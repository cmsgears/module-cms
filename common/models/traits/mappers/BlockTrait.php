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

use cmsgears\cms\common\models\entities\Block;
use cmsgears\cms\common\models\mappers\ModelBlock;

/**
 * BlockTrait can be used to map blocks to other models.
 */
trait BlockTrait {

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

	// BlockTrait ----------------------------

	/**
	 * @inheritdoc
	 */
	public function getModelBlocks() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( ModelBlock::class, [ 'parentId' => 'id' ] )
			->where( "$modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType'" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
		*/

		return ModelBlock::find()
			->leftJoin( $objectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveModelBlocks() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( ModelBlock::class, [ 'parentId' => 'id' ] )
			->where( "$modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
		*/

		return ModelBlock::find()
			->leftJoin( $objectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1 AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getBlocks() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( Block::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelObjectTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelObjectTable, &$mapperType ) {
					$query->onCondition( [ "$modelObjectTable.parentType" => $this->modelType, "$modelObjectTable.type" => $mapperType ] )
						->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
				}
			);
		*/

		return Block::find()
			->leftJoin( $modelObjectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveBlocks() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		/*
		return $this->hasMany( Block::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelObjectTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelObjectTable, &$mapperType ) {
					$query->onCondition( [ "$modelObjectTable.parentType" => $this->modelType, "$modelObjectTable.type" => $mapperType, "$modelObjectTable.active" => true ] )
						->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] );
				}
			);
		*/

		return Block::find()
			->leftJoin( $modelObjectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $objectTable.shared=1 AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getDisplayBlocks() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;
		$objectTable		= CoreTables::getTableName( CoreTables::TABLE_OBJECT_DATA );

		return Block::find()
			->leftJoin( $modelObjectTable, "$modelObjectTable.modelId=$objectTable.id" )
			->where( "$modelObjectTable.parentId=$this->id AND $modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $modelObjectTable.active=1" )
			->orderBy( [ "$modelObjectTable.order" => SORT_DESC, "$modelObjectTable.id" => SORT_ASC ] )
			->all();
	}

	// Static Methods ----------------------------------------------

	// Yii classes ---------------------------

	// CMG classes ---------------------------

	// BlockTrait ----------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
