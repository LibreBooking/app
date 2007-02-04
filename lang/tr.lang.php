<?php
/**
* Turkish (tr) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator özcan doðan <ozcandogan@gmail.com>
* @version 05-14-06
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all of the strings that are used throughout phpScheduleit.
// Please save the translated file as '2 letter language code'.lang.php.  For example, en.lang.php.
// 
// To make phpScheduleIt available in another language, simply translate each
//  of the following strings into the appropriate one for the language.  If there
//  is no direct translation, please provide the closest translation.  Please be sure
//  to make the proper additions the /config/langs.php file (instructions are in the file).
//  Also, please add a help translation for your language using en.help.php as a base.
//
// You will probably keep all sprintf (%s) tags in their current place.  These tags
//  are there as a substitution placeholder.  Please check the output after translating
//  to be sure that the sentences make sense.
//
// + Please use single quotes ' around all $strings.  If you need to use the ' character, please enter it as \'
// + Please use double quotes " around all $email.  If you need to use the " character, please enter it as \"
//
// + For all $dates please use the PHP strftime() syntax
//    http://us2.php.net/manual/en/function.strftime.php
//
// + Non-intuitive parts of this file will be explained with comments.  If you
//    have any questions, please email lqqkout13@users.sourceforge.net
//    or post questions in the Developers forum on SourceForge
//    http://sourceforge.net/forum/forum.php?forum_id=331297
///////////////////////////////////////////////////////////

////////////////////////////////
/* Do not modify this section */
////////////////////////////////
global $strings;			  //
global $email;				  //
global $dates;				  //
global $charset;			  //
global $letters;			  //
global $days_full;			  //
global $days_abbr;			  //
global $days_two;			  //
global $days_letter;		  //
global $months_full;		  //
global $months_abbr;		  //
global $days_letter;		  //
/******************************/

