<?php
namespace cmsgears\cms\admin\services\entities;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\ObjectData;

class ElementService extends \cmsgears\cms\common\services\entities\ElementService {

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
	            ]
	        ]
	    ]);

		if( !isset( $config[ 'conditions' ] ) ) {

			$config[ 'conditions' ]	= [];
		}

		// Restrict to site
		if( !isset( $config[ 'site' ] ) || !$config[ 'site' ] ) {

			$config[ 'conditions' ][ 'siteId' ] = Yii::$app->cmgCore->siteId;

			unset( $config[ 'site' ] );
		}

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_ELEMENT;

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		if( !isset( $config[ 'search-col' ] ) ) {

			$config[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new ObjectData(), $config );
	}
}

?>