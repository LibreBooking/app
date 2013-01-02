function AccessoryManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		accessoryList: $('table.list'),

		addUnlimited: $('#chkUnlimitedAdd'),
		addQuantity: $('#addQuantity'),
		
		editName: $('#editName'),
		editUnlimited: $('#chkUnlimitedEdit'),
		editQuantity: $('#editQuantity'),
		
		editDialog: $('#editDialog'),
		deleteDialog: $('#deleteDialog'),

		addForm: $('#addForm'),
		form: $('#editForm'),
		deleteForm: $('#deleteForm')
	};

	var accessories = new Object();

	AccessoryManagement.prototype.init = function() {

		ConfigureAdminDialog(elements.editDialog, 450, 200);
		ConfigureAdminDialog(elements.deleteDialog,  500, 200);

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
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.actions.deleteAccessory));
		ConfigureAdminForm(elements.form, getSubmitCallback(options.actions.edit));

		WireUpUnlimited(elements.addUnlimited, elements.addQuantity);
		WireUpUnlimited(elements.editUnlimited, elements.editQuantity);
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

	var deleteAccessory = function() {
		elements.deleteDialog.dialog('open');
	};

	var getActiveAccessory = function ()
	{
		return accessories[getActiveId()];
	};

	var WireUpUnlimited = function(checkbox, quantity)
	{
		checkbox.change(function(){
			if (checkbox.is(":checked"))
			{
				quantity.val('');
				quantity.attr('disabled', 'disabled');
			}
			else
			{
				quantity.removeAttr('disabled');
			}
		});
	};

	AccessoryManagement.prototype.addAccessory = function(id, name, quantity)
	{
		accessories[id] = {id: id, name: name, quantity: quantity};
	}
}