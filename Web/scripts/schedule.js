var scheduleSpecificDates = [];

function Schedule(opts, resourceGroups) {
	var options = opts;
	var groupDiv = $('#resourceGroups');
	var scheduleId = $('#scheduleId');
	var multidateselect = $('#multidateselect');

	this.init = function () {
		this.initUserDefaultSchedule();
		this.initRotateSchedule();
		this.initReservations();
		this.initResourceFilter();

		var reservations = $('#reservations');

		reservations.delegate('.clickres:not(.reserved)', 'mouseenter', function () {
			$(this).siblings('.resourcename').toggleClass('hilite');
			var ref = $(this).attr('ref');
			reservations.find('td[ref="' + ref + '"]').addClass('hilite');
		});

		reservations.delegate('.clickres:not(.reserved)', 'mouseleave', function () {
			$(this).siblings('.resourcename').removeClass('hilite');
			var ref = $(this).attr('ref');
			reservations.find('td[ref="' + ref + '"]').removeClass('hilite');
			$(this).removeClass('hilite');
		});

		reservations.delegate('.clickres', 'mousedown', function () {
			$(this).addClass('clicked');
		});

		reservations.delegate('.clickres', 'mouseup', function () {
			$(this).removeClass('clicked');
		});

		reservations.delegate('.reservable', 'click', function () {
			var sd = '';
			var ed = '';

			var start = $(this).attr('data-start');
			if (start)
			{
				sd = start;
			}
			var end = $(this).attr('data-end');
			if (end)
			{
				ed = end;
			}

			var link = $(this).attr('data-href');
			window.location = link + "&sd=" + sd + "&ed=" + ed;
		});

		// var isOldIE = (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0);
		// if (opts.lockTableHead && !isOldIE)
		// {
		// 	{
		// 		var reservationTables = reservations.find('table.reservations');
		// 		reservationTables.floatThead({
		// 			position: 'auto', top: 50, zIndex: 998
		// 		});
		//
		// 		var onPrinting = function () {
		// 			reservationTables.floatThead('destroy');
		// 		};
		//
		// 		var onScreen = function () {
		// 			reservationTables.floatThead({
		// 				position: 'auto', top: 50, zIndex: 998
		// 			});
		// 		};
		//
		// 		//WebKit print detection
		// 		if (window.matchMedia)
		// 		{
		// 			var mediaQueryList = window.matchMedia('print');
		// 			mediaQueryList.addListener(function (mql) {
		// 				if (mql.matches)
		// 				{
		// 					onPrinting();
		// 				}
		// 				else
		// 				{
		// 					onScreen();
		// 				}
		// 			});
		// 		}
		//
		// 		//IE print detection
		// 		window.onbeforeprint = onPrinting;
		// 		window.onafterprint = onScreen;
		//
		// 		onScreen();
		// 	}
		// }

		this.initResources();
		this.initNavigation();

		var today = $(".today");
		if (today && today.length > 0)
		{
			$('html, body').animate({
				scrollTop: today.offset().top - 50
			}, 500);
		}
	};

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

		if (expandCalendar == "true")
		{
			expand();
		}
		else
		{
			collapse();
		}

		$("#calendar_toggle").click(function (event) {
			event.preventDefault();

			if (datePicker.css("display") == "none")
			{
				expand();
			}
			else
			{
				collapse();
			}
		});

		function CheckMultiDateSelect() {
			$('#individualDatesList').empty().show();
			$('.schedule_dates').hide();
		}

		multidateselect.click(function (e) {
			if (multidateselect.is(':checked'))
			{
				CheckMultiDateSelect();
			}
			else
			{
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

			if (scheduleSpecificDates.length == 0)
			{
				$('#individualDatesGo').hide();
				$('#individualDatesGo').click();
			}
		});

		$('#individualDatesGo').click(function (e) {
			e.preventDefault();

			if (multidateselect.is(':checked'))
			{
				var dates = scheduleSpecificDates.join(',');
				RedirectToSelf('sds', /(sds=[\d\-\,]*)/i, 'sds=' + dates);
			}
			else
			{
				RedirectToSelf('sds', /(sds=[\d\-\,]*)/i, '');
			}
		});

		if (options.specificDates.length > 0)
		{
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
		if (anonymous)
		{
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
			if (shown)
			{
				hide();
			}
			else
			{
				show();
			}
		}

		$('.toggle-sidebar').on('click', function () {
			toggle();
		});

		var hideSidebar = localStorage.getItem('hide-sidebar-status');
		show();
		if (hideSidebar)
		{
			hide();
		}
	};

	this.initReservations = function () {
		var reservations = $('#reservations');

		if (options.disableSelectable != '1') {
            this.makeSlotsSelectable(reservations);
            this.makeReservationsMoveable(reservations);
        }

		$('.reserved', reservations).each(function () {
			var resid = $(this).attr('resid');
			var pattern = 'td[resid="' + resid + '"]';

			$(this).hover(function () {
				$(pattern, reservations).addClass('hilite');
			}, function () {
				$(pattern, reservations).removeClass('hilite');
			});

			$(this).click(function (e) {
				e.stopPropagation();
				var reservationUrl = options.reservationUrlTemplate.replace("[referenceNumber]", resid);
				window.location = reservationUrl;
			});

			var qTipElement = $(this);

			if ($(this).is('div'))
			{
				var fa = $(this).find('.fa');
				if (fa.length > 0)
				{
					qTipElement = $(this).find('.fa');

					qTipElement.click(function (e) {
						e.stopPropagation();
					});
				}
			}

			qTipElement.qtip({
				position: {
					my: 'bottom left', at: 'top left', effect: false,
					viewport: $(window)
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
					delay: 700, effect: false
				},

				hide: {
					fixed: true, delay: 500
				},

				style: {
					classes: 'qtip-light qtip-bootstrap'
				}
			});
		});
	};

	this.makeSlotsSelectable = function (reservationsElement) {
		var startHref = '';
		var startDate = '';
		var endDate = '';
		var href = '';
		var select = function (element) {
			href = element.attr('data-href');
			if (startHref == '')
			{
				startDate = element.attr('data-start');
				startHref = href;
			}
			endDate = element.attr('data-end');
		};

		reservationsElement.selectable({
			filter: 'td.reservable',
			cancel: 'td.reserved',
			distance: 20,
			start: function (event, ui) {
				startHref = '';
			}, selecting: function (event, ui) {
				select($(ui.selecting));
			}, unselecting: function (event, ui) {
				select($(ui.unselecting));
			}, stop: function (event, ui) {
				if (href != '' && startDate != '' && endDate != '')
				{
					var start = moment(decodeURIComponent(startDate));
					var end = moment(decodeURIComponent(endDate));

					// the user dragged right to left
					if (end < start)
					{
						window.location = href + "&sd=" + endDate + "&ed=" + startDate;
					}
					else
					{
						window.location = href + "&sd=" + startDate + "&ed=" + endDate;
					}
				}
			}
		});
	};

	this.makeReservationsMoveable = function (reservations) {
		var sourceResourceId = null;
		var referenceNumber = null;

		reservations.find('td[draggable="true"]').on('dragstart', function (event) {
			$(event.target).removeClass('clicked');
			referenceNumber = $(event.target).attr('resid');
			sourceResourceId = $(event.target).attr('data-resourceId');

			event.originalEvent.dataTransfer.setData("text", event.target.id);
		});

		reservations.find('td.reservable').on('dragover dragleave drop', function (event) {
			event.preventDefault();

			var targetSlot = $(event.target);

			if (event.type == 'dragover')
			{
				$(event.target).addClass('hilite');
			}
			else if (event.type == 'dragleave')
			{
				$(event.target).removeClass('hilite');
			}
			else if (event.type === 'drop')
			{
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
					if (updateResult.success)
					{
						document.location.reload();
					}
					else
					{
                        droppedCell.removeClass('dropped');
                        droppedCell.html('');

                        return false;
					}
				});
			}
		});
	};

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

				if (node.type == 'resource')
				{
					checkbox.attr('resource-id', node.resource_id);
					checkbox.attr('group-id', node.group_id);
					checkbox.val(node.resource_id);
					if (opts.selectedResources.indexOf(parseInt(node.resource_id)) !== -1)
					{
						checkbox.attr('checked', true);
						groupDiv.tree("openNode", node.parent);
					}
					$li.find('span').html(label);
				}
			}
		});

		groupDiv.bind('tree.click', function (event) {
			if (event.node)
			{
				var node = event.node;
				if (node.type != 'resource')
				{
					$('#resourceGroups').find(':checkbox').attr('checked', false);
					ChangeGroup(node);
				}
			}
		});

		this.toggleResourceFilter();
	};
}

