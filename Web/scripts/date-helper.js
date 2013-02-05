/**
 Copyright 2012 Nick Korbel

 This file is part of phpScheduleIt.

 phpScheduleIt is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 phpScheduleIt is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

var dateHelper = {
	oneDay: 86400000, //24*60*60*1000 => hours*minutes*seconds*milliseconds

	MoreThanOneDayBetweenBeginAndEnd:function (beginDateElement, beginTimeElement, endDateElement, endTimeElement) {

		var begin = this.GetDate(beginDateElement, beginTimeElement);
		var end = this.GetDate(endDateElement, endTimeElement);

		var timeBetweenDates = end.getTime() - begin.getTime();

		return timeBetweenDates > this.oneDay;
	},

	GetDate:function (dateElement, timeElement) {
		return new Date(dateElement.val() + 'T' + timeElement.val());
	},

	GetDateDifference:function (beginDateElement, beginTimeElement, endDateElement, endTimeElement) {
		var begin = this.GetDate(beginDateElement, beginTimeElement);
		var end = this.GetDate(endDateElement, endTimeElement);

		var difference = end - begin;
		var days = difference / this.oneDay;
		var hours = (days % 1) * 24;

		var roundedHours = (hours % 1) ? hours.toPrecision(2) : hours;
		var roundedDays = Math.floor(days);

		return {RoundedHours: roundedHours, RoundedDays: roundedDays};
	}

};