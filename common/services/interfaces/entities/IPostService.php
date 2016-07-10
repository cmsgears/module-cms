<?php
namespace cmsgears\cms\common\services\interfaces\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface IPostService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	public function getPublicPage( $config = [] );

	public function getPublicPageForChildSites( $config = [] );

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	// Update -------------

	// Delete -------------

}
