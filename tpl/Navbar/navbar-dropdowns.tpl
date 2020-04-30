<ul id="my-account-nav{$suffix}" class="nav-content dropdown-content">
    <li id="navProfile{$suffix}"><a href="{$Path}{Pages::PROFILE}">{translate key="Profile"}</a></li>
    <li id="navPassword{$suffix}"><a
                href="{$Path}{Pages::PASSWORD}">{translate key="ChangePassword"}</a></li>
    <li id="navNotification{$suffix}">
        <a href="{$Path}{Pages::NOTIFICATION_PREFERENCES}">{translate key="NotificationPreferences"}</a>
    </li>
    {if $ShowParticipation}
        <li id="navInvitations{$suffix}">
            <a href="{$Path}{Pages::PARTICIPATION}">{translate key="OpenInvitations"}</a>
        </li>
    {/if}
    {if $CreditsEnabled}
        <li id="navUserCredits{$suffix}">
            <a href="{$Path}{Pages::CREDITS}">{translate key="Credits"}</a>
        </li>
    {/if}
</ul>
<ul id="schedule-nav{$suffix}" class="nav-content dropdown-content">
    <li id="navBookings{$suffix}"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Bookings"}</a>
    </li>
    <li id="navMyCalendar{$suffix}"><a
                href="{$Path}{Pages::MY_CALENDAR}">{translate key="MyCalendar"}</a></li>
    <li id="navResourceCalendar{$suffix}"><a
                href="{$Path}{Pages::CALENDAR}">{translate key="ResourceCalendar"}</a></li>
    <!--<li class="menuitem"><a href="#">{translate key="Current Status"}</a></li>-->
    <li id="navFindATime{$suffix}"><a href="{$Path}{Pages::OPENINGS}">{translate key="FindATime"}</a>
    </li>
    <li id="navFindATime{$suffix}"><a
                href="{$Path}{Pages::SEARCH_RESERVATIONS}">{translate key="SearchReservations"}</a>
    </li>
</ul>
<ul id="admin-nav{$suffix}" class="nav-content dropdown-content" style="min-width:200px;">
    <li id="navManageReservations{$suffix}">
        <a href="{$Path}admin/manage_reservations.php">{translate key="ManageReservations"}</a>
    </li>
    <li id="navManageBlackouts{$suffix}">
        <a href="{$Path}admin/manage_blackouts.php">{translate key="ManageBlackouts"}</a>
    </li>
    <li id="navManageQuotas{$suffix}">
        <a href="{$Path}admin/manage_quotas.php">{translate key="ManageQuotas"}</a>
    </li>
    <li class="divider"></li>
    <li id="navManageSchedules{$suffix}">
        <a href="{$Path}admin/manage_schedules.php">{translate key="ManageSchedules"}</a>
    <li id="navManageResources{$suffix}">
        <a href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a>
    </li>
    <li id="navManageAccessories{$suffix}">
        <a href="{$Path}admin/manage_accessories.php">{translate key="ManageAccessories"}</a>
    </li>

    <li class="divider"></li>
    <li id="navManageUsers{$suffix}">
        <a href="{$Path}admin/manage_users.php">{translate key="ManageUsers"}</a>
    </li>
    <li id="navManageGroups{$suffix}">
        <a href="{$Path}admin/manage_groups.php">{translate key="ManageGroups"}</a>
    </li>

    <li id="navManageAnnouncements{$suffix}">
        <a href="{$Path}admin/manage_announcements.php">{translate key="ManageAnnouncements"}</a>
    </li>
    <li class="divider"></li>
    <li id="navManageAttributes{$suffix}">
        <a href="{$Path}admin/manage_attributes.php">{translate key="CustomAttributes"}</a>
    </li>
    {if $PaymentsEnabled}
        <li id="navManagePayments{$suffix}">
            <a href="{$Path}admin/manage_payments.php">{translate key="ManagePayments"}</a>
        </li>
    {/if}
