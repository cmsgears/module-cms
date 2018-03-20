<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\entities;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\interfaces\base\IApproval;
use cmsgears\core\common\models\interfaces\base\IAuthor;
use cmsgears\core\common\models\interfaces\base\IMultiSite;
use cmsgears\core\common\models\interfaces\base\INameType;
use cmsgears\core\common\models\interfaces\base\IOwner;
use cmsgears\core\common\models\interfaces\base\ISlugType;
use cmsgears\core\common\models\interfaces\base\IVisibility;
use cmsgears\core\common\models\interfaces\resources\IComment;
use cmsgears\core\common\models\interfaces\resources\IContent;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IGridCache;
use cmsgears\core\common\models\interfaces\mappers\IFile;
use cmsgears\core\common\models\interfaces\mappers\IGallery;
use cmsgears\cms\common\models\interfaces\resources\IPageContent;
use cmsgears\cms\common\models\interfaces\mappers\IBlock;
use cmsgears\cms\common\models\interfaces\mappers\IElement;
use cmsgears\cms\common\models\interfaces\mappers\IWidget;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\base\Entity;
use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\base\ApprovalTrait;
use cmsgears\core\common\models\traits\base\AuthorTrait;
use cmsgears\core\common\models\traits\base\MultiSiteTrait;
use cmsgears\core\common\models\traits\base\NameTypeTrait;
use cmsgears\core\common\models\traits\base\OwnerTrait;
use cmsgears\core\common\models\traits\base\SlugTypeTrait;
use cmsgears\core\common\models\traits\base\VisibilityTrait;
use cmsgears\core\common\models\traits\resources\CommentTrait;
use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;
use cmsgears\core\common\models\traits\mappers\FileTrait;
use cmsgears\core\common\models\traits\mappers\GalleryTrait;
use cmsgears\cms\common\models\traits\resources\PageContentTrait;
use cmsgears\cms\common\models\traits\mappers\BlockTrait;
use cmsgears\cms\common\models\traits\mappers\ElementTrait;
use cmsgears\cms\common\models\traits\mappers\WidgetTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * The Content is base class of Page and Post.
 *
 * @property integer $id
 * @property integer $siteId
 * @property integer $parentId
 * @property integer $createdBy
 * @property integer $modifiedBy
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property string $icon
 * @property string $texture
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $visibility
 * @property integer $order
 * @property integer $featured
 * @property integer $comments
 * @property date $createdAt
 * @property date $modifiedAt
 * @property string $content
 * @property string $data
 * @property string $gridCache
 * @property boolean $gridCacheValid
 * @property datetime $gridCachedAt
 *
 * @since 1.0.0
 */
