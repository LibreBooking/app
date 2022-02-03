予約が間もなく終了します。<br/>
予約の詳細:
	<br/>
	<br/>
	開始: {formatdate date=$StartDate key=reservation_email}<br/>
	終了: {formatdate date=$EndDate key=reservation_email}<br/>
	リソース: {$ResourceName}<br/>
	件名: {$Title}<br/>
	説明: {$Description|nl2br}<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">予約の表示</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">カレンダーへ追加</a> |
<a href="{$ScriptUrl}">LibreBooking へログイン</a>

