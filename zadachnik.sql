/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 5.7.33 : Database - zadachnik
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zadachnik` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `zadachnik`;

/*Table structure for table `tasks` */

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_2` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tasks` */

insert  into `tasks`(`id`,`name`,`source`,`source_2`,`user_id`,`date`,`status`,`comment`) values 
(1,'Супориши 3','5. намунаи ариза.docx','0',2,'2022-06-05',3,'Ҳал карда шавад'),
(2,'Супориши 1','CSS кор бо матн.docx','0',4,'2022-06-02',3,'То муддати додашуда  ҳал кунед'),
(3,'Супориши 4','mundarija_prog.docx','5. намунаи ариза.docx',1,'2022-06-04',3,'Аз ҳамин файл истифода бурда презентация созед.'),
(4,'Супориши 7','source.docx','0',1,'2022-06-07',3,'Ҳал карда шавад'),
(5,'Супориши 5','SDD_task_Interns.pdf','0',1,'2022-06-03',3,'Ба намуди файли Word карда диҳед'),
(6,'Супориши 2','Visual Studio 2013 key.txt','0',2,'2022-06-17',3,'Масъаларо бодиққат хонед ва ҳал то муддаташ ҳал кунед.'),
(7,'Супориши 8','Қисми 51.docx','0',2,'2022-06-05',3,'Ҳал кунед'),
(8,'Супориши 6','Қисми 1.docx','0',4,'2022-06-12',3,'Масъала ҳал карда шавад.');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` int(1) NOT NULL,
  `email` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`login`,`user_status`,`email`,`pass`) values 
(1,'Азамов Сиёвуш','st22433',0,'azamov@gmail.com','azamov2001'),
(2,'Абдуназаров Сардор','st25560',0,'sardor@gmail.com','sardor2001'),
(3,'Мунирчон','admin',1,'admin@gmail.com','qwerty123'),
(4,'Латипов Мухаммадчон','st23455',0,'odam@gmail.com','latipov2001'),
(5,'Исобоев Манучехр','sila1234',0,'damdam@gmail.com','123456789'),
(6,'Dor Dadoev','dor123456',0,'dor@gmail.com','werty12345'),
(7,'Abdunazarov Sardor','job1234',0,'job@gmail.com','12345678910'),
(8,'Юсупов Илҳомҷон','st57633',0,'ilhomjon@gmail.com','oper2022'),
(9,'Фозилов Амирҷон','st34900',0,'amirak@mail.ru','amirak2001'),
(10,'Воситов Бахтиёр','st46389',0,'bakha@gmail.com','bakhatj');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
