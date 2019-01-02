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
<h1>Administration de Booked Scheduler </h1>

<div id="help">
<h2>Administration</h2>

<p>Si vous avez le statut d'administrateur d'application, alors vous verrez les menus "Gestion de l'application", "Responsables" et "Rapports". Toutes les tâches de gestion se feront ici.</p>

<h3>Mettre en place un planning</h3>

<p>
A l'installation, un planning par défaut va être créé. Via le sous-menu "plannings", vous pourrez créer, voir, modifier et ajouter des plannings (et leur ajouter des attributs supplémentaires).

</p>

<p>Chaque planning doit avoir une grille de créneaux horaires définie. Cela permet de contrôler la disponibilité des ressources.
En cliquant sur "Modifier sa configuration", vous ouvrirez un éditeur de créneaux horaires. Ces créneaux doivent couvrir 24h et peuvent avoir les statuts "Réservables" ou "Bloqués" (un créneau par ligne).
Il est aussi possible d'y ajouter un texte explicatif.</p>

<p>Un créneau sans texte sera de la forme: "10:25 - 16:50"</p>

<p>Un créneau avec texte sera de la forme: "10:25 - 16:50 Texte de Mon Créneau"</p>

<p>Sous la liste des créneaux, un assistant vous permettra de créer ceux-ci à des intervalles fixes.</p>

<h3>Mettre en place des Ressources</h3>

<p>Vous pouvez gérer les ressources via le sous-menu "Ressources".
</p>

<p>Les Ressources dans Booked Scheduler peuvent être tout ce que vous voulez (Salles, équipements, ...). Chaque ressource doit être liée à un planning pour être réservable. La ressource héritera donc des créneaux horaires de réservabilité définis pour le planning.
</p>

<p>Une durée minimum de réservation empêchera la saisie d'une réservation plus courte que le temps que vous aurez défini (par défaut: pas de minimum).
.</p>
<p>Une durée maximum de réservation empêchera la saisie d'une réservation plus longue que le temps que vous aurez défini (par défaut: pas de maximum).</p>

<p>Demander une approbation pour une ressource entraînera une "mise en attente" des réservations jusqu'à approbation par le responsable (par défaut: pas d'approbation).</p>

<p>Autoriser la permission automatique donne le droit de réserver la ressource à tout nouvel utilisateur (par défaut: la permission automatique est autorisée)</p>

<p>Vous pouvez obliger un délai précédent la réservation en fixant un nombre de jours/heures/minutes.

Par exemple, si nous voulons ajouter une réservation un lundi à 10h30 et que la ressources nécessite 1 jour de délai avant l'heure de réservation, celle-ci ne pourra être réservée qu'à partir du dimanche précédent à 10h30 (par défaut: pas de délai avant le début de la réservation).</p>

<p>Vous pouvez empêcher une réservation faite trop en avance en statuant sur un nombre maximum de jours/heures/minutes de délai entre le moment présent et la réservation.
Par exemple, nous sommes un lundi à 10h30 et la ressource ne peut être réservée à plus d'un jour dans le futur. Ainsi celle-ci ne sera réservable que jusqu'à mardi à 10h30 (par défaut: pas de maximum).</p>

<p>Certaines ressources peuvent avoir une capacité d'utilisation. Par exemple, une salle peut ne pouvoir contenir que 8 personnes.
Fixer cette capacité (organisateur non inclus) permet d'adapter le nombre de participants (raisons de sécurité, par exemple) aux possibilités de cette salle (par défaut: les ressources ont une capacité illimitée).</p>

<p>Les Administrateurs d'application sont exempts de ces contraintes.</p>

<h3>Image de la Ressource</h3>

<p>Vous pouvez attribuer une image à une ressource (affichée dans la vue détaillé dans la page de réservation).
cela nécessite l'installation de php_gd2 et son activation dans le fichier php.ini de votre serveur.
 <a href="http://www.php.net/manual/en/book.image.php">Plus de détails...</a></p>

<h3>Gérer les Accessoires</h3>

<p>On envisage les accessoires comme des objets utilisés lors de réservations. Par exemple: des vidéoprojecteurs dans une salle.</p>

<p>Les accessoires peuvent être gérés via le sous-menu "Accessoires" du sous-menu "Ressources". Vous pouvez limiter le nombre d'accessoires réservés en fixant une quantité maximum par réservation.</p>

<h3>Gérer les Quotas</h3>

<p>Les quotas permettent de limiter l'utilisation d'une ressource. Ce système dans Booked Scheduler est très flexible, en autorisant de limiter les réservations en durée et en nombre.
Ces quotas s'additionnent.
Par exemple:
- un quota limite une ressource à une durée de réservation de 5 heures par jour
- un autre existe limitant les utilisateurs à 4 réservations par jour

