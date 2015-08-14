<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'cmgcms' ) && $user->isPermitted( 'cms' ) ) { ?>
	<div class="collapsible-tab has-children" id="sidebar-page-blog">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-post"></span></div>
			<div class="colf colf4x3">Pages & Blog</div>
		</div>
		<div class="collapsible-tab-content clear">
			<ul>
				<li class='page-matrix'><?= Html::a( "Pages Matrix", ['/cmgcms/page/matrix'] ) ?></li>
				<li class='menu'><?= Html::a( "Menus", ['/cmgcms/menu/all'] ) ?></li>
				<li class='page'><?= Html::a( "Pages", ['/cmgcms/page/all'] ) ?></li>
				<li class='post-matrix'><?= Html::a( "Posts Matrix", ['/cmgcms/post/matrix'] ) ?></li>
				<li class='post-category'><?= Html::a( "Post Categories", ['/cmgcms/post/categories'] ) ?></li>
				<li class='post'><?= Html::a( "Posts", ['/cmgcms/post/all'] ) ?></li>
			</ul>
		</div>
	</div>

	<div class="collapsible-tab has-children" id="sidebar-sdebar">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-cms"></span></div>
			<div class="colf colf4x3">Sidebars & Widgets</div>
		</div>
		<div class="collapsible-tab-content clear">
			<ul>
				<li class='widget-matrix'><?= Html::a( "Widgets Matrix", ['/cmgcms/widget/matrix'] ) ?></li>
				<li class='sdebar'><?= Html::a( "Sidebars", ['/cmgcms/sidebar/all'] ) ?></li>
				<li class='widget'><?= Html::a( "Widgets", ['/cmgcms/widget/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>