{*
Copyright 2011-2015 Nick Korbel

File ini adalah bagian dari phpShceduleIt.

Booked Scheduler adalah perangkat lunak gratis: Anda bisa
mendistribusikannya dan/atau memodifikasikannya di bawah ketentuan
GNU General Public License seperti yang diterbitkan oleh
Free Software Foundation, baik versi 3 dari Lisensi, atau
(dengan pilihan) versi apapun setelahnya.

Booked Scheduler didistribusikan dengan harapan akan berguna,
tapi TANPA JAMINAN; tanpa
Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; bahkan tanpa jaminan dari
PERDAGANGAN atau PENYESUAIAN UNTUK TUJUAN TERTENTU.
Lihat GNU General Public License untuk rincian lebih lanjut.

Anda seharusnya mendapatkan salinan dari GNU General Public License
bersamaan dengan Booked Scheduler. Jika tidak, lihat
<http://www.gnu.org/licenses/>.

*}
{include file='globalheader.tpl'}
<h1 xmlns="http://www.w3.org/1999/html">Booked Scheduler Administration</h1>

<div id="help">
<h2>Administration</h2>

<p>Jika Anda termasuk dalam Administrator Aplikasi maka Anda dapat malihat menu Manajemen Aplikasi. Semua tugas administratif bisa ditemukan di sini.</p>

<h3>Menyiapkan Jadwal</h3>

<p>Saat memasang Booked Scheduler, jadwal standar akan dibuat. Dari pilihan menu Jadwal Anda bisa melihat dan mengatur atribut dari jadwal yang ada.</p>

<p>Setiap jadwal harus diatur tampilannya. Kontrol ini mengatur ketersediaan resource pada jadwal. Mengklik tautan Ubah Tampilan akan membawa pada pengaturan tampilan. Di sini Anda bisa membuat dan merubah slot waktu yang tersedia pada reservasi dan memblokirnya dari reservasi. Tidak ada batasan pada slot waktu, tapi Anda harus memberikan waktu untuk semua 24 jam sehari, satu persatu. Juga, format waktu harus dalam 24 jam. Jika Anda inginkan, Anda juga dapat memberikan label tampilan untuk setiap slot atau semuanya.</p>

<p>Setiap slot tanpa label harus berformat seperti ini: 10:25 - 16:50</p>

<p>Setiap slot dengan label harus berformat seperti ini: 10:25 - 16:50 Jadwal Periode 4</p>

<p>Di bawah jendela konfigurasi slot terdapat pembuat slot otomatis. Ini akan mengatur slot yang tersedia berdasarkan jarak antara waktu mulai dan akhir.</p>

<h3>Menyiapkan Resources</h3>

<p>Anda bisa melihat dan mengatur resource dari pilihan menu Resource. Di sini Anda bisa mengubah atribut dan pengaturan penggunaan resource.</p>

<p>Resource dalam Booked Scheduler bisa apa saja untuk mengatur yang dapat dipesan, seperti ruangan atau peralatan. Setiap Resource harus ditetapkan ke jadwal agar dapat dipesan. Resource akan mengikuti tampilan dari jadwal yang digunakan.</p>

<p>Mengatur lama minimal reservasi akan membatasi booking yang lebih lama dari jumlah yang sudah diatur. Standarnya tanpa minimal.</p>

<p>Mengatur lama maksimal reservasi akan membatasi booking yang kurang dari jumlah yang sudah diatur. Standarnya tanpa maksimal.</p>

<p>Mengatur resource agar membutuhkan persetujuan akan membuat semua booking dari resource tersebut menjadi tertunda sampai disetujui. Standarnya tidak membutuhkan persutujuan.</p>

<p>Mengatur resource untuk otomatis memberikan izin terhadapnya akan memberikan kepada semua pengguna baru izin untuk mengakses resource ketika pendaftaran. Standarnya otomatos memberikan izin.</p>

<p>Anda membutuhkan lama waktu booking dengan mengatur resource untuk meminta sejumlah hari/jam/menit notifikasi. Sebagai contoh, jika waktu saat ini pukul 10:30 AM pada hari Senin dan resource membutuhkan 1 hari notifikasi, resource tidak dapat di booking sampai pukul 10:30 AM pada hari Minggu. Standarnya reservasi bisa dipesan sampai waktu saat ini.</p>

