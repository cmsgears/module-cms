<?php
namespace cmsgears\cms\frontend\services\entities;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\models\base\CoreTables;
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

		$postTable = CmsTables::TABLE_PAGE;

		$config[ 'conditions' ][ "$postTable.siteId" ] = Yii::$app->cmgCore->siteId;

		return self::getPagination( $config );
	}

	public static function getPaginationForChildSites( $config = [] ) {

		$postTable = CmsTables::TABLE_PAGE;

		$config[ 'filters' ][]	= [ 'not in', "$postTable.siteId", [ 1 ] ];

		return self::getPagination( $config );
	}

	/**
	 * Generate search query using content, tag and category tables.
	 */
	public static function getPaginationForSearch( $config = [] ) {

		// DB Tables
		$postTable 			= CmsTables::TABLE_PAGE;
		$contentTable		= CmsTables::TABLE_MODEL_CONTENT;
		$mcategoryTable		= CoreTables::TABLE_MODEL_CATEGORY;
		$categoryTable		= CoreTables::TABLE_CATEGORY;
		$mtagTable			= CoreTables::TABLE_MODEL_TAG;
		$tagTable			= CoreTables::TABLE_TAG;
		$maddressTable		= CoreTables::TABLE_MODEL_ADDRESS;
		$addressTable		= CoreTables::TABLE_ADDRESS;

		// Search Query
		$query			 	= Post::find()->joinWith( 'content' );

		// Tag
		if( isset( $search ) || isset( $config[ 'tag' ] ) ) {

			$query->leftJoin( $mtagTable, "$postTable.id=$mtagTable.parentId AND $mtagTable.parentType='post' AND $mtagTable.active=TRUE" )
				->leftJoin( $tagTable, "$mtagTable.tagId=$tagTable.id" );
		}

		if( isset( $config[ 'tag' ] ) ) {

			$query->andWhere( "$tagTable.id=" . $config[ 'tag' ]->id );
		}

		// Category
		if( isset( $config[ 'category' ] ) ) {

			$query->leftJoin( "$mcategoryTable AS MCCAT", "$postTable.id=MCCAT.parentId AND MCCAT.parentType='post' AND MCCAT.active=TRUE" )
				->leftJoin( "$categoryTable AS CCAT", "MCCAT.categoryId=CCAT.id" );

			$query->andWhere( "CCAT.id=" . $config[ 'category' ]->id );
		}

		// Search
		$search 	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $search ) ) {

			$query->leftJoin( "$mcategoryTable AS MCSEARCH", "$postTable.id=MCSEARCH.parentId AND MCSEARCH.parentType='post' AND MCSEARCH.active=TRUE" )
				->leftJoin( "$categoryTable AS CSEARCH", "MCSEARCH.categoryId=CSEARCH.id" );

			$config[ 'search-col' ]	= [ "$contentTable.content", "CSEARCH.name", "$tagTable.name" ];
		}

		if( isset( $search ) || isset( $config[ 'category' ] ) ) {

			$query->groupBy( "$postTable.id" );
		}

		$config[ 'query' ]	= $query;

		return static::getPaginationForSite( $config );
	}
}

?>