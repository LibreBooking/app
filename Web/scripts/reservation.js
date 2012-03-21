function Reservation(opts) {
	var options = opts;

	var elements = {
		beginDate: $('#formattedBeginDate'),
		endDate: $('#formattedEndDate'),
        endDateTextbox: $('#EndDate'),
		repeatOptions: $('#repeatOptions'),
		repeatDiv: $('#repeatDiv'),
		repeatInterval: $('#repeatInterval'),
		repeatTermination: $('#formattedEndRepeat'),
        repeatTerminationTextbox: $('#EndRepeat'),
		beginTime: $('#BeginPeriod'),
		endTime: $('#EndPeriod'),
		durationDays: $('#durationDays'),
		durationHours: $('#durationHours'),

		participantDialogPrompt: $('#promptForParticipants'),
		participantDialog: $('#participantDialog'),
		participantList: $('#participantList'),
		participantAutocomplete: $('#participantAutocomplete'),

		inviteeDialogPrompt: $('#promptForInvitees'),
		inviteeDialog: $('#inviteeDialog'),
		inviteeList: $('#inviteeList'),
		inviteeAutocomplete: $('#inviteeAutocomplete'),

		changeUserAutocomplete: $('#changeUserAutocomplete'),
		userName: $('#userName'),
		userId: $('#userId'),

		accessoriesPrompt: $('#addAccessoriesPrompt'),
		accessoriesDialog: $('#dialogAddAccessories'),
		accessoriesList: $('#accessories'),
		accessoriesConfirm: $('#btnConfirmAddAccessories'),
		accessoriesCancel: $('#btnCancelAddAccessories'),

		printButton: $('#btnPrint')
	};

	var oneDay = 86400000; //24*60*60*1000 => hours*minutes*seconds*milliseconds

	var repeatToggled = false;
	var terminationDateSetManually = false;

	var participation = {};
	participation.addedUsers = [];

	var changeUser = {};
	
	Reservation.prototype.init = function(ownerId) {
		participation.addedUsers.push(ownerId);

		//elements.beginDate.data['previousVal'] = elements.beginDate.val();

		$('.dialog').dialog({
			bgiframe: true,
			autoOpen: false,
			modal: true
		});

		$('#dialogAddResources').dialog({
			height: 300,
			open: function(event, ui) {
				InitializeCheckboxes('#dialogAddResources', '#additionalResources');
				return true;
			}
		});

		elements.accessoriesDialog.dialog({ width: 450 });
		elements.accessoriesPrompt.click(function() {
			ShowAccessoriesPrompt();

			elements.accessoriesDialog.dialog('open');
		});

		elements.accessoriesConfirm.click(function() {
			AddAccessories();
			elements.accessoriesDialog.dialog('close');
		});

		elements.accessoriesCancel.click(function() {
			elements.accessoriesDialog.dialog('close');
		});

		elements.printButton.click(function() {
			window.print();
		});
		
		$('#btnClearAddResources').click(function() {
			CancelAdd('#dialogAddResources', '#additionalResources');
		});

		$('#btnConfirmAddResources').click(function() {
			AddResources();
		});

		$('#resourceNames, #additionalResources').delegate('.resourceDetails', 'mouseover', function() {
            var resourceId = $(this).siblings(".resourceId").val();
			$(this).bindResourceDetails(resourceId);
		});

		// CHANGE USERS //

		changeUser.init();
		
		/////////////////////////
		InitializeParticipationElements();

		// initialize selected resources
		AddResources();

		InitializeRepeatElements();
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

		InitializeDateElements();

		WireUpActions();
		WireUpButtonPrompt();
		WireUpSaveDialog();
		DisplayDuration();
	};

	// pre-submit callback 
	Reservation.prototype.preSubmit = function(formData, jqForm, options) {
		$('#result').hide();
		$('#creatingNotification').show();

		return true;
	};

	// post-submit callback 
	Reservation.prototype.showResponse = function(responseText, statusText, xhr, $form) {
		$('#btnSaveSuccessful').click(function(e) {
			window.location = options.returnUrl;
		});

		$('#btnSaveFailed').click(function() {
			CloseSaveDialog();
		});

		$('#creatingNotification').hide();
		$('#result').show();
	};

	var AddAccessories = function() {
		elements.accessoriesList.empty();
		
		elements.accessoriesDialog.find('input:text').each(function() {
			AddAccessory($(this).siblings('.name').val(), $(this).siblings('.id').val(), $(this).val());
		})
	};

	Reservation.prototype.addAccessory = function (accessoryId, quantity, name)
	{
		AddAccessory(name, accessoryId, quantity);
	};

	var ShowAccessoriesPrompt = function() {
		elements.accessoriesDialog.find('input:text').val('0');
		
		elements.accessoriesList.find('input:hidden').each(function () {
			var idAndQuantity = $(this).val();
			var y = idAndQuantity.split('-');
			var params = y[1].split(',');
			var id = params[0].split('=')[1];
			var quantity = params[1].split('=')[1];
			elements.accessoriesDialog.find('[name="accessory' + id + '"]').val(quantity);
		});
		elements.accessoriesDialog.dialog('open');
	};

	var AddAccessory = function(name, id, quantity) {
		if (quantity == 0 || isNaN(quantity))
		{
			elements.accessoriesList.find('p [accessoryId=' + id  + ']').remove();
			return;
		}
		var x = 'accessory-id=' + id + ',quantity=' + quantity;

		elements.accessoriesList.append('<p accessoryId="' + id + '"><span class="quantity">(' + quantity + ')</span> ' + name + '<input type="hidden" name="' + options.accessoryListInputId + '" value="' + x + '"/></p>');
	};
	
	var AddResources = function() {
		AddSelected('#dialogAddResources', '#additionalResources', options.additionalResourceElementId);
		$('#dialogAddResources').dialog('close');
	};

	var AddSelected = function(dialogBoxId, displayDivId, inputId) {
		$(displayDivId).empty();

		$(dialogBoxId + ' :checked').each(function() {
			$(displayDivId)
					.append('<p><a href="#" class="resourceDetails">' + $(this).next().text() + '</a><input class="resourceId" type="hidden" name="' + inputId + '[]" value="' + $(this).val() + '"/></p>')
		});

		$(dialogBoxId).dialog('close');
	};

	var AdjustEndDate = function() {
		var firstDate = new Date(elements.beginDate.data['previousVal']);
		var secondDate = new Date(elements.beginDate.val());

		var diffDays = (secondDate.getTime() - firstDate.getTime()) / (oneDay);

		var currentEndDate = new Date(elements.endDate.val());
		currentEndDate.setDate(currentEndDate.getDate() + diffDays);

		elements.endDateTextbox.datepicker("setDate", currentEndDate);
	};

	var AdjustTerminationDate = function () {
		if (terminationDateSetManually) {
			return;
		}

		var newEndDate = new Date(elements.beginDate.val());
		var interval = parseInt(elements.repeatInterval.val());
		var currentEnd = new Date(elements.repeatTermination.val());

		var repeatOption = elements.repeatOptions.val();

		if (repeatOption == 'daily') {
			newEndDate.setDate(newEndDate.getDate() + interval);
		}
		else if (repeatOption == 'weekly') {
			newEndDate.setDate(newEndDate.getDate() + (7 * interval));
		}
		else if (repeatOption == 'monthly') {
			newEndDate.setMonth(newEndDate.getMonth() + interval);
		}
		else if (repeatOption = 'yearly') {
			newEndDate.setFullYear(newEndDate.getFullYear() + interval);
		}
		else {
			newEndDate = currentEnd;
		}

		elements.repeatTerminationTextbox.datepicker("setDate", newEndDate);
	};

	var CancelAdd = function(dialogBoxId, displayDivId) {
		var selectedItems = $.makeArray($(displayDivId + ' p').text());
		$(dialogBoxId + ' :checked').each(function() {
			var checkboxText = $(this).next().text();
			if ($.inArray(checkboxText, selectedItems) < 0) {
				$(this).removeAttr('checked');
			}
		});

		$(dialogBoxId).dialog('close');
	};

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
	};

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

	var CloseSaveDialog = function() {
		$('#dialogSave').dialog('close');
	};

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
	};

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
	};

	var MoreThanOneDayBetweenBeginAndEnd = function() {
		var begin = GetBeginDate();
		var end = GetEndDate();

		var timeBetweenDates = end.getTime() - begin.getTime();

		return timeBetweenDates > oneDay;
	};

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
	};

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
	};

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
	};

	function GetBeginDate() {
		return new Date(elements.beginDate.val() + ' ' + elements.beginTime.val());
	}

	function GetEndDate() {
		return new Date(elements.endDate.val() + ' ' + elements.endTime.val());
	}

