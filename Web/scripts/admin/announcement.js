function AnnouncementManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		announcementList: $('table.list'),

		editDialog: $('#editDialog'),
		deleteDialog: $('#deleteDialog'),

		addForm: $('#addForm'),
		editForm: $('#editForm'),
		deleteForm: $('#deleteForm')
	};

	var announcements = new Object();

    AnnouncementManagement.prototype.init = function() {

		ConfigureAdminDialog(elements.editDialog, 450, 200);
		ConfigureAdminDialog(elements.deleteDialog,  500, 200);

		elements.announcementList.delegate('a.update', 'click', function(e) {
			setActiveId($(this));
			e.preventDefault();
		});

		elements.announcementList.delegate('.edit', 'click', function() {
			editAnnouncement();
		});
		elements.announcementList.delegate('.delete', 'click', function() {
			deleteAnnouncement();
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.actions.add));
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.actions.delete));
		ConfigureAdminForm(elements.editForm, getSubmitCallback(options.actions.edit));
	};

	var getSubmitCallback = function(action) {
		return function() {
			return options.submitUrl + "?aid=" + getActiveId() + "&action=" + action;
		};
	};

	function setActiveId(activeElement) {
		var id = activeElement.parents('td').siblings('td.id').find(':hidden').val();
		elements.activeId.val(id);
	}

	function getActiveId() {
		return elements.activeId.val();
	}

	var editAnnouncement = function() {
		var accessory = getActiveAccessory();
		elements.editName.val(accessory.name);
		elements.editQuantity.val(accessory.quantity);

		if (accessory.quantity == '')
		{
			elements.editUnlimited.attr('checked', 'checked');
		}
		else
		{
			elements.editUnlimited.removeAttr('checked');
		}

		elements.editUnlimited.trigger('change');
		elements.editDialog.dialog('open');
	};

	var deleteAnnouncement = function() {
		elements.deleteDialog.dialog('open');
	};

	var getActiveAccessory = function ()
	{
		return announcements[getActiveId()];
	};

	AnnouncementManagement.prototype.addAnnouncement = function(id, text, start, end, priority)
	{
		announcements[id] = {id: id, text: text, start: start, end: end, priority: priority};
	}
}