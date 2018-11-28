function AttributeManagement(opts) {
    var options = opts;

    var elements = {
        activeId: $('#activeId'),
        attributeList: $('#attributeList'),

        attributeCategory: $('#attributeCategory'),
        addCategory: $('#addCategory'),
        attributeType: $('#attributeType'),
        appliesTo: $('#appliesTo'),
        editAppliesTo: $('#editAppliesTo'),
        appliesToId: $('.appliesToId'),
        entityChoices: $('#entityChoices'),
        editEntityChoices: $('#editEntityChoices'),

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
        secondaryPrompt: $('.secondaryPrompt'),
        secondaryAttributeCategory: $('.secondaryAttributeCategory ')
    };

    function RefreshAttributeList() {
        var categoryId = elements.attributeCategory.val();

        $.ajax({
            url: opts.changeCategoryUrl + categoryId, cache: false, beforeSend: function () {
                $('#indicator').removeClass('no-show').insertBefore(elements.attributeList);
                $(elements.attributeList).html('');
            }
        }).done(function (data) {
            $('#indicator').addClass('no-show');
            $(elements.attributeList).html(data);
        });
    }

    var currentAttributeEntities = {entityIds: [], secondaryEntityIds: []};
    var selectedEntityChoices = $('#entityChoices, #editEntityChoices');
    var activeAppliesTo;
    var updateEntityCallback = function () {
    };

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

        elements.attributeList.delegate('.delete', 'click', function (e) {
            e.preventDefault();
            var attributeId = $(this).closest('tr').attr('attributeId');

            showDeleteDialog(attributeId);
        });

        $('#addAttributeButton').click(function (e) {
            e.preventDefault();
            selectedEntityChoices = elements.entityChoices;
            currentAttributeEntities.entityIds = [];
            currentAttributeEntities.secondaryEntityIds = [];
            $('span.error', elements.addDialog).remove();
            elements.addDialog.find(':text, :input[type="number"]').val('');
            elements.addCategory.val(elements.attributeCategory.val());
            elements.attributeType.trigger('change');
            elements.limitScope.prop('checked', false);
            showRelevantCategoryOptions();
            elements.appliesTo.text(options.allText);
            elements.secondaryPrompt.text(options.allText);
            elements.appliesToId.val('');
            elements.addDialog.modal('show');
        });

        elements.attributeType.on('change', function () {
            showRelevantAttributeOptions($(this).val(), elements.addDialog);
        });

        elements.attributeList.delegate('.edit', 'click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            selectedEntityChoices = elements.editEntityChoices;
            var attributeId = $(this).closest('tr').attr('attributeId');
            var dataList = elements.attributeList.data('list');
            var selectedAttribute = dataList[attributeId];

            currentAttributeEntities.entityIds = selectedAttribute.entityIds;
            currentAttributeEntities.secondaryEntityIds = selectedAttribute.secondaryEntityIds;

            showEditDialog(selectedAttribute);
        });

        $('#appliesTo, #editAppliesTo').click(function (e) {
            e.preventDefault();
            activeAppliesTo = $(this);

            showEntities($(this), elements.attributeCategory.val(), currentAttributeEntities.entityIds, 'ATTRIBUTE_ENTITY');

            updateEntityCallback = function (selectedIds) {
                currentAttributeEntities.entityIds = selectedIds;
            };
        });

        elements.secondaryPrompt.click(function (e) {
            e.preventDefault();
            activeAppliesTo = $(this);

            showEntities($(this), $(this).closest('.textBoxOptions').find('.secondaryAttributeCategory').val(), currentAttributeEntities.secondaryEntityIds, 'ATTRIBUTE_SECONDARY_ENTITY_IDS');

            updateEntityCallback = function (selectedIds) {
                currentAttributeEntities.secondaryEntityIds = selectedIds;
            };
        });

        $(document).mouseup(function (e) {
            var container = selectedEntityChoices;

            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.hide();
            }
        });

        selectedEntityChoices.delegate('a.all', 'click', function (e) {
            onEntityChoiceClick(e);
        });

        selectedEntityChoices.delegate('a.ok', 'click', function (e) {
            e.preventDefault();
            selectedEntityChoices.hide();
            handleEntitiesSelected(activeAppliesTo);
        });

        elements.limitScope.change(function (e) {
            elements.attributeSecondary.addClass('no-show');
            if (elements.limitScope.is(':checked')) {
                elements.attributeSecondary.removeClass('no-show');
            }
        });

        elements.secondaryAttributeCategory.change(function (e) {
            currentAttributeEntities.entityIds = [];
            currentAttributeEntities.secondaryEntityIds = [];
            elements.secondaryPrompt.text(opts.allText);
        });

        ConfigureAsyncForm(elements.addForm, defaultSubmitCallback, addAttributeHandler);
        ConfigureAsyncForm(elements.form, defaultSubmitCallback, editAttributeHandler);
        ConfigureAsyncForm(elements.deleteForm, defaultSubmitCallback, deleteAttributeHandler);
    };

    function handleEntitiesSelected(element) {
        element.empty();
        var entities = selectedEntityChoices.find(':checked');
        // element.append(entities);
        if (entities.length > 0) {
            var text = _.map(entities, function (e) {
                return $(e).attr('data-text');
            }).join(', ');

            element.text(text);
            // elements.secondaryPrompt.text(text);

            updateEntityCallback(_.map(entities, function (e) {
                return $(e).val();
            }));
        }
        else {
            element.text(opts.allText);
        }
    }

    var onEntityChoiceClick = function (e) {
        e.preventDefault();
        selectedEntityChoices.hide();
        elements.appliesToId.empty();
        selectedEntityChoices.find('input:checkbox').removeAttr('checked');
        elements.appliesTo.text(opts.allText);
    };

    var showRelevantAttributeOptions = function (selectedType, optionsDiv) {
        $('.textBoxOptions', optionsDiv).find('div').not('.attributeUnique, .attributeSecondary').show();

        if (selectedType != opts.selectList) {
            $('.attributePossibleValues').hide();
        }

        if (selectedType == opts.selectList || selectedType == opts.date) {
            $('.attributeValidationExpression').hide();
        }

        if (selectedType == opts.checkbox) {
            $('.attributePossibleValues, .attributeValidationExpression').hide();
        }

        showRelevantCategoryOptions();
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

        selectedEntityChoices.empty();
        if (selectedAttribute.entityDescriptions.length == 0) {
            elements.appliesTo.text(options.allText);
            elements.appliesToId.val('');
        }
        else {
            if (elements.attributeCategory.val() == options.categories.reservation) {
                $.each(selectedAttribute.secondaryEntityIds, function (i, id) {
                    if (selectedAttribute.secondaryEntityDescriptions[i] != undefined) {
                        var name = selectedAttribute.secondaryEntityDescriptions[i].replace(/"/g, '&quot;')
                        selectedEntityChoices.append($('<input type="checkbox" name="ATTRIBUTE_SECONDARY_ENTITY_IDS[]" value="' + id + '" checked="checked" data-text="' + name + '"/>'));
                    }
                });
            }
            else {
                $.each(selectedAttribute.entityIds, function (i, id) {
                    if (selectedAttribute.secondaryEntityDescriptions[i] != undefined) {
                        var name = selectedAttribute.entityDescriptions[i].replace(/"/g, '&quot;')
                        selectedEntityChoices.append($('<input type="checkbox" name="ATTRIBUTE_ENTITY[]" value="' + id + '" checked="checked" data-text="' + name + '"/>'));
                    }
                });
            }
            handleEntitiesSelected(elements.editAppliesTo);
            elements.appliesToId.hide();
        }

        var limitScope = $('#editAttributeLimitScope');
        limitScope.prop('checked', false);

        $('#editAttributeSecondaryEntityId').val('');
        elements.secondaryPrompt.text(options.allText);
        if (selectedAttribute.secondaryEntityIds.length > 0) {
            limitScope.prop('checked', true);
            limitScope.trigger('change');
            $('#editAttributeSecondaryCategory').val(selectedAttribute.secondaryCategory);
            $('#editAttributeSecondaryEntityId').val(selectedAttribute.secondaryEntityIds.join());
            elements.secondaryPrompt.text(selectedAttribute.secondaryEntityDescriptions.join(', '));
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
        if (elements.attributeCategory.val() == options.categories.reservation) {
            $('.attributeUnique').hide();
            $('.attributeAdminOnly').show();
            $('.secondaryEntities, .attributeSecondary').addClass('no-show');
            $('.secondaryEntities').removeClass('no-show');
            $('.attributeIsPrivate').show();
        }
        else {
            $('.attributeUnique').show();
            //$('.attributeAdminOnly').hide();
            $('.secondaryEntities, .attributeSecondary').addClass('no-show');
            $('.attributeIsPrivate').hide();
        }
    };

    var showEntities = function (element, categoryId, selectedIds, formName) {
        //var selectedIds = [];
        elements.appliesToId.find('input:checkbox').removeAttr('checked');

        selectedEntityChoices.empty();
        selectedEntityChoices.css({left: element.position().left, top: element.position().top + element.height()});
        selectedEntityChoices.show();

        $('<div class="ajax-indicator">&nbsp;</div>').appendTo(selectedEntityChoices).show();

        var data = [];

        if (categoryId == options.categories.resource) {
            data = getResources();
        }

        if (categoryId == options.categories.user) {
            data = getUsers();
        }

        if (categoryId == options.categories.resource_type) {
            data = getResourceTypes();
        }

        var items = ['<li><a href="#" class="all">' + options.allText + '</a> <a href="#" class="ok">OK</a></li>'];
        $.each(data, function (index, item) {
            var checked = '';
            if (selectedIds.indexOf(item.Id) !== -1) {
                checked = ' checked="checked" ';
            }
            items.push('<li><label><input type="checkbox" name="' + formName + '[]" value="' + item.Id + '"' + checked + ' data-text="' + item.Name.replace(/"/g, '&quot;') + '"/>' + item.Name + '</label></li>');
        });

        selectedEntityChoices.empty();

        $('<div/>', {'class': '', html: items.join('')}).appendTo(selectedEntityChoices);
    };

    var getResources = function () {
        var items = [];
        $.ajax({
            url: options.resourcesUrl, async: false
        }).done(function (data) {
            items = data;
        });

        return items;
    };

    var getUsers = function () {
        var items = [];
        $.ajax({
            url: options.usersUrl, async: false
        }).done(function (data) {
            items = $.map(data, function (item, index) {
                return {Id: item.UserId, Name: item.FullName};
            });
        });

        return items;
    };

    var getResourceTypes = function () {
        var items = [];
        $.ajax({
            url: options.resourceTypesUrl, async: false
        }).done(function (data) {
            items = $.map(data, function (item, index) {
                return {Id: item.Id, Name: item.Name};
            });
        });

        return items;
    }
}