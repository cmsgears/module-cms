<?php
namespace cmsgears\modules\cms\frontend\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\modules\cms\common\models\entities\Post;

class PostService extends \cmsgears\modules\cms\common\services\PostService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	// Pagination -------

	public static function getPaginationBlog() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'page_name' => SORT_ASC ],
	                'desc' => ['page_name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'slug' => [
	                'asc' => [ 'page_slug' => SORT_ASC ],
	                'desc' => ['page_slug' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'visibility' => [
	                'asc' => [ 'page_visibility' => SORT_ASC ],
	                'desc' => ['page_visibility' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'visibility',
	            ],
	            'status' => [
	                'asc' => [ 'page_status' => SORT_ASC ],
	                'desc' => ['page_status' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'status',
	            ],
	            'template' => [
	                'asc' => [ 'page_template' => SORT_ASC ],
	                'desc' => ['page_template' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'template',
	            ],
	            'cdate' => [
	                'asc' => [ 'page_created_on' => SORT_ASC ],
	                'desc' => ['page_created_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'pdate' => [
	                'asc' => [ 'page_published_on' => SORT_ASC ],
	                'desc' => ['page_published_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'pdate',
	            ],
	            'udate' => [
	                'asc' => [ 'page_updated_on' => SORT_ASC ],
	                'desc' => ['page_updated_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ],
	        'defaultOrder' => [
	        	'pdate' => 'desc'
	        ]
	    ]);
		
		$query	= Post::blogQuery();

		return self::getPaginationDetails( new Post(), [ 'route' => 'blog', 'query' => $query, 'sort' => $sort, 'search-col' => 'page_name' ] );
	}
}

?>