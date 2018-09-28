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

use cmsgears\core\admin\controllers\base\AttributeController as BaseAttributeController;

/**
 * AttributeController provides actions specific to article attributes.
 *
 * @since 1.0.0
 */
class AttributeController extends BaseAttributeController {

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
		$this->title	= 'Article Attribute';
		$this->apixBase	= 'cms/article/attribute';

		// Services
		$this->modelService		= Yii::$app->factory->get( 'pageMetaService' );
		$this->parentService	= Yii::$app->factory->get( 'articleService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'article' ];

		// Return Url
		$this->returnUrl = Url::previous( 'attributes' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/article/attribute/all' ], true );

		// Article Url
		$articleUrl = Url::previous( 'articles' );
		$articleUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/article/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [ [ 'label' => 'Articles', 'url' =>  $articleUrl ] ],
			'all' => [ [ 'label' => 'Attributes' ] ],
			'create' => [ [ 'label' => 'Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// AttributeController -------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'attributes' );

		return parent::actionAll( $pid );
	}

}