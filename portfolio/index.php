<html>
<head>
	<title>:: AARONHARDY.COM :: For all your Aaron Hardy needs.</title>
	<META name="description" content="For all your Aaron Hardy needs.">
	<META name="keywords" content="web designer, graphic designer, developer, programmer, php, asp, utah, investor, student, punker">
  <link href="/stylesheet.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="firsttime.js"></script>
  <script>
    
    function show_item(id) {
      document.getElementById('exhibit_' + id).style.display='block';
      document.getElementById('toggle_' + id + '_show').style.display='none';
      document.getElementById('toggle_' + id + '_hide').style.display='block';
    }
    
    function hide_item(id) {
      document.getElementById('exhibit_' + id).style.display='none';
      document.getElementById('toggle_' + id + '_show').style.display='block';
      document.getElementById('toggle_' + id + '_hide').style.display='none';
    }
    
  </script>
</head>
<body background="/images/back.gif" bgcolor="#AFE60A" style="text-align:center;">

<div style="width:610px; background-color:white; border:1px solid black; margin-left:auto; margin-right:auto; text-align:left; padding:8px; font-size: 13px;">
<span style="font-size:38px; font-weight:bold">Portfolio</span>
<p>
<b>What the portfolio <i>is</i>:</b>
<ul>
	<li>a showcase of my past work</li>
	<li>a place to keep my work so I don't lose it</li>
  <li>a resource for other gurus and potential employers</li>
</ul>
<p>
<b>What the portfolio <i>is not</i>:</b>
<ul>
	<li>completely functional.  Over time, relative paths have changed, functions have been deprecated, and files have disappeared.
  <li>a comprehensive collection of all my work.  It's missing material I haven't kept around, material that's behind locked intranets, proprietary material, and a lot of day-to-day material as well.</li>
	<li>perfect.  Many of these projects were intended as personal experiments or educational resources and don't necessarily show my current abilities.</li>
	<li>evenly distributed.  Some of the items required months of effort, while others required a few hours.
</ul>
<p>
With those points in mind, kick back and enjoy the show. If you have any questions, comments, or requests, don't be shy;
you can use my <a href="#" onClick="window.open('/contact.php','contactwindow','screenX=20,screenY=20,left=20,top=20,width=472,height=255')">contact form</a>
and I'll be sure to get back to you.
<p>

<div align="center">
  <input type="button" id="showportfolio" value="Okay, I've read the disclaimer--let's get on with it!" onClick="document.getElementById('portfolio').style.display='block';this.style.display='none';" style="display:none;">
</div>

<div id="portfolio">

<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>AaronHardy.com</b>
<br><i>Photoshop, CSS, HTML</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="http://aaronhardy.com" target="_blank">AaronHardy.com</a> ]
<p>
This is my personal website.  You probably just came from there, so I'll leave it at that.  
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Test Case Reporting Tool</b><br>
<i>PHP, cURL, MySQL, XML, JavaScript, CSS, HTML</i>
</div>
<? registerExpansion(); ?>
<p>
[ Source :: <a href="tcdb/bugdata.php">Bug Data Collector Class</a> ]<br>
[ Source :: <a href="tcdb/category_chart_creator.php">Category Chart Creator</a> ]<br>
[ Source :: <a href="tcdb/severity_chart_creator.php">Severity Chart Creator</a> ]<br>
[ Source :: <a href="tcdb/report.php">Report Template</a> ]<br>
[ Source :: <a href="tcdb/charts.php">Chart XML Generator Class</a> ] - Props to <a href="http://www.maani.us" target="_blank">maani.us</a><br>
[ Module (.swf - right-click &raquo; save link as...) :: <a href="tcdb/charts.swf">Flash Chart Display</a> ] - Props to <a href="http://www.maani.us" target="_blank">maani.us</a><br>
<p>
Because of the need for valuable information, I decided to create several internal reporting tools that provide the status on a current software build.  Before, the most detailed status of a build was only derived after painstakingly finding bugs in the Bugzilla database that pertained to the build.  Even then, management would only see a list of short bug descriptions.  I decided to use a mixture of PHP, cURL, MySQL, HTML, CSS, and JavaScript, coupled with a Flash toolkit, to provide a richer and more precise presentation.  The finished product now produces a printer-friendly report that includes the following data:
<ul>
  <li>Bar charts of test case completion/pass/fail percentages
  <li>Pie chart of failed test cases grouped by category (installation, file I/O, authentication, and configuration)
  <li>Pie chart of reported bugs grouped by severity (blocker, critical, major, normal, minor, and enhancement)
  <li>Details of each reported bug (summary, reporter, assignee, severity, and status)
