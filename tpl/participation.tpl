{include file='globalheader.tpl'}
<h1>Open Invitations</h1>

table of open invitations.  Accept | Decline links

<script type="text/javascript" src="scripts/participation.js"></script>
<script type="text/javascript">

	$(document).ready(function() {

		var participationOptions = {
			responseType: 'json'
		};

		var participation = new Participation(participationOptions);
		participation.init();
	});

</script>

{include file='globalfooter.tpl'}
