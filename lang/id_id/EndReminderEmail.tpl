{*
Copyright 2011-2020 Nick Korbel

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

Reservasi Anda akan segera berakhir.<br/>
Rincian Reservasi:
	<br/>
	<br/>
	Mulai: {formatdate date=$StartDate key=reservation_email}<br/>
	Akhir: {formatdate date=$EndDate key=reservation_email}<br/>
	Resource: {$ResourceName}<br/>
	Judul: {$Title}<br/>
	Keterangan: {$Description|nl2br}<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Lihat reservasi ini</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Tambah ke Kalender</a> |
<a href="{$ScriptUrl}">Masuk ke Booked Scheduler</a>

