{\rtf1\mac\ansicpg10000\cocoartf824\cocoasubrtf410
{\fonttbl\f0\fswiss\fcharset77 Helvetica;}
{\colortbl;\red255\green255\blue255;}
\margl1440\margr1440\vieww16880\viewh15660\viewkind0
\pard\tx566\tx1133\tx1700\tx2267\tx2834\tx3401\tx3968\tx4535\tx5102\tx5669\tx6236\tx6803\ql\qnatural\pardirnatural

\f0\fs24 \cf0 // ** I18N\
\
// Calendar EN language\
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>\
// Encoding: any\
// Distributed under the same terms as the calendar itself.\
\
// For translators: please use UTF-8 if possible.  We strongly believe that\
// Unicode is the answer to a real internationalized world.  Also please\
// include your contact information in the header, as can be seen above.\
\
// full day names\
Calendar._DN = new Array\
("s&ouml;ndag",\
 "m&aring;ndag",\
 "tisdag",\
 "onsdag",\
 "torsdag",\
 "fredag",\
 "l&ouml;rdag",\
 "s&ouml;ndag");\
\
// Please note that the following array of short day names (and the same goes\
// for short month names, _SMN) isn't absolutely necessary.  We give it here\
// for exemplification on how one can customize the short day names, but if\
// they are simply the first N letters of the full name you can simply say:\
//\
//   Calendar._SDN_len = N; // short day name length\
//   Calendar._SMN_len = N; // short month name length\
//\
// If N = 3 then this is not needed either since we assume a value of 3 if not\
// present, to be compatible with translation files that were written before\
// this feature.\
\
// short day names\
Calendar._SDN = new Array\
("S&ouml;n",\
 "M&aring;n",\
 "Tis",\
 "Ons",\
 "Tor",\
 "Fre",\
 "L&ouml;r",\
 "S&ouml;n");\
\
// First day of the week. "0" means display Sunday first, "1" means display\
// Monday first, etc.\
Calendar._FD = 0;\
\
// full month names\
Calendar._MN = new Array\
("januari",\
 "februari",\
 "mars",\
 "april",\
 "maj",\
 "juni",\
 "juli",\
 "augusti",\
 "september",\
 "oktober",\
 "november",\
 "december");\
\
// short month names\
Calendar._SMN = new Array\
("Jan",\
 "Feb",\
 "Mar",\
 "Apr",\
 "Maj",\
 "Jun",\
 "Jul",\
 "Aug",\
 "Sep",\
 "Okt",\
 "Nov",\
 "Dec");\
\
// tooltips\
Calendar._TT = \{\};\
Calendar._TT["INFO"] = "Om kalendern";\
\
Calendar._TT["ABOUT"] =\
"DHTML Datum/tid-v\'8aljare\\n" +\
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\\n" + // don't translate this this ;-)\
"F\'9ar senaste version g\'8c till: http://www.dynarch.com/projects/calendar/\\n" +\
"Distribueras under GNU LGPL.  Se http://gnu.org/licenses/lgpl.html f\'9ar detaljer." +\
"\\n\\n" +\
"Val av datum:\\n" +\
"- Anv\'8and knapparna \\xab, \\xbb f\'9ar att v\'8alja \'8cr\\n" +\
"- Anv\'8and knapparna " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " f\'9ar att v\'8alja m\'8cnad\\n" +\
"- H\'8cll musknappen nedtryckt p\'8c n\'8cgon av ovanst\'8cende knappar f\'9ar snabbare val.";\
Calendar._TT["ABOUT_TIME"] = "\\n\\n" +\
"Val av tid:\\n" +\
"- Klicka p\'8c en del av tiden f\'9ar att \'9aka den delen\\n" +\
"- eller skift-klicka f\'9ar att minska den\\n" +\
"- eller klicka och drag f\'9ar snabbare val.";\
\
Calendar._TT["PREV_YEAR"] = "F&ouml;reg. &aring;r (h&aring;ll f&ouml;r meny)";\
Calendar._TT["PREV_MONTH"] = "F&ouml;reg. m&aring;n (h&aring;ll f&ouml;r meny)";\
Calendar._TT["GO_TODAY"] = "Go Today";\
Calendar._TT["NEXT_MONTH"] = "N&auml;sta m&aring;nad (h&aring;ll f&ouml;r meny)";\
Calendar._TT["NEXT_YEAR"] = "N&auml;sta &aring;r (h&aring;ll f&ouml;r meny)";\
Calendar._TT["SEL_DATE"] = "V&auml;lj datum";\
Calendar._TT["DRAG_TO_MOVE"] = "Dra f&ouml;r att flytta";\
Calendar._TT["PART_TODAY"] = " (idag)";\
\
// the following is to inform that "%s" is to be the first day of week\
// %s will be replaced with the day name.\
Calendar._TT["DAY_FIRST"] = "Visa %s f&ouml;rst";\
\
// This may be locale-dependent.  It specifies the week-end days, as an array\
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1\
// means Monday, etc.\
Calendar._TT["WEEKEND"] = "0,6";\
\
Calendar._TT["CLOSE"] = "St&auml;ng";\
Calendar._TT["TODAY"] = "Idag";\
Calendar._TT["TIME_PART"] = "(Skift-)klicka eller drag f&ouml;r att &auml;ndra tid";\
\
// date formats\
Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";\
Calendar._TT["TT_DATE_FORMAT"] = "%A %d %b %Y";\
\
Calendar._TT["WK"] = "vecka";\
Calendar._TT["TIME"] = "Tid:";}
