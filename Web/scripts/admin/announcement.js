function AnnouncementManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		announcementList: $('#announcementList'),

		editDialog: $('#editDialog'),
		deleteDialog: $('#deleteDialog'),

		addForm: $('#addForm'),
		form: $('#editForm'),
		deleteForm: $('#deleteForm'),

		editText: $('#editText'),
		editBegin: $('#editBegin'),
		editEnd: $('#editEnd'),
		editPriority: $('#editPriority')
	};

	var announcements = new Object();

	AnnouncementManagement.prototype.init = function () {

		elements.announcementList.delegate('a.update', 'click', function (e) {
			setActiveId($(this));
			e.preventDefault();
		});

		elements.announcementList.delegate('.edit', 'click', function () {
			editAnnouncement();
		});
		elements.announcementList.delegate('.delete', 'click', function () {
			deleteAnnouncement();
		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').modal("hide");
		});

		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.actions.add));
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.actions.deleteAnnouncement));
		ConfigureAdminForm(elements.form, getSubmitCallback(options.actions.edit));
	};

	var getSubmitCallback = function (action) {
		return function () {
			return options.submitUrl + "?aid=" + getActiveId() + "&action=" + action;
		};
	};

	function setActiveId(activeElement) {
		var id = activeElement.closest('tr').attr('data-announcement-id');
		elements.activeId.val(id);
	}

	function getActiveId() {
		return elements.activeId.val();
	}

	var editAnnouncement = function () {
		var announcement = getActiveAnnouncement();
		elements.editText.val(HtmlDecode(announcement.text));
		elements.editBegin.val(announcement.start);
		elements.editBegin.trigger('change');
		elements.editEnd.val(announcement.end);
		elements.editEnd.trigger('change');
		elements.editPriority.val(announcement.priority);

		elements.editDialog.modal('show');
	};

	var deleteAnnouncement = function () {
		elements.deleteDialog.modal('show');
	};

	var getActiveAnnouncement = function () {
		return announcements[getActiveId()];
	};

	AnnouncementManagement.prototype.addAnnouncement = function (id, text, start, end, priority) {
		announcements[id] = {id: id, text: text, start: start, end: end, priority: priority};
	};
}