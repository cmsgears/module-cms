<?php
namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\utilities\AjaxUtil;

class PostController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

		parent::init();

		$this->crudPermission	= CmsGlobal::PERM_CMS;
		$this->modelService		= Yii::$app->factory->get( 'postService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->core->getRbacFilterClass(),
                'actions' => [
					'bindCategories' => [ 'permission' => $this->crudPermission ],
					'assignTags' => [ 'permission' => $this->crudPermission ],
					'removeTag' => [ 'permission' => $this->crudPermission ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
					'bindCategories' => [ 'post' ],
					'assignTags' => [ 'post' ],
					'removeTag' => [ 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

    public function actions() {

        return [
        	'bind-categories' => [
        		'class' => 'cmsgears\core\common\actions\tag\BindCategories'
        	],
            'assign-tags' => [
                'class' => 'cmsgears\core\common\actions\tag\AssignTags'
            ],
            'remove-tag' => [
                'class' => 'cmsgears\core\common\actions\tag\RemoveTag'
            ]
        ];
    }

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------
}
