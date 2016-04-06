<?php
namespace cmsgears\cms\frontend\services\entities;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Post;

class PostService extends \cmsgears\cms\common\services\entities\PostService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	// Pagination -------

	public static function getPagination( $config = [] ) {

		$postTable = CmsTables::TABLE_PAGE;

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'slug' => [
	                'asc' => [ 'slug' => SORT_ASC ],
	                'desc' => ['slug' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'visibility' => [
	                'asc' => [ 'visibility' => SORT_ASC ],
	                'desc' => ['visibility' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'visibility',
	            ],
	            'status' => [
	                'asc' => [ 'status' => SORT_ASC ],
	                'desc' => ['status' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'status',
	            ],
	            'template' => [
	                'asc' => [ 'template' => SORT_ASC ],
	                'desc' => ['template' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'template',
	            ],
	            'cdate' => [
	                'asc' => [ 'createdAt' => SORT_ASC ],
	                'desc' => ['createdAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'pdate' => [
	                'asc' => [ 'publishedAt' => SORT_ASC ],
	                'desc' => ['publishedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'pdate',
	            ],
	            'udate' => [
	                'asc' => [ 'updatedAt' => SORT_ASC ],
	                'desc' => ['updatedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ],
	        'defaultOrder' => [
	        	'pdate' => 'desc'
	        ]
	    ]);

		if( !isset( $config[ 'conditions' ] ) ) {

			$config[ 'conditions' ] = [];
		}

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'query' ] = Post::findWithAuthor();
		}

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		if( !isset( $config[ 'search-col' ] ) ) {

			$config[ 'search-col' ] = 'name';
		}

		if( !isset( $config[ 'route' ] ) ) {

			$config[ 'route' ] = 'blog';
		}

		$config[ 'conditions' ][ "$postTable.status" ] 		= Post::STATUS_PUBLISHED;
		$config[ 'conditions' ][ "$postTable.visibility" ] 	= Post::VISIBILITY_PUBLIC;

		return self::getDataProvider( new Post(), $config );
	}

	public static function getPaginationForSite( $config = [] ) {

		$config[ 'conditions' ][ 'siteId' ] = Yii::$app->cmgCore->siteId;

		return self::getPagination( $config );
	}

	public static function getPaginationForChildSites( $config = [] ) {

		$config[ 'filters' ][]	= [ 'not in', 'siteId', [ 1 ] ];

		return self::getPagination( $config );
	}
}

?>