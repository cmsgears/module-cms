<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\forms\Link;
use cmsgears\cms\common\models\forms\PageLink;
use cmsgears\core\common\models\entities\ObjectData;

use cmsgears\core\common\utilities\DataUtil;

use cmsgears\cms\common\services\interfaces\entities\IMenuService;

class MenuService extends \cmsgears\core\common\services\entities\ObjectDataService implements IMenuService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $parentType	= CmsGlobal::TYPE_MENU;

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

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =  CmsGlobal::TYPE_MENU;

		return parent::getPage( $config );
	}

	// Read ---------------

    // Read - Models ---

	public function getByName( $name, $first = false ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =  CmsGlobal::TYPE_MENU;

		return parent::getByName( $config );
	}

	public function getLinks( $menu ) {

		$objectData		= $menu->generateObjectFromJson();
		$links			= $objectData->links;
		$linkObjects	= [];

		foreach ( $links as $link ) {

			if( strcmp( $link->type, CmsGlobal::TYPE_LINK ) == 0 ) {

				$linkObjects[]	= new Link( $link );
			}
		}

		return $linkObjects;
	}

	public function getPageLinks( $menu, $associative = false ) {

		$objectData		= $menu->generateObjectFromJson();
		$links			= $objectData->links;
		$linkObjects	= [];
		$pageLinks		= [];

		foreach ( $links as $link ) {

			if( strcmp( $link->type, CmsGlobal::TYPE_PAGE ) == 0 ) {

				$pageLink		= new PageLink( $link );
				$linkObjects[]	= $pageLink;

				if( $associative ) {

					$pageLinks[ $link->pageId ]	= $pageLink;
				}
			}
		}

		if( $associative ) {

			return $pageLinks;
		}

		return $linkObjects;
	}

	public function getPageLinksForUpdate( $menu, $pages ) {

		$pageLinks		= self::getPageLinks( $menu, true );
		$keys			= array_keys( $pageLinks );
		$linkObjects	= [];

		foreach ( $pages as $page ) {

			if( in_array( $page[ 'id' ], $keys ) ) {

				$pageLink		= $pageLinks[ $page[ 'id' ] ];
				$pageLink->name	= $page[ 'name' ];
				$linkObjects[]	= $pageLink;
			}
			else {

				$pageLink			= new PageLink();
				$pageLink->pageId	= $page[ 'id' ];
				$pageLink->name		= $page[ 'name' ];
				$linkObjects[]		= $pageLink;
			}
		}

		return $linkObjects;
	}

    // Read - Lists ----

	public function getIdList( $config = [] ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =  CmsGlobal::TYPE_MENU;

		return parent::getIdList( $config );
	}

	public function getIdNameList( $config = [] ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =  CmsGlobal::TYPE_MENU;

		return parent::getIdNameList( $config );
	}

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function updateLinks( $menu, $links, $pageLinks ) {

		$menu		= self::findById( $menu->id );
		$objectData	= $menu->generateObjectFromJson();

		// Clear all existing mappings
		$objectData->links	= [];

		// Add Links
		if( isset( $links ) && count( $links ) > 0 ) {

			foreach ( $links as $link ) {

				if( isset( $link ) ) {

					$link->type				= CmsGlobal::TYPE_LINK;

					if( !isset( $link->order ) || strlen( $link->order ) == 0 ) {

						$link->order	= 0;
					}

					$objectData->links[] 	= $link;
				}
			}
		}

		// Add Page Links
		if( isset( $pageLinks ) && count( $pageLinks ) > 0 ) {

			foreach ( $pageLinks as $link ) {

				if( isset( $link->link ) && $link->link ) {

					$link->type				= CmsGlobal::TYPE_PAGE;

					if( !isset( $link->order ) || strlen( $link->order ) == 0 ) {

						$link->order	= 0;
					}

					$objectData->links[] 	= $link;
				}
			}
		}

		$objectData->links	= DataUtil::sortObjectArrayByNumber( $objectData->links, 'order', true );

		$menu->generateJsonFromObject( $objectData );

		$menu->update();

		return true;
	}

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
