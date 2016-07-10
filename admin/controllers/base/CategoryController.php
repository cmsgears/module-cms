<?php
namespace cmsgears\cms\admin\controllers\base;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;
use cmsgears\cms\common\models\resources\Category;
use cmsgears\cms\common\models\resources\ModelContent;

abstract class CategoryController extends \cmsgears\core\admin\controllers\base\CategoryController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $modelContentService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->viewPath				= '@cmsgears/module-cms/admin/views/category/';

		$this->crudPermission 		= CmsGlobal::PERM_CMS;

		$this->modelContentService	= Yii::$app->factory->get( 'modelContentService' );

		// Notes: Configure sidebar and returnUrl exclusively in child classes. We can also change type and templateType in child classes.
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CategoryController --------------------

	public function actionAll() {

		$dataProvider = $this->modelService->getPageByType( $this->type );

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->type 	= $this->type;
		$model->siteId	= Yii::$app->core->siteId;
		$content		= new ModelContent();
		$banner	 		= File::loadFile( null, 'Banner' );
		$video	 		= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			$category = $this->modelService->create( $model );

			$this->modelContentService->create( $content, [ 'parent' => $category, 'parentType' => CoreGlobal::TYPE_CATEGORY, 'publish' => true, 'banner' => $banner, 'video' => $video ] );

			return $this->redirect( $this->returnUrl );
		}

		$categoryMap	= $this->modelService->getIdNameMapByType( $this->type, [ 'prepend' => [ [ 'name' => 'Choose Category', 'id' => 0 ] ] ] );
		$templatesMap	= $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

    	return $this->render( 'create', [
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
		$model	= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->modelContent;
			$banner	 	= File::loadFile( $content->banner, 'Banner' );
			$video	 	= File::loadFile( $content->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$category = $this->modelService->update( $model );

				$this->modelContentService->update( $content, [ 'publish' => true, 'banner' => $banner, 'video' => $video ] );

				return $this->redirect( $this->returnUrl );
			}

			$categoryMap	= $this->modelService->getIdNameMapByType( $this->type, [
									'prepend' => [ [ 'name' => 'Choose Category', 'id' => 0 ] ],
									'filters' => [ [ 'not in', 'id', [ $id ] ] ]
								]);

			$templatesMap	= $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'categoryMap' => $categoryMap,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content		= $model->modelContent;

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				$this->modelContentService->delete( $content );

				return $this->redirect( $this->returnUrl );
			}

			$categoryMap	= $this->modelService->getIdNameMapByType( $this->type, [ 'prepend' => [ [ 'name' => 'Choose Category', 'id' => 0 ] ] ] );
			$templatesMap	= $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $content->banner,
	    		'video' => $content->video,
	    		'categoryMap' => $categoryMap,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
