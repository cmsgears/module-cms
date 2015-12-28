<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

/**
 * ModelBlock Entity
 *
 * @property integer $id
 * @property integer $blockId
 * @property integer $parentId
 * @property string $parentType
 * @property integer $order
 * @property short $active
 */
class ModelBlock extends \cmsgears\core\common\models\entities\CmgModel {

	// Instance Methods --------------------------------------------

	public function getBlock() {

		return $this->hasOne( Block::className(), [ 'id' => 'blockId' ] );
	}

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        $rules = [
            [ [ 'blockId', 'parentId', 'parentType' ], 'required' ],
            [ [ 'id', 'active' ], 'safe' ],
            [ [ 'blockId' ], 'integerOnly' => true, 'min' => 1, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'parentId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'parentType' ], 'string', 'min' => 1, 'max' => 100 ],
            [ 'order', 'number', 'integerOnly' => true, 'min' => 0 ]
        ];

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'blockId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_BLOCK ),
			'order' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'active' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ACTIVE )
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

	// ModelBlock ------------------------

	// Read ----

	public static function findByBlockId( $parentId, $parentType, $blockId ) {

		return self::find()->where( 'parentId=:pid AND parentType=:ptype AND blockId=:bid', [ ':pid' => $parentId, ':ptype' => $parentType, ':bid' => $blockId ] )->one(); 
	}

	// Delete ----

	/**
	 * Delete all entries related to a block
	 */
	public static function deleteByBlockId( $blockId ) {

		self::deleteAll( 'blockId=:bid', [ ':bid' => $blockId ] );
	}
}

?>