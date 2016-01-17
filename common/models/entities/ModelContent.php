<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Template;

/**
 * ModelContent Entity
 *
 * @property int $id
 * @property int $bannerId
 * @property int $videoId
 * @property int $templateId
 * @property int $parentId
 * @property string $parentType
 * @property string $summary
 * @property date $createdAt
 * @property date $modifiedAt
 * @property date $publishedAt
 * @property string $seoName
 * @property string $seoDescription
 * @property string $seoKeywords
 * @property string $seoRobot
 * @property string $content
 * @property string $data 
 */
class ModelContent extends \cmsgears\core\common\models\entities\CmgModel {

	// Instance Methods --------------------------------------------

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'bannerId' ] );
	}

	public function getBannerUrl() {

		$banner			= $this->banner;
		$bannerUrl		= isset( $banner ) ? $banner->getFileUrl() : null;

		return $bannerUrl;
	}

	public function getVideo() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'videoId' ] );
	}

	public function getVideoUrl() {

		$video			= $this->video;
		$videoUrl		= isset( $video ) ? $video->getFileUrl() : null;

		return $videoUrl;
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

	public function getLimitedSummary( $limit = CoreGlobal::DISPLAY_LIMIT_TEXT ) {

		if( strlen( $this->summary ) > $limit ) {

			return substr( $this->summary, 0, $limit );
		}

		return $this->summary;
	}

	public function getLimitedContent( $limit = CoreGlobal::DISPLAY_LIMIT_TEXT ) {

		if( strlen( $this->content ) > $limit ) {

			return substr( $this->content, 0, $limit );
		}

		return $this->content;
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
            [ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'safe' ],
            [ [ 'templateId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'bannerId', 'videoId', 'parentId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'parentType' ], 'string', 'min' => 1, 'max' => 100 ],
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
			'data' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
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

	// Read ------
}

?>