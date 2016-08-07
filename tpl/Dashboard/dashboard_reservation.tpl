<div class="reservation row" id="{$reservation->ReferenceNumber}">
    <div class="col-sm-3 col-xs-12">{$reservation->Title|default:$DefaultTitle}</div>
    <div class="col-sm-2 col-xs-12">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=$reservation->IsUserOwner($UserId)} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-2 col-xs-6">{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</div>
    <div class="col-sm-3 col-xs-12">{$reservation->ResourceName}</div>
</div>
<div class="clearfix"></div>
