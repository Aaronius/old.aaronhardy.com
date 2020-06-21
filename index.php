<!--Created by Aaron Hardy-->
<?
// Notify Aaron of referrer...
if (strpos($HTTP_REFERER,"galaxisweb")===false && strlen(trim($HTTP_REFERER))>0){
	$to = "me@aaronhardy.com";
	$subject = "User visit at aaronhardy.com";
	$headers = "From: aaronhardy@aaronhardy.com <aaronhardy@aaronhardy.com>\n";
	$body = "Someone visited from $HTTP_REFERER";
	mail($to, $subject, stripslashes($body), $headers);
}
// End notify Aaron too...
?>
<html>
<head>
	<title>:: AARONHARDY.COM :: For all your Aaron Hardy needs.</title>
	<META name="description" content="For all your Aaron Hardy needs.">
	<META name="keywords" content="web designer, graphic designer, developer, programmer, php, asp, utah, investor, student, punker">
</head>
<body background="/images/back.gif" bgcolor="#AFE60A" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" style="overflow-X:hidden">

<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
	<tr>
		<td align="center"><img src="images/tier1/pantalla.gif" usemap="#nav" border="0"></td>
	</tr>
</table>

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
<map name="nav">
  <area shape="poly" coords="55,124,159,82,159,29,204,28,232,60,338,26,280,119,341,213,233,183,165,273,159,163" href="guru.php">
  <area shape="poly" coords="435,208,506,123,452,28,458,27,557,65,587,27,628,28,623,92,695,126,695,148,617,169,606,281,545,186" href="student.php">
  <area shape="poly" coords="69,285,186,313,242,219,252,331,362,362,259,404,261,486,232,486,188,434,81,472,138,378" href="investor.php">
  <area shape="poly" coords="372,348,480,321,499,210,556,309,668,289,592,375,644,475,538,430,485,486,464,486,472,398" href="punker.php">
  <area shape="rect" coords="619,487,693,502" href="#" onClick="window.open('contact.php','contactwindow','screenX=20,screenY=20,left=20,top=20,width=472,height=255')">
  <area shape="rect" coords="567,487,621,502" href="punker.php">
  <area shape="rect" coords="509,487,569,502" href="investor.php">
  <area shape="rect" coords="311,487,458,502" href="guru.php">
  <area shape="rect" coords="455,487,511,502" href="student.php">
  <area shape="rect" coords="264,487,313,502" href="#">
</map>
