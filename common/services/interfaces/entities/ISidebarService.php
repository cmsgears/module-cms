<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\interfaces\entities;

// CMG Imports
use cmsgears\core\common\services\interfaces\entities\IObjectService;

/**
 * ISidebarService declares methods specific to sidebar model.
 *
 * @since 1.0.0
 */
interface ISidebarService extends IObjectService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getWidgets( $sidebar, $associative = false );

	public function getWidgetsForUpdate( $sidebar, $widgets );

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function updateWidgets( $sidebar, $widgets );

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
