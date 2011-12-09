{include file='globalheader.tpl'}

{if $PreferencesUpdated}
<div class="success">{translate key=YourSettingsWereUpdated}</div>
{/if}

{if !$EmailEnabled}
<div class="error">{translate key=EmailDisabled}</div>
{else}
<div id="notificationPreferences" class="box-form">
    <form class="box-form" method="post" action="{$smarty.server.SCRIPT_NAME}">
        <div class="header">
            <h3 class="header">{translate key=NotificationPreferences}</h3>
        </div>

       <div style="display: table;">
            <div class="notification-row">
                <div class="notification-type">
                    {translate key=ReservationCreatedPreference}
                </div>
                <div class="notification-status">
                    <input id="createdYes" type="radio" name="{ReservationEvent::Created}" value="1" {if $Created}checked="checked"{/if}/><label
                        for="createdYes">{translate key=PreferenceSendEmail}</label>
                    <br/>
                    <input id="createdNo" type="radio" name="{ReservationEvent::Created}" value="0" {if !$Created}checked="checked"{/if}/><label
                        for="createdNo">{translate key=PreferenceNoEmail}</label>
                </div>
            </div>

            <div class="notification-row alt">
                <div class="notification-type">
                    {translate key=ReservationUpdatedPreference}
                </div>
                <div class="notification-status">
                    <input id="updatedYes" type="radio" name="{ReservationEvent::Updated}" value="1" {if $Updated}checked="checked"{/if}/><label
                        for="updatedYes">{translate key=PreferenceSendEmail}</label>
                    <br/>
                    <input id="updatedNo" type="radio" name="{ReservationEvent::Updated}" value="0" {if !$Updated}checked="checked"{/if}/><label
                        for="updatedNo">{translate key=PreferenceNoEmail}</label>
                </div>
            </div>

            <div class="notification-row">
                <div class="notification-type">
                    {translate key=ReservationApprovalPreference}
                </div>
                <div class="notification-status">
                    <input id="approvedYes" type="radio" name="{ReservationEvent::Approved}" value="1" {if $Approved}checked="checked"{/if}/><label
                        for="approvedYes">{translate key=PreferenceSendEmail}</label>
                    <br/>
                    <input id="approvedNo" type="radio" name="{ReservationEvent::Approved}" value="0" {if !$Approved}checked="checked"{/if}/><label
                        for="approvedNo">{translate key=PreferenceNoEmail}</label>
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
{/if}


{include file='globalfooter.tpl'}