{block name="header"}
	{include file='globalheader.tpl' DisplayWelcome='false' cssFiles='css/reservation.css,css/jquery.qtip.min.css'}
{/block}

<div id="reservationbox">

<form id="reservationForm" method="post">
	<div class="reservationHeader">
		<h3>{block name=reservationHeader}{translate key="CreateReservationHeading"}{/block}</h3>
	</div>
	<div id="reservationDetails">
		<ul class="no-style">
			<li>
				{$UserName} <input type="hidden" {formname key=USER_ID} value="{$UserId}" />
			</li>
		</ul>
		<ul class="no-style">
        	<li class="inline">
		    	<label>{translate key="ResourceList"}</label><br />
		    		<div id="resourceNames" style="display:inline">
                        <a href="#" class="resourceDetails">{$ResourceName}</a>
			    		<input class="resourceId" type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}" />
			    		<input type="hidden" {formname key=SCHEDULE_ID} value="{$ScheduleId}" />
		    		</div>
                    {if $AvailableResources|count > 0}
					    <a href="#" onclick="$('#dialogAddResources').dialog('open'); return false;">(More Resources)</a>
                    {/if}
					<div id="additionalResources"></div>
        	</li>
        	<li>
				<label>{translate key='BeginDate'}
				<input type="text" id="BeginDate" {formname key=BEGIN_DATE} class="dateinput" value="{formatdate date=$SelectedStart}"/>
				</label>
				<select id="BeginPeriod" {formname key=BEGIN_PERIOD} class="pulldown" style="width:150px">
					{foreach from=$Periods item=period}
						{if $period->IsReservable()}
							{assign var='selected' value=''}
							{if $period->BeginDate()->Equals($SelectedStart)}
								{assign var='selected' value=' selected="selected"'}
							{/if}
							<option value="{$period->Begin()}"{$selected}>{$period->Label()}</option>
						{/if}
					{/foreach}
				</select>
			</li>
			<li>
				<label>{translate key='EndDate'}
				<input type="text" id="EndDate" {formname key=END_DATE} class="dateinput" value="{formatdate date=$SelectedEnd}" />
				</label>
				<select id="EndPeriod" {formname key=END_PERIOD} class="pulldown" style="width:150px">
					{foreach from=$Periods item=period}
						{if $period->IsReservable()}
							{assign var='selected' value=''}
							{if $period->EndDate()->Equals($SelectedEnd)}
								{assign var='selected' value=' selected="selected"'}
							{/if}
							<option value="{$period->End()}"{$selected}>{$period->LabelEnd()}</option>
						{/if}
					{/foreach}
				</select>
			</li>
			<li>
				<label>Reservation Length</label>
				<div class="durationText">
					<span id="durationDays">0</span> {translate key=days},
					<span id="durationHours">0</span> {translate key=hours}
				</div>
			</li>
			<li>
				<div id="repeatDiv">
					<label>{translate key="RepeatPrompt"}</label>
					<select id="repeatOptions" {formname key=repeat_options} class="pulldown" style="width:250px">
						{foreach from=$RepeatOptions key=k item=v}
							<option value="{$k}">{translate key=$v['key']}</option>
						{/foreach}					
					</select>
					<div id="repeatEveryDiv" style="display:none;" class="days weeks months years">
						<label>{translate key="RepeatEveryPrompt"}</label>
						<select id="repeatInterval" {formname key=repeat_every} class="pulldown" style="width:55px">
							{html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}
						</select>
						<span class="days">{translate key=$RepeatOptions['daily']['everyKey']}</span>
						<span class="weeks">{translate key=$RepeatOptions['weekly']['everyKey']}</span>
						<span class="months">{translate key=$RepeatOptions['monthly']['everyKey']}</span>
						<span class="years">{translate key=$RepeatOptions['yearly']['everyKey']}</span>
					</div>
					<div id="repeatOnWeeklyDiv" style="display:none;" class="weeks">
						<label>{translate key="RepeatDaysPrompt"}</label>
						<input type="checkbox" id="repeatDay0" {formname key=repeat_sunday} />{translate key="DaySundaySingle"}
						<input type="checkbox" id="repeatDay1" {formname key=repeat_monday} />{translate key="DayMondaySingle"}
						<input type="checkbox" id="repeatDay2" {formname key=repeat_tuesday} />{translate key="DayTuesdaySingle"}
						<input type="checkbox" id="repeatDay3" {formname key=repeat_wednesday} />{translate key="DayWednesdaySingle"}
						<input type="checkbox" id="repeatDay4" {formname key=repeat_thursday} />{translate key="DayThursdaySingle"}
						<input type="checkbox" id="repeatDay5" {formname key=repeat_friday} />{translate key="DayFridaySingle"}
						<input type="checkbox" id="repeatDay6" {formname key=repeat_saturday} />{translate key="DaySaturdaySingle"}
					</div>
					<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfMonth}" id="repeatMonthDay" checked="checked" />
						<label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfWeek}" id="repeatMonthWeek" />
						<label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
					</div>
					<div id="repeatUntilDiv" style="display:none;">
						{translate key="RepeatUntilPrompt"}
						<input type="text" id="EndRepeat" {formname key=end_repeat_date} class="dateinput" value="{formatdate date=$RepeatTerminationDate}" />
					</div>
				</div>
			</li>
			<li class="rsv-req">
                <label>{translate key="ReservationTitle"}<br />
                {textbox name="RESERVATION_TITLE" class="input" tabindex="100" value="ReservationTitle"}
                </label>
        	</li>
        	<li class="rsv-box-l">
                <label>{translate key="ReservationDescription"}<br />
	                <textarea id="description" name="{FormKeys::DESCRIPTION}" class="input-area" rows="2" cols="52" tabindex="110">{$Description}</textarea>
                </label>
        	</li>
			
        </ul>
	</div>
	<div id="reservationParticipation">
		<ul class="no-style">
			<li>
                <label>{translate key="ParticipantList"}<br />
					<input type="text" id="participantAutocomplete" class="textbox" />
					<button id="addParticipants" type="button" class="button" style="display:inline">
						<img src="img/user-plus.png" />
						{translate key='Add'}
					</button>
				</label>
				<div id="participants" title="Add Resources" class="dialog">
					here is where they go
				</div>
        	</li>
			<!-- The selected participants should be printed here, above the Invitation list pulldown -->
			<li>
                <label>{translate key="InvitationList"}<br />
                       
					<button type="button" class="button" style="display:inline">
						<img src="img/user-plus.png" />
						{translate key='Add'}
					</button>
				</label>

        	</li>
			<!-- The invited users should be printed here above the X -->
		</ul>

	</div>
	<div style="clear:both;">&nbsp;</div>
	<input type="hidden" {formname key=reservation_id} value="{$ReservationId}" />
	<input type="hidden" {formname key=reference_number} value="{$ReferenceNumber}" />
	<input type="hidden" {formname key=reservation_action} value="{$ReservationAction}" />
	<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} id="hdnSeriesUpdateScope" value="{SeriesUpdateScope::FullSeries}" />
	<div style="float:left;">
	{block name="deleteButtons"}
	&nbsp;
	{/block}
	</div>
	<div style="float:right;">
		{block name="submitButtons"}
			<button type="button" class="button save create">
				<img src="img/disk-black.png" />
				{translate key='Create'}
			</button>
		{/block}
		<button type="button" class="button" onclick="window.location='{$ReturnUrl}'">
			<img src="img/slash.png" />
			{translate key='Cancel'}
		</button>
	</div>
