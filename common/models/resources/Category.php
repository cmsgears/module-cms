<?php
namespace cmsgears\cms\common\models\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\models\traits\resources\ContentTrait;

/**
 * Category Entity
 *
 * @property long $id
 * @property long $siteId
 * @property long $parentId
 * @property long $rootId
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property string $type
 * @property string $description
 * @property boolean $featured
 * @property short lValue
 * @property short rValue
 * @property string $htmlOptions
 * @property string $data
 */
class Category extends \cmsgears\core\common\models\resources\Category {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

    public $parentType = 'category';

	// Private/Protected --

	// Traits ------------------------------------------------------

	use ContentTrait;

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

	// yii\base\Model --------------------

	// Category --------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	// Category --------------------------

	// Create -------------

	// Read ---------------

	// Update -------------

	// Delete -------------
}

?>