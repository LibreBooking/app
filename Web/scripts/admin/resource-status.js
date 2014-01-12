function ResourceStatusManagement(opts) {
	var options = opts;

	var elements = {
		addDialog:$('#addDialog'),
		editDialog:$('#editDialog'),
		deleteDialog:$('#deleteDialog'),

		activeId:$('#activeId'),

		editForm:$('#editForm'),
		addForm:$('#addForm'),
		deleteForm:$('#deleteForm'),
		attributeForm:$('.attributesForm')
	};

	ResourceStatusManagement.prototype.init = function () {
		ConfigureAdminDialog(elements.addDialog, 'auto', 'auto');
		ConfigureAdminDialog(elements.editDialog, 'auto', 'auto');
		ConfigureAdminDialog(elements.deleteDialog, 'auto', 'auto');

		var statusList = $('ul');

		statusList.delegate('a.update', 'click', function (e)
		{
			var id = $(this).closest('li').attr('reasonId');
			setActiveId(id);

			e.preventDefault();
			e.stopPropagation();
		});

		statusList.delegate('a.edit', 'click', function (e)
		{
			$('#edit-reason-description').val($(this).closest('li').find('.reason-description').text());
			showEditPrompt(e);
		});

		statusList.delegate('a.delete', 'click', function (e)
		{
			showDeletePrompt(e);
		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});

		$('.add').click(function(e)
		{
			e.preventDefault();
			$('#add-reason-status').val($(this).attr('add-to'));
			showAddPrompt(e);
		});

		var errorHandler = function (result) {
			$("#globalError").html(result).show();
		};

		ConfigureAdminForm(elements.editForm, getSubmitCallback, null, errorHandler);
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback, null, errorHandler);
		ConfigureAdminForm(elements.addForm, getSubmitCallback, null, errorHandler);
	};


	var getSubmitCallback = function (form) {
		return options.submitUrl + "?rsrid=" + getActiveId() + "&action=" + form.attr('ajaxAction');
	};

	var setActiveId = function (id) {
		elements.activeId.val(id);
	};

	var getActiveId = function () {
		return elements.activeId.val();
	};

	var showAddPrompt = function (e) {
		elements.addDialog.dialog("open");
	};

	var showEditPrompt = function (e) {

		elements.editDialog.dialog("open");
	};

	var showDeletePrompt = function (e) {
		elements.deleteDialog.dialog("open");
	};
}