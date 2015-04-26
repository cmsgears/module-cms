<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\Category;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\Post;

use cmsgears\cms\admin\models\forms\PostCategoryBinderForm;

use cmsgears\cms\admin\services\TemplateService;
use cmsgears\core\admin\services\CategoryService;
use cmsgears\cms\admin\services\PostService;

use cmsgears\core\admin\controllers\BaseController;

class PostController extends BaseController {

	const URL_ALL 		= 'all';

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

		$this->redirect( "all" );
	}

	public function actionAll() {

		$pagination = PostService::getPagination();

	    return $this->render( 'all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionMatrix() {

		$pagination 	= PostService::getPagination();
		$allCategories	= CategoryService::getIdNameMapByType( CmsGlobal::CATEGORY_TYPE_POST );

	    return $this->render('matrix', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'allCategories' => $allCategories
	    ]);
	}

	public function actionCreate() {

		$model	= new Post();
		$banner = new CmgFile();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post( "Post" ), "" )  && $model->validate() ) {

			$banner->load( Yii::$app->request->post( "File" ), "" );

			if( PostService::create( $model, $banner ) ) {

				$binder = new PostCategoryBinderForm();

				$binder->pageId	= $model->id;
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				PostService::bindCategories( $binder );

				return $this->redirect( "all" );
			}
		}

		$categories		= CategoryService::getIdNameMapByType( CmsGlobal::CATEGORY_TYPE_POST );
		$templatesMap	= TemplateService::getIdNameMapForPages();

    	return $this->render('create', [
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

			$model->setScenario( "update" );

			if( $model->load( Yii::$app->request->post( "Post" ), "" )  && $model->validate() ) {

				$banner->load( Yii::$app->request->post( "File" ), "" );

				if( PostService::update( $model, $banner ) ) {

					$binder = new PostCategoryBinderForm();

					$binder->pageId	= $model->id;
					$binder->load( Yii::$app->request->post( "Binder" ), "" );

					PostService::bindCategories( $binder );

					$this->refresh();
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CmsGlobal::CATEGORY_TYPE_POST );
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

			if( $model->load( Yii::$app->request->post( "Post" ), "" ) ) {

				if( PostService::delete( $model ) ) {

					return $this->redirect( "all" );
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CmsGlobal::CATEGORY_TYPE_POST );
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

		$pagination = CategoryService::getPaginationByType( CmsGlobal::CATEGORY_TYPE_POST );

	    return $this->render('categories', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'type' => CmsGlobal::CATEGORY_TYPE_POST
	    ]);
	}
}

?>