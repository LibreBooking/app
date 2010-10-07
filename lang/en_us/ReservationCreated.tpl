You have successfully created a new reservation.

Starting: {formatdate date=$StartDate} 
Ending: {formatdate date=$EndDate}

{if count($RepeatDates) gt 0}
Your reservation was repeated on the following dates:
{/if}

{foreach from=$RepeatDates item=date name=dates}
  	{formatdate date=$date}
{/foreach}