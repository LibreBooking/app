function AnnouncementManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		announcementList: $('#announcementList'),

		editDialog: $('#editDialog'),
		deleteDialog: $('#deleteDialog'),
		emailDialog: $('#emailDialog'),

		addForm: $('#addForm'),
		form: $('#editForm'),
		deleteForm: $('#deleteForm'),
		emailForm: $('#emailForm'),

		editText: $('#editText'),
		editBegin: $('#editBegin'),
		editEnd: $('#editEnd'),
		editPriority: $('#editPriority'),
		editUserGroups: $('#editUserGroups'),
		editResourceGroups: $('#editResourceGroups'),
        editUserGroupsDiv: $('#editUserGroupsDiv'),
        editResourceGroupsDiv: $('#editResourceGroupsDiv'),

		emailCount: $('#emailCount'),

        displayPage: $('#addPage'),
        moreOptions: $('#moreOptions')
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
		elements.announcementList.delegate('.sendEmail', 'click', function () {
			emailAnnouncement();
		});
		elements.announcementList.delegate('.delete', 'click', function () {
			deleteAnnouncement();
		});

		elements.displayPage.change(function(e){
		    if ($(this).val() == '5')
            {
                elements.moreOptions.hide();
            }
            else {
                elements.moreOptions.show();
            }
        });

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').modal("hide");
		});

		ConfigureAsyncForm(elements.addForm, getSubmitCallback(options.actions.add));
		ConfigureAsyncForm(elements.deleteForm, getSubmitCallback(options.actions.deleteAnnouncement));
		ConfigureAsyncForm(elements.form, getSubmitCallback(options.actions.edit));
		ConfigureAsyncForm(elements.emailForm, getSubmitCallback(options.actions.email), function() {
			elements.emailDialog.modal('hide');}
		);
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

		if (announcement.displayPage == 5)
        {
            elements.editUserGroupsDiv.hide();
            elements.editResourceGroupsDiv.hide();
        }
        else
        {
            elements.editUserGroupsDiv.show();
            elements.editResourceGroupsDiv.show();

            elements.editUserGroups.val($.map(announcement.groupIds, function(i){
                return i + "";
            }));
            elements.editUserGroups.trigger('change');

            elements.editResourceGroups.val($.map(announcement.resourceIds, function(i){
                return i + "";
            }));
            elements.editResourceGroups.trigger('change');
        }

		elements.editDialog.modal('show');
	};

	var emailAnnouncement = function() {
		var announcement = getActiveAnnouncement();

		ajaxGet(options.getEmailCountUrl + '&aid=' +announcement.id, function(){}, function(data) {
			elements.emailCount.text(data.users);
			elements.emailDialog.modal('show');
		});
	};

	var deleteAnnouncement = function () {
		elements.deleteDialog.modal('show');
	};

	var getActiveAnnouncement = function () {
		return announcements[getActiveId()];
	};

	AnnouncementManagement.prototype.addAnnouncement = function (id, text, start, end, priority, groupIds, resourceIds, displayPage) {
		announcements[id] = {id: id, text: text, start: start, end: end, priority: priority, groupIds: groupIds, resourceIds: resourceIds, displayPage: displayPage};
	};
}