<p>Anda bisa membatasi resource dari booking yang terlalu lama di masa yang akan datang dengan membutuhkan maksimal notifikasi dari hari/jam/menit. Sebagai contoh, jika sekarang 10:30 hari Senin dan reservasi tidak bisa lebih dari 1 hari, resource tidak akan bisa di booking lebih dari 10:30 pada hari Selasa. Standarnya tidak ada maksimal.</p>

<p>Beberapa resource tidak memiliki cukup kapasitas. Sebagai contoh, beberapa ruang rapat hanya untuk 8 orang. Mengatur resource kapasitas akan membatasi jumlah partisipan pada satu waktu, termasuk penyelenggara. Standarnya resource tidak memiliki batasan kapasitas.</p>

<p>Administrator Aplikasi dikecualikan dari keterbatasan penggunaan.</p>

<h3>Gambar Resource</h3>

<p>Anda bisa mengatur gambar resource yang akan ditampilkan saat melihat rincian resource pada halaman reservasi. Membutuhkan php_gd2 yang terpasang dan diaktifkan pada file php.ini. <a href="http://www.php.net/manual/en/book.image.php">Untuk Lebih Jelas</a></p>

<h3>Menyiapkan Aksesoris</h3>

<p>Aksesoris bisa dianggap sebagai obyek yang digunakan selama reservasi. Contoh mungkin proyektor atau kursi di ruang konferensi.</p>

<p>Aksesoris dapat dilihat dan dikelola dari menu Aksesoris, di bawah menu Resources. Mengatur jumlah aksesori akan membatasi lebih dari sejumlah aksesori yang dapat dipesan pada suatu waktu.</p>

<h3>Menyiapkan Kuota</h3>

<p>Kuota membatasi reservasi yang dapat dipesan berdasarkan pengaturan batas. Sistem kuota di Booked Scheduler sangat fleksibel, memungkinkan Anda membuat batasan berdasarkan lamanya reservasi dan jumlah reservasi. Juga, membatasi kuota "yang menumpuk". Sebagai contoh jika kuota membatasi untuk 5 jam per hari dan kuota yang lain membatasi untuk 4 reservasi per hari, pengguna tidak akan dapat mereservasi selama 4 jam tapi diak bisa reservasi selama 3x2 jam. Hal ini memungkinkan kombinasi kuota yang kuat yang bisa dibuat.</p>

<p>Administrator Aplikasi dikecualikan dari keterbatasan penggunaan.</p>

<h3>Menyiapkan Pengumuman</h3>

<p>Pengumuman adalah cara mudah untuk menampilkan notifikasi kepada pengguna Booked Scheduler. Dari menu Pengumuman Anda bisa melihat dan mengatur pengumuman yang ditampilkan dalam dashboard pengguna. Sebuah pengumuman dapat dokinfigurasi dengan pilihan mulai dan akhir tanggal. Tambahan tingakat juga tersedia, yang akan mensortir pernumuman dari 1 sampai 10.</p>

<p>HTML bisa digunakan pada teks pengumuman. Akan memungkinkan untuk melekatkan tautan atau gambar dari mana saja di laman.</p>

<h3>Menyiapkan Grup</h3>

<p>Grup di Booked Scheduler mengatur pengguna, mengontrol izin akses resource dan menentukan peran yang berlaku pada aplikasi.</p>

<h3>Peran</h3>

<p>Peran memberikan kepada kelompok pengguna izin untuk melakukan beberapa tindakan.</p>

<p>Administrator Aplikasi: Pengguna yang termasuk dalam kelompok ini memiliki hak administratif secara penuh. Peran ini memiliki hampir nol pembatasan pada sumber daya dapat dipesan. Bisa mengelola semua aspek aplikasi.</p>

<p>Administrator Grup: Pengguna yang termasuk kelompok ini mampu mengelola kelompok dan reservasi atas nama mereka dan mengelola pengguna dalam kelompok itu.</p>

<p>Administrator Resource: Pengguna yang termasuk dalam kelompok ini mampu untuk mengatur resource dan menyetujui reservasi pada resource mereka.</p>

<p>Administrator Jadwal: Pengguna yang termasuk dalam kelompok ini mampu untuk mengatur jadwal mereka dan resource yang masuk dalam jadwal mereka dan menyetujui reservasi pada jadwal mereka.</p>

<h3>Melihat dan Mengatur Reservasi</h3>

<p>Anda bisa melihat dan mengatur reservasi dari menu Reservasi. Standarnya Anda akan melihat 7 hari terakhir dan 7 hari berikutnya dari reservasi. Bisa juga disaring lebih atau kurang rincian tergantung pada apa yang Anda cari. Utilitas ini memmungkinkan Anda menemukan secara cepat tindakan pada reservasi. Anda juga dapat mengekspor daftar dari saringan reservasi ke fromat CSV untuk kebutuhan laporan.</p>

