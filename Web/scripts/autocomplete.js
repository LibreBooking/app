$.fn.userAutoComplete = function(url, selectionCallback)
{
	var textbox = $(this);

	textbox.autocomplete(
		{
			source: function(request, response) {
				$.ajax({
					url: url,
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data) {
						response($.map(data, function(item) {
							var l = item.Name;
							if (item.Email)
							{
								l += " (" + item.Email + ")";
							}
							return {
								label: l,
								value: item.Id
							}
						}));
					}
				});
			},
			focus: function(event, ui) {
				textbox.val(ui.item.label);
				return false;
			},
			select: function(event, ui) {
				if (selectionCallback != undefined)
				{
					selectionCallback(ui, textbox);
					//textbox.val('');
				}
				else
				{
					textbox.val(ui.item.label);
				}

				return false;
			}
		});
}