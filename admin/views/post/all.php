<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Posts';
$siteUrl		= $coreProperties->getSiteUrl();

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-cms';
$this->params['sidebar-child'] 	= 'post';

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
		<?= Html::a( "Add Post", ["/cmgcms/post/create"], ['class'=>'btn'] )  ?>				
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
					<th>Tags</th>
					<th>SEO Title</th>
					<th>SEO Description</th>
					<th>SEO Keywords</th>
					<th>SEO Robot</th>
					<th>Created on
						<span class='box-icon-sort'>
							<span sort-order='cdate' class="icon-sort <?php if( strcmp( $sortOrder, 'cdate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-cdate' class="icon-sort <?php if( strcmp( $sortOrder, '-cdate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Updated on
						<span class='box-icon-sort'>
							<span sort-order='udate' class="icon-sort <?php if( strcmp( $sortOrder, 'udate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-udate' class="icon-sort <?php if( strcmp( $sortOrder, '-udate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Published on
						<span class='box-icon-sort'>
							<span sort-order='pdate' class="icon-sort <?php if( strcmp( $sortOrder, 'pdate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-pdate' class="icon-sort <?php if( strcmp( $sortOrder, '-pdate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					$slugBase	= $siteUrl;
					$tagsBase	= Url::toRoute( "/cmgcms/page/all/" );

					foreach( $models as $post ) {

						$id 		= $post->id;
						$editUrl	= Html::a( $post->name, [ "/cmgcms/post/update?id=$id" ] );
						$slug		= $post->slug;
						$slugUrl	= "<a href='" . $slugBase . "post/$slug'>$slug</a>";
						$tags		= $post->getTagMap();
						$content	= $post->content;
				?>
					<tr>
						<td><?= $editUrl ?></td>
						<td><?= $slugUrl ?></td>
						<td><?= $post->getVisibilityStr() ?></td>
						<td><?= $post->getStatusStr() ?></td>
						<td><?= $content->getTemplateName() ?></td>
						<td><?= CodeGenUtil::generateLinksFromMap( $tagsBase, $tags ) ?></td>
						<td><?= $content->seoName ?></td>
						<td><?= $content->seoDescription ?></td>
						<td><?= $content->seoKeywords ?></td>
						<td><?= $content->seoRobot ?></td>
						<td><?= $content->createdAt ?></td>
						<td><?= $content->modifiedAt ?></td>
						<td><?= $content->publishedAt ?></td>
						<td>
							<span class="wrap-icon-action"><?= Html::a( "", ["/cmgcms/post/update?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action"><?= Html::a( "", ["/cmgcms/post/delete?id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
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