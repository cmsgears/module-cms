<?php
// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\widgets\category\CategorySuggest;
use cmsgears\widgets\tag\TagMapper;
?>
<div class="filler-height filler-height-small"></div>
<div class="row max-cols-100">
	<div class="box box-crud colf colf15x7">
		<div class="box-header">
			<div class="box-header-title">Categories</div>
		</div>
		<div class="box-content padding padding-small">
			<?= CategorySuggest::widget([
				'model' => $model, 'type' => CmsGlobal::TYPE_POST, 'disabled' => true
			])?>
		</div>
	</div>
	<div class="colf colf15"></div>
	<div class="box box-crud colf colf15x7">
		<div class="box-header">
			<div class="box-header-title">Tags</div>
		</div>
		<div class="box-content padding padding-small">
			<?= TagMapper::widget([
				'model' => $model, 'disabled' => true
			])?>
		</div>
	</div>
</div>
