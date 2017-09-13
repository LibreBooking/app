{*
Copyright 2011-2016 Nick Korbel

Translation: 2017 Daniele Cordella <kordan@mclink.it>

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
<h1 xmlns="http://www.w3.org/1999/html">Amministrazione di Booked Scheduler</h1>

<div id="help">
<h2>Amministrazione</h2>

<p>Se si ricopre il ruolo di Amministratore dell'applciazione si pu&ograve; accedere al menu "Gestione Applicazione". Tutte le attivit&agrave; di amministrazione si avviano da questo menu.</p>

<h3>Configurazione dei calendari</h3>

<p>All'installazione di Booked Scheduler, un calendario di default viene generato automaticamente. Dal menu "Prenotazioni" &egrave; possibile accedere alla modifica di tutte le caratteristiche delle prenotazioni.</p>

<p>Ogni calendario deve avere un layout definito. Cliccando il link "Modifica Layout" verr&agrave; mostrato l'editor di layout. Qui si possono creare e cambiare le caselle del calendario (time slot) disponibili e quelle negate alle prenotazioni. Non ci sono limiti al numero delle caselle dei calendari, ma &egrave; necessario definire un valore temporale per ogni casella fino a ricoprire l'intero arco delle 24 ore del giorno. &Egrave; possibile anche definire un'etichetta per ogni casella, se lo si desidera.</p>

<p>Una casella del calendario senza etichetta &egrave; formattata come in questo esempio: 10:25 - 16:50</p>

<p>Una casella con etichetta pu&ograve; essere apprire come in questo esempio: 10:25 - 16:50 Periodo 4</p>

<p>Sotto la finestra di configurazione delle caselle c'&egrave; uno strumento per la creazione veloce delle stesse. Questo configura le caselle disponibili in un dato intervallo di tempo.</p>

<h3>Configurazione delle risorse</h3>

<p>Le risorse definite si possono accedere e gestire dal menu "Risorse". In questo modo &egrave; possibile modificare gli attributi e la modalit&agrave; di utilizzo di una risorsa.</p>

<p>Una risorsa di Booked Scheduler pu&ograve; essere qualsiasi cosa si possa prenotare come, ad esempio, un'aula o un equipaggiamento. Ogni risorsa deve essere assegnata ad un calendario per essere prenotabile. La risorsa eredita il layout di prenotazione del calendario al quale appartiene.</p>

<p>Definire un periodo minimo di prenotazione evita prenotazioni pi&ugrave; brevi del minimo impostato. Il parametro di default &egrave; "nessun minimo".</p>

<p>Definire un periodo massimo di prenotazione evita prenotazioni pi&ugrave; lunghe del massimo impostato. Il parametro di default &egrave; "nessun massimo".</p>

<p>Definire la "Necessaria approvazione" per una risorsa, mette le prenotazione in uno stato di attesa fino al momento dell'approvazione. L'impostazione di default &egrave; "Nessuna approvazione necessaria"</p>

<p>L'impostazione di "Concessione automatica permessi" garantisce a tutti i nuovi utenti i permessi di accesso alla risorsa gi&agrave; al momento della registrazione. L'impostazione di default &egrave; "Concessione automatica permessi".</p>

<p>&Egrave; possibile impostare un tempo di notifica in modo che una risorsa debba essere prenotata con un certo anticipo. Per esempio, se si desidera prenotare un risorsa per le 10.30 di Lunedi e la risorsa richiede un tempo di notifica di 1 giorno, non &egrave; possibile prenotarla dopo le ore 10.30 di Domenica. L'impostazione predefinita &egrave; che le prenotazioni possono essere effettuate sempre.</p>

<p>&Egrave; possibile impedire che le risorse vengano prenotate troppo lontano nel tempo impostando un limite temporale massimo. Per esempio, se sono le 10.30 di Lunedi e il tempo imostato come limite massimo di termine prenotazione &egrave; di 1 giorno, non &egrave; possibile eseguire prenotazioni per date successive alle 10.30 di Marted&igrave;. L'impostazione predefinita &egrave; "Nessun limite".</p>

<p>&Egrave; possibile impostare una capienza per una risorsa. Ad esempio, per una sala conferenze &egrave; possibile definire il massimo numero di persone che pu&ograve; contenere. L'impostazione della capienza di una risorsa limita il numero massimo di partecipanti che possono essere coinvolti o invitati escludendo l'organizzatore. L'impostazione predefinita &egrave; che le risorse hanno una capacit&agrave; illimitata.</p>

<p>Gli amministratori dell'applicazione sono esentati dai vincoli di utilizzo.</p>

<h3>Immagine delle risorsa</h3>

<p>&Egrave; possibile associare una immagine alle risorse in modo he venga mostrata fra i dettagli della pagina di prenotazione. Occorre che php_gd2 sia installato e abilitato nel file php.ini . <a href="http://www.php.net/manual/en/book.image.php">Maggiori Informazioni</a></p>

<h3>Configurazione accessori</h3>

<p>Gli accessori possono essere visti come oggetti usati durante una prenotazione. Ad esempio un proiettore o delle sedie in una sala riunioni.</p>

<p>Gli accessori possono essere visualizzati e gestiti dalla voce "Accessori" del menu "Risorse". Definire la quantit&agrave; disponibile di ogni accessorio evita che gli stessi vengano richiesti oltre la loro effettiva disponibilit&agrave;.</p>

<h3>Configurazione delle quote</h3>

<p>Le quote permettono di impostare limiti di utilizzo delle risorse. La gestione delle quote in Booked Scheduler &egrave; molto flessibile e permette di impostare limiti basati sia sulla lunghezza della prenotazione che sul numero di prenotazioni. Inoltre, i limiti si possono combinare. Ad esempio, se per una risorsa esiste una quota limite di 5 ore al giorno e un altro limite di 4 prenotazioni al giorno, un utente potrebbe fare una prenotazione lunga 4 ore, ma non pu&ograve; fare 3 prenotazioni di due ore ciascuna. In questo modo si possono definire limiti per le risorse che si adattano molto fedelmente alle realt&agrave; locali.</p>

<p>Gli Amministratori dell'applicazione sono esentati dai limiti di quota.</p>

<h3>Configurazione degli avvisi</h3>

<p>Gli avvisi sono un modo molto semplice per informare gli utenti di Booked Scheduler. Dalla voce di menu "Annunci" &egrave; possibile visualizzare e gestire gli annunci da mostrare sul "Cruscotto" degli utenti. Un annuncio pu&ograve; essere configurato con una eventuale data di inizio e fine. &Egrave; disponibile anche un livello di priorit&agrave;, anch'esso opzionale, per ordinare gli annunci da 1 a 10.</p>

<p>Nel testo dell'annuncio &egrave; possibile utilizzare il codice HTML. Questo permette di inserire link o immagini.</p>

<h3>Configurazione dei gruppi</h3>

<p>I Gruppi, in Booked Scheduler permettono di organizzare gli utenti, gestire i permessi di accesso alle risorse e definire ruoli all'interno dell'applicazione.</p>

<h3>Ruoli</h3>

<p>I ruoli assegnano agli utenti dei gruppi l'autorizzazione ad eseguire certe azioni. I ruoli possono essere: "Amministratori di applicazione", "Amministratori di gruppo", "Amministratori di risorsa", "Amministratori di calendario"</p>

<p>Amministratori di applicazione: gli utenti che appartengono a questo gruppo godono di tutti i privilegi amministrativi. Questo ruolo non subisce, praticamente, nessuna limitazione nella prenotazione delle risorse. Essi possono gestire tutti gli aspetti della applicazione.</p>

<p>Amministratori di gruppo: gli utenti che appartengono a questo gruppo possono fare prenotazioni per conto di altri e gestire gli utenti del loro gruppo.</p>

<p>Amministratori di risorsa: gli utenti che appartengono a questo gruppo gestiscono le loro risorse e approvano le relative prenotazioni.</p>

<p>Amministratori di calendario: gli utenti che appartengono a questo gruppo gestiscono i loro calendari e le risorse associate.</p>

<h3>Visualizzare e gestire le prenotazioni</h3>

<p>&Egrave; possibile visualizzare e gestire le prenotazioni dalla voce "Prenotazioni" del menu "Gestione applicazione". Per impostazione predefinita si vedranno gli ultimi 7 giorni e i prossimi 7 giorni di prenotazioni. La visualizzazione pu&ograve; essere filtrata in maniera pi&ugrave; o meno granulare a seconda di ci&ograve; che si st&agrave; cercando. &Egrave; inoltre possibile esportare l'elenco delle prenotazioni filtrate in formato CSV per eventuali successivi report.</p>

<h3>Approvazione prenotazioni</h3>

<p>Ponendo $conf['settings']['reservation']['updates.require.approval'] a "true" ogni richiesta di prenotazione viene messa in attesa e deve essere confermata prima di diventare effettiva. Dagli strumenti di amministrazione, si possono visualizzare e approvare le prenotazioni in attesa. Le prenotazioni in attesa sono chiaramente evidenziate.</p>

<h3>Visualizzazione e gestione degli utenti</h3>

<p>&Egrave; possibile aggiungere, visualizzare e gestire tutti gli utenti registrati dalla voce "Utenti" del menu "Gestione applicazione". Questo strumento consente di modificare i permessi di accesso alle risorse per il singolo utente, disattivare o cancellare accounts, ripristinare password e modificare i dettagli degli utenti. &Egrave; possibile anche aggiungere nuovi utenti a Booked Scheduler, cosa assolutamente necessaria se l'autoregistrazione &egrave; negata.</p>

<h3>Reportistica</h3>

<p>I reports sono accessibili ad ogni tipo di amministratore (di applicazione, di gruppo, di risorsa o di calendario). Un amministratore autenticato pu&ograve; accedere ai report dal menu omonimo. Booked Scheduler nasce con un corredo base di report che possono essere visualizzati sotto forma di lista o di grafico, esportati in formato CSV o stampati. Inoltre, &egrave; possibile creare dei report personalizzati dalla voce di menu "Crea nuovo report". Anche i report personalizzati possono essere visualizzati sotto forma di lista o di grafico, esportati in formato CSV o stampati. Ovviamente, i report personalizzati possono essere salvati ed utilizzati nuovamente attraverso la voce di menu "Report salvati". I report salvati possono anche essere inviati per posta elettronica.</p>

<h3>Promemoria prenotazioni</h3>

<p>Gli utenti possono chiedere che un promemoria gli venga inviato per posta elettronica prima dell'inizio delle prenotazioni. Affinch&eacute; ci&ograve; sia possibile, $conf['settings']['enable.email'] e $conf['settings']['reservation']['enable.reminders'] devono entrambi essere posti a "true". Inoltre, un'operazione pianificata (cron) deve essere configurata sul server per eseguire /Booked Scheduler/Jobs/sendreminders.php</p>

<p>Su linux, generalmente, si attiva un processo di cron. Il comando da eseguire &egrave; <span class="note">php</span> seguito dal percorso assoluto: Booked Scheduler/Jobs/sendreminders.php. Il percorso assoluto di sendreminders.php su questo particolare server &egrave; <span class="note">{$RemindersPath}</span>
</p>

<p>Un esempio di configurazione potrebbe essere: <span class="note">* * * * * php {$RemindersPath}</span></p>

<p>Se si ha l'accesso all'applicativo "cPanel" sul server che ospita l'installazione di Booked Scheduler, la documentazione: <a
href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">creazione
un lavoro cron in cPanel</a> &egrave; lineare sia adoperando la voce "Every mimute" dal menu "Common Settings" che digitando * per i minuti, le ore, i giorni, i mesi e il giorno della settmana.</p>

<p>Su Windows, <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">si possono usare le operazioni pianificate</a>. Le operazioni pianificate devono essere configurate per essere eseguite ogni minuto. Il comando da eseguire &egrave; <span class="note">php</span> seguito dal percorso assoluto: Booked Scheduler/Jobs/sendreminders.php</p>

<h2>Configurazione</h2>

<p>Alcune funzionalit&agrave; di Booked Scheduler possono essere controllate solamente modificando il file config.</p>

<p class="setting"><span>$conf['settings']['app.title']</span>Il nome dell'applicazione</p>

<p class="setting"><span>$conf['settings']['server.timezone']</span>Indica il fuso orario del server sul quale &egrave; ospitato il Booked Scheduler. Si pu&ograve; visualizzare il fuso orario corrente dalla voce di menu "Impostazioni Server". I possibili valori si possono trovare qui: <a href="http://php.net/manual/en/timezones.php target="_blank">http://php.net/manual/en/timezones.php</a></p>

<p class="setting"><span>$conf['settings']['allow.self.registration']</span>Se, o meno, gli utenti hanno il permesso di auto registrarsi.</p>

<p class="setting"><span>$conf['settings']['admin.email']</span>Indirizzo di posta elettronica dell'amministratore principale dell'applicazione.</p>

<p class="setting"><span>$conf['settings']['admin.email.name']</span>Il nome da utilizzare nel campo "Mittente" nelle comunicazioni elettroniche inviate dall'applicativo.</p>

<p class="setting"><span>$conf['settings']['default.page.size']</span>Il numero di righe iniziali di ogni pagina che visualizza una lista di dati.</p>

<p class="setting"><span>$conf['settings']['enable.email']</span>Se Booked Scheduler &egrave; abilitato, o meno, ad inviare email.</p>

<p class="setting"><span>$conf['settings']['default.language']</span>Lingua impostata per default per tutti gli utenti. Si pu&ograve; impostare qualsiasi lingua contenuta nella cartella 'lang' di Booked Scheduler.</p>

<p class="setting"><span>$conf['settings']['script.url']</span>L'URL pubblico assoluto della cartella di Booked Scheduler sul server. Questo dovrebbe essere la directory Web che contiene i file come bookings.php e calendar.php. Se questo indirizzo viene lasciato senza un protocollo specificato allora il protocollo (http vs https) viene rilevato automaticamente.</p>

<p class="setting"><span>$conf['settings']['image.upload.directory']</span>L'indirizzo della cartella nella quale archiviare le immagini delle risorse. Questa cartella deve avere i permessi di scrittura (755 &egrave; suggerito). Questo indirizzo pu&ograve; essere sia relativo alla cartella di Booked Scheduler, sia assoluto.</p>

<p class="setting"><span>$conf['settings']['image.upload.url']</span>L'URL dal quale le immagini caricate sono visualizzate. Questo indirizzo pu&ograve; essere sia relativo a $conf['settings']['script.url'], sia assoluto.</p>

<p class="setting"><span>$conf['settings']['cache.templates']</span>Se, o meno, i modelli vengono memorizzati nella cache. Si consiglia di impostare questo valore a vero, purch&eacute; tpl_c abbia i permessi di scrittura.</p>

<p class="setting"><span>$conf['settings']['use.local.jquery']</span>Se, o meno, una versione locale di jQuery deve essere usata. Qualora questo parametrro venga impostato a false i servizi di jQuery saranno acquisiti dal Google CDN. Si racomanda di porre questo parametro a false per aumentare le performance ed ottimizzare l'utilizzo di banda. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>Se, o meno, deve essere introdotta l'immagine di sicurezza captcha durante la registrazione degli account.</p>

<p class="setting"><span>$conf['settings']['registration.require.email.activation']</span>Se, o meno, gli utenti devono confermare il loro account per posta elettronica prima di potersi collegare.</p>

<p class="setting"><span>$conf['settings']['registration.auto.subscribe.email']</span>Se, o meno, gli utenti sono automaticamente coinvolti nel flusso di comunicazioni elettroniche una volta registrati.</p>

<p class="setting"><span>$conf['settings']['registration.notify.admin']</span>Se, o meno, la registrazione di un nuovo utente &egrave; seguita da una mail all'amministratore.</p>

<p class="setting"><span>$conf['settings']['inactivity.timeout']</span>Numero di minuti prima che l'utenta venga automaticamente disconnesso. Si lasci vuoto questo paramero se non si desidera che l'utente non venga mai disconnesso.</p>

<p class="setting"><span>$conf['settings']['name.format']</span>Il formato con il quale i nomi degli utenti &egrave; mostrato. Il default &egrave; {literal}'{first} {last}'{/literal}.</p>

<p class="setting"><span>$conf['settings']['css.extension.file']</span>L'URL assoluto o relativo di fogi di stile addizionali. Questi fogli di stile possono essere utilizzati per apportare modifiche secondarie ai fogli si stile predefiniti, cos&igrave; come per definire un coordinato grafico completamente nuovo. Si lasci questo parametro vuoto se non si intendono modificare i fogli di stile di Booked Scheduler.</p>

<p class="setting"><span>$conf['settings']['disable.password.reset']</span>Se, o meno, la funzionalit&agrave; di ripristino della password deve essere abilitata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['home.url']</span>L'indirizzo web al quale l'utente verr&agrave; indirizzato attraverso il logo dell'applicazione. Il default &egrave; la pagina scelta dall'utente come default.</p>

<p class="setting"><span>$conf['settings']['logout.url']</span>L'indirizzo web al quale l'utente verr&agrave; indirizzato all'uscita da Booked Scheduler. Il default &egrave; la pagina di login.</p>

<p class="setting"><span>$conf['settings']['schedule']['use.per.user.colors']</span>Se usare, o meno, un colore specifico (prescelto dall'amministratore) per indicare le prenotazioni di ogni utente. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>Se, o meno, le risorse non accessibili all'utente devono comunque essere visualizzate</p>

<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>Il formato del testo da mostrare nelle caselle prenotate del calendario. I termini ammessi sono: {literal}{name}, {title}, {description}, {email}, {phone}, {organization}, {position}{/literal}. Una qualunque combinazione di termini &egrave; ammessa. Si lasci questo parametro vuoto se non si intendono etichettare le caselle.</p>

<p class="setting"><span>$conf['settings']['schedule']['hide.blocked.periods']</span>Se, o meno, la durata della prenotazione deve essere nascosta dalla pagina delle prenotazioni. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['ics']['require.login']</span>Se, o meno, un utente si deve autenticare per aggiungere una prenotazione ad Outlook.</p>

<p class="setting"><span>$conf['settings']['ics']['subscription.key']</span>Per consentire le sottoscrizioni ad un calendario si scelga per queto parametro una password difficile da indovinare. Se questo parametro &egrave; lasciato vuoto le sottoscrizioni saranno disabilitate.</p>

<p class="setting"><span>$conf['settings']['ics']['import']</span>Se, o meno, &egrave; abilitata l'importazione da iCal.</p>

<p class="setting"><span>$conf['settings']['ics']['import.key']</span>La chiave per le importazioni delle prenotazioni in iCal. Si consiglia di non lasciare vuoto questo parametro se l'importazione &egrave; abilitata</p>

<p class="setting"><span>$conf['settings']['privacy']['view.schedules']</span>Se, o meno, un utente autenticato pu&ograve; vedere i calendari. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['privacy']['view.reservations']</span>Se, o meno, un utente autenticato pu&ograve; vedere le prenotazioni. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['privacy']['hide.user.details']</span>Se, o meno, i dettagli del profilo utente devono essere mostrati ai non amministratori.</p>

<p class="setting"><span>$conf['settings']['privacy']['hide.reservation.details']</span>Se, o meno, i dettagli delle prenotazioni utente devono essere mostrati ai non amministratori.</p>

<p class="setting"><span>$conf['settings']['reservation']['start.time.constraint']</span>Quando le prenotazioni possono essere create o modificate. Le opzioni sono: "future", "current", "none". "future" significa che le prenotazioni possono essere create o modificate solo se appartengono al futuro. "current" significa che le prenotazioni possono essere create o modificate al massimo se sono in corso e, comunque, non appartengono al passato. "none" significa che non ci sono vincoli al momento in cui una prenotazione pu&ograve; essere creata o modificata. Il default &egrave;: "future".</p>

<p class="setting"><span>$conf['settings']['reservation']['updates.require.approval']</span>Se, o meno, le modifiche ad una prenotazione gi&agrave; approvata richiedono una nuova approvazione. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.participation']</span>Se, o meno, la sezione per la partecipazione e l'invito dei partecipanti deve essere rimossa. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.recurrence']</span>Se, o meno, le prenotazioni periodiche devono essere precluse ai non amministratori. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation']['enable.reminders']</span>Se, o meno, i promemoria sono abilitati. Questo richiede l'abiltazione dell'email e la configurazione delle operazioni pianificate. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>Se, o meno, inviare una email a tutti gli amministratori di risorsa quando una prenotazione viene aggiunta. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>Se, o meno, inviare una email a tutti gli amministratori di risorsa quando una prenotazione viene aggiornata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>Se, o meno, inviare una email a tutti gli amministratori di risorsa quando una prenotazione viene cancellata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.approval']</span>Se, o meno, inviare una email a tutti gli amministratori di risorsa quando una prenotazione viene approvata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>Se, o meno, inviare una email a tutti gli amministratori dell'applicazione quando una prenotazione viene creata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>Se, o meno, inviare una email a tutti gli amministratori dell'applicazione quando una prenotazione viene aggiornata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>Se, o meno, inviare una email a tutti gli amministratori dell'applicazione quando una prenotazione viene cancellata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.approval']</span>Se, o meno, inviare una email a tutti gli amministratori dell'applicazione quando una prenotazione viene approvata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>Se, o meno, inviare una email a tutti gli amministratori di gruppo quando una prenotazione viene creata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>Se, o meno, inviare una email a tutti gli amministratori di gruppo quando una prenotazione viene aggiornata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>Se, o meno, inviare una email a tutti gli amministratori di gruppo quando una prenotazione viene cancellata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.approval']</span>Se, o meno, inviare una email a tutti gli amministratori di gruppo quando una prenotazione viene approvata. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['uploads']['enable.reservation.attachments']</span>Se, o meno, agli utenti è consentito allegare un documento alle prenotazioni. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.path']</span>L'indirizzo della cartella nella quale archiviare i documenti allegati alle prenotazioni. Questa cartella deve avere i permessi di scrittura (755 &egrave; suggerito). Questo indirizzo pu&ograve; essere sia relativo alla cartella di Booked Scheduler, sia assoluto. Il default &egrave;: "uploads/reservation"</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>Lista separata da virgole delle estensioni consentite per i documenti allegati alle prenotazioni. Lasciare questo parametro vuoto significa consentire qualunque formato. (non raccomandato).</p>

