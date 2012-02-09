{*
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl'}
<h1>Aide phpScheduleIt</h1>

<div id="help">
<h2>Enregistrement</h2>

<p>L'enregistrement est obligatoire pour utiliser phpScheduleIt.
    Si l'administrateur a activé l'automatisme chaque utilisateur peut le faire lui même. Sinon, c'est l'administrateur qui crée les comptes. 
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
    <br>- Que vous ayez le droit de reserver la ressource
    <br>- Que le créneau horaire soit cohérent (heure de début avant l'heure de fin par exemple)
    <br>- Qu'elle ne soit pas bloquée pour tout autre raison.
    <br>En tout état de cause, contactez l'administrateur qui devrait, soit résoudre votre souci, soit vous en donner la raison.
</p>


<h3>Ressources Multiples</h3>

<p>Vous pouvez réserver toutes les ressources qui vous sont autorisées en une seule réservation. Pour ajouter plus
    de ressources à votre réservation, cliquez sur "(+ de Resources)" , à droite de la première ressource affichée.
    Vous pourrez ensuite ajouter des ressources en les sélectionnant puis en cliquant sur le bouton "Valider".</p>

<p>Pour ôter des ressources supplémentaires à la réservation, cliquez sur "(+ de Resources)", déselectionnez la/les
   ressource(s) concernée(s) puis validez.</p>

<p>Les ressources supplémentaires obéissent aux même rêgles que la première.Par exemple, cela veut dire que si
   vous essayez de créer une réservation de  2 heures avec
   <br>- La Ressource 1 qui a un maximum de 3 heures
   <br>et
   <br>- La Ressource 2 qui a un maximum de 1 heure
   <br>Votre réservation sera refusée.</p>

<p>En survolant le nom de la réservation, les informations sur la ressource s'affichent.</p>


<h3>Dates récurrentes</h3>

<p>Vous pouvez configurer votre réservation pour qu'elle se reproduise régulièrement.
 Notez que cet evenement se répetera  aussi le jour de la date fixée dans "jusqu'au XX/XX/XXXX". </p>

<p>Cette option offre de nombreux possibilités.
   <br>Par exemple :
   
   <br>- Une "Répétition">"Journalière">Tous les "2 jours" --> créera des réservations régulières espacées de deux jours.
   <br>- Une "Répétition">"Hebdomadaire">Tous les "2 semaines" fixée au Jeudi --> créera une réservation le jeudi toute les 2 semaines.
   <br>- Une "Répétition" > "Mensuelle">Tous le "2 mois"Jour du mois --> répetera votre résa tous les 2 mois,  les 3 du mois, si on est le 3.
   <br>- Une "Répétition" > "Mensuelle">Tous le "2 mois">Jour de la semaine --> répetera votre résa tous les 2 mois les premiers samedi du mois, si on est le premier samedi du mois.  
</p>

<h3>Participants et invités</h3>

<p>Vous pouvez ajouter des participants et/ou des invités lors d'une réservation.
Les participants seront rajoutés à la réservation et recevront un mail de confirmation.
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

<p>Vous pouvez mettre à jour une réservation que vous avez créé ou que l'on a créé en votre nom.</p>

<h3>Mettre à jour toutes les instances d'une série</h3>

<p>
    Si une réservation est réglée pour se répéter, une série est crée.
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

<p>La démarche est la même que pour la mise à jour, vous choisissez quelle instance vous voulez effacer à l'effacement d'une dans la série.</p>

<p>Seuls les administrateurs de l'application peuvent effacer des réservations passées.</p>

<h2>Ajouter une Réservation à Outlook &reg;</h2>

<p>A la consultation ou à la mise à jour d'une réservation, vous verrez un bouton "Ajouter à Outlook".
    Si Outlook est installé sur votre ordi, il vous sera demandé si vous voulez l'ajouter, sinon vous pourrez 
    télécharger le fichier ".ics".C'est un format standard de calendrier, utilisable dans toutes les 
    applications qui supportent le format "iCalendar".</p>

<h2>Quotas</h2>

<p>Les Administrateurs peuvent configurer des rêgles de quotas basées sur différents critères. si votre 
   réservation va à l'encontre de ces rêgles, vous serez prévenu, et celle-ci sera refusée.</p>

<h2>Administration</h2>

<p>En tant qu'Administrateur vous aurez un menu en plus : "Gestion de l'application".
   Tous les réglages se feront ici.</p>

<h3>Configuration des Plannings</h3>

<p>Par défaut, un planning est créé à l'installation de l'application.
    Vous pouvez modifier et ajouter des plannings via le menu "Gestion de l'application/Plannings".
</p>

<p>Chaque planning a une configuration qui lui est propre.Ceci permet le controle de la disponibilité des ressources
sur celui-ci.Vous pourrez modifier cette configuration en cliquant sur "Modifier sa configuration" à savoir :
   <br>- Modifier les créneaux horaires dans la mesure ou ceux-ci couvrent 24H et vont de minuit à minuit
   <br>- Donner un libellé à ces créneaux (si besoin).</p>

<p>Un créneau sans libellé doit être de la forme : 10:25 - 16:50</p>

<p>Un créneau avec libellé doit être de la forme : 10:25 - 16:50 Periode 4</p>

<p>Sous la fenêtre de configuration des créneaux se trouve un outil de création de créneaux. celui-ci crée les créneaux avec l'intervale saisi dans une periode que vous fixez.</p>

<h3>Configuration des Ressources</h3>

<p>Vous pouvez visualiser et gérer les ressources via le menu "Gestion de l'application/Ressources".
</p>

<p>Les ressources peuvent être tout ce que voulez rendre reservable (Salles, Equipements, etc...). Pour être reservable, toute ressource doit être liée à un planning.
   La ressource hérite alors des propriétés et réglages issus du planning.</p>

<p>Il est possible d'obliger à créer des réservations ayant une longueur minimum (par défaut il n'y a pas de minimum).</p>

<p>Il est possible d'obliger à créer des réservations ayant une longueur maximum (par défaut il n'y a pas de maximum).</p>

