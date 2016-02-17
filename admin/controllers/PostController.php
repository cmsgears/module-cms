<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\forms\Binder;
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\Category;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\Post;
use cmsgears\cms\common\models\entities\ModelContent;

use cmsgears\cms\common\services\ModelContentService;
use cmsgears\core\admin\services\TemplateService;
use cmsgears\core\admin\services\CategoryService;
use cmsgears\cms\admin\services\PostService;

class PostController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'post' ];
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

	// PostController --------------------

	public function actionIndex() {

		return $this->redirect( [  'all' ] );
	}

	public function actionAll() {

		$dataProvider = PostService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new Post();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$content		= new ModelContent();
		$banner	 		= CmgFile::loadFile( null, 'Banner' );
		$video	 		= CmgFile::loadFile( null, 'Video' );

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Post' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
		    $model->validate() && $content->validate() ) {

			$post = PostService::create( $model );

			// Create Content
			ModelContentService::create( $post, CmsGlobal::TYPE_POST, $content, $post->isPublished(), $banner, $video );

			// Bind Categories
			$binder = new Binder();

			$binder->binderId	= $model->id;
			$binder->load( Yii::$app->request->post(), 'Binder' );

			PostService::bindCategories( $binder );

			return $this->redirect( [  'all' ] );
		}

		$visibilityMap	= Page::$visibilityMap;
		$statusMap		= Page::$statusMap;
		$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_POST, [ 'default' => true ] );

    	return $this->render( 'create', [
    		'model' => $model,
    		'content' => $content,
    		'banner' => $banner,
    		'video' => $video,
    		'visibilityMap' => $visibilityMap,
	    	'statusMap' => $statusMap,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= PostService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {
			
			$content	= $model->content;
			$banner	 	= CmgFile::loadFile( $content->banner, 'Banner' );
			$video	 	= CmgFile::loadFile( $content->video, 'Video' );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Post' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
		    	$model->validate() && $content->validate() ) {

				$post = PostService::update( $model );

				// Update Content
				ModelContentService::update( $content, $post->isPublished(), $banner, $video );

				// Bind Categories
				$binder = new Binder();

				$binder->binderId	= $model->id;
				$binder->load( Yii::$app->request->post(), 'Binder' );

				PostService::bindCategories( $binder );

				return $this->redirect( [  'all' ] );
			}

			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_POST, [ 'default' => true ] );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
	    		'video' => $video,
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
		$model	= PostService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;
			$banner		= $content->banner;
			$video		= $content->video;

			if( $model->load( Yii::$app->request->post(), 'Post' ) ) {
				
				// Delete Post
				PostService::delete( $model );
				
				// Delete Content
				ModelContentService::delete( $content, $banner, $video );

				return $this->redirect( [  'all' ] );
			}

			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_POST, [ 'default' => true ] );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
	    		'video' => $video,
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