USE `cmgdemo`;

/* ============================= CMS Gears CMS ============================================== */

--
-- Dumping data for table `cmg_option`
--

INSERT INTO `cmg_option` VALUES 
	(1001,1,'Post','1001');

--
-- Dumping data for table `cmg_role`
--

INSERT INTO `cmg_role` VALUES 
	(1001,'CMS Manager','The role CMS Manager is limited to manage cms from admin.','/',0);

--
-- Dumping data for table `cmg_permission`
--

INSERT INTO `cmg_permission` VALUES 
	(1001,'cms','The permission cms is to manage cms module from admin.'),
	(1002,'cms-page','The permission cms-page is to manage pages from admin.'),
	(1003,'cms-post','The permission cms-post is to manage posts from admin.'),
	(1004,'cms-menu','The permission cms-menu is to manage menus from admin.'),
	(1005,'cms-slider','The permission cms-slider is to manage sliders.'),
	(1006,'cms-sidebar','The permission cms-sidebar is to manage sidebars and widgets.');

--
-- Dumping data for table `cmg_role_permission`
--

INSERT INTO `cmg_role_permission` VALUES 
	(1,1001),(1,1002),(1,1003),(1,1004),(1,1005),(1,1006),
	(2,1001),(2,1002),(2,1003),(2,1004),(2,1005),(2,1006),
	(1001,1001),(1001,1002),(1001,1003),(1001,1004),(1001,1005),(1001,1006);

--
-- Dumping data for table `cmg_user`
--

INSERT INTO `cmg_user` VALUES 
	(1001,1001,NULL,NULL,NULL,10,'democmsmanager@cmsgears.org','democmsmanager','$2y$13$Ut5b2RskRpGA9Q0nKSO6Xe65eaBHdx/q8InO8Ln6Lt3HzOK4ECz8W','demo','user',NULL,NULL,1,NULL,NULL,'2014-10-11 14:22:54','2014-10-10 08:03:19',NULL,NULL,NULL,NULL);

--
-- Dumping data for table `cmg_cms_menu`
--

INSERT INTO `cmg_cms_menu` VALUES 
	(1,NULL,'main-menu','Main Menu. It can be used for site header and footer.');

--
-- Dumping data for table `cmg_cms_page`
--

INSERT INTO `cmg_cms_page` VALUES
	(1,1,NULL,NULL,'Home','home page','home',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(2,1,NULL,NULL,'Login','login page','login',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(3,1,NULL,NULL,'Register','register page','register',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(4,1,NULL,NULL,'Confirm Account','confirm account page','confirm-account',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(5,1,NULL,NULL,'Activate Account','activate account page','activate-account',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(6,1,NULL,NULL,'Forgot Password','forgot password page','forgot-password',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(7,1,NULL,NULL,'Reset Password','reset password page','reset-password',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(8,1,NULL,NULL,'Contact Us','contact page','contact',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(9,1,NULL,NULL,'Feedback','feedback page','feedback',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,NULL),
	(10,1,NULL,NULL,'About Us','about us page','about-us',0,0,0,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'simple'),
	(11,1,NULL,NULL,'Terms','terms page','terms',0,0,0,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'simple'),
	(12,1,NULL,NULL,'Privacy','privacy page','privacy',0,0,0,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'simple'),
	(13,1,NULL,NULL,'Blog','blog page','blog',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00',NULL,'blog');

--
-- Dumping data for table `cmg_cms_menu_page`
--

INSERT INTO `cmg_cms_menu_page` VALUES
	(1,1,0),
	(1,2,0),
	(1,3,0),
	(1,11,0),
	(1,12,0),
	(1,10,0),
	(1,8,0);