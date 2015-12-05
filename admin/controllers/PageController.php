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

use cmsgears\cms\common\services\ModelContentService;
use cmsgears\core\admin\services\TemplateService;
use cmsgears\cms\admin\services\PageService;

class PageController extends \cmsgears\core\admin\controllers\BaseController {

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

	// PageController --------------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = PageService::getPaginationForSite();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new Page();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$content		= new ModelContent();
		$banner	 		= CmgFile::loadFile( null, 'File' );

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Page' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
		    $model->validate() && $content->validate() ) {

			$page = PageService::create( $model );

			if( isset( $page ) ) {

				// Create Content
				ModelContentService::create( $page, CmsGlobal::TYPE_PAGE, $content, $banner );

				$this->redirect( [ 'all' ] );
			}
		}

		$visibilityMap	= Page::$visibilityMap;
		$statusMap		= Page::$statusMap;
		$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_PAGE );

    	return $this->render( 'create', [
    		'model' => $model,
    		'content' => $content,
    		'banner' => $banner,
    		'visibilityMap' => $visibilityMap,
	    	'statusMap' => $statusMap,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= PageService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;
			$banner	 	= CmgFile::loadFile( $content->banner, 'File' );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Page' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
		    	$model->validate() && $content->validate() ) {

				$page = PageService::update( $model );
	
				if( isset( $page ) ) {

					// Update Content
					ModelContentService::update( $content, $page->isPublished(), $banner );

					$this->redirect( [ 'all' ] );
				}
			}

			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_PAGE );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
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

				if( PageService::delete( $model ) ) {
					
					ModelContentService::delete( $content );

					$this->redirect( [ 'all' ] );
				}
			}

			$banner			= $content->banner;
			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_PAGE );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
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