Cet utilisateur pourra faire une réservation de 4 heures, mais ne pourra pas en faire 3 de 2 heures.
Vous pouvez ainsi combiner ces quotas.</p>

<p>Les Administrateurs d'application sont exempts de quotas.</p>

<h3>Gérer les Annonces</h3>

<p>Les annonces sont un moyen simple d'afficher des messages aux utilisateurs. Via le sous-menu "Annonces" vous pouvez gérer les messages affichés dans le tableau de bord. On peut définir à ces annonces une date de début et de fin. Un niveau de priorité est aussi diponible (optionnel) pour permettre un classement de 1 à 10.</p>

<p>Vous pouvez saisir du HTML dans les annonces, et donc aussi y mettre des liens et images venant du web.</p>

<h3>Gérer les Groupes</h3>

<p>Les groupes permettent d'organiser les utilisateurs, de contrôler les permissions d'accès aux ressources et de définir des rôles dans l'application.</p>

<h3>Rôles</h3>

<p>Les rôles donnent à un groupe l'autorisation d'effectuer certaines actions.</p>

<p>Les utilisateurs qui appartiennent à un groupe qui a le rôle d'Administrateur d'Application ont tous les droits d'administration.
Ce rôle n'a presque aucune restriction quant aux réservations de ressources. Il peut gérer presque toute l'application.</p>

<p>Les utilisateurs qui appartiennent à un groupe qui a le rôle d'Administrateur de rôle ont le droit de réserver pour quelqu'un d'autre ainsi que gérer les utilisateurs de ce groupe.</p>

<h3>Gérer les Réservations</h3>

<p>Via le sous-menu "Réservations". Par défaut, les 7 jours passés et suivants la date en cours sont affichés.
Il y est possible de filtrer les résultats pour trouver facilement une réservation. Vous pouvez aussi faire un export de la liste
de réservations en CSV.</p>

<h3>Approbation de Réservations</h3>

<p>Depuis la liste des réservations, vous pourrez effectuer les approbations de réservations. Celles qui sont en attente sont surlignées.</p>

<h3>Gérer les Utilisateurs</h3>

<p>Via le sous-menu "Utilisateurs". Il y est possible de changer les droits d'accès aux ressources d'un utilisateur, d'ajouter, de modifier, désactiver, ou effacer des comptes, de réinitialiser des mots de passe.</p>

<h3>Rapports</h3>

<p>Des rapports (statistiques) sont disponibles via le menu "Rapports".
Il existe des rapports "clés en mains" ("rapports standards") mais vous pouvez aussi créer et sauvegarder vos propres rapports personnalisés.
Ces rapports peuvent être affichés (sous forme de listes ou de graphiques imprimables) et exportés en CSV. Vous pouvez aussi envoyer par mail les rapports sauvegardés.</p>

<h2>Configuration</h2>

<p>Certaines des fonctionnalités du logiciel ne sont configurables que dans le fichier de configuration ("/config/config.php").</p>

<p class="setting"><span>$conf['settings']['server.timezone']</span>C'est le fuseau horaire du serveur qui héberge Booked Scheduler.
 Le fuseau en cours est visible via le menu "Gestion de l'application/Préférences du serveur". Les valeurs possibles sont disponibles ici :
    http://php.net/manual/en/timezones.php</p>

<p class="setting"><span>$conf['settings']['allow.self.registration']</span>Détermine si les utilisateurs peuvent eux-mêmes créer de nouveaux comptes.</p>

<p class="setting"><span>$conf['settings']['admin.email']</span>Adresse email de l'administrateur principal de l'application.
</p>

<p class="setting"><span>$conf['settings']['default.page.size']</span>Le nombre de lignes initial pour toute page affichant une liste de données.
</p>

<p class="setting"><span>$conf['settings']['enable.email']</span>Autorise l'envoi d'emails (ou non) depuis Booked Scheduler.
</p>

<p class="setting"><span>$conf['settings']['default.language']</span>Langue par défaut pour tous. Ce peut être toute langue disponible dans le répertoire "lang" de Booked Scheduler.</p>

<p class="setting"><span>$conf['settings']['script.url']</span>L'URL publique complète (racine de l'instance de Booked Scheduler). Devrait être le repertoire Web qui contient les fichiers bookings.php, calendar.php,  ...</p>

<p class="setting"><span>$conf['settings']['password.pattern']</span>Une expression régulière pour renforcer la complexité du mot de passe lors de la création de compte.</p>

<p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>Affiche (ou cache) une ressource non accessible aux utilisateurs dans le planning.</p>

<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>La valeur à afficher pour la réservation dans le planning ('name' - par défaut: 'title','none').</p>

