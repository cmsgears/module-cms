/* ============================== CMSGears CMS ============================================== */

SET FOREIGN_KEY_CHECKS=0;

--
-- CMS module roles and permissions
--

INSERT INTO `cmg_core_role` (`createdBy`,`modifiedBy`,`name`,`slug`,`homeUrl`,`type`,`description`,`icon`,`createdAt`,`modifiedAt`) VALUES 
	(1,1,'CMS Manager','cms-manager','dashboard','system','The role CMS Manager is limited to manage cms from admin.',NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @rolesadmin := `id` FROM cmg_core_role WHERE slug = 'super-admin';
SELECT @roleadmin := `id` FROM cmg_core_role WHERE slug = 'admin';
SELECT @rolecms := `id` FROM cmg_core_role WHERE slug = 'cms-manager';

INSERT INTO `cmg_core_permission` (`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`icon`,`createdAt`,`modifiedAt`) VALUES 
	(1,1,'CMS','cms','system','The permission cms is to manage templates, pages, menus, sidebars and widgets from admin.',null,'2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @permcms := `id` FROM cmg_core_permission WHERE slug = 'cms';

--
-- Dumping data for table `cmg_core_role_permission`
--

INSERT INTO `cmg_core_role_permission` VALUES 
	(@rolesadmin,@permcms),
	(@roleadmin,@permcms),
	(@rolecms,@permcms);

--
-- Dumping data for table `cmg_cms_page`
--

INSERT INTO `cmg_cms_page` (`parentId`,`siteId`,`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`status`,`visibility`,`icon`,`order`,`featured`) VALUES
	(NULL,1,1,1,'Home','home','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Login','login','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Register','register','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Confirm Account','confirm-account','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Activate Account','activate-account','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Forgot Password','forgot-password','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Reset Password','reset-password','page',500,10,NULL,0,0),
	(NULL,1,1,1,'About Us','about-us','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Terms','terms','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Privacy','privacy','page',500,10,NULL,0,0),
	(NULL,1,1,1,'Blog','blog','page',500,10,NULL,0,0);

--
-- Dumping data for table `cmg_cms_model_content`
--

INSERT INTO `cmg_cms_model_content` (`bannerId`,`videoId`,`templateId`,`parentId`,`parentType`,`createdAt`,`modifiedAt`,`publishedAt`,`seoName`,`seoDescription`,`seoKeywords`,`seoRobot`,`summary`,`content`,`data`) VALUES
	(NULL,NULL,NULL,1,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'home page',NULL,NULL,NULL,NULL,NULL),
	(NULL,NULL,NULL,2,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'login page',NULL,NULL,NULL,NULL,NULL),
	(NULL,NULL,NULL,3,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'register page',NULL,NULL,NULL,NULL,NULL),
	(NULL,NULL,NULL,4,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'confirm account page',NULL,NULL,NULL,NULL,NULL),
	(NULL,NULL,NULL,5,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'activate account page',NULL,NULL,NULL,NULL,NULL),
	(NULL,NULL,NULL,6,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'forgot password page',NULL,NULL,NULL,NULL,NULL),
	(NULL,NULL,NULL,7,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'reset password page',NULL,NULL,NULL,NULL,NULL),
	(NULL,NULL,NULL,8,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'about us page',NULL,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>',NULL),
	(NULL,NULL,NULL,9,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'terms page',NULL,NULL,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>',NULL),
	(NULL,NULL,NULL,10,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'privacy page',NULL,NULL,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>',NULL),
	(NULL,NULL,NULL,11,'page','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'blog page',NULL,NULL,NULL,NULL,NULL);

SET FOREIGN_KEY_CHECKS=1;