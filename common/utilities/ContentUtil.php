<?php
namespace cmsgears\cms\common\utilities;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\services\PageService;

class ContentUtil {

	/**
	 * The method can be utilised by the Layouts for SEO purpose. It allows options to override default module and controller used for system pages.
	 * @param $view - The current view being rendered by controller.
	 * @param $module - The module to be considered for system pages.
	 * @param $controller - The site controller provided by given module to be considered for system pages.
	 * @return array having SEO related details.
	 */
	public static function initPage( $view, $module = 'cmgcore', $controller = 'site' ) {

		$page = self::findViewPage( $view, $module, $controller );

		if( isset( $page ) ) {

			$coreProperties				= $view->context->getCoreProperties();

			$content					= $page->content;

			// Page and Content
			$view->params[ 'page' ]		= $page;
			$view->params[ 'content' ]	= $content;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= $content->summary;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= $content->seoDescription;
			$view->params[ 'keywords' ]	= $content->seoKeywords;
			$view->params[ 'robot' ]	= $content->seoRobot;

			// SEO - Page Title
			$siteTitle					= $coreProperties->getSiteTitle();

			if( isset( $content->seoName ) && strlen( $content->seoName ) > 0 ) {

				$view->title		= $content->seoName . " | " . $siteTitle;
			}
			else if( isset( $page->name ) && strlen( $page->name ) > 0 ) {

				$view->title		= $page->name . " | " . $siteTitle;
			}
			else {
				
				$view->title		= $siteTitle;
			}
		}
	}

	/**
	 * The method can be utilised by the Layouts for SEO purpose. It can be used for models using content to render model pages apart from standard cms pages.
	 * @param $view - The current view being rendered by controller.
	 * @param $serviceClass - The service class for model to be used to find model.
	 * @return array having SEO related details.
	 */
	public static function initModelPage( $view, $serviceClass ) {

		$slug	= Yii::$app->request->queryParams[ 'slug' ];
		$object = Yii::createObject( $serviceClass );
		$model	= $object::findBySlug( $slug );

		if( isset( $model ) ) {

			$coreProperties				= $view->context->getCoreProperties();

			$content					= $model->content;

			// Page and Content
			$view->params[ 'page' ]		= $model;
			$view->params[ 'content' ]	= $content;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= $content->summary;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= $content->seoDescription;
			$view->params[ 'keywords' ]	= $content->seoKeywords;
			$view->params[ 'robot' ]	= $content->seoRobot;

			// SEO - Page Title
			$siteTitle					= $coreProperties->getSiteTitle();

			if( isset( $content->seoName ) && strlen( $content->seoName ) > 0 ) {

				$view->title		= $content->seoName . " | " . $siteTitle;
			}
			else if( isset( $page->name ) && strlen( $page->name ) > 0 ) {

				$view->title		= $page->name . " | " . $siteTitle;
			}
			else {
				
				$view->title		= $siteTitle;
			}
		}
	}

	/**
	 * It returns page info to be used for system pages. We can decorate system pages using either this method or standard blocks using block widget.
	 * @return array - page details including content, author and banner.
	 */
	public static function getPageInfo( $view, $module = 'cmgcore', $controller = 'site' ) {

		$page = self::findViewPage( $view, $module, $controller );

		if( isset( $page ) ) {

			$info				= [];
			$info[ 'page' ]		= $page;
			$info[ 'content' ]	= $page->content;

			return $info;
		}

		return null;
	}

	/**
	 * @return Page based on given slug
	 */
	public static function getPage( $slug ) {

		$page 		= PageService::findBySlug( $slug );

		return $page;
	}

	/**
	 * It returns page summary to be used in page blocks on other pages.
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
			$summary   	   .= "<div class='page-summary'>$summary</div>";
			$summary   	   .= "<div class='page-link'><a class='btn btn-medium' href='$slugUrl'>Read More</a></div>";

			return $summary;
		}

		return '';
	}

	/**
	 * It returns page full content to be used in page blocks on other pages.
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
			$content	= $content->content;
			$content   .= "<div class='page-content'>$content</div>";

			return $content;
		}

		return '';
	}

	public static function findViewPage( $view, $module, $controller ) {

		$moduleName		= $view->context->module->id;
		$controllerName	= Yii::$app->controller->id;
		$actionName		= Yii::$app->controller->action->id;
		$page 			= null;

		// System/Public Pages - Landing, Login, Register, Confirm Account, Activate Account, Forgot Password, Reset Password
		if( strcmp( $moduleName, $module ) == 0 && strcmp( $controllerName, $controller ) == 0 ) {

			if( strcmp( $actionName, 'index' ) == 0 ) {

				$page	= self::getPage( 'home' );
			}
			else {

				$page	= self::getPage( $actionName );
			}
		}
		// Blog/CMS Pages
		else if( isset( Yii::$app->request->queryParams[ 'slug' ] ) ) {

			$actionName	= Yii::$app->request->queryParams[ 'slug' ];
			$page		= self::getPage( $actionName );
		}

		return $page;
	}
}

?>