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
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\cms\common\models\entities\Block;
use cmsgears\cms\common\models\mappers\ModelBlock;
use cmsgears\core\common\models\resources\Gallery;

// EC Imports
use empathyconnects\core\common\config\CoreGlobal;
use empathyconnects\cms\common\config\CmsGlobal;

/**
 * PageController consist of actions specific to site pages.
 *
 * @since 1.0.0
 */
class BlockController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

    public $blockService;
    public $modelBlockService;
    public $galleryService;
    public $modelGalleryService;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

    public function init() {

        parent::init();

        $this->blockService         = Yii::$app->factory->get( 'blockService' );
        $this->modelBlockService    = Yii::$app->factory->get( 'modelBlockService' );
        $this->galleryService       = Yii::$app->factory->get( 'galleryService' );
        $this->modelGalleryService  = Yii::$app->factory->get( 'modelGalleryService' );
    }

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ContentController ---------------------

    public function actionCreate( $slug ) {

        $post   = $this->modelService->getBySlug( $slug, true );

        $this->view->params[ 'model' ]  = $post;

        $this->view->params[ 'step' ]   = 'content';

        if( isset( $post ) ) {

            $model          = new Block();
            $modelBlock     = new ModelBlock();

            $model->siteId  = Yii::$app->core->site->id;

            if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

                $this->blockService->create( $model );

                $modelBlock->modelId    = $model->id;
                $modelBlock->parentId   = $post->id;
                $modelBlock->parentType = $post->type;

                $this->modelBlockService->create( $modelBlock );

                // Create Gallery
                $gallery            = new Gallery();
                $gallery->name      = $model->name;
                $gallery->siteId    = Yii::$app->core->siteId;
                $modelGallery       = $this->modelGalleryService->create( $gallery, [ 'parentId' => $model->id, 'parentType' => CmsGlobal::TYPE_BLOG_CONTENT ] );

                return $this->redirect( [ "update?slug=$model->slug&pslug=$post->slug" ] );
            }

            return $this->render( 'create', [
                'model' => $model,
                'post' => $post
            ] );
        }

        // Error- Page not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
    }

    public function actionUpdate( $slug, $pslug ) {

        $post   = $this->modelService->getBySlug( $pslug, true );
        $model  = $this->blockService->getBySlug( $slug );

        $this->view->params[ 'model' ]  = $post;

        $this->view->params[ 'step' ]   = 'content';

        if( isset( $post ) && isset( $model ) ) {

            $model      = $this->blockService->getBySlug( $slug, true );

            $gallery    = $this->galleryService->getBySlug( $model->slug, true );

            if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

                $this->blockService->update( $model );
            }

            return $this->render( 'update', [
                'model' => $model,
                'post' => $post,
                'gallery' => $gallery
            ] );
        }
    }
}