<p>Mettre une approbation obligatoire sur une ressource entrainera la mise en attente des réservations liées à cette ressource jusqu'a approbation (par défaut pas d'approbation).</p>

<p>Mettre une ressource en permission automatique permettra à tous les utilisateurs enregistrés d'y avoir accès (mis par défaut)</p>

<p>Vous pouvez poser un délai maximum avant réservation en configurant la ressource pour qu'elle demande un certain nombre de jours/heures/minutes.
    <br>Par exemple :
    <br>- Si on est un Lundi à 10h30 du matin et que la ressource nécessite au maximum 1 jour de préavis 
    <br>- la ressource ne sera pas réservable qu'a partir du dimanche précédent à 10h30 du matin.
    <br>Par défaut, il n'y a pas de délai.</p>

<p>Vous pouvez empêcher la réservation d'une ressource à des dates trop éloignées en demandant un nombre de jours/heures/minutes.
    <br>Par exemple :
    <br>- Si on est un Lundi à 10h30 du matin et que la réservation ne peut finir dans plus d'1 jour
    <br>- La réservation ne pourra dépasser le Mardi à 10h30 du matin
    <br>Par défaut, il n'y a pas de maximum.</p>

<p>Certaines ressources peuvent avoir une capacité maximum. Ainsi, une salle de conférence peut, par exemple, n'acceuillir que 8 personnes.
    On pourra donc empêcher de dépasser le maximum de la capacité admise (sans compter l'organisateur).
    Par défaut, les ressources ont une capacité illimitée.</p>

<p>Les Administrateurs de l'application sont exempts de ces contraintes d'usage.</p>

<h3>Configuration des Accessoires</h3>

<p>On peut considérer les accessoires comme des objets utilisés lors des réservations (Vidéoprojecteurs, chaises, etc...).</p>

<p>Les Accessoires peuvent être visualisés et gérés dans le menu "Gestion de l'application/Accessoires". Il est possible
    de fixer une quantité maximum d'accessoires empruntés à la fois.</p>

<h3>Configuration des Quotas</h3>

<p>Pour prévenir de trop fréquentes réservations par une même personne, il est possible de fixer des quotas. 
    <br>Le système de quotas dans phpScheduleIt est très flexible, permettant de poser des limites basées sur 
    la longueur et le nombre de réservations. 
    <br>Les quotas "s'additionnent". On peut ainsi cumuler un quotas de 5 heures/jours et de 2 réservations/jours ce qui permet à un
    utilisteur 1 réservation de 5 heures, 2 de 2h30, .... mais ni 5 de 1 heure, ni 2 de 3 heures etc....
    Il existe ainsi de multiples combinaisons.</p>

<p>Les Administrateurs de l'application sont exempts des limites de quotas.</p>

<h3>Configuration des Annonces</h3>

<p>Les annonces sont un moyen simple d'afficher des informations aux utilisateurs via le tableau de bord. 
   <br>Le menu "Gestion de l'application/Annonces" permet des les gérer.
   <br>Une annonce peut avoir avec une fin et un début de diffusion, si besoin est.
   <br>Une notion de priorité, classant les annonces de 1 à 10 est aussi disponible.</p>

<p>Vous pouvez y insérer des balises HTML (permettant de lier des images ou liens du net).</p>

<h3>Configuration des Groupes</h3>

<p>Les Groupes dans phpScheduleIt permettent l'organisation des utilisateurs, 
   le contrôle des permissions d'accès aux ressources et la définition des rôles dans l'application</p>

<h3>Les Rôles</h3>

<p>Les Rôles donnent à un groupe l'autorisation de faire certaines actions.</p>

<p>Les utilisateurs appartenants à un groupe qui a les droits "Application Administrator" ont tous les privilèges administrateurs.
    Ce role n'a presque aucune restrictions sur tout ce qui se réserve. Il peut gérer tous les aspects de l'application.</p>

<p>Les Utilisateurs d'un groupe qui a les droits "Group Administrator" peuvent réserver au nom des autres et de gérer 
   les utilisateurs de ce groupe.</p>

<h3>Voir et Gérer les Réservations</h3>

<p>Vous pouvez voir et gérer les réservations via le menu "Gestion de l'application/Reservations".
    <br>Vous pouvez filtrer l'affichage plus ou moins finement en fonction de ce que vous cherchez.
    <br>Cet outil vous permettra de trouver rapidement une réservation et de la modifier.
    <br>Vous pouvez aussi exporter cette liste filtrée au format CSV.</p>

<h3>Les Approbations de Réservation</h3>

<p>Dans l'outil d'administration vous pourrez voir et approuver les réservations en attente. Les réservations en attente
   sont différenciés par leur couleur.</p>

<h3>Voir et Gérer le Utilisateurs</h3>

<p>Vous pouvez ajouter, voir, et gérer tous les utilisateurs enregistrés dans le menu "Gestion de l'application/Utilisateurs".
    Cet outil vous permettra de changer les permissions d'accès propres à chaque utilisateur, désactiver et effacer des comptes,
    réinitialiser le mots de passe et modifier les informations des utilisateurs.
    <br>Vous pouvez aussi ajouter de nouveaux utilisateurs à phpScheduleIt. C'est d'autant plus utile si l'enregistrement "libre" est désactivé.</p>

<h2>Configuration</h2>

<p>Quelques fonctionnalités de phpScheduleIt peuvent uniquement être gérées via l'édition du fichier "config.php".</p>

<p class="setting"><span>server.timezone</span>C'est le Fuseau horaire du serveur qui héberge phpScheduleIt. 
 Le fuseau en cours est visible via le menu "Gestion de l'application/Préférences du serveur". Les valeurs possibles sont disponibles ici :
    http://php.net/manual/en/timezones.php</p>

<p class="setting"><span>allow.self.registration</span>Determine si les utilisateurs peuvent eux même créer de nouveaux comptes.</p>

<p class="setting"><span>admin.email</span>Adresse email de l'administrateur principal de l'application</p>

<p class="setting"><span>default.page.size</span>Le nombre de lignes initial pour toute page affichant une liste de données</p>

<p class="setting"><span>enable.email</span>Autorise l'envoi d'emails (ou non) depuis phpScheduleIt</p>

<p class="setting"><span>default.language</span>Langue par défaut pour tous. Ce peut être toute langue disponible dans le répertoire "lang" de phpScheduleIt</p>

<p class="setting"><span>script.url</span>L'URL publique complète (racine de l'instance de phpScheduleIt). Devrait être le repertoire Web qui contient index.php</p>

