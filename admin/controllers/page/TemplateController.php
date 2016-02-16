<?php
namespace cmsgears\cms\admin\controllers\page;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 		= [ 'parent' => 'sidebar-cms', 'child' => 'page-template' ];
		
		$this->type			= CmsGlobal::TYPE_PAGE;
	}

	// Instance Methods ------------------

	// yii\base\Component ----------------

    public function behaviors() {
		
		$behaviors	= parent::behaviors();
		
		$behaviors[ 'rbac' ][ 'actions' ] = [
								                'all'  => [ 'permission' => CmsGlobal::PERM_CMS ],
								                'create'  => [ 'permission' => CmsGlobal::PERM_CMS ],
								                'update'  => [ 'permission' => CmsGlobal::PERM_CMS ],
								                'delete'  => [ 'permission' => CmsGlobal::PERM_CMS ]
							                ];
		
		return $behaviors;
    }

	// CategoryController --------------------

	public function actionAll() {

		Url::remember( [ 'page/template/all' ], 'templates' );

		return parent::actionAll();
	}
}

?>