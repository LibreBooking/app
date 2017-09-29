function Reservation(opts) {
	var options = opts;

	var elements = {
		beginDate: $('#formattedBeginDate'),
		endDate: $('#formattedEndDate'),
		beginDateTextbox: $('#BeginDate'),
		endDateTextbox: $('#EndDate'),

		beginTime: $('#BeginPeriod'),
		endTime: $('#EndPeriod'),
		durationDays: $('#durationDays'),
		durationHours: $('#durationHours'),
        durationMinutes: $('#durationMinutes'),

		participantDialogPrompt: $('#promptForParticipants'),
		participantDialog: $('#participantDialog'),
		participantGroupDialogPrompt: $('#promptForGroupParticipants'),
		participantGroupDialog: $('#participantGroupDialog'),
		participantList: $('#participantList'),
		participantAutocomplete: $('#participantAutocomplete'),

		inviteeDialogPrompt: $('#promptForInvitees'),
		inviteeDialog: $('#inviteeDialog'),
		inviteeGroupDialogPrompt: $('#promptForGroupInvitees'),
		inviteeGroupDialog: $('#inviteeGroupDialog'),
		inviteeList: $('#inviteeList'),
		inviteeAutocomplete: $('#inviteeAutocomplete'),
		guestDialogPrompt: $('#promptForGuests'),
		inviteeGuestDialog: $('#inviteeGuestDialog'),
		guestEmail: $('#txtGuestEmail'),
		addGuestButton: $('#btnAddGuest'),

		changeUserAutocomplete: $('#changeUserAutocomplete'),
		userName: $('#userName'),
        availableCreditsCount: $('#availableCreditsCount'),
		userId: $('#userId'),

		referenceNumber: $('#referenceNumber'),

		accessoriesPrompt: $('#addAccessoriesPrompt'),
		accessoriesDialog: $('#dialogAddAccessories'),
		accessoriesList: $('#accessories'),
		accessoriesConfirm: $('#btnConfirmAddAccessories'),
		accessoriesCancel: $('#btnCancelAddAccessories'),

		printButton: $('.btnPrint'),
		groupDiv: $('#resourceGroups'),
		resourceGroupsDialog: $('#dialogResourceGroups'),
		addResourcesConfirm: $('.btnConfirmAddResources'),
		reservationAttachments: $('#reservationAttachments'),

        deleteButtonPrompt: $('#deleteButtonPrompt'),
		additionalResources: $('#additionalResources'),
        deleteRecurringButtons: $('#deleteRecurringButtons')
	};

	var participation = {};
	participation.addedUsers = [];

	var changeUser = {};

	var oneDay = 86400000;

	var scheduleId;

	var _ownerId;
	var _startDate;
	var _endDate;

	Reservation.prototype.init = function (ownerId, startDateString, endDateString) {
		_ownerId = ownerId;
		_startDate = moment(startDateString);
		_endDate = moment(endDateString);
		participation.addedUsers.push(ownerId);

		$('#dialogResourceGroups').on('show.bs.modal', function (e) {
			InitializeAdditionalResources();
			return true;
		});

		scheduleId = $('#scheduleId').val();

		elements.accessoriesPrompt.click(function (e) {
			e.preventDefault();
			ShowAccessoriesPrompt();
		});

		elements.accessoriesConfirm.click(function (e) {
			e.preventDefault();
			AddAccessories();
			elements.accessoriesDialog.modal('hide');
		});

		elements.accessoriesCancel.click(function (e) {
			e.preventDefault();
			elements.accessoriesDialog.modal('hide');
		});

		elements.printButton.click(function (e) {
			e.preventDefault();
			window.print();
		});

		WireUpResourceDetailPopups();

		$('#btnRemoveAttachment').click(function (e) {
			e.preventDefault();
			$('input:checkbox', '#attachmentDiv').toggle();
		});

		changeUser.init();

		InitializeParticipationElements();

		elements.groupDiv.delegate('.additionalResourceCheckbox, .additionalResourceGroupCheckbox', 'click', function (e) {
			handleAdditionalResourceChecked($(this), e);
		});

		$('.btnClearAddResources').click(function () {
			elements.resourceGroupsDialog.modal('hide');
		});

		elements.addResourcesConfirm.click(function () {
			AddResources();
		});

		$('.btnUpdateThisInstance').click(function () {
			ChangeUpdateScope(options.scopeOpts.instance);
		});

		$('.btnUpdateAllInstances').click(function () {
			ChangeUpdateScope(options.scopeOpts.full);
		});

		$('.btnUpdateFutureInstances').click(function () {
			ChangeUpdateScope(options.scopeOpts.future);
		});

        $('.triggerDeletePrompt').click(function(e){
            e.preventDefault();
            elements.deleteButtonPrompt.modal('show');
        });

        $('#cancelDelete, #confirmDelete').click(function (e)
        {
            e.preventDefault();
            elements.deleteButtonPrompt.modal('hide');
        });

        InitializeDateElements();

		WireUpActions();
		WireUpButtonPrompt();
		WireUpSaveDialog();
		DisplayDuration();
		WireUpAttachments();
		InitializeAutoRelease();

		elements.userId.change(function () {
			LoadCustomAttributes();
		});

		LoadCustomAttributes();
	};

    function SetDeleteReason() {
        var reason = $("#deleteReason").val();
        if (_.isEmpty(reason)) {
            reason = $('#deleteReasonRecurring').val();
        }
        $('#hdnDeleteReason').val(reason);
    }

// pre-submit callback
	Reservation.prototype.preSubmit = function (formData, jqForm, options) {
		$.blockUI({message: $('#wait-box')});

		$('#creatingNotification').find('h3').addClass('no-show');
		$('#createUpdateMessage').removeClass('no-show');
		$('#result').hide();
		$('#creatingNotification').show();

		return true;
	};

	// post-submit callback 
	Reservation.prototype.showResponse = function (responseText, statusText, xhr, $form) {
		ShowReservationAjaxResponse();
	};

	var AddAccessories = function () {
		elements.accessoriesList.empty();

		elements.accessoriesDialog.find('.accessory-quantity, :checked').each(function () {
			AddAccessory($(this).siblings('.name').val(), $(this).siblings('.id').val(), $(this).val());
		});
	};

	Reservation.prototype.addAccessory = function (accessoryId, quantity, name) {
		AddAccessory(name, accessoryId, quantity);
	};

	Reservation.prototype.addResourceGroups = function (resourceGroups) {
		elements.groupDiv.tree({
			data: resourceGroups, saveState: false, dragAndDrop: false, selectable: false, autoOpen: true,

			onCreateLi: function (node, $li) {
				var span = $li.find('span');
				var itemName = span.text();
				var label = $('<label><input type="checkbox"/>' + itemName + '</label>');

				var checkbox = label.find('input');

				if (node.type === 'resource')
				{
					checkbox.attr('resource-id', node.resource_id);
					checkbox.attr('group-id', node.group_id);
					checkbox.attr('reservation-color', node.color);
					checkbox.attr('reservation-text-color', node.textColor);
					checkbox.attr('requires-approval', node.requiresApproval);
					checkbox.attr('requires-checkin', node.isCheckInEnabled);
					checkbox.attr('autorelease-minutes', node.autoReleaseMinutes);
					checkbox.addClass('additionalResourceCheckbox');
				}
				else
				{
					checkbox.attr('group-id', node.id);
					checkbox.addClass('additionalResourceGroupCheckbox');
				}

				$li.find('span').html(label);
			}
		});
	};

	function LoadCustomAttributes() {
		var attributesPlaceholder = $('#custom-attributes-placeholder');
		attributesPlaceholder.html('<span class="fa fa-spinner fa-spin fa-2x"/>');
		var url = 'ajax/reservation_attributes.php?uid=' + elements.userId.val() + '&rn=' + elements.referenceNumber.val() + '&ro=' + $('#reservation-box').hasClass('readonly');

		var resourceIds = GetSelectedResourceIds();
		_.each(resourceIds, function (n) {
			url += '&rid[]=' + n;
		});
		attributesPlaceholder.load(url);
	}

	function GetSelectedResourceIds() {
		var resourceIds = [parseInt($('#primaryResourceId').val())];
		elements.additionalResources.find('.resourceId').each(function (i, element) {
			resourceIds.push(parseInt($(element).val()));
		});

		return resourceIds;
	}

	function onResourcesChanged() {
		LoadCustomAttributes();
	}

	function GetDisallowedAccessoryIds() {
		var disAllowedAccessoryIds = [];

		var resourceIds = GetSelectedResourceIds();
		elements.accessoriesDialog.find('tr[accessory-id]').each(function (i, row) {
			var allowedResourcesTxt = $(row).find('.resource-ids').val();
			if (allowedResourcesTxt)
			{
				var allowedResources = $.map(allowedResourcesTxt.split(','), function (i) {
					return parseInt(i);
				});

				if (_.intersection(resourceIds, allowedResources).length == 0)
				{
					disAllowedAccessoryIds.push($(row).attr('accessory-id'));
					// accessory is not allowed with any resources
				}
			}
		});

		return disAllowedAccessoryIds;
	}

	var ShowAccessoriesPrompt = function () {

		var url = options.accessoriesUrl
						.replace('[sd]', elements.beginDate.val())
						.replace('[ed]', elements.endDate.val())
						.replace('[rn]', elements.referenceNumber.val())
						.replace('[st]', elements.beginTime.val())
						.replace('[et]', elements.endTime.val())
						.replace('[rn]', elements.referenceNumber.val());

		ajaxGet(url, null, function(data){
			var dialog = elements.accessoriesDialog;
			$.each(data, function(i, accessory) {
				dialog.find('[accessory-quantity-id="' + accessory.id + '"]').html(accessory.quantity === null ? '&infin;' : accessory.quantity);
			});
		});

		elements.accessoriesDialog.find('input:text').val('0');
		elements.accessoriesDialog.find('tr[accessory-id]').show();

		elements.accessoriesList.find('input:hidden').each(function () {
			var idAndQuantity = $(this).val();
			var y = idAndQuantity.split('-');
			var params = y[1].split(',');
			var id = params[0].split('=')[1];
			var quantity = params[1].split('=')[1];
			var quantityElement = elements.accessoriesDialog.find('[name="accessory' + id + '"]');
			quantityElement.val(quantity);
			if (quantity > 0)
			{
				quantityElement.prop('checked', true);
			}
		});

		var accessoryIds = GetDisallowedAccessoryIds();
		_.forEach(accessoryIds, function (id) {
			elements.accessoriesDialog.find('tr[accessory-id="' + id + '"]').hide();
		});

	};

	var AddAccessory = function (name, id, quantity) {
		if (quantity == 0 || isNaN(quantity))
		{
			elements.accessoriesList.find('p [accessoryId=' + id + ']').remove();
			return;
		}
		var x = 'accessory-id=' + id + ',quantity=' + quantity + ',name=' + encodeURIComponent(name);

		elements.accessoriesList.append('<div accessoryId="' + id + '"><span class="badge quantity">' + quantity + '</span> ' + name + '<input type="hidden" name="' + options.accessoryListInputId + '" value="' + x + '"/></div>');
	};

	var AddResources = function () {
		var displayDiv = elements.additionalResources;
		displayDiv.empty();

		var primaryResourceContainer = $('#primaryResourceContainer');
		var resourceIdHdn = primaryResourceContainer.find('.resourceId');
		var resourceId = resourceIdHdn.val();

		var allCheckboxes = elements.resourceGroupsDialog.find('.additionalResourceCheckbox:checked');

		var checkboxes = [];
		var addedResources = [];
		$.each(allCheckboxes, function (i, checkbox) {
			var checkedResourceId = $(checkbox).attr('resource-id');
			if (!_.includes(addedResources, checkedResourceId))
			{
				checkboxes.push(checkbox);
				addedResources.push(checkedResourceId);
			}
		});

		if (checkboxes.length >= 1)
		{
			resourceIdHdn.val($(checkboxes[0]).attr('resource-id'));
			$.each(checkboxes, function (i, checkbox) {
				displayDiv = elements.additionalResources;
				var checkedResourceId = $(checkbox).attr('resource-id');
				var checkedResourceName = $(checkbox).parent().text();
				var color = $(checkbox).attr('reservation-color');
				var textColor = $(checkbox).attr('reservation-text-color');
				var requiresApproval = $(checkbox).attr('requires-approval') != '0';
				var requiresCheckin = $(checkbox).attr('requires-checkin') != '0';
				var autoReleaseMinutes = $(checkbox).attr('autorelease-minutes');

				if (i === 0)
				{
					primaryResourceContainer.find('.resourceName').remove();
					displayDiv = primaryResourceContainer;
				}
				displayDiv.append('<div class="resourceName" style="background-color:' + color + '; color:' + textColor + ';">' + '<span class="resourceDetails">' + checkedResourceName + '</span> ' + '<input class="resourceId" type="hidden" name="additionalResources[]" value="' + checkedResourceId + '"/>' + (requiresApproval ? ' <i class="fa fa-lock" data-tooltip="approval"></i> ' : '') + (requiresCheckin ? ' <i class="fa fa-sign-in" data-tooltip="checkin"></i> ' : '') + (!_.isEmpty(autoReleaseMinutes) ? ' <i class="fa fa-clock-o" data-tooltip="autorelease" data-autorelease="' + autoReleaseMinutes + '"></i> ' : '') + '</div>');
			});
		}

		var accessoryIds = GetDisallowedAccessoryIds();
		_.forEach(accessoryIds, function (id) {
			elements.accessoriesList.find('[accessoryid="' + id + '"]').remove();
		});

		WireUpResourceDetailPopups();
		elements.resourceGroupsDialog.modal('hide');
		onResourcesChanged();
	};

	var InitializeAdditionalResources = function () {

		var url = options.resourcesUrl
								.replace('[sd]', elements.beginDate.val())
								.replace('[ed]', elements.endDate.val())
								.replace('[rn]', elements.referenceNumber.val())
								.replace('[st]', elements.beginTime.val())
								.replace('[et]', elements.endTime.val())
								.replace('[rn]', elements.referenceNumber.val());

		var dialog = elements.resourceGroupsDialog;
        var allCheckboxes = dialog.find('[resource-id]');
        allCheckboxes.prop('disabled', false);
        allCheckboxes.parent().removeClass('unavailableResource');

		dialog.find('#checking-availability').removeClass('no-show');

		ajaxGet(url, null, function(data){
			$.each(data, function(i, unavailableResourceId) {
                var checkbox = dialog.find('[resource-id="' + unavailableResourceId + '"]');
                checkbox.prop('checked', false);
                checkbox.trigger('checked');
                checkbox.prop('disabled', true);
                checkbox.parent().addClass('unavailableResource');
			});
			dialog.find('#checking-availability').addClass('no-show');
		});

		elements.groupDiv.find('input[type=checkbox]').prop('checked', false);
		$.each($('.resourceId'), function (idx, val) {
			var resourceCheckboxes = elements.groupDiv.find('[resource-id="' + $(val).val() + '"]');
			$.each(resourceCheckboxes, function (ridx, checkbox) {
				$(checkbox).prop('checked', true);
				handleAdditionalResourceChecked($(checkbox));
			});
		});
	};

	var handleAdditionalResourceChecked = function (checkbox, event) {
		var isChecked = checkbox.is(':checked');

		if (!checkbox[0].hasAttribute('resource-id'))
		{
			// if this is a group, check/uncheck all nested subitems
			$.each(checkbox.closest('li').find('ul').find('input[type=checkbox]'), function (i, v) {
				if ($(v).is(':enabled'))
                {
                    $(v).prop('checked', isChecked);
                    handleAdditionalResourceChecked($(v));
                }
			});
		}
		else
		{
			// if all resources in a group are checked, check the group
			var groupId = checkbox.attr('group-id');
			var resourceId = checkbox.attr('resource-id');
			var numberOfResources = elements.groupDiv.find('.additionalResourceCheckbox[group-id="' + groupId + '"]').length;
			var numberOfResourcesChecked = elements.groupDiv.find('.additionalResourceCheckbox[group-id="' + groupId + '"]:checked').length;

			elements.groupDiv.find('[resource-id="' + resourceId + '"]').prop('checked', isChecked);

			elements.groupDiv.find('.additionalResourceGroupCheckbox[group-id="' + groupId + '"]').prop('checked', numberOfResources == numberOfResourcesChecked)
		}

		if (elements.groupDiv.find('.additionalResourceCheckbox:checked').length == 0)
		{
			// if this is the only checked checkbox, don't allow 'done'
			elements.addResourcesConfirm.addClass('disabled');
			elements.addResourcesConfirm.attr('disabled', true);
		}
		else
		{
			elements.addResourcesConfirm.removeClass('disabled');
			elements.addResourcesConfirm.removeAttr('disabled');
		}
	};

	var AdjustEndDate = function () {
		var firstDate = new Date(elements.beginDate.data['beginPreviousVal'] + 'T' + elements.beginTime.val());
		var secondDate = new Date(elements.beginDate.val() + 'T' + elements.beginTime.val());

		var diffDays = (secondDate.getTime() - firstDate.getTime()) / (oneDay);

		var currentEndDate = new Date(elements.endDate.val() + 'T' + elements.endTime.val());
		currentEndDate.setDate(currentEndDate.getDate() + diffDays);

		elements.endDateTextbox.datepicker("setDate", currentEndDate);
		elements.endDate.trigger('change');
	};

	var SelectRepeatWeekday = function () {
		$('#repeatOnWeeklyDiv').find(':checkbox').each(function (i, v) {
			$(v).parent().removeClass('active');
			$(v).prop('checked', false);
		});

		var date = moment(elements.beginDate.val() + 'T' + elements.beginTime.val());
		var checkbox = $('#repeatDay' + date.day());
		checkbox.prop('checked', true);
		checkbox.parent().addClass('active');
	};

	var ChangeUpdateScope = function (updateScopeValue) {
		$('#hdnSeriesUpdateScope').val(updateScopeValue);
	};

	var DisplayDuration = function () {
		var rounded = dateHelper.GetDateDifference(elements.beginDate, elements.beginTime, elements.endDate, elements.endTime);

		elements.durationDays.text(rounded.RoundedDays);
		elements.durationHours.text(rounded.RoundedHours);
        elements.durationMinutes.text(rounded.RoundedMinutes);
	};

	var ShowReservationAjaxResponse = function () {
		$('.blockUI').css('cursor', 'default');

		$('#btnSaveSuccessful').unbind().click(function (e) {
			window.location = options.returnUrl;
		});

		$('#btnSaveFailed').unbind().click(function () {
			CloseSaveDialog();
		});

        $('#btnWaitList').unbind().click(function () {
			JoinWaitList();
		});

		$('#btnRetry').unbind().click(function (e) {
			e.preventDefault();
			var retryParams = $('#retryParams');
			$('#retrySubmitParams').empty().append(retryParams.find('input'));
			retryParams.empty();
			//CloseSaveDialog();
			$('#form-reservation').submit();
		});

		$('#creatingNotification').hide();
		$('#result').show();
	};

	var CloseSaveDialog = function () {
		$.unblockUI();
	};

    var JoinWaitList = function () {
        $('#result').hide();
        $('#creatingNotification').show();
        $('#joiningWaitingList').removeClass('no-show');

        ajaxPost($('#form-reservation'), opts.waitlistUrl, null, function (data) {
            $('#result').html(data);
            ShowReservationAjaxResponse();
        });
	};

	var WireUpActions = function () {
		$('.create').click(function () {
			$('form').attr("action", options.createUrl);
		});

		$('.update').click(function () {
            SetDeleteReason();
            elements.deleteRecurringButtons.addClass('no-show');
			$('form').attr("action", options.updateUrl);
		});

		$('.delete').click(function () {
            SetDeleteReason();
            elements.deleteRecurringButtons.removeClass('no-show');
            $('form').attr("action", options.deleteUrl);
		});

		$('.btnCheckin').click(function () {
			$('#creatingNotification').find('h3').addClass('no-show');
			$('#checkingInMessage').removeClass('no-show');
			$.blockUI({message: $('#wait-box')});

			ajaxPost($('#form-reservation'), opts.checkinUrl, null, function (data) {
				$('#result').html(data);
				ShowReservationAjaxResponse();
			});
		});

		$('.btnCheckout').click(function () {
			$('#creatingNotification').find('h3').addClass('no-show');
			$('#checkingOutMessage').removeClass('no-show');
			$.blockUI({message: $('#wait-box')});

			ajaxPost($('#form-reservation'), opts.checkoutUrl, null, function (data) {
				$('#result').html(data);
				ShowReservationAjaxResponse();
			});
		});
	};

	var WireUpButtonPrompt = function () {
		$('#updateButtons').find('button').click(function () {
			$('#updateButtons').modal('hide');
		});

		$('.prompt').click(function () {
			$('#updateButtons').modal('show');
		});
	};

	var WireUpSaveDialog = function () {
		$('.save').click(function () {
			$('#form-reservation').submit();
		});
	};

	function WireUpResourceDetailPopups() {
		$('#primaryResourceContainer, #additionalResources').find('.resourceDetails').each(function () {
			var resourceId = $(this).attr("data-resourceId");
			$(this).bindResourceDetails(resourceId);
		});
	}

	function InitializeDateElements() {
		var periodsCache = ['begin', 'end'];
		periodsCache['begin'] = [];
		periodsCache['end'] = [];

		elements.beginDate.data['beginPreviousVal'] = elements.beginDate.val();
		elements.endDate.data['endPreviousVal'] = elements.endDate.val();
		elements.beginTime.data['beginTimePreviousVal'] = elements.beginTime.val();

		elements.beginDate.change(function () {
			PopulatePeriodDropDown(elements.beginDate, elements.beginTime, elements.beginDateTextbox, 'begin');
			AdjustEndDate();
			DisplayDuration();
			SelectRepeatWeekday();

			elements.beginDate.data['beginPreviousVal'] = elements.beginDate.val();
		});

		elements.endDate.change(function () {
			PopulatePeriodDropDown(elements.endDate, elements.endTime, elements.endDateTextbox, 'end');
			DisplayDuration();

			elements.endDate.data['endPreviousVal'] = elements.endDate.val();
		});

		elements.beginTime.change(function () {
			var diff = dateHelper.GetTimeDifference(elements.beginTime.data['beginTimePreviousVal'], elements.beginTime.val());

			var newTime = dateHelper.AddTimeDiff(diff, elements.endTime.val());

			//console.log(newTime);
			elements.endTime.val(newTime);
			elements.beginTime.data['beginTimePreviousVal'] = elements.beginTime.val();

			DisplayDuration();
		});

		elements.endTime.change(function () {
			DisplayDuration();
		});

		var PopulatePeriodDropDown = function (dateElement, periodElement, dateTextbox, type) {
			var prevDate = new Date(dateElement.data['previousVal']);
			var currDate = new Date(dateElement.val());
			if (prevDate.getTime() == currDate.getTime())
			{
				return;
			}

			var selectedPeriod = periodElement.val();

			var weekday = currDate.getDay();

			if (periodsCache[type][weekday] != null)
			{
				periodElement.empty();
				periodElement.html(periodsCache[type][weekday]);
				if (selectedPeriod)
                {
                    periodElement.val(selectedPeriod);
                }
				return;
			}
			$.ajax({
				url: 'schedule.php', dataType: 'json', data: {dr: 'layout', 'sid': scheduleId, 'ld': dateElement.val()}, success: function (data) {
					var items = [];
					periodElement.empty();
					$.map(data.periods, function (item) {
						if (item.isReservable) {
							if (type == 'begin')
							{
								items.push('<option value="' + item.begin + '">' + item.label + '</option>');
							}
							else
							{
								items.push('<option value="' + item.end + '">' + item.labelEnd + '</option>');

							}
                        }
                        else {
							if (type == 'end' && moment(elements.beginDate.val()).add(1, 'days').isSame(elements.endDate.val()))
							{
								selectedPeriod = null;
								items.push('<option value="' + item.begin + '" selected="selected">' + item.label + '</option>');
							}
						}
					});

                    if (items.length == 0){
                        var nextDate = moment(dateElement.val()).add(1, 'days').toDate();
                        dateTextbox.datepicker("setDate", nextDate);
                        dateElement.trigger('change');
                    }
                    else {
                        var html = items.join('');
                        periodsCache[type][weekday] = html;
                        periodElement.html(html);
                        if (selectedPeriod) {
                            periodElement.val(selectedPeriod);
                        }
                    }
				}, async: false
			});
		};

		SelectRepeatWeekday();
	}

	function InitializeParticipationElements() {
		elements.participantDialogPrompt.click(function () {
			participation.showAllUsersToAdd(elements.participantDialog);
		});

		elements.participantGroupDialogPrompt.click(function () {
			participation.showAllGroupsToAdd(elements.participantGroupDialog);
		});

		elements.participantDialog.delegate('.add', 'click', function (e) {
			e.preventDefault();
			participation.addParticipant($(this).find('.name').text(), $(this).attr('user-id'));
		});

		elements.participantGroupDialog.delegate('.add', 'click', function (e) {
			e.preventDefault();
			participation.addGroupParticipants($(this).attr('group-id'));
		});

		elements.participantList.delegate('.remove', 'click', function (e) {
			e.preventDefault();
			var item = $(this).closest('.user');
			var id = item.find('.id').val();
			item.remove();
			participation.removeParticipant(id);
		});

		elements.participantAutocomplete.userAutoComplete(options.userAutocompleteUrl, function (ui) {
			participation.addParticipant(ui.item.label, ui.item.value);
		});

		elements.inviteeDialogPrompt.click(function (e) {
			e.preventDefault();
			participation.showAllUsersToAdd(elements.inviteeDialog);
		});

		elements.inviteeGroupDialogPrompt.click(function (e) {
			e.preventDefault();
			participation.showAllGroupsToAdd(elements.inviteeGroupDialog);
		});

		elements.inviteeDialog.delegate('.add', 'click', function (e) {
			e.preventDefault();
			participation.addInvitee($(this).find('.name').text(), $(this).attr('user-id'));
		});

		elements.inviteeGroupDialog.delegate('.add', 'click', function (e) {
			e.preventDefault();
			participation.addGroupInvitees($(this).attr('group-id'));
		});

		elements.inviteeList.delegate('.remove', 'click', function (e) {
			e.preventDefault();
			var item = $(this).closest('.user');
			var id = item.find('.id').val();
			item.remove();
			participation.removeInvitee(id);
		});

		elements.inviteeAutocomplete.userAutoComplete(options.userAutocompleteUrl, function (ui) {
			participation.addInvitee(ui.item.label, ui.item.value);
		});

		elements.guestDialogPrompt.click(function (e) {
			e.preventDefault();
			elements.inviteeGuestDialog.modal('show');
		});

		elements.addGuestButton.click(function (e) {
			e.preventDefault();
			var emails = elements.guestEmail.val().split(/[ ,]+/);
			$.each(emails, function (i, email) {
				if (validateEmail(email))
				{
					participation.addInvitedGuest($.trim(email));
					elements.guestEmail.val('');
				}
			});
		});

		elements.guestEmail.keyup(function (e) {
			var code = e.keyCode || e.which;
			if (code === 13)
			{
				elements.addGuestButton.trigger('click');
			}
		});
	}

	function WireUpAttachments() {
		var enableCorrectButtons = function () {
			var allAttachments = elements.reservationAttachments.find('.attachment-item');
			if (allAttachments.length > 1)
			{
				$.each(allAttachments, function (i, v) {
					var addbutton = $(v).find('.add-attachment');
					if (i == allAttachments.length - 1)
					{
						addbutton.show();
					}
					else
					{
						addbutton.hide();
					}

					$(v).find('.remove-attachment').show();
				});
			}
			else
			{
				elements.reservationAttachments.find('.add-attachment').show();
				elements.reservationAttachments.find('.remove-attachment').hide();
			}

			if (allAttachments.length == opts.maxConcurrentUploads)
			{
				allAttachments.find('.add-attachment').hide();
			}
		};

		enableCorrectButtons();

		elements.reservationAttachments.delegate('.add-attachment', 'click', function (e) {
			e.preventDefault();
			var li = $(this).closest('.attachment-item');
			var cloned = li.clone();
			cloned.appendTo(li.parent());
			cloned.wrap('<form>').closest('form').get(0).reset();
			cloned.unwrap();
			enableCorrectButtons();
		});

		elements.reservationAttachments.delegate('.remove-attachment', 'click', function (e) {
			e.preventDefault();
			$(this).closest('.attachment-item').remove();
			enableCorrectButtons();
		});
	}

	function InitializeAutoRelease() {
		var autoReleaseButtonMessage = $('.autoReleaseButtonMessage');
		if (autoReleaseButtonMessage.length > 0)
		{
			var autoReleaseMinutes = autoReleaseButtonMessage.first().data('autorelease-minutes');
			if (autoReleaseMinutes != '')
			{
				var interval;
				var updateAutoReleaseMinutes = function () {
					var ms = _startDate.diff(moment());
					var releaseMinutesText = Math.max(0, Math.ceil(moment.duration(ms).asMinutes()) + autoReleaseMinutes);
					$('.autoReleaseMinutes').text(releaseMinutesText);

					if (releaseMinutesText <= 0)
					{
						clearInterval(interval);
                        $('#btnCheckin').addClass('no-show');
                    }
				};

				updateAutoReleaseMinutes();
				interval = setInterval(updateAutoReleaseMinutes, 5000);
				autoReleaseButtonMessage.show();
			}
		}
	}

	changeUser.init = function () {
		$('#showChangeUsers').click(function (e) {
			$('#changeUsers').toggle();
			e.preventDefault();
		});

		elements.changeUserAutocomplete.userAutoComplete(options.changeUserAutocompleteUrl, function (ui) {
			changeUser.chooseUser(ui.item.value, ui.item.label, ui.item.data.CurrentCreditCount);
		});

		$('#promptForChangeUsers').click(function () {
			changeUser.showAll();
		});

		$('#changeUserDialog').delegate('.add', 'click', function () {
			changeUser.chooseUser($(this).attr('userId'), $(this).text(), $(this).attr('availableCredits'));
			$('#changeUserDialog').modal('hide');
		});
	};

	changeUser.chooseUser = function (id, name, availableCredits) {
		elements.userName.text(name);
		elements.userName.attr('data-userid', id);
        elements.availableCreditsCount.text(availableCredits);
		elements.userId.val(id).trigger('change');

		participation.removeParticipant(_ownerId);
		participation.removeInvitee(_ownerId);

		participation.addedUsers.push(id);

		_ownerId = id;
		$('#changeUsers').hide();
	};

	changeUser.showAll = function () {
		var allUserList;
		var dialogElement = $('#changeUserDialog');
		var listElement = dialogElement.find('.modal-body');
		var items = [];
		if (listElement.children().length == 0)
		{
			$.ajax({
				url: options.changeUserAutocompleteUrl, dataType: 'json', async: false, success: function (data) {
					allUserList = data;
					$.map(allUserList, function (item) {
						items.push('<div><a href="#" class="add" title="Add" userId="' + item.Id + '" availableCredits="' + item.CurrentCreditCount + '">' + item.DisplayName + '</a></div>');
					});

					$('<div/>', {'class': 'no-style', html: items.join('')}).appendTo(listElement);
				}
			});
		}

		dialogElement.modal('show');
	};

	participation.addParticipant = function (name, userId) {
		if ($.inArray(userId, participation.addedUsers) >= 0)
		{
			return;
		}

		var item = '<div class="user">' + '<a href="#" class="remove"><span class="fa fa-remove"></span></a> <a href="#" class="bindableUser" data-userid="' + userId + '">' + name + '</a><input type="hidden" class="id" name="participantList[]" value="' + userId + '" />' + '</div>';

		elements.participantList.append(item);
		$('.bindableUser').bindUserDetails();
		participation.addedUsers.push(userId);
	};

	Reservation.prototype.addParticipant = function (name, userId) {
		participation.addParticipant(name, userId);
	};

	Reservation.prototype.addInvitee = function (name, userId) {
		participation.addInvitee(name, userId);
	};

	Reservation.prototype.addParticipatingGuest = function (email) {
		participation.addParticipatingGuest(email);
	};

	Reservation.prototype.addInvitedGuest = function (email) {
		participation.addInvitedGuest(email);
	};

	participation.addInvitee = function (name, userId) {
		if ($.inArray(userId, participation.addedUsers) >= 0)
		{
			return;
		}

		var item = '<div class="user">' + '<a href="#" class="remove"><span class="fa fa-remove"></span></a> <a href="#" class="bindableUser" data-userid="' + userId + '">' + name + '</a><input type="hidden" class="id" name="invitationList[]" value="' + userId + '" />' + '</div>';

		elements.inviteeList.append(item);
		$('.bindableUser').bindUserDetails();
		participation.addedUsers.push(userId);
	};

	participation.addInvitedGuest = function (emailAddress) {
		if ($.inArray(emailAddress, participation.addedUsers) >= 0)
		{
			return;
		}

		var item = '<div class="user">' + '<a href="#" class="remove"><span class="fa fa-remove"></span></a> ' + emailAddress + ' ' + opts.guestLabel + '<input type="hidden" class="id" name="guestInvitationList[]" value="' + emailAddress + '" />' + '</div>';

		elements.inviteeList.append(item);

		participation.addedUsers.push(emailAddress);
	};

	participation.addParticipatingGuest = function (emailAddress) {
		if ($.inArray(emailAddress, participation.addedUsers) >= 0)
		{
			return;
		}

		var item = '<div class="user">' + '<a href="#" class="remove"><span class="fa fa-remove"></span></a> ' + emailAddress + ' ' +  opts.guestLabel + '<input type="hidden" class="id" name="guestParticipationList[]" value="' + emailAddress + '" />' + '</div>';

		elements.participantList.append(item);

		participation.addedUsers.push(emailAddress);
	};

	participation.removeParticipant = function (userId) {
		var index = $.inArray(userId, participation.addedUsers);
		if (index >= 0)
		{
			participation.addedUsers.splice(index, 1);
		}
	};

	participation.removeInvitee = function (userId) {
		var index = $.inArray(userId, participation.addedUsers);
		if (index >= 0)
		{
			participation.addedUsers.splice(index, 1);
		}
	};

	participation.showAllUsersToAdd = function (dialogElement) {
		var allUserList;
		var listElement = dialogElement.find('.modal-body');
		var items = [];
		if (listElement.children().length == 0)
		{
			$.ajax({
				url: options.userAutocompleteUrl, dataType: 'json', async: false, success: function (data) {
					allUserList = data;
					$.map(allUserList, function (item) {
						if (item.Id != _ownerId)
						{
							items.push('<div><a href="#" class="add" title="Add" user-id="' + item.Id + '">' + '<span class="fa fa-plus-square icon"></span> <span class="name">' + item.DisplayName + '</span></a></div>');
						}
					});

					$('<div/>', {'class': 'no-style', html: items.join('')}).appendTo(listElement);
				}
			});
		}

		dialogElement.modal('show');
	};

	participation.showAllGroupsToAdd = function (dialogElement) {
		var allUserList;
		var listElement = dialogElement.find('.modal-body');
		var items = [];
		if (listElement.children().length == 0)
		{
			$.ajax({
				url: options.groupAutocompleteUrl, dataType: 'json', async: false, success: function (data) {
					allUserList = data;
					$.map(allUserList, function (item) {
						if (item.Id != _ownerId)
						{
							items.push('<div><a href="#" class="add" title="Add" group-id="' + item.Id + '">' + '<span class="fa fa-plus-square icon"></span> <span class="name">' + item.Name + '</span></a></div>');
						}
					});

					$('<div/>', {'class': 'no-style', html: items.join('')}).appendTo(listElement);
				}
			});
		}

		dialogElement.modal('show');
	};

	participation.addGroupUsers = function (groupId, addUserCallback) {
		$.ajax({
			url: options.userAutocompleteUrl + '&term=group&gid=' + groupId, dataType: 'json', async: false, success: function (data) {
				$.each(data, function (i, user) {
					addUserCallback(user.DisplayName, user.Id);
				});
			}
		});
	};

	participation.addGroupParticipants = function (groupId) {
		participation.addGroupUsers(groupId, participation.addParticipant);
	};

	participation.addGroupInvitees = function (groupId) {
		participation.addGroupUsers(groupId, participation.addInvitee);
	};
}