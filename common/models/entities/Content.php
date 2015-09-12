<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;
use cmsgears\core\common\behaviors\AuthorBehavior;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Template;
use cmsgears\core\common\models\traits\CreateModifyTrait;

/**
 * Content Entity
 *
 * @property int $id
 * @property int $parentId
 * @property int $createdBy
 * @property int $modifiedBy 
 * @property string $name
 * @property string $slug
 * @property short $type
 * @property short $status
 * @property short $visibility
 */
class Content extends \cmsgears\core\common\models\entities\NamedCmgEntity {

	// Pre-Defined Status
	const STATUS_NEW		= 0;
	const STATUS_PUBLISHED	= 5;

	public static $statusMap = [
		self::STATUS_NEW => "new",
		self::STATUS_PUBLISHED => "published"
	];

	// Pre-Defined Visibility
	const VISIBILITY_PRIVATE	= 0;
	const VISIBILITY_PUBLIC		= 5;

	public static $visibilityMap = [
		self::VISIBILITY_PRIVATE => "private",
		self::VISIBILITY_PUBLIC => "public"
	];
	
	use CreateModifyTrait;

	// Instance Methods --------------------------------------------

	// yii\db\BaseActiveRecord

	public function beforeSave( $insert ) {

	    if( parent::beforeSave( $insert ) ) {

			if( $this->parentId <= 0 ) {

				$this->parentId = null;
			}

	        return true;
	    }

		return false;
	}

	// Content

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

	public function isPage() {

		return $this->type == CmsGlobal::TYPE_PAGE;
	}

	public function isPost() {

		return $this->type == CmsGlobal::TYPE_POST;
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->status ];
	}

	public function isNew() {

		return $this->status == self::STATUS_NEW;
	}

	public function isPublished() {

		return $this->status == self::STATUS_PUBLISHED;
	}

	public function getVisibilityStr() {

		return self::$visibilityMap[ $this->visibility ];
	}

	public function isPrivate() {

		return $this->visibility == self::VISIBILITY_PRIVATE;
	}

	public function isPublic() {

		return $this->visibility == self::VISIBILITY_PUBLIC;
	}

	/**
	 * @return boolean - whether given user is author
	 */
	public function checkOwner( $user ) {

		return $this->createdBy	= $user->id;
	}

	// yii\base\Component ----------------

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [

            'authorBehavior' => [
                'class' => AuthorBehavior::className()
            ],
            'sluggableBehavior' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true
            ]
        ];
    }

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'type' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'name' ], 'required' ],
            [ [ 'id', 'slug', 'type', 'status', 'visibility' ], 'safe' ],
            [ [ 'parentId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'createdBy' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_AUTHOR ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'visibility' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ), 
			'status' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'slug' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SLUG )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_PAGE;
	}

	// yii\db\BaseActiveRecord ------------

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
}

?>