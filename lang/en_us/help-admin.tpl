{*
Copyright 2011-2014 Nick Korbel

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
<h1 xmlns="http://www.w3.org/1999/html">Booked Scheduler Administration</h1>

<div id="help">
<h2>Administration</h2>

<p>If you are in an Application Administrator role then you will see the Application Management menu item. All
	administrative tasks can be found here.</p>

<h3>Setting up Schedules</h3>

<p>
	When installing Booked Scheduler a default schedule will be created with out of the box settings. From the
	Schedules menu option you can view and edit attributes of the current schedules.
</p>

<p>Each schedule must have a layout defined for it. This controls the availability of the resources on that
	schedule. Clicking the Change Layout link will bring up the layout editor. Here you can create and change the
	time slots that are available for reservation and blocked from reservation. There is no restriction on the slot
	times, but you must provide slot values for all 24 hours of the day, one per line. Also, the time format must be
	in 24 hour time.
	You can also provide a display label for any or all slots, if you wish.</p>

<p>A slot without a label should be formatted like this: 10:25 - 16:50</p>

<p>A slot with a label should be formatted like this: 10:25 - 16:50 Schedule Period 4</p>

<p>Below the slot configuration windows is a slot creation wizard. This will set up available slots at the given
	interval between the start and end times.</p>

<h3>Setting up Resources</h3>

<p>You can view and manage resources from the Resources menu option. Here you can change the attributes and usage
	configuration of a resource.
</p>

<p>Resources in Booked Scheduler can be anything you want to make bookable, such as rooms or equipment. Every resource
	must be assigned to a schedule in order for it to be bookable. The resource will inherit whatever layout the
	schedule uses.</p>

<p>Setting a minimum reservation duration will prevent booking from lasting longer than the set amount. The default is
	no minimum.</p>

<p>Setting a maximum reservation duration will prevent booking from lasting shorter than the set amount. The default is
	no maximum.</p>

<p>Setting a resource to require approval will place all bookings for that resource into a pending state until approved.
	The default is no approval required.</p>

<p>Setting a resource to automatically grant permission to it will grant all new users permission to access the resource
	at registration time. The default is to automatically grant permissions.</p>

<p>You can require a booking lead time by setting a resource to require a certain number of days/hours/minutes
	notification. For example, if it is currently 10:30 AM on a Monday and the resource requires 1 days notification,
	the resource will not be able to be booked until 10:30 AM on Sunday. The default is that reservations can be made up
	until the current time.</p>

<p>You can prevent resources from being booked too far into the future by requiring a maximum notification of
	days/hours/minutes. For example, if it is currently 10:30 AM on a Monday and the resource cannot end more than 1 day
	in the future, the resource will bot be able to be booked past 10:30 AM on Tuesday. The default is no maximum.</p>

<p>Certain resources cannot have a usage capacity. For example, some conference rooms may only hold up to 8 people.
	Setting the resource capacity will prevent any more than the configured number of participants at one time,
	excluding the organizer. The default is that resources have unlimited capacity.</p>

<p>Application Administrators are exempt from usage constraints.</p>

<h3>Resource Images</h3>

<p>You can set a resource image which will be displayed when viewing resource details from the reservation page. This
	requires php_gd2 to be installed and enabled in your php.ini file. <a
			href="http://www.php.net/manual/en/book.image.php">More Details</a></p>

<h3>Setting up Accessories</h3>

<p>Accessories can be thought of as objects used during a reservation. Examples may be projectors or chairs in a
	conference room.</p>

<p>Accessories can be viewed and managed from the Accessories menu item, under the Resources menu item. Setting a
	accessory quantity will prevent more than that number of accessories from being booked at a time.</p>

<h3>Setting up Quotas</h3>

<p>Quotas prevent reservations from being booked based on a configurable limit. The quota system in Booked Scheduler is
	very flexible, allowing you to build limits based on reservation length and number reservations. Also, quota limits
	"stack". For example, if a quota exists limiting a resource to 5 hours per day and another quota exists limiting to
	4 reservations per day a user would be able to make 4 hour-long reservations but would be restricting from making 3
	two-hour-long reservations. This allows powerful quota combinations to be built.</p>

<p>Application Administrators are exempt from quota limits.</p>

<h3>Setting up Announcements</h3>

<p>Announcements are a very simple way to display notifications to Booked Scheduler users. From the Announcements menu item
	you can view and manage the announcements that are displayed on users dashboards. An announcement can be configured
	with an optional start and end date. An optional priority level is also available, which sorts announcements from 1
	to 10.</p>

<p>HTML is allows within the announcement text. This allows you to embed links or images from anywhere on the web.</p>

<h3>Setting up Groups</h3>

<p>Groups in Booked Scheduler organize users, control resource access permissions and define roles within the
	application.</p>

<h3>Roles</h3>

<p>Roles give a group of users the authorization to perform certain actions.</p>

<p>Application Administrator: Users that belong to a group that is given the Application Administrator role are open to
	full administrative privileges. This role has nearly zero restrictions on what resources can be booked. It can
	manage all aspects of the application.</p>

<p>Group Administrator: Users that belong to a group that is given the Group Administrator role are able to manage
	their groups and reserve on behalf of and manage users within that group.</p>

<p>Resource Administrator: Users that belong to a group that is given the Resource Administrator role are able to manage
	their resources and approve reservations for their resources.</p>

<p>Schedule Administrator: Users that belong to a group that is given the Schedule Administrator role are able to manage
	their schedules and resources belonging to their schedules and approve reservations on their schedules.</p>

<h3>Viewing and Managing Reservations</h3>

<p>You can view and manage reservations from the Reservations menu item. By default you will see the last 7 days and the
	next 7 days worth of reservations. This can be filtered more or less granular depending on what you are looking for.
	This tool allows you to quickly find an act on a reservation. You can also export the list of filtered reservations
	to CSV format for further reporting.</p>

<h3>Reservation Approval</h3>

<p>Setting $conf['settings']['reservation']['updates.require.approval'] to true will put all reservation requests into a
	pending state. The reservation becomes active only after an administrator approves it. From the Reservations admin
	tool an administrator will be able to view and approve pending reservations. Pending reservations will be
	highlighted.</p>

<h3>Viewing and Managing Users</h3>

<p>You can add, view, and manage all registered users from the Users menu item. This tool allows you to change resource
	access permissions of individual users, deactivate or delete accounts, reset user passwords, and edit user details.
	You can also add new users to Booked Scheduler. This is especially useful if self-registration is turned off.</p>

<h3>Reporting</h3>

<p>Reports are accessible to all application, group, resource and schedule administrators. When the currently logged in
	user has access to reporting features, they will see a Reports navigation item. Booked Scheduler comes with a set of
	Common Reports which can be viewed as a list of results, a chart, exported to CSV and printed. In addition, ad-hoc
	reports can be created from the Create New Report menu item. This also allows listing, charting, exporting and
	printing. In addition, custom reports can be saved and accessed again at a later time from the My Saved Reports menu
	item. Saved reports also have the ability to be emailed.</p>

<h3>Reservation Reminders</h3>

<p>Users can request that reminder emails are send prior to the beginning or end of a reservation. In order for this
	feature to function, $conf['settings']['enable.email'] and $conf['settings']['reservation']['enable.reminders'] must
	both be set to true. Also, a scheduled task must be configured on your server to execute
	/Booked Scheduler/Jobs/sendreminders.php</p>

<p>On Linux, a cron job can be used. The command to run is <span class="note">php</span> followed by the full path to
	Booked Scheduler/Jobs/sendreminders.php. The full path to sendreminders.php on this server is <span
			class="note">{$RemindersPath}</span>
</p>

<p>An example cron configuration might look like: <span class="note">* * * * * php {$RemindersPath}</span></p>

<p>If you have access to cPanel through a hosting provider, <a
			href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">setting up
		a
		cron job in cPanel</a> is straightforward. Either select the Every Minute option from the Common Settings menu,
	or
	enter * for minute, hour, day, month and weekday.</p>

<p>On Windows, <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">a scheduled task
		can be used</a>. The task must be configured to run every minute. The task to execute is php followed by the
	full
	path to Booked Scheduler/Jobs/sendreminders.php</p>

<h2>Configuration</h2>

<p>Some functionality can only be controlled by editing the config file.</p>

<p class="setting"><div>$conf['settings']['default.timezone']</div>The default timezone to use. If not set, the server
	timezone will be used. Possible values are located here:
	<a href="http://php.net/manual/en/timezones.php" target="_blank">http://php.net/manual/en/timezones.php</a></p>

<p class="setting"><div>$conf['settings']['allow.self.registration']</div>If users are allowed to register new
	accounts. Default is false.</p>

<p class="setting"><div>$conf['settings']['admin.email']</div>The email address of the main application administrator
</p>

<p class="setting"><div>$conf['settings']['default.page.size']</div>The initial number of rows for any page that
	displays a list of data
</p>

<p class="setting"><div>$conf['settings']['enable.email']</div>Whether or not any emails are sent out of Booked Scheduler
</p>

<p class="setting"><div>$conf['settings']['default.language']</div>Default language for all users. This can be any
	language in the
	Booked Scheduler lang directory</p>

<p class="setting"><div>$conf['settings']['script.url']</div>The full public URL to the root of this instance of
	Booked Scheduler. This should be the Web directory which contains files like bookings.php and calendar.php. If this
	value starts with //, then the protocol (http vs https) will be automatically detected.</p>

<p class="setting"><div>$conf['settings']['image.upload.directory']</div>The physical directory to store images.
	This directory will need to be writable (755 suggested). This can be the full directory or relative to the
	Booked Scheduler root directory.</p>

<p class="setting"><div>$conf['settings']['image.upload.url']</div>The URL where uploaded
	images can be viewed from. This can be the full URL or relative to $conf['settings']['script.url'].
</p>

<p class="setting"><div>$conf['settings']['cache.templates']</div>Whether or not templates are cached. It is
	recommended to set this to
	true, as long as tpl_c is writable</p>

<p class="setting"><div>$conf['settings']['use.local.jquery']</div>Whether or not a local version of jQuery files
	should be used. If set to false, the files will be served from the Google CDN. It is recommended to set this to
	false to improve performance and bandwidth usage. Default is false.</p>

<p class="setting"><div>$conf['settings']['registration.captcha.enabled']</div>Whether or not captcha image security
	is enabled during user account registration</p>

<p class="setting"><div>$conf['settings']['registration.require.email.activation']</div>Whether or not a user will be
	required to activate their account by email before logging in.</p>

<p class="setting"><div>$conf['settings']['registration.auto.subscribe.email']</div>Whether or not users will be
	automatically subscribed to all emails upon registration.</p>

<p class="setting"><div>$conf['settings']['inactivity.timeout']</div>Number of minutes before the user is
	automatically logged out. Leave this blank if you do not want users automatically logged out.</p>

<p class="setting"><div>$conf['settings']['name.format']</div>Display format for first name and last name. Default
	is {literal}'{first} {last}'{/literal}.</p>

<p class="setting"><div>$conf['settings']['css.extension.file']</div>Full or relative URL to an additional CSS file to
	include. This can be used to override the default style with adjustments or a full theme. Leave this blank if you
	are not extending the style of Booked Scheduler.</p>

<p class="setting"><div>$conf['settings']['disable.password.reset']</div>If the password reset functionality should be
	disabled. Default is false.</p>

<p class="setting"><div>$conf['settings']['home.url']</div>Where the user will be redirected when the logo is clicked.
	Default is the user's homepage.</p>

<p class="setting"><div>$conf['settings']['logout.url']</div>Where the user will be redirected after being logged out.
	Default is the login page.</p>


<p class="setting"><div>$conf['settings']['schedule']['use.per.user.colors']</div>Use user-specific,
	administrator-defined colors for reservations. Default is false.</p>

<p class="setting"><div>$conf['settings']['schedule']['show.inaccessible.resources']</div>Whether or not resources
	that are not accessible to the user are displayed in the schedule</p>

<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>The format of what to display for the
	reservation slot on the Bookings page. Available tokens are listed in the Available Label Tokens section.</p>

<p class="setting"><div>$conf['settings']['schedule']['hide.blocked.periods']</div>If blocked periods should be
	hidden on the bookings page. Default is false.</p>

<p class="setting"><div>$conf['settings']['ics']['require.login']</div>If users should be required to log in to add a
	reservation to
	Outlook.</p>

<p class="setting"><div>$conf['settings']['ics']['subscription.key']</div>If you want to allow calendar subscriptions,
	set this to a difficult to guess value. If nothing is set then calendar subscriptions will be disabled.</p>

<p class="setting"><div>$conf['settings']['privacy']['view.schedules']</div>If non-authenticated users can view the
	booking schedules. Default is false.</p>

<p class="setting"><div>$conf['settings']['privacy']['view.reservations']</div>If non-authenticated users can view
	reservation details.
	Default is false.</p>

<p class="setting"><div>$conf['settings']['privacy']['hide.user.details']</div>If non-adminstrators can view personal
	information about other users. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation']['start.time.constraint']</div>When reservations can be
	created or edited.
	Options are future, current, none. Future means reservations cannot be created or modified if the starting time of
	the selected slot is in the past. Current means reservations can be created or modified if the ending time of the
	selected slot is not in the past. None means that there is no restriction on when reservations can be created or
	modified. Default is future.</p>

<p class="setting"><div>$conf['settings']['reservation']['updates.require.approval']</div>Whether or not updates to
	reservations which have previously been approved require approval again. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation']['prevent.participation']</div>Whether or not users should be
	prevented from adding and inviting others to a reservation. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation']['prevent.recurrence']</div>Whether or not users should be
	prevented creating recurring reservations. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['resource.admin.add']</div>Whether or not to send an
	email to all resource administrators when a reservation is created. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['resource.admin.update']</div>Whether or not to send
	an
	email to all resource administrators when a reservation is updated. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['resource.admin.delete']</div>Whether or not to send
	an
	email to all resource administrators when a reservation is deleted. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['application.admin.add']</div>Whether or not to send
	an
	email to all application administrators when a reservation is created. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['application.admin.update']</div>Whether or not to
	send an
	email to all application administrators when a reservation is updated. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['application.admin.delete']</div>Whether or not to
	send an
	email to all application administrators when a reservation is deleted. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['group.admin.add']</div>Whether or not to send an
	email to all group administrators when a reservation is created. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['group.admin.update']</div>Whether or not to send an
	email to all group administrators when a reservation is updated. Default is false.</p>

<p class="setting"><div>$conf['settings']['reservation.notify']['group.admin.delete']</div>Whether or not to send an
	email to all group administrators when a reservation is deleted. Default is false.</p>

<p class="setting"><div>$conf['settings']['uploads']['enable.reservation.attachments']</div>If users are allowed to
	attach files to reservations. Default is false.</p>

<p class="setting"><div>$conf['settings']['uploads']['reservation.attachment.path']</div>The full or relative
	filesystem path (relative to the root of your Booked Scheduler directory) to store reservation attachments. This
	directory must be writable by PHP (755 suggested). Default is uploads/reservation</p>

<p class="setting"><div>$conf['settings']['uploads']['reservation.attachment.extensions']</div>Comma separated list of
	safe file extensions. Leaving this blank will allow all file types (not recommended).</p>

<p class="setting"><div>$conf['settings']['database']['type']</div>Any PEAR::MDB2 supported type</p>

<p class="setting"><div>$conf['settings']['database']['user']</div>Database user with access to the configured
	database</p>

<p class="setting"><div>$conf['settings']['database']['password']</div>Password for the database user</p>

<p class="setting"><div>$conf['settings']['database']['hostspec']</div>Database host URL or named pipe</p>

<p class="setting"><div>$conf['settings']['database']['name']</div>Name of Booked Scheduler database</p>

<p class="setting"><div>$conf['settings']['phpmailer']['mailer']</div>PHP email library. Options are mail, smtp,
	sendmail, qmail</p>

<p class="setting"><div>$conf['settings']['phpmailer']['smtp.host']</div>SMTP host, if using smtp</p>

<p class="setting"><div>$conf['settings']['phpmailer']['smtp.port']</div>SMTP port, if using smtp, usually 25</p>

<p class="setting"><div>$conf['settings']['phpmailer']['smtp.secure']</div>SMTP security, if using smtp. Options are
	'', ssl or tls</p>

<p class="setting"><div>$conf['settings']['phpmailer']['smtp.auth']</div>SMTP requies authentication, if using smtp.
	Options are true or false</p>

<p class="setting"><div>$conf['settings']['phpmailer']['smtp.username']</div>SMTP username, if using smtp</p>

<p class="setting"><div>$conf['settings']['phpmailer']['smtp.password']</div>SMTP password, if using smtp</p>

<p class="setting"><div>$conf['settings']['phpmailer']['sendmail.path']</div>Path to sendmail, if using sendmail</p>

<p class="setting"><div>$conf['settings']['plugins']['Authentication']</div>Name of authentication plugin to use. For
	more on plugins, see Plugins below</p>

<p class="setting"><div>$conf['settings']['plugins']['Authorization']</div>Name of authorization plugin to use. For
	more on plugins, see Plugins below</p>

<p class="setting"><div>$conf['settings']['plugins']['Permission']</div>Name of permission plugin to use. For more on
	plugins, see Plugins below</p>

<p class="setting"><div>$conf['settings']['plugins']['PreReservation']</div>Name of prereservation plugin to use. For
	more on plugins, see Plugins below</p>

<p class="setting"><div>$conf['settings']['plugins']['PostReservation']</div>Name of postreservation plugin to use.
	For more on plugins, see Plugins below</p>

<p class="setting"><div>$conf['settings']['install.password']</div>If you are running an installation or upgrade, you
	will be required to provide a value here. Set this to any random value.</p>

<p class="setting"><div>$conf['settings']['pages']['enable.configuration']</div>If the configuration management page
	should be available to application administrators. Options are true or false.</p>

<p class="setting"><div>$conf['settings']['api']['enabled']</div>If the Booked Scheduler's RESTful API should be enabled.
	See more about prerequisites for using the API in the readme_installation.html file. Options are true or false.</p>

<p class="setting"><div>$conf['settings']['recaptcha']['enabled']</div>If reCAPTCHA should be used instead of the
	built in captcha. Options are true or false.</p>

<p class="setting"><div>$conf['settings']['recaptcha']['public.key']</div>Your reCAPTCHA public key. Visit
	www.google.com/recaptcha to sign up.</p>

<p class="setting"><div>$conf['settings']['recaptcha']['private.key']</div>Your reCAPTCHA private key. Visit
	www.google.com/recaptcha to sign up.</p>

<p class="setting"><div>$config['settings']['email']['default.from.address']</div>The email address to use as the
	'from' address when sending emails. If emails are bouncing or being marked as spam, set this to an email address
	with your domain name. For example, noreply@yourdomain.com. This will not change the 'from' name or the reply-to
	address.</p>

<p class="setting"><div>$conf['settings']['reports']['allow.all.users']</div>If non-administrators can access usage
	reports. Default is false.</p>

<p class="setting"><div>$conf['settings']['password']['minimum.letters']</div>Minimum number of letters required for
	user passwords. Default is 6.</p>

<p class="setting"><div>$conf['settings']['password']['minimum.numbers']</div>Minimum number of numbers required for
	user passwords. Default is 0.</p>

<p class="setting"><div>$conf['settings']['password']['upper.and.lower']</div>Whether user passwords require a
	combination of upper and lower case letters. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.labels']['ics.summary']</span>The format of what to display in the
	summary field for ics feeds for schedules and resources. Available tokens are listed in the Available Label Tokens section.</p>
<p class="setting"><span>$conf['settings']['reservation.labels']['ics.my.summary']</span>The format of what to display in the
	summary field for ics feeds from My Calendar. Available tokens are listed in the Available Label Tokens section.</p>
<p class="setting"><span>$conf['settings']['reservation.labels']['rss.description']</span>The format of what to display in the
	description field for rss/atom feeds. Available tokens are listed in the Available Label Tokens section.</p>
<p class="setting"><span>$conf['settings']['reservation.labels']['my.calendar']</span>The format of what to display for the
	reservation label on the My Calendar page. Available tokens are listed in the Available Label Tokens section.</p>
<p class="setting"><span>$conf['settings']['reservation.labels']['resource.calendar']</span>The format of what to display for the
	reservation label on the Resource Calendar page. Available tokens are listed in the Available Label Tokens section.</p>
<p class="setting"><span>$conf['settings']['reservation.labels']['reservation.popup']</span>The format of what to display in reservation popups.
	Possible values are {name} {dates} {title} {resources} {participants} {accessories} {description} {attributes}. Custom attributes can be individually added using att with the attribute id. For example {att1}.
	Default is all information.</p>

<h2>Plugins</h2>

<p>The following components are currently pluggable:</p>

<ul>
	<li>Authentication - Who is allowed to log in</li>
	<li>Authorization - What a user can do when you are logged in</li>
	<li>Permission - What resources a user has access to</li>
	<li>Pre Reservation - What happens before a reservation is booked</li>
	<li>Post Reservation - What happens after a reservation is booked</li>
</ul>

<p>
	To enable a plugin, set the value of the config setting to the name of the plugin folder. For example, to enable
	LDAP
	authentication, set
	$conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

<p>Plugins may have their own configuration files. For LDAP, rename or copy
	/plugins/Authentication/Ldap/Ldap.config.dist to /plugins/Authentication/Ldap/Ldap.config and edit all values that
	are applicable to your environment.</p>

<h3>Installing Plugins</h3>

<p>To install a new plugin copy the folder to either the Authentication, Authorization and Permission directory. Then
	change either $conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] or
	$conf['settings']['plugins']['Permission'] in config.php to the name of that folder.</p>

<h2>Available Label Tokens</h2>
<p>Available tokens for reservation lables are {literal}{name}, {title}, {description}, {email},
	{phone}, {organization}, {position}, {startdate}, {enddate}, {resourcename}{/literal}. Custom attributes can be added using att with the attribute id. For example {literal}{att1}{/literal}
	Leave it blank for no label. Any combination of tokens can be used.</p>
</div>


{include file='globalfooter.tpl'}