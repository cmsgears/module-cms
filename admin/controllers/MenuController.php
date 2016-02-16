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
use cmsgears\cms\common\models\forms\Link;
use cmsgears\cms\common\models\forms\PageLink;

use cmsgears\cms\admin\services\MenuService;
use cmsgears\cms\admin\services\PageService;

class MenuController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'menu' ];
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

		return $this->redirect( [ 'all' ] );
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
		$model->data	= "{ \"links\": {} }";
		$pages			= PageService::getIdNameList();

		$model->setScenario( 'create' );

		// Menu Pages
		$pageLinks	= [];

		for ( $i = 0, $j = count( $pages ); $i < $j; $i++ ) {

			$pageLinks[] = new PageLink();
		}

		// Menu Links
		$links	= [];

		for ( $i = 0; $i < 4; $i++ ) {

			$links[] = new Link();
		}

		if( $model->load( Yii::$app->request->post(), 'ObjectData' ) &&  
			Link::loadMultiple( $links, Yii::$app->request->post(), 'Link' ) && PageLink::loadMultiple( $pageLinks, Yii::$app->request->post(), 'PageLink' ) && 
			$model->validate() && Link::validateMultiple( $links ) && PageLink::validateMultiple( $pageLinks ) ) {

			$menu = MenuService::create( $model );

			if( $menu ) {

				MenuService::updateLinks( $menu, $links, $pageLinks );

				return $this->redirect( [ 'all' ] );
			}
		}

    	return $this->render( 'create', [
    		'model' => $model,
    		'pages' => $pages,
    		'links' => $links,
    		'pageLinks' => $pageLinks
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= MenuService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );

			$pages		= PageService::getIdNameList();
			$links		= MenuService::getLinks( $model );
			$pageLinks	= MenuService::getPageLinksForUpdate( $model, $pages );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) &&  
				Link::loadMultiple( $links, Yii::$app->request->post(), 'Link' ) && PageLink::loadMultiple( $pageLinks, Yii::$app->request->post(), 'PageLink' ) && 
				$model->validate() && Link::validateMultiple( $links ) && PageLink::validateMultiple( $pageLinks ) ) {

				if( MenuService::update( $model ) ) {

					MenuService::updateLinks( $model, $links, $pageLinks );

					return $this->redirect( [ 'all' ] );
				}
			}

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'links' => $links,
	    		'pageLinks' => $pageLinks
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

			$pages		= PageService::getIdNameList();
			$links		= MenuService::getLinks( $model );
			$pageLinks	= MenuService::getPageLinksForUpdate( $model, $pages );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) ) {

				if( MenuService::delete( $model ) ) {

					return $this->redirect( [ 'all' ] );
				}
			}

			$pages	= PageService::getIdNameList();

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'links' => $links,
	    		'pageLinks' => $pageLinks
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>