<p class="setting"><span>password.pattern</span>Une expression régulière pour renforcer la complexité du mot de passe lors de la création de compte</p>

<p class="setting"><span>show.inaccessible.resources</span>Affiche (ou cache) une ressource non accessible aux utilisateurs dans le planning</p>

<p class="setting"><span>notify.created</span>Envoi (ou non) un email aux administrateurs lors de la création d'une nouvelle réservation</p>

<p class="setting"><span>image.upload.directory</span>Le répertoire physique où se trouveront les images. Ce répertoire doit avoir des droits en écriture.</p>

<p class="setting"><span>image.upload.url</span>L'URL relative au script.url où les images uploadés peuvent être vus</p>

<p class="setting"><span>cache.templates</span>Affiche (ou cache) les templates. Il est recommandé de le rêgler à "true", tant que "tpl_c" est modifiale (droits en ecriture)</p>

<p class="setting"><span>registration.captcha.enabled</span>Active (ou non) l'image captcha de sécurité durant l'enregistrement des comptes utilisateurs.</p>

<p class="setting"><span>inactivity.timeout</span>Temps (minutes) après lequel un utilisateur est automatiquement déconnecté</p>

<p class="setting"><span>['database']['type']</span>Tout type PEAR::MDB2 supporté</p>

<p class="setting"><span>['database']['user']</span>Utilisateur de la base de données</p>

