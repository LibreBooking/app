<?php
session_start();

$go_to = $_SESSION['came_from'];

require_once ("db.php");
require_once ("LDAP_Authenticate.php");

if (@$_POST["submit"] <> "") {
    $validpwd = False;

    // setup variables
    $userid = @$_POST["userid"];
    $userid = (get_magic_quotes_gpc()) ? stripslashes($userid) : $userid;
    $passwd = @$_POST["passwd"];
    $passwd = (get_magic_quotes_gpc()) ? stripslashes($passwd) : $passwd;
    if (!$validpwd) {
        $validpwd = LDAP_validate($userid, $passwd);
    }
    if ($validpwd) {

        // write cookies
        if (@$_POST["rememberme"] <> "") {
            setCookie("WR_userid", $userid, time() + 365 * 24 * 60 * 60); // change cookie expiry time here
        }
        $_SESSION["WR_user"] = "$userid";
        $_SESSION["WR_status"] = "login";

        if ($go_to) {//if they came from a page behind this script
            header("Location: $go_to"); //this dictates where it will redirect too
        } else {
            header("Location: main.php"); //they typed in http://library.ucalgary.ca/login.php thus send them somewhere after
        }
    }
} else {
    $validpwd = True;
}
?>
<html>
    <head>
        <title>Small Url Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="WR_Style_Sheets.css" rel="stylesheet" type="text/css" />
        <META http-equiv="Expires" content="Tue, 20 Aug 1996 14:25:27 GMT">
        <META HTTP-EQUIV="cache-control" CONTENT="no-cache">
        <META HTTP-EQUIV="pragma" CONTENT="no-cache">
        <meta name="generator" content="PHPMaker v2.1.0.0" />
    </head>
    <script language="JavaScript" src="ew.js"></script>
    <script language="JavaScript">
        <!-- start JavaScript
        function  EW_checkMyForm(EW_this) {
            if (!EW_hasValue(EW_this.userid, "TEXT")) {
                if (!EW_onError(EW_this, EW_this.userid, "TEXT", "Please enter user ID"))
                    return false;
            }
            if (!EW_hasValue(EW_this.passwd, "PASSWORD")) {
                if (!EW_onError(EW_this, EW_this.passwd, "PASSWORD", "Please enter password"))
                    return false;
            }
            return true;
        }

        // end JavaScript -->
    </script>
    <body bgcolor="#FFFFEE" OnLoad="document.loginform.userid.focus();">

<!--<table border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" align="center" width="100%" bgcolor="#FFFEEE">
        <tr>
                <td class="wrheader"><center>Small Url Login</center></td>
        </tr>
</table>-->

        <table border="0" cellspacing="0" cellpadding="2" align="center" width="100%" >
            <tr>
                <td><center><img src="/images/ir_images/sucubanner.gif"></center></td>
    </tr>
</table>

<br><br><br>
<?php if (!$validpwd) { ?>
    <p align="center"><span class="phpmaker" style="color: Red;">Incorrect user ID or password</span></p>
<?php } ?>
<form action="login.php" name=loginform method="post" onSubmit="return EW_checkMyForm(this);">
    <table  border="1" align="center" bordercolor="#FF0000" bgcolor="yellow" >
        <tr>
            <td>
                <table border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#CCCCCC">
                    <tr>
                        <td align="left" colspan="2"><span class="phpmaker"><div align="center"><b>Login</b></div></span></td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><span class="phpmaker">Please use your UofC IT username and password</span></td>
                    </tr>
                    <tr>

                        <td align="left"><span class="phpmaker">User ID</span></td>
                        <td><input type="text" name="userid" size="20" maxlength="20" tabindex="1" value="<?php echo @$_COOKIE["WR_userid"]; ?>"></td>
                    </tr>
                    <tr>
                        <td align="left"><span class="phpmaker">Password</span></td>
                        <td><input type="password" name="passwd" size="20" maxlength="20"tabindex="2"></td>
                    </tr>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td><input type="checkbox" name="rememberme" value="true"><span class="phpmaker">Remember me</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" name="submit" value="Login"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table></form>
<br>
</body>
</html>