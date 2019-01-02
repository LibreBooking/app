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
{include file='globalheader.tpl'}
<h1>Aide Booked Scheduler</h1>

<div id="help">
<h2>Enregistrement</h2>

<p>L'enregistrement est obligatoire pour utiliser Booked Scheduler.
    Si l'administrateur a activé l'automatisme, chaque utilisateur peut le faire lui-même. Sinon, c'est l'administrateur qui crée les comptes.
    Après enregistrement, vous pourrez vous connecter et avoir accès à toutes les ressources qui vous sont autorisées.
</p>

<h2>Réserver</h2>

<p>Pour réserver, rendez-vous dans le menu "Planning/Réservations".
    <br>Il suffit ensuite de cliquer sur le créneau horaire souhaité et la page de réservation s'affiche.
    <br>Notez qu'il n'est pas possible de réserver un créneau horaire passé (ce qui est logique !!!) hors administration.
    <br>
    <br>Choisissez :
    <br>- La ressource
    <br>- Le jour et l'heure de début
    <br>- Le jour et l'heure de fin

    <br>Ajoutez :
    <br>- Un libellé
    <br>- Des participants (en option)
    <br>- Des invités (en option)

    <br><br>Validez en cliquant sur "Créer"
</p>

<h3>Erreurs possibles</h3>

