<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\traits\resources;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\resources\ModelContent;

/**
 * PageContentTrait can be used to add seo optimised content to relevant models to
 * form public pages. The models using this trait must also use Visibility and Approval
 * traits in order to check the published status.
 *
 * @since 1.0.0
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

		return isset( $template ) ? $template->viewPath : null;
	}

	/**
	 * Check whether content is published. To consider a model as published, it must
	 * be publicly visible in either active or frozen status.
	 *
	 * @return boolean
	 */
	public function isPublished() {

		$user = Yii::$app->core->getUser();

		if( isset( $user ) ) {

			// Always published for owner
			if( $this->createdBy == $user->id ) {

				return true;
			}

			// TODO: Add code for secured visibility with password match

			// Visible to logged in users in strictly protected mode
			if( $this->isPublic() && $this->isVisibilityProtected() ) {

				return true;
			}
		}

		// Status(Active or Frozen) with public visibility
		return $this->isPublic() && $this->isVisibilityPublic( false );
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

		$config[ 'relations' ] = [ 'modelContent', 'modelContent.template' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with content, template, banner, video and gallery.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with content, banner, video and gallery.
	 */
	public static function queryWithFullContent( $config = [] ) {

		$config[ 'relations' ] = [ 'modelContent', 'modelContent.template', 'modelContent.banner', 'modelContent.video', 'modelContent.gallery' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
