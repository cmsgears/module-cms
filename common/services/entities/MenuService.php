<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\forms\Link;
use cmsgears\cms\common\models\forms\PageLink;
use cmsgears\core\common\models\entities\ObjectData;

use cmsgears\core\common\utilities\SortUtil;

class MenuService extends \cmsgears\core\common\services\entities\ObjectDataService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return ObjectData
	 */
	public static function findByName( $name ) {

		return self::findByNameType( $name, CmsGlobal::TYPE_MENU );
	}

	/**
	 * @return array - of all menu ids
	 */
	public static function getIdList() {

		return self::getIdListByType( CmsGlobal::TYPE_MENU );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::getIdNameListByType( CmsGlobal::TYPE_MENU );
	}

	public static function getLinks( $menu ) {

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

	public static function getPageLinks( $menu, $associative = false ) {

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

	public static function getPageLinksForUpdate( $menu, $pages ) {

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

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		if( !isset( $config[ 'conditions' ] ) ) {

			$config[ 'conditions' ]	= [];
		}

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_MENU;

		return self::getDataProvider( new ObjectData(), $config );
	}

	// Update -----------

	public static function updateLinks( $menu, $links, $pageLinks ) {

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

		$objectData->links	= SortUtil::sortObjectArrayByNumber( $objectData->links, 'order', true );

		$menu->generateJsonFromObject( $objectData );

		$menu->update();

		return true;
	}
}

?>