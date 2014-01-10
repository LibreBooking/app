function ResourceStatusManagement(opts) {
	var options = opts;

	var elements = {
		editDialog:$('#editDialog'),
		deleteDialog:$('#deleteDialog'),

		activeId:$('#activeId'),

		editForm:$('#editForm'),
		addForm:$('#addForm'),
		deleteForm:$('#deleteForm'),
		attributeForm:$('.attributesForm')
	};

	var types = {};

	ResourceStatusManagement.prototype.init = function () {
		ConfigureAdminDialog(elements.editDialog, 'auto', 'auto');
		ConfigureAdminDialog(elements.deleteDialog, 'auto', 'auto');

		$('ul').delegate('a.update', 'click', function (e)
		{
			var id = $(this).closest('li').attr('reasonId');
			setActiveId(id);

			e.preventDefault();
			e.stopPropagation();
		});

		$('ul').delegate('a.edit', 'click', function (e)
		{
			$('#reason-description').val($(this).closest('li').find('.reason-description').val());
			showEdit(e);
		});

		$('ul').delegate('a.delete', 'click', function (e)
		{
			showDeletePrompt(e);
		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});


		var errorHandler = function (result) {
			$("#globalError").html(result).show();
		};

		ConfigureAdminForm(elements.editForm, getSubmitCallback, null, errorHandler);
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback, null, errorHandler);
		ConfigureAdminForm(elements.addForm, getSubmitCallback, null, errorHandler);
	};


	var getSubmitCallback = function (form) {
		return options.submitUrl + "?rtid=" + getActiveId() + "&action=" + form.attr('ajaxAction');
	};

	var setActiveId = function (id) {
		elements.activeId.val(id);
	};

	var getActiveId = function () {
		return elements.activeId.val();
	};

	var showEdit = function (e) {

		elements.editDialog.dialog("open");
	};

	var showDeletePrompt = function (e) {
		elements.deleteDialog.dialog("open");
	};
}