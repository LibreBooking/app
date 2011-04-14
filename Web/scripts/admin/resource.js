function ResourceManagement(opts)
{
	var options = opts;
	
	var elements = {
		activeId: $('#activeId'),
			
		renameDialog: $('#renameDialog'),
		imageDialog: $('#imageDialog'),
		scheduleDialog: $('#scheduleDialog'),
		locationDialog: $('#locationDialog'),
		descriptionDialog: $('#descriptionDialog'),
		notesDialog: $('#notesDialog'),
		
		renameForm: $('#renameForm'),
		imageForm: $('#imageForm'),
		scheduleForm: $('#scheduleForm'),
		locationForm: $('#locationForm'),
		descriptionForm: $('#descriptionForm'),
		notesForm: $('#notesForm'),
		
		addForm: $('#addScheduleForm')
	};
	
	var resources = new Object();
	
	ResourceManagement.prototype.init = function()
	{
		ConfigureAdminDialog(elements.renameDialog, 'Rename Resource', 300, 125);
		ConfigureAdminDialog(elements.imageDialog, 'Change Image', 500, 150);
		ConfigureAdminDialog(elements.scheduleDialog, 'Change Schedule', 300, 125);
		ConfigureAdminDialog(elements.locationDialog, 'Change Location', 300, 160);
		ConfigureAdminDialog(elements.descriptionDialog, 'Change Description', 500, 260);
		ConfigureAdminDialog(elements.notesDialog, 'Change Notes', 500, 260);
		    
		$('.resourceDetails').each(function() {
			var id = $(this).find(':hidden.id').val();
			
			$(this).find('a.update').click(function() {
				setActiveResourceId(id);				
			});
			
			$(this).find('.imageButton').click(function(e) {
				showChangeImage(e);
				return false;
			});
			
			$(this).find('.renameButton').click(function(e) {
				showRename(e);
				return false;
			});
			
			$(this).find('.changeScheduleButton').click(function(e) {
				showScheduleMove(e);
				return false;
			});
			
			$(this).find('.changeLocationButton').click(function(e) {
				showChangeLocation(e);
				return false;
			});
			
			$(this).find('.descriptionButton').click(function(e) {
				showChangeDescription(e);
				return false;
			});
			
			$(this).find('.notesButton').click(function(e) {
				showChangeNotes(e);
				return false;
			});
			

//			$(this).find('.makeDefaultButton').click(function(e) {
//				elements.makeDefaultForm.submit();
//				$(this).after($('.indicator'));
//			});
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		var imageSaveErrorHandler = function(result) { alert(result); };
		
		ConfigureAdminForm(elements.imageForm, getSubmitCallback(options.actions.changeImage), null, imageSaveErrorHandler);
		ConfigureAdminForm(elements.renameForm, getSubmitCallback(options.actions.rename), null, function(x){alert(x);});
		ConfigureAdminForm(elements.scheduleForm, getSubmitCallback(options.actions.changeSchedule));
		ConfigureAdminForm(elements.locationForm, getSubmitCallback(options.actions.changeLocation));
		ConfigureAdminForm(elements.descriptionForm, getSubmitCallback(options.actions.changeDescription));
		ConfigureAdminForm(elements.notesForm, getSubmitCallback(options.actions.changeNotes));
	};

	ResourceManagement.prototype.add = function(resource)
	{
		resources[resource.id] = resource;
	};
	
	var getSubmitCallback = function(action)
	{
		return function() {
			return options.submitUrl + "?sid=" + getActiveResourceId() + "&action=" + action;
		};
	};
	
	var setActiveResourceId = function(scheduleId)
	{
		elements.activeId.val(scheduleId);
	};
	
	var getActiveResourceId = function()
	{
		return elements.activeId.val();
	};
	
	var getActiveResource = function() 
	{
		return resources[getActiveResourceId()];
	};
	
	var showChangeImage = function(e)
	{
		elements.imageDialog.dialog("open");
	}
	
	var showRename = function(e)
	{
		$('#editName').val(getActiveResource().name);
//		elements.renameDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.renameDialog.dialog("open");
	};
	
	var showScheduleMove = function(e)
	{
		$('#editSchedule').val(getActiveResource().scheduleId);
		elements.scheduleDialog.dialog("open");
	};
	
	var showChangeLocation = function(e)
	{
		$('#editLocation').val(getActiveResource().location);
		$('#editContact').val(getActiveResource().contact);
		elements.locationDialog.dialog("open");
	};
	
	var showChangeDescription = function(e)
	{
		$('#editDescription').val(getActiveResource().description);
		elements.descriptionDialog.dialog("open");
	};
	
	var showChangeNotes = function(e)
	{
		$('#editNotes').val(getActiveResource().notes);
		elements.notesDialog.dialog("open");
	};
	
	var showChangeConfiguration = function(e, daysVisible, dayOfWeek)
	{
		elements.daysVisible.val(daysVisible.val());
		elements.dayOfWeek.val(dayOfWeek.val());
		
		elements.changeSettingsDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.changeSettingsDialog.dialog("open");
	};
}