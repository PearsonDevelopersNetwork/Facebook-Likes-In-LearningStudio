<?php
/** 
 * FACEBOOK LIKES IN LEARNINGSTUDIO
 *
 * @author    Jeof Oyster <jeof.oyster@pearson.com>
 * @partner   Brittney Cunningham <brittney.cunningham@asu.edu>
 * @copyright 2013 Pearson 
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   1.0
 * 
 * Please refer to the License file provided with this sample application 
 * for the full terms and conditions, attributions, copyrights and license details. 
 */
 
/** 
 * LANDING PAGE 
 * This is a sample intermediary page that you would give to Facebook as the 
 * "liked" page. Using our JavaScript widget, this page should receive 3 parameters: 
 * course = the Course ID
 * user = the User ID
 * content_item = the Content Item ID
 * 
 * Use the LearningStudio APIs to retrieve additional information for these objects 
 * and display it to Facebook and the student's friends. 
 * 
 * This example is written in PHP and uses OAuth 1.0 to retrieve the information, 
 * but you can use any language you prefer provided you render the appropriate 
 * Facebook HTML tags to the <head>. 
 *
 * Also, you can use any LearningStudio API to retrieve information for the 
 * promotional element of this page, including the actual page content (which you 
 * could show in a truncated form, for example). However some APIs will require 
 * an OAuth 2 token, which is outside the scope of this example. Refer to 
 * LearningStudio API documentation for the full scope of possibilities and requirements. 
 */
 
// Including some functions for making OAuth 1 calls. 
include('libraries/functions.php'); 

// Gather the parameters sent to this page when the Like button was clicked. 
$course_id  = $_REQUEST['course'];
$user_id    = $_REQUEST['user'];
$content_id = $_REQUEST['content_item'];

// These are your institution's API Keys. They can be requested from your 
// client services consultant at Pearson. Keep these secure and safe. 
$oauth_application_id    = 'd23df54b-abb2-4dbb-b394-cdb10d4a35cf'; 
$oauth_token_key_moniker = '04b11650-b3bb-41d6-91a6-c19936aaf4e5'; 
$oauth_secret            = '8a72063be6d0409da86a5c239e39fd10'; 

// Make a few API calls. Note this is a streamlined implementation of calling 
// APIs for this example application. 
$user_info = doLearningStudioGET('/users/'.$user_id); 
$course_info = doLearningStudioGET('/courses/'.$course_id); 
$content_info = doLearningStudioGET('/courses/'.$course_id.'/items/'.$content_id); 

// Extract some information about the course, content and user from the APIs.
$course_title = $course_info->courses[0]->title; 
$content_title = $content_info->items[0]->title; 
$user_firstname = $user_info->users[0]->firstName; 
$user_lastname = $user_info->users[0]->lastName; 
    // Note this is just some of the information you could pull out. 
    // For example, you could also cross reference the Call Numbers or Course Code from  
    // your course catalog system to display marketing descriptions about the course: 
    // $call_numbers = $course_info->courses[0]->callNumbers; 
    // $course_code = $course_info->courses[0]->displayCourseCode; 


// At this point we have all the information we want to use for displaying information 
// to Facebook and to the users who click through to the story from the news feed. 
 
?>
<!DOCTYPE html> 
<html lang="en-US">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    
    <!-- These are the tags that Facebook uses to construct the news feed story. 
         Best practices are found here: https://developers.facebook.com/docs/plugins/checklist
         Customize this section to suit your institution's branding --> 
    
    <!-- The fb:app_id is your Facebook App ID (also used when inserting the Like button in the course). 
         This is needed for tracking analytics properly. --> 
    <meta property="fb:app_id"      content="535504089872870" />
    
    <!-- Customize the title of the page that will display in the news feed. The <meta> tag is the primary source for the news feed, 
         but occasionally Facebook may use the <title> tag as well, so you're encouraged to keep them relatively close in theme. --> 
    <meta property="og:title"       content='"<?=$content_title;?>" in the <?=$course_title;?> course at Strata University' /> 
    <title><?=$user_firstname;?> likes "<?=$content_title;?>" in the <?=$course_title;?> course at Strata University</title>
    
    <!-- Specify the image that Facebook should associate with this page when it appears in the news feed. 
         Their recommendations say it should be at least 600x315 but bigger is always better. Stick to a 1.91:1 aspect ratio --> 
    <meta property="og:image"       content="http://<?=$_SERVER["HTTP_HOST"];?><?=str_replace('index.php','strata_promo.jpg',$_SERVER["REQUEST_URI"]);?>" />
    
    <!-- Additional detail that Facebook may display on larger stories in the news feed. --> 
    <meta property="og:description" content="<?=$course_title;?> is one of the many courses offered in the fully online program at Strata University. <?=$user_firstname;?> likes this course, you could too! Find out more about our fully online programs." />

    <!-- Put your "Site name" here, which is probably going to be your institution or school/division's name --> 
    <meta property="og:site_name"   content="Strata University" />
    
    
    <!-- Add stylesheets and other important links here --> 
    <link rel="stylesheet" href="css/main.css" type="text/css" />
