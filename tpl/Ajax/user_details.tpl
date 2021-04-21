
{if $CanViewUser}
<div id="userDetailsPopup">
	<div id="userDetailsName">{fullname first=$User->FirstName() last=$User->LastName() ignorePrivacy=true}</div>
	<div id="userDetailsEmail"><span class="label">{translate key=Email}</span> <a href="mailto:{$User->EmailAddress()}">{$User->EmailAddress()}</a></div>
	<div id="userDetailsPhone"><span class="label">{translate key=Phone}</span> <a href="tel:{$User->GetAttribute(UserAttribute::Phone)}">{$User->GetAttribute(UserAttribute::Phone)}</a></div>
	<div id="userDetailsOrganization"><span class="label">{translate key=Organization}</span> {$User->GetAttribute(UserAttribute::Organization)}</div>
	<div id="userDetailsPosition"><span class="label">{translate key=Position}</span> {$User->GetAttribute(UserAttribute::Position)}</div>
	<div id="userDetailsAttributes">
	{foreach from=$Attributes item=attribute}
		<div class="customAttribute"><span class="label">{$attribute->Label()}</span> {$User->GetAttributeValue($attribute->Id())}</div>
	{/foreach}
	</div>
</div>
{/if}
