<?php
namespace cmsgears\cms\admin\controllers\page;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\ModelComment;

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
        $this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Config
		$this->parentUrl		= '/cms/page/comment/all?pid=';
		$this->commentUrl		= 'page/comment';
		$this->parentType		= CmsGlobal::TYPE_PAGE;
		$this->commentType		= ModelComment::TYPE_COMMENT;

		// Services
		$this->parentService	= Yii::$app->factory->get( 'pageService' );

		// Sidebar
		$this->sidebar 			= [ 'parent' => 'sidebar-cms', 'child' => 'page-comments' ];

		// Return Url
		$this->returnUrl		= Url::previous( $this->commentUrl );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/page/comment/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [ [ 'label' => 'Pages', 'url' =>  [ '/cms/page/all' ] ] ],
			'all' => [ [ 'label' => 'Comments' ] ],
			'create' => [ [ 'label' => 'Comments', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Comments', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Comments', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
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