<p>
    Il est possible que votre réservation soit refusée.

    <br>Vérifiez donc :
    <br>- Que vous ayez le droit de réserver la ressource.
    <br>- Que le créneau horaire soit cohérent (heure de début avant l'heure de fin, par exemple).
    <br>- Qu'elle ne soit pas bloquée pour tout autre raison.
    <br>En dernier recours, contactez l'administrateur qui devrait soit résoudre votre souci, soit vous en donner la raison.
</p>


<h3>Ressources Multiples</h3>

<p>Vous pouvez réserver toutes les ressources qui vous sont autorisées en une seule réservation. Pour ajouter plus
    de ressources à votre réservation, cliquez sur "(+ de Ressources)" à droite de la première ressource affichée.
    Vous pourrez ensuite ajouter des ressources en les sélectionnant puis en cliquant sur le bouton "Valider".</p>

<p>Pour ôter des ressources supplémentaires à la réservation, cliquez sur "(+ de Resources)", désélectionnez la/les
   ressource(s) concernée(s) puis validez.</p>

<p>Les ressources supplémentaires obéissent aux mêmes rêgles que la première. Par exemple, cela veut dire que si
   vous essayez de créer une réservation de 2 heures avec
   <br>- La Ressource 1 qui a un maximum de 3 heures
   <br>et
   <br>- La Ressource 2 qui a un maximum de 1 heure
   <br>Votre réservation sera refusée.</p>

<p>En survolant le nom de la réservation, les informations sur la ressource s'affichent.</p>


<h3>Dates récurrentes</h3>

<p>Vous pouvez configurer votre réservation pour qu'elle se reproduise régulièrement.
 Notez que cet évènement se répetera aussi le jour de la date fixée dans "jusqu'au XX/XX/XXXX".</p>

<p>Cette option offre de nombreuses possibilités.
   <br>Par exemple :

   <br>- Une "Répétition" > "Journalière" > Tous les "2 jours" --> créera des réservations régulières espacées de deux jours.
   <br>- Une "Répétition" > "Hebdomadaire" > Tous les "2 semaines" fixée au Jeudi --> créera une réservation le jeudi toutes les 2 semaines.
   <br>- Une "Répétition" > "Mensuelle" > Tous les "2 mois" > Jour du mois --> répétera votre réservation tous les 2 mois, les 3 du mois, si on est le 3.
   <br>- Une "Répétition" > "Mensuelle" > Tous les "2 mois" > Jour de la semaine --> répétera votre réservation tous les 2 mois les premiers samedi du mois, si on est le premier samedi du mois.
</p>

<h3>Participants et invités</h3>

<p>Vous pouvez ajouter des participants et/ou des invités lors d'une réservation.
Les participants seront rajoutés à la réservation et recevront un email de confirmation.
Les invités devront, en plus, accepter l'invitation qui leur sera notifiée par email.
S'ils confirment leur accord, ils deviennent des participants, s'il refusent, ils sont effacés de la liste des invités.

</p>

<p>
    Le nombre total de participants est limité par la capacité de la ressource.
</p>

<h3>Accessoires</h3>

<p>Les accessoires sont les objets utilisés durant la réservation (Vidéo-Projecteurs, Chaises ....).
Vous pouvez en ajouter en cliquant sur "(Ajouter)" (à droite d'"Accessoires").
La quantité dont vous pourrez disposer sera fonction de ce qui est diponible (l'existant moins ce qui est déjà réservé).
</p>

<h3>Réserver pour d'autres</h3>

<p>Les administrateurs de l'Application et des Groupes peuvent réserver au nom d'autres utilisateurs
 en utilisant "(Modifier)" à droite du nom d'utilisateur dans la réservation.</p>

<p>Les administrateurs de l'Application et des Groupes peuvent aussi modifier et effacer les réservations des autres.</p>

<h2>Mettre à jour une Réservation</h2>

<p>Vous pouvez mettre à jour une réservation que vous avez créée ou que l'on a créée en votre nom.</p>

<h3>Mettre à jour toutes les instances d'une série</h3>

<p>
    Si une réservation est réglée pour se répéter, une série est créée.
    <br>Chaque réservation de cette série est une instance.
    <br>Si vous modifiez votre réservation, il
    vous sera demandé quelles instances de la série sont concernées par cette modification. Vous pouvez soit
    choisir :
       <br>- De ne faire cette modification que pour la réservation que vous avez devant vous -> "Cette Instance seule"
       <br>- De l'appliquer à toutes les instances de la série qui ne sont pas encore passées -> "Toutes les Instances"
       <br>- De l'appliquer aux "Futures Instances" (celle que vous avez devant les yeux plus celles d'après).
</p>

<p>Seuls les administrateurs de l'application peuvent mettre à jour des réservations passées.</p>

<h2>Effacer une Réservation</h2>

<p>Effacer une réservation l'enlève définitivement du planning.</p>

<h3>Effacer des Instances spécifiques d'une série</h3>

<p>La démarche est la même que pour la mise à jour: vous choisissez quelle instance vous voulez effacer dans la série.</p>

<p>Seuls les administrateurs de l'application peuvent effacer des réservations passées.</p>

<h2>Ajouter une Réservation à Outlook &reg;, Ical, ...</h2>

<p>A la consultation ou à la mise à jour d'une réservation, vous verrez un bouton "Ajouter à Outlook".
    Si Outlook est installé sur votre ordinateur, il vous sera demandé si vous voulez l'ajouter, sinon vous pourrez
    télécharger le fichier ".ics". C'est un format standard de calendrier, utilisable dans toutes les
    applications qui supportent le format "iCalendar".</p>

-------------------------------------------------------------

<h2>Inscription aux Calendriers</h2>

<p>Des calendriers peuvent être publiés pour les plannings, les ressources et les utilisateurs.
Il faut, pour cela, que l'administrateur ait déterminé une clé d'inscription dans le fichier de configuration.
Pour activer les inscriptions aux calendriers, aux plannings, et Ressources,
il suffit de cliquer sur le lien concerné lors de la gestion du planning ou de la ressource.
Pour un calendrier personnel, allez dans "Planning/Mon Calendrier" et cliquez sur "Permettre les inscriptions au Calendrier".
</p>

<p>Pour s'inscrire à un calendrier de planning : ouvrez "Plannings/Calendrier des Ressources" et choissisez le planning désiré.
A droite, vous trouverez un lien pour vous inscrire.
La démarche est la même pour une ressource.
Pour vous inscrire à votre propre calendrier, allez sur "Planning/Mon Calendrier" et inscrivez-vous en utilisant le lien disponible.</p>

<h3>Logiciels Clients (Outlook&reg;, iCal, Mozilla Thunderbird, Evolution)</h3>

<p>Dans la plupart des cas, le lien d'inscription ouvrira votre logiciel client et mettra tout automatiquement en place.
Pour Outlook, si cela ne fonctionne pas, ajouter manuellement un calendrier dans le logiciel en copiant l'URL fournie lors de l'inscription au calendrier de Booked Scheduler.</p>

<h3>Agenda Google&reg;</h3>

<p>Cliquez sur la flèche d' "Autres agendas" puis sur "Ajouter par URL". Copiez l'URL fournie lors de l'inscription dans Booked Scheduler.</p>


-------------------------------------------------------------


<h2>Quotas</h2>

<p>Les Administrateurs peuvent configurer des règles de quotas basées sur différents critères. Si votre
   réservation va à l'encontre de ces règles, vous serez prévenu et celle-ci sera refusée.</p>

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
