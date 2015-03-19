USE `cmgdemo`;

SET FOREIGN_KEY_CHECKS=0;

/* ============================= CMSGears CMS ============================================== */

--
-- Table structure for table `cmg_cms_menu`
--

DROP TABLE IF EXISTS `cmg_cms_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_menu` (
  `menu_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `menu_parent` bigint(20) DEFAULT NULL,
  `menu_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `fk_menu_1` (`menu_parent`),
  CONSTRAINT `fk_menu_1` FOREIGN KEY (`menu_parent`) REFERENCES `cmg_cms_menu` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_page`
--

DROP TABLE IF EXISTS `cmg_cms_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page` (
  `page_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `page_author` bigint(20) DEFAULT NULL,
  `page_banner` bigint(20) DEFAULT NULL,
  `page_parent` bigint(20) DEFAULT NULL,
  `page_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_type` smallint(6) DEFAULT NULL,
  `page_status` smallint(6) DEFAULT NULL,
  `page_visibility` smallint(6) DEFAULT NULL,
  `page_summary` text COLLATE utf8_unicode_ci,
  `page_content` text COLLATE utf8_unicode_ci,
  `page_created_on` datetime DEFAULT NULL,
  `page_published_on` datetime DEFAULT NULL,
  `page_updated_on` datetime DEFAULT NULL,
  `page_meta_tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_slug_unique` (`page_slug`),
  KEY `fk_page_1` (`page_author`),
  KEY `fk_page_2` (`page_banner`),
  KEY `fk_page_3` (`page_parent`),
  CONSTRAINT `fk_page_1` FOREIGN KEY (`page_author`) REFERENCES `cmg_user` (`user_id`),
  CONSTRAINT `fk_page_2` FOREIGN KEY (`page_banner`) REFERENCES `cmg_file` (`file_id`),
  CONSTRAINT `fk_page_3` FOREIGN KEY (`page_parent`) REFERENCES `cmg_cms_page` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_menu_page`
--

DROP TABLE IF EXISTS `cmg_cms_menu_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_menu_page` (
  `menu_id` bigint(20) NOT NULL,
  `page_id` bigint(20) NOT NULL,
  `page_order` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`,`page_id`),
  KEY `fk_menu_page_1` (`menu_id`),
  KEY `fk_menu_page_2` (`page_id`),
  CONSTRAINT `fk_menu_page_1` FOREIGN KEY (`menu_id`) REFERENCES `cmg_cms_menu` (`menu_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_menu_page_2` FOREIGN KEY (`page_id`) REFERENCES `cmg_cms_page` (`page_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_page_meta`
--

DROP TABLE IF EXISTS `cmg_cms_page_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page_meta` (
  `page_meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `page_meta_parent` bigint(20) NOT NULL,
  `page_meta_key` varchar(255) NOT NULL,
  `page_meta_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`page_meta_id`),
  KEY `fk_page_meta_1` (`page_meta_parent`),
  CONSTRAINT `fk_page_meta_1` FOREIGN KEY (`page_meta_parent`) REFERENCES `cmg_cms_page` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_page_file`
--

DROP TABLE IF EXISTS `cmg_cms_page_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_page_file` (
  `page_id` bigint(20) NOT NULL,
  `file_id` bigint(20) NOT NULL,
  `file_order` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`,`file_id`),
  KEY `fk_page_file_1` (`page_id`),
  KEY `fk_page_file_2` (`file_id`),
  CONSTRAINT `fk_page_file_1` FOREIGN KEY (`page_id`) REFERENCES `cmg_cms_page` (`page_id`),
  CONSTRAINT `fk_page_file_2` FOREIGN KEY (`file_id`) REFERENCES `cmg_file` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_post_category`
--

DROP TABLE IF EXISTS `cmg_cms_post_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_post_category` (
  `post_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`),
  KEY `fk_post_category_1` (`post_id`),
  KEY `fk_post_category_2` (`category_id`),
  CONSTRAINT `fk_post_category_1` FOREIGN KEY (`post_id`) REFERENCES `cmg_cms_page` (`page_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_post_category_2` FOREIGN KEY (`category_id`) REFERENCES `cmg_category` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_sidebar`
--

DROP TABLE IF EXISTS `cmg_cms_sidebar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_sidebar` (
  `sidebar_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sidebar_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sidebar_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sidebar_active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`sidebar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_widget`
--

DROP TABLE IF EXISTS `cmg_cms_widget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_widget` (
  `widget_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `widget_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `widget_template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `widget_meta` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`widget_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cms_sidebar_widget`
--

DROP TABLE IF EXISTS `cmg_cms_sidebar_widget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cms_sidebar_widget` (
  `sidebar_id` bigint(20) NOT NULL,
  `widget_id` bigint(20) NOT NULL,
  PRIMARY KEY (`widget_id`,`sidebar_id`),
  KEY `fk_sidebar_widget_1` (`sidebar_id`),
  KEY `fk_sidebar_widget_2` (`widget_id`),
  CONSTRAINT `fk_sidebar_widget_1` FOREIGN KEY (`sidebar_id`) REFERENCES `cmg_cms_sidebar` (`sidebar_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sidebar_widget_2` FOREIGN KEY (`widget_id`) REFERENCES `cmg_cms_widget` (`widget_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=1;