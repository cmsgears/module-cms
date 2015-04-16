<?php
namespace cmsgears\cms\admin;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\cms\admin\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-cms/admin/views' );
    }
}

?>