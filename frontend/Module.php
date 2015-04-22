<?php
namespace cmsgears\cms\frontend;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\cms\frontend\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-cms/frontend/views' );
    }
}

?>