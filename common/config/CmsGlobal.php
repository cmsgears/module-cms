<?php
namespace cmsgears\cms\common\config;

class CmsGlobal {

	// Traits - Metas, Tags, Attachments, Addresses --------------------

	const TYPE_PAGE				= 'page';
	const TYPE_POST				= 'post';
	const TYPE_BLOCK			= 'block';
	const TYPE_MENU				= 'menu';
	const TYPE_SIDEBAR			= 'sidebar';
	const TYPE_WIDGET			= 'widget';

	// Permissions -----------------------------------------------------

	const PERM_CMS				= 'cms';

	// Errors ----------------------------------------------------------

	// Errors - Generic
	const ERROR_NO_TEMPLATE		= 'noTemplateError';
	const ERROR_NO_VIEW			= 'noViewError';

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_TEMPLATE		= 'templateField';
	const FIELD_MENU			= 'menuField';
	const FIELD_PAGE			= 'pageField';
	const FIELD_BLOCK			= 'blockField';
	const FIELD_WIDGET			= 'widgetField';
	const FIELD_SIDEBAR			= 'sidebarField';

	// Content Fields
	const FIELD_KEYWORDS		= 'keywordsField';

	// SEO
	const FIELD_SEO_NAME			= 'seoNameField';
	const FIELD_SEO_DESCRIPTION		= 'seoDescriptionField';
	const FIELD_SEO_KEYWORDS		= 'seoKeywordsField';
	const FIELD_SEO_ROBOT			= 'seoRobotField';
	
	// Block Fields
	const FIELD_BACKGROUND			= 'backgroundField';
	const FIELD_TEXTURE				= 'textureField';
	const FIELD_HTML_OPTIONS		= 'htmlOtpionsField';
	const FIELD_BACKGROUND_CLASS	= 'backgroundClassField';
	const FIELD_TEXTURE_CLASS		= 'textureClassField';
}

?>