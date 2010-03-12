$(document).ready(function() {

	$("#dialogAddResources").dialog({
	    bgiframe: true, autoOpen: false, height: 100, modal: true
	});
	    
	$("#btnClearAddResources").click(function(){   
	    ClearSelected('#dialogAddResources');	
	});
	
	$("#dialogAddResources :checkbox").click(function(){   
		AddCheckbox(this);
	});
});

function ClearSelected(dialogBoxId)
{
	
	$(dialogBox + ":checkbox").change();
	//alert(dialogBox);
	//dialogBox.dialog('close');

	//alert(dialogBox);
}

function AddCheckbox(box)
{
	alert(box);
}