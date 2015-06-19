--
-- Dumping data for table `cmg_cms_template`
--

INSERT INTO `cmg_cms_template` VALUES 
	(1,'simple','Simple layout for pages and posts.',0),
	(2,'blog','Blog layout to view all blog posts or filters(category, author).',0),
	(3,'text','Text layout for simple text widget.',5);

--
-- Dumping data for table `cmg_core_role`
--

INSERT INTO `cmg_core_role` VALUES 
	(1001,1,1,'CMS Manager','The role CMS Manager is limited to manage cms from admin.','/dashboard',0,'2014-10-11 14:22:54','2014-10-11 14:22:54',null);

--
-- Dumping data for table `cmg_core_permission`
--

INSERT INTO `cmg_core_permission` VALUES 
	(1001,1,1,'cms','The permission cms is to manage templates, pages, menus, sidebars and widgets from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54',null);

--
-- Dumping data for table `cmg_core_role_permission`
--

INSERT INTO `cmg_core_role_permission` VALUES 
	(1,1001),
	(2,1001),
	(1001,1001);

--
-- Dumping data for table `cmg_core_user`
--

INSERT INTO `cmg_core_user` VALUES 
	(1001,NULL,NULL,NULL,500,'democmsmanager@cmsgears.com','democmsmanager','$2y$13$Ut5b2RskRpGA9Q0nKSO6Xe65eaBHdx/q8InO8Ln6Lt3HzOK4ECz8W','cms','manager',NULL,NULL,NULL,NULL,'2014-10-11 14:22:54','2014-10-10 08:03:19',NULL,'-jG5ExHS0Y39ucSxHhl3PZ4xmPsfvQFC',NULL,NULL,NULL);

--
-- Dumping data for table `cmg_core_site_member`
--

INSERT INTO `cmg_core_site_member` VALUES
	(1,1001,1001,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_cms_menu`
--

INSERT INTO `cmg_cms_menu` VALUES 
	(1,NULL,'main-menu','Main Menu. It can be used for site header and footer.');

--
-- Dumping data for table `cmg_cms_page`
--

INSERT INTO `cmg_cms_page` VALUES
	(1,NULL,NULL,NULL,1,NULL,'Home','home',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','home page',NULL,NULL,NULL),
	(2,NULL,NULL,NULL,1,NULL,'Login','login',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','login page',NULL,NULL,NULL),
	(3,NULL,NULL,NULL,1,NULL,'Register','register',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','register page',NULL,NULL,NULL),
	(4,NULL,NULL,NULL,1,NULL,'Confirm Account','confirm-account',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','confirm account page',NULL,NULL,NULL),
	(5,NULL,NULL,NULL,1,NULL,'Activate Account','activate-account',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','activate account page',NULL,NULL,NULL),
	(6,NULL,NULL,NULL,1,NULL,'Forgot Password','forgot-password',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','forgot password page',NULL,NULL,NULL),
	(7,NULL,NULL,NULL,1,NULL,'Reset Password','reset-password',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','reset password page',NULL,NULL,NULL),
	(8,NULL,NULL,NULL,1,NULL,'Contact','contact',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','contact page',NULL,NULL,NULL),
	(9,NULL,NULL,NULL,1,NULL,'Feedback','feedback',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','feedback page',NULL,NULL,NULL),
	(10,NULL,NULL,1,1,NULL,'About Us','about-us',0,0,0,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','about us page',NULL,NULL,NULL),
	(11,NULL,NULL,1,1,NULL,'Terms','terms',0,0,0,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','terms page',NULL,NULL,NULL),
	(12,NULL,NULL,1,1,NULL,'Privacy','privacy',0,0,0,NULL,'<p>Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero</p>','2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','privacy page',NULL,NULL,NULL),
	(13,NULL,NULL,2,1,NULL,'Blog','blog',0,0,0,NULL,NULL,'2014-10-01 00:00:00','2014-10-01 00:00:00','2014-10-01 00:00:00','blog page',NULL,NULL,NULL);

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