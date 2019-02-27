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
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\base\CoreTables;

class CommentController extends \cmsgears\cms\admin\controllers\post\CommentController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

            parent::init();

            // Views
            $this->setViewPath( '@cmsgears/module-cms/frontend/views/comment' );

            // Permission
            $this->crudPermission	= CoreGlobal::PERM_USER;
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CommentController ---------------------
        public function actionAll( $slug = null ) {

            Url::remember( Yii::$app->request->getUrl(), $this->commentUrl );

            $model			= null;
            $dataProvider	= null;
            $mCommentTable	= CoreTables::TABLE_MODEL_COMMENT;

            if( isset( $slug ) ) {

                $model          = $this->parentService->getBySlug( $slug, true );
                $dataProvider	= $this->modelService->getPageByParent( $model->id, $this->parentType, [ 'conditions' => [ "$mCommentTable.type" => $this->commentType ] ] );
            }
            else {

                $dataProvider	= $this->modelService->getPageByParentType( $this->parentType, [ 'conditions' => [ "$mCommentTable.type" => $this->commentType ] ] );
            }

            $parent	= isset( $pid ) ? true : false;

            return $this->render( 'all', [
                     'dataProvider' => $dataProvider,
                     'model' => $model,
                     'parent' => $parent
            ]);
	}

}
