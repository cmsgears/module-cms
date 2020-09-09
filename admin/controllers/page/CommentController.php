<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\page;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\ModelComment;

/**
 * CommentController provides actions specific to page comments.
 *
 * @since 1.0.0
 */
class CommentController extends \cmsgears\core\admin\controllers\base\CommentController {

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
		$this->parentType	= CmsGlobal::TYPE_PAGE;
		$this->commentType	= ModelComment::TYPE_COMMENT;
		$this->apixBase		= 'cms/page/comment';
		$this->parentUrl	= '/cms/page/update?id=';
		$this->parentCol	= 'Page';
		$this->urlKey		= 'page-comments';

		// Services
		$this->parentService = Yii::$app->factory->get( 'pageService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'page-comments' ];

		// Return Url
		$this->returnUrl = Url::previous( $this->urlKey );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/page/comment/all' ], true );

		// All Url
		$allUrl = Url::previous( 'pages' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/cms/page/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Pages', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Page Comments' ] ],
			'create' => [ [ 'label' => 'Page Comments', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Page Comments', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Page Comments', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CommentController ---------------------

}
