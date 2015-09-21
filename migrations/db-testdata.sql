/* ============================== CMSGears CMS ============================================== */

SET FOREIGN_KEY_CHECKS=0;

--
-- Dumping data for table `cmg_core_role`
--

INSERT INTO `cmg_core_role` VALUES 
	(1001,1,1,'CMS Manager','cms-manager','The role CMS Manager is limited to manage cms from admin.','dashboard','system',NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_core_permission`
--

INSERT INTO `cmg_core_permission` VALUES 
	(1001,1,1,'CMS','cms','The permission cms is to manage templates, pages, menus, sidebars and widgets from admin.','system',null,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_core_role_permission`
--

INSERT INTO `cmg_core_role_permission` VALUES 
	(1,1001),
	(2,1001),
	(1001,1001);

--
-- Dumping data for table `cmg_cms_page`
--

INSERT INTO `cmg_cms_page` VALUES
	(1,NULL,1,1,'Home','home','page',5,5),
	(2,NULL,1,1,'Login','login','page',5,5),
	(3,NULL,1,1,'Register','register','page',5,5),
	(4,NULL,1,1,'Confirm Account','confirm-account','page',5,5),
	(5,NULL,1,1,'Activate Account','activate-account','page',5,5),
	(6,NULL,1,1,'Forgot Password','forgot-password','page',5,5),
	(7,NULL,1,1,'Reset Password','reset-password','page',5,5),
	(8,NULL,1,1,'About Us','about','page',5,5),
	(9,NULL,1,1,'Terms','terms','page',5,5),
	(10,NULL,1,1,'Privacy','privacy','page',5,5),
	(11,NULL,1,1,'Blog','blog','page',5,5);

--
-- Dumping data for table `cmg_cms_model_content`
--

INSERT INTO `cmg_cms_model_content` VALUES
	(1,NULL,NULL,NULL,1,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'home page',NULL,NULL),
	(2,NULL,NULL,NULL,2,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'login page',NULL,NULL),
	(3,NULL,NULL,NULL,3,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'register page',NULL,NULL),
	(4,NULL,NULL,NULL,4,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'confirm account page',NULL,NULL),
	(5,NULL,NULL,NULL,5,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'activate account page',NULL,NULL),
	(6,NULL,NULL,NULL,6,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'forgot password page',NULL,NULL),
	(7,NULL,NULL,NULL,7,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'reset password page',NULL,NULL),
	(8,NULL,NULL,NULL,8,'page','<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'about us page',NULL,NULL),
	(9,NULL,NULL,NULL,9,'page',NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'terms page',NULL,NULL),
	(10,NULL,NULL,NULL,10,'page',NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'privacy page',NULL,NULL),
	(11,NULL,NULL,NULL,11,'page',NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'blog page',NULL,NULL);

SET FOREIGN_KEY_CHECKS=1;