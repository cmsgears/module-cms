/* == Reserved Id's - 1001 to 1250 == */

/* ============================= CMS Gears CMS ============================================== */

--
-- Dumping data for table `cmg_cms_template`
--

INSERT INTO `cmg_cms_template` VALUES 
	(1,'simple','Simple layout for pages and posts.',0),
	(2,'blog','Blog layout to view all blog posts or filters(category, author).',0),
	(3,'text','Text layout for text widget.',5);

--
-- Dumping data for table `cmg_option`
--

INSERT INTO `cmg_option` VALUES 
	(1001,1,'Post',1001,NULL);

--
-- Dumping data for table `cmg_role`
--

INSERT INTO `cmg_role` VALUES 
	(1001,1,1,'CMS Manager','The role CMS Manager is limited to manage cms from admin.','/dashboard',0,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_permission`
--

INSERT INTO `cmg_permission` VALUES 
	(1001,1,1,'cms','The permission cms is to manage templates, pages, menus, sidebars and widgets from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_role_permission`
--

INSERT INTO `cmg_role_permission` VALUES 
	(1,1001),
	(2,1001),
	(1001,1001);

--
-- Dumping data for table `cmg_user`
--

INSERT INTO `cmg_user` VALUES 
	(1001,1001,NULL,NULL,NULL,500,'democmsmanager@cmsgears.com','democmsmanager','$2y$13$Ut5b2RskRpGA9Q0nKSO6Xe65eaBHdx/q8InO8Ln6Lt3HzOK4ECz8W','cms','manager',NULL,NULL,1,NULL,NULL,'2014-10-11 14:22:54','2014-10-10 08:03:19',NULL,NULL,NULL,NULL,NULL);

--
-- Dumping data for table `cmg_cms_menu`
--

INSERT INTO `cmg_cms_menu` VALUES 
	(1,NULL,'main-menu','Main Menu. It can be used for site header and footer.');

--
-- Dumping data for table `cmg_cms_page`
--

INSERT INTO `cmg_cms_page` VALUES
	(1,NULL,1,NULL,NULL,'Home','home page','home',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(2,NULL,1,NULL,NULL,'Login','login page','login',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(3,NULL,1,NULL,NULL,'Register','register page','register',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(4,NULL,1,NULL,NULL,'Confirm Account','confirm account page','confirm-account',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(5,NULL,1,NULL,NULL,'Activate Account','activate account page','activate-account',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(6,NULL,1,NULL,NULL,'Forgot Password','forgot password page','forgot-password',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(7,NULL,1,NULL,NULL,'Reset Password','reset password page','reset-password',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(8,NULL,1,NULL,NULL,'Contact','contact page','contact',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(9,NULL,1,NULL,NULL,'Feedback','feedback page','feedback',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(10,NULL,1,NULL,1,'About Us','about us page','about-us',NULL,0,0,0,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(11,NULL,1,NULL,1,'Terms','terms page','terms',NULL,0,0,0,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(12,NULL,1,NULL,1,'Privacy','privacy page','privacy',NULL,0,0,0,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00'),
	(13,NULL,1,NULL,2,'Blog','blog page','blog',NULL,0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00');

--
-- Dumping data for table `cmg_cms_menu_page`
--

INSERT INTO `cmg_cms_menu_page` VALUES
	(1,1,0),
	(1,2,0),
	(1,3,0),
	(1,8,0),
	(1,10,0),
	(1,11,0),
	(1,12,0),
	(1,13,0);