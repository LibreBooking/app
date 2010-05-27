$(document).ready(function() {

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
	
});

function AddResources(inputId)
{
	AddSelected('#dialogAddResources', '#additionalResources', inputId);
	$('#dialogAddResources').dialog('close');
}

function AddSelected(dialogBoxId, displayDivId, inputId)
{
	$(displayDivId).empty();
	
	$(dialogBoxId + ' :checked').each(function(){
		$(displayDivId)
			.append('<p>' + $(this).next().text() + '</p>')
			.append('<input type="hidden" name="' + inputId + '[]" value="' + $(this).val() + '"/>')
	});
	
	$(dialogBoxId).dialog('close');
}

function CancelAdd(dialogBoxId, displayDivId)
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

function InitialzeCheckboxes(dialogBoxId, displayDivId)
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

function CloseSaveDialog()
{
	$('#dialogSave').dialog('close');
}