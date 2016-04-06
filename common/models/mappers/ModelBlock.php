<?php
namespace cmsgears\cms\common\models\mappers;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;

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
class ModelBlock extends \cmsgears\core\common\models\base\CmgModel {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	// Private/Protected --

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        $rules = [
            [ [ 'blockId', 'parentId', 'parentType' ], 'required' ],
            [ [ 'id' ], 'safe' ],
            [ [ 'parentType' ], 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->mediumText ],
            [ 'order', 'number', 'integerOnly' => true, 'min' => 0 ],
            [ 'active', 'boolean' ],
            [ [ 'blockId' ], 'integerOnly' => true, 'min' => 1, 'tooSmall' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
            [ [ 'parentId' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'blockId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_BLOCK ),
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'order' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'active' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ACTIVE )
		];
	}

	// ModelBlock ------------------------

	public function getBlock() {

		return $this->hasOne( Block::className(), [ 'id' => 'blockId' ] );
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

	// Create -------------

	// Read ---------------

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

	// Update -------------

	// Delete -------------
}

?>