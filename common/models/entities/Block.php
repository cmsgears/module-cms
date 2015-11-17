<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;
use cmsgears\core\common\behaviors\AuthorBehavior;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Template;

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
 * @property string $htmlOptions
 * @property string $backgroundClass
 * @property string $textureClass
 * @property string $content
 * @property date $createdAt
 * @property date $modifiedAt
 */
class Block extends \cmsgears\core\common\models\entities\CmgEntity {

	// Instance Methods --------------------------------------------

	// Block

	public function getSite() {

		return $this->hasOne( Site::className(), [ 'id' => 'siteId' ] );
	}

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'bannerId' ] );
	}

	public function getTexture() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'textureId' ] );
	}

	public function getVideo() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'videoId' ] );
	}

	public function getTemplate() {

		return $this->hasOne( Template::className(), [ 'id' => 'templateId' ] );
	}

	public function getTemplateName() {

		$template = $this->template;

		if( isset( $template ) ) {

			return $template->name;
		}

		return '';
	}

	// yii\db\BaseActiveRecord

	public function beforeSave( $insert ) {

	    if( parent::beforeSave( $insert ) ) {

			if( $this->templateId <= 0 ) {

				$this->templateId = null;
			}

	        return true;
	    }

		return false;
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

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'description', 'htmlOptions', 'backgroundClass', 'textureClass' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
        	[ [ 'name', 'siteId' ], 'required' ],
            [ [ 'id', 'slug', 'description', 'htmlOptions', 'backgroundClass', 'textureClass', 'title', 'content' ], 'safe' ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'templateId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'bannerId', 'videoId', 'textureId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
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
			'bannerId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'videoId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VIDEO ),
			'textureId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_TEXTURE ),
			'templateId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'title' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'slug' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'description' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'htmlOptions' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_HTML_OPTIONS ),
			'backgroundClass' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_BACKGROUND_CLASS ),
			'textureClass' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_TEXTURE_CLASS )
		];
	}

	// Block -----------------------------	

	/**
	 * Validates to ensure that only one message exist with one name for a particular locale.
	 */
    public function validateNameCreate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( self::isExistByNameSiteId( $this->name, $this->siteId ) ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
            }
        }
    }

	/**
	 * Validates to ensure that only one message exist with one name.
	 */
    public function validateNameUpdate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$existingContent = self::findByNameSiteId( $this->name, $this->siteId );

			if( isset( $existingContent ) && $existingContent->id != $this->id && 
				$existingContent->siteId == $this->siteId && strcmp( $existingContent->name, $this->name ) == 0 ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
			}
        }
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

	// Read ------

	/**
	 * @return Block - by slug.
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}

	/**
	 * @param string $name
	 * @param int $siteId
	 * @return Block - by name and site id
	 */
	public static function findByNameSiteId( $name, $siteId ) {

		return static::find()->where( 'name=:name AND siteId=:siteId' )
							->addParams( [ ':name' => $name, ':siteId' => $siteId ] )
							->one();
	}

	/**
	 * @param string $name
	 * @param int $siteId
	 * @return boolean - check whether content exist by name and site id
	 */
	public static function isExistByNameSiteId( $name, $siteId ) {
		
		$content = self::findByNameSiteId( $name, $siteId );

		return isset( $content );
	}
}

?>