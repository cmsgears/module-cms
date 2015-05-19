SET FOREIGN_KEY_CHECKS=0;

/* ============================= CMSGears CMS ============================================== */

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
  KEY `fk_menu_1` (`parentId`),
  CONSTRAINT `fk_menu_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_cms_menu` (`id`)
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
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  KEY `fk_page_1` (`parentId`),
  KEY `fk_page_2` (`authorId`),
  KEY `fk_page_3` (`bannerId`),
  KEY `fk_page_4` (`templateId`),
  CONSTRAINT `fk_page_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_cms_page` (`id`),
  CONSTRAINT `fk_page_2` FOREIGN KEY (`authorId`) REFERENCES `cmg_core_user` (`id`),
  CONSTRAINT `fk_page_3` FOREIGN KEY (`bannerId`) REFERENCES `cmg_core_file` (`id`),
  CONSTRAINT `fk_page_4` FOREIGN KEY (`templateId`) REFERENCES `cmg_cms_template` (`id`)
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
  KEY `fk_menu_page_1` (`menuId`),
  KEY `fk_menu_page_2` (`pageId`),
  CONSTRAINT `fk_menu_page_1` FOREIGN KEY (`menuId`) REFERENCES `cmg_cms_menu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_menu_page_2` FOREIGN KEY (`pageId`) REFERENCES `cmg_cms_page` (`id`) ON DELETE CASCADE
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
  KEY `fk_widget_1` (`templateId`),
  CONSTRAINT `fk_widget_1` FOREIGN KEY (`templateId`) REFERENCES `cmg_cms_template` (`id`)
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
  KEY `fk_sidebar_widget_1` (`sidebarId`),
  KEY `fk_sidebar_widget_2` (`widgetId`),
  CONSTRAINT `fk_sidebar_widget_1` FOREIGN KEY (`sidebarId`) REFERENCES `cmg_cms_sidebar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sidebar_widget_2` FOREIGN KEY (`widgetId`) REFERENCES `cmg_cms_widget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=1;