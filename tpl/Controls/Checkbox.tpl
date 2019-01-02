{*
Copyright 2014-2019 Nick Korbel

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
*}
<label class="booked-checkbox {$class}" id="{$id}">
	<button name="{$name}" type="button" class="btn btn-xs btn-default" value=""><span style="width:10px;"
																								  class="glyphicon"></span>
	</button>
	{$label}
</label>

<script type="text/javascript">
	$(function ()
	{
		$('#{$id}').on('click', function (e)
		{
			var btn = $(this).find('button');
			if (btn.val() == 'true')
			{
				btn.find('span').removeClass('glyphicon-ok');
				btn.val('');
			}
			else
			{
				btn.find('span').addClass('glyphicon-ok');
				btn.val('true');
			}
			e.preventDefault();
			e.stopPropagation();
		});
	});
</script>