function RemoveResourceId(url) {
	if (!url)
	{
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

	_.each(node.children, function(i) {
		if (i.type == 'group')
		{
			ChangeGroup(i);
		}
	});
}

function AddSpecificDate(dateText, inst) {
	var formattedDate = inst.selectedYear + '-' + (inst.selectedMonth + 1) + '-' + inst.selectedDay;
	if (scheduleSpecificDates.indexOf(formattedDate) != -1)
	{
		return;
	}
	$('#individualDatesGo').show();
	scheduleSpecificDates.push(formattedDate);
	var dateItem = '<div data-date="' + formattedDate + '">' + dateText + ' <i class="fa fa-remove icon remove removeSpecificDate"><i/><div>';

	$('#individualDatesList').html($('#individualDatesList').html() + dateItem);
}

function dpDateChanged(dateText, inst) {
	if ($('#multidateselect').is(':checked'))
	{
		AddSpecificDate(dateText, inst);
	}
	else
	{

		if (inst)
		{
			ChangeDate(inst.selectedYear, inst.selectedMonth + 1, inst.selectedDay);
		}
		else
		{
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

	if (preProcess)
	{
		newUrl = preProcess(url);
		newUrl = newUrl.replace(/&{2,}/i, "");
	}

	if (newUrl.indexOf(queryStringParam + "=") != -1)
	{
		newUrl = newUrl.replace(regexMatch, substitution);
	}
	else if (newUrl.indexOf("?") != -1)
	{
		newUrl = newUrl + "&" + substitution;
	}
	else
	{
		newUrl = newUrl + "?" + substitution;
	}

	newUrl = newUrl.replace("#", "");

	window.location = newUrl;
}