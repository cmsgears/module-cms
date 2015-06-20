<?php
namespace cmsgears\cms\common\services;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Template;

use cmsgears\core\common\services\Service;

class TemplateService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Template::findById( $id );
	}

	public static function getIdNameMap() {

		return self::findMap( "id", "name", CmsTables::TABLE_TEMPLATE );
	}

	public static function getIdNameMapForPages() {

		return self::findMap( "id", "name", CmsTables::TABLE_TEMPLATE, [ 'type' => Template::TYPE_PAGE ] );
	}

	public static function getIdNameMapForWidgets() {

		return self::findMap( "id", "name", CmsTables::TABLE_TEMPLATE, [ 'type' => Template::TYPE_WIDGET ] );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Template(), $config );
	}

	// Create -----------

	public static function create( $template ) {

		$template->save();

		return $template;
	}

	// Update -----------

	public static function update( $template ) {

		$templateToUpdate	= self::findById( $template->id );

		$templateToUpdate->copyForUpdateFrom( $menu, [ 'name', 'description' ] );

		$templateToUpdate->update();

		return $templateToUpdate;
	}

	// Delete -----------

	public static function delete( $template ) {

		$existingTemplate	= self::findById( $template->id );

		// Delete Template
		$existingTemplate->delete();

		return true;
	}
}

?>