</ul>
This reporting tool is tightly integrated with Bugzilla (a browser-based application) by authenticating and pulling various bug information through a background process and ensures data integrity by avoiding duplication of data across systems.  Now, managers can get the latest information in one place on the web and print copies for meetings in the click of a button.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Yaooast (Yet Another One of Aaron's Sweet Tools)</b><br>
<i>BASH</i>
</div>
<? registerExpansion(); ?>
<p>
[ Source :: <a href="yaooast/yaooast.php">BASH Script</a> ]<br>
<!--[ Source (file) :: <a href="yaooast/yaooast.sh">BASH Script</a> ]<br>-->
<p>
Yaooast (Yet Another One of Aaron's Sweet Tools) is a Linux shell script I wrote for testing the Novell Client for Linux.  At Novell, when we get a new software build to test, it's critical that we get a quick overview of how it's going to perform.  This tool runs the client through the following tests:
<ul>
  <li>Boundary (credential variations)
  <li>Datetime Preservation
  <li>Project Compile
  <li>Deep Directory with File I/O
  <li>Large File Copy
</ul>
<p>
Now after we get a new build, we can run this script and in just a few minutes we can tell if it's a dud.
<p>
If you'd like to use Yaooast for your own purposes, you'll need to modify the connection settings at the top of the script to fit your particular network.
<p>
<i>Side note: Unless you've used SuSE products, chances are you probably won't find the name very punny.</i>
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>RateMyApartments.com</b><br>
<i>PHP, MySQL, Ajax, CSS, JavaScript, HTML, Photoshop</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="http://www.ratemyapartments.com" target="_blank">RateMyApartments.com</a> ]
<p>
RateMyApartments.com is a venture I embarked on with <a href="http://www.laddmorgan.com" target="_blank">Ladd Morgan</a> in 2005. We haven't earned a penny off it, but we enjoy the gratification of working on it in our spare time.  We believe there are a lot of students like us looking for quality apartments and/or wanting to vent about their previous experiences and we hope to give them a good place to do so.
<p>
The backend of RateMyApartments.com is fairly intelligent.  In our database, we have 3,000+ schools and 50,000+ apartment complexes from around the country, along with their respective longitude and latitude coordinates.  When a user adds an apartment, the script takes the given address, pulls its particular latitude and longitude from a Yahoo web service, and inserts it into our database.  Later, when a user chooses to view all the apartments at a given school, the listing script can quickly perform a few calculations with the coordinates and return all apartments within a given distance of the school.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Google Sitemap Creator</b><br>
<i>PHP, MySQL, XML</i>
</div>
<? registerExpansion(); ?>
<p>
[ Source :: <a href="sitemap_creator/sitemap_creator.php" target="_blank">Sitemap Creator</a> ]
<p>
Search engine optimization (SEO) is crucial to a website's success.  With <a href="http://ratemyapartments.com" target="_blank">RateMyApartments.com</a>, we chose to keep our homepage simple using two dropdown boxes that lead to all other pages within the site.  Although user-friendly, search engine spiders have a hard time following the Ajax/JavaScript interaction.  In order to make sure all pages would be capable of being indexed by Google, we decided to utilize <a href="https://www.google.com/webmasters/sitemaps/docs/en/about.html" target="_blank">Google Sitemaps</a>, a method of communicating a website's structure through XML.
<p>
Because Google limits its sitemaps to 50,000 links (or 10 MB), I designed the creator to split the 220,000+ links into sitemaps with a max of 20,000 links each (to be safe and for easier management).  Then a sitemap <i>index</i> is created that references the individual sitemaps.  The sitemap index is then submitted to Google for spidering.
<p>
Although there are examples of other sitemap creators on the web, I hope this will particularly serve as a valuable resource for those looking for a stand-alone, backward-compatible script capable of handling many thousands of links.  If you happen to be running PHP5 and are looking to do any XML manipulation, check out the <a href="http://us3.php.net/simplexml" target="_blank">SimpleXML extension</a> that can help ease the development process.   
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>BCSVictims.com&#8482;</b><br>
<i>PHP, MySQL, CSS, JavaScript, HTML, Photoshop</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="http://www.bcsvictims.com" target="_blank">BCSVictims.com</a> ]
<p>
BCSVictims.com&#8482; is a venture I embarked on with Cameron May, my brother-in-law.  It's a place of refuge for those college football fans whose teams don't pertain to the Bowl Championship Series, otherwise known as the BCS.  It's our way of creating a movement and giving fans a way to show that the corrupt actions of the BCS will not go unnoticed.   
<p> 
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>BYU Broadcasting</b><br>
<i>ASP, SQL, CSS, JavaScript, HTML, Photoshop, Fireworks</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="http://www.byub.org" target="_blank">BYU Broadcasting</a> ]<br>
[ Website :: <a href="http://www.byutv.org" target="_blank">BYU Television</a> ]<br>
[ Website :: <a href="http://www.byuradio.org" target="_blank">BYU Radio</a> ]<br>
[ Website :: <a href="http://www.kbyutv.org" target="_blank">KBYU-TV</a> ]<br>
[ Website :: <a href="http://www.classical89.org" target="_blank">Classical 89</a> ]
<p>BYU Broadcasting, where I worked for two years, is a division of <a href="http://www.byu.edu" target="_blank">Brigham Young University</a> and specializes in broadcasting <a href="http://www.lds.org" target="_blank">LDS</a>-related material over television, radio, and Internet.

