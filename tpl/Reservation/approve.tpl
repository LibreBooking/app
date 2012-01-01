{*
Copyright 2011-2012 Nick Korbel

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
*}
{extends file="Reservation/view.tpl"}

{block name=header}
	{include file='globalheader.tpl' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css,css/jquery.qtip.min.css'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=deleteButtons}
	<button type="button" class="button delete save">
		<img src="img/cross-button.png" />
		{translate key='Delete'}
	</button>
{/block}

{block name=submitButtons}
	<button type="button" class="button" id="btnApprove">
		<img src="img/tick-circle.png" />
		{translate key='Approve'}
	</button>
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...<br/>
{/block}