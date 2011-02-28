{extends file="Reservation\create.tpl"}

{block name=header}
	{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=submitButtons}
	{if $IsRecurring}
		<div style="border: solid 1px #ccc; float:left; padding: 4px; margin-right: 5px;">
		<img src="img/disk-black.png" alt="" />
		<button type="submit" id="btnUpdateThisInstance" class="buttons save">
			{translate key='ThisInstance'}
		</button>
		<button type="submit" id="btnUpdateAllInstances" class="buttons save">
			{translate key='AllInstances'}
		</button>
		<button type="submit" id="btnUpdateFutureInstances" class="buttons save">
			{translate key='FutureInstances'}
		</button>	
		</div>
	{else}
		<button type="submit" id="btnCreate" class="buttons save">
			<img src="img/disk-black.png" />
			{translate key='Update'}
		</button>
	{/if}
		<button type="submit" class="buttons save">
			<img src="img/printer.png" />
			{translate key='Print'}
		</button>
{/block}

{block name="ajaxMessage"}
	Updating reservation...<br/>
{/block}

{block name="submitUrl"}"ajax/reservation_update.php"{/block}