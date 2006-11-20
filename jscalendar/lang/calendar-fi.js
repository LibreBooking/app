// ** I18N

// Calendar EN language
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
// Encoding: any
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Calendar._DN = new Array
("Sunnuntai",
 "Maanantai",
 "Tiistai",
 "Keskiviikko",
 "Torstai",
 "Perjantai",
 "Lauantai",
 "Sunnuntai");

// Please note that the following array of short day names (and the same goes
// for short month names, _SMN) isn't absolutely necessary.  We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
//   Calendar._SDN_len = N; // short day name length
//   Calendar._SMN_len = N; // short month name length
//
// If N = 3 then this is not needed either since we assume a value of 3 if not
// present, to be compatible with translation files that were written before
// this feature.

// short day names
Calendar._SDN = new Array
("Su",
 "Ma",
 "Ti",
 "Ke",
 "To",
 "Pe",
 "La",
 "Su");

// First day of the week. "0" means display Sunday first, "1" means display
// Monday first, etc.
Calendar._FD = 1;

// full month names
Calendar._MN = new Array
("Tammikuu",
 "Helmikuu",
 "Maaliskuu",
 "Huhtikuu",
 "Toukokuu",
 "Kes‰kuu",
 "Hein‰kuu",
 "Elokuu",
 "Syyskuu",
 "Lokakuu",
 "Marraskuu",
 "Joulukuu");

// short month names
Calendar._SMN = new Array
("Tam",
 "Hel",
 "Maa",
 "Huh",
 "Tou",
 "Kes",
 "Hei",
 "Elo",
 "Syy",
 "Lok",
 "Mar",
 "Jou");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "Tietoa ohjelmasta";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"For latest version visit: http://www.dynarch.com/projects/calendar/\n" +
"Distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"P‰iv‰m‰‰r‰ valinta:\n" +
"- K‰yt‰ \xab, \xbb painikkeita valitaksesi vuosi\n" +
"- K‰yt‰ " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " painikkeita valitaksesi kuukausi\n" +
"- Pit‰m‰ll‰ hiiren painiketta mink‰ tahansa yll‰ olevan painikkeen kohdalla, saat n‰kyviin valikon nopeampaan siirtymiseen.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Ajan valinta:\n" +
"- Klikkaa ajanjaksoa pident‰‰ksesi aikaa\n" +
"- tai vaihto+klikkaa v‰hent‰‰ksesi\n" +
"- tai paina ja ved‰ nopea valinta.";

Calendar._TT["PREV_YEAR"] = "Edell. vuosi (paina hetki, n‰et valikon)";
Calendar._TT["PREV_MONTH"] = "Edell. kuukausi (paina hetki, n‰et valikon)";
Calendar._TT["GO_TODAY"] = "Siirry t‰h‰n p‰iv‰‰n";
Calendar._TT["NEXT_MONTH"] = "Seur. kuukausi (paina hetki, n‰et valikon)";
Calendar._TT["NEXT_YEAR"] = "Seur. vuosi (paina hetki, n‰et valikon)";
Calendar._TT["SEL_DATE"] = "Valitse p‰iv‰m‰‰r‰";
Calendar._TT["DRAG_TO_MOVE"] = "Siirr‰ kalenterin paikkaa";
Calendar._TT["PART_TODAY"] = " (t‰n‰‰n)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Calendar._TT["DAY_FIRST"] = "N‰yt‰ %s ensimm‰isen‰";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "Sulje";
Calendar._TT["TODAY"] = "T‰n‰‰n";
Calendar._TT["TIME_PART"] = "(Shift-) Klikkaa tai liikuta muuttaaksesi aikaa";


// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%d.%m.%Y";
Calendar._TT["TT_DATE_FORMAT"] = "%d.%m.%Y";

Calendar._TT["WK"] = "Vko";
Calendar._TT["TIME"] = "Kello:";

