<?php
namespace cmsgears\cms\common\services\mappers;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\mappers\ModelContent;

use cmsgears\core\common\services\resources\FileService;

use cmsgears\core\common\utilities\DateUtil;

class ModelContentService extends \cmsgears\core\common\services\base\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return ModelContent
	 */
	public static function findById( $id ) {

		return ModelContent::findById( $id );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new ModelContent(), $config );
	}

	// Create -----------

	/**
	 * @param ModelContent $content
	 * @param CmgFile $banner
	 * @return Page
	 */
	public static function create( $parent, $parentType, $content, $publish = false, $banner = null, $video = null ) {

		// Template
		if( isset( $content->templateId ) && $content->templateId <= 0 ) {

			$content->templateId = null;
		}

		// publish
    	if( $publish && !isset( $content->publishedAt ) ) {

			$date 	= DateUtil::getDateTime();

    		$content->publishedAt	= $date;
    	}

		// parent
		$content->parentId		= $parent->id;
		$content->parentType	= $parentType;

		FileService::saveFiles( $content, [ 'bannerId' => $banner, 'videoId' => $video ] );

		// Create Content
		$content->save();

		return $content;
	}

	// Update -----------

	/**
	 * @param ModelContent $content
	 * @param CmgFile $banner
	 * @return Page
	 */
	public static function update( $content, $publish = false, $banner = null, $video = null ) {

		// Template
		if( isset( $content->templateId ) && $content->templateId <= 0 ) {

			$content->templateId = null;
		}

		$contentToUpdate	= self::findById( $content->id );

		$contentToUpdate->copyForUpdateFrom( $content, [ 'bannerId', 'templateId', 'summary', 'content', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ] );

		// publish
    	if( $publish && !isset( $contentToUpdate->publishedAt ) ) {

			$date 	= DateUtil::getDateTime();

    		$contentToUpdate->publishedAt	= $date;
    	}

		FileService::saveFiles( $contentToUpdate, [ 'bannerId' => $banner, 'videoId' => $video ] );

		// Update Content
		$contentToUpdate->update();

		return $contentToUpdate;
	}

	public function updateBanner( $content, $banner ) {

		// Find existing content
		$contentToUpdate	= self::findById( $content->id );

		// Save Files
		FileService::saveFiles( $contentToUpdate, [ 'bannerId' => $banner ] );

		// Update User
		$contentToUpdate->update();

		// Return updated Content
		return $contentToUpdate;
	}

	// Delete -----------

	/**
	 * @param ModelContent $content
	 * @return boolean
	 */
	public static function delete( $content, $banner = null, $video = null ) {

		$existingContent	= self::findById( $content->id );

		// Delete Content
		$existingContent->delete();

		// Delete Files
		FileService::deleteFiles( [ $banner, $video ] );

		return true;
	}
}

?>