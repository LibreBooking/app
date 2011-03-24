<td colspan="{$Slot->PeriodSpan()}" class="reservable clickres slot">
&nbsp;
<input type="hidden" class="href" value="{$Href}" />
<input type="hidden" class="start" value="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}" />
<input type="hidden" class="end" value="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}" />
</td>