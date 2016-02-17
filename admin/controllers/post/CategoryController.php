<?php
namespace cmsgears\cms\admin\controllers\post;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class CategoryController extends \cmsgears\cms\admin\controllers\base\CategoryController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'post-category' ];
	}

	// Instance Methods --------------------------------------------

	// CategoryController --------------------

	public function actionAll() {

		Url::remember( [ 'post/category/all' ], 'categories' );

		return parent::actionAll();
	}
}

?>