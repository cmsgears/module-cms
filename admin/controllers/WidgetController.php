<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\Widget;

use cmsgears\cms\admin\models\forms\SidebarBinderForm;

use cmsgears\cms\admin\services\SidebarService;
use cmsgears\cms\admin\services\WidgetService;

use cmsgears\core\admin\controllers\BaseController;

class WidgetController extends BaseController {

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
	                'matrix' => CmsGlobal::PERM_CMS,
	                'create' => CmsGlobal::PERM_CMS,
	                'update' => CmsGlobal::PERM_CMS,
	                'delete' => CmsGlobal::PERM_CMS,
	                'meta'   => CmsGlobal::PERM_CMS,
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => ['get'],
	                'all'    => ['get'],
	                'matrix' => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post'],
	                'meta'   => ['get', 'post']
                ]
            ]
        ];
    }

	// UserController --------------------

	public function actionIndex() {

		$this->redirect( "all" );
	}

	public function actionAll() {

		$pagination = WidgetService::getPagination();

	    return $this->render('all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionMatrix() {

		$pagination 	= WidgetService::getPagination();
		
		$allSidebars	= SidebarService::getIdNameMap();

	    return $this->render('matrix', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'allSidebars' => $allSidebars
	    ]);
	}

	public function actionCreate() {

		$model	= new Widget();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post( "Widget" ), "" )  && $model->validate() ) {

			if( WidgetService::create( $model ) ) {

				$binder = new SidebarBinderForm();

				$binder->widgetId	= $model->getId();
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				WidgetService::bindSidebars( $binder );

				return $this->redirect( "all" );
			}
		}

		$sidebars	= SidebarService::getIdNameMap();

    	return $this->render('create', [
    		'model' => $model,
    		'sidebars' => $sidebars
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model			= WidgetService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( "update" );

			if( $model->load( Yii::$app->request->post( "Widget" ), "" )  && $model->validate() ) {

				if( WidgetService::update( $model ) ) {
		
					$binder = new SidebarBinderForm();
	
					$binder->widgetId	= $model->getId();
					$binder->load( Yii::$app->request->post( "Binder" ), "" );

					WidgetService::bindSidebars( $binder );
	
					$this->refresh();
				}
			}

			$sidebars	= SidebarService::getIdNameMap();

	    	return $this->render('update', [
	    		'model' => $model,
	    		'sidebars' => $sidebars
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}

	public function actionDelete( $id ) {

		// Find Model
		$model			= WidgetService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post( "Widget" ), "" ) ) {

				if( WidgetService::delete( $model ) ) {

					return $this->redirect( "all" );
				}
			}

			$sidebars	= SidebarService::getIdNameMap();

	    	return $this->render('delete', [
	    		'model' => $model,
	    		'sidebars' => $sidebars
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );		
	}
	
	// Widgets -------------------------------------------------------------------

	public function actionMeta( $id ) {

		// Find Model
		$model			= WidgetService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( "meta" );

			if( $model->load( Yii::$app->request->post( "Widget" ), "" )  && $model->validate() ) {

				if( WidgetService::updateMeta( $model ) ) {
	
					$this->refresh();
				}
			}

			$model->generateMapFromJson();

			$view	= '@templates/widget/' . $model->getTemplate();

	    	return $this->render( $view, [
	    		'model' => $model
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>