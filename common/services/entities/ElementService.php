<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

use cmsgears\cms\common\services\interfaces\entities\IElementService;

class ElementService extends \cmsgears\core\common\services\entities\ObjectDataService implements IElementService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $parentType	= CmsGlobal::TYPE_ELEMENT;

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

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =  CmsGlobal::TYPE_ELEMENT;

		return parent::getPage( $config );
	}

	// Read ---------------

    // Read - Models ---

	public function getByName( $name, $first = false ) {

		$config[ 'conditions' ][ 'type' ] = CmsGlobal::TYPE_ELEMENT;

		return parent::getByName( $config );
	}

    // Read - Lists ----

	public function getIdList( $config = [] ) {

		$config[ 'conditions' ][ 'type' ] = CmsGlobal::TYPE_ELEMENT;

		return parent::getIdList( $config );
	}

	public function getIdNameList( $config = [] ) {

		$config[ 'conditions' ][ 'type' ] = CmsGlobal::TYPE_ELEMENT;

		return parent::getIdNameList( $config );
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
