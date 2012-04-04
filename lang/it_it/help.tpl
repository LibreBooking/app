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
<h1>phpScheduleIt Help</h1>

<div id="help">
<h2>Registrazione</h2>

<p>
Per utilizzare &egrave; necessario registrarsi, se l'amministratore ha abilitato questa possibilit&agrave;. Una volta registrato il vostro account
sarete in grado di entrare e prenotare le risorse per le quali avete i permessi.
</p>

<h2>Prenotazione</h2>

<p>
Sotto la voce di menu "Schedulazioni" si trova la voce "Booking". Questo mostrer&agrave; gli slot disponibili, riservati e
bloccati e permetter&agrave; di prenotare le risorse per le quali si hanno i permessi.
</p>

<h3>Express</h3>

<p>
Nella pagina prenotazioni, si trovano la risorsa, la data e gli orari per prenotare. Cliccando sul time-slot si potranno
modificare i dettagli della prenotazione. Facendo clic sul pulsante "Crea", si potr&agrave; verificare la disponibilit&agrave;, 
fare laprenotazione e inviare email di notifica. Verr&agrave; fornito un Numero di riferimento da utilizzare per seguire la prenotazione.
</p>

<p>Qualsiasi modifica effettuata non avr&agrave; effetto fino al salvataggio della prenotazione.</p>

<p>Solo gli Amministratori possono creare prenotazioni nel passato.</p>

<h3>Risorse Multiple</h3>

<p>Puoi prenotare tutte le risorse per le quali hai i permessi come parte di una singola prenotazione. Per aggiungere altre risorse
	alla prenotazione, clicca sul link "Altre Risorse", visualizzato di fianco al nome della risorsa primaria che stai prenotando. 
  Avrai la possibilit&agrave; di aggiungere ulteriori risorse selezionandole e cliccando sul pulsante "Fatto".</p>

<p>Per rimuovere risorse addizionali dalla tua prenotazione, clicca il link "Altre risorse", deseleziona le risorse che vuoirimuovere
e clicca il pulsante "Fatto".</p>

<p>Le risorse aggiuntive saranno soggette alle stesse regole della risorsa principale. Per esempio, se tenti di creare 
una prenotazione di 2 ore con la Risorsa 1, che ha un tempo massimo di prenotazione di 3 ore e con la Risorsa
	2, che ha un tempo massimo di prenotazione di 1 ora, la prenotazione verr&agrave; rifiutata.</p>

<p>Puoi vedere i dettagli di configurazione di na risorsa, spostando il puntatore del mouse sul nome della risorsa.</p>

<h3>Date ricorrenti</h3>

<p>Una prenotazione pu&ograve; essere configurata come ricorrente, in diversi modi. Per tutte le optioni di ricorrenza, la data "Fino a" 
	&egrave; compresa.</p>

<p>Le opzioni di ricorrenza sono molto flessibili. Per esempio: Ripeti Giornalmente ogni 2 giorni creer&agrave; una
	prenotazione ogni 2 giorni, all'orario specificato. Ripeti settimanalmente, ogni 1 settimana di Luned&igrave;, Mercoled&igrave;,
	Venerd&igrave;, creer&agrave; una prenotazione in ciascuno di questi giorni ogni settimana, all'orario specificato. Se stai creando
  una prenotazione il 15/01/2011, con ripetitivit&agrave; Mensile ogni 3 mesi, verr&agrave; creata una prenotazione il giorno 15 del mese, ogni 3 mesi. 
  Se il 15/01/2011 &egrave; il terzo sabato di Gennaio, lo stesso esempio precedente verr&agrave; eseguito ogni terzo mese sul terzo sabato di quel mese.</p>

<h3>Parteciupanti aggiuntivi</h3>

<p>Puoi Aggiungere Partecipanti o Invitare Altri quando imposti una prenotazione. Aggiungendo qualcuno, lo includerai
   nella prenotazione e non gli manderai un invito.
   L'utente invitato ricever&agrave; un'email. Invitando un utente, invece, gli manderai una email di invito e darai all'utente stesso
   la possibilit&agrave; di accettare o rifiutare l'invito. L'accettazione di un invito aggiunge l'utente alla lista partecipanti.
   Il rifiuto di un invito rimuove l'utente dalla lista degli invitati.
