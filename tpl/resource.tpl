{include file='header.tpl' DisplayWelcome='false'}
<div id="resourcebox">
<form class="resource" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
        {validator id="name" key="NameRequired"}
{/validation_group}

        <div class="resourceHeader"><h3>Resource Management</h3></div>
        <p>
                <label class="res-req">{translate key="ResourceName"}<br />
                {textbox name="RESOURCE_NAME" class="input" value="ResourceName" size="20" tabindex="10"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="ResourceLocation"}<br />
                {textbox name="RESOURCE_LOCATION" class="input" value="Location" size="20" tabindex="20"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="ContactInfo"}<br />
                {textbox name="CONTACT_INFO" class="input" value="ContactINfo" size="20" tabindex="30"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="Description"}<br />
                {textbox name="DESCRIPTION" class="input" value="Description" size="20" tabindex="40"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="ResourceNotes"}<br />
                {textbox name="RESOURCE_NOTES" class="input" value="Notes" size="20" tabindex="50"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MinDuration"} (HH:MM)<br />
                {textbox name="MIN_NOTICE" class="input" value="MinDuration" size="20" tabindex="60"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MaxDuration"} (D HH:MM)<br />
                {textbox name="MAX_DURATION" class="input" value="MaxDuration" size="20" tabindex="70"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MinIncrement"} (HH:MM)<br />
                {textbox name="MIN_INCREMENT" class="input" value="MinIncrement" size="20" tabindex="80"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="UnitCost"}<br />
                {textbox name="UNIT_COST" class="input" value="UnitCost" size="20" tabindex="90"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MaxParticipants"}<br />
                {textbox name="MAX_PARTICIPANTS" class="input" value="MaxParticipants" size="20" tabindex="100"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MinNotice"} (D HH:MM)<br />
                {textbox name="MIN_NOTICE" class="input" value="MinNotice" size="20" tabindex="110"}
                </label>
        </p>
        <p>
                <label class="res">{translate key="MaxNotice"} (D HH:MM)<br />
                {textbox name="MAX_NOTICE" class="input" value="MaxNotice" size="20" tabindex="120"}
                </label>
        </p>
        <p class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::ALLOW_MULTIDAY'}" 
				value="true" tabindex="160" /> {translate key="AllowMultiday"}</label>
        </p>
        <p class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::AUTO_ASSIGN'}" 
				value="true" tabindex="170" /> {translate key="AutoAssign"}</label>
        </p>
        <p class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::REQUIRES_APPROVAL'}" 
				value="true" tabindex="180" /> {translate key="RequiresApproval"}</label>
        </p>
        <p class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::IS_ACTIVE'}" 
				value="true" tabindex="190" /> {translate key="IsActive"}</label>
        </p>

        <p class="save">
                <input type="submit" name="{constant echo='Actions::SAVE'}" value="{translate key='Save'}" class="button" tabindex="200" />
        </p>
</form>
</div>
{setfocus key='RESOURCE_NAME'}
{include file='footer.tpl'}
