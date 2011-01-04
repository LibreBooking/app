function checkForm(f) {
	var msg = "Please fix these errors:\n";
	var errors = false;
	
	if (f.fname.value == "") {
		msg+="-First name is required\n";
		errors = true;
	}
	if (f.lname.value == "") {
		msg+="-Last name is required\n";
		errors = true;
	}
	if (f.phone.value == "") {
		msg+="-Phone number is required\n";
		errors = true;
	}
	if (f.organization.value == "") {
		msg+="-Organization is required\n";
		errors = true;
	}
	if ( (f.email.value == "") || ( f.email.value.indexOf('@') == -1) ) {
		msg+="-Valid email is required\n";
		errors = true;
	}
	if (errors) {
		window.alert(msg);
		return false;
	}
		
	return true;
}

function verifyEdit() {
	var msg = "Please fix these errors:\n";
	var errors = false;
	
	if ( (document.register.email.value != "") && ( document.register.email.value.indexOf('@') == -1) ) {
		msg+="-Valid email is required\n";
		errors = true;
	}
	if ( (document.register.password.value != "") && (document.register.password.value.length < 6) ) {
		msg+="-Min 6 character password is required\n";
		errors = true;
	}
	if ( (document.register.password.value != "") && (document.register.password.value != document.register.password2.value) ) {
		msg+=("-Passwords do not match\n");
		errors = true;
	}
	if (errors) {
		window.alert(msg);
		return false;
	}
		
	return true;
}

function checkBrowser() {
	if ( (navigator.appName.indexOf("Netscape") != -1) && ( parseFloat(navigator.appVersion) <= 4.79 ) ) {
		newWin = window.open("","message","height=200,width=300");
		newWin.document.writeln("<center><b>This system is optimized for Netscape version 6.0 or higher.<br>" +
					"Please visit <a href='http://channels.netscape.com/ns/browsers/download.jsp' target='_blank'>Netscape.com</a> to obtain an update.");
		newWin.document.close();
	}
}

function help(file) {    
		window.open("help.php#" + file ,"","width=500,height=500,scrollbars");    
		void(0);    
}      

function reserve(type, machid, start_date, resid, scheduleid, is_blackout, read_only, pending, starttime, endtime) {  
		if (is_blackout == null) { is_blackout = 0; }
		
		if (is_blackout != 1) {
			w = (type == 'r' || type == 'm') ? 600 : 520;
			h = (type == 'm') ? 610 : 570;
		}
		else {
			w = (type == 'r') ? 600 : 425;
			h = (type == 'm') ? 460 : 420;
		}
		
		if (machid == null) { machid = ''; }
		if (start_date == null) { start_date = ''; }
		if (resid == null) { resid = ''; }
		if (scheduleid == null) { scheduleid = ''; }

		if (read_only == null) { read_only = ''; }
		if (pending == null) { pending = ''; }
		if (starttime == null) { starttime = ''; }
		if (endtime == null) { endtime = ''; }

		nurl = "reserve.php?type=" + type + "&machid=" + machid + "&start_date=" + start_date + "&resid=" + resid + '&scheduleid=' + scheduleid + "&is_blackout=" + is_blackout + "&read_only=" + read_only + "&pending=" + pending + "&starttime=" + starttime + "&endtime=" + endtime;    
		var resWindow = window.open(nurl,"reserve","width=" + w + ",height=" + h + ",scrollbars,resizable=no,status=no");     
		resWindow.focus();
		void(0);   
}

function checkDate() {
	var formStr = document.getElementById("jumpWeek");
	
	var month = document.getElementById("jumpMonth").value;
	var day = document.getElementById("jumpDay").value;
	var year = document.getElementById("jumpYear").value;
	
	var dayNum = new Array();
	if ( year%4 == 0 ) {
		dayNum = [31,29,31,30,31,30,31,31,30,31,30,31];
	} 
	else {
		dayNum = [31,28,31,30,31,30,31,31,30,31,30,31];
	}
	
	if ( (month > 12) || (day > dayNum[month-1]) ) {
		alert("Please enter valid date value");
		return false;
	}
	
	for (var i=0; i < formStr.childNodes.length-1; i++) {
		if (formStr.childNodes[i].type == "text" || formStr.childNodes[i].type == "textbox" ) {			
			if ( (formStr.childNodes[i].value <= 0) || (formStr.childNodes[i].value.match(/\D+/) != null) ) {
					alert("Please enter valid date value");
					formStr.childNodes[i].focus();
					return false;
			}
		}
	}
	
	changeScheduler(month, day, year, 0, "");
}

