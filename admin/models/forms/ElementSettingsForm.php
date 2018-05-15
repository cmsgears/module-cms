<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\models\forms;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\models\forms\DataModel;

/**
 * ElementSettingsForm provide element settings data.
 *
 * @since 1.0.0
 */
class ElementSettingsForm extends DataModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Background
	public $bkg;
	public $bkgClass;

	// Texture
	public $texture;

	// Max cover on top of block content
	public $maxCover;
	public $maxCoverContent;
	public $maxCoverClass;

	// Block Header
	public $header;
	public $headerIcon;
	public $headerIconUrl;

	// Block Content
	public $description;
	public $summary;
	public $content;

	// Block Footer
	public $footer;
	public $footerIcon;
	public $footerIconClass;
	public $footerIconUrl;
	public $footerTitle;
	public $footerInfo;
	public $footerContent;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	public function rules() {

		return [
			[ [ 'maxCoverContent', 'footerContent' ], 'safe' ],
			[ [ 'bkg', 'texture', 'maxCover', 'header', 'description', 'summary', 'content', 'footer' ], 'boolean' ],
			[ [ 'headerIcon', 'footerIcon' ], 'boolean' ],
			[ [ 'bkgClass', 'maxCoverClass', 'footerIconClass', 'footerTitle' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ 'footerInfo', 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'headerIconUrl', 'footerIconUrl' ], 'url' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ElementSettingsForm -------------------

}
