{*
Copyright 2011-2020 Nick Korbel

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
    {include file='globalheader.tpl' TitleKey='EditReservationHeading' TitleArgs='' Qtip=true printCssFiles='css/reservation.print.css'}
{/block}

{block name=reservationHeader}
{translate key="EditReservationHeading" args=''}
{if $RequiresApproval}<span class="pendingApproval">({translate key=PendingApproval}){/if}
{/block}

{block name=submitButtons}
    <button id="submit-buttons{$submitSuffix}" type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-target="reservation-buttons-dropdown{$submitSuffix}" aria-expanded="false">
        <span class="hide-on-small-only">{translate key=More} <i class="material-icons right">arrow_drop_down</i></span>
        <span class="show-on-small hide-on-med-and-up"><i class="fa fa-ellipsis-v"></i> <i class="material-icons right">arrow_drop_down</i></span>
    </button>
    <ul id="reservation-buttons-dropdown{$submitSuffix}" class="dropdown-content" role="menu">
        <li>
            {assign var=icsUrl value="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
            <a href="{$icsUrl}" download="{$icsUrl}">
                <span class="fa fa-calendar"></span>
                {translate key=AddToOutlook}</a>
        </li>
        <li>
            <a href="http://www.google.com/calendar/event?action=TEMPLATE&text={$ReservationTitle|escape:'url'}&dates={formatdate date=$StartDate->ToUtc() key=google}/{formatdate date=$EndDate->ToUtc() key=google}&ctz={$StartDate->Timezone()}&details={$Description|escape:'url'}&location={$Resource->Name|escape:'url'}&trp=false&sprop=&sprop=name:"
               target="_blank" rel="nofollow">
            <span class="fa fa-google"></span>
                {translate key=AddToGoogleCalendar}</a>
        </li>
        {if $EmailEnabled}
        <li>
            <a href="#" class="btnSendEmail">
            <span class="fa fa-envelope"></span>
                {translate key=Email}</a>
        </li>
        {/if}
        <li>
            <a href="#" class="btnPrint">
                <span class="fa fa-print"></span>
                {translate key='Print'}</a>
        </li>
        <li>
            <a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::SOURCE_REFERENCE_NUMBER}={$ReferenceNumber}&{QueryStringKeys::REDIRECT}={$ReturnUrl|urlencode}">
                <span class="fa fa-copy"></span>
                {translate key='DuplicateReservation'}</a>
        </li>

        <li class="divider"></li>
        <li>
        {if $IsRecurring}
            <a href="#" class="delete prompt">
                <span class="fa fa-remove remove icon"></span>
                {translate key='Delete'}
            </a>
        {else}

            <a href="#" class="triggerDeletePrompt delete prompt-single">
                <span class="fa fa-remove remove icon"></span>
                {translate key='Delete'}
            </a>
        {/if}
        </li>
    </ul>

{if $CheckInRequired}
    <button type="button" class="btn btn-warning btnCheckin waves-effect waves-light">
    <i class="fa fa-sign-in"></i>
    {translate key=CheckIn}
        <span class="autoReleaseButtonMessage"
              data-autorelease-minutes="{$AutoReleaseMinutes}"> - {translate key=ReleasedIn} <span
                    class="autoReleaseMinutes"></span> {translate key=minutes}</span>
    </button>
{/if}
{if $CheckOutRequired}
    <button type="button" class="btn btn-warning btnCheckout waves-effect waves-light">
    <i class="fa fa-sign-out"></i> {translate key=CheckOut}
    </button>
{/if}
{if $IsRecurring}
    <button type="button" class="btn btn-primary update prompt">
        <i class="fa fa-check-circle-o"></i>
        {translate key='Update'}
    </button>
    <div class="modal modal-fixed-header modal-fixed-footer" id="updateButtons" tabindex="-1" role="dialog" aria-labelledby="updateButtonsLabel"
         aria-hidden="true">
        <div class="modal-header">
            <h4 class="modal-title left" id="updateButtonsLabel">{translate key=ApplyUpdatesTo}</h4>
             <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
        </div>
        <div class="modal-content">
            <div id="deleteRecurringButtons" class="no-show margin-bottom-15">
                <div>{translate key=DeleteReminderWarning}</div>
                <div class="input-field">
                <label for="deleteReasonRecurring">{translate key=Reason} ({translate key=Optional})</label>
                <textarea id="deleteReasonRecurring" class="materialize-textarea"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-primary save btnUpdateThisInstance waves-effect waves-light">
                    <i class="fa fa-check"></i>
                    {translate key='ThisInstance'}
                </button>
                <button type="button" class="btn btn-primary save btnUpdateAllInstances waves-effect waves-light">
                    <i class="fa fa-check-square"></i>
                    {translate key='AllInstances'}
                </button>
                <button type="button" class="btn btn-primary save btnUpdateFutureInstances waves-effect waves-light">
                    <i class="fa fa-check-square-o"></i>
                    {translate key='FutureInstances'}
                </button>
                <button type="button" class="btn btn-flat waves-effect waves-dark">
                    {translate key='Cancel'}
                </button>
            </div>
    </div>

{else}
    <button type="button" class="btn btn-primary save update btnEdit">
         <i class="fa fa-check-circle-o"></i>
        {translate key='Update'}
    </button>
{/if}

    <div id="deleteButtonPrompt" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4 class="modal-title left" id="updateButtonsLabel">{translate key=Delete}</h4>
             <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
        </div>
        <div class="modal-content">
            <div>{translate key=DeleteReminderWarning}</div>
            <div class="input-field">
                <label for="deleteReason">{translate key=Reason} ({translate key=Optional})</label>
                <textarea id="deleteReason" class="materialize-textarea"></textarea>
            </div>
         </div>
        <div class="modal-footer">
        {cancel_button id="cancelDelete" class="cancel"}
            {delete_button id="confirmDelete" class="delete save"}
       </div>
    </div>
    </div>
{/block}

{block name="ajaxMessage"}
    {translate key=UpdatingReservation}...
{/block}

{block name='attachments'}
    {if $Attachments|count > 0}
        <div class="col-xs-12">
    <div id="attachmentDiv" class="res-attachments">
        <span class="heading">{translate key=Attachments} ({$Attachments|count})</span>
        <a href="#" class="remove" id="btnRemoveAttachment">({translate key="Remove"})</a>
        <br/>
        {foreach from=$Attachments item=attachment}
            {assign var=attachmentUrl value="attachments/{Pages::RESERVATION_FILE}?{QueryStringKeys::ATTACHMENT_FILE_ID}={$attachment->FileId()}&{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
             <label style='display: none;margin-right:20px;'>
                <input  type="checkbox"
                   name="{FormKeys::REMOVED_FILE_IDS}[{$attachment->FileId()}]"/>
                  <span>{translate key="Remove"}</span>
            &nbsp;</label>
            <a href="{$attachmentUrl}" download="{$attachmentUrl}"
               target="_blank">{$attachment->FileName()}</a>

        {/foreach}
    </div>
    </div>
    {/if}
{/block}

{block name=extras}
{if $AutoReleaseMinutes != null}
    <input type="hidden" id="autoReleaseMinutes" value="{$AutoReleaseMinutes}"/>
{/if}

<div class="modal modal-fixed-header modal-fixed-footer" id="emailReservationPrompt" tabindex="-1" role="dialog"
     aria-labelledby="emailReservationLabel" aria-hidden="true">
    <form id="emailReservationForm" method="post" role="form" onkeypress="return event.keyCode != 13;">
            <div class="modal-header">
                <h4 class="modal-title" id="emailReservationLabel">{translate key=EmailReservation}</h4>
                 <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="form-group">
                    <label for="emailUserAutocomplete" class="no-show">{translate key=User}</label>
                    <input type="search" id="emailUserAutocomplete" name="email"
                           class="form-control" placeholder="{translate key=Email}" autofocus="autofocus" />
                </div>

                <div id="emailReservationList">

                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                <button type="button" class="btn btn-primary waves-effect waves-light" id="btnSendReservation">
                    <span class="fa fa-envelope"></span>
                    {translate key='Email'}
                </button>
                {indicator}
            </div>
    </form>
</div>
{/block}