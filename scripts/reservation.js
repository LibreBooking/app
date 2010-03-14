$(document).ready(function() {

	$('#dialogAddResources').dialog({
	    bgiframe: true, autoOpen: false, height: 100, modal: true,
	    open: function(event, ui) { InitialzeCheckboxes('#dialogAddResources', '#additionalResources'); return true; }
	});
	
	$('#btnConfirmAddResources').click(function(){   
	    AddSelected('#dialogAddResources', '#additionalResources');	
	});
	
	$('#btnClearAddResources').click(function(){   
		CancelAdd('#dialogAddResources', '#additionalResources');	
	});
});

function AddSelected(dialogBoxId, displayDivId)
{
	$(displayDivId).empty();
	
	$(dialogBoxId + ' :checked').each(function(){
		$(displayDivId).append('<p>' + $(this).next().text() + '</p>')
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