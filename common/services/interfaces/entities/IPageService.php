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
use cmsgears\core\common\services\interfaces\base\IFeatured;
use cmsgears\cms\common\services\interfaces\base\IContentService;

/**
 * IPageService declares methods specific to page model.
 *
 * @since 1.0.0
 */
interface IPageService extends IContentService, IFeatured {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getMenuPages( $ids, $map = false );

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function register( $model, $config = [] );

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
