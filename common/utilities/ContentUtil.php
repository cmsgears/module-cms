<?php
namespace cmsgears\cms\common\utilities;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\services\PageService;

class ContentUtil {

	/**
	 * The method can be utilised by the Layouts for SEO purpose.
	 * @return array having SEO related details.
	 */
	public static function initPage( $view, $module = 'cmgcore', $controller = 'site' ) {

		$page = self::findViewPage( $view, $module, $controller );

		if( isset( $page ) ) {

			$coreProperties			= $view->context->getCoreProperties();

			$content				= $page->content;
			$view->params[ 'page']	= $page;
			$view->params[ 'desc']	= $content->seoDescription;
			$view->params[ 'meta']	= $content->seoKeywords;
			$view->params[ 'robot']	= $content->seoRobot;

			$siteTitle				= $coreProperties->getSiteTitle();

			if( isset( $content->seoName ) && strlen( $content->seoName ) > 0 ) {

				$view->title		= $siteTitle . " | " . $content->seoName;
			}
			else {

				$view->title		= $siteTitle . " | " . $page->name;
			}
		}
	}

	/**
	 * @return array - page details including content, author and banner.
	 */
	public static function getPageInfo( $view, $module = 'cmgcore', $controller = 'site' ) {

		$page = self::findViewPage( $view, $module, $controller );

		if( isset( $page ) ) {

			$info				= [];
			$info[ 'page']		= $page;
			$info[ 'content']	= $page->content;
			$info[ 'banner']	= $info[ 'content']->banner;
			$info[ 'author']	= $page->createdBy;

			return $info;
		}

		return null;
	}

	/**
	 * @return string - page summary
	 */
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
			$slugUrl		= Url::toRoute( "/$page->slug" );
			$summary		= $page->content->summary;
			$summary   	   .= "<div class='read-more'><a class='btn' href='$slugUrl'>Read More</a></div>";

			return $summary;
		}

		return '';
	}

	/**
	 * @return string - page content
	 */
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

	// helpers --------------------

	public static function findViewPage( $view, $module, $controller ) {

		$moduleName		= $view->context->module->id;
		$controllerName	= Yii::$app->controller->id;
		$actionName		= Yii::$app->controller->action->id;
		$page 			= null;

		// Module's Controller Pages
		if( strcmp( $moduleName, $module ) == 0 && strcmp( $controllerName, $controller ) == 0 ) {

			if( strcmp( $actionName, 'index' ) == 0 ) {

				$page	= self::getPage( 'home' );
			}
			else {

				$page	= self::getPage( $actionName );
			}
		}
		// CMS Pages
		else if( isset( Yii::$app->request->queryParams[ 'slug' ] ) ) {

			$actionName	= Yii::$app->request->queryParams[ 'slug' ];
			$page		= self::getPage( $actionName );
		}
		
		return $page;
	}

	/**
	 * @return Page based on given slug
	 */
	public static function getPage( $slug ) {

		$page 		= PageService::findBySlug( $slug );

		return $page;
	}
	
	// Additional method to init page for a model having content

	public static function initModelPage( $view, $serviceClass ) {

		$slug	= Yii::$app->request->queryParams[ 'slug' ];
		$object = Yii::createObject( $serviceClass );
		$model	= $object::findBySlug( $slug );

		if( isset( $model ) ) {

			$coreProperties			= $view->context->getCoreProperties();

			$content				= $model->content;
			$view->params[ 'page']	= $model;
			$view->params[ 'desc']	= $content->seoDescription;
			$view->params[ 'meta']	= $content->seoKeywords;
			$view->params[ 'robot']	= $content->seoRobot;

			$siteTitle				= $coreProperties->getSiteTitle();

			if( isset( $content->seoName ) && strlen( $content->seoName ) > 0 ) {

				$view->title		= $siteTitle . " | " . $content->seoName;
			}
			else {

				$view->title		= $siteTitle . " | " . $page->name;
			}
		}
	}
}

?>