<h3>Persetujuan Reservasi</h3>

<p>Atur $conf['settings']['reservation']['updates.require.approval'] ke 'true' akan membuat semua permintaan reservasi ke keadaan ditunda. Reservasi menjadi aktif setelah administrator menyetujinya. Dari utiliti Reservasi admin seorang admnistrator akan bisa melihat dan menyetujui penundaan reservasi. Reservasi yang ditunda akan disorot.</p>

<h3>Melihat dan Mengatur Pengguna</h3>

<p>Anda dapat menambah, melihat, dan mengatur semua pengguna yang terdaftar dalam menu Pengguna. Utilitas ini memungkinkan Anda untuk mengganti akses izin resouce per pengguna, menonaktifkan atau menghapus akun, mengatur ulang kata sandi pengguna, dan menyunting rincian pengguna. Anda juga dapat menambah pengguna baru ke Booked Scheduler. Hal ini sangat berguna jika pendaftaran sendiri (self-registration) dimatikan.</p>

<h3>Laporan</h3>

<p>Laporan dapat diakses ke semua administrator aplikasi, grup, resource dan jadwal. Saat pengguna yang memiliki akses fitur laporan masuk (log in), mereka akan melihat menu navigasi Laporan. Booked Scheduler dilengkapi dengan satu set dari Laporan Umum yang dapat dilihat sebagai daftar dari hasil, bagan, ekspor ke CSV dan cetak. Selain itu, laporan ad-hoc dapat dibuat dari menu Buat Laporan Baru. Hal ini juga memungkinkan dilihat dalam bentuk daftar, bagan, ekspor dan cetak. Selain itu, laporan khusus bisa diimpan dan diakses kembali pada waktu yang mendatang dari menu Laporan Tersimpan Saya. Menyimpan laporan juga bisa untuk dikirim melalui e-mail.</p>

<h3>Pengingat Reservasi</h3>

<p>Pengguna bisa meminta email pengingat dikirimkan berdasarkan awal atau akhir dari reservasi. Users can request that reminder emails are send prior to the beginning or end of a reservation. Agar fitur ini berfungsi, $conf['settings']['enable.email'] dan $conf['settings']['reservation']['enable.reminders'] keduanya harus diatur 'true'. Juga, tugas jadwal harus dikonfigurasi pada server Anda untuk menjalankan /Booked Scheduler/Jobs/sendreminders.php</p>

<p>Pada Linux, 'cron job' bisa digunakan. Perintah untuk menjalankan adalah <span class="note">php</span> diikuti dengan alamat lengkap untuk file Booked Scheduler/Jobs/sendreminders.php. Alamat lengkap untuk file sendreminders.php pada server ini <span class="note">{$RemindersPath}</span></p>

<p>Contoh konfigurasi cron akan terlihat seperti ini: <span class="note">* * * * * php {$RemindersPath}</span></p>

<p>Jika Anda memiliki akses ke cPanel melalui hosting provider, <a href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">mengatur cron job dalam cPanel</a> sangatlah mudah. Pilih setiap pilihan Setiap Menit (Every Minute)  opsi dari menu Pengaturan Umum (Common Seting), atau masukkan * untuk menit (minute), jam (hour), hari (day), bulan (month) dan hari kerja (weekday).</p>

<p>Dalam Windows, <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">sebuah tugas jadwal bisa digunakan</a>. Tugas harus dikonfigurasi agar berjalan setiap menit. Tugas untuk menjalankan adalah php diikuti dengan alamat lengkap untuk file Booked Scheduler/Jobs/sendreminders.php</p>

<h2>Konfigurasi</h2>

<p>Beberapa fungsi Booked Scheduler hanya bisa dikontrol dengan menyunting file config.</p>

<p class="setting"><span>$conf['settings']['server.timezone']</span>Konfigurasi ini harus merefleksikan zona waktu dari server yang terdapat Booked Scheduler. Server ini sekarang diatur pada <em>{$ServerTimezone}</em>. Lihat daftarnya di sini: <a href="http://php.net/manual/en/timezones.php" target="_blank">http://php.net/manual/en/timezones.php</a></p>

<p class="setting"><span>$conf['settings']['allow.self.registration']</span>Jika pengguna memungkinkan untuk mendaftar akun baru.</p>

