<?php
namespace cmsgears\modules\cms\admin\models\forms;

// Yii Imports
use \Yii;
use yii\base\Model;

class PageBinderForm extends Model {

	public $menuId;
	public $bindedData;

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'menuId', 'bindedData' ], 'required' ],
            [ 'menuId', 'compare', 'compareValue' => 0, 'operator' => '>' ]
        ];
    }
}

?>