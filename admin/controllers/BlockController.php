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
use cmsgears\cms\common\models\entities\Block;

use cmsgears\cms\admin\services\BlockService;

class BlockController extends \cmsgears\core\admin\controllers\BaseController {

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
	                'index'  => ['get'],
	                'all'   => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post']
                ]
            ]
        ];
    }

	// BlockController -------------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = BlockService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model		= new Block();
		$banner	 	= new CmgFile();
		$video	 	= new CmgFile();
		$texture	= new CmgFile();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Block' ) && $model->validate() ) {

			$banner->load( Yii::$app->request->post(), 'Banner' );
			$video->load( Yii::$app->request->post(), 'Video' );
			$texture->load( Yii::$app->request->post(), 'Texture' );

			if( BlockService::create( $model, $banner, $video, $texture ) ) {

				// Create Content
				ContentService::create( $page, CmsGlobal::TYPE_PAGE, $content, $banner );

				// Bind Menus
				$binder = new Binder();

				$binder->binderId	= $model->id;
				$binder->load( Yii::$app->request->post(), 'Binder' );

				BlockService::bindMenus( $binder );

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
		$model		= BlockService::findById( $id );
		$banner 	= new CmgFile();

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Page' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
		    	$model->validate() && $content->validate() ) {

				$banner->load( Yii::$app->request->post(), 'File' );

				$page = BlockService::update( $model );
	
				if( isset( $page ) ) {

					// Update Content
					ContentService::update( $content, $page->isPublished(), $banner );

					// Bind Menus
					$binder = new Binder();

					$binder->binderId	= $model->id;
					$binder->load( Yii::$app->request->post(), 'Binder' );

					BlockService::bindMenus( $binder );

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
		$model	= BlockService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {
			
			$content	= $model->content;

			if( $model->load( Yii::$app->request->post(), 'Page' ) ) {

				if( BlockService::delete( $model ) ) {
					
					ContentService::delete( $content );

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