<p class="setting"><span>$conf['settings']['admin.email']</span>Alamat email dari adiministrator aplikasi utama.</p>

<p class="setting"><span>$conf['settings']['default.page.size']</span>Jumlah baris pada setiap halaman yang menampilkan daftar dari data</p>

<p class="setting"><span>$conf['settings']['enable.email']</span>Mengirim atau tidak setiap email dari Booked Scheduler</p>

<p class="setting"><span>$conf['settings']['default.language']</span>Bahasa standar untuk semua pengguna. Bisa menggunakan bahasa yang terdapat pada direktori bahasa Booked Scheduler.</p>

<p class="setting"><span>$conf['settings']['script.url']</span>URL publik lengkap untuk sumber dari Booked Scheduler. Harus berisikan direktori Web yang terdapat file seperti booking.php dan calendar.php</p>

<p class="setting"><span>$conf['settings']['password.pattern']</span>Sebuah ekspresi standar untuk memberlakukan kerumitan kata sabdi saat pendaftaran akun.</p>

<p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>Menampilkan atau tidak resource yang tidak dapat diakses oleh pengguna tapi ditampilkan dalam jadwal.</p>

<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>Format dari tampilan slot reservasi pada halaman Booking. Token yang tersedia adalah {literal}{name}, {title}, {description}, {email}, {phone}, {organization}, {position}{/literal}. Biarkan kosong untuk tidak ada label. Bermacam kombinasi dari token bisa digunakan.</p>

<p class="setting"><span>$conf['settings']['schedule']['hide.blocked.periods']</span>Jika periode blokir harus disembunyikan pada halaman booking. Biasanya adalah 'false'.</p>

<p class="setting"><span>$conf['settings']['image.upload.directory']</span>Direktori untuk menyimpan gambar. Direktori ini harus bisa ditulis (writeable/755 sugeted). Bisa berupa direktori lengkap atau bergantung pada Booked Scheduler direktori utama.</p>

<p class="setting"><span>$conf['settings']['image.upload.url']</span>URL dimana hasil unggah gambar bisa dilihat. Bisa berupa URL lengkap atau tergantung pada  $conf['settings']['script.url'].</p>

<p class="setting"><span>$conf['settings']['cache.templates']</span>Mengaktifkan atau menonaktifkan template untuk di-'cached'. Pengaturan ini direkomendasikan untuk diatur sebagai 'true', selama direktori tpl_c dapat ditulis (writeable).</p>

<p class="setting"><span>$conf['settings']['use.local.jquery']</span>Menggunakan atau tidak file jQuery dari server. Jika diatur salah, file akan diambil dari Google CDN. Pengaturan ini direkomendasikan untuk diatur sebagai 'false' untuk meningkatkan performa dan penggunaan bandwith. Standarnya 'false'.</p>

<p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>Mengaktifkan atau menonaktifkan 'captcha image security' ketika pendaftaran akun baru.</p>

<p class="setting"><span>$conf['settings']['registration.require.email.activation']</span>Mengaktifkan atau menonaktifkan pengaktivasian akun mereka dengan menggunakan email sebelum masuk (log in) setelah mendaftar.</p>

<p class="setting"><span>$conf['settings']['registration.auto.subscribe.email']</span>Mengotomatiskan atau tidak pengguna agar otomatis berlangganan ke semua email ketika pendaftaran.</p>

<p class="setting"><span>$conf['settings']['inactivity.timeout']</span>Pengaturan berapa menit sebelum pengguna otomatis keloar (log out). Biarkan kosong jika Anda tidak ingin pengguna otomatis keluar (log out).</p>

<p class="setting"><span>$conf['settings']['name.format']</span>Pengaturan format tampilan untuk nama awal dan nama akhir. Biasanya {literal}'{first} {last}'{/literal}.</p>

<p class="setting"><span>$conf['settings']['css.extension.file']</span>URL lengkap atau relatif untuk file CSS tambahan agar termasuk. Pengaturan ini bisa digunakan untuk mengganti tema yang biasanya dengan tambahan pengaturan atau secara keseluruhan. Biarkan kosong jika Anda tidak ingin menambah style untuk Booked Scheduler.</p>

<p class="setting"><span>$conf['settings']['disable.password.reset']</span>Jika pengaturan ulang kata sandi harus dinonaktifkan. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['home.url']</span>Ke mana pengguna akan dialihkan ketika logo diklik. Biasanya halaman beranda pengguna.</p>

