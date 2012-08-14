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

		$(".reservation").each(function() {
			var refNum = $(this).attr('refNum');
			$(this).attachReservationPopup(refNum);
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

		if (view.name.indexOf("Day") > 0)
		{
			handleTimeClick();
		}
		else
		{
			dayDialog.dialog({modal: false});
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
		var month =  dateVar.getMonth()+1;
		var reservationDate = dateVar.getFullYear() + "-" + month + "-" + dateVar.getDate() + " " + dateVar.getHours() + ":" + dateVar.getMinutes();
		var url = _options.reservationUrl + "&rd=" + reservationDate;

		window.location = url;
	};

}