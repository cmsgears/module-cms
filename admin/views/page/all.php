<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'All Pages | ' . $coreProperties->getSiteTitle();
$siteUrl		= $coreProperties->getSiteUrl();

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();

// Searching
$searchTerms	= Yii::$app->request->getQueryParam( 'search' );

// Sorting
$sortOrder		= Yii::$app->request->getQueryParam( 'sort' );

if( !isset( $sortOrder ) ) {

	$sortOrder	= '';
}
?>
<div class="header-content clearfix">
	<div class="header-actions col15x10">
		<?= Html::a( 'Add Page', [ 'create' ], [ 'class' => 'btn btn-medium' ] ) ?>				
	</div>
	<div class="header-search col15x5">
		<input id="search-terms" class="element-large" type="text" name="search" value="<?= $searchTerms ?>">
		<span class="frm-icon-element element-medium">
			<i class="cmti cmti-search"></i>
			<button id="btn-search">Search</button>
		</span>
	</div>
</div>

<div class="data-grid">
	<div class="grid-header clearfix">
		<div class="col12x6 info">
			<?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?>
		</div>
		<div class="col12x6 pagination">
			<?= LinkPager::widget( [ 'pagination' => $pagination, 'options' => [ 'class' => 'pagination-basic' ] ] ); ?>
		</div>
	</div>
	<div class="grid-content">
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
					<th>SEO Details</th>
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

					foreach( $models as $pag ) {

						$id 		= $pag->id;
						$editUrl	= Html::a( $pag->name, [ "/cmgcms/page/update?id=$id" ] );
						$slug		= $pag->slug;
						$slugUrl	= "<a href='" . $slugBase . "$slug'>$slug</a>";
						$content	= $pag->content;
				?>
					<tr>
						<td><?= $editUrl ?></td>
						<td><?= $slugUrl ?></td>
						<td><?= $pag->getVisibilityStr() ?></td>
						<td><?= $pag->getStatusStr() ?></td>
						<td><?= $content->getTemplateName() ?></td>
						<td>
							<table>
								<tr><td>Name</td><td><?= $content->seoName ?></td></tr>
								<tr><td>Description</td><td><?= $content->seoDescription ?></td></tr>
								<tr><td>Keywords</td><td><?= $content->seoKeywords ?></td></tr>
								<tr><td>Robot</td><td><?= $content->seoRobot ?></td></tr>
							</table>
						</td>
						<td><?= $content->createdAt ?></td>
						<td><?= $content->modifiedAt ?></td>
						<td><?= $content->publishedAt ?></td>
						<td>
							<span title="Update Page"><?= Html::a( "", [ "update?id=$id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
							<span title="Delete Page"><?= Html::a( "", [ "delete?id=$id" ], [ 'class' => 'cmti cmti-close-c-o' ] )  ?></span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-header clearfix">
		<div class="col12x6 info">
			<?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?>
		</div>
		<div class="col12x6 pagination">
			<?= LinkPager::widget( [ 'pagination' => $pagination, 'options' => [ 'class' => 'pagination-basic' ] ] ); ?>
		</div>
	</div>
</div>