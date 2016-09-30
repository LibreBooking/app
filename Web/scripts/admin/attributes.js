function AttributeManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		attributeList: $('#attributeList'),

		attributeCategory: $('#attributeCategory'),
		addCategory: $('#addCategory'),
		attributeType: $('#attributeType'),
		appliesTo: $('.appliesTo'),
		appliesToId: $('.appliesToId'),
		entityChoices: $('#entityChoices'),

		editName: $('#editName'),
		editUnlimited: $('#chkUnlimitedEdit'),
		editQuantity: $('#editQuantity'),

		addDialog: $('#addAttributeDialog'),
		editDialog: $('#editAttributeDialog'),
		deleteDialog: $('#deleteDialog'),

		addForm: $('#addAttributeForm'),
		form: $('#editAttributeForm'),
		deleteForm: $('#deleteForm'),

		limitScope: $('.limitScope'),
		attributeSecondary: $('.attributeSecondary'),
		secondaryPrompt: $('.secondaryPrompt')
	};

	function RefreshAttributeList() {
		var categoryId = elements.attributeCategory.val();

		$.ajax({
			url: opts.changeCategoryUrl + categoryId,
			cache: false,
			beforeSend: function () {
				$('#indicator').removeClass('no-show').insertBefore(elements.attributeList);
				$(elements.attributeList).html('');
			}
		}).done(function (data) {
			$('#indicator').addClass('no-show');
			$(elements.attributeList).html(data);
		});
	}

	AttributeManagement.prototype.init = function () {

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});

		RefreshAttributeList();

		elements.attributeCategory.change(function () {
			RefreshAttributeList();
		});

		elements.attributeList.delegate('a.update', 'click', function (e) {
			e.preventDefault();
			e.stopPropagation();
		});

		$('#addAttributeButton').click(function (e) {
			e.preventDefault();
			$('span.error', elements.addDialog).remove();
			elements.addCategory.val(elements.attributeCategory.val());
			elements.limitScope.prop('checked', false);
			showRelevantCategoryOptions();
			elements.appliesTo.text(options.allText);
			elements.secondaryPrompt.text(options.allText);
			elements.appliesToId.val('');
			elements.addDialog.modal('show');
		});

		elements.attributeType.change(function () {
			showRelevantAttributeOptions($(this).val(), elements.addDialog);
		});

		elements.attributeList.delegate('.edit', 'click', function (e) {
			e.preventDefault();
			var attributeId = $(this).closest('tr').attr('attributeId');
			var dataList = elements.attributeList.data('list');
			var selectedAttribute = dataList[attributeId];

			showEditDialog(selectedAttribute);
		});

		elements.attributeList.delegate('.delete', 'click', function (e) {
			e.preventDefault();
			var attributeId = $(this).closest('tr').attr('attributeId');

			showDeleteDialog(attributeId);
		});

		elements.appliesTo.click(function (e) {
			e.preventDefault();
			showEntities(elements.appliesTo, elements.attributeCategory.val());

			onEntityChoiceClick = function (e) {
				e.preventDefault();
				elements.entityChoices.hide();
				elements.appliesToId.val($(e.target).attr('entity-id'));
				elements.appliesTo.text($(e.target).text());
			};
		});

		$(document).mouseup(function (e) {
			var container = elements.entityChoices;

			if (!container.is(e.target) && container.has(e.target).length === 0)
			{
				container.hide();
			}
		});

		elements.entityChoices.delegate('a.all', 'click', function (e) {
			onEntityChoiceClick(e);
		});

		elements.entityChoices.delegate('a.ok', 'click', function (e) {
			e.preventDefault();
			elements.entityChoices.hide();
			handleEntitiesSelected();
		});

		elements.limitScope.change(function (e) {
			elements.attributeSecondary.hide();
			if (elements.limitScope.is(':checked'))
			{
				elements.attributeSecondary.show();
			}
		});

		elements.secondaryPrompt.click(function (e) {
			e.preventDefault();
			showEntities($(this), $(this).closest('.textBoxOptions').find('.secondaryAttributeCategory').val());
			onEntityChoiceClick = function (e) {
				e.preventDefault();
				elements.entityChoices.hide();
				$('.secondaryEntityId').val($(e.target).attr('entity-id'));
				$('.secondaryPrompt').text($(e.target).text());
			};
		});

		ConfigureAsyncForm(elements.addForm, defaultSubmitCallback, addAttributeHandler);
		ConfigureAsyncForm(elements.form, defaultSubmitCallback, editAttributeHandler);
		ConfigureAsyncForm(elements.deleteForm, defaultSubmitCallback, deleteAttributeHandler);

	};

	function handleEntitiesSelected() {
		elements.appliesToId.empty();
		var entities = elements.entityChoices.find(':checked');
		elements.appliesToId.append(entities);
		if (entities.length > 0)
		{
			elements.appliesTo.text(entities.length);
		}
		else
		{
			elements.appliesTo.text(opts.allText);
		}
	}

	var onEntityChoiceClick = function (e) {
		e.preventDefault();
		elements.entityChoices.hide();
		elements.appliesToId.empty();
		elements.entityChoices.find('input:checkbox').removeAttr('checked');
		elements.appliesTo.text(opts.allText);
	};

	var showRelevantAttributeOptions = function (selectedType, optionsDiv) {
		$('.textBoxOptions', optionsDiv).find('div').not('.attributeUnique, .attributeSecondary').show();

		if (selectedType != opts.selectList)
		{
			$('.attributePossibleValues').hide();
		}

		if (selectedType == opts.selectList || selectedType == opts.date)
		{
			$('.attributeValidationExpression').hide();
		}

		if (selectedType == opts.checkbox)
		{
			$('.attributePossibleValues, .attributeValidationExpression').hide();
		}

		showRelevantCategoryOptions();
		//if (elements.attributeCategory.val() == options.categories.reservation)
		//{
		//	$('.attributeUnique').hide();
		//}
	};

	var addAttributeHandler = function () {
		elements.addForm.resetForm();
		elements.addDialog.modal('hide');
		RefreshAttributeList();
	};

	var editAttributeHandler = function () {
		elements.form.resetForm();
		elements.editDialog.modal('hide');
		RefreshAttributeList();
	};

	var deleteAttributeHandler = function () {
		elements.deleteDialog.modal('hide');
		RefreshAttributeList();
	};

	var showEditDialog = function (selectedAttribute) {
		showRelevantAttributeOptions(selectedAttribute.type, elements.editDialog);
		showRelevantCategoryOptions();

		$('.editAttributeType', elements.editDialog).hide();
		$('#editType' + selectedAttribute.type).show();

		$('#editAttributeLabel').val(HtmlDecode(selectedAttribute.label));
		$('#editAttributeRequired').prop('checked', selectedAttribute.required);
		$('#editAttributeUnique').prop('checked', selectedAttribute.unique);
		$('#editAttributeAdminOnly').prop('checked', selectedAttribute.adminOnly);

		$('#editAttributeRegex').val(selectedAttribute.regex);
		$('#editAttributePossibleValues').val(selectedAttribute.possibleValues);
		$('#editAttributeSortOrder').val(selectedAttribute.sortOrder);
		$('#editAttributeEntityId').val(selectedAttribute.entityId);

		elements.entityChoices.empty();
		if (selectedAttribute.entityDescriptions.length == 0)
		{
			elements.appliesTo.text(options.allText);
			elements.appliesToId.val('');
		}
		else
		{
			$.each(selectedAttribute.entityIds, function (i, id) {
				elements.entityChoices.append($('<input type="checkbox" name="ATTRIBUTE_ENTITY[]" value="' + id + '" checked="checked"/>'));
			});
			handleEntitiesSelected();
			elements.appliesToId.hide();
		}

		var limitScope = $('#editAttributeLimitScope');
		limitScope.prop('checked', false);

		$('#editAttributeSecondaryEntityId').val('');
		elements.secondaryPrompt.text(options.allText);
		if (selectedAttribute.secondaryEntityId)
		{
			limitScope.prop('checked', true);
			limitScope.trigger('change');
			$('#editAttributeSecondaryCategory').val(selectedAttribute.secondaryCategory);
			$('#editAttributeSecondaryEntityId').val(selectedAttribute.secondaryEntityId);
			$('.secondaryPrompt').text(selectedAttribute.secondaryEntityDescription);
		}

		$('#editAttributePrivate').prop('checked', selectedAttribute.isPrivate);

		setActiveId(selectedAttribute.id);

		elements.editDialog.modal('show');
	};

	var showDeleteDialog = function (selectedAttributeId) {
		setActiveId(selectedAttributeId);
		elements.deleteDialog.modal('show');
	};

	var defaultSubmitCallback = function (form) {
		return options.submitUrl + "?aid=" + getActiveId() + "&action=" + form.attr('ajaxAction');
	};

	function setActiveId(id) {
		elements.activeId.val(id);
	}

	function getActiveId() {
		return elements.activeId.val();
	}

	var showRelevantCategoryOptions = function () {
		if (elements.attributeCategory.val() == options.categories.reservation)
		{
			$('.attributeUnique').hide();
			$('.attributeAdminOnly').show();
			$('.secondaryEntities, .attributeSecondary').hide();
			$('.secondaryEntities').show();
			$('.attributeIsPrivate').show();
		}
		else
		{
			$('.attributeUnique').show();
			//$('.attributeAdminOnly').hide();
			$('.secondaryEntities, .attributeSecondary').hide();
			$('.attributeIsPrivate').hide();
		}
	};

	var showEntities = function (element, categoryId) {
		var selectedIds = [];
		elements.appliesToId.find(':checked').each(function (i, v) {
			selectedIds.push($(v).val());
		});

		elements.entityChoices.empty();
		elements.entityChoices.css({left: element.offset().left, top: element.offset().top + element.height()});
		elements.entityChoices.show();

		$('<div class="ajax-indicator">&nbsp;</div>"').appendTo(elements.entityChoices).show();

		var data = [];

		if (categoryId == options.categories.resource)
		{
			data = getResources();
		}

		if (categoryId == options.categories.user)
		{
			data = getUsers();
		}

		if (categoryId == options.categories.resource_type)
		{
			data = getResourceTypes();
		}

		var items = ['<li><a href="#" class="all">' + options.allText + '</a> <a href="#" class="ok">OK</a></li>'];
		$.each(data, function (index, item) {
			var checked = '';
			if (selectedIds.indexOf(item.Id) != -1)
			{
				checked = ' checked="checked" '
			}
			items.push('<li><label><input type="checkbox" name="ATTRIBUTE_ENTITY[]" value="' + item.Id + '"' + checked + '/>' + item.Name + '</label></li>');
		});

		elements.entityChoices.empty();

		$('<div/>', {'class': '', html: items.join('')}).appendTo(elements.entityChoices);
	};

	var getResources = function () {
		var items = [];
		$.ajax({
					url: options.resourcesUrl,
					async: false
				}
		).done(function (data) {
					items = data;
				});

		return items;
	};

	var getUsers = function () {
		var items = [];
		$.ajax({
					url: options.usersUrl,
					async: false
				}
		).done(function (data) {
					items = $.map(data, function (item, index) {
						return {Id: item.UserId, Name: item.FullName};
					});
				});

		return items;
	};

	var getResourceTypes = function () {
		var items = [];
		$.ajax({
					url: options.resourceTypesUrl,
					async: false
				}
		).done(function (data) {
					items = $.map(data, function (item, index) {
						return {Id: item.Id, Name: item.Name};
					});
				});

		return items;
	}
}