</ul>
<ul id="responsibilities-nav{$suffix}" class="nav-content dropdown-content">
    {if $CanViewGroupAdmin}
        <li id="navResponsibilitiesGAUsers{$suffix}">
            <a href="{$Path}admin/manage_group_users.php">
                {translate key="ManageUsers"}
            </a>
        </li>
        <li id="navResponsibilitiesGAReservations{$suffix}">
            <a href="{$Path}admin/manage_group_reservations.php">
                {translate key="GroupReservations"}
            </a>
        </li>
        <li id="navResponsibilitiesGAGroups{$suffix}">
            <a href="{$Path}admin/manage_admin_groups.php">
                {translate key="ManageGroups"}
            </a>
        </li>
    {/if}
    {if $CanViewResourceAdmin || $CanViewScheduleAdmin}
        <li id="navResponsibilitiesRAResources{$suffix}">
            <a href="{$Path}admin/manage_admin_resources.php">
                {translate key="ManageResources"}
            </a>
        </li>
        <li id="navResponsibilitiesRABlackouts{$suffix}">
            <a href="{$Path}admin/manage_blackouts.php">
                {translate key="ManageBlackouts"}
            </a>
        </li>
    {/if}
    {if $CanViewResourceAdmin}
        <li id="navResponsibilitiesRAReservations{$suffix}">
            <a href="{$Path}admin/manage_resource_reservations.php">
                {translate key="ResourceReservations"}
            </a>
        </li>
    {/if}
    {if $CanViewScheduleAdmin}
        <li id="navResponsibilitiesSASchedules{$suffix}">
            <a href="{$Path}admin/manage_admin_schedules.php">
                {translate key="ManageSchedules"}
            </a>
        </li>
        <li id="navResponsibilitiesSAReservations{$suffix}">
            <a href="{$Path}admin/manage_schedule_reservations.php">
                {translate key="ScheduleReservations"}
            </a>
        </li>
    {/if}
    <li id="navResponsibilitiesAnnouncements{$suffix}">
        <a href="{$Path}admin/manage_announcements.php">{translate key="ManageAnnouncements"}</a>
    </li>
</ul>
<ul id="reports-nav{$suffix}" class="nav-content dropdown-content">
    <li id="navGenerateReport{$suffix}">
        <a href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key=GenerateReport}</a>
    </li>
    <li id="navSavedReports{$suffix}">
        <a href="{$Path}reports/{Pages::REPORTS_SAVED}">{translate key=MySavedReports}</a>
    </li>
    <li id="navCommonReports{$suffix}">
        <a href="{$Path}reports/{Pages::REPORTS_COMMON}">{translate key=CommonReports}</a>
    </li>
</ul>
<ul id="view-schedule-nav{$suffix}" class="nav-content dropdown-content">
    <li id="navViewSchedule{$suffix}">
        <a href="view-schedule.php">
            {translate key='ViewSchedule'}
        </a>
    </li>
    <li id="navViewCalendar{$suffix}">
        <a href="view-calendar.php">
            {translate key='ViewCalendar'}
        </a>
    </li>
</ul>
<ul id="view-settings-nav{$suffix}" class="nav-content dropdown-content">
    {if $EnableConfigurationPage}
        <li id="navManageConfiguration{$suffix}">
            <a href="{$Path}admin/manage_configuration.php">{translate key="ManageConfiguration"}</a>
        </li>
    {/if}
    <li id="navEmailTemplates{$suffix}">
        <a href="{$Path}admin/manage_email_templates.php">{translate key="ManageEmailTemplates"}</a>
    </li>
    <li id="navLookAndFeel{$suffix}">
        <a href="{$Path}admin/manage_theme.php">{translate key="LookAndFeel"}</a>
    </li>
    <li id="navImport{$suffix}">
        <a href="{$Path}admin/import.php">{translate key="Import"}</a>
    </li>
    <li id="navServerSettings{$suffix}">
        <a href="{$Path}admin/server_settings.php">{translate key="ServerSettings"}</a>
    </li>
    <li id="navDataCleanup{$suffix}">
        <a href="{$Path}admin/data_cleanup.php">{translate key="DataCleanup"}</a>
    </li>
    {if $ShowNewVersion}
        <li class="divider new-version"></li>
        <li id="navNewVersion{$suffix}" class="new-version">
            <a href="https://www.bookedscheduler.com/whatsnew">{translate key=WhatsNew}</a>
        </li>
    {/if}
</ul>
<ul id="view-help-nav{$suffix}" class="nav-content dropdown-content">
    <li id="navHelp{$suffix}"><a href="https://www.bookedscheduler.com/help/usage" target="_blank" rel="noreferrer">{translate key=Help}</a></li>
    {if $CanViewAdmin}
        <li id="navHelpAdmin{$suffix}">
            <a href="https://www.bookedscheduler.com/help/administration" target="_blank" rel="noreferrer">{translate key=Administration}</a>
        </li>
    {/if}
    <li id="navAbout{$suffix}">
        <a href="{$Path}help.php?ht=about">{translate key=About}</a>
    </li>
</ul>