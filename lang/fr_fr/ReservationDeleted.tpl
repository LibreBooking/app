{*
Copyright 2011-2019 Nick Korbel

Ce fichier fait parti de Booked Scheduler.

Booked Scheduler est un logiciel libre : vous pouvez le redistribuer et/ou le
modifier dans le respect des termes de la license GNU (General Public License)
telle que publiée par la Free Software Foundation, que ce soit en version 3
de cette license ou plus récente (à votre guise).

Booked Scheduler est distribué dans l'espoir d'être utile mais
il est fourni SANS AUCUNE GARANTIE; sans même une garantie implicite
de COMMERCIABILITE ou DE CONFORMITE A UNE UTILISATION PARTICULIERE.
Voir la Licence Publique Générale GNU pour plus de détails.

Vous devez avoir reçu une copie de la GNU General Public License
avec Booked Scheduler. si ce n'est pas le cas consultez <http://www.gnu.org/licenses/>.
*}


Détails de la réservation :
<br/>
<br/>

Début: {formatdate date=$StartDate key=reservation_email}<br/>
Fin: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
    Ressources:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Ressource: {$ResourceName}
    <br/>
{/if}
Titre: {$Title}<br/>
Description: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>

{if count($RepeatDates) gt 0}
    <br/>
    Les dates suivantes ont été effacées:
    <br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
    {formatdate date=$date}
    <br/>
{/foreach}

{if $Accessories|count > 0}
    <br/>
    Accessoires:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<a href="{$ScriptUrl}">Connexion à Booked Scheduler</a>


