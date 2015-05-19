<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Posts Matrix";

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
		<?= Html::a( "Add Post", ["/cmgcms/post/create"], ['class'=>'btn'] )  ?>				
	</div>
	<div class="header-search"> 
		<input type="text" name="search" id="search-terms" value="<?php if( isset($searchTerms) ) echo $searchTerms;?>">
		<input type="submit" name="submit-search" value="Search" onclick="return searchTable();" />
	</div>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pages ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th>Post
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Categories</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach( $page as $post ) {

						$id 		= $post->id;
						$categories	= $post->getCategoryIdList();
						$apixUrl	= Yii::$app->urlManager->createAbsoluteUrl( "/apix/cmgcms/post/bind-categories" );
				?>
					<tr>
						<td><?= $post->name ?></td>
						<td>
							<form action="<?=$apixUrl?>" method="POST">
								<input type="hidden" name="pageId" value="<?=$id?>" />
								<ul class="ul-inline">
									<?php foreach ( $allCategories as $category ) { 

										if( in_array( $category['id'], $categories ) ) {
									?>		
											<li><input type="checkbox" name="bindedData" value="<?=$category['id']?>" checked /><?=$category['name']?></li>
									<?php		
										}
										else {
									?>
											<li><input type="checkbox" name="bindedData" value="<?=$category['id']?>" /><?=$category['name']?></li>
									<?php
										}
									}
									?>
								</ul>
							</form>
						</td>
						<td><span class="wrap-icon-action"><span class="icon-action icon-action-save matrix-row"</span></span></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $pages, $page, $total ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pages ] ); ?>
	</div>
</div>
<script type="text/javascript">
	initSidebar( "sidebar-page-blog", 3 );
	initMappingsMatrix();
</script>