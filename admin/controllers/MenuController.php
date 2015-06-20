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
use cmsgears\cms\common\models\entities\Menu;

use cmsgears\cms\admin\services\PageService;
use cmsgears\cms\admin\services\MenuService;

use cmsgears\core\admin\controllers\BaseController;

class MenuController extends BaseController {
		
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
	                'all'   => [ 'permission' => CmsGlobal::PERM_CMS ],
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

	// UserController --------------------

	public function actionIndex() {

		$this->redirect( [ "all" ] );
	}

	public function actionAll() {

		$dataProvider = MenuService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model	= new Menu();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post(), 'Menu' )  && $model->validate() ) {

			if( MenuService::create( $model ) ) {

				$binder = new Binder();

				$binder->binderId	= $model->id;
				$binder->load( Yii::$app->request->post(), 'Binder' );

				MenuService::bindPages( $binder );

				$this->redirect( [ "all" ] );
			}
		}

		$pages	= PageService::getIdNameList();

    	return $this->render('create', [
    		'model' => $model,
    		'pages' => $pages
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model		
		$model	= MenuService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( "update" );

			if( $model->load( Yii::$app->request->post(), 'Menu' )  && $model->validate() ) {

				if( MenuService::update( $model ) ) {

					$binder = new Binder();

					$binder->binderId	= $model->id;
					$binder->load( Yii::$app->request->post(), 'Binder' );

					MenuService::bindPages( $binder );

					$this->redirect( [ "all" ] );
				}
			}

			$pages	= PageService::getIdNameList();
	
	    	return $this->render('update', [
	    		'model' => $model,
	    		'pages' => $pages
	    	]);			
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= MenuService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'Menu' ) ) {

				if( MenuService::delete( $model ) ) {

					$this->redirect( [ "all" ] );
				}
			}

			$pages	= PageService::getIdNameList();

	    	return $this->render('delete', [
	    		'model' => $model,
	    		'pages' => $pages
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>