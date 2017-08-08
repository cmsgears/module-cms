<?php
namespace cmsgears\cms\common\services\interfaces\entities;

interface IPostService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getFeatured();

	// Read - Lists ----

	// Read - Maps -----

	// Create -------------

	// Update -------------

	public function linkGallery( $model, $gallery );

	// Delete -------------

}
