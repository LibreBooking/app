var scheduleSpecificDates = [];

function Schedule(opts, resourceGroups) {
    var options = opts;
    var groupDiv = $('#resourceGroups');
    var scheduleId = $('#scheduleId');
    var multidateselect = $('#multidateselect');

    this.init = function () {
        this.initUserDefaultSchedule();
        this.initRotateSchedule();
        this.initResourceFilter();
        renderEvents();
        this.initResources();
        this.initNavigation();

        var today = $(".today");
        if (today && today.length > 0) {
            $('html, body').animate({
                scrollTop: today.offset().top - 50
            }, 500);
        }

        $(window).on('resize', _.debounce(function () {
            let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
            if (!isMobile) {
                renderEvents(true);
            }
        }, 1000));

        setInterval(function () {
            renderEvents(true);
        }, 300000);
    };


    function renderEvents(clear = false) {
        $("#loading-schedule").removeClass("no-show");

        if (clear) {
            $("#reservations").find("div.event, div.condensed-event").remove();
        }

        function attachReservationEvents(div, reservation) {
            var reservations = $('#reservations');
            var resid = reservation.ReferenceNumber;
            var pattern = 'div.reserved[data-resid="' + resid + '"]';

            div.click(function (e) {
                var reservationUrl = options.reservationUrlTemplate.replace("[referenceNumber]", resid);
                window.location = reservationUrl;
            });

            if (opts.isMobileView) {
                return;
            }

            div.hover(function (e) {
                $(pattern, reservations).addClass('hilite');
            }, function (e) {
                $(pattern, reservations).removeClass('hilite');
            });

            var qTipElement = div;

            qTipElement.qtip({
                position: {
                    my: 'bottom left', at: 'top left', effect: false, viewport: $(window)
                },

                content: {
                    text: function (event, api) {
                        $.ajax({url: options.summaryPopupUrl, data: {id: resid}})
                            .done(function (html) {
                                api.set('content.text', html);
                            })
                            .fail(function (xhr, status, error) {
                                api.set('content.text', status + ': ' + error);
                            });

                        return 'Loading...';
                    }
                },

                show: {
                    delay: 700, effect: false,
                },

                hide: {
                    fixed: true, delay: 500
                },

                style: {
                    classes: 'qtip-light qtip-bootstrap'
                }
            });
        }

        function findClosestStart(tds, reservation) {
            let startTd = null;

            tds.each((i, v) => {
                const td = $(v);
                let tdMin = Number.parseInt(td.data('min'));
                let resStart = Number.parseInt(reservation.StartDate);

                if (tdMin <= resStart) {
                    startTd = td;
                }
            });

            if (!startTd) {
                startTd = tds.first();
            }

            return startTd;
        }

        function findClosestEnd(tds, reservation) {
            let endTd = null;

            tds.each((i, v) => {
                const td = $(v);
                let tdMin = Number.parseInt(td.data('min'));
                let resEnd = Number.parseInt(reservation.EndDate);

                if (tdMin <= resEnd) {
                    endTd = td;
                }
            });

            if (!endTd) {
                endTd = tds.last();
            }

            return endTd;
        }

        ajaxPost($("#fetchReservationsForm"), options.reservationLoadUrl, null, function (reservationList) {
            const ScheduleStandard = "0";
            const ScheduleWide = "1";
            const ScheduleTall = "2";
            const ScheduleCondensed = "3";

            reservationList.forEach(res => {
                $('#reservations').find(".reservations").each(function () {
                    const t = $(this);
                    const tableMin = Number.parseInt(t.data("min"));
                    const tableMax = Number.parseInt(t.data("max"));

                    const rendersWithin = ((res.StartDate >= tableMin && res.StartDate < tableMax) || (res.EndDate > tableMin && res.EndDate <= tableMax) || (res.StartDate <= tableMin && res.EndDate >= tableMax));

                    if (!rendersWithin) {
                        return;
                    }

                    const className = res.IsReservation ? "reserved" : "unreservable";
                    const mine = res.IsOwner ? "mine" : "";
                    const participant = res.IsParticipant ? "participating" : "";
                    const past = res.IsPast ? "past" : "";
                    const isNew = res.IsNew ? `<span class="reservation-new">${opts.newLabel}</span>` : "";
                    const isUpdated = res.IsUpdated ? `<span class="reservation-updated">${opts.updatedLabel}</span>` : "";
                    const isPending = res.IsPending ? "pending" : "";
                    const isDraggable = res.IsOwner && res.IsReservation && !res.IsPast;
                    const draggableAttribute = isDraggable ? 'draggable="true"' : "";
                    const color = res.BorderColor !== "" ? `border-color:${res.BorderColor};background-color:${res.BackgroundColor};color:${res.TextColor};` : "";

                    if (opts.scheduleStyle === ScheduleCondensed || (opts.isMobileView === "1" && opts.scheduleStyle === ScheduleStandard)) {
                        if (Number.parseInt(t.data("resourceid")) !== Number.parseInt(res.ResourceId)) {
                            return;
                        }
                        const startsBefore = res.StartDate < tableMin;
                        const endsAfter = res.EndDate > tableMax;
                        let startTime = startsBefore ? opts.midnightLabel : res.StartTime;
                        let endTime = endsAfter ? opts.midnightLabel : res.EndTime;
                        const div = $(`<div 
                                    class="${className} ${mine} ${past} ${participant} ${isPending} condensed-event" 
                                    style="${color}"
                                    data-resid="${res.ReferenceNumber}">
                                    <span>${startTime}-${endTime}</span>
                                    ${isNew} ${isUpdated} ${res.Label}</div>`);

                        t.append(div);
                        if (res.IsReservation) {
                            attachReservationEvents(div, res);
                        }
                        return;
                    }

                    let startTd = t.find('td[data-resourceid="' + res.ResourceId + '"][data-min="' + res.StartDate + '"]:first');
                    let endTd = t.find('td[data-resourceid="' + res.ResourceId + '"][data-min="' + res.EndDate + '"]:first');
                    let calculatedAdjustment = 0;

                    if (startTd.length === 0) {
                        startTd = findClosestStart(t.find('td[data-resourceid="' + res.ResourceId + '"]'), res);
                    }
                    if (endTd.length === 0) {
                        endTd = findClosestEnd(t.find('td[data-resourceid="' + res.ResourceId + '"]'), res);
                        calculatedAdjustment = endTd.outerWidth();
                    }
                    if (startTd.length === 0 || endTd.length === 0) {
                        // does not fit in this reservation table
                        return;
                    }


                    let numberOfConflicts = 0;
                    let conflictIds = [];

                    t.find(`div.event[data-resourceid="${res.ResourceId}"]`).each((i, div) => {
                        if ($(div).hasClass('unreservable')) {
                            return false;
                        }
                        let divMin = Number.parseInt($(div).data('start'));
                        let divMax = Number.parseInt($(div).data('end'));
                        let resStart = Number.parseInt(res.StartDate);
                        let resEnd = Number.parseInt(res.EndDate);


                        const overlaps = resStart <= divMin && resEnd >= divMax;
                        const conflictsStart = resStart >= divMin && resStart < divMax;
                        const conflictsEnd = resEnd > divMin && resEnd <= divMax;

                        if (overlaps || conflictsStart || conflictsEnd) {
                            numberOfConflicts++;
                            if (!conflictIds.includes(res.ReferenceNumber)) {
                                conflictIds.push(res.ReferenceNumber);
                            }
                            if (!conflictIds.includes($(div).data('resid'))) {
                                conflictIds.push($(div).data('resid'));
                            }
                        }
                    });

                    let width = 0;
                    let height = 0;
                    let top = startTd.position().top;
                    let left = startTd.position().left
                    if (opts.scheduleStyle === ScheduleTall) {
                        width = startTd.outerWidth();
                        height = endTd.position().top - startTd.position().top;
                    } else {
                        height = 40;
                        width = endTd.position().left - startTd.position().left + calculatedAdjustment;
                        top = startTd.position().top + (40 * numberOfConflicts);
                        if (numberOfConflicts > 0) {
                            startTd.css('height', 40 * (numberOfConflicts + 1) + "px");
                            height = 40;
                        }
                    }

                    const style = `left:${left}px; top:${top}px; width:${width}px; height:${height}px;`;
                    const div = $(`<div 
                                    class="${className} ${mine} ${past} ${participant} ${isPending} event" 
                                    style="${style} ${color}"
                                    data-resid="${res.ReferenceNumber}"
                                    data-resourceid="${res.ResourceId}"
                                    data-start="${startTd.data('min')}"
                                    data-end="${endTd.data('min')}"
                                    ${draggableAttribute}>${isNew} ${isUpdated} ${res.Label}</div>`);

                    if (res.IsReservation) {
                        attachReservationEvents(div, res);
                    }

                    t.append(div);

                    if (conflictIds.length > 0 && opts.scheduleStyle === ScheduleTall) {
                        console.log(conflictIds)
                        width = startTd.outerWidth() / conflictIds.length;
                        conflictIds.forEach((conflict, index) => {
                            left = startTd.position().left + (width * index);
                            console.log(index, conflict, left, startTd.position().left);
                            const div = t.find(`[data-resid="${conflict}"]`);
                            div.css('width', width + "px");
                            div.css('left', left + "px");
                        })
                    }

                    if (isDraggable) {
                        div.on('dragstart', function (event) {
                            div.qtip("hide");
                            $(event.target).removeClass('clicked');
                            const data = JSON.stringify({
                                referenceNumber: res.ReferenceNumber, resourceId: res.ResourceId
                            });
                            event.originalEvent.dataTransfer.setData("text", data);
                        });
                    }
                });
            });

            if (options.isReservable) {
                initReservable();
            }

            $("#loading-schedule").addClass("no-show");
        });
    }

    this.renderEvents = renderEvents;

    this.initResources = function () {
        $('.resourceNameSelector').each(function () {
            $(this).bindResourceDetails($(this).attr('resourceId'));
        });
    };

    this.initNavigation = function () {
        var datePicker = $("#datepicker");
        var expandCalendar = readCookie('schedule_calendar_toggle');

        function collapse() {
            createCookie('schedule_calendar_toggle', false, 30, opts.scriptUrl);
            datePicker.hide();
            $('#individualDates').hide();
        }

        function expand() {
            createCookie('schedule_calendar_toggle', true, 30, opts.scriptUrl);
            datePicker.show();
            $('#individualDates').show();
        }

        if (expandCalendar == "true") {
            expand();
        } else {
            collapse();
        }

        $("#calendar_toggle").click(function (event) {
            event.preventDefault();

            if (datePicker.css("display") == "none") {
                expand();
            } else {
                collapse();
            }
        });

        function CheckMultiDateSelect() {
            $('#individualDatesList').empty().show();
            $('.schedule_dates').hide();
        }

        multidateselect.click(function (e) {
            if (multidateselect.is(':checked')) {
                CheckMultiDateSelect();
            } else {
                $('#individualDatesList').empty().hide();
                $('.schedule_dates').show();
            }
        });

        $('#individualDatesList').on('click', '.removeSpecificDate', function () {
            var dateDiv = $(this).closest('div');
            var dateText = dateDiv.data('date');
            var index = scheduleSpecificDates.indexOf(dateText);
            scheduleSpecificDates.splice(index, 1);
            $('#individualDatesList').find('div[data-date="' + dateText + '"]').remove();

            if (scheduleSpecificDates.length == 0) {
                $('#individualDatesGo').hide();
                $('#individualDatesGo').click();
            }
        });

        $('#individualDatesGo').click(function (e) {
            e.preventDefault();

            if (multidateselect.is(':checked')) {
                var dates = scheduleSpecificDates.join(',');
                RedirectToSelf('sds', /(sds=[\d\-\,]*)/i, 'sds=' + dates);
            } else {
                RedirectToSelf('sds', /(sds=[\d\-\,]*)/i, '');
            }
        });

        if (options.specificDates.length > 0) {
            CheckMultiDateSelect();

            multidateselect.attr('checked', true);
            $.each(options.specificDates, function (i, v) {
                var d = v.split('-');
                AddSpecificDate(v, {selectedYear: d[0], selectedMonth: d[1] - 1, selectedDay: d[2]});
            });
        }

        $('#schedules').on('change', function (e) {
            // e.preventDefault();
            var scheduleId = $(this).val();

            RedirectToSelf("sid", /sid=\d+/i, "sid=" + scheduleId, function (url) {
                var x = RemoveGroupId(url);
                x = RemoveResourceId(x);
                return x;
            });
        });

        $('.schedule-dates, .alert').find('.change-date').on('click', function (e) {
            e.preventDefault();
            var year = $(this).attr('data-year');
            var month = $(this).attr('data-month');
            var day = $(this).attr('data-day');
            ChangeDate(year, month, day);
        });
    };

    this.initUserDefaultSchedule = function (anonymous) {
        var makeDefaultButton = $('#make_default');
        if (anonymous) {
            makeDefaultButton.hide();
            return;
        }

        makeDefaultButton.show();

        var defaultSetMessage = $('#defaultSetMessage');
        makeDefaultButton.click(function (e) {
            e.preventDefault();
            var scheduleId = $('#scheduleId').val();
            var changeDefaultUrl = options.setDefaultScheduleUrl.replace("[scheduleId]", scheduleId);


            $.ajax({
                url: changeDefaultUrl, success: function (data) {
                    defaultSetMessage.show().delay(5000).fadeOut();
                }
            });
        });
    };

    this.initRotateSchedule = function () {
        $('#schedule-actions .schedule-style').click(function (e) {
            e.preventDefault();
            createCookie(opts.cookieName, $(this).attr('schedule-display'), 30, opts.scriptUrl);
            window.location.reload();
        });
    };

    this.toggleResourceFilter = function () {

        var shown = false;

        function hide() {
            shown = false;
            $('#reservations-left').addClass('hidden');
            $('#reservations').removeClass('col-md-10').addClass('col-md-12');
            $('#restore-sidebar').removeClass('hidden');

            localStorage.setItem('hide-sidebar-status', true);
        }

        function show() {
            shown = true;
            $('#reservations-left').removeClass('hidden');
            $('#reservations').addClass('col-md-10').removeClass('col-md-12');
            $('#restore-sidebar').addClass('hidden');

            localStorage.removeItem('hide-sidebar-status');
        }

        function toggle() {
            if (shown) {
                hide();
            } else {
                show();
            }

            renderEvents(true);
        }

        $('.toggle-sidebar').on('click', function (e) {
            e.preventDefault();
            toggle();
        });

        var hideSidebar = localStorage.getItem('hide-sidebar-status');
        show();
        if (hideSidebar) {
            hide();
        }
    };

    function initReservable() {
        let selectingTds = false;
        const reservations = $('#reservations');

        function openReservation(startTd, endTd) {
            let sd = '';
            let ed = '';

            const start = startTd.data('start');
            if (start) {
                sd = start;
            }
            const end = endTd.data('end');
            if (end) {
                ed = end;
            }

            const link = startTd.data('href');
            window.location = link + "&sd=" + sd + "&ed=" + ed;
        }

        if (options.disableSelectable != '1') {
            let firstTd;
            let lastTd;
            let tds = [];

            function isSequentialReservation(td) {
                const resourceId = td.data('resourceid');
                const firstMinTime = Number.parseInt(firstTd.data("min"));
                const minTime = Number.parseInt(td.data('min'));
                const lastResourceId = lastTd.data('resourceid');
                const lastMinTime = Number.parseInt(lastTd.data('min'));
                const isSequential = resourceId === lastResourceId && minTime > firstMinTime && minTime > lastMinTime;
                return isSequential;
            }

            function add(td) {
                tds.push(td);
            }

            function removeIfNonSequential(td) {
                tds.forEach(i => {
                    if (Number.parseInt(i.data("min")) > Number.parseInt(td.data("min")) || i.data("resourceid") !== firstTd.data("resourceid")) {
                        i.removeClass("hilite")
                    }
                });
                tds = tds.filter(i => Number.parseInt(i.data("min")) <= Number.parseInt(td.data("min")));
            }

            reservations.on("mousedown", "td.reservable", e => {
                selectingTds = true;
                firstTd = $(e.target);
                lastTd = $(e.target);
                add(firstTd);
                return false;
            });

            reservations.on("mouseenter", "td.reservable", e => {
                let td = $(e.target);
                td.addClass("hilite");
                td.siblings('.resourcename').toggleClass('hilite');

                if (selectingTds) {
                    removeIfNonSequential(td);
                    if (isSequentialReservation(td)) {
                        add(td);
                    }
                    lastTd = td;
                    e.stopPropagation();
                    return false;
                }
            });

            reservations.on("mouseleave", "td.reservable", e => {
                let td = $(e.target);

                td.siblings('.resourcename').removeClass('hilite');
                if (selectingTds && tds.find(i => i.data("ref") === td.data("ref")) !== undefined) {
                    e.stopPropagation();
                } else {
                    td.removeClass("hilite");
                }
            });

            reservations.on("mouseup", "td.reservable", e => {
                if (selectingTds) {
                    e.stopPropagation();
                    if (Number.parseInt(firstTd.data("min")) < Number.parseInt(lastTd.data("min")) && firstTd.data("resourceid") === lastTd.data("resourceid")) {
                        openReservation(firstTd, lastTd);
                    } else {
                        reservations.find("td.hilite, td.clicked").each((i, e) => $(e).removeClass("hilite clicked"));
                    }
                }
                selectingTds = false;
            });

            reservations.find("td.reservable").on("selectstart", e => {
                return false;
            });

            makeReservationsMoveable(reservations);
        }

        /**
         reservations.delegate('.clickres:not(.reserved)', 'mouseenter', function () {
            if (selectingTds) {
                return;
            }
            $(this).siblings('.resourcename').toggleClass('hilite');
            var ref = $(this).attr('ref');
            reservations.find('td[ref="' + ref + '"]').addClass('hilite');
        });

         reservations.delegate('.clickres:not(.reserved)', 'mouseleave', function () {
            if (selectingTds) {
                return;
            }

            $(this).siblings('.resourcename').removeClass('hilite');
            var ref = $(this).attr('ref');
            reservations.find('td[ref="' + ref + '"]').removeClass('hilite');
            $(this).removeClass('hilite');
        });
         */

        reservations.delegate('.clickres', 'mousedown', function (e) {
            $(e.target).addClass('clicked');
        });

        reservations.delegate('.clickres', 'mouseup', function (e) {
            $(e.target).removeClass('clicked');
        });

        reservations.delegate('.reservable', 'click', function (e) {
            console.log("clicked");
            openReservation($(e.target), $(e.target));
        });
    }

    this.initReservable = initReservable;

    function makeReservationsMoveable(reservations) {
        reservations.find('td.reservable').on('dragover dragleave drop', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const data = JSON.parse(event.originalEvent.dataTransfer.getData("text"));
            var referenceNumber = data.referenceNumber;
            var sourceResourceId = data.resourceId;

            var targetSlot = $(event.target);

            if (event.type == 'dragover') {
                $(event.target).addClass('hilite');
            } else if (event.type == 'dragleave') {
                $(event.target).removeClass('hilite');
            } else if (event.type === 'drop') {
                var droppedCell = $(event.target);
                droppedCell.addClass('dropped');
                droppedCell.html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');

                var targetResourceId = targetSlot.attr('data-resourceId');
                var startDate = decodeURIComponent(targetSlot.attr('data-start'));
                $('#moveStartDate').val(startDate);
                $('#moveReferenceNumber').val(referenceNumber);
                $('#moveResourceId').val(targetResourceId);
                $('#moveSourceResourceId').val(sourceResourceId);

                ajaxPost($('#moveReservationForm'), options.updateReservationUrl, null, function (updateResult) {
                    if (updateResult.success) {
                        document.location.reload();
                    } else {
                        droppedCell.removeClass('dropped');
                        droppedCell.html('');

                        return false;
                    }
                });
            }
        });
    }

    this.initResourceFilter = function () {

        $('#advancedFilter').attr('action', opts.filterUrl);

        $('#show_all_resources').click(function (e) {
            e.preventDefault();

            groupDiv.tree('selectNode', null);

            $('#clearFilter').val('1');
            $('#resettable').find('input, select').val('');
            $(this).closest('form').submit();
        });

        groupDiv.tree({
            data: resourceGroups, saveState: 'tree' + options.scheduleId,

            onCreateLi: function (node, $li) {
                var span = $li.find('span');
                var itemName = span.text();
                var label = $('<label><input type="checkbox" name="resourceId[]"/> ' + itemName + '</label>');

                var checkbox = label.find('input');

                if (node.type == 'resource') {
                    checkbox.attr('resource-id', node.resource_id);
                    checkbox.attr('group-id', node.group_id);
                    checkbox.val(node.resource_id);
                    if (opts.selectedResources.indexOf(parseInt(node.resource_id)) !== -1) {
                        checkbox.attr('checked', true);
                        groupDiv.tree("openNode", node.parent);
                    }
                    $li.find('span').html(label);
                }
            }
        });

        groupDiv.bind('tree.click', function (event) {
            if (event.node) {
                var node = event.node;
                if (node.type != 'resource') {
                    $('#resourceGroups').find(':checkbox').attr('checked', false);
                    ChangeGroup(node);
                }
            }
        });

        this.toggleResourceFilter();
    };
}

