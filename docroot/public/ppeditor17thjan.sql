/*
SQLyog Community Edition- MySQL GUI v7.0  
MySQL - 5.1.33-community : Database - ppeditor1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`processpedia_redesign` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `processpedia_redesign`;

/*Table structure for table `pp_configuration` */

DROP TABLE IF EXISTS `pp_configuration`;

CREATE TABLE `pp_configuration` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `OpsSpecialistName` varchar(50) NOT NULL,
  `OpsSpecialistEmailId` varchar(50) NOT NULL,
  `TechAgencyLeadName` varchar(50) NOT NULL,
  `TechAgencyLeadEmailId` varchar(50) NOT NULL,
  `TechAgencyDeveloperName` varchar(50) NOT NULL,
  `TechAgencyDeveloperEmailId` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `pp_configuration` */

insert  into `pp_configuration`(`Id`,`OpsSpecialistName`,`OpsSpecialistEmailId`,`TechAgencyLeadName`,`TechAgencyLeadEmailId`,`TechAgencyDeveloperName`,`TechAgencyDeveloperEmailId`) values (1,'dipa','nnita.dipa@gmail.com','dipa133','nnita.dipa@gmail.com','dddd','nnita.dipa@gmail.com');

/*Table structure for table `pp_content_attachment` */

DROP TABLE IF EXISTS `pp_content_attachment`;