</form>

<div id="dialogAddResources" class="dialog" title="Add Resources" style="display:none;">

	{foreach from=$AvailableResources item=resource}
		{assign var='checked' value=''}
		{if is_array($AdditionalResourceIds) && in_array($resource->Id(), $AdditionalResourceIds)}
			{assign var='checked' value='checked="checked"'}	
		{/if}
		
		<p>
			<input type="checkbox" {formname key=ADDITIONAL_RESOURCES multi=true} id="additionalResource{$resource->Id()}" value="{$resource->Id()}" {$checked} /> 
			<label for="additionalResource{$resource->Id()}">{$resource->Name()}</label>
		</p>
		
	{/foreach}
	<br/>
	<button id="btnConfirmAddResources">Add Selected</button>
	<button id="btnClearAddResources">Cancel</button>
</div>

<div id="dialogSave" style="display:none;">
	<div id="creatingNotifiation" style="position:relative; top:170px; font-size:16pt;text-align:center;">
		{block name="ajaxMessage"}
			Creating reservation...<br/>
		{/block}
		<img src="{$Path}img/reservation_submitting.gif" alt="Creating reservation"/>
	</div>
	<div id="result" style="display:none;"></div>
</div>
<!-- reservationbox ends -->
</div>

{control type="DatePickerSetupControl" ControlId="BeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" DefaultDate=$EndDate}


<script type="text/javascript" src="scripts/js/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/js/jquery.qtip.pack.js"></script>
<script type="text/javascript" src="scripts/reservation.js"></script>
<script type="text/javascript" src="scripts/autocomplete.js"></script>
<script type="text/javascript" src="scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	var scopeOptions = {
		instance: '{SeriesUpdateScope::ThisInstance}',
		full: '{SeriesUpdateScope::FullSeries}',
		future: '{SeriesUpdateScope::FutureInstances}'
	};
	
	var reservationOpts = {
		additionalResourceElementId: '{FormKeys::ADDITIONAL_RESOURCES}',
		repeatType: '{$RepeatType}',
		repeatInterval: '{$RepeatInterval}',
		repeatMonthlyType: '{$RepeatMonthlyType}',
		repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}$day,{/foreach}],
		returnUrl: '{$ReturnUrl}',
		scopeOpts: scopeOptions,
		createUrl: 'ajax/reservation_save.php',
		updateUrl: 'ajax/reservation_update.php',
		deleteUrl: 'ajax/reservation_delete.php',
		userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}"
	};

	$('#description').TextAreaExpander();
	
	var reservation = new Reservation(reservationOpts);
	reservation.init();
	
	var options = { 
        target: '#result',   // target element(s) to be updated with server response
        beforeSubmit: reservation.preSubmit,  // pre-submit callback 
        success: reservation.showResponse  // post-submit callback 
 		//url: {block name="submitUrl"}"ajax/reservation_save.php"{/block}

 	    // other available options: 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    
    $('#reservationForm').submit(function() { 
        $(this).ajaxSubmit(options); 
 		return false; 
    });

   
});
</script>

{include file='globalfooter.tpl'}