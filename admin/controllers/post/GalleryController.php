<?php
namespace cmsgears\cms\admin\controllers\post;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class GalleryController extends \cmsgears\core\admin\controllers\base\GalleryController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $postService;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Config
		$this->type			= CmsGlobal::TYPE_POST;
		$this->parentUrl	= '/cms/post/all';

		// Services
		$this->parentService	= Yii::$app->factory->get( 'postService' );

		// Sidebar
		$this->sidebar		= [ 'parent' => 'sidebar-cms', 'child' => 'post' ];

		// Return Url
		$this->returnUrl	= Url::previous( 'posts' );
		$this->returnUrl	= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/all/' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [ [ 'label' => 'Posts', 'url' =>  [ '/cms/post/all' ] ] ],
			'index' => [ [ 'label' => 'Gallery' ] ],
			'items' => [ [ 'label' => 'Gallery', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ],
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GalleryController ---------------------

}
