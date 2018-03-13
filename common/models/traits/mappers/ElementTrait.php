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
use cmsgears\cms\common\models\entities\Element;
use cmsgears\cms\common\models\mappers\ModelElement;

/**
 * ElementTrait can be used to associate elements to relevant models.
 */
trait ElementTrait {

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

	// ElementTrait --------------------------

	/**
	 * @inheritdoc
	 */
	public function getModelElements() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_ELEMENT;

		return $this->hasMany( ModelElement::class, [ 'parentId' => 'id' ] )
			->where( "$modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType'" );
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveModelElements() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_ELEMENT;

		return $this->hasMany( ModelElement::class, [ 'parentId' => 'id' ] )
			->where( "$modelObjectTable.parentType='$this->modelType' AND $modelObjectTable.type='$mapperType' AND $modelObjectTable.active=1" );
	}

	/**
	 * @inheritdoc
	 */
	public function getElements() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_ELEMENT;

		return $this->hasMany( Element::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelObjectTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelObjectTable, &$mapperType ) {

					$query->onCondition( [ "$modelObjectTable.parentType" => $this->modelType, "$modelObjectTable.type" => $mapperType ] );
				}
			);
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveElements() {

		$modelObjectTable	= CoreTables::getTableName( CoreTables::TABLE_MODEL_OBJECT );
		$mapperType			= CmsGlobal::TYPE_ELEMENT;

		return $this->hasMany( Element::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelObjectTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelObjectTable, &$mapperType ) {

					$query->onCondition( [ "$modelObjectTable.parentType" => $this->modelType, "$modelObjectTable.type" => $mapperType, "$modelObjectTable.active" => true ] );
				}
			);
	}

	// Static Methods ----------------------------------------------

	// Yii classes ---------------------------

	// CMG classes ---------------------------

	// ElementTrait --------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
