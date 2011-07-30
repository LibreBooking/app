{include file='globalheader.tpl' cssFiles='css/participation.css,css/jquery.qtip.css'}
<h1>{translate key=OpenInvitations} ({$Reservations|count})</h1>

<ul class="no-style participation">
{foreach from=$Reservations item=reservation name=invitations}
	{assign var=referenceNumber value=$reservation->ReferenceNumber}
	<li class="actions row{$smarty.foreach.invitations.index%2}">
		<h3><a href="{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}={$referenceNumber}" class="reservation" referenceNumber="{$referenceNumber}">
		{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard} - {formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</a></h3>
		<input type="hidden" value="{$referenceNumber}" class="referenceNumber" />
		<button value="{InvitationAction::Accept}" class="button participationAction">{html_image src="ticket-plus.png"} {translate key="Accept"}</button>
		<button value="{InvitationAction::Decline}" class="button participationAction">{html_image src="ticket-minus.png"} {translate key="Decline"}</button>
	</li>
{foreachelse}
	<li class="no-data"><h2>{translate key='None'}</h2></li>
{/foreach}
</ul>

<div class="dialog" style="display:none;">
	
</div>

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/participation.js"></script>

<script type="text/javascript">

	$(document).ready(function() {

		var participationOptions = {
			responseType: 'json'
		};

		var participation = new Participation(participationOptions);
		participation.initParticipation();
	});

</script>

{include file='globalfooter.tpl'}