	</div><!-- close main-->
	<div id="button-up" class="bg-primary rounded-circle text-white">
		<i class="bi bi-chevron-double-up" aria-hidden="true"></i>
	</div>
	<footer class="bg-light border-top text-center pt-2">
		<div><a class="link-primary" href="{$CompanyUrl}">{$CompanyName}</a></div>
		<div><a class="link-primary" href="https://github.com/LibreBooking/app">{$AppTitle} - GPLv3
				v{$Version}</a></div>
	</footer>

	<script type="text/javascript">
		init();
		$.blockUI.defaults.css.border = 'none';
		$.blockUI.defaults.css.top = '25%';
	</script>

	{if !empty($GoogleAnalyticsTrackingId)}
		{literal}
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
				})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
			{/literal}
			ga('create', '{$GoogleAnalyticsTrackingId}', 'auto');
			ga('set', 'anonymizeIp', true);
			ga('send', 'pageview');
		</script>
	{/if}

	</body>

</html>