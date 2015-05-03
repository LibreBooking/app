<?php
/**
Copyright 2011-2015 Nick Korbel

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
 */

require_once('Language.php');
require_once('en_us.php');

class es extends en_us
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
        $dates['reservation_email'] = 'd/m/Y @ g:i A (e)';
        $dates['res_popup'] = 'd/m/Y g:i A';
        $dates['dashboard'] = 'd/m/Y g:i A';
        $dates['period_time'] = "g:i A";
		$dates['general_date_js'] = "dd/mm/yy";


        $this->Dates = $dates;
    }

    protected function _LoadStrings()
    {
        $strings = parent::_LoadStrings();

        $strings['FirstName'] = 'Nombre';
        $strings['LastName'] = 'Apellido';
        $strings['Timezone'] = 'Zona Horario';
        $strings['Edit'] = 'Editar';
        $strings['Change'] = 'Cambiar';
        $strings['Rename'] = 'Renombrar';
        $strings['Remove'] = 'Eliminar';
        $strings['Delete'] = 'Borrar';
        $strings['Update'] = 'Actualizar';
        $strings['Cancel'] = 'Cancelar';
        $strings['Add'] = 'A&ntilde;adir';
        $strings['Name'] = 'Nombre';
        $strings['Yes'] = 'S&iacute;';
        $strings['No'] = 'No';
        $strings['FirstNameRequired'] = 'Se requiere un Nombre.';
        $strings['LastNameRequired'] = 'Se requiere un Apellido.';
        $strings['PwMustMatch'] = 'La contrase&ntilde;a de confirmaci&oacute;n debe coincidir.';
        $strings['PwComplexity'] = 'La contrase&ntilde;a debe tener por lo menos 6 car&aacute;cteres.';
        $strings['PwRequired'] = 'Se requiere una contrase&ntilde;a.';
        $strings['ValidEmailRequired'] = 'Se requiere una direcci&oacute;n v&aacute;lida de email.';
        $strings['UniqueEmailRequired'] = 'Esa direcci&oacute;n de email ya est&aacute; registrada.';
        $strings['UniqueUsernameRequired'] = 'Ese Nombre de Usuario ya est&aacute; registrado.';
        $strings['UserNameRequired'] = 'Se requiere un Nombre de Usuario.';
        $strings['CaptchaMustMatch'] = 'Por favor, introduce los car&aacute;cteres de seguridad tal como aparecen.';
        $strings['Today'] = 'Hoy';
        $strings['Week'] = 'Semana';
        $strings['Month'] = 'Mes';
        $strings['BackToCalendar'] = 'Regreso al calendario';
        $strings['BeginDate'] = 'Inicio';
        $strings['EndDate'] = 'Fin';
        $strings['Username'] = 'Nombre de Usuario';
        $strings['Password'] = 'Contrase&ntilde;a';
        $strings['PasswordConfirmation'] = 'Confirmar Contrase&ntilde;a';
        $strings['DefaultPage'] = 'P&aacute;gina de Inicio por defecto';
        $strings['MyCalendar'] = 'Mi Calendario';
        $strings['ScheduleCalendar'] = 'Calendario de Reservas';
        $strings['Registration'] = 'Registro';
        $strings['NoAnnouncements'] = 'No hay Anuncios';
        $strings['Announcements'] = 'Anuncios';
        $strings['NoUpcomingReservations'] = 'No tienes Reservas pr&oacute;ximas';
        $strings['UpcomingReservations'] = 'Pr&oacute;ximas Reservas';
        $strings['ShowHide'] = 'Mostrar/Ocultar';
        $strings['Error'] = 'Error';
        $strings['ReturnToPreviousPage'] = 'Volver a la &uacute;ltima p&aacute;gina en la que estabas';
        $strings['UnknownError'] = 'Error Desconocido';
        $strings['InsufficientPermissionsError'] = 'No tienes permiso para acceder a este Recurso';
        $strings['MissingReservationResourceError'] = 'No se ha seleccionado un Recurso';
        $strings['MissingReservationScheduleError'] = 'No se ha seleccionado una Planificaci&oacute;n';
        $strings['DoesNotRepeat'] = 'No Se Repite';
        $strings['Daily'] = 'Diario';
        $strings['Weekly'] = 'Semanal';
        $strings['Monthly'] = 'Mensual';
        $strings['Yearly'] = 'Anual';
        $strings['RepeatPrompt'] = 'Repetir';
        $strings['hours'] = 'horas';
        $strings['days'] = 'd&iacute;as';
        $strings['weeks'] = 'semanas';
        $strings['months'] = 'meses';
        $strings['years'] = 'a&ntilde;os';
        $strings['day'] = 'd&iacute;a';
        $strings['week'] = 'semana';
        $strings['month'] = 'mes';
        $strings['year'] = 'a&ntilde;o';
        $strings['repeatDayOfMonth'] = 'd&iacute;a del mes';
        $strings['repeatDayOfWeek'] = 'd&iacute;a de la semana';
        $strings['RepeatUntilPrompt'] = 'Hasta';
        $strings['RepeatEveryPrompt'] = 'Cada';
        $strings['RepeatDaysPrompt'] = 'En';
        $strings['CreateReservationHeading'] = 'Crear una nueva reserva';
        $strings['EditReservationHeading'] = 'Editando reserva %s';
        $strings['ViewReservationHeading'] = 'Viendo reserva %s';
        $strings['ReservationErrors'] = 'Cambiar Reserva';
        $strings['Create'] = 'Crear';
        $strings['ThisInstance'] = 'S&oacute;lo Esta Instancia';
        $strings['AllInstances'] = 'Todas Las Instancias';
        $strings['FutureInstances'] = 'Instancias Futuras';
        $strings['Print'] = 'Imprimir';
        $strings['ShowHideNavigation'] = 'Mostrar/Ocultar Navegaci&oacute;n';
        $strings['ReferenceNumber'] = 'N&uacute;mero de Referencia';
        $strings['Tomorrow'] = 'Ma&ntilde;ana';
        $strings['LaterThisWeek'] = 'M&aacute;s Tarde Esta Semana';
        $strings['NextWeek'] = 'Siguiente Semana';
        $strings['SignOut'] = 'Cerrar';
        $strings['LayoutDescription'] = 'Empieza en %s, mostrando %s d&iacute;as cada vez';
        $strings['AllResources'] = 'Todos Los Recursos';
        $strings['TakeOffline'] = 'Deshabilitar';
        $strings['BringOnline'] = 'Habilitar';
        $strings['AddImage'] = 'A&ntilde;adir Im&aacute;gen';
        $strings['NoImage'] = 'Sin Im&aacute;gen Asignada';
        $strings['Move'] = 'Mover';
        $strings['AppearsOn'] = 'Aparece En %s';
        $strings['Location'] = 'Localizaci&oacute;n';
        $strings['NoLocationLabel'] = '(no se ha fijado una localizaci&oacute;n)';
        $strings['Contact'] = 'Contacto';
        $strings['NoContactLabel'] = '(sin informaci&oacute;n de contacto';
        $strings['Description'] = 'Descripci&oacute;n';
        $strings['NoDescriptionLabel'] = '(sin descripci&oacute;n)';
        $strings['Notes'] = 'Notas';
        $strings['NoNotesLabel'] = '(sin notas)';
        $strings['NoTitleLabel'] = '(sin t&iacute;tulo)';
        $strings['UsageConfiguration'] = 'Configuraci&oacute;n De Uso';
        $strings['ChangeConfiguration'] = 'Cambiar Configuraci&oacute;n';
        $strings['ResourceMinLength'] = 'Las reservas deben durar por lo menos %s';
        $strings['ResourceMinLengthNone'] = 'No hay duraci&oacute;n m&iacute;nima de reserva';
        $strings['ResourceMaxLength'] = 'Las reservas no pueden durar m&aacute;s de %s';
        $strings['ResourceMaxLengthNone'] = 'No hay duraci&oacute;n m&aacute;xima de reserva';
        $strings['ResourceRequiresApproval'] = 'Las reservas deben ser aprobadas';
        $strings['ResourceRequiresApprovalNone'] = 'Las reservas no requieren ser aprobadas';
        $strings['ResourcePermissionAutoGranted'] = 'El permiso es autom&aacute;ticamente concedido';
        $strings['ResourcePermissionNotAutoGranted'] = 'El permiso no es autom&aacute;ticamente concedido';
        $strings['ResourceMinNotice'] = 'Las reservas deben ser realizadas por lo menos %s ant&eacute;s del tiempo de inicio';
        $strings['ResourceMinNoticeNone'] = 'Las reservas se pueden realizar hasta el tiempo actual';
        $strings['ResourceMaxNotice'] = 'Las reservas no deben durar m&aacute;s de %s desde el tiempo actual';
        $strings['ResourceMaxNoticeNone'] = 'Las reservas pueden terminar en cualquier momento futuro';        
		$strings['ResourceBufferTime'] = 'Debe de haber %s entre reservas';
		$strings['ResourceBufferTimeNone'] = 'No hay tiempo entre reservas';		
		$strings['ResourceAllowMultiDay'] = 'Las reservas pueden extenderse a lo largo de d&iacute;as';
        $strings['ResourceNotAllowMultiDay'] = 'Las reservas no pueden extenderse a lo largo de d&iacute;as';
        $strings['ResourceCapacity'] = 'Este recurso tiene una capacidad de %s personas';
        $strings['ResourceCapacityNone'] = 'Este recurso tiene capacidad ilimitada';
        $strings['AddNewResource'] = 'A&ntilde;adir Nuevo Recurso';
        $strings['AddNewUser'] = 'A&ntilde;adir Nuevo Usuario';
        $strings['AddUser'] = 'A&ntilde;adir Usuario';
        $strings['Schedule'] = 'Planificaci&oacute;n';
        $strings['AddResource'] = 'A&ntilde;adir Recurso';
        $strings['Capacity'] = 'Capacidad';
        $strings['Access'] = 'Acceso';
        $strings['Duration'] = 'Duraci&oacute;n';
        $strings['Active'] = 'Activo';
        $strings['Inactive'] = 'Inactivo';
        $strings['ResetPassword'] = 'Reiniciar Contrase&ntilde;';
        $strings['LastLogin'] = '&Uacute;ltimo Inicio de Sesi&oacute;n';
        $strings['Search'] = 'Buscar';
        $strings['ResourcePermissions'] = 'Permisos del Recurso';
        $strings['Reservations'] = 'Reservas';
        $strings['Groups'] = 'Grupos';
        $strings['ResetPassword'] = 'Reiniciar Contrase&ntilde;';
        $strings['AllUsers'] = 'Todos Los Usuarios';
        $strings['AllGroups'] = 'Todos Los Grupos';
        $strings['AllSchedules'] = 'Todas Las Planificaciones';
        $strings['UsernameOrEmail'] = 'Nombre de Usuario o Email';
        $strings['Members'] = 'Miembros';
        $strings['QuickSlotCreation'] = 'Crear un intervalo de tiempo cada %s minutos entre %s y %s';
        $strings['ApplyUpdatesTo'] = 'Aplicar Actualizaciones A';
        $strings['CancelParticipation'] = 'Cancelar Participaci&oacute;n';
        $strings['Attending'] = 'Asistencia';
        $strings['QuotaConfiguration'] = 'En %s para %s usuarios en %s est&aacute;n limitados a %s %s por cada %s';
        $strings['reservations'] = 'reservas';
        $strings['ChangeCalendar'] = 'Cambiar Calendario';
        $strings['AddQuota'] = 'A&ntilde;adir Cuota';
        $strings['FindUser'] = 'Encontrar Usuario';
        $strings['Created'] = 'Creado';
        $strings['LastModified'] = '&Uacute;ltima Modificaci&oacute;n';
        $strings['GroupName'] = 'Nombre de Grupo';
        $strings['GroupMembers'] = 'Miembros del Grupo';
        $strings['GroupRoles'] = 'Roles del Grupo';
        $strings['GroupAdmin'] = 'Administrador del Grupo';
        $strings['Actions'] = 'Acciones';
        $strings['CurrentPassword'] = 'Contrase&ntilde;a Actual';
        $strings['NewPassword'] = 'Nueva Contrase&ntilde;a';
        $strings['InvalidPassword'] = 'La Contrase&ntilde;a actual es incorrecta';
        $strings['PasswordChangedSuccessfully'] = 'Tu Contrase&ntilde;a ha sido modificada con &eacute;xito';
        $strings['SignedInAs'] = 'Sesi&oacute;n iniciada por ';
        $strings['NotSignedIn'] = 'No has iniciado sesi&oacute;n';
        $strings['ReservationTitle'] = 'T&iacute;tulo de la reserva';
        $strings['ReservationDescription'] = 'Descripci&oacute;n de la reserva';
        $strings['ResourceList'] = 'Recursos a reservar';
        $strings['Accessories'] = 'Accesorios';
        $strings['Add'] = 'A&ntilde;adir';
        $strings['ParticipantList'] = 'Participantes';
        $strings['InvitationList'] = 'Invitados';
        $strings['AccessoryName'] = 'Nombre de Accesorio';
        $strings['QuantityAvailable'] = 'Cantidad Disponibles';
        $strings['Resources'] = 'Recursos';
        $strings['Participants'] = 'Participantes';
        $strings['User'] = 'Usuario';
        $strings['Resource'] = 'Recurso';
        $strings['Status'] = 'Estado';
        $strings['Approve'] = 'Aprobado';
        $strings['Page'] = 'P&aacute;gina';
        $strings['Rows'] = 'Filas';
        $strings['Unlimited'] = 'Ilimitado';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Direci&oacute;n de Correo';
        $strings['Phone'] = 'Tel&eacute;fono';
        $strings['Organization'] = 'Organizaci&oacute;n';
        $strings['Position'] = 'Nº de Socio';
        $strings['Language'] = 'Lenguaje';
        $strings['Permissions'] = 'Permisos';
        $strings['Reset'] = 'Reiniciar';
        $strings['FindGroup'] = 'Encontrar Grupo';
        $strings['Manage'] = 'Gestionar';
        $strings['None'] = 'Ninguno';
        $strings['AddToOutlook'] = 'A&ntilde;adir a Outlook';
        $strings['Done'] = 'Hecho';
        $strings['RememberMe'] = 'Recu&eacute;rdame';
        $strings['FirstTimeUser?'] = '¿Eres un usuario nuevo?';
        $strings['CreateAnAccount'] = 'Crear Cuenta';
        $strings['ViewSchedule'] = 'Ver Planificaci&oacute;n';
        $strings['ForgotMyPassword'] = 'He Olvidado Mi Contrase&ntilde;a';
        $strings['YouWillBeEmailedANewPassword'] = 'Se te enviar&aacute; una contrase&ntilde;a generada aleatoriamente.';
        $strings['Close'] = 'Cerrar';
        $strings['ExportToCSV'] = 'Exportar a CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Funcionando...';
        $strings['Login'] = 'Iniciar Sesi&oacute;n';
        $strings['AdditionalInformation'] = 'Informaci&oacute;n Adicional';
        $strings['AllFieldsAreRequired'] = 'Se requieren todos los campos';
        $strings['Optional'] = 'opcional';
        $strings['YourProfileWasUpdated'] = 'T&uacute; perfil fue actualizado';
        $strings['YourSettingsWereUpdated'] = 'T&uacute;s ajustes fueron actualizados';
        $strings['Register'] = 'Registrar';
        $strings['SecurityCode'] = 'C&oacute;digo de Seguridad';
        $strings['ReservationCreatedPreference'] = 'Cuando yo creo una reserva o una reserva es creada en mi nombre';
        $strings['ReservationUpdatedPreference'] = 'Cuando yo actualizado una reserva o una reserva es actualizada en mi nombre';
        $strings['ReservationApprovalPreference'] = 'Cuando mi reserva pendiente ha sido aprobada';
        $strings['PreferenceSendEmail'] = 'Env&iacute;ame un correo';
        $strings['PreferenceNoEmail'] = 'No me notifiques';
        $strings['ReservationCreated'] = '¡T&uacute; reserva ha sido creada con &eacute;xito!';
        $strings['ReservationUpdated'] = 'T&uacute; reserva ha sido actualizada con &eacute;xito!';
        $strings['ReservationRemoved'] = 'T&uacute; reserva ha sido eliminada';
        $strings['YourReferenceNumber'] = 'T&uacute; n&uacute;mero de referencia es %s';
        $strings['UpdatingReservation'] = 'Actualizando reserva';
        $strings['ChangeUser'] = 'Cambiar Usuario';
        $strings['MoreResources'] = 'M&aacute;s Recursos';
        $strings['ReservationLength'] = 'Duraci&oacute;n de la Reserva';
        $strings['ParticipantList'] = 'Lista de Participantes';
        $strings['AddParticipants'] = 'A&ntilde;adir Participantes';
        $strings['InviteOthers'] = 'Invitar A Otros';
        $strings['AddResources'] = 'A&ntilde;adir Resources';
        $strings['AddAccessories'] = 'A&ntilde;adir Accesorios';
        $strings['Accessory'] = 'Accesorio';
        $strings['QuantityRequested'] = 'Cantidad Requerida';
        $strings['CreatingReservation'] = 'Creando Reserva';
        $strings['UpdatingReservation'] = 'Actualizado Reserva';
        $strings['DeleteWarning'] = '¡Esta acci&oacute;n es permanente e irrecuperable!';
        $strings['DeleteAccessoryWarning'] = 'Al borrar este accesorio se eliminar&aacute; de todas las reservas.';
        $strings['AddAccessory'] = 'A&ntilde;adir Accesorio';
        $strings['AddBlackout'] = 'A&ntilde;adir No Disponibilidad';
        $strings['AllResourcesOn'] = 'Todos los Recursos Habilitados';
        $strings['Reason'] = 'Raz&oacute;n';
        $strings['BlackoutShowMe'] = 'Mu&eacute;strame reservas en conflicto';
        $strings['BlackoutDeleteConflicts'] = 'Borrar las reservas en conflicto';
        $strings['Filter'] = 'Filtrar';
        $strings['Between'] = 'Entre';
        $strings['CreatedBy'] = 'Creada Por';
        $strings['BlackoutCreated'] = 'No Disponibilidad Creada';
        $strings['BlackoutNotCreated'] = 'No se ha podido crear la No Dispinibilidad';
        $strings['BlackoutConflicts'] = 'Hay conflictos en la temporizaci&oacute;n de No Disponibilidad';
        $strings['BlackoutUpdated'] = 'No Disponibilidad actualizada';
        $strings['BlackoutNotUpdated'] = 'La No Disponibilidad no pudo ser actualizada';
        $strings['BlackoutConflicts'] = 'There are conflicting blackout times';
        $strings['ReservationConflicts'] = 'Hay tiempos de reserva en conflicto';
        $strings['UsersInGroup'] = 'Usuarios en este grupo';
        $strings['Browse'] = 'Navegar';
        $strings['DeleteGroupWarning'] = 'Al borrar este grupo se eliminar&aacute;n todos los permisos de los recursos asociados.  Los usuarios en este grupo pueden perder acceso a los recursos.';
        $strings['WhatRolesApplyToThisGroup'] = '¿Qu&eacute; roles aplican a este grupo?';
        $strings['WhoCanManageThisGroup'] = '¿Qui&eacute;n puede gestionar este grupo?';
        $strings['AddGroup'] = 'A&ntilde;adir Grupo';
        $strings['AllQuotas'] = 'Todas Las Cuotas';
        $strings['QuotaReminder'] = 'Recordar: Las cuoatas se fijan bas&aacute;ndose en la zona hora de las planificaciones.';
        $strings['AllReservations'] = 'Todas Las Reservas';
        $strings['PendingReservations'] = 'Reservas Pendientes';
        $strings['Approving'] = 'Aprobando';
        $strings['MoveToSchedule'] = 'Mover a planificaci&oacute;n';
        $strings['DeleteResourceWarning'] = 'Al borrar este recurso se eliminar&aacute;n todos los datos asociados, incluyendo';
        $strings['DeleteResourceWarningReservations'] = 'todos las pasadas, actuales y futuras resevas asociadas';
        $strings['DeleteResourceWarningPermissions'] = 'todas las asignaciones de permisos';
        $strings['DeleteResourceWarningReassign'] = 'Por favor reasigne todo lo que no quieras que sea borrado antes de continuar';
        $strings['ScheduleLayout'] = 'Distribuci&oacute;n (todas las veces %s)';
        $strings['ReservableTimeSlots'] = 'Intervalos de Tiempo Reservables';
        $strings['BlockedTimeSlots'] = 'Intervalos de Tiempo Bloqueados';
        $strings['ThisIsTheDefaultSchedule'] = 'Esta es la planificaci&oacute;n por defecto';
        $strings['DefaultScheduleCannotBeDeleted'] = 'La planificaci&oacute;n por defecto no se puede eliminar';
        $strings['MakeDefault'] = 'Hacer por Defecto';
        $strings['BringDown'] = 'Deshabilitar';
        $strings['ChangeLayout'] = 'Cambiar Distribuci&oacute;n';
        $strings['AddSchedule'] = 'A&ntilde;adir Planificaci&oacute;n';
        $strings['StartsOn'] = 'Comienza en';
        $strings['NumberOfDaysVisible'] = 'N&uacute;meros de D&iacute;as Visibles';
        $strings['UseSameLayoutAs'] = 'Usar la misma Distribuci&oacute;n que';
        $strings['Format'] = 'Formato';
        $strings['OptionalLabel'] = 'Etiqueta Opcional';
        $strings['LayoutInstructions'] = 'Introduce un intervalo de tiempo por l&iacute;nea.  Se deben proporcionar intervarlos de tiempo para las 24 horas del d&iacute;a comenzando y terminando a las 12:00 AM.';
        $strings['AddUser'] = 'A&ntilde;adir Usuario';
        $strings['UserPermissionInfo'] = 'El acceso real a los recursos puede ser diferente dependiendo de los roles del usuario, permisos de grupo, o ajustes externos de permisos';
        $strings['DeleteUserWarning'] = 'Al borrar este usuario se eliminar&aacute;n todos sus actuales, futuras y pasadas reservas.';
        $strings['AddAnnouncement'] = 'A&ntilde;adir Anuncio';
        $strings['Announcement'] = 'Anuncio';
        $strings['Priority'] = 'Prioridad';
        $strings['Reservable'] = 'Reservable';
        $strings['Unreservable'] = 'No Reservable';
        $strings['Reserved'] = 'Reservado';
        $strings['MyReservation'] = 'Mi Reserva';
        $strings['Pending'] = 'Pendiente';
        $strings['Past'] = 'Pasado';
        $strings['Restricted'] = 'Restringido';
		$strings['ViewAll'] = 'View All';
		$strings['MoveResourcesAndReservations'] = 'Mover recursos y reservas a';
		$strings['WeekOf'] = 'Semana de';
		$strings['Of']='de';

        // Errors
        $strings['LoginError'] = 'No se ha encontrado una correspondencia para tu Nombre de Usuario (DNI/NIE/CIF) y password';
        $strings['ReservationFailed'] = 'Tu reserva no se ha podido realizar';
        $strings['MinNoticeError'] = 'Esta reserva se debe realizar por anticipada.  La fecha m&aacute;s temprana que puede ser reservada %s.';
        $strings['MaxNoticeError'] = 'Esta reserva no se puede alargar tan lejos en el futuro. La &uacute;ltima fecha en la que se puede reservar es %s.';
        $strings['MinDurationError'] = 'Esta reserva debe durar al menos %s.';
        $strings['MaxDurationError'] = 'Esta reserva no puede durar m&aacute;s de %s.';
        $strings['ConflictingAccessoryDates'] = 'No hay suficientes de los siguientes accesorios:';
        $strings['NoResourcePermission'] = 'No tienes permisos para acceder uno o m&aacute;s de los recursos requeridos';
        $strings['ConflictingReservationDates'] = 'Hay conflictos en las reservas de las siguientes fechas:';
        $strings['StartDateBeforeEndDateRule'] = 'La fecha de inicio debe ser anterior que la fecha final';
        $strings['StartIsInPast'] = 'La fecha inicial no puede ser pasada';
        $strings['EmailDisabled'] = 'El administrador ha desactivado las notificaciones por email';
        $strings['ValidLayoutRequired'] = 'Se deben proporcionar intervalos de tiempo para las 24 horas del d&iacute;a comenando y terminando a las 12:00 AM.';
        $strings['CustomAttributeErrors'] = 'Hay problemas con los atributos adicionales que proporcionastes:';
        $strings['CustomAttributeRequired'] = '%s es un campo requerido.';
        $strings['CustomAttributeInvalid'] = 'El valor proporcionado para %s no es válido.';
        $strings['AttachmentLoadingError'] = 'Lo siento, hubo un problema con el fichero solicitado.';
        $strings['InvalidAttachmentExtension'] = 'Solamente puedes subir ficheros de tipo: %s';
        $strings['InvalidStartSlot'] = 'La fecha de comienzo y tiempo solicitado no es válido.';
        $strings['InvalidEndSlot'] = 'La fecha de finalización y tiempo solicitado no es válido.';
        $strings['MaxParticipantsError'] = '%s puede suportar %s participantes solamente.';
        $strings['ReservationCriticalError'] = 'Hubo un error cr&iacute;tico guardando tu reserva. Si continua, contacta con el administrador del sistema.';
        $strings['InvalidStartReminderTime'] = 'La hora de comienzo del recordatorio no es válida.';
        $strings['InvalidEndReminderTime'] = 'La hora de finalización del recordatorio no es válida.';
        $strings['QuotaExceeded'] = 'L&iacute;mite de cuota excedido.';
        $strings['MultiDayRule'] = '%s no permite reservar a través de d&iacute;as.';
        $strings['InvalidReservationData'] = 'Hubo problemas con tu solicitud de reserva.';
        $strings['PasswordError'] = 'La contrase&ntilde;a debe contener al menos %s letras y al menos %s números.';
        $strings['PasswordErrorRequirements'] = 'La contrase&ntilde;a debe contener una combinación de al menos %s letras mayúsculas y minusculas y %s números.';
        $strings['NoReservationAccess'] = 'No estas permitido para cambiar esta reserva.';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Crear Reserva';
        $strings['EditReservation'] = 'Editar Reserva';
        $strings['LogIn'] = 'Iniciar Sesi&oacute;n';
        $strings['ManageReservations'] = 'Gestionar Reservas';
        $strings['AwaitingActivation'] = 'Esperando Activaci&oacute;n';
        $strings['PendingApproval'] = 'Pendiente De Aprobaci&oacute;n';
        $strings['ManageSchedules'] = 'Planificaciones';
        $strings['ManageResources'] = 'Recursos';
        $strings['ManageAccessories'] = 'Accesorios';
        $strings['ManageUsers'] = 'Usuarios';
        $strings['ManageGroups'] = 'Grupos';
        $strings['ManageQuotas'] = 'Cuotas';
        $strings['ManageBlackouts'] = 'Agenda de No Disponibilidad';
        $strings['MyDashboard'] = 'Mi Tabl&oacute;n';
        $strings['ServerSettings'] = 'Ajustes De Servidor';
        $strings['Dashboard'] = 'Tabl&oacute;n';
        $strings['Help'] = 'Ayuda';
        $strings['Bookings'] = 'Reservas';
        $strings['Schedule'] = 'Planificaci&oacute;n';
        $strings['Reservations'] = 'Reservas';
        $strings['Account'] = 'Cuenta';
        $strings['EditProfile'] = 'Editar Mi Perfil';
        $strings['FindAnOpening'] = 'Encontrar Un Hueco';
        $strings['OpenInvitations'] = 'Invitaciones Pendientes';
        $strings['MyCalendar'] = 'Mi Calendario';
        $strings['ResourceCalendar'] = 'Calendario de Recursos';
        $strings['Reservation'] = 'Nueva Reserva';
        $strings['Install'] = 'Instalaci&oacute;n';
        $strings['ChangePassword'] = 'Cambiar Contrase&ntilde;a';
        $strings['MyAccount'] = 'Mi Cuenta';
        $strings['Profile'] = 'Perfil';
        $strings['ApplicationManagement'] = 'Gesti&oacute;n de la Aplicaci&oacute;n';
        $strings['ForgotPassword'] = 'Contrase&ntilde;a Olvidada';
        $strings['NotificationPreferences'] = 'Preferencias de Notificaci&oacute;n';
        $strings['ManageAnnouncements'] = 'Anuncios';
        //

        // Day representations
        $strings['DaySundaySingle'] = 'D';
        $strings['DayMondaySingle'] = 'L';
        $strings['DayTuesdaySingle'] = 'M';
        $strings['DayWednesdaySingle'] = 'M';
        $strings['DayThursdaySingle'] = 'J';
        $strings['DayFridaySingle'] = 'V';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'Dom';
        $strings['DayMondayAbbr'] = 'Lun';
        $strings['DayTuesdayAbbr'] = 'Mar';
        $strings['DayWednesdayAbbr'] = 'Mie';
        $strings['DayThursdayAbbr'] = 'Jue';
        $strings['DayFridayAbbr'] = 'Vie';
        $strings['DaySaturdayAbbr'] = 'Sab';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Tu Reserva Ha Sido Aprobada';
        $strings['ReservationCreatedSubject'] = 'Tu Reserva Ha Sido Creada';
        $strings['ReservationUpdatedSubject'] = 'Tu Reserva Ha Sido Actualizada';
        $strings['ReservationCreatedAdminSubject'] = 'Notificaci&oacute;n: Se Ha Creado Una Reserva';
        $strings['ReservationUpdatedAdminSubject'] = 'Notificaci&oacute;n: Se Ha Creado Actualizado Reserva';
        $strings['ParticipantAddedSubject'] = 'Notificaci&oacute;n de Participaci&oacute;n En Reserva';
        $strings['InviteeAddedSubject'] = 'Invitaci&oacute;n a Reserva';
        $strings['ResetPassword'] = 'Petici&oacute;n de Reinicio de Contrase&ntilde;a';
        $strings['ForgotPasswordEmailSent'] = 'Se ha enviado un email a la direcci&oacute;n proporcionada con instrucciones para reiniciar tu contrase&ntilde;a';
		$strings['ActivationEmailSent'] = 'Tu recibiras un email de activación en breve.';
		$strings['AccountActivationError'] = 'Lo sentimos, no podemos activar tu cuenta.';
		
        //
		
		// Adapting Booked: missing strings
		$strings['Responsibilities'] = 'Administraci&oacute;n';
		$strings['GroupReservations'] = 'Gestionar Reservas';
		$strings['ResourceReservations'] = 'Reservas por recursos';
		$strings['Customization'] = 'Personalizaci&oacute;n';
		$strings['ScheduleReservations'] = 'Historial de Reservas';
				
		$strings['Reports'] = 'Informes';
		$strings['GenerateReport'] = 'Crear nuevo informe';
		$strings['MySavedReports'] = 'Mis informes';
		$strings['CommonReports'] = 'Informes comunes';
		
		$strings['BulkResourceUpdate'] = 'Ver toda la configuraci&oacute;n del recurso';
		$strings['ResourceType'] = 'Tipo de Recurso';
		$strings['AppliesTo'] = 'Aplicar a';
		$strings['UniquePerInstance'] = 'Unico por instancia';
		$strings['AddResourceType'] = 'A&ntilde;adir Tipo de Recurso';
		$strings['NoResourceTypeLabel'] = '(no hay tipo de recurso configurado)';
		$strings['ClearFilter'] = 'Limpiar Filtro';
		$strings['MinimumCapacity'] = 'Capacidad M&iacute;nima';
		$strings['Color'] = 'Color';
		$strings['Available'] = 'Disponible';
		$strings['Unavailable'] = 'No disponible';
		$strings['Hidden'] = 'Oculto';
		$strings['ResourceStatus'] = 'Estado del Recurso';
		$strings['CurrentStatus'] = 'Estado actual';
		$strings['File'] = 'Fichero';
		$strings['Unchanged'] = 'Sin cambios';
		$strings['Common'] = 'Común';
		$strings['AdvancedFilter'] = 'Filtro Avanzado';
		$strings['SortOrder'] = 'Orden';
		
		$strings['TurnOffSubscription'] = 'Desactivar suscripciones en Calendario';
		$strings['TurnOnSubscription'] = 'Activar suscripciones en Calendario';
		$strings['SubscribeToCalendar'] = 'Subscribirse a este Calendario';
		$strings['SubscriptionsAreDisabled'] = 'El administrador ha desabilitado las subcripciones a este calendario';
		$strings['NoResourceAdministratorLabel'] = '(No hay administrador de Recurso)';
		$strings['WhoCanManageThisResource'] = '¿Quien puede administrar este Recurso?';
		$strings['ResourceAdministrator'] = 'Administrador de Recurso';

        $strings['Private'] = 'Privado';
        $strings['Accept'] = 'Accepto';
        $strings['Decline'] = 'Disminución';
        $strings['ShowFullWeek'] = 'Mostrar semana completa';
        $strings['CustomAttributes'] = 'Personalizar atributos';
        $strings['AddAttribute'] = 'A&ntilde;adir un atributo';
        $strings['EditAttribute'] = 'Editar un atributu';
        $strings['DisplayLabel'] = 'Etiqueta visible';
        $strings['Type'] = 'Tipo';
        $strings['Required'] = 'Requerido';
        $strings['ValidationExpression'] = 'Validation Expression';
        $strings['PossibleValues'] = 'Posibles valores';
        $strings['SingleLineTextbox'] = 'Caja de texto de una sola linea';
        $strings['MultiLineTextbox'] = 'Caja de texto de múltiples lineas';
        $strings['Checkbox'] = 'Checkbox';
		
		$strings['Title'] = 'Titulo';
		$strings['AdditionalAttributes'] = 'Atributos adicionales';
		$strings['True'] = 'Verdadero';
		$strings['False'] = 'Falso';
		$strings['Attachments'] = 'Adjuntos';
		$strings['AttachFile'] = 'Adjuntar fichero';
		$strings['Maximum'] = 'máximo';
		$strings['NoScheduleAdministratorLabel'] = 'No hay Administrador de calendario';
		$strings['ScheduleAdministrator'] = 'Administrador de calendario';
		$strings['Total'] = 'Total';
		$strings['QuantityReserved'] = 'Cantidad Reservada';
		$strings['AllAccessories'] = 'Todos los Accesorios';
		$strings['GetReport'] = 'Conseguir Informe';
		$strings['NoResultsFound'] = 'No hemos encontrado coincidencias';
		
		$strings['SaveThisReport'] = 'Guardar este Informe';
		$strings['ReportSaved'] = 'Informe guardado!';
		$strings['EmailReport'] = 'Email Informe';
		$strings['ReportSent'] = 'Informe enviado!';
		$strings['RunReport'] = 'Ejecutar Informe';
		$strings['NoSavedReports'] = 'Tu no has guardado el informe.';
		$strings['CurrentWeek'] = 'Semana actual';
		$strings['CurrentMonth'] = 'Mes actual';
		$strings['AllTime'] = 'Todo el tiempo';
		$strings['FilterBy'] = 'Filtrar por';
		$strings['Select'] = 'Seleccionar';
		$strings['List'] = 'Lista';
		$strings['TotalTime'] = 'Tiempo Total';
		$strings['Count'] = 'Cuenta';
		$strings['Usage'] = 'Uso';
		$strings['AggregateBy'] = 'Agregar por';
		$strings['Range'] = 'Rango';
		$strings['Choose'] = 'Elegir';
		$strings['All'] = 'Todo';
		$strings['ViewAsChart'] = 'Ver como gráfico';
		$strings['ReservedResources'] = 'Recurso Reservado';
		$strings['ReservedAccessories'] = 'Accesorio Reservado';
		$strings['ResourceUsageTimeBooked'] = 'Uso de recurso - Tiempo Reservado';
		$strings['ResourceUsageReservationCount'] = 'Uso de recursos - N&uacute;mero de Reservas';
		$strings['Top20UsersTimeBooked'] = 'Top 20 - Tiempo reservado';
		$strings['Top20UsersReservationCount'] = 'Top 20 - N&uacute;mero de Reservas';
		$strings['ConfigurationUpdated'] = 'El fichero de configuraci&oacute;n fue actualizado';
		$strings['ConfigurationUiNotEnabled'] = 'Esta página no puede ser accedida porque $conf[\'settings\'][\'pages\'][\'enable.configuration\'] es configurado a Falso.';
		$strings['ConfigurationFileNotWritable'] = 'El fichero de configuraci&oacute;n no es editable. Por favor chequee los permisos de este fichero e intentelo de nuevo.';
		$strings['ConfigurationUpdateHelp'] = 'Refer to the Configuration section of the <a target=_blank href=%s>Help File</a> for documentation on these settings.';
		$strings['GeneralConfigSettings'] = 'settings';
		$strings['UseSameLayoutForAllDays'] = 'Usar la misma Distribuci&oacute;n para todos los d&iacute;as';
		$strings['LayoutVariesByDay'] = 'Distribuci&oacute;n por d&iacute;as';

        $strings['Administration'] = 'Administraci&oacute;n';
        $strings['About'] = 'Sobre';
        $strings['Private'] = 'Privado';
        $strings['Participant'] = 'Participantes';
        
        $strings['MakeDefaultSchedule'] = 'Hacer esta planificaci&oacute;n mi Planificaci&oacute;n por defecto';
        $strings['DefaultScheduleSet'] = 'Esta es tu planificación por defecto ahora';
        $strings['FlipSchedule'] = 'Flip the schedule layout';
        $strings['StandardScheduleDisplay'] = 'Use la vista de programación estandar';
        $strings['TallScheduleDisplay'] = 'Use la vista de programación alargada';
        $strings['WideScheduleDisplay'] = 'Use la vista de programación ancha';
        $strings['CondensedWeekScheduleDisplay'] = 'Use la vista de programación de semana condensada';

        $strings['ResourceGroupHelp1'] = 'Arrastre los grupos de recursos a organizar.';
        $strings['ResourceGroupHelp2'] = 'Haga click con el boton derecho sobre el nombre de un grupo de recursos para acciones adicionales.';
        $strings['ResourceGroupHelp3'] = 'Arrastre los recursos para añadirlos a los grupos.';
        $strings['ResourceGroupWarning'] = 'Si usa los grupos de recursos, cada recurso debe estar asignado a almenos un grupo. Los recursos no asignaods no estarán disponibles para ser reservados.';
               
        $strings['ManageConfiguration'] = 'Application Configuration';
        $strings['LookAndFeel'] = 'Look and Feel';
        $strings['ManageResourceGroups'] = 'Grupos de recursos';
        $strings['ManageResourceTypes'] = 'Tipos de recursos';
        $strings['ManageResourceStatus'] = 'Estados de recursos';

        $strings['Group'] = 'Grupo';
        $strings['Address'] = 'Direcci&oacute;n';
        $strings['Province'] = 'Provincia';
        $strings['CIF'] = 'CIF/NIF';
        $strings['Date_effective'] = 'Fecha de renovaci&oacute;n';

        $strings['acceptTerm1'] = 'Acepto las ';
        $strings['acceptTerm2'] = 'Términos y condiciones de uso';

        $strings['Insurances'] = 'Aseguradoras';
        $strings['Specialties'] = 'Especialidades';

        $strings['FirstTimeProfesional?'] = '¿Eres un profesional nuevo?';

        $strings['LoginError2'] = 'Tu suscripción ha caducado, debes ponerte en contacto con el administrador.';
       
				
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
        $days['full'] = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        // The three letter abbreviation
        $days['abbr'] = array('Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
        // The two letter abbreviation
        $days['two'] = array('Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa');
        // The one letter abbreviation
        $days['letter'] = array('D', 'L', 'M', 'M', 'J', 'V', 'S');

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
        $months['full'] = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Deciembre');
        // The three letter month name
        $months['abbr'] = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');

        $this->Months = $months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    protected function _GetHtmlLangCode()
    {
        return 'es';
    }
}

?>