<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\config;

/**
 * CmsProperties provide methods to access the properties specific to blog.
 *
 * @since 1.0.0
 */
class CmsProperties extends \cmsgears\core\common\config\Properties {

	// Variables ---------------------------------------------------

	// Global -----------------

	/**
	 * The property to find whether comments are enabled at page level.
	 */
	const PROP_COMMENT_PAGE = 'page_comment';

	/**
	 * The property to find whether comments are enabled at article level.
	 */
	const PROP_COMMENT_ARTICLE = 'article_comment';

	/**
	 * The property to find whether comments are enabled at post level.
	 */
	const PROP_COMMENT_POST = 'post_comment';

	/**
	 * The property to limit number of posts displayed on blog page. It can also be
	 * used to limit the number of pages and posts on search pages.
	 */
	const PROP_POST_LIMIT = 'post_limit';

	/**
	 * Check to add the application title while generating page title.
	 */
	const PROP_TITLE_SITE = 'title_site';

	/**
	 * Separator used to separate the page title with site title.
	 */
	const PROP_TITLE_SEPARATOR = 'title_separator';

	/**
	 * Check to append or prepend site title with page title.
	 */
	const PROP_TITLE_APPEND = 'append_title';

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
	 * Returns whether comments are required for articles.
	 */
	public function isArticleComments() {

		return $this->properties[ self::PROP_COMMENT_ARTICLE ];
	}

	/**
	 * Returns whether comments are required for posts.
	 */
	public function isPostComments() {

		return $this->properties[ self::PROP_COMMENT_POST ];
	}

	/**
	 * Returns the number of posts or pages displayed on search pages.
	 */
	public function getPostLimit() {

		return $this->properties[ self::PROP_POST_LIMIT ];
	}

	/**
	 * Checks whether site title needs to be displayed with page title.
	 */
	public function isSiteTitle() {

		return $this->properties[ self::PROP_TITLE_SITE ];
	}

	/**
	 * Returns the title separator used to separate page title with site title.
	 */
	public function getTitleSeparator() {

		return $this->properties[ self::PROP_TITLE_SEPARATOR ];
	}

	/**
	 * Checks whether site title needs to appended or prepend.
	 */
	public function isAppendTitle() {

		return $this->properties[ self::PROP_TITLE_APPEND ];
	}

}
