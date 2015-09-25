function Schedule(opts, resourceGroups)
{
	var options = opts;
	var groupDiv = $('#resourceGroups');
	var scheduleId = $('#scheduleId');

	this.init = function ()
	{
		this.initUserDefaultSchedule();
		this.initRotateSchedule();
		this.initReservations();
		this.initResourceFilter();

		var reservations = $('#reservations');

		reservations.delegate('.clickres:not(.reserved)', 'mouseenter', function ()
		{
			$(this).siblings('.resourcename').toggleClass('hilite');
			var ref = $(this).attr('ref');
			reservations.find('td[ref="' + ref + '"]').addClass('hilite');
		});

		reservations.delegate('.clickres:not(.reserved)', 'mouseleave', function ()
		{
			$(this).siblings('.resourcename').removeClass('hilite');
			var ref = $(this).attr('ref');
			reservations.find('td[ref="' + ref + '"]').removeClass('hilite');
			$(this).removeClass('hilite');
		});

		reservations.delegate('.clickres', 'mousedown', function ()
		{
			$(this).addClass('clicked');
		});

		reservations.delegate('.clickres', 'mouseup', function ()
		{
			$(this).removeClass('clicked');
		});

		reservations.delegate('.reservable', 'click', function ()
		{
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

	this.initResources = function ()
	{
		$('.resourceNameSelector').each(function ()
		{
			$(this).bindResourceDetails($(this).attr('resourceId'));
		});
	};

	this.initNavigation = function ()
	{
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

		$('#schedule-title').find('.schedule-id').on('click', function (e)
		{
			e.preventDefault();
			var scheduleId = $(this).attr('data-scheduleid');

			RedirectToSelf("sid", /sid=\d+/i, "sid=" + scheduleId, function (url)
			{
				var x = RemoveGroupId(url);
				x = RemoveResourceId(x);
				return x;
			});
		});

		$('.schedule-dates').find('.change-date').on('click', function (e)
		{
			e.preventDefault();
			var year = $(this).attr('data-year');
			var month = $(this).attr('data-month');
			var day = $(this).attr('data-day');
			ChangeDate(year, month, day)
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
		$('#schedule-actions .schedule-style').click(function (e)
		{
			e.preventDefault();
			createCookie(opts.cookieName, $(this).attr('schedule-display'), 30, opts.scriptUrl);
			window.location.reload();
		});
	};

	this.toggleResourceFilter = function(){

		var shown = false;
		function hide()
		{
			shown = false;
			$('#reservations-left').addClass('hidden');
			$('#reservations').removeClass('col-md-10').addClass('col-md-12');
			$('#restore-sidebar').removeClass('hidden');

			localStorage.setItem('hide-sidebar-status', true);
		}

		function show()
		{
			shown = true;
			$('#reservations-left').removeClass('hidden');
			$('#reservations').addClass('col-md-10').removeClass('col-md-12');
			$('#restore-sidebar').addClass('hidden');

			localStorage.removeItem('hide-sidebar-status');
		}

		function toggle()
		{
			if (shown)
			{
				hide();
			}
			else
			{
				show();
			}
		}

		$('.toggle-sidebar').on('click', function ()
		{
			toggle();
		});

		var hideSidebar = localStorage.getItem('hide-sidebar-status');
		show();
		if (hideSidebar)
		{
			hide();
		}
	};

	this.initReservations = function ()
	{
		var reservations = $('#reservations');

		this.makeSlotsSelectable(reservations);

		$('.reserved', reservations).each(function ()
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

			var qTipElement = $(this);

			if ($(this).is('div')) {
				qTipElement = $(this).find('.fa');
				qTipElement.click(function(e){
					e.stopPropagation();
				});
			}

			qTipElement.qtip({
				position: {
					my: 'bottom left',
					at: 'top left',
					effect: false
				},

				content: {
					text: function (event, api)
					{
						var refNum = $(this).attr('id');
						$.ajax({ url: options.summaryPopupUrl, data: { id: resid } })
								.done(function (html)
								{
									api.set('content.text', html)
								})
								.fail(function (xhr, status, error)
								{
									api.set('content.text', status + ': ' + error)
								});

						return 'Loading...';
					}
				},

				show: {
					delay: 700,
					effect: false
				},

				hide: {
					fixed: true,
					delay: 500
				},

				style: {
					classes: 'qtip-light qtip-bootstrap'
				}
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

	this.initResourceFilter = function ()
	{
		$('#show_all_resources').click(function (e)
		{
			e.preventDefault();

			groupDiv.tree('selectNode', null);

			eraseCookie('resource_filter' + scheduleId.val());
			ShowAllResources();
		});

		$('#resourceIdFilter').change(function (e)
		{
			var resourceId = $(this).val();
			if (resourceId == '')
			{
				RedirectToSelf('', '', '', function (url)
				{
					groupDiv.tree('selectNode', null);
					return RemoveResourceId(url);
				});
			}
			else
			{
				ChangeResource(resourceId);
			}
		});

		groupDiv.tree({
			data: resourceGroups,
			saveState: 'tree' + options.scheduleId,

			onCreateLi: function (node, $li)
			{
				if (node.type == 'resource')
				{
					$li.addClass('group-resource')
				}
			}
		});

		groupDiv.bind(
				'tree.select',
				function (event)
				{
					if (event.node)
					{
						var node = event.node;
						if (node.type == 'resource')
						{
							ChangeResource(node.resource_id);
						}
						else
						{
							ChangeGroup(node.id);
						}
					}
				});


		this.toggleResourceFilter();
	};
}

function ShowAllResources()
{
	RedirectToSelf("", "", "", function (url)
	{
		var x = RemoveGroupId(url);
		x = RemoveResourceId(x);
		return x;
	});
}

function RemoveResourceId(url)
{
	if (!url)
	{
		url = window.location.href;
	}
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

function dpDateChanged(dateText, inst)
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

function ChangeDate(year, month, day)
{
	RedirectToSelf("sd", /sd=\d{4}-\d{1,2}-\d{1,2}/i, "sd=" + year + "-" + month + "-" + day);
}


function RedirectToSelf(queryStringParam, regexMatch, substitution, preProcess)
{
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