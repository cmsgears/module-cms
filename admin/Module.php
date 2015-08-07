<?php
namespace cmsgears\cms\admin;

// Yii Imports
use \Yii;

class Module extends \cmsgears\core\common\base\Module {

    public $controllerNamespace = 'cmsgears\cms\admin\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-cms/admin/views' );
    }

	public function getSidebarHtml() {
		
		$path	= Yii::getAlias( "@cmsgears" ) . "/module-cms/admin/views/sidebar.php";

		return $path;
	}
}

?>