<?php
namespace cmsgears\modules\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\cms\common\models\entities\Sidebar;

use cmsgears\modules\core\common\services\Service;

class SidebarService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Sidebar::findOne( $id );
	}

	public static function getIdList() {

		$sidebarsList	= array();

		// Execute the command
		$sidebars 		= Sidebar::find()->all();

		foreach ( $sidebars as $sidebar ) {
			
			array_push( $sidebarsList, $sidebar->getId() );
		}

		return $sidebarsList;
	}

	public static function getIdNameMap() {

		$sidebarsMap 	= array();

		// Execute the command
		$sidebars 		= Sidebar::find()->all();

		foreach ( $sidebars as $sidebar ) {

			$sidebarsMap[] = [ "id" => $sidebar->getId(), "name" => $sidebar->getName() ];
		}

		return $sidebarsMap;
	}
}

?>