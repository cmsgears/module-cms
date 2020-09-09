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
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

/**
 * PostController provides actions specific to post model.
 *
 * @since 1.0.0
 */
class PostController extends \cmsgears\cms\admin\controllers\base\PageController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $prettyReview;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-cms/admin/views/post' );

		// Config
		$this->type			= CmsGlobal::TYPE_POST;
		$this->templateType	= CmsGlobal::TYPE_POST;
		$this->title		= 'Post';
		$this->baseUrl		= 'post';
		$this->apixBase		= 'cms/post';
		$this->comments		= true;
		$this->prettyReview	= false;

		// Services
		$this->modelService = Yii::$app->factory->get( 'postService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-cms', 'child' => 'post' ];

		// Return Url
		$this->returnUrl = Url::previous( 'posts' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Posts' ] ],
			'create' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'review' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Review' ] ],
			'gallery' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Gallery' ] ],
			'data' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Data' ] ],
			'attributes' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Attributes' ] ],
			'config' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Config' ] ],
			'settings' => [ [ 'label' => 'Posts', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		$behaviors = parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'review' ] = [ 'permission' => $this->crudPermission ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'review' ] = [ 'get', 'post' ];

		return $behaviors;
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'posts' );

		return parent::actionAll( $config );
	}

	public function actionReview( $id ) {

		$modelClass = $this->modelService->getModelClass();

		$model = $this->modelService->getById( $id );

		// Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$status		= Yii::$app->request->post( 'status' );
				$email		= $this->modelService->getEmail( $model );
				$message	= Yii::$app->request->post( 'message' );

				switch( $status ) {

					case $modelClass::STATUS_APPROVED: {

						$this->modelService->approve( $model, [ 'notify' => false ] );

						$this->modelContentService->publish( $model->modelContent );

						Yii::$app->coreMailer->sendApproveMail( $model, $email, $message );

						break;
					}
					case $modelClass::STATUS_REJECTED: {

						$model->setRejectMessage( $message );
						$model->refresh();

						$this->modelService->reject( $model, [ 'notify' => false ] );

						Yii::$app->coreMailer->sendRejectMail( $model, $email, $message );

						break;
					}
					case $modelClass::STATUS_FROJEN: {

						$model->setRejectMessage( $message );
						$model->refresh();

						$this->modelService->freeze( $model, [ 'notify' => false ] );

						Yii::$app->coreMailer->sendFreezeMail( $model, $email, $message );

						break;
					}
					case $modelClass::STATUS_BLOCKED: {

						$model->setRejectMessage( $message );
						$model->refresh();

						$this->modelService->block( $model, [ 'notify' => false ] );

						Yii::$app->coreMailer->sendBlockMail( $model, $email, $message );

						break;
					}
					case $modelClass::STATUS_ACTIVE: {

						$this->modelService->activate( $model, [ 'notify' => false ] );

						$model->updateDataMeta( CoreGlobal::DATA_APPROVAL_REQUEST, false );

						Yii::$app->coreMailer->sendActivateMail( $model, $email );
					}
				}

				$this->redirect( $this->returnUrl );
			}

			$content	= $model->modelContent;
			$template	= $content->template;

			if( $this->prettyReview && isset( $template ) ) {

				return Yii::$app->templateManager->renderViewAdmin( $template, [
					'model' => $model,
					'content' => $content,
					'userReview' => false
				], [ 'layout' => false ] );
			}
			else {

				$templatesMap = $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_POST, [ 'default' => true ] );

				return $this->render( 'review', [
					'modelService' => $this->modelService,
					'metaService' => $this->metaService,
					'model' => $model,
					'content' => $content,
					'avatar' => $model->avatar,
					'banner' => $content->banner,
					'mbanner' => $content->mobileBanner,
					'video' => $content->video,
					'mvideo' => $content->mobileVideo,
					'visibilityMap' => $modelClass::$visibilityMap,
					'statusMap' => $modelClass::$statusMap,
					'templatesMap' => $templatesMap
				]);
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
