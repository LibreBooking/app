function QuotaManagement(opts)
{
	var options = opts;
	
	var elements = {
		
		addForm: $('#addQuotaForm')
	
	};
	
	QuotaManagement.prototype.init = function()
	{
		//ConfigureAdminDialog(elements.deleteDialog,  300, 135);
		    
		$('.quotaList').each(function() {

			$(this).find('.delete').click(function(e) {
				elements.deleteForm.submit();
				$(this).after($('.indicator'));
			});
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.actions.addQuota), null, handleAddError);
	};

	var getSubmitCallback = function(action)
	{
		return function() {
			return options.submitUrl + "?qid=" + getActiveQuotaId() + "&action=" + action;
		};
	};

	var handleAddError = function(responseText)
	{
		alert(responseText);
	};

	var getActiveQuotaId = function()
	{
		return null;
	};
}