</p>

<p>
	Il numero totale dei partecipanti &egrave; limitato dalla capienza impostata per la risorsa.
</p>

<h3>Accessori</h3>

<p>Gli Accessori vann ointesi come oggetti utilizzati durante una prenotazione, come un proiettore o delle sedie.
   per aggiungere accessori alla tua prenotazione, clicca il link "Aggiungi" alla destra del titolo Accessori. Da li potrai
   selezionare la quantit&agrave; di accessori disponibili da aggiungere. La quantit&agrave; disponibile durante la tua prenotazione dipender&agrave;
   da quanti accessori sono stati prenotati.
</p>

<h3>Prenotazione a nome di altri</h3>

<p>Gli amministratori dell'applicazione o dei gruppi possono prenotare in nome di altri utenti cliccando il link Cambia alla destra
   del nome utente.</p>

<p>Gli amministratori dell'applicazione o dei gruppi possono anche modificare e cancellare prenotazioni di altri utenti.</p>

<h2>Aggiornamento di una prenotazione</h2>

<p>L'utente pu&ograve; aggiornare una prenotazione che ha creato o che &egrave; stata creata a suo nome.</p>

<h3>Aggiornamento di una specifica istanza di una serie</h3>

<p>
	Se una prenotazione &egrave; impostata come ricorrente, allora viene creata una serie di istanze. Dopo aver modificato e aggiornato la prenotazione
	verr&agrave; chiesto se le modifiche andranno applicate solo all'istanza corrente o a tutta la serie. Selezionando "Solo questa istanza", le altre istanze
	della serie non verranno modificate.
	Si potranno invece aggiornare tutte le istanze della serie ancora selezionando "Tutte le Istanze", o solo le istanze future (compresa quella selezionata)
	scegliendo "Istanze Future".
</p>

<p>Solo gli Amministratori dell'applicazione poessono aggiornare prenotazioni nel passato.</p>

<h2>Cancellare una prenotazione</h2>

<p>Cancellando una prenotazione la si rimuove definitivamente dalla schedulazione. No sar&agrave; pi&ugrave; visibile in phpScheduleIt</p>

<h3>Cancellare una specifica istanza di una serie</h3>

<p>Come per l'aggiornamento di una prenotazione, durante la cancellazione, si pu&ograve; selezionare quale istanza eliminare.</p>

<p>Solo gli Amministratori dell'applicazione poessono cancellare prenotazioni nel passato.</p>

<h2>Aggiungere una prenotazione ad Outlook &reg;</h2>

<p>Quando si visualizza o aggiorna una prenotazione, si trove&agrave; un pulsante "Aggiungi ad Outlook". Se Outlook &egrave; installatio sul tuo
   computer, ti verr&agrave; chiesto di aggiungere una riunione. Se non &egrave; installato, invece, il browser ti chieder&agrave; di scaricare il file .ics
   Questo file &egrave; in un formato standard per i calendari. Puoi usare questo file per aggiungere l'appuntamento in qualsiasi applicazione
   che supporta il formato standard iCalendar.</p>

<h2>Quote</h2>

<p>Gli amministratori possono configurare le regole di quota, basandosi su diversi criteri. Se la tua prenotazione
   v&igrave;ola una quota, verrai avvisato e la prenotazione verr&agrave; rifiutata.</p>

<h2>Amministrazione</h2>

<p>Se hai il ruolo di Ammionistratore dell'applciazione vedrai il menu Gestione Applicazione. Tutte le attivit&agrave; di amministrazione
   si troveranno sotto quel menu.</p>

<h3>Impostazione delle Schedulazioni</h3>

<p>
	All'installazione di phpScheduleIt, una schedulazione di default viene creata con settaggi base. Dal menu Schedulazioni
	si vedono e si possono modificare gli attributi della Schedulazione corrente.
</p>

<p>Ogni schedulazione deve avere un layout definito. Questo controlla la disponibilita delle risorse di quella schedulazione
   Cliccando il link "Cambia Layout" verr&agrave; mostrato l'editor di layout. Qui si possono creare e cambiare i time slot disponibili
   e quelli bloccati per le prenotazioni. Non ci sono limitazioni nei time slots, ma occorre fornire valori di slot per tutte le 
   24 ore del giorno, uno per riga, nel formato "24 ore".
   Si pu&ograve; definire anche un'etichetta per ogni slot, se lo si desidera.</p>

