<?
highlight_string('
<?
// Connection info
include_once("/usr/local/www/data-dist/includes/dbconn.php");

class BugData{
	
	private $build_uid;
	private $projectName;
	private $buildName;
	private $bugs;
	private $counts;
	private $severityPercentages;
	private $categoryPercentages;
	
	function __construct($build_uid){
		$this->build_uid = $build_uid;
	}
	
	public function getProjectName(){
	  if(!isset($this->projectName)){
	    $this->setBuildInfo();
	  }
		return $this->projectName;
	}
	
	public function getBuildName(){
	  if(!isset($this->buildName)){
	    $this->setBuildInfo();
	  }
		return $this->buildName;
	}
	
	public function getBugs(){
	  if(!isset($this->bugs)){
	    $this->setBugs();
	  }
		return $this->bugs;
	}
	
	public function getCounts(){
		if(!isset($this->counts)){
	    $this->setCounts();
	  }
		return $this->counts;
	}
	
	public function getSeverityPercentages(){
	  if(!isset($this->bugs)){ // Severity percentages are dependent on bugs array as well
	    $this->setBugs();
	  }
	  if(!isset($this->severityPercentages)){
	    $this->setSeverityPercentages();
	  }
	  return $this->severityPercentages;
	}
	
	public function getCategoryPercentages(){
	  if(!isset($this->counts)){// Category percentages are dependent on counts array as well
	    $this->setCounts();
	  }
	  if(!isset($this->categoryPercentages)){
	    $this->setCategoryPercentages();
	  }
		return $this->categoryPercentages;
	}
	
	private function setBuildInfo(){
	  $buildInfoQuery = mysql_query(
			"SELECT TRIM(tcdb_projects.name) AS projectName, TRIM(tcdb_builds.name) as buildName ".
			"FROM tcdb_projects, tcdb_builds ".
			"WHERE tcdb_builds.project_uid = tcdb_projects.uid ".
			"AND tcdb_builds.uid = $this->build_uid "
			) or die("Could not get information");
		
		$buildInfoRS = mysql_fetch_array($buildInfoQuery);
		
		$this->projectName = $buildInfoRS[\'projectName\'];
		$this->buildName = $buildInfoRS[\'buildName\'];
	}
	
	private function setBugs(){
	  
		// Get bugs that failed for build and that have an id number
		$tcFailedQuery = mysql_query(
			"SELECT DISTINCT TRIM(bug_id) AS bug_id ".
			"FROM tcdb_results ".
			"WHERE build_uid = $this->build_uid ".
			"AND status = 2 ".
			"AND bug_id <> \'\'"
			) or die("Could not get information");

		
		// Bugzilla authentication credentials
		include_once("auth_info.php");
		
		// Hidden form variables that need to be posted
		$url = \'https://bugzilla.novell.com/ichainlogin.cgi?target=index.cgi\';
		$context = \'default\';
		$proxypath = \'reverse\';
		$submit = \'Log In\';
		
		// Complete post string - includes both hidden form variables as well as Bugzilla authentication credentials
		$curlPost = \'url=\'  . urlencode($url) . \'&context=\' . urlencode($context) . \'&proxypath=\' . urlencode($proxypath) . \'&username=\' . urlencode($username) . \'&password=\' . urlencode($password) . \'&submit=\' . urlencode($submit); 
		
		// Agent spoof
		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3"; 
		
		// cURL operations to authenticate through Bugzilla
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://www.novell.com/ICSLogin/auth-up");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		curl_setopt($ch, CURLOPT_COOKIEJAR, "/usr/local/www/data-dist/labinfo/tcdb_stats/cookies.txt");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_REFERER, "https://innerweb.novell.com/ICSLogin/auth-up"); 
		$filein = curl_exec($ch);
		curl_close($ch);
		
		// For each failed bug (does not include duplicates between operating systems
		// i.e., a bug duplicated on both SuSE and SLED will show as a single bug
		while ($tcFailedRS = mysql_fetch_array($tcFailedQuery)){

			// cURL operations to pull in Bugzilla page for specified bug
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://bugzilla.novell.com/show_bug.cgi?id={$tcFailedRS[\'bug_id\']}");
			curl_setopt($ch, CURLOPT_COOKIEFILE, "/usr/local/www/data-dist/labinfo/tcdb_stats/cookies.txt");
			curl_setopt($ch, CURLOPT_REFERER, "https://bugzilla.novell.com/ICSLogin/?%22https://bugzilla.novell.com/ichainlogin.cgi?target=index.cgi%22");
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$filein = curl_exec($ch);
			
			// Remove line breaks, tabs, double+ spaces, and spaces between angle brackets from source
			$filein = str_replace("\r","",$filein);
			$filein = str_replace("\n","",$filein);
			$filein = str_replace("\t","",$filein);
			$filein = preg_replace("/ +/", " ", trim($filein)); 
			$filein = str_replace("> <","><",$filein);
			
			//echo htmlentities($filein);
			
			// Regular expression formula for "summary" match
			$regex_formula = \'/<h3>summary<\/h3>\'.
				\'<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>\'.
				\'<td align="left" width="100%">(.*?)<\/td>/\';
			
			// Run preg match and assign match to "summary" variable
			preg_match($regex_formula, $filein, $matches);
			$summary = $matches[1];
			
			// Regular expression formula for "severity" match
			$regex_formula = \'/<tr>\'.
				\'<td class="row_header">Severity<\/td>\'.
				\'<td class="row_header">Priority<\/td>\'.
				\'<td class="row_header">Status<\/td>\'.
				\'<td class="row_header">Fixed in Milestone<\/td>\'.
				\'<\/tr>\'.
				\'<tr align="center">\'.
				\'<td class=".*?">(.*?)<\/td>/\';
			
			// Run preg match and assign match to "severity" variable
			preg_match($regex_formula, $filein, $matches);
			$severity = $matches[1];
			
			// Regular expression formula for "reporter" match
			$regex_formula = \'/<td width="25">Reporter:&nbsp;<\/td>\'.
				\'<td><a href="mailto:.*?">(.*?) &lt;.*?&gt;<\/a><\/td>/\';
				
			// Run preg match and assign match to "reporter" variable
			preg_match($regex_formula, $filein, $matches);
			$reporter = $matches[1];
			
			// Regular expression formula for "assignee" match
			$regex_formula = \'/<td width="25">Assignee:&nbsp;<\/td>\'.
				\'<td><a href="mailto:.*?">(.*?) &lt;.*?&gt;<\/a><\/td>/\';
			
			// Run preg match and assign match to "assignee" variable
			preg_match($regex_formula, $filein, $matches);
			$assignee = $matches[1];
			
			// Store bugs in bug array
			$currentBug = 
			$bugs[] = array(
		  	\'id\'=>trim($tcFailedRS[\'bug_id\']),
				\'summary\'=>trim($summary),
				\'severity\'=>trim($severity),
				\'reporter\'=>trim($reporter),
				\'assignee\'=>trim($assignee));
				
		}
		
		$this->bugs = $bugs;
	}
	
	private function setCounts(){
		$tcCountsQuery = mysql_query(
			"SELECT ".
			"(SELECT COUNT(1) ".
			"FROM tcdb_results ".
			"WHERE build_uid = $this->build_uid) ".
			"AS all_total, ".
			"(SELECT COUNT(1) ".
			"FROM tcdb_results ".
			"WHERE tcdb_results.build_uid = $this->build_uid ".
			"AND (status = 1 OR status = 2)) ".
			"AS all_completed, ".
			"(SELECT COUNT(1) ".
			"FROM tcdb_results ".
			"WHERE tcdb_results.build_uid = $this->build_uid ".
			"AND status = 1) ".
			"AS all_passed, ".
			"(SELECT COUNT(DISTINCT build_uid, testcase_uid, status) ".
			"FROM tcdb_results ".
			"INNER JOIN tcdb_testcases ON tcdb_results.testcase_uid=tcdb_testcases.uid ".
			"WHERE build_uid = $this->build_uid ".
			"AND tcdb_testcases.category_id = 0 ".
			"AND status = 2) ".
			"AS install_total, ".
			"(SELECT COUNT(DISTINCT build_uid, testcase_uid, status) ".
			"FROM tcdb_results ".
			"INNER JOIN tcdb_testcases ON tcdb_results.testcase_uid=tcdb_testcases.uid ".
			"WHERE build_uid = $this->build_uid ".
			"AND tcdb_testcases.category_id = 1 ".
			"AND status = 2) ".
			"AS configuration_total, ".
			"(SELECT COUNT(DISTINCT build_uid, testcase_uid, status) ".
			"FROM tcdb_results ".
			"INNER JOIN tcdb_testcases ON tcdb_results.testcase_uid=tcdb_testcases.uid ".
			"WHERE build_uid = $this->build_uid ".
			"AND tcdb_testcases.category_id = 2 ".
			"AND status = 2) ".
			"AS file_system_total, ".
			"(SELECT COUNT(DISTINCT build_uid, testcase_uid, status) ".
			"FROM tcdb_results ".
			"INNER JOIN tcdb_testcases ON tcdb_results.testcase_uid=tcdb_testcases.uid ".
			"WHERE build_uid = $this->build_uid ".
			"AND tcdb_testcases.category_id = 3 ".
			"AND status = 2) ".
			"AS authentication_total"
			) or die("Could not get information");
		
		$this->counts = mysql_fetch_array($tcCountsQuery);
	}
	
	private function setSeverityPercentages(){
		if (count($this->bugs)) {
			
			$severityCounts = array(
				\'blocker\'=>0,
				\'critical\'=>0,
				\'major\'=>0,
				\'normal\'=>0,
				\'minor\'=>0,
				\'enhancement\'=>0
				);
			
			foreach($this->bugs as $bug){
			  if(strcasecmp($bug[\'severity\'],"blocker")==0) $severityCounts[\'blocker\']++;
			  if(strcasecmp($bug[\'severity\'],"critical")==0) $severityCounts[\'critical\']++;
			  if(strcasecmp($bug[\'severity\'],"major")==0) $severityCounts[\'major\']++;
			  if(strcasecmp($bug[\'severity\'],"normal")==0) $severityCounts[\'normal\']++;
			  if(strcasecmp($bug[\'severity\'],"minor")==0) $severityCounts[\'minor\']++;
			  if(strcasecmp($bug[\'severity\'],"enhancement")==0) $severityCounts[\'enhancement\']++;
			}
		
			$severityPercentages = array(
				\'blocker\'=>round($severityCounts[\'blocker\'] / count($this->bugs) * 100),
				\'critical\'=>round($severityCounts[\'critical\'] / count($this->bugs) * 100),
				\'major\'=>round($severityCounts[\'major\'] / count($this->bugs) * 100),
				\'normal\'=>round($severityCounts[\'normal\'] / count($this->bugs) * 100),
				\'minor\'=>round($severityCounts[\'minor\'] / count($this->bugs) * 100),
				\'enhancement\'=>round($severityCounts[\'enhancement\'] / count($this->bugs) * 100)
				);
				
		}
		
		$this->severityPercentages = $severityPercentages;
	}
	
	private function setCategoryPercentages(){
	  
	  if ($this->counts[\'all_completed\'] - $this->counts[\'all_passed\']) { // only if a test case has failed
	  
			// These are failed test cases.
			// It is different than the SQL (all_total-all_passed) because duplicate OS\'s are removed
			// It is different than # of bugs because many test cases could be associated with a single bug
			$totalFailedCases = 
				$this->counts[\'install_total\'] + 
				$this->counts[\'configuration_total\'] +
				$this->counts[\'file_system_total\'] +
				$this->counts[\'authentication_total\'];
			
			/* Debug code
			echo "install total" . $this->counts[\'install_total\'] . "<br>";
		  echo "config total" . $this->counts[\'configuration_total\'] . "<br>";
		  echo "file total" . $this->counts[\'file_system_total\'] . "<br>";
		  echo "auth total" . $this->counts[\'authentication_total\'] . "<br>";
		  echo "bugcount" . count($this->bugs) . "<br>";
			*/
			
			$categoryPercentages = array(
				\'install\'=>round($this->counts[\'install_total\'] / $totalFailedCases * 100),
				\'configuration\'=>round($this->counts[\'configuration_total\'] / $totalFailedCases * 100),
				\'file_system\'=>round($this->counts[\'file_system_total\'] / $totalFailedCases * 100),
				\'authentication\'=>round($this->counts[\'authentication_total\'] / $totalFailedCases * 100)
				);	
			
		}
		
		$this->categoryPercentages = $categoryPercentages;	
	}

}
?>
');
?>