<p class="setting"><span>$conf['settings']['database']['type']</span>Qualsiasi tipo di PEAR::MDB2 supportato</p>

<p class="setting"><span>$conf['settings']['database']['user']</span>L'utente con abilitazione di accesso al Database configurato</p>

<p class="setting"><span>$conf['settings']['database']['password']</span>Password per l'utente del database</p>

<p class="setting"><span>$conf['settings']['database']['hostspec']</span>Named pipe o URL dell'host del Database</p>

<p class="setting"><span>$conf['settings']['database']['name']</span>Nome del database di Booked Scheduler</p>

<p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>Libreria email PHP. Le opzioni possibili sono 'mail', 'smtp', 'sendmail' o 'qmail'</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>SMTP host, se si intende fare uso del protocollo SMTP</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.port']</span>Porta SMTP. Solitamente: 25</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.secure']</span>Sicurezza SMTP. Le opzioni sono '', 'ssl' o 'tls'</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.auth']</span>Se, o meno, il protocollo SMTP richiede l'autenticazione. Le opzioni sono: 'true' o 'false'.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.username']</span>Nome utente per il protocollo SMTP</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.password']</span>Password utente per il protocollo SMTP</p>

<p class="setting"><span>$conf['settings']['phpmailer']['sendmail.path']</span>Path di sendmail, se si intende fare uso di sendmail</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.debug']</span>Se, o meno, attivare le notifiche di debug per le mail</p>

