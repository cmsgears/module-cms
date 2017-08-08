<?php
namespace cmsgears\cms\admin\controllers\post;

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

	public $postService;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Services
		$this->postService	= Yii::$app->factory->get( 'postService' );

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

	public function actionIndex( $pid = null ) {

		$post = $this->postService->getById( $pid );

		if( isset( $post ) ) {

			Url::remember( [ '/cms/post/all' ], 'galleries' );

			$gallery = $post->gallery;

			if( isset( $gallery ) ) {

		    	return $this->redirect( [ 'items', 'id' => $gallery->id ] );
			}
			else {

				$gallery 			= new Gallery();
				$gallery->name		= $post->name;
				$gallery->type		= CmsGlobal::TYPE_POST;
				$gallery->siteId	= Yii::$app->core->siteId;

				if( $gallery->load( Yii::$app->request->post(), 'Gallery' )  && $gallery->validate() ) {

					$this->modelService->create( $gallery );

					if( $this->postService->linkGallery( $post, $gallery ) ) {

						$this->redirect( [ "index?pid=$post->id" ] );
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
