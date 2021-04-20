var dateHelper = function ()
{
	var oneDay = 86400000; //24*60*60*1000 => hours*minutes*seconds*milliseconds

	var getDifference = function (end, begin)
	{
		var difference = end.getTime() - begin.getTime();
        var duration = moment.duration(difference);
		return {RoundedHours: duration.hours(), RoundedDays: Math.floor(duration.asDays()), RoundedMinutes: duration.minutes()};
	};

	var parse = function(time)
	{
		var s = time.split(':');

		var hms= {h:s[0],m:s[1],s:[2]};

		return moment().hour(hms.h).minute(hms.m).second(hms.s);
	};

	return {
		MoreThanOneDayBetweenBeginAndEnd: function (beginDateElement, beginTimeElement, endDateElement, endTimeElement)
		{

			var begin = this.GetDate(beginDateElement, beginTimeElement);
			var end = this.GetDate(endDateElement, endTimeElement);

			var timeBetweenDates = end.toDate().getTime() - begin.toDate().getTime();

			return timeBetweenDates > oneDay;
		},

		GetDate: function (dateElement, timeElement)
		{
			return moment(dateElement.val() + 'T' + timeElement.val(), 'YYYY-MM-DDTHH:mm:ss');
		},

		GetDateDifference: function (beginDateElement, beginTimeElement, endDateElement, endTimeElement)
		{
			var begin = this.GetDate(beginDateElement, beginTimeElement);
			var end = this.GetDate(endDateElement, endTimeElement);

			return getDifference(end.toDate(), begin.toDate());
		},

		AddTimeDiff : function(diff, time){
			var d = parse(time);
			return d.add('ms', diff).format('HH:mm') + ':00';
		},

		GetTimeDifference: function (beginTime, endTime)
		{
			var start = parse(beginTime);
			var end = parse(endTime);

			return end.toDate().getTime() - start.toDate().getTime();
		}
	};
}();
