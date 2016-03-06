<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\models\traits\ContentTrait;

/**
 * Category Entity
 *
 * @property integer $id
 * @property integer $siteId
 * @property integer $parentId
 * @property integer $rootId
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property string $type 
 * @property string $description
 * @property string $featured
 * @property integer lValue
 * @property integer rValue
 * @property string $htmlOptions
 * @property string $data
 */
class Category extends \cmsgears\core\common\models\entities\Category {
    
    public $parentType = 'category';
    
	use ContentTrait;
}

?>