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
 * IMenuService declares methods specific to menu model.
 *
 * @since 1.0.0
 */
interface IMenuService extends IObjectService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getLinks( $menu );

	public function getPageLinks( $menu, $associative = false );

	public function getPageLinksForUpdate( $menu, $pages );

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function updateLinks( $menu, $links, $pageLinks );

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
