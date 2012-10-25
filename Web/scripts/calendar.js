function Calendar(opts, reservations)
{
	var _options = opts;
	var _reservations = reservations;

	var dayDialog = $('#dayDialog');

	Calendar.prototype.init = function()
	{
		$('#calendar').fullCalendar({
			header: '',
			editable: false,
			defaultView: _options.view,
			year: _options.year,
			month: _options.month-1,
			date: _options.date,
			events: _reservations,
			eventRender: function(event, element) { element.attachReservationPopup(event.id); },
			dayClick: dayClick,
			dayNames: _options.dayNames,
			dayNamesShort: _options.dayNamesShort,
			monthNames: _options.monthNames,
			monthNamesShort: _options.monthNamesShort,
			weekMode: 'variable',
			timeFormat: _options.timeFormat,
			columnFormat:  {
				month: 'dddd',
			    week: 'dddd ' + _options.dayMonth,
			    day: 'dddd ' + _options.dayMonth
			},
			axisFormat: _options.timeFormat,
			firstDay: _options.firstDay
		});

		$('.fc-widget-content').hover(
			function() {
				$(this).addClass('hover');
			},
				
			function() {
				$(this).removeClass('hover');
			}
		);

		$(".reservation").each(function(index, value) {
			var refNum = $(this).attr('refNum');
			value.attachReservationPopup(refNum);
		});

		$('#calendarFilter').change(function() {
			var day = getQueryStringValue('d');
			var month = getQueryStringValue('m');
			var year = getQueryStringValue('y');
			var type = getQueryStringValue('ct');
			var scheduleId = '';
			var resourceId = '';

			if ($(this).find(':selected').hasClass('schedule'))
			{
				scheduleId = '&sid=' + $(this).val();
			}
			else
			{
				scheduleId = '&sid=' + $(this).find(':selected').prevAll('.schedule').val();
				resourceId = '&rid=' + $(this).val();
			}

			var url = 'calendar.php?ct=' + type + '&d=' + day + '&m=' + month + '&y=' + year + scheduleId + resourceId;
			
			window.location = url;
		});

        $('#turnOffSubscription').click(function(e){
            e.preventDefault();
            PerformAsyncAction($(this), function(){return opts.subscriptionDisableUrl;});
        });

        $('#turnOnSubscription').click(function(e){
            e.preventDefault();
            PerformAsyncAction($(this), function(){return opts.subscriptionEnableUrl;});
        });

		dayDialog.find('a').click(function(e){
			e.preventDefault();
		});

		$('#dayDialogCancel').click(function(e){
			dayDialog.dialog('close');
		});

		$('#dayDialogView').click(function(e){
			drillDownClick();
		});

		$('#dayDialogCreate').click(function(e){
			openNewReservation();
		});
	};

	var dateVar = null;

	var dayClick = function(date, allDay, jsEvent, view)
	{
		dateVar = date;

		if (!opts.reservable)
		{
			drillDownClick();
			return;
		}

		if (view.name.indexOf("Day") > 0)
		{
			handleTimeClick();
		}
		else
		{
			dayDialog.dialog({modal: false, height: 70, width: 'auto'});
			dayDialog.dialog("widget").position({
						       my: 'left top',
						       at: 'left bottom',
						       of: jsEvent
						    });
		}
	};

	var handleTimeClick = function()
	{
		openNewReservation();
	};

	var drillDownClick = function()
	{
		var month =  dateVar.getMonth()+1;
		var url =  _options.dayClickUrl;
		url = url + '&y=' + dateVar.getFullYear() + '&m=' + month + '&d=' + dateVar.getDate();

		window.location = url;
	};

	var openNewReservation = function(){
		var end = new Date(dateVar);
		end.setMinutes(dateVar.getMinutes()+30);

		var url = _options.reservationUrl + "&sd=" + getUrlFormattedDate(dateVar) + "&ed=" + getUrlFormattedDate(end);

		window.location = url;
	};

	var getUrlFormattedDate = function(d)
	{
		var month =  d.getMonth()+1;
		return encodeURI(d.getFullYear() + "-" + month + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes());
	}

}