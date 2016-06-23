<?php
namespace cmsgears\cms\common\models\resources;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Template;
use cmsgears\core\common\models\entities\ObjectData;

use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\forms\BlockElement;

use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\VisualTrait;
use cmsgears\core\common\models\traits\mappers\TemplateTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * Block Entity
 *
 * @property int $id
 * @property int $siteId
 * @property int $bannerId
 * @property int $textureId
 * @property int $videoId
 * @property int $templateId
 * @property int $createdBy
 * @property int $modifiedBy
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $active
 * @property string $title
 * @property string $icon
 * @property date $createdAt
 * @property date $modifiedAt
 * @property string $htmlOptions
 * @property string $content
 * @property string $data
 */
class Block extends \cmsgears\core\common\models\base\NamedCmgEntity {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	// Private/Protected --

	// Traits ------------------------------------------------------

	use TemplateTrait;
	use VisualTrait;
	use DataTrait;

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

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
                'ensureUnique' => true
            ]
        ];
    }

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

		// model rules
        $rules = [
        	[ [ 'name', 'siteId' ], 'required' ],
            [ [ 'id', 'title', 'content', 'data' ], 'safe' ],
            [ [ 'name' ], 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->largeText ],
            [ [ 'slug', 'description', 'icon', 'htmlOptions' ], 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->extraLargeText ],
            [ 'name', 'alphanumpun' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ 'active', 'boolean' ],
            [ [ 'templateId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'siteId', 'bannerId', 'videoId', 'textureId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		// trim if required
		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'description', 'htmlOptions', 'title' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'siteId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SITE ),
			'bannerId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'textureId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_TEXTURE ),
			'videoId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VIDEO ),
			'templateId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
			'createdBy' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_AUTHOR ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'slug' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'description' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'active' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ACTIVE ),
			'title' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'icon' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'htmlOptions' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// yii\db\BaseActiveRecord -----------

	public function beforeSave( $insert ) {

	    if( parent::beforeSave( $insert ) ) {

			if( $this->templateId <= 0 ) {

				$this->templateId = null;
			}

	        return true;
	    }

		return false;
	}

	// Block -----------------------------

	public function getSite() {

		return $this->hasOne( Site::className(), [ 'id' => 'siteId' ] );
	}

	/**
	 * @return string representation of flag
	 */
	public function getActiveStr() {

		return Yii::$app->formatter->asBoolean( $this->active );
	}

	public function getElementIdList() {

		$objectData		= $this->generateObjectFromJson();
		$elements		= [];
		$idList			= [];

		if( isset( $objectData->elements ) ) {

			$elements	= $objectData->elements;
		}

		foreach ( $elements as $element ) {

			$element	= new BlockElement( $element );
			$idList[]	= $element->elementId;
		}

		return $idList;
	}

	public function getElements() {

		$idList	= $this->getElementIdList();
		$idList	= join( ',', $idList );

		return ObjectData::find()->where( "id in($idList)" )->all();
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_BLOCK;
	}

	// Block -----------------------------

	// Create -------------

	// Read ---------------

	/**
	 * @return Block - by slug.
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}

	/**
	 * @param string $name
	 * @return Block - by name for current site
	 */
	public static function findByName( $name ) {

		$siteId	= Yii::$app->cmgCore->siteId;

		return static::find()->where( 'name=:name AND siteId=:siteId' )
							->addParams( [ ':name' => $name, ':siteId' => $siteId ] )
							->one();
	}

	// Update -------------

	// Delete -------------
}

?>