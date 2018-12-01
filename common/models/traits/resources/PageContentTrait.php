<?php
namespace cmsgears\cms\common\models\traits\resources;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\resources\ModelContent;

/**
 * PageContentTrait can be used to add seo optimised content to relevant models to form public pages.
 */
trait PageContentTrait {

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii classes ---------------------------

	// CMG interfaces ------------------------

	// CMG classes ---------------------------

	// Validators ----------------------------

	// ContentTrait --------------------------

	/**
	 * @return ModelContent associated with parent.
	 */
	public function getModelContent() {

		$modelContentTable = CmsTables::TABLE_MODEL_CONTENT;

		return $this->hasOne( ModelContent::className(), [ 'parentId' => 'id' ] )
			->from( "$modelContentTable as modelContent" )
			->where( "modelContent.parentType='$this->modelType'" );
	}

	public function getTemplateViewPath() {

		$content	= $this->content;
		$template	= $content->template;

		return $template->viewPath;
	}

	/**
	 * Check whether content is published.
	 *
	 * @return boolean
	 */
	public function isPublished() {

		$user = Yii::$app->core->getUser();

		if( isset( $user ) && $this->createdBy == $user->id ) {

			return true;
		}

		// Status & Visibility(Protected OR Public)
		return $this->isPublic() && ( $this->isVisibilityProtected() || $this->isVisibilityPublic() );
	}

	// Static Methods ----------------------------------------------

	// Yii classes ---------------------------

	// CMG classes ---------------------------

	// ContentTrait --------------------------

	// Read - Query -----------

	/**
	 * Return query to find the model with content.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with content.
	 */
	public static function queryWithContent( $config = [] ) {

		$config[ 'relations' ]	= [ 'modelContent', 'modelContent.template' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with content, template, banner, video and gallery.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with content, banner, video and gallery.
	 */
	public static function queryWithFullContent( $config = [] ) {

		$config[ 'relations' ]	= [ 'modelContent', 'modelContent.template', 'modelContent.banner', 'modelContent.video', 'modelContent.gallery' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
