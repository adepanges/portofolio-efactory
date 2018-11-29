/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.10-MariaDB : Database - project_nutrifood_app
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `master_hakakses` */

DROP TABLE IF EXISTS `master_hakakses`;

CREATE TABLE `master_hakakses` (
  `id_hakakses` int(11) NOT NULL AUTO_INCREMENT,
  `id_modul` int(11) NOT NULL DEFAULT '0',
  `nama_hakakses` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_hakakses`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_hakakses` */

insert  into `master_hakakses`(`id_hakakses`,`id_modul`,`nama_hakakses`) values (1,1,'Admininistrator'),(2,1,'Supervisor'),(3,1,'Operator');

/*Table structure for table `master_mesin` */

DROP TABLE IF EXISTS `master_mesin`;

CREATE TABLE `master_mesin` (
  `id_mesin` int(11) NOT NULL AUTO_INCREMENT,
  `kode_mesin` varchar(500) NOT NULL,
  `nama_mesin` varchar(500) DEFAULT NULL,
  `status_mesin` int(11) DEFAULT NULL,
  `keterangan_mesin` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_mesin`),
  UNIQUE KEY `UNIQUE KODE MESIN` (`kode_mesin`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `master_mesin` */

insert  into `master_mesin`(`id_mesin`,`kode_mesin`,`nama_mesin`,`status_mesin`,`keterangan_mesin`) values (1,'Multilane C-1','Multilane C-1',1,''),(2,'Multilane C-2','Multilane C-2',1,''),(3,'Multilane C-3','Multilane C-3',1,''),(4,'Multilane C-4','Multilane C-4',1,''),(5,'Multilane C-5','Multilane C-5',1,''),(6,'Multilane C-6','Multilane C-6',1,''),(7,'Multilane C-7','Multilane C-7',1,''),(8,'Multilane C-8','Multilane C-8',1,''),(9,'Multilane C-9','Multilane C-9',1,''),(10,'Multilane C-10','Multilane C-10',1,''),(11,'Multilane 10.1','Multilane 10.1',1,''),(12,'Multilane 10.2','Multilane 10.2',1,''),(13,'OMAG','OMAG',1,'');

/*Table structure for table `master_problem` */

DROP TABLE IF EXISTS `master_problem`;

CREATE TABLE `master_problem` (
  `id_problem` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) DEFAULT '1',
  `kode_downtime` varchar(10) DEFAULT NULL,
  `nama_problem` varchar(500) DEFAULT NULL,
  `keterangan_problem` varchar(500) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_problem`),
  UNIQUE KEY `UNIQ` (`kode_downtime`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `master_problem` */

insert  into `master_problem`(`id_problem`,`status`,`kode_downtime`,`nama_problem`,`keterangan_problem`,`type`) values (1,1,'SHIFT','SHIFT','SHIFT',1),(2,1,'B','Lubang pipa bocor','Lubang pipa bocor',2),(3,1,'C','Air Habis','Air Habis',2),(4,1,'D','Tidak ada suplai listrik','Tidak ada suplai listrik',2),(5,1,'E','Kurang Gula','Kurang Gula',2),(6,1,'F','Takaran tidak sesuai','Takaran tidak sesuai',2),(7,1,'G','Membersihkan Mesin','Bersih bersih masin pak de',1),(8,1,'H','Mengatur Mesin',NULL,1),(9,1,'I','Memindahkan mesin',NULL,1);

/*Table structure for table `master_product` */

DROP TABLE IF EXISTS `master_product`;

CREATE TABLE `master_product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `master_product` */

insert  into `master_product`(`id_product`,`product_name`,`duration`,`active`) values (1,'NS American Sweet Orange',145,1),(2,'NS Florida Orange',145,1),(3,'NS Jeruk Peras',137,1),(5,'NS Strawberry',176,1),(6,'NS Extra Manis',177,1),(7,'NS Anggur',181,1),(8,'NS Sweet Manggo',179,1),(9,'Sweetner Classic',246,1),(10,'Sweetener Stevia',231,1);

/*Table structure for table `master_user` */

DROP TABLE IF EXISTS `master_user`;

CREATE TABLE `master_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `UNIQUE USERNAME` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `master_user` */

insert  into `master_user`(`id_user`,`username`,`password`,`nama`,`status`) values (1,'admin','0cc175b9c0f1b6a831c399e269772661','Admin',1),(2,'spv','0cc175b9c0f1b6a831c399e269772661','Yanuar Pangestu',1),(3,'opt','0cc175b9c0f1b6a831c399e269772661 ','Agus Haryono',1),(4,'opt2','0cc175b9c0f1b6a831c399e269772661 ','Budi',1),(5,'opt3','0cc175b9c0f1b6a831c399e269772661 ','Sugeng',1),(6,'opt4','0cc175b9c0f1b6a831c399e269772661 ','Riuyadi',1),(7,'opt5','0cc175b9c0f1b6a831c399e269772661','Agus Salim',1);

/*Table structure for table `trans_detailkegiatan` */

DROP TABLE IF EXISTS `trans_detailkegiatan`;

CREATE TABLE `trans_detailkegiatan` (
  `id_detailkegiatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_keg` int(11) NOT NULL,
  `id_problem` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_confirm` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `downtime_duration` bigint(20) DEFAULT NULL,
  `keterangan_detailkeg` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_detailkegiatan`),
  KEY `id_keg_1` (`id_keg`),
  KEY `id_problem_1` (`id_problem`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `trans_detailkegiatan` */

insert  into `trans_detailkegiatan`(`id_detailkegiatan`,`id_keg`,`id_problem`,`status`,`waktu_mulai`,`waktu_confirm`,`waktu_selesai`,`downtime_duration`,`keterangan_detailkeg`) values (1,1,7,3,'2016-07-07 21:57:20','2016-07-07 21:57:20','2016-07-07 21:58:23',63,''),(2,1,1,3,'2016-07-07 22:00:21','2016-07-07 22:00:21','2016-07-07 22:41:43',2482,''),(3,2,7,3,'2016-08-06 20:27:09','2016-08-06 20:27:09','2016-08-06 20:27:47',38,'bersih bersih'),(4,2,4,3,'2016-08-06 20:28:30','2016-08-06 20:28:54','2016-08-06 20:29:12',42,'bahaya bos');

/*Table structure for table `trans_kegiatan` */

DROP TABLE IF EXISTS `trans_kegiatan`;

CREATE TABLE `trans_kegiatan` (
  `id_keg` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_mesin` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `kode_session` varchar(100) DEFAULT NULL,
  `kode_batch` varchar(50) DEFAULT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `duration_life` int(11) DEFAULT '0',
  `prosentase` float DEFAULT '0',
  `keterangan_keg` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_keg`),
  KEY `id_user_1` (`id_user`),
  KEY `id_mesin1_1` (`id_mesin`),
  KEY `id_product_1` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `trans_kegiatan` */

insert  into `trans_kegiatan`(`id_keg`,`id_user`,`id_mesin`,`id_product`,`active`,`kode_session`,`kode_batch`,`waktu_mulai`,`waktu_selesai`,`duration_life`,`prosentase`,`keterangan_keg`) values (1,3,1,1,0,'MTQ2NzkwMzM3NC4x','AA123','2016-07-07 21:58:32','2016-07-07 22:41:58',124,0,NULL),(2,3,1,9,0,'MTQ3MDQ4OTk4Ny4x','AA112','2016-08-06 20:28:00','2016-08-06 20:29:19',37,0,NULL);

/*Table structure for table `trans_userhakakses` */

DROP TABLE IF EXISTS `trans_userhakakses`;

CREATE TABLE `trans_userhakakses` (
  `id_userhakakses` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_modul` int(11) DEFAULT '0',
  `id_hakakses` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_userhakakses`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `trans_userhakakses` */

insert  into `trans_userhakakses`(`id_userhakakses`,`id_user`,`id_modul`,`id_hakakses`) values (1,3,1,3),(2,2,1,2),(3,1,1,1),(4,4,1,3),(5,5,1,3),(6,6,1,3),(7,7,1,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
