/* ============================== CMSGears CMS ============================================== */

--
-- Table structure for table `cmg_cms_page`
--

DROP TABLE IF EXISTS `cmg_cms_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parentId` bigint(20) DEFAULT NULL,
  `siteId` bigint(20) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `modifiedBy` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `visibility` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cms_page_1` (`parentId`),
  KEY `fk_cms_page_2` (`siteId`),
  KEY `fk_cms_page_3` (`createdBy`),
  KEY `fk_cms_page_4` (`modifiedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_block`
--

DROP TABLE IF EXISTS `cmg_cms_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_block` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bannerId` bigint(20) DEFAULT NULL,
  `textureId` bigint(20) DEFAULT NULL,
  `videoId` bigint(20) DEFAULT NULL,
  `templateId` bigint(20) DEFAULT NULL,
  `createdBy` bigint(20) NOT NULL,
  `modifiedBy` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `htmlOptions` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `backgroundClass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `textureClass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cms_block_1` (`bannerId`),
  KEY `fk_cms_block_2` (`textureId`),
  KEY `fk_cms_block_3` (`videoId`),
  KEY `fk_cms_block_4` (`templateId`),
  KEY `fk_cms_block_5` (`createdBy`),
  KEY `fk_cms_block_6` (`modifiedBy`)
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
  `videoId` bigint(20) DEFAULT NULL,
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
  KEY `fk_cms_model_content_1` (`bannerId`),
  KEY `fk_cms_model_content_2` (`videoId`),
  KEY `fk_cms_model_content_3` (`templateId`)
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
  `blockId` bigint(20) DEFAULT NULL,
  `parentId` bigint(20) NOT NULL,
  `parentType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` smallint(6) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_cms_model_block_1` (`blockId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `cmg_cms_page`
--
ALTER TABLE `cmg_cms_page` 
	ADD CONSTRAINT `fk_cms_page_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_cms_page` (`id`),
	ADD CONSTRAINT `fk_cms_page_2` FOREIGN KEY (`siteId`) REFERENCES `cmg_core_site` (`id`),
	ADD CONSTRAINT `fk_cms_page_3` FOREIGN KEY (`createdBy`) REFERENCES `cmg_core_user` (`id`),
	ADD CONSTRAINT `fk_cms_page_4` FOREIGN KEY (`modifiedBy`) REFERENCES `cmg_core_user` (`id`);

--
-- Constraints for table `cmg_cms_block`
--
ALTER TABLE `cmg_cms_block` 
	ADD CONSTRAINT `fk_cms_block_1` FOREIGN KEY (`bannerId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_cms_block_2` FOREIGN KEY (`textureId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_cms_block_3` FOREIGN KEY (`videoId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_cms_block_4` FOREIGN KEY (`templateId`) REFERENCES `cmg_core_template` (`id`),
	ADD CONSTRAINT `fk_cms_block_5` FOREIGN KEY (`createdBy`) REFERENCES `cmg_core_user` (`id`),
	ADD CONSTRAINT `fk_cms_block_6` FOREIGN KEY (`modifiedBy`) REFERENCES `cmg_core_user` (`id`);

--
-- Constraints for table `cmg_cms_model_content`
--
ALTER TABLE `cmg_cms_model_content` 
	ADD CONSTRAINT `fk_cms_model_content_1` FOREIGN KEY (`bannerId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_cms_model_content_2` FOREIGN KEY (`videoId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_cms_model_content_3` FOREIGN KEY (`templateId`) REFERENCES `cmg_core_template` (`id`);

--
-- Constraints for table `cmg_cms_model_block`
--
ALTER TABLE `cmg_cms_model_block` 
	ADD CONSTRAINT `fk_cms_model_block_1` FOREIGN KEY (`blockId`) REFERENCES `cmg_cms_block` (`id`);

SET FOREIGN_KEY_CHECKS=1;