SET FOREIGN_KEY_CHECKS=0;

/* ============================= CMSGears CMS ============================================== */

--
-- Table structure for table `cmg_cms_tag`
--

DROP TABLE IF EXISTS `cmg_cms_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_template`
--

DROP TABLE IF EXISTS `cmg_cms_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_menu`
--

DROP TABLE IF EXISTS `cmg_cms_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parentId` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cms_menu_1` (`parentId`),
  CONSTRAINT `fk_cms_menu_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_cms_menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_page`
--

DROP TABLE IF EXISTS `cmg_cms_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parentId` bigint(20) DEFAULT NULL,
  `authorId` bigint(20) NOT NULL,
  `bannerId` bigint(20) DEFAULT NULL,
  `templateId` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `visibility` smallint(6) DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `content` longtext COLLATE utf8_unicode_ci,
  `createdAt` datetime DEFAULT NULL,
  `publishedAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_page_slug` (`slug`),
  KEY `fk_cms_page_1` (`parentId`),
  KEY `fk_cms_page_2` (`authorId`),
  KEY `fk_cms_page_3` (`bannerId`),
  KEY `fk_cms_page_4` (`templateId`),
  CONSTRAINT `fk_cms_page_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_cms_page` (`id`),
  CONSTRAINT `fk_cms_page_2` FOREIGN KEY (`authorId`) REFERENCES `cmg_user` (`id`),
  CONSTRAINT `fk_cms_page_3` FOREIGN KEY (`bannerId`) REFERENCES `cmg_file` (`id`),
  CONSTRAINT `fk_cms_page_4` FOREIGN KEY (`templateId`) REFERENCES `cmg_cms_template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_menu_page`
--

DROP TABLE IF EXISTS `cmg_cms_menu_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_menu_page` (
  `menuId` bigint(20) NOT NULL,
  `pageId` bigint(20) NOT NULL,
  `order` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuId`,`pageId`),
  KEY `fk_cms_menu_page_1` (`menuId`),
  KEY `fk_cms_menu_page_2` (`pageId`),
  CONSTRAINT `fk_cms_menu_page_1` FOREIGN KEY (`menuId`) REFERENCES `cmg_cms_menu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cms_menu_page_2` FOREIGN KEY (`pageId`) REFERENCES `cmg_cms_page` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_page_meta`
--

DROP TABLE IF EXISTS `cmg_cms_page_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page_meta` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pageId` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cms_page_meta_1` (`pageId`),
  CONSTRAINT `fk_cms_page_meta_1` FOREIGN KEY (`pageId`) REFERENCES `cmg_cms_page` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_page_tag`
--

DROP TABLE IF EXISTS `cmg_cms_page_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page_tag` (
  `pageId` bigint(20) NOT NULL,
  `tagId` bigint(20) NOT NULL,
  `order` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pageId`,`tagId`),
  KEY `fk_cms_page_tag_1` (`pageId`),
  KEY `fk_cms_page_tag_2` (`tagId`),
  CONSTRAINT `fk_cms_page_tag_1` FOREIGN KEY (`pageId`) REFERENCES `cmg_cms_page` (`id`),
  CONSTRAINT `fk_cms_page_tag_2` FOREIGN KEY (`tagId`) REFERENCES `cmg_cms_tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_page_file`
--

DROP TABLE IF EXISTS `cmg_cms_page_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page_file` (
  `pageId` bigint(20) NOT NULL,
  `fileId` bigint(20) NOT NULL,
  `order` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pageId`,`fileId`),
  KEY `fk_cms_page_file_1` (`pageId`),
  KEY `fk_cms_page_file_2` (`fileId`),
  CONSTRAINT `fk_cms_page_file_1` FOREIGN KEY (`pageId`) REFERENCES `cmg_cms_page` (`id`),
  CONSTRAINT `fk_cms_page_file_2` FOREIGN KEY (`fileId`) REFERENCES `cmg_file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_post_category`
--

DROP TABLE IF EXISTS `cmg_cms_post_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_post_category` (
  `postId` bigint(20) NOT NULL,
  `categoryId` bigint(20) NOT NULL,
  PRIMARY KEY (`postId`,`categoryId`),
  KEY `fk_cms_post_category_1` (`postId`),
  KEY `fk_cms_post_category_2` (`categoryId`),
  CONSTRAINT `fk_cms_post_category_1` FOREIGN KEY (`postId`) REFERENCES `cmg_cms_page` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cms_post_category_2` FOREIGN KEY (`categoryId`) REFERENCES `cmg_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_sidebar`
--

DROP TABLE IF EXISTS `cmg_cms_sidebar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_sidebar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_widget`
--

DROP TABLE IF EXISTS `cmg_cms_widget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_widget` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `templateId` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk_cms_widget_1` (`templateId`),
  CONSTRAINT `fk_cms_widget_1` FOREIGN KEY (`templateId`) REFERENCES `cmg_cms_template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_sidebar_widget`
--

DROP TABLE IF EXISTS `cmg_cms_sidebar_widget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_sidebar_widget` (
  `sidebarId` bigint(20) NOT NULL,
  `widgetId` bigint(20) NOT NULL,
  PRIMARY KEY (`sidebarId`,`widgetId`),
  KEY `fk_cms_sidebar_widget_1` (`sidebarId`),
  KEY `fk_cms_sidebar_widget_2` (`widgetId`),
  CONSTRAINT `fk_cms_sidebar_widget_1` FOREIGN KEY (`sidebarId`) REFERENCES `cmg_cms_sidebar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cms_sidebar_widget_2` FOREIGN KEY (`widgetId`) REFERENCES `cmg_cms_widget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=1;