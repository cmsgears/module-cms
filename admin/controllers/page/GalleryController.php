<?php
namespace cmsgears\cms\admin\controllers\page;

// Yii Imports
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;
use cmsgears\core\common\models\resources\Gallery;

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

		// Services
		$this->pageService	= Yii::$app->factory->get( 'pageService' );

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

	public function actionIndex( $pid = null ) {

		$page = $this->pageService->getById( $pid );

		if( isset( $page ) ) {

			Url::remember( [ '/cms/page/all' ], 'galleries' );

			$gallery = $page->gallery;

			if( isset( $gallery ) ) {

		    	return $this->redirect( [ 'items', 'id' => $gallery->id ] );
			}
			else {

				$gallery 			= new Gallery();
				$gallery->name		= $page->name;
				$gallery->type		= CmsGlobal::TYPE_PAGE;
				$gallery->siteId	= Yii::$app->core->siteId;

				if( $gallery->load( Yii::$app->request->post(), 'Gallery' )  && $gallery->validate() ) {

					$this->modelService->create( $gallery );

					if( $this->pageService->linkGallery( $page, $gallery ) ) {

						$this->redirect( [ "index?pid=$page->id" ] );
					}
				}

				$templatesMap	= $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

				return $this->render( 'create', [
					'model' => $gallery,
					'templatesMap' => $templatesMap
				]);
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
