{assign var=checkin value=$reservation->IsCheckinEnabled() && $reservation->RequiresCheckin()}
{assign var=checkout value=$reservation->IsCheckinEnabled() && $reservation->RequiresCheckout()}
{assign var=class value=""}
{if $reservation->RequiresApproval}{assign var=class value="pending"}{/if}
<div class="reservation row {$class}" id="{$reservation->ReferenceNumber}">
    <div class="col-sm-3 col-xs-12">{$reservation->Title|default:$DefaultTitle}</div>
    <div class="col-sm-2 col-xs-12">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=$reservation->IsUserOwner($UserId)} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-{if $checkin || $checkout}2{else}3{/if} col-xs-12">{$reservation->ResourceNames|join:', '}</div>
    {if $checkin}
        <div class="col-sm-1 col-xs-12">
            <button title="{translate key=CheckIn}" type="button" class="btn btn-xs col-xs-12 btn-warning btnCheckin" data-referencenumber="{$reservation->ReferenceNumber}" data-url="ajax/reservation_checkin.php?action={ReservationAction::Checkin}">
                <i class="fa fa-sign-in"> {translate key=CheckIn}</i>
            </button>
        </div>
    {/if}
    {if $checkout}
        <div class="col-sm-1 col-xs-12">
            <button title="{translate key=CheckOut}" type="button" class="btn btn-xs col-xs-12 btn-warning btnCheckin" data-referencenumber="{$reservation->ReferenceNumber}" data-url="ajax/reservation_checkin.php?action={ReservationAction::Checkout}">
                <i class="fa fa-sign-out"> {translate key=CheckOut}</i>
            </button>
        </div>
    {/if}
    <div class="clearfix"></div>
</div>
<div id="wait-box" class="wait-box">
	<div id="creatingNotification">
		<h3>
			{block name="ajaxMessage"}
				{translate key=Working}...
			{/block}
		</h3>
		{html_image src="reservation_submitting.gif"}
	</div>
	<div id="result"></div>
</div>
