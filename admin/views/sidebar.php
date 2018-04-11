<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

$core	= Yii::$app->core;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'cms' ) && $user->isPermitted( CmsGlobal::PERM_BLOG_ADMIN ) ) { ?>
	<div id="sidebar-ui" class="collapsible-tab has-children <?= $parent == 'sidebar-ui' ? 'active' : null ?>">
		<div class="row tab-header">
			<div class="tab-icon"><span class="cmti cmti-pencil-o"></span></div>
			<div class="tab-title">UI Elements</div>
		</div>
		<div class="tab-content clear <?= $parent == 'sidebar-ui' ? 'expanded visible' : null ?>">
			<ul>
				<li class="uelement <?= $child == 'uelement' ? 'active' : null ?>"><?= Html::a( "Elements", ['/cms/element/all'] ) ?></li>
				<li class="ublock <?= $child == 'ublock' ? 'active' : null ?>"><?= Html::a( "Blocks", ['/cms/block/all'] ) ?></li>
				<li class="uwidget <?= $child == 'uwidget' ? 'active' : null ?>"><?= Html::a( "Widgets", ['/cms/widget/all'] ) ?></li>
				<li class="usidebar <?= $child == 'usidebar' ? 'active' : null ?>"><?= Html::a( "Sidebars", ['/cms/sidebar/all'] ) ?></li>
				<li class="ulink <?= $child == 'ulink' ? 'active' : null ?>"><?= Html::a( "Links", ['/cms/link/all'] ) ?></li>
				<li class="umenu <?= $child == 'umenu' ? 'active' : null ?>"><?= Html::a( "Menus", ['/cms/menu/all'] ) ?></li>
				<li class="element-template <?= $child == 'element-template' ? 'active' : null ?>"><?= Html::a( "Element Templates", ['/cms/element/template/all'] ) ?></li>
				<li class="block-template <?= $child == 'block-template' ? 'active' : null ?>"><?= Html::a( "Block Templates", ['/cms/block/template/all'] ) ?></li>
				<li class="widget-template <?= $child == 'widget-template' ? 'active' : null ?>"><?= Html::a( "Widget Templates", ['/cms/widget/template/all'] ) ?></li>
				<li class="sidebar-template <?= $child == 'sidebar-template' ? 'active' : null ?>"><?= Html::a( "Sidebar Templates", ['/cms/sidebar/template/all'] ) ?></li>
				<li class="menu-template <?= $child == 'menu-template' ? 'active' : null ?>"><?= Html::a( "Menu Templates", ['/cms/menu/template/all'] ) ?></li>
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
				<li class="page <?= $child == 'page' ? 'active' : null ?>"><?= Html::a( "Pages", ['/cms/page/all'] ) ?></li>
				<li class="page-comments <?= $child == 'page-comments' ? 'active' : null ?>"><?= Html::a( "Page Comments", ['/cms/page/comment/all'] ) ?></li>
				<li class="post <?= $child == 'post' ? 'active' : null ?>"><?= Html::a( "Posts", ['/cms/post/all'] ) ?></li>
				<li class="post-category <?= $child == 'post-category' ? 'active' : null ?>"><?= Html::a( "Post Categories", ['/cms/post/category/all'] ) ?></li>
				<li class="post-tag <?= $child == 'post-tag' ? 'active' : null ?>"><?= Html::a( "Post Tags", ['/cms/post/tag/all'] ) ?></li>
				<li class="post-comments <?= $child == 'post-comments' ? 'active' : null ?>"><?= Html::a( "Post Comments", ['/cms/post/comment/all'] ) ?></li>
				<li class="page-template <?= $child == 'page-template' ? 'active' : null ?>"><?= Html::a( "Page Templates", ['/cms/page/template/all'] ) ?></li>
				<li class="post-template <?= $child == 'post-template' ? 'active' : null ?>"><?= Html::a( "Post Templates", ['/cms/post/template/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>
