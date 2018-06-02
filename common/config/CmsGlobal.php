<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\config;

/**
 * CmsGlobal defines the global constants and variables available for cms and dependent modules.
 *
 * @since 1.0.0
 */
class CmsGlobal {

	// System Sites ---------------------------------------------------

	const SITE_BLOG		= 'blog';

	// System Pages ---------------------------------------------------

	const PAGE_SEARCH_PAGES		= 'search-pages';
	const PAGE_SEARCH_ARTICLES	= 'search-articles';
	const PAGE_SEARCH_POSTS		= 'search-posts';

	// Grouping by type ------------------------------------------------

	const TYPE_ELEMENT	= 'element';
	const TYPE_BLOCK	= 'block';

	const TYPE_MENU		= 'menu';
	const TYPE_LINK		= 'link';

	const TYPE_SIDEBAR	= 'sidebar';
	const TYPE_WIDGET	= 'widget';

	const TYPE_PAGE		= 'page';
	const TYPE_ARTICLE	= 'article';
	const TYPE_POST		= 'blog';

	// Templates -------------------------------------------------------

	const TEMPLATE_PAGE		= 'page';
	const TEMPLATE_ARTICLE	= 'article';
	const TEMPLATE_POST		= 'post';

	const TEMPLATE_SEARCH	= 'search';
	const TEMPLATE_ARCHIVE	= 'archive';

	const TEMPLATE_SIDEBAR_VERTICAL		= 'vsidebar';
	const TEMPLATE_SIDEBAR_HORIZONTAL	= 'hsidebar';

	// Config ----------------------------------------------------------

	const CONFIG_BLOG	= 'blog';

	// Roles -----------------------------------------------------------

	const ROLE_BLOG_ADMIN = 'blog-admin';

	// Permissions -----------------------------------------------------

	// Blog
	const PERM_BLOG_ADMIN		= 'admin-blog';

	const PERM_BLOG_MANAGE		= 'manage-posts';
	const PERM_BLOG_AUTHOR		= 'post-author';

	const PERM_BLOG_VIEW		= 'view-posts';
	const PERM_BLOG_ADD			= 'add-post';
	const PERM_BLOG_UPDATE		= 'update-post';
	const PERM_BLOG_DELETE		= 'delete-post';
	const PERM_BLOG_APPROVE		= 'approve-post';
	const PERM_BLOG_PRINT		= 'print-post';
	const PERM_BLOG_IMPORT		= 'import-posts';
	const PERM_BLOG_EXPORT		= 'export-posts';

	// Model Attributes ------------------------------------------------

	// Default Maps ----------------------------------------------------

	// Messages --------------------------------------------------------

	// Errors ----------------------------------------------------------

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_ELEMENT			= 'elementField';
	const FIELD_BLOCK			= 'blockField';

	const FIELD_LINK			= 'linkField';
	const FIELD_MENU			= 'menuField';

	const FIELD_WIDGET			= 'widgetField';
	const FIELD_SIDEBAR			= 'sidebarField';

	const FIELD_PAGE			= 'pageField';

	const FIELD_KEYWORDS		= 'keywordsField';

	// SEO
	const FIELD_SEO_NAME			= 'seoNameField';
	const FIELD_SEO_DESCRIPTION		= 'seoDescriptionField';
	const FIELD_SEO_KEYWORDS		= 'seoKeywordsField';
	const FIELD_SEO_ROBOT			= 'seoRobotField';

	// Link
	const FIELD_ABSOLUTE	= 'absoluteField';
	const FIELD_URL_OPTIONS	= 'urlOptionsField';

}
