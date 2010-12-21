function Reservation(opts)
{
	var options = opts;
	
	Reservation.prototype.init = function()
	{
		$('#dialogAddResources').dialog({
		    bgiframe: true, autoOpen: false, 
		    height: 300, modal: true,
		    open: function(event, ui) { InitialzeCheckboxes('#dialogAddResources', '#additionalResources'); return true; }
		});
		
		$('#btnClearAddResources').click(function(){   
			CancelAdd('#dialogAddResources', '#additionalResources');	
		});
		
		$('#dialogSave').dialog({
		    autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		    minHeight: 400, minWidth: 700, width: 700,
		    open: function(event, ui) {  $(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide(); }
		});
		
		$('.save').click(function(){
			$('#dialogSave').dialog('open');
		});
		
		$('#btnConfirmAddResources').click(function() {
			AddResources();
		});
		
		$('btnConfirmAddResources').click();
		
		$('#repeatOptions').change(function() { 
			ChangeRepeatOptions($(this));
		});
		
		InitializeRepeatOptions();
	}
	
	// pre-submit callback 
	Reservation.prototype.preSubmit = function(formData, jqForm, options) { 
	    $('#result').hide();
	    $('#creatingNotifiation').show();
	    
	    return true; 
	} 
	
	// post-submit callback 
	Reservation.prototype.showResponse = function(responseText, statusText, xhr, $form)  { 
		$('#btnSaveSuccessful').click(function(e) {
			window.location = options.returnUrl;
		});
		
		$('#btnSaveFailed').click(function() {
			CloseSaveDialog();
		});
		
		$('#creatingNotifiation').hide();
	    $('#result').show();
	}
	
	var AddResources = function(inputId)
	{
		AddSelected('#dialogAddResources', '#additionalResources', options.additionalResourceElementId);
		$('#dialogAddResources').dialog('close');
	}

	var AddSelected = function(dialogBoxId, displayDivId, inputId)
	{
		$(displayDivId).empty();
		
		$(dialogBoxId + ' :checked').each(function(){
			$(displayDivId)
				.append('<p>' + $(this).next().text() + '</p>')
				.append('<input type="hidden" name="' + inputId + '[]" value="' + $(this).val() + '"/>')
		});
		
		$(dialogBoxId).dialog('close');
	}

	var CancelAdd = function(dialogBoxId, displayDivId)
	{
		var selectedItems = $.makeArray($(displayDivId + ' p').text());
		$(dialogBoxId + ' :checked').each(function(){
			var checkboxText = $(this).next().text();
			if ($.inArray(checkboxText, selectedItems) < 0)
			{
				$(this).removeAttr('checked');
			}
		});
		
		$(dialogBoxId).dialog('close');
	}
	
	var ChangeRepeatOptions = function(repeatDropDown)
	{
		if (repeatDropDown.val() != 'none')
    	{
    		$('#repeatUntilDiv').show();
    	}
    	else
    	{
    		$('#repeatDiv div[id!=repeatOptions]').hide();
    	}
    	
    	if (repeatDropDown.val() == 'daily')
    	{
    		$('#repeatDiv .weeks').hide();
    		$('#repeatDiv .months').hide();
    		$('#repeatDiv .years').hide();
    		
    		$('#repeatDiv .days').show();	
    	}
    	
    	if (repeatDropDown.val() == 'weekly')
    	{
    		$('#repeatDiv .days').hide();
    		$('#repeatDiv .months').hide();
    		$('#repeatDiv .years').hide();
    		
    		$('#repeatDiv .weeks').show();	
    	}
    	
    	if (repeatDropDown.val() == 'monthly')
    	{
    		$('#repeatDiv .days').hide();
    		$('#repeatDiv .weeks').hide();
    		$('#repeatDiv .years').hide();
    		
    		$('#repeatDiv .months').show();	
    	}
    	
    	if (repeatDropDown.val() == 'yearly')
    	{
    		$('#repeatDiv .days').hide();
    		$('#repeatDiv .weeks').hide();
    		$('#repeatDiv .months').hide();
    		
    		$('#repeatDiv .years').show();	
    	}
	}

	var InitialzeCheckboxes = function(dialogBoxId, displayDivId)
	{
		var selectedItems = $.makeArray($(displayDivId + ' p').text());
		$(dialogBoxId + ' :checkbox').each(function(){
			var checkboxText = $(this).next().text();
			if ($.inArray(checkboxText, selectedItems) >= 0)
			{
				$(this).attr('checked', 'checked');
			}
			else
			{
				$(this).removeAttr('checked');
			}
		});
	}
	
	var InitializeRepeatOptions = function()
	{
		if (options.repeatType)
		{
			$('#repeatOptions').val(options.repeatType);
			$('#repeat_every').val(options.repeatInterval);
			for (var i = 0; i < options.repeatWeekdays.length; i++)
			{
				var id = "#repeatDay" + i;
				$(id).attr('checked', true);
			}
			
			$("#repeatOnMonthlyDiv :radio[value='" + options.repeatMonthlyType + "']").attr('checked', true);
			
			$('#repeatOptions').trigger('change');
		}
	}

	var CloseSaveDialog = function()
	{
		$('#dialogSave').dialog('close');
	}
	
	
}