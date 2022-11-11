	</div><!-- close main-->

	<nav class="navbar bottom bg-light border-top">
		<div class="container-fluid">
			<div class="row center">
				<div class="col">
					<a class="nav-link" href="{$CompanyUrl}">{$CompanyName}</a><a class="nav-link" href="https://github.com/effgarces/BookedScheduler">{$AppTitle} - GPLv3 v{$Version}</a>
				</div>
	  	</div>
		</div>
	</nav>


	<script type="text/javascript">
		init();
		$.blockUI.defaults.css.border = 'none';
		$.blockUI.defaults.css.top = '25%';

	</script>

	{if !empty($GoogleAnalyticsTrackingId)}
		{literal}
			<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  {/literal}
			  ga('create', '{$GoogleAnalyticsTrackingId}', 'auto');
              ga('set', 'anonymizeIp', true);
			  ga('send', 'pageview');
			</script>
	{/if}

	</body>
</html>
