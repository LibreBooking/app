/**
 Copyright 2012-2014 Nick Korbel

 This file is part of Booked Scheduler.

 Booked Scheduler is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 Booked Scheduler is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
function Recurrence(recurOptions, recurElements, prefix) {
	prefix = prefix || '';
	var e = {
		repeatOptions:$('#' + prefix + 'repeatOptions'),
		repeatDiv:$('#' + prefix + 'repeatDiv'),
		repeatInterval:$('#' + prefix + 'repeatInterval'),
		repeatTermination:$('#' + prefix + 'formattedEndRepeat'),
		repeatTerminationTextbox:$('#' + prefix + 'EndRepeat'),
		beginDate: $('#' + prefix + 'formattedBeginDate'),
		endDate: $('#' + prefix + 'formattedEndDate'),
		beginTime: $('#' + prefix + 'BeginPeriod'),
		endTime: $('#' + prefix + 'EndPeriod')
	};

	var options = recurOptions;

	var elements = $.extend(e, recurElements);

	var repeatToggled = false;
	var terminationDateSetManually = false;

	this.init = function () {
		InitializeDateElements();
		InitializeRepeatElements();
		InitializeRepeatOptions();
	};

	var ChangeRepeatOptions = function () {
		var repeatDropDown = elements.repeatOptions;
		if (repeatDropDown.val() != 'none') {
			$('#' + prefix + 'repeatUntilDiv').show();
		}
		else {
			$('div[id!=' + prefix + 'repeatOptions]', elements.repeatDiv).hide();
		}

		if (repeatDropDown.val() == 'daily') {
			$('.weeks', elements.repeatDiv).hide();
			$('.months', elements.repeatDiv).hide();
			$('.years', elements.repeatDiv).hide();

			$('.days', elements.repeatDiv).show();
		}

		if (repeatDropDown.val() == 'weekly') {
			$('.days', elements.repeatDiv).hide();
			$('.months', elements.repeatDiv).hide();
			$('.years', elements.repeatDiv).hide();

			$('.weeks', elements.repeatDiv).show();
		}

		if (repeatDropDown.val() == 'monthly') {
			$('.days', elements.repeatDiv).hide();
			$('.weeks', elements.repeatDiv).hide();
			$('.years', elements.repeatDiv).hide();

			$('.months', elements.repeatDiv).show();
		}

		if (repeatDropDown.val() == 'yearly') {
			$('.days', elements.repeatDiv).hide();
			$('.weeks', elements.repeatDiv).hide();
			$('.months', elements.repeatDiv).hide();

			$('.years', elements.repeatDiv).show();
		}
	};

	function InitializeDateElements() {
		elements.beginDate.change(function () {
			ToggleRepeatOptions();
		});

		elements.endDate.change(function () {
			ToggleRepeatOptions();
		});

		elements.beginTime.change(function () {
			ToggleRepeatOptions();
		});

		elements.endTime.change(function () {
			ToggleRepeatOptions();
		});
	}

	function InitializeRepeatElements() {
		elements.repeatOptions.change(function () {
			ChangeRepeatOptions();
			AdjustTerminationDate();
		});

		elements.repeatInterval.change(function () {
			AdjustTerminationDate();
		});

		elements.beginDate.change(function () {
			AdjustTerminationDate();
		});

		elements.repeatTermination.change(function () {
			terminationDateSetManually = true;
		});
	}

	function InitializeRepeatOptions() {
		if (options.repeatType) {
			elements.repeatOptions.val(options.repeatType);
			elements.repeatInterval.val(options.repeatInterval);
			for (var i = 0; i < options.repeatWeekdays.length; i++) {
				var id = '#' + prefix + 'repeatDay' + options.repeatWeekdays[i];
				$(id).attr('checked', true);
			}

			$("#" + prefix + "repeatOnMonthlyDiv :radio[value='" + options.repeatMonthlyType + "']").attr('checked', true);

			ChangeRepeatOptions();
		}
	}

	var ToggleRepeatOptions = function () {
		var SetValue = function (value, disabled) {
			elements.repeatOptions.val(value);
			elements.repeatOptions.trigger('change');
			if (disabled) {
				$('select, input', elements.repeatDiv).attr("disabled", 'disabled');
			}
			else {
				$('select, input', elements.repeatDiv).removeAttr("disabled");
			}
		};

		if (dateHelper.MoreThanOneDayBetweenBeginAndEnd(elements.beginDate, elements.beginTime, elements.endDate, elements.endTime)) {
			elements.repeatOptions.data["current"] = elements.repeatOptions.val();
			repeatToggled = true;
			SetValue('none', true);
		}
		else {
			if (repeatToggled) {
				SetValue(elements.repeatOptions.data["current"], false);
				repeatToggled = false;
			}
		}
	};

	var AdjustTerminationDate = function () {
		if (terminationDateSetManually) {
			return;
		}

		var newEndDate = new Date(elements.beginDate.val());
		var interval = parseInt(elements.repeatInterval.val());
		var currentEnd = new Date(elements.repeatTermination.val());

		var repeatOption = elements.repeatOptions.val();

		if (repeatOption == 'daily') {
			newEndDate.setDate(newEndDate.getDate() + interval);
		}
		else if (repeatOption == 'weekly') {
			newEndDate.setDate(newEndDate.getDate() + (7 * interval));
		}
		else if (repeatOption == 'monthly') {
			newEndDate.setMonth(newEndDate.getMonth() + interval);
		}
		else if (repeatOption = 'yearly') {
			newEndDate.setFullYear(newEndDate.getFullYear() + interval);
		}
		else {
			newEndDate = currentEnd;
		}

		elements.repeatTerminationTextbox.datepicker("setDate", newEndDate);
	};
}