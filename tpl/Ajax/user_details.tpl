{if $CanViewUser}
	<div id="userDetailsPopup">
		<div id="userDetailsName" class="fw-bold border-bottom">
			{fullname first=$User->FirstName() last=$User->LastName() ignorePrivacy=true}</div>
		<div id="userDetailsEmail" class="fw-bold"><span class="label">{translate key=Email}</span> <a
				href="mailto:{$User->EmailAddress()}" class="link-primary">{$User->EmailAddress()}</a></div>
		<div id="userDetailsPhone" class="fw-bold"><span class="label">{translate key=Phone}</span> <a
				href="tel:{$User->GetAttribute(UserAttribute::Phone)}">{$User->GetAttribute(UserAttribute::Phone)}</a>
		</div>
		<div id="userDetailsOrganization" class="fw-bold"><span class="label">{translate key=Organization}</span>
			{$User->GetAttribute(UserAttribute::Organization)}</div>
		<div id="userDetailsPosition" class="fw-bold"><span class="label">{translate key=Position}</span>
			{$User->GetAttribute(UserAttribute::Position)}</div>
		<div id="userDetailsAttributes" class="fw-bold">
			{foreach from=$Attributes item=attribute}
				<div class="customAttribute"><span class="label">{$attribute->Label()}</span>
					{$User->GetAttributeValue($attribute->Id())}</div>
			{/foreach}
		</div>
	</div>
{/if}