<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\ObjectData;
use cmsgears\cms\common\models\forms\SidebarWidget;

use cmsgears\cms\admin\services\SidebarService;
use cmsgears\cms\admin\services\WidgetService;

class SidebarController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'sdebar' ];
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
	                'index'  => [ 'get' ],
	                'all'    => [ 'get' ],
	                'create' => [ 'get', 'post' ],
	                'update' => [ 'get', 'post' ],
	                'delete' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// SidebarController -----------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = SidebarService::getPagination();

	    return $this->render('all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new ObjectData();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$model->type	= CmsGlobal::TYPE_SIDEBAR;
		$model->data	= "{ \"widgets\": {} }";
		$widgets		= WidgetService::getIdNameList();

		$model->setScenario( 'create' );

		// Sidebar Widgets
		$sidebarWidgets	= [];

		for ( $i = 0, $j = count( $widgets ); $i < $j; $i++ ) {

			$sidebarWidgets[] = new SidebarWidget();
		}

		if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && SidebarWidget::loadMultiple( $sidebarWidgets, Yii::$app->request->post(), 'SidebarWidget' ) && 
			$model->validate() && SidebarWidget::validateMultiple( $sidebarWidgets ) ) {

			$sidebar	= SidebarService::create( $model );

			if( $sidebar ) {

				SidebarService::updateWidgets( $sidebar, $sidebarWidgets );

				$this->redirect( [ 'all' ] );
			}
		}

    	return $this->render( 'create', [
    		'model' => $model,
    		'widgets' => $widgets,
    		'sidebarWidgets' => $sidebarWidgets
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= SidebarService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );

			$widgets		= WidgetService::getIdNameList();
			$sidebarWidgets	= SidebarService::getWidgetsForUpdate( $model, $widgets );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && $model->validate() ) {

				if( SidebarService::update( $model ) ) {

					SidebarService::updateWidgets( $model, $sidebarWidgets );

					$this->redirect( [ 'all' ] );
				}
			}
	
	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'sidebarWidgets' => $sidebarWidgets
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= SidebarService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {
			
			$widgets		= WidgetService::getIdNameList();
			$sidebarWidgets	= SidebarService::getWidgetsForUpdate( $model, $widgets );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) ) {

				if( SidebarService::delete( $model ) ) {

					$this->redirect( [ 'all' ] );
				}
			}

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'sidebarWidgets' => $sidebarWidgets
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>