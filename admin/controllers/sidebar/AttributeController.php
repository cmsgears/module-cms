<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\sidebar;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * AttributeController provides actions specific to sidebar attributes.
 *
 * @since 1.0.0
 */
class AttributeController extends \cmsgears\core\admin\controllers\base\AttributeController {

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
		$this->title	= 'Sidebar Attribute';
		$this->apixBase	= 'cms/sidebar/attribute';

		// Services
		$this->modelService		= Yii::$app->factory->get( 'objectMetaService' );
		$this->parentService	= Yii::$app->factory->get( 'sidebarService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-ui', 'child' => 'usidebar' ];

		// Return Url
		$this->returnUrl = Url::previous( 'sidebar-attributes' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/sidebar/attribute/all' ], true );

		// All Url
		$allUrl = Url::previous( 'sidebars' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/cms/sidebar/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Sidebars', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Sidebar Attributes' ] ],
			'create' => [ [ 'label' => 'Sidebar Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Sidebar Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Sidebar Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
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

		Url::remember( Yii::$app->request->getUrl(), 'sidebar-attributes' );

		return parent::actionAll( $pid );
	}

}
