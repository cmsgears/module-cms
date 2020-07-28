<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\base;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;
use cmsgears\cms\common\models\resources\ModelContent;

/**
 * CategoryController is base controller for actions specific to category model.
 *
 * @since 1.0.0
 */
abstract class CategoryController extends \cmsgears\core\admin\controllers\base\CategoryController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $parentPath;

	// Protected --------------

	protected $templateType;

	protected $templateService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->viewPath = '@cmsgears/module-cms/admin/views/category/';

		// Config
		$this->templateType = CoreGlobal::TYPE_CATEGORY;

		// Permission
		$this->crudPermission = CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->templateService = Yii::$app->factory->get( 'templateService' );

		// Notes: Configure sidebar and returnUrl exclusively in child classes. We can also change type and templateType in child classes.
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		$behaviors = parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'gallery' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'data' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'attributes' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'config' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'settings' ] = [ 'permission' => $this->crudPermission ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'gallery' ] = [ 'get' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'data' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'attributes' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'config' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'settings' ] = [ 'get', 'post' ];

		return $behaviors;
	}

	// yii\base\Controller ----

	public function actions() {

		$actions = parent::actions();

		$actions[ 'gallery' ] = [ 'class' => 'cmsgears\cms\common\actions\regular\gallery\Browse' ];
		$actions[ 'data' ] = [ 'class' => 'cmsgears\cms\common\actions\data\data\Form' ];
		$actions[ 'attributes' ] = [ 'class' => 'cmsgears\cms\common\actions\data\attribute\Form' ];
		$actions[ 'config' ] = [ 'class' => 'cmsgears\cms\common\actions\data\config\Form' ];
		$actions[ 'settings' ] = [ 'class' => 'cmsgears\cms\common\actions\data\setting\Form' ];

		return $actions;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CategoryController --------------------

	public function actionCreate( $config = [] ) {

		$model = $this->modelService->getModelObject();

		$model->type = $this->type;

		$content	= new ModelContent();
		$banner		= File::loadFile( null, 'Banner' );
		$video		= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			$this->model = $this->modelService->create( $model, [ 'admin' => true, 'content' => $content, 'banner' => $banner, 'video' => $video ] );

			return $this->redirect( 'all' );
		}

		$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'content' => $content,
			'banner' => $banner,
			'video' => $video,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id, $config = [] ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->modelContent;
			$template	= $content->template;

			$banner	= File::loadFile( $content->banner, 'Banner' );
			$video	= File::loadFile( $content->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->model = $this->modelService->update( $model, [
					'admin' => true, 'content' => $content, 'oldTemplate' => $template,
					'banner' => $banner, 'video' => $video
				]);

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

			return $this->render( 'update', [
				'model' => $model,
				'content' => $content,
				'banner' => $banner,
				'video' => $video,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id, $config = [] ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content = $model->modelContent;

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->model = $model;

				$this->modelService->delete( $model, [ 'admin' => true, 'content' => $content ] );

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'content' => $content,
				'banner' => $content->banner,
				'video' => $content->video,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
