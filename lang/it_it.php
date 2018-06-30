<?php
/**
 * Copyright 2011-2016 Nick Korbel
 *
 * Translation: 2014 Nicola Ruggero <nicola@nxnt.org>, Daniele Cordella <kordan@mclink.it>
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('Language.php');
require_once('en_gb.php');

class it_it extends en_gb
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return array
	 */
	protected function _LoadStrings()
	{
		$strings = parent::_LoadStrings();

		$strings['FirstName'] = 'Nome';
		$strings['LastName'] = 'Cognome';
		$strings['Timezone'] = 'Fuso orario';
		$strings['Edit'] = 'Modifica';
		$strings['Change'] = 'Cambia';
		$strings['Rename'] = 'Rinomina';
		$strings['Remove'] = 'Rimuovi';
		$strings['Delete'] = 'Elimina';
		$strings['Update'] = 'Aggiorna';
		$strings['Cancel'] = 'Annulla';
		$strings['Add'] = 'Aggiungi';
		$strings['Name'] = 'Nome';
		$strings['Yes'] = 'Sì';
		$strings['No'] = 'No';
		$strings['FirstNameRequired'] = 'Nome è obbligatorio.';
		$strings['LastNameRequired'] = 'Cognome è obbligatorio.';
		$strings['PwMustMatch'] = 'La password di conferma non corrisponde con la password inserita.';
		$strings['ValidEmailRequired'] = 'È richiesto un indirizzo email valido.';
		$strings['UniqueEmailRequired'] = 'Questo indirizzo email è già registrato.';
		$strings['UniqueUsernameRequired'] = 'Questo nome utente è già registrato.';
		$strings['UserNameRequired'] = 'Nome utente è obbligatorio.';
		$strings['CaptchaMustMatch'] = 'Inserire le lettere dall\'immagine di sicurezza esattamente come mostrato.';
		$strings['Today'] = 'Oggi';
		$strings['Week'] = 'Settimana';
		$strings['Month'] = 'Mese';
		$strings['BackToCalendar'] = 'Torna al calendario';
		$strings['BeginDate'] = 'Inizio';
		$strings['EndDate'] = 'Fine';
		$strings['Username'] = 'Nome utente';
		$strings['Password'] = 'Password';
		$strings['PasswordConfirmation'] = 'Conferma password';
		$strings['DefaultPage'] = 'Homepage predefinita';
		$strings['MyCalendar'] = 'Calendario personale';
		$strings['ScheduleCalendar'] = 'Calendario';
		$strings['Registration'] = 'Registrazione';
		$strings['NoAnnouncements'] = 'Non ci sono avvisi';
		$strings['Announcements'] = 'Avvisi';
		$strings['NoUpcomingReservations'] = 'Non hai prenotazioni imminenti';
		$strings['UpcomingReservations'] = 'Le tue prenotazioni imminenti';
		$strings['AllNoUpcomingReservations'] = 'Non ci sono prenotazioni imminenti';
		$strings['AllUpcomingReservations'] = 'Tutte le prenotazioni imminenti';
		$strings['ShowHide'] = 'Mostra/Nascondi';
		$strings['Error'] = 'Errore';
		$strings['ReturnToPreviousPage'] = 'Torna all\'ultima pagina sulla quale ti trovavi';
		$strings['UnknownError'] = 'Errore Sconosciuto';
		$strings['InsufficientPermissionsError'] = 'Non hai i permessi per accedere a questa risorsa';
		$strings['MissingReservationResourceError'] = 'Non è stata selezionata una risorsa';
		$strings['MissingReservationScheduleError'] = 'Non è stata selezionato un calendario';
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
		$strings['RepeatDaysPrompt'] = 'il';
		$strings['CreateReservationHeading'] = 'Crea una nuova prenotazione';
		$strings['EditReservationHeading'] = 'Modifica prenotazione %s';
		$strings['ViewReservationHeading'] = 'Visualizza prenotazione %s';
		$strings['ReservationErrors'] = 'Modifica la prenotazione';
		$strings['Create'] = 'Crea';
		$strings['ThisInstance'] = 'Solo questa ripetizione';
		$strings['AllInstances'] = 'Tutte le ripetizioni';
		$strings['FutureInstances'] = 'Ripetizioni future';
		$strings['Print'] = 'Stampa';
		$strings['ShowHideNavigation'] = 'Mostra/Nascondi navigazione';
		$strings['ReferenceNumber'] = 'Numero riferimento';
		$strings['Tomorrow'] = 'Domani';
		$strings['LaterThisWeek'] = 'Questo fine settimana';
		$strings['NextWeek'] = 'Prossima settimana';
		$strings['SignOut'] = 'Disconnetti';
		$strings['LayoutDescription'] = 'Inizia di %s, mostrando %s giorni alla volta';
		$strings['AllResources'] = 'Tutte le risorse';
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
		$strings['NoTitleLabel'] = '(nessuna nota)';
		$strings['UsageConfiguration'] = 'Configurazione Utilizzo';
		$strings['ChangeConfiguration'] = 'Cambia configurazione';
		$strings['ResourceMinLength'] = 'Le prenotazioni devono durare almeno %s';
		$strings['ResourceMinLengthNone'] = 'Non è prevista una durata minima della prenotazione';
		$strings['ResourceMaxLength'] = 'Le prenotazioni non possono durare più di %s';
		$strings['ResourceMaxLengthNone'] = 'Non è prevista una durata massima della prenotazione';
		$strings['ResourceRequiresApproval'] = 'Le prenotazioni devono essere approvate';
		$strings['ResourceRequiresApprovalNone'] = 'Le prenotazioni non richiedono approvazione';
		$strings['ResourcePermissionAutoGranted'] = 'Automatica disponibilità immediata';
		$strings['ResourcePermissionNotAutoGranted'] = 'Disponibilità NON concessa automaticamente';
		$strings['ResourceMinNotice'] = 'Le prenotazioni devono essere effettuate almeno %s prima dell\'inizio';
		$strings['ResourceMinNoticeNone'] = 'Le prenotazioni possono essere effettuate fino al momento attuale';
		$strings['ResourceMaxNotice'] = 'Le prenotazioni non devono terminare più %s da ora';
		$strings['ResourceMaxNoticeNone'] = 'Le prenotazioni possono terminare in qualsiasi momento nel futuro';
		$strings['ResourceBufferTime'] = 'Ci devono essere %s tra le prenotazioni';
		$strings['ResourceBufferTimeNone'] = 'Non ci sono vincoli temporali tra le prenotazioni';
		$strings['ResourceAllowMultiDay'] = 'Le prenotazioni possono essere effettuate su più giorni';
		$strings['ResourceNotAllowMultiDay'] = 'Le prenotazioni non possono essere effettuate su più giorni';
		$strings['ResourceCapacity'] = 'Questa risorsa ha una capacità di %s persone';
		$strings['ResourceCapacityNone'] = 'Questa risorsa ha capacità illimitata';
		$strings['AddNewResource'] = 'Aggiungi nuova risorsa';
		$strings['AddNewUser'] = 'Aggiungi nuovo utente';
		$strings['AddResource'] = 'Aggiungi risorsa';
		$strings['Capacity'] = 'Capacità';
		$strings['Access'] = 'Accesso';
		$strings['Duration'] = 'Durata';
		$strings['Active'] = 'Attivo';
		$strings['Inactive'] = 'Inattivo';
		$strings['ResetPassword'] = 'Reimposta password';
		$strings['LastLogin'] = 'Ultimo accesso';
		$strings['Search'] = 'Cerca';
		$strings['ResourcePermissions'] = 'Permessi risorsa';
		$strings['Reservations'] = 'Prenotazioni';
		$strings['Groups'] = 'Gruppi';
		$strings['Users'] = 'Utenti';
		$strings['AllUsers'] = 'Tutti gli utenti';
		$strings['AllGroups'] = 'Tutti i gruppi';
		$strings['AllSchedules'] = 'Tutti i calendari';
		$strings['UsernameOrEmail'] = 'Nome utente oppure email';
		$strings['Members'] = 'Componenti';
		$strings['QuickSlotCreation'] = 'Crea fasce orarie ogni %s minuti tra %s e %s';
		$strings['ApplyUpdatesTo'] = 'Applica aggiornamenti a';
		$strings['CancelParticipation'] = 'Annulla partecipazione';
		$strings['Attending'] = 'Partecipa';
		$strings['QuotaConfiguration'] = 'In %s per %s utenti in %s sono limitati a %s %s per %s';
		$strings['QuotaEnforcement'] = 'Rinforzo %s %s';
		$strings['reservations'] = 'prenotazioni';
		$strings['reservation'] = 'prenotazione';
		$strings['ChangeCalendar'] = 'Cambia calendario';
		$strings['AddQuota'] = 'Aggiungi quota';
		$strings['FindUser'] = 'Cerca utente';
		$strings['Created'] = 'Creato';
		$strings['LastModified'] = 'Ultima modifica';
		$strings['GroupName'] = 'Nome gruppo';
		$strings['GroupMembers'] = 'Componenti gruppo';
		$strings['GroupRoles'] = 'Ruoli gruppo';
		$strings['GroupAdmin'] = 'Amministratore gruppo';
		$strings['Actions'] = 'Azioni';
		$strings['CurrentPassword'] = 'Password attuale';
		$strings['NewPassword'] = 'Nuova password';
		$strings['InvalidPassword'] = 'La password attuale è errata';
		$strings['PasswordChangedSuccessfully'] = 'Password modificata correttamente';
		$strings['SignedInAs'] = 'Collegato come';
		$strings['NotSignedIn'] = 'Non sei collegato';
		$strings['ReservationTitle'] = 'Titolo evento';
		$strings['ReservationDescription'] = 'Descrizione prenotazione';
		$strings['ResourceList'] = 'Risorsa relativa:';
		$strings['Accessories'] = 'Accessori';
		$strings['InvitationList'] = 'Inviti';
		$strings['AccessoryName'] = 'Nome accessorio';
		$strings['QuantityAvailable'] = 'Quantità disponibile';
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
		$strings['EmailAddress'] = 'Indirizzo email';
		$strings['Phone'] = 'Telefono';
		$strings['Organization'] = 'Dipartimento';
		$strings['Position'] = 'Titolo';
		$strings['Language'] = 'Lingua';
		$strings['Permissions'] = 'Permessi';
		$strings['Reset'] = 'Azzera';
		$strings['FindGroup'] = 'Cerca gruppo';
		$strings['Manage'] = 'Gestisci';
		$strings['None'] = 'Nulla';
		$strings['AddToOutlook'] = 'Aggiungi ad Outlook';
		$strings['Done'] = 'Fatto';
		$strings['RememberMe'] = 'Ricordami';
		$strings['FirstTimeUser?'] = 'Nuovo utente?';
		$strings['CreateAnAccount'] = 'Crea un account';
		$strings['ViewSchedule'] = 'Visualizza calendario';
		$strings['ForgotMyPassword'] = 'Password dimenticata';
		$strings['YouWillBeEmailedANewPassword'] = 'Ti verrà inviata una password generata in modo casuale';
		$strings['Close'] = 'Chiudi';
		$strings['ExportToCSV'] = 'Esporta in CSV';
		$strings['OK'] = 'OK';
		$strings['Working'] = 'Elaborazione in corso...';
		$strings['Login'] = 'Accesso';
		$strings['AdditionalInformation'] = 'Informazioni aggiuntive';
		$strings['AllFieldsAreRequired'] = 'tutti i campi sono obbligatori';
		$strings['Optional'] = 'opzionale';
		$strings['YourProfileWasUpdated'] = 'Il tuo profilo è stato aggiornato';
		$strings['YourSettingsWereUpdated'] = 'Le tue impostazioni sono state aggiornate';
		$strings['Register'] = 'Registra';
		$strings['SecurityCode'] = 'Codice sicurezza';
		$strings['ReservationCreatedPreference'] = 'Quando creo una prenotazione o una prenotazione viene creata a mio nome';
		$strings['ReservationUpdatedPreference'] = 'Quando modifico una prenotazione o una prenotazione viene modificata a mio nome';
		$strings['ReservationDeletedPreference'] = 'Quando elimino una prenotazione o una prenotazione viene eliminata a mio nome';
		$strings['ReservationApprovalPreference'] = 'Quando la mia prenotazione in sospeso viene approvata';
		$strings['PreferenceSendEmail'] = 'Mandami una email';
		$strings['PreferenceNoEmail'] = 'Non avvisarmi';
		$strings['ReservationCreated'] = 'La tua richiesta è stata inoltrata';
		$strings['ReservationUpdated'] = 'La tua richiesta è stata aggiornata';
		$strings['ReservationRemoved'] = 'La tua richiesta è stata rimossa';
		$strings['ReservationRequiresApproval'] = 'Attenzione: Questa prenotazione deve essere confermata con una email da parte di un responsabile dell\'Unità Operativa coinvolta per poter essere, eventualmente, confermata.';
		$strings['YourReferenceNumber'] = 'Il tuo numero di riferimento è %s';
		$strings['ChangeUser'] = 'Cambia utente';
		$strings['MoreResources'] = 'Altre risorse';
		$strings['ReservationLength'] = 'Lunghezza prenotazione';
		$strings['ParticipantList'] = 'Lista partecipanti';
		$strings['AddParticipants'] = 'Aggiungi partecipanti';
		$strings['InviteOthers'] = 'Invita altri';
		$strings['AddResources'] = 'Aggiungi risorse';
		$strings['AddAccessories'] = 'Aggiungi accessori';
		$strings['Accessory'] = 'Accessori';
		$strings['QuantityRequested'] = 'Quantità richiesta';
		$strings['CreatingReservation'] = 'Creazione della richiesta di prenotazione';
		$strings['UpdatingReservation'] = 'Aggiornamento prenotazione';
		$strings['DeleteWarning'] = 'Questa azione è permanente e non recuperabile!';
		$strings['DeleteAccessoryWarning'] = 'Eliminando questo accessorio, verrà rimosso da tutte le prenotazioni.';
		$strings['AddAccessory'] = 'Aggiungi accessorio';
		$strings['AddBlackout'] = 'Aggiungi Fuori-servizio';
		$strings['AllResourcesOn'] = 'Tutte le risorse attive';
		$strings['Reason'] = 'Motivo';
		$strings['BlackoutShowMe'] = 'Mostra prenotazioni in conflitto';
		$strings['BlackoutDeleteConflicts'] = 'Elimina le prenotazioni in conflitto';
		$strings['Filter'] = 'Filtra';
		$strings['Between'] = 'Tra';
		$strings['CreatedBy'] = 'Creato da';
		$strings['BlackoutCreated'] = 'Fuori-servizio creato';
		$strings['BlackoutNotCreated'] = 'Impossibile creare il fuori-servizio';
		$strings['BlackoutUpdated'] = 'Fuori-servizio aggiornato';
		$strings['BlackoutNotUpdated'] = 'Impossibile aggiornare il fuori-servizio';
		$strings['BlackoutConflicts'] = 'Ci sono fuori-servizio in conflitto';
		$strings['ReservationConflicts'] = 'Ci sono prenotazioni in conflitto';
		$strings['UsersInGroup'] = 'Utenti in questo gruppo';
		$strings['Browse'] = 'Sfoglia';
		$strings['DeleteGroupWarning'] = 'Eliminando questo gruppo rimuoverai tutti i permessi associati. Gli utenti in questo gruppo posso perdere l\'accesso alle risorse.';
		$strings['WhatRolesApplyToThisGroup'] = 'Quale ruolo applico a questo gruppo?';
		$strings['WhoCanManageThisGroup'] = 'Chi può gestire questo gruppo?';
		$strings['WhoCanManageThisSchedule'] = 'Chi può gestire questo calendario?';
		$strings['AllQuotas'] = 'Tutte le quote';
		$strings['QuotaReminder'] = 'Ricorda: le quote vengono applicate in base al fuso orario.';
		$strings['AllReservations'] = 'Tutti le prenotazioni';
		$strings['PendingReservations'] = 'Prenotazioni in sospeso';
		$strings['Approving'] = 'Approvazione';
		$strings['MoveToSchedule'] = 'Sposta nel calendario';
		$strings['DeleteResourceWarning'] = 'Eliminando questa risorsa cancellerai tutti i dati, incluso';
		$strings['DeleteResourceWarningReservations'] = 'tutti le prenotazioni passate, correnti e future associate ad essa';
		$strings['DeleteResourceWarningPermissions'] = 'assegnazione di tutti i permessi';
		$strings['DeleteResourceWarningReassign'] = 'Riassegnare tutto ciò che non vuoi venga eliminato prima di procedere';
		$strings['ScheduleLayout'] = 'Layout (fuso orario %s)';
		$strings['ReservableTimeSlots'] = 'Fasce orarie assegnabili';
		$strings['BlockedTimeSlots'] = 'Fasce orarie bloccate';
		$strings['ThisIsTheDefaultSchedule'] = 'Questo è il calendario predefinito';
		$strings['DefaultScheduleCannotBeDeleted'] = 'Il calendario predefinito non può essere eliminato';
		$strings['MakeDefault'] = 'Imposta predefinita';
		$strings['BringDown'] = 'Porta Giù';
		$strings['ChangeLayout'] = 'Cambia layout';
		$strings['AddSchedule'] = 'Aggiungi calendario';
		$strings['StartsOn'] = 'Inizia di';
		$strings['NumberOfDaysVisible'] = 'Numero di giorni visibili';
		$strings['UseSameLayoutAs'] = 'Usa lo stesso layout di';
		$strings['Format'] = 'Formato';
		$strings['OptionalLabel'] = 'Etichetta opzionale';
		$strings['LayoutInstructions'] = 'Inserisci una fascia oraria per riga. L\'insieme delle fasce orarie deve coprire tutte le 24 ore del giorno iniziando e finendo alle 00:00.';
		$strings['AddUser'] = 'Aggiungi utente';
		$strings['UserPermissionInfo'] = 'L\'accesso attuale alla risorsa può essere diverso a seconda del ruolo, permessi di gruppo, o impostazioni di permessi esterni';
		$strings['DeleteUserWarning'] = 'Eliminando questo utente verranno rimosse tutte le sue prenotazioni correnti, future, e storiche.';
		$strings['AddAnnouncement'] = 'Aggiungi avviso';
		$strings['Announcement'] = 'Avviso';
		$strings['Priority'] = 'Priorità';
		$strings['Reservable'] = 'Prenotabile';
		$strings['Unreservable'] = 'NON prenotabile';
		$strings['Reserved'] = 'Prenotato';
		$strings['MyReservation'] = 'Mie prenotazioni';
		$strings['Pending'] = 'In sospeso';
		$strings['Past'] = 'Passato';
		$strings['Restricted'] = 'Ristretto';
		$strings['ViewAll'] = 'Vedi tutte';
		$strings['MoveResourcesAndReservations'] = 'Sposta risorse e prenotazioni a';
		$strings['TurnOffSubscription'] = 'Disabilita le sottoscrizione';
		$strings['TurnOnSubscription'] = 'Abilita le sottoscrizione';
		$strings['SubscribeToCalendar'] = 'Apri una sottoscrizione';
		$strings['SubscriptionsAreDisabled'] = 'L\'amministratore ha disabilitato le sottoscrizioni';
		$strings['NoResourceAdministratorLabel'] = '(Nessun amministratore della risorsa)';
		$strings['WhoCanManageThisResource'] = 'Chi può gestire questa risorsa?';
		$strings['ResourceAdministrator'] = 'Amministratore risorsa';
		$strings['Private'] = 'Privato';
		$strings['Accept'] = 'Accetta';
		$strings['Decline'] = 'Rifiuta';
		$strings['ShowFullWeek'] = 'Mostra settimana intera';
		$strings['CustomAttributes'] = 'Attributi personalizzati';
		$strings['AddAttribute'] = 'Aggiungi un attributo';
		$strings['EditAttribute'] = 'Modifica un attributo';
		$strings['DisplayLabel'] = 'Etichetta visualizzata';
		$strings['Type'] = 'Tipo';
		$strings['Required'] = 'Obbligatorio';
		$strings['ValidationExpression'] = 'Espressione di convalida';
		$strings['PossibleValues'] = 'Valori possibili';
		$strings['SingleLineTextbox'] = 'Casella di testo singola';
		$strings['MultiLineTextbox'] = 'Casella di testo multipla';
		$strings['Checkbox'] = 'Casella di spunta';
		$strings['SelectList'] = 'Lista a tendina';
		$strings['CommaSeparated'] = 'separato da virgola';
		$strings['Category'] = 'Categoria';
		$strings['CategoryReservation'] = 'Prenotazione';
		$strings['CategoryGroup'] = 'Gruppo';
		$strings['SortOrder'] = 'Ordinamento';
		$strings['Title'] = 'Note';
		$strings['AdditionalAttributes'] = 'Attributi aggiuntivi';
		$strings['True'] = 'Vero';
		$strings['False'] = 'Falso';
		$strings['ForgotPasswordEmailSent'] = 'Una email è stata inviata all\'indirizzo fornito con le istruzioni per reimpostare la password';
		$strings['ActivationEmailSent'] = 'Riceverai presto una email di attivazione.';
		$strings['AccountActivationError'] = 'Spiacente, non puoi attivare il tuo account.';
		$strings['Attachments'] = 'Allegati';
		$strings['AttachFile'] = 'File Allegato';
		$strings['Maximum'] = 'max';
		$strings['NoScheduleAdministratorLabel'] = 'Nessun amministratore';
		$strings['ScheduleAdministrator'] = 'Amministratore calendario';
		$strings['Total'] = 'Totale';
		$strings['QuantityReserved'] = 'Quantità assegnata';
		$strings['AllAccessories'] = 'Tutti gli accessori';
		$strings['GetReport'] = 'Crea report';
		$strings['NoResultsFound'] = 'Nessun risultato';
		$strings['SaveThisReport'] = 'Salva questo report';
		$strings['ReportSaved'] = 'Report salvato';
		$strings['EmailReport'] = 'Invia report';
		$strings['ReportSent'] = 'Report inviato';
		$strings['RunReport'] = 'Esegui report';
		$strings['NoSavedReports'] = 'Non hai report salvati.';
		$strings['CurrentWeek'] = 'Settimana corrente';
		$strings['CurrentMonth'] = 'Mese corrente';
		$strings['AllTime'] = 'Tutti gli orari';
		$strings['FilterBy'] = 'Filtra per';
		$strings['Select'] = 'Seleziona';
		$strings['List'] = 'Lista';
		$strings['TotalTime'] = 'Tempo totale';
		$strings['Count'] = 'Conteggio';
		$strings['Usage'] = 'Uso';
		$strings['AggregateBy'] = 'Aggregato per';
		$strings['Range'] = 'Intervallo';
		$strings['Choose'] = 'Scegli';
		$strings['All'] = 'Tutto';
		$strings['ViewAsChart'] = 'Visualizza come grafico';
		$strings['ReservedResources'] = 'Prenotazioni per risorsa';
		$strings['ReservedAccessories'] = 'Accessori assegnati';
		$strings['ResourceUsageTimeBooked'] = 'Copertura risorse - orario prenotazioni';
		$strings['ResourceUsageReservationCount'] = 'Copertura risorse - conteggio prenotazioni';
		$strings['Top20UsersTimeBooked'] = 'Top 20 utenti - orario prenotazioni';
		$strings['Top20UsersReservationCount'] = 'Top 20 utenti - conteggio prenotazioni';
		$strings['ConfigurationUpdated'] = 'Il file di configurazione è stato aggiornato';
		$strings['ConfigurationUiNotEnabled'] = 'Questa pagnia non può essere acceduta perché $conf[\'settings\'][\'pages\'][\'enable.configuration\'] è impostata a false oppure è mancante.';
		$strings['ConfigurationFileNotWritable'] = 'Il file di configurazione non è scrivibile. Verifica i permessi del file e riprova.';
		$strings['ConfigurationUpdateHelp'] = 'Vedi la sezione Configurazione del <a target=_blank href=%s>Manuale</a> per ulteriori dettagli su queste impostazioni.';
		$strings['GeneralConfigSettings'] = 'impostazioni';
		$strings['UseSameLayoutForAllDays'] = 'Usa lo stesso layout per tutti i giorni';
		$strings['LayoutVariesByDay'] = 'Il layout è diverso per ogni giorno';
		$strings['ManageReminders'] = 'Promemoria';
		$strings['ReminderUser'] = 'User ID';
		$strings['ReminderMessage'] = 'Messaggio';
		$strings['ReminderAddress'] = 'Indirizzi';
		$strings['ReminderSendtime'] = 'Orario di invio';
		$strings['ReminderRefNumber'] = 'Numero di riferimento prenotazione';
		$strings['ReminderSendtimeDate'] = 'Giorno del promemoria';
		$strings['ReminderSendtimeTime'] = 'Ora del promemoria (HH:MM)';
		$strings['ReminderSendtimeAMPM'] = 'AM / PM';
		$strings['AddReminder'] = 'Aggiungi promemoria';
        $strings['DeleteReminderWarning'] = 'Sei sicuro?';
        $strings['NoReminders'] = 'Non ci sono promemoria imminenti.';
		$strings['Reminders'] = 'Promemoria';
		$strings['SendReminder'] = 'Invia promemoria';
		$strings['minutes'] = 'minuti';
		$strings['hours'] = 'ore';
		$strings['days'] = 'giorni';
		$strings['ReminderBeforeStart'] = 'prima dell\'orario di inizio';
		$strings['ReminderBeforeEnd'] = 'prima dell\'orario di fine';
		$strings['Logo'] = 'Logo';
		$strings['CssFile'] = 'File CSS';
		$strings['ThemeUploadSuccess'] = 'Le modifiche sono state salvate. Aggiorna la pagina per rendere le modifiche effettive.';
		$strings['MakeDefaultSchedule'] = 'Rendi questo calendario quello predefinito';
		$strings['DefaultScheduleSet'] = 'Adesso questo calendario è quello predefinito';
		$strings['FlipSchedule'] = 'Rovescia visualizzazione prenotazioni';
		$strings['Next'] = 'Successivo';
		$strings['Success'] = 'Eseguito correttamente';
		$strings['Participant'] = 'Invitato';
		$strings['ResourceFilter'] = 'Filtro risorsa';
		$strings['ResourceGroups'] = 'Filtro gruppi';
		$strings['AddNewGroup'] = 'Aggiungi nuovo gruppo';
		$strings['Quit'] = 'Esci';
		$strings['AddGroup'] = 'Aggiungi gruppo';
		$strings['StandardScheduleDisplay'] = 'Visualizzazione standard';
		$strings['TallScheduleDisplay'] = 'Visualizzazione allungata';
		$strings['WideScheduleDisplay'] = 'Visualizzazione allargata';
		$strings['CondensedWeekScheduleDisplay'] = 'Visualizzazione settimana condensata';
		$strings['ResourceGroupHelp1'] = 'Trascina i gruppi di risorse per riorganizzare.';
		$strings['ResourceGroupHelp2'] = 'Fai clic con il pulsante destro sul nome del gruppo di risorse per ulteriori azioni.';
		$strings['ResourceGroupHelp3'] = 'Trascina le risorse per aggiungerle ai gruppi.';
		$strings['ResourceGroupWarning'] = 'Se usi i gruppi di risorse, ogni risorsa deve essere assegnata ad almeno un gruppo. Le risorse non assegnate non possono essere utilizzate nelle prenotazioni.';
		$strings['ResourceType'] = 'Tipo risorsa';
		$strings['AppliesTo'] = 'Si applica a';
		$strings['UniquePerInstance'] = 'Unico per istanza';
		$strings['AddResourceType'] = 'Aggiungi tipo risorsa';
		$strings['NoResourceTypeLabel'] = '(nessun tipo risorsa impostato)';
		$strings['ClearFilter'] = 'Pulisci filtro';
		$strings['MinimumCapacity'] = 'Capacità minima';
		$strings['Color'] = 'Colore';
		$strings['Available'] = 'Disponibile';
		$strings['Unavailable'] = 'Non disponibile';
		$strings['Hidden'] = 'Nascosta';
		$strings['ResourceStatus'] = 'Stato risorsa';
		$strings['CurrentStatus'] = 'Stato attuale';
		$strings['AllReservationResources'] = 'Tutte le risorse delle prenotazioni';
		$strings['File'] = 'File';
		$strings['BulkResourceUpdate'] = 'Aggiornamento combinato risorsa';
		$strings['Unchanged'] = 'Non modificato';
		$strings['Common'] = 'Generale';
		$strings['AdminOnly'] = 'Solo per gli amministratori';
		$strings['AdvancedFilter'] = 'Filtro avanzato';
		$strings['MinimumQuantity'] = 'Minima quantità';
		$strings['MaximumQuantity'] = 'Massima quantità';
		$strings['ChangeLanguage'] = 'Cambia lingua';
		$strings['AddRule'] = 'Aggiungi ruolo';
		$strings['Attribute'] = 'Attributi';
		$strings['RequiredValue'] = 'Obbligatori';
		$strings['ReservationCustomRuleAdd'] = 'Se %s allora la prenotazione apparirà in';
		$strings['AddReservationColorRule'] = 'Aggiungi un colore di ruolo per la prenotazione';
		$strings['LimitAttributeScope'] = 'Limitata l\'attributo a...';
		$strings['CollectFor'] = 'Limitato a';
		$strings['SignIn'] = 'Iscriviti';
		$strings['AllParticipants'] = 'Tutti i partecipanti';
		$strings['RegisterANewAccount'] = 'Crea un nuovo profilo';
		$strings['Dates'] = 'Date';
		$strings['More'] = 'Altro';
		$strings['ResourceAvailability'] = 'Disponibilità delle risorse';
		$strings['UnavailableAllDay'] = 'Indisponibile per tutto il giorno';
		$strings['AvailableUntil'] = 'Disponibile fino a';
		$strings['AvailableBeginningAt'] = 'Disponibile a partire da';
		$strings['AllResourceTypes'] = 'Tutte le risorse';
		$strings['AllResourceStatuses'] = 'Qualunque stato';
		$strings['AllowParticipantsToJoin'] = 'Consenti ai partecipanti di unirsi';
		$strings['Join'] = 'Unisci';
		$strings['YouAreAParticipant'] = 'Sei un partecipante a questa prenotazione';
		$strings['YouAreInvited'] = 'Sei invitato a questa prenotazione';
		$strings['YouCanJoinThisReservation'] = 'Puoi unirti a questa prenotazione';
		$strings['Import'] = 'Importa';
		$strings['GetTemplate'] = 'Genera il template';
		$strings['UserImportInstructions'] = 'I file devono essere in formato CSV. Nome utente ed email sono campi obbligatori. Lasciando vuoti gli altri campi si erediteranno i calori di default e, come \'password\' la password dell\'utente. Si usi il template fornito come esempio.';
		$strings['RowsImported'] = 'Righe importate';
		$strings['RowsSkipped'] = 'Righe scartate';
		$strings['Columns'] = 'Colonne';
		$strings['Reserve'] = 'Riservato';
		$strings['AllDay'] = 'Tutto il giorno';
		$strings['Everyday'] = 'Ogni giorno';
		$strings['IncludingCompletedReservations'] = 'incluse le prenotazioni già effettuate';
		$strings['NotCountingCompletedReservations'] = 'senza contare le prenotazioni già effettuate';
		$strings['RetrySkipConflicts'] = 'Trascura le prenotazioni che confliggono';
		$strings['Retry'] = 'Riprova';
		$strings['RemoveExistingPermissions'] = 'Elimino i permessi attuali?';
		$strings['Continue'] = 'Continua';
		$strings['WeNeedYourEmailAddress'] = 'L\'indirizzo di posta elettronica è necessario per prenotare';
		$strings['ResourceColor'] = 'Colore della risorsa';
		$strings['DateTime'] = 'Date e ora';
		$strings['AutoReleaseNotification'] = 'Rilasciato automaticamente se non controllato entro %s minuti';
		$strings['RequiresCheckInNotification'] = 'Richiede il check in/out';
		$strings['NoCheckInRequiredNotification'] = 'Non richiede il check in/out';
		$strings['RequiresApproval'] = 'Richiede approvazione';
		$strings['CheckingIn'] = 'Checking In';
		$strings['CheckingOut'] = 'Checking Out';
		$strings['CheckIn'] = 'Check In';
		$strings['CheckOut'] = 'Check Out';
		$strings['ReleasedIn'] = 'Rilasciato';
		$strings['CheckedInSuccess'] = 'Check in conseguito';
		$strings['CheckedOutSuccess'] = 'Check out conseguito';
		$strings['CheckInFailed'] = 'Processo di check in fallito';
		$strings['CheckOutFailed'] = 'Processo di check out fallito';
		$strings['CheckInTime'] = 'Ora del check in';
		$strings['CheckOutTime'] = 'Ora del check out';
		$strings['OriginalEndDate'] = 'Data originale di conclusione';
		$strings['SpecificDates'] = 'Mostra date specifiche';
		$strings['Users'] = 'Utenti';
		$strings['Guest'] = 'Ospite';
		$strings['ResourceDisplayPrompt'] = 'Risorse da mostrare';
		$strings['Credits'] = 'Riconoscimenti';
		$strings['AvailableCredits'] = 'Riconoscimenti disponibili';
		$strings['CreditUsagePerSlot'] = 'Richiede %s riconoscimenti per casella (non di punta)';
		$strings['PeakCreditUsagePerSlot'] = 'Richiede %s riconoscimenti per casella (di punta)';
		$strings['CreditsRule'] = 'Non hai sufficienti riconoscimenti. Riconoscimenti richiesti: %s. Riconoscimenti attuali: %s';
		$strings['PeakTimes'] = 'Ore di punta';
		$strings['AllYear'] = 'Tutto l\'anno';
		$strings['MoreOptions'] = 'Altro';
		$strings['SendAsEmail'] = 'Invia l\'email';
		$strings['UsersInGroups'] = 'Utenti nel gruppo';
		$strings['UsersWithAccessToResources'] = 'Utenti con accesso alle risorse';
		$strings['AnnouncementSubject'] = 'Una nuovo comunicazione è stato pubblicato da %s';
		$strings['AnnouncementEmailNotice'] = 'la comunicazione sarà inviata agli utenti per posta elettronica';
		$strings['Day'] = 'Giorno';
		$strings['NotifyWhenAvailable'] = 'Avvisami quando disponibile';
		$strings['AddingToWaitlist'] = 'Sei stato aggiunto alla lista di attesa';
		$strings['WaitlistRequestAdded'] = 'Sarai avvisato se questo orario diverrà disponibile';
		$strings['PrintQRCode'] = 'Stampa il QR Code';
		$strings['FindATime'] = 'Trova una disponibilità';
		$strings['AnyResource'] = 'Qualsiasi risorsa';
		$strings['ThisWeek'] = 'Questa settimana';
		$strings['Hours'] = 'Ore';
		$strings['Minutes'] = 'Minuti';
        $strings['ImportICS'] = 'Importa da ICS';
        $strings['ImportQuartzy'] = 'Importa da Quartzy';
        $strings['OnlyIcs'] = 'Solo file *.ics possono essere caricati.';
        $strings['IcsLocationsAsResources'] = 'I luoghi saranno importati come risorse.';
        $strings['IcsMissingOrganizer'] = 'Gli eventi privi dell\'organizzatore saranno assegnati all\'utente corrente.';
        $strings['IcsWarning'] = 'Le regole di prenotazione non saranno verificate. Potranno verificarsi conflitti e duplicazioni.';
		$strings['BlackoutAroundConflicts'] = 'Salta le prenotazioni in conflitto';
		$strings['DuplicateReservation'] = 'Duplicazione';
		$strings['UnavailableNow'] = 'Non disponibile adesso';
		$strings['ReserveLater'] = 'Prenota più tardi';
		$strings['CollectedFor'] = 'Valido per';
		$strings['IncludeDeleted'] = 'Includi le prenotazioni cancellate';
		$strings['Deleted'] = 'Cancellato';
		$strings['Back'] = 'Indietro';
		$strings['Forward'] = 'Avanti';
		$strings['DateRange'] = 'Intervallo temporale';
		$strings['Copy'] = 'Copia';
		$strings['Detect'] = 'Rileva';
		$strings['Autofill'] = 'Autoriempimento';
        // End Strings

		// Install
		$strings['InstallApplication'] = 'Installa Booked Scheduler (solo MySQL)';
		$strings['IncorrectInstallPassword'] = 'Attenzione, la password non è corretta.';
		$strings['SetInstallPassword'] = 'È necessario impostare una password di installazione prima che l\'installazione possa essere eseguita.';
		$strings['InstallPasswordInstructions'] = 'In %s si consiglia di scegliere %s una password sicura e, quindi, di riprovare.<br />È possibile usare %s';
		$strings['NoUpgradeNeeded'] = 'Non è necessario alcun aggiornamento. L\'installazione cancella tutti i dati esistenti e installa una nuova copia di Booked Scheduler!';
		$strings['ProvideInstallPassword'] = 'Si immetta la password di installazoine.';
		$strings['InstallPasswordLocation'] = 'Quest\'ultima è definita nel file %s in %s.';
		$strings['VerifyInstallSettings'] = 'Verifica i seguenti parametri prima di continuare. Sono eventualmente modificabili da %s.';
		$strings['DatabaseName'] = 'Nome del database';
		$strings['DatabaseUser'] = 'Utente del database';
		$strings['DatabaseHost'] = 'Server del database';
		$strings['DatabaseCredentials'] = 'È necessario fornire le credenziali di un utente MySQL con privilegi sufficienti alla creazione del database. Se non si conoscono, si contatti l\'amministratore del database. In molti casi, "root" funziona.';
		$strings['MySQLUser'] = 'Utente MySQL';
		$strings['InstallOptionsWarning'] = 'Le seguenti opzioni, probabilmente, non funzioneranno su un server remoto. In questo caso, si utilizzino gli strumenti della procedura guidata per completare la procedura.';
		$strings['CreateDatabase'] = 'Crea il database';
		$strings['CreateDatabaseUser'] = 'Crea l\'utente MySQL con diritti sul database';
		$strings['PopulateExampleData'] = 'Importa dati di esempio. Crea un account per l\'amministratore: admin/password e un account per l\'utente: user/password';
		$strings['DataWipeWarning'] = 'Attenzione: Questo distruggerà ogni dato preesistente';
		$strings['RunInstallation'] = 'Avvia l\'installazione';
		$strings['UpgradeNotice'] = 'Si sta aggiornando dalla versione <b>%s</b> alla versione <b>%s</b>';
		$strings['RunUpgrade'] = 'Avvia l\'aggiornamento';
		$strings['Executing'] = 'Esecuzione in corso';
		$strings['StatementFailed'] = 'Errore. Dettagli:';
		$strings['SQLStatement'] = 'Query SQL:';
		$strings['ErrorCode'] = 'Codice di errore:';
		$strings['ErrorText'] = 'Messaggio di errore:';
		$strings['InstallationSuccess'] = 'Installazione eseguita con successo!';
		$strings['RegisterAdminUser'] = 'Accedi come amministratore. Questo è necessario se non sono stati importati dati di esempio. Ci si assicuri che $conf[\'settings\'][\'allow.self.registration\'] = \'true\' nel file %s file.';
		$strings['LoginWithSampleAccounts'] = 'Se non sono stati importati dati di esempio, è possibile accedere come amministratore con credenziali: admin/password or come utente con credenziali: user/password.';
		$strings['InstalledVersion'] = 'Si sta usando la versione %s di Booked Scheduler';
		$strings['InstallUpgradeConfig'] = 'Si racomanda di aggiornare il file config';
		$strings['InstallationFailure'] = 'Si sono verificati dei problemi durante l\'intallazione. Si prega di correggerli e di riprovare l\'installazione.';
		$strings['ConfigureApplication'] = 'Configure Booked Scheduler';
		$strings['ConfigUpdateSuccess'] = 'Il file config è aggiornato!';
		$strings['ConfigUpdateFailure'] = 'Non è possibile aggiornare automaticamente il file config. Si prega di sovrascrivere il contenuto corrente del file con il seguente:';
		$strings['SelectUser'] = 'Seleziona utente';
		$strings['InviteUsers'] = 'Invita altri utenti';
		$strings['InviteUsersLabel'] = 'Riporta l\'indirizzo di posta elettronica delle persone da invitare';
		// End Install

		// Errors
		$strings['LoginError'] = 'Nome utente o password errate';
		$strings['ReservationFailed'] = 'Impossibile creare la prenotazione';
		$strings['MinNoticeError'] = 'Questa prenotazione non è assegnabile in anticipo. La prima data che può essere assegnata è %s.';
		$strings['MaxNoticeError'] = 'Questa prenotazione non può essere creata fino a questa data nel futuro. L\'ultima data che può essere assegnata è %s.';
		$strings['MinDurationError'] = 'La prenotazione deve durare almeno %s.';
		$strings['MaxDurationError'] = 'Questa prenotazione non può durare più di %s.';
		$strings['ConflictingAccessoryDates'] = 'Non ci sono abbastanza accessori:';
		$strings['NoResourcePermission'] = 'Non hai i permessi per accedere a una o più risorse richieste';
		$strings['ConflictingReservationDates'] = 'Ci sono prenotazioni in conflitto nelle seguenti date:';
		$strings['StartDateBeforeEndDateRule'] = 'La data di inizio deve essere antecedente alla data di fine';
		$strings['StartIsInPast'] = 'La data di inizio non può essere nel passato';
		$strings['EmailDisabled'] = 'L\'amministratore ha disabilitato le notifiche via email';
		$strings['ValidLayoutRequired'] = 'L\'insieme delle fasce orarie deve coprire tutte le 24 ore del giorno iniziando e finendo alle 00:00.';
		$strings['CustomAttributeErrors'] = 'C\'è un problema con gli attributi aggiuntivi:';
		$strings['CustomAttributeRequired'] = '%s è un campo obbligatorio';
		$strings['CustomAttributeInvalid'] = 'Il valore fornito per %s non è valido';
		$strings['AttachmentLoadingError'] = 'Spiacente, c\'è stato un problemadurante il caricamento del file richiesto.';
		$strings['InvalidAttachmentExtension'] = 'Puoi solo caricare file in %s';
		$strings['InvalidStartSlot'] = 'La data/ora di inizio non è valida.';
		$strings['InvalidEndSlot'] = 'La data/ora di fine non è valida.';
		$strings['MaxParticipantsError'] = '%s può contenere al massimo %s partecipanti.';
		$strings['ReservationCriticalError'] = 'Errore critico durante il salvataggio della prenotazione. Se il problema persiste contatta l\'amministratore dell\'applicazione.';
		$strings['InvalidStartReminderTime'] = 'L\'orario del promemoria di inizio prenotazione non è valido.';
		$strings['InvalidEndReminderTime'] = 'L\'orario del promemoria di fine prenotazione non è valido.';
		$strings['QuotaExceeded'] = 'Limite della quota superato.';
		$strings['MultiDayRule'] = '%s non permette prenotazioni su più giorni.';
		$strings['InvalidReservationData'] = 'Ci sono stati problemi con la tua richiesta di prenotazione.';
		$strings['PasswordError'] = 'La password deve contenere almeno %s lettere ed %s numeri.';
		$strings['PasswordErrorRequirements'] = 'La password deve contenere una combinazione di almeno %s maiuscole e minuscole e %s numeri.';
		$strings['NoReservationAccess'] = 'Non sei abilitato a modificare questa prenotazione.';
		$strings['PasswordControlledExternallyError'] = 'La password è controllata da un sistema esterno e non può essere modificata localmente.';
		$strings['AccessoryResourceRequiredErrorMessage'] = 'L\'accessorio %s può essere richiesto solo con la risorsa %s';
		$strings['AccessoryMinQuantityErrorMessage'] = 'Si devono richiedere almeno %s %s';
		$strings['AccessoryMaxQuantityErrorMessage'] = 'Non si possono richiedere più di %s %s';
		$strings['AccessoryResourceAssociationErrorMessage'] = 'L\'ccessorio \'%s\' non può essere richiesto con la risorsa selezionata';
		$strings['NoResources'] = 'Nessuna risorsa è stata aggiunta.';
		$strings['ParticipationNotAllowed'] = 'Non puoi accedere a questa prenotazione.';
		$strings['ReservationCannotBeCheckedInTo'] = 'Questa prenotazione non può essere inviata.';
		$strings['ReservationCannotBeCheckedOutFrom'] = 'Questa prenotazione non può essere ritirata.';
		$strings['InvalidEmailDomain'] = 'Questo indirizzo di posta elettronica non appartiene ad un dominio consentito';
		// End Errors

		// Page Titles
		$strings['CreateReservation'] = 'Crea prenotazione';
		$strings['EditReservation'] = 'Modifica prenotazione';
		$strings['LogIn'] = 'Accedi';
		$strings['ManageReservations'] = 'Prenotazioni';
		$strings['AwaitingActivation'] = 'Attesa attivazione';
		$strings['PendingApproval'] = 'Approvazione in sospeso';
		$strings['ManageSchedules'] = 'Calendari';
		$strings['ManageResources'] = 'Risorse';
		$strings['ManageAccessories'] = 'Accessori';
		$strings['ManageUsers'] = 'Utenti';
		$strings['ManageGroups'] = 'Gruppi';
		$strings['ManageQuotas'] = 'Quote';
		$strings['ManageBlackouts'] = 'Fuori-servizio';
		$strings['MyDashboard'] = 'Cruscotto personale';
		$strings['ServerSettings'] = 'Impostazioni server';
		$strings['Dashboard'] = 'Cruscotto';
		$strings['Help'] = 'Aiuto';
		$strings['Administration'] = 'Amministrazione';
		$strings['About'] = 'Informazioni su';
		$strings['Bookings'] = 'Prenotazioni';
		$strings['Schedule'] = 'Calendario';
		$strings['Account'] = 'Account';
		$strings['EditProfile'] = 'Modifica il profilo';
		$strings['FindAnOpening'] = 'Trova una data disponibile';
		$strings['OpenInvitations'] = 'Inviti aperti';
		$strings['ResourceCalendar'] = 'Calendario risorse';
		$strings['Reservation'] = 'Nuova prenotazione';
		$strings['Install'] = 'Installazione';
		$strings['ChangePassword'] = 'Cambia password';
		$strings['MyAccount'] = 'Account personale';
		$strings['Profile'] = 'Profilo';
		$strings['ApplicationManagement'] = 'Gestione applicazione';
		$strings['ForgotPassword'] = 'Password dimenticata';
		$strings['NotificationPreferences'] = 'Preferenze di notifica';
		$strings['ManageAnnouncements'] = 'Avvisi';
		$strings['Responsibilities'] = 'Amministrazione';
		$strings['GroupReservations'] = 'Prenotazioni gruppo';
		$strings['ResourceReservations'] = 'Prenotazioni risorsa';
		$strings['Customization'] = 'Personalizzazione';
		$strings['Attributes'] = 'Attributi';
		$strings['AccountActivation'] = 'Attivazione account';
		$strings['ScheduleReservations'] = 'Calendario prenotazioni';
		$strings['Reports'] = 'Report';
		$strings['GenerateReport'] = 'Crea nuovo report';
		$strings['MySavedReports'] = 'Report salvati';
		$strings['CommonReports'] = 'Report comuni';
		$strings['ViewDay'] = 'Mostra giorno';
		$strings['Group'] = 'Gruppo';
		$strings['ManageConfiguration'] = 'Configurazione applicazione';
		$strings['LookAndFeel'] = 'Aspetto applicazione';
		$strings['ManageResourceGroups'] = 'Gruppi risorsa';
		$strings['ManageResourceTypes'] = 'Tipi risorsa';
		$strings['ManageResourceStatus'] = 'Stati risorsa';
		$strings['ReservationColors'] = 'Colori delle prenotazioni';
		// End Page Titles

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
		// End Day representations

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'La tua richiesta di prenotazione è stata approvata';
		$strings['ReservationCreatedSubject'] = 'La tua richiesta di prenotazione è stata inoltrata';
		$strings['ReservationUpdatedSubject'] = 'La tua richiesta di prenotazione è stata aggiornata';
		$strings['ReservationDeletedSubject'] = 'La tua richiesta di prenotazione è stata rimossa';

		$strings['ReservationCreatedAdminSubject'] = 'Notifica: Hai inoltrato una richiesta di prenotazione';
		$strings['ReservationUpdatedAdminSubject'] = 'Notifica: Una tua richiesta di prenotazione è stata aggiornata';
		$strings['ReservationDeleteAdminSubject'] = 'Notifica: Una tua richiesta di prenotazione è stata rimossa';
		$strings['ReservationApprovalAdminSubject'] = 'Notifica: Una tua richiesta di prenotazione è in attesa di approvazione';

		$strings['ParticipantAddedSubject'] = 'Notifica di partecipazione ad una prenotazione';
		$strings['ParticipantDeletedSubject'] = 'Annullata partecipazione ad una prenotazione';
		$strings['InviteeAddedSubject'] = 'Invito ad una prenotazione';
		$strings['ResetPasswordRequest'] = 'Richiesta di reimpostazione della password';
		$strings['ActivateYourAccount'] = 'Attiva il tuo account';
		$strings['ReportSubject'] = 'Il report che hai richiesto (%s)';
		$strings['ReservationStartingSoonSubject'] = 'La prenotazione di %s sta per iniziare';
		$strings['ReservationEndingSoonSubject'] = 'La prenotazione di %s sta per terminare';
		$strings['UserAdded'] = 'Aggiunto nuovo utente';
		$strings['UserDeleted'] = 'Il profilo di %s è stato cancellato da %s';
		$strings['GuestAccountCreatedSubject'] = 'Dettagli del tuo profilo';
		$strings['InviteUserSubject'] = '%s ti ha invitato ad unirti a %s';

		$strings['ReservationCreatedSubjectWithResource'] = 'Hai inoltrato una richiesta di prenotazione per %s';
		$strings['ReservationUpdatedSubjectWithResource'] = 'Hai modificato una richiesta di prenotazione per %s';
		$strings['ReservationDeletedSubjectWithResource'] = 'Una tua richiesta di prenotazione per %s è stata eliminata';
		$strings['ReservationApprovedSubjectWithResource'] = 'Una tua richiesta di prenotazione per %s è stata approvata';

		$strings['ReservationCreatedAdminSubjectWithResource'] = 'Notifica: Richiesta di prenotazione inoltrata per %s';
		$strings['ReservationUpdatedAdminSubjectWithResource'] = 'Notifica: Richiesta di prenotazione modificata per %s';
		$strings['ReservationDeleteAdminSubjectWithResource'] = 'Notifica: Richiesta di prenotazione eliminata per %s';
		$strings['ReservationApprovalAdminSubjectWithResource'] = 'Notifica: Richiesta di prenotazione per %s richiede la tua approvazione';

		$strings['ParticipantAddedSubjectWithResource'] = '%s ti ha aggiunto alla prenotazione per %s';
		$strings['ParticipantDeletedSubjectWithResource'] = '%s ha eliminato la prenotazione per %s';
		$strings['InviteeAddedSubjectWithResource'] = '%s ti ha invitato alla prenotazione per %s';
		// End Email Subjects

		$this->Strings = $strings;

		return $this->Strings;
	}

	/**
	 * @return array
	 */
	protected function _LoadDays()
	{
		$days = parent::_LoadDays();

		/***
		 * DAY NAMES
		 * All of these arrays MUST start with Sunday as the first element
		 * and go through the seven day week, ending on Saturday
		 ***/
		// The full day name
		$days['full'] = array('Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato');
		// The three letter abbreviation
		$days['abbr'] = array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
		// The two letter abbreviation
		$days['two'] = array('Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa');
		// The one letter abbreviation
		$days['letter'] = array('D', 'L', 'M', 'M', 'G', 'V', 'S');

		$this->Days = $days;

		return $this->Days;
	}

	/**
	 * @return array
	 */
	protected function _LoadMonths()
	{
		$months = parent::_LoadMonths();

		/***
		 * MONTH NAMES
		 * All of these arrays MUST start with January as the first element
		 * and go through the twelve months of the year, ending on December
		 ***/
		// The full month name
		$months['full'] = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
		// The three letter month name
		$months['abbr'] = array('Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic');

		$this->Months = $months;

		return $this->Months;
	}

	/**
	 * @return array
	 */
	protected function _LoadLetters()
	{
		$this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

		return $this->Letters;
	}

	protected function _GetHtmlLangCode()
	{
		return 'it';
	}
}