<p class="setting"><span>['database']['password']</span>Mot de passe de l'utilisateur de base de données</p>

<p class="setting"><span>['database']['hostspec']</span>URL d'hebergement de la base ou "named pipe"</p>

<p class="setting"><span>['database']['name']</span>Nom de la base</p>

<p class="setting"><span>['phpmailer']['mailer']</span>Librairie PHP des emails. les Options sont mail, smtp, sendmail, qmail</p>

<h2>Plugins</h2>

<p>Ces composants sont diponibles:</p>

<ul>
    <li>Authentication - Qui est autorisé à se connecter</li>
    <li>Authorization - Ce qu'un utilisateur peut faire une fois connecté</li>
    <li>Permission - A quelles ressources  un utilisateur a accès</li>
    <li>Pre Reservation - Ce qui se passe avant qu'une réservation ne soit enregistrée</li>
    <li>Post Reservation - Ce qui se passe après qu'une réservation ai été enregistrée</li>
</ul>

<p>
    Pour activer un plugin remplissez sa valeur dans le fichier de configuration avec le nom du dossier du plugin.
    <br>Par exemple, pour activer
    <br>LDAP
    authentication, 
    <br>Remplissez comme ceci cette valeur
    <br>$conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

<p>
    Les Plugins doivent avoir leur propre fichier de configuration. Pour LDAP, renommez ou copiez
    /plugins/Authentication/Ldap/Ldap.config.dist en /plugins/Authentication/Ldap/Ldap.config et editez 
    toutes les valeurs applicables à votre environnement.</p>

<h3>Installer des Plugins</h3>

<p>
    Pour installer un nouveau plugin copier les dossiers Authentication, Authorization et Permission .
    <br>Ensuite, 
    ajoutez le nom du dossier comme ceci 
    <br>$conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] ou
    $conf['settings']['plugins']['Permission'] au ficheir config.php .</p>

{include file="support-and-credits.tpl"}
</div>

{include file='globalfooter.tpl'}
