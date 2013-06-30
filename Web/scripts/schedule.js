function Schedule(opts)
{
	var options = opts;

	this.init = function ()
	{
		this.initUserDefaultSchedule();
		this.initRotateSchedule();
		this.initReservations();
		this.initResourceGroups();

		var reservations = $('#reservations');
		reservations.delegate('.clickres:not(.reserved)', 'hover', function ()
		{
			$(this).siblings('.resourcename').toggleClass('hilite');
			var ref = $(this).attr('ref');
			reservations.find('td[ref="' + ref + '"]').toggleClass('hilite');
		});

		reservations.delegate('td.clickres', 'mousedown', function ()
		{
			$(this).addClass('clicked');
		});

		reservations.delegate('td.clickres', 'mouseup', function ()
		{
			$(this).removeClass('clicked');
		});

		reservations.delegate('.reservable', 'click', function ()
		{
			var start = $('.start', this).val();
			var end = $('.end', this).val();
			var link = $('.href', this).val();
			window.location = link + "&sd=" + start + "&ed=" + end;
		});

		this.initResources();
		this.initNavigation();
	};

	this.initResources = function ()
	{
		$('.resourceNameSelector').each(function ()
		{
			$(this).bindResourceDetails($(this).attr('resourceId'));
		});
	};

	this.initNavigation = function ()
	{
		$('.schedule_drop').hover(
				function ()
				{
					$("#schedule_list").show()
				},
				function ()
				{
					$("#schedule_list").hide()
				}
		);

		$("#calendar_toggle").click(function (event)
		{
			event.preventDefault();

			var datePicker = $("#datepicker");
			datePicker.toggle();

			if (datePicker.css("display") == "none")
			{
				$(this).find("img").first().attr("src", "img/calendar.png");
			}
			else
			{
				$(this).find("img").first().attr("src", "img/calendar-minus.png");
			}
		});
	};

	this.initUserDefaultSchedule = function ()
	{
		var makeDefaultButton = $('#make_default');
		makeDefaultButton.show();

		var defaultSetMessage = $('#defaultSetMessage');
		makeDefaultButton.click(function (e)
		{
			e.preventDefault();
			var scheduleId = $('#scheduleId').val();
			var changeDefaultUrl = options.setDefaultScheduleUrl.replace("[scheduleId]", scheduleId);
			$.ajax({
				url: changeDefaultUrl,
				success: function (data)
				{
					defaultSetMessage.show().delay(5000).fadeOut();
				}
			});

		});
	};

	this.initRotateSchedule = function ()
	{
		$('#rotate_schedule').click(function (e)
		{
			e.preventDefault();
			createCookie(opts.cookieName, opts.cookieValue, 30);
			window.location.reload();
		});
	};

	this.initReservations = function ()
	{
		var reservations = $('#reservations');

		this.makeSlotsSelectable(reservations);

		$('td.reserved', reservations).each(function ()
		{
			var resid = $(this).attr('resid');
			var pattern = 'td[resid="' + resid + '"]';

			$(this).hover(
					function ()
					{
						$(pattern, reservations).addClass('hilite');
					},
					function ()
					{
						$(pattern, reservations).removeClass('hilite');
					}
			);

			$(this).click(function ()
			{
				var reservationUrl = options.reservationUrlTemplate.replace("[referenceNumber]", resid);
				window.location = reservationUrl;
			});

			$(this).qtip({
				position: {
					my: 'bottom left',
					at: 'top left',
					viewport: $(window),
					effect: false
				},
				content: {
					text: 'Loading...',
					ajax: {
						url: options.summaryPopupUrl,
						type: 'GET',
						data: { id: resid },
						dataType: 'html'
					}
				},
				show: {
					delay: 700,
					event: 'mouseenter'
				},
				style: {
				},
				hide: {
					fixed: true
				},
				overwrite: false
			});
		});
	};

	this.makeSlotsSelectable = function (reservationsElement)
	{
		var startHref = '';
		var startDate = '';
		var endDate = '';
		var href = '';
		var select = function (element)
		{
			href = element.find('.href').val();
			if (startHref == '')
			{
				startDate = element.find('.start').val();
				startHref = href;
			}
			console.log('Selecting ' + href);
			if (href != startHref)
			{
				element.removeClass('ui-selecting');
			}
			else
			{
				endDate = element.find('.end').val();
			}
		};

		reservationsElement.selectable({
			filter: 'td.reservable',
			distance: 20,
			start: function (event, ui)
			{
				startHref = '';
			},
			selecting: function (event, ui)
			{
				select($(ui.selecting));
			},
			unselecting: function (event, ui)
			{
				select($(ui.unselecting));
			},
			stop: function (event, ui)
			{
				if (href != '' && startDate != '' && endDate != '')
				{
					window.location = href + "&sd=" + startDate + "&ed=" + endDate;
					console.log('Start:' + startDate + ' end:' + endDate);
				}
			}
		});
	}

	this.initResourceGroups = function()
	{
		$('#show_all_resources').click(function(e)
		{
			e.preventDefault();
			ShowAllResources();
		});
	};

	function ShowAllResources()
	{
		RedirectToSelf("", "", "", function (url)
		{
			var x = RemoveGroupId(url);
			return RemoveResourceId(x);
		})
	}
}

function dpDateChanged(dateText, inst)
{
	ChangeDate(inst.selectedYear, inst.selectedMonth + 1, inst.selectedDay);
}

function ChangeDate(year, month, day)
{
	RedirectToSelf("sd", /sd=\d{4}-\d{1,2}-\d{1,2}/i, "sd=" + year + "-" + month + "-" + day);
}

function ChangeSchedule(scheduleId)
{
	RedirectToSelf("sid", /sid=\d+/i, "sid=" + scheduleId);
}

function RemoveResourceId(url)
{
	return url.replace(/&*rid=\d+/i, "");
}

function RemoveGroupId(url)
{
	return url.replace(/&*gid=\d+/i, "");
}
function ChangeGroup(groupId)
{
	RedirectToSelf('gid', /gid=\d+/i, "gid=" + groupId, RemoveResourceId);
}

function ChangeResource(resourceId)
{
	RedirectToSelf('rid', /rid=\d+/i, "rid=" + resourceId, RemoveGroupId);
}

function RedirectToSelf(queryStringParam, regexMatch, substitution, preProcess)
{
	var url = window.location.href;
	var newUrl = window.location.href;

	if (preProcess)
	{
		newUrl = preProcess(url);
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