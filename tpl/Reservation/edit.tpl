{extends file="Reservation\create.tpl"}

{block name=reservationHeader}
{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=submitButtons}
<h3>Apply Updates To:</h3>
<input type="submit" id="btnUpdateThisInstance" value="{translate key='ThisInstance'}" class="button save"></input>
<input type="submit" id="btnUpdateAllInstances" value="{translate key='AllInstances'}" class="button save"></input>
<!--  <input type="submit" {formname key=SERIES_UPDATE_SCOPE} value="{translate key='FutureInstances'}" class="button save"></input>-->	
{/block}