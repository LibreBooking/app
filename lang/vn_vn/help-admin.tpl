{*
Copyright 2011-2019 Nick Korbel

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
*}
{include file='globalheader.tpl'}
<h1>Booked Scheduler Administration</h1>

<div id="help">
    <h2>Administration</h2>

    <p>If you are in a group with the Application Administrator role assigned then you will see the Application
        Management menu item. All
        administrative tasks can be found here.</p>

    <div id="help-schedules">
        <h3>Setting up Schedules</h3>

        <p>
            When installing Booked Scheduler a default schedule will be created with out of the box settings. From the
            Schedules menu option you can view and edit attributes of the current schedules.
        </p>

        <p>Schedules can be displayed starting on any day of the week and for any number of days. For a schedule to
            display starting on the current day, set the
            Starts On option to Today.</p>

        <p>Each schedule must have a layout defined for it. This controls the availability of the resources on that
            schedule. Clicking the Change Layout link will bring up the layout editor. Here you can create and change
            the
            time slots that are available for reservation and blocked from reservation. There is no restriction on the
            slot
            times, but you must provide slot values for all 24 hours of the day, one per line. Also, the time format
            must be
            in 24 hour time.
            You can also provide a display label for any or all slots, if you wish.</p>

        <p>A slot without a label should be formatted like this: 10:25 - 16:50</p>

        <p>A slot with a label should be formatted like this: 10:25 - 16:50 Schedule Period 4</p>

        <p>Below the slot configuration windows is a slot creation wizard. This will set up available slots at the given
            interval between the start and end times.</p>

        <h3>Schedule Administrators</h3>

        <p>A group of users may be set up with permission to manage resources. In order for a group to be set as the
            schedule administrator the group must first
            be granted the Schedule Administrator role. This is configured from the Groups admin tool. Once that role
            has been added, the group will be
            available in the Manage Schedules tool.</p>

        <p>Schedule Administrators have the same capabilities as Application Administrators for any resource that is on
            a schedule which the group is assigned
            to. They can change schedule details, black out times, manage and approve reservations.</p>
    </div>

    <div id="help-resources">
        <h3>Setting up Resources</h3>

        <p>You can view and manage resources from the Resources menu option. Here you can change the attributes and
            usage
            configuration of a resource.
        </p>

        <p>Resources in Booked Scheduler can be anything you want to make bookable, such as rooms or equipment. Every
            resource
            must be assigned to a schedule in order for it to be bookable. The resource will inherit whatever layout the
            schedule uses.</p>

        <p>Setting a minimum reservation duration will prevent booking from lasting shorter than the set amount. The
            default is
            no minimum.</p>

        <p>Setting a maximum reservation duration will prevent booking from lasting longer than the set amount. The
            default is
            no maximum.</p>

        <p>Setting a resource to require approval will place all bookings for that resource into a pending state until
            approved.
            The default is no approval required.</p>

        <p>Setting a resource to automatically grant permission to it will grant all new users permission to access the
            resource
            at registration time. The default is to automatically grant permissions.</p>

        <p>You can require a booking lead time by setting a resource to require a certain number of days/hours/minutes
            notification. For example, if it is currently 10:30 AM on a Monday and the resource requires 1 days
            notification,
            the resource will not be able to be booked until 10:30 AM on Sunday. The default is that reservations can be
            made up
            until the current time.</p>

        <p>You can prevent resources from being booked too far into the future by requiring a maximum notification of
            days/hours/minutes. For example, if it is currently 10:30 AM on a Monday and the resource cannot end more
            than 1 day
            in the future, the resource will not be able to be booked past 10:30 AM on Tuesday. The default is no
            maximum.</p>

        <p>Certain resources can have a usage capacity. For example, some conference rooms may only hold up to 8 people.
            Setting the resource capacity will prevent any more than the configured number of participants at one time,
            excluding the organizer. The default is that resources have unlimited capacity.</p>

        <p>Requiring check in/check out will give the reservation owner the opportunity to record when they actually
            begin and end a reservation. You can optionally automatically release a reserved time if a user does not
            check in within a given amount of time. To automatically release reservations you must configure the
            autorelease job.</p>

        <p>Application Administrators and applicable Schedule and Resource Administrators are exempt from usage
            constraints.</p>

        <h3>Resource Administrators</h3>

        <p>A group of users may be set up with permission to manage resources. In order for a group to be set as the
            resource administrator the group must first
            be granted the Resource Administrator role. This is configured from the Groups admin tool. Once that role
            has been added, the group will be
            available in the Manage Resources tool.</p>

        <p>Resource Administrators have the same capabilities as Application Administrators for any resource which the
            group is assigned to. They can change
            resource details, black out times, manage and approve reservations.</p>

        <h3>Resource Images</h3>

        <p>You can set a resource image which will be displayed when viewing resource details from the reservation page.
            This
            requires php_gd2 to be installed and enabled in your php.ini file. <a
                    href="http://www.php.net/manual/en/book.image.php" target="_blank">More
                Details</a></p>

        <div id="help-resource-statuses">
            <h3>Resource Statuses</h3>
            <p>Setting a resource to the Available status will allow users with permission to book the reservation. The
                Unavailable status will show the resource on
                the schedule but will not allow it to be booked by anyone other than administrators. The Hidden status
                will remove the resource from the schedule
                and prevent bookings from all users.</p>
        </div>
    </div>

    <div id="help-resource-groups">
        <h3>Resource Groups</h3>

        <p>Resource Groups are a simple way to organize and filter resources. When a booking is being created, the user
            will have an option to book all
            resources in a group. If resources in a group are assigned to different schedules then only the resources
            which share a schedule will be booked
            together.</p>

        <p>If using resource groups, each resource must be assigned to at least one group. Due to the group hierarchy,
            unassigned resources will not be able to
            be reserved.</p>

        <p>Drag and drop resource groups to reorganize.</p>

        <p>Right click a resource group name for additional actions.</p>

        <p>Drag and drop resources to add them to groups.</p>
    </div>

    <div id="help-resource-types">
        <h3>Resource Types</h3>

        <p>Resource types allow resources that share a common set of attributes to be managed together. Custom
            attributes for a resource type will apply to all
            resources of that type</p>
    </div>

    <div id="help-accessories">
        <h3>Setting up Accessories</h3>

        <p>Accessories can be thought of as ancillary resources used during a reservation. Examples may be projectors or
            chairs in a
            conference room.</p>

        <p>Accessories can be viewed and managed from the Accessories menu item, under the Resources menu item. Setting
            a
            accessory quantity will prevent more than that number of accessories from being booked at a time.</p>
    </div>

    <div id="help-quotas">
        <h3>Setting up Quotas</h3>

        <p>Quotas restrict reservations from being booked based on a configurable limit. The quota system in Booked
            Scheduler is
            very flexible, allowing you to build limits based on reservation length and number reservations.</p>

        <p>Quota limits &quot;stack&quot;. For example, if a quota exists limiting a resource to 5 hours per day and
            another quota exists limiting to
            4 reservations per day, a user would be able to make 4 one-hour-long reservations but would be restricted
            from making 3
            two-hour-long reservations. This allows powerful quota combinations to be built.</p>

        <p>Quotas applied to a group are enforced for each user in the group individually. It does not apply to the
            group's aggregated reservations.</p>

        <p>It is important to remember that quota limits are enforced based on the schedule's timezone. For example, a
            daily limit would begin and end at
            midnight of the schedule's timezone; not the user's timezone.</p>

        <p>Application Administrators are exempt from quota limits.</p>
    </div>

    <div id="help-announcements">
        <h3>Setting up Announcements</h3>

        <p>Announcements are a very simple way to display notifications to Booked Scheduler users.</p>

        <p>From the Announcements menu item
            you can view and manage the announcements that are displayed on users dashboards. An announcement can be
            configured
            with an optional start and end date. An optional priority level is also available, which sorts announcements
            from 1
            to 10.</p>

        <p>HTML is allowed within the announcement text. This allows you to embed links or images from anywhere on the
            web.</p>

    </div>

    <div id="help-groups">
        <h3>Setting up Groups</h3>

        <p>Groups in Booked Scheduler organize users, control resource access permissions and define roles within the
            application. Setting resource permissions for a group will grant access to all members of that group. Users
            can individually be granted additional
            resource permission.</p>

        <h3>Roles</h3>

        <p>Roles give a group of users the authorization to perform certain actions.</p>

        <p>Application Administrator: Users that belong to a group that is given the Application Administrator role are
            open to
            full administrative privileges. This role has nearly zero restrictions on what resources can be booked. It
            can
            manage all aspects of the application.</p>

        <p>Group Administrator: Users that belong to a group that is given the Group Administrator role are able to
            manage
            their groups and reserve on behalf of and manage users within that group. A group administrator must first
            be assigned the Group Administrator role.
            This group will then be available in the Group Administrators list.</p>

        <p>Resource Administrator: Users that belong to a group that is given the Resource Administrators role have the
            same capabilities as Application
            Administrators for any resource which the group is assigned to. They can change resource details, black out
            times, manage and approve
            reservations.</p>

        <p>Schedule Administrator: Users that belong to a group that is given the Schedule Administrators role have the
            same capabilities as Application
            Administrators for any resource that is on a schedule which the group is assigned to. They can change
            schedule details, black out times, manage and
            approve reservations.</p>

    </div>

    <div id="help-reservations">
        <h3>Viewing and Managing Reservations</h3>

        <p>You can view and manage reservations from the Reservations menu item. By default you will see the last 14
            days and the
            next 14 days worth of reservations. This can be filtered more or less granular depending on what you are
            looking for.
            This tool allows you to quickly find an act on a reservation. You can also export the list of filtered
            reservations
            to CSV format for further reporting.</p>

        <h3>Reservation Approval</h3>

        <p>Setting $conf['settings']['reservation']['updates.require.approval'] to true will put all reservation
            requests into a
            pending state. The reservation becomes active only after an administrator approves it. From the Reservations
            admin
            tool an administrator will be able to view and approve pending reservations. Pending reservations will be
            highlighted.</p>
    </div>

    <div id="help-users">
        <h3>Viewing and Managing Users</h3>

        <p>You can add, view, and manage all registered users from the Users menu item. This tool allows you to change
            resource
            access permissions of individual users, assign users to groups, deactivate or delete accounts, reset user
            passwords, and edit user details.
            You can also add new users to Booked Scheduler, which is especially useful if self-registration is turned
            off.</p>

        <h3>Reservation Colors</h3>

        <p>Reservation colors can be set for individual users, resources, or dynamically based on a custom attribute
            value. The slot background color of a reservation on the Schedule and Calendar views will be
            displayed in this color.</p>

    </div>

    <div id="help-attributes">
        <h3>Custom Attributes</h3>

        <p>Custom Attributes are a powerful extension point in Booked. You can add additional attributes to
            Reservations, Resources, Resource Types and
            Users.</p>

        <p>Attributes can be configured as single line text box, a multi-line text box, a select list (drop down), or a
            checkbox. All attributes can be
            configured to be required. Textbox attributes allow an optional validation expression to be set. This value
            must be a valid regular expression. For
            example, to require a digit to be entered the validation expression would be <em>/\d+/</em></p>

        <p>User, Resource, and Resource Type attributes can be limited to a single entity. These attributes will have an
            Applies To property. If an attribute is
            configured to apply to a single entity then it will only be collected for that entity.</p>

        <p>Reservation attributes will be collected during the reservation process. To collect an attribute value only
            for
            specific users or resources, check the 'Collect In Specific Cases' option and pick the cases when the
            attribute
            should be shown.</p>

        <p>User attributes are collected when registering and updating a user's profile.</p>

        <p>Resources attributes are entered when managing resources and will be displayed when viewing resource
            details.</p>

        <p>Resource Type attributes are entered when managing resource types and will be displayed when viewing resource
            details.</p>

        <p>Admin only attributes are only shown to users who have administrative privileges over that reservation.</p>

        <p>Private attributes are only shown to the reservation owner and those users who have administrative privileges
            over that reservation.</p>

        <p>Custom attributes are available to plugins and can be used to extend the functionality of Booked.</p>
    </div>

    <div id="help-blackouts">
        <h3>Blackout Times</h3>

        <p>Blackout Times can be used to prevent reservations from being booked at certain times. This feature is
            helpful when a resource is temporarily
            unavailable or unavailable at a scheduled recurring interval. Blacked out times are not bookable by anyone,
            including administrators.</p>
    </div>

    <div id="help-reporting">
        <h3>Reporting</h3>

        <p>Reports are accessible to all application, group, resource and schedule administrators. When the currently
            logged in
            user has access to reporting features, they will see a Reports navigation item. Booked Scheduler comes with
            a set of
            Common Reports which can be viewed as a list of results, a chart, exported to CSV and printed. In addition,
            ad-hoc
            reports can be created from the Create New Report menu item. This also allows listing, charting, exporting
            and
            printing. In addition, custom reports can be saved and accessed again at a later time from the My Saved
            Reports menu
            item. Saved reports also have the ability to be emailed.</p>
    </div>

    <div id="help-credits">
        <h3>Credits</h3>

        <p>Credits allow control over a user's usage. Credits must first be enabled in the application configuration
            before they can be managed. Once enabled, administrators will have the ability to set the credit redemption
            rates for peak and off peak times. Peak times are defined per schedule.</p>

        <p>If a reservation would bring a user over their credit limit, the reservation will be rejected. Administrators
            can manage user credits when managing user details.</p>
    </div>

    <div id="help-reminders">
        <h3>Reservation Reminders</h3>

        <p>Users can request that reminder emails are send prior to the beginning or end of a reservation. In order for
            this
            feature to function, $conf['settings']['enable.email'] and
            $conf['settings']['reservation']['enable.reminders'] must
            both be set to true. Also, a scheduled task must be configured on your server to execute
            /Booked Scheduler/Jobs/sendreminders.php</p>

        <p>On Linux, a cron job can be used. The command to run is <span class="note">php</span> followed by the full
            path to
            Booked Scheduler/Jobs/sendreminders.php. The full path to sendreminders.php on this server is <span
                    class="note">{$RemindersPath}</span>
        </p>

        <p>An example cron configuration might look like: <span class="note">* * * * * php -f {$RemindersPath}</span>
        </p>

        <p>If you have access to cPanel through a hosting provider, <a
                    href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">setting
                up
                a cron job in cPanel</a> is straightforward. Either select the Every Minute option from the Common
            Settings menu,
            or enter * for minute, hour, day, month and weekday.</p>

        <p>On Windows, <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">a scheduled
                task
                can be used</a>. The task must be configured to run at a frequent interval - at least every 5 minutes.
            The task to execute is php followed by
            the
            full path to Booked Scheduler\Jobs\sendreminders.php. For example, c:\PHP\php.exe -f
            c:\inetpub\wwwroot\Booked\Jobs\sendreminders.php</p>

    </div>

    <div>
        <h3>Configuring Autorelease Job</h3>
        <p>On Linux, a cron job can be used. The command to run is <span class="note">php</span> followed by the full
            path to
            Booked Scheduler/Jobs/autorelease.php. The full path to autorelease.php on this server is <span
                    class="note">{$AutoReleasePath}</span>
        </p>

        <p>An example cron configuration might look like: <span class="note">* * * * * php -f {$AutoReleasePath}</span>
        </p>

        <p>If you have access to cPanel through a hosting provider, <a
                    href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">setting
                up
                a cron job in cPanel</a> is straightforward. Either select the Every Minute option from the Common
            Settings menu,
            or enter * for minute, hour, day, month and weekday.</p>

        <p>On Windows, <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">a scheduled
                task
                can be used</a>. The task must be configured to run at a frequent interval - at least every 5 minutes.
            The task to execute is php followed by
            the
            full path to Booked Scheduler\Jobs\autorelease.php. For example, c:\PHP\php.exe -f
            c:\inetpub\wwwroot\Booked\Jobs\autorelease.php</p>
    </div>

    <div>
        <h3>Configuring Waitlist Notification Job</h3>
        <p>On Linux, a cron job can be used. The command to run is <span class="note">php</span> followed by the full
            path to
            Booked Scheduler/Jobs/sendwaitlist.php. The full path to autorelease.php on this server is <span
                    class="note">{$WaitListPath}</span>
        </p>

        <p>An example cron configuration might look like: <span class="note">* * * * * php -f {$WaitListPath}</span>
        </p>

        <p>If you have access to cPanel through a hosting provider, <a
                    href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">setting
                up
                a cron job in cPanel</a> is straightforward. Either select the Every Minute option from the Common
            Settings menu,
            or enter * for minute, hour, day, month and weekday.</p>

        <p>On Windows, <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">a scheduled
                task
                can be used</a>. The task must be configured to run at a frequent interval - at least every 5 minutes.
            The task to execute is php followed by
            the
            full path to Booked Scheduler\Jobs\sendwaitlist.php. For example, c:\PHP\php.exe -f
            c:\inetpub\wwwroot\Booked\Jobs\sendwaitlist.php</p>
    </div>

    <div id="help-configuration">
        <h2>Configuration</h2>

        <p>Some functionality can only be controlled by editing the config file.</p>

        <p class="setting"><span>$conf['settings']['app.title']</span>The title of the application to be used in the
            browser. Default is false.</p>

        <p class="setting"><span>$conf['settings']['default.timezone']</span>The default timezone to use. If not set,
            the server
            timezone will be used. Possible values are located here:
            <a href="http://php.net/manual/en/timezones.php" target="_blank">http://php.net/manual/en/timezones.php</a>
        </p>

        <p class="setting"><span>$conf['settings']['allow.self.registration']</span>If users are allowed to register new
            accounts. Default is false.</p>

        <p class="setting"><span>$conf['settings']['admin.email']</span>The email address of the main application
            administrator
        </p>

        <p class="setting"><span>$conf['settings']['default.page.size']</span>The initial number of rows for any page
            that
            displays a list of data
        </p>

        <p class="setting"><span>$conf['settings']['enable.email']</span>Whether or not any emails are sent out of
            Booked Scheduler
        </p>

        <p class="setting"><span>$conf['settings']['default.language']</span>Default language for all users. This can be
            any
            language in the
            Booked Scheduler lang directory</p>

        <p class="setting"><span>$conf['settings']['script.url']</span>The full public URL to the root of this instance
            of
            Booked Scheduler. This should be the Web directory which contains files like bookings.php and calendar.php.
            If this
            value starts with //, then the protocol (http vs https) will be automatically detected.</p>

        <p class="setting"><span>$conf['settings']['image.upload.directory']</span>The physical directory to store
            images.
            This directory will need to be writable (755 suggested). This can be the full directory or relative to the
            Booked Scheduler root directory.</p>

        <p class="setting"><span>$conf['settings']['image.upload.url']</span>The URL where uploaded
            images can be viewed from. This can be the full URL or relative to $conf['settings']['script.url'].
        </p>

        <p class="setting"><span>$conf['settings']['cache.templates']</span>Whether or not templates are cached. It is
            recommended to set this to
            true, as long as tpl_c is writable</p>

        <p class="setting"><span>$conf['settings']['use.local.jquery']</span>Whether or not a local version of jQuery
            files
            should be used. If set to false, the files will be served from the Google CDN. It is recommended to set this
            to
            false to improve performance and bandwidth usage. Default is false.</p>

        <p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>Whether or not captcha image
            security
            is enabled during user account registration</p>

        <p class="setting"><span>$conf['settings']['registration.require.email.activation']</span>Whether or not a user
            will be
            required to activate their account by email before logging in.</p>

        <p class="setting"><span>$conf['settings']['registration.auto.subscribe.email']</span>Whether or not users will
            be
            automatically subscribed to all emails upon registration.</p>

        <p class="setting"><span>$conf['settings']['registration.notify.admin']</span>Whether or not admins will be
            notified upon new user registration.</p>

        <p class="setting"><span>$conf['settings']['inactivity.timeout']</span>Number of minutes before the user is
            automatically logged out. Leave this blank if you do not want users automatically logged out.</p>

        <p class="setting"><span>$conf['settings']['name.format']</span>Display format for first name and last name.
            Default
            is {literal}'{first} {last}'{/literal}.</p>

        <p class="setting"><span>$conf['settings']['css.extension.file']</span>Full or relative URL to an additional CSS
            file to
            include. This can be used to override the default style with adjustments or a full theme. Leave this blank
            if you
            are not extending the style of Booked Scheduler.</p>

        <p class="setting"><span>$conf['settings']['disable.password.reset']</span>If the password reset functionality
            should be
            disabled. Default is false.</p>

        <p class="setting"><span>$conf['settings']['home.url']</span>Where the user will be redirected when the logo is
            clicked.
            Default is the user's homepage.</p>

        <p class="setting"><span>$conf['settings']['logout.url']</span>Where the user will be redirected after being
            logged out.
            Default is the login page.</p>

        <p class="setting"><span>$conf['settings']['default.homepage']</span>The default homepage to use when new users
            register 1 = Dashboard, 2 = Schedule, 3
            = My
            Calendar, 4 = Resource Calendar. Default is 1 (Dashboard)</p>

        <p class="setting"><span>$conf['settings']['schedule']['use.per.user.colors']</span>Use user-specific,
            administrator-defined colors for reservations. Default is false.</p>

        <p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>Whether or not
            resources
            that are not accessible to the user are displayed in the schedule</p>

        <p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>The format of what to display
            for the
            reservation slot on the Bookings page. Available tokens are listed in the Available Label Tokens section.
        </p>

        <p class="setting"><span>$conf['settings']['schedule']['hide.blocked.periods']</span>If blocked periods should
            be
            hidden on the bookings page. Default is false.</p>

        <p class="setting"><span>$conf['settings']['ics']['require.login']</span>If users should be required to log in
            to add a
            reservation to
            Outlook.</p>

        <p class="setting"><span>$conf['settings']['ics']['subscription.key']</span>If you want to allow calendar
            subscriptions,
            set this to a difficult to guess value. If nothing is set then calendar subscriptions will be disabled.</p>

        <p class="setting"><span>$conf['settings']['privacy']['view.schedules']</span>If non-authenticated users can
            view the
            booking schedules. Default is false.</p>

        <p class="setting"><span>$conf['settings']['privacy']['view.reservations']</span>If non-authenticated users can
            view
            reservation details.
            Default is false.</p>

        <p class="setting"><span>$conf['settings']['privacy']['hide.user.details']</span>If non-adminstrators can view
            personal
            information about other users. Default is false.</p>

        <p class="setting"><span>$conf['settings']['privacy']['hide.reservation.details']</span>If non-adminstrators can
            view reservation details.
            Options are true, false, past, future. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation']['start.time.constraint']</span>When reservations can
            be
            created or edited.
            Options are future, current, none. Future means reservations cannot be created or modified if the starting
            time of
            the selected slot is in the past. Current means reservations can be created or modified if the ending time
            of the
            selected slot is not in the past. None means that there is no restriction on when reservations can be
            created or
            modified. Default is future.</p>

        <p class="setting"><span>$conf['settings']['reservation']['updates.require.approval']</span>Whether or not
            updates to
            reservations which have previously been approved require approval again. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation']['prevent.participation']</span>Whether or not users
            should be
            prevented from adding and inviting others to a reservation. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation']['prevent.recurrence']</span>Whether or not users
            should be
            prevented creating recurring reservations. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation']['enable.reminders']</span>Whether or not users
            can be reminded about their reservations via email. This requires the reminders job to be running. Default
            is false.</p>

        <p class="setting"><span>$conf['settings']['reservation']['allow.guest.participation']</span>Whether or not
            non-registered users can be invited to reservations. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation']['allow.wait.list']</span>Whether or not
            users can be notified of time slot availability. This requires the wait list job to be running. Default is
            false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>Whether or not to
            send an
            email to all resource administrators when a reservation is created. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>Whether or not
            to send
            an
            email to all resource administrators when a reservation is updated. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>Whether or not
            to send
            an
            email to all resource administrators when a reservation is deleted. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>Whether or not
            to send
            an
            email to all application administrators when a reservation is created. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>Whether or
            not to
            send an
            email to all application administrators when a reservation is updated. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>Whether or
            not to
            send an
            email to all application administrators when a reservation is deleted. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>Whether or not to send
            an
            email to all group administrators when a reservation is created. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>Whether or not to
            send an
            email to all group administrators when a reservation is updated. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>Whether or not to
            send an
            email to all group administrators when a reservation is deleted. Default is false.</p>

        <p class="setting"><span>$conf['settings']['uploads']['enable.reservation.attachments']</span>If users are
            allowed to
            attach files to reservations. Default is false.</p>

        <p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.path']</span>The full or relative
            filesystem path (relative to the root of your Booked Scheduler directory) to store reservation attachments.
            This
            directory must be writable by PHP (755 suggested). Default is uploads/reservation</p>

        <p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>Comma separated
            list of
            safe file extensions. Leaving this blank will allow all file types (not recommended).</p>

        <p class="setting"><span>$conf['settings']['database']['type']</span>Any PEAR::MDB2 supported type</p>

        <p class="setting"><span>$conf['settings']['database']['user']</span>Database user with access to the configured
            database</p>

        <p class="setting"><span>$conf['settings']['database']['password']</span>Password for the database user</p>

        <p class="setting"><span>$conf['settings']['database']['hostspec']</span>Database host URL or named pipe</p>

        <p class="setting"><span>$conf['settings']['database']['name']</span>Name of Booked Scheduler database</p>

        <p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>PHP email library. Options are mail,
            smtp,
            sendmail, qmail</p>

        <p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>SMTP host, if using smtp</p>

        <p class="setting"><span>$conf['settings']['phpmailer']['smtp.port']</span>SMTP port, if using smtp, usually 25
        </p>

        <p class="setting"><span>$conf['settings']['phpmailer']['smtp.secure']</span>SMTP security, if using smtp.
            Options are
            '', ssl or tls</p>

        <p class="setting"><span>$conf['settings']['phpmailer']['smtp.auth']</span>SMTP requies authentication, if using
            smtp.
            Options are true or false</p>

        <p class="setting"><span>$conf['settings']['phpmailer']['smtp.username']</span>SMTP username, if using smtp</p>

        <p class="setting"><span>$conf['settings']['phpmailer']['smtp.password']</span>SMTP password, if using smtp</p>

        <p class="setting"><span>$conf['settings']['phpmailer']['sendmail.path']</span>Path to sendmail, if using
            sendmail</p>

        <p class="setting"><span>$conf['settings']['plugins']['Authentication']</span>Name of authentication plugin to
            use. For
            more on plugins, see Plugins below</p>

        <p class="setting"><span>$conf['settings']['plugins']['Authorization']</span>Name of authorization plugin to
            use. For
            more on plugins, see Plugins below</p>

        <p class="setting"><span>$conf['settings']['plugins']['Permission']</span>Name of permission plugin to use. For
            more on
            plugins, see Plugins below</p>

        <p class="setting"><span>$conf['settings']['plugins']['PreReservation']</span>Name of prereservation plugin to
            use. For
            more on plugins, see Plugins below</p>

        <p class="setting"><span>$conf['settings']['plugins']['PostReservation']</span>Name of postreservation plugin to
            use.
            For more on plugins, see Plugins below</p>

        <p class="setting"><span>$conf['settings']['install.password']</span>If you are running an installation or
            upgrade, you
            will be required to provide a value here. Set this to any random value.</p>

        <p class="setting"><span>$conf['settings']['pages']['enable.configuration']</span>If the configuration
            management page
            should be available to application administrators. Options are true or false.</p>

        <p class="setting"><span>$conf['settings']['api']['enabled']</span>If the Booked Scheduler's RESTful API should
            be enabled.
            See more about prerequisites for using the API in the readme_installation.html file. Options are true or
            false.</p>

        <p class="setting"><span>$conf['settings']['recaptcha']['enabled']</span>If reCAPTCHA should be used instead of
            the
            built in captcha. Options are true or false.</p>

        <p class="setting"><span>$conf['settings']['recaptcha']['public.key']</span>Your reCAPTCHA public key. Visit
            www.google.com/recaptcha to sign up.</p>

        <p class="setting"><span>$conf['settings']['recaptcha']['private.key']</span>Your reCAPTCHA private key. Visit
            www.google.com/recaptcha to sign up.</p>

        <p class="setting"><span>$config['settings']['email']['default.from.address']</span>The email address to use as
            the 'from' address when sending emails. If emails are bouncing or being marked as spam, set this to an email
            address with your domain name. For example, noreply@yourdomain.com. This will not change the 'from' name or
            the reply-to address.</p>

        <p class="setting"><span>$config['settings']['email']['default.from.name']</span>The friendly name to use as the
            'from' address when sending emails.</p>

        <p class="setting"><span>$conf['settings']['reports']['allow.all.users']</span>If non-administrators can access
            usage
            reports. Default is false.</p>

        <p class="setting"><span>$conf['settings']['password']['minimum.letters']</span>Minimum number of letters
            required for
            user passwords. Default is 6.</p>

        <p class="setting"><span>$conf['settings']['password']['minimum.numbers']</span>Minimum number of numbers
            required for
            user passwords. Default is 0.</p>

        <p class="setting"><span>$conf['settings']['password']['upper.and.lower']</span>Whether user passwords require a
            combination of upper and lower case letters. Default is false.</p>

        <p class="setting"><span>$conf['settings']['reservation.labels']['ics.summary']</span>The format of what to
            display in the
            summary field for ics feeds. Available tokens are listed in the Available Label Tokens section.</p>

        <p class="setting"><span>$conf['settings']['reservation.labels']['rss.description']</span>The format of what to
            display in the
            description field for rss/atom feeds. Available tokens are listed in the Available Label Tokens section.</p>

        <p class="setting"><span>$conf['settings']['reservation.labels']['my.calendar']</span>The format of what to
            display for the
            reservation label on the My Calendar page. Available tokens are listed in the Available Label Tokens
            section.</p>

        <p class="setting"><span>$conf['settings']['reservation.labels']['resource.calendar']</span>The format of what
            to display for the
            reservation label on the Resource Calendar page. Available tokens are listed in the Available Label Tokens
            section.</p>
        {literal}
            <p class="setting"><span>$conf['settings']['reservation.labels']['reservation.popup']</span>The format of
                what to display in reservation popups.
                Possible values are {name} {dates} {title} {resources} {participants} {accessories} {description}
                {attributes}. Custom attributes can be
                individually added using att with the attribute id. For example {att1}.
                Default is all information.</p>
        {/literal}

        <p class="setting"><span>$conf['settings']['google.analytics']['tracking.id']</span>Your Google Analytics
            Tracking ID. If this is set then Google
            Analytics tracking code will be added to every page in Booked.</p>

        <p class="setting"><span>$conf['settings']['authentication']['allow.social.login']</span>If users can log in to
            Booked using Google and Facebook. Default is false.</p>

        <p class="setting"><span>$conf['settings']['credits']['enabled']</span>Whether or not credit functionality is
            enabled. Default is false.</p>
    </div>

    <h2>Plugins</h2>

    <p>The following components are currently pluggable:</p>

    <ul>
        <li>Authentication - Who is allowed to log in</li>
        <li>Authorization - What a user can do when you are logged in</li>
        <li>Permission - What resources a user has access to</li>
        <li>Pre Reservation - What happens before a reservation is booked</li>
        <li>Post Reservation - What happens after a reservation is booked</li>
        <li>Post Registration - What happens after a new user register</li>
    </ul>

    <p>
        To enable a plugin, set the value of the config setting to the name of the plugin folder. For example, to enable
        LDAP authentication, set $conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

    <p>Plugins may have their own configuration files. For LDAP, rename or copy
        /plugins/Authentication/Ldap/Ldap.config.dist to /plugins/Authentication/Ldap/Ldap.config and edit all values
        that
        are applicable to your environment.</p>

    <h3>Installing Plugins</h3>

    <p>To install a new plugin copy the folder to the proper plugin directory. Then
        change either $conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] or
        $conf['settings']['plugins']['Permission'] in config.php to the name of that folder.</p>

    <h2>Available Label Tokens</h2>

    <p>Available tokens for reservation labels
        are {literal}{name}, {title}, {description}, {email}, {phone}, {organization}, {position}, {startdate}, {enddate} {resourcename} {participants} {invitees} {reservationAttributes}{/literal}
        . Custom attributes can be added using att with the attribute id. For example {literal}{att1}{/literal}
        Leave it blank for no label. Any combination of tokens can be used.</p>

    <h2>Active Directory Integration</h2>

    <p>Booked can authenticate your users against Active Directory. To enable this, first set <span class="setting">$conf['settings']['plugins']['Authentication'] = 'ActiveDirectory';</span>
    </p>

    <p>Next, open Application Management - Customization - Application Configuration and choose the
        Authentication-ActiveDirectory file.</p>

    <p class="setting"><span>$conf['settings']['domain.controllers']</span>Comma separated list of ActiveDirectory
        servers. ex) domaincontroller1,controller2
    </p>

    <p class="setting"><span>$conf['settings']['port']</span>Default port 389 or 636 for SSL.</p>

    <p class="setting"><span>$conf['settings']['username']</span>Admin user to bind with (this is not always required).
    </p>

    <p class="setting"><span>$conf['settings']['password']</span>Admin user password to bind with (this is not always
        required).</p>

    <p class="setting"><span>$conf['settings']['basedn']</span>The base dn for your domain. This is generally the same
        as your account suffix, but broken up and
        prefixed with DC=. Your base dn can be located in the extended attributes in Active Directory Users and
        Computers MMC.</p>

    <p class="setting"><span>$conf['settings']['version']</span>LDAP protocol version. Default is 3</p>

    <p class="setting"><span>$conf['settings']['use.ssl']</span>Whether or not to use SSL. This typically relates to the
        port used.</p>

    <p class="setting"><span>$conf['settings']['account.suffix']</span>The full account suffix for your domain. Example:
        @uidauthent.domain.com.</p>

    <p class="setting"><span>$conf['settings']['database.auth.when.ldap.user.not.found']</span>If Active Directory auth
        fails, authenticate against Booked
        Scheduler database</p>

    <p class="setting"><span>$conf['settings']['attribute.mapping']</span>Mapping of required attributes to attribute
        names in your directory.</p>

    <p class="setting"><span>$conf['settings']['required.groups']</span>A required group that the user must belong to.
        The user only needs to belong to at least
        one listed. Blank for no restriction. ex) Group1,Group2</p>

    <p class="setting"><span>$conf['settings']['sync.groups']</span>Whether or not to sync group membership into Booked.
        The Active Directory groups must first
        be created in Booked. Anything that doesn't exist in Booked will be skipped.</p>

    <p>More info for ActiveDirectory configuration can be found at <a
                href="http://adldap.sourceforge.net/wiki/doku.php?id=documentation_configuration">http://adldap.sourceforge.net/wiki/doku.php?id=documentation_configuration</a>
    </p>

    <h2>LDAP Integration</h2>

    <p>Booked can authenticate your users against LDAP. To enable this, first set <span
                class="setting">$conf['settings']['plugins']['Authentication'] = 'Ldap';</span></p>

    <p>Next, open Application Management - Customization - Application Configuration and choose the Authentication-Ldap
        file.</p>

    <p class="setting"><span>$conf['settings']['host']</span>Comma separated list of LDAP servers such as
        mydomain1,localhost</p>

    <p class="setting"><span>$conf['settings']['port']</span>Default port 389 or 636 for SSL</p>

    <p class="setting"><span>$conf['settings']['version']</span>LDAP protocol version. Default is 3</p>

    <p class="setting"><span>$conf['settings']['starttls']</span>Whether or not to start TLS after connecting</p>

    <p class="setting"><span>$conf['settings']['binddn']</span>The distinguished name to bind as (username). If you
        don't supply this, an anonymous bind will be
        established.</p>

    <p class="setting"><span>$conf['settings']['bindpw']</span>Password for the binddn. If the credentials are wrong,
        the bind will fail server-side and an
        anonymous bind will be established instead. An empty bindpw string requests an unauthenticated bind.</p>

    <p class="setting"><span>$conf['settings']['basedn']</span>LDAP base name. ex) dc=example,dc=com</p>

    <p class="setting"><span>$conf['settings']['filter']</span>Default search filter to find users.</p>

    <p class="setting"><span>$conf['settings']['scope']</span>User search scope. ex) uid.</p>

    <p class="setting"><span>$conf['settings']['required.group']</span>A required group that the user must belong to.
        The user only needs to belong to at least
        one listed. Blank for no restriction. ex) Group1,Group2</p>

    <p class="setting"><span>$conf['settings']['database.auth.when.ldap.user.not.found']</span>If Active Directory auth
        fails, authenticate against Booked
        Scheduler database</p>

    <p class="setting"><span>$conf['settings']['ldap.debug.enabled']</span>If detailed LDAP logs should be enabled.</p>

    <p class="setting"><span>$conf['settings']['attribute.mapping']</span>Mapping of required attributes to attribute
        names in your directory.</p>

    <p class="setting"><span>$conf['settings']['user.id.attribute']</span>The attribute name for user identification.
        ex) uid</p>

    <p>More info for LDAP configuration can be found at <a
                href="http://pear.php.net/manual/en/package.networking.net-ldap2.connecting.php">http://pear.php.net/manual/en/package.networking.net-ldap2.connecting.php</a>
    </p>

    <h2>CAS Integration</h2>

    <p>Booked can authenticate your users against CAS. To enable this, first set <span
                class="setting">$conf['settings']['plugins']['Authentication'] = 'CAS';</span></p>

    <p>Next, open Application Management - Customization - Application Configuration and choose the Authentication-CAS
        file.</p>

    <p class="setting"><span>$conf['settings']['cas.version']</span>1.0 = CAS_VERSION_1_0, 2.0 = CAS_VERSION_2_0, S1 =
        SAML_VERSION_1_1</p>

    <p class="setting"><span>$conf['settings']['cas.server.hostname']</span>The hostname of the CAS server.</p>

    <p class="setting"><span>$conf['settings']['cas.port']</span>The port the CAS server is running on.</p>

    <p class="setting"><span>$conf['settings']['cas.server.uri']</span>The URI the CAS server is responding on.</p>

    <p class="setting"><span>$conf['settings']['cas.change.session.id']</span>Whether or not to allow phpCAS to change
        the session_id.</p>

    <p class="setting"><span>$conf['settings']['email.suffix']</span>Email suffix to use when storing CAS user account.
        ex) Email addresses will be saved to
        Booked Scheduler as username@yourdomain.com</p>

    <p class="setting"><span>$conf['settings']['cas_logout_servers']</span>Comma separated list of servers to use for
        logout. Leave blank to not use cas logout
        servers.</p>

    <p class="setting"><span>$conf['settings']['cas.certificates']</span>Full path to certificate to use for CAS. Leave
        blank if no certificate should be used.
    </p>

    <p class="setting"><span>$conf['settings']['cas.debug.enabled']</span>If detailed CAS logs should be enabled.</p>

    <p class="setting"><span>$conf['settings']['cas.debug.file']</span>Full path to debug file if cas.debug.enabled is
        true.</p>

    <p>When using CAS you should also set <span class="setting">$conf['settings']['logout.url']</span> to your CAS
        logout server</p>

    <p>More info for CAS configuration can be found at <a href="https://wiki.jasig.org/display/casc/phpcas">https://wiki.jasig.org/display/casc/phpcas</a>
    </p>

    <h2>WordPress Integration</h2>

    <p>Booked can authenticate your users against a WordPress site running on the same server as Booked. To enable this,
        first set <span class="setting">$conf['settings']['plugins']['Authentication'] = 'WordPress';</span>
    </p>

    <p>Next, open Application Management - Customization - Application Configuration and choose the
        Authentication-WordPress file.</p>

    <p class="setting"><span>$conf['settings']['wp_includes.directory']</span>The full path to your wp-includes
        directory or path relative to Booked Scheduler
        root.</p>

    <p class="setting"><span>$conf['settings']['database.auth.when.wp.user.not.found']</span>If WordPress auth fails,
        authenticate against Booked Scheduler
        database.</p>


</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}