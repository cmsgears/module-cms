<?php
namespace cmsgears\modules\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\cms\common\models\entities\Post;

use cmsgears\modules\core\common\services\Service;

class PostService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

    public static function findBySlug( $slug ) {

		$page 	= Post::findBySlug( $slug );

		return $page;
    }

	public static function findById( $id ) {

		return Post::findOne( $id );
	}
}

?>