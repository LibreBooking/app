{include file='globalheader.tpl'}

{if $Updated}
<div class="success">{translate key=YourSettingsWereUpdated}</div>
{/if}

<div id="registrationbox">
    <form class="" method="post" action="{$smarty.server.SCRIPT_NAME}">
        <div class="registrationHeader"><h3></h3></div>

        <p class="regsubmit">
            <button type="submit" class="button update prompt" name="{Actions::SAVE}">
                <img src="img/tick-circle.png"/>
            {translate key='Update'}
            </button>
        </p>
    </form>
</div>
{include file='globalfooter.tpl'}