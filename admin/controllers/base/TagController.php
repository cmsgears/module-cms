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

use cmsgears\core\admin\controllers\base\TagController as BaseTagController;

/**
 * TagController provides actions specific to tag model.
 *
 * @since 1.0.0
 */
abstract class TagController extends BaseTagController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateType;

	protected $templateService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->viewPath = '@cmsgears/module-cms/admin/views/tag/';

		// Config
		$this->templateType = CoreGlobal::TYPE_TAG;

		// Permission
		$this->crudPermission = CmsGlobal::PERM_BLOG_ADMIN;

		$this->templateService = Yii::$app->factory->get( 'templateService' );

		// Notes: Configure sidebar and returnUrl exclusively in child classes. We can also change type and templateType in child classes.
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TagController -------------------------

	public function actionCreate( $config = [] ) {

		$model = $this->modelService->getModelObject();

		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= $this->type;

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
		$model	= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->modelContent;
			$banner		= File::loadFile( $content->banner, 'Banner' );
			$video		= File::loadFile( $content->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->model = $this->modelService->update( $model, [ 'admin' => true, 'content' => $content, 'banner' => $banner, 'video' => $video ] );

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
		$model	= $this->modelService->getById( $id );

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
