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

/**
 * The cms index migration inserts the recommended indexes for better performance. It
 * also list down other possible index commented out. These indexes can be created using
 * project based migration script.
 *
 * @since 1.0.0
 */
class m160623_065815_cms_index extends Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;
	}

	public function up() {

		$this->upPrimary();

		$this->upDependent();
	}

	private function upPrimary() {

		// Content
		$this->createIndex( 'idx_' . $this->prefix . 'page_name', $this->prefix . 'cms_page', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_slug', $this->prefix . 'cms_page', 'slug' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_type', $this->prefix . 'cms_page', 'type' );
		//$this->createIndex( 'idx_' . $this->prefix . 'page_icon', $this->prefix . 'cms_page', 'icon' );
	}

	private function upDependent() {

		// Page Meta
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_name', $this->prefix . 'cms_page_meta', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_type', $this->prefix . 'cms_page_meta', 'type' );
		//$this->createIndex( 'idx_' . $this->prefix . 'page_meta_type_v', $this->prefix . 'cms_page_meta', 'valueType' );
		//$this->createIndex( 'idx_' . $this->prefix . 'page_meta_mit', $this->prefix . 'cms_page_meta', [ 'modelId', 'type' ] );
		//$this->createIndex( 'idx_' . $this->prefix . 'page_meta_mitn', $this->prefix . 'cms_page_meta', [ 'modelId', 'type', 'name' ] );

		// Model Content
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_type', $this->prefix . 'cms_model_content', 'type' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_type_p', $this->prefix . 'cms_model_content', 'parentType' );
		//$this->createIndex( 'idx_' . $this->prefix . 'model_content_piptt', $this->prefix . 'cms_model_content', [ 'parentId', 'parentType', 'type' ] );
	}

	public function down() {

		$this->downPrimary();

		$this->downDependent();
	}

	private function downPrimary() {

		// Content
		$this->dropIndex( 'idx_' . $this->prefix . 'page_name', $this->prefix . 'cms_page' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_slug', $this->prefix . 'cms_page' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_type', $this->prefix . 'cms_page' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'page_icon', $this->prefix . 'cms_page' );
	}

	private function downDependent() {

		// Page Meta
		$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_name', $this->prefix . 'cms_page_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_type', $this->prefix . 'cms_page_meta' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_type_v', $this->prefix . 'cms_page_meta' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_mit', $this->prefix . 'cms_page_meta' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_mitn', $this->prefix . 'cms_page_meta' );

		// Model Content
		$this->dropIndex( 'idx_' . $this->prefix . 'model_content_type', $this->prefix . 'cms_model_content' );
		$this->dropIndex( 'idx_' . $this->prefix . 'model_content_type_p', $this->prefix . 'cms_model_content' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'model_content_piptt', $this->prefix . 'cms_model_content' );
	}

}