function RemoveResourceId(url) {
    if (!url) {
        url = window.location.href;
    }
    return url.replace(/&*rid[]=\d+/i, "");
}

function RemoveGroupId(url) {
    return url.replace(/&*gid=\d+/i, "");
}

function ChangeGroup(node) {
    var groupId = node.id;
    var $resourceGroups = $('#resourceGroups');

    $resourceGroups.find('input[group-id="' + groupId + '"]').click();

    _.each(node.children, function (i) {
        if (i.type == 'group') {
            ChangeGroup(i);
        }
    });
}

function AddSpecificDate(dateText, inst) {
    var formattedDate = inst.selectedYear + '-' + (inst.selectedMonth + 1) + '-' + inst.selectedDay;
    if (scheduleSpecificDates.indexOf(formattedDate) != -1) {
        return;
    }
    $('#individualDatesGo').show();
    scheduleSpecificDates.push(formattedDate);
    var dateItem = '<div data-date="' + formattedDate + '">' + dateText + ' <i class="fa fa-remove icon remove removeSpecificDate"><i/><div>';

    $('#individualDatesList').html($('#individualDatesList').html() + dateItem);
}

function dpDateChanged(dateText, inst) {
    if ($('#multidateselect').is(':checked')) {
        AddSpecificDate(dateText, inst);
    } else {

        if (inst) {
            ChangeDate(inst.selectedYear, inst.selectedMonth + 1, inst.selectedDay);
        } else {
            var date = new Date();
            ChangeDate(date.getFullYear(), date.getMonth() + 1, date.getDate());
        }
    }
}

function ChangeDate(year, month, day) {
    RedirectToSelf("sd", /sd=\d{4}-\d{1,2}-\d{1,2}/i, "sd=" + year + "-" + month + "-" + day);
}

function RedirectToSelf(queryStringParam, regexMatch, substitution, preProcess) {
    var url = window.location.href;
    var newUrl = window.location.href;

    if (preProcess) {
        newUrl = preProcess(url);
        newUrl = newUrl.replace(/&{2,}/i, "");
    }

    if (newUrl.indexOf(queryStringParam + "=") != -1) {
        newUrl = newUrl.replace(regexMatch, substitution);
    } else if (newUrl.indexOf("?") != -1) {
        newUrl = newUrl + "&" + substitution;
    } else {
        newUrl = newUrl + "?" + substitution;
    }

    newUrl = newUrl.replace("#", "");

    window.location = newUrl;
}