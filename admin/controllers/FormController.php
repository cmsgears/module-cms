<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers;

// Yii Imports
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\common\models\resources\File;
use cmsgears\cms\admin\models\forms\FormSettingsForm;

use cmsgears\core\admin\controllers\base\CrudController;

use cmsgears\core\common\behaviors\ActivityBehavior;

/**
 * FormController provides actions specific to form model.
 *
 * @since 1.0.0
 */
class FormController extends CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $type;
	protected $templateType;

	protected $templateService;
	protected $modelContentService;

	protected $settingsClass;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-cms/admin/views/form' );

		// Permission
		$this->crudPermission = FormsGlobal::PERM_FORM_ADMIN;

		// Config
		$this->type			= CoreGlobal::TYPE_FORM;
		$this->templateType	= CoreGlobal::TYPE_FORM;
		$this->apixBase		= 'cms/form';

		$this->settingsClass = FormSettingsForm::class;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'formService' );
		$this->templateService	= Yii::$app->factory->get( 'templateService' );

		$this->modelContentService	= Yii::$app->factory->get( 'modelContentService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		// Return Url
		$this->returnUrl = Url::previous( 'forms' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/form/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'all' => [ [ 'label' => 'Forms' ] ],
			'create' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'settings' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		$behaviors = parent::behaviors();

		$behaviors[ 'activity' ] = [
			'class' => ActivityBehavior::class,
			'admin' => true,
			'create' => [ 'create' ],
			'update' => [ 'update' ],
			'delete' => [ 'delete' ]
		];

		return $behaviors;
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageController ------------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'forms' );

		$modelClass = $this->modelService->getModelClass();

		$dataProvider = $this->modelService->getPageByType( $this->type );

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'visibilityMap' => $modelClass::$visibilityMap,
			'statusMap' => $modelClass::$statusMap
		]);
	}

	public function actionCreate( $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		$model = new $modelClass;

		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= $this->type;

		$content = $this->modelContentService->getModelObject();

		$banner	= File::loadFile( null, 'Banner' );
		$video	= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			$this->model = $this->modelService->add( $model, [
				'admin' => true, 'content' => $content, 'publish' => $model->isActive(),
				'banner' => $banner, 'video' => $video
			]);

			return $this->redirect( 'all' );
		}

		$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'content' => $content,
			'banner' => $banner,
			'video' => $video,
			'visibilityMap' => $modelClass::$visibilityMap,
			'statusMap' => $modelClass::$statusMap,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id, $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content = $model->modelContent;

			$banner	= File::loadFile( $content->banner, 'Banner' );
			$video	= File::loadFile( $content->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->model = $this->modelService->update( $model, [
					'admin' => true, 'content' => $content, 'publish' => $model->isActive(),
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
				'visibilityMap' => $modelClass::$visibilityMap,
				'statusMap' => $modelClass::$statusMap,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSettings( $id ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$settingsClass	= $this->settingsClass;
			$settings		= new $settingsClass( $model->getDataMeta( 'settings' ) );

			if( $settings->load( Yii::$app->request->post(), $settings->getClassName() ) && $settings->validate() ) {

				$this->model = $this->modelService->updateDataMeta( $model, 'settings', $settings );

				return $this->redirect( $this->returnUrl );
			}

			return $this->render( 'settings', [
				'model' => $model,
				'settings' => $settings
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id, $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		// Find Model
		$model = $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content = $model->modelContent;

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				try {

					$this->model = $model;

					$this->modelService->delete( $model, [ 'admin' => true ] );

					return $this->redirect( $this->returnUrl );
				}
				catch( Exception $e ) {

					throw new HttpException( 409, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_DEPENDENCY )  );
				}
			}

			$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'content' => $content,
				'banner' => $content->banner,
				'video' => $content->video,
				'visibilityMap' => $modelClass::$visibilityMap,
				'statusMap' => $modelClass::$statusMap,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
