<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedCmgEntity;

class Template extends NamedCmgEntity {

	const TYPE_PAGE		= 0;
	const TYPE_WIDGET	= 5;

	// Instance Methods --------------------------------------------

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'name', 'type' ], 'required' ],
            [ 'name', 'alphanumspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'id', 'description' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'description' => 'Description'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_TEMPLATE;
	}

	// Template --------------------------

	public static function findByType( $type ) {

		return self::find()->where( 'type=:type', [ ':type' => $type ] )->all();
	}

	public static function findForPages() {

		return self::find()->where( 'type=:type', [ ':type' => self::TYPE_PAGE ] )->all();
	}

	public static function findForWidgets() {

		return self::find()->where( 'type=:type', [ ':type' => self::TYPE_WIDGET ] )->all();
	}
}

?>