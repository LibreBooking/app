function ResourceTypeManagement(opts) {
	var options = opts;

	var elements = {
		activeId:$('#activeId'),

		resourceTypes: $('#resourceTypes'),

		editDialog:$('#editDialog'),
		deleteDialog:$('#deleteDialog'),

		editForm:$('#editForm'),
		addForm:$('#addForm'),
		deleteForm:$('#deleteForm'),
		attributeForm:$('.attributesForm')
	};

	var types = {};

	ResourceTypeManagement.prototype.init = function () {
		ConfigureAdminDialog(elements.editDialog, 'auto', 'auto');
		ConfigureAdminDialog(elements.deleteDialog, 'auto', 'auto');

		elements.resourceTypes.delegate('a.update', 'click', function (e)
		{
			var id = $(this).siblings(':hidden.id').val();
			setActiveId(id);

			e.preventDefault();
			e.stopPropagation();
		});

		elements.resourceTypes.delegate('a.edit', 'click', function (e)
		{
			showEdit(e);
		});

		elements.resourceTypes.delegate('a.delete', 'click', function (e)
		{
			showDeletePrompt(e);
		});

		elements.resourceTypes.delegate('.changeAttributes', 'click', function(e) {
			var id = $(this).attr('resourceTypeId');
			setActiveId(id);
		});

		elements.resourceTypes.delegate('.changeAttributes, .customAttributes .cancel', 'click', function (e) {
			var id = getActiveId();
			var otherUsers = $(".customAttributes[resourceTypeId!='" + id + "']");
			otherUsers.find('.attribute-readwrite, .validationSummary').hide();
			otherUsers.find('.attribute-readonly').show();
			var container = $(this).closest('.customAttributes');
			container.find('.attribute-readwrite').toggle();
			container.find('.attribute-readonly').toggle();
			container.find('.validationSummary').hide();
		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});

		var attributesHandler = function(responseText, form)
		{
			if (responseText.ErrorIds && responseText.Messages.attributeValidator)
			{
				var messages =  responseText.Messages.attributeValidator.join('</li><li>');
				messages = '<li>' + messages + '</li>';
				var validationSummary = $(form).find('.validationSummary');
				validationSummary.find('ul').empty().append(messages);
				validationSummary.show();
			}
		};

		var errorHandler = function (result) {
			$("#globalError").html(result).show();
		};

		ConfigureAdminForm(elements.editForm, getSubmitCallback, null, errorHandler);
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback, null, errorHandler);
		ConfigureAdminForm(elements.addForm, getSubmitCallback, null, errorHandler);

		$.each(elements.attributeForm, function(i,form){
			ConfigureAdminForm($(form), getSubmitCallback, null, attributesHandler, {validationSummary:null});
		});
	};

	ResourceTypeManagement.prototype.add = function (resourceType) {
		types[resourceType.id] = resourceType;
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
		var type = types[getActiveId()];

		$('#editName').val(type.name);
		$('#editDescription').val(type.description);

		elements.editDialog.dialog("open");
	};

	var showDeletePrompt = function (e) {
		elements.deleteDialog.dialog("open");
	};
}