<p>During my stay, the site went through a complete restructuring.  At <a href="http://web.archive.org/web/20010522053506/http://www.kbyu.org/" target="_blank">its infancy</a>, the site consisted of a bunch of HTML files that were basically simple brochures.  If a programmer wanted to change a link on the navigation bar, he or she would have to manually change each page.  Now, it's a flourishing oasis of goodness offering many utilities to help users find what they're looking for--whether it be broadcast schedules, video, audio, transcripts, etc.  Also, a majority of the content can be easily changed through back-end, browser-based utilities.  This really cut down on a lot of work while allowing the site to quickly expand.  It now receives about 4 million visitors yearly.  I also created many intranet applications for automating internal processes, but the code is proprietary, so unfortunately I can't post it.

<p>Also of note--since I left BYU Broadcasting, some changes have been made to the site.  So, I'll take credit for the good changes and not for the bad ones.  You know how it goes.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>INTEX 2</b><br>
<i>Java, JSP, CSS, HTML, Photoshop</i>
</div>
<? registerExpansion(); ?>
<p>
<!--[ Quicktime Screencast (.qtl - <b>272 MB</b>) :: <a href="intex2/BlockwoodDemo.qtl">System Demo</a> ]<br>--> 
[ Source (.zip) :: <a href="intex2/intex2code.zip">Blockwood Check-out and Management System</a> ]<br>
[ Javadoc (.zip) :: <a href="intex2/intex2javadoc.zip">Blockwood Check-out and Management System</a> ]<br>
[ Programmer Manual (.pdf) :: <a href="intex2/programmermanual.pdf">Blockwood Check-out and Management System</a> ]<br>
[ User Manual (.pdf) :: <a href="intex2/usermanual.pdf">Blockwood Check-out and Management System</a> ]
<p>INTEX 2 (Integrated Exercise) was a semester-long project done in a team of four. It's called an "integrated exercise" because it integrates principles from three separate classes within the information systems junior core program.  We  spent a few hours to many hours each night working on it, and in the end it came together fairly well.
<p>The project consists of a system designed for a fictional movie rental chain (like Blockbuster or Hollywood).  Modules include:
<ul>
	<li>Check-out</li>
	<li>Refunds</li>
	<li>Membership management</li>
	<li>Database management</li>
	<li>Rental returns</li>
	<li>Accounting</li>
	<li>Website</li>
