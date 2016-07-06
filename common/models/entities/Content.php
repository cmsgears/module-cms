<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\interfaces\IApproval;
use cmsgears\core\common\models\interfaces\IVisibility;

use cmsgears\core\common\models\entities\Site;
use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\CreateModifyTrait;
use cmsgears\core\common\models\traits\NameTypeTrait;
use cmsgears\core\common\models\traits\SlugTypeTrait;
use cmsgears\core\common\models\traits\interfaces\ApprovalTrait;
use cmsgears\core\common\models\traits\interfaces\VisibilityTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * Content Entity
 *
 * @property int $id
 * @property int $parentId
 * @property int $siteId
 * @property int $createdBy
 * @property int $modifiedBy
 * @property string $name
 * @property string $slug
 * @property short $type
 * @property short $status
 * @property short $visibility
 * @property string $icon
 * @property short $order
 * @property short $featured
 * @property short $comments
 * @property date $createdAt
 * @property date $modifiedAt
 */
class Content extends \cmsgears\core\common\models\base\Entity implements IApproval, IVisibility {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $multiSite = true;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use CreateModifyTrait;
	use NameTypeTrait;
	use SlugTypeTrait;
	use VisibilityTrait;

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
                'class' => AuthorBehavior::className()
            ],
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'createdAt',
 				'updatedAtAttribute' => 'modifiedAt',
 				'value' => new Expression('NOW()')
            ],
            'sluggableBehavior' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'uniqueValidator' => [ 'targetAttribute' => 'type' ]
            ]
        ];
    }

	// yii\base\Model ---------

    /**
     * @inheritdoc
     */
	public function rules() {

		// model rules
        $rules = [
            [ [ 'name', 'siteId' ], 'required' ],
            [ [ 'id' ], 'safe' ],
            [ [ 'name', 'type' ], 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
			[ [ 'slug', 'icon' ], 'string', 'min' => 1, 'max' => Yii::$app->core->extraLargeText ],
            [ [ 'name', 'type' ], 'unique', 'targetAttribute' => [ 'name', 'type' ] ],
            [ [ 'slug', 'type' ], 'unique', 'targetAttribute' => [ 'slug', 'type' ] ],
            [ [ 'status', 'visibility', 'order' ], 'number', 'integerOnly' => true, 'min' => 0 ],
            [ [ 'featured', 'comments' ], 'boolean' ],
            [ [ 'parentId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'createdBy', 'modifiedBy', 'siteId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		// trim if required
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'name', 'type' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'parentId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'createdBy' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AUTHOR ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'visibility' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'slug' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'featured' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_FEATURED )
		];
	}

	// yii\db\BaseActiveRecord

	public function beforeSave( $insert ) {

	    if( parent::beforeSave( $insert ) ) {

			if( $this->parentId <= 0 ) {

				$this->parentId = null;
			}

			if( !isset( $this->order ) || strlen( $this->order ) <= 0 ) {

				$this->order = 0;
			}

	        return true;
	    }

		return false;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Content -------------------------------

	public function getParent() {

		switch( $row['type'] ) {

			case self::TYPE_PAGE: {

				return $this->hasOne( Page::className(), [ 'id' => 'parentId' ] );
			}
			case self::TYPE_POST: {

				return $this->hasOne( Post::className(), [ 'id' => 'parentId' ] );
			}
		}
	}

	public function getSite() {

		return $this->hasOne( Site::className(), [ 'id' => 'siteId' ] );
	}

	public function getAttributes() {

		return $this->hasMany( ContentAttribute::className(), [ 'pageId' => 'id' ] );
	}

	public function isPage() {

		return $this->type == CmsGlobal::TYPE_PAGE;
	}

	public function isPost() {

		return $this->type == CmsGlobal::TYPE_POST;
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_PAGE;
	}

	// yii\db\BaseActiveRecord

    public static function instantiate( $row ) {

		switch( $row['type'] ) {

			case CmsGlobal::TYPE_PAGE:
			{
				$class = 'cmsgears\cms\common\models\entities\Page';

				break;
			}
			case CmsGlobal::TYPE_POST:
			{
				$class = 'cmsgears\cms\common\models\entities\Post';

				break;
			}
		}

		$model = new $class( null );

        return $model;
    }

	// CMG parent classes --------------------

	// Content -------------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
