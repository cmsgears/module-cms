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

use cmsgears\forms\frontend\controllers\FormController as BaseFormController;

/**
 * FormController provides actions specific to form model.
 *
 * @since 1.0.0
 */
class FormController extends BaseFormController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $formService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->formService = Yii::$app->factory->get( 'formService' );
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

		$model = $this->formService->getBySlugType( $slug, CoreGlobal::TYPE_FORM );

		if( isset( $model ) ) {

			$template	= $model->modelContent->template;
			$formFields	= $model->getFieldsMap();

	 		$form	= new GenericForm( [ 'fields' => $formFields ] );
			$user	= Yii::$app->user->getIdentity();

			$form->captchaAction = '/cms/form/captcha';

			$this->view->params[ 'model' ] = $model;

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

			if( $form->load( Yii::$app->request->post(), 'GenericForm' ) && $form->validate() ) {

				// Save Model
				if( $this->formService->processForm( $model, $form ) ) {

					// Trigger User Mail
					if( $model->userMail ) {

						Yii::$app->formsMailer->sendUserMail( $model, $form );
					}

					// Trigger Admin Mail
					if( $model->adminMail ) {

						Yii::$app->formsMailer->sendAdminMail( $model, $form );
					}

					// Set success message
					if( isset( $model->success ) ) {

						Yii::$app->session->setFlash( 'message', $model->success );
					}

					// Refresh the Page
		        	return $this->refresh();
				}
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
		        	'model' => $model,
					'form' => $form,
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
