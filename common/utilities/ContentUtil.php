<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\utilities;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\config\CoreProperties;
use cmsgears\cms\common\config\CmsProperties;

/**
 * ContentUtil generates the meta data for pages, posts and models. The generated data
 * can be used for SEO purpose.
 *
 * @since 1.0.0
 */
class ContentUtil {

	/**
	 * Generates the meta data of Page or Post.
	 *
	 * @param \yii\web\View $view The current view being rendered by controller.
	 * @param array $config
	 * @return array having page meta data.
	 */
	public static function initPage( $view, $config = [] ) {

		$page = self::findViewPage( $view, $config );

		if( isset( $page ) ) {

			$coreProperties = CoreProperties::getInstance();
			$cmsProperties	= CmsProperties::getInstance();

			$content = $page->modelContent;

			// Page and Content
			$view->params[ 'page' ]		= $page;
			$view->params[ 'content' ]	= $content;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= $content->summary;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= isset( $content->seoDescription ) ? $content->seoDescription : $page->description;
			$view->params[ 'keywords' ]	= $content->seoKeywords;
			$view->params[ 'robot' ]	= $content->seoRobot;

			// SEO - Page Title
			$siteTitle		= $coreProperties->getSiteTitle();
			$titleSeparator	= $cmsProperties->getTitleSeparator();
			$seoName		= !empty( $content->seoName ) ? $content->seoName : $page->name;

			if( $cmsProperties->isSiteTitle() ) {

				if( $cmsProperties->isAppendTitle() ) {

					$view->title = "$seoName $titleSeparator $siteTitle";
				}
				else {

					$view->title = "$siteTitle $titleSeparator $seoName";
				}
			}
			else {

				$view->title = $content->seoName;
			}
		}
	}

	/**
	 * Generates the meta data of Model using SEO Data.
	 *
	 * @param \yii\web\View $view The current view being rendered by controller.
	 * @param array $config
	 * @return array having model meta data.
	 */
	public static function initModel( $view, $config = [] ) {

		$model = self::findModel( $config );

		if( isset( $model ) ) {

			$coreProperties = CoreProperties::getInstance();
			$cmsProperties	= CmsProperties::getInstance();
			$seoData		= $model->getDataMeta( CoreGlobal::DATA_SEO );

			// Model
			$view->params[ 'model' ]	= $model;
			$view->params[ 'content' ]	= $seoData;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= isset( $seoData ) && !empty( $seoData->summary ) ? $seoData->summary : $model->description;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= isset( $seoData ) && !empty( $seoData->description ) ? $seoData->description : $model->description;
			$view->params[ 'keywords' ]	= isset( $seoData ) && !empty( $seoData->keywords ) ? $seoData->keywords : null;
			$view->params[ 'robot' ]	= isset( $seoData ) && !empty( $seoData->robot ) ? $seoData->robot : null;

			// SEO - Page Title
			$siteTitle		= $coreProperties->getSiteTitle();
			$titleSeparator	= $cmsProperties->getTitleSeparator();
			$seoName		= isset( $seoData ) && !empty( $seoData->name ) ? $seoData->name : $model->name;

			if( $cmsProperties->isSiteTitle() ) {

				if( $cmsProperties->isAppendTitle() ) {

					$view->title = "$seoName $titleSeparator $siteTitle";
				}
				else {

					$view->title = "$siteTitle $titleSeparator $seoName";
				}
			}
			else {

				$view->title = $model->seoName;
			}
		}
	}

	/**
	 * Generates the meta data of Model using model content.
	 *
	 * @param \yii\web\View $view The current view being rendered by controller.
	 * @param array $config
	 * @return array having model meta data.
	 */
	public static function initModelPage( $view, $config = [] ) {

		$model = self::findModel( $config );

		if( isset( $model ) ) {

			$coreProperties = CoreProperties::getInstance();
			$cmsProperties	= CmsProperties::getInstance();
			$seoData		= $model->getDataMeta( CoreGlobal::DATA_SEO );

			$content = $model->modelContent;

			// Model
			$view->params[ 'model' ]	= $model;
			$view->params[ 'content' ]	= $content;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= $content->summary;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= isset( $content->seoDescription ) ? $content->seoDescription : $model->description;
			$view->params[ 'keywords' ]	= $content->seoKeywords;
			$view->params[ 'robot' ]	= $content->seoRobot;

			// SEO - Page Title
			$siteTitle		= $coreProperties->getSiteTitle();
			$titleSeparator	= $cmsProperties->getTitleSeparator();
			$seoName		= !empty( $content->seoName ) ? $content->seoName : $model->name;

			if( $cmsProperties->isSiteTitle() ) {

				if( $cmsProperties->isAppendTitle() ) {

					$view->title = "$seoName $titleSeparator $siteTitle";
				}
				else {

					$view->title = "$siteTitle $titleSeparator $seoName";
				}
			}
			else {

				$view->title = $model->seoName;
			}
		}
	}

	/**
	 * Find and return the view according to the configuration passed to it.
	 *
	 * @param \yii\web\View $view
	 * @param array $config
	 * @return \cmsgears\cms\common\models\entities\Content
	 */
	public static function findViewPage( $view, $config = [] ) {

		$module			= isset( $config[ 'module' ] ) ? $config[ 'module' ] : 'core'; // The module used for pages.
		$controller		= isset( $config[ 'controller' ] ) ? $config[ 'controller' ] : 'site'; // The controller used for pages.

		$moduleName		= $view->context->module->id;
		$controllerName	= Yii::$app->controller->id;
		$actionName		= Yii::$app->controller->action->id;

		$page = null;

		// System/Public Pages - Landing, Login, Register, Confirm Account, Activate Account, Forgot Password, Reset Password
		if( $moduleName == $module && $controllerName == $controller ) {

			if( $actionName == 'index' ) {

				$page = self::getPage( 'home' );
			}
			else {

				$page = self::getPage( $actionName );
			}
		}
		// Blog/CMS Pages
		else if( isset( Yii::$app->request->queryParams[ 'slug' ] ) ) {

			$type = isset( $config[ 'type' ] ) ? $config[ 'type' ] : CmsGlobal::TYPE_POST;

			$page = self::getPage( Yii::$app->request->queryParams[ 'slug' ], $type );
		}

		return $page;
	}

	/**
	 * @return Page based on given slug
	 */
	public static function getPage( $slug, $type = CmsGlobal::TYPE_PAGE ) {

		return Yii::$app->factory->get( 'pageService' )->getBySlugType( $slug, $type );
	}

	public static function findModel( $config ) {

		$model = null;

		if( isset( $config[ 'model' ] ) ){

			$model = $config[ 'model' ];
		}
		else {

			$service	= Yii::$app->factory->get( $config[ 'service' ] );
			$typed		= isset( $config[ 'typed' ] ) ? $config[ 'typed' ] : true;
			$type		= isset( $config[ 'type' ] ) ? $config[ 'type' ] : $service->getParentType();
			$slug		= Yii::$app->request->queryParams[ 'slug' ];

			if( $typed ) {

				$model = $service->getBySlugType( $slug, $type );
			}
			else {

				$model = $service->getBySlug( $slug );
			}
		}

		return $model;
	}

}
