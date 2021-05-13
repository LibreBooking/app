{include file='globalheader.tpl'}
<div class="error">
    <h3>{translate key=$ErrorMessage}</h3>
    <h5><a href="#" onclick="goBack()">{translate key='ReturnToPreviousPage'}</a></h5>    
</div>

<script>
function goBack() {
 window.history.back();
}
</script>
    
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
