<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\resources;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\ITemplate;
use cmsgears\core\common\models\interfaces\resources\IVisual;

use cmsgears\core\common\models\base\ModelResource;
use cmsgears\core\common\models\resources\Gallery;

use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\TemplateTrait;
use cmsgears\core\common\models\traits\resources\VisualTrait;

/**
 * ModelContent represents the additional data required to form a page with basic SEO
 * attributes. The models forming single public page can use it.
 *
 * @property integer $id
 * @property integer $templateId
 * @property integer $bannerId
 * @property integer $mbannerId
 * @property integer $videoId
 * @property integer $mvideoId
 * @property integer $galleryId
 * @property integer $parentId
 * @property string $parentType
 * @property string $type
 * @property string $summary
 * @property string $classPath
 * @property string $viewPath
 * @property string $seoName
 * @property string $seoDescription
 * @property string $seoKeywords
 * @property string $seoRobot
 * @property string $seoSchema
 * @property date $createdAt
 * @property date $modifiedAt
 * @property date $publishedAt
 * @property string $content
 * @property string $data
 */
class ModelContent extends ModelResource implements IData, ITemplate, IVisual {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use DataTrait;
	use TemplateTrait;
	use VisualTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	/**
	 * @inheritdoc
	 */
	public function behaviors() {

		return [
			'timestampBehavior' => [
				'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'createdAt',
				'updatedAtAttribute' => 'modifiedAt',
				'value' => new Expression('NOW()')
			]
		];
	}

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		// Model Rules
		$rules = [
			// Required, Safe
			// [ [ 'parentId', 'parentType' ], 'required' ],
			[ [ 'id', 'summary', 'content', 'data', 'seoSchema' ], 'safe' ],
			// Text Limit
			[ [ 'parentType', 'type' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxLargeText ],
			[ [ 'classPath', 'viewPath' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			// Other
			[ 'templateId', 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
			[ [ 'bannerId', 'mbannerId', 'videoId', 'mvideoId', 'galleryId', 'parentId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'createdAt', 'modifiedAt', 'publishedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
		];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
			'templateId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
			'bannerId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'mbannerId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_BANNER_M ),
			'videoId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIDEO ),
			'mvideoId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIDEO_M ),
			'galleryId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GALLERY ),
			'parentId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'summary' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SUMMARY ),
			'classPath' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CLASSPATH ),
			'viewPath' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIEW_PATH ),
			'seoName' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_SEO_NAME ),
			'seoDescription' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_SEO_DESCRIPTION ),
			'seoKeywords' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_SEO_KEYWORDS ),
			'seoRobot' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_SEO_ROBOT ),
			'seoSchema' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_SEO_SCHEMA ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// yii\db\BaseActiveRecord

	/**
	 * @inheritdoc
	 */
	public function beforeSave( $insert ) {

		if( parent::beforeSave( $insert ) ) {

			if( $this->templateId <= 0 ) {

				$this->templateId = null;
			}

			return true;
		}

		return false;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ModelContent --------------------------

	/**
	 * Returns the gallery associated with model content.
	 *
	 * @return \cmsgears\core\common\models\resources\Gallery
	 */
	public function getGallery() {

		return $this->hasOne( Gallery::class, [ 'id' => 'galleryId' ] );
	}

	/**
	 * Returns cut down part of [[$summary]].
	 *
	 * @param integer $limit
	 * @return string
	 */
	public function getLimitedSummary( $limit = CoreGlobal::TEXT_MEDIUM ) {

		$summary = strip_tags( $this->summary );

		if( strlen( $summary ) > $limit ) {

			$summary = substr( $summary, 0, $limit );
		}

		return HtmlPurifier::process( $summary );
	}

	/**
	 * Returns cut down part of [[$content]].
	 *
	 * @param integer $limit
	 * @return string
	 */
	public function getLimitedContent( $limit = CoreGlobal::TEXT_MEDIUM ) {

		$content = strip_tags( $this->content );

		if( strlen( $content ) > $limit ) {

			$content = substr( $content, 0, $limit );
		}

		return HtmlPurifier::process( $content );
	}

	public function getDisplaySummary( $limit = CoreGlobal::TEXT_MEDIUM ) {

		if( empty( $this->summary ) || strlen( $this->summary ) < 10 ) {

			return $this->getLimitedContent( $limit );
		}

		return $this->getLimitedSummary( $limit );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return CmsTables::getTableName( CmsTables::TABLE_MODEL_CONTENT );
	}

	// CMG parent classes --------------------

	// ModelContent --------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
