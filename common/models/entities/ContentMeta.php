<?php
namespace cmsgears\cms\common\models\entities;

/**
 * ContentMeta Entity
 *
 * @property integer $pageId
 * @property string $name
 * @property string $value
 */
class ContentMeta extends CmgEntity {

	// Instance methods --------------------------------------------------

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'pageId', 'name' ], 'required' ],
			[ [ 'value' ], 'safe' ],
            [ 'pageId', 'number', 'integerOnly' => true, 'min' => 1 ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'string', 'min'=>1, 'max'=>100 ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'value' => 'Value'
		];
	}

	// Static methods --------------------------------------------------

	// yii\db\ActiveRecord ----------------

	public static function tableName() {

		return CmsTables::TABLE_PAGE_META;
	}

	// ContentMeta ------------------------

	// Find

	public static function findByPageId( $pageId ) {

		return self::find()->where( 'pageId=:id', [ ':id' => $pageId ] )->all();
	}

	// Delete

	public static function deleteByPageId( $pageId ) {

		self::deleteAll( 'pageId=:id', [ ':id' => $pageId ] );
	}
}

?>