<p class="setting"><span>$conf['settings']['plugins']['Authentication']</span>Nome della plugin di autenticazione da utilizzare. Si veda: "Plugins" più avanti.</p>

<p class="setting"><span>$conf['settings']['plugins']['Authorization']</span>Nome della plugin di autorizzazione da utilizzare. Si veda: "Plugins" più avanti.</p>

<p class="setting"><span>$conf['settings']['plugins']['Permission']</span>Nome della plugin di permessi da utilizzare. Si veda: "Plugins" più avanti.</p>

<p class="setting"><span>$conf['settings']['plugins']['PreReservation']</span>Nome della plugin di pre-prenotazione da utilizzare. Si veda: "Plugins" più avanti.</p>

<p class="setting"><span>$conf['settings']['plugins']['PostReservation']</span>Nome della plugin di post-prenotazione da utilizzare. Si veda: "Plugins" più avanti.</p>

<p class="setting"><span>$conf['settings']['install.password']</span>Se si intende eseguire una installazione automatica o un aggiornamento, questa password sarà richiesta. Si definisca il parametro in modo che sia difficile da indovinare per l'utente malintenzionato.</p>

<p class="setting"><span>$conf['settings']['pages']['enable.configuration']</span>Se, o meno, la pagina di gestione della configurazione deve essere accessibile agli amministratori dell'applicazione. Le opzioni sono: 'true' o 'false'.</p>

