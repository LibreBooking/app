<?php
/**
* European Portuguese (pt_PT) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Pedro Ramos <pedro.ramos@tugatech.pt>
* @version 05-14-06
* @package Languages
*
* Copyright (C) 2003 - 2004 phpScheduleIt
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
$days_full = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
// The three letter abbreviation
$days_abbr = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb');
// The two letter abbreviation
$days_two  = array('Do', 'Se', 'Te', 'Qa', 'Qu', 'Sx', 'Sá');
// The one letter abbreviation
$days_letter = array('D', 'S', 'T', 'Q', 'Q', 'S', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
// The three letter month name
$months_abbr = array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');

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
$strings['yyyy'] = 'yyyy';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Administrador';
$strings['Welcome Back'] = 'Bem-vindo, %s';
$strings['Log Out'] = 'Sair';
$strings['My Control Panel'] = 'Painel de Controle';
$strings['Help'] = 'Ajuda';
$strings['Manage Schedules'] = 'Gerir Agenda';
$strings['Manage Users'] = 'Gerir utilizadores';
$strings['Manage Resources'] = 'Gerir Recursos';
$strings['Manage User Training'] = 'Gerir Formação';
$strings['Manage Reservations'] = 'Gerir Reservas';
$strings['Email Users'] = 'Enviar E-mail';
$strings['Export Database Data'] = 'Exportar Dados';
$strings['Reset Password'] = 'Alterar Senha';
$strings['System Administration'] = 'Administrador do Sistema';
$strings['Successful update'] = 'A atualização foi concluida com êxito';
$strings['Update failed!'] = 'Erro na atualização';
$strings['Manage Blackout Times'] = 'Gerir horários indisponíveis';
$strings['Forgot Password'] = 'Esqueceu-se da senha ?';
$strings['Manage My Email Contacts'] = 'Gerir os meus contatos de E-mail';
$strings['Choose Date'] = 'Escolher Data';
$strings['Modify My Profile'] = 'Alterar os Meus Dados';
$strings['Register'] = 'Registar';
$strings['Processing Blackout'] = 'A Processar horários indisponíveis';
$strings['Processing Reservation'] = 'A Processar Reserva';
$strings['Online Scheduler [Read-only Mode]'] = 'Agenda Online [Somente Leitura]';
$strings['Online Scheduler'] = 'Agenda Online';
$strings['phpScheduleIt Statistics'] = 'Estatísticas da Agenda';
$strings['User Info'] = 'Informações do Utilizadores';

$strings['Could not determine tool'] = 'Não foi possível determinar a ferramenta. Por favor, volte ao Painel de Controle e tente novamente mais tarde.';
$strings['This is only accessable to the administrator'] = 'Acesso permitido apenas ao administrador';
$strings['Back to My Control Panel'] = 'Voltar ao  Painel de Controle';
$strings['That schedule is not available.'] = 'Esta agenda não está disponível';
$strings['You did not select any schedules to delete.'] = 'Você não selecionou nenhum compromisso para excluir.';
$strings['You did not select any members to delete.'] = 'Você não selecionou nenhum membro para excluir.';
$strings['You did not select any resources to delete.'] = 'Você não selecionou nenhum recurso para excluir.';
$strings['Schedule title is required.'] = 'O título do compromisso é obrigatório.';
$strings['Invalid start/end times'] = 'Horário de início/fim é inválido';
$strings['View days is required'] = 'Dias de visualização é obrigatório';
$strings['Day offset is required'] = 'Duração de dias é obrigatório';
$strings['Admin email is required'] = 'Email do Administrador é obrigatório';
$strings['Resource name is required.'] = 'Nome do recurso é obrigatório.';
$strings['Valid schedule must be selected'] = 'Um compromisso válido deve ser selecionado';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'A maior reserva deve ser maior ou igual à menor reserva.';
$strings['Your request was processed successfully.'] = 'A sua solicitação foi processada com sucesso.';
$strings['Go back to system administration'] = 'Voltar para a administração do sistema';
$strings['Or wait to be automatically redirected there.'] = 'Ou espere para ser automaticamente redirecionado para lá.';
$strings['There were problems processing your request.'] = 'Ocorreram problemas no processamento de sua solicitação.';
$strings['Please go back and correct any errors.'] = 'Por favor, volte e corriga os erros.';
$strings['Login to view details and place reservations'] = 'Entre para ver os detalhes e fazer reservas';
$strings['Memberid is not available.'] = 'ID do Membro: %s não está disponível.';

$strings['Schedule Title'] = 'Título do Compromisso';
$strings['Start Time'] = 'Hora de Início';
$strings['End Time'] = 'Hora de Término';
$strings['Time Span'] = 'Agrupamento de Horário';
$strings['Weekday Start'] = 'Dia inicial da semana';
$strings['Admin Email'] = 'E-mail do Administrador';

$strings['Default'] = 'Padrão';
$strings['Reset'] = 'Alterar';
$strings['Edit'] = 'Editar';
$strings['Delete'] = 'Excluir';
$strings['Cancel'] = 'Cancelar';
$strings['View'] = 'Visualizar';
$strings['Modify'] = 'Alterar';
$strings['Save'] = 'Gravar';
$strings['Back'] = 'Voltar';
$strings['Next'] = 'Próximo';
$strings['Close Window'] = 'Fechar Janela';
$strings['Search'] = 'Procura';
$strings['Clear'] = 'Limpar';

$strings['Days to Show'] = 'Dias para exibir';
$strings['Reservation Offset'] = 'Duração da Reserva';
$strings['Hidden'] = 'Oculto';
$strings['Show Summary'] = 'Exibir Sumário';
$strings['Add Schedule'] = 'Adicionar Compromisso';
$strings['Edit Schedule'] = 'Editar Compromisso';
$strings['No'] = 'Não';
$strings['Yes'] = 'Sim';
$strings['Name'] = 'Nome';
$strings['First Name'] = 'Primeiro Nome';
$strings['Last Name'] = 'Sobrenome';
$strings['Resource Name'] = 'Nome do Recurso';
$strings['Email'] = 'E-mail';
$strings['Institution'] = 'Institutição';
$strings['Phone'] = 'Telefone';
$strings['Password'] = 'Senha';
$strings['Permissions'] = 'Permissões';
$strings['View information about'] = 'Ver informações sobre %s %s';
$strings['Send email to'] = 'Enviar e-mail para %s %s';
$strings['Reset password for'] = 'Alterar senha para %s %s';
$strings['Edit permissions for'] = 'Alterar permissões de %s %s';
$strings['Position'] = 'Posição';
$strings['Password (6 char min)'] = 'Senha (6 carác. no mínimo)';
$strings['Re-Enter Password'] = 'Re-digite a Senha';

$strings['Sort by descending last name'] = 'Ordenar sobrenome decrescente';
$strings['Sort by descending email address'] = 'Ordenar e-mail decrescente';
$strings['Sort by descending institution'] = 'Ordenar instituição decrescente';
$strings['Sort by ascending last name'] = 'Ordenar sobrenome crescente';
$strings['Sort by ascending email address'] = 'Ordenar e-mail crescente';
$strings['Sort by ascending institution'] = 'Ordenar instituição crescente';
$strings['Sort by descending resource name'] = 'Ordenar recurso decrescente';
$strings['Sort by descending location'] = 'Ordenar localização decrescente';
$strings['Sort by descending schedule title'] = 'Ordenar título do compromisso decrescente';
$strings['Sort by ascending resource name'] = 'Ordenar recurso crescente';
$strings['Sort by ascending location'] = 'Ordenar localização crescente';
$strings['Sort by ascending schedule title'] = 'Ordenar título do compromisso crescente';
$strings['Sort by descending date'] = 'Ordenar data decrescente';
$strings['Sort by descending user name'] = 'Ordenar utilizador decrescente';
$strings['Sort by descending start time'] = 'Ordenar hora de início decrescente';
$strings['Sort by descending end time'] = 'Ordenar hora de término decrescente';
$strings['Sort by ascending date'] = 'Ordenar data crescente';
$strings['Sort by ascending user name'] = 'Ordenar utilizador crescente';
$strings['Sort by ascending start time'] = 'Ordenar hora de início crescente';
$strings['Sort by ascending end time'] = 'Ordenar hora de término crescente';
$strings['Sort by descending created time'] = 'Ordenar por data de criação descendente';
$strings['Sort by ascending created time'] = 'Ordenar por data de criação ascendente';
$strings['Sort by descending last modified time'] = 'Ordenar por data de modificação descendente';
$strings['Sort by ascending last modified time'] = 'Ordenar por data de modificação ascendente';

$strings['Search Users'] = 'Pesquisar utilizadores';
$strings['Location'] = 'Local';
$strings['Schedule'] = 'Marcação';
$strings['Phone'] = 'Telefone';
$strings['Notes'] = 'Notas';
$strings['Status'] = 'Status';
$strings['All Schedules'] = 'Todas as marcações';
$strings['All Resources'] = 'Todos os recursos';
$strings['All Users'] = 'Todos os utilizadores';

$strings['Edit data for'] = 'Editar informação de %s';
$strings['Active'] = 'Activo';
$strings['Inactive'] = 'Inactivo';
$strings['Toggle this resource active/inactive'] = 'Mudar recurso entre activo/inactivo';
$strings['Minimum Reservation Time'] = 'Minimo tempo de reserva';
$strings['Maximum Reservation Time'] = 'Maximo tempo de reserva';
$strings['Auto-assign permission'] = 'Auto-assign permission';
$strings['Add Resource'] = 'Adicionar recurso';
$strings['Edit Resource'] = 'Editar recurso';
$strings['Allowed'] = 'Autorizado';
$strings['Notify user'] = 'Notificar Utilizador';
$strings['User Reservations'] = 'Reservas do utilizador';
$strings['Date'] = 'Data';
$strings['User'] = 'Utilizador';
$strings['Email Users'] = 'Email para Utilizadores';
$strings['Subject'] = 'Assunto';
$strings['Message'] = 'Menssagem';
$strings['Please select users'] = 'Por favor seleccione utilizadores';
$strings['Send Email'] = 'Enviar Email';
$strings['problem sending email'] = 'Houve um problema ao enviar o Email... Tente mais tarde.';
$strings['The email sent successfully.'] = 'Email enviado com sucesso.';
$strings['do not refresh page'] = 'Por favor nao faça RELOAD desta página ou o seu Email será enviado de novo.';
$strings['Return to email management'] = 'Voltar á gestão de Emails';
$strings['Please select which tables and fields to export'] = 'Seleccione tabelas e campos a exportar:';
$strings['all fields'] = '- Todos campos -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Plain text';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Exportar dados';
$strings['Reset Password for'] = 'Restaurar password de %s';
$strings['Please edit your profile'] = 'Por favor altere o seu perfil';
$strings['Please register'] = 'Por favor registe-se';
$strings['Email address (this will be your login)'] = 'Endereço Email (será o seu login)';
$strings['Keep me logged in'] = 'Manter-me registado <br/>(requer cookies)';
$strings['Edit Profile'] = 'Editar Perfil';
$strings['Register'] = 'Registar';
$strings['Please Log In'] = 'Por favor autentique-se';
$strings['Email address'] = 'Endereço Email';
$strings['Password'] = 'Password';
$strings['First time user'] = 'Novo utilizador ?';
$strings['Click here to register'] = 'Clique aqui para se registar';
$strings['Register for phpScheduleIt'] = 'Registe-se no sistema de reservas';
$strings['Log In'] = 'Log In';
$strings['View Schedule'] = 'Ver marcações';
$strings['View a read-only version of the schedule'] = 'Ver versão de leitura das marcações';
$strings['I Forgot My Password'] = 'Esqueci-me da password';
$strings['Retreive lost password'] = 'Recuperar a password';
$strings['Get online help'] = 'Obter ajuda';
$strings['Language'] = 'Idioma';
$strings['(Default)'] = '(Default)';

$strings['My Announcements'] = 'Meus Anuncios';
$strings['My Reservations'] = 'Minhas Reservas';
$strings['My Permissions'] = 'Minhas Permissões';
$strings['My Quick Links'] = 'Meus Links';
$strings['Announcements as of'] = 'Anuncios de %s';
$strings['There are no announcements.'] = 'Não existem anúncios.';
$strings['Resource'] = 'Recurso';
$strings['Created'] = 'Criada';
$strings['Last Modified'] = 'Ultima modificação';
$strings['View this reservation'] = 'Ver esta reserva';
$strings['Modify this reservation'] = 'Modificar esta reserva';
$strings['Delete this reservation'] = 'Apagar esta reserva';
$strings['Bookings'] = 'Bookings';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = 'Change Profile';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Preferences';				// @since 1.2.0
$strings['Mass Email Users'] = 'Mass Email Users';
$strings['Search Scheduled Resource Usage'] = 'Search Reservations';		// @since 1.2.0
$strings['Export Database Content'] = 'Export Database Content';
$strings['View System Stats'] = 'View System Stats';
$strings['Email Administrator'] = 'Email para Administrador';

$strings['Email me when'] = 'Enviar-me um mail quando:';
$strings['I place a reservation'] = 'Eu coloco uma reserva';
$strings['My reservation is modified'] = 'A minha reserva é modificada';
$strings['My reservation is deleted'] = 'A minha reserva é apagada';
$strings['I prefer'] = 'Eu prefiro:';
$strings['Your email preferences were successfully saved'] = 'As suas preferencias de Email foram gravadas!';
$strings['Return to My Control Panel'] = 'Voltar ao painel de controlo';

$strings['Please select the starting and ending times'] = 'P.F. seleccione data de inicio e de fim:';
$strings['Please change the starting and ending times'] = 'P.F. altere data de inicio e de fim:';
$strings['Reserved time'] = 'Tempo de reserva:';
$strings['Minimum Reservation Length'] = 'Tempo Minimo de reserva:';
$strings['Maximum Reservation Length'] = 'Tempo Máximo de reserva:';
$strings['Reserved for'] = 'Reservado para:';
$strings['Will be reserved for'] = 'Irá ser reservado para:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Actualizar todos os registos dependentes ?';
$strings['Delete?'] = 'Apagar ?';
$strings['Never'] = '-- Nunca --';
$strings['Days'] = 'Dias';
$strings['Weeks'] = 'Semanas';
$strings['Months (date)'] = 'Meses (data)';
$strings['Months (day)'] = 'Meses (dia)';
$strings['First Days'] = 'Primeiros dias';
$strings['Second Days'] = 'Segundos dias';
$strings['Third Days'] = 'Terceiros dias';
$strings['Fourth Days'] = 'Quartos dias';
$strings['Last Days'] = 'Ultimos dias';
$strings['Repeat every'] = 'Repetir ...:';
$strings['Repeat on'] = 'Repetir em:';
$strings['Repeat until date'] = 'Repetir até á data:';
$strings['Choose Date'] = 'Escolha data';
$strings['Summary'] = 'Resumo';

$strings['View schedule'] = 'Ver marcações:';
$strings['My Reservations'] = 'Minhas reservas';
$strings['My Past Reservations'] = 'Reservas antigas';
$strings['Other Reservations'] = 'Outras reservas';
$strings['Other Past Reservations'] = 'Outras reservas antigas';
$strings['Blacked Out Time'] = 'Tempo indisponivel';
$strings['Set blackout times'] = 'Tempo indisponivel para %s em %s'; 
$strings['Reserve on'] = 'Reservar %s em %s';
$strings['Prev Week'] = '&laquo; Semana anterior';
$strings['Jump 1 week back'] = 'Recuar uma semana';
$strings['Prev days'] = '&#8249; Ultimos %d dias';
$strings['Previous days'] = '&#8249; Ultimos %d dias';
$strings['This Week'] = 'Esta semana';
$strings['Jump to this week'] = 'Ir para esta semana';
$strings['Next days'] = 'Proximos %d dias &#8250;';
$strings['Next Week'] = 'Proxima semana &raquo;';
$strings['Jump To Date'] = 'Ir para data';
$strings['View Monthly Calendar'] = 'Ver calendário mensal';
$strings['Open up a navigational calendar'] = 'Abrir calendário navegável';

$strings['View stats for schedule'] = 'Ver estado das reservas:';
$strings['At A Glance'] = 'Simples';
$strings['Total Users'] = 'Todos os utilizadores:';
$strings['Total Resources'] = 'Todos os recursos:';
$strings['Total Reservations'] = 'Todas as reservas:';
$strings['Max Reservation'] = 'Max Reserva:';
$strings['Min Reservation'] = 'Min Reserva:';
$strings['Avg Reservation'] = 'Média Reservas:';
$strings['Most Active Resource'] = 'Recurso mais pedido:';
$strings['Most Active User'] = 'Utilizador mais activo:';
$strings['System Stats'] = 'Status Sistema';
$strings['phpScheduleIt version'] = 'versao phpScheduleIt:';
$strings['Database backend'] = 'Database backend:';
$strings['Database name'] = 'Database name:';
$strings['PHP version'] = 'PHP version:';
$strings['Server OS'] = 'Server OS:';
$strings['Server name'] = 'Server name:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt root directory:';
$strings['Using permissions'] = 'Using permissions:';
$strings['Using logging'] = 'Using logging:';
$strings['Log file'] = 'Log file:';
$strings['Admin email address'] = 'Admin email address:';
$strings['Tech email address'] = 'Tech email address:';
$strings['CC email addresses'] = 'CC email addresses:';
$strings['Reservation start time'] = 'Hora de inicio da reserva:';
$strings['Reservation end time'] = 'Hora de fim da reserva:';
$strings['Days shown at a time'] = 'Dias mostrados no periodo:';
$strings['Reservations'] = 'Reservas';
$strings['Return to top'] = 'Return to top';
$strings['for'] = 'for';

$strings['Select Search Criteria'] = 'Seleccione critério pesquisa';
$strings['Schedules'] = 'Marcações:';
$strings['All Schedules'] = 'Todas as marcações';
$strings['Hold CTRL to select multiple'] = 'Pressione CTRL para seleccionar várias';
$strings['Users'] = 'Utilizadores:';
$strings['All Users'] = 'Todos utilizadores';
$strings['Resources'] = 'Recursos';
$strings['All Resources'] = 'Todos recursos';
$strings['Starting Date'] = 'Data inicio:';
$strings['Ending Date'] = 'Data fim:';
$strings['Starting Time'] = 'Hora inicio:';
$strings['Ending Time'] = 'Hora fim:';
$strings['Output Type'] = 'Tipo de output:';
$strings['Manage'] = 'Manage';
$strings['Total Time'] = 'Tempo total';
$strings['Total hours'] = 'Total horas:';
$strings['% of total resource time'] = '% do tempo total do recurso';
$strings['View these results as'] = 'Ver estes resultados como:';
$strings['Edit this reservation'] = 'Editar esta reserva';
$strings['Search Results'] = 'Resultados da pesquisa';
$strings['Search Resource Usage'] = 'Pesquisar utilização de Recursos';
$strings['Search Results found'] = 'resultados pesquisa: %d rservas encontradas';
$strings['Try a different search'] = 'Tente outra pesquisa';
$strings['Search Run On'] = 'Pesquisa efectuada em:';
$strings['Member ID'] = 'Utilizador ID';
$strings['Previous User'] = '&laquo; Utilizador anterior';
$strings['Next User'] = 'Proximo utilizador &raquo;';

$strings['No results'] = 'Sem resultados';
$strings['That record could not be found.'] = 'O registo nao foi encontrado.';
$strings['This blackout is not recurring.'] = 'Este periodo morto nao é recorrente.';
$strings['This reservation is not recurring.'] = 'Esta reserva não é recorrente.';
$strings['There are no records in the table.'] = 'Não existem registos na tabela %s.';
$strings['You do not have any reservations scheduled.'] = 'Não tem reservas agendadas.';
$strings['You do not have permission to use any resources.'] = 'Não tem permissão para utilizar nenhum recurso.';
$strings['No resources in the database.'] = 'Não existem recursos na base de dados.';
$strings['There was an error executing your query'] = 'Houve um erro ao executar a sua pesquisa:';

$strings['That cookie seems to be invalid'] = 'Cookie inválida';
$strings['We could not find that logon in our database.'] = 'O seu Login não consta na nossa Base de Dados.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = 'A sua password nao existe na nossa Base Dados.';
$strings['You can try'] = '<br />Pode tentar:<br />Registar um endereço de Email.<br />ou:<br />tentar autenticar-se de novo.';
$strings['A new user has been added'] = 'Novo utilizador foi adicionado';
$strings['You have successfully registered'] = 'Registou-se com sucesso!';
$strings['Continue'] = 'Continuar...';
$strings['Your profile has been successfully updated!'] = 'O seu perfil foi actualizado!';
$strings['Please return to My Control Panel'] = 'Por favor volte ao painel de controlo';
$strings['Valid email address is required.'] = '- Deve introduzir um Email válido.';
$strings['First name is required.'] = '- Primeiro nome é obrigatório.';
$strings['Last name is required.'] = '- Apelido é obrigatório.';
$strings['Phone number is required.'] = '- Telefone é obrigatório.';
$strings['That email is taken already.'] = '- Esse Email já existe.<br />Por favor tente com outro endereço de Email.';
$strings['Min 6 character password is required.'] = '- A password deve ter no minimo 6 caracteres.';
$strings['Passwords do not match.'] = '- Passwords não coincidem.';

$strings['Per page'] = 'Por pagina:';
$strings['Page'] = 'Pagina:';

$strings['Your reservation was successfully created'] = 'A sua reserva foi criada com sucesso';
$strings['Your reservation was successfully modified'] = 'A sua reserva foi alterada com sucesso';
$strings['Your reservation was successfully deleted'] = 'A sua reserva foi apagada';
$strings['Your blackout was successfully created'] = 'Your blackout was successfully created';
$strings['Your blackout was successfully modified'] = 'Your blackout was successfully modified';
$strings['Your blackout was successfully deleted'] = 'Your blackout was successfully deleted';
$strings['for the follwing dates'] = 'para as seguintes datas:';
$strings['Start time must be less than end time'] = 'Hora de inicio deve ser anterior á hora de fim.';
$strings['Current start time is'] = 'A hora de inicio é:';
$strings['Current end time is'] = 'A hora de fim é:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Periodo de reserva maior do que o permitido para este recurso.';
$strings['Your reservation is'] = 'A sua reserva é:';
$strings['Minimum reservation length'] = 'Minimo periodo de reserva:';
$strings['Maximum reservation length'] = 'Maximo periodo de reserva:';
$strings['You do not have permission to use this resource.'] = 'Não tem permissões para usar este recurso.';
$strings['reserved or unavailable'] = '%s a %s já está reservado ou está indisponivel.';	// @since 1.1.0
$strings['Reservation created for'] = 'Reserva riada para %s';
$strings['Reservation modified for'] = 'Reserva modificada para %s';
$strings['Reservation deleted for'] = 'Reserva apagada para %s';
$strings['created'] = 'criada';
$strings['modified'] = 'modificado';
$strings['deleted'] = 'deleted';
$strings['Reservation #'] = 'Reserva #';
$strings['Contact'] = 'Contacto';
$strings['Reservation created'] = 'Reserva criada';
$strings['Reservation modified'] = 'Reserva modificada';
$strings['Reservation deleted'] = 'Reserva apagada';

$strings['Reservations by month'] = 'Reservas mês a mês';
$strings['Reservations by day of the week'] = 'Reservas por dia de semana';
$strings['Reservations per month'] = 'Reservas por mês';
$strings['Reservations per user'] = 'Reservas por utilizador';
$strings['Reservations per resource'] = 'Reservas por recurso';
$strings['Reservations per start time'] = 'Reservas por hora de inicio';
$strings['Reservations per end time'] = 'Reservas por hora de fim';
$strings['[All Reservations]'] = '[Todas as reservas]';

$strings['Permissions Updated'] = 'Permissões actualizadas';
$strings['Your permissions have been updated'] = 'As suas permissoes de %s foram actualizadas';
$strings['You now do not have permission to use any resources.'] = 'Não tem permissões para utilizar recursos.';
$strings['You now have permission to use the following resources'] = 'Tem permissões para utilizar os seguintes recursos:';
$strings['Please contact with any questions.'] = 'Por favor contacte %s.';
$strings['Password Reset'] = 'Password restaurada';

$strings['This will change your password to a new, randomly generated one.'] = 'Irá mudar a sua password para uma nova, gerada aleatóriamente.';
$strings['your new password will be set'] = 'Depois de introduzir o seu Email e carregar em "Mudar password" a sua nova password será gerada pelo sistema e enviada para si.';
$strings['Change Password'] = 'Mudar password';
$strings['Sorry, we could not find that user in the database.'] = 'Não foi possivel encontrar esse utilizador na Base Dados.';
$strings['Your New Password'] = 'A sua nova password %s ';
$strings['Your new passsword has been emailed to you.'] = 'Successo!<br />'
    			. 'A sua nova password foi enviada .<br />'
    			. 'Por favor confira o seu email e depois <a href="index.php">autentique-se</a>'
    			. ' com a sua nova password e altere-a carregando em &quot;Alterar o meu perfil/Password&quot;'
    			. ' no painel de controle.';

$strings['You are not logged in!'] = 'Não está autenticado!';

$strings['Setup'] = 'Setup';
$strings['Please log into your database'] = 'Por favor autentique-se na Base de Dados';
$strings['Enter database root username'] = 'Insira o seu usename de root:';
$strings['Enter database root password'] = 'Insira a password de root:';
$strings['Login to database'] = 'Autentique-se na Base de Dados';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'User root <b>NAO</b> é necessário. Qualquer utilizador com permissões para criar tabelas é suficiente.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Isto permitirá criar a Base de Dados e tabelas necessárias ao PhpScheduleIt.';
$strings['It also populates any required tables.'] = 'Também irá inserir dados nas tabelas necessárias.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Atenção! Irá apagar todos os dados das tabelas já existentes!';
$strings['Not a valid database type in the config.php file.'] = 'Base de dados em config.php não é válida.';
$strings['Database user password is not set in the config.php file.'] = 'A password do utilizador da Base de Dados não está definida no ficheiro config.php.';
$strings['Database name not set in the config.php file.'] = 'O nome da Base de Dados não está definido no ficheiro config.php.';
$strings['Successfully connected as'] = 'Conectado com sucesso como';
$strings['Create tables'] = 'Create tables &gt;';
$strings['There were errors during the install.'] = 'Houve erros durante a instalação. É no entanto possivel que o PhpScheduleIt funcione, se os erros nao foram graves.<br/><br/>'
	. 'Por favor coloque perguntas no forum em <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'O PhpScheduleIt foi instalado com sucesso e está pronto a ser utilizado.';
$strings['Thank you for using phpScheduleIt'] = 'Por favor REMOVA COMPLETAMENTE a diretoria \'install\'.'
	. ' Isto é importante porque contem passords e outros dados criticos.'
	. ' Se não fizer fica uma porta aberta para acessos não autorizados á Base de Dados!'
	. '<br /><br />'
	. 'Obrigado por usar o phpScheduleIt!';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.';
$strings['There is no way to undo this action'] = 'There is no way to undo this action!';
$strings['Click to proceed'] = 'Click to proceed';
$strings['This version has already been upgraded to 1.0.0.'] = 'This version has already been upgraded to 1.0.0.';
$strings['Please delete this file.'] = 'Please delete this file.';
$strings['Successful update'] = 'The update succeeded fully';
$strings['Patch completed successfully'] = 'Patch completed successfully';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'
		. '<br />It is only required to run this if you performed a manual SQL update or are upgrading from 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Se não especificar uma password será usada a password definida em config.php.';
$strings['Notify user that password has been changed?'] = 'Notificar o utilizador da alteração de password ?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'O sistema necessita de um Email válido.';
$strings['Invalid User Name/Password.'] = 'Utilizador/password inválidos.';
$strings['Pending User Reservations'] = 'Reservas pendentes do utilizador.';
$strings['Approve'] = 'Aprovar';
$strings['Approve this reservation'] = 'Aprovar esta reserva';
$strings['Approve Reservations'] ='Aprovar reservas';

$strings['Announcement'] = 'Anúncios';
$strings['Number'] = 'Numero';
$strings['Add Announcement'] = 'Adicionar anúncio';
$strings['Edit Announcement'] = 'Editar anúncio';
$strings['All Announcements'] = 'Todos os anúncios';
$strings['Delete Announcements'] = 'Apagar anúncios';
$strings['Use start date/time?'] = 'Usar data/hora de inicio ?';
$strings['Use end date/time?'] = 'Usar data/hora de fim ?';
$strings['Announcement text is required.'] = 'É necessário o texto do anúncio.';
$strings['Announcement number is required.'] = 'É necessário o numero de anúncio.';

$strings['Pending Approval'] = 'Aprovação pendente';
$strings['My reservation is approved'] = 'Minha reserva está aprovada';
$strings['This reservation must be approved by the administrator.'] = 'Esta reserva deverá ser aprovada pelo administrador.';
$strings['Approval Required'] = 'Aprovação necessária';
$strings['No reservations requiring approval'] = 'Sem reservas á espera de aprovação';
$strings['Your reservation was successfully approved'] = 'A sua reserva foi aprovada com sucesso';
$strings['Reservation approved for'] = 'Reserva aprovada para %s';
$strings['approved'] = 'aprovada';
$strings['Reservation approved'] = 'Reserva aprovada';

$strings['Valid username is required'] = 'É necessário um nome de utilizador válido';
$strings['That logon name is taken already.'] = 'Esse nome de utilizador já existe.';
$strings['this will be your login'] = '(este irá ser o seu login)';
$strings['Logon name'] = 'Nome de login';
$strings['Your logon name is'] = 'O seu nome de login é %s';

$strings['Start'] = 'Inicio';
$strings['End'] = 'Fim';
$strings['Start date must be less than or equal to end date'] = 'Data de inicio tem de ser anterior ou igual á data de fim';
$strings['That starting date has already passed'] = 'A data de inicio já passou';
$strings['Basic'] = 'Basico';
$strings['Participants'] = 'Participantes';
$strings['Close'] = 'Fechar';
$strings['Start Date'] = 'Data de inicio';
$strings['End Date'] = 'Data de fim';
$strings['Minimum'] = 'Minimo';
$strings['Maximum'] = 'Maximo';
$strings['Allow Multiple Day Reservations'] = 'Permitir reservas para vários dias';
$strings['Invited Users'] = 'Utilizadores convidados';
$strings['Invite Users'] = 'Convidar utilizadores';
$strings['Remove Participants'] = 'Remover participantes';
$strings['Reservation Invitation'] = 'Convite para reserva';
$strings['Manage Invites'] = 'Gerir convites';
$strings['No invite was selected'] = 'Não seleccionou nenhum convite';
$strings['reservation accepted'] = '%s aceitou o seu convite em %s';
$strings['reservation declined'] = '%s rejeitou o seu convite em %s';
$strings['Login to manage all of your invitiations'] = 'Faça login para gerir os seus convites';
$strings['Reservation Participation Change'] = 'Alterar participação na reserva';
$strings['My Invitations'] = 'Meus convites';
$strings['Accept'] = 'Aceitar';
$strings['Decline'] = 'Rejeitar';
$strings['Accept or decline this reservation'] = 'Aceitar ou rejeitar esta reserva';
$strings['My Reservation Participation'] = 'Minha participação na reserva';
$strings['End Participation'] = 'Terminar participação';
$strings['Owner'] = 'Dono';
$strings['Particpating Users'] = 'Utilizadores participantes';
$strings['No advanced options available'] = 'Opções avançadas indisponíveis';
$strings['Confirm reservation participation'] = 'Confirmar participação na reserva';
$strings['Confirm'] = 'Confirmar';
$strings['Do for all reservations in the group?'] = 'Aplicar a todas as reservas no grupo ?';

$strings['My Calendar'] = 'Meu Calendário';
$strings['View My Calendar'] = 'Ver o Meu Calendário';
$strings['Participant'] = 'Participante';
$strings['Recurring'] = 'Recorrente';
$strings['Multiple Day'] = 'Vários dias';
$strings['[today]'] = '[hoje]';
$strings['Day View'] = 'Ver dia';
$strings['Week View'] = 'Ver semana';
$strings['Month View'] = 'Ver mês';
$strings['Resource Calendar'] = 'Calendário de recursos';
$strings['View Resource Calendar'] = 'Schedule Calendar';	// @since 1.2.0
$strings['Signup View'] = 'Signup View';

$strings['Select User'] = 'Seleccionar utilizador';
$strings['Change'] = 'Alterar';

$strings['Update'] = 'Actualizar';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt Update só está disponivel para versões 1.0.0 ou superior';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt já se encontra actualizado';
$strings['Migrating reservations'] = 'Migrar reservas';

$strings['Admin'] = 'Admin';
$strings['Manage Announcements'] = 'Gerir anúncios';
$strings['There are no announcements'] = 'Não existem anúncios';
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
$strings['Manage Additional Resources'] = 'Manage Additional Resources';
$strings['All Additional Resources'] = 'All Additional Resources';
$strings['Number Available'] = 'Number Available';
$strings['Unlimited'] = 'Unlimited';
$strings['Add Additional Resource'] = 'Add Additional Resource';
$strings['Edit Additional Resource'] = 'Edit Additional Resource';
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
				. "Registou-se com sucesso com os seguintes dados:\r\n"
				. "Login: %s\r\n"
				. "Nome: %s %s \r\n"
				. "Telefone: %s \r\n"
				. "Instituição: %s \r\n"
				. "Posição: %s \r\n\r\n"
				. "Por favor autentique-se neste endereço:\r\n"
				. "%s \r\n\r\n"
				. "Pode encontrar links para a agenda de recursos e para alterar o seu perfil no Painel de Controle.\r\n\r\n"
				. "Envie questões sobre os recursos ou reservas para %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrador,\r\n\r\n"
					. "Novo utilizador registado no Sistema Reservas INIAP:\r\n"
					. "Email: %s \r\n"
					. "Nome: %s %s \r\n"
					. "Telefone: %s \r\n"
					. "Instituição: %s \r\n"
					. "Posição: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Voçê %s a reserva #%s.\r\n\r\n<br/><br/>"
			. "Por favor use este numero para colocar qualquer questão ao administrador.\r\n\r\n<br/><br/>"
			. "Uma reserva entre %s %s e %s %s para %s"
			. " localizado em %s foi %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Esta reserva será repetida nas seguintes datas:\r\n<br/>";
$email['reservation_activity_3'] = "Todas as reservas recorrentes neste grupo tambem foram %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "O seguinte resumo foi reunido para esta reserva:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Se isto for um erro contacte o administrador para: pm.ramos@iniap.min-agricultura.pt"
			. " ou para %s.\r\n\r\n<br/><br/>"
			. "Pode ver ou modificar a sua reserva a qualquer altura "
			. " indo a %s em:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Perguntas técnicas para <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "A reserva #%s foi aprovada.\r\n\r\n<br/><br/>"
			. "Por favor use este numero para colocar qualquer questão ao administrador.\r\n\r\n<br/><br/>"
			. "Uma reserva entre %s %s e %s %s para %s"
			. " localizado em %s foi %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "A sua password %s foi restaurada pelo administrador.\r\n\r\n"
			. "A sua password temporaria é:\r\n\r\n %s\r\n\r\n"
			. "Use esta password para se ligar a %s em %s"
			. " e mude-a imediatamente atraves do seu Painel de Controle/Password.\r\n\r\n"
			. "Contacte  %s se tiver alguma dúvida.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "A sua nova password para a sua conta %s é:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Por favor autentique-se em %s "
            . "com a sua nova password "
            . "(faça 'copiar' e 'colar' para ter certeza que é a correcta) "
            . "e mudea-a de imediato indo a"
            . "Alterar o meu perfil/Password "
            . "no Painel de Controlo.\r\n\r\n"
            . "Por favor envie as suas duvidas para %s.";
			
// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s convidou-o para participar na seguinte reserva:\r\n\r\n"
		. "Recurso: %s\r\n"
		. "Data inicio: %s\r\n"
		. "Hora inicio: %s\r\n"
		. "Data fim: %s\r\n"
		. "Hora fim: %s\r\n"
		. "Summary: %s\r\n"
		. "Datas repetidas (se existirem): %s\r\n\r\n"
		. "Para aceitar este convite vá a este link (pode copiar e colar o link) %s\r\n"
		. "Para recusar este convite vá a este link (pode copiar e colar o link) %s\r\n"
		. "Para aceitar as datas seleccionadas ou gerir os seus convites posteriormente, autentique-se no %s em %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Você foi removido da seguinte reserva:\r\n\r\n"
		. "Recurso: %s\r\n"
		. "Data inicio: %s\r\n"
		. "Hora inicio: %s\r\n"
		. "Data fim: %s\r\n"
		. "Hora fim: %s\r\n"
		. "Resumo: %s\r\n"
		. "Datas repetidas (se existirem): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Your reservation for %s from %s %s to %s %s is approaching.";
?>