<p>Uno slot senza etichetta verr&agrave; formattato come in questo esempio: 10:25 - 16:50</p>

<p>Uno slot con etichetta verr&agrave; formattato come in questo esempio: 10:25 - 16:50 Periodo 4</p>

<p>Sotto la finestra di configurazione degli slot c'&egrave; un wizard per la creazione. Questo configurer&agrave; gli slot disponibili
   nell'intervallo di tempo tra Inizio e Fine</p>

<h3>Impostazione di una risorsa</h3>

<p>Puoi vedere e gestire le risorse dall'opzione di menu "Risorse". Qui puoi cambiare gli attributi e la configurazione 
   di utilizzo di una risorsa.
</p>

<p>Una risorsa di phpScheduleIt pu&ograve; essere qualsiasi cosa tu pensi si possa prenotare, come Stanze o Equipaggiamenti. Ogni risorsa
   deve essere assegnata ad una Schedulazione per essere prenotabile. La risorsa assumer&agrave; il layout di prenotazione della schedulazione
   di cui fa parte.</p>

<p>L'impostazione di un periodo minimo di prenotazione eviter&agrave; prenotazioni pi&ugrave; brevi del minimo impostato. Il parametro
   di default &egrave; "nessun minimo".</p>

<p>L'impostazione di un periodo massimo di prenotazione eviter&agrave; prenotazioni pi&ugrave; lunghe del massimo impostato. Il parametro
   di default &egrave; "nessun massimo".</p>

<p>L'impostazione di "Necessaria Approvazione" per una risorsa, metter&agrave; le prenotazioni in uno stato di attesa finch&egrave; non verranno
approvate. L'impostazione di default &egrave; "Nessuna Approvazione Necessaria"</p>

<p>L'impostazione di "Concessione automatica permessi" garantir&agrave; a tutti i nuovi utenti i permessi di accesso alla
risorsa gi&agrave; al momento della registrazione. L'impostazione di default &egrave; "Concessione automatica permessi".</p>

<p>E' possibile impostare un tempo di notifica in modo che una risorsa debba essere prenotata con un certo numero di giorni / ore / minuti
di anticipo. Per esempio, se si desidera prenotare alle 10.30 di Lunedi e la risorsa richiede la notifica 1 giorno,
non la si potr&agrave; prenotare dopo le ore 10.30 di Domenica. L'impostazione predefinita &egrave; che le prenotazioni possono essere effettuate fino
fino al momento attuale.</p>

<p>E' possibile impedire che le risorse vengano prenotato troppo lontano nel futuro impostando un tempo massimo di
giorni / ore / minuti. Per esempio, se sono le 10.30 di Lunedi e il tempo imostato come limite massimo di termine prenotazione &eacute di 1 giorno,
la risorsa non potr&agrave; essere prenotata fino ad oltre le 10.30 di Marted&igrave;. L'impostazione predefinita &egrave; nessun limite.</p>

<p>E' possibile impostare una capacit&agrave; di persone per una risorsa. Ad esempio, in una sala per conferenze si pu&ograve; impostare il massimo numero di persone che
pu&ograve; contenere. L'impostazione della capacit&agrave; di una risorsa limiter&agrave; il numeri di partecipanti invitabili contemporaneament,
escludendo l'organizzatore. L'impostazione predefinita &egrave; che le risorse hanno capacit&agrave; illimitata.</p>

<p>Gli amministratori dell' applicazione sono esenti da vincoli di utilizzo.</p>

<h3>Immagine Risorsa</h3>

<p>Puoi impostare un'immagine che verr&agrave; visualizzata nei dettagli della pagina di prenotazione.
   Occorre che php_gd2 sia installato e abilitato nel file php.ini . <a href="http://www.php.net/manual/en/book.image.php">Maggiori Informazion</a></p>

<h3>Impostazione Accessori</h3>

<p>Gli Accessori possono essere vistic ome oggetti usati durante una prenotazione. Ad esempio un proiettore o delle sedie in una
	sala riunioni.</p>

<p>Gli Accessori possono essere visualizzati e gestiti dalla voce "Accessori", nel menu "Risorse".</p>

