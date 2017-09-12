{assign var=checkin value=$reservation->IsCheckinEnabled() && $reservation->RequiresCheckin()}
{assign var=class value=""}
{if $reservation->RequiresApproval}{assign var=class value="pending"}{/if}
<div class="reservation row {$class}" id="{$reservation->ReferenceNumber}">
    <div class="col-sm-3 col-xs-12">{$reservation->Title|default:$DefaultTitle}</div>
    <div class="col-sm-2 col-xs-12">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=$reservation->IsUserOwner($UserId)} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-{if $checkin}2{else}3{/if} col-xs-12">{$reservation->Resources|join:', '}</div>
    {if $checkin}
        <div class="col-sm-1 col-xs-12">
            <button type="button" class="btn btn-xs col-xs-12 btn-success btnCheckin" data-referencenumber="{$reservation->ReferenceNumber}">
                <i class="fa fa-sign-in"></i> {translate key=CheckIn}
            </button>
        </div>
    {/if}
    <div class="clearfix"></div>
</div>

