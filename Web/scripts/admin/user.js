function UserManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		userList: $('table.list'),

		userAutocomplete: $('#userSearch'),

		permissionsDialog: $('#permissionsDialog'),
		passwordDialog: $('#passwordDialog'),

		permissionsForm: $('#permissionsForm'),
		passwordForm: $('#passwordForm'),

		userDialog: $('#userDialog'),
		userForm: $('#userForm'),

        addUserForm: $('#addUserForm'),

		deleteDialog: $('#deleteDialog'),
		deleteUserForm: $('#deleteUserForm')
	};

	var users = new Object();

	UserManagement.prototype.init = function() {

		ConfigureAdminDialog(elements.permissionsDialog, 430, 500);
		ConfigureAdminDialog(elements.passwordDialog, 400, 150);
		ConfigureAdminDialog(elements.userDialog, 320, 560);
		ConfigureAdminDialog(elements.deleteDialog, 600, 200);

		elements.userList.delegate('a.update', 'click', function(e) {
			setActiveUserElement($(this));
			e.preventDefault();
			e.stopPropagation();
		});

		elements.userList.delegate('.changeStatus', 'click', function(e) {
			changeStatus();
		});

		elements.userList.delegate('.changeGroups', 'click', function(e) {
			changeGroups();
		});

		elements.userList.delegate('.changePermissions', 'click', function(e) {
			changePermissions();
		});

		elements.userList.delegate('.resetPassword', 'click', function(e) {
			elements.passwordDialog.find(':password').val('');
			elements.passwordDialog.dialog('open');
		});

		elements.userList.delegate('.editable', 'click', function() {
			var userId = $(this).find('input:hidden.id').val();
			setActiveUserId(userId);
			changeUserInfo();
		});

		elements.userList.delegate('.delete', 'click', function(e) {
			deleteUser();
		});

		elements.userList.delegate('.viewReservations', 'click', function(e) {
			var user = getActiveUser();
            var name = encodeURI(user.first + ' ' + user.last);
            var url = options.manageReservationsUrl + '?uid=' + user.id + '&un=' + name;
            window.location.href = url;
		});

		elements.userAutocomplete.userAutoComplete(options.userAutocompleteUrl, function(ui) {
			elements.userAutocomplete.val( ui.item.label );
			window.location.href = options.selectUserUrl + ui.item.value
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

        $('.clear').click(function() {
            $(this).closest('form')[0].reset();
        });

		var hidePermissionsDialog = function() {
			elements.permissionsDialog.dialog('close');
		};

		var hidePasswordDialog = function() {
			hideDialog(elements.passwordDialog);
		};

		var hideDialog = function(dialogElement) {
			dialogElement.dialog('close');
		};

		var handleUserUpdate = function(response) {
            $('.asyncValidation').hide();
			$.each(response.ErrorIds, function(index, errorId) {
				$('#' + errorId).show();
			});
		};
		
		var error = function(errorText) { alert(errorText);};
		
		ConfigureAdminForm(elements.permissionsForm, getSubmitCallback(options.actions.permissions), hidePermissionsDialog, error);
		ConfigureAdminForm(elements.passwordForm, getSubmitCallback(options.actions.password), hidePasswordDialog, error);
		ConfigureAdminForm(elements.userForm, getSubmitCallback(options.actions.updateUser), hideDialog(elements.userDialog), handleUserUpdate);
		ConfigureAdminForm(elements.deleteUserForm, getSubmitCallback(options.actions.deleteUser), hideDialog(elements.deleteDialog), error);
		ConfigureAdminForm(elements.addUserForm, getSubmitCallback(options.actions.addUser), null, handleUserUpdate);
	};

	UserManagement.prototype.addUser = function(user) {
		users[user.id] = user;
	};

	var getSubmitCallback = function(action) {
		return function() {
			return options.submitUrl + "?uid=" + getActiveUserId() + "&action=" + action;
		};
	};

	function setActiveUserElement(activeElement) {
		var id = activeElement.parents('td').siblings('td.id').find(':hidden').val();
		setActiveUserId(id);
	}

	function setActiveUserId(id) {
		elements.activeId.val(id);
	}

	function getActiveUserId() {
		return elements.activeId.val();
	}

	function getActiveUser() {
		return users[getActiveUserId()];
	}

	var changeStatus = function() {
		var user = getActiveUser();

		if (user.isActive) {
			PerformAsyncAction($(this), getSubmitCallback(options.actions.deactivate))
		}
		else {
			PerformAsyncAction($(this), getSubmitCallback(options.actions.activate))
		}
	};

	var changeGroups = function () {
		var user = getActiveUser();
		var data = {dr: 'groups', id: user.id};
		$.get(opts.groupsUrl, data, function(response) {
			//$('#privilegesDialog').html(response).show();
		});
	};

	var changePermissions = function () {
		var user = getActiveUser();
		var data = {dr: 'permissions', uid: user.id};
		$.get(opts.permissionsUrl, data, function(resourceIds) {
			elements.permissionsForm.find(':checkbox').attr('checked', false);
			$.each(resourceIds, function(index, value) {
				elements.permissionsForm.find(':checkbox[value="' + value + '"]').attr('checked',true);
			});

			elements.permissionsDialog.dialog('open');
		});
	};

	var changeUserInfo = function () {
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

	var deleteUser = function() {
		elements.deleteDialog.dialog('open');
	};
}