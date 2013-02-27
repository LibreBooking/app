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

		attributeForm:$('#attributesForm'),
		attributeDialog:$('#attributeDialog'),

		permissionsForm:$('#permissionsForm'),
		passwordForm:$('#passwordForm'),

		userDialog:$('#userDialog'),
		userForm:$('#userForm'),

		groupsDialog:$('#groupsDialog'),
		addedGroups : $('#addedGroups'),
		removedGroups : $('#removedGroups'),
		groupList : $('#groupList'),

		addUserForm:$('#addUserForm'),

		deleteDialog:$('#deleteDialog'),
		deleteUserForm:$('#deleteUserForm')
	};

	var users = {};

	UserManagement.prototype.init = function ()
	{

		ConfigureAdminDialog(elements.permissionsDialog, 430, 500);
		ConfigureAdminDialog(elements.passwordDialog, 400, 150);
		ConfigureAdminDialog(elements.userDialog, 350, 560);
		ConfigureAdminDialog(elements.deleteDialog, 600, 200);
		ConfigureAdminDialog(elements.attributeDialog, 300, 300);
		ConfigureAdminDialog(elements.groupsDialog, 300, 300);

		elements.userList.delegate('a.update', 'click', function (e)
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

		elements.userList.delegate('.changeAttributes', 'click', function (e)
		{
			showAttributesPrompt(e);
			return false;
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

		$(".save").click(function ()
		{
			$(this).closest('form').submit();
		});

		$(".cancel").click(function ()
		{
			$(this).closest('.dialog').dialog("close");
		});

		$('.clear').click(function ()
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

		ConfigureAdminForm(elements.permissionsForm, getSubmitCallback(options.actions.permissions), hidePermissionsDialog, error);
		ConfigureAdminForm(elements.passwordForm, getSubmitCallback(options.actions.password), hidePasswordDialog, error);
		ConfigureAdminForm(elements.userForm, getSubmitCallback(options.actions.updateUser), hideDialog(elements.userDialog));
		ConfigureAdminForm(elements.deleteUserForm, getSubmitCallback(options.actions.deleteUser), hideDialog(elements.deleteDialog), error);
		ConfigureAdminForm(elements.addUserForm, getSubmitCallback(options.actions.addUser));
		ConfigureAdminForm(elements.attributeForm, getSubmitCallback(options.actions.changeAttributes));
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

	var showAttributesPrompt = function (e)
	{
		var userId = getActiveUserId();

		var attributeDiv = $('[userId="' + userId + '"]').find('div.customAttributes');

		$.each(attributeDiv.find('li[attributeId]'), function (index, value)
		{
			var id = $(value).attr('attributeId');
			var attrVal = $(value).find('.attributeValue').text();
			var attributeElement = $('#psiattribute\\[' + id + '\\]');
			if (attributeElement.is(':checkbox'))
			{
				if (attrVal.toLowerCase() == 'true')
				{
					attributeElement.attr('checked', 'checked');
				}
				else
				{
					attributeElement.removeAttr('checked');
				}
			}
			else
			{
				attributeElement.val(attrVal);
			}
		});
		elements.attributeDialog.dialog('open');
	};
}