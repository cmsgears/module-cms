<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

/**
 * ContentAttribute Entity
 *
 * @property integer $id
 * @property integer $pageId
 * @property string $name
 * @property string $label
 * @property string $type
 * @property string $valueType
 * @property string $value
 */
class ContentAttribute extends \cmsgears\core\common\models\entities\Attribute {

	// Instance Methods --------------------------------------------

	public function getParent() {

		return $this->hasOne( Content::className(), [ 'id' => 'pageId' ] );
	}

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {
		
		// model rules
        $rules = [
            [ [ 'pageId', 'name' ], 'required' ],
            [ [ 'id', 'label', 'value' ], 'safe' ],
            [ [ 'pageId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'name', 'type', 'valueType' ], 'string', 'min' => 1, 'max' => 100 ],
            [ 'label', 'string', 'min' => 1, 'max' => 150 ],
            [ 'name', 'alphanumu' ],
            [ 'name', 'validatenameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validatenameUpdate', 'on' => [ 'update' ] ]
        ];

		// trim if required
		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'type', 'valueType', 'value' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'pageId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'label' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_LABEL ),
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'valueType' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VALUE_TYPE ),
			'value' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VALUE )
		];
	}

	// ContentAttribute ------------------

	/**
	 * Validates to ensure that only one attribute exist with one name.
	 */
    public function validateNameCreate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( self::isExistByTypeName( $this->pageId, $this->type, $this->name ) ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_EXIST ) );
            }
        }
    }

	/**
	 * Validates to ensure that only one attribute exist with one name.
	 */
    public function validateNameUpdate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$existingConfig = self::findByTypeName( $this->pageId, $this->type, $this->name );

			if( isset( $existingConfig ) && $existingConfig->id != $this->id && 
				$existingConfig->pageId == $this->pageId &&  
				strcmp( $existingConfig->name, $this->name ) == 0 && $existingConfig->type == $this->type ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_EXIST ) );
			}
        }
    }

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CoreTables::TABLE_MODEL_ATTRIBUTE;
	}

	// ContentAttribute ------------------

	/**
	 * @param integer $pageId
	 * @param string $type
	 * @return array - ContentAttribute by type
	 */
	public static function findByType( $pageId, $type ) {

		return self::find()->where( 'pageId=:pid AND type=:type', [ ':pid' => $pageId, ':type' => $type ] )->all();
	}

	/**
	 * @param integer $pageId
	 * @param string $name
	 * @return ContentAttribute - by name
	 */
	public static function findByName( $pageId, $name ) {

		return self::find()->where( 'parentId=:pid AND name=:name', [ ':pid' => $pageId, ':name' => $name ] )->one();
	}

	/**
	 * @param integer $pageId
	 * @param string $type
	 * @param string $name
	 * @return ModelAttribute - by type and name
	 */
	public static function findByTypeName( $pageId, $type, $name ) {

		return self::find()->where( 'parentId=:pid AND type=:type AND name=:name', [ ':pid' => $pageId, ':type' => $type, ':name' => $name ] )->one();
	}

	/**
	 * @param integer $pageId
	 * @param string $type
	 * @param string $name
	 * @return boolean - Check whether attribute exist by type and name
	 */
	public static function isExistByTypeName( $pageId, $type, $name ) {

		$config = self::findByTypeName( $pageId, $type, $name );

		return isset( $config );
	}
}

?>