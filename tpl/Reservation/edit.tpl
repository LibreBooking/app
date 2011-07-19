{extends file="Reservation/create.tpl"}

{block name=header}
	{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css,css/jquery.qtip.min.css'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=deleteButtons}	
	{if $IsRecurring}
		<button type="button" class="button delete prompt">
			<img src="img/cross-button.png" />
			{translate key='Delete'}
		</button>
	{else}
		<button type="button" class="button delete save">
			<img src="img/cross-button.png" />
			{translate key='Delete'}
		</button>
	{/if}
{/block}

{block name=submitButtons}
	{if $IsRecurring}
		<button type="button" class="button update prompt">
			<img src="img/disk-black.png" />
			{translate key='Update'}
		</button>
		<div id="updateButtons" style="display:none;" title="{translate key=ApplyUpdatesTo}">
			<div style="text-align: center;line-height:50px;">
				<button type="button" id="btnUpdateThisInstance" class="button save">
					<img src="img/disk-black.png" alt="" />
					{translate key='ThisInstance'}
				</button>
				<button type="button" id="btnUpdateAllInstances" class="button save">
					<img src="img/disks-black.png" alt="" />
					{translate key='AllInstances'}
				</button>
				<button type="button" id="btnUpdateFutureInstances" class="button save">
					<img src="img/disk-arrow.png" alt="" />
					{translate key='FutureInstances'}
				</button>
				<button type="button" class="button">
					<img src="img/slash.png" />
					{translate key='Cancel'}
				</button>
			</div>
		</div>
	{else}
		<button type="button" id="btnCreate" class="button save update">
			<img src="img/disk-black.png" />
			{translate key='Update'}
		</button>
	{/if}
	<button type="button" class="button">
		<img src="img/printer.png" />
		{translate key='Print'}
	</button>
{/block}

{block name="ajaxMessage"}
	Updating reservation...<br/>
{/block}