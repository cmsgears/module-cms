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
 * BlockSettingsForm provide block settings data.
 *
 * @since 1.0.0
 */
class BlockSettingsForm extends DataModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Background
	public $bkg;
	public $fixedBkg;
	public $scrollBkg;
	public $parallaxBkg;
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
	public $contentClass;
	public $contentDataClass;
	public $boxWrapClass;

	// Block Footer
	public $footer;
	public $footerIcon;
	public $footerIconClass;
	public $footerIconUrl;
	public $footerTitle;
	public $footerInfo;
	public $footerContent;

	// Elements
	public $elements;
	public $elementType;

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
			[ [ 'bkg', 'fixedBkg', 'scrollBkg', 'parallaxBkg' ], 'boolean' ],
			[ [ 'texture', 'maxCover', 'header', 'description', 'summary', 'content', 'footer', 'elements' ], 'boolean' ],
			[ [ 'headerIcon', 'footerIcon' ], 'boolean' ],
			[ 'elementType', 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ [ 'bkgClass', 'maxCoverClass', 'footerIconClass', 'footerTitle' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'contentClass', 'contentDataClass', 'boxWrapClass' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ 'footerInfo', 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'headerIconUrl', 'footerIconUrl' ], 'url' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// BlockSettingsForm ---------------------

}
