<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Widgets Matrix";

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-sdebar';
$this->params['sidebar-child'] 	= 'widget-matrix';

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();

// Searching
$searchTerms	= Yii::$app->request->getQueryParam("search");

// Sorting
$sortOrder		= Yii::$app->request->getQueryParam("sort");

if( !isset( $sortOrder ) ) {

	$sortOrder	= '';
}
?>
<div class="content-header clearfix">
	<div class="header-actions"> 
		<?= Html::a( "Add Widget", ["/cmgcms/widget/create"], ['class'=>'btn'] )  ?>				
	</div>
	<div class="header-search">
		<input type="text" name="search" id="search-terms" value="<?php if( isset($searchTerms) ) echo $searchTerms;?>">
		<input type="submit" name="submit-search" value="Search" onclick="return searchTable();" />
	</div>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th>Widget
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Sidebars</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					$apixUrl	= Yii::$app->urlManager->createAbsoluteUrl( "/apix/cmgcms/widget/bind-sidebars" );

					foreach( $models as $widget ) {

						$id 		= $widget->id;
						$sidebars	= $widget->getSidebarsIdList();
				?>
					<tr id="widget-matrix-<?=$id?>" class="request-ajax" cmt-controller="widget" cmt-action="matrix" action="<?=$apixUrl?>" method="POST" cmt-clear-data="false">
						<td><?= $widget->name ?></td>
						<td>
							<form action="<?=$apixUrl?>" method="POST">
								<input type="hidden" name="Binder[binderId]" value="<?=$id?>" />
								<ul class="ul-inline">
									<?php foreach ( $sidebarsList as $sidebar ) { 

										if( in_array( $sidebar['id'], $sidebars ) ) {
									?>		
											<li><input type="checkbox" name="Binder[bindedData][]" value="<?=$sidebar['id']?>" checked /><?=$sidebar['name']?></li>
									<?php		
										}
										else {
									?>
											<li><input type="checkbox" name="Binder[bindedData][]" value="<?=$sidebar['id']?>" /><?=$sidebar['name']?></li>
									<?php
										}
									}
									?>
								</ul>
							</form>
						</td>
						<td>
							<span class="wrap-icon-action cmt-submit" title="Assign Roles" cmt-request="widget-matrix-<?=$id?>">
								<span class="icon-action icon-action-save"</span>
							</span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
</div>