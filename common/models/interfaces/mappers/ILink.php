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
 * The ILink declare the methods implemented by LinkTrait. It can be implemented
 * by entities, resources and models which need multiple links.
 *
 * @since 1.0.0
 */
interface ILink {

	/**
	 * Return all the link mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelLink[]
	 */
	public function getModelLinks();

	/**
	 * Return all the active link mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelLink[]
	 */
	public function getActiveModelLinks();

	/**
	 * Return all the links associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelLink[]
	 */
	public function getLinks();

	/**
	 * Return all the active links associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelLink[]
	 */
	public function getActiveLinks();

}