<p class="setting"><span>$conf['settings']['logout.url']</span>Ke mana pengguna akan dialihkan setelah keluar. Biasanya halaman login.</p>

<p class="setting"><span>$conf['settings']['ics']['require.login']</span>Jika pengguna harus masuk (log in) terlebih dahulu untuk menambah reservasi ke Outlook.</p>

<p class="setting"><span>$conf['settings']['ics']['subscription.key']</span>Jika Anda mengizinkan berlangganan webcal, atur agar sulit untuk ditebak. Jika tidak diatur maka berlangganan webcal akan dinonaktfkan.</p>

<p class="setting"><span>$conf['settings']['privacy']['view.schedules']</span>Jika bukan pengguna otentik bisa melihat jadwal booking. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['privacy']['view.reservations']</span>Jika bukan pengguna otentik bisa melihat rincian reservasi. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['privacy']['hide.user.details']</span>Jika bukan pengguna otentik bisa melihat informasi personal tentang pengguna lain. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation']['start.time.constraint']</span>Ketika reservasi bisa dibuat atau diubah. Pilihannya adalah future (di masa depan), current (saat ini), none (tidak sama sekali). Future (masa depan) artinya reservasi tidak bisa dibuat dan dimodifikasi jika waktu mulai dari slot yang dipilih adalah waktu yang sudah lewat. Current (saat ini) artinya reservasi bisa dibuat atau dimodifikasi jika akhir waktu dari slot yang dipilih bukan waktu yang sudah lewat. None (tidak sama sekali) artinya tidak ada batasan pada kapan reservasi bisa dibuat atau dimodifikasi. Biasanya 'future'.</p>

<p class="setting"><span>$conf['settings']['reservation']['updates.require.approval']</span>menyetujui atau tidak pembaruan reservasi yang sebelumnya telah disetujui. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.participation']</span>Membatasi atau tidak pengguna dari penambahan dan mengundang pengguna yang lain dalam reservasi. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation']['prevent.recurrence']</span>Mengharuskan atau tidak pengguna dibatasi reservasi yang berulang. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>Mengirim atau tidak mengirim email ke semua administrator grup ketika reservasi dibuat. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>Mengirim atau tidak mengirim email ke semua administrator grup ketika reservasi diperbarui. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>Mengirim atau tidak mengirim email ke semua administrator resource ketika reservasi dihapus. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>Mengirim atau tidak mengirim email ke semua administrator grup ketika reservasi dibuat. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>Mengirim atau tidak mengirim email ke semua administrator aplikasi ketika reservasi diperbarui. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>Mengirim atau tidak mengirim email ke semua administrator aplikasi ketika reservasi dihapus. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>Mengirim atau tidak mengirim email ke semua administrator grup ketika reservasi dibuat. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>Mengirim atau tidak mengirim email ke semua administrator grup ketika reservasi diperbarui. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>Mengirim atau tidak mengirim email ke semua administrator grup ketika reservasi dihapus. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['uploads']['enable.reservation.attachments']</span>Jika pengguna diizinkan untuk melampirkan file saat reservasi. Biasanya 'false'.</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.path']</span>Alamat lengkap atau relatif dari sistem file (tergantung atau relatif dari direktori utama Booked Scheduler) untuk menyimpan lampiran reservasi. Direktori ini harus dapat ditulis (writeable) oleh PHP (755 disarankan). Standarnya 'uploads/reservation'.</p>

<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>Pisahkan dengan koma daftar dari file ekstensi. Biarkan kosong untuk memungkinkan semua tipe file (tidak direkomendasi).</p>

<p class="setting"><span>$conf['settings']['database']['type']</span>Tipe PEAR::MDB2 juga didukung.</p>

<p class="setting"><span>$conf['settings']['database']['user']</span>Pengguna database dengan akses untuk mengkonfigurasi database.</p>

<p class="setting"><span>$conf['settings']['database']['password']</span>Kata sandi dari pengguna database.</p>

<p class="setting"><span>$conf['settings']['database']['hostspec']</span>URL host database atau IP.</p>

<p class="setting"><span>$conf['settings']['database']['name']</span>Nama database dari Booked Scheduler.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>Jenis email PHP. Pilihannya 'mail', 'smtp', 'sendmail', 'qmail'.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>Host SMTP, jika menggunakan smtp.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.port']</span>Port SMTP, jika menggunakan smtp, biasanya 25.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.secure']</span>Sekuritas SMTP, jika menggunakan smtp. Pilihannya '', 'ssl' atau 'tls'.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.auth']</span>Membutuhkan otentikasi SMTP, jika menggunakan smtp. Pilihannya 'true' atau 'false'.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.username']</span>Nama Pengguna SMTP, jika menggunakan smtp.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['smtp.password']</span>Kata Sandi SMTP, jika menggunakan smtp.</p>

