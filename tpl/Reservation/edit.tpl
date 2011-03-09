{extends file="Reservation\create.tpl"}

{block name=header}
	{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=deleteButtons}	
	{if $IsRecurring}
		<button type="submit" class="button delete prompt">
			<img src="img/cross-button.png" />
			{translate key='Delete'}
		</button>
	{else}
		<button type="submit" class="button delete save">
			<img src="img/cross-button.png" />
			{translate key='Delete'}
		</button>
	{/if}
{/block}

{block name=submitButtons}
	{if $IsRecurring}
		<button type="submit" class="button update prompt">
			<img src="img/disk-black.png" />
			{translate key='Update'}
		</button>
		<div id="updateButtons" style="display:none;">
			<div style="text-align: center;line-height:50px;">
				<button type="submit" id="btnUpdateThisInstance" class="button save">
					<img src="img/disk-black.png" alt="" />
					{translate key='ThisInstance'}
				</button>
				<button type="submit" id="btnUpdateAllInstances" class="button save">
					<img src="img/disks-black.png" alt="" />
					{translate key='AllInstances'}
				</button>
				<button type="submit" id="btnUpdateFutureInstances" class="button save">
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
		<button type="submit" id="btnCreate" class="button save update">
			<img src="img/disk-black.png" />
			{translate key='Update'}
		</button>
	{/if}
	<button type="submit" class="button">
		<img src="img/printer.png" />
		{translate key='Print'}
	</button>
{/block}

{block name="ajaxMessage"}
	Updating reservation...<br/>
{/block}