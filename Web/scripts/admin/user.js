function UserManagement(opts)
{
	var options = opts;

	var elements = {
		activeId:$('#activeId'),
		userList:$('table.list'),

		userAutocomplete:$('#userSearch'),
		filterStatusId:$('#filterStatusId'),

		permissionsDialog:$('#permissionsDialog'),
		passwordDialog:$('#passwordDialog'),

		attributeForm:$('.attributesForm'),

		permissionsForm:$('#permissionsForm'),
		passwordForm:$('#passwordForm'),

		userDialog:$('#userDialog'),
		userForm:$('#userForm'),

		groupsDialog:$('#groupsDialog'),
		addedGroups : $('#addedGroups'),
		removedGroups : $('#removedGroups'),
		groupList : $('#groupList'),

		colorDialog:$('#colorDialog'),
		colorValue:$('#reservationColor'),
		colorForm:$('#colorForm'),

		addUserForm:$('#addUserForm'),

		deleteDialog:$('#deleteDialog'),
		deleteUserForm:$('#deleteUserForm')
	};

	var users = {};

	UserManagement.prototype.init = function ()
	{
		ConfigureAdminDialog(elements.permissionsDialog);
		ConfigureAdminDialog(elements.passwordDialog);
		ConfigureAdminDialog(elements.userDialog);
		ConfigureAdminDialog(elements.deleteDialog);
		ConfigureAdminDialog(elements.groupsDialog);
		ConfigureAdminDialog(elements.colorDialog);

		elements.userList.delegate('.update', 'click', function (e)
		{
			setActiveUserElement($(this));
			e.preventDefault();
			e.stopPropagation();
		});

		elements.userList.delegate('.changeStatus', 'click', function (e)
		{
			changeStatus();
		});

		elements.userList.delegate('.changeGroups', 'click', function (e)
		{
			changeGroups();
		});

		elements.userList.delegate('.changePermissions', 'click', function (e)
		{
			changePermissions();
		});

		elements.userList.delegate('.resetPassword', 'click', function (e)
		{
			elements.passwordDialog.find(':password').val('');
			elements.passwordDialog.dialog('open');
		});

		elements.userList.delegate('.changeColor', 'click', function (e)
		{
			var user = getActiveUser();
			elements.colorValue.val(user.reservationColor);
			elements.colorDialog.dialog('open');
		});

		elements.userList.delegate('.editable', 'click', function ()
		{
			var userId = $(this).find('input:hidden.id').val();
			setActiveUserId(userId);
			changeUserInfo();
		});

		elements.userList.delegate('.delete', 'click', function (e)
		{
			deleteUser();
		});

		elements.userList.delegate('.viewReservations', 'click', function (e)
		{
			var user = getActiveUser();
			var name = encodeURI(user.first + ' ' + user.last);
			var url = options.manageReservationsUrl + '?uid=' + user.id + '&un=' + name;
			window.location.href = url;
		});

		elements.userAutocomplete.userAutoComplete(options.userAutocompleteUrl, function (ui)
		{
			elements.userAutocomplete.val(ui.item.label);
			window.location.href = options.selectUserUrl + ui.item.value
		});

		elements.filterStatusId.change(function ()
		{
			var statusid = $(this).val();
			window.location.href = options.filterUrl + statusid;
		});

		elements.addedGroups.delegate('div', 'click', function(e){
			e.preventDefault();
			changeGroup('removeUser', $(this).attr('groupId'));
			$(this).appendTo(elements.removedGroups);
		});

		elements.removedGroups.delegate('div', 'click', function(e){
			e.preventDefault();
			changeGroup('addUser', $(this).attr('groupId'));
			$(this).appendTo(elements.addedGroups);
		});

		elements.userList.delegate('.changeAttributes, .customAttributes .cancel', 'click', function (e) {
			var user = getActiveUser();
			var otherUsers = $(".customAttributes[userId!='" + user.id + "']");
			otherUsers.find('.attribute-readwrite, .validationSummary').hide();
			otherUsers.find('.attribute-readonly').show();
			var container = $(this).closest('.customAttributes');
			container.find('.attribute-readwrite').toggle();
			container.find('.attribute-readonly').toggle();
			container.find('.validationSummary').hide();
		});

		$(".save").click(function ()
		{
			$(this).closest('form').submit();
		});

		$(".cancel").click(function ()
		{
			$(this).closest('.dialog').dialog("close");
		});

		$('.clearform').click(function ()
		{
			$(this).closest('form')[0].reset();
		});

		var hidePermissionsDialog = function ()
		{
			elements.permissionsDialog.dialog('close');
		};

		var hidePasswordDialog = function ()
		{
			hideDialog(elements.passwordDialog);
		};

		var hideDialog = function (dialogElement)
		{
			dialogElement.dialog('close');
		};

		var error = function (errorText)
		{
			alert(errorText);
		};

		var attributesHandler = function(responseText, form)
		{
			if (responseText.ErrorIds && responseText.Messages.attributeValidator)
			{
				var messages =  responseText.Messages.attributeValidator.join('</li><li>');
				messages = '<li>' + messages + '</li>';
				var validationSummary = $(form).find('.validationSummary');
				validationSummary.find('ul').empty().append(messages);
				validationSummary.show();
			}
		};

		ConfigureAdminForm(elements.permissionsForm, defaultSubmitCallback(elements.permissionsForm), hidePermissionsDialog, error);
		ConfigureAdminForm(elements.passwordForm, defaultSubmitCallback(elements.passwordForm), hidePasswordDialog, error);
		ConfigureAdminForm(elements.userForm, defaultSubmitCallback(elements.userForm), hideDialog(elements.userDialog));
		ConfigureAdminForm(elements.deleteUserForm, defaultSubmitCallback(elements.deleteUserForm), hideDialog(elements.deleteDialog), error);
		ConfigureAdminForm(elements.addUserForm, defaultSubmitCallback(elements.addUserForm));
		$.each(elements.attributeForm, function(i,form){
			ConfigureAdminForm($(form), defaultSubmitCallback($(form)), null, attributesHandler, {validationSummary:null});
		});
		ConfigureAdminForm(elements.colorForm, defaultSubmitCallback(elements.colorForm));
	};

	UserManagement.prototype.addUser = function (user)
	{
		users[user.id] = user;
	};

	var getSubmitCallback = function (action)
	{
		return function ()
		{
			return options.submitUrl + "?uid=" + getActiveUserId() + "&action=" + action;
		};
	};

	var defaultSubmitCallback = function (form) {
		return function () {
			return options.submitUrl + "?action=" + form.attr('ajaxAction') + '&uid=' + getActiveUserId();
		};
	};

	function setActiveUserElement(activeElement)
	{
		var id = activeElement.parents('td').siblings('td.id').find(':hidden').val();
		setActiveUserId(id);
	}

	function setActiveUserId(id)
	{
		elements.activeId.val(id);
	}

	function getActiveUserId()
	{
		return elements.activeId.val();
	}

	function getActiveUser()
	{
		return users[getActiveUserId()];
	}

	var changeStatus = function ()
	{
		var user = getActiveUser();

		if (user.isActive)
		{
			PerformAsyncAction($(this), getSubmitCallback(options.actions.deactivate))
		}
		else
		{
			PerformAsyncAction($(this), getSubmitCallback(options.actions.activate))
		}
	};

	var changeGroups = function ()
	{
		elements.addedGroups.find('.group-item').remove();
		elements.removedGroups.find('.group-item').remove();

		elements.groupList.find('.group-item').clone().appendTo(elements.removedGroups);

		var user = getActiveUser();
		var data = {dr:'groups', uid:user.id};
		$.get(opts.groupsUrl, data, function (groupIds)
		{
			$.each(groupIds, function (index, value)
			{
				var groupLine = elements.removedGroups.find('div[groupId=' + value + ']');
				groupLine.appendTo(elements.addedGroups);
			});
		});

		elements.groupsDialog.dialog('open');
	};

	var changeGroup = function(action, groupId)
	{
		var url = opts.groupManagementUrl + '?action=' + action + '&gid='+groupId;

		var data = {userId:getActiveUserId()};
		$.post(url, data);
	};

	var changePermissions = function ()
	{
		var user = getActiveUser();
		var data = {dr:'permissions', uid:user.id};
		$.get(opts.permissionsUrl, data, function (resourceIds)
		{
			elements.permissionsForm.find(':checkbox').attr('checked', false);
			$.each(resourceIds, function (index, value)
			{
				elements.permissionsForm.find(':checkbox[value="' + value + '"]').attr('checked', true);
			});

			elements.permissionsDialog.dialog('open');
		});
	};

	var changeColor = function ()
	{
		var user = getActiveUser();
		var data = {dr:'color', uid:user.id};
		$.get(opts.colorUrl, data, function (colorIds)
		{

		});
	}

	var changeUserInfo = function ()
	{
		var user = getActiveUser();

		ClearAsyncErrors(elements.userDialog);

		$('#username').val(user.username);
		$('#fname').val(user.first);
		$('#lname').val(user.last);
		$('#email').val(user.email);
		$('#timezone').val(user.timezone);

		$('#phone').val(user.phone);
		$('#organization').val(user.organization);
		$('#position').val(user.position);

		elements.userDialog.dialog('open');
	};

	var deleteUser = function ()
	{
		elements.deleteDialog.dialog('open');
	};
}