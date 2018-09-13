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
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\resources\Link;
use cmsgears\cms\common\models\mappers\ModelLink;

/**
 * LinkTrait can be used to associate links to relevant models.
 */
trait LinkTrait {

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

	// LinkTrait -----------------------------

	/**
	 * @inheritdoc
	 */
	public function getModelLinks() {

		$modelLinkTable	= CmsTables::getTableName( CmsTables::TABLE_MODEL_LINK );

		return $this->hasMany( ModelLink::class, [ 'parentId' => 'id' ] )
			->where( "$modelLinkTable.parentType='$this->modelType'" )
			->orderBy( [ "$modelLinkTable.order" => SORT_DESC, "$modelLinkTable.id" => SORT_DESC ] );
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveModelLinks() {

		$modelLinkTable	= CmsTables::getTableName( CmsTables::TABLE_MODEL_LINK );

		return $this->hasMany( ModelLink::class, [ 'parentId' => 'id' ] )
			->where( "$modelLinkTable.parentType='$this->modelType' AND $modelLinkTable.active=1" )
			->orderBy( [ "$modelLinkTable.order" => SORT_DESC, "$modelLinkTable.id" => SORT_DESC ] );
	}

	/**
	 * @inheritdoc
	 */
	public function getLinks() {

		$modelLinkTable	= CmsTables::getTableName( CmsTables::TABLE_MODEL_LINK );
		$linkTable		= CmsTables::getTableName( CmsTables::TABLE_LINK );

		/*
		return $this->hasMany( Link::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelLinkTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelLinkTable ) {
					$query->onCondition( [ "$modelLinkTable.parentType" => $this->modelType ] );
				}
			);
		*/

		return Link::find()
			->leftJoin( $modelLinkTable, "$modelLinkTable.modelId=$linkTable.id" )
			->where( "$modelLinkTable.parentId=$this->id AND $modelLinkTable.parentType='$this->modelType'" )
			->orderBy( [ "$modelLinkTable.order" => SORT_DESC, "$modelLinkTable.id" => SORT_DESC ] )
			->all();
	}

	/**
	 * @inheritdoc
	 */
	public function getActiveLinks() {

		$modelLinkTable	= CmsTables::getTableName( CmsTables::TABLE_MODEL_LINK );
		$linkTable		= CmsTables::getTableName( CmsTables::TABLE_LINK );

		/*
		return $this->hasMany( Link::class, [ 'id' => 'modelId' ] )
			->viaTable( $modelLinkTable, [ 'parentId' => 'id' ],
				function( $query ) use( &$modelLinkTable ) {
					$query->onCondition( [ "$modelLinkTable.parentType" => $this->modelType, "$modelLinkTable.active" => true ] );
				}
			);
		*/

		return Link::find()
			->leftJoin( $modelLinkTable, "$modelLinkTable.modelId=$linkTable.id" )
			->where( "$modelLinkTable.parentId=$this->id AND $modelLinkTable.parentType='$this->modelType' AND $modelLinkTable.active=1" )
			->orderBy( [ "$modelLinkTable.order" => SORT_DESC, "$modelLinkTable.id" => SORT_DESC ] )
			->all();
	}

	// Static Methods ----------------------------------------------

	// Yii classes ---------------------------

	// CMG classes ---------------------------

	// LinkTrait -----------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
