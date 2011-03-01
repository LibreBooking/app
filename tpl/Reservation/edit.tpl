{extends file="Reservation\create.tpl"}

{block name=header}
	{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=submitButtons}
	{if $IsRecurring}
		<button type="submit" id="btnUpdateThisInstance" class="buttons save">
			<img src="img/disk-black.png" alt="" />
			{translate key='ThisInstance'}
		</button>
		<button type="submit" id="btnUpdateAllInstances" class="buttons save">
			<img src="img/disks-black.png" alt="" />
			{translate key='AllInstances'}
		</button>
		<button type="submit" id="btnUpdateFutureInstances" class="buttons save">
			<img src="img/disk-arrow.png" alt="" />
			{translate key='FutureInstances'}
		</button>
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