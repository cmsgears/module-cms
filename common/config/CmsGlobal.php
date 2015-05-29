<?php
namespace cmsgears\cms\common\config;

class CmsGlobal {

	// Categories ------------------------------------------------------

	const CATEGORY_TYPE_POST	= "post"; // Used for Post

	// Traits - Metas, Tags, Attachments, Addresses --------------------

	const TYPE_PAGE				= "page";
	const TYPE_POST				= "post";
	const TYPE_SIDEBAR			= "sidebar";
	const TYPE_MENU				= "menu";

	// Permissions -----------------------------------------------------

	const PERM_CMS				= "cms";

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_TEMPLATE		= "templateField";
	const FIELD_MENU			= "menuField";
	const FIELD_PAGE			= "pageField";
	const FIELD_WIDGET			= "widgetField";
	const FIELD_SIDEBAR			= "sidebarField";

	// Content Fields
	const FIELD_KEYWORDS		= "keywordsField";
	const FIELD_SUMMARY			= "summaryField";
	const FIELD_CONTENT			= "contentField";
}

?>