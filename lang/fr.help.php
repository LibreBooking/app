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
?><div align="center">
  <h3><a name="top" id="top"></a>Introduction � phpScheduleIt</h3>
  <p><a href="http://phpscheduleit.sourceforge.net" target="_blank">http://phpscheduleit.sourceforge.net</a></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: solid #CCCCCC 1px">
    <tr> 
      <td bgcolor="#FAFAFA"> 
        <ul>
          <li><b><a href="#getting_started">Pr�liminaires</a></b></li>
          <ul>
            <li><a href="#registering">Enregistrement</a></li>
            <li><a href="#logging_in">Connexion</a></li>
            <li><a href="#language">Choisir ma langue</a></li>
            <li><a href="#manage_profile">Modification des identifiants et du mot de passe</a></li>
            <li><a href="#resetting_password">R�-initialisation de votre mot de passe oubli�</a></li>
            <li><a href="#getting_support">Obtenir de l'aide</a></li>
          </ul>
          <li><a href="#my_control_panel"><b>Mon panneau de contr�le</b></a></li>
          <ul>
            <li><a href="#my_announcements">Mes annonces</a></li>
            <li><a href="#my_reservations">Mes r�servations</a></li>
            <li><a href="#my_training">Mes privil�ges</a></li>
            <li><a href="#quick_links">Mes liens rapides</a></li>
          </ul>
          <li><a href="#using_the_scheduler"><b>Utilisation du planificateur</b></a></li>
          <ul>
      <li><a href="#read_only">Version en lecture seule</a></li>
            <li><a href="#making_a_reservation">Effectuer une r�servation</a></li>
            <li><a href="#modifying_deleting_a_reservation">Modification/Effacement d'une r�servation</a></li>
            <li><a href="#navigating">Se d�placer dans le planificateur</a></li>
          </ul>
        </ul>
    <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="getting_started" id="getting_started"></a>Pr�liminaires</h4>
        <p>Afin d'utiliser phpScheduleIt, au pr�alable, vous devez vous enregistrer.
          Si vous etes d�j� enregistr�, alors vous devez vous connecter avant d'utiliser 
          le syst�me. En ent�te de chaque page (� l'exception des pages  d'enregistrement et de connexion)
          vous verrez un message de bienvenue, la date du jour, et quelques liens.
          -- un lien &quot;connexion&quot; et un lien &quot;Mon panneau de contr�le;
          sous le message de bienvenue, et un lien &quot;Help Me&quot; sous 
          la date.</p>
          <p>Si le nom d'un utilisateur pr�c�dent est affich� dans le message de bienvenue, click &quot;
          D�connexion&quot; pour effacer tout cookie pr�c�demment enregistr� et <a href="#logging_in">Connectez
          vous</a> sous votre nom. Cliquer sur &quot;Mon panneau de Contr�le&quot; vous
          am�nera � <a href="#my_control_panel">Mon panneau de contr�le</a>, votre &quot;page d'accueil
          &quot; dans le planificateur.
          Cliquer sur &quot;HelpMe&quot; fait appara�tre une fen�tre d'aide. Cliquer
          &quot;Envoi d'un message �lectronique � l'administrateur&quot; ouvre la messagerie sur la 
          r�daction d'un message adress� � l'administrateur.</p>
          <p><font color="#FF0000">Attention:</font> Si vous utilisez Norton Personal
            Firewal en m�me temps que phpScheduleIt, il est possible que vous rencontriez
            des difficult�s. S'il vous plait d�sactivez Norton Personal Firewal pendant 
            l'utilisation de phpScheduleIt et r�-activez le ensuite.</p>
          <p align="right"><a href="#top">Top</a></p>
        <h5><a name="registering" id="registering"></a>Enregistrement</h5>
        <p>Pour vous enregistrer, en premier lieu positionnez vous sur
          la page d'enregistrement. Elle peut �tre atteinte gr�ce � un lien sur la page
          d'accueil initiale. Vous devez renseigner tous les champs. L'adresse de messagerie
          que vous y indiquez sera votre identifiant de connexion. Les informations que vous 
          donnez peuvent, � tout moment, faire l'objet d'une modification � <a href="#quick_links">modifiez 
          vos identifiants</a>. Si vous s�lectionnez (cochez) l'option &quot;rendre ma connexion persistante
          &quot; sera utilis� un cookie pour vous identifier chaque fois que vous reviendrez sur 
          phpScheduleIt, sans qu'il ne vous soit n�cessaire de vous identifier � la connexion.<i>
          Vous ne devez utilisez cette option qu'� la condition d'�tre la seule personne � 
          utiliser phpScheduleIt sur l'ordinateur.</i> Apr�s vous �tre enregistr�, vous serez
          dirig� vers <a href="#my_control_panel">Mon panneau de contr�le</a>.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="logging_in" id="logging_in"></a>Connexion</h5>
        <p>La connexion se r�sume simplement � entrer votre adresse
          de messagerie et votre mot de passe. Vous devez avoir effectu� au pr�alable
          votre <a href="#registering">enregistrement</a> avant de pouvoir vous connecter.
          Ceci peut �tre effectu� en suivant (cliquant sur) le lien d'enregistrement figurant
          sur la page d'accueil. Si vous s�lectionnez (cochez) l'option &quot;rendre ma connexion persistante
          &quot; sera utilis� un cookie pour vous identifier chaque fois que vous reviendrez sur 
          phpScheduleIt, sans qu'il ne vous soit n�cessaire de vous identifier � la connexion.<i>
          Vous ne devez utilisez cette option qu'� la condition d'�tre la seule personne � 
          utiliser phpScheduleIt sur l'ordinateur.</i> Apr�s vous �tre enregistr�, vous serez
          dirig� vers <a href="#my_control_panel">Mon panneau de contr�le</a>.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="language" id="language"></a>Choisir ma langue</h5>
        <p>Sur la page d'accueil initiale figure une boite � choix
          multiple comportant toutes les langues disponibles sur le syst�me. Merci de bien vouloir
          choisir la langue que vous pr�f�rez, et, ainsi tous les textes de phpScheduleIt seront traduits dans
          cette langue. Cela ne traduira pas tout texte entr� par votre administrateur ou un quelconque 
          utilisateur ; cela ne traduira que les message du syst�me. Vous aurez � vous d�connecter pour 
          s�lectionner une autre langue.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="manage_profile" id="manage_profile"></a>Modification des identifiants et du mot de passe</h5>
        <p>Pour effectuer des modifications de vos identifiants (nom, adresse �lectronique, etc.)
          ou de votre mot de passe, premi�rement vous devez vous connecter au syst�me. Puis �
          <a href="#my_control_panel">Mon panneau de contr�le</a>, dans 
          <a href="#quick_links">Mes liens rapides</a>, cliquez 
          &quot;Modifier mes identifiants et/ou mon mot de passe&quot;. Cela vous pr�sentera
          un formulaire contenant toutes les informations vous concernant. Modifiez 
          toutes les information que vous souhaitez. Tout champ laiss� blanc ne sera pas pris en
          compte dans les modifications. Si vous souhaitez modifier votre mot de passe vous devrez 
          l'indiquer deux fois. Apr�s avoir modifi� vos informations,  cliquez &quot;Modification du profil&quot;
          , et ainsi, vos modifications seront prises en compte. Vous serez ensuite conduit de nouveau
          � Mon panneau de contr�le. </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="resetting_password" id="resetting_password"></a>R�-initialisation de votre mot de passe oubli�</h5>
        <p>Si vous avez oubli� votre mot de passe, vous avez la possibilit� de le faire annuler, 
          et de vous en faire adresser un nouveau par email. Pour cela, sur la page d'accueil initiale, cliquez
          sur &quot;J'ai oubli� mon mot de passe&quot; situ� sous le formulaire de connexion. Il vous sera 
          pr�sent� une page nouvelle dans laquelle vous serez invit� � indiquer votre adresse de messagerie.
          Apr�s avoir cliqu� sur le bouton &quot;Envoyer&quot;, un nouveau mot de passe g�n�r� de fa�on al�atoire
          sera cr��. Ce nouveau mot de passe sera plac� dans la base de donn�e et vous sera communiqu� par message
          �lectronique. A la r�ception de ce message �lectronique, merci de bien vouloir effectuer un copier/coller
          de ce mot de passe � <a href="#logging_in">Connexion</a>. Ensuite ne tardez pas � en changer la valeur
          � <a href="#manage_profile">Modifier mes caract�ristiques et/ou mon mot de passe  </a>.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="getting_support" id="getting_support"></a>Obtenir de l'aide</h5>
        <p>Si vous n'avez pas les privil�ges suffisants pour utiliser une ressource, si vous avez des questions
          � propos des ressources, des r�servations, ou de votre enregistrement, merci d'utiliser &quot;
          Envoi d'un message �lectronique � l'administrateur  &quot; situ� dans les liens rapides.</p>
        <p align="right"><a href="#top">Top</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="my_control_panel" id="my_control_panel"></a>Mon panneau de contr�le</h4>
        <p>Le panneau de contr�le est votre &quot;page d'accueil&quot;
          dans le syst�me de r�servation. C'est l� que vous pouvez passer en revue, modifier, ou annuler
          vos r�servations. Dans &quot;Mon panneau de contr�le&quot; figurent �galement les <a href="#quick_links">liens rapides</a>
          permettant d'acc�der &quot;Allez sur le planificateur en ligne&quot; 
          &quot;Modifier mes caract�ristiques et/ou mon mot de passe  &quot;
          &quot; Gestion de mes adresses �lectroniques pr�f�r�es  &quot;
          &quot;  Envoi d'un message �lectronique � l'administrateur  &quot;
          et une option pour &quot;Quitter&quot; le syst�me.  </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_announcements" id="my_announcements"></a>Mes annonces</h5>
        <p>Cette table contient tous les messages que l'administrateur juge important de faire passer.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_reservations" id="my_reservations"></a>Mes R�servations</h5>
        <p>Le tableau des r�servations pr�sente toute vos r�servations � venir en commen�ant par le jour m�me.
          Ce tableau indiquera chaque date de r�servation, nom de la ressource, Date/heure de cr�ation, 
          Date/heure de la derni�re modification, heure de d�but, heure de fin. Depuis ce tableau
          il vous est possible de modifier ou d'annuler une r�servation, simplement en cliquant sur 
          &quot;Modification&quot; ou &quot;Effacement&quot; � la fin de chaque ligne de r�servation. Ces deux 
          options ouvriront une fen�tre ou il vous sera demand� de confirmer votre choix. Cliquer sur la date
          de r�servation ouvrira une fen�tre dans laquelle seront visibles les caract�ristiques de la r�servation.</p>
         <p> Pour trier vos r�servations sur une colonne particuli�re, cliquer sur le signe &#150; ou le signe + dans 
         l'ent�te de chaque colonne. Le signe moins triera les r�servations en ordre d�croissant sur le texte contenu
         par la colonne, le signe plus en ordre croissant.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_training" id="my_training"></a>Mes privil�ges</h5>
        <p>Le tableau de &quot;Mes privil�ges&quot; pr�sente toutes les ressources qu'ils vous
          est possible de r�server. La liste comprend le nom de la ressource, son emplacement, et le num�ro de
          t�l�phone du responsable.</p>
         <p>Lors de l'enregistrement, il ne vous sera pas donn� la permission d'employer toutes les 
         ressources � moins que l'administrateur ait d�cid� d'accorder aux utilisateurs la permission 
         automatiquement.  L'administrateur est la seule personne qui peut vous donner la permission d'employer 
         une ressource.  Vous ne serez pas autoris�s � r�server une ressource pour laquelle il ne vous a pas �t� 
         donn� la permission, mais vous pourrez regarder son programme et ses r�servations en cours. </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="quick_links" id="quick_links"></a>Mes liens rapides</h5>
        <p>Le tableau des liens rapides contient les liens aux applications courantes.
          Le premier &quot;Allez sur le planificateur en ligne&quot; vous conduit au planificateur de ressource.
          Vous pourrez y consulter les planifications existantes, y r�server des ressources, et mettre � jour
          vos r�servations d�j� effectu�es.</p>
         <p>&quot;Modifier mes caract�ristiques et/ou mon mot de passe&quot; vous conduit � une page o� il vous 
          sera possible de modifier vos caract�ristiques telles que l'adresse de messagerie, le nom, le num�ro de 
          t�l�phone, et le mot de passe. Toutes ces informations figureront dans un formulaire, � partir duquel 
          vous pourrez les modifier, si vous remplacez une information par des blancs, cela �quivaudra � n'en pas 
          demander la modification.</p>
         <p>&quot;Gestion de mes adresses �lectroniques pr�f�r�es&quot; vous pr�sente une page sur laquelle vous
          pourrez choisir les type de messages �lectroniques que vous souhaitez recevoir du syst�me. Par d�faut, 
          vous recevez un message �lectronique au format HTML chaque fois que vous ajoutez, modifiez, annulez une 
          r�servation.</p>
         <p>&quot;Envoi d'un message �lectronique � l'administrateur&quot; Ouvre votre gestionnaire de messagerie
          sur la cr�ation d'un message � destination de l'administrateur du syst�me.
         <p>Le dernier lien &quot;Quitter&quot; vous permet de vous d�connecter du syst�me et de revenir � la 
          page d'accueil et de connexion initiale. </p>
        <p align="right"><a href="#top">Top</a></p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="using_the_scheduler" id="using_the_scheduler"></a>Utilisation du planificateur</h4>
        <p>Le planificateur est l'endroit o� vous pouvez effectuer toutes les fonctions relatives � la planification
          des ressources. La semaine affich�e commence par la semaine courante et les 7 (par d�faut) jours suivants.
          C'est l� que vous pouvez visualiser, reserver, modifier les ressources d�j� r�serv�es. Les r�servations
          sont distingu�es grace � des couleurs, ainsi toutes sont visibles, mais <i>seules les v�tres</i> seront
          accessibles via un lien (cliquable) pour �tre modifi�es. Toutes les autres r�servations ne pourront faire
          l'objet que d'une visualisation.</p>
        <p>Vous pouvez changer de planification (� la condition qu'il en existe plus
          d'une) en utilisant la liste de choix au d�but de chaque planification. </p>
        <p>L'administrateur du syst�me peut sp�cifier des plages horaires inaccessibles. Les r�servations ne seront
          pas possibles si elles entrent en conflit avec ces plages.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Version en Lecture Seule</h5>
        <p>Si vous n'etes pas encore enregistr�, ou connect�, il vous est possible de visualiser une version de la
          planification en lecture seule en cliquant sur &quot;Visualisation de planification&quot;. Cette 
          version montre toutes les planifications, mais ne permet pas d'en visualiser les d�tails, pas
          plus qu'elle ne permet d'effectuer des r�servations.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Effectuer une r�servation</h5>
        <p>Pour effectuer une r�servation, en premier lieu, positionnez vous dans le tableau
           sur le jour de d�but de r�servation. Un fois le jour localis� dans le tableau, cliquez sur
           le nom de la ressource. Dans une nouvelle fen�tre vous serez invit� � choisir la dur�e pendant
           laquelle vous souhaitez effectuer la r�servation. </p>
        <p>Vous y trouverez un message vous indiquant la dur�e minimale/maximale de la r�servation.
          Si la dur�e de votre r�servation est sup�rieure ou inf�rieure aux dur�es indiqu�es, la r�servation
          ne sera pas accept�e.</p>
        <p>Vous pouvez, si vous le d�sirez, choisir de r�p�ter cette r�servation. Pour ce faire,
          choisissez le jour pour lequel elle doit �tre r�p�t�e, puis choisissez la dur�e pendant laquelle
          vous souhaitez que soit r�alis�e la r�p�tition. La r�servation sera effectu�e pour le jour de d�part
          choisi, plus tous les jours correspondants au choix de r�p�tition. Toutes les dates pour lesquelles
          la r�servation n'aura pu �tre effectu�e du fait d'un conflit seront list�es. </p>
        <p>Vous pouvez ajouter un r�sum� de cette r�servation en remplissant la boite de texte r�sum�. Le r�sum�
          sera disponible � la lecture pour les autres utilisateurs.</p>
        <p>Apr�s avoir sp�cifi� des heures de d�but et de fin valides pour la r�servation voulue, apr�s avoir
          si n�cessaire sp�cifi� les param�tres de r�p�tition cliquez sur le bouton &quot;Sauvegarde&quot;.
          Une message vous sera envoy� si la r�servation n'a pu aboutir vous informant de la date pour laquelle
          la r�servation n'a pu avoir lieu. Dans ce cas il faut modifier la r�p�tition afin qu'il n'y ait plus
          de conflit. Apr�s que votre r�servation ait abouti, la planification est automatiquement r�-affich�e.</p>
        <p>Il ne vous est pas possible de r�server une ressource � une date appartenant au pass�, pour laquelle vous 
           n'avez pas les privil�ges, ou qui a �t� d�clar� inactive par l'administrateur. Ces ressources seront gris�es
           et ne seront pas accessibles.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="modifying_deleting_a_reservation" id="modifying_deleting_a_reservation"></a>Modification/Effacement 
        d'une r�servation</h5>
        <p>Vous avez plusieurs possibilit�s pour modifier, ou annuler une r�servation. L'une d'entre elles est � partir
           de <a href="#my_control_panel">Mon panneau de contr�le</a> comme d�crit ci-dessus. L'autre est via le
           Planificateur en Ligne. Ainsi que pr�c�demment indiqu�, vous n'avez acc�s en modification qu'� vos propres
           r�servations, celles des autres vous seront montr�es, mais vous seront inaccessibles.</p>
        <p>Pour modifier une r�servation via le planificateur, cliquer simplement
           sur la r�servation que vous souhaitez modifier. Cela ouvrira une fen�tre tr�s proche de la fen�tre de
           r�servation. Vous y aurez deux choix ; vous pouvez soit modifier les heures de d�but et/ou de fin ou
           cliquer sur le choix &quot;Effacement&quot;. Apr�s avoir effectuer vos modifications, cliquez sur le
           bouton &quot;Modifier&quot; � la fin du formulaire. Vos modifications seront �valu�es � nouveau afin
           d'en d�duire d'�ventuels conflits et un message appara�tra vous indiquant le r�sultat de votre requ�te.
           Si vous devez changer les horaires, retournez � la fen�tre de modifications. Apr�s que votre r�servation
           aura �t� modifi�e avec succ�s, la planification sera automatiquement r� affich�e. Ceci est n�cessaire
           pour que les nouvelles informations contenues par la base de donn�e soient r� affich�es. </p>
        <p>Pour modifier un groupe de r�servations r�p�titives, cochez le choix intitul� &quot;Modification de toutes
           les r�servations r�p�titives dans le groupe&quot; Tout conflit de date sera affich�.</p>
        <p>Vous ne pouvez pas modifier une r�servation pour une date appartenant au pass�.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="navigating" id="navigating"></a>Se d�placer dans le planificateur.</h5>
        <p>Il y a plusieurs m�thodes pour se d�placer dans le planificateur.</p>
        <p>Passer de semaine en semaine via &quot;Sem. pr�c.&quot; et &quot;Sem. Suiv.&quot; au bas de la 
           fen�tre du planificateur.</p>
        <p>Passer directement � n'importe quelle date en la composant dans les boites pr�vues au bas de la
       fen�tre du planificateur.</p>
        <p>Choisir une date dans le calendrier de navigation &quot;Visualisation du calendrier&quot; au
           bas de la fen�tre du planificateur, pour que ce dernier se positionne sur cette date.</p>
        <p align="right"><a href="#top">Top</a></p>
      </td>
    </tr>
  </table>
</div>