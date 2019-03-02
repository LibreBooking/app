{*
Copyright 2011-2019 Nick Korbel

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

{include file='globalheader.tpl' TitleKey='ViewReservationHeading' Qtip=true Owl=true printCssFiles='css/reservation.print.css'}
<div id="page-view-reservation">
    <div id="reservation-box" class="readonly">
        <div id="reservationFormDiv">
            <div class="row">
                {assign var="detailsCol" value="col-xs-12"}
                {assign var="participantCol" value="col-xs-12"}

                {if $ShowParticipation && $AllowParticipation && $ShowReservationDetails}
                    {assign var="detailsCol" value="col-xs-12 col-sm-6"}
                    {assign var="participantCol" value="col-xs-12 col-sm-6"}
                {/if}

                <div id="reservationDetails" class="{$detailsCol}">
                    <div class="col-xs-12">
                        <label>{translate key='User'}</label>
                        {if $ShowUserDetails && $ShowReservationDetails}
                            <a href="#" class="bindableUser" data-userid="{$UserId}">{$ReservationUserName}</a>
                            <input id="userId" type="hidden" value="{$UserId}"/>
                        {else}
                            {translate key=Private}
                        {/if}
                    </div>

                    <div class="col-xs-12">
                        <div class="col-md-6 no-padding-left">
                            <label>{translate key='BeginDate'}</label> {formatdate date=$StartDate}
                            <input type="hidden" id="formattedBeginDate"
                                   value="{formatdate date=$StartDate key=system}"/>
                            {foreach from=$StartPeriods item=period}
                                {if $period eq $SelectedStart}
                                    {$period->Label()}
                                    <input type="hidden" id="BeginPeriod" value="{$period->Begin()}"/>
                                {/if}
                            {/foreach}
                        </div>
                        <div class="col-md-6 no-padding-left">
                            <label>{translate key='EndDate'}</label> {formatdate date=$EndDate}
                            <input type="hidden" id="formattedEndDate" value="{formatdate date=$EndDate key=system}"/>
                            {foreach from=$EndPeriods item=period}
                                {if $period eq $SelectedEnd}
                                    {$period->LabelEnd()}
                                    <input type="hidden" id="EndPeriod" value="{$period->End()}"/>
                                {/if}
                            {/foreach}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        {*<span class="like-label">{translate key=ReservationLength}</span>*}
                        <div class="durationText">
                            <span id="durationDays">0</span> {translate key=days}
                            <span id="durationHours">0</span> {translate key=hours}
                            <span id="durationMinutes">0</span> {translate key=minutes}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <label>{translate key='RepeatPrompt'}</label> {translate key=$RepeatOptions[$RepeatType]['key']}
                        {if $IsRecurring}
                            <div class="repeat-details">
                                <label>{translate key='RepeatEveryPrompt'}</label> {$RepeatInterval} {$RepeatOptions[$RepeatType]['everyKey']}
                                {if $RepeatMonthlyType neq ''}
                                    ({$RepeatMonthlyType})
                                {/if}
                                {if count($RepeatWeekdays) gt 0}
                                    <br/>
                                    <label>{translate key='RepeatDaysPrompt'}</label>
                                    {foreach from=$RepeatWeekdays item=day}{translate key=$DayNames[$day]} {/foreach}
                                {/if}
                                <br/><label>{translate key='RepeatUntilPrompt'}</label> {formatdate date=$RepeatTerminationDate}
                            </div>
                        {/if}
                    </div>

                    <div class="col-xs-12">
                        <div class="pull-left">
                            <label>{translate key='Resources'}</label> {$ResourceName}
                            <input id="primaryResourceId" type="hidden" value="{$ResourceId}"/>
                            <div id="additionalResources" class="inline">
                                {foreach from=$AvailableResources item=resource}
                                    {if is_array($AdditionalResourceIds) && in_array($resource->Id, $AdditionalResourceIds)}
                                        ,{$resource->Name}
                                        <input class="resourceId" type="hidden" value="{$resource->Id}"/>
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                        <div class="pull-right">
                            {if $ShowReservationDetails}
                                <label>{translate key='Accessories'}</label>
                                {foreach from=$Accessories item=accessory name=accessoryLoop}
                                    <span class="badge quantity">{$accessory->QuantityReserved}</span>
                                    {if $smarty.foreach.accessoryLoop.last}
                                        {$accessory->Name}
                                    {else}
                                        {$accessory->Name},
                                    {/if}
                                {/foreach}
                            {/if}
                        </div>
                    </div>

                    {if $ShowReservationDetails}
                        <div class="col-xs-12">
                            <label>{translate key='ReservationTitle'}</label>
                            {if $ReservationTitle neq ''}
                                {$ReservationTitle}
                            {else}
                                <span class="no-data">{translate key='None'}</span>
                            {/if}
                        </div>
                        <div class="col-xs-12">
                            <label>{translate key='ReservationDescription'}</label>
                            {if $Description neq ''}
                                <br/>
                                {$Description|nl2br}
                            {else}
                                <span class="no-data">{translate key='None'}</span>
                            {/if}
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label>{translate key=ReferenceNumber}</label>
                                {$ReferenceNumber}
                            </div>
                        </div>
                    {/if}
                </div>

                {if $ShowParticipation && $AllowParticipation && $ShowReservationDetails}
                    <div class="{$participantCol}">
                        <div id="reservationParticipation">
                            <div id="participationAction" class="participationAction">
                                {if $IAmParticipating && $CanAlterParticipation}
                                    <div class="alert alert-info" role="alert">
                                        <strong>{translate key=YouAreAParticipant}</strong>
                                        {if $IsRecurring}
                                            <button value="{InvitationAction::CancelAll}"
                                                    class="btn btn-xs btn-info participationAction">
                                                <i class="fa fa-minus-square"></i> {translate key=AllInstances}
                                            </button>
                                            <button value="{InvitationAction::CancelInstance}"
                                                    class="btn btn-xs btn-info participationAction">
                                                <i class="fa fa-minus-square"></i> {translate key=ThisInstance}
                                            </button>
                                        {else}
                                            <button value="{InvitationAction::CancelInstance}"
                                                    class="btn btn-xs btn-info participationAction">
                                                <i class="fa fa-minus-square"></i> {translate key=CancelParticipation}
                                            </button>
                                        {/if}
                                    </div>
                                {/if}
                            </div>

                            <div id="invitationAction" class="participationAction">
                                {if $IAmInvited && $CanAlterParticipation}
                                    <div class="alert alert-info" role="alert">
                                        <strong>{translate key=YouAreInvited}</strong>
                                        <button value="{InvitationAction::Accept}"
                                                class="btn btn-xs btn-info participationAction">
                                            <i class="fa fa-user-plus"></i> {translate key="Attending"}
                                        </button>
                                        <button value="{InvitationAction::Decline}"
                                                class="btn btn-xs btn-danger  participationAction">
                                            <i class="fa fa-user-times"></i> {translate key="NotAttending"}
                                        </button>
                                    </div>
                                {/if}
                            </div>

                            <div id="joinReservation" class="participationAction">
                                {if $AllowParticipantsToJoin && !$IAmParticipating && !$IAmInvited && $CanAlterParticipation}
                                    <div class="alert alert-info " role="alert">
                                        <strong>{translate key=YouCanJoinThisReservation}</strong>
                                        {if $IsRecurring}
                                            <button value="{InvitationAction::JoinAll}" id="btnJoinSeries"
                                                    class="btn btn-xs btn-info participationAction">
                                                <i class="fa fa-user-plus"></i> {translate key="AllInstances"}
                                            </button>
                                            <button value="{InvitationAction::Join}" id="btnJoinInstance"
                                                    class="btn btn-xs btn-info participationAction">
                                                <i class="fa fa-user-plus"></i> {translate key="ThisInstance"}
                                            </button>
                                        {else}
                                            <button value="{InvitationAction::Join}" id="btnJoin"
                                                    class="btn btn-xs btn-info participationAction">
                                                <i class="fa fa-user-plus"></i> {translate key="Join"}
                                            </button>
                                        {/if}
                                    </div>
                                {/if}
                            </div>

                            <span id="participate-indicator" class="fa fa-spinner fa-spin" style="display:none;"></span>

                            {if $ShowUserDetails}
                                <div id="ro-participantList">
                                    <label>{translate key='ParticipantList'}</label>
                                    {foreach from=$Participants item=participant}
                                        <div><a href="#" class="bindableUser"
                                                data-userid="{$participant->UserId}">{$participant->FullName}</a></div>
                                        {foreachelse}
                                        <div class="no-data">{translate key='None'}</div>
                                    {/foreach}
                                </div>
                                <div id="ro-inviteeList">
                                    <label>{translate key='InvitationList'}</label>
                                    {foreach from=$Invitees item=invitee}
                                        <div><a href="#" class="bindableUser"
                                                data-userid="{$invitee->UserId}">{$invitee->FullName}</a></div>
                                        {foreachelse}
                                        <div class="no-data">{translate key='None'}</div>
                                    {/foreach}
                                </div>
                            {/if}
                        </div>
                    </div>
                {/if}

                <div class="col-xs-12 same-height">
                    <div id="custom-attributes-placeholder" class="col-xs-12">
                    </div>
                </div>

                {if $ShowReservationDetails}
                    <div class="col-xs-12 buttons">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" onclick="window.location='{$ReturnUrl}'">
                                {translate key='Close'}
                            </button>

                            {block name="deleteButtons"}
                                {if $CanJoinWaitList}
                                    <button id="btnWaitList" class="btn btn-default"><span
                                                class="fa fa-bell-o"></span> {translate key='NotifyWhenAvailable'}
                                    </button>
                                {/if}

                                {assign var=icsUrl value="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
                                <a href="{$icsUrl}" download="{$icsUrl}" class="btn btn-default">
                                    <span class="fa fa-calendar"></span>
                                    {translate key=AddToOutlook}</a>
                                <a href="http://www.google.com/calendar/event?action=TEMPLATE&text={$ReservationTitle|escape:'url'}&dates={formatdate date=$StartDate->ToUtc() key=google}/{formatdate date=$EndDate->ToUtc() key=google}&ctz={$StartDate->Timezone()}&details={$Description|escape:'url'}&location={$Resource->Name|escape:'url'}&trp=false&sprop=&sprop=name:"
                                   target="_blank" rel="nofollow" class="btn btn-default">
                                    <span class="fa fa-google"></span>
                                    {translate key=AddToGoogleCalendar}</a>
                                <button type="button" class="btnPrint btn btn-default">
                                    <span class="fa fa-print"></span>
                                    {translate key='Print'}</button>
                            {/block}

                            {block name="submitButtons"}
                                {if $CheckInRequired}
                                    <button type="button" class="btn btn-warning btnCheckin"><i
                                                class="fa fa-sign-in"></i> {translate key=CheckIn}<span
                                                class="autoReleaseButtonMessage"
                                                data-autorelease-minutes="{$AutoReleaseMinutes}"> - {translate key=ReleasedIn}
										<span class="autoReleaseMinutes"></span> {translate key=minutes}</span></button>
                                {/if}
                                {if $CheckOutRequired}
                                    <button type="button" class="btn btn-warning btnCheckout"><i
                                                class="fa fa-sign-out"></i> {translate key=CheckOut}</button>
                                {/if}
                            {/block}
                        </div>
                    </div>
                {/if}
            </div>
            {if $ShowReservationDetails}
                {if $Attachments|count > 0}
                    <div class="col-xs-12">
                        <div class="res-attachments">
                            <span class="heading">{translate key=Attachments} ({$Attachments|count})</span>
                            <br/>
                            {foreach from=$Attachments item=attachment}
                                {assign var=attachmentUrl value="attachments/{Pages::RESERVATION_FILE}?{QueryStringKeys::ATTACHMENT_FILE_ID}={$attachment->FileId()}&{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
                                <a href="{$attachmentUrl}" download="{$attachmentUrl}"
                                   target="_blank">{$attachment->FileName()}</a>
                                &nbsp;
                            {/foreach}
                        </div>
                    </div>
                {/if}
            {/if}
            <input type="hidden" id="referenceNumber" {formname key=reference_number} value="{$ReferenceNumber}"/>
        </div>
    </div>

    <div id="wait-box" class="wait-box">
        <div id="creatingNotification">
            <h3 id="createUpdateMessage" class="no-show">
                {block name="ajaxMessage"}
                    {translate key=UpdatingReservation}
                {/block}
            </h3>
            <h3 id="joiningWaitingList" class="no-show">
                {translate key=AddingToWaitlist}
            </h3>
            <h3 id="checkingInMessage" class="no-show">
                {translate key=CheckingIn}
            </h3>
            <h3 id="checkingOutMessage" class="no-show">
                {translate key=CheckingOut}
            </h3>
            {html_image src="reservation_submitting.gif"}
        </div>
        <div id="result"></div>
    </div>


    <div style="display: none">
        <form id="form-reservation" method="post" enctype="application/x-www-form-urlencoded">
            <input type="hidden" {formname key=RESERVATION_ID} value="{$ReservationId}"/>
            <input type="hidden" {formname key=REFERENCE_NUMBER} value="{$ReferenceNumber}"/>
            <input type="hidden" {formname key=RESERVATION_ACTION} value="{$ReservationAction}"/>
            <input type="hidden" {formname key=SERIES_UPDATE_SCOPE} id="hdnSeriesUpdateScope" value="{SeriesUpdateScope::FullSeries}"/>
            <input type="hidden" {formname key=DELETE_REASON} value="" id="hdnDeleteReason"/>
            <input type="hidden" {formname key=BEGIN_DATE} value="{formatdate date=$StartDate key=system}"/>
            <input type="hidden" {formname key=BEGIN_PERIOD} value="{$SelectedStart->Begin()}"/>
            <input type="hidden" {formname key=END_DATE} value="{formatdate date=$EndDate key=system}"/>
            <input type="hidden" {formname key=END_PERIOD} value="{$SelectedEnd->End()}"/>
            <input type="hidden" {formname key=USER_ID} value="{$UserId}"/>
            <input type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}"/>
            {csrf_token}
        </form>
    </div>
</div>

{include file="javascript-includes.tpl" Qtip=true Owl=true}
{jsfile src="participation.js"}
{jsfile src="approval.js"}
{jsfile src="js/jquery.autogrow.js"}
{jsfile src="resourcePopup.js"}
{jsfile src="userPopup.js"}
{jsfile src="date-helper.js"}
{jsfile src="recurrence.js"}
{jsfile src="reservation.js"}
{jsfile src="autocomplete.js"}
{jsfile src="force-numeric.js"}
{jsfile src="reservation-reminder.js"}
{jsfile src="ajax-helpers.js"}
{jsfile src="js/tree.jquery.js"}

<script type="text/javascript">

    $(document).ready(function () {

        var participationOptions = {
            responseType: 'json'
        };

        var participation = new Participation(participationOptions);
        participation.initReservation();

        var approvalOptions = {
            responseType: 'json',
            url: "{$Path}ajax/reservation_approve.php",
            returnUrl: '{$ReturnUrl}'
        };

        var approval = new Approval(approvalOptions);
        approval.initReservation();

        var scopeOptions = {
            instance: '{SeriesUpdateScope::ThisInstance}',
            full: '{SeriesUpdateScope::FullSeries}',
            future: '{SeriesUpdateScope::FutureInstances}'
        };

        var reservationOpts = {
            returnUrl: '{$ReturnUrl}',
            scopeOpts: scopeOptions,
            deleteUrl: 'ajax/reservation_delete.php',
            checkinUrl: 'ajax/reservation_checkin.php?action={ReservationAction::Checkin}',
            checkoutUrl: 'ajax/reservation_checkin.php?action={ReservationAction::Checkout}',
            userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}",
            changeUserAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::MyUsers}",
            waitlistUrl: 'ajax/reservation_waitlist.php',
        };
        var reservation = new Reservation(reservationOpts);
        reservation.init('{$UserId}');

        var ajaxOptions = {
            target: '#result',   // target element(s) to be updated with server response
            beforeSubmit: reservation.preSubmit,  // pre-submit callback
            success: reservation.showResponse  // post-submit callback
        };

        $('#form-reservation').submit(function () {
            $(this).ajaxSubmit(ajaxOptions);
            return false;
        });

        $.blockUI.defaults.css.width = '60%';
        $.blockUI.defaults.css.left = '20%';
    });

</script>
{include file='globalfooter.tpl'}