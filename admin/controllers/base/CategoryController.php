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

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\Category;
use cmsgears\cms\common\models\entities\ModelContent;

use cmsgears\core\admin\services\CategoryService;
use cmsgears\cms\common\services\ModelContentService;
use cmsgears\core\admin\services\TemplateService;

abstract class CategoryController extends \cmsgears\core\admin\controllers\base\CategoryController {

	protected $templateType;
	
	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {
		
		$behaviors	= parent::behaviors();
		
		$behaviors[ 'rbac' ][ 'actions' ] = [
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

	public function actionCreate( $type ) {

		$model			= new Category();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$model->type 	= $type;

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Category' )  && $model->validate() ) {

			if( CategoryService::create( $model ) ) { 

				return $this->redirect( $this->returnUrl );
			} 
		} 
		
		$categoryMap	= CategoryService::getIdNameMapByType( $type, [ 'prepend' => [ [ 'value' => 'Choose Category', 'name' => 0 ] ] ] );

    	return $this->render( '@cmsgears/module-cms/admin/views/category/create', [
    		'model' => $model,
    		'categoryMap' => $categoryMap
    	]);
	}	
 	
	public function actionUpdate( $id, $type ) {
		
		// Find Model
		$model	= CategoryService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->type 	= $type; 
			$banner 		= CmgFile::loadFile( $model->banner, 'Banner' );
			$video	 		= CmgFile::loadFile( $model->video, 'Video' );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Category' )  && $model->validate() ) {

				if( CategoryService::update( $model, $banner, $video ) ) {

					return $this->redirect( $this->returnUrl );
				}
			}

			$categoryMap	= CategoryService::getIdNameMapByType( $type, [
									'prepend' => [ [ 'value' => 'Choose Category', 'name' => 0 ] ],
									'filters' => [ [ 'not in', 'id', [ $id ] ] ]
								]);

	    	return $this->render( '@cmsgears/module-cms/admin/views/category/update', [
	    		'model' => $model, 
	    		'banner' => $banner,
				'video' => $video,
	    		'categoryMap' => $categoryMap
	    	]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id, $type ) {

		// Find Model
		$model	= CategoryService::findById( $id );

		// Delete/Render if exist		
		if( isset( $model ) ) {

			$banner = $model->banner;
			$video 	= $model->video;

			if( $model->load( Yii::$app->request->post(), 'Category' )  && $model->validate() ) {

				if( CategoryService::delete( $model, $banner, $video ) ) {

					return $this->redirect( $this->returnUrl );
				}
			}

			$categoryMap	= CategoryService::getIdNameMapByType( $type, [ 'prepend' => [ [ 'value' => 'Choose Category', 'name' => 0 ] ] ] );

	    	return $this->render( '@cmsgears/module-cms/admin/views/category/delete', [
	    		'model' => $model, 
	    		'banner' => $banner,
				'video' => $video,
	    		'categoryMap' => $categoryMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>