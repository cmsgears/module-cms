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

use cmsgears\core\common\models\entities\CmgModel;
use cmsgears\core\common\models\entities\CmgFile;

/**
 * ModelBlock Entity
 *
 * @property integer $id
 * @property integer $backgroundId
 * @property integer $textureId
 * @property integer $parentId
 * @property string $parentType
 * @property integer $order
 * @property string $htmlOptions
 * @property string $backgroundClass
 * @property string $textureClass
 * @property string $content
 * @property date $createdAt
 * @property date $modifiedAt
 */
class ModelBlock extends CmgModel {

	// Instance Methods --------------------------------------------

	// ModelBlock

	public function getBackground() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'backgroundId' ] );
	}

	public function getTexture() {

		return $this->hasOne( Template::className(), [ 'id' => 'textureId' ] );
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

			$trim[] = [ [ 'backgroundClass', 'textureClass' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'parentId', 'parentType' ], 'required' ],
            [ [ 'id', 'order', 'htmlOptions', 'backgroundClass', 'textureClass', 'content' ], 'safe' ],
            [ [ 'parentId', 'backgroundId', 'textureId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'order' ], 'number', 'integerOnly' => true, 'min' => 0 ],
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
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'backgroundId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_BACKGROUND ),
			'textureId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_TEXTURE ),
			'order' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'htmlOptions' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_HTML_OPTIONS ),
			'backgroundClass' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_BACKGROUND_CLASS ),
			'textureClass' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_TEXTURE_CLASS )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_MODEL_BLOCK;
	}
}

?>