function verifyTimes(f) {
	if (f.del && f.del.checked) {
		return confirm("Delete this reservation?");
	}
	if (parseFloat(f.starttime.value) < parseFloat(f.endtime.value)) {
		return true;
	}
	else {
		window.alert("End time must be later than start time\nCurrent start time: " + f.starttime.value + " Current end time: " + f.endtime.value);
		return false;
	}
}

function checkAdminForm() {
	var f = document.forms[0];
	for (var i=0; i< f.elements.length; i++) {
		if ( (f.elements[i].type == "checkbox") && (f.elements[i].checked == true) )
			return confirm('This will delete all reservations and permission information for the checked items!\nContinue?');
	}
	alert("No boxes have been checked!");	
	return false;
}

function checkBoxes() {
	var f = document.train;
	for (var i=0; i< f.elements.length; i++) {
		if (f.elements[i].type == "checkbox")
			f.elements[i].checked = true;
	}
	void(0);
}

function viewUser(user) {
	window.open("userInfo.php?user="+user,"UserInfo","width=400,height=400,scrollbars,resizable=no,status=no");     
		void(0);    
}

function checkAddResource(f) {
	var msg = "";
	minres = (parseInt(f.minH.value) * 60) + parseInt(f.minM.value);
	maxRes = (parseInt(f.maxH.value) * 60) + parseInt(f.maxM.value);
	
	if (f.name.value=="")
		msg+="-Resource name is required.\n";
	if (parseInt(minres) > parseInt(maxRes))
		msg+="-Minimum reservaion time must be less than or equal to maximum";
	if (msg!="") {
		alert("You have the following errors:\n\n"+msg);
		return false;
	}
	
	return true;
}

function checkAddSchedule() {
	var f = document.addSchedule;
	var msg = "";
	
	if (f.scheduletitle.value=="")
		msg+="-Schedule title is required.\n";
	if (parseInt(f.daystart.value) > parseInt(f.dayend.value))
		msg+="-Invalid start/end times.\n";
	if (f.viewdays.value == "" || parseInt(f.viewdays.value) <= 0)
		msg+="Invalid view days.\n";
	if (f.adminemail.value == "")
		msg+="Admin email is required.\n";

	if (msg!="") {
		alert("You have the following errors:\n\n"+msg);
		return false;
	}
	
	return true;
}

function checkAllBoxes(box) {
    var f = document.forms[0];
	
	for (var i = 0; i < f.elements.length; i++) {
		if (f.elements[i].type == "checkbox" && f.elements[i].name != "notify_user")
			f.elements[i].checked = box.checked;
	}

	void(0);
}

function check_reservation_form(f) {
	
	var recur_ok = false;
	var days_ok = false;
	var is_repeat = false;
	var msg = "";
	
	if ((typeof f.interval != 'undefined') && f.interval.value != "none") {
		is_repeat = true;
		if (f.interval.value == "week" || f.interval.value == "month_day") {
			for (var i=0; i < f.elements["repeat_day[]"].length; i++) {
				if (f.elements["repeat_day[]"][i].checked == true)
					days_ok = true;
			}
		}
		else {
			days_ok = true;
		}
		
		if (f.repeat_until.value == "") {
			msg += "- Please choose an ending date\n";
			recur_ok = false;
		}
	}
	else {
		recur_ok = true;
		days_ok = true;
	}
	
	if (days_ok == false) {
		recur_ok = false;
		msg += "- Please select days to repeat on";
	}
	
	if (msg != "")
		alert(msg);
		
	return (msg == "");
}

function check_for_delete(f) {
	if (f.del && f.del.checked == true)
		return confirm('Delete this reservation?');
}

function toggle_fields(box) {
	document.forms[0].elements["table," + box.value + "[]"].disabled = (box.checked == true) ? false : "disabled";
}

function search_user_lname(letter) {
	var frm = isIE() ? document.name_search : document.forms['name_search'];
	frm.firstName.value = "";
	frm.lastName.value=letter;
	frm.submit();
}

function isIE() {
	return document.all;
}

function changeDate(month, year) {
	var frm = isIE() ? document.changeMonth : document.forms['changeMonth'];
	frm.month.value = month;
	frm.year.value = year;
	frm.submit();
}

