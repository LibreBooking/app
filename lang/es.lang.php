<?php
/**
* Spanish (es) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Josue Rojas <josue_rojas@hotmail.com>
* @version 05-14-06
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all of the strings that are used throughout phpScheduleit.
// Please save the translated file as '2 letter language code'.lang.php.  For example, en.lang.php.
// 
// To make phpScheduleIt available in another language, simply translate each
//  of the following strings into the appropriate one for the language.  If there
//  is no direct translation, please provide the closest translation.  Please be sure
//  to make the proper additions the /config/langs.php file (instructions are in the file).
//  Also, please add a help translation for your language using en.help.php as a base.
//
// You will probably keep all sprintf (%s) tags in their current place.  These tags
//  are there as a substitution placeholder.  Please check the output after translating
//  to be sure that the sentences make sense.
//
// + Please use single quotes ' around all $strings.  If you need to use the ' character, please enter it as \'
// + Please use double quotes " around all $email.  If you need to use the " character, please enter it as \"
//
// + For all $dates please use the PHP strftime() syntax
//    http://us2.php.net/manual/en/function.strftime.php
//
// + Non-intuitive parts of this file will be explained with comments.  If you
//    have any questions, please email lqqkout13@users.sourceforge.net
//    or post questions in the Developers forum on SourceForge
//    http://sourceforge.net/forum/forum.php?forum_id=331297
///////////////////////////////////////////////////////////

////////////////////////////////
/* Do not modify this section */
////////////////////////////////
global $strings;			  //
global $email;				  //
global $dates;				  //
global $charset;			  //
global $letters;			  //
global $days_full;			  //
global $days_abbr;			  //
global $days_two;			  //
global $days_letter;		  //
global $months_full;		  //
global $months_abbr;		  //
global $days_letter;		  //
/******************************/

