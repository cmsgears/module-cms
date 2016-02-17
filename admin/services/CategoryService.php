<?php
namespace cmsgears\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\models\entities\Category;

class CategoryService extends \cmsgears\cms\common\services\CategoryService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $config = [] ) {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'parent' => [
	                'asc' => [ 'parentId' => SORT_ASC ],
	                'desc' => ['parentId' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'parent',
	            ]
	        ]
	    ]);

		if( !isset( $config[ 'conditions' ] ) ) {

			$config[ 'conditions' ] = [];
		}

		// Restrict to site
		if( !isset( $config[ 'site' ] ) || !$config[ 'site' ] ) {

			$config[ 'conditions' ][ 'siteId' ] = Yii::$app->cmgCore->siteId;

			unset( $config[ 'site' ] );
		}

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		if( !isset( $config[ 'search-col' ] ) ) {

			$config[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new Category(), $config );
	}

	public static function getPaginationByType( $type ) {

		return self::getPagination( [ 'conditions' => [ 'type' => $type ] ] );
	}
}

?>