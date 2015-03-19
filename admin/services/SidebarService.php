<?php
namespace cmsgears\modules\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\modules\cms\common\models\entities\Sidebar;
use cmsgears\modules\cms\common\models\entities\SidebarWidget;

class SidebarService extends \cmsgears\modules\cms\common\services\SidebarService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'sidebar_name' => SORT_ASC ],
	                'desc' => ['sidebar_name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'active' => [
	                'asc' => [ 'sidebar_active' => SORT_ASC ],
	                'desc' => ['sidebar_active' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'active',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Sidebar(), [ 'sort' => $sort, 'search-col' => 'sidebar_name' ] );
	}

	// Create -----------

	public static function create( $sidebar ) {

		$sidebar->save();

		return true;
	}

	// Update -----------

	public static function update( $sidebar ) {
		
		$sidebarToUpdate	= self::findById( $sidebar->getId() );
		
		$sidebarToUpdate->setName( $sidebar->getName() );
		$sidebarToUpdate->setDesc( $sidebar->getDesc() );
		$sidebarToUpdate->setActive( $sidebar->isActive() );

		$sidebarToUpdate->update();

		return true;
	}

	public static function bindWidgets( $binder ) {

		$sidebarId	= $binder->sidebarId;
		$widgets	= $binder->bindedData;
	
		// Clear all existing mappings
		SidebarWidget::deleteBySidebar( $sidebarId );

		if( isset( $widgets ) && count( $widgets ) > 0 ) {

			foreach ( $widgets as $key => $value ) {
				
				if( isset( $value ) ) {

					$toSave	= new SidebarWidget();
	
					$toSave->setSidebarId( $sidebarId );
					$toSave->setWidgetId( $value );
	
					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $sidebar ) {

		$sidebarId			= $sidebar->getId();
		$existingSidebar	= self::findById( $sidebarId );

		// Delete Sidebar
		$existingSidebar->delete();

		return true;
	}
}

?>