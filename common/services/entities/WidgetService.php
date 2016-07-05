<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

use cmsgears\cms\common\services\interfaces\entities\IWidgetService;

class WidgetService extends \cmsgears\core\common\services\entities\ObjectDataService implements IWidgetService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $parentType	= CmsGlobal::TYPE_WIDGET;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ElementService ------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_WIDGET;

		return parent::getPage( $config );
	}

	// Read ---------------

    // Read - Models ---

	public function getByName( $name, $first = false ) {

		return $this->getByNameType( $name, CmsGlobal::TYPE_WIDGET );
	}

    // Read - Lists ----

	public function getIdList( $config = [] ) {

		return $this->getIdListByType( CmsGlobal::TYPE_WIDGET, $config );
	}

	public function getIdNameList( $config = [] ) {

		return $this->getIdNameListByType( CmsGlobal::TYPE_WIDGET, $config );
	}

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ElementService ------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------
}

?>