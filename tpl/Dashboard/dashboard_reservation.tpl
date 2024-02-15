{assign var=checkin value=$reservation->IsCheckinEnabled() && $reservation->RequiresCheckin()}
{assign var=checkout value=$reservation->IsCheckinEnabled() && $reservation->RequiresCheckout()}
{assign var=class value=""}
{if $reservation->RequiresApproval}{assign var=class value="pending"}{/if}
<div class="reservation row {$class}" id="{$reservation->ReferenceNumber}" {if isset($orangePending)}style="background-color:white;"{/if}> {*doesn't show pending reservations as orange Pending Approval Reservations1 in the dashboard*}
    <div class="col-sm-3 col-xs-12">{$reservation->Title|default:$DefaultTitle}</div>
    <div class="col-sm-2 col-xs-12">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=$reservation->IsUserOwner($UserId)} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-{if $checkin || $checkout}2{else}3{/if} col-xs-12">{', '|join:$reservation->ResourceNames}</div>
    {if $allowCheckin}
        {if $checkin}
            <div class="col-sm-1 col-xs-12">
                <button title="{translate key=CheckIn}" type="button" class="btn btn-xs col-xs-12 btn-warning btnCheckin" data-referencenumber="{$reservation->ReferenceNumber}" data-url="ajax/reservation_checkin.php?action={ReservationAction::Checkin}">
                    {translate key=CheckIn}
                </button>
            </div>
        {/if}
    {/if}
    {if $allowCheckout}
        {if $checkout}
            <div class="col-sm-1 col-xs-12">
                <button title="{translate key=CheckOut}" type="button" class="btn btn-xs col-xs-12 btn-warning btnCheckin" data-referencenumber="{$reservation->ReferenceNumber}" data-url="ajax/reservation_checkin.php?action={ReservationAction::Checkout}">
                    {translate key=CheckOut}
                </button>
            </div>
        {/if}
    {/if}
    <div class="clearfix"></div>
</div>