<h3>Impostazioni Quote</h3>

<p>Le quote permettono di impostare limiti di utilizzo delle risorse. La gestione delle quote in phpScheduleIt &egrave;
molto flessibile, permette di impostare limiti basati sulla lunghezza della prenotazione e sul numero di prenotazioni. 
Inoltre, i limiti si possono combinare. Ad esempio, se per una risorsa esiste una quota limite di 5 ore al giorno e un altro limite di
4 prenotazioni al giorno, un utente potrebbe fare una prenotazione lunga 4 ore, ma non potrebbe fare 3 prenotazioni
di due ore ciascuna.</p>

<p>Gli Amministratori dell'applicazione sono esenti dai limiti di Quota.</p>

<h3>Impostazione annunci</h3>

<p>Gli annunci sono un modo molto semplice per informare gli utenti di phpScheduleIt. Dalla voce di menu Annunci
&egrave; possibile visualizzare e gestire gli annunci da mostrare sul cruscotto utenti. Un annuncio pu&ograve; essere configurato
con una data di inizio e di fine opzionale. E' disponibile anche un livello di priorit&agrave;, anch'esso opzionale, per ordinare gli annunci da 1
a 10.</p>

<p>Nel testo dell'annuncio si pu&ograve; utilizzare codifica HTML. Questo permette di inserire link o immagini.</p>

<h3>Impostazione Gruppi</h3>

<p>I Gruppi, in phpScheduleIt permettono di organizzare gli utenti, gestire i permessi di accesso alle risorse e definire ruoli all'interno
  dell'applicazione.</p>

<h3>Ruoli</h3>

<p>Il Ruolo da ad un gruppo di utenti l'autorizzazione ad eseguire certe azioni.</p>

<p>Gli utenti che appartengono ad un gruppo al quale &eacute stato dato il ruolo di Amministratori di Applicazione sono abilitati a tutti
i privilegi amministrativi. Questo ruolo ha praticamente zero restrizioni nelle prenotazioni delle risorse. Essi possono gestire tutti gli
aspetto della applicazione</p>

<p>Gli utenti che appartengono ad un gruppo al quale &egrave; stato dato il ruolo di Amministratore di Gruppo sono in grado di fare prenotazioni per altri
e gestire gli utenti di quel gruppo.</p>

<h3>Visualizzare e gestire le prenotazioni</h3>

<p>E' possibile visualizzare e gestire le prenotazioni dalla voce di menu prenotazioni. Per impostazione predefinita si vedranno gli ultimi 7 giorni e i
prossimi 7 giorni di prenotazioni. La visualizzazione pu&ograve; essere filtrata in maniera pi&ugrave; o meno granulare a seconda di ci&ograve; che si st&agrave; cercando.
E' inoltre possibile esportare l'elenco delle prenotazioni filtrate in formato CSV per eventuali successivi report.</p>

<h3>Approvazione prenotazioni</h3>

<p>Dagli strumenti di amministrazione prenotazioni, si potranno visualizzare e approvare le prenotazioni in corso. Verranno evidenziate
chiaramente le sospeso evidenziato.</p>

<h3>Visualizzaizone e Gestione Utenti</h3>

<p>E' possibile aggiungere, visualizzare e gestire tutti gli Utenti Registrati dalla voce di menu Utenti. 
   Questo strumento consente di modificare i permessi di accesso alle risorse per il singolo Utente, disattivare o cancellare accounts,
   resettare password, e modificare i dettagli degli utenti.
	 E' possibile anche aggiungere nuovi utenti a phpScheduleIt, prestazione particolarmente utile se l'autoregistrazione &eacute impostata a NO.</p>

<h2>Configurazione</h2>

<p>Alcune funzionalit&agrave; di phpScheduleIt possono essere controllate editando il file config.</p>

<p class="setting"><span>server.timezone</span>Indica il fuso orario del server sul quale &eacute ospitato il phpScheduleIt. 
  Si pu&ograve; visualizzare il fuso orario corrente dalla voce di menu Impostazioni Server. I possibili valori si possono trovare qui:
	http://php.net/manual/en/timezones.php</p>

<p class="setting"><span>allow.self.registration</span>Se gli utenti hanno il permesso di registrarsi.</p>

<p class="setting"><span>admin.email</span>Indirizzo email dell'amministratore principale dell'applicazione.</p>