<p class="setting"><span>$conf['settings']['image.upload.directory']</span>Le répertoire physique où se trouveront les images. Ce répertoire doit avoir des droits en écriture (755).</p>

<p class="setting"><span>$conf['settings']['image.upload.url']</span>L'URL relative au script.url où les images uploadées peuvent être vues.</p>

<p class="setting"><span>$conf['settings']['cache.templates']</span>Met en cache (ou non) les templates. Il est recommandé de le règler à "true", tant que "tpl_c" est modifiable (droits en écriture).</p>

<p class="setting"><span>$conf['settings']['use.local.jquery']</span>Autorise (ou non) une version locale de jQuery.
Si fixé à "false", les fichiers seront ceux de Google CDN. Il est recommandé de mettre à "false" pour optimiser les performances. "false" par défaut.</p>

<p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>Active (ou non) l'image captcha de sécurité durant l'enregistrement des comptes utilisateurs.</p>

<p class="setting"><span>$conf['settings']['registration.require.email.activation']</span>Détermine si les utilisateurs doivent activer leur compte par email avant de pouvoir se connecter.</p>

<p class="setting"><span>$conf['settings']['registration.auto.subscribe.email']</span>Fixe l'inscription automatique aux emails des utilisateurs après enregistrement du compte.</p>

<p class="setting"><span>$conf['settings']['inactivity.timeout']</span>Temps (minutes) après lequel un utilisateur est automatiquement déconnecté (rien = automatique)</p>

<p class="setting"><span>$conf['settings']['name.format']</span>Affiche le format des prénoms et noms. Par défaut: {literal}'{prénom} {nom}'{/literal}.</p>

<p class="setting"><span>$conf['settings']['ics']['require.login']</span>Spécifie si les utilisateurs doivent être connectés pour ajouter une réservation à Outlook.</p>

<p class="setting"><span>$conf['settings']['ics']['subscription.key']</span>Pour permettre des inscriptions webcal. Si rien d'indiqué, les inscriptions webcal sont désactivées.</p>

<p class="setting"><span>$conf['settings']['privacy']['view.schedules']</span>Autoriser (ou non) le lecture du planning par des utilisateurs non connectés. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['privacy']['view.reservations']</span>Autoriser (ou non) le lecture du détails des réservations par des utilisateurs non connectés. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['privacy']['hide.user.details']</span>Autorise (ou non) les non-administrateurs à voir les informations personnelles des utilisateurs. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation']['start.time.constraint']</span>Détermine quand les réservations peuvent être créées ou modifiées. valeurs possibles: "future", "current", "none". "future" signifie que les réservations ne peuvent être créées ou modifiées si l'heure de début du créneau horaire choisi est passée. "current" signifie que les réservations peuvent être créées ou modifiées si l'heure de fin du créneau horaire choisi n'est pas dépassée. "none" signifie qu'il n'y a aucune restriction. Par défaut "future".</p>

<p class="setting"><span>$conf['settings']['reservation']['updates.require.approval']</span>Fixe si des réservations anciennement approuvées, puis modifiées, nécessitent une seconde approbation. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.participation']</span>Interdit (ou non) les utilisateurs d'ajouter ou d'inviter d'autres utilisateurs à une réservation. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.recurrence']</span>Interdit aux utilisateurs de créer des réservations réccurentes. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>Envoie un mail à tous les Administrateurs de Ressources quand une réservation est créée. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>Envoie un mail à tous les Administrateurs de Ressources quand une réservation est mise à jour. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>Envoie un mail à tous les Administrateurs de Ressources quand une réservation est effacée. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>Envoie un mail à tous les Administrateurs d'Application quand une réservation est créée. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>Envoie un mail à tous les Administrateurs d'Application quand une réservation est mise à jour. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>Envoie un mail à tous les Administrateurs d'Application quand une réservation est effacée. Par défaut "false"..</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>Envoie un mail à tout le groupe Administrateurs quand une réservation est créée. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>Envoie un mail à tout le groupe Administrateurs quand une réservation est mise à jour. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>Envoie un mail à tout le groupe Administrateurs quand une réservation est effacée. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['css.extension.file']</span>URL relative ou absolue pointant sur un fichier CSS supplémentaire à inclure. On peut ainsi "Surcharger" le CSS en place pour créer son propre style voire son propre thème. A laisser vide si vous voulez utiliser Booked Scheduler tel quel.</p>

