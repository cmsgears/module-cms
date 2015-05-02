<?php
namespace cmsgears\cms\common\utilities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\services\PageService;

class ContentUtil {

	public static function initPage( $view ) {

		$moduleName		= $view->context->module->id;
		$controllerName	= Yii::$app->controller->id;
		$actionName		= Yii::$app->controller->action->id;

		// Landing Page
		if( strcmp( $moduleName, 'cmgcore' ) == 0 && strcmp( $controllerName, 'site' ) == 0 && strcmp( $actionName, 'index' ) == 0 ) {

			$page	= ContentUtil::getPage( "home" );
		}
		// Other Pages
		else {
			
			$page	= ContentUtil::getPage( $actionName );
		}

		if( isset( $page ) ) {
			
			$coreProperties			= $view->context->getCoreProperties();
			$view->params[ 'page']	= $page;
			$view->params[ 'desc']	= $page->description;
			$view->params[ 'meta']	= $page->keywords;
			$siteTitle				= $coreProperties->getSiteTitle();
			$view->title			= $siteTitle . " | " . $page->name;
		}
	}

	public static function getPage( $slug ) {

		$page 		= PageService::findBySlug( $slug );

		return $page;
	}

	public static function getPageSummary( $config = [] ) {
		
		if( isset( $config[ 'slug' ] ) ) {

			$slug	= $config[ 'slug' ];
			$page 	= PageService::findBySlug( $slug );
		}

		if( isset( $config[ 'page' ] ) ) {

			$page	= $config[ 'page' ];
		}

		if( isset( $page ) ) {
			
			$coreProperties	= Yii::$app->controller->getCoreProperties();
			$slugUrl		= $coreProperties->getSiteUrl() . $page->getSlug();
			$summary		= $page->getSummary();
			$summary   	   .= "<div class='read-more'><a class='btn' href='$slugUrl'>Read More</a></div>";

			return $summary;
		}

		return '';
	}

	public static function getPageContent( $config = [] ) {
		
		if( isset( $config[ 'slug' ] ) ) {

			$slug	= $config[ 'slug' ];
			$page 	= PageService::findBySlug( $slug );
		}

		if( isset( $config[ 'page' ] ) ) {

			$page	= $config[ 'page' ];
		}
		
		if( isset( $page ) ) {

			$content	= $page->getContent();
			
			return $content;
		}
		
		return '';
	}
}

?>