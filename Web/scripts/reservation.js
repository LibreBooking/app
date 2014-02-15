function Reservation(opts)
{
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
		participantGroupDialogPrompt: $('#promptForGroupParticipants'),
		participantGroupDialog: $('#participantGroupDialog'),
		participantList: $('#participantList'),
		participantAutocomplete: $('#participantAutocomplete'),

		inviteeDialogPrompt: $('#promptForInvitees'),
		inviteeDialog: $('#inviteeDialog'),
		inviteeGroupDialogPrompt: $('#promptForGroupInvitees'),
		inviteeGroupDialog: $('#inviteeGroupDialog'),
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

		printButton: $('.btnPrint'),
		groupDiv: $('#resourceGroups'),
		addResourcesButton: $('#btnAddResources'),
		resourceGroupsDialog: $('#dialogResourceGroups'),
		addResourcesConfirm:$('.btnConfirmAddResources'),
		reservationAttachments:$('#reservationAttachments')
	};

	var participation = {};
	participation.addedUsers = [];

	var changeUser = {};

	var oneDay = 86400000;

	var scheduleId;

	var _ownerId;

	Reservation.prototype.init = function (ownerId)
	{
		_ownerId = ownerId;
		participation.addedUsers.push(ownerId);

		$('.dialog').dialog({
			bgiframe: true,
			autoOpen: false,
			modal: true,
			width: 'auto'
		});

		$('#dialogAddResources').dialog({
			height: 300,
			open: function (event, ui)
			{
				InitializeCheckboxes('#dialogAddResources', '#additionalResources');
				return true;
			}
		});

		scheduleId = $('#scheduleId').val();

		elements.accessoriesDialog.dialog({ width: 450 });
		elements.accessoriesPrompt.click(function ()
		{
			ShowAccessoriesPrompt();

			elements.accessoriesDialog.dialog('open');
		});

		elements.accessoriesConfirm.click(function ()
		{
			AddAccessories();
			elements.accessoriesDialog.dialog('close');
		});

		elements.accessoriesCancel.click(function ()
		{
			elements.accessoriesDialog.dialog('close');
		});

		elements.printButton.click(function ()
		{
			window.print();
		});

		WireUpResourceDetailPopups();

		$('#btnRemoveAttachment').click(function (e)
		{
			e.preventDefault();
			$('input:checkbox', '#attachmentDiv').toggle();
		});
		// CHANGE USERS //

		changeUser.init();

		/////////////////////////
		InitializeParticipationElements();

		elements.addResourcesButton.click(function (e)
		{
			e.preventDefault();
			InitializeAdditionalResources();
			elements.resourceGroupsDialog.dialog('open');
		});

		elements.groupDiv.delegate('.additionalResourceCheckbox, .additionalResourceGroupCheckbox', 'click', function (e)
		{
			handleAdditionalResourceChecked($(this), e);
		});

		$('.btnClearAddResources').click(function ()
		{
			elements.resourceGroupsDialog.dialog('close');
		});

		elements.addResourcesConfirm.click(function ()
		{
			AddResources();
		});

		$('.btnUpdateThisInstance').click(function ()
		{
			ChangeUpdateScope(options.scopeOpts.instance);
		});

		$('.btnUpdateAllInstances').click(function ()
		{
			ChangeUpdateScope(options.scopeOpts.full);
		});

		$('.btnUpdateFutureInstances').click(function ()
		{
			ChangeUpdateScope(options.scopeOpts.future);
		});

		InitializeDateElements();

		WireUpActions();
		WireUpButtonPrompt();
		WireUpSaveDialog();
		DisplayDuration();
		WireUpAttachments();
	};

	// pre-submit callback 
	Reservation.prototype.preSubmit = function (formData, jqForm, options)
	{
		$('#dialogSave').dialog('open');
		$('#result').hide();
		$('#creatingNotification').show();

		return true;
	};

	// post-submit callback 
	Reservation.prototype.showResponse = function (responseText, statusText, xhr, $form)
	{
		$('#btnSaveSuccessful').click(function (e)
		{
			window.location = options.returnUrl;
		});

		$('#btnSaveFailed').click(function ()
		{
			CloseSaveDialog();
		});

		$('#creatingNotification').hide();
		$('#result').show();
	};

	var AddAccessories = function ()
	{
		elements.accessoriesList.empty();

		elements.accessoriesDialog.find('input:text, :checked').each(function ()
		{
			AddAccessory($(this).siblings('.name').val(), $(this).siblings('.id').val(), $(this).val());
		});
	};

	Reservation.prototype.addAccessory = function (accessoryId, quantity, name)
	{
		AddAccessory(name, accessoryId, quantity);
	};

	Reservation.prototype.addResourceGroups = function (resourceGroups)
	{
		elements.groupDiv.tree({
			data: resourceGroups,
			saveState: false,
			dragAndDrop: false,
			selectable: false,
			autoOpen: true,

			onCreateLi: function (node, $li)
			{
				var span = $li.find('span');
				var itemName = span.text();
				var label = $('<label><input type="checkbox"/>' + itemName + '</label>');

				var checkbox = label.find('input');

				if (node.type == 'resource')
				{
					checkbox.attr('resource-id', node.resource_id);
					checkbox.attr('group-id', node.group_id);
					checkbox.addClass('additionalResourceCheckbox');
				}
				else
				{
					checkbox.attr('group-id', node.id);
					checkbox.addClass('additionalResourceGroupCheckbox');
				}

				$li.find('span').html(label);
			}
		});
	};

	var ShowAccessoriesPrompt = function ()
	{
		elements.accessoriesDialog.find('input:text').val('0');

		elements.accessoriesList.find('input:hidden').each(function ()
		{
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

	var AddAccessory = function (name, id, quantity)
	{
		if (quantity == 0 || isNaN(quantity))
		{
			elements.accessoriesList.find('p [accessoryId=' + id + ']').remove();
			return;
		}
		var x = 'accessory-id=' + id + ',quantity=' + quantity + ',name=' + encodeURIComponent(name);

		elements.accessoriesList.append('<p accessoryId="' + id + '"><span class="quantity">(' + quantity + ')</span> ' + name + '<input type="hidden" name="' + options.accessoryListInputId + '" value="' + x + '"/></p>');
	};

	var AddResources = function ()
	{
		var displayDiv = $('#additionalResources');
		displayDiv.empty();

		var resourceNames = $('#resourceNames');
		var resourceIdHdn = resourceNames.find('.resourceId');
		var resourceId = resourceIdHdn.val();

		var checkboxes = elements.resourceGroupsDialog.find('.additionalResourceCheckbox:checked');

		if (checkboxes.length >= 1)
		{
			resourceNames.find('.resourceDetails').text($(checkboxes[0]).parent().text());
			resourceIdHdn.val($(checkboxes[0]).attr('resource-id'));
		}
		if (checkboxes.length > 1)
		{
			$.each(checkboxes, function (i, checkbox)
			{
				if (i == 0)
				{
					return true;
				}
				displayDiv.append('<p><a href="#" class="resourceDetails">' + $(checkbox).parent().text() + '</a><input class="resourceId" type="hidden" name="additionalResources[]" value="' + $(checkbox).attr('resource-id') + '"/></p>');
			});

		}
		WireUpResourceDetailPopups();
		elements.resourceGroupsDialog.dialog('close');
	};

	var InitializeAdditionalResources = function()
	{
		elements.groupDiv.find('input[type=checkbox]').attr('checked', false);
		$.each($('.resourceId'), function(idx, val){
			var resourceCheckboxes = elements.groupDiv.find('[resource-id="' + $(val).val() + '"]');
			$.each(resourceCheckboxes, function(ridx, checkbox)
			{
				$(checkbox).attr('checked', true);
				handleAdditionalResourceChecked($(checkbox));
			});
		});
	};

	var handleAdditionalResourceChecked = function (checkbox, event)
	{
		var isChecked = checkbox.is(':checked');

		if (!checkbox[0].hasAttribute('resource-id'))
		{
			// if this is a group, check/uncheck all nested subitems
			$.each(checkbox.closest('li').find('ul').find('input[type=checkbox]'), function (i, v)
			{
				$(v).attr('checked', isChecked);
				handleAdditionalResourceChecked($(v));
			});
		}
		else
		{
			// if all resources in a group are checked, check the group
			var groupId = checkbox.attr('group-id');
			var numberOfResources = elements.groupDiv.find('.additionalResourceCheckbox[group-id="'+ groupId+'"]').length;
			var numberOfResourcesChecked = elements.groupDiv.find('.additionalResourceCheckbox[group-id="'+ groupId+'"]:checked').length;

			elements.groupDiv.find('.additionalResourceGroupCheckbox[group-id="'+ groupId+'"]').attr('checked', numberOfResources == numberOfResourcesChecked)
		}

		if (elements.groupDiv.find('.additionalResourceCheckbox:checked').length == 0)
		{
			// if this is the only checked checkbox, don't allow 'done'
			elements.addResourcesConfirm.addClass('disabled');
			elements.addResourcesConfirm.attr('disabled', true);
		}
		else
		{
			elements.addResourcesConfirm.removeClass('disabled');
			elements.addResourcesConfirm.removeAttr('disabled');
		}
	};

	var AdjustEndDate = function ()
	{
		var firstDate = new Date(elements.beginDate.data['beginPreviousVal'] + 'T' + elements.beginTime.val());
		var secondDate = new Date(elements.beginDate.val() + 'T' + elements.beginTime.val());

		var diffDays = (secondDate.getTime() - firstDate.getTime()) / (oneDay);

		var currentEndDate = new Date(elements.endDate.val() + 'T' + elements.endTime.val());
		currentEndDate.setDate(currentEndDate.getDate() + diffDays);

		elements.endDateTextbox.datepicker("setDate", currentEndDate);
		elements.endDate.trigger('change');
	};

	var ChangeUpdateScope = function (updateScopeValue)
	{
		$('#hdnSeriesUpdateScope').val(updateScopeValue);
	};

	var DisplayDuration = function ()
	{
		var rounded = dateHelper.GetDateDifference(elements.beginDate, elements.beginTime, elements.endDate, elements.endTime);

		elements.durationDays.text(rounded.RoundedDays);
		elements.durationHours.text(rounded.RoundedHours);
	};

	var CloseSaveDialog = function ()
	{
		$('#dialogSave').dialog('close');
	};

	var WireUpActions = function ()
	{
		$('.create').click(function ()
		{
			$('form').attr("action", options.createUrl);
		});

		$('.update').click(function ()
		{
			$('form').attr("action", options.updateUrl);
		});

		$('.delete').click(function ()
		{
			$('form').attr("action", options.deleteUrl);
		});
	};

	var WireUpButtonPrompt = function ()
	{
		var updateButtons = $('.updateButtons');
		updateButtons.dialog({
			autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
			minWidth: 700, width: 700, height: 100
		});

		updateButtons.find('.button').click(function ()
		{
			$('.updateButtons').dialog('close');
		});

		$('.prompt').click(function ()
		{
			$('.updateButtons').dialog('open');
		});
	};

	var WireUpSaveDialog = function ()
	{
		$('#dialogSave').dialog({
			autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
			minHeight: 400, minWidth: 700, width: 700,
			open: function (event, ui)
			{
				$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
			}
		});

		$('.save').click(function ()
		{

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

	function InitializeCheckboxes(dialogBoxId, displayDivId)
	{
		var selectedItems = [];
		$(displayDivId + ' p').each(function ()
		{
			selectedItems.push($(this).text())
		});

		var resourceId = $('#resourceNames').find('.resourceId').val();

		$(dialogBoxId + ' :checkbox').each(function ()
		{
			var checkboxText = $(this).next().text();
			if ($.inArray(checkboxText, selectedItems) >= 0 || $(this).val() == resourceId)
			{
				$(this).attr('checked', 'checked');
			}
			else
			{
				$(this).removeAttr('checked');
			}
		});
	}

	function InitializeDateElements()
	{
		var periodsCache = [];

		elements.beginDate.data['beginPreviousVal'] = elements.beginDate.val();
		elements.endDate.data['endPreviousVal'] = elements.endDate.val();
		elements.beginTime.data['beginTimePreviousVal'] = elements.beginTime.val();

		elements.beginDate.change(function ()
		{
			PopulatePeriodDropDown(elements.beginDate, elements.beginTime);
			AdjustEndDate();
			DisplayDuration();

			elements.beginDate.data['beginPreviousVal'] = elements.beginDate.val();
		});

		elements.endDate.change(function ()
		{
			PopulatePeriodDropDown(elements.endDate, elements.endTime);
			DisplayDuration();

			elements.endDate.data['endPreviousVal'] = elements.endDate.val();
		});

		elements.beginTime.change(function ()
		{
			var diff = dateHelper.GetTimeDifference(elements.beginTime.data['beginTimePreviousVal'], elements.beginTime.val());

			var newTime = dateHelper.AddTimeDiff(diff,elements.endTime.val());

			console.log(newTime);
			elements.endTime.val(newTime);
			elements.beginTime.data['beginTimePreviousVal'] = elements.beginTime.val();

			DisplayDuration();
		});

		elements.endTime.change(function ()
		{
			DisplayDuration();
		});

		var PopulatePeriodDropDown = function (dateElement, periodElement)
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
				periodElement.html(periodsCache[weekday]);
				periodElement.val(selectedPeriod);
				return;
			}
			$.ajax({
				url: 'schedule.php',
				dataType: 'json',
				data: {dr: 'layout', 'sid': scheduleId, 'ld': dateElement.val()},
				success: function (data)
				{
					var items = [];
					periodElement.empty();
					$.map(data.periods, function (item)
					{
						items.push('<option value="' + item.begin + '">' + item.label + '</option>')
					});
					var html = items.join('');
					periodsCache[weekday] = html;
					periodElement.html(html);
					periodElement.val(selectedPeriod);
				},
				async: false
			});
		};
	}

	function InitializeParticipationElements()
	{
		elements.participantDialogPrompt.click(function ()
		{
			participation.showAllUsersToAdd(elements.participantDialog);
		});

		elements.participantGroupDialogPrompt.click(function ()
		{
			participation.showAllGroupsToAdd(elements.participantGroupDialog);
		});

		elements.participantDialog.delegate('.add', 'click', function ()
		{
			participation.addParticipant($(this).closest('li').text(), $(this).find('.id').val());
		});

		elements.participantGroupDialog.delegate('.add', 'click', function ()
		{
			participation.addGroupParticipants($(this).find('.id').val());
		});

		elements.participantList.delegate('.remove', 'click', function ()
		{
			var li = $(this).closest('li');
			var id = li.find('.id').val();
			li.remove();
			participation.removeParticipant(id);
		});

		elements.participantAutocomplete.userAutoComplete(options.userAutocompleteUrl, function (ui)
		{
			participation.addParticipant(ui.item.label, ui.item.value);
		});

		elements.inviteeDialogPrompt.click(function ()
		{
			participation.showAllUsersToAdd(elements.inviteeDialog);
		});

		elements.inviteeGroupDialogPrompt.click(function ()
		{
			participation.showAllGroupsToAdd(elements.inviteeGroupDialog);
		});

		elements.inviteeDialog.delegate('.add', 'click', function ()
		{
			participation.addInvitee($(this).closest('li').text(), $(this).find('.id').val());
		});

		elements.inviteeGroupDialog.delegate('.add', 'click', function ()
		{
			participation.addGroupInvitees($(this).find('.id').val());
		});

		elements.inviteeList.delegate('.remove', 'click', function ()
		{
			var li = $(this).closest('li');
			var id = li.find('.id').val();
			li.remove();
			participation.removeInvitee(id);
		});

		elements.inviteeAutocomplete.userAutoComplete(options.userAutocompleteUrl, function (ui)
		{
			participation.addInvitee(ui.item.label, ui.item.value);
		});
	}

	function WireUpAttachments()
	{
		var enableCorrectButtons = function()
		{
			var allAttachments = elements.reservationAttachments.find('.attachment-item');
			if (allAttachments.length > 1)
			{
				$.each(allAttachments, function(i, v)
				{
					var addbutton = $(v).find('.add-attachment');
					if (i == allAttachments.length -1)
					{
						addbutton.show();
					}
					else
					{
						addbutton.hide();
					}

					$(v).find('.remove-attachment').show();
				});
			}
			else
			{
				elements.reservationAttachments.find('.add-attachment').show();
				elements.reservationAttachments.find('.remove-attachment').hide();
			}

			if (allAttachments.length == opts.maxConcurrentUploads)
			{
				allAttachments.find('.add-attachment').hide();
			}
		};

		enableCorrectButtons();

		elements.reservationAttachments.delegate('.add-attachment', 'click', function (e)
		{
			e.preventDefault();
			var li = $(this).closest('li');
			var cloned = li.clone();
			cloned.appendTo(li.parent());
			cloned.wrap('<form>').closest('form').get(0).reset();
			cloned.unwrap();
			enableCorrectButtons();

		});

		elements.reservationAttachments.delegate('.remove-attachment', 'click', function (e)
		{
			e.preventDefault();
			$(this).closest('li').remove();
			enableCorrectButtons();
		});
	}

	changeUser.init = function ()
	{
		$('#showChangeUsers').click(function (e)
		{
			$('#changeUsers').toggle();
			e.preventDefault();
		});

		elements.changeUserAutocomplete.userAutoComplete(options.changeUserAutocompleteUrl, function (ui)
		{
			changeUser.chooseUser(ui.item.value, ui.item.label);
		});

		$('#promptForChangeUsers').click(function ()
		{
			changeUser.showAll();
		});

		$('#changeUserDialog').delegate('.add', 'click', function ()
		{
			changeUser.chooseUser($(this).attr('userId'), $(this).text());
			$('#changeUserDialog').dialog('close');
		});
	};

	changeUser.chooseUser = function (id, name)
	{
		elements.userName.text(name);
		elements.userId.val(id);

		participation.removeParticipant(_ownerId);
		participation.removeInvitee(_ownerId);

		participation.addedUsers.push(id);

		_ownerId = id;
		$('#changeUsers').hide();
	};

	changeUser.showAll = function ()
	{
		var dialogElement = $('#changeUserDialog');
		var allUserList;
		var items = [];
		if (dialogElement.children().length == 0)
		{
			$.ajax({
				url: options.changeUserAutocompleteUrl,
				dataType: 'json',
				async: false,
				success: function (data)
				{
					allUserList = data;
				}
			});


			$.map(allUserList, function (item)
			{
				items.push('<li><a href="#" class="add" title="Add" userId="' + item.Id + '">' + item.DisplayName + '</a></li>')
			});
		}

		$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(dialogElement);

		dialogElement.dialog({minHeight: 400, minWidth: 700, width: 700});
		dialogElement.dialog('open');
	};

	participation.addParticipant = function (name, userId)
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

	Reservation.prototype.addParticipant = function (name, userId)
	{
		participation.addParticipant(name, userId);
	};

	Reservation.prototype.addInvitee = function (name, userId)
	{
		participation.addInvitee(name, userId);
	};

	participation.addInvitee = function (name, userId)
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

	participation.removeParticipant = function (userId)
	{
		var index = $.inArray(userId, participation.addedUsers);
		if (index >= 0)
		{
			participation.addedUsers.splice(index, 1);
		}
	};

	participation.removeInvitee = function (userId)
	{
		var index = $.inArray(userId, participation.addedUsers);
		if (index >= 0)
		{
			participation.addedUsers.splice(index, 1);
		}
	};

	participation.showAllUsersToAdd = function (dialogElement)
	{
		var allUserList;
		if (allUserList == null)
		{
			$.ajax({
				url: options.userAutocompleteUrl,
				dataType: 'json',
				async: false,
				success: function (data)
				{
					allUserList = data;
				}
			});

			var items = [];
			$.map(allUserList, function (item)
			{
				items.push('<li><a href="#" class="add" title="Add"><input type="hidden" class="id" value="' + item.Id + '" />' +
						'<img src="img/plus-button.png" /></a> ' +
						item.DisplayName + '</li>')
			});
		}

		dialogElement.empty();

		$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(dialogElement);

		dialogElement.dialog('open');
	};

	participation.showAllGroupsToAdd = function(dialogElement){
		var allUserList;
		if (allUserList == null)
		{
			$.ajax({
				url: options.groupAutocompleteUrl,
				dataType: 'json',
				async: false,
				success: function (data)
				{
					allUserList = data;
				}
			});

			var items = [];
			$.map(allUserList, function (item)
			{
				items.push('<li><a href="#" class="add" title="Add"><input type="hidden" class="id" value="' + item.Id + '" />' +
						'<img src="img/plus-button.png" /></a> ' +
						item.Name + '</li>')
			});
		}

		dialogElement.empty();

		$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(dialogElement);

		dialogElement.dialog('open');
	};

	participation.addGroupUsers = function(groupId, addUserCallback){
		$.ajax({
			url: options.userAutocompleteUrl + '&term=group&gid=' + groupId,
			dataType: 'json',
			async: false,
			success: function (data) {
				$.each(data, function(i, user){
					addUserCallback(user.DisplayName, user.Id);
				});
			}
		});
	};

	participation.addGroupParticipants = function(groupId) 	{
		participation.addGroupUsers(groupId, participation.addParticipant);
	};

	participation.addGroupInvitees = function(groupId) 	{
		participation.addGroupUsers(groupId, participation.addInvitee);
	};
}