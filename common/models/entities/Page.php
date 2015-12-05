<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\traits\FileTrait;
use cmsgears\cms\common\models\traits\ContentTrait;
use cmsgears\cms\common\models\traits\BlockTrait;

class Page extends Content {

	use FileTrait;

	public $fileType	= CmsGlobal::TYPE_PAGE;

	use ContentTrait;

	public $contentType	= CmsGlobal::TYPE_PAGE;

	use BlockTrait;

	public $blockType	= CmsGlobal::TYPE_PAGE;

	// Instance Methods --------------------------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function find() {

		$postTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$postTable.type" => CmsGlobal::TYPE_PAGE ] );
	}

	// Page ------------------------------

	/**
	 * @return Page - by slug.
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug AND siteId=:siteId', [ ':slug' => $slug, ':siteId' => Yii::$app->cmgCore->siteId ] )->one();
	}
}

?>