function UserManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		userList: $('table.list'),

		userAutocomplete: $('#userSearch'),

		permissionsDialog: $('#permissionsDialog'),

		permissionsForm: $('#permissionsForm'),

		addForm: $('#addScheduleForm')
	};

	var users = new Object();


	UserManagement.prototype.init = function() {

		ConfigureAdminDialog(elements.permissionsDialog, 'Modify Privileges', 300, 135);

		elements.userList.delegate('a.update', 'click', function(e) {
			setActiveUserId($(this));
			e.preventDefault();
		});

		elements.userList.delegate('.changeStatus', 'click', function() {
			changeStatus();
		});

		elements.userList.delegate('.changeGroups', 'click', function() {
			changeGroups();
		});

		elements.userList.delegate('.changePermissions', 'click', function() {
			changePermissions();
		});

		$(elements.userAutocomplete).autocomplete({
			source: function(request, add) {
				$.getJSON(opts.userAutocompleteUrl, request, function(data) {
					add($.map(data, function(item) {
						return {
							label: item.First,
							value: item.First
						}
					}));
				});
			},
			select: function(e, ui) {
				alert(ui.item);
			}
		});
	};

	UserManagement.prototype.addUser = function(user) {
		users[user.id] = user;
	};

	var getSubmitCallback = function(action) {
		return function() {
			return options.submitUrl + "?uid=" + getActiveUserId() + "&action=" + action;
		};
	};

	function setActiveUserId(activeElement) {
		var id = activeElement.parents('td').siblings('td.id').find(':hidden').val();
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
	}

	var changeGroups = function () {
		var user = getActiveUser();
		var data = {dr: 'groups', id: user.id};
		$.get(opts.groupsUrl, data, function(response) {
			//$('#privilegesDialog').html(response).show();
		});
	};

	var changePermissions = function () {
		var user = getActiveUser();
		var data = {dr: 'groups', uid: user.id};
		$.get(opts.permissionsUrl, data, function(resourceIds) {
			$.each(resourceIds, function(index, value) {
				elements.permissionsForm.find(':checkbox[value="' + value + '"]').attr('checked',true);
			});

			elements.permissionsDialog.dialog('open');
		});
	};
}