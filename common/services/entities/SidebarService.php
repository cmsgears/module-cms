<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\entities;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\forms\SidebarWidget;

use cmsgears\cms\common\services\interfaces\entities\ISidebarService;

use cmsgears\core\common\services\entities\ObjectDataService;

use cmsgears\core\common\utilities\DataUtil;

/**
 * SidebarService provide service methods of sidebar model.
 *
 * @since 1.0.0
 */
class SidebarService extends ObjectDataService implements ISidebarService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Sidebar';

	public static $parentType	= CmsGlobal::TYPE_SIDEBAR;

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

	// SidebarService ------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass		= static::$modelClass;
		$modelTable		= static::$modelTable;

		// Sorting ----------

		$sort = new Sort([
			'attributes' => [
				'name' => [
					'asc' => [ 'name' => SORT_ASC ],
					'desc' => ['name' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'name'
				]
			]
		]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'hasOne' ] = true;
		}

		// Filters ----------

		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [ 'name' => "$modelTable.name",  'title' =>  "$modelTable.title", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template" ];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template",  'active' => "$modelTable.active"
		];

		// Result -----------

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_SIDEBAR;

		return parent::getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getByName( $name, $first = false ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_SIDEBAR;

		return parent::getByName( $config );
	}

	public function getWidgets( $sidebar, $associative = false ) {

		$objectData		= $sidebar->generateObjectFromJson();
		$widgets		= $objectData->widgets;
		$widgetObjects	= [];
		$sidebarWidgets	= [];

		foreach ( $widgets as $widget ) {

			$sidebarWidget		= new SidebarWidget( $widget );
			$widgetObjects[]	= $sidebarWidget;

			if( $associative ) {

				$sidebarWidgets[ $sidebarWidget->widgetId ]	= $sidebarWidget;
			}
		}

		if( $associative ) {

			return $sidebarWidgets;
		}

		return $widgetObjects;
	}

	public function getWidgetsForUpdate( $sidebar, $widgets ) {

		$sidebarWidgets	= self::getWidgets( $sidebar, true );
		$keys			= array_keys( $sidebarWidgets );
		$widgetObjects	= [];

		foreach ( $widgets as $widget ) {

			if( in_array( $widget[ 'id' ], $keys ) ) {

				$sidebarWidget			= $sidebarWidgets[ $widget[ 'id' ] ];
				$sidebarWidget->name	= $widget[ 'name' ];
				$widgetObjects[]		= $sidebarWidget;
			}
			else {

				$sidebarWidget				= new SidebarWidget();
				$sidebarWidget->widgetId	= $widget[ 'id' ];
				$sidebarWidget->name		= $widget[ 'name' ];
				$widgetObjects[]			= $sidebarWidget;
			}
		}

		return $widgetObjects;
	}

	// Read - Lists ----

	public function getIdList( $config = [] ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_SIDEBAR;

		return parent::getIdList( $config );
	}

	public function getIdNameList( $config = [] ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_SIDEBAR;

		return parent::getIdNameList( $config );
	}

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	/**
	 * @param array $widgets
	 * @return boolean
	 */
	public function updateWidgets( $sidebar, $widgets ) {

		$sidebar	= self::findById( $sidebar->id );
		$objectData	= $sidebar->generateObjectFromJson();

		// Clear all existing mappings
		$objectData->widgets	= [];

		// Add Widgets
		if( isset( $widgets ) && count( $widgets ) > 0 ) {

			foreach ( $widgets as $widget ) {

				if( isset( $widget->widget ) && $widget->widget ) {

					if( !isset( $widget->order ) || strlen( $widget->order ) == 0 ) {

						$widget->order	= 0;
					}

					$objectData->widgets[]	= $widget;
				}
			}
		}

		$objectData->widgets	= DataUtil::sortObjectArrayByNumber( $objectData->widgets, 'order', true );

		$sidebar->generateJsonFromObject( $objectData );

		$sidebar->update();

		return true;
	}

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'delete': {

						$this->delete( $model );

						Yii::$app->factory->get( 'activityService' )->deleteActivity( $model, self::$parentType );

						break;
					}
				}

				break;
			}
		}
	}

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// SidebarService ------------------------

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
