{*
Copyright 2017-2019 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}

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