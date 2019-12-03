<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\frontend\controllers\apix\post;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\ModelComment;

use cmsgears\core\common\utilities\AjaxUtil;

/**
 * CommentController provides actions specific to post comment model.
 *
 * @since 1.0.0
 */
class CommentController extends \cmsgears\core\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $parentType;
	protected $commentType;

	protected $userService;
	protected $parentService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CoreGlobal::PERM_USER;

		// Config
		$this->parentType	= CmsGlobal::TYPE_POST;
		$this->commentType	= ModelComment::TYPE_COMMENT;

		// Services
		$this->modelService = Yii::$app->factory->get( 'modelCommentService' );

		$this->userService		= Yii::$app->factory->get( 'userService' );
		$this->parentService	= Yii::$app->factory->get( 'postService' );
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
					'request-spam' => [ 'permission' => $this->crudPermission ],
					'request-approve' => [ 'permission' => $this->crudPermission ],
					'request-delete' => [ 'permission' => $this->crudPermission ],
					// Model
					'bulk' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'request-spam' => [ 'post' ],
					'request-approve' => [ 'post' ],
					'request-delete' => [ 'post' ],
					// Model
					'bulk' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			// Model
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CommentController ---------------------

	public function actionRequestSpam( $id, $pid ) {

		$user = Yii::$app->core->getUser();

		$model	= $this->modelService->getById( $id );
		$parent	= $this->parentService->getById( $pid );

		if( isset( $model ) && $parent->isOwner( $user ) && $model->isParentValid( $parent->id, CmsGlobal::TYPE_POST ) ) {

			$parentType = $this->parentService->getParentType();
			$adminLink	= "cms/post/comment/all?pid={$parent->id}";

			$this->modelService->spamRequest( $model, $parent, [ 'parentType' => $parentType, 'adminLink' => $adminLink ] );

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
		}

		// Trigger Ajax Failure
    	return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ) );
    }

}
