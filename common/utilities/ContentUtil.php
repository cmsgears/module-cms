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

			$page	= self::getPage( 'home' );
		}
		// Other Pages
		else {

			$page	= self::getPage( $actionName );
		}

		if( isset( $page ) ) {

			$coreProperties			= $view->context->getCoreProperties();

			$view->params[ 'page']	= $page;
			$view->params[ 'desc']	= $page->seoDescription;
			$view->params[ 'meta']	= $page->seoKeywords;
			$view->params[ 'robot']	= $page->seoRobot;

			$siteTitle				= $coreProperties->getSiteTitle();
			$view->title			= $siteTitle . " | " . $page->seoName;
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
			$slugUrl		= $coreProperties->getSiteUrl() . $page->slug;
			$summary		= $page->content->summary;
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

			$content	= $page->content;

			return $content;
		}

		return '';
	}
}

?>