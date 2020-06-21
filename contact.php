<?
if ($_POST['lettersubmit']) {
	if (!validateEmail($_POST['email'])) {
		$status = "Error sending. Please provide a valid email address.";
	}
	else {
		mail("aaron@aaronhardy.com", "Mail from aaronhardy.com", "Name:\n" 
			. stripslashes($_POST['name']) . "\n\n" 
			. "Email Address:\n" . stripslashes($_POST['email']) 
			. "\n\nMessage:\n" . stripslashes($_POST['message']),
		     "From: " . $_POST['name'] . "\n"
		    ."Reply-To: " . $_POST['email'] . "\n"
		    ."X-Mailer: PHP/" . phpversion());
			$status = "Thank you. Your message has been sent.";
			unset($_POST['name']);
			unset($_POST['email']);
			unset($_POST['message']);
	}
}
?>


<html>
<head>
	<title>:: AARONHARDY.COM :: CONTACT ME</title>
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="stylesheet.css" rel="stylesheet" type="text/css">
</head>
<body background="/images/back.gif" bgcolor="#AFE60A" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" bgcolor="#000000" style="overflow-Y:hidden; overflow-X:hidden" onLoad='window.focus();'>
<form method="post" name="letter">
<div style="background-color:#83a31f;margin:15px; border: dashed 1px #ffffff;">
<table cellpadding="0" cellspacing="8" align="center" valign="top">
	<tr>
		<td class="contact">Name:</td>
		<td><input type="text" name="name" tabindex="2" class="input" value="<?=$_POST['name']?>"></td>
	</tr>
	<tr>
		<td class="contact">Email:</td>
		<td><input type="text" name="email" tabindex="3" class="input" value="<?=$_POST['email']?>"></td>
	</tr>
	<tr>
		<td valign="top" class="contact">Message:</td>
		<td><textarea name="message" class="textarea" tabindex="5"><?=$_POST['message']?></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="hidden" name="lettersubmit" value="yes"><input type="submit" value="send message"></td>
	</tr>
	<tr>
		<td valign="top" class="contact">Status:</td>
		<td class="status">
		<? 
		if ($status) {
			echo $status;
		}
		else {
			echo "Ready...";
		}?></td>
	</tr>
</table>
</div>
</form>
<!-- Google Analytics -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-895132-3";
urchinTracker();
</script>
<!-- End Google Analytics -->
</body>
</html>
<?php
function validateEmail($email) {
	return (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'.
	'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' .
	'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email));
}
?>
