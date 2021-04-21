<label class="booked-checkbox {$class}" id="{$id}">
	<button name="{$name}" type="button" class="btn btn-xs btn-default" value=""><span style="width:10px;"
																								  class="glyphicon"></span>
	</button>
	{$label}
</label>

<script type="text/javascript">
	$(function ()
	{
		$('#{$id}').on('click', function (e)
		{
			var btn = $(this).find('button');
			if (btn.val() == 'true')
			{
				btn.find('span').removeClass('glyphicon-ok');
				btn.val('');
			}
			else
			{
				btn.find('span').addClass('glyphicon-ok');
				btn.val('true');
			}
			e.preventDefault();
			e.stopPropagation();
		});
	});
</script>
