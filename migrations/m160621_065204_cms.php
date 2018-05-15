<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\base\Migration;

use cmsgears\core\common\models\base\Meta;

/**
 * The cms migration inserts the database tables of cms module. It also insert the foreign
 * keys if FK flag of migration component is true.
 *
 * @since 1.0.0
 */
class m160621_065204_cms extends Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix		= Yii::$app->migration->cmgPrefix;

		// Get the values via config
		$this->fk			= Yii::$app->migration->isFk();
		$this->options		= Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

	public function up() {

		// Page
		$this->upPage();
		$this->upPageMeta();
		$this->upPageFollower();

		// Link
		$this->upLink();

		// Resources
		$this->upModelContent();
		$this->upModelLink();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
	}

	private function upPage() {

		$this->createTable( $this->prefix . 'cms_page', [
			'id' => $this->bigPrimaryKey( 20 ),
			'siteId' => $this->bigInteger( 20 )->notNull(),
			'avatarId' => $this->bigInteger( 20 ),
			'parentId' => $this->bigInteger( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'slug' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'texture' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'title' => $this->string( Yii::$app->core->xxxLargeText )->defaultValue( null ),
			'description' => $this->string( Yii::$app->core->xtraLargeText )->defaultValue( null ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'pinned' => $this->boolean()->notNull()->defaultValue( false ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'comments' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
		], $this->options );

		// Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'page_site', $this->prefix . 'cms_page', 'siteId' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_avatar', $this->prefix . 'cms_page', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_parent', $this->prefix . 'cms_page', 'parentId' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_creator', $this->prefix . 'cms_page', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_modifier', $this->prefix . 'cms_page', 'modifiedBy' );
	}

	private function upPageMeta() {

		$this->createTable( $this->prefix . 'cms_page_meta', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'label' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText ),
			'active' => $this->boolean()->defaultValue( false ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'valueType' => $this->string( Yii::$app->core->mediumText )->notNull()->defaultValue( Meta::VALUE_TYPE_TEXT ),
			'value' => $this->text(),
			'data' => $this->mediumText()
		], $this->options );

		// Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_parent', $this->prefix . 'cms_page_meta', 'modelId' );
	}

	private function upPageFollower() {

        $this->createTable( $this->prefix . 'cms_page_follower', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'active' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns user and model
		$this->createIndex( 'idx_' . $this->prefix . 'page_follower_user', $this->prefix . 'cms_page_follower', 'modelId' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_follower_parent', $this->prefix . 'cms_page_follower', 'parentId' );
	}

	private function upLink() {

		$this->createTable( $this->prefix . 'cms_link', [
			'id' => $this->bigPrimaryKey( 20 ),
			'siteId' => $this->bigInteger( 20 )->notNull(),
			'pageId' => $this->bigInteger( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'title' => $this->string( Yii::$app->core->xxxLargeText )->defaultValue( null ),
			'url' => $this->string( Yii::$app->core->xxxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'absolute' => $this->boolean()->notNull()->defaultValue( false ),
			'user' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'htmlOptions' => $this->text(),
			'urlOptions' => $this->text(),
			'data' => $this->mediumText()
		], $this->options );

		// Index for columns site, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'link_site', $this->prefix . 'cms_link', 'siteId' );
		$this->createIndex( 'idx_' . $this->prefix . 'link_page', $this->prefix . 'cms_link', 'pageId' );
		$this->createIndex( 'idx_' . $this->prefix . 'link_creator', $this->prefix . 'cms_link', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'link_modifier', $this->prefix . 'cms_link', 'modifiedBy' );
	}

	private function upModelContent() {

		$this->createTable( $this->prefix . 'cms_model_content', [
			'id' => $this->bigPrimaryKey( 20 ),
			'templateId' => $this->bigInteger( 20 ),
			'bannerId' => $this->bigInteger( 20 ),
			'videoId' => $this->bigInteger( 20 ),
			'galleryId' => $this->bigInteger( 20 ),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'parentType' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText ),
			'summary' => $this->text(),
			'seoName' => $this->string( Yii::$app->core->xxLargeText )->defaultValue( null ),
			'seoDescription' => $this->string( Yii::$app->core->xxLargeText )->defaultValue( null ),
			'seoKeywords' => $this->string( Yii::$app->core->xxLargeText )->defaultValue( null ),
			'seoRobot' => $this->string( Yii::$app->core->xxLargeText )->defaultValue( null ),
			'publishedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText()
		], $this->options );

		// Index for columns base, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_template', $this->prefix . 'cms_model_content', 'templateId' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_banner', $this->prefix . 'cms_model_content', 'bannerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_video', $this->prefix . 'cms_model_content', 'videoId' );
	}

	private function upModelLink() {

		$this->createTable( $this->prefix . 'cms_model_link', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'parentType' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'active' => $this->boolean()->notNull()->defaultValue( true )
		], $this->options );

		// Index for columns user
		$this->createIndex( 'idx_' . $this->prefix . 'model_link_parent', $this->prefix . 'cms_model_link', 'modelId' );
	}

	private function generateForeignKeys() {

		// Page
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_site', $this->prefix . 'cms_page', 'siteId', $this->prefix . 'core_site', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_avatar', $this->prefix . 'cms_page', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_parent', $this->prefix . 'cms_page', 'parentId', $this->prefix . 'cms_page', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_creator', $this->prefix . 'cms_page', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_modifier', $this->prefix . 'cms_page', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Page meta
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_meta_parent', $this->prefix . 'cms_page_meta', 'modelId', $this->prefix . 'cms_page', 'id', 'CASCADE' );

		// Page Follower
        $this->addForeignKey( 'fk_' . $this->prefix . 'page_follower_user', $this->prefix . 'cms_page_follower', 'modelId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_follower_parent', $this->prefix . 'cms_page_follower', 'parentId', $this->prefix . 'cms_page', 'id', 'CASCADE' );

		// Link
		$this->addForeignKey( 'fk_' . $this->prefix . 'link_site', $this->prefix . 'cms_link', 'siteId', $this->prefix . 'core_site', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'link_page', $this->prefix . 'cms_link', 'pageId', $this->prefix . 'cms_page', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'link_creator', $this->prefix . 'cms_link', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'link_modifier', $this->prefix . 'cms_link', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Model Content
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_content_template', $this->prefix . 'cms_model_content', 'templateId', $this->prefix . 'core_template', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_content_banner', $this->prefix . 'cms_model_content', 'bannerId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_content_video', $this->prefix . 'cms_model_content', 'videoId', $this->prefix . 'core_file', 'id', 'SET NULL' );

		// Model Link
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_link_parent', $this->prefix . 'cms_model_link', 'modelId', $this->prefix . 'cms_link', 'id', 'CASCADE' );
	}

	public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

		$this->dropTable( $this->prefix . 'cms_page' );
		$this->dropTable( $this->prefix . 'cms_page_meta' );
		$this->dropTable( $this->prefix . 'cms_page_follower' );

		$this->dropTable( $this->prefix . 'cms_link' );

		$this->dropTable( $this->prefix . 'cms_model_content' );
		$this->dropTable( $this->prefix . 'cms_model_link' );
	}

	private function dropForeignKeys() {

		// Page
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_site', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_avatar', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_parent', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_creator', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_modifier', $this->prefix . 'cms_page' );

		// Page meta
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_meta_parent', $this->prefix . 'cms_page_meta' );

		// Page Follower
        $this->dropForeignKey( 'fk_' . $this->prefix . 'page_follower_user', $this->prefix . 'cms_page_follower' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_follower_parent', $this->prefix . 'cms_page_follower' );

		// Link
		$this->dropForeignKey( 'fk_' . $this->prefix . 'link_site', $this->prefix . 'cms_link' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'link_page', $this->prefix . 'cms_link' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'link_creator', $this->prefix . 'cms_link' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'link_modifier', $this->prefix . 'cms_link' );

		// Model Content
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_content_template', $this->prefix . 'cms_model_content' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_content_banner', $this->prefix . 'cms_model_content' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_content_video', $this->prefix . 'cms_model_content' );

		// Model Link
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_link_parent', $this->prefix . 'cms_model_link', 'modelId' );
	}

}
