<?php
namespace cmsgears\modules\cms\common\models\entities;

// project imports
use cmsgears\modules\core\common\models\entities\NamedActiveRecord;
use cmsgears\modules\core\common\models\entities\CmgFile;
use cmsgears\modules\core\common\models\entities\User;

use cmsgears\modules\core\common\utilities\MessageUtil;

class Content extends NamedActiveRecord {

	// Pre-Defined Types
	const TYPE_PAGE		= 0;
	const TYPE_POST		= 1;

	public static $typeMap = [
		self::TYPE_PAGE => "page",
		self::TYPE_POST => "post"
	];

	// Pre-Defined Status
	const STATUS_NEW		= 0;
	const STATUS_PUBLISHED	= 1;

	public static $statusMap = [
		self::STATUS_NEW => "new",
		self::STATUS_PUBLISHED => "published"
	];

	// Pre-Defined Visibility
	const VISIBILITY_PRIVATE	= 0;
	const VISIBILITY_PUBLIC		= 1;

	public static $visibilityMap = [
		self::VISIBILITY_PRIVATE => "private",
		self::VISIBILITY_PUBLIC => "public"
	];

	// Instance Methods --------------------------------------------
	
	// db columns
	
	public function getId() {

		return $this->page_id;
	}

	public function getAuthorId() {

		return $this->page_author;
	}

	public function getAuthor() {

		return $this->hasOne( User::className(), [ 'user_id' => 'page_author' ] );
	}

	public function setAuthorId( $authorId ) {

		$this->page_author = $authorId;
	}

	public function getBannerId() {

		return $this->page_banner;
	}

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'file_id' => 'page_banner' ] );
	}

	public function setBannerId( $bannerId ) {

		$this->page_banner = $bannerId;
	}

	public function getBannerWithAlias() {

		return $this->hasOne( CmgFile::className(), [ 'file_id' => 'page_banner' ] )->from( 'cmg_file banner' );
	}

	public function getName() {
		
		return $this->page_name;	
	}

	public function setName( $name ) {
		
		$this->page_name = $name;
	}

	public function getDesc() {
		
		return $this->page_desc;	
	}

	public function setDesc( $desc ) {
		
		$this->page_desc = $desc;
	}

	public function getSlug() {
		
		return $this->page_slug;	
	}

	public function setSlug( $slug ) {
		
		$this->page_slug = $slug;
	}

	public function getType() {

		return $this->page_type;	
	}

	public function getTypeStr() {

		return self::$typeMap[ $this->page_type ];	
	}

	public function setType( $type ) {
		
		$this->page_type = $type;
	}

	public function getStatus() {
		
		return $this->page_status;
	}
	
	public function getStatusStr() {
		
		return self::$statusMap[ $this->page_status ];
	}

	public function setStatus( $status ) {

		$this->page_status = $status;
	}

	public function isPublished() {
		return $this->page_status == self::STATUS_PUBLISHED;
	}

	public function getVisibility() {
		
		return $this->page_visibility;
	}
	
	public function getVisibilityStr() {
		
		return self::$visibilityMap[ $this->page_visibility ];
	}

	public function setVisibility( $visibility ) {

		$this->page_visibility = $visibility;
	}

	public function getSummary() {
		
		return $this->page_summary;	
	}
	
	public function setSummary( $summary ) {
		
		$this->page_summary = $summary;	
	}

	public function getContent() {
		
		return $this->page_content;
	}

	public function setContent( $content ) {
		
		$this->page_content = $content;	
	}

	public function getCreatedOn() {
		
		return $this->page_created_on;
	}
	
	public function setCreatedOn( $date ) {
		
		$this->page_created_on = $date;
	}

	public function getPublishedOn() {
		
		return $this->page_published_on;
	}

	public function setPublishedOn( $publishedOn ) {

		$this->page_published_on = $publishedOn;
	}

	public function getUpdatedOn() {
		
		return $this->page_updated_on;
	}
	
	public function setUpdatedOn( $updatedOn ) {
		
		$this->page_updated_on = $updatedOn;
	}

	public function getMetaTags() {
		
		return $this->page_meta_tags;
	}
	
	public function setMetaTags( $metaTags ) {
		
		$this->page_meta_tags = $metaTags;
	}

	public function getTemplate() {
		
		return $this->page_template;
	}

	public function setTemplate( $template ) {

		$this->page_template = $template;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'page_name' ], 'required' ],
            [ 'page_name', 'alphanumhyphenspace' ],
            [ 'page_name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'page_name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'page_author', 'page_banner', 'page_desc', 'page_type', 'page_visibility', 'page_status', 'page_summary', 'page_content', 'page_created_on', 
                'page_published_on', 'page_updated_on', 'page_meta_tags', 'page_template' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'page_name' => 'Name',
			'page_desc' => 'Description',
			'page_slug' => 'Slug',
			'page_template' => 'Template',
			'page_summary' => 'Summary',
			'page_meta_tags' => 'Keywords',
			'page_content' => ''
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CMSTables::TABLE_PAGE;
	}

	// yii\db\BaseActiveRecord
    public static function instantiate( $row ) {
		
		switch( $row['page_type'] ) {
			
			case self::TYPE_PAGE:
			{
				$class = 'cmsgears\modules\cms\common\models\entities\Page';

				break;
			}
			case self::TYPE_POST:
			{
				$class = 'cmsgears\modules\cms\common\models\entities\Post';

				break;
			}
		}

		$model = new $class( null );

        return $model;
    }
}

?>