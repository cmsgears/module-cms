<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\frontend\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;

/**
 * ElementController consist of actions specific to page elements.
 *
 * @since 1.0.0
 */
class ElementController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;

	protected $modelElementService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CoreGlobal::PERM_USER;

		// Config
		$this->apixBase	= 'cms/element';

		// Services
		$this->modelService = Yii::$app->factory->get( 'elementService' );

		$this->templateService = Yii::$app->factory->get( 'templateService' );

		$this->modelElementService = Yii::$app->factory->get( 'modelElementService' );

		// Return Url
		$this->returnUrl = Url::previous( 'elements' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/element/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		return [
			'rbac' => [
				'class' => Yii::$app->core->getRbacFilterClass(),
				'actions' => [
					'index' => [ 'permission' => $this->crudPermission ],
					'all' => [ 'permission' => $this->crudPermission ],
					'add' => [ 'permission' => $this->crudPermission ],
					'update' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'index' => [ 'get' ],
					'all' => [ 'get' ],
					'add' => [ 'get', 'post' ],
					'update' => [ 'get', 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ElementController -----------------------

	public function actionAll( $status = null ) {

		Url::remember( Yii::$app->request->getUrl(), 'elements' );

		$modelClass = $this->modelService->getModelClass();

		$user = Yii::$app->core->getUser();

		$dataProvider = null;

		if( isset( $status ) ) {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id, [ 'status' => Post::$urlRevStatusMap[ $status ] ] );
		}
		else {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id );
		}

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'statusMap' => $modelClass::$statusMap,
			'status' => $status
		]);
	}

    public function actionAdd( $pid = null, $ptype = null, $template = CoreGlobal::TEMPLATE_DEFAULT ) {

		$template	= $this->templateService->getBySlugType( $template, CmsGlobal::TYPE_ELEMENT, [ 'ignoreSite' => true ] );
		$modelClass	= $this->modelService->getModelClass();

		if( isset( $template ) ) {

			$model = new $modelClass;

			// Element
			$model->siteId		= Yii::$app->core->siteId;
			$model->visibility	= $modelClass::VISIBILITY_PUBLIC;
			$model->status		= $modelClass::STATUS_NEW;
			$model->type		= CmsGlobal::TYPE_ELEMENT;
			$model->templateId	= $template->id;

			// Files
			$avatar	= File::loadFile( null, 'Avatar' );
			$banner	= File::loadFile( null, 'Banner' );
			$video	= File::loadFile( null, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

				// Register Model
				$model = $this->modelService->register( $model, [
					'avatar' => $avatar, 'banner' => $banner, 'video' => $video, 'addGallery' => true
				]);

				// Refresh Model
				$model->refresh();

				// Set model in action to cache
				$this->model = $model;

				return $this->redirect( $this->returnUrl );
			}

			return $this->render( 'add', [
				'model' => $model,
				'avatar' => $avatar,
				'banner' => $banner,
				'video' => $video,
				'statusMap' => $modelClass::$baseStatusMap
			]);
		}

		// Template not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

	public function actionUpdate( $id ) {

		$modelClass = $this->modelService->getModelClass();

		// Model
		$model = $this->model;

		// Files
		$avatar	= File::loadFile( null, 'Avatar' );
		$banner	= File::loadFile( null, 'Banner' );
		$video	= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

			// Register Model
			$model = $this->modelService->update( $model, [
				'admin' => true, 'avatar' => $avatar, 'banner' => $banner, 'video' => $video
			]);

			// Refresh Model
			$model->refresh();

			// Set model in action to cache
			$this->model = $model;

			return $this->redirect( $this->returnUrl );
		}

		return $this->render( 'update', [
			'model' => $model,
			'avatar' => $avatar,
			'banner' => $banner,
			'video' => $video,
			'statusMap' => $modelClass::$baseStatusMap
		]);
	}

}
