<?php
/**
Copyright 2011-2013 Nick Korbel

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
 */

require_once('Language.php');
require_once('en_us.php');

class it_it extends en_us
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _LoadDates()
    {
        $dates = parent::_LoadDates();

        $dates['general_date'] = 'd/m/Y';
        $dates['general_datetime'] = 'd/m/Y H:i:s';
        $dates['schedule_daily'] = 'l, d/m/Y';
        $dates['reservation_email'] = 'd/m/Y @ H:i (e)';
        $dates['res_popup'] = 'd/m/Y H:i ';
        $dates['dashboard'] = 'l, d/m/Y H:i';
        $dates['period_time'] = "H:i";
		$dates['general_date_js'] = "dd/mm/yy";

        $this->Dates = $dates;
    }

    protected function _LoadStrings()
    {
        $strings = parent::_LoadStrings();

        $strings['FirstName'] = 'Nome';
        $strings['LastName'] = 'Cognome';
        $strings['Timezone'] = 'Fuso Orario';
        $strings['Edit'] = 'Modifica';
        $strings['Change'] = 'Cambia';
        $strings['Rename'] = 'Rinomina';
        $strings['Remove'] = 'Rimuovi';
        $strings['Delete'] = 'Cancella';
        $strings['Update'] = 'Aggiorna';
        $strings['Cancel'] = 'Annulla';
        $strings['Add'] = 'Aggiungi';
        $strings['Name'] = 'Nome';
        $strings['Yes'] = 'Si';
        $strings['No'] = 'No';
        $strings['FirstNameRequired'] = 'Nome � obbligatorio.';
        $strings['LastNameRequired'] = 'Cognome &egrave obbligatorio.';
        $strings['PwMustMatch'] = 'Conferma Password deve corrispondere a Password.';
        $strings['PwComplexity'] = 'La Password deve essere minimo 6 caratteri con una combinazione di lettere, numeri e simboli.';
        $strings['ValidEmailRequired'] = 'E\' richiesto un indirizzo di email valido.';                                       
        $strings['UniqueEmailRequired'] = 'Questo indirizzo email &egrave gi&agrave; registrato.';
        $strings['UniqueUsernameRequired'] = 'Questo nome utente &egrave gi&agrave; registrato.';
        $strings['UserNameRequired'] = 'Nome Utente &egrave obbligatorio.';
        $strings['CaptchaMustMatch'] = 'Inserire le lettere dall\'immagine di sicurezza esattamente come mostrato.';
        $strings['Today'] = 'Oggi';
        $strings['Week'] = 'Settimana';
        $strings['Month'] = 'Mese';
        $strings['BackToCalendar'] = 'Indietro al calendario';
        $strings['BeginDate'] = 'Inizio';
        $strings['EndDate'] = 'Fine';
        $strings['Username'] = 'Username';
        $strings['Password'] = 'Password';
        $strings['PasswordConfirmation'] = 'Conferma Password';
        $strings['DefaultPage'] = 'Default Homepage';
        $strings['MyCalendar'] = 'Mio Calendario';
        $strings['ScheduleCalendar'] = 'Calendario Schedulazione';
        $strings['Registration'] = 'Registrazione';
        $strings['NoAnnouncements'] = 'Non ci sono annunci';
        $strings['Announcements'] = 'Annunci';
        $strings['NoUpcomingReservations'] = 'Non hai prenotazioni imminenti';
        $strings['UpcomingReservations'] = 'Prenotazioni imminenti';
        $strings['ShowHide'] = 'Mostra/Nascondi';
        $strings['Error'] = 'Errore';
        $strings['ReturnToPreviousPage'] = 'Ritorna all\'ultima pagine sulla quale ti trovavi';
        $strings['UnknownError'] = 'Errore Sconosciuto';
        $strings['InsufficientPermissionsError'] = 'Non hai i permessi per accedere a questa risorsa';
        $strings['MissingReservationResourceError'] = 'Non &egrave stata selezionata una Risorsa';
        $strings['MissingReservationScheduleError'] = 'Non &egrave stata selezionata una Schedulazione';
        $strings['DoesNotRepeat'] = 'Non ripetere';
        $strings['Daily'] = 'Giornaliera';
        $strings['Weekly'] = 'Settimanale';
        $strings['Monthly'] = 'Mensile';
        $strings['Yearly'] = 'Annuale';
        $strings['RepeatPrompt'] = 'Ripeti';
        $strings['hours'] = 'ore';
        $strings['days'] = 'giorni';
        $strings['weeks'] = 'settimane';
        $strings['months'] = 'mesi';
        $strings['years'] = 'anni';
        $strings['day'] = 'giorno';
        $strings['week'] = 'settimana';
        $strings['month'] = 'mese';
        $strings['year'] = 'anno';
        $strings['repeatDayOfMonth'] = 'giorno del mese';
        $strings['repeatDayOfWeek'] = 'giorno della settimana';
        $strings['RepeatUntilPrompt'] = 'Fino';
        $strings['RepeatEveryPrompt'] = 'Ogni';
        $strings['RepeatDaysPrompt'] = 'On';
        $strings['CreateReservationHeading'] = 'Crea una nuova prenotazione';
        $strings['EditReservationHeading'] = 'Modifica prenotazione %s';
        $strings['ViewReservationHeading'] = 'Visualizza prenotazione %s';
        $strings['ReservationErrors'] = 'Cambia Prenotazione';
        $strings['Create'] = 'Crea';
        $strings['ThisInstance'] = 'Solo questa Ripetizione';
        $strings['AllInstances'] = 'Tutte le Ripetizioni';
        $strings['FutureInstances'] = 'Ripetizioni Future';
        $strings['Print'] = 'Stampa';
        $strings['ShowHideNavigation'] = 'Mostra/Nascondi Navigazione';
        $strings['ReferenceNumber'] = 'Numero Riferimento';
        $strings['Tomorrow'] = 'Domani';
        $strings['LaterThisWeek'] = 'Fine di Questa Settimana';
        $strings['NextWeek'] = 'Prossima Settimana';
        $strings['SignOut'] = 'Esci';
        $strings['LayoutDescription'] = 'Inizia di %s, mostrando %s giorni alla volta';
        $strings['AllResources'] = 'Tutte le Risorse';
        $strings['TakeOffline'] = 'Non in linea';
        $strings['BringOnline'] = 'In linea';
        $strings['AddImage'] = 'Aggiungi immagine';
        $strings['NoImage'] = 'Nessuna immagine assegnata';
        $strings['Move'] = 'Muovi';
        $strings['AppearsOn'] = 'Appartiene a %s';
        $strings['Location'] = 'Posizione';
        $strings['NoLocationLabel'] = '(nessuna posizione impostata)';
        $strings['Contact'] = 'Contatto';
        $strings['NoContactLabel'] = '(nessuna informazione di contatto)';
        $strings['Description'] = 'Descrizione';
        $strings['NoDescriptionLabel'] = '(nessuna descrizione)';
        $strings['Notes'] = 'Note';
        $strings['NoNotesLabel'] = '(nessuna nota)';
        $strings['NoTitleLabel'] = '(nessun titolo)';
        $strings['UsageConfiguration'] = 'Utilizzo Configurazione';
        $strings['ChangeConfiguration'] = 'Cambia Configurazione';
        $strings['ResourceMinLength'] = 'Le prenotazioni devono durare almeno %s';
        $strings['ResourceMinLengthNone'] = 'Non &egrave prevista una durata minima di prenotazione';
        $strings['ResourceMaxLength'] = 'Le prenotazioni non possono durare pi&ugrave; di %s';
        $strings['ResourceMaxLengthNone'] = 'Non &egrave prevista una durata massima di prenotazione';
        $strings['ResourceRequiresApproval'] = 'La prenotazione deve essere approvata';
        $strings['ResourceRequiresApprovalNone'] = 'Le prenotazioni non richiedono approvazione';
        $strings['ResourcePermissionAutoGranted'] = 'Permessi concessi automaticamente';
        $strings['ResourcePermissionNotAutoGranted'] = 'Permessi NON concessi automaticamente';
        $strings['ResourceMinNotice'] = 'Le prenotazioni devono essere effettuate almeno %s prima dell\'inizio';
        $strings['ResourceMinNoticeNone'] = 'Le prenotazioni possono essere effettuate fino al momento attuale';
        $strings['ResourceMaxNotice'] = 'Le prenotazioni non devono terminare piu %s da ora';
        $strings['ResourceMaxNoticeNone'] = 'Le prenotazioni possono terminare in qualsiasi momento nel futuro';
        $strings['ResourceAllowMultiDay'] = 'Le prenotazioni possono essere effettuate su piu\' giorni';
        $strings['ResourceNotAllowMultiDay'] = 'Le prenotazioni non possono essere effettuate su piu\' giorni';
        $strings['ResourceCapacity'] = 'Questa risorsa ha una capacita\' di %s persone';
        $strings['ResourceCapacityNone'] = 'Questa risorsa ha capacita\' illimitata';
        $strings['AddNewResource'] = 'Aggiungi nuova risorsa';
        $strings['AddNewUser'] = 'Aggiungi nuovo utente';
        $strings['AddUser'] = 'Aggiungi utente';
        $strings['Schedule'] = 'Schedulazione';
        $strings['AddResource'] = 'Aggiungi Risorsa';
        $strings['Capacity'] = 'Capacita\'';
        $strings['Access'] = 'Accesso';
        $strings['Duration'] = 'Durata';
        $strings['Active'] = 'Attiva';
        $strings['Inactive'] = 'Inattiva';
        $strings['ResetPassword'] = 'Reset Password';
        $strings['LastLogin'] = 'Ultimo Login';
        $strings['Search'] = 'Cerca';
        $strings['ResourcePermissions'] = 'Permessi Risorsa';
        $strings['Reservations'] = 'Prenotazioni';
        $strings['Groups'] = 'Gruppi';
        $strings['ResetPassword'] = 'Reset Password';
        $strings['AllUsers'] = 'Tutti gli Utenti';
        $strings['AllGroups'] = 'Tutti i Gruppi';
        $strings['AllSchedules'] = 'Tutte le Schedulazioni';
        $strings['UsernameOrEmail'] = 'Username o Email';
        $strings['Members'] = 'Membri';
        $strings['QuickSlotCreation'] = 'Crea slots ogni %s minuti tra %s e %s';
        $strings['ApplyUpdatesTo'] = 'ApplicaAggiornamentiA';
        $strings['CancelParticipation'] = 'Cancella Partecipazione';
        $strings['Attending'] = 'Partecipa';
        $strings['QuotaConfiguration'] = 'In %s per %s utenti in %s sono limitati a %s %s per %s';
        $strings['reservations'] = 'prenotazioni';
        $strings['ChangeCalendar'] = 'Cambia Calendario';
        $strings['AddQuota'] = 'Aggiungi Quota';
        $strings['FindUser'] = 'Cerca Utente';
        $strings['Created'] = 'Creato';
        $strings['LastModified'] = 'Ultima Modifica';
        $strings['GroupName'] = 'Nome Gruppo';
        $strings['GroupMembers'] = 'Membri Gruppo';
        $strings['GroupRoles'] = 'Ruoli Gruppo';
        $strings['GroupAdmin'] = 'Amministratore Gruppo';
        $strings['Actions'] = 'Azioni';
        $strings['CurrentPassword'] = 'Password Attuale';
        $strings['NewPassword'] = 'Nuova Password';
        $strings['InvalidPassword'] = 'La password attuale e\' errata';
        $strings['PasswordChangedSuccessfully'] = 'Password modificata correttamente';
        $strings['SignedInAs'] = 'Loggato come';
        $strings['NotSignedIn'] = 'Non sei loggato';
        $strings['ReservationTitle'] = 'Titolo della prenotazione';
        $strings['ReservationDescription'] = 'Descrizione della prenotazione';
        $strings['ResourceList'] = 'Risorsa da riservare';
        $strings['Accessories'] = 'Accessori';
        $strings['Add'] = 'Aggiungi';
        $strings['ParticipantList'] = 'Partecipanti';
        $strings['InvitationList'] = 'Inviti';
        $strings['AccessoryName'] = 'Nome Accessorio';
        $strings['QuantityAvailable'] = 'Quantita\' disponibile';
        $strings['Resources'] = 'Risorse';
        $strings['Participants'] = 'Partecipanti';
        $strings['User'] = 'Utente';
        $strings['Resource'] = 'Risorsa';
        $strings['Status'] = 'Stato';
        $strings['Approve'] = 'Approva';
        $strings['Page'] = 'Pagina';
        $strings['Rows'] = 'Righe';
        $strings['Unlimited'] = 'Illimitata';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Indirizzo Email';
        $strings['Phone'] = 'Telefono';
        $strings['Organization'] = 'Organizzazione';
        $strings['Position'] = 'Posizione';
        $strings['Language'] = 'Lingua';
        $strings['Permissions'] = 'Permessi';
        $strings['Reset'] = 'Reset';
        $strings['FindGroup'] = 'Cerca Gruppo';
        $strings['Manage'] = 'Gestisci';
        $strings['None'] = 'Nessuno';
        $strings['AddToOutlook'] = 'Aggiungi a Outlook';
        $strings['Done'] = 'Fatto';
        $strings['RememberMe'] = 'Ricordami';
        $strings['FirstTimeUser?'] = 'Utente Nuovo?';
        $strings['CreateAnAccount'] = 'Crea un Account';
        $strings['ViewSchedule'] = 'Visualizza Schedulazione';
        $strings['ForgotMyPassword'] = 'Password Dimenticata';
        $strings['YouWillBeEmailedANewPassword'] = 'Ti verra\' inviata una password generata in modo randomico';
        $strings['Close'] = 'Chiudi';
        $strings['ExportToCSV'] = 'Esporta in CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Attendi';
        $strings['Login'] = 'Login';
        $strings['AdditionalInformation'] = 'Informazioni Addizionali';
        $strings['AllFieldsAreRequired'] = 'tutti i campi sono obbligatori';
        $strings['Optional'] = 'opzionale';
        $strings['YourProfileWasUpdated'] = 'Il tuo profilo e\' stato aggiornato';
        $strings['YourSettingsWereUpdated'] = 'I tuoi settaggi sono stati aggiornati';
        $strings['Register'] = 'Registra';
        $strings['SecurityCode'] = 'Codice Sicurezza';
        $strings['ReservationCreatedPreference'] = 'Quando creo una prenotazione o una prenotazione viene creata a mio nome';
        $strings['ReservationUpdatedPreference'] = 'Quando modifico una prenotazione o una prenotazione viene modificata a mio nome';
        $strings['ReservationDeletedPreference'] = 'Quando cancello una prenotazione o una prenotazione viene cancellata a mio nome';
        $strings['ReservationApprovalPreference'] = 'Quando la mia prenotazione pendente viene approvata';
        $strings['PreferenceSendEmail'] = 'Mandami una email';
        $strings['PreferenceNoEmail'] = 'Non avvisarmi';
        $strings['ReservationCreated'] = 'La tua prenotazione e\' stata creata!';
        $strings['ReservationUpdated'] = 'La tua prenotazione e\' stata creata aggiornata!';
        $strings['ReservationRemoved'] = 'La tua prenotazione e\' stata rimossa';
        $strings['YourReferenceNumber'] = 'Il tuo numero di riferimento e\' %s';
        $strings['UpdatingReservation'] = 'Aggiorno prenotazione';
        $strings['ChangeUser'] = 'Cambia Utente';
        $strings['MoreResources'] = 'Altre Risorse';
        $strings['ReservationLength'] = 'Lunghezza Prenotazione';
        $strings['ParticipantList'] = 'Lista Partecipanti';
        $strings['AddParticipants'] = 'Aggiungi Partecipanti';
        $strings['InviteOthers'] = 'Invita Altri';
        $strings['AddResources'] = 'Aggiungi Risorse';
        $strings['AddAccessories'] = 'Aggiungi Accessori';
        $strings['Accessory'] = 'Accessori';
        $strings['QuantityRequested'] = 'Quantita\' Richiesta';
        $strings['CreatingReservation'] = 'Creo Prenotazione';
        $strings['UpdatingReservation'] = 'Aggiorno Prenotazione';
        $strings['DeleteWarning'] = 'Questa azione e\' permanente e non recuperabile!';
        $strings['DeleteAccessoryWarning'] = 'Cancellando questo accessorio, verra\' rimosso da tutte le prenotazioni.';
        $strings['AddAccessory'] = 'Aggiungi accessorio';
        $strings['AddBlackout'] = 'Aggiungi Blackout';
        $strings['AllResourcesOn'] = 'Tutte le Risorse On';
        $strings['Reason'] = 'Motivo';
        $strings['BlackoutShowMe'] = 'Mostrami le prenotazioni in conflitto';
        $strings['BlackoutDeleteConflicts'] = 'Cancella le prenotazioni in conflitto';
        $strings['Filter'] = 'Filtra';
        $strings['Between'] = 'Tra';
        $strings['CreatedBy'] = 'Creato da';
        $strings['BlackoutCreated'] = 'Blackout Creato!';
        $strings['BlackoutNotCreated'] = 'Blackout non puo\' essere creato!';
        $strings['BlackoutConflicts'] = 'Ci sono Blackout in conflitto';
        $strings['ReservationConflicts'] = 'Ci sono momenti di prenotazioni in conflitto';
        $strings['UsersInGroup'] = 'Utenti in questo gruppo';
        $strings['Browse'] = 'Sfoglia';
        $strings['DeleteGroupWarning'] = 'Cancellando questo gruppo rimuovera\' tutti i permessi associati.  Gli Utenti in questo gruppo posso perdere l\'accesso alle risorse.';
        $strings['WhatRolesApplyToThisGroup'] = 'Quale ruolo applico a questo gruppo?';
        $strings['WhoCanManageThisGroup'] = 'Chi puo\' gestire questo gruppo?';
        $strings['AddGroup'] = 'Aggiungi Gruppo';
        $strings['AllQuotas'] = 'Tutte le Quote';
        $strings['QuotaReminder'] = 'Ricorda: Le quote vengono applicate in base al fuso orario calendario.';
        $strings['AllReservations'] = 'Tutte le prenotazioni';
        $strings['PendingReservations'] = 'Prenotazioni pendenti';
        $strings['Approving'] = 'Approvazione';
        $strings['MoveToSchedule'] = 'Sposta a schedulazione';
        $strings['DeleteResourceWarning'] = 'Cancellando questa risorsa cancellera\' tutti i dati, incluso';
        $strings['DeleteResourceWarningReservations'] = 'tutte le prenotazioni passate, correnti e future associate ad esso';
        $strings['DeleteResourceWarningPermissions'] = 'assegnazione di tutti i permessi';
        $strings['DeleteResourceWarningReassign'] = 'Riassegnare tutto ci&ograve; che non si desidera venga cancellato prima di procedere';
        $strings['ScheduleLayout'] = 'Layout (fuso orario %s)';
        $strings['ReservableTimeSlots'] = 'Time Slots Prenotabili';
        $strings['BlockedTimeSlots'] = 'Time Slots Bloccati';
        $strings['ThisIsTheDefaultSchedule'] = 'Questa e\' la schedulazione di default';
        $strings['DefaultScheduleCannotBeDeleted'] = 'La Schedulazione di default non puo\' essere cancellata';
        $strings['MakeDefault'] = 'Imposta Default';
        $strings['BringDown'] = 'Porta Giu\'';
        $strings['ChangeLayout'] = 'Cambia Layout';
        $strings['AddSchedule'] = 'Aggiungi Schedulazione';
        $strings['StartsOn'] = 'Inizia di';
        $strings['NumberOfDaysVisible'] = 'Numero di Giorni Visibili';
        $strings['UseSameLayoutAs'] = 'Usa lo stesso Layout di';
        $strings['Format'] = 'Formato';
        $strings['OptionalLabel'] = 'Etichetta Opzionale';
        $strings['LayoutInstructions'] = 'Inserisci uno slot per linea.  Gli Slots devono essere forniti per tutte le 24 ore del giorno iniziando e finendo alle 12:00 AM.';
        $strings['AddUser'] = 'Aggiungi Utente';
        $strings['UserPermissionInfo'] = 'L\'accesso attuale alla risorsa puo\' essere diverso a seconda del ruolo, permessi di gruppo, o settaggi d ipermessi esterni';
        $strings['DeleteUserWarning'] = 'Cancellando questo utente verranno rimossi tutte le sue prenotazioni correnti, future, e storiche.';
        $strings['AddAnnouncement'] = 'Aggiungi Annuncio';
        $strings['Announcement'] = 'Annuncio';
        $strings['Priority'] = 'Priorita\'';
        $strings['Reservable'] = 'Prenotabile';
        $strings['Unreservable'] = 'NON Prenotabile';
        $strings['Reserved'] = 'Prenotata';
        $strings['MyReservation'] = 'Le mie prenotazioni';
        $strings['Pending'] = 'Pendente';
        $strings['Past'] = 'Passato';
        $strings['Restricted'] = 'Ristretto';
        $strings['ViewAll'] = 'Vedi tutte';
        $strings['MoveResourcesAndReservations'] = 'Sposta risorse e prenotazioni a';
        $strings['TurnOffSubscription'] = 'Disabilita le sottoscrizioni del Calendario';
        $strings['TurnOnSubscription'] = 'Permetti Sottoscrizioni a questo Calendario';
        $strings['SubscribeToCalendar'] = 'Iscriviti a questo Calendario';
        $strings['SubscriptionsAreDisabled'] = 'L\'amministratore ha disabilitato le sottoscrizioni calendario';
        $strings['NoResourceAdministratorLabel'] = '(Nessun Amministratore Risorsa)';
        $strings['WhoCanManageThisResource'] = 'Chi puo\' gestire questa Risorsa?';
        $strings['ResourceAdministrator'] = 'Amministratore Risorsa';
        $strings['Private'] = 'Privato';
        $strings['Accept'] = 'Accetta';
        $strings['Decline'] = 'Rifiuta';
        $strings['ShowFullWeek'] = 'Mostra Intera Settimana';
        $strings['CustomAttributes'] = 'Attributi Personalizzati';
        $strings['AddAttribute'] = 'Aggiungi un Attributo';
        $strings['EditAttribute'] = 'Modifica un Attributo';
        $strings['DisplayLabel'] = 'Etichetta Visualizzata';
        $strings['Type'] = 'Tipo';
        $strings['Required'] = 'Obbligatorio';
        $strings['ValidationExpression'] = 'Espressione di Validazione';
        $strings['PossibleValues'] = 'Valori Possibili';
        $strings['SingleLineTextbox'] = 'Casella di testo singola';
        $strings['MultiLineTextbox'] = 'Casella di testo multipla';
        $strings['Checkbox'] = 'Checkbox';
        $strings['SelectList'] = 'Lista a tendina';
        $strings['CommaSeparated'] = 'comma separated';
        $strings['Category'] = 'Categoria';
        $strings['CategoryReservation'] = 'Prenotazione';
        $strings['CategoryGroup'] = 'Gruppo';
        $strings['SortOrder'] = 'Ordinamento';
        $strings['Title'] = 'Titolo';
        $strings['AdditionalAttributes'] = 'Attributi Addizionali';
        $strings['True'] = 'Vero';
        $strings['False'] = 'Falso';
		$strings['ForgotPasswordEmailSent'] = 'Una email e\' stata inviata all\'indirizzo fornito con le istruzioni per resettare la password';
		$strings['ActivationEmailSent'] = 'Riceverai presto una email di attivazione.';
		$strings['AccountActivationError'] = 'Scusa, non puoi attivare il tuo account.';
		$strings['Attachments'] = 'Allegati';
		$strings['AttachFile'] = 'File Allegato';
		$strings['Maximum'] = 'max';

        // Errors
        $strings['LoginError'] = 'Username o password errate';
        $strings['ReservationFailed'] = 'La tua prenotazione non puo\' essere fatta';
        $strings['MinNoticeError'] = 'Questa prenotazione necessita di preavviso. La prima data che pu&ograve; essere prenotata &egrave %s.';
        $strings['MaxNoticeError'] = 'Questa prenotazione non pu&ograve; essere fatta fino a questo punto nel futuro. L\'ultima data che pu&ograve; essere prenotata &egrave %s.';
        $strings['MinDurationError'] = 'La prenotazione deve durare almeno %s.';
        $strings['MaxDurationError'] = 'Questa prenotazione non pu&ograve; durare pi&ugrave; di %s.';
        $strings['ConflictingAccessoryDates'] = 'Non ci sono abbastanza dei seguenti accessori:';
        $strings['NoResourcePermission'] = 'Non hai i permessi per accedere a una o pi&ugrave; delle risorse richieste';
        $strings['ConflictingReservationDates'] = 'Ci sono prenotazioni contrastanti nelle seguenti date:';
        $strings['StartDateBeforeEndDateRule'] = 'La data di inizio deve essere antecedente alla data di fine';
        $strings['StartIsInPast'] = 'La data di inizio non puo\' essere nel passato';
        $strings['EmailDisabled'] = 'L\'amministratore ha disabilitato le notifiche via email';
        $strings['ValidLayoutRequired'] = 'Gli Slots devono essere indicati per tutte le 24 ore del giorno partendo e finendo alle 12:00 AM.';

        // Page Titles
        $strings['CreateReservation'] = 'Crea Prenotazione';
        $strings['EditReservation'] = 'Modifica Prenotazione';
        $strings['LogIn'] = 'Log In';
        $strings['ManageReservations'] = 'Prenotazioni';
        $strings['AwaitingActivation'] = 'Attesa Attivazione';
        $strings['PendingApproval'] = 'Approvazione Pendente';
        $strings['ManageSchedules'] = 'Schedulazioni';
        $strings['ManageResources'] = 'Risorse';
        $strings['ManageAccessories'] = 'Accessori';
        $strings['ManageUsers'] = 'Utenti';
        $strings['ManageGroups'] = 'Gruppi';
        $strings['ManageQuotas'] = 'Quote';
        $strings['ManageBlackouts'] = 'Blackout';
        $strings['MyDashboard'] = 'Mio Cruscotto';
        $strings['ServerSettings'] = 'Settaggi Server';
        $strings['Dashboard'] = 'Cruscotto';
        $strings['Help'] = 'Aiuto';
        $strings['Bookings'] = 'Prenotazioni';
        $strings['Schedule'] = 'Schedulazioni';
        $strings['Reservations'] = 'Prenotazioni';
        $strings['Account'] = 'Account';
        $strings['EditProfile'] = 'Modifica il Mio Profilo';
        $strings['FindAnOpening'] = 'Find An Opening';
        $strings['OpenInvitations'] = 'Inviti Aperti';
        $strings['MyCalendar'] = 'Mio Calendario';
        $strings['ResourceCalendar'] = 'Calendario Risorsa';
        $strings['Reservation'] = 'Nuova Prenotazione';
        $strings['Install'] = 'Installazione';
        $strings['ChangePassword'] = 'Cambia Password';
        $strings['MyAccount'] = 'Mio Account';
        $strings['Profile'] = 'Profilo';
        $strings['ApplicationManagement'] = 'Gestione Applicazione';
        $strings['ForgotPassword'] = 'Password Dimenticata';
        $strings['NotificationPreferences'] = 'Preferenze di Notifica';
        $strings['ManageAnnouncements'] = 'Annunci';
        //

        // Day representations
        $strings['DaySundaySingle'] = 'D';
        $strings['DayMondaySingle'] = 'L';
        $strings['DayTuesdaySingle'] = 'M';
        $strings['DayWednesdaySingle'] = 'M';
        $strings['DayThursdaySingle'] = 'G';
        $strings['DayFridaySingle'] = 'V';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'Dom';
        $strings['DayMondayAbbr'] = 'Lun';
        $strings['DayTuesdayAbbr'] = 'Mar';
        $strings['DayWednesdayAbbr'] = 'Mer';
        $strings['DayThursdayAbbr'] = 'Gio';
        $strings['DayFridayAbbr'] = 'Ven';
        $strings['DaySaturdayAbbr'] = 'Sab';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'La tua prenotazione e\' stata approvata';
        $strings['ReservationCreatedSubject'] = 'La tua prenotazione e\' stata creata';
        $strings['ReservationUpdatedSubject'] = 'La tua prenotazione e\' stata aggiornata';
        $strings['ReservationCreatedAdminSubject'] = 'Notifica: una prenotazione e\' stata creata';
        $strings['ReservationUpdatedAdminSubject'] = 'Notifica: una prenotazione e\' stata aggiornata';
        $strings['ParticipantAddedSubject'] = 'Notifica di partecipazione ad una prenotazione';
        $strings['InviteeAddedSubject'] = 'Invito a prenotazione';
        $strings['ResetPassword'] = 'Richiesta di reset Password';
        $strings['ForgotPasswordEmailSent'] = 'Una email e\' sta inviata all\'indirizzo fornito con le istruzioni per resettare la password';
        //

        $this->Strings = $strings;
    }

    protected function _LoadDays()
    {
         $days = parent::_LoadDays();

        /***
        DAY NAMES
        All of these arrays MUST start with Sunday as the first element
        and go through the seven day week, ending on Saturday
         ***/
        // The full day name
        $days['full'] = array('Domenica', 'Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato');
        // The three letter abbreviation
        $days['abbr'] = array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
        // The two letter abbreviation
        $days['two'] = array('Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa');
        // The one letter abbreviation
        $days['letter'] = array('D', 'L', 'M', 'M', 'G', 'V', 'S');

        $this->Days = $days;
    }

    protected function _LoadMonths()
    {
        $months = parent::_LoadMonths();

        /***
        MONTH NAMES
        All of these arrays MUST start with January as the first element
        and go through the twelve months of the year, ending on December
         ***/
        // The full month name
        $months['full'] = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
        // The three letter month name
        $months['abbr'] = array('Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic');

        $this->Months = $months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    protected function _GetHtmlLangCode()
    {
        return 'it';
    }
}

?>