<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\interfaces\resources;

interface IPageContent {

	/**
	 * @return ModelContent associated with parent.
	 */
	public function getModelContent();

	/**
	 * It returns the view path assigned to the corresponding template.
	 * 
	 * @return string
	 */
	public function getTemplateViewPath();

	/**
	 * Check whether content is published. To consider a model as published, it must
	 * be publicly visible in either active or frozen status.
	 *
	 * @return boolean
	 */
	public function isPublished();

}
