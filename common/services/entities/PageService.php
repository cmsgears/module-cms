<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Page;

use cmsgears\core\common\services\resources\FileService;

class PageService extends \cmsgears\core\common\services\base\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return Page
	 */
	public static function findById( $id ) {

		return Page::findById( $id );
	}

	/**
	 * @param string $slug
	 * @return Page
	 */
    public static function findBySlug( $slug ) {

		return Page::findBySlug( $slug );
    }

	/**
	 * @return array - of all page ids
	 */
	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_PAGE, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_PAGE ] ] );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_PAGE, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_PAGE ] ] );
	}

    public static function getMenuPages( $pages, $map = false ) {

		if( count( $pages ) > 0 ) {

			if( $map ) {

				$pages 		= Page::find()->andFilterWhere( [ 'in', 'id', $pages ] )->all();
				$pageMap	= [];

				foreach ( $pages as $page ) {

					$pageMap[ $page->id ] = $page;
				}

				return $pageMap;
			}
			else {

				return Page::find()->andFilterWhere( [ 'in', 'id', $pages ] )->all();
			}
		}

		return [];
    }

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Page(), $config );
	}

	// Create -----------

	/**
	 * @param Page $page
	 * @param CmgFile $banner
	 * @return Page
	 */
	public static function create( $page ) {

		$page->type 	= CmsGlobal::TYPE_PAGE;

		if( !isset( $page->order ) || strlen( $post->order ) <= 0 ) {

			$page->order = 0;
		}

		// Create Page
		$page->save();

		return $page;
	}

	// Update -----------

	/**
	 * @param Page $page
	 * @param CmgFile $banner
	 * @return Page
	 */
	public static function update( $page ) {

		$pageToUpdate	= self::findById( $page->id );

		$pageToUpdate->copyForUpdateFrom( $page, [ 'parentId', 'name', 'status', 'visibility', 'icon', 'order', 'featured' ] );

		if( !isset( $pageToUpdate->order ) || strlen( $pageToUpdate->order ) <= 0 ) {

			$pageToUpdate->order = 0;
		}

		$pageToUpdate->update();

		return $pageToUpdate;
	}

	// Delete -----------

	/**
	 * @param Page $page
	 * @return boolean
	 */
	public static function delete( $page ) {

		$existingPage		= self::findById( $page->id );

		// Delete Page
		$existingPage->delete();

		return true;
	}
}

?>