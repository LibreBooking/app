{*
Copyright 2011-2012 Nick Korbel

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
<h1>phpScheduleIt Hilfe   (Übersetzung ist noch nicht komplett)</h1>

<div id="help">
<h2>Registrierung / Konto hinzufügen</h2>

<p>Um phpScheduleIt verwenden zu können, ist eine Registrierung erforderlich. (Wenn der Administrator die Registrierung aktiviert hat).
Nachdem Ihr Konto registriert wurde, können Sie sich anmelden und haben Zugriff auf alle Ressourcen, die für Sie freigegeben wurden.
</p>

<h2>Buchen einer Reservierung</h2>

<p>
Unter dem Menüpunkt "Terminplan" finden Sie das Buchungselement in Form eines Wochenkalenders. 
Dieser zeigt Ihnen die verfügbaren, reservierten und blockierten Slots (Zeitfenster) und ermöglicht es Ihnen, Ressourcen zu buchen.
Sie können nur Ressourcen buchen, die für Sie freigegeben wurden.
</p>

<h3>Schnelles Buchen</h3>

<p>
Auf der Buchungsseite finden Sie die Ressourcen, das Datum und die Uhrzeiten die Sie buchen können.
Nach einem Klick auf das für Sie passende Zeitfenster können Sie die Details Ihrer Reservierung eintragen/ändern.
Nach einem Druck auf die Schaltfläche "Anlegen" wird die Verfügbarkeit geprüft, die Reservierung gebucht wenn verfügbar und 
eine Email mit Buchungs-Bestätigung/-Änderung/-Löschung gesendet.
Weiterhin erhalten Sie eine Referenznummer für evt. Rückfragen.
</p>

<p>
Alle Änderungen an einer Reservierung werden erst wirksam, wenn Sie die Buchung speichern in dem Sie auf "Update" drücken.
</p>

<p>
Nur Anwendungsadministratoren können Reservierungen in der Vergangenheit eintragen.
</p>

<h3>Mehrere Ressourcen</h3>

<p>
Sie können alle Ressourcen die Sie gleichzeitig benötigen, in einer einzigen Reservierung zusammen buchen. 
Um eine weitere Ressource zu Ihrer Reservierung hinzuzufügen, klicken Sie auf "Weitere Ressourcen".
Diesen Link finden Sie neben dem Namen der primären Ressource, die Sie reservieren möchten. 
Nach dem Klick auf "Weitere Ressourcen" können Sie aus einer Liste mehr Ressourcen auswählen und durch einen Klick 
auf die Schaltfläche "Fertig" hinzuzufügen. 
</p>

<p>
Um zusätzlich hinzugefügte Ressourcen von der Reservierung zu entfernen, klicken Sie auf
"Weitere Ressourcen" und deaktivieren die Ressourcen wieder.
</p>

<p>
Zusätzliche Ressourcen unterstehen den gleichen Regeln wie die primäre Ressource.
Dies bedeutet zum Beispiel, dass, wenn Sie versuchen eine 2-stündige Buchung mit Resource 1, 
die eine maximale Buchungslänge von 3 Stunden hat und mit Resource 2, die
eine maximale Buchungslänge von 1 Stunde hat, zu erstellen, Ihre Reservierung verweigert wird.
</p>

<p>
Die genauen Konfigurationsdaten einer Ressource werden Ihnen angezeigt, wenn Sie mit der Maus auf die Ressource zeigen.
</p>

<h3>Wiederkehrende Termine</h3>

<p>
Reservierungen können automatisch wiederholt werden. 
Für die Wiederholung gibt es eine Reihe von verschieden Möglichkeiten.
Alle Wiederholungsoptionen gelten inklusive des Bis-Datums.
</p>

<p>
Die Optionen für die Wiederholung ermöglichen sehr flexible Wiederholungsmöglichkeiten. 
Zum Beispiel: 
"Täglich alle 2 Tage" erstellt Reservierungen für jeden zweiten Tag für Ihre angegebene Zeit.
"Wöchentlich, jede 1. Woche am Montag, Mittwoch, Freitag" erstellt eine Reservierung an jedem dieser Tage in jeder Woche für Ihre angegebene Zeit.
"Monatlich, jeden 3. Monat am 15. des Monats" ist genauso möglich wie 
"Monatlich, jeden 3. Monat am 3. Samstag des Monats".
</p>

<h3>Weitere Teilnehmer</h3>

<p>
Wenn der Administrator die Option "Teilnehmer einladen" freigeschaltet hat, können Sie auch weitere Teilnehmer 
zu jeder Reservierung hinzufügen bzw. einladen.
Hinzugefügte Teilnehmer werden in der Teilnehmerliste der Reservierung eingetragen und erhalten eine Email.
Eingeladene Teilnehmer erhalten eine Einladung per E-Mail und haben dann die Möglichkeit, die Einladung anzunehmen oder abzulehnen.
Nach Annahme einer Einladung wird der Benutzer zur Teilnehmerliste hinzugefügt. 
Nach einer Absage wird der Benutzer von der Einladungsliste gelöscht.
</p>

<p>
Die Gesamtzahl der Teilnehmer wird durch die Kapazität der Ressource begrenzt.
</p>

<h3>Zubehör</h3>

<p>
Zubehör sind Objekte, die man zu einer Reservierung hinzufügen und mit der Ressouce zusammen nutzen kann.
Zum Beispiel Projektoren oder Stühle.
Um Zubehör für Ihre Reservierung hinzuzufügen, klicken Sie auf den Link Zubehör "Hinzufügen".
Nun können Sie das Zubehör und die erforderliche Menge des Zubehörs auswählen bzw. eintragen.
Die verfügbare Menge des Zubehörs ist abhängig von möglicherweise bereits reservierten Zubehörteilen.
</p>

<h3>Buchen im Namen anderer</h3>

<p>
Anwendungsadministratoren und Gruppenadministratoren können Reservierungen für andere Nutzer zu buchen, 
indem Sie auf den Link "Ändern" rechts neben dem Namen des Benutzers klicken.
</p>

<p>
Anwendungsadministratoren und Gruppenadministratoren können auch Reservierungen anderer Benutzer ändern und löschen.
</p>

<h2>Aktualisieren einer Reservierung</h2>

<p>
Sie können jede Reservierung die Sie erstellt haben oder die auf Ihrem Namen erstellt wurde, ändern.
</p>

<h3>Aktualisieren von wiederholten Reservierungen (Serienreservierung)</h3>

<p>
Wenn eine Buchung mit Wiederholung erstellt wird, dann handelt es sich um einer Serienreservierung.
Nachdem Sie Änderungen vorgenommen haben und die Reservierung aktualisieren möchten, werden
Sie aufgefordert, die Instanzen der Serie auszuwählen, für die Sie die Änderungen vornehmen möchten.
Sie haben verschiedene Auswahlmöglichkeiten.
</p>
<p>
Sie können Ihre Änderungen an der Instanz anwenden, die Sie gerade sehen (nur an dieser Instanz) 
und alle anderen Instanzen werden nicht verändert.
Sie können Ihre Änderungen an allen Instanzen anwenden, die noch nicht abgelaufen sind.
Sie können Ihre Änderungen an allen zukünftigen Instanzen ab der und inklusive der gerade betrachteten Instanz durchführen lassen.
</p>

<p>
Nur Anwendungsadministratoren können Reservierungen in der Vergangenheit verändern.
</p>

<h2>Löschen einer Reservierung</h2>

<p>
Das löschen einer Reservierung entfernt sie komplett aus dem Zeitplan. Sie wird in phpScheduleIt nirgends mehr sichtbar sein.
</p>

<h3>Löschen von Wiederholungsbuchungen</h3>

<p>
Ähnlich wie bei der "Aktualisierung einer Wiederholungsreservierung" können Sie beim Löschen 
auswählen, welche Instanzen Sie löschen möchten.
</p>

<p>
Nur Anwendungadministratoren können Reservierungen in der Vergangenheit löschen.
</p>

<h2>
Hinzufügen einer Reservierung zum eigenen Kalender (Outlook®, iCal, Mozilla, Lightning, Evolution)
</h2>

<p>
Beim Betrachten oder Aktualisieren einer Reservierung finden Sie eine Taste,
um Outlook-Add. Wenn Outlook auf Ihrem Computer installiert ist, dann
sollten Sie gebeten, die Sitzung hinzuzufügen. Wenn es nicht installiert
ist, werden Sie aufgefordert, eine. Ics-Datei herunterladen. Dies ist ein
Standard-Kalender-Format. Sie können diese Datei verwenden, um die
Reservierung für jede Anwendung, die das iCalendar-Format unterstützt
hinzuzufügen.

When viewing or updating a reservation you will see a button to Add to Outlook. If Outlook is installed on your
	computer then you should be asked to add the meeting. If it is not installed you will be prompted to download an
	.ics file. This is a standard calendar format. You can use this file to add the reservation to any application
	that supports the iCalendar file format.</p>

<h2>Abonnieren von Kalendern

Subscribing to Calendars</h2>

<p>
Kalender für Termine, Ressourcen und Benutzer veröffentlicht werden. Damit
diese Funktion funktioniert, muss der Administrator einen
Subscription-Schlüssel in der Konfigurationsdatei konfiguriert haben. Um
Scheudle and Resource Ebene Kalender-Abonnements aktivieren, drehen Sie
einfach Abonnements bei der Verwaltung des Zeitplans oder Ressource. Auf
persönlichen Kalender Mitgliederbeiträge drehen, offene Termine -> Mein
Kalender. Auf der rechten Seite der Seite finden Sie einen Link auf Zulassen
oder Ausschalten Kalender Abonnements.

Calendars can be published for Schedules, Resources and Users. For this feature to work, the administrator must have
	configured a subscription key in the config file. To enable Scheudle and Resource level calendar
	subscriptions, simply turn subscriptions on when managing the Schedule or Resource. To turn on personal calendar
	subcriptions, open Schedule -> My Calendar. On the right side of the page you will find a link to Allow or Turn Off
	calendar subscriptions.
</p>

<p>
Um einen Zeitplan Kalender, offene Schedule abonnieren -> Resource Kalender
und wählen Sie den gewünschten Zeitplan. Auf der rechten Seite der Seite
finden Sie einen Link auf die aktuelle Kalender abonnieren. Anmeldung die
eine Ressource Kalender folgt den gleichen Schritten. Um Ihren persönlichen
Kalender, offene Scheudle abonnieren -> Mein Kalender. Auf der rechten Seite
der Seite finden Sie einen Link auf die aktuelle Kalender abonnieren.
Kalender-Client (Outlook ®, iCal, Mozilla Lightning, Evolution)

 To subscribe to a Schedule calendar, open Schedule -> Resource Calendar and select the schedule you want. On the
	right side of the page, you will find a link to subscribe to the current calendar. Subscribing the a Resource
	calendar follows the same steps. To subscribe to your personal calendar, open Scheudle -> My Calendar. On the
	right side of the page, you will find a link to subscribe to the current calendar.</p>

<h3>Calendar client (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h3>

<p>
In den meisten Fällen wird einfach auf das zu diesem Kalender Link
abonnieren und automatisch die Abonnements in Ihrem Kalender-Client. Für
Outlook, falls es nicht automatisch, öffnen Sie die Kalenderansicht, dann
rechts auf Meine Kalender und wählen Sie Hinzufügen Kalender -> Aus dem
Internet. Fügen Sie in der URL, unter der dieser Kalender Link Abonnieren in
phpScheduleIt gedruckt.
Google ® Kalender

In most cases, simply clicking the Subscribe to this Calendar link will automatically set up the subscription in
	your calendar Client. For Outlook, if it does not automatically add, open the Calendar view, then right click My
	Calendars and choose
	Add Calendar -> From Internet. Paste in the URL printed under the Subscribe to this Calendar link in
	phpScheduleIt.</p>

<h3>Google&reg; Calendar</h3>

<p>
Öffnen Sie Google Kalender Einstellungen. Klicken Sie auf die Registerkarte
Kalender. Klicken Sie auf Durchsuchen interessanten Kalender. Klicken Sie
auf Hinzufügen von URL. Fügen Sie in der URL, unter der dieser Kalender Link
Abonnieren in phpScheduleIt gedruckt.

Open Google Calendar settings. Click the Calendars tab. Click Browse interesting calendars. Click add by URL. Paste
	in the URL printed under the Subscribe to this Calendar link in phpScheduleIt.</p>

<h2>Quotas</h2>

<p>
Administratoren haben die Möglichkeit, Quotenregelungen auf einer Vielzahl
von Kriterien zu konfigurieren. Wenn Sie Ihre Reservierung geartetes
Quotensystem verstoßen würde, werden Sie benachrichtigt und die Reservierung
wird verweigert. 

Administrators have the ability to configure quota rules based on a variety of criteria. If your reservation
	would violate any quota, you will be notified and the reservation will be denied.</p>

</div>

{include file='globalfooter.tpl'}
