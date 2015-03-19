<?php
namespace cmsgears\modules\cms\admin;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\core\common\validators\CoreValidator;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\modules\cms\admin\controllers';

	private $mailer;

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/modules/cms/admin/views' );
		
		CoreValidator::initValidators();
    }
}

?>