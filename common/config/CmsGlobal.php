<?php
namespace cmsgears\cms\common\config;

class CmsGlobal {

	// Traits - Metas, Tags, Attachments, Addresses --------------------

	const TYPE_PAGE				= "page";
	const TYPE_POST				= "post";
	const TYPE_SIDEBAR			= "sidebar";
	const TYPE_MENU				= "menu";
	const TYPE_WIDGET			= "widget";

	// Permissions -----------------------------------------------------

	const PERM_CMS				= "cms";

	// Errors ----------------------------------------------------------

	// Errors - Generic
	const ERROR_NO_TEMPLATE		= "noTemplateError";
	const ERROR_NO_VIEW			= "noViewError";

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_TEMPLATE		= "templateField";
	const FIELD_MENU			= "menuField";
	const FIELD_PAGE			= "pageField";
	const FIELD_WIDGET			= "widgetField";
	const FIELD_SIDEBAR			= "sidebarField";

	// Content Fields
	const FIELD_KEYWORDS		= "keywordsField";
}

?>