{extends file="Reservation\create.tpl"}

{block name=reservationHeader}
{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=submitButtons}
{if $IsRecurring}
	<h3>Apply Updates To:</h3>
	<input type="submit" id="btnUpdateThisInstance" value="{translate key='ThisInstance'}" class="button save"></input>
	<input type="submit" id="btnUpdateAllInstances" value="{translate key='AllInstances'}" class="button save"></input>
	<input type="submit" id="btnUpdateFutureInstances" value="{translate key='FutureInstances'}" class="button save"></input>	
{else}
	<input type="submit" id="btnSave" value="{translate key='Update'}" class="button save"></input>
{/if}
{/block}

{block name="ajaxMessage"}
Updating reservation...<br/>
{/block}

{block name="submitUrl"}"ajax/reservation_update.php"{/block}