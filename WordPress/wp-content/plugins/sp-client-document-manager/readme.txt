=== Plugin Name ===
Contributors: smartypants
Donate link: http://smartypantsplugins.com/donate/
Tags: document manager, File uploader, online website documents organization, share documents and graphic files securely, customer file manager
Requires at least: 2.0.2
Tested up to: 3.8.1
Stable tag: 2.1.2

Project & Document Manager. A multi-functional file management tool to upload, share, track, group, distribute and organize any type of document.

== Description ==

Online project & document managment application,  Businesses & Organization utilizing this application can maintain and file web based documents. You can organize, manage client, student & supplier's documents and accounts, control individual documents, and select specific distribution of documents all in an easy to manage online process. 
The plug-in also demonstrates how quickly a business can take hold of their interactions with clients, sales organzation, vendors, and all in between.  With a straight-forward layout, access to template modifications and easy to manage features; clients can add and modify projects. Think of it as a old school filing cabinet that allows to manage you files from any wifi access point.The plug-in provides assurances that the user has complete control over the flow of information.


We also now offer a premium version; please check out our website for more information: 
http://smartypantsplugins.com/sp-client-document-manager/

Works with WordPress Multi Site!

**[Click here to try out a demo](http://smartypantsplugins.com/client-upload-demo/ "Click here to try out a demo")**

Login with:  user: test   password: test

**Overall Features**
* Enhanced file and document security
* Ability to choose and upload multiple files
* Delete uploaded documents
* Automatically zip multiple files
* Custom Forms
* Search by file name
* Ability to allow deleting documents and files 
* Renaming of projects
* Disable user uploads (View Only) 
* Disable user deleting of files
* Ability to translate plugin to multiple languages using the .po files.

**Client / Customers**
* Clients upload files and Documents online to their own personal page
* Clients can create or add to existing projects

**Administrator Side Features**
* Complete control on who can access specific files
* Turn off ability for Clients to upload documents instantly.
* Notification via email when a client uploads a file
* Add files and documents to client page and projects
* Download file archive of a user
* Custom Naming of files
* Create multiple upload locations
* 50 latest uploads on main plugin page
* Force downloads of file 
* Delete confirmation with custom notification
* Thank you confirmation with custom notification
* Add staff, supplier's, vendors, sub-contractors or partner's so you can distribute the files to other people
* Attach file or send the file as a link
* Projects allow you or the users to create projects to store files in
* Allow the user to create projects
* Ability to add files to any user
* Download all the files of a project in a single zip file
* Add multiple admin emails to receive files
* Advanced admin file manager
* Assign custom capabilities to user roles


**Premium Features**


**Overall Premium Features**
* Add custom fields to your client upload form, Sort the fields, view them in the file view page or in admin
* Search by tags
* Change text for category (ex: Status)
* Custom Email Notifications
* Auto deletion of files based on a time you set.
* Thumbnail view mode for a windows explorer type look and feel.
* Automatically create thumbnails of pdfs and psds (must have imagemagick installed on server)
* File versioning system, don't lose old versions 
* Upload multiple files
* File progress bar
* Allow users to collaborate on files by creating groups
* Switch between list view and thumbnail view
* Assign a file or files to a category


**Premium Addon Features**

* Integrate wordpress roles and buddypress groups. When you share a project with a group everyone from that group has access to those files.
* Batch operations - batch delete and move files to different folders. Download files as a zip archive keeping directory structure intact.
* Dropbox integration to allow your users to import files directly from their dropbox
* Add unlimited sub folders for better organizing
* File importer, upload multiple files with a zip file.
* Share projects with buddypress and wordpress roles!

**Categories**

* Add Categories
* Manage Categories allow an admin to designate categories for the user to select, for example a print company could use categories as statuses (Mockup, Draft and Final)


**Projects**

* Allow a user to create projects
* Collaborate with other users with groups
* Assign a file or files to a project
* Manage Projects
	
**Clients**

* Client can view all categories set by admin

Full Support Available through email or Skype. 
Add-on packs available for more features!



**Current Languages**

* English
* French
* German
* Italian

**Demo**

[youtube http://www.youtube.com/watch?v=cEhzmhx9jt8]


== Installation ==

* Upload the plugin to your plugins folder
* Activate the plugin
* Create a new page and enter the shortcode [sp-client-document-manager]  
* Go to the plugin admin page and click settings to configure the plugin  (VERY IMPORTANT!)  
* If you're using the premium version please upload the zip archive in the settings area. 
 
= Short Codes = 
x = configurable area


**[sp-client-document-manager]** 

This shortcode displays the uploader
 
**[cdm-link file="x" date="1" real="1"]**
* This links to a specific file

* file = required, this is the file id. You can find the file id in admin under files or by clicking on a file. The ID is listed next to the date.
* date = (set to 1) optional, show the date of a file
* real = (set to 1) optional, generate the real url for the file, the link tags are not generated and only the url is returned. This is good for custom links and image url's

examples:

* [cdm-link file="53" date="1"]
* Will generate a link with the file name and date

'< img src="[cdm-link file="53" real="1"]" width="100">'

Will generate a full url for use in an image

**[cdm-project project="x" date="1" order="x" direction="x" limit="x" ]**

This shortlink will display a unordered list of files, it is a basic html ul so you can use css to display it however you want.

* project = required, this is the project id which you can get in admin under the projects tab.
* date = optional, put's the date of the file next to the file name
* order = (name,date,id,file) optional, use one of the fields to order the list by
* direction  = (asc,desc) optional, Only to be used with order, use asc for ascending order or desc for decending order
* limit = optional, use to limit the amount of results shown.

examples:

* [cdm-project project="1" date="1" ]
* [cdm-project project="1" date="1" order="name" direction="asc" limit="10" ]

= User Role Capabilities = 
If you use "User Role Editor" plugin and want to assign CDM capabilities to another role then please use the following custom captabilities. All are automatically set for administrator

* sp_cdm = You need this role to view the plugin, this is a very minimal role. You can view files, edit and delete.
* sp_cdm_settings = edit settings as well as enable any premium plugin features (in the future we will break premium features into their own roles, just getting started here)
* sp_cdm_vendors = Show vendors tab
* sp_cdm_projects = Show projects tab
* sp_cdm_uploader = Use the uploader (add files)

**[cdm_public_view]**

This is a shortcode for premium members only, it displays the file list to the public. This shortcode lists all the files from all users.

= Premium Users = 

*Premium users must have free + premium version installed. The premium extends the free version.

== Frequently Asked Questions ==

= How come I'm getting a 404 error? =

This could be one of two reasons, either you did not install theme my login or you're running wordpress in a directory in which you can go to settings and set the directory for wordpress.

= Why am I just getting a spinning circle and no content on my uploader? = 

This is usually because you are using a theme that converts new lines into paragraphs. To fix this wrap the short code in raw tags. Example: [raw][sp-client-document-manager] [/raw]

= Is there a conflict with another plugin? =

Sometimes plugins have conflicts, if you are experiencing any abnormal problems there could be a javascript error. Please download and install firebug to find the issue.

= I get an imagemagick error when creating thumbnails of pdf and psd's = 

Imagemagick is a 3rd party plugin you are responsible for, it needs to be downloaded and installed on your server but more importantly, it needs to be compiled into php. Your server admin should be able to handle that, we do not support imagemagick installations.

= I'm using the premium version but not seeing the client document uploader tab in wordpress =

Premium users must have free + premium version installed. The premium extends the free version. Once you install the free version you will see the tab, from there put in your serial code.
= Do you offer capabilities for user roles? = 

* sp_cdm = You need this role to view the plugin, this is a very minimal role. You can view files, edit and delete.
* sp_cdm_settings = edit settings as well as enable any premium plugin features (in the future we will break premium features into their own roles, just getting started here)
* sp_cdm_vendors = Show vendors tab
* sp_cdm_projects = Show projects tab
* sp_cdm_uploader = Use the uploader (add files)

= Why am I getting a permission denied error when activating the premium or trial version? = 

The premium version relies on common functions to operate, please activate the FREE version to fix this error. You must have both FREE and Premium plugins installed and activated.

== Screenshots ==

1. This is the client view
2. This is the file view which also shows the premium revision system
3. This is the admin page view
4. Admin file uploader to upload a file for a user
5. Settings page
6. Form builder to add custom forms (premium)
7. Group manager to allow multiple user manage the same files (premium)
8. Project editor
9. Upload a file


== Changelog ==

= 1.0.0 =
* Created first version
	
= 1.0.2 =
* Database bug fix
* Small zip error
	
= 1.0.3 =
* Error with file tree fixed.
* There was an error with wordpress in a folder, now in the settings you have to set the directory if you have wordpress in a folder.
	
= 1.0.4 =
* increased the upload size for php to 1000mb
	
= 1.0.7 =
* Fixed a few bugs and added auto file deletion to the premium version. Now you can set how many days a file should exist in the system.

= 1.0.9 =
* Update to enable localization. Please translate the language files and get them back to us so other users can use them!

= 1.1.1 =
* Projects now come with free version! Create projects and folders for your files
* Premium users can now view thumbnails and
* Thumbnails created from psds and pdfs

= 1.1.2 =
* Premium users can now add fields to the upload form, add textboxes,selectboxes or textareas!

= 1.1.3 =
* Force download works better with mime types!

= 1.1.4 =
* Admin now has ability to add files to any user
* Added German Translation

= 1.1.7 =
* Removed additional project function that was causing conflicts with the free version
* Added the ability to give the plugin a company name for emails for both free and premium.
* Added the ability for admins to form groups which allows group members to share all  files and projects! Premium only

= 1.1.8 =
* Works with WordPress multsite

= 1.1.8 =
* Fixed include issue with some versions of php

= 1.2.0 =
* Fixed an issue with wordpress running in its own directory. Files link properly now!

= 1.2.1 =
* Added the ability to search for files
* Fixed a few bugs
* added the ability for premium users to use tags (download latest premium version in client area)

= 1.2.2 =
* Fixed a javascript error that was causing conflicts with other plugins
* Removed the filetree jquery plugin for a more homebrewed file view system.
* Fixed a function include error
* Added the search feature to search files!

= 1.2.3 =
* Fixed issue with uploading

= 1.2.5 =
*Fixes a major issue with the admin wordpress uploader

= 1.2.6 =
* Added ability to set admin and user emails with custom template tags! Check out the settings area

= 1.2.7 = 
* Addded the ability to delete projects
* Added the ability to edit project names
* when adding projects it now uses ajax to eliminate page refresh
* Bug fixed with multi site
* Bug fixed with admin email
* Bug fixed with User email
* increased by eliminating some scripts that are not being used anymore

= 1.2.8 = 
* Fixed a bug with multi user
* Fixed a bug involving blank download links in the email
* Add more features for groups (premium)
* Only file/project owners can delete their own files by default, the admin has the option to over-ride this functionality and allow all users of a group to modify /files/projects

= 1.2.9 = 
* Major updates seperating premium and giving its own plugin, this will reduce errors when updating the free version!
* Added sorting for file list view

= 1.3.1 =
*Fixed errors with UTF-8
*Fixed ie9 compatibility

= 1.3.2 =
*Added ability to make projects mandatory so users.
*The form now remembers what the user chose last for a project and keeps that project selected.

= 1.3.5 =
* You can now turn off the ability for users to upload files
* Fixed an issue with projects that was not moving client files when changing ownership of a project

= 1.3.9 =
* You can now disable user deleting
* Premium users can disable adding of revisions
* Fixed Redirect Problem
* Added the system to admin upload
* Emails will only send if there is email content under settings
* Admin has the ability to delete or upload even if settings disable them.
* Added a check to see if theme my login is installed.

= 1.4.0 = 
* Removed the regular uploaded and added a file view that shows you each users files as they see it, this view also includes an uploadeder as the client would see it. This fixes any bugs that would not place the correct file when adding a file to a user project.

= 1.4.1 = 
* Fix to the progress meter

= 1.4.2 =
* Added new feature, you can now set additional emails ot receive both the admin and the user email. In the settings section there is a new spot to add additional emails, comma seperate the emails for multiple emails.
* You can also add roles to the comma seperated values, if you add a role then it will email all the users of the specified role. Works with custom roles as well!
* Example to email a few different emails and custom role "customer_service":    test@test.com,test2@test.com,customer_service,test3@test.com
* This feature was requested by marisqa

= 1.4.3 =
* Added time zone support, choose your timezone in settings to set the correct time. 
* This effects file names when using the %y %m or d% also effects time files were posted.

= 1.4.4 =
* Fixed problem with wp multisite links in the admin email
* Fixed a problem with notes not being added to admin email
* Added custom forms to email if a premium user.

= 1.4.7 =
* Add capabilities so you can use "User role editor" to assign different roles with the new capabilities.
* List of new capabilities:
* sp_cdm = You need this role to view the plugin, this is a very minimal role. You can view files, edit and delete.
* sp_cdm_settings = edit settings as well as enable any premium plugin features (in the future we will break premium features into their own roles, just getting started here)
* sp_cdm_vendors = Show vendors tab
* sp_cdm_projects = Show projects tab
* sp_cdm_uploader = Use the uploader (add files)
* Also added an update to the premium version to see who uploaded a version.

= 1.4.8 =
* New shortcodes to show a list of project files or link directly to a file (check installation instructions on usage)
* Fixed email content not saving
* Fixed a conflict with jetpack that was running the shortcode twice making double files.
* Removed admin/uploader.php no longer needed with the new file viewer/uploader

= 1.4.9 =
* Fixed issue with slashes, this will fix newer files. Older files will have to be edited. There was a random code to addslashes in there (something wordpress db class does as well) so it was adding slashes twice.

= 1.5.0 =
* Fixed an issue where uploads were happening twice on some installations, now using wordpress actions and hooks for processing data in shortcodes
* The search function now searches within projects for the file your searching for, if the file is inside a project it displays the project name.
* Fixed an issue with validation being broken
* Fixed another stripslashes problem in the admin email

= 1.5.1 =
* Fixed a stripslashes for revision notes
* Fixed an issue with premium notes not being logged.
* Added a  ajax refresh button

= 1.5.2 =
* New uploader for premium users, the uploader allows multiple file uploads and shows file progress. 
* New uploader allows you to choose if you want zip files or leave them seperate
* Ability to set the file name to the same filename as the original
* Shows actual file progress now!
* Allow premium users to use the old uploader
* Fixed IE issues
* New setting to turn off file revisions
* Premium Admin emails recieves a list of all uploaded files since we can do multiple files now. One email for all files uploaded
* Fixed premium tables not installing correctly
* Created some hooks so we can have seperate settings from the free version  add_action('cdm_premium_settings','your_function')  to build on settings
* Fixed load issue in IE (spining circle)
* Dropped the idea of drag and drop due to browser compatibility issues.
* User groups fixed for projects

= 1.5.5 =
* Removed all references to hardcoded uploads and hardcoded plugin directory, it now uses your wordpress settings (major update)
* You can now overide the location of your uploads folder in advanced settings, remember to set your permissions to 777 on the folder you create.
* Deletes are now powered by ajax so theres no page reload
* When installing the premium and free doesn't exist the plugin prompts you to install the free version.

= 1.5.6 =
* Added ability to set maximum file size for premium users only
* Added ability to limit file types for premium users only
* Added the ability to move the uploads directory to a non web accessible location for extra security.
* Added the ability to force login when downloading files for extra security
* Fixed a bug where a file was not being removed from the server
* Updated timthumb manager
* Fixed a admin upload bug when using premium
* Started working on folder syncing for a version 2.0 release

= 1.5.8 =
* Fixed some bugs
* Patched a security whole when accessing a file directly through download.php
* Added a new shortcode for premium users
* Added a notice for premium users when free version is out of date
* Added a notice when a new version of premium is released.


= 1.6.0 = 

* Fixed a quick shortcode bug.

= 1.6.3 

* Fixed a security hole when backing out of a project displaying files from other useres.
* Fixed a bug that was not allowing the adding of projects in the admin file uploader.
* Replaced the buttons with a nice dropdown menu with hooks for the addons.
* Added lots of hooks and actions for extending CDM

== Upgrade Notice ==

= 1.0.5 =
Major fixes to bugs that were found during our initial release

= 1.0.7 =
Not a major issue to upgrade unless you're a premium user.

= 1.0.8 =
Added localization for multiple languages

= 1.1.0 =
Bug fixes, added thumbnail mode for premium users.

= 1.1.1 =
Projects now come with free version! Create projects and folders for your files


= 1.2.5 = 
Major updates, new uploader and fixes to admin upload functions

= 1.2.6 =
* Added ability to set admin and user emails with custom template tags! Check out the settings area

= 1.2.9 = 
* There is a new procedure for premium, premium users please check email. You must update free plugin, download the new premium plugin and add it through the wordpress plugin manager. This will reduce errors when upgrading in the future.

= 1.3.5 =
* You can now turn off the ability for users to upload files
* Fixed an issue with projects that was not moving client files when changing ownership of a project

= 1.3.6 =
* Fixed download.php header problem

= 1.3.9 =
* You can now disable user deleting
* Premium users can disable adding of revisions
* Fixed Redirect Problem
* Added the system to admin upload
* Emails will only send if there is email content under settings
* Admin has the ability to delete or upload even if settings disable them.
* Added a check to see if theme my login is installed.

= 1.4.0 = 
* Removed the regular uploaded and added a file view that shows you each users files as they see it, this view also includes an uploadeder as the client would see it. This fixes any bugs that would not place the correct file when adding a file to a user project.

= 1.4.1 = 
* Fix to the progress meter

= 1.4.2 =
* Added new feature, you can now set additional emails ot receive both the admin and the user email. In the settings section there is a new spot to add additional emails, comma seperate the emails for multiple emails.
* You can also add roles to the comma seperated values, if you add a role then it will email all the users of the specified role. Works with custom roles as well!
* Example to email a few different emails and custom role "customer_service":    test@test.com,test2@test.com,customer_service,test3@test.com
* This feature was requested by marisqa

= 1.4.3 =
* Added time zone support, choose your timezone in settings to set the correct time. 
* This effects file names when using the %y %m or d% also effects time files were posted.

= 1.4.4 =
* Fixed problem with wp multisite links in the admin email
* Fixed a problem with notes not being added to admin email
* Added custom forms to email if a premium user.


= 1.4.7 =
* Add capabilities so you can use "User role editor" to assign different roles with the new capabilities.
* List of new capabilities:
* sp_cdm = You need this role to view the plugin, this is a very minimal role. You can view files, edit and delete.
* sp_cdm_settings = edit settings as well as enable any premium plugin features (in the future we will break premium features into their own roles, just getting started here)
* sp_cdm_vendors = Show vendors tab
* sp_cdm_projects = Show projects tab
* sp_cdm_uploader = Use the uploader (add files)
* Also added an update to the premium version to see who uploaded a version.

= 1.4.8 =
* New shortcodes to show a list of project files or link directly to a file (check installation instructions on usage)
* Fixed email content not saving
* Fixed a conflict with jetpack that was running the shortcode twice making double files.
* Removed admin/uploader.php no longer needed with the new file viewer/uploader

= 1.4.9 =
* Fixed issue with slashes, this will fix newer files. Older files will have to be edited. There was a random code to addslashes in there (something wordpress db class does as well) so it was adding slashes twice.

= 1.5.0 =
* Fixed an issue where uploads were happening twice on some installations, now using wordpress actions and hooks for processing data in shortcodes
* The search function now searches within projects for the file your searching for, if the file is inside a project it displays the project name.
* Fixed an issue with validation being broken
* Fixed another stripslashes problem in the admin email

= 1.5.1 =
* Fixed a stripslashes for revision notes
* Fixed an issue with premium notes not being logged.
* Added a  ajax refresh button

= 1.5.2 =
* New uploader for premium users, the uploader allows multiple file uploads and shows file progress. 
* New uploader allows you to choose if you want zip files or leave them seperate
* Ability to set the file name to the same filename as the original
* Shows actual file progress now!
* Allow premium users to use the old uploader
* Fixed IE issues
* New setting to turn off file revisions
* Premium Admin emails recieves a list of all uploaded files since we can do multiple files now. One email for all files uploaded
* Fixed premium tables not installing correctly
* Created some hooks so we can have seperate settings from the free version  add_action('cdm_premium_settings','your_function')  to build on settings
* Fixed load issue in IE (spining circle)
* Dropped the idea of drag and drop due to browser compatibility issues.
* User groups fixed for projects

= 1.5.3 =
* Removed the requirement for theme my login

= 1.5.4 =
* Fixed ie issue of huge padding no the file list table
* Fixed a group sql error
* Fixed a redirect issue with theme my login.

= 1.5.5 =
* Removed all references to hardcoded uploads and hardcoded plugin directory, it now uses your wordpress settings (major update)
* You can now overide the location of your uploads folder in advanced settings, remember to set your permissions to 777 on the folder you create.
* Deletes are now powered by ajax so theres no page reload
* When installing the premium and free doesn't exist the plugin prompts you to install the free version.

= 1.5.6 =
* Added ability to set maximum file size for premium users only
* Added ability to limit file types for premium users only
* Added the ability to move the uploads directory to a non web accessible location for extra security.
* Added the ability to force login when downloading files for extra security
* Fixed a bug where a file was not being removed from the server
* Updated timthumb manager
* Fixed a admin upload bug when using premium
* Started working on folder syncing for a version 2.0 release

= 1.5.8 =
* Fixed some bugs
* Patched a security whole when accessing a file directly through download.php
* Added a new shortcode for premium users
* Added a notice for premium users when free version is out of date
* Added a notice when a new version of premium is released.

= 1.5.9 =
* Fixed some bugs
* Added hooks to build addons
* Released two premium addons, dropbox integration and sub projects.
* Fixed a flash upload bug
* Total rewrite of the ajax core


= 1.6.0 = 

* Fixed a quick shortcode bug.

= 1.6.1 = 

* Fixed an error when viewing admin uploader and users are part of a group

= 1.6.3 = 

* Fixed a security hole when backing out of a project displaying files from other useres.
* Fixed a bug that was not allowing the adding of projects in the admin file uploader.
* Replaced the buttons with a nice dropdown menu with hooks for the addons.
* Added lots of hooks and actions for extending CDM

= 1.6.4 = 

*Fixed multisite permissions issue. (please update both free and premium)

= 1.6.5 = 

*Update to timthumb

= 1.6.6 =

* Fixed an issue with imageMagick
* New field for ImageMagick that lets you specify a custom location of your imageMagick convert app
* Sanitize file names to remove special characters and invalid characters from the URL
* Few minor bug fixes.

= 1.6.8 =

* No more dependency on timthumb, using a wordpress native thumbnail resizer.
* Fixed issue with downloads link in email
* Fixed deleting of files in admin redirecting to wrong page

= 1.6.9 =

* Fixed an issue with add a project button not showing up in admin when disabled for users.

= 1.7.0 =

* Bug fixes
* Added the ability to disable user editing and delete of projects
* fixed a sql error
* removed some notices

= 1.7.1 =

* New hooks which give added features to make 3rd party extensions

= 1.7.2 =

* Stripslashes issue on custom urls on a windows machine.

= 1.7.3 = 

* Add new fields to translating plugin. Please update in your language and mail the po to us if you need the new fields translated.

= 1.7.5 =

* Bug fixes
* Added functionality to groups manager.

= 1.7.6 =


* Permissions problem

= 1.7.7 =

* New context menu for premium useres
* Fixed some bugs
* Projects now called Folders. You can also change what you want to call the folders in settings.
* Major updates to premium versions as well.

= 1.7.8 = 

* Quick patch to fix javascript error from 1.7.7

= 1.8.2 =

* Now using google cdm for jquery ui themes. Still using smoothness but premium members can chage the theme or use a custom theme.
* Bug Fixes
* Added the ability for batch operations through a new addon
* UI Fix to the main uploader page
* Turn off search
* Tightened up code for the uploader
* Fixed multiple instances of upload form
* Fixed UI compatibility with 3.6

= 1.8.3 =

* Fixed issue jquery UI styles not showing in ssl mode
* Allow notify to group users if using group plugin for revisions.

= 1.8.6 =

* Now uses your wordpress settings time zone instead of a native time zone.

= 1.8.7 =

* Fixed issue with caching in IE 10
* Added force upgrade button for tables
* Fixed bugs mentioned in forums.
* Added the ability to use the template tags in the email subject

= 1.8.8 =

* Added database integrity test on the settings page.

= 1.8.9 =

* Added another level of security protecting links so its not possible to find other user files based off the URL.

= 1.9.0 =

* Quick fix to downloads, there was broken links in a few instances.

= 1.9.1 =

* Fix to the issue with html emails breaking the password reset feature

= 1.9.3 =

* Imagemagick now supports over 100 different file types based off your imageMagick installation!
* Premium users can choose the option to force download a file instead of viewing the file info screen.

= 1.9.4 =

* Update to fix issue with batch operations manager

= 1.9.5 =

* Delete cache when deleting a file 
* Delete small and big thumbnails when deleting a file.

= 1.9.6 = 

* Fixes to the permission system
* Projects now reload when using premium contextual menu
* Security fixes
* Function depreciation
* Please update the free version before updating the premium versions

= 1.9.7 =

* Enhanced the log for productivity pack
* Productivity now uses the license manager so you can get automatic updates, please submit a support ticket if you need a new license.

= 1.9.8 =

* Major updates to the UI
* Changed permission system
* Removed the folder dropdown and replaced it with an as you see is what you get type of system

= 1.9.9 =

* Auto detect if theres no shortcode installed and asks if you want to create it automatically

= 2.0.1 =

* Fixed a small bug that would show all files to all users, some servers sent undefined in replace of project id.

= 2.0.2 =

* fixed a project adding issue

= 2.0.4 =

* Fixed a permissions issue with thumbnails
* 3.8.1 compatible

= 2.0.6 =

* Bran new installer should stop any upgrade issues we have in the future!

= 2.0.9 =

* When uploading in admin there is a seperate email that allows you to notify the user that a file has been added. We have made this an optional feature.

= 2.1.1 =

* Fix to admin email
* Added a few more template tags
* Added the ability to remove the search field.