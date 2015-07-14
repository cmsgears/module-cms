/* ============================== CMSGears Cms ============================================== */

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
  KEY `fk_menu_1` (`parentId`)
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
  `createdBy` bigint(20) NOT NULL,
  `modifiedBy` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `visibility` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_page_1` (`parentId`),
  KEY `fk_page_2` (`createdBy`),
  KEY `fk_page_3` (`modifiedBy`)
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
  KEY `fk_menu_page_2` (`pageId`)
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
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  KEY `fk_widget_1` (`templateId`)
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
  `order` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sidebarId`,`widgetId`),
  KEY `fk_sidebar_widget_1` (`sidebarId`),
  KEY `fk_sidebar_widget_2` (`widgetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- ======================== Model Traits =================================

--
-- Table structure for table `cmg_cms_model_content`
--

DROP TABLE IF EXISTS `cmg_cms_model_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_model_content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bannerId` bigint(20) DEFAULT NULL,
  `templateId` bigint(20) DEFAULT NULL,
  `parentId` bigint(20) NOT NULL,
  `parentType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  `publishedAt` datetime DEFAULT NULL,
  `seoName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seoDescription` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seoKeywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seoRobot` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_model_content_1` (`bannerId`),
  KEY `fk_model_content_2` (`templateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_model_block`
--

DROP TABLE IF EXISTS `cmg_cms_model_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_model_block` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `backgroundId` bigint(20) DEFAULT NULL,
  `textureId` bigint(20) DEFAULT NULL,
  `parentId` bigint(20) NOT NULL,
  `order` smallint(6) DEFAULT 0,
  `htmlOptions` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `backgroundClass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `textureClass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_model_block_1` (`backgroundId`),
  KEY `fk_model_block_2` (`textureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `cmg_cms_menu`
--
ALTER TABLE `cmg_cms_menu`
	ADD CONSTRAINT `fk_menu_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_cms_menu` (`id`);

--
-- Constraints for table `cmg_cms_page`
--
ALTER TABLE `cmg_cms_page` 
	ADD CONSTRAINT `fk_page_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_cms_page` (`id`),
	ADD CONSTRAINT `fk_page_2` FOREIGN KEY (`createdBy`) REFERENCES `cmg_core_user` (`id`),
	ADD CONSTRAINT `fk_page_3` FOREIGN KEY (`modifiedBy`) REFERENCES `cmg_core_user` (`id`);

--
-- Constraints for table `cmg_cms_menu_page`
--
ALTER TABLE `cmg_cms_menu_page` 
	ADD CONSTRAINT `fk_menu_page_1` FOREIGN KEY (`menuId`) REFERENCES `cmg_cms_menu` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_menu_page_2` FOREIGN KEY (`pageId`) REFERENCES `cmg_cms_page` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cmg_cms_widget`
--
ALTER TABLE `cmg_cms_widget` 
	ADD CONSTRAINT `fk_widget_1` FOREIGN KEY (`templateId`) REFERENCES `cmg_core_template` (`id`);

--
-- Constraints for table `cmg_cms_sidebar_widget`
--
ALTER TABLE `cmg_cms_sidebar_widget` 
	ADD CONSTRAINT `fk_sidebar_widget_1` FOREIGN KEY (`sidebarId`) REFERENCES `cmg_cms_sidebar` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_sidebar_widget_2` FOREIGN KEY (`widgetId`) REFERENCES `cmg_cms_widget` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cmg_cms_model_content`
--
ALTER TABLE `cmg_cms_model_content` 
	ADD CONSTRAINT `fk_model_content_1` FOREIGN KEY (`bannerId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_model_content_2` FOREIGN KEY (`templateId`) REFERENCES `cmg_core_template` (`id`);

--
-- Constraints for table `cmg_cms_model_block`
--
ALTER TABLE `cmg_cms_model_block` 
	ADD CONSTRAINT `fk_model_block_1` FOREIGN KEY (`backgroundId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_model_block_2` FOREIGN KEY (`textureId`) REFERENCES `cmg_core_template` (`id`);

SET FOREIGN_KEY_CHECKS=1;