// Charset for this language
// 'iso-8859-1' will work for most languages
$charset = 'iso-8859-1';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element 
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
// The three letter abbreviation
$days_abbr = array('Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
// The two letter abbreviation
$days_two  = array('Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa');
// The one letter abbreviation
$days_letter = array('D', 'L', 'M', 'M', 'J', 'V', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
// The three letter month name
$months_abbr = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%m/%d/%Y';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%m/%d/%Y @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%A %m/%d/%Y';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%A,<br/>%m/%d/%Y';
// Date on top-right of each page
$dates['header'] = '%A, %B %d, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%m %d %Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = 'horas';
$strings['minutes'] = 'minutos';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'dd';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'aaaa';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Administrador';
$strings['Welcome Back'] = 'Bienvenido, %s';
$strings['Log Out'] = 'Cerrar Sesión';
$strings['My Control Panel'] = 'Mi Pánel de Control';
$strings['Help'] = 'Ayuda';
$strings['Manage Schedules'] = 'Administrar Horarios';
$strings['Manage Users'] ='Administrar Usuarios';
$strings['Manage Resources'] ='Administrar Recursos';
$strings['Manage User Training'] ='Administrar Entrenamiento de Usuarios';
$strings['Manage Reservations'] ='Administrar Reservas';
$strings['Email Users'] ='Email a Usuarios';
$strings['Export Database Data'] = 'Exportar Base de Datos';
$strings['Reset Password'] = 'Establecer Contraseña';
$strings['System Administration'] = 'Administración del Sistema';
$strings['Successful update'] = 'Actualización exitosa';
$strings['Update failed!'] = 'Fallo la actualización!';
$strings['Manage Blackout Times'] = 'Administrar Tiempos Muertos';
$strings['Forgot Password'] = 'Olvidó Su Contraseña';
$strings['Manage My Email Contacts'] = 'Administrar Mis Contactos Email';
$strings['Choose Date'] = 'Escoja la Fecha';
$strings['Modify My Profile'] = 'Modificar Mi Perfil';
$strings['Register'] = 'Registrarse';
$strings['Processing Blackout'] = 'Procesando Tiempo Muerto';
$strings['Processing Reservation'] = 'Procesando Reserva';
$strings['Online Scheduler [Read-only Mode]'] = 'Horario en Línea [Modo sólo Consulta]';
$strings['Online Scheduler'] = 'Horario en Línea';
$strings['phpScheduleIt Statistics'] = 'Estadísticas Administrativas';
$strings['User Info'] = 'Datos de Usuario:';

$strings['Could not determine tool'] = 'No se puede determinar la herramienta. Por favor vuelva a Mi Pánel de Control e intente de nuevo más tarde.';
$strings['This is only accessable to the administrator'] = 'Esto sólo está disponible para el Administrador';
$strings['Back to My Control Panel'] = 'Volver a Mi Pánel de Control';
$strings['That schedule is not available.'] = 'Ese horario no está disponible.';
$strings['You did not select any schedules to delete.'] = 'Usted no ha seleccionado horarios para borrar.';
$strings['You did not select any members to delete.'] = 'Usted no ha seleccionado miembros para borrar.';
$strings['You did not select any resources to delete.'] = 'Usted no ha seleccionado recursos para borrar';
$strings['Schedule title is required.'] = 'Es necesario un nombre para el horario.';
$strings['Invalid start/end times'] = 'Las horas de inicio o fin no son válidas.';
$strings['View days is required'] = 'Es necesario el número de días visibles';
$strings['Day offset is required'] = 'Es necesario indicar el primer día de la semana';
$strings['Admin email is required'] = 'Es necesario el email administrativo';
$strings['Resource name is required.'] = 'Es necesario un nombre para el recurso.';
$strings['Valid schedule must be selected'] = 'Debe seleccionar un horario válido';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'La duración mínima de la reserva debe se menor o igual que la duración máxima de la reserva.';
$strings['Your request was processed successfully.'] = 'Su solicitud fue procesada exitosamente.';
$strings['Go back to system administration'] = 'Vuelva a la administración del sistema';
$strings['Or wait to be automatically redirected there.'] = 'O espere para ser dirigido automáticamente.';
$strings['There were problems processing your request.'] = 'Se presentaron inconvenientes procesando su solicitud.';
$strings['Please go back and correct any errors.'] = 'Por favor vuelva atrás y corrija los errores que existan.';
$strings['Login to view details and place reservations'] = 'Inicie sesión para ver los detalles y hacer reservas';
$strings['Memberid is not available.'] = 'El id de usuario: %s no está disponible.';

$strings['Schedule Title'] = 'Nombre del Horario';
$strings['Start Time'] = 'Hora de Inicio';
$strings['End Time'] = 'Hora de Finalización';
$strings['Time Span'] = 'Franjas de Tiempo';
$strings['Weekday Start'] = 'Primer día de la Semana';
$strings['Admin Email'] = 'Email Administrativo';

$strings['Default'] = 'Por Defecto';
$strings['Reset'] = 'Restablecer';
$strings['Edit'] = 'Editar';
$strings['Delete'] = 'Borrar';
$strings['Cancel'] = 'Cancelar';
$strings['View'] = 'Verificar';
$strings['Modify'] = 'Modificar';
$strings['Save'] = 'Guardar';
$strings['Back'] = 'Volver';
$strings['Next'] = 'Siguiente';
$strings['Close Window'] = 'Cerrar Ventana';
$strings['Search'] = 'Buscar';
$strings['Clear'] = 'Limpiar';

$strings['Days to Show'] = 'Días visibles';
$strings['Reservation Offset'] = 'Espacio entre Reservas';
$strings['Hidden'] = 'Oculto';
$strings['Show Summary'] = 'Mostrar Descripción';
$strings['Add Schedule'] = 'Adicionar Horario';
$strings['Edit Schedule'] = 'Cambiar Horario';
$strings['No'] = 'No';
$strings['Yes'] = 'Si';
$strings['Name'] = 'Nombre';
$strings['First Name'] = 'Nombres';
$strings['Last Name'] = 'Apellidos';
$strings['Resource Name'] = 'Nombre del Recurso';
$strings['Email'] = 'Email';
$strings['Institution'] = 'Institución';
$strings['Phone'] = 'Teléfono';
$strings['Password'] = 'Password';
$strings['Permissions'] = 'Permisos';
$strings['View information about'] = 'Ver la información de %s %s';
$strings['Send email to'] = 'Enviar email a %s %s';
$strings['Reset password for'] = 'Restablecer el password para %s %s';
$strings['Edit permissions for'] = 'Editar permisos para %s %s';
$strings['Position'] = 'Cargo';
$strings['Password (6 char min)'] = 'Password (%s letras min.)';
$strings['Re-Enter Password'] = 'Confirme el Password';

$strings['Sort by descending last name'] = 'Ordenar por apellido en forma descendente';
$strings['Sort by descending email address'] = 'Ordenar por email en forma descendente';
$strings['Sort by descending institution'] = 'Ordenar por institución en forma descendente';
$strings['Sort by ascending last name'] = 'Ordenar por apellido en forma ascendente';
$strings['Sort by ascending email address'] = 'Ordenar por email en forma ascendente';
$strings['Sort by ascending institution'] = 'Ordenar por institución en forma ascendente';
$strings['Sort by descending resource name'] = 'Ordenar por nombre del recurso en forma descendente';
$strings['Sort by descending location'] = 'Ordenar por ubicación en forma descendente';
$strings['Sort by descending schedule title'] = 'Ordenar por nombre del horario en forma descendente';
$strings['Sort by ascending resource name'] = 'Ordenar por nombre del recurso en forma ascendente';
$strings['Sort by ascending location'] = 'Ordenar por ubicación en forma ascendente';
$strings['Sort by ascending schedule title'] = 'Ordenar por nombre del horario en forma ascendente';
$strings['Sort by descending date'] = 'Ordenar por fecha en forma descendente';
$strings['Sort by descending user name'] = 'Ordenar por nombre de usuario en forma descendente';
$strings['Sort by descending start time'] = 'Ordenar por fecha inicial en forma descendente';
$strings['Sort by descending end time'] = 'Ordenar por fecha final en forma descendente';
$strings['Sort by ascending date'] = 'Ordenar por fecha en forma ascendente';
$strings['Sort by ascending user name'] = 'Ordenar por nombre de usuario en forma ascendente';
$strings['Sort by ascending start time'] = 'Ordenar por fecha inicial en forma ascendente';
$strings['Sort by ascending end time'] = 'Ordenar por fecha final en forma descendente';
$strings['Sort by descending created time'] = 'Ordenar por fecha de solicitud en forma ascendente';
$strings['Sort by ascending created time'] = 'Ordenar por fecha de solicitud en forma descendente';
$strings['Sort by descending last modified time'] = 'Ordenar por fecha de modificación en forma ascendente';
$strings['Sort by ascending last modified time'] = 'Ordenar por fecha de modificación en forma descendente';

$strings['Search Users'] = 'Buscar Usuarios';
$strings['Location'] = 'Ubicación';
$strings['Schedule'] = 'Horario';
$strings['Phone'] = 'Teléfono';
$strings['Notes'] = 'Notas';
$strings['Status'] = 'Estado';
$strings['All Schedules'] = 'Todos los Horarios';
$strings['All Resources'] = 'Todos los Recursos';
$strings['All Users'] = 'Todos los Usuarios';

$strings['Edit data for'] = 'Editar la información de %s';
$strings['Active'] = 'Activo';
$strings['Inactive'] = 'Inactivo';
$strings['Toggle this resource active/inactive'] = 'Cambiar este Recuso entre activo/inactivo';
$strings['Minimum Reservation Time'] = 'Tiempo Mínimo de Reserva';
$strings['Maximum Reservation Time'] = 'Tiempo Máximo de Reserva';
$strings['Auto-assign permission'] = 'Permiso de Auto-asignación';
$strings['Add Resource'] = 'Añadir un Recurso';
$strings['Edit Resource'] = 'Editar un Recurso';
$strings['Allowed'] = 'Permitido';
$strings['Notify user'] = 'Notificar al usuario';
$strings['User Reservations'] = 'Reservas de Usuario';
$strings['Date'] = 'Fecha';
$strings['User'] = 'Usuario';
$strings['Email Users'] = 'Enviar un Email a los Usuarios';
$strings['Subject'] = 'Asunto';
$strings['Message'] = 'Mensaje';
$strings['Please select users'] = 'Por favor seleccione los usuarios';
$strings['Send Email'] = 'Enviar Email';
$strings['problem sending email'] = 'Lo siento, hubo un problema enviando el email. Por favor intente más tarde.';
$strings['The email sent successfully.'] = 'El email fue enviado exitosamente.';
$strings['do not refresh page'] = 'Por favor <u>no</u> use Actualizar en esta página. Si lo hace, el email se enviará otra vez.';
$strings['Return to email management'] = 'Volver a administración de emails';
$strings['Please select which tables and fields to export'] = 'Por favor indique cuáles tablas y campos desea exportar:';
$strings['all fields'] = '- todos los campos -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Texto simple';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Exportar Datos';
$strings['Reset Password for'] = 'Restablecer Password de %s';
$strings['Please edit your profile'] = 'Por favor modifique su perfil';
$strings['Please register'] = 'Por favor regístrese';
$strings['Email address (this will be your login)'] = 'Dirección de Email (Este será su nombre de usuario)';
$strings['Keep me logged in'] = 'Mantener la sesión abierta <br/>(requiere cookies)';
$strings['Edit Profile'] = 'Editar Perfil';
$strings['Register'] = 'Registrarse';
$strings['Please Log In'] = 'Por favor inicie sesión';
$strings['Email address'] = 'Dirección de Email';
$strings['Password'] = 'Password';
$strings['First time user'] = 'Usuario por primera vez?';
$strings['Click here to register'] = 'Regístrese haciendo clic aquí';
$strings['Register for phpScheduleIt'] = 'Registrarse en phpScheduleIt';
$strings['Log In'] = 'Iniciar Sesión';
$strings['View Schedule'] = 'Ver Agenda';
$strings['View a read-only version of the schedule'] = 'Ver la Agenda -Sólo Consulta-';
$strings['I Forgot My Password'] = 'Olvidé mi Password';
$strings['Retreive lost password'] = 'Recuperar password perdido';
$strings['Get online help'] = 'Obtener ayuda en línea';
$strings['Language'] = 'Idioma';
$strings['(Default)'] = '(por defecto)';

$strings['My Announcements'] = 'Mis anuncios';
$strings['My Reservations'] = 'Mis Reservas';
$strings['My Permissions'] = 'Mis Permisos';
$strings['My Quick Links'] = 'Mis Accesos Directos';
$strings['Announcements as of'] = 'Anuncios para %s';
$strings['There are no announcements.'] = 'No hay anuncios.';
$strings['Resource'] = 'Recurso';
$strings['Created'] = 'Creado';
$strings['Last Modified'] = 'Modificado por última vez';
$strings['View this reservation'] = 'Ver esta reserva';
$strings['Modify this reservation'] = 'Modificar esta reserva';
$strings['Delete this reservation'] = 'Borrar esta reserva';
$strings['Bookings'] = 'Reservaciones';
$strings['Change My Profile Information/Password'] = 'Change Profile';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Preferences';				// @since 1.2.0
$strings['Mass Email Users'] = 'Enviar un Email a todos los Usuarios';
$strings['Search Scheduled Resource Usage'] = 'Search Reservations';		// @since 1.2.0
$strings['Export Database Content'] = 'Exportar el Contenido de la Base de Datos';
$strings['View System Stats'] = 'Ver Estadísticas del Sistema';
$strings['Email Administrator'] = 'Enviar un Email al Administrador';

$strings['Email me when'] = 'Enviarme un Email cuando:';
$strings['I place a reservation'] = 'Yo haga una reserva';
$strings['My reservation is modified'] = 'Se modifique mi reserva';
$strings['My reservation is deleted'] = 'Se borre mi reserva';
$strings['I prefer'] = 'Prefiero:';
$strings['Your email preferences were successfully saved'] = 'Sus preferencias de email han sido guardadas';
$strings['Return to My Control Panel'] = 'Volver a Mi Pánel de Control';

$strings['Please select the starting and ending times'] = 'Por favor indique las fechas inicial y final:';
$strings['Please change the starting and ending times'] = 'Por favor cambie las fechas inicial y final:';
$strings['Reserved time'] = 'Tiempo reservado:';
$strings['Minimum Reservation Length'] = 'Tiempo Mínimo de Reserva:';
$strings['Maximum Reservation Length'] = 'Tiempo Máximo de Reserva:';
$strings['Reserved for'] = 'Reservado para:';
$strings['Will be reserved for'] = 'Será reservado para:';
$strings['N/A'] = 'N/D';
$strings['Update all recurring records in group'] = 'Actualizar todos los registros recurrentes a la vez?';
$strings['Delete?'] = 'Borrar?';
$strings['Never'] = '-- Nunca --';
$strings['Days'] = 'Días';
$strings['Weeks'] = 'Semanas';
$strings['Months (date)'] = 'Meses (fecha)';
$strings['Months (day)'] = 'Meses (día)';
$strings['First Days'] = 'Primer Día';
$strings['Second Days'] = 'Segundo Día';
$strings['Third Days'] = 'Tercer Día';
$strings['Fourth Days'] = 'Cuarto Día';
$strings['Last Days'] = 'Último Día';
$strings['Repeat every'] = 'Repetir cada:';
$strings['Repeat on'] = 'Repetir en:';
$strings['Repeat until date'] = 'Repetir hasta esta fecha:';
$strings['Choose Date'] = 'Elegir Fecha';
$strings['Summary'] = 'Descripción';

$strings['View schedule'] = 'Ver Agenda:';
$strings['My Reservations'] = 'Mis Reservas';
$strings['My Past Reservations'] = 'Mis Reservas Pasadas';
$strings['Other Reservations'] = 'Otras Reservas';
$strings['Other Past Reservations'] = 'Otras Reservas Pasadas';
$strings['Blacked Out Time'] = 'Tiempo Muerto';
$strings['Set blackout times'] = 'Establecer tiempo muerto para %s en %s'; 
$strings['Reserve on'] = 'Reservar %s en %s';
$strings['Prev Week'] = '« Semana Ant.';
$strings['Jump 1 week back'] = 'Volver 1 semana atrás';
$strings['Prev days'] = '‹ %d días ant.';
$strings['Previous days'] = '‹ %d días anteriores';
$strings['This Week'] = 'Esta Semana';
$strings['Jump to this week'] = 'Ir a esta semana';
$strings['Next days'] = '%d días siguientes ›';
$strings['Next Week'] = 'Siguiente Semana »';
$strings['Jump To Date'] = 'Ir a una Fecha';
$strings['View Monthly Calendar'] = 'Ver Calendario Mensual';
$strings['Open up a navigational calendar'] = 'Abrir una Calendario para Navegar';

$strings['View stats for schedule'] = 'Ver estadísticas del horario:';
$strings['At A Glance'] = 'En Resumen';
$strings['Total Users'] = 'Total de Usuarios:';
$strings['Total Resources'] = 'Total de Recursos:';
$strings['Total Reservations'] = 'Total de Reservas:';
$strings['Max Reservation'] = 'Reserva Máxima:';
$strings['Min Reservation'] = 'Reserva Mínima:';
$strings['Avg Reservation'] = 'Reserva Promedio:';
$strings['Most Active Resource'] = 'Recurso más Activo:';
$strings['Most Active User'] = 'Usuario más Activo:';
$strings['System Stats'] = 'Estadísticas del Sistema';
$strings['phpScheduleIt version'] = 'Versión de phpScheduleIt:';
$strings['Database backend'] = 'Base de Datos:';
$strings['Database name'] = 'Nombre de Base de Datos:';
$strings['PHP version'] = 'Versión de PHP:';
$strings['Server OS'] = 'Sistema del Servidor:';
$strings['Server name'] = 'Nombre del Servidor:';
$strings['phpScheduleIt root directory'] = 'Directorio raíz de phpScheduleIt:';
$strings['Using permissions'] = 'Permisos de Uso:';
$strings['Using logging'] = 'Log de Uso:';
$strings['Log file'] = 'Archivo de Log:';
$strings['Admin email address'] = 'Dirección email del administrador:';
$strings['Tech email address'] = 'Dirección email Técnico:';
$strings['CC email addresses'] = 'Direcciones email para copias (CC):';
$strings['Reservation start time'] = 'Hora inicial de reserva:';
$strings['Reservation end time'] = 'Hora final de reserva:';
$strings['Days shown at a time'] = 'Días mostrados a la vez:';
$strings['Reservations'] = 'Reservas';
$strings['Return to top'] = 'Volver arriba';
$strings['for'] = 'para';

$strings['Select Search Criteria'] = 'Indique el Criterio de Búsqueda';
$strings['Schedules'] = 'Horarios:';
$strings['All Schedules'] = 'Todos los Horarios';
$strings['Hold CTRL to select multiple'] = 'Mantenga la tecla CTRL presionada para seleccionar varios';
$strings['Users'] = 'Usuarios:';
$strings['All Users'] = 'Todos los Usuarios';
$strings['Resources'] = 'Recursos';
$strings['All Resources'] = 'Todos los Recursos:';
$strings['Starting Date'] = 'Fecha Inicial:';
$strings['Ending Date'] = 'Fechas Final:';
$strings['Starting Time'] = 'Hora Inicial:';
$strings['Ending Time'] = 'Hora Final:';
$strings['Output Type'] = 'Tipo de Salida:';
$strings['Manage'] = 'Administrar';
$strings['Total Time'] = 'Tiempo Total';
$strings['Total hours'] = 'Horas en total:';
$strings['% of total resource time'] = '% del tiempo total del recurso';
$strings['View these results as'] = 'Ver estos resultados como:';
$strings['Edit this reservation'] = 'Editar esta reserva';
$strings['Search Results'] = 'Buscar Resultados';
$strings['Search Resource Usage'] = 'Buscar uso del Recurso';
$strings['Search Results found'] = 'Resultados de la Búsqueda: Se encontraron %d reservas';
$strings['Try a different search'] = 'Intente otra Búsqueda';
$strings['Search Run On'] = 'Hacer la Búsqueda en:';
$strings['Member ID'] = 'ID de Miembro';
$strings['Previous User'] = '« Usuario Anterior';
$strings['Next User'] = 'Usuario Siguiente »';

$strings['No results'] = 'No hay resultados';
$strings['That record could not be found.'] = 'No se encontró ese registro.';
$strings['This blackout is not recurring.'] = 'Este tiempo muerto no es recurrente.';
$strings['This reservation is not recurring.'] = 'Esta reserva no es recurrente.';
$strings['There are no records in the table.'] = 'No hay registros en la tabla %s.';
$strings['You do not have any reservations scheduled.'] = 'No tiene ninguna reserva programada.';
$strings['You do not have permission to use any resources.'] = 'No tiene permiso para usar ningún recurso.';
$strings['No resources in the database.'] = 'No hay recursos en la base de datos.';
$strings['There was an error executing your query'] = 'Hubo un error ejecutando el comando en la base de datos:';

$strings['That cookie seems to be invalid'] = 'Esa cookie parece ser inválida';
$strings['We could not find that email in our database.'] = 'No se encontró ese email en la base de datos.';
$strings['That password did not match the one in our database.'] = 'Ese password no coincide con el de nuestra base de datos.';
$strings['You can try'] = '<br />Usted puede:<br />Registrar una dirección email.<br />O:<br />Volver a intentar iniciar sesión.';
$strings['A new user has been added'] = 'Un nuevo usuario ha sido adicionado';
$strings['You have successfully registered'] = 'Usted se ha registrado exitosamente!';
$strings['Continue'] = 'Continuar...';
$strings['Your profile has been successfully updated!'] = 'Su perfil ha sido actualizado exitosamente!';
$strings['Please return to My Control Panel'] = 'Por favor vuelva a Mi Pánel de Control';
$strings['Valid email address is required.'] = '- Se requiere una dirección de email válida.';
$strings['First name f.'] = '- Se requiere el nombre.';
$strings['Last name is required.'] = '- Se requiere el Apellido.';
$strings['Phone number is required.'] = '- Se requiere el teléfono.';
$strings['That email is taken already.'] = '- Ese email ya está registrado.<br />Por favor intente de nuevo con otra dirección email.';
$strings['Min 6 character password is required.'] = '- Se requiere un password de almento %s caracteres.';
$strings['Passwords do not match.'] = '- Los passwords no coinciden.';

$strings['Per page'] = 'Por página:';
$strings['Page'] = 'Página:';

$strings['Your reservation was successfully created'] = 'Su reserva fue creada exitosamente';
$strings['Your reservation was successfully modified'] = 'Su reserva fue modificada exitosamente';
$strings['Your reservation was successfully deleted'] = 'Su reserva fue borrada exitosamente';
$strings['Your blackout was successfully created'] = 'Su tiempo muerto fue creado exitosamente';
$strings['Your blackout was successfully modified'] = 'Su tiempo muerto fue modificado exitosamente';
$strings['Your blackout was successfully deleted'] = 'Su tiempo muerto fue borrado exitosamente';
$strings['for the follwing dates'] = 'para las siguientes fechas:';
$strings['Start time must be less than end time'] = 'El momento inicial debe ser anterior al momento final.';
$strings['Current start time is'] = 'Fecha inicial actualmente es:';
$strings['Current end time is'] = 'Fecha final actualmente es:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'La duración de la reserva no está en el rango permitido para este recurso.';
$strings['Your reservation is'] = 'Su reserva es:';
$strings['Minimum reservation length'] = 'Duración mínima de la reserva:';
$strings['Maximum reservation length'] = 'Duración máxima de la reserva:';
$strings['You do not have permission to use this resource.'] = 'Usted no tiene permiso para usar este recurso.';
$strings['reserved or unavailable'] = '%s hasta %s ya está reservado o no está disponible.';	// @since 1.1.0
$strings['Reservation created for'] = 'Reserva creada para %s';
$strings['Reservation modified for'] = 'Reserva modificada para %s';
$strings['Reservation deleted for'] = 'Reserva borrada para %s';
$strings['created'] = 'creado';
$strings['modified'] = 'modificado';
$strings['deleted'] = 'borrado';
$strings['Reservation #'] = 'Reserva #';
$strings['Contact'] = 'Contacto';
$strings['Reservation created'] = 'Reserva creada';
$strings['Reservation modified'] = 'Reserva modificada';
$strings['Reservation deleted'] = 'Reserva borrada';

$strings['Reservations by month'] = 'Reservas por mes';
$strings['Reservations by day of the week'] = 'Reservas por día de la semana';
$strings['Reservations per month'] = 'Reservas por mes';
$strings['Reservations per user'] = 'Reservas por usuario';
$strings['Reservations per resource'] = 'Reservas por recurso';
$strings['Reservations per start time'] = 'Reservas por fecha inicial';
$strings['Reservations per end time'] = 'Reservas por fecha final';
$strings['[All Reservations]'] = '[Todas las Reservas]';

$strings['Permissions Updated'] = 'Permisos Actualizados';
$strings['Your permissions have been updated'] = 'Sus %s permisos han sido actualizados';
$strings['You now do not have permission to use any resources.'] = 'Usted no tiene permisos para usar ningún recurso.';
$strings['You now have permission to use the following resources'] = 'Usted no tiene permisos para usar los siguientes recursos:';
$strings['Please contact with any questions.'] = 'Por favor contacte a %s para más información.';
$strings['Password Reset'] = 'Password Restablecido';

$strings['This will change your password to a new, randomly generated one.'] = 'Esto cambiará su password a uno nuevo, generado aleatoriamente.';
$strings['your new password will be set'] = 'Después de escribir su email y hacer clic en "Cambiar Password", su nuevo password será activado en el sistema y enviado a su email.';
$strings['Change Password'] = 'Cambiar Password';
$strings['Sorry, we could not find that user in the database.'] = 'Lo siento, el usuario no se encuentra en la base de datos.';
$strings['Your New Password'] = 'Su Nuevo %s Password';
$strings['Your new passsword has been emailed to you.'] = 'Listo!<br />'
    			. 'Su nuevo password ha sido enviado.<br />'
    			. 'Por favor busque su nuevo password en su correo, y luego <a href="index.php">Inicie Sesión</a>'
    			. ' con este nuevo password y cámbielo enseguida haciendo clic en &quot;Cambiar la Información de mi Perfil/Password&quot;'
    			. ' en Mi Pánel de Control.';

$strings['You are not logged in!'] = 'Usted no ha iniciado sesión!';

$strings['Setup'] = 'Configuración';
$strings['Please log into your database'] = 'Por favor inicie sesión en la base de datos';
$strings['Enter database root username'] = 'Ingrese el usuario root de la base de datos:';
$strings['Enter database root password'] = 'Ingrese el password de root:';
$strings['Login to database'] = 'Iniciar sesión en la base de datos';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = '<b>No</b> es necesario el usuario root. Cualquier usuario con permisos para crear tablas funciona.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Esto creará las bases de datos y tablas necesarias para phpScheduleIt.';
$strings['It also populates any required tables.'] = 'También creará los datos en las tablas requeridas.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Advertencia: ESTO BORRARÁ TODA LA INFORMACIÓN DE BASES DE DATOS ANTERIORES DE phpScheduleIt!';
$strings['Not a valid database type in the config.php file.'] = 'Tipo inválido de base de datos en el archivo config.php.';
$strings['Database user password is not set in the config.php file.'] = 'Password de usuario de base de datos no indicado en el archivo config.php.';
$strings['Database name not set in the config.php file.'] = 'Nombre de base de datos no indicado en el archivo config.php.';
$strings['Successfully connected as'] = 'Se conectó exitosamente como';
$strings['Create tables'] = 'Crear tablas &gt;';
$strings['There were errors during the install.'] = 'Hubo errores durante la instalación. Es posible, sin embargo, que phpScheduleIt funcione si los problemas no fueron graves.<br/><br/>'
	. 'Por favor publique sus preguntas en los foros de <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Usted ha terminado de instalar phpScheduleIt y está listo para empezar a usarlo.';
$strings['Thank you for using phpScheduleIt'] = 'Por favor ELIMINE COMPLETAMENTE EL DIRECTORIO \'install\'.'
	. ' Esto es crítico ya que contiene los passwords de la base de datos y otra información importante.'
	. ' El no hacerlo es dejar la puerta abierta para que cualquier persona tome el control de su sistema!'
	. '<br /><br />'
	. 'Gracias por usar phpScheduleIt!';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'Esto actualizará su versión de phpScheduleIt de 0.9.3 a 1.0.0.';
$strings['There is no way to undo this action'] = 'No hay forma de deshacer este cambio!';
$strings['Click to proceed'] = 'Clic para iniciar';
$strings['This version has already been upgraded to 1.0.0.'] = 'Esta versión ya fue actualizada a 1.0.0.';
$strings['Please delete this file.'] = 'Por favor borre este archivo.';
$strings['Successful update'] = 'La actualización se hizo exitosamente';
$strings['Patch completed successfully'] = 'La corrección se completo exitosamente';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'Esto llenará los campos requeridos para phpScheduleIt 1.0.0 y corregirá el error de datos de 0.9.9.'
		. '<br />Sólo se requiere ejecutar esto si Usted realizó una actualización manual de SQL o está actualizando versión desde 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Si no se especificó un valor, se usará el password por defecto del archivo de configuración.';
$strings['Notify user that password has been changed?'] = 'Notificar al usuario que el password ha cambiado?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Este sistema requiere que Usted tenga una dirección de email.';
$strings['Invalid User Name/Password.'] = 'Nombre de Usuario/Password Inválido.';
$strings['Pending User Reservations'] = 'Reservas de Usuario Pendientes';
$strings['Approve'] = 'Aprobar';
$strings['Approve this reservation'] = 'Aprobar esta reserva';
$strings['Approve Reservations'] ='Aprobar Reservas';

$strings['Announcement'] = 'Anuncio';
$strings['Number'] = 'Número';
$strings['Add Announcement'] = 'Añadir Anuncio';
$strings['Edit Announcement'] = 'Editar Anuncio';
$strings['All Announcements'] = 'Todos los Anuncios';
$strings['Delete Announcements'] = 'Borrar Anuncios';
$strings['Use start date/time?'] = 'Usar fecha/hora de inicio?';
$strings['Use end date/time?'] = 'Usar fecha/hora de finalización?';
$strings['Announcement text is required.'] = 'Se requiere un texto para el anuncio.';
$strings['Announcement number is required.'] = 'Se requiere un número para el anuncio.';

$strings['Pending Approval'] = 'Aprobación Pendiente';
$strings['My reservation is approved'] = 'Mi reserva está aprobada';
$strings['This reservation must be approved by the administrator.'] = 'Esta reserva debe ser aprobada por el administrador.';
$strings['Approval Required'] = 'Se Requiere Aprobación';
$strings['No reservations requiring approval'] = 'No hay reservas que necesiten ser aprobadas';
$strings['Your reservation was successfully approved'] = 'Su reserva fue aprobada exitosamente';
$strings['Reservation approved for'] = 'Reserva aprobada para %s';
$strings['approved'] = 'aprobada';
$strings['Reservation approved'] = 'Reserva aprobada';

$strings['Valid username is required'] = 'Se requiere una nombre de usuario válido';
$strings['That logon name is taken already.'] = 'Ese nombre de usuario ya está siendo utilizado.';
$strings['this will be your login'] = '(este será su nombre de usuario)';
$strings['Logon name'] = 'Nombre de usuario';
$strings['Your logon name is'] = 'Su nombre de usuario es %s';

$strings['Start'] = 'Inicio';
$strings['End'] = 'Fin';
$strings['Start date must be less than or equal to end date'] = 'La fecha de inicio debe ser menor o igual que la fecha de finalización';
$strings['That starting date has already passed'] = 'Esa fecha de inició ya pasó';
$strings['Basic'] = 'Básico';
$strings['Participants'] = 'Participantes';
$strings['Close'] = 'Cierre';
$strings['Start Date'] = 'Fecha Inicial';
$strings['End Date'] = 'Fecha Final';
$strings['Minimum'] = 'Mínimo';
$strings['Maximum'] = 'Máximo';
$strings['Allow Multiple Day Reservations'] = 'Permitir Reservas de Múltiples Días';
$strings['Invited Users'] = 'Usuarios Invitados';
$strings['Invite Users'] = 'Invitar Usuarios';
$strings['Remove Participants'] = 'Eliminar Participantes';
$strings['Reservation Invitation'] = 'Reserva Invitación';
$strings['Manage Invites'] = 'Administrar Invitados';
$strings['No invite was selected'] = 'No fue seleccionado algún invitado';
$strings['reservation accepted'] = '%s Aceptó su Invitación el %s';
$strings['reservation declined'] = '%s Rechazó su Invitación el %s';
$strings['Login to manage all of your invitiations'] = 'Ingrese para administrar todas sus invitaciones';
$strings['Reservation Participation Change'] = 'Cambio de la Participación en la Reserva';
$strings['My Invitations'] = 'Mis Invitaciones';
$strings['Accept'] = 'Aceptar';
$strings['Decline'] = 'Rechazar';
$strings['Accept or decline this reservation'] = 'Aceptar o rechazar esta reserva';
$strings['My Reservation Participation'] = 'Mi Participación en la Reserva';
$strings['End Participation'] = 'Terminar Participación';
$strings['Owner'] = 'Propietario';
$strings['Particpating Users'] = 'Usuarios Participantes';
$strings['No advanced options available'] = 'No hay opciones avanzadas disponibles';
$strings['Confirm reservation participation'] = 'Confirmar participación en la reserva';
$strings['Confirm'] = 'Confirmar';
$strings['Do for all reservations in the group?'] = 'Hacerlo para todas las reservas en el grupo?';

$strings['My Calendar'] = 'Mi Calendario';
$strings['View My Calendar'] = 'Ver Mi Calendario';
$strings['Participant'] = 'Participante';
$strings['Recurring'] = 'Recurrente';
$strings['Multiple Day'] = 'Multiples Días';
$strings['[today]'] = '[hoy]';
$strings['Day View'] = 'Vista Día';
$strings['Week View'] = 'Vista Semana';
$strings['Month View'] = 'Vista Mes';
$strings['Resource Calendar'] = 'Calendario de Recursos';
$strings['View Resource Calendar'] = 'Schedule Calendar';	// @since 1.2.0
$strings['Signup View'] = 'Vista de inscripción';

$strings['Select User'] = 'Seleccionar Usuario';
$strings['Change'] = 'Cambiar';

$strings['Update'] = 'Actualizar';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'La actualización de phpScheduleIt sólo esta disponible para las versiones 1.0.0 o posteriores';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt ya está actualizado';
$strings['Migrating reservations'] = 'Migrando reservas';

$strings['Admin'] = 'Administrador';
$strings['Manage Announcements'] = 'Administrar Anuncios';
$strings['There are no announcements'] = 'No hay anuncios';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximum Participant Capacity';
$strings['Leave blank for unlimited'] = 'Leave blank for unlimited';
$strings['Maximum of participants'] = 'This resource has a maximum capacity of %s participants';
$strings['That reservation is at full capacity.'] = 'That reservation is at full capacity.';
$strings['Allow registered users to join?'] = 'Allow registered users to join?';
$strings['Allow non-registered users to join?'] = 'Allow non-registered users to join?';
$strings['Join'] = 'Join';
$strings['My Participation Options'] = 'My Participation Options';
$strings['Join Reservation'] = 'Join Reservation';
$strings['Join All Recurring'] = 'Join All Recurring';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'You are not participating on the following reservation dates because they are at full capacity.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'You are already invited to this reservation. Please follow participation instructions previously sent to your email.';
$strings['Additional Tools'] = 'Additional Tools';
$strings['Create User'] = 'Create User';
$strings['Check Availability'] = 'Check Availability';
$strings['Manage Additional Resources'] = 'Manage Accessories';
$strings['All Additional Resources'] = 'All Accessories';
$strings['Number Available'] = 'Number Available';
$strings['Unlimited'] = 'Unlimited';
$strings['Add Additional Resource'] = 'Add Accessory';
$strings['Edit Additional Resource'] = 'Edit Accessory';
$strings['Checking'] = 'Checking';
$strings['You did not select anything to delete.'] = 'You did not select anything to delete.';
$strings['Added Resources'] = 'Added Resources';
$strings['Additional resource is reserved'] = 'The additional resource %s only has %s available at a time';
$strings['All Groups'] = 'All Groups';
$strings['Group Name'] = 'Group Name';
$strings['Delete Groups'] = 'Delete Groups';
$strings['Manage Groups'] = 'Manage Groups';
$strings['None'] = 'None';
$strings['Group name is required.'] = 'Group name is required.';
$strings['Groups'] = 'Groups';
$strings['Current Groups'] = 'Current Groups';
$strings['Group Administration'] = 'Group Administration';
$strings['Reminder Subject'] = 'Reservation reminder- %s, %s %s';
$strings['Reminder'] = 'Reminder';
$strings['before reservation'] = 'before reservation';
$strings['My Participation'] = 'My Participation';
$strings['My Past Participation'] = 'My Past Participation';
$strings['Timezone'] = 'Timezone';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'Select reservations to export';
$strings['Export Format'] = 'Export Format';
$strings['This resource cannot be reserved less than x hours in advance'] = 'This resource cannot be reserved less than %s hours in advance';
$strings['This resource cannot be reserved more than x hours in advance'] = 'This resource cannot be reserved more than %s hours in advance';
$strings['Minimum Booking Notice'] = 'Minimum Booking Notice';
$strings['Maximum Booking Notice'] = 'Maximum Booking Notice';
$strings['hours prior to the start time'] = 'hours prior to the start time';
$strings['hours from the current time'] = 'hours from the current time';
$strings['Contains'] = 'Contains';
$strings['Begins with'] = 'Begins with';
$strings['Minimum booking notice is required.'] = 'Minimum booking notice is required.';
$strings['Maximum booking notice is required.'] = 'Maximum booking notice is required.';
$strings['Accessory Name'] = 'Accessory Name';
$strings['Accessories'] = 'Accessories';
$strings['All Accessories'] = 'All Accessories';
$strings['Added Accessories'] = 'Added Accessories';
// end since 1.2.0

/***
  EMAIL MESSAGES
  Please translate these email messages into your language.  You should keep the sprintf (%s) placeholders
   in their current position unless you know you need to move them.
  All email messages should be surrounded by double quotes "
  Each email message will be described below.
***/
// @since 1.1.0
// Email message that a user gets after they register
$email['register'] = "%s, %s \r\n"
				. "Usted se ha registrado exitosamente con la siguiente información:\r\n"
				. "Usuario: %s\r\n"
				. "Nombre: %s %s \r\n"
				. "Teléfono: %s \r\n"
				. "Institución: %s \r\n"
				. "Cargo: %s \r\n\r\n"
				. "Por favor ingrese al sistema de agenda en línea en esta dirección:\r\n"
				. "%s \r\n\r\n"
				. "Usted encontrará enlaces para el sistema de agenda en línea y para modificar su perfil en Mi Pánel de Control.\r\n\r\n"
				. "Por favor dirija sus preguntas relacionadas con reservas y recursos a %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrador,\r\n\r\n"
					. "Un nuevo usuario se ha registrado con la siguiente información:\r\n"
					. "Email: %s \r\n"
					. "Nombre: %s %s \r\n"
					. "Teléfono: %s \r\n"
					. "Institución: %s \r\n"
					. "Cargo: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Usted ha %s exitosamente la reserva #%s.\r\n\r\n<br/><br/>"
			. "Por favor use este número de reserva cuando contacte al administrador para alguna pregunta.\r\n\r\n<br/><br/>"
			. "Una reserva entre %s %s y %s %s para %s"
			. " ubicada en %s ha sido %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Esta reserva se ha repetido en las siguientes fechas:\r\n<br/>";
$email['reservation_activity_3'] = "Todas las reservas recurrentes de esta serie, también fueron %ss.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "El siguiente es el resumen de para esta reserva:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Si Usted considera esto un error, por favor contacte al administrador en: %s"
			. " o llamando al %s.\r\n\r\n<br/><br/>"
			. "Usted puede ver o modificar su reserva en cualquier momento"
			. " iniciando sesión en %s en:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Por favor dirija las preguntas técnicas a <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "La reserva #%s ha sido aprobada.\r\n\r\n<br/><br/>"
			. "Por favor use este número de reserva cuando contacte al administrador para alguna pregunta.\r\n\r\n<br/><br/>"
			. "Una reserva entre %s %s y %s %s para %s"
			. " ubicada en %s ha sido %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Su password %s ha sido restablecido por el administrador.\r\n\r\n"
			. "Su password temporal es:\r\n\r\n %s\r\n\r\n"
			. "Por favor use este password temporal (puede usar copiar y pegar para mayor facilidad) para iniciar sesión en %s en %s"
			. " y cámbielo de inmediato usando la opción 'Cambiar la Información de mi Perfil/Password' en la tabla Mis Accesos Directos.\r\n\r\n"
			. "Por favor contacte a %s para mayor información.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Su nuevo password para su cuenta de %s es:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Por favor inicie sesión en %s "
            . "con este nuevo password "
            . "(puede usar copiar y pegar para mayor facilidad) "
            . "y cámbielo de inmediato haciendo clic en "
            . "Cambiar la Información de mi Perfil/Password "
            . "en Mi Pánel de Control.\r\n\r\n"
            . "Por favor contacte a %s para mayor información.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s lo(la) ha invitado para participar en la siguiente reserva:\r\n\r\n"
		. "Recurso: %s\r\n"
		. "Fecha de Inicio: %s\r\n"
		. "Hora de Inicio: %s\r\n"
		. "Fecha de Finalización: %s\r\n"
		. "Hora de Finalización: %s\r\n"
		. "Resumen: %s\r\n"
		. "Fechas de repetición (si hay): %s\r\n\r\n"
		. "Para aceptar esta invitación haga click en este enlace (Use copiar y pegar si no está resaltado) %s\r\n"
		. "Para rechazar esta invitación haga click en este enlace (Use copiar y pegar si no está resaltado) %s\r\n"
		. "Para aceptar algunas fechas o administrar sus invitaciones después, por favor ingrese a %s en %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Usted ha sido retirado de la siguiente reserva:\r\n\r\n"
		. "Recurso: %s\r\n"
		. "Fecha de Inicio: %s\r\n"
		. "Hora de Inicio: %s\r\n"
		. "Fecha de Finalización: %s\r\n"
		. "Hora de Finalización: %s\r\n"
		. "Resumen: %s\r\n"
		. "Fechas de repetición (si hay): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Your reservation for %s from %s %s to %s %s is approaching.";
?>