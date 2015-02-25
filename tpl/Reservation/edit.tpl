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
{extends file="Reservation/create.tpl"}

{block name=header}
	{include file='globalheader.tpl' TitleKey='EditReservationHeading' TitleArgs='' cssFiles='css/reservation.css,css/jquery.qtip.min.css,scripts/css/jqtree.css'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=''}
{/block}

{block name=submitButtons}
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			{translate key=More} <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}">
				<span class="fa fa-calendar"></span>
				{translate key=AddToOutlook}</a>
			</li>
			<li><a href="#" class="btnPrint">
				<span class="fa fa-print"></span>
				{translate key='Print'}</a>
			</li>

			<li class="divider"></li>
			<li>
				{if $IsRecurring}
					<a href="#" class="delete prompt">
						<span class="fa fa-remove remove icon"></span>
						{translate key='Delete'}
					</a>
				{else}
					<a href="#" class="delete save">
						<span class="fa fa-remove remove icon"></span>
						{translate key='Delete'}
					</a>
				{/if}
			</li>
		</ul>
	</div>
	{if $IsRecurring}
		<button type="button" class="btn btn-success update prompt">
			<span class="glyphicon glyphicon-ok-circle"></span>
			{translate key='Update'}
		</button>
		<div class="updateButtons" title="{translate key=ApplyUpdatesTo}">
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
		<button type="button" class="btn btn-success save update btnCreate">
			<span class="glyphicon glyphicon-ok-circle"></span>
			{translate key='Update'}
		</button>
	{/if}
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...
	<br/>
{/block}

{block name='attachments'}
	<div style="clear:both">&nbsp;</div>
	<div id="attachmentDiv" class="res-attachments">
		<span class="heading">{translate key=Attachments} ({$Attachments|count})</span>
		{if $Attachments|count > 0}
			<a href="#" class="remove" id="btnRemoveAttachment">({translate key="Remove"})</a>
			<br/>
			{foreach from=$Attachments item=attachment}
				<a href="attachments/{Pages::RESERVATION_FILE}?{QueryStringKeys::ATTACHMENT_FILE_ID}={$attachment->FileId()}&{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"
				   target="_blank">{$attachment->FileName()}</a>
				&nbsp;
				<input style='display: none;' type="checkbox" name="{FormKeys::REMOVED_FILE_IDS}[{$attachment->FileId()}]"/>
				&nbsp;
			{/foreach}
		{/if}
	</div>
{/block}