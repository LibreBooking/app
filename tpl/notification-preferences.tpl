{include file='globalheader.tpl'}

{if $PreferencesUpdated}
<div class="success">{translate key=YourSettingsWereUpdated}</div>
{/if}

<div id="notificationPreferences" class="box-form">
    <form class="box-form" method="post" action="{$smarty.server.SCRIPT_NAME}">
        <div class="header">
            <h3 class="header">{translate key=NotificationPreferences}</h3>
        </div>

       <div style="display: table;">
            <div class="notification-row">
                <div class="notification-type">
                    When I create a reservation or a reservation is created on my behalf
                </div>
                <div class="notification-status">
                    <input id="createdYes" type="radio" name="{ReservationEvent::Created}" value="1" {if $Created}checked="checked"{/if}/><label
                        for="createdYes">Send me an email</label>
                    <br/>
                    <input id="createdNo" type="radio" name="{ReservationEvent::Created}" value="0" {if !$Created}checked="checked"{/if}/><label
                        for="createdNo">Do not notify me</label>
                </div>
            </div>

            <div class="notification-row alt">
                <div class="notification-type">
                    When I update a reservation or a reservation is updated on my behalf
                </div>
                <div class="notification-status">
                    <input id="updatedYes" type="radio" name="{ReservationEvent::Updated}" value="1" {if $Updated}checked="checked"{/if}/><label
                        for="updatedYes">Send me an email</label>
                    <br/>
                    <input id="updatedNo" type="radio" name="{ReservationEvent::Updated}" value="0" {if !$Updated}checked="checked"{/if}/><label
                        for="updatedNo">Do not notify me</label>
                </div>
            </div>

            <div class="notification-row">
                <div class="notification-type">
                    When my pending reservation is approved
                </div>
                <div class="notification-status">
                    <input id="approvedYes" type="radio" name="{ReservationEvent::Approved}" value="1" {if $Approved}checked="checked"{/if}/><label
                        for="approvedYes">Send me an email</label>
                    <br/>
                    <input id="approvedNo" type="radio" name="{ReservationEvent::Approved}" value="0" {if !$Approved}checked="checked"{/if}/><label
                        for="approvedNo">Do not notify me</label>
                </div>
            </div>
       </div>

        <div style="clear:both;">
            <button type="submit" class="button update prompt" name="{Actions::SAVE}">
                <img src="img/tick-circle.png"/>
            {translate key='Update'}
            </button>
        </div>
    </form>
</div>
{include file='globalfooter.tpl'}