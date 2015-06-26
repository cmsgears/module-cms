<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Pages Matrix";

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-page-blog';
$this->params['sidebar-child'] 	= 'page-matrix';

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
		<?= Html::a( "Add Page", ["/cmgcms/page/create"], ['class'=>'btn'] )  ?>				
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
					<th>Page
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Menus</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					$apixUrl	= Yii::$app->urlManager->createAbsoluteUrl( "/apix/cmgcms/page/bind-menus" );

					foreach( $models as $pag ) {

						$id 		= $pag->id;
						$menus		= $pag->getMenusIdList();
				?>
					<tr>
						<td><?= $pag->name ?></td>
						<td>
							<form action="<?=$apixUrl?>" method="POST">
								<input type="hidden" name="Binder[binderId]" value="<?=$id?>" />
								<ul class="ul-inline">
									<?php foreach ( $menusList as $menu ) {

										if( in_array( $menu['id'], $menus ) ) {
									?>		
											<li><input type="checkbox" name="Binder[bindedData]" value="<?=$menu['id']?>" checked /><?=$menu['name']?></li>
									<?php		
										}
										else {
									?>
											<li><input type="checkbox" name="Binder[bindedData]" value="<?=$menu['id']?>" /><?=$menu['name']?></li>
									<?php
										}
									}
									?>
								</ul>
							</form>
						</td>
						<td><span class="wrap-icon-action" title="Link Menus"><span class="icon-action icon-action-save matrix-row"</span></span></td>
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
<script type="text/javascript">
	initMappingsMatrix();
</script>