<p class="setting"><span>$conf['settings']['api']['enabled']</span>Se, o meno, le API di RESTful di Booked Scheduler devono essere abilitate. Ulteriori informazioni sui prerequisiti per l'utilizzo delle API sono rintracciabili nel file readme_installation.html file. Le opzioni sono: 'true' o 'false'.</p>

<p class="setting"><span>$conf['settings']['recaptcha']['enabled']</span>Se, o meno, reCAPTCHA debba essere usato piuttosto che il captcha di booked. Le opzioni sono: 'true' o 'false'.</p>

<p class="setting"><span>$conf['settings']['recaptcha']['public.key']</span>La chiave pubblica del reCAPTCHA. Si crei un account su www.google.com/recaptcha per ottenere la chiave.</p>

<p class="setting"><span>$conf['settings']['recaptcha']['private.key']</span>La chiave privata del reCAPTCHA. Si crei un account su www.google.com/recaptcha per ottenere la chiave.</p>

<p class="setting"><span>$config['settings']['email']['default.from.address']</span>L'indirizzo di posta elettronica da usare come mittente delle email di booked. Se le mail di booked vengono categorizzate come spam si indichi in questo indirizzo di posta elettronica il proprio nome di dominio. Ad esempio: noreply@yourdomain.com. Questo non cambierà il campo nome "nome" o l'indirizzo "rispondi-a" delle mail.</p>