CREATE TABLE `pp_content_attachment` (
  `AId` int(11) NOT NULL AUTO_INCREMENT,
  `RequestId` bigint(20) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `File` varchar(100) NOT NULL,
  `MetaData` text NOT NULL,
  PRIMARY KEY (`AId`),
  KEY `FK_pp_attachment` (`RequestId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `pp_content_attachment` */

/*Table structure for table `pp_documents` */

DROP TABLE IF EXISTS `pp_documents`;

CREATE TABLE `pp_documents` (
  `DocumentId` int(11) NOT NULL AUTO_INCREMENT,
  `RequestId` bigint(20) NOT NULL,
  `Folder` tinyint(4) NOT NULL,
  `File` varchar(100) NOT NULL,
  `MetaData` text NOT NULL,
  PRIMARY KEY (`DocumentId`),
  KEY `FK_pp_documents` (`RequestId`),
  CONSTRAINT `FK_pp_documents` FOREIGN KEY (`RequestId`) REFERENCES `pp_requests` (`RequestId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `pp_documents` */

insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (1,16,127,'dppb-template0212_52e0d943dac0d.docx','Dipa Test');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (2,17,127,'dppb-template0212_52e0dba565621.docx','Dipa Test');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (3,18,127,'dppb-template0212_52e0dbd9f0d98.docx','Dipa Test');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (4,19,127,'dppb-template0212_52e0dbed2575d.docx','Dipa Test');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (5,20,127,'dppb-template0212_52e0dbf840d4d.docx','Dipa Test');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (6,21,127,'dppb-template0212_52e0dc4e217af.docx','test dipa123');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (7,22,127,'dppb-template0212_52e0dc83777fd.docx','test dipa123');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (8,23,127,'dppb-template0212_52e0dcdbba5a0.docx','test dipa123');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (9,24,127,'dppb-template0212_52e0de9753e61.docx','fffffffffff');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (10,25,127,'dppb-template0212_52e0debc773ab.docx','fffffffffff');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (11,26,127,'dppb-template0212_52e0dedd6b952.docx','fffffffffffrrrrrrrr');
insert  into `pp_documents`(`DocumentId`,`RequestId`,`Folder`,`File`,`MetaData`) values (12,27,127,'dppb-template0212_52e0e6ae65839.docx','Test3333');

/*Table structure for table `pp_mastertemplates` */

DROP TABLE IF EXISTS `pp_mastertemplates`;

CREATE TABLE `pp_mastertemplates` (
  `TemplateId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `TemplateName` varchar(50) NOT NULL,
  `TemplateType` varchar(20) NOT NULL,
  `TemplateLayout` longtext NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  PRIMARY KEY (`TemplateId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `pp_mastertemplates` */

insert  into `pp_mastertemplates`(`TemplateId`,`TemplateName`,`TemplateType`,`TemplateLayout`,`CreatedOn`,`UpdatedOn`,`CreatedBy`) values (1,'Playbook Master Template','p','<h3><span style=\"background-color: #ccffcc;\">A sub-subtopic</span></h3>\r\n<p class=\"ppbody\">Xxxxx</p>\r\n<p class=\"ppbody\">To communicate P&amp;G&rsquo;s definite expectations, use the compliance statement format.</p>\r\n<p class=\"ppbody\"><span style=\"background-color: #ccffcc;\">COMPLIANCE STATEMENT</span></p>\r\n<p class=\"ppbody\">?If xxxxx: Xxxxx.</p>','0000-00-00 00:00:00','0000-00-00 00:00:00',1);
insert  into `pp_mastertemplates`(`TemplateId`,`TemplateName`,`TemplateType`,`TemplateLayout`,`CreatedOn`,`UpdatedOn`,`CreatedBy`) values (2,'Process Guide','pg','<h3><span style=\"background-color: #ccffcc;\">A sub-subtopic</span></h3>\r\n<p class=\"ppbody\">Xxxxx</p>\r\n<p class=\"ppbody\">To communicate P&amp;G&rsquo;s definite expectations, use the compliance statement format.</p>\r\n<p class=\"ppbody\"><span style=\"background-color: #ccffcc;\">COMPLIANCE STATEMENT</span></p>\r\n<p class=\"ppbody\">?If xxxxx: Xxxxx.</p>','0000-00-00 00:00:00','0000-00-00 00:00:00',1);

/*Table structure for table `pp_messages` */

DROP TABLE IF EXISTS `pp_messages`;

CREATE TABLE `pp_messages` (
  `MessageId` int(11) NOT NULL AUTO_INCREMENT,
  `RequestId` bigint(20) NOT NULL,
  `Message` text NOT NULL,
  `AssignedTo` int(11) DEFAULT NULL,
  `Status` varchar(2) DEFAULT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `MessageBy` int(11) NOT NULL,
  `MessageTo` int(11) DEFAULT NULL,
  PRIMARY KEY (`MessageId`),
  KEY `FK_pp_messages` (`RequestId`),
  CONSTRAINT `FK_pp_messages` FOREIGN KEY (`RequestId`) REFERENCES `pp_requests` (`RequestId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `pp_messages` */

insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (1,1,'sadasdasda',1,'1','0000-00-00 00:00:00',1,2);
insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (2,1,'I have sent request to upload playbook 1 through tech agency. Please help.',NULL,NULL,NULL,1,2);
insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (3,1,'sadasdasd',NULL,'4','2014-01-21 17:31:27',1,0);
insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (4,1,'sadasdasd',NULL,'4','2014-01-21 17:32:35',1,0);
insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (5,1,'test test test',NULL,'4','2014-01-21 17:32:44',1,0);
insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (6,25,'hhhhhhhhhhhhhh',NULL,'3','2014-01-23 14:49:56',1,NULL);
insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (7,26,'hhhhhhhhhhhhhhrrrrr',NULL,'3','2014-01-23 14:50:29',1,NULL);
insert  into `pp_messages`(`MessageId`,`RequestId`,`Message`,`AssignedTo`,`Status`,`CreatedOn`,`MessageBy`,`MessageTo`) values (8,27,'Test3333',NULL,'3','2014-01-23 15:23:50',1,NULL);

/*Table structure for table `pp_requests` */

DROP TABLE IF EXISTS `pp_requests`;

CREATE TABLE `pp_requests` (
  `RequestId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Type` enum('p','d','pg') NOT NULL,
  `Name` varchar(150) NOT NULL,
  `DocumentUrl` varchar(150) DEFAULT NULL,
  `StagingUrl` varchar(250) DEFAULT NULL,
  `ProductionUrl` varchar(250) DEFAULT NULL,
  `CreatedOn` datetime NOT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `AssignedTo` int(11) DEFAULT NULL,
  PRIMARY KEY (`RequestId`),
  KEY `NewIndex1` (`Status`,`AssignedTo`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `pp_requests` */

insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (1,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,3,4,1);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (2,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,1,4,1);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (3,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,1,4,4);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (4,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,1,4,4);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (5,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,1,4,4);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (6,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,1,4,4);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (7,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,1,4,4);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (8,'d','test',NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,1,4,4);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (9,'','sdsdfs',NULL,NULL,NULL,'2014-01-23 14:17:14',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (10,'','sdsdfs',NULL,NULL,NULL,'2014-01-23 14:18:05',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (11,'','sdsdfs',NULL,NULL,NULL,'2014-01-23 14:18:33',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (12,'','Dipa Test',NULL,NULL,NULL,'2014-01-23 14:19:44',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (13,'pg','Dipa Test',NULL,NULL,NULL,'2014-01-23 14:21:52',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (14,'d','Dipa Test',NULL,NULL,NULL,'2014-01-23 14:22:55',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (15,'d','Dipa Test',NULL,NULL,NULL,'2014-01-23 14:23:23',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (16,'d','Dipa Test',NULL,NULL,NULL,'2014-01-23 14:26:35',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (17,'d','Dipa Test 123',NULL,NULL,NULL,'2014-01-23 14:36:45',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (18,'d','Dipa Test 123',NULL,NULL,NULL,'2014-01-23 14:37:38',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (19,'d','Dipa Test 123',NULL,NULL,NULL,'2014-01-23 14:37:57',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (20,'d','Dipa Test 123',NULL,NULL,NULL,'2014-01-23 14:38:08',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (21,'d','test dipa123',NULL,NULL,NULL,'2014-01-23 14:39:34',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (22,'d','test dipa123',NULL,NULL,NULL,'2014-01-23 14:40:27',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (23,'d','test dipa123',NULL,NULL,NULL,'2014-01-23 14:41:55',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (24,'d','test test',NULL,NULL,NULL,'2014-01-23 14:49:19',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (25,'d','test test',NULL,NULL,NULL,'2014-01-23 14:49:56',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (26,'d','test test 444444444',NULL,NULL,NULL,'2014-01-23 14:50:29',NULL,1,3,0);
insert  into `pp_requests`(`RequestId`,`Type`,`Name`,`DocumentUrl`,`StagingUrl`,`ProductionUrl`,`CreatedOn`,`UpdatedOn`,`CreatedBy`,`Status`,`AssignedTo`) values (27,'d','Test3333',NULL,NULL,NULL,'2014-01-23 15:23:50',NULL,1,3,0);

/*Table structure for table `pp_requests_contents` */

DROP TABLE IF EXISTS `pp_requests_contents`;

CREATE TABLE `pp_requests_contents` (
  `ContentId` int(11) NOT NULL AUTO_INCREMENT,
  `RequestId` bigint(20) NOT NULL,
  `TemplateId` smallint(6) NOT NULL,
  `Content` text NOT NULL,
  PRIMARY KEY (`ContentId`),
  KEY `FK_pp_requests_content` (`RequestId`),
  CONSTRAINT `FK_pp_requests_content` FOREIGN KEY (`RequestId`) REFERENCES `pp_requests` (`RequestId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pp_requests_contents` */

/*Table structure for table `term_data` */

DROP TABLE IF EXISTS `term_data`;

CREATE TABLE `term_data` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` longtext,
  `weight` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `taxonomy_tree` (`vid`,`weight`,`name`),
  KEY `vid_name` (`vid`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=198 DEFAULT CHARSET=utf8;

/*Data for the table `term_data` */

insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (16,1,'Community','Community',6);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (14,1,'Social','Playbook for social applications',28);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (15,1,'Development ','developement',11);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (13,1,'mApps','Abbreviation for “mobile application(s)”',18);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (21,1,'Desktop website','A website designed primarily for use in desktop/ workstation browsers (vs. mobile or tablet browsers)',10);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (12,1,'Playbook','Tags only for playbook page',1);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (22,1,'Web Storage','Web Storage',32);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (23,1,'multimedia','multimedia',21);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (24,1,'Web Accessibility','Web Accessibility',30);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (20,1,'Mobile sites','Mobile sites',19);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (30,1,'web OTS','Web OTS',31);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (17,1,'Buddy Media ','Buddy Media ',5);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (18,1,'HTML5','HTML5',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (19,1,'CSS3','CSS3',8);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (25,1,'mWeb','Abbreviation for “mobile Web site(s)”',22);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (26,1,'eCommerce','Digital presences that sell products to consumers or professionals',12);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (27,1,'Promotions','Digital presences that either promote events such as sweepstakes and contests or offer online coupons, refunds or other similar types of services',25);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (28,1,'Educational','Educational sites',13);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (29,1,'Recruiting','Recruiting sites',27);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (32,1,'Conformance','Satisfying all requirements of a given standard, guideline or specification.',7);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (33,1,'BI','Business Intelligence',3);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (34,1,'P&G','Procter & Gamble',23);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (35,1,'PII','Personally identifiable information',24);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (36,1,'PSA','Privacy, Security, and Access\r\n\r\n',26);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (37,1,'1CP','1, Consumer Place (GBS)',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (38,1,'BU','Business Unit',4);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (39,1,'GBS','Global Business Services',16);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (40,1,'GBU','Global Business Unit',17);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (41,1,'Spotfire','P&G’s enterprise BI tool',29);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (42,1,'CV','Custom Variables',9);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (43,1,'MPID','Marketing Program ID [1, Consumer Place; GA CV slot 50]',20);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (44,1,'AP','[Google Analytics] Accounts and Profiles',1);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (45,1,'GA','Google Analytics',14);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (46,1,'GAP','Google Analytics Premium',15);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (73,4,'MPID','Marketing Program ID [1, Consumer Place; GA CV slot 50]',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (71,4,'CV','Custom Variables',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (72,4,'Desktop website','A website designed primarily for use in desktop/ workstation browsers (vs. mobile or tablet browsers)',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (74,4,'AP','[Google Analytics] Accounts and Profiles',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (62,4,'P&G ','Procter & Gamble',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (63,4,'BI','Business Intelligence',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (64,4,'PII','Personally identifiable information',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (65,4,'PSA','Privacy, Security, and Access',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (66,4,'1CP','1, Consumer Place (GBS)',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (67,4,'BU','Business Unit',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (68,4,'GBS','Global Business Services[, or “Services” for short?]',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (69,4,'GBU','Global Business Unit',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (70,4,'Spotfire','P&G’s enterprise BI tool',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (75,4,'GA','Google Analytics',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (76,4,'GAP','Google Analytics Premium',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (77,5,'Promotions','Digital presences that either promote events such as sweepstakes and contests or offer online coupons, refunds or other similar types of services',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (78,5,'eCommerce','Digital presences that sell products to consumers or professionals',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (79,5,'mAPP','Abbreviation for “mobile application(s)”',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (80,5,'mWeb','Abbreviation for “mobile Web site(s)”',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (81,5,'Consumer Facing Digital Property','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (82,5,'Digital Property','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (83,5,'Go-to-market capability','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (84,5,'Scorecarding','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (85,5,'Conformance','Satisfying all requirements of a given standard, guideline or specification.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (86,5,'Level A conformance','A Web site that eliminates major accessibility barriers only. This does not imply much in terms of accessibility.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (87,5,'Level AA conformance','A Web site that is accessible for most people, under most circumstances, with most technologies they use.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (88,6,'analytics','For insights and business value, automated processing of data received through target audience members’ interactivity with presences. Optimal results depend on high quality in data structures.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (89,6,'Consumer facing digital presence','A digital property created for use by our consumers.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (90,6,'Dev1234','Developer. See also IT-D.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (91,6,'digital presence','A web site, social web page, or mobile Web site or application dedicated to carrying a message for a brand or the enterprise. See also “DP” and “Presence.”',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (92,6,'Digital property','An application in the digital arena, such as a web site, social web page, or mobile Web site or application.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (93,6,'DP','Digital Presence—typically a consumer-facing Web site, social site, or mobile site or application.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (94,6,'DPDL','Digital Presence Delivery Lead',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (95,6,'DPP','Digital presence platform, referring to sets of capabilities existing and possible, and (in-)compatibilities.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (96,6,'ER','External relations.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (97,6,'GBS Capabilities','A set of functions in each of our platform areas, for example, BIN (Buy Now) in the Digital Presence platform.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (98,6,'GBS Security','The organization responsible for setting and enforcing security policies.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (99,6,'GCR','Global Consumer Relations, working closely with P&G External Relations, is the area of GBS that manages relationships and activities with consumers.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (100,6,'IT-D','The information technology team in GBS responsible for IT development work.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (101,6,'Playbook123','A how-to manual for creating digital presences for P&G. As a set, the playbooks cover most if not all digital platforms. ',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (103,6,'Presence','Classification(s) of P&G Web sites—from basic (“Required Presence”), to medium (“Standard”), to sophisticated (“CRM”). See chart on page 3',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (104,6,'Process guide ','Step-by-step details about a task from a playbook. These can be recommendations, best practices, or required approaches.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (105,6,'Solution manager','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (106,6,'White label site','A Web site that showcases, and allows viewers to “walk through,” an OTS template and its features but is not cloaked with the context of a specific product or branding.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (107,7,'Analytics','For insights and business value, automated processing of data received through target audience members’ interactivity with presences. Optimal results depend on high quality in data structures.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (108,7,'Community management','Buddy Media and Vitrue. (Although ThisMoment may develop for all touch points, we do NOT allow use of its community management platform.)',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (109,7,'Consumer facing digital property','A digital property created for use by our consumers.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (110,7,'Dev123','Developer.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (111,7,'Development','An app iframed into Facebook or YouTube, even those that look as if they are on Facebook or YouTube sites.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (112,7,'Digital presence','A web site, social web page, or mobile Web site or application dedicated to carrying a message for a brand or the enterprise. See also “DP” and “Presence.”',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (113,7,'Digital property','An application in the digital arena, such as a web site, social web page, or mobile Web site or application.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (114,7,'DMM','Digital Marketing Manager.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (115,7,'DP','GBS Digital Presence, typically a consumer-facing Web site, social site, or mobile site or application.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (116,7,'DPP','Digital presence platform, referring to sets of capabilities existing and possible, and (in-)compatibilities.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (117,7,'ER','External Relations.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (118,7,'EZ ID','An ID provided by the DMM and entered in the EZ System to track the social digital presence and the means for GBS to charge back to the brand.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (119,7,'IO code','The Internal Order code from the brand, to which GBS will charge back to.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (120,7,'GBS Capabilities','A set of functions in each of our platform areas, for example, BIN (Buy Now) in the Digital Presence platform.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (121,7,'GBS Security','The organization responsible for setting and enforcing security policies.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (122,7,'GCR','Global Consumer Relations, working closely with P&G External Relations, is the area of GBS that manages relationships and activities with consumers.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (123,7,'OTS','Off the shelf templates and capabilities, as part of GBS services, offering Brands more choices at lower costs.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (124,7,'Playbook','A how-to manual for creating digital presences for P&G. As a set, the playbooks cover most if not all digital platforms. ',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (125,7,'Presence','Same as DP. ',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (126,7,'Presence','Classification(s) of P&G Web sites—from basic (“Required Presence”), to medium (“Standard”), to sophisticated (“CRM”). See chart on page 3.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (127,7,'Process guide ','Step-by-step details about a task from a playbook. These can be recommendations, best practices, or required approaches.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (128,8,'Analytics','For insights and business value, automated processing of data received through target audience members’ interactivity with presences. Optimal results depend on quality in data structures.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (129,8,'Consumer facing digital property','A digital property created for use by our consumers.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (130,8,'DCA','Digital Consumer Analyst (used to be called ‘DMM’)',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (131,8,'Dev','Developer.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (132,8,'Digital presence123','A web site, social web page, mobile Web site or application dedicated to carrying a message for a brand or the enterprise. See also “DP” and “Presence.”',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (133,8,'Digital property','An application in the digital arena, such as a web site, social web page, or mobile Web site or application.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (134,8,'DMM','Digital Marketing Manager (now called ‘DCA’)',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (135,8,'DPDL','Digital Presence Delivery Lead.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (136,8,'DM','Deployment Manager',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (137,8,'DP','GBS Digital Presence, typically a consumer-facing Web site, social site, or mobile site or application.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (138,8,'DPP','Digital presence platform, referring to sets of capabilities existing and possible, and compatibilities and incompatibilities.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (139,8,'ER','External Relations.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (140,8,'EZ ID','A tracking identity that a DMM assigns to a social digital presence and enters into the EZ system, for GBS chargeback purposes.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (141,8,'IO code','A brand’s Internal Order code, for GBS chargeback purposes.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (142,8,'GBS Security','Responsible for setting and enforcing security policies.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (143,8,'GCR','Global Consumer Relations, working closely with P&G External Relations, is the area of GBS that manages relationships and activities with consumers.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (144,8,'Playbook12345','A how-to manual for creating digital presences for P&G. As a set, the playbooks cover most if not all digital platforms. ',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (146,8,'Presence','Classification(s) of P&G Web sites—from basic (“Required Presence”), to medium (“Standard”), to sophisticated (“CRM”). See chart on page 3.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (147,8,'Process guide ','Step-by-step details about a task from a playbook. These can be recommendations, best practices, or required approaches.',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (148,1,'EMS','The GBS Email Marketing Service ',2);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (149,6,'P&G','Procter and Gamble',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (169,10,'Web Dev Process','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (170,10,'Maintenance Process','',2);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (171,10,'Learning & Sharing','',1);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (172,4,'social presences','social presences  Dummy description added here',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (174,6,'social presences','social presences',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (175,6,'compliance statements','compliance statements',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (176,6,'OTS','OTS dummy text',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (178,6,'PII','Personally Identified information\r\n',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (179,6,'GCR','GCR dummy text added here',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (180,6,'Work Order','Work Order dummy text added here',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (181,6,'EZ ID','EZ ID dummy text added here',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (182,6,'IO Code','IO Code dummy text added here',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (183,10,'R2O','',3);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (184,10,'Platform Roadmaps','',4);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (185,10,'Newsletters','',5);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (188,11,'Incident Management','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (187,10,'PSAT Compliance','',7);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (189,11,'Change Management','',1);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (190,11,'Problem Management','',2);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (191,11,'Release Management','',3);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (192,11,'Operational Level Agreement','',4);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (193,11,'Roles and Responsibilities','',5);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (194,11,'Operations Tools','',6);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (195,11,'Contact List','',7);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (196,12,'PSAT','',0);
insert  into `term_data`(`tid`,`vid`,`name`,`description`,`weight`) values (197,12,'BV API','',1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `uid` double DEFAULT NULL,
  `name` varchar(180) DEFAULT NULL,
  `pass` varchar(96) DEFAULT NULL,
  `mail` varchar(192) DEFAULT NULL,
  `mode` tinyint(4) DEFAULT NULL,
  `sort` tinyint(4) DEFAULT NULL,
  `threshold` tinyint(4) DEFAULT NULL,
  `theme` varchar(765) DEFAULT NULL,
  `signature` varchar(765) DEFAULT NULL,
  `signature_format` int(11) DEFAULT NULL,
  `created` double DEFAULT NULL,
  `access` double DEFAULT NULL,
  `login` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `timezone` varchar(24) DEFAULT NULL,
  `language` varchar(36) DEFAULT NULL,
  `picture` varchar(765) DEFAULT NULL,
  `init` varchar(192) DEFAULT NULL,
  `data` blob
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1,'MTAdmin','c2e877d417aace78e49ba5105838b091','admin@processpedia.cs.pg.com',0,0,0,'','',1,1259553386,1389863483,1389848741,1,'19800','','','admin@mindtree.processnet.dev','a:2:{s:18:\"admin_compact_mode\";b:1;s:13:\"form_build_id\";s:37:\"form-02b5558123cc17e73499b818becab546\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (3,'AuthUser','c4ca4238a0b923820dcc509a6f75849b','author@processpedia.cs.pg.com',0,0,0,'','',1,1259555040,1363948991,1363948981,1,'19800','','','author@mindtree.processnet.dev','a:1:{s:13:\"form_build_id\";s:37:\"form-60077d43a65a3ec7753aecd43999f330\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (4,'approver','a015c1f40df74b5133e2fa929d42eb3c','approver@processpedia.cs.pg.com',0,0,0,'','',2,1259555060,1260345030,1260244972,1,'19800','','','approver@mindtree.processnet.dev','a:1:{s:13:\"form_build_id\";s:37:\"form-e3a86c060ce696ed806112354ac98f03\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (62,'ppJeff','9879368a8ea904d640014d1bbea11c39','jeffrey.c.pierce@accenture.com',0,0,0,'','',1,1276072917,1288189326,1288188885,1,'19800','','','jeffrey.c.pierce@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-54e344ed4cc1dfe0e0b19228e15e91a3\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (14,'PGUser','5d8ef9f46810760a6b516997191547b6','PGUser@processpedia.cs.pg.com',0,0,0,'','',2,1269517451,1389324002,1389324002,1,'19800','','','PGUser@mindtree.processnet.com','a:1:{s:13:\"form_build_id\";s:37:\"form-c8d0d55520b7dfd4c4bea73ede725a16\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (8,'balajik','3d3e8f33dc6845855134983ce3b6943b','balajik@mindtree.com',0,0,0,'','',2,1268153024,1306119030,1306119030,1,'-18000','','','balajik@mindtree.com','a:1:{s:13:\"form_build_id\";s:37:\"form-b20611446fd20d762f6081c1726e5a00\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (385,'michael.arent','3f1d7a0c565e2c108885bcea5bdba76f','michael.arent@hp.com',0,0,0,'','',0,1286559357,1286812112,1286806379,1,'19800','','','michael.arent@hp.com','a:1:{s:13:\"form_build_id\";s:37:\"form-88c42539fd8235451c8d2ed711a2dc7a\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (63,'Alankar','e10adc3949ba59abbe56e057f20f883e','Alankar@mindtree.com',0,0,0,'','',1,1276158339,1311141308,1311141103,0,'19800','','','Alankar@mindtree.com','a:1:{s:13:\"form_build_id\";s:37:\"form-ae68fe10898e92f2e709f70ee303f751\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (59,'UserAdminTest','c4ca4238a0b923820dcc509a6f75849b','Deep_Kapoor@mindtree.com',0,0,0,'','',2,1274868187,1322735567,1322735567,1,'19800','','','Deep_Kapoor@mindtree.com','a:1:{s:13:\"form_build_id\";s:37:\"form-2e1cda87abd1c328cd34f3d93838f404\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (60,'ppdavfel','8fe956395eeeb1a687f2430c34ee965e','david.feldman@accenture.com',0,0,0,'','',0,1275993317,1277917659,1277917659,1,'19800','','','david.feldman@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-f48ae81117fcb18e16b13bda991f8907\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (69,'ppUser','e99a18c428cb38d5f260853678922e03','siraj_khan@mindtree.com',0,0,0,'','',0,1284982950,1385120383,1385120383,1,'19800','','','siraj_khan@mindtree.com','a:1:{s:13:\"form_build_id\";s:37:\"form-dc6e35ccfffc60e0e47cce5b4da22257\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (71,'ppPeter','e99a18c428cb38d5f260853678922e03','peter.marci@accenture.com',0,0,0,'','',0,1284983161,1287501210,1287499455,1,'19800','','','peter.marci@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-91a65763a39d46d9d44118b9513341fc\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1468,'grisham.es_pg','e83333d5e27ec5f0dc27aa6fea605685','grisham.es@pg.com',0,0,0,'','',0,1361374210,1361374211,1361374261,1,'19800','','','grisham.es@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-5bce461801baf49884304382d3affba1\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1469,'hensley.z_pg','c20d0a5c762cafbd6d3801381e435185','hensley.z@pg.com',0,0,0,'','',0,1361374538,1361374538,1361374538,1,'19800','','','hensley.z@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-6c9067c642893854c24f475fca2de285\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1470,'houston.ce_pg','ec53ea70ae4392b82492e9f721046caf','houston.ce@pg.com',0,0,0,'','',0,1361383902,1361384420,1361383902,1,'19800','','','houston.ce@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-6fa67962995448b960f4ae563f8f9e80\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1471,'kowalczyk.to_pg','463a1dc2c0245e48f41b13ef1976e8f4','kowalczyk.to@pg.com',0,0,0,'','',0,1361389348,1366033295,1366033295,1,'19800','','','kowalczyk.to@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-81c5c82795866d8e40f3623236736467\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1472,'obrycki.l_pg','e686a33ac1a2a1268f8659e367bd1f07','obrycki.l@pg.com',0,0,0,'','',0,1361432048,1381132284,1381132284,1,'19800','','','obrycki.l@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-e9c35a51ca2911e10aa44f368fa1f1c9\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1473,'stopa.p_pg','535a60fc6d78420ca8d93cbce9e13a70','stopa.p@pg.com',0,0,0,'','',0,1361434785,1364473998,1364473996,1,'19800','','','stopa.p@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-3713465902a745c435d2224c44b8b936\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1474,'tan.in_pg','72ff8f0cf575273f9cea9606d7b33fa9','tan.in@pg.com',0,0,0,'','',0,1361449166,1362068096,1362066709,1,'19800','','','tan.in@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-916ff572e01acbaa7334a50a1402e3cc\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1475,'herrington.cr_pg','966a06f115467333c5773f04ffb56307','herrington.cr@pg.com',0,0,0,'','',0,1361463027,1361463899,1361463027,1,'19800','','','herrington.cr@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-b01db0ca7447ba78ea39a5eb228aa31f\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1476,'sy.cc_pg','729ee2976af7e06d9f59c7a5abf64b88','sy.cc@pg.com',0,0,0,'','',0,1361467551,1363295490,1363295489,1,'19800','','','sy.cc@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-8472e1eb77c5298602e1f27600fc4f12\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1477,'shah.mn_pg','91d7fc613e5f555399e6c0e656424117','shah.mn@pg.com',0,0,0,'','',0,1361472266,1367587734,1367587734,1,'19800','','','shah.mn@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-73ad4b79fa5b5e08d405f92dbd2df83f\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1478,'crone.j_pg','1593e5eb308ec8b07d0cc6c74bcd42d0','crone.j@pg.com',0,0,0,'','',0,1361803955,1361809269,1361803955,1,'19800','','','crone.j@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-29f5be3a23002a9ac1a3d946270b0f44\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1479,'reed.j.18_pg','9495e3822f518dbd6516af2057198d89','reed.j.18@pg.com',0,0,0,'','',0,1361805114,1361808445,1361805114,1,'19800','','','reed.j.18@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-66bd0c599d1a224c39f51aa599ccc853\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1480,'sobrino.a_pg','ae6fb27094b6d3b896cd834e57f0e1f9','sobrino.a@pg.com',0,0,0,'','',0,1361805921,1367350757,1367350757,1,'19800','','','sobrino.a@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-5280235223818f18b557118807a87055\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1481,'hu.si_pg','99c57bedbaa13e2e35e7ac44ab6f9274','hu.si@pg.com',0,0,0,'','',0,1361847292,1361847483,1361847292,1,'19800','','','hu.si@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-2f58f953db38b7422bd0fd83a7ec892f\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1482,'wang.re.2_pg','905171dcf9b847d966089cfd735ad96e','wang.re.2@pg.com',0,0,0,'','',0,1361851312,1361851519,1361851313,1,'19800','','','wang.re.2@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-90f73cd9c75cb21d118b519150e8c6a9\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1483,'kazanowska.a_pg','1e58cb8c1004fc82b91d737e3e3721c4','kazanowska.a@pg.com',0,0,0,'','',0,1361883576,1364300558,1364300334,1,'19800','','','kazanowska.a@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-03c7d00e1c66002a179b64eb14c3de07\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1484,'kohati.s_pg','8854f3f119e415259048cf7ee3acd8ef','kohati.s@pg.com',0,0,0,'','',0,1361930568,1362718305,1362718305,1,'19800','','','kohati.s@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-03529715791f0e3af3ada1e40a0eaaa5\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1485,'sun.c.3_pg','a6953d586208cf9d7c41857a2d10a890','sun.c.3@pg.com',0,0,0,'','',0,1361966021,1361966022,1361966022,1,'19800','','','sun.c.3@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-53f7ee5b76d89f2128f7e5ebb12f441a\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (1486,'kocinski.j_pg','7a3415a399cf3a4adb6cd2b86791ce5d','kocinski.j@pg.com',0,0,0,'','',0,1362066393,1362413604,1362413604,1,'19800','','','kocinski.j@pg.com','a:1:{s:13:\"form_build_id\";s:37:\"form-8429f76f908275558ea93363ebef21ec\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (210,'Siraj','882da2fa8c2009581681da94ded9df5b','M1012322@mindtree.com',0,0,0,'','',2,1285308713,1346232663,1363948949,1,'19800','','','sirajrkhan@gmail.com','a:1:{s:13:\"form_build_id\";s:37:\"form-15d8a9188ba340962d9e56fdd28da93b\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (211,'satish.cs','1c5c95d20269dc09974d41e4d0100d9d','satish.cs@accenture.com',0,0,0,'','',0,1285308967,1306331476,1306330919,0,'19800','','','satish.cs@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-b88f871212a1b3fc33236a5b861319df\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (212,'radek.odrobina','16d4ee76192b5cd9e5ef0159e66d3d98','radek.odrobina@accenture.com',0,0,0,'','',0,1285309024,1285309024,0,1,'19800','','','radek.odrobina@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-a081b32450d43c84f58830ea371ef239\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (213,'AccentureAdmin','38aef20dcb41b31fbc09b8715dd0226f','chandra.m.munigala@accenture.com',0,0,0,'','',2,1285324751,1322653984,1325833381,1,'19800','','','M1012322@mindtree.com','a:1:{s:13:\"form_build_id\";s:37:\"form-70e190cb8043a6aa1a81cd2a14550862\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (216,'aarthee.lakkoju','e96a479c49f59f0f9e66875d0d856ab6','aarthee.lakkoju@accenture.com',0,0,0,'','',0,1285761764,1285778176,1285778176,0,'19800','','','aarthee.lakkoju@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-62430a4fe84b6a21b5512f4ccf661c98\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (217,'farooq.i.mohammed','a5bff91c197812a6da14c9e60d7a3c93','farooq.i.mohammed@accenture.com',0,0,0,'','',2,1285788325,1288883620,1288883038,1,'-18000','','','farooq.i.mohammed@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-aad18ece7f7b5c9069007976fe187a59\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (218,'david.neuman','58e6eb6c68bd85abeedee4b29f6180b7','david.neuman@avanade.com',0,0,0,'','',2,1285788587,1285788587,0,1,'-18000','','','david.neuman@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-b989f3db9425fa4932c2dd7b540a1324\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (219,'cliff.vaughn','58e6eb6c68bd85abeedee4b29f6180b7','cliff.vaughn@avanade.com',0,0,0,'','',0,1285788780,1285863086,1285862740,1,'-18000','','','cliff.vaughn@avanade.com','a:1:{s:13:\"form_build_id\";s:37:\"form-9f07767e6712f4e89532543ee2d761d4\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (220,'tim.rogan','58e6eb6c68bd85abeedee4b29f6180b7','tim.rogan@avanade.com',0,0,0,'','',0,1285815371,1285815371,0,1,'-18000','','','tim.rogan@avanade.com','a:1:{s:13:\"form_build_id\";s:37:\"form-0e65a5f5a8861c7de65c38cfecd10e47\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (221,'a.varghese','58e6eb6c68bd85abeedee4b29f6180b7','a.varghese@avanade.com',0,0,0,'','',0,1285815416,1286983878,1286983878,1,'-18000','','','a.varghese@avanade.com','a:1:{s:13:\"form_build_id\";s:37:\"form-e1fe9411f3a1c3c3a0dc323fbb65fe3d\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (222,'samba.x.doppalapudi','a1f300064914d043263aa6b5bfa86e15','samba.x.doppalapudi@accenture.com',0,0,0,'','',2,1285815623,1285816027,1285815782,1,'-18000','','','samba.x.doppalapudi@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-27dbc3653abf6392bd9a1c91a7e7509a\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (223,'aleksander.giece','e96a479c49f59f0f9e66875d0d856ab6','aleksander.giece@accenture.com',0,0,0,'','',0,1285815718,1285815718,0,1,'-18000','','','aleksander.giece@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-675b8b8e5353f86974aa12ab2d40d7a1\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (224,'young.c.hong','e96a479c49f59f0f9e66875d0d856ab6','young.c.hong@accenture.com',0,0,0,'','',0,1285816010,1285816010,0,1,'-18000','','','young.c.hong@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-fa60a20e94b450f55c8d73c60c6651bc\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (225,'e.mason','58e6eb6c68bd85abeedee4b29f6180b7','e.mason@avanade.com',0,0,0,'','',0,1285816057,1285816809,1285816808,1,'-18000','','','e.mason@avanade.com','a:1:{s:13:\"form_build_id\";s:37:\"form-b15f2abbc9cf5c84572fa48ce65a5448\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (226,'vijay.vellabati','58e6eb6c68bd85abeedee4b29f6180b7','vijay.vellabati@avanade.com',0,0,0,'','',0,1285816104,1285831174,1285831173,1,'-18000','','','vijay.vellabati@avanade.com','a:1:{s:13:\"form_build_id\";s:37:\"form-488be4d1396888c7428e8d335a91558e\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (227,'janien.a.montank','e96a479c49f59f0f9e66875d0d856ab6','janien.a.montank@accenture.com',0,0,0,'','',0,1285816130,1285816130,0,1,'-18000','','','janien.a.montank@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-416e20fc5dedefb7485dfbb9eb7bce3d\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (228,'scott.anderso','58e6eb6c68bd85abeedee4b29f6180b7','scott.anderso@avanade.com',0,0,0,'','',0,1285816183,1285816183,0,1,'-18000','','','scott.anderso@avanade.com','a:1:{s:13:\"form_build_id\";s:37:\"form-148629001789f62fe18e9d69d49b743b\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (229,'s.peddi','e96a479c49f59f0f9e66875d0d856ab6','s.peddi@accenture.com',0,0,0,'','',0,1285816222,1285816222,0,1,'-18000','','','s.peddi@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-4b6cf52749917960de42b63702295c1b\";}');
insert  into `users`(`uid`,`name`,`pass`,`mail`,`mode`,`sort`,`threshold`,`theme`,`signature`,`signature_format`,`created`,`access`,`login`,`status`,`timezone`,`language`,`picture`,`init`,`data`) values (230,'jermaine.lindsay','e96a479c49f59f0f9e66875d0d856ab6','jermaine.lindsay@accenture.com',0,0,0,'','',0,1285816288,1285866263,1285866263,1,'-18000','','','jermaine.lindsay@accenture.com','a:1:{s:13:\"form_build_id\";s:37:\"form-3a470d357c0386abc3e83f53181465ee\";}');

/*Table structure for table `vocabulary` */

DROP TABLE IF EXISTS `vocabulary`;

CREATE TABLE `vocabulary` (
  `vid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` longtext,
  `help` varchar(255) NOT NULL DEFAULT '',
  `relations` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hierarchy` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `multiple` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tags` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `module` varchar(255) NOT NULL DEFAULT '',
  `weight` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`),
  KEY `list` (`weight`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `vocabulary` */

insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (1,'Tags','','Enter tags for your \"Learning and Sharing\" content',1,1,1,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (5,'Web Accessibility Process Guide','This vocabulary is mainly used to  describe the web accessbility process guide term. ','',1,1,0,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (4,'Web Analytics Process Guide','This vocabulary is mainly used to describe the web analytics process guide terms.','',1,1,0,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (6,'Web OTS','This vocabulary is mainly used to describe the Web OTS term.','',1,1,0,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (7,'Social','This vocabulary is mainly used to describe the Social Term','',1,1,0,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (8,'mApp','This vocabulary is mainly used to describe the mApp term.','',1,1,0,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (10,'Processpedia Document','','',1,1,1,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (11,'WebOps Documents','','',1,0,1,0,0,'taxonomy',0);
insert  into `vocabulary`(`vid`,`name`,`description`,`help`,`relations`,`hierarchy`,`multiple`,`required`,`tags`,`module`,`weight`) values (12,'Training Matrials','','',1,1,1,0,0,'taxonomy',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
