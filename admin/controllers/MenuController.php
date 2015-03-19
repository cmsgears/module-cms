<?php
namespace cmsgears\modules\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\modules\core\common\config\CoreGlobal;

use cmsgears\modules\cms\common\models\entities\Menu;
use cmsgears\modules\cms\common\models\entities\CMSPermission;

use cmsgears\modules\cms\admin\models\forms\PageBinderForm;

use cmsgears\modules\cms\admin\services\PageService;
use cmsgears\modules\cms\admin\services\MenuService;

use cmsgears\modules\core\admin\controllers\BaseController;

use cmsgears\modules\core\common\utilities\MessageUtil;

class MenuController extends BaseController {
	
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
	                'index'  => CMSPermission::PERM_CMS_MENU,
	                'all'   => CMSPermission::PERM_CMS_MENU,
	                'create' => CMSPermission::PERM_CMS_MENU,
	                'update' => CMSPermission::PERM_CMS_MENU,
	                'delete' => CMSPermission::PERM_CMS_MENU
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

	// UserController

	public function actionIndex() {

		$this->redirect( self::URL_ALL );
	}

	public function actionAll() {

		$pagination = MenuService::getPagination();

	    return $this->render('all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionCreate() {

		$model	= new Menu();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post( "Menu" ), "" )  && $model->validate() ) {

			if( MenuService::create( $model ) ) {

				$binder = new PageBinderForm();

				$binder->menuId	= $model->getId();
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				MenuService::bindPages( $binder );

				return $this->redirect( [ self::URL_ALL ] );
			}
		}

		$pages	= PageService::getIdNameMap();

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
	
			if( $model->load( Yii::$app->request->post( "Menu" ), "" )  && $model->validate() ) {
	
				if( MenuService::update( $model ) ) {
	
					$binder = new PageBinderForm();
	
					$binder->menuId	= $model->getId();
					$binder->load( Yii::$app->request->post( "Binder" ), "" );
	
					MenuService::bindPages( $binder );
	
					$this->refresh();
				}
			}

			$pages	= PageService::getIdNameMap();
	
	    	return $this->render('update', [
	    		'model' => $model,
	    		'pages' => $pages
	    	]);			
		}
		
		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= MenuService::findById( $id );
		
		// Delete/Render if exist
		if( isset( $model ) ) {

			if( isset( $_POST ) && count( $_POST ) > 0 ) {
	
				if( MenuService::delete( $model ) ) {
		
					return $this->redirect( [ self::URL_ALL ] );
				}
			}

			$pages	= PageService::getIdNameMap();

	    	return $this->render('delete', [
	    		'model' => $model,
	    		'pages' => $pages
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>