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
	$sql = "INSERT INTO 4th_addresses (name,address) VALUES (\'$name\',\'$address\')";
	mysql_query($sql);
	echo "$name\'s address added to mailing list.<br>";
}

if ($Changed) {
	if ($_POST[\'Update\']){
		$sql="UPDATE 4th_addresses SET name=\'$name\', address=\'$address\' WHERE ID=$ID";
		echo "$name\'s information updated.<br>";
	}
	else {
		$sql="DELETE FROM 4th_addresses WHERE ID=$ID";
		echo "$name deleted.<br>";
	}
	mysql_query($sql);
	
}
?>
[ <a href="index.php">Links Manager</a> :: <a href="news.php">News Manager</a> :: <b>Mailing List Manager</b> ]
<p>
<form method="post" action="<? echo $PHP_SELF?>">
<table cellspacing="8" cellpadding="0" border="0">
	<tr>
		<td>Name:<br><input type="text" name="name"></td>
	</tr>
	<tr>
		<td>Address:<br><input type="text" name="address"></td>
	</tr>
	<tr>
		<td><input type="Submit" value="Add"></td>
	</tr>
</table>
<input type="hidden" name="NewSubmit" value="yes">
</form><p>
<hr style="height:1px;width:500px" align="left">
<?
$results = mysql_query("SELECT ID, name, address FROM 4th_addresses ORDER BY name",$db);
while ($data = mysql_fetch_array($results)) {
?>
<form method="post" action="<?=$PHP_SELF?>">
<table cellspacing="8" cellpadding="0" border="0">
	<tr>
		<td>Name:<br><input type="text" name="name" value="<?=$data[\'name\']?>"></td>
	</tr>
	<tr>
		<td>Address:<br><input type="text" name="address" value="<?=$data[\'address\']?>"></td>
	</tr>
	<tr>
		<td><input type="Submit" name="Update" value="Update"><input type="Submit" name="Delete" value="Delete"></td>
	</tr>
</table>
<input type="hidden" name="ID" value="<?=$data[\'ID\']?>">
<input type="hidden" name="Changed" value="yes">
</form>
<p>
<hr style="height:1px;width:500px" align="left">
<?php
};
?>
</body>
</html>
');
?>
