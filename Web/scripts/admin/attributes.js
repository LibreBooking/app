function AttributeManagement(opts)
{
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

	function RefreshAttributeList()
	{
		var categoryId = elements.attributeCategory.val();

		$.ajax({
			url: opts.changeCategoryUrl + categoryId,
			cache: false,
			beforeSend: function ()
			{
				$('#indicator').show().insertBefore(elements.attributeList);
				$(elements.attributeList).html('');
			}
		}).done(function (data)
		{
			$('#indicator').hide();
			$(elements.attributeList).html(data)
		});
	}

	AttributeManagement.prototype.init = function ()
	{
		ConfigureAdminDialog(elements.addDialog);
		ConfigureAdminDialog(elements.editDialog);
		ConfigureAdminDialog(elements.deleteDialog);

		$(".save").click(function ()
		{
			$(this).closest('form').submit();
		});

		$(".cancel").click(function ()
		{
			$(this).closest('.dialog').dialog("close");
		});

		RefreshAttributeList();

		elements.attributeCategory.change(function ()
		{
			RefreshAttributeList();
		});

		elements.attributeList.delegate('a.update', 'click', function (e)
		{
			e.preventDefault();
			e.stopPropagation();
		});

		$('#addAttributeButton').click(function (e)
		{
			e.preventDefault();
			$('span.error', elements.addDialog).remove();
			elements.addCategory.val(elements.attributeCategory.val());
			elements.limitScope.removeAttr('checked');
			toggleAppliesTo();
			elements.appliesTo.text(options.allText);
			elements.secondaryPrompt.text(options.allText);
			elements.appliesToId.val('');
			elements.addDialog.dialog('open');
		});

		elements.attributeType.change(function ()
		{
			showRelevantAttributeOptions($(this).val(), elements.addDialog);
		});

		elements.attributeList.delegate('.editable', 'click', function (e)
		{
			e.preventDefault();
			var attributeId = $(this).attr('attributeId');
			var dataList = elements.attributeList.data('list');
			var selectedAttribute = dataList[attributeId];

			showEditDialog(selectedAttribute);
		});

		elements.attributeList.delegate('.delete', 'click', function (e)
		{
			e.preventDefault();
			var attributeId = $(this).attr('attributeId');

			showDeleteDialog(attributeId);
		});

		elements.appliesTo.click(function (e)
		{
			e.preventDefault();
			showEntities($(this), elements.attributeCategory.val());

			onEntityChoiceClick = function (e)
			{
				e.preventDefault();
				elements.entityChoices.hide();
				elements.appliesToId.val($(e.target).attr('entity-id'));
				elements.appliesTo.text($(e.target).text());
			}
		});

		$(document).mouseup(function (e)
		{
			var container = elements.entityChoices;

			if (!container.is(e.target) && container.has(e.target).length === 0)
			{
				container.hide();
			}
		});

		elements.entityChoices.delegate('a', 'click', function (e) {
			onEntityChoiceClick(e);
		});

		elements.limitScope.change(function (e) {
			elements.attributeSecondary.hide();
			if ($(this).is(':checked'))
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
			}
		});

		ConfigureAdminForm(elements.addForm, defaultSubmitCallback, addAttributeHandler);
		ConfigureAdminForm(elements.form, defaultSubmitCallback, editAttributeHandler);
		ConfigureAdminForm(elements.deleteForm, defaultSubmitCallback, deleteAttributeHandler);

	};

	var onEntityChoiceClick = function (e){	};

	var showRelevantAttributeOptions = function (selectedType, optionsDiv)
	{
		$('.textBoxOptions', optionsDiv).find('div').show();

		if (selectedType != opts.selectList)
		{
			$('.attributePossibleValues').hide();
		}

		if (selectedType == opts.selectList)
		{
			$('.attributeValidationExpression').hide();
		}

		if (selectedType == opts.checkbox)
		{
			$('div', ".textBoxOptions").hide();
			$('.attributeLabel').show();
			$('.attributeSortOrder').show();
		}
	};

	var addAttributeHandler = function ()
	{
		elements.addForm.resetForm();
		elements.addDialog.dialog('close');
		RefreshAttributeList();
	};

	var editAttributeHandler = function ()
	{
		elements.form.resetForm();
		elements.editDialog.dialog('close');
		RefreshAttributeList();
	};

	var deleteAttributeHandler = function ()
	{
		elements.deleteDialog.dialog('close');
		RefreshAttributeList();
	};

	var showEditDialog = function (selectedAttribute)
	{
		showRelevantAttributeOptions(selectedAttribute.type, elements.editDialog);
		toggleAppliesTo();

		$('.editAttributeType', elements.editDialog).hide();
		$('#editType' + selectedAttribute.type).show();

		$('#editAttributeLabel').val(selectedAttribute.label);
		$('#editAttributeRequired').removeAttr('checked');
		if (selectedAttribute.required)
		{
			$('#editAttributeRequired').attr('checked', 'checked');
		}
		$('#editAttributeUnique').removeAttr('checked');
		if (selectedAttribute.unique)
		{
			$('#editAttributeUnique').attr('checked', 'checked');
		}
		$('#editAttributeRegex').val(selectedAttribute.regex);
		$('#editAttributePossibleValues').val(selectedAttribute.possibleValues);
		$('#editAttributeSortOrder').val(selectedAttribute.sortOrder);
		$('#editAttributeEntityId').val(selectedAttribute.entityId);

		if (selectedAttribute.entityDescription == '')
		{
			elements.appliesTo.text(options.allText);
			elements.appliesToId.val('');
		}
		else
		{
			elements.appliesTo.text(selectedAttribute.entityDescription);
			elements.appliesToId.val(selectedAttribute.entityId);
		}

		$('#editAttributeAdminOnly').removeAttr('checked');
		if (selectedAttribute.adminOnly)
		{
			$('#editAttributeAdminOnly').attr('checked', 'checked');
		}

		var limitScope = $('#editAttributeLimitScope');
		limitScope.removeAttr('checked');
		$('#editAttributeSecondaryCategory').val('');
		$('#editAttributeSecondaryEntityId').val('');
		elements.secondaryPrompt.text(options.allText);
		if (selectedAttribute.secondaryEntityId)
		{
			limitScope.attr('checked', 'checked');
			limitScope.trigger('change');
			$('#editAttributeSecondaryCategory').val(selectedAttribute.secondaryCategory);
			$('#editAttributeSecondaryEntityId').val(selectedAttribute.secondaryEntityId);
			$('.secondaryPrompt').text(selectedAttribute.secondaryEntityDescription);

		}

		$('#editAttributePrivate').prop('checked', selectedAttribute.isPrivate);

		setActiveId(selectedAttribute.id);

		elements.editDialog.dialog('open');
	};

	var showDeleteDialog = function (selectedAttributeId)
	{
		setActiveId(selectedAttributeId);
		elements.deleteDialog.dialog('open');
	};

	var defaultSubmitCallback = function (form)
	{
		return options.submitUrl + "?aid=" + getActiveId() + "&action=" + form.attr('ajaxAction');
	};

	function setActiveId(id)
	{
		elements.activeId.val(id);
	}

	function getActiveId()
	{
		return elements.activeId.val();
	}

	var toggleAppliesTo = function ()
	{
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
			$('.attributeAdminOnly').hide();
			$('.secondaryEntities, .attributeSecondary').hide();
			$('.attributeIsPrivate').hide();
		}
	};

	var showEntities = function (element, categoryId)
	{
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

		var items = ['<li><a href="#" entity-id="">' + options.allText + '</a></li>'];
		$.each(data, function (index, item)
		{
			items.push('<li><a href="#" entity-id="' + item.Id + '">' + item.Name + '</a></li>');
		});

		elements.entityChoices.empty();

		$('<ul/>', {'class': '', html: items.join('')}).appendTo(elements.entityChoices);
	};

	var getResources = function ()
	{
		var items = [];
		$.ajax({
					url: options.resourcesUrl,
					async: false
				}
		).done(function (data)
				{
					items = data;
				});

		return items;
	};

	var getUsers = function ()
	{
		var items = [];
		$.ajax({
					url: options.usersUrl,
					async: false
				}
		).done(function (data)
				{
					items = $.map(data, function (item, index)
					{
						return {Id: item.UserId, Name: item.FullName};
					});
				});

		return items;
	};

	var getResourceTypes = function ()
	{
		var items = [];
		$.ajax({
					url: options.resourceTypesUrl,
					async: false
				}
		).done(function (data)
				{
					items = $.map(data, function (item, index)
					{
						return {Id: item.Id, Name: item.Name};
					});
				});

		return items;
	}
}