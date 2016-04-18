<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\ObjectData;
use cmsgears\core\common\models\resources\CmgFile;
use cmsgears\cms\admin\models\forms\ElementForm;

use cmsgears\core\admin\services\entities\TemplateService;
use cmsgears\cms\admin\services\entities\ElementService;

class ElementController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'element' ];
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
	                'all'    => [ 'get' ],
	                'create' => [ 'get', 'post' ],
	                'update' => [ 'get', 'post' ],
	                'delete' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// UserController --------------------

	public function actionIndex() {

		return $this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = ElementService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new ObjectData();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$model->type	= CmsGlobal::TYPE_ELEMENT;
		$banner	 		= CmgFile::loadFile( null, 'Banner' );
		$meta			= new ElementForm();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && $meta->load( Yii::$app->request->post(), 'ElementForm' ) && $model->validate() ) {

			if( ElementService::create( $model, $meta, null, $banner ) ) {

				return $this->redirect( [ 'all' ] );
			}
		}

		$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

    	return $this->render( 'create', [
    		'model' => $model,
    		'banner' => $banner,
    		'meta' => $meta,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model			= ElementService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$banner	 = CmgFile::loadFile( $model->banner, 'Banner' );
			$meta	= new ElementForm( $model->data );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && $meta->load( Yii::$app->request->post(), 'ElementForm' ) && $model->validate() ) {

				if( ElementService::update( $model, $meta, null, $banner ) ) {

					return $this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'meta' => $meta,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model			= ElementService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$banner	 	= CmgFile::loadFile( $model->banner, 'Banner' );
			$meta		= new ElementForm( $model->data );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) ) {

				if( ElementService::delete( $model, null, $banner ) ) {

					return $this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'banner' => $banner,
	    		'meta' => $meta,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>