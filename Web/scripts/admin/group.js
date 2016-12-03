function GroupManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		groupList: $('#groupList'),

		autocompleteSearch: $('#groupSearch'),
		userSearch: $('#userSearch'),

		groupUserList: $('#groupUserList'),
		membersDialog: $('#membersDialog'),
		allUsersList: $('#allUsersList'),
		permissionsDialog: $('#permissionsDialog'),
		deleteDialog: $('#deleteDialog'),
		renameDialog: $('#renameDialog'),
		browseUserDialog: $('#allUsers'),
		rolesDialog: $('#rolesDialog'),
		groupAdminDialog: $('#groupAdminDialog'),

		permissionsForm: $('#permissionsForm'),
		addUserForm: $('#addUserForm'),
		removeUserForm: $('#removeUserForm'),
		renameGroupForm: $('#renameGroupForm'),
		deleteGroupForm: $('#deleteGroupForm'),
		rolesForm: $('#rolesForm'),
		groupAdminForm: $('#groupAdminForm'),
        groupCount: $('#groupCount'),

		addForm: $('#addGroupForm'),

        checkAllResources: $('#checkAllResources'),
        checkNoResources: $('#checkNoResources')
	};

	var allUserList = null;

	GroupManagement.prototype.init = function() {

		elements.groupList.delegate('a.update', 'click', function(e) {
			setActiveId($(this));
			e.preventDefault();
		});

		elements.groupList.delegate('.rename', 'click', function() {
			renameGroup();
		});

		elements.groupList.delegate('.permissions', 'click', function() {
			changePermissions();
		});

		elements.groupList.delegate('.members', 'click', function() {
			changeMembers();
			elements.membersDialog.modal('show');
		});

		elements.groupList.delegate('.delete', 'click', function() {
			deleteGroup();
		});

		elements.groupList.delegate('.roles', 'click', function() {
			changeRoles();
		});

		elements.browseUserDialog.delegate('.add', 'click', function() {
			var link = $(this);
			var userId = link.siblings('.id').val();

			addUserToGroup(userId);

			link.find('img').attr('src', '../img/tick-white.png');
		});

		elements.groupUserList.delegate('.delete', 'click', function() {
			var userId = $(this).siblings('.id').val();
			removeUserFromGroup($(this), userId);
		});

		elements.autocompleteSearch.autocomplete({
			source: function(request, response) {
				$.ajax({
					url: options.groupAutocompleteUrl,
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data) {
						response($.map(data, function(item) {
							return {
								label: item.Name,
								value: item.Id
							}
						}));
					}
				});
			},
			focus: function(event, ui) {
				elements.autocompleteSearch.val(ui.item.label);
				return false;
			},
			select: function(event, ui) {
				elements.autocompleteSearch.val(ui.item.label);
				window.location.href = options.selectGroupUrl + ui.item.value
				return false;
			}
		});

		elements.userSearch.userAutoComplete(options.userAutocompleteUrl, function(ui) {
			addUserToGroup(ui.item.value);
			elements.userSearch.val('');
		});

		elements.groupList.delegate('.groupAdmin', 'click', function() {
			changeGroupAdmin();
		});

        elements.checkAllResources.click(function(e){
            e.preventDefault();
            elements.permissionsDialog.find('input:checkbox').prop('checked', true);
        });

        elements.checkNoResources.click(function(e){
            e.preventDefault();
            elements.permissionsDialog.find('input:checkbox').prop('checked', false);
        });

		$(".save").click(function() {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function() {
			$(this).closest('.dialog').modal("hide");
		});

		var hidePermissionsDialog = function() {
			elements.permissionsDialog.modal('hide');
		};

		var error = function(errorText) {
			alert(errorText);
		};

		$("#browseUsers").click(function() {
			showAllUsersToAdd();
		});

		ConfigureAsyncForm(elements.addUserForm, getSubmitCallback(options.actions.addUser), changeMembers, error);
		ConfigureAsyncForm(elements.removeUserForm, getSubmitCallback(options.actions.removeUser), changeMembers, error);
		ConfigureAsyncForm(elements.permissionsForm, getSubmitCallback(options.actions.permissions), hidePermissionsDialog, error);
		ConfigureAsyncForm(elements.renameGroupForm, getSubmitCallback(options.actions.renameGroup), null, error);
		ConfigureAsyncForm(elements.deleteGroupForm, getSubmitCallback(options.actions.deleteGroup), null, error);
		ConfigureAsyncForm(elements.addForm, getSubmitCallback(options.actions.addGroup), null, error);
		ConfigureAsyncForm(elements.rolesForm, getSubmitCallback(options.actions.roles), null, error);
		ConfigureAsyncForm(elements.groupAdminForm, getSubmitCallback(options.actions.groupAdmin), null, error);
	};

	var showAllUsersToAdd = function() {
		elements.membersDialog.modal('hide');
		elements.allUsersList.empty();

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
		if (allUserList != null)
		{
			$.map(allUserList, function(item) {
				if (elements.groupUserList.data('userIds')[item.Id] == undefined) {
					items.push('<div><a href="#" class="add"><img src="../img/plus-button.png" alt="Add To Group" /></a> ' + item.DisplayName + '<input type="hidden" class="id" value="' + item.Id + '"/></div>');
				}
				else {
					items.push('<div><img src="../img/tick-white.png" alt="Group Member" /> <span>' + item.DisplayName + '</span></div>');
				}
			});
		}

		$('<div/>', {'class': '', html: items.join('')}).appendTo(elements.allUsersList);
		elements.browseUserDialog.modal('show');
	};

	var getSubmitCallback = function(action) {
		return function() {
			return options.submitUrl + "?gid=" + getActiveId() + "&action=" + action;
		};
	};

	function setActiveId(activeElement) {
		var id = activeElement.closest('tr').attr('data-group-id');
		elements.activeId.val(id);
	}

	function getActiveId() {
		return elements.activeId.val();
	}

	var renameGroup = function() {
		elements.renameDialog.modal('show');
	};

	var changeMembers = function() {
		var groupId = getActiveId();
		$.getJSON(opts.groupsUrl + '?dr=groupMembers', {gid: groupId}, function(data) {
			var items = [];
			var userIds = [];

			$('#totalUsers').text(data.Total);
			if (data.Users != null)
			{
				$.map(data.Users, function(item) {
					items.push('<div><a href="#" class="delete"><img src="../img/cross-button.png" /></a> ' + item.DisplayName + '<input type="hidden" class="id" value="' + item.Id + '"/></div>');
					userIds[item.Id] = item.Id;
				});
			}

			elements.groupUserList.empty();
			elements.groupUserList.data('userIds', userIds);

			$('<div/>', {'class': '', html: items.join('')}).appendTo(elements.groupUserList);
		});
	};

	var addUserToGroup = function(userId) {


		$('#addUserId').val(userId);
		elements.addUserForm.submit();
	};

	var removeUserFromGroup = function(element, userId) {

        $('#removeUserId').val(userId);
		elements.removeUserForm.submit();
	};

	var changePermissions = function () {
		var groupId = getActiveId();

		var data = {dr: opts.dataRequests.permissions, gid: groupId};
		$.get(opts.permissionsUrl, data, function(resourceIds) {
			elements.permissionsForm.find(':checkbox').attr('checked', false);
			$.each(resourceIds, function(index, value) {
				elements.permissionsForm.find(':checkbox[value="' + value + '"]').prop('checked', true);
			});

			elements.permissionsDialog.modal('show');
		});
	};

	var deleteGroup = function() {
		elements.deleteDialog.modal('show');
	};

	var changeRoles = function() {
		var groupId = getActiveId();

		var data = {dr: opts.dataRequests.roles, gid: groupId};
		$.get(opts.rolesUrl, data, function(roleIds) {
			elements.rolesForm.find(':checkbox').attr('checked', false);
			$.each(roleIds, function(index, value) {
				elements.rolesForm.find(':checkbox[value="' + value + '"]').prop('checked', true);
			});

			elements.rolesDialog.modal('show');
		});
	};

	var changeGroupAdmin = function() {
		var groupId = getActiveId();

		elements.groupAdminForm.find('select').val('');
		
		elements.groupAdminDialog.modal('show');
	};
}