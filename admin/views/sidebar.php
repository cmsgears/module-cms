<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;
use cmsgears\forms\common\config\FormsGlobal;

$core	= Yii::$app->core;
$user	= $core->getUser();

$siteRootUrl = Yii::$app->core->getSiteRootUrl();
?>
<?php if( $core->hasModule( 'cms' ) && $user->isPermitted( CmsGlobal::PERM_BLOG_ADMIN ) ) { ?>
	<div id="sidebar-ui" class="collapsible-tab has-children <?= $parent == 'sidebar-ui' ? 'active' : null ?>">
		<div class="row tab-header">
			<div class="tab-icon"><span class="cmti cmti-pencil-o"></span></div>
			<div class="tab-title">UI Elements</div>
		</div>
		<div class="tab-content clear <?= $parent == 'sidebar-ui' ? 'expanded visible' : null ?>">
			<ul>
				<li class="uelement <?= $child == 'uelement' ? 'active' : null ?>"><?= Html::a( "Elements", [ "$siteRootUrl/cms/element/all" ] ) ?></li>
				<li class="ublock <?= $child == 'ublock' ? 'active' : null ?>"><?= Html::a( "Blocks", [ "$siteRootUrl/cms/block/all" ] ) ?></li>
				<li class="uwidget <?= $child == 'uwidget' ? 'active' : null ?>"><?= Html::a( "Widgets", [ "$siteRootUrl/cms/widget/all" ] ) ?></li>
				<li class="usidebar <?= $child == 'usidebar' ? 'active' : null ?>"><?= Html::a( "Sidebars", [ "$siteRootUrl/cms/sidebar/all" ] ) ?></li>
				<li class="umenu <?= $child == 'umenu' ? 'active' : null ?>"><?= Html::a( "Menus", [ "$siteRootUrl/cms/menu/all" ] ) ?></li>
				<li class="ulink <?= $child == 'ulink' ? 'active' : null ?>"><?= Html::a( "Links", [ "$siteRootUrl/cms/link/all" ] ) ?></li>
				<li class="element-template <?= $child == 'element-template' ? 'active' : null ?>"><?= Html::a( "Element Templates", [ "$siteRootUrl/cms/element/template/all" ] ) ?></li>
				<li class="block-template <?= $child == 'block-template' ? 'active' : null ?>"><?= Html::a( "Block Templates", [ "$siteRootUrl/cms/block/template/all" ] ) ?></li>
				<li class="widget-template <?= $child == 'widget-template' ? 'active' : null ?>"><?= Html::a( "Widget Templates", [ "$siteRootUrl/cms/widget/template/all" ] ) ?></li>
				<li class="sidebar-template <?= $child == 'sidebar-template' ? 'active' : null ?>"><?= Html::a( "Sidebar Templates", [ "$siteRootUrl/cms/sidebar/template/all" ] ) ?></li>
				<li class="menu-template <?= $child == 'menu-template' ? 'active' : null ?>"><?= Html::a( "Menu Templates", [ "$siteRootUrl/cms/menu/template/all" ] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>

<?php if( $core->hasModule( 'cms' ) && $user->isPermitted( CmsGlobal::PERM_BLOG_ADMIN ) ) { ?>
	<div id="sidebar-cms" class="collapsible-tab has-children <?= $parent == 'sidebar-cms' ? 'active' : null ?>">
		<div class="row tab-header">
			<div class="tab-icon"><span class="cmti cmti-pencil"></span></div>
			<div class="tab-title">Pages & Posts</div>
		</div>
		<div class="tab-content clear <?= $parent == 'sidebar-cms' ? 'expanded visible' : null ?>">
			<ul>
				<li class="page <?= $child == 'page' ? 'active' : null ?>"><?= Html::a( "Pages", [ "$siteRootUrl/cms/page/all" ] ) ?></li>
				<li class="page-comments <?= $child == 'page-comments' ? 'active' : null ?>"><?= Html::a( "Page Comments", [ "$siteRootUrl/cms/page/comment/all" ] ) ?></li>
				<li class="article <?= $child == 'article' ? 'active' : null ?>"><?= Html::a( "Articles", [ "$siteRootUrl/cms/article/all" ] ) ?></li>
				<li class="article-comments <?= $child == 'article-comments' ? 'active' : null ?>"><?= Html::a( "Article Comments", [ "$siteRootUrl/cms/article/comment/all" ] ) ?></li>
				<li class="post <?= $child == 'post' ? 'active' : null ?>"><?= Html::a( "Posts", [ "$siteRootUrl/cms/post/all" ] ) ?></li>
				<li class="post-category <?= $child == 'post-category' ? 'active' : null ?>"><?= Html::a( "Post Categories", [ "$siteRootUrl/cms/post/category/all" ] ) ?></li>
				<li class="post-tag <?= $child == 'post-tag' ? 'active' : null ?>"><?= Html::a( "Post Tags", [ "$siteRootUrl/cms/post/tag/all" ] ) ?></li>
				<li class="post-comments <?= $child == 'post-comments' ? 'active' : null ?>"><?= Html::a( "Post Comments", [ "$siteRootUrl/cms/post/comment/all" ] ) ?></li>
				<li class="page-template <?= $child == 'page-template' ? 'active' : null ?>"><?= Html::a( "Page Templates", [ "$siteRootUrl/cms/page/template/all" ] ) ?></li>
				<li class="article-template <?= $child == 'article-template' ? 'active' : null ?>"><?= Html::a( "Article Templates", [ "$siteRootUrl/cms/article/template/all" ] ) ?></li>
				<li class="post-template <?= $child == 'post-template' ? 'active' : null ?>"><?= Html::a( "Post Templates", [ "$siteRootUrl/cms/post/template/all" ] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>

<?php if( $core->hasModule( 'forms' ) && $user->isPermitted( FormsGlobal::PERM_FORM_ADMIN ) ) { ?>
	<div id="sidebar-form" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'active';?>">
		<div class="row tab-header">
			<div class="tab-icon"><span class="cmti cmti-checkbox-b-active"></span></div>
			<div class="tab-title">Forms</div>
		</div>
		<div class="tab-content clear <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='form <?php if( strcmp( $child, 'form' ) == 0 ) echo 'active';?>'><?= Html::a( "Forms", [ "$siteRootUrl/cms/form/all" ] ) ?></li>
				<?php if( $user->isPermitted( CoreGlobal::PERM_SETTINGS ) ) { ?>
					<li class='config <?php if( strcmp( $child, 'config' ) == 0 ) echo 'active';?>'><?= Html::a( "Configs", [ "$siteRootUrl/forms/config/all" ] ) ?></li>
				<?php } ?>
				<li class='template <?php if( strcmp( $child, 'template' ) == 0 ) echo 'active';?>'><?= Html::a( "Templates", [ "$siteRootUrl/forms/form/template/all" ] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>
