<?php
/**
 * survey_view.php works with survey_list.php to create a list/view app
 *
 * Based on demo_list_pager.php along with demo_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package SurveySez
 * @author Christina Petrie <christinapetrie@hotmail.com>
 * @version 1.0 2015/02/03
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see survey_list.php
 * @see Pager_inc.php 
 * @todo add class code
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list_pager.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

$mySurvey = new Survey($myID);
//dumpDie($mySurvey);
if ($mySurvey->isValid)
{

	$config->titleTag = $mySurvey->Title . " survey"; 

}else {

	$config->titleTag = "No such survey"; 
}

//dumpDie($mySurvey);


//---end config area --------------------------------------------------

/*if($foundRecord)
{#only load data if record found
	$config->titleTag = $Title . " surveys made with PHP & love!"; #overwrite PageTitle with Muffin info!
	#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
	//$config->metaDescription = $MetaDescription . ' Seattle Central\'s ITC280 Class Muffins are made with pure PHP! ' . $config->metaDescription;
	//$config->metaKeywords = $MetaKeywords . ',Muffins,PHP,Fun,Bran,Regular,Regular Expressions,'. $config->metaKeywords;
}
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php

echo '
	<h3 align="center">' . $config->titleTag . '</h3>
	';
if ($mySurvey->isValid)
{
	//$config->titleTag = $mySurvey->Title . " survey"; 
	echo '
	<p>Here is the Survey\'s description:</p>
	<p>' . $mySurvey->Description . '</p>
	';
	$mySurvey->showQuestions();
	echo SurveyUtil::responseList($myID);
	
}else {//no such survey

	//$config->titleTag = "No such survey"; 
	echo
	'<p>Please check to see if there is a problem</p>';
}
get_footer(); #defaults to theme footer or footer_inc.php


