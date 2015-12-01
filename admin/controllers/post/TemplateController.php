<?php
namespace cmsgears\cms\admin\controllers\post;

// Yii Imports
use \Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\IntegrityException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\BaseTemplateController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods ------------------

	// yii\base\Component ----------------

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'all'  => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'create'  => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'update'  => [ 'permission' => CmsGlobal::PERM_CMS ],
	                'delete'  => [ 'permission' => CmsGlobal::PERM_CMS ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'all'  => ['get'],
	                'create'  => ['get', 'post'],
	                'update'  => ['get', 'post'],
	                'delete'  => ['get', 'post']
                ]
            ]
        ];
    }

	// CategoryController --------------------

	public function actionAll( $type = null ) {
		
		Url::remember( [ 'page/template/all' ], 'templates' );

		return parent::actionAll( [ 'parent' => 'sidebar-cms', 'child' => 'post-template' ], CmsGlobal::TYPE_POST );
	}
	
	public function actionCreate() {

		return parent::actionCreate( [ 'parent' => 'sidebar-cms', 'child' => 'post-template' ], CmsGlobal::TYPE_POST );
	}
	 
	public function actionUpdate( $id ) {

		return parent::actionUpdate( $id, [ 'parent' => 'sidebar-cms', 'child' => 'post-template' ], CmsGlobal::TYPE_POST );
	}
	
	public function actionDelete( $id ) {

		return parent::actionDelete( $id, [ 'parent' => 'sidebar-cms', 'child' => 'post-template' ], CmsGlobal::TYPE_POST );
	}
}

?>