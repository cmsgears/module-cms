<?php
namespace cmsgears\cms\common\services;

// CMG Imports
use cmsgears\cms\common\models\entities\Post;

use cmsgears\core\common\services\Service;

class PostService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Post::findById( $id );
	}

    public static function findBySlug( $slug ) {

		return Post::findBySlug( $slug );
    }
}

?>