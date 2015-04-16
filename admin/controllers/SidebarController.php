<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\Sidebar;

use cmsgears\cms\admin\models\forms\WidgetBinderForm;

use cmsgears\cms\admin\services\SidebarService;
use cmsgears\cms\admin\services\WidgetService;

use cmsgears\core\admin\controllers\BaseController;

class SidebarController extends BaseController {
	
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
                'permissions' => [
	                'index'  => CmsGlobal::PERM_CMS,
	                'all'    => CmsGlobal::PERM_CMS,
	                'create' => CmsGlobal::PERM_CMS,
	                'update' => CmsGlobal::PERM_CMS,
	                'delete' => CmsGlobal::PERM_CMS
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => ['get'],
	                'all'    => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post']
                ]
            ]
        ];
    }

	// SidebarController -----------------

	public function actionIndex() {

		$this->redirect( "all" );
	}

	public function actionAll() {

		$pagination = SidebarService::getPagination();

	    return $this->render('all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionCreate() {

		$model	= new Sidebar();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post( "Sidebar" ), "" )  && $model->validate() ) {

			if( SidebarService::create( $model ) ) {

				$binder = new WidgetBinderForm();

				$binder->sidebarId	= $model->getId();
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				SidebarService::bindWidgets( $binder );

				return $this->redirect( "all" );
			}
		}

		$widgets	= WidgetService::getIdNameMap();

    	return $this->render('create', [
    		'model' => $model,
    		'widgets' => $widgets
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= SidebarService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( "update" );

			if( $model->load( Yii::$app->request->post( "Sidebar" ), "" )  && $model->validate() ) {

				if( SidebarService::update( $model ) ) {
		
					$binder = new WidgetBinderForm();
	
					$binder->sidebarId	= $model->getId();
					$binder->load( Yii::$app->request->post( "Binder" ), "" );
	
					SidebarService::bindWidgets( $binder );
	
					$this->refresh();
				}
			}

			$widgets	= WidgetService::getIdNameMap();
	
	    	return $this->render('update', [
	    		'model' => $model,
	    		'widgets' => $widgets
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= SidebarService::findById( $id );
		
		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post( "Sidebar" ), "" ) ) {

				if( SidebarService::delete( $model ) ) {

					return $this->redirect( "all" );
				}
			}

			$widgets	= WidgetService::getIdNameMap();

	    	return $this->render('delete', [
	    		'model' => $model,
	    		'widgets' => $widgets
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>