<p class="setting"><span>$conf['settings']['phpmailer']['sendmail.path']</span>Alamat lengkap folder untuk sendmail, jika mengunakan sendmail.</p>

<p class="setting"><span>$conf['settings']['plugins']['Authentication']</span>Nama dari plugin otentikasi (authentication) yang digunakan. Untuk plugin yang lain, lihat bagian Plugins di bawah.</p>

<p class="setting"><span>$conf['settings']['plugins']['Authorization']</span>Nama dari plugin otorisasi (authorization) yang digunakan. Untuk plugin yang lain, lihat bagian Plugins di bawah.</p>

<p class="setting"><span>$conf['settings']['plugins']['Permission']</span>Nama dari plugin perizinan (permission) yang digunakan. Untuk plugin yang lain, lihat bagian Plugins di bawah.</p>

<p class="setting"><span>$conf['settings']['plugins']['PreReservation']</span>Nama dari plugin pra-resevasi (prereservation) yang digunakan. Untuk plugin yang lain, lihat bagian Plugins di bawah.</p>

<p class="setting"><span>$conf['settings']['plugins']['PostReservation']</span>Nama dari plugin pasca-reservasi (postreservation) yang digunakan. Untuk plugin yang lain, lihat bagian Plugins di bawah.</p>

<p class="setting"><span>$conf['settings']['install.password']</span>Jika Anda menjalankan pemasangan (instalation) atau melakukan upgrade, Anda harus mengisi di sini. Atur dengan isian acak.</p>

<p class="setting"><span>$conf['settings']['pages']['enable.configuration']</span>Jika halaman pengaturan konfigurasi harus tersedia untuk administrator aplikasi. Pilihannya 'true' atau 'false'.</p>

<p class="setting"><span>$conf['settings']['api']['enabled']</span>Jika RESTful API Booked Scheduler harus diaktifkan. Lihat lebih lanjut syarat-syarat untuk menggunakan API pada file readme_installation.html. Pilihannya 'true' atau 'false'.</p>

<p class="setting"><span>$conf['settings']['recaptcha']['enabled']</span>Jika ingin menggunakan reCAPTCHA daripada captcha yang ada. Pilihannya 'true' atau 'false'.</p>

<p class="setting"><span>$conf['settings']['recaptcha']['public.key']</span>Kunci reCAPTCHA publik (reCAPTCHA public key) Anda. Kunjungi www.google.com/recaptcha untuk pendaftaran.</p>

<p class="setting"><span>$conf['settings']['recaptcha']['private.key']</span>Kunci reCAPTCHA rahasia reChapta (reCAPTCHA private key) Anda. Kunjungi www.google.com/recaptcha untuk pendaftaran.</p>

<h2>Plugins</h2>

<p>Berikut komponen-komponen yang tersambung:</p>

<ul>
	<li>Authentication (Otentikasi) - Siapa saja yang bisa masuk (log in)</li>
	<li>Authorization (Otorisasi) - Apa saja yang pengguna bisa lakukan ketika masuk (log in)</li>
	<li>Permission (Izin) - Resource apa saja yang pengguna bisa akses</li>
	<li>Pre Reservation (Pra Reservasi) - Apa yang terjadi sebeum reservasi dibooking</li>
	<li>Post Reservation (Pasca Reservasi) - Apa yang terjadi setelah reservasi dibooking</li>
</ul>

<p>
	Untuk mengaktifkan plugin, atur value dari pengaturan konfig menjadi nama folder. Sebagai contoh, untuk mengaktifkan otentikasi LDAP, atur $conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

<p>Plugin mungkin memiliki file konfigurasi sendiri. Untuk LDAP, ganti nama atau salin /plugins/Authentication/Ldap/Ldap.config.dist ke /plugins/Authentication/Ldap/Ldap.config dan ubah semua nilai yang sesuai untuk kebutuhan Anda.</p>

<h3>Memasang Plugins</h3>

<p>Untuk memasang plugin baru, salin folder ke direktori Authentication, Authorization dan Permission. kemudian ubah $conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] atau $conf['settings']['plugins']['Permission'] pada config.php ke nama folder tersebut.</p>

</div>

{include file='globalfooter.tpl'}