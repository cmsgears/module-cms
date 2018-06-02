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

	// Avatar & Banner
	public $defaultAvatar;
	public $defaultBanner;

	// Banner
	public $fixedBanner;
	public $scrollBanner;
	public $parallaxBanner;
	public $background;
	public $backgroundClass;

	// Texture
	public $texture;

	// Max cover on top of block content
	public $maxCover;
	public $maxCoverContent;
	public $maxCoverClass;

	// Header
	public $header; // Show Header
	public $headerIcon; // Show Header Icon using Model Avatar/Icon
	public $headerTitle; // Show Header Title using Model Title
	public $headerInfo; // Show Header Info using Model Description
	public $headerContent; // Show Header Content using Model Summary
	public $headerIconUrl; // Show Header Icon using Icon Url irrespective of Model Avatar/Icon
	public $headerBanner;
	public $headerGallery;

	// Content

	public $content; // Show content
	public $contentTitle; // Show Model Title within content
	public $contentInfo; // Show Model Description within content
	public $contentSummary; // Show Model Summary within content
	public $contentData; // Show Model Content within content

	public $contentAvatar;
	public $contentBanner;
	public $contentGallery;

	public $contentClass;
	public $contentDataClass;
	public $boxWrapClass;
	public $boxWrapper;
	public $boxClass;

	// Footer
	public $footer; // Show Footer
	public $footerIcon; // Show Footer Icon using Model Avatar/Icon
	public $footerIconClass; // Show Footer Icon using css class irrespective of Model Avatar/Icon
	public $footerIconUrl; // Show Footer Icon using Icon Url irrespective of Model Avatar/Icon
	public $footerTitle; // Show Footer Title using Model Title
	public $footerTitleData; // Show Footer Title using Title Data irrespective of Model Title
	public $footerInfo; // Show Footer Info using Model Description
	public $footerInfoData; // Show Footer Info using Info Data irrespective of Model Description
	public $footerContent; // Show Footer Content using Model Summary
	public $footerContentData; // Show Footer Content using Content Data irrespective of Model Summary

	// Attributes
	public $attributeData;
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
			[ [ 'maxCoverContent', 'footerContentData' ], 'safe' ],
			[ [ 'defaultAvatar', 'defaultBanner', 'fixedBanner', 'scrollBanner', 'parallaxBanner', 'background', 'texture', 'maxCover' ], 'boolean' ],
			[ [ 'elements', 'widgets', 'blocks' ], 'boolean' ],
			[ [ 'header', 'headerIcon', 'headerTitle', 'headerInfo', 'headerContent', 'headerBanner', 'headerGallery' ], 'boolean' ],
			[ [ 'content', 'contentTitle', 'contentInfo', 'contentSummary', 'contentData', 'contentAvatar', 'contentBanner', 'contentGallery', 'attributeData' ], 'boolean' ],
			[ [ 'footer', 'footerIcon', 'footerTitle', 'footerInfo', 'footerContent' ], 'boolean' ],
			[ [ 'elementType', 'widgetType', 'blockType', 'boxWrapper' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ [ 'backgroundClass', 'contentClass', 'contentDataClass', 'boxWrapClass', 'boxClass', 'attributeTypes' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'maxCoverClass', 'footerIconClass', 'footerTitleData' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ 'footerInfoData' , 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'headerIconUrl', 'footerIconUrl' ], 'url' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// FormSettingsForm ----------------------

}
