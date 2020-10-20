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
 * The IWidget declare the methods implemented by WidgetTrait. It can be implemented
 * by entities, resources and models which need multiple widgets.
 *
 * @since 1.0.0
 */
interface IWidget {

	/**
	 * Return all the shared widget mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelWidget[]
	 */
	public function getModelWidgets();

	/**
	 * Return all the active shared widget mappings associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\mappers\ModelWidget[]
	 */
	public function getActiveModelWidgets();

	/**
	 * Return all the shared widgets associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelWidget[]
	 */
	public function getWidgets();

	/**
	 * Return all the active shared widgets associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelWidget[]
	 */
	public function getActiveWidgets();

	/**
	 * Return all the active widgets associated with the parent.
	 *
	 * @return \cmsgears\cms\common\models\entities\ModelWidget[]
	 */
	public function getDisplayWidgets();

}