</head>
<body>
    
<!-- Page Body goes here. For the Like button, Facebook will generally rely on the <meta> tags above, meaning you can 
     create almost anything you want here and it shouldn't impact what appears in the news feed. However if you have any trouble 
     with that, you can also programmatically hide this from Facebook's user agent: 
     "facebookexternalhit/1.1 (+https://www.facebook.com/externalhit_uatext.php)" 
     --> 
     
     
     
	<header>
	    <img src="images/logo.png" alt="Strata University" />
    </header>
    
    <article> 
        <h1><strong><?=$user_firstname;?></strong> is taking <strong><?=$course_title;?></strong> at Strata University</h1>
        <div class="left-column">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec urna nunc, convallis sed purus sit amet, ultricies imperdiet purus. Cras odio lacus, tempor ut blandit quis, ullamcorper nec est. Cras tempor tempor iaculis. Sed quis fermentum nisl, sed elementum nisi. Maecenas dignissim lacinia tortor venenatis consequat. Suspendisse pellentesque imperdiet dui nec rhoncus. Donec nec eros sed enim porta egestas id et diam. Pellentesque vitae urna at ipsum hendrerit vehicula at id magna. Ut eu ante molestie, laoreet massa eu, commodo turpis. Donec vestibulum purus et eleifend tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur a mattis nunc. Donec ac ipsum ut elit tincidunt vestibulum vel a orci. Quisque nisi justo, adipiscing a blandit vitae, facilisis condimentum ante. </p>
        </div>
        <div class="right-column">
            <h2>Check us out</h2>
            <iframe width="100%" height="225" src="//www.youtube.com/embed/KsriJV02V9c" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="clear"></div>
        <div class="left-column">
            <h2>Imagine Yourself at Strata</h2>
            <p>Request more information and one of our ambassadors will give you a ring to answer any questions you have!</p> 
            <form> 
                <div>
                    <label>Your name</label> 
                    <input type="text">
                </div> 
                <div>
                    <label>Email address</label> 
                    <input type="text">
                </div> 
                <div>
                    <label>Phone</label> 
                    <input type="text">
                </div> 
                <div>
                    <label>Field of Study</label> 
                    <input type="text">
                </div> 
                <div>
                    <label>&nbsp;</label>
                    <div><button>Gimme a Shout!</button></div>
                </div>
            </form>
        </div>
        <div class="right-column" id="News">
            <h3>News from Strata</h3> 
            <a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit</a>
            <small><?=date("M j, Y");?>&mdash;Cras tempor tempor iaculis. Sed quis fermentum nisl, sed elementum nisi...</small>
            <a href="#">Donec nec eros sed enim porta egestas id et diam</a>
            <small><?=date("M j, Y");?>&mdash;Donec ac ipsum ut elit tincidunt vestibulum vel a orci. Quisque nisi justo, adipiscing a blandit vitae...</small>
            <a href="#">Cras tempor tempor iaculis</a>
            <small><?=date("M j, Y");?>&mdash;Sed quis fermentum nisl, sed elementum nisi, Lorem ipsum dolor sit amet, consectetur adipiscing elit...</small>
        </div>
        <div class="clear"></div>
    </article> 
     
     
    

</body> 
</html>