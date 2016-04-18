<?php
namespace cmsgears\cms\admin\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

class ElementForm extends \cmsgears\core\common\models\forms\JsonModel {

	public $content;
	public $data;

	public function rules() {

        return [
            [ [ 'content', 'data' ], 'safe' ]
        ];
    }
}

?>