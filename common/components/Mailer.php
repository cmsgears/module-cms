<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\components;

/**
 * Mailer triggers the mails provided by CMS Module.
 *
 * @since 1.0.0
 */
class Mailer extends \cmsgears\core\common\base\Mailer {

	// Global -----------------

	const MAIL_POST_CREATE		= 'post/create';
	const MAIL_POST_REGISTER	= 'post/register';
	const MAIL_PAGE_REGISTER	= 'page/register';

	// Public -----------------

	public $htmlLayout	= '@cmsgears/module-core/common/mails/layouts/html';
	public $textLayout	= '@cmsgears/module-core/common/mails/layouts/text';
	public $viewPath	= '@cmsgears/module-cms/common/mails/views';

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Mailer --------------------------------

	public function sendCreatePostMail( $post ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		$user = $post->getOwner();

		$name	= $user->getName();
		$email	= $user->email;

		if( empty( $email ) ) {

			return;
		}

		// Send Mail
		$this->getMailer()->compose( self::MAIL_POST_CREATE, [ 'coreProperties' => $this->coreProperties, 'post' => $post, 'name' => $name, 'email' => $email ] )
			->setTo( $email )
			->setFrom( [ $fromEmail => $fromName ] )
			->setSubject( "Post Registration | " . $this->coreProperties->getSiteName() )
			//->setTextBody( "text" )
			->send();
	}

	public function sendRegisterPostMail( $post ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		$user = $post->getOwner();

		$name	= $user->getName();
		$email	= $user->email;

		if( empty( $email ) ) {

			return;
		}

		// Send Mail
		$this->getMailer()->compose( self::MAIL_POST_REGISTER, [ 'coreProperties' => $this->coreProperties, 'post' => $post, 'name' => $name, 'email' => $email ] )
			->setTo( $email )
			->setFrom( [ $fromEmail => $fromName ] )
			->setSubject( "Post Registration | " . $this->coreProperties->getSiteName() )
			//->setTextBody( "text" )
			->send();
	}

	public function sendRegisterPageMail( $page ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		$user = $page->getOwner();

		$name	= $user->getName();
		$email	= $user->email;

		if( empty( $email ) ) {

			return;
		}

		// Send Mail
		$this->getMailer()->compose( self::MAIL_PAGE_REGISTER, [ 'coreProperties' => $this->coreProperties, 'page' => $page, 'name' => $name, 'email' => $email ] )
			->setTo( $email )
			->setFrom( [ $fromEmail => $fromName ] )
			->setSubject( "Page Registration | " . $this->coreProperties->getSiteName() )
			//->setTextBody( "text" )
			->send();
	}

}
