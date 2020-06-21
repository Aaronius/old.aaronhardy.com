<?
highlight_string('
<?
set_time_limit(0); // No timeout
ignore_user_abort(true); // Continue processing if user aborts
ini_set("max_execution_time", 0); // No max execution time

/* Remove previous XML files
***********************************/
if (file_exists("../sitemap_index.xml")) {
  unlink("../sitemap_index.xml");
}

for ($i=1; $i<50; $i++) {
  if (file_exists("../sitemap_$i.xml")) {
    unlink("../sitemap_$i.xml");
  }
}
/***********************************/

//Connect to DB
$db = mysql_connect("localhost", "*****","*****") or die(mysql_error());
mysql_select_db("*****",$db) or die(mysql_error());

startSitemap($filename, $file, $sitemapCounter, $entryCounter);

/* Write school entries
***********************************/
$sqlSchools=mysql_query("SELECT name_id, state, lat, lon FROM schools ORDER BY name_id");
while ($rSchools=mysql_fetch_array($sqlSchools)) {
  
  // 50,000 entry or 10 MB max, but we\'ll be safe
  // Checking filesize doesn\'t work well because the file must be closed each time
  // for it to be updated.  Instead we\'ll work with entries.
  if ($entryCounter > 20000) {
    endSitemap($file);
    startSitemap($filename, $file, $sitemapCounter, $entryCounter);
  }
  
  addEntry($file, $entryCounter, "http://ratemyapartments.com/ratings/{$rSchools[\'state\']}/{$rSchools[\'name_id\']}/");
  echo ".";  // This seems to help keep it alive
  
}
/***********************************/

// Seek to the beginning record in the recordset
mysql_data_seek($sqlSchools, 0);

include($_SERVER["DOCUMENT_ROOT"] . "/includes/arrays.php");

/* Write apartment entries
***********************************/
while ($rSchools=mysql_fetch_array($sqlSchools)) {

  $i=5; // We assume a level 5 zoom (~5 mile radius) 
  $lat_lower=$rSchools[\'lat\']-$diff[$i][1];  // $diff[] is in includes/arrays.php
  $lat_upper=$rSchools[\'lat\']+$diff[$i][1];
  $lon_lower=$rSchools[\'lon\']-$diff[$i][0];
  $lon_upper=$rSchools[\'lon\']+$diff[$i][0];
  
  $sqlApts=mysql_query("
  	SELECT
  	name_id FROM apartments
  	WHERE (lat BETWEEN $lat_lower AND $lat_upper)
  	AND (lon BETWEEN $lon_lower AND $lon_upper)");
  	
  while ($rApts=mysql_fetch_array($sqlApts)) {
    
    // 50,000 entry or 10 MB max, but we\'ll be safe
    // Checking filesize doesn\'t work well because the file must be closed each time
    // for it to be updated.  Instead we\'ll work with entries.
    if ($entryCounter > 20000) {
      endSitemap($file);
      startSitemap($filename, $file, $sitemapCounter, $entryCounter);
    }
    
    addEntry($file, $entryCounter, "http://ratemyapartments.com/ratings/{$rSchools[\'state\']}/{$rSchools[\'name_id\']}/{$rApts[\'name_id\']}/");
    echo "."; // This seems to help keep it alive
    
  }

}
/***********************************/


// Close up the final sitemap 
endSitemap($file);
echo "Done creating sitemaps.";

/* Create sitemap index
***********************************/
$filename = "../sitemap_index.xml";
$file = fopen($filename, "a");
fputs($file, \'<?xml version="1.0" encoding="UTF-8"?>\');
fputs($file, "\n<sitemapindex xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n");

for ($i=1; $i<=$sitemapCounter; $i++) {
  fputs($file, "\t<sitemap>\n");
  fputs($file, "\t\t<loc>http://ratemyapartments.com/sitemap_$i.xml</loc>\n");
  fputs($file, "\t</sitemap>\n");
}

fputs($file, "</sitemapindex>");
fclose($file);
/***********************************/
 

function startSitemap(&$filename, &$file, &$sitemapCounter, &$entryCounter) {
  $sitemapCounter++;
  $entryCounter = 0;
  $filename = "../sitemap_$sitemapCounter.xml";
  $file = fopen($filename, "a");
  fputs($file, \'<?xml version="1.0" encoding="UTF-8"?>\');
  fputs($file, "\n<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n");
}

function endSitemap(&$file) {
  fputs($file, "</urlset>");
  fclose($file);
}

function addEntry(&$file, &$entryCounter, $url){
  $entryCounter++;
  fputs($file, "\t<url>\n");
  fputs($file, "\t\t<loc>" . htmlentities($url, ENT_QUOTES, \'UTF-8\') . "</loc>\n");
  fputs($file, "\t</url>\n");
}

?>

');
?>
