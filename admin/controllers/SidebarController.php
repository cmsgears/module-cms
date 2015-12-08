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
use cmsgears\core\common\models\entities\ObjectData;

use cmsgears\cms\admin\services\SidebarService;
use cmsgears\cms\admin\services\WidgetService;

class SidebarController extends \cmsgears\core\admin\controllers\base\Controller {

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
		$model->data	= "{ \"widgets\": [] }";

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && $model->validate() ) {

			if( SidebarService::create( $model ) ) {

				$binder 			= new Binder();
				$binder->binderId	= $model->id;

				$binder->load( Yii::$app->request->post(), 'Binder' );

				SidebarService::bindWidgets( $binder );

				$this->redirect( [ 'all' ] );
			}
		}

		$widgets	= WidgetService::getIdNameList();

    	return $this->render( 'create', [
    		'model' => $model,
    		'widgets' => $widgets
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= SidebarService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && $model->validate() ) {

				if( SidebarService::update( $model ) ) {

					$binder 			= new Binder();
					$binder->binderId	= $model->id;
	
					$binder->load( Yii::$app->request->post(), 'Binder' );

					SidebarService::bindWidgets( $binder );

					$this->redirect( [ 'all' ] );
				}
			}

			$widgets	= WidgetService::getIdNameList();
	
	    	return $this->render('update', [
	    		'model' => $model,
	    		'widgets' => $widgets
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

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) ) {

				if( SidebarService::delete( $model ) ) {

					$this->redirect( [ 'all' ] );
				}
			}

			$widgets	= WidgetService::getIdNameList();

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'widgets' => $widgets
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>