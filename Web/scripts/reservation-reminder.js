/**
 Copyright 2013-2020 Nick Korbel

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

function Reminder(opts)
{
	var options = opts;

	var elements = {
		startDiv:$('#reminderOptionsStart'),
		endDiv:$('#reminderOptionsEnd')
	};

	Reminder.prototype.init = function ()
	{
		$('.reminderTime').forceNumeric();

		var enable = function (div)
		{
			div.find('.reminderEnabled').attr('checked', 'checked');
			div.find('.reminderTime, .reminderInterval').removeAttr('disabled', 'disabled');
		};

		var disable = function (div)
		{
			div.find('.reminderEnabled').removeAttr('checked');
			div.find('.reminderTime, .reminderInterval').attr('disabled', 'disabled');
		};

		if (opts.reminderTimeStart != '')
		{
			enable(elements.startDiv);
			elements.startDiv.find('.reminderTime').val(opts.reminderTimeStart);
			elements.startDiv.find('.reminderInterval').val(opts.reminderIntervalStart);
		}
		else
		{
			disable(elements.startDiv);
		}

		if (opts.reminderTimeEnd != '')
		{
			enable(elements.endDiv);
			elements.endDiv.find('.reminderTime').val(opts.reminderTimeEnd);
			elements.endDiv.find('.reminderInterval').val(opts.reminderIntervalEnd);
		}
		else
		{
			disable(elements.endDiv);
		}

		var wireUp = function (div)
		{
			div.find('.reminderEnabled').change(function ()
			{
				if ($(this).is(':checked'))
				{
					enable(div);
				}
				else
				{
					disable(div);
				}
			});
		};

		wireUp(elements.startDiv);
		wireUp(elements.endDiv);
	};
}