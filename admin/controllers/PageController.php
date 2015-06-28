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
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\ModelContent;

use cmsgears\core\admin\services\TemplateService;
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

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = PageService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionMatrix() {

		$dataProvider 	= PageService::getPagination();
		$menusList		= MenuService::getIdNameList();

	    return $this->render( 'matrix', [
	         'dataProvider' => $dataProvider,
	         'menusList' => $menusList
	    ]);
	}

	public function actionCreate() {

		$model		= new Page();
		$content	= new ModelContent();
		$banner	 	= new CmgFile();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Page' )  && $model->validate() &&
		    $content->load( Yii::$app->request->post(), 'ModelContent' )  && $content->validate() ) {

			$banner->load( Yii::$app->request->post(), 'File' );

			if( PageService::create( $model, $content, $banner ) ) {

				$binder = new Binder();

				$binder->binderId	= $model->id;
				$binder->load( Yii::$app->request->post(), 'Binder' );

				PageService::bindMenus( $binder );

				$this->redirect( [ 'all' ] );
			}
		}

		$menus			= MenuService::getIdNameList();
		$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_PAGE );

    	return $this->render( 'create', [
    		'model' => $model,
    		'content' => $content,
    		'banner' => $banner,
    		'menus' => $menus,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= PageService::findById( $id );
		$banner 	= new CmgFile();

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Page' )  && $model->validate() &&
		    	$content->load( Yii::$app->request->post(), 'ModelContent' )  && $content->validate() ) {

				$banner->load( Yii::$app->request->post(), 'File' );

				if( PageService::update( $model, $content, $banner ) ) {

					$binder = new Binder();

					$binder->binderId	= $model->id;
					$binder->load( Yii::$app->request->post(), 'Binder' );
	
					PageService::bindMenus( $binder );
	
					$this->redirect( [ 'all' ] );
				}
			}

			$menus			= MenuService::getIdNameList();
			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$banner			= $content->banner;
			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_PAGE );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
	    		'menus' => $menus,
	    		'visibilityMap' => $visibilityMap,
	    		'statusMap' => $statusMap,
	    		'templatesMap' => $templatesMap
	    	]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= PageService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {
			
			$content	= $model->content;

			if( $model->load( Yii::$app->request->post(), 'Page' ) ) {

				if( PageService::delete( $model, $content ) ) {

					$this->redirect( [ 'all' ] );
				}
			}

			$menus			= MenuService::getIdNameList();
			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$banner			= $content->banner;
			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_PAGE );
			
	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
	    		'menus' => $menus,
	    		'visibilityMap' => $visibilityMap,
	    		'statusMap' => $statusMap,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>