function ajaxPost(formElement, url, onBefore, onAfter) {
	$.ajax({
		type:'POST',
		data:formElement.serialize(),
		url:url,
		cache:false,
		beforeSend:function () {
			if (onBefore) {
				onBefore();
			}
		}
	}).done(function (data) {
				if (onAfter) {
					onAfter(data);
				}
			});
}

var ajaxGet = function (url, onBefore, onAfter) {
	$.ajax({
		type:'GET',
		url:url,
		cache:false,
		beforeSend:function () {
			if (onBefore) {
				onBefore();
			}
		}
	}).done(function (data) {
				if (onAfter) {
					onAfter(data);
				}
			});
};