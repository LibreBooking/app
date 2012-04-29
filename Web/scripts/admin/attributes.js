function AttributeManagement(opts) {
	var options = opts;

	var elements = {
		activeId:$('#activeId'),
		accessoryList:$('table.list'),

		addUnlimited:$('#chkUnlimitedAdd'),
		addQuantity:$('#addQuantity'),

		editName:$('#editName'),
		editUnlimited:$('#chkUnlimitedEdit'),
		editQuantity:$('#editQuantity'),

		addDialog:$('#addAttributeDialog'),
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

		ConfigureAdminDialog(elements.addDialog, 450, 200);
//		ConfigureAdminDialog(elements.deleteDialog,  500, 200);

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
			elements.addDialog.dialog('open');
			elements.addDialog.parent().appendTo(elements.addForm);
		});

		$('#attributeType').change(function () {
			showRelevantAttributeOptions($(this));
		});

		ConfigureAdminForm(elements.addForm, defaultSubmitCallback, addAttributeHandler);
//		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.actions.deleteAccessory));
//		ConfigureAdminForm(elements.editForm, getSubmitCallback(options.actions.edit));

	};

	var showRelevantAttributeOptions = function (typeElement) {
		var selectedType = typeElement.val();
		$('div', "#textBoxOptions").show();

		if (selectedType != opts.selectList)
		{
			$('#attributePossibleValues').hide();
		}

		if(selectedType == opts.checkbox)
		{
			$('div', "#textBoxOptions").hide();
			$('#attributeLabel').show();
		}
	};

	var addAttributeHandler = function () {
		elements.addForm.resetForm();
		elements.addDialog.dialog('close');
		RefreshAttributeList();
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

	var editAccessory = function () {
		var accessory = getActiveAccessory();
		elements.editName.val(accessory.name);
		elements.editQuantity.val(accessory.quantity);

		if (accessory.quantity == '') {
			elements.editUnlimited.attr('checked', 'checked');
		}
		else {
			elements.editUnlimited.removeAttr('checked');
		}

		elements.editUnlimited.trigger('change');
		elements.editDialog.dialog('open');
	};

	var deleteAccessory = function () {
		elements.deleteDialog.dialog('open');
	};

	var getActiveAccessory = function () {
		return accessories[getActiveId()];
	};

}