class Content extends Entity implements IApproval, IAuthor, IBlock, IComment, IContent, IData, IElement,
	IFile, IGallery, IGridCache, IMultiSite, INameType, IOwner, IPageContent, ISlugType, IVisibility, IWidget {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $pageClass	= 'cmsgears\cms\common\models\entities\Page';

	public static $postClass	= 'cmsgears\cms\common\models\entities\Post';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use AuthorTrait;
	use BlockTrait;
	use CommentTrait;
	use ContentTrait;
	use DataTrait;
	use ElementTrait;
	use FileTrait;
	use GalleryTrait;
	use GridCacheTrait;
	use MultiSiteTrait;
	use NameTypeTrait;
	use OwnerTrait;
	use PageContentTrait;
	use SlugTypeTrait;
	use VisibilityTrait;
	use WidgetTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	/**
	 * @inheritdoc
	 */
	public function behaviors() {

		return [
			'authorBehavior' => [
				'class' => AuthorBehavior::class
			],
			'timestampBehavior' => [
				'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'createdAt',
				'updatedAtAttribute' => 'modifiedAt',
				'value' => new Expression('NOW()')
			],
			'sluggableBehavior' => [
				'class' => SluggableBehavior::class,
				'attribute' => 'name',
				'slugAttribute' => 'slug', // Unique for Site Id
				'ensureUnique' => true,
				'uniqueValidator' => [ 'targetAttribute' => 'siteId' ]
			]
		];
	}

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		// Model Rules
		$rules = [
			// Required, Safe
			[ [ 'siteId', 'name' ], 'required' ],
			[ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Text Limit
			[ 'type', 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ [ 'icon', 'texture' ], 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
			[ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
			[ 'slug', 'string', 'min' => 0, 'max' => Yii::$app->core->xxLargeText ],
			[ 'title', 'string', 'min' => 0, 'max' => Yii::$app->core->xxxLargeText ],
			[ 'description', 'string', 'min' => 0, 'max' => Yii::$app->core->xtraLargeText ],
			// Other
			[ [ 'status', 'visibility', 'order' ], 'number', 'integerOnly' => true, 'min' => 0 ],
			[ [ 'featured', 'comments', 'gridCacheValid' ], 'boolean' ],
			[ 'parentId', 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
			[ [ 'siteId', 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'createdAt', 'modifiedAt', 'gridCachedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
		];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'name', 'title', 'description' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
			'siteId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SITE ),
			'parentId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'createdBy' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AUTHOR ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'slug' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'texture' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TEXTURE ),
			'title' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'description' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'visibility' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'featured' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_FEATURED ),
			'comments' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_COMMENT ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	// yii\db\BaseActiveRecord

	/**
	 * @inheritdoc
	 */
	public function beforeSave( $insert ) {

		if( parent::beforeSave( $insert ) ) {

			if( $this->parentId <= 0 ) {

				$this->parentId = null;
			}

			if( !isset( $this->order ) || strlen( $this->order ) <= 0 ) {

				$this->order = 0;
			}

			return true;
		}

		return false;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Content -------------------------------

	/**
	 * Returns the immediate parent.
	 *
	 * @return Content
	 */
	public function getParent() {

		switch( $row['type'] ) {

			case self::TYPE_PAGE: {

				return $this->hasOne( Page::class, [ 'id' => 'parentId' ] );
			}
			case self::TYPE_POST: {

				return $this->hasOne( Post::class, [ 'id' => 'parentId' ] );
			}
		}
	}

	/**
	 * Returns meta and attributes.
	 *
	 * @return \cmsgears\cms\common\models\resources\ContentMeta[]
	 */
	public function getMetas() {

		return $this->hasMany( ContentMeta::class, [ 'pageId' => 'id' ] );
	}

	/**
	 * Check whether content type is page.
	 *
	 * @return boolean
	 */
	public function isPage() {

		return $this->type == CmsGlobal::TYPE_PAGE;
	}

	/**
	 * Check whether content type is post.
	 *
	 * @return boolean
	 */
	public function isPost() {

		return $this->type == CmsGlobal::TYPE_POST;
	}

	/**
	 * Check whether content is published.
	 *
	 * @return boolean
	 */
	public function isPublished() {

		$user	= Yii::$app->user->getIdentity();

		if( isset( $user ) && $this->createdBy == $user->id ) {

			return true;
		}

		return $this->isPublic() && $this->isVisibilityPublic();
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return CmsTables::getTableName( CmsTables::TABLE_PAGE );
	}

	// yii\db\BaseActiveRecord

	/**
	 * @inheritdoc
	 */
	public static function instantiate( $row ) {

		switch( $row[ 'type' ] ) {

			case CmsGlobal::TYPE_PAGE: {

				$class = static::$pageClass;

				break;
			}
			case CmsGlobal::TYPE_POST: {

				$class = static::$postClass;

				break;
			}
		}

		$model = new $class( null );

		return $model;
	}

	// CMG parent classes --------------------

	// Content -------------------------------

	// Read - Query -----------

	/**
	 * @inheritdoc
	 */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'modelContent', 'site', 'creator', 'modifier' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the content with author.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with author.
	 */
	public static function queryWithAuthor( $config = [] ) {

		$config[ 'relations' ][] = [ 'modelContent', 'creator' ];

		$config[ 'relations' ][] = [ 'creator.avatar'  => function ( $query ) {
			$fileTable	= CoreTables::getTableName( CoreTables::TABLE_FILE );
			$query->from( "$fileTable avatar" ); }
		];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
