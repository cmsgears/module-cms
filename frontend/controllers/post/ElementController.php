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
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;

/**
 * ElementController consist of actions specific to elements.
 *
 * @since 1.0.0
 */
class ElementController extends \cmsgears\cms\frontend\controllers\ElementController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $parentService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-cms/frontend/views/element' );

		// Services
		$this->parentService = Yii::$app->factory->get( 'postService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ElementController ---------------------

    public function actionAdd( $pid = null, $ptype = null, $template = CmsGlobal::TEMPLATE_ELEMENT_CARD ) {

		$template	= $this->templateService->getBySlugType( $template, CmsGlobal::TYPE_ELEMENT );
		$modelClass	= $this->modelService->getModelClass();

		$user	= Yii::$app->core->getUser();
		$parent = $this->parentService->getById( $pid );

		if( empty( $template ) ) {

			$template = $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_ELEMENT_CARD, CmsGlobal::TYPE_ELEMENT );
		}

		if( isset( $template ) && $parent->isOwner( $user ) ) {

			$model = new $modelClass;

			// Element
			$model->siteId		= Yii::$app->core->siteId;
			$model->visibility	= $modelClass::VISIBILITY_PUBLIC;
			$model->status		= $modelClass::STATUS_NEW;
			$model->type		= CmsGlobal::TYPE_ELEMENT;
			$model->templateId	= $template->id;
			$model->userId		= $user->id;
			$model->shared		= false;

			// Files
			$avatar	= File::loadFile( null, 'Avatar' );
			$banner	= File::loadFile( null, 'Banner' );
			$video	= File::loadFile( null, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

				// Register Model
				$this->model = $this->modelService->register( $model, [
					'avatar' => $avatar, 'banner' => $banner, 'video' => $video,
					'addGallery' => true
				]);

				if( $this->model ) {

					$this->model->refresh();

					// Create Mapper
					$this->modelElementService->createByParams([
						'modelId' => $this->model->id,
						'parentId' => $parent->id, 'parentType' => $this->parentService->getParentType(),
						'type' => CmsGlobal::TYPE_ELEMENT, 'active' => true
					]);

					return $this->redirect( $this->returnUrl );
				}
			}

			$templatesMap = $this->templateService->getFrontendIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

			return $this->render( 'add', [
				'model' => $model,
				'avatar' => $avatar,
				'banner' => $banner,
				'video' => $video,
				'statusMap' => $modelClass::$baseStatusMap,
				'templatesMap' => $templatesMap
			]);
		}

		// Template not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

}
