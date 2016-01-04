<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\ModelContent;

use cmsgears\core\common\services\FileService;

use cmsgears\core\common\utilities\DateUtil;

class ModelContentService extends \cmsgears\core\common\services\Service {

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
		
		// template
		if( isset( $content->templateId ) && $content->templateId <= 0 ) {

			unset( $content->templateId );
		}
		
		// publish
    	if( $publish && !isset( $content->publishedAt ) ) {
			
			$date 	= DateUtil::getDateTime();

    		$content->publishedAt	= $date;
    	}
		
		// parent
		$content->parentId		= $parent->id;
		$content->parentType	= $parentType;
		
		// banner
		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $content, 'attribute' => 'bannerId' ] );
		}

		// video
		if( isset( $video ) ) {

			FileService::saveFile( $video, [ 'model' => $content, 'attribute' => 'videoId' ] );
		}

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
		
		// template
		if( isset( $content->templateId ) && $content->templateId <= 0 ) {

			unset( $content->templateId );
		}

		$contentToUpdate	= self::findById( $content->id );

		$contentToUpdate->copyForUpdateFrom( $content, [ 'bannerId', 'templateId', 'summary', 'content', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ] );
		
		// publish
    	if( $publish && !isset( $contentToUpdate->publishedAt ) ) {
			
			$date 	= DateUtil::getDateTime();

    		$contentToUpdate->publishedAt	= $date;
    	}

		// banner, video

		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $contentToUpdate, 'attribute' => 'bannerId' ] );
		}

		if( isset( $video ) ) {

			FileService::saveImage( $video, [ 'model' => $contentToUpdate, 'attribute' => 'videoId' ] );
		}
		
		// Update Content
		$contentToUpdate->update();

		return $contentToUpdate;
	}

	// Delete -----------

	/**
	 * @param ModelContent $content
	 * @return boolean
	 */
	public static function delete( $content ) {

		$existingContent	= self::findById( $content->id );

		// Delete Content
		$existingContent->delete();

		return true;
	}
}

?>