<html>
  <head>
    <title>Configuration Setup Page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    {*<style>#configSetupDiv {font-size:11pt;}</style>*}
  </head>
  <body>
   <div id="wrapper">
    <div id="content">
    <form name="configSetupForm" action="configSetupWriteForm.php" method="post">
    <div id="configSetupDiv">
        <h1>System Settings <input type="submit" class="button" value="Submit Page Changes" /> </h1>
        Installation password (optional, default is empty): 
			<input type="text" name="installPass" class="textbox" size="50" value="<?php echo htmlentities($conf['settings']['install.password'], ENT_QUOTES); ?>"><br />
    	Enter the URL of your site: 
			<input type="text" name="siteURL" class="textbox" size="50" value="<?php echo htmlentities($conf['settings']['script.url'], ENT_QUOTES); ?>"><br />
        
        Select the site's default language:
        {*<?php require 'configSetup/languageDropDown.tpl'; ?>*}
		
		Select the server's time zone:
		{*<?php require 'configSetup/timeZoneDefault.tpl'; ?>	*}
		<br />
		Enter path to the images upload directory:
		<input type="text" name="imageUploadDir" class="textbox" size="50" value="<?php echo htmlentities($conf['settings']['image.upload.directory'], ENT_QUOTES); ?>"><br />
		Enter the image upload URL:
		<input type="text" name="imageUploadURL" class="textbox" size="50" value="<?php echo htmlentities($conf['settings']['image.upload.url'], ENT_QUOTES); ?>"><br />
		Allow template caching?
		<?php 
		  if($conf['settings']['cache.templates'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="cacheTemp" value="true" checked>Yes
		  		<input type="radio" class="button" name="cacheTemp" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="cacheTemp" value="true">Yes
		  		<input type="radio" class="button" name="cacheTemp" value="false" checked>No<br />';
		  	}	
		?>
		Use local JQuery?
		<?php
		  if($conf['settings']['use.local.jquery'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="localJQ" value="true" checked>Yes
				 <input type="radio" class="button" name="localJQ" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="localJQ" value="true">Yes
				 <input type="radio" class="button" name="localJQ" value="false" checked>No<br />';
		  	}
		?>
		
		An inactive user will be timed out after
		<input type="text" name="inactiveTimeout" class="textbox" size="5" value="<?php echo htmlentities($conf['settings']['inactivity.timeout'], ENT_QUOTES); ?>">
		minutes.<br />
		
		<h1>Database Settings <input type="submit" class="button" value="Submit Page Changes" /></h1>
		Database type: MySQL <br />
		Database user:
		<input type="text" name="dbUser" class="textbox" size="25" value="<?php echo htmlentities($conf['settings']['database']['user'], ENT_QUOTES); ?>"><br />
		Database password:
		<input type="text" name="dbPass" class="textbox" size="25" value="<?php echo htmlentities($conf['settings']['database']['password'], ENT_QUOTES); ?>"><br />
		Database location:
		<input type="text" name="dbLocation" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['database']['hostspec'], ENT_QUOTES); ?>"><br />
		Database name:
		<input type="text" name="dbName" class="textbox" size="30" value="<?php echo htmlentities($conf['settings']['database']['name'], ENT_QUOTES); ?>"><br />	
    </div>
    <div id="configSetupDiv">		
		<h1>Email Settings <input type="submit" class="button" value="Submit Page Changes" /></h1>
		Enter the admin email address: 
    	<input type="text" name="adminEmail" class="textbox" size="50" value="<?php echo htmlentities($conf['settings']['admin.email'], ENT_QUOTES); ?>"><br />
		Enable the system to send email?
		<?php
		  if($conf['settings']['enable.email'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="enableEmail" value="true" checked>Yes
				 <input type="radio" class="button" name="enableEmail" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="enableEmail" value="true">Yes
				 <input type="radio" class="button" name="enableEmail" value="false" checked>No<br />';
		  	}
		?>
		Select email method:
		<?php
		  if($conf['settings']['phpmailer']['mailer'] == 'mail') 
			{echo
		  		'<input type="radio" class="button" name="mailMethod" value="mail" checked>mail
				 <input type="radio" class="button" name="mailMethod" value="smtp">smtp
				 <input type="radio" class="button" name="mailMethod" value="sendmail">sendmail<br />';
			}
		   else if($conf['settings']['phpmailer']['mailer'] == 'sendmail')
			{echo
		  		'<input type="radio" class="button" name="mailMethod" value="mail">mail
				 <input type="radio" class="button" name="mailMethod" value="smtp" >smtp
				 <input type="radio" class="button" name="mailMethod" value="sendmail" checked>sendmail<br />';
		  	}
		   else
			{echo
		  		'<input type="radio" class="button" name="mailMethod" value="mail">mail
				 <input type="radio" class="button" name="mailMethod" value="smtp" checked>smtp
				 <input type="radio" class="button" name="mailMethod" value="sendmail">sendmail<br />';
		  	}
		?>
		  Enter SMTP host:
		  <input type="text" name="smtpHost" class="textbox" size="50" value="<?php echo htmlentities($conf['settings']['phpmailer']['smtp.host'], ENT_QUOTES); ?>"><br />	
		  Enter SMTP port:
		  <input type="text" name="smtpPort" class="textbox" size="5" value="<?php echo htmlentities($conf['settings']['phpmailer']['smtp.port'], ENT_QUOTES); ?>"><br />
		  Use secure SMTP?
		<?php
		  if($conf['settings']['phpmailer']['smtp.secure'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="secureSmtp" value="true" checked>Yes
				 <input type="radio" class="button" name="secureSmtp" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="secureSmtp" value="true">Yes
				 <input type="radio" class="button" name="secureSmtp" value="false" checked>No<br />';
		  	}
		?>
		  Enter SMTP user name:
		  <input type="text" name="smtpUser" class="textbox" size="20" value="<?php echo htmlentities($conf['settings']['phpmailer']['smtp.username'], ENT_QUOTES); ?>"><br />	
		  Enter SMTP user password:
		  <input type="text" name="smtpPass" class="textbox" size="20" value="<?php echo htmlentities($conf['settings']['phpmailer']['smtp.password'], ENT_QUOTES); ?>"><br />
		 Path to sendmail:
		 <input type="text" name="pathSendmail" class="textbox" size="35" value="<?php echo htmlentities($conf['settings']['phpmailer']['sendmail.path'], ENT_QUOTES); ?>"><br />	
						
		<h1>User Account Settings <input type="submit" class="button" value="Submit Page Changes" /></h1>
		 Select name format
		<?php
		if($conf['settings']['name.format'] == '{first} {last}') {
			echo
			'<select name="nameFormat">
				<option value="{first} {last}" selected="selected">First Last</option>
				<option value="{last}, {first}">Last, First</option>
			</select>
			<br />';
			}
			else {
			echo
			'<select name="nameFormat">
				<option value="{first} {last}" >First Last</option>
				<option value="{last}, {first}" selected="selected" >Last, First</option>
			</select>
			<br />';
			}		
		?>	
		 Allow self-registration?
		<?php 
		  if($conf['settings']['uploads']['enable.reservation.attachments'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="selfReg" value="true" checked>Yes
				 <input type="radio" class="button" name="selfReg" value="false">No';  }
		   else
			{echo
		  		'<input type="radio" class="button" name="selfReg" value="true">Yes
				 <input type="radio" class="button" name="selfReg" value="false" checked>No';  }
		?>
		(more secure)<br />
		  Use captcha?
		  <?php 
		  if($conf['settings']['uploads']['enable.reservation.attachments'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="useCaptcha" value="true" checked>Yes
		  <input type="radio" class="button" name="useCaptcha" value="false">No<br />';  }
		   else
			{echo
		  		'<input type="radio" class="button" name="useCaptcha" value="true">Yes
		  <input type="radio" class="button" name="useCaptcha" value="false" checked>No<br />';  }
		?>		  
		  Password pattern:
		  <input type="text" name="passPattern" class="textbox" size="20" value="<?php echo htmlentities($conf['settings']['password.pattern'], ENT_QUOTES); ?>">
		  (link to php reference page):<br />
		  
		  <?php
		  if($conf['settings']['enable.email'] == 'true') {
		     
			  echo 'Require users to have valid email for self-registration?';
			  if($conf['settings']['registration.require.email.activation'] == 'true') 
				{echo
					'<input type="radio" class="button" name="reqEmailReg" value="true" checked>Yes
			         <input type="radio" class="button" name="reqEmailReg" value="false">No<br />';  }
			   else
				{echo
					'<input type="radio" class="button" name="reqEmailReg" value="true">Yes
			         <input type="radio" class="button" name="reqEmailReg" value="false" checked>No<br />';  }
			         
			  echo 'Subscribe users to email when they register?';
			  if($conf['settings']['registration.auto.subscribe.email'] == 'true')
				{echo
					'<input type="radio" class="button" name="reqSubscribe" value="true" checked>Yes
					 <input type="radio" class="button" name="reqSubscribe" value="false">No<br />';  }
			  else
				{echo
					'<input type="radio" class="button" name="reqSubscribe" value="true">Yes
					 <input type="radio" class="button" name="reqSubscribe" value="false" checked>No<br />';  }
			}
		 else
		   {echo 'Require users to have valid email for self-registration? (turn on system email to enable)<br />
		          Subscribe users to email when they register? (turn on system email to enable)<br />'; }
		?>	  
				
    </div>
    <div id="configSetupDiv">
		<h1>Calendar and Reservation Settings <input type="submit" class="button" value="Submit Page Changes" /></h1>
		Which reservations can be created and/or edited? 
		<?php
		echo <<<EOD
		<select name="resCreateEdit">
    	    <option value="{$conf['settings']['reservation']['start.time.constraint']}" selected="selected">Now set to {$conf['settings']['reservation']['start.time.constraint']}</option>
			<option value="future">future</option>
			<option value="current">current</option>
			<option value="none">none</option>						
		</select><br />	
EOD;
		?>
		In schedule view, what should be displayed as the reservation title?
		<?php
		if($conf['settings']['schedule']['reservation.label'] == 'user') {
			echo 
			'<select name="resTitle">
			  <option value="user" selected="selected">Name of user that made the reservation</option>
			  <option value="title">Title of the reservation</option>
			  <option value="none">Do not display a title</option>
			 </select>
			 <br />';
			 }
		elseif($conf['settings']['schedule']['reservation.label'] == 'title') {
			echo
			'<select name="resTitle">
			  <option value="user">Name of user that made the reservation</option>
			  <option value="title" selected="selected">Title of the reservation</option>
			  <option value="none">Do not display a title</option>
			 </select>
			 <br />';
			 }
		elseif($conf['settings']['schedule']['reservation.label'] == 'none') {
			echo
			'<select name="resTitle">
			  <option value="user">Name of user that made the reservation</option>
			  <option value="title">Title of the reservation</option>
			  <option value="none" selected="selected">Do not display a title</option>
			 </select>
			 <br />';
			 }		
		?>
		Can users see inaccessible resources?
		<?php 
		  if($conf['settings']['schedule']['show.inaccessible.resources'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="inaccessRes" value="true" checked>Yes
		  		<input type="radio" class="button" name="inaccessRes" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="inaccessRes" value="true">Yes
		  		<input type="radio" class="button" name="inaccessRes" value="false" checked>No<br />';
		  	}	
		?>
		
		ics (iCalendar) subscription key:
		<input type="text" name="icsKey" size="50" value="<?php echo htmlentities($conf['settings']['ics']['subscription.key'], ENT_QUOTES); ?>"><br />
		Users must be logged in to access ics files?
		<?php 
		  if($conf['settings']['ics']['require.login'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="icsUserLogin" value="true" checked>Yes
				 <input type="radio" class="button" name="icsUserLogin" value="false">No<br />';  }
		   else
			{echo
		  		'<input type="radio" class="button" name="icsUserLogin" value="true">Yes
				 <input type="radio" class="button" name="icsUserLogin" value="false" checked>No<br />';  }
		?>
		
		Allow attachments to reservations?
		<?php 
		  if($conf['settings']['uploads']['enable.reservation.attachments'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="resAttach" value="true" checked>Yes
		<input type="radio" class="button" name="resAttach" value="false">No<br />';  }
		   else
			{echo
		  		'<input type="radio" class="button" name="resAttach" value="true">Yes
		<input type="radio" class="button" name="resAttach" value="false" checked>No<br />';  }
		?>
		List allowable attachment extensions:
		<input type="text" name="allowExt" class="textbox" size="60" value="<?php echo htmlentities($conf['settings']['uploads']['reservation.attachment.extensions'], ENT_QUOTES); ?>"><br />
		<br />
		Notify admin(s) by email when: <br />
		
		a resource is added to a reservation?
		<?php 
		  if($conf['settings']['reservation.notify']['resource.admin.add'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="resAdd" value="true" checked>Yes
		  		<input type="radio" class="button" name="resAdd" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="resAdd" value="true">Yes
		  		<input type="radio" class="button" name="resAdd" value="false" checked>No<br />';
		  	}	
		?>
		a resource is updated?
		<?php 
		  if($conf['settings']['reservation.notify']['resource.admin.update'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="resUpd" value="true" checked>Yes
		  		<input type="radio" class="button" name="resUpd" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="resUpd" value="true">Yes
		  		<input type="radio" class="button" name="resUpd" value="false" checked>No<br />';
		  	}	
		?>	
		a resource is deleted?
		<?php 
		  if($conf['settings']['reservation.notify']['resource.admin.delete'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="resDel" value="true" checked>Yes
		  		<input type="radio" class="button" name="resDel" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="resDel" value="true">Yes
		  		<input type="radio" class="button" name="resDel" value="false" checked>No<br />';
		  	}	
		?>	
		an application is added?
		<?php 
		  if($conf['settings']['reservation.notify']['application.admin.add'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="appAdd" value="true" checked>Yes
		  		<input type="radio" class="button" name="appAdd" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="appAdd" value="true">Yes
		  		<input type="radio" class="button" name="appAdd" value="false" checked>No<br />';
		  	}	
		?>	
		an application is updated?
		<?php 
		  if($conf['settings']['reservation.notify']['application.admin.update'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="appUpd" value="true" checked>Yes
		  		<input type="radio" class="button" name="appUpd" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="appUpd" value="true">Yes
		  		<input type="radio" class="button" name="appUpd" value="false" checked>No<br />';
		  	}	
		?>	
		an application is deleted?
		<?php 
		  if($conf['settings']['reservation.notify']['application.admin.delete'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="appDel" value="true" checked>Yes
		  		<input type="radio" class="button" name="appDel" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="appDel" value="true">Yes
		  		<input type="radio" class="button" name="appDel" value="false" checked>No<br />';
		  	}	
		?>	
		a group is added?
		<?php 
		  if($conf['settings']['reservation.notify']['group.admin.add'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="groupAdd" value="true" checked>Yes
		  		<input type="radio" class="button" name="groupAdd" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="groupAdd" value="true">Yes
		  		<input type="radio" class="button" name="groupAdd" value="false" checked>No<br />';
		  	}	
		?>
		a group is updated?
		<?php 
		  if($conf['settings']['reservation.notify']['group.admin.update'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="groupUpd" value="true" checked>Yes
		  		<input type="radio" class="button" name="groupUpd" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="groupUpd" value="true">Yes
		  		<input type="radio" class="button" name="groupUpd" value="false" checked>No<br />';
		  	}	
		?>
		a group is deleted?
		<?php 
		  if($conf['settings']['reservation.notify']['group.admin.delete'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="groupDel" value="true" checked>Yes
		  		<input type="radio" class="button" name="groupDel" value="false">No<br />';
			}
		   else
			{echo
		  		'<input type="radio" class="button" name="groupDel" value="true">Yes
		  		<input type="radio" class="button" name="groupDel" value="false" checked>No<br />';
		  	}	
		?>

    </div> 
    <div id="configSetupDiv">
		<h1>Privacy Settings <input type="submit" class="button" value="Submit Page Changes" /></h1>		
		Can unauthenticated users view schedule details?
		<?php 
		  if($conf['settings']['privacy']['view.schedules'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="unauthViewSched" value="true" checked>Yes
				 <input type="radio" class="button" name="unauthViewSched" value="false" >No<br />';  
		    }
		   else
			{echo
		  		'<input type="radio" class="button" name="unauthViewSched" value="true">Yes
				 <input type="radio" class="button" name="unauthViewSched" value="false" checked>No<br />';  
		    }
		?>
		
		Can unauthenticated users see reservation details? 
		<?php 
		  if($conf['settings']['privacy']['view.reservations'] == 'true') 
			{echo
		  		'<input type="radio" class="button" name="unauthViewRes" value="true" checked>Yes
				 <input type="radio" class="button" name="unauthViewRes" value="false">No<br />';  }
		   else
			{echo
		  		'<input type="radio" class="button" name="unauthViewRes" value="true">Yes
				 <input type="radio" class="button" name="unauthViewRes" value="false" checked>No<br />';  }
		?>
		
		Can registered users see user details? 
		<?php 
		  if($conf['settings']['privacy']['hide.user.details'] == 'false') 
			{echo
		  		'<input type="radio" class="button" name="authViewUser" value="false" checked>Yes
				 <input type="radio" class="button" name="authViewUser" value="true">No<br />';  }
		   else
			{echo
		  		'<input type="radio" class="button" name="authViewUser" value="false">Yes
				 <input type="radio" class="button" name="authViewUser" value="true" checked>No<br />';  }
		?>
		
		Can registered users see reservation details? 
		<?php 
		  if($conf['settings']['privacy']['hide.reservation.details'] == 'false') 
			{echo
		  		'<input type="radio" class="button" name="authViewRes" value="false" checked>Yes
				 <input type="radio" class="button" name="authViewRes" value="true">No<br />';  }
		   else
			{echo
		  		'<input type="radio" class="button" name="authViewRes" value="false">Yes
				 <input type="radio" class="button" name="authViewRes" value="true" checked>No<br />';  }
		?>


    </div> 
    <div id="configSetupDiv">
		<h1>Appearance Settings <input type="submit" class="button" value="Submit Page Changes" /></h1>
		Default page size:
		<input type="text" name="defPageSize" class="textbox" size="5" value="<?php echo htmlentities($conf['settings']['default.page.size'], ENT_QUOTES); ?>"><br />
		Path to CSS extension file:
		<input type="text" name="cssExtFile" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['css.extension.file'], ENT_QUOTES); ?>"><br />
	</div> <!--end configSetupDiv-->
	<div id="configSetupDiv">
		<h1>Plugin Settings <input type="submit" class="button" value="Submit Page Changes" /></h1>
		<i>For more on plugins, see readme_installation.html</i><br />
		Authentication:
		<input type="text" name="plugAuthentication" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['plugins']['Authentication'], ENT_QUOTES); ?>"><br />
		Authorization:
		<input type="text" name="plugAuthorization" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['plugins']['Authorization'], ENT_QUOTES); ?>"><br />
		Permission:
		<input type="text" name="plugPermission" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['plugins']['Permission'], ENT_QUOTES); ?>"><br />
		Post Registration:
		<input type="text" name="plugPostReg" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['plugins']['PostRegistration'], ENT_QUOTES); ?>"><br />
		Pre Reservation:
		<input type="text" name="plugPreRes" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['plugins']['PreReservation'], ENT_QUOTES); ?>"><br />
		Post Reservation:
		<input type="text" name="plugPostRes" class="textbox" size="40" value="<?php echo htmlentities($conf['settings']['plugins']['PostReservation'], ENT_QUOTES); ?>"><br />	
		<br />
	</div>
	</form>
   </div> <!--end content-->
  </div> <!--end wrapper-->
 </body>
</html>