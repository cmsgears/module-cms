<?php
namespace cmsgears\modules\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\cms\common\models\entities\Page;

use cmsgears\modules\core\common\services\Service;

class PageService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

    public static function findBySlug( $slug ) {

		$page 	= Page::findBySlug( $slug );

		return $page;
    }

	public static function findById( $id ) {

		return Page::findOne( $id );
	}

	public static function getIdList() {

		$pagesList	= array();

		// Execute the command
		$pages 		= Page::find()->all();

		foreach ( $pages as $page ) {
			
			array_push( $pagesList, $page->getId() );
		}

		return $pagesList;
	}

	public static function getIdNameMap() {

		$pagesMap 		= array();

		// Execute the command
		$pages 		= Page::find()->all();

		foreach ( $pages as $page ) {

			$pagesMap[] = [ "id" => $page->getId(), "name" => $page->getName() ];
		}

		return $pagesMap;
	}
}

?>