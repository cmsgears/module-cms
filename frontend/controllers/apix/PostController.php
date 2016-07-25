<?php
namespace cmsgears\cms\frontend\controllers\apix;

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

	protected $metaService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

		parent::init();

		$this->crudPermission	= CoreGlobal::PERM_USER;
		$this->modelService		= Yii::$app->factory->get( 'postService' );
		$this->metaService		= Yii::$app->factory->get( 'contentMetaService' );
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
	                'assignCategory' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'removeCategory' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'assignTags' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'removeTag' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'addMeta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'updateMeta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'deleteMeta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'autoSearch' => [ 'post' ],
                    'assignCategory' => [ 'post' ],
                    'removeCategory' => [ 'post' ],
	                'assignTags' => [ 'post' ],
	                'removeTag' => [ 'post' ],
	                'addMeta' => [ 'post' ],
	                'updateMeta' => [ 'post' ],
	                'deleteMeta' => [ 'post' ],
					'submitComment' => [ 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

    public function actions() {

        return [
        	'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
            'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\AssignCategory' ],
            'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\RemoveCategory' ],
            'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\AssignTags' ],
            'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\RemoveTag' ],
            'add-meta' => [ 'class' => 'cmsgears\core\common\actions\attribute\CreateMeta' ],
            'update-meta' => [ 'class' => 'cmsgears\core\common\actions\attribute\UpdateMeta' ],
            'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\attribute\DeleteMeta' ],
            'submit-comment' => [ 'class' => 'cmsgears\core\common\actions\comment\Comment' ]
        ];
    }

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------
}
