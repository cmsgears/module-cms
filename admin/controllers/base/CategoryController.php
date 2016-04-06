<?php
namespace cmsgears\cms\admin\controllers\base;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\CmgFile;
use cmsgears\cms\common\models\resources\Category;
use cmsgears\cms\common\models\mappers\ModelContent;

use cmsgears\core\admin\services\entities\TemplateService;
use cmsgears\cms\admin\services\resources\CategoryService;
use cmsgears\cms\common\services\mappers\ModelContentService;

abstract class CategoryController extends \cmsgears\core\admin\controllers\base\CategoryController {

	protected $templateType;

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->type			= CmsGlobal::TYPE_POST;
		$this->templateType	= CmsGlobal::TYPE_POST;
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {

		$behaviors	= parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ] = [
								                'index'  => [ 'permission' => CmsGlobal::PERM_CMS ],
								                'all'  => [ 'permission' => CmsGlobal::PERM_CMS ],
								                'create'  => [ 'permission' => CmsGlobal::PERM_CMS ],
								                'update'  => [ 'permission' => CmsGlobal::PERM_CMS ],
								                'delete'  => [ 'permission' => CmsGlobal::PERM_CMS ],
							                ];

		return $behaviors;
    }

	// CategoryController -----------------

	public function actionAll() {

		$dataProvider = CategoryService::getPaginationByType( $this->type );

	    return $this->render( '@cmsgears/module-core/admin/views/category/all', [
			'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new Category();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$model->type 	= $this->type;
		$content		= new ModelContent();
		$banner	 		= CmgFile::loadFile( null, 'Banner' );
		$video	 		= CmgFile::loadFile( null, 'Video' );

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Category' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
		    $model->validate() && $content->validate() ) {

			// Create Category
			$category = CategoryService::create( $model );

			// Create Content
			ModelContentService::create( $category, CoreGlobal::TYPE_CATEGORY, $content, true, $banner, $video );

			return $this->redirect( $this->returnUrl );
		}

		$categoryMap	= CategoryService::getIdNameMapByType( $this->type, [ 'prepend' => [ [ 'value' => 'Choose Category', 'name' => 0 ] ] ] );
		$templatesMap	= TemplateService::getIdNameMapByType( $this->templateType, [ 'default' => true ] );

    	return $this->render( '@cmsgears/module-cms/admin/views/category/create', [
    		'model' => $model,
    		'content' => $content,
    		'banner' => $banner,
    		'video' => $video,
    		'categoryMap' => $categoryMap,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model	= CategoryService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;
			$banner	 	= CmgFile::loadFile( $content->banner, 'Banner' );
			$video	 	= CmgFile::loadFile( $content->video, 'Video' );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Category' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
			    $model->validate() && $content->validate() ) {

				// Update Category
				CategoryService::update( $model, $banner, $video );

				// Update Content
				ModelContentService::update( $content, true, $banner, $video );

				return $this->redirect( $this->returnUrl );
			}

			$categoryMap	= CategoryService::getIdNameMapByType( $this->type, [
									'prepend' => [ [ 'value' => 'Choose Category', 'name' => 0 ] ],
									'filters' => [ [ 'not in', 'id', [ $id ] ] ]
								]);
			$templatesMap	= TemplateService::getIdNameMapByType( $this->templateType, [ 'default' => true ] );

	    	return $this->render( '@cmsgears/module-cms/admin/views/category/update', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'categoryMap' => $categoryMap,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= CategoryService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;
			$banner 	= $content->banner;
			$video 		= $content->video;

			if( $model->load( Yii::$app->request->post(), 'Category' )  && $model->validate() ) {

				// Delete Category
				CategoryService::delete( $model );

				// Delete Content
				ModelContentService::delete( $content, $banner, $video );

				return $this->redirect( $this->returnUrl );
			}

			$categoryMap	= CategoryService::getIdNameMapByType( $this->type, [
									'prepend' => [ [ 'value' => 'Choose Category', 'name' => 0 ] ],
									'filters' => [ [ 'not in', 'id', [ $id ] ] ]
								]);
			$templatesMap	= TemplateService::getIdNameMapByType( $this->templateType, [ 'default' => true ] );

	    	return $this->render( '@cmsgears/module-cms/admin/views/category/delete', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'categoryMap' => $categoryMap,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>