</ul>
<p>The functionality related with the system is highly extensive and is fairly well documented in the user and programmer manuals, so if you'd like to dig in more, feel free.  This project is a great example of object-oriented programming, model-view controllers, caching, etc, etc.  After adding a few authentication modules and slight customization, the system should literally be ready to run within an existing movie rental chain.  This was definitely a very good experience to work on a real-world example and to learn excellent programming principles.
<p><i>Side Note: The only part that isn't completely documented is the website, which is where customers can go to search for available rental videos.  The search will return the stores that have the rental videos available for rent with the given title.  The customer can then choose to reserve the video, which will in turn send a text message (using JavaMail) to a cell phone (presumably that of a store clerk), so that the video can be pulled off the shelf.  The reservation then expires after one hour and another customer can choose to rent the video.  With the website, a customer can also find out which videos he/she has checked out.</i>
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Mister Suite</b><br>
<i>Access, Excel, Word, VBA</i>
</div>
<? registerExpansion(); ?>
<p>
[ Source (.zip) :: <a href="mister/MrFinanciero.zip" target="_blank">Mr. Financiero</a> ]<br>
[ Source (.zip) :: <a href="mister/MrHistoriador.zip" target="_blank">Mr. Historiador</a> ]<br>
[ Source (.zip) :: <a href="mister/MrSecretario.zip" target="_blank">Mr. Secretario</a> ]<br>
[ Source (.zip) :: <a href="mister/MrComisario.zip" target="_blank">Mr. Comisario</a> ]
<p>
As a missionary for <a href="http://lds.org">The Church of Jesus Christ of Latter-day Saints</a> in Ecuador, I was appointed as Historian in the mission office.  I could immediately see that a lot of the office processes could be made much more efficient, so, while I wasn't busy entering baptism forms, I decided to program a suite of applications to help out.  Note that this suite was developed for a network of computers; therefore, processes requiring the connection between nodes may not function correctly if you test it on your local workstation.
<p>
Mr. Financiero is used for dealing with all of the mission's finances.  With this, the financer can import missionary information from Mr. Secretario, have a base deposit for each missionary, reimburse or deduct certain amounts for medical, travel, or other categorized reasons.  It is also tied into Mr. Comisario to automatically deduct certain amounts for missionary material purchases.  With the click of a button, the application will print general ledgers to be sent to auditing offices and write to a file that would be transferred to a bank for automatic deposits.
<p>
Mr. Historiador is used for storing information about baptisms and the progress of each missionary companionship.  With this information, reports are then created for the mission president and zone leaders to review.
<p>
Mr. Secretario is used for storing personal information about missionaries.  In addition, using mail merge functionality, the secretary can automatically generate many documents customized to specific missionaries and in their appropriate languages.
<p>
Mr. Comisario is used for conducting transactions of missionary material.  The commissary orders material from distribution centers for the missionaries to purchase.  This application keeps track of what inventory needs to be replenished and which missionaries have over-purchased.  It also ties directly into Mr. Financiero to automatically deduct purchase costs from the respective missionary accounts.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Java Potpourri</b><br>
<i>Java</i>
</div>
<? registerExpansion(); ?>
<p>
[ Source (.zip) :: <a href="java_examples/java_examples.zip">Java Examples</a> ]
<p>This zip file contains several Java examples from my Java beginnings that could be useful to aspiring programmers. The following are included:
<ul>
  <li>Currency converter</li>
  <li>XML parser<li>
  <li>Benford's Law fraud analyzer</li>
  <li>Chat room</li>
  <li>Delimited file reader</li>
  <li>Change order fraud analyzer</li>
  <li>GUID creator</li>
  <li>State & capital game</li>
  <li>Web scraper</li>
