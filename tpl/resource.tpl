{include file='header.tpl' DisplayWelcome='false'}
<div id="resourcebox">
<form class="resource" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
        {validator id="name" key="NameRequired"}
{/validation_group}

	<div class="resourceHeader"><h3>Resource Management</h3></div>
	<div id="resourcebox-leftcolumn">
		<ul class="no-style">
			<li class="res-req">
                <label>{translate key="ResourceName"}<br />
                {textbox name="RESOURCE_NAME" class="input" value="resourceName" tabindex="10"}
                </label>
        	</li>
        	<li class="res">
                <label>{translate key="ResourceLocation"}<br />
                {textbox name="LOCATION" class="input" value="location" tabindex="20"}
                </label>
        	</li>
        	<li class="res">
                <label>{translate key="ContactInfo"}<br />
                {textbox name="CONTACT_INFO" class="input" value="contactInfo" tabindex="30"}
                </label>
        	</li>
        	<li class="res">
                <label>{translate key="Description"}<br />
                {textbox name="DESCRIPTION" class="input" value="description" tabindex="40"}
                </label>
        	</li>
			<li class="res">
                <label>{translate key="UnitCost"}
                {textbox name="UNIT_COST" class="input" value="unitCost" tabindex="50"}
                </label>
        	</li>
        	<li class="res">
                <label>{translate key="MaxParticipants"}
                {textbox name="MAX_PARTICIPANTS" class="input" value="maxParticipants" tabindex="60"}
                </label>
        	</li>
			<li class="res-box">
                <label>{translate key="ResourceNotes"}<br />
                {textbox name="NOTES" class="input" value="notes" tabindex="70"}
                </label>
        	</li>
        </ul>
	</div>
	<div id="resourcebox-rightcolumn">
		<ul class="no-style">
			<li class="res">
                <label class="res">{translate key="MinDuration"} (HH:MM)<br />
                {textbox name="MIN_DURATION" class="input" value="minDuration" tabindex="80"}
                </label>
        	</li>
        	<li class="res">
                <label class="res">{translate key="MaxDuration"} (D HH:MM)<br />
                {textbox name="MAX_DURATION" class="input" value="maxDuration" tabindex="90"}
                </label>
        	</li>
        	<li class="res">
                <label class="res">{translate key="MinIncrement"} (HH:MM)<br />
                {textbox name="MIN_INCREMENT" class="input" value="minIncrement" tabindex="100"}
                </label>
        	</li>
        	<li class="res">
                <label class="res">{translate key="MinNotice"} (D HH:MM {translate key="Before"})<br />
                {textbox name="MIN_NOTICE" class="input" value="minNotice" tabindex="110"}
                </label>
        	</li>
        	<li class="res">
                <label class="res">{translate key="MaxNotice"} (D HH:MM {translate key="Before"})<br />
                {textbox name="MAX_NOTICE" class="input" value="maxNotice" tabindex="120"}
                </label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::ALLOW_MULTIDAY'}" 
				value="true" tabindex="160" /> {translate key="AllowMultiday"}</label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::AUTO_ASSIGN'}" 
				value="true" tabindex="170" /> {translate key="AutoAssign"}</label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::REQUIRES_APPROVAL'}" 
				value="true" tabindex="180" /> {translate key="RequiresApproval"}</label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::IS_ACTIVE'}" 
				value="true" tabindex="190" /> {translate key="IsActive"}</label>
        	</li>
    	</ul>
	</div>
	<div id="resourcebox-footer">
        <p class="save">
                <input type="submit" name="{constant echo='Actions::SAVE'}" value="{translate key='Save'}" class="button" tabindex="200" />
        </p>
	</div>
</form>
</div>
{setfocus key='RESOURCE_NAME'}
{include file='footer.tpl'}
