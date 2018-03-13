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

		$modelBlockTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;

		return $this->hasMany( ModelBlock::class, [ 'parentId' => 'id' ] )
			->where( "$modelBlockTable.parentType='$this->modelType' AND $modelBlockTable.type='$mapperType'" );
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveModelBlocks() {

		$modelBlockTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;

		return $this->hasMany( ModelBlock::class, [ 'parentId' => 'id' ] )
			->where( "$modelBlockTable.parentType='$this->modelType' AND $modelBlockTable.type='$mapperType' AND $modelBlockTable.active=1" );
	}

	/**
	 * @inheritdoc
	 */
	public function getBlocks() {

		$modelBlockTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;

		return $this->hasMany( Block::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelBlockTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelBlockTable, &$mapperType ) {

					$query->onCondition( [ "$modelBlockTable.parentType" => $this->modelType, "$modelBlockTable.type" => $mapperType ] );
				}
			);
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveBlocks() {

		$modelBlockTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_BLOCK;

		return $this->hasMany( Block::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelBlockTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelBlockTable, &$mapperType ) {

					$query->onCondition( [ "$modelBlockTable.parentType" => $this->modelType, "$modelBlockTable.type" => $mapperType, "$modelBlockTable.active" => true ] );
				}
			);
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
