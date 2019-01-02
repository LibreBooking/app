/**
 Copyright 2012-2019 Nick Korbel

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
        repeatOptions: $('#' + prefix + 'repeatOptions'),
        repeatDiv: $('#' + prefix + 'repeatDiv'),
        repeatInterval: $('#' + prefix + 'repeatInterval'),
        repeatTermination: $('#' + prefix + 'formattedEndRepeat'),
        repeatTerminationTextbox: $('#' + prefix + 'EndRepeat'),
        beginDate: $('#' + prefix + 'formattedBeginDate'),
        endDate: $('#' + prefix + 'formattedEndDate'),
        beginTime: $('#' + prefix + 'BeginPeriod'),
        endTime: $('#' + prefix + 'EndPeriod'),
        repeatOnWeeklyDiv: $('#' + prefix + 'repeatOnWeeklyDiv'),
        repeatOnMonthlyDiv: $('#' + prefix + 'repeatOnMonthlyDiv')
    };

    var options = recurOptions;

    var elements = $.extend(e, recurElements);

    var repeatToggled = false;
    var terminationDateSetManually = recurOptions.autoSetTerminationDate || false;
    var changeCallback = null;

    this.init = function () {
        InitializeDateElements();
        InitializeRepeatElements();
        InitializeRepeatOptions();
        ToggleRepeatOptions();
    };

    this.onChange = function (callback) {
        changeCallback = callback;
    };

    var NotifyChange = function () {
        if (changeCallback) {
            changeCallback(elements.repeatOptions.val(),
                elements.repeatInterval.val(),
                elements.repeatOnWeeklyDiv.find(':checked').map(function (_, el) {
                    return $(el).val();
                }).get(),
                elements.repeatOnMonthlyDiv.find(':checked').map(function (_, el) {
                    return $(el).val();
                }).get(),
                elements.repeatTermination.val());
        }
    };

    var show = function (element) {
        element.removeClass('no-show').addClass('inline');
    };

    var hide = function (element) {
        element.removeClass('inline').addClass('no-show');
    };

    var ChangeRepeatOptions = function () {
        var repeatDropDown = elements.repeatOptions;
        if (repeatDropDown.val() != 'none') {
            show($('#' + prefix + 'repeatUntilDiv'));
        }
        else {
            hide($('.recur-toggle', elements.repeatDiv));
        }

        if (repeatDropDown.val() == 'daily') {
            hide($('.weeks', elements.repeatDiv));
            hide($('.months', elements.repeatDiv));
            hide($('.years', elements.repeatDiv));

            show($('.days', elements.repeatDiv));
        }

        if (repeatDropDown.val() == 'weekly') {
            hide($('.days', elements.repeatDiv));
            hide($('.months', elements.repeatDiv));
            hide($('.years', elements.repeatDiv));

            show($('.weeks', elements.repeatDiv));
        }

        if (repeatDropDown.val() == 'monthly') {
            hide($('.days', elements.repeatDiv));
            hide($('.weeks', elements.repeatDiv));
            hide($('.years', elements.repeatDiv));

            show($('.months', elements.repeatDiv));
        }

        if (repeatDropDown.val() == 'yearly') {
            hide($('.days', elements.repeatDiv));
            hide($('.weeks', elements.repeatDiv));
            hide($('.months', elements.repeatDiv));

            show($('.years', elements.repeatDiv));
        }

        NotifyChange();
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
            NotifyChange();
        });

        elements.repeatInterval.change(function () {
            AdjustTerminationDate();
            NotifyChange();
        });

        elements.beginDate.change(function () {
            AdjustTerminationDate();
            NotifyChange();
        });

        elements.repeatTermination.change(function () {
            terminationDateSetManually = true;
            NotifyChange();
        });
    }

    function InitializeRepeatOptions() {
        if (options.repeatType) {
            elements.repeatOptions.val(options.repeatType);
            elements.repeatInterval.val(options.repeatInterval == '' ? 1 : options.repeatInterval);
            ChangeRepeatOptions();

            for (var i = 0; i < options.repeatWeekdays.length; i++) {
                var id = '#' + prefix + 'repeatDay' + options.repeatWeekdays[i];
                if (!$(id).is(':checked')) {
                    $(id).closest('label').button('toggle');
                }
            }

            $("#" + prefix + "repeatOnMonthlyDiv :radio[value='" + options.repeatMonthlyType + "']").prop('checked', true);
        }

        elements.repeatOnWeeklyDiv.find('label').click(function(e){
            NotifyChange();
        });
        elements.repeatOnMonthlyDiv.find('label').click(function(e){
            NotifyChange();
        });
    }

    var ToggleRepeatOptions = function () {
        var SetValue = function (value, disabled) {
            elements.repeatOptions.val(value);
            elements.repeatOptions.trigger('change');
            if (disabled) {
                $('select, input', elements.repeatDiv).prop("disabled", 'disabled');
            }
            else {
                $('select, input', elements.repeatDiv).removeAttr("disabled");
            }
        };

        if (dateHelper.MoreThanOneDayBetweenBeginAndEnd(elements.beginDate, elements.beginTime, elements.endDate, elements.endTime)) {
            elements.repeatOptions.data["current"] = elements.repeatOptions.val();
            repeatToggled = true;
            if (elements.repeatOptions.val() == 'daily') {
                elements.repeatOptions.val('none');
                elements.repeatOptions.trigger('change');
            }
            elements.repeatOptions.find("option[value='daily']").prop("disabled", "disabled");
            elements.repeatOnWeeklyDiv.addClass('no-show');
        }
        else {
            if (repeatToggled) {
                SetValue(elements.repeatOptions.data["current"], false);
                repeatToggled = false;
            }
            elements.repeatOptions.find("option[value='daily']").removeAttr("disabled");

        }
    };

    var AdjustTerminationDate = function () {
        if (terminationDateSetManually) {
            return;
        }

        var newEndDate = new Date(elements.endDate.val());
        var interval = parseInt(elements.repeatInterval.val());
        var currentEnd = new Date(elements.repeatTermination.val());

        var repeatOption = elements.repeatOptions.val();

        if (repeatOption == 'daily') {
            newEndDate.setDate(newEndDate.getDate() + interval);
        }
        else if (repeatOption == 'weekly') {
            newEndDate.setDate(newEndDate.getDate() + (8 * interval));
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