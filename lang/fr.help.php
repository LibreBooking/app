<?php
/**
* French (fr) help translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator J. Pe. <jpe@chez.com>
* @translator Benoit Mortier <benoit.mortier@opensides.be>
* @version 07-10-04
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all the help file for phpScheduleit.  Please save the translated
//  file as '2 letter language code'.help.php.  For example, en.help.php.
// 
// To make phpScheduleIt help available in another language, simply translate this
//  file into your language.  If there is no direct translation, please provide the
//  closest translation.
//
// This will be included in the body of the help file.
//
// Please keep the HTML formatting unless you need to change it.  Also, please try
//  to keep the HTML XHTML 1.0 Transitional complaint.
///////////////////////////////////////////////////////////
?>
<div align="center"> 
  <h3><a name="top" id="top"></a>Introduction à phpScheduleIt</h3>
  <p><a href="http://phpscheduleit.sourceforge.net" target="_blank">http://phpscheduleit.sourceforge.net</a></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: solid #CCCCCC 1px">
    <tr> 
      <td bgcolor="#FAFAFA"> 
        <ul>
          <li><b><a href="#getting_started">Préliminaires</a></b></li>
          <ul>
            <li><a href="#registering">Enregistrement</a></li>
            <li><a href="#logging_in">Connexion</a></li>
            <li><a href="#language">Choisir ma langue</a></li>
            <li><a href="#manage_profile">Modification des identifiants et du mot de passe</a></li>
            <li><a href="#resetting_password">Ré-initialisation de votre mot de passe oublié</a></li>
            <li><a href="#getting_support">Obtenir de l'aide</a></li>
          </ul>
          <li><a href="#my_control_panel"><b>Mon panneau de contrôle</b></a></li>
          <ul>
            <li><a href="#my_announcements">Mes annonces</a></li>
            <li><a href="#my_reservations">Mes réservations</a></li>
            <li><a href="#my_training">Mes privilèges</a></li>
            <li><a href="#quick_links">Mes liens rapides</a></li>
          </ul>
          <li><a href="#using_the_scheduler"><b>Utilisation du planificateur</b></a></li>
          <ul>
      <li><a href="#read_only">Version en lecture seule</a></li>
            <li><a href="#making_a_reservation">Effectuer une réservation</a></li>
            <li><a href="#modifying_deleting_a_reservation">Modification/Effacement d'une réservation</a></li>
            <li><a href="#navigating">Se déplacer dans le planificateur</a></li>
          </ul>
        </ul>
    <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="getting_started" id="getting_started"></a>Préliminaires</h4>
        <p>Afin d'utiliser phpScheduleIt, au préalable, vous devez vous enregistrer.
          Si vous etes déjà enregistré, alors vous devez vous connecter avant d'utiliser 
          le système. En entête de chaque page (à l'exception des pages  d'enregistrement et de connexion)
          vous verrez un message de bienvenue, la date du jour, et quelques liens.
          -- un lien &quot;connexion&quot; et un lien &quot;Mon panneau de contrôle;
          sous le message de bienvenue, et un lien &quot;Help Me&quot; sous 
          la date.</p>
          <p>Si le nom d'un utilisateur précédent est affiché dans le message de bienvenue, click &quot;
          Déconnexion&quot; pour effacer tout cookie précédemment enregistré et <a href="#logging_in">Connectez
          vous</a> sous votre nom. Cliquer sur &quot;Mon panneau de Contrôle&quot; vous
          amènera à <a href="#my_control_panel">Mon panneau de contrôle</a>, votre &quot;page d'accueil
          &quot; dans le planificateur.
          Cliquer sur &quot;HelpMe&quot; fait apparaître une fenêtre d'aide. Cliquer
          &quot;Envoi d'un message électronique à l'administrateur&quot; ouvre la messagerie sur la 
          rédaction d'un message adressé à l'administrateur.</p>
          <p><font color="#FF0000">Attention:</font> Si vous utilisez Norton Personal
            Firewal en même temps que phpScheduleIt, il est possible que vous rencontriez
            des difficultés. S'il vous plait désactivez Norton Personal Firewal pendant 
            l'utilisation de phpScheduleIt et ré-activez le ensuite.</p>
          <p align="right"><a href="#top">Top</a></p>
        <h5><a name="registering" id="registering"></a>Enregistrement</h5>
        <p>Pour vous enregistrer, en premier lieu positionnez vous sur
          la page d'enregistrement. Elle peut être atteinte grâce à un lien sur la page
          d'accueil initiale. Vous devez renseigner tous les champs. L'adresse de messagerie
          que vous y indiquez sera votre identifiant de connexion. Les informations que vous 
          donnez peuvent, à tout moment, faire l'objet d'une modification à <a href="#quick_links">modifiez 
          vos identifiants</a>. Si vous sélectionnez (cochez) l'option &quot;rendre ma connexion persistante
          &quot; sera utilisé un cookie pour vous identifier chaque fois que vous reviendrez sur 
          phpScheduleIt, sans qu'il ne vous soit nécessaire de vous identifier à la connexion.<i>
          Vous ne devez utilisez cette option qu'à la condition d'être la seule personne à 
          utiliser phpScheduleIt sur l'ordinateur.</i> Après vous être enregistré, vous serez
          dirigé vers <a href="#my_control_panel">Mon panneau de contrôle</a>.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="logging_in" id="logging_in"></a>Connexion</h5>
        <p>La connexion se résume simplement à entrer votre adresse
          de messagerie et votre mot de passe. Vous devez avoir effectué au préalable
          votre <a href="#registering">enregistrement</a> avant de pouvoir vous connecter.
          Ceci peut être effectué en suivant (cliquant sur) le lien d'enregistrement figurant
          sur la page d'accueil. Si vous sélectionnez (cochez) l'option &quot;rendre ma connexion persistante
          &quot; sera utilisé un cookie pour vous identifier chaque fois que vous reviendrez sur 
          phpScheduleIt, sans qu'il ne vous soit nécessaire de vous identifier à la connexion.<i>
          Vous ne devez utilisez cette option qu'à la condition d'être la seule personne à 
          utiliser phpScheduleIt sur l'ordinateur.</i> Après vous être enregistré, vous serez
          dirigé vers <a href="#my_control_panel">Mon panneau de contrôle</a>.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="language" id="language"></a>Choisir ma langue</h5>
        <p>Sur la page d'accueil initiale figure une boite à choix
          multiple comportant toutes les langues disponibles sur le système. Merci de bien vouloir
          choisir la langue que vous préférez, et, ainsi tous les textes de phpScheduleIt seront traduits dans
          cette langue. Cela ne traduira pas tout texte entré par votre administrateur ou un quelconque 
          utilisateur ; cela ne traduira que les message du système. Vous aurez à vous déconnecter pour 
          sélectionner une autre langue.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="manage_profile" id="manage_profile"></a>Modification des identifiants et du mot de passe</h5>
        <p>Pour effectuer des modifications de vos identifiants (nom, adresse électronique, etc.)
          ou de votre mot de passe, premièrement vous devez vous connecter au système. Puis à
          <a href="#my_control_panel">Mon panneau de contrôle</a>, dans 
          <a href="#quick_links">Mes liens rapides</a>, cliquez 
          &quot;Modifier mes identifiants et/ou mon mot de passe&quot;. Cela vous présentera
          un formulaire contenant toutes les informations vous concernant. Modifiez 
          toutes les information que vous souhaitez. Tout champ laissé blanc ne sera pas pris en
          compte dans les modifications. Si vous souhaitez modifier votre mot de passe vous devrez 
          l'indiquer deux fois. Après avoir modifié vos informations,  cliquez &quot;Modification du profil&quot;
          , et ainsi, vos modifications seront prises en compte. Vous serez ensuite conduit de nouveau
          à Mon panneau de contrôle. </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="resetting_password" id="resetting_password"></a>Ré-initialisation de votre mot de passe oublié</h5>
        <p>Si vous avez oublié votre mot de passe, vous avez la possibilité de le faire annuler, 
          et de vous en faire adresser un nouveau par email. Pour cela, sur la page d'accueil initiale, cliquez
          sur &quot;J'ai oublié mon mot de passe&quot; situé sous le formulaire de connexion. Il vous sera 
          présenté une page nouvelle dans laquelle vous serez invité à indiquer votre adresse de messagerie.
          Après avoir cliqué sur le bouton &quot;Envoyer&quot;, un nouveau mot de passe généré de façon aléatoire
          sera créé. Ce nouveau mot de passe sera placé dans la base de donnée et vous sera communiqué par message
          électronique. A la réception de ce message électronique, merci de bien vouloir effectuer un copier/coller
          de ce mot de passe à <a href="#logging_in">Connexion</a>. Ensuite ne tardez pas à en changer la valeur
          à <a href="#manage_profile">Modifier mes caractéristiques et/ou mon mot de passe  </a>.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="getting_support" id="getting_support"></a>Obtenir de l'aide</h5>
        <p>Si vous n'avez pas les privilèges suffisants pour utiliser une ressource, si vous avez des questions
          à propos des ressources, des réservations, ou de votre enregistrement, merci d'utiliser &quot;
          Envoi d'un message électronique à l'administrateur  &quot; situé dans les liens rapides.</p>
        <p align="right"><a href="#top">Top</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="my_control_panel" id="my_control_panel"></a>Mon panneau de contrôle</h4>
        <p>Le panneau de contrôle est votre &quot;page d'accueil&quot;
          dans le système de réservation. C'est là que vous pouvez passer en revue, modifier, ou annuler
          vos réservations. Dans &quot;Mon panneau de contrôle&quot; figurent également les <a href="#quick_links">liens rapides</a>
          permettant d'accéder &quot;Allez sur le planificateur en ligne&quot; 
          &quotModifier mes caractéristiques et/ou mon mot de passe  &quot;
          &quot; Gestion de mes adresses électroniques préférées  &quot;
          &quot;  Envoi d'un message électronique à l'administrateur  &quot;
          et une option pour &quot;Quitter&quot; le système.  </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_announcements" id="my_announcements"></a>Mes annonces</h5>
        <p>Cette table contient tous les messages que l'administrateur juge important de faire passer.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_reservations" id="my_reservations"></a>Mes Réservations</h5>
        <p>Le tableau des réservations présente toute vos réservations à venir en commençant par le jour même.
          Ce tableau indiquera chaque date de réservation, nom de la ressource, Date/heure de création, 
          Date/heure de la dernière modification, heure de début, heure de fin. Depuis ce tableau
          il vous est possible de modifier ou d'annuler une réservation, simplement en cliquant sur 
          &quot;Modification&quot; ou &quot;Effacement&quot; à la fin de chaque ligne de réservation. Ces deux 
          options ouvriront une fenêtre ou il vous sera demandé de confirmer votre choix. Cliquer sur la date
          de réservation ouvrira une fenêtre dans laquelle seront visibles les caractéristiques de la réservation.</p>
         <p> Pour trier vos réservations sur une colonne particulière, cliquer sur le signe &#150 ou le signe + dans 
         l'entête de chaque colonne. Le signe moins triera les réservations en ordre décroissant sur le texte contenu
         par la colonne, le signe plus en ordre croissant.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_training" id="my_training"></a>Mes privilèges</h5>
        <p>Le tableau de &quot;Mes privilèges&quot; présente toutes les ressources qu'ils vous
          est possible de réserver. La liste comprend le nom de la ressource, son emplacement, et le numéro de
          téléphone du responsable.</p>
         <p>Lors de l'enregistrement, il ne vous sera pas donné la permission d'employer toutes les 
         ressources à moins que l'administrateur ait décidé d'accorder aux utilisateurs la permission 
         automatiquement.  L'administrateur est la seule personne qui peut vous donner la permission d'employer 
         une ressource.  Vous ne serez pas autorisés à réserver une ressource pour laquelle il ne vous a pas été 
         donné la permission, mais vous pourrez regarder son programme et ses réservations en cours. </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="quick_links" id="quick_links"></a>Mes liens rapides</h5>
        <p>Le tableau des liens rapides contient les liens aux applications courantes.
          Le premier &quot;Allez sur le planificateur en ligne&quot; vous conduit au planificateur de ressource.
          Vous pourrez y consulter les planifications existantes, y réserver des ressources, et mettre à jour
          vos réservations déjà effectuées.</p>
         <p>&quot;Modifier mes caractéristiques et/ou mon mot de passe&quot; vous conduit à une page où il vous 
          sera possible de modifier vos caractéristiques telles que l'adresse de messagerie, le nom, le numéro de 
          téléphone, et le mot de passe. Toutes ces informations figureront dans un formulaire, à partir duquel 
          vous pourrez les modifier, si vous remplacez une information par des blancs, cela équivaudra à n'en pas 
          demander la modification.</p>
         <p>&quot;Gestion de mes adresses électroniques préférées&quot; vous présente une page sur laquelle vous
          pourrez choisir les type de messages électroniques que vous souhaitez recevoir du système. Par défaut, 
          vous recevez un message électronique au format HTML chaque fois que vous ajoutez, modifiez, annulez une 
          réservation.</p>
         <p>&quot;Envoi d'un message électronique à l'administrateur&quot; Ouvre votre gestionnaire de messagerie
          sur la création d'un message à destination de l'administrateur du système.
         <p>Le dernier lien &quot;Quitter&quot; vous permet de vous déconnecter du système et de revenir à la 
          page d'accueil et de connexion initiale. </p>
        <p align="right"><a href="#top">Top</a></p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="using_the_scheduler" id="using_the_scheduler"></a>Utilisation du planificateur</h4>
        <p>Le planificateur est l'endroit où vous pouvez effectuer toutes les fonctions relatives à la planification
          des ressources. La semaine affichée commence par la semaine courante et les 7 (par défaut) jours suivants.
          C'est là que vous pouvez visualiser, reserver, modifier les ressources déjà réservées. Les réservations
          sont distinguées grace à des couleurs, ainsi toutes sont visibles, mais <i>seules les vôtres</i> seront
          accessibles via un lien (cliquable) pour être modifiées. Toutes les autres réservations ne pourront faire
          l'objet que d'une visualisation.</p>
        <p>Vous pouvez changer de planification (à la condition qu'il en existe plus
          d'une) en utilisant la liste de choix au début de chaque planification. </p>
        <p>L'administrateur du système peut spécifier des plages horaires inaccessibles. Les réservations ne seront
          pas possibles si elles entrent en conflit avec ces plages.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Version en Lecture Seule</h5>
        <p>Si vous n'etes pas encore enregistré, ou connecté, il vous est possible de visualiser une version de la
          planification en lecture seule en cliquant sur &quot;Visualisation de planification&quot;. Cette 
          version montre toutes les planifications, mais ne permet pas d'en visualiser les détails, pas
          plus qu'elle ne permet d'effectuer des réservations.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Effectuer une réservation</h5>
        <p>Pour effectuer une réservation, en premier lieu, positionnez vous dans le tableau
           sur le jour de début de réservation. Un fois le jour localisé dans le tableau, cliquez sur
           le nom de la ressource. Dans une nouvelle fenêtre vous serez invité à choisir la durée pendant
           laquelle vous souhaitez effectuer la réservation. </p>
        <p>Vous y trouverez un message vous indiquant la durée minimale/maximale de la réservation.
          Si la durée de votre réservation est supérieure ou inférieure aux durées indiquées, la réservation
          ne sera pas acceptée.</p>
        <p>Vous pouvez, si vous le désirez, choisir de répéter cette réservation. Pour ce faire,
          choisissez le jour pour lequel elle doit être répétée, puis choisissez la durée pendant laquelle
          vous souhaitez que soit réalisée la répétition. La réservation sera effectuée pour le jour de départ
          choisi, plus tous les jours correspondants au choix de répétition. Toutes les dates pour lesquelles
          la réservation n'aura pu être effectuée du fait d'un conflit seront listées. </p>
        <p>Vous pouvez ajouter un résumé de cette réservation en remplissant la boite de texte résumé. Le résumé
          sera disponible à la lecture pour les autres utilisateurs.</p>
        <p>Après avoir spécifié des heures de début et de fin valides pour la réservation voulue, après avoir
          si nécessaire spécifié les paramètres de répétition cliquez sur le bouton &quot;Sauvegarde&quot;.
          Une message vous sera envoyé si la réservation n'a pu aboutir vous informant de la date pour laquelle
          la réservation n'a pu avoir lieu. Dans ce cas il faut modifier la répétition afin qu'il n'y ait plus
          de conflit. Après que votre réservation ait abouti, la planification est automatiquement ré-affichée.</p>
        <p>Il ne vous est pas possible de réserver une ressource à une date appartenant au passé, pour laquelle vous 
           n'avez pas les privilèges, ou qui a été déclaré inactive par l'administrateur. Ces ressources seront grisées
           et ne seront pas accessibles.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="modifying_deleting_a_reservation" id="modifying_deleting_a_reservation"></a>Modification/Effacement 
        d'une réservation</h5>
        <p>Vous avez plusieurs possibilités pour modifier, ou annuler une réservation. L'une d'entre elles est à partir
           de <a href="#my_control_panel">Mon panneau de contrôle</a> comme décrit ci-dessus. L'autre est via le
           Planificateur en Ligne. Ainsi que précédemment indiqué, vous n'avez accès en modification qu'à vos propres
           réservations, celles des autres vous seront montrées, mais vous seront inaccessibles.</p>
        <p>Pour modifier une réservation via le planificateur, cliquer simplement
           sur la réservation que vous souhaitez modifier. Cela ouvrira une fenêtre très proche de la fenêtre de
           réservation. Vous y aurez deux choix ; vous pouvez soit modifier les heures de début et/ou de fin ou
           cliquer sur le choix &quot;Effacement&quot;. Après avoir effectuer vos modifications, cliquez sur le
           bouton &quot;Modifier&quot; à la fin du formulaire. Vos modifications seront évaluées à nouveau afin
           d'en déduire d'éventuels conflits et un message apparaîtra vous indiquant le résultat de votre requête.
           Si vous devez changer les horaires, retournez à la fenêtre de modifications. Après que votre réservation
           aura été modifiée avec succès, la planification sera automatiquement ré affichée. Ceci est nécessaire
           pour que les nouvelles informations contenues par la base de donnée soient ré affichées. </p>
        <p>Pour modifier un groupe de réservations répétitives, cochez le choix intitulé &quot;Modification de toutes
           les réservations répétitives dans le groupe&quot; Tout conflit de date sera affiché.</p>
        <p>Vous ne pouvez pas modifier une réservation pour une date appartenant au passé.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="navigating" id="navigating"></a>Se déplacer dans le planificateur.</h5>
        <p>Il y a plusieurs méthodes pour se déplacer dans le planificateur.</p>
        <p>Passer de semaine en semaine via &quot;Sem. préc.&quot; et &quot;Sem. Suiv.&quot; au bas de la 
           fenêtre du planificateur.</p>
        <p>Passer directement à n'importe quelle date en la composant dans les boites prévues au bas de la
       fenêtre du planificateur.</p>
        <p>Choisir une date dans le calendrier de navigation &quot;Visualisation du calendrier&quot; au
           bas de la fenêtre du planificateur, pour que ce dernier se positionne sur cette date.</p>
        <p align="right"><a href="#top">Top</a></p>
      </td>
    </tr>
  </table>
</div>