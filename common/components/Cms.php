<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\components;

// Yii Imports
use Yii;
use yii\base\Component;

/**
 * Cms component register the services provided by Cms Module.
 *
 * @since 1.0.0
 */
class Cms extends Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	/**
	 * Initialize the services.
	 */
	public function init() {

		parent::init();

		// Register components and objects
		$this->registerComponents();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Cms -----------------------------------

	// Properties ----------------

	// Components and Objects ----

	/**
	 * Register the services.
	 */
	public function registerComponents() {

		// Register services
		$this->registerResourceServices();
		$this->registerMapperServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initMapperServices();
		$this->initEntityServices();
	}

	/**
	 * Registers resource services.
	 */
	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\ICategoryService', 'cmsgears\cms\common\services\resources\CategoryService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\ITagService', 'cmsgears\cms\common\services\resources\TagService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\IContentMetaService', 'cmsgears\cms\common\services\resources\ContentMetaService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\IModelContentService', 'cmsgears\cms\common\services\resources\ModelContentService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\ILinkService', 'cmsgears\cms\common\services\resources\LinkService' );
	}

	/**
	 * Registers mapper services.
	 */
	public function registerMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelCategoryService', 'cmsgears\cms\common\services\mappers\ModelCategoryService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelTagService', 'cmsgears\cms\common\services\mappers\ModelTagService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelElementService', 'cmsgears\cms\common\services\mappers\ModelElementService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelBlockService', 'cmsgears\cms\common\services\mappers\ModelBlockService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelLinkService', 'cmsgears\cms\common\services\mappers\ModelLinkService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelWidgetService', 'cmsgears\cms\common\services\mappers\ModelWidgetService' );
	}

	/**
	 * Registers entity services.
	 */
	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IElementService', 'cmsgears\cms\common\services\entities\ElementService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IBlockService', 'cmsgears\cms\common\services\entities\BlockService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IMenuService', 'cmsgears\cms\common\services\entities\MenuService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IWidgetService', 'cmsgears\cms\common\services\entities\WidgetService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\ISidebarService', 'cmsgears\cms\common\services\entities\SidebarService' );

		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IPageService', 'cmsgears\cms\common\services\entities\PageService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IPostService', 'cmsgears\cms\common\services\entities\PostService' );
	}

	/**
	 * Initialize resource services.
	 */
	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'categoryService', 'cmsgears\cms\common\services\resources\CategoryService' );
		$factory->set( 'tagService', 'cmsgears\cms\common\services\resources\TagService' );

		$factory->set( 'contentMetaService', 'cmsgears\cms\common\services\resources\ContentMetaService' );
		$factory->set( 'modelContentService', 'cmsgears\cms\common\services\resources\ModelContentService' );

		$factory->set( 'linkService', 'cmsgears\cms\common\services\resources\LinkService' );
	}

	/**
	 * Initialize mapper services.
	 */
	public function initMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'modelCategoryService', 'cmsgears\cms\common\services\mappers\ModelCategoryService' );
		$factory->set( 'modelTagService', 'cmsgears\cms\common\services\mappers\ModelTagService' );

		$factory->set( 'modelElementService', 'cmsgears\cms\common\services\mappers\ModelElementService' );
		$factory->set( 'modelBlockService', 'cmsgears\cms\common\services\mappers\ModelBlockService' );

		$factory->set( 'modelLinkService', 'cmsgears\cms\common\services\mappers\ModelLinkService' );

		$factory->set( 'modelWidgetService', 'cmsgears\cms\common\services\mappers\ModelWidgetService' );
	}

	/**
	 * Initialize entity services.
	 */
	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'elementService', 'cmsgears\cms\common\services\entities\ElementService' );
		$factory->set( 'blockService', 'cmsgears\cms\common\services\entities\BlockService' );

		$factory->set( 'menuService', 'cmsgears\cms\common\services\entities\MenuService' );

		$factory->set( 'widgetService', 'cmsgears\cms\common\services\entities\WidgetService' );
		$factory->set( 'sidebarService', 'cmsgears\cms\common\services\entities\SidebarService' );

		$factory->set( 'pageService', 'cmsgears\cms\common\services\entities\PageService' );
		$factory->set( 'postService', 'cmsgears\cms\common\services\entities\PostService' );
	}

}
