<?php
function transtext()
{

	//-------------------------------------addon\content_account\recovery\display.html
	echo T_("click here to login to your account");                                   // Line 6
	echo T_("are you remember your password!?");                                      // Line 6

	//---------------------------------------addon\content_account\signup\display.html
	echo T_("already have an account?");                                              // Line 6
	echo T_("click here to sign in to your account");                                 // Line 6
	echo T_("Sign In");                                                               // Line 6

	//---------------------------------addon\content_account\verification\display.html
	echo T_("we send a verification code for you");                                   // Line 6
	echo T_("please check your mobile and enter the code");                           // Line 7
	echo T_("don't receive message?");                                                // Line 8

	//------------------------------addon\content_account\verificationsms\display.html
	echo T_("Please send number <b>2015</b> to below number");                        // Line 6 Seperate
	echo T_("Then wait we receive your message and verificate your account");         // Line 8

	//----------------------------------------------addon\content_cp\home\display.html
	echo T_("Hello!");                                                                // Line 7
	echo T_("Welcome to Saloos control panel.");                                      // Line 7
	echo T_("No. of");                                                                // Line 75
	echo T_("Posts");                                                                 // Line 63 Seperate
	echo T_("Pages");                                                                 // Line 64 Seperate
	echo T_("Attachments");                                                           // Line 66 Seperate
	echo T_("Tags");                                                                  // Line 112
	echo T_("Categories");                                                            // Line 99
	echo T_("Users");                                                                 // Line 68 Seperate
	echo T_("Add New Post");                                                          // Line 86
	echo T_("Add New Attachment");                                                    // Line 87
	echo T_("Quick Access");                                                          // Line 89
	echo T_("Visit");                                                                 // Line 112

	//-------------------------------------------addon\content_cp\home\layout-xhr.html
	echo T_("Add New Record");                                                        // Line 56 Seperate

	//-----------------------------------------------addon\content_cp\home\layout.html
	echo T_("Dashboard");                                                             // Line 62 Seperate
	echo T_("Options");                                                               // Line 53 Seperate
	echo T_("My Profile");                                                            // Line 69 Seperate
	echo T_("Lock Screen");                                                           // Line 71 Seperate
	echo T_("Logout");                                                                // Line 72 Seperate
	echo T_("Powered by");                                                            // Line 83
	echo T_("All right reserved");                                                    // Line 83
	echo T_("Saloos");                                                                // Line 7 Seperate
	echo T_("Last update on");                                                        // Line 84
	echo T_("Version");                                                               // Line 75 Seperate

	//-----------------------------------addon\content_cp\templates\child_display.html
	echo T_("Back to");                                                               // Line 54 Seperate

	//-------------------------------------addon\content_cp\templates\child_posts.html
	echo T_("Enter title here");                                                      // Line 19
	echo T_("Click to check result");                                                 // Line 10
	echo T_("Write your post content here");                                          // Line 20
	echo T_("Excerpt");                                                               // Line 24
	echo T_("If excerpt is empty we get it automatically from content");              // Line 26
	echo T_("Summaries of your content that can be used as page description.");       // Line 28
	echo T_("Enter Tags here");                                                       // Line 27
	echo T_("Enter Tags");                                                            // Line 28
	echo T_("Add");                                                                   // Line 93 Seperate
	echo T_("Normally, tags are ad-hoc keywords that identify important information in your post (names, subjects, etc) that may or may not recur in other posts, while categories are pre-determined sections.");// Line 11
	echo T_("What’s the difference between posts and pages?");                      // Line 56
	echo T_("Pages are similar to Posts in that they have a title, body text, and associated metadata, but they are different in that they are not part of the chronological blog stream, kind of like permanent posts.");// Line 56
	echo T_("Pages are not categorized or tagged, but can have a hierarchy.");        // Line 56
	echo T_("Publish");                                                               // Line 85
	echo T_("Slug");                                                                  // Line 49
	echo T_("Enter slug here");                                                       // Line 67
	echo T_("Language");                                                              // Line 53
	echo T_("All Languages");                                                         // Line 69
	echo T_("Status");                                                                // Line 61
	echo T_("Submit Changes");                                                        // Line 69
	echo T_("Update");                                                                // Line 96 Seperate
	echo T_("Page Attributes");                                                       // Line 91
	echo T_("Parent Page");                                                           // Line 79
	echo T_("Without parent");                                                        // Line 81
	echo T_("You can nest Pages under other Pages by making one the “Parent” of the other, creating a group of Pages.");// Line 56
	echo T_("Height");                                                                // Line 96
	echo T_("Width");                                                                 // Line 97
	echo T_("Enter cat here");                                                        // Line 108

	//-------------------------------------addon\content_cp\templates\child_terms.html
	echo T_("What’s the difference between categories and tags?");                  // Line 11
	echo T_("If you think of your site like a book, the categories are like the Table of Contents and the tags are like the terms in the index.");// Line 11

	//-------------------------addon\content_cp\templates\display_attachments_add.html
	echo T_("Drag & Drop Files Here");                                                // Line 11
	echo T_("or");                                                                    // Line 60 Seperate
	echo T_("Choose File");                                                           // Line 11
	echo T_("Maximum size allowed");                                                  // Line 13

	//---------------------------------addon\content_cp\templates\display_utility.html
	echo T_("You can use our tools");                                                 // Line 6
	echo T_("Regenerate sitemap");                                                    // Line 10
	echo T_("Extract twig trans func in current project");                            // Line 11
	echo T_("Extract twig trans func in saloos addon");                               // Line 12
	echo T_("Automatically read database and create sql files");                      // Line 13
	echo T_("Show server info");                                                      // Line 14
	echo T_("Show PHP info");                                                         // Line 15

	//----------------------------------addon\content_cp\templates\module_display.html
	echo T_("Actions");                                                               // Line 55 Seperate
	echo T_("Data not exist!");                                                       // Line 104 Seperate
	echo T_("delete record");                                                         // Line 57 Seperate
	echo T_("seriously, are you sure? There's no coming back.");                      // Line 58 Seperate
	echo T_("Cancel");                                                                // Line 59 Seperate
	echo T_("Delete");                                                                // Line 61 Seperate

	//----------------------------------addon\content_cp\templates\module_profile.html
	echo T_("Mobile");                                                                // Line 112 Seperate
	echo T_("Email");                                                                 // Line 13
	echo T_("Display Name");                                                          // Line 15
	echo T_("Save Changes");                                                          // Line 17
	echo T_("Edit your profile data");                                                // Line 22

	//-----------------------------------------addon\content_cp\templates\sidebar.html
	echo T_("Draft");                                                                 // Line 78
	echo T_("Deleted");                                                               // Line 79
	echo T_("Schedule");                                                              // Line 80
	echo T_("Preview");                                                               // Line 83

	//--------------------------------------addon\includes\languages\trans_static.html
	echo T_("saloos");                                                                // Line 8 Seperate
	echo T_("Javad Evazzadeh");                                                       // Line 9 Seperate
	echo T_("Hasan Salehi");                                                          // Line 10 Seperate
	echo T_("Another Project with Saloos");                                           // Line 11 Seperate
	echo T_("Saloos is an artichokes for PHP programming!!");                         // Line 12 Seperate
	echo T_("Saloos is powerfull.");                                                  // Line 13 Seperate
	echo T_("Insert Successfully");                                                   // Line 14 Seperate
	echo T_("Insert Failed!");                                                        // Line 15 Seperate
	echo T_("Update Successfully");                                                   // Line 16 Seperate
	echo T_("Update Failed!");                                                        // Line 17 Seperate
	echo T_("Delete Successfully");                                                   // Line 18 Seperate
	echo T_("Delete Failed!");                                                        // Line 19 Seperate
	echo T_("Transaction error");                                                     // Line 20 Seperate
	echo T_("id does not exist!");                                                    // Line 22 Seperate
	echo T_("all require fields must fill");                                          // Line 23 Seperate
	echo T_("some fields must be change for update!");                                // Line 24 Seperate
	echo T_("Ermile");                                                                // Line 124 Seperate
	echo T_("ermile");                                                                // Line 26 Seperate
	echo T_("now we only support Iran!");                                             // Line 27 Seperate
	echo T_("your verification code is");                                             // Line 28 Seperate
	echo T_("your recovery code is");                                                 // Line 29 Seperate
	echo T_("you account is verified successfully");                                  // Line 30 Seperate
	echo T_("thanks for using our service");                                          // Line 31 Seperate
	echo T_("made in iran");                                                          // Line 32 Seperate
	echo T_("Iran");                                                                  // Line 33 Seperate
	echo T_("iran");                                                                  // Line 34 Seperate
	echo T_("Qom");                                                                   // Line 35 Seperate
	echo T_("qom");                                                                   // Line 36 Seperate
	echo T_("submit");                                                                // Line 37 Seperate
	echo T_("save");                                                                  // Line 38 Seperate
	echo T_("add new");                                                               // Line 39 Seperate
	echo T_("signin");                                                                // Line 40 Seperate
	echo T_("sign in");                                                               // Line 41 Seperate
	echo T_("signup");                                                                // Line 42 Seperate
	echo T_("sign up");                                                               // Line 43 Seperate
	echo T_("register");                                                              // Line 44 Seperate
	echo T_("create an account");                                                     // Line 45 Seperate
	echo T_("home");                                                                  // Line 46 Seperate
	echo T_("Home");                                                                  // Line 47 Seperate
	echo T_("homepage");                                                              // Line 48 Seperate
	echo T_("Homepage");                                                              // Line 49 Seperate
	echo T_("admin");                                                                 // Line 50 Seperate
	echo T_("Terms");                                                                 // Line 65 Seperate
	echo T_("Comments");                                                              // Line 67 Seperate
	echo T_("Profile");                                                               // Line 70 Seperate
	echo T_("Powered by Saloos.");                                                    // Line 73 Seperate
	echo T_("All right reserved.");                                                   // Line 74 Seperate
	echo T_("Login Successfully");                                                    // Line 78 Seperate
	echo T_("Login failed!");                                                         // Line 79 Seperate
	echo T_("Mobile or password is incorrect");                                       // Line 80 Seperate
	echo T_("Please forward this message to administrator");                          // Line 81 Seperate
	echo T_("Assign keywords to your posts using tags");                              // Line 82 Seperate
	echo T_("Use categories to define sections of your site and group related posts");// Line 83 Seperate
	echo T_("Use posts to share your news in specefic category");                     // Line 84 Seperate
	echo T_("Use pages to share your static content");                                // Line 85 Seperate
	echo T_("Upload your media");                                                     // Line 86 Seperate
	echo T_("page");                                                                  // Line 87 Seperate
	echo T_("post");                                                                  // Line 88 Seperate
	echo T_("tag");                                                                   // Line 89 Seperate
	echo T_("category");                                                              // Line 90 Seperate
	echo T_("attachment");                                                            // Line 91 Seperate
	echo T_("option");                                                                // Line 92 Seperate
	echo T_("Edit");                                                                  // Line 94 Seperate
	echo T_("Control Panel");                                                         // Line 95 Seperate
	echo T_("Editor");                                                                // Line 97 Seperate
	echo T_("Admin");                                                                 // Line 98 Seperate
	echo T_("Administrator");                                                         // Line 99 Seperate
	echo T_("Writer");                                                                // Line 100 Seperate
	echo T_("utility");                                                               // Line 101 Seperate
	echo T_("Utility");                                                               // Line 102 Seperate
	echo T_("Chart must be contain at least 2 column!");                              // Line 103 Seperate
	echo T_("Byte");                                                                  // Line 105 Seperate
	echo T_("KB");                                                                    // Line 106 Seperate
	echo T_("MB");                                                                    // Line 107 Seperate
	echo T_("GB");                                                                    // Line 108 Seperate
	echo T_("TB");                                                                    // Line 109 Seperate
	echo T_("PB");                                                                    // Line 110 Seperate
	echo T_("we send a verification code to this number");                            // Line 113 Seperate
	echo T_("Password");                                                              // Line 114 Seperate
	echo T_("between 5-40 character");                                                // Line 115 Seperate
	echo T_("between 5-40 character. be tricky!");                                    // Line 116 Seperate
	echo T_("Login");                                                                 // Line 117 Seperate
	echo T_("Create an account");                                                     // Line 118 Seperate
	echo T_("Verificate");                                                            // Line 119 Seperate
	echo T_("Recovery");                                                              // Line 120 Seperate
	echo T_("Change password");                                                       // Line 121 Seperate
	echo T_("SMS Delivery");                                                          // Line 122 Seperate
	echo T_("SMS Callback");                                                          // Line 123 Seperate
	echo T_("edit");                                                                  // Line 125 Seperate

	//-------------------------------------------------addon\includes\macro\forms.html
	echo T_("Select");                                                                // Line 57

}
?>