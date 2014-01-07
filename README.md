Facebook Likes in LearningStudio
================================

> #### Documentation Guide
> documentation/LICENSE.md  
> documentation/INSTALL.md  
> documentation/ExperienceSample.pdf  
> documentation/fbls-full-detail.js  


Overview
--------

The majority of online students will use Facebook, and the Facebook ecosystem offers a way to measure and improve student engagement with course content while also promoting a university's online program. 

This example leverages Facebook's Like buttons to allow students to flag pages of course content inside LearningStudio as particularly strong content. This publishes the activity to their Facebook walls, which while fostering continued engagement through social reinforcement also gives the instructional designer insight into popular content or courses and promotes the university via word of mouth marketing in otherwise potentially closed communities. 

The problem has been that "liking" content on Facebook typically requires the content to be publicly available. Facebook makes a request to the page to get information about it, including the name and a thumbnail to display in Facebook. Since course content is nonpublic, the answer is to provide Facebook a public intermediate page. Using LearningStudio APIs, this page can show Facebook's system the relevant information it needs for the student's Facebook wall, but then also displays marketing-style content to the student's friends who click on the link.


The User Experience
-------------------

> See documentation/ExperienceSample.pdf for a visual example.


1. Student clicks the "Like" button that appears in any given page of content. 

2. Rather than sending the content page to Facebook as the liked page, the intermediate landing page URL is sent instead. 

3. The landing page uses LearningStudio APIs to look up course information. This detail, including a thumbnail image reference if desired, is inserted into meta tags shown only to Facebook and used in the story posted to the student's Facebook page. 

4. When the student's friends click on the story in the Facebook feed, they are shown a full marketing page about the course and/or the school. This could include: 
 * a reference to the original student (e.g., "Bill is enjoying his class at Strata University")
 * a description of the course or school/division the student is enrolled in 
 * sample content from the course 
 * general marketing information and an information request form

5. Pages that are 'liked' will appear in the related Facebook application's analytics system, allowing the instructional designer or teacher the option to see which content or courses are the most popular. 


Implementation
--------------

> See INSTALL.md Guide for more details.

1. The institution or instructional designer should create a Facebook application the Facebook Developers Portal. The Application ID is required when implementing the Like button in courses. 

2. The institution will need to design and implement the marketing copy for the landing page. The sample included here demonstrates some possibilities. This file should be hosted in a publicly accessible place, and the URL will be required when implementing the Like button in courses. 
 * The key to the landing page is using LearningStudio's REST APIs and writing the correct <meta> tags to the HTML for Facebook. 
 * While our sample page is built in PHP, a skilled developer can implement it in any programming language 

3. The institution should host the fbls.js file alongside the landing page (i.e., in a publicly accessible place). The URL to this file will be required when implementing the Like button in courses. 

4. The instructional designer will need to implement the provided JavaScript and HTML code on any and every page of content in LearningStudio where they want a Like button to appear. 



Compatibility 
-------------

 * This workflow should function in any browser supported by LearningStudio. 
 * The Like buttons can be implemented in Master courses and copied to course sections. 
 * The Like button can probably be implemented in Content Managed course content (content must be published for this to work). 
 * The Like button has not been tested with Equella-powered content. 
 * A Facebook account is required for students to Like and publish content to their Facebook walls. 


How It Works (Technology Used) 
------------------------------

 1. A JavaScript widget (fbls.js) parses the content item ID from the LearningStudio content frame. 
 
 2. Using the LearningStudio content extension JavaScript tools, available to the LearningStudio Visual Editor, retrieves the course ID and user ID. 
 
 3. When all three pieces of data are available, the JavaScript widget writes a reference to Facebook's Like button URL to the designated IFRAME(s) in the content. This URL includes the link to the intermediate page, including the course, user and content IDs. 
 
 4. The intermediate page uses the course and content IDs with LearningStudio's APIs to look up the course information, including the titles of the content and the course. 
 
 5. This information is written to Facebook-specific `<meta>` tags, along with the URL of a thumbnail the institution wants to show in the Facebook news feed. 
 
 6. Facebook uses this `<meta>` information to construct the story that appears in the news feed. 
 
 7. When the student's friends click the link from the news feed, they return to the intermediate landing page, along with the original course, content and user IDs. 
 
 8. The page content of the intermediate page is customized to the course, content and user IDs. Using the LearningStudio APIs, the page can display the name of the original student along with a preview of the course or marketing copy about the institution. 


Security & Privacy
------------------

As of version 1.1, the solution will create an encrypted hash of the user ID, course ID, and content item ID that is sent to the landing page. The landing page can decrypt this hash to get the information. This isn't inherently secure, because JavaScript-based encryption never truly can be; therefore this encryption is technically hackable. But it does offer security/privacy by obfuscation, preventing raw IDs from being in the wild on Facebook. Feel free to discuss this issue with the API Support team, if needed, but use of this tool is at your own risk. 


License
-------

> See LICENSE.md for full details.   

(c) 2013 Pearson.  MIT License  
Developed by the Pearson Developer Network along with ASU Online.   