<?php
namespace cmsgears\cms\admin\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

class WidgetForm extends \yii\base\Model {

	public $classPath;
	public $data;

	public function __construct( $jsonData = false ) {

        if( $jsonData ) {

			$this->setData( json_decode( $jsonData, true ) );
		}
    }

    private function setData( $data ) {

        foreach( $data as $key => $value ) {

            $this->{ $key } = $value;
        }
    }

	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'classPath' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'classPath', 'data' ], 'safe' ]
        ];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }
}

?>