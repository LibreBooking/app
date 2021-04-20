{include file='globalheader.tpl' HideNavBar=true}

<div id="page-resource-display-resource">
<div id="placeholder"></div>
</div>

<div id="wait-box" class="wait-box">
	{indicator id="waitIndicator"}
</div>

{include file="javascript-includes.tpl"}
{jsfile src="resourceDisplay.js"}
{jsfile src="ajax-helpers.js"}
{jsfile src="autocomplete.js"}

<script type="text/javascript">
	$(function () {
		var resourceDisplay = new ResourceDisplay();
		resourceDisplay.initDisplay(
                {
                    url: '{$smarty.server.SCRIPT_NAME}?dr=resource&rid={$PublicResourceId}&dr=display',
                    userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}&as=1",
                    allowAutocomplete: {if $AllowAutocomplete}true{else}false{/if}
                }
        );
	});
</script>

{include file='globalfooter.tpl'}
