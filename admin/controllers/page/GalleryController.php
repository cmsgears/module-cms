<?php
namespace cmsgears\cms\admin\controllers\page;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class GalleryController extends \cmsgears\core\admin\controllers\base\GalleryController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $pageService;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Config
		$this->type			= CmsGlobal::TYPE_PAGE;
		$this->parentUrl	= '/cms/page/all';

		// Services
		$this->parentService	= Yii::$app->factory->get( 'pageService' );

		// Sidebar
		$this->sidebar		= [ 'parent' => 'sidebar-cms', 'child' => 'page' ];

		// Return Url
		$this->returnUrl	= Url::previous( 'pages' );
		$this->returnUrl	= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/page/all/' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [ [ 'label' => 'Pages', 'url' =>  [ '/cms/page/all' ] ] ],
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
