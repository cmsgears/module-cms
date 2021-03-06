<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\traits\mappers;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\base\CoreTables;

use cmsgears\cms\common\models\entities\Widget;
use cmsgears\cms\common\models\mappers\ModelWidget;

/**
 * WidgetTrait can be used to associate widgets to relevant models.
 */
trait WidgetTrait {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii classes ---------------------------

	// CMG interfaces ------------------------

	// CMG classes ---------------------------

	// Validators ----------------------------

	// WidgetTrait ---------------------------

	/**
	 * @inheritdoc
	 */
	public function getModelWidgets() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_WIDGET;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( ModelWidget::class, [ 'parentId' => 'id' ] )
			->where( "$modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType'" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
		*/

		return ModelWidget::find()
			->leftJoin( $objectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveModelWidgets() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_WIDGET;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( ModelWidget::class, [ 'parentId' => 'id' ] )
			->where( "$modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
		*/

		return ModelWidget::find()
			->leftJoin( $objectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1 AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getWidgets() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_WIDGET;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( Widget::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelObjectTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelObjectTable, &$mapperType ) {
					$query->onCondition( [ "$modelObjectTable.parentType" => $this->modelType, "$modelObjectTable.type" => $mapperType ] )
						->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
				}
			);
		*/

		return Widget::find()
			->leftJoin( $modelObjectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveWidgets() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_WIDGET;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( Widget::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelObjectTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelObjectTable, &$mapperType ) {
					$query->onCondition( [ "$modelObjectTable.parentType" => $this->modelType, "$modelObjectTable.type" => $mapperType, "$modelObjectTable.active" => true ] )
						->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
				}
			);
		*/

		return Widget::find()
			->leftJoin( $modelObjectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1 AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getDisplayWidgets() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_WIDGET;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		return Widget::find()
			->leftJoin( $modelObjectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	// Static Methods ----------------------------------------------

	// Yii classes ---------------------------

	// CMG classes ---------------------------

	// WidgetTrait ---------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
