<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\CmgFile;
use cmsgears\cms\common\models\resources\Block;
use cmsgears\cms\common\models\forms\BlockElement;

use cmsgears\core\admin\services\entities\TemplateService;
use cmsgears\cms\admin\services\entities\ElementService;
use cmsgears\cms\admin\services\resources\BlockService;

class BlockController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'block' ];
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'index'  => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'all'    => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'create' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'update' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'delete' => [ 'permission' => CmsGlobal::PERM_CMS ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => [ 'get' ],
	                'all'   => [ 'get' ],
	                'create' => [ 'get', 'post' ],
	                'update' => [ 'get', 'post' ],
	                'delete' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// BlockController -------------------

	public function actionIndex() {

		return $this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = BlockService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new Block();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$banner 		= CmgFile::loadFile( $model->banner, 'Banner' );
		$video 			= CmgFile::loadFile( $model->video, 'Video' );
		$texture		= CmgFile::loadFile( $model->texture, 'Texture' );
		$elements		= ElementService::getIdNameList();

		// Block Elements
		$blockElements	= [];

		for ( $i = 0, $j = count( $elements ); $i < $j; $i++ ) {

			$blockElements[] = new BlockElement();
		}

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Block' ) && BlockElement::loadMultiple( $blockElements, Yii::$app->request->post(), 'BlockElement' ) &&
			$model->validate() && BlockElement::validateMultiple( $blockElements ) ) {

			$block = BlockService::create( $model, $banner, $video, $texture );

			if( $block ) {

				BlockService::updateElements( $block, $blockElements );

				return $this->redirect( [ 'all' ] );
			}
		}

		$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_BLOCK, [ 'default' => true ] );

    	return $this->render( 'create', [
    		'model' => $model,
    		'banner' => $banner,
    		'video' => $video,
    		'texture' => $texture,
    		'templatesMap' => $templatesMap,
    		'elements' => $elements,
    		'blockElements' => $blockElements
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= BlockService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$banner 		= CmgFile::loadFile( $model->banner, 'Banner' );
			$video 			= CmgFile::loadFile( $model->video, 'Video' );
			$texture		= CmgFile::loadFile( $model->texture, 'Texture' );
			$elements		= ElementService::getIdNameList();
			$blockElements	= BlockService::getElementsForUpdate( $model, $elements );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Block' ) && BlockElement::loadMultiple( $blockElements, Yii::$app->request->post(), 'BlockElement' ) &&
				$model->validate() && BlockElement::validateMultiple( $blockElements ) ) {

				if( BlockService::update( $model, $banner, $video, $texture ) ) {

					BlockService::updateElements( $model, $blockElements );

					return $this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_BLOCK, [ 'default' => true ] );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'texture' => $texture,
	    		'templatesMap' => $templatesMap,
	    		'elements' => $elements,
	    		'blockElements' => $blockElements
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= BlockService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$elements		= ElementService::getIdNameList();
			$blockElements	= BlockService::getElementsForUpdate( $model, $elements );

			if( $model->load( Yii::$app->request->post(), 'Block' ) ) {

				if( BlockService::delete( $model ) ) {

					return $this->redirect( [ 'all' ] );
				}
			}

			$banner			= $model->banner;
			$video			= $model->video;
			$texture		= $model->texture;
			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_BLOCK, [ 'default' => true ] );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'texture' => $texture,
	    		'templatesMap' => $templatesMap,
	    		'elements' => $elements,
	    		'blockElements' => $blockElements
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>