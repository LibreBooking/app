function ReservationColorManagement(opts)
{
	var options = opts;

	var elements = {
		deleteRuleId:$('#deleteRuleId'),
		attributeOption:$('#attributeOption'),

		colorDialog:$('#colorDialog'),
		colorValue:$('#reservationColor'),
		colorForm:$('#colorForm'),

		addDialog:$('#addDialog'),
		addForm:$('#addForm'),
		deleteDialog:$('#deleteDialog'),
		deleteForm:$('#deleteForm')
	};

	ReservationColorManagement.prototype.init = function ()
	{
		ConfigureAdminDialog(elements.addDialog);
		ConfigureAdminDialog(elements.deleteDialog);

		$(".save").click(function ()
		{
			$(this).closest('form').submit();
		});

		$(".cancel").click(function ()
		{
			$(this).closest('.dialog').dialog("close");
		});

		$(".delete").click(function()
		{
			elements.deleteRuleId.val($(this).attr('ruleId'));
			elements.deleteDialog.dialog('open');
		});

		$('#reservationColor').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
					$(el).ColorPickerHide();
				},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		});

		$('#addRuleButton').click(function(e){
			var attrId = '#attribute' + elements.attributeOption.val();
			$('#attributeFillIn').empty();
			$('#attributeFillIn').append($(attrId).clone().attr('style',' display:inline'));
			elements.addDialog.dialog('open');
		});

		ConfigureAsyncForm(elements.addForm, defaultSubmitCallback(elements.addForm))
		ConfigureAsyncForm(elements.deleteForm, defaultSubmitCallback(elements.deleteForm))
	};

	var defaultSubmitCallback = function (form)
	{
		return function()
		{
			return form.attr('action') + "?action=" + form.attr('ajaxAction');
		}
	};
}