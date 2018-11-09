<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\widget;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\admin\controllers\base\AttributeController as BaseAttributeController;

/**
 * AttributeController provides actions specific to widget attributes.
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
		$this->title	= 'Widget Attribute';
		$this->apixBase	= 'cms/widget/attribute';

		// Services
		$this->modelService		= Yii::$app->factory->get( 'objectMetaService' );
		$this->parentService	= Yii::$app->factory->get( 'widgetService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-ui', 'child' => 'uwidget' ];

		// Return Url
		$this->returnUrl = Url::previous( 'attributes' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/widget/attribute/all' ], true );

		// All Url
		$allUrl = Url::previous( 'widgets' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/cms/widget/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Widgets', 'url' =>  $allUrl ]
			],
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
