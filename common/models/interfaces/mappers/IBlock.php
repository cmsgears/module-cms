<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\interfaces\mappers;

/**
 * The IBlock declare the methods implemented by BlockTrait. It can be implemented
 * by entities, resources and models which need multiple blocks.
 *
 * @since 1.0.0
 */
interface IBlock {

	/**
	 * Return all the shared block mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelBlock[]
	 */
	public function getModelBlocks();

	/**
	 * Return all the active shared block mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelBlock[]
	 */
	public function getActiveModelBlocks();

	/**
	 * Return all the shared blocks associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelBlock[]
	 */
	public function getBlocks();

	/**
	 * Return all the active shared blocks associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelBlock[]
	 */
	public function getActiveBlocks();

	/**
	 * Return all the active blocks associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelBlock[]
	 */
	public function getDisplayBlocks();

}
