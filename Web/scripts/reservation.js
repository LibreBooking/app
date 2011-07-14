function Reservation(opts) {
	var options = opts;

	var elements = {
		beginDate: $('#BeginDate'),
		endDate: $('#EndDate'),
		repeatOptions: $('#repeatOptions'),
		repeatDiv: $('#repeatDiv'),
		repeatInterval: $('#repeatInterval'),
		repeatTermination: $('#EndRepeat'),
		beginTime: $('#BeginPeriod'),
		endTime: $('#EndPeriod'),
		durationDays: $('#durationDays'),
		durationHours: $('#durationHours'),
		participantList: $('#participants')
	};

	const oneDay = 86400000; //24*60*60*1000 => hours*minutes*seconds*milliseconds

	var repeatToggled = false;
	var terminationDateSetManually = false;
	var addedParticipants = [];

	Reservation.prototype.init = function() {
		elements.beginDate.data['previousVal'] = elements.beginDate.val();

		$('.dialog').dialog({
			bgiframe: true,
			autoOpen: false,
			modal: true
		});

		$('#dialogAddResources').dialog({
			height: 300,
			open: function(event, ui) {
				InitialzeCheckboxes('#dialogAddResources', '#additionalResources');
				return true;
			}
		});

		$('#btnClearAddResources').click(function() {
			CancelAdd('#dialogAddResources', '#additionalResources');
		});

		$('#btnConfirmAddResources').click(function() {
			AddResources();
		});

		$('#resourceNames, #additionalResources').delegate('.resourceDetails', 'mouseover', function() {
			bindResourceDetails($(this));
		});

		$('#addParticipants').click(function() {

			var allUserList;
			if (allUserList == null) {
				$.ajax({
					url: options.userAutocompleteUrl,
					dataType: 'json',
					async: false,
					success: function(data) {
						allUserList = data;
					}
				});
			}

			var items = [];
			$.map(allUserList, function(item) {
				items.push('<li><a href="#" class="add"><input type="hidden" class="id" value="' + item.Id + '" />' +
						'<img src="img/plus-button.png" /></a> ' +
						item.First + ' ' + item.Last + '</li>')
			});
			elements.participantList.empty();

			$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(elements.participantList);

			elements.participantList.dialog('open');
		});

		elements.participantList.delegate('.add', 'click', function(){
			addParticipant($(this).closest('li').text(), $(this).find('.id').val());
		});
		
		$("#addedParticipants").delegate('.remove', 'click', function(){
			var li = $(this).closest('li');
			var id = li.find('.id').val();
			li.remove();
			removeParticipant(id);
		});
		
		$("#participantAutocomplete").userAutoComplete(options.userAutocompleteUrl, function(ui) {
			addParticipant(ui.item.label, ui.item.value);
		});

		// initialize selected resources
		AddResources();

		elements.repeatOptions.change(function() {
			ChangeRepeatOptions();
			AdjustTerminationDate();
		});

		elements.repeatInterval.change(function() {
			AdjustTerminationDate();
		});

		elements.repeatTermination.change(function() {
			terminationDateSetManually = true;
		});

		InitializeRepeatOptions();

		$('#btnUpdateThisInstance').click(function() {
			ChangeUpdateScope(options.scopeOpts.instance);
		});

		$('#btnUpdateAllInstances').click(function() {
			ChangeUpdateScope(options.scopeOpts.full);
		});

		$('#btnUpdateFutureInstances').click(function() {
			ChangeUpdateScope(options.scopeOpts.future);
		});

		elements.beginDate.change(function() {
			AdjustEndDate();
			ToggleRepeatOptions();
			elements.beginDate.data['previousVal'] = elements.beginDate.val();

			DisplayDuration();
		});

		elements.endDate.change(function() {
			ToggleRepeatOptions();

			DisplayDuration();
		});

		elements.beginTime.change(function() {
			ToggleRepeatOptions();
			DisplayDuration();
		});

		elements.endTime.change(function() {
			ToggleRepeatOptions();
			DisplayDuration();
		});

		$('select, input', elements.repeatDiv).change(function() {
			ToggleUpdateScope();
		});

		WireUpActions();
		WireUpButtonPrompt();
		WireUpSaveDialog();
		DisplayDuration();
	}

	var addParticipant = function(name, userId)
	{
		if ($.inArray(userId, addedParticipants) >= 0)
		{
			// dont add if they are already participating
			return;
		}
		
		var item = '<li>' +
				'<a href="#" class="remove"><img src="img/user-minus.png"/></a> ' +
				name +
				'<input type="hidden" class="id" name="participantList[]" value="' + userId + '" />' +
				'</li>';

		$("#addedParticipants ul").append(item);

		addedParticipants.push(userId);
	}

	var removeParticipant = function(userId)
	{
		var index = $.inArray(userId, addedParticipants);
		if (index >= 0)
		{
			addedParticipants.splice(index, 1);
		}
	}

	// pre-submit callback 
	Reservation.prototype.preSubmit = function(formData, jqForm, options) {
		$('#result').hide();
		$('#creatingNotifiation').show();

		return true;
	}

	// post-submit callback 
	Reservation.prototype.showResponse = function(responseText, statusText, xhr, $form) {
		$('#btnSaveSuccessful').click(function(e) {
			window.location = options.returnUrl;
		});

		$('#btnSaveFailed').click(function() {
			CloseSaveDialog();
		});

		$('#creatingNotifiation').hide();
		$('#result').show();
	}

	var AddResources = function() {
		AddSelected('#dialogAddResources', '#additionalResources', options.additionalResourceElementId);
		$('#dialogAddResources').dialog('close');
	}

	var AddSelected = function(dialogBoxId, displayDivId, inputId) {
		$(displayDivId).empty();

		$(dialogBoxId + ' :checked').each(function() {
			$(displayDivId)
					.append('<p><a href="#" class="resourceDetails">' + $(this).next().text() + '</a><input class="resourceId" type="hidden" name="' + inputId + '[]" value="' + $(this).val() + '"/></p>')
		});

		$(dialogBoxId).dialog('close');
	}

	var AdjustEndDate = function() {
		//var oneDay = 86400000; //24*60*60*1000 => hours*minutes*seconds*milliseconds
		var firstDate = new Date(elements.beginDate.data['previousVal']);
		var secondDate = new Date(elements.beginDate.val());

		var diffDays = (secondDate.getTime() - firstDate.getTime()) / (oneDay);

		var currentEndDate = new Date(elements.endDate.val());
		currentEndDate.setDate(currentEndDate.getDate() + diffDays);

		elements.endDate.datepicker("setDate", currentEndDate);
	}

	var AdjustTerminationDate = function () {
		if (terminationDateSetManually) {
			return;
		}

		var begin = new Date(elements.beginDate.val());
		var interval = parseInt(elements.repeatInterval.val());
		var currentEnd = new Date(elements.repeatTermination.val());

		var repeatOption = elements.repeatOptions.val();

		if (repeatOption == 'daily') {
			begin.setDate(begin.getDate() + interval);
		}
		else if (repeatOption == 'weekly') {
			begin.setDate(begin.getDate() + (7 * interval));
		}
		else if (repeatOption == 'monthly') {
			begin.setMonth(begin.getMonth() + interval);
		}
		else if (repeatOption = 'yearly') {
			begin.setFullYear(begin.getFullYear() + interval);
		}
		else {
			begin = currentEnd;
		}

		elements.repeatTermination.datepicker("setDate", begin);
	}

	var CancelAdd = function(dialogBoxId, displayDivId) {
		var selectedItems = $.makeArray($(displayDivId + ' p').text());
		$(dialogBoxId + ' :checked').each(function() {
			var checkboxText = $(this).next().text();
			if ($.inArray(checkboxText, selectedItems) < 0) {
				$(this).removeAttr('checked');
			}
		});

		$(dialogBoxId).dialog('close');
	}

	var ChangeRepeatOptions = function() {
		var repeatDropDown = elements.repeatOptions;
		if (repeatDropDown.val() != 'none') {
			$('#repeatUntilDiv').show();
		}
		else {
			$('div[id!=repeatOptions]', elements.repeatDiv).hide();
		}

		if (repeatDropDown.val() == 'daily') {
			$('.weeks', elements.repeatDiv).hide();
			$('.months', elements.repeatDiv).hide();
			$('.years', elements.repeatDiv).hide();

			$('.days', elements.repeatDiv).show();
		}

		if (repeatDropDown.val() == 'weekly') {
			$('.days', elements.repeatDiv).hide();
			$('.months', elements.repeatDiv).hide();
			$('.years', elements.repeatDiv).hide();

			$('.weeks', elements.repeatDiv).show();
		}

		if (repeatDropDown.val() == 'monthly') {
			$('.days', elements.repeatDiv).hide();
			$('.weeks', elements.repeatDiv).hide();
			$('.years', elements.repeatDiv).hide();

			$('.months', elements.repeatDiv).show();
		}

		if (repeatDropDown.val() == 'yearly') {
			$('.days', elements.repeatDiv).hide();
			$('.weeks', elements.repeatDiv).hide();
			$('.months', elements.repeatDiv).hide();

			$('.years', elements.repeatDiv).show();
		}
	}

	var ChangeUpdateScope = function(updateScopeValue) {
		$('#hdnSeriesUpdateScope').val(updateScopeValue);
	};

	var DisplayDuration = function() {
		var difference = GetEndDate() - GetBeginDate();
		var days = difference / oneDay;
		var hours = (days % 1) * 24;

		var roundedHours = (hours % 1) ? hours.toPrecision(2) : hours;
		var roundedDays = Math.floor(days);

		elements.durationDays.text(roundedDays);
		elements.durationHours.text(roundedHours);
	};

	var InitialzeCheckboxes = function(dialogBoxId, displayDivId) {
		var selectedItems = $.makeArray($(displayDivId + ' p').text());
		$(dialogBoxId + ' :checkbox').each(function() {
			var checkboxText = $(this).next().text();
			if ($.inArray(checkboxText, selectedItems) >= 0) {
				$(this).attr('checked', 'checked');
			}
			else {
				$(this).removeAttr('checked');
			}
		});
	}

	var InitializeRepeatOptions = function() {
		if (options.repeatType) {
			elements.repeatOptions.val(options.repeatType);
			$('#repeat_every').val(options.repeatInterval);
			for (var i = 0; i < options.repeatWeekdays.length; i++) {
				var id = "#repeatDay" + i;
				$(id).attr('checked', true);
			}

			$("#repeatOnMonthlyDiv :radio[value='" + options.repeatMonthlyType + "']").attr('checked', true);

			ChangeRepeatOptions();
		}
	}

	var CloseSaveDialog = function() {
		$('#dialogSave').dialog('close');
	}

	var ToggleRepeatOptions = function() {
		var SetValue = function(value, disabled) {
			elements.repeatOptions.val(value);
			elements.repeatOptions.trigger('change');
			$('select, input', elements.repeatDiv).attr("disabled", disabled);
		};

		if (MoreThanOneDayBetweenBeginAndEnd()) {
			elements.repeatOptions.data["current"] = elements.repeatOptions.val();
			repeatToggled = true;
			SetValue('none', 'disabled');
		}
		else {
			if (repeatToggled) {
				SetValue(elements.repeatOptions.data["current"], '');
				repeatToggled = false;
			}
		}
	}

	var ToggleUpdateScope = function() {
		if (MoreThanOneDayBetweenBeginAndEnd()) {
			$('#btnUpdateThisInstance').show();
			$('#btnUpdateAllInstances').hide();
			$('#btnUpdateFutureInstances').hide();
		}
		else {
			$('#btnUpdateThisInstance').hide();
			$('#btnUpdateAllInstances').show();
			$('#btnUpdateFutureInstances').show();
		}
	}

	var MoreThanOneDayBetweenBeginAndEnd = function() {
		var begin = GetBeginDate();
		var end = GetEndDate();

		var timeBetweenDates = end.getTime() - begin.getTime();

		return timeBetweenDates > oneDay;
	}

	var WireUpActions = function () {
		$('.create').click(function() {
			$('form').attr("action", options.createUrl);
		});

		$('.update').click(function() {
			$('form').attr("action", options.updateUrl);
		});

		$('.delete').click(function() {
			$('form').attr("action", options.deleteUrl);
		});
	}

	var WireUpButtonPrompt = function () {
		$('#updateButtons').dialog({
			autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
			minWidth: 700, width: 700, height: 100
		});

		$('#updateButtons').find('.button').click(function() {
			$('#updateButtons').dialog('close');
		});

		$('.prompt').click(function() {
			$('#updateButtons').dialog('open');
		});
	}

	var WireUpSaveDialog = function() {
		$('#dialogSave').dialog({
			autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
			minHeight: 400, minWidth: 700, width: 700,
			open: function(event, ui) {
				$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
			}
		});

		$('.save').click(function() {
			$('#dialogSave').dialog('open');

			$('#reservationForm').submit();
		});
	}

	function GetBeginDate() {
		return new Date(elements.beginDate.val() + ' ' + elements.beginTime.val());
	}

	function GetEndDate() {
		return new Date(elements.endDate.val() + ' ' + elements.endTime.val());
	}

	function bindResourceDetails(resourceNameElement) {
		resourceNameElement.click(function(e) {
			e.preventDefault();
		});

		var resourceId = resourceNameElement.siblings(".resourceId").val();

		resourceNameElement.qtip({
			position: {
				my: 'top left',  // Position my top left...
				at: 'bottom left', // at the bottom right of...
				target: resourceNameElement // my target
			},
			content: {
				text: 'Loading...',
				ajax: {
					url: "ajax/resource_details.php",
					type: 'GET',
					data: { rid: resourceId },
					dataType: 'html'
				}
			},
			show: {
				ready: true,
				delay: 500
			},
			style: {
				classes: 'ui-tooltip-shadow ui-tooltip-blue resourceQtip',
				tip: {
					corner: true
				}
			},
			hide: {
				delay: 500,
				fixed: true,
				when: 'mouseout'
			}
		});
	}
}