<p class="setting"><span>$conf['settings']['reports']['allow.all.users']</span>Se, o meno, gli utenti non amministratori potranno accedere alla reportistica sull'utilizzo del prodotto. Il default &egrave;: "false".</p>

<p class="setting"><span>$conf['settings']['password']['minimum.letters']</span>Il minimo numero di lettere richieste per la password. Il default &egrave; 6.</p>

<p class="setting"><span>$conf['settings']['password']['minimum.numbers']</span>Il minimo numero di cifre richieste per la password. Il default &egrave; 0.</p>

<p class="setting"><span>$conf['settings']['password']['upper.and.lower']</span>Se, o meno, la password utente richiede una combinazione di lettere in maiuscolo e minuscolo. Il default &egrave;: "false".</p>

<h2>Plugins</h2>

<p>Categorie di componenti personalizzabili tramite la creazione di plugin:</p>

<ul>
    <li>Authentication - Chi ha il permesso di connettersi</li>
    <li>Authorization - Cosa un utente pu&ograve; fare quando &egrave; connesso</li>
    <li>Permission - Quali risorse un utente pu&ograve; accedere</li>
    <li>Post Registration - Cosa succede dopo che una autenticazione &egrave; stata effettuata</li>
    <li>Post Reservation - Cosa succede dopo che una prenotazione &egrave; stata effettuata</li>
    <li>Pre Registration - Cosa succede prima che una autenticazione venga effettuata</li>
    <li>Pre Reservation - Cosa succede prima che una prenotazione venga effettuata</li>
