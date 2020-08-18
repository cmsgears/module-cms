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
 * ModelFileController provides actions specific to sidebar files.
 *
 * @since 1.0.0
 */
class ModelFileController extends \cmsgears\core\admin\controllers\base\ModelFileController {

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
		$this->title	= 'Sidebar File';
		$this->apixBase	= 'cms/sidebar/model-file';

		// Services
		$this->parentService = Yii::$app->factory->get( 'sidebarService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-ui', 'child' => 'usidebar' ];

		// Return Url
		$this->returnUrl = Url::previous( 'sidebar-files' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/sidebar/file/all' ], true );

		// All Url
		$allUrl = Url::previous( 'sidebars' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/cms/sidebar/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Sidebars', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Sidebar Files' ] ],
			'create' => [ [ 'label' => 'Sidebar Files', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Sidebar Files', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Sidebar Files', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ModelFileController -------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'sidebar-files' );

		return parent::actionAll( $pid );
	}

}
