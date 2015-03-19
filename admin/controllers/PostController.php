<?php
namespace cmsgears\modules\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\modules\core\common\config\CoreGlobal;
use cmsgears\modules\cms\common\config\CMSGlobal;

use cmsgears\modules\core\common\models\entities\CmgFile;
use cmsgears\modules\core\common\models\entities\Category;
use cmsgears\modules\cms\common\models\entities\Page;
use cmsgears\modules\cms\common\models\entities\Post;
use cmsgears\modules\cms\common\models\entities\CMSPermission;

use cmsgears\modules\cms\admin\models\forms\PostCategoryBinderForm;

use cmsgears\modules\core\admin\services\CategoryService;
use cmsgears\modules\cms\admin\services\PostService;

use cmsgears\modules\core\admin\controllers\BaseController;

use cmsgears\modules\core\common\utilities\MessageUtil;

class PostController extends BaseController {

	const URL_ALL 		= 'all';

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'permissions' => [
	                'index'  => CMSPermission::PERM_CMS_POST,
	                'all'    => CMSPermission::PERM_CMS_POST,
	                'create' => CMSPermission::PERM_CMS_POST,
	                'update' => CMSPermission::PERM_CMS_POST,
	                'delete' => CMSPermission::PERM_CMS_POST
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

	// PostController

	public function actionIndex() {

		$this->redirect( self::URL_ALL );
	}

	public function actionAll() {

		$pagination = PostService::getPagination();

	    return $this->render('all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionMatrix() {

		$pagination 	= PostService::getPagination();
		$allCategories	= CategoryService::getIdNameMapByType( CMSGlobal::CATEGORY_TYPE_POST );

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

			$banner 		= new CmgFile();

			$banner->load( Yii::$app->request->post( "File" ), "" );

			if( PostService::create( $model, $banner ) ) {

				$binder = new PostCategoryBinderForm();

				$binder->pageId	= $model->getId();
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				PostService::bindCategories( $binder );

				return $this->redirect( [ self::URL_ALL ] );
			}
		}

		$categories	= CategoryService::getIdNameMapByType( CMSGlobal::CATEGORY_TYPE_POST );

    	return $this->render('create', [
    		'model' => $model,
    		'banner' => $banner,
    		'categories' => $categories
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

				$banner 		= new CmgFile();		

				$banner->load( Yii::$app->request->post( "File" ), "" );

				if( PostService::update( $model, $banner ) ) {

					$binder = new PostCategoryBinderForm();

					$binder->pageId	= $model->getId();
					$binder->load( Yii::$app->request->post( "Binder" ), "" );

					PostService::bindCategories( $binder );

					$this->refresh();
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CMSGlobal::CATEGORY_TYPE_POST );
			$visibilities	= Page::$visibilityMap;
			$status			= Page::$statusMap;
			$banner			= $model->banner;

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'categories' => $categories,
	    		'visibilities' => $visibilities,
	    		'status' => $status
	    	]);
		}
		
		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= PostService::findById( $id );
		$banner = new CmgFile();

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( isset( $_POST ) && count( $_POST ) > 0 ) {

				if( PostService::delete( $model ) ) {

					return $this->redirect( [ self::URL_ALL ] );
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CMSGlobal::CATEGORY_TYPE_POST );
			$visibilities	= Page::$visibilityMap;
			$status			= Page::$statusMap;
			$banner			= $model->banner;

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'categories' => $categories,
	    		'visibilities' => $visibilities,
	    		'status' => $status
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	// Categories -------------------

	public function actionCategories() {

		$pagination = CategoryService::getPaginationByType( CMSGlobal::CATEGORY_TYPE_POST );

	    return $this->render('categories', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'type' => CMSGlobal::CATEGORY_TYPE_POST
	    ]);
	}
}

?>