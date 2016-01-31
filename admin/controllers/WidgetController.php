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
use cmsgears\cms\admin\models\forms\WidgetForm;

use cmsgears\core\common\services\SiteService;
use cmsgears\core\admin\services\TemplateService;
use cmsgears\cms\admin\services\WidgetService;

class WidgetController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'widget' ];
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
	                'delete' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'settings' => [ 'permission' => CmsGlobal::PERM_CMS ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => [ 'get' ],
	                'all'    => [ 'get' ],
	                'create' => [ 'get', 'post' ],
	                'update' => [ 'get', 'post' ],
	                'delete' => [ 'get', 'post' ],
	                'settings' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// UserController --------------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = WidgetService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new ObjectData();
		$model->siteId	= Yii::$app->cmgCore->siteId;
		$model->type	= CmsGlobal::TYPE_WIDGET;
		$meta			= new WidgetForm();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && $meta->load( Yii::$app->request->post(), 'WidgetForm' ) && $model->validate() ) {

			if( WidgetService::create( $model, $meta ) ) {

				return $this->redirect( [ 'all' ] );
			}
		}

		$templatesMap	= TemplateService::getIdNameMap( [ 'conditions' => [ 'type' => CmsGlobal::TYPE_WIDGET ], 'prepend' => [ [ 'name' => '0', 'value' => 'Choose Template' ] ] ] );

    	return $this->render( 'create', [
    		'model' => $model,
    		'meta' => $meta,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model			= WidgetService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$meta	= new WidgetForm( $model->data );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) && $meta->load( Yii::$app->request->post(), 'WidgetForm' ) && $model->validate() ) {

				if( WidgetService::update( $model, $meta ) ) {
	
					return $this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMap( [ 'conditions' => [ 'type' => CmsGlobal::TYPE_WIDGET ], 'prepend' => [ [ 'name' => '0', 'value' => 'Choose Template' ] ] ] );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'meta' => $meta,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}

	public function actionDelete( $id ) {

		// Find Model
		$model			= WidgetService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'ObjectData' ) ) {

				if( WidgetService::delete( $model ) ) {

					return $this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_WIDGET );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );		
	}

	public function actionSettings( $id ) {

		// Find Model
		$model	= WidgetService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$meta	= new WidgetForm( $model->data );

			if( $meta->load( Yii::$app->request->post(), 'WidgetForm' ) ) {

				if( WidgetService::update( $model, $meta ) ) {
	
					return $this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_WIDGET );

	    	return $this->render( 'settings', [
	    		'model' => $model,
	    		'meta' => $meta,
	    		'templatesMap' => $templatesMap,
	    		'theme' => SiteService::getTheme()
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>