	<table width="100%" border="0" cellspacing="0" cellpadding="5" class="mainBorder">
	  <tr>
		<td class="mainBkgrdClr">
		  <h4 class="welcomeBack"><?php echo translate('Welcome Back', array($_SESSION['sessionName'], 1))?></h4>
		  <p>
			<?php $this->link->doLink($this->dir_path . 'index.php?logout=true', translate('Log Out')) ?>
			|
			<?php $this->link->doLink($this->dir_path . 'ctrlpnl.php', translate('My Control Panel')) ?>
		  </p>
		</td>
		<td class="mainBkgrdClr" valign="top">
		  <div align="right">
		    <p>
			<?php echo translate_date('header', Time::getAdjustedTime(mktime()));?>
			</p>
			<p>
			  <?php  $this->link->doLink('javascript: help();', translate('Help')) ?>
			</p>
		  </div>
		</td>
	  </tr>
	</table>