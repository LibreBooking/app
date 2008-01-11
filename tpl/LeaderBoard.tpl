	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="header">
	  <tr>
		<td>
		  <img src="img/logo.gif"/>
		  <!--
		  <h4 class="welcomeBack">{translate key='Welcome Back' args=$UserName}</h4>	  
		  <p>
			{html_link href="$Path/index.php?logout=true" key="Log Out"}
			|
			{html_link href="$Path/ctrlpnl.php" key="My Control Panel"}
		  </p>
		  -->
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