{*
Copyright 2012 Nick Korbel

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
*}

{include file='globalheader.tpl' Title='phpScheduleIt v2.0 Migration'}

<h1>Migrate phpScheduleIt v1.2 to v2.0 (MySQL only)</h1>

<div>
{if $ShowResults}
    Migrated {$SchedulesMigratedCount} Schedules<br/>
    Migrated {$ResourcesMigratedCount} Resources<br/>
    Migrated {$AccessoriesMigratedCount} Accessories<br/>
    Migrated {$GroupsMigratedCount} Groups<br/>
    Migrated {$UsersMigratedCount} Users<br/>
    Migrated {$ReservationsMigratedCount} Reservations<br/>

    {else}

    <h3>This will copy all data from your phpScheduleIt v1.2 installation into 2.0. Due to changes in 2.0, this process will
        not be perfect. This process only migrates data which exists in your 1.2 installation but not in your 2.0 installation.
        Running this multiple times will not insert duplicate data.</h3>

    <br/>
    <h3>There is no automated way to undo this process. Please check all migrated data for accuracy after the import
        completes.</h3>
    <div class="error">
    <h3>Known Issues</h3>
    <ul style="margin-left: 30px;">
        <li>Recurring reservations will appear as single instances</li>
        <li>Application admin designations will not be migrated, only the user accounts</li>
        <li>Group admin designations will not be migrated, only the user accounts</li>
        <li>Open reservation invitations will be removed</li>
        <li>User timezones will all be set to the server's timezone</li>
        <li>At the time of writing, phpScheduleIt 2 is not available in all of the same languages that 1.2 was. User language preferences will be migrated but may have no immediate effect</li>
        <li>User email preferences will not be migrated</li>
    </ul>
    </div>

    <form class="register" method="post" action="{$smarty.server.SCRIPT_NAME}">
        {if $LegacyConnectionFailed}
            <div class="error">
                Could not connect to 1.2 database. Please confirm the settings below and try again.
            </div>
        {/if}

        {if $InstallPasswordFailed}
           <div class="error">
              Your installation password was incorrect. Please confirm this config setting in $conf['settings']['install.password']
           </div>
       {/if}

        <h3>phpScheduleIt 1.2 database settings</h3>
        <br/>

        <ul style="list-style: none;">
            <li>Install Password: <input type="password" class="textbox" name="installPassword"/> (found in config.php)</li>
            <li>User: <input type="text" class="textbox" name="legacyUser"/></li>
            <li>Password: <input type="password" class="textbox" name="legacyPassword"/></li>
            <li>Hostspec: <input type="text" class="textbox" name="legacyHostSpec"/></li>
            <li>Database Name: <input type="text" class="textbox" name="legacyDatabaseName"/></li>
        </ul>
        <br/>
        <input type="submit" name="run" value="Run Migration" class="button"/>
    </form>
{/if}
</div>

{include file='globalfooter.tpl'}