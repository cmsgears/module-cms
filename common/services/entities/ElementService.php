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

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_ELEMENT;

		return parent::getPage( $config );
	}

	// Read ---------------

    // Read - Models ---

	public function getByName( $name, $first = false ) {

		return $this->getByNameType( $name, CmsGlobal::TYPE_ELEMENT );
	}

    // Read - Lists ----

	public function getIdList( $config = [] ) {

		return $this->getIdListByType( CmsGlobal::TYPE_ELEMENT, $config );
	}

	public function getIdNameList( $config = [] ) {

		return $this->getIdNameListByType( CmsGlobal::TYPE_ELEMENT, $config );
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