{assign var=checkin value=$reservation->IsCheckinEnabled() && $reservation->RequiresCheckin()}
{assign var=checkout value=$reservation->IsCheckinEnabled() && $reservation->RequiresCheckout()}
{assign var=class value=""}
{if $reservation->RequiresApproval}{assign var=class value="pending"}{/if}
<div class="reservation row {$class}" id="{$reservation->ReferenceNumber}">
    <div class="col s12 m3">{$reservation->Title|default:$DefaultTitle}</div>
    <div class="col s12 m2">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=$reservation->IsUserOwner($UserId)} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</div>
    <div class="col s6 m2">{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col s6 m2">{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col s12 m{if $checkin || $checkout}2{else}3{/if}">{$reservation->ResourceNames|join:', '}</div>
    {if $checkin}
        <div class="col s12 m1">
            <button title="{translate key=CheckIn}" type="button" class="btn btn-small col s12 btn-success btnCheckin" data-referencenumber="{$reservation->ReferenceNumber}" data-url="ajax/reservation_checkin.php?action={ReservationAction::Checkin}">
                <i class="fa fa-sign-in"></i>
            </button>
        </div>
    {/if}
    {if $checkout}
        <div class="col s12 m1">
            <button title="{translate key=CheckOut}" type="button" class="btn btn-small col s12  btn-success btnCheckin" data-referencenumber="{$reservation->ReferenceNumber}" data-url="ajax/reservation_checkin.php?action={ReservationAction::Checkout}">
                <i class="fa fa-sign-out"></i>
            </button>
        </div>
    {/if}
    <div class="clearfix"></div>
</div>

