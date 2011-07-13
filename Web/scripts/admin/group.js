function GroupManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		groupList: $('table.list'),

		autocompleteSearch: $('#groupSearch'),
		userSearch: $('#userSearch'),

		groupUserList: $('#groupUserList'),
		membersDialog: $('#membersDialog'),
		permissionsDialog: $('#permissionsDialog'),
		deleteDialog: $('#deleteDialog'),
		renameDialog: $('#renameDialog'),
		browseUserDialog: $('#allUsers'),

		permissionsForm: $('#permissionsForm'),
		addUserForm: $('#addUserForm'),
		removeUserForm: $('#removeUserForm'),
		renameGroupForm: $('#renameGroupForm'),
		deleteGroupForm: $('#deleteGroupForm'),

		addForm: $('#addGroupForm')
	};

	var allUserList = null;

	GroupManagement.prototype.init = function() {

		ConfigureAdminDialog(elements.membersDialog, 'Group Membership', 400, 500);
		ConfigureAdminDialog(elements.permissionsDialog, 'Change Group Permissions', 400, 300);
		ConfigureAdminDialog(elements.deleteDialog, 'Delete Group', 400, 300);
		ConfigureAdminDialog(elements.renameDialog, 'Rename Group', 500, 100);
		ConfigureAdminDialog(elements.browseUserDialog, 'Browse Users', 500, 100);

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
		});

		elements.groupList.delegate('.delete', 'click', function() {
			deleteGroup();
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

		elements.autocompleteSearch.autocomplete(
				{
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
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		var hidePermissionsDialog = function() {
			elements.permissionsDialog.dialog('close');
		};

		var error = function(errorText) {
			alert(errorText);
		};

		$("#browseUsers").click(function() {
			showAllUsersToAdd();
		});

		ConfigureAdminForm(elements.addUserForm, getSubmitCallback(options.actions.addUser), changeMembers, error);
		ConfigureAdminForm(elements.removeUserForm, getSubmitCallback(options.actions.removeUser), changeMembers, error);
		ConfigureAdminForm(elements.permissionsForm, getSubmitCallback(options.actions.permissions), hidePermissionsDialog, error);
		ConfigureAdminForm(elements.renameGroupForm, getSubmitCallback(options.actions.renameGroup), null, error);
		ConfigureAdminForm(elements.deleteGroupForm, getSubmitCallback(options.actions.deleteGroup), null, error);
		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.actions.addGroup), null, error);
	};

	var showAllUsersToAdd = function() {
		elements.browseUserDialog.empty();

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
			if (elements.groupUserList.data('userIds')[item.Id] == undefined) {
				items.push('<li><a href="#" class="add"><img src="../img/plus-button.png" alt="Add To Group" /></a> ' + item.First + ' ' + item.Last + '<input type="hidden" class="id" value="' + item.Id + '"/></li></li>');
			}
			else {
				items.push('<li><img src="../img/tick-white.png" alt="Group Member" /> <span>' + item.First + ' ' + item.Last + '</span></li>');
			}
		});


		$('<ul/>', {'class': '', html: items.join('')}).appendTo(elements.browseUserDialog);

		elements.browseUserDialog.dialog('open');
	};

	var getSubmitCallback = function(action) {
		return function() {
			return options.submitUrl + "?gid=" + getActiveId() + "&action=" + action;
		};
	};

	function setActiveId(activeElement) {
		var id = activeElement.parents('td').siblings('td.id').find(':hidden').val();
		elements.activeId.val(id);
	}

	function getActiveId() {
		return elements.activeId.val();
	}

	function getActiveGroup() {
		return groups[getActiveId()];
	}

	var renameGroup = function() {
		elements.renameDialog.dialog('open');
	};

	var changeMembers = function() {
		var groupId = getActiveId();
		$.getJSON('manage_groups.php?dr=groupMembers', {gid: groupId}, function(data) {
			var items = [];
			var userIds = [];

			$('#totalUsers').text(data.Total);
			$.map(data.Users, function(item) {
				items.push('<li><a href="#" class="delete"><img src="../img/cross-button.png" /></a> ' + item.FirstName + ' ' + item.LastName + '<input type="hidden" class="id" value="' + item.UserId + '"/></li>');
				userIds[item.UserId] = item.UserId;
			});

			elements.groupUserList.empty();
			elements.groupUserList.data('userIds', userIds);

			$('<ul/>', {'class': '', html: items.join('')}).appendTo(elements.groupUserList);
			elements.membersDialog.dialog('open');
		});
	}

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

		var data = {dr: 'permissions', gid: groupId};
		$.get(opts.permissionsUrl, data, function(resourceIds) {
			elements.permissionsForm.find(':checkbox').attr('checked', false);
			$.each(resourceIds, function(index, value) {
				elements.permissionsForm.find(':checkbox[value="' + value + '"]').attr('checked', true);
			});

			elements.permissionsDialog.dialog('open');
		});
	};

	var deleteGroup = function() {
		elements.deleteDialog.dialog('open');
	};

}