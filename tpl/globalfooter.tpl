	</div><!-- close main-->

	<footer class="footer navbar">
		<a href="{$CompanyUrl}">{$CompanyName}</a> <br/><a href="https://github.com/librebooking/app">LibreBooking GPLv3 v{$Version}</a>

	</footer>

	<script type="text/javascript">
		init();
		$.blockUI.defaults.css.border = 'none';
		$.blockUI.defaults.css.top = '25%';

	</script>

	{if !empty($GoogleAnalyticsTrackingId)}
		<!-- Google tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id={$GoogleAnalyticsTrackingId}"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', '{$GoogleAnalyticsTrackingId}');
		</script>
	{/if}

	</body>
</html>
