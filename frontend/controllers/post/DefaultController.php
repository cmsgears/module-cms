<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\frontend\controllers\post;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;

/**
 * DefaultController provide actions specific to blog post management.
 *
 * @since 1.0.0
 */
class DefaultController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $basePath;

	public $metaService;

	// Protected --------------

	protected $templateService;

	protected $modelContentService;

	protected $elementService;
	protected $blockService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CoreGlobal::PERM_USER;

		// Config
		$this->apixBase	= 'cms/post';
		$this->basePath	= 'post/default';

		// Services
		$this->modelService = Yii::$app->factory->get( 'postService' );
		$this->metaService	= Yii::$app->factory->get( 'pageMetaService' );

		$this->templateService = Yii::$app->factory->get( 'templateService' );

		$this->modelContentService = Yii::$app->factory->get( 'modelContentService' );

		$this->elementService	= Yii::$app->factory->get( 'elementService' );
		$this->blockService		= Yii::$app->factory->get( 'blockService' );

		// Return Url
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/default/all' ], true );
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
					'home' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'add' => [ 'permission' => $this->crudPermission ],
					'basic' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'media' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'elements' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'blocks' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'attributes' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'settings' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ],
					'review' => [ 'permission' => $this->crudPermission, 'filters' => [ 'discover', 'owner' ] ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'index' => [ 'get' ],
					'home' => [ 'get' ],
					'add' => [ 'get', 'post' ],
					'basic' => [ 'get', 'post' ],
					'media' => [ 'get', 'post' ],
					'elements' => [ 'get' ],
					'blocks' => [ 'get' ],
					'attributes' => [ 'get' ],
					'settings' => [ 'get', 'post' ],
					'review' => [ 'get', 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// DefaultController ---------------------

	public function actionHome( $slug ) {

		$model = $this->model;

		return $this->checkStatus( $model );
	}

	public function actionAdd( $template = CoreGlobal::TEMPLATE_DEFAULT ) {

		$template	= $this->templateService->getBySlugType( $template, CmsGlobal::TYPE_POST, [ 'ignoreSite' => true ] );
		$modelClass	= $this->modelService->getModelClass();

		if( isset( $template ) ) {

			$model = new $modelClass;

			// Post
			$model->siteId		= Yii::$app->core->siteId;
			$model->visibility	= $modelClass::VISIBILITY_PUBLIC;
			$model->status		= $modelClass::STATUS_NEW;
			$model->type		= CmsGlobal::TYPE_POST;
			$model->comments	= false;

			// Content
			$content = $this->modelContentService->getModelObject();

			$content->templateId = $template->id;

			// Files
			$avatar	= File::loadFile( null, 'Avatar' );
			$banner	= File::loadFile( null, 'Banner' );
			$video	= File::loadFile( null, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				// Register Model
				$model = $this->modelService->register( $model, [
					'content' => $content,
					'avatar' => $avatar, 'banner' => $banner, 'video' => $video
				]);

				// Refresh Model
				$model->refresh();

				// Set model in action to cache
				$this->model = $model;

				return $this->updateStatus( $model, $modelClass::STATUS_BASIC );
			}

			return $this->render( 'add', [
				'model' => $model,
				'content' => $content,
				'avatar' => $avatar,
				'banner' => $banner,
				'video' => $video,
				'visibilityMap' => $modelClass::$visibilityMap
			]);
		}

		// Template not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

	public function actionBasic( $slug ) {

		$modelClass = $this->modelService->getModelClass();

		// Model
		$model = $this->model;

		$this->checkEditable( $model );

		// Content
		$content = $model->modelContent;

		// Files
		$avatar	= File::loadFile( null, 'Avatar' );
		$banner	= File::loadFile( null, 'Banner' );
		$video	= File::loadFile( null, 'Video' );

		$oldSlug = $model->slug;

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			// Register Model
			$model = $this->modelService->update( $model, [
				'content' => $content,
				'avatar' => $avatar, 'banner' => $banner, 'video' => $video
			]);

			// Refresh Model
			$model->refresh();

			// Set model in action to cache
			$this->model = $model;

			if( $oldSlug == $model->slug ) {

				return $this->refresh();
			}
			else {

				return $this->redirect( [ 'basic?slug=' . $model->slug ] );
			}
		}

		return $this->render( 'basic', [
			'model' => $model,
			'content' => $content,
			'avatar' => $avatar,
			'banner' => $banner,
			'video' => $video,
			'visibilityMap' => $modelClass::$visibilityMap
		]);
	}

	public function actionMedia( $slug ) {

		$modelClass = $this->modelService->getModelClass();

		$model = $this->model;

		$this->checkEditable( $model );

		$content = $model->modelContent;

		$avatar	 = File::loadFile( $model->avatar, 'Avatar' );
		$banner	 = File::loadFile( $content->banner, 'Banner' );
		$video	 = File::loadFile( $content->video, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

			$this->model = $this->modelService->update( $model, [
				'content' => $content, 'avatar' => $avatar,
				'banner' => $banner, 'video' => $video
			]);

			$this->model->refresh();

			if( $this->model->status >= $modelClass::STATUS_MEDIA ) {

				return $this->refresh();
			}
			else {

				return $this->updateStatus( $model, $modelClass::STATUS_MEDIA );
			}
		}

		return $this->render( 'media', [
			'model' => $model,
			'content' => $content,
			'avatar' => $avatar,
			'banner' => $banner,
			'video' => $video,
			'gallery' => $content->gallery
		]);
	}

	public function actionElements( $slug ) {

		$modelClass = $this->modelService->getModelClass();

		$model = $this->model;

		$this->checkEditable( $model );

		$elements = $model->modelElements;

		if( $model->status < $modelClass::STATUS_ELEMENTS ) {

			$this->modelService->updateStatus( $model, $modelClass::STATUS_ELEMENTS );
		}

		return $this->render( 'elements', [
			'model' => $model,
			'elements' => $elements
		]);
	}

	public function actionBlocks( $slug ) {

		Url::remember( Yii::$app->request->getUrl(), 'blocks' );

		$modelClass = $this->modelService->getModelClass();

		$model		= $this->model;
		$parentType	= $this->modelService->getParentType();

		$this->checkEditable( $model );

		$dataProvider = $this->blockService->getPageByTypeParent( CmsGlobal::TYPE_BLOCK, $model->id, $parentType );

		if( $model->status < $modelClass::STATUS_BLOCKS ) {

			$this->modelService->updateStatus( $model, $modelClass::STATUS_BLOCKS );
		}

		return $this->render( 'blocks', [
			'model' => $model,
			'parentType' => $parentType,
			'dataProvider' => $dataProvider
		]);
	}

	public function actionAttributes( $slug ) {

		$modelClass = $this->modelService->getModelClass();

		$model = $this->model;

		$this->checkEditable( $model );

		$metas = $this->metaService->getByType( $model->id, CoreGlobal::META_TYPE_USER );

		if( $model->status < $modelClass::STATUS_ATTRIBUTES ) {

			$this->modelService->updateStatus( $model, $modelClass::STATUS_ATTRIBUTES );
		}

		return $this->render( 'attributes', [
			'model' => $model,
			'attributes' => $metas
		]);
	}

	public function actionSettings( $slug ) {

		$modelClass = $this->modelService->getModelClass();

		$model = $this->model;

		$parentType	= $this->modelService->getParentType();

		$this->checkEditable( $model );

		if( $model->status < $modelClass::STATUS_SETTINGS ) {

			$this->modelService->updateStatus( $model, $modelClass::STATUS_SETTINGS );
		}

		return $this->render( 'settings', [
			'model' => $model,
			'parentType' => $parentType
		]);
	}

	public function actionReview( $slug ) {

		$model = $this->model;

		$modelClass = $this->modelService->getModelClass();

		if( isset( $model ) ) {

			if( $model->status < $modelClass::STATUS_REVIEW ) {

				$this->modelService->updateStatus( $model, $modelClass::STATUS_REVIEW );
			}

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

				// Submit
				if( $model->status < $modelClass::STATUS_SUBMITTED ) {

					$this->modelService->submit( $model, [
						'adminLink' => "/cms/post/review?id={$model->id}"
					]);
				}
				// Re-Submit
				else if( $model->isRejected() ) {

					$this->modelService->reSubmit( $model, [
						'adminLink' => "/cms/post//review?id={$model->id}"
					]);
				}
				// Activation Request
				else if( $model->isFrojen() || $model->isBlocked() ) {

					//Yii::$app->orgMailer->sendActivationRequestMail( $model );

					if( $model->isFrojen() ) {

						$this->modelService->upliftFreeze( $model, [
							'adminLink' => "/cms/post//review?id={$model->id}"
						]);
					}

					if( $model->isBlocked() ) {

						$this->modelService->upliftBlock( $model, [
							'adminLink' => "/cms/post//review?id={$model->id}"
						]);
					}
				}

				return $this->refresh();
			}

			$content	= $model->modelContent;
			$template	= $content->template;

			if( isset( $template ) ) {

				$this->view->params[ 'model' ] = $model;

				return Yii::$app->templateManager->renderViewAdmin( $template, [
					'model' => $model,
					'metaService' => $this->metaService,
					'content' => $content,
					'userReview' => true,
					'adminReview' => false,
					'frontend' => true
				]);
			}

			// Template not found
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	// State Handling ---------

	protected function checkStatus( $model ) {

		$modelClass = $this->modelService->getModelClass();

		switch( $model->status ) {

			case $modelClass::STATUS_NEW: {

				return $this->redirect( [ "$this->basePath/basic?slug=$model->slug" ] );
			}
			case $modelClass::STATUS_BASIC: {

				return $this->redirect( [ "$this->basePath/media?slug=$model->slug" ] );
			}
			case $modelClass::STATUS_MEDIA: {

				return $this->redirect( [ "$this->basePath/attributes?slug=$model->slug" ] );
			}
			case $modelClass::STATUS_ATTRIBUTES: {

				return $this->redirect( [ "$this->basePath/settings?slug=$model->slug" ] );
			}
			case $modelClass::STATUS_SETTINGS: {

				return $this->redirect( [ "$this->basePath/review?slug=$model->slug" ] );
			}
			case $modelClass::STATUS_REJECTED: {

				return $this->redirect( [ "$this->basePath/review?slug=$model->slug" ] );
			}
			case $modelClass::STATUS_RE_SUBMIT: {

				return $this->redirect( [ "$this->basePath/review?slug=$model->slug" ] );
			}
			default: {

				return $this->redirect( [ "$this->basePath/basic?slug=$model->slug" ] );
			}
		}
	}

	/**
	 * Check whether model is under review. It will disable the registration tabs if status is new.
	 */
	protected function checkEditable( $model ) {

		if( !$model->isEditable() ) {

			Yii::$app->getResponse()->redirect( [ "$this->basePath/review?slug=$model->slug" ] )->send();
		}
	}

	/**
	 * Check whether item is being registered and redirect user to the last step filled by user.
	 */
	protected function checkRefresh( $model ) {

		if( $model->isRegistration() ) {

			return $this->checkStatus( $model );
		}

		return $this->refresh();
	}

	/**
	 * Update item status and redirect to the last step filled by user.
	 */
	protected function updateStatus( $model, $status ) {

		// Update Item Status
		$this->modelService->updateStatus( $model, $status );

		return $this->checkStatus( $model );
	}

}
