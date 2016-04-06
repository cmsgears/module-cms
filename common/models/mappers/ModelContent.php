<?php
namespace cmsgears\cms\common\models\mappers;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Template;
use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\TemplateTrait;
use cmsgears\core\common\models\traits\VisualTrait;
use cmsgears\core\common\models\traits\DataTrait;

/**
 * ModelContent Entity
 *
 * @property integer $id
 * @property integer $bannerId
 * @property integer $videoId
 * @property integer $templateId
 * @property integer $parentId
 * @property string $parentType
 * @property string $summary
 * @property date $createdAt
 * @property date $modifiedAt
 * @property date $publishedAt
 * @property string $seoName
 * @property string $seoDescription
 * @property string $seoKeywords
 * @property string $seoRobot
 * @property integer $viewCount
 * @property string $content
 * @property string $data
 */
class ModelContent extends \cmsgears\core\common\models\base\CmgModel {

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

            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'createdAt',
 				'updatedAtAttribute' => 'modifiedAt',
 				'value' => new Expression('NOW()')
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

			$trim[] = [ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'id', 'parentId', 'parentType', 'summary', 'content', 'data' ], 'safe' ],
            [ [ 'parentType' ], 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->mediumText ],
            [ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->extraLargeText ],
            [ [ 'viewCount' ], 'number', 'integerOnly' => true, 'min' => 0 ],
            [ [ 'templateId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'bannerId', 'videoId', 'parentId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt', 'publishedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
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
			'templateId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'summary' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SUMMARY ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'seoName' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_NAME ),
			'seoDescription' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_DESCRIPTION ),
			'seoKeywords' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_KEYWORDS ),
			'seoRobot' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_ROBOT ),
			'viewCount' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VIEW_COUNT ),
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

	// ModelContent ----------------------

	public function getLimitedSummary( $limit = CoreGlobal::DISPLAY_TEXT_SMALL ) {

		if( strlen( $this->summary ) > $limit ) {

			return substr( $this->summary, 0, $limit );
		}

		return $this->summary;
	}

	public function getLimitedContent( $limit = CoreGlobal::DISPLAY_TEXT_MEDIUM ) {

		if( strlen( $this->content ) > $limit ) {

			return substr( $this->content, 0, $limit );
		}

		return $this->content;
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_MODEL_CONTENT;
	}

	// ModelContent ----------------------

	// Create -------------

	// Read ---------------

	// Update -------------

	// Delete -------------
}

?>