<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'cmgcms' ) && $user->isPermitted( 'cms' ) ) { ?>
	<div id="sidebar-cms" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-cms' ) == 0 ) echo 'active';?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-cms"></span></div>
			<div class="colf colf4x3">CMS</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-cms' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='block <?php if( strcmp( $child, 'block' ) == 0 ) echo 'active';?>'><?= Html::a( "Blocks", ['/cmgcms/block/all'] ) ?></li>
				<li class='page <?php if( strcmp( $child, 'page' ) == 0 ) echo 'active';?>'><?= Html::a( "Pages", ['/cmgcms/page/all'] ) ?></li>
				<li class='page-template <?php if( strcmp( $child, 'page-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Page Templates", ['/cmgcms/page/template/all'] ) ?></li>
				<li class='post <?php if( strcmp( $child, 'post' ) == 0 ) echo 'active';?>'><?= Html::a( "Posts", ['/cmgcms/post/all'] ) ?></li>
				<li class='post-category <?php if( strcmp( $child, 'post-category' ) == 0 ) echo 'active';?>'><?= Html::a( "Post Categories", ['/cmgcms/post/category/all'] ) ?></li>
				<li class='post-template <?php if( strcmp( $child, 'post-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Post Templates", ['/cmgcms/post/template/all'] ) ?></li>
				<li class='menu <?php if( strcmp( $child, 'menu' ) == 0 ) echo 'active';?>'><?= Html::a( "Menus", ['/cmgcms/menu/all'] ) ?></li>
				<li class='sdebar <?php if( strcmp( $child, 'sdebar' ) == 0 ) echo 'active';?>'><?= Html::a( "Sidebars", ['/cmgcms/sidebar/all'] ) ?></li>
				<li class='widget <?php if( strcmp( $child, 'widget' ) == 0 ) echo 'active';?>'><?= Html::a( "Widgets", ['/cmgcms/widget/all'] ) ?></li>
				<li class='widget-template <?php if( strcmp( $child, 'widget-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Widget Templates", ['/cmgcms/widget/template/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>