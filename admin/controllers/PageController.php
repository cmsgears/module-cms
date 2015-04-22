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
use cmsgears\cms\common\models\entities\Page;

use cmsgears\cms\admin\models\forms\MenuBinderForm;

use cmsgears\cms\admin\services\TemplateService;
use cmsgears\cms\admin\services\PageService;
use cmsgears\cms\admin\services\MenuService;

use cmsgears\core\admin\controllers\BaseController;

class PageController extends BaseController {
	
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
	                'matrix' => [ 'permission' => CmsGlobal::PERM_CMS ],
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
	                'matrix' => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post']
                ]
            ]
        ];
    }

	// UserController --------------------

	public function actionIndex() {

		$this->redirect( "all" );
	}

	public function actionAll() {

		$pagination = PageService::getPagination();

	    return $this->render('all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionMatrix() {

		$pagination = PageService::getPagination();
		
		$allMenus	= MenuService::getIdNameList();

	    return $this->render('matrix', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'allMenus' => $allMenus
	    ]);
	}

	public function actionCreate() {

		$model	= new Page();
		$banner = new CmgFile();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post( "Page" ), "" )  && $model->validate() ) {

			$banner->load( Yii::$app->request->post( "File" ), "" );

			if( PageService::create( $model, $banner ) ) {

				$binder = new MenuBinderForm();

				$binder->pageId	= $model->id;
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				PageService::bindMenus( $binder );

				return $this->redirect( "all" );
			}
		}

		$menus			= MenuService::getIdNameList();
		$templatesMap	= TemplateService::getIdNameMapForPages();

    	return $this->render('create', [
    		'model' => $model,
    		'banner' => $banner,
    		'menus' => $menus,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= PageService::findById( $id );
		$banner = new CmgFile();

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( "update" );

			if( $model->load( Yii::$app->request->post( "Page" ), "" )  && $model->validate() ) {

				$banner->load( Yii::$app->request->post( "File" ), "" );

				if( PageService::update( $model, $banner ) ) {
	
					$binder = new MenuBinderForm();
	
					$binder->pageId	= $model->id;
					$binder->load( Yii::$app->request->post( "Binder" ), "" );
	
					PageService::bindMenus( $binder );
	
					$this->refresh();
				}
			}

			$menus			= MenuService::getIdNameList();
			$visibilities	= Page::$visibilityMap;
			$status			= Page::$statusMap;
			$banner			= $model->banner;
			$templatesMap	= TemplateService::getIdNameMapForPages();

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'menus' => $menus,
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
		$model	= PageService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post( "Page" ), "" ) ) {

				if( PageService::delete( $model ) ) {

					return $this->redirect( "all" );
				}
			}

			$menus			= MenuService::getIdNameList();
			$visibilities	= Page::$visibilityMap;
			$status			= Page::$statusMap;
			$banner			= $model->banner;
			$templatesMap	= TemplateService::getIdNameMapForPages();
			
	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'menus' => $menus,
	    		'visibilities' => $visibilities,
	    		'status' => $status,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>