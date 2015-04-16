<?php
namespace cmsgears\cms\common\utilities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\services\PageService;

class ContentUtility {

	public static function getPageSummary( $slug ) {

		$page 		= PageService::findBySlug( $slug );

		if( isset( $page ) ) {
			
			$coreProperties	= Yii::$app->controller->getCoreProperties();
			$slugUrl		= $coreProperties->getSiteUrl() . $page->getSlug();
			$summary		= $page->getSummary();
			$summary   	   .= "<div class='read-more'><a class='btn' href='$slugUrl'>Read More</a></div>";

			return $summary;
		}

		return '';
	}

	public static function getPageContent( $slug ) {
		
		$page 		= PageService::findBySlug( $slug );
		
		if( isset( $page ) ) {

			$content	= $page->getContent();
			
			return $content;
		}
		
		return '';
	}
}

?>