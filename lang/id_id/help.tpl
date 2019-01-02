{*
Copyright 2011-2019 Nick Korbel

File ini adalah bagian dari Booked Scheduler.

Booked Scheduler adalah perangkat lunak gratis: Anda bisa
mendistribusikannya dan/atau memodifikasikannya di bawah ketentuan
GNU General Public License seperti yang diterbitkan oleh
Free Software Foundation, baik versi 3 dari Lisensi, atau
(dengan pilihan) versi apapun setelahnya Booked Scheduler didistribusikan dengan harapan akan berguna,
tapi TANPA JAMINAN; Booked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; bahkan tanpa jaminan dari
PERDAGANGAN atau PENYESUAIAN UNTUK TUJUAN TERTENTU.
Lihat GNU General Public License untuk rincian lebih lanjut.

Anda seharusnya mendapatkan salinan dari GNU General Public License
bersamaa Booked Scheduler. Jika tidak, lihat
<http://www.gnu.org/licenses/>.

*}
{include file='globalheader.tpl'}
Booked Scheduler</h1>

<div id="help">
<h2>Pendaftaran</h2>

<p>Pendaftaran dibutuhkan unt Booked Scheduler jika administrator telah mengaktifkannya. Setelah akun Anda telah terdaftar, Anda bisa log in dan mengakses resources yang diizinkan untuk Anda.</p>

<h2>Booking</h2>

<p>Di bawah menu Jadwal, Anda akan menemukan menu Booking. Menu ini akan menunjukkan slot yang tersedia, telah dipesan dan diblokir dalam jadwal dan memungkinkan Anda untuk memesan resources yang diizinkan untuk Anda.</p>

<h3>Cara Cepat</h3>

<p>Pada halaman Booking, temukan resources, tanggal dan waktu yang Anda ingin pesan. Mengklik pada slot waktu akan memungkinkan Anda mengubah rincian pemesanan. Mengklik tombol Create akan memeriksa ketersediaan, memesan reservasi dan mengirim email apapun. Anda akan diberikan nomor referensi digunakan untuk tindak lanjut reservasi.</p>

<p>Semua perubahan yang terjadi pada reservasi tidak akan berpengaruh sampai Anda menyimpannya.</p>

<p>Hanya Administrator Aplikasi dapat membuat reservasi di masa lalu.</p>

<h3>Resources Ganda</h3>

<p>Anda dapat memesan semua resource yang Anda miliki izin sebagai bagian dari pemesanan tunggal. Untuk menambahkan lebih banyak resource dalam reservasi Anda, klik tautan Resources Tambahan, ditampilkan di sebelah nama resource utama yang Anda reservasi. Anda kemudian akan dapat menambahkan lebih banyak resource dengan memilihnya dan mengklik tombol Selesai.</p>

<p>Untuk menghapus resource tambahan dari reservasi Anda, klik tautan Resource Tambahan, hapus pilihan resources yang ingin Anda hapus, dan klik tombol Selesai.</p>

<p>Resources tambahan akan memiliki aturan yang sama seperti resources utama. Sebagai contoh, jika Anda mencoba untuk membuat 2 jam reservasi dengan Resource 1, yang memiliki panjang maksimal 3 jam dan dengan Resource 2, yang memiliki panjang maksimal 1 jam, reservasi Anda akan ditolak.</p>

<h3>Pengulangan Tanggal</h3>

<p>Reservasi dapat dikonfigurasi untuk berulang dengan berbagai cara yang berbeda. Untuk semua pilihan ulangi Sampai tanggal tersebut inklusif.</p>

<p>Pilihan Pengulangan mengizinkan kemungkinan pengulangan yang fleksibel. Sebagai contoh: Ulangi Harian setiap 2 hari akan membuat reservasi setiap hari selama waktu yang ditentukan Anda. Ulangi Mingguan, setiap 1 minggu pada hari Senin, Rabu, Jumat akan membuat reservasi pada masing-masing hari setiap minggu pada waktu tertentu. Jika Anda membuat reservasi di 15-01-2011, mengulangi Bulanan, setiap 3 bulan pada hari yang sama setiap bulan akan menciptakan reservasi setiap bulan ketiga pada tanggal 15. Sejak 15-01-2011 adalah hari Sabtu ketiga bulan Januari, contoh yang yang sama setiap minggu yang dipilih akan mengulangi setiap bulan ketiga pada Sabtu ketiga bulan itu.</p>

<h3>Partisipan Tambahan</h3>

<p>Anda dapat Tambah Partisipan atau Mengundang Orang lain ketika memesan reservasi. Menambahkan seseorang akan menyertakan mereka dalam reservasi dan tidak akan mengirim undangan. Pengguna Yang ditambahkan akan menerima email. Mengundang pengguna akan mengirim email undangan dan memberikan pengguna pilihan untuk Terima atau Tolak undangan. Menerima sebuah undangan menambahkan pengguna ke daftar partisipan. Menolak sebuah undangan menghapus pengguna dari daftar undangan.</p>

<p>Jumlah partisipan dibatasi oleh kapasitas partisipan resource.</p>

<h3>Aksesoris</h3>