<p class="setting"><span>$conf['settings']['uploads']['enable.reservation.attachments']</span>Autorise les utilisateurs à joindre des fichiers aux réservations. Par défaut "false".</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.path']</span>Le chemin d'accès absolu ou relatif du répertoire où sont stockés les fichiers joints aux réservations (lié au répertoire "racine" de Booked Scheduler). Ce répertoire doit avoir des droits en écriture (755 recommandé). Par défaut "uploads/reservation".</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>Liste des extensions de fichiers autorisées, séparée par des virgules (ex: "png,pdf,csv") . Laisser vide autorisera tout type de fichiers (non recommandé à cause des virus).</p>

<p class="setting"><span>$conf['settings']['database']['type']</span>Tout type PEAR::MDB2 supporté</p>

<p class="setting"><span>$conf['settings']['database']['user']</span>Utilisateur de la base de données</p>

<p class="setting"><span>$conf['settings']['database']['password']</span>Mot de passe de l'utilisateur de base de données</p>

<p class="setting"><span>$conf['settings']['database']['hostspec']</span>URL d'hébergement de la base ou "named pipe"</p>

<p class="setting"><span>$conf['settings']['database']['name']</span>Nom de la base</p>

<p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>Librairie PHP des emails. les Options sont mail, smtp, sendmail, qmail</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>Adresse serveur, si vous utilisez smtp</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.port']</span>Port SMTP, si vous utilisez smtp. Habituellement: 25</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.secure']</span>Sécurisation SMTP, si vous utilisez smtp. Options : '', "ssl" ou "tls"</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.auth']</span>SMTP nécesssite une authentication, si vous utilisez smtp. Options : "true" ou "false"</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.username']</span>Utilisateur SMTP, si vous utilisez smtp</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.password']</span>Mot de passe SMTP, si vous utilisez smtp</p>

<p class="setting"><span>$conf['settings']['phpmailer']['sendmail.path']</span>Chemin d'accès à "sendmail", si vous utilisez sendmail</p>

<p class="setting"><span>$conf['settings']['plugins']['Authentication']</span>Nom du répertoire du plugin gérant l'authentification à utiliser. Plus d'infos sur les plugins dans le paragraphe "Plugins" ci-dessous.</p>

<p class="setting"><span>$conf['settings']['plugins']['Authorization']</span>Nom du répertoire du plugin gérant l'autorisation. Plus d'infos sur les plugins dans le paragraphe "Plugins" ci-dessous.</p>

<p class="setting"><span>$conf['settings']['plugins']['Permission']</span>Nom du répertoire du plugin gérant les permissions. Plus d'infos sur les plugins dans le paragraphe "Plugins" ci-dessous.</p>

<p class="setting"><span>$conf['settings']['plugins']['PreReservation']</span>Nom du répertoire du plugin gérant les préréservations. Plus d'infos sur les plugins dans le paragraphe "Plugins" ci-dessous.</p>

<p class="setting"><span>$conf['settings']['plugins']['PostReservation']</span>Nom du répertoire du plugin gérant les postréservations. Plus d'infos sur les plugins dans le paragraphe "Plugins" ci-dessous.</p>

<p class="setting"><span>$conf['settings']['install.password']</span>C'est ce mot de passe qui vous sera demandé en cas d'installation ou de mise à jour de l'application</p>

<h2>Plugins</h2>

<p>Ces composants sont diponibles (répertoire "plugins"):</p>

<ul>
  <li>"Authentication" - Qui est autorisé à se connecter</li>
  <li>"Authorization" - Ce qu'un utilisateur peut faire une fois connecté</li>
  <li>"Permission" - A quelles ressources  un utilisateur a accès</li>
  <li>"Pre Reservation" - Ce qui se passe avant qu'une réservation ne soit enregistrée</li>
  <li>"Post Reservation" - Ce qui se passe après qu'une réservation ait été enregistrée</li>
</ul>

<p>Pour activer un plugin, remplissez la valeur du fichier de configuration avec le nom du répertoire du plugin.
Par exemple, pour activer "l'authentication" de "Ldap", saisissez: $conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

<p>Les plugins peuvent avoir leur propre fichier de configuration. Pour "Ldap", renommez ou copiez le fichier "/plugins/Authentication/Ldap/Ldap.config.dist" en "/plugins/Authentication/Ldap/Ldap.config" et modifiez les valeurs de ce fichier pour les adapter à votre environnement.</p>

<h3>Installer des Plugins</h3>

<p>Pour installer un nouveau plugin<br>
- copiez le répertoire du plugin dans le répertoire concerné :
"plugins/Authentication" ou  "plugins/Authorization" ou "plugins/Permission".<br>
- Saisissez le nom du répertoire du plugin dans la valeur du fichier "config.php" concernée :
$conf['settings']['plugins']['Authentication'] ou $conf['settings']['plugins']['Authorization'] ou
	$conf['settings']['plugins']['Permission']</p>

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
