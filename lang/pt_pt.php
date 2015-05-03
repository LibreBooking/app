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

class pt_pt extends Language
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
    protected function _LoadDates()
    {
        $dates = array();

        $dates['general_date'] = 'd/m/Y';
        $dates['general_datetime'] = 'd/m/Y H:i:s';
        $dates['schedule_daily'] = 'l, d/m/Y';
        $dates['reservation_email'] = 'd/m/Y @ H:i (e)';
        $dates['res_popup'] = 'd/m/Y H:i';
        $dates['dashboard'] = 'l, m/d/Y H:i';
        $dates['period_time'] = 'H:i';
	$dates['general_date_js'] = 'dd/mm/yy';
	$dates['calendar_time'] = 'h:mmt';
	$dates['calendar_dates'] = 'd/M';

        $this->Dates = $dates;

        return $this->Dates;
    }
    /**
     * @return array
     */
    protected function _LoadStrings()
    {
        $strings = array();

        $strings['FirstName'] = 'Nome';
        $strings['LastName'] = 'Apelido';
        $strings['Timezone'] = 'Fuso Horário';
        $strings['Edit'] = 'Editar';
        $strings['Change'] = 'Alterar';
        $strings['Rename'] = 'Renomear';
        $strings['Remove'] = 'Remover';
        $strings['Delete'] = 'Apagar';
        $strings['Update'] = 'Atualizar';
        $strings['Cancel'] = 'Cancelar';
        $strings['Add'] = 'Adicionar';
        $strings['Name'] = 'Nome';
        $strings['Yes'] = 'Sim';
        $strings['No'] = 'Não';
        $strings['FirstNameRequired'] = 'O nome é obrigatório.';
        $strings['LastNameRequired'] = 'O apelido é obrigatório.';
        $strings['PwMustMatch'] = 'A confirmação da senha deve coincidir com a senha.';
        $strings['PwComplexity'] = 'A senha deve ter pelo menos 6 caracteres com uma combinação de letras, números e símbolos.';
        $strings['ValidEmailRequired'] = 'Um endereço de e-mail válido é obrigatório.';
        $strings['UniqueEmailRequired'] = 'Este endereço de e-mail já está registrado.';
        $strings['UniqueUsernameRequired'] = 'Esse nome de utilizador já está registrado.';
        $strings['UserNameRequired'] = 'Nome de utilizador é obrigatório.';
        $strings['CaptchaMustMatch'] = 'Por favor digite as letras da imagem de segurança exatamente como mostrado.';
        $strings['Today'] = 'Hoje';
        $strings['Week'] = 'Semana';
        $strings['Month'] = 'Mês';
        $strings['BackToCalendar'] = 'Voltar ao calendário';
        $strings['BeginDate'] = 'Início';
        $strings['EndDate'] = 'Final';
        $strings['Username'] = 'Utilizador';
        $strings['Password'] = 'Senha';
        $strings['PasswordConfirmation'] = 'Confirmar senha';
        $strings['DefaultPage'] = 'Página Inicial - Padrão';
        $strings['MyCalendar'] = 'Meu Calendário';
        $strings['ScheduleCalendar'] = 'Calendário de agendas';
        $strings['Registration'] = 'Registo';
        $strings['NoAnnouncements'] = 'Não há anúncios';
        $strings['Announcements'] = 'Anúncios';
        $strings['NoUpcomingReservations'] = 'Não tem futuras reservas';
        $strings['UpcomingReservations'] = 'Futuras reservas';
        $strings['ShowHide'] = 'Mostrar/Ocultar';
        $strings['Error'] = 'Erro';
        $strings['ReturnToPreviousPage'] = 'Regressar à página anterior';
        $strings['UnknownError'] = 'Erro Desconhecido';
        $strings['InsufficientPermissionsError'] = 'Não tem permissão para aceder a este recurso';
        $strings['MissingReservationResourceError'] = 'Um recurso não foi selecionado';
        $strings['MissingReservationScheduleError'] = 'A agenda não foi selecionada';
        $strings['DoesNotRepeat'] = 'Não repetir';
        $strings['Daily'] = 'Diário';
        $strings['Weekly'] = 'Semanal';
        $strings['Monthly'] = 'Mensal';
        $strings['Yearly'] = 'Anual';
        $strings['RepeatPrompt'] = 'Repetir';
        $strings['hours'] = 'horas';
        $strings['days'] = 'dias';
        $strings['weeks'] = 'semanas';
        $strings['months'] = 'meses';
        $strings['years'] = 'anos';
        $strings['day'] = 'dia';
        $strings['week'] = 'semana';
        $strings['month'] = 'mês';
        $strings['year'] = 'ano';
        $strings['repeatDayOfMonth'] = 'dia do mês';
        $strings['repeatDayOfWeek'] = 'dia da semana';
        $strings['RepeatUntilPrompt'] = 'Até';
        $strings['RepeatEveryPrompt'] = 'Todo';
        $strings['RepeatDaysPrompt'] = 'Em';
        $strings['CreateReservationHeading'] = 'Criar uma nova reserva';
        $strings['EditReservationHeading'] = 'Edição de reserva %s';
        $strings['ViewReservationHeading'] = 'Visualização de reserva %s';
        $strings['ReservationErrors'] = 'Alterar reserva';
        $strings['Create'] = 'Criar';
        $strings['ThisInstance'] = 'Apenas esta instância';
        $strings['AllInstances'] = 'Todas as instâncias';
        $strings['FutureInstances'] = 'Instâncias futuras';
        $strings['Print'] = 'Imprimir';
        $strings['ShowHideNavigation'] = 'Mostrar/Ocultar navegação';
        $strings['ReferenceNumber'] = 'Número de referência';
        $strings['Tomorrow'] = 'Amanhã';
        $strings['LaterThisWeek'] = 'Ainda esta semana';
        $strings['NextWeek'] = 'Próxima semana';
        $strings['SignOut'] = 'Sair';
        $strings['LayoutDescription'] = 'Inicia em %s, mostrando %s dias de uma só vez';
        $strings['AllResources'] = 'Todos os recursos';
        $strings['TakeOffline'] = 'Colocar Offline';
        $strings['BringOnline'] = 'Colocar Online';
        $strings['AddImage'] = 'Adicionar imagem';
        $strings['NoImage'] = 'Nenhuma imagem';
        $strings['Move'] = 'Mover';
        $strings['AppearsOn'] = 'Aparece em %s';
        $strings['Location'] = 'Local';
        $strings['NoLocationLabel'] = '(nenhum local definido)';
        $strings['Contact'] = 'Contato';
        $strings['NoContactLabel'] = '(nenhuma informação de contato)';
        $strings['Description'] = 'Descrição';
        $strings['NoDescriptionLabel'] = '(nenhuma descrição)';
        $strings['Notes'] = 'Notas';
        $strings['NoNotesLabel'] = '(nenhuma nota)';
        $strings['NoTitleLabel'] = '(nenhum título)';
        $strings['UsageConfiguration'] = 'Configuração de utilização';
        $strings['ChangeConfiguration'] = 'Alterar configuração';
        $strings['ResourceMinLength'] = 'As reservas devem durar pelo menos %s';
        $strings['ResourceMinLengthNone'] = 'Não há uma duração mínima de reserva';
        $strings['ResourceMaxLength'] = 'As reservas não podem durar mais de %s';
        $strings['ResourceMaxLengthNone'] = 'Não há uma duração máxima de reserva';
        $strings['ResourceRequiresApproval'] = 'As reservas devem ser aprovadas';
        $strings['ResourceRequiresApprovalNone'] = 'Reservas não necessitam aprovação';
        $strings['ResourcePermissionAutoGranted'] = 'A permissão é concedida automaticamente';
        $strings['ResourcePermissionNotAutoGranted'] = 'A permissão não é concedida automaticamente';
        $strings['ResourceMinNotice'] = 'As reservas devem ser feitas pelo menos %s antes da hora de início';
        $strings['ResourceMinNoticeNone'] = 'As reservas podem ser feitas até o tempo atual';
        $strings['ResourceMaxNotice'] = 'As reservas não devem terminar mais de %s a partir do tempo atual';
        $strings['ResourceMaxNoticeNone'] = 'As reservas podem acabar a qualquer momento no futuro';
        $strings['ResourceAllowMultiDay'] = 'As reservas podem ser feitas através de dias';
        $strings['ResourceNotAllowMultiDay'] = 'As reservas não podem ser feitas através de dias';
        $strings['ResourceCapacity'] = 'Este recurso tem uma capacidade de %s pessoas';
        $strings['ResourceCapacityNone'] = 'Esse recurso tem capacidade ilimitada';
        $strings['AddNewResource'] = 'Adicionar novo recurso';
        $strings['AddNewUser'] = 'Adicionar novo utilizador';
        $strings['AddUser'] = 'Adicionar utilizador';
        $strings['Schedule'] = 'Agenda';
        $strings['AddResource'] = 'Adicionar recurso';
        $strings['Capacity'] = 'Capacidade';
        $strings['Access'] = 'Acesso';
        $strings['Duration'] = 'Duração';
        $strings['Active'] = 'Ativo';
        $strings['Inactive'] = 'Inativo';
        $strings['ResetPassword'] = 'Redefinir senha';
        $strings['LastLogin'] = 'Último acesso';
        $strings['Search'] = 'Pesquisar';
        $strings['ResourcePermissions'] = 'Permissões de recursos';
        $strings['Reservations'] = 'Reservas';
        $strings['Groups'] = 'Grupos';
        $strings['ResetPassword'] = 'Redefinir senha';
        $strings['AllUsers'] = 'Todos os utilizadores';
        $strings['AllGroups'] = 'Todos os grupos';
        $strings['AllSchedules'] = 'Todas as agendas';
        $strings['UsernameOrEmail'] = 'Utilizador ou E-mail';
        $strings['Members'] = 'Membros';
        $strings['QuickSlotCreation'] = 'Criar intervalos a cada %s minutos entre %s e %s';
        $strings['ApplyUpdatesTo'] = 'Aplicar atualizações para';
        $strings['CancelParticipation'] = 'Cancelar participação';
        $strings['Attending'] = 'Atender';
        $strings['QuotaConfiguration'] = 'Em %s para %s utilizadores em %s estão limitados a %s %s por %s';
        $strings['reservations'] = 'reservas';
        $strings['ChangeCalendar'] = 'Alterar calendário';
        $strings['AddQuota'] = 'Adicionar quota';
        $strings['FindUser'] = 'Encontrar utilizador';
        $strings['Created'] = 'Criado';
        $strings['LastModified'] = 'Última modificação';
        $strings['GroupName'] = 'Nome do grupo';
        $strings['GroupMembers'] = 'Membros do grupo';
        $strings['GroupRoles'] = 'Regras do grupo';
        $strings['GroupAdmin'] = 'Administrador do grupo';
        $strings['Actions'] = 'Ações';
        $strings['CurrentPassword'] = 'Senha atual';
        $strings['NewPassword'] = 'Nova senha';
        $strings['InvalidPassword'] = 'Senha atual está incorreta';
        $strings['PasswordChangedSuccessfully'] = 'A sua senha foi alterada com sucesso';
        $strings['SignedInAs'] = 'Logado como';
        $strings['NotSignedIn'] = 'Não está logado';
        $strings['ReservationTitle'] = ' Título da reserva';
        $strings['ReservationDescription'] = 'Descrição da reserva';
        $strings['ResourceList'] = 'Recursos a serem reservados';
        $strings['Accessories'] = 'Acessórios';
        $strings['Add'] = 'Adicionar';
        $strings['ParticipantList'] = 'Participantes';
        $strings['InvitationList'] = 'Convidados';
        $strings['AccessoryName'] = 'Nome do acessório';
        $strings['QuantityAvailable'] = 'Quantidade disponível';
        $strings['Resources'] = 'Recursos';
        $strings['Participants'] = 'Participantes';
        $strings['User'] = 'Utilizador';
        $strings['Resource'] = 'Recurso';
        $strings['Status'] = 'Estado';
        $strings['Approve'] = 'Aprovar';
        $strings['Page'] = 'Página';
        $strings['Rows'] = 'Linhas';
        $strings['Unlimited'] = 'Ilimitado';
        $strings['Email'] = 'E-mail';
        $strings['EmailAddress'] = 'Endereço de e-mail';
        $strings['Phone'] = 'Telefone';
        $strings['Organization'] = 'Morada';
        $strings['Position'] = 'Posição';
        $strings['Language'] = 'Idioma';
        $strings['Permissions'] = 'Permissões';
        $strings['Reset'] = 'Redefenir';
        $strings['FindGroup'] = 'Encontrar grupo';
        $strings['Manage'] = 'Gerir';
        $strings['None'] = 'Nenhum';
        $strings['AddToOutlook'] = 'Adicionar ao Outlook';
        $strings['Done'] = 'Concluído';
        $strings['RememberMe'] = 'Manter sessão iniciada';
        $strings['FirstTimeUser?'] = 'Está a usar pela primeira vez?';
        $strings['CreateAnAccount'] = 'Criar conta';
        $strings['ViewSchedule'] = 'Ver agendas';
        $strings['ForgotMyPassword'] = 'Esqueci-me da minha senha';
        $strings['YouWillBeEmailedANewPassword'] = 'Receberá um e-mail com uma nova senha gerada aleatoriamente';
        $strings['Close'] = 'Fechar';
        $strings['ExportToCSV'] = 'Exportar para CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Trabalhando...';
        $strings['Login'] = 'Entrar';
        $strings['AdditionalInformation'] = 'Informações adicionais';
        $strings['AllFieldsAreRequired'] = 'Todos os campos são obrigatórios';
        $strings['Optional'] = 'Opcional';
        $strings['YourProfileWasUpdated'] = 'O seu perfil foi atualizado';
        $strings['YourSettingsWereUpdated'] = 'As suas configurações foram atualizadas';
        $strings['Register'] = 'Registar';
        $strings['SecurityCode'] = 'Código de Segurança';
        $strings['ReservationCreatedPreference'] = 'Quando eu criar uma reserva ou uma reserva é criada em meu nome';
        $strings['ReservationUpdatedPreference'] = 'Quando eu atualizar uma reserva ou uma reserva é atualizada em meu nome';
	$strings['ReservationDeletedPreference'] = 'Quando eu excluir uma reserva ou uma reserva é excluída em meu nome';
        $strings['ReservationApprovalPreference'] = 'Quando minha reserva pendente é aprovada';
        $strings['PreferenceSendEmail'] = 'Enviar um e-mail';
        $strings['PreferenceNoEmail'] = 'Não me notificar';
        $strings['ReservationCreated'] = 'A sua reserva foi criada com sucesso!';
        $strings['ReservationUpdated'] = 'A sua reserva foi atualizada com sucesso!';
        $strings['ReservationRemoved'] = 'A sua reserva foi removida';
        $strings['YourReferenceNumber'] = 'O seu número de referência é %s';
        $strings['UpdatingReservation'] = 'Atualizando a reserva';
        $strings['ChangeUser'] = 'Alterar utilizador';
        $strings['MoreResources'] = 'Mais Recursos';
        $strings['ReservationLength'] = 'Duração da reserva';
        $strings['ParticipantList'] = 'Lista de participantes';
        $strings['AddParticipants'] = 'Adicionar participantes';
        $strings['InviteOthers'] = 'Convidar outros';
        $strings['AddResources'] = 'Adicionar recursos';
        $strings['AddAccessories'] = 'Adicionar acessórios';
        $strings['Accessory'] = 'Acessório';
        $strings['QuantityRequested'] = 'Quantidade solicitada';
        $strings['CreatingReservation'] = 'Criação de reserva';
        $strings['UpdatingReservation'] = 'Atualizando reserva';
        $strings['DeleteWarning'] = 'Esta ação é permanente e irrecuperável!';
        $strings['DeleteAccessoryWarning'] = 'Apagar este acessório irá removê-lo de todas as reservas.';
        $strings['AddAccessory'] = 'Adicionar acessório';
        $strings['AddBlackout'] = 'Adicionar horário indisponível';
        $strings['AllResourcesOn'] = 'Todos recursos em';
        $strings['Reason'] = 'Razão';
        $strings['BlackoutShowMe'] = 'Mostrar reservas em conflito';
        $strings['BlackoutDeleteConflicts'] = 'Excluir reservas em conflito';
        $strings['Filter'] = 'Filtro';
        $strings['Between'] = 'Entre';
        $strings['CreatedBy'] = 'Criado por';
        $strings['BlackoutCreated'] = 'Horário indisponível criado!';
        $strings['BlackoutNotCreated'] = 'Horário indisponível não pôde ser criado!';
        $strings['BlackoutConflicts'] = 'Existem horários indisponíveis em conflito';
        $strings['ReservationConflicts'] = 'Existem horários de reservas em conflito';
        $strings['UsersInGroup'] = 'Utilizadores neste grupo';
        $strings['Browse'] = 'Navegar';
        $strings['DeleteGroupWarning'] = 'Apagar este grupo irá remover todas as permissões de recursos associados. Os utilizadores deste grupo podem perder o acesso aos recursos.';
        $strings['WhatRolesApplyToThisGroup'] = 'Que regras se aplicam a este grupo?';
        $strings['WhoCanManageThisGroup'] = 'Quem pode gerir este grupo?';
        $strings['AddGroup'] = 'Adicionar grupo';
        $strings['AllQuotas'] = 'Todas as quotas';
        $strings['QuotaReminder'] = 'Lembre-se: As quotas são aplicadas com base no fuso horário da agenda.';
        $strings['AllReservations'] = 'Todas as reservas';
        $strings['PendingReservations'] = 'Reservas pendentes';
        $strings['Approving'] = 'Aprovar';
        $strings['MoveToSchedule'] = 'Mover para agenda';
        $strings['DeleteResourceWarning'] = 'Apagar este recurso irá apagar todos os dados associados, incluindo';
        $strings['DeleteResourceWarningReservations'] = 'todas as reservas passadas, atuais e futuras associados';
        $strings['DeleteResourceWarningPermissions'] = 'todas as atribuições de permissão';
        $strings['DeleteResourceWarningReassign'] = 'Por favor, reatribuir qualquer coisa que não queira que seja eliminado antes de prosseguir';
        $strings['ScheduleLayout'] = 'Layout (todos os horários %s)';
        $strings['ReservableTimeSlots'] = 'Intervalos de horários reserváveis';
        $strings['BlockedTimeSlots'] = 'Intervalos de horários bloqueados';
        $strings['ThisIsTheDefaultSchedule'] = 'Esta é a agenda padrão';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Agenda padrão não pode ser apagada';
        $strings['MakeDefault'] = 'Tornar padrão';
        $strings['BringDown'] = 'Mover para baixo';
        $strings['ChangeLayout'] = 'Mudar layout';
        $strings['AddSchedule'] = 'Adicionar agenda';
        $strings['StartsOn'] = 'Inicia em';
        $strings['NumberOfDaysVisible'] = 'Número de dias visíveis';
        $strings['UseSameLayoutAs'] = 'Usar o mesmo layout como';
        $strings['Format'] = 'Formato';
        $strings['OptionalLabel'] = 'Título opcional';
        $strings['LayoutInstructions'] = 'Digite um intervalo por linha. Intervalos devem ser fornecidos para todas as 24 horas do dia começando e terminando às 12:00.';
        $strings['AddUser'] = 'Adicionar utilizador';
        $strings['UserPermissionInfo'] = 'O acesso efetivo ao recurso pode ser diferente dependendo da função do utilizador, permissões de grupo, ou definições de permissões externas';
        $strings['DeleteUserWarning'] = 'Apagar este usuário irá remover todas as suas reservas atuais, futuros e histórico.';
        $strings['AddAnnouncement'] = 'Adicionar anúncio';
        $strings['Announcement'] = 'Anúncio';
        $strings['Priority'] = 'Prioridade';
        $strings['Reservable'] = 'Reservável';
        $strings['Unreservable'] = 'Não reservável';
        $strings['Reserved'] = 'Reservados';
        $strings['MyReservation'] = 'As minhas reservas';
        $strings['Pending'] = 'Pendente';
        $strings['Past'] = 'Passado';
        $strings['Restricted'] = 'Restrito';
        $strings['ViewAll'] = 'Ver todos';
        $strings['MoveResourcesAndReservations'] = 'Mover recursos e reservas para';
        $strings['TurnOffSubscription'] = 'Desligar assinaturas de calendário';
        $strings['TurnOnSubscription'] = 'Permitir assinaturas para este calendário';
        $strings['SubscribeToCalendar'] = 'Assinar este calendário';
        $strings['SubscriptionsAreDisabled'] = 'O administrador desabilitou assinaturas de calendário';
        $strings['NoResourceAdministratorLabel'] = '(Nenhum administrador de recursos)';
        $strings['WhoCanManageThisResource'] = 'Quem pode gerir este recurso?';
        $strings['ResourceAdministrator'] = 'Administrador de recursos';
        $strings['Private'] = 'Privado';
        $strings['Accept'] = 'Aceitar';
        $strings['Decline'] = 'Recusar';
        $strings['ShowFullWeek'] = 'Mostrar semana completa';
        $strings['CustomAttributes'] = 'Atributos personalizados';
        $strings['AddAttribute'] = 'Adicionar um atributo';
        $strings['EditAttribute'] = 'Atualizar um atributo';
        $strings['DisplayLabel'] = 'Mostrar rótulo';
        $strings['Type'] = 'Tipo';
        $strings['Required'] = 'Obrigatório';
        $strings['ValidationExpression'] = 'Expressão de validação';
        $strings['PossibleValues'] = 'Valores possíveis';
        $strings['SingleLineTextbox'] = 'Caixa de texto de linha única';
        $strings['MultiLineTextbox'] = 'Caixa de texto de várias linhas';
        $strings['Checkbox'] = 'Caixa de seleção';
        $strings['SelectList'] = 'Lista de seleção';
        $strings['CommaSeparated'] = 'separados por vírgula';
        $strings['Category'] = 'Categoria';
        $strings['CategoryReservation'] = 'Reservar';
        $strings['CategoryGroup'] = 'Grupo';
        $strings['SortOrder'] = 'Ordem';
        $strings['Title'] = 'Título';
        $strings['AdditionalAttributes'] = 'Atributos adicionais';
        $strings['True'] = 'Verdadeiro';
        $strings['False'] = 'Falso';
	$strings['ForgotPasswordEmailSent'] = 'Um e-mail foi enviado para o endereço fornecido com instruções para redefinir a sua senha';
	$strings['ActivationEmailSent'] = 'Irá receber um e-mail de ativação em breve.';
	$strings['AccountActivationError'] = 'Desculpe, não foi possível ativar a sua conta.';
	$strings['Attachments'] = 'Anexos';
	$strings['AttachFile'] = 'Anexar arquivo';
	$strings['Maximum'] = 'máximo';
        // End Strings

        // Errors
        $strings['LoginError'] = 'Não foi possível encontrar seu utilizador ou senha';
        $strings['ReservationFailed'] = 'A sua reserva não pôde ser feita';
        $strings['MinNoticeError'] = 'Esta reserva exige aviso prévio. A data mais próxima em que pode ser reservado é %s.';
        $strings['MaxNoticeError'] = 'Esta reserva não pode ser feita tão longe no futuro. A última data em que pode ser reservado é %s.';
        $strings['MinDurationError'] = 'Esta reserva deve durar pelo menos %s.';
        $strings['MaxDurationError'] = 'Esta reserva não pode durar mais do que %s.';
        $strings['ConflictingAccessoryDates'] = 'Não são suficientes os seguintes acessórios:';
        $strings['NoResourcePermission'] = 'Não tem permissão para aceder a um ou mais dos recursos solicitados';
        $strings['ConflictingReservationDates'] = 'Há reservas em conflito nas seguintes datas:';
        $strings['StartDateBeforeEndDateRule'] = 'A data de início deve ser anterior à data de término';
        $strings['StartIsInPast'] = 'A data de início não pode ser no passado';
        $strings['EmailDisabled'] = 'O administrador desabilitou as notificações de e-mail';
        $strings['ValidLayoutRequired'] = 'Intervalos devem ser fornecidos para todas as 24 horas do dia começando e terminando às 12:00.';
        $strings['CustomAttributeErrors'] = 'Há problemas com os atributos adicionais que forneceu:';
        $strings['CustomAttributeRequired'] = '%s é um campo obrigatório';
        $strings['CustomAttributeInvalid'] = 'O valor fornecido para %s é inválido';
        $strings['AttachmentLoadingError'] = 'Desculpe, houve um problema ao carregar o arquivo solicitado.';
        $strings['InvalidAttachmentExtension'] = 'Só pode fazer upload de arquivos do tipo: %s';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Criar Reservas';
        $strings['EditReservation'] = 'Editar Reservas';
        $strings['LogIn'] = 'Entrar';
        $strings['ManageReservations'] = 'Reservas';
        $strings['AwaitingActivation'] = 'Aguardando Ativação';
        $strings['PendingApproval'] = 'Aguardando Aprovação';
        $strings['ManageSchedules'] = 'Agendas';
        $strings['ManageResources'] = 'Recursos';
        $strings['ManageAccessories'] = 'Acessórios';
        $strings['ManageUsers'] = 'Utilizadores';
        $strings['ManageGroups'] = 'Grupos';
        $strings['ManageQuotas'] = 'Quotas';
        $strings['ManageBlackouts'] = 'Horários Indisponíveis';
        $strings['MyDashboard'] = 'O Meu Painel de Controlo';
        $strings['ServerSettings'] = 'Configurações do Servidor';
        $strings['Dashboard'] = 'Painel de Controlo';
        $strings['Help'] = 'Ajuda';
        $strings['Bookings'] = 'Reservas';
        $strings['Schedule'] = 'Agenda';
        $strings['Reservations'] = 'Reservas';
        $strings['Account'] = 'Conta';
        $strings['EditProfile'] = 'Editar o Meu Perfil';
        $strings['FindAnOpening'] = 'Encontrar Uma Abertura';
        $strings['OpenInvitations'] = 'Abrir Convites';
        $strings['MyCalendar'] = 'O Meu Calendário';
        $strings['ResourceCalendar'] = 'Calendário de Recursos';
        $strings['Reservation'] = 'Nova Reserva';
        $strings['Install'] = 'Instalação';
        $strings['ChangePassword'] = 'Alterar Senha';
        $strings['MyAccount'] = 'A Minha Conta';
        $strings['Profile'] = 'Perfil';
        $strings['ApplicationManagement'] = 'Gestão da Aplicação';
        $strings['ForgotPassword'] = 'Esqueceu-se da sua Senha';
        $strings['NotificationPreferences'] = 'Preferências de Notificação';
        $strings['ManageAnnouncements'] = 'Anúncios';
        $strings['Responsibilities'] = 'Responsabilidades';
        $strings['GroupReservations'] = 'Reservas para Grupos';
        $strings['ResourceReservations'] = 'Reservas de Recurso';
        $strings['Customization'] = 'Personalização';
        $strings['Attributes'] = 'Atributos';
	$strings['AccountActivation'] = 'Ativação da Conta';
        // End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'D';
        $strings['DayMondaySingle'] = 'S';
        $strings['DayTuesdaySingle'] = 'T';
        $strings['DayWednesdaySingle'] = 'Q';
        $strings['DayThursdaySingle'] = 'Q';
        $strings['DayFridaySingle'] = 'S';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'Dom';
        $strings['DayMondayAbbr'] = 'Seg';
        $strings['DayTuesdayAbbr'] = 'Ter';
        $strings['DayWednesdayAbbr'] = 'Qua';
        $strings['DayThursdayAbbr'] = 'Qui';
        $strings['DayFridayAbbr'] = 'Sex';
        $strings['DaySaturdayAbbr'] = 'Sáb';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'A sua reserva foi aprovada';
        $strings['ReservationCreatedSubject'] = 'A sua reserva foi criada';
        $strings['ReservationUpdatedSubject'] = 'A sua reserva foi atualizada';
        $strings['ReservationDeletedSubject'] = 'A sua reserva foi removida';
        $strings['ReservationCreatedAdminSubject'] = 'Notificação: A reserva foi criada';
        $strings['ReservationUpdatedAdminSubject'] = 'Notificação: A reserva foi atualizada';
        $strings['ReservationDeleteAdminSubject'] = 'Notificação: A reserva foi removida';
        $strings['ParticipantAddedSubject'] = 'Notificação de participação na reserva';
        $strings['ParticipantDeletedSubject'] = 'Reserva removida';
        $strings['InviteeAddedSubject'] = 'Convite de reserva';
        $strings['ResetPassword'] = 'Pedido de redefinição de senha';
        $strings['ActivateYourAccount'] = 'Por favor ative a sua conta';
        //

        $this->Strings = $strings;

        return $this->Strings;
    }

    /**
     * @return array
     */
    protected function _LoadDays()
    {
        $days = array();

        /***
        DAY NAMES
        All of these arrays MUST start with Sunday as the first element
        and go through the seven day week, ending on Saturday
         ***/
        // The full day name
        $days['full'] = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
        // The three letter abbreviation
        $days['abbr'] = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb');
        // The two letter abbreviation
        $days['two'] = array('Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sá');
        // The one letter abbreviation
        $days['letter'] = array('D', 'S', 'T', 'Q', 'Q', 'S', 'S');

        $this->Days = $days;

        return $this->Days;
    }

    /**
     * @return array
     */
    protected function _LoadMonths()
    {
        $months = array();

        /***
        MONTH NAMES
        All of these arrays MUST start with January as the first element
        and go through the twelve months of the year, ending on December
         ***/
        // The full month name
        $months['full'] = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        // The three letter month name
        $months['abbr'] = array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');

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
        return 'pt-pt';
    }
}

?>