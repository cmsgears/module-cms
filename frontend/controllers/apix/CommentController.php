<?php
namespace cmsgears\cms\frontend\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\services\entities\PostService;

class CommentController extends \cmsgears\core\frontend\controllers\apix\CommentController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->parentService	= new PostService();
	}

	// Instance Methods --------------------------------------------

	// yii\base\Controller ---------------

    public function actions() {

        return [
            'create' => [
                'class' => 'cmsgears\core\frontend\actions\comment\CreateComment',
                'scenario' => 'captcha'
            ]
        ];
    }

	// CommentController -----------------
}

?>