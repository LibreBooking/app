var http_request = null;

function createRequestObject() {
	var request_obj = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		request_obj = new XMLHttpRequest();
		if (request_obj.overrideMimeType) {
			request_obj.overrideMimeType('text/xml');
		}
	}
	else if (window.ActiveXObject) { // IE
		try {
			request_obj = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				request_obj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
		}
	}

	return request_obj;
}

function checkReservation(url, formid, txt) {
	var div = document.getElementById("checkDiv");
	var f = document.getElementById(formid);
	
	http_request = createRequestObject();	
	http_request.onreadystatechange = showCheckResults;
	http_request.open('POST', url + document.location.search.substring(0), true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	
	div.style.textAlign = "center";
	div.style.display = "inline";
	div.innerHTML = "<h4>" + txt + "..." + "</h4>";
	
	var keyValue = "";
	keyValue = buildKeyValueString(f, keyValue);

	http_request.send(keyValue);
}

function buildKeyValueString(f, keyValue) {
	for (var i = 0; i < f.elements.length; i++) {
		if (f.elements[i].name == "") { continue; }
		if (f.elements[i].type=="select-multiple") {
			for (var o = 0; o < f.elements[i].options.length; o++) {
				keyValue += f.elements[i].name + "=" + f.elements[i].options[o].value + "&";
			}
		}
		else if (f.elements[i].type=="checkbox" && f.elements[i].name.indexOf("[]",0) >= 0){
			if (f.elements[i].checked) {
				keyValue += f.elements[i].name + "=" + f.elements[i].value + "&";
			}
		}
		else {
			keyValue += f.elements[i].name + "=" + f.elements[i].value + "&";
		}
	}
	
	return keyValue;
}

function showCheckResults() {
	if (http_request.readyState == 4) {
		var txt = "";
		var div = document.getElementById("checkDiv");
	
		if (http_request.status == 200) {
			div.style.textAlign = "left";
			txt = http_request.responseText;
		}
		else {
			txt = "Error checking reservations";
		}
		
		div.innerHTML = txt;		
	}
}