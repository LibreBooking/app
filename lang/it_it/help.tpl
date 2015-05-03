{*
Copyright 2011-2015 Nick Korbel

Translation: 2014 Daniele Cordella <kordan@mclink.it>

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
<h1>Manuale di Booked Scheduler</h1>

<div id="help">
<h2>Registrazione</h2>

<p>La registrazione &egrave; necessaria per utilizzare Booked Scheduler, se l'amministratore ha imposto questo vincolo. Solo un utente registrato pu&ograve; accedere a Booked Scheduler e prenotare le risorse per le quali dispone dei permessi necessari.</p>

<h2>Prenotazione</h2>

<p>Sotto la voce di menu "Calendario" si trova la voce "Prenotazioni" per accedere al calendario per le prenotazioni. Il calendario riporta i giorni disponibili, quelli con prenotazioni cos&igrave; come quelli bloccati e permetter&agrave; di prenotare le risorse per le quali si dispone dei permessi. Nella pagina delle prenotazioni, si trovano le risorse (aule, generalmente), le date e gli orari per prenotare.</p>

<h3>Express</h3>

<p>Le caselle del calendario danno informazioni in merito alla disponibilit&agrave; della risorsa. Cliccando su una casella del calendario non occupata da altre prenotazioni si potranno effettuare proprie prenotazioni. Tramite il bottone "Crea", si realizza la prenotazione e si inviano le email di notifica qualora previste. All'atto della prenotazione verr&agrave; fornito un numero di riferimento della prenotazione.</p>

<p>Qualsiasi modifica effettuata non avr&agrave; effetto fino al salvataggio della prenotazione.</p>

<p>Solo gli Amministratori possono creare prenotazioni nel passato.</p>

<h3>Risorse Multiple</h3>

<p>Si possono associare alla prenotazione di una risorsa risorse addizionali (aule, generalmente) per le quali si dispone dei permessi. Per associare risorse addizionali si selezioni il link "Altre Risorse" visualizzato di fianco del nome della risorsa principale che si sta prenotando. Si avr&agrave; la possibilit&agrave; di aggiungere le nuove risorse selezionandole dalla lista e chiudendo la finestra con il bottone "Fatto".</p>
<p>Per rimuovere risorse addizionali da una prenotazione, si proceda analogamente a quanto fatto per aggiungerle, selezionando il link "Altre Risorse" visualizzato di fianco del nome della risorsa principale. Per eliminare risorse addizionali si deselezionino nella lista e si chiuda la finestra con il bottone "Fatto".</p>

<p>Le risorse addizionali saranno soggette alle stesse regole della risorsa principale. Per esempio, se si tentasse di creare una prenotazione di 2 ore con la risorsa principale che ha un tempo massimo di prenotazione di 3 ore e una risorsa addizionale che ha un tempo massimo di prenotazione di 1 ora, la prenotazione verrebbe rifiutata.</p>

<p>I dettagli di configurazione di una risorsa sono visibili spostando il cursore del mouse sul nome della risorsa.</p>

<h3>Date ripetute</h3>

<p>Una prenotazione pu&ograve; essere configurata come periodica, in diversi modi. In qualunque modo la si realizzi, la data di fine prenotazione si intende sempre compresa.</p>

<p>Le opzioni di periodicit&agrave; sono molto flessibili. Per esempio: "Ripetizione giornaliera Ogni 2 giorni" crea una prenotazione ogni 2 giorni, all'orario specificato. "Ripetizione settimanale, ogni 1 settimana di Luned&igrave;, Mercoled&igrave;, Venerd&igrave;", crea una prenotazione in ciascuno di questi giorni ogni settimana, all'orario specificato. Se si sta creando una prenotazione il 17/01/2015, con "ripetizione mensile ogni 3 mesi, giorno del mese", si crea una prenotazione per il giorno 17 del mese, ogni 3 mesi. Se il 17/01/2015 &egrave; il terzo sabato di Gennaio, una prenotazione "ripetizione mensile ogni 3 mesi, giorno della settimana" crea una prenotazione ogni terzo mese sul terzo sabato.</p>

<h3>Partecipanti</h3>

<p>Si possono "aggiungere partecipanti" cos&igrave; come "invitare altri" all'atto della creazione di una prenotazione se questo &egrave; consentito dall'amministratore di Booked Scheduler. Aggiungendo qualcuno, lo si include nella prenotazione e nessun invito gli sar&agrave; inviato. L'utente invitato ricever&agrave; semplicemente una comunicazione per posta elettronica con la quale verr&agrave; informato di essere stato coinvolto in una prenotazione. Invitando un utente, invece, gli si mander&agrave; una email di invito. L'utente, quindi, avr&agrave; la possibilit&agrave; di accettare o rifiutare l'invito. L'accettazione di un invito implica, per un utente, la sua inclusione nella lista dei partecipanti. Il rifiuto dello stesso, l'esclusione dalla lista degli invitati.</p>

<p>Il numero totale dei partecipanti coinvolgibili in una prenotazione &egrave; limitato dalla capienza impostata per la risorsa.</p>

<h3>Accessori</h3>

<p>Gli accessori vanno intesi come strumenti di ausilio ad una prenotazione, come un proiettore o una sedia. Per aggiungere accessori alla tua prenotazione, si selezioni il link "Aggiungi" alla destra dell'etichetta "Accessori". Da li si potranno selezionare gli accessori disponibili. La disponibilit&agrave; degli stessi dipende dalla loro numerosit&agrave; e dal loro utilizzo nell'ambito delle atre prenotazioni.</p>

<h3>Prenotare per conto di un altro</h3>

<p>Solo gli amministratori dell'applicazione o dei gruppi possono prenotare per conto di altri selezionando il link "Cambia" alla destra del nome utente nella finestra di prenotazione.</p>

<p>Solo gli amministratori dell'applicazione o dei gruppi possono anche modificare o cancellare prenotazioni di altri utenti.</p>

<h2>Aggiornamento di una prenotazione</h2>

<p>L'utente pu&ograve; aggiornare una prenotazione che ha creato o che &egrave; stata creata a suo nome.</p>

<h3>Aggiornamento di una specifica istanza di una serie</h3>

<p>Se una prenotazione &egrave; impostata come periodica, allora viene creata una serie di istanze. Dopo aver modificato e aggiornato la prenotazione verr&agrave; chiesto se le modifiche andranno applicate solo all'istanza corrente o a tutta la serie. Selezionando "Solo questa istanza", le altre istanze della serie non verranno modificate. Si potranno invece aggiornare tutte le istanze della serie ancora selezionando "Tutte le Istanze", o solo le istanze future (compresa quella selezionata) scegliendo "Istanze Future".</p>

<p>Solo gli Amministratori dell'applicazione poessono aggiornare prenotazioni nel passato.</p>

<h2>Eliminare una prenotazione</h2>

<p>Eliminando una prenotazione la si rimuove definitivamente dalla pianificazione. No sar&agrave; pi&ugrave; presente in Booked Scheduler</p>

<h3>Cancellare una specifica istanza di una prenotazione periodica</h3>

<p>Come per l'aggiornamento di una prenotazione, durante la cancellazione, si deve selezionare l'istanza che si intende eliminare.</p>

<p>Solo gli Amministratori dell'applicazione possono cancellare prenotazioni nel passato.</p>

<h2>Aggiungere una prenotazione al calendario (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h2>

<p>Nella finestra di creazione di una prenotazione &egrave; presente il bottone "Aggiungi ad Outlook". Se Outlook &egrave; installato sul proprio computer, si dovrebbe ricevere una richiesta di aggiungere una riunione al proprio calendario. Se non &egrave; installato, invece, il browser potrebbe proporre di scaricare il file .ics Questo &egrave; il formato standard per i calendari. &Egrave; possibile usare questo file per aggiungere l'appuntamento in qualsiasi applicazione che supporta il formato standard iCalendar.</p>

<p>Calendars can be published for Schedules, Resources and Users. For this feature to work, the administrator must have configured a subscription key in the config file. To enable Scheudle and Resource level calendar subscriptions, simply turn subscriptions on when managing the Schedule or Resource. To turn on personal calendar subcriptions, open Schedule -> My Calendar. On the right side of the page you will find a link to Allow or Turn Off calendar subscriptions.</p>

<p> To subscribe to a Schedule calendar, open Schedule -> Resource Calendar and select the schedule you want. On the right side of the page, you will find a link to subscribe to the current calendar. Subscribing the a Resource calendar follows the same steps. To subscribe to your personal calendar, open Scheudle -> My Calendar. On the right side of the page, you will find a link to subscribe to the current calendar.</p>

<h3>Calendar client (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h3>

<p>In most cases, simply clicking the Subscribe to this Calendar link will automatically set up the subscription in your calendar Client. For Outlook, if it does not automatically add, open the Calendar view, then right click My Calendars and choose Add Calendar -> From Internet. Paste in the URL printed under the Subscribe to this Calendar link in Booked Scheduler.</p>

<h3>Google&reg; Calendar</h3>

<p>Open Google Calendar settings. Click the Calendars tab. Click Browse interesting calendars. Click add by URL. Paste in the URL printed under the Subscribe to this Calendar link in Booked Scheduler.</p>

<h2>Quote</h2>

<p>Gli amministratori possono configurare le regole di quota, basandosi su diversi criteri. Se una prenotazione v&igrave;ola una quota, si ricever&agrave; una comunicazione per posta elettronica e la prenotazione verr&agrave; rifiutata.</p>

</div>

{include file='globalfooter.tpl'}