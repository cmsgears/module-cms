<?php
use cmsgears\widgets\cms\Blog;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | " . $page->getName();
?>
<section class="module" id="module-blog">
	<div class="texture-default"></div>
	<div class="module-wrap-content content-80">
		<div class="module-header">
			<h1 class="align-middle"><?=$page->getName()?></h1>
		</div>
		<div class="module-content">
			<?=$page->getContent()?>
		</div>
		<?php
		    echo Blog::widget([
		        'options' => [ 'class' => 'blog-posts' ]
		    ]);
		?>
	</div>
</section>