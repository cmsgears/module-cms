<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\config;

// CMG Imports
use cmsgears\core\common\config\Properties;

/**
 * CmsProperties provide methods to access the properties specific to blog.
 *
 * @since 1.0.0
 */
class CmsProperties extends Properties {

	// Variables ---------------------------------------------------

	// Global -----------------

	/**
	 * The property to find whether comments are enabled at page level.
	 */
	const PROP_COMMENT_PAGE		= 'page_comment';

	/**
	 * The property to find whether comments are enabled at post level.
	 */
	const PROP_COMMENT_POST		= 'post_comment';

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private static $instance;

	// Constructor and Initialisation ------------------------------

	/**
	 * Return Singleton instance.
	 */
	public static function getInstance() {

		if( !isset( self::$instance ) ) {

			self::$instance	= new CmsProperties();

			self::$instance->init( CmsGlobal::CONFIG_BLOG );
		}

		return self::$instance;
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CmsProperties -------------------------

	/**
	 * Returns whether comments are required for pages.
	 */
	public function isPageComments() {

		return $this->properties[ self::PROP_COMMENT_PAGE ];
	}

	/**
	 * Returns whether comments are required for posts.
	 */
	public function isPostComments() {

		return $this->properties[ self::PROP_COMMENT_POST ];
	}

}