<p>Aksesori dapat dianggap sebagai obyek yang digunakan selama reservasi. Contoh mungkin proyektor atau kursi. Untuk menambahkan aksesori dalam pesanan Anda, klik link Tambah di sebelah kanan Aksesori judul. Dari sana Anda dapat memilih kuantitas untuk setiap aksesori yang tersedia. Jumlah yang tersedia selama waktu reservasi Anda akan bergantung pada berapa banyak aksesori yang sudah dipakai.</p>

<h3>Pemesanan Atas Nama Orang Lain</h3>

<p>Administrator Aplikasi dan Administrator Grup dapat memesan reservasi atas nama orang lain dengan mengklik tautan Ubah pada sebelah kiri nama pengguna.</p>

<p>Administrator Aplikasi dan Administrator Grup juga dapat memodifikasi dan menghapus reservasi yang dimiliki oleh pengguna lain.</p>

<h2>Perbarui Reservasi</h2>

<p>Anda dapat memperbarui reservasi yang telah dibuat atau atas nama Anda.</p>

<h3>Memperbarui Satu Reservasi (Dari Rangkaian Pengulangan)</h3>

<p>Jika reservasi diatur untuk berulang, maka rangkaiannya akan dibuat. Setelah Anda merubah dan memperbarui reservasi, Anda akan ditanya reservasi mana yang ingin Anda lakukan perubahan. Anda dapat menerapkan perbuahan pada reservasi yang sedang Anda buka/lihat (Hanya Reservasi Ini) dan reservasi yang lain tidak akan berbuah. Anda dapat merubah semua reservasi yang belum terjadi. Anda juga dapat menerapkannya pada Reservasi Yang Akan Datang, yang akan memperbarui semua reservasi termasuk reservasi yang sedang Anda buka/lihat.</p>

<p>Hanya Administrator Aplikasi yang dapat merubah reservasi yang sudah lewat.</p>

<h2>Menghapus Reservasi</h2>

<p>Menghapus reservasi akan menghapusnya dari jadwal. Tidak akan Booked Scheduleralam Booked Scheduler.</p>

<h3>Memhapus Satu Reservasi (Dari Rangkaian Pengulangan)</h3>

<p>Mirip dengan memperbarui reservasi, dengan menghapus Anda bisa memilih rangkaian reservasi mana yang ingin dihapus.</p>

<p>Hanya Administrator Aplikasi yang dapat merubah reservasi yang sudah lewat.</p>

<h2>Menambah Reservasi ke Aplikasi Kalender (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h2>

<p>Saat membuka/melihat atau mengubah reservasi Anda akan melihat tombol Tambah ke Outlook. Jika Outlook terpasang pada komputer Anda maka Anda akan ditanya untuk menambahkan jadwal. Jika tidak terpasang Anda akan mengunduh .ics file. Ini adalah standar aplikasi kalender. Anda bisa menggunakan file ini untuk menambah reservasi ke dalam aplikasi yang mendukung format iCalendar.</p>

<h2>Berlangganan Kalender</h2>

<p>Kalender dapat diterbitkan untuk Jadwal, Resource dan Pengguna. Agar fitur ini untuk bekerja, administrator harus mengkonfigurasi kunci berlangganan dalam file konfigurasi. Untuk mengaktifkan berlangganan Kalender Jadwal dan Resource, cukup mengaktifkan langganan ketika mengelola Jadwal atau Resource. Untuk mengaktifkan berlangganan kalender pribadi, buka Jadwal -> Kalender Saya. Di sisi kanan halaman, Anda akan menemukan link untuk Izinkan atau Nonaktifkan berlangganan kalender.</p>

<p>Untuk berlangganan Kalender Jadwal, buka Jadwal -> Kalender Resource dan pilih jadwal yang diinginkan. Pada sisi kanan halaman, Anda akan menemukan tautan untuk berlangganan ke Kalender yang Anda buka. Untuk berlangganan Kalender Resource, ikuti cara yang sama. Untuk berlangganan kalender pribadi, buka Jadwal -> Kalender Saya. Pada sisi kanan halaman, Anda akan menemukan tautan untuk berlangganan ke Kalender yang Anda buka.</p>

<h3>Program Kalender (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h3>

<p>Pada beberapa kasus, cukup mengklik tautan Berlangganan ke Kalender ini akan otomatis mengatur berlangganan pada Program Kalender. Untuk Outlook, jika tidak terjadi otomatis penambahan, buka Kalender, dan klik kanan Kalender saya dan pilih Tambah Kalender -> Dari Internet. Salin URL yang terlihat di bawah tautan BerlangganBooked Schedulerni pada Booked Scheduler.</p>

<h3>Kalender Google&reg;</h3>

<p>Buka pengaturan Kalender Google. Klik Kalender tab. Klik telusiri kalender yang menarik. Klik dan tambah dengan URL. Salin URL yang terlihat di bawah tautan BerlangBooked Schedulerr ini pada Booked Scheduler.</p>

<h2>Kuota</h2>

<p>Administrator memiliki kemampuan untuk mengkonfigurasi peraturan kuota berdasarkan bervariasi kriteria. Jika reservasi Anda melebihi kuota, Anda akan mendapat pesan dan reservasi akan ditolak.</p>

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}