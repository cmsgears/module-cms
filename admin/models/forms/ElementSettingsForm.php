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

	// Avatar
	public $defaultAvatar;

	// Background
	public $defaultBanner;
	public $bkg;
	public $bkgClass;

	// Texture
	public $texture;

	// Header
	public $header; // Show Header
	public $headerIcon; // Show Header Icon using Model Avatar/Icon
	public $headerTitle; // Show Header Title using Model Title
	public $headerInfo; // Show Header Info using Model Description
	public $headerContent; // Show Header Content using Model Summary
	public $headerIconUrl; // Show Header Icon using Icon Url irrespective of Model Avatar/Icon

	// Content
	public $content; // Show content
	public $contentTitle; // Show Model Title within content
	public $contentInfo; // Show Model Description within content
	public $contentSummary; // Show Model Summary within content
	public $contentData; // Show Model Content within content

	public $maxCover;

	public $contentClass;
	public $contentDataClass;

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
	public $attributes;
	public $attributeTypes;

	public $metaWrapClass;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		return [
			[ [ 'footerContentData' ], 'safe' ],
			[ [ 'defaultAvatar', 'defaultBanner', 'bkg', 'texture', 'maxCover' ], 'boolean' ],
			[ [ 'header', 'headerIcon', 'headerTitle', 'headerInfo', 'headerContent' ], 'boolean' ],
			[ [ 'content', 'contentTitle', 'contentInfo', 'contentSummary', 'contentData', 'attributes' ], 'boolean' ],
			[ [ 'footer', 'footerIcon', 'footerTitle', 'footerInfo', 'footerContent' ], 'boolean' ],
			[ [ 'bkgClass', 'contentClass', 'contentDataClass', 'metaWrapClass', 'attributeTypes' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ [ 'footerIconClass', 'footerTitleData' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			[ 'footerInfoData' , 'string', 'min' => 1, 'max' => Yii::$app->core->xtraLargeText ],
			[ [ 'headerIconUrl', 'footerIconUrl' ], 'url' ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
			'bkg' => 'Background',
			'bkgClass' => 'Background Class',
			'metaWrapClass' => 'Attribute Wrap Class'
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ElementSettingsForm -------------------

}
