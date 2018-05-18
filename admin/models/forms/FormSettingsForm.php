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
 * FormSettingsForm provide form settings data.
 *
 * @since 1.0.0
 */
class FormSettingsForm extends DataModel {

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

	// Header
	public $header;
	public $headerIcon;
	public $headerIconUrl;

	// Content
	public $banner;
	public $gallery;
	public $description;
	public $summary;
	public $content;
	public $contentClass;
	public $contentDataClass;
	public $boxWrapClass;

	// Footer
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
			[ [ 'footerContent' ], 'safe' ],
			[ [ 'bkg', 'fixedBkg', 'scrollBkg', 'parallaxBkg' ], 'boolean' ],
			[ [ 'texture', 'header', 'footer', 'elements', 'widgets', 'blocks' ], 'boolean' ],
			[ [ 'banner', 'gallery', 'description', 'summary', 'content' ], 'boolean' ],
			[ [ 'headerIcon', 'footerIcon' ], 'boolean' ],
			[ [ 'elementType', 'widgetType', 'blockType' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ [ 'bkgClass', 'footerIconClass', 'footerTitle' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'contentClass', 'contentDataClass', 'boxWrapClass' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'footerInfo' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'headerIconUrl', 'footerIconUrl' ], 'url' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// FormSettingsForm ----------------------

}
