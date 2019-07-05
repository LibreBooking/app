{*
Eredeti angol jogi nyilatkozat:

Copyright 2013-2019 Nick Korbel

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

---
Az Eredeti angol jogi nyilatkozat magyar fordítása:

Szerzői jog tulajdonos: 2011-2019 Nick Korbel

Ez a fájl a Booked Scheduler része.

Booked Scheduler szabad szoftver: terjesztheted vagy módosíthatod a GNU Általános Nyilvános Licensz 
bármely 3 változata vagy (belátásod alapjánszerint) későbbi változatok alapján,
amelyeket a Free Software Foundation, adott ki. 

Booked Scheduler abban a reményben kerül terjesztésre, hogy hasznos lesz,
ém MINDEN GARANCIA NÉLKÜL; még a KERESKEDELMI vagy GYAKORLATI FELHASZNÁLÁS
hallgatólagos garanciája nélkül.  További információt a 
GNU Általános Nyilvános Licenszben talál.

A Booked Scheduler mellett meg kellett kapja a GNU Általános Nyilvános Licensz egy példányát is.
Amennyiben nem, kérjük látogassa meg az alábbi oldalt <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl' cssFiles="https://cdn.rawgit.com/afeld/bootstrap-toc/v0.4.1/dist/bootstrap-toc.min.css"}


<div id="page-help">

    <div class="row">
        <div id="toc-div" class="col-sm-3 hidden-xs scrollspy">
            <nav id="toc" role="navigation" data-spy="affix" style="overflow-y: scroll;max-height:80%">
            </nav>
        </div>

        <div id="help" class="col-xs-12 col-sm-9">
            <h1>{$AppTitle} Súgó</h1>

            <div id="help-registration">

                <h2>Regisztráció</h2>

                <p>
                    Regisztráció szükséges a {$AppTitle} használatához. Miután
                    fiókja
                    regisztrálásra került
                    lehetősége nyílik a bejelentkezésre és hozzáférhet minden olyan elemhez, amelyre jogosultsága van.
                </p>

            </div>

            <div id="help-booking">

                <h2>Foglalás</h2>

                <p>
                    A beosztások menüpont alatt megtalálhatja a foglalás menüpontot. Itt megtekintheti az összes szabad, foglalt
					és zárolt rekeszt a beosztáson és lehetősége van foglalni
                    elemeket, amelyekre jogosultsága van.
                </p>

                <p>
                    A Foglalások oldalon, keresse meg az elemet, a dátumot és időt, amelyet foglalni szeretne. Az idő rekeszre kattintva
                    lehetőség van a foglalás beállítására. A Létrehoz gombra
                    kattintva ellenőrzésre kerül az elérhetőség, foglalása bejegyzésre kerül, amelyről e-mailt is kap. Kapni fog egy referencia számot
                    mellyel követheti a foglalását.
                </p>

                <p>Bármilyen változtatás a foglaláson a Mentés gombra kattintást követően fog aktualizálódni.</p>

                <p>Alapértelmezettként, csak az alkalmazás adminisztrátorok képesek múltidőben regisztrációt létrehozni.</p>

            </div>

            <div id="help-find-a-time">
                <h3>Időpont keresése</h3>
                <p>
                    A Beosztások menüpont alatt van egy Időpont keresése is. Itt nyílik lehetőség minden olyan elérhető időpont
                    keresésére, amely megegyezik a feltételeivel.
                </p>

            </div>

            <div id="help-multiple-resources">

                <h3>Többszörös elemek</h3>

                <p>Minden elemet lefoglalhat, amelyhez hozzáférési joga van egy egyszeri foglalás alkalmával. Elemek foglalásához
                    adásához, kattintson a További elemek linkre, amely az elsődleges elem foglalása mellett van feltűntetve
                    . Ekkor hozzáadhat több elemet is a kijelőlésükkel, majd a Kész gombra kattintással.</p>

                <p>Már hozzáadott elemek eltávolításához, kattintson a További Elemek linkre, vonja vissza kijelölését a nem kívánt
                    elemek mellől, majd kattintson a Kész gombra.</p>

                <p>A további elemekre is az elsődlegesen foglalt elem szabályai lesznek érvényesek. Például ez azt jelenti, hogy ha
                    szeretne létrehozni egy 2 órás foglalást az Elem 1-nél Elem 2-vel, amelynek maximum 1 órás foglalása lehet,
					foglalása elutasáításra kerül.

                <p>Az elem beállíásait megtekintheti, ha az elem fölé viszi az egerét.</p>

            </div>

            <div id="help-recurring-dates">

                <h3>Visszatérő dátumok</h3>

                <p>Egy foglalást többféle képpen beállíthatunk visszatérőként.</p>

                <p>The repeat options allow for flexible recurrence possibilities. For example: Repeat Daily every 2 days will
                    create a reservation every other day for your specified time. Repeat Weekly, every 1 week on Monday, Wednesday,
                    Friday will create a reservation on each of those days every week at your specified time. If you were creating a
                    reservation on 2011-01-15, repeating Monthly, every 3 months on the day of month would create a reservation
                    every third month on the 15th. Since 2011-01-15 is the third Saturday of January, the same example with the day
                    of week selected would repeat every third month on the third Saturday of that month.</p>

            </div>

            <div id="help-additional-participants">

                <h3>Additional Participants</h3>

                <p>You can either Add Participants or Invite Others when booking a reservation. Adding someone will include them on
                    the reservation and will not send an invitation.
                    The added user will receive an email.</p>
                <p>Inviting a user will send an invitation email and give the user an option
                    to Accept or Decline the invitation. Accepting an
                    invitation adds the user to the participants list. Declining an invitation removes the user from the invitees
                    list.
                </p>

                <p>
                    The total number of participants is limited by the resource's participant capacity.
                </p>

            </div>

            <div id="help-accessories">

                <h3>Accessories</h3>

                <p>Accessories can be thought of as objects used during a reservation. Examples may be projectors or chairs. To add
                    accessories to your reservation, click the Add link to the right of the Accessories title. From there you will
                    be able to select a quantity for each of the available accessories. The quantity available during your
                    reservation time will depend on how many accessories are already reserved.</p>

            </div>

            <div id="help-admin-booking">

                <h3>Booking on behalf of others</h3>

                <p>Application Administrators and Group Administrators can book reservations on behalf of other users by clicking
                    the Change link to the right of the user's name.</p>

                <p>Application Administrators and Group Administrators can also modify and delete reservations owned by other
                    users.</p>

            </div>

            <div id="help-reservation-updates">

                <h2>Updating a Reservation</h2>

                <p>You can update any reservation that you have created or that was created on your behalf.</p>

            </div>

            <div id="help-reservation-updates-instance">

                <h3 data-toc-text="Specific Instances">Updating Specific Instances From a Series</h3>

                <p>
                    If a reservation is set up to repeat, then a series is created. After you make changes and Update the
                    reservation, you will be asked which instances of the series you want to apply the changes to. You can
                    apply your changes to the instance that you are viewing (Only This Instance) and no other instances will be
                    changed.
                    You can update All Instances to apply the change to every reservation instance that has not yet occurred. You
                    can also apply the change only to Future Instances, which will update all reservation instances including and
                    after the instance you are currently viewing.
                </p>

                <p>Only Application Administrators can update reservations in the past.</p>

            </div>

            <div id="help-reservation-delete">

                <h2>Deleting a Reservation</h2>

                <p>Deleting a reservation completely removes it from the schedule. It will no longer be visible anywhere in
                    {$AppTitle}</p>

                <h3 data-toc-text="Specific Instances">Deleting Specific Instances From a Series</h3>

                <p>Similar to updating a reservation, when deleting you can select which instances you want to delete.</p>

                <p>Only Application Administrators can delete reservations in the past.</p>

            </div>

            <div id="help-email-notifications">

                <h2>Email Notifications</h2>
                <p>
                    can send you email notifications for different events. You can turn notifications on or off
                    in My Account > Notification Preferences.
                </p>

            </div>

            <div id="help-credits">

                <h2>Credits</h2>

                <p>Credits give administrators control over resource usage. A resource may be configured to consume a certain number of
                    credits per slot. If you don't have enough credits, you will not be allowed to complete a booking. You can view your
                    credit usage in the Credits section of My Account</p>

                <h2>Paying for Reservation Usage</h2>
                <p>Reservations can be paid for using credits. If you do not have enough credits to complete a reservation, you can purchase credits in the Credits section of My
                    Account. You can also view your purchase history and credit usage history in the Credits section of My Account.</p>

                <h2 data-toc-text="Add to Calendar">Adding a Reservation to Calendar (Outlook&reg;, iCal, Mozilla
                    Lightning,
                    Evolution)</h2>

                <p>When viewing or updating a reservation you will see a button to Add to Outlook. If Outlook is installed on your
                    computer then you should be asked to add the meeting. If it is not installed you will be prompted to download an
                    .ics file. This is a standard calendar format. You can use this file to add the reservation to any application
                    that supports the iCalendar file format.</p>

            </div>

            <div id="help-subscriptions">

                <h2>Subscribing to Calendars</h2>

                <p>You can easily display
{$AppTitle}
events in external calendars like Microsoft Outlook and Google Calendar.
To do this, you subscribe to calendars.</p>

                <p>Calendars can be published for Schedules, Resources and Users. For this feature to work, the administrator must
                    have
                    configured a subscription key in the config file. To enable Schedule and Resource level calendar
                    subscriptions, simply allow public visibility when managing the Schedule or Resource. To turn on personal calendar
                    subscriptions, open Schedule > My Calendar. On the right side of the page you will find a link to Allow or Turn
                    Off calendar subscriptions.
                </p>

                <p> To subscribe to a Schedule calendar, open Schedule > Resource Calendar and select the schedule you want. On the
                    right side of the page, you will find a link to subscribe to the current calendar. Subscribing the a Resource
                    calendar follows the same steps.</p>
                <p>To subscribe to your personal calendar, open Schedule > My Calendar. On the
                    right side of the page, you will find a link to subscribe to the current calendar.</p>

                <p>By default events for the next 30 will be returned. This can be customized with the
                    following two query string parameters on the subscription URL. pastDayCount and futureDayCount will override the
                    past and future number of days loaded, respectively.</p>

            </div>

            <div id="help-calendar-client">
                <h3 data-toc-text="Calendar Client">Calendar client (Outlook, iCal, Mozilla Lightning,
                    Evolution)</h3>

                <p>In most cases, simply clicking the Subscribe to this Calendar link will automatically set up the subscription in
                    your calendar Client. For Outlook, if it does not automatically add, open the Calendar view, then right click My
                    Calendars and choose
                    Add Calendar > From Internet. Paste in the URL printed under the Subscribe to this Calendar link.</p>

                <div id="help-google-calendar">
                <h3>Google Calendar</h3>

                <p>Open Google Calendar settings. Click the Calendars tab. Click Browse interesting calendars. Click add by URL.
                    Paste
                    in the URL printed under the Subscribe to this Calendar link.</p>

                </div>

                <div id="help-embed-calendar">
                <h3>Embedding a Calendar Externally</h3>
                <p class="note">This requires CORS to be enabled on your server. You can add the following to your
                    Apache htaccess file <code>Header Set Access-Control-Allow-Origin "*"</code></p>
                <p>It is simple to include a view of a Booked calendar in an external website. Copy and paste the
                    following
                    JavaScript
                    reference to your website
                    <code>
                        &lt;script async src=&quot;{$ScriptUrl}/scripts/embed-calendar.js&quot; crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;
                    </code>
                </p>

                <p>The following querystring arguments are accepted to customize the embedded view:</p>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Possible Values</th>
                        <th>Default</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>type</td>
                        <td>agenda, week, month</td>
                        <td>agenda</td>
                        <td>Controls the view that is shown</td>
                    </tr>
                    <tr>
                        <td>format</td>
                        <td>date, title, user, resource</td>
                        <td>date</td>
                        <td>Controls the information shown in the reservation box. Multiple options can be passed. For
                            example, to show date and title request date,title
                        </td>
                    </tr>
                    <tr>
                        <td>d</td>
                        <td>Any digit between 1 and 30</td>
                        <td>7</td>
                        <td>Limits the number of days shown for the agenda view</td>
                    </tr>
                    <tr>
                        <td>sid</td>
                        <td>Any schedule public ID</td>
                        <td>All schedules</td>
                        <td>Limits the reservations shown to a specific schedule</td>
                    </tr>
                    <tr>
                        <td>rid</td>
                        <td>Any resource public ID</td>
                        <td>All resources</td>
                        <td>Limits the reservations shown to a specific resource</td>
                    </tr>
                    </tbody>
                </table>

                <p><strong>Only calendars and resources that have been marked as public will be shown.</strong> If
                    reservations
                    are missing from a schedule or resource, it is likely that public visibility has not been turned on.
                </p>
                </div>
            </div>

            <div id="help-quotas">

                <h2>Quotas</h2>

                <p>Administrators have the ability to configure quota rules based on a variety of criteria. If your reservation
                    would violate any quota, you will be notified and the reservation will be denied.</p>

                <h2>Waiting For Availability</h2>

                <p>If a time is not available you can sign up to be notified if it becomes available. This option will be shown
                    after a reservation attempt is made.</p>
            </div>

        </div>
    </div>
    <script src="https://cdn.rawgit.com/afeld/bootstrap-toc/v0.4.1/dist/bootstrap-toc.min.js"></script>
    {include file="javascript-includes.tpl"}
    <script type="text/javascript">
        $(function () {
            var navSelector = '#toc';
            var $myNav = $(navSelector);
            Toc.init({
                $nav: $myNav,
                $scope: $('#help')
            });

            $('body').scrollspy({
                target: navSelector,
                offset: 50
            });
        });
    </script>
    {include file='globalfooter.tpl'}
