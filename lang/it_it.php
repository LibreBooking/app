<?php
/**
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
        $dates['res_popup'] = 'd/m/Y H:i';
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
        $strings['Timezone'] = 'Fuso orario';
        $strings['Edit'] = 'Modifica';
        $strings['Change'] = 'Cambia';
        $strings['Rename'] = 'Rinomina';
        $strings['Remove'] = 'Remove';
        $strings['Delete'] = 'Elimina';
        $strings['Update'] = 'Aggiorna';
        $strings['Cancel'] = 'Annulla';
        $strings['Add'] = 'Aggiungi';
        $strings['Name'] = 'Nome';
        $strings['Yes'] = 'Sí';
        $strings['No'] = 'No';
        $strings['FirstNameRequired'] = 'Il nome è un campo obbligatorio';
        $strings['LastNameRequired'] = 'Il cognome è un campo obbligatorio';
        $strings['PwMustMatch'] = 'Password non coincidenti';
        $strings['PwComplexity'] = 'La password deve contemplare almeno 6 caratteri fra numeri, lettere e simboli';
        $strings['ValidEmailRequired'] = 'Email non valida';
        $strings['UniqueEmailRequired'] = 'Email già in uso';
        $strings['UniqueUsernameRequired'] = 'Nome utente già in uso';
        $strings['UserNameRequired'] = 'Il nome utente è un campo obbligatorio';
        $strings['CaptchaMustMatch'] = 'Trascrivere i caratteri come mostrati a video';
        $strings['Today'] = 'Oggi';
        $strings['Week'] = 'Settimana';
        $strings['Month'] = 'Mese';
        $strings['BackToCalendar'] = 'Torna al calendario';
        $strings['BeginDate'] = 'Inizio';
        $strings['EndDate'] = 'Fine';
        $strings['Username'] = 'Nome utente';
        $strings['Password'] = 'Password';
        $strings['PasswordConfirmation'] = 'Nuova password (ripeti)';
        $strings['DefaultPage'] = 'Pagina d\'ingresso';
        $strings['MyCalendar'] = 'Il mio Calendario';
        $strings['ScheduleCalendar'] = 'Calendario delle prenotazioni';
        $strings['Registration'] = 'Registro';
        $strings['NoAnnouncements'] = 'Nessuna comunicazione';
        $strings['Announcements'] = 'Comunicazioni';
        $strings['NoUpcomingReservations'] = 'Nessuna prenotazione';
        $strings['UpcomingReservations'] = 'Prossime prenotazioni';
        $strings['ShowHide'] = 'Mostra/Nascondi';
        $strings['Error'] = 'Errore';
        $strings['ReturnToPreviousPage'] = 'Ritorna';
        $strings['UnknownError'] = 'Errore sconosciuto';
        $strings['InsufficientPermissionsError'] = 'Non hai il permesso per accedere a questa risorsa';
        $strings['MissingReservationResourceError'] = 'Nessuna prenotazione selezionata';
        $strings['MissingReservationScheduleError'] = 'Nessuna pianificazione selezionata';
        $strings['DoesNotRepeat'] = 'non è ripetuta';
        $strings['Daily'] = 'Quotidiana';
        $strings['Weekly'] = 'Settimanale';
        $strings['Monthly'] = 'Mensile';
        $strings['Yearly'] = 'Annuale';
        $strings['RepeatPrompt'] = 'Ripetizione';
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
        $strings['RepeatUntilPrompt'] = 'fino a';
        $strings['RepeatEveryPrompt'] = 'ogni';
        $strings['RepeatDaysPrompt'] = 'e';
        $strings['CreateReservationHeading'] = 'Crea una nuova prenotazione';
        $strings['EditReservationHeading'] = 'Modifica la prenotazione %s';
        $strings['ViewReservationHeading'] = 'Visualizza la prenotazione %s';
        $strings['ReservationErrors'] = 'Correggi la prenotazione';
        $strings['Create'] = 'Crea';
        $strings['ThisInstance'] = 'S&oacute;lo Esta Instancia';
        $strings['AllInstances'] = 'Todas Las Instancias';
        $strings['FutureInstances'] = 'Instancias Futuras';
        $strings['Print'] = 'Stampa';
        $strings['ShowHideNavigation'] = 'Mostrar/Ocular Navegación';
        $strings['ReferenceNumber'] = 'Numero della prenotazione';
        $strings['Tomorrow'] = 'Ma&ntilde;ana';
        $strings['LaterThisWeek'] = 'M&aacute;s Tarde Esta Semana';
        $strings['NextWeek'] = 'Prossima settimana';
        $strings['SignOut'] = 'Esci';
        $strings['LayoutDescription'] = 'Inizia di %s, mostrando %s giorni per settimana';
        $strings['AllResources'] = 'Tutte le risorse';
        $strings['TakeOffline'] = 'Sospendi la disponibilità';
        $strings['BringOnline'] = 'Avvia la disponibilità';
        $strings['AddImage'] = 'Aggiungi immagine';
        $strings['NoImage'] = 'Immagine mancante';
        $strings['Move'] = 'Modifica';
        $strings['AppearsOn'] = 'Calendario: %s';
        $strings['Location'] = 'Localizzazione';
        $strings['NoLocationLabel'] = '(localizzazione non specificata)';
        $strings['Contact'] = 'Referente';
        $strings['NoContactLabel'] = '(referente non specificato)';
        $strings['Description'] = 'Descrizione';
        $strings['NoDescriptionLabel'] = '(descrizione non specificata)';
        $strings['Notes'] = 'Note';
        $strings['NoNotesLabel'] = '(note non specificate)';
        $strings['NoTitleLabel'] = '(titolo non specificato)';
        $strings['UsageConfiguration'] = 'Dettagli di utilizzo';
        $strings['ChangeConfiguration'] = 'Modifica';
        $strings['ResourceMinLength'] = 'La prenotazione deben durar por lo menos %s';
        $strings['ResourceMinLengthNone'] = 'Non è definita una durata minima per le prenotazioni';
        $strings['ResourceMaxLength'] = 'La prenotazione no pueden durar m&aacute;s de %s';
        $strings['ResourceMaxLengthNone'] = 'Non è definita una durata massima per le prenotazioni';
        $strings['ResourceRequiresApproval'] = 'La prenotazione deve essere approvata';
        $strings['ResourceRequiresApprovalNone'] = 'La prenotazione no requieren ser aprobadas';
        $strings['ResourcePermissionAutoGranted'] = 'L\'autorizzazione è automaticamente concessa';
        $strings['ResourcePermissionNotAutoGranted'] = 'L\'autorizzazione NON è automaticamente concessa';
        $strings['ResourceMinNotice'] = 'La prenotazione deben ser realizadas por lo menos %s antés del tiempo de inicio';
        $strings['ResourceMinNoticeNone'] = 'Le prenotazioni possono essere effettuate fino al momento attuale';
        $strings['ResourceMaxNotice'] = 'La prenotazione no deben durar m&aacute;s de %s desde el tiempo actual';
        $strings['ResourceMaxNoticeNone'] = 'Le prenotazioni possono terminare in qualsiasi momento futuro';
        $strings['ResourceAllowMultiDay'] = 'Le prenotazioni possono estendersi su più giorni';
        $strings['ResourceNotAllowMultiDay'] = 'La prenotazione no pueden extenderse a lo largo de d&iacute;as';
        $strings['ResourceCapacity'] = 'Questa risorsa ha una capienza di %s persone';
        $strings['ResourceCapacityNone'] = 'A questa risorsa è assegnata una capienza illimitata';
        $strings['AddNewResource'] = 'Aggiungi nuova risorsa';
        $strings['AddNewUser'] = 'Aggiungi nuovo utente';
        $strings['AddUser'] = 'Aggiungi utente';
        $strings['Schedule'] = 'Prenotazioni';
        $strings['AddResource'] = 'Aggiungi risorsa';
        $strings['Capacity'] = 'Capienza';
        $strings['Access'] = 'Accesso';
        $strings['Duration'] = 'Durata';
        $strings['Active'] = 'Attivo';
        $strings['Inactive'] = 'Inactivo';
        $strings['ResetPassword'] = 'Reiniciar Contrase&ntilde;';
        $strings['LastLogin'] = 'Ultimo accesso';
        $strings['Search'] = 'Seleziona';
        $strings['ResourcePermissions'] = 'Accesso';
        $strings['Reservations'] = 'Prenotazioni';
        $strings['Groups'] = 'Grupos';
        $strings['ResetPassword'] = 'Reiniciar Contrase&ntilde;';
        $strings['AllUsers'] = 'Tutti gli utenti';
        $strings['AllGroups'] = 'Tutti i gruppi';
        $strings['AllSchedules'] = 'Tutti i calendari';
        $strings['UsernameOrEmail'] = 'Nome utente o indirizzo di posta elettronica';
        $strings['Members'] = 'Miembros';
        $strings['QuickSlotCreation'] = 'Intervalli temporali di %s minuti dalle %s alle %s';
        $strings['ApplyUpdatesTo'] = 'Aplicar Actualizaciones A';
        $strings['CancelParticipation'] = 'Cancelar Participaci&oacute;n';
        $strings['Attending'] = 'Asistencia';
        $strings['QuotaConfiguration'] = 'In %s in %s le prenotazioni degli utenti in %s sono limitate a %s %s per %s';
        $strings['reservations'] = 'reservas';
        $strings['ChangeCalendar'] = 'Cambia il calendario';
        $strings['AddQuota'] = 'Aggiungi quota';
        $strings['FindUser'] = 'Cerca';
        $strings['Created'] = 'Data di creazione';
        $strings['LastModified'] = 'Ultima modifica';
        $strings['GroupName'] = 'Nome';
        $strings['GroupMembers'] = 'Membri';
        $strings['GroupRoles'] = 'Ruoli';
        $strings['GroupAdmin'] = 'Gruppo amministrativo';
        $strings['Actions'] = 'Azioni';
        $strings['CurrentPassword'] = 'Password attuale';
        $strings['NewPassword'] = 'Nuova password';
        $strings['InvalidPassword'] = 'La password corrente non è corretta';
        $strings['PasswordChangedSuccessfully'] = 'La password è stata modificata con successo';
        $strings['SignedInAs'] = 'Sei collegato come';
        $strings['NotSignedIn'] = 'Non sei collegato';
        $strings['ReservationTitle'] = 'Nome della prenotazione';
        $strings['ReservationDescription'] = 'Descrizione della prenotazione';
        $strings['ResourceList'] = 'Risorsa da prenotare';
        $strings['Accessories'] = 'Accessori';
        $strings['Add'] = 'Aggiungi';
        $strings['ParticipantList'] = 'Partecipanti';
        $strings['InvitationList'] = 'Altri utenti da invitare';
        $strings['AccessoryName'] = 'Nome dell\'accessorio';
        $strings['QuantityAvailable'] = 'Disponibilità';
        $strings['Resources'] = 'Recursos';
        $strings['Participants'] = 'Partecipanti';
        $strings['User'] = 'Utente';
        $strings['Resource'] = 'Risorsa';
        $strings['Status'] = 'Stato';
        $strings['Approve'] = 'Conferma';
        $strings['Page'] = 'Pagina';
        $strings['Rows'] = 'Righe';
        $strings['Unlimited'] = 'Illimitata';
        $strings['Email'] = 'Indirizzo di posta elettronica';
        $strings['EmailAddress'] = 'Direci&oacute;n de Correo';
        $strings['Phone'] = 'Telefono';
        $strings['Organization'] = 'Istituzione';
        $strings['Position'] = 'Posizione';
        $strings['Language'] = 'Lingua';
        $strings['Permissions'] = 'Permessi';
        $strings['Reset'] = 'Modifica';
        $strings['FindGroup'] = 'Cerca';
        $strings['Manage'] = 'Gestisci';
        $strings['None'] = 'Nessuno';
        $strings['AddToOutlook'] = 'Esporta su Outlook';
        $strings['Done'] = 'Continua';
        $strings['RememberMe'] = 'Ricordami';
        $strings['FirstTimeUser?'] = 'Primo accesso?';
        $strings['CreateAnAccount'] = 'Crea un nuovo account';
        $strings['ViewSchedule'] = 'Visualizza le prenotazioni';
        $strings['ForgotMyPassword'] = 'Password dimenticata?';
        $strings['YouWillBeEmailedANewPassword'] = 'Se te enviar&acute; una contrase&ntilde;a generada aleatoriamente';
        $strings['Close'] = 'Continua';
        $strings['ExportToCSV'] = 'Esporta in testo separato da virgola (CSV)';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Funcionando';
        $strings['Login'] = 'Accesso iniziale';
        $strings['AdditionalInformation'] = 'Altre informazioni';
        $strings['AllFieldsAreRequired'] = 'tutti i campi sono obbligatori';
        $strings['Optional'] = 'opzionali';
        $strings['YourProfileWasUpdated'] = 'Il tuo profilo è stato aggiornato';
        $strings['YourSettingsWereUpdated'] = 'Le tue impostazioni di notifica sono state aggiornate';
        $strings['Register'] = 'Registrar';
        $strings['SecurityCode'] = 'C&oacute;digo de Seguridad';
        $strings['ReservationCreatedPreference'] = 'Quando richiedo una prenotazione o questa viene fatta a nome mio';
        $strings['ReservationUpdatedPreference'] = 'Quando aggiorno una prenotazione o questa viene aggiornata a nome mio';
        $strings['ReservationApprovalPreference'] = 'Quando una mia richiesta di prenotazione viene approvata';
        $strings['PreferenceSendEmail'] = 'Inviami una email';
        $strings['PreferenceNoEmail'] = 'Non fare nulla';
        $strings['ReservationCreated'] = 'La prenotazione è stata creata con successo!';
        $strings['ReservationUpdated'] = 'La prenotazione è stata aggiornata con successo!';
        $strings['ReservationRemoved'] = 'La prenotazione è stata cancellata';
        $strings['YourReferenceNumber'] = 'Il numero di prenotazione è: %s';
        $strings['UpdatingReservation'] = 'Aggiornamento della prenotazione';
        $strings['ChangeUser'] = 'Cambia utente';
        $strings['MoreResources'] = 'altre risorse';
        $strings['ReservationLength'] = 'Darata della prenotazione';
        $strings['ParticipantList'] = 'Lista dei partecipanti';
        $strings['AddParticipants'] = 'Aggiungi partecipante';
        $strings['InviteOthers'] = 'Altri utenti da invitare';
        $strings['AddResources'] = 'Aggiungi risorse';
        $strings['AddAccessories'] = 'Aggiungi accessori';
        $strings['Accessory'] = 'Accessorio';
        $strings['QuantityRequested'] = 'Richiesta';
        $strings['CreatingReservation'] = 'Creando Reserva';
        $strings['UpdatingReservation'] = 'Actualizado Reserva';
        $strings['DeleteWarning'] = 'Si conferma la cancellazione?';
        $strings['DeleteAccessoryWarning'] = 'Eliminando questo accessorio lo si cancellerà da tutte le prenotazioni che lo coinvolgono.';
        $strings['AddAccessory'] = 'Aggiungi accessorio';
        $strings['AddBlackout'] = 'Nuovo blocco delle risorse';
        $strings['AllResourcesOn'] = 'Tutte le risorse nel calendario:';
        $strings['Reason'] = 'Causale';
        $strings['BlackoutShowMe'] = 'Visualizza le prenotazioni in conflitto con i blocchi';
        $strings['BlackoutDeleteConflicts'] = 'Elimina le prenotazioni in conflitto con i blocchi';
        $strings['Filter'] = 'Filtro';
        $strings['Between'] = 'Compresa fra:';
        $strings['CreatedBy'] = 'Creata da';
        $strings['BlackoutCreated'] = 'Blocco delle risorse correttamente creato';
        $strings['BlackoutNotCreated'] = 'Il blocco delle risorse non può essere creato';
        $strings['BlackoutConflicts'] = 'Ci sono sovrapposizioni temporali con le prenotazioni già effettuate';
        $strings['ReservationConflicts'] = 'Hay tiempos de reserva en conflicto';
        $strings['UsersInGroup'] = 'Usuarios en este grupo';
        $strings['Browse'] = 'Sfoglia';
        $strings['DeleteGroupWarning'] = 'Al borrar este grupo se eliminarán todos los permisos de los recursos asociados.  Los usuarios en este grupo pueden perder acceso a los recursos.';
        $strings['WhatRolesApplyToThisGroup'] = 'Ruoli del gruppo';
        $strings['WhoCanManageThisGroup'] = 'Gruppo amministrativo';
        $strings['AddGroup'] = 'Aggiungi gruppo';
        $strings['AllQuotas'] = 'Tutte le quote';
        $strings['QuotaReminder'] = 'Attenzione: le quote sono impostate in base all\'ora locale.';
        $strings['AllReservations'] = 'Tutte le prenotazioni';
        $strings['PendingReservations'] = 'Reservas Pendientes';
        $strings['Approving'] = 'Aprobando';
        $strings['MoveToSchedule'] = 'Calendario di riferimento';
        $strings['DeleteResourceWarning'] = 'Eliminando questa risorsa si perderanno tutti i dati associati, tra cui';
        $strings['DeleteResourceWarningReservations'] = '- tutte le prenotazioni attuali, passate e future';
        $strings['DeleteResourceWarningPermissions'] = '- tutte le autorizzazioni concesse';
        $strings['DeleteResourceWarningReassign'] = 'Si consiglia riassegnazione di tutte le autorizzazioni che non si intendono perdere';
        $strings['ScheduleLayout'] = 'Intervalli temporali (Fuso: %s)';
        $strings['ReservableTimeSlots'] = 'Intervalli di tempo disponibili';
        $strings['BlockedTimeSlots'] = 'Intervalli di tempo inaccessibili';
        $strings['ThisIsTheDefaultSchedule'] = 'Questa è la pianificazione predefinita. Non può essere cancellata';
        $strings['DefaultScheduleCannotBeBroughtDown'] = 'La planificación por defecto no se puede eliminar';
        $strings['MakeDefault'] = 'Hacer por Defecto';
        $strings['BringDown'] = 'Deshabilitar';
        $strings['ChangeLayout'] = 'Modifica gli intervalli temporali';
        $strings['AddSchedule'] = 'Nuovo calendario';
        $strings['StartsOn'] = 'Comincia con';
        $strings['NumberOfDaysVisible'] = 'Numero di giorni visibili';
        $strings['UseSameLayoutAs'] = 'Utilizza gli stessi parametri di';
        $strings['Format'] = 'Formato';
        $strings['OptionalLabel'] = 'Etiqueta Opcional';
        $strings['LayoutInstructions'] = 'Riportare un intervallo temporale per riga. Gli intervalli devono ricoprire tutte le 24 ore dalle 0.00 alle 24:00';
        $strings['AddUser'] = 'Nuovo utente';
        $strings['UserPermissionInfo'] = 'El acceso real a los recursos puede ser diferente dependiendo de los roles del usuario, permisos de grupo, o ajustes externos de permisos';
        $strings['DeleteUserWarning'] = 'Al borrar este usuario se eliminarán todos sus acutales, futuros y pasadas reservas.';
        $strings['AddAnnouncement'] = 'Nuova comunicazione';
        $strings['Announcement'] = 'Comunicazione';
        $strings['Priority'] = 'Priorità';
        $strings['Reservable'] = 'Prenotabile';
        $strings['Unreservable'] = 'Non prenotabile';
        $strings['Reserved'] = 'Prenotato';
        $strings['MyReservation'] = 'Personale';
        $strings['Pending'] = 'Non confermata';
        $strings['Past'] = 'Passato';
        $strings['Restricted'] = 'Inaccessibile';
		$strings['ViewAll'] = 'Mostra tutto';
		$strings['MoveResourcesAndReservations'] = 'Move resources and reservations to';

        // Errors
        $strings['LoginError'] = 'Nome utente o password non corretti';
        $strings['ReservationFailed'] = 'Non è possibile effettuare la prenotazione';
        $strings['MinNoticeError'] = 'Esta reserva se debe realizar por anticipada. La fecha más temprana que puede ser reservada %s.';
        $strings['MaxNoticeError'] = 'Esta reserva no se puede alargar tan lejos en el futuro. La última fecha en la que se puede reservar es %s.';
        $strings['MinDurationError'] = 'Esta reserva debe durar al menos %s.';
        $strings['MaxDurationError'] = 'Esta reserva no puede durar más de %s.';
        $strings['ConflictingAccessoryDates'] = 'No hay suficientes de los siguientes accesorios:';
        $strings['NoResourcePermission'] = 'No tienes permisos para acceder uno o más de los recursos requeridos';
        $strings['ConflictingReservationDates'] = 'Hay conflictos en las reservas de las siguientes fechas:';
        $strings['StartDateBeforeEndDateRule'] = 'La data di inizio della prenotazione deve precedere la data di conclusione della stessa';
        $strings['StartIsInPast'] = 'La fecha inicial no puede ser pasada';
        $strings['EmailDisabled'] = 'La notifica per posta elettronica è disabilitata';
        $strings['ValidLayoutRequired'] = 'Se deben proporcionar slots para las 24 horas del día comenando y terminando a las 12:00 AM.';

        // Page Titles
        $strings['CreateReservation'] = 'Crear Reserva';
        $strings['EditReservation'] = 'Editar Reserva';
        $strings['LogIn'] = 'Accedi';
        $strings['ManageReservations'] = 'Gestione delle prenotazioni';
        $strings['AwaitingActivation'] = 'Esperando Activación';
        $strings['PendingApproval'] = 'Pendiente De Aprobación';
        $strings['ManageSchedules'] = 'Gestione dei calendari';
        $strings['ManageResources'] = 'Gestione delle risorse';
        $strings['ManageAccessories'] = 'Gestione degli accessori';
        $strings['ManageUsers'] = 'Gestione degli utenti';
        $strings['ManageGroups'] = 'Gestione dei gruppi';
        $strings['ManageQuotas'] = 'Gestione delle quote';
        $strings['ManageBlackouts'] = 'Gestione del blocchi delle risorse';
        $strings['MyDashboard'] = 'Pannello di controllo';
        $strings['ServerSettings'] = 'Impostazioni del server';
        $strings['Dashboard'] = 'Pannello di controllo';
        $strings['Help'] = 'Guida';
        $strings['Bookings'] = 'Prenotazioni';
        $strings['Schedule'] = 'Calendario';
        $strings['Reservations'] = 'Prenotazioni';
        $strings['Account'] = 'Cuenta';
        $strings['EditProfile'] = 'Editar Mi Perfil';
        $strings['FindAnOpening'] = 'Encontrar Un Hueco';
        $strings['OpenInvitations'] = 'Inviti';
        $strings['MyCalendar'] = 'Il mio calendario';
        $strings['ResourceCalendar'] = 'Calendario Generale';
        $strings['Reservation'] = 'Nueva Reserva';
        $strings['Install'] = 'Instalación';
        $strings['ChangePassword'] = 'Modifica della password';
        $strings['MyAccount'] = 'Profilo personale';
        $strings['Profile'] = 'Profilo';
        $strings['ApplicationManagement'] = 'Amministrazione';
        $strings['ForgotPassword'] = 'Contraseña Olvidada';
        $strings['NotificationPreferences'] = 'Impostazioni di notifica';
        $strings['ManageAnnouncements'] = 'Gestione delle comunicazioni';
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
        $strings['ReservationApprovedSubject'] = 'Prenotazione approvata';
        $strings['ReservationCreatedSubject'] = 'Nuova richiesta di prenotazione';
        $strings['ReservationUpdatedSubject'] = 'Prenotazione aggiornata';
        $strings['ReservationCreatedAdminSubject'] = 'Notifica: una nuova richiesta di prenotazione è stata generata';
        $strings['ReservationUpdatedAdminSubject'] = 'Notifica: una richiesta di prenotazione è stata aggiornata';
        $strings['ParticipantAddedSubject'] = 'Invito a partecipare ad un evento';
        $strings['InviteeAddedSubject'] = 'Invito ad un evento';
        $strings['ResetPassword'] = 'Richiesta di modifica della password';
        $strings['ForgotPasswordEmailSent'] = 'Una email è stata iniata al tuo indirizzo con le istruzioni per modificare la password';
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
        $days['full'] = array('Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato');
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
