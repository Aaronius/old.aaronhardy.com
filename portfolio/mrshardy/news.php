<?
highlight_string('
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Mrs. Hardy\'s Phatty List Of Junk Admin</title>
	<style>
	body,td{
		font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-size: 11px;
	}
	</style>
</head>

<body>
<?
//Connect to DB
$db = mysql_connect("localhost", "*****","*****");
mysql_select_db("*****",$db);

if ($NewSubmit) {
	if ($post_to_website=="on"){
		$sql = "INSERT INTO 4th_news (news,timestamp,active) VALUES (\'$news\',NOW(),1)";
		mysql_query($sql);
		echo "<b>News item posted to website.</b><br>";
	}
	if ($send_to_list=="on"){
		$header = "From: Mrs. Hardy <holly.hardy@nebo.edu>\n";
		$header .= "Reply-To: holly.hardy@nebo.edu\n";
		$results = mysql_query("SELECT address FROM 4th_addresses",$db);
		while ($data = mysql_fetch_array($results)) {
			$header .= "Bcc: ".$data[\'address\']."\n";
		}
		$header .= "X-Mailer: PHP/" . phpversion() . "\n";
		mail("Mailing List Recipients <me@aaronhardy.com>", "Class news for ".date("l, F j, Y"),
			"This is the class news for ".date("l, F j, Y").":\n\n"
			. stripslashes($news),$header);
		echo "<b>News item sent to mailing list.</b><br>";
	}
}

if ($Changed) {
	if ($_POST[\'Update\']){
		if ($active=="on") {
			$active=1;
		} else {
			$active=0;
		}
		$sql="UPDATE 4th_news SET news=\'$news\', active=\'$active\' WHERE ID=$ID";
		echo "<b>News item information updated.</b><br>";
	}
	else {
		$sql="DELETE FROM 4th_news WHERE ID=$ID";
		echo "<b>News item deleted.</b><br>";
	}
	mysql_query($sql);
}
?>
[ <a href="index.php">Links Manager</a> :: <b>News Manager</b> :: <a href="addresses.php">Mailing List Manager</a> ]
<p>
<form method="post" action="<? echo $PHP_SELF?>">
<table cellspacing="8" cellpadding="0" border="0">
	<tr>
		<td>News item content:<br><textarea name="news" rows="15" cols="60"></textarea></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="post_to_website" checked> Post to website</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="send_to_list" checked> Send to mailing list</td>
	</tr>
	<tr>
		<td><input type="Submit" value="Add"></td>
	</tr>
</table>
<input type="hidden" name="NewSubmit" value="yes">
</form><p>
<hr style="height:1px;width:500px" align="left">
<?
$results = mysql_query("SELECT ID,news,UNIX_TIMESTAMP(timestamp) as timestamp, active FROM 4th_news ORDER BY timestamp DESC",$db);
while ($data = mysql_fetch_array($results)) {
?>
<form method="post" action="<?=$PHP_SELF?>">
<table cellspacing="8" cellpadding="0" border="0">
	<tr>
		<td><?=date("l, F j, Y",$data[\'timestamp\'])?><br><textarea name="news" rows="15" cols="60"><?=$data[\'news\']?></textarea></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="active"<?if ($data[\'active\']) echo " checked"?>> Active</td>
	</tr>
	<tr>
		<td><input type="Submit" name="Update" value="Update"><input type="Submit" name="Delete" value="Delete"></td>
	</tr>
</table>
<input type="hidden" name="Changed" value="yes">
<input type="hidden" name="ID" value="<?=$data[\'ID\']?>">
</form><p>
<hr style="height:1px;width:500px" align="left">
<?php
};
?>
</body>
</html>
');
?>