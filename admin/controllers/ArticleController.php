<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\admin\models\forms\PageSettingsForm;

use cmsgears\cms\admin\controllers\base\PageController;

/**
 * ArticleController provides actions specific to articles.
 *
 * @since 1.0.0
 */
class ArticleController extends PageController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $metaService;

	// Protected --------------

	protected $templateService;

	protected $modelContentService;
	protected $modelCategoryService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-cms/admin/views/article' );

		// Config
		$this->type			= CmsGlobal::TYPE_ARTICLE;
		$this->templateType	= CmsGlobal::TYPE_ARTICLE;
		$this->apixBase		= 'cms/page';
		$this->comments		= true;

		$this->settingsClass = PageSettingsForm::class;

		// Services
		$this->modelService = Yii::$app->factory->get( 'articleService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'article' ];

		// Return Url
		$this->returnUrl = Url::previous( 'articles' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/article/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'all' => [ [ 'label' => 'Articles' ] ],
			'create' => [ [ 'label' => 'Articles', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Articles', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Articles', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'settings' => [ [ 'label' => 'Articles', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'articles' );

		return parent::actionAll( $config );
	}

}
