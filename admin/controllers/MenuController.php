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
use cmsgears\cms\common\models\forms\Link;

use cmsgears\cms\admin\services\MenuService;
use cmsgears\cms\admin\services\PageService;

class MenuController extends \cmsgears\core\admin\controllers\base\Controller {

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

	// MenuController --------------------
	
	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = MenuService::getPagination();

	    return $this->render('all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new ObjectData();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$model->type	= CmsGlobal::TYPE_MENU;
		$model->data	= "{ \"pages\": [], \"links\": [] }";

		$model->setScenario( 'create' );
		
		// Menu Links
		$links	= [];

		for ( $i = 0; $i < 4; $i++ ) {

			$links[] = new Link();
		}

		if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && Link::loadMultiple( $links, Yii::$app->request->post(), 'Link' ) &&  
			$model->validate() && Link::validateMultiple( $links ) ) {

			$menu = MenuService::create( $model );

			if( $menu ) {

				$binder 			= new Binder();
				$binder->binderId	= $model->id;

				$binder->load( Yii::$app->request->post(), 'BinderPage' );

				MenuService::bindPages( $binder );

				MenuService::updateLinks( $menu, $links );

				$this->redirect( [ 'all' ] );
			}
		}

		$pages	= PageService::getIdNameList();

    	return $this->render( 'create', [
    		'model' => $model,
    		'pages' => $pages,
    		'links' => $links
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= MenuService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );

			$links	= MenuService::getLinks( $model );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && Link::loadMultiple( $links, Yii::$app->request->post(), 'Link' ) &&  
				$model->validate() && Link::validateMultiple( $links ) ) {

				if( MenuService::update( $model ) ) {

					$binder 			= new Binder();
					$binder->binderId	= $model->id;
	
					$binder->load( Yii::$app->request->post(), 'BinderPage' );
	
					MenuService::bindPages( $binder );

					MenuService::updateLinks( $model, $links );

					$this->redirect( [ 'all' ] );
				}
			}

			$pages	= PageService::getIdNameList();
	
	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'pages' => $pages,
	    		'links' => $links
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

			$links	= MenuService::getLinks( $model );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) ) {

				if( MenuService::delete( $model ) ) {

					$this->redirect( [ 'all' ] );
				}
			}

			$pages	= PageService::getIdNameList();

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'pages' => $pages,
	    		'links' => $links
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>