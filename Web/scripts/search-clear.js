$('.searchclear').click(function(e) {
	e.preventDefault();
	e.stopPropagation();

	var ref = $(e.target).attr('ref');
	var refs = ref.split(',');
	_.each(refs, function(ref) {
		$('#' + ref).val('');
	});
});
