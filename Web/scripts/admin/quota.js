function QuotaManagement(opts)
{
	var options = opts;
	
	var elements = {
		
		addForm: $('#addQuotaForm'),
		deleteForm: $('#deleteQuotaForm'),
		deleteDialog: $('#deleteDialog')
	};

	var activeQuotaId = null;
	
	QuotaManagement.prototype.init = function()
	{
		$('.delete').click(function(e) {
			e.preventDefault();
			setActiveQuotaId($(this).attr('quotaId'));
			elements.deleteDialog.modal('show');
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').modal("hide");
		});

		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.actions.addQuota), null, handleAddError);
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.actions.deleteQuota), null, handleAddError);
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

	var setActiveQuotaId = function (quotaId)
	{
		activeQuotaId = quotaId
	};
	
	var getActiveQuotaId = function()
	{
		return activeQuotaId;
	};
}