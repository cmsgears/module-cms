<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;
use cmsgears\core\common\models\resources\Form;
use cmsgears\core\common\models\resources\FormField;

use cmsgears\cms\common\models\entities\Page;

use cmsgears\cms\common\services\entities\PostService;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The cms data migration inserts the base data required to run the application.
 *
 * @since 1.0.0
 */
class m160623_065213_cms_data extends \cmsgears\core\common\base\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	private $site;

	private $master;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( Yii::$app->migration->getSiteMaster() );

		Yii::$app->core->setSite( $this->site );
	}

	public function up() {

		// Create RBAC and Site Members
		$this->insertRolePermission();

		// Create post permission groups and CRUD permissions
		$this->insertPostPermissions();

		// Create various config
		$this->insertBlogConfig();

		// Init default config
		$this->insertDefaultConfig();

		// Init system pages
		$this->insertSystemPages();

		// Notifications
		$this->insertNotificationTemplates();
	}

	private function insertRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'adminUrl', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Blog Admin', CmsGlobal::ROLE_BLOG_ADMIN, 'dashboard', NULL, CoreGlobal::TYPE_SYSTEM, NULL, 'The role blog admin is limited to manage site content and blog posts from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole	= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole		= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$blogAdminRole	= Role::findBySlugType( 'blog-admin', CoreGlobal::TYPE_SYSTEM );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Admin Blog', 'admin-blog', CoreGlobal::TYPE_SYSTEM, null, 'The permission admin blog is to manage elements, blocks, pages, page templates, posts, post templates, post categories, post tags, menus, sidebars and widgets from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$userPerm			= Permission::findBySlugType( 'user', CoreGlobal::TYPE_SYSTEM );
		$blogAdminPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_ADMIN, CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $blogAdminPerm->id ],
			[ $adminRole->id, $blogAdminPerm->id ],
			[ $blogAdminRole->id, $adminPerm->id ], [ $blogAdminRole->id, $userPerm->id ], [ $blogAdminRole->id, $blogAdminPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

	private function insertPostPermissions() {

		// Permissions
		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'group', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			// Permission Groups - Default - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'Manage Posts', CmsGlobal::PERM_BLOG_MANAGE, CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission manage posts allows user to manage posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Post Author', CmsGlobal::PERM_BLOG_AUTHOR, CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission post author allows user to perform crud operations of post belonging to respective author from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			// Post Permissions - Hard Coded - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'View Posts', CmsGlobal::PERM_BLOG_VIEW, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission view posts allows users to view their posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Post', CmsGlobal::PERM_BLOG_ADD, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission add post allows users to create post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Post', CmsGlobal::PERM_BLOG_UPDATE, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission update post allows users to update post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Delete Post', CmsGlobal::PERM_BLOG_DELETE, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission delete post allows users to delete post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Approve Post', CmsGlobal::PERM_BLOG_APPROVE, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission approve post allows user to approve, freeze or block post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Print Post', CmsGlobal::PERM_BLOG_PRINT, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission print post allows user to print post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Import Posts', CmsGlobal::PERM_BLOG_IMPORT, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission import posts allows user to import posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Export Posts', CmsGlobal::PERM_BLOG_EXPORT, CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission export posts allows user to export posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		// Permission Groups
		$postManagerPerm	= Permission::findBySlugType( 'manage-posts', CoreGlobal::TYPE_SYSTEM );
		$postAuthorPerm		= Permission::findBySlugType( 'post-author', CoreGlobal::TYPE_SYSTEM );

		// Permissions
		$vPostsPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_VIEW, CoreGlobal::TYPE_SYSTEM );
		$aPostPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_ADD, CoreGlobal::TYPE_SYSTEM );
		$uPostPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_UPDATE, CoreGlobal::TYPE_SYSTEM );
		$dPostPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_DELETE, CoreGlobal::TYPE_SYSTEM );
		$apPostPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_APPROVE, CoreGlobal::TYPE_SYSTEM );
		$pPostPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_PRINT, CoreGlobal::TYPE_SYSTEM );
		$iPostsPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_IMPORT, CoreGlobal::TYPE_SYSTEM );
		$ePostsPerm		= Permission::findBySlugType( CmsGlobal::PERM_BLOG_EXPORT, CoreGlobal::TYPE_SYSTEM );

		//Hierarchy

		$columns = [ 'parentId', 'childId', 'rootId', 'parentType', 'lValue', 'rValue' ];

		$hierarchy = [
			// Post Manager - Organization, Approver
			[ null, null, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 18 ],
			[ $postManagerPerm->id, $vPostsPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $postManagerPerm->id, $aPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $postManagerPerm->id, $uPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $postManagerPerm->id, $dPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $postManagerPerm->id, $apPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],
			[ $postManagerPerm->id, $pPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 13 ],
			[ $postManagerPerm->id, $iPostsPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 15 ],
			[ $postManagerPerm->id, $ePostsPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 16, 17 ],

			// Post Author- Individual
			[ null, null, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 16 ],
			[ $postAuthorPerm->id, $vPostsPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $postAuthorPerm->id, $aPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $postAuthorPerm->id, $uPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $postAuthorPerm->id, $dPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $postAuthorPerm->id, $pPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],
			[ $postAuthorPerm->id, $iPostsPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 13 ],
			[ $postAuthorPerm->id, $ePostsPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 15 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_hierarchy', $columns, $hierarchy );
	}

	private function insertBlogConfig() {

		$this->insert( $this->prefix . 'core_form', [
			'siteId' => $this->site->id,
			'createdBy' => $this->master->id, 'modifiedBy' => $this->master->id,
			'name' => 'Config Blog', 'slug' => 'config-blog',
			'type' => CoreGlobal::TYPE_SYSTEM,
			'description' => 'Blog configuration form.',
			'success' => 'All configurations saved successfully.',
			'captcha' => false,
			'visibility' => Form::VISIBILITY_PROTECTED,
			'status' => Form::STATUS_ACTIVE, 'userMail' => false,'adminMail' => false,
			'createdAt' => DateUtil::getDateTime(),
			'modifiedAt' => DateUtil::getDateTime()
		]);

		$config	= Form::findBySlugType( 'config-blog', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'meta', 'active', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'page_comment','Page Comment', FormField::TYPE_TOGGLE, false, true, true, 'required', 0, NULL, '{"title":"Enable/disable comments on pages. It can also be set for individual pages from Edit Page."}' ],
			[ $config->id, 'article_comment','Article Comment', FormField::TYPE_TOGGLE, false, true, true, 'required', 0, NULL, '{"title":"Enable/disable comments on articles. It can also be set for individual articles from Edit Article."}' ],
			[ $config->id, 'post_comment','Post Comment', FormField::TYPE_TOGGLE, false, true, true, 'required', 0, NULL, '{"title":"Enable/disable comments on posts. It can also be set for individual pages from Edit Post."}' ],
			[ $config->id, 'post_limit','Post Limit', FormField::TYPE_TEXT, false, true, true, 'required,number', 0, NULL, '{"title":"Number of posts displayed on a page.","placeholder":"Post limit"}' ],
			[ $config->id, 'title_site','Title Site', FormField::TYPE_TOGGLE, false, true, true, 'required', 0, NULL, '{"title":"Enable/disable site name to generate the title."}' ],
			[ $config->id, 'title_separator','Title Separator', FormField::TYPE_TEXT, false, true, true, 'required', 0, NULL, '{"title":"Title Separator used to generate the title.","placeholder":"Title Separator"}' ],
			[ $config->id, 'append_title','Append Title', FormField::TYPE_TOGGLE, false, true, true, 'required', 0, NULL, '{"title":"Controls the position of site title."}' ]
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertDefaultConfig() {

		$columns = [ 'modelId', 'name', 'label', 'type', 'active', 'valueType', 'value', 'data' ];

		$metas	= [
			[ $this->site->id, 'page_comment', 'Page Comment', 'blog', 1, 'flag', '0', NULL ],
			[ $this->site->id, 'article_comment', 'Article Comment', 'blog', 1, 'flag', '0', NULL ],
			[ $this->site->id, 'post_comment', 'Post Comment', 'blog', 1, 'flag', '1', NULL ],
			[ $this->site->id, 'post_limit', 'Post Limit', 'blog', 1, 'text', PostService::PAGE_LIMIT, NULL ],
			[ $this->site->id, 'title_site', 'Title Site', 'blog', 1, 'flag', '1', NULL ],
			[ $this->site->id, 'title_separator', 'Title Separator', 'blog', 1, 'text', '|', NULL ],
			[ $this->site->id, 'append_title', 'Append Title', 'blog', 1, 'flag', '1', NULL ]
		];

		$this->batchInsert( $this->prefix . 'core_site_meta', $columns, $metas );
	}

	private function insertSystemPages() {

		$columns = [ 'siteId', 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'title', 'status', 'visibility', 'order', 'featured', 'comments', 'createdAt', 'modifiedAt' ];

		$pages	= [
			[ $this->site->id, $this->master->id, $this->master->id, 'Home', 'home', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Login', 'login', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Login OTP', 'login-otp', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Register', 'register', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Confirm Account', 'confirm-account', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Confirm Account OTP', 'confirm-account-otp', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Activate Account', 'activate-account', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Forgot Password', 'forgot-password', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Reset Password', 'reset-password', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Reset Password OTP', 'reset-password-otp', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'About Us', 'about-us', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Terms', 'terms', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Privacy', 'privacy', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Feedback', 'feedback', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Testimonial', 'testimonial', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Help', 'help', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'FAQs', 'faqs', CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			// Blog Page
			[ $this->site->id, $this->master->id, $this->master->id, 'Blog', CmsGlobal::PAGE_BLOG, CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			// Search Pages
			[ $this->site->id, $this->master->id, $this->master->id, 'Search Pages', CmsGlobal::PAGE_SEARCH_PAGES, CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Search Articles', CmsGlobal::PAGE_SEARCH_ARTICLES, CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Search Posts', CmsGlobal::PAGE_SEARCH_POSTS, CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			// Articles Page
			[ $this->site->id, $this->master->id, $this->master->id, 'Articles', CmsGlobal::PAGE_ARTICLES, CmsGlobal::TYPE_PAGE, null, null, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'cms_page', $columns, $pages );

		$summary = "Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero.";
		$content = "Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero.";

		$columns = [ 'parentId', 'parentType', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot', 'summary', 'content', 'publishedAt' ];

		$pages	= [
			[ Page::findBySlugType( 'home', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'login', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'login-otp', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'register', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'confirm-account', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'confirm-account-otp', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'activate-account', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'forgot-password', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'reset-password', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'reset-password-otp', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'about-us', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'terms', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'privacy', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'feedback', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'testimonial', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'help', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'faqs', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			// Blog Page
			[ Page::findBySlugType( CmsGlobal::PAGE_BLOG, CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			// Search Pages
			[ Page::findBySlugType( CmsGlobal::PAGE_SEARCH_PAGES, CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( CmsGlobal::PAGE_SEARCH_ARTICLES, CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( CmsGlobal::PAGE_SEARCH_POSTS, CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ],
			// Articles Page
			[ Page::findBySlugType( CmsGlobal::PAGE_ARTICLES, CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, $summary, $content, DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'cms_model_content', $columns, $pages );
	}

	private function insertNotificationTemplates() {

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'icon', 'type', 'description', 'active', 'renderer', 'fileRender', 'layout', 'layoutGroup', 'viewPath', 'createdAt', 'modifiedAt', 'message', 'content', 'data' ];

		$templates = [
			// Page
			[ $this->master->id, $this->master->id, 'New Page', CmsGlobal::TPL_NOTIFY_PAGE_NEW, null, 'notification', 'Trigger Notification and Email to Admin, when new Page is created by site users.', true, 'twig', 0, null, false, null, DateUtil::getDateTime(), DateUtil::getDateTime(), 'New Page - <b>{{model.displayName}}</b>', 'New Page - <b>{{model.displayName}}</b> has been submitted for registration. {% if config.link %}Please follow this <a href="{{config.link}}">link</a>.{% endif %}{% if config.adminLink %}Please follow this <a href="{{config.adminLink}}">link</a>.{% endif %}', '{"config":{"admin":"1","user":"0","direct":"0","adminEmail":"1","userEmail":"0","directEmail":"0"}}' ],
			// Post
			[ $this->master->id, $this->master->id, 'New Post', CmsGlobal::TPL_NOTIFY_POST_NEW, null, 'notification', 'Trigger Notification and Email to Admin, when new Post is created by site users.', true, 'twig', 0, null, false, null, DateUtil::getDateTime(), DateUtil::getDateTime(), 'New Post - <b>{{model.displayName}}</b>', 'New Post - <b>{{model.displayName}}</b> has been submitted for registration. {% if config.link %}Please follow this <a href="{{config.link}}">link</a>.{% endif %}{% if config.adminLink %}Please follow this <a href="{{config.adminLink}}">link</a>.{% endif %}', '{"config":{"admin":"1","user":"0","direct":"0","adminEmail":"1","userEmail":"0","directEmail":"0"}}' ],
			// Article
			[ $this->master->id, $this->master->id, 'New Article', CmsGlobal::TPL_NOTIFY_ARTICLE_NEW, null, 'notification', 'Trigger Notification and Email to Admin, when new Article is created by site users.', true, 'twig', 0, null, false, null, DateUtil::getDateTime(), DateUtil::getDateTime(), 'New Article - <b>{{model.displayName}}</b>', 'New Article - <b>{{model.displayName}}</b> has been submitted for registration. {% if config.link %}Please follow this <a href="{{config.link}}">link</a>.{% endif %}{% if config.adminLink %}Please follow this <a href="{{config.adminLink}}">link</a>.{% endif %}', '{"config":{"admin":"1","user":"0","direct":"0","adminEmail":"1","userEmail":"0","directEmail":"0"}}' ]
		];

		$this->batchInsert( $this->prefix . 'core_template', $columns, $templates );
	}

	public function down() {

		echo "m160623_065213_cms_data will be deleted with m160623_014408_core and m160623_065204_cms.\n";

		return true;
	}

}
