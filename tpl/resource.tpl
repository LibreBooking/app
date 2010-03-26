{include file='header.tpl' DisplayWelcome='false'}
<div id="resourcebox">
<form class="resource" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
        {validator id="name" key="NameRequired"}
{/validation_group}

        <div class="resourceHeader"><h3>Resource Management</h3></div>
        <p>
                <label class="res-req">{translate key="Name"}<br />
                {textbox name="NAME" class="input" value="ResourceName" size="20" tabindex="10"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="Location"}<br />
                {textbox name="LOCATION" class="input" value="Location" size="20" tabindex="20"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="Description"}<br />
                {textbox name="DESCRIPTION" class="input" value="Description" size="20" tabindex="30"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="Notes"}<br />
                {textbox name="NOTES" class="input" value="Notes" size="20" tabindex="40"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="IsActive"}<br />
                {textbox name="IS_ACTIVE" class="input" value="IsActive" size="20" tabindex="50"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MinDuration"}<br />
                {textbox name="MIN_NOTICE" class="input" value="MinDuration" size="20" tabindex="60"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MinIncrement"}<br />
                {textbox name="MIN_INCREMENT" class="input" value="MinIncrement" size="20" tabindex="70"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MaxDuration"}<br />
                {textbox name="MAX_DURATION" class="input" value="MaxDuration" size="20" tabindex="80"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="UnitCost"}<br />
                {textbox name="UNIT_COST" class="input" value="UnitCost" size="20" tabindex="90"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="AutoAssign"}<br />
                {textbox name="AUTO_ASSIGN" class="input" value="AutoAssign" size="20" tabindex="100"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="RequiresApproval"}<br />
                {textbox name="REQUIRES_APPROVAL" class="input" value="RequiresApproval" size="20" tabindex="110"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="AllowMultipleDayReservations"}<br />
                {textbox name="MULTIDAY_RESERVATIONS" class="input" value="AllowMultipleDayReservations" size="20" tabindex="120"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MaxParticipants"}<br />
                {textbox name="MAX_PARTICIPANTS" class="input" value="MaxParticipants" size="20" tabindex="130"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MinNotice"}<br />
                {textbox name="MIN_NOTICE" class="input" value="MinNotice" size="20" tabindex="140"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MaxNotice"}<br />
                {textbox name="MAX_NOTICE" class="input" value="MaxNotice" size="20" tabindex="150"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="Constraints"}<br />
                {textbox name="CONSTRAINTS" class="input" value="Constraints" size="20" tabindex="160"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="LongQuota"}<br />
                {textbox name="LONG_QUOTA" class="input" value="LongQuota" size="20" tabindex="170"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="DayQuota"}<br />
                {textbox name="DAY_QUOTA" class="input" value="DayQuota" size="20" tabindex="180"}
                </label>
        </p>

        <p class="save">
                <input type="submit" name="{constant echo='Actions::SAVE'}" value="{translate key='Save'}" class="button" tabindex="200" />
        </p>
</form>
</div>
{setfocus key='NAME'}
{include file='footer.tpl'}