// Function to change the Scheduler on selected date click
function changeScheduler(m, d, y, isPopup, scheduleid) {
	newDate = m + '-' + d + '-' + y;
	keys = new Array();
	vals = new Array();

	// Get everything up to the "?" (if it even exists)
	var queryString = (isPopup) ? window.opener.document.location.search.substring(0): document.location.search.substring(0);
	queryString = queryString.replace("?", "");

	var pairs = queryString.split('&');
	var url = (isPopup) ? window.opener.document.URL.split('?')[0] : document.URL.split('?')[0];
	var schedid = ""
	
	if (scheduleid == "") {
		for (var i=0;i<pairs.length;i++)
		{
			var pos = pairs[i].indexOf('=');
			if (pos >= 0)
			{
				var argname = pairs[i].substring(0,pos);
				var value = pairs[i].substring(pos+1);
				keys[keys.length] = argname;
				vals[vals.length] = value;		
			}
		}
		
		for (i = 0; i < keys.length; i++) {
			if (keys[i] == "scheduleid") {
				schedid = vals[i];
			}
		}
	}
	else {
		schedid	= scheduleid;
	}
	
	if (isPopup)
		window.opener.location = url + "?date=" + newDate + "&scheduleid=" + schedid;
	else
		document.location.href = url + "?date=" + newDate + "&scheduleid=" + schedid;
}

function showsummary(object, e, text) {
	myLayer = document.getElementById(object);
	myLayer.innerHTML = text;
	
	w = parseInt(myLayer.style.width);
	h = parseInt(myLayer.style.height);

    if (e != '') {
        if (isIE()) {
        	x = e.clientX;
            y = e.clientY;
            browserX = document.body.offsetWidth - 25;
            x += document.body.scrollLeft;			// Adjust for scrolling on IE
    		y += document.body.scrollTop;
        }
        if (!isIE()) {
            x = e.pageX;
            y = e.pageY;
            browserX = window.innerWidth - 35;
       }
    }
	
	x1 = x + 20;		// Move out of mouse pointer
	y1 = y + 20;
	
	// Keep box from going off screen
	if (x1 + w > browserX) {
		x1 = browserX - w;
	}
    
    myLayer.style.left = parseInt(x1)+ "px";
    myLayer.style.top = parseInt(y1) + "px";
	myLayer.style.visibility = "visible";
}

function getAbsolutePosition(element) {
    var r = { x: element.offsetLeft, y: element.offsetTop };
    if (element.offsetParent) {
      var tmp = getAbsolutePosition(element.offsetParent);
      r.x += tmp.x;
      r.y += tmp.y;
    }
    return r;
  };

function moveSummary(object, e) {

	myLayer = document.getElementById(object);
	w = parseInt(myLayer.style.width);
	h = parseInt(myLayer.style.height);

    if (e != '') {
        if (isIE()) {
            x = e.clientX;
            y = e.clientY;
			browserX = document.body.offsetWidth -25;
			x += document.body.scrollLeft;
			y += document.body.scrollTop;
        }
        if (!isIE()) {
            x = e.pageX;
            y = e.pageY;
			browserX = window.innerWidth - 30;
        }
    }

	x1 = x + 20;	// Move out of mouse pointer	
	y1 = y + 20;
	
	// Keep box from going off screen
	if (x1 + w > browserX)
		x1 = browserX - w;

    myLayer.style.left = parseInt(x1) + "px";
    myLayer.style.top = parseInt(y1) + "px";
}

function hideSummary(object) {
	myLayer = document.getElementById(object);
	myLayer.style.visibility = 'hidden';
}

function resOver(cell, color) {
	hiliteResource(cell.parentNode, "resourceNameOver");
	cell.style.backgroundColor = color;
	cell.style.cursor='pointer'
}

function resOut(cell, color) {
	hiliteResource(cell.parentNode, "resourceName");
	cell.style.backgroundColor = color;
}

function blankOver(cell) {
	hiliteResource(cell.parentNode, "resourceNameOver");
	cell.className = "reservationOver";
	cell.style.cursor='pointer'
}

function blankOut(cell, _class) {
	hiliteResource(cell.parentNode, "resourceName");
	cell.className = _class;
}

function hiliteResource(parent, _class) {
	var index = isIE() ? 0 : 1;
	parent.childNodes[index].className = _class;
}

