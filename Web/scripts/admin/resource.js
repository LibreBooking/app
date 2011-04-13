function ResourceManagement(opts)
{
	var options = opts;
	
	var elements = {
		activeId: $('#activeId'),
			
		renameDialog: $('#renameDialog'),
		descriptionDialog: $('#changeDescription'),
		
		renameForm: $('#renameForm'),
		descriptionForm: $('#descriptionForm'),
		
		addForm: $('#addScheduleForm')
	};
	
	var resources = new Object();
	
	ResourceManagement.prototype.init = function()
	{
		ConfigureAdminDialog(elements.renameDialog, 'Rename Resource', 300, 125);
		ConfigureAdminDialog(elements.descriptionDialog, 'Change Description', 500, 325);
		    
		$('.resourceDetails').each(function() {
			var id = $(this).find(':hidden.id').val();
			
			$(this).find('a.update').click(function() {
				setActiveResourceId(id);				
			});
			
			$(this).find('.renameButton').click(function(e) {
				showRename(e);
				return false;
			});
			
			$(this).find('.descriptionButton').click(function(e) {
				showChangeDescription(e);
				return false;
			});
			
			$(this).find('.changeButton').click(function(e) {
				showChangeSettings(e, daysVisible, dayOfWeek);
				return false;
			});

			$(this).find('.makeDefaultButton').click(function(e) {
				elements.makeDefaultForm.submit();
				$(this).after($('.indicator'));
			});
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		ConfigureAdminForm(elements.renameForm, getSubmitCallback(options.renameAction));
		ConfigureAdminForm(elements.descriptionForm, getSubmitCallback(options.changeDescriptionAction));
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
	
	var showRename = function(e)
	{
		elements.renameDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.renameDialog.dialog("open");
	};
	
	var showChangeDescription = function(e)
	{
		$('#editDescription').val(getActiveResource().description);
		elements.descriptionDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.descriptionDialog.dialog("open");
	};
	
	var showChangeConfiguration = function(e, daysVisible, dayOfWeek)
	{
		elements.daysVisible.val(daysVisible.val());
		elements.dayOfWeek.val(dayOfWeek.val());
		
		elements.changeSettingsDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.changeSettingsDialog.dialog("open");
	};
}