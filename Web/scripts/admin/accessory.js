function AccessoryManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		accessoryList: $('table.list'),

		editDialog: $('#editDialog'),
		deleteDialog: $('#deleteDialog'),

		addForm: $('#addForm'),
		editForm: $('#editForm'),
		deleteForm: $('#deleteForm')
	};

	AccessoryManagement.prototype.init = function() {

		ConfigureAdminDialog(elements.editDialog, 450, 200);
		ConfigureAdminDialog(elements.deleteDialog,  400, 300);

		elements.accessoryList.delegate('a.update', 'click', function(e) {
			setActiveId($(this));
			e.preventDefault();
		});

		elements.accessoryList.delegate('.edit', 'click', function() {
			editAccessory();
		});
		elements.accessoryList.delegate('.delete', 'click', function() {
			deleteAccessory();
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

	var editAccessory = function() {
		elements.editDialog.dialog('open');
	};

	var deleteAccessory = function() {
		elements.deleteDialog.dialog('open');
	};
}