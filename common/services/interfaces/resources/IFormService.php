<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\interfaces\resources;

// CMG Imports
use cmsgears\core\common\services\interfaces\resources\IFormService as IBaseFormService;

/**
 * IFormService declares methods specific to form model.
 *
 * @since 1.0.0
 */
interface IFormService extends IBaseFormService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getWithContentById( $id, $config = [] );

	public function getWithContentBySlug( $slug, $config = [] );

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