<p class="setting"><span>default.page.size</span>Il numero di righe per ogni pagina che visualizza una lista di data</p>

<p class="setting"><span>enable.email</span>Se possono essere inviate email al di fuori di phpScheduleIt</p>

<p class="setting"><span>default.language</span>Lingua impostata per Default per tutti gli utenti. Si pu&ograve; impostare qualsiasi 
  lingua contenuta nella cartella 'lang' di phpScheduleIt</p>

<p class="setting"><span>script.url</span>L'indirizzo URL pubblico completo della cartella root dell'istanza di phpScheduleIt. 
  Questo dovrebbe essere la directory Web che contiene i file come bookings.php e calendar.php</p>

<p class="setting"><span>password.pattern</span>Una espressione regolare per far rispettare la complessit&agrave; della password dell'account utente durante la
registrazione</p>

<p class="setting"><span>show.inaccessible.resources</span>Se le risorse non accessibili all'utente che si collega devono comunque essere visualizzate</p>

<p class="setting"><span>notify.created</span>Se gli amministratori devono ricevere una email quando viene fatta una nuova prenotazione</p>

<p class="setting"><span>image.upload.directory</span>La cartella fisica relativa, rispetto alla cartella di phpScheduleIt,
   dove memorizzare le immagini. Questa cartella deve essere avere i permessi di scrittura.</p>

<p class="setting"><span>image.upload.url</span>L'indirizzo URL relativo rispetto al parametro script.url dove le immagini possono essere visualizzate</p>

<p class="setting"><span>cache.templates</span>Impostazione per stabilire se i modelli vengono memorizzati nella cache. Si consiglia di impostare questo valore a
vero, purch&eacute; tpl_c abbia i permessi di scrittura</p>

<p class="setting"><span>registration.captcha.enabled</span>Se deve essere abilitata l'immagine di sicurezza captcha durante la registrazioneimage security is enabled 
  durante la registrazione degli account</p>

<p class="setting"><span>inactivity.timeout</span>Numero di minuti prima che l'utenta venga automaticamente disconnesso</p>

<p class="setting"><span>['database']['type']</span>Qualsiasi tipo di PEAR::MDB2 supportato</p>

<p class="setting"><span>['database']['user']</span>L'utente con abilitazione di accesso al Database configurato</p>

<p class="setting"><span>['database']['password']</span>Password per l'utente del database</p>

<p class="setting"><span>['database']['hostspec']</span>Named pipe o URL dell'host del Database</p>

<p class="setting"><span>['database']['name']</span>Nome del database di phpScheduleIt</p>

<p class="setting"><span>['phpmailer']['mailer']</span>Libreria email PHP. Le opzioni possibili sono mail, smtp, sendmail o qmail</p>

<h2>Plugins</h2>

<p>I seguenti componenti sono inseribili come plugin:</p>

<ul>
	<li>Authentication - Chi ha il permesso di connettersi</li>
	<li>Authorization - Quello che un utente pu&ograve; fare quando &egrave; connesso</li>
	<li>Permission - A quali risorse un utente ha accesso</li>
	<li>Pre Reservation - Cosa succede prima che una prenotazione venga memorizzata</li>
	<li>Post Reservation - Cosa succede dopo che una prenotazione &eacute stata fatta</li>
</ul>

<p>
	Per abilitare un plugin, impostare il valore del parametro di configurazione uguale al nome della cartella del plugin. Per esempio, per abilitare
	l'autenticazione LDAP, impostare
	$conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

<p>I plugin possono avere il proprio file di configurazione. Per LDAP, rinominare o copiare
	/plugins/Authentication/Ldap/Ldap.config.dist in /plugins/Authentication/Ldap/Ldap.config e editare tutti i valori che
	sono applicabili all'ambiente in cui &egrave; inserito phpScheduleIt.</p>

<h3>Installare i Plugins</h3>

<p>Per installare un nuovo plugin, copiare la cartella dentro una delle cartelle Authentication, Authorization e Permission. 
   In seguito modificare $conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] o
	$conf['settings']['plugins']['Permission'] nel file config.php inserendo il nome della cartella del plugin.</p>

{include file="support-and-credits.tpl"}
</div>

{include file='globalfooter.tpl'}