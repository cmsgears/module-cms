<?php
namespace cmsgears\cms\admin\models\forms;

// Yii Imports
use \Yii;
use yii\base\Model;

class WidgetBinderForm extends Model {

	public $sidebarId;
	public $bindedData;

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'sidebarId', 'bindedData' ], 'required' ],
            [ 'sidebarId', 'compare', 'compareValue' => 0, 'operator' => '>' ]
        ];
    }
}

?>