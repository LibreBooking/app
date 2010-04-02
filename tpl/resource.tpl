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
        	<li class="res-box-s">
                <label>{translate key="ResourceLocation"}<br />
	                <textarea name="{constant echo='FormKeys::LOCATION'}" class="input-area" rows="2" cols="52" tabindex="20"></textarea>
                </label>
        	</li>
        	<li class="res-box-m">
                <label>{translate key="ContactInfo"}<br />
	                <textarea name="{constant echo='FormKeys::CONTACT_INFO'}" class="input-area" rows="3" cols="52" tabindex="30"></textarea>
                </label>
        	</li>
        	<li class="res-box-l">
                <label>{translate key="Description"}<br />
	                <textarea name="{constant echo='FormKeys::DESCRIPTION'}" class="input-area" rows="4" cols="52" tabindex="40"></textarea>
                </label>
        	</li>
			<li class="res-box-xl">
                <label>{translate key="ResourceNotes"}<br />
                	<textarea name="{constant echo='FormKeys::NOTES'}" class="input-area" rows="6" cols="52" tabindex="50"></textarea>
                </label>
        	</li>
        </ul>
	</div>
	<div id="resourcebox-rightcolumn">
		<ul class="no-style">
			<li class="res">
                <label>{translate key="UnitCost"}
                {textbox name="UNIT_COST" class="input" value="unitCost" tabindex="60"}
                </label>
        	</li>
        	<li class="res">
                <label>{translate key="MaxParticipants"}
                {textbox name="MAX_PARTICIPANTS" class="input" value="maxParticipants" tabindex="70"}
                </label>
        	</li>
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
                <label class="res">{translate key="MaxNotice"} (D HH:MM {translate key="Before"})<br />
                {textbox name="MAX_NOTICE" class="input" value="maxNotice" tabindex="110"}
                </label>
        	</li>
        	<li class="res">
                <label class="res">{translate key="MinNotice"} (D HH:MM {translate key="Before"})<br />
                {textbox name="MIN_NOTICE" class="input" value="minNotice" tabindex="120"}
                </label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::ALLOW_MULTIDAY'}" 
				checked="checked" tabindex="160" /> {translate key="AllowMultiday"}</label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::AUTO_ASSIGN'}" 
				checked="checked" tabindex="170" /> {translate key="AutoAssign"}</label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::REQUIRES_APPROVAL'}" 
				tabindex="180" /> {translate key="RequiresApproval"}</label>
        	</li>
        	<li class="res-checkbox">
		       <label class="res"><input type="checkbox" name="{constant echo='FormKeys::IS_ACTIVE'}" 
				checked="checked" tabindex="190" /> {translate key="IsActive"}</label>
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
