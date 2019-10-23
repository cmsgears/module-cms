<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\components;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * MessageSource stores and provide the messages and message templates available in
 * Cms Module.
 *
 * @since 1.0.0
 */
class MessageSource extends \cmsgears\core\common\base\MessageSource {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [
		// Generic Fields
		CmsGlobal::FIELD_ELEMENT => 'Element',
		CmsGlobal::FIELD_BLOCK => 'Block',
		CmsGlobal::FIELD_LINK => 'Link',
		CmsGlobal::FIELD_MENU => 'Menu',
		CmsGlobal::FIELD_WIDGET => 'Widget',
		CmsGlobal::FIELD_SIDEBAR => 'Sidebar',
		CmsGlobal::FIELD_PAGE => 'Page',
		CmsGlobal::FIELD_KEYWORDS => 'Keywords',
		// SEO
		CmsGlobal::FIELD_SEO_NAME => 'SEO Name',
		CmsGlobal::FIELD_SEO_DESCRIPTION => 'SEO Description',
		CmsGlobal::FIELD_SEO_KEYWORDS => 'SEO Keywords',
		CmsGlobal::FIELD_SEO_ROBOT => 'SEO Robot',
		CmsGlobal::FIELD_SEO_SCHEMA => 'SEO Schema',
		// Link
		CmsGlobal::FIELD_ABSOLUTE => 'Absolute',
		CmsGlobal::FIELD_URL_OPTIONS => 'Url Options'
	];

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// MessageSource -------------------------

}
