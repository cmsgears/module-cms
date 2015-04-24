<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedCmgEntity;
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\User;

class Content extends NamedCmgEntity {

	// Pre-Defined Types
	const TYPE_PAGE		= 0;
	const TYPE_POST		= 5;

	public static $typeMap = [
		self::TYPE_PAGE => "page",
		self::TYPE_POST => "post"
	];

	// Pre-Defined Status
	const STATUS_NEW		= 0;
	const STATUS_PUBLISHED	= 5;

	public static $statusMap = [
		self::STATUS_NEW => "new",
		self::STATUS_PUBLISHED => "published"
	];

	// Pre-Defined Visibility
	const VISIBILITY_PRIVATE	= 0;
	const VISIBILITY_PUBLIC		= 5;

	public static $visibilityMap = [
		self::VISIBILITY_PRIVATE => "private",
		self::VISIBILITY_PUBLIC => "public"
	];

	// Instance Methods --------------------------------------------
	
	public function getParent() {

		switch( $row['type'] ) {

			case self::TYPE_PAGE: {

				return $this->hasOne( Page::className(), [ 'id' => 'parentId' ] );
			}
			case self::TYPE_POST: {

				return $this->hasOne( Post::className(), [ 'id' => 'parentId' ] );
			}
		}
	}

	public function getAuthor() {

		return $this->hasOne( User::className(), [ 'id' => 'authorId' ] );
	}

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'bannerId' ] );
	}

	public function getBannerWithAlias() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'bannerId' ] )->from( 'cmg_file banner' );
	}

	public function getTemplate() {

		return $this->hasOne( Template::className(), [ 'id' => 'templateId' ] );
	}

	public function getTemplateName() {

		$template = $this->template;
		
		if( isset( $template ) ) {
			
			return $template->name;
		}
		else {
			
			return '';
		}
	}

	public function getTags() {

    	return $this->hasMany( Tag::className(), [ 'id' => 'tagId' ] )
					->viaTable( CMSTables::TABLE_PAGE_TAG, [ 'pageId' => 'id' ] );
	}

	public function getTagsMap() {

    	$tags		= $this->tags;
		$tagsMap	= [];

		foreach ( $tags as $tag ) {

			$tagsMap[ $tag->name ] = $tag->description; 
		}

		return $tagsMap;
	}

	public function getTagsCsv() {

    	$tags		= $this->tags;
		$tagsCsv	= [];

		foreach ( $tags as $tag ) {

			$tagsCsv[] = $tag->name; 
		}

		return implode( ",", $tagsCsv );
	}

	public function getFiles() {

    	return $this->hasMany( CmgFile::className(), [ 'id' => 'fileId' ] )
					->viaTable( CMSTables::TABLE_PAGE_FILE, [ 'pageId' => 'id' ] );
	}

	public function getTypeStr() {

		return self::$typeMap[ $this->type ];	
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->status ];
	}

	public function isNew() {

		return $this->status == self::STATUS_NEW;
	}

	public function isPublished() {

		return $this->status == self::STATUS_PUBLISHED;
	}
	
	public function getVisibilityStr() {
		
		return self::$visibilityMap[ $this->visibility ];
	}

	public function isPrivate() {

		return $this->visibility == self::VISIBILITY_PRIVATE;
	}

	public function isPublic() {

		return $this->visibility == self::VISIBILITY_PUBLIC;
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'parentId', 'authorId', 'bannerId', 'templateId', 'description', 'type', 'visibility', 'status' ], 'safe' ], 
            [ [ 'id', 'summary', 'content', 'createdAt', 'publishedAt', 'updatedAt' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'parentId' => 'Parent Page',
			'authorId' => 'Author',
			'bannerId' => 'Banner',
			'templateId' => 'Template',
			'name' => 'Name',
			'description' => 'Description',
			'type' => 'Type',
			'visibility' => 'Visibility', 
			'status' => 'Status',
			'slug' => 'Slug',
			'summary' => 'Summary',
			'content' => 'Content'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_PAGE;
	}

	// yii\db\BaseActiveRecord
    public static function instantiate( $row ) {
		
		switch( $row['type'] ) {
			
			case self::TYPE_PAGE:
			{
				$class = 'cmsgears\cms\common\models\entities\Page';

				break;
			}
			case self::TYPE_POST:
			{
				$class = 'cmsgears\cms\common\models\entities\Post';

				break;
			}
		}

		$model = new $class( null );

        return $model;
    }
}

?>