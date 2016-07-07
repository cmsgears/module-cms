<?php
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

use cmsgears\core\common\utilities\DateUtil;

class m160621_065213_cms_data extends \yii\db\Migration {

	public $prefix;

	private $site;

	private $master;

	public function init() {

		$this->prefix		= 'cmg_';

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( 'demomaster' );

		Yii::$app->core->setSite( $this->site );
	}

    public function up() {

		// Create RBAC and Site Members
		$this->insertRolePermission();

		// Create various config
		$this->insertCmsConfig();

		// Init default config
		$this->insertDefaultConfig();

		// Init system pages
		$this->insertSystemPages();
    }

	private function insertRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'CMS Manager', 'cms-manager', 'dashboard', CoreGlobal::TYPE_SYSTEM, null, 'The role CMS Manager is limited to manage cms from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole		= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole			= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$cmsManagerRole		= Role::findBySlugType( 'cms-manager', CoreGlobal::TYPE_SYSTEM );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'CMS', 'cms', CoreGlobal::TYPE_SYSTEM, null, 'The permission cms is to manage templates, pages, menus, sidebars and widgets from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$userPerm			= Permission::findBySlugType( 'user', CoreGlobal::TYPE_SYSTEM );
		$cmsPerm			= Permission::findBySlugType( 'cms', CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $cmsPerm->id ],
			[ $adminRole->id, $cmsPerm->id ],
			[ $cmsManagerRole->id, $adminPerm->id ], [ $cmsManagerRole->id, $userPerm->id ], [ $cmsManagerRole->id, $cmsPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

	private function insertCmsConfig() {

		$this->insert( $this->prefix . 'core_form', [
            'siteId' => $this->site->id,
            'createdBy' => $this->master->id, 'modifiedBy' => $this->master->id,
            'name' => 'Config CMS', 'slug' => 'config-cms',
            'type' => CoreGlobal::TYPE_SYSTEM,
            'description' => 'CMS configuration form.',
            'successMessage' => 'All configurations saved successfully.',
            'captcha' => false,
            'visibility' => Form::VISIBILITY_PROTECTED,
            'active' => true, 'userMail' => false,'adminMail' => false,
            'createdAt' => DateUtil::getDateTime(),
            'modifiedAt' => DateUtil::getDateTime()
        ]);

		$config	= Form::findBySlug( 'config-cms', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'page_comment','Page Comment', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{\"title\":\"Enable/disable comments on pages. It can also be set for individual pages from Edit Page.\"}' ],
			[ $config->id, 'post_comment','Post Comment', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{\"title\":\"Enable/disable comments on posts. It can also be set for individual pages from Edit Post.\"}' ],
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertDefaultConfig() {

		$columns = [ 'modelId', 'name', 'label', 'type', 'valueType', 'value' ];

		$attributes	= [
			[ $this->site->id, 'page_comment', 'Page Comment', 'cms', 'flag', '0' ],
			[ $this->site->id, 'post_comment', 'Post Comment', 'cms', 'flag', '1' ]
		];

		$this->batchInsert( $this->prefix . 'core_site_attribute', $columns, $attributes );
	}

	private function insertSystemPages() {

		$columns = [ 'siteId', 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'status', 'visibility', 'icon', 'order', 'featured', 'comments', 'createdAt', 'modifiedAt' ];

		$pages	= [
			[ $this->site->id, $this->master->id, $this->master->id, 'Home', 'home', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Login', 'login', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Register', 'register', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Confirm Account', 'confirm-account', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Activate Account', 'activate-account', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Forgot Password', 'forgot-password', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Reset Password', 'reset-password', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'About Us', 'about-us', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Terms', 'terms', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Privacy', 'privacy', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Blog', 'blog', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'cms_page', $columns, $pages );

		$summary = "Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero.";
		$content = "Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero.";

		$columns = [ 'parentId', 'parentType', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot', 'views', 'referrals', 'summary', 'content', 'publishedAt' ];

		$pages	= [
			[ Page::findBySlugType( 'home', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'login', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'register', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'confirm-account', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'activate-account', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'forgot-password', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'reset-password', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'about-us', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'terms', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'privacy', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'blog', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'cms_model_content', $columns, $pages );
	}

    public function down() {

        echo "m160621_065213_cms_data will be deleted with m160621_014408_core and m160621_065204_cms.\n";

        return true;
    }
}
