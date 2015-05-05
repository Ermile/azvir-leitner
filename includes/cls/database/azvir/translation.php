<?php
function transtext()
{

	// ------------------------------------------------------------ Table cardcats
	echo T_("cardcats");            // Table cardcats
	echo T_("cardcat");             // cardcat
	echo T_("enable");              // Enum enable
	echo T_("disable");             // Enum disable
	echo T_("expire");              // Enum expire
	echo T_("public");              // Enum public
	echo T_("private");             // Enum private
	echo T_("protected");           // Enum protected
	echo T_("id");                  // id
	echo T_("user");                // user_id
	echo T_("type");                // cardcats_type
	echo T_("title");               // cardcats_title
	echo T_("slug");                // cardcats_slug
	echo T_("desc");                // cardcats_desc
	echo T_("url");                 // cardcats_url
	echo T_("parent");              // cardcats_parent
	echo T_("count");               // cardcats_count
	echo T_("status");              // cardcats_status
	echo T_("modified");            // date_modified

	// ------------------------------------------------------------ Table carddetails
	echo T_("carddetails");         // Table carddetails
	echo T_("carddetail");          // carddetail
	echo T_("success");             // Enum success
	echo T_("fail");                // Enum fail
	echo T_("ignore");              // Enum ignore
	echo T_("change");              // Enum change
	echo T_("card");                // card_id
	echo T_("date");                // carddetails_date
	echo T_("status");              // carddetail_status

	// ------------------------------------------------------------ Table cards
	echo T_("cards");               // Table cards
	echo T_("card");                // card
	echo T_("front");               // card_front
	echo T_("back");                // card_back
	echo T_("createdate");          // card_createdate

	// ------------------------------------------------------------ Table cardusages
	echo T_("cardusages");          // Table cardusages
	echo T_("cardusage");           // cardusage
	echo T_("cardcat");             // cardcat_id
	echo T_("deck");                // cardusage_deck
	echo T_("try");                 // cardusage_try
	echo T_("trysuccess");          // cardusage_trysuccess
	echo T_("expire");              // cardusage_expire
	echo T_("lasttry");             // cardusages_lasttry

	// ------------------------------------------------------------ Table comments
	echo T_("comments");            // Table comments
	echo T_("comment");             // comment
	echo T_("approved");            // Enum approved
	echo T_("unapproved");          // Enum unapproved
	echo T_("spam");                // Enum spam
	echo T_("deleted");             // Enum deleted
	echo T_("post");                // post_id
	echo T_("product");             // product_id
	echo T_("author");              // comment_author
	echo T_("email");               // comment_email
	echo T_("url");                 // comment_url
	echo T_("content");             // comment_content
	echo T_("status");              // comment_status
	echo T_("parent");              // comment_parent
	echo T_("visitor");             // Visitor_id

	// ------------------------------------------------------------ Table errorlogs
	echo T_("errorlogs");           // Table errorlogs
	echo T_("errorlog");            // errorlog
	echo T_("errorlog");            // errorlog_id

	// ------------------------------------------------------------ Table errors
	echo T_("errors");              // Table errors
	echo T_("error");               // error
	echo T_("critical");            // Enum critical
	echo T_("high");                // Enum high
	echo T_("medium");              // Enum medium
	echo T_("low");                 // Enum low
	echo T_("title");               // error_title
	echo T_("solution");            // error_solution
	echo T_("priority");            // error_priority

	// ------------------------------------------------------------ Table notifications
	echo T_("notifications");       // Table notifications
	echo T_("notification");        // notification
	echo T_("read");                // Enum read
	echo T_("unread");              // Enum unread
	echo T_("user sender");         // user_idsender
	echo T_("title");               // notification_title
	echo T_("content");             // notification_content
	echo T_("url");                 // notification_url
	echo T_("status");              // notification_status

	// ------------------------------------------------------------ Table options
	echo T_("options");             // Table options
	echo T_("option");              // option
	echo T_("cat");                 // option_cat
	echo T_("key");                 // option_key
	echo T_("value");               // option_value
	echo T_("extra");               // option_extra
	echo T_("status");              // option_status

	// ------------------------------------------------------------ Table postmetas
	echo T_("postmetas");           // Table postmetas
	echo T_("postmeta");            // postmeta
	echo T_("cat");                 // postmeta_cat
	echo T_("key");                 // postmeta_key
	echo T_("value");               // postmeta_value
	echo T_("status");              // postmeta_status

	// ------------------------------------------------------------ Table posts
	echo T_("posts");               // Table posts
	echo T_("post");                // post
	echo T_("open");                // Enum open
	echo T_("closed");              // Enum closed
	echo T_("publish");             // Enum publish
	echo T_("draft");               // Enum draft
	echo T_("schedule");            // Enum schedule
	echo T_("language");            // post_language
	echo T_("title");               // post_title
	echo T_("slug");                // post_slug
	echo T_("content");             // post_content
	echo T_("type");                // post_type
	echo T_("url");                 // post_url
	echo T_("comment");             // post_comment
	echo T_("count");               // post_count
	echo T_("status");              // post_status
	echo T_("parent");              // post_parent
	echo T_("publishdate");         // post_publishdate

	// ------------------------------------------------------------ Table terms
	echo T_("terms");               // Table terms
	echo T_("term");                // term
	echo T_("language");            // term_language
	echo T_("type");                // term_type
	echo T_("title");               // term_title
	echo T_("slug");                // term_slug
	echo T_("desc");                // term_desc
	echo T_("url");                 // term_url
	echo T_("parent");              // term_parent
	echo T_("count");               // term_count
	echo T_("status");              // term_status

	// ------------------------------------------------------------ Table termusages
	echo T_("termusages");          // Table termusages
	echo T_("termusage");           // termusage
	echo T_("posts");               // Enum posts
	echo T_("products");            // Enum products
	echo T_("attachments");         // Enum attachments
	echo T_("comments");            // Enum comments
	echo T_("term");                // term_id
	echo T_("object");              // object_id
	echo T_("type");                // termusage_type
	echo T_("order");               // termusage_order

	// ------------------------------------------------------------ Table userlogs
	echo T_("userlogs");            // Table userlogs
	echo T_("userlog");             // userlog
	echo T_("forgetpassword");      // Enum forgetpassword
	echo T_("title");               // userlog_title
	echo T_("desc");                // userlog_desc
	echo T_("priority");            // userlog_priority
	echo T_("type");                // userlog_type

	// ------------------------------------------------------------ Table usermetas
	echo T_("usermetas");           // Table usermetas
	echo T_("usermeta");            // usermeta
	echo T_("cat");                 // usermeta_cat
	echo T_("key");                 // usermeta_key
	echo T_("value");               // usermeta_value
	echo T_("status");              // usermeta_status

	// ------------------------------------------------------------ Table users
	echo T_("users");               // Table users
	echo T_("user");                // user
	echo T_("active");              // Enum active
	echo T_("awaiting");            // Enum awaiting
	echo T_("deactive");            // Enum deactive
	echo T_("removed");             // Enum removed
	echo T_("filter");              // Enum filter
	echo T_("mobile");              // user_mobile
	echo T_("email");               // user_email
	echo T_("pass");                // user_pass
	echo T_("displayname");         // user_displayname
	echo T_("status");              // user_status
	echo T_("permission");          // user_permission
	echo T_("createdate");          // user_createdate

	// ------------------------------------------------------------ Table verifications
	echo T_("verifications");       // Table verifications
	echo T_("verification");        // verification
	echo T_("emailsignup");         // Enum emailsignup
	echo T_("emailchangepass");     // Enum emailchangepass
	echo T_("emailrecovery");       // Enum emailrecovery
	echo T_("mobilesignup");        // Enum mobilesignup
	echo T_("mobilechangepass");    // Enum mobilechangepass
	echo T_("mobilerecovery");      // Enum mobilerecovery
	echo T_("yes");                 // Enum yes
	echo T_("no");                  // Enum no
	echo T_("type");                // verification_type
	echo T_("value");               // verification_value
	echo T_("code");                // verification_code
	echo T_("url");                 // verification_url
	echo T_("verified");            // verification_verified
	echo T_("status");              // verification_status
	echo T_("createdate");          // verification_createdate

	// ------------------------------------------------------------ Table visitors
	echo T_("visitors");            // Table visitors
	echo T_("visitor");             // visitor
	echo T_("ip");                  // visitor_ip
	echo T_("url");                 // visitor_url
	echo T_("agent");               // visitor_agent
	echo T_("referer");             // visitor_referer
	echo T_("robot");               // visitor_robot
	echo T_("createdate");          // visitor_createdate

}
?>