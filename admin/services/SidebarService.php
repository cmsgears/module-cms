<?php
namespace cmsgears\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\models\entities\Sidebar;
use cmsgears\cms\common\models\entities\SidebarWidget;

class SidebarService extends \cmsgears\cms\common\services\SidebarService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'active' => [
	                'asc' => [ 'active' => SORT_ASC ],
	                'desc' => ['active' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'active',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Sidebar(), [ 'sort' => $sort, 'search-col' => 'name' ] );
	}

	// Create -----------

	public static function create( $sidebar ) {

		$sidebar->save();

		return $sidebar;
	}

	// Update -----------

	public static function update( $sidebar ) {
		
		$sidebarToUpdate	= self::findById( $sidebar->id );
		
		$sidebarToUpdate->copyForUpdateFrom( $sidebar, [ 'name', 'description', 'active' ] );

		$sidebarToUpdate->update();

		return $sidebarToUpdate;
	}

	public static function bindWidgets( $binder ) {

		$sidebarId	= $binder->sidebarId;
		$widgets	= $binder->bindedData;

		// Clear all existing mappings
		SidebarWidget::deleteBySidebarId( $sidebarId );

		if( isset( $widgets ) && count( $widgets ) > 0 ) {

			foreach ( $widgets as $key => $value ) {

				if( isset( $value ) ) {

					$toSave	= new SidebarWidget();

					$toSave->sidebarId	= $sidebarId;
					$toSave->widgetId	= $value;
	
					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $sidebar ) {

		$existingSidebar	= self::findById( $sidebar->id );

		// Delete Sidebar
		$existingSidebar->delete();

		return true;
	}
}

?>