function showHideDays(opt) {
	e = document.getElementById("days");
	
	if (opt.options[2].selected == true || opt.options[4].selected == true) {
		e.style.visibility = "visible";
		e.style.display = isIE() ? "inline" : "table";
	}
	else {
		e.style.visibility = "hidden";
		e.style.display = "none";
	}
	
	e = document.getElementById("week_num")
	if (opt.options[4].selected == true) {
		e.style.visibility = "visible";
		e.style.display = isIE() ? "inline" : "table";
	}
	else {
		e.style.visibility = "hidden";
		e.style.display = "none";
	}
}

function chooseDate(input_box, m, y) {
	var file = "recurCalendar.php?m=" + m + "&y="+ y;
	if (isIE()) {
		yVal = "top=" + 200;
		xVal = "left=" + 500;
	}
	if (!isIE()) {
		yVal = "screenY=" + 200;
		xVal = "screenX=" + 500
	}
	window.open(file, "calendar",yVal + "," + xVal + ",height=270,width=220,resizable=no,status=no,menubar=no");
	void(0);
}

function selectRecurDate(m, d, y, isPopup) {
	f = window.opener.document.forms[0];
	f._repeat_until.value = m + "/" + d + "/" + y;
	f.repeat_until.value = f._repeat_until.value;
	window.close();
}

function setSchedule(sid) {
	f = document.getElementById("setDefaultSchedule");
	f.scheduleid.value = sid;
	f.submit();
}

function changeSchedule(sel) {
	var url = document.URL.split('?')[0];
	document.location.href = url + "?scheduleid=" + sel.options[sel.selectedIndex].value;
}

function showHideCpanelTable(element) {
	var expires = new Date();
	var time = expires.getTime() + 2592000000;
	expires.setTime(time);
	var showHide = "";
	if (document.getElementById(element).style.display == "none") {
		document.getElementById(element).style.display='block';
		showHide = "show";
	} else {
		document.getElementById(element).style.display='none';
		showHide = "hide";
	}
	
	document.cookie = element + "=" + showHide + ";expires=" + expires.toGMTString();
}

function changeLanguage(opt) {
	var expires = new Date();
	var time = expires.getTime() + 2592000000;
	expires.setTime(time);
	document.cookie = "lang=" + opt.options[opt.selectedIndex].value + ";expires=" + expires.toGMTString() + ";path=/";
	document.location.href = document.URL;
}

function clickTab(tabid, panel_to_show) {
	document.getElementById(tabid.getAttribute("id")).className = "tab-selected";
	rows = document.getElementById("tab-container").getElementsByTagName("td");
	for (i = 0; i < rows.length; i++) {
		if (rows[i].className == "tab-selected" && rows[i] != tabid) {
			rows[i].className = "tab-not-selected";
		}
	}

	div_to_display = document.getElementById(panel_to_show);
	div_to_display.style.display = isIE() ? "block" : "table";
	divs = document.getElementById("main-tab-panel").getElementsByTagName("div");

	for (i = 0; i < divs.length; i++) {
		// only hide panels with prefix "pnl"
		if (divs[i] != div_to_display && divs[i].getAttribute("id").substring(0,3) == "pnl") {
			divs[i].style.display = "none";
		}
	}
}

function checkCalendarDates() {
	var table = document.getElementById("repeat_table");
	if (table == null) return;
	
	// If the start/end date are not equal, hide the whole repeat section
	if (document.getElementById("hdn_start_date").value != document.getElementById("hdn_end_date").value) {
		table.style.display = "none";
		table.style.visibility = "hidden";	
	}
	else {
		table.style.display = isIE() ? "inline" : "table";
		table.style.visibility = "visible";
	}
}

function showHideMinMax(chk) {
	document.getElementById("minH").disabled = document.getElementById("minM").disabled = document.getElementById("maxH").disabled = document.getElementById("maxM").disabled= chk.checked
}

function moveSelectItems(from, to) {
	from_select = document.getElementById(from);
	to_select = document.getElementById(to);
	
	for (i = 0; i < from_select.options.length; i++) {
		if (from_select.options[i].selected) {
			if (isIE()) {
				var option = new Option(from_select.options[i].text, from_select.options[i].value);
				to_select.options.add(option);
				from_select.options.remove(i);
				to_select.options[0].selected = true;
			}
			else {
				to_select.options.add(from_select.options[i]);
			}
			i--;	
		}
	}
}

function selectAllOptions(button) {
	var form = button.form;
	var i;
	
	for (i = 0; i < form.elements.length; i++) {
		if (form.elements[i].type == "select-multiple" && form.elements[i].multiple == true) {
			selectbox = form.elements[i];
			for (j = 0; j < selectbox.options.length; j++) {
				selectbox.options[j].selected = true;
			}
		}
	}
}

