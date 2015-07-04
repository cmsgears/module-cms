<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgEntity;
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Template;

/**
 * ModelContent Entity
 *
 * @property int $id
 * @property int $bannerId
 * @property int $templateId
 * @property int $parentId
 * @property string $parentType
 * @property string $summary
 * @property string $content
 * @property date $createdAt
 * @property date $modifiedAt
 * @property date $publishedAt
 * @property string $seoName
 * @property string $seoDescription
 * @property string $seoKeywords
 * @property string $seoRobot
 */
class ModelContent extends CmgEntity {

	// Instance Methods --------------------------------------------

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

	// ModelContent

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'bannerId' ] );
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

        return [
            [ [ 'id', 'parentId', 'parentType', 'summary', 'content' ], 'safe' ],
            [ [ 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ], 'safe' ],
            [ [ 'templateId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'parentId', 'bannerId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt', 'publishedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'bannerId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'templateId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'summary' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SUMMARY ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'seoName' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_NAME ),
			'seoDescription' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_DESCRIPTION ),
			'seoKeywords' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_KEYWORDS ),
			'seoRobot' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SEO_ROBOT )
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

	// Read ----

	/**
	 * @return ModelContent - by id
	 */
	public static function findById( $id ) {

		return self::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}

	/**
	 * @param int $parentId
	 * @param string $parentType
	 * @return ModelContent by parent id and type
	 */
	public static function findByParentIdType( $parentId, $parentType ) {

		return self::find()->where( 'parentId=:id AND parentType=:type', [ ':id' => $parentId, ':type' => $parentType ] )->one();
	}

	// Delete ----

	/**
	 * Delete all the entries associated with the parent.
	 */
	public static function deleteByParentIdType( $parentId, $parentType ) {

		self::deleteAll( 'parentId=:id AND parentType=:type', [ ':id' => $parentId, ':type' => $parentType ] );
	}
}

?>