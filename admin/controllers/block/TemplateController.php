<?php
namespace cmsgears\cms\admin\controllers\block;

// Yii Imports
use \Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\IntegrityException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 		= [ 'parent' => 'sidebar-cms', 'child' => 'block-template' ];
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
	                'all'  => [ 'get' ],
	                'create'  => [ 'get', 'post' ],
	                'update'  => [ 'get', 'post' ],
	                'delete'  => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// CategoryController --------------------

	public function actionAll() {

		Url::remember( [ 'block/template/all' ], 'templates' );

		return parent::actionAll( CmsGlobal::TYPE_BLOCK );
	}

	public function actionCreate() {

		return parent::actionCreate( CmsGlobal::TYPE_BLOCK );
	}

	public function actionUpdate( $id ) {

		return parent::actionUpdate( $id, CmsGlobal::TYPE_BLOCK );
	}

	public function actionDelete( $id ) {

		return parent::actionDelete( $id, CmsGlobal::TYPE_BLOCK );
	}
}

?>