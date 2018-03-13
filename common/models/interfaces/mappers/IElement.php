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
 * The IElement declare the methods implemented by ElementTrait. It can be implemented
 * by entities, resources and models which need multiple elements.
 *
 * @since 1.0.0
 */
interface IElement {

	/**
	 * Return all the element mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelElement[]
	 */
	public function getModelElements();

	/**
	 * Return all the active element mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelElement[]
	 */
	public function getActiveModelElements();

	/**
	 * Return all the elements associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelElement[]
	 */
	public function getElements();

	/**
	 * Return all the active elements associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelElement[]
	 */
	public function getActiveElements();

}
