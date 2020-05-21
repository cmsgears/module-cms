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
use yii\web\UnauthorizedHttpException;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\CoreGlobalWeb;

use cmsgears\forms\common\models\forms\GenericForm;

/**
 * FormController provides actions specific to form model.
 *
 * @since 1.0.0
 */
class FormController extends \cmsgears\forms\frontend\controllers\FormController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->modelService = Yii::$app->factory->get( 'formService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FormController ------------------------

    public function actionSingle( $slug ) {

		$model = $this->modelService->getBySlugType( $slug, CoreGlobal::TYPE_FORM );

		if( isset( $model ) ) {

			$this->model = $model;

			// Find Template
			$content	= $model->modelContent;
			$template	= $content->template;

			// Fields
			$formFields	= $model->getFieldsMap();

	 		$form	= new GenericForm( [ 'fields' => $formFields ] );
			$user	= Yii::$app->core->getUser();

			$form->captchaAction = '/cms/form/captcha';

			// View Params
			$data = json_decode( $model->data );

			$this->view->params[ 'model' ]		= $model;
			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];

			// Form need a valid user
			if( !$model->isVisibilityPublic() ) {

				// Form need it's owner
				if( $model->isVisibilityPrivate() && !$model->isOwner( $user ) ) {

					// Error- Not allowed
					throw new UnauthorizedHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_ALLOWED ) );
				}

				// Form need logged in user
				if( $model->isVisibilityProtected() && empty( $user ) ) {

					// Remember URL for Login
					Url::remember( Url::canonical(), CoreGlobal::REDIRECT_LOGIN );

					// Error- Not allowed
					return $this->redirect( [ '/login' ] );
				}
			}

			if( $model->captcha ) {

				$form->setScenario( 'captcha' );
			}

			if( $form->load( Yii::$app->request->post(), $form->getClassName() ) && $form->validate() ) {

				// Save Model
				if( $this->modelService->processForm( $model, $form ) ) {

					// Set success message
					if( isset( $model->success ) ) {

						Yii::$app->session->setFlash( 'message', $model->success );
					}

					// Refresh the Page
		        	return $this->refresh();
				}
			}

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CoreGlobal::TYPE_FORM );
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
					'modelService' => $this->modelService,
					'template' => $template,
		        	'model' => $model,
					'form' => $form,
					'content' => $content,
					'banner' => $content->banner
		        ], [ 'page' => true ] );
			}

	        return $this->render( CoreGlobalWeb::PAGE_INDEX, [
				'model' => $model,
				'form' => $form
	        ]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
