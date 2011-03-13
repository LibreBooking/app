{include file='globalheader.tpl' DisplayWelcome='false'}
<div class="error">
	<table>
		<tr>
			<td style="width:100px;"><img src="img/alert.png" alt="Alert" width="60" height="60" /></td>
			<td>
				<h3>{translate key=$ErrorMessage}</h3>
				<h5><a href="{$ReturnUrl}">{translate key='ReturnToPreviousPage'}</a></h5>
			</td>
		</tr>
	</table>
</div>


{include file='globalfooter.tpl'}