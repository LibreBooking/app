{extends file="Reservation/view.tpl"}

{block name=header}
	{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css,css/jquery.qtip.min.css'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=deleteButtons}
	<button type="button" class="button delete save">
		<img src="img/cross-button.png" />
		{translate key='Delete'}
	</button>
{/block}

{block name=submitButtons}
	<button type="button" class="button" id="btnApprove">
		<img src="img/tick-circle.png" />
		{translate key='Approve'}
	</button>
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...<br/>
{/block}