//	function bindResourceDetails(resourceNameElement) {
//		resourceNameElement.click(function(e) {
//			e.preventDefault();
//		});
//
//		var resourceId = resourceNameElement.siblings(".resourceId").val();
//
//		resourceNameElement.qtip({
//			position: {
//				my: 'top left',  // Position my top left...
//				at: 'bottom left', // at the bottom right of...
//				target: resourceNameElement // my target
//			},
//			content: {
//				text: 'Loading...',
//				ajax: {
//					url: "ajax/resource_details.php",
//					type: 'GET',
//					data: { rid: resourceId },
//					dataType: 'html'
//				}
//			},
//			show: {
//				ready: true,
//				delay: 500
//			},
//			style: {
//				classes: 'ui-tooltip-shadow ui-tooltip-blue resourceQtip',
//				tip: {
//					corner: true
//				}
//			},
//			hide: {
//				delay: 500,
//				fixed: true,
//				when: 'mouseout'
//			}
//		});
//	}

	function InitializeCheckboxes(dialogBoxId, displayDivId) {
		var selectedItems = [];
		$(displayDivId + ' p').each(function() { selectedItems.push($(this).text()) });

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

	function InitializeRepeatElements() {
		elements.repeatOptions.change(function() {
			ChangeRepeatOptions();
			AdjustTerminationDate();
		});

		elements.repeatInterval.change(function() {
			AdjustTerminationDate();
		});

        elements.beginDate.change(function() {
            AdjustTerminationDate();
        });

		elements.repeatTermination.change(function() {
			terminationDateSetManually = true;
		});

		$('select, input', elements.repeatDiv).change(function() {
			ToggleUpdateScope();
		});
	}
	
	function InitializeRepeatOptions() {
		if (options.repeatType) {
			elements.repeatOptions.val(options.repeatType);
			$('#repeat_every').val(options.repeatInterval);
			for (var i = 0; i < options.repeatWeekdays.length; i++) {
				var id = "#repeatDay" + options.repeatWeekdays[i];
				$(id).attr('checked', true);
			}

			$("#repeatOnMonthlyDiv :radio[value='" + options.repeatMonthlyType + "']").attr('checked', true);

			ChangeRepeatOptions();
		}
	}
	
	function InitializeDateElements() {
        elements.beginDate.data['previousVal'] = elements.beginDate.val();

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
	}

	function InitializeParticipationElements() {
		elements.participantDialogPrompt.click(function() {
			participation.showAllUsersToAdd(elements.participantDialog);
		});

		elements.participantDialog.delegate('.add', 'click', function(){
			participation.addParticipant($(this).closest('li').text(), $(this).find('.id').val());
		});

		elements.participantList.delegate('.remove', 'click', function(){
			var li = $(this).closest('li');
			var id = li.find('.id').val();
			li.remove();
			participation.removeParticipant(id);
		});

		elements.participantAutocomplete.userAutoComplete(options.userAutocompleteUrl, function(ui) {
			participation.addParticipant(ui.item.label, ui.item.value);
		});

		elements.inviteeDialogPrompt.click(function() {
			participation.showAllUsersToAdd(elements.inviteeDialog);
		});

		elements.inviteeDialog.delegate('.add', 'click', function(){
			participation.addInvitee($(this).closest('li').text(), $(this).find('.id').val());
		});

		elements.inviteeList.delegate('.remove', 'click', function(){
			var li = $(this).closest('li');
			var id = li.find('.id').val();
			li.remove();
			participation.removeInvitee(id);
		});

		elements.inviteeAutocomplete.userAutoComplete(options.userAutocompleteUrl, function(ui) {
			participation.addInvitee(ui.item.label, ui.item.value);
		});
	}

	changeUser.init = function()
	{
		$('#showChangeUsers').click(function(e) {
			$('#changeUsers').toggle();
			e.preventDefault();
		});

		elements.changeUserAutocomplete.userAutoComplete(options.changeUserAutocompleteUrl, function(ui) {
			changeUser.chooseUser(ui.item.value, ui.item.label);
		});

		$('#promptForChangeUsers').click(function()	{
			changeUser.showAll();
		});

		$('#changeUserDialog').delegate('.add', 'click', function() {
			changeUser.chooseUser($(this).attr('userId'), $(this).text());
			$('#changeUserDialog').dialog('close');
		});
	};

	changeUser.chooseUser = function(id, name)
	{
		elements.userName.text(name);
		elements.userId.val(id);
		$('#changeUsers').hide();
	};
	
	changeUser.showAll = function()
	{
		var dialogElement = $('#changeUserDialog');
		var allUserList;
		var items = [];
		if (dialogElement.children().length == 0) {
			$.ajax({
				url: options.changeUserAutocompleteUrl,
				dataType: 'json',
				async: false,
				success: function(data) {
					allUserList = data;
				}
			});


			$.map(allUserList, function(item) {
				items.push('<li><a href="#" class="add" title="Add" userId="' + item.Id + '">' + item.Name + '</a></li>')
			});
		}

		$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(dialogElement);

		dialogElement.dialog('open');
	};
	
	participation.addParticipant = function(name, userId)
	{
		if ($.inArray(userId, participation.addedUsers) >= 0)
		{
			return;
		}

		var item = '<li>' +
				'<a href="#" class="remove"><img src="img/user-minus.png" alt="Remove"/></a> ' +
				name +
				'<input type="hidden" class="id" name="participantList[]" value="' + userId + '" />' +
				'</li>';

		elements.participantList.find("ul").append(item);

		participation.addedUsers.push(userId);
	};

	Reservation.prototype.addParticipant = function(name, userId)
	{
		participation.addParticipant(name, userId);
	};

	Reservation.prototype.addInvitee = function(name, userId)
	{
		participation.addInvitee(name, userId);
	};
	
	participation.addInvitee = function(name, userId)
	{
		if ($.inArray(userId, participation.addedUsers) >= 0)
		{
			return;
		}

		var item = '<li>' +
				'<a href="#" class="remove"><img src="img/user-minus.png" alt="Remove"/></a> ' +
				name +
				'<input type="hidden" class="id" name="invitationList[]" value="' + userId + '" />' +
				'</li>';

		elements.inviteeList.find("ul").append(item);

		participation.addedUsers.push(userId);
	};

	participation.removeParticipant = function(userId)
	{
		var index = $.inArray(userId, participation.addedUsers);
		if (index >= 0)
		{
			participation.addedUsers.splice(index, 1);
		}
	};

	participation.removeInvitee = function(userId)
	{
		var index = $.inArray(userId, participation.addedUsers);
		if (index >= 0)
		{
			participation.addedUsers.splice(index, 1);
		}
	};

	participation.showAllUsersToAdd = function(dialogElement) {
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

			var items = [];
			$.map(allUserList, function(item) {
				items.push('<li><a href="#" class="add" title="Add"><input type="hidden" class="id" value="' + item.Id + '" />' +
						'<img src="img/plus-button.png" /></a> ' +
						item.Name + '</li>')
			});
		}

		dialogElement.empty();

		$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(dialogElement);

		dialogElement.dialog('open');
	};
}