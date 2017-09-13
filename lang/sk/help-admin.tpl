{*
Copyright 2011-2013 Nick Korbel

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
{include file='globalheader.tpl'}
<h1>Rezervácie online - administrácia</h1>

<div id="help">
<h2>Administration</h2>

<p>Ak ste v úlohe správcu aplikácií potom uvidíte položku Správa aplikácií. všetko 
administratívne úlohy možno nájsť tu.</p>

<h3>Nastavenie plánov</h3>

<p>
	Po inštalácii Rezervácie online predvolený plán bude vytvorený z nastavení schránky. od 
voľby menu Plány možno zobraziť a upravovať vlastnosti súčasných plánov.
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

<p>Resources in phpScheduleIt can be anything you want to make bookable, such as rooms or equipment. Every resource
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

<p>Quotas prevent reservations from being booked based on a configurable limit. The quota system in phpScheduleIt is
	very flexible, allowing you to build limits based on reservation length and number reservations. Also, quota limits
	"stack". For example, if a quota exists limiting a resource to 5 hours per day and another quota exists limiting to
	4 reservations per day a user would be able to make 4 hour-long reservations but would be restricting from making 3
	two-hour-long reservations. This allows powerful quota combinations to be built.</p>

<p>Application Administrators are exempt from quota limits.</p>

<h3>Setting up Announcements</h3>

<p>Announcements are a very simple way to display notifications to phpScheduleIt users. From the Announcements menu item
	you can view and manage the announcements that are displayed on users dashboards. An announcement can be configured
	with an optional start and end date. An optional priority level is also available, which sorts announcements from 1
	to 10.</p>

<p>HTML is allows within the announcement text. This allows you to embed links or images from anywhere on the web.</p>

<h3>Setting up Groups</h3>

<p>Groups in phpScheduleIt organize users, control resource access permissions and define roles within the
	application.</p>

<h3>Roles</h3>

<p>Roles give a group of users the authorization to perform certain actions.</p>

<p>Users that belong to a group that is given the Application Administrator role are open to full administrative
	privileges. This role has nearly zero restrictions on what resources can be booked. It can manage all aspects of the
	application.</p>

<p>Users that belong to a group that is given the Group Administrator role are able to reserve on behalf of and manage
	users within that group.</p>

<h3>Viewing and Managing Reservations</h3>

<p>You can view and manage reservations from the Reservations menu item. By default you will see the last 7 days and the
	next 7 days worth of reservations. This can be filtered more or less granular depending on what you are looking for.
	This tool allows you to quickly find an act on a reservation. You can also export the list of filtered reservations
	to CSV format for further reporting.</p>

<h3>Reservation Approval</h3>

<p>From the Reservations admin tool you will be able to view and approve pending reservations. Pending reservations will
	be highlighted.</p>

<h3>Viewing and Managing Users</h3>

<p>You can add, view, and manage all registered users from the Users menu item. This tool allows you to change resource
	access permissions of individual users, deactivate or delete accounts, reset user passwords, and edit user details.
	You can also add new users to phpScheduleIt. This is especially useful if self-registration is turned off.</p>

<h3>Reporting</h3>

<p>Reports are accessible to all application, group, resource and schedule administrators. When the currently logged in
	user has access to reporting features, they will see a Reports navigation item. phpScheduleIt comes with a set of
	Common Reports which can be viewed as a list of results, a chart, exported to CSV and printed. In addition, ad-hoc
	reports can be created from the Create New Report menu item. This also allows listing, charting, exporting and
	printing. In addition, custom reports can be saved and accessed again at a later time from the My Saved Reports menu
	item. Saved reports also have the ability to be emailed.</p>

<h2>Configuration</h2>

<p>Some of phpScheduleIt's functionality can only be controlled by editing the config file.</p>

<p class="setting"><span>$conf['settings']['server.timezone']</span>This must reflect the timezone of the server that
	phpScheduleIt is hosted
	on. You can view the current timezone from the Server Settings menu item. Possible values are located here:
	http://php.net/manual/en/timezones.php</p>

<p class="setting"><span>$conf['settings']['allow.self.registration']</span>If users are allowed to register new
	accounts.</p>

<p class="setting"><span>$conf['settings']['admin.email']</span>The email address of the main application administrator
</p>

<p class="setting"><span>$conf['settings']['default.page.size']</span>The initial number of rows for any page that
	displays a list of data
</p>

<p class="setting"><span>$conf['settings']['enable.email']</span>Whether or not any emails are sent out of phpScheduleIt
</p>

<p class="setting"><span>$conf['settings']['default.language']</span>Default language for all users. This can be any
	language in the
	phpScheduleIt lang directory</p>

<p class="setting"><span>$conf['settings']['script.url']</span>The full public URL to the root of this instance of
	phpScheduleIt. This should
	be the Web directory which contains files like bookings.php and calendar.php</p>

<p class="setting"><span>$conf['settings']['password.pattern']</span>A regular expression to enforce password complexity
	during user account
	registration</p>

<p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>Whether or not resources
	that are not
	accessible to the user
	are displayed in the schedule</p>

<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>The value to display for the
	reservation on the
	Bookings page. Options
	are 'name', 'title', or 'none'. Default is 'name'.</p>

<p class="setting"><span>$conf['settings']['image.upload.directory']</span>The physical directory to store images.
	This directory will need to be writable (755 suggested). This can be the full directory or relative to the
	phpScheduleIt root directory.</p>

<p class="setting"><span>$conf['settings']['image.upload.url']</span>The URL where uploaded
	images can be viewed from. This can be the full URL or relative to $conf['settings']['script.url'].
</p>

<p class="setting"><span>$conf['settings']['cache.templates']</span>Whether or not templates are cached. It is
	recommended to set this to
	true, as long as tpl_c is writable</p>

<p class="setting"><span>$conf['settings']['use.local.jquery']</span>Whether or not a local version of jQuery files
	should be used. If set to false, the files will be served from the Google CDN. It is recommended to set this to
	false to improve performance and bandwidth usage. Default is false.</p>

<p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>Whether or not captcha image security
	is enabled during user account registration</p>

<p class="setting"><span>$conf['settings']['registration.require.email.activation']</span>Whether or not a user will be
	required to activate their account by email before logging in.</p>

<p class="setting"><span>$conf['settings']['registration.auto.subscribe.email']</span>Whether or not users will be
	automatically subscribed to all emails upon registration.</p>

<p class="setting"><span>$conf['settings']['inactivity.timeout']</span>Number of minutes before the user is
	automatically logged out. Leave this blank if you do not want users automatically logged out.</p>

<p class="setting"><span>$conf['settings']['name.format']</span>Display format for first name and last name. Default
	is {literal}'{first} {last}'{/literal}.</p>

<p class="setting"><span>$conf['settings']['ics']['require.login']</span>If users should be required to log in to add a
	reservation to
	Outlook.</p>

<p class="setting"><span>$conf['settings']['ics']['subscription.key']</span>If you want to allow webcal subscriptions,
	set this to a
	difficult to guess value. If nothing is set then webcal subscriptions will be disabled.</p>

<p class="setting"><span>$conf['settings']['privacy']['view.schedules']</span>If non-authenticated users can view the
	booking schedules.
	Default is false.</p>

<p class="setting"><span>$conf['settings']['privacy']['view.reservations']</span>If non-authenticated users can view
	reservation details.
	Default is false.</p>

<p class="setting"><span>$conf['settings']['privacy']['hide.user.details']</span>If non-adminstrators can view personal
	information about
	other users. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation']['start.time.constraint']</span>When reservations can be
	created or edited.
	Options are future, current, none. Future means reservations cannot be created or modified if the starting time of
	the selected slot is in the past. Current means reservations can be created or modified if the ending time of the
	selected slot is not in the past. None means that there is no restriction on when reservations can be created or
	modified. Default is future.</p>

<p class="setting"><span>$conf['settings']['reservation']['updates.require.approval']</span>Whether or not updates to
	reservations which have previously been approved require approval again. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.participation']</span>Whether or not users should be
	prevented from adding and inviting others to a reservation. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.recurrence']</span>Whether or not users should be
	prevented creating recurring reservations. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>Whether or not to send an
	email to all resource administrators when a reservation is created. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>Whether or not to send
	an
	email to all resource administrators when a reservation is updated. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>Whether or not to send
	an
	email to all resource administrators when a reservation is deleted. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>Whether or not to send
	an
	email to all application administrators when a reservation is created. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>Whether or not to
	send an
	email to all application administrators when a reservation is updated. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>Whether or not to
	send an
	email to all application administrators when a reservation is deleted. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>Whether or not to send an
	email to all group administrators when a reservation is created. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>Whether or not to send an
	email to all group administrators when a reservation is updated. Default is false.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>Whether or not to send an
	email to all group administrators when a reservation is deleted. Default is false.</p>

<p class="setting"><span>$conf['settings']['css.extension.file']</span>Full or relative URL to an additional CSS file to
	include. This can be used to override the default style with adjustments or a full theme. Leave this blank if you
	are not extending the style of phpScheduleIt.</p>

<p class="setting"><span>$conf['settings']['uploads']['enable.reservation.attachments']</span>If users are allowed to
	attach files to reservations. Default is false.</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.path']</span>The full or relative
	filesystem path (relative to the root of your phpScheduleIt directory) to store reservation attachments. This
	directory must be writable by PHP (755 suggested). Default is uploads/reservation</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>Comma separated list of
	safe file extensions. Leaving this blank will allow all file types (not recommended).</p>

<p class="setting"><span>$conf['settings']['database']['type']</span>Any PEAR::MDB2 supported type</p>

<p class="setting"><span>$conf['settings']['database']['user']</span>Database user with access to the configured
	database</p>

<p class="setting"><span>$conf['settings']['database']['password']</span>Password for the database user</p>

<p class="setting"><span>$conf['settings']['database']['hostspec']</span>Database host URL or named pipe</p>

<p class="setting"><span>$conf['settings']['database']['name']</span>Name of phpScheduleIt database</p>

<p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>PHP email library. Options are mail, smtp,
	sendmail, qmail</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>SMTP host, if using smtp</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.port']</span>SMTP port, if using smtp, usually 25</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.secure']</span>SMTP security, if using smtp. Options are
	'', ssl or tls</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.auth']</span>SMTP requies authentication, if using smtp.
	Options are true
	or false</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.username']</span>SMTP username, if using smtp</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.password']</span>SMTP password, if using smtp</p>

<p class="setting"><span>$conf['settings']['phpmailer']['sendmail.path']</span>Path to sendmail, if using sendmail</p>

<p class="setting"><span>$conf['settings']['plugins']['Authentication']</span>Name of authentication plugin to use. For
	more on plugins,
	see Plugins below</p>

<p class="setting"><span>$conf['settings']['plugins']['Authorization']</span>Name of authorization plugin to use. For
	more on plugins,
	see Plugins below</p>

<p class="setting"><span>$conf['settings']['plugins']['Permission']</span>Name of permission plugin to use. For more on
	plugins, see
	Plugins below</p>

<p class="setting"><span>$conf['settings']['plugins']['PreReservation']</span>Name of prereservation plugin to use. For
	more on plugins,
	see Plugins below</p>

<p class="setting"><span>$conf['settings']['plugins']['PostReservation']</span>Name of postreservation plugin to use.
	For more on
	plugins, see Plugins below</p>

<p class="setting"><span>$conf['settings']['install.password']</span>If you are running an installation or upgrade, you
	will be required to
	provide a value here</p>

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

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}