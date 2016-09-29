{*
Copyright 2011-2016 Nick Korbel

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
	{include file='globalheader.tpl' TitleKey='EditReservationHeading'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading"}
{/block}

{block name=deleteButtons}
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			{translate key=More} <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li>
				{assign var=icsUrl value="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
				<a href="{$icsUrl}" download="{$icsUrl}">
					<span class="fa fa-calendar"></span>
					{translate key=AddToOutlook}</a>
			</li>
			<li><a href="#" class="btnPrint">
					<span class="fa fa-print"></span>
					{translate key='Print'}</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="#" class="delete {if $IsRecurring}prompt{else}save{/if}">
					<span class="fa fa-remove remove icon"></span>
					{translate key='Delete'}
				</a>
			</li>
		</ul>
	</div>
{/block}

<div class="modal fade" id="updateButtons" tabindex="-1" role="dialog" aria-labelledby="updateButtonsLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="updateButtonsLabel">{translate key=ApplyUpdatesTo}</h4>
			</div>
			<div class="modal-body">
				<button type="button" class="btn btn-success save btnUpdateThisInstance">
					<span class="fa fa-check"></span>
					{translate key='ThisInstance'}
				</button>
				<button type="button" class="btn btn-success save btnUpdateAllInstances">
					<span class="fa fa-check-square"></span>
					{translate key='AllInstances'}
				</button>
				<button type="button" class="btn btn-success save btnUpdateFutureInstances">
					<span class="fa fa-check-square-o"></span>
					{translate key='FutureInstances'}
				</button>
				<button type="button" class="btn btn-default">
					{translate key='Cancel'}
				</button>
			</div>
		</div>
	</div>
</div>

{block name=submitButtons}
	<button type="button" class="btn btn-success" id="btnApprove">
		<span class="glyphicon glyphicon-ok-circle"></span>
		{translate key='Approve'}
	</button>
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...
	<br/>
{/block}