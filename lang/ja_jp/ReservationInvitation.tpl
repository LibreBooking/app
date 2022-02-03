    予約の詳細:
	<br/>
	<br/>

	開始: {formatdate date=$StartDate key=reservation_email}<br/>
	終了: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		リソース:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		リソース: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	件名: {$Title}<br/>
	説明: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		下記の日時で予約されました:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>Accessories:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
		承認が必要なリソースが含まれています。 そのため承認されるまでは保留状態となります。
	{/if}

	<br/>
	出席しますか? <a href="{$ScriptUrl}/{$AcceptUrl}">はい</a> <a href="{$ScriptUrl}/{$DeclineUrl}">いいえ</a>
	<br/>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">予約の表示</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">カレンダーへ追加</a> |
	<a href="{$ScriptUrl}">LibreBooking へログイン</a>

