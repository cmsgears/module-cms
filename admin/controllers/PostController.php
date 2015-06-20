<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\forms\Binder;
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\Category;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\Post;

use cmsgears\cms\admin\services\TemplateService;
use cmsgears\core\admin\services\CategoryService;
use cmsgears\cms\admin\services\PostService;

use cmsgears\core\admin\controllers\BaseController;

class PostController extends BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'index'  => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'all'    => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'create' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'update' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'delete' => [ 'permission' => CmsGlobal::PERM_CMS ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => ['get'],
	                'all'   => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post']
                ]
            ]
        ];
    }

	// PostController --------------------

	public function actionIndex() {

		$this->redirect( [  'all' ] );
	}

	public function actionAll() {

		$dataProvider = PostService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionMatrix() {

		$dataProvider 	= PostService::getPagination();
		$categoriesList	= CategoryService::getIdNameListByType( CmsGlobal::CATEGORY_TYPE_POST );

	    return $this->render( 'matrix', [
	         'dataProvider' => $dataProvider,
	         'categoriesList' => $categoriesList
	    ]);
	}

	public function actionCreate() {

		$model	= new Post();
		$banner = new CmgFile();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Post' )  && $model->validate() ) {

			$banner->load( Yii::$app->request->post(), 'File' );

			if( PostService::create( $model, $banner ) ) {

				$binder = new Binder();

				$binder->binderId	= $model->id;
				$binder->load( Yii::$app->request->post(), 'Binder' );

				PostService::bindCategories( $binder );

				$this->redirect( [  'all' ] );
			}
		}

		$categories		= CategoryService::getIdNameListByType( CmsGlobal::CATEGORY_TYPE_POST );
		$templatesMap	= TemplateService::getIdNameMapForPages();

    	return $this->render( 'create', [
    		'model' => $model,
    		'banner' => $banner,
    		'categories' => $categories,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= PostService::findById( $id );
		$banner 	= new CmgFile();

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Post' )  && $model->validate() ) {

				$banner->load( Yii::$app->request->post(), 'File' );

				if( PostService::update( $model, $banner ) ) {

					$binder = new Binder();

					$binder->binderId	= $model->id;
					$binder->load( Yii::$app->request->post(), 'Binder' );

					PostService::bindCategories( $binder );

					$this->redirect( [  'all' ] );
				}
			}

			$categories		= CategoryService::getIdNameListByType( CmsGlobal::CATEGORY_TYPE_POST );
			$visibilities	= Page::$visibilityMap;
			$status			= Page::$statusMap;
			$banner			= $model->banner;
			$templatesMap	= TemplateService::getIdNameMapForPages();

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'categories' => $categories,
	    		'visibilities' => $visibilities,
	    		'status' => $status,
	    		'templatesMap' => $templatesMap
	    	]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= PostService::findById( $id );
		$banner = new CmgFile();

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'Post' ) ) {

				if( PostService::delete( $model ) ) {

					$this->redirect( [  'all' ] );
				}
			}

			$categories		= CategoryService::getIdNameListByType( CmsGlobal::CATEGORY_TYPE_POST );
			$visibilities	= Page::$visibilityMap;
			$status			= Page::$statusMap;
			$banner			= $model->banner;
			$templatesMap	= TemplateService::getIdNameMapForPages();

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'categories' => $categories,
	    		'visibilities' => $visibilities,
	    		'status' => $status,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	// Categories -------------------

	public function actionCategories() {

		$dataProvider = CategoryService::getPaginationByType( CmsGlobal::CATEGORY_TYPE_POST );

	    return $this->render( 'categories', [
	         'dataProvider' => $dataProvider,
	         'type' => CmsGlobal::CATEGORY_TYPE_POST
	    ]);
	}
}

?>