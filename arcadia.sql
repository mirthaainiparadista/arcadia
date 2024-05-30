/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.4.32-MariaDB : Database - arcadia
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`arcadia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `arcadia`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(100) NOT NULL,
  `user_admin` varchar(20) NOT NULL,
  `pass_admin` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `admin` */

insert  into `admin`(`id_admin`,`nama_admin`,`user_admin`,`pass_admin`) values 
(1,'Admin Arcadia','admin','admin');

/*Table structure for table `buku` */

DROP TABLE IF EXISTS `buku`;

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(255) NOT NULL,
  `tgl_terbit` date NOT NULL,
  `nama_pengarang` varchar(100) NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `buku` */

insert  into `buku`(`id_buku`,`judul_buku`,`tgl_terbit`,`nama_pengarang`,`nama_penerbit`) values 
(1,'The Ultimate Management Book','2018-04-19','Martin Manser','John Murray Press'),
(2,'100 Things Successful People Do','2016-10-25','Mobius','Nigel Cumberland'),
(3,'Dincolo de ordine','0000-00-00',':Jordan B. Peterson','Editura Trei SRL'),
(4,'The 48 Laws Of Power','2010-09-03','Robert Greene','Profile Books'),
(5,'The Concise Mastery','2014-06-02','Robert Greene','Profile Books'),
(6,'The Concise Seduction','2023-05-25','Robert Greene','Profile'),
(7,'The 33 Strategies Of War','2010-09-03','Robert Greene','Profile Books'),
(8,'Pandosto','2012-05-21','Robert Greene','John Grismond'),
(9,'The Winter\'s Tale','2006-02-09','William Shakespeare','Huge Print Press'),
(10,'The Two Gentlemen of Verona','2013-12-19','William Shakespeare','National Library of the Netherlands');

/*Table structure for table `detil_peminjaman` */

DROP TABLE IF EXISTS `detil_peminjaman`;

CREATE TABLE `detil_peminjaman` (
  `kode_pinjam` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  PRIMARY KEY (`kode_pinjam`,`id_buku`),
  KEY `id_buku` (`id_buku`),
  CONSTRAINT `detil_peminjaman_ibfk_1` FOREIGN KEY (`kode_pinjam`) REFERENCES `peminjaman` (`kode_pinjam`),
  CONSTRAINT `detil_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detil_peminjaman` */

/*Table structure for table `peminjam` */

DROP TABLE IF EXISTS `peminjam`;

CREATE TABLE `peminjam` (
  `id_peminjam` int(11) NOT NULL AUTO_INCREMENT,
  `nama_peminjam` varchar(100) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `user_peminjam` varchar(20) NOT NULL,
  `pass_peminjam` varchar(255) NOT NULL,
  `foto_peminjam` varchar(100) NOT NULL,
  `status_peminjam` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_peminjam`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `peminjam` */

insert  into `peminjam`(`id_peminjam`,`nama_peminjam`,`tgl_daftar`,`user_peminjam`,`pass_peminjam`,`foto_peminjam`,`status_peminjam`) values 
(9,'paradista','2024-05-30','paradista','$2y$10$8VQJ.DftMx3jS/nDt1.EYeKwwRhLUU1dhAJA.skmjRyHatadRoydW','paradista.jpg',0);

/*Table structure for table `peminjaman` */

DROP TABLE IF EXISTS `peminjaman`;

CREATE TABLE `peminjaman` (
  `kode_pinjam` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` int(11) NOT NULL,
  `id_peminjam` int(11) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `tgl_ambil` date NOT NULL,
  `tgl_wajibkembali` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status_pinjam` char(1) NOT NULL,
  PRIMARY KEY (`kode_pinjam`),
  KEY `fk_admin` (`id_admin`),
  KEY `fk_peminjam` (`id_peminjam`),
  CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  CONSTRAINT `fk_peminjam` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjam` (`id_peminjam`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `peminjaman` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
