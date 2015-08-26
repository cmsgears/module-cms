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
use cmsgears\core\admin\controllers\BaseCategoryController;

use cmsgears\core\common\models\entities\Category;

use cmsgears\core\admin\services\CategoryService; 

use cmsgears\core\admin\controllers\BaseController;
 

class CategoryController extends BaseCategoryController {

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
	                'index'  => [ 'permission' => CmsGlobal::PERM_CMS ],
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

	// DropdownController --------------------

	public function actionAll( $type = null ) {
		
		Url::remember( [ "post/category/all" ], 'categories' );
		
		$createUrl	= ["post/category/create"];

		return parent::actionAll( CmsGlobal::TYPE_POST, false, $createUrl );
	}
	
	public function actionCreate() {

		return parent::actionCreate( Url::previous( "categories" ), CmsGlobal::TYPE_POST );
	}
	 
	public function actionUpdate( $id ) {

		return parent::actionUpdate( $id, Url::previous( "categories" ), CmsGlobal::TYPE_POST );
	}
	
	public function actionDelete( $id ) {

		return parent::actionDelete( $id, Url::previous( "categories" ),CmsGlobal::TYPE_POST );
	}  
}
?>