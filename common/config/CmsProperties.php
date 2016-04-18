<?php
namespace cmsgears\cms\common\config;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class CmsProperties extends \cmsgears\core\common\config\CmgProperties {

	/**
	 * The property to find whether comments are enabled at page level.
	 */
	const PROP_COMMENT_PAGE		= "page_comment";

	/**
	 * The property to find whether comments are enabled at post level.
	 */
	const PROP_COMMENT_POST		= "post_comment";

	// Singleton instance
	private static $instance;

	// Constructor and Initialisation ------------------------------

 	private function __construct() {

	}

	/**
	 * Return Singleton instance.
	 */
	public static function getInstance() {

		if( !isset( self::$instance ) ) {

			self::$instance	= new CmsProperties();

			self::$instance->init( CmsGlobal::CONFIG_CMS );
		}

		return self::$instance;
	}

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

?>