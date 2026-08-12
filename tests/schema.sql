
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `action_type` int NOT NULL DEFAULT '1',
  `company_id` int NOT NULL DEFAULT '1',
  `module_id` int NOT NULL,
  `action` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`uniq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `assign_approvers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assign_approvers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `approver_id` int DEFAULT NULL,
  `is_default_project` tinyint DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `default_project_id` int DEFAULT NULL,
  `total_week_hours` int DEFAULT NULL,
  `approve_start_week` date DEFAULT NULL,
  `approve_end_week` date DEFAULT NULL,
  `pending_status` enum('Pending','Approve','Reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `reject_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `timesheet_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `billable_type_master_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billable_type_master_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `billable_type_tx` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `billable_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billable_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `business_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_units` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `business_unit` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_active` int NOT NULL DEFAULT '1' COMMENT '1-active,0-inactive',
  `dt_created` datetime NOT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clients_master_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients_master_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_name_tx` (`client_name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `currency_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currency_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`),
  UNIQUE KEY `code_tx` (`code_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `default_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `default_project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_code` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dt_created` datetime NOT NULL,
  `dt_updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `default_project_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `default_project_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id_nm` int NOT NULL,
  `parent_task_nm` int DEFAULT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`uniq_id`),
  KEY `project_id_nm` (`project_id_nm`),
  CONSTRAINT `default_project_tasks_ibfk_1` FOREIGN KEY (`project_id_nm`) REFERENCES `default_project` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `department_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `division_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `division_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `globalprojects_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `globalprojects_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `industry_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `industry_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `invoice_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `company_id` int DEFAULT '0',
  `project_id` int DEFAULT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `designation` varchar(45) DEFAULT NULL,
  `secondary_contact_first_name` varchar(100) DEFAULT NULL,
  `secondary_contact_last_name` varchar(100) DEFAULT NULL,
  `secondary_contact_email` varchar(100) DEFAULT NULL,
  `secondary_contact_phone` varchar(50) DEFAULT NULL,
  `secondary_contact_designation` varchar(45) DEFAULT NULL,
  `street` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `city` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `zipcode` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `organization` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `currency` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Active',
  `user_id` int DEFAULT NULL,
  `region` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `log_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_times` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `task_id` int DEFAULT NULL,
  `is_default_task` tinyint DEFAULT NULL,
  `default_task_id` tinyint DEFAULT NULL,
  `default_project_id` int DEFAULT NULL,
  `istype` int DEFAULT NULL,
  `defect_id` int DEFAULT NULL,
  `test_case_id` int DEFAULT NULL,
  `task_date` datetime DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `total_hours` int DEFAULT NULL,
  `is_billable` tinyint DEFAULT NULL,
  `auto_generate_invoice` tinyint DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `task_status` tinyint DEFAULT '0',
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0.0.0.0',
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `break_time` int DEFAULT NULL,
  `timesheet_flag` tinyint DEFAULT '0',
  `approver_id` int DEFAULT NULL,
  `pending_status` enum('Pending','Approve','Reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `project_manager_id` int DEFAULT NULL,
  `project_manager_action` enum('Pending','Approve','Reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `project_manager_comment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reporting_manager_id` int DEFAULT NULL,
  `reporting_manager_action` enum('Pending','Approve','Reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `reporting_manager_comment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `log_times_ibfk_1_idx` (`id`,`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `m_proj_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_proj_modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `active` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_type_id` int DEFAULT NULL,
  `ref_id` int DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_id` int DEFAULT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `action_id` (`action_id`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `company_id` int NOT NULL DEFAULT '1',
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`uniq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_recovery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_recovery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_availed` tinyint DEFAULT '0',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_cost` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `year` int DEFAULT NULL,
  `week_number` int DEFAULT NULL,
  `spend_type` enum('Resourcing Costs','Software Costs','Hardware Costs','Traing Costs','Others') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Others',
  `planned_spend` int NOT NULL,
  `actual_spend` int NOT NULL,
  `variance` int NOT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_delivery_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_delivery_plan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` varchar(45) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `milestone` varchar(45) DEFAULT NULL,
  `module` varchar(45) DEFAULT NULL,
  `onsite` varchar(45) DEFAULT NULL,
  `offshore` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `start_date` varchar(45) DEFAULT NULL,
  `end_date` varchar(45) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_health`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_health` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `year` int DEFAULT NULL,
  `week_number` int DEFAULT NULL,
  `schedule` int DEFAULT NULL,
  `schedule_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` int DEFAULT NULL,
  `budget_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resource` int DEFAULT NULL,
  `resource_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` int DEFAULT NULL,
  `scope_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quality` int DEFAULT NULL,
  `quality_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `change_mang` int DEFAULT NULL,
  `change_mang_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_issues_risks_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_issues_risks_actions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `week_number` int DEFAULT NULL,
  `type` enum('Risk','Issue','Decision','Dependency','Change Request','Others') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Others',
  `due_date` date DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_milestones_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_milestones_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `milestone_type` enum('DELIVERY','FINANCIAL') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'DELIVERY',
  `title_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_milestone_id` int DEFAULT NULL,
  `description_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uniq_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id_nm` int NOT NULL,
  `currency` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billable_type` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billable_amount_nm` int DEFAULT NULL,
  `percent_complete_nm` int DEFAULT NULL,
  `start_date_dt` date DEFAULT NULL,
  `end_date_dt` date DEFAULT NULL,
  `actual_start_date_dt` date DEFAULT NULL,
  `actual_end_date_dt` date DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `class_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dependent` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  `delivery_milestone_status` enum('','New','In Progress','Completed','On Hold') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `financial_milestone_status` enum('','New','Yet To Invoice','Invoiced','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_needs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_needs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_tx` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `project_id_nm` int NOT NULL,
  `type` enum('CONCERN','CHANGE_REQUEST','OPEN_ACTION') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'CONCERN',
  `assigned_to` int DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`uniq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uniq_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_tx` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `project_id_nm` int NOT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`uniq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_planned_efforts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_planned_efforts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `phase` varchar(45) NOT NULL,
  `engagement_type` varchar(45) NOT NULL,
  `resource_type` varchar(45) NOT NULL,
  `module` varchar(45) NOT NULL,
  `experience` varchar(45) NOT NULL,
  `efforts` decimal(10,0) NOT NULL,
  `comments` text,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id_idx` (`project_id`),
  CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_priorities_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_priorities_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `priority` varchar(255) NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `priority` (`priority`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_resource_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_resource_plan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `phase` varchar(45) DEFAULT NULL,
  `engagement_type` varchar(45) NOT NULL,
  `role` varchar(45) DEFAULT NULL,
  `module` varchar(45) DEFAULT NULL,
  `resource_type` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `efforts` decimal(10,0) DEFAULT NULL,
  `resource_name` varchar(45) DEFAULT NULL,
  `experience` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `comments` text,
  `start_date` varchar(45) DEFAULT NULL,
  `end_date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_resources_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_resources_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id_nm` int NOT NULL,
  `user_id_nm` int NOT NULL,
  `active_yn` int NOT NULL DEFAULT '1',
  `resource_type` enum('onsite','offshore') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'offshore',
  `resource_type_title` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date_dt` datetime DEFAULT NULL,
  `end_date_dt` datetime DEFAULT NULL,
  `percentage_of_allocation` int DEFAULT NULL,
  `status` enum('assigned','planned') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'assigned',
  `comments` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_nm` int DEFAULT NULL,
  `updated_by_nm` int DEFAULT NULL,
  `created_at_dt` datetime DEFAULT NULL,
  `updated_at_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41894 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_severity_master_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_severity_master_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `severity_tx` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_status_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_status_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `dt_created` datetime NOT NULL,
  `company_id` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_tx` (`status_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_subtype_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_subtype_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `project_type_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_type_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_tx` (`type_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_code` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int NOT NULL DEFAULT '1',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `uniq_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workflow_id` int DEFAULT '0',
  `project_type` int NOT NULL DEFAULT '1',
  `sub_type` tinyint NOT NULL DEFAULT '1',
  `default_assign` int NOT NULL,
  `isactive` tinyint NOT NULL DEFAULT '1',
  `rate` float DEFAULT NULL,
  `estimated_hours` decimal(10,0) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `po_number` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `budget` float DEFAULT '0',
  `cost_approved` float DEFAULT '0',
  `status_id` int DEFAULT NULL,
  `type_id` int DEFAULT NULL,
  `technology_id` int DEFAULT NULL,
  `manager` int DEFAULT NULL,
  `hourly_rate` int DEFAULT '0',
  `min_range_percent` int DEFAULT '0',
  `max_range_percent` int DEFAULT '0',
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USD',
  `industry_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_customer_id` int DEFAULT '0',
  `initiator` int DEFAULT NULL,
  `progress` int DEFAULT NULL,
  `priority` int DEFAULT NULL,
  `display_custom_field` tinyint DEFAULT '0',
  `project_orders` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope_of_work` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billability` int DEFAULT '0',
  `billable_type` int NOT NULL DEFAULT '0',
  `project_manager` int NOT NULL DEFAULT '0',
  `account_manager` int DEFAULT '0',
  `project_coordinator` int DEFAULT NULL,
  `task_status_group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dt_created` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  `sector` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `closed_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `project_status_t` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `responsibilities_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsibilities_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_nm` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_actions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `role_id` int NOT NULL,
  `action_id` int NOT NULL,
  `is_allowed` tinyint NOT NULL DEFAULT '1' COMMENT '1=Allowed, 0= Not Allowed',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10010 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `is_allowed` tinyint DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_menu_menuId_roleId_unique` (`role_id`,`menu_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `role_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles_t` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `module_id` int NOT NULL,
  `role_id` int NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1' COMMENT '1=Enabled, 2=Disabled',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1160 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles_resp_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_resp_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id_nm` int NOT NULL,
  `responsibility_id_nm` int NOT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_resp_t_responsibilityIdNm_roleIdNm_unique` (`role_id_nm`,`responsibility_id_nm`),
  KEY `responsibility_id_nm` (`responsibility_id_nm`),
  CONSTRAINT `roles_resp_t_ibfk_1` FOREIGN KEY (`role_id_nm`) REFERENCES `roles_t` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `roles_resp_t_ibfk_2` FOREIGN KEY (`responsibility_id_nm`) REFERENCES `responsibilities_t` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name_tx` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_role_nm` int DEFAULT NULL,
  `is_active_nm` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sb_locations_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sb_locations_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sb_qualifications_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sb_qualifications_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sb_skillcategories_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sb_skillcategories_t` (
  `id` int NOT NULL,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id_nm` int DEFAULT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sb_skills_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sb_skills_t` (
  `id` int NOT NULL,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id_nm` int DEFAULT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sb_teams_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sb_teams_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sector_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sector_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sub_department_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_department_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dept_id` int NOT NULL,
  `name_tx` varchar(255) NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dept_id` (`dept_id`),
  CONSTRAINT `sub_department_t_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department_t` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `task_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_tx` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `uniq_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id_nm` int NOT NULL,
  `billability_nm` tinyint(1) DEFAULT '0',
  `parent_task_nm` int DEFAULT NULL,
  `milestone_id_nm` int DEFAULT NULL,
  `created_by_nm` int NOT NULL,
  `priority_nm` int DEFAULT NULL,
  `start_date_dt` date DEFAULT NULL,
  `estimated_hours_nm` int DEFAULT NULL,
  `revised_efforts_nm` int DEFAULT NULL,
  `spent_hours_nm` int NOT NULL DEFAULT '0',
  `due_date_dt` date DEFAULT NULL,
  `projected_date_dt` date DEFAULT NULL,
  `completion` decimal(10,2) DEFAULT '0.00',
  `task_type_nm` int DEFAULT NULL,
  `task_status_nm` int DEFAULT NULL,
  `comments` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at_dt` datetime DEFAULT NULL,
  `updated_at_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_type_nm` (`task_type_nm`),
  KEY `task_status_nm` (`task_status_nm`),
  CONSTRAINT `task_t_ibfk_3` FOREIGN KEY (`task_type_nm`) REFERENCES `tasktypes_t` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `task_t_ibfk_4` FOREIGN KEY (`task_status_nm`) REFERENCES `taskstatus_t` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=481186 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `task_time_log_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_time_log_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id_nm` int NOT NULL,
  `task_id_nm` int NOT NULL,
  `billable_task__yn` int NOT NULL,
  `user_id_nm` int NOT NULL,
  `start_date_dt` date DEFAULT NULL,
  `end_date_dt` date DEFAULT NULL,
  `estimated_hours_nm` int DEFAULT NULL,
  `total_hours_nm` int DEFAULT NULL,
  `hours_spent_nm` int DEFAULT NULL,
  `break_hours_nm` int DEFAULT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tasksancestors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasksancestors` (
  `task_id` int NOT NULL,
  `ancestor_id` int NOT NULL,
  PRIMARY KEY (`task_id`,`ancestor_id`),
  UNIQUE KEY `tasksancestors_task_id_ancestor_id_unique` (`task_id`,`ancestor_id`),
  KEY `ancestor_id` (`ancestor_id`),
  CONSTRAINT `tasksancestors_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task_t` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tasksancestors_ibfk_2` FOREIGN KEY (`ancestor_id`) REFERENCES `task_t` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `taskstatus_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taskstatus_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_value_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_nm` tinyint NOT NULL DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_tx` (`status_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tasktypes_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasktypes_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_type_name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_nm` tinyint NOT NULL DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `task_type_name_tx` (`task_type_name_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `technologies_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `technologies_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active_yn` tinyint DEFAULT '1',
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_tx` (`name_tx`),
  UNIQUE KEY `code_tx` (`code_tx`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `time_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `time_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `task_id` int DEFAULT NULL,
  `task_date` datetime DEFAULT NULL,
  `total_hours` int DEFAULT NULL,
  `is_billable` tinyint DEFAULT NULL,
  `is_default_task` tinyint DEFAULT NULL,
  `default_project_id` int DEFAULT NULL,
  `default_task_id` int DEFAULT NULL,
  `task_status` tinyint DEFAULT '0',
  `timesheet_flag` tinyint DEFAULT '0',
  `reporting_manager_id` int DEFAULT NULL,
  `reporting_manager_action` enum('Pending','Approve','Reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `reporting_manager_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_manager_id` int DEFAULT NULL,
  `project_manager_action` enum('Pending','Approve','Reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `project_manager_comment` int DEFAULT NULL,
  `description` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `timesheet_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timesheet_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` int DEFAULT NULL,
  `week_number` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `is_default_task` tinyint DEFAULT NULL,
  `default_project_id` int DEFAULT NULL,
  `default_task_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `task_id` int DEFAULT NULL,
  `dayofweek` int DEFAULT NULL,
  `hours` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `default_project_id` (`default_project_id`),
  KEY `default_task_id` (`default_task_id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `timesheet_logs_ibfk_1` FOREIGN KEY (`default_project_id`) REFERENCES `default_project` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `timesheet_logs_ibfk_2` FOREIGN KEY (`default_task_id`) REFERENCES `default_project_tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `timesheet_logs_ibfk_4` FOREIGN KEY (`task_id`) REFERENCES `task_t` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=571397 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `timesheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timesheets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` int DEFAULT NULL,
  `week_number` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `task_id` int DEFAULT NULL,
  `is_billable` tinyint DEFAULT NULL,
  `is_default_task` tinyint DEFAULT NULL,
  `default_project_id` int DEFAULT NULL,
  `default_task_id` int DEFAULT NULL,
  `approved_hours` int DEFAULT NULL,
  `user_comments` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `reporting_manager_id` int DEFAULT NULL,
  `reporting_manager_action` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'Pending',
  `reporting_manager_comment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `project_manager_id` int DEFAULT NULL,
  `project_manager_action` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'Pending',
  `project_manager_approved_hrs` int DEFAULT NULL,
  `project_manager_comment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `submitted_date` datetime DEFAULT NULL,
  `rm_approved_date` datetime DEFAULT NULL,
  `timesheet_status` tinyint(1) DEFAULT '0',
  `timesheet_comment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_record` (`year`,`week_number`,`user_id`,`project_id`,`task_id`),
  KEY `user_id` (`user_id`),
  KEY `project_id` (`project_id`),
  KEY `task_id` (`task_id`),
  KEY `default_project_id` (`default_project_id`),
  KEY `default_task_id` (`default_task_id`),
  KEY `reporting_manager_id` (`reporting_manager_id`),
  KEY `project_manager_id` (`project_manager_id`),
  KEY `UNIQUE` (`year`,`week_number`,`user_id`,`project_id`,`task_id`),
  CONSTRAINT `timesheets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_t` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `timesheets_ibfk_4` FOREIGN KEY (`default_project_id`) REFERENCES `default_project` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `timesheets_ibfk_5` FOREIGN KEY (`default_task_id`) REFERENCES `default_project_tasks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `timesheets_ibfk_6` FOREIGN KEY (`reporting_manager_id`) REFERENCES `users_t` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `timesheets_ibfk_7` FOREIGN KEY (`project_manager_id`) REFERENCES `users_t` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94314 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `company_id` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_roles_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id_nm` int NOT NULL,
  `role_id_nm` int NOT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12219 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_tasks_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_tasks_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id_nm` int NOT NULL,
  `task_id_nm` int NOT NULL,
  `project_id_nm` int NOT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_tasks_t_taskIdNm_userIdNm_unique` (`user_id_nm`,`task_id_nm`),
  KEY `task_id_nm` (`task_id_nm`)
) ENGINE=InnoDB AUTO_INCREMENT=58849 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users_t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_t` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_name_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '123456789',
  `password_tx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `joined_on` date DEFAULT NULL,
  `primary_skill` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `sub_department_id` int DEFAULT NULL,
  `division_id` int DEFAULT NULL,
  `designation` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `reporting_manager_nm` int NOT NULL DEFAULT '0',
  `is_competency_mgr` tinyint(1) DEFAULT NULL,
  `is_reporting_manager` tinyint(1) DEFAULT NULL,
  `competency` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_nm` int NOT NULL DEFAULT '1',
  `updated_by_nm` int NOT NULL DEFAULT '1',
  `activate_yn_nm` tinyint DEFAULT '0',
  `last_login_dt` datetime DEFAULT NULL,
  `login_failures_nm` int NOT NULL DEFAULT '0',
  `last_login_failure_dt` datetime DEFAULT NULL,
  `created_at_dt` datetime NOT NULL,
  `updated_at_dt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id_UNIQUE` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10433 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

