<?php
namespace cmsgears\cms\admin\models\forms;

// Yii Imports
use \Yii;
use yii\base\Model;

class SidebarBinderForm extends Model {

	public $widgetId;
	public $bindedData;

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'widgetId', 'bindedData' ], 'required' ],
            [ 'widgetId', 'compare', 'compareValue' => 0, 'operator' => '>' ]
        ];
    }
}

?>