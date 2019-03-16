{if $LoggedIn}
    <li id="navDashboard{$suffix}">
        <a href="{$Path}{Pages::DASHBOARD}">{translate key="Dashboard"}</a>
    </li>
    <li id="navMyAccount{$suffix}">
        <a class="dropdown-trigger" href="#!" data-target="my-account-nav{$suffix}">
            {translate key="MyAccount"}<i class="material-icons right">arrow_drop_down</i>
        </a>
    <li id="navScheduleDropdown{$suffix}">
        <a class="dropdown-trigger" href="#!" data-target="schedule-nav{$suffix}">
            {translate key="Schedule"}<i class="material-icons right">arrow_drop_down</i>
        </a>
    </li>
    {if $CanViewAdmin}
        <li id="navApplicationManagementDropdown{$suffix}">
            <a class="dropdown-trigger" href="#!" data-target="admin-nav{$suffix}">
                {translate key="ApplicationManagement"}<i
                        class="material-icons right">arrow_drop_down</i>
            </a>
        </li>
    {/if}
    {if $CanViewResponsibilities}
        <li id="navResponsibilitiesDropdown{$suffix}">
            <a class="dropdown-trigger" href="#!" data-target="responsibilities-nav{$suffix}">
                {translate key="Responsibilities"}<i class="material-icons right">arrow_drop_down</i>
            </a>
        </li>
    {/if}
    {if $CanViewReports}
        <li id="navReportsDropdown{$suffix}">
            <a class="dropdown-trigger" href="#!" data-target="reports-nav{$suffix}">
                {translate key="Reports"}<i class="material-icons right">arrow_drop_down</i>
            </a>
        </li>
    {/if}
{/if}