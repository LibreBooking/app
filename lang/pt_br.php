<?php
/**
Copyright 2011-2020 Nick Korbel

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
require_once('en_gb.php');

class pt_br extends en_gb
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
    $strings['LastName'] = 'Sobrenome';
    $strings['Timezone'] = 'Fuso Horário';
    $strings['Edit'] = 'Editar';
    $strings['Change'] = 'Alterar';
    $strings['Rename'] = 'Renomear';
    $strings['Remove'] = 'Remover';
    $strings['Delete'] = 'Excluir';
    $strings['Update'] = 'Atualizar';
    $strings['Cancel'] = 'Cancelar';
    $strings['Add'] = 'Adicionar';
    $strings['Name'] = 'Nome';
    $strings['Yes'] = 'Sim';
    $strings['No'] = 'Não';
    $strings['FirstNameRequired'] = 'Nome é obrigatório.';
    $strings['LastNameRequired'] = 'Sobrenome é obrigatório.';
    $strings['PwMustMatch'] = 'Confirmação de senha devem coincidir com a senha.';
    $strings['PwComplexity'] = 'A senha deve ter pelo menos 6 caracteres com uma combinação de letras, números e símbolos.';
    $strings['ValidEmailRequired'] = 'Um endereço de e-mail válido é obrigatório.';
    $strings['UniqueEmailRequired'] = 'Este endereço de e-mail já está registrado.';
    $strings['UniqueUsernameRequired'] = 'Esse nome de usuário já está registrado.';
    $strings['UserNameRequired'] = 'Nome de usuário é obrigatório.';
    $strings['CaptchaMustMatch'] = 'Por favor digite as letras da imagem de segurança exatamente como mostrado.';
    $strings['Today'] = 'Hoje';
    $strings['Week'] = 'Semana';
    $strings['Month'] = 'Mês';
    $strings['BackToCalendar'] = 'Voltar ao calendário';
    $strings['BeginDate'] = 'Início';
    $strings['EndDate'] = 'Final';
    $strings['Username'] = 'Usuário';
    $strings['Password'] = 'Senha';
    $strings['PasswordConfirmation'] = 'Confirmar Senha';
    $strings['DefaultPage'] = 'Página Inicial Padrão';
    $strings['MyCalendar'] = 'Meu Calendário';
    $strings['ScheduleCalendar'] = 'Calendário de Agendas';
    $strings['Registration'] = 'Registro';
    $strings['NoAnnouncements'] = 'Não há anúncios';
    $strings['Announcements'] = 'Anúncios';
    $strings['NoUpcomingReservations'] = 'Você não tem reservas futuras';
    $strings['UpcomingReservations'] = 'Reservas Futuras';
    $strings['AllNoUpcomingReservations'] = 'Não existem reservas futuras';
    $strings['AllUpcomingReservations'] = 'Todas as reservas futuras';
    $strings['ShowHide'] = 'Mostrar/Esconder';
    $strings['Error'] = 'Erro';
    $strings['ReturnToPreviousPage'] = 'Retornar para a última página que você estava';
    $strings['UnknownError'] = 'Erro Desconhecido';
    $strings['InsufficientPermissionsError'] = 'Você não tem permissão para acessar este recurso';
    $strings['MissingReservationResourceError'] = 'Um recurso não foi selecionado';
    $strings['MissingReservationScheduleError'] = 'A agenda não foi selecionada';
    $strings['DoesNotRepeat'] = 'Não repetir';
    $strings['Daily'] = 'Diário';
    $strings['Weekly'] = 'Semanal';
    $strings['Monthly'] = 'Mensal';
    $strings['Yearly'] = 'Anual';
    $strings['RepeatPrompt'] = 'Repetir';
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
    $strings['RepeatEveryPrompt'] = 'A Cada';
    $strings['RepeatDaysPrompt'] = 'Em';
    $strings['CreateReservationHeading'] = 'Criar uma nova reserva';
    $strings['EditReservationHeading'] = 'Edição de reserva %s';
    $strings['ViewReservationHeading'] = 'Vendo reserva %s';
    $strings['ReservationErrors'] = 'Alterar Reserva';
    $strings['Create'] = 'Criar';
    $strings['ThisInstance'] = 'Apenas Esta Instância';
    $strings['AllInstances'] = 'Todas as Instâncias';
    $strings['FutureInstances'] = 'Instâncias Futuras';
    $strings['Print'] = 'Imprimir';
    $strings['ShowHideNavigation'] = 'Mostrar/Esconder Navegação';
    $strings['ReferenceNumber'] = 'Número de Referência';
    $strings['Tomorrow'] = 'Amanhã';
    $strings['LaterThisWeek'] = 'Ainda esta semana';
    $strings['NextWeek'] = 'Próxima Semana';
    $strings['SignOut'] = 'Sair';
    $strings['LayoutDescription'] = 'Inicia em %s, mostrando %s dias de uma só vez';
    $strings['AllResources'] = 'Todos os Recursos';
    $strings['TakeOffline'] = 'Colocar Offline';
    $strings['BringOnline'] = 'Colocar Online';
    $strings['AddImage'] = 'Adicionar Imagem';
    $strings['NoImage'] = 'Nenhuma Imagem Atribuída';
    $strings['Move'] = 'Mover';
    $strings['AppearsOn'] = 'Aparece Em %s';
    $strings['Location'] = 'Local';
    $strings['NoLocationLabel'] = '(Nenhum local definido)';
    $strings['Contact'] = 'Contato';
    $strings['NoContactLabel'] = '(Nenhuma informação do contato)';
    $strings['Description'] = 'Descrição';
    $strings['NoDescriptionLabel'] = '(Nenhuma descrição)';
    $strings['Notes'] = 'Notas';
    $strings['NoNotesLabel'] = '(Nenhuma nota)';
    $strings['NoTitleLabel'] = '(Nenhum título)';
    $strings['UsageConfiguration'] = 'Configuração de Uso';
    $strings['ChangeConfiguration'] = 'Alterar Configuração';
    $strings['ResourceMinLength'] = 'As reservas devem durar pelo menos %s';
    $strings['ResourceMinLengthNone'] = 'Não há uma duração mínima de reserva';
    $strings['ResourceMaxLength'] = 'As reservas não podem durar mais de %s';
    $strings['ResourceMaxLengthNone'] = 'Não há uma duração máxima de reserva';
    $strings['ResourceRequiresApproval'] = 'As reservas devem ser aprovadas';
    $strings['ResourceRequiresApprovalNone'] = 'Reservas não necessitam de aprovação';
    $strings['ResourcePermissionAutoGranted'] = 'A permissão é concedida automaticamente';
    $strings['ResourcePermissionNotAutoGranted'] = 'A permissão não é concedida automaticamente';
    $strings['ResourceMinNotice'] = 'As reservas devem ser feitas pelo menos %s antes da hora de início';
    $strings['ResourceMinNoticeNone'] = 'As reservas podem ser feitas até a hora atual';
    $strings['ResourceMaxNotice'] = 'As reservas não deve terminar mais de %s a partir da hora atual';
    $strings['ResourceMaxNoticeNone'] = 'As reservas podem acabar a qualquer momento no futuro';
    $strings['ResourceBufferTime'] = 'Precisa ter %s entre as reservas';
    $strings['ResourceBufferTimeNone'] = 'Não existem barreiras entre as reservas';
    $strings['ResourceAllowMultiDay'] = 'As reservas podem ser feitas através de dias';
    $strings['ResourceNotAllowMultiDay'] = 'As reservas não podem ser feitas através de dias';
    $strings['ResourceCapacity'] = 'Este recurso tem uma capacidade de %s pessoas';
    $strings['ResourceCapacityNone'] = 'Esse recurso tem capacidade ilimitada';
    $strings['AddNewResource'] = 'Adicionar Novo Recurso';
    $strings['AddNewUser'] = 'Adicionar Novo Usuário';
    $strings['AddUser'] = 'Adicionar Usuário';
    $strings['Schedule'] = 'Agenda';
    $strings['Schedules'] = 'Agendas';
    $strings['AddResource'] = 'Adicionar Recurso';
    $strings['Capacity'] = 'Capacidade';
    $strings['Access'] = 'Acesso';
    $strings['Duration'] = 'Duração';
    $strings['Active'] = 'Ativo';
    $strings['Inactive'] = 'Inativo';
    $strings['ResetPassword'] = 'Redefinir Senha';
    $strings['LastLogin'] = 'Último Acesso';
    $strings['Search'] = 'Pesquisar';
    $strings['ResourcePermissions'] = 'Permissões de Recursos';
    $strings['Reservations'] = 'Reservas';
    $strings['Groups'] = 'Grupos';
    $strings['ResetPassword'] = 'Redefinir Senha';
    $strings['AllUsers'] = 'Todos os Usuários';
    $strings['AllGroups'] = 'Todos os Grupos';
    $strings['AllSchedules'] = 'Todas as Agendas';
    $strings['UsernameOrEmail'] = 'Usuário ou Email';
    $strings['Members'] = 'Membros';
    $strings['QuickSlotCreation'] = 'Criar faixas a cada %s minutos entre %s e %s';
    $strings['ApplyUpdatesTo'] = 'Aplicar Atualizações Para';
    $strings['CancelParticipation'] = 'Cancelar Participação';
    $strings['Attending'] = 'Atender';
    $strings['QuotaConfiguration'] = 'Em %s para %s usuários em %s estão limitados a %s %s por %s';
    $strings['reservations'] = 'reservas';
    $strings['reservation'] = 'reserva';
    $strings['ChangeCalendar'] = 'Alterar Calendário';
    $strings['AddQuota'] = 'Adicionar Cota';
    $strings['FindUser'] = 'Encontrar Usuário';
    $strings['Created'] = 'Criado';
    $strings['LastModified'] = 'Última Modificação';
    $strings['GroupName'] = 'Nome do Grupo';
    $strings['GroupMembers'] = 'Membros do Grupo';
    $strings['GroupRoles'] = 'Regras do Grupo';
    $strings['GroupAdmin'] = 'Administrador do Grupo';
    $strings['Actions'] = 'Ações';
    $strings['CurrentPassword'] = 'Senha Atual';
    $strings['NewPassword'] = 'Nova Senha';
    $strings['InvalidPassword'] = 'Senha atual está incorreto';
    $strings['PasswordChangedSuccessfully'] = 'Sua senha foi alterada com sucesso';
    $strings['SignedInAs'] = 'Conectado como';
    $strings['NotSignedIn'] = 'Você não está logado';
    $strings['ReservationTitle'] = 'Título da reserva';
    $strings['ReservationDescription'] = 'Descrição da reserva';
    $strings['ResourceList'] = 'Recursos a serem reservados';
    $strings['Accessories'] = 'Acessórios';
    $strings['Add'] = 'Adicionar';
    $strings['ParticipantList'] = 'Participantes';
    $strings['InvitationList'] = 'Convidados';
    $strings['AccessoryName'] = 'Nome do Acessório';
    $strings['QuantityAvailable'] = 'Quantidade Disponível';
    $strings['Resources'] = 'Recursos';
    $strings['Participants'] = 'Participantes';
    $strings['User'] = 'Usuário';
    $strings['Resource'] = 'Recurso';
    $strings['Status'] = 'Estado';
    $strings['Approve'] = 'Aprovar';
    $strings['Page'] = 'Página';
    $strings['Rows'] = 'Linhas';
    $strings['Unlimited'] = 'Ilimitado';
    $strings['Email'] = 'Email';
    $strings['EmailAddress'] = 'Endereço de Email';
    $strings['Phone'] = 'Telefone';
    $strings['Organization'] = 'Organização';
    $strings['Position'] = 'Posição';
    $strings['Language'] = 'Idioma';
    $strings['Permissions'] = 'Permissões';
    $strings['Reset'] = 'Resetar';
    $strings['FindGroup'] = 'Encontrar Grupo';
    $strings['Manage'] = 'Gerenciar';
    $strings['None'] = 'Nenhum';
    $strings['AddToOutlook'] = 'Adicionar ao Outlook';
    $strings['Done'] = 'Concluído';
    $strings['RememberMe'] = 'Lembrar-se de Mim';
    $strings['FirstTimeUser?'] = 'Usuário Novo?';
    $strings['CreateAnAccount'] = 'Criar Uma Conta';
    $strings['ViewSchedule'] = 'Ver Agendas';
    $strings['ForgotMyPassword'] = 'Eu Esqueci Minha Senha';
    $strings['YouWillBeEmailedANewPassword'] = 'Você receberá um email uma nova senha gerada aleatoriamente';
    $strings['Close'] = 'Fechar';
    $strings['ExportToCSV'] = 'Exportar para CSV';
    $strings['OK'] = 'OK';
    $strings['Working'] = 'Trabalhando...';
    $strings['Login'] = 'Login';
    $strings['AdditionalInformation'] = 'Informações Adicionais';
    $strings['AllFieldsAreRequired'] = 'todos os campos são obrigatórios';
    $strings['Optional'] = 'opcional';
    $strings['YourProfileWasUpdated'] = 'Seu perfil foi atualizado';
    $strings['YourSettingsWereUpdated'] = 'Suas configurações foram atualizadas';
    $strings['Register'] = 'Registrar';
    $strings['SecurityCode'] = 'Código de Segurança';
    $strings['ReservationCreatedPreference'] = 'Quando eu criar uma reserva ou uma reserva é criada em meu nome';
    $strings['ReservationUpdatedPreference'] = 'Quando eu atualizar uma reserva ou uma reserva é atualizada em meu nome';
    $strings['ReservationApprovalPreference'] = 'Quando minha reserva pendente é aprovada';
    $strings['ReservationDeletedPreference'] = 'Quando eu deletar uma reserva ou uma reserva é deletada em meu nome';
    $strings['PreferenceSendEmail'] = 'Envie-me um e-mail';
    $strings['PreferenceNoEmail'] = 'Não me notificar';
    $strings['ReservationCreated'] = 'A sua reserva foi criada com sucesso!';
    $strings['ReservationUpdated'] = 'A sua reserva foi atualizada com sucesso!';
    $strings['ReservationRemoved'] = 'A sua reserva foi removida';
    $strings['ReservationRequiresApproval'] = 'Um ou mais recussos reservados requerem aprovação antes de serem usados e estarão pendentes até aprovação.';
    $strings['YourReferenceNumber'] = 'O seu número de referência é %s';
    $strings['UpdatingReservation'] = 'Atualizando Reserva';
    $strings['ChangeUser'] = 'Alterar Usuário';
    $strings['MoreResources'] = 'Mais Recursos';
    $strings['ReservationLength'] = 'Duração da Reserva';
    $strings['ParticipantList'] = 'Lista de Participantes';
    $strings['AddParticipants'] = 'Adicionar Participantes';
    $strings['InviteOthers'] = 'Convidar Outros';
    $strings['AddResources'] = 'Adicionar Recursos';
    $strings['AddAccessories'] = 'Adicionar Acessórios';
    $strings['Accessory'] = 'Acessório';
    $strings['QuantityRequested'] = 'Quantidade Solicitada';
    $strings['CreatingReservation'] = 'Criação de Reserva';
    $strings['UpdatingReservation'] = 'Atualizando Reserva';
    $strings['DeleteWarning'] = 'Esta ação é permanente e irrecuperável!';
    $strings['DeleteAccessoryWarning'] = 'Excluindo este acessório irá removê-lo de todas as reservas.';
    $strings['AddAccessory'] = 'Adicionar Acessório';
    $strings['AddBlackout'] = 'Adicionar Horário Indisponível';
    $strings['AllResourcesOn'] = 'Todos os recursos em';
    $strings['Reason'] = 'Razão';
    $strings['BlackoutShowMe'] = 'Mostre-me reservas conflitantes';
    $strings['BlackoutDeleteConflicts'] = 'Excluir reservas conflitantes';
    $strings['Filter'] = 'Filtro';
    $strings['Between'] = 'Entre';
    $strings['CreatedBy'] = 'Criado Por';
    $strings['BlackoutCreated'] = 'Horário indisponível criado!';
    $strings['BlackoutNotCreated'] = 'Horário indisponível não pôde ser criado!';
    $strings['BlackoutUpdated'] = 'Horário indisponível atualizado!';
    $strings['BlackoutNotUpdated'] = 'Horário indisponível não foi atualizado!';
    $strings['BlackoutConflicts'] = 'Existem conflitos entre horários indisponíveis.';
    $strings['ReservationConflicts'] = 'Existem conflitos entre horários reservados.';
    $strings['UsersInGroup'] = 'Usuários neste grupo';
    $strings['Browse'] = 'Navegar';
    $strings['DeleteGroupWarning'] = 'Excluindo este grupo irá remover todas as permissões de recursos associados. Os usuários deste grupo podem perder o acesso aos recursos.';
    $strings['WhatRolesApplyToThisGroup'] = 'Que regras se aplicam a esse grupo?';
    $strings['WhoCanManageThisGroup'] = 'Quem pode gerenciar este grupo?';
    $strings['WhoCanManageThisSchedule'] = 'Quem pode gerenciar essa agenda?';
    $strings['AddGroup'] = 'Adicionar Grupo';
    $strings['AllQuotas'] = 'Todas as Cotas';
    $strings['QuotaReminder'] = 'Lembre-se: As cotas são aplicadas com base no fuso horário da agenda.';
    $strings['AllReservations'] = 'Todas as Reservas';
    $strings['PendingReservations'] = 'Reservas Pendentes';
    $strings['Approving'] = 'Aprovar';
    $strings['MoveToSchedule'] = 'Mover para agenda';
    $strings['DeleteResourceWarning'] = 'Excluindo este recurso irá apagar todos os dados associados, incluindo';
    $strings['DeleteResourceWarningReservations'] = 'todas as reservas passadas, atuais e futuras associados';
    $strings['DeleteResourceWarningPermissions'] = 'todas as atribuições de permissão';
    $strings['DeleteResourceWarningReassign'] = 'Por favor, reatribuir qualquer coisa que você não queira que seja eliminado antes de prosseguir';
    $strings['ScheduleLayout'] = 'Layout (todos os horários %s)';
    $strings['ReservableTimeSlots'] = 'Faixa de Horários Reserváveis';
    $strings['BlockedTimeSlots'] = 'Faixa de Horários Bloqueados';
    $strings['ThisIsTheDefaultSchedule'] = 'Esta é a agenda padrão';
    $strings['DefaultScheduleCannotBeDeleted'] = 'Agenda padrão não pode ser excluída';
    $strings['MakeDefault'] = 'Tornar Padrão';
    $strings['BringDown'] = 'Mover para Baixo';
    $strings['ChangeLayout'] = 'Mudar Layout';
    $strings['AddSchedule'] = 'Adicionar Agenda';
    $strings['StartsOn'] = 'Inicia em';
    $strings['NumberOfDaysVisible'] = 'Número de dias visíveis';
    $strings['UseSameLayoutAs'] = 'Usar mesmo layout como';
    $strings['Format'] = 'Formato';
    $strings['OptionalLabel'] = 'Título Opcional';
    $strings['LayoutInstructions'] = 'Digite uma faixa por linha. Faixas devem ser fornecidas para todas as 24 horas do dia começando e terminando às 12:00.';
    $strings['AddUser'] = 'Adicionar Usuário';
    $strings['UserPermissionInfo'] = 'O acesso efetivo ao recurso pode ser diferente dependendo da função do usuário, permissões de grupo, ou definições de permissões externas';
    $strings['DeleteUserWarning'] = 'Excluir este usuário irá remover todas as suas reservas atuais, futuros e histórico.';
    $strings['AddAnnouncement'] = 'Adicionar Anúncio';
    $strings['Announcement'] = 'Anúncio';
    $strings['Priority'] = 'Prioridade';
    $strings['Reservable'] = 'Reservável';
    $strings['Unreservable'] = 'Não Reservável';
    $strings['Reserved'] = 'Reservados';
    $strings['MyReservation'] = 'Minhas Reservas';
    $strings['Pending'] = 'Pendente';
    $strings['Past'] = 'Passado';
    $strings['Restricted'] = 'Restrito';
    $strings['ViewAll'] = 'Ver Todos';
    $strings['MoveResourcesAndReservations'] = 'Mover recursos e reservas para';
    $strings['TurnOffSubscription'] = 'Desabilitar reservas no calendário';
    $strings['TurnOnSubscription'] = 'Permitir reservas no calendário';
    $strings['SubscribeToCalendar'] = 'Aderir a este calendário';
    $strings['SubscriptionsAreDisabled'] = 'O calendário foi desabilitado pelo administrador';
    $strings['NoResourceAdministratorLabel'] = '(Nenhum administrador do recurso)';
    $strings['WhoCanManageThisResource'] = 'Quem pode gerenciar este recurso?';
    $strings['ResourceAdministrator'] = 'Administrador do Recurso';
    $strings['Private'] = 'Privado';
    $strings['Accept'] = 'Aceitar';
    $strings['Decline'] = 'Recusar';
    $strings['ShowFullWeek'] = 'Exibir semana';
    $strings['CustomAttributes'] = 'Personalização dos atributos';
    $strings['AddAttribute'] = 'Adicionar um atributo';
    $strings['EditAttribute'] = 'Atualizar um atributo';
    $strings['DisplayLabel'] = 'Nome de exibição';
    $strings['Type'] = 'Tipo';
    $strings['Required'] = 'Necessário';
    $strings['ValidationExpression'] = 'Expressão de validação';
    $strings['PossibleValues'] = 'Valores possíveis';
    $strings['SingleLineTextbox'] = 'Caixa de texto linha única';
    $strings['MultiLineTextbox'] = 'Caixa de texto linhas múltiplas';
    $strings['Checkbox'] = 'Caixa de seleção';
    $strings['SelectList'] = 'Lista de seleção';
    $strings['CommaSeparated'] = 'Separação por vírgula';
    $strings['Category'] = 'categoria';
    $strings['CategoryReservation'] = 'Reservar';
    $strings['CategoryGroup'] = 'Grupo';
    $strings['SortOrder'] = 'Ordem de exibição';
    $strings['Title'] = 'Título';
    $strings['AdditionalAttributes'] = 'Atributos adicionais';
    $strings['True'] = 'Verdadeiro';
    $strings['False'] = 'Falso';
    $strings['ForgotPasswordEmailSent'] = 'Um email foi enviado para o endereço fornecido com instruções para redefinir sua senha';
    $strings['ActivationEmailSent'] = 'Você receberá uma mensagem de email de ativação logo.';
    $strings['AccountActivationError'] = 'Desculpe, não foi possível ativar a sua conta.';
    $strings['Attachments'] = 'Anexos';
    $strings['AttachFile'] = 'Arquivo anexado';
    $strings['Maximum'] = 'Máx';
    $strings['NoScheduleAdministratorLabel'] = 'Nenhum Administrador Nesta Agenda';
    $strings['ScheduleAdministrator'] = 'Administrador da Agenda';
    $strings['Total'] = 'Total';
    $strings['QuantityReserved'] = 'Quantidade reservada';
    $strings['AllAccessories'] = 'Todos os Acessórios';
    $strings['GetReport'] = 'Gerar Relatório';
    $strings['NoResultsFound'] = 'Nenhum resultado encontrado';
    $strings['SaveThisReport'] = 'Salvar Este Relatório';
    $strings['ReportSaved'] = 'Relatório Salvo!';
    $strings['EmailReport'] = 'Enviar Relatório';
    $strings['ReportSent'] = 'Relatório enviado!';
    $strings['RunReport'] = 'Executar Relatório';
    $strings['NoSavedReports'] = 'Você não tem relatórios salvos.';
    $strings['CurrentWeek'] = 'Semana Atual';
    $strings['CurrentMonth'] = 'Mês Atual';
    $strings['AllTime'] = 'Qualquer Período';
    $strings['FilterBy'] = 'Filtrar Por';
    $strings['Select'] = 'Seleção';
    $strings['List'] = 'Listar';
    $strings['TotalTime'] = 'Tempo Total';
    $strings['Count'] = 'Contar';
    $strings['Usage'] = 'Uso';
    $strings['AggregateBy'] = 'Agregar Por';
    $strings['Range'] = 'Período';
    $strings['Choose'] = 'Escolher';
    $strings['All'] = 'Todos';
    $strings['ViewAsChart'] = 'Visualizar Gráfico';
    $strings['ReservedResources'] = 'Recursos Reservados';
    $strings['ReservedAccessories'] = 'Acessórios Reservados';
    $strings['ResourceUsageTimeBooked'] = 'Uso de Recursos - Tempo Reservado';
    $strings['ResourceUsageReservationCount'] = 'Uso de Recursos - Contagem de Reservas';
    $strings['Top20UsersTimeBooked'] = 'Top 20 Usuários - Tempo Reservado';
    $strings['Top20UsersReservationCount'] = 'Top 20 Usuários - Contagem de Reservas';
    $strings['ConfigurationUpdated'] = 'O arquivo de configuração foi atualizado';
    $strings['ConfigurationUiNotEnabled'] = 'Esta página não pode ser acessada. A $conf[\'settings\'][\'pages\'][\'enable.configuration\'] está marcada como falsa.';
    $strings['ConfigurationFileNotWritable'] = 'O arquivo de configuração não pode ser escrito. Por favor verifique as permissões desde arquivo e tente novamente.';
    $strings['ConfigurationUpdateHelp'] = 'Consulte a seção de configuração do <a target=_blank href=%s>Arquivo de Ajuda</a> para documentação sobre essas configurações.';
    $strings['GeneralConfigSettings'] = 'Configurações';
    $strings['UseSameLayoutForAllDays'] = 'Use o mesmo layout para todos os dias';
    $strings['LayoutVariesByDay'] = 'Layout varia a cada dia';
    $strings['ManageReminders'] = 'Lembretes';
    $strings['ReminderUser'] = 'ID do usuário';
    $strings['ReminderMessage'] = 'Mensagem';
    $strings['ReminderAddress'] = 'Endereços';
    $strings['ReminderSendtime'] = 'Hora para envio';
    $strings['ReminderRefNumber'] = 'Número de referência da reserva';
    $strings['ReminderSendtimeDate'] = 'Data do lembrete';
    $strings['ReminderSendtimeTime'] = 'Hora do lembrete (HH:MM)';
    $strings['ReminderSendtimeAMPM'] = 'AM / PM';
    $strings['AddReminder'] = 'Adicionar lembrete';
    $strings['DeleteReminderWarning'] = 'Você tem certeza disto?';
    $strings['NoReminders'] = 'Você não tem mais lembretes.';
    $strings['Reminders'] = 'Lembretes';
    $strings['SendReminder'] = 'Enviar lembrete';
    $strings['minutes'] = 'minutos';
    $strings['hours'] = 'horas';
    $strings['days'] = 'dias';
    $strings['ReminderBeforeStart'] = 'antes da hora de início';
    $strings['ReminderBeforeEnd'] = 'antes da hora de encerramento';
    $strings['Logo'] = 'Logo';
    $strings['CssFile'] = 'Arquivo CSS';
    $strings['ThemeUploadSuccess'] = 'As suas mudanças foram salvas. Recarregue a página para as mudanças terem efeito.';
    $strings['MakeDefaultSchedule'] = 'Fazer desta minha agenda padrão';
    $strings['DefaultScheduleSet'] = 'Agora esta é sua agenda padrão';
    $strings['FlipSchedule'] = 'Inverter o layout da agenda';
    $strings['Next'] = 'Próximo';
    $strings['Success'] = 'Successo';
    $strings['Participant'] = 'Participantes';
    $strings['ResourceFilter'] = 'Filtro de recursos';
    $strings['ResourceGroups'] = 'Grupos de recursos';
    $strings['AddNewGroup'] = 'Adicione um novo grupo';
    $strings['Quit'] = 'Sair';
    $strings['StandardScheduleDisplay'] = 'Use a exibição padrão da agenda';
    $strings['TallScheduleDisplay'] = 'Use a exibição de altura da agenda';
    $strings['WideScheduleDisplay'] = 'Use a exibição de largura da agenda';
    $strings['CondensedWeekScheduleDisplay'] = 'Use a exibição condensada da semana da agenda';
    $strings['ResourceGroupHelp1'] = 'Arraste e solte um grupo de recursos para reorganizar.';
    $strings['ResourceGroupHelp2'] = 'Clique com o botão direito no nome de um grupo de recursos para ações adicionais.';
    $strings['ResourceGroupHelp3'] = 'Arraste e solte recursos para adicioná-los aos grupos.';
    $strings['ResourceGroupWarning'] = 'Se estiver usando grupos de recursos, cada recurso deve estar atribuído em pelo menos um grupo. Recursos não atribuídos não poderão ser reservados.';
    $strings['ResourceType'] = 'Tipo de recurso';
    $strings['AppliesTo'] = 'Aplicar para';
    $strings['UniquePerInstance'] = 'Único por instância';
    $strings['AddResourceType'] = 'Adicionar tipo de recurso';
    $strings['NoResourceTypeLabel'] = '(Nenhum tipo de recurso selecionado)';
    $strings['ClearFilter'] = 'Limpar filtro';
    $strings['MinimumCapacity'] = 'Capacidade mínima';
    $strings['Color'] = 'Cor';
    $strings['Available'] = 'Disponível';
    $strings['Unavailable'] = 'Indisponível';
    $strings['Hidden'] = 'Oculto';
    $strings['ResourceStatus'] = 'Situação do recurso';
    $strings['CurrentStatus'] = 'Situação atual';
    $strings['AllReservationResources'] = 'Todos os recursos reservados';
    $strings['File'] = 'Arquivo';
    $strings['BulkResourceUpdate'] = 'Atualização de recursos em massa';
    $strings['Unchanged'] = 'Inalterado';
    $strings['Common'] = 'Comum';
	$strings['AdvancedFilter'] = 'Filtro avançado';
	$strings['AllParticipants'] = 'Todos os participantes';
	$strings['ResourceAvailability'] = 'Recurso disponível';
	$strings['UnavailableAllDay'] = 'Indisponivel todo o dia';
	$strings['AvailableUntil'] = 'Disponível até';
	$strings['AvailableBeginningAt'] = 'Disponível a parit de';
	$strings['RegisterANewAccount'] = 'Registro de uma Nova Conta';
	$strings['FindATime'] = 'Procure uma agenda';
	$strings['Import'] = 'Importação';
	$strings['SpecificDates'] = 'Mostrar datas específicas';
	$strings['AllowParticipantsToJoin'] = 'Permitir aos participantes participação na reserva';
	$strings['AccessoryMinQuantityErrorMessage'] = 'Você deve reservar pelo menos %s acessório %s';
    // End Strings

    // Install
    $strings['InstallApplication'] = 'Instalar Booked Scheduler (apenas para MySQL)';
    $strings['IncorrectInstallPassword'] = 'Desculpe, esta senha está incorreta.';
    $strings['SetInstallPassword'] = 'Você deve escolher uma senha de instalação antes de iniciar a instalação.';
    $strings['InstallPasswordInstructions'] = 'Em %s por favor marque %s para uma senha que seja aleatória e difícil de adivinhar, então retorne para esta página.<br/>Você pode usar %s';
    $strings['NoUpgradeNeeded'] = 'Não existe necessidade de atualização. Executar o processo de instalação irá deletar todos os dados existentes e instalar uma nova cópia do Booked Scheduler!';
    $strings['ProvideInstallPassword'] = 'Por favor forneça sua senha de instalação.';
    $strings['InstallPasswordLocation'] = 'Istro pode ser achado na %s em %s.';
    $strings['VerifyInstallSettings'] = 'Verifique as seguintes configurações padrão antes de continuar. Ou você pode alterar em %s.';
    $strings['DatabaseName'] = 'Nome da base de dados';
    $strings['DatabaseUser'] = 'Usuário da base de dados';
    $strings['DatabaseHost'] = 'Servidor da base de dados';
    $strings['DatabaseCredentials'] = 'Você deve fornecer as credenciais de um usuário MySQL que tenha privilégios de criar uma base de dados. Se você não sabe, entre em contato com seu Administrador de base de dados. Em muitos casos, root funciona.';
    $strings['MySQLUser'] = 'Usuário MySQL';
    $strings['InstallOptionsWarning'] = 'As seguintes opções provavelmente não funcionam neste ambiente. Se você está instalando em um ambiente hospedado, use o assistente de ferramentas do  MySQL para completar esses passos.';
    $strings['CreateDatabase'] = 'Criar a base de dados';
    $strings['CreateDatabaseUser'] = 'Criar usuário da base de dados';
    $strings['PopulateExampleData'] = 'Importar amostra de dados. Crie uma conta de admin: admin/senha e conta de usuário: usuário/senha';
    $strings['DataWipeWarning'] = 'Alerta: Isto irá deletar qualquer dado existente';
    $strings['RunInstallation'] = 'Executar instalação';
    $strings['UpgradeNotice'] = 'Você está atualizando a versão <b>%s</b> para a versão <b>%s</b>';
    $strings['RunUpgrade'] = 'Executar atualização';
    $strings['Executing'] = 'Executando';
    $strings['StatementFailed'] = 'Falha. Detalhes:';
    $strings['SQLStatement'] = 'Instrução SQL:';
    $strings['ErrorCode'] = 'Erro de código:';
    $strings['ErrorText'] = 'Erro de texto:';
    $strings['InstallationSuccess'] = 'Instalação completa com sucesso!';
    $strings['RegisterAdminUser'] = 'Registre seu usuário admin. Isto é requerido se você não importar uma amostra de dado. Garanta que $conf[\'settings\'][\'allow.self.registration\'] = \'true\' no seu %s arquivo.';
    $strings['LoginWithSampleAccounts'] = 'Se você importar uma amostra de dado, você pode entrar com admin/senha para usuário admin ou user/senha para usuário básico.';
    $strings['InstalledVersion'] = 'Você está executando a versão %s do Booked Scheduler';
    $strings['InstallUpgradeConfig'] = 'É recomendado que você atualize seu arquivo de configuração';
    $strings['InstallationFailure'] = 'Existem problemas com a instalação. Por favor corrijá-os e tente novamente.';
    $strings['ConfigureApplication'] = 'Configurar Booked Scheduler';
    $strings['ConfigUpdateSuccess'] = 'Seu arquivo de configuração está atualizado!';
    $strings['ConfigUpdateFailure'] = 'Não foi possível atualizar automaticamente o arquivo de configuração. Por favor sobrescreva o conteúdo do config.php com o seguinte:';
    $strings['SelectUser'] = 'Selecione usuário';
    // End Install

    // Errors
    $strings['LoginError'] = 'Não foi possível encontrar seu usuário ou senha';
    $strings['ReservationFailed'] = 'A sua reserva não pode ser feita';
    $strings['MinNoticeError'] = 'Esta reserva exige aviso prévio. A data mais próxima que pode ser reservado é %s.';
    $strings['MaxNoticeError'] = 'Esta reserva não pode ser feita tão longe no futuro. A última data que pode ser reservado é %s.';
    $strings['MinDurationError'] = 'Esta reserva deve durar pelo menos %s.';
    $strings['MaxDurationError'] = 'Esta reserva não pode durar mais do que %s.';
    $strings['ConflictingAccessoryDates'] = 'Não são suficientes os seguintes acessórios:';
    $strings['NoResourcePermission'] = 'Você não tem permissão para acessar um ou mais dos recursos solicitados';
    $strings['ConflictingReservationDates'] = 'Há reservas conflitantes nas seguintes datas:';
    $strings['StartDateBeforeEndDateRule'] = 'A data de início deve ser anterior à data de término';
    $strings['StartIsInPast'] = 'A data de início não pode ser no passado';
    $strings['EmailDisabled'] = 'O administrador desabilitou notificações de e-mail';
    $strings['ValidLayoutRequired'] = 'Faixas devem ser fornecidas para todas as 24 horas do dia começando e terminando às 12:00.';
    $strings['CustomAttributeErrors'] = 'Existem erros com o atributo adicional que você forneceu:';
    $strings['CustomAttributeRequired'] = '%s é um parâmetro necessário';
    $strings['CustomAttributeInvalid'] = 'O valor fornecido para %s é inválido';
    $strings['AttachmentLoadingError'] = 'Descupe, houve um problema para carregar o arquivo requisitado.';
    $strings['InvalidAttachmentExtension'] = 'Você pode apenas carregar arquivos do tipo: %s';
    $strings['InvalidStartSlot'] = 'A data e horário iniciais requisitados não são válidos.';
    $strings['InvalidEndSlot'] = 'A data e horário finais requisitados não são válidos.';
    $strings['MaxParticipantsError'] = '%s pode suportar apenas %s participantes.';
    $strings['ReservationCriticalError'] = 'ocorreu um erro crítico para salvar a sua reserva. Se o problema persistir, contate seu administrador de sistemas.';
    $strings['InvalidStartReminderTime'] = 'O horário de início do lembrete não é válido.';
    $strings['InvalidEndReminderTime'] = 'O horário de término do lembrete não é válido.';
    $strings['QuotaExceeded'] = 'Limite da cota excedido.';
    $strings['MultiDayRule'] = '%s não permite reservas neste intervalo de dias.';
    $strings['InvalidReservationData'] = 'Houve um problema no seu pedido de reserva.';
    $strings['PasswordError'] = 'A senha deve conter pelo menos %s letras e pelo menos %s números.';
    $strings['PasswordErrorRequirements'] = 'A senha deve conter uma combinação de pelo menos %s letras em caixa alte e baixa e %s números.';
    $strings['NoReservationAccess'] = 'Você não tem permissão para alterar esta reserva.';
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
    $strings['ManageUsers'] = 'Usuários';
    $strings['ManageGroups'] = 'Grupos';
    $strings['ManageQuotas'] = 'Cotas';
    $strings['ManageBlackouts'] = 'Horários Indisponíveis';
    $strings['MyDashboard'] = 'Meu Painel de Controle';
    $strings['ServerSettings'] = 'Configurações do Servidor';
    $strings['Dashboard'] = 'Painel de Controle';
    $strings['Help'] = 'Ajuda';
    $strings['Administration'] = 'Administração';
    $strings['About'] = 'Sobre';
    $strings['Bookings'] = 'Reservas';
    $strings['Schedule'] = 'Agenda';
    $strings['Reservations'] = 'Reservas';
    $strings['Account'] = 'Conta';
    $strings['EditProfile'] = 'Editar Meu Perfil';
    $strings['FindAnOpening'] = 'Encontrar Uma Abertura';
    $strings['OpenInvitations'] = 'Abrir Convites';
    $strings['MyCalendar'] = 'Meu Calendário';
    $strings['ResourceCalendar'] = 'Calendário de Recursos';
    $strings['Reservation'] = 'Nova Reserva';
    $strings['Install'] = 'Instalação';
    $strings['ChangePassword'] = 'Alterar Senha';
    $strings['MyAccount'] = 'Minha Conta';
    $strings['Profile'] = 'Perfil';
    $strings['ApplicationManagement'] = 'Gerenciamento de Aplicativos';
    $strings['ForgotPassword'] = 'Esqueceu a Senha';
    $strings['NotificationPreferences'] = 'Preferências de Notificação';
    $strings['ManageAnnouncements'] = 'Anúncios';
    $strings['Responsibilities'] = 'Responsabilidades';
    $strings['GroupReservations'] = 'Reservas por Grupos';
    $strings['ResourceReservations'] = 'Reservas de Recursos';
    $strings['Customization'] = 'Personalização';
    $strings['Attributes'] = 'Atributos';
    $strings['AccountActivation'] = 'Ativação de Conta';
    $strings['ScheduleReservations'] = 'Reservas na Agenda';
    $strings['Reports'] = 'Relatórios';
    $strings['GenerateReport'] = 'Criar Novo Relatório';
    $strings['MySavedReports'] = 'Meus Relatórios Salvos';
    $strings['CommonReports'] = 'Relatórios Gerais';
    $strings['ViewDay'] = 'Visualizar dia';
    $strings['Group'] = 'Grupo';
    $strings['ManageConfiguration'] = 'Configurar Aplicação';
    $strings['LookAndFeel'] = 'Temas';
    $strings['ManageResourceGroups'] = 'Grupo de recursos';
    $strings['ManageResourceTypes'] = 'Tipos de recursos';
    $strings['ManageResourceStatus'] = 'Situação dos recursos';
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
    $strings['DaySaturdayAbbr'] = 'Sab';
    // End Day representations
    
    // Email Subjects
    $strings['ReservationApprovedSubject'] = 'Sua reserva foi aprovada';
    $strings['ReservationCreatedSubject'] = 'Sua reserva foi criada';
    $strings['ReservationUpdatedSubject'] = 'Sua reserva foi atualizada';
    $strings['ReservationDeletedSubject'] = 'Sua reserva foi removida';
    $strings['ReservationCreatedAdminSubject'] = 'Notificação: A reserva foi criada';
    $strings['ReservationUpdatedAdminSubject'] = 'Notificação: A reserva foi atualizada';
    $strings['ReservationDeleteAdminSubject'] = 'Notificação: A reserva foi removida';
    $strings['ParticipantAddedSubject'] = 'Notificação de Participação na Reserva';
    $strings['ParticipantDeletedSubject'] = 'Reserva removida';
    $strings['InviteeAddedSubject'] = 'Convite de Reserva';
    $strings['ResetPassword'] = 'Pedido de Redefinição de Senha';
    $strings['ActivateYourAccount'] = 'Por favor, ative a sua conta';
    $strings['ReportSubject'] = 'Seu relatório requisitado (%s)';
    $strings['ReservationStartingSoonSubject'] = 'A reserva para %s está chegando';
    $strings['ReservationEndingSoonSubject'] = 'A reserva para %s está chegando ao fim';
    $strings['UserAdded'] = 'A new user has been added';
    $strings['InviteUserSubject'] = '%s convidou você para participar do sistema %s';
    $strings['ReservationCreatedSubjectWithResource'] = 'Reserva criada para %s';
    $strings['ReservationDeletedSubjectWithResource'] = 'Reserva removida para %s';
    // End Email Subjects

    // Create do pt_br language
    $strings['or'] = 'ou';
    $strings['of'] = 'de';
    $strings['Back'] = 'Anterior';
    $strings['Forward'] = 'Próximo';
    $strings['ViewWeek'] = 'Ver Semana';
    $strings['ViewMonth'] = 'Ver Mês';
    $strings['CurrentTime'] = 'Hora Atual';
    $strings['ImageUploadDirectory'] = 'Diretório para enviar imagem física';
    $strings['ChangePermissions'] = 'Tente aplicar as permissões corretas';
    // End of creation
    
    //My count
    //Change Password
    $strings['PasswordControlledExternallyError'] = 'Sua senha é controlada por um sistema externo e não pode ser atualizada aqui.';
    
    //Create to pt_br 18/04/2019
    //Schedule
    $strings['ThisWeek'] = 'Semana atual';
    $strings['DateRange'] = 'Período';
    $strings['Hours'] = 'Horas';
    $strings['Minutes'] = 'Minutos';
    $strings['SpecificTime'] = 'Tempo específico';
    $strings['NewVersion'] = 'Nova versão';
    $strings['AnyResource'] = 'Todos os recursos';
    $strings['MoreOptions'] = 'Mais opções';
    //End Schedule 
    
    //New version
    //Cleanup data
    $strings['ManageEmailTemplates'] = 'Modelo de email';
    $strings['DataCleanup'] = 'Limpeza de dados';
    $strings['DeleteReservationsBefore'] = 'Excluir reservas anteriores a';
    $strings['Purge'] = 'Excluir definitivamente';
    $strings['Users'] = 'Usuários';
    $strings['DeletedReservations'] = 'Reserva(s) excluída(s)';
    $strings['WhatsNew'] = 'O que há de novo?';
    //End New version
    
    //Reservations
    $strings['NameOrEmail'] = 'Nome ou email';
    $strings['Guest'] = 'Convidados'; 
    $strings['ReservationSeriesEndingPreference'] = 'Quando minha série de reservas recorrentes está terminando';
    $strings['CheckingAvailability']='Visualizar disponibilidade';    
    //End reservations 
    
    //Schedule
    $strings['SearchReservations'] = 'Procure uma reserva';
    $strings['Day'] = 'Dia';
    //Reservations
    $strings['NoResources'] = 'Você não adicionou recursos.';
    $strings['More'] = 'Mais';
    $strings['AddToGoogleCalendar'] = 'Adicionar ao Google';
    $strings['DuplicateReservation'] = 'Duplicar';
    //End schedule
    
    //Resources
    $strings['ResourceColor'] = 'Cor do recurso';
    $strings['PrintQRCode'] = 'Imprimir QR Code';
    $strings['FullAccess'] = 'Acesso total';
    $strings['ViewOnly'] = 'Apenas visualizar';
    $strings['Public'] = 'Público';
    $strings['Image'] = 'Imagem';
    $strings['Copy'] = 'Copiar';
    $strings['NoCheckInRequiredNotification'] = 'Não requere check in/out';
    $strings['ImportResources'] = 'Importar recursos';
    $strings['ExportResources'] = 'Exportar recursos';
    $strings['BulkResourceDelete'] = 'Excluir recursos em massa';
    //End Resources
    
    //Access
    $strings['ResourceMinNoticeNoneUpdate'] = 'As reservas podem ser atualizadas até a hora atual';
    $strings['ResourceMinNoticeNoneDelete'] ='As reservas podem ser excluídas até a hora atual'; 
    $strings['ResourceMinNoticeDelete'] = 'As reservas devem ser excluídas pelo menos 2 dias antes da hora de início';
    $strings['RequiresCheckInNotification'] = 'Requer check in/out';
    $strings['AutoReleaseNotification'] = 'Liberado automaticamente se não for verificado em 30 minutos';
    $strings['ChooseOrDropFile'] = 'Escolha um arquivo ou arraste-o aqui';
    //End Access
  
    
    
    
    //Gerenciamento de Aplicativos
    //Reservas
    $strings['MissedCheckin'] = 'Checkin perdido';
    $strings['MissedCheckout'] = 'Checkout perdido';
    $strings['AllResourceStatuses'] = 'Todos os status do recurso';
    $strings['AllResourceTypes'] = 'Todos os tipos de recursos';
    $strings['Attribute'] = 'Attribute';
    $strings['Export'] = 'Exportar';
    $strings['TermsOfService'] = 'Termos do serviço';
    $strings['ReservationColors'] = 'Cores da reserva';
    $strings['Attribute'] = 'Atributo';
    $strings['RequiredValue'] = 'Valor obrigatório';
    $strings['AddRule'] = 'Adicionar regra';
    $strings['AddReservationColorRule'] = 'Adicionar regra de cor de reserva';
    $strings['ReservationCustomRuleAdd'] = 'Use esta cor quando o atributo de reserva estiver definido com o seguinte valor:';

    //Horários indisponíveis
    $strings['BlackoutAroundConflicts'] = 'Indisponibilizar reservas conflitantes';
    
    //Cotas
    $strings['AllDay'] = 'O dia inteiro';
    $strings['Everyday'] = 'Todos os dias';
    $strings['IncludingCompletedReservations'] = 'Incluir reservas concluídas';
    $strings['NotCountingCompletedReservations'] = 'Não incluir reservas concluídas';
    $strings['QuotaEnforcement'] = 'Forçar %s %s';
    
    //Schedules
    $strings['ReservationDetails']='Detalhes da reserva';
    $strings['ViewAvailability']='Visualizar disponibilidade';
    $strings['Availability'] = 'Disponibilidade';
    $strings['AvailableAllYear'] = 'Ano inteiro';
    $strings['AvailableBetween'] = 'Disponível entre';
    $strings['ConcurrentYes'] = 'Recursos podem ser reservados por mais de uma pessoa de cada vez';
    $strings['ConcurrentNo'] = 'Recursos não podem ser reservados por mais de uma pessoa de cada vez';
    $strings['DefaultStyle'] = 'Estilo padrão';
    $strings['Standard'] = 'Padrão';
    $strings['Wide'] = 'Largo';
    $strings['Tall'] = 'Alto';
    $strings['Autofill'] = 'Autopreenchimento';
    $strings['ThisScheduleUsesAStandardLayout'] = 'Essa programação usa um layout padrão';
    $strings['SwitchToACustomLayout'] = 'Mudar para um layout personalizado';
    $strings['SwitchLayoutWarning'] = 'Tem certeza de que deseja alterar o tipo de layout? Isso removerá todos os slots existentes.';
    $strings['OnlyViewedCalendar'] = 'Esta agenda só pode ser visualizada a partir da exibição da agenda.';
    
    $strings['ViewTerms']         = 'Ver os Termos de Serviço';
    $strings['IAccept']           = 'Eu Aceito';
    $strings['TheTermsOfService'] = 'os Termos de Serviço';
    
    //Users
    $strings['InviteUsers'] = 'Convidar usuários';
    $strings['NotifyUser'] = 'Notificar usuário';
    $strings['AutomaticallyAddToGroup'] = 'Adicionar automaticamente novos usuários a este grupo';
    $strings['GroupAutomaticallyAdd'] = 'Adiciona automaticamente';
    $strings['InviteUsersLabel'] = 'Insira os endereços de e-mail das pessoas para convidar';
    
    //Announcements
    $strings['DisplayPage'] = 'Mostrar página';
    $strings['UsersInGroups'] = 'Usuários nos grupos';
    $strings['UsersWithAccessToResources'] = 'Usuários com acesso ao recurso';
    $strings['SendAsEmail'] = 'Enviar como e-mail';
    $strings['AnnouncementEmailNotice'] = 'os usuários receberão este anúncio como um e-mail';
    
    //Personalização dos atributos
    $strings['DateTime'] = 'Data e hora';
    $strings['AdminOnly'] = 'Somente Admin';
    $strings['LimitAttributeScope'] = 'Coletar em casos específicos';
    $strings['CollectedFor'] = 'Coletado para';
    
    //Relatórios
    $strings['IncludeDeleted'] = 'Inclui reservas removidas';
    $strings['Utilization'] = 'Utilização';
    
    $strings['UpdateUsersOnImport'] = 'Atualizar usuário existente se o email já existir';
    $strings['UserImportInstructions'] = '<ul><li>O arquivo deve estar no formato CSV.</li>'
            . '<li>Nome de usuário e email são campos obrigatórios.</li>'
            . '<li>A validade do atributo não será aplicada.</li>'
            . '<li>Deixar outros campos em branco irá definir valores padrão e \'senha\' como a senha do usuário.</li>'
            . '<li>Use o modelo fornecido como um exemplo.</li></ul>';
    $strings['GetTemplate'] = 'Baixar modelo';
    
    //Configuração
    $strings['ImportICS'] = 'Importar de ICS';
    $strings['ImportQuartzy'] = 'Importar de Quartzy';
    $strings['OnlyIcs'] = 'Somente arquivos *.ics podem se importados.';
    $strings['IcsLocationsAsResources'] = 'Locais serão importados como recursos.';
    $strings['IcsMissingOrganizer'] = 'Qualquer evento que não tenha um organizador terá o proprietário configurado para o usuário atual.';                               
    $strings['IcsWarning'] = 'As regras de reserva não serão aplicadas se houver conflitos, duplicatas, etc.';
    $strings['DeleteBlackoutsBefore'] = 'Excluir horários indisponíveis antes de ';
    $strings['PermanentlyDeleteUsers'] = 'Excluir permanentemente os usuários que não estão conectados desde';
    $strings['SelectEmailTemplate'] = 'Selecione um modelo de email';
    
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
    DAY NAMES
    All of these arrays MUST start with Sunday as the first element
    and go through the seven day week, ending on Saturday
    ***/
    // The full day name
    $days['full'] = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
    // The three letter abbreviation
    $days['abbr'] = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
    // The two letter abbreviation
    $days['two'] = array('Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa');
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
    $months = parent::_LoadMonths();

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
    return 'pt_br';
  }
}
