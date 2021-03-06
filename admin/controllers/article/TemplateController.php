<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\article;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * TemplateController provide actions specific to article templates.
 *
 * @since 1.0.0
 */
class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CmsGlobal::PERM_BLOG_ADMIN;

		// Config
		$this->type		= CmsGlobal::TYPE_ARTICLE;
		$this->apixBase = 'cms/page/template';

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'article-template' ];

		// Return Url
		$this->returnUrl = Url::previous( 'article-templates' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/article/template/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Article Templates' ] ],
			'create' => [ [ 'label' => 'Article Templates', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Article Templates', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Article Templates', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'data' => [ [ 'label' => 'Article Templates', 'url' => $this->returnUrl ], [ 'label' => 'Data' ] ],
			'attributes' => [ [ 'label' => 'Article Templates', 'url' => $this->returnUrl ], [ 'label' => 'Attributes' ] ],
			'config' => [ [ 'label' => 'Article Templates', 'url' => $this->returnUrl ], [ 'label' => 'Config' ] ],
			'settings' => [ [ 'label' => 'Article Templates', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TemplateController --------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'article-templates' );

		return parent::actionAll( $config );
	}

}
