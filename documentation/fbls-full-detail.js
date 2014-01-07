/** 
 * FACEBOOK LIKES IN LEARNINGSTUDIO
 *
 * @author    Jeof Oyster <jeof.oyster@pearson.com>
 * @partner   Brittney Cunningham <brittney.cunningham@asu.edu>
 * @copyright 2013 Pearson 
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version   1.0
 * @date      2013-11-11
 * 
 * Please refer to the License file provided with this sample application 
 * for the full terms and conditions, attributions, copyrights and license details.
 */


/* THIS FILE 
 * This file is a expanded version of fbls.js, intended to show how the 
 * widget works. Note that the actual fbls.js has been optimized and minified. 
 * This version is quite verbose and intended for instruction only. 
 */


// Write JQuery to the page if it doesn't already exist.
// This script uses JQuery to simplify cross-browser XHR functionality. 
window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>')

$(document).ready(function(){
    
    // Define the variables that apply to your implementation
    var Facebook_App_ID = '000000000000000'; // create this in Facebook
    var Landing_Page_URL = 'http://url.com'; // host this somewhere on a server you control
    
    // Set up vars we need in this script 
    var userId;                     //User ID (returned asynchronously) 
    var courseId;                   //Course ID (returned asynchronsouly) 
    var QueryString = function(){   //Content Item ID (parsed from LearningStudio content frame URL) 
      var query_string = {};
      var query = window.location.search.substring(1);
      var vars = query.split("&");
      for (var i=0;i<vars.length;i++) {
          var pair = vars[i].split("=");
          if (typeof query_string[pair[0]] === "undefined") {
              query_string[pair[0]] = pair[1];
          } else if (typeof query_string[pair[0]] === "string") {
              var arr = [ query_string[pair[0]], pair[1] ];
              query_string[pair[0]] = arr;
          } else {
              query_string[pair[0]].push(pair[1]);
          }
      } 
      return query_string;
    }();
    
    // Start the process by sending the asynchronous requests for User and Course information.
    $.getJSON("http://dynamiccoursedata.next.ecollege.com/userinfo/json.ed?callback=?",receiveAsynchInfo); 
    $.getJSON("http://dynamiccoursedata.next.ecollege.com/courseinfo/json.ed?callback=?",receiveAsynchInfo); 
    
    
    // Handler for receiving User and Course information asynchronously
    function receiveAsynchInfo(data){ 
        if(data.courseInfo!=undefined){ 
          courseId = data.courseInfo.courseID; 
        } else if(data.userInfo!=undefined){ 
          userId = data.userInfo.userID; 
        } 
        LoadFacebookButtons(); 
    } 
    
    
    // Load the Facebook buttons once we have course and user information
    function LoadFacebookButtons(){ 
        
        // Check for user and course information. If not present, wait for the asynch's to load. 
        if(courseId!=undefined && userId!=undefined){ 
            
            // Make sure we have the expected parameters, in particular, the content item ID's we parsed from
            // the LearningStudio frame URL, above. Also the Facebook App ID and a Landing Page URL. 
            if(QueryString.courseItemSubId==undefined || QueryString.courseItemType==undefined || Landing_Page_URL==undefined || Facebook_App_ID==undefined) return false;

            // Assemble the Content Item ID that will be used in the Landing Page. Note that in order to use the ID with 
            // the LearningStudio REST APIs, the ID that is used in the LearningStudio UI needs to be prepended with either 
            // 100 or 200 depending on whether the content item is a normal item or a unit item (respectively). 
            var contentItemId = ((QueryString.courseItemType=='CourseContentItem')?'100':'200')+q.courseItemSubId;
            
            // Create the Landing Page URL, appending the course, user and content item IDs the APIs will need. 
            var AssembledLandingPageURL = Landing_Page_URL+((Landing_Page_URL.indexOf('?')<0)?'?':'&')+'course='+courseId+'&user='+userId+'&content_item='+contentItemId; 

            // Assemble the URL for the Facebook button, escaping the AssembledLandingPageURL
            var FacebookLikeButtonURL = '//www.facebook.com/plugins/like.php?href='+escape(AssembledLandingPageURL)+'&width=50&layout=button&action=like&show_faces=false&share=false&height=35&appId='+Facebook_App_ID;
            
            // Render the FB button anywhere we find an IFRAME with the class "fb-like-button"
            $('iframe.fb-like-button').attr('src', FacebookLikeButtonURL)
                                      .attr('allowTransparency','true')
                                      .attr('frameborder','0')
                                      .attr('scrolling','no')
                                      .css({'border':'none','overflow':'hidden','height':'35px','width':'50px'})
                                      .show();
        }
    } 
    
}); 
