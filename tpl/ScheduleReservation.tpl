{assign var=class value="unreservable"}
{if $slot->IsReservable()}
	{assign var=class value="reservable"}
{/if}
{if $slot->IsReserved()}
	{assign var=class value="reserved"}
{/if}
<div class="{$class} clickres" id="get">{$slot->Label()}</div>
