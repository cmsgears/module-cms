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
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\interfaces\base\IAuthor;
use cmsgears\core\common\models\interfaces\base\IMultiSite;
use cmsgears\core\common\models\interfaces\base\IName;
use cmsgears\core\common\models\interfaces\resources\IData;

use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Content;

use cmsgears\core\common\models\traits\base\AuthorTrait;
use cmsgears\core\common\models\traits\base\MultiSiteTrait;
use cmsgears\core\common\models\traits\base\NameTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * Link represents the url.
 *
 * @property integer $id
 * @property integer $siteId
 * @property integer $pageId
 * @property integer $createdBy
 * @property integer $modifiedBy
 * @property string $name
 * @property string $title
 * @property string $url
 * @property string $type
 * @property string $icon
 * @property integer $order
 * @property boolean $absolute
 * @property boolean $private
 * @property boolean $active
 * @property date $createdAt
 * @property date $modifiedAt
 * @property string $htmlOptions
 * @property string $urlOptions
 * @property string $data
 */
class Link extends \cmsgears\core\common\models\base\Resource implements IAuthor, IData, IMultiSite, IName {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType = CmsGlobal::TYPE_LINK;

	// Private ----------------

	// Traits ------------------------------------------------------

	use AuthorTrait;
	use DataTrait;
	use MultiSiteTrait;
	use NameTrait;

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
			'authorBehavior' => [
				'class' => AuthorBehavior::class
			],
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
			[ [ 'siteId', 'name' ], 'required' ],
			[ [ 'id', 'htmlOptions', 'urlOptions' ], 'safe' ],
			// Unique
			[ 'name', 'unique', 'targetAttribute' => [ 'siteId', 'name' ], 'message' => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NAME ) ],
			// Text Limit
			[ 'type', 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->xxLargeText ],
			[ 'icon', 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
			[ [ 'title', 'url' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxxLargeText ],
			// Other
			[ 'order', 'number', 'integerOnly' => true, 'min' => 0 ],
			[ [ 'absolute', 'private', 'active' ], 'boolean' ],
			[ [ 'siteId', 'pageId', 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
		];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'name', 'title', 'url' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
			'siteId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SITE ),
			'pageId' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_PAGE ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'title' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'url' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_URL),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'absolute' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_ABSOLUTE ),
			'private' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PRIVATE ),
			'active' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ACTIVE ),
			'htmlOptions' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'urlOptions' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_URL_OPTIONS ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// yii\db\BaseActiveRecord

	/**
	 * @inheritdoc
	 */
	public function beforeSave( $insert ) {

		if( parent::beforeSave( $insert ) ) {

			if( empty( $this->order ) || $this->order <= 0 ) {

				$this->order = 0;
			}

			// Default Type - Default
			$this->type = $this->type ?? CoreGlobal::TYPE_DEFAULT;

			return true;
		}

		return false;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Link ----------------------------------

	/**
	 * Returns the page associated with link.
	 *
	 * @return \cmsgears\cms\common\models\entities\Content
	 */
	public function getPage() {

		return $this->hasOne( Content::class, [ 'id' => 'pageId' ] );
	}

	/**
	 * Returns string representation of absolute flag.
	 *
	 * @return string
	 */
	public function getAbsoluteStr() {

		return Yii::$app->formatter->asBoolean( $this->absolute );
	}

	/**
	 * Returns string representation of private flag.
	 *
	 * @return string
	 */
	public function getPrivateStr() {

		return Yii::$app->formatter->asBoolean( $this->private );
	}

	/**
	 * Returns string representation of active flag.
	 *
	 * @return string
	 */
	public function getActiveStr() {

		return Yii::$app->formatter->asBoolean( $this->active );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return CmsTables::getTableName( CmsTables::TABLE_LINK );
	}

	// CMG parent classes --------------------

	// Link ----------------------------------

	// Read - Query -----------

	/**
	 * @inheritdoc
	 */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'site', 'page', 'creator', 'modifier' ];

		$config[ 'relations' ] = $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
