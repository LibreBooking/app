function AttributeManagement(opts) {
	var options = opts;

	var elements = {
		activeId:$('#activeId'),
		attributeList: $('#attributeList'),

		addUnlimited:$('#chkUnlimitedAdd'),
		addQuantity:$('#addQuantity'),

		editName:$('#editName'),
		editUnlimited:$('#chkUnlimitedEdit'),
		editQuantity:$('#editQuantity'),

		addDialog:$('#addAttributeDialog'),
		editDialog:$('#editAttributeDialog'),
		deleteDialog:$('#deleteDialog'),

		addForm:$('#addAttributeForm'),
		editForm:$('#editForm'),
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
		})
				.done(function (data) {
					$('.indicator').hide();
					$('#attributeList').html(data)
				});
	}

	AttributeManagement.prototype.init = function () {

		ConfigureAdminDialog(elements.addDialog, 480, 200);
		ConfigureAdminDialog(elements.editDialog,  500, 200);

//		elements.accessoryList.delegate('a.update', 'click', function(e) {
//			setActiveId($(this));
//			e.preventDefault();
//		});
//
//		elements.accessoryList.delegate('.edit', 'click', function() {
//			editAccessory();
//		});
//		elements.accessoryList.delegate('.delete', 'click', function() {
//			deleteAccessory();
//		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});

		RefreshAttributeList();

		$('#attributeCategory').change(function () {
			RefreshAttributeList();
		});

		$('#addAttributeButton').click(function (e) {
			e.preventDefault();
			$('span.error', elements.addDialog).remove();
			elements.addDialog.dialog('open');
			elements.addDialog.parent().appendTo(elements.addForm);
		});

		$('#attributeType').change(function () {
			showRelevantAttributeOptions($(this).val(), elements.addDialog);
		});

		elements.attributeList.delegate('.editable', 'click', function(){
			var attributeId = $(this).attr('attributeId');
			var dataList = elements.attributeList.data('list');
			var selectedAttribute = dataList[attributeId];

			showEditDialog(selectedAttribute);
		});

		ConfigureAdminForm(elements.addForm, defaultSubmitCallback, addAttributeHandler);
//		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.actions.deleteAccessory));
//		ConfigureAdminForm(elements.editForm, getSubmitCallback(options.actions.edit));

	};

	var showRelevantAttributeOptions = function (selectedType, optionsDiv) {
		//var selectedType = typeElement.val();
		$('.textBoxOptions', optionsDiv).find('div').show();

		if (selectedType != opts.selectList)
		{
			$('.attributePossibleValues').hide();
		}

		if (selectedType == opts.selectList)
		{
			$('.attributeValidationExpression').hide();
		}

		if(selectedType == opts.checkbox)
		{
			$('div', ".textBoxOptions").hide();
			$('.attributeLabel').show();
		}
	};

	var addAttributeHandler = function () {
		elements.addForm.resetForm();
		elements.addDialog.dialog('close');
		RefreshAttributeList();
	};

	var showEditDialog = function(selectedAttribute){
		showRelevantAttributeOptions(selectedAttribute.type, elements.editDialog);

		$('.editAttributeType', elements.editDialog).hide();
		$('#editType' + selectedAttribute.type).show();

		$('#editAttributeLabel').val(selectedAttribute.label);
		$('#editAttributeRequired').removeAttr('checked');
		if (selectedAttribute.required)
		{
			$('#editAttributeRequired').attr('checked', 'checked');
		}
		$('#editAttributeRegex').val(selectedAttribute.regex);
		$('#editAttributePossibleValues').val(selectedAttribute.possibleValues);

		elements.editDialog.dialog('open');
	};

	var defaultSubmitCallback = function (form) {
		return options.submitUrl + "?aid=" + "&action=" + form.attr('ajaxAction');
	};

	var getSubmitCallback = function (action) {
		return function () {
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

}