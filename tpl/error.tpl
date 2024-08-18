{include file='globalheader.tpl'}
<div class="error text-center">
    <h3>{translate key=$ErrorMessage}</h3>
    <h5>
        <a class="link-primary"
            href="//{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}">{translate key='ReturnToPreviousPage'}</a>
    </h5>
</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}