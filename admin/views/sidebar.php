<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'cms' ) && $user->isPermitted( 'cms' ) ) { ?>
	<div id="sidebar-cms" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-cms' ) == 0 ) echo 'active';?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf5 wrap-icon"><span class="cmti cmti-chart-column"></span></div>
			<div class="colf colf5x4">CMS</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-cms' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='page-element <?php if( strcmp( $child, 'element' ) == 0 ) echo 'active';?>'><?= Html::a( "Elements", ['/cms/element/all'] ) ?></li>
				<li class='page-element-template <?php if( strcmp( $child, 'element-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Element Templates", ['/cms/element/template/all'] ) ?></li>
				<li class='page-block <?php if( strcmp( $child, 'block' ) == 0 ) echo 'active';?>'><?= Html::a( "Blocks", ['/cms/block/all'] ) ?></li>
				<li class='page-block-template <?php if( strcmp( $child, 'block-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Block Templates", ['/cms/block/template/all'] ) ?></li>
				<li class='page <?php if( strcmp( $child, 'page' ) == 0 ) echo 'active';?>'><?= Html::a( "Pages", ['/cms/page/all'] ) ?></li>
				<li class='page-template <?php if( strcmp( $child, 'page-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Page Templates", ['/cms/page/template/all'] ) ?></li>
				<li class='post <?php if( strcmp( $child, 'post' ) == 0 ) echo 'active';?>'><?= Html::a( "Posts", ['/cms/post/all'] ) ?></li>
				<li class='post-template <?php if( strcmp( $child, 'post-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Post Templates", ['/cms/post/template/all'] ) ?></li>
				<li class='post-category <?php if( strcmp( $child, 'post-category' ) == 0 ) echo 'active';?>'><?= Html::a( "Post Categories", ['/cms/post/category/all'] ) ?></li>
				<li class='post-tag <?php if( strcmp( $child, 'post-tag' ) == 0 ) echo 'active';?>'><?= Html::a( "Post Tags", ['/cms/post/tag/all'] ) ?></li>
				<li class='menu <?php if( strcmp( $child, 'menu' ) == 0 ) echo 'active';?>'><?= Html::a( "Menus", ['/cms/menu/all'] ) ?></li>
				<li class='widget <?php if( strcmp( $child, 'widget' ) == 0 ) echo 'active';?>'><?= Html::a( "Widgets", ['/cms/widget/all'] ) ?></li>
				<li class='widget-template <?php if( strcmp( $child, 'widget-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Widget Templates", ['/cms/widget/template/all'] ) ?></li>
				<li class='sdebar <?php if( strcmp( $child, 'sdebar' ) == 0 ) echo 'active';?>'><?= Html::a( "Sidebars", ['/cms/sidebar/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>