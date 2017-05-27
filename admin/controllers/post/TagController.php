<?php
namespace cmsgears\cms\admin\controllers\post;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class TagController extends \cmsgears\cms\admin\controllers\base\TagController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		$this->type				= CmsGlobal::TYPE_POST;

		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'post-tag' ];

		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/tag/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TagController -------------------------

	public function actionAll() {

		Url::remember( [ 'post/tag/all' ], 'tags' );

		return parent::actionAll();
	}
}
