<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\forms\Binder;
use cmsgears\cms\common\models\entities\Widget;

use cmsgears\core\admin\services\TemplateService;
use cmsgears\cms\admin\services\SidebarService;
use cmsgears\cms\admin\services\WidgetService;

use cmsgears\core\admin\controllers\BaseController;

class WidgetController extends BaseController {

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
	                'matrix' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'create' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'update' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'delete' => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'meta'   => [ 'permission' => CmsGlobal::PERM_CMS ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => ['get'],
	                'all'    => ['get'],
	                'matrix' => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post'],
	                'meta'   => ['get', 'post']
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

	public function actionMatrix() {

		$dataProvider 	= WidgetService::getPagination();
		$sidebarsList	= SidebarService::getIdNameList();

	    return $this->render( 'matrix', [
	         'dataProvider' => $dataProvider,
	         'sidebarsList' => $sidebarsList
	    ]);
	}

	public function actionCreate() {

		$model	= new Widget();

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Widget' ) && $model->validate() ) {

			if( WidgetService::create( $model ) ) {

				$binder 			= new Binder();
				$binder->binderId	= $model->id;

				$binder->load( Yii::$app->request->post(), 'Binder' );

				return $this->redirect( [ 'all' ] );
			}
		}

		$sidebars		= SidebarService::getIdNameList();
		$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_WIDGET );

    	return $this->render( 'create', [
    		'model' => $model,
    		'sidebars' => $sidebars,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model			= WidgetService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Widget' ) && $model->validate() ) {

				if( WidgetService::update( $model ) ) {
		
					$binder 			= new Binder();
					$binder->binderId	= $model->id;

					$binder->load( Yii::$app->request->post(), 'Binder' );

					WidgetService::bindSidebars( $binder );
	
					return $this->redirect( [ 'all' ] );
				}
			}

			$sidebars		= SidebarService::getIdNameList();
			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_WIDGET );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'sidebars' => $sidebars,
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

			if( $model->load( Yii::$app->request->post(), 'Widget' ) ) {

				if( WidgetService::delete( $model ) ) {

					return $this->redirect( [ 'all' ] );
				}
			}

			$sidebars		= SidebarService::getIdNameList();
			$templatesMap	= TemplateService::getIdNameMap( CmsGlobal::TYPE_WIDGET );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'sidebars' => $sidebars,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );		
	}
	
	// Widgets -------------------------------------------------------------------

	public function actionMeta( $id ) {

		// Find Model
		$model			= WidgetService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'meta' );

			if( $model->load( Yii::$app->request->post(), 'Widget' ) && $model->validate() ) {

				if( WidgetService::updateMeta( $model ) ) {
	
					return $this->redirect( [ 'all' ] );
				}
			}

			$model->generateMapFromJson();

			$templateName 	= $model->getTemplateName();
			$view			= "@widgets/templates/admin/$templateName";

	    	return $this->render( $view, [
	    		'model' => $model
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
	}
}

?>