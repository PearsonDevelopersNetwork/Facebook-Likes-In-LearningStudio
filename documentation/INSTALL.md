Implementing Facebook Likes in LearningStudio
=============================================

Cloning the Repository 
----------------------

When cloning the repository, use a recursive clone, i.e.: 

    git clone --recursive https://github.com/PearsonDevelopersNetwork/Facebook-Likes-In-LearningStudio.git

The intermediary "Landing Page" sample code uses a submodule for calculating the authentication signature in LearningStudio's API calls.  You may choose to implement your own logic for the intermediary page, and may or may not use the library then, but if you're going to use the PHP demo, grab all the modules in one go. 


Creating a Facebook Application
-------------------------------

You need to create a Facebook application. This is how Facebook tracks and regulates all its API activity, including Likes. Join the [Facebook Developers Program](https://developers.facebook.com/) and create an App. Once you do, you'll have an App ID. Your app will also be in Sandbox mode, which you should turn off. You don't need to do anything else with this application, it's just a container for accessing the analytics information. 


Implement an Intermediary Page
------------------------------

You need to provide a publicly accessible intermediary landing page that Facebook can retrieve for its meta data. This is also the page that people will land on when they click the Like story in a student's news feed.

A sample implementation of this page is found in the `code/landing-page` directory. This file shows how to receive standard parameters, call some basic LearningStudio APIs, and implement the important `<meta>` tags for Facebook's system. It also shows some basic ideas for how to use the page for marketing purposes - but this is completely up to your creativity (provided you have the stuff Facebook needs). 

Note when you implement the `<meta>` tags on your landing page, one of them is for the Facebook App ID you created in the previous section. 


Host the Facebook Widget Code Somewhere
---------------------------------------

When you implement a landing page, you should also host the `code/fbls.js` file provided here. This widget handles all the work of preparing and rendering the Facebook Like button in a LearningStudio content item. Make note of the publicly accessible URL where this file can be loaded. 


Implement the HTML in a LearningStudio Content Item
---------------------------------------------------

To implement the code in LearningStudio, you will need the Facebook App ID you created above, the URL of the landing page, and the URL pointing to `fbls.js`. 

In LearningStudio Author mode, choose a content item and start editing it. Use "HTML" mode in the Visual Editor (the button is at the bottom of the editor). Important: Do *not* use "Plain Text Editor" because this will sanitize your HTML tags. 

In HTML mode, copy and paste this code anywhere in the code (usually at the top of bottom), replacing the `{parameters}` with the appropriate values. You only need to do this part once for each content item, but these values will be the same for all content items and all courses.

    <script type="text/javascript">
        var Facebook_App_ID = '{YOUR_FACEBOOK_APP_ID}';
        var Landing_Page_URL = '{URL_OF_LANDING_PAGE}';
    </script>
    <script type="text/javascript" src="{URL_TO_FBLS.JS}"></script>

Next you need to place an IFRAME wherever you want the Like button to appear. Note, you can implement multiple Like buttons in a content item (though they will all "like" the *same* content item). Also note, the JavaScript widget will unhide the iFrame if it can successfully load the button. 

    <iframe class="fb-like-button" style="display:none"></iframe>
    
> *Important: LearningStudio requires the full closing tag (i.e., `</iframe>`).*
> 
> *Note: You can add additional CSS styles inline to the `<iframe>`. The JavaScript widget will append what it needs to yours, but will overwrite border, width, height and overflow.*

Save and publish the Content Item. The Like button will load asynchronously once the document is ready. 


Checklist for Implementing Facebook Likes in LearningStudio
===========================================================

1. Optional: Clone the repo for a full working demo (in PHP).

2. Create a Facebook App.
 * **Save:** The Facebook App ID. 

3. Request LearningStudio API keys from your client services consultant if you don't already know them. 

4. Create an image for Facebook to use as a thumbnail with the news feed stories.

5. Create & host an intermediate landing page that uses LearningStudio APIs to render contextual detail for Facebook and the student's friends. 
 * Use: Facebook App ID
 * Use: LearningStudio APIs (Keys needed) to get contextual data
 * Use: The image you created in step 3
 * **Save:** The publicly accessible URL for this page. 

6. Host the fbls.js file somewhere publicly accessible. 
 * **Save:** The publicly accessible URL for this file. 

7. Edit the JavaScript code above with the correct details
 * Use: Facebook App ID
 * Use: The URL of the landing page
 * Use: The URL of the fbls.js file 

8. Copy the JavaScript code into a content item in HTML mode. Add the `<iframe>` anywhere you want a Like button to appear. 
 * Use: Your edited JavaScript code from Step 6.

9. Repeat Step 8 for every content item where you want a Like button to appear. 