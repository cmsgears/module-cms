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
 * PageSettingsForm provide page settings data.
 *
 * @since 1.0.0
 */
class PageSettingsForm extends DataModel {

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

	// Page Header
	public $header;
	public $headerIcon;
	public $headerIconUrl;

	// Page Content
	public $banner;
	public $gallery;
	public $description;
	public $summary;
	public $content;
	public $contentClass;
	public $contentDataClass;
	public $boxWrapClass;

	// Page Footer
	public $footer;
	public $footerIcon;
	public $footerIconClass;
	public $footerIconUrl;
	public $footerTitle;
	public $footerInfo;
	public $footerContent;

	// Attributes
	public $attributes;
	public $attributeTypes;

	// Elements
	public $elements;
	public $elementType;

	// Widgets
	public $widgets;
	public $widgetType;

	// Blocks
	public $blocks;
	public $blockType;

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
			[ [ 'texture', 'maxCover', 'header', 'footer', 'elements', 'widgets', 'blocks' ], 'boolean' ],
			[ [ 'banner', 'gallery', 'description', 'summary', 'content' ], 'boolean' ],
			[ [ 'headerIcon', 'footerIcon', 'attributes' ], 'boolean' ],
			[ [ 'elementType', 'widgetType', 'blockType' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ [ 'bkgClass', 'maxCoverClass', 'footerIconClass', 'footerTitle' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'contentClass', 'contentDataClass', 'boxWrapClass' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'footerInfo', 'attributeTypes' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'headerIconUrl', 'footerIconUrl' ], 'url' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// BlockSettingsForm ---------------------

}
