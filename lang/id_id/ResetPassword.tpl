{*
Copyright 2011-2013 Nick Korbel

File ini adalah bagian dari phpShceduleIt.

phpScheduleIt adalah perangkat lunak gratis: Anda bisa 
mendistribusikannya dan/atau memodifikasikannya di bawah ketentuan 
GNU General Public License seperti yang diterbitkan oleh
Free Software Foundation, baik versi 3 dari Lisensi, atau
(dengan pilihan) versi apapun setelahnya.

phpScheduleIt didistribusikan dengan harapan akan berguna,
tapi TANPA JAMINAN; tanpa
phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; bahkan tanpa jaminan dari
PERDAGANGAN atau PENYESUAIAN UNTUK TUJUAN TERTENTU.
Lihat GNU General Public License untuk rincian lebih lanjut.

Anda seharusnya mendapatkan salinan dari GNU General Public License
bersamaan dengan phpScheduleIt. Jika tidak, lihat 
<http://www.gnu.org/licenses/>.

*}
{include file='..\..\tpl\Email\emailheader.tpl'}
	
Berikut kata sandi phpScheduleIt sementara Anda: {$TemporaryPassword}

<br/>

Kata sandi lama Anda tidak akan lagu berfungsi.
<br/>

Silahkan <a href="{$ScriptUrl}">masuk phpScheduleIt</a> dan ubah kata sandi Anda segera mungkin.
	
{include file='..\..\tpl\Email\emailfooter.tpl'}