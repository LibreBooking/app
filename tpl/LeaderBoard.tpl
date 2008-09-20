<table width="100%" border="0" cellspacing="0" cellpadding="0" id="header">
	  <tr>
		<td>
		  <img src="img/logo.gif" alt="phpScheduleIt"/>
		</td>
		<td style="width:100%;vertical-align:bottom;">
		  {if $DisplayWelcome eq 'true'}
			  <!--<h4 class="welcomeBack">{translate key='Welcome Back' args=$UserName}</h4>--> 
			  <p>
				{html_link href="bookings.php" key="Bookings"}
				|
				{html_link href="dashboard.php" key="MyDashboard"}
				|
				{html_link href="logout.php" key="Log Out"}
			  </p>
		  {/if}
		</td>
		<td>
		  <div align="right">
		    <p>				
			<?php echo translate_date('header', Time::getAdjustedTime(mktime()));?>
			</p>
			<p>
			  {html_link href="javascript: help();" key="Help"}
			</p>
		  </div>
		</td>
	  </tr>
	</table>