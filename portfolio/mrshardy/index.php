<?
highlight_string('
<?
session_start();
if (!$_SESSION[\'filter\']) {
	$_SESSION[\'filter\'] = "math";
} elseif ($selected_filter) {
	$_SESSION[\'filter\'] = $selected_filter;
}
?>
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
	if ($active=="on") {
		$active=1;
	} else {
		$active=0;
	}
	$sql = "INSERT INTO 4th_links (subject,title,description,url,active) VALUES (\'$subject\',\'$title\',\'$description\',\'$url\',$active)";
	mysql_query($sql);
	echo "<b>".stripcslashes($title)." added to website.</b><br>";
}

if ($Changed) {
	if ($active=="on") {
		$active=1;
	} else {
		$active=0;
	}
	if ($_POST[\'Update\']){
		$sql="UPDATE 4th_links SET subject=\'$subject\', title=\'$title\', description=\'$description\', url=\'$url\', active=$active WHERE ID=$ID";
		echo "<b>".stripcslashes($title)." updated.</b><br>";
	} else {
		$sql="DELETE FROM 4th_links WHERE ID=$ID";
		echo "<b>".stripcslashes($title)." deleted.</b><br>";
	}
	mysql_query($sql);
}
?>
<p>
[ <b>Links Manager</b> :: <a href="news.php">News Manager</a> :: <a href="addresses.php">Mailing List Manager</a> ]
<p>
<b>Links Filter:</b>
<select name="filter" onchange="window.open(\'index.php?selected_filter=\' + this.options[this.selectedIndex].value,\'_top\')">
	<option value="math"<?if ($_SESSION[\'filter\'] == "math") echo " selected"?>>Math</option>
	<option value="reading"<?if ($_SESSION[\'filter\'] == "reading") echo " selected"?>>Reading</option>
	<option value="science"<?if ($_SESSION[\'filter\'] == "science") echo " selected"?>>Science</option>
	<option value="social_studies"<?if ($_SESSION[\'filter\'] == "social_studies") echo " selected"?>>Social Studies</option>
	<option value="spelling"<?if ($_SESSION[\'filter\'] == "spelling") echo " selected"?>>Spelling</option>
	<option value="writing"<?if ($_SESSION[\'filter\'] == "writing") echo " selected"?>>Writing</option>
	<option value="favorites"<?if ($_SESSION[\'filter\'] == "favorites") echo " selected"?>>Mrs. Hardy\'s Favorites</option>
</select>
<p>
<form method="post" action="<? echo $PHP_SELF?>">
<table cellspacing="8" cellpadding="0" border="0">
	<tr>
		<td>Subject:<br>
		<select name="subject" style="width:300px">
			<option value="math">Math</option>
			<option value="reading">Reading</option>
			<option value="science">Science</option>
			<option value="social_studies">Social Studies</option>
			<option value="spelling">Spelling</option>
			<option value="writing">Writing</option>
			<option value="favorites">Mrs. Hardy\'s Favorites</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Title:<br><input type="text" name="title" style="width:300px"></td>
	</tr>
	<tr>
		<td>Description:<br><textarea name="description" style="width:300px" maxlength="270"></textarea></td>
	</tr>
	<tr>
		<td>URL:<br><input type="text" name="url" size="80" style="width:300px"></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="active" checked> Active</td>
	</tr>
	<tr>
		<td><input type="Submit" value="Add"></td>
	</tr>
</table>
<input type="hidden" name="NewSubmit" value="yes">
</form>
<p>
<hr style="height:1px;width:500px" align="left">
<?
$results = mysql_query("SELECT ID,subject,title,description,url,active FROM 4th_links WHERE subject=\'{$_SESSION[\'filter\']}\' ORDER BY title ASC",$db);
while ($data = mysql_fetch_array($results)) {
?>
<form method="post" action="<?=$PHP_SELF?>">
<table cellspacing="8" cellpadding="0" border="0">
	<tr>
		<td>Subject:<br>
		<select name="subject" style="width:300px">
			<option value="math"<?if ($data[\'subject\'] == "math") echo " selected";?>>Math</option>
			<option value="reading"<?if ($data[\'subject\'] == "reading") echo " selected";?>>Reading</option>
			<option value="science"<?if ($data[\'subject\'] == "science") echo " selected";?>>Science</option>
			<option value="social_studies"<?if ($data[\'subject\'] == "social_studies") echo " selected";?>>Social Studies</option>
			<option value="spelling"<?if ($data[\'subject\'] == "spelling") echo " selected";?>>Spelling</option>
			<option value="writing"<?if ($data[\'subject\'] == "writing") echo " selected";?>>Writing</option>
			<option value="favorites"<?if ($data[\'subject\'] == "favorites") echo " selected";?>>Mrs. Hardy\'s Favorites</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Title:<br><input type="text" name="title" value="<?=$data[\'title\']?>" style="width:300px"></td>
	</tr>
	<tr>
		<td>Description:<br><textarea name="description" style="width:300px"><?=$data[\'description\']?></textarea></td>
	</tr>
	<tr>
		<td>URL:<br><input type="text" name="url" value="<?=$data[\'url\']?>" style="width:300px"></td>
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