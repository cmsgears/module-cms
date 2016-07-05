<?php
namespace cmsgears\cms\common\models\resources;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Template;
use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\ResourceTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\VisualTrait;
use cmsgears\core\common\models\traits\mappers\TemplateTrait;

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
 * @property date $publishedAt
 * @property string $seoName
 * @property string $seoDescription
 * @property string $seoKeywords
 * @property string $seoRobot
 * @property integer $viewCount
 * @property string $content
 * @property string $data
 */
class ModelContent extends \cmsgears\core\common\models\base\Entity {

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
	use ResourceTrait;
	use TemplateTrait;
	use VisualTrait;

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

		$trim		= [];

		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'id', 'parentId', 'parentType', 'summary', 'content', 'data' ], 'safe' ],
            [ [ 'parentType' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
            [ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
            [ [ 'viewCount' ], 'number', 'integerOnly' => true, 'min' => 0 ],
            [ [ 'templateId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'bannerId', 'videoId', 'parentId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'publishedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		if( Yii::$app->core->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'bannerId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'videoId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIDEO ),
			'templateId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
			'parentId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'summary' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SUMMARY ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'seoName' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_NAME ),
			'seoDescription' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_DESCRIPTION ),
			'seoKeywords' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_KEYWORDS ),
			'seoRobot' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_ROBOT ),
			'viewCount' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIEW_COUNT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
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

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ModelContent --------------------------

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

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_MODEL_CONTENT;
	}

	// CMG parent classes --------------------

	// ModelContent --------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}

?>