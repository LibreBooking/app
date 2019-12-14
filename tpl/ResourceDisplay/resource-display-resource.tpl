{function name=displayReservation}
    <div class="resource-display-reservation">
        {format_date date=$reservation->StartDate() key=res_popup_time timezone=$Timezone}
        - {format_date date=$reservation->EndDate() key=res_popup_time timezone=$Timezone}
        | {$reservation->GetUserName()}
        <div class="title">{$reservation->GetTitle()|default:$NoTitle}</div>
    </div>
{/function}

<div id="resource-display" class="resource-display row no-margin">
    <div class="col s7 left-panel">
        <div class="resource-display-name">{$ResourceName}</div>

        <div class="resource-display-current">
            {if $AvailableNow}
                <div class="resource-display-available">{translate key=Available}</div>
            {else}
                <div class="resource-display-unavailable">{translate key=Unavailable}</div>
            {/if}

            {if $CurrentReservation != null}
                {call name=displayReservation reservation=$CurrentReservation}
            {/if}
        </div>

        <div class="left-panel-bottom">
            <div class="resource-display-heading">{translate key=NextReservation}</div>
            {if $NextReservation != null}
                {call name=displayReservation reservation=$NextReservation}
            {else}
                <div class="resource-display-reservation">{translate key=None}</div>
            {/if}

            {if $RequiresCheckin}
                <form role="form" method="post" id="formCheckin" action="{$smarty.server.SCRIPT_NAME}?action=checkin"
                      class="inline-block">
                    <input type="hidden" {formname key=REFERENCE_NUMBER} value="{$CheckinReferenceNumber}"/>
                    <div class="resource-display-action" id="checkin"><i
                                class="fa fa-check"></i> {translate key=CheckIn}</div>
                </form>
            {/if}
            <div class="resource-display-action" id="reservePopup"><i class="fa fa-plus"></i> {translate key=Reserve}
            </div>
        </div>
    </div>
    <div class="col s5 right-panel">
        <div class="time">{formatdate date=$Now key=period_time timezone=$Timezone}</div>
        <div class="date">{formatdate date=$Now key=schedule_daily timezone=$Timezone}</div>
        <div class="upcoming-reservations">
            <div class="resource-display-heading">{translate key=UpcomingReservations}</div>
            {if $UpcomingReservations|count > 0}
                {foreach from=$UpcomingReservations item=r name=upcoming}
                    <div class="resource-display-upcoming">
                        {call name=displayReservation reservation=$r}
                    </div>
                    {if !$smarty.foreach.upcoming.last}
                        <hr class="upcoming-separator"/>
                    {/if}
                {/foreach}
            {else}
                <div class="resource-display-none">{translate key=None}</div>
            {/if}
        </div>
    </div>

    <div id="reservation-box-wrapper">
    </div>
    <div id="reservation-box">
        <form role="form" method="post" id="formReserve" action="{$smarty.server.SCRIPT_NAME}?action=reserve">
            <div class="row margin-top-25">
                <div class="col s12">
                    <div id="validationErrors" class="validationSummary alert alert-danger no-show">
                        <ul>
                        </ul>
                    </div>
                    <div>
                        <table class="reservations">
                            <thead>
                            <tr>
                                {foreach from=$DailyLayout->GetPeriods($Today, true) item=period}
                                    <td class="reslabel" colspan="{$period->Span()}">{$period->Label($Today)}</td>
                                {/foreach}
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                {assign var=slots value=$DailyLayout->GetLayout($Today, $ResourceId)}
                                {foreach from=$slots item=slot}
                                    {assign var="referenceNumber" value=""}
                                    {if $slot->IsReserved()}
                                        {assign var="class" value="reserved"}
                                        {assign var="referenceNumber" value=$slot->Reservation()->ReferenceNumber}
                                    {elseif $slot->IsReservable()}
                                        {assign var="class" value="reservable"}
                                        {if $slot->IsPastDate(Date::Now())}
                                            {assign var="class" value="pasttime"}
                                        {/if}
                                    {else}
                                        {assign var="class" value="unreservable"}
                                    {/if}
                                    {if $slot->HasCustomColor()}
                                        {assign var=color value='style="background-color:'|cat:$slot->Color()|cat:';color:'|cat:$slot->TextColor()|cat:';"'}
                                    {/if}
                                    <td colspan="{$slot->PeriodSpan()}" {$color} data-begin="{$slot->Begin()}"
                                        data-end="{$slot->End()}"
                                        class="slot {$class}"
                                        data-refnum="{$referenceNumber}">{$slot->Label($SlotLabelFactory)|escape|default:'&nbsp;'}</td>
                                {/foreach}
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        <label for="emailAddress">{translate key=Email}</label>
                        <input id="emailAddress" type="email" required="required" {formname key=EMAIL} />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <div class="input-field">
                        <i class="material-icons prefix">access_time</i>
                        <label for="beginPeriod" class="active">{translate key=BeginDate}</label>
                        <select title="Begin" id="beginPeriod" {formname key=BEGIN_PERIOD}>
                            {foreach from=$slots item=slot}
                                {if $slot->IsReservable() && !$slot->IsPastDate($Today)}
                                    <option value="{$slot->Begin()}">{$slot->Begin()->Format($TimeFormat)}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col s6">
                    <div class="input-field">
                        <i class="material-icons prefix">access_time</i>
                        <label for="endPeriod" class="active">{translate key=EndDate}</label>
                        <select title="End" class="" id="endPeriod" {formname key=END_PERIOD}>
                            {foreach from=$slots item=slot}
                                {if $slot->IsReservable() && !$slot->IsPastDate($Today)}
                                    <option value="{$slot->End()}">{$slot->End()->Format($TimeFormat)}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>

            {if $Terms != null}
                <div class="row" id="termsAndConditions">
                    <label for="termsAndConditionsAcknowledgement">
                        <input type="checkbox"
                               id="termsAndConditionsAcknowledgement" {formname key=TOS_ACKNOWLEDGEMENT} {if $TermsAccepted}checked="checked"{/if}/>
                        <span>{translate key=IAccept}</span>
                    </label>
                    <a href="{$Terms->DisplayUrl()}" style="vertical-align: middle"  target="_blank">{translate key=TheTermsOfService}</a>
                </div>
            {/if}

            {if $Attributes|count > 0}
                <div class="row margin-top-25">
                    <div class="customAttributes col s12">
                        {foreach from=$Attributes item=attribute name=attributeEach}
                            {if $smarty.foreach.attributeEach.index % 2 == 0}
                                <div class="row">
                            {/if}
                            <div class="customAttribute col s6">
                                {control type="AttributeControl" attribute=$attribute}
                            </div>
                            {if $smarty.foreach.attributeEach.index % 2 ==1}
                                </div>
                            {/if}
                        {/foreach}
                        {if $Attributes|count % 2 == 1}
                            <div class="col s6">&nbsp;</div>
                        {/if}
                    </div>
                </div>
            {/if}

            <div class="row margin-top-25">
                <div class="col s12 text-center">
                    <input type="submit" class="action-reserve col-xs-12" value="Reserve"/>
                    <a href="#" class="action-cancel" id="reserveCancel">{translate key=Cancel}</a>
                </div>
            </div>

            <input type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}"/>
            <input type="hidden" {formname key=SCHEDULE_ID} value="{$ScheduleId}"/>
            <input type="hidden" {formname key=TIMEZONE} value="{$Timezone}"/>
        </form>
    </div>

</div>