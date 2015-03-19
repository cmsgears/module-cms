<?php
namespace cmsgears\modules\cms\frontend;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\modules\cms\frontend\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/modules/cms/frontend/views' );
    }
}

?>