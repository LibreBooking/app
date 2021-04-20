<div>
	<div id="updateUserResults" class="alert alert-danger no-show validationSummary">
		<ul>
            {async_validator id="emailformat" key="ValidEmailRequired"}
            {async_validator id="uniqueemail" key="UniqueEmailRequired"}
            {async_validator id="uniqueusername" key="UniqueUsernameRequired"}
            {async_validator id="updateAttributeValidator" key=""}
		</ul>
	</div>
	<div class="col-sm-12 col-md-6">

		<div class="form-group has-feedback">
			<label for="username">{translate key="Username"}</label>
			<input type="text" {formname key="USERNAME"} class="required form-control" required
				   id="username" value="{$User->Username()|escape:html}"/>
			<i class="glyphicon glyphicon-asterisk form-control-feedback"
			   data-bv-icon-for="username"></i>
		</div>
	</div>

	<div class="col-sm-12 col-md-6">
		<div class="form-group has-feedback">
			<label for="email">{translate key="Email"}</label>
			<input type="text" {formname key="EMAIL"} class="required form-control" required
				   id="email" value="{$User->EmailAddress()|escape:html}"/>
			<i class="glyphicon glyphicon-asterisk form-control-feedback"
			   data-bv-icon-for="email"></i>
		</div>
	</div>

	<div class="col-sm-12 col-md-6">
		<div class="form-group has-feedback">
			<label for="fname">{translate key="FirstName"}</label>
			<input type="text" {formname key="FIRST_NAME"} class="required form-control" required
				   id="fname" value="{$User->FirstName()|escape:html}"/>
			<i class="glyphicon glyphicon-asterisk form-control-feedback"
			   data-bv-icon-for="fname"></i>
		</div>
	</div>

	<div class="col-sm-12 col-md-6">
		<div class="form-group has-feedback">
			<label for="lname">{translate key="LastName"}</label>
			<input type="text" {formname key="LAST_NAME"} class="required form-control" required
				   id="lname" value="{$User->LastName()|escape:html}"/>
			<i class="glyphicon glyphicon-asterisk form-control-feedback"
			   data-bv-icon-for="lname"></i>
		</div>
	</div>

	<div class="col-sm-12 col-md-6">
		<div class="form-group">
			<label for="timezone">{translate key="Timezone"}</label>
			<select {formname key='TIMEZONE'} id='timezone' class="form-control">
                {html_options values=$Timezones output=$Timezones selected="{$User->Timezone()}"}
			</select>
		</div>
	</div>

	<div class="col-sm-12 col-md-6">

		<div class="form-group">
			<label for="phone">{translate key="Phone"}</label>
			<input type="text" {formname key="PHONE"} class="form-control" id="phone" value="{$User->GetAttribute(UserAttribute::Phone)|escape:html}"/>
		</div>
	</div>

	<div class="col-sm-12 col-md-6">
		<div class="form-group">
			<label for="organization">{translate key="Organization"}</label>
			<input type="text" {formname key="ORGANIZATION"} class="form-control"
				   id="organization" value="{$User->GetAttribute(UserAttribute::Organization)|escape:html}"/>
		</div>
	</div>

	<div class="col-sm-12 col-md-6">
		<div class="form-group">
			<label for="position">{translate key="Position"}</label>
			<input type="text" {formname key="POSITION"} class="form-control" id="position" value="{$User->GetAttribute(UserAttribute::Position)|escape:html}"/>
		</div>
	</div>

	{foreach from=$Attributes item=attribute}
		<div class="col-sm-12 col-md-6">
			{control type="AttributeControl" attribute=$attribute value={$User->GetAttributeValue($attribute->Id())} }
		</div>
	{/foreach}
		<div class="clearfix">&nbsp;</div>
</div>