</ul>  
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>INTEX 1</b><br>
<i>Microsoft Office (+Visio, Project)</i>
</div>
<? registerExpansion(); ?>
<p>
[ Proposal (.pdf) :: <a href="intex1/RMA.pdf">Rocky Mountain Airlines Inventory Management System</a> ]<br>
[ Presentation (.ppt) :: <a href="intex1/RMA.ppt">Rocky Mountain Airlines Inventory Management System</a> ]<br>
<p>INTEX 1 (Integrated Excercise) was a week-long project done in a team of four. It's called an "integrated excercise" because it integrates principles from three seperate classes within the information systems junior core program. We spent every waking hour of the week working on it (literally), and in the end it really came together well.
<p>The project consisted of compiling a proposal for an airline inventory management system.  The system would be used for tracking how long parts have been in the air, when they need to be replaced, where the airplane needs to go to get serviced, recording details of repairs, etc.  The proposal had to include development schedules, feasibility analyses, and financial terms, among other things.  We then had to present the proposal to a panel (college professors and sponsoring corporate employees) representing the corporate board of directors to sell them on the project.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>MrsHardy.com</b><br>
<i>PHP, MySQL, CSS, HTML, Photoshop</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="http://www.mrshardy.com" target="_blank">MrsHardy.com</a> ]<br>
[ Source :: <a href="mrshardy/index.php" target="_blank">Links Manager</a> ]<br>
[ Source :: <a href="mrshardy/addresses.php" target="_blank">News Manager</a> ]<br>
[ Source :: <a href="mrshardy/news.php" target="_blank">Mailing List Manager</a> ]
<p>
Mrs. Hardy, <a href="http://aaronhardy.com/images/investor/wedding.jpg" target="_blank">my wife</a>, is a fourth grade teacher.  She had a hard time keeping track of all the links for her kids to visit, so I decided to alleviate some of the pain by creating a website for her.  It's backed by a browser-based management system where she can manage the links and add news bits to the site.  I also provided her with a mailing list manager where she can add the email addresses of her students' parents.  When she has news, she can opt to post it to the site, send it to all the addresses in the mailing list, or both.
<p>
For obvious reasons, I can't provide access to the management system, but I've posted the code for your enjoyment.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Flash Password Protection</b><br>
<i>Flash 4</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="http://www.flashkit.com/movies/Scripting/String_Manipulation/Password-Aaron_A-457/index.php" target="_blank">Flash Kit Exhibit</a> ]<br>
[ Source (.zip) :: <a href="flash_password_protection/flash_password_protection.zip">FLA, SWF, and HTML source files</a> ]
<p>
This is a simple flash password protection script I created back in the year 2000 while I was experimenting with different flash authentication techniques. At that time, I hadn't seen many examples on the web of how to do it, so after I created a solution that fit my fancy, I submitted it to Flash Kit for others to draw ideas from.  Since then, it's been downloaded over 20,000 times and seems to be favored for its simplicity and robustness.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Dogline</b><br>
<i>Photoshop</i>
</div>
<? registerExpansion(); ?>
<p>
[ Mockup (.jpg) :: <a href="dogline/layout.jpg" target="_blank">Dogline Layout</a> ]<br>
[ Source (.psd) :: <a href="dogline/dogvector.psd" target="_blank">Logo</a> ]<br>
[ Source (.psd) :: <a href="dogline/tier.psd" target="_blank">Layout</a> ]<br>
<p>
This is one of the many experimental mock-ups I create.  I post it here so you can pull it into Photoshop and see how my websites are conceived.  After creating the mock-up, I slice the design up into pieces that I then code into an functioning web page using CSS, JavaScript, HTML, etc.  After it looks good on the web, I then add in the back-end scripting elements as needed.
<p>
By the way, none of these files are copyrighted and were never put into actual production, so if you'd like to use them, feel free.  Just drop a tip in the bucket.
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Xeba.com - 2000</b><br>
<i>Flash 4, HTML</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="aaronhardy_2000/" target="_blank">Xeba.com - 2000</a> ]<br>
<p>
This was my personal website made in 2000 when I was a junior in high school.  I was really into Flash 4 at the time and decided to add the Mr. Flash feature, where stumped Flash learners could ask their most difficult questions and hopefully I could answer them.  It was surprisingly successful--in a relative kind of way.  
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>Xeba.com - 1999</b><br>
<i>HTML, Paint Shop Pro</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="aaronhardy_1999/" target="_blank">Xeba.com - 1999</a> ]<br>
<p>
This was my personal website made in 1999 when I was a sophomore in high school.  
</div>
</div>
<!--exhibit boundary-->
<div class="exhibit">
<div style="float:left">
<b>4th Rock: Mars Exploration</b><br>
<i>Flash 4, HTML</i>
</div>
<? registerExpansion(); ?>
<p>
[ Website :: <a href="bpa/" target="_blank">4th Rock: Mars Exploration</a> ]<br>
[ Source :: <a href="bpa/final.fla">4th Rock: Mars Exploration</a> ]<br>
<p>
This was the first website I created in Flash.  I created it in the year 2000 for a competition called Business Professionals of America where it performed quite well.  
</div>
</div>
<!--exhibit boundary-->
</div>
</div>
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
<?
function registerExpansion() {
  global $id;
  $id++;
  echo "<div id=\"toggle_{$id}_show\" style=\"float:right\">[ <a href=\"#\" onClick=\"show_item($id); return false;\">show item</a> ]</div>\n";
  echo "<div id=\"toggle_{$id}_hide\" style=\"float:right; display:none\">[ <a href=\"#\" onClick=\"hide_item($id); return false;\">hide item</a> ]</div>\n";
  echo "<div style=\"clear:both\"></div>\n";
  echo "<div id=\"exhibit_$id\" style=\"display:none\">\n"; 
}
?>
