function AttributeManagement(opts) {
	var options = opts;

	var elements = {
		activeId:$('#activeId'),
		attributeList:$('#attributeList'),

		attributeCategory:$('#attributeCategory'),
		addCategory:$('#addCategory'),

		editName:$('#editName'),
		editUnlimited:$('#chkUnlimitedEdit'),
		editQuantity:$('#editQuantity'),

		addDialog:$('#addAttributeDialog'),
		editDialog:$('#editAttributeDialog'),
		deleteDialog:$('#deleteDialog'),

		addForm:$('#addAttributeForm'),
		form:$('#editAttributeForm'),
		deleteForm:$('#deleteForm')
	};

	var attributes = new Object();

	function RefreshAttributeList() {
		var categoryId = $('#attributeCategory').val();

		$.ajax({
			url:opts.changeCategoryUrl + categoryId,
			cache:false,
			beforeSend:function () {
				$('.indicator').show().insertBefore($('#attributeList'));
				$('#attributeList').html('');
			}
		}).done(function (data) {
					$('.indicator').hide();
					$('#attributeList').html(data)
				});
	}

	AttributeManagement.prototype.init = function () {

		ConfigureAdminDialog(elements.addDialog, 480, 200);
		ConfigureAdminDialog(elements.editDialog, 500, 200);
		ConfigureAdminDialog(elements.deleteDialog, 430, 200);

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});

		RefreshAttributeList();

		elements.attributeCategory.change(function () {
			RefreshAttributeList();
		});

		elements.attributeList.delegate('a.update', 'click', function(e) {
			e.preventDefault();
			e.stopPropagation();
		});

		$('#addAttributeButton').click(function (e) {
			e.preventDefault();
			$('span.error', elements.addDialog).remove();
			elements.addCategory.val(elements.attributeCategory.val());
			elements.addDialog.dialog('open');
		});

		$('#attributeType').change(function () {
			showRelevantAttributeOptions($(this).val(), elements.addDialog);
		});

		elements.attributeList.delegate('.editable', 'click', function (e) {
			e.preventDefault();
			var attributeId = $(this).attr('attributeId');
			var dataList = elements.attributeList.data('list');
			var selectedAttribute = dataList[attributeId];

			showEditDialog(selectedAttribute);
		});

		elements.attributeList.delegate('.delete', 'click', function (e) {
			e.preventDefault();
			var attributeId = $(this).attr('attributeId');

			showDeleteDialog(attributeId);
		});

		ConfigureAdminForm(elements.addForm, defaultSubmitCallback, addAttributeHandler);
		ConfigureAdminForm(elements.form, defaultSubmitCallback, editAttributeHandler);
		ConfigureAdminForm(elements.deleteForm, defaultSubmitCallback, deleteAttributeHandler);

	};

	var showRelevantAttributeOptions = function (selectedType, optionsDiv) {
		//var selectedType = typeElement.val();
		$('.textBoxOptions', optionsDiv).find('div').show();

		if (selectedType != opts.selectList) {
			$('.attributePossibleValues').hide();
		}

		if (selectedType == opts.selectList) {
			$('.attributeValidationExpression').hide();
		}

		if (selectedType == opts.checkbox) {
			$('div', ".textBoxOptions").hide();
			$('.attributeLabel').show();
		}
	};

	var addAttributeHandler = function () {
		elements.addForm.resetForm();
		elements.addDialog.dialog('close');
		RefreshAttributeList();
	};

	var editAttributeHandler = function () {
		elements.form.resetForm();
		elements.editDialog.dialog('close');
		RefreshAttributeList();
	};

	var deleteAttributeHandler = function() {
		elements.deleteDialog.dialog('close');
		RefreshAttributeList();
	};

	var showEditDialog = function (selectedAttribute) {
		showRelevantAttributeOptions(selectedAttribute.type, elements.editDialog);

		$('.editAttributeType', elements.editDialog).hide();
		$('#editType' + selectedAttribute.type).show();

		$('#editAttributeLabel').val(selectedAttribute.label);
		$('#editAttributeRequired').removeAttr('checked');
		if (selectedAttribute.required) {
			$('#editAttributeRequired').attr('checked', 'checked');
		}
		$('#editAttributeRegex').val(selectedAttribute.regex);
		$('#editAttributePossibleValues').val(selectedAttribute.possibleValues);
		$('#editAttributeSortOrder').val(selectedAttribute.sortOrder);
		setActiveId(selectedAttribute.id);

		elements.editDialog.dialog('open');
	};

	var showDeleteDialog = function(selectedAttributeId) {
		setActiveId(selectedAttributeId);
		elements.deleteDialog.dialog('open');
	};

	var defaultSubmitCallback = function (form) {
		return options.submitUrl + "?aid=" + getActiveId() + "&action=" + form.attr('ajaxAction');
	};

	function setActiveId(id) {
		elements.activeId.val(id);
	}

	function getActiveId() {
		return elements.activeId.val();
	}

}