function changeMyCal(m, d, y, view) {
	var url = document.URL.split('?')[0];
	document.location.href = url + "?date=" + m + "-" + d + "-" + y + "&view=" + view;
}

function changeResCalendar(m, d, y, view, id) {
	var url = document.URL.split('?')[0];
	var type_id = id.split("|");
	var type = type_id[0];
	var p = (type == "s") ? "scheduleid" : "machid";
	var id = type_id[1];
	document.location.href = url + "?date=" + m + "-" + d + "-" + y + "&view=" + view + "&" + p + "=" + id;
}

function selectUserForReservation(memberid, fname, lname, email) {
	var doc = window.opener.document
	doc.forms[0].memberid.value = memberid;
	doc.getElementById('name').innerHTML = fname + " " + lname;
	doc.getElementById('phone').innerHTML = "";
	doc.getElementById('email').innerHTML = email;
	window.close();
}

function adminRowClick(checkbox, row_id, count) {
	var row = document.getElementById(row_id);
	row.className = (checkbox.checked) ? "adminRowSelected" : "cellColor" + (count%2);
}

function showHide(element) {
	if (document.getElementById(element).style.display == "none") {
		document.getElementById(element).style.display='block';
	}
	else {
		document.getElementById(element).style.display='none';
	}
}

function submitJoinForm(isLoggedIn) {
	var loggedIn = (isLoggedIn != 0);
	var f = document.getElementById("join_form");
	f.h_join_fname.value = (!loggedIn) ? document.getElementById("join_fname").value : "";
	f.h_join_lname.value = (!loggedIn) ? document.getElementById("join_lname").value : "";
	f.h_join_email.value = (!loggedIn) ? document.getElementById("join_email").value : "";
	f.h_join_userid.value= (loggedIn) ? document.getElementById("join_userid").value : "";
	f.h_join_resid.value = document.getElementById("resid").value;
	f.submit();
}

function validateReservationWindow() {
	document.getElementById("check").style.display = "inline";
	var f = document.getElementById("reserve");
	f.target = "check";
	f.submit();
}

function createXMLDoc() {
	var xmlDoc = null;
	if (document.implementation && document.implementation.createDocument)
	{
		xmlDoc = document.implementation.createDocument("", "", null);
	}
	else if (window.ActiveXObject)
	{
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
 	}
	
	return xmlDoc;
}

function getOption(opt) {
	if (isIE()) {
		return new Option(opt.text, opt.value);
	}
	else {
		return opt;
	}
}

function popGroupEdit(memberid) {
	window.open("group_edit.php?edit=1&memberid=" + memberid, "groups","height=250,width=470,resizable=no,status=no,menubar=no");
	void(0);
}

function popGroupView(memberid) {
	window.open("group_edit.php?edit=0&memberid=" + memberid, "groups","height=250,width=470,resizable=no,status=no,menubar=no");
	void(0);
}

function showHere(parent, id) {
	var element = document.getElementById(id);
	var x;
	var y;
	
	var offset = getOffset(parent);
	x = offset[0];
	y = offset[1];
	element.style.left = parseInt(x) + "px";
    element.style.top = parseInt(y - 34) + "px";
	element.style.display = "inline";
}

function getOffset(obj) {
	var curLeft = 0;
	var curTop = 0;
	
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curLeft += obj.offsetLeft
			curTop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	}
	else if (obj.x) {
		curLeft += obj.x;
		curTop += obj.y;
	}
	
	return new Array(curLeft, curTop);
}

function switchStyle(obj, style) {
	obj.className = style;
}

function openExport(type, id, start, end) {
	var qs = 'type=' + type;
	
	if (id.length > 0) {
		qs += "&resid=" + id;
	}
	else {
		if (start.length > 0) {
			qs += "&start_date=" + start; 	
		}
		if (end.length >0) {
			qs += "&end_date=" + end;	
		}
	}
	
	window.open("exports/ical.php?" + qs);
}

function exportSearch() {
	var _type = document.getElementById("type");
	var type = _type[_type.selectedIndex].value;
	
	var start = document.getElementById("nostart").checked ? '' : document.getElementById("hdn_start_date").value;
	var end = document.getElementById("noend").checked ? '' : document.getElementById("hdn_end_date").value;
	
	openExport(type, '', start, end);
}

function blurDiv(checkbox, divid) {
	document.getElementById(divid).className = checkbox.checked ? "blur_textbox" : "textbox";
}