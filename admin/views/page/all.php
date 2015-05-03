<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Pages';
$siteUrl		= $coreProperties->getSiteUrl();

// Searching
$searchTerms	= Yii::$app->request->getQueryParam( "search" );

// Sorting
$sortOrder		= Yii::$app->request->getQueryParam( "sort" );

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
		<?= LinkPager::widget( [ 'pagination' => $pages ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th><input type='checkbox' /></th>
					<th>Name
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Slug
						<span class='box-icon-sort'>
							<span sort-order='slug' class="icon-sort <?php if( strcmp( $sortOrder, 'slug') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-slug' class="icon-sort <?php if( strcmp( $sortOrder, '-slug') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Description</th>
					<th>Visibility
						<span class='box-icon-sort'>
							<span sort-order='visibility' class="icon-sort <?php if( strcmp( $sortOrder, 'visibility') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-visibility' class="icon-sort <?php if( strcmp( $sortOrder, '-visibility') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Status
						<span class='box-icon-sort'>
							<span sort-order='status' class="icon-sort <?php if( strcmp( $sortOrder, 'status') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-status' class="icon-sort <?php if( strcmp( $sortOrder, '-status') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Template
						<span class='box-icon-sort'>
							<span sort-order='template' class="icon-sort <?php if( strcmp( $sortOrder, 'template') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-template' class="icon-sort <?php if( strcmp( $sortOrder, '-template') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Keywords</th>
					<th>Created on
						<span class='box-icon-sort'>
							<span sort-order='cdate' class="icon-sort <?php if( strcmp( $sortOrder, 'cdate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-cdate' class="icon-sort <?php if( strcmp( $sortOrder, '-cdate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Published on
						<span class='box-icon-sort'>
							<span sort-order='pdate' class="icon-sort <?php if( strcmp( $sortOrder, 'pdate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-pdate' class="icon-sort <?php if( strcmp( $sortOrder, '-pdate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Updated on
						<span class='box-icon-sort'>
							<span sort-order='udate' class="icon-sort <?php if( strcmp( $sortOrder, 'udate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-udate' class="icon-sort <?php if( strcmp( $sortOrder, '-udate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
					
					$slugBase	= $siteUrl;
					$tagsBase	= Url::toRoute( "/cmgcms/page/all/" );

					foreach( $page as $pag ) {

						$id 		= $pag->id;
						$editUrl	= Html::a( $pag->name, [ "/cmgcms/page/update?id=$id" ] );
						$slug		= $pag->slug;
						$slugUrl	= "<a href='" . $slugBase . "$slug'>$slug</a>";
				?>
					<tr>
						<td> <input type='checkbox' /> </td>
						<td><?= $editUrl ?></td>
						<td><?= $slugUrl ?></td>						
						<td><?= $pag->description ?></td>
						<td><?= $pag->getVisibilityStr() ?></td>
						<td><?= $pag->getStatusStr() ?></td>
						<td><?= $pag->getTemplateName() ?></td>
						<td><?= $pag->keywords ?></td>
						<td><?= $pag->createdAt ?></td>
						<td><?= $pag->publishedAt ?></td>
						<td><?= $pag->updatedAt ?></td>
						<td>
							<span class="wrap-icon-action" title="Update Page"><?= Html::a( "", ["/cmgcms/page/update?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="Delete Page"><?= Html::a( "", ["/cmgcms/page/delete?id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
						</td>
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
	initSidebar( "sidebar-page-blog", 2 );
</script>