{include file='globalheader.tpl' HideNavBar=true cssFiles='css/schedule.css'}

<div id="page-resource-display-resource" class="h-100">

        <div class="resource-display date-picker ms-4">
                <div class="date form-group w-50">
                        <label class="fw-bold text-uppercase fs-6 text-secondary"
                                for="availabilityStartDate">{translate key='Date'}</label>
                        <input type="text" id="availabilityStartDate" class="form-control w-auto"
                                {formname key=ANNOUNCEMENT_START} />
                        <input type="hidden" id="formattedBeginDate" {formname key=ANNOUNCEMENT_START} />
                </div>
        </div>

        <div id="placeholder"></div>
</div>

<div id="wait-box" class="wait-box">
        {indicator id="waitIndicator"}
</div>

{include file="javascript-includes.tpl"}
{jsfile src="resourceDisplay.js"}
{jsfile src="ajax-helpers.js"}
{jsfile src="autocomplete.js"}

{control type="DatePickerSetupControl" ControlId="availabilityStartDate" AltId="formattedBeginDate" MaxDate=$MaxFutureDate}

<script type="text/javascript">
        function getResourceId() {
                return '{$PublicResourceId}';
        }
        $(function() {
                var resourceDisplay = new ResourceDisplay();
                resourceDisplay.initDisplay({
                        url: '{$smarty.server.SCRIPT_NAME}?dr=resource&rid={$PublicResourceId}&dr=display',
                        userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}&as=1",
                        allowAutocomplete: {if $AllowAutocomplete}true{else}false{/if},
                        initialDate: '{$InitialDate}',
                        MaxDate: '{$MaxFutureDate}'
                });
        });
</script>

{include file='globalfooter.tpl'}