// Charset for this language
// 'iso-8859-1' will work for most languages
$charset = 'iso-8859-9';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element 
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('Pazar', 'Pazartesi', 'Salý', 'Çarþamba', 'Perþembe', 'Cuma', 'Cumartesi');
// The three letter abbreviation
$days_abbr = array('Paz', 'Pts', 'Sal', 'Çar', 'Per', 'Cum', 'Cts');
// The two letter abbreviation
$days_two  = array('Pa', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct');
// The one letter abbreviation
$days_letter = array('P', 'P', 'S', 'Ç', 'P', 'C', 'C');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Ocak', 'þubat', 'Mart', 'Nisan', 'Mayýs', 'Haziran', 'Temmuz', 'Aðustos', 'Eylül', 'Ekim', 'Kasým', 'Aralýk');
// The three letter month name
$months_abbr = array('Oca', 'þub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Agu', 'Eyl', 'Eki', 'Kas', 'Ara');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%m/%d/%Y';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%m/%d/%Y @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%A %m/%d/%Y';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%A,<br/>%m/%d/%Y';
// Date on top-right of each page
$dates['header'] = '%A, %B %d, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%m %d %Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = 'saat';
$strings['minutes'] = 'dakika';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'dd';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'yyyy';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Administrator';
$strings['Welcome Back'] = 'Hoþgeldiniz, %s';
$strings['Log Out'] = 'Çýkýþ';
$strings['My Control Panel'] = 'Denetim Masam';
$strings['Help'] = 'Yardým';
$strings['Manage Schedules'] = 'Çizelgeyi Yönet';
$strings['Manage Users'] = 'Kullanýcýlarý Yönet';
$strings['Manage Resources'] = 'Kaynaklarý Yönet';
$strings['Manage User Training'] = 'Kullanýcý eðitimi yönet';
$strings['Manage Reservations'] = 'Rezervasyonlarý yönet';
$strings['Email Users'] = 'Kullanýclara eposta gönder';
$strings['Export Database Data'] = 'Veritabaný ihraç';
$strings['Reset Password'] = 'þifreyi sýfýrla';
$strings['System Administration'] = 'Sistem yönetimi';
$strings['Successful update'] = 'Güncelleþtirme baþarýlý';
$strings['Update failed!'] = 'Güncelleþtirme baþarýsýz';
$strings['Manage Blackout Times'] = 'Uygun olmayan zamanlarý yönet';
$strings['Forgot Password'] = 'þifreyi unuttum';
$strings['Manage My Email Contacts'] = 'Posta listemi yönet';
$strings['Choose Date'] = 'Tarih Seç';
$strings['Modify My Profile'] = 'Profilimi deðiþtir';
$strings['Register'] = 'Kayýt Ol';
$strings['Processing Blackout'] = 'Uygun olmayan zaman iþleniyor';
$strings['Processing Reservation'] = 'rezervasyon iþleniyor';
$strings['Online Scheduler [Read-only Mode]'] = 'Çizelge Göster [salt okunur]';
$strings['Online Scheduler'] = 'Çizelge';
$strings['phpScheduleIt Statistics'] = 'Ýstatistik';
$strings['User Info'] = 'Kullanýcý Bilgisi:';

$strings['Could not determine tool'] = 'Araç tanýmlanamadý. Denetim masasýna dönüp tekrar deneyiniz.';
$strings['This is only accessable to the administrator'] = 'Sadece admin yetkili';
$strings['Back to My Control Panel'] = 'Denetim masasýna dön';
$strings['That schedule is not available.'] = 'Bu çizelge uygun deðil';
$strings['You did not select any schedules to delete.'] = 'Silmek için çizelge seçmediniz';
$strings['You did not select any members to delete.'] = 'Silmek için üye seçmediniz.';
$strings['You did not select any resources to delete.'] = 'Silmek için kaynak seçmediniz';
$strings['Schedule title is required.'] = 'Çizelge baþlýðý gerekli.';
$strings['Invalid start/end times'] = 'Geçersiz baþlangýç/bitiþ zamanlarý';
$strings['View days is required'] = 'Gün gerekli';
$strings['Day offset is required'] = 'offset gün gerekli';
$strings['Admin email is required'] = 'Admin eposta gerekli';
$strings['Resource name is required.'] = 'Kaynak adý gerekli';
$strings['Valid schedule must be selected'] = 'Geçerli çizelge seçilmeli';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'En az rezervasyon süresi en çok rezervasyon süresinden az ya da eþit olmalýdýr.';
$strings['Your request was processed successfully.'] = 'Ýsteðiniz baþarýyla iþlendi.';
$strings['Go back to system administration'] = 'Sistem yönetimine geri dön';
$strings['Or wait to be automatically redirected there.'] = 'Veya oraya yönlendirilmek için bekleyin.';
$strings['There were problems processing your request.'] = 'Ýþlemde hata var.';
$strings['Please go back and correct any errors.'] = 'Lütfen geri dönün ve hatalarý düzeltin.';
$strings['Login to view details and place reservations'] = 'Giriþ yapýnýz';
$strings['Memberid is not available.'] = 'Üye: %s geçerli deðil.';

$strings['Schedule Title'] = 'Çizelge baþlýðý';
$strings['Start Time'] = 'Baþlangýç zamaný';
$strings['End Time'] = 'Bitiþ zamaný';
$strings['Time Span'] = 'Süre';
$strings['Weekday Start'] = 'Hafta Baþý';
$strings['Admin Email'] = 'Admin Eposta';

$strings['Default'] = 'varsayýlan';
$strings['Reset'] = 'Yenile';
$strings['Edit'] = 'Düzenle';
$strings['Delete'] = 'Sil';
$strings['Cancel'] = 'Ýptal';
$strings['View'] = 'Göster';
$strings['Modify'] = 'Deðiþtir';
$strings['Save'] = 'Kaydet';
$strings['Back'] = 'Geri';
$strings['Next'] = 'Ýleri';
$strings['Close Window'] = 'Pancereyi kapat';
$strings['Search'] = 'Ara';
$strings['Clear'] = 'Temizle';

$strings['Days to Show'] = 'Gösterilecek gün';
$strings['Reservation Offset'] = 'Rezervasyon Offset';
$strings['Hidden'] = 'saklý';
$strings['Show Summary'] = 'Özet Gözter';
$strings['Add Schedule'] = 'Çizelge ekle';
$strings['Edit Schedule'] = 'Çizelge düzenle';
$strings['No'] = 'Hayýr';
$strings['Yes'] = 'Evet';
$strings['Name'] = 'Ad';
$strings['First Name'] = 'Ýlk ad';
$strings['Last Name'] = 'Soyad';
$strings['Resource Name'] = 'Kaynak adý';
$strings['Email'] = 'Eposta';
$strings['Institution'] = 'Bölüm';
$strings['Phone'] = 'telefon';
$strings['Password'] = 'þifre';
$strings['Permissions'] = 'Ýzinler';
$strings['View information about'] = 'Hakkýnda bilgi göster %s %s';
$strings['Send email to'] = 'Posta Yolla %s %s';
$strings['Reset password for'] = 'þifre sýfýrla %s %s';
$strings['Edit permissions for'] = 'Ýzin deðiþtir %s %s';
$strings['Position'] = 'Görevi';
$strings['Password (6 char min)'] = 'þifre (en az %s karakter)';
$strings['Re-Enter Password'] = 'þifreyi tekrar gir';

$strings['Sort by descending last name'] = 'z\'den a\'ya soyadlara göre sýrala';
$strings['Sort by descending email address'] = 'z\'den a\'ya Epostaya göre sýrala';
$strings['Sort by descending institution'] = 'z\'den a\'ya göreve göre sýrala';
$strings['Sort by ascending last name'] = 'a\'dan z\'ye soyada göre sýrala';
$strings['Sort by ascending email address'] = 'a\'dan z\'ye epostaya göre sýrala';
$strings['Sort by ascending institution'] = 'a\'dan z\'ye göreve göre sýrala';
$strings['Sort by descending resource name'] = 'z\'den a\'ya kaynak adýna göre sýrala';
$strings['Sort by descending location'] = 'z\'den a\'ya yere göre sýrala';
$strings['Sort by descending schedule title'] = 'z\'den a\'ya çizelge baþlýðýna göre sýrala';
$strings['Sort by ascending resource name'] = 'a\'dan z\'ye kaynak adýna göre sýrala';
$strings['Sort by ascending location'] = 'a\'dan z\'ye yere göre sýrala';
$strings['Sort by ascending schedule title'] = 'a\'dan z\'ye çizelge baþlýðýna göre sýrala';
$strings['Sort by descending date'] = 'z\'den a\'ya tarihe göre sýrala';
$strings['Sort by descending user name'] = 'z\'den a\'ya kullanýcý adýna göre sýrala';
$strings['Sort by descending start time'] = 'z\'den a\'ya baþlangýç zamanýna göre sýrala';
$strings['Sort by descending end time'] = 'z\'den a\'ya bitiþ zamanýna göre sýrala';
$strings['Sort by ascending date'] = 'a\'dan z\'ye tarihe göre sýrala';
$strings['Sort by ascending user name'] = 'a\'dan z\'ye kullanýcý adýna göre sýrala';
$strings['Sort by ascending start time'] = 'a\'dan z\'ye baþlangýç zamanýna göre sýrala';
$strings['Sort by ascending end time'] = 'a\'dan z\'ye bitiþ zamanýna göre sýrala';
$strings['Sort by descending created time'] = 'z\'den a\'ya yaratýldýðý zamanýna göre sýrala';
$strings['Sort by ascending created time'] = 'a\'dan z\'ye yaratýldýðý zamanýna göre sýrala';
$strings['Sort by descending last modified time'] = 'z\'den a\'ya son deðiþtirildiði zamana göre sýrala';
$strings['Sort by ascending last modified time'] = 'a\'dan z\'ye son deðiþtirildiði zamana göre sýrala';

$strings['Search Users'] = 'Kullanýcý ara';
$strings['Location'] = 'yer';
$strings['Schedule'] = 'Çizelge';
$strings['Notes'] = 'Notlar';
$strings['Status'] = 'Durum';
$strings['All Schedules'] = 'Tüm çizelgeler';
$strings['All Resources'] = 'Tüm kaynaklar';
$strings['All Users'] = 'Tüm kullanýcýlar';

$strings['Edit data for'] = 'Veriyi düzenle %s';
$strings['Active'] = 'Aktif';
$strings['Inactive'] = 'Pasif';
$strings['Toggle this resource active/inactive'] = 'Bu kaynaðý actif/pasif olarak iþaretle';
$strings['Minimum Reservation Time'] = 'En kýsa rezervasyon süresi';
$strings['Maximum Reservation Time'] = 'En uzun rezervasyon süresi';
$strings['Auto-assign permission'] = 'Otomatik yetkilendir';
$strings['Add Resource'] = 'kaynak ekle';
$strings['Edit Resource'] = 'kaynak düzenle';
$strings['Allowed'] = 'Ýzinli';
$strings['Notify user'] = 'Kullanýcý bilgilendir';
$strings['User Reservations'] = 'Kullanýcý rezervasyonlarý';
$strings['Date'] = 'Tarih';
$strings['User'] = 'Kullanýcý';
$strings['Subject'] = 'Konu';
$strings['Message'] = 'Mesaj';
$strings['Please select users'] = 'Kullanýcý seçiniz';
$strings['Send Email'] = 'Eposta gönder';
$strings['problem sending email'] = 'Eposta göndermede hata! Lütfen daha sonra tekrar deneyiniz.';
$strings['The email sent successfully.'] = 'Eposta baþarýyla gönderildi.';
$strings['do not refresh page'] = 'Lütfen <u>bu sayfayý</u> tazelemeyin. Epostayý 2. kez göndermiþ olursunuz.';
$strings['Return to email management'] = 'Eposta yönetimine dön';
$strings['Please select which tables and fields to export'] = 'Lütfen ihraç edilecek tablolarý seçiniz';
$strings['all fields'] = '- Tüm alanlar -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Düz metin';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Ýhraç et';
$strings['Reset Password for'] = 'þifreyi sýfýrla %s';
$strings['Please edit your profile'] = 'Profilinizi düzenleyin';
$strings['Please register'] = 'Lütfen kayýt olun';
$strings['Email address (this will be your login)'] = 'Eposta adresi (kullanýcý adýnýz olacak)';
$strings['Keep me logged in'] = 'þifre kaydet <br/>(çerez gerektirir)';
$strings['Edit Profile'] = 'Profil düzenle';
$strings['Please Log In'] = 'Giriþ Yapýnýz';
$strings['Email address'] = 'Eposta';
$strings['First time user'] = 'Ýlk kez kullanýcýsý?';
$strings['Click here to register'] = 'kayýt için týklayýnýz';
$strings['Register for phpScheduleIt'] = 'Kayýt olunuz';
$strings['Log In'] = 'Giriþ';
$strings['View Schedule'] = 'Çizelgeyi göster';
$strings['View a read-only version of the schedule'] = 'salt okunur çizelge';
$strings['I Forgot My Password'] = 'þifremi Unuttum';
$strings['Retreive lost password'] = 'þifremi gönder';
$strings['Get online help'] = 'yardým';
$strings['Language'] = 'Dil';
$strings['(Default)'] = '(varsayýlan)';

$strings['My Announcements'] = 'Duyurularým';
$strings['My Reservations'] = 'Rezervasyonlarým';
$strings['My Permissions'] = 'izinlerim';
$strings['My Quick Links'] = 'Köprülerim';
$strings['Announcements as of'] = 'Duyurular %s';
$strings['There are no announcements.'] = 'Duyuru Yok';
$strings['Resource'] = 'Kaynak';
$strings['Created'] = 'Yaratýldý';
$strings['Last Modified'] = 'Son deðiþtirme';
$strings['View this reservation'] = 'Bu rezervasyonu göster';
$strings['Modify this reservation'] = 'Bu rezervasyonu deðiþtir';
$strings['Delete this reservation'] = 'Bu rezervasyonu sil';
$strings['Bookings'] = 'Bookings';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = 'Change Profile';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Preferences';				// @since 1.2.0
$strings['Mass Email Users'] = 'Kullanýclara eposta gönder';
$strings['Search Scheduled Resource Usage'] = 'Search Reservations';		// @since 1.2.0
$strings['Export Database Content'] = 'Veritabaný ihraç et';
$strings['View System Stats'] = 'Sistem istatistikleri';
$strings['Email Administrator'] = 'Epostal Administrator';

$strings['Email me when'] = 'eposta gönderme zamaný:';
$strings['I place a reservation'] = 'Rezervasyon yaparým';
$strings['My reservation is modified'] = 'Rezervasyonum deðiþtirildi';
$strings['My reservation is deleted'] = 'Rezervasyonum silindi';
$strings['I prefer'] = 'tercihim:';
$strings['Your email preferences were successfully saved'] = 'Eposta tercihleriniz kaydedildi!';
$strings['Return to My Control Panel'] = 'Denetim masasýna dön';

$strings['Please select the starting and ending times'] = 'Baþlançýç ve bitiþ zamaný seçiniz:';
$strings['Please change the starting and ending times'] = 'Baþlançýç ve bitiþ zamaný deðiþtirin:';
$strings['Reserved time'] = 'Rezerv zamaný:';
$strings['Minimum Reservation Length'] = 'En kýsa rezervasyon süresi:';
$strings['Maximum Reservation Length'] = 'En uzun rezervasyon süresi:';
$strings['Reserved for'] = 'Rezervasyon sahibi:';
$strings['Will be reserved for'] = 'rezerve edileceði kiþi:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Gruptaki tüm tekrarlayan kayýtlarý güncelle?';
$strings['Delete?'] = 'sil?';
$strings['Never'] = '-- Hiç --';
$strings['Days'] = 'Gün';
$strings['Weeks'] = 'Hafta';
$strings['Months (date)'] = 'Aylar (tarih)';
$strings['Months (day)'] = 'haftalar (gün)';
$strings['First Days'] = 'Birinci Günler';
$strings['Second Days'] = 'Ýkinci Günler';
$strings['Third Days'] = 'Üçüncü Günler';
$strings['Fourth Days'] = 'Dördüncü Günler';
$strings['Last Days'] = 'Son Günler';
$strings['Repeat every'] = 'Tekrar sýklýðý:';
$strings['Repeat on'] = 'Tekrar:';
$strings['Repeat until date'] = 'Tekrar sonu:';
$strings['Summary'] = 'Özet';

$strings['View schedule'] = 'Çizelge Göster:';
$strings['My Past Reservations'] = 'Eski rezervasyonlarý';
$strings['Other Reservations'] = 'Diðer rezervasyonlar';
$strings['Other Past Reservations'] = 'Diðer eski rezervasyonlar';
$strings['Blacked Out Time'] = 'Uygun olmayan zaman';
$strings['Set blackout times'] = 'Uygun olmayan zaman ayarla %s on %s';
$strings['Reserve on'] = 'Rezerve %s on %s';
$strings['Prev Week'] = '« Geçen hafta';
$strings['Jump 1 week back'] = '1 Hafta geri';
$strings['Prev days'] = '‹ önceki %d gün';
$strings['Previous days'] = '‹ önceki %d gün';
$strings['This Week'] = 'Bu hafta';
$strings['Jump to this week'] = 'Bu haftaya dön';
$strings['Next days'] = 'Sonraki %d gün ›';
$strings['Next Week'] = 'Gelecek hafta »';
$strings['Jump To Date'] = 'Tarihe Git';
$strings['View Monthly Calendar'] = 'Aylýk takvimi göster';
$strings['Open up a navigational calendar'] = 'Dolaþýmlý takvim aç';

$strings['View stats for schedule'] = 'Çizelge istatistikleri:';
$strings['At A Glance'] = 'Bakýþta';
$strings['Total Users'] = 'Toplam kullanýcý:';
$strings['Total Resources'] = 'Toplam kaynak:';
$strings['Total Reservations'] = 'Toplam rezervasyon:';
$strings['Max Reservation'] = 'En çok rezervasyon:';
$strings['Min Reservation'] = 'En az rezervasyon:';
$strings['Avg Reservation'] = 'Ortalama rezervasyon:';
$strings['Most Active Resource'] = 'En aktif kaynak:';
$strings['Most Active User'] = 'En aktif kullanýcý:';
$strings['System Stats'] = 'Sistem istatistikleri';
$strings['phpScheduleIt version'] = 'versiYon:';
$strings['Database backend'] = 'Veritabaný arka ucu:';
$strings['Database name'] = 'Veritabaný adý:';
$strings['PHP version'] = 'PHP versiyon:';
$strings['Server OS'] = 'Sunucu OS:';
$strings['Server name'] = 'Sunucu adý:';
$strings['phpScheduleIt root directory'] = 'ana dizin:';
$strings['Using permissions'] = 'Ýzinler:';
$strings['Using logging'] = 'Log Kayýtlarý:';
$strings['Log file'] = 'Log dosyasý:';
$strings['Admin email address'] = 'Admin eposta adresi:';
$strings['Tech email address'] = 'Teknisyen eposta adresi:';
$strings['CC email addresses'] = 'CC eposta adres:';
$strings['Reservation start time'] = 'Rezervasyon baþlangýç zamaný:';
$strings['Reservation end time'] = 'Rezervasyon bitiþ zamaný:';
$strings['Days shown at a time'] = 'Bir seferde gösterilecek gün:';
$strings['Reservations'] = 'Rezervasyonlar';
$strings['Return to top'] = 'Yukarý dön';
$strings['for'] = 'Ýçin';

$strings['Select Search Criteria'] = 'Arama kriteri seçiniz';
$strings['Schedules'] = 'Çizelgeler:';
$strings['Hold CTRL to select multiple'] = 'Çoklu seçim için CTRL basýlý tutunuz';
$strings['Users'] = 'Kullanýcýlar:';
$strings['Resources'] = 'Kaynaklar';
$strings['Starting Date'] = 'Baþlangýç günü:';
$strings['Ending Date'] = 'Bitiþ Günü:';
$strings['Starting Time'] = 'Baþlangýç zamaný:';
$strings['Ending Time'] = 'Bitiþ zamaný:';
$strings['Output Type'] = 'Çýktý tipi:';
$strings['Manage'] = 'Yönet';
$strings['Total Time'] = 'Toplam süre';
$strings['Total hours'] = 'Toplam saat:';
$strings['% of total resource time'] = '% Toplam rezervasyon süresi';
$strings['View these results as'] = 'Bu sonuçlarý göster:';
$strings['Edit this reservation'] = 'Bu rezervasyonu düzenle';
$strings['Search Results'] = 'Arama sonuçlarý';
$strings['Search Resource Usage'] = 'kaynak kullanýmý ara';
$strings['Search Results found'] = 'Arama sonuçlarý: %d rezervasyon bulundu';
$strings['Try a different search'] = 'Farklý arama deneyiniz';
$strings['Search Run On'] = 'Arama çalýþtýrýldý:';
$strings['Member ID'] = 'Üye ID';
$strings['Previous User'] = '« Önceki kullanýcý';
$strings['Next User'] = 'Sonraki kullanýcý »';

$strings['No results'] = 'Sonuç bulunamadý';
$strings['That record could not be found.'] = 'O kayýt bulunamadý.';
$strings['This blackout is not recurring.'] = 'Bu kesinti tekrarlamayacak.';
$strings['This reservation is not recurring.'] = 'Bu rezervasyon tekrarlamayacak.';
$strings['There are no records in the table.'] = 'Tabloda %s kayýt yok.';
$strings['You do not have any reservations scheduled.'] = 'yapýlmýþ rezervasyonunuz yok';
$strings['You do not have permission to use any resources.'] = 'Kaynak kullaným yetkinniz yok.';
$strings['No resources in the database.'] = 'Veritabanýnda kaynak yok.';
$strings['There was an error executing your query'] = 'Sorgu çalýþtýrýlýrken hata oluþtu:';

$strings['That cookie seems to be invalid'] = 'Çerez geçersiz';
$strings['We could not find that email in our database.'] = 'Eposta adresniniz bulunamadý';
$strings['That password did not match the one in our database.'] = 'hatalý þifre.';
$strings['You can try'] = '<br />tekrar farklý:<br />eposta adresi girin.<br />veya:<br />tekrar giriþ yapýn.';
$strings['A new user has been added'] = 'Yeni bir kullanýcý eklendi';
$strings['You have successfully registered'] = 'baþarýyla kaydoldunuz!';
$strings['Continue'] = 'Devam...';
$strings['Your profile has been successfully updated!'] = 'Profiliniz baþarýyla güncellendi!';
$strings['Please return to My Control Panel'] = 'Lütfen denetim masasýna dönün';
$strings['Valid email address is required.'] = '- geçerli eposta adresi giriniz.';
$strings['First name is required.'] = '- Ad gerekli.';
$strings['Last name is required.'] = '-Soyad gerekli.';
$strings['Phone number is required.'] = '- Telefon no gerekli.';
$strings['That email is taken already.'] = '- Bu eposta kayýtlý.<br />Lütfen baþka eposta deneyiniz.';
$strings['Min 6 character password is required.'] = '- En az 6 karakter þifre gerekli.';
$strings['Passwords do not match.'] = '- þifreler tutarsýz.';

$strings['Per page'] = 'sayfa baþýna:';
$strings['Page'] = 'sayfa:';

$strings['Your reservation was successfully created'] = 'Rezervasyonunuz baþarýyla yaratýldý';
$strings['Your reservation was successfully modified'] = 'Rezervasyonunuz baþarýyla deðiþtirildi';
$strings['Your reservation was successfully deleted'] = 'Rezervasyonunuz baþarýyla silindi';
$strings['Your blackout was successfully created'] = 'Kesintiniz yaratýldý.';
$strings['Your blackout was successfully modified'] = 'Kesintiniz deðiþtirildi';
$strings['Your blackout was successfully deleted'] = 'Kesintiniz silindi';
$strings['for the follwing dates'] = 'takip eden günler için:';
$strings['Start time must be less than end time'] = 'Baþlangýç zamaný bitiþ zamanýndan önce olmalýdýr.';
$strings['Current start time is'] = 'Geçerli baþlangýç zamaný:';
$strings['Current end time is'] = 'Geçerli bitiþ zamaný:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Rezervasyon süreniz kaynaðýn izin verilen süresine uymuyor.';
$strings['Your reservation is'] = 'rezervasyonunuz:';
$strings['Minimum reservation length'] = 'En kýsarezervasyon süresi:';
$strings['Maximum reservation length'] = 'En uzunrezervasyon süresi:';
$strings['You do not have permission to use this resource.'] = 'Bu kaynaða rezervasyon yetkiniz yok.';
$strings['reserved or unavailable'] = '%s den%s ekadar %s rezerve ya da uygun deðil.';
$strings['Reservation created for'] = 'rezervasyon yaratýldý %s';
$strings['Reservation modified for'] = 'rezervasyon deðiþtirildi %s';
$strings['Reservation deleted for'] = 'Rezervasyon silindi %s';
$strings['created'] = 'yaratýldý';
$strings['modified'] = 'deðiþtirildi';
$strings['deleted'] = 'silindi';
$strings['Reservation #'] = 'Rezervasyon #';
$strings['Contact'] = 'Ýletiþim';
$strings['Reservation created'] = 'Rezervasyon yaratýldý';
$strings['Reservation modified'] = 'Rezervasyon deðiþtirildi';
$strings['Reservation deleted'] = 'Rezervasyon silindi';

$strings['Reservations by month'] = 'Ay bazýnda rezervasyonlar';
$strings['Reservations by day of the week'] = 'Gün bazýnda rezervasyonlar';
$strings['Reservations per month'] = 'ay baþýna rezervasyonlar';
$strings['Reservations per user'] = 'Kullanýcý baþýna rezervasyonlar';
$strings['Reservations per resource'] = 'Kaynak baþýna rezervasyonlar';
$strings['Reservations per start time'] = 'Baþlangýç zamaný baþýna rezervasyonlar';
$strings['Reservations per end time'] = 'Bitiþ zamaný baþýna rezervasyonlar';
$strings['[All Reservations]'] = '[Tüm Rezervasyonlar]';

$strings['Permissions Updated'] = 'Ýzinler güncellendi';
$strings['Your permissions have been updated'] = 'Sizin %s izinleriniz güncellendi';
$strings['You now do not have permission to use any resources.'] = 'Kaynak kullanýmý için izniniz yok.';
$strings['You now have permission to use the following resources'] = 'Ekteki kaynaklara izniniz var:';
$strings['Please contact with any questions.'] = 'Sorularýnýz için %s baþvurunuz.';
$strings['Password Reset'] = 'þifre sýfýrla';

$strings['This will change your password to a new, randomly generated one.'] = 'Bu sizin þifreniz rasgele bir þifre ile deðiþtirecektir.';
$strings['your new password will be set'] = 'eposta adresinizi girip þifre Deðiþtire týklayýnca yeni þifreniz size postalanacaktýr.';
$strings['Change Password'] = 'þifre deðiþtir';
$strings['Sorry, we could not find that user in the database.'] = 'Kullanýcý bulunamadý.';
$strings['Your New Password'] = 'yeni %s þifreniz';
$strings['Your new passsword has been emailed to you.'] = 'baþardýnýz!<br />yeni þifreniz size eposta olarak gönderildi.';
$strings['You are not logged in!'] = 'Giriþ yapmadýnýz!';

$strings['Setup'] = 'Kur';
$strings['Please log into your database'] = 'Veritabanýna giriþ yapýnýz';
$strings['Enter database root username'] = 'veritabaný root kullanýcý:';
$strings['Enter database root password'] = 'veritabaný root þifre:';
$strings['Login to database'] = 'veritabaný giriþ yap';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Root kullanýcý <b></b> gerekmiyor. databse yaratma izni olan kullancý yeterli..';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Veritabaný ve tablolar kurulacak';
$strings['It also populates any required tables.'] = 'gerekli tablolar da yaratýlacak.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Uyarý: daha önceki rezervasyon veritabanýnýz silinecektir';
$strings['Not a valid database type in the config.php file.'] = 'config.php geçerli veritabaný adýný barýndýrmýyor.';
$strings['Database user password is not set in the config.php file.'] = 'config.php veritabaný kulalnýcý þifesi bulunmuyor.';
$strings['Database name not set in the config.php file.'] = 'config.php veritabaný adý bulunmuyor.';
$strings['Successfully connected as'] = 'baðlandý';
$strings['Create tables'] = 'Tablo yarat >';
$strings['There were errors during the install.'] = 'Kurulumda hatalar oluþtu.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Kurulum baþarýlý.';
$strings['Thank you for using phpScheduleIt'] = ' \'install\' Diznini siliniz.';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'upfate 0.9.3 to 1.0.0.';
$strings['There is no way to undo this action'] = 'Bu iþlem geri alýnamaz!';
$strings['Click to proceed'] = 'baþlamak için týklayýnýz';
$strings['This version has already been upgraded to 1.0.0.'] = 'zaten versiyon 1.0';
$strings['Please delete this file.'] = 'Lütfen bu dosyayý siliniz.';
$strings['Patch completed successfully'] = 'Yama baþarýlý';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Deðer girilmezse konfig dosyasýndaki þifre geçerli';
$strings['Notify user that password has been changed?'] = 'Kullanýcýyý þifre deðiþtiði hakkýnda biilgilendir?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Bu sistem eposta adresine sahip olmanýzý gerektirir.';
$strings['Invalid User Name/Password.'] = 'Geçersiz kullanýcý adý/Þifre.';
$strings['Pending User Reservations'] = 'Bekleyen kullanýcý rezervasyonlarý';
$strings['Approve'] = 'Onayla';
$strings['Approve this reservation'] = 'Bu rezervasyonu onayla';
$strings['Approve Reservations'] ='Rezervasyonlarý onayla';

$strings['Announcement'] = 'Duyuru';
$strings['Number'] = 'Numara';
$strings['Add Announcement'] = 'Duyuru ekle';
$strings['Edit Announcement'] = 'Duyuru düzenle';
$strings['All Announcements'] = 'Tüm duyurular';
$strings['Delete Announcements'] = 'Duyurularý sil';
$strings['Use start date/time?'] = 'Baþlangýç tarih/saat?';
$strings['Use end date/time?'] = 'Use end date/time?';
$strings['Announcement text is required.'] = 'Duyuru metni gerekli.';
$strings['Announcement number is required.'] = 'Duyuru numarasý gerekli.';

$strings['Pending Approval'] = 'Onay bekliyor';
$strings['My reservation is approved'] = 'ezervasyonum onaylandý';
$strings['This reservation must be approved by the administrator.'] = 'Bu rezervasyon rezervasyon yöneticisi tarafýndan onaylanmalýdýr.';
$strings['Approval Required'] = 'Onay gerekli';
$strings['No reservations requiring approval'] = 'Onaylanmasý gereken rezervasyon bulunmuyor';
$strings['Your reservation was successfully approved'] = 'Rezervasyonunuz onaylandý';
$strings['Reservation approved for'] = 'Rezervasyon onaylandý %s';
$strings['approved'] = 'onaylandý';
$strings['Reservation approved'] = 'Rezervasyon onaylandý';

$strings['Valid username is required'] = 'Geçerli kullanýcý adý gerekli';
$strings['That logon name is taken already.'] = 'Bu kullanýcý adý zaten alýnmýþ.';
$strings['this will be your login'] = '(giriþ hesabýnýz olacak)';
$strings['Logon name'] = 'Giriþ adý';
$strings['Your logon name is'] = 'Giriþ adýnýz %s';

$strings['Start'] = 'Baþlangýç';
$strings['End'] = 'Bitiþ';
$strings['Start date must be less than or equal to end date'] = 'Baþlangýç tarihi bitiþ tarihinden önce olmalýdýr';
$strings['That starting date has already passed'] = 'Bu baþlangýç tarihi geçmiþ';
$strings['Basic'] = 'Temel';
$strings['Participants'] = 'Katýlýmcýlar';
$strings['Close'] = 'Kapat';
$strings['Start Date'] = 'Baþlangýç tarihi';
$strings['End Date'] = 'Bitiþ tarihi';
$strings['Minimum'] = 'En az';
$strings['Maximum'] = 'En çok';
$strings['Allow Multiple Day Reservations'] = 'Çoklu rezervasyona izin ver';
$strings['Invited Users'] = 'Davetli kullanýcýlar';
$strings['Invite Users'] = 'Kullanýcýlarý davet et';
$strings['Remove Participants'] = 'Katýlýmcýlarý kaldýr';
$strings['Reservation Invitation'] = 'Rezervasyon Daveti';
$strings['Manage Invites'] = 'Davetlileri yönet';
$strings['No invite was selected'] = 'Davetli seçilmedi';
$strings['reservation accepted'] = '%s Davetinizi kabul etti %s';
$strings['reservation declined'] = '%s Davetinizi reddetti %s';
$strings['Login to manage all of your invitiations'] = 'Tüm davetlerinizi yönetmek için giriþ yapýnýz';
$strings['Reservation Participation Change'] = 'Rezervasyon katýlým deðiþikliði';
$strings['My Invitations'] = 'Davetlerim';
$strings['Accept'] = 'Kabul et';
$strings['Decline'] = 'Reddet';
$strings['Accept or decline this reservation'] = 'Bu rezervasyonu kabul ya da red edin';
$strings['My Reservation Participation'] = 'Rezervasyona katýlýmým';
$strings['End Participation'] = 'Katýlým sonu';
$strings['Owner'] = 'Sahip';
$strings['Particpating Users'] = 'Katýlýmcý kullanýcýlar';
$strings['No advanced options available'] = 'Geliþmiþ seçenekler bulunmuyor';
$strings['Confirm reservation participation'] = 'Rezervasyon katýlýmýný onayla';
$strings['Confirm'] = 'Onayla';
$strings['Do for all reservations in the group?'] = 'Bu gruptaki tüm rezervasyonlar için yap?';

$strings['My Calendar'] = 'Takvimim';
$strings['View My Calendar'] = 'Takvimimi göster';
$strings['Participant'] = 'Katýlýmcý';
$strings['Recurring'] = 'Tekrarlayan';
$strings['Multiple Day'] = 'Çoklu gün';
$strings['[today]'] = '[bugün]';
$strings['Day View'] = 'Gün göster';
$strings['Week View'] = 'Hafta göster';
$strings['Month View'] = 'Ay göster';
$strings['Resource Calendar'] = 'Kaynak takvimi';
$strings['View Resource Calendar'] = 'Schedule Calendar';	// @since 1.2.0
$strings['Signup View'] = 'Kayýt göster';

$strings['Select User'] = 'Kullanýcý seç';
$strings['Change'] = 'Deðiþtir';

$strings['Update'] = 'Güncelle';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt Güncellemesi sadece 1.0.0 ve sonrasý için geçerlidir';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt zaten güncel';
$strings['Migrating reservations'] = 'Reservasyonlarý taþýyor';

$strings['Admin'] = 'Yönetici';
$strings['Manage Announcements'] = 'Manage Announcements';
$strings['There are no announcements'] = 'There are no announcements';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximum Participant Capacity';
$strings['Leave blank for unlimited'] = 'Leave blank for unlimited';
$strings['Maximum of participants'] = 'This resource has a maximum capacity of %s participants';
$strings['That reservation is at full capacity.'] = 'That reservation is at full capacity.';
$strings['Allow registered users to join?'] = 'Allow registered users to join?';
$strings['Allow non-registered users to join?'] = 'Allow non-registered users to join?';
$strings['Join'] = 'Join';
$strings['My Participation Options'] = 'My Participation Options';
$strings['Join Reservation'] = 'Join Reservation';
$strings['Join All Recurring'] = 'Join All Recurring';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'You are not participating on the following reservation dates because they are at full capacity.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'You are already invited to this reservation. Please follow participation instructions previously sent to your email.';
$strings['Additional Tools'] = 'Additional Tools';
$strings['Create User'] = 'Create User';
$strings['Check Availability'] = 'Check Availability';
$strings['Manage Additional Resources'] = 'Manage Additional Resources';
$strings['All Additional Resources'] = 'All Additional Resources';
$strings['Number Available'] = 'Number Available';
$strings['Unlimited'] = 'Unlimited';
$strings['Add Additional Resource'] = 'Add Additional Resource';
$strings['Edit Additional Resource'] = 'Edit Additional Resource';
$strings['Checking'] = 'Checking';
$strings['You did not select anything to delete.'] = 'You did not select anything to delete.';
$strings['Added Resources'] = 'Added Resources';
$strings['Additional resource is reserved'] = 'The additional resource %s only has %s available at a time';
$strings['All Groups'] = 'All Groups';
$strings['Group Name'] = 'Group Name';
$strings['Delete Groups'] = 'Delete Groups';
$strings['Manage Groups'] = 'Manage Groups';
$strings['None'] = 'None';
$strings['Group name is required.'] = 'Group name is required.';
$strings['Groups'] = 'Groups';
$strings['Current Groups'] = 'Current Groups';
$strings['Group Administration'] = 'Group Administration';
$strings['Reminder Subject'] = 'Reservation reminder- %s, %s %s';
$strings['Reminder'] = 'Reminder';
$strings['before reservation'] = 'before reservation';
$strings['My Participation'] = 'My Participation';
$strings['My Past Participation'] = 'My Past Participation';
$strings['Timezone'] = 'Timezone';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'Select reservations to export';
$strings['Export Format'] = 'Export Format';
$strings['This resource cannot be reserved less than x hours in advance'] = 'This resource cannot be reserved less than %s hours in advance';
$strings['This resource cannot be reserved more than x hours in advance'] = 'This resource cannot be reserved more than %s hours in advance';
$strings['Minimum Booking Notice'] = 'Minimum Booking Notice';
$strings['Maximum Booking Notice'] = 'Maximum Booking Notice';
$strings['hours prior to the start time'] = 'hours prior to the start time';
$strings['hours from the current time'] = 'hours from the current time';
$strings['Contains'] = 'Contains';
$strings['Begins with'] = 'Begins with';
$strings['Minimum booking notice is required.'] = 'Minimum booking notice is required.';
$strings['Maximum booking notice is required.'] = 'Maximum booking notice is required.';
$strings['Accessory Name'] = 'Accessory Name';
$strings['Accessories'] = 'Accessories';
$strings['All Accessories'] = 'All Accessories';
$strings['Added Accessories'] = 'Added Accessories';
// end since 1.2.0

/***
  EMAIL MESSAGES
  Please translate these email messages into your language.  You should keep the sprintf (%s) placeholders
   in their current position unless you know you need to move them.
  All email messages should be surrounded by double quotes "
  Each email message will be described below.
***/
// @since 1.1.0
// Email message that a user gets after they register
$email['register'] = "%s, %s \r\n"
				. "Aþaðýdaki bilgi ile baþarýyla kayýt oldunuz:\r\n"
				. "Giriþ: %s\r\n"
				. "Adý: %s %s \r\n"
				. "Telefon: %s \r\n"
				. "Bölüm: %s \r\n"
				. "Görev: %s \r\n\r\n"
				. "Rezervasyon için:\r\n"
				. "%s \r\n\r\n"
				. "Profilinizi denetim masasýndan güncelleþtirebilirsiniz.\r\n\r\n"
				. "Sorularýnýz için %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrator,\r\n\r\n"
				. "Yeni kullanýcý kaydoldu\r\n"
				. "Eposta: %s \r\n"
				. "Ad: %s %s \r\n"
				. "Telefon: %s \r\n"
				. "Bölüm: %s \r\n"
				. "Görev: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "You have successfully %s reservation #%s.\r\n\r\n<br/><br/>"
			. "Please use this reservation number when contacting the administrator with any questions.\r\n\r\n<br/><br/>"
			. "A reservation between %s %s and %s %s for %s"
			. " located at %s has been %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Bu rezervasyon aþaðýdaki tarihlerde tekrarlanacaktýr:\r\n<br/>";
$email['reservation_activity_3'] = "Bu gruptaki tüm tekrarlayan rezervasyonlarayný zamanda %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "rezervasyon özeti:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "<br/><br/>rezervasyonunuzu istediðiniz az deðiþtirebilirsiniz %s :\r\n<br/><a href=&quot;%s&quot; target=&quot;_blank&quot;>%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "teknik sorular için <a href=&quot;mailto:%s&quot;>%s</a>.\r\n\r\n<br/<br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Reservasyon #%s onaylandý.\r\n\r\n<br/><br/>"
			. "Sorularýnýzda rezervasyon numaranýzý belirtiniz.\r\n\r\n<br/><br/>"
			. "Rezervasyon %s %s and %s %s for %s"
			. " yeri %s  %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Sizin%s þifreniz admin tarafýndan sýfýrlandý.\r\n\r\nGeçici þifreniz:\r\n\r\n %s\r\n";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\nyeni parolanýz %s hesap:\r\n\r\n%s";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s sizi rezervasyonuna davet etti:\r\n\r\n"
		. "Kaynak: %s\r\n"
		. "Baþlangýç Tarihi: %s\r\n"
		. "Baþlangýç zamaný: %s\r\n"
		. "Bitiþ tarihi: %s\r\n"
		. "Bitiþ zamaný: %s\r\n"
		. "Özet: %s\r\n"
		. "Tekrarlayan günler (eðer varsa): %s\r\n\r\n"
		. "Daveti kabul etmek için bu köprüye týklayýnýz (iþaretlenmemiþse kopyala yapýþtýr yapabilirsiniz) %s\r\n"
		. "Daveti red etmek için (iþaretlenmemiþse kopyala yapýþtýr yapabilirsiniz) %s\r\n"
		. "Seçim günlerini kabul etmek ya da rezervasyonlarýnýzý yönetmek için, giriþ yapýnýz %s at %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Aþaðýdaki rezervasyondan kaldýrýldýnýz:\r\n\r\n"
		. "Kaynak: %s\r\n"
		. "Baþlangýç tarihi: %s\r\n"
		. "Baþlangýç zamaný: %s\r\n"
		. "Bitiþ tarihi: %s\r\n"
		. "Bitiþ zamaný: %s\r\n"
		. "Özet: %s\r\n"
		. "Tekrarlanan tarihler (eðer varsa): %s\r\n\r\n";	

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Your reservation for %s from %s %s to %s %s is approaching.";
?>