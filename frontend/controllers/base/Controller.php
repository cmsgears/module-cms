<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\frontend\controllers\base;

// CMG Imports
use cmsgears\core\common\config\CommentProperties;
use cmsgears\cms\common\config\CmsProperties;

use cmsgears\core\frontend\controllers\base\Controller as BaseController;

/**
 * Base Controller of all frontend controllers specific to CMS module.
 *
 * @since 1.0.0
 */
abstract class Controller extends BaseController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Private ----------------

	private $cmsProperties;

	private $commentProperties;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Controller ----------------------------

	public function getCmsProperties() {

		if( !isset( $this->cmsProperties ) ) {

			$this->cmsProperties = CmsProperties::getInstance();
		}

		return $this->cmsProperties;
	}

	public function getCommentProperties() {

		if( !isset( $this->commentProperties ) ) {

			$this->commentProperties = CommentProperties::getInstance();
		}

		return $this->commentProperties;
	}

}
