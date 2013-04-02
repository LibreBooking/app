function Reservation(opts) {
	var options = opts;

	var elements = {
		beginDate: $('#formattedBeginDate'),
		endDate: $('#formattedEndDate'),
        endDateTextbox: $('#EndDate'),

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

	var participation = {};
	participation.addedUsers = [];

	var changeUser = {};

	var oneDay = 86400000;

	var scheduleId;

	Reservation.prototype.init = function(ownerId) {
		participation.addedUsers.push(ownerId);

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

		scheduleId = $('#scheduleId').val();

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

		WireUpResourceDetailPopups();

		$('#btnRemoveAttachment').click(function(e){
			e.preventDefault();
			$('input:checkbox', '#attachmentDiv').toggle();
		});
		// CHANGE USERS //

		changeUser.init();
		
		/////////////////////////
		InitializeParticipationElements();

		// initialize selected resources
		AddResources();

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

		$('#dialogSave').dialog('open');
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
		
		elements.accessoriesDialog.find('input:text, :checked').each(function() {
			AddAccessory($(this).siblings('.name').val(), $(this).siblings('.id').val(), $(this).val());
		});
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
			var quantityElement = elements.accessoriesDialog.find('[name="accessory' + id + '"]');
			quantityElement.val(quantity);
			if (quantity > 0)
			{
				quantityElement.attr('checked', 'checked');
			}
		});
		elements.accessoriesDialog.dialog('open');
	};

	var AddAccessory = function(name, id, quantity) {
		if (quantity == 0 || isNaN(quantity))
		{
			elements.accessoriesList.find('p [accessoryId=' + id  + ']').remove();
			return;
		}
		var x = 'accessory-id=' + id + ',quantity=' + quantity + ',name=' + encodeURIComponent(name);

		elements.accessoriesList.append('<p accessoryId="' + id + '"><span class="quantity">(' + quantity + ')</span> ' + name + '<input type="hidden" name="' + options.accessoryListInputId + '" value="' + x + '"/></p>');
	};
	
	var AddResources = function() {
		AddSelected('#dialogAddResources', '#additionalResources', options.additionalResourceElementId);
		$('#dialogAddResources').dialog('close');
	};

	var AddSelected = function(dialogBoxId, displayDivId, inputId) {
		$(displayDivId).empty();

		var resourceNames = $('#resourceNames');
		var resourceIdHdn = resourceNames.find('.resourceId');
		var resourceId = resourceIdHdn.val();

		var checkboxes = $(dialogBoxId + ' :checked');

		if (checkboxes.length >= 1)
		{
			resourceNames.find('.resourceDetails').text($(checkboxes[0]).next().text());
			resourceIdHdn.val($(checkboxes[0]).val());
		}
		if (checkboxes.length > 1)
		{
			$.each(checkboxes, function(i) {
				if (i == 0)
				{
					return true;
				}
				$(displayDivId).append('<p><a href="#" class="resourceDetails">' + $(this).next().text() + '</a><input class="resourceId" type="hidden" name="' + inputId + '[]" value="' + $(this).val() + '"/></p>');
			});
		}

		$(dialogBoxId).dialog('close');
		WireUpResourceDetailPopups();
	};

	var AdjustEndDate = function() {
		var firstDate = new Date(elements.beginDate.data['previousVal'] + 'T' + elements.beginTime.val());
		var secondDate = new Date(elements.beginDate.val()+ 'T' + elements.beginTime.val());

		var diffDays = (secondDate.getTime() - firstDate.getTime()) / (oneDay);

		var currentEndDate = new Date(elements.endDate.val() + 'T' + elements.endTime.val());
		currentEndDate.setDate(currentEndDate.getDate() + diffDays);

		elements.endDateTextbox.datepicker("setDate", currentEndDate);
		elements.endDate.trigger('change');
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

	var ChangeUpdateScope = function(updateScopeValue) {
		$('#hdnSeriesUpdateScope').val(updateScopeValue);
	};

	var DisplayDuration = function() {
		var rounded = dateHelper.GetDateDifference(elements.beginDate, elements.beginTime, elements.endDate, elements.endTime);

		elements.durationDays.text(rounded.RoundedDays);
		elements.durationHours.text(rounded.RoundedHours);
	};

	var CloseSaveDialog = function() {
		$('#dialogSave').dialog('close');
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
		var updateButtons = $('#updateButtons');
		updateButtons.dialog({
			autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
			minWidth: 700, width: 700, height: 100
		});

		updateButtons.find('.button').click(function() {
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

			$('#reservationForm').submit();
		});
	};

	function WireUpResourceDetailPopups()
	{
		$('#resourceNames, #additionalResources').find('.resourceDetails').each(function ()
		{
			var resourceId = $(this).siblings(".resourceId").val();
			$(this).bindResourceDetails(resourceId);
		});
	}

	function InitializeCheckboxes(dialogBoxId, displayDivId) {
		var selectedItems = [];
		$(displayDivId + ' p').each(function() { selectedItems.push($(this).text()) });

		var resourceId = $('#resourceNames').find('.resourceId').val();

		$(dialogBoxId + ' :checkbox').each(function() {
			var checkboxText = $(this).next().text();
			if ($.inArray(checkboxText, selectedItems) >= 0 || $(this).val() == resourceId) {
				$(this).attr('checked', 'checked');
			}
			else {
				$(this).removeAttr('checked');
			}
		});
	}
	
	function InitializeDateElements() {
		var periodsCache = [];

        elements.beginDate.data['previousVal'] = elements.beginDate.val();
		elements.endDate.data['previousVal'] = elements.endDate.val();

		elements.beginDate.change(function() {
			PopulatePeriodDropDown(elements.beginDate, elements.beginTime);
			AdjustEndDate();
			DisplayDuration();

			elements.beginDate.data['previousVal'] = elements.beginDate.val();
		});

		elements.endDate.change(function() {
			PopulatePeriodDropDown(elements.endDate, elements.endTime);
			DisplayDuration();

			elements.endDate.data['previousVal'] = elements.endDate.val();
		});

		elements.beginTime.change(function() {
			DisplayDuration();
		});

		elements.endTime.change(function() {
			DisplayDuration();
		});

		var PopulatePeriodDropDown = function(dateElement, periodElement)
			{
				var prevDate = new Date(dateElement.data['previousVal']);
				var currDate = new Date(dateElement.val());
				if (prevDate.getTime() == currDate.getTime())
				{
					return;
				}

				var selectedPeriod = periodElement.val();

				var weekday = currDate.getDay();

				if (periodsCache[weekday] != null)
				{
					periodElement.empty();
					periodElement.html(periodsCache[weekday])
					periodElement.val(selectedPeriod);
					return;
				}
				$.ajax({
					url:'schedule.php',
					dataType:'json',
					data:{dr:'layout', 'sid':scheduleId, 'ld':dateElement.val()},
					success:function (data)
					{
						var items = [];
						periodElement.empty();
						$.map(data.periods, function (item)
						{
							items.push('<option value="' + item.begin + '">'+ item.label + '</option>')
						});
						var html = items.join('');
						periodsCache[weekday] = html;
						periodElement.html(html);
						periodElement.val(selectedPeriod);
					},
					async:false
				});
			};
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
				items.push('<li><a href="#" class="add" title="Add" userId="' + item.Id + '">' + item.DisplayName + '</a></li>')
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
						item.DisplayName + '</li>')
			});
		}

		dialogElement.empty();

		$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(dialogElement);

		dialogElement.dialog('open');
	};
}