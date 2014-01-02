<?php
/**
Copyright 2011-2014 Nick Korbel

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

if ($_GET['ajax'] == '1')
{
	for ($i = 0; $i < 10000000; $i++)
	{

	}
}
else {
?>
<html>
<head>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.2.min.js"></script>
</head>

<div id="1">

</div>

<script type="text/javascript">
	var success1 = function () {
		$("#1").append('<p>1- '+ new Date() + '</p>');
	};
	var success2 = function () {
		$("#1").append('<p>2- '+ new Date() + '</p>');
	};

	$(document).ready(function () {
		$("#1").append('<p>1- '+ new Date() + '</p>');
		$("#1").append('<p>2- '+ new Date() + '</p>');

		$.ajax({
			url:'test.php?ajax=1',
			success:success1
		});
		$.ajax({
			url:'test2.php?ajax=1',
			success:success2
		});
	});
</script>
</html>

<?php
}
?>