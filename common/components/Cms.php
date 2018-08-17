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

use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\Article;
use cmsgears\cms\common\models\entities\Post;

use cmsgears\core\common\base\Component;

/**
 * Cms component initialize the module Cms and it's properties.
 *
 * @since 1.0.0
 */
class Cms extends Component {

	// Global -----------------

	// Public -----------------

	public $pageMap = [];

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Register page map
		$this->registerPageMap();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Cms -----------------------------------

	// Properties ----------------

	/**
	 * Register page map
	 */
	public function registerPageMap() {

		$this->pageMap[ CmsGlobal::TYPE_PAGE ]		= Page::class;
		$this->pageMap[ CmsGlobal::TYPE_ARTICLE ]	= Article::class;
		$this->pageMap[ CmsGlobal::TYPE_POST ]		= Post::class;
	}

	public function getPageClass( $type ) {

		return $this->pageMap[ $type ];
	}

}
