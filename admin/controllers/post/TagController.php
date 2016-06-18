<?php
namespace cmsgears\cms\admin\controllers\post;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class TagController extends \cmsgears\core\admin\controllers\base\TagController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->sidebar 	= [ 'parent' => 'sidebar-cms', 'child' => 'post-tag' ];

		$this->type		= CmsGlobal::TYPE_POST;
	}

	// Instance Methods --------------------------------------------

	// CategoryController --------------------

	public function actionAll() {

		Url::remember( [ 'post/tag/all' ], 'tags' );

		return parent::actionAll();
	}
}

?>