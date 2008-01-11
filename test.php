<?php
//require_once 'lib/pear/Date.php';
//$tz = new Date_TimeZone("");
$timezone_abbreviations = DateTimeZone::listAbbreviations  ();
echo '<pre>';
//print_r($tz->getAvailableIDs());

//echo date_default_timezone_get() . "\n";
//echo 'chicago? ' . timezone_name_from_abbr("", -21600, 0) . "\n";
//echo 'chicago? ' . timezone_name_from_abbr("", -18000, 1) . "\n";
//
//
//$createtz = date_default_timezone_get(); // 'GMT'
//$dateSrc = date('Y-m-d H:i:s');
//$dateTime = new DateTime($dateSrc, new DateTimeZone($createtz));
//$dateTime->setTimeZone(new DateTimeZone(date_default_timezone_get()));
//echo 'DateTime::format(): '.$dateTime->format('H:i:s') . "\n";

$gmt = new DateTime(strtotime(time()), new DateTimeZone('GMT'));
//echo $gmt->format('d/m/Y H:i:s a');
print_r(date_parse($gmt->format(DATE_ISO8601)));
echo '<br/>';

$local = new DateTime(strtotime(time()), new DateTimeZone('US/Central'));
//echo $local->format('d/m/Y H:i:s a');

print_r(date_parse($local->format(DATE_ISO8601)));

echo '<br/>';
echo date('d/m/Y H:i:s a', gmmktime());

//print_r(DateTimeZone::listIdentifiers());
//print_r($timezone_abbreviations);

//print_r(array_keys($timezone_abbreviations));
//
//foreach($timezone_abbreviations as $tz)
//{
//	//$idx = $tz[0]['offset'] / 3600 . "";
//	$all[] = $tz[0]['timezone_id'];
//}
//
//$all = array_unique($all);
//sort($all);
//print_r($all);
echo '</pre>';


//
//A 	
//ACDT 	
//ACST 	
//ADT 	
//AEDT 	
//AEST 	
//AKDT 	
//AKST 	
//AST 	
//AWST 	
//B 	
//BST 	
//C 	
//CDT 	
//CDT 	
//CEDT 	
//CEST 	
//CET 	
//CST 	
//CST 	
//CXT 	
//D 	
//E 	
//EDT 	
//EDT 	
//EEDT 	
//EEST 	
//EET 	
//EST 	
//EST 	
//F 	
//G 	
//GMT 	
//H 	
//HAA 	
//HAC 	
//HADT 	
//HAE 	
//HAP 	
//HAR 	
//HAST 	
//HAT 	
//HAY 	
//HNA 	
//HNC 	
//HNE 	
//HNP 	
//HNR 	
//HNT 	
//HNY 	
//I 	
//IST 	
//K 	
//L 	
//M 	
//MDT 	
//MESZ 	
//MEZ 	
//MST 	
//N 	
//NDT 	
//NFT 	
//NST 	
//O 	
//P 	
//PDT 	
//PST 	
//Q 	
//R 	
//S 	
//T 	
//U 	
//UTC 	
//V 	
//W 	
//WEDT 	
//WEST 	
//WET 	
//WST 	
//X 	
//Y 	
//Z 	
//$con = mysql_connect('.', 'schedule_user', 'password') or die(mysql_error())
?>