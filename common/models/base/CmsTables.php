<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\base;

// CMG Imports
use cmsgears\core\common\models\base\DbTables;

/**
 * It provide table name constants of db tables available in CMS Module.
 *
 * @since 1.0.0
 */
class CmsTables extends DbTables {

	// Entities -------------

	// Content - Page and Post
	const TABLE_PAGE			= 'cmg_cms_page';

	// Resources ------------

	// Page attributes
	const TABLE_PAGE_META		= 'cmg_cms_page_meta';

	// Page Followers
	const TABLE_PAGE_FOLLOWER	= 'cmg_cms_page_follower';

	const TABLE_LINK			= 'cmg_cms_link';

	// Model Resources
	const TABLE_MODEL_CONTENT	= 'cmg_cms_model_content';

	// Mappers --------------

	const TABLE_MODEL_LINK		= 'cmg_cms_model_link';

}
