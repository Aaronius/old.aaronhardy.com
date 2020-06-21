<?
highlight_string('
<?
include "charts/charts.php";
include_once("bugdata.php");

$bugData = new BugData($_GET[\'build_uid\']);
$severityPercentages = $bugData->getSeverityPercentages();
$categoryPercentages = $bugData->getCategoryPercentages();
$projectName = $bugData->getProjectName();
$buildName = $bugData->getBuildName();
$bugs = $bugData->getBugs();
$counts = $bugData->getCounts();

if ($counts[\'all_total\']){ // at least one test case exists
	$percentagePassed = round($counts[\'all_passed\'] / $counts[\'all_total\'] * 100);
	$percentageFailed = round(($counts[\'all_completed\'] - $counts[\'all_passed\']) / $counts[\'all_total\'] * 100);
	$percentageComplete = $percentagePassed + $percentageFailed;  
}
?>

<html>
<head>

<style>

body{
	text-align: center;
	font: 12px Verdana, Helvetica, Arial;
}

#container{
	width: 700px;
	margin-left: auto;
	margin-right: auto;
	text-align: left;
}

h1{
	font: bold 60px Georgia, Times, serif;
	margin: 0;
	padding: 0;
	text-align: center;
}

h2{
	font: bold 20px Georgia, Times, serif;
	margin: 0 0 60px 0;
	padding: 0;
	text-align: center;
}

#bugtable{
	margin-top: 70px;
	border-collapse: collapse;
	width: 100%; 
	font: 12px Verdana, Helvetica, Arial;
}

#bugtable thead th {
	padding: 8px;
	background-color: #EEEEEE;
	height: 26px;
	text-align: left;
}

#bugtable td {
	padding: 8px;
	border: 1px solid #EEEEEE;
	vertical-align: top;
}

/* Style bug severity text according to severity. */
td.sev_Blocker{ color: #E00000; font-weight: bold; }
td.sev_Critical{ color: #D80000; }
td.sev_Major{ color: #E88000; }
td.sev_Enhancement{ color: #737E1F; }
td.sev_Minor{ color: #6484A4; }

</style>

</head>
<body onLoad="window.focus()">
	<div id="container">
		<h1>TESTING REPORT</h1>
		<h2><?=$projectName?> - Build <?=$buildName?></h2>
		
		<div style="text-align:center; line-height:1.4;">
			<b>Total Build Progress<br>
			<span style="color:#56CF19;"><?=$percentagePassed?>% Passed</span> :: 
			<span style="color:red;"><?=$percentageFailed?>% Failed</span> :: 
			<?=$percentageComplete?>% Complete</b>
		</div>
		
		<div style="width:100%; height:35px; border:1px dotted #567E3A; margin-bottom:60px;">
			<div style="float:left; width:<?=$percentagePassed?>%; height:35px; background-color:#56CF19;"></div>
			<div style="float:left; width:<?=$percentageFailed?>%; height:35px; background-color:red;"></div>
		</div>
		
		
		<table cellspacing="0" cellpadding="0" border="0" width="100%" height="300" style="font: 12px Verdana, Helvetica, Arial;">
			<tr>
				<td align="center" width="50%">

<?
if (count($bugs)) { // only if there are bugs

	$url = "charts/severity_chart_creator.php?" .
		"blocker=" . $severityPercentages[\'blocker\'] . 
		"&critical=" . $severityPercentages[\'critical\'] . 
		"&major=" . $severityPercentages[\'major\'] . 
		"&normal=" . $severityPercentages[\'normal\'] . 
		"&minor=" . $severityPercentages[\'minor\'] . 
		"&enhancement=" . $severityPercentages[\'enhancement\'] .
		"&forceNoCacheID=" . uniqid(rand(),true);
	
	echo InsertChart ( "charts/charts.swf", "charts/charts_library", $url, 345 , 300 , "FFFFFF" , false );

} else {
  
  echo "<b>Bugs Found By Severity</b><br>No bugs have been reported.";

}
?>
				</td>
				<td align="center" width="50%">
				
<?
if ($counts[\'all_completed\']-$counts[\'all_passed\']){ // only if there are failed test cases
	
	$url = "charts/category_chart_creator.php?" .
		"install=" . $categoryPercentages[\'install\'] . 
		"&configuration=" . $categoryPercentages[\'configuration\'] . 
		"&file_system=" . $categoryPercentages[\'file_system\'] . 
		"&authentication=" . $categoryPercentages[\'authentication\'] . 
		"&forceNoCacheID=" . uniqid(rand(),true);
	
	echo InsertChart ( "charts/charts.swf", "charts/charts_library", $url, 345 , 300 , "FFFFFF" , false );

} else {

  echo "<b>Cases Failed By Category</b><br>No test cases have been failed.";

}
?>
				</td>
			<tr>
		</table>

		
<?
// Print bug table
echo "<table id=\"bugtable\">";
echo "<thead><tr><th>ID</th><th>Notes</th><th>Severity</th><th>Reporter</th><th>Assignee</th></tr></thead>";

if (count($bugs)) { // only if there are bugs

  foreach($bugs as $bug){
		  echo "<tr>";
		  echo "<td>{$bug[\'id\']}</td>";
		  echo "<td>{$bug[\'summary\']}</td>";
		  echo "<td class=\"sev_{$bug[\'severity\']}\">{$bug[\'severity\']}</td>";
		  echo "<td><nobr>{$bug[\'reporter\']}</nobr></td>";
		  echo "<td><nobr>{$bug[\'assignee\']}</nobr></td>";
		  echo "</tr>";
	}

} else {

	echo "<tr><td colspan=\"5\">No bugs have been reported.</td></tr>";

}

echo "</table>";
?>

	</div>
</body>
</html>
');
?>