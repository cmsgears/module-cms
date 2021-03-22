<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\resources;

// Yii Imports
use Yii;
use yii\base\Exception;
use yii\data\Sort;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\services\interfaces\resources\IFormService;

/**
 * FormService provide service methods of category model.
 *
 * @since 1.0.0
 */
class FormService extends \cmsgears\forms\common\services\resources\FormService implements IFormService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\cms\common\models\resources\Form';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CategoryService -----------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$searchParam	= $config[ 'search-param' ] ?? 'keywords';
		$searchColParam	= $config[ 'search-col-param' ] ?? 'search';

		$defaultSort = isset( $config[ 'defaultSort' ] ) ? $config[ 'defaultSort' ] : [ 'id' => SORT_DESC ];

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$contentTable	= Yii::$app->factory->get( 'modelContentService' )->getModelTable();
		$templateTable	= Yii::$app->factory->get( 'templateService' )->getModelTable();

		// Sorting ----------

		$sort = new Sort([
			'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				],
	            'template' => [
	                'asc' => [ "$templateTable.name" => SORT_ASC ],
	                'desc' => [ "$templateTable.name" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Template'
	            ],
				'name' => [
					'asc' => [ "$modelTable.name" => SORT_ASC ],
					'desc' => [ "$modelTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Name'
				],
				'slug' => [
					'asc' => [ "$modelTable.slug" => SORT_ASC ],
					'desc' => [ "$modelTable.slug" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Slug'
				],
	            'type' => [
	                'asc' => [ "$modelTable.type" => SORT_ASC ],
	                'desc' => [ "$modelTable.type" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Type'
	            ],
	            'icon' => [
	                'asc' => [ "$modelTable.icon" => SORT_ASC ],
	                'desc' => [ "$modelTable.icon" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Icon'
	            ],
				'title' => [
					'asc' => [ "$modelTable.title" => SORT_ASC ],
					'desc' => [ "$modelTable.title" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Title'
				],
				'captcha' => [
					'asc' => [ "$modelTable.captcha" => SORT_ASC ],
					'desc' => [ "$modelTable.captcha" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Captcha'
				],
				'visibility' => [
					'asc' => [ "$modelTable.visibility" => SORT_ASC ],
					'desc' => [ "$modelTable.visibility" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Visibility'
				],
				'status' => [
					'asc' => [ "$modelTable.status" => SORT_ASC ],
					'desc' => [ "$modelTable.status" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Status'
				],
				'umail' => [
					'asc' => [ "$modelTable.userMail" => SORT_ASC ],
					'desc' => [ "$modelTable.userMail" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'User Mail'
				],
				'amail' => [
					'asc' => [ "$modelTable.adminMail" => SORT_ASC ],
					'desc' => [ "$modelTable.adminMail" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Admin Mail'
				],
				'uqsubmit' => [
					'asc' => [ "$modelTable.uniqueSubmit" => SORT_ASC ],
					'desc' => [ "$modelTable.uniqueSubmit" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Unique Submit'
				],
				'upsubmit' => [
					'asc' => [ "$modelTable.updateSubmit" => SORT_ASC ],
					'desc' => [ "$modelTable.updateSubmit" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Update Submit'
				],
				'cdate' => [
					'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
					'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Created At'
				],
				'udate' => [
					'asc' => [ "$modelTable.modifiedAt" => SORT_ASC ],
					'desc' => [ "$modelTable.modifiedAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Updated At'
				],
				'pdate' => [
					'asc' => [ "$contentTable.publishedAt" => SORT_ASC ],
					'desc' => [ "$contentTable.publishedAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Published At'
				]
			],
			'defaultOrder' => $defaultSort
		]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'query' ] = $modelClass::queryWithContent();
		}

		// Filters ----------

		// Params
		$type	= Yii::$app->request->getQueryParam( 'type' );
		$status	= Yii::$app->request->getQueryParam( 'status' );
		$filter	= Yii::$app->request->getQueryParam( 'model' );

		// Filter - Type
		if( isset( $type ) ) {

			$config[ 'conditions' ][ "$modelTable.type" ] = $type;
		}

		// Filter - Status
		if( isset( $status ) && isset( $modelClass::$urlRevStatusMap[ $status ] ) ) {

			$config[ 'conditions' ][ "$modelTable.status" ]	= $modelClass::$urlRevStatusMap[ $status ];
		}

		// Filter - Model
		if( isset( $filter ) ) {

			switch( $filter ) {

				case 'captcha': {

					$config[ 'conditions' ][ "$modelTable.captcha" ] = true;

					break;
				}
				case 'umail': {

					$config[ 'conditions' ][ "$modelTable.userMail" ] = true;

					break;
				}
				case 'amail': {

					$config[ 'conditions' ][ "$modelTable.adminMail" ] = true;

					break;
				}
				case 'uqsubmit': {

					$config[ 'conditions' ][ "$modelTable.uniqueSubmit" ] = true;

					break;
				}
				case 'upsubmit': {

					$config[ 'conditions' ][ "$modelTable.updateSubmit" ] = true;

					break;
				}
			}
		}

		// Searching --------

		$searchCol		= Yii::$app->request->getQueryParam( $searchColParam );
		$keywordsCol	= Yii::$app->request->getQueryParam( $searchParam );

		$search = [
			'name' => "$modelTable.name",
			'title' => "$modelTable.title",
			'desc' => "$modelTable.description",
			'success' => "$modelTable.success",
			'failure' => "$modelTable.failure",
			'summary' => "modelContent.summary",
			'content' => "modelContent.content"
		];

		if( isset( $searchCol ) ) {

			$config[ 'search-col' ] = $config[ 'search-col' ] ?? $search[ $searchCol ];
		}
		else if( isset( $keywordsCol ) ) {

			$config[ 'search-col' ] = $config[ 'search-col' ] ?? $search;
		}

		// Reporting --------

		$config[ 'report-col' ]	= $config[ 'report-col' ] ?? [
			'name' => "$modelTable.name",
			'title' => "$modelTable.title",
			'desc' => "$modelTable.description",
			'success' => "$modelTable.success",
			'failure' => "$modelTable.failure",
			'summary' => "modelContent.summary",
			'content' => "modelContent.content",
			'captcha' => "$modelTable.captcha",
			'status' => "$modelTable.status",
			'visibility' => "$modelTable.visibility",
			'umail' => "$modelTable.userMail",
			'amail' => "$modelTable.adminMail",
			'uqsubmit' => "$modelTable.uniqueSubmit",
			'upsubmit' => "$modelTable.updateSubmit"
		];

		// Result -----------

		return parent::findPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getWithContentById( $id, $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$config[ 'conditions' ][ "$modelTable.id" ]	= $id;

		return $modelClass::queryWithContent( $config )->one();
	}

	public function getWithContentBySlug( $slug, $config = [] ) {

		$siteId		= isset( $config[ 'siteId' ] ) ? $config[ 'siteId' ] : Yii::$app->core->siteId;
		$ignoreSite	= isset( $config[ 'ignoreSite' ] ) ? $config[ 'ignoreSite' ] : false;

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		if( $modelClass::isMultiSite() && !$ignoreSite ) {

			$config[ 'conditions' ][ "$modelTable.siteId" ]	= $siteId;
		}

		$config[ 'conditions' ][ "$modelTable.slug" ] = $slug;

		return $modelClass::queryWithContent( $config )->one();
	}

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function add( $model, $config = [] ) {

		return $this->register( $model, $config );
	}

	public function register( $model, $config = [] ) {

		$content 	= $config[ 'content' ];
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner 	= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo 	= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );

		$galleryClass = $galleryService->getModelClass();

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Copy Template
			$config[ 'template' ] = $content->template;

			$this->copyTemplate( $model, $config );

			// Create Model
			$model = $this->create( $model, $config );

			// Create Gallery
			if( isset( $gallery ) ) {

				$gallery->siteId	= $model->siteId;
				$gallery->type		= static::$parentType;
				$gallery->status	= $galleryClass::STATUS_ACTIVE;

				$gallery = $galleryService->create( $gallery );
			}
			else {

				$gallery = $galleryService->createByParams([
					'siteId' => $model->siteId,
					'type' => static::$parentType, 'status' => $galleryClass::STATUS_ACTIVE,
					'name' => $model->name, 'title' => $model->title
				]);
			}

			// Create and attach model content
			$modelContentService->create( $content, [
				'parent' => $model, 'parentType' => CoreGlobal::TYPE_FORM,
				'publish' => $publish,
				'banner' => $banner, 'video' => $video, 'gallery' => $gallery
			]);

			$transaction->commit();

			return $model;
		}
		catch( Exception $e ) {

			$transaction->rollBack();
		}

		return false;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$content 	= $config[ 'content' ];
		$admin 		= isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner 	= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo 	= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;

		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [
			'templateId', 'name', 'slug', 'icon', 'texture', 'title', 'description',
			'success', 'failure', 'captcha', 'visibility', 'status',
			'userMail', 'adminMail', 'uniqueSubmit', 'updateSubmit',
			'htmlOptions', 'content'
		];

		if( $admin ) {

			$attributes	= ArrayHelper::merge( $attributes, [ 'status' ] );
		}

		// Copy Template
		$config[ 'template' ] = $content->template;

		if( $this->copyTemplate( $model, $config ) ) {

			$attributes[] = 'data';
		}

		// Services
		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );

		// Create/Update gallery
		if( isset( $gallery ) ) {

			$gallery = $galleryService->createOrUpdate( $gallery );
		}

		// Update model content
		$modelContentService->update( $content, [
			'publish' => $publish,
			'banner' => $banner, 'mbanner' => $mbanner,
			'video' => $video, 'mvideo' => $mvideo,
			'gallery' => $gallery
		]);

		return parent::update( $model, [
			'attributes' => $attributes
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$config[ 'hard' ] = $config[ 'hard' ] ?? !Yii::$app->core->isSoftDelete();

		if( $config[ 'hard' ] ) {

			$transaction = Yii::$app->db->beginTransaction();

			try {

				// Delete Model Files
				$this->fileService->deleteMultiple( $model->files );

				// Delete Model Content
				Yii::$app->factory->get( 'modelContentService' )->delete( $model->modelContent );

				// Delete mappings
				Yii::$app->factory->get( 'modelFormService' )->deleteByModelId( $model->id );

				// Delete Fields
				Yii::$app->factory->get( 'formFieldService' )->deleteByFormId( $model->id );

				// Commit
				$transaction->commit();

				$config[ 'hard' ] = false;
			}
			catch( Exception $e ) {

				$transaction->rollBack();

				throw new Exception( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_DEPENDENCY )  );
			}
		}

		// Delete model
		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// CategoryService -----------------------

	// Data Provider ------

	public static function findPageForSearch( $config = [] ) {

		// Search
		$searchContent	= isset( $config[ 'searchContent' ] ) ? $config[ 'searchContent' ] : false;
		$keywordsParam	= isset( $config[ 'search-param' ] ) ? $config[ 'search-param' ] : 'keywords';
		$keywords 		= Yii::$app->request->getQueryParam( $keywordsParam );

		$modelClass	= static::$modelClass;
		$modelTable	= $modelClass::tableName();
		$parentType	= static::$parentType;

		// Search
		if( $searchContent && isset( $keywords ) ) {

			$cache = CacheProperties::getInstance()->isCaching();

			// Search in model cache - full search
			if( $cache ) {

				$config[ 'search-col' ][] = "$modelTable.gridCache";
			}
			// Search in model content only
			else {

				// Search Query
				$config[ 'query' ] = isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::queryWithAll( [ 'relations' => [ 'modelContent', 'modelContent.template' ] ] );

				// Search in model content
				$config[ 'search-col' ][] = 'modelContent.content';
			}
		}

		return parent::findPageForSearch( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
