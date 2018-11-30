<div id="resource-display" class="resource-display">
    <div class="col-xs-7 left-panel">
        <div class="resource-display-name">Conference Room 1</div>
        {* unavailable
        <div class="resource-display-unavailable">Unavailable</div>*}
        {*<div class="resource-display-reservation">6:00 AM - 12:00 PM | Nick Korbel*}
        {*<div class="title">Some title of reservation here</div>*}
        {*</div>*}

        {* available *}
        <div class="resource-display-available">Available</div>

        <div class="left-panel-bottom">
            <div class="resource-display-heading">Next Reservation</div>
            {* next reservation *}
            {* <div class="resource-display-reservation">12:00 PM - 4:00 PM | Someone Else*}
            {*<div class="title">Another title</div>*}
            {*</div>*}
            {* requires checkin *}
            {* <div class="resource-display-action">Check In</div>*}
            {* available *}
            <div class="resource-display-reservation">None</div>
            <div class="resource-display-action"><i class="fa fa-plus"></i> Reserve</div>
        </div>
    </div>
    <div class="col-xs-5 right-panel">
        <div class="time">7:31 AM</div>
        <div class="date">Tuesday, November 27</div>
        <div class="upcoming-reservations">
            <div class="resource-display-heading">Upcoming Reservations</div>
            <div class="resource-display-none">None</div>
        </div>
    </div>

    <div id="reservation-box-wrapper">
        <div id="reservation-box">
            <form role="form" method="post" id="formReserve" action="{$smarty.server.SCRIPT_NAME}?action=reserve">
                <div class="row margin-top-25">
                    <div class="col-xs-12">
                        <div id="validationErrors" class="validationSummary alert alert-danger no-show">
                            <ul>
                                {validator id="emailformat" key="ValidEmailRequired"}
                            </ul>
                        </div>

                        <div id="reserveResults" class="no-show">
                        </div>

                        <div>
                            {* schedule *}
                            <table class="reservations">
                                <thead>
                                <tr>
                                    <td class="reslabel" colspan="2">12:00 AM</td>
                                    <td class="reslabel" colspan="2">1:00 AM</td>
                                    <td class="reslabel" colspan="2">2:00 AM</td>
                                    <td class="reslabel" colspan="2">3:00 AM</td>
                                    <td class="reslabel" colspan="2">4:00 AM</td>
                                    <td class="reslabel" colspan="2">5:00 AM</td>
                                    <td class="reslabel" colspan="2">6:00 AM</td>
                                    <td class="reslabel" colspan="2">7:00 AM</td>
                                    <td class="reslabel" colspan="2">8:00 AM</td>
                                    <td class="reslabel" colspan="2">9:00 AM</td>
                                    <td class="reslabel" colspan="2">10:00 AM</td>
                                    <td class="reslabel" colspan="2">11:00 AM</td>
                                    <td class="reslabel" colspan="2">12:00 PM</td>
                                    <td class="reslabel" colspan="2">1:00 PM</td>
                                    <td class="reslabel" colspan="2">2:00 PM</td>
                                    <td class="reslabel" colspan="2">3:00 PM</td>
                                    <td class="reslabel" colspan="2">4:00 PM</td>
                                    <td class="reslabel" colspan="2">5:00 PM</td>
                                    <td class="reslabel" colspan="2">6:00 PM</td>
                                    <td class="reslabel" colspan="2">7:00 PM</td>
                                    <td class="reslabel" colspan="2">8:00 PM</td>
                                    <td class="reslabel" colspan="2">9:00 PM</td>
                                    <td class="reslabel" colspan="2">10:00 PM</td>
                                    <td class="reslabel" colspan="2">11:00 PM</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot pasttime" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>
                                    <td colspan="1" class="slot reservable" data-refnum="" data-checkin="">&nbsp;</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="email-addon"><span
                                    class="glyphicon glyphicon-envelope"></span></span>
                            <input id="emailAddress" type="email" class="form-control"
                                   placeholder="{translate key=Email}"
                                   aria-describedby="email-addon" required="required" {formname key=EMAIL} />
                        </div>
                    </div>
                </div>
                <div class="row margin-top-25">
                    <div class="col-xs-6">
                        <div class="input-group input-group-lg has-feedback">
				<span class="input-group-addon" id="starttime-addon"><span
                            class="glyphicon glyphicon-time"></span></span>
                            <select title="Begin" class="form-control" aria-describedby="starttime-addon"
                                    id="beginPeriod" {formname key=BEGIN_PERIOD}>
                                {foreach from=$slots item=slot}
                                    {if $slot->IsReservable() && !$slot->IsPastDate($Today)}
                                        <option value="{$slot->Begin()}">{$slot->Begin()->Format($TimeFormat)}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="input-group input-group-lg">
				<span class="input-group-addon" id="endtime-addon"><span
                            class="glyphicon glyphicon-time"></span></span>
                            <select title="End" class="form-control input-lg" aria-describedby="endtime-addon"
                                    id="endPeriod" {formname key=END_PERIOD}>
                                {foreach from=$slots item=slot}
                                    {if $slot->IsReservable() && !$slot->IsPastDate($Today)}
                                        <option value="{$slot->End()}">{$slot->End()->Format($TimeFormat)}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>

                {if $Attributes|count > 0}
                    <div class="row margin-top-25">
                        <div class="customAttributes col-xs-12">
                            {foreach from=$Attributes item=attribute name=attributeEach}
                                {if $smarty.foreach.attributeEach.index % 2 == 0}
                                    <div class="row">
                                {/if}
                                <div class="customAttribute col-xs-6">
                                    {control type="AttributeControl" attribute=$attribute}
                                </div>
                                {if $smarty.foreach.attributeEach.index % 2 ==1}
                                    </div>
                                {/if}
                            {/foreach}
                            {if $Attributes|count % 2 == 1}
                                <div class="col-xs-6">&nbsp;</div>
                            {/if}
                        </div>
                    </div>
                {/if}

                <div class="row margin-top-25">
                    <div class="col-xs-12">
                        <input type="submit" class="action-reserve col-xs-12" value="Reserve"/>
                        <a href="#" class="action-cancel">Cancel</a>
                    </div>
                </div>

                <input type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}"/>
                <input type="hidden" {formname key=SCHEDULE_ID} value="{$ScheduleId}"/>
                <input type="hidden" {formname key=TIMEZONE} value="{$Timezone}"/>
            </form>
        </div>
    </div>
</div>