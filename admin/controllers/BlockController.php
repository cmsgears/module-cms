<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\cms\common\models\entities\Block;

use cmsgears\core\admin\services\TemplateService;
use cmsgears\cms\admin\services\BlockService;

class BlockController extends \cmsgears\core\admin\controllers\BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
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
	                'index'  => ['get'],
	                'all'   => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post']
                ]
            ]
        ];
    }

	// BlockController -------------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = BlockService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model		= new Block();
		$banner	 	= new CmgFile();
		$video	 	= new CmgFile();
		$texture	= new CmgFile();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Block' ) && $model->validate() ) {

			$banner->load( Yii::$app->request->post(), 'Banner' );
			$video->load( Yii::$app->request->post(), 'Video' );
			$texture->load( Yii::$app->request->post(), 'Texture' );

			if( BlockService::create( $model, $banner, $video, $texture ) ) {

				$this->redirect( [ 'all' ] );
			}
		}

		$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_BLOCK );

    	return $this->render( 'create', [
    		'model' => $model,
    		'banner' => $banner,
    		'video' => $video,
    		'texture' => $texture,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= BlockService::findById( $id );
		$banner 	= new CmgFile();

		// Update/Render if exist
		if( isset( $model ) ) {

			$banner 	= CmgFile::loadFile( $model->banner, 'Banner' );
			$video 		= CmgFile::loadFile( $model->video, 'Video' );
			$texture	= CmgFile::loadFile( $model->texture, 'Texture' );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Block' ) && $model->validate() ) {

				if( BlockService::update( $model, $banner, $video, $texture ) ) {
	
					$this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_BLOCK );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'texture' => $texture,
	    		'templatesMap' => $templatesMap
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

			if( $model->load( Yii::$app->request->post(), 'Block' ) ) {

				if( BlockService::delete( $model ) ) {

					$this->redirect( [ 'all' ] );
				}
			}

			$banner			= $model->banner;
			$video			= $model->video;
			$texture		= $model->texture;
			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_BLOCK );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'texture' => $texture,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>