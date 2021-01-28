{*
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}

{if $Deleted}
    <p>Ο/Η {$UserName} διέγραψε μια κράτηση</p>
    {else}
    <p>Ο/Η {$UserName} σας πρόσθεσε σε μια κράτηση</p>
{/if}

{if !empty($DeleteReason)}
    <p><strong>Αιτία διαγραφής:</strong>{$DeleteReason|nl2br}</p>
{/if}

<p><strong>Πληροφορίες κράτησης:</strong></p>

<p>
    <strong>Έναρξη:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Λήξη: {formatdate date=$EndDate key=reservation_email}<br/>
</p>

<p>
{if $ResourceNames|count > 1}
    <strong>Πόροι ({$ResourceNames|count}):</strong> <br />
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}<br/>
    {/foreach}
{else}
    <strong>Πόρος:</strong> {$ResourceName}<br/>
{/if}
</p>

{if $ResourceImage}
    <div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

{if $RequiresApproval && !$Deleted}
    <p>* Τουλάχιστον ένας από τους κρατημένους πόρους απαιτεί έγκριση πριν τη χρήση του. Η κράτηση θα είναι σε εκκρεμότητα μέχρι να εγκριθεί. *</p>
{/if}

<p>
	<strong>Τίτλος:</strong> {$Title}<br/>
	<strong>Περιγραφή:</strong> {$Description|nl2br}
</p>

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>Η κράτηση ισχύει για τις εξής ημερομηνίες  ({$RepeatRanges|count}):</strong>
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Participants|count >0}
    <br />
    <strong>Συμμετέχοντες ({$Participants|count + $ParticipatingGuests|count}):</strong>
    <br />
    {foreach from=$Participants item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|count >0}
    {foreach from=$ParticipatingGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Invitees|count >0}
    <br />
    <strong>Invitees ({$Invitees|count + $InvitedGuests|count}):</strong>
    <br />
    {foreach from=$Invitees item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|count >0}
    {foreach from=$InvitedGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Accessories|count > 0}
    <br />
       <strong>Εξοπλισμός ({$Accessories|count}):</strong>
       <br />
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if !$Deleted && !$Updated}
<p>
    <strong>Θα παρακολουθήσετε;</strong> <a href="{$ScriptUrl}/{$AcceptUrl}">Ναι</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Όχι</a>
</p>
{/if}

{if !$Deleted}
<a href="{$ScriptUrl}/{$ReservationUrl}">Δείτε την κράτηση</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Προσθήκη στο Ημερολόγιο</a> |
<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Προσθήκη στο Google Calendar</a> |
{/if}
<a href="{$ScriptUrl}">Κάνετε είσοδο στο  {$AppTitle}</a>
