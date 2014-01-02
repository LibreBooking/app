{*
Copyright 2011-2014 Nick Korbel

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
{extends file="Reservation/view.tpl"}

{block name=header}
	{include file='globalheader.tpl' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css,css/jquery.qtip.min.css'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=deleteButtons}
	{if $IsRecurring}
		<a href="#" class="delete prompt">
			{html_image src="cross-button.png"}
			{translate key='Delete'}
		</a>
		<div class="updateButtons" style="display:none;" title="{translate key=ApplyUpdatesTo}">
			<div style="text-align: center;line-height:50px;">
				<button type="button" class="button save btnUpdateThisInstance">
					{html_image src="disk-black.png"}
					{translate key='ThisInstance'}
				</button>
				<button type="button" class="button save btnUpdateAllInstances">
					{html_image src="disks-black.png"}
					{translate key='AllInstances'}
				</button>
				<button type="button" class="button save btnUpdateFutureInstances">
					{html_image src="disk-arrow.png"}
					{translate key='FutureInstances'}
				</button>
				<button type="button" class="button">
					{html_image src="slash.png"}
					{translate key='Cancel'}
				</button>
			</div>
		</div>
	{else}
		<a href="#" class="delete save">
			{html_image src="cross-button.png"}
			{translate key='Delete'}
		</a>
	{/if}
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