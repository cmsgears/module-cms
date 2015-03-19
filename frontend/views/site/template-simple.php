<?php
	$coreProperties = $this->context->getCoreProperties();
    $this->title 	= $coreProperties->getSiteTitle() . " | " . $page->getName();
?>
<section class="container row clearfix">
    <h1><?=$page->getName()?></h1>
    <div class="col col2 no-float-center">
    	<?=$page->getContent()?>
    </div>
</section>