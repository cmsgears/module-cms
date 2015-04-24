<?php
namespace cmsgears\cms\admin\models\forms;

// Yii Imports
use \Yii;
use yii\base\Model;

class MenuBinderForm extends Model {

	public $pageId;
	public $bindedData;

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'pageId', 'bindedData' ], 'required' ],
            [ 'pageId', 'compare', 'compareValue' => 0, 'operator' => '>' ]
        ];
    }
}

?>