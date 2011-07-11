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

		permissionsForm: $('#permissionsForm'),
		addUserForm: $('#addUserForm'),
		removeUserForm: $('#removeUserForm'),
		renameGroupForm: $('#renameGroupForm'),
		deleteGroupForm: $('#deleteGroupForm'),

		addForm: $('#addGroupForm')
	};

	var groups = new Object();

	GroupManagement.prototype.init = function() {

		ConfigureAdminDialog(elements.membersDialog, 'Group Membership', 400, 500);
		ConfigureAdminDialog(elements.permissionsDialog, 'Change Group Permissions', 400, 300);
		ConfigureAdminDialog(elements.deleteDialog, 'Delete Group', 400, 300);
		ConfigureAdminDialog(elements.renameDialog, 'Rename Group', 500, 100);

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

		elements.autocompleteSearch.autocomplete(
		{
			source: function( request, response ) {
				$.ajax({
					url: options.groupAutocompleteUrl,
					dataType: "json",
					data: {
						term: request.term
					},
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: item.Name,
								value: item.Id
							}
						}));
					}
				});
			},
			focus: function( event, ui ) {
				elements.autocompleteSearch.val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
				elements.autocompleteSearch.val( ui.item.label );
				window.location.href = options.selectGroupUrl + ui.item.value
				return false;
			}
		});

		elements.userSearch.autocomplete(
		{
			source: function( request, response ) {
				$.ajax({
					url: options.userAutocompleteUrl,
					dataType: "json",
					data: {
						term: request.term
					},
					success: function( data ) {
						response( $.map( data, function( item ) {
							return {
								label: item.First + " " + item.Last,
								value: item.Id
							}
						}));
					}
				});
			},
			focus: function( event, ui ) {
				elements.userSearch.val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {

				addUserToGroup(ui.item.value);
				elements.userSearch.val('');
				return false;
			}
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
		
		var error = function(errorText) { alert(errorText);};
		
		ConfigureAdminForm(elements.addUserForm, getSubmitCallback(options.actions.addUser), changeMembers, error);
		ConfigureAdminForm(elements.removeUserForm, getSubmitCallback(options.actions.removeUser), changeMembers, error);
		ConfigureAdminForm(elements.permissionsForm, getSubmitCallback(options.actions.permissions), hidePermissionsDialog, error);
		ConfigureAdminForm(elements.renameGroupForm, getSubmitCallback(options.actions.renameGroup), null, error);
		ConfigureAdminForm(elements.deleteGroupForm, getSubmitCallback(options.actions.deleteGroup), null, error);
		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.actions.addGroup), null, error);
	};

	GroupManagement.prototype.addGroup = function(group)
	{
		groups[group.id] = group;
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

			$('#totalUsers').text(data.Total);
			$.map( data.Users, function( item ) {
				items.push('<li><a href="#" class="delete"><img src="../img/cross-button.png" /></a> ' + item.FirstName + ' ' + item.LastName + '<input type="hidden" class="id" value="' + item.UserId + '"/></li>');
			});

			elements.groupUserList.empty();

			$('<ul/>', {'class': 'my-new-list', html: items.join('')}).appendTo(elements.groupUserList);
			elements.membersDialog.dialog('open');

			elements.groupUserList.delegate('.delete', 'click', function() {
				var userId = $(this).siblings('.id').val();
				removeUserFromGroup($(this), userId);
			});
		});
	}

	var addUserToGroup = function(userId)
	{
		$('#addUserId').val(userId);
		elements.addUserForm.submit();
	};

	var removeUserFromGroup = function(element, userId)
	{
		$('#removeUserId').val(userId);
		elements.removeUserForm.submit();
	};

	var changePermissions = function () {
		var groupId = getActiveId();
		
		var data = {dr: 'permissions', gid: groupId};
		$.get(opts.permissionsUrl, data, function(resourceIds) {
			elements.permissionsForm.find(':checkbox').attr('checked', false);
			$.each(resourceIds, function(index, value) {
				elements.permissionsForm.find(':checkbox[value="' + value + '"]').attr('checked',true);
			});

			elements.permissionsDialog.dialog('open');
		});
	};

	var deleteGroup = function() {
		elements.deleteDialog.dialog('open');
	};

}