function ResourceManagement(opts) {
	var options = opts;

	var elements = {
		activeId:$('#activeId'),

		//renameDialog:$('#renameDialog'),
		imageDialog:$('#imageDialog'),
		//scheduleDialog:$('#scheduleDialog'),
		//locationDialog:$('#locationDialog'),
		//descriptionDialog:$('#descriptionDialog'),
		//notesDialog:$('#notesDialog'),
		deleteDialog:$('#deletePrompt'),
		//configurationDialog:$('#configurationDialog'),
		groupAdminDialog:$('#groupAdminDialog'),
		//sortOrderDialog:$('#sortOrderDialog'),
		//resourceTypeDialog:$('#resourceTypeDialog'),
		statusDialog:$('#statusDialog'),
		durationDialog:$('#durationDialog'),
		capacityDialog:$('#capacityDialog'),

		//renameForm:$('#renameForm'),
		imageForm:$('#imageForm'),
		//scheduleForm:$('#scheduleForm'),
		//locationForm:$('#locationForm'),
		//descriptionForm:$('#descriptionForm'),
		//notesForm:$('#notesForm'),
		deleteForm:$('#deleteForm'),
		durationForm:$('#durationForm'),
		capacityForm:$('#capacityForm'),
		groupAdminForm:$('#groupAdminForm'),
		attributeForm:$('.attributesForm'),
		//sortOrderForm:$('#sortOrderForm'),
		statusForm:$('#statusForm'),
		//resourceTypeForm:$('#resourceTypeForm'),

		statusReasons:('.reasonId'),
		statusOptions:('.statusId'),
		addStatusReason:('.addStatusReason'),
		newStatusReason:('.newStatusReason'),
		existingStatusReason:('.existingStatusReason'),
		resourceStatusReason:('.resourceStatusReason'),
		addStatusIcon:('.addStatusIcon'),

		addForm:$('#addResourceForm'),
		statusOptionsFilter:$('#resourceStatusIdFilter'),
		statusReasonsFilter:$('#resourceReasonIdFilter'),
		filterTable:$('#filterTable'),
		filterButton:$('#filter'),
		clearFilterButton:$('#clearFilter'),

		bulkUpdatePromptButton:$('#bulkUpdatePromptButton'),
		bulkUpdateDialog:$('#bulkUpdateDialog'),
		bulkUpdateList:$('#bulkUpdateList'),
		bulkUpdateForm:$('#bulkUpdateForm'),
		bulkEditStatusOptions:$('#bulkEditStatusId'),
		bulkEditStatusReasons:$('#bulkEditStatusReasonId'),

		addResourceButton: $('#add-resource'),
		addResourceDialog:$('#add-resource-dialog')
	};

	var resources = {};
	var reasons = [];

	function initializeResourceUI(id, details)
	{
		var resource = getResource(id);
		if (resource.allowSubscription)
		{
			details.find('.disableSubscription').removeClass('hide');
		}
		else
		{
			details.find('.enableSubscription').removeClass('hide');
		}
	}

	ResourceManagement.prototype.init = function () {
		// todo make placeholders
		//$(".days").watermark('days');
		//$(".hours").watermark('hrs');
		//$(".minutes").watermark('mins');

		ConfigureAdminDialog(elements.imageDialog);
		//ConfigureAdminDialog(elements.configurationDialog);
		ConfigureAdminDialog(elements.groupAdminDialog);

		$('.resourceDetails').each(function () {
			var indicator = $('.indicator');
			var details = $(this);
			var id = details.attr('data-resourceId');

			initializeResourceUI(id, details);

			details.find('a.update').click(function (e) {
				e.preventDefault();
				setActiveResourceId(id);
			});

			details.find('.imageButton').click(function (e) {
				showChangeImage(e);
			});

			details.find('.removeImageButton').click(function (e) {
				PerformAsyncAction($(this), getSubmitCallback(options.actions.removeImage), indicator);
			});

			var subscriptionCallback = function ()
			{
				details.find('.subscriptionButton').toggleClass('hide')
			};

			details.find('.enableSubscription').click(function (e) {

				PerformAsyncAction($(this), getSubmitCallback(options.actions.enableSubscription), $('#subscriptionIndicator'), subscriptionCallback);
			});

			details.find('.disableSubscription').click(function (e) {
				PerformAsyncAction($(this), getSubmitCallback(options.actions.disableSubscription), $('#subscriptionIndicator'), subscriptionCallback);
			});

			details.find('.renameButton').click(function (e) {
				e.stopPropagation();
				details.find('.resourceName').editable('toggle');
			});

			details.find('.changeScheduleButton').click(function (e) {
				e.stopPropagation();
				details.find('.scheduleName').editable('toggle');
			});

			details.find('.changeResourceType').click(function (e) {
				e.stopPropagation();
				details.find('.resourceTypeName').editable('toggle');
			});

			details.find('.changeSortOrder').click(function (e) {
				e.stopPropagation();
				details.find('.sortOrderValue').editable('toggle');
			});

			details.find('.changeLocation').click(function (e) {
				e.stopPropagation();
				details.find('.locationValue').editable('toggle');
			});

			details.find('.changeContact').click(function (e) {
				e.stopPropagation();
				details.find('.contactValue').editable('toggle');
			});

			details.find('.changeDescription').click(function (e) {
				e.stopPropagation();
				details.find('.descriptionValue').editable('toggle');
			});

			details.find('.changeNotes').click(function (e) {
				e.stopPropagation();
				details.find('.notesValue').editable('toggle');
			});

			details.find('.adminButton').click(function (e) {
				showResourceAdmin(e);
			});

			details.find('.deleteButton').click(function (e) {
				showDeletePrompt(e);
			});

			details.find('.changeConfigurationButton').click(function (e) {
				showConfigurationPrompt(e);
			});

			details.find('.changeAttributes, .customAttributes .cancel').click(function (e) {
				var otherResources = $(".resourceDetails[data-resourceId!='" + id + "']");
				otherResources.find('.attribute-readwrite, .validationSummary').hide();
				otherResources.find('.attribute-readonly').show();
				var container = $(this).closest('.customAttributes');
				container.find('.attribute-readwrite').toggle();
				container.find('.attribute-readonly').toggle();
				container.find('.validationSummary').hide();
			});

			details.find('.changeStatus').click(function (e) {
				showStatusPrompt(e);
			});

			details.find('.changeDuration').click(function (e) {
				showDurationPrompt(e);
			});

			details.find('.changeCapacity').click(function (e) {
				showCapacityPrompt(e);
			});
		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.modal').modal("hide");
		});

		$(".cancelColorbox").click(function () {
			$('#bulkUpdateDialog').hide();
			$.colorbox.close();
		});

		elements.addResourceButton.click(function(e){
			e.preventDefault();
			elements.addResourceDialog.modal('show');
			$('#resourceName').focus();
		});

		elements.bulkEditStatusOptions.change(function(e){
			populateReasonOptions(elements.bulkEditStatusOptions.val(), elements.bulkEditStatusReasons);
		});

		elements.statusOptionsFilter.change(function(e){
			populateReasonOptions(elements.statusOptionsFilter.val(), elements.statusReasonsFilter);
		});

		elements.filterButton.click(filterResources);

		elements.clearFilterButton.click(function (e) {
			e.preventDefault();
			elements.filterTable.find('input,select,textarea').val('')

			filterResources();
		});

		elements.bulkUpdatePromptButton.click(function(e){
			e.preventDefault();

			var items = [];
			elements.bulkUpdateList.empty();
			$.each(resources, function (i, r) {
				items.push('<li><label><input type="checkbox" name="resourceId[]" checked="checked" value="' + r.id + '" /> ' + r.name + '</li>');
			});
			$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(elements.bulkUpdateList);

			wireUpCheckboxToggle(elements.bulkUpdateDialog);

			$('#bulkUpdateDialog').modal('show');
		});

		wireUpCheckboxToggle(elements.durationForm);

		var imageSaveErrorHandler = function (result) {
			alert(result);
		};

		var combineIntervals = function (jqForm, opts) {
			$(jqForm).find('.interval').each(function (i, v) {
				var id = $(v).attr('id');
				var d = $('#' + id + 'Days').val();
				var h = $('#' + id + 'Hours').val();
				var m = $('#' + id + 'Minutes').val();
				$(v).val(d + 'd' + h + 'h' + m + 'm');
				//console.log($(v).val());
			});
		};

		var attributesHandler = function(responseText, form) {
			if (responseText.ErrorIds && responseText.Messages.attributeValidator)
			{
				var messages =  responseText.Messages.attributeValidator.join('</li><li>');
				messages = '<li>' + messages + '</li>';
				var validationSummary = $(form).find('.validationSummary');
				validationSummary.find('ul').empty().append(messages);
				validationSummary.show();
			}
		};

		var errorHandler = function (result) {
			$("#globalError").html(result).show();
		};

		var bulkUpdateErrorHandler = function (result) {
			$("#bulkUpdateErrors").html(result).show();
		};

		ConfigureAdminForm(elements.imageForm, defaultSubmitCallback(elements.imageForm), null, imageSaveErrorHandler);
		ConfigureAdminForm(elements.addForm, defaultSubmitCallback(elements.addForm), null, handleAddError);
		ConfigureAdminForm(elements.deleteForm, defaultSubmitCallback(elements.deleteForm));
		ConfigureAdminForm(elements.durationForm, defaultSubmitCallback(elements.durationForm), null, onDurationSaved, {onBeforeSerialize:combineIntervals});
		ConfigureAdminForm(elements.capacityForm, defaultSubmitCallback(elements.capacityForm), null, onCapacitySaved);
		//ConfigureAdminForm(elements.groupAdminForm, defaultSubmitCallback(elements.groupAdminForm));
		ConfigureAdminForm(elements.bulkUpdateForm, defaultSubmitCallback(elements.bulkUpdateForm), null, bulkUpdateErrorHandler, {onBeforeSerialize:combineIntervals});

		$.each(elements.attributeForm, function(i,form){
			ConfigureAdminForm($(form), defaultSubmitCallback($(form)), null, attributesHandler, {validationSummary:null});
		});
	};

	ResourceManagement.prototype.add = function (resource) {
		resources[resource.id] = resource;
	};

	ResourceManagement.prototype.addStatusReason = function (id, statusId, description) {
		if (!(statusId in reasons))
		{
			reasons[statusId] = [];
		}

		reasons[statusId].push({id:id,description:description});
	};

	ResourceManagement.prototype.initializeStatusFilter = function (statusId, reasonId)	{
		elements.statusOptionsFilter.val(statusId);
		elements.statusOptionsFilter.trigger('change');
		elements.statusReasonsFilter.val(reasonId);
	};

	var getSubmitCallback = function (action) {
		return function () {
			return options.submitUrl + "?rid=" + getActiveResourceId() + "&action=" + action;
		};
	};

	var defaultSubmitCallback = function (form) {
		return function () {
			return options.submitUrl + "?action=" + form.attr('ajaxAction') + '&rid=' + getActiveResourceId();
		};
	};

	var setActiveResourceId = function (scheduleId) {
		elements.activeId.val(scheduleId);
	};

	var getActiveResourceId = function () {
		return elements.activeId.val();
	};

	var getResource = function(id)
	{
		return resources[id];
	};

	var getActiveResource = function () {
		return getResource(getActiveResourceId());
	};

	var showChangeImage = function (e) {
		elements.imageDialog.dialog("open");
	};

	var showResourceAdmin = function (e) {
		$('#adminGroupId').val(getActiveResource().adminGroupId);
		elements.groupAdminDialog.dialog("open");
	};

	var showDeletePrompt = function (e) {
		e.preventDefault();
		elements.deleteDialog.modal('show');
	};

	var showConfigurationPrompt = function (e) {

		wireUpCheckboxToggle(elements.configurationDialog);

		var resource = getActiveResource();

		setDaysHoursMinutes('#minDuration', resource.minLength, $('#noMinimumDuration'));
		setDaysHoursMinutes('#maxDuration', resource.maxLength, $('#noMaximumDuration'));
		setDaysHoursMinutes('#startNotice', resource.startNotice, $('#noStartNotice'));
		setDaysHoursMinutes('#endNotice', resource.endNotice, $('#noEndNotice'));
		setDaysHoursMinutes('#bufferTime', resource.bufferTime, $('#noBufferTime'));
		showHideConfiguration(resource.maxParticipants, $('#maxCapacity'), $('#unlimitedCapacity'));

		$('#allowMultiday').val(resource.allowMultiday);
		$('#requiresApproval').val(resource.requiresApproval);
		$('#autoAssign').val(resource.autoAssign);

		elements.configurationDialog.dialog("open");
	};

	var showDurationPrompt = function(e){
		var resource = getActiveResource();

		setDaysHoursMinutes('#minDuration', resource.minLength, $('#noMinimumDuration'));
		setDaysHoursMinutes('#maxDuration', resource.maxLength, $('#noMaximumDuration'));
		setDaysHoursMinutes('#bufferTime', resource.bufferTime, $('#noBufferTime'));
		$('#allowMultiDay').prop('checked', resource.allowMultiday && resource.allowMultiday == "1");

		elements.durationDialog.modal('show');
	};

	var showCapacityPrompt = function(e){
		var resource = getActiveResource();

		showHideConfiguration(resource.maxParticipants, $('#maxCapacity'), $('#unlimitedCapacity'));
		wireUpCheckboxToggle(elements.capacityDialog);
		elements.capacityDialog.modal('show');
	};

	var onDurationSaved = function (resultHtml)
	{
		var emptyIfZero = function(val)
		{
			if (val == 0)
			{
				return '';
			}
			return val;
		};

		var setDuration = function(container, resourceDuration){
			resourceDuration.value = container.attr('data-value');
			resourceDuration.days = emptyIfZero(container.attr('data-days'));
			resourceDuration.hours = emptyIfZero(container.attr('data-hours'));
			resourceDuration.minutes = emptyIfZero(container.attr('data-minutes'));
		};

		var resource = getActiveResource();
		var resourceDiv = $("div[data-resourceId=" + resource.id + "]");
		resourceDiv.find('.durationPlaceHolder').html(resultHtml);

		var result = resourceDiv.find('.durationPlaceHolder');
		var minDuration = result.find('.minDuration');
		var maxDuration = result.find('.maxDuration');
		var bufferTime = result.find('.bufferTime');

		setDuration(minDuration, resource.minLength);
		setDuration(maxDuration, resource.maxLength);
		setDuration(bufferTime, resource.bufferTime);
		resource.allowMultiday = bufferTime.attr('data-value');

		elements.durationDialog.modal('hide');
	};

	var onCapacitySaved = function(resultHtml)
	{
		var resource = getActiveResource();
		var resourceDiv = $("div[data-resourceId=" + resource.id + "]");
		resourceDiv.find('.capacityPlaceHolder').html(resultHtml);

		var result = resourceDiv.find('.capacityPlaceHolder');
		var maxParticipants = result.find('.maxParticipants');
		resource.maxParticipants = maxParticipants.attr('data-value');

		elements.capacityDialog.modal('hide');
	};

	var showStatusPrompt = function (e) {
		var resource = getActiveResource();
		var statusForm = $('.popover:visible').find('form');

		var statusOptions = statusForm.find(elements.statusOptions);
		var statusReasons = statusForm.find(elements.statusReasons);
		var addStatusReason = statusForm.find(elements.addStatusReason);
		var saveButton = statusForm.find('.save');

		statusOptions.val(resource.statusId);
		statusReasons.val(resource.reasonId);

		statusOptions.unbind();
		statusOptions.change(function(e){
			populateReasonOptions(statusOptions.val(), statusReasons);
		});

		populateReasonOptions(statusOptions.val(), statusReasons);

		addStatusReason.unbind();
		addStatusReason.click(function(e){
			e.preventDefault();
			statusForm.find(elements.newStatusReason).toggleClass('no-show');
			statusForm.find(elements.existingStatusReason).toggleClass('no-show');

			if (statusForm.find(elements.newStatusReason).hasClass('no-show')){
				statusForm.find(elements.statusReasons).data('prev', statusReasons.val());
				statusForm.find(elements.statusReasons).val('');
				statusForm.find(elements.resourceStatusReason).focus();
			}
			else{
				statusForm.find(elements.statusReasons).val(statusReasons.data('prev'));
				statusForm.find(elements.statusReasons).focus();
			}
		});

		saveButton.unbind();

		ConfigureAdminForm(statusForm, defaultSubmitCallback(statusForm));

		saveButton.click(function() {
			statusForm.submit();
		});

		statusOptions.focus();
	};

	function populateReasonOptions(statusId, reasonsElement){
		reasonsElement.empty().append($('<option>', {value:'', text:'-'}));

		if (statusId in reasons)
		{
			$.each(reasons[statusId], function(i, v){
				reasonsElement.append($('<option>', {
						value: v.id,
						text : v.description
					}));
			});
		}
	}

	function setDaysHoursMinutes(elementPrefix, interval, attributeCheckbox) {
		$(elementPrefix + 'Days').val(interval.days);
		$(elementPrefix + 'Hours').val(interval.hours);
		$(elementPrefix + 'Minutes').val(interval.minutes);
		showHideConfiguration(interval.value, $(elementPrefix), attributeCheckbox);
	}

	function showHideConfiguration(attributeValue, attributeDisplayElement, attributeCheckbox) {
		attributeDisplayElement.val(attributeValue);
		var selector = attributeCheckbox.attr('data-related-inputs');
		var container = attributeCheckbox.closest('form');
		var span = container.find(selector);

		if (attributeValue == '' || attributeValue == undefined) {
			attributeCheckbox.prop('checked', true);
			span.hide();
		}
		else {
			attributeCheckbox.prop('checked', false);
			span.show();
		}
	}

	function wireUpCheckboxToggle(container) {
		container.find(':checkbox').change(function ()
		{
			var selector = $(this).attr('data-related-inputs');
			var span = container.find(selector);

			if ($(this).is(":checked"))
			{
				span.find("input[type=text],input[type=number]").val('');
				span.hide();
			}
			else
			{
				span.show();
			}
		});
	}

	function filterResources() {
		window.location = document.location.pathname + '?' + $('#filterForm').serialize();
	}

	var handleAddError = function (result) {
		$('#addResourceResults').text(result).show();
	};
}