</ul>

<p>Per abilitare un plugin, impostare il valore del parametro di configurazione uguale al nome della cartella del plugin. Per esempio, per abilitare l'autenticazione LDAP, impostare $conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

<p>I plugin possono avere il proprio file di configurazione. Per LDAP, rinominare o copiare /plugins/Authentication/Ldap/Ldap.config.dist in /plugins/Authentication/Ldap/Ldap.config e editare tutti i valori che sono applicabili all'ambiente in cui &egrave; inserito Booked Scheduler.</p>

<h3>Installare i Plugins</h3>

<p>Per installare un nuovo plugin, copiare la cartella dentro una delle cartelle Authentication, Authorization e Permission. In seguito modificare $conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] o $conf['settings']['plugins']['Permission'] nel file config.php inserendo il nome della cartella del plugin.</p>

<h2>Codici disponibili per le etichette</h2>

<p>I codici disponibili per le etichette delle prenotazioni sono: {literal}{name}, {title}, {description}, {email}, {phone}, {organization}, {position}, {startdate}, {enddate} {resourcename} {participants} {invitees}{/literal}. Gli attributi personalizzati possono essere aggiunti usando "att" seguito dall'ID dell'attributo. Per esempio: {literal}{att1}{/literal}. Si omettano i codici se non si desiderano le etichette. Una qualunque combinazione di codici è ammessa.</p>

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
