-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: ptkd_qerp
-- ------------------------------------------------------
-- Server version	5.7.17-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `lk_accesscontrol`
--

DROP TABLE IF EXISTS `lk_accesscontrol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lk_accesscontrol` (
  `accessID` varchar(10) NOT NULL COMMENT 'Access ID',
  `description` varchar(50) NOT NULL COMMENT 'Description',
  `node` varchar(50) DEFAULT NULL COMMENT 'Controller',
  `icon` varchar(50) DEFAULT NULL COMMENT 'Icon',
  PRIMARY KEY (`accessID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lk_accesscontrol`
--

LOCK TABLES `lk_accesscontrol` WRITE;
/*!40000 ALTER TABLE `lk_accesscontrol` DISABLE KEYS */;
INSERT INTO `lk_accesscontrol` VALUES ('A','Accounting','Accounting','fa-money'),('A.3','Journal','/journal','fa-money'),('A.4','GL to GL','/gltogl','fa-money'),('A.5','Cash / Bank Transfer','/cash-bank-transfer','fa-money'),('A.6','Supplier Payable','/supplier-payable','fa-money'),('A.7','Customer Receivable','/customer-receivable','fa-money'),('A.8','Cash / Bank - In / Out','/cashinout','fa-money'),('B','Inventory','Inventory','fa-archive'),('B.1','Goods Receipt','/goods-receipt','fa-cart-arrow-down'),('B.10','Stock Transfer','/stock-transfer','fa-exchange'),('B.11','Internal Usage','/internal-usage','fa-exchange'),('B.12','Internal Usage Approval','/internal-usage-approval','fa-exchange'),('B.2','Import Duty','/import-duty','fa-shopping-cart '),('B.3','Goods Receipt Approval','/goods-receipt-approval','fa-cart-arrow-down'),('B.4','Goods Receipt History','/goods-receipt-history','fa-cart-arrow-down'),('B.5','Goods Delivery','/goods-delivery','fa-shopping-cart '),('B.6','Goods Delivery History','/goods-delivery-history','fa-shopping-cart '),('B.7','Stock Card','/stock-card','fa-archive'),('B.8','Stock Inquiry','/stock-hpp','fa-archive'),('B.9','Stock Adjustment','/stock-adjustment','fa-archive'),('C','Purchase','Purchase','fa-cart-arrow-down'),('C.1','Purchase Order Inventory','/purchase','fa-cart-arrow-down'),('C.2','Purchase Order Non Inventory','/purchase-order-non-inventory','fa-cart-arrow-down'),('C.3','Purchase Return','/purchase-return','fa-cart-arrow-down'),('C.4','Supplier Advance Payment','/supplier-advance-payment','fa-cart-arrow-down'),('C.5','Supplier Payment','/supplier-payment','fa-cart-arrow-down'),('C.6','Forwarder Payment','/forwarder-payment','fa-cart-arrow-down'),('D','Sales','Sales','fa-shopping-cart '),('D.1','Sales Quotation','/sales-quotation','fa-shopping-cart '),('D.2','Sales Order','/sales-order','fa-shopping-cart '),('D.3','Sales Return','/sales-return','fa-shopping-cart '),('D.4','Customer Advance Payment','/customer-advance-payment','fa-shopping-cart '),('D.5','Customer Payment','/customer-payment','fa-shopping-cart '),('E','Sampling','Sampling','fa-archive'),('E.1','Supplier Sample Receipt','/sample-receipt','fa-cart-arrow-down'),('E.2','Customer Sample Delivery','/sample-delivery','fa-shopping-cart '),('E.3','Sample Status','/sample-delivery-status','fa-archive'),('E.4','Sample Stock Card','/sample-stock-card','fa-archive'),('F','Master Data','Master','fa-database '),('F.1','Currency','/currency','fa-usd '),('F.10','Product Subcategory','/subcategory','fa-sitemap '),('F.11','Reason','/reason','fa-file-text'),('F.12','Report Destination','/report-destination','fa-file-text'),('F.13','Supplier','/supplier','fa-users'),('F.14','Tax','/tax','fa-money'),('F.15','Warehouse','/warehouse','fa-home '),('F.16','UOM','/uom','fa-balance-scale'),('F.17','User Access','/user-access','fa-unlock'),('F.18','User','/user','fa-user '),('F.19','Payment Due','/payment-due','fa-money '),('F.2','Customer','/customer','fa-users'),('F.3','Chart Of Account','/coa','fa-book'),('F.4','Document Type','/documenttype','fa-file-text '),('F.5','HS Code','/hscode','fa-file-text'),('F.6','Marketing','/marketing','fa-phone '),('F.7','Packing Type','/packingtype','fa-shopping-bag'),('F.8','Product','/product','fa fa-archive'),('F.9','Product Category','/category','fa-sitemap '),('G','Reporting','Reporting','fa-print '),('G.1','Sampling Report','/sampling-report','fa-print '),('G.2','Tri Wulan Report','/triwulan-report','fa-print '),('G.3','Inventory Report','/inventory-report','fa-print '),('G.4','Accounting Report','/accounting-report','fa-print'),('G.5','Pending Shipment Report','/pending-shipment-report','fa-print'),('H','Lainnya','Lainnya','fa-file-text '),('H.1','Document Control','/document-control','fa-file-text '),('H.2','Settings','/settings','fa-cogs');
/*!40000 ALTER TABLE `lk_accesscontrol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lk_documenttype`
--

DROP TABLE IF EXISTS `lk_documenttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lk_documenttype` (
  `lkDocumentTypeID` smallint(6) NOT NULL AUTO_INCREMENT,
  `lkDocumentTypeName` varchar(45) NOT NULL,
  `ordinal` tinyint(4) NOT NULL,
  PRIMARY KEY (`lkDocumentTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lk_documenttype`
--

LOCK TABLES `lk_documenttype` WRITE;
/*!40000 ALTER TABLE `lk_documenttype` DISABLE KEYS */;
INSERT INTO `lk_documenttype` VALUES (1,'Pembelian',1),(2,'Penjualan',2),(3,'Lainnya',3);
/*!40000 ALTER TABLE `lk_documenttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lk_filteraccess`
--

DROP TABLE IF EXISTS `lk_filteraccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lk_filteraccess` (
  `accessID` varchar(10) NOT NULL COMMENT 'Access ID',
  `insertAcc` bit(1) NOT NULL COMMENT 'Insert Access',
  `updateAcc` bit(1) NOT NULL COMMENT 'Update Access',
  `deleteAcc` bit(1) NOT NULL COMMENT 'Delete Access',
  `viewAcc` bit(1) NOT NULL COMMENT 'View Access',
  PRIMARY KEY (`accessID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lk_filteraccess`
--

LOCK TABLES `lk_filteraccess` WRITE;
/*!40000 ALTER TABLE `lk_filteraccess` DISABLE KEYS */;
INSERT INTO `lk_filteraccess` VALUES ('A.3','','','',''),('A.4','','','',''),('A.5','','','',''),('A.6','','','',''),('A.7','','','',''),('A.8','','','',''),('B.1','','','',''),('B.10','','','',''),('B.11','','','',''),('B.12','','','',''),('B.2','','','',''),('B.3','','','',''),('B.4','','','',''),('B.5','','','',''),('B.6','','','',''),('B.7','','','',''),('B.8','','','',''),('B.9','','','',''),('C.1','','','',''),('C.2','','','',''),('C.3','','','',''),('C.4','','','',''),('C.5','','','',''),('C.6','','','',''),('D.1','','','',''),('D.2','','','',''),('D.3','','','',''),('D.4','','','',''),('D.5','','','',''),('E.1','','','',''),('E.2','','','',''),('E.3','','','',''),('E.4','','','',''),('F.1','','','',''),('F.10','','','',''),('F.11','','','',''),('F.12','','','',''),('F.13','','','',''),('F.14','','','',''),('F.15','','','',''),('F.16','','','',''),('F.17','','','',''),('F.18','','','',''),('F.19','','','',''),('F.2','','','',''),('F.3','','','',''),('F.4','','','',''),('F.5','','','',''),('F.6','','','',''),('F.7','','','',''),('F.8','','','',''),('F.9','','','',''),('G.1','','','',''),('G.2','','','',''),('G.3','','','',''),('G.4','','','',''),('G.5','','','',''),('H.1','','','',''),('H.2','','','','');
/*!40000 ALTER TABLE `lk_filteraccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lk_paymentmethod`
--

DROP TABLE IF EXISTS `lk_paymentmethod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lk_paymentmethod` (
  `paymentID` smallint(6) NOT NULL COMMENT 'Payment ID',
  `paymentName` varchar(20) NOT NULL COMMENT 'Payment Name',
  PRIMARY KEY (`paymentID`),
  UNIQUE KEY `paymentID` (`paymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lk_paymentmethod`
--

LOCK TABLES `lk_paymentmethod` WRITE;
/*!40000 ALTER TABLE `lk_paymentmethod` DISABLE KEYS */;
INSERT INTO `lk_paymentmethod` VALUES (1,'Cash'),(2,'Transfer'),(3,'Giro / Cheque');
/*!40000 ALTER TABLE `lk_paymentmethod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lk_status`
--

DROP TABLE IF EXISTS `lk_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lk_status` (
  `statusID` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(50) NOT NULL,
  PRIMARY KEY (`statusID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lk_status`
--

LOCK TABLES `lk_status` WRITE;
/*!40000 ALTER TABLE `lk_status` DISABLE KEYS */;
INSERT INTO `lk_status` VALUES (1,'In Delivery'),(2,'Delivered'),(3,'Approved'),(4,'Rejected'),(5,'Pending');
/*!40000 ALTER TABLE `lk_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lk_statusshipment`
--

DROP TABLE IF EXISTS `lk_statusshipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lk_statusshipment` (
  `statusShipmentID` smallint(6) NOT NULL COMMENT 'Status Shipment ID',
  `statusShipmentName` varchar(20) NOT NULL COMMENT 'Status Shipment Name',
  PRIMARY KEY (`statusShipmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lk_statusshipment`
--

LOCK TABLES `lk_statusshipment` WRITE;
/*!40000 ALTER TABLE `lk_statusshipment` DISABLE KEYS */;
/*!40000 ALTER TABLE `lk_statusshipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_poinvoice`
--

DROP TABLE IF EXISTS `map_poinvoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map_poinvoice` (
  `purchaseOrderID` varchar(50) NOT NULL COMMENT 'Purchase Order ID',
  `supplierInvoiceID` varchar(50) NOT NULL COMMENT 'Supplier Invoice ID'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map_poinvoice`
--

LOCK TABLES `map_poinvoice` WRITE;
/*!40000 ALTER TABLE `map_poinvoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `map_poinvoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_coa`
--

DROP TABLE IF EXISTS `ms_coa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_coa` (
  `coaNo` varchar(20) NOT NULL COMMENT 'COA No',
  `coaLevel` int(11) NOT NULL COMMENT 'COA Level',
  `description` varchar(100) NOT NULL COMMENT 'Description',
  `currencyID` varchar(5) NOT NULL COMMENT 'Currency ID',
  `ordinal` smallint(6) NOT NULL COMMENT 'Ordinal',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`coaNo`),
  KEY `fk_mscoa_currency_idx` (`currencyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_coa`
--

LOCK TABLES `ms_coa` WRITE;
/*!40000 ALTER TABLE `ms_coa` DISABLE KEYS */;
INSERT INTO `ms_coa` VALUES ('1',0,'Aktiva','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('11',1,'Aktiva','IDR',1,'','admin','2016-11-02 09:46:19','admin','2016-11-02 09:46:19'),('111',2,'Aktiva Lancar','IDR',1,'','admin','2016-11-02 09:48:14','admin','2016-11-02 09:48:14'),('1110',3,'Kas','IDR',1,'','admin','2016-11-02 09:50:22','admin','2016-11-02 09:50:22'),('1110.0001',4,'Kas IDR\r\n','IDR',1,'','admin','2016-11-07 13:20:13','admin','2016-11-07 13:20:13'),('1110.0002',4,'Kas USD\r\n','USD',2,'','admin','2016-11-07 13:29:02','admin','2016-11-07 13:29:02'),('1110.0003',4,'Kas EURO','EURO',3,'','admin','2016-11-10 16:12:26','admin','2016-11-14 10:19:09'),('1110.0004',4,'Kas SGD','SGD',4,'\0','admin','2016-11-14 10:19:52','admin','2016-11-14 10:19:52'),('1111',3,'Bank','IDR',2,'','admin','2016-11-10 00:00:00','admin','2016-11-10 00:00:00'),('1111.0001',4,'Bank BCA IDR','IDR',1,'','admin','2016-11-11 16:16:25','admin','2017-12-21 13:41:52'),('1111.0002',4,'Bank BCA USD','USD',2,'','admin','2016-11-15 10:17:53','admin','2017-12-21 13:41:26'),('1111.0003',4,'Bank BCA EUR','EURO',3,'','admin','2016-11-15 10:19:36','admin','2016-11-15 10:19:36'),('1112',3,'Temporary Investment','IDR',3,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1112.0001',4,'Deposito','IDR',1,'','admin','2016-11-15 10:21:54','admin','2016-11-15 10:21:54'),('1112.0002',4,'Surat-Surat Berharga','IDR',2,'','admin','2016-11-15 10:22:46','admin','2016-11-15 10:22:46'),('1113',3,'Piutang Giro Mundur','IDR',4,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1113.0001',4,'Piutang Giro Mundur','IDR',1,'','admin','2016-11-15 10:25:17','admin','2016-11-15 10:25:17'),('1114',3,'Piutang Dagang','IDR',5,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1114.0001',4,'Piutang Dagang Customer','IDR',1,'','admin','2016-11-15 10:26:27','admin','2017-12-21 13:42:59'),('1115',3,'Lain-Lain','IDR',6,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1115.0001',4,'Lainnya','IDR',1,'\0','admin','2016-11-17 15:00:36','admin','2016-11-17 15:00:36'),('1115.0002',4,'Piutang Giro Mundur 1','IDR',2,'','admin','2017-03-30 13:34:57','admin','2017-03-30 13:34:57'),('1118',3,'Piutang Lain2','IDR',7,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1118.0001',4,'Pinjaman Direksi','IDR',1,'','admin','2016-11-15 10:27:15','admin','2016-11-15 10:27:15'),('1118.0002',4,'Piutang Karyawan (per karyawan)','IDR',2,'','admin','2016-11-15 10:27:39','admin','2016-11-15 10:27:39'),('1118.0003',4,'Piutang Lain-Lain','IDR',3,'','admin','2016-11-15 10:28:00','admin','2016-11-15 10:28:00'),('1118.0004',4,'Piutang Pemegang Saham','IDR',4,'','admin','2016-11-15 10:28:24','admin','2016-11-15 10:28:24'),('1119',3,'Persediaan','IDR',8,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1119.0001',4,'Persediaan Bahan Baku Obat','IDR',1,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1119.0002',4,'Persediaan Bahan Baku Food','IDR',2,'','admin','2017-12-21 00:00:00','admin','2017-12-21 00:00:00'),('1119.0003',4,'Persediaan Bahan Baku Kosmetik','IDR',3,'','admin','2016-11-15 10:31:33','admin','2017-12-21 13:52:38'),('1119.0004',4,'Persediaan Produk','IDR',4,'','admin','2016-11-15 10:39:50','admin','2016-11-15 10:39:50'),('1119.0005',4,'Persediaan Barang Sample','IDR',5,'','admin','2017-10-12 17:13:11','admin','2017-10-12 17:13:11'),('1120',3,'Uang Muka','IDR',9,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1120.0001',4,'Uang Muka Lain-Lain','IDR',1,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1120.0002',4,'Uang Muka Supplier','IDR',2,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1120.0003',4,'Uang Muka Customer','IDR',3,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1121',3,'Biaya Dibayar Dimuka','IDR',10,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1121.0001',4,'Asuransi Dibayar Dimuka','IDR',1,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1121.0002',4,'Sewa Dibayar Dimuka','IDR',2,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1121.0003',4,'Uang Muka Kendaraan','IDR',3,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1121.0004',4,'Bunga Dibayar Dimuka','IDR',4,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122',3,'Pajak Dibayar Dimuka','IDR',11,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1122.0001',4,'Uang Muka Sementara','IDR',1,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122.0002',4,'Piutang PPN','IDR',2,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122.0003',4,'PPh Ps 21','IDR',3,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122.0004',4,'PPh Ps 22 (PPh 22 Impor)','IDR',4,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122.0005',4,'PPh Ps 23','IDR',5,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122.0006',4,'PPh Ps 25','IDR',6,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122.0007',4,'Uang Muka Pajak','IDR',7,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1122.0008',4,'PPh Pasal 4 Ayat 2','IDR',8,'','admin','2016-11-15 10:31:15','admin','2016-11-15 10:31:15'),('1199',3,'Pos Sementara','IDR',12,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1199.0001',4,'Pos Sementara','IDR',1,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('12',1,'Pengurangan Aktiva Lancar\r\n','IDR',2,'','admin','2016-11-02 09:47:40','admin','2016-11-02 09:47:40'),('13',1,'Investasi Jangka Panjang\r\n','USD',3,'','admin','2016-11-10 00:00:00','admin','2016-11-10 00:00:00'),('131',2,'Investasi Jangka Panjang\r\n','IDR',2,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1310',3,'Investasi Jangka Panjang','IDR',13,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1310.0001',4,'Investasi Pada Anak Perusahaan','IDR',1,'','admin','2016-11-15 13:46:41','admin','2016-11-15 13:46:41'),('1310.0002',4,'Obligasi PT A','IDR',2,'','admin','2016-11-15 13:46:52','admin','2016-11-15 13:46:52'),('1310.0003',4,'Investasi Pada Sektor Properti','IDR',3,'','admin','2016-11-15 13:47:03','admin','2016-11-15 13:47:03'),('14',1,'Aktiva Tetap','IDR',4,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('141',2,'Aktiva Tetap','IDR',3,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1410',3,'Aktiva Tetap','IDR',14,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1410.0001',4,'Tanah','IDR',1,'','admin','2016-11-15 11:12:03','admin','2016-11-15 11:12:03'),('1410.0002',4,'Bangunan','IDR',2,'','admin','2016-11-15 11:12:25','admin','2016-11-15 11:12:25'),('1410.0003',4,'Mesin','IDR',3,'','admin','2016-11-15 11:13:01','admin','2016-11-15 11:13:01'),('1410.0004',4,'Peralatan Kantor','IDR',4,'','admin','2016-11-15 11:13:46','admin','2016-11-15 11:13:46'),('1410.0005',4,'Peralatan Laboratorium','IDR',5,'','admin','2016-11-15 11:14:00','admin','2017-12-21 13:55:15'),('1410.0006',4,'Inventaris Kantor','IDR',6,'','admin','2016-11-15 11:14:30','admin','2016-11-15 11:14:30'),('1410.0007',4,'Kendaraan','IDR',7,'','admin','2016-11-15 11:14:58','admin','2016-11-15 11:14:58'),('1410.0008',4,'Furniture Kantor','IDR',8,'','admin','2016-11-15 11:15:29','admin','2016-11-15 11:15:29'),('1410.0009',4,'Leasing','IDR',9,'','admin','2016-11-15 11:15:48','admin','2017-12-21 14:01:20'),('15',1,'Pengurangan Aktiva Tetap','IDR',5,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('151',2,'Pengurangan Aktiva Tetap','IDR',4,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1510',3,'Akumulasi Penyusutan Aktiva Tetap','IDR',15,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1510.0001',4,'Akm. Peny. Tanah','IDR',1,'','admin','2016-11-15 11:16:13','admin','2017-12-21 14:03:13'),('1510.0002',4,'Akm. Peny. Bangunan Kantor','IDR',2,'','admin','2016-11-15 11:16:56','admin','2017-12-21 14:03:47'),('1510.0003',4,'Akm. Peny. Mesin','IDR',3,'','admin','2016-11-15 11:17:12','admin','2017-12-21 14:04:23'),('1510.0004',4,'Akm. Peny. Peralatan  Kantor','IDR',4,'','admin','2016-11-15 11:17:44','admin','2017-12-21 14:04:54'),('1510.0005',4,'Akm. Peny. Peralatan  Laboratorium','IDR',5,'','admin','2016-11-15 11:18:06','admin','2017-12-21 14:06:10'),('1510.0006',4,'Akm. Peny. Inventaris Kantor','IDR',6,'','admin','2016-11-15 11:18:34','admin','2017-12-21 14:06:44'),('1510.0007',4,'Akm. Peny. Kendaraan','IDR',7,'','admin','2016-11-15 11:19:51','admin','2017-12-21 14:07:20'),('1510.0008',4,'Akm. Peny. Furniture Kantor','IDR',8,'','admin','2016-11-15 11:20:07','admin','2017-12-21 14:08:05'),('1510.0009',4,'Akm. Peny. Leasing','IDR',9,'','admin','2016-11-15 11:20:23','admin','2017-12-21 14:08:43'),('16',1,'Hak Paten','IDR',6,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('161',2,'Hak Paten','IDR',5,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1610',3,'Aktiva Tak Berwujud','IDR',16,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1610.0001',4,'Hak Paten','IDR',1,'','admin','2016-11-15 11:24:44','admin','2016-11-15 11:24:44'),('1610.0002',4,'Goodwill','IDR',2,'','admin','2016-11-15 11:24:59','admin','2016-11-15 11:24:59'),('1610.0003',4,'Franchise','IDR',3,'','admin','2016-11-15 11:25:18','admin','2016-11-15 11:25:18'),('1610.0004',4,'Perijinan','IDR',4,'','admin','2016-11-15 11:26:33','admin','2016-11-15 11:26:33'),('17',1,'Amortisasi Hak Paten','IDR',7,'','admin','2017-12-21 00:00:00','admin','2017-12-21 00:00:00'),('171',2,'Amortisasi Hak Paten','IDR',6,'','admin','2017-12-21 00:00:00','admin','2017-12-21 00:00:00'),('1710',3,'Amortisasi Aktiva Tak Berwujud','IDR',17,'','admin','2017-12-21 00:00:00','admin','2017-12-21 00:00:00'),('1710.0002',4,'By. Amortisasi Hak Paten','IDR',2,'','admin','2017-12-21 15:20:29','admin','2017-12-21 15:20:29'),('18',1,'Aktiva Lain2','IDR',7,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('181',2,'Aktiva Lain2','IDR',6,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1810',3,'Aktiva Lain2','IDR',17,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('1810.0001',4,'Bangunan Dalam Pelaksanaan','IDR',1,'','admin','2016-11-15 11:27:03','admin','2016-11-15 11:27:03'),('1810.0002',4,'Mesin Dalam Pemasangan','IDR',2,'','admin','2016-11-15 11:27:41','admin','2016-11-15 11:27:55'),('1810.0003',4,'Biaya Pra Operasi','IDR',3,'','admin','2016-11-15 11:28:31','admin','2016-11-15 11:28:31'),('1810.0004',4,'Biaya2 lain yang ditangguhkan','IDR',4,'','admin','2016-11-15 11:28:49','admin','2016-11-15 11:28:49'),('2',0,'Hutang','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('21',1,'Hutang Jangka Pendek','IDR',8,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('211',2,'Hutang Jangka Pendek','IDR',7,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2110',3,'Hutang Giro Mundur','IDR',18,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2110.0001',4,'Hutang Giro Mundur A','IDR',1,'','admin','2016-11-15 11:29:18','admin','2016-11-15 11:29:18'),('2110.0002',4,'Hutang Giro Mundur B','IDR',2,'','admin','2016-11-15 11:30:04','admin','2016-11-15 11:30:04'),('2111',3,'Hutang Dagang / Usaha','IDR',19,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2111.0001',4,'Hutang Dagang Supplier','IDR',1,'','admin','2016-11-15 11:30:20','admin','2016-11-15 11:30:20'),('2111.0002',4,'Hutang  kpd PPJK','IDR',2,'','admin','2016-11-15 11:30:41','admin','2017-12-21 14:19:07'),('2114',3,'Biaya Yang Masih Harus Dibayar','IDR',20,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2114.0001',4,'Hutang biaya ','IDR',1,'','admin','2016-11-15 11:31:15','admin','2016-11-15 14:38:08'),('2115',3,'Hutang Pajak','IDR',21,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2115.0001',4,'Hutang PPh Ps. 29 Badan','IDR',1,'','admin','2016-11-15 11:31:49','admin','2017-12-21 14:22:07'),('2115.0002',4,'Hutang PPN','IDR',2,'','admin','2016-11-15 11:32:08','admin','2016-11-15 11:32:08'),('2115.0003',4,'Hutang PPh Ps 21','IDR',3,'','admin','2016-11-15 11:32:41','admin','2016-11-15 11:32:41'),('2115.0004',4,'Hutang PPh Ps 22 (Impor)','IDR',4,'','admin','2016-11-15 11:33:08','admin','2017-12-21 14:25:45'),('2115.0005',4,'Hutang PPh Ps 23','IDR',5,'','admin','2016-11-15 11:33:26','admin','2017-12-21 14:20:57'),('2115.0006',4,'Hutang PPh Ps 25','IDR',6,'','admin','2016-11-15 11:34:21','admin','2017-12-21 14:21:28'),('2115.0007',4,'Hutang PPh Ps 23 atas Komisi','IDR',7,'','admin','2016-11-15 11:34:54','admin','2017-12-21 14:23:01'),('2115.0008',4,'Hutang Pajak PPh 23 atas sewa','IDR',8,'','admin','2016-11-15 11:35:27','admin','2016-11-15 11:35:27'),('2115.0009',4,'Hutang Bea Masuk (Impor)','IDR',9,'','admin','2016-11-15 11:37:22','admin','2017-12-21 14:25:10'),('2115.0010',4,'Hutang PPN Impor','IDR',10,'','admin','2016-11-15 11:37:40','admin','2016-11-15 11:37:40'),('2115.0011',4,'Hutang PPh Ps 24 (Bendaharawan)','IDR',11,'','admin','2016-11-15 11:38:33','admin','2017-12-21 14:26:18'),('2115.0012',4,'Hutang PPh Ps 4 ayat 2','IDR',12,'','admin','2016-11-15 11:39:12','admin','2016-11-15 11:39:12'),('2116',3,'Hutang Bank','IDR',22,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2116.0001',4,'Hutang Bank BCA','IDR',1,'','admin','2016-11-15 11:39:59','admin','2016-11-15 11:39:59'),('2116.0002',4,'Hutang Bank Ekonomi','IDR',2,'','admin','2016-11-15 11:40:22','admin','2016-11-15 11:40:22'),('2117',3,'Hutang Angsuran','IDR',23,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2117.0001',4,'Hutang Angsuran Motor','IDR',1,'','admin','2016-11-15 11:40:57','admin','2016-11-15 11:40:57'),('2117.0002',4,'Hutang Angsuran Mobil (KKB BCA)','IDR',2,'','admin','2016-11-15 11:41:25','admin','2016-11-15 11:41:25'),('2118',3,'Hutang Lain2','IDR',24,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2118.0001',4,'Hutang Pemegang saham Nurdin Wijaya','IDR',1,'','admin','2016-11-15 11:42:34','admin','2016-11-15 11:42:34'),('2118.0002',4,'Hutang Direksi','IDR',2,'','admin','2016-11-15 11:42:50','admin','2016-11-15 11:42:50'),('2118.0003',4,'Hutang Lain-Lain','IDR',3,'','admin','2016-11-15 11:43:05','admin','2016-11-15 11:43:05'),('2119',3,'Uang Muka Penjualan','IDR',25,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2119.0001',4,'UM Penjualan Customer','IDR',1,'','admin','2016-11-15 11:43:21','admin','2016-11-15 11:43:21'),('2120',3,'Pendapatan Diterima Dimuka','IDR',26,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('2120.0001',4,'Pendapatan diterima di muka (perkasus)','IDR',1,'','admin','2016-11-15 11:43:21','admin','2016-11-15 11:43:21'),('3',0,'Modal','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('31',1,'Modal','IDR',9,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('311',2,'Modal','IDR',8,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('3110',3,'Modal Saham Nurdin Wijaya','IDR',27,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('3110.0001',4,'Modal Saham','IDR',1,'','admin','2016-11-15 11:47:49','admin','2016-11-15 11:47:49'),('318',2,'Laba Ditahan','IDR',1,'','admin','2016-07-14 16:00:00','admin','2016-07-14 16:00:00'),('3180',3,'Laba Ditahan','IDR',28,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('3180.0001',4,'Laba Ditahan','IDR',1,'','admin','2016-11-15 11:52:00','admin','2016-11-15 11:52:00'),('319',2,'Laba / Rugi Periode','IDR',1,'','admin','2016-07-14 16:00:00','admin','2016-07-14 16:00:00'),('3190',3,'Laba / Rugi Periode Berjalan','IDR',29,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('3190.0001',4,'Laba / Rugi Periode Berjalan','IDR',1,'','admin','2016-11-15 11:52:00','admin','2016-11-15 11:52:00'),('3190.0002',4,'Laba / Rugi Tahun Lalu','IDR',2,'','admin','2016-11-15 11:52:00','admin','2016-11-15 11:52:00'),('4',0,'Penjualan','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('41',1,'Penjualan / Pendapatan','IDR',10,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('411',2,'Penjualan / Pendapatan','IDR',9,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('4110',3,'Penjualan / Pendapatan','IDR',30,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('4110.0001',4,'Penjualan Sample','IDR',1,'','admin','2016-11-15 13:18:02','admin','2016-11-15 13:18:02'),('4110.0002',4,'Penjualan  Lokal','IDR',2,'','admin','2016-11-15 13:18:11','admin','2017-12-21 14:29:15'),('4110.0003',4,'Discount Penjualan Lokal','IDR',3,'','admin','2016-11-15 13:18:42','admin','2016-11-15 13:18:42'),('4110.0004',4,'Potongan Penjualan Lokal','IDR',4,'','admin','2016-11-15 13:19:00','admin','2016-11-15 13:19:00'),('4110.0005',4,'Retur Penjualan Lokal','IDR',5,'','admin','2016-11-15 13:19:17','admin','2017-12-21 14:29:47'),('5',0,'Harga Pokok Penjualan','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('51',1,'Harga Pokok Penjualan / Pendapatan','IDR',11,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('511',2,'Harga Pokok Penjualan / Pendapatan','IDR',10,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('5110',3,'Harga Pokok Penjualan','IDR',31,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('5110.0001',4,'COGS / HPP','IDR',1,'','admin','2016-11-15 13:23:01','admin','2017-12-22 09:57:28'),('5110.0002',4,'Retur Pembelian','IDR',2,'','admin','2016-11-15 13:23:32','admin','2016-11-15 13:23:32'),('5110.0003',4,'Discount Pembelian','IDR',3,'','admin','2016-11-15 13:24:00','admin','2016-11-15 13:24:00'),('5110.0004',4,'By Gudang','IDR',4,'','admin','2016-11-15 13:25:22','admin','2016-11-15 13:25:22'),('5110.0005',4,'By Label / Stiker','IDR',5,'','admin','2016-11-15 13:25:41','admin','2016-11-15 13:25:41'),('5110.0006',4,'By Angkut','IDR',6,'','admin','2016-11-15 13:26:13','admin','2016-11-15 13:26:13'),('5110.0007',4,'Bea Masuk','IDR',7,'','admin','2016-11-15 13:26:35','admin','2016-11-15 13:26:35'),('5110.0008',4,'PPN Impor','IDR',8,'','admin','2016-11-15 13:27:03','admin','2016-11-15 13:27:03'),('5110.0009',4,'By Radiasi Bahan Baku BATAN','IDR',9,'','admin','2016-11-15 13:27:19','admin','2016-11-15 13:27:19'),('5110.0010',4,'PPPN BM (Barang Mewah)','IDR',10,'','admin','2016-11-15 13:27:38','admin','2016-11-15 13:27:38'),('5110.0011',4,'Komisi Impor','IDR',11,'','admin','2016-11-15 13:27:53','admin','2016-11-15 13:27:53'),('5110.0012',4,'Biaya Asuransi','IDR',12,'','admin','2016-11-15 13:28:10','admin','2016-11-15 13:28:10'),('5110.0013',4,'Ikhtisar R/L','IDR',13,'','admin','2016-11-15 13:43:37','admin','2016-11-15 13:43:37'),('6',0,'Biaya Operasional','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('61',1,'Biaya Operasional','IDR',12,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('611',2,'Biaya Operasional','IDR',11,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('6110',3,'Biaya Karyawan','IDR',32,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('6110.0001',4,'By Gaji Karyawan','IDR',1,'','admin','2016-11-15 13:49:23','admin','2016-11-15 13:49:23'),('6110.0002',4,'By Lembur Karyawan','IDR',2,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0003',4,'By Uang Makan Karyawan','IDR',3,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0004',4,'By Uang Transport','IDR',4,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0005',4,'By Pengobatan Karyawan','IDR',5,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0006',4,'By Pakaian Hari Raya Karyawan','IDR',6,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0007',4,'By THR Karyawan','IDR',7,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0008',4,'By Bonus Karyawan','IDR',8,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0009',4,'By Pesangon Karyawan','IDR',9,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0010',4,'By PPh 21','IDR',10,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0011',4,'By Asuransi (Pensiun)','IDR',11,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0012',4,'By Training Karyawan','IDR',12,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6110.0013',4,'By Rekreasi & Fellowship Karyawan','IDR',13,'','admin','2016-11-15 13:49:39','admin','2016-11-15 13:49:39'),('6111',3,'Biaya Umum, Kantor, dan Administrasi','IDR',33,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('6111.0001',4,'By. Perlengkapan Kantor','IDR',1,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:12:01'),('6111.0002',4,'By. Pos & Materai','IDR',2,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:12:46'),('6111.0003',4,'By. Internet Kantor','IDR',3,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:14:17'),('6111.0004',4,'By. PLN & PAM','IDR',4,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:23:41'),('6111.0005',4,'By. Telepon, Fax, & Hallophone','IDR',5,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:24:35'),('6111.0006',4,'By. Handphone','IDR',6,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:25:24'),('6111.0007',4,'By. Bensin, Parkir, & Tol','IDR',7,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:26:30'),('6111.0008',4,'By. Keamanan & Kebersihan Kantor','IDR',8,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:27:21'),('6111.0009',4,'By. Jasa Perpanjangan','IDR',9,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:28:29'),('6111.0010',4,'By. Adm Bank','IDR',10,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:28:59'),('6111.0011',4,'By. Asuransi','IDR',11,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:29:52'),('6111.0012',4,'By. Kalibrasi','IDR',12,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:31:03'),('6111.0013',4,'By. Pajak','IDR',13,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:31:48'),('6111.0014',4,'By. Denda Pajak','IDR',14,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:32:18'),('6111.0015',4,'By. Pajak Bumi & Bangunan  (PBB)','IDR',15,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:33:21'),('6111.0016',4,'By. Fotocopy','IDR',16,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:34:10'),('6111.0017',4,'By. Ijin','IDR',17,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:34:54'),('6111.0018',4,'By. Entertainment','IDR',18,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:35:22'),('6111.0019',4,'By. Limbah','IDR',19,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:35:53'),('6111.0020',4,'By. ATK & Cetakan','IDR',20,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:40:49'),('6111.0021',4,'R & P Bangunan Kantor','IDR',21,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:41:53'),('6111.0022',4,'R & P Inventaris Kantor','IDR',22,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:42:33'),('6111.0023',4,'R & P Kendaraan','IDR',23,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:43:13'),('6111.0024',4,'By. Dapur','IDR',24,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:43:57'),('6111.0025',4,'By. Sample','IDR',25,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:44:24'),('6111.0026',4,'By. Transfer Bank','IDR',26,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:45:09'),('6111.0027',4,'By. Lain2','IDR',27,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:45:57'),('6111.0028',4,'By. Konsultan  (Profesional Fee)','IDR',28,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:46:48'),('6111.0029',4,'By. Bunga Pinjaman / Angsuran','IDR',29,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:47:30'),('6111.0030',4,'By. Transportasi & Akomodasi Perjalanan Dinas','IDR',30,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:48:15'),('6112',3,'Biaya Penjualan','IDR',34,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('6112.0001',4,'By. Angkut & Penjualan','IDR',1,'','admin','2016-11-15 13:57:39','admin','2017-11-17 14:42:39'),('6112.0002',4,'By. Komisi','IDR',2,'','admin','2016-11-15 13:57:39','admin','2017-11-17 13:48:53'),('6112.0003',4,'By. Iklan & Promosi','IDR',3,'','admin','2016-11-15 13:57:39','admin','2017-11-17 14:40:00'),('6112.0004',4,'By. Inklaring','IDR',4,'','admin','2016-11-15 13:57:39','admin','2017-11-17 16:15:01'),('6112.0005',4,'By. Kirim Barang  (FEDEX; DHL; EMS; UPS; TNT)','IDR',5,'','admin','2016-11-15 13:57:39','admin','2017-11-17 16:16:11'),('6112.0006',4,'By. Dokumen','IDR',6,'','admin','2016-11-15 13:57:39','admin','2017-11-17 16:16:54'),('6112.0007',4,'By. Handling','IDR',7,'','admin','2016-11-15 13:57:39','admin','2017-11-17 16:17:38'),('6112.0008',4,'By. Impor','IDR',8,'','admin','2016-11-15 13:57:39','admin','2017-11-17 16:18:21'),('6112.0009',4,'By. Claim','IDR',9,'','admin','2016-11-15 13:57:39','admin','2017-11-17 16:19:15'),('6112.0010',4,'By Ekspedisi / Kurir  (PANALOG)','IDR',10,'','admin','2016-11-15 13:57:39','admin','2017-11-17 16:20:24'),('6112.0011',4,'By. Kirim Barang ke Customer  (HIRA, TIKI, THOMAS EXPRESS & RENT CAR)','IDR',11,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:33:20'),('6112.0012',4,'bY. sEWA gUDANG','IDR',12,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:33:57'),('6112.0013',4,'bY. tRANSPORTASI  (ppjk)','IDR',13,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:34:22'),('6112.0014',4,'By Jalur Kuning / Merah  (Pemeriksaan Dokumen)','IDR',14,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:35:05'),('6112.0015',4,'By. Koreksi Manifes / Re - Address','IDR',15,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:35:54'),('6112.0016',4,'By. Denda Administrasi Notul','IDR',16,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:36:41'),('6113',3,'Biaya Penyusutan & Amortisasi','IDR',35,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('6113.0001',4,'By Peny. Tanah','IDR',1,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:48:07'),('6113.0002',4,'By. Peny. Bangunan Kantor','IDR',2,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:48:37'),('6113.0003',4,'By. Peny. Mesin','IDR',3,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:49:06'),('6113.0004',4,'By. Peny. Peralatan Kantor','IDR',4,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:49:34'),('6113.0005',4,'By. Peny. Peralatan Laboratorium','IDR',5,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:50:08'),('6113.0006',4,'By. Peny. Inventaris Kantor','IDR',6,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:50:38'),('6113.0007',4,'By. Peny. Kendaraan','IDR',7,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:51:04'),('6113.0008',4,'By. Peny. Furniture Kantor','IDR',8,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:51:40'),('6113.0009',4,'By. Peny. Leasing','IDR',9,'','admin','2016-11-15 13:57:39','admin','2017-12-21 14:52:13'),('7',0,'Pendapatan Lain-lain','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('71',1,'Penjualan / Pendapatan Lain2','IDR',13,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('711',2,'Penjualan / Pendapatan Lain2','IDR',12,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('7110',3,'Pendapatan Lain2','IDR',36,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('7110.0001',4,'Pendapatan Jasa Giro','IDR',1,'','admin','2016-11-15 13:57:39','admin','2016-11-15 13:57:39'),('7110.0002',4,'Pendapatan Bunga dari Pihak ke 3','IDR',2,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:05:22'),('7110.0003',4,'Pendapatan Klaim','IDR',3,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:07:41'),('7110.0004',4,'Pendapatan Komisi','IDR',4,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:07:59'),('7110.0005',4,'Pendapatan Sewa','IDR',5,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:08:17'),('7110.0006',4,'Pendapatan Investasi Jangka Pendek','IDR',6,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:08:49'),('7110.0007',4,'Pendapatan Lain - lain','IDR',7,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:09:20'),('7110.0008',4,'Selisih Kurs  (Penjualan & Pembelian)','IDR',8,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:10:11'),('7110.0009',4,'Laba Penjualan Aktiva Tetap','IDR',9,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:10:50'),('7110.0010',4,'Selisih Kurs  (Kas & Bank)','IDR',10,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:11:26'),('7110.0011',4,'Pendapatan Stock Opname','IDR',11,'','admin','2017-03-23 08:25:51','admin','2017-12-21 15:12:12'),('8',0,'Biaya Lain-lain','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('81',1,'Biaya Penjualan / Pendapatan Lain2','IDR',14,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('811',2,'Biaya Penjualan / Pendapatan Lain2','IDR',13,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('8110',3,'Biaya Lain2','IDR',37,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('8110.0001',4,'By Bunga Bank','IDR',1,'','admin','2016-11-15 13:57:39','admin','2016-11-15 13:57:39'),('8110.0002',4,'By. Bunga Pihak Ke 3','IDR',2,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:14:00'),('8110.0003',4,'By. Bunga Leasing','IDR',3,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:14:33'),('8110.0004',4,'Dst..','IDR',4,'','admin','2016-11-15 13:57:39','admin','2016-11-15 13:57:39'),('8110.0005',4,'Rugi Penjualan Aktiva Tetap','IDR',5,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:15:43'),('8110.0006',4,'Rugi Penjualan Investasi Jangka Pendek','IDR',6,'','admin','2016-11-15 13:57:39','admin','2017-12-21 15:16:13'),('8110.0007',4,'Rugi Stock Opname','IDR',7,'','admin','2017-03-23 08:26:57','admin','2017-12-21 15:16:42'),('9',0,'Ayat Silang','IDR',1,'','SYSTEM','2017-07-12 16:29:02','SYSTEM','2017-07-12 16:29:02'),('91',1,'Ayat Silang & Ikh L/R','IDR',15,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('911',2,'Ayat Silang & Ikh L/R','IDR',14,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('9110',3,'Ayat Silang & Ikh L/R','IDR',39,'','admin','2016-11-02 09:48:40','admin','2016-11-02 09:48:40'),('9110.0001',4,'Ayat Silang','IDR',1,'','admin','2016-11-15 14:20:28','admin','2016-11-15 14:20:28'),('9110.0002',4,'Ikh L/R','IDR',2,'','admin','2016-11-15 14:20:40','admin','2016-11-15 14:20:40');
/*!40000 ALTER TABLE `ms_coa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_coasetting`
--

DROP TABLE IF EXISTS `ms_coasetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_coasetting` (
  `key` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `coaNo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_coasetting`
--

LOCK TABLES `ms_coasetting` WRITE;
/*!40000 ALTER TABLE `ms_coasetting` DISABLE KEYS */;
INSERT INTO `ms_coasetting` VALUES ('AdminBank','Biaya Administrasi Bank','6111.0010'),('BeaImpor','Hutang Bea Impor','2115.0009'),('ByTxBank','By Transfer bank','6111.0026'),('COGS','COGS/HPP','5110.0001'),('DiscountPenjualanLokal','Discount Penjualan Lokal','4110.0003'),('HutangDagang','Hutang Dagang','2111.0001'),('HutangPPJK','Hutang kpd PPJK','2111.0002'),('HutangPPNImpor','Hutang PPN Impor','2115.0010'),('IncomeStockOpname','Pendapatan Stock Opname','7110.0011'),('LabaRugi','Laba / Rugi Periode Berjalan','3190.0001'),('PenjualanLokal','Penjualan Lokal','4110.0002'),('PiutangDagangCustomer','Piutang Dagang Customer','1114.0001'),('PiutangPPN','Piutang PPN','1122.0002'),('PPH22Impor','Hutang PPh Ps 22 (Impor)','2115.0011'),('PPN','Hutang PPN','2115.0002'),('PPNImpor','Hutang PPN Impor','2115.0010'),('RugiStockOpname','Rugi Stock Opname','8110.0007'),('SelisihKursKasBank','Selisih Kurs  (Kas & Bank)','7110.0010'),('SelisihKursPenjualanPembelian','Selisih Kurs  (Penjualan & Pembelian)','7110.0008'),('UangMukaCustomer','Uang Muka Customer','1120.0003'),('UangMukaSupplier','Uang Muka Supplier','1120.0002'),('UMPCustomer','UM Penjualan Customer','2119.0001');
/*!40000 ALTER TABLE `ms_coasetting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_country`
--

DROP TABLE IF EXISTS `ms_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_country` (
  `countryID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Country ID',
  `countryName` varchar(50) NOT NULL COMMENT 'Country Name',
  `notes` varchar(100) DEFAULT NULL COMMENT 'Notes',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`countryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_country`
--

LOCK TABLES `ms_country` WRITE;
/*!40000 ALTER TABLE `ms_country` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_currency`
--

DROP TABLE IF EXISTS `ms_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_currency` (
  `currencyID` varchar(5) NOT NULL COMMENT 'Currency ID',
  `currencyName` varchar(50) NOT NULL COMMENT 'Currency Name',
  `currencySign` varchar(3) NOT NULL COMMENT 'Currency Sign',
  `rate` decimal(18,2) NOT NULL COMMENT 'Rate',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`currencyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Currency = Exchange Rate';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_currency`
--

LOCK TABLES `ms_currency` WRITE;
/*!40000 ALTER TABLE `ms_currency` DISABLE KEYS */;
INSERT INTO `ms_currency` VALUES ('EURO','Euro','€',14000.00,'','admin','2016-11-11 16:15:54','admin','2017-03-31 15:02:30'),('IDR','Indonesian Rupiah','Rp',1.00,'','admin','2016-10-21 15:03:51','admin','2016-11-14 14:06:46'),('RGN','RINGGIT','RGN',3.00,'\0','admin','2017-03-07 14:18:52','admin','2017-03-07 14:19:48'),('RMB','Yuan','Y',1.00,'','admin','2016-11-17 13:28:49','admin','2017-03-07 13:42:02'),('SEK','Swedish Krona','SEK',18.00,'','admin','2016-11-11 16:38:44','admin','2017-03-07 10:48:08'),('USD','US Dollars','$',13000.00,'','admin','2016-10-21 15:03:51','admin','2017-04-20 15:50:10');
/*!40000 ALTER TABLE `ms_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_customer`
--

DROP TABLE IF EXISTS `ms_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_customer` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Customer ID',
  `customerName` varchar(200) NOT NULL COMMENT 'Customer Name',
  `dueDate` int(11) DEFAULT NULL COMMENT 'Due Date',
  `creditLimit` decimal(18,2) DEFAULT NULL COMMENT 'Credit Limit',
  `email` varchar(200) DEFAULT NULL COMMENT 'Email',
  `npwp` varchar(50) DEFAULT NULL COMMENT 'NPWP',
  `npwpAddress` varchar(200) DEFAULT NULL,
  `npwpRegisteredDate` datetime DEFAULT NULL,
  `notes` varchar(100) DEFAULT NULL COMMENT 'Notes',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_customer`
--

LOCK TABLES `ms_customer` WRITE;
/*!40000 ALTER TABLE `ms_customer` DISABLE KEYS */;
INSERT INTO `ms_customer` VALUES (6,'PT.  Ethica Industri Farmasi',45,NULL,'','01.303.269.3-007.000','Jl. Pulogadung No. 6, KIP\r\nRawa Terate - Cakung\r\nJakarta Timur 13920','1982-11-05 00:00:00','- Tukar Faktur Setiap Hari di MAYAPADA TOWER, Bidakara - Pancoran\r\n   Pukul 08-16.00 WIB','','admin','2016-11-08 11:00:41','vetty','2018-01-25 16:00:17'),(7,'PT.  Futamed Pharmaceuticals',30,NULL,'','02.574.947.4-047.000','Rukan Gold Coast Blok B No. 10-11\r\nBukit Golf Mediterania PIK , RT. 004 / RW. 003\r\nKamal Muara - Penjaringan\r\nJakarta Utara - DKI Jakarta Raya','2007-04-12 00:00:00','- Tukar Faktur Setiap Hari, Pukul 09.00 - 15.00 WIB','','admin','2016-11-09 13:13:19','vetty','2018-01-25 16:02:47'),(8,'PT.  Mahakam Beta Farma',30,NULL,'','01.309.889.2-007.000','Jl. Pulo Kambing II No. 20, KIP Rawa Terate - Cakung\r\nJakarta Timur 13930',NULL,'','','admin','2016-11-14 10:02:09','vetty','2018-01-26 15:31:32'),(9,'PT.  Global Health Pharmaceutical',30,NULL,'log.adm@globalhealth.co.id','','',NULL,'','','admin','2016-11-14 14:02:31','vetty','2018-01-25 16:18:12'),(10,'PT.  Sri Aman Corporindo',30,NULL,'info@simanco.co.id','','',NULL,'','','admin','2017-03-07 14:29:19','vetty','2018-01-17 16:16:28'),(13,'PT.  Interbat',30,NULL,'','01.001.917.2-073.000','Ruko Mega Grosir Cempaka Mas Blok K No.1\r\nJl. Letjend Suprapto - Sumur Batu - Kemayoran\r\nJakarta Pusat - DKI Jakarta 10640','1983-12-31 00:00:00','- Tukar Faktur Setiap Hari, Pukul 08.00-16.00 WIB','','admin','2017-08-10 14:31:11','vetty','2018-01-25 16:43:36'),(16,'PT.  Nufarindo',30,NULL,'wiwik.suryani@exeltis.com','01.121.034.1-511.000','Jl. Raya Mangkang Kulon\r\nKM. 16.5, Mangkang Kulon\r\nTugu - Semarang - Jawa Tengah','2007-04-09 00:00:00','','','admin','2017-08-23 16:43:11','yudhi','2018-01-19 16:01:14'),(17,'PT.  Meprofarm',30,NULL,'','01.131.033.1-441.000','Jl. Soekarno Hatta No. 789, Cisaranten Wetan\r\nUjung Berung - Bandung - Jawa Barat','2007-04-09 00:00:00','','','admin','2017-09-26 19:19:46','vetty','2018-01-25 16:56:08'),(18,'PT.  Guardian Pharmatama',30,NULL,'','01.310.245.4-038.000','Green Ville Maisonette Blok FA No.18-19\r\nDuri Kepa -  Kebon Jeruk \r\nJakarta Barat - DKI Jakarta Raya - 00000',NULL,'- Tukar Faktur Senin & Kamis, Pukul 10.00 - 14.00 WIB\r\n- Pembayaran Hari Kamis, Pukul 10.00 - 14.00','','admin','2017-10-02 08:58:12','vetty','2018-01-25 16:25:00'),(19,'PT.  Galenium Pharmasia Laboratories',60,NULL,'','02.406.277.0-062.000','Jl. Raya Kebayoran Lama No. 21\r\n Grogol Utara - Kebayoran Lama\r\nJakarta Selatan - DKI Jakarta','2007-04-09 00:00:00','- Tukar Faktur Senin & Kamis Pukul 10.00-11.30 WIB\r\n- Pembayaran Setiap Hari Rabu','','admin','2017-10-02 09:43:19','vetty','2018-01-25 16:05:42'),(20,'PT.  Mersifarma Tirmaku Mercusana',30,NULL,'','01.792.434.1-441.000','Jl. Raya Pelabuhan KM 18, Cikembar\r\nCikembar - Kab.Sukabumi - Jawa Barat','2003-08-06 00:00:00','- Tukar Faktur & Pembayaran Setiap Hari Senin, Pukul 13.00 - 16.00  WIB\r\n','','admin','2017-10-02 09:55:28','vetty','2018-01-26 11:03:07'),(21,'PT.  Tempo Scan Pacific',30,NULL,'','01.000.781.3-092.000','Gedung Tempo Scan Tower Lt.16, Jl. HR Rasuna Said Kav. 3-4, Jakarta Selatan 12950',NULL,'-Tukar Faktur Setiap Hari, Pukul 08.00 - 14.30 WIB di CIKARANG','','admin','2017-10-02 10:13:57','vetty','2018-01-26 15:50:14'),(22,'PT.  Erela (Erlangga Edi Laboratories)',30,NULL,'','01.144.101.1-511.000','Jl Erlangga Raya No. 9-11-14-26\r\nPleburan, Semarang Selatan\r\nKota Semarang , Jawa Tengah','2007-04-09 00:00:00','','','admin','2017-10-02 10:33:20','vetty','2018-01-25 13:46:45'),(23,'PT.  Anindojaya Swakarsa',30,NULL,'','01.653.730.0-046.000','Jl. Dewi Shinta Blok B-2 No.1\r\nKelapa Gading Timur - Kelapa Gading\r\nJakarta Utara','2007-04-09 00:00:00','- Tukar Faktur Tiap Hari Jum\'at Pukul 08.00-17.00 WIB','','admin','2017-10-02 10:40:18','vetty','2018-01-25 13:48:43'),(24,'PT.  Bahtera Sentra Niagatama',60,NULL,'','73.483.988.9-045.000','Jl. Raya Kelapa Hybrida Grand Orchad Square GOS No. D16 RT.004 RW.011 , Sukapura,Cilincing,Jakarta Utara, DKI Jakarta','2015-07-15 00:00:00','- Tukar Faktur Setiap Hari Pukul 08.00 - 17.00 WIB','','admin','2017-10-02 11:38:51','vetty','2018-01-25 13:49:02'),(25,'PT.  Bina San Prima',30,NULL,'','01.588.725.0-092.000','Jl. Purnawarman No. 47\r\nTaman Sari - Bandung Wetan\r\nBandung - Jawa Barat 40116','2007-04-01 00:00:00','','','admin','2017-10-02 11:42:37','vetty','2018-02-21 10:21:54'),(26,'PT.  Bufa Aneka',30,NULL,'','01.244.362.8-511.000','Jl. Tambak Aji V Nomor 4, RT. 001/RW.012 - Tambak Aji - Ngaliyan - Semarang - Jawa Tengah','2007-04-05 00:00:00','','','admin','2017-10-02 11:46:42','vetty','2018-03-01 15:32:25'),(27,'PT.  Novell Pharmaceutical Laboratories',30,NULL,'','01.002.680.5-052.000','Jl. Pos Pengumben Raya No. 8  - RT.005 RW .05, Kebon Jeruk,\r\nJakarta Barat, DKI Jakarta Raya\r\n','2011-07-13 00:00:00','- Tukar Faktur Setiap Hari Senin & Rabu Pukul 10.00 - 12.00   WIB di POS PENGUMBEN','','admin','2017-10-12 16:55:34','vetty','2018-01-17 16:06:56'),(28,'PT.  Ika Pharmindo Putramas',30,NULL,'','01.104.846.9-007.000','Jl. Raya Pulogadung No.29 KIP\r\nJatinegara - Cakung\r\nJakarta Timur 13920','2007-04-09 00:00:00','- Tukar Faktur Setiap Hari Kamis Pukul 14.00-16.00 WIB (Boleh tiap hari ke Bu. Susi)','','admin','2017-10-13 08:52:07','vetty','2018-01-25 16:30:53'),(29,'PT.  Yarindo Farmatama',30,NULL,'','01.679.372.1-415.000','Jl. Modern Industri IV Kav. 29, Kawasan Industri\r\nNambo Ilir - Kibin Serang 42186','2006-07-01 00:00:00','- Tukar Faktur Setiap Hari Pukul 08.00-16.00 WIB di kantor','','admin','2017-10-13 09:06:05','vetty','2018-01-17 16:24:11'),(30,'PT.  Surya Kejayan Jaya Farma',30,NULL,'skjfpt@gmail.com','01.454.118.9-631.000',' Jl. Sumatera No. 66\r\nGubeng - Gubeng\r\nSurabaya - Jawa Timur','2008-04-07 00:00:00','','','admin','2017-10-13 09:23:33','vetty','2018-01-17 16:18:35'),(31,'PT.  Surya Dermato Medica Laboratories',30,NULL,'','01.122.214.8-631.000',' Jl. Aria Wiratanudatar KM 8,Kp. Warung Danas\r\nRT. 03 RW. 01 , Kademangan,Mande,Cianjur\r\nJawa Barat - 43292','2007-04-09 00:00:00','','','admin','2017-10-13 09:30:26','vetty','2018-01-17 16:17:19'),(32,'PT.  Tropica Mas Pharmaceuticals',30,NULL,'','01.131.872.2-441.000','Jl. Aria Wiratanudatar KM 8,Kp. Warung Danas\r\nRT.03 RW.01 , Kademangan , Mande , Cianjur\r\nJawa Barat - 43292',NULL,'','','admin','2017-10-13 09:33:44','admin','2017-12-21 15:02:18'),(33,'PT.  Simex Pharmaceutical Indonesia',30,NULL,'',' 02.039.013.4-046.000','Komplek Ruko Mitra Bahari Blok E No. 15/16,\r\nJl. Pakin No. 1 Penjaringan Jakarta Utara','2008-04-07 00:00:00','- Tukar Faktur Setiap Hari Jum\'at, Pukul 08.00 - 16.00 WIB','','admin','2017-10-13 09:49:53','vetty','2018-03-19 14:06:49'),(34,'PT.  Tunggal Idaman Abdi',30,NULL,'suparsiningsih@tia-pharma.com','01.000.786.2-007.000','Jl. Jend. A. Yani No. 7 RT 011 RW 006\r\nPisangan Timur - Pulo Gadung\r\nJakarta Timur','1983-12-31 00:00:00','- Tukar Faktur Setiap Hari Rabu, Pukul 10.00 - 16.00 WIB','','admin','2017-10-13 10:05:19','vetty','2018-01-17 16:23:03'),(35,'PT.  Teguhsindo Lestaritama',30,NULL,'','01.343.494.9-007.000','Jl. Haji Miran No. 32 RT 001/RW 002\r\nPondok Kopi - Duren Sawit\r\nJakarta Timur - DKI Jakarta 13460',NULL,'- Tukar Faktur Setiap Hari Selasa & Kamis, Pukul 09.00 - 16.00 WIB\r\n- Pembayaran Hari Kamis Pagi','','admin','2017-10-13 10:12:33','vetty','2018-01-17 16:19:47'),(36,'PT.  Erlimpex',30,NULL,'','01.144.110.2-551.000','Jl. Dr. Setiabudi No. 130\r\nSrondol Kulon,\r\nBanyumanik, Semarang\r\nJawa Tengah\r\n00000','2007-04-09 00:00:00','','','admin','2017-10-13 10:53:23','saiba','2018-03-22 15:29:01'),(37,'PT.  Cendo',30,NULL,'',' 01.119.005.5-441.000','Jl Cisirung Palasari (Jl Moch Toha KM 6,7)\r\nDayeuhkolot Kab. Bandung\r\nJawa Barat, 40256\r\n','2009-04-09 00:00:00','','','admin','2017-10-13 11:03:25','vetty','2018-02-07 13:14:23'),(38,'PT.  Corsa Industries',30,NULL,'','01.309.580.7-415.000','Jl. Gatot Subroto KM 7,5\r\nManis Jaya Jatiuwung\r\nKota Tangerang Banten','2006-07-01 00:00:00','','','admin','2017-10-13 11:11:52','vetty','2018-01-25 15:25:05'),(39,'PT.  Dian Cipta Perkasa',30,NULL,'','01.553.455.5-007.000','Puri Sentra Niaga Blok B No. 25 RT.012 RW.07\r\nCipinang Melayu - Makasar\r\nJakarta Timur 13620','1991-09-10 00:00:00','- Tukar Faktur Setiap Hari Selasa & Jum\'at, Pukul 08.00 - 16.00 WIB','','admin','2017-10-13 11:30:08','vetty','2018-01-25 15:30:48'),(40,'PT.  Dipa Pharmalab Intersains',30,NULL,'','01.539.601.3-038.000','Jl. Kebayoran Lama No. 28  RT.009 RW.011\r\nKebayoran Lama\r\nJakarta Selatan',NULL,'- Tukar Faktur Setiap Hari Selasa & Kamis, Pukul 13.00 - 16.00 WIB','','admin','2017-10-13 13:17:44','vetty','2018-01-25 15:41:12'),(41,'PT.  Errita Pharma',30,NULL,'','01.104.181.1-441.000','Jl. Peundeuy, Bojong Salam, Rancaekek,\r\nKab. Bandung','2008-04-07 00:00:00','','','admin','2017-10-13 13:28:58','vetty','2018-01-25 15:47:49'),(42,'PT.  Etercon Pharma',30,NULL,'','01.132.404.3.052.000','Jl. Pos Pengumben Raya No. 8\r\nKebon Jeruk - Jakarta Barat\r\nDKI Jakarta Raya 11560','2007-04-09 00:00:00','- TF Setiap Hari Selasa & Kamis Sampai Pukul 12.00 WIB\r\n- Kalau barang dikirim ke SMG TF di SMG','','admin','2017-10-13 13:45:09','vetty','2018-01-25 15:58:43'),(43,'PT.  Genero Pharmaceuticals',30,NULL,'','02.004.473.1-038.000','Jl. Arjuna Utara No. 52\r\nDuri Kepa - Kebon Jeruk\r\nJakarta Barat',NULL,'- TF Senin & Kamis, Pukul 10.00 - 12.00 WIB\r\n   Di Eightyeight @ Kokas Office Tower Fl.16-17 unit A','','admin','2017-10-13 13:58:34','vetty','2018-01-25 16:13:08'),(44,'PT.  Gratia Husada Farma',30,NULL,'','01.132.191.6-511.000','Jl. Darmawangsa No. 28\r\nNgempon - Bergas\r\nSemarang','1995-01-05 00:00:00','','','admin','2017-10-13 14:06:05','vetty','2018-01-25 16:23:46'),(45,'PT.  Hensan Bersama Sukses',30,NULL,'','03.028.979.7-416.000','Business Park Tangerang City Blok E No. 6,\r\nJl. Jend. Sudirman, Babakan, Tangerang,\r\nTangerang, Banten','2013-04-17 00:00:00','- TF Setiap Hari Pukul 08.00 - 16.00 WIB ','','admin','2017-10-13 14:13:48','vetty','2018-01-25 16:27:03'),(46,'PT.  Kairos Tritunggal',60,NULL,'kairostrifa@gmail.com','21.042.942.9-007.000','Jl. Raya Bekasi Km. 25 - Ruko Inkopau Blok A No.8-9\r\nUjung Menteng - Cakung - Jakarta Timur - DKI Jakarta Raya',NULL,'- TF Setiap Hari Pukul 08.00 - 16.00 WIB','','admin','2017-10-13 14:20:42','vetty','2018-01-25 16:44:23'),(47,'PT.  Kolosal Pratama',30,NULL,' info@kolosal.co.id','02.100.386.8-003.000','Ruko Graha Mas Pemuda Blok AC No. 15-16\r\nJl. Pemuda Jati - Pulo Gadung - Jakarta Timur','2002-02-26 00:00:00','- Tukat Faktur Setiap Hari Pukul 08.00 - 16.00 WIB','','admin','2017-10-13 15:52:32','vetty','2018-01-25 16:47:00'),(48,'PT.  Libra Utama Farma',60,NULL,'','31.564.822.0-006.000','Menteng Niaga Blok I 1 No. 20-21 RT 009  RW 007\r\nUjung Menteng - Cakung - Jakarta Timur - DKI Jakarta Raya\r\n','2012-07-18 00:00:00','- Tukar Faktur Setiap Hari, Pukul 08.00 - 16.00 WIB','','admin','2017-10-13 16:10:34','vetty','2018-01-25 16:48:35'),(49,'PT.  Lucas Djaja',30,NULL,'','01.105.047.3-429.000','Jl. Ciwastra Margasari, Buahbatu, Bandung\r\nJawa Barat','2005-04-15 00:00:00','','','admin','2017-10-13 16:17:38','vetty','2018-01-25 16:50:09'),(50,'PT.  Marin Liza Farmasi',30,NULL,'','01.104.591.1-441.000','Jl. Terusan Kiaracondong No. 43,  Margasari,\r\nMargacinta, Bandung ','2008-04-07 00:00:00','','','admin','2017-10-13 16:21:51','vetty','2018-01-25 16:51:16'),(51,'PT.  Mecosin Indonesia',30,NULL,'','01.105.103.4-038.000','Jl. Palmerah Utara No. 14 A\r\nPalmerah\r\nJakarta Barat','2007-04-09 00:00:00','- Tukar Faktur Setiap Hari, Pukul 08.00 - 16.00 WIB','','admin','2017-10-13 16:27:11','vetty','2018-01-17 15:51:54'),(52,'PT.  Metiska Farma',30,NULL,'tri.pratiwi@metiska.co.id','01.000.891.0-062.000','Jl. Raya Kebayoran Lama No. 557\r\nGrogol Selatan - Kebayoran Lama\r\nJakarta Selatan - DKI Jakarta','2008-04-07 00:00:00','- Tukar Faktur Setiap Hari Selasa & Kamis, Pukul 08.00 - 16.00 WIB','','admin','2017-10-13 16:35:53','vetty','2018-01-17 15:55:14'),(53,'PT.  Molex Ayus',30,NULL,'lmulianingsih@molexayus.com','01.402.146.3-074.000','JL.IR H Juanda NO.5 C Kebon Kelapa\r\nGambir Jakarta Pusat','1986-09-03 00:00:00','- Tukar Faktur Setiap Hari Jum\'at, Pukul 09.00 - 15.00 WIB (ke Bu.IKA)','','admin','2017-10-13 16:42:09','vetty','2018-01-17 16:05:04'),(54,'PT.  Mutiara Mukti Farma',30,NULL,'','01.128.343.9-125.000','Jl. Besar Namo Rambe KM 8,5\r\nRT. RW. Deli Tua\r\nDeli Tua\r\nDeli Serdang','1994-09-20 00:00:00','','','admin','2017-10-13 16:49:07','vetty','2018-01-17 16:05:27'),(55,'PT.  Pharos Indonesia',30,NULL,'purchasinglocal@pharos.co.id','01.000.737.5-052.000','',NULL,'','','admin','2017-10-13 16:56:01','vetty','2018-01-17 16:12:00'),(56,'PT.  Gracia Pharmindo',30,NULL,'','02.065.258.2-441.000','Jl. Baranangsiang Komplek ITC Blok G No.27\r\nKebon Pisang - Sumur Bandung - Bandung - Jawa Barat',NULL,'','','admin','2017-10-18 16:36:38','vetty','2018-03-08 16:03:30'),(57,'PT.  Kimia Farma (Persero), Tbk',30,NULL,'','01.001.627.7-051.000','Jl. Veteran No. 9 RT.005 RW.002\r\nGambir - Gambir Kota\r\nJakarta Pusat - DKI Jakarta 10110',NULL,'','','admin','2017-10-18 16:46:51','vetty','2018-01-17 15:47:55'),(58,'PT.  Phapros Tbk',30,NULL,'','01.000.793.8-051.000','',NULL,'','','admin','2017-10-18 17:00:01','vetty','2018-01-17 16:10:17'),(59,'PT.  Pyridam Farma Tbk',45,NULL,'','01.313.863.1-054.000','Ruko Villa Kebon Jeruk\r\nJl. Raya Kebon Jeruk Blok F3 - Kebon Jeruk, Kebon Jeruk\r\nJakarta Barat - DKI Jakarta - 11530','2002-03-01 00:00:00','- Tukar Faktur Setiap Hari Senin - Jum\'at, Pukul 08.00 - 16.00 WIB','','admin','2017-10-18 17:06:04','vetty','2018-01-17 16:14:29'),(60,'Sanbe Farma',30,NULL,'',' 01.104.916.0-092.000','Jl. Taman Sari No. 10\r\nBandung','2004-01-01 00:00:00','','','admin','2017-10-19 14:35:15','vetty','2018-01-26 13:29:54'),(61,'PT.  Rohto Laboratories Indonesia',30,NULL,'Sellih Sapitri <sellihs@rohtolab.com>','01.071.452.5-052.000','Wisma Barito Pacific Lt.7 Tower B\r\nJl. Letjend S.Parman Kav. 62-63\r\nSlipi - Palmerah - Jakarta Barat\r\nDKI Jakarta 11410','1996-03-22 00:00:00','- Tukar Faktur Setiap Hari, Pukul 09-16.00 WIB','','admin','2017-10-19 14:48:43','vetty','2018-01-17 16:15:24'),(62,'PT.  Rama Emerald Multi Sukses',90,NULL,'','01.438.620.5-641.000','Tenaru - Driyorejo\r\nGresik - Jawa Timur',NULL,'','','admin','2017-10-19 15:01:05','admin','2017-12-21 14:58:49'),(63,'PT.  Pratapa Nirmala',60,NULL,'teddy.saputra@gmail.com','01.302.575.4-073.000','Jl. Raden Saleh 4\r\nKenari - Senen\r\nJakarta Pusat - DKI Jakarta','2008-04-07 00:00:00','','','admin','2017-10-19 15:11:48','vetty','2018-01-17 16:13:00'),(64,'PT.  Promedrahardjo Farmasi Industri',30,NULL,'','   01.789.716.6-441.000    ','Jl. Raya Siliwangi RT.013 RW.006, Sundawenang,\r\nParungkuda, Kab. Sukabumi, Jawa Barat','2003-02-04 00:00:00','- Tukar Faktur Setiap Hari Selasa, Pukul 09.00 - 15.00 WIB','','admin','2017-10-19 15:20:43','vetty','2018-01-17 16:13:23'),(65,'PT.  Sunthi Sepuri',30,NULL,'','01.000.636.9-073.000','Jl. Jend. Sudirman Kav. 7 - 8\r\nKaret Tengsin- Tanah Abang\r\nJakarta Pusat - DKI Jakarta','2008-04-07 00:00:00','- Tukar Faktur Setiap Hari, Pukul 08.00 - 16.00 WIB\r\n   Bisa di kantor & Pabrik','','admin','2017-10-19 15:45:37','vetty','2018-01-17 16:16:48'),(66,'PT.  Golden Coral Corporindo',NULL,NULL,'','','',NULL,'','','vetty','2018-03-12 15:21:49','vetty','2018-03-12 15:21:49');
/*!40000 ALTER TABLE `ms_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_customerdetail`
--

DROP TABLE IF EXISTS `ms_customerdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_customerdetail` (
  `customerDetailID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Customer Detail ID',
  `customerID` int(11) NOT NULL COMMENT 'Customer ID',
  `addressType` varchar(50) NOT NULL COMMENT 'Customer Detail Name',
  `contactPerson` varchar(200) DEFAULT NULL COMMENT 'Contact Person',
  `nickname` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `street` varchar(200) DEFAULT NULL,
  `postalCode` varchar(10) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL COMMENT 'Phone',
  `fax` varchar(50) DEFAULT NULL COMMENT 'Fax',
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`customerDetailID`),
  KEY `ms_customerdetail_fk1_idx` (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_customerdetail`
--

LOCK TABLES `ms_customerdetail` WRITE;
/*!40000 ALTER TABLE `ms_customerdetail` DISABLE KEYS */;
INSERT INTO `ms_customerdetail` VALUES (188,6,'Office','Ibu. Harum Alianty','Harum','Indonesia','Jakarta Timur','Gedung Java Books Lt.II,Jl. Rawagelam IV No. 9 Kawasan Industri Pulogadung - Jakarta Timur','','021-46828140 -231 -841','021-46828216','Harum.Alianty@sohoglobalhealth.com'),(189,6,'Factory','Bp.','','Indonesia','Jakarta Timur','Jl. Pulogadung No. 6 (Kawasan Industri Pulogadung) Jakarta','13920','021-46821064 - 4615133-35','021-4615132',''),(191,19,'Office','Ibu. Sannia','Sannia','Indonesia','Jakarta Selatan','Jl. Raya Kebayoran Lama No.21 - Grogol Utara - Kebayoran Lama - Jakarta Selatan - DKI Jakarta','','021-7228601/3','021-7399275/81','sannia.r@galenium.com'),(192,19,'Factory','Bp. M.Chusnan','Chusnan','Indonesia','Bogor','Jl. Raya Bogor Km 51.5 - Kedung Halang - Bogor','','0251-8652140','',''),(193,43,'Office','Bp. Adam Markus Setiono','Adam','Indonesia','Jakarta Barat','Jl. Arjuna Utara No. 52Duri Kepa - Kebon Jeruk - Jakarta Barat','','021 - 21283083','021 - 39838317','Adam.Setiono@aryanoble.co.id'),(194,43,'Office','Ibu. Asti Astriyani','Asti','Indonesia','Jakarta Barat','Jl. Arjuna Utar','','021 - 89841338','021 - 39838317','Asti.Astriyani@aryanoble.co.id'),(197,44,'Office & Factory','Ibu. Nila Eka Agustin','Nila','Indonesia','Semarang','Jl. Darmawangsa No. 28, Ngempon KlepuKarangjati - Semarang ','50552','024 - 6922055-6923054-7627202','024 - 6923052','nila_gratia@yahoo.co.id'),(198,18,'Office','Ibu. Susianty','Susi','Indonesia','Jakarta Barat','Jl. Green Ville Maisonette Blok FA No. 18 - 19Duri Kepa, Kebon Jeruk, Jakarta Barat','','021-5656253','021-5656638 - 5640917','purchasing-raw@guardian.co.id'),(199,18,'Factory','Bp. Purwanto','','Indonesia','Bogor','Jl. Pahlawan No. 25Desa Karang Asem - CiteureupBogor - Jawa Barat','','021-8756009 - 87902588','',''),(200,45,'Office & Factory','Ibu. Meliana','Meli','Indonesia','Tangerang','Business Park Tangerang City Blok E No. 6Jl. Jend. Sudirman - Babakan - TangerangTangerang - Banten','','021 - 29529253','021 - 29529283',''),(204,46,'Office & Factory','Bp. Frans','Frans','Indonesia','Jakarta Timur','Jl. Raya Bekasi Km. 25 - Ruko Inkopau Blok A No.8-9Ujung Menteng - Cakung - Jakarta Timur - DKI Jakarta Raya','','021 - 46802216','021 - 46802187','kairostrifa@gmail.com'),(205,57,'Office','Bp. Verdi Budidarmo','Verdi','Indonesia','Jakarta Pusat','Jl. Veteran No. 9','10110','021 - 3847709','',NULL),(206,57,'Factory','Bp. ','','Indonesia','Medan','Jl. Raya Medan - Tanjung Morawa KM.9Medan','20148','061 - 7867022','',NULL),(207,47,'Office & Factory','Ibu. Citri','Citri','Indonesia','Jakarta Timur','Ruko Graha Mas Pemuda Blok AC No. 15-16Jl. Pemuda Jati - Pulo Gadung - Jakarta Timur','','021 - 4701971','021 - 4701966',''),(209,49,'Office & Factory','Ibu. Natalie','Natalie','Indonesia','Bandung','Jl. Ciwastra Margasari, MargacintaBandung - Jawa Barat','','022 - 7562974-( 7564032-6201','022 - 7562973','pembelianlucasmarin@gmail.com'),(210,50,'Office & Factory','Ibu. Natalie','Natalie','Indonesia','Bandung','Jl. Terusan Kiaracondong No. 43 - MargasariMargacinta - Bandung - Jawa Barat','','022 - 7566201-965-7501052','022 - 7562973','pembelianlucasmarin@gmail.com'),(211,51,'Office & Factory','Ibu. Inge','Inge','Indonesia','Jakarta Barat','Jl. Palmerah Utara No. 14 A, PalmerahPalmerah, Jakarta Barat','','021 - 5483695-5482730','021 - 5301613',NULL),(213,20,'Office','Ibu. Susi Gozali','Susi','Indonesia','Jakarta Selatan','Wisma Tiara Building, 4th FloorJalan Raya Pasar Minggu Km 18 No. 17 - Jakarta','12510','021-7987683','021-7987684-86','susi_g@mersifarma.com'),(214,20,'Factory','Bp. Hendry','Hendry','Indonesia','Sukabumi','Jl. Raya Pelabuhan Km. 18, RT - RW -, CikembarCikembar - Kab. Sukabumi, Jawa Barat','','0266 - 321877','0266 - 321878',''),(215,52,'Office & Factory','Ibu. Tri Pratiwi','Tiwi','Indonesia','Jakarta Selatan','Jl. Raya Kebayoran Lama 557Jakarta Selatan','','021 - 7220076-7202351','021 - 7202379-80',NULL),(217,54,'Office & Factory','Bp. Reddy','Reddy','Indonesia','Medan','Jl. Besar Namo Rambe KM 8,5 RT- / RW-Deli Tua - Deli Serdang','20355','061 - 7031178 - 7031189','061 - 7030393',NULL),(218,27,'Office','Ibu. Ika','Ika','Indonesia','Jakarta Barat','Jl. Pos Pengumben Raya No. 8 , RT 005 RW 05 Kebon Jeruk,Jakarta Barat -  DKI Jakarta Raya','11560','021 - 5355888 / 53668600 / 8672448 - 49','021 - 8670351',NULL),(219,27,'Factory','Mr','','Indonesia','Bogor','Jl. Wanaherang No. 35, Tlajung Udik, Gunung PutriBogor','16962','','',NULL),(220,16,'Office & Factory','Ibu. Anik Sudaryanti','','Indonesia','Semarang','Jl. Raya Mangkang Kulon Km 16.5, Mangkang KulonKec Tugu - Semarang, Jawa Tengah','50155','024 - 8660006','024 - 8660960',NULL),(221,58,'Office','Bp.','','Indonesia','Jakarta Selatan','Gedung RNI Jl. Denpasar Raya Kav DIIIKuningan - Setiabudi','12950','021 - 5276263','021 - 5209381',NULL),(222,58,'Factory','Bp. Wahyudi','Wahyudi','Indonesia','Semarang','Jl. Simongan No.131','50148','024 - 7607330','024 - 7620743',NULL),(223,55,'Office & Factory','Ibu. Fiona Auliana','Fiona','Indonesia','Jakarta Selatan','Jl. Limo No. 40 RT 008/RW 010 -Grogol Selatan-Kebayoran LamaJakarta Selatan - DKI Jakarta Raya','','021 - 7200981','021 - 5324604',NULL),(224,63,'Office','Bp. Teddy Saputra','Teddy','Indonesia','Jakarta Pusat','Jl. Raden Saleh No.4 - Kenari - Senen ','10430','021 - 3903093','021 - 3903090 - 3147202',NULL),(225,63,'Factory','Bp. I Gusti Rai Adnyana','','Indonesia','Tangerang','Jl. Industri VI - Tangerang ','15135','021 - 5901876-77','',NULL),(226,64,'Office','Ibu. Lisa','Lisa','Indonesia','Jakarta Timur','Graha Agape Lt 2Jl. Haji Ten No. 20 Rawamangun','13220','021 -  4897468-4710846/47  ','',NULL),(227,64,'Factory','Bp.','','Indonesia','Sukabumi','Jl. Raya Siliwangi - ParungkudaSukabumi - Jawa Barat','','0266 - 535393 - 6','',NULL),(228,59,'Office','Bp.','','Indonesia','Jakarta Barat','Ruko Villa Kebon Jeruk Jl. Raya Kebon Jeruk Blok F3 - Kebon Jeruk','11530','021 - 53690112','021 - 532904',NULL),(229,59,'Factory','Bp.','','Indonesia','Jakarta Barat','Jl. Kemandoran VIII No. 16','12110','021 - 53690112','',NULL),(230,62,'Office & Factory','Bp.','','Indonesia','Gresik','Tenaru - Driyorejo - GresikJawa Timur','61177','031 - 7507406','031 - 7507069-7506600',NULL),(231,61,'Office','Bp. Sellih Sapitri','Sellih','Indonesia','Jakarta Barat','Wisma Barito Pacific Lt 7 Tower BJl. Letjend S.Parman Kav 62-63Slipi - Palmerah','11410','021 - 53669091','021 - 53669092',NULL),(232,61,'Factory','Bp. Rasgani','Gani','Indonesia','Bandung','Warehouse LaksanamekarJalan Raya Batujajar KM 1,5Padalarang - Bandung Barat','40553','022 - 6868261','022 - 6866470',NULL),(233,33,'Office','Ibu. Flora','Flora','Indonesia','Jakarta Utara','Komplek Ruko Mitra Bahari  Blok E No. 15/16Jl. Pakin No. 1 - Penjaringan Jakarta Utara','','021 - 6625955','021 - 6625956',''),(234,65,'Office','Ibu. Lily','Lily','Indonesia','Jakarta Pusat','Wisma Nugra Santana 5th FlJl. Jend. Sudirman Kav. 7 - 8, Karet Tengsin, Tanah Abang','','021 - 5702500','021 - 5707151-5700404',NULL),(235,65,'Factory','Bp.','','Indonesia','Tangerang','JL. Raya Serang Km 17 -  CikupaPO. Box. 2770/JKT 10001','15710','021 - 596 3255','',NULL),(236,31,'Office & Factory','Ibu. Linda','Linda','Indonesia','Surabaya','Jl. Rungkut Industri III No. 31Kalirungkut - Rungkut - Surabaya','','031 - 8438934-8495506-8493209','031 - 8438731',NULL),(237,30,'Office','Bp. Robert William','Robert','Indonesia','Surabaya','Jl. Sumatera No. 66 - Gubeng - GubengSurabaya - Jawa Timur','','031 - 5033476','031 - 5031145',NULL),(238,35,'Office & Factory','Ibu. ','','Indonesia','Jakarta Timur','Jl. Haji Miran No. 32 RT 001/RW 002Pondok Kopi - Duren SawitJakarta Timur - DKI Jakarta ','13460','021 - 7220076','021 - 7250889',NULL),(239,21,'Office','Bp. Heri','Heri','Indonesia','Jakarta Selatan','Gedung Tempo Scan Tower Lt. 16, Jl. HR Rasuna Said Kav. 3-4 - Jakarta Selatan','12950','021 - 8970801 / 02','021 - 8970764 / 940',''),(240,21,'Factory','Bp. Afrizal','Rizal','Indonesia','Cikarang','EJIP Industrial Park Plot 1 H Cikarang Selatan - Bekasi','17550','021 - 8975307','',''),(241,32,'Office & Factory','Mr','','Indonesia','Cianjur','Jl. Aria Wiratanudatar KM 8,Kp. Warung DanasRT/RW 003/001 Kademangan,Mande,Cianjur - Jawa Barat','43292','0263 - 317365','0263 - 2293388',NULL),(245,60,'Office','Ibu. Claresta Aileen Josephine','Claresta','Indonesia','Bandung','Jl. Taman Sari No. 10','40116','022 - 4207725','022 - 4206904','m.sourcing2@sanbe-farma.com'),(246,60,'Factory','Bp.','','Indonesia','Bandung','Jl. Industri No. 8 (Gudang 2)Cimareme','','022 - 6867965','',''),(247,29,'Office','Ibu. Shenny','Shenny','Indonesia','Jakarta Pusat','Jl. Raden Saleh Raya No.4Jakarta','10430','021 - 3147201 / 3100693','021 - 3146114',NULL),(248,29,'Factory','Bp. Fadlan','Fadlan','Indonesia','Cikande - Serang','Jl. Modern Industri IV Kav. 29, Kawasan Industri Modern Cikande - Serang','42186','0254 - 400888','',NULL),(249,8,'Office & Factory','Ibu. Made Nilam','Nilam','Indonesia','Jakarta Timur',' Jl. Pulo Kambing II No. 20, KIP Rawa Terate - Cakung','13930','021 - 4603543','021 - 4603667','made.nilam@mbf.co.id'),(257,7,'Office & Factory','Ibu. Titin Thomas','Titin','Indonesia','Jakarta Utara','Rukan Gold Coast Blok B No. 10-11, Bukit Golf Mediterania PIKRT 004 RW 003, Kamal Muara, Penjaringan - Jakarta Utara','','021-29032737 - 3030','021-29032736','titin.thomas@futamed.co.id'),(258,28,'Office & Factory','Ibu. Maya Wijaya','Maya','Indonesia','Jakarta Timur','Jl. Raya Pulogadung No. 29 RT- /RW- JatinegaraCakung - Jakarta Timur - DKI Jakarta','13920','021-4600086','021-46827785','maya.wijaya@ikapharmindo.com'),(259,48,'Office & Factory','Bp. Kompri','Kompri','Indonesia','Jakarta Timur','Menteng Niaga Blok I 1 No. 20-21 RT 009 / RW 007Ujung Menteng - Cakung - Jakarta Timur - DKI Jakarta Raya','','021 - 4604760','021 - 4605454-4604770',''),(264,34,'Office & Factory','Ibu. ','','Indonesia','Jakarta Timur','Jl. Jend. A.Yani No. 7 RT 011/RW 006Pisangan Timur - Pulo Gadung - Jakarta Timur','13230','021 - 4890208','021 - 4701520-4891839',NULL),(265,13,'Office','Ibu. Merry Gunawan','Merry','Indonesia','Jakarta Pusat','Jl. Mampang Prapatan Raya No. 81 - Jakarta','12790','021 - 79192000','021 - 79196000','merry.gunawan@interbat.co.id'),(266,13,'Office','Ibu. Inawati Iskandar','Ina','Indonesia','Jakarta Pusat','Jl. Mampang Pra','12790','021 - 79192000','021 - 79196000',' inawati.iskandar@interbat.co.id'),(273,56,'Office','Ibu. Fela Satari','Fela','Indonesia','Bandung','Baranang Siangte Blok FA18-19Komplek ITC Kosambi Blk G-27Kebon Pisang - Sumur Bandung','40112','022 - 4222208','022 - 4262138','fela.satari@yahoo.com'),(274,56,'Office','Ibu. Desita Nurfaidah','Desita','Indonesia','Bandung','Baranang Siangte Blok FA18-19Komplek ITC Kosambi Blk G-27Kebon Pisang - Sumur Bandung','40112','022 - 4222208','022 - 4262138',' dnurfaidah@gmail.com'),(281,9,'Office','Ibu. Patricia Kurniawan','Patricia','Indonesia','Jakarta Barat','Aries Niaga Blok A1/2EJalan Taman Aries, Kebon Jeruk','11620','021 - 58906944 - 70615191','',''),(282,9,'Office','Ibu. Winarni Sri','Wiwin','Indonesia','Jakarta Barat','Aries Niaga Blo','11620','021 - 58906944 - 70615191','',''),(296,53,'Office & Factory','Ibu. Leni Mulianingsih','Leni','Indonesia','Jakarta Pusat','JL.IR.H.Juanda NO.5C - Kebon KelapaGambir - Jakarta Pusat','','021 - 3814521-3520472    ','021 - 3515107',NULL),(301,10,'Office','Bp. Miller','Miller','Indonesia','Jakarta Barat','Mutiara Taman Palem D8 No. 65, Jakarta','11730','021 - 54350781','021 - 54350784',NULL),(302,10,'Factory','Bp. Miller','Miller','Indonesia','Jakarta Barat','Jl. Prepedan Dalam No. 18, Kamal - Kalideres','','021 - 5550456','',NULL),(305,17,'Office & Factory','Ibu. Clarissa Lizda Febriana','Clarissa','Indonesia','Bandung','Jl. Soekarno Hatta No. 789, Cisaranten Wetan, Ujung Berung - Bandung','40294','022-7805588','022-7805577','purchasing@meprofarm.com'),(307,23,'Office & Factory','Ibu. Elisabeth','Lisa','Indonesia','Jakarta Utara','Jl. Dewi Shinta Blok B-2 No. 1, Kelapa Gading Timur - Kelapa Gading','14240','021-4524969-45842050','021-4505075',''),(308,24,'Office & Factory','Bp. Arifin Gouw','Arifin','Indonesia','Jakarta Utara','Jl. Raya Kelapa Hybrida, Grand Orchad Square Blok GOS No. D16, RT 004/RW 011 - Sukapura - Cilincing','','021-29616463','021-22860690','arifin.gouw@ptbsn.com'),(309,25,'Office','Ibu. Oom Romlah','Oom','Indonesia','Bandung','Jl. Purnawarman No. 47 - Taman Sari - Bandung Wetan - Bandung - Jawa Barat','40116','022-4207725','022-4222914',''),(310,25,'Factory 1','Bp. Galih Saputra','Galih','Indonesia','Bandung','Jl. Leuwigajah 174 - Cimahi','','022-6613311','',''),(311,25,'Factory 2','Bp. Galih Saputra','Galih','Indonesia','Bandung','Jl. Industri I No. 8-Cimareme','','022-6867965','',''),(312,26,'Office & Factory','Ibu. Alvie','Alvie','Indonesia','Semarang','Jl. Tambak Aji V, No. 4RT 001/RW012 - Tambak Aji - Ngaliyan - Semarang - Jawa Tengah','50185','024 - 8662825 / 26','024 - 8662824','alvie.bufa@gmail.com'),(313,37,'Office & Factory','Bp. Uus Sriyanto','Uus','Indonesia','Bandung','Jl. Cisurung Palasari (Jl. Moch. Toha km 6,7) Dayeuhkolot Kab. Bandung Jawa Barat','40256','022 - 5208222','022 - 5203997','cendobdg@yahoo.com'),(314,38,'Office & Factory','Ibu. Yusnita','Yusnita','Indonesia','Tangerang','Jl. Gatot Subroto KM 7,5 RT 003/01Kel.Manis Jaya Kec.Jatiuwung, Tangerang','','021 - 5918515 - 17','021 - 5914282','ysnt_77@yahoo.com'),(315,39,'Office & Factory','Bp. Imam','Imam','Indonesia','Jakarta Timur','Puri Sentra Niaga Blok B No. 25, RT 012 RW 07, MakasarJakarta Timur, DKI Jakarta Raya','13620','021 - 8500489 / 86607760 / 86607762','021 - 29537000','purchasing@dianciptaperkasa.co.id'),(316,40,'Office & Factory','Ibu. Caroline','Caroline','Indonesia','Jakarta Selatan',' Jl. Kebayoran Lama No. 28  RT.009/ RW.011Kebayoran Lama - Jakarta Selatan','','021 - 53653883-3440725','021 - 53679080-3809110','caroline@dipa.co.id'),(317,22,'Office','Ibu. Maria Monica','Monica','Indonesia','Semarang','Jl. Erlangga Raya No. 9-11-14-26RT. 09/ RW. 04 - Pleburan - Semarang Selatan - Semarang - Jawa Tengah','50241','024 - 8310650','024 - 8313998','elisabethmonica80@gmail.com'),(318,22,'Office','Bp. Aries Kristanto','Aries','Indonesia','Semarang','Jl. Erlangga Raya No. 9-11-14-26RT. 09/ RW. 04 - Pleburan - Semarang Selatan - Semarang - Jawa Tengah','50241','024 - 8310650','024 - 8313998',' aries.kristanto@hotmail.com'),(319,22,'Factory','Bp. Fang','Fang','Indonesia','Semarang','Jl. Murbei 2 - Semarang','','024 - 8310650','',''),(320,36,'Office & Factory','Ibu. Maria Monica','Monica','Indonesia','Semarang','Jl. Dr. Setiabudi No. 130 RT.05 RW.02 Sumurboto - Banyumanik Semarang - Jawa Tengah','50269','024 - 7472323','024 - 7462911','elisabethmonica80@gmail.com'),(321,41,'Office & Factory','Ibu. Leni Mulianingsih','Leni','Indonesia','Bandung','Jl. Peundeuy RT/RW 04/07, Desa BojongsalamRancaekek - Bandung - Jawa Barat','','022 - 7949062','022 - 7949063','leni_m@errita.co.id'),(322,42,'Office & Factory','Ibu. Dany Christiani','Dany','Indonesia','Jakarta Barat','Jl. Pos Pengumben Raya No. 8, Kebon Jeruk - Jakarta Barat','11560','021 - 29324045 / 53668600','021 - 29430914 / 53675258','Dany.Christiani@plant.eterconpharma.com'),(323,9,'Factory','Bp.','','Indonesia','Sukabumi','Jl. Cemerlang RT. 004 RW. 001Sukakarya - Warudoyong','','','',''),(324,13,'Office','Ibu. Anjelica Darmadi','Anjel','Indonesia','Jakarta Pusat','Jl. Mampang Pra','12790','021 - 79192000','021 - 79196000','anjelica.darmadi@interbat.co.id'),(325,30,'Office','Ibu. Endah','Endah','Indonesia','Surabaya','Jl. Sumatera No. 66 - Gubeng - GubengSurabaya - Jawa Timur','','031 - 5033476','031 - 5031145',NULL),(326,16,'Office & Factory','Ibu. Wiwik','','Indonesia','Semarang','Jl. Raya Mangkang Kulon Km 16.5, Mangkang KulonKec Tugu - Semarang, Jawa Tengah','50155','024 - 8660006','024 - 8660960',NULL),(327,22,'Office','Ibu. Carolina Novianti','Vivi','Indonesia','Semarang','Jl. Erlangga Raya No. 9-11-14-26RT. 09/ RW. 04 - Pleburan - Semarang Selatan - Semarang - Jawa Tengah','50241','024 - 8310650','024 - 8313998','vivierela@gmail.com'),(328,23,'Office','Ibu. Meta Vega','Meta','Indonesia','Jakarta Utara','Jl. Dewi Shinta Blok B-2 No. 1, Kelapa Gading Timur - Kelapa Gading','14240','021-4524969-45842050','021-4505075','mita.vega@anindojaya-id.com'),(329,25,'Office','Ibu. Riska Fatmawati','Riska','Indonesia','Bandung','Jl. Purnawarman No. 47 - Taman Sari - Bandung Wetan - Bandung - Jawa Barat','40116','022-4207725','022-4222914','rm_finance3@binasanprima.com'),(330,26,'Office & Factory','Bp. ','','Indonesia','Semarang','Jl. Tambak Aji V, No. 4RT 001/RW012 - Tambak Aji - Ngaliyan - Semarang - Jawa Tengah','50185','024 - 8662825 / 26','024 - 8662824','factory@bufa-aneka.com'),(331,39,'Office','Ibu. Riki','Riki','Indonesia','Jakarta Timur','Puri Sentra Niaga Blok B No. 25, RT 012 RW 07, MakasarJakarta Timur, DKI Jakarta Raya','13620','021 - 8500489 / 86607760 / 86607762','021 - 29537000','finance-dcp@dianciptaperkasa.co.id'),(332,40,'Office','Bp. Abdul Gafur','Abdul','Indonesia','Jakarta Selatan',' Jl. Kebayoran Lama No. 28  RT.009/ RW.011Kebayoran Lama - Jakarta Selatan','','021 - 53653883-3440725','021 - 53679080-3809110','abdul.gafur@dipa.co.id'),(333,42,'Office','Ibu. Eva Wulandari','Eva','Indonesia','Jakarta Barat','Jl. Pos Pengumben Raya No. 8, Kebon Jeruk - Jakarta Barat','11560','021 - 29324045 / 53668600','021 - 29430914 / 53675258','Eva.Wulandari@eterconpharma.com'),(334,7,'Office','Ibu. Erni','Erni','Indonesia','Jakarta Utara','Rukan Gold Coast Blok B No. 10-11, Bukit Golf Mediterania PIKRT 004 RW 003, Kamal Muara, Penjaringan - Jakarta Utara','','021-29032737 - 3030','021-29032736','erny@futamed.co.id'),(335,43,'Factory','Bp. Aryana','Aryana','Indonesia','Cikarang','Jl. Industri Selatan Blok HH No. 2-3Kawasan Industri CikarangJababeka - Bekasi','17750','021 - 89841338 ','021 - 89841337',''),(336,45,'Office','Ibu. Linda','Linda','Indonesia','Tangerang','Business Park Tangerang City Blok E No. 6Jl. Jend. Sudirman - Babakan - TangerangTangerang - Banten','','021 - 29529253','021 - 29529283','linda.telew@hensancorp.com'),(337,28,'Office','Ibu. Susi Anggraeni','Susi','Indonesia','Jakarta Timur','Jl. Raya Pulogadung No. 29 RT- /RW- JatinegaraCakung - Jakarta Timur - DKI Jakarta','13920','021-4600086','021-46827785',''),(338,28,'Office','Ibu. Glory Fibriyana','Glory','Indonesia','Jakarta Timur','Jl. Raya Pulogadung No. 29 RT- /RW- JatinegaraCakung - Jakarta Timur - DKI Jakarta','13920','021-4600086','021-46827785','glory.fibriyana@ikapharmindo.com'),(339,13,'Factory','Bp. Roni','Roni','Indonesia','Sidoarjo','Jl. H.R Moch. Mangundiprojo No. 1 - Sidoarjo','61252','031 - 8914201 - 0551','031 - 8914015',''),(340,47,'Office','Ibu. Rina','Rina','Indonesia','Jakarta Timur','Ruko Graha Mas Pemuda Blok AC No. 15-16Jl. Pemuda Jati - Pulo Gadung - Jakarta Timur','','021 - 4701971','021 - 4701966','kls@cbn.net.id'),(341,48,'Office','Ibu. Mulyati','Mulyati','Indonesia','Jakarta Timur','Menteng Niaga Blok I 1 No. 20-21 RT 009 / RW 007Ujung Menteng - Cakung - Jakarta Timur - DKI Jakarta Raya','','021 - 4604760','021 - 4605454-4604770','librautf@gmail.com'),(342,49,'Office','Bp. Cecep','Cecep','Indonesia','Bandung','Jl. Ciwastra Margasari, MargacintaBandung - Jawa Barat','','022 - 7562974-( 7564032-6201','022 - 7562973','finance_ap@lucasjaya.com'),(343,17,'Office','Bp. Harby','Harby','Indonesia','Bandung','Jl. Soekarno Hatta No. 789, Cisaranten Wetan, Ujung Berung - Bandung','40294','022-7805588','022-7805577','accounting@meprofarm.com'),(344,20,'Office','Bp. Satrio Ponco Hutomo','Satrio','Indonesia','Jakarta Selatan','Wisma Tiara Building, 4th FloorJalan Raya Pasar Minggu Km 18 No. 17 - Jakarta','12510','021-7987683','021-7987684-86','Satrio_Hutomo@mersifarma.com'),(345,8,'Office','Ibu. Tince Soumury','Tince','Indonesia','Jakarta Timur','Jl. Pulo Kambing II No. 20, KIP Rawa Terate - Cakung','13930','021 - 4603543','021 - 4603667','tince.soumury@mbf.co.id'),(346,21,'Office','Ibu. Wijiati','Wiji','Indonesia','Jakarta Selatan','Gedung Tempo Scan Tower Lt. 16, Jl. HR Rasuna Said Kav. 3-4 - Jakarta Selatan','12950','021 - 8970801 / 02','021 - 8970764 / 940','wijiati.tsp@thetempogroup.com'),(347,25,'Office','Ibu. Puji Purnama, Amd','Puji','Indonesia','Bandung','Jl. Purnawarman No. 47 - Taman Sari - Bandung Wetan - Bandung - Jawa Barat','40116','022-4207725','022-4222914','rmp1.admin@sanbe-farma.com'),(348,26,'Office','Ibu. Eny Sumarno','Eny','Indonesia','Semarang','Jl. Tambak Aji V, No. 4RT 001/RW012 - Tambak Aji - Ngaliyan - Semarang - Jawa Tengah','50185','024 - 8662825 / 26','024 - 8662824','christina.enys@zenith-pharma.com'),(349,56,'Office','Ibu. Ratna Sudjaja','Ratna','Indonesia','Bandung','Baranang Siangte Blok FA18-19Komplek ITC Kosambi Blk G-27Kebon Pisang - Sumur Bandung','40112','022 - 4222208','022 - 4262138',''),(350,56,'Factory','Bp. Rudi','','Indonesia','Bandung','Kawasan Industri Dwipapuri Blok M-30Jl. Raya Rancaekek KM 24,5','45364','022 - 7780031','',''),(351,66,'Office','Bp. Anto','Anto','Indonesia','Tangerang','Kawasan Industri Mekar JayaJalan Gas No. 8 Sepatan','15520','','',''),(352,33,'Factory','Bp.','','Indonesia','Sukabumi','Jl. Pelabuhan II KM.9 Pasir Malang,Desa Kebon Manggu, Kec Gunung Guruh','43141','','',''),(353,36,'Office & Factory','Ibu. Nisia','Nisia','Indonesia','Semarang','Jl. Dr. Setiabudi No. 130 RT.05 RW.02 Sumurboto - Banyumanik Semarang - Jawa Tengah','50269','024 - 7472323','024 - 7462911','rnd_erpha@yahoo.co.id');
/*!40000 ALTER TABLE `ms_customerdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_documenttype`
--

DROP TABLE IF EXISTS `ms_documenttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_documenttype` (
  `documentTypeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Document Type ID',
  `lkDocumentTypeID` smallint(6) NOT NULL,
  `documentTypeName` varchar(50) NOT NULL COMMENT 'Document Type Name',
  `reportDestination` varchar(100) DEFAULT NULL,
  `flagMandatory` bit(1) NOT NULL COMMENT 'Flag Mandatory',
  `ordinal` tinyint(4) DEFAULT NULL COMMENT 'Ordinal',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`documentTypeID`),
  KEY `fk_documenttypeid_idx` (`lkDocumentTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_documenttype`
--

LOCK TABLES `ms_documenttype` WRITE;
/*!40000 ALTER TABLE `ms_documenttype` DISABLE KEYS */;
INSERT INTO `ms_documenttype` VALUES (1,1,'BPOM 2',NULL,'',1,'','admin','2016-10-27 14:34:27','admin','2016-11-11 16:17:07'),(2,3,'BPOM',NULL,'',1,'','admin','2016-11-09 13:51:54','admin','2016-11-09 13:53:00'),(3,2,'BPOM 1',NULL,'',3,'','admin','2016-11-09 13:56:33','admin','2016-11-11 16:16:59'),(7,2,'Dokumen 2',NULL,'\0',2,'','admin','2017-02-03 15:15:46','admin','2017-02-03 15:15:46'),(8,3,'bbbb','','',2,'','admin','2017-02-21 17:18:34','admin','2017-03-07 15:05:10'),(9,3,'Dokumen Ekstra','1,2','\0',3,'','admin','2017-04-18 14:13:21','admin','2017-04-18 14:13:21'),(10,3,'GMP','1','',1,'','admin','2017-08-10 10:51:27','admin','2017-08-10 10:51:27'),(11,1,'GMP','1','',1,'','admin','2017-08-10 15:07:28','admin','2017-08-10 15:07:28'),(12,1,'MSDS','1','',1,'','admin','2017-08-10 15:08:54','admin','2017-08-10 15:08:54');
/*!40000 ALTER TABLE `ms_documenttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_hscode`
--

DROP TABLE IF EXISTS `ms_hscode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_hscode` (
  `hsCodeID` int(11) NOT NULL AUTO_INCREMENT,
  `hsCode` varchar(20) NOT NULL,
  `taxPercentage` decimal(18,2) DEFAULT NULL,
  `flagActive` bit(1) NOT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`hsCodeID`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_hscode`
--

LOCK TABLES `ms_hscode` WRITE;
/*!40000 ALTER TABLE `ms_hscode` DISABLE KEYS */;
INSERT INTO `ms_hscode` VALUES (1,'123456789',5.00,'\0','admin','2017-02-20 14:35:56','nurdin','2018-01-12 09:44:53'),(2,'HS12345',5.00,'\0','admin','2017-04-18 14:47:13','admin','2017-04-18 14:47:13'),(3,'29398000',5.00,'','admin','2017-08-10 11:01:33','yudi','2018-01-24 16:45:10'),(4,'29162000',5.00,'','admin','2017-08-10 11:02:23','yudi','2018-01-25 10:44:53'),(5,'29224900 ',5.00,'','admin','2017-08-10 11:04:15','yudi','2018-01-24 16:29:51'),(6,'29394200 ',0.00,'','admin','2017-08-10 11:04:48','yudi','2018-01-24 16:44:20'),(7,'2921.45.00 ',45.00,'\0','admin','2017-08-10 11:05:20','admin','2017-08-10 11:05:20'),(8,'29400000 ',5.00,'','admin','2017-08-10 11:05:44','yudi','2018-01-24 16:45:35'),(9,'29225090',5.00,'\0','admin','2017-08-10 11:05:45','admin','2017-08-10 11:05:45'),(10,'29381000',0.00,'','admin','2017-08-11 14:03:46','yudi','2018-01-24 16:44:00'),(11,'29419000 ',5.00,'','admin','2017-08-11 14:04:31','yudi','2018-01-24 16:46:34'),(12,'29372200',0.00,'','admin','2017-08-11 14:06:33','yudi','2018-01-24 16:41:11'),(13,'29335990',5.00,'','admin','2017-08-11 14:07:39','yudi','2018-01-24 16:32:54'),(14,'29339100',0.00,'','admin','2017-08-11 15:27:35','yudi','2018-01-24 16:33:35'),(15,'28369100',5.00,'','admin','2017-08-11 15:28:13','nurdin','2018-01-12 09:43:08'),(16,'2836.91.00.',2.00,'\0','admin','2017-08-11 15:29:28','qwinjayasupport','2018-01-12 10:06:20'),(17,'2916.20.00',5.00,'\0','admin','2017-08-11 15:29:55','admin','2017-08-11 15:29:55'),(18,'29162000',5.00,'','admin','2017-08-11 15:30:48','admin','2017-12-22 14:33:34'),(19,'29398000',5.00,'','admin','2017-08-11 15:31:17','yudi','2018-01-24 16:45:21'),(20,'29221990',5.00,'','admin','2017-08-11 15:31:40','admin','2017-12-22 14:40:55'),(21,'29372200',0.00,'','admin','2017-08-11 15:32:04','yudi','2018-01-24 16:41:24'),(22,'29214500',5.00,'\0','admin','2017-08-14 15:12:04','admin','2017-08-14 15:12:04'),(23,'29214500',5.00,'','admin','2017-08-15 14:50:48','yudi','2018-01-24 16:28:44'),(24,'2933.99.9000',0.00,'\0','admin','2017-08-15 14:59:31','admin','2017-08-15 14:59:31'),(25,'29339100',0.00,'','admin','2017-08-15 15:06:47','yudi','2018-01-24 16:36:20'),(26,'29394100',0.00,'','admin','2017-08-15 16:23:40','yudi','2018-01-24 16:44:11'),(27,'29335990',5.00,'','admin','2017-08-15 16:42:07','yudi','2018-01-24 16:32:32'),(28,'29072200',0.00,'','admin','2017-08-16 14:03:26','admin','2017-08-16 14:03:26'),(29,'29146200',5.00,'','admin','2017-08-23 11:05:25','admin','2017-12-22 14:32:47'),(30,'29362600',0.00,'\0','admin','2017-08-30 08:38:53','admin','2017-08-30 08:38:53'),(31,'29333990',0.00,'','admin','2017-09-07 09:06:07','yudi','2018-01-24 16:32:10'),(32,'29304000',0.00,'\0','admin','2017-09-19 13:14:55','admin','2017-09-19 13:14:55'),(33,'29224900',5.00,'\0','admin','2017-09-19 14:12:52','admin','2017-09-19 14:12:52'),(34,'29321900',5.00,'','admin','2017-09-28 11:33:02','yudi','2018-01-24 16:31:56'),(35,'29225090',5.00,'','admin','2017-09-28 11:36:35','yudi','2018-01-24 16:30:05'),(36,'29362600',0.00,'','admin','2017-09-28 11:46:51','yudi','2018-01-24 16:40:30'),(37,'2918.16.00',5.00,'\0','admin','2017-09-28 12:02:09','admin','2017-09-28 12:02:09'),(38,'29349990',5.00,'','admin','2017-09-28 13:58:11','yudi','2018-01-24 16:37:41'),(39,'29335990',5.00,'','admin','2017-09-28 14:15:58','yudi','2018-01-24 16:33:52'),(40,'29372300',0.00,'','admin','2017-09-28 14:42:14','yudi','2018-01-24 16:41:55'),(41,'29372300',0.00,'','admin','2017-09-28 14:48:20','yudi','2018-01-24 16:42:12'),(42,'29372900',5.00,'','admin','2017-10-03 09:24:31','yudi','2018-01-24 16:42:36'),(43,'29341000',5.00,'','admin','2017-10-03 15:05:29','yudi','2018-01-24 16:36:32'),(44,'29372900',5.00,'','admin','2017-10-05 10:41:05','yudi','2018-01-24 16:42:50'),(45,'29389000',0.00,'\0','admin','2017-10-13 10:06:34','admin','2017-10-13 10:06:34'),(46,'----------',0.00,'\0','admin','2017-10-17 14:22:30','admin','2017-10-17 14:22:30'),(47,'29372100',0.00,'','admin','2017-10-18 09:41:43','yudi','2018-01-24 16:40:57'),(48,'29214900',5.00,'','admin','2017-10-18 09:53:45','admin','2017-12-22 14:39:49'),(49,'29339990',5.00,'','admin','2017-10-18 10:10:04','yudi','2018-01-24 16:35:27'),(50,'29351000',0.00,'','admin','2017-10-18 10:25:42','yudi','2018-01-24 16:40:01'),(51,'29231000',0.00,'','admin','2017-10-18 10:40:42','yudi','2018-01-24 16:30:22'),(52,'29304000',0.00,'','admin','2017-10-18 10:47:06','yudi','2018-01-24 16:30:53'),(53,'29395900',5.00,'','admin','2017-10-18 11:02:24','yudi','2018-01-24 16:44:33'),(54,'29413000',5.00,'','admin','2017-10-18 11:23:38','yudi','2018-01-24 16:46:05'),(55,'13021930',5.00,'','admin','2017-10-18 13:35:15','qwinjayasupport','2018-01-12 13:49:59'),(56,'29362300',0.00,'','admin','2017-10-18 13:39:14','yudi','2018-01-24 16:40:13'),(57,'30039000',5.00,'','admin','2017-10-18 13:49:19','yudi','2018-01-24 16:46:46'),(58,'29242990',5.00,'','admin','2017-10-18 16:50:46','yudi','2018-01-24 16:30:32'),(59,'29371900',5.00,'','admin','2017-10-19 11:14:03','yudi','2018-01-24 16:40:45'),(60,'29397900',0.00,'','admin','2017-10-19 11:21:38','yudi','2018-01-24 16:44:43'),(61,'29309010',5.00,'','admin','2017-10-19 13:35:12','yudi','2018-01-24 16:31:11'),(62,'29415000',5.00,'','admin','2017-10-19 13:39:47','yudi','2018-01-24 16:46:20'),(63,'2907.22.00',5.00,'\0','admin','2017-10-19 14:01:50','admin','2017-10-19 14:01:50'),(64,'29303000',5.00,'','admin','2017-10-19 14:13:34','yudi','2018-01-24 16:30:43'),(65,'13021990',5.00,'','admin','2017-10-19 14:46:51','admin','2017-12-22 14:27:44'),(66,'35079000',0.00,'','admin','2017-10-19 14:58:36','yudi','2018-01-24 16:46:58'),(67,'29419000',0.00,'\0','admin','2017-10-20 10:38:24','admin','2017-10-20 10:38:24'),(68,'29309090',5.00,'','admin','2017-10-31 15:45:56','yudi','2018-01-24 16:31:21'),(69,'29343000',0.00,'','admin','2017-11-08 11:04:22','yudi','2018-03-23 15:38:40'),(70,'29181600            ',5.00,'','admin','2017-11-17 15:50:26','admin','2017-11-17 15:50:26'),(71,'293359.90',5.00,'\0','admin','2017-11-24 08:31:05','admin','2017-11-24 08:31:05'),(72,'29339990',5.00,'\0','admin','2017-11-27 15:48:32','admin','2017-11-27 15:48:32'),(73,'29189900',5.00,'','yudhi','2018-01-05 15:55:45','yudhi','2018-01-05 15:55:45'),(74,'29381000',0.00,'','yudhi','2018-01-09 11:22:20','yudhi','2018-01-09 11:22:20'),(75,'29183000',0.00,'','yudhi','2018-01-11 16:33:46','yudi','2018-03-21 14:22:56'),(76,'29392090',0.00,'','yudi','2018-01-24 14:40:16','yudi','2018-01-24 14:40:16'),(77,'29349990',5.00,'','yudi','2018-01-24 14:48:09','yudi','2018-01-24 14:48:09'),(78,'3939311',5.00,'\0','qwinjayasupport','2018-01-24 16:08:22','qwinjayasupport','2018-01-24 16:08:31'),(79,'29362900',0.00,'','yudi','2018-01-26 15:58:50','yudi','2018-01-26 15:58:50'),(80,'29359000',0.00,'','akhiong','2018-02-07 09:26:58','akhiong','2018-02-07 09:26:58'),(81,'39139090',5.00,'','yudi','2018-02-12 08:17:17','yudi','2018-02-12 08:17:17'),(82,'28369990',5.00,'','yudi','2018-02-22 14:29:23','yudi','2018-02-22 14:29:23'),(83,'21069099',10.00,'','yudi','2018-03-05 08:03:30','yudi','2018-03-05 08:03:30'),(84,'29411090',5.00,'','yudi','2018-03-09 11:18:07','yudi','2018-03-09 11:18:07'),(85,'29232010',0.00,'','yudi','2018-03-19 15:13:17','yudi','2018-03-19 15:13:17'),(86,'29181900',5.00,'','yudi','2018-03-22 10:32:23','yudi','2018-03-22 10:32:23'),(87,'29339900',0.00,'','yudi','2018-03-28 07:49:38','yudi','2018-03-28 07:49:38'),(88,'0',0.00,'','yudi','2018-03-29 15:18:06','yudi','2018-03-29 15:18:06'),(89,'29280090',5.00,'','yudi','2018-04-03 10:12:04','yudi','2018-04-03 10:12:04');
/*!40000 ALTER TABLE `ms_hscode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_marketing`
--

DROP TABLE IF EXISTS `ms_marketing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_marketing` (
  `marketingID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Marketing ID',
  `marketingName` varchar(200) NOT NULL COMMENT 'Marketing Name',
  `phone1` varchar(20) DEFAULT NULL COMMENT 'Phone 1',
  `phone2` varchar(20) DEFAULT NULL COMMENT 'Phone 2',
  `email` varchar(50) DEFAULT NULL COMMENT 'Email',
  `notes` varchar(200) DEFAULT NULL COMMENT 'Notes',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`marketingID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_marketing`
--

LOCK TABLES `ms_marketing` WRITE;
/*!40000 ALTER TABLE `ms_marketing` DISABLE KEYS */;
INSERT INTO `ms_marketing` VALUES (1,'WF.KHIONG','021- 580 2720','','commercial@qwinjaya.com','','','admin','2017-09-19 15:19:48','admin','2017-09-19 15:19:48'),(2,'Nurdin Wijaya','0816 7249 05','','nurdin.wijaya@qwinjaya.com','','','admin','2017-09-19 15:20:34','admin','2017-09-19 15:20:34'),(3,'Yunita Indrasari','081-58480 2218','','','','','admin','2017-10-11 08:15:09','admin','2017-10-11 08:15:09');
/*!40000 ALTER TABLE `ms_marketing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_packingtype`
--

DROP TABLE IF EXISTS `ms_packingtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_packingtype` (
  `packingTypeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Packing Type ID',
  `packingTypeName` varchar(50) NOT NULL COMMENT 'Packing Type Name',
  `notes` varchar(100) DEFAULT NULL COMMENT 'Notes',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`packingTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_packingtype`
--

LOCK TABLES `ms_packingtype` WRITE;
/*!40000 ALTER TABLE `ms_packingtype` DISABLE KEYS */;
INSERT INTO `ms_packingtype` VALUES (1,'Drum','','','admin','2016-11-08 11:52:00','admin','2016-11-08 11:52:00'),(2,'LUSIN','','','admin','2016-11-08 11:53:20','admin','2017-03-08 14:37:40'),(3,'Pack','','','admin','2016-11-09 14:19:16','admin','2016-11-10 14:06:04'),(4,'Karung','','','admin','2016-11-14 10:06:12','admin','2016-11-14 10:06:12'),(5,'LUSIN','\' TIDAK ADA \'','\0','admin','2017-03-07 15:33:57','admin','2017-03-07 15:33:57'),(6,'Drum HDPE','','','admin','2017-08-10 10:44:23','admin','2017-08-10 10:44:23'),(7,'Drum VAT','','','admin','2017-08-10 10:44:36','admin','2017-08-10 10:44:36'),(8,'Tin','','','admin','2017-08-10 10:44:46','admin','2017-08-10 10:44:46'),(9,'Pot','','','admin','2017-08-14 15:16:07','yudhi','2018-01-24 10:45:37'),(10,'Fibre Drum','','','admin','2017-08-15 16:33:19','admin','2017-08-15 16:33:19'),(11,'Carton','','','admin','2017-08-15 16:38:23','admin','2017-08-15 16:39:19'),(12,'Carton','','','admin','2017-08-15 16:39:55','admin','2017-08-15 16:39:55'),(13,'Standard Export','','','admin','2017-08-23 11:17:36','admin','2017-08-23 11:17:36'),(14,'Aluminium Tin','','','admin','2017-09-28 14:50:33','admin','2017-09-28 14:50:33'),(15,'Aluminium Bag','','','admin','2017-09-28 16:40:04','admin','2017-09-28 16:40:04'),(16,'@ 250mg/Ampoule','','','admin','2017-10-03 10:12:10','admin','2017-10-03 10:12:10'),(17,'Zak','-','','admin','2017-10-20 10:55:49','admin','2017-10-20 10:55:49'),(18,'Bottle','','','admin','2017-12-21 10:27:44','admin','2017-12-21 10:27:44'),(19,'Vial','','','admin','2017-12-21 10:45:15','admin','2017-12-21 10:45:15'),(20,'Aluminium Baq / Fibre Drum','','','yudhi','2018-01-03 10:27:05','yudhi','2018-01-03 10:27:05'),(21,'Pail','','','yudhi','2018-01-16 15:53:24','yudhi','2018-01-16 15:53:24');
/*!40000 ALTER TABLE `ms_packingtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_paymentdue`
--

DROP TABLE IF EXISTS `ms_paymentdue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_paymentdue` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `paymentDue` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_paymentdue`
--

LOCK TABLES `ms_paymentdue` WRITE;
/*!40000 ALTER TABLE `ms_paymentdue` DISABLE KEYS */;
INSERT INTO `ms_paymentdue` VALUES (1,'T/T 60 days in advance'),(2,'T/T 30 Days AWB'),(3,'T/T Upon Faxed Documents'),(4,'T/T in advance'),(5,'15 Day from AWB'),(6,'T/T 60 Days AWB'),(7,'T/T  120 days AWB'),(8,'T/T 90 Days AWB'),(9,'Free Of Charge'),(10,'T/T 60 Days B/L'),(11,'T/T 180 days AWB'),(12,'T/T in advance (We will transfer the payment ');
/*!40000 ALTER TABLE `ms_paymentdue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_product`
--

DROP TABLE IF EXISTS `ms_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_product` (
  `productID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Product ID',
  `productCategoryID` int(11) NOT NULL COMMENT 'Product Category ID',
  `productSubcategoryID` int(11) DEFAULT NULL,
  `productName` varchar(100) NOT NULL COMMENT 'Product Name',
  `supplierID` int(11) NOT NULL,
  `origin` varchar(50) DEFAULT NULL,
  `flagOOT` bit(1) DEFAULT NULL,
  `hsCode` varchar(20) DEFAULT NULL,
  `minQty` decimal(18,2) DEFAULT NULL COMMENT 'Minimal Quantity',
  `notes` text COMMENT 'Notes',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`productID`),
  KEY `productCategoryID` (`productCategoryID`),
  KEY `ms_product_supplierid_idx` (`supplierID`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_product`
--

LOCK TABLES `ms_product` WRITE;
/*!40000 ALTER TABLE `ms_product` DISABLE KEYS */;
INSERT INTO `ms_product` VALUES (1,3,1,'Acefyline Piperazine',1,'Kores India Limited','\0','',0.00,'','\0','admin','2017-08-10 10:15:47','admin','2017-08-10 10:15:47'),(4,3,5,'Ephedrine',4,'Embio','','123456789',0.00,'','\0','admin','2017-08-10 10:49:43','admin','2017-08-10 10:53:59'),(5,1,5,'Pseudoephedrine Hcl',70,'ex. Embio  Limited / INDIA','\0','2939.42.00 ',1.00,'','','admin','2017-08-10 11:01:52','yudhi','2018-01-02 16:43:11'),(6,4,NULL,'Biaya lain-lain',7,'CENGKARENG','\0','123456789',NULL,'','\0','admin','2017-08-10 14:41:53','admin','2017-08-10 14:45:34'),(7,2,4,'Estazolam',22,'ex. Cambrex Profarmaco - Italy','\0','2933.91.00',NULL,'','\0','admin','2017-08-11 16:01:36','admin','2017-12-22 14:13:28'),(9,2,1,'Levodopa',3,'Guangxi Bonger','\0','29225090',NULL,'','\0','admin','2017-08-11 16:13:38','admin','2017-08-11 16:13:38'),(11,1,1,'Amlodipine Besylate',23,'ex. Cadila Pharmaceutical Ltd','\0','2939.80.00',NULL,'','\0','admin','2017-08-14 09:58:48','admin','2017-12-22 12:58:51'),(12,1,1,'Fluoxetine Hcl',23,'ex. Cadila Pharmaceutical Ltd / India','\0','2922.19.90',NULL,'','\0','admin','2017-08-14 10:00:51','admin','2017-12-22 14:15:22'),(13,1,1,'Dexamethasone Base',14,'ex. Symbotica  - Malaysia','\0','2937.22.00',NULL,'','','admin','2017-08-14 10:03:53','yudhi','2018-01-16 15:57:20'),(14,3,1,'Sertraline Hydrochloride Ph.Eur',16,'Vegesna Laboratories PVT. LTD','\0','2921.45.00 ',NULL,'','\0','admin','2017-08-14 10:34:53','admin','2017-08-14 13:40:31'),(15,2,1,'Permethrine (Pharma Grade)',4,'Srikem Laboratories Pvt. Ltd','\0','2916.20.00 ',NULL,'','\0','admin','2017-08-14 15:21:22','admin','2017-08-14 15:23:29'),(16,2,1,'Lithium Carbonate',11,'Jiangsu Nhwa','\0','2836.91.00',NULL,'','\0','admin','2017-08-14 15:27:13','admin','2017-08-14 15:27:13'),(17,2,1,'Sertaline Hcl Ph.Eur',16,'Vegesna Laboratories Ltd / India','','2921.45.00 ',NULL,'','\0','admin','2017-08-15 14:54:16','admin','2017-08-30 09:33:06'),(18,2,4,'Zolpidem Tartrate',12,'Farmak, a.s.','\0','2933.99.9000',NULL,'','\0','admin','2017-08-15 15:03:42','admin','2017-11-27 15:38:24'),(19,2,5,'Ephedrine Hcl',70,'ex. Embio  Limited','\0','2939.41.00',NULL,'','\0','admin','2017-08-15 16:27:16','admin','2017-12-22 14:13:06'),(20,2,5,'Pseudoephedrine Hcl',12,'Embio  Limited, INDIA','\0','2939.42.00 ',NULL,'','\0','admin','2017-08-15 16:29:53','admin','2017-08-16 13:58:12'),(21,2,1,'Levodopa BP',11,'Guangxi Bonger, CHINA','\0','29225090',NULL,'','\0','admin','2017-08-15 16:33:29','admin','2017-08-15 16:33:29'),(22,2,1,'Ofloxacin',12,'Zhejiang Apeloa Kangyu Pharmaceutical','\0','',NULL,'','\0','admin','2017-08-15 16:43:31','admin','2017-08-15 16:43:31'),(23,2,1,'Tobramycin',4,'ex. LIVZON New North River Pharmaceutical Co., Ltd','','2941.90.00 ',NULL,'','','admin','2017-08-16 10:39:12','admin','2017-12-22 14:22:33'),(24,3,4,'Clordiazepoxide',2,'ex. Cambrex Profarmaco - Italy','\0','2933.91.00',NULL,'','\0','admin','2017-08-16 13:48:39','admin','2017-12-22 14:00:08'),(25,1,1,'Hydroquinone USP',21,'ex. Medilux Laboratories Pvt Ltd','\0','29072200',NULL,'','','admin','2017-08-16 14:06:40','admin','2017-12-22 14:16:22'),(26,1,4,'Alprazolam USP 38 [ Particle Size 90 % < Microns ]',26,'ex. Lake Chemical Pvt Ltd / India','\0','2933.91.0000',NULL,'','','admin','2017-08-16 14:28:01','admin','2017-12-22 12:58:35'),(27,3,1,'Lactulose Concentrate USP',4,'Lacsa (PTY) Limited','\0','2940.00.00 ',NULL,'','\0','admin','2017-08-16 14:52:58','admin','2017-08-16 14:52:58'),(28,3,1,'Lactulose Concentrate USP',4,'Lacsa (PTY) Limited','\0','2940.00.00 ',NULL,'','\0','admin','2017-08-16 14:54:18','admin','2017-08-16 14:54:18'),(29,1,2,'Haloperidol USP 36',27,'ex. RL Fine Chem Pvt Ltd','','2933.99.9000',NULL,'','\0','admin','2017-08-16 15:04:31','admin','2017-12-22 14:16:02'),(30,1,1,'L-Methionin',11,'CJ HAIDE (Ningbo) Biotech Co., Ltd','\0','29304000',0.00,'','\0','admin','2017-09-19 13:31:00','admin','2017-09-19 13:31:00'),(31,1,1,'Gabapentine Usp',30,'ex. Strides Shasun Limited','\0','29224900',NULL,'-','\0','admin','2017-09-19 14:25:09','admin','2017-12-22 14:15:39'),(34,1,1,'Amlodipine Besylate BP/Ph.Eur',23,'ex. Cadila Pharmaceutical Ltd / India','\0','2939.80.00',NULL,'','','admin','2017-09-28 11:31:00','admin','2017-12-22 13:13:48'),(35,2,1,'Nifuroxazide EP',17,'ex. Coprima / Spain','\0','2932.19.00',NULL,'','','admin','2017-09-28 11:34:39','admin','2017-12-22 14:21:14'),(36,2,2,'',33,'RPG Life Sciences Limited','','2933.39.90',NULL,'','\0','admin','2017-09-28 11:45:03','admin','2017-09-28 11:45:03'),(37,2,1,'Methylcobalamine JP/USP',34,'ex. Vital Laboratories / India','\0','2936.26.00',NULL,'','','admin','2017-09-28 11:52:17','admin','2017-12-22 14:19:12'),(38,2,1,'Levodopa BP',11,'ex. Guangxi Bonger / China','\0','2922.50.90',NULL,'','','admin','2017-09-28 13:39:05','admin','2017-12-22 14:18:12'),(39,1,1,'Domperidone BP',36,'ex. Vasudha Pharma / India','\0','2933.39.90',NULL,'','','admin','2017-09-28 13:44:32','admin','2017-12-22 14:08:09'),(41,1,1,'Cetirizine DiHcl Ph.Eur',37,'ex. Granules India Ltd / India','\0','2933.59.90 ',NULL,'','','admin','2017-09-28 14:05:10','admin','2017-12-22 13:16:12'),(42,1,1,'Cinnarizine Dihcl BP',39,'ex. RL Fine Chemicals / INDIA','\0','2933.59.90 ',NULL,'','','admin','2017-09-28 14:20:28','admin','2017-12-22 13:17:04'),(43,1,1,'Cetirizine DiHcl  BP',39,'ex. Vaikunth Pharmaceuticals / INDIA','\0','2933.59.90 ',NULL,'','','admin','2017-09-28 14:22:49','admin','2017-12-22 13:15:41'),(44,2,1,'Terbutaline Sulphate BP',41,'ex. Jayco Cheemicals Industries / India','\0','2922.50.90',NULL,'','','admin','2017-09-28 14:32:49','admin','2017-12-22 14:23:38'),(45,1,1,'Clobetasol Propionate Micronized USP',14,'ex. Symbiotica / Malaysia','\0','2937.22.00',NULL,'','','admin','2017-09-28 14:35:03','admin','2017-12-22 13:59:53'),(46,1,1,'Diosmine EP 8.0',11,'ex. Chengdu Yazhong Bi-Pharmaceutical / CHINA','\0','2938.10.00',NULL,'','','admin','2017-09-28 14:37:17','admin','2017-12-22 14:07:29'),(47,1,1,'Cetirizine DiHcl  BP',15,'ex. Vaikunth Pharmaceuticals [Pvt] Ltd / INDIA','\0','2933.59.90 ',NULL,'','','admin','2017-09-28 14:39:52','admin','2017-12-22 13:15:59'),(48,1,1,'Allylestrenol JPC',2,'ex. Alchymars ICM SM Private / INDIA','\0','2937.23.00',NULL,'','','admin','2017-09-28 16:31:09','admin','2017-12-22 12:58:20'),(49,1,1,'Mometasone Furoate Micro USP',14,'ex. Symbiotica - Malaysia','\0','2937.22.00',NULL,'','','admin','2017-09-28 16:34:11','admin','2017-12-22 14:19:39'),(50,1,1,'Mecobalamine (Methylcobalamine)',34,'ex. Vital Laboratories / India','\0','2936.26.00',NULL,'','\0','admin','2017-09-28 16:36:05','admin','2017-12-22 14:17:23'),(51,1,1,'Clobetasol Propionate ',42,'China','\0','2937.22.00',NULL,'','','admin','2017-09-28 16:43:45','admin','2017-12-14 16:31:18'),(52,1,1,'Dexamethasone Base Micronized',42,'ex. Tianjin Tianyao','\0','2937.22.00',NULL,'','','admin','2017-09-28 16:45:46','admin','2017-12-22 14:02:08'),(53,1,1,'Finasteride USP 39',43,'ex. Hunan Yuxin Pharmaceutical Ltd / CHINA','\0','2937.29.00',NULL,'','','admin','2017-10-03 09:27:00','yudi','2018-03-19 15:25:28'),(57,1,1,'Dexamethasone Sodium Metasulphobenzoate [Working Standard]',14,'ex. Symbiotica - Malaysia','\0','2937.22.00',NULL,'','\0','admin','2017-10-03 14:59:14','budy','2018-02-02 11:53:17'),(58,2,1,'Meloxicam BP',44,'ex. Apex Healthcare Limited / Limited','\0','2934.10.00',NULL,'','','admin','2017-10-03 15:07:28','admin','2017-12-22 14:18:48'),(60,1,1,'Desonide Micronized USP',14,'ex. Symbiotica - Malaysia','\0','2937.29.00',NULL,'','','admin','2017-10-05 10:43:27','admin','2017-12-22 14:01:12'),(61,1,3,'Hesperidine',46,'China','\0','29389000',30.00,'','','admin','2017-10-13 10:10:23','yudi','2018-03-09 15:03:18'),(62,6,1,'Brinzolamide',45,'-','\0','----------',0.00,'','','admin','2017-10-17 14:27:00','admin','2017-10-17 14:27:00'),(63,1,3,'Mecobalamine (Methylcobalamine)',9,'ex.Interquim','\0','2936.26.00',NULL,'','','admin','2017-10-18 09:18:13','admin','2017-10-18 09:18:13'),(64,1,3,'Vitamin B12 (Cyanocobalamine)',2,'ex. Sanofi / France','\0','2936.26.00',NULL,'','','admin','2017-10-18 09:36:50','yudi','2018-03-21 15:02:25'),(65,1,1,'Hydrocortisone Base BP/USP',14,'ex.Symbiotica / Malaysia','\0','2937.21.00',NULL,'','','admin','2017-10-18 09:47:42','admin','2017-10-18 09:47:42'),(66,1,1,'Itraconazole Pellets 22% USP',19,'ex. RA Chem Pharma Limited / INDIA','\0','2934.99.90',NULL,'','','admin','2017-10-18 09:51:36','admin','2017-10-18 09:51:36'),(67,1,1,'Maprotiline Hcl USP',17,'ex.Sifavitor / ITALY','\0','2921.49.00',NULL,'','','admin','2017-10-18 09:55:40','admin','2017-10-18 09:55:40'),(68,1,1,'Ketorolac Tromethamine USP (Injectable Grade)',17,'ex. MSN Laboratories / INDIA','\0','2933.99.9000',NULL,'','','admin','2017-10-18 10:02:00','admin','2017-10-18 10:02:00'),(69,1,1,'Oxcarbazepine USP36 Bulk Density >0.600 gr/ml',40,'ex.Zhejiang Jiuzhou / CHINA','\0','2933.99.90',NULL,'','','admin','2017-10-18 10:12:07','admin','2017-10-18 10:12:07'),(70,1,1,'Gliclazide HCL USP',11,'ex. Shandong Keyuan / CHINA','\0','2935.10.00',NULL,'','','admin','2017-10-18 10:27:55','admin','2017-10-18 10:27:55'),(71,1,1,'Choline Bitartrate',11,'ex. Shenzhen Fast Chemical Co., Ltd','\0','2923.10.00',NULL,'','','admin','2017-10-18 10:42:33','admin','2017-12-22 13:16:45'),(72,1,3,'L-Mehionin',11,'ex. CJ Haide [Ningbo] Biotech Co., Ltd','\0','2930.40.00',NULL,'','','admin','2017-10-18 10:52:01','admin','2017-10-18 10:52:01'),(73,1,1,'Clozapine BP',11,'ex. Taizhou Xinming Pharmaceutical / CHINA','\0','2933.59.90 ',NULL,'','','admin','2017-10-18 10:57:01','admin','2017-10-18 10:57:01'),(74,1,1,'Cefoperazone Sodium',43,'ex.Shandong Ruiying Pharmaceutical / CHINA','\0','2941.90.00 ',NULL,'','','admin','2017-10-18 10:59:54','admin','2017-10-18 10:59:54'),(75,1,1,'Promethazine Theoclate BP',47,'ex.Harika Drugs Pvt / INDIA','\0','2939.59.00',NULL,'','','admin','2017-10-18 11:04:01','admin','2017-10-18 11:04:01'),(76,1,1,'Domperidone Maleate BP ',36,'ex. Vasudha Pharma Chem Limited / INDIA','\0','2933.39.90',NULL,'','','admin','2017-10-18 11:06:18','yudi','2018-01-29 16:34:30'),(77,1,2,'Haloperidol BP/EP',33,'ex. RPG Life Sciences Ltd / INDIA','\0','2933.39.90',NULL,'','','admin','2017-10-18 11:08:44','admin','2017-10-18 11:08:44'),(78,1,1,'Mupirocin Calcium USP 38',40,'ex. Hangzou Zhongmei Huadong Pharmaceutical/CHINA','\0','2941.90.00 ',NULL,'','','admin','2017-10-18 11:14:16','admin','2017-10-18 11:14:16'),(79,1,1,'Mupirocin USP 39',40,'ex. Hangzhou Zhongmei Huadong Pharmaceutical/CHINA','\0','2941.90.00 ',NULL,'','','admin','2017-10-18 11:20:08','admin','2017-10-18 11:20:08'),(80,1,1,'Salbutamol Sulphate BP',41,'ex. Jayco Chemical Industries / INDIA','\0','2922.50.90',NULL,'','','admin','2017-10-18 11:22:06','admin','2017-10-18 11:22:06'),(81,1,1,'Minocycline Hcl USP 39/BP/Ph.Eur',70,'ex, CIPAN [Companhia Industrial Produture De Antii','\0','2941.30.00',NULL,'','','admin','2017-10-18 11:26:05','yudi','2018-04-03 09:48:59'),(82,1,6,'Gingko Biloba Extract 24%',48,'ex.Huisong Pharmaceuticals / CHINA','\0','1302.19.30.00',NULL,'','','admin','2017-10-18 13:36:52','admin','2017-10-18 13:36:52'),(83,1,3,'Vitamin D3 100 CWS-FBD',49,'ex. Piramal Enterprise Limited / INDIA','\0','2936.23.00',NULL,'','','admin','2017-10-18 13:44:14','admin','2017-10-18 13:44:14'),(84,1,5,'Pseudoephedrine Hcl BP/Ph.Eur',18,'ex. Embio Limited / INDIA','\0','2939.42.00 ',NULL,'','','admin','2017-10-18 13:47:25','admin','2017-10-18 13:47:25'),(85,1,1,'Omeprazole Pellets 8.5% [Mesh 14#18]',66,'ex. Smilax Labs / INDIA','\0','3003.90.00',NULL,'','','admin','2017-10-18 16:32:06','admin','2017-10-18 16:32:06'),(86,1,1,'Betamethasone Valerate USP',14,'ex.Symbiotica / Malaysia','\0','2937.22.00',NULL,'','','admin','2017-10-18 16:41:43','yudi','2018-02-05 08:13:38'),(87,1,1,'Tioconazole Ph.Eur',64,'ex. Optimus Drugs Pvt Ltd / INDIA','\0','2934.99.90',NULL,'','','admin','2017-10-18 16:44:30','admin','2017-10-18 16:44:30'),(88,1,1,'Amitriptiline Hcl USP',36,'ex. Vasudha Pharma Chem Limited / INDIA','','2921.49.00',NULL,'','','admin','2017-10-18 16:47:27','yudi','2018-01-29 16:26:51'),(89,1,1,'Tramadol Hcl',9,'ex. Chemagis / Perrigo','','2922.50.90',NULL,'','','admin','2017-10-18 16:49:36','admin','2017-10-18 16:49:36'),(90,1,1,'Lidocaine Hcl BP',51,'ex. Apex Healthcare Limited / INDIA','\0','2924.29.90',NULL,'','','admin','2017-10-18 16:52:34','admin','2017-10-18 16:52:34'),(91,1,3,'DL - Choline Bitartrate',11,'ex. Shenzhen Fast Chemical Co., Ltd / CHINA','\0','2923.10.00',NULL,'','','admin','2017-10-19 11:03:50','admin','2017-10-19 11:03:50'),(92,1,1,'Betamethasone Sodim Phosphate USP Grade',14,'ex.Symbiotica / Malaysia','\0','2937.22.00',NULL,'','','admin','2017-10-19 11:07:03','admin','2017-10-19 11:07:03'),(93,1,1,'Oxytocin Powder EP',52,'ex. Grindeks / LATVIA','\0','2937.19.00',NULL,'','','admin','2017-10-19 11:19:28','admin','2017-10-19 11:19:28'),(94,1,1,'Vincamine [Formerly Vincaminor Extract]',53,'ex. Covex,SA / SPAIN','\0','2939.79.00',NULL,'','','admin','2017-10-19 11:26:39','admin','2017-10-19 11:26:39'),(95,1,1,'DESONIDE',14,'ex. Symbiotica / Malaysia','\0','2937.29.00',0.00,'','','admin','2017-10-19 11:27:14','admin','2017-12-22 14:00:56'),(96,1,6,'Iron Sucrose Complex',35,'ex. Emcure Pharmaceuticals Limited','\0','2918.16.00',NULL,'','','admin','2017-10-19 11:29:07','admin','2017-11-17 16:11:57'),(97,1,1,'Levofloxacin Hemihydrate Injection Grade',54,'ex. Shangyu Jingxin Pharmaceuticals / CHINA','\0','2934.99.90',NULL,'','','admin','2017-10-19 11:45:27','admin','2017-10-19 11:45:27'),(98,1,1,'Pilocarpine Hcl',18,'ex. Sourcetech Quimica Ltd','\0','2939.79.00',NULL,'','','admin','2017-10-19 13:08:59','admin','2017-10-19 13:08:59'),(99,1,1,'Flunarizine Dihcl',58,'ex. Fleming Laboratories Limited / INDIA','\0','2933.59.90',NULL,'','','admin','2017-10-19 13:11:11','yudi','2018-04-06 09:58:18'),(100,1,1,'Finastride USP 39',55,'ex. Hunan Yuxin Pharmaceutical Co., Ltd / CHINA','\0','2937.29.00',NULL,'','','admin','2017-10-19 13:14:56','admin','2017-10-19 13:14:56'),(101,1,1,'Acyclovir Micronized < 20 Microns',40,'ex. Zhejiang Chairoter Pharm - CHINA','\0','2933.59.90 ',NULL,'','','admin','2017-10-19 13:17:29','admin','2017-12-22 13:17:35'),(102,1,1,'Betamethasone Base Miconizzed',14,'ex.Symbiotica / Malaysia','\0','2937.22.00',NULL,'','','admin','2017-10-19 13:21:47','admin','2017-10-19 13:21:47'),(103,1,1,'Methylprednisolone Base Micro USP',14,'ex.Symbiotica / Malaysia','\0','2937.29.00',NULL,'','','admin','2017-10-19 13:23:38','admin','2017-11-28 15:51:14'),(104,1,1,'Haloperidol USP',57,'ex. RL Fine Chem Pvt Ltd / INDIA','\0','2933.39.90',NULL,'','','admin','2017-10-19 13:28:16','admin','2017-10-19 13:28:16'),(105,1,1,'Sertraline Hcl',47,'ex.Harika Drugs Pvt / INDIA','\0','2921.45.00 ',NULL,'','','admin','2017-10-19 13:33:14','admin','2017-10-19 13:33:14'),(106,1,1,'Alpha Lipoic Acid [Thioctic Acid]',70,'ex. Suzhou Fushilai Pharmaceutical Co., Ltd /CHINA','\0','2930.90.10',NULL,'','','admin','2017-10-19 13:38:10','yudhi','2018-01-05 08:54:48'),(107,1,1,'Clarithromycin USP',2,'ex. Zhejiang Guobang Pharmaceutical Co., Ltd ','\0','2941.50.00',NULL,'','','admin','2017-10-19 13:41:36','admin','2017-12-22 13:56:14'),(108,1,1,'Clindamycin Hcl USP 38',43,'ex. Zhejiang Hisoar Chuannan Pharmaceutical Co., L','\0','2941.90.00 ',NULL,'','','admin','2017-10-19 13:44:04','admin','2017-10-19 13:44:04'),(109,1,1,'Esomperazole Magnesium Trihdrate USP 37',69,'ex. Everest Organics Limited / CHINA','\0','2933.39.90',NULL,'','','admin','2017-10-19 13:54:52','admin','2017-10-19 13:54:52'),(110,1,1,'Ceftazidime Sterile with Sodium Carbonate USP',40,'ex. Qilu Antibiotics Pharmaceutical Co., Ltd','\0','2941.90.00 ',NULL,'','','admin','2017-10-19 14:00:10','admin','2017-10-19 14:00:10'),(112,1,1,'Ketorolac Thromethamine USP (Injectable Grade)',39,'ex. Symed Labs Limited / INDIA','\0','2933.99.90',NULL,'','','admin','2017-10-19 14:10:49','yudi','2018-04-02 08:42:19'),(113,1,1,'N-Acetyl L-Cystein USP',59,'ex. Wuhan Grand Hoyo Co., Ltd / CHINA','\0','2930.30.00',NULL,'','','admin','2017-10-19 14:15:54','yudi','2018-03-28 11:27:57'),(114,1,1,'Lactulose 70 %',18,'ex. Lacsa PTY Ltd / South Africa','\0','2940.00.00 ',NULL,'','','admin','2017-10-19 14:31:43','admin','2017-10-19 14:31:43'),(115,1,4,'Chlordiazepoxide Hcl',2,'ex. Cambrex Profarmaco - ITALY','\0','2933.91.00',NULL,'','','admin','2017-10-19 14:35:02','yudi','2018-03-13 11:37:16'),(116,1,7,'Citrus Aurantinum Extract [HESPERIDINE]',46,'ex. Hunan Yuantong Pharmaceutical / CHINA','\0','2938.10.00',NULL,'','','admin','2017-10-19 14:40:46','admin','2017-10-19 14:40:46'),(117,1,6,'Saw Palmento Extract',60,'ex. Hangzhou Greensky - CHINA','\0','1302.19.90',NULL,'','','admin','2017-10-19 14:48:55','admin','2017-10-19 14:48:55'),(118,1,1,'Lysozyme Hcl Powder',18,'ex. Bouwhuis Enthoven B.V. / NETHERLAND','\0','3507.90.00',NULL,'','','admin','2017-10-19 15:02:24','admin','2017-10-19 15:02:24'),(119,1,8,'Lysozyme Hcl FIP Standard',18,'ex.International Pharmaceutical Federation/BELGIUM','\0','3507.90.00',NULL,'','','admin','2017-10-19 15:06:37','admin','2017-10-19 15:06:37'),(120,1,1,'Tranexamic Acid EP/BP Injection',62,'ex. Hunan Dongting / CHINA','\0','2922.49.00 ',NULL,'','','admin','2017-10-19 15:15:11','admin','2017-10-19 15:15:11'),(121,1,1,'Metoprolol Tartrate EP',9,'ex.Microsin / ROMANIA','\0','2922.19.90',NULL,'','','admin','2017-10-19 15:18:28','admin','2017-10-19 15:18:28'),(122,1,3,'Co-enzym Q10 [Water Soluble]',13,'ex. Shananxi Yuanbang Bio-Tech Co., Ltd/CHINA','\0','2914.62.00',NULL,'','','admin','2017-10-19 15:24:32','admin','2017-10-19 15:24:32'),(123,1,1,'Mupirocin USP',12,'ex. CONCORD BIOTECH LIMITED','\0','29419000',NULL,'','','admin','2017-10-20 10:51:55','admin','2017-12-22 14:19:54'),(124,1,1,'Cetirizine Dhcl BP',27,'ex. Vaikunth Pharmaceutical / INDIA','\0','2933.59.90',NULL,'','','admin','2017-10-25 13:43:11','admin','2017-12-22 13:15:20'),(125,6,1,'Lansoprazole DR Pellets 8.50%',19,'ex. RA  Chem Pharma Limited','\0','----------',1.00,'','','admin','2017-10-25 15:36:57','admin','2017-12-22 14:17:52'),(127,1,1,'Citicoline Sodium ',2,'ex. Euticals, SPA - Italy','\0','2934.99.90',0.00,'','','admin','2017-10-27 15:16:35','yudhi','2018-01-17 09:26:28'),(128,1,1,'Cefixime Trihydrate Powder USP',9,'ex.Orchid Pharma / India','\0','2941.90.00 ',NULL,'','','admin','2017-10-30 09:16:05','admin','2017-10-30 09:16:05'),(129,1,1,'Cetirizine DiHcl  BP',57,'ex. Vaikunth Pharmaceuical / INDIA','\0','2933.59.90 ',NULL,'','','admin','2017-10-30 09:24:31','admin','2017-10-30 09:24:31'),(130,1,1,'Ketoconazole Micronized',11,'ex. Zhejiang East Asia Pharmaceutical / INDIA','\0','2934.99.90',NULL,'','','admin','2017-10-30 10:00:49','admin','2017-10-30 10:03:04'),(131,1,1,'N-Acetyl L-Cystein',11,'ex. Wuhan Grand Hoyo Co., Ltd / CHINA','\0','2930.90.90',NULL,'','','admin','2017-10-31 15:47:43','admin','2017-10-31 15:47:43'),(132,1,1,'Neomycin Sulphate Sterile EP 8.0',11,'ex. Sichuan Long March Pharmaceutical Co., Ltd','\0','2941.90.00 ',0.00,'','','admin','2017-11-03 13:45:55','admin','2017-12-22 14:20:28'),(133,1,1,'Acyclovir Micronized ',11,'ex.Zhejiang Zhebei / CHINA','\0','2933.59.90 ',NULL,'','','admin','2017-11-03 15:16:55','admin','2017-12-22 11:11:11'),(134,1,1,'Pilocarpine Hcl',70,'ex.Sourcetech Quimica LTD / BRAZIL','\0','2939.79.00',NULL,'','','admin','2017-11-06 10:07:48','admin','2017-11-06 10:07:48'),(135,1,1,'Tobramycin USP',70,'ex.Livzon Pharmaceutical/CHINA','\0','2941.90.00 ',NULL,'','','admin','2017-11-06 10:19:43','yudi','2018-04-04 15:49:19'),(136,1,1,'DL-Choline Bitartrate 1% Coated USP 30',40,'ex. Shenzhen Fast Chemical Co., Ltd /CHINA','\0','2923.10.00',NULL,'','','admin','2017-11-06 13:43:23','admin','2017-12-22 14:07:50'),(137,1,1,'Dexamethasone Sodium  Phosphate',43,'ex. Tianjin Tianyao / CHINA','\0','2937.22.00',NULL,'','','admin','2017-11-06 13:58:27','admin','2017-11-06 13:58:27'),(138,1,1,'Meloxicam BP',70,'ex. Apex Healthcare Limited / INDIA','\0','2934.10.00',NULL,'','','admin','2017-11-06 14:19:21','admin','2017-11-06 14:19:21'),(140,1,2,'Amitriptiline Hcl USP',57,'ex.Vasudha Pharma / INDIA','','2921.49.00',NULL,'','','admin','2017-11-06 15:33:55','admin','2017-11-06 15:33:55'),(141,1,6,'Iron Sucrose Complex',17,'ex. Emcure  Ltd / INDIA','\0','2918.16.00',NULL,'','','admin','2017-11-08 09:40:41','admin','2017-11-08 09:40:41'),(142,1,3,'Mecoblamine (Metylcobalamine)',34,'ex. Vital Laboratories PVT Ltd / INDIA','\0','2936.26.00',NULL,'','','admin','2017-11-08 10:40:20','admin','2017-11-08 10:40:20'),(143,1,1,'Oxomemazine',57,'ex. RL Fine Chem Pvt Ltd / INDIA','\0','2934.30.00',NULL,'','','admin','2017-11-08 11:07:56','admin','2017-11-08 11:07:56'),(144,1,1,'Permethrine (Pharma Grade)',70,'ex. Srikem Laboratories / INDIA','\0','2916.20.00 ',NULL,'','','admin','2017-11-08 15:40:41','admin','2017-11-08 15:40:41'),(145,1,1,'Omeprazole Pellets 8.5% [Mesh 14#18]',38,'ex. Smilax Labs / INDIA','\0','3003.90.00',NULL,'','','admin','2017-11-08 16:09:33','admin','2017-11-08 16:09:33'),(146,1,1,'Omeprazole Pellets 8.5%',19,'ex. RA Chem Pharma Limited / INDIA','\0','3003.90.00',NULL,'','','admin','2017-11-08 16:23:03','admin','2017-11-08 16:23:03'),(147,1,1,'Cefixime Trihydrate Micronized USP',9,'ex. Orchid - INDIA','\0','2941.90.00 ',NULL,'','','admin','2017-11-08 16:36:43','admin','2017-11-08 16:36:43'),(148,1,1,'Cefepime with Arginin',9,'ex. Orchid - INDIA','\0','2941.90.00 ',NULL,'','','admin','2017-11-08 16:38:21','admin','2017-11-08 16:38:21'),(149,1,1,'Betahistine 2 Hcl',4,'ex. ZCL Chemical Ltd','\0','2933.39.90',NULL,'','','admin','2017-11-08 16:51:52','admin','2017-11-08 16:51:52'),(151,1,1,'Oxomemazine',71,'ex. R L Fine Chem PVT Ltd/INDIA','\0','2934.30.00',NULL,'','','admin','2017-11-20 08:47:31','admin','2017-11-20 08:47:31'),(152,1,1,'Triprolidine Hcl USP',20,'ex. Hikal Limited / INDIA','\0','2933.39.90',NULL,'','','admin','2017-11-20 09:06:40','yudhi','2018-01-03 10:02:30'),(153,1,1,'Haloperidol USP',16,'ex. RL Fine Chemicals / INDIA','','2933.39.90',NULL,'','','admin','2017-11-23 16:45:28','admin','2017-11-23 16:45:28'),(154,1,1,'Mupirocin USP ',70,'ex. Concord Biotech Limited / INDIA','\0','2941.90.00 ',NULL,'','','admin','2017-11-24 15:36:08','admin','2017-11-24 15:36:08'),(155,1,1,'Gabapentine USP',61,'ex. Strides Shasun / INDIA','\0','2922.49.00 ',NULL,'','','admin','2017-11-27 08:38:41','admin','2017-11-27 08:38:41'),(156,1,1,'Pantoprazole Sodium Sterile',16,'ex. Rajasthan Antibiotics Limited / INDIA','\0','2933.39.90',NULL,'','','admin','2017-11-27 09:42:09','yudhi','2018-01-11 08:00:17'),(157,1,1,'Valacyclovir Hcl USP (Hydrous Form)',40,'','\0','2933.59.90 ',NULL,'','','admin','2017-11-27 09:48:52','admin','2017-11-27 09:48:52'),(158,1,1,'Dexamethasone Sodium Metasulphobenzoate (Working Standard)',14,'ex. Symbiotica / Malaysia','\0','2937.22.00',NULL,'','\0','admin','2017-11-27 10:09:25','budy','2018-02-02 11:50:24'),(159,1,1,'Working Standard',13,'ex. Shaanxi yuanbang Bio-Tech Co., Ltd / CHINA','\0','2914.62.00',NULL,'','','admin','2017-11-27 10:28:08','admin','2017-11-27 10:28:08'),(160,1,1,'Lisinopril Dihydrate Ph. Eur',16,'ex. Unimark Remedies / INDIA','\0','2933.99.90',NULL,'','','admin','2017-11-27 10:47:01','yudi','2018-02-27 15:50:00'),(161,1,1,'Amlodipine Besylate BP/EP',63,'ex. Prudence Pharma Chem / INDIA','\0','2939.80.00',NULL,'','','admin','2017-11-27 14:30:52','yudhi','2018-01-08 14:07:44'),(162,1,4,'Zolpidem Tartrate',4,'ex. Farmak A.S','\0','29339990',10.00,'','','admin','2017-11-27 15:53:21','admin','2017-12-22 14:22:51'),(163,1,1,'Omeprazole Pellets 22%',19,'ex. RA Chem Pharma Limited / INDIA','\0','3003.90.00',NULL,'','','admin','2017-11-27 16:07:25','admin','2017-11-27 16:07:25'),(164,1,1,'Levofloxacin Hemihydrate ',11,'ex. Shangyu Jingxin Pharmaceuticals / CHINA','\0','2934.99.90',NULL,'','','admin','2017-11-27 16:16:27','admin','2017-11-27 16:16:27'),(165,1,1,'ONDANSETRON HCL',74,'ex. CADILA PHARMACEUTICALS','\0','123456789',1.00,'','','admin','2017-12-20 11:57:51','admin','2017-12-22 14:21:36'),(166,1,1,'LISINOPRIL DIHYDRATE',54,'ex ZHEJIANG HUAHAI','\0','29339990',1.00,'','','admin','2017-12-20 11:58:38','yudhi','2018-01-10 16:33:14'),(167,1,1,'CEFIXIME COMPACTED',9,'ex. Zhejiang Apeloa / CHINA','\0','2941.90.00 ',1.00,'','','admin','2017-12-20 12:01:27','admin','2017-12-22 13:14:48'),(169,1,1,'Clozapine',43,'ex. Tazhou Xingming Pharmaceutical Co., Ltd','\0','2933.59.90 ',1.00,'','','admin','2017-12-21 15:29:22','admin','2017-12-22 14:00:21'),(170,1,1,'lycopen 5% Powder',48,'ex. Huisong Pharmaceutical / CHINA','\0','13021930',0.00,'','','yudhi','2018-01-03 10:26:17','yudhi','2018-01-03 10:27:46'),(171,1,3,'Vitamin K Diacetate',11,'ex. Anhui Wanhe Pharmaceutical Co., Ltd / CHINA','\0','2936.23.00',0.00,'','','yudhi','2018-01-03 17:00:50','yudhi','2018-01-03 17:00:50'),(172,1,1,'Saw Palmento Extract 45%',48,'ex. Huisong Pharmaceutical / CHINA','\0','13021990',0.00,'','','yudhi','2018-01-03 17:10:28','yudhi','2018-01-03 17:19:09'),(173,1,1,'Saw Palmento Extract 45%',60,'ex. Hangzhou Greensky / CHINA','\0','13021990',0.00,'','','yudhi','2018-01-03 17:12:59','yudhi','2018-01-03 17:17:06'),(174,1,1,'Tribulus Terrestris  Dry Extract 60% Furostamol Saponin',70,'ex. Vemo 99 Ltd / BULGARIA','\0','13021930',0.00,'','','yudhi','2018-01-05 15:24:34','yudi','2018-01-29 08:40:20'),(175,1,1,'Fenofibrate Micronized',2,'ex. Jiangsu Nhwa Pharmaceutical Co., Ltd / CHINA','\0','29189900',NULL,'','','yudhi','2018-01-05 15:59:41','yudhi','2018-01-05 15:59:41'),(176,1,1,'Diosmin EP',78,'ex. Chengdu Yazhong  / CHINA','\0','29381000',0.00,'','','yudhi','2018-01-09 11:24:58','budy','2018-02-07 08:56:29'),(177,1,1,'Lidocaine Hcl USP',79,'ex. Gufic Biosciences Ltd / INDIA','\0','2924.29.90',0.00,'','','yudhi','2018-01-10 15:15:31','yudhi','2018-01-10 15:15:31'),(178,1,1,'Cinnarizine BP/EP',58,'ex. Fleming Laboratories Limited / INDIA','\0','2933.59.90 ',0.00,'','','yudhi','2018-01-11 09:58:07','yudhi','2018-01-11 09:58:07'),(179,1,1,'Cyproheptadine USP',36,'ex. Vasudha Pharma / India','\0','2933.39.90',0.00,'','','yudhi','2018-01-11 14:08:11','yudhi','2018-01-17 16:26:20'),(180,1,1,'Amlodipine Besylate BP/EP',23,'ex. Prudence Pharma Chem / INDIA','\0','2933.99.90',0.00,'','','yudhi','2018-01-11 15:52:02','yudhi','2018-01-11 15:52:02'),(181,1,1,'Ketoprofen Micronized',11,'ex. Hubei Xundai / CHINA','\0','29183000',0.00,'','','yudhi','2018-01-11 16:35:32','yudhi','2018-01-11 16:35:32'),(182,1,6,'Iron Sucrose Complex',2,'ex. Emcure Pharmaceuticals Limited','\0','2918.16.00',0.00,'','','nurdin','2018-01-18 16:39:24','nurdin','2018-01-18 16:39:24'),(183,1,1,'Cinnarizine Dihcl BP 2016',16,'ex. RL Fine Chemicals / INDIA','\0','2933.59.90 ',0.00,'','','nurdin','2018-01-18 16:45:28','yudi','2018-01-24 14:26:28'),(184,1,1,'Cetirizine Dhcl EP Grade',2,'ex. Granules India Ltd / India','\0','2933.59.90 ',NULL,'','','nurdin','2018-01-18 16:57:16','nurdin','2018-01-18 16:57:16'),(185,1,1,'Lactulose  Solution 70 %',70,'ex. Lacsa PTY Ltd / South Africa','\0','2940.00.00 ',0.00,'','','nurdin','2018-01-18 17:00:48','yudi','2018-01-24 14:44:05'),(186,1,1,'Cetirizine Dhcl EP',16,'ex. Apex Healthcare Limited / INDIA','\0','2933.59.90 ',NULL,'','','nurdin','2018-01-18 17:06:21','yudi','2018-02-01 10:35:24'),(187,2,1,'Nifuroxazide EP',2,'ex. Coprima / SPAIN','\0','2932.19.00',NULL,'','','nurdin','2018-01-18 17:09:12','nurdin','2018-01-18 17:09:12'),(188,1,3,'L-Methionine',43,'ex. CJ Haide (Ningbo) Biotech Co., Ltd / CHINA','\0','2930.40.00',NULL,'','','nurdin','2018-01-18 17:14:16','nurdin','2018-01-18 17:14:16'),(189,1,3,'Vitamin K Diacetate',43,'ex. Anhui Wanhe Pharmaceutical Co., Ltd / CHINA','\0','2936.23.00',0.00,'','','nurdin','2018-01-18 17:15:41','nurdin','2018-01-18 17:15:41'),(190,1,1,'Mebeverine Hcl',19,'ex. RA  Chem Pharma Limited / INDIA','\0','29225090',0.00,'','','yudhi','2018-01-19 16:52:51','yudhi','2018-01-22 10:57:10'),(191,1,1,'Neomycin Sulphate USP 39',40,'ex. Yichang Sanxia / CHIINA','\0','2941.90.00 ',0.00,'','','yudi','2018-01-24 14:31:14','yudi','2018-01-24 14:31:14'),(192,1,1,'Rutin',40,'ex. Chengdu Okay Pharmaceutical / CHINA','\0','29381000',0.00,'','','yudi','2018-01-24 14:37:13','yudi','2018-01-24 14:37:13'),(193,1,1,'Homatropine Hbr EP',70,'ex. Medigraph / INDIA','\0','29392090',0.00,'','','yudi','2018-01-24 14:42:43','yudi','2018-03-19 15:24:23'),(194,1,1,'Risperidone EP',27,'ex. Enaltec Labs Pvt Ltd / INDIA','\0','29349990',0.00,'','','yudi','2018-01-24 14:49:40','qwinjayasupport','2018-02-02 16:09:37'),(195,1,1,'Folic Acid',40,'ex. Hebei  Jiheng / CHINA','\0','29362900',0.00,'','','yudi','2018-01-26 16:04:01','yudi','2018-01-26 16:09:45'),(196,1,4,'Midazolam Hcl (Inject Grade)',2,'ex. Cambrex Profarmaco - Italy','\0','29339100',0.00,'','','yudi','2018-01-29 08:17:12','yudi','2018-01-29 09:29:59'),(197,1,1,'Cetirizine Hcl EP',16,'ex. Vaikunth Pharmaceutical / INDIA','\0','29335990',0.00,'','','yudi','2018-01-29 15:09:18','yudi','2018-01-29 15:09:18'),(198,1,1,'Cinnarizine Hcl BP',16,'ex. Vaikunth Pharmaceuticals / INDIA','\0','29335990',0.00,'','','yudi','2018-01-29 15:19:09','yudi','2018-01-29 15:20:09'),(199,1,1,'Nifuroxazide EP',45,'ex. Global Calcium / INDIA','\0','29321900',0.00,'','','yudi','2018-01-31 13:37:32','yudi','2018-01-31 13:44:46'),(200,1,1,'Vitamin B1 Mono',70,'ex. Jiangxi Tianxin','\0','29362600',0.00,'','','yudi','2018-02-01 08:44:01','yudi','2018-02-01 08:44:01'),(201,1,1,'Hydroquinone USP',70,'ex. Medilux Laboratories Pvt Ltd / INDIA','\0','29072200',0.00,'','','yudi','2018-02-01 09:08:56','yudi','2018-02-01 09:08:56'),(202,1,1,'Iron Sucrose',45,'ex. Global Calcium / INDIA','\0','29181600            ',0.00,'','','yudi','2018-02-02 08:59:51','yudi','2018-02-02 08:59:51'),(203,1,1,'Dexamethasone Sodium Metasulphobenzoate ',14,'ex. Symbiotica - Malaysia','\0','29372200',NULL,'','\0','budy','2018-02-02 13:11:06','budy','2018-02-02 13:18:08'),(204,1,1,'Dexamethasone Sodium Metasulphobenzoate',14,'ex. Symbiotica - Malaysia','\0','29372200',NULL,'','','budy','2018-02-02 13:22:38','budy','2018-02-02 13:22:38'),(205,1,1,'Dexamethasone Sodium Metasulphobenzoate (Working Standard)',14,'ex. Symbiotica - Malaysia','\0','29372200',NULL,'','','budy','2018-02-02 13:24:10','budy','2018-02-02 13:24:10'),(206,1,1,'Simethicone Powder',86,'ex. DASAN Pharmaceutical / KOREA','\0','30039000',0.00,'','','yudi','2018-02-05 14:40:10','yudi','2018-02-05 14:50:17'),(207,1,1,'Brompheniramine Maleate USP',16,'Kesavha Organics Pvt Ltd.','\0','29333990',NULL,'','','budy','2018-02-07 09:22:13','budy','2018-02-07 09:22:13'),(208,1,1,'ROSUVASTATIN CALCIUM EP',17,'ex. CTX LIfesciences (P) INDIA','\0','29359000',NULL,'','','akhiong','2018-02-07 09:30:19','akhiong','2018-02-07 09:30:19'),(209,1,1,'Benzocaine EP9',11,'Changzhou Sunlight Pharmaceutical Co., Ltd/China','\0','29224900 ',NULL,'','','budy','2018-02-07 13:25:44','budy','2018-02-07 13:25:44'),(210,1,1,'Cetylpyridinium Chloride BP',87,'ex.Technodrugs - INDIA','\0','29333990',NULL,'','','akhiong','2018-02-09 08:26:50','akhiong','2018-02-09 08:26:50'),(211,1,1,'Sodium Hyaluronate (HA-EPI)',70,'ex. Bloomage Freeda / China','\0','39139090',0.00,'','','yudi','2018-02-12 08:19:36','yudi','2018-02-12 08:19:36'),(212,1,1,'Dipenhydramine Hcl',88,'ex. Supriya Lifescience Ltd','\0','29221990',0.00,'','','yudi','2018-02-20 16:15:27','yudi','2018-02-20 16:15:27'),(213,1,1,'Hydrotalcite',80,'ex. Meha Chemicals / INDIA','\0','28369990',25.00,'','','yudi','2018-02-22 14:33:43','akhiong','2018-02-22 14:42:58'),(214,1,4,'Zolpidem Tartrate',70,'ex. Farmak / Czech Republic ','\0','29339990',1.00,'','','yudi','2018-02-23 16:21:11','yudi','2018-02-23 16:21:11'),(215,1,1,'Lithium Carbonate',11,'ex. Jiangsu Nhwa Pharmaceutical Co., Ltd / CHINA','\0','28369100',25.00,'','','yudi','2018-02-27 15:54:42','yudi','2018-02-27 16:42:39'),(216,1,1,'Levocetirizine Hcl',89,'ex. Granule Labs / INDIA','\0','29335990',0.00,'','','yudi','2018-02-28 08:48:30','yudi','2018-02-28 08:48:30'),(217,1,1,'Hyoscine N-Butylbromide EP9',44,'ex. Alkaloids / AUSTRALIA','\0','29397900',0.00,'','','yudi','2018-03-01 16:02:21','yudi','2018-03-01 16:02:21'),(218,1,1,'L-Carnitine Fumarate',90,'ex. Ningbo Create - Bio / CHINA','\0','21069099',25.00,'','','yudi','2018-03-05 08:05:31','yudi','2018-03-05 08:37:47'),(219,1,1,'Amitriptyline Hydrochloride USP',27,'ex. Vasudha Pharma Chem Limited / INDIA','\0','29214900',25.00,'','','yudi','2018-03-08 08:43:16','yudi','2018-03-08 08:43:16'),(220,1,1,'Donepezil Form III',92,'ex. Megafine / INDIA','\0','29333990',0.00,'','','yudi','2018-03-09 09:54:39','yudi','2018-03-09 11:45:26'),(221,1,1,'Bismuth Subsalicylate SG in Pharma -Bags',91,'ex. 5N Plus Lubeck GmbH / GERMANY','\0','29189900',0.00,'','','yudi','2018-03-09 10:14:56','yudi','2018-03-09 10:14:56'),(222,1,1,'Benzyl Nicotinate',93,'ex. Herbert Brown / INDIA','\0','29411090',0.00,'','','yudi','2018-03-09 11:21:54','yudi','2018-03-09 11:26:34'),(223,1,1,'Mometasone Maleate',14,'ex. Symbiotica / Malaysia','\0','29372200',100.00,'','\0','yudi','2018-03-12 09:35:42','yudi','2018-03-12 09:35:42'),(224,1,1,'Lysine Hcl',11,'ex. CJ Haide (Ningbo) / CHINA','\0','29183000',0.00,'','','yudi','2018-03-12 09:59:10','yudi','2018-03-12 10:01:59'),(225,1,1,'Ambroxol Hcl',1,'ex. Kores India Limited / INDIA','\0','29221990',0.00,'','','yudi','2018-03-14 08:28:33','yudi','2018-03-14 08:28:33'),(226,1,1,'Azithromycin Dihydrate',50,'ex. Anuh Pharma Limited/INDIA','\0','29419000 ',NULL,'','','akhiong','2018-03-16 08:24:42','akhiong','2018-03-16 08:24:42'),(227,1,1,'Eperisone',67,'ex. Syn-Tech Chem/TAIWAN','\0','29333990',NULL,'','','akhiong','2018-03-16 13:54:48','akhiong','2018-03-16 13:54:48'),(228,1,3,'DL- Choline Bitartrate',40,'Shenzhen Fast Chemical Co., Ltd/China','\0','29231000',25.00,'','','budy','2018-03-16 14:09:34','budy','2018-03-16 14:09:34'),(229,1,1,'Citicoline Sodium',11,'ex.  Suzhou Tianma /  CHINA','\0','29349990',20.00,'','','yudi','2018-03-19 14:48:27','yudi','2018-03-19 14:50:09'),(230,1,1,'Soy Isoflavone',94,'ex. Organic Herb Inc','\0','29232010',0.00,'','','yudi','2018-03-19 15:16:17','yudi','2018-03-19 15:20:51'),(231,1,1,'Fluoxetine Hcl Ph. Eur/BP. IH',23,'Cadila Pharmaceuticals Limited','\0','29221990',25.00,'','','budy','2018-03-21 10:48:38','budy','2018-03-21 10:48:38'),(232,1,1,'Pravastatin Sodium',43,'ex. Zhejiang Hisun / CHINA','\0','29181900',1.00,'','','yudi','2018-03-22 10:37:02','yudi','2018-03-22 10:39:02'),(233,1,1,'L-Carnitine Fumarate',95,'ex. Huanggang Huayang / CHINA','\0','29224900 ',1.00,'','','yudi','2018-03-22 14:46:45','yudi','2018-04-02 13:53:38'),(234,1,NULL,'Prochlorperazine Maleate',97,'ex. Mehta Pharmaceutical Industries / INDIA','\0','29343000',5.00,'','','yudi','2018-03-23 15:48:54','yudi','2018-03-23 15:48:54'),(235,1,1,'Salbutamol Sulphate BP',92,'ex. Jayco chemicals / INDIA','\0','29225090',10.00,'','','yudi','2018-03-26 10:44:51','yudi','2018-03-26 10:44:51'),(236,1,1,'Polydimethylsiloxane',86,'ex. Dasan Pharmaceuutical / KOREA','\0','0',0.00,'','','yudi','2018-03-29 15:22:40','yudi','2018-03-29 15:22:40'),(237,1,1,'Benserazide Hydrochloride Ph. Eur',19,'ex. RA  Chem Pharma Limited / INDIA','\0','29280090',0.00,'','','yudi','2018-04-03 10:15:01','yudi','2018-04-03 10:15:01');
/*!40000 ALTER TABLE `ms_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_productcategory`
--

DROP TABLE IF EXISTS `ms_productcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_productcategory` (
  `productCategoryID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Product Category ID',
  `ProductCategoryName` varchar(50) NOT NULL COMMENT 'Product Category Name',
  `coaNo` varchar(20) NOT NULL COMMENT 'COA No',
  `notes` varchar(100) DEFAULT NULL COMMENT 'Notes',
  `flagInventory` bit(1) DEFAULT NULL,
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`productCategoryID`),
  KEY `fk_msproductcategory_coano_idx` (`coaNo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_productcategory`
--

LOCK TABLES `ms_productcategory` WRITE;
/*!40000 ALTER TABLE `ms_productcategory` DISABLE KEYS */;
INSERT INTO `ms_productcategory` VALUES (1,'Persediaan Bahan Baku Obat','1119.0001','ini notes 2','','','admin','2016-11-04 13:33:36','admin','2017-06-16 02:26:34'),(2,'Persediaan Lain-Lain','1119.0003','Notes','','','admin','2016-11-11 16:15:13','admin','2017-06-16 02:26:41'),(3,'Persediaan Produk','1119.0004','','','','admin','2016-11-14 09:57:52','admin','2017-06-16 02:26:54'),(4,'Biaya','1119.0004','sddsds','\0','\0','admin','2017-03-08 14:21:02','admin','2017-08-10 14:45:19'),(5,'Ephedrine','1119.0004','','','\0','admin','2017-08-10 10:47:25','admin','2017-08-10 10:47:25'),(6,'Persediaan Barang Sample','1119.0005','','\0','','admin','2017-10-12 17:13:38','admin','2017-10-12 17:13:38');
/*!40000 ALTER TABLE `ms_productcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_productdetail`
--

DROP TABLE IF EXISTS `ms_productdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_productdetail` (
  `productDetailID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Product Detail ID',
  `productID` int(11) NOT NULL COMMENT 'Product ID',
  `uomID` int(11) NOT NULL COMMENT 'UOM ID',
  `packingTypeID` int(11) NOT NULL,
  `uomQty` decimal(18,2) NOT NULL,
  `buyPrice` decimal(18,2) NOT NULL COMMENT 'Buy Price',
  `sellPrice` decimal(18,2) NOT NULL COMMENT 'Sell Price',
  PRIMARY KEY (`productDetailID`),
  KEY `productID` (`productID`),
  KEY `uomID` (`uomID`),
  KEY `ms_productdetail_packingtype_idx` (`packingTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_productdetail`
--

LOCK TABLES `ms_productdetail` WRITE;
/*!40000 ALTER TABLE `ms_productdetail` DISABLE KEYS */;
INSERT INTO `ms_productdetail` VALUES (1,1,1,1,25.00,0.00,0.00),(3,4,1,1,25.00,25.00,0.00),(4,5,1,1,25.00,59.00,0.00),(5,6,2,8,1.00,0.00,0.00),(6,7,1,1,1.00,4000.00,0.00),(8,9,1,7,25.00,0.00,0.00),(10,11,1,6,5.00,0.00,0.00),(11,12,1,6,25.00,0.00,0.00),(12,13,1,9,10.00,0.00,0.00),(13,14,1,1,25.00,94.75,0.00),(14,15,1,6,50.00,0.00,0.00),(15,16,1,7,25.00,0.00,0.00),(16,17,1,6,25.00,94.75,0.00),(17,18,1,6,10.00,1000.00,0.00),(18,19,1,6,25.00,52.00,0.00),(19,20,1,6,25.00,60.00,0.00),(20,21,1,7,25.00,81.00,0.00),(21,22,1,10,25.00,81.00,0.00),(22,23,1,10,5.00,870.00,0.00),(23,24,1,6,5.00,1400.00,0.00),(24,25,1,10,25.00,90.00,2250.00),(25,26,1,6,5.00,775.00,0.00),(26,28,1,6,280.00,5.00,11200.00),(27,29,1,6,20.00,240.00,19200.00),(28,30,1,1,25.00,25.00,625.00),(29,31,1,6,25.00,0.00,0.00),(31,27,1,6,5.00,775.00,0.00),(32,34,1,6,10.00,0.00,0.00),(33,35,1,6,40.00,0.00,0.00),(34,36,1,6,2.00,0.00,0.00),(35,37,1,6,1.00,0.00,0.00),(36,38,1,10,25.00,0.00,0.00),(37,39,1,6,5.00,0.00,0.00),(39,41,1,6,25.00,0.00,0.00),(40,42,1,6,25.00,0.00,0.00),(41,43,1,6,25.00,0.00,0.00),(42,44,1,6,2.00,0.00,0.00),(43,45,3,6,100.00,0.00,0.00),(44,46,1,10,25.00,0.00,0.00),(45,47,1,6,25.00,0.00,0.00),(46,48,1,14,2.00,0.00,0.00),(47,49,3,6,100.00,0.00,0.00),(48,50,1,6,1.00,0.00,0.00),(49,51,1,15,1.00,0.00,0.00),(50,52,1,14,1.00,0.00,0.00),(51,53,1,13,1.00,0.00,0.00),(55,57,5,19,500.00,0.00,0.00),(56,58,1,6,25.00,151.00,0.00),(58,60,3,6,100.00,4.00,0.00),(59,61,1,1,30.00,0.00,0.00),(60,62,1,3,1.00,0.00,0.00),(61,63,3,8,100.00,0.00,0.00),(62,64,1,14,100.00,0.00,0.00),(63,65,1,6,5.00,800.00,0.00),(64,66,1,6,25.00,100.00,0.00),(65,67,1,10,10.00,0.00,0.00),(66,68,1,6,3.00,0.00,0.00),(67,69,1,10,25.00,0.00,0.00),(68,70,1,10,10.00,0.00,0.00),(69,71,1,10,25.00,0.00,0.00),(70,72,1,10,25.00,0.00,0.00),(71,73,1,10,25.00,0.00,0.00),(72,74,1,14,10.00,0.00,0.00),(73,75,1,6,5.00,0.00,0.00),(74,76,1,6,5.00,0.00,0.00),(75,77,1,6,4.00,0.00,0.00),(76,78,1,10,10.00,0.00,0.00),(77,79,1,10,5.00,0.00,0.00),(78,80,1,6,25.00,0.00,0.00),(79,81,1,10,10.00,0.00,0.00),(80,82,1,10,5.00,0.00,0.00),(81,83,1,6,10.00,0.00,0.00),(82,84,1,6,25.00,0.00,0.00),(83,85,1,6,25.00,0.00,0.00),(84,86,1,9,1.00,0.00,0.00),(85,87,1,6,1.00,0.00,0.00),(86,88,1,6,25.00,0.00,0.00),(87,89,1,10,10.00,0.00,0.00),(88,90,1,6,25.00,0.00,0.00),(89,91,1,10,25.00,0.00,0.00),(90,92,1,9,100.00,0.00,0.00),(91,93,3,6,10.00,0.00,0.00),(92,94,1,13,2.00,0.00,0.00),(93,95,1,11,0.50,2000.00,0.00),(94,96,1,6,25.00,0.00,0.00),(95,97,1,10,10.00,0.00,0.00),(96,98,1,6,5.00,0.00,0.00),(97,99,1,6,2.00,0.00,0.00),(98,100,1,10,1.00,0.00,0.00),(99,101,1,10,25.00,0.00,0.00),(100,102,3,9,100.00,0.00,0.00),(101,103,1,9,1.00,0.00,0.00),(102,104,1,6,10.00,0.00,0.00),(103,105,1,6,10.00,0.00,0.00),(104,106,1,10,25.00,0.00,0.00),(105,107,1,10,25.00,0.00,0.00),(106,108,1,10,25.00,0.00,0.00),(107,109,1,10,1.50,0.00,0.00),(108,110,1,14,5.00,0.00,0.00),(109,111,1,6,1.00,0.00,0.00),(110,112,1,6,2.00,0.00,0.00),(111,113,1,10,25.00,0.00,0.00),(112,114,1,6,280.00,0.00,0.00),(113,115,1,13,5.00,0.00,0.00),(114,116,1,10,10.00,0.00,0.00),(115,117,1,10,10.00,0.00,0.00),(116,118,1,13,5.00,0.00,0.00),(117,119,5,13,250.00,0.00,0.00),(118,120,1,10,10.00,0.00,0.00),(119,121,1,13,10.00,0.00,0.00),(120,122,3,13,200.00,0.00,0.00),(121,123,1,1,1.00,0.00,0.00),(122,124,1,6,25.00,0.00,0.00),(123,125,1,3,1.00,0.00,0.00),(125,127,1,1,20.00,0.00,0.00),(126,128,1,14,5.00,210.00,0.00),(127,129,1,6,25.00,0.00,0.00),(128,130,1,10,25.00,0.00,0.00),(129,131,1,10,25.00,0.00,0.00),(130,132,1,8,6.00,0.00,0.00),(131,133,1,10,25.00,0.00,0.00),(132,134,1,6,5.00,0.00,0.00),(133,135,1,14,5.00,0.00,0.00),(134,136,1,10,25.00,0.00,0.00),(135,137,1,8,5.00,0.00,0.00),(136,138,1,6,25.00,0.00,0.00),(138,140,1,6,25.00,0.00,0.00),(139,141,1,6,25.00,0.00,0.00),(140,142,1,6,1.00,0.00,0.00),(141,143,3,13,10.00,0.00,0.00),(142,144,1,6,50.00,0.00,0.00),(143,145,1,6,25.00,20.50,0.00),(144,146,1,6,25.00,0.00,0.00),(145,147,1,13,50.00,0.00,0.00),(146,148,1,13,10.00,0.00,0.00),(147,149,1,13,5.00,0.00,0.00),(149,151,3,13,50.00,0.00,0.00),(150,152,1,6,5.00,0.00,0.00),(151,153,1,6,10.00,0.00,0.00),(152,154,1,13,1.00,0.00,0.00),(153,155,1,6,25.00,0.00,0.00),(154,156,1,13,2.00,0.00,0.00),(155,157,1,10,10.00,0.00,0.00),(156,158,5,19,500.00,0.00,0.00),(157,159,5,13,20.00,0.00,0.00),(158,160,1,13,25.00,0.00,0.00),(159,161,1,6,5.00,0.00,0.00),(160,162,1,6,10.00,0.00,0.00),(161,163,1,10,25.00,0.00,0.00),(162,164,1,10,25.00,0.00,0.00),(163,165,1,10,1.00,0.00,0.00),(164,166,1,10,1.00,0.00,0.00),(165,167,1,14,1.00,0.00,0.00),(166,168,1,1,1.00,2.00,3.00),(167,169,1,10,25.00,0.00,0.00),(168,170,1,20,0.00,0.00,0.00),(169,171,1,1,25.00,140.00,0.00),(170,172,1,10,5.00,0.00,0.00),(171,173,1,10,5.00,0.00,0.00),(172,174,1,1,15.00,330.00,0.00),(173,175,1,1,25.00,58.00,0.00),(174,176,1,10,25.00,0.00,0.00),(175,177,1,1,5.00,0.00,0.00),(176,178,1,1,25.00,46.00,0.00),(177,179,1,1,5.00,0.00,0.00),(178,180,1,1,10.00,0.00,0.00),(179,181,1,1,25.00,79.00,0.00),(180,182,1,6,25.00,0.00,0.00),(181,183,1,6,25.00,0.00,0.00),(182,184,1,6,25.00,0.00,0.00),(183,185,1,6,280.00,0.00,0.00),(184,186,1,6,25.00,0.00,0.00),(185,187,1,6,40.00,0.00,0.00),(186,188,1,10,25.00,0.00,0.00),(187,189,1,1,25.00,0.00,0.00),(188,190,1,1,25.00,0.00,0.00),(189,191,6,10,20.00,49.00,0.00),(190,192,1,10,25.00,37.50,0.00),(191,193,1,6,5.00,1750.00,0.00),(192,194,1,6,10.00,380.00,0.00),(193,195,1,1,25.00,220.00,0.00),(194,196,1,1,2.00,0.00,0.00),(195,197,1,6,25.00,0.00,0.00),(196,198,1,6,0.00,0.00,0.00),(197,199,1,20,0.00,0.00,0.00),(198,200,1,10,0.00,0.00,0.00),(199,201,1,6,1.00,0.00,0.00),(200,202,1,3,0.00,0.00,0.00),(201,203,3,19,100.00,0.00,0.00),(202,204,3,19,100.00,0.00,0.00),(203,205,5,16,500.00,0.00,0.00),(204,206,1,1,25.00,0.00,0.00),(205,207,1,6,10.00,0.00,0.00),(206,208,1,6,25.00,0.00,0.00),(207,209,1,10,25.00,0.00,0.00),(208,210,1,6,25.00,0.00,0.00),(209,211,1,10,2.00,0.00,0.00),(210,212,1,10,5.00,0.00,0.00),(211,213,1,10,25.00,0.00,0.00),(212,214,1,1,1.00,0.00,0.00),(213,215,1,10,25.00,0.00,0.00),(214,216,1,6,1.00,0.00,0.00),(215,217,1,11,1.00,0.00,0.00),(216,218,1,10,25.00,0.00,0.00),(217,219,1,6,25.00,0.00,0.00),(218,220,3,6,0.00,0.00,0.00),(219,221,1,6,25.00,0.00,0.00),(220,222,1,6,5.00,0.00,0.00),(221,223,3,9,100.00,0.00,0.00),(222,224,1,10,25.00,0.00,0.00),(223,225,1,6,25.00,0.00,0.00),(224,226,1,6,25.00,0.00,0.00),(225,227,1,10,25.00,0.00,0.00),(226,228,1,10,25.00,0.00,0.00),(227,229,1,10,20.00,0.00,0.00),(228,230,1,1,25.00,0.00,0.00),(229,231,1,6,25.00,0.00,0.00),(230,232,1,14,1.00,1350.00,0.00),(231,233,1,10,1.00,0.00,0.00),(232,234,1,6,5.00,0.00,0.00),(233,235,1,6,10.00,0.00,0.00),(234,236,3,3,0.00,0.00,0.00),(235,237,1,3,0.00,0.00,0.00);
/*!40000 ALTER TABLE `ms_productdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_productsupplier`
--

DROP TABLE IF EXISTS `ms_productsupplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_productsupplier` (
  `productID` int(11) NOT NULL COMMENT 'Product ID',
  `supplierID` int(11) NOT NULL COMMENT 'Supplier ID'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_productsupplier`
--

LOCK TABLES `ms_productsupplier` WRITE;
/*!40000 ALTER TABLE `ms_productsupplier` DISABLE KEYS */;
INSERT INTO `ms_productsupplier` VALUES (1,1),(2,3),(3,3),(4,4),(5,4),(6,10),(7,22),(8,3),(9,3),(10,4),(11,23),(12,23),(13,14),(14,16),(15,4),(16,11),(17,16),(18,4),(19,12),(20,4),(21,11),(22,12),(23,4),(24,2),(25,21),(26,26),(27,4),(28,4),(29,27),(30,11),(31,30),(32,32),(33,32),(34,23),(35,2),(36,33),(37,34),(38,11),(39,36),(40,2),(41,37),(42,39),(43,39),(44,41),(45,14),(46,11),(47,15),(48,2),(49,14),(50,34),(51,42),(52,42),(53,43),(54,14),(55,14),(56,14),(57,14),(58,4),(59,14),(60,14),(61,46),(62,45),(63,9),(64,2),(65,14),(66,19),(67,17),(68,17),(69,40),(70,11),(71,11),(72,11),(73,11),(74,43),(75,47),(76,36),(77,33),(78,40),(79,40),(80,41),(81,18),(82,48),(83,49),(84,18),(85,66),(86,14),(87,64),(88,36),(89,9),(90,51),(91,11),(92,14),(93,52),(94,53),(95,14),(96,35),(97,54),(98,18),(99,58),(100,55),(101,40),(102,14),(103,14),(104,57),(105,47),(106,18),(107,2),(108,43),(109,69),(110,40),(111,18),(112,39),(113,59),(114,18),(115,17),(116,46),(117,60),(118,18),(119,18),(120,62),(121,9),(122,13),(123,12),(124,27),(125,19),(126,2),(127,2),(128,9),(129,57),(130,11),(131,11),(132,11),(133,11),(134,70),(135,70),(136,40),(137,43),(138,70),(139,17),(140,57),(141,17),(142,34),(143,57),(144,70),(145,38),(146,19),(147,9),(148,9),(149,4),(150,4),(151,71),(152,5),(153,16),(154,70),(155,61),(156,72),(157,40),(158,14),(159,13),(160,16),(161,63),(162,4),(163,19),(164,11),(165,74),(166,54),(167,9),(168,1),(169,43),(170,48),(171,11),(172,48),(173,48),(174,2),(175,2),(176,78),(177,79),(178,58),(179,36),(180,23),(181,11),(182,2),(183,16),(184,2),(185,70),(186,16),(187,2),(188,43),(189,43),(190,19),(191,40),(192,40),(193,70),(194,27),(195,40),(196,2),(197,16),(198,16),(199,45),(200,70),(201,70),(202,45),(203,14),(204,14),(205,14),(206,86),(207,16),(208,17),(209,11),(210,87),(211,70),(212,88),(213,80),(214,70),(215,11),(216,89),(217,44),(218,90),(219,27),(220,92),(221,91),(222,93),(223,14),(224,11),(225,1),(226,50),(227,67),(228,40),(229,11),(230,94),(231,23),(232,43),(233,95),(234,97),(235,92),(236,86),(237,19);
/*!40000 ALTER TABLE `ms_productsupplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_reason`
--

DROP TABLE IF EXISTS `ms_reason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_reason` (
  `mapReasonID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Map Reason ID',
  `mapReasonName` varchar(50) NOT NULL COMMENT 'Map Reason Name',
  `coaNo` varchar(20) NOT NULL COMMENT 'COA No',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`mapReasonID`),
  KEY `coaNoConstrain_idx` (`coaNo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_reason`
--

LOCK TABLES `ms_reason` WRITE;
/*!40000 ALTER TABLE `ms_reason` DISABLE KEYS */;
INSERT INTO `ms_reason` VALUES (1,'Reason 0001','1110.0003','','admin','2016-11-11 16:20:13','admin','2016-11-11 16:26:06'),(2,'QA','1510.0005','','admin','2017-03-08 14:32:48','admin','2017-03-08 14:33:11'),(3,'QA ','1510.0009','\0','admin','2017-03-14 09:59:36','admin','2017-03-14 09:59:36'),(4,'Inventory Kantor','1410.0006','','admin','2017-07-07 11:33:49','admin','2017-07-07 11:33:49');
/*!40000 ALTER TABLE `ms_reason` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_reportdestination`
--

DROP TABLE IF EXISTS `ms_reportdestination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_reportdestination` (
  `reportDestinationID` int(11) NOT NULL AUTO_INCREMENT,
  `reportDestinationName` varchar(100) NOT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`reportDestinationID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_reportdestination`
--

LOCK TABLES `ms_reportdestination` WRITE;
/*!40000 ALTER TABLE `ms_reportdestination` DISABLE KEYS */;
INSERT INTO `ms_reportdestination` VALUES (1,'Kemenperindag','admin','2017-02-20 16:35:03','admin','2017-02-20 16:35:03'),(2,'Gedung A','admin','2017-02-21 17:11:35','admin','2017-02-21 17:11:35'),(3,'Cabang A','admin','2017-03-08 15:06:33','admin','2017-04-25 12:01:16'),(4,'KEMENKES','admin','2017-08-10 15:09:40','admin','2017-08-10 15:09:40'),(5,'NAPZA','admin','2017-08-10 15:09:53','admin','2017-08-10 15:09:53'),(6,'OOT','admin','2017-08-10 15:10:01','admin','2017-08-10 15:10:01');
/*!40000 ALTER TABLE `ms_reportdestination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_setting`
--

DROP TABLE IF EXISTS `ms_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_setting` (
  `key1` varchar(100) NOT NULL COMMENT 'Key 1',
  `key2` varchar(100) DEFAULT NULL COMMENT 'Key 2',
  `value1` varchar(100) DEFAULT NULL COMMENT 'Value 1',
  `value2` varchar(100) DEFAULT NULL COMMENT 'Value 2',
  PRIMARY KEY (`key1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_setting`
--

LOCK TABLES `ms_setting` WRITE;
/*!40000 ALTER TABLE `ms_setting` DISABLE KEYS */;
INSERT INTO `ms_setting` VALUES ('CellPhone','Director Cell Phone','+62 816724905','text'),('City','City','Jakarta Barat','text'),('CompanyAttn','Company Atttendant','Nurdin Wijaya','text'),('CompanyAttnEmail','Attendant Email','nurdin.wijaya@qwinjaya.com','text'),('CompanyDirector','Company Director','Nurdin Wijaya','text'),('CompanyName','Company Name','PT.  Qwinjaya Aditama','text'),('Country','Country','Indonesia','text'),('Fax','Fax','+6221 58355060','text'),('FinancePIC','Finance Dept. PIC','Feti Ratnasari','text'),('IjinITPrekursorFarmasi','Ijin IT Prekursor Farmasi No','HK.02.06.IT/V/323/16','text'),('IjinPedagangFarmasi','Ijin Pedagang Besar Farmasi No','HK.07.01.BO/V/405/13','text'),('IjinPsikotropika','Ijin Importir Terdaftar Psikotropika','HK.02.06.IT-P/V/325/16','text'),('ImportPIC','Import Dept. PIC','Wong Foen Khiong','text'),('ImportTax','Import Tax','10','number'),('Kecamatan','Kecamatan','Kebon Jeruk','text'),('Kelurahan','Kelurahan','Kelurahan Kedoya Utara','text'),('NPWP','NPWP','02.751.136.9-039.000','text'),('OfficeAddress','Company Address','Komplek Pertokoan Green Garden Blok A7  No.6\r\nKedoya Utara, Kebon Jeruk, Jakarta Barat 11520\r\n','textarea'),('PharmacistName','Pharmacist Name','Merry,S.Farm,Apt.','text'),('PharmacistNumber','Pharmacist Number','SIKA No. 006/2.35.1/31.73.05/-1.779.3/2016','text'),('Phone1','Phone 1','+6221 5802720','text'),('Phone2','Phone 2','+6221 58357791','text'),('Phone3','Phone 3','+6221 58306106','text'),('Phone4','Phone 4','+6221 58306107','text'),('PostalCode','Postal Code','11520','text'),('Province','Province','DKI Jakarta','text'),('SalesAdmin1','Sales Admin I','Yudi Ananto','text'),('SamplingPIC','Sampling PIC','Ahmad Setiawan','text'),('WarehousePIC','Warehouse PIC','Budiyanto','text');
/*!40000 ALTER TABLE `ms_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_subcategory`
--

DROP TABLE IF EXISTS `ms_subcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_subcategory` (
  `subcategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `subcategoryName` varchar(50) NOT NULL,
  `flagActive` bit(1) NOT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`subcategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_subcategory`
--

LOCK TABLES `ms_subcategory` WRITE;
/*!40000 ALTER TABLE `ms_subcategory` DISABLE KEYS */;
INSERT INTO `ms_subcategory` VALUES (1,'Bahan Obat','','admin','2017-08-04 08:50:31','admin','2017-08-04 08:50:31'),(2,'OOT','','admin','2017-08-04 08:50:43','admin','2017-08-04 08:50:43'),(3,'Suplemen Kesehatan','','admin','2017-08-04 08:50:57','admin','2017-08-04 08:50:57'),(4,'Psikotropika','','admin','2017-08-04 08:51:07','admin','2017-08-04 08:51:07'),(5,'Prekursor','','admin','2017-08-10 10:45:27','admin','2017-08-10 10:45:27'),(6,'HS OT Kos','','admin','2017-08-10 10:45:49','admin','2017-08-10 10:45:49'),(7,'Bahan Kimia BPOM Lt.4','','admin','2017-10-19 14:38:09','admin','2017-10-19 14:38:09'),(8,'Bahan Baku Pembanding','','admin','2017-10-19 15:04:30','admin','2017-10-19 15:04:30');
/*!40000 ALTER TABLE `ms_subcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_supplier`
--

DROP TABLE IF EXISTS `ms_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_supplier` (
  `supplierID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Supplier ID',
  `supplierName` varchar(200) NOT NULL COMMENT 'Supplier Name',
  `isForwarder` bit(1) NOT NULL,
  `country` varchar(50) DEFAULT NULL COMMENT 'Country',
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `street` varchar(200) DEFAULT NULL COMMENT 'Address',
  `postalCode` varchar(10) DEFAULT NULL,
  `officeNumber` varchar(200) DEFAULT NULL,
  `factoryNumber` varchar(200) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL COMMENT 'Fax',
  `mobile` varchar(200) DEFAULT NULL COMMENT 'Mobile',
  `email` varchar(200) DEFAULT NULL COMMENT 'Email',
  `url` varchar(50) DEFAULT NULL COMMENT 'URL WEBSITE',
  `npwp` varchar(50) DEFAULT NULL COMMENT 'NPWP',
  `npwpAddress` varchar(200) DEFAULT NULL COMMENT 'NPWP Address',
  `npwpRegisteredDate` datetime DEFAULT NULL COMMENT 'NPWP Registered Date',
  `notes` varchar(200) DEFAULT NULL COMMENT 'Notes',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`supplierID`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_supplier`
--

LOCK TABLES `ms_supplier` WRITE;
/*!40000 ALTER TABLE `ms_supplier` DISABLE KEYS */;
INSERT INTO `ms_supplier` VALUES (1,'Kores (India) Limited','\0','India','','','C-7/1-B, T.T.C  Industrial Area\r\nMIDC Pawane, Navi Mumbai - 400705','','+91 22 27613455 / 6138 9035 / 6138 9000','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.korescd.com','','',NULL,'','','admin','2017-08-04 09:04:35','vetty','2018-01-24 14:36:20'),(2,'Verben S.A','\0','Switzerland','','','Via F.Pelli 17\r\nP.O. Box\r\n6901 Lugano','','+41 91 973 21 01','',NULL,'','Marinella.Frigerio@ChemoLugano','','','',NULL,'','','admin','2017-08-04 09:05:21','yudi','2018-03-21 16:42:07'),(3,'Andard-Mount Company Limited','\0','','','','20 Hanover Square, London, W1S 1JY\r\nUnited Kingdom\r\n','','+44 20 8991 5150   ','',NULL,'','mwing@andardmount.co.uk ,  jasmit@andardmount.co.uk','www.andardmount.com','','',NULL,'','','admin','2017-08-04 09:05:45','vetty','2018-01-25 14:23:54'),(4,'Aastrid International Pvt Ltd','\0','India','','','247-248 , Udyog Bhavan, Sonawala Road,\r\nGoregaon (East)\r\nMumbai 400063','','+91 22 42552525','',NULL,'+91 9867890077','ravi.jagtap@aastrid.com ,  dipti.kanvinde@aastrid.com','www.aastrid.com','','',NULL,'','','admin','2017-08-04 09:06:04','vetty','2018-01-25 14:22:53'),(5,'Suzhou Fushilai Pharmaceutical Co., Ltd','\0','China','','Jiangsu','No.16, Haiwang Rd., Changshu Advanced Material Industrial Park','','+86 512 52838772 ','',NULL,'+86 13901575733  ','sales@fuslai.com , slp@fushilai.com.cn','www.fuslai.com   ','','',NULL,'','','admin','2017-08-04 09:10:45','vetty','2018-01-24 14:31:23'),(6,'PT. Jebea Carlos','','Indonesia','','Jakarta Barat','Ruko Garden Shopping Arcade Blok B No.8DH\r\n','','021 - 88874826 / 021 - 88979729','',NULL,'0858 1077 3535','benadi71@gmail.com','','','',NULL,'','','admin','2017-08-10 11:21:23','vetty','2018-01-18 16:22:25'),(7,'PT. Gema Sangkakala Anugrah','','Indonesia','DKI Jakarta','Jakarta','Jl. Tanah Abang III No. 1','','021-3843085','',NULL,'0897 7759 931','airfreight@gemasangkakala.com','','01.326.125.0-028.000','Jl. Tanah Abang III No. 1, Petojo Selatan, Jakarta Pusat',NULL,'','','admin','2017-08-10 11:21:31','yudi','2018-03-23 14:38:00'),(8,'PT Waris','','Indonesia','','Jakarta','Jl. Haji Ten No. 41 ','13220','021 4898301 / 05','',NULL,'','ptwaris@cbn.net.id','','','',NULL,'','','admin','2017-08-10 11:56:58','admin','2017-12-21 14:19:03'),(9,'Biovia Pte Ltd','\0','Singapore 179098','','','111, North Bridge Road,\r\n#27-01/02, Peninsula Plaza\r\n\r\n','','+65 68543712','',NULL,'+65 81392429','mohan@biovia.com.sg','','','',NULL,'','','admin','2017-08-10 14:23:38','vetty','2018-01-24 14:46:31'),(10,'PT.  Jasa Angkasa Semesta (JAS)','','Indonesia','DKI Jakarta','Jakarta','Warehouse - Soekarno-Hatta Airport','','','',NULL,'','','','01.065.322.8-005.000','Menara Cardig Lt.3, RT. 011 RW. 008\r\nJL. Raya Halim Perdanakusuma, Kebon Pala, Jakarta Timur',NULL,'','','admin','2017-08-10 14:36:59','admin','2018-01-04 11:49:58'),(11,'Shaoxing Hantai Pharmaceutical Co.,Ltd.','\0','China PC : 312500','','','No. 10B-6 Jiayi Plaza,\r\nNo.127, Renming E. Road,\r\nXinchang, Zhejiang','','+86 575 86165129','',NULL,'+86 13116856377','tracy.zhang@hantaipharm.com , hantai_victor@yahoo.com','www.hantaipharm.com','','',NULL,'','','admin','2017-08-11 14:14:35','vetty','2018-01-18 16:43:00'),(12,'Panaaya  Pharma  Pvt Ltd','\0','India','','','F-19/20, Varalaxmi Complex, MG Road\r\nSecunderabad 500003','','+91 40 40170586','',NULL,'','panaaya@gmail.com','','','',NULL,'','','admin','2017-08-11 14:17:37','vetty','2018-01-24 14:38:34'),(13,'Shaanxi Yuanbang Bio Tech Co.,Ltd','\0','China','','','Rm 1007, Huixin IBC-B, No.1,\r\nZhangba 1st Road, Xi\'an 710065','','+86 29 8889 7680 - 101','',NULL,'+86 18691638389','kobe@yb-bio.com','www.yb-bio.com','','',NULL,'','','admin','2017-08-11 14:20:42','vetty','2018-01-24 14:29:48'),(14,'Symbiotica Speciality Ingredients Sdn.Bhd.','\0','Malaysia','','','#3-9-B, NB Plaza, No. 3000\r\nJalan Baru Perai, Pulau Pinang','13700','+604 397 9799','',NULL,'','mohan@biovia.com.sg , marketing1@symbiotica.com.my','','','',NULL,'','','admin','2017-08-11 14:24:17','vetty','2018-01-22 16:05:55'),(15,'Vaikunth Chemicals (Pvt.) Ltd.,','\0','INDIA','','','Plot No. 408/4 & 5, Nr. Fire Station,\r\nGIDC Panoli - 394116, Ta: Ankleshwar,\r\nDist. Bharuch, Gujarat','','+91 2646 272289','',NULL,'','shantanu@cosmigen.com , reena@cosmigen.com','www.vaikunthchemicals.com','','',NULL,'','','admin','2017-08-11 14:28:02','vetty','2018-01-22 16:06:58'),(16,'Jaysons Api Pharma','\0','India','','','3, Nafar Kundu Road, 2nd Floor\r\nRoom No. 2C, Near Paramount Nursing Home\r\nKolkata 700026','','','',NULL,'','paras.kamdar@jaysonsapi.com','','','',NULL,'','','admin','2017-08-11 14:30:50','vetty','2018-01-24 14:40:38'),(17,'CTX Lifesciences Pvt.Ltd','\0','India','','','Block No.251-252, Sachin Magdalla Road\r\nGIDC, Sachin, Surat 394230, Gujarat\r\n','','+91 261 2399669','',NULL,'','','','','',NULL,'','','admin','2017-08-11 14:33:18','vetty','2018-02-07 08:09:03'),(18,'Aarti Drugs Ltd','\0','India','','','Plot No. 109-D, Mahendra Industrial Estate,\r\nGround Floor, Road No. 29, Sion (E)\r\nMumbai 400022','','+91 22 24072249','',NULL,'','','www.aartidrugs.com','','',NULL,'','','admin','2017-08-11 14:36:10','vetty','2018-01-25 14:22:26'),(19,'Ra Chem Pharma Limited','\0','India','','','Plot No. A-19/C, Road No.18\r\nIDA , Nacharam, Hyderabad 500076\r\nTelangana','','+91 40 23443700','',NULL,'+91 9652216217','ashraf@rachempharma.com, rajesh@rachempharma.com','www.rachempharma.com','','',NULL,'','','admin','2017-08-11 14:38:49','vetty','2018-01-24 15:34:00'),(20,'Hikal Limited','\0','India','','','100% EOU Unit, 82/A, KIADB Industrial Area\r\nJigani, Anekal Taluk,\r\nBangalore 560105, Karnataka','','+91 80 39861100','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com, nehaldesai@vitalchemie.com','','','',NULL,'','','admin','2017-08-11 14:41:43','vetty','2018-01-24 14:42:26'),(21,'Medilux Laboratories Pvt Ltd','\0','India','','','Plot No. 98-99, Sector-1, Industrial Area,\r\nPithampur 454775, Dist. Dhar, (M.P.)','','+91 7292409991 / 92','',NULL,'','marketing@medilux.co.in, romi@medilux.co.in','www.medilux.co.in','','',NULL,'','','admin','2017-08-11 15:15:17','vetty','2018-01-24 14:37:06'),(22,'Cambrex Profarmaco Milano S.r.l','\0','','','','Via E. Curiel, 34 - 20067 \r\nPaullo MI - Italy\r\n\r\n','','+39 02 345988.1','',NULL,'','','www.cambrex.com','','',NULL,'','','admin','2017-08-11 15:26:46','yudi','2018-02-22 15:40:04'),(23,'Tradewell Corporation','\0','India','','','Godown No. 3,H.No.207, 1st Floor,Cabin G\r\nHari Niwas,Oswal Compund, Purna Village\r\nPurna, Bhiwandi, Dist. Thane 421302','','','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-08-14 09:57:25','vetty','2018-01-24 14:32:59'),(24,'Zhejiang Excel Pharmaceutical Co., Ltd.','\0','China','','Zhejiang','9 Dazha Road, Huangyan Economic Development Zone\r\nTaizhou\r\n\r\n','318020','+86 576 84160008','',NULL,'','','','','',NULL,'','','admin','2017-08-14 10:50:28','vetty','2018-01-24 14:28:56'),(25,'Century Pharmaceuticals Limited','\0','India','','','406 World Trade Centre, Sayajigunj\r\nVadodara 390005\r\n','','+91 265 2361581','',NULL,'+ 91 9930293555','shantanu@cosmigen.com , reena@cosmigen.com','','','',NULL,'','','admin','2017-08-15 14:26:45','vetty','2018-01-24 14:47:55'),(26,'Lake Chemicals Pvt Ltd','\0','India','','','Prestige Atrium, 6th Level, Unit No. 603, No.1 , Central Street\r\nOpp Empire Hotel, Shivajinagar\r\nBangalore 560001\r\n','','','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-08-15 16:22:04','vetty','2018-01-25 14:39:51'),(27,'Anzen Exports','\0','India','','','157, Sarat Bose Road\r\nKolkata 700026, West Bengal','','+91 33 24659650 / 51','',NULL,'+91 9831008727','mayur@anzen.co.in, mahua@anzen.co.in , manish@anzen.co.in','www.anzen.co.in','','',NULL,'','','admin','2017-08-16 15:01:13','vetty','2018-01-24 14:52:06'),(28,'Sri Krishna Pharmaceuticals Limited','\0','India','','','C-4, Industrial Area , Uppal\r\nHyderabad 500039, Telangana','','+91 40 2717 7823 - 26','',NULL,'+91 9848388036','ramarao@srikrishnapharma.com , vrameshkumar@srikrishnapharma.com','www.srikrishnapharma.com','','',NULL,'','','admin','2017-09-12 16:07:48','vetty','2018-01-24 14:30:35'),(29,'Pharmatec Co.,Ltd','\0','Japan','','','Kashima Shokan BLDG. 9F\r\n1-1, Nihonbashi Hon-cho 4-chome, Chuo-ku, \r\nTokyo 103-0023','','+81 3 3279 0200','',NULL,'','tabei@pharmatec.co.jp','www.pharmatec.co.jp','','',NULL,'','','admin','2017-09-12 16:11:16','vetty','2018-01-24 14:38:49'),(30,'Xiamen Tianhongxiang Trade Co.,Ltd','\0','','','','Room 806, No. 297- 1 Jiahe Road, Siming District\r\nXiamen - China\r\n','','+86 592 5068676','',NULL,'','sales@natural-extract.com','','','',NULL,'','','admin','2017-09-19 14:17:31','vetty','2018-01-25 15:15:24'),(31,'Baselux  S.A.','','Switzerland','','','Corso Elvezia 16, CH - 6900\r\nLugano\r\n','','+41 91 910 1820','',NULL,'','marinella.frigerio@chemolugano.com','','','',NULL,'','','admin','2017-09-19 15:01:42','vetty','2018-01-24 14:46:16'),(32,'Caterchem Gmbh','\0','Austria','','','1010  Wien\r\nBorseplatz 4\r\nWien\r\n','','','',NULL,'','','','','',NULL,'','','admin','2017-09-19 15:09:21','vetty','2018-01-24 14:47:39'),(33,'RPG Life Sciences Limited','\0','India','','','25 MIDC Land, Thane Belapur Road,\r\nNavi Mumbai 400705','','','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.rpglifesciences.com','','',NULL,'','','admin','2017-09-28 11:42:38','yudi','2018-01-31 08:41:13'),(34,'Vital Laboratories Pvt Ltd','\0','India','','','Plot No. 48, 2nd Floor, Service Road Western\r\nExpress Highway, Nr Hanuman Temple Vile Parle East\r\nMaharashtra 400057','','+91 22 26183641','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-09-28 11:50:46','vetty','2018-01-25 15:12:59'),(35,'Emcure Pharmaceuticals Limited','\0','India','','','Plot No. 12/2, M.I.D.C. Pimpri,\r\nPune 411018, Maharashtra','','+91 20 33750000','',NULL,'+91 9823162427','tushar.budukh@emcure.co.in, ravindra.kothi@emcure.co.in , Rahul.joglekar@emcure.co.in','www.emcure.co.in','','',NULL,'','','admin','2017-09-28 12:00:35','vetty','2018-01-24 14:43:19'),(36,'Vasudha Pharma Chem Limited','\0','India','','','78/A, Vengalrao Nagar,\r\nHyderabad 500038 , Telangana','','+91 40 44763666','',NULL,'+99 63913974','vasudha@vasudhapharma.com, logisticsexports@vasudhapharma.com','www.vasudhapharma.com','','',NULL,'','','admin','2017-09-28 13:36:17','vetty','2018-01-25 14:18:50'),(37,'Granules India Limited','\0','India','','','2nd Floor, 3 rd Block,\r\nMy Home Hub, Madhapur\r\nHyderabad, 500081(TS)','','+91 40 3066 0000','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.granulesindia.com','','',NULL,'','','admin','2017-09-28 14:02:54','vetty','2018-01-24 14:44:03'),(38,'Smilax Laboratories Limited','\0','India','','','Plot No.12A, Phase III, I.D.A,\r\nJeedimetla, Hyderabad 500055','','+91 40 23090260','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.smilaxlabs.com','','',NULL,'','','admin','2017-09-28 14:08:03','vetty','2018-01-24 14:30:19'),(39,'Atman Pharmaceuticals','\0','India','','','101 & 102 Mewad, 1st Floor,E.S. Patanwala Complex,\r\nOpp Shreyas Cinema, Ghatkopar [W]\r\nMumbai - 400086','','+91 22 25004461/ 2/3','',NULL,'+91 9987555125','atman.parekh@atman.net.in , atman@atman.net.in','www.atman.net.in','','',NULL,'','','admin','2017-09-28 14:18:53','vetty','2018-01-24 14:52:46'),(40,'Hangzhou Dongjin Import & Export .Co.,Ltd','\0','China','','','A-1809, Yaojiang International Building No.100\r\nMoganshan Road, Hangzhou 310005','','+86 571 87293016','',NULL,'','jeffrey@hzdongjin.com ,  wendy@hzdongjin.com','www.hzdongjin.com','','',NULL,'','','admin','2017-09-28 14:25:51','yudi','2018-01-26 16:06:10'),(41,'Jayco Chemical Industries','\0','India','','','Western Express Highway,\r\nNext to Dodhia Petrol Pump, Kashi Mira, Pos Mira\r\nDist. Thane 401104, Maharashtra\r\n','','+91 22 64526498','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.jaycochemicals.com','','',NULL,'','','admin','2017-09-28 14:30:46','vetty','2018-01-24 14:40:58'),(42,'Jiaxing Junkang Commerce and Industrial Company Ltd','\0','','','','Add: No.88, Hefeng Road, Jiaxing Economic Development Zone\r\nZhejiang - China','','+86 573 82201129','',NULL,'','junkang@junkangchem.com ','www.junkangchem.com','','',NULL,'','','admin','2017-09-28 16:39:39','vetty','2018-01-25 14:34:07'),(43,'Pan Asia Innofar Pharmaceutical Ltd','\0','Hongkong','','','RM18C, 27/F, Ho King Comm Ctr,2-16 Fayuen St\r\nMongkok Kowloon','','','',NULL,'+86 13609620212','serenapan@innofar.cn','www.innofar.cn','','',NULL,'','','admin','2017-10-03 09:16:07','vetty','2018-01-25 14:45:31'),(44,'Alkaloids Of Australia Pty Limited','\0','','','','Suite 3, Level 18, 122\r\nArthur Street, North Sydney NSW 2060,\r\nAustralia, P.O Box 1278\r\nPotts Point NSW 2011 - Australia\r\n','','+61 2 9460 0188','',NULL,'','sales@alkaloids.org','www.alkaloids.org','','',NULL,'','','admin','2017-10-03 15:10:10','vetty','2018-01-24 13:40:56'),(45,'Global Calcium Pvt Ltd','\0','India','','','No. 1, 100 Feet Road\r\n5 th Block, Koramangala\r\nBangalore 560095','','+91 80 4055 4500','',NULL,'','','www.globalcalcium.com','','',NULL,'','','admin','2017-10-11 15:58:43','vetty','2018-01-24 14:43:48'),(46,'Hunan Yuantong Pharmaceutical Co.,Ltd','\0','','','','No. 747 Kangwan Road\r\nLiuyang Economic Development Zone\r\nChangsa City, Hunan Province\r\nChina\r\n','','+86 755 27805629','',NULL,'+86 186 6590 5396','xiezhigang@yt-pharm.com, jeremyling@yt-pharm.com','www.yt-pharm.com','','',NULL,'','','admin','2017-10-12 11:02:14','yudi','2018-03-27 08:30:18'),(47,'Harika Drugs Private Limited','\0','','','','No. 7-2-1813/5/A/1, 2nd floor, Classic Arcade, Road No.1,\r\nCzech Colony, Sanath Nagar, Hyderabad 500018, Telangana - India\r\n','','+91 40 23814863','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-10-12 11:14:57','vetty','2018-01-25 14:31:33'),(48,'Huisong  Pharmaceuticals','\0','','','','ADD : No.39, 25 Avenue,\r\nHangzhou Economic and Technological Development Zone\r\nHangzhou - China','','+86 571 2829 2015','',NULL,'+86 150 0581 2456','mliu@farfavourgroup.com','www.huisongpharm.com','','',NULL,'','','admin','2017-10-12 11:48:33','vetty','2018-01-25 14:32:22'),(49,'Piramal Enterprises Limited','\0','India','','','A Wing 6th Floor 247 Park LBS MARG\r\nVikhroli West, Mumbai  400083\r\n','','','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-10-12 12:04:30','vetty','2018-01-24 14:39:23'),(50,'Anuh Pharma Limited','\0','India','','','3-A, Shivsagar Estate, North Wing\r\nDr. Annie Besant Road, Worli\r\nMumbai 400018\r\n','','','',NULL,'','alrego@vitalchemie.com ,  vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-10-12 12:56:56','vetty','2018-01-24 14:51:52'),(51,'Apex Healthcare Limited','\0','India','','','4710-GIDC Estate\r\nAnkleshwar 393002, Gujarat','','+91 2646 223525 / 227289','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.apexhealthcareindia.com','','',NULL,'','','admin','2017-10-12 13:00:19','vetty','2018-01-24 14:52:22'),(52,'Joint Stock Company \"Grindeks\"','\0','LV-1057 Latvia','','','53 Krustpils Street, Riga\r\n\r\n','','+371 67083220','',NULL,'+371 29680067','parsla.kramina@grindeks.lv','www.grindeks.lv','','',NULL,'','','admin','2017-10-12 13:03:43','vetty','2018-01-24 14:40:01'),(53,'Covex S.A','\0','Spain','','','C/Acero, 25 - Poligono Industrial Sur\r\nApartado de Correos No. 5\r\n28770 Colmenar Viejo, Madrid','','+34 91 8450200','',NULL,'','n.lipkus@covex.com ,  o.gembei@covex.com','www.covex.com','','',NULL,'','','admin','2017-10-12 13:07:26','vetty','2018-01-24 14:43:04'),(54,'Zhejiang Jingxin Pharmaceutical Imp & Exp Co.,Ltd','\0','China','','Zhejiang','No.800 Dadao East Road, Yulin Street,\r\nChengguan - Xinchang Country','312500','+86 575 86298518 ','',NULL,'+86 13017735329','janicezxh@163.com ,  janicezxh@gmail.com','www.jingxinpharm.com','','',NULL,'','','admin','2017-10-12 13:10:55','vetty','2018-01-24 14:29:27'),(55,'Aurora Pharmachem Industrial Ltd','\0','','','','419, Harborne Road,\r\nEdgbaston, Birmingham\r\nEngland B15 3LB\r\n\r\n','','','',NULL,'+86 13609620212','serena_pan@126.com ,  serena_pan@139.com','','','',NULL,'','','admin','2017-10-12 13:17:11','vetty','2018-01-25 14:25:38'),(56,'Auctus Pharma Limited','\0','India','','','#102, 1 St Floor, Aditya Trade Centre,\r\nAmeerpet, Hyderabad 500038\r\nAndhra Pradesh','','+91 40 66361958 / 59','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.auctuspharma.com','','',NULL,'','','admin','2017-10-12 13:20:29','vetty','2018-01-24 14:45:23'),(57,'Alipharma S.A','\0','Switzerland','','','Via Della Posta 4\r\nP.O. Box 5106\r\n6901 Lugano\r\n','','+41 91 971 5984','',NULL,'','info@alipharmach.ch','','','',NULL,'','','admin','2017-10-12 13:22:42','vetty','2018-01-24 14:16:23'),(58,'Fleming Laboratories Limited','\0','','','','4th Floor, Madhupala Towers Ameerpet,\r\nHyderabad 500016, Telangana\r\nIndia','','+91 40 23416779','',NULL,'','shantanu@cosmigen.com , reena@cosmigen.com','www.fleminglabs.com','','',NULL,'','','admin','2017-10-12 13:25:40','vetty','2018-01-25 14:29:18'),(59,'Wuhan Grand Hoyo Co., Ltd.','\0','China','','','399 Luo Yu Road, Zhuo Dao Quan\r\nWuhan 430070\r\n\r\n','','+86 27 8745 6106','',NULL,'+86 18607150923','vivian.zhou@grandhoyo.com','','','',NULL,'','','admin','2017-10-12 13:33:34','vetty','2018-01-25 15:14:39'),(60,'Hangzhou Greensky Biological Tech Co.,Ltd','\0','China','','','Room 902, Think Blue Building 1, No. 533 Dongxin Road\r\nHangzhou, Zhejiang','','+86 571 85390169','',NULL,'+86 15858227405','jerry@greenskybio.net','http://greenskybio.en.alibaba.com','','',NULL,'','','admin','2017-10-12 13:37:50','vetty','2018-01-24 14:45:01'),(61,'Strides Shasun Limited','\0','India','','','Regd. Off: 201, Devavratea, Sector 17,\r\nVashi, Navi Mumbai - 400703','','+91 22 27892924','',NULL,'','shantanu@cosmigen.com , reena@cosmigen.com','www.stridesshasun.com','','',NULL,'','','admin','2017-10-12 13:41:59','vetty','2018-01-24 14:30:56'),(62,'Hunan Dongting Pharmaceutical Co.,Ltd','\0','China','','','Add : No.16 Dongyan Road, Deshan\r\nChangde City, Hunan Province','','+86 736 7318200','',NULL,'','impexp@dtpharm.com , impexp@hotmail.com','','','',NULL,'','','admin','2017-10-12 13:44:54','vetty','2018-01-24 14:41:38'),(63,'Prudence Pharma Chem','\0','India','','','Plot No.7407, B/H Lyka Lab,\r\nGIDC, Ankleshwar 393 002\r\nGujarat','','+91 2646 222825 / 650406','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.prudencepharma.com','','',NULL,'','','admin','2017-10-12 13:48:19','vetty','2018-01-24 14:33:28'),(64,'Optimus Drugs Pvt Ltd','\0','','','','#1-2-11/1, Above SBI Bank, Street No.2, Kakatiya Nagar, \r\nHabsiguda, Hyderabad 500007\r\nTelangana - India','','+91 40 40069400','',NULL,'+91 8008239797','vishnu.ch@optimuspharma.com, anusha.p@optimuspharma.com, optimus@optimuspharma.com','www.optimuspharma.com','','',NULL,'','','admin','2017-10-12 13:53:48','vetty','2018-01-25 14:44:34'),(65,'B.T. Gen S.A.','\0','Switzerland','','','Via F. Pelli 17\r\nLugano 6901\r\n','','+41 91 973 21 01','',NULL,'','marinella.frigerio@chemolugano.com , andrea.agradi@chemolugano.com','www.chemogroup.com','','',NULL,'','','admin','2017-10-12 14:02:45','vetty','2018-01-24 14:46:00'),(66,'Veriq Pte Ltd','\0','Singapore 048545','','','14, Robinson Road, # 11-02B,\r\nFar East Finance Building\r\n','','+65 63335075','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-10-18 16:30:09','vetty','2018-01-22 16:10:04'),(67,'Syn-Tech  Chem & Pharm. Co.Ltd','\0','Taiwan','','','168 Kai Yuan RD, Hsin Ying 730 ','','+886 6 6362121','',NULL,'','syntech@ms1.hinet.net','www.syn-tech.com.tw','','',NULL,'','','admin','2017-10-19 08:22:24','vetty','2018-01-22 16:04:53'),(68,'Top Ray International Industrial Co.,Ltd','\0','United Kingdom','','London','Flat 107, 25 Indescon Square','','','',NULL,'','topray01@hotmail.com, janicezxh@163.com','','','',NULL,'','','admin','2017-10-19 08:41:15','vetty','2018-01-24 14:32:37'),(69,'Procyon Life Sciences Pvt Ltd','\0','India','','','E-404 Remi Biz Court,\r\nVeera Desai Road, Andheri (West)\r\nMumbai - 400053','','+91 22 66921530','',NULL,'','ujwala@procyonlifesciences.com ,   rajveer@procyonlifesciences.com','www.procyonlifesciences.com','','',NULL,'','','admin','2017-10-19 13:48:44','vetty','2018-01-24 14:33:14'),(70,'Aceto Pte Ltd','\0','','','','300 Beach Road,\r\n#40-01 The Concourse\r\nSingapore 199555','','+65 6296 0800','',NULL,'','lisakng@aceto.com.sg , yunita@aceto.com.sg','www.aceto.com','','',NULL,'','','admin','2017-11-06 10:03:44','vetty','2018-01-25 14:21:58'),(71,'Rl Fine Chem Pvt Ltd','\0','India','','Karnataka 560064','#41 KHB Industrial Area, Yelahanka New Town\r\nBangalore','','','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','','','',NULL,'','','admin','2017-11-20 08:26:49','vetty','2018-01-24 14:35:23'),(72,'Oceanic Pharmachem Pvt Ltd','\0','','','','607,Wintall, Sahar Plaza, J.B. Nagar, \r\nAndheri (E), Mumbai 400059\r\nIndia\r\n','','+91 022 42128666','',NULL,'','bhavik@oceanicpharmachem.com','www.oceanicpharmachem.com','','',NULL,'','','admin','2017-11-21 13:51:51','vetty','2018-01-25 14:43:58'),(73,'PT Surya Kejayan Jaya Farma','','Indonesia','Jawa Timur','Surabaya','Jl. Sumatera No. 66','','031- 5033476 / 5032182','',NULL,'081 650 0653','skjfpt@gmail.com','','','',NULL,'','','admin','2017-12-06 11:44:32','vetty','2018-01-18 16:15:19'),(74,'Cadila Pharmaceuticals Ltd','','India','','','Cadila Corporate Campus\r\nSarkhej-Dholka Road, Bhat, Ahmedabad 382210\r\nGujarat','','+91 2646 251519','',NULL,'','alrego@vitalchemie.com , vidyas@vitalchemie.com','www.cadilapharma.com','','',NULL,'','','admin','2017-12-06 15:00:10','vetty','2018-01-24 14:46:48'),(75,'UPS','','','','','','','021-80885005','',NULL,'','','','','',NULL,'','','admin','2017-12-06 15:04:59','admin','2017-12-06 15:04:59'),(76,'Fedex','','','','','','','','',NULL,'0852 1800 9556','','','','',NULL,'','','admin','2017-12-06 15:07:37','admin','2017-12-06 15:07:37'),(77,'DHL','','','','','','','021- 79193333','021 79173333',NULL,'0895 2402 5625','','www.dhl.com','','',NULL,'','','admin','2017-12-06 15:12:02','admin','2017-12-21 14:18:28'),(78,'Chengdu Yazhong Bio-Pharmaceutical Co., Ltd','\0','','','','Lichun Town, Pengzhou City,\r\nChengdu, Sichuan China 611936','','+86 28 83817535','',NULL,'','nicole@yzpharm.com , yazhong@yzpharm.com','www.yzpharm.com','','',NULL,'','','yudhi','2018-01-09 11:13:22','yudi','2018-03-19 11:34:08'),(79,'Gufic Biosciences Ltd','\0','India','','','2Nd Floor, Dorr Oliver House B.D. Sawant Marg, Chakala, Andheri (East), Mumbai 400099','','','',NULL,'','shantanu@cosmigen.com , reena@cosmigen.com','','','',NULL,'','','yudhi','2018-01-10 15:08:19','vetty','2018-01-24 14:44:29'),(80,'Meha Chemicals','\0','India','','','206, 2nd Floor, D Definity Jayprakash Nagar\r\nRoad No. 1 Goregaon (E), Mumbai 400063\r\nMaharashtra','','+91 22 2685 2767 / 0172','',NULL,'','','sales@mehachem.com','','',NULL,'','','vetty','2018-01-22 16:54:33','yudi','2018-02-22 14:31:56'),(81,'Shaanxi YouBio Technology Co.,Ltd','\0','China','PRC 710065','','Rm1007, Huixin IBC,B#, No. 1 Zhangba\r\n1st Rd, Xi\'an ','','','',NULL,'','','','','',NULL,'','','vetty','2018-01-24 15:11:52','vetty','2018-01-24 15:11:52'),(82,'Sequent Scientific Limited','\0','India','','','120 A & B, Industrial Area, Baikampady\r\nNew Mangalore 575011','','+91 824 2402100','',NULL,'','','','','',NULL,'','','vetty','2018-01-24 15:19:58','vetty','2018-01-24 15:19:58'),(83,'Medigraph Pharmaceuticals Pvt Ltd','\0','India','','','301, Eric House 16th Road\r\nChembur, Mumbai 400071','','+91 22 61066600','',NULL,'','','','','',NULL,'','','vetty','2018-01-24 15:25:26','vetty','2018-01-24 15:25:26'),(84,'FDC Limited','\0','India','','','142-48, S.V. Road\r\nJogeshwari (West), Mumbai 400102\r\nMaharashtra','','+91 22 3071 9207','',NULL,'','','','','',NULL,'','','vetty','2018-01-24 15:28:39','vetty','2018-01-24 15:28:39'),(85,'Srikem Laboratories Pvt Ltd','\0','India','','','Plot No. 17/27, M.I.D.C. Taloja, Panvel\r\nDist. Raigad 410208\r\nState Maharashtra','','','',NULL,'','','www.srikem.com','','',NULL,'','','vetty','2018-01-24 15:31:59','vetty','2018-01-24 15:31:59'),(86,'DASAN Pharmaceutical','\0','','','','342, Deogamsan-ro, Dogo-myeon,Asan-si, \r\nChungcheongnam-do,\r\nKorea','','','',NULL,'','sj22223@dspharm.com','sj22223@dspharm.com','','',NULL,'','','yudi','2018-02-05 14:38:05','yudi','2018-02-05 14:38:05'),(87,'Technodrugs & Intermediates PVT . LTD','\0','INDIA','','','Office : 11-2/B, Ghanshyam Industrial Estate off Veera Desai Road,\r\nAndheri - West Mumbai -400053  I N D I A.','400053','','',NULL,'','info@technodrugs.com ; sameer@technodrugs.com','','','',NULL,'','','akhiong','2018-02-09 08:19:54','akhiong','2018-02-09 08:19:54'),(88,'Supriya Lifescience Ltd','\0','','','','207/208, Udyog Bhavan, Sonawala Road,  \r\nGoregaon (E), Mumbai - 400 063   \r\nIndia','','','',NULL,'','','saloni@supriyalifescience.com','','',NULL,'','','yudi','2018-02-20 16:12:31','yudi','2018-02-20 16:12:31'),(89,'Trinity Pharmaceuticals & Food Pvt Ltd.','\0','','','','Unit 701 / 7th Floor, Kamlacharan Building  \r\nNear Jawahar Nagar Phatak  \r\nGoregaon (West), Mumbai - 400062, India\r\n','','','',NULL,'','','','','',NULL,'','','yudi','2018-02-28 08:46:17','yudi','2018-02-28 11:37:56'),(90,'Ningbo Create -Bio Engineering Co., Ltd','\0','','','','Gengyu Rd., Guisi Industry Zone \r\nNingbo,China','','','',NULL,'','','stella@createbiochem.com','','',NULL,'','','yudi','2018-03-05 08:02:12','yudi','2018-03-05 08:02:12'),(91,'5N Plus Lubeck GmbH','\0','','','','Kaninchenborn 24-28  \r\n23560 Lubeck  \r\nGermany','','','',NULL,'','','www.5nplus.com','','',NULL,'','','yudi','2018-03-08 11:14:58','yudi','2018-03-08 11:14:58'),(92,'PT. Surya Kejayan Jaya Farma','\0','','','','Jl. Sumatra 66,  \r\nSURABAYA','','','',NULL,'','','','','',NULL,'','','yudi','2018-03-09 09:50:08','yudi','2018-03-09 09:55:46'),(93,'Herbert Brown Pharmaceutical & Research Labs','\0','','','','W-258-A, MIDC Phase II ,\r\nShivaji Udyog Nagar, Dombivli (East)  \r\nDist. Thane, Maharashtra State, INDIA','','','',NULL,'','','','','',NULL,'','','yudi','2018-03-09 11:16:20','yudi','2018-03-09 11:16:20'),(94,'Organic Herb Inc.','\0','','','','A301, 1st Building, 188 Huanbao Road\r\nChangsha 410016\r\nP.R. China','','+86 731 8273 9230                   ','',NULL,'+86 17373158558','linda@organic-herb.com','www.organic-herb.com','','',NULL,'','','vetty','2018-03-16 14:35:50','vetty','2018-03-16 14:39:47'),(95,'Huanggang Huayang Pharmaceutical, Co.,Ltd','\0','','','','8 Wangu RD, Sanlifan Town  \r\nLoutian Country, Hubei 438621\r\nChina','','','',NULL,'','','henry@huayangbio.com','','',NULL,'','','yudi','2018-03-22 14:44:27','yudi','2018-03-22 14:44:27'),(96,'TNT Courier','','','','','','','','',NULL,'','','','','',NULL,'','','yudi','2018-03-23 14:38:38','yudi','2018-03-23 14:38:38'),(97,'Jai Radhe Sales','\0','','','','309/310 Harikrupa Tower   \r\nNR. Old Sharda Mandir Cross Road     \r\nEllisbridge, Ahmedabad - 380006   \r\nGujarat - India','','','',NULL,'','','anair@jairadhesales.com','','',NULL,'','','yudi','2018-03-23 15:46:07','yudi','2018-03-23 15:46:07');
/*!40000 ALTER TABLE `ms_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_suppliercontactdetail`
--

DROP TABLE IF EXISTS `ms_suppliercontactdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_suppliercontactdetail` (
  `supplierContactID` int(11) NOT NULL AUTO_INCREMENT,
  `supplierID` int(11) DEFAULT NULL,
  `contactPerson` varchar(200) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`supplierContactID`),
  KEY `fk_suppliercontact_supplierid_idx` (`supplierID`)
) ENGINE=InnoDB AUTO_INCREMENT=810 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_suppliercontactdetail`
--

LOCK TABLES `ms_suppliercontactdetail` WRITE;
/*!40000 ALTER TABLE `ms_suppliercontactdetail` DISABLE KEYS */;
INSERT INTO `ms_suppliercontactdetail` VALUES (161,76,'Bpk. Ryan','Courier',''),(495,2,'Mrs. Marinella Frigerio','','Marinella'),(496,2,'Mr. Andrea Agradi','','Andrea'),(502,30,'Mr. Damon','','Damon'),(510,5,'Mr. Jackie Chen ','Sales Director','Jackie'),(514,67,'Ms. Amy Huang','Manager','Amy'),(515,68,'Ms. Yang Lisa','','Lisa'),(516,68,' Ms. Janice Zi ','VP of API','Janice'),(586,22,'QQ: PT. Menjangan Sakti','Area Manager','Sir'),(601,57,'Mrs. Marinella Frigerio','',''),(607,18,'Mr. ','',''),(609,77,'Bpk. Ali','Courier',''),(610,8,'Bp. Edi','Manager',''),(619,66,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(620,66,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(621,34,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(622,34,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(623,54,'Mrs. Janice Zi','Vice President of API','Janice'),(626,28,'Mr. Rama Rao','Manager - Exports','Rama'),(627,28,'Mr. V.V. Ramesh Kumar','General Manager Exports','Ramesh'),(630,14,'Mr. Mohan Menon','','Mohan'),(631,14,'Mr. Lor Karloon','Marketing Executive','Karloon'),(632,14,'Mr. Ravi','','Ravi'),(635,11,'Ms. Tracy Zhang','Sales Manager','Tracy'),(636,11,'Mr. Victor Huang','Managing Director','Victor'),(637,15,'Mr. Shantanu Rambhad (Cosmigen)','','Shantanu'),(638,15,'Ms. Reena Massil (Cosmigen)','','Reena'),(641,36,'Mr. S.Sandeep Varma','','Sandeep'),(642,36,'Mr. Shaheen Rafik Mansuri','Manager – Logistics Head','Shaheen'),(645,33,'Mr. Al Rego ( Vital Chemie Corporation )','','Al'),(646,33,'Mrs. Vidya Sawant ( Vital Chemie Corporation )','','Vidya'),(658,23,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(659,23,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(665,71,'Mr. Al Rego [Vitalchemie Corporation]','','Al'),(675,59,'Ms. Vivian Zhou','International Sales Dept',''),(678,61,'Mr. Shantanu Rambhad (Cosmigen)','','Shantanu'),(679,61,'Ms. Reena Massil (Cosmigen)','','Reena'),(684,16,'Mr. Paras Kamdar','Business Development','Paras'),(685,13,'Mr. Kobe Yang','','Kobe'),(686,38,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(687,38,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(698,10,'PT. JAS','-',''),(702,70,'Mrs. Lisa Kng','','Lisa'),(703,70,'Ms. Cyrille Arlandis','Sales Director','Cyrille'),(704,70,'Ms. Yunita Indrasari','Sales','Yunita'),(705,70,'Mr. Teddy Saputra','','Teddy'),(710,4,'Mr. Ravi Jagtap','Managing Director','Ravi'),(711,4,'Ms. Dipti Kanvinde','Manager Exports','Dipti'),(712,44,'Mr. Chris','','Chris'),(713,44,'Mr. David Doctor','Export Administration Manager','David'),(714,3,'Ms. Marian Wing','Senior Executive','Marian'),(715,79,'Mr. Shatanu Rambad','','Shantanu'),(716,78,'Ms. Nicole Mou','Sales Department','Nicole'),(717,50,'Mr. Al Rego (Vitalchemie Corporation)','','Al'),(718,50,'Mrs. Vidya Sawant (Vitalchemie Corporation)','','Vidya'),(719,27,'Mr. Mayur Jhunjhuwala','Manager','Mayur'),(720,27,'Mr. Mahua','','Mahua'),(721,27,'Mrs. Manish Jajodia','','Manish'),(724,39,'Mr. Atman Parekh ','','Atman'),(725,39,'Mr. Minal','','Minal'),(728,55,'Ms. Serena Pan','Sales Director','Serena'),(729,65,'Ms. Marinella Frigerio','','Marinella'),(730,65,'Mr. Andrea Agradi','','Andrea'),(731,31,'Mrs. Marinella Frigerio','','Marinella'),(732,9,'Mr. Mohan Menon','Managing Director','Mohan'),(735,25,'Mr. Shantanu Rambhad (Cosmigen)','','Shantanu'),(736,25,'Ms. Reena Massil (Cosmigen)','','Reena'),(737,53,'Ms. Natasha Lipkus','Commercial Director','Natasha'),(738,53,'Ms. Olga Gembei','Import-Export Department','Olga'),(739,35,'Mr. Tushar Budukh','Assistant Manager - Commercial','Tushar'),(740,35,'Mr. Ravindra Kothi','','Ravindra'),(741,35,'Mr. Sameer Ghodrao','Business Development','Sameer'),(742,35,'Mr. Rahul Joglekar','','Rahul'),(743,58,'Mr. Shantanu Rambhad (Cosmigen)','','Shantanu'),(744,58,'Ms. Reena Massil (Cosmigen)','','Reena'),(745,37,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(746,37,'Mrs. Vidya Sawant  ( Vitalchemie Corporation )','','Vidya'),(747,40,'Mr. Jeffrey Liu','','Jeffrey'),(748,63,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(749,63,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(750,60,'Mr. Jerry Chou','Sales Director','Jerry'),(751,40,'Mr. Wendy','','Wendy'),(752,47,'Mr. Al Rego ( Vital Chemie Corporation )','','Al'),(753,47,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(754,20,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(755,20,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(756,20,'Mr. Nehal Desai','','Nehal'),(757,48,'Ms. Miranda Liu','','Miranda'),(758,62,'Mr. Xiejuan','','Xiejuan'),(759,62,'Mr. Xie Liang','API Sales Dept. Manager','Xie Liang'),(760,46,'Mr. Zhigang Xie ','Sales Manager','Zhigang'),(761,46,'Mr. Jeremy Ling','Sales Department','Jeremy'),(762,41,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(763,41,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(764,42,'Mr. Kobe Wong','Sales Director','Kobe'),(765,17,'Mrs. Tamara Sander','','Tamara'),(766,1,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(767,1,'Mrs. Vidya Sawant  (Vitalchemie Corporation )','','Vidya'),(768,26,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(769,26,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(770,21,'Mr. Parv Jain  ','','Parv'),(771,21,'Mr. Romi Daiya','','Romi'),(773,64,'Mr. Vishnu Chelikani','Business Development','Vishnu'),(774,64,'Mr. Anusha P','','Anusha'),(775,64,'Mr. Subba Reddy ','','Subba'),(776,43,'Ms. Serena Pan','Sales Director','Serena'),(777,12,'Ms. Priya','','Priya'),(778,29,'Mr. Chizuru Tabei','','Tabei'),(779,49,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(780,49,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(781,51,'Mr. Al Rego ( Vital Chemie Corporation )','','Al'),(782,51,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(783,56,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(784,56,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(785,74,'Mr. Al Rego ( Vitalchemie Corporation )','','Al'),(786,74,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(787,32,'Mr.','',''),(788,79,'Ms. Reena Massil','','Reena'),(789,52,'Ms. Parsla Kramina','Business Development','Parsla'),(790,69,'Ms. Ujwala Mhatre','','Ujawala'),(791,69,' Mr. Rajveer','','Rajveer'),(792,73,'Bp. Robert William','Director','Robert'),(793,73,'Ibu. Endah ','','Endah'),(794,7,'Bp. Anton Teopilus','Direktur','Anton'),(795,7,'Ibu. Desy Maria','','Desy'),(796,6,'Bp. Benadi Nurdin','Direktur','Benadi'),(797,19,'Mr. Mohammad Ashraf','Manager – Business development','Ashraf'),(798,71,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','','Vidya'),(799,24,'Mr.','',''),(800,72,'Mr. Bhavik Shah','','Bhavik'),(801,86,'Ms. Seungju Ha','Sales','Seungju'),(802,87,'Mr. Alpa','','Alpa'),(803,88,'Mr. Saloni Wagh','','Saloni'),(804,89,'Mr. Ashish Kulkarni','','Ashish'),(805,90,'Ms. Stella Zhao','','Stella'),(806,91,'Ms. Susanti','','Susanti'),(807,92,'Mr. Robert William','','Robert'),(808,93,'Mr. Shantanu Rambhad (Cosmigen)','','Shantanu'),(809,94,'Ms. Linda Wen','Business Development','Linda');
/*!40000 ALTER TABLE `ms_suppliercontactdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_supplierdetail`
--

DROP TABLE IF EXISTS `ms_supplierdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_supplierdetail` (
  `supplierDetailID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Supplier Detail ID',
  `supplierID` int(11) NOT NULL COMMENT 'Supplier ID',
  `bankName` varchar(50) NOT NULL COMMENT 'Bank Name',
  `swiftCode` varchar(50) DEFAULT NULL COMMENT 'Swift Code',
  `accountNo` varchar(50) DEFAULT NULL COMMENT 'Account Number',
  `country` varchar(50) DEFAULT NULL COMMENT 'Country',
  `city` varchar(50) DEFAULT NULL COMMENT 'City',
  `street` varchar(200) DEFAULT NULL COMMENT 'Street',
  `postalCode` varchar(10) DEFAULT NULL COMMENT 'Postal Code',
  PRIMARY KEY (`supplierDetailID`),
  KEY `fk_supplierid_supplier_idx` (`supplierID`)
) ENGINE=InnoDB AUTO_INCREMENT=387 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_supplierdetail`
--

LOCK TABLES `ms_supplierdetail` WRITE;
/*!40000 ALTER TABLE `ms_supplierdetail` DISABLE KEYS */;
INSERT INTO `ms_supplierdetail` VALUES (194,30,'CHINA CONSTRUCTION BANK XIAMEN BRANCH','PCBCCNBJSMX','3511 4562 4002 2010 2935','CHINA','','',''),(195,24,'AGRICULTURAL BANK OF CHINA - TAIZHOU  BRANCH','ABOCCNBJ110 ','1991  6314  0400  0104  0','CHINA','ZHEJIANG','Tian Chang South Road, Huangyan',''),(199,5,'THE SARASWAT CO-OPERATIVE BANK LTD','SRCBINBBAND ','2845 0010 0000 140','INDIA','MUMBAI','SME VILE PARLE EAST,BHOLANATH CO-OP - SUBHASH ROAD','400057'),(201,67,'TAIWAN  BUSINESS BANK - Cheng Kung Branch','MBBTTWTP720','690 - 50 - 00903 - 3','Taiwan','Tainan City','25 Kuong Yuan Road',''),(202,68,'PING AN BANK, H.O., OFFSHORE ','SZDBCNBS ','OSA 110 - 1322 - 8751 - 201','CHINA','','',''),(206,19,'STATE BANK OF INDIA','SBININBB144','3027 - 9792 - 517','INDIA','HYDERABAD','INDUSTRIAL FINANCE BRANCH, ',''),(219,73,'BCA','','100 0019 808','Indonesia','Surabaya','',''),(243,22,'INTESA SANPAOLO SPA - BRANCH 3','BCITITMMG53','IBAN IT30 A030 6901 6031 0000 0100 512','ITALY','','',''),(252,57,'UBS  SA','UBSWCHZH80A','IBAN  CH16  0024  7247  7178  7260K','SWITZERLAND','PARADISO','VIA S. SALVATORE 13 P.O  BOX  337',''),(255,18,'UNION BANK OF INDIA','UBININBBFIB','4958  0501  0011  006','INDIA','MUMBAI','INDUSTRIAL FINANCE BRANCH 1st FL,UNION BANK BHAVAN','400021'),(256,8,'BCA','','028 30 82536','Indonesia','Jakarta','',''),(262,66,'DBS BANK LTD','DBSSSGSG ','0288 - 000837 - 01 - 1 - 022','SINGAPORE','','12 MARINA BOULEVARD - DBS ASIA CENTRAL - MARINA BA','018982'),(263,34,'THE SARASWAT CO-OPERATIVE BANK LTD','SRCBINBBAND','0195 02100 950 189','INDIA','MUMBAI','',''),(264,54,'SHANGHAI PUDONG DEVELOPMENT BANK - HANGZHOU BRANCH','SPDBCNSH336','9520 1457 41000 3340','CHINA','HANGZHOU','129, YANAN ROAD',''),(266,28,'STATE BANK of INDIA, OVERSEAS BRANCH','SBININBB134','1026  0539  381','INDIA','Hyderabad','Plot No. 241/A, Rd No. 36, Rajala Towers 2nd & 3rd','500033'),(268,14,'RHB BANK BERHAD','RHBBMYKL','6070  28  0000  1084','MALAYSIA','','PRAI TRADE BUSINESS CENTRE, 3rd FL - 2784 & 2785, ','13600'),(272,15,'HDFC BANK LTD,COMM.','HDFCINBBXXX','0255 232 000 1379','INDIA','GUJARAT','PLOT NO. C/4/5 - NEXT TO HOTEL LORDS PLAZA GIDC ES','393002'),(276,33,'UNION BANK OF INDIA','UBININBBIFB','4958 0501 0029 007','INDIA','','INDUSTRIAL FINANCE BRANCH',''),(288,71,'RBL BANK LIMITED','RATNINBBXXX','609000 4494 71','INDIA','Bangalore','G-12,G-13,14,15&17 GRD FL,PRESTIGE TOWER 99&100 RE','560025'),(292,69,'BANK OF INDIA - (Andheri Corporate Banking Branch)','BKIDINBBADC','0119 2011 00000 76','INDIA','MUMBAI','M.D.I Building Andheri-West','400058'),(293,59,'BANK OF COMMUNICATIONS - WUHAN BRANCH','COMMCNSHWHN ','4218 6330 8146 3400 0264 8','CHINA','','',''),(295,61,'RBL BANK LTD','RATNINBB','409 - 000 - 202 - 070','INDIA','MUMBAI','6th FL, ONE INDIABULLS CENTRE - TOWER 2,841 SENAPA','400013'),(298,38,'AXIS BANK LTD','AXISINBBA08','0080 1030 0014 818','INDIA','HYDERABAD','6-3-879/B, GREENLANDS ROAD - BEGUMPET',''),(303,7,'BCA','','261 3016 864','Indonesia','Jakarta Ousat','',''),(308,2,'CREDIT  SUISSE','CRESCHZZ69A','IBAN  CH37  0483  5082  9442  6200 1','SWITZERLAND','LUGANO','CH - 6900, LUGANO',''),(309,2,'CREDIT  SUISSE','CRESCHZZ69A','IBAN  CH64  0483  5082  9442  6200  0','SWITZERLAND','LUGANO','CH - 6900, LUGANO',''),(312,4,'SARASWAT CO-OPERATIVE BANK LTD','SRCBINBBAND','0281 - 0010 - 0002 - 539','INDIA','VILE PARLE ( E)','BHOLANATH CO - OPERATIVE HOUSING,SOCIETY - SUBHASH',''),(313,44,'COMMONWEALTH BANK OF AUSTRALIA','CTBAAU2S','0640 0013 9634 07','AUSTRALIA','NEW SOUTH WALES','201 SUSSEX STREET,SYDNEY','2000'),(314,3,'ALLIED IRISH BANK - WEMBLEY BRANCH','AIBKGB2L','IBAN  GB33  AIBK  2392  8520  1259  39','UNITED KINGDOM','','',''),(317,50,'BANK OF INDIA , WORLI NAKA BRANCH','BKIDINBBWRN','OD 0049 2711 0000 041','INDIA','WORLI MUMBAI','PANKAJ MANSION, DR.ANNIE BESANT ROAD',''),(320,39,'THE SARASWAT CO-OPERATIVE BANK LTD','SRCBINBB','0321 001 0000 2360','INDIA','','',''),(326,31,'UBS  SA','UBSWCHZH69A','CH19  0024  7247  5045  2160A','SWITZERLAND','CH-6900, LUGANO','',''),(330,53,'BANKIA','CAHMESMMXXX ','IBAN ES72 2038 2261 6960 0042 0184','SPAIN','MADRID','C/ SAN SEBASTIAN ,34 - 28770 COLMENAR VIEJO',''),(333,37,'AXIS BANK LTD','AXISINBBXXX','9150 2006 1464 527','INDIA','HYDERABAD','',''),(337,23,'HDFC BANK LIMITED - VERSOVA BRANCH','HDFCINBB','50 2000 2398 6207','INDIA','','',''),(346,48,'BANK OF COMMUNICATIONS - Zhejiang Branch','COMMCNSHHAN','3310  6611  0145  1000  0464  9','CHINA','HANGZHOU','173, QING CHUN ROAD','310006'),(347,62,'CHINA CONSTRUCTION BANK CO.,LTD - CHANGDE BRANCH','PCBCCNBJHUX','4301 4688 6002 2010 1066','CHINA','HUNAN','130 DONGTING ROAD (MIDDLE) CHANGDE',''),(348,11,'ZHEJIANG RURAL CREDIT COOPERATIVE UNION','ZJRCCN2N','2010 0009 9621 886','CHINA','ZHEJIANG','10B-6 JIAYI PLAZA - XINCHANG',''),(349,46,'CHINA CONSTRUCTION BANK  CHANGSHA','PCBCCNBJHUX','4305 0175 4136 0000 0006','CHINA','','LIUYANG SUB BRANCH',''),(351,16,'STANDARD CHARTERED BANK','SCBLINBB ','3310 5198 430','INDIA','KOLKATA','19, N S ROAD - WEST BENGAL','700001'),(352,42,'AGRICULTURAL BANK OF CHINA','ABOCCNBJ1110','19 - 3004 - 1404 - 0000 - 937','','CHINA','',''),(353,52,'NORDEA BANK AB - LATVIA BRANCH','NDEALV2X','LV63 NDEA 0000 0818 2900 6','LATVIA','','',''),(354,17,'COMMERZBANK  HAMBURG','COBADEHHXXX','IBAN  DE61  2004  0000  0550  2661  00','GERMANY','HAMBURG','',''),(355,1,'DENA BANK','BKDNINBBIFB','3582 - 0398 - 5600 - 1','INDIA','MUMBAI','DENA BANK BUILDING, GROUND FL,HORNIMAN CIRCLE,FORT','4000005'),(356,26,'STATE BANK OF INDIA - INTERNATIONAL BANKING DIVISI','SBININBBM03','5404 1433 741','INDIA','BANGALORE','MYSORE BANK CIRCLE BRANCH - AVENUE ROAD','560009'),(357,21,'THE SARASWAT CO-OPERATIVE BANK LTD','SRCBINBBGHT','0625 0010 0000 608','INDIA','MUMBAI','B-Block,Prabhat Bhavan 1st Fl Opp. Cipla LBS Road','400083'),(358,72,'BANK OF MAHARASHTRA - FOREIGN EXCHANGE DEPT','MAHBINBBLJR','CC 6002 3847 760','INDIA','MUMBAI','L.J ROAD , MAHIM BRANCH','400016'),(360,64,'AXIS BANK LTD','AXISINBB027','9140 2000 6766 577','INDIA','TELANGANA','Ground FL,WELCOME COURT COMPLEX - Opp:RAILWAY DEGR','500017'),(361,43,'STANDARD CHARTERED BANK (HONGKONG) LIMITED','BLHKHHXXX','4151 0594 156','HONGKONG','CAUSEAYBAY','G/F TO 2/F - YEE AH MANSION 38-40A YEE O STREET',''),(362,12,'SYNDICATE BANK','SYNBINBB175','3034  107 0000 10','INDIA','Hyderabad','M.G ROAD','500003'),(363,29,'MIZUHO  BANK, LTD','MHCBJPJT','01  000  27','JAPAN','TOKYO','',''),(364,49,'AUSTRALIA and NEW ZEALAND BANKING GROUP LTD','ANZBINBX','003 0000 35858','INDIA','MUMBAI','CNERGY UNIT A 6 TH FL-APPASAHEB MARATHE MARG - PRA','400025'),(365,70,'DEUTSCHE BANK','DEUTSGSG','257 1560 05 0','SINGAPORE','','1 Raffles Quay, #15-00 South Tower','048583'),(366,27,'STANDARD CHARTERED BANK','SCBLINBB ','3310 5125 522','INDIA','KOLKATA','19, NETAJI SUBHAS ROAD','700001'),(367,51,'BANK OF BARODA','BARBINBBANK','0895 0500 0001 20','INDIA','GUJARAT','GIDC INDUSTRIAL ESTATE BRANCH,ANKLESHWAR - BHARUCH','393002'),(368,56,'INDIAN BANK','IDIBINBBHYD','CC 707640438','INDIA','ANDHRA PRADESH','SURABHI ARCADE,BANK STREET,HYDERABAD','500001'),(369,65,'CORNER BANCA S.A','CBLUCH22XXX','IBAN  CH81 0849 0000 2777 8000 2','SWITZERLAND','LUGANO','',''),(370,74,'CORPORATION  BANK - NAVRANGPURA BRANCH','CORPINBB335','0335 0040 1980 003','INDIA','GUJARAT','AHMEDABAD','380006'),(371,55,'HSBC HONGKONG','HKHHHKH ','6970 1751 5838','HONGKONG','','1 QUEEN',''),(372,9,'UNITED OVERSEAS BANK LIMITED','UOVBSGSG','1443053633','SINGAPORE','','80,RAFFLES PLACE','048624'),(373,32,'PKB  PRIVATBANK  AG','PKBSCH2269A','IBAN  CH80  0866  3115  6041  0000  1','SWITZERLAND','LUGANO','VIA  BALESTRA  1','6900'),(374,25,'BANK OF BARODA, INTERNATIONAL BUSINESS BRANCH','BARBINBBOBR','2479 0500 0000 30','INDIA','VADODARA','SURAJ PLAZA, SAYAJIGUNJ',''),(375,78,'BANK OF CHINA PENGZHOU SUB-BRANCH','BKCHCNBJ570','1293 0932 0280','CHINA','PENGZHOU CITY','No.1 THE EAST STREET',''),(376,35,'Citi Bank N A Parmar House','CITIINBX','0306 0290 45','INDIA','PUNE','Onyx Tower, Near Westin Hotel - North Main Road,','411001'),(377,58,'STATE BANK OF INDIA - COMMERCIAL BRANCH','SBININBB194','1028 4056 668','INDIA','SECUNDERABAD','ASHOKA MY HOME CHAMBERS, S.P. ROAD','500003'),(378,40,'BANK OF CHINA - HANGZHOU WENHUI SUBBRANCH','BKCHCNBJ910','3883 6803 3050','CHINA','HANGZHOU CITY','No.221 XIANGJISI ROAD',''),(379,40,'CHINA MERCHANTS BANK H.O','CMBCCNBS008','OSA 57190 8571 6327 08','CHINA','SHENZHEN','SHENZHEN OFF SHORE BANKING DEPT - NO.7088 SHENNAN ',''),(380,60,'CHINA CONSTRUCTION BANK - ZHEJIANG BRANCH WENHUI S','PCBCCNBJZJX','3301 4003 2002 290000 11','CHINA','HANGZHOU','NO.227 SOUTH HUSHU RD',''),(381,47,'ICICI BANK LIMITED','ICICINBBCTS','0048 0501 5501','INDIA','TELANGANA','S.D. ROAD BRANCH - NO.62, G-1, NAVKETAN,OPP.CLOCK ','500003'),(382,20,'CITIBANK','CITIINBX','0301  8510  65','INDIA','MUMBAI','',''),(383,41,'UNION BANK OF INDIA','UBININBBGOR','3168  0101  0020 149','INDIA','MUMBAI','GOREGAON (E) BRANCH','400063'),(384,36,'CITI BANK NA, ','CITIINBX','0307 2140 32','INDIA','SECUNDERABAD','SECUNDERABAD BRANCH - ANDHRA PRADESH',''),(385,6,'BCA','','3983 0142 71','Indonesia','Jakarta','',''),(386,45,'INDIAN BANK - BANGALORE CITY BRANCH','IDIBINBBCTY','73969 1373','INDIA','BANGALORE','NO. 10, K.G. ROAD',' 560009');
/*!40000 ALTER TABLE `ms_supplierdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_tax`
--

DROP TABLE IF EXISTS `ms_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_tax` (
  `taxID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tax ID',
  `taxName` varchar(50) NOT NULL COMMENT 'Tax Name',
  `taxRate` decimal(18,2) NOT NULL COMMENT 'Tax Rate',
  `coaNo` varchar(20) NOT NULL COMMENT 'COA No',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`taxID`),
  KEY `fk_mstax_coano_idx` (`coaNo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_tax`
--

LOCK TABLES `ms_tax` WRITE;
/*!40000 ALTER TABLE `ms_tax` DISABLE KEYS */;
INSERT INTO `ms_tax` VALUES (1,'Bea Masuk',5.00,'5110.0007','','admin','2017-12-22 13:20:15','admin','2017-12-22 13:20:15'),(2,'PPh 22',2.50,'1122.0004','','admin','2017-12-22 13:23:13','admin','2017-12-22 13:23:13'),(3,'PPN Impor',10.00,'1122.0007','','admin','2017-12-22 13:24:17','admin','2017-12-22 13:24:17');
/*!40000 ALTER TABLE `ms_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_uom`
--

DROP TABLE IF EXISTS `ms_uom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_uom` (
  `uomID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UOM ID',
  `uomName` varchar(50) NOT NULL COMMENT 'UOM Name',
  `notes` varchar(100) NOT NULL COMMENT 'Notes',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`uomID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_uom`
--

LOCK TABLES `ms_uom` WRITE;
/*!40000 ALTER TABLE `ms_uom` DISABLE KEYS */;
INSERT INTO `ms_uom` VALUES (1,'kg','kilogram','','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),(3,'Gram','Notes','','admin','2016-11-14 10:14:09','admin','2016-11-14 10:14:09'),(4,'CTN','','','admin','2017-03-14 09:56:49','admin','2017-03-14 09:58:27'),(5,'mg','','','admin','2017-10-03 09:47:48','admin','2017-10-03 09:47:48'),(6,'Bou','','','admin','2017-12-21 10:41:49','admin','2017-12-21 10:41:49'),(7,'Miu','','','admin','2017-12-21 10:42:00','admin','2017-12-21 10:42:00'),(8,'Vial','','\0','admin','2017-12-21 10:42:29','admin','2017-12-21 10:42:29'),(9,'Ampul','','','admin','2017-12-21 10:42:47','admin','2017-12-21 10:42:47'),(10,'Liter','','','admin','2017-12-21 10:43:17','admin','2017-12-21 10:43:17');
/*!40000 ALTER TABLE `ms_uom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_user`
--

DROP TABLE IF EXISTS `ms_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_user` (
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT 'Username',
  `fullName` varchar(200) NOT NULL COMMENT 'Fullname',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT 'Password',
  `salt` varchar(45) NOT NULL COMMENT 'Salt Password',
  `userRole` varchar(100) NOT NULL COMMENT 'User Role ID',
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Create By',
  `createdDate` datetime NOT NULL COMMENT 'Create Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`username`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_userrole_idx` (`userRole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_user`
--

LOCK TABLES `ms_user` WRITE;
/*!40000 ALTER TABLE `ms_user` DISABLE KEYS */;
INSERT INTO `ms_user` VALUES ('akhiong','Akhiong','4ba2122266b957e57476a79e5d448f62','pWKXgMaVPZNoSMdg-Grd','PURCHASE','','','','admin','2017-12-20 11:09:20',NULL,NULL),('budy','Budy','f7f416210fa7f18a97f43a60ab185e18','ZNTEEquF6NnYgwfUj-7f','WAREHOUSE','','','','admin','2017-12-20 11:10:47',NULL,NULL),('fendi','Fendi','f29c4ae0334a080530d789903d2b2dc0','twtCtqTGM3dPL7dNxSk-','PURCHASE','','','','nurdin','2018-01-18 16:20:21',NULL,NULL),('maitri','Maitri','48cff8e5f4e2bb0577b3cb1c4f1bc8b9','p4rQI8mI59dSYIYKrfZo','ACCOUNTING','','','','admin','2016-11-14 09:56:33','admin','2017-12-20 10:58:14'),('nurdin','Nurdin Wijaya','fbb7415d942bd0e43df96368276cce3f','KDw5PrmKeUt2DDsZ39hW','DIRECTOR','','','','admin','2017-12-20 11:10:25',NULL,NULL),('qwinjayasupport','Admin QERP','80351a01e455630a41f644a0f3187763','yHlcMHoEu-SSpJhO2uTw','ADMIN','support@qwinjaya.com','+628585','','admin','2016-10-21 13:55:30','qwinjayasupport','2018-01-22 13:38:40'),('saiba','Noor Saiba Rifqiyana','212bce00fa04e1c665a64a9e0b6d8368','RRpLjE4tPcno-XtghEtX','MARKETING','sales@qwinjaya.com','+6281288186480','','qwinjayasupport','2018-01-19 16:56:44','qwinjayasupport','2018-01-22 13:57:19'),('vetty','Vetty','3471dbe794b7a17f7655719d88d3dbb3','VqAKC0wFfbLApi0qUygl','ACCOUNTING-FETI','','','','admin','2017-12-20 11:11:04','qwinjayasupport','2018-01-09 09:15:41'),('wawan','Wawan','15f51430af71b460f69904f917f38590','LLXJA4Mz5CfNU7H2KIXe','SAMPLING','','','','admin','2017-12-20 11:09:41',NULL,NULL),('yudi','Yudi','246ac66730c85ca8b7910dfd795b5f4f','sGnHuS6JCSduZ2F51u-v','PURCHASE','import@qwinjaya.com','+6281393277379','','admin','2017-12-22 15:44:34','qwinjayasupport','2018-01-24 10:59:35');
/*!40000 ALTER TABLE `ms_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_useraccess`
--

DROP TABLE IF EXISTS `ms_useraccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_useraccess` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userRole` varchar(100) NOT NULL COMMENT 'User Role',
  `accessID` varchar(10) NOT NULL COMMENT 'Access ID',
  `indexAcc` bit(1) NOT NULL COMMENT 'Index Access',
  `viewAcc` bit(1) NOT NULL COMMENT 'View Access',
  `insertAcc` bit(1) NOT NULL COMMENT 'Insert Access',
  `updateAcc` bit(1) NOT NULL COMMENT 'Update Access',
  `deleteAcc` bit(1) NOT NULL COMMENT 'Delete Access',
  `flagActive` bit(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_useraccessid_idx` (`accessID`)
) ENGINE=InnoDB AUTO_INCREMENT=693 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_useraccess`
--

LOCK TABLES `ms_useraccess` WRITE;
/*!40000 ALTER TABLE `ms_useraccess` DISABLE KEYS */;
INSERT INTO `ms_useraccess` VALUES (202,'ADMIN','G.4','','','','','',''),(203,'ADMIN','A.5','','','','','',''),(204,'ADMIN','A.1','','','','','',''),(205,'ADMIN','A.2','','','','','',''),(206,'ADMIN','F.3','','','','','',''),(207,'ADMIN','F.1','','','','','',''),(208,'ADMIN','F.2','','','','','',''),(209,'ADMIN','D.4','','','','','',''),(210,'ADMIN','D.5','','','','','',''),(211,'ADMIN','A.7','','','','','',''),(212,'ADMIN','E.2','','','','','',''),(213,'ADMIN','H.1','','','','','',''),(214,'ADMIN','F.4','','','','','',''),(215,'ADMIN','A.4','','','','','',''),(216,'ADMIN','B.4','','','','','',''),(217,'ADMIN','B.5','','','','','',''),(218,'ADMIN','B.1','','','','','',''),(219,'ADMIN','B.2','','','','','',''),(220,'ADMIN','B.3','','','','','',''),(221,'ADMIN','F.5','','','','','',''),(222,'ADMIN','B.10','','','','','',''),(223,'ADMIN','B.11','','','','','',''),(224,'ADMIN','G.3','','','','','',''),(225,'ADMIN','A.3','','','','','',''),(226,'ADMIN','F.6','','','','','',''),(227,'ADMIN','F.7','','','','','',''),(228,'ADMIN','F.8','','','','','',''),(229,'ADMIN','F.9','','','','','',''),(230,'ADMIN','F.10','','','','','',''),(231,'ADMIN','C.3','','','','','',''),(232,'ADMIN','C.4','','','','','',''),(233,'ADMIN','F.11','','','','','',''),(234,'ADMIN','F.12','','','','','',''),(235,'ADMIN','D.2','','','','','',''),(236,'ADMIN','D.1','','','','','',''),(237,'ADMIN','D.3','','','','','',''),(238,'ADMIN','E.3','','','','','',''),(239,'ADMIN','E.4','','','','','',''),(240,'ADMIN','G.1','','','','','',''),(241,'ADMIN','H.2','','','','','',''),(242,'ADMIN','B.8','','','','','',''),(243,'ADMIN','B.6','','','','','',''),(244,'ADMIN','B.7','','','','','',''),(245,'ADMIN','B.9','','','','','',''),(246,'ADMIN','F.13','','','','','',''),(247,'ADMIN','C.1','','','','','',''),(248,'ADMIN','A.6','','','','','',''),(249,'ADMIN','C.2','','','','','',''),(250,'ADMIN','E.1','','','','','',''),(251,'ADMIN','F.14','','','','','',''),(252,'ADMIN','G.2','','','','','',''),(253,'ADMIN','F.16','','','','','',''),(254,'ADMIN','F.18','','','','','',''),(255,'ADMIN','F.17','','','','','',''),(256,'ADMIN','F.15','','','','','',''),(257,'ADMIN','C.5','','','','','',''),(258,'ADMIN','B.12','','','','','',''),(259,'ADMIN','F.19','','','','','',''),(260,'ADMIN','G.5','','','','','',''),(261,'ACCOUNTING','G.4','','','','','',''),(262,'ACCOUNTING','A.1','','','','','',''),(263,'ACCOUNTING','A.2','','','','','',''),(264,'ACCOUNTING','A.5','','','','','',''),(265,'ACCOUNTING','F.3','','','','','',''),(266,'ACCOUNTING','F.1','','','','','',''),(267,'ACCOUNTING','F.2','\0','\0','\0','\0','\0',''),(268,'ACCOUNTING','D.4','','','','','',''),(269,'ACCOUNTING','D.5','','','','','',''),(270,'ACCOUNTING','A.7','','','','','',''),(271,'ACCOUNTING','E.2','\0','\0','\0','\0','\0',''),(272,'ACCOUNTING','H.1','\0','\0','\0','\0','\0',''),(273,'ACCOUNTING','F.4','\0','\0','\0','\0','\0',''),(274,'ACCOUNTING','A.4','','','','','',''),(275,'ACCOUNTING','B.4','\0','\0','\0','\0','\0',''),(276,'ACCOUNTING','B.5','','','','','',''),(277,'ACCOUNTING','B.1','\0','\0','\0','\0','\0',''),(278,'ACCOUNTING','B.2','\0','\0','\0','\0','\0',''),(279,'ACCOUNTING','B.3','\0','\0','\0','\0','\0',''),(280,'ACCOUNTING','F.5','\0','\0','\0','\0','\0',''),(281,'ACCOUNTING','B.12','\0','\0','\0','\0','\0',''),(282,'ACCOUNTING','B.10','\0','\0','\0','\0','\0',''),(283,'ACCOUNTING','B.11','\0','\0','\0','\0','\0',''),(284,'ACCOUNTING','G.3','','','','','',''),(285,'ACCOUNTING','A.3','','','','','',''),(286,'ACCOUNTING','F.6','\0','\0','\0','\0','\0',''),(287,'ACCOUNTING','F.7','\0','\0','\0','\0','\0',''),(288,'ACCOUNTING','F.19','\0','\0','\0','\0','\0',''),(289,'ACCOUNTING','G.5','\0','\0','\0','\0','\0',''),(290,'ACCOUNTING','F.8','\0','\0','\0','\0','\0',''),(291,'ACCOUNTING','F.9','\0','\0','\0','\0','\0',''),(292,'ACCOUNTING','F.10','\0','\0','\0','\0','\0',''),(293,'ACCOUNTING','C.1','\0','\0','\0','\0','\0',''),(294,'ACCOUNTING','C.2','\0','\0','\0','\0','\0',''),(295,'ACCOUNTING','C.3','\0','\0','\0','\0','\0',''),(296,'ACCOUNTING','F.11','\0','\0','\0','\0','\0',''),(297,'ACCOUNTING','F.12','\0','\0','\0','\0','\0',''),(298,'ACCOUNTING','D.2','\0','\0','\0','\0','\0',''),(299,'ACCOUNTING','D.1','\0','\0','\0','\0','\0',''),(300,'ACCOUNTING','D.3','\0','\0','\0','\0','\0',''),(301,'ACCOUNTING','E.3','\0','\0','\0','\0','\0',''),(302,'ACCOUNTING','E.4','\0','\0','\0','\0','\0',''),(303,'ACCOUNTING','G.1','\0','\0','\0','\0','\0',''),(304,'ACCOUNTING','H.2','\0','\0','\0','\0','\0',''),(305,'ACCOUNTING','B.8','\0','\0','\0','\0','\0',''),(306,'ACCOUNTING','B.6','','','','','',''),(307,'ACCOUNTING','B.7','','','','','',''),(308,'ACCOUNTING','B.9','\0','\0','\0','\0','\0',''),(309,'ACCOUNTING','F.13','\0','\0','\0','\0','\0',''),(310,'ACCOUNTING','C.4','','','','','',''),(311,'ACCOUNTING','A.6','','','','','',''),(312,'ACCOUNTING','C.5','','','','','',''),(313,'ACCOUNTING','E.1','\0','\0','\0','\0','\0',''),(314,'ACCOUNTING','F.14','','','','','',''),(315,'ACCOUNTING','G.2','\0','\0','\0','\0','\0',''),(316,'ACCOUNTING','F.16','\0','\0','\0','\0','\0',''),(317,'ACCOUNTING','F.18','\0','\0','\0','\0','\0',''),(318,'ACCOUNTING','F.17','\0','\0','\0','\0','\0',''),(319,'ACCOUNTING','F.15','\0','\0','\0','\0','\0',''),(320,'DIRECTOR','G.4','','','','','',''),(321,'DIRECTOR','A.1','','','','','',''),(322,'DIRECTOR','A.2','','','','','',''),(323,'DIRECTOR','A.5','','','','','',''),(324,'DIRECTOR','F.3','','','','','',''),(325,'DIRECTOR','F.1','','','','','',''),(326,'DIRECTOR','F.2','','','','','',''),(327,'DIRECTOR','D.4','','','','','',''),(328,'DIRECTOR','D.5','','','','','',''),(329,'DIRECTOR','A.7','','','','','',''),(330,'DIRECTOR','E.2','','','','','',''),(331,'DIRECTOR','H.1','','','','','',''),(332,'DIRECTOR','F.4','','','','','',''),(333,'DIRECTOR','A.4','','','','','',''),(334,'DIRECTOR','B.4','','','','','',''),(335,'DIRECTOR','B.5','','','','','',''),(336,'DIRECTOR','B.1','','','','','',''),(337,'DIRECTOR','B.2','','','','','',''),(338,'DIRECTOR','B.3','','','','','',''),(339,'DIRECTOR','F.5','','','','','',''),(340,'DIRECTOR','B.12','','','','','',''),(341,'DIRECTOR','B.10','','','','','',''),(342,'DIRECTOR','B.11','','','','','',''),(343,'DIRECTOR','G.3','','','','','',''),(344,'DIRECTOR','A.3','','','','','',''),(345,'DIRECTOR','F.6','','','','','',''),(346,'DIRECTOR','F.7','','','','','',''),(347,'DIRECTOR','F.19','','','','','',''),(348,'DIRECTOR','G.5','','','','','',''),(349,'DIRECTOR','F.8','','','','','',''),(350,'DIRECTOR','F.9','','','','','',''),(351,'DIRECTOR','F.10','','','','','',''),(352,'DIRECTOR','C.1','','','','','',''),(353,'DIRECTOR','C.2','','','','','',''),(354,'DIRECTOR','C.3','','','','','',''),(355,'DIRECTOR','F.11','','','','','',''),(356,'DIRECTOR','F.12','','','','','',''),(357,'DIRECTOR','D.2','','','','','',''),(358,'DIRECTOR','D.1','','','','','',''),(359,'DIRECTOR','D.3','','','','','',''),(360,'DIRECTOR','E.3','','','','','',''),(361,'DIRECTOR','E.4','','','','','',''),(362,'DIRECTOR','G.1','','','','','',''),(363,'DIRECTOR','H.2','','','','','',''),(364,'DIRECTOR','B.8','','','','','',''),(365,'DIRECTOR','B.6','','','','','',''),(366,'DIRECTOR','B.7','','','','','',''),(367,'DIRECTOR','B.9','','','','','',''),(368,'DIRECTOR','F.13','','','','','',''),(369,'DIRECTOR','C.4','','','','','',''),(370,'DIRECTOR','A.6','','','','','',''),(371,'DIRECTOR','C.5','','','','','',''),(372,'DIRECTOR','E.1','','','','','',''),(373,'DIRECTOR','F.14','','','','','',''),(374,'DIRECTOR','G.2','','','','','',''),(375,'DIRECTOR','F.16','','','','','',''),(376,'DIRECTOR','F.18','','','','','',''),(377,'DIRECTOR','F.17','','','','','',''),(378,'DIRECTOR','F.15','','','','','',''),(379,'SAMPLING','G.4','\0','\0','\0','\0','\0',''),(380,'SAMPLING','A.1','\0','\0','\0','\0','\0',''),(381,'SAMPLING','A.2','\0','\0','\0','\0','\0',''),(382,'SAMPLING','A.5','\0','\0','\0','\0','\0',''),(383,'SAMPLING','F.3','\0','\0','\0','\0','\0',''),(384,'SAMPLING','F.1','\0','\0','\0','\0','\0',''),(385,'SAMPLING','F.2','\0','\0','\0','\0','\0',''),(386,'SAMPLING','D.4','\0','\0','\0','\0','\0',''),(387,'SAMPLING','D.5','\0','\0','\0','\0','\0',''),(388,'SAMPLING','A.7','\0','\0','\0','\0','\0',''),(389,'SAMPLING','E.2','','','','','',''),(390,'SAMPLING','H.1','\0','\0','\0','\0','\0',''),(391,'SAMPLING','F.4','\0','\0','\0','\0','\0',''),(392,'SAMPLING','A.4','\0','\0','\0','\0','\0',''),(393,'SAMPLING','B.4','\0','\0','\0','\0','\0',''),(394,'SAMPLING','B.5','\0','\0','\0','\0','\0',''),(395,'SAMPLING','B.1','\0','\0','\0','\0','\0',''),(396,'SAMPLING','B.2','\0','\0','\0','\0','\0',''),(397,'SAMPLING','B.3','\0','\0','\0','\0','\0',''),(398,'SAMPLING','F.5','\0','\0','\0','\0','\0',''),(399,'SAMPLING','B.12','\0','\0','\0','\0','\0',''),(400,'SAMPLING','B.10','\0','\0','\0','\0','\0',''),(401,'SAMPLING','B.11','\0','\0','\0','\0','\0',''),(402,'SAMPLING','G.3','\0','\0','\0','\0','\0',''),(403,'SAMPLING','A.3','\0','\0','\0','\0','\0',''),(404,'SAMPLING','F.6','\0','\0','\0','\0','\0',''),(405,'SAMPLING','F.7','\0','\0','\0','\0','\0',''),(406,'SAMPLING','F.19','\0','\0','\0','\0','\0',''),(407,'SAMPLING','G.5','\0','\0','\0','\0','\0',''),(408,'SAMPLING','F.8','\0','\0','\0','\0','\0',''),(409,'SAMPLING','F.9','\0','\0','\0','\0','\0',''),(410,'SAMPLING','F.10','\0','\0','\0','\0','\0',''),(411,'SAMPLING','C.1','\0','\0','\0','\0','\0',''),(412,'SAMPLING','C.2','\0','\0','\0','\0','\0',''),(413,'SAMPLING','C.3','\0','\0','\0','\0','\0',''),(414,'SAMPLING','F.11','\0','\0','\0','\0','\0',''),(415,'SAMPLING','F.12','\0','\0','\0','\0','\0',''),(416,'SAMPLING','D.2','\0','\0','\0','\0','\0',''),(417,'SAMPLING','D.1','\0','\0','\0','\0','\0',''),(418,'SAMPLING','D.3','\0','\0','\0','\0','\0',''),(419,'SAMPLING','E.3','','','','','',''),(420,'SAMPLING','E.4','','','','','',''),(421,'SAMPLING','G.1','\0','\0','\0','\0','\0',''),(422,'SAMPLING','H.2','\0','\0','\0','\0','\0',''),(423,'SAMPLING','B.8','\0','\0','\0','\0','\0',''),(424,'SAMPLING','B.6','\0','\0','\0','\0','\0',''),(425,'SAMPLING','B.7','\0','\0','\0','\0','\0',''),(426,'SAMPLING','B.9','\0','\0','\0','\0','\0',''),(427,'SAMPLING','F.13','\0','\0','\0','\0','\0',''),(428,'SAMPLING','C.4','\0','\0','\0','\0','\0',''),(429,'SAMPLING','A.6','\0','\0','\0','\0','\0',''),(430,'SAMPLING','C.5','\0','\0','\0','\0','\0',''),(431,'SAMPLING','E.1','','','','','',''),(432,'SAMPLING','F.14','\0','\0','\0','\0','\0',''),(433,'SAMPLING','G.2','\0','\0','\0','\0','\0',''),(434,'SAMPLING','F.16','\0','\0','\0','\0','\0',''),(435,'SAMPLING','F.18','\0','\0','\0','\0','\0',''),(436,'SAMPLING','F.17','\0','\0','\0','\0','\0',''),(437,'SAMPLING','F.15','\0','\0','\0','\0','\0',''),(438,'WAREHOUSE','G.4','\0','\0','\0','\0','\0',''),(439,'WAREHOUSE','A.1','\0','\0','\0','\0','\0',''),(440,'WAREHOUSE','A.2','\0','\0','\0','\0','\0',''),(441,'WAREHOUSE','A.5','\0','\0','\0','\0','\0',''),(442,'WAREHOUSE','F.3','\0','\0','\0','\0','\0',''),(443,'WAREHOUSE','F.1','\0','\0','\0','\0','\0',''),(444,'WAREHOUSE','F.2','\0','\0','\0','\0','\0',''),(445,'WAREHOUSE','D.4','\0','\0','\0','\0','\0',''),(446,'WAREHOUSE','D.5','\0','\0','\0','\0','\0',''),(447,'WAREHOUSE','A.7','\0','\0','\0','\0','\0',''),(448,'WAREHOUSE','E.2','\0','\0','\0','\0','\0',''),(449,'WAREHOUSE','H.1','\0','\0','\0','\0','\0',''),(450,'WAREHOUSE','F.4','\0','\0','\0','\0','\0',''),(451,'WAREHOUSE','A.4','\0','\0','\0','\0','\0',''),(452,'WAREHOUSE','B.4','','','','','',''),(453,'WAREHOUSE','B.5','','','','','',''),(454,'WAREHOUSE','B.1','','','','','',''),(455,'WAREHOUSE','B.2','','','','','',''),(456,'WAREHOUSE','B.3','','','','','',''),(457,'WAREHOUSE','F.5','\0','\0','\0','\0','\0',''),(458,'WAREHOUSE','B.12','','','','','',''),(459,'WAREHOUSE','B.10','','','','','',''),(460,'WAREHOUSE','B.11','','','','','',''),(461,'WAREHOUSE','G.3','','','','','',''),(462,'WAREHOUSE','A.3','\0','\0','\0','\0','\0',''),(463,'WAREHOUSE','F.6','\0','\0','\0','\0','\0',''),(464,'WAREHOUSE','F.7','\0','\0','\0','\0','\0',''),(465,'WAREHOUSE','F.19','\0','\0','\0','\0','\0',''),(466,'WAREHOUSE','G.5','','','','','',''),(467,'WAREHOUSE','F.8','','','','','',''),(468,'WAREHOUSE','F.9','\0','\0','\0','\0','\0',''),(469,'WAREHOUSE','F.10','\0','\0','\0','\0','\0',''),(470,'WAREHOUSE','C.1','\0','\0','\0','\0','\0',''),(471,'WAREHOUSE','C.2','\0','\0','\0','\0','\0',''),(472,'WAREHOUSE','C.3','\0','\0','\0','\0','\0',''),(473,'WAREHOUSE','F.11','\0','\0','\0','\0','\0',''),(474,'WAREHOUSE','F.12','\0','\0','\0','\0','\0',''),(475,'WAREHOUSE','D.2','','','','','',''),(476,'WAREHOUSE','D.1','','','','','',''),(477,'WAREHOUSE','D.3','','','','','',''),(478,'WAREHOUSE','E.3','\0','\0','\0','\0','\0',''),(479,'WAREHOUSE','E.4','\0','\0','\0','\0','\0',''),(480,'WAREHOUSE','G.1','\0','\0','\0','\0','\0',''),(481,'WAREHOUSE','H.2','\0','\0','\0','\0','\0',''),(482,'WAREHOUSE','B.8','','','','','',''),(483,'WAREHOUSE','B.6','','','','','',''),(484,'WAREHOUSE','B.7','','','','','',''),(485,'WAREHOUSE','B.9','','','','','',''),(486,'WAREHOUSE','F.13','\0','\0','\0','\0','\0',''),(487,'WAREHOUSE','C.4','\0','\0','\0','\0','\0',''),(488,'WAREHOUSE','A.6','\0','\0','\0','\0','\0',''),(489,'WAREHOUSE','C.5','\0','\0','\0','\0','\0',''),(490,'WAREHOUSE','E.1','\0','\0','\0','\0','\0',''),(491,'WAREHOUSE','F.14','\0','\0','\0','\0','\0',''),(492,'WAREHOUSE','G.2','\0','\0','\0','\0','\0',''),(493,'WAREHOUSE','F.16','\0','\0','\0','\0','\0',''),(494,'WAREHOUSE','F.18','\0','\0','\0','\0','\0',''),(495,'WAREHOUSE','F.17','\0','\0','\0','\0','\0',''),(496,'WAREHOUSE','F.15','','','','','',''),(497,'PURCHASE','G.4','\0','\0','\0','\0','\0',''),(498,'PURCHASE','A.1','\0','\0','\0','\0','\0',''),(499,'PURCHASE','A.2','\0','\0','\0','\0','\0',''),(500,'PURCHASE','A.5','\0','\0','\0','\0','\0',''),(501,'PURCHASE','F.3','\0','\0','\0','\0','\0',''),(502,'PURCHASE','F.1','\0','\0','\0','\0','\0',''),(503,'PURCHASE','F.2','','','','','',''),(504,'PURCHASE','D.4','\0','\0','\0','\0','\0',''),(505,'PURCHASE','D.5','\0','\0','\0','\0','\0',''),(506,'PURCHASE','A.7','\0','\0','\0','\0','\0',''),(507,'PURCHASE','E.2','\0','\0','\0','\0','\0',''),(508,'PURCHASE','H.1','','','','','',''),(509,'PURCHASE','F.4','','','','','',''),(510,'PURCHASE','A.4','\0','\0','\0','\0','\0',''),(511,'PURCHASE','B.4','','','','','',''),(512,'PURCHASE','B.5','','','','','',''),(513,'PURCHASE','B.1','','','','','',''),(514,'PURCHASE','B.2','','','','','',''),(515,'PURCHASE','B.3','','','','','',''),(516,'PURCHASE','F.5','','','','','',''),(517,'PURCHASE','B.12','','','','','',''),(518,'PURCHASE','B.10','\0','\0','\0','\0','\0',''),(519,'PURCHASE','B.11','\0','\0','\0','\0','\0',''),(520,'PURCHASE','G.3','\0','\0','\0','\0','\0',''),(521,'PURCHASE','A.3','\0','\0','\0','\0','\0',''),(522,'PURCHASE','F.6','\0','\0','\0','\0','\0',''),(523,'PURCHASE','F.7','','','','','',''),(524,'PURCHASE','F.19','','','','','',''),(525,'PURCHASE','G.5','','','','','',''),(526,'PURCHASE','F.8','','','','','',''),(527,'PURCHASE','F.9','','','','','',''),(528,'PURCHASE','F.10','','','','','',''),(529,'PURCHASE','C.1','','','','','',''),(530,'PURCHASE','C.2','','','','','',''),(531,'PURCHASE','C.3','','','','','',''),(532,'PURCHASE','F.11','','','','','',''),(533,'PURCHASE','F.12','','','','','',''),(534,'PURCHASE','D.2','','','','','',''),(535,'PURCHASE','D.1','','','','','',''),(536,'PURCHASE','D.3','','','','','',''),(537,'PURCHASE','E.3','\0','\0','\0','\0','\0',''),(538,'PURCHASE','E.4','\0','\0','\0','\0','\0',''),(539,'PURCHASE','G.1','\0','\0','\0','\0','\0',''),(540,'PURCHASE','H.2','\0','\0','\0','\0','\0',''),(541,'PURCHASE','B.8','\0','\0','\0','\0','\0',''),(542,'PURCHASE','B.6','','','','','',''),(543,'PURCHASE','B.7','','','','','',''),(544,'PURCHASE','B.9','\0','\0','\0','\0','\0',''),(545,'PURCHASE','F.13','','','','','',''),(546,'PURCHASE','C.4','\0','\0','\0','\0','\0',''),(547,'PURCHASE','A.6','\0','\0','\0','\0','\0',''),(548,'PURCHASE','C.5','\0','\0','\0','\0','\0',''),(549,'PURCHASE','E.1','\0','\0','\0','\0','\0',''),(550,'PURCHASE','F.14','\0','\0','\0','\0','\0',''),(551,'PURCHASE','G.2','','','','','',''),(552,'PURCHASE','F.16','\0','\0','\0','\0','\0',''),(553,'PURCHASE','F.18','\0','\0','\0','\0','\0',''),(554,'PURCHASE','F.17','\0','\0','\0','\0','\0',''),(555,'PURCHASE','F.15','','','','','',''),(556,'ADMIN','A.8','','','','','',''),(557,'ACCOUNTING-FETI','G.4','','','','','',''),(558,'ACCOUNTING-FETI','A.8','','','','','',''),(559,'ACCOUNTING-FETI','A.5','','','','','',''),(560,'ACCOUNTING-FETI','F.3','','','','','',''),(561,'ACCOUNTING-FETI','F.1','','','','','',''),(562,'ACCOUNTING-FETI','F.2','','','','','',''),(563,'ACCOUNTING-FETI','D.4','','','','','',''),(564,'ACCOUNTING-FETI','D.5','','','','','',''),(565,'ACCOUNTING-FETI','A.7','','','','','',''),(566,'ACCOUNTING-FETI','E.2','\0','\0','\0','\0','\0',''),(567,'ACCOUNTING-FETI','H.1','\0','\0','\0','\0','\0',''),(568,'ACCOUNTING-FETI','F.4','\0','\0','\0','\0','\0',''),(569,'ACCOUNTING-FETI','A.4','','','','','',''),(570,'ACCOUNTING-FETI','B.4','','','','','',''),(571,'ACCOUNTING-FETI','B.5','','','','','',''),(572,'ACCOUNTING-FETI','B.1','\0','\0','\0','\0','\0',''),(573,'ACCOUNTING-FETI','B.2','\0','\0','\0','\0','\0',''),(574,'ACCOUNTING-FETI','B.3','\0','\0','\0','\0','\0',''),(575,'ACCOUNTING-FETI','F.5','\0','\0','\0','\0','\0',''),(576,'ACCOUNTING-FETI','B.12','\0','\0','\0','\0','\0',''),(577,'ACCOUNTING-FETI','B.10','\0','\0','\0','\0','\0',''),(578,'ACCOUNTING-FETI','B.11','\0','\0','\0','\0','\0',''),(579,'ACCOUNTING-FETI','G.3','\0','\0','\0','\0','\0',''),(580,'ACCOUNTING-FETI','A.3','','','','','',''),(581,'ACCOUNTING-FETI','F.6','\0','\0','\0','\0','\0',''),(582,'ACCOUNTING-FETI','F.7','\0','\0','\0','\0','\0',''),(583,'ACCOUNTING-FETI','F.19','\0','\0','\0','\0','\0',''),(584,'ACCOUNTING-FETI','G.5','\0','\0','\0','\0','\0',''),(585,'ACCOUNTING-FETI','F.8','\0','\0','\0','\0','\0',''),(586,'ACCOUNTING-FETI','F.9','\0','\0','\0','\0','\0',''),(587,'ACCOUNTING-FETI','F.10','\0','\0','\0','\0','\0',''),(588,'ACCOUNTING-FETI','C.1','\0','\0','\0','\0','\0',''),(589,'ACCOUNTING-FETI','C.2','\0','\0','\0','\0','\0',''),(590,'ACCOUNTING-FETI','C.3','\0','\0','\0','\0','\0',''),(591,'ACCOUNTING-FETI','F.11','\0','\0','\0','\0','\0',''),(592,'ACCOUNTING-FETI','F.12','\0','\0','\0','\0','\0',''),(593,'ACCOUNTING-FETI','D.2','','','','','',''),(594,'ACCOUNTING-FETI','D.1','\0','\0','\0','\0','\0',''),(595,'ACCOUNTING-FETI','D.3','\0','\0','\0','\0','\0',''),(596,'ACCOUNTING-FETI','E.3','\0','\0','\0','\0','\0',''),(597,'ACCOUNTING-FETI','E.4','\0','\0','\0','\0','\0',''),(598,'ACCOUNTING-FETI','G.1','\0','\0','\0','\0','\0',''),(599,'ACCOUNTING-FETI','H.2','\0','\0','\0','\0','\0',''),(600,'ACCOUNTING-FETI','B.8','\0','\0','\0','\0','\0',''),(601,'ACCOUNTING-FETI','B.6','','','','','',''),(602,'ACCOUNTING-FETI','B.7','','','','','',''),(603,'ACCOUNTING-FETI','B.9','\0','\0','\0','\0','\0',''),(604,'ACCOUNTING-FETI','F.13','','','','','',''),(605,'ACCOUNTING-FETI','C.4','','','','','',''),(606,'ACCOUNTING-FETI','A.6','','','','','',''),(607,'ACCOUNTING-FETI','C.5','','','','','',''),(608,'ACCOUNTING-FETI','E.1','\0','\0','\0','\0','\0',''),(609,'ACCOUNTING-FETI','F.14','','','','','',''),(610,'ACCOUNTING-FETI','G.2','','','','','',''),(611,'ACCOUNTING-FETI','F.16','\0','\0','\0','\0','\0',''),(612,'ACCOUNTING-FETI','F.18','\0','\0','\0','\0','\0',''),(613,'ACCOUNTING-FETI','F.17','\0','\0','\0','\0','\0',''),(614,'ACCOUNTING-FETI','F.15','\0','\0','\0','\0','\0',''),(615,'ACCOUNTING','A.8','','','','','',''),(616,'DIRECTOR','A.8','','','','','',''),(617,'PURCHASE','A.8','\0','\0','\0','\0','\0',''),(618,'WAREHOUSE','A.8','\0','\0','\0','\0','\0',''),(619,'SAMPLING','A.8','\0','\0','\0','\0','\0',''),(620,'MARKETING','G.4','\0','\0','\0','\0','\0',''),(621,'MARKETING','A.8','\0','\0','\0','\0','\0',''),(622,'MARKETING','A.5','\0','\0','\0','\0','\0',''),(623,'MARKETING','F.3','\0','\0','\0','\0','\0',''),(624,'MARKETING','F.1','\0','\0','\0','\0','\0',''),(625,'MARKETING','F.2','','','','','',''),(626,'MARKETING','D.4','','','','','',''),(627,'MARKETING','D.5','','','','','',''),(628,'MARKETING','A.7','\0','\0','\0','\0','\0',''),(629,'MARKETING','E.2','\0','\0','\0','\0','\0',''),(630,'MARKETING','H.1','\0','\0','\0','\0','\0',''),(631,'MARKETING','F.4','\0','\0','\0','\0','\0',''),(632,'MARKETING','A.4','\0','\0','\0','\0','\0',''),(633,'MARKETING','B.4','\0','\0','\0','\0','\0',''),(634,'MARKETING','B.5','\0','\0','\0','\0','\0',''),(635,'MARKETING','B.1','\0','\0','\0','\0','\0',''),(636,'MARKETING','B.2','\0','\0','\0','\0','\0',''),(637,'MARKETING','B.3','\0','\0','\0','\0','\0',''),(638,'MARKETING','F.5','\0','\0','\0','\0','\0',''),(639,'MARKETING','B.12','\0','\0','\0','\0','\0',''),(640,'MARKETING','B.10','\0','\0','\0','\0','\0',''),(641,'MARKETING','B.11','\0','\0','\0','\0','\0',''),(642,'MARKETING','G.3','\0','\0','\0','\0','\0',''),(643,'MARKETING','A.3','\0','\0','\0','\0','\0',''),(644,'MARKETING','F.6','\0','\0','\0','\0','\0',''),(645,'MARKETING','F.7','\0','\0','\0','\0','\0',''),(646,'MARKETING','F.19','\0','\0','\0','\0','\0',''),(647,'MARKETING','G.5','\0','\0','\0','\0','\0',''),(648,'MARKETING','F.8','\0','\0','\0','\0','\0',''),(649,'MARKETING','F.9','\0','\0','\0','\0','\0',''),(650,'MARKETING','F.10','\0','\0','\0','\0','\0',''),(651,'MARKETING','C.1','\0','\0','\0','\0','\0',''),(652,'MARKETING','C.2','\0','\0','\0','\0','\0',''),(653,'MARKETING','C.3','\0','\0','\0','\0','\0',''),(654,'MARKETING','F.11','\0','\0','\0','\0','\0',''),(655,'MARKETING','F.12','\0','\0','\0','\0','\0',''),(656,'MARKETING','D.2','','','','','',''),(657,'MARKETING','D.1','','','','','',''),(658,'MARKETING','D.3','','','','','',''),(659,'MARKETING','E.3','\0','\0','\0','\0','\0',''),(660,'MARKETING','E.4','\0','\0','\0','\0','\0',''),(661,'MARKETING','G.1','\0','\0','\0','\0','\0',''),(662,'MARKETING','H.2','\0','\0','\0','\0','\0',''),(663,'MARKETING','B.8','\0','\0','\0','\0','\0',''),(664,'MARKETING','B.6','\0','\0','\0','\0','\0',''),(665,'MARKETING','B.7','\0','\0','\0','\0','\0',''),(666,'MARKETING','B.9','\0','\0','\0','\0','\0',''),(667,'MARKETING','F.13','','','','','',''),(668,'MARKETING','C.4','\0','\0','\0','\0','\0',''),(669,'MARKETING','A.6','\0','\0','\0','\0','\0',''),(670,'MARKETING','C.5','\0','\0','\0','\0','\0',''),(671,'MARKETING','E.1','\0','\0','\0','\0','\0',''),(672,'MARKETING','F.14','\0','\0','\0','\0','\0',''),(673,'MARKETING','G.2','\0','\0','\0','\0','\0',''),(674,'MARKETING','F.16','\0','\0','\0','\0','\0',''),(675,'MARKETING','F.18','\0','\0','\0','\0','\0',''),(676,'MARKETING','F.17','\0','\0','\0','\0','\0',''),(677,'MARKETING','F.15','\0','\0','\0','\0','\0',''),(678,'ACCOUNTING','C.6','','','','','',''),(679,'ACCOUNTING-FETI','C.6','','','','','',''),(680,'ADMIN','C.6','','','','','',''),(681,'DIRECTOR','C.6','','','','','',''),(682,'MARKETING','C.6','','','','','',''),(683,'PURCHASE','C.6','','','','','',''),(684,'SAMPLING','C.6','','','','','',''),(685,'WAREHOUSE','C.6','','','','','','');
/*!40000 ALTER TABLE `ms_useraccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_warehouse`
--

DROP TABLE IF EXISTS `ms_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_warehouse` (
  `warehouseID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Warehouse ID',
  `warehouseName` varchar(50) NOT NULL COMMENT 'Warehouse Name',
  `address` varchar(100) DEFAULT NULL COMMENT 'Address',
  `phone` varchar(20) DEFAULT NULL COMMENT 'Phone',
  `flagActive` bit(1) NOT NULL COMMENT 'Flag Active',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`warehouseID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_warehouse`
--

LOCK TABLES `ms_warehouse` WRITE;
/*!40000 ALTER TABLE `ms_warehouse` DISABLE KEYS */;
INSERT INTO `ms_warehouse` VALUES (5,'Gudang Bahan Baku Farmasi','Komplek Pertokoan Green Garden blok A7 No 5 & 6, Kedoya Utara, Kebon Jeruk, Jakarta Barat 11520','021 5802720','','admin','2016-11-14 10:13:08','yudhi','2018-01-17 14:45:04'),(7,'Gudang Utama','Pertokoan Green Garden Blok A14 No. 39  Kedoya Jakarta Barat','021-5802720','','admin','2017-10-12 13:57:39','admin','2017-10-12 13:57:39'),(8,'Warehouse 1','Pertokoan Green Garden Blok A14 No. 39\r\nKedoya, Jakarta Barat','021-5802720-53857791','\0','admin','2017-11-27 10:42:37','admin','2017-11-27 10:42:37');
/*!40000 ALTER TABLE `ms_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_cashbanktransfer`
--

DROP TABLE IF EXISTS `tr_cashbanktransfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_cashbanktransfer` (
  `transferID` varchar(50) NOT NULL,
  `transferDate` datetime NOT NULL,
  `sourceCurrency` varchar(20) NOT NULL,
  `destinationCurrency` varchar(20) NOT NULL,
  `sourceRate` decimal(18,2) NOT NULL,
  `destinationRate` decimal(18,2) NOT NULL,
  `sourceAmount` decimal(18,2) NOT NULL,
  `additionalInfo` varchar(200) DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `editedBy` varchar(50) DEFAULT NULL,
  `editedDate` datetime DEFAULT NULL,
  `voucherNum` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`transferID`),
  KEY `fk_cashbanktransfer_sourcecurrency_idx` (`sourceCurrency`),
  KEY `fk_cashbanktransfer_destcurrency_idx` (`destinationCurrency`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_cashbanktransfer`
--

LOCK TABLES `tr_cashbanktransfer` WRITE;
/*!40000 ALTER TABLE `tr_cashbanktransfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_cashbanktransfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_cashinoutdetail`
--

DROP TABLE IF EXISTS `tr_cashinoutdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_cashinoutdetail` (
  `cashDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `cashInOutNum` varchar(50) NOT NULL,
  `destinationAccount` varchar(20) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `notes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cashDetailID`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_cashinoutdetail`
--

LOCK TABLES `tr_cashinoutdetail` WRITE;
/*!40000 ALTER TABLE `tr_cashinoutdetail` DISABLE KEYS */;
INSERT INTO `tr_cashinoutdetail` VALUES (26,'QJA/CI/18/I/001','9110.0001',10000000.00,'Kas Kecil'),(28,'QJA/CO/18/I/008','6111.0009',621000.00,'By Perpanjang STNK - FENDI'),(29,'QJA/CO/18/I/009','6111.0004',1929571.00,'PLN & PAM Blok A7/6 & Kontrakan'),(30,'QJA/CO/18/I/009','6111.0027',29.00,'By Lain - Lain'),(31,'QJA/CO/18/I/010','6111.0005',420863.00,'By Telepon Kantor'),(32,'QJA/CO/18/I/010','6111.0027',37.00,'By Lain - Lain'),(33,'QJA/CO/18/I/005','6111.0017',100000.00,'By Rekomendasi Apoteker - SAIBA'),(34,'QJA/CO/18/I/004','6111.0020',2325000.00,'By Cetak 5 Box Surat Jalan @  Rp. 465.000,-'),(35,'QJA/CO/18/I/002','6111.0002',600000.00,'Beli 100 pcs Materai @ 6.000,-'),(36,'QJA/CO/18/I/003','6111.0022',4250000.00,'By Install Software Microsoft Laptop Bp Nurdin'),(37,'QJA/CO/18/I/003','6111.0027',100000.00,'Fee Teknisi'),(38,'QJA/CO/18/I/012','6111.0022',920000.00,'bY sERVICE pRINTER epson l565'),(39,'QJA/CO/18/I/012','6111.0020',245000.00,'bY tINTA pRINTER f73n'),(45,'QJA/CO/18/I/015','6110.0005',145000.00,'By Pengobatan Karyawan - MAITRI'),(46,'QJA/CO/18/I/015','6111.0027',50000.00,'By Lain - Lain'),(47,'QJA/CO/18/I/016','6111.0002',600000.00,'Beli 100 Bh Materai @ 6.000,-'),(48,'QJA/CO/18/I/007','6112.0005',60000.00,'By Kirim Sample 14 Gr MELOXICAM'),(49,'QJA/CO/18/I/007','1122.0007',6000.00,'PPN VAT 10%'),(50,'QJA/CO/18/I/020','6111.0020',605500.00,'ATK'),(51,'QJA/CO/18/I/018','6111.0008',325000.00,'By Keamanan Kantor Jan 18'),(52,'QJA/CO/18/I/006','6111.0008',275000.00,'By Keamanan Kantor Bln Jan 18'),(53,'QJA/CO/18/I/006','2118.0003',825000.00,'By Keamanan Kantor Okt 17 - Des 17'),(54,'QJA/CO/18/I/011','6111.0002',645987.00,'By Kirim Dokumen'),(55,'QJA/CO/18/I/011','6111.0027',53.00,'By Lain - Lain'),(56,'QJA/CO/18/I/011','1122.0007',6460.00,'PPN VAT 10%'),(57,'QJA/CO/18/I/014','6111.0023',124000.00,'By Service Motor - FENDI'),(64,'QJA/CO/18/I/013','5110.0007',608000.00,'Bea Masuk'),(65,'QJA/CO/18/I/013','6111.0010',45000.00,'By Adm Bank'),(66,'QJA/CO/18/I/013','6112.0012',15000.00,'By Sewa Gudang'),(67,'QJA/CO/18/I/013','6112.0008',100000.00,'By Impor'),(68,'QJA/CO/18/I/013','1122.0007',885500.00,'Uang Muka Pajak'),(69,'QJA/CO/18/I/013','1122.0004',872000.00,'PPh 22'),(70,'QJA/CO/18/I/013','6112.0006',20000.00,'By Dokumen'),(71,'QJA/CO/18/I/017','6111.0021',200000.00,'By Pengecekan Listrik di A14/39'),(73,'QJA/CO/18/I/019','6111.0020',1625000.00,'By Cetakan Kartu Nama @ 125.000,-'),(74,'QJA/CI/18/I/021','9110.0001',5000000.00,'Kas Kecil'),(76,'QJA/CO/18/I/023','6111.0023',125000.00,'By Ganti Pelampung Motor BEAT'),(77,'QJA/CI/18/I/024','9110.0001',5000000.00,'Kas Kecil'),(78,'QJA/CO/18/II/022','6111.0023',860200.00,'Ganti Accu Toyota VIOS'),(79,'QJA/CO/18/I/025','6111.0020',1680000.00,'By Cetak Kop Surat 12 Rim @ 140.000,-'),(80,'QJA/CO/18/I/026','6111.0018',1000000.00,'Petugas PTSP = 2 orang @ 500.000,-'),(82,'QJA/CI/18/I/028','9110.0001',5000000.00,'Kas Kecil'),(83,'QJA/CO/18/I/027','6111.0002',600000.00,'Beli 100 Bh Materai @ 6.000,-'),(84,'QJA/CO/18/I/029','6111.0023',40000.00,'By ganti Ban Dalam Supra X - FENDI'),(85,'QJA/CO/18/I/030','6111.0009',2370000.00,'By Perpanjang STNK AVEGA GT'),(86,'QJA/CO/18/I/031','6110.0011',1708000.00,'By Asuransi Karyawan'),(87,'QJA/CO/18/I/032','6111.0023',48000.00,'By Ganti Oli - Bp KHIONG'),(88,'QJA/CO/18/I/033','6111.0030',1223898.00,'By Perjalanan Dinas Bp NURDIN Jkt - Sg - Jkt '),(89,'QJA/CO/18/I/033','6111.0027',2.00,'By Lain - Lain'),(90,'QJA/CI/18/I/034','9110.0001',5000000.00,'Kas kecil'),(91,'QJA/CO/18/I/035','6112.0011',1600000.00,'GRACIA PHARMINDO - 2.240 Kg LACTULOSE'),(92,'QJA/CO/18/I/035','6112.0001',227000.00,'By Angkut/Kuli'),(93,'QJA/CO/18/I/036','6111.0018',2000000.00,'Bunga Papan untuk Pernikahan Customer - INTERBAT'),(94,'QJA/CO/18/I/037','6110.0003',1330000.00,'Uang Muka Karyawan Jan 18'),(95,'QJA/CO/18/I/038','6111.0026',910000.00,'By. transfer Bank ke PRINCIPAL'),(96,'QJA/CO/18/I/039','6112.0008',1450000.00,'29 Lbr By Ijin Impor @ 50.000,-'),(98,'QJA/CO/18/II/040','6112.0011',1319500.00,'By Kirim Barang ke Customer'),(99,'QJA/CO/18/I/041','6111.0002',120000.00,'By Kirim Dok - TIKI '),(104,'QJA/CO/18/I/042','6111.0024',544000.00,'By Dapur'),(105,'QJA/CO/18/I/042','6111.0007',1639000.00,'By Bensin, Parkir & Tol AVEGA GT & Isi e-Money 301.000,-'),(106,'QJA/CO/18/I/042','6112.0001',110000.00,'By Tips Kuli saat Penjualan'),(107,'QJA/CO/18/I/042','6111.0021',140000.00,'Beli Kunci Pintu Gudang Lantai 1'),(108,'QJA/CO/18/I/043','6111.0007',95000.00,'Expense YUDI Jan 18'),(109,'QJA/CO/18/I/043','6111.0023',315000.00,'By. Service & Ganti Spare Part Honda VARIO'),(110,'QJA/CO/18/I/044','6111.0007',187000.00,'Exp WAWAN Jan 18'),(111,'QJA/CO/18/I/045','6111.0007',108500.00,'Exp BUDI Jan 18'),(112,'QJA/CO/18/I/046','6111.0007',195000.00,'Exp FENDI Jan 18'),(113,'QJA/CO/18/I/047','6111.0007',2322000.00,'Exp Bp NURDIN Jan 18');
/*!40000 ALTER TABLE `tr_cashinoutdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_cashinouthead`
--

DROP TABLE IF EXISTS `tr_cashinouthead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_cashinouthead` (
  `cashInOutNum` varchar(50) NOT NULL COMMENT 'Cash In Number',
  `voucherNum` varchar(50) DEFAULT NULL,
  `refNum` varchar(50) DEFAULT NULL,
  `cashInOutDate` datetime NOT NULL COMMENT 'Cash In Date',
  `penerima` varchar(200) DEFAULT NULL,
  `checkOrGiroNum` varchar(50) DEFAULT NULL,
  `checkOrGiroDate` datetime DEFAULT NULL,
  `currencyID` varchar(5) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `cashAccount` varchar(20) NOT NULL COMMENT 'Cash Account',
  `additionalInfo` varchar(200) DEFAULT NULL COMMENT 'Additional Info',
  `flagCashInOut` varchar(50) DEFAULT NULL,
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`cashInOutNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_cashinouthead`
--

LOCK TABLES `tr_cashinouthead` WRITE;
/*!40000 ALTER TABLE `tr_cashinouthead` DISABLE KEYS */;
INSERT INTO `tr_cashinouthead` VALUES ('QJA/CI/18/I/001','KM-1801-001','','2018-01-10 00:00:00','Kas Kecil','',NULL,'IDR',1.00,'1110.0001','kAS kECIL','in','maitri','2018-02-08 13:33:13','maitri','2018-02-08 15:53:08'),('QJA/CI/18/I/021','KM-1801-002','','2018-01-18 00:00:00','Kas Kecil','',NULL,'IDR',1.00,'1110.0001','Kas Kecil','in','maitri','2018-02-09 09:33:27','maitri','2018-02-09 09:33:27'),('QJA/CI/18/I/024','KM-1801-003','','2018-01-24 00:00:00','Kas Kecil','',NULL,'IDR',1.00,'1110.0001','Kas Kecil','in','maitri','2018-02-09 09:55:10','maitri','2018-02-09 09:55:10'),('QJA/CI/18/I/028','KM-1801-004','','2018-01-26 00:00:00','Kas Kecil','',NULL,'IDR',1.00,'1110.0001','Kas Kecil','in','maitri','2018-02-09 10:06:25','maitri','2018-02-09 10:06:25'),('QJA/CI/18/I/034','KM-1801-005','','2018-01-30 00:00:00','Kas Kecil','',NULL,'IDR',1.00,'1110.0001','Kas Kecil','in','maitri','2018-02-09 13:22:28','maitri','2018-02-09 13:22:28'),('QJA/CO/18/I/002','KK-1801-001','','2018-01-05 00:00:00','-','',NULL,'IDR',1.00,'1110.0001','Beli 100 Bh Materai @ 6.000,-','out','maitri','2018-02-08 14:42:20','maitri','2018-02-08 15:57:57'),('QJA/CO/18/I/003','KK-1801-002','','2018-01-05 00:00:00','-','',NULL,'IDR',1.00,'1110.0001','By. Instal Microsoft Laptop Bp Nurdin W','out','maitri','2018-02-08 14:46:38','maitri','2018-02-08 15:58:51'),('QJA/CO/18/I/004','KK-1801-003','','2018-01-08 00:00:00','CV PERSADA MANDIRI','',NULL,'IDR',1.00,'1110.0001','By Cetakan Surat Jalan\r\n5 Box @ Rp. 465.000,-','out','maitri','2018-02-08 14:51:08','maitri','2018-02-08 15:57:33'),('QJA/CO/18/I/005','KK-1801-004','','2018-01-09 00:00:00','IAI','',NULL,'IDR',1.00,'1110.0001','By Rekomendasi Apoteker - SAIBA','out','maitri','2018-02-08 14:57:24','maitri','2018-02-08 15:56:56'),('QJA/CO/18/I/006','KK-1801-005','','2018-01-10 00:00:00','-','',NULL,'IDR',1.00,'1110.0001','By Keamanan kantor periode Okt 17 - Jan 18','out','maitri','2018-02-08 15:00:49','maitri','2018-02-09 09:09:16'),('QJA/CO/18/I/007','KK-1801-006','','2018-01-10 00:00:00','UPS','',NULL,'IDR',1.00,'1110.0001','SAMPLE\r\n14 Gr MELOXICAM','out','maitri','2018-02-08 15:33:22','maitri','2018-02-09 09:01:43'),('QJA/CO/18/I/008','KK-1801-007','','2018-01-10 00:00:00','Biro Jasa MULIA JAYA','',NULL,'IDR',1.00,'1110.0001','By Perpanjangan STNK - FENDI','out','maitri','2018-02-08 15:41:02','maitri','2018-02-08 15:55:31'),('QJA/CO/18/I/009','KK-1801-008','','2018-01-10 00:00:00','PLN & PAM','',NULL,'IDR',1.00,'1110.0001','PLN & PAM Jan 18','out','maitri','2018-02-08 15:42:36','maitri','2018-02-08 15:55:58'),('QJA/CO/18/I/010','KK-1801-009','','2018-01-10 00:00:00','TELKOM','',NULL,'IDR',1.00,'1110.0001','By Telepon kantor Jan 18','out','maitri','2018-02-08 15:48:44','maitri','2018-02-08 15:56:25'),('QJA/CO/18/I/011','KK-1801-010','','2018-01-12 00:00:00','DHL','',NULL,'IDR',1.00,'1110.0001','By. Kirim Dokumen :\r\nACETO PTE\r\nCHENGDU YAZHONG','out','maitri','2018-02-08 15:51:31','maitri','2018-02-09 09:20:16'),('QJA/CO/18/I/012','KK-1801-011','','2018-01-12 00:00:00','EPSON','',NULL,'IDR',1.00,'1110.0001','bY sERVICE pRINTER epson l565\r\nbELI tINTA pRINTER f73n','out','maitri','2018-02-08 16:02:43','maitri','2018-02-08 16:02:43'),('QJA/CO/18/I/013','KK-1801-012','','2018-01-15 00:00:00','DHL','',NULL,'IDR',1.00,'1110.0001','500 Mg DEXAMETHASONE SOD m-SULPHOBENZOATE','out','maitri','2018-02-08 16:10:48','maitri','2018-02-09 09:26:14'),('QJA/CO/18/I/014','KK-1801-013','','2018-01-15 00:00:00','ARENA MOTOR','',NULL,'IDR',1.00,'1110.0001','By Service Motor SUPRA X 125 D \r\nFENDI','out','maitri','2018-02-08 16:17:05','maitri','2018-02-09 09:22:28'),('QJA/CO/18/I/015','KK-1801-014','','2018-01-16 00:00:00','PONTANA KEDOYA','',NULL,'IDR',1.00,'1110.0001','By Pengobatan Karyawan\r\nMAITRI','out','maitri','2018-02-08 16:20:27','maitri','2018-02-08 16:20:27'),('QJA/CO/18/I/016','KK-1801-015','','2018-01-17 00:00:00','POS INDONESIA','',NULL,'IDR',1.00,'1110.0001','Beli 100 Bh Materai @ 6.000,-','out','maitri','2018-02-08 16:24:16','maitri','2018-02-08 16:24:16'),('QJA/CO/18/I/017','KK-1801-016','','2018-01-17 00:00:00','-','',NULL,'IDR',1.00,'1110.0001','By. Pengecekan Listrik di Blok A14 No. 39','out','maitri','2018-02-08 16:26:42','maitri','2018-02-09 09:28:55'),('QJA/CO/18/I/018','KK-1801-017','','2018-01-18 00:00:00','-','',NULL,'IDR',1.00,'1110.0001','By Keamanan kantor A14/39','out','maitri','2018-02-08 16:28:50','maitri','2018-02-09 09:06:36'),('QJA/CO/18/I/019','KK-1801-018','','2018-01-18 00:00:00','CV PERSADA MANDIRI','',NULL,'IDR',1.00,'1110.0001','By Cetakan Kartu Nama  @ 125.000,-\r\n9 Box - Bp. NURDIN\r\n4 Box - SAIBA','out','maitri','2018-02-08 16:31:34','maitri','2018-02-09 09:30:22'),('QJA/CO/18/I/020','KK-1801-019','','2018-01-19 00:00:00','PACIFIC STATIONARY','',NULL,'IDR',1.00,'1110.0001','ATK','out','maitri','2018-02-08 16:33:30','maitri','2018-02-09 09:04:50'),('QJA/CO/18/I/023','KK-1801-021','','2018-01-23 00:00:00','HONDA AHAS','',NULL,'IDR',1.00,'1110.0001','By Ganti Pelampung BEAT\r\nMAITRI','out','maitri','2018-02-09 09:51:26','maitri','2018-02-09 09:51:26'),('QJA/CO/18/I/025','KK-1801-022','','2018-01-24 00:00:00','CV PERSADA MANDIRI','',NULL,'IDR',1.00,'1110.0001','By Cetak Kop Surat\r\n12 Rim @  Rp. 140.000,-','out','maitri','2018-02-09 09:58:36','maitri','2018-02-09 09:58:36'),('QJA/CO/18/I/026','KK-1801-023','','2018-01-24 00:00:00','-','',NULL,'IDR',1.00,'1110.0001','By Entertainment Petugas PTSP - Pengurusan SIPA Apoteker\r\n2 Orang @  Rp. 500.000,-','out','maitri','2018-02-09 10:01:35','maitri','2018-02-09 10:02:19'),('QJA/CO/18/I/027','KK-1801-024','','2018-01-25 00:00:00','POS INDONESIA','',NULL,'IDR',1.00,'1110.0001','Beli 100 Bh Materai @ 6.000,-','out','maitri','2018-02-09 10:04:02','maitri','2018-02-09 10:10:24'),('QJA/CO/18/I/029','KK-1801-025','','2018-01-25 00:00:00','ARI MOTOR','',NULL,'IDR',1.00,'1110.0001','By Ganti Ban Dalam Supra X 125 D \r\nFENDI','out','maitri','2018-02-09 10:12:38','maitri','2018-02-09 10:12:38'),('QJA/CO/18/I/030','KK-1801-026','','2018-01-26 00:00:00','Biro Jasa MULIA JAYA','',NULL,'IDR',1.00,'1110.0001','By Perpanjang STNK\r\nAVEGA GT','out','maitri','2018-02-09 10:16:20','maitri','2018-02-09 10:16:20'),('QJA/CO/18/I/031','KK-1801-027','','2018-01-28 00:00:00','PRUDENTIAL LIFE ASSURANCE','',NULL,'IDR',1.00,'1110.0001','By Asuransi Karyawan\r\nBp. NURDIN  Rp. 900.000,-\r\nBp KHIONG  Rp. 118.000,-\r\nMAITRI  Rp. 150.000,-\r\nYUDI; TARMAN @ 90.000,-\r\nBUDI; FETI; FENDI; WAWAN','out','maitri','2018-02-09 13:02:04','maitri','2018-02-09 13:02:04'),('QJA/CO/18/I/032','KK-1801-028','','2018-01-26 00:00:00','HONDA AHAS','',NULL,'IDR',1.00,'1110.0001','By Ganti Oli Motor VARIO\r\nBp. KHIONG','out','maitri','2018-02-09 13:15:50','maitri','2018-02-09 13:15:50'),('QJA/CO/18/I/033','KK-1801-029','','2018-01-29 00:00:00','Bp. NURDIN','',NULL,'IDR',1.00,'1110.0001','By Perjalanan Dinas Bp NURDIN W\r\nJkt - SG - Jkt  tanggal 23 Jan 18','out','maitri','2018-02-09 13:20:24','maitri','2018-02-09 13:20:24'),('QJA/CO/18/I/035','KK-1801-030','','2018-01-30 00:00:00','KAVIN KARENT RENT CAR','',NULL,'IDR',1.00,'1110.0001','By Kirim ke Customer \r\nGRACIA PHARMINDO - SUKABUMI\r\n2.240 Kg LACTULOSE LIQUID 70%','out','maitri','2018-02-09 13:27:52','maitri','2018-02-09 13:27:52'),('QJA/CO/18/I/036','KK-1801-031','','2018-01-30 00:00:00','CHRYSANT FLOWER','',NULL,'IDR',1.00,'1110.0001','By Entertainment Customer - Bunga Papan Pernikahan\r\nINTERBAT','out','maitri','2018-02-09 13:31:37','maitri','2018-02-09 13:31:37'),('QJA/CO/18/I/037','KK-1801-032','','2018-01-31 00:00:00','NUROKHMAN','',NULL,'IDR',1.00,'1110.0001','Uang Muka Karyawan JAN 18\r\nNUROKHMAN','out','maitri','2018-02-09 13:35:34','maitri','2018-02-09 13:35:34'),('QJA/CO/18/I/038','KK-1801-033','','2018-01-31 00:00:00','BCA','',NULL,'IDR',1.00,'1110.0001','PANALOG & DHL @ 5.000,-\r\nBy Transfer ke Principal  @ 50.000,- (Rincian Terlampir)','out','maitri','2018-02-09 14:09:52','maitri','2018-02-12 09:15:11'),('QJA/CO/18/I/039','KK-1801-034','','2018-01-31 00:00:00','BNI','',NULL,'IDR',1.00,'1110.0001','By Ijin Impor BNI\r\n29 Lbr Ijin Impor @ 50.000,-','out','maitri','2018-02-12 11:07:49','maitri','2018-02-12 11:07:49'),('QJA/CO/18/I/041','KK-1801-036','','2018-01-31 00:00:00','TIKI','',NULL,'IDR',1.00,'1110.0001','SRI AMAN; HENSAN BERSAMA; ANINDOJAYA; SKJF; NUFARINDO; ERELA; BINA SAN; GRACIA PHARMINDO; CENDO PHARMA; MEPROFARM','out','maitri','2018-02-12 11:32:31','maitri','2018-02-12 11:32:31'),('QJA/CO/18/I/042','KK-1801-037','','2018-01-31 00:00:00','-','',NULL,'IDR',1.00,'1110.0001','Rincian Terlampir','out','maitri','2018-02-12 11:55:23','maitri','2018-02-12 11:55:35'),('QJA/CO/18/I/043','KK-1801-038','','2018-01-31 00:00:00','YUDI','',NULL,'IDR',1.00,'1110.0001','Exp YUDI Jan 18','out','maitri','2018-02-12 13:06:50','maitri','2018-02-12 13:06:50'),('QJA/CO/18/I/044','KK-1801-039','','2018-01-31 00:00:00','WAWAN','',NULL,'IDR',1.00,'1110.0001','Exp WAWAN Jan 18','out','maitri','2018-02-12 13:08:43','maitri','2018-02-12 13:08:43'),('QJA/CO/18/I/045','KK-1801-040','','2018-01-31 00:00:00','BUDI','',NULL,'IDR',1.00,'1110.0001','Exp BUDI Jan 18','out','maitri','2018-02-12 13:10:19','maitri','2018-02-12 13:10:19'),('QJA/CO/18/I/046','KK-1801-041','','2018-01-31 00:00:00','FENDI ERWANTO','',NULL,'IDR',1.00,'1110.0001','Exp FENDI Jan 18','out','maitri','2018-02-12 13:12:58','maitri','2018-02-12 13:12:58'),('QJA/CO/18/I/047','KK-1801-042','','2018-01-31 00:00:00','Bp. NURDIN','',NULL,'IDR',1.00,'1110.0001','Exp Bp. NURDIN Jan 18','out','maitri','2018-02-12 13:14:42','maitri','2018-02-12 13:14:42'),('QJA/CO/18/II/022','KK-1801-020','','2018-01-23 00:00:00','SHOP & DRIVE','',NULL,'IDR',1.00,'1110.0001','By Ganti Accu Toyota VIOS','out','maitri','2018-02-09 09:45:18','maitri','2018-02-09 09:56:13'),('QJA/CO/18/II/040','KK-1801-035','','2018-01-31 00:00:00','HIRA & TIKI','',NULL,'IDR',1.00,'1110.0001','ERELA (8); NUFARINDO;  CENDO (2); INTERBAT (4); SKJF (2); BSP; MEPROFARM (3); SANBE FARMA','out','maitri','2018-02-12 11:28:23','maitri','2018-02-12 11:28:48');
/*!40000 ALTER TABLE `tr_cashinouthead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_customeradvancebalancedetail`
--

DROP TABLE IF EXISTS `tr_customeradvancebalancedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_customeradvancebalancedetail` (
  `balanceDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `balanceHeadID` int(11) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  PRIMARY KEY (`balanceDetailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_customeradvancebalancedetail`
--

LOCK TABLES `tr_customeradvancebalancedetail` WRITE;
/*!40000 ALTER TABLE `tr_customeradvancebalancedetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_customeradvancebalancedetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_customeradvancebalancehead`
--

DROP TABLE IF EXISTS `tr_customeradvancebalancehead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_customeradvancebalancehead` (
  `balanceHeadID` int(11) NOT NULL AUTO_INCREMENT,
  `balanceDate` datetime NOT NULL,
  `customerID` int(11) NOT NULL,
  PRIMARY KEY (`balanceHeadID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_customeradvancebalancehead`
--

LOCK TABLES `tr_customeradvancebalancehead` WRITE;
/*!40000 ALTER TABLE `tr_customeradvancebalancehead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_customeradvancebalancehead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_customeradvancepayment`
--

DROP TABLE IF EXISTS `tr_customeradvancepayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_customeradvancepayment` (
  `custAdvancePaymentNum` varchar(50) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `custAdvancePaymentDate` datetime NOT NULL,
  `custID` int(11) NOT NULL,
  `paymentCOA` varchar(20) DEFAULT NULL,
  `treasuryCOA` varchar(20) DEFAULT NULL,
  `currencyID` varchar(5) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `adminFeePaymentCoa` varchar(20) DEFAULT NULL,
  `adminFeeRate` decimal(18,2) DEFAULT NULL,
  `adminFeeAmount` decimal(18,2) DEFAULT NULL,
  `additionalInfo` varchar(200) DEFAULT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`custAdvancePaymentNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_customeradvancepayment`
--

LOCK TABLES `tr_customeradvancepayment` WRITE;
/*!40000 ALTER TABLE `tr_customeradvancepayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_customeradvancepayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_customerpayment`
--

DROP TABLE IF EXISTS `tr_customerpayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_customerpayment` (
  `customerPaymentNum` varchar(50) NOT NULL,
  `paymentTransactionDate` datetime NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `voucherNum` varchar(50) DEFAULT NULL,
  `customerID` int(11) NOT NULL,
  `transactionAmount` decimal(18,2) DEFAULT NULL,
  `paymentAmount` decimal(18,2) NOT NULL,
  `coaNo` varchar(20) NOT NULL,
  `adminFeePaymentCoa` varchar(20) DEFAULT NULL,
  `adminFeeRate` decimal(18,2) DEFAULT NULL,
  `adminFeeAmount` decimal(18,2) DEFAULT NULL,
  `additionalInfo` varchar(200) DEFAULT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) DEFAULT NULL,
  `editedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`customerPaymentNum`),
  KEY `fk_customerpayment_customerid_idx` (`customerID`),
  KEY `fk_customerpayment_coano_idx` (`coaNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_customerpayment`
--

LOCK TABLES `tr_customerpayment` WRITE;
/*!40000 ALTER TABLE `tr_customerpayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_customerpayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_customerreceivabledetail`
--

DROP TABLE IF EXISTS `tr_customerreceivabledetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_customerreceivabledetail` (
  `receivableDetailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `receivableNum` int(11) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `rate` decimal(18,2) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  PRIMARY KEY (`receivableDetailID`),
  KEY `fk_customerreceivabledetail_currency_idx` (`currency`),
  KEY `fk_customerreceivabledetail_receivablenum_idx` (`receivableNum`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_customerreceivabledetail`
--

LOCK TABLES `tr_customerreceivabledetail` WRITE;
/*!40000 ALTER TABLE `tr_customerreceivabledetail` DISABLE KEYS */;
INSERT INTO `tr_customerreceivabledetail` VALUES (1,1,'QJA/GD/17/XI/009','IDR',1.00,0.00),(2,2,'QJA/GD/17/XI/001','IDR',1.00,0.00),(3,3,'QJA/GD/17/XI/001','IDR',1.00,21604000.00),(4,4,'QJA/GD/17/XI/001','IDR',1.00,21604000.00),(5,5,'QJA/GD/17/XI/001','IDR',1.00,0.00),(6,6,'QJA/GD/17/XI/001','IDR',1.00,21604000.00),(7,7,'QJA/GD/17/XI/002','IDR',1.00,0.00),(8,8,'QJA/GD/17/XI/001','IDR',1.00,297000000.00),(9,9,'QJA/GD/17/XI/002','IDR',1.00,145530000.00),(10,10,'QJA/GD/17/XI/003','IDR',1.00,73669750.00),(11,11,'QJA/GD/17/XI/004','IDR',1.00,165604890.00),(12,12,'QJA/GD/17/XI/005','IDR',1.00,0.00),(13,13,'QJA/GD/17/XII/001','IDR',1.00,0.00),(14,14,'QJA/GD/17/XII/001','IDR',1.00,0.00),(15,15,'QJA/GD/17/XII/001','IDR',1.00,0.00),(16,16,'QJA/GD/17/XII/001','IDR',1.00,59070000.00),(17,17,'QJA/GD/17/XII/001','IDR',1.00,59070000.00),(18,18,'QJA/GD/17/XII/001','IDR',1.00,59070000.00),(19,19,'QJA/GD/17/XII/001','IDR',1.00,0.00),(20,20,'QJA/GD/17/XII/001','IDR',1.00,59070000.00),(21,21,'QJA/GD/17/XII/001','IDR',1.00,59070000.00),(22,22,'QJA/GD/17/XII/001','IDR',1.00,59070000.00),(23,23,'QJA/GD/17/XII/002','IDR',1.00,41412250.00),(24,24,'QJA/GD/17/XII/003','IDR',1.00,0.00),(25,25,'QJA/GD/17/XII/001','IDR',1.00,41412250.00),(26,26,'QJA/GD/17/XII/002','IDR',1.00,324903700.00),(27,27,'QJA/GD/17/XII/003','IDR',1.00,29535000.00),(28,28,'QJA/GD/17/XII/001','IDR',1.00,41412250.00),(29,29,'QJA/GD/17/XII/002','IDR',1.00,7590.00),(30,30,'QJA/GD/17/XII/002','IDR',1.00,0.00),(31,31,'QJA/GD/17/XII/001','IDR',1.00,7590.00),(32,32,'QJA/GD/17/XII/001','IDR',1.00,7590.00),(33,33,'QJA/GD/18/I/001','IDR',1.00,0.00),(34,34,'QJA/GD/18/I/001','IDR',1.00,0.00),(35,35,'QJA/GD/18/I/001','IDR',1.00,7590.00),(36,36,'QJA/GD/18/I/001','IDR',1.00,7590.00),(37,37,'QJA/GD/18/I/001','IDR',1.00,7590.00),(38,38,'QJA/GD/18/I/001','IDR',1.00,7590.00),(39,39,'QJA/GD/18/I/001','IDR',1.00,7590.00),(40,40,'QJA/GD/18/I/001','IDR',1.00,7590.00),(41,41,'QJA/GD/18/I/001','IDR',1.00,41412250.00),(42,42,'QJA/GD/18/I/001','IDR',1.00,7590.00),(43,43,'QJA/GD/18/I/001','IDR',1.00,25016200.00),(44,44,'QJA/GD/17/XI/0293','IDR',1.00,211679600.00),(45,45,'QJA/GD/17/XI/0293','IDR',1.00,0.00),(46,46,'QJA/GD/17/XI/0293','IDR',1.00,211679600.00),(47,47,'QJA/GD/17/XI/0293','IDR',1.00,211679600.00),(48,48,'QJA/GD/17/XI/0293','IDR',1.00,211679600.00),(49,49,'QJA/GD/17/XI/0293','IDR',1.00,211679600.00),(50,50,'QJA/GD/17/XI/0293','IDR',1.00,211679600.00),(51,51,'QJA/GD/17/XI/0293','IDR',1.00,211679600.00),(52,52,'QJA/GD/17/XI/0001','IDR',1.00,145530000.00),(53,53,'QJA/GD/17/XI/0001','IDR',1.00,145530000.00),(54,54,'QJA/GD/17/XI/0001','IDR',1.00,0.00),(55,55,'QJA/GD/17/XI/0001','IDR',1.00,145530000.00),(56,56,'QJA/GD/17/XI/0294','IDR',1.00,145530000.00),(57,57,'QJA/GD/17/XI/0295','IDR',1.00,111375000.00),(58,58,'QJA/GD/17/XI/0296','IDR',1.00,74250000.00),(59,59,'QJA/GD/17/XI/0297','IDR',1.00,74250000.00),(60,60,'QJA/GD/17/XI/0298','IDR',1.00,19250000.00),(61,61,'QJA/GD/17/XI/0299','IDR',1.00,51810.00),(62,62,'QJA/GD/17/XI/0300','IDR',1.00,45795750.00),(63,63,'QJA/GD/18/II/0001','IDR',1.00,364998150.00),(64,64,'QJA/GD/17/XI/0301','IDR',1.00,364998150.00),(65,65,'QJA/GD/17/XI/0302','IDR',1.00,32632517.50),(66,66,'QJA/GD/17/XI/0303','IDR',1.00,26114962.50),(67,67,'QJA/GD/17/XI/0304','IDR',1.00,44119625.00),(68,68,'QJA/GD/17/XI/0305','IDR',1.00,14993286.00),(69,69,'QJA/GD/17/XI/0306','IDR',1.00,567270000.00),(70,70,'QJA/GD/17/XI/0307','IDR',1.00,19540950.00),(71,71,'QJA/GD/17/XI/0308','IDR',1.00,37920795.00),(72,72,'QJA/GD/17/XI/0309','IDR',1.00,14850000.00),(73,73,'QJA/GD/17/XI/0310','IDR',1.00,22825000.00),(74,74,'QJA/GD/17/XI/0311','IDR',1.00,165604890.00),(75,75,'QJA/GD/17/XI/0312','IDR',1.00,19540950.00),(76,76,'QJA/GD/17/XI/0313','IDR',1.00,149600000.00),(77,77,'QJA/GD/17/XI/0314','IDR',1.00,297000000.00),(78,78,'QJA/GD/17/XI/0315','IDR',1.00,32450000.00),(79,79,'QJA/GD/17/XI/0316','IDR',1.00,21604000.00),(80,80,'QJA/GD/17/XI/0317','IDR',1.00,73669750.00),(81,81,'QJA/GD/17/XI/0318','IDR',1.00,67518000.00),(82,82,'QJA/GD/17/XI/0319','IDR',1.00,67518000.00),(83,83,'QJA/GD/17/XI/0320','IDR',1.00,9581000.00),(84,84,'QJA/GD/17/XI/0321','IDR',1.00,9581000.00),(85,85,'QJA/GD/17/XI/0320','IDR',1.00,9581000.00),(86,86,'QJA/GD/17/XI/0321','IDR',1.00,9581000.00),(87,87,'QJA/GD/17/XI/0321','IDR',1.00,9581000.00),(88,88,'QJA/GD/17/XI/0322','IDR',1.00,233200000.00),(89,89,'QJA/GD/17/XI/0323','IDR',1.00,233200000.00),(90,90,'QJA/GD/17/XII/0324','IDR',1.00,66380600.00),(91,91,'QJA/GD/17/XII/0325','IDR',1.00,113905440.00),(92,92,'QJA/GD/17/XII/0326','IDR',1.00,112777500.00),(93,93,'QJA/GD/17/XII/0327','IDR',1.00,55945824.00),(94,94,'QJA/GD/17/XII/0328','IDR',1.00,39171385.00),(95,95,'QJA/GD/17/XII/0329','IDR',1.00,334309800.00),(96,96,'QJA/GD/17/XII/0330','IDR',1.00,145530000.00),(97,97,'QJA/GD/17/XII/0331','IDR',1.00,254984400.00),(98,98,'QJA/GD/17/XII/0332','IDR',1.00,64968750.00),(99,99,'QJA/GD/17/XII/0333','IDR',1.00,63250000.00),(100,100,'QJA/GD/17/XII/0334','IDR',1.00,63483750.00),(101,101,'QJA/GD/17/XII/0335','IDR',1.00,27126000.00),(102,102,'QJA/GD/17/XII/0336','IDR',1.00,74800000.00),(103,103,'QJA/GD/17/XII/0337','IDR',1.00,67518000.00),(104,104,'QJA/GD/17/XII/0338','IDR',1.00,67518000.00),(105,105,'QJA/GD/17/XII/0339','IDR',1.00,67518000.00),(106,106,'QJA/GD/17/XII/0340','IDR',1.00,110484000.00),(107,107,'QJA/GD/17/XII/0341','IDR',1.00,42501195.00),(108,108,'QJA/GD/17/XII/0342','IDR',1.00,41412250.00),(109,109,'QJA/GD/17/XII/0343','IDR',1.00,324903700.00),(110,110,'QJA/GD/17/XII/0344','IDR',1.00,303831000.00),(111,111,'QJA/GD/18/I/0001','IDR',1.00,12508100.00),(112,112,'QJA/GD/18/I/0001','IDR',1.00,25016200.00),(113,113,'QJA/GD/18/I/0001','IDR',1.00,25016200.00),(114,114,'QJA/GD/18/I/0002','IDR',1.00,465973200.00),(115,115,'QJA/GD/18/I/0003','IDR',1.00,65450000.00),(116,116,'QJA/GD/18/I/0004','IDR',1.00,52910000.00),(117,117,'QJA/GD/18/I/0005','IDR',1.00,37515500.00),(118,118,'QJA/GD/18/I/0006','IDR',1.00,146018950.00),(119,119,'QJA/GD/18/I/0007','IDR',1.00,59070000.00),(120,120,'QJA/GD/18/I/0008','IDR',1.00,63483750.00),(121,121,'QJA/GD/18/I/0009','IDR',1.00,594000000.00),(122,122,'QJA/GD/18/I/0010','IDR',1.00,58652000.00),(123,123,'QJA/GD/18/I/0011','IDR',1.00,252945000.00),(124,124,'QJA/GD/18/I/0012','IDR',1.00,12787500.00),(125,125,'QJA/GD/18/I/0013','IDR',1.00,45540000.00),(126,126,'QJA/GD/18/I/0014','IDR',1.00,41171130.00),(127,127,'QJA/GD/18/I/0014','IDR',1.00,41171130.00),(128,128,'QJA/GD/18/I/0015','IDR',1.00,53242200.00),(129,129,'QJA/GD/18/I/0016','IDR',1.00,19250000.00),(130,130,'QJA/GD/18/I/0017','IDR',1.00,9726750.00),(131,131,'QJA/GD/18/I/0018','IDR',1.00,136867500.00),(132,132,'QJA/GD/18/I/0019','IDR',1.00,38921740.00),(133,133,'QJA/GD/18/I/0020','IDR',1.00,38853100.00),(134,134,'QJA/GD/18/I/0021','IDR',1.00,37515500.00),(135,135,'QJA/GD/18/I/0022','IDR',1.00,122267475.00),(136,136,'QJA/GD/18/I/0023','IDR',1.00,96734000.00),(137,137,'QJA/GD/18/I/0024','IDR',1.00,74219750.00),(138,138,'QJA/GD/18/I/0025','IDR',1.00,79410127.50),(139,139,'QJA/GD/18/I/0026','IDR',1.00,146449875.00),(140,140,'QJA/GD/18/I/0027','IDR',1.00,128958500.00),(141,141,'QJA/GD/18/I/0028','IDR',1.00,196053000.00),(142,142,'QJA/GD/18/I/0028','IDR',1.00,196053000.00),(143,143,'QJA/GD/18/I/0029','IDR',1.00,295680000.00),(144,144,'QJA/GD/18/III/0029','IDR',1.00,295680000.00),(145,145,'QJA/GD/18/I/0030','IDR',1.00,18425000.00),(146,146,'QJA/GD/18/I/0031','IDR',1.00,63250000.00),(147,147,'QJA/GD/18/I/0032','IDR',1.00,26173125.00),(148,148,'QJA/GD/18/II/0033','IDR',1.00,104651250.00),(149,149,'QJA/GD/18/II/0034','IDR',1.00,136867500.00),(150,150,'QJA/GD/18/II/0035','IDR',1.00,38209985.00);
/*!40000 ALTER TABLE `tr_customerreceivabledetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_customerreceivablehead`
--

DROP TABLE IF EXISTS `tr_customerreceivablehead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_customerreceivablehead` (
  `receivableNum` int(11) NOT NULL AUTO_INCREMENT,
  `receivableDate` datetime NOT NULL,
  `customerID` int(11) NOT NULL,
  PRIMARY KEY (`receivableNum`),
  KEY `fk_customerreceivablehead_customerid_idx` (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_customerreceivablehead`
--

LOCK TABLES `tr_customerreceivablehead` WRITE;
/*!40000 ALTER TABLE `tr_customerreceivablehead` DISABLE KEYS */;
INSERT INTO `tr_customerreceivablehead` VALUES (1,'2017-11-17 16:24:01',18),(2,'2017-11-22 10:52:55',56),(3,'2017-11-22 10:54:53',56),(4,'2017-11-22 10:56:55',56),(5,'2017-11-22 14:01:25',56),(6,'2017-11-22 14:05:19',56),(7,'2017-11-22 14:45:22',56),(8,'2017-11-22 15:50:00',29),(9,'2017-11-23 16:58:07',21),(10,'2017-11-27 10:10:09',37),(11,'2017-11-27 16:47:51',63),(12,'2017-11-28 16:29:05',16),(13,'2017-12-21 15:54:16',37),(14,'2017-12-21 16:33:58',17),(15,'2017-12-22 09:56:39',29),(16,'2017-12-22 09:57:57',29),(17,'2017-12-22 10:26:13',29),(18,'2017-12-22 11:05:05',29),(19,'2017-12-22 11:08:25',29),(20,'2017-12-22 11:09:21',29),(21,'2017-12-22 11:10:32',29),(22,'2017-12-22 13:33:32',29),(23,'2017-12-22 13:37:12',17),(24,'2017-12-22 13:39:06',37),(25,'2017-12-22 13:42:25',17),(26,'2017-12-22 13:43:35',37),(27,'2017-12-22 13:45:49',29),(28,'2017-12-22 13:48:22',17),(29,'2017-12-22 14:27:58',59),(30,'2017-12-22 14:34:39',59),(31,'2017-12-22 14:39:47',59),(32,'2017-12-22 14:43:02',59),(33,'2018-01-10 14:00:17',17),(34,'2018-01-12 09:05:04',17),(35,'2018-01-16 13:38:26',59),(36,'2018-01-16 13:39:37',59),(37,'2018-01-16 13:41:56',59),(38,'2018-01-16 14:03:41',59),(39,'2018-01-16 14:05:12',59),(40,'2018-01-17 10:47:19',59),(41,'2018-01-17 11:34:04',17),(42,'2018-01-17 14:30:29',59),(43,'2018-02-12 16:43:08',45),(44,'2018-02-14 15:42:22',29),(45,'2018-02-14 16:11:49',29),(46,'2018-02-15 10:39:49',29),(47,'2018-02-15 12:45:06',29),(48,'2018-02-15 12:50:25',29),(49,'2018-02-15 12:56:09',29),(50,'2018-02-15 13:37:32',29),(51,'2018-02-15 13:42:06',29),(52,'2018-02-15 13:57:30',21),(53,'2018-02-15 14:01:03',21),(54,'2018-02-15 14:07:19',21),(55,'2018-02-15 14:10:57',21),(56,'2018-02-15 15:19:45',21),(57,'2018-02-20 10:26:02',29),(58,'2018-02-22 11:09:32',59),(59,'2018-02-22 11:18:35',59),(60,'2018-02-22 11:39:31',60),(61,'2018-02-22 15:34:27',16),(62,'2018-02-23 11:10:53',13),(63,'2018-02-23 11:17:51',17),(64,'2018-02-23 11:22:58',17),(65,'2018-02-23 14:21:24',29),(66,'2018-02-23 14:41:39',23),(67,'2018-02-23 16:37:35',22),(68,'2018-02-23 16:43:57',55),(69,'2018-02-26 16:14:39',29),(70,'2018-02-26 16:26:04',18),(71,'2018-02-26 16:30:30',30),(72,'2018-02-26 16:39:06',29),(73,'2018-02-26 17:27:16',16),(74,'2018-02-28 16:43:43',63),(75,'2018-03-01 13:21:25',18),(76,'2018-03-01 13:25:24',59),(77,'2018-03-01 13:29:49',29),(78,'2018-03-01 14:06:57',13),(79,'2018-03-02 08:41:16',56),(80,'2018-03-07 13:31:15',37),(81,'2018-03-07 13:35:52',19),(82,'2018-03-07 13:45:08',19),(83,'2018-03-07 13:57:10',36),(84,'2018-03-07 14:01:59',36),(85,'2018-03-07 14:09:42',36),(86,'2018-03-07 14:20:29',22),(87,'2018-03-07 14:51:22',22),(88,'2018-03-07 15:18:43',28),(89,'2018-03-07 15:23:21',28),(90,'2018-03-07 16:07:08',28),(91,'2018-03-07 16:18:17',30),(92,'2018-03-08 10:03:12',29),(93,'2018-03-08 10:07:10',28),(94,'2018-03-08 10:12:34',17),(95,'2018-03-08 14:33:19',17),(96,'2018-03-08 14:46:49',21),(97,'2018-03-08 15:24:17',13),(98,'2018-03-08 15:43:30',36),(99,'2018-03-09 14:43:25',36),(100,'2018-03-09 14:47:22',22),(101,'2018-03-09 15:23:14',18),(102,'2018-03-09 15:27:09',59),(103,'2018-03-09 15:30:03',19),(104,'2018-03-09 15:34:49',19),(105,'2018-03-09 15:40:01',19),(106,'2018-03-09 15:49:04',28),(107,'2018-03-09 16:33:59',23),(108,'2018-03-09 16:36:47',17),(109,'2018-03-09 16:39:27',37),(110,'2018-03-09 16:44:12',28),(111,'2018-03-14 14:15:29',45),(112,'2018-03-14 14:18:42',45),(113,'2018-03-14 14:39:44',45),(114,'2018-03-14 15:44:59',29),(115,'2018-03-16 10:37:41',22),(116,'2018-03-16 10:51:06',22),(117,'2018-03-16 11:06:56',13),(118,'2018-03-16 11:22:30',21),(119,'2018-03-16 11:33:16',29),(120,'2018-03-16 13:10:39',22),(121,'2018-03-16 13:18:21',29),(122,'2018-03-16 13:25:40',29),(123,'2018-03-16 13:39:02',25),(124,'2018-03-16 14:17:55',22),(125,'2018-03-16 14:24:19',13),(126,'2018-03-16 14:29:23',17),(127,'2018-03-16 14:32:05',17),(128,'2018-03-16 14:49:37',30),(129,'2018-03-16 15:22:53',60),(130,'2018-03-16 15:30:49',13),(131,'2018-03-16 15:40:48',20),(132,'2018-03-16 16:16:51',10),(133,'2018-03-19 11:27:51',10),(134,'2018-03-19 11:38:11',13),(135,'2018-03-19 11:50:21',18),(136,'2018-03-19 13:25:02',29),(137,'2018-03-19 13:34:00',37),(138,'2018-03-19 13:41:48',23),(139,'2018-03-19 13:47:37',37),(140,'2018-03-19 13:54:51',20),(141,'2018-03-19 14:01:07',33),(142,'2018-03-19 14:22:20',33),(143,'2018-03-19 14:36:07',56),(144,'2018-03-19 14:47:14',56),(145,'2018-03-19 15:06:45',22),(146,'2018-03-19 16:29:57',22),(147,'2018-03-19 16:48:15',16),(148,'2018-04-06 14:50:43',20),(149,'2018-04-06 15:22:33',20),(150,'2018-04-06 15:37:36',28);
/*!40000 ALTER TABLE `tr_customerreceivablehead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_documentcontroldetail`
--

DROP TABLE IF EXISTS `tr_documentcontroldetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_documentcontroldetail` (
  `docControlDetailID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Document Control Detail ID',
  `docControlHeadID` int(11) NOT NULL COMMENT 'Document Control Head ID',
  `documentTypeID` int(11) NOT NULL COMMENT 'Document Type ID',
  `document` varchar(100) NOT NULL COMMENT 'Document',
  PRIMARY KEY (`docControlDetailID`),
  KEY `fk_documenttypeid_dcd_idx` (`documentTypeID`),
  KEY `fk_documenttypeid_headid_idx` (`docControlHeadID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_documentcontroldetail`
--

LOCK TABLES `tr_documentcontroldetail` WRITE;
/*!40000 ALTER TABLE `tr_documentcontroldetail` DISABLE KEYS */;
INSERT INTO `tr_documentcontroldetail` VALUES (6,2,2,'QJA-17055_2.pdf'),(7,2,8,'QJA-17055_8.pdf'),(11,2,9,'QJA-17055_9.pdf'),(12,3,2,'QJA-17079_2.pdf'),(13,3,8,'QJA-17079_8.pdf'),(14,3,9,'QJA-17079_9.pdf');
/*!40000 ALTER TABLE `tr_documentcontroldetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_documentcontrolhead`
--

DROP TABLE IF EXISTS `tr_documentcontrolhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_documentcontrolhead` (
  `docControlHeadID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Document Control Head ID',
  `lkDocumentTypeID` smallint(6) NOT NULL COMMENT 'Document Type ID',
  `refNum` varchar(50) DEFAULT NULL COMMENT 'Reference Number',
  `createdBy` varchar(50) DEFAULT NULL COMMENT 'Created By',
  `createdDate` datetime DEFAULT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`docControlHeadID`),
  KEY `fk_lkdocumenttypeid_dch_idx` (`lkDocumentTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_documentcontrolhead`
--

LOCK TABLES `tr_documentcontrolhead` WRITE;
/*!40000 ALTER TABLE `tr_documentcontrolhead` DISABLE KEYS */;
INSERT INTO `tr_documentcontrolhead` VALUES (1,2,'QJA/PO/17/IX/003','admin','2017-12-07 16:04:16','admin','2017-12-07 16:04:16'),(2,3,'QJA/17055','yudi','2018-04-06 15:23:18','yudi','2018-04-06 15:23:18'),(3,3,'QJA/17079','yudi','2018-04-06 15:32:42','yudi','2018-04-06 15:32:42');
/*!40000 ALTER TABLE `tr_documentcontrolhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_gltogldetail`
--

DROP TABLE IF EXISTS `tr_gltogldetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_gltogldetail` (
  `gltoglDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `gltoglNum` varchar(50) NOT NULL,
  `coaNo` varchar(20) NOT NULL,
  `currencyID` varchar(5) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `debitAmount` decimal(18,2) DEFAULT NULL,
  `creditAmount` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`gltoglDetailID`),
  KEY `fk_gltoglnum_idx` (`gltoglNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_gltogldetail`
--

LOCK TABLES `tr_gltogldetail` WRITE;
/*!40000 ALTER TABLE `tr_gltogldetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_gltogldetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_gltoglhead`
--

DROP TABLE IF EXISTS `tr_gltoglhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_gltoglhead` (
  `gltoglNum` varchar(50) NOT NULL,
  `gltoglDate` datetime NOT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`gltoglNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_gltoglhead`
--

LOCK TABLES `tr_gltoglhead` WRITE;
/*!40000 ALTER TABLE `tr_gltoglhead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_gltoglhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_goodsdeliverydetail`
--

DROP TABLE IF EXISTS `tr_goodsdeliverydetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_goodsdeliverydetail` (
  `goodsDeliveryDetailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `goodsDeliveryNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `batchNumber` varchar(50) DEFAULT NULL,
  `manufactureDate` datetime DEFAULT NULL,
  `expiredDate` datetime DEFAULT NULL,
  `retestDate` varchar(45) DEFAULT NULL,
  `qty` decimal(18,2) NOT NULL,
  `notes` varchar(100) DEFAULT NULL,
  `pack` int(11) NOT NULL,
  `packQty` decimal(18,2) NOT NULL,
  PRIMARY KEY (`goodsDeliveryDetailID`),
  KEY `fk_goodsdeliverynum_idx` (`goodsDeliveryNum`),
  KEY `fk_goodsdelivery_productid_idx` (`productID`),
  KEY `fk_goodsdelivery_uomid_idx` (`uomID`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_goodsdeliverydetail`
--

LOCK TABLES `tr_goodsdeliverydetail` WRITE;
/*!40000 ALTER TABLE `tr_goodsdeliverydetail` DISABLE KEYS */;
INSERT INTO `tr_goodsdeliverydetail` VALUES (16,'QJA/GD/17/XI/0293',142,1,'MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL,1.00,'- 1 Kg x 1 Drum<br />\r\n- COA Terlampir, Kemasan, Label & Segel Asli',6,1.00),(17,'QJA/GD/17/XI/0293',80,1,'SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL,20.00,'- 10 Kg x 2 Drum<br />\r\n- COA Terlampir, Kemasan, Label & Segel Asli',6,25.00),(22,'QJA/GD/17/XI/0294',34,1,'17ADL005','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL,100.00,'- 5 Kg x 20 drum<br />\r\n- COA Terlampir<br />\r\n- Kemasan & Label Asli<br />\r\n- Tersegel Asli',6,10.00),(23,'QJA/GD/17/XI/0295',140,1,'CAMPT/1709023','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label dan segel Asli<br />\r\n- 25 Kg x 2 Drum',6,25.00),(24,'QJA/GD/17/XI/0296',38,1,'20170823','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, label & Segel Asli',10,25.00),(25,'QJA/GD/17/XI/0297',38,1,'20170823','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli',10,25.00),(26,'QJA/GD/17/XI/0298',205,5,'PS/DSMB/1016','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL,500.00,'- Working Standard<br />\r\n- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli',16,500.00),(27,'QJA/GD/17/XI/0299',103,1,'MPB 002/0817','2017-08-01 00:00:00',NULL,'2020-07-01',1.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 1 Kg x 1 Pot',9,1.00),(28,'QJA/GD/17/XI/0300',46,1,'4003-20170503','2017-04-28 00:00:00',NULL,'2019-04-27',50.00,'- COA Terlampir<br />\r\n- Kemasan , Segel & Label Asli<br />\r\n- 25 kg x 3 Fiber Drum',10,25.00),(30,'QJA/GD/17/XI/0301',38,1,'20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,300.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 12 Fiber Drum',10,25.00),(31,'QJA/GD/17/XI/0302',149,1,'BST200117','2017-01-01 00:00:00',NULL,'2019-12-01',5.00,'-COA Terlampir <br />\r\n - Kemasan, Label & Segel Asli<br />\r\n- 5 kg x 1 Drum',13,5.00),(32,'QJA/GD/17/XI/0303',46,1,'4003-20170503','2017-04-28 00:00:00',NULL,'2019-04-27',25.00,'- COA Terlampir<br />\r\n- Kemasan, Label &  Segel Asli<br />\r\n- 25 Kg x 1 Fiber Drum',10,25.00),(33,'QJA/GD/17/XI/0304',43,1,'17CTH047','2017-08-01 00:00:00','2021-07-01 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli',6,25.00),(34,'QJA/GD/17/XI/0304',42,1,'CZC/358','2017-10-01 00:00:00',NULL,'2022-09-01',25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli',6,25.00),(35,'QJA/GD/17/XI/0305',132,1,'SC-NM-20170504','2017-05-05 00:00:00','2020-11-04 00:00:00',NULL,12.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 6 Kg x 2 Tin',8,6.00),(36,'QJA/GD/17/XI/0306',146,1,'TDOMPA 17026','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,475.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 19 Drum',6,25.00),(37,'QJA/GD/17/XI/0306',146,1,'TDOMPA 17027','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,480.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 19 Drum, 5 Kg x  1 Drum',6,25.00),(38,'QJA/GD/17/XI/0307',145,1,'OP8.5/141800617','2017-09-01 00:00:00','2020-08-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Drum',6,25.00),(39,'QJA/GD/17/XI/0308',152,1,'A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Drum',6,5.00),(40,'QJA/GD/17/XI/0309',146,1,'TDOMPA 17026','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Drum',6,25.00),(41,'QJA/GD/17/XI/0310',133,1,'170903','2017-09-03 00:00:00','2020-09-02 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Fiber Drum',10,25.00),(42,'QJA/GD/17/XI/0311',214,1,'02020417','2017-03-01 00:00:00','2022-03-01 00:00:00',NULL,10.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel asli<br />\r\n- 10 Kg x 1 Drum',1,1.00),(43,'QJA/GD/17/XI/0312',44,1,'TBS/125/17-18','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,2.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 2 Kg x 1 Drum',6,2.00),(44,'QJA/GD/17/XI/0313',38,1,'20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,100.00,'- COA Terlampir<br />\r\n- Kemasan , Label & Segel Asli<br />\r\n- 25 Kg x 4 Fiber Drum',10,25.00),(45,'QJA/GD/17/XI/0314',182,1,'217INS1003','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Drum',6,25.00),(46,'QJA/GD/17/XI/0315',53,1,'FSD-170905','2017-10-05 00:00:00','2022-10-04 00:00:00',NULL,1.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 1 Kg x 1 Tin',13,1.00),(47,'QJA/GD/17/XI/0316',120,1,'X1710307M','2017-10-09 00:00:00',NULL,'2022-10-08',10.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 10 Kg x 1 Fiber Drum',10,10.00),(48,'QJA/GD/17/XI/0317',135,1,'TB.1706015','2017-06-26 00:00:00',NULL,'2022-06-26',5.00,'- COA Terlampir<br />\r\n- Kemasan & Label Asli<br />\r\n- Tersegel Asli<br />\r\n- 5 Kg x 1 Tin',14,5.00),(49,'QJA/GD/17/XI/0318',144,1,'175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 50 Kg x 1 Drum',6,50.00),(50,'QJA/GD/17/XI/0319',144,1,'175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,50.00,'- COA Terlampir <br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 50 Kg x 1 Drum',6,50.00),(53,'QJA/GD/17/XI/0320',39,1,'BDOM/1709193','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Drum',6,5.00),(55,'QJA/GD/17/XI/0321',39,1,'BDOM/1709189','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Drum',6,5.00),(56,'QJA/GD/17/XI/0322',78,1,'170603MC-WF','2017-06-20 00:00:00','2019-06-19 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Fiber drum',10,10.00),(57,'QJA/GD/17/XI/0323',78,1,'170603MC-WF','2017-06-20 00:00:00','2019-06-19 00:00:00',NULL,5.00,'- COA Terlampir <br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Fiber Drum',10,10.00),(58,'QJA/GD/17/XII/0324',130,1,'DC-0101H-1708001','2017-07-28 00:00:00','2020-07-27 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Vat',10,25.00),(59,'QJA/GD/17/XII/0325',152,1,'A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL,15.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 3 Drum',6,5.00),(60,'QJA/GD/17/XII/0326',219,1,'CAMPT/1709023','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, label & Segel Asli<br />\r\n- 25 Kg x 2 Drum',6,25.00),(61,'QJA/GD/17/XII/0327',156,1,'APSS17004','2017-07-01 00:00:00','2020-06-01 00:00:00',NULL,2.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 1 Kg x 2 Tin',13,2.00),(62,'QJA/GD/17/XII/0328',152,1,'A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Drum',6,5.00),(63,'QJA/GD/17/XII/0329',217,1,'213733','2017-08-21 00:00:00',NULL,'2022-08-21',6.00,'- COA Terlampir<br />\r\n- Kemasan, Label dan Segel Asli',11,1.00),(64,'QJA/GD/17/XII/0330',34,1,'17ADL006','2017-07-01 00:00:00','2022-06-01 00:00:00',NULL,100.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 10 Kg x 10 Drum',6,10.00),(65,'QJA/GD/17/XII/0331',157,1,'176682006','2017-11-09 00:00:00',NULL,'2020-11-08',60.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 10 Kg x 6 Vat',10,10.00),(66,'QJA/GD/17/XII/0332',138,1,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Drum',6,25.00),(67,'QJA/GD/17/XII/0333',64,3,'1704770694','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL,500.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 100 Gr x 5 Tin',14,100.00),(68,'QJA/GD/17/XII/0334',137,1,'NEDNa 171005','2017-09-22 00:00:00','2022-09-22 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 1 Kg x 5 Tin',8,5.00),(69,'QJA/GD/17/XII/0335',116,1,'YT20170922','2017-09-22 00:00:00','2019-09-21 00:00:00',NULL,30.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 30 Kg x 1 Vat',10,10.00),(70,'QJA/GD/17/XII/0336',38,1,'20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Vat',10,25.00),(71,'QJA/GD/17/XII/0337',144,1,'175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 50 Kg x 1 Drum',6,50.00),(72,'QJA/GD/17/XII/0338',144,1,'175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 50 Kg x 1 Drum',6,50.00),(73,'QJA/GD/17/XII/0339',144,1,'175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 50 Kg x 1 Drum',6,50.00),(74,'QJA/GD/17/XII/0340',64,3,'1704770694','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL,800.00,'- COA Terlampir, 100 Gr x 8 Tin<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- Kekurangan menyusul',14,100.00),(75,'QJA/GD/17/XII/0341',25,1,'HYD/025/17-18','2017-10-01 00:00:00',NULL,'2020-09-01',25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Drum',10,25.00),(76,'QJA/GD/17/XII/0342',169,1,'C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29',25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Vat',10,25.00),(77,'QJA/GD/17/XII/0343',134,1,'17CF03','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Tin',6,5.00),(78,'QJA/GD/17/XII/0344',64,3,'1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL,2200.00,'- COA Terlampir, 100 Gr x 22 tin<br />\r\n- Kemasan, Segel & Label Asli<br />\r\n- Kekurangan Menyusul',14,100.00),(81,'QJA/GD/18/I/0001',64,3,'1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL,200.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 100 Gr x 2 Tin',14,100.00),(82,'QJA/GD/18/I/0002',37,1,'MCB1711033','2017-11-01 00:00:00','2021-10-01 00:00:00',NULL,2.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 2 Kg x 1 Drum',6,1.00),(83,'QJA/GD/18/I/0003',64,3,'1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL,500.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel As;li<br />\r\n- 100 Gr x 5 Tin',14,100.00),(84,'QJA/GD/18/I/0004',124,1,'17CTH062','2017-10-01 00:00:00','2021-09-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Drum',6,25.00),(85,'QJA/GD/18/I/0005',152,1,'A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel asli<br />\r\n- 5 Kg x 1 Drum<br />\r\n',6,5.00),(86,'QJA/GD/18/I/0006',34,1,'17ADL007','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,100.00,'- COA Terlampir<br />\r\n- Kemasan, label & Segel Asli<br />\r\n- 10 Kg x 10 Drum',6,10.00),(87,'QJA/GD/18/I/0007',131,1,'17111001','2017-11-10 00:00:00','2019-11-09 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Fiber Drum',10,25.00),(88,'QJA/GD/18/I/0008',137,1,'NEDNa 171005','2017-09-22 00:00:00','2022-09-22 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 1 Kg x 5 Tin (1 Dus)',8,5.00),(89,'QJA/GD/18/I/0009',182,1,'217INS1003','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 kg x 2 Drum',6,25.00),(90,'QJA/GD/18/I/0010',131,1,'17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Fiber Drum',10,25.00),(91,'QJA/GD/18/I/0011',13,1,'DB 005/1117','2017-11-01 00:00:00',NULL,'2022-10-01',10.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 2 Pot (2 Carton)',9,10.00),(92,'QJA/GD/18/I/0012',136,1,'17 11 19','2017-11-19 00:00:00','2019-11-18 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Carton',10,25.00),(93,'QJA/GD/18/I/0013',176,1,'4003-20171105','2017-11-01 00:00:00',NULL,'2019-10-31',50.00,'- COA Terlampir <br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Vat',10,25.00),(95,'QJA/GD/18/I/0014',102,3,'BB 004/0817','2017-08-01 00:00:00',NULL,'2022-07-01',300.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 100 Gr x 3 Pot',9,100.00),(96,'QJA/GD/18/I/0015',128,1,'XMEP170089','2017-12-01 00:00:00','2020-11-01 00:00:00',NULL,15.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 15 Kg x 1 Drum',14,5.00),(97,'QJA/GD/18/I/0016',205,5,'PS/DSMB/1016','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL,500.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel asli<br />\r\n- WS, 1 Vial x 1 Pack',16,500.00),(98,'QJA/GD/18/I/0017',186,1,'CDAH009121718','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,10.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 10 Kg x 1 Drum',6,25.00),(99,'QJA/GD/18/I/0018',69,1,'W15082709','2015-08-01 00:00:00',NULL,'2020-07-01',75.00,'- COA Terlampir<br />\r\n- Surat Pernyataan, Label & Segel Asli, 25 Kg x 3 Vat',10,25.00),(100,'QJA/GD/18/I/0019',152,1,'A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01',5.00,'- COA Terlampir<br />\r\n- Kemasan, label & Segel Asli<br />\r\n- 5 Kg x 5 Drum',6,5.00),(101,'QJA/GD/18/I/0020',152,1,'A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01',5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Drum',6,5.00),(102,'QJA/GD/18/I/0021',152,1,'A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01',5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Drum',6,5.00),(103,'QJA/GD/18/I/0022',184,1,'CZH-16 06 012 (B)','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Drum',6,25.00),(104,'QJA/GD/18/I/0023',153,1,'HAL/108','2017-12-01 00:00:00',NULL,'2022-11-01',10.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 10 Kg x 1 Drum',6,10.00),(105,'QJA/GD/18/I/0024',135,1,'TB-1710032','2017-10-26 00:00:00',NULL,'2020-10-25',5.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 5 Kg x 1 Tin (1 Carton)',14,5.00),(106,'QJA/GD/18/I/0025',176,1,'4003-20180104','2017-12-28 00:00:00',NULL,'2019-12-27',75.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 3 Vat',10,25.00),(107,'QJA/GD/18/I/0026',193,1,'FP/HTP/002/12/17','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,5.00,'- COA Terlampir<br />\r\n- Kemasan Label & Segel Asli<br />\r\n- 5 Kg x 5 Drum',6,5.00),(108,'QJA/GD/18/I/0027',155,1,'GBW1801005','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL,100.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 4 Drum',6,25.00),(110,'QJA/GD/18/I/0028',106,1,'ALA.1801021','2018-01-02 00:00:00','2020-01-01 00:00:00',NULL,100.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 4 Vat',10,25.00),(112,'QJA/GD/18/III/0029',185,1,'P3264','2017-09-30 00:00:00','2021-09-30 00:00:00',NULL,2240.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 280 Kg x 8 Drum',6,280.00),(113,'QJA/GD/18/I/0030',183,1,'CZC/364','2017-12-01 00:00:00',NULL,'2022-11-01',25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Drum',6,25.00),(114,'QJA/GD/18/I/0031',64,3,'1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL,500.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 100 Gr x 5 Tin',14,100.00),(115,'QJA/GD/18/I/0032',175,1,'W-F03-20170805-01','2017-08-09 00:00:00',NULL,'2020-07-01',25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Vat',1,25.00),(118,'QJA/GD/18/II/0033',38,1,'20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Vat',10,25.00),(119,'QJA/GD/18/II/0033',38,1,'20171117','2017-11-03 00:00:00','2020-11-02 00:00:00',NULL,25.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 1 Vat',10,25.00),(120,'QJA/GD/18/II/0034',69,1,'W15082709','2015-08-01 00:00:00',NULL,'2020-07-01',25.00,'-COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli',10,25.00),(121,'QJA/GD/18/II/0034',69,1,'W15090903','2015-09-01 00:00:00',NULL,'2020-08-01',50.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 25 Kg x 2 Vat<br />\r\n ',10,25.00),(122,'QJA/GD/18/II/0035',121,1,'MTP03217','2017-09-30 00:00:00',NULL,'2022-09-01',10.00,'- COA Terlampir<br />\r\n- Kemasan, Label & Segel Asli<br />\r\n- 1 Carton',13,10.00);
/*!40000 ALTER TABLE `tr_goodsdeliverydetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_goodsdeliveryhead`
--

DROP TABLE IF EXISTS `tr_goodsdeliveryhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_goodsdeliveryhead` (
  `goodsDeliveryNum` varchar(50) NOT NULL,
  `invoiceNum` varchar(50) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `transType` varchar(50) NOT NULL,
  `goodsDeliveryDate` datetime NOT NULL,
  `customerDetailID` int(11) DEFAULT NULL,
  `shipmentBy` varchar(50) DEFAULT NULL,
  `deliveryNum` varchar(20) DEFAULT NULL,
  `deliveryStatus` int(11) NOT NULL,
  `warehouseID` int(11) NOT NULL,
  `additionalInfo` varchar(45) DEFAULT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`goodsDeliveryNum`),
  KEY `fk_goodsdeliveryhead_deliverystatus_idx` (`shipmentBy`),
  KEY `fk_goodsdeliveryhead_destination_idx` (`customerDetailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_goodsdeliveryhead`
--

LOCK TABLES `tr_goodsdeliveryhead` WRITE;
/*!40000 ALTER TABLE `tr_goodsdeliveryhead` DISABLE KEYS */;
INSERT INTO `tr_goodsdeliveryhead` VALUES ('QJA/GD/17/XI/0293','QJA/17K0293','QJA/SO/17/XI/001','Sales Order','2017-11-01 09:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-15 13:42:05','budy','2018-02-15 13:42:05'),('QJA/GD/17/XI/0294','QJA/17K0294','QJA/SO/17/VIII/002','Sales Order','2017-11-06 09:00:00',240,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-15 15:19:45','budy','2018-02-15 15:19:45'),('QJA/GD/17/XI/0295','QJA/17K0295','QJA/SO/17/IX/002','Sales Order','2017-11-06 09:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-20 10:26:02','budy','2018-02-20 10:26:02'),('QJA/GD/17/XI/0296','QJA/17K0296','QJA/SO/17/XI/002','Sales Order','2017-11-07 10:00:00',229,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-22 11:09:32','budy','2018-02-22 11:09:32'),('QJA/GD/17/XI/0297','QJA/17K0297','QJA/SO/17/VIII/003','Sales Order','2017-11-07 10:00:00',229,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-22 11:18:35','budy','2018-02-22 11:18:35'),('QJA/GD/17/XI/0298','QJA/17K0298','QJA/SO/17/IX/003','Sales Order','2017-11-07 10:00:00',246,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-22 11:39:30','budy','2018-02-22 11:39:30'),('QJA/GD/17/XI/0299','QJA/17K0299','QJA/SO/17/X/003','Sales Order','2017-11-07 10:00:00',220,'Expedisi TIKI','',1,5,'','budy','2018-02-22 15:34:27','budy','2018-02-22 15:34:27'),('QJA/GD/17/XI/0300','QJA/17K0300','QJA/SO/17/VIII/004','Sales Order','2017-11-07 10:00:00',339,'Expedisi HIRA','',1,5,'','budy','2018-02-23 11:10:52','budy','2018-02-23 11:10:52'),('QJA/GD/17/XI/0301','QJA/17K0301','QJA/SO/17/XI/005','Sales Order','2017-11-07 10:00:00',305,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-23 11:22:57','budy','2018-02-23 11:22:57'),('QJA/GD/17/XI/0302','QJA/17K0302','QJA/SO/17/VII/006','Sales Order','2017-11-08 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-23 14:21:24','budy','2018-02-23 14:21:24'),('QJA/GD/17/XI/0303','QJA/17K0303','QJA/SO/17/VIII/007','Sales Order','2017-11-08 09:00:00',307,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-23 14:41:38','budy','2018-02-23 14:41:38'),('QJA/GD/17/XI/0304','QJA/17K0304','QJA/SO/17/VIII/008','Sales Order','2017-11-09 09:00:00',319,'Expedisi HIRA','',1,5,'','budy','2018-02-23 16:37:34','budy','2018-02-23 16:37:34'),('QJA/GD/17/XI/0305','QJA/17K0305','QJA/SO/17/IX/009','Sales Order','2017-11-10 09:00:00',223,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-23 16:43:56','budy','2018-02-23 16:43:56'),('QJA/GD/17/XI/0306','QJA/17K0306','QJA/SO/17/XI/011','Sales Order','2017-11-10 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-26 16:14:38','budy','2018-02-26 16:14:38'),('QJA/GD/17/XI/0307','QJA/17K0307','QJA/SO/17/VIII/012','Sales Order','2017-11-10 08:00:00',199,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-26 16:26:03','budy','2018-02-26 16:26:03'),('QJA/GD/17/XI/0308','QJA/17K0308','QJA/SO/17/XI/013','Sales Order','2017-11-13 13:00:00',237,'Expedisi HIRA','',1,5,'','budy','2018-02-26 16:30:30','budy','2018-02-26 16:30:30'),('QJA/GD/17/XI/0309','QJA/17K0309','QJA/SO/17/VIII/014','Sales Order','2017-11-13 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-26 16:39:05','budy','2018-02-26 16:39:05'),('QJA/GD/17/XI/0310','QJA/17K0310','QJA/SO/17/X/015','Sales Order','2017-11-15 13:00:00',220,'Expedisi HIRA','',1,5,'','budy','2018-02-26 17:27:15','budy','2018-02-26 17:27:15'),('QJA/GD/17/XI/0311','QJA/17K0311','QJA/SO/17/VII/016','Sales Order','2017-11-17 09:00:00',225,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-02-28 16:43:42','budy','2018-02-28 16:43:42'),('QJA/GD/17/XI/0312','QJA/17K0312','QJA/SO/17/VIII/017','Sales Order','2017-11-17 09:00:00',199,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-01 13:21:25','budy','2018-03-01 13:21:25'),('QJA/GD/17/XI/0313','QJA/17K0313','QJA/SO/17/X/018','Sales Order','2017-11-20 09:00:00',229,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-01 13:25:24','budy','2018-03-01 13:25:24'),('QJA/GD/17/XI/0314','QJA/17K0314','QJA/SO/17/IX/019','Sales Order','2017-11-20 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-01 13:29:48','budy','2018-03-01 13:29:48'),('QJA/GD/17/XI/0315','QJA/17K0315','QJA/SO/17/IX/020','Sales Order','2017-11-20 13:30:00',339,'Expedisi TIKI','',1,5,'','budy','2018-03-01 14:06:56','budy','2018-03-01 14:06:56'),('QJA/GD/17/XI/0316','QJA/17K0316','QJA/SO/17/X/021','Sales Order','2017-11-20 09:00:00',275,'Expedisi HIRA','',1,5,'','budy','2018-03-02 08:41:16','budy','2018-03-02 08:41:16'),('QJA/GD/17/XI/0317','QJA/17K0317','QJA/SO/17/XI/022','Sales Order','2017-11-21 13:00:00',313,'Expedisi HIRA','',1,5,'','budy','2018-03-07 13:31:14','budy','2018-03-07 13:31:14'),('QJA/GD/17/XI/0318','QJA/17K0318','QJA/SO/17/X/023','Sales Order','2017-11-22 08:00:00',192,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-07 13:35:51','budy','2018-03-07 13:35:51'),('QJA/GD/17/XI/0319','QJA/17K0319','QJA/SO/17/X/024','Sales Order','2017-11-22 08:00:00',192,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-07 13:45:08','budy','2018-03-07 13:45:08'),('QJA/GD/17/XI/0320','QJA/17K0320','QJA/SO/17/X/025','Sales Order','2017-11-24 13:00:00',320,'Expedisi HIRA','',1,5,'','budy','2018-03-07 14:09:42','budy','2018-03-07 14:09:42'),('QJA/GD/17/XI/0321','QJA/17K0321','QJA/SO/17/IX/026','Sales Order','2017-11-24 13:00:00',319,'Expedisi HIRA','',1,5,'','budy','2018-03-07 14:51:22','budy','2018-03-07 14:51:22'),('QJA/GD/17/XI/0322','QJA/17K0322','QJA/SO/17/X/027','Sales Order','2017-11-30 09:00:00',258,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-07 15:18:42','budy','2018-03-07 15:18:42'),('QJA/GD/17/XI/0323','QJA/17K0323','QJA/SO/17/XI/028','Sales Order','2017-11-30 09:00:00',258,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-07 15:23:21','budy','2018-03-07 15:23:21'),('QJA/GD/17/XII/0324','QJA/17KL0324','QJA/SO/17/X/029','Sales Order','2017-12-04 09:00:00',258,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-07 16:07:08','budy','2018-03-07 16:07:08'),('QJA/GD/17/XII/0325','QJA/17L0325','QJA/SO/17/XII/030','Sales Order','2017-12-04 13:00:00',325,'Expedisi HIRA','',1,5,'','budy','2018-03-07 16:18:16','budy','2018-03-07 16:18:16'),('QJA/GD/17/XII/0326','QJA/17L0326','QJA/SO/17/X/049','Sales Order','2017-12-05 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-08 10:03:11','budy','2018-03-08 10:03:11'),('QJA/GD/17/XII/0327','QJA/17L0327','QJA/SO/17/XI/032','Sales Order','2017-12-05 09:00:00',258,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-08 10:07:10','budy','2018-03-08 10:07:10'),('QJA/GD/17/XII/0328','QJA/17L0328','QJA/SO/17/XII/033','Sales Order','2017-12-06 10:00:00',305,'Expedisi HIRA','',1,5,'','budy','2018-03-08 10:12:34','budy','2018-03-08 10:12:34'),('QJA/GD/17/XII/0329','QJA/17L0329','QJA/SO/17/XII/034','Sales Order','2017-12-07 13:00:00',305,'Expedisi HIRA','',1,5,'','budy','2018-03-08 14:33:19','budy','2018-03-08 14:33:19'),('QJA/GD/17/XII/0330','QJA/17L0330','QJA/SO/17/IX/035','Sales Order','2017-12-08 07:00:00',240,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-08 14:46:48','budy','2018-03-08 14:46:48'),('QJA/GD/17/XII/0331','QJA/17L0331','QJA/SO/17/VIII/036','Sales Order','2017-12-08 13:00:00',339,'Expedisi HIRA','',1,5,'','budy','2018-03-08 15:24:16','budy','2018-03-08 15:24:16'),('QJA/GD/17/XII/0332','QJA/17L0332','QJA/SO/17/XI/037','Sales Order','2017-12-11 13:00:00',320,'Expedisi HIRA','',1,5,'','budy','2018-03-08 15:43:30','budy','2018-03-08 15:43:30'),('QJA/GD/17/XII/0333','QJA/17L0333','QJA/SO/17/XII/038','Sales Order','2017-12-11 13:00:00',320,'Expedisi TIKI','',1,5,'','budy','2018-03-09 14:43:25','budy','2018-03-09 14:43:25'),('QJA/GD/17/XII/0334','QJA/17L0334','QJA/SO/17/X/039','Sales Order','2017-12-12 13:00:00',319,'Expedisi HIRA','',1,5,'','budy','2018-03-09 14:47:21','budy','2018-03-09 14:47:21'),('QJA/GD/17/XII/0335','QJA/17L0335','QJA/SO/17/X/040','Sales Order','2017-12-13 08:00:00',199,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 15:23:14','budy','2018-03-09 15:23:14'),('QJA/GD/17/XII/0336','QJA/17L0336','QJA/SO/17/X/041','Sales Order','2017-12-14 09:00:00',229,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 15:27:09','budy','2018-03-09 15:27:09'),('QJA/GD/17/XII/0337','QJA/17L0337','QJA/SO/17/X/042','Sales Order','2017-12-18 08:00:00',192,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 15:30:03','budy','2018-03-09 15:30:03'),('QJA/GD/17/XII/0338','QJA/17L0338','QJA/SO/17/X/043','Sales Order','2017-12-18 08:00:00',192,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 15:34:48','budy','2018-03-09 15:34:48'),('QJA/GD/17/XII/0339','QJA/17L0339','QJA/SO/17/X/044','Sales Order','2017-12-18 08:00:00',192,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 15:40:00','budy','2018-03-09 15:40:00'),('QJA/GD/17/XII/0340','QJA/17L0340','QJA/SO/17/III/045','Sales Order','2017-12-19 09:00:00',258,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 15:49:04','budy','2018-03-09 15:49:04'),('QJA/GD/17/XII/0341','QJA/17L0341','QJA/SO/18/I/001','Sales Order','2017-12-19 10:00:00',307,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 16:33:58','budy','2018-03-09 16:33:58'),('QJA/GD/17/XII/0342','QJA/17L0342','QJA/SO/17/XII/046','Sales Order','2017-12-19 13:00:00',305,'Expedisi HIRA','',1,5,'','budy','2018-03-09 16:36:47','budy','2018-03-09 16:36:47'),('QJA/GD/17/XII/0343','QJA/17L0343','QJA/SO/17/XI/047','Sales Order','2017-12-19 13:00:00',313,'Expedisi HIRA','',1,5,'','budy','2018-03-09 16:39:26','budy','2018-03-09 16:39:26'),('QJA/GD/17/XII/0344','QJA/17L0344','QJA/SO/17/III/048','Sales Order','2017-12-28 09:00:00',258,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-09 16:44:11','budy','2018-03-09 16:44:11'),('QJA/GD/18/I/0001','QJA/18A0001','QJA/SO/17/XII/050','Sales Order','2018-01-02 10:00:00',200,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-14 14:39:44','budy','2018-03-14 14:39:44'),('QJA/GD/18/I/0002','QJA/18A0002','QJA/SO/18/III/002','Sales Order','2018-01-02 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-14 15:44:58','budy','2018-03-14 15:44:58'),('QJA/GD/18/I/0003','QJA/18A0003','QJA/SO/17/X/051','Sales Order','2018-01-02 13:00:00',319,'Expedisi TIKI','',1,5,'','budy','2018-03-16 10:37:41','budy','2018-03-16 10:37:41'),('QJA/GD/18/I/0004','QJA/18A0004','QJA/SO/17/X/052','Sales Order','2018-01-03 13:00:00',319,'Expedisi HIRA','',1,5,'','budy','2018-03-16 10:51:06','budy','2018-03-16 10:51:06'),('QJA/GD/18/I/0005','QJA/18A0005','QJA/SO/17/XI/053','Sales Order','2018-01-03 13:00:00',339,'Expedisi HIRA','',1,5,'','budy','2018-03-16 11:06:56','budy','2018-03-16 11:06:56'),('QJA/GD/18/I/0006','QJA/18A0006','QJA/SO/17/XI/054','Sales Order','2018-01-04 09:00:00',240,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-16 11:22:30','budy','2018-03-16 11:22:30'),('QJA/GD/18/I/0007','QJA/18A0007','QJA/SO/17/X/055','Sales Order','2018-01-04 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-16 11:33:16','budy','2018-03-16 11:33:16'),('QJA/GD/18/I/0008','QJA/18A0008','QJA/SO/17/X/056','Sales Order','2018-01-04 13:00:00',319,'Expedisi HIRA','',1,5,'','budy','2018-03-16 13:10:38','budy','2018-03-16 13:10:38'),('QJA/GD/18/I/0009','QJA/18A0009','QJA/SO/17/X/057','Sales Order','2018-01-08 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-16 13:18:20','budy','2018-03-16 13:18:20'),('QJA/GD/18/I/0010','QJA/18A0010','QJA/SO/17/XI/058','Sales Order','2018-01-09 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-16 13:25:40','budy','2018-03-16 13:25:40'),('QJA/GD/18/I/0011','QJA/18A0011','QJA/SO/17/XII/059','Sales Order','2018-01-10 13:00:00',310,'Expedisi HIRA','',1,5,'','budy','2018-03-16 13:39:02','budy','2018-03-16 13:39:02'),('QJA/GD/18/I/0012','QJA/18A0012','QJA/SO/17/X/060','Sales Order','2018-01-10 13:00:00',319,'Expedisi HIRA','',1,5,'','budy','2018-03-16 14:17:55','budy','2018-03-16 14:17:55'),('QJA/GD/18/I/0013','QJA/18A0013','QJA/SO/17/XII/061','Sales Order','2018-01-11 13:00:00',339,'Expedisi HIRA','',1,5,'','budy','2018-03-16 14:24:19','budy','2018-03-16 14:24:19'),('QJA/GD/18/I/0014','QJA/18A0014','QJA/SO/17/XII/062','Sales Order','2018-01-12 13:00:00',305,'Expedisi TIKI','',1,5,'','budy','2018-03-16 14:32:05','budy','2018-03-16 14:32:05'),('QJA/GD/18/I/0015','QJA/18A0015','QJA/SO/17/X/063','Sales Order','2018-01-15 13:00:00',325,'Expedisi HIRA','',1,5,'','budy','2018-03-16 14:49:37','budy','2018-03-16 14:49:37'),('QJA/GD/18/I/0016','QJA/18A0016','QJA/SO/17/XII/064','Sales Order','2018-01-15 14:00:00',246,'Expedisi TIKI','',1,5,'','budy','2018-03-16 15:22:52','budy','2018-03-16 15:22:52'),('QJA/GD/18/I/0017','QJA/18A0017','QJA/SO/18/I/002','Sales Order','2018-01-18 13:00:00',339,'Expedisi HIRA','',1,5,'','budy','2018-03-16 15:30:49','budy','2018-03-16 15:30:49'),('QJA/GD/18/I/0018','QJA/18A0018','QJA/SO/17/XI/065','Sales Order','2018-01-19 10:00:00',344,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-16 15:40:47','budy','2018-03-16 15:40:47'),('QJA/GD/18/I/0019','QJA/18A0019','QJA/SO/18/I/003','Sales Order','2018-01-19 09:00:00',302,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-16 16:16:50','budy','2018-03-16 16:16:50'),('QJA/GD/18/I/0020','QJA/18A0020','QJA/SO/18/I/004','Sales Order','2018-01-19 10:00:00',302,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-19 11:27:50','budy','2018-03-19 11:27:50'),('QJA/GD/18/I/0021','QJA/18A0021','QJA/SO/17/XI/066','Sales Order','2018-01-19 13:00:00',339,'Expedisi HIRA','',1,5,'','budy','2018-03-19 11:38:11','budy','2018-03-19 11:38:11'),('QJA/GD/18/I/0022','QJA/18A0022','QJA/SO/17/XI/067','Sales Order','2018-01-22 09:00:00',199,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-19 11:50:21','budy','2018-03-19 11:50:21'),('QJA/GD/18/I/0023','QJA/18A0023','QJA/SO/17/XI/068','Sales Order','2018-01-22 10:00:00',248,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-19 13:25:02','budy','2018-03-19 13:25:02'),('QJA/GD/18/I/0024','QJA/18A0024','QJA/SO/17/XII/069','Sales Order','2018-01-22 13:00:00',313,'Expedisi HIRA','',1,5,'','budy','2018-03-19 13:33:59','budy','2018-03-19 13:33:59'),('QJA/GD/18/I/0025','QJA/18A0025','QJA/SO/18/I/005','Sales Order','2018-01-24 10:00:00',307,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-03-19 13:41:48','budy','2018-03-19 13:41:48'),('QJA/GD/18/I/0026','QJA/18A0026','QJA/SO/17/XI/070','Sales Order','2018-01-25 13:00:00',313,'Expedisi HIRA','',1,5,'','budy','2018-03-19 13:47:37','budy','2018-03-19 13:47:37'),('QJA/GD/18/I/0027','QJA/18A0027','QJA/SO/17/XI/071','Sales Order','2018-01-26 10:00:00',213,'PT. QWINJAYA ADITAMA','',1,5,'','budy','2018-03-19 13:54:50','budy','2018-03-19 13:54:50'),('QJA/GD/18/I/0028','QJA/18A0028','QJA/SO/17/I/006','Sales Order','2018-01-29 10:00:00',233,'PT. QWINJAYA ADITAMA','',1,5,'','budy','2018-03-19 14:22:20','budy','2018-03-19 14:22:20'),('QJA/GD/18/I/0030','QJA/18A0030','QJA/SO/17/XI/073','Sales Order','2018-01-30 13:00:00',319,'Expedisi HIRA','',1,5,'','budy','2018-03-19 15:06:45','budy','2018-03-19 15:06:45'),('QJA/GD/18/I/0031','QJA/18A0031','QJA/SO/17/X/074','Sales Order','2018-01-30 13:00:00',319,'Expedisi TIKI','',1,5,'','budy','2018-03-19 16:29:57','budy','2018-03-19 16:29:57'),('QJA/GD/18/I/0032','QJA/18A0032','QJA/SO/18/I/006','Sales Order','2018-01-30 13:00:00',326,'PT QWINJAYA ADITAMA','',2,5,'','budy','2018-03-19 16:48:14','budy','2018-03-19 16:48:14'),('QJA/GD/18/II/0033','QJA/18B0033','QJA/SO/17/XI/075','Sales Order','2018-02-01 09:00:00',213,'PT QWINJAYA ADITAMA','',1,5,'','budy','2018-04-06 14:50:43','budy','2018-04-06 14:50:43'),('QJA/GD/18/II/0034','QJA/18B0034','QJA/SO/17/XI/076','Sales Order','2018-02-01 15:28:00',213,'PT QWINJAYA ADITAMA','',1,5,'<p>- PO No. PO175028</p>\r\n\r\n<p>&nbsp;</p>\r\n','budy','2018-04-06 15:22:33','budy','2018-04-06 15:22:33'),('QJA/GD/18/II/0035','QJA/18AB0035','QJA/SO/17/XII/077','Sales Order','2018-02-01 10:00:00',258,'PT QWINJAYA ADITAMA','',1,5,'<p>PO No. BF.17.0917</p>\r\n','budy','2018-04-06 15:37:36','budy','2018-04-06 15:37:36'),('QJA/GD/18/III/0029','QJA/18A0029','QJA/SO/17/XII/072','Sales Order','2018-03-19 07:00:00',350,'PT QWINJAYA ADITAMA','',1,5,'<p>- PO No. 450/PO-GP/BB/XII/17</p>\r\n','budy','2018-03-19 14:47:14','budy','2018-03-19 14:47:14');
/*!40000 ALTER TABLE `tr_goodsdeliveryhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_goodsreceiptcost`
--

DROP TABLE IF EXISTS `tr_goodsreceiptcost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_goodsreceiptcost` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `goodsReceiptNum` varchar(50) NOT NULL,
  `importDutyAmount` decimal(18,2) DEFAULT NULL,
  `PPNImportAmount` decimal(18,2) DEFAULT NULL,
  `PPHImportAmount` decimal(18,2) DEFAULT NULL,
  `otherCostAmount` decimal(18,2) DEFAULT NULL,
  `taxInvoiceAmount` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_goodsreceiptcost_goodsreceiptnum_idx` (`goodsReceiptNum`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_goodsreceiptcost`
--

LOCK TABLES `tr_goodsreceiptcost` WRITE;
/*!40000 ALTER TABLE `tr_goodsreceiptcost` DISABLE KEYS */;
INSERT INTO `tr_goodsreceiptcost` VALUES (1,'QJA/GR/18/I/001',0.00,0.00,0.00,NULL,NULL),(2,'QJA/GR/18/I/004',625.00,13125.00,13453.12,NULL,NULL),(3,'QJA/GR/18/I/002',0.00,14500.00,14862.50,NULL,NULL),(4,'QJA/GR/18/I/003',0.00,2450.00,2511.25,NULL,NULL),(5,'QJA/GR/18/I/005',0.00,3150.00,3228.75,NULL,NULL),(6,'QJA/GR/18/I/006',0.00,600.00,615.00,NULL,NULL),(7,'QJA/GR/18/I/007',190.00,4142.00,4245.55,NULL,NULL),(8,'QJA/GR/18/I/008',0.00,511.50,476.62,NULL,NULL),(9,'QJA/GR/18/I/009',2131.88,6869.38,7041.11,NULL,NULL),(10,'QJA/GR/18/I/010',0.00,22800.00,23370.00,NULL,NULL),(11,'QJA/GR/18/I/011',0.00,2125.00,2178.13,NULL,NULL),(12,'QJA/GR/18/I/012',0.00,4675.00,4356.25,NULL,NULL),(13,'QJA/GR/18/I/013',0.00,7150.00,7328.75,NULL,NULL),(14,'QJA/GR/18/I/014',0.00,1300.00,1332.50,NULL,NULL),(15,'QJA/GR/18/I/015',0.00,4950.00,4612.50,NULL,NULL),(16,'QJA/GR/18/I/016',0.00,975.00,999.37,NULL,NULL),(17,'QJA/GR/18/I/017',0.00,2400.00,2460.00,NULL,NULL),(18,'QJA/GR/18/I/018',0.00,4042.50,3766.87,NULL,NULL),(19,'QJA/GR/18/I/019',0.00,1914.00,1783.50,NULL,NULL),(20,'QJA/GR/18/I/020',0.00,8750.00,8968.75,NULL,NULL),(21,'QJA/GR/18/I/021',0.00,7000.00,7175.00,NULL,NULL),(22,'QJA/GR/18/I/022',0.00,8750.00,8968.75,NULL,NULL),(23,'QJA/GR/18/I/023',0.00,12980.00,12095.00,NULL,NULL),(24,'QJA/GR/18/I/024',76.25,1761.38,1641.28,NULL,NULL),(25,'QJA/GR/18/I/025',72.50,1674.75,1560.56,NULL,NULL),(26,'QJA/GR/18/I/026',0.00,5325.00,5458.12,NULL,NULL),(27,'QJA/GR/18/I/027',0.00,11200.00,11480.00,NULL,NULL),(28,'QJA/GR/18/II/028',0.00,1000.00,1025.00,NULL,NULL),(29,'QJA/GR/18/II/029',0.00,833000.00,209000.00,NULL,NULL),(30,'QJA/GR/17/XI/001',690.00,15939.00,14852.25,NULL,NULL),(31,'QJA/GR/17/XII/002',0.00,11687.50,10890.62,NULL,NULL),(32,'QJA/GR/17/XII/003',0.00,1815.00,1691.25,NULL,NULL),(33,'QJA/GR/17/XII/004',0.00,811.25,755.94,NULL,NULL),(34,'QJA/GR/17/XII/005',0.00,6930.00,6457.50,NULL,NULL),(35,'QJA/GR/17/XII/006',0.00,2750.00,2562.50,NULL,NULL),(36,'QJA/GR/17/XII/007',0.00,8800.00,8200.00,NULL,NULL),(37,'QJA/GR/17/XII/008',0.00,1320.00,1230.00,NULL,NULL),(38,'QJA/GR/17/XII/009',0.00,69300.00,64575.00,NULL,NULL),(39,'QJA/GR/17/XII/010',0.00,15840.00,14760.00,NULL,NULL),(40,'QJA/GR/17/XI/011',0.00,27380444.00,6845333.30,NULL,NULL),(41,'QJA/GR/17/XI/012',0.00,3100.00,3177.50,NULL,NULL),(42,'QJA/GR/17/XI/013',0.00,7590.00,7072.50,NULL,NULL),(43,'QJA/GR/18/II/031',0.00,18253630.00,4563555.60,NULL,NULL),(44,'QJA/GR/17/XI/014',0.00,6845111.20,1711333.40,NULL,NULL),(45,'QJA/GR/17/XI/015',0.00,2512000.00,628000.00,NULL,NULL),(46,'QJA/GR/17/XI/016',0.00,1564500.00,391500.00,NULL,NULL),(47,'QJA/GR/17/XI/017',0.00,1564500.00,391500.00,NULL,NULL),(48,'QJA/GR/17/XI/018',0.00,18118000.00,4530000.00,NULL,NULL),(49,'QJA/GR/17/XI/019',0.00,1458000.00,365000.00,NULL,NULL),(50,'QJA/GR/17/XI/020',0.00,1863000.00,466000.00,NULL,NULL),(51,'QJA/GR/17/II/048',0.00,13887000.00,3472000.00,NULL,NULL),(52,'QJA/GR/17/XI/033',0.00,1334000.00,1334000.00,NULL,NULL),(53,'QJA/GR/17/XI/034',0.00,0.00,0.00,NULL,NULL),(54,'QJA/GR/17/XI/035',0.00,1707000.00,427000.00,NULL,NULL),(55,'QJA/GR/17/XI/036',0.00,4500.00,4612.50,NULL,NULL),(56,'QJA/GR/17/XI/037',0.00,747000.00,187000.00,NULL,NULL),(57,'QJA/GR/17/XI/038',0.00,38448000.00,9612000.00,NULL,NULL),(58,'QJA/GR/17/XII/039',0.00,5429000.00,1358000.00,NULL,NULL),(59,'QJA/GR/17/XI/041',2031000.00,4265000.00,1067000.00,NULL,NULL),(60,'QJA/GR/17/XII/040',0.00,1149000.00,288000.00,NULL,NULL),(61,'QJA/GR/17/XII/042',0.00,20400.00,20910.00,NULL,NULL),(62,'QJA/GR/17/XI/043',0.00,6300.00,6457.50,NULL,NULL),(63,'QJA/GR/17/XII/044',10747000.00,16634824.00,4159059.00,NULL,NULL),(64,'QJA/GR/17/XII/045',2552000.00,5358000.00,1340000.00,NULL,NULL),(65,'QJA/GR/17/XI/046',0.00,3047000.00,762000.00,NULL,NULL),(66,'QJA/GR/17/XI/047',0.00,1829000.00,458000.00,NULL,NULL),(67,'QJA/GR/17/V/046',0.00,84323000.00,21081000.00,NULL,NULL),(68,'QJA/GR/17/XI/048',0.00,3047000.00,762000.00,NULL,NULL),(69,'QJA/GR/18/II/030',0.00,2830000.00,708000.00,NULL,NULL),(70,'QJA/GR/18/II/032',0.00,32223000.00,8056000.00,NULL,NULL),(71,'QJA/GR/18/II/033',0.00,7964000.00,1991000.00,NULL,NULL),(72,'QJA/GR/18/II/034',0.00,2968482.00,742350.50,NULL,NULL),(73,'QJA/GR/18/II/035',0.00,2968482.00,742350.50,NULL,NULL),(74,'QJA/GR/18/II/036',0.00,1210000.00,303000.00,NULL,NULL),(75,'QJA/GR/18/II/037',0.00,3764036.00,941299.00,NULL,NULL),(76,'QJA/GR/18/II/038',0.00,350000.00,734000.00,NULL,NULL),(77,'QJA/GR/18/II/040',16330000.00,34293000.00,8574000.00,NULL,NULL),(78,'QJA/GR/18/II/041',0.00,1680000.00,420000.00,NULL,NULL),(79,'QJA/GR/18/II/042',0.00,1190000.00,298000.00,NULL,NULL),(80,'QJA/GR/18/II/043',781000.00,1640000.00,410000.00,NULL,NULL),(81,'QJA/GR/18/II/044',1076000.00,1543000.00,1543000.00,NULL,NULL);
/*!40000 ALTER TABLE `tr_goodsreceiptcost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_goodsreceiptdetail`
--

DROP TABLE IF EXISTS `tr_goodsreceiptdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_goodsreceiptdetail` (
  `goodsReceiptDetailID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Goods Receipt Detail ID',
  `goodsReceiptNum` varchar(50) NOT NULL COMMENT 'Goods Receipt Number',
  `productID` int(11) NOT NULL COMMENT 'Product ID',
  `uomID` int(11) NOT NULL COMMENT 'UOM ID',
  `temperature` varchar(15) DEFAULT NULL,
  `batchNumber` varchar(50) DEFAULT NULL COMMENT 'Batch Number',
  `hsCode` varchar(20) DEFAULT NULL,
  `manufactureDate` datetime DEFAULT NULL COMMENT 'Manufacture Date',
  `expiredDate` datetime DEFAULT NULL COMMENT 'Expired Date',
  `retestDate` datetime DEFAULT NULL,
  `qty` decimal(18,0) NOT NULL COMMENT 'Quantity',
  `notes` text COMMENT 'Notes',
  `goodsCondition` bit(1) DEFAULT NULL COMMENT 'Goods Condition',
  `pack` int(11) NOT NULL COMMENT 'Pack',
  `packQty` decimal(18,2) NOT NULL COMMENT 'Pack Quantity',
  `hsCodeTax` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`goodsReceiptDetailID`),
  KEY `fk_goodsreceiptnum_idx` (`goodsReceiptNum`),
  KEY `fk_goodsreceiptproductid_idx` (`productID`),
  KEY `fk_goodsreceiptuomid_idx` (`uomID`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_goodsreceiptdetail`
--

LOCK TABLES `tr_goodsreceiptdetail` WRITE;
/*!40000 ALTER TABLE `tr_goodsreceiptdetail` DISABLE KEYS */;
INSERT INTO `tr_goodsreceiptdetail` VALUES (3,'QJA/GR/18/I/001',182,1,'-','217INS1003','2918.16.00','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL,50,'-','',6,25.00,500.00),(4,'QJA/GR/18/I/002',13,1,'15-30 C','DB 005/1117','2937.22.00','2017-11-01 00:00:00',NULL,'2022-10-01 00:00:00',10,'- Pengiriman melaui : PT. Unex Inti Indonesia\r <br/>- Kemasan pot penyok\r <br/>- Tersegel baik','',9,10.00,0.00),(10,'QJA/GR/18/I/003',176,1,'1]. 15-30 C','4003-20171105','29381000','2017-11-01 00:00:00',NULL,'2019-10-31 00:00:00',50,'- Pengiriman melalui PT. Unex Inti Indonesia, Kemasan fiber drum bagus dan tersegel baik.','',1,25.00,0.00),(11,'QJA/GR/18/I/004',12,1,'-','17FH094','2922.19.90','2017-08-01 00:00:00','2022-07-01 00:00:00',NULL,75,'- Pengiriman Melalui: PT. Gapura Angkasa  - Kemasan drum HDPE bagus dan tersegel baik.      ','',6,25.00,0.00),(12,'QJA/GR/18/I/005',128,1,'25 C','XMEP170089','2941.90.00 ','2017-12-01 00:00:00','2020-11-01 00:00:00',NULL,15,'- Pengiriman Melalui : PT. Gapura Angkasa  - Kemasan drum HDPE bagus dan tersegel baik','',14,5.00,0.00),(14,'QJA/GR/18/I/006',158,5,'15-30 C','PS/DSMB/1016','2937.22.00','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL,500,'- Pengiriman melalui : DHL<br />\r\n- Kemasan Packing bagus dan tersegel baik','',19,500.00,0.00),(15,'QJA/GR/18/I/007',194,1,' -','El-03/L020/17026','29349990','2017-11-01 00:00:00',NULL,'2020-10-01 00:00:00',8,'- Pengiriman melalui : PT. Gapura Angkasa  - Kemasan Drum HDPE bagus dan  tersegel baik','',6,8.00,500.00),(16,'QJA/GR/18/I/007',194,1,' -','El-03/L020/17030','29349990','2017-12-01 00:00:00',NULL,'2020-11-01 00:00:00',2,'- Kemsan melalui : PT. Gapura Angkasa      - Kemasan Drum HDPE bagus dan tersegel baik','',6,2.00,500.00),(18,'QJA/GR/18/I/008',186,1,'-','CDAH009121718','2933.59.90 ','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,10,'- Pengiriman Melalui : PT. Gapura Angkasa  - Kemasan Drum HDPE bagus dan tersegel baik','',6,10.00,0.00),(19,'QJA/GR/18/I/009',17,1,'-','SET401317VE-II','2921.45.00 ','2017-11-25 00:00:00','2022-11-24 00:00:00',NULL,50,'- Pengiriman Melalui : PT. Gapura Angkasa          - Kemasan Drum HDPE bagus dan tersegel baik','',6,25.00,4500.00),(20,'QJA/GR/18/I/010',69,1,'-','W15082709','2933.99.90','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',100,'- Pengiriman Melalui : PT. JAS <br />\r\n- Kemasan 1 Fiber drum bagian bawah penyok, Tersegel baik','',10,25.00,0.00),(21,'QJA/GR/18/I/010',69,1,'-','W15090903','2933.99.90','2015-09-01 00:00:00',NULL,'2020-08-01 00:00:00',100,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,0.00),(22,'QJA/GR/18/I/011',152,1,'-','A11080515/003','2933.39.90','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',5,'- Pengiriman Melalui : PT. Gema Sangkakala by DHL<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,5.00,0.00),(23,'QJA/GR/18/I/012',152,1,'-','A11080515/003','2933.39.90','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',10,'- Pengiriman Melalui : PT. Gema Sangkakala by DHL<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,5.00,0.00),(24,'QJA/GR/18/I/013',184,1,'-','CZH-16 06 012 (B)','2933.59.90 ','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL,50,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE Drum bagus dan tersegel baik','',6,25.00,0.00),(25,'QJA/GR/18/I/013',184,1,'','CZH-16 06 012 (B)','2933.59.90 ','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL,5,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE Drum bagus dan tersegel baik','',6,5.00,0.00),(26,'QJA/GR/18/I/014',121,1,'-','MTP03217','2922.19.90','2017-09-30 00:00:00',NULL,'2022-09-01 00:00:00',10,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Carton bagus dan tersegel baik','',13,10.00,0.00),(27,'QJA/GR/18/I/015',135,1,'-','TB-1710032','2941.90.00 ','2017-10-26 00:00:00',NULL,'2020-10-25 00:00:00',5,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Aluminium Tin bagus dan tersegel baik','',14,5.00,0.00),(28,'QJA/GR/18/I/016',183,1,'-','CZC/364','2933.59.90 ','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00',25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,25.00,0.00),(29,'QJA/GR/18/I/017',153,1,'-','HAL/108','2933.39.90','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00',10,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,10.00,0.00),(30,'QJA/GR/18/I/018',176,1,'-','4003-20180104','29381000','2017-12-28 00:00:00',NULL,'2019-12-27 00:00:00',75,'- Pengiriman Melalui : PT. Unex Inti Indonesia<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,0.00),(31,'QJA/GR/18/I/019',207,1,'-','G1705K005','29333990','2017-05-01 00:00:00','2022-04-01 00:00:00',NULL,10,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,10.00,0.00),(32,'QJA/GR/18/I/020',193,1,'-','FP/HTP/002/12/17','29392090','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,5,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan drum HDPE bagus dan tersegel baik','',6,5.00,0.00),(33,'QJA/GR/18/I/021',155,1,'-','GBW1801005','2922.49.00 ','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL,100,'- Pengiriman Melalui : PT. Unex Inti Indonesia<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,25.00,0.00),(34,'QJA/GR/18/I/022',155,1,'-','GBW1801005','2922.49.00 ','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL,125,'- Pengiriman Melalui : PT. Unex Inti Indonesia<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,25.00,0.00),(35,'QJA/GR/18/I/023',106,1,'-','ALA.1801021','2930.90.10','2018-01-02 00:00:00','2020-01-01 00:00:00',NULL,100,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,0.00),(37,'QJA/GR/18/I/024',209,1,'-','C0011712003','29224900 ','2017-11-29 00:00:00','2019-11-28 00:00:00',NULL,25,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber Drum bagus dan tersegel baik','',10,25.00,500.00),(38,'QJA/GR/18/I/025',175,1,'-','W-F03-20170805-01','29189900','2017-08-09 00:00:00',NULL,'2020-07-01 00:00:00',25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Fiber Drum bagus dan tersegel baik','',1,25.00,500.00),(39,'QJA/GR/18/I/026',38,1,'-','20171117','2922.50.90','2017-11-03 00:00:00','2020-11-02 00:00:00',NULL,75,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber Drum bagus dan tersegel baik','',10,25.00,0.00),(40,'QJA/GR/18/I/027',185,1,'-','P3264','2940.00.00 ','2017-09-30 00:00:00','2021-09-30 00:00:00',NULL,2240,'- Pengiriman Melalui : PT. GSA<br />\r\n- Kemasan Drum HDPE Bagus dan tersegel baik','',6,280.00,0.00),(41,'QJA/GR/18/II/028',77,1,'Below 25 C','HAL3001725','2933.39.90','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,2,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,2.00,0.00),(42,'QJA/GR/18/II/029',188,1,'-','IHAF171222','2930.40.00','2017-12-22 00:00:00','2020-12-21 00:00:00',NULL,25,'- Pengiriman Melalui : PT. Unex<br />\r\n- Kemasan Fiber Drum bagus dan tersegel baik','',10,25.00,0.00),(43,'QJA/GR/18/II/030',39,1,'15-30 C','BDM/1801016','2933.39.90','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,5.00,0.00),(46,'QJA/GR/17/XII/002',152,1,'-','A11080515/004','2933.39.90','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',25,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,5.00,0.00),(47,'QJA/GR/17/XII/003',131,1,'-','17111001','2930.90.90','2017-11-10 00:00:00','2019-11-09 00:00:00',NULL,50,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,0.00),(48,'QJA/GR/17/XII/004',136,1,'-','17 11 19','2923.10.00','2017-11-19 00:00:00','2019-11-18 00:00:00',NULL,25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Carton bagus dan tersegel baik','',10,25.00,0.00),(49,'QJA/GR/17/XII/005',34,1,'15-30 C','17ADL007','2939.80.00','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,100,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,10.00,0.00),(50,'QJA/GR/17/XII/006',124,1,'15-30 C','17CTH062','2933.59.90','2017-10-01 00:00:00','2021-09-01 00:00:00',NULL,50,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,25.00,0.00),(51,'QJA/GR/17/XII/007',137,1,'-','NEDNa 171005','2937.22.00','2017-09-22 00:00:00','2022-09-22 00:00:00',NULL,10,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Aluminium Tin bagus dan tersegel baik','',8,10.00,0.00),(52,'QJA/GR/17/XII/008',102,3,'15-30 C','BB 004/0817','2937.22.00','2017-08-01 00:00:00',NULL,'2022-07-01 00:00:00',300,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan pot bagus dan tersegel baik','',9,100.00,0.00),(53,'QJA/GR/17/XII/009',64,3,'-','1705272729','2936.26.00','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL,10000,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Aluminium Tin bagus dan tersegel baik','',14,100.00,0.00),(54,'QJA/GR/17/XII/010',37,1,'-','MCB1711033','2936.26.00','2017-11-01 00:00:00','2021-10-01 00:00:00',NULL,2,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,2.00,0.00),(57,'QJA/GR/17/XI/011',38,1,'-','20170823','2922.50.90','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL,100,'- Pengiriman Melalui : PT. gapura Angkasa<br />\r\n- Kemasan Fiber drum bagus & segel baik','',10,25.00,0.00),(58,'QJA/GR/17/XI/011',38,1,'-','20170929','2922.50.90','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,200,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber drum bagus & Segel baik','',10,25.00,0.00),(60,'QJA/GR/17/XI/012',103,1,'15-30 C','MPB 002/0817','2937.29.00','2017-08-01 00:00:00',NULL,'2020-07-01 00:00:00',1,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Pot bagus dan tersegel baik','',9,1.00,0.00),(61,'QJA/GR/17/XI/013',38,1,'-','20170929','2922.50.90','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,100,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,0.00),(62,'QJA/GR/18/II/031',38,1,'-','20170929','2922.50.90','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,200,'-Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,0.00),(64,'QJA/GR/17/XI/014',46,1,'','4003-20170503','2938.10.00','2017-04-28 00:00:00',NULL,'2019-04-27 00:00:00',75,' - Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fibre drum bagus dan tersegel baik','',10,25.00,0.00),(65,'QJA/GR/17/XI/015',149,1,'','BST200117','2933.39.90','2017-01-01 00:00:00',NULL,'2019-12-01 00:00:00',5,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE drum  bagus dan tersegel baik','',13,5.00,0.00),(66,'QJA/GR/17/XI/016',43,1,'','17CTH047','2933.59.90 ','2017-08-01 00:00:00','2021-07-01 00:00:00',NULL,25,'- Pengiriman Melalui : PT. Unex Inti Indonesia<br />\r\n- Kemasan HDPE drum  bagus dan tersegel baik','',6,25.00,0.00),(67,'QJA/GR/17/XI/017',42,1,'','CZC/358','2933.59.90 ','2017-10-01 00:00:00',NULL,'2022-09-01 00:00:00',25,'- Pengiriman Melalui : PT. Unex Inti Indonesia<br />\r\n- Kemasan HDPE drum  bagus dan tersegel baik','',6,25.00,0.00),(69,'QJA/GR/17/XI/018',146,1,'','TDOMPA 17026','3003.90.00','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,500,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan 1 HDPE drum rusak dan jebol ','',6,25.00,0.00),(70,'QJA/GR/17/XI/018',146,1,'','TDOMPA 17027','3003.90.00','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,475,'','',6,25.00,0.00),(71,'QJA/GR/17/XI/018',146,1,'','TDOMPA 17027','3003.90.00','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,'','',6,5.00,0.00),(72,'QJA/GR/17/XI/019',145,1,'','OP8.5/141800617','3003.90.00','2017-09-01 00:00:00','2020-08-01 00:00:00',NULL,50,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE drum bagus dan tersegel baik<br />\r\n','',6,25.00,0.00),(73,'QJA/GR/17/XI/020',133,1,'','170903','2933.59.90 ','2017-09-03 00:00:00','2020-09-02 00:00:00',NULL,25,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik ','',10,25.00,0.00),(74,'QJA/GR/18/II/032',214,1,'','02020417','29339990','2017-03-01 00:00:00','2022-03-01 00:00:00',NULL,10,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE drum bagus dan tersegel baik','',1,10.00,5.00),(75,'QJA/GR/17/XI/033',44,1,'','TBS/125/17-18','2922.50.90','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,2,'- Pengiriman Melalui : Fedex<br />\r\n- Kemasan HDPE drum bagus dan tersegel baik','',6,2.00,0.00),(76,'QJA/GR/17/XI/034',53,1,'-','FSD-170905','2937.29.00','2017-10-05 00:00:00','2022-10-04 00:00:00',NULL,1,'- Pengiriman Melalui : Fedex<br />\r\n- Kemasan Aluminium Tin bagus dan tersegel baik','',13,1.00,0.00),(77,'QJA/GR/17/XI/035',120,1,'','X1710307M','2922.49.00 ','2017-10-09 00:00:00',NULL,'2022-10-08 00:00:00',10,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,10.00,0.00),(78,'QJA/GR/17/XI/036',135,1,'','TB.1706015','2941.90.00 ','2017-06-26 00:00:00',NULL,'2022-06-26 00:00:00',5,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Aluminium bagus dan tersegel baik','',14,5.00,0.00),(79,'QJA/GR/17/XI/037',39,1,'15-30 C','BDOM/1709189','2933.39.90','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan HDPE Drum bagus dan tersegel baik','',6,5.00,0.00),(80,'QJA/GR/17/XI/038',78,1,'','170603MC-WF','2941.90.00 ','2017-06-20 00:00:00','2019-06-19 00:00:00',NULL,10,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Fiber drum bagus & tersegel baik','',10,10.00,0.00),(81,'QJA/GR/17/XII/039',130,1,'','DC-0101H-1708001','2934.99.90','2017-07-28 00:00:00','2020-07-27 00:00:00',NULL,25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,0.00),(82,'QJA/GR/17/XII/040',156,1,'Below 30 C','APSS17004','2933.39.90','2017-07-17 00:00:00','2020-06-01 00:00:00',NULL,2,'- Pengiriman Melalui : PT. gapura Angkasa<br />\r\n- Kemasan Aluminium Tin bagus dan tersegel baik','',13,2.00,0.00),(83,'QJA/GR/17/XI/041',219,1,'15-30 C','CAMPT/1709023','29214900','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,50,'-Pengirima Melalui : PT. Unex Inti Indonesia<br />\r\n- Kemasan HDPE Drum bagus dan tersegel baik','',6,25.00,500.00),(84,'QJA/GR/17/XII/042',217,1,'-','213733','29397900','2017-08-21 00:00:00',NULL,'2022-08-21 00:00:00',6,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan pot bagus dan tersegel baik','',11,1.00,0.00),(85,'QJA/GR/17/XI/043',34,1,'15-30 C','17ADL006','2939.80.00','2017-07-01 00:00:00','2022-06-01 00:00:00',NULL,100,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan HDPE Drum bagus dan tersegel baik','',6,10.00,0.00),(86,'QJA/GR/17/XII/044',157,1,'-','176682006','2933.59.90 ','2017-11-09 00:00:00',NULL,'2020-11-08 00:00:00',60,'- Pengiriman Melalui : PT. JAS<br />\r\n - Kemasan, Label & Segel Asli','',10,10.00,0.00),(87,'QJA/GR/17/XII/045',138,1,'-','MLAH060101718','2934.10.00','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE Drum bagus & tersegel baik','',6,25.00,0.00),(90,'QJA/GR/17/V/046',64,3,'-','1604584496','2936.26.00','2016-12-13 00:00:00','2021-12-13 00:00:00',NULL,6000,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Tin bagus dan tersegel baik','',14,100.00,0.00),(91,'QJA/GR/17/V/046',64,3,'-','1704770694','2936.26.00','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL,4000,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Tin bagus dan tersegel baik','',14,100.00,0.00),(92,'QJA/GR/17/XI/047',116,1,'-','YT20170922','2938.10.00','2017-09-22 00:00:00','2019-09-21 00:00:00',NULL,30,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Fiber drum penyok, Barang tidak tersegel','',10,10.00,0.00),(93,'QJA/GR/17/XI/048',25,1,'-','HYD/025/17-18','29072200','2017-10-01 00:00:00',NULL,'2020-09-01 00:00:00',25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE Drum bagus dan tersegel baik','',10,25.00,0.00),(94,'QJA/GR/18/II/032',38,1,'-','20180126','2922.50.90','2018-01-12 00:00:00','2021-01-11 00:00:00',NULL,350,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- 2 Fiber Drum tidak tersegel<br />\r\n','',10,25.00,0.00),(95,'QJA/GR/18/II/033',181,1,'-','KPO-1711023','29183000','2017-11-15 00:00:00',NULL,'2020-11-14 00:00:00',75,'- Pengiriman Melalui : Gapura Angkasa<br />\r\n- Kemasan Fiber Drum bagus dan tersegel baik','',1,25.00,0.00),(96,'QJA/GR/18/II/034',136,1,'-','17 12 25','2923.10.00','2017-12-25 00:00:00','2019-12-24 00:00:00',NULL,25,'- Pengiriman Melalui : PT. Garuda Indonesia<br />\r\n- Kemasan Carton bagus dan Tersegel baik','',10,25.00,0.00),(97,'QJA/GR/18/II/035',195,1,'-','021707011','29362900','2017-07-19 00:00:00','2021-07-18 00:00:00',NULL,25,'- Pengiriman Melalui : PT. Garuda Indonesia<br />\r\n- Kemasan Fiber Drum Bagus dan Tersegel baik','',1,25.00,0.00),(98,'QJA/GR/18/II/036',156,1,'-','APSS17004','2933.39.90','2017-07-01 00:00:00','2020-06-01 00:00:00',NULL,2,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Aluminium Tin bagus dan tersegel baik','',13,2.00,0.00),(99,'QJA/GR/18/II/037',191,6,'-','201712003','2941.90.00 ','2017-12-02 00:00:00','2021-12-01 00:00:00',NULL,20,'- Pengiriman Melalui : PT. Garuda Indonesia<br />\r\n- Kemasan Fiber Drum Bagus dan Tersegel Baik','',10,20.00,0.00),(100,'QJA/GR/18/II/038',87,1,'-','OP-01/03/17/010','2934.99.90','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL,1,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Drum HDPE bagus dan Tersegel Baik','',6,1.00,0.00),(101,'QJA/GR/18/II/040',144,1,'-','185003006','2916.20.00 ','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,300,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan drum bagus, Terlampir sample','',6,50.00,500.00),(102,'QJA/GR/18/II/041',86,3,'15-30 C','BV 212/1117','2937.22.00','2017-11-01 00:00:00',NULL,'2022-10-01 00:00:00',500,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Pot bagus dan Tersegel Baik','',9,1.00,0.00),(103,'QJA/GR/18/II/042',201,1,'-','HYD/012/17-18','29072200','2017-07-01 00:00:00',NULL,'2020-06-01 00:00:00',1,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE Drum bagus dan Tersegel Baik','',6,1.00,0.00),(104,'QJA/GR/18/II/043',178,1,'-','CIN/01181001','2933.59.90 ','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,25,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum Penyok, Tersegel baik','',1,25.00,0.00),(105,'QJA/GR/18/II/044',192,1,'-','RAF01-1712002','29381000','2017-12-09 00:00:00','2020-11-01 00:00:00',NULL,25,'- Pengiriman Melalui : TNT<br />\r\n- Segel Terbuka, Kemasan Fiber drum baik','',10,25.00,0.00),(106,'QJA/GR/18/II/045',88,1,'15-30 C','CAMPT/1802011','2921.49.00','2018-02-01 00:00:00','2023-01-01 00:00:00',NULL,50,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,25.00,NULL),(107,'QJA/GR/18/II/046',179,1,'15-30 C','BCYP/1801009','2933.39.90','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,5,'- Pengiriman Melalui : Gapura Angkasa<br />\r\n- Kemasan Drum HDPE Bagus dan tersegel baik','',1,5.00,NULL),(108,'QJA/GR/18/II/047',41,1,'-','RPCZH-17 10 001','2933.59.90 ','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,75,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,25.00,NULL),(109,'QJA/GR/18/III/048',174,1,'-','050118/0601','13021930','2018-01-01 00:00:00','2021-01-01 00:00:00',NULL,15,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Carton bagus dan tersegel baik','',1,15.00,NULL),(110,'QJA/GR/18/III/049',76,1,'15-30 C','BDM/1802039','2933.39.90','2018-02-01 00:00:00','2023-01-01 00:00:00',NULL,50,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,5.00,NULL),(111,'QJA/GR/18/III/050',152,1,'- ','A11080515/006','2933.39.90','2015-09-01 00:00:00',NULL,'2020-08-01 00:00:00',21,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik','',6,5.00,NULL),(112,'QJA/GR/18/III/051',197,1,'-','18CTH009','29335990','2018-02-01 00:00:00','2022-01-01 00:00:00',NULL,50,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan HDPE drum bagus dan tersegel baik','',6,25.00,NULL),(113,'QJA/GR/18/III/052',183,1,'-','CZC/375','2933.59.90 ','2018-02-01 00:00:00',NULL,'2023-01-01 00:00:00',25,'- Pengiriman Melalui : PT. Gapura Angkasa<br />\r\n- Kemasan drum HDPE bagus dan tersegel baik','',6,25.00,NULL),(114,'QJA/GR/18/III/053',220,3,'Below 30 C','DN(F-III) 1610001','29333990','2016-09-01 00:00:00','2021-08-01 00:00:00',NULL,1355,'- Pengiriman Melalui : Expedisi TIKI<br />\r\n- Kemasan Drum HDPE bagus dan Tersegel baik','',6,1.00,NULL),(115,'QJA/GR/18/III/054',154,1,'-','32418013','2941.90.00 ','2018-02-01 00:00:00',NULL,'2021-01-01 00:00:00',2,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Drum HDPE bagus dan tersegel baik (1 Carton)','',13,2.00,NULL),(116,'QJA/GR/18/III/055',69,1,'-','W15082709','2933.99.90','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',200,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan Fiber drum bagus dan tersegel baik','',10,25.00,NULL),(117,'QJA/GR/18/III/056',201,1,'-','HYD/013/17-18','29072200','2017-07-01 00:00:00',NULL,'2020-06-01 00:00:00',5,'- Pengiriman Melalui : PT. JAS<br />\r\n- Kemasan HDPE Drum bagus dan tersegel baik','',6,5.00,NULL);
/*!40000 ALTER TABLE `tr_goodsreceiptdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_goodsreceipthead`
--

DROP TABLE IF EXISTS `tr_goodsreceipthead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_goodsreceipthead` (
  `goodsReceiptNum` varchar(50) NOT NULL COMMENT 'Goods Receipt Number',
  `refNum` varchar(50) NOT NULL COMMENT 'Reference Number',
  `transType` varchar(50) NOT NULL COMMENT 'Transaction Type',
  `goodsReceiptDate` datetime NOT NULL COMMENT 'Goods Receipt Date',
  `AWBNum` varchar(50) DEFAULT NULL,
  `AWBDate` datetime DEFAULT NULL,
  `PPJK` int(11) DEFAULT NULL,
  `SKINumber` varchar(50) DEFAULT NULL,
  `SKIDate` datetime DEFAULT NULL,
  `warehouseID` int(11) NOT NULL,
  `deliveryNum` varchar(20) DEFAULT NULL COMMENT 'Delivery Number',
  `invoiceNum` varchar(50) DEFAULT NULL,
  `invoiceDate` datetime DEFAULT NULL,
  `taxInvoiceNum` varchar(50) DEFAULT NULL,
  `pibNumber` varchar(20) DEFAULT NULL COMMENT 'PIB Number',
  `pibDate` datetime DEFAULT NULL COMMENT 'PIB Date',
  `pibRate` decimal(18,2) DEFAULT NULL,
  `pibAmount` decimal(18,2) DEFAULT NULL,
  `pibSubmitCode` varchar(20) DEFAULT NULL,
  `additionalInfo` varchar(200) DEFAULT NULL COMMENT 'Additional Information',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`goodsReceiptNum`),
  KEY `fk_warehouseID_idx` (`warehouseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_goodsreceipthead`
--

LOCK TABLES `tr_goodsreceipthead` WRITE;
/*!40000 ALTER TABLE `tr_goodsreceipthead` DISABLE KEYS */;
INSERT INTO `tr_goodsreceipthead` VALUES ('QJA/GR/17/II/048','QJA/17146','Purchase Order','2017-11-17 17:59:00','','2017-11-17 17:59:00',10,'',NULL,5,'','SGACI-171100821',NULL,'','293934','2017-11-16 00:00:00',13537.00,23972000.00,'001872',NULL,'qwinjayasupport','2018-02-26 17:49:25','qwinjayasupport','2018-02-26 17:51:24'),('QJA/GR/17/V/046','QJA/17055','Purchase Order','2017-05-13 06:30:00','176 5231 9864','2017-05-04 00:00:00',7,'PO.03.06.433.1.042224','2017-05-08 00:00:00',5,'I0062586','VL-17/00108','2017-04-24 00:00:00','','093120','2017-05-12 00:00:00',13318.00,105404000.00,'000679',NULL,'budy','2018-03-09 14:10:30','budy','2018-03-09 14:15:18'),('QJA/GR/17/XI/011','QJA/17169','Purchase Order','2017-11-07 06:30:00','999 8395 1162','2017-11-02 00:00:00',7,'PO.03.01.321.1.182928','2017-11-03 00:00:00',5,'1170000913','HTYY17-164TZ','2017-10-25 00:00:00','','280318','2017-11-06 00:00:00',13577.00,34225777.30,'001817',NULL,'budy','2018-02-22 11:00:29','budy','2018-02-22 11:05:22'),('QJA/GR/17/XI/012','QJA/17202','Purchase Order','2017-11-07 06:30:00','232 6688 8275','2017-10-28 00:00:00',7,'PO.03.01.321.1.182925','2017-11-03 00:00:00',5,'I0152788','I 17/0805','2017-10-26 00:00:00','','279413','2017-11-06 00:00:00',13577.00,7630000.00,'001781',NULL,'budy','2018-02-22 15:07:20','budy','2018-02-22 15:13:42'),('QJA/GR/17/XI/013','QJA/17183','Purchase Order','2017-11-07 06:30:00','999 8395 1162','2017-11-02 00:00:00',7,'PO.03.01.321.1.182928','2017-11-03 00:00:00',5,'1170000913','HTYY17-164TZ','2017-10-25 00:00:00','','280318','2017-11-06 00:00:00',13577.00,11408591.70,'001817',NULL,'budy','2018-02-22 15:41:27','budy','2018-02-23 10:23:56'),('QJA/GR/17/XI/014','QJA/17161','Purchase Order','2017-11-07 10:57:00','','2018-02-23 00:00:00',NULL,'',NULL,5,'','',NULL,'','280318','2017-11-06 00:00:00',13577.00,8556444.60,'001817',NULL,'qwinjayasupport','2018-02-23 10:47:03','qwinjayasupport','2018-02-23 10:48:05'),('QJA/GR/17/XI/015','QJA/17151','Purchase Order','2017-11-08 14:05:00','','2018-02-23 00:00:00',NULL,'',NULL,5,'','',NULL,'','280332','2017-11-06 00:00:00',13577.00,3140000.00,'001803',NULL,'qwinjayasupport','2018-02-23 13:55:13','qwinjayasupport','2018-02-23 13:56:04'),('QJA/GR/17/XI/016','QJA/17172','Purchase Order','2017-11-09 16:23:00','','2018-02-23 00:00:00',NULL,'',NULL,5,'','',NULL,'','283905','2017-11-08 00:00:00',13544.00,2701000.00,'001841',NULL,'qwinjayasupport','2018-02-23 16:13:30','qwinjayasupport','2018-02-23 16:14:18'),('QJA/GR/17/XI/017','QJA/17173','Purchase Order','2017-11-09 16:26:00','','2018-02-23 00:00:00',NULL,'',NULL,5,'','',NULL,'','283905','2017-11-08 00:00:00',13544.00,2700500.00,'001841',NULL,'qwinjayasupport','2018-02-23 16:15:44','qwinjayasupport','2018-02-23 16:16:12'),('QJA/GR/17/XI/018','QJA/17166','Purchase Order','2017-11-10 14:51:00','','2017-11-10 00:00:00',10,'',NULL,5,'','RATG/17-18/325',NULL,'','284920','2017-11-09 00:00:00',13544.00,31276000.00,'001824',NULL,'qwinjayasupport','2018-02-26 14:42:22','qwinjayasupport','2018-02-26 14:43:03'),('QJA/GR/17/XI/019','QJA/17174','Purchase Order','2017-11-10 15:05:00','','2017-11-10 00:00:00',10,'',NULL,5,'','',NULL,'','284038','2017-11-08 00:00:00',13544.00,2518000.00,'001823',NULL,'qwinjayasupport','2018-02-26 14:55:11','qwinjayasupport','2018-02-26 14:56:03'),('QJA/GR/17/XI/020','QJA/17208','Purchase Order','2017-11-15 17:23:00','','2018-02-26 00:00:00',NULL,'',NULL,5,'','HTYY17-201TZ',NULL,'','290552','2017-11-14 00:00:00',13544.00,2329000.00,'001855',NULL,'qwinjayasupport','2018-02-26 17:14:02','qwinjayasupport','2018-02-26 17:15:29'),('QJA/GR/17/XI/033','QJA/17165','Purchase Order','2017-11-10 09:23:00','','2017-11-10 00:00:00',76,'',NULL,5,'','EXP/075/17-18',NULL,'','194145','2017-11-07 00:00:00',13577.00,2668000.00,'811236881354',NULL,'qwinjayasupport','2018-03-01 09:14:09','qwinjayasupport','2018-03-01 09:15:18'),('QJA/GR/17/XI/034','QJA/17193','Purchase Order','2017-11-20 13:00:00','8119 5822 6185','2017-11-08 00:00:00',76,'PO.03.01.321.1.183357','2017-11-10 00:00:00',5,'1108789','P2017100901','2017-10-27 00:00:00','','0','2017-11-20 00:00:00',0.00,0.00,'0',NULL,'budy','2018-03-01 13:48:51','budy','2018-03-01 14:02:44'),('QJA/GR/17/XI/035','QJA/17200','Purchase Order','2017-11-15 17:02:00','','2018-03-01 00:00:00',NULL,'',NULL,5,'','90021166',NULL,'','288470','2017-11-13 00:00:00',13544.00,2947000.00,'001871',NULL,'qwinjayasupport','2018-03-01 16:53:08','qwinjayasupport','2018-03-01 16:54:12'),('QJA/GR/17/XI/036','QJA/17213','Purchase Order','2017-11-17 16:26:00','','2017-11-17 00:00:00',NULL,'',NULL,5,'','SGACI-171100828',NULL,'','',NULL,13000.00,0.00,'',NULL,'qwinjayasupport','2018-03-02 16:18:50','qwinjayasupport','2018-03-02 16:19:56'),('QJA/GR/17/XI/037','QJA/17198','Purchase Order','2017-11-07 07:00:00','217 1756 0480','2017-11-01 00:00:00',7,'PO.03.01.321.1.182785','2017-11-02 00:00:00',5,'81117000914','1700400364','2017-10-23 00:00:00','','280331','2017-11-06 00:00:00',13577.00,934000.00,'001812',NULL,'budy','2018-03-07 14:39:49','budy','2018-03-07 14:44:46'),('QJA/GR/17/XI/038','QJA/17201','Purchase Order','2017-11-29 13:00:00','112 4587 3472','2017-11-22 00:00:00',7,'PO.03.01.321.1.184296','2017-11-27 00:00:00',5,'I0164577','2017DJ1025','2017-11-15 00:00:00','','307538','2017-11-27 00:00:00',13538.00,48060000.00,'001959',NULL,'budy','2018-03-07 15:07:21','budy','2018-03-07 15:13:34'),('QJA/GR/17/XI/041','QJA/17215','Purchase Order','2017-11-28 06:30:00','809 1100 4921','2017-11-21 00:00:00',7,'PO.03.01.321.1.184085','2017-11-22 00:00:00',5,'SPB345838','EXP/E0244','2017-11-17 00:00:00','','306904','2017-11-27 00:00:00',13538.00,7363000.00,'001938',NULL,'budy','2018-03-08 09:27:06','budy','2018-03-08 09:32:49'),('QJA/GR/17/XI/043','QJA/17185','Purchase Order','2017-11-15 07:00:00','217 1761 2114','2017-11-04 00:00:00',7,'','2017-11-10 00:00:00',5,'811170002226','TC/17-18/EXP/014','2017-11-02 00:00:00','','288459','2017-11-13 00:00:00',13544.00,15467000.00,'001840',NULL,'budy','2018-03-08 14:40:04','budy','2018-03-08 14:43:34'),('QJA/GR/17/XI/047','QJA/17207','Purchase Order','2017-11-15 06:30:00','618 4821 4132','2017-11-10 00:00:00',7,'PO.03.01.321.1.183479','2017-11-13 00:00:00',5,'I0157791','CITY2017110201','2017-11-02 00:00:00','','290551','2017-11-14 00:00:00',13544.00,2287000.00,'001887',NULL,'budy','2018-03-09 14:21:19','budy','2018-03-09 14:26:16'),('QJA/GR/17/XI/048','QJA/17217','Purchase Order','2017-11-24 06:30:00','160 5334 1271','2017-11-18 00:00:00',7,'PO.03.01.321.1.184006','2017-11-21 00:00:00',5,'I0162550','EXP/119/2017-18','2017-11-16 00:00:00','','302202','2017-11-22 00:00:00',13538.00,3809000.00,'001939',NULL,'budy','2018-03-09 14:32:12','budy','2018-03-09 14:37:54'),('QJA/GR/17/XII/002','QJA/17219','Purchase Order','2017-12-02 09:00:00','160 8490 4083','2017-11-22 00:00:00',7,'PO.03.01.321.1.184555','2017-11-29 00:00:00',5,'CDO17111655','7050329667','2017-11-21 00:00:00','','312100','2017-11-30 00:00:00',13516.00,17952000.00,'001992',NULL,'budy','2018-02-12 11:25:39','budy','2018-02-12 11:29:30'),('QJA/GR/17/XII/003','QJA/17211','Purchase Order','2017-12-07 06:30:00','784 27858272','2017-11-24 00:00:00',7,'PO.03.06.433.1.047470','2017-12-22 00:00:00',5,'812170000635','HTYY17-212TZ','2017-11-13 00:00:00','','317075','2017-12-05 00:00:00',13516.00,4044000.00,'001991',NULL,'budy','2018-02-12 11:37:06','budy','2018-02-12 11:40:44'),('QJA/GR/17/XII/004','QJA/17205','Purchase Order','2017-12-08 06:30:00','112 4610 5312','2017-12-01 00:00:00',7,'PO.03.06.433.1.047028','2017-12-06 00:00:00',5,'I01696682','2017DJ1019','2017-12-04 00:00:00','','320198','2017-12-07 00:00:00',13518.00,11824999.00,'002046',NULL,'budy','2018-02-12 11:49:14','budy','2018-02-12 15:19:49'),('QJA/GR/17/XII/005','QJA/17218','Purchase Order','2017-12-09 09:30:00','217 1856 3145','2017-12-04 00:00:00',7,'PO.03.01.321.1.184478','2017-12-05 00:00:00',5,'812170001224','TC/EXP/17-18/016','2017-12-02 00:00:00','','322492','2017-12-08 00:00:00',13518.00,15438000.00,'002065',NULL,'budy','2018-02-12 15:37:25','budy','2018-02-12 15:42:02'),('QJA/GR/17/XII/006','QJA/17204','Purchase Order','2017-12-09 09:30:00','217 1856 3086','2017-12-05 00:00:00',7,'PO.03.01.321.1.184701','2017-12-04 00:00:00',5,'812170001226','EXP/E0258','2017-11-29 00:00:00','','322496','2017-12-08 00:00:00',13518.00,6127000.00,'002050',NULL,'budy','2018-02-12 15:48:18','budy','2018-02-12 15:51:37'),('QJA/GR/17/XII/007','QJA/17203','Purchase Order','2017-12-12 07:00:00','784 2795 3122','2017-12-06 00:00:00',7,'PO.03.01.321.1.184716','2017-12-04 00:00:00',5,'812170001507','P2017102001','2017-12-01 00:00:00','','324484','2017-12-11 00:00:00',13518.00,13519000.00,'002040',NULL,'budy','2018-02-12 16:03:40','budy','2018-02-12 16:09:06'),('QJA/GR/17/XII/008','QJA/17212','Purchase Order','2017-12-13 11:00:00','232 6688 8485','2017-11-30 00:00:00',7,'PO.03.01.321.1.185207','2017-12-11 00:00:00',5,'I0172061','I 17/0885','2017-11-28 00:00:00','','326231','2017-12-12 00:00:00',13518.00,2029000.00,'002039',NULL,'budy','2018-02-12 16:13:40','budy','2018-02-12 16:18:18'),('QJA/GR/17/XII/009','QJA/17079','Purchase Order','2017-12-28 09:00:00','618 5027 3801','2017-12-18 00:00:00',7,'PO.03.06.433.1.047405','2017-12-20 00:00:00',5,'I0178638','VL-17/00332','2017-12-13 00:00:00','','343850','2017-11-27 00:00:00',13569.00,107392000.00,'002150',NULL,'budy','2018-02-12 16:23:24','budy','2018-02-12 16:27:24'),('QJA/GR/17/XII/010','QJA/17221','Purchase Order','2017-12-29 08:00:00','126 7267 4184','2017-12-19 00:00:00',7,'PO.03.06.433.1.047441','2017-12-22 00:00:00',5,'348791','HHM/1718/00346','2017-12-07 00:00:00','','343208','2017-12-27 00:00:00',13569.00,24425000.00,'002167',NULL,'budy','2018-02-12 16:33:19','budy','2018-02-12 16:37:18'),('QJA/GR/17/XII/039','QJA/17209','Purchase Order','2017-12-02 09:00:00','784 2673 8386','2017-11-26 00:00:00',7,'PO.03.01.321.1.184551','2017-11-29 00:00:00',5,'811170004981','HTYY17-204TZ','2017-11-15 00:00:00','','312116','2017-11-30 00:00:00',13516.00,9372000.00,'002001',NULL,'budy','2018-03-07 15:34:20','budy','2018-03-07 16:01:40'),('QJA/GR/17/XII/040','QJA/17216','Purchase Order','2017-12-05 06:15:00','217 1856 0216','2017-11-24 00:00:00',7,'PO.03.01.321.1.184666','2017-11-30 00:00:00',5,'812170000330','JAP1718021','2017-11-23 00:00:00','','314457','2017-12-04 00:00:00',13516.00,1437000.00,'001999',NULL,'budy','2018-03-07 16:52:42','budy','2018-03-08 09:47:02'),('QJA/GR/17/XII/042','QJA/17223','Purchase Order','2017-12-07 07:00:00','217 17462373','2017-12-01 00:00:00',7,'PO.03.01.321.1.184739','2017-12-04 00:00:00',5,'812170000634','A17/2094','2017-12-03 00:00:00','','317094','2017-12-05 00:00:00',13516.00,34467000.00,'002045',NULL,'budy','2018-03-08 14:26:57','budy','2018-03-08 14:30:50'),('QJA/GR/17/XII/044','QJA/17171','Purchase Order','2017-12-08 07:00:00','112 4610 5312','2017-12-01 00:00:00',7,'PO.03.06.433.1.047028','2017-12-06 00:00:00',5,'I0169682','2017DJ1019','2017-12-04 00:00:00','','320198','2017-12-07 00:00:00',13518.00,20793883.00,'002046',NULL,'budy','2018-03-08 15:01:44','budy','2018-03-08 15:16:29'),('QJA/GR/17/XII/045','QJA/17194','Purchase Order','2017-12-06 06:15:00','176 5466 7465','2017-11-27 00:00:00',7,'PO.03.01.321.1.184648','2017-11-30 00:00:00',5,'I0168277','SGACI-171100880','2017-11-27 00:00:00','','315895','2017-12-05 00:00:00',13516.00,9250000.00,'002018',NULL,'budy','2018-03-08 15:35:02','budy','2018-03-08 15:40:17'),('QJA/GR/18/I/001','QJA/17225','Purchase Order','2018-01-07 11:00:00','618 50159211','2018-01-02 00:00:00',7,'PO.03.06.433.1.047641',NULL,5,'I0002137 (PT. JAS)','VL-17/00283',NULL,'','004933','2018-01-05 00:00:00',13554.00,30863.00,'000021',NULL,'budy','2018-01-25 13:59:35','yudi','2018-01-26 15:46:37'),('QJA/GR/18/I/002','QJA/17254','Purchase Order','2018-01-10 07:00:00','807 0999 8284','2018-01-05 00:00:00',7,'PO.03.01.321.1.186596','2018-01-08 00:00:00',5,'SPB349794','I 18/0026','2018-01-03 00:00:00','','008254','2018-01-09 00:00:00',13554.00,24568000.00,'000032',NULL,'budy','2018-01-26 14:15:47','budy','2018-01-26 14:22:14'),('QJA/GR/18/I/003','QJA/17247','Purchase Order','2018-01-11 06:45:00','843 0489 1375','2018-01-08 00:00:00',7,'PO.03.01.321.1.186672','2018-01-09 00:00:00',5,'SPB349887 (UNEX)','INV20180103','2018-01-03 00:00:00','','009995','2018-01-10 00:00:00',13445.00,4119000.00,'000048',NULL,'budy','2018-02-01 11:02:19','budy','2018-02-01 11:08:14'),('QJA/GR/18/I/004','QJA/17237','Purchase Order','2018-01-11 06:45:00','217 1856 3171','2018-01-06 00:00:00',7,'PO.03.01.321.1.186714','2018-01-09 00:00:00',5,'8011800012','TC/17-18/EXP/020','2018-01-04 00:00:00','','009988','2018-01-10 00:00:00',13445.00,19192000.00,'000043',NULL,'budy','2018-02-01 11:24:42','budy','2018-02-01 11:30:52'),('QJA/GR/18/I/005','QJA/17210','Purchase Order','2018-01-13 16:00:00','668 2012 5943','2018-01-09 00:00:00',7,'PO.03.01.321.1.186842','2018-01-11 00:00:00',5,'801180001611','BPL18/IN-0429','2018-01-08 00:00:00','','012683','2018-01-12 00:00:00',13445.00,5322000.00,'000068',NULL,'budy','2018-02-01 11:41:44','budy','2018-02-01 11:47:51'),('QJA/GR/18/I/006','QJA/17253','Purchase Order','2018-01-15 10:30:00','192 0771 274','2018-01-14 00:00:00',77,'PO.03.01.321.1.186768','2018-01-10 00:00:00',5,'192 0771 274','I 18/0032','2018-01-08 00:00:00','','012843','2018-01-14 00:00:00',13445.00,1744000.00,'-',NULL,'budy','2018-02-02 14:48:41','budy','2018-02-02 14:57:47'),('QJA/GR/18/I/007','QJA/17240','Purchase Order','2018-01-16 07:00:00','809 1100 7043','2018-01-10 00:00:00',7,'PO.03.01.321.1.186925','2018-01-12 00:00:00',5,'001942','EXP/E0290','2018-01-05 00:00:00','','014573','2018-01-15 00:00:00',13445.00,9262000.00,'000065',NULL,'budy','2018-02-05 10:10:08','budy','2018-02-05 10:17:15'),('QJA/GR/18/I/008','QJA/17243','Purchase Order','2018-01-18 07:00:00','217 1857 1908','2018-01-12 00:00:00',7,'PO.03.01.321.1.187130','2018-01-16 00:00:00',5,'801180002289','JAP1718033','2018-01-10 00:00:00','','017876','2018-01-17 00:00:00',13391.00,2104665.00,'000085',NULL,'budy','2018-02-05 17:29:26','budy','2018-02-05 17:41:22'),('QJA/GR/18/I/009','QJA/17236','Purchase Order','2018-01-18 07:00:00','217 1857 1908','2018-01-12 00:00:00',7,'PO.03.01.321.1.187039','2018-01-15 00:00:00',5,'801180002289','JAP1718033','2018-01-10 00:00:00','','017876','2018-01-17 00:00:00',13391.00,10523335.00,'000085',NULL,'budy','2018-02-05 17:46:55','budy','2018-02-05 17:51:21'),('QJA/GR/18/I/010','QJA/17220','Purchase Order','2018-01-19 07:00:00','112 4673 9685','2018-01-12 00:00:00',7,'PO.03.01.321.1.187042','2018-01-15 00:00:00',5,'I0008051 (PT. JAS)','2018DJ0102','2018-01-12 00:00:00','','019782','2018-01-18 00:00:00',13391.00,38165000.00,'000078',NULL,'budy','2018-02-06 14:04:51','budy','2018-02-06 14:15:47'),('QJA/GR/18/I/011','QJA/17233','Purchase Order','2018-01-19 07:00:00','160 8490 4853','2018-01-12 00:00:00',7,'PO.03.01.321.1.187192','2018-01-17 00:00:00',5,'CDO18010775','7050329738','2018-01-10 00:00:00','','018590','2018-01-17 00:00:00',13391.00,3558000.00,'000091',NULL,'budy','2018-02-06 14:22:44','budy','2018-02-06 14:33:35'),('QJA/GR/18/I/012','QJA/180003','Purchase Order','2018-01-19 07:00:00','160 8490 4853','2018-01-12 00:00:00',7,'PO.03.01.321.1.187170','2018-01-17 00:00:00',5,'CDO18010816','7050329737','2018-01-10 00:00:00','','019755','2018-01-18 00:00:00',13391.00,7115000.00,'000100',NULL,'budy','2018-02-06 15:15:38','budy','2018-02-06 15:18:29'),('QJA/GR/18/I/013','QJA/17238','Purchase Order','2018-01-20 08:00:00','618 5424 0141','2018-01-17 00:00:00',7,'PO.03.01.321.1.187281','2018-01-18 00:00:00',5,'I0008635','VL-17/00288','2017-12-20 00:00:00','','020940','2018-01-19 00:00:00',13391.00,17442000.00,'000114',NULL,'budy','2018-02-06 15:31:45','budy','2018-02-06 15:36:20'),('QJA/GR/18/I/014','QJA/17244','Purchase Order','2018-01-20 08:00:00','668 2012 5980','2018-01-16 00:00:00',7,'PO.03.01.321.1.187280','2018-01-18 00:00:00',5,'20-01-2018','BPL18/IN-0430','2018-01-15 00:00:00','','020987','2018-01-19 00:00:00',13391.00,3173000.00,'000111',NULL,'budy','2018-02-06 15:46:42','budy','2018-02-06 15:49:39'),('QJA/GR/18/I/015','QJA/180002','Purchase Order','2018-01-20 08:00:00','999 8537 4752','2018-01-15 00:00:00',7,'PO.03.01.321.1.187143','2018-01-16 00:00:00',5,'20-01-2018','SGACI-180100045','2018-01-15 00:00:00','','021025','2018-01-19 00:00:00',13391.00,7533000.00,'000112',NULL,'budy','2018-02-06 15:55:14','budy','2018-02-06 15:59:32'),('QJA/GR/18/I/016','QJA/17228','Purchase Order','2018-01-22 06:30:00','176 5826 3984','2018-01-12 00:00:00',7,'PO.03.01.321.1.187106','2018-01-16 00:00:00',5,'I0008752','JAP1718032','2018-01-05 00:00:00','','017869','2018-01-17 00:00:00',13391.00,4560712.00,'000090',NULL,'budy','2018-02-06 16:08:38','budy','2018-02-06 16:32:21'),('QJA/GR/18/I/017','QJA/17224','Purchase Order','2018-01-22 06:30:00','176 5826 3984','2018-01-12 00:00:00',7,'PO.03.01.321.1.187122','2018-01-16 00:00:00',5,'I0008752','JAP1718032','2018-01-05 00:00:00','','017869','2018-01-17 00:00:00',13391.00,1824288.00,'000090',NULL,'budy','2018-02-06 16:37:50','budy','2018-02-06 16:52:35'),('QJA/GR/18/I/018','QJA/180008','Purchase Order','2018-01-24 07:00:00','843 0503 8040','2018-01-18 00:00:00',7,'PO.03.01.321.1.187452','2018-01-22 00:00:00',5,'SPB351240','INV20180117','2018-01-17 00:00:00','','024853','2018-01-23 00:00:00',13391.00,6153000.00,'000134',NULL,'budy','2018-02-07 09:02:28','budy','2018-02-07 09:07:33'),('QJA/GR/18/I/019','QJA/17242','Purchase Order','2018-01-25 06:30:00','217 1857 1932','2018-01-19 00:00:00',7,'PO.03.01.321.1.187520','2018-01-23 00:00:00',5,'801100008888','JAP1718035','2018-01-17 00:00:00','','026767','2018-01-24 00:00:00',13339.00,2902000.00,'000138',NULL,'budy','2018-02-07 10:04:53','budy','2018-02-07 10:08:23'),('QJA/GR/18/I/020','QJA/17231','Purchase Order','2018-01-25 06:30:00','160 5569 2291','2018-01-18 00:00:00',7,'PO.03.01.321.1.187543','2018-01-23 00:00:00',5,'I0010886','SGACI-180100060','2018-01-22 00:00:00','','026765','2018-01-24 00:00:00',13339.00,21156000.00,'000139',NULL,'budy','2018-02-07 10:16:18','budy','2018-02-07 10:33:47'),('QJA/GR/18/I/021','QJA/17235','Purchase Order','2018-01-26 07:00:00','807 1101 5244','2018-01-19 00:00:00',7,'PO.03.01.321.1.187572','2018-01-24 00:00:00',5,'SPB351489 (PT. Unex)','9212000684','2018-01-18 00:00:00','','028276','2018-01-25 00:00:00',13339.00,16924000.00,'000133',NULL,'budy','2018-02-07 10:47:41','budy','2018-02-07 11:27:45'),('QJA/GR/18/I/022','QJA/17252','Purchase Order','2018-01-26 07:00:00','807 1101 5244','2018-01-19 00:00:00',7,'PO.03.01.321.1.187572','2018-01-24 00:00:00',5,'SPB351489 (PT. Unex)','9212000684','2018-01-18 00:00:00','','028276','2018-01-25 00:00:00',13339.00,21156000.00,'000133',NULL,'budy','2018-02-07 12:57:38','budy','2018-02-07 13:01:09'),('QJA/GR/18/I/023','QJA/180005','Purchase Order','2018-01-27 08:00:00','112 4717 0292','2018-01-19 00:00:00',7,'PO.03.06.433.1.048101','2018-01-23 00:00:00',5,'I0012062','SGACI-180100056','2018-01-22 00:00:00','','030771','2018-01-26 00:00:00',13339.00,19677000.00,'000137',NULL,'budy','2018-02-07 13:10:19','budy','2018-02-07 13:14:38'),('QJA/GR/18/I/024','QJA/17249','Purchase Order','2018-01-30 06:30:00','999 8570 2293','2018-01-23 00:00:00',7,'PO.03.01.321.1.187811','2018-01-29 00:00:00',5,'801180004141','HTYY18-005TZ','2018-01-12 00:00:00','','032556','2018-01-29 00:00:00',13339.00,3141750.00,'000177',NULL,'budy','2018-02-07 14:33:04','budy','2018-02-07 14:38:40'),('QJA/GR/18/I/025','QJA/180007','Purchase Order','2018-01-30 06:30:00','157 3536 0614','2018-01-22 00:00:00',7,'PO.03.01.321.1.187622','2018-01-24 00:00:00',5,'I0012673','VL-18/00011','2018-01-18 00:00:00','','031842','2018-01-29 00:00:00',13339.00,3525000.00,'000155',NULL,'budy','2018-02-07 14:47:14','budy','2018-02-07 14:52:45'),('QJA/GR/18/I/026','QJA/17232','Purchase Order','2018-01-30 06:30:00','999 8570 2293','2018-01-23 00:00:00',7,'PO.03.01.321.1.187753',NULL,5,'801180004141','HTYY18-005TZ',NULL,'-','032556','2018-01-29 00:00:00',1333900.00,9425250.00,'000177',NULL,'budy','2018-02-07 15:06:10','qwinjayasupport','2018-04-06 14:03:40'),('QJA/GR/18/I/027','QJA/17239','Purchase Order','2018-01-30 11:00:00','CFRJSIN10289','2017-12-31 00:00:00',7,'PO.03.01.321.1.186436','2018-01-04 00:00:00',5,'000030','SGACI-180100015','2018-01-01 00:00:00','','046544','2018-01-24 00:00:00',13339.00,27079000.00,'000042',NULL,'budy','2018-02-07 15:29:55','budy','2018-02-07 16:04:44'),('QJA/GR/18/II/028','QJA/17190','Purchase Order','2018-02-01 07:00:00','160 5334 2483','2018-01-27 00:00:00',7,'PO.03.01.321.1.187928','2018-01-30 00:00:00',5,'I0014205','9480170202','2018-01-23 00:00:00','','035802','2018-01-31 00:00:00',13313.00,1665000.00,'000193',NULL,'budy','2018-02-07 16:15:16','budy','2018-02-07 16:19:12'),('QJA/GR/18/II/029','QJA/17250','Purchase Order','2018-02-02 06:30:00','205 6154 2876','2018-01-26 00:00:00',7,'PO.03.06.433.1.048173','2018-01-25 00:00:00',5,'SPB352220 -PT Unex','P20180108001','2018-01-24 00:00:00','','036840','2018-02-01 00:00:00',13313.00,1042000.00,'000175',NULL,'budy','2018-02-07 16:29:30','budy','2018-02-07 16:34:28'),('QJA/GR/18/II/030','QJA/17248','Purchase Order','2018-02-06 06:30:00','160 5867 4722','2018-01-30 00:00:00',7,'PO.03.01.321.1.188055','2018-02-01 00:00:00',5,'I0016101 (PT. JAS)','1700400619','2018-01-22 00:00:00','','040835','2018-02-05 00:00:00',13313.00,3538000.00,'000217',NULL,'budy','2018-02-07 16:44:31','budy','2018-03-20 10:31:09'),('QJA/GR/18/II/031','QJA/17206','Purchase Order','2018-02-23 10:39:00','999 8395 1162','2017-11-12 00:00:00',7,'PO.03.01.321.1.182928','2017-11-03 00:00:00',5,'1170000913','HTYY17-164TZ','2017-10-25 00:00:00','','280318','2017-11-06 00:00:00',13577.00,22817185.50,'001817',NULL,'budy','2018-02-23 10:31:58','budy','2018-02-23 10:42:17'),('QJA/GR/18/II/032','QJA/180013','Purchase Order','2018-02-13 06:30:00','999 8666 1676','2018-02-06 00:00:00',7,'PO.03.01.321.1.188400','2018-02-07 00:00:00',5,'802180001819','HTYY18-028-1TZ','2018-01-22 00:00:00','','050285','2018-02-12 00:00:00',13440.00,40279000.00,'000270',NULL,'budy','2018-03-20 10:23:03','budy','2018-03-21 13:57:34'),('QJA/GR/18/II/033','QJA/180012','Purchase Order','2018-02-13 06:30:00','784 2787 4685','2018-01-31 00:00:00',7,'PO.03.01.321.1.188163','2018-02-02 00:00:00',5,'802180001820','HTYY18-027TZ','2018-02-22 00:00:00','','050271','2018-02-12 00:00:00',13440.00,9955000.00,'000232',NULL,'budy','2018-03-20 10:44:03','yudi','2018-03-21 14:25:26'),('QJA/GR/18/II/034','QJA/17226','Purchase Order','2018-02-14 06:30:00','126 1662 3865','2018-02-05 00:00:00',7,'PO.03.06.433.1.048521','2018-02-09 00:00:00',5,'274288','2018DJ0126','2018-02-05 00:00:00','','051680','2018-02-13 00:00:00',13440.00,3710835.50,'000294',NULL,'budy','2018-03-20 10:53:26','yudi','2018-03-21 15:16:09'),('QJA/GR/18/II/035','QJA/180020','Purchase Order','2018-02-14 06:30:00','126 1662 3865','2018-02-05 00:00:00',7,'PO.03.06.433.1.048522','2018-02-09 00:00:00',5,'274288','2018DJ0126','2018-02-05 00:00:00','','051680','2018-02-13 00:00:00',13440.00,3710832.50,'000294',NULL,'budy','2018-03-20 11:00:29','yudi','2018-03-21 15:22:16'),('QJA/GR/18/II/036','QJA/180009','Purchase Order','2018-02-14 06:30:00','217 1857 1991','2018-02-09 00:00:00',7,'PO.03.01.321.1.188576','2018-02-12 00:00:00',5,'802180002065','JAP1718039','2018-02-06 00:00:00','','051744','2018-02-13 00:00:00',13440.00,1513000.00,'000299',NULL,'budy','2018-03-20 11:07:03','yudi','2018-03-21 15:38:28'),('QJA/GR/18/II/037','QJA/17229','Purchase Order','2018-02-14 06:30:00','126 1662 3865','2018-02-08 00:00:00',7,'PO.03.01.321.1.188449','2018-02-08 00:00:00',5,'274288','2018DJ0126','2018-02-05 00:00:00','','051680','2018-02-13 00:00:00',13440.00,4705335.00,'000294',NULL,'budy','2018-03-20 11:13:06','yudi','2018-03-21 15:45:29'),('QJA/GR/18/II/038','QJA/17246','Purchase Order','2018-02-14 06:30:00','217 1899 7904','2018-02-08 00:00:00',7,'PO.03.01.321.1.188516','2018-02-09 00:00:00',5,'802180002064','369/EXP','2017-12-20 00:00:00','','051742','2018-02-13 00:00:00',13440.00,1268000.00,'000293',NULL,'budy','2018-03-20 11:18:20','yudi','2018-03-21 15:58:51'),('QJA/GR/18/II/040','QJA/180030','Purchase Order','2018-02-16 09:00:00','232 6901 9193','2018-02-07 00:00:00',7,'',NULL,5,'I0021376','SGACI-180200098','2018-02-07 00:00:00','','051699','2018-02-13 00:00:00',13440.00,59197000.00,'000295',NULL,'budy','2018-03-20 11:29:59','yudi','2018-03-21 16:14:31'),('QJA/GR/18/II/041','QJA/180033','Purchase Order','2018-02-20 07:00:00','232 6814 2001','2018-02-08 00:00:00',7,'PO.03.01.321.1.188520','2018-02-09 00:00:00',5,'I0020080','I18/0134','2018-02-07 00:00:00','','051688','2018-02-13 00:00:00',13440.00,2100000.00,'000296',NULL,'budy','2018-03-20 11:35:45','yudi','2018-03-21 16:25:46'),('QJA/GR/18/II/042','QJA/180032','Purchase Order','2018-02-21 07:00:00','176 8418 4531','2018-02-15 00:00:00',7,'PO.03.01.321.1.188814','2018-02-15 00:00:00',5,'I0022736','SGACI-180200112','2018-02-13 00:00:00','','059249','2018-02-20 00:00:00',13592.00,1488000.00,'000332',NULL,'budy','2018-03-20 11:41:22','yudi','2018-03-21 16:34:24'),('QJA/GR/18/II/043','QJA/180010','Purchase Order','2018-02-22 07:00:00','160 5553 5874','2018-02-13 00:00:00',7,'PO.03.01.321.1.188899','2018-02-19 00:00:00',5,'I0023250','G/1/17-18/0316/E','2018-01-30 00:00:00','','061157','2018-02-21 00:00:00',13581.00,2831000.00,'000354',NULL,'budy','2018-03-20 11:47:12','yudi','2018-03-21 16:39:11'),('QJA/GR/18/II/044','QJA/17230','Purchase Order','2018-02-22 15:00:00','279 937 851','2018-02-17 00:00:00',7,NULL,NULL,5,'1245994',NULL,NULL,NULL,'055810','2018-02-20 00:00:00',13592.00,3086000.00,'137475',NULL,'budy','2018-03-20 11:55:07','budy','2018-03-20 11:55:07'),('QJA/GR/18/II/045','QJA/180027','Purchase Order','2018-02-27 06:30:00','217 1899 8906','2018-02-19 00:00:00',7,NULL,NULL,5,'802180003734',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 15:06:05','budy','2018-03-20 15:06:05'),('QJA/GR/18/II/046','QJA/180015','Purchase Order','2018-02-27 06:30:00','217 1899 6633','2018-02-17 00:00:00',7,NULL,NULL,5,'802180003732',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 15:14:06','budy','2018-03-20 15:14:06'),('QJA/GR/18/II/047','QJA/180016','Purchase Order','2018-02-28 07:00:00','160 4163 6534','2018-02-09 00:00:00',7,NULL,NULL,5,'I0025315',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 15:28:50','budy','2018-03-20 15:28:50'),('QJA/GR/18/III/048','QJA/180023','Purchase Order','2018-03-05 09:00:00','618 5488 1923','2018-02-28 00:00:00',7,NULL,NULL,5,'I0026877',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 15:34:10','budy','2018-03-20 15:34:10'),('QJA/GR/18/III/049','QJA/180028','Purchase Order','2018-03-06 06:30:00','160 4163 6943','2018-02-28 00:00:00',7,NULL,NULL,5,'I0027608',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 15:38:39','budy','2018-03-20 15:38:39'),('QJA/GR/18/III/050','QJA/180019','Purchase Order','2018-03-10 08:00:00','603 4405 1335','2018-03-05 00:00:00',7,NULL,NULL,5,'717180500048',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 15:46:24','budy','2018-03-20 15:46:24'),('QJA/GR/18/III/051','QJA/180024','Purchase Order','2018-03-13 07:00:00','217 1950 9324','2018-03-06 00:00:00',7,NULL,NULL,5,'803180001554',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 15:57:18','budy','2018-03-20 15:57:18'),('QJA/GR/18/III/052','QJA/180025','Purchase Order','2018-03-13 07:00:00','217 1950 9324','2018-03-06 00:00:00',7,NULL,NULL,5,'803180001554',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 16:02:21','budy','2018-03-20 16:02:21'),('QJA/GR/18/III/053','QJA/180055','Purchase Order','2018-03-13 09:30:00','SUB01.00','2018-03-12 00:00:00',73,NULL,NULL,5,'030089987599',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 16:11:15','budy','2018-03-20 16:11:15'),('QJA/GR/18/III/054','QJA/180040','Purchase Order','2018-03-15 06:15:00','176 8829 8512','2018-03-08 00:00:00',7,NULL,NULL,5,'I0031999',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 16:19:21','budy','2018-03-20 16:19:21'),('QJA/GR/18/III/055','QJA/17220','Purchase Order','2018-03-18 07:00:00','112 4820 9000','2018-03-09 00:00:00',7,NULL,NULL,5,'I0033193 (PT. JAS)',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 16:25:11','budy','2018-03-20 16:25:11'),('QJA/GR/18/III/056','QJA/180045','Purchase Order','2018-03-20 06:30:00','176 8418 4800','2018-03-09 00:00:00',7,NULL,NULL,5,'I0034029',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'budy','2018-03-20 16:42:13','budy','2018-03-20 16:42:13');
/*!40000 ALTER TABLE `tr_goodsreceipthead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_internalusagedetail`
--

DROP TABLE IF EXISTS `tr_internalusagedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_internalusagedetail` (
  `internalUsageDetailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `internalUsageNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `batchNumber` varchar(50) NOT NULL,
  `purposeAccount` varchar(20) DEFAULT NULL,
  `manufactureDate` datetime DEFAULT NULL,
  `expiredDate` datetime DEFAULT NULL,
  `retestDate` datetime DEFAULT NULL,
  PRIMARY KEY (`internalUsageDetailID`),
  KEY `fk_internalusage_internalusagenum_idx` (`internalUsageNum`),
  KEY `fk_internalusage_productID_idx` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_internalusagedetail`
--

LOCK TABLES `tr_internalusagedetail` WRITE;
/*!40000 ALTER TABLE `tr_internalusagedetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_internalusagedetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_internalusagehead`
--

DROP TABLE IF EXISTS `tr_internalusagehead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_internalusagehead` (
  `internalUsageNum` varchar(50) NOT NULL,
  `internalUsageDate` datetime NOT NULL,
  `warehouseID` int(11) NOT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`internalUsageNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_internalusagehead`
--

LOCK TABLES `tr_internalusagehead` WRITE;
/*!40000 ALTER TABLE `tr_internalusagehead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_internalusagehead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_journaldetail`
--

DROP TABLE IF EXISTS `tr_journaldetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_journaldetail` (
  `journalDetailID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Journal Detail ID',
  `journalHeadID` bigint(20) NOT NULL COMMENT 'Journal Head ID',
  `coaNo` varchar(20) NOT NULL COMMENT 'COA No',
  `currency` varchar(5) NOT NULL COMMENT 'Currency',
  `rate` decimal(18,2) NOT NULL COMMENT 'Rate',
  `originalDrAmount` decimal(18,2) NOT NULL COMMENT 'Original Debit Amount',
  `originalCrAmount` decimal(18,2) NOT NULL COMMENT 'Original Credit Amount',
  `drAmount` decimal(18,2) NOT NULL COMMENT 'Debit Amount',
  `crAmount` decimal(18,2) NOT NULL COMMENT 'Credit Amount',
  PRIMARY KEY (`journalDetailID`),
  KEY `fk_journaldetail_coano_idx` (`coaNo`),
  KEY `fk_journaldetail_currency_idx` (`currency`),
  KEY `fk_journaldetail_journalheadid_idx` (`journalHeadID`)
) ENGINE=InnoDB AUTO_INCREMENT=4427 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_journaldetail`
--

LOCK TABLES `tr_journaldetail` WRITE;
/*!40000 ALTER TABLE `tr_journaldetail` DISABLE KEYS */;
INSERT INTO `tr_journaldetail` VALUES (3255,933,'2115.0009','USD',13537.00,0.00,0.00,0.00,0.00),(3256,933,'2115.0010','USD',13537.00,1025.86,0.00,13887000.00,0.00),(3257,933,'2115.0011','USD',13537.00,256.48,0.00,3472000.00,0.00),(3258,933,'2111.0002','USD',13537.00,0.00,1282.34,0.00,17359000.00),(3259,934,'2115.0009','USD',13318.00,0.00,0.00,0.00,0.00),(3260,934,'2115.0010','USD',13318.00,6331.51,0.00,84323000.00,0.00),(3261,934,'2115.0011','USD',13318.00,1582.90,0.00,21081000.00,0.00),(3262,934,'2111.0002','USD',13318.00,0.00,7914.40,0.00,105404000.00),(3263,935,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3264,935,'2115.0010','USD',13577.00,2016.68,0.00,27380444.00,0.00),(3265,935,'2115.0011','USD',13577.00,504.19,0.00,6845333.30,0.00),(3266,935,'2111.0002','USD',13577.00,0.00,2520.86,0.00,34225777.30),(3267,936,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3268,936,'2115.0010','USD',13577.00,0.23,0.00,3100.00,0.00),(3269,936,'2115.0011','USD',13577.00,0.23,0.00,3177.50,0.00),(3270,936,'2111.0002','USD',13577.00,0.00,0.46,0.00,6277.50),(3271,937,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3272,937,'2115.0010','USD',13577.00,0.56,0.00,7590.00,0.00),(3273,937,'2115.0011','USD',13577.00,0.52,0.00,7072.50,0.00),(3274,937,'2111.0002','USD',13577.00,0.00,1.08,0.00,14662.50),(3275,938,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3276,938,'2115.0010','USD',13577.00,504.17,0.00,6845111.20,0.00),(3277,938,'2115.0011','USD',13577.00,126.05,0.00,1711333.40,0.00),(3278,938,'2111.0002','USD',13577.00,0.00,630.22,0.00,8556444.60),(3279,939,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3280,939,'2115.0010','USD',13577.00,185.02,0.00,2512000.00,0.00),(3281,939,'2115.0011','USD',13577.00,46.25,0.00,628000.00,0.00),(3282,939,'2111.0002','USD',13577.00,0.00,231.27,0.00,3140000.00),(3283,940,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3284,940,'2115.0010','USD',13544.00,115.51,0.00,1564500.00,0.00),(3285,940,'2115.0011','USD',13544.00,28.91,0.00,391500.00,0.00),(3286,940,'2111.0002','USD',13544.00,0.00,144.42,0.00,1956000.00),(3287,941,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3288,941,'2115.0010','USD',13544.00,115.51,0.00,1564500.00,0.00),(3289,941,'2115.0011','USD',13544.00,28.91,0.00,391500.00,0.00),(3290,941,'2111.0002','USD',13544.00,0.00,144.42,0.00,1956000.00),(3291,942,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3292,942,'2115.0010','USD',13544.00,1337.71,0.00,18118000.00,0.00),(3293,942,'2115.0011','USD',13544.00,334.47,0.00,4530000.00,0.00),(3294,942,'2111.0002','USD',13544.00,0.00,1672.18,0.00,22648000.00),(3295,943,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3296,943,'2115.0010','USD',13544.00,107.65,0.00,1458000.00,0.00),(3297,943,'2115.0011','USD',13544.00,26.95,0.00,365000.00,0.00),(3298,943,'2111.0002','USD',13544.00,0.00,134.60,0.00,1823000.00),(3299,944,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3300,944,'2115.0010','USD',13544.00,137.55,0.00,1863000.00,0.00),(3301,944,'2115.0011','USD',13544.00,34.41,0.00,466000.00,0.00),(3302,944,'2111.0002','USD',13544.00,0.00,171.96,0.00,2329000.00),(3303,945,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3304,945,'2115.0010','USD',13577.00,98.25,0.00,1334000.00,0.00),(3305,945,'2115.0011','USD',13577.00,98.25,0.00,1334000.00,0.00),(3306,945,'2111.0002','USD',13577.00,0.00,196.51,0.00,2668000.00),(3307,946,'2115.0009','USD',0.00,0.00,0.00,0.00,0.00),(3308,946,'2115.0010','USD',0.00,0.00,0.00,0.00,0.00),(3309,946,'2115.0011','USD',0.00,0.00,0.00,0.00,0.00),(3310,946,'2111.0002','USD',0.00,0.00,0.00,0.00,0.00),(3311,947,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3312,947,'2115.0010','USD',13544.00,126.03,0.00,1707000.00,0.00),(3313,947,'2115.0011','USD',13544.00,31.53,0.00,427000.00,0.00),(3314,947,'2111.0002','USD',13544.00,0.00,157.56,0.00,2134000.00),(3315,948,'2115.0009','USD',13000.00,0.00,0.00,0.00,0.00),(3316,948,'2115.0010','USD',13000.00,0.35,0.00,4500.00,0.00),(3317,948,'2115.0011','USD',13000.00,0.35,0.00,4612.50,0.00),(3318,948,'2111.0002','USD',13000.00,0.00,0.70,0.00,9112.50),(3319,949,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3320,949,'2115.0010','USD',13577.00,55.02,0.00,747000.00,0.00),(3321,949,'2115.0011','USD',13577.00,13.77,0.00,187000.00,0.00),(3322,949,'2111.0002','USD',13577.00,0.00,68.79,0.00,934000.00),(3323,950,'2115.0009','USD',13538.00,0.00,0.00,0.00,0.00),(3324,950,'2115.0010','USD',13538.00,2840.01,0.00,38448000.00,0.00),(3325,950,'2115.0011','USD',13538.00,710.00,0.00,9612000.00,0.00),(3326,950,'2111.0002','USD',13538.00,0.00,3550.01,0.00,48060000.00),(3327,951,'2115.0009','USD',13538.00,150.02,0.00,2031000.00,0.00),(3328,951,'2115.0010','USD',13538.00,315.04,0.00,4265000.00,0.00),(3329,951,'2115.0011','USD',13538.00,78.82,0.00,1067000.00,0.00),(3330,951,'2111.0002','USD',13538.00,0.00,543.88,0.00,7363000.00),(3331,952,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3332,952,'2115.0010','USD',13544.00,0.47,0.00,6300.00,0.00),(3333,952,'2115.0011','USD',13544.00,0.48,0.00,6457.50,0.00),(3334,952,'2111.0002','USD',13544.00,0.00,0.94,0.00,12757.50),(3335,953,'2115.0009','USD',13544.00,0.00,0.00,0.00,0.00),(3336,953,'2115.0010','USD',13544.00,135.04,0.00,1829000.00,0.00),(3337,953,'2115.0011','USD',13544.00,33.82,0.00,458000.00,0.00),(3338,953,'2111.0002','USD',13544.00,0.00,168.86,0.00,2287000.00),(3339,954,'2115.0009','USD',13538.00,0.00,0.00,0.00,0.00),(3340,954,'2115.0010','USD',13538.00,225.07,0.00,3047000.00,0.00),(3341,954,'2115.0011','USD',13538.00,56.29,0.00,762000.00,0.00),(3342,954,'2111.0002','USD',13538.00,0.00,281.36,0.00,3809000.00),(3343,955,'2115.0009','USD',13516.00,0.00,0.00,0.00,0.00),(3344,955,'2115.0010','USD',13516.00,0.86,0.00,11687.50,0.00),(3345,955,'2115.0011','USD',13516.00,0.81,0.00,10890.62,0.00),(3346,955,'2111.0002','USD',13516.00,0.00,1.67,0.00,22578.12),(3347,956,'2115.0009','USD',13516.00,0.00,0.00,0.00,0.00),(3348,956,'2115.0010','USD',13516.00,0.13,0.00,1815.00,0.00),(3349,956,'2115.0011','USD',13516.00,0.13,0.00,1691.25,0.00),(3350,956,'2111.0002','USD',13516.00,0.00,0.26,0.00,3506.25),(3351,957,'2115.0009','USD',13518.00,0.00,0.00,0.00,0.00),(3352,957,'2115.0010','USD',13518.00,0.06,0.00,811.25,0.00),(3353,957,'2115.0011','USD',13518.00,0.06,0.00,755.94,0.00),(3354,957,'2111.0002','USD',13518.00,0.00,0.12,0.00,1567.19),(3355,958,'2115.0009','USD',13518.00,0.00,0.00,0.00,0.00),(3356,958,'2115.0010','USD',13518.00,0.51,0.00,6930.00,0.00),(3357,958,'2115.0011','USD',13518.00,0.48,0.00,6457.50,0.00),(3358,958,'2111.0002','USD',13518.00,0.00,0.99,0.00,13387.50),(3359,959,'2115.0009','USD',13518.00,0.00,0.00,0.00,0.00),(3360,959,'2115.0010','USD',13518.00,0.20,0.00,2750.00,0.00),(3361,959,'2115.0011','USD',13518.00,0.19,0.00,2562.50,0.00),(3362,959,'2111.0002','USD',13518.00,0.00,0.39,0.00,5312.50),(3363,960,'2115.0009','USD',13518.00,0.00,0.00,0.00,0.00),(3364,960,'2115.0010','USD',13518.00,0.65,0.00,8800.00,0.00),(3365,960,'2115.0011','USD',13518.00,0.61,0.00,8200.00,0.00),(3366,960,'2111.0002','USD',13518.00,0.00,1.26,0.00,17000.00),(3367,961,'2115.0009','USD',13518.00,0.00,0.00,0.00,0.00),(3368,961,'2115.0010','USD',13518.00,0.10,0.00,1320.00,0.00),(3369,961,'2115.0011','USD',13518.00,0.09,0.00,1230.00,0.00),(3370,961,'2111.0002','USD',13518.00,0.00,0.19,0.00,2550.00),(3371,962,'2115.0009','USD',13569.00,0.00,0.00,0.00,0.00),(3372,962,'2115.0010','USD',13569.00,5.11,0.00,69300.00,0.00),(3373,962,'2115.0011','USD',13569.00,4.76,0.00,64575.00,0.00),(3374,962,'2111.0002','USD',13569.00,0.00,9.87,0.00,133875.00),(3375,963,'2115.0009','USD',13569.00,0.00,0.00,0.00,0.00),(3376,963,'2115.0010','USD',13569.00,1.17,0.00,15840.00,0.00),(3377,963,'2115.0011','USD',13569.00,1.09,0.00,14760.00,0.00),(3378,963,'2111.0002','USD',13569.00,0.00,2.26,0.00,30600.00),(3379,964,'2115.0009','USD',13516.00,0.00,0.00,0.00,0.00),(3380,964,'2115.0010','USD',13516.00,401.67,0.00,5429000.00,0.00),(3381,964,'2115.0011','USD',13516.00,100.47,0.00,1358000.00,0.00),(3382,964,'2111.0002','USD',13516.00,0.00,502.15,0.00,6787000.00),(3383,965,'2115.0009','USD',13516.00,0.00,0.00,0.00,0.00),(3384,965,'2115.0010','USD',13516.00,85.01,0.00,1149000.00,0.00),(3385,965,'2115.0011','USD',13516.00,21.31,0.00,288000.00,0.00),(3386,965,'2111.0002','USD',13516.00,0.00,106.32,0.00,1437000.00),(3387,966,'2115.0009','USD',13516.00,0.00,0.00,0.00,0.00),(3388,966,'2115.0010','USD',13516.00,1.51,0.00,20400.00,0.00),(3389,966,'2115.0011','USD',13516.00,1.55,0.00,20910.00,0.00),(3390,966,'2111.0002','USD',13516.00,0.00,3.06,0.00,41310.00),(3391,967,'2115.0009','USD',13518.00,795.01,0.00,10747000.00,0.00),(3392,967,'2115.0010','USD',13518.00,1230.57,0.00,16634824.00,0.00),(3393,967,'2115.0011','USD',13518.00,307.67,0.00,4159059.00,0.00),(3394,967,'2111.0002','USD',13518.00,0.00,2333.25,0.00,31540883.00),(3395,968,'2115.0009','USD',13516.00,188.81,0.00,2552000.00,0.00),(3396,968,'2115.0010','USD',13516.00,396.42,0.00,5358000.00,0.00),(3397,968,'2115.0011','USD',13516.00,99.14,0.00,1340000.00,0.00),(3398,968,'2111.0002','USD',13516.00,0.00,684.37,0.00,9250000.00),(3399,969,'2115.0009','USD',13554.00,0.00,0.00,0.00,0.00),(3400,969,'2115.0010','USD',13554.00,0.00,0.00,0.00,0.00),(3401,969,'2115.0011','USD',13554.00,0.00,0.00,0.00,0.00),(3402,969,'2111.0002','USD',13554.00,0.00,0.00,0.00,0.00),(3403,970,'2115.0009','USD',13554.00,0.00,0.00,0.00,0.00),(3404,970,'2115.0010','USD',13554.00,1.07,0.00,14500.00,0.00),(3405,970,'2115.0011','USD',13554.00,1.10,0.00,14862.50,0.00),(3406,970,'2111.0002','USD',13554.00,0.00,2.17,0.00,29362.50),(3407,971,'2115.0009','USD',13445.00,0.00,0.00,0.00,0.00),(3408,971,'2115.0010','USD',13445.00,0.18,0.00,2450.00,0.00),(3409,971,'2115.0011','USD',13445.00,0.19,0.00,2511.25,0.00),(3410,971,'2111.0002','USD',13445.00,0.00,0.37,0.00,4961.25),(3411,972,'2115.0009','USD',13445.00,0.05,0.00,625.00,0.00),(3412,972,'2115.0010','USD',13445.00,0.98,0.00,13125.00,0.00),(3413,972,'2115.0011','USD',13445.00,1.00,0.00,13453.12,0.00),(3414,972,'2111.0002','USD',13445.00,0.00,2.02,0.00,27203.12),(3415,973,'2115.0009','USD',13445.00,0.00,0.00,0.00,0.00),(3416,973,'2115.0010','USD',13445.00,0.23,0.00,3150.00,0.00),(3417,973,'2115.0011','USD',13445.00,0.24,0.00,3228.75,0.00),(3418,973,'2111.0002','USD',13445.00,0.00,0.47,0.00,6378.75),(3419,974,'2115.0009','USD',13445.00,0.00,0.00,0.00,0.00),(3420,974,'2115.0010','USD',13445.00,0.04,0.00,600.00,0.00),(3421,974,'2115.0011','USD',13445.00,0.05,0.00,615.00,0.00),(3422,974,'2111.0002','USD',13445.00,0.00,0.09,0.00,1215.00),(3423,975,'2115.0009','USD',13445.00,0.01,0.00,190.00,0.00),(3424,975,'2115.0010','USD',13445.00,0.31,0.00,4142.00,0.00),(3425,975,'2115.0011','USD',13445.00,0.32,0.00,4245.55,0.00),(3426,975,'2111.0002','USD',13445.00,0.00,0.64,0.00,8577.55),(3427,976,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3428,976,'2115.0010','USD',13391.00,0.04,0.00,511.50,0.00),(3429,976,'2115.0011','USD',13391.00,0.04,0.00,476.62,0.00),(3430,976,'2111.0002','USD',13391.00,0.00,0.07,0.00,988.12),(3431,977,'2115.0009','USD',13391.00,0.16,0.00,2131.88,0.00),(3432,977,'2115.0010','USD',13391.00,0.51,0.00,6869.38,0.00),(3433,977,'2115.0011','USD',13391.00,0.53,0.00,7041.11,0.00),(3434,977,'2111.0002','USD',13391.00,0.00,1.20,0.00,16042.37),(3435,978,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3436,978,'2115.0010','USD',13391.00,1.70,0.00,22800.00,0.00),(3437,978,'2115.0011','USD',13391.00,1.75,0.00,23370.00,0.00),(3438,978,'2111.0002','USD',13391.00,0.00,3.45,0.00,46170.00),(3439,979,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3440,979,'2115.0010','USD',13391.00,0.16,0.00,2125.00,0.00),(3441,979,'2115.0011','USD',13391.00,0.16,0.00,2178.13,0.00),(3442,979,'2111.0002','USD',13391.00,0.00,0.32,0.00,4303.13),(3443,980,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3444,980,'2115.0010','USD',13391.00,0.35,0.00,4675.00,0.00),(3445,980,'2115.0011','USD',13391.00,0.33,0.00,4356.25,0.00),(3446,980,'2111.0002','USD',13391.00,0.00,0.67,0.00,9031.25),(3447,981,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3448,981,'2115.0010','USD',13391.00,0.53,0.00,7150.00,0.00),(3449,981,'2115.0011','USD',13391.00,0.55,0.00,7328.75,0.00),(3450,981,'2111.0002','USD',13391.00,0.00,1.08,0.00,14478.75),(3451,982,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3452,982,'2115.0010','USD',13391.00,0.10,0.00,1300.00,0.00),(3453,982,'2115.0011','USD',13391.00,0.10,0.00,1332.50,0.00),(3454,982,'2111.0002','USD',13391.00,0.00,0.20,0.00,2632.50),(3455,983,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3456,983,'2115.0010','USD',13391.00,0.37,0.00,4950.00,0.00),(3457,983,'2115.0011','USD',13391.00,0.34,0.00,4612.50,0.00),(3458,983,'2111.0002','USD',13391.00,0.00,0.71,0.00,9562.50),(3459,984,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3460,984,'2115.0010','USD',13391.00,0.07,0.00,975.00,0.00),(3461,984,'2115.0011','USD',13391.00,0.07,0.00,999.37,0.00),(3462,984,'2111.0002','USD',13391.00,0.00,0.15,0.00,1974.37),(3463,985,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3464,985,'2115.0010','USD',13391.00,0.18,0.00,2400.00,0.00),(3465,985,'2115.0011','USD',13391.00,0.18,0.00,2460.00,0.00),(3466,985,'2111.0002','USD',13391.00,0.00,0.36,0.00,4860.00),(3467,986,'2115.0009','USD',13391.00,0.00,0.00,0.00,0.00),(3468,986,'2115.0010','USD',13391.00,0.30,0.00,4042.50,0.00),(3469,986,'2115.0011','USD',13391.00,0.28,0.00,3766.87,0.00),(3470,986,'2111.0002','USD',13391.00,0.00,0.58,0.00,7809.37),(3471,987,'2115.0009','USD',13339.00,0.00,0.00,0.00,0.00),(3472,987,'2115.0010','USD',13339.00,0.14,0.00,1914.00,0.00),(3473,987,'2115.0011','USD',13339.00,0.13,0.00,1783.50,0.00),(3474,987,'2111.0002','USD',13339.00,0.00,0.28,0.00,3697.50),(3475,988,'2115.0009','USD',13339.00,0.00,0.00,0.00,0.00),(3476,988,'2115.0010','USD',13339.00,0.66,0.00,8750.00,0.00),(3477,988,'2115.0011','USD',13339.00,0.67,0.00,8968.75,0.00),(3478,988,'2111.0002','USD',13339.00,0.00,1.33,0.00,17718.75),(3479,989,'2115.0009','USD',13339.00,0.00,0.00,0.00,0.00),(3480,989,'2115.0010','USD',13339.00,0.52,0.00,7000.00,0.00),(3481,989,'2115.0011','USD',13339.00,0.54,0.00,7175.00,0.00),(3482,989,'2111.0002','USD',13339.00,0.00,1.06,0.00,14175.00),(3483,990,'2115.0009','USD',13339.00,0.00,0.00,0.00,0.00),(3484,990,'2115.0010','USD',13339.00,0.66,0.00,8750.00,0.00),(3485,990,'2115.0011','USD',13339.00,0.67,0.00,8968.75,0.00),(3486,990,'2111.0002','USD',13339.00,0.00,1.33,0.00,17718.75),(3487,991,'2115.0009','USD',13339.00,0.00,0.00,0.00,0.00),(3488,991,'2115.0010','USD',13339.00,0.97,0.00,12980.00,0.00),(3489,991,'2115.0011','USD',13339.00,0.91,0.00,12095.00,0.00),(3490,991,'2111.0002','USD',13339.00,0.00,1.88,0.00,25075.00),(3491,992,'2115.0009','USD',13339.00,0.01,0.00,76.25,0.00),(3492,992,'2115.0010','USD',13339.00,0.13,0.00,1761.38,0.00),(3493,992,'2115.0011','USD',13339.00,0.12,0.00,1641.28,0.00),(3494,992,'2111.0002','USD',13339.00,0.00,0.26,0.00,3478.91),(3495,993,'2115.0009','USD',13339.00,0.01,0.00,72.50,0.00),(3496,993,'2115.0010','USD',13339.00,0.13,0.00,1674.75,0.00),(3497,993,'2115.0011','USD',13339.00,0.12,0.00,1560.56,0.00),(3498,993,'2111.0002','USD',13339.00,0.00,0.25,0.00,3307.81),(3499,994,'2115.0009','USD',13339.00,0.00,0.00,0.00,0.00),(3500,994,'2115.0010','USD',13339.00,0.40,0.00,5325.00,0.00),(3501,994,'2115.0011','USD',13339.00,0.41,0.00,5458.12,0.00),(3502,994,'2111.0002','USD',13339.00,0.00,0.81,0.00,10783.12),(3503,995,'2115.0009','USD',13339.00,0.00,0.00,0.00,0.00),(3504,995,'2115.0010','USD',13339.00,0.84,0.00,11200.00,0.00),(3505,995,'2115.0011','USD',13339.00,0.86,0.00,11480.00,0.00),(3506,995,'2111.0002','USD',13339.00,0.00,1.70,0.00,22680.00),(3507,996,'2115.0009','USD',13313.00,0.00,0.00,0.00,0.00),(3508,996,'2115.0010','USD',13313.00,0.08,0.00,1000.00,0.00),(3509,996,'2115.0011','USD',13313.00,0.08,0.00,1025.00,0.00),(3510,996,'2111.0002','USD',13313.00,0.00,0.15,0.00,2025.00),(3511,997,'2115.0009','USD',13313.00,0.00,0.00,0.00,0.00),(3512,997,'2115.0010','USD',13313.00,62.57,0.00,833000.00,0.00),(3513,997,'2115.0011','USD',13313.00,15.70,0.00,209000.00,0.00),(3514,997,'2111.0002','USD',13313.00,0.00,78.27,0.00,1042000.00),(3515,998,'2115.0009','USD',13313.00,0.00,0.00,0.00,0.00),(3516,998,'2115.0010','USD',13313.00,212.57,0.00,2830000.00,0.00),(3517,998,'2115.0011','USD',13313.00,53.18,0.00,708000.00,0.00),(3518,998,'2111.0002','USD',13313.00,0.00,265.76,0.00,3538000.00),(3519,999,'2115.0009','USD',13577.00,0.00,0.00,0.00,0.00),(3520,999,'2115.0010','USD',13577.00,1344.45,0.00,18253630.00,0.00),(3521,999,'2115.0011','USD',13577.00,336.12,0.00,4563555.60,0.00),(3522,999,'2111.0002','USD',13577.00,0.00,1680.58,0.00,22817185.60),(3523,1000,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3524,1000,'2115.0010','USD',13440.00,2397.54,0.00,32223000.00,0.00),(3525,1000,'2115.0011','USD',13440.00,599.40,0.00,8056000.00,0.00),(3526,1000,'2111.0002','USD',13440.00,0.00,2996.95,0.00,40279000.00),(3527,1001,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3528,1001,'2115.0010','USD',13440.00,592.56,0.00,7964000.00,0.00),(3529,1001,'2115.0011','USD',13440.00,148.14,0.00,1991000.00,0.00),(3530,1001,'2111.0002','USD',13440.00,0.00,740.70,0.00,9955000.00),(3531,1002,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3532,1002,'2115.0010','USD',13440.00,220.87,0.00,2968482.00,0.00),(3533,1002,'2115.0011','USD',13440.00,55.23,0.00,742350.50,0.00),(3534,1002,'2111.0002','USD',13440.00,0.00,276.10,0.00,3710832.50),(3535,1003,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3536,1003,'2115.0010','USD',13440.00,220.87,0.00,2968482.00,0.00),(3537,1003,'2115.0011','USD',13440.00,55.23,0.00,742350.50,0.00),(3538,1003,'2111.0002','USD',13440.00,0.00,276.10,0.00,3710832.50),(3539,1004,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3540,1004,'2115.0010','USD',13440.00,90.03,0.00,1210000.00,0.00),(3541,1004,'2115.0011','USD',13440.00,22.54,0.00,303000.00,0.00),(3542,1004,'2111.0002','USD',13440.00,0.00,112.57,0.00,1513000.00),(3543,1005,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3544,1005,'2115.0010','USD',13440.00,280.06,0.00,3764036.00,0.00),(3545,1005,'2115.0011','USD',13440.00,70.04,0.00,941299.00,0.00),(3546,1005,'2111.0002','USD',13440.00,0.00,350.10,0.00,4705335.00),(3547,1006,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3548,1006,'2115.0010','USD',13440.00,26.04,0.00,350000.00,0.00),(3549,1006,'2115.0011','USD',13440.00,54.61,0.00,734000.00,0.00),(3550,1006,'2111.0002','USD',13440.00,0.00,80.65,0.00,1084000.00),(3551,1007,'2115.0009','USD',13440.00,1215.03,0.00,16330000.00,0.00),(3552,1007,'2115.0010','USD',13440.00,2551.56,0.00,34293000.00,0.00),(3553,1007,'2115.0011','USD',13440.00,637.95,0.00,8574000.00,0.00),(3554,1007,'2111.0002','USD',13440.00,0.00,4404.54,0.00,59197000.00),(3555,1008,'2115.0009','USD',13440.00,0.00,0.00,0.00,0.00),(3556,1008,'2115.0010','USD',13440.00,125.00,0.00,1680000.00,0.00),(3557,1008,'2115.0011','USD',13440.00,31.25,0.00,420000.00,0.00),(3558,1008,'2111.0002','USD',13440.00,0.00,156.25,0.00,2100000.00),(3559,1009,'2115.0009','USD',13592.00,0.00,0.00,0.00,0.00),(3560,1009,'2115.0010','USD',13592.00,87.55,0.00,1190000.00,0.00),(3561,1009,'2115.0011','USD',13592.00,21.92,0.00,298000.00,0.00),(3562,1009,'2111.0002','USD',13592.00,0.00,109.48,0.00,1488000.00),(3563,1010,'2115.0009','USD',13581.00,57.51,0.00,781000.00,0.00),(3564,1010,'2115.0010','USD',13581.00,120.76,0.00,1640000.00,0.00),(3565,1010,'2115.0011','USD',13581.00,30.19,0.00,410000.00,0.00),(3566,1010,'2111.0002','USD',13581.00,0.00,208.45,0.00,2831000.00),(3567,1011,'2115.0009','USD',13592.00,79.16,0.00,1076000.00,0.00),(3568,1011,'2115.0010','USD',13592.00,113.52,0.00,1543000.00,0.00),(3569,1011,'2115.0011','USD',13592.00,113.52,0.00,1543000.00,0.00),(3570,1011,'2111.0002','USD',13592.00,0.00,306.21,0.00,4162000.00),(3571,1024,'5110.0001','IDR',1.00,54695250.00,0.00,54695250.00,0.00),(3572,1024,'1119.0001','IDR',1.00,0.00,54695250.00,0.00,54695250.00),(3573,1024,'1114.0001','IDR',1.00,67518000.00,0.00,67518000.00,0.00),(3574,1024,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3575,1024,'4110.0002','IDR',1.00,0.00,61380000.00,0.00,61380000.00),(3576,1024,'2115.0002','IDR',1.00,0.00,6138000.00,0.00,6138000.00),(3577,1025,'5110.0001','IDR',1.00,54695250.00,0.00,54695250.00,0.00),(3578,1025,'1119.0001','IDR',1.00,0.00,54695250.00,0.00,54695250.00),(3579,1025,'1114.0001','IDR',1.00,67518000.00,0.00,67518000.00,0.00),(3580,1025,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3581,1025,'4110.0002','IDR',1.00,0.00,61380000.00,0.00,61380000.00),(3582,1025,'2115.0002','IDR',1.00,0.00,6138000.00,0.00,6138000.00),(3583,1026,'5110.0001','IDR',1.00,54695250.00,0.00,54695250.00,0.00),(3584,1026,'1119.0001','IDR',1.00,0.00,54695250.00,0.00,54695250.00),(3585,1026,'1114.0001','IDR',1.00,67518000.00,0.00,67518000.00,0.00),(3586,1026,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3587,1026,'4110.0002','IDR',1.00,0.00,61380000.00,0.00,61380000.00),(3588,1026,'2115.0002','IDR',1.00,0.00,6138000.00,0.00,6138000.00),(3589,1027,'5110.0001','IDR',1.00,54695250.00,0.00,54695250.00,0.00),(3590,1027,'1119.0001','IDR',1.00,0.00,54695250.00,0.00,54695250.00),(3591,1027,'1114.0001','IDR',1.00,67518000.00,0.00,67518000.00,0.00),(3592,1027,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3593,1027,'4110.0002','IDR',1.00,0.00,61380000.00,0.00,61380000.00),(3594,1027,'2115.0002','IDR',1.00,0.00,6138000.00,0.00,6138000.00),(3595,1028,'5110.0001','IDR',1.00,54695250.00,0.00,54695250.00,0.00),(3596,1028,'1119.0001','IDR',1.00,0.00,54695250.00,0.00,54695250.00),(3597,1028,'1114.0001','IDR',1.00,67518000.00,0.00,67518000.00,0.00),(3598,1028,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3599,1028,'4110.0002','IDR',1.00,0.00,61380000.00,0.00,61380000.00),(3600,1028,'2115.0002','IDR',1.00,0.00,6138000.00,0.00,6138000.00),(3601,1029,'5110.0001','IDR',1.00,1025.00,0.00,1025.00,0.00),(3602,1029,'1119.0001','IDR',1.00,0.00,1025.00,0.00,1025.00),(3603,1029,'1114.0001','IDR',1.00,19540950.00,0.00,19540950.00,0.00),(3604,1029,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3605,1029,'4110.0002','IDR',1.00,0.00,17764500.00,0.00,17764500.00),(3606,1029,'2115.0002','IDR',1.00,0.00,1776450.00,0.00,1776450.00),(3607,1030,'5110.0001','IDR',1.00,900.00,0.00,900.00,0.00),(3608,1030,'1119.0003','IDR',1.00,0.00,900.00,0.00,900.00),(3609,1030,'1114.0001','IDR',1.00,19540950.00,0.00,19540950.00,0.00),(3610,1030,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3611,1030,'4110.0002','IDR',1.00,0.00,17764500.00,0.00,17764500.00),(3612,1030,'2115.0002','IDR',1.00,0.00,1776450.00,0.00,1776450.00),(3613,1031,'5110.0001','IDR',1.00,18284400.00,0.00,18284400.00,0.00),(3614,1031,'1119.0001','IDR',1.00,0.00,18284400.00,0.00,18284400.00),(3615,1031,'1114.0001','IDR',1.00,27126000.00,0.00,27126000.00,0.00),(3616,1031,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3617,1031,'4110.0002','IDR',1.00,0.00,24660000.00,0.00,24660000.00),(3618,1031,'2115.0002','IDR',1.00,0.00,2466000.00,0.00,2466000.00),(3619,1032,'5110.0001','IDR',1.00,87041500.00,0.00,87041500.00,0.00),(3620,1032,'1119.0001','IDR',1.00,0.00,87041500.00,0.00,87041500.00),(3621,1032,'1114.0001','IDR',1.00,122267475.00,0.00,122267475.00,0.00),(3622,1032,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3623,1032,'4110.0002','IDR',1.00,0.00,111152250.00,0.00,111152250.00),(3624,1032,'2115.0002','IDR',1.00,0.00,11115225.00,0.00,11115225.00),(3625,1033,'5110.0001','IDR',1.00,18806634.00,0.00,18806634.00,0.00),(3626,1033,'1119.0001','IDR',1.00,0.00,18806634.00,0.00,18806634.00),(3627,1033,'1114.0001','IDR',1.00,25016200.00,0.00,25016200.00,0.00),(3628,1033,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3629,1033,'4110.0002','IDR',1.00,0.00,22742000.00,0.00,22742000.00),(3630,1033,'2115.0002','IDR',1.00,0.00,2274200.00,0.00,2274200.00),(3631,1034,'5110.0001','IDR',1.00,93373000.00,0.00,93373000.00,0.00),(3632,1034,'1119.0001','IDR',1.00,0.00,93373000.00,0.00,93373000.00),(3633,1034,'1114.0001','IDR',1.00,128958500.00,0.00,128958500.00,0.00),(3634,1034,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3635,1034,'4110.0002','IDR',1.00,0.00,117235000.00,0.00,117235000.00),(3636,1034,'2115.0002','IDR',1.00,0.00,11723500.00,0.00,11723500.00),(3637,1035,'5110.0001','IDR',1.00,42088700.00,0.00,42088700.00,0.00),(3638,1035,'1119.0001','IDR',1.00,0.00,42088700.00,0.00,42088700.00),(3639,1035,'1114.0001','IDR',1.00,51810.00,0.00,51810.00,0.00),(3640,1035,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3641,1035,'4110.0002','IDR',1.00,0.00,47100.00,0.00,47100.00),(3642,1035,'2115.0002','IDR',1.00,0.00,4710.00,0.00,4710.00),(3643,1036,'5110.0001','IDR',1.00,1375.00,0.00,1375.00,0.00),(3644,1036,'1119.0001','IDR',1.00,0.00,1375.00,0.00,1375.00),(3645,1036,'1114.0001','IDR',1.00,22825000.00,0.00,22825000.00,0.00),(3646,1036,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3647,1036,'4110.0002','IDR',1.00,0.00,20750000.00,0.00,20750000.00),(3648,1036,'2115.0002','IDR',1.00,0.00,2075000.00,0.00,2075000.00),(3649,1037,'5110.0001','IDR',1.00,9570744.00,0.00,9570744.00,0.00),(3650,1037,'1119.0001','IDR',1.00,0.00,9570744.00,0.00,9570744.00),(3651,1037,'1114.0001','IDR',1.00,14993286.00,0.00,14993286.00,0.00),(3652,1037,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3653,1037,'4110.0002','IDR',1.00,0.00,13630260.00,0.00,13630260.00),(3654,1037,'2115.0002','IDR',1.00,0.00,1363026.00,0.00,1363026.00),(3655,1038,'5110.0001','IDR',1.00,9770.00,0.00,9770.00,0.00),(3656,1038,'1119.0001','IDR',1.00,0.00,9770.00,0.00,9770.00),(3657,1038,'1114.0001','IDR',1.00,165604890.00,0.00,165604890.00,0.00),(3658,1038,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3659,1038,'4110.0002','IDR',1.00,0.00,150549900.00,0.00,150549900.00),(3660,1038,'2115.0002','IDR',1.00,0.00,15054990.00,0.00,15054990.00),(3661,1039,'5110.0001','IDR',1.00,51524715.00,0.00,51524715.00,0.00),(3662,1039,'1119.0003','IDR',1.00,0.00,51524715.00,0.00,51524715.00),(3663,1039,'1114.0001','IDR',1.00,74250000.00,0.00,74250000.00,0.00),(3664,1039,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3665,1039,'4110.0002','IDR',1.00,0.00,67500000.00,0.00,67500000.00),(3666,1039,'2115.0002','IDR',1.00,0.00,6750000.00,0.00,6750000.00),(3667,1040,'5110.0001','IDR',1.00,51524715.00,0.00,51524715.00,0.00),(3668,1040,'1119.0003','IDR',1.00,0.00,51524715.00,0.00,51524715.00),(3669,1040,'1114.0001','IDR',1.00,74250000.00,0.00,74250000.00,0.00),(3670,1040,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3671,1040,'4110.0002','IDR',1.00,0.00,67500000.00,0.00,67500000.00),(3672,1040,'2115.0002','IDR',1.00,0.00,6750000.00,0.00,6750000.00),(3673,1041,'5110.0001','IDR',1.00,103049430.00,0.00,103049430.00,0.00),(3674,1041,'1119.0003','IDR',1.00,0.00,103049430.00,0.00,103049430.00),(3675,1041,'1114.0001','IDR',1.00,149600000.00,0.00,149600000.00,0.00),(3676,1041,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3677,1041,'4110.0002','IDR',1.00,0.00,136000000.00,0.00,136000000.00),(3678,1041,'2115.0002','IDR',1.00,0.00,13600000.00,0.00,13600000.00),(3679,1042,'5110.0001','IDR',1.00,51524715.00,0.00,51524715.00,0.00),(3680,1042,'1119.0003','IDR',1.00,0.00,51524715.00,0.00,51524715.00),(3681,1042,'1114.0001','IDR',1.00,74800000.00,0.00,74800000.00,0.00),(3682,1042,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3683,1042,'4110.0002','IDR',1.00,0.00,68000000.00,0.00,68000000.00),(3684,1042,'2115.0002','IDR',1.00,0.00,6800000.00,0.00,6800000.00),(3685,1044,'5110.0001','IDR',1.00,29396400.00,0.00,29396400.00,0.00),(3686,1044,'1119.0001','IDR',1.00,0.00,29396400.00,0.00,29396400.00),(3687,1044,'1114.0001','IDR',1.00,37920795.00,0.00,37920795.00,0.00),(3688,1044,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3689,1044,'4110.0002','IDR',1.00,0.00,34473450.00,0.00,34473450.00),(3690,1044,'2115.0002','IDR',1.00,0.00,3447345.00,0.00,3447345.00),(3691,1045,'5110.0001','IDR',1.00,83323800.00,0.00,83323800.00,0.00),(3692,1045,'1119.0001','IDR',1.00,0.00,83323800.00,0.00,83323800.00),(3693,1045,'1114.0001','IDR',1.00,145530000.00,0.00,145530000.00,0.00),(3694,1045,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3695,1045,'4110.0002','IDR',1.00,0.00,132300000.00,0.00,132300000.00),(3696,1045,'2115.0002','IDR',1.00,0.00,13230000.00,0.00,13230000.00),(3697,1046,'5110.0001','IDR',1.00,85327200.00,0.00,85327200.00,0.00),(3698,1046,'1119.0001','IDR',1.00,0.00,85327200.00,0.00,85327200.00),(3699,1046,'1114.0001','IDR',1.00,145530000.00,0.00,145530000.00,0.00),(3700,1046,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3701,1046,'4110.0002','IDR',1.00,0.00,132300000.00,0.00,132300000.00),(3702,1046,'2115.0002','IDR',1.00,0.00,13230000.00,0.00,13230000.00),(3703,1047,'5110.0001','IDR',1.00,93679740.00,0.00,93679740.00,0.00),(3704,1047,'1119.0001','IDR',1.00,0.00,93679740.00,0.00,93679740.00),(3705,1047,'1114.0001','IDR',1.00,146018950.00,0.00,146018950.00,0.00),(3706,1047,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3707,1047,'4110.0002','IDR',1.00,0.00,132744500.00,0.00,132744500.00),(3708,1047,'2115.0002','IDR',1.00,0.00,13274450.00,0.00,13274450.00),(3709,1048,'5110.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3710,1048,'1119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3711,1048,'1114.0001','IDR',1.00,19250000.00,0.00,19250000.00,0.00),(3712,1048,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3713,1048,'4110.0002','IDR',1.00,0.00,17500000.00,0.00,17500000.00),(3714,1048,'2115.0002','IDR',1.00,0.00,1750000.00,0.00,1750000.00),(3715,1049,'5110.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3716,1049,'1119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3717,1049,'1114.0001','IDR',1.00,19250000.00,0.00,19250000.00,0.00),(3718,1049,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3719,1049,'4110.0002','IDR',1.00,0.00,17500000.00,0.00,17500000.00),(3720,1049,'2115.0002','IDR',1.00,0.00,1750000.00,0.00,1750000.00),(3721,1050,'5110.0001','IDR',1.00,64130.00,0.00,64130.00,0.00),(3722,1050,'1119.0001','IDR',1.00,0.00,64130.00,0.00,64130.00),(3723,1050,'1114.0001','IDR',1.00,211679600.00,0.00,211679600.00,0.00),(3724,1050,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3725,1050,'4110.0002','IDR',1.00,0.00,192436000.00,0.00,192436000.00),(3726,1050,'2115.0002','IDR',1.00,0.00,19243600.00,0.00,19243600.00),(3727,1051,'5110.0001','IDR',1.00,101250000.00,0.00,101250000.00,0.00),(3728,1051,'1119.0001','IDR',1.00,0.00,101250000.00,0.00,101250000.00),(3729,1051,'1114.0001','IDR',1.00,111375000.00,0.00,111375000.00,0.00),(3730,1051,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3731,1051,'4110.0002','IDR',1.00,0.00,101250000.00,0.00,101250000.00),(3732,1051,'2115.0002','IDR',1.00,0.00,10125000.00,0.00,10125000.00),(3733,1052,'5110.0001','IDR',1.00,2035.00,0.00,2035.00,0.00),(3734,1052,'1119.0001','IDR',1.00,0.00,2035.00,0.00,2035.00),(3735,1052,'1114.0001','IDR',1.00,32632517.50,0.00,32632517.50,0.00),(3736,1052,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3737,1052,'4110.0002','IDR',1.00,0.00,29665925.00,0.00,29665925.00),(3738,1052,'2115.0002','IDR',1.00,0.00,2966592.50,0.00,2966592.50),(3739,1053,'5110.0001','IDR',1.00,6175.00,0.00,6175.00,0.00),(3740,1053,'1119.0001','IDR',1.00,0.00,6175.00,0.00,6175.00),(3741,1053,'1114.0001','IDR',1.00,567270000.00,0.00,567270000.00,0.00),(3742,1053,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3743,1053,'4110.0002','IDR',1.00,0.00,515700000.00,0.00,515700000.00),(3744,1053,'2115.0002','IDR',1.00,0.00,51570000.00,0.00,51570000.00),(3745,1054,'5110.0001','IDR',1.00,325.00,0.00,325.00,0.00),(3746,1054,'1119.0001','IDR',1.00,0.00,325.00,0.00,325.00),(3747,1054,'1114.0001','IDR',1.00,14850000.00,0.00,14850000.00,0.00),(3748,1054,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3749,1054,'4110.0002','IDR',1.00,0.00,13500000.00,0.00,13500000.00),(3750,1054,'2115.0002','IDR',1.00,0.00,1350000.00,0.00,1350000.00),(3751,1055,'5110.0001','IDR',1.00,84712500.00,0.00,84712500.00,0.00),(3752,1055,'1119.0001','IDR',1.00,0.00,84712500.00,0.00,84712500.00),(3753,1055,'1114.0001','IDR',1.00,297000000.00,0.00,297000000.00,0.00),(3754,1055,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3755,1055,'4110.0002','IDR',1.00,0.00,270000000.00,0.00,270000000.00),(3756,1055,'2115.0002','IDR',1.00,0.00,27000000.00,0.00,27000000.00),(3757,1056,'5110.0001','IDR',1.00,40614000.00,0.00,40614000.00,0.00),(3758,1056,'1119.0001','IDR',1.00,0.00,40614000.00,0.00,40614000.00),(3759,1056,'1114.0001','IDR',1.00,112777500.00,0.00,112777500.00,0.00),(3760,1056,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3761,1056,'4110.0002','IDR',1.00,0.00,102525000.00,0.00,102525000.00),(3762,1056,'2115.0002','IDR',1.00,0.00,10252500.00,0.00,10252500.00),(3763,1057,'5110.0001','IDR',1.00,214932960.00,0.00,214932960.00,0.00),(3764,1057,'1119.0003','IDR',1.00,0.00,214932960.00,0.00,214932960.00),(3765,1057,'1114.0001','IDR',1.00,465973200.00,0.00,465973200.00,0.00),(3766,1057,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3767,1057,'4110.0002','IDR',1.00,0.00,423612000.00,0.00,423612000.00),(3768,1057,'2115.0002','IDR',1.00,0.00,42361200.00,0.00,42361200.00),(3769,1058,'5110.0001','IDR',1.00,24531540.00,0.00,24531540.00,0.00),(3770,1058,'1119.0001','IDR',1.00,0.00,24531540.00,0.00,24531540.00),(3771,1058,'1114.0001','IDR',1.00,59070000.00,0.00,59070000.00,0.00),(3772,1058,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3773,1058,'4110.0002','IDR',1.00,0.00,53700000.00,0.00,53700000.00),(3774,1058,'2115.0002','IDR',1.00,0.00,5370000.00,0.00,5370000.00),(3775,1059,'5110.0001','IDR',1.00,169425000.00,0.00,169425000.00,0.00),(3776,1059,'1119.0001','IDR',1.00,0.00,169425000.00,0.00,169425000.00),(3777,1059,'1114.0001','IDR',1.00,594000000.00,0.00,594000000.00,0.00),(3778,1059,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3779,1059,'4110.0002','IDR',1.00,0.00,540000000.00,0.00,540000000.00),(3780,1059,'2115.0002','IDR',1.00,0.00,54000000.00,0.00,54000000.00),(3781,1060,'5110.0001','IDR',1.00,1760.00,0.00,1760.00,0.00),(3782,1060,'1119.0001','IDR',1.00,0.00,1760.00,0.00,1760.00),(3783,1060,'1114.0001','IDR',1.00,58652000.00,0.00,58652000.00,0.00),(3784,1060,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3785,1060,'4110.0002','IDR',1.00,0.00,53320000.00,0.00,53320000.00),(3786,1060,'2115.0002','IDR',1.00,0.00,5332000.00,0.00,5332000.00),(3787,1061,'5110.0001','IDR',1.00,32138400.00,0.00,32138400.00,0.00),(3788,1061,'1119.0001','IDR',1.00,0.00,32138400.00,0.00,32138400.00),(3789,1061,'1114.0001','IDR',1.00,96734000.00,0.00,96734000.00,0.00),(3790,1061,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3791,1061,'4110.0002','IDR',1.00,0.00,87940000.00,0.00,87940000.00),(3792,1061,'2115.0002','IDR',1.00,0.00,8794000.00,0.00,8794000.00),(3793,1062,'5110.0001','IDR',1.00,192239600.00,0.00,192239600.00,0.00),(3794,1062,'1119.0001','IDR',1.00,0.00,192239600.00,0.00,192239600.00),(3795,1062,'1114.0001','IDR',1.00,233200000.00,0.00,233200000.00,0.00),(3796,1062,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3797,1062,'4110.0002','IDR',1.00,0.00,212000000.00,0.00,212000000.00),(3798,1062,'2115.0002','IDR',1.00,0.00,21200000.00,0.00,21200000.00),(3799,1063,'5110.0001','IDR',1.00,192239600.00,0.00,192239600.00,0.00),(3800,1063,'1119.0001','IDR',1.00,0.00,192239600.00,0.00,192239600.00),(3801,1063,'1114.0001','IDR',1.00,233200000.00,0.00,233200000.00,0.00),(3802,1063,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3803,1063,'4110.0002','IDR',1.00,0.00,212000000.00,0.00,212000000.00),(3804,1063,'2115.0002','IDR',1.00,0.00,21200000.00,0.00,21200000.00),(3805,1064,'5110.0001','IDR',1.00,51698700.00,0.00,51698700.00,0.00),(3806,1064,'1119.0001','IDR',1.00,0.00,51698700.00,0.00,51698700.00),(3807,1064,'1114.0001','IDR',1.00,66380600.00,0.00,66380600.00,0.00),(3808,1064,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3809,1064,'4110.0002','IDR',1.00,0.00,60346000.00,0.00,60346000.00),(3810,1064,'2115.0002','IDR',1.00,0.00,6034600.00,0.00,6034600.00),(3811,1065,'5110.0001','IDR',1.00,11488600.00,0.00,11488600.00,0.00),(3812,1065,'1119.0001','IDR',1.00,0.00,11488600.00,0.00,11488600.00),(3813,1065,'1114.0001','IDR',1.00,55945824.00,0.00,55945824.00,0.00),(3814,1065,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3815,1065,'4110.0002','IDR',1.00,0.00,50859840.00,0.00,50859840.00),(3816,1065,'2115.0002','IDR',1.00,0.00,5085984.00,0.00,5085984.00),(3817,1066,'5110.0001','IDR',1.00,67122720.00,0.00,67122720.00,0.00),(3818,1066,'1119.0001','IDR',1.00,0.00,67122720.00,0.00,67122720.00),(3819,1066,'1114.0001','IDR',1.00,110484000.00,0.00,110484000.00,0.00),(3820,1066,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3821,1066,'4110.0002','IDR',1.00,0.00,100440000.00,0.00,100440000.00),(3822,1066,'2115.0002','IDR',1.00,0.00,10044000.00,0.00,10044000.00),(3823,1067,'5110.0001','IDR',1.00,206872974.00,0.00,206872974.00,0.00),(3824,1067,'1119.0001','IDR',1.00,0.00,206872974.00,0.00,206872974.00),(3825,1067,'1114.0001','IDR',1.00,303831000.00,0.00,303831000.00,0.00),(3826,1067,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3827,1067,'4110.0002','IDR',1.00,0.00,276210000.00,0.00,276210000.00),(3828,1067,'2115.0002','IDR',1.00,0.00,27621000.00,0.00,27621000.00),(3829,1068,'5110.0001','IDR',1.00,15600000.00,0.00,15600000.00,0.00),(3830,1068,'1119.0001','IDR',1.00,0.00,15600000.00,0.00,15600000.00),(3831,1068,'1114.0001','IDR',1.00,21604000.00,0.00,21604000.00,0.00),(3832,1068,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3833,1068,'4110.0002','IDR',1.00,0.00,19640000.00,0.00,19640000.00),(3834,1068,'2115.0002','IDR',1.00,0.00,1964000.00,0.00,1964000.00),(3835,1069,'5110.0001','IDR',1.00,28455875.00,0.00,28455875.00,0.00),(3836,1069,'1119.0001','IDR',1.00,0.00,28455875.00,0.00,28455875.00),(3837,1069,'1114.0001','IDR',1.00,38921740.00,0.00,38921740.00,0.00),(3838,1069,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3839,1069,'4110.0002','IDR',1.00,0.00,35383400.00,0.00,35383400.00),(3840,1069,'2115.0002','IDR',1.00,0.00,3538340.00,0.00,3538340.00),(3841,1070,'5110.0001','IDR',1.00,28455875.00,0.00,28455875.00,0.00),(3842,1070,'1119.0001','IDR',1.00,0.00,28455875.00,0.00,28455875.00),(3843,1070,'1114.0001','IDR',1.00,38853100.00,0.00,38853100.00,0.00),(3844,1070,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3845,1070,'4110.0002','IDR',1.00,0.00,35321000.00,0.00,35321000.00),(3846,1070,'2115.0002','IDR',1.00,0.00,3532100.00,0.00,3532100.00),(3847,1071,'5110.0001','IDR',1.00,309148290.00,0.00,309148290.00,0.00),(3848,1071,'1119.0003','IDR',1.00,0.00,309148290.00,0.00,309148290.00),(3849,1071,'1114.0001','IDR',1.00,364998150.00,0.00,364998150.00,0.00),(3850,1071,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3851,1071,'4110.0002','IDR',1.00,0.00,331816500.00,0.00,331816500.00),(3852,1071,'2115.0002','IDR',1.00,0.00,33181650.00,0.00,33181650.00),(3853,1072,'5110.0001','IDR',1.00,29396400.00,0.00,29396400.00,0.00),(3854,1072,'1119.0001','IDR',1.00,0.00,29396400.00,0.00,29396400.00),(3855,1072,'1114.0001','IDR',1.00,39171385.00,0.00,39171385.00,0.00),(3856,1072,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3857,1072,'4110.0002','IDR',1.00,0.00,35610350.00,0.00,35610350.00),(3858,1072,'2115.0002','IDR',1.00,0.00,3561035.00,0.00,3561035.00),(3859,1073,'5110.0001','IDR',1.00,275726400.00,0.00,275726400.00,0.00),(3860,1073,'1119.0001','IDR',1.00,0.00,275726400.00,0.00,275726400.00),(3861,1073,'1114.0001','IDR',1.00,334309800.00,0.00,334309800.00,0.00),(3862,1073,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3863,1073,'4110.0002','IDR',1.00,0.00,303918000.00,0.00,303918000.00),(3864,1073,'2115.0002','IDR',1.00,0.00,30391800.00,0.00,30391800.00),(3865,1074,'5110.0001','IDR',1.00,2557.50,0.00,2557.50,0.00),(3866,1074,'1119.0001','IDR',1.00,0.00,2557.50,0.00,2557.50),(3867,1074,'1114.0001','IDR',1.00,41412250.00,0.00,41412250.00,0.00),(3868,1074,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3869,1074,'4110.0002','IDR',1.00,0.00,37647500.00,0.00,37647500.00),(3870,1074,'2115.0002','IDR',1.00,0.00,3764750.00,0.00,3764750.00),(3871,1075,'5110.0001','IDR',1.00,17843760.00,0.00,17843760.00,0.00),(3872,1075,'1119.0001','IDR',1.00,0.00,17843760.00,0.00,17843760.00),(3873,1075,'1114.0001','IDR',1.00,41171130.00,0.00,41171130.00,0.00),(3874,1075,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3875,1075,'4110.0002','IDR',1.00,0.00,37428300.00,0.00,37428300.00),(3876,1075,'2115.0002','IDR',1.00,0.00,3742830.00,0.00,3742830.00),(3877,1076,'5110.0001','IDR',1.00,1457.50,0.00,1457.50,0.00),(3878,1076,'1119.0001','IDR',1.00,0.00,1457.50,0.00,1457.50),(3879,1076,'1114.0001','IDR',1.00,26114962.50,0.00,26114962.50,0.00),(3880,1076,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3881,1076,'4110.0002','IDR',1.00,0.00,23740875.00,0.00,23740875.00),(3882,1076,'2115.0002','IDR',1.00,0.00,2374087.50,0.00,2374087.50),(3883,1077,'5110.0001','IDR',1.00,30460500.00,0.00,30460500.00,0.00),(3884,1077,'1119.0001','IDR',1.00,0.00,30460500.00,0.00,30460500.00),(3885,1077,'1114.0001','IDR',1.00,42501195.00,0.00,42501195.00,0.00),(3886,1077,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3887,1077,'4110.0002','IDR',1.00,0.00,38637450.00,0.00,38637450.00),(3888,1077,'2115.0002','IDR',1.00,0.00,3863745.00,0.00,3863745.00),(3889,1078,'5110.0001','IDR',1.00,54133117.50,0.00,54133117.50,0.00),(3890,1078,'1119.0001','IDR',1.00,0.00,54133117.50,0.00,54133117.50),(3891,1078,'1114.0001','IDR',1.00,79410127.50,0.00,79410127.50,0.00),(3892,1078,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3893,1078,'4110.0002','IDR',1.00,0.00,72191025.00,0.00,72191025.00),(3894,1078,'2115.0002','IDR',1.00,0.00,7219102.50,0.00,7219102.50),(3895,1079,'5110.0001','IDR',1.00,196533000.00,0.00,196533000.00,0.00),(3896,1079,'1119.0001','IDR',1.00,0.00,196533000.00,0.00,196533000.00),(3897,1079,'1114.0001','IDR',1.00,252945000.00,0.00,252945000.00,0.00),(3898,1079,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3899,1079,'4110.0002','IDR',1.00,0.00,229950000.00,0.00,229950000.00),(3900,1079,'2115.0002','IDR',1.00,0.00,22995000.00,0.00,22995000.00),(3901,1080,'5110.0001','IDR',1.00,58500000.00,0.00,58500000.00,0.00),(3902,1080,'1119.0001','IDR',1.00,0.00,58500000.00,0.00,58500000.00),(3903,1080,'1114.0001','IDR',1.00,73669750.00,0.00,73669750.00,0.00),(3904,1080,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3905,1080,'4110.0002','IDR',1.00,0.00,66972500.00,0.00,66972500.00),(3906,1080,'2115.0002','IDR',1.00,0.00,6697250.00,0.00,6697250.00),(3907,1081,'5110.0001','IDR',1.00,23155.00,0.00,23155.00,0.00),(3908,1081,'1119.0001','IDR',1.00,0.00,23155.00,0.00,23155.00),(3909,1081,'1114.0001','IDR',1.00,324903700.00,0.00,324903700.00,0.00),(3910,1081,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3911,1081,'4110.0002','IDR',1.00,0.00,295367000.00,0.00,295367000.00),(3912,1081,'2115.0002','IDR',1.00,0.00,29536700.00,0.00,29536700.00),(3913,1082,'5110.0001','IDR',1.00,66285450.00,0.00,66285450.00,0.00),(3914,1082,'1119.0001','IDR',1.00,0.00,66285450.00,0.00,66285450.00),(3915,1082,'1114.0001','IDR',1.00,74219750.00,0.00,74219750.00,0.00),(3916,1082,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3917,1082,'4110.0002','IDR',1.00,0.00,67472500.00,0.00,67472500.00),(3918,1082,'2115.0002','IDR',1.00,0.00,6747250.00,0.00,6747250.00),(3919,1083,'5110.0001','IDR',1.00,116716250.00,0.00,116716250.00,0.00),(3920,1083,'1119.0001','IDR',1.00,0.00,116716250.00,0.00,116716250.00),(3921,1083,'1114.0001','IDR',1.00,146449875.00,0.00,146449875.00,0.00),(3922,1083,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3923,1083,'4110.0002','IDR',1.00,0.00,133136250.00,0.00,133136250.00),(3924,1083,'2115.0002','IDR',1.00,0.00,13313625.00,0.00,13313625.00),(3925,1084,'5110.0001','IDR',1.00,1375.00,0.00,1375.00,0.00),(3926,1084,'1119.0001','IDR',1.00,0.00,1375.00,0.00,1375.00),(3927,1084,'1114.0001','IDR',1.00,44119625.00,0.00,44119625.00,0.00),(3928,1084,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3929,1084,'4110.0002','IDR',1.00,0.00,40108750.00,0.00,40108750.00),(3930,1084,'2115.0002','IDR',1.00,0.00,4010875.00,0.00,4010875.00),(3931,1085,'5110.0001','IDR',1.00,7467350.00,0.00,7467350.00,0.00),(3932,1085,'1119.0001','IDR',1.00,0.00,7467350.00,0.00,7467350.00),(3933,1085,'1114.0001','IDR',1.00,9581000.00,0.00,9581000.00,0.00),(3934,1085,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3935,1085,'4110.0002','IDR',1.00,0.00,8710000.00,0.00,8710000.00),(3936,1085,'2115.0002','IDR',1.00,0.00,871000.00,0.00,871000.00),(3937,1086,'5110.0001','IDR',1.00,59479200.00,0.00,59479200.00,0.00),(3938,1086,'1119.0001','IDR',1.00,0.00,59479200.00,0.00,59479200.00),(3939,1086,'1114.0001','IDR',1.00,63483750.00,0.00,63483750.00,0.00),(3940,1086,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3941,1086,'4110.0002','IDR',1.00,0.00,57712500.00,0.00,57712500.00),(3942,1086,'2115.0002','IDR',1.00,0.00,5771250.00,0.00,5771250.00),(3943,1087,'5110.0001','IDR',1.00,47016585.00,0.00,47016585.00,0.00),(3944,1087,'1119.0001','IDR',1.00,0.00,47016585.00,0.00,47016585.00),(3945,1087,'1114.0001','IDR',1.00,65450000.00,0.00,65450000.00,0.00),(3946,1087,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3947,1087,'4110.0002','IDR',1.00,0.00,59500000.00,0.00,59500000.00),(3948,1087,'2115.0002','IDR',1.00,0.00,5950000.00,0.00,5950000.00),(3949,1088,'5110.0001','IDR',1.00,37174500.00,0.00,37174500.00,0.00),(3950,1088,'1119.0001','IDR',1.00,0.00,37174500.00,0.00,37174500.00),(3951,1088,'1114.0001','IDR',1.00,52910000.00,0.00,52910000.00,0.00),(3952,1088,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3953,1088,'4110.0002','IDR',1.00,0.00,48100000.00,0.00,48100000.00),(3954,1088,'2115.0002','IDR',1.00,0.00,4810000.00,0.00,4810000.00),(3955,1089,'5110.0001','IDR',1.00,59479200.00,0.00,59479200.00,0.00),(3956,1089,'1119.0001','IDR',1.00,0.00,59479200.00,0.00,59479200.00),(3957,1089,'1114.0001','IDR',1.00,63483750.00,0.00,63483750.00,0.00),(3958,1089,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3959,1089,'4110.0002','IDR',1.00,0.00,57712500.00,0.00,57712500.00),(3960,1089,'2115.0002','IDR',1.00,0.00,5771250.00,0.00,5771250.00),(3961,1090,'5110.0001','IDR',1.00,10966477.50,0.00,10966477.50,0.00),(3962,1090,'1119.0001','IDR',1.00,0.00,10966477.50,0.00,10966477.50),(3963,1090,'1114.0001','IDR',1.00,12787500.00,0.00,12787500.00,0.00),(3964,1090,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3965,1090,'4110.0002','IDR',1.00,0.00,11625000.00,0.00,11625000.00),(3966,1090,'2115.0002','IDR',1.00,0.00,1162500.00,0.00,1162500.00),(3967,1091,'5110.0001','IDR',1.00,13056225.00,0.00,13056225.00,0.00),(3968,1091,'1119.0001','IDR',1.00,0.00,13056225.00,0.00,13056225.00),(3969,1091,'1114.0001','IDR',1.00,18425000.00,0.00,18425000.00,0.00),(3970,1091,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3971,1091,'4110.0002','IDR',1.00,0.00,16750000.00,0.00,16750000.00),(3972,1091,'2115.0002','IDR',1.00,0.00,1675000.00,0.00,1675000.00),(3973,1092,'5110.0001','IDR',1.00,47016585.00,0.00,47016585.00,0.00),(3974,1092,'1119.0001','IDR',1.00,0.00,47016585.00,0.00,47016585.00),(3975,1092,'1114.0001','IDR',1.00,63250000.00,0.00,63250000.00,0.00),(3976,1092,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3977,1092,'4110.0002','IDR',1.00,0.00,57500000.00,0.00,57500000.00),(3978,1092,'2115.0002','IDR',1.00,0.00,5750000.00,0.00,5750000.00),(3979,1093,'5110.0001','IDR',1.00,6412975.00,0.00,6412975.00,0.00),(3980,1093,'1119.0001','IDR',1.00,0.00,6412975.00,0.00,6412975.00),(3981,1093,'1114.0001','IDR',1.00,9581000.00,0.00,9581000.00,0.00),(3982,1093,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3983,1093,'4110.0002','IDR',1.00,0.00,8710000.00,0.00,8710000.00),(3984,1093,'2115.0002','IDR',1.00,0.00,871000.00,0.00,871000.00),(3985,1094,'5110.0001','IDR',1.00,51022900.00,0.00,51022900.00,0.00),(3986,1094,'1119.0001','IDR',1.00,0.00,51022900.00,0.00,51022900.00),(3987,1094,'1114.0001','IDR',1.00,64968750.00,0.00,64968750.00,0.00),(3988,1094,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3989,1094,'4110.0002','IDR',1.00,0.00,59062500.00,0.00,59062500.00),(3990,1094,'2115.0002','IDR',1.00,0.00,5906250.00,0.00,5906250.00),(3991,1095,'5110.0001','IDR',1.00,41951700.00,0.00,41951700.00,0.00),(3992,1095,'1119.0001','IDR',1.00,0.00,41951700.00,0.00,41951700.00),(3993,1095,'1114.0001','IDR',1.00,63250000.00,0.00,63250000.00,0.00),(3994,1095,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(3995,1095,'4110.0002','IDR',1.00,0.00,57500000.00,0.00,57500000.00),(3996,1095,'2115.0002','IDR',1.00,0.00,5750000.00,0.00,5750000.00),(3997,1096,'5110.0001','IDR',1.00,88189200.00,0.00,88189200.00,0.00),(3998,1096,'1119.0001','IDR',1.00,0.00,88189200.00,0.00,88189200.00),(3999,1096,'1114.0001','IDR',1.00,113905440.00,0.00,113905440.00,0.00),(4000,1096,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4001,1096,'4110.0002','IDR',1.00,0.00,103550400.00,0.00,103550400.00),(4002,1096,'2115.0002','IDR',1.00,0.00,10355040.00,0.00,10355040.00),(4003,1097,'5110.0001','IDR',1.00,42351750.00,0.00,42351750.00,0.00),(4004,1097,'1119.0001','IDR',1.00,0.00,42351750.00,0.00,42351750.00),(4005,1097,'1114.0001','IDR',1.00,53242200.00,0.00,53242200.00,0.00),(4006,1097,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4007,1097,'4110.0002','IDR',1.00,0.00,48402000.00,0.00,48402000.00),(4008,1097,'2115.0002','IDR',1.00,0.00,4840200.00,0.00,4840200.00),(4009,1098,'5110.0001','IDR',1.00,21275705.00,0.00,21275705.00,0.00),(4010,1098,'1119.0001','IDR',1.00,0.00,21275705.00,0.00,21275705.00),(4011,1098,'1114.0001','IDR',1.00,26173125.00,0.00,26173125.00,0.00),(4012,1098,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4013,1098,'4110.0002','IDR',1.00,0.00,23793750.00,0.00,23793750.00),(4014,1098,'2115.0002','IDR',1.00,0.00,2379375.00,0.00,2379375.00),(4015,1099,'5110.0001','IDR',1.00,2915.00,0.00,2915.00,0.00),(4016,1099,'1119.0001','IDR',1.00,0.00,2915.00,0.00,2915.00),(4017,1099,'1114.0001','IDR',1.00,45795750.00,0.00,45795750.00,0.00),(4018,1099,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4019,1099,'4110.0002','IDR',1.00,0.00,41632500.00,0.00,41632500.00),(4020,1099,'2115.0002','IDR',1.00,0.00,4163250.00,0.00,4163250.00),(4021,1100,'5110.0001','IDR',1.00,2035.00,0.00,2035.00,0.00),(4022,1100,'1119.0001','IDR',1.00,0.00,2035.00,0.00,2035.00),(4023,1100,'1114.0001','IDR',1.00,32450000.00,0.00,32450000.00,0.00),(4024,1100,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4025,1100,'4110.0002','IDR',1.00,0.00,29500000.00,0.00,29500000.00),(4026,1100,'2115.0002','IDR',1.00,0.00,2950000.00,0.00,2950000.00),(4027,1101,'5110.0001','IDR',1.00,214936200.00,0.00,214936200.00,0.00),(4028,1101,'1119.0001','IDR',1.00,0.00,214936200.00,0.00,214936200.00),(4029,1101,'1114.0001','IDR',1.00,254984400.00,0.00,254984400.00,0.00),(4030,1101,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4031,1101,'4110.0002','IDR',1.00,0.00,231804000.00,0.00,231804000.00),(4032,1101,'2115.0002','IDR',1.00,0.00,23180400.00,0.00,23180400.00),(4033,1102,'5110.0001','IDR',1.00,29396400.00,0.00,29396400.00,0.00),(4034,1102,'1119.0001','IDR',1.00,0.00,29396400.00,0.00,29396400.00),(4035,1102,'1114.0001','IDR',1.00,37515500.00,0.00,37515500.00,0.00),(4036,1102,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4037,1102,'4110.0002','IDR',1.00,0.00,34105000.00,0.00,34105000.00),(4038,1102,'2115.0002','IDR',1.00,0.00,3410500.00,0.00,3410500.00),(4039,1103,'5110.0001','IDR',1.00,32940250.00,0.00,32940250.00,0.00),(4040,1103,'1119.0001','IDR',1.00,0.00,32940250.00,0.00,32940250.00),(4041,1103,'1114.0001','IDR',1.00,45540000.00,0.00,45540000.00,0.00),(4042,1103,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4043,1103,'4110.0002','IDR',1.00,0.00,41400000.00,0.00,41400000.00),(4044,1103,'2115.0002','IDR',1.00,0.00,4140000.00,0.00,4140000.00),(4045,1104,'5110.0001','IDR',1.00,6849496.50,0.00,6849496.50,0.00),(4046,1104,'1119.0001','IDR',1.00,0.00,6849496.50,0.00,6849496.50),(4047,1104,'1114.0001','IDR',1.00,9726750.00,0.00,9726750.00,0.00),(4048,1104,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4049,1104,'4110.0002','IDR',1.00,0.00,8842500.00,0.00,8842500.00),(4050,1104,'2115.0002','IDR',1.00,0.00,884250.00,0.00,884250.00),(4051,1105,'5110.0001','IDR',1.00,28455875.00,0.00,28455875.00,0.00),(4052,1105,'1119.0001','IDR',1.00,0.00,28455875.00,0.00,28455875.00),(4053,1105,'1114.0001','IDR',1.00,37515500.00,0.00,37515500.00,0.00),(4054,1105,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4055,1105,'4110.0002','IDR',1.00,0.00,34105000.00,0.00,34105000.00),(4056,1105,'2115.0002','IDR',1.00,0.00,3410500.00,0.00,3410500.00),(4057,1106,'5110.0001','IDR',1.00,114493050.00,0.00,114493050.00,0.00),(4058,1106,'1119.0001','IDR',1.00,0.00,114493050.00,0.00,114493050.00),(4059,1106,'1114.0001','IDR',1.00,136867500.00,0.00,136867500.00,0.00),(4060,1106,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4061,1106,'4110.0002','IDR',1.00,0.00,124425000.00,0.00,124425000.00),(4062,1106,'2115.0002','IDR',1.00,0.00,12442500.00,0.00,12442500.00),(4063,1107,'5110.0001','IDR',1.00,149396800.00,0.00,149396800.00,0.00),(4064,1107,'1119.0001','IDR',1.00,0.00,149396800.00,0.00,149396800.00),(4065,1107,'1114.0001','IDR',1.00,295680000.00,0.00,295680000.00,0.00),(4066,1107,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4067,1107,'4110.0002','IDR',1.00,0.00,268800000.00,0.00,268800000.00),(4068,1107,'2115.0002','IDR',1.00,0.00,26880000.00,0.00,26880000.00),(4069,1108,'1110.0001','IDR',1.00,10000000.00,0.00,10000000.00,0.00),(4070,1108,'9110.0001','IDR',1.00,0.00,10000000.00,0.00,10000000.00),(4071,1109,'1110.0001','IDR',1.00,5000000.00,0.00,5000000.00,0.00),(4072,1109,'9110.0001','IDR',1.00,0.00,5000000.00,0.00,5000000.00),(4073,1110,'1110.0001','IDR',1.00,5000000.00,0.00,5000000.00,0.00),(4074,1110,'9110.0001','IDR',1.00,0.00,5000000.00,0.00,5000000.00),(4075,1111,'1110.0001','IDR',1.00,5000000.00,0.00,5000000.00,0.00),(4076,1111,'9110.0001','IDR',1.00,0.00,5000000.00,0.00,5000000.00),(4077,1112,'1110.0001','IDR',1.00,5000000.00,0.00,5000000.00,0.00),(4078,1112,'9110.0001','IDR',1.00,0.00,5000000.00,0.00,5000000.00),(4079,1113,'1110.0001','IDR',1.00,0.00,600000.00,0.00,600000.00),(4080,1113,'6111.0002','IDR',1.00,600000.00,0.00,600000.00,0.00),(4081,1114,'1110.0001','IDR',1.00,0.00,4350000.00,0.00,4350000.00),(4082,1114,'6111.0022','IDR',1.00,4250000.00,0.00,4250000.00,0.00),(4083,1114,'6111.0027','IDR',1.00,100000.00,0.00,100000.00,0.00),(4085,1115,'1110.0001','IDR',1.00,0.00,2325000.00,0.00,2325000.00),(4086,1115,'6111.0020','IDR',1.00,2325000.00,0.00,2325000.00,0.00),(4087,1116,'1110.0001','IDR',1.00,0.00,100000.00,0.00,100000.00),(4088,1116,'6111.0017','IDR',1.00,100000.00,0.00,100000.00,0.00),(4089,1117,'1110.0001','IDR',1.00,0.00,1100000.00,0.00,1100000.00),(4090,1117,'6111.0008','IDR',1.00,275000.00,0.00,275000.00,0.00),(4091,1117,'2118.0003','IDR',1.00,825000.00,0.00,825000.00,0.00),(4093,1118,'1110.0001','IDR',1.00,0.00,66000.00,0.00,66000.00),(4094,1118,'6112.0005','IDR',1.00,60000.00,0.00,60000.00,0.00),(4095,1118,'1122.0007','IDR',1.00,6000.00,0.00,6000.00,0.00),(4097,1119,'1110.0001','IDR',1.00,0.00,621000.00,0.00,621000.00),(4098,1119,'6111.0009','IDR',1.00,621000.00,0.00,621000.00,0.00),(4099,1120,'1110.0001','IDR',1.00,0.00,1929600.00,0.00,1929600.00),(4100,1120,'6111.0004','IDR',1.00,1929571.00,0.00,1929571.00,0.00),(4101,1120,'6111.0027','IDR',1.00,29.00,0.00,29.00,0.00),(4103,1121,'1110.0001','IDR',1.00,0.00,420900.00,0.00,420900.00),(4104,1121,'6111.0005','IDR',1.00,420863.00,0.00,420863.00,0.00),(4105,1121,'6111.0027','IDR',1.00,37.00,0.00,37.00,0.00),(4107,1122,'1110.0001','IDR',1.00,0.00,652500.00,0.00,652500.00),(4108,1122,'6111.0002','IDR',1.00,645987.00,0.00,645987.00,0.00),(4109,1122,'6111.0027','IDR',1.00,53.00,0.00,53.00,0.00),(4110,1122,'1122.0007','IDR',1.00,6460.00,0.00,6460.00,0.00),(4111,1123,'1110.0001','IDR',1.00,0.00,1165000.00,0.00,1165000.00),(4112,1123,'6111.0022','IDR',1.00,920000.00,0.00,920000.00,0.00),(4113,1123,'6111.0020','IDR',1.00,245000.00,0.00,245000.00,0.00),(4115,1124,'1110.0001','IDR',1.00,0.00,2545500.00,0.00,2545500.00),(4116,1124,'5110.0007','IDR',1.00,608000.00,0.00,608000.00,0.00),(4117,1124,'6111.0010','IDR',1.00,45000.00,0.00,45000.00,0.00),(4118,1124,'6112.0012','IDR',1.00,15000.00,0.00,15000.00,0.00),(4119,1124,'6112.0008','IDR',1.00,100000.00,0.00,100000.00,0.00),(4120,1124,'1122.0007','IDR',1.00,885500.00,0.00,885500.00,0.00),(4121,1124,'1122.0004','IDR',1.00,872000.00,0.00,872000.00,0.00),(4122,1124,'6112.0006','IDR',1.00,20000.00,0.00,20000.00,0.00),(4123,1125,'1110.0001','IDR',1.00,0.00,124000.00,0.00,124000.00),(4124,1125,'6111.0023','IDR',1.00,124000.00,0.00,124000.00,0.00),(4125,1126,'1110.0001','IDR',1.00,0.00,195000.00,0.00,195000.00),(4126,1126,'6110.0005','IDR',1.00,145000.00,0.00,145000.00,0.00),(4127,1126,'6111.0027','IDR',1.00,50000.00,0.00,50000.00,0.00),(4129,1127,'1110.0001','IDR',1.00,0.00,600000.00,0.00,600000.00),(4130,1127,'6111.0002','IDR',1.00,600000.00,0.00,600000.00,0.00),(4131,1128,'1110.0001','IDR',1.00,0.00,200000.00,0.00,200000.00),(4132,1128,'6111.0021','IDR',1.00,200000.00,0.00,200000.00,0.00),(4133,1129,'1110.0001','IDR',1.00,0.00,325000.00,0.00,325000.00),(4134,1129,'6111.0008','IDR',1.00,325000.00,0.00,325000.00,0.00),(4135,1130,'1110.0001','IDR',1.00,0.00,1625000.00,0.00,1625000.00),(4136,1130,'6111.0020','IDR',1.00,1625000.00,0.00,1625000.00,0.00),(4137,1131,'1110.0001','IDR',1.00,0.00,605500.00,0.00,605500.00),(4138,1131,'6111.0020','IDR',1.00,605500.00,0.00,605500.00,0.00),(4139,1132,'1110.0001','IDR',1.00,0.00,125000.00,0.00,125000.00),(4140,1132,'6111.0023','IDR',1.00,125000.00,0.00,125000.00,0.00),(4141,1133,'1110.0001','IDR',1.00,0.00,1680000.00,0.00,1680000.00),(4142,1133,'6111.0020','IDR',1.00,1680000.00,0.00,1680000.00,0.00),(4143,1134,'1110.0001','IDR',1.00,0.00,1000000.00,0.00,1000000.00),(4144,1134,'6111.0018','IDR',1.00,1000000.00,0.00,1000000.00,0.00),(4145,1135,'1110.0001','IDR',1.00,0.00,600000.00,0.00,600000.00),(4146,1135,'6111.0002','IDR',1.00,600000.00,0.00,600000.00,0.00),(4147,1136,'1110.0001','IDR',1.00,0.00,40000.00,0.00,40000.00),(4148,1136,'6111.0023','IDR',1.00,40000.00,0.00,40000.00,0.00),(4149,1137,'1110.0001','IDR',1.00,0.00,2370000.00,0.00,2370000.00),(4150,1137,'6111.0009','IDR',1.00,2370000.00,0.00,2370000.00,0.00),(4151,1138,'1110.0001','IDR',1.00,0.00,1708000.00,0.00,1708000.00),(4152,1138,'6110.0011','IDR',1.00,1708000.00,0.00,1708000.00,0.00),(4153,1139,'1110.0001','IDR',1.00,0.00,48000.00,0.00,48000.00),(4154,1139,'6111.0023','IDR',1.00,48000.00,0.00,48000.00,0.00),(4155,1140,'1110.0001','IDR',1.00,0.00,1223900.00,0.00,1223900.00),(4156,1140,'6111.0030','IDR',1.00,1223898.00,0.00,1223898.00,0.00),(4157,1140,'6111.0027','IDR',1.00,2.00,0.00,2.00,0.00),(4159,1141,'1110.0001','IDR',1.00,0.00,1827000.00,0.00,1827000.00),(4160,1141,'6112.0011','IDR',1.00,1600000.00,0.00,1600000.00,0.00),(4161,1141,'6112.0001','IDR',1.00,227000.00,0.00,227000.00,0.00),(4163,1142,'1110.0001','IDR',1.00,0.00,2000000.00,0.00,2000000.00),(4164,1142,'6111.0018','IDR',1.00,2000000.00,0.00,2000000.00,0.00),(4165,1143,'1110.0001','IDR',1.00,0.00,1330000.00,0.00,1330000.00),(4166,1143,'6110.0003','IDR',1.00,1330000.00,0.00,1330000.00,0.00),(4167,1144,'1110.0001','IDR',1.00,0.00,910000.00,0.00,910000.00),(4168,1144,'6111.0026','IDR',1.00,910000.00,0.00,910000.00,0.00),(4169,1145,'1110.0001','IDR',1.00,0.00,1450000.00,0.00,1450000.00),(4170,1145,'6112.0008','IDR',1.00,1450000.00,0.00,1450000.00,0.00),(4171,1146,'1110.0001','IDR',1.00,0.00,120000.00,0.00,120000.00),(4172,1146,'6111.0002','IDR',1.00,120000.00,0.00,120000.00,0.00),(4173,1147,'1110.0001','IDR',1.00,0.00,2433000.00,0.00,2433000.00),(4174,1147,'6111.0024','IDR',1.00,544000.00,0.00,544000.00,0.00),(4175,1147,'6111.0007','IDR',1.00,1639000.00,0.00,1639000.00,0.00),(4176,1147,'6112.0001','IDR',1.00,110000.00,0.00,110000.00,0.00),(4177,1147,'6111.0021','IDR',1.00,140000.00,0.00,140000.00,0.00),(4181,1148,'1110.0001','IDR',1.00,0.00,410000.00,0.00,410000.00),(4182,1148,'6111.0007','IDR',1.00,95000.00,0.00,95000.00,0.00),(4183,1148,'6111.0023','IDR',1.00,315000.00,0.00,315000.00,0.00),(4185,1149,'1110.0001','IDR',1.00,0.00,187000.00,0.00,187000.00),(4186,1149,'6111.0007','IDR',1.00,187000.00,0.00,187000.00,0.00),(4187,1150,'1110.0001','IDR',1.00,0.00,108500.00,0.00,108500.00),(4188,1150,'6111.0007','IDR',1.00,108500.00,0.00,108500.00,0.00),(4189,1151,'1110.0001','IDR',1.00,0.00,195000.00,0.00,195000.00),(4190,1151,'6111.0007','IDR',1.00,195000.00,0.00,195000.00,0.00),(4191,1152,'1110.0001','IDR',1.00,0.00,2322000.00,0.00,2322000.00),(4192,1152,'6111.0007','IDR',1.00,2322000.00,0.00,2322000.00,0.00),(4193,1153,'1110.0001','IDR',1.00,0.00,860200.00,0.00,860200.00),(4194,1153,'6111.0023','IDR',1.00,860200.00,0.00,860200.00,0.00),(4195,1154,'1110.0001','IDR',1.00,0.00,1319500.00,0.00,1319500.00),(4196,1154,'6112.0011','IDR',1.00,1319500.00,0.00,1319500.00,0.00),(4197,1155,'1119.0001','USD',13318.00,63000.00,0.00,839034000.00,0.00),(4198,1155,'2111.0001','USD',13318.00,0.00,63000.00,0.00,839034000.00),(4199,1156,'1119.0001','USD',13318.00,63000.00,0.00,839034000.00,0.00),(4200,1156,'2111.0001','USD',13318.00,0.00,63000.00,0.00,839034000.00),(4201,1157,'1119.0003','USD',13577.00,41400.00,0.00,562087800.00,0.00),(4202,1157,'2111.0001','USD',13577.00,0.00,20400.00,0.00,276970800.00),(4203,1157,'7110.0008','IDR',1.00,0.00,285117000.00,0.00,285117000.00),(4204,1158,'1119.0003','USD',13577.00,41400.00,0.00,562087800.00,0.00),(4205,1158,'2111.0001','USD',13577.00,0.00,20400.00,0.00,276970800.00),(4206,1158,'7110.0008','IDR',1.00,0.00,285117000.00,0.00,285117000.00),(4207,1159,'1119.0001','USD',13577.00,3100.00,0.00,42088700.00,0.00),(4208,1159,'2111.0001','USD',13577.00,0.00,3100.00,0.00,42088700.00),(4209,1160,'1119.0003','USD',13577.00,6900.00,0.00,93681300.00,0.00),(4210,1160,'2111.0001','USD',13577.00,0.00,6900.00,0.00,93681300.00),(4211,1161,'1119.0001','USD',13577.00,3975.00,0.00,53968575.00,0.00),(4212,1161,'2111.0001','USD',13577.00,0.00,3975.00,0.00,53968575.00),(4213,1162,'1119.0001','USD',13577.00,1850.00,0.00,25117450.00,0.00),(4214,1162,'2111.0001','USD',13577.00,0.00,1850.00,0.00,25117450.00),(4215,1163,'1119.0001','USD',13544.00,1250.00,0.00,16930000.00,0.00),(4216,1163,'2111.0001','USD',13544.00,0.00,1250.00,0.00,16930000.00),(4217,1164,'1119.0001','USD',13544.00,950.00,0.00,12866800.00,0.00),(4218,1164,'2111.0001','USD',13544.00,0.00,950.00,0.00,12866800.00),(4219,1165,'1119.0001','USD',13544.00,12740.00,0.00,172550560.00,0.00),(4220,1165,'2111.0001','USD',13544.00,0.00,12740.00,0.00,172550560.00),(4221,1166,'1119.0001','USD',13544.00,12740.00,0.00,172550560.00,0.00),(4222,1166,'2111.0001','USD',13544.00,0.00,12740.00,0.00,172550560.00),(4223,1167,'1119.0001','USD',13544.00,12740.00,0.00,172550560.00,0.00),(4224,1167,'2111.0001','USD',13544.00,0.00,12740.00,0.00,172550560.00),(4225,1168,'1119.0001','USD',13544.00,1025.00,0.00,13882600.00,0.00),(4226,1168,'2111.0001','USD',13544.00,0.00,1025.00,0.00,13882600.00),(4227,1169,'1119.0001','USD',13544.00,1375.00,0.00,18623000.00,0.00),(4228,1169,'2111.0001','USD',13544.00,0.00,1375.00,0.00,18623000.00),(4229,1170,'1119.0003','USD',13577.00,900.00,0.00,12219300.00,0.00),(4230,1170,'2111.0001','USD',13577.00,0.00,900.00,0.00,12219300.00),(4231,1171,'1119.0001','USD',0.00,1850.00,0.00,0.00,0.00),(4232,1171,'2111.0001','USD',0.00,0.00,1850.00,0.00,0.00),(4233,1172,'1119.0001','USD',13544.00,1200.00,0.00,16252800.00,0.00),(4234,1172,'2111.0001','USD',13544.00,0.00,1200.00,0.00,16252800.00),(4235,1173,'1119.0001','USD',13000.00,4500.00,0.00,58500000.00,0.00),(4236,1173,'2111.0001','USD',13000.00,0.00,4500.00,0.00,58500000.00),(4237,1174,'1119.0001','USD',13577.00,550.00,0.00,7467350.00,0.00),(4238,1174,'2111.0001','USD',13577.00,0.00,550.00,0.00,7467350.00),(4239,1175,'1119.0001','USD',13538.00,28400.00,0.00,384479200.00,0.00),(4240,1175,'2111.0001','USD',13538.00,0.00,28400.00,0.00,384479200.00),(4241,1176,'1119.0001','USD',13538.00,3000.00,0.00,40614000.00,0.00),(4242,1176,'2111.0001','USD',13538.00,0.00,3000.00,0.00,40614000.00),(4243,1177,'1119.0001','USD',13544.00,6300.00,0.00,85327200.00,0.00),(4244,1177,'2111.0001','USD',13544.00,0.00,6300.00,0.00,85327200.00),(4245,1178,'1119.0001','USD',13544.00,1350.00,0.00,18284400.00,0.00),(4246,1178,'2111.0001','USD',13544.00,0.00,1350.00,0.00,18284400.00),(4247,1179,'1119.0001','USD',13538.00,2250.00,0.00,30460500.00,0.00),(4248,1179,'2111.0001','USD',13538.00,0.00,2250.00,0.00,30460500.00),(4249,1180,'1119.0001','USD',13516.00,10625.00,0.00,143607500.00,0.00),(4250,1180,'2111.0001','USD',13516.00,0.00,10625.00,0.00,143607500.00),(4251,1181,'1119.0001','USD',13516.00,1650.00,0.00,22301400.00,0.00),(4252,1181,'2111.0001','USD',13516.00,0.00,825.00,0.00,11150700.00),(4253,1181,'7110.0008','IDR',1.00,0.00,11150700.00,0.00,11150700.00),(4254,1182,'1119.0001','USD',13518.00,737.50,0.00,9969525.00,0.00),(4255,1182,'2111.0001','USD',13518.00,0.00,737.50,0.00,9969525.00),(4256,1183,'1119.0001','USD',13518.00,6300.00,0.00,85163400.00,0.00),(4257,1183,'2111.0001','USD',13518.00,0.00,6300.00,0.00,85163400.00),(4258,1184,'1119.0001','USD',13518.00,2500.00,0.00,33795000.00,0.00),(4259,1184,'2111.0001','USD',13518.00,0.00,2500.00,0.00,33795000.00),(4260,1185,'1119.0001','USD',13518.00,8000.00,0.00,108144000.00,0.00),(4261,1185,'2111.0001','USD',13518.00,0.00,8000.00,0.00,108144000.00),(4262,1186,'1119.0001','USD',13518.00,1200.00,0.00,16221600.00,0.00),(4263,1186,'2111.0001','USD',13518.00,0.00,1200.00,0.00,16221600.00),(4264,1187,'1119.0001','USD',13569.00,63000.00,0.00,854847000.00,0.00),(4265,1187,'2111.0001','USD',13569.00,0.00,63000.00,0.00,854847000.00),(4266,1188,'1119.0003','USD',13569.00,14400.00,0.00,195393600.00,0.00),(4267,1188,'2111.0001','USD',13569.00,0.00,14400.00,0.00,195393600.00),(4268,1189,'1119.0001','USD',13516.00,3825.00,0.00,51698700.00,0.00),(4269,1189,'2111.0001','USD',13516.00,0.00,3825.00,0.00,51698700.00),(4270,1190,'1119.0001','USD',13516.00,850.00,0.00,11488600.00,0.00),(4271,1190,'2111.0001','USD',13516.00,0.00,850.00,0.00,11488600.00),(4272,1191,'1119.0001','USD',13516.00,20400.00,0.00,275726400.00,0.00),(4273,1191,'2111.0001','USD',13516.00,0.00,20400.00,0.00,275726400.00),(4274,1192,'1119.0001','USD',13518.00,15900.00,0.00,214936200.00,0.00),(4275,1192,'2111.0001','USD',13518.00,0.00,15900.00,0.00,214936200.00),(4276,1193,'1119.0001','USD',13516.00,3775.00,0.00,51022900.00,0.00),(4277,1193,'2111.0001','USD',13516.00,0.00,3775.00,0.00,51022900.00),(4278,1194,'1119.0001','USD',13554.00,12500.00,0.00,169425000.00,0.00),(4279,1194,'2111.0001','USD',13554.00,0.00,12500.00,0.00,169425000.00),(4280,1195,'1119.0001','USD',13554.00,14500.00,0.00,196533000.00,0.00),(4281,1195,'2111.0001','USD',13554.00,0.00,14500.00,0.00,196533000.00),(4282,1196,'1119.0001','USD',13445.00,2450.00,0.00,32940250.00,0.00),(4283,1196,'2111.0001','USD',13445.00,0.00,2450.00,0.00,32940250.00),(4284,1197,'1119.0001','USD',13445.00,7875.00,0.00,105879375.00,0.00),(4285,1197,'2111.0001','USD',13445.00,0.00,7875.00,0.00,105879375.00),(4286,1198,'1119.0001','USD',13445.00,3150.00,0.00,42351750.00,0.00),(4287,1198,'2111.0001','USD',13445.00,0.00,3150.00,0.00,42351750.00),(4288,1199,'1119.0001','USD',13445.00,600.00,0.00,8067000.00,0.00),(4289,1199,'2111.0001','USD',13445.00,0.00,800.00,0.00,10756000.00),(4290,1199,'7110.0008','IDR',1.00,2689000.00,0.00,2689000.00,0.00),(4291,1200,'1119.0001','USD',13445.00,3800.00,0.00,51091000.00,0.00),(4292,1200,'2111.0001','USD',13445.00,0.00,3800.00,0.00,51091000.00),(4293,1201,'1119.0001','USD',13445.00,3800.00,0.00,51091000.00,0.00),(4294,1201,'2111.0001','USD',13445.00,0.00,3800.00,0.00,51091000.00),(4295,1202,'1119.0001','USD',13391.00,465.00,0.00,6226815.00,0.00),(4296,1202,'2111.0001','USD',13391.00,0.00,465.00,0.00,6226815.00),(4297,1203,'1119.0003','USD',13391.00,4737.50,0.00,63439862.50,0.00),(4298,1203,'2111.0001','USD',13391.00,0.00,4737.50,0.00,63439862.50),(4299,1204,'1119.0001','USD',13391.00,22800.00,0.00,305314800.00,0.00),(4300,1204,'2111.0001','USD',13391.00,0.00,45600.00,0.00,610629600.00),(4301,1204,'7110.0008','IDR',1.00,305314800.00,0.00,305314800.00,0.00),(4302,1205,'1119.0001','USD',13391.00,22800.00,0.00,305314800.00,0.00),(4303,1205,'2111.0001','USD',13391.00,0.00,45600.00,0.00,610629600.00),(4304,1205,'7110.0008','IDR',1.00,305314800.00,0.00,305314800.00,0.00),(4305,1206,'1119.0001','USD',13391.00,2125.00,0.00,28455875.00,0.00),(4306,1206,'2111.0001','USD',13391.00,0.00,2125.00,0.00,28455875.00),(4307,1207,'1119.0001','USD',13391.00,4250.00,0.00,56911750.00,0.00),(4308,1207,'2111.0001','USD',13391.00,0.00,4250.00,0.00,56911750.00),(4309,1208,'1119.0001','USD',13391.00,7150.00,0.00,95745650.00,0.00),(4310,1208,'2111.0001','USD',13391.00,0.00,7150.00,0.00,95745650.00),(4311,1209,'1119.0001','USD',13391.00,7150.00,0.00,95745650.00,0.00),(4312,1209,'2111.0001','USD',13391.00,0.00,7150.00,0.00,95745650.00),(4313,1210,'1119.0001','USD',13391.00,1300.00,0.00,17408300.00,0.00),(4314,1210,'2111.0001','USD',13391.00,0.00,1300.00,0.00,17408300.00),(4315,1211,'1119.0001','USD',13391.00,4500.00,0.00,60259500.00,0.00),(4316,1211,'2111.0001','USD',13391.00,0.00,4500.00,0.00,60259500.00),(4317,1212,'1119.0001','USD',13391.00,975.00,0.00,13056225.00,0.00),(4318,1212,'2111.0001','USD',13391.00,0.00,975.00,0.00,13056225.00),(4319,1213,'1119.0001','USD',13391.00,2400.00,0.00,32138400.00,0.00),(4320,1213,'2111.0001','USD',13391.00,0.00,2400.00,0.00,32138400.00),(4321,1214,'1119.0001','USD',13391.00,3675.00,0.00,49211925.00,0.00),(4322,1214,'2111.0001','USD',13391.00,0.00,3675.00,0.00,49211925.00),(4323,1215,'1119.0001','USD',13339.00,1740.00,0.00,23209860.00,0.00),(4324,1215,'2111.0001','USD',13339.00,0.00,1740.00,0.00,23209860.00),(4325,1216,'1119.0001','USD',13339.00,8750.00,0.00,116716250.00,0.00),(4326,1216,'2111.0001','USD',13339.00,0.00,8750.00,0.00,116716250.00),(4327,1217,'1119.0001','USD',13339.00,7000.00,0.00,93373000.00,0.00),(4328,1217,'2111.0001','USD',13339.00,0.00,7000.00,0.00,93373000.00),(4329,1218,'1119.0001','USD',13339.00,8750.00,0.00,116716250.00,0.00),(4330,1218,'2111.0001','USD',13339.00,0.00,8750.00,0.00,116716250.00),(4331,1219,'1119.0001','USD',13339.00,11800.00,0.00,157400200.00,0.00),(4332,1219,'2111.0001','USD',13339.00,0.00,11800.00,0.00,157400200.00),(4333,1220,'1119.0001','USD',13339.00,1525.00,0.00,20341975.00,0.00),(4334,1220,'2111.0001','USD',13339.00,0.00,1525.00,0.00,20341975.00),(4335,1221,'1119.0001','USD',13339.00,1450.00,0.00,19341550.00,0.00),(4336,1221,'2111.0001','USD',13339.00,0.00,1450.00,0.00,19341550.00),(4339,1223,'1119.0001','USD',13339.00,11200.00,0.00,149396800.00,0.00),(4340,1223,'2111.0001','USD',13339.00,0.00,11200.00,0.00,149396800.00),(4341,1224,'1119.0001','USD',13313.00,1000.00,0.00,13313000.00,0.00),(4342,1224,'2111.0001','USD',13313.00,0.00,1000.00,0.00,13313000.00),(4343,1225,'1119.0001','USD',13313.00,625.00,0.00,8320625.00,0.00),(4344,1225,'2111.0001','USD',13313.00,0.00,625.00,0.00,8320625.00),(4345,1226,'1119.0001','USD',13313.00,2125.00,0.00,28290125.00,0.00),(4346,1226,'2111.0001','USD',13313.00,0.00,2125.00,0.00,28290125.00),(4347,1227,'1119.0003','USD',13577.00,13800.00,0.00,187362600.00,0.00),(4348,1227,'2111.0001','USD',13577.00,0.00,13800.00,0.00,187362600.00),(4349,1228,'1119.0001','USD',13440.00,23975.00,0.00,322224000.00,0.00),(4350,1228,'2111.0001','USD',13440.00,0.00,47950.00,0.00,644448000.00),(4351,1228,'7110.0008','IDR',1.00,322224000.00,0.00,322224000.00,0.00),(4352,1229,'1119.0001','USD',13440.00,23975.00,0.00,322224000.00,0.00),(4353,1229,'2111.0001','USD',13440.00,0.00,47950.00,0.00,644448000.00),(4354,1229,'7110.0008','IDR',1.00,322224000.00,0.00,322224000.00,0.00),(4355,1230,'1119.0001','USD',13440.00,5925.00,0.00,79632000.00,0.00),(4356,1230,'2111.0001','USD',13440.00,0.00,5925.00,0.00,79632000.00),(4357,1231,'1119.0001','USD',13440.00,737.50,0.00,9912000.00,0.00),(4358,1231,'2111.0001','USD',13440.00,0.00,737.50,0.00,9912000.00),(4359,1232,'1119.0001','USD',13440.00,5500.00,0.00,73920000.00,0.00),(4360,1232,'2111.0001','USD',13440.00,0.00,5500.00,0.00,73920000.00),(4361,1233,'1119.0001','USD',13440.00,900.00,0.00,12096000.00,0.00),(4362,1233,'2111.0001','USD',13440.00,0.00,900.00,0.00,12096000.00),(4363,1234,'1119.0001','USD',13440.00,980.00,0.00,13171200.00,0.00),(4364,1234,'2111.0001','USD',13440.00,0.00,980.00,0.00,13171200.00),(4365,1235,'1119.0001','USD',13440.00,520.00,0.00,6988800.00,0.00),(4366,1235,'2111.0001','USD',13440.00,0.00,520.00,0.00,6988800.00),(4367,1236,'1119.0001','USD',13440.00,24300.00,0.00,326592000.00,0.00),(4368,1236,'2111.0001','USD',13440.00,0.00,24300.00,0.00,326592000.00),(4369,1237,'1119.0001','USD',13440.00,1250.00,0.00,16800000.00,0.00),(4370,1237,'2111.0001','USD',13440.00,0.00,1250.00,0.00,16800000.00),(4371,1238,'1119.0001','USD',13592.00,875.00,0.00,11893000.00,0.00),(4372,1238,'2111.0001','USD',13592.00,0.00,875.00,0.00,11893000.00),(4373,1239,'1119.0001','USD',13581.00,1150.00,0.00,15618150.00,0.00),(4374,1239,'2111.0001','USD',13581.00,0.00,1150.00,0.00,15618150.00),(4375,1240,'1119.0001','USD',13592.00,937.50,0.00,12742500.00,0.00),(4376,1240,'2111.0001','USD',13592.00,0.00,937.50,0.00,12742500.00),(4377,1241,'1119.0001','USD',0.00,3000.00,0.00,0.00,0.00),(4378,1241,'2111.0001','USD',0.00,0.00,3000.00,0.00,0.00),(4379,1242,'1119.0001','USD',0.00,700.00,0.00,0.00,0.00),(4380,1242,'2111.0001','USD',0.00,0.00,700.00,0.00,0.00),(4381,1243,'1119.0001','USD',0.00,8625.00,0.00,0.00,0.00),(4382,1243,'2111.0001','USD',0.00,0.00,8625.00,0.00,0.00),(4383,1244,'1119.0001','EURO',0.00,5325.00,0.00,0.00,0.00),(4384,1244,'2111.0001','EURO',0.00,0.00,5325.00,0.00,0.00),(4385,1245,'1119.0001','USD',0.00,4250.00,0.00,0.00,0.00),(4386,1245,'2111.0001','USD',0.00,0.00,4250.00,0.00,0.00),(4387,1246,'1119.0001','USD',0.00,8925.00,0.00,0.00,0.00),(4388,1246,'2111.0001','USD',0.00,0.00,8925.00,0.00,0.00),(4389,1247,'1119.0001','USD',0.00,2585.00,0.00,0.00,0.00),(4390,1247,'2111.0001','USD',0.00,0.00,2585.00,0.00,0.00),(4391,1248,'1119.0001','USD',0.00,975.00,0.00,0.00,0.00),(4392,1248,'2111.0001','USD',0.00,0.00,975.00,0.00,0.00),(4393,1249,'1119.0001','IDR',0.00,68441050.00,0.00,0.00,0.00),(4394,1249,'2111.0001','IDR',0.00,0.00,68441050.00,0.00,0.00),(4395,1250,'1119.0001','USD',0.00,6370.00,0.00,0.00,0.00),(4396,1250,'2111.0001','USD',0.00,0.00,6370.00,0.00,0.00),(4397,1251,'1119.0001','USD',0.00,22800.00,0.00,0.00,0.00),(4398,1251,'2111.0001','USD',0.00,0.00,45600.00,0.00,0.00),(4399,1252,'1119.0001','USD',0.00,3500.00,0.00,0.00,0.00),(4400,1252,'2111.0001','USD',0.00,0.00,3500.00,0.00,0.00),(4401,1253,'1119.0003','USD',1333900.00,5325.00,0.00,7103017500.00,0.00),(4402,1253,'2111.0001','USD',1333900.00,0.00,5325.00,0.00,7103017500.00),(4409,1255,'5110.0001','IDR',1.00,51524715.00,0.00,51524715.00,0.00),(4410,1255,'1119.0003','IDR',1.00,0.00,51524715.00,0.00,51524715.00),(4411,1255,'1114.0001','IDR',1.00,104651250.00,0.00,104651250.00,0.00),(4412,1255,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4413,1255,'4110.0002','IDR',1.00,0.00,95137500.00,0.00,95137500.00),(4414,1255,'2115.0002','IDR',1.00,0.00,9513750.00,0.00,9513750.00),(4415,1256,'5110.0001','IDR',1.00,38164350.00,0.00,38164350.00,0.00),(4416,1256,'1119.0001','IDR',1.00,0.00,38164350.00,0.00,38164350.00),(4417,1256,'1114.0001','IDR',1.00,136867500.00,0.00,136867500.00,0.00),(4418,1256,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4419,1256,'4110.0002','IDR',1.00,0.00,124425000.00,0.00,124425000.00),(4420,1256,'2115.0002','IDR',1.00,0.00,12442500.00,0.00,12442500.00),(4421,1257,'5110.0001','IDR',1.00,17408300.00,0.00,17408300.00,0.00),(4422,1257,'1119.0001','IDR',1.00,0.00,17408300.00,0.00,17408300.00),(4423,1257,'1114.0001','IDR',1.00,38209985.00,0.00,38209985.00,0.00),(4424,1257,'2119.0001','IDR',1.00,0.00,0.00,0.00,0.00),(4425,1257,'4110.0002','IDR',1.00,0.00,34736350.00,0.00,34736350.00),(4426,1257,'2115.0002','IDR',1.00,0.00,3473635.00,0.00,3473635.00);
/*!40000 ALTER TABLE `tr_journaldetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_journalhead`
--

DROP TABLE IF EXISTS `tr_journalhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_journalhead` (
  `journalHeadID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Journal Head ID',
  `journalDate` datetime NOT NULL COMMENT 'Journal Date',
  `transactionType` varchar(100) NOT NULL COMMENT 'Transaction Type',
  `refNum` varchar(50) NOT NULL COMMENT 'Reference Number',
  `notes` varchar(200) DEFAULT NULL COMMENT 'Notes',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`journalHeadID`)
) ENGINE=InnoDB AUTO_INCREMENT=1258 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_journalhead`
--

LOCK TABLES `tr_journalhead` WRITE;
/*!40000 ALTER TABLE `tr_journalhead` DISABLE KEYS */;
INSERT INTO `tr_journalhead` VALUES (933,'2017-11-17 17:59:00','Import Duty','QJA/GR/17/II/048',NULL,'admin','2018-04-03 14:40:20','admin','2018-04-03 14:40:20'),(934,'2017-05-13 06:30:00','Import Duty','QJA/GR/17/V/046',NULL,'admin','2018-04-03 14:40:20','admin','2018-04-03 14:40:20'),(935,'2017-11-07 06:30:00','Import Duty','QJA/GR/17/XI/011',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(936,'2017-11-07 06:30:00','Import Duty','QJA/GR/17/XI/012',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(937,'2017-11-07 06:30:00','Import Duty','QJA/GR/17/XI/013',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(938,'2017-11-07 10:57:00','Import Duty','QJA/GR/17/XI/014',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(939,'2017-11-08 14:05:00','Import Duty','QJA/GR/17/XI/015',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(940,'2017-11-09 16:23:00','Import Duty','QJA/GR/17/XI/016',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(941,'2017-11-09 16:26:00','Import Duty','QJA/GR/17/XI/017',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(942,'2017-11-10 14:51:00','Import Duty','QJA/GR/17/XI/018',NULL,'admin','2018-04-03 14:40:21','admin','2018-04-03 14:40:21'),(943,'2017-11-10 15:05:00','Import Duty','QJA/GR/17/XI/019',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(944,'2017-11-15 17:23:00','Import Duty','QJA/GR/17/XI/020',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(945,'2017-11-10 09:23:00','Import Duty','QJA/GR/17/XI/033',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(947,'2017-11-15 17:02:00','Import Duty','QJA/GR/17/XI/035',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(948,'2017-11-17 16:26:00','Import Duty','QJA/GR/17/XI/036',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(949,'2017-11-07 07:00:00','Import Duty','QJA/GR/17/XI/037',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(950,'2017-11-29 13:00:00','Import Duty','QJA/GR/17/XI/038',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(951,'2017-11-28 06:30:00','Import Duty','QJA/GR/17/XI/041',NULL,'admin','2018-04-03 14:40:22','admin','2018-04-03 14:40:22'),(952,'2017-11-15 07:00:00','Import Duty','QJA/GR/17/XI/043',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(953,'2017-11-15 06:30:00','Import Duty','QJA/GR/17/XI/047',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(954,'2017-11-24 06:30:00','Import Duty','QJA/GR/17/XI/048',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(955,'2017-12-02 09:00:00','Import Duty','QJA/GR/17/XII/002',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(956,'2017-12-07 06:30:00','Import Duty','QJA/GR/17/XII/003',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(957,'2017-12-08 06:30:00','Import Duty','QJA/GR/17/XII/004',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(958,'2017-12-09 09:30:00','Import Duty','QJA/GR/17/XII/005',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(959,'2017-12-09 09:30:00','Import Duty','QJA/GR/17/XII/006',NULL,'admin','2018-04-03 14:40:23','admin','2018-04-03 14:40:23'),(960,'2017-12-12 07:00:00','Import Duty','QJA/GR/17/XII/007',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(961,'2017-12-13 11:00:00','Import Duty','QJA/GR/17/XII/008',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(962,'2017-12-28 09:00:00','Import Duty','QJA/GR/17/XII/009',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(963,'2017-12-29 08:00:00','Import Duty','QJA/GR/17/XII/010',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(964,'2017-12-02 09:00:00','Import Duty','QJA/GR/17/XII/039',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(965,'2017-12-05 06:15:00','Import Duty','QJA/GR/17/XII/040',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(966,'2017-12-07 07:00:00','Import Duty','QJA/GR/17/XII/042',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(967,'2017-12-08 07:00:00','Import Duty','QJA/GR/17/XII/044',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(968,'2017-12-06 06:15:00','Import Duty','QJA/GR/17/XII/045',NULL,'admin','2018-04-03 14:40:24','admin','2018-04-03 14:40:24'),(970,'2018-01-10 07:00:00','Import Duty','QJA/GR/18/I/002',NULL,'admin','2018-04-03 14:40:25','admin','2018-04-03 14:40:25'),(971,'2018-01-11 06:45:00','Import Duty','QJA/GR/18/I/003',NULL,'admin','2018-04-03 14:40:25','admin','2018-04-03 14:40:25'),(972,'2018-01-11 06:45:00','Import Duty','QJA/GR/18/I/004',NULL,'admin','2018-04-03 14:40:25','admin','2018-04-03 14:40:25'),(973,'2018-01-13 16:00:00','Import Duty','QJA/GR/18/I/005',NULL,'admin','2018-04-03 14:40:25','admin','2018-04-03 14:40:25'),(974,'2018-01-15 10:30:00','Import Duty','QJA/GR/18/I/006',NULL,'admin','2018-04-03 14:40:25','admin','2018-04-03 14:40:25'),(975,'2018-01-16 07:00:00','Import Duty','QJA/GR/18/I/007',NULL,'admin','2018-04-03 14:40:25','admin','2018-04-03 14:40:25'),(976,'2018-01-18 07:00:00','Import Duty','QJA/GR/18/I/008',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(977,'2018-01-18 07:00:00','Import Duty','QJA/GR/18/I/009',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(978,'2018-01-19 07:00:00','Import Duty','QJA/GR/18/I/010',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(979,'2018-01-19 07:00:00','Import Duty','QJA/GR/18/I/011',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(980,'2018-01-19 07:00:00','Import Duty','QJA/GR/18/I/012',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(981,'2018-01-20 08:00:00','Import Duty','QJA/GR/18/I/013',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(982,'2018-01-20 08:00:00','Import Duty','QJA/GR/18/I/014',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(983,'2018-01-20 08:00:00','Import Duty','QJA/GR/18/I/015',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(984,'2018-01-22 06:30:00','Import Duty','QJA/GR/18/I/016',NULL,'admin','2018-04-03 14:40:26','admin','2018-04-03 14:40:26'),(985,'2018-01-22 06:30:00','Import Duty','QJA/GR/18/I/017',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(986,'2018-01-24 07:00:00','Import Duty','QJA/GR/18/I/018',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(987,'2018-01-25 06:30:00','Import Duty','QJA/GR/18/I/019',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(988,'2018-01-25 06:30:00','Import Duty','QJA/GR/18/I/020',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(989,'2018-01-26 07:00:00','Import Duty','QJA/GR/18/I/021',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(990,'2018-01-26 07:00:00','Import Duty','QJA/GR/18/I/022',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(991,'2018-01-27 08:00:00','Import Duty','QJA/GR/18/I/023',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(992,'2018-01-30 06:30:00','Import Duty','QJA/GR/18/I/024',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(993,'2018-01-30 06:30:00','Import Duty','QJA/GR/18/I/025',NULL,'admin','2018-04-03 14:40:27','admin','2018-04-03 14:40:27'),(994,'2018-01-30 06:30:00','Import Duty','QJA/GR/18/I/026',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(995,'2018-01-30 11:00:00','Import Duty','QJA/GR/18/I/027',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(996,'2018-02-01 07:00:00','Import Duty','QJA/GR/18/II/028',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(997,'2018-02-02 06:30:00','Import Duty','QJA/GR/18/II/029',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(998,'2018-02-06 06:30:00','Import Duty','QJA/GR/18/II/030',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(999,'2018-02-23 10:39:00','Import Duty','QJA/GR/18/II/031',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(1000,'2018-02-13 06:30:00','Import Duty','QJA/GR/18/II/032',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(1001,'2018-02-13 06:30:00','Import Duty','QJA/GR/18/II/033',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(1002,'2018-02-14 06:30:00','Import Duty','QJA/GR/18/II/034',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(1003,'2018-02-14 06:30:00','Import Duty','QJA/GR/18/II/035',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(1004,'2018-02-14 06:30:00','Import Duty','QJA/GR/18/II/036',NULL,'admin','2018-04-03 14:40:28','admin','2018-04-03 14:40:28'),(1005,'2018-02-14 06:30:00','Import Duty','QJA/GR/18/II/037',NULL,'admin','2018-04-03 14:40:29','admin','2018-04-03 14:40:29'),(1006,'2018-02-14 06:30:00','Import Duty','QJA/GR/18/II/038',NULL,'admin','2018-04-03 14:40:29','admin','2018-04-03 14:40:29'),(1007,'2018-02-16 09:00:00','Import Duty','QJA/GR/18/II/040',NULL,'admin','2018-04-03 14:40:29','admin','2018-04-03 14:40:29'),(1008,'2018-02-20 07:00:00','Import Duty','QJA/GR/18/II/041',NULL,'admin','2018-04-03 14:40:29','admin','2018-04-03 14:40:29'),(1009,'2018-02-21 07:00:00','Import Duty','QJA/GR/18/II/042',NULL,'admin','2018-04-03 14:40:29','admin','2018-04-03 14:40:29'),(1010,'2018-02-22 07:00:00','Import Duty','QJA/GR/18/II/043',NULL,'admin','2018-04-03 14:40:29','admin','2018-04-03 14:40:29'),(1011,'2018-02-22 15:00:00','Import Duty','QJA/GR/18/II/044',NULL,'admin','2018-04-03 14:40:29','admin','2018-04-03 14:40:29'),(1024,'2017-11-22 08:00:00','Sales Invoice','QJA/GD/17/XI/0318','','admin','2018-04-03 14:41:32','admin','2018-04-03 14:41:32'),(1025,'2017-11-22 08:00:00','Sales Invoice','QJA/GD/17/XI/0319','','admin','2018-04-03 14:41:32','admin','2018-04-03 14:41:32'),(1026,'2017-12-18 08:00:00','Sales Invoice','QJA/GD/17/XII/0337','','admin','2018-04-03 14:41:32','admin','2018-04-03 14:41:32'),(1027,'2017-12-18 08:00:00','Sales Invoice','QJA/GD/17/XII/0338','','admin','2018-04-03 14:41:32','admin','2018-04-03 14:41:32'),(1028,'2017-12-18 08:00:00','Sales Invoice','QJA/GD/17/XII/0339','','admin','2018-04-03 14:41:32','admin','2018-04-03 14:41:32'),(1029,'2017-11-10 08:00:00','Sales Invoice','QJA/GD/17/XI/0307','','admin','2018-04-03 14:41:33','admin','2018-04-03 14:41:33'),(1030,'2017-11-17 09:00:00','Sales Invoice','QJA/GD/17/XI/0312','','admin','2018-04-03 14:41:33','admin','2018-04-03 14:41:33'),(1031,'2017-12-13 08:00:00','Sales Invoice','QJA/GD/17/XII/0335','','admin','2018-04-03 14:41:33','admin','2018-04-03 14:41:33'),(1032,'2018-01-22 09:00:00','Sales Invoice','QJA/GD/18/I/0022','','admin','2018-04-03 14:41:33','admin','2018-04-03 14:41:33'),(1033,'2018-01-02 10:00:00','Sales Invoice','QJA/GD/18/I/0001','','admin','2018-04-03 14:41:33','admin','2018-04-03 14:41:33'),(1034,'2018-01-26 10:00:00','Sales Invoice','QJA/GD/18/I/0027','','admin','2018-04-03 14:41:33','admin','2018-04-03 14:41:33'),(1035,'2017-11-07 10:00:00','Sales Invoice','QJA/GD/17/XI/0299','','admin','2018-04-03 14:41:33','admin','2018-04-03 14:41:33'),(1036,'2017-11-15 13:00:00','Sales Invoice','QJA/GD/17/XI/0310','','admin','2018-04-03 14:41:34','admin','2018-04-03 14:41:34'),(1037,'2017-11-10 09:00:00','Sales Invoice','QJA/GD/17/XI/0305','','admin','2018-04-03 14:41:34','admin','2018-04-03 14:41:34'),(1038,'2017-11-17 09:00:00','Sales Invoice','QJA/GD/17/XI/0311','','admin','2018-04-03 14:41:34','admin','2018-04-03 14:41:34'),(1039,'2017-11-07 10:00:00','Sales Invoice','QJA/GD/17/XI/0296','','admin','2018-04-03 14:41:34','admin','2018-04-03 14:41:34'),(1040,'2017-11-07 10:00:00','Sales Invoice','QJA/GD/17/XI/0297','','admin','2018-04-03 14:41:34','admin','2018-04-03 14:41:34'),(1041,'2017-11-20 09:00:00','Sales Invoice','QJA/GD/17/XI/0313','','admin','2018-04-03 14:41:35','admin','2018-04-03 14:41:35'),(1042,'2017-12-14 09:00:00','Sales Invoice','QJA/GD/17/XII/0336','','admin','2018-04-03 14:41:35','admin','2018-04-03 14:41:35'),(1044,'2017-11-13 13:00:00','Sales Invoice','QJA/GD/17/XI/0308','','admin','2018-04-03 14:41:35','admin','2018-04-03 14:41:35'),(1045,'2017-11-06 09:00:00','Sales Invoice','QJA/GD/17/XI/0294','','admin','2018-04-03 14:41:35','admin','2018-04-03 14:41:35'),(1046,'2017-12-08 07:00:00','Sales Invoice','QJA/GD/17/XII/0330','','admin','2018-04-03 14:41:35','admin','2018-04-03 14:41:35'),(1047,'2018-01-04 09:00:00','Sales Invoice','QJA/GD/18/I/0006','','admin','2018-04-03 14:41:35','admin','2018-04-03 14:41:35'),(1048,'2017-11-07 10:00:00','Sales Invoice','QJA/GD/17/XI/0298','','admin','2018-04-03 14:41:35','admin','2018-04-03 14:41:35'),(1049,'2018-01-15 14:00:00','Sales Invoice','QJA/GD/18/I/0016','','admin','2018-04-03 14:41:36','admin','2018-04-03 14:41:36'),(1050,'2017-11-01 09:00:00','Sales Invoice','QJA/GD/17/XI/0293','','admin','2018-04-03 14:41:36','admin','2018-04-03 14:41:36'),(1051,'2017-11-06 09:00:00','Sales Invoice','QJA/GD/17/XI/0295','','admin','2018-04-03 14:41:36','admin','2018-04-03 14:41:36'),(1052,'2017-11-08 10:00:00','Sales Invoice','QJA/GD/17/XI/0302','','admin','2018-04-03 14:41:36','admin','2018-04-03 14:41:36'),(1053,'2017-11-10 10:00:00','Sales Invoice','QJA/GD/17/XI/0306','','admin','2018-04-03 14:41:36','admin','2018-04-03 14:41:36'),(1054,'2017-11-13 10:00:00','Sales Invoice','QJA/GD/17/XI/0309','','admin','2018-04-03 14:41:36','admin','2018-04-03 14:41:36'),(1055,'2017-11-20 10:00:00','Sales Invoice','QJA/GD/17/XI/0314','','admin','2018-04-03 14:41:37','admin','2018-04-03 14:41:37'),(1056,'2017-12-05 10:00:00','Sales Invoice','QJA/GD/17/XII/0326','','admin','2018-04-03 14:41:37','admin','2018-04-03 14:41:37'),(1057,'2018-01-02 10:00:00','Sales Invoice','QJA/GD/18/I/0002','','admin','2018-04-03 14:41:37','admin','2018-04-03 14:41:37'),(1058,'2018-01-04 10:00:00','Sales Invoice','QJA/GD/18/I/0007','','admin','2018-04-03 14:41:37','admin','2018-04-03 14:41:37'),(1059,'2018-01-08 10:00:00','Sales Invoice','QJA/GD/18/I/0009','','admin','2018-04-03 14:41:37','admin','2018-04-03 14:41:37'),(1060,'2018-01-09 10:00:00','Sales Invoice','QJA/GD/18/I/0010','','admin','2018-04-03 14:41:38','admin','2018-04-03 14:41:38'),(1061,'2018-01-22 10:00:00','Sales Invoice','QJA/GD/18/I/0023','','admin','2018-04-03 14:41:38','admin','2018-04-03 14:41:38'),(1062,'2017-11-30 09:00:00','Sales Invoice','QJA/GD/17/XI/0322','','admin','2018-04-03 14:41:38','admin','2018-04-03 14:41:38'),(1063,'2017-11-30 09:00:00','Sales Invoice','QJA/GD/17/XI/0323','','admin','2018-04-03 14:41:38','admin','2018-04-03 14:41:38'),(1064,'2017-12-04 09:00:00','Sales Invoice','QJA/GD/17/XII/0324','','admin','2018-04-03 14:41:38','admin','2018-04-03 14:41:38'),(1065,'2017-12-05 09:00:00','Sales Invoice','QJA/GD/17/XII/0327','','admin','2018-04-03 14:41:38','admin','2018-04-03 14:41:38'),(1066,'2017-12-19 09:00:00','Sales Invoice','QJA/GD/17/XII/0340','','admin','2018-04-03 14:41:39','admin','2018-04-03 14:41:39'),(1067,'2017-12-28 09:00:00','Sales Invoice','QJA/GD/17/XII/0344','','admin','2018-04-03 14:41:39','admin','2018-04-03 14:41:39'),(1068,'2017-11-20 09:00:00','Sales Invoice','QJA/GD/17/XI/0316','','admin','2018-04-03 14:41:39','admin','2018-04-03 14:41:39'),(1069,'2018-01-19 09:00:00','Sales Invoice','QJA/GD/18/I/0019','','admin','2018-04-03 14:41:39','admin','2018-04-03 14:41:39'),(1070,'2018-01-19 10:00:00','Sales Invoice','QJA/GD/18/I/0020','','admin','2018-04-03 14:41:39','admin','2018-04-03 14:41:39'),(1071,'2017-11-07 10:00:00','Sales Invoice','QJA/GD/17/XI/0301','','admin','2018-04-03 14:41:39','admin','2018-04-03 14:41:39'),(1072,'2017-12-06 10:00:00','Sales Invoice','QJA/GD/17/XII/0328','','admin','2018-04-03 14:41:39','admin','2018-04-03 14:41:39'),(1073,'2017-12-07 13:00:00','Sales Invoice','QJA/GD/17/XII/0329','','admin','2018-04-03 14:41:40','admin','2018-04-03 14:41:40'),(1074,'2017-12-19 13:00:00','Sales Invoice','QJA/GD/17/XII/0342','','admin','2018-04-03 14:41:40','admin','2018-04-03 14:41:40'),(1075,'2018-01-12 13:00:00','Sales Invoice','QJA/GD/18/I/0014','','admin','2018-04-03 14:41:40','admin','2018-04-03 14:41:40'),(1076,'2017-11-08 09:00:00','Sales Invoice','QJA/GD/17/XI/0303','','admin','2018-04-03 14:41:40','admin','2018-04-03 14:41:40'),(1077,'2017-12-19 10:00:00','Sales Invoice','QJA/GD/17/XII/0341','','admin','2018-04-03 14:41:40','admin','2018-04-03 14:41:40'),(1078,'2018-01-24 10:00:00','Sales Invoice','QJA/GD/18/I/0025','','admin','2018-04-03 14:41:40','admin','2018-04-03 14:41:40'),(1079,'2018-01-10 13:00:00','Sales Invoice','QJA/GD/18/I/0011','','admin','2018-04-03 14:41:40','admin','2018-04-03 14:41:40'),(1080,'2017-11-21 13:00:00','Sales Invoice','QJA/GD/17/XI/0317','','admin','2018-04-03 14:41:41','admin','2018-04-03 14:41:41'),(1081,'2017-12-19 13:00:00','Sales Invoice','QJA/GD/17/XII/0343','','admin','2018-04-03 14:41:41','admin','2018-04-03 14:41:41'),(1082,'2018-01-22 13:00:00','Sales Invoice','QJA/GD/18/I/0024','','admin','2018-04-03 14:41:41','admin','2018-04-03 14:41:41'),(1083,'2018-01-25 13:00:00','Sales Invoice','QJA/GD/18/I/0026','','admin','2018-04-03 14:41:41','admin','2018-04-03 14:41:41'),(1084,'2017-11-09 09:00:00','Sales Invoice','QJA/GD/17/XI/0304','','admin','2018-04-03 14:41:41','admin','2018-04-03 14:41:41'),(1085,'2017-11-24 13:00:00','Sales Invoice','QJA/GD/17/XI/0321','','admin','2018-04-03 14:41:41','admin','2018-04-03 14:41:41'),(1086,'2017-12-12 13:00:00','Sales Invoice','QJA/GD/17/XII/0334','','admin','2018-04-03 14:41:42','admin','2018-04-03 14:41:42'),(1087,'2018-01-02 13:00:00','Sales Invoice','QJA/GD/18/I/0003','','admin','2018-04-03 14:41:42','admin','2018-04-03 14:41:42'),(1088,'2018-01-03 13:00:00','Sales Invoice','QJA/GD/18/I/0004','','admin','2018-04-03 14:41:42','admin','2018-04-03 14:41:42'),(1089,'2018-01-04 13:00:00','Sales Invoice','QJA/GD/18/I/0008','','admin','2018-04-03 14:41:42','admin','2018-04-03 14:41:42'),(1090,'2018-01-10 13:00:00','Sales Invoice','QJA/GD/18/I/0012','','admin','2018-04-03 14:41:42','admin','2018-04-03 14:41:42'),(1091,'2018-01-30 13:00:00','Sales Invoice','QJA/GD/18/I/0030','','admin','2018-04-03 14:41:42','admin','2018-04-03 14:41:42'),(1092,'2018-01-30 13:00:00','Sales Invoice','QJA/GD/18/I/0031','','admin','2018-04-03 14:41:43','admin','2018-04-03 14:41:43'),(1093,'2017-11-24 13:00:00','Sales Invoice','QJA/GD/17/XI/0320','','admin','2018-04-03 14:41:43','admin','2018-04-03 14:41:43'),(1094,'2017-12-11 13:00:00','Sales Invoice','QJA/GD/17/XII/0332','','admin','2018-04-03 14:41:43','admin','2018-04-03 14:41:43'),(1095,'2017-12-11 13:00:00','Sales Invoice','QJA/GD/17/XII/0333','','admin','2018-04-03 14:41:43','admin','2018-04-03 14:41:43'),(1096,'2017-12-04 13:00:00','Sales Invoice','QJA/GD/17/XII/0325','','admin','2018-04-03 14:41:44','admin','2018-04-03 14:41:44'),(1097,'2018-01-15 13:00:00','Sales Invoice','QJA/GD/18/I/0015','','admin','2018-04-03 14:41:44','admin','2018-04-03 14:41:44'),(1098,'2018-01-30 13:00:00','Sales Invoice','QJA/GD/18/I/0032','','admin','2018-04-03 14:41:44','admin','2018-04-03 14:41:44'),(1099,'2017-11-07 10:00:00','Sales Invoice','QJA/GD/17/XI/0300','','admin','2018-04-03 14:41:45','admin','2018-04-03 14:41:45'),(1100,'2017-11-20 13:30:00','Sales Invoice','QJA/GD/17/XI/0315','','admin','2018-04-03 14:41:45','admin','2018-04-03 14:41:45'),(1101,'2017-12-08 13:00:00','Sales Invoice','QJA/GD/17/XII/0331','','admin','2018-04-03 14:41:45','admin','2018-04-03 14:41:45'),(1102,'2018-01-03 13:00:00','Sales Invoice','QJA/GD/18/I/0005','','admin','2018-04-03 14:41:45','admin','2018-04-03 14:41:45'),(1103,'2018-01-11 13:00:00','Sales Invoice','QJA/GD/18/I/0013','','admin','2018-04-03 14:41:45','admin','2018-04-03 14:41:45'),(1104,'2018-01-18 13:00:00','Sales Invoice','QJA/GD/18/I/0017','','admin','2018-04-03 14:41:46','admin','2018-04-03 14:41:46'),(1105,'2018-01-19 13:00:00','Sales Invoice','QJA/GD/18/I/0021','','admin','2018-04-03 14:41:46','admin','2018-04-03 14:41:46'),(1106,'2018-01-19 10:00:00','Sales Invoice','QJA/GD/18/I/0018','','admin','2018-04-03 14:41:46','admin','2018-04-03 14:41:46'),(1107,'2018-03-19 07:00:00','Sales Invoice','QJA/GD/18/III/0029','<p>- PO No. 450/PO-GP/BB/XII/17</p>\r\n','admin','2018-04-03 14:41:46','admin','2018-04-03 14:41:46'),(1108,'2018-01-10 00:00:00','Cash In','QJA/CI/18/I/001','kAS kECIL','maitri','2018-02-08 13:33:13','maitri','2018-02-08 15:53:08'),(1109,'2018-01-18 00:00:00','Cash In','QJA/CI/18/I/021','Kas Kecil','maitri','2018-02-09 09:33:27','maitri','2018-02-09 09:33:27'),(1110,'2018-01-24 00:00:00','Cash In','QJA/CI/18/I/024','Kas Kecil','maitri','2018-02-09 09:55:10','maitri','2018-02-09 09:55:10'),(1111,'2018-01-26 00:00:00','Cash In','QJA/CI/18/I/028','Kas Kecil','maitri','2018-02-09 10:06:25','maitri','2018-02-09 10:06:25'),(1112,'2018-01-30 00:00:00','Cash In','QJA/CI/18/I/034','Kas Kecil','maitri','2018-02-09 13:22:28','maitri','2018-02-09 13:22:28'),(1113,'2018-01-05 00:00:00','Cash Out','QJA/CO/18/I/002','Beli 100 Bh Materai @ 6.000,-','maitri','2018-02-08 14:42:20','maitri','2018-02-08 15:57:57'),(1114,'2018-01-05 00:00:00','Cash Out','QJA/CO/18/I/003','By. Instal Microsoft Laptop Bp Nurdin W','maitri','2018-02-08 14:46:38','maitri','2018-02-08 15:58:51'),(1115,'2018-01-08 00:00:00','Cash Out','QJA/CO/18/I/004','By Cetakan Surat Jalan\r\n5 Box @ Rp. 465.000,-','maitri','2018-02-08 14:51:08','maitri','2018-02-08 15:57:33'),(1116,'2018-01-09 00:00:00','Cash Out','QJA/CO/18/I/005','By Rekomendasi Apoteker - SAIBA','maitri','2018-02-08 14:57:24','maitri','2018-02-08 15:56:56'),(1117,'2018-01-10 00:00:00','Cash Out','QJA/CO/18/I/006','By Keamanan kantor periode Okt 17 - Jan 18','maitri','2018-02-08 15:00:49','maitri','2018-02-09 09:09:16'),(1118,'2018-01-10 00:00:00','Cash Out','QJA/CO/18/I/007','SAMPLE\r\n14 Gr MELOXICAM','maitri','2018-02-08 15:33:22','maitri','2018-02-09 09:01:43'),(1119,'2018-01-10 00:00:00','Cash Out','QJA/CO/18/I/008','By Perpanjangan STNK - FENDI','maitri','2018-02-08 15:41:02','maitri','2018-02-08 15:55:31'),(1120,'2018-01-10 00:00:00','Cash Out','QJA/CO/18/I/009','PLN & PAM Jan 18','maitri','2018-02-08 15:42:36','maitri','2018-02-08 15:55:58'),(1121,'2018-01-10 00:00:00','Cash Out','QJA/CO/18/I/010','By Telepon kantor Jan 18','maitri','2018-02-08 15:48:44','maitri','2018-02-08 15:56:25'),(1122,'2018-01-12 00:00:00','Cash Out','QJA/CO/18/I/011','By. Kirim Dokumen :\r\nACETO PTE\r\nCHENGDU YAZHONG','maitri','2018-02-08 15:51:31','maitri','2018-02-09 09:20:16'),(1123,'2018-01-12 00:00:00','Cash Out','QJA/CO/18/I/012','bY sERVICE pRINTER epson l565\r\nbELI tINTA pRINTER f73n','maitri','2018-02-08 16:02:43','maitri','2018-02-08 16:02:43'),(1124,'2018-01-15 00:00:00','Cash Out','QJA/CO/18/I/013','500 Mg DEXAMETHASONE SOD m-SULPHOBENZOATE','maitri','2018-02-08 16:10:48','maitri','2018-02-09 09:26:14'),(1125,'2018-01-15 00:00:00','Cash Out','QJA/CO/18/I/014','By Service Motor SUPRA X 125 D \r\nFENDI','maitri','2018-02-08 16:17:05','maitri','2018-02-09 09:22:28'),(1126,'2018-01-16 00:00:00','Cash Out','QJA/CO/18/I/015','By Pengobatan Karyawan\r\nMAITRI','maitri','2018-02-08 16:20:27','maitri','2018-02-08 16:20:27'),(1127,'2018-01-17 00:00:00','Cash Out','QJA/CO/18/I/016','Beli 100 Bh Materai @ 6.000,-','maitri','2018-02-08 16:24:16','maitri','2018-02-08 16:24:16'),(1128,'2018-01-17 00:00:00','Cash Out','QJA/CO/18/I/017','By. Pengecekan Listrik di Blok A14 No. 39','maitri','2018-02-08 16:26:42','maitri','2018-02-09 09:28:55'),(1129,'2018-01-18 00:00:00','Cash Out','QJA/CO/18/I/018','By Keamanan kantor A14/39','maitri','2018-02-08 16:28:50','maitri','2018-02-09 09:06:36'),(1130,'2018-01-18 00:00:00','Cash Out','QJA/CO/18/I/019','By Cetakan Kartu Nama  @ 125.000,-\r\n9 Box - Bp. NURDIN\r\n4 Box - SAIBA','maitri','2018-02-08 16:31:34','maitri','2018-02-09 09:30:22'),(1131,'2018-01-19 00:00:00','Cash Out','QJA/CO/18/I/020','ATK','maitri','2018-02-08 16:33:30','maitri','2018-02-09 09:04:50'),(1132,'2018-01-23 00:00:00','Cash Out','QJA/CO/18/I/023','By Ganti Pelampung BEAT\r\nMAITRI','maitri','2018-02-09 09:51:26','maitri','2018-02-09 09:51:26'),(1133,'2018-01-24 00:00:00','Cash Out','QJA/CO/18/I/025','By Cetak Kop Surat\r\n12 Rim @  Rp. 140.000,-','maitri','2018-02-09 09:58:36','maitri','2018-02-09 09:58:36'),(1134,'2018-01-24 00:00:00','Cash Out','QJA/CO/18/I/026','By Entertainment Petugas PTSP - Pengurusan SIPA Apoteker\r\n2 Orang @  Rp. 500.000,-','maitri','2018-02-09 10:01:35','maitri','2018-02-09 10:02:19'),(1135,'2018-01-25 00:00:00','Cash Out','QJA/CO/18/I/027','Beli 100 Bh Materai @ 6.000,-','maitri','2018-02-09 10:04:02','maitri','2018-02-09 10:10:24'),(1136,'2018-01-25 00:00:00','Cash Out','QJA/CO/18/I/029','By Ganti Ban Dalam Supra X 125 D \r\nFENDI','maitri','2018-02-09 10:12:38','maitri','2018-02-09 10:12:38'),(1137,'2018-01-26 00:00:00','Cash Out','QJA/CO/18/I/030','By Perpanjang STNK\r\nAVEGA GT','maitri','2018-02-09 10:16:20','maitri','2018-02-09 10:16:20'),(1138,'2018-01-28 00:00:00','Cash Out','QJA/CO/18/I/031','By Asuransi Karyawan\r\nBp. NURDIN  Rp. 900.000,-\r\nBp KHIONG  Rp. 118.000,-\r\nMAITRI  Rp. 150.000,-\r\nYUDI; TARMAN @ 90.000,-\r\nBUDI; FETI; FENDI; WAWAN','maitri','2018-02-09 13:02:04','maitri','2018-02-09 13:02:04'),(1139,'2018-01-26 00:00:00','Cash Out','QJA/CO/18/I/032','By Ganti Oli Motor VARIO\r\nBp. KHIONG','maitri','2018-02-09 13:15:50','maitri','2018-02-09 13:15:50'),(1140,'2018-01-29 00:00:00','Cash Out','QJA/CO/18/I/033','By Perjalanan Dinas Bp NURDIN W\r\nJkt - SG - Jkt  tanggal 23 Jan 18','maitri','2018-02-09 13:20:24','maitri','2018-02-09 13:20:24'),(1141,'2018-01-30 00:00:00','Cash Out','QJA/CO/18/I/035','By Kirim ke Customer \r\nGRACIA PHARMINDO - SUKABUMI\r\n2.240 Kg LACTULOSE LIQUID 70%','maitri','2018-02-09 13:27:52','maitri','2018-02-09 13:27:52'),(1142,'2018-01-30 00:00:00','Cash Out','QJA/CO/18/I/036','By Entertainment Customer - Bunga Papan Pernikahan\r\nINTERBAT','maitri','2018-02-09 13:31:37','maitri','2018-02-09 13:31:37'),(1143,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/037','Uang Muka Karyawan JAN 18\r\nNUROKHMAN','maitri','2018-02-09 13:35:34','maitri','2018-02-09 13:35:34'),(1144,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/038','PANALOG & DHL @ 5.000,-\r\nBy Transfer ke Principal  @ 50.000,- (Rincian Terlampir)','maitri','2018-02-09 14:09:52','maitri','2018-02-12 09:15:11'),(1145,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/039','By Ijin Impor BNI\r\n29 Lbr Ijin Impor @ 50.000,-','maitri','2018-02-12 11:07:49','maitri','2018-02-12 11:07:49'),(1146,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/041','SRI AMAN; HENSAN BERSAMA; ANINDOJAYA; SKJF; NUFARINDO; ERELA; BINA SAN; GRACIA PHARMINDO; CENDO PHARMA; MEPROFARM','maitri','2018-02-12 11:32:31','maitri','2018-02-12 11:32:31'),(1147,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/042','Rincian Terlampir','maitri','2018-02-12 11:55:23','maitri','2018-02-12 11:55:35'),(1148,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/043','Exp YUDI Jan 18','maitri','2018-02-12 13:06:50','maitri','2018-02-12 13:06:50'),(1149,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/044','Exp WAWAN Jan 18','maitri','2018-02-12 13:08:43','maitri','2018-02-12 13:08:43'),(1150,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/045','Exp BUDI Jan 18','maitri','2018-02-12 13:10:19','maitri','2018-02-12 13:10:19'),(1151,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/046','Exp FENDI Jan 18','maitri','2018-02-12 13:12:58','maitri','2018-02-12 13:12:58'),(1152,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/I/047','Exp Bp. NURDIN Jan 18','maitri','2018-02-12 13:14:42','maitri','2018-02-12 13:14:42'),(1153,'2018-01-23 00:00:00','Cash Out','QJA/CO/18/II/022','By Ganti Accu Toyota VIOS','maitri','2018-02-09 09:45:18','maitri','2018-02-09 09:56:13'),(1154,'2018-01-31 00:00:00','Cash Out','QJA/CO/18/II/040','ERELA (8); NUFARINDO;  CENDO (2); INTERBAT (4); SKJF (2); BSP; MEPROFARM (3); SANBE FARMA','maitri','2018-02-12 11:28:23','maitri','2018-02-12 11:28:48'),(1155,'2017-05-13 06:30:00','Goods Receipt','QJA/GR/17/V/046',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1156,'2017-05-13 06:30:00','Goods Receipt','QJA/GR/17/V/046',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1157,'2017-11-07 06:30:00','Goods Receipt','QJA/GR/17/XI/011',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1158,'2017-11-07 06:30:00','Goods Receipt','QJA/GR/17/XI/011',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1159,'2017-11-07 06:30:00','Goods Receipt','QJA/GR/17/XI/012',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1160,'2017-11-07 06:30:00','Goods Receipt','QJA/GR/17/XI/013',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1161,'2017-11-07 10:57:00','Goods Receipt','QJA/GR/17/XI/014',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1162,'2017-11-08 14:05:00','Goods Receipt','QJA/GR/17/XI/015',NULL,'admin','2018-04-03 14:42:29','admin','2018-04-03 14:42:29'),(1163,'2017-11-09 16:23:00','Goods Receipt','QJA/GR/17/XI/016',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1164,'2017-11-09 16:26:00','Goods Receipt','QJA/GR/17/XI/017',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1165,'2017-11-10 14:51:00','Goods Receipt','QJA/GR/17/XI/018',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1166,'2017-11-10 14:51:00','Goods Receipt','QJA/GR/17/XI/018',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1167,'2017-11-10 14:51:00','Goods Receipt','QJA/GR/17/XI/018',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1168,'2017-11-10 15:05:00','Goods Receipt','QJA/GR/17/XI/019',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1169,'2017-11-15 17:23:00','Goods Receipt','QJA/GR/17/XI/020',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1170,'2017-11-10 09:23:00','Goods Receipt','QJA/GR/17/XI/033',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1172,'2017-11-15 17:02:00','Goods Receipt','QJA/GR/17/XI/035',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1173,'2017-11-17 16:26:00','Goods Receipt','QJA/GR/17/XI/036',NULL,'admin','2018-04-03 14:42:30','admin','2018-04-03 14:42:30'),(1174,'2017-11-07 07:00:00','Goods Receipt','QJA/GR/17/XI/037',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1175,'2017-11-29 13:00:00','Goods Receipt','QJA/GR/17/XI/038',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1176,'2017-11-28 06:30:00','Goods Receipt','QJA/GR/17/XI/041',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1177,'2017-11-15 07:00:00','Goods Receipt','QJA/GR/17/XI/043',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1178,'2017-11-15 06:30:00','Goods Receipt','QJA/GR/17/XI/047',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1179,'2017-11-24 06:30:00','Goods Receipt','QJA/GR/17/XI/048',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1180,'2017-12-02 09:00:00','Goods Receipt','QJA/GR/17/XII/002',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1181,'2017-12-07 06:30:00','Goods Receipt','QJA/GR/17/XII/003',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1182,'2017-12-08 06:30:00','Goods Receipt','QJA/GR/17/XII/004',NULL,'admin','2018-04-03 14:42:31','admin','2018-04-03 14:42:31'),(1183,'2017-12-09 09:30:00','Goods Receipt','QJA/GR/17/XII/005',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1184,'2017-12-09 09:30:00','Goods Receipt','QJA/GR/17/XII/006',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1185,'2017-12-12 07:00:00','Goods Receipt','QJA/GR/17/XII/007',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1186,'2017-12-13 11:00:00','Goods Receipt','QJA/GR/17/XII/008',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1187,'2017-12-28 09:00:00','Goods Receipt','QJA/GR/17/XII/009',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1188,'2017-12-29 08:00:00','Goods Receipt','QJA/GR/17/XII/010',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1189,'2017-12-02 09:00:00','Goods Receipt','QJA/GR/17/XII/039',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1190,'2017-12-05 06:15:00','Goods Receipt','QJA/GR/17/XII/040',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1191,'2017-12-07 07:00:00','Goods Receipt','QJA/GR/17/XII/042',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1192,'2017-12-08 07:00:00','Goods Receipt','QJA/GR/17/XII/044',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1193,'2017-12-06 06:15:00','Goods Receipt','QJA/GR/17/XII/045',NULL,'admin','2018-04-03 14:42:32','admin','2018-04-03 14:42:32'),(1194,'2018-01-07 11:00:00','Goods Receipt','QJA/GR/18/I/001',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1195,'2018-01-10 07:00:00','Goods Receipt','QJA/GR/18/I/002',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1196,'2018-01-11 06:45:00','Goods Receipt','QJA/GR/18/I/003',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1197,'2018-01-11 06:45:00','Goods Receipt','QJA/GR/18/I/004',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1198,'2018-01-13 16:00:00','Goods Receipt','QJA/GR/18/I/005',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1199,'2018-01-15 10:30:00','Goods Receipt','QJA/GR/18/I/006',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1200,'2018-01-16 07:00:00','Goods Receipt','QJA/GR/18/I/007',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1201,'2018-01-16 07:00:00','Goods Receipt','QJA/GR/18/I/007',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1202,'2018-01-18 07:00:00','Goods Receipt','QJA/GR/18/I/008',NULL,'admin','2018-04-03 14:42:33','admin','2018-04-03 14:42:33'),(1203,'2018-01-18 07:00:00','Goods Receipt','QJA/GR/18/I/009',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1204,'2018-01-19 07:00:00','Goods Receipt','QJA/GR/18/I/010',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1205,'2018-01-19 07:00:00','Goods Receipt','QJA/GR/18/I/010',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1206,'2018-01-19 07:00:00','Goods Receipt','QJA/GR/18/I/011',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1207,'2018-01-19 07:00:00','Goods Receipt','QJA/GR/18/I/012',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1208,'2018-01-20 08:00:00','Goods Receipt','QJA/GR/18/I/013',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1209,'2018-01-20 08:00:00','Goods Receipt','QJA/GR/18/I/013',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1210,'2018-01-20 08:00:00','Goods Receipt','QJA/GR/18/I/014',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1211,'2018-01-20 08:00:00','Goods Receipt','QJA/GR/18/I/015',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1212,'2018-01-22 06:30:00','Goods Receipt','QJA/GR/18/I/016',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1213,'2018-01-22 06:30:00','Goods Receipt','QJA/GR/18/I/017',NULL,'admin','2018-04-03 14:42:34','admin','2018-04-03 14:42:34'),(1214,'2018-01-24 07:00:00','Goods Receipt','QJA/GR/18/I/018',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1215,'2018-01-25 06:30:00','Goods Receipt','QJA/GR/18/I/019',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1216,'2018-01-25 06:30:00','Goods Receipt','QJA/GR/18/I/020',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1217,'2018-01-26 07:00:00','Goods Receipt','QJA/GR/18/I/021',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1218,'2018-01-26 07:00:00','Goods Receipt','QJA/GR/18/I/022',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1219,'2018-01-27 08:00:00','Goods Receipt','QJA/GR/18/I/023',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1220,'2018-01-30 06:30:00','Goods Receipt','QJA/GR/18/I/024',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1221,'2018-01-30 06:30:00','Goods Receipt','QJA/GR/18/I/025',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1223,'2018-01-30 11:00:00','Goods Receipt','QJA/GR/18/I/027',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1224,'2018-02-01 07:00:00','Goods Receipt','QJA/GR/18/II/028',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1225,'2018-02-02 06:30:00','Goods Receipt','QJA/GR/18/II/029',NULL,'admin','2018-04-03 14:42:35','admin','2018-04-03 14:42:35'),(1226,'2018-02-06 06:30:00','Goods Receipt','QJA/GR/18/II/030',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1227,'2018-02-23 10:39:00','Goods Receipt','QJA/GR/18/II/031',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1228,'2018-02-13 06:30:00','Goods Receipt','QJA/GR/18/II/032',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1229,'2018-02-13 06:30:00','Goods Receipt','QJA/GR/18/II/032',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1230,'2018-02-13 06:30:00','Goods Receipt','QJA/GR/18/II/033',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1231,'2018-02-14 06:30:00','Goods Receipt','QJA/GR/18/II/034',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1232,'2018-02-14 06:30:00','Goods Receipt','QJA/GR/18/II/035',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1233,'2018-02-14 06:30:00','Goods Receipt','QJA/GR/18/II/036',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1234,'2018-02-14 06:30:00','Goods Receipt','QJA/GR/18/II/037',NULL,'admin','2018-04-03 14:42:36','admin','2018-04-03 14:42:36'),(1235,'2018-02-14 06:30:00','Goods Receipt','QJA/GR/18/II/038',NULL,'admin','2018-04-03 14:42:37','admin','2018-04-03 14:42:37'),(1236,'2018-02-16 09:00:00','Goods Receipt','QJA/GR/18/II/040',NULL,'admin','2018-04-03 14:42:37','admin','2018-04-03 14:42:37'),(1237,'2018-02-20 07:00:00','Goods Receipt','QJA/GR/18/II/041',NULL,'admin','2018-04-03 14:42:37','admin','2018-04-03 14:42:37'),(1238,'2018-02-21 07:00:00','Goods Receipt','QJA/GR/18/II/042',NULL,'admin','2018-04-03 14:42:37','admin','2018-04-03 14:42:37'),(1239,'2018-02-22 07:00:00','Goods Receipt','QJA/GR/18/II/043',NULL,'admin','2018-04-03 14:42:37','admin','2018-04-03 14:42:37'),(1240,'2018-02-22 15:00:00','Goods Receipt','QJA/GR/18/II/044',NULL,'admin','2018-04-03 14:42:37','admin','2018-04-03 14:42:37'),(1253,'2018-01-30 06:30:00','Goods Receipt','QJA/GR/18/I/026',NULL,'admin','2018-04-06 14:03:40','admin','2018-04-06 14:03:40'),(1255,'2018-02-01 09:00:00','Sales Invoice','QJA/GD/18/II/0033','','admin','2018-04-06 14:50:43','admin','2018-04-06 14:50:43'),(1256,'2018-02-01 15:28:00','Sales Invoice','QJA/GD/18/II/0034','<p>- PO No. PO175028</p>\r\n\r\n<p>&nbsp;</p>\r\n','admin','2018-04-06 15:22:33','admin','2018-04-06 15:22:33'),(1257,'2018-02-01 10:00:00','Sales Invoice','QJA/GD/18/II/0035','<p>PO No. BF.17.0917</p>\r\n','admin','2018-04-06 15:37:36','admin','2018-04-06 15:37:36');
/*!40000 ALTER TABLE `tr_journalhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_purchaseorderdetail`
--

DROP TABLE IF EXISTS `tr_purchaseorderdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_purchaseorderdetail` (
  `purchaseOrderDetailID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Purchase Order Detail ID',
  `purchaseOrderNum` varchar(50) NOT NULL COMMENT 'Purchase Order Num',
  `productID` int(11) NOT NULL COMMENT 'Product ID',
  `uomID` int(11) NOT NULL COMMENT 'UOM ID',
  `qty` decimal(18,0) NOT NULL COMMENT 'Quantity',
  `price` decimal(18,2) NOT NULL COMMENT 'Price',
  `discount` decimal(18,2) DEFAULT NULL COMMENT 'Discount',
  `subTotal` decimal(18,2) NOT NULL COMMENT 'Sub Total',
  `notes` varchar(100) DEFAULT NULL COMMENT 'Notes',
  `statusShipment` smallint(6) DEFAULT NULL COMMENT 'Status Shipment',
  PRIMARY KEY (`purchaseOrderDetailID`),
  KEY `fk_purchaseordernum_idx` (`purchaseOrderNum`),
  KEY `fk_uomid_idx` (`uomID`),
  KEY `fk_productid_idx` (`productID`),
  KEY `fk_statusshipment_idx` (`statusShipment`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_purchaseorderdetail`
--

LOCK TABLES `tr_purchaseorderdetail` WRITE;
/*!40000 ALTER TABLE `tr_purchaseorderdetail` DISABLE KEYS */;
INSERT INTO `tr_purchaseorderdetail` VALUES (2,'QJA/17193',53,1,1,1850.00,0.00,1850.00,'',NULL),(8,'QJA/17177',39,1,5,95.00,0.00,475.00,'',NULL),(9,'QJA/17244',121,1,10,130.00,0.00,1300.00,'',NULL),(11,'QJA/17079',64,3,10000,6.30,0.00,63000.00,'',NULL),(13,'QJA/17227',131,1,50,32.00,0.00,1600.00,'',NULL),(14,'QJA/17214',134,1,5,4210.00,0.00,21050.00,'',NULL),(15,'QJA/17222',169,1,25,93.00,0.00,2325.00,'',NULL),(16,'QJA/17183',38,1,100,69.00,0.00,6900.00,'',NULL),(28,'QJA/180002',135,1,5,900.00,0.00,4500.00,'',NULL),(30,'QJA/180003',152,1,10,425.00,0.00,4250.00,'',NULL),(31,'QJA/180004',171,1,25,140.00,0.00,3500.00,'',NULL),(33,'QJA/180005',106,1,100,118.00,0.00,11800.00,'',NULL),(36,'QJA/180008',176,1,75,49.00,0.00,3675.00,'',NULL),(38,'QJA/180009',156,1,2,450.00,0.00,900.00,'',NULL),(39,'QJA/180010',178,1,25,46.00,0.00,1150.00,'',NULL),(44,'QJA/180012',181,1,75,79.00,0.00,5925.00,'',NULL),(46,'QJA/180013',38,1,700,68.50,0.00,47950.00,'',NULL),(48,'QJA/180007',175,1,25,58.00,0.00,1450.00,'',NULL),(49,'QJA/180014',127,1,80,325.00,0.00,26000.00,'',NULL),(50,'QJA/180006',174,1,15,330.00,0.00,4950.00,'',NULL),(51,'QJA/180015',179,1,5,140.00,0.00,700.00,'',NULL),(52,'QJA/17190',77,1,2,500.00,0.00,1000.00,NULL,NULL),(53,'QJA/17210',128,1,15,210.00,0.00,3150.00,NULL,NULL),(54,'QJA/17220',69,1,400,114.00,0.00,45600.00,NULL,NULL),(55,'QJA/17224',153,1,10,240.00,0.00,2400.00,NULL,NULL),(56,'QJA/17225',182,1,50,250.00,0.00,12500.00,NULL,NULL),(57,'QJA/17226',136,1,25,29.50,0.00,737.50,NULL,NULL),(58,'QJA/17228',183,1,25,39.00,0.00,975.00,NULL,NULL),(59,'QJA/17229',191,6,20,49.00,0.00,980.00,NULL,NULL),(60,'QJA/17230',192,1,25,37.50,0.00,937.50,NULL,NULL),(61,'QJA/17231',193,1,5,1750.00,0.00,8750.00,NULL,NULL),(62,'QJA/17232',38,1,75,71.00,0.00,5325.00,NULL,NULL),(63,'QJA/17233',152,1,5,425.00,0.00,2125.00,NULL,NULL),(65,'QJA/17235',155,1,100,70.00,0.00,7000.00,NULL,NULL),(66,'QJA/17236',17,1,50,94.75,0.00,4737.50,NULL,NULL),(67,'QJA/17237',12,1,75,105.00,0.00,7875.00,NULL,NULL),(68,'QJA/17238',184,1,55,130.00,0.00,7150.00,NULL,NULL),(69,'QJA/17239',185,1,2240,5.00,0.00,11200.00,NULL,NULL),(70,'QJA/17240',194,1,10,380.00,0.00,3800.00,NULL,NULL),(72,'QJA/17245',187,1,360,40.00,0.00,14400.00,NULL,NULL),(73,'QJA/17246',87,1,1,520.00,0.00,520.00,NULL,NULL),(74,'QJA/17247',176,1,50,49.00,0.00,2450.00,NULL,NULL),(75,'QJA/17248',39,1,25,85.00,0.00,2125.00,NULL,NULL),(76,'QJA/17250',188,1,25,25.00,0.00,625.00,NULL,NULL),(77,'QJA/17251',189,1,25,131.00,0.00,3275.00,NULL,NULL),(78,'QJA/17252',155,1,125,70.00,0.00,8750.00,NULL,NULL),(79,'QJA/17253',158,5,500,1.20,0.00,800.00,NULL,NULL),(80,'QJA/17254',13,1,10,1450.00,0.00,14500.00,NULL,NULL),(88,'QJA/180017',44,1,1,450.00,0.00,450.00,'',NULL),(91,'QJA/180018',7,1,1,4000.00,0.00,4000.00,'',NULL),(95,'QJA/180019',152,1,21,425.00,0.00,8925.00,'',NULL),(98,'QJA/180011',180,1,10,60.00,0.00,600.00,'',NULL),(99,'QJA/180020',195,1,25,220.00,0.00,5500.00,'',NULL),(104,'QJA/180022',99,1,5,175.00,0.00,875.00,'',NULL),(107,'QJA/180023',174,1,15,355.00,0.00,5325.00,'',NULL),(110,'QJA/180024',197,1,50,51.70,0.00,2585.00,'',NULL),(116,'QJA/180026',146,1,125,13.00,0.00,1625.00,'',NULL),(119,'QJA/180027',88,1,50,60.00,0.00,3000.00,'',NULL),(120,'QJA/180028',76,1,50,85.00,0.00,4250.00,'',NULL),(121,'QJA/180016',41,1,75,115.00,0.00,8625.00,'',NULL),(124,'QJA/180025',183,1,25,39.00,0.00,975.00,'',NULL),(126,'QJA/180029',77,1,1,500.00,0.00,500.00,'',NULL),(128,'QJA/180030',144,1,300,81.00,0.00,24300.00,'',NULL),(131,'QJA/180031',200,1,300,77.30,0.00,23190.00,'',NULL),(134,'QJA/180032',201,1,1,875.00,0.00,875.00,'',NULL),(135,'QJA/180033',86,3,500,2.50,0.00,1250.00,'',NULL),(139,'QJA/180034',186,1,20,58.00,0.00,1160.00,'',NULL),(143,'QJA/17243',186,1,10,46.50,0.00,465.00,'',NULL),(145,'QJA/180036',49,3,100,4.50,0.00,450.00,'',NULL),(146,'QJA/180035',86,1,30,1300.00,0.00,39000.00,'',NULL),(147,'QJA/17242',207,1,10,174.00,0.00,1740.00,'',NULL),(149,'QJA/17249',209,1,25,61.00,0.00,1525.00,'',NULL),(150,'QJA/180037',60,3,500,4.00,0.00,0.00,'',NULL),(151,'QJA/17203',137,1,10,800.00,0.00,8000.00,'',NULL),(152,'QJA/17204',124,1,50,50.00,0.00,2500.00,'',NULL),(153,'QJA/17205',136,1,25,29.50,0.00,737.50,'',NULL),(154,'QJA/17206',38,1,200,69.00,0.00,13800.00,'',NULL),(155,'QJA/17211',131,1,25,33.00,0.00,825.00,'',NULL),(156,'QJA/17212',102,3,300,4.00,0.00,1200.00,'',NULL),(157,'QJA/17218',34,1,100,63.00,0.00,6300.00,'',NULL),(158,'QJA/17219',152,1,25,425.00,0.00,10625.00,'',NULL),(159,'QJA/17221',37,1,2,7200.00,0.00,14400.00,'',NULL),(163,'QJA/180039',65,1,5,900.00,0.00,4500.00,'',NULL),(165,'QJA/180040',154,1,2,3185.00,0.00,6370.00,'',NULL),(167,'QJA/180021',196,1,1,9200.00,0.00,9200.00,'',NULL),(168,'QJA/180041',157,1,60,335.00,0.00,20100.00,'',NULL),(170,'QJA/180042',185,1,2240,5.00,0.00,0.00,'',NULL),(171,'QJA/180043',153,1,50,245.00,0.00,12250.00,'',NULL),(175,'QJA/180045',201,1,5,700.00,0.00,3500.00,'',NULL),(176,'QJA/17169',38,1,100,69.00,0.00,6900.00,NULL,NULL),(177,'QJA/17169',38,1,200,69.00,0.00,13800.00,NULL,NULL),(179,'QJA/180001',5,1,100,61.00,0.00,6100.00,'',NULL),(189,'QJA/180046',102,3,300,4.50,0.00,1350.00,'',NULL),(190,'QJA/17202',103,1,1,3100.00,0.00,3100.00,NULL,NULL),(191,'QJA/17161',46,1,75,53.00,0.00,3975.00,NULL,NULL),(192,'QJA/17151',149,1,5,370.00,0.00,1850.00,NULL,NULL),(193,'QJA/17172',43,1,25,50.00,0.00,1250.00,NULL,NULL),(194,'QJA/17173',42,1,25,38.00,0.00,950.00,NULL,NULL),(196,'QJA/180047',214,1,10,960.00,0.00,9600.00,'',NULL),(197,'QJA/17166',146,1,980,13.00,0.00,12740.00,NULL,NULL),(198,'QJA/17174',145,1,50,20.50,0.00,1025.00,NULL,NULL),(199,'QJA/17208',133,1,25,55.00,0.00,1375.00,NULL,NULL),(200,'QJA/17146',214,1,10,977.00,0.00,9770.00,NULL,NULL),(201,'QJA/180048',203,3,200,10.50,0.00,2100.00,'',NULL),(203,'QJA/180049',144,1,1100,78.00,0.00,85800.00,'',NULL),(206,'QJA/180050',216,1,11,1100.00,0.00,12100.00,'',NULL),(207,'QJA/180051',44,1,2,450.00,0.00,900.00,'',NULL),(208,'QJA/17165',44,1,2,450.00,0.00,900.00,NULL,NULL),(211,'QJA/17200',120,1,10,120.00,0.00,1200.00,NULL,NULL),(212,'QJA/180053',136,1,25,29.50,0.00,737.50,'',NULL),(213,'QJA/17217',25,1,25,90.00,0.00,2250.00,NULL,NULL),(214,'QJA/17207',116,1,30,45.00,0.00,1350.00,NULL,NULL),(215,'QJA/17194',138,1,25,151.00,0.00,3775.00,NULL,NULL),(216,'QJA/17171',157,1,60,265.00,0.00,15900.00,NULL,NULL),(217,'QJA/17185',34,1,100,63.00,0.00,6300.00,NULL,NULL),(218,'QJA/17216',156,1,2,425.00,0.00,850.00,NULL,NULL),(219,'QJA/17209',130,1,25,153.00,0.00,3825.00,NULL,NULL),(220,'QJA/17201',78,1,10,2840.00,0.00,28400.00,NULL,NULL),(221,'QJA/17198',39,1,6,110.00,0.00,550.00,NULL,NULL),(222,'QJA/17213',135,1,5,900.00,0.00,4500.00,NULL,NULL),(223,'QJA/180054',45,3,100,4.50,0.00,450.00,'',NULL),(225,'QJA/17215',219,1,50,60.00,0.00,3000.00,NULL,NULL),(226,'QJA/180044',19,1,275,53.50,0.00,14712.50,'',NULL),(227,'QJA/17223',217,1,6,3400.00,0.00,20400.00,NULL,NULL),(228,'QJA/17055',64,3,10000,6.30,0.00,63000.00,NULL,NULL),(232,'QJA/180056',221,1,50,26.25,0.00,1312.50,'',NULL),(240,'QJA/180057',222,1,5,310.00,0.00,1550.00,'',NULL),(243,'QJA/180058',145,1,100,20.00,0.00,2000.00,'',NULL),(245,'QJA/180055',220,3,1355,50510.00,0.00,68441050.00,'',NULL),(247,'QJA/180059',49,3,100,4.50,0.00,450.00,'',NULL),(249,'QJA/180060',175,1,25,58.00,0.00,1450.00,'',NULL),(250,'QJA/180061',16,1,275,49.50,0.00,13612.50,'',NULL),(253,'QJA/180062',115,1,5,280.00,0.00,1400.00,'',NULL),(254,'QJA/180038',211,1,2,5025.00,0.00,10050.00,'',NULL),(255,'QJA/180063',185,1,2240,5.00,0.00,11200.00,'',NULL),(259,'QJA/180065',176,1,75,51.00,0.00,3825.00,'',NULL),(261,'QJA/180066',229,1,60,290.00,0.00,17400.00,'',NULL),(262,'QJA/180067',230,1,50,65.00,0.00,3250.00,'',NULL),(267,'QJA/180068',64,1,20,6800.00,0.00,136000.00,'',NULL),(268,'QJA/180069',232,1,1,1350.00,0.00,1350.00,'',NULL),(269,'QJA/180052',41,1,140,115.00,0.00,16100.00,'',NULL),(271,'QJA/180070',235,1,20,1240470.00,0.00,24809400.00,'',NULL),(274,'QJA/180071',61,1,30,45.00,0.00,1350.00,'',NULL),(275,'QJA/180072',153,1,20,255.00,0.00,5100.00,'',NULL),(278,'QJA/180073',227,1,25,92.00,0.00,2300.00,'',NULL),(279,'QJA/180074',131,1,25,41.00,0.00,1025.00,'',NULL),(281,'QJA/180064',112,1,1,540.00,0.00,540.00,'',NULL),(283,'QJA/180075',81,1,40,1580.00,0.00,63200.00,'',NULL),(285,'QJA/180076',38,1,350,65.00,0.00,22750.00,'',NULL),(286,'QJA/180077',135,1,5,930.00,0.00,4650.00,'',NULL);
/*!40000 ALTER TABLE `tr_purchaseorderdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_purchaseorderhead`
--

DROP TABLE IF EXISTS `tr_purchaseorderhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_purchaseorderhead` (
  `purchaseOrderNum` varchar(50) NOT NULL COMMENT 'Purchase Order Number',
  `refNum` varchar(50) DEFAULT NULL COMMENT 'Reference Sales Order Number',
  `purchaseOrderDate` datetime NOT NULL COMMENT 'Purchase Order Date',
  `shipmentDate` datetime DEFAULT NULL COMMENT 'Shipment Date',
  `shipmentType` varchar(100) DEFAULT NULL,
  `deliveryType` varchar(50) DEFAULT NULL,
  `isImport` bit(1) DEFAULT NULL,
  `hasVAT` bit(1) DEFAULT NULL,
  `supplierID` int(11) DEFAULT NULL COMMENT 'Supplier ID',
  `contactPerson` varchar(50) DEFAULT NULL,
  `contactPersonCC` varchar(50) DEFAULT NULL,
  `paymentDue` int(11) DEFAULT NULL,
  `currencyID` varchar(5) NOT NULL COMMENT 'Currency ID',
  `rate` decimal(10,2) NOT NULL COMMENT 'Rate',
  `paymentID` smallint(6) NOT NULL COMMENT 'Payment ID',
  `taxRate` decimal(18,2) DEFAULT NULL COMMENT 'Tax Rate',
  `grandTotal` decimal(18,2) NOT NULL COMMENT 'Grand Total',
  `packingType` varchar(100) DEFAULT NULL,
  `additionalInfo` text COMMENT 'Additional Info',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`purchaseOrderNum`),
  KEY `fk_supplierid_idx` (`supplierID`),
  KEY `fk_currencyid_idx` (`currencyID`),
  KEY `fk_paymentid_idx` (`paymentID`),
  KEY `fk_paymentdue_idx` (`paymentDue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_purchaseorderhead`
--

LOCK TABLES `tr_purchaseorderhead` WRITE;
/*!40000 ALTER TABLE `tr_purchaseorderhead` DISABLE KEYS */;
INSERT INTO `tr_purchaseorderhead` VALUES ('QJA/17055',NULL,'2017-03-03 00:00:00',NULL,'CIF air Jakarta','May-17','','\0',2,'Mrs. Marinella Frigreio','',11,'USD',13000.00,2,0.00,63000.00,'100 Gr / Aluminium Tin',NULL,'ADMIN','2017-03-03 00:00:00','ADMIN','2017-03-03 00:00:00'),('QJA/17079','','2017-04-12 00:00:00',NULL,'CIF Air Jakarta','Early October 2017','','\0',2,'Mrs. Marinella Frigreio','',11,'USD',13325.00,2,0.00,63000.00,'TIN','<ol>\r\n	<li>Please mention Our PO No.QJA/17079 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Sanofi/France</li>\r\n</ol>\r\n','admin','2017-12-21 13:26:01','admin','2017-12-21 13:33:37'),('QJA/17146',NULL,'2017-07-21 00:00:00',NULL,'CIF Air Jakarta','Prompt after import license receipt','','\0',70,'Mr. Teddy Saputra','',6,'USD',13000.00,2,0.00,9770.00,'HDPE',NULL,'ADMIN','2017-07-21 00:00:00','ADMIN','2017-07-21 00:00:00'),('QJA/17151',NULL,'2017-07-25 00:00:00',NULL,'CIF Air Jakarta','Prompt.','','\0',70,'Mr. Teddy Saputra','Mr. Vincent Harijanto/Ms. Yunita Indrasari',6,'USD',13000.00,2,0.00,1850.00,'Standard Export',NULL,'ADMIN','2017-07-25 00:00:00','ADMIN','2017-07-25 00:00:00'),('QJA/17161',NULL,'2017-08-07 00:00:00',NULL,'CIF Air Jakarta','End September 2017','','\0',11,'Ms. Tracy Zhang','Mr. Victor Huang',12,'USD',13000.00,2,0.00,3975.00,'25 kg / Fibre Drum',NULL,'ADMIN','2017-08-07 00:00:00','ADMIN','2017-08-07 00:00:00'),('QJA/17165',NULL,'2017-08-23 00:00:00',NULL,'CIF Air Jakarta','End October 2017','','\0',41,'Mr. Al Rego ( Vitalchemie Corporation )','',3,'USD',13000.00,2,0.00,900.00,'HDPE',NULL,'ADMIN','2017-08-23 00:00:00','ADMIN','2017-08-23 00:00:00'),('QJA/17166',NULL,'2017-08-24 00:00:00',NULL,'CIF Air Jakarta','Prompt','','\0',19,'Mr. Mohammad Ashraf','',2,'USD',13000.00,2,0.00,12740.00,'HDPE',NULL,'ADMIN','2017-08-24 00:00:00','ADMIN','2017-08-24 00:00:00'),('QJA/17169',NULL,'2017-10-19 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',11,'Ms. Tracy Zhang','Ms. Tracy Zhang',4,'USD',13000.00,4,0.00,20400.00,'25 kg / Fibre Drum',NULL,'SYSTEM','2018-02-21 11:58:38','SYSTEM','2018-02-21 11:58:38'),('QJA/17171',NULL,'2017-08-25 00:00:00',NULL,'CIF air Jakarta','Early November 2017','','\0',40,'Mr. Jeffrey Liu','',4,'USD',13000.00,2,0.00,15900.00,'10 kg / Fibre Drum',NULL,'ADMIN','2017-08-25 00:00:00','ADMIN','2017-08-25 00:00:00'),('QJA/17172',NULL,'2017-08-30 00:00:00',NULL,'CIF Air Jakarta','Mid October 2017','','\0',39,'Mr. Atman Prakesh','',3,'USD',13000.00,2,0.00,1250.00,'HDPE',NULL,'ADMIN','2017-08-30 00:00:00','ADMIN','2017-08-30 00:00:00'),('QJA/17173',NULL,'2017-08-30 00:00:00',NULL,'CIF Air Jakarta','Mid September 2017','','\0',39,'Mr. Atman Prakesh','',3,'USD',13000.00,2,0.00,950.00,'HDPE',NULL,'ADMIN','2017-08-30 00:00:00','ADMIN','2017-08-30 00:00:00'),('QJA/17174',NULL,'2017-08-30 00:00:00',NULL,'CIF Air Jakarta','Prompt','','\0',38,'Mr. Al Rego ( Vitalchemie Corporation )','Mrs. Vidya Sawant ( Vitalchemie Corporation )',3,'USD',13000.00,2,0.00,1025.00,'HDPE',NULL,'ADMIN','2017-08-30 00:00:00','ADMIN','2017-08-30 00:00:00'),('QJA/17177','','2017-09-04 00:00:00',NULL,'CIF Air Jakarta','End October 2017','','\0',36,'Mr. S.Sandeep','',3,'USD',13000.00,2,0.00,475.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/17177 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Vasudha Pharma</li>\r\n</ol>\r\n','admin','2017-12-06 08:32:40','admin','2017-12-06 08:32:40'),('QJA/17183','','2017-09-18 00:00:00',NULL,'CIF air Jakarta','Combine Shipment with our PO No. QJA/17169','','\0',11,'Ms. Tracy Zhang','Mr. Victor Huang',4,'USD',13000.00,2,0.00,6900.00,'25 kg/Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/17183 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Guangxi Bonger</li>\r\n</ol>\r\n','admin','2017-12-22 14:11:22','admin','2017-12-22 14:11:22'),('QJA/17185',NULL,'2017-09-25 00:00:00',NULL,'CIF air Jakarta','Early November 2017','','\0',23,'Mr. Al Rego ( Vitalchemie Corporation )','',2,'USD',13000.00,2,0.00,6300.00,'10 kg / HDPE',NULL,'ADMIN','2017-09-25 00:00:00','ADMIN','2017-09-25 00:00:00'),('QJA/17190',NULL,'2017-09-27 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',33,'Mr. Al Rego [Vital Chemie Corporation]',NULL,2,'USD',13000.00,2,0.00,1000.00,'5 Kg / Aluminium Tin',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17193','','2017-10-02 00:00:00',NULL,'CIF Air / Courier Jakarta','Prompt','','\0',43,'Ms. Serena Pan','',4,'USD',13000.00,2,0.00,1850.00,'Standard Export','<ol>\r\n	<li>Please mention Our PO No.QJA/17193 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last shipment.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Hunan Yuxin Pharmaceutical Ltd/CHINA.</li>\r\n</ol>\r\n','admin','2017-12-05 11:50:22','admin','2017-12-05 11:50:22'),('QJA/17194',NULL,'2017-03-17 00:00:00',NULL,'CIF air Jakarta','Early Desember 2017','','\0',70,'Mrs. Lisa Kng','',10,'USD',13000.00,2,0.00,3775.00,'25 kg / HDPE Drum',NULL,'ADMIN','2017-03-17 00:00:00','ADMIN','2017-03-17 00:00:00'),('QJA/17198',NULL,'2017-11-10 00:00:00',NULL,'CIF air Jakarta','Early November 2017','','\0',36,'Mr. S.Sandeep Varma','',3,'USD',13000.00,2,0.00,550.00,'5 kg / HDPE Drum',NULL,'ADMIN','2017-11-10 00:00:00','ADMIN','2017-11-10 00:00:00'),('QJA/17200',NULL,'2017-10-16 00:00:00',NULL,'CIF Air Jakarta','Prompt','','\0',62,'Mr. Xiejuan','',4,'USD',13000.00,2,0.00,1200.00,'Fibre drum',NULL,'ADMIN','2017-10-16 00:00:00','ADMIN','2017-10-16 00:00:00'),('QJA/17201',NULL,'2017-10-11 00:00:00',NULL,'CIF air Jakarta','End November 2017','','\0',40,'Mr. Jeffrey Liu','',4,'USD',13000.00,2,0.00,28400.00,'10 kg / Fibre Drum',NULL,'ADMIN','2017-10-11 00:00:00','ADMIN','2017-10-11 00:00:00'),('QJA/17202','','2017-10-17 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Mohan Menon',NULL,6,'USD',13000.00,2,0.00,3100.00,'HDPE',NULL,'admin','2018-02-22 00:00:00','admin','2018-02-22 00:00:00'),('QJA/17203','','2017-10-19 00:00:00',NULL,'CIF air Jakarta','End November 2017','','\0',43,'Ms. Serena Pan','Ms. Serena Pan',4,'USD',13000.00,4,0.00,8000.00,'5 kg / Aluminium Tin','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:20:55'),('QJA/17204','','2017-10-19 00:00:00',NULL,'CIF air Jakarta','Early Desember 2017','','\0',27,'Mr. Mayur Jhunjhuwala','Mr. Mayur Jhunjhuwala',1,'USD',13000.00,1,0.00,2500.00,'25 kg / HDPE Drum','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:22:28'),('QJA/17205','','2017-10-19 00:00:00',NULL,'CIF air Jakarta','Early Desember 2017','','\0',40,'Mr. Jeffrey Liu','Mr. Jeffrey Liu',4,'USD',13000.00,4,0.00,737.50,'25 kg / Fibre Drum','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:24:05'),('QJA/17206','','2017-10-19 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',11,'Ms. Tracy Zhang','Ms. Tracy Zhang',4,'USD',13000.00,4,0.00,13800.00,'25 kg / Fibre Drum','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:25:23'),('QJA/17207',NULL,'2017-10-23 00:00:00',NULL,'CIF air Jakarta','MidNovember 2017','','\0',46,'Mr. Xiejuan','',4,'USD',13000.00,2,0.00,1350.00,'30 kg / Fibre Drum',NULL,'ADMIN','2017-10-23 00:00:00','ADMIN','2017-10-23 00:00:00'),('QJA/17208',NULL,'2017-10-23 00:00:00',NULL,'CIF Air Jakarta','Prompt','','\0',11,'Ms. Tracy Zhang','Mr. Victor Huang',4,'USD',13000.00,2,0.00,1375.00,'Fibre Drum',NULL,'ADMIN','2017-10-23 00:00:00','ADMIN','2017-10-23 00:00:00'),('QJA/17209',NULL,'2017-10-26 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',11,'Ms. Tracy Zhang','',4,'USD',13000.00,2,0.00,3825.00,'25 kg / Fibre Drum',NULL,'ADMIN','2017-10-26 00:00:00','ADMIN','2017-10-26 00:00:00'),('QJA/17210',NULL,'2017-10-26 00:00:00',NULL,'CIF air Jakarta','Mid February 2018','','\0',9,'Mr. Mohan Menon',NULL,3,'USD',13000.00,2,0.00,3150.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17211','','2017-10-31 00:00:00',NULL,'CIF air Jakarta','End November 2017','','\0',11,'Ms. Tracy Zhang','Ms. Tracy Zhang',4,'USD',13000.00,4,0.00,825.00,'25 kg/Fibre Drum','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:27:52'),('QJA/17212','','2017-01-11 00:00:00',NULL,'CIF air Jakarta','Early December 2017','','\0',14,'Mr. Mohan Menon','Mr. Mohan Menon',6,'USD',13000.00,6,0.00,1200.00,'HDPE','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:29:27'),('QJA/17213',NULL,'2017-03-11 00:00:00',NULL,'CIF Air Jakarta','Prompt','','\0',70,'Mrs. Lisa Kng','',10,'USD',13000.00,2,0.00,4500.00,'5 kg / Aluminium Tin',NULL,'ADMIN','2017-03-11 00:00:00','ADMIN','2017-03-11 00:00:00'),('QJA/17214','','2017-11-03 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',70,'Mrs. Lisa Kng','Ms. Yunita Indrasari',6,'USD',13000.00,2,0.00,21050.00,'Aluminium Tin','<ol>\r\n	<li>Please mention Our PO No.QJA/17214 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Sourcetech Quimica LTDA</li>\r\n</ol>\r\n','admin','2017-12-21 15:27:02','admin','2017-12-21 15:27:02'),('QJA/17215',NULL,'2017-06-11 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',27,'Mr. Mayur Jhunjhuwala','',8,'USD',13000.00,2,0.00,3000.00,'25 kg/HDPE Drum',NULL,'ADMIN','2017-06-11 00:00:00','ADMIN','2017-06-11 00:00:00'),('QJA/17216',NULL,'2017-10-11 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,0.00,850.00,'HDPE',NULL,'ADMIN','2017-10-11 00:00:00','ADMIN','2017-10-11 00:00:00'),('QJA/17217',NULL,'2017-11-14 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',21,'Mr. Parv Jain ','',3,'USD',13000.00,2,0.00,2250.00,'25 kg / HDPE Drum',NULL,'ADMIN','2017-11-14 00:00:00','ADMIN','2017-11-14 00:00:00'),('QJA/17218','','2017-09-11 00:00:00',NULL,'CIF air Jakarta','Early December 2017','','\0',23,'Mr. Al Rego ( Vitalchemie Corporation )','Mr. Al Rego ( Vitalchemie Corporation )',2,'USD',13000.00,2,0.00,6300.00,'10 kg/HDPE','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:30:30'),('QJA/17219','','2017-10-11 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',20,'Mr. Al Rego ( Vitalchemie Corporation )','Mr. Al Rego ( Vitalchemie Corporation )',2,'USD',13000.00,2,0.00,10625.00,'5 kg / HDPE','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:31:31'),('QJA/17220',NULL,'2017-11-14 00:00:00',NULL,'CIF air Jakarta','each 200 kg Early January 2017 and Early March 201','','\0',40,'Mr. Jeffrey Liu',NULL,3,'USD',13000.00,2,0.00,45600.00,'25 kg/ Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17221','','2017-11-14 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',34,'Mr. Al Rego ( Vitalchemie Corporation )','Mr. Al Rego ( Vitalchemie Corporation )',3,'USD',13000.00,3,0.00,14400.00,'1 kg / HDPE','','','0000-00-00 00:00:00','qwinjayasupport','2018-02-09 16:34:05'),('QJA/17222','','2017-11-21 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',43,'Ms. Serena Pan','Ms. Serena Pan',4,'USD',13000.00,2,0.00,2325.00,'Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/17222 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Taizhou Xingming</li>\r\n	<li>Please kindly provide the form E with same issue date of the AWB.</li>\r\n</ol>\r\n','admin','2017-12-21 16:18:39','admin','2017-12-21 16:18:39'),('QJA/17223',NULL,'2017-11-21 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',44,'Mr. Chris',NULL,4,'USD',13000.00,2,0.00,20400.00,'Standard Export',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17224',NULL,'2017-11-23 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',16,'Mr. Paras Kamdar',NULL,2,'USD',13000.00,2,0.00,2400.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17225',NULL,'2017-11-24 00:00:00',NULL,'CIF air Jakarta','Early December 2017','','\0',2,'Mrs. Marinella Frigreio',NULL,7,'USD',13000.00,2,0.00,12500.00,'25 kg / HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17226',NULL,'2017-11-24 00:00:00',NULL,'CIF air Jakarta','Early February 2018','','\0',40,'Mr. Jeffrey Liu',NULL,4,'USD',13000.00,2,0.00,737.50,'25 kg / Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17227','','2017-11-27 00:00:00',NULL,'CIF air Jakarta','Early January 2018','','\0',11,'Ms. Tracy Zhang','',12,'USD',13000.00,2,0.00,1600.00,'25 kg/Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/17227 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Manufacturer</li>\r\n</ol>\r\n','admin','2017-12-21 13:50:17','admin','2017-12-21 13:53:30'),('QJA/17228',NULL,'2017-11-27 00:00:00',NULL,'CIF air Jakarta','Second weeks January 2018','','\0',16,'Mr. Paras Kamdar',NULL,2,'USD',13000.00,2,0.00,975.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17229',NULL,'2017-11-28 00:00:00',NULL,'CIF air Jakarta','Mid February 2018','','\0',40,'Mr. Jeffrey Liu',NULL,4,'USD',13000.00,2,0.00,980.00,'Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17230',NULL,'2017-11-28 00:00:00',NULL,'CIF air Jakarta','Mid February 2018','','\0',40,'Mr. Jeffrey Liu',NULL,4,'USD',13000.00,2,0.00,937.50,'Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17231',NULL,'2017-11-28 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',70,'Mrs. Lisa Kng',NULL,2,'USD',13000.00,2,0.00,8750.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17232',NULL,'2017-11-30 00:00:00',NULL,'CIF air Jakarta','Mid January 2018','','\0',11,'Ms. Tracy Zhang',NULL,4,'USD',13000.00,2,0.00,5325.00,'25 kg / Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17233',NULL,'2017-12-05 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',20,'Mr. Al Rego [Vitalchemie Corporation]',NULL,3,'USD',13000.00,2,0.00,2125.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17235',NULL,'2017-12-06 00:00:00',NULL,'CIF air Jakarta','Mid January 2018','','\0',61,'Mr. Shantanu Rambhad (Cosmigen)',NULL,3,'USD',13000.00,2,0.00,7000.00,'25 kg / Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17236',NULL,'2017-12-06 00:00:00',NULL,'CIF air Jakarta','Mid January 2018','','\0',16,'Mr. Paras Kamdar',NULL,2,'USD',13000.00,2,0.00,4737.50,'10 kg / HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17237',NULL,'2017-12-06 00:00:00',NULL,'CIF air Jakarta','Mid January 2018','','\0',23,'Mr. Al Rego [Vitalchemie Corporation]',NULL,2,'USD',13000.00,2,0.00,7875.00,'25 kg / Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17238',NULL,'2008-12-17 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',2,'Mrs. Marinella Frigreio',NULL,11,'USD',13000.00,2,0.00,7150.00,'25 kg X HDPE & 5 kg X 1 HDPE',NULL,'admin','2010-01-17 00:00:00','admin','2010-01-17 00:00:00'),('QJA/17239',NULL,'2017-12-08 00:00:00',NULL,'CIF sea Jakarta','Prompt','','\0',70,'Mrs. Lisa Kng',NULL,6,'USD',13000.00,2,0.00,11200.00,'280 kg / HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17240',NULL,'2017-12-11 00:00:00',NULL,'CIF air Jakarta','Mid January 2018','','\0',27,'Mr. Mayur Jhunjhuwala',NULL,3,'USD',13000.00,2,0.00,3800.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17241',NULL,'2017-12-13 00:00:00',NULL,'CIF air Jakarta','Prompt after original import license receipt','','\0',70,'Mrs. Lisa Kng',NULL,6,'USD',13000.00,2,0.00,975.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17242','','2017-12-13 00:00:00',NULL,'CIF air Jakarta','Early February 2018','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,0.00,1740.00,'HDPE','','admin','2017-01-10 00:00:00','qwinjayasupport','2018-02-07 09:52:02'),('QJA/17243','','2017-12-13 00:00:00',NULL,'CIF air Jakarta','Early February 2018','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,0.00,465.00,'HDPE','','admin','2017-01-10 00:00:00','qwinjayasupport','2018-02-05 11:48:17'),('QJA/17244','','2017-12-14 00:00:00',NULL,'CIF Air Jakarta','Prompt','','\0',9,'MOHAN MENON','',2,'USD',13000.00,2,0.00,1300.00,'Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/17244 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Microsin/Romania</li>\r\n</ol>\r\n','admin','2017-12-14 15:20:51','admin','2017-12-14 15:20:51'),('QJA/17245',NULL,'2014-12-17 00:00:00',NULL,'CNF air Jakarta','Prompt shipment','','\0',2,'Mrs. Marinella Frigreio',NULL,7,'USD',13000.00,2,0.00,14400.00,'40 kg / Fibre Drum',NULL,'admin','2010-01-17 00:00:00','admin','2010-01-17 00:00:00'),('QJA/17246',NULL,'2017-12-15 00:00:00',NULL,'CIF air Jakarta','Early February 2018','','\0',64,'Mr. Vishnu Chelikani',NULL,3,'USD',13000.00,2,0.00,520.00,'HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17247',NULL,'2017-12-18 00:00:00',NULL,'CIF air Jakarta','prompt (Early January 2018)','','\0',78,'MS. Nicole Mou',NULL,4,'USD',13000.00,2,0.00,2450.00,'25 kg / Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17248',NULL,'2017-12-20 00:00:00',NULL,'CIF air Jakarta','Early January 2018','','\0',36,'Mr. S.Sandeep Varma',NULL,3,'USD',13000.00,2,0.00,2125.00,'5 kg / Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17249','','2017-12-21 00:00:00',NULL,'CIF air Jakarta','Early February 2018','','\0',11,'Ms. Tracy Zhang','',4,'USD',13000.00,2,0.00,1525.00,'Fibre Drum','','admin','2017-01-10 00:00:00','akhiong','2018-02-07 14:26:45'),('QJA/17250',NULL,'2017-12-21 00:00:00',NULL,'CIF air Jakarta','Early February 2018','','\0',43,'Ms. Serena Pan',NULL,4,'USD',13000.00,2,0.00,625.00,'Fibre Drum',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17251',NULL,'2017-12-21 00:00:00',NULL,'CIF air Jakarta','Early March 2018','','\0',43,'Ms. Serena Pan',NULL,4,'USD',13000.00,2,0.00,3275.00,'Standard Export',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17252',NULL,'2017-12-21 00:00:00',NULL,'CIF air Jakarta','Mid January 2018 (Combine shipment with PO. No. QJ','','\0',61,'Mr. Shantanu Rambhad (Cosmigen)',NULL,3,'USD',13000.00,2,0.00,8750.00,'25 kg / HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17253',NULL,'2017-12-22 00:00:00',NULL,'CIF air Jakarta','Early January 2018','','\0',14,'Mr. Mohan Menon',NULL,6,'USD',13000.00,2,0.00,800.00,'250 mg / Vial',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/17254',NULL,'2017-12-22 00:00:00',NULL,'CIF air Jakarta','Early January 2018','','\0',14,'Mr. Mohan Menon',NULL,6,'USD',13000.00,2,0.00,14500.00,'5 kg / HDPE',NULL,'admin','2017-01-10 00:00:00','admin','2017-01-10 00:00:00'),('QJA/180001','','2018-01-02 00:00:00',NULL,'CIF Air Jakarta','Early April 2018','','\0',70,'Mrs. Lisa Kng','',6,'USD',13569.00,2,0.00,6100.00,'25 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18001 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Embio Ltd</li>\r\n	<li>in quantity one hundred kilograms</li>\r\n</ol>\r\n','yudhi','2018-01-02 10:34:30','yudi','2018-02-22 08:04:00'),('QJA/180002','','2018-01-02 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',70,'Ms. Yunita Indrasari','',6,'USD',13569.00,2,0.00,4500.00,'5 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18002 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Embio Ltd</li>\r\n	<li>In quantity Five Kilograms</li>\r\n</ol>\r\n','yudhi','2018-01-02 11:03:31','yudhi','2018-01-02 15:53:10'),('QJA/180003','','2018-01-03 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',20,'Mrs. Vidya Sawant [Vitalchemie Corporation]','',3,'USD',13569.00,2,0.00,4250.00,'5kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/18003 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Hikal Limited</li>\r\n</ol>\r\n','yudhi','2018-01-03 10:08:30','yudhi','2018-01-03 10:12:59'),('QJA/180004','','2018-01-03 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',11,'Ms. Tracy Zhang','Mr. Victor Huang',3,'USD',13000.00,2,0.00,3500.00,'TIN','<ol>\r\n	<li>Please mention Our PO No.QJA/18004 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Anhui Wanhe Pharmaceutical Co., Ltd</li>\r\n</ol>\r\n','yudhi','2018-01-03 17:04:30','yudhi','2018-01-03 17:04:30'),('QJA/180005','','2018-01-05 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',70,'Mr. Teddy Saputra','',3,'USD',13000.00,2,0.00,11800.00,'25 kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/18005 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Sezhou Fushilai Pharmaceutical Co., Ltd</li>\r\n</ol>\r\n','yudhi','2018-01-05 08:56:48','yudhi','2018-01-05 11:28:22'),('QJA/180006','','2018-01-05 00:00:00',NULL,'CNF Air Jakarta','prompt shipment','','\0',2,'Mrs. Marinella Frigreio','',7,'EURO',14000.00,2,0.00,4950.00,'15 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18006 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Vemo 99 Ltd</li>\r\n</ol>\r\n','yudhi','2018-01-05 15:26:15','yudhi','2018-01-17 10:43:23'),('QJA/180007','','2018-01-05 00:00:00',NULL,'CNF Air Jakarta','prompt shipment','','\0',2,'Mrs. Marinella Frigreio','',7,'USD',13000.00,2,0.00,1450.00,'25 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18007 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Jiangsu Nhwa Pharmaceutical Co., Ltd</li>\r\n</ol>\r\n','yudhi','2018-01-05 16:01:40','yudhi','2018-01-17 10:36:25'),('QJA/180008','','2018-01-09 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',78,'MS. Nicole Mou','',4,'USD',13000.00,2,0.00,3675.00,'25 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18008 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Chengdu Yazhong Bio-Pharmaceutical Co., Ltd.</li>\r\n</ol>\r\n','yudhi','2018-01-09 11:27:13','yudhi','2018-01-09 11:27:13'),('QJA/180009','','2018-01-11 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,0.00,900.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/18009 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Rajasthan Antibiotics Limited</li>\r\n</ol>\r\n','yudhi','2018-01-11 08:01:41','yudhi','2018-01-11 08:03:34'),('QJA/180010','','2018-01-11 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',58,'Mr. Shantanu Rambhad [Cosmigen]','Ms. Reena M (Cosmigen)',3,'USD',13000.00,2,0.00,1150.00,'25 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18010 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Fleming Laboratories Limited</li>\r\n</ol>\r\n','yudhi','2018-01-11 10:00:59','yudhi','2018-01-11 10:00:59'),('QJA/180011','','2018-01-11 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',72,'Mr. Bhavik Shah','',3,'USD',13000.00,2,0.00,600.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/18011 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Prudance Pharma Chem</li>\r\n</ol>\r\n','yudhi','2018-01-11 14:16:17','yudi','2018-01-25 11:11:08'),('QJA/180012','','2018-01-11 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',11,'Ms. Tracy Zhang','',3,'USD',13000.00,2,0.00,5925.00,'25 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18012 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Hubei Xundai</li>\r\n</ol>\r\n','yudhi','2018-01-11 16:38:37','yudhi','2018-01-11 16:38:37'),('QJA/180013','','2018-01-12 00:00:00',NULL,'CIF Air Jakarta','350 Kg prompt, 350 Kg in April 2018','','\0',11,'Ms. Tracy Zhang','',3,'USD',13000.00,2,0.00,47950.00,'25 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18013 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Guangxi Bonger</li>\r\n	<li>350 Kg Prompt ;&nbsp; 350 Kg in April 2018&nbsp;&nbsp;&nbsp;</li>\r\n</ol>\r\n','yudhi','2018-01-12 08:34:11','yudhi','2018-01-12 08:36:38'),('QJA/180014','','2018-01-17 00:00:00',NULL,'CNF Air Jakarta','prompt shipment','','\0',2,'Mrs. Marinella Frigreio','',7,'USD',13000.00,2,0.00,26000.00,'20 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/18014 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Euticals</li>\r\n</ol>\r\n','yudhi','2018-01-17 09:23:55','yudhi','2018-01-17 10:42:22'),('QJA/180015','','2018-01-17 00:00:00',NULL,'CIF Air Jakarta','prompt shipment','','\0',36,'Mr. S.Sandeep Varma','Mr. Shaheen Rafik Mansuri',4,'USD',13000.00,2,0.00,700.00,'5kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/18015 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Vasudha Pharma</li>\r\n</ol>\r\n','yudhi','2018-01-17 16:25:38','yudhi','2018-01-17 16:25:38'),('QJA/180016','','2018-01-24 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',37,'Mr. Al Rego ( Vitalchemie Corporation )','',3,'USD',13000.00,2,0.00,8625.00,'25kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/18016 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Granules India Limited</li>\r\n</ol>\r\n','yudi','2018-01-24 11:30:04','yudi','2018-01-29 16:44:15'),('QJA/180017','','2018-01-24 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',41,'Mr. Al Rego ( Vitalchemie Corporation )','',3,'USD',13000.00,2,0.00,450.00,'1kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180017 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Jayco Chemical Industries</li>\r\n</ol>\r\n','yudi','2018-01-24 13:50:07','yudi','2018-01-24 13:53:49'),('QJA/180018','','2018-01-24 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',22,'QQ: PT. Menjangan Sakti','',4,'EURO',14000.00,2,0.00,4000.00,'1kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180018 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Cambrex Profarmaco</li>\r\n	<li>in quality one Kilogram</li>\r\n</ol>\r\n','yudi','2018-01-24 14:22:03','yudi','2018-01-24 15:56:44'),('QJA/180019','','2018-01-25 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',20,'Mrs. Vidya Sawant ( Vitalchemie Corporation )','',4,'USD',13000.00,2,0.00,8925.00,'5kg / HDPE   &  1kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180019 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Hikal Limited</li>\r\n</ol>\r\n','yudi','2018-01-25 09:13:07','yudi','2018-01-25 09:15:46'),('QJA/180020','','2018-01-26 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',40,'Mr. Jeffrey Liu','',4,'USD',13000.00,2,0.00,5500.00,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180020 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Hebei Jiheng</li>\r\n</ol>\r\n','yudi','2018-01-26 16:08:48','yudi','2018-01-26 16:08:48'),('QJA/180021','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','Three Weeks after receipt of SPI','','\0',2,'Mrs. Marinella Frigreio','',4,'USD',13000.00,2,0.00,9200.00,'Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180021 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Cambrex Profarmaco</li>\r\n	<li>Quantity in one kilogram only</li>\r\n</ol>\r\n','yudi','2018-01-29 08:23:59','yudi','2018-02-19 09:15:12'),('QJA/180022','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','Early March 2018','','\0',58,'Mr. Shantanu Rambhad (Cosmigen)','',4,'USD',13000.00,2,0.00,875.00,'2kg X 1 HDPE,  &  3kg X 1 HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180022 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Fleming Labs</li>\r\n</ol>\r\n','yudi','2018-01-29 08:31:58','yudi','2018-01-29 08:34:11'),('QJA/180023','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','prompt after SGS inspection','','\0',70,'Ms. Yunita Indrasari','',7,'EURO',14000.00,2,0.00,5325.00,'Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180023 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Vemo 99 Ltd</li>\r\n</ol>\r\n','yudi','2018-01-29 09:28:24','yudi','2018-01-29 10:11:33'),('QJA/180024','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','Ear May 2018','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,0.00,2585.00,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180024 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Vaikunth Pharmaceutical</li>\r\n</ol>\r\n','yudi','2018-01-29 15:06:35','yudi','2018-01-29 15:10:58'),('QJA/180025','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','Ear May 2018','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,0.00,975.00,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180025 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from RL Fine Chemicals</li>\r\n</ol>\r\n','yudi','2018-01-29 15:16:42','yudi','2018-01-29 16:50:13'),('QJA/180026','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',19,'Mr. Mohammad Ashraf','',2,'USD',13000.00,2,0.00,1625.00,'25kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180026 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Ra Chem Pharma</li>\r\n</ol>\r\n','yudi','2018-01-29 16:07:04','yudi','2018-01-29 16:10:00'),('QJA/180027','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',36,'Mr. S.Sandeep Varma','',3,'USD',13000.00,2,0.00,3000.00,'25kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180027 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Vasudha Pharma</li>\r\n</ol>\r\n','yudi','2018-01-29 16:25:32','yudi','2018-01-29 16:25:32'),('QJA/180028','','2018-01-29 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',36,'Mr. S.Sandeep Varma','',3,'USD',13000.00,2,0.00,4250.00,'10Kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180028 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Vasudha Pharma</li>\r\n</ol>\r\n','yudi','2018-01-29 16:32:34','yudi','2018-01-29 16:32:34'),('QJA/180029','','2018-01-31 00:00:00',NULL,'CIF Air Jakarta','Mid June 2018','','\0',33,'Mr. Al Rego ( Vital Chemie Corporation )','',4,'USD',13000.00,2,0.00,500.00,'1kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180029 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from RPG Life Sciences</li>\r\n</ol>\r\n','yudi','2018-01-31 08:39:51','yudi','2018-01-31 08:42:17'),('QJA/180030','','2018-02-01 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Ms. Yunita Indrasari','',6,'USD',13000.00,2,0.00,24300.00,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180030 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Srikem Laboratories</li>\r\n</ol>\r\n','yudi','2018-02-01 08:35:04','yudi','2018-02-01 08:35:51'),('QJA/180031','','2018-02-01 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Ms. Yunita Indrasari','',6,'USD',13000.00,2,0.00,23190.00,'25kg / Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180031 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Jiangxi Tianxin</li>\r\n</ol>\r\n','yudi','2018-02-01 08:41:22','yudi','2018-02-01 08:48:34'),('QJA/180032','','2018-02-01 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Mr. Teddy Saputra','',6,'USD',13000.00,2,0.00,875.00,'1kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180032 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Medilux Laboratories</li>\r\n</ol>\r\n','yudi','2018-02-01 09:04:28','yudi','2018-02-01 09:12:03'),('QJA/180033','','2018-02-01 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,0.00,1250.00,'Pot','<ol>\r\n	<li>Please mention Our PO No.QJA/180033 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-02-01 10:06:24','yudi','2018-02-01 10:06:24'),('QJA/180034','','2018-02-01 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,0.00,1160.00,'10kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180034 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Apex Healthcare Limited</li>\r\n</ol>\r\n','yudi','2018-02-01 10:22:21','yudi','2018-02-01 10:35:43'),('QJA/180035','','2018-02-05 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,0.00,39000.00,'5kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180035 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-02-05 08:12:24','yudi','2018-02-05 14:01:32'),('QJA/180036','','2018-02-05 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,0.00,450.00,'Pot','<ol>\r\n	<li>Please mention Our PO No.QJA/180036 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-02-05 13:04:34','yudi','2018-02-05 13:59:23'),('QJA/180037','','2018-02-09 00:00:00','2018-02-09 00:00:00','CIF air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,0.00,2000.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180037&nbsp;&amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','nurdin','2018-02-09 09:16:02','nurdin','2018-02-09 09:16:02'),('QJA/180038','','2018-02-12 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Ms. Yunita Indrasari','',6,'USD',13000.00,2,10.00,10050.00,'Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180038 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Manufacturer</li>\r\n</ol>\r\n','yudi','2018-02-12 08:09:33','yudi','2018-03-13 11:50:48'),('QJA/180039','','2018-02-12 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,0.00,4500.00,'5kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180039 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-02-12 08:25:47','yudi','2018-02-12 08:25:47'),('QJA/180040','','2018-02-14 00:00:00','2018-02-14 00:00:00','CIF air Jakarta','Prompt','','\0',70,'Ms. Yunita Indrasari','',6,'USD',13700.00,2,0.00,6370.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180040&nbsp;&amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Concord-India</li>\r\n</ol>\r\n','nurdin','2018-02-14 11:51:18','nurdin','2018-02-14 11:51:58'),('QJA/180041','','2018-02-19 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',40,'Mr. Jeffrey Liu','',4,'USD',13000.00,2,0.00,20100.00,'10kg / Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180041 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Zhejiang Charioteer</li>\r\n</ol>\r\n','yudi','2018-02-19 09:22:00','yudi','2018-02-19 09:22:00'),('QJA/180042','','2018-02-19 00:00:00','2018-02-19 00:00:00','CIF Sea Jakarta','Prompt','','\0',70,'Mrs. Lisa Kng','',6,'USD',13705.00,2,0.00,11200.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180042&nbsp;&amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Lacsa PTY Ltd</li>\r\n</ol>\r\n','nurdin','2018-02-19 14:11:51','nurdin','2018-02-19 14:11:51'),('QJA/180043','','2018-02-20 00:00:00','2018-04-30 00:00:00','CIF air Jakarta','End April 2018','','\0',16,'Mr. Paras Kamdar','',2,'USD',13700.00,2,0.00,12250.00,'10 kg HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180043&nbsp;&amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from RL Fine Chemicals</li>\r\n</ol>\r\n','nurdin','2018-02-20 11:06:58','nurdin','2018-02-20 11:06:58'),('QJA/180044','','2018-02-20 00:00:00',NULL,'CIF Sea Jakarta','Early Maret 2018','','\0',70,'Mrs. Lisa Kng','',6,'USD',13000.00,2,10.00,14712.50,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180044 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Embio Ltd</li>\r\n	<li>in quantity two hundred seventy five Kilograms</li>\r\n</ol>\r\n','yudi','2018-02-20 15:35:59','yudi','2018-03-08 13:07:09'),('QJA/180045','','2018-02-21 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Mr. Teddy Saputra','',6,'USD',13000.00,2,0.00,3500.00,'5kg / HDPE   ','<ol>\r\n	<li>Please mention Our PO No.QJA/180045 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from&nbsp; Medilux</li>\r\n</ol>\r\n','yudi','2018-02-21 09:31:29','yudi','2018-02-21 09:34:39'),('QJA/180046','','2018-02-22 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,0.00,1350.00,'Pot','<ol>\r\n	<li>Please mention Our PO No.QJA/180046 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-02-22 09:24:49','yudi','2018-02-22 10:15:27'),('QJA/180047','','2018-02-23 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Mr. Teddy Saputra','',6,'USD',13000.00,2,0.00,9600.00,'10kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180047 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Farmak</li>\r\n	<li>in quantity ten Kilograms</li>\r\n</ol>\r\n','yudi','2018-02-23 16:23:19','yudi','2018-02-23 16:26:33'),('QJA/180048','','2018-02-27 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,0.00,2100.00,'Pot','<ol>\r\n	<li>Please mention Our PO No.QJA/180048 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-02-27 08:26:50','yudi','2018-02-27 08:26:50'),('QJA/180049','','2018-02-27 00:00:00',NULL,'CIF Sea Jakarta','prompt','','\0',70,'Ms. Yunita Indrasari','',6,'USD',13000.00,2,0.00,85800.00,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180049 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Srikem Laboratories</li>\r\n</ol>\r\n','yudi','2018-02-27 08:59:23','nurdin','2018-02-27 10:26:42'),('QJA/180050','','2018-02-28 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',89,'Mr. Ashish Kulkarni','',4,'USD',13000.00,2,0.00,12100.00,'1kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180050 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Granule Labs</li>\r\n</ol>\r\n','yudi','2018-02-28 08:56:11','yudi','2018-02-28 11:38:43'),('QJA/180051','','2018-02-28 00:00:00',NULL,'CIF Air Jakarta','Early April 2018','','\0',41,'Mr. Al Rego ( Vitalchemie Corporation )','',3,'USD',13000.00,2,0.00,900.00,'2kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180051 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Jayco Chemical Industries</li>\r\n</ol>\r\n','yudi','2018-02-28 13:04:27','yudi','2018-02-28 13:04:27'),('QJA/180052','','2018-03-01 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',37,'Mr. Al Rego ( Vitalchemie Corporation )','',3,'USD',13000.00,2,10.00,16100.00,'25kg / HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180052 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Granules India</li>\r\n</ol>\r\n','yudi','2018-03-01 10:31:46','yudi','2018-03-23 11:01:19'),('QJA/180053','','2018-03-02 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',40,'Mr. Jeffrey Liu','',4,'USD',13000.00,2,10.00,737.50,'25kg / Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180053 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Shenzhen Fast Chemicak Co., Ltd</li>\r\n</ol>\r\n','yudi','2018-03-02 11:15:47','yudi','2018-03-02 11:15:47'),('QJA/180054','','2018-03-05 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,10.00,450.00,'Pot','<ol>\r\n	<li>Please mention Our PO No.QJA/180054 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-03-05 13:28:24','yudi','2018-03-05 13:28:24'),('QJA/180055','','2018-03-09 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',92,'Mr. Robert William','',2,'IDR',13650.00,2,10.00,68441050.00,'Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180055 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Megafine</li>\r\n</ol>\r\n','yudi','2018-03-09 10:01:55','yudi','2018-03-12 09:40:14'),('QJA/180056','','2018-03-09 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',91,'Ms. Susanti','',4,'USD',13000.00,2,10.00,1312.50,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180056 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from 5N Plus Lubeck GmbH</li>\r\n</ol>\r\n','yudi','2018-03-09 10:17:48','yudi','2018-03-09 10:17:48'),('QJA/180057','','2018-03-09 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',93,'Mr. Shantanu Rambhad (Cosmigen)','',4,'USD',13000.00,2,10.00,1550.00,' Drum HDPE  ','<ol>\r\n	<li>Please mention Our PO No.QJA/180057 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Herbert Brown</li>\r\n</ol>\r\n','yudi','2018-03-09 11:23:59','yudi','2018-03-09 11:24:42'),('QJA/180058','','2018-03-09 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',38,'Mr. Al Rego ( Vitalchemie Corporation )','',3,'USD',13000.00,2,10.00,2000.00,'25kg / Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180058 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Smilax Labs</li>\r\n</ol>\r\n','yudi','2018-03-09 13:42:19','yudi','2018-03-09 13:42:19'),('QJA/180059','','2018-03-12 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',14,'Mr. Lor Karloon','',6,'USD',13000.00,2,10.00,450.00,'Pot','<ol>\r\n	<li>Please mention Our PO No.QJA/180059 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symbiotica</li>\r\n</ol>\r\n','yudi','2018-03-12 09:31:50','yudi','2018-03-12 10:00:17'),('QJA/180060','','2018-03-12 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',2,'Mrs. Marinella Frigreio','',7,'USD',13000.00,2,10.00,1450.00,'Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180060 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Jiangsu Nhwa</li>\r\n</ol>\r\n','yudi','2018-03-12 10:12:38','yudi','2018-03-12 10:15:44'),('QJA/180061','','2018-03-12 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',11,'Ms. Tracy Zhang','',3,'USD',13000.00,2,10.00,13612.50,'Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180061 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Jiangsu Nhwa</li>\r\n</ol>\r\n','yudi','2018-03-12 13:15:55','yudi','2018-03-12 13:15:55'),('QJA/180062','','2018-03-13 00:00:00',NULL,'CNF Air Jakarta','Prompt after import licence recaipt','','\0',2,'Mrs. Marinella Frigreio','',7,'USD',13000.00,2,10.00,1400.00,' Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180062 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Cambrex</li>\r\n	<li>in quality five Kilograms</li>\r\n</ol>\r\n','yudi','2018-03-13 11:36:22','yudi','2018-03-13 11:39:30'),('QJA/180063','','2018-03-13 00:00:00',NULL,'CIF Sea Jakarta','prompt','','\0',70,'Mrs. Lisa Kng','',6,'USD',13000.00,2,10.00,11200.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180063 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Lacsa PTY Ltd</li>\r\n</ol>\r\n','yudi','2018-03-13 15:50:29','yudi','2018-03-13 15:50:29'),('QJA/180064','','2018-03-16 00:00:00','2018-03-16 00:00:00','CIF air Jakarta','Prompt','\0','\0',39,'Mr. Atman Parekh ','',3,'USD',13900.00,2,0.00,540.00,'HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180064&nbsp;&amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Symed Labs-India</li>\r\n</ol>\r\n','nurdin','2018-03-16 13:54:56','yudi','2018-04-02 08:43:07'),('QJA/180065','','2018-03-19 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',78,'Ms. Nicole Mou','',4,'USD',13000.00,2,10.00,3825.00,'Fiber Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180065 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Chengdu Yazhong</li>\r\n</ol>\r\n','yudi','2018-03-19 09:59:10','yudi','2018-03-19 11:31:09'),('QJA/180066','','2018-03-19 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',11,'Ms. Tracy Zhang','',4,'USD',13000.00,2,10.00,17400.00,'Fiber Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180066 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Suzhou Tianma</li>\r\n</ol>\r\n','yudi','2018-03-19 14:41:54','yudi','2018-03-19 14:51:00'),('QJA/180067','','2018-03-19 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',94,'Ms. Linda Wen','',4,'USD',13000.00,2,10.00,3250.00,'Fiber Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180067 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Organic Hcrb</li>\r\n</ol>\r\n','yudi','2018-03-19 15:18:44','yudi','2018-03-19 15:18:44'),('QJA/180068','','2018-03-21 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',2,'Mrs. Marinella Frigerio','',11,'USD',13000.00,2,10.00,136000.00,'1 Kg / Aluminium Tin','<ol>\r\n	<li>Please mention Our PO No.QJA/180068 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Sanofi</li>\r\n</ol>\r\n','yudi','2018-03-21 15:02:02','yudi','2018-03-22 07:51:36'),('QJA/180069','','2018-03-22 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',43,'Ms. Serena Pan','',4,'USD',13000.00,2,10.00,1350.00,'1 Kg / Aluminium Tin','<ol>\r\n	<li>Please mention Our PO No.QJA/180069 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Zhejiang Hisun</li>\r\n</ol>\r\n','yudi','2018-03-22 10:38:22','yudi','2018-03-22 10:38:22'),('QJA/180070','','2018-03-26 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',92,'Mr. Robert William','',2,'IDR',1.00,2,10.00,24809400.00,'Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180070 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Jayco Chemicals</li>\r\n</ol>\r\n','yudi','2018-03-26 10:38:32','yudi','2018-03-26 10:45:38'),('QJA/180071','','2018-03-27 00:00:00',NULL,'CIF air Jakarta','mid may 2018','','\0',46,'Mr. Zhigang Xie ','',4,'USD',13000.00,2,10.00,1350.00,'30 kg/Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180071 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Hunan Yuantong</li>\r\n</ol>\r\n','yudi','2018-03-27 08:29:01','yudi','2018-03-27 08:31:48'),('QJA/180072','','2018-03-27 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',16,'Mr. Paras Kamdar','',2,'USD',13000.00,2,10.00,5100.00,'Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180072 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from RL Fine</li>\r\n</ol>\r\n','yudi','2018-03-27 08:35:40','yudi','2018-03-27 08:35:40'),('QJA/180073','','2018-03-28 00:00:00',NULL,'CIF air Jakarta','Early May 2018','','\0',67,'Ms. Amy Huang','',4,'USD',13000.00,2,10.00,2300.00,'Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180073 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Syn-Tech Chem</li>\r\n</ol>\r\n','yudi','2018-03-28 07:52:35','yudi','2018-03-28 07:54:24'),('QJA/180074','','2018-03-28 00:00:00',NULL,'CIF air Jakarta','Prompt','','\0',11,'Ms. Tracy Zhang','',4,'USD',13000.00,2,10.00,1025.00,'Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180074 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Wuhan Grand Hoyo</li>\r\n</ol>\r\n','yudi','2018-03-28 11:26:57','yudi','2018-03-28 11:26:57'),('QJA/180075','','2018-04-03 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Ms. Yunita Indrasari','',7,'USD',13000.00,2,10.00,63200.00,'Drum HDPE','<ol>\r\n	<li>Please mention Our PO No.QJA/180075 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Cipan</li>\r\n</ol>\r\n','yudi','2018-04-03 09:48:19','yudi','2018-04-03 09:49:54'),('QJA/180076','','2018-04-04 00:00:00',NULL,'CIF Air Jakarta','in April 2018','','\0',11,'Ms. Tracy Zhang','',3,'USD',13000.00,2,0.00,22750.00,'25 Kg  / Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180076 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Guangxi Bonger</li>\r\n</ol>\r\n','yudi','2018-04-04 08:09:32','yudi','2018-04-04 08:09:32'),('QJA/180077','','2018-04-04 00:00:00',NULL,'CIF Air Jakarta','prompt','','\0',70,'Ms. Yunita Indrasari','',6,'USD',13000.00,2,0.00,4650.00,'Fibre Drum','<ol>\r\n	<li>Please mention Our PO No.QJA/180077 &amp; HS Code No. on Invoice &amp; Packing List.</li>\r\n	<li>Please wrapping with good conditions for the packing.</li>\r\n	<li>Specification/Parameter on COA should be same with last approval.</li>\r\n	<li>CoA &amp; Label on Packing along with sealed should be from Livzon Pharmaceutical</li>\r\n</ol>\r\n','yudi','2018-04-04 15:47:43','yudi','2018-04-04 15:47:43');
/*!40000 ALTER TABLE `tr_purchaseorderhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_purchaseordernoninventorydetail`
--

DROP TABLE IF EXISTS `tr_purchaseordernoninventorydetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_purchaseordernoninventorydetail` (
  `purchaseOrderNonInventoryID` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseOrderNonInventoryNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `discount` decimal(18,2) NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  PRIMARY KEY (`purchaseOrderNonInventoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_purchaseordernoninventorydetail`
--

LOCK TABLES `tr_purchaseordernoninventorydetail` WRITE;
/*!40000 ALTER TABLE `tr_purchaseordernoninventorydetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_purchaseordernoninventorydetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_purchaseordernoninventoryhead`
--

DROP TABLE IF EXISTS `tr_purchaseordernoninventoryhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_purchaseordernoninventoryhead` (
  `purchaseOrderNonInventoryNum` varchar(50) NOT NULL,
  `purchaseOrderNonInventoryDate` datetime NOT NULL,
  `refNum` varchar(50) DEFAULT NULL,
  `currencyID` varchar(5) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `hasVAT` bit(1) NOT NULL,
  `taxInvoice` varchar(50) DEFAULT NULL,
  `supplierID` int(11) NOT NULL,
  `whtID` int(11) DEFAULT NULL,
  `whtRate` varchar(45) DEFAULT NULL,
  `grandTotal` decimal(18,2) NOT NULL,
  `additionalInfo` text,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`purchaseOrderNonInventoryNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_purchaseordernoninventoryhead`
--

LOCK TABLES `tr_purchaseordernoninventoryhead` WRITE;
/*!40000 ALTER TABLE `tr_purchaseordernoninventoryhead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_purchaseordernoninventoryhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_purchasereturndetail`
--

DROP TABLE IF EXISTS `tr_purchasereturndetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_purchasereturndetail` (
  `purchaseReturnDetailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchaseReturnNum` varchar(50) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `HPP` decimal(18,2) NOT NULL,
  `VAT` decimal(18,2) NOT NULL,
  `totalAmount` decimal(18,2) NOT NULL,
  `notes` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`purchaseReturnDetailID`),
  KEY `fk_purchasereturndetail_purchasereturnnum_idx` (`purchaseReturnNum`),
  KEY `fk_purchasereturn_productid_idx` (`productID`),
  KEY `fk_purchasereturn_uomid_idx` (`uomID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_purchasereturndetail`
--

LOCK TABLES `tr_purchasereturndetail` WRITE;
/*!40000 ALTER TABLE `tr_purchasereturndetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_purchasereturndetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_purchasereturnhead`
--

DROP TABLE IF EXISTS `tr_purchasereturnhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_purchasereturnhead` (
  `purchaseReturnNum` varchar(50) NOT NULL COMMENT 'Purchase Return Number',
  `purchaseReturnDate` datetime NOT NULL COMMENT 'Purchase Return Date',
  `supplierID` int(11) NOT NULL COMMENT 'Supplier ID',
  `currencyID` varchar(5) NOT NULL COMMENT 'Currency ID',
  `rate` decimal(10,2) NOT NULL COMMENT 'Rate',
  `coaNo` varchar(20) DEFAULT NULL COMMENT 'COA No',
  `grandTotal` decimal(18,2) NOT NULL COMMENT 'Grand Total',
  `additionalInfo` text COMMENT 'Additional Info',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`purchaseReturnNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_purchasereturnhead`
--

LOCK TABLES `tr_purchasereturnhead` WRITE;
/*!40000 ALTER TABLE `tr_purchasereturnhead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_purchasereturnhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_salesorderdetail`
--

DROP TABLE IF EXISTS `tr_salesorderdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_salesorderdetail` (
  `salesOrderDetailID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Sales Order Detail ID',
  `salesOrderNum` varchar(50) NOT NULL COMMENT 'Sales Order Number',
  `productID` int(11) NOT NULL COMMENT 'Product ID',
  `uomID` int(11) NOT NULL COMMENT 'UOM ID',
  `qty` decimal(18,2) NOT NULL COMMENT 'Quantity',
  `price` decimal(18,2) NOT NULL COMMENT 'Price',
  `discount` decimal(18,2) DEFAULT NULL COMMENT 'Discount',
  `tax` decimal(18,2) DEFAULT NULL COMMENT 'Tax',
  `subTotal` decimal(18,2) NOT NULL COMMENT 'Sub Total',
  `notes` varchar(100) DEFAULT NULL COMMENT 'Notes',
  PRIMARY KEY (`salesOrderDetailID`),
  KEY `fk_salesordernum_idx` (`salesOrderNum`),
  KEY `fk_salesorderproductid_idx` (`productID`),
  KEY `fk_salesorderuomid_idx` (`uomID`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_salesorderdetail`
--

LOCK TABLES `tr_salesorderdetail` WRITE;
/*!40000 ALTER TABLE `tr_salesorderdetail` DISABLE KEYS */;
INSERT INTO `tr_salesorderdetail` VALUES (9,'QJA/SO/17/XI/001',142,1,1.00,138700000.00,0.00,10.00,138700000.00,''),(10,'QJA/SO/17/XI/001',80,1,20.00,2686800.00,0.00,10.00,53736000.00,''),(14,'QJA/SO/17/VIII/002',34,1,100.00,1323000.00,0.00,10.00,132300000.00,''),(17,'QJA/SO/17/IX/002',140,1,50.00,2025000.00,0.00,10.00,101250000.00,''),(18,'QJA/SO/17/XI/002',38,1,50.00,1350000.00,0.00,10.00,67500000.00,''),(19,'QJA/SO/17/VIII/003',38,1,50.00,1350000.00,0.00,10.00,67500000.00,''),(20,'QJA/SO/17/IX/003',205,5,500.00,35000.00,0.00,10.00,17500000.00,''),(21,'QJA/SO/17/X/003',103,1,1.00,47100.00,0.00,10.00,47100.00,''),(25,'QJA/SO/17/VIII/004',46,1,50.00,832650.00,0.00,10.00,41632500.00,''),(26,'QJA/SO/17/XI/005',38,1,300.00,1106055.00,0.00,10.00,331816500.00,''),(27,'QJA/SO/17/VII/006',149,1,5.00,5933185.00,0.00,10.00,29665925.00,''),(29,'QJA/SO/17/VIII/007',46,1,25.00,949635.00,0.00,10.00,23740875.00,''),(36,'QJA/SO/17/VIII/008',43,1,25.00,962000.00,0.00,10.00,24050000.00,''),(37,'QJA/SO/17/VIII/008',42,1,25.00,642350.00,0.00,10.00,16058750.00,''),(38,'QJA/SO/17/IX/009',132,1,12.00,1135855.00,0.00,10.00,13630260.00,''),(42,'QJA/SO/17/XI/011',146,1,955.00,540000.00,0.00,10.00,515700000.00,''),(44,'QJA/SO/17/VIII/012',145,1,50.00,355290.00,0.00,10.00,17764500.00,''),(46,'QJA/SO/17/XI/013',152,1,5.00,6894690.00,0.00,10.00,34473450.00,''),(47,'QJA/SO/17/VIII/014',146,1,25.00,540000.00,0.00,10.00,13500000.00,''),(48,'QJA/SO/17/X/015',133,1,25.00,830000.00,0.00,10.00,20750000.00,''),(49,'QJA/SO/17/VII/016',214,1,10.00,15054990.00,0.00,10.00,150549900.00,''),(51,'QJA/SO/17/VIII/017',44,1,2.00,8882250.00,0.00,10.00,17764500.00,''),(52,'QJA/SO/17/X/018',38,1,100.00,1360000.00,0.00,10.00,136000000.00,''),(53,'QJA/SO/17/IX/019',182,1,25.00,10800000.00,0.00,10.00,270000000.00,''),(54,'QJA/SO/17/IX/020',53,1,1.00,29500000.00,0.00,10.00,29500000.00,''),(55,'QJA/SO/17/X/021',120,1,10.00,1964000.00,0.00,10.00,19640000.00,''),(56,'QJA/SO/17/XI/022',135,1,5.00,13394500.00,0.00,10.00,66972500.00,''),(57,'QJA/SO/17/X/023',144,1,50.00,1227600.00,0.00,10.00,61380000.00,''),(58,'QJA/SO/17/X/024',144,1,50.00,1227600.00,0.00,10.00,61380000.00,''),(59,'QJA/SO/17/X/025',39,1,5.00,1742000.00,0.00,10.00,8710000.00,''),(61,'QJA/SO/17/X/027',78,1,5.00,42400000.00,0.00,10.00,212000000.00,''),(62,'QJA/SO/17/XI/028',78,1,5.00,42400000.00,0.00,10.00,212000000.00,''),(63,'QJA/SO/17/X/029',130,1,25.00,2413840.00,0.00,10.00,60346000.00,''),(64,'QJA/SO/17/XII/030',152,1,15.00,6903360.00,0.00,10.00,103550400.00,''),(66,'QJA/SO/17/XI/032',156,1,2.00,25429920.00,0.00,10.00,50859840.00,''),(67,'QJA/SO/17/XII/033',152,1,5.00,7122070.00,0.00,10.00,35610350.00,''),(68,'QJA/SO/17/XII/034',217,1,6.00,50653000.00,0.00,10.00,303918000.00,''),(69,'QJA/SO/17/IX/035',34,1,100.00,1323000.00,0.00,10.00,132300000.00,''),(70,'QJA/SO/17/VIII/036',157,1,60.00,3863400.00,0.00,10.00,231804000.00,''),(71,'QJA/SO/17/XI/037',138,1,25.00,2362500.00,0.00,10.00,59062500.00,''),(72,'QJA/SO/17/XII/038',64,3,500.00,115000.00,0.00,10.00,57500000.00,''),(73,'QJA/SO/17/X/039',137,1,5.00,11542500.00,0.00,10.00,57712500.00,''),(75,'QJA/SO/17/X/041',38,1,50.00,1360000.00,0.00,10.00,68000000.00,''),(76,'QJA/SO/17/X/042',144,1,50.00,1227600.00,0.00,10.00,61380000.00,''),(77,'QJA/SO/17/X/043',144,1,50.00,1227600.00,0.00,10.00,61380000.00,''),(78,'QJA/SO/17/X/044',144,1,50.00,1227600.00,0.00,10.00,61380000.00,''),(79,'QJA/SO/17/III/045',64,3,800.00,125550.00,0.00,10.00,100440000.00,''),(81,'QJA/SO/17/XII/046',169,1,25.00,1505900.00,0.00,10.00,37647500.00,''),(82,'QJA/SO/17/XI/047',134,1,5.00,59073400.00,0.00,10.00,295367000.00,''),(83,'QJA/SO/17/III/048',64,3,2200.00,125550.00,0.00,10.00,276210000.00,''),(85,'QJA/SO/17/IX/026',39,1,5.00,1742000.00,0.00,10.00,8710000.00,''),(86,'QJA/SO/17/X/049',219,1,50.00,2050500.00,0.00,10.00,102525000.00,''),(87,'QJA/SO/17/X/040',116,1,30.00,822000.00,0.00,10.00,24660000.00,''),(91,'QJA/SO/18/I/001',25,1,25.00,1545498.00,0.00,10.00,38637450.00,''),(95,'QJA/SO/17/XII/050',64,3,200.00,113710.00,0.00,10.00,22742000.00,''),(99,'QJA/SO/18/III/002',37,1,2.00,211806000.00,0.00,10.00,423612000.00,''),(101,'QJA/SO/17/X/051',64,3,500.00,119000.00,0.00,10.00,59500000.00,''),(102,'QJA/SO/17/X/052',124,1,50.00,962000.00,0.00,10.00,48100000.00,''),(103,'QJA/SO/17/XI/053',152,1,5.00,6821000.00,0.00,10.00,34105000.00,''),(104,'QJA/SO/17/XI/054',34,1,100.00,1327445.00,0.00,10.00,132744500.00,''),(105,'QJA/SO/17/X/055',131,1,50.00,1074000.00,0.00,10.00,53700000.00,''),(106,'QJA/SO/17/X/056',137,1,5.00,11542500.00,0.00,10.00,57712500.00,''),(107,'QJA/SO/17/X/057',182,1,50.00,10800000.00,0.00,10.00,540000000.00,''),(108,'QJA/SO/17/XI/058',131,1,50.00,1066400.00,0.00,10.00,53320000.00,''),(109,'QJA/SO/17/XII/059',13,1,10.00,22995000.00,0.00,10.00,229950000.00,''),(111,'QJA/SO/17/X/060',136,1,25.00,465000.00,0.00,10.00,11625000.00,''),(112,'QJA/SO/17/XII/061',176,1,50.00,828000.00,0.00,10.00,41400000.00,''),(113,'QJA/SO/17/XII/062',102,3,300.00,124761.00,0.00,10.00,37428300.00,''),(114,'QJA/SO/17/X/063',128,1,15.00,3226800.00,0.00,10.00,48402000.00,''),(115,'QJA/SO/17/XII/064',205,5,500.00,35000.00,0.00,10.00,17500000.00,''),(116,'QJA/SO/18/I/002',186,1,10.00,884250.00,0.00,10.00,8842500.00,''),(117,'QJA/SO/17/XI/065',69,1,75.00,1659000.00,0.00,10.00,124425000.00,''),(118,'QJA/SO/18/I/003',152,1,5.00,7076680.00,0.00,10.00,35383400.00,''),(119,'QJA/SO/18/I/004',152,1,5.00,7064200.00,0.00,10.00,35321000.00,''),(120,'QJA/SO/17/XI/066',152,1,5.00,6821000.00,0.00,10.00,34105000.00,''),(121,'QJA/SO/17/XI/067',184,1,50.00,2223045.00,0.00,10.00,111152250.00,''),(122,'QJA/SO/17/XI/068',153,1,10.00,8794000.00,0.00,10.00,87940000.00,''),(123,'QJA/SO/17/XII/069',135,1,5.00,13494500.00,0.00,10.00,67472500.00,''),(124,'QJA/SO/18/I/005',176,1,75.00,962547.00,0.00,10.00,72191025.00,''),(125,'QJA/SO/17/XI/070',193,1,5.00,26627250.00,0.00,10.00,133136250.00,''),(126,'QJA/SO/17/XI/071',155,1,100.00,1172350.00,0.00,10.00,117235000.00,''),(129,'QJA/SO/17/XII/072',185,1,2240.00,120000.00,0.00,10.00,268800000.00,''),(131,'QJA/SO/17/XI/073',183,1,25.00,670000.00,0.00,10.00,16750000.00,''),(133,'QJA/SO/17/X/074',64,3,500.00,115000.00,0.00,10.00,57500000.00,''),(134,'QJA/SO/18/I/006',175,1,25.00,951750.00,0.00,10.00,23793750.00,''),(135,'QJA/SO/17/XI/075',38,1,75.00,1268500.00,0.00,10.00,95137500.00,''),(136,'QJA/SO/17/XI/076',69,1,75.00,1659000.00,0.00,10.00,124425000.00,''),(137,'QJA/SO/17/XII/077',121,1,10.00,3473635.00,0.00,10.00,34736350.00,''),(138,'QJA/SO/17/XI/078',231,1,50.00,1705000.00,0.00,10.00,85250000.00,'');
/*!40000 ALTER TABLE `tr_salesorderdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_salesorderhead`
--

DROP TABLE IF EXISTS `tr_salesorderhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_salesorderhead` (
  `salesOrderNum` varchar(50) NOT NULL COMMENT 'Sales Order Number',
  `customerOrderNum` varchar(50) DEFAULT NULL,
  `refNum` varchar(50) DEFAULT NULL COMMENT 'Reference Sales Quotation Number',
  `salesOrderDate` datetime NOT NULL COMMENT 'Sales Order Date',
  `dueDate` datetime DEFAULT NULL,
  `customerID` int(11) NOT NULL,
  `contactPerson` varchar(50) DEFAULT NULL,
  `paymentID` smallint(6) NOT NULL COMMENT 'Payment ID',
  `taxID` int(11) DEFAULT NULL COMMENT 'Tax ID',
  `taxRate` decimal(18,2) DEFAULT NULL COMMENT 'Tax Rate',
  `grandTotal` decimal(18,2) NOT NULL COMMENT 'Grand Total',
  `additionalInfo` varchar(200) DEFAULT NULL COMMENT 'Additional Info',
  `materai` decimal(18,2) DEFAULT NULL,
  `createdBy` varchar(50) NOT NULL COMMENT 'Create By',
  `createdDate` datetime NOT NULL COMMENT 'Create Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`salesOrderNum`),
  KEY `fk_salespayment_idx` (`paymentID`),
  KEY `fk_taxid_salesorderhead_idx` (`taxID`),
  KEY `fk_salescustomer_idx` (`customerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_salesorderhead`
--

LOCK TABLES `tr_salesorderhead` WRITE;
/*!40000 ALTER TABLE `tr_salesorderhead` DISABLE KEYS */;
INSERT INTO `tr_salesorderhead` VALUES ('QJA/SO/17/I/006','60/XII/17/SIMEX','','2017-12-27 14:18:38','2018-01-29 14:18:38',33,'Ibu. Flora',2,2,10.00,196053000.00,'',NULL,'budy','2018-03-19 13:58:47','budy','2018-03-19 14:18:38'),('QJA/SO/17/III/045','BF.17.0255','','2017-03-27 16:50:29','2017-12-19 16:50:29',28,'Ibu. Maya Wijaya',2,2,10.00,110484000.00,'',NULL,'budy','2018-03-01 16:50:29','budy','2018-03-01 16:50:29'),('QJA/SO/17/III/048','BF.17.0255','','2017-03-07 08:26:12','2017-12-28 08:26:12',28,'Ibu. Maya Wijaya',2,2,10.00,303831000.00,'',NULL,'budy','2018-03-02 08:26:12','budy','2018-03-02 08:26:12'),('QJA/SO/17/IX/002','918/PO/ROFO/IX/17','','2017-09-19 15:41:29','2017-11-06 15:41:29',29,'Ibu. Shenny',2,2,10.00,111375000.00,'',NULL,'budy','2018-02-15 15:38:33','budy','2018-02-15 15:41:29'),('QJA/SO/17/IX/003','5022/SB/SSF/09/17','','2017-09-27 11:33:22','2017-11-07 11:33:22',60,'Ibu. Claresta Aileen Josephine',2,2,10.00,19250000.00,'',NULL,'budy','2018-02-22 11:33:22','budy','2018-02-22 11:33:22'),('QJA/SO/17/IX/009','A2702521','','2017-09-08 16:01:38','2017-11-10 16:01:38',55,'Ibu. Fiona Auliana',2,2,10.00,14993286.00,'',NULL,'budy','2018-02-23 16:01:38','budy','2018-02-23 16:01:38'),('QJA/SO/17/IX/019','918/PO/ROFO/IX/17','','2017-09-19 08:55:16','2017-11-20 08:55:16',29,'Ibu. Shenny',2,2,10.00,297000000.00,'',NULL,'budy','2018-03-01 08:55:16','budy','2018-03-01 08:55:16'),('QJA/SO/17/IX/020','4060004680','','2017-09-29 09:00:17','2017-11-20 09:00:17',13,'Ibu. Merry Gunawan',2,2,10.00,32450000.00,'',NULL,'budy','2018-03-01 09:00:17','budy','2018-03-01 09:00:17'),('QJA/SO/17/IX/026','ER-1709BA0020','','2017-09-13 14:17:25','2017-11-24 14:17:25',22,'Ibu. Maria Monica',2,2,10.00,9581000.00,'',NULL,'budy','2018-03-01 14:59:17','budy','2018-03-07 14:17:25'),('QJA/SO/17/IX/035','8100031876','','2017-09-22 16:09:45','2017-12-08 16:09:45',21,'Bp. Heri',2,2,10.00,145530000.00,'',NULL,'budy','2018-03-01 16:09:45','budy','2018-03-01 16:09:45'),('QJA/SO/17/VII/006','715/PO/RND/VII/17','','2017-07-21 11:28:14','2017-11-08 11:28:14',29,'Ibu. Shenny',2,2,10.00,32632517.50,'',NULL,'budy','2018-02-23 11:28:14','budy','2018-02-23 11:28:14'),('QJA/SO/17/VII/016','206/SP/VII/2017','','2017-07-17 17:17:07','2017-11-17 17:17:07',63,'Bp. Teddy Saputra',2,2,10.00,165604890.00,'',NULL,'budy','2018-02-26 17:17:07','budy','2018-02-26 17:17:07'),('QJA/SO/17/VIII/002','8100031608','','2017-08-24 13:54:28','2017-10-05 13:54:28',21,'Bp. Heri',2,2,10.00,145530000.00,'',NULL,'budy','2018-02-15 13:54:28','budy','2018-02-15 13:54:28'),('QJA/SO/17/VIII/003','PF/PROD/1708164','','2017-08-29 11:16:12','2017-11-07 11:16:12',59,'Bp.',2,2,10.00,74250000.00,'',NULL,'budy','2018-02-22 11:16:12','budy','2018-02-22 11:16:12'),('QJA/SO/17/VIII/004','4060004639','','2017-08-18 11:08:09','2017-11-07 11:08:09',13,'Ibu. Merry Gunawan',2,2,10.00,45795750.00,'',NULL,'budy','2018-02-23 11:08:09','budy','2018-02-23 11:08:09'),('QJA/SO/17/VIII/007','T173/2017','','2017-08-07 14:37:48','2017-11-08 14:37:48',23,'Ibu. Elisabeth',2,2,10.00,26114962.50,'',NULL,'budy','2018-02-23 14:37:48','budy','2018-02-23 14:37:48'),('QJA/SO/17/VIII/008','ER-1708BA0062','','2017-08-28 15:48:34','2017-11-09 15:48:34',22,'Ibu. Maria Monica',2,2,10.00,46524625.00,'',NULL,'budy','2018-02-23 15:48:34','budy','2018-02-23 15:48:34'),('QJA/SO/17/VIII/012','RM/2017-08/0093','','2017-08-29 14:23:58','2017-11-10 14:23:58',18,'Ibu. Susianty',2,2,10.00,19540950.00,'',NULL,'budy','2018-02-26 14:23:58','budy','2018-02-26 14:23:58'),('QJA/SO/17/VIII/014','789/PO/ROFO/VIII/17','','2017-08-18 16:36:48','2017-11-13 16:36:48',29,'Ibu. Shenny',2,2,10.00,14850000.00,'',NULL,'budy','2018-02-26 16:36:48','budy','2018-02-26 16:36:48'),('QJA/SO/17/VIII/017','RM/2017-08/0056','','2017-08-23 17:48:03','2017-11-17 17:48:03',18,'Ibu. Susianty',2,2,10.00,19540950.00,'',NULL,'budy','2018-02-26 17:48:03','budy','2018-02-26 17:48:03'),('QJA/SO/17/VIII/036','4060004642','','2017-08-22 16:11:59','2017-12-08 16:11:59',13,'Ibu. Merry Gunawan',2,2,10.00,254984400.00,'',NULL,'budy','2018-03-01 16:11:59','budy','2018-03-01 16:11:59'),('QJA/SO/17/X/003','P1017095','','2017-10-17 11:43:41','2017-11-07 11:43:41',16,'Ibu. Anik Sudaryanti',2,2,10.00,51810.00,'',NULL,'budy','2018-02-22 11:43:41','budy','2018-02-22 11:43:41'),('QJA/SO/17/X/015','P1017091','','2017-10-16 16:45:34','2017-11-15 16:45:34',16,'Ibu. Anik Sudaryanti',2,2,10.00,22825000.00,'',NULL,'budy','2018-02-26 16:45:34','budy','2018-02-26 16:45:34'),('QJA/SO/17/X/018','PF/PROD/1710136','','2017-10-31 08:51:18','2017-11-20 08:51:18',59,'Bp.',2,2,10.00,149600000.00,'',NULL,'budy','2018-03-01 08:51:18','budy','2018-03-01 08:51:18'),('QJA/SO/17/X/021','356/PO-GP/BB/X/17','','2017-10-11 09:03:00','2017-11-20 09:03:00',56,'Ibu. Fela Satari',2,2,10.00,21604000.00,'',NULL,'budy','2018-03-01 09:03:00','budy','2018-03-01 09:03:00'),('QJA/SO/17/X/023','907/B/X/GPL/17','','2017-10-16 09:12:48','2017-11-22 09:12:48',19,'Ibu. Sannia',2,2,10.00,67518000.00,'',NULL,'budy','2018-03-01 09:12:48','budy','2018-03-01 09:12:48'),('QJA/SO/17/X/024','908/B/X/GPL/17','','2017-10-16 09:14:15','2017-11-22 09:14:15',19,'Ibu. Sannia',2,2,10.00,67518000.00,'',NULL,'budy','2018-03-01 09:14:15','budy','2018-03-01 09:14:15'),('QJA/SO/17/X/025','EX-1710BA0005','','2017-10-06 14:54:01','2017-11-24 14:54:01',36,'Ibu. Maria Monica',2,2,10.00,9581000.00,'',NULL,'budy','2018-03-01 14:54:01','budy','2018-03-01 14:54:01'),('QJA/SO/17/X/027','BF.17.0714','','2017-10-13 15:09:07','2017-11-30 15:09:07',28,'Ibu. Maya Wijaya',2,2,10.00,233200000.00,'',NULL,'budy','2018-03-01 15:09:07','budy','2018-03-01 15:09:07'),('QJA/SO/17/X/029','BF.17.0738','','2017-10-25 15:39:23','2017-12-04 15:39:23',28,'Ibu. Maya Wijaya',2,2,10.00,66380600.00,'',NULL,'budy','2018-03-01 15:39:23','budy','2018-03-01 15:39:23'),('QJA/SO/17/X/039','ER-1710BA0022','','2017-10-16 16:25:10','2017-12-12 16:25:10',22,'Ibu. Maria Monica',2,2,10.00,63483750.00,'',NULL,'budy','2018-03-01 16:25:10','budy','2018-03-01 16:25:10'),('QJA/SO/17/X/040','RM/2017-10/0023','','2017-10-20 15:20:57','2017-11-13 15:20:57',18,'Ibu. Susianty',2,2,10.00,27126000.00,'',NULL,'budy','2018-03-01 16:34:04','budy','2018-03-09 15:20:57'),('QJA/SO/17/X/041','PF/PROD/1710137','','2017-10-31 16:37:14','2017-12-14 16:37:14',59,'Bp.',2,2,10.00,74800000.00,'',NULL,'budy','2018-03-01 16:37:14','budy','2018-03-01 16:37:14'),('QJA/SO/17/X/042','909/B/X/GPL/17','','2017-10-16 16:42:59','2017-12-18 16:42:59',19,'Ibu. Sannia',2,2,10.00,67518000.00,'',NULL,'budy','2018-03-01 16:42:59','budy','2018-03-01 16:42:59'),('QJA/SO/17/X/043','910/B/X/GPL/17','','2017-10-16 16:44:50','2017-12-18 16:44:50',19,'Ibu. Sannia',2,2,10.00,67518000.00,'',NULL,'budy','2018-03-01 16:44:50','budy','2018-03-01 16:44:50'),('QJA/SO/17/X/044','911/B/X/GPL/17','','2017-10-16 16:46:33','2017-12-18 16:46:33',19,'Ibu. Sannia',2,2,10.00,67518000.00,'',NULL,'budy','2018-03-01 16:46:33','budy','2018-03-01 16:46:33'),('QJA/SO/17/X/049','1047/PO/ROFO/X/17','','2017-10-26 09:58:47','2017-12-05 09:58:47',29,'Ibu. Shenny',2,2,10.00,112777500.00,'',NULL,'budy','2018-03-08 09:58:47','budy','2018-03-08 09:58:47'),('QJA/SO/17/X/051','ER-1710BA0012','','2017-10-13 10:35:09','2018-01-05 10:35:09',22,'Ibu. Maria Monica',2,2,10.00,65450000.00,'',NULL,'budy','2018-03-16 10:35:09','budy','2018-03-16 10:35:09'),('QJA/SO/17/X/052','ER-1710BA0027','','2017-10-16 10:48:20','2018-01-08 10:48:20',22,'Ibu. Maria Monica',2,2,10.00,52910000.00,'',NULL,'budy','2018-03-16 10:48:20','budy','2018-03-16 10:48:20'),('QJA/SO/17/X/055','1094/PO/ROFO/X/17','','2017-10-30 11:30:18','2018-01-04 11:30:18',29,'Ibu. Shenny',2,2,10.00,59070000.00,'',NULL,'budy','2018-03-16 11:30:18','budy','2018-03-16 11:30:18'),('QJA/SO/17/X/056','ER-1710BA0022','','2017-10-16 13:05:11','2017-12-11 13:05:11',22,'Ibu. Maria Monica',2,2,10.00,63483750.00,'',NULL,'budy','2018-03-16 13:05:11','budy','2018-03-16 13:05:11'),('QJA/SO/17/X/057','975/PO/ROFO/X/17','','2017-10-03 13:16:15','2018-01-02 13:16:15',29,'Ibu. Shenny',2,2,10.00,594000000.00,'',NULL,'budy','2018-03-16 13:16:15','budy','2018-03-16 13:16:15'),('QJA/SO/17/X/060','ER-1710BA0039','','2017-10-17 14:15:30','2018-01-16 14:15:30',22,'Ibu. Maria Monica',2,2,10.00,12787500.00,'',NULL,'budy','2018-03-16 14:15:30','budy','2018-03-16 14:15:30'),('QJA/SO/17/X/063','POSKJF/17/X/009','','2017-10-25 14:45:07','2018-01-15 14:45:07',30,'Bp. Robert William',2,2,10.00,53242200.00,'',NULL,'budy','2018-03-16 14:45:07','budy','2018-03-16 14:45:07'),('QJA/SO/17/X/074','ER-1710BA0060','','2017-10-27 15:50:04','2018-02-05 15:50:04',22,'Ibu. Maria Monica',2,2,10.00,63250000.00,'',NULL,'budy','2018-03-19 15:50:04','budy','2018-03-19 15:50:04'),('QJA/SO/17/XI/001','918/PO/ROFO/IX/17','','2017-11-01 14:37:15','2017-11-01 14:37:15',29,'Ibu. Shenny',2,2,10.00,225549600.00,'',NULL,'budy','2018-02-13 14:37:15','budy','2018-02-13 14:37:15'),('QJA/SO/17/XI/002','PF/PROD/1708163','','2017-11-29 09:57:22','2017-09-25 09:57:22',59,'Bp.',2,2,10.00,74250000.00,'',NULL,'budy','2018-02-21 09:57:22','budy','2018-02-21 09:57:22'),('QJA/SO/17/XI/005','411703074','','2017-11-07 11:14:47','2017-11-07 11:14:47',17,'Ibu. Clarissa Lizda Febriana',2,2,10.00,364998150.00,'',NULL,'budy','2018-02-23 11:14:47','budy','2018-02-23 11:14:47'),('QJA/SO/17/XI/011','789/PO/ROFO/VIII/17','','2017-11-18 13:38:23','2017-11-10 13:38:23',29,'Ibu. Shenny',2,2,10.00,567270000.00,'',NULL,'budy','2018-02-26 13:38:23','budy','2018-02-26 13:38:23'),('QJA/SO/17/XI/013','POSKJF17/XI/001','','2017-11-09 14:48:56','2017-11-13 14:48:56',30,'Bp. Robert William',2,2,10.00,37920795.00,'',NULL,'budy','2018-02-26 14:43:38','budy','2018-02-26 14:48:56'),('QJA/SO/17/XI/022','POBB-7170','','2017-11-02 09:09:40','2017-11-21 09:09:40',37,'Bp. Uus Sriyanto',2,2,10.00,73669750.00,'',NULL,'budy','2018-03-01 09:09:40','budy','2018-03-01 09:09:40'),('QJA/SO/17/XI/028','BF.17.0807','','2017-11-13 15:10:51','2017-11-30 15:10:51',28,'Ibu. Maya Wijaya',2,2,10.00,233200000.00,'',NULL,'budy','2018-03-01 15:10:51','budy','2018-03-01 15:10:51'),('QJA/SO/17/XI/032','BF.17.0767','','2017-11-08 15:51:12','2017-12-05 15:51:12',28,'Ibu. Maya Wijaya',2,2,10.00,55945824.00,'',NULL,'budy','2018-03-01 15:51:12','budy','2018-03-01 15:51:12'),('QJA/SO/17/XI/037','EX-1710BA0002','','2017-11-02 16:15:23','2017-12-11 16:15:23',36,'Ibu. Maria Monica',2,2,10.00,64968750.00,'',NULL,'budy','2018-03-01 16:15:23','budy','2018-03-01 16:15:23'),('QJA/SO/17/XI/047','POBB-7170','','2017-11-02 08:22:23','2017-12-19 08:22:23',37,'Bp. Uus Sriyanto',2,2,10.00,324903700.00,'',NULL,'budy','2018-03-02 08:22:23','budy','2018-03-02 08:22:23'),('QJA/SO/17/XI/053','4060004728','','2017-11-01 11:03:07','2018-01-08 11:03:07',13,'Ibu. Merry Gunawan',2,2,10.00,37515500.00,'',NULL,'budy','2018-03-16 11:03:07','budy','2018-03-16 11:03:07'),('QJA/SO/17/XI/054','8100032321','','2017-11-08 11:15:03','2018-01-04 11:15:03',21,'Bp. Heri',2,2,10.00,146018950.00,'',NULL,'budy','2018-03-16 11:15:03','budy','2018-03-16 11:15:03'),('QJA/SO/17/XI/058','1164/PO/ROFO/XI/17','','2017-11-23 13:22:33','2018-01-29 13:22:33',29,'Ibu. Shenny',2,2,10.00,58652000.00,'',NULL,'budy','2018-03-16 13:22:33','budy','2018-03-16 13:22:33'),('QJA/SO/17/XI/065','PO175028','','2017-11-07 15:36:55','2018-01-19 15:36:55',20,'Ibu. Susi Gozali',2,2,10.00,136867500.00,'',NULL,'budy','2018-03-16 15:36:55','budy','2018-03-16 15:36:55'),('QJA/SO/17/XI/066','4060004728','','2017-11-01 11:34:31','2018-01-08 11:34:31',13,'Ibu. Merry Gunawan',2,2,10.00,37515500.00,'',NULL,'budy','2018-03-19 11:34:31','budy','2018-03-19 11:34:31'),('QJA/SO/17/XI/067','RM/2017-11/0078','','2017-11-30 11:47:07','2018-01-12 11:47:07',18,'Ibu. Susianty',2,2,10.00,122267475.00,'',NULL,'budy','2018-03-19 11:47:07','budy','2018-03-19 11:47:07'),('QJA/SO/17/XI/068','1164/PO/ROFO/XI/17','','2017-11-23 13:22:48','2018-01-15 13:22:48',29,'Ibu. Shenny',2,2,10.00,96734000.00,'',NULL,'budy','2018-03-19 13:22:48','budy','2018-03-19 13:22:48'),('QJA/SO/17/XI/070','POBB-7173','','2017-11-25 13:45:36','2018-01-25 13:45:36',37,'Bp. Uus Sriyanto',2,2,10.00,146449875.00,'',NULL,'budy','2018-03-19 13:45:36','budy','2018-03-19 13:45:36'),('QJA/SO/17/XI/071','PO175441','','2017-11-27 13:52:24','2018-02-02 13:52:24',20,'Ibu. Susi Gozali',2,2,10.00,128958500.00,'',NULL,'budy','2018-03-19 13:52:24','budy','2018-03-19 13:52:24'),('QJA/SO/17/XI/073','ER-1711BA0024','','2017-11-20 15:03:22','2018-02-05 15:03:22',22,'Ibu. Maria Monica',2,2,10.00,18425000.00,'',NULL,'budy','2018-03-19 15:01:36','budy','2018-03-19 15:03:22'),('QJA/SO/17/XI/075','PO175358','','2017-11-22 16:51:20','2018-02-01 16:51:20',20,'Ibu. Susi Gozali',2,2,10.00,104651250.00,'',NULL,'budy','2018-03-19 16:51:20','budy','2018-03-19 16:51:20'),('QJA/SO/17/XI/076','PO175028','','2017-11-07 17:07:43','2018-01-19 17:07:43',20,'Ibu. Susi Gozali',2,2,10.00,136867500.00,'',NULL,'budy','2018-03-20 17:07:43','budy','2018-03-20 17:07:43'),('QJA/SO/17/XI/078','PO175438','','2017-11-27 10:54:15','2018-02-05 10:54:15',20,'Ibu. Susi Gozali',2,2,10.00,93775000.00,'',NULL,'budy','2018-03-21 10:54:15','budy','2018-03-21 10:54:15'),('QJA/SO/17/XII/030','POSKJF/17/XII/001','','2017-12-04 15:44:02','2017-12-04 15:44:02',30,'Bp. Robert William',2,2,10.00,113905440.00,'',NULL,'budy','2018-03-01 15:44:02','budy','2018-03-01 15:44:02'),('QJA/SO/17/XII/033','411703402','','2017-12-05 15:53:10','2017-12-06 15:53:10',17,'Ibu. Clarissa Lizda Febriana',2,2,10.00,39171385.00,'',NULL,'budy','2018-03-01 15:53:10','budy','2018-03-01 15:53:10'),('QJA/SO/17/XII/034','411703456','','2017-12-07 16:06:24','2017-12-07 16:06:24',17,'Ibu. Clarissa Lizda Febriana',2,2,10.00,334309800.00,'',NULL,'budy','2018-03-01 16:06:24','budy','2018-03-01 16:06:24'),('QJA/SO/17/XII/038','EX-1712BA0003','','2017-12-04 16:20:12','2017-12-11 16:20:12',36,'Ibu. Maria Monica',2,2,10.00,63250000.00,'',NULL,'budy','2018-03-01 16:20:12','budy','2018-03-01 16:20:12'),('QJA/SO/17/XII/046','411703456','','2017-12-07 08:15:15','2017-12-19 08:15:15',17,'Ibu. Clarissa Lizda Febriana',2,2,10.00,41412250.00,'',NULL,'budy','2018-03-02 08:15:15','budy','2018-03-02 08:15:15'),('QJA/SO/17/XII/050','270 - 490 OP','','2017-12-21 14:36:45','2018-01-02 14:36:45',45,'Ibu. Meliana',2,2,10.00,25016200.00,'',NULL,'budy','2018-03-14 14:36:45','budy','2018-03-14 14:36:45'),('QJA/SO/17/XII/059','1024/BSP/BB/12/17','','2017-12-20 13:35:49','2018-01-15 13:35:49',25,'Ibu. Oom Romlah',2,2,10.00,252945000.00,'',NULL,'budy','2018-03-16 13:35:49','budy','2018-03-16 13:35:49'),('QJA/SO/17/XII/061','4060004806','','2017-12-15 14:22:15','2018-01-08 14:22:15',13,'Ibu. Merry Gunawan',2,2,10.00,45540000.00,'',NULL,'budy','2018-03-16 14:22:15','budy','2018-03-16 14:22:15'),('QJA/SO/17/XII/062','411703553','','2017-12-14 14:26:55','2018-01-15 14:26:55',17,'Ibu. Clarissa Lizda Febriana',2,2,10.00,41171130.00,'',NULL,'budy','2018-03-16 14:26:55','budy','2018-03-16 14:26:55'),('QJA/SO/17/XII/064','6735/SB/SSF/12/17','','2017-12-22 14:58:40','2018-01-29 14:58:40',60,'Ibu. Claresta Aileen Josephine',2,2,10.00,19250000.00,'',NULL,'budy','2018-03-16 14:58:40','budy','2018-03-16 14:58:40'),('QJA/SO/17/XII/069','POBB-7182','','2017-12-29 13:30:32','2018-01-22 13:30:32',37,'Bp. Uus Sriyanto',2,2,10.00,74219750.00,'',NULL,'budy','2018-03-19 13:30:32','budy','2018-03-19 13:30:32'),('QJA/SO/17/XII/072','450/PO-GP/BB/XII/17','','2017-12-07 14:27:41','2018-01-31 14:27:41',56,'Ibu. Fela Satari',2,2,10.00,295680000.00,'',NULL,'budy','2018-03-19 14:27:41','budy','2018-03-19 14:27:41'),('QJA/SO/17/XII/077','BF.17.0917','','2017-12-14 17:14:38','2018-02-05 17:14:38',28,'Ibu. Maya Wijaya',2,2,10.00,38209985.00,'',NULL,'budy','2018-03-20 17:14:38','budy','2018-03-20 17:14:38'),('QJA/SO/18/I/001','T224/2017','','2018-01-10 16:30:01','2017-12-19 16:30:01',23,'Ibu. Elisabeth',2,2,10.00,42501195.00,'',NULL,'budy','2018-03-09 16:30:01','budy','2018-03-09 16:30:01'),('QJA/SO/18/I/002','4060004793','','2018-01-18 15:28:05','2018-03-05 15:28:05',13,'Ibu. Merry Gunawan',2,2,10.00,9726750.00,'',NULL,'budy','2018-03-16 15:28:05','budy','2018-03-16 15:28:05'),('QJA/SO/18/I/003','SAC/PO/1801/10002','','2018-01-05 16:10:31','2018-01-19 16:10:31',10,'Bp. Miller',2,2,10.00,38921740.00,'',NULL,'budy','2018-03-16 16:10:31','budy','2018-03-16 16:10:31'),('QJA/SO/18/I/004','SAC/PO/1801/10005','','2018-01-12 16:35:17','2018-02-05 16:35:17',10,'Bp. Miller',2,2,10.00,38853100.00,'',NULL,'budy','2018-03-16 16:35:17','budy','2018-03-16 16:35:17'),('QJA/SO/18/I/005','T004/2018','','2018-01-08 13:38:14','2018-01-24 13:38:14',23,'Ibu. Elisabeth',2,2,10.00,79410127.50,'',NULL,'budy','2018-03-19 13:38:14','budy','2018-03-19 13:38:14'),('QJA/SO/18/I/006','P1217144','','2018-01-30 16:45:54','2018-02-05 16:45:54',16,'Ibu. Anik Sudaryanti',2,2,10.00,26173125.00,'',NULL,'budy','2018-03-19 16:45:54','budy','2018-03-19 16:45:54'),('QJA/SO/18/III/002','1123/PO/ROFO/XI/17','','2017-11-10 15:12:24','2017-12-04 15:12:24',29,'Ibu. Shenny',2,2,10.00,465973200.00,'',NULL,'budy','2018-03-14 14:43:46','budy','2018-03-14 15:12:24');
/*!40000 ALTER TABLE `tr_salesorderhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_salesquotationdetail`
--

DROP TABLE IF EXISTS `tr_salesquotationdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_salesquotationdetail` (
  `salesQuotationDetailID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Sales Quotation Detail ID',
  `salesQuotationNum` varchar(50) NOT NULL COMMENT 'Sales Quotation Number',
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `qty` decimal(18,2) NOT NULL COMMENT 'Quantity',
  `priceOffer` decimal(18,2) NOT NULL COMMENT 'Price',
  `discount` decimal(18,2) DEFAULT NULL,
  `tax` decimal(18,2) DEFAULT NULL,
  `subTotal` decimal(18,2) NOT NULL COMMENT 'Sub Total',
  `notes` varchar(100) DEFAULT NULL COMMENT 'Notes',
  PRIMARY KEY (`salesQuotationDetailID`),
  KEY `fk_quotationdetail_idx` (`salesQuotationNum`),
  KEY `fk_productid_idx` (`productID`),
  KEY `fk_uomid_idx` (`uomID`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_salesquotationdetail`
--

LOCK TABLES `tr_salesquotationdetail` WRITE;
/*!40000 ALTER TABLE `tr_salesquotationdetail` DISABLE KEYS */;
INSERT INTO `tr_salesquotationdetail` VALUES (19,'QJA/SQ/18/I/001',170,1,5.00,4792900.00,0.00,10.00,0.00,''),(20,'QJA/SQ/18/I/001',172,1,5.00,2389625.00,0.00,10.00,0.00,''),(23,'QJA/SQ/18/I/002',177,1,1.00,4995000.00,0.00,10.00,4995000.00,''),(25,'QJA/SQ/18/I/003',173,1,10.00,2350000.00,0.00,10.00,23500000.00,''),(27,'QJA/SQ/18/I/004',179,1,5.00,2328100.00,0.00,10.00,0.00,''),(31,'QJA/SQ/18/I/005',86,1,300.00,74300.00,0.00,10.00,0.00,''),(35,'QJA/SQ/18/I/006',103,1,3.00,47061000.00,0.00,10.00,141183000.00,''),(47,'QJA/SQ/18/I/007',190,1,25.00,1503765.00,0.00,10.00,37594125.00,''),(58,'QJA/SQ/18/I/008',86,3,500.00,69000.00,0.00,10.00,34500000.00,''),(59,'QJA/SQ/18/II/009',206,1,25.00,620757.00,0.00,10.00,15518925.00,''),(60,'QJA/SQ/18/II/010',210,1,25.00,597940.00,0.00,10.00,14948500.00,''),(61,'QJA/SQ/18/II/011',185,1,2240.00,122500.00,0.00,10.00,0.00,''),(63,'QJA/SQ/18/II/012',179,1,30.00,1703000.00,0.00,10.00,51090000.00,''),(64,'QJA/SQ/18/II/012',195,1,5.00,4315500.00,0.00,10.00,21577500.00,''),(65,'QJA/SQ/18/II/013',212,1,5.00,2260500.00,0.00,10.00,11302500.00,''),(66,'QJA/SQ/18/II/014',204,3,200.00,412500.00,0.00,10.00,82500000.00,''),(67,'QJA/SQ/18/II/014',13,1,10.00,23375685.00,0.00,10.00,233756850.00,''),(70,'QJA/SQ/18/II/015',212,1,2.00,2960550.00,0.00,10.00,5921100.00,''),(71,'QJA/SQ/18/II/015',212,1,25.00,440640.00,0.00,10.00,11016000.00,''),(72,'QJA/SQ/18/II/015',212,1,100.00,358020.00,0.00,10.00,35802000.00,''),(73,'QJA/SQ/18/II/016',213,1,25.00,224195.00,0.00,10.00,5604875.00,''),(74,'QJA/SQ/18/II/017',212,1,300.00,330000.00,0.00,10.00,0.00,''),(75,'QJA/SQ/18/II/017',64,3,600.00,165000.00,0.00,10.00,99000000.00,''),(76,'QJA/SQ/18/II/018',215,1,275.00,765000.00,0.00,10.00,210375000.00,''),(77,'QJA/SQ/18/III/019',45,3,100.00,90500.00,0.00,10.00,0.00,''),(79,'QJA/SQ/18/III/020',218,1,25.00,653206.00,0.00,10.00,16330150.00,''),(80,'QJA/SQ/18/III/021',49,3,100.00,118150.00,0.00,10.00,11815000.00,''),(81,'QJA/SQ/18/III/022',113,1,50.00,500000.00,0.00,10.00,25000000.00,''),(83,'QJA/SQ/18/III/023',185,1,2240.00,123300.00,0.00,10.00,276192000.00,''),(85,'QJA/SQ/18/III/024',224,1,50.00,235000.00,0.00,10.00,11750000.00,''),(97,'QJA/SQ/18/III/025',225,1,50.00,1389000.00,0.00,10.00,69450000.00,''),(98,'QJA/SQ/18/III/025',161,1,25.00,1236210.00,0.00,10.00,30905250.00,''),(99,'QJA/SQ/18/III/025',47,1,50.00,972300.00,0.00,10.00,48615000.00,''),(100,'QJA/SQ/18/III/025',112,1,5.00,7431150.00,0.00,10.00,37155750.00,''),(102,'QJA/SQ/18/III/026',226,1,25.00,2530710.00,0.00,10.00,63267750.00,''),(103,'QJA/SQ/18/III/027',227,1,25.00,1422000.00,0.00,10.00,35550000.00,''),(104,'QJA/SQ/18/III/028',233,1,25.00,1127023.00,0.00,10.00,28175575.00,''),(105,'QJA/SQ/18/III/029',234,1,5.00,4666750.00,0.00,10.00,23333750.00,''),(106,'QJA/SQ/18/IV/030',233,1,1.00,3478750.00,0.00,10.00,3478750.00,''),(107,'QJA/SQ/18/IV/031',152,1,5.00,8349000.00,0.00,10.00,41745000.00,''),(108,'QJA/SQ/18/IV/032',99,1,10.00,3620350.00,0.00,10.00,36203500.00,'');
/*!40000 ALTER TABLE `tr_salesquotationdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_salesquotationhead`
--

DROP TABLE IF EXISTS `tr_salesquotationhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_salesquotationhead` (
  `salesQuotationNum` varchar(50) NOT NULL COMMENT 'Sales Quotation Number',
  `salesQuotationDate` datetime NOT NULL COMMENT 'Sales QUotation Date',
  `marketingID` int(11) NOT NULL COMMENT 'Marketing ID',
  `customerID` int(11) NOT NULL COMMENT 'Customer ID',
  `contactPerson` varchar(50) DEFAULT NULL,
  `delivery` varchar(100) DEFAULT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `grandTotal` decimal(18,2) NOT NULL COMMENT 'Grand Total',
  `additionalInfo` text COMMENT 'Additional Info',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`salesQuotationNum`),
  KEY `fk_quotationcustomer_idx` (`customerID`),
  KEY `fk_quotationmarketing_idx` (`marketingID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_salesquotationhead`
--

LOCK TABLES `tr_salesquotationhead` WRITE;
/*!40000 ALTER TABLE `tr_salesquotationhead` DISABLE KEYS */;
INSERT INTO `tr_salesquotationhead` VALUES ('QJA/SQ/18/I/001','2018-01-04 05:15:27',2,9,'Ibu. Patricia Kurniawan , Ibu. Winarni Sri','Max Three weeks after confirmation','30 days after delivery the goods',39503887.50,'a) The Quotation is valid for fourteen (14) days from the date of submission\r\nb) The above price is excluding Value Added Tax (10% of sales price)','nurdin','2018-01-04 05:09:04','nurdin','2018-01-04 05:15:27'),('QJA/SQ/18/I/002','2018-01-10 16:45:01',2,22,'Bp. Aries Kristanto','Max Three weeks after confirmation','30 days after delivery the goods',5494500.00,'1.) The quotation is valid for Fourteen (14) days from the date of submission.\r\n2). The above price is excluding Value Added Tax (10% of sales price)\r\n3). Rate 13500','nurdin','2018-01-10 16:28:09','nurdin','2018-01-10 16:45:01'),('QJA/SQ/18/I/003','2018-01-10 16:49:50',2,9,'Ibu. Patricia Kurniawan , Ibu. Winarni Sri','Max Three weeks after confirmation','30 days after delivery the goods',25850000.00,'1). The quotation is valid for Fourteen (14) days from the date of submission\r\n2). The above price is excluding Value Added Tax (10% of sales price)','nurdin','2018-01-10 16:47:47','nurdin','2018-01-10 16:49:50'),('QJA/SQ/18/I/004','2018-01-11 14:22:31',2,53,'Ibu. Leni Mulianingsih','Max Three weeks after confirmation','30 days after delivery the goods',12804550.00,'a). The Quotation is Valid for Fourteen (14) days from the date of submission\r\nb). The above price is excluding Value Added Tax (10% of Sales Price)','nurdin','2018-01-11 14:21:10','nurdin','2018-01-11 14:22:31'),('QJA/SQ/18/I/005','2018-01-18 11:29:13',2,38,'Ibu. Yusnita','Max three weeks after confirmation','30 days after delivery the goods',24519000.00,'a). The quotation is valid for Fourteen (14) days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','nurdin','2018-01-18 11:23:28','nurdin','2018-01-18 11:29:13'),('QJA/SQ/18/I/006','2018-01-19 17:02:56',2,16,'Ibu. Wiwik','Max three weeks after cnfirmation','30 days after delivery the goods',155301300.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added  Tax (10% of sales price)\r\n','yudhi','2018-01-19 15:58:18','yudhi','2018-01-19 17:02:56'),('QJA/SQ/18/I/007','2018-01-22 11:09:37',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',41353537.50,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc).  Rate 13500','saiba','2018-01-22 08:16:19','saiba','2018-01-22 11:09:37'),('QJA/SQ/18/I/008','2018-01-24 15:53:09',2,38,'Ibu. Yusnita','Max three weeks after cnfirmation','30 days after delivery the goods',37950000.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','yudhi','2018-01-24 10:35:08','yudi','2018-01-25 15:53:09'),('QJA/SQ/18/II/009','2018-02-05 14:48:55',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',17070817.50,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc).  Rate 13.643','saiba','2018-02-05 14:48:55','saiba','2018-02-05 14:48:55'),('QJA/SQ/18/II/010','2018-02-09 09:14:04',2,22,'Ibu. Maria Monica','Max three weeks after confirmation','30 days after receipt the goods',16443350.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc).   Rate 13.822','saiba','2018-02-09 09:14:04','saiba','2018-02-09 09:14:04'),('QJA/SQ/18/II/011','2018-02-13 16:27:14',2,56,'Ibu. Desita Nurfaidah','Max 60 days after confirmation order','30 days after delivery the goods',301840000.00,'1. The Quotation is valid for Fourteen (14) days from the date of submission.\r\n2.The above price is excluding Value Added Tax (10 % of sales price)','nurdin','2018-02-13 16:27:14','nurdin','2018-02-13 16:27:14'),('QJA/SQ/18/II/012','2018-02-14 11:20:00',2,53,'Ibu. Leni Mulianingsih','Max Three weeks after confirmation order','30 days after delivery the goodsvery the goods',79934250.00,'1. The Quotation is Valid for Fourteen (14 ) days from the date of submission.\r\n2. The above price is excluding Value Added Tax (10% of sales price)','nurdin','2018-02-14 11:17:12','nurdin','2018-02-14 11:20:00'),('QJA/SQ/18/II/013','2018-02-20 16:17:53',2,28,'Ibu. Maya Wijaya','Max three weeks after cnfirmation','30 days after delivery the goods',12432750.00,'','yudi','2018-02-20 16:17:53','yudi','2018-02-20 16:17:53'),('QJA/SQ/18/II/014','2018-02-21 10:25:10',2,25,'Ibu. Puji Purnama, Amd','Max three weeks after confirmation.','30 days after receipt the goods.',347882535.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','saiba','2018-02-21 10:25:10','saiba','2018-02-21 10:25:10'),('QJA/SQ/18/II/015','2018-02-22 08:27:21',2,28,'Ibu. Maya Wijaya','Max three weeks after confirmation.','30 days after receipt the goods.',58013010.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc).  Rate 13.770','saiba','2018-02-22 08:26:24','saiba','2018-02-22 08:27:21'),('QJA/SQ/18/II/016','2018-02-22 14:39:46',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',6165362.50,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc). Rate 13.820','saiba','2018-02-22 14:39:46','saiba','2018-02-22 14:39:46'),('QJA/SQ/18/II/017','2018-02-23 15:13:20',2,36,'Ibu. Maria Monica','Max three weeks after confirmation oder','30 days after delivery the  goods',217800000.00,'1. The quotation is valid for Fourteen (14) days from the date of submission\r\n2. The above price is excluding Value Added Tax (10% of sales price)','nurdin','2018-02-23 15:13:20','nurdin','2018-02-23 15:13:20'),('QJA/SQ/18/II/018','2018-02-27 16:41:41',2,20,'Ibu. Susi Gozali','Max Three weeks after confirmation','30 days after delivery the  goods',231412500.00,'1. The Quotation is valid for Fourteen (14) days  from the date of submission.\r\n2. The above price is excluding Value Added Tax (10% of sales price)','nurdin','2018-02-27 16:41:41','nurdin','2018-02-27 16:41:41'),('QJA/SQ/18/III/019','2018-03-01 15:36:49',2,26,'Ibu. Eny Sumarno','Max Three weeks after confirmation','30 days after delivery the  goods',9955000.00,'1.  The quotation is valid for Fourteen (14) days from the date of submission\r\n2. The above price is excluding Value Added Tax (10% of sales price)','nurdin','2018-03-01 15:36:49','nurdin','2018-03-01 15:36:49'),('QJA/SQ/18/III/020','2018-03-05 08:39:36',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',17963165.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc).   Rate 13.898','saiba','2018-03-05 08:31:54','saiba','2018-03-05 08:39:36'),('QJA/SQ/18/III/021','2018-03-08 08:38:12',2,36,'Ibu. Maria Monica','Max three weeks after confirmation.','30 days after receipt the goods.',12996500.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','saiba','2018-03-08 08:38:12','saiba','2018-03-08 08:38:12'),('QJA/SQ/18/III/022','2018-03-08 08:59:38',2,20,'Ibu. Susi Gozali','Max three weeks after confirmation.','30 days after receipt the goods.',27500000.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','saiba','2018-03-08 08:59:38','saiba','2018-03-08 08:59:38'),('QJA/SQ/18/III/023','2018-03-08 09:13:10',2,56,'Ibu. Desita Nurfaidah','Max three weeks after confirmation.','30 days after receipt the goods.',303811200.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','saiba','2018-03-08 09:09:50','saiba','2018-03-08 09:13:10'),('QJA/SQ/18/III/024','2018-03-12 10:02:32',2,13,'Ibu. Merry Gunawan','Max three weeks after confirmation.','30 days after receipt the goods.',12925000.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','saiba','2018-03-12 10:00:57','saiba','2018-03-12 10:02:32'),('QJA/SQ/18/III/025','2018-03-14 08:38:23',2,42,'Ibu. Dany Christiani','Max three weeks after confirmation.','30 days after receipt the goods.',204738600.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc).   Rate 13.890','saiba','2018-03-14 08:32:48','saiba','2018-03-14 08:38:23'),('QJA/SQ/18/III/026','2018-03-16 08:29:30',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',69594525.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc). Rate 13905','saiba','2018-03-16 08:27:36','saiba','2018-03-16 08:29:30'),('QJA/SQ/18/III/027','2018-03-16 13:57:19',2,22,'Ibu. Maria Monica','Max three weeks after confirmation.','30 days after receipt the goods.',39105000.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','saiba','2018-03-16 13:57:19','saiba','2018-03-16 13:57:19'),('QJA/SQ/18/III/028','2018-03-22 15:32:28',2,36,'Ibu. Nisia','Max three weeks after confirmation.','30 days after receipt the goods.',30993132.50,'a). The quotation is valid for Fourteen (14)days from date of submission \r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc).  Rate 13895','saiba','2018-03-22 15:32:28','saiba','2018-03-22 15:32:28'),('QJA/SQ/18/III/029','2018-03-23 16:01:36',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',25667125.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc). Rate 13941','saiba','2018-03-23 16:01:36','saiba','2018-03-23 16:01:36'),('QJA/SQ/18/IV/030','2018-04-02 15:51:19',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',3826625.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc). Rate 13915','saiba','2018-04-02 15:51:19','saiba','2018-04-02 15:51:19'),('QJA/SQ/18/IV/031','2018-04-02 16:19:11',2,22,'Bp. Aries Kristanto','Max three weeks after confirmation.','30 days after receipt the goods.',45919500.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)\r\nc). Rate 13.915','saiba','2018-04-02 16:19:11','saiba','2018-04-02 16:19:11'),('QJA/SQ/18/IV/032','2018-04-06 09:55:22',2,20,'Ibu. Susi Gozali','Max three weeks after confirmation.','30 days after receipt the goods.',39823850.00,'a). The quotation is valid for Fourteen (14)days from date of submission\r\nb). The above price is excluding Value Added Tax (10% of sales price)','saiba','2018-04-06 09:55:22','saiba','2018-04-06 09:55:22');
/*!40000 ALTER TABLE `tr_salesquotationhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_salesreturndetail`
--

DROP TABLE IF EXISTS `tr_salesreturndetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_salesreturndetail` (
  `salesReturnDetailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `salesReturnNum` varchar(50) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `qty` decimal(18,2) NOT NULL,
  `HPP` decimal(18,2) NOT NULL,
  `VAT` decimal(18,2) NOT NULL,
  `totalAmount` decimal(18,2) NOT NULL,
  `notes` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`salesReturnDetailID`),
  KEY `fk_salesreturndetail_salesreturnnum_idx` (`salesReturnNum`),
  KEY `fk_salesreturndetail_productid_idx` (`productID`),
  KEY `fk_salesreturndetail_uomid_idx` (`uomID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_salesreturndetail`
--

LOCK TABLES `tr_salesreturndetail` WRITE;
/*!40000 ALTER TABLE `tr_salesreturndetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_salesreturndetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_salesreturnhead`
--

DROP TABLE IF EXISTS `tr_salesreturnhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_salesreturnhead` (
  `salesReturnNum` varchar(50) NOT NULL,
  `salesReturnDate` datetime NOT NULL,
  `customerID` int(11) NOT NULL,
  `coaNo` varchar(20) DEFAULT NULL,
  `grandTotal` decimal(18,2) NOT NULL,
  `additionalInfo` text,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) DEFAULT NULL,
  `editedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`salesReturnNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_salesreturnhead`
--

LOCK TABLES `tr_salesreturnhead` WRITE;
/*!40000 ALTER TABLE `tr_salesreturnhead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_salesreturnhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_sampledeliverydetail`
--

DROP TABLE IF EXISTS `tr_sampledeliverydetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_sampledeliverydetail` (
  `sampleDeliveryDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `sampleDeliveryNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `qty` decimal(18,4) NOT NULL,
  `batchNumber` varchar(20) NOT NULL,
  `manufactureDate` datetime DEFAULT NULL,
  `expiredDate` datetime DEFAULT NULL,
  `retestDate` datetime DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL,
  `notes` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sampleDeliveryDetailID`),
  KEY `fk_sampledeliverynum_idx` (`sampleDeliveryNum`),
  KEY `fk_sampledeliveryproductid_idx` (`productID`),
  KEY `fk_sampledeliveryuomid_idx` (`uomID`),
  KEY `fk_sampledeliverystatusid_idx` (`statusID`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_sampledeliverydetail`
--

LOCK TABLES `tr_sampledeliverydetail` WRITE;
/*!40000 ALTER TABLE `tr_sampledeliverydetail` DISABLE KEYS */;
INSERT INTO `tr_sampledeliverydetail` VALUES (3,'QJA/CSD/18/I/001',122,3,0.0500,'CO170220','2017-02-20 00:00:00','2019-02-19 00:00:00',NULL,1,''),(11,'QJA/CSD/18/I/002',152,1,0.1000,'A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',1,''),(12,'QJA/CSD/18/I/002',152,1,0.1000,'A11080515/004','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',1,''),(13,'QJA/CSD/18/I/002',152,1,0.1000,'A11080515/005','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',1,''),(22,'QJA/CSD/18/II/003',208,1,0.1000,'RS170002','2017-07-02 00:00:00',NULL,'2019-06-02 00:00:00',1,''),(23,'QJA/CSD/18/II/003',208,1,0.0001,'WS/RS/03','2017-08-01 00:00:00',NULL,'2017-07-31 00:00:00',1,''),(26,'QJA/CSD/18/II/004',144,1,0.0100,'185003006','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,1,''),(27,'QJA/CSD/18/II/005',177,1,0.0100,'2474','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,1,''),(28,'QJA/CSD/18/II/005',177,1,0.0100,'2487','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,1,''),(29,'QJA/CSD/18/II/005',177,1,0.0100,'2488','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,1,''),(33,'QJA/CSD/18/II/006',65,1,0.0002,'WS/HB/0916','2017-03-01 00:00:00',NULL,'2019-03-01 00:00:00',1,''),(36,'QJA/CSD/18/I/007',199,1,0.1000,'17010180','2018-01-01 00:00:00',NULL,'2018-12-01 00:00:00',1,''),(37,'QJA/CSD/18/III/008',206,1,0.1000,'17061','2017-10-31 00:00:00','2020-10-30 00:00:00',NULL,1,''),(38,'QJA/CSD/18/III/008',206,1,0.1000,'17062','2017-11-01 00:00:00','2020-10-31 00:00:00',NULL,1,''),(39,'QJA/CSD/18/III/008',206,1,0.1000,'17063','2017-11-02 00:00:00','2020-11-01 00:00:00',NULL,1,''),(40,'QJA/CSD/18/III/009',125,1,0.1000,'TDLPPA16035','2016-05-01 00:00:00','2019-04-01 00:00:00',NULL,1,''),(41,'QJA/CSD/18/III/010',138,1,0.0500,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,1,''),(43,'QJA/CSD/18/III/011',144,1,0.0010,'174003086','2018-03-01 00:00:00',NULL,'2019-09-18 00:00:00',1,''),(44,'QJA/CSD/18/I/006',138,1,0.0070,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,1,''),(45,'QJA/CSD/18/I/006',138,1,0.0070,'MLAH076121718','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,1,''),(46,'QJA/CSD/18/III/012',236,3,0.5000,'WS0096140','2016-10-12 00:00:00','2018-10-11 00:00:00',NULL,1,'');
/*!40000 ALTER TABLE `tr_sampledeliverydetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_sampledeliveryhead`
--

DROP TABLE IF EXISTS `tr_sampledeliveryhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_sampledeliveryhead` (
  `sampleDeliveryNum` varchar(50) NOT NULL,
  `sampleDeliveryDate` datetime NOT NULL,
  `refNum` varchar(50) DEFAULT NULL,
  `warehouseID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `customerDetailID` int(11) DEFAULT NULL,
  `notes` text,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`sampleDeliveryNum`),
  KEY `fk_sampledeliverycustomerid_idx` (`customerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_sampledeliveryhead`
--

LOCK TABLES `tr_sampledeliveryhead` WRITE;
/*!40000 ALTER TABLE `tr_sampledeliveryhead` DISABLE KEYS */;
INSERT INTO `tr_sampledeliveryhead` VALUES ('QJA/CSD/18/I/001','2018-01-23 00:00:00',NULL,8,22,NULL,'','wawan','2018-01-26 15:29:30','wawan','2018-01-26 15:29:30'),('QJA/CSD/18/I/002','2018-01-18 00:00:00',NULL,8,30,NULL,'','wawan','2018-02-02 10:59:19','wawan','2018-02-02 10:59:19'),('QJA/CSD/18/I/006','2018-01-10 00:00:00',NULL,8,22,317,'COA IS Attached','wawan','2018-02-26 16:13:49','wawan','2018-03-15 10:09:08'),('QJA/CSD/18/I/007','2018-01-31 00:00:00',NULL,8,17,305,'COA,MSDS Are Attached','wawan','2018-02-26 16:40:18','wawan','2018-02-26 16:40:18'),('QJA/CSD/18/II/003','2018-02-07 00:00:00',NULL,8,17,NULL,'COA ,MSDS Are Attached','wawan','2018-02-07 09:47:39','wawan','2018-02-07 10:11:58'),('QJA/CSD/18/II/004','2018-02-19 00:00:00',NULL,8,22,317,'COA Is Attached','wawan','2018-02-19 14:09:51','qwinjayasupport','2018-02-20 11:06:13'),('QJA/CSD/18/II/005','2018-02-20 00:00:00',NULL,8,22,318,'COA,MSDS  Are Attached','wawan','2018-02-20 15:31:53','wawan','2018-02-20 15:31:53'),('QJA/CSD/18/II/006','2017-12-06 00:00:00',NULL,8,55,223,'COA WS IS Attached','wawan','2018-02-26 15:02:22','wawan','2018-02-26 15:11:45'),('QJA/CSD/18/III/008','2018-03-02 00:00:00',NULL,8,22,318,'COA,MSDS Are Attached','wawan','2018-03-02 14:51:06','wawan','2018-03-02 14:51:06'),('QJA/CSD/18/III/009','2018-03-08 00:00:00',NULL,8,56,349,'COA IS  Attached','wawan','2018-03-08 16:09:16','wawan','2018-03-08 16:09:16'),('QJA/CSD/18/III/010','2018-03-12 00:00:00',NULL,8,66,351,'COA Is Attached','wawan','2018-03-12 16:12:36','wawan','2018-03-12 16:12:36'),('QJA/CSD/18/III/011','2018-03-15 00:00:00',NULL,8,22,318,'COA,MSDS Are Attached\r\n(WS || WORKING STANDARD)','wawan','2018-03-15 09:56:52','wawan','2018-03-15 09:58:37'),('QJA/CSD/18/III/012','2018-03-19 00:00:00',NULL,8,22,318,'COA IS Attached','wawan','2018-03-29 16:17:55','wawan','2018-03-29 16:17:55');
/*!40000 ALTER TABLE `tr_sampledeliveryhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_samplereceiptdetail`
--

DROP TABLE IF EXISTS `tr_samplereceiptdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_samplereceiptdetail` (
  `sampleReceiptDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `sampleReceiptNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `qty` decimal(18,4) NOT NULL,
  `batchNumber` varchar(20) NOT NULL,
  `manufactureDate` datetime NOT NULL,
  `expiredDate` datetime DEFAULT NULL,
  `retestDate` datetime DEFAULT NULL,
  PRIMARY KEY (`sampleReceiptDetailID`),
  KEY `fk_receiptsampleproductid_idx` (`productID`),
  KEY `fk_samplereceiptnum_idx` (`sampleReceiptNum`),
  KEY `fk_samplereceiptuomid_idx` (`uomID`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_samplereceiptdetail`
--

LOCK TABLES `tr_samplereceiptdetail` WRITE;
/*!40000 ALTER TABLE `tr_samplereceiptdetail` DISABLE KEYS */;
INSERT INTO `tr_samplereceiptdetail` VALUES (7,'QJA/SSR/18/I/002',122,3,0.0500,'CO170220','2017-02-20 00:00:00','2019-02-19 00:00:00',NULL),(13,'QJA/SSR/18/I/003',199,1,0.1000,'17010180','2018-01-01 00:00:00',NULL,'2018-12-01 00:00:00'),(26,'QJA/SSR/18/I/004',152,1,0.1000,'A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(27,'QJA/SSR/18/I/004',152,1,0.1000,'A11080515/004','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(28,'QJA/SSR/18/I/004',152,1,0.1000,'A11080515/005','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(29,'QJA/SSR/18/II/004',208,1,0.1000,'RS170002','2017-07-02 00:00:00',NULL,'2019-06-02 00:00:00'),(30,'QJA/SSR/18/II/004',208,1,0.0001,'WS/RS/03','2017-08-01 00:00:00',NULL,'2017-07-31 00:00:00'),(31,'QJA/SSR/18/II/005',144,1,0.0100,'185003006','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL),(32,'QJA/SSR/18/II/006',177,1,0.0100,'2488','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL),(33,'QJA/SSR/18/II/006',177,1,0.0100,'2474','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL),(34,'QJA/SSR/18/II/006',177,1,0.0100,'2487','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL),(35,'QJA/SSR/17/XII/001',65,1,0.0002,'WS/HB/0916','2017-03-01 00:00:00',NULL,'2019-03-01 00:00:00'),(38,'QJA/SSR/18/I/007',138,1,0.0070,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(39,'QJA/SSR/18/I/001',138,1,0.0070,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(40,'QJA/SSR/18/I/001',138,1,0.0070,'MLAH076121718','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL),(41,'QJA/SSR/18/III/008',206,1,0.1000,'17061','2017-10-31 00:00:00','2020-10-30 00:00:00',NULL),(42,'QJA/SSR/18/III/008',206,1,0.1000,'17062','2017-11-01 00:00:00','2020-10-31 00:00:00',NULL),(43,'QJA/SSR/18/III/008',206,1,0.1000,'17063','2017-11-02 00:00:00','2020-11-01 00:00:00',NULL),(44,'QJA/SSR/18/III/009',125,1,0.1000,'TDLPPA16035','2016-05-01 00:00:00','2019-04-01 00:00:00',NULL),(45,'QJA/SSR/18/III/010',138,1,0.0500,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(46,'QJA/SSR/18/III/011',144,1,0.0010,'174003086','2018-03-01 00:00:00',NULL,'2019-09-18 00:00:00'),(47,'QJA/SSR/18/III/012',236,3,0.5000,'WS0096140','2016-10-12 00:00:00','2018-10-11 00:00:00',NULL);
/*!40000 ALTER TABLE `tr_samplereceiptdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_samplereceipthead`
--

DROP TABLE IF EXISTS `tr_samplereceipthead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_samplereceipthead` (
  `sampleReceiptNum` varchar(50) NOT NULL,
  `sampleReceiptDate` datetime NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `supplierID` int(11) NOT NULL,
  `warehouseID` int(11) DEFAULT NULL,
  `notes` text,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`sampleReceiptNum`),
  KEY `fk_refnum_idx` (`refNum`),
  KEY `fk_receiptsamplesupplierid_idx` (`supplierID`),
  KEY `fk_receiptsamplewarehouseid_idx` (`warehouseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_samplereceipthead`
--

LOCK TABLES `tr_samplereceipthead` WRITE;
/*!40000 ALTER TABLE `tr_samplereceipthead` DISABLE KEYS */;
INSERT INTO `tr_samplereceipthead` VALUES ('QJA/SSR/17/XII/001','2017-12-05 00:00:00','',14,8,'WORKING STANDARD','admin','2017-12-22 13:55:38','wawan','2018-02-26 14:57:14'),('QJA/SSR/18/I/001','2018-01-10 00:00:00','',51,8,'COA,MSDS ARE Attached','wawan','2018-01-25 14:41:56','wawan','2018-02-26 16:04:58'),('QJA/SSR/18/I/002','2018-01-18 00:00:00','',81,8,'','wawan','2018-01-25 15:24:50','wawan','2018-01-25 15:24:50'),('QJA/SSR/18/I/003','2018-01-31 00:00:00','',45,8,'','wawan','2018-02-01 11:15:55','wawan','2018-02-02 08:38:58'),('QJA/SSR/18/I/004','2018-01-18 00:00:00','',20,8,'','wawan','2018-02-02 10:53:26','wawan','2018-02-02 10:53:26'),('QJA/SSR/18/I/007','2018-01-10 00:00:00','',51,8,'','wawan','2018-02-26 15:57:29','wawan','2018-02-26 15:57:29'),('QJA/SSR/18/II/004','2018-02-06 00:00:00','',17,8,'','wawan','2018-02-07 09:44:04','wawan','2018-02-07 09:44:04'),('QJA/SSR/18/II/005','2018-02-19 00:00:00','',70,8,'','wawan','2018-02-19 14:01:45','wawan','2018-02-19 14:01:45'),('QJA/SSR/18/II/006','2018-02-20 00:00:00','',79,8,'','wawan','2018-02-20 11:13:32','wawan','2018-02-20 11:13:32'),('QJA/SSR/18/III/008','2018-03-02 00:00:00','',86,8,'','wawan','2018-03-02 14:48:09','wawan','2018-03-02 14:48:09'),('QJA/SSR/18/III/009','2018-03-08 00:00:00','',19,8,'','wawan','2018-03-08 15:59:17','wawan','2018-03-08 15:59:17'),('QJA/SSR/18/III/010','2018-03-12 00:00:00','',51,8,'','wawan','2018-03-12 16:10:26','wawan','2018-03-12 16:10:26'),('QJA/SSR/18/III/011','2018-03-15 00:00:00','',85,8,'','wawan','2018-03-15 09:53:01','wawan','2018-03-15 09:53:01'),('QJA/SSR/18/III/012','2018-03-19 00:00:00','',86,8,'','wawan','2018-03-29 16:04:12','wawan','2018-03-29 16:04:12');
/*!40000 ALTER TABLE `tr_samplereceipthead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_stockcard`
--

DROP TABLE IF EXISTS `tr_stockcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_stockcard` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `refNum` varchar(50) NOT NULL COMMENT 'Reference Num',
  `transactionDate` datetime NOT NULL COMMENT 'Transaction Date',
  `productID` int(11) NOT NULL COMMENT 'Product ID',
  `warehouseID` int(11) NOT NULL COMMENT 'Warehouse ID',
  `inQty` decimal(18,2) NOT NULL COMMENT 'In Qty',
  `outQty` decimal(18,2) NOT NULL COMMENT 'Out Qty',
  `flagStatus` bit(1) DEFAULT NULL COMMENT 'Flag Status',
  `batchNumber` varchar(50) DEFAULT NULL,
  `manufactureDate` datetime DEFAULT NULL,
  `expiredDate` datetime DEFAULT NULL,
  `retestDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_stockcard_warehouseid_idx` (`warehouseID`),
  KEY `fk_stockcard_productid_idx` (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_stockcard`
--

LOCK TABLES `tr_stockcard` WRITE;
/*!40000 ALTER TABLE `tr_stockcard` DISABLE KEYS */;
INSERT INTO `tr_stockcard` VALUES (1,'INIT','2017-10-31 00:00:00',167,5,10.00,0.00,'','AP004-15052008','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL),(2,'INIT','2017-10-31 00:00:00',64,5,1300.00,0.00,'','1604584496','2016-12-13 00:00:00','2021-12-13 00:00:00',NULL),(3,'INIT','2017-10-31 00:00:00',66,5,75.00,0.00,'','DITPK17012','2017-02-01 00:00:00','2020-01-01 00:00:00',NULL),(4,'INIT','2017-10-31 00:00:00',152,5,5.00,0.00,'','A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL),(5,'INIT','2017-10-31 00:00:00',34,5,100.00,0.00,'','17ADL005','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL),(6,'INIT','2017-10-31 00:00:00',63,5,1200.00,0.00,'','A17118A','2017-03-01 00:00:00','2020-03-01 00:00:00',NULL),(7,'INIT','2017-10-31 00:00:00',142,5,1.00,0.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(8,'INIT','2017-10-31 00:00:00',165,5,1.00,0.00,'','15OS003','2015-03-01 00:00:00','2020-02-01 00:00:00',NULL),(9,'INIT','2017-10-31 00:00:00',166,5,5.00,0.00,'','C5127-13-008','2013-06-01 00:00:00','2016-05-01 00:00:00',NULL),(10,'INIT','2017-10-31 00:00:00',83,5,10.00,0.00,'','MH0027','2016-10-04 00:00:00','2018-09-30 00:00:00',NULL),(11,'INIT','2017-10-31 00:00:00',39,5,5.00,0.00,'','BDOM/1709193','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(12,'INIT','2017-10-31 00:00:00',144,5,250.00,0.00,'','175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(13,'INIT','2017-10-31 00:00:00',132,5,24.00,0.00,'','SC-NM-20170504','2017-05-05 00:00:00','2020-11-04 00:00:00',NULL),(14,'INIT','2017-10-31 00:00:00',80,5,20.00,0.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(15,'QJA/GR/17/XII/001','2017-12-21 14:24:11',131,5,50.00,0.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(16,'QJA/GD/17/XII/001','2017-12-21 15:54:16',134,5,0.00,0.00,'','17CF03','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL),(17,'QJA/GR/17/XII/003','2017-12-21 16:28:27',169,5,50.00,0.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(18,'QJA/GD/17/XII/001','2017-12-21 16:33:58',169,5,0.00,0.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(19,'QJA/GR/17/XII/001','2017-12-22 09:55:01',131,5,50.00,0.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(20,'QJA/GD/17/XII/001','2017-12-22 09:56:39',131,5,0.00,0.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(21,'QJA/GD/17/XII/001','2017-12-22 09:57:57',131,5,0.00,50.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(22,'QJA/GD/17/XII/001','2017-12-22 10:26:13',131,5,0.00,50.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(23,'QJA/GD/17/XII/001','2017-12-22 11:05:05',131,5,0.00,50.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(24,'QJA/GD/17/XII/001','2017-12-22 11:08:25',131,5,0.00,0.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(25,'QJA/GD/17/XII/001','2017-12-22 11:09:21',131,5,0.00,50.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(26,'QJA/GD/17/XII/001','2017-12-22 11:10:32',131,5,0.00,50.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(27,'QJA/GD/17/XII/001','2017-12-22 13:33:32',131,5,0.00,50.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(28,'QJA/GD/17/XII/002','2017-12-22 13:37:12',169,5,0.00,25.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(29,'QJA/GD/17/XII/003','2017-12-22 13:39:05',134,5,0.00,0.00,'','17CF03','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL),(30,'QJA/GD/17/XII/001','2017-12-22 13:42:25',169,5,0.00,25.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(31,'QJA/GD/17/XII/002','2017-12-22 13:43:35',134,5,0.00,5.00,'','17CF03','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL),(32,'QJA/GD/17/XII/003','2017-12-22 13:45:49',131,5,0.00,25.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(33,'QJA/GD/17/XII/001','2017-12-22 13:48:22',169,5,0.00,25.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(34,'QJA/GR/17/XII/001','2017-12-22 14:03:37',131,5,50.00,0.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(43,'QJA/GD/18/I/001','2018-01-10 14:00:17',169,5,0.00,0.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(44,'QJA/GD/18/I/001','2018-01-12 09:05:04',169,5,0.00,0.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(52,'QJA/GD/18/I/001','2018-01-17 11:34:03',169,5,0.00,25.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(54,'QJA/GR/18/I/001','2018-01-26 10:48:18',182,5,50.00,0.00,'','217INS1003','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL),(55,'QJA/GR/18/I/002','2018-01-26 14:22:14',13,5,10.00,0.00,'','DB 005/1117','2017-11-01 00:00:00',NULL,'2022-10-01 00:00:00'),(56,'QJA/GR/18/I/001','2018-01-26 15:46:38',182,5,50.00,0.00,'','217INS1003','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL),(57,'QJA/GR/18/I/003','2018-02-01 11:08:14',176,5,50.00,0.00,'','4003-20171105','2017-11-01 00:00:00',NULL,'2019-10-31 00:00:00'),(58,'QJA/GR/18/I/004','2018-02-01 11:30:53',12,5,75.00,0.00,'','17FH094','2017-08-01 00:00:00','2022-07-01 00:00:00',NULL),(59,'QJA/GR/18/I/005','2018-02-01 11:47:51',128,5,15.00,0.00,'','XMEP170089','2017-12-01 00:00:00','2020-11-01 00:00:00',NULL),(60,'QJA/GR/18/I/006','2018-02-02 14:57:47',158,5,500.00,0.00,'','PS/DSMB/1016','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL),(61,'QJA/GR/18/I/007','2018-02-05 10:17:15',194,5,8.00,0.00,'','El-03/L020/17026','2017-11-01 00:00:00',NULL,'2020-10-01 00:00:00'),(62,'QJA/GR/18/I/007','2018-02-05 10:17:15',194,5,2.00,0.00,'','El-03/L020/17030','2017-12-01 00:00:00',NULL,'2020-11-01 00:00:00'),(63,'QJA/GR/18/I/008','2018-02-05 17:41:22',186,5,10.00,0.00,'','CDAH009121718','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL),(64,'QJA/GR/18/I/009','2018-02-05 17:51:21',17,5,50.00,0.00,'','SET401317VE-II','2017-11-25 00:00:00','2022-11-24 00:00:00',NULL),(65,'QJA/GR/18/I/010','2018-02-06 14:15:48',69,5,100.00,0.00,'','W15082709','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(66,'QJA/GR/18/I/010','2018-02-06 14:15:48',69,5,100.00,0.00,'','W15090903','2015-09-01 00:00:00',NULL,'2020-08-01 00:00:00'),(67,'QJA/GR/18/I/011','2018-02-06 14:33:35',152,5,5.00,0.00,'','A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(68,'QJA/GR/18/I/012','2018-02-06 15:18:29',152,5,10.00,0.00,'','A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(69,'QJA/GR/18/I/013','2018-02-06 15:36:20',184,5,50.00,0.00,'','CZH-16 06 012 (B)','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL),(70,'QJA/GR/18/I/013','2018-02-06 15:36:20',184,5,5.00,0.00,'','CZH-16 06 012 (B)','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL),(71,'QJA/GR/18/I/014','2018-02-06 15:49:39',121,5,10.00,0.00,'','MTP03217','2017-09-30 00:00:00',NULL,'2022-09-01 00:00:00'),(72,'QJA/GR/18/I/015','2018-02-06 15:59:32',135,5,5.00,0.00,'','TB-1710032','2017-10-26 00:00:00',NULL,'2020-10-25 00:00:00'),(73,'QJA/GR/18/I/016','2018-02-06 16:32:21',183,5,25.00,0.00,'','CZC/364','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00'),(74,'QJA/GR/18/I/017','2018-02-06 16:52:35',153,5,10.00,0.00,'','HAL/108','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00'),(75,'QJA/GR/18/I/018','2018-02-07 09:07:33',176,5,75.00,0.00,'','4003-20180104','2017-12-28 00:00:00',NULL,'2019-12-27 00:00:00'),(76,'QJA/GR/18/I/019','2018-02-07 10:08:23',207,5,10.00,0.00,'','G1705K005','2017-05-01 00:00:00','2022-04-01 00:00:00',NULL),(77,'QJA/GR/18/I/020','2018-02-07 10:33:47',193,5,5.00,0.00,'','FP/HTP/002/12/17','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL),(78,'QJA/GR/18/I/021','2018-02-07 11:27:45',155,5,100.00,0.00,'','GBW1801005','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL),(79,'QJA/GR/18/I/022','2018-02-07 13:01:09',155,5,125.00,0.00,'','GBW1801005','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL),(80,'QJA/GR/18/I/023','2018-02-07 13:14:38',106,5,100.00,0.00,'','ALA.1801021','2018-01-02 00:00:00','2020-01-01 00:00:00',NULL),(81,'QJA/GR/18/I/024','2018-02-07 14:38:40',209,5,25.00,0.00,'','C0011712003','2017-11-29 00:00:00','2019-11-28 00:00:00',NULL),(82,'QJA/GR/18/I/025','2018-02-07 14:52:45',175,5,25.00,0.00,'','W-F03-20170805-01','2017-08-09 00:00:00',NULL,'2020-07-01 00:00:00'),(84,'QJA/GR/18/I/027','2018-02-07 16:04:45',185,5,2240.00,0.00,'','P3264','2017-09-30 00:00:00','2021-09-30 00:00:00',NULL),(85,'QJA/GR/18/II/028','2018-02-07 16:19:12',77,5,2.00,0.00,'','HAL3001725','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(86,'QJA/GR/18/II/029','2018-02-07 16:34:28',188,5,25.00,0.00,'','IHAF171222','2017-12-22 00:00:00','2020-12-21 00:00:00',NULL),(88,'QJA/GR/17/XII/002','2018-02-12 11:29:30',152,5,25.00,0.00,'','A11080515/004','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(89,'QJA/GR/17/XII/003','2018-02-12 11:40:44',131,5,50.00,0.00,'','17111001','2017-11-10 00:00:00','2019-11-09 00:00:00',NULL),(90,'QJA/GR/17/XII/004','2018-02-12 15:19:50',136,5,25.00,0.00,'','17 11 19','2017-11-19 00:00:00','2019-11-18 00:00:00',NULL),(91,'QJA/GR/17/XII/005','2018-02-12 15:42:02',34,5,100.00,0.00,'','17ADL007','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(92,'QJA/GR/17/XII/006','2018-02-12 15:51:37',124,5,50.00,0.00,'','17CTH062','2017-10-01 00:00:00','2021-09-01 00:00:00',NULL),(93,'QJA/GR/17/XII/007','2018-02-12 16:09:07',137,5,10.00,0.00,'','NEDNa 171005','2017-09-22 00:00:00','2022-09-22 00:00:00',NULL),(94,'QJA/GR/17/XII/008','2018-02-12 16:18:19',102,5,300.00,0.00,'','BB 004/0817','2017-08-01 00:00:00',NULL,'2022-07-01 00:00:00'),(95,'QJA/GR/17/XII/009','2018-02-12 16:27:24',64,5,10000.00,0.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(96,'QJA/GR/17/XII/010','2018-02-12 16:37:18',37,5,2.00,0.00,'','MCB1711033','2017-11-01 00:00:00','2021-10-01 00:00:00',NULL),(97,'QJA/GD/18/I/001','2018-02-12 16:43:08',64,5,0.00,200.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(98,'QJA/GD/17/XI/0293','2018-02-14 15:42:21',142,5,0.00,1.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(99,'QJA/GD/17/XI/0293','2018-02-14 15:42:21',80,5,0.00,20.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(100,'QJA/GD/17/XI/0293','2018-02-14 16:11:48',142,5,0.00,0.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(101,'QJA/GD/17/XI/0293','2018-02-14 16:11:48',80,5,0.00,0.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(102,'QJA/GD/17/XI/0293','2018-02-15 10:39:48',142,5,0.00,1.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(103,'QJA/GD/17/XI/0293','2018-02-15 10:39:48',80,5,0.00,20.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(104,'QJA/GD/17/XI/0293','2018-02-15 12:45:06',142,5,0.00,1.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(105,'QJA/GD/17/XI/0293','2018-02-15 12:45:06',80,5,0.00,20.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(106,'QJA/GD/17/XI/0293','2018-02-15 12:50:25',142,5,0.00,1.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(107,'QJA/GD/17/XI/0293','2018-02-15 12:50:25',80,5,0.00,20.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(108,'QJA/GD/17/XI/0293','2018-02-15 12:56:08',142,5,0.00,1.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(109,'QJA/GD/17/XI/0293','2018-02-15 12:56:08',80,5,0.00,20.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(110,'QJA/GD/17/XI/0293','2018-02-15 13:37:31',142,5,0.00,1.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(111,'QJA/GD/17/XI/0293','2018-02-15 13:37:31',80,5,0.00,20.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(112,'QJA/GD/17/XI/0293','2018-02-15 13:42:06',142,5,0.00,1.00,'','MCB1709025','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL),(113,'QJA/GD/17/XI/0293','2018-02-15 13:42:06',80,5,0.00,20.00,'','SS/171/16-17','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(114,'QJA/GD/17/XI/0001','2018-02-15 13:57:30',34,5,0.00,100.00,'','17ADL005','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL),(115,'QJA/GD/17/XI/0001','2018-02-15 14:01:02',34,5,0.00,100.00,'','17ADL005','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL),(116,'QJA/GD/17/XI/0001','2018-02-15 14:07:18',34,5,0.00,0.00,'','17ADL005','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL),(117,'QJA/GD/17/XI/0001','2018-02-15 14:10:57',34,5,0.00,100.00,'','17ADL005','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL),(118,'QJA/GD/17/XI/0294','2018-02-15 15:19:45',34,5,0.00,100.00,'','17ADL005','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL),(119,'INIT','2017-11-06 00:00:00',140,5,50.00,0.00,'','CAMPT/1709023','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(120,'INIT','2017-11-06 00:00:00',205,5,500.00,0.00,'','PS/DSMB/1016','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL),(121,'QJA/GD/17/XI/0295','2018-02-20 10:26:02',140,5,0.00,50.00,'','CAMPT/1709023','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(122,'QJA/GR/17/XI/011','2018-02-22 11:05:22',38,5,100.00,0.00,'','20170823','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL),(123,'QJA/GR/17/XI/011','2018-02-22 11:05:22',38,5,200.00,0.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(124,'QJA/GD/17/XI/0296','2018-02-22 11:09:32',38,5,0.00,50.00,'','20170823','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL),(125,'QJA/GD/17/XI/0297','2018-02-22 11:18:35',38,5,0.00,50.00,'','20170823','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL),(126,'QJA/GD/17/XI/0298','2018-02-22 11:39:30',205,5,0.00,500.00,'','PS/DSMB/1016','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL),(127,'QJA/GR/17/XI/012','2018-02-22 15:13:42',103,5,1.00,0.00,'','MPB 002/0817','2017-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(128,'QJA/GD/17/XI/0299','2018-02-22 15:34:27',103,5,0.00,1.00,'','MPB 002/0817','2017-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(129,'QJA/GR/17/XI/013','2018-02-23 10:23:56',38,5,100.00,0.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(130,'QJA/GR/18/II/031','2018-02-23 10:42:18',38,5,200.00,0.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(131,'QJA/GR/17/XI/014','2018-02-23 10:48:05',46,5,75.00,0.00,'','4003-20170503','2017-04-28 00:00:00',NULL,'2019-04-27 00:00:00'),(132,'QJA/GD/17/XI/0300','2018-02-23 11:10:52',46,5,0.00,50.00,'','4003-20170503','2017-04-28 00:00:00',NULL,'2019-04-27 00:00:00'),(133,'QJA/GD/18/II/0001','2018-02-23 11:17:51',38,5,0.00,300.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(134,'QJA/GD/17/XI/0301','2018-02-23 11:22:57',38,5,0.00,300.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(135,'QJA/GR/17/XI/015','2018-02-23 13:56:04',149,5,5.00,0.00,'','BST200117','2017-01-01 00:00:00',NULL,'2019-12-01 00:00:00'),(136,'QJA/GD/17/XI/0302','2018-02-23 14:21:24',149,5,0.00,5.00,'','BST200117','2017-01-01 00:00:00',NULL,'2019-12-01 00:00:00'),(137,'QJA/GD/17/XI/0303','2018-02-23 14:41:39',46,5,0.00,25.00,'','4003-20170503','2017-04-28 00:00:00',NULL,'2019-04-27 00:00:00'),(138,'QJA/GR/17/XI/016','2018-02-23 16:14:18',43,5,25.00,0.00,'','17CTH047','2017-08-01 00:00:00','2021-07-01 00:00:00',NULL),(139,'QJA/GR/17/XI/017','2018-02-23 16:16:12',42,5,25.00,0.00,'','CZC/358','2017-10-01 00:00:00',NULL,'2022-09-01 00:00:00'),(140,'QJA/GD/17/XI/0304','2018-02-23 16:37:34',43,5,0.00,25.00,'','17CTH047','2017-08-01 00:00:00','2021-07-01 00:00:00',NULL),(141,'QJA/GD/17/XI/0304','2018-02-23 16:37:34',42,5,0.00,25.00,'','CZC/358','2017-10-01 00:00:00',NULL,'2022-09-01 00:00:00'),(142,'QJA/GD/17/XI/0305','2018-02-23 16:43:57',132,5,0.00,12.00,'','SC-NM-20170504','2017-05-05 00:00:00','2020-11-04 00:00:00',NULL),(143,'QJA/GR/17/XI/018','2018-02-26 14:43:03',146,5,500.00,0.00,'','TDOMPA 17026','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL),(144,'QJA/GR/17/XI/018','2018-02-26 14:43:03',146,5,475.00,0.00,'','TDOMPA 17027','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL),(145,'QJA/GR/17/XI/018','2018-02-26 14:43:03',146,5,5.00,0.00,'','TDOMPA 17027','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL),(146,'QJA/GR/17/XI/019','2018-02-26 14:56:03',145,5,50.00,0.00,'','OP8.5/141800617','2017-09-01 00:00:00','2020-08-01 00:00:00',NULL),(147,'QJA/GD/17/XI/0306','2018-02-26 16:14:38',146,5,0.00,475.00,'','TDOMPA 17026','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL),(148,'QJA/GD/17/XI/0306','2018-02-26 16:14:38',146,5,0.00,480.00,'','TDOMPA 17027','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL),(149,'QJA/GD/17/XI/0307','2018-02-26 16:26:03',145,5,0.00,50.00,'','OP8.5/141800617','2017-09-01 00:00:00','2020-08-01 00:00:00',NULL),(150,'QJA/GD/17/XI/0308','2018-02-26 16:30:30',152,5,0.00,5.00,'','A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL),(151,'QJA/GD/17/XI/0309','2018-02-26 16:39:05',146,5,0.00,25.00,'','TDOMPA 17026','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL),(152,'QJA/GR/17/XI/020','2018-02-26 17:15:30',133,5,25.00,0.00,'','170903','2017-09-03 00:00:00','2020-09-02 00:00:00',NULL),(153,'QJA/GD/17/XI/0310','2018-02-26 17:27:16',133,5,0.00,25.00,'','170903','2017-09-03 00:00:00','2020-09-02 00:00:00',NULL),(154,'QJA/GR/17/II/048','2018-02-26 17:51:24',214,5,10.00,0.00,'','02020417','2017-03-01 00:00:00','2022-03-01 00:00:00',NULL),(155,'QJA/GD/17/XI/0311','2018-02-28 16:43:43',214,5,0.00,10.00,'','02020417','2017-03-01 00:00:00','2022-03-01 00:00:00',NULL),(156,'QJA/GR/17/XI/033','2018-03-01 09:15:18',44,5,2.00,0.00,'','TBS/125/17-18','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(157,'QJA/GD/17/XI/0312','2018-03-01 13:21:25',44,5,0.00,2.00,'','TBS/125/17-18','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(158,'QJA/GD/17/XI/0313','2018-03-01 13:25:24',38,5,0.00,100.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(159,'QJA/GD/17/XI/0314','2018-03-01 13:29:48',182,5,0.00,25.00,'','217INS1003','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL),(160,'QJA/GR/17/XI/034','2018-03-01 14:02:44',53,5,1.00,0.00,'','FSD-170905','2017-10-05 00:00:00','2022-10-04 00:00:00',NULL),(161,'QJA/GD/17/XI/0315','2018-03-01 14:06:56',53,5,0.00,1.00,'','FSD-170905','2017-10-05 00:00:00','2022-10-04 00:00:00',NULL),(162,'QJA/GR/17/XI/035','2018-03-01 16:54:13',120,5,10.00,0.00,'','X1710307M','2017-10-09 00:00:00',NULL,'2022-10-08 00:00:00'),(163,'QJA/GD/17/XI/0316','2018-03-02 08:41:16',120,5,0.00,10.00,'','X1710307M','2017-10-09 00:00:00',NULL,'2022-10-08 00:00:00'),(164,'QJA/GR/17/XI/036','2018-03-02 16:19:56',135,5,5.00,0.00,'','TB.1706015','2017-06-26 00:00:00',NULL,'2022-06-26 00:00:00'),(165,'QJA/GD/17/XI/0317','2018-03-07 13:31:15',135,5,0.00,5.00,'','TB.1706015','2017-06-26 00:00:00',NULL,'2022-06-26 00:00:00'),(166,'QJA/GD/17/XI/0318','2018-03-07 13:35:52',144,5,0.00,50.00,'','175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(167,'QJA/GD/17/XI/0319','2018-03-07 13:45:08',144,5,0.00,50.00,'','175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(168,'QJA/GD/17/XI/0320','2018-03-07 13:57:09',39,5,0.00,5.00,'','BDOM/1709193','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(169,'QJA/GD/17/XI/0321','2018-03-07 14:01:58',39,5,0.00,5.00,'','BDOM/1709193','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(170,'QJA/GD/17/XI/0320','2018-03-07 14:09:42',39,5,0.00,5.00,'','BDOM/1709193','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(171,'QJA/GD/17/XI/0321','2018-03-07 14:20:28',39,5,0.00,5.00,'','BDOM/1709193','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(172,'QJA/GR/17/XI/037','2018-03-07 14:44:46',39,5,5.00,0.00,'','BDOM/1709189','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(173,'QJA/GD/17/XI/0321','2018-03-07 14:51:22',39,5,0.00,5.00,'','BDOM/1709189','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(174,'QJA/GR/17/XI/038','2018-03-07 15:13:34',78,5,10.00,0.00,'','170603MC-WF','2017-06-20 00:00:00','2019-06-19 00:00:00',NULL),(175,'QJA/GD/17/XI/0322','2018-03-07 15:18:43',78,5,0.00,5.00,'','170603MC-WF','2017-06-20 00:00:00','2019-06-19 00:00:00',NULL),(176,'QJA/GD/17/XI/0323','2018-03-07 15:23:21',78,5,0.00,5.00,'','170603MC-WF','2017-06-20 00:00:00','2019-06-19 00:00:00',NULL),(177,'QJA/GR/17/XII/039','2018-03-07 16:01:40',130,5,25.00,0.00,'','DC-0101H-1708001','2017-07-28 00:00:00','2020-07-27 00:00:00',NULL),(178,'QJA/GD/17/XII/0324','2018-03-07 16:07:08',130,5,0.00,25.00,'','DC-0101H-1708001','2017-07-28 00:00:00','2020-07-27 00:00:00',NULL),(179,'QJA/GD/17/XII/0325','2018-03-07 16:18:16',152,5,0.00,15.00,'','A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL),(180,'QJA/GR/17/XI/041','2018-03-08 09:32:49',219,5,50.00,0.00,'','CAMPT/1709023','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(181,'QJA/GR/17/XII/040','2018-03-08 09:47:02',156,5,2.00,0.00,'','APSS17004','2017-07-17 00:00:00','2020-06-01 00:00:00',NULL),(182,'QJA/GD/17/XII/0326','2018-03-08 10:03:11',219,5,0.00,50.00,'','CAMPT/1709023','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(183,'QJA/GD/17/XII/0327','2018-03-08 10:07:10',156,5,0.00,2.00,'','APSS17004','2017-07-01 00:00:00','2020-06-01 00:00:00',NULL),(184,'QJA/GD/17/XII/0328','2018-03-08 10:12:34',152,5,0.00,5.00,'','A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL),(185,'QJA/GR/17/XII/042','2018-03-08 14:30:50',217,5,6.00,0.00,'','213733','2017-08-21 00:00:00',NULL,'2022-08-21 00:00:00'),(186,'QJA/GD/17/XII/0329','2018-03-08 14:33:19',217,5,0.00,6.00,'','213733','2017-08-21 00:00:00',NULL,'2022-08-21 00:00:00'),(187,'QJA/GR/17/XI/043','2018-03-08 14:43:35',34,5,100.00,0.00,'','17ADL006','2017-07-01 00:00:00','2022-06-01 00:00:00',NULL),(188,'QJA/GD/17/XII/0330','2018-03-08 14:46:48',34,5,0.00,100.00,'','17ADL006','2017-07-01 00:00:00','2022-06-01 00:00:00',NULL),(189,'QJA/GR/17/XII/044','2018-03-08 15:16:29',157,5,60.00,0.00,'','176682006','2017-11-09 00:00:00',NULL,'2020-11-08 00:00:00'),(190,'QJA/GD/17/XII/0331','2018-03-08 15:24:16',157,5,0.00,60.00,'','176682006','2017-11-09 00:00:00',NULL,'2020-11-08 00:00:00'),(191,'QJA/GR/17/XII/045','2018-03-08 15:40:17',138,5,25.00,0.00,'','MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(192,'QJA/GD/17/XII/0332','2018-03-08 15:43:30',138,5,0.00,25.00,'','MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(195,'QJA/GR/17/V/046','2018-03-09 14:15:18',64,5,6000.00,0.00,'','1604584496','2016-12-13 00:00:00','2021-12-13 00:00:00',NULL),(196,'QJA/GR/17/V/046','2018-03-09 14:15:18',64,5,4000.00,0.00,'','1704770694','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL),(197,'QJA/GR/17/XI/047','2018-03-09 14:26:16',116,5,30.00,0.00,'','YT20170922','2017-09-22 00:00:00','2019-09-21 00:00:00',NULL),(198,'QJA/GR/17/XI/048','2018-03-09 14:37:54',25,5,25.00,0.00,'','HYD/025/17-18','2017-10-01 00:00:00',NULL,'2020-09-01 00:00:00'),(199,'QJA/GD/17/XII/0333','2018-03-09 14:43:25',64,5,0.00,500.00,'','1704770694','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL),(200,'QJA/GD/17/XII/0334','2018-03-09 14:47:21',137,5,0.00,5.00,'','NEDNa 171005','2017-09-22 00:00:00','2022-09-22 00:00:00',NULL),(201,'QJA/GD/17/XII/0335','2018-03-09 15:23:14',116,5,0.00,30.00,'','YT20170922','2017-09-22 00:00:00','2019-09-21 00:00:00',NULL),(202,'QJA/GD/17/XII/0336','2018-03-09 15:27:09',38,5,0.00,50.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(203,'QJA/GD/17/XII/0337','2018-03-09 15:30:03',144,5,0.00,50.00,'','175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(204,'QJA/GD/17/XII/0338','2018-03-09 15:34:48',144,5,0.00,50.00,'','175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(205,'QJA/GD/17/XII/0339','2018-03-09 15:40:00',144,5,0.00,50.00,'','175003074','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL),(206,'QJA/GD/17/XII/0340','2018-03-09 15:49:04',64,5,0.00,800.00,'','1704770694','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL),(207,'QJA/GD/17/XII/0341','2018-03-09 16:33:58',25,5,0.00,25.00,'','HYD/025/17-18','2017-10-01 00:00:00',NULL,'2020-09-01 00:00:00'),(208,'QJA/GD/17/XII/0342','2018-03-09 16:36:47',169,5,0.00,25.00,'','C103-171108','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00'),(209,'QJA/GD/17/XII/0343','2018-03-09 16:39:26',134,5,0.00,5.00,'','17CF03','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL),(210,'QJA/GD/17/XII/0344','2018-03-09 16:44:11',64,5,0.00,2200.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(211,'QJA/GD/18/I/0001','2018-03-14 14:15:29',64,5,0.00,100.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(212,'QJA/GD/18/I/0001','2018-03-14 14:18:41',64,5,0.00,200.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(213,'QJA/GD/18/I/0001','2018-03-14 14:39:44',64,5,0.00,200.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(214,'QJA/GD/18/I/0002','2018-03-14 15:44:58',37,5,0.00,2.00,'','MCB1711033','2017-11-01 00:00:00','2021-10-01 00:00:00',NULL),(215,'QJA/GD/18/I/0003','2018-03-16 10:37:41',64,5,0.00,500.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(216,'QJA/GD/18/I/0004','2018-03-16 10:51:06',124,5,0.00,50.00,'','17CTH062','2017-10-01 00:00:00','2021-09-01 00:00:00',NULL),(217,'QJA/GD/18/I/0005','2018-03-16 11:06:56',152,5,0.00,5.00,'','A11080515/004','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL),(218,'QJA/GD/18/I/0006','2018-03-16 11:22:30',34,5,0.00,100.00,'','17ADL007','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL),(219,'QJA/GD/18/I/0007','2018-03-16 11:33:16',131,5,0.00,50.00,'','17111001','2017-11-10 00:00:00','2019-11-09 00:00:00',NULL),(220,'QJA/GD/18/I/0008','2018-03-16 13:10:38',137,5,0.00,5.00,'','NEDNa 171005','2017-09-22 00:00:00','2022-09-22 00:00:00',NULL),(221,'QJA/GD/18/I/0009','2018-03-16 13:18:21',182,5,0.00,50.00,'','217INS1003','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL),(222,'QJA/GD/18/I/0010','2018-03-16 13:25:40',131,5,0.00,50.00,'','17120701','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL),(223,'QJA/GD/18/I/0011','2018-03-16 13:39:02',13,5,0.00,10.00,'','DB 005/1117','2017-11-01 00:00:00',NULL,'2022-10-01 00:00:00'),(224,'QJA/GD/18/I/0012','2018-03-16 14:17:55',136,5,0.00,25.00,'','17 11 19','2017-11-19 00:00:00','2019-11-18 00:00:00',NULL),(225,'QJA/GD/18/I/0013','2018-03-16 14:24:19',176,5,0.00,50.00,'','4003-20171105','2017-11-01 00:00:00',NULL,'2019-10-31 00:00:00'),(226,'QJA/GD/18/I/0014','2018-03-16 14:29:23',102,5,0.00,300.00,'','BB 004/0817','2017-08-01 00:00:00',NULL,'2022-07-01 00:00:00'),(227,'QJA/GD/18/I/0014','2018-03-16 14:32:05',102,5,0.00,300.00,'','BB 004/0817','2017-08-01 00:00:00',NULL,'2022-07-01 00:00:00'),(228,'QJA/GD/18/I/0015','2018-03-16 14:49:37',128,5,0.00,15.00,'','XMEP170089','2017-12-01 00:00:00','2020-11-01 00:00:00',NULL),(229,'QJA/GD/18/I/0016','2018-03-16 15:22:53',205,5,0.00,500.00,'','PS/DSMB/1016','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL),(230,'QJA/GD/18/I/0017','2018-03-16 15:30:49',186,5,0.00,10.00,'','CDAH009121718','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL),(231,'QJA/GD/18/I/0018','2018-03-16 15:40:47',69,5,0.00,75.00,'','W15082709','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(232,'QJA/GD/18/I/0019','2018-03-16 16:16:50',152,5,0.00,5.00,'','A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(233,'QJA/GD/18/I/0020','2018-03-19 11:27:51',152,5,0.00,5.00,'','A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(234,'QJA/GD/18/I/0021','2018-03-19 11:38:11',152,5,0.00,5.00,'','A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(235,'QJA/GD/18/I/0022','2018-03-19 11:50:21',184,5,0.00,50.00,'','CZH-16 06 012 (B)','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL),(236,'QJA/GD/18/I/0023','2018-03-19 13:25:02',153,5,0.00,10.00,'','HAL/108','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00'),(237,'QJA/GD/18/I/0024','2018-03-19 13:34:00',135,5,0.00,5.00,'','TB-1710032','2017-10-26 00:00:00',NULL,'2020-10-25 00:00:00'),(238,'QJA/GD/18/I/0025','2018-03-19 13:41:48',176,5,0.00,75.00,'','4003-20180104','2017-12-28 00:00:00',NULL,'2019-12-27 00:00:00'),(239,'QJA/GD/18/I/0026','2018-03-19 13:47:37',193,5,0.00,5.00,'','FP/HTP/002/12/17','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL),(240,'QJA/GD/18/I/0027','2018-03-19 13:54:50',155,5,0.00,100.00,'','GBW1801005','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL),(241,'QJA/GD/18/I/0028','2018-03-19 14:01:07',106,5,0.00,100.00,'','ALA.1801021','2018-01-02 00:00:00','2020-01-01 00:00:00',NULL),(242,'QJA/GD/18/I/0028','2018-03-19 14:22:20',106,5,0.00,100.00,'','ALA.1801021','2018-01-02 00:00:00','2020-01-01 00:00:00',NULL),(243,'QJA/GD/18/I/0029','2018-03-19 14:36:06',185,5,0.00,2240.00,'','P3264','2017-09-30 00:00:00','2021-09-30 00:00:00',NULL),(244,'QJA/GD/18/III/0029','2018-03-19 14:47:14',185,5,0.00,2240.00,'','P3264','2017-09-30 00:00:00','2021-09-30 00:00:00',NULL),(245,'QJA/GD/18/I/0030','2018-03-19 15:06:45',183,5,0.00,25.00,'','CZC/364','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00'),(246,'QJA/GD/18/I/0031','2018-03-19 16:29:57',64,5,0.00,500.00,'','1705272729','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL),(247,'QJA/GD/18/I/0032','2018-03-19 16:48:14',175,5,0.00,25.00,'','W-F03-20170805-01','2017-08-09 00:00:00',NULL,'2020-07-01 00:00:00'),(248,'QJA/GR/18/II/030','2018-03-20 10:31:09',39,5,25.00,0.00,'','BDM/1801016','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL),(249,'QJA/GR/18/II/032','2018-03-21 13:57:34',214,5,10.00,0.00,'','02020417','2017-03-01 00:00:00','2022-03-01 00:00:00',NULL),(250,'QJA/GR/18/II/032','2018-03-21 13:57:34',38,5,350.00,0.00,'','20180126','2018-01-12 00:00:00','2021-01-11 00:00:00',NULL),(251,'QJA/GR/18/II/033','2018-03-21 14:25:26',181,5,75.00,0.00,'','KPO-1711023','2017-11-15 00:00:00',NULL,'2020-11-14 00:00:00'),(252,'QJA/GR/18/II/034','2018-03-21 15:16:09',136,5,25.00,0.00,'','17 12 25','2017-12-25 00:00:00','2019-12-24 00:00:00',NULL),(253,'QJA/GR/18/II/035','2018-03-21 15:22:17',195,5,25.00,0.00,'','021707011','2017-07-19 00:00:00','2021-07-18 00:00:00',NULL),(254,'QJA/GR/18/II/036','2018-03-21 15:38:28',156,5,2.00,0.00,'','APSS17004','2017-07-01 00:00:00','2020-06-01 00:00:00',NULL),(255,'QJA/GR/18/II/037','2018-03-21 15:45:29',191,5,20.00,0.00,'','201712003','2017-12-02 00:00:00','2021-12-01 00:00:00',NULL),(256,'QJA/GR/18/II/038','2018-03-21 15:58:51',87,5,1.00,0.00,'','OP-01/03/17/010','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL),(257,'QJA/GR/18/II/040','2018-03-21 16:14:31',144,5,300.00,0.00,'','185003006','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL),(258,'QJA/GR/18/II/041','2018-03-21 16:25:46',86,5,500.00,0.00,'','BV 212/1117','2017-11-01 00:00:00',NULL,'2022-10-01 00:00:00'),(259,'QJA/GR/18/II/042','2018-03-21 16:34:24',201,5,1.00,0.00,'','HYD/012/17-18','2017-07-01 00:00:00',NULL,'2020-06-01 00:00:00'),(260,'QJA/GR/18/II/043','2018-03-21 16:39:11',178,5,25.00,0.00,'','CIN/01181001','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL),(261,'QJA/GR/18/I/026','2018-04-06 14:03:40',38,5,75.00,0.00,'','20171117','2017-11-03 00:00:00','2020-11-02 00:00:00',NULL),(264,'QJA/GD/18/II/0033','2018-04-06 14:50:43',38,5,0.00,50.00,'','20170929','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL),(265,'QJA/GD/18/II/0033','2018-04-06 14:50:43',38,5,0.00,25.00,'','20171117','2017-11-03 00:00:00','2020-11-02 00:00:00',NULL),(266,'QJA/GD/18/II/0034','2018-04-06 15:22:33',69,5,0.00,25.00,'','W15082709','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00'),(267,'QJA/GD/18/II/0034','2018-04-06 15:22:33',69,5,0.00,50.00,'','W15090903','2015-09-01 00:00:00',NULL,'2020-08-01 00:00:00'),(268,'QJA/GD/18/II/0035','2018-04-06 15:37:36',121,5,0.00,10.00,'','MTP03217','2017-09-30 00:00:00',NULL,'2022-09-01 00:00:00');
/*!40000 ALTER TABLE `tr_stockcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_stockcardsample`
--

DROP TABLE IF EXISTS `tr_stockcardsample`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_stockcardsample` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `refNum` varchar(50) NOT NULL,
  `transactionDate` datetime NOT NULL,
  `productID` int(11) NOT NULL,
  `warehouseID` int(11) NOT NULL,
  `batchNumber` varchar(50) DEFAULT NULL,
  `manufactureDate` datetime DEFAULT NULL,
  `expiredDate` datetime DEFAULT NULL,
  `retestDate` datetime DEFAULT NULL,
  `inQty` decimal(18,4) NOT NULL,
  `outQty` decimal(18,4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_samplestockcard_productid_idx` (`productID`),
  KEY `fk_samplestockcard_warehouseid_idx` (`warehouseID`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_stockcardsample`
--

LOCK TABLES `tr_stockcardsample` WRITE;
/*!40000 ALTER TABLE `tr_stockcardsample` DISABLE KEYS */;
INSERT INTO `tr_stockcardsample` VALUES (7,'QJA/SSR/18/I/002','2018-01-25 15:24:50',122,8,'CO170220','2017-02-20 00:00:00','2019-02-19 00:00:00',NULL,0.0500,0.0000),(10,'QJA/CSD/18/I/001','2018-01-26 15:29:30',122,8,'CO170220','2017-02-20 00:00:00','2019-02-19 00:00:00',NULL,0.0000,0.0500),(17,'QJA/SSR/18/I/003','2018-02-02 08:38:58',199,8,'17010180','2018-01-01 00:00:00',NULL,'2018-12-01 00:00:00',0.1000,0.0000),(45,'QJA/SSR/18/I/004','2018-02-02 10:53:26',152,8,'A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',0.1000,0.0000),(46,'QJA/SSR/18/I/004','2018-02-02 10:53:26',152,8,'A11080515/004','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',0.1000,0.0000),(47,'QJA/SSR/18/I/004','2018-02-02 10:53:26',152,8,'A11080515/005','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',0.1000,0.0000),(48,'QJA/CSD/18/I/002','2018-02-02 10:59:20',152,8,'A11080515/003','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',0.0000,0.1000),(49,'QJA/CSD/18/I/002','2018-02-02 10:59:20',152,8,'A11080515/004','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',0.0000,0.1000),(50,'QJA/CSD/18/I/002','2018-02-02 10:59:20',152,8,'A11080515/005','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',0.0000,0.1000),(51,'QJA/SSR/18/II/004','2018-02-07 09:44:05',208,8,'RS170002','2017-07-02 00:00:00',NULL,'2019-06-02 00:00:00',0.1000,0.0000),(52,'QJA/SSR/18/II/004','2018-02-07 09:44:05',208,8,'WS/RS/03','2017-08-01 00:00:00',NULL,'2017-07-31 00:00:00',0.0001,0.0000),(66,'QJA/CSD/18/II/003','2018-02-07 10:11:58',208,8,'RS170002','2017-07-02 00:00:00',NULL,'2019-06-02 00:00:00',0.0000,0.1000),(67,'QJA/CSD/18/II/003','2018-02-07 10:11:58',208,8,'WS/RS/03','2017-08-01 00:00:00',NULL,'2017-07-31 00:00:00',0.0000,0.0001),(68,'QJA/SSR/18/II/005','2018-02-19 14:01:46',144,8,'185003006','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,0.0100,0.0000),(71,'QJA/CSD/18/II/004','2018-02-20 11:06:14',144,8,'185003006','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,0.0000,0.0100),(72,'QJA/SSR/18/II/006','2018-02-20 11:13:32',177,8,'2488','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,0.0100,0.0000),(73,'QJA/SSR/18/II/006','2018-02-20 11:13:32',177,8,'2474','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,0.0100,0.0000),(74,'QJA/SSR/18/II/006','2018-02-20 11:13:32',177,8,'2487','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,0.0100,0.0000),(75,'QJA/CSD/18/II/005','2018-02-20 15:31:53',177,8,'2474','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,0.0000,0.0100),(76,'QJA/CSD/18/II/005','2018-02-20 15:31:53',177,8,'2487','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,0.0000,0.0100),(77,'QJA/CSD/18/II/005','2018-02-20 15:31:53',177,8,'2488','2017-11-01 00:00:00','2022-10-01 00:00:00',NULL,0.0000,0.0100),(78,'QJA/SSR/17/XII/001','2018-02-26 14:57:14',65,8,'WS/HB/0916','2017-03-01 00:00:00',NULL,'2019-03-01 00:00:00',0.0002,0.0000),(82,'QJA/CSD/18/II/006','2018-02-26 15:11:45',65,8,'WS/HB/0916','2017-03-01 00:00:00',NULL,'2019-03-01 00:00:00',0.0000,0.0002),(86,'QJA/SSR/18/I/001','2018-02-26 16:04:58',138,8,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,0.0070,0.0000),(87,'QJA/SSR/18/I/001','2018-02-26 16:04:58',138,8,'MLAH076121718','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,0.0070,0.0000),(92,'QJA/CSD/18/I/007','2018-02-26 16:40:18',199,8,'17010180','2018-01-01 00:00:00',NULL,'2018-12-01 00:00:00',0.0000,0.1000),(93,'QJA/SSR/18/III/008','2018-03-02 14:48:09',206,8,'17061','2017-10-31 00:00:00','2020-10-30 00:00:00',NULL,0.1000,0.0000),(94,'QJA/SSR/18/III/008','2018-03-02 14:48:09',206,8,'17062','2017-11-01 00:00:00','2020-10-31 00:00:00',NULL,0.1000,0.0000),(95,'QJA/SSR/18/III/008','2018-03-02 14:48:09',206,8,'17063','2017-11-02 00:00:00','2020-11-01 00:00:00',NULL,0.1000,0.0000),(96,'QJA/CSD/18/III/008','2018-03-02 14:51:06',206,8,'17061','2017-10-31 00:00:00','2020-10-30 00:00:00',NULL,0.0000,0.1000),(97,'QJA/CSD/18/III/008','2018-03-02 14:51:06',206,8,'17062','2017-11-01 00:00:00','2020-10-31 00:00:00',NULL,0.0000,0.1000),(98,'QJA/CSD/18/III/008','2018-03-02 14:51:06',206,8,'17063','2017-11-02 00:00:00','2020-11-01 00:00:00',NULL,0.0000,0.1000),(99,'QJA/SSR/18/III/009','2018-03-08 15:59:17',125,8,'TDLPPA16035','2016-05-01 00:00:00','2019-04-01 00:00:00',NULL,0.1000,0.0000),(100,'QJA/CSD/18/III/009','2018-03-08 16:09:16',125,8,'TDLPPA16035','2016-05-01 00:00:00','2019-04-01 00:00:00',NULL,0.0000,0.1000),(101,'QJA/SSR/18/III/010','2018-03-12 16:10:26',138,8,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,0.0500,0.0000),(102,'QJA/CSD/18/III/010','2018-03-12 16:12:36',138,8,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,0.0000,0.0500),(103,'QJA/SSR/18/III/011','2018-03-15 09:53:02',144,8,'174003086','2018-03-01 00:00:00',NULL,'2019-09-18 00:00:00',0.0010,0.0000),(105,'QJA/CSD/18/III/011','2018-03-15 09:58:37',144,8,'174003086','2018-03-01 00:00:00',NULL,'2019-09-18 00:00:00',0.0000,0.0010),(106,'QJA/CSD/18/I/006','2018-03-15 10:09:08',138,8,'MLAH060101718','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,0.0000,0.0070),(107,'QJA/CSD/18/I/006','2018-03-15 10:09:08',138,8,'MLAH076121718','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,0.0000,0.0070),(108,'QJA/SSR/18/III/012','2018-03-29 16:04:12',236,8,'WS0096140','2016-10-12 00:00:00','2018-10-11 00:00:00',NULL,0.5000,0.0000),(109,'QJA/CSD/18/III/012','2018-03-29 16:17:56',236,8,'WS0096140','2016-10-12 00:00:00','2018-10-11 00:00:00',NULL,0.0000,0.5000);
/*!40000 ALTER TABLE `tr_stockcardsample` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_stockhpp`
--

DROP TABLE IF EXISTS `tr_stockhpp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_stockhpp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `stockDate` datetime NOT NULL COMMENT 'Stock Date',
  `refNum` varchar(50) NOT NULL COMMENT 'Reference Number',
  `manufactureDate` datetime DEFAULT NULL,
  `expiredDate` datetime DEFAULT NULL COMMENT 'Expired Date',
  `retestDate` datetime DEFAULT NULL,
  `warehouseID` int(11) NOT NULL COMMENT 'Warehouse ID',
  `productID` int(11) NOT NULL COMMENT 'Product ID',
  `HPP` decimal(18,2) NOT NULL COMMENT 'HPP',
  `qtyStock` decimal(18,2) NOT NULL COMMENT 'Quantity Stock',
  `batchNumber` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_refnumgoodsreceipt_idx` (`refNum`),
  KEY `fk_stockhpp_warehouseid_idx` (`warehouseID`),
  KEY `fk_stockhpp_productid` (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_stockhpp`
--

LOCK TABLES `tr_stockhpp` WRITE;
/*!40000 ALTER TABLE `tr_stockhpp` DISABLE KEYS */;
INSERT INTO `tr_stockhpp` VALUES (1,'2017-10-31 00:00:00','INIT','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL,5,167,2600325.00,10.00,'AP004-15052008'),(2,'2017-10-31 00:00:00','INIT','2016-12-13 00:00:00','2021-12-13 00:00:00',NULL,5,64,83903.00,1300.00,'1604584496'),(3,'2017-10-31 00:00:00','INIT','2017-02-01 00:00:00','2020-01-01 00:00:00',NULL,5,66,1328600.00,75.00,'DITPK17012'),(4,'2017-10-31 00:00:00','INIT','2015-08-01 00:00:00','2020-07-01 00:00:00',NULL,5,152,5879280.00,5.00,'A11080515/004'),(5,'2017-10-31 00:00:00','INIT','2017-06-01 00:00:00','2022-05-01 00:00:00',NULL,5,34,833238.00,100.00,'17ADL005'),(6,'2017-10-31 00:00:00','INIT','2017-03-01 00:00:00','2020-03-01 00:00:00',NULL,5,63,142830.00,1200.00,'A17118A'),(7,'2017-10-31 00:00:00','INIT','2017-09-01 00:00:00','2021-08-01 00:00:00',NULL,5,142,64130.00,1.00,'MCB1709025'),(8,'2017-10-31 00:00:00','INIT','2015-03-01 00:00:00','2020-02-01 00:00:00',NULL,5,165,9531900.00,1.00,'15OS003'),(9,'2017-10-31 00:00:00','INIT','2013-06-01 00:00:00','2016-05-01 00:00:00',NULL,5,166,3825822.00,5.00,'C5127-13-008'),(10,'2017-10-31 00:00:00','INIT','2016-10-04 00:00:00','2018-09-30 00:00:00',NULL,5,83,785821.00,10.00,'MH0027'),(11,'2017-10-31 00:00:00','INIT','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5,39,1282595.00,5.00,'BDOM/1709193'),(12,'2017-10-31 00:00:00','INIT','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,5,144,1093905.00,250.00,'175003074'),(13,'2017-10-31 00:00:00','INIT','2017-05-05 00:00:00','2020-11-04 00:00:00',NULL,5,132,797562.00,24.00,'SC-NM-20170504'),(14,'2017-10-31 00:00:00','INIT','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL,5,80,1224000.00,20.00,'SS/171/16-17'),(15,'2017-12-21 14:24:11','QJA/GR/17/XII/001','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL,5,131,35.20,50.00,'17120701'),(16,'2017-12-21 15:50:09','QJA/GR/17/XII/002','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL,5,134,4631.00,5.00,'17CF03'),(17,'2017-12-21 15:50:33','QJA/GR/17/XII/002','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL,5,134,4631.00,5.00,'17CF03'),(18,'2017-12-21 15:51:36','QJA/GR/17/XII/002','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL,5,134,4631.00,5.00,'17CF03'),(19,'2017-12-21 15:52:01','QJA/GR/17/XII/002','2017-06-27 00:00:00','2022-06-26 00:00:00',NULL,5,134,4631.00,5.00,'17CF03'),(20,'2017-12-21 16:28:26','QJA/GR/17/XII/003','2017-10-30 00:00:00',NULL,'2020-10-29 00:00:00',5,169,102.30,50.00,'C103-171108'),(21,'2017-12-22 09:55:01','QJA/GR/17/XII/001','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL,5,131,35.20,50.00,'17120701'),(22,'2017-12-22 14:03:37','QJA/GR/17/XII/001','2017-12-07 00:00:00','2019-12-06 00:00:00',NULL,5,131,35.20,50.00,'17120701'),(26,'2018-01-26 10:48:18','QJA/GR/18/I/001','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL,5,182,3388500.00,50.00,'217INS1003'),(27,'2018-01-26 14:22:14','QJA/GR/18/I/002','2017-11-01 00:00:00',NULL,'2022-10-01 00:00:00',5,13,19653300.00,10.00,'DB 005/1117'),(28,'2018-01-26 15:46:37','QJA/GR/18/I/001','2017-01-01 00:00:00','2021-12-01 00:00:00',NULL,5,182,3388500.00,50.00,'217INS1003'),(29,'2018-02-01 11:08:14','QJA/GR/18/I/003','2017-11-01 00:00:00',NULL,'2019-10-31 00:00:00',5,176,658805.00,50.00,'4003-20171105'),(30,'2018-02-01 11:30:52','QJA/GR/18/I/004','2017-08-01 00:00:00','2022-07-01 00:00:00',NULL,5,12,1411725.00,75.00,'17FH094'),(31,'2018-02-01 11:47:51','QJA/GR/18/I/005','2017-12-01 00:00:00','2020-11-01 00:00:00',NULL,5,128,2823450.00,15.00,'XMEP170089'),(32,'2018-02-02 14:57:47','QJA/GR/18/I/006','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL,5,158,16134.00,500.00,'PS/DSMB/1016'),(33,'2018-02-05 10:17:15','QJA/GR/18/I/007','2017-11-01 00:00:00',NULL,'2020-10-01 00:00:00',5,194,5109100.00,8.00,'El-03/L020/17026'),(34,'2018-02-05 10:17:15','QJA/GR/18/I/007','2017-12-01 00:00:00',NULL,'2020-11-01 00:00:00',5,194,5109100.00,2.00,'El-03/L020/17030'),(35,'2018-02-05 10:17:15','QJA/GR/18/I/007','2017-11-01 00:00:00',NULL,'2020-10-01 00:00:00',5,194,5109100.00,8.00,'El-03/L020/17026'),(36,'2018-02-05 10:17:15','QJA/GR/18/I/007','2017-12-01 00:00:00',NULL,'2020-11-01 00:00:00',5,194,5109100.00,2.00,'El-03/L020/17030'),(37,'2018-02-05 17:41:22','QJA/GR/18/I/008','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,5,186,684949.65,10.00,'CDAH009121718'),(38,'2018-02-05 17:51:21','QJA/GR/18/I/009','2017-11-25 00:00:00','2022-11-24 00:00:00',NULL,5,17,1268797.25,50.00,'SET401317VE-II'),(39,'2018-02-06 14:15:47','QJA/GR/18/I/010','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',5,69,1526574.00,100.00,'W15082709'),(40,'2018-02-06 14:15:47','QJA/GR/18/I/010','2015-09-01 00:00:00',NULL,'2020-08-01 00:00:00',5,69,1526574.00,100.00,'W15090903'),(41,'2018-02-06 14:15:47','QJA/GR/18/I/010','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',5,69,1526574.00,100.00,'W15082709'),(42,'2018-02-06 14:15:47','QJA/GR/18/I/010','2015-09-01 00:00:00',NULL,'2020-08-01 00:00:00',5,69,1526574.00,100.00,'W15090903'),(43,'2018-02-06 14:33:35','QJA/GR/18/I/011','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',5,152,5691175.00,5.00,'A11080515/003'),(44,'2018-02-06 15:18:29','QJA/GR/18/I/012','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',5,152,6260292.50,10.00,'A11080515/003'),(45,'2018-02-06 15:36:20','QJA/GR/18/I/013','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL,5,184,1740830.00,50.00,'CZH-16 06 012 (B)'),(46,'2018-02-06 15:36:20','QJA/GR/18/I/013','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL,5,184,1740830.00,5.00,'CZH-16 06 012 (B)'),(47,'2018-02-06 15:36:20','QJA/GR/18/I/013','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL,5,184,1740830.00,50.00,'CZH-16 06 012 (B)'),(48,'2018-02-06 15:36:20','QJA/GR/18/I/013','2016-01-01 00:00:00','2020-12-01 00:00:00',NULL,5,184,1740830.00,5.00,'CZH-16 06 012 (B)'),(49,'2018-02-06 15:49:39','QJA/GR/18/I/014','2017-09-30 00:00:00',NULL,'2022-09-01 00:00:00',5,121,1740830.00,10.00,'MTP03217'),(50,'2018-02-06 15:59:31','QJA/GR/18/I/015','2017-10-26 00:00:00',NULL,'2020-10-25 00:00:00',5,135,13257090.00,5.00,'TB-1710032'),(51,'2018-02-06 16:32:21','QJA/GR/18/I/016','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00',5,183,522249.00,25.00,'CZC/364'),(52,'2018-02-06 16:52:35','QJA/GR/18/I/017','2017-12-01 00:00:00',NULL,'2022-11-01 00:00:00',5,153,3213840.00,10.00,'HAL/108'),(53,'2018-02-07 09:07:33','QJA/GR/18/I/018','2017-12-28 00:00:00',NULL,'2019-12-27 00:00:00',5,176,721774.90,75.00,'4003-20180104'),(54,'2018-02-07 10:08:23','QJA/GR/18/I/019','2017-05-01 00:00:00','2022-04-01 00:00:00',NULL,5,207,2553084.60,10.00,'G1705K005'),(55,'2018-02-07 10:33:47','QJA/GR/18/I/020','2017-12-01 00:00:00','2022-11-01 00:00:00',NULL,5,193,23343250.00,5.00,'FP/HTP/002/12/17'),(56,'2018-02-07 11:27:45','QJA/GR/18/I/021','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL,5,155,933730.00,100.00,'GBW1801005'),(57,'2018-02-07 13:01:09','QJA/GR/18/I/022','2018-01-01 00:00:00','2020-12-01 00:00:00',NULL,5,155,933730.00,125.00,'GBW1801005'),(58,'2018-02-07 13:14:38','QJA/GR/18/I/023','2018-01-02 00:00:00','2020-01-01 00:00:00',NULL,5,106,1731402.20,100.00,'ALA.1801021'),(59,'2018-02-07 14:38:40','QJA/GR/18/I/024','2017-11-29 00:00:00','2019-11-28 00:00:00',NULL,5,209,895046.90,25.00,'C0011712003'),(60,'2018-02-07 14:52:45','QJA/GR/18/I/025','2017-08-09 00:00:00',NULL,'2020-07-01 00:00:00',5,175,851028.20,25.00,'W-F03-20170805-01'),(62,'2018-02-07 16:04:44','QJA/GR/18/I/027','2017-09-30 00:00:00','2021-09-30 00:00:00',NULL,5,185,66695.00,2240.00,'P3264'),(63,'2018-02-07 16:19:12','QJA/GR/18/II/028','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,5,77,6656500.00,2.00,'HAL3001725'),(64,'2018-02-07 16:34:28','QJA/GR/18/II/029','2017-12-22 00:00:00','2020-12-21 00:00:00',NULL,5,188,332825.00,25.00,'IHAF171222'),(66,'2018-02-12 11:29:30','QJA/GR/17/XII/002','2015-08-01 00:00:00',NULL,'2020-07-01 00:00:00',5,152,6318730.00,25.00,'A11080515/004'),(67,'2018-02-12 11:40:44','QJA/GR/17/XII/003','2017-11-10 00:00:00','2019-11-09 00:00:00',NULL,5,131,490630.80,50.00,'17111001'),(68,'2018-02-12 15:19:49','QJA/GR/17/XII/004','2017-11-19 00:00:00','2019-11-18 00:00:00',NULL,5,136,438659.10,25.00,'17 11 19'),(69,'2018-02-12 15:42:02','QJA/GR/17/XII/005','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5,34,936797.40,100.00,'17ADL007'),(70,'2018-02-12 15:51:37','QJA/GR/17/XII/006','2017-10-01 00:00:00','2021-09-01 00:00:00',NULL,5,124,743490.00,50.00,'17CTH062'),(71,'2018-02-12 16:09:06','QJA/GR/17/XII/007','2017-09-22 00:00:00','2022-09-22 00:00:00',NULL,5,137,11895840.00,10.00,'NEDNa 171005'),(72,'2018-02-12 16:18:18','QJA/GR/17/XII/008','2017-08-01 00:00:00',NULL,'2022-07-01 00:00:00',5,102,59479.20,300.00,'BB 004/0817'),(73,'2018-02-12 16:27:24','QJA/GR/17/XII/009','2017-07-18 00:00:00','2022-07-18 00:00:00',NULL,5,64,94033.17,10000.00,'1705272729'),(74,'2018-02-12 16:37:18','QJA/GR/17/XII/010','2017-11-01 00:00:00','2021-10-01 00:00:00',NULL,5,37,107466480.00,2.00,'MCB1711033'),(75,'2017-11-06 00:00:00','INIT','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5,140,2025000.00,50.00,'CAMPT/1709023'),(76,'2017-11-06 00:00:00','INIT','2017-01-01 00:00:00','2019-01-01 00:00:00',NULL,5,205,0.00,500.00,'PS/DSMB/1016'),(102,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL,5,38,1030494.30,100.00,'20170823'),(103,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,5,38,1030494.30,200.00,'20170929'),(104,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL,5,38,1030494.30,100.00,'20170823'),(105,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,5,38,1030494.30,200.00,'20170929'),(106,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL,5,38,1030494.30,100.00,'20170823'),(107,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,5,38,1030494.30,200.00,'20170929'),(108,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-08-23 00:00:00','2020-08-22 00:00:00',NULL,5,38,1030494.30,100.00,'20170823'),(109,'2018-02-22 11:05:22','QJA/GR/17/XI/011','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,5,38,1030494.30,200.00,'20170929'),(110,'2018-02-22 15:13:42','QJA/GR/17/XI/012','2017-08-01 00:00:00',NULL,'2020-07-01 00:00:00',5,103,42088700.00,1.00,'MPB 002/0817'),(111,'2018-02-23 10:23:56','QJA/GR/17/XI/013','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,5,38,1030494.30,100.00,'20170929'),(112,'2018-02-23 10:42:17','QJA/GR/18/II/031','2017-09-29 00:00:00','2020-09-28 00:00:00',NULL,5,38,1030494.30,200.00,'20170929'),(113,'2018-02-23 10:48:05','QJA/GR/17/XI/014','2017-04-28 00:00:00',NULL,'2019-04-27 00:00:00',5,46,58.30,75.00,'4003-20170503'),(114,'2018-02-23 13:56:04','QJA/GR/17/XI/015','2017-01-01 00:00:00',NULL,'2019-12-01 00:00:00',5,149,407.00,5.00,'BST200117'),(115,'2018-02-23 16:14:18','QJA/GR/17/XI/016','2017-08-01 00:00:00','2021-07-01 00:00:00',NULL,5,43,55.00,25.00,'17CTH047'),(116,'2018-02-23 16:16:12','QJA/GR/17/XI/017','2017-10-01 00:00:00',NULL,'2022-09-01 00:00:00',5,42,41.80,25.00,'CZC/358'),(117,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,500.00,'TDOMPA 17026'),(118,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,475.00,'TDOMPA 17027'),(119,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,5.00,'TDOMPA 17027'),(120,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,500.00,'TDOMPA 17026'),(121,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,475.00,'TDOMPA 17027'),(122,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,5.00,'TDOMPA 17027'),(123,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,500.00,'TDOMPA 17026'),(124,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,475.00,'TDOMPA 17027'),(125,'2018-02-26 14:43:03','QJA/GR/17/XI/018','2017-10-01 00:00:00','2020-09-01 00:00:00',NULL,5,146,13.00,5.00,'TDOMPA 17027'),(126,'2018-02-26 14:56:03','QJA/GR/17/XI/019','2017-09-01 00:00:00','2020-08-01 00:00:00',NULL,5,145,20.50,50.00,'OP8.5/141800617'),(127,'2018-02-26 17:15:29','QJA/GR/17/XI/020','2017-09-03 00:00:00','2020-09-02 00:00:00',NULL,5,133,55.00,25.00,'170903'),(128,'2018-02-26 17:51:24','QJA/GR/17/II/048','2017-03-01 00:00:00','2022-03-01 00:00:00',NULL,5,214,977.00,10.00,'02020417'),(129,'2018-03-01 09:15:18','QJA/GR/17/XI/033','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,5,44,450.00,2.00,'TBS/125/17-18'),(130,'2018-03-01 14:02:44','QJA/GR/17/XI/034','2017-10-05 00:00:00','2022-10-04 00:00:00',NULL,5,53,2035.00,1.00,'FSD-170905'),(131,'2018-03-01 16:54:12','QJA/GR/17/XI/035','2017-10-09 00:00:00',NULL,'2022-10-08 00:00:00',5,120,1560000.00,10.00,'X1710307M'),(132,'2018-03-02 16:19:56','QJA/GR/17/XI/036','2017-06-26 00:00:00',NULL,'2022-06-26 00:00:00',5,135,11700000.00,5.00,'TB.1706015'),(133,'2018-03-07 14:44:46','QJA/GR/17/XI/037','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5,39,1493470.00,5.00,'BDOM/1709189'),(134,'2018-03-07 15:13:34','QJA/GR/17/XI/038','2017-06-20 00:00:00','2019-06-19 00:00:00',NULL,5,78,38447920.00,10.00,'170603MC-WF'),(138,'2018-03-07 16:01:40','QJA/GR/17/XII/039','2017-07-28 00:00:00','2020-07-27 00:00:00',NULL,5,130,2067948.00,25.00,'DC-0101H-1708001'),(139,'2018-03-08 09:32:48','QJA/GR/17/XI/041','2017-09-01 00:00:00','2022-08-01 00:00:00',NULL,5,219,812280.00,50.00,'CAMPT/1709023'),(140,'2018-03-08 09:47:02','QJA/GR/17/XII/040','2017-07-17 00:00:00','2020-06-01 00:00:00',NULL,5,156,5744300.00,2.00,'APSS17004'),(141,'2018-03-08 14:30:50','QJA/GR/17/XII/042','2017-08-21 00:00:00',NULL,'2022-08-21 00:00:00',5,217,45954400.00,6.00,'213733'),(142,'2018-03-08 14:43:34','QJA/GR/17/XI/043','2017-07-01 00:00:00','2022-06-01 00:00:00',NULL,5,34,853272.00,100.00,'17ADL006'),(143,'2018-03-08 15:16:29','QJA/GR/17/XII/044','2017-11-09 00:00:00',NULL,'2020-11-08 00:00:00',5,157,3582270.00,60.00,'176682006'),(144,'2018-03-08 15:40:17','QJA/GR/17/XII/045','2017-10-01 00:00:00','2022-09-01 00:00:00',NULL,5,138,2040916.00,25.00,'MLAH060101718'),(147,'2018-03-09 14:15:18','QJA/GR/17/V/046','2016-12-13 00:00:00','2021-12-13 00:00:00',NULL,5,64,83903.40,6000.00,'1604584496'),(148,'2018-03-09 14:15:18','QJA/GR/17/V/046','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL,5,64,83903.40,4000.00,'1704770694'),(149,'2018-03-09 14:15:18','QJA/GR/17/V/046','2016-12-13 00:00:00','2021-12-13 00:00:00',NULL,5,64,83903.40,6000.00,'1604584496'),(150,'2018-03-09 14:15:18','QJA/GR/17/V/046','2017-02-22 00:00:00','2022-02-22 00:00:00',NULL,5,64,83903.40,4000.00,'1704770694'),(151,'2018-03-09 14:26:16','QJA/GR/17/XI/047','2017-09-22 00:00:00','2019-09-21 00:00:00',NULL,5,116,609480.00,30.00,'YT20170922'),(152,'2018-03-09 14:37:54','QJA/GR/17/XI/048','2017-10-01 00:00:00',NULL,'2020-09-01 00:00:00',5,25,1218420.00,25.00,'HYD/025/17-18'),(153,'2018-03-20 10:31:09','QJA/GR/18/II/030','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,5,39,1131605.00,25.00,'BDM/1801016'),(154,'2018-03-21 13:57:34','QJA/GR/18/II/032','2018-01-12 00:00:00','2021-01-11 00:00:00',NULL,5,38,920640.00,350.00,'20180126'),(155,'2018-03-21 14:25:26','QJA/GR/18/II/033','2017-11-15 00:00:00',NULL,'2020-11-14 00:00:00',5,181,1061760.00,75.00,'KPO-1711023'),(156,'2018-03-21 15:16:09','QJA/GR/18/II/034','2017-12-25 00:00:00','2019-12-24 00:00:00',NULL,5,136,396480.00,25.00,'17 12 25'),(157,'2018-03-21 15:22:16','QJA/GR/18/II/035','2017-07-19 00:00:00','2021-07-18 00:00:00',NULL,5,195,2956800.00,25.00,'021707011'),(158,'2018-03-21 15:38:28','QJA/GR/18/II/036','2017-07-01 00:00:00','2020-06-01 00:00:00',NULL,5,156,6048000.00,2.00,'APSS17004'),(159,'2018-03-21 15:45:29','QJA/GR/18/II/037','2017-12-02 00:00:00','2021-12-01 00:00:00',NULL,5,191,658560.00,20.00,'201712003'),(160,'2018-03-21 15:58:51','QJA/GR/18/II/038','2017-03-01 00:00:00','2022-02-01 00:00:00',NULL,5,87,6988800.00,1.00,'OP-01/03/17/010'),(161,'2018-03-21 16:14:31','QJA/GR/18/II/040','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,5,144,1088640.00,300.00,'185003006'),(162,'2018-03-21 16:25:46','QJA/GR/18/II/041','2017-11-01 00:00:00',NULL,'2022-10-01 00:00:00',5,86,33600.00,500.00,'BV 212/1117'),(163,'2018-03-21 16:34:24','QJA/GR/18/II/042','2017-07-01 00:00:00',NULL,'2020-06-01 00:00:00',5,201,11893000.00,1.00,'HYD/012/17-18'),(164,'2018-03-21 16:39:11','QJA/GR/18/II/043','2018-01-01 00:00:00','2022-12-01 00:00:00',NULL,5,178,624726.00,25.00,'CIN/01181001'),(168,'2018-04-06 14:03:40','QJA/GR/18/I/026','2017-11-03 00:00:00','2020-11-02 00:00:00',NULL,5,38,94706900.00,75.00,'20171117');
/*!40000 ALTER TABLE `tr_stockhpp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_stockopnamedetail`
--

DROP TABLE IF EXISTS `tr_stockopnamedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_stockopnamedetail` (
  `stockOpnameDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `stockOpnameNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `uomID` int(11) NOT NULL,
  `batchNumber` varchar(50) NOT NULL,
  `manufactureDate` datetime NOT NULL,
  `expiredDate` datetime DEFAULT NULL,
  `retestDate` decimal(18,2) DEFAULT NULL,
  `qtyInStock` decimal(18,2) NOT NULL,
  `qtyReal` decimal(18,2) NOT NULL,
  `HPP` decimal(18,2) NOT NULL,
  PRIMARY KEY (`stockOpnameDetailID`),
  KEY `fk_stockopnamedetail_stocknum_idx` (`stockOpnameNum`),
  KEY `fk_stockopnamedetail_productid_idx` (`productID`),
  KEY `fk_stockopnamedetail_uomid_idx` (`uomID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_stockopnamedetail`
--

LOCK TABLES `tr_stockopnamedetail` WRITE;
/*!40000 ALTER TABLE `tr_stockopnamedetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_stockopnamedetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_stockopnamehead`
--

DROP TABLE IF EXISTS `tr_stockopnamehead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_stockopnamehead` (
  `stockOpnameNum` varchar(50) NOT NULL,
  `stockOpnameDate` datetime NOT NULL,
  `warehouseID` int(11) NOT NULL,
  `notes` text,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`stockOpnameNum`),
  KEY `fk_stockopname_warehouseid_idx` (`warehouseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_stockopnamehead`
--

LOCK TABLES `tr_stockopnamehead` WRITE;
/*!40000 ALTER TABLE `tr_stockopnamehead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_stockopnamehead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_stocktransferdetail`
--

DROP TABLE IF EXISTS `tr_stocktransferdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_stocktransferdetail` (
  `stockTransferDetailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `stockTransferNum` varchar(50) NOT NULL,
  `productID` int(11) NOT NULL,
  `qtyInStock` decimal(18,2) NOT NULL,
  `qtyTransfer` decimal(18,2) NOT NULL,
  PRIMARY KEY (`stockTransferDetailID`),
  KEY `fk_stocktransfer_transfernum_idx` (`stockTransferNum`),
  KEY `fk_stocktransfer_productid_idx` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_stocktransferdetail`
--

LOCK TABLES `tr_stocktransferdetail` WRITE;
/*!40000 ALTER TABLE `tr_stocktransferdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_stocktransferdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_stocktransferhead`
--

DROP TABLE IF EXISTS `tr_stocktransferhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_stocktransferhead` (
  `stockTransferNum` varchar(50) NOT NULL,
  `stockTransferDate` datetime NOT NULL,
  `sourceWarehouseID` int(11) NOT NULL,
  `destinationWarehouseID` int(11) NOT NULL,
  `notes` text,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`stockTransferNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_stocktransferhead`
--

LOCK TABLES `tr_stocktransferhead` WRITE;
/*!40000 ALTER TABLE `tr_stocktransferhead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_stocktransferhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplieradvancebalancedetail`
--

DROP TABLE IF EXISTS `tr_supplieradvancebalancedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplieradvancebalancedetail` (
  `balanceDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `balanceHeadID` int(11) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  PRIMARY KEY (`balanceDetailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplieradvancebalancedetail`
--

LOCK TABLES `tr_supplieradvancebalancedetail` WRITE;
/*!40000 ALTER TABLE `tr_supplieradvancebalancedetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_supplieradvancebalancedetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplieradvancebalancehead`
--

DROP TABLE IF EXISTS `tr_supplieradvancebalancehead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplieradvancebalancehead` (
  `balanceHeadID` int(11) NOT NULL AUTO_INCREMENT,
  `balanceDate` datetime NOT NULL,
  `supplierID` int(11) NOT NULL,
  PRIMARY KEY (`balanceHeadID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplieradvancebalancehead`
--

LOCK TABLES `tr_supplieradvancebalancehead` WRITE;
/*!40000 ALTER TABLE `tr_supplieradvancebalancehead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_supplieradvancebalancehead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplieradvancepayment`
--

DROP TABLE IF EXISTS `tr_supplieradvancepayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplieradvancepayment` (
  `supplierAdvancePaymentNum` varchar(50) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `supplierAdvancePaymentDate` datetime NOT NULL,
  `supplierID` int(11) NOT NULL,
  `paymentCOA` varchar(20) DEFAULT NULL,
  `treasuryCOA` varchar(20) DEFAULT NULL,
  `currencyID` varchar(5) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `adminFeePaymentCoa` varchar(20) DEFAULT NULL,
  `adminFeeRate` decimal(18,2) DEFAULT NULL,
  `adminFeeAmount` decimal(18,2) DEFAULT NULL,
  `additionalInfo` text,
  `createdBy` varchar(50) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedBy` varchar(50) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY (`supplierAdvancePaymentNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplieradvancepayment`
--

LOCK TABLES `tr_supplieradvancepayment` WRITE;
/*!40000 ALTER TABLE `tr_supplieradvancepayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_supplieradvancepayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplierinvoicedetail`
--

DROP TABLE IF EXISTS `tr_supplierinvoicedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplierinvoicedetail` (
  `supplierInvoiceDetailID` bigint(20) NOT NULL COMMENT 'Supplier Invoice Detail ID',
  `supplierInvoiceNum` varchar(50) NOT NULL COMMENT 'Supplier Invoice Number',
  `invoiceNum` varchar(50) NOT NULL COMMENT 'Invoice Number',
  `invoiceDate` datetime DEFAULT NULL COMMENT 'Invoice Date',
  `dueDate` datetime DEFAULT NULL COMMENT 'Due Date',
  `taxInvoice` varchar(20) DEFAULT NULL COMMENT 'Tax Invoice',
  `taxAmount` decimal(18,2) DEFAULT NULL COMMENT 'Tax Amount',
  `amount` decimal(18,2) NOT NULL COMMENT 'Amount',
  `freight` decimal(18,2) DEFAULT NULL COMMENT 'Freight',
  `subTotal` decimal(18,2) NOT NULL COMMENT 'Sub Total',
  PRIMARY KEY (`supplierInvoiceDetailID`),
  KEY `fk_supplierinvoicenum_supplierinvoicehead_idx` (`supplierInvoiceNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplierinvoicedetail`
--

LOCK TABLES `tr_supplierinvoicedetail` WRITE;
/*!40000 ALTER TABLE `tr_supplierinvoicedetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_supplierinvoicedetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplierinvoicehead`
--

DROP TABLE IF EXISTS `tr_supplierinvoicehead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplierinvoicehead` (
  `supplierInvoiceNum` varchar(50) NOT NULL COMMENT 'Supplier Invoice Number',
  `invoiceTransactionDate` datetime NOT NULL COMMENT 'Invoice Transaction Date',
  `currencyID` varchar(10) NOT NULL COMMENT 'Currency ID',
  `rate` decimal(10,0) NOT NULL COMMENT 'Rate',
  `paymentID` smallint(6) NOT NULL COMMENT 'Payment ID',
  `systemTotal` decimal(18,2) NOT NULL COMMENT 'System Total',
  `invoiceTotal` decimal(18,2) NOT NULL COMMENT 'Invoice Total',
  `additionalInfo` varchar(200) DEFAULT NULL COMMENT 'Additional Info',
  `createdBy` varchar(50) NOT NULL COMMENT 'Create By',
  `createdDate` datetime NOT NULL COMMENT 'Create Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`supplierInvoiceNum`),
  KEY `fk_currencyid_supplierinvoice_idx` (`currencyID`),
  KEY `fk_paymentid_supplierinvoice_idx` (`paymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplierinvoicehead`
--

LOCK TABLES `tr_supplierinvoicehead` WRITE;
/*!40000 ALTER TABLE `tr_supplierinvoicehead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_supplierinvoicehead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplierpayabledetail`
--

DROP TABLE IF EXISTS `tr_supplierpayabledetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplierpayabledetail` (
  `payableDetailID` bigint(20) NOT NULL AUTO_INCREMENT,
  `payableNum` int(11) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `rate` decimal(18,2) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  PRIMARY KEY (`payableDetailID`),
  KEY `fk_supplierpayabledetail_currency_idx` (`currency`),
  KEY `fk_supplierpayabledetail_payablenum_idx` (`payableNum`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplierpayabledetail`
--

LOCK TABLES `tr_supplierpayabledetail` WRITE;
/*!40000 ALTER TABLE `tr_supplierpayabledetail` DISABLE KEYS */;
INSERT INTO `tr_supplierpayabledetail` VALUES (1,1,'QJA/GR/17/X/004','EURO',14000.00,4800.00),(2,2,'QJA/GR/17/X/005','USD',13000.00,0.00),(3,3,'QJA/GR/17/X/006','USD',13000.00,0.00),(4,4,'QJA/GR/17/X/010','USD',63.00,0.00),(5,5,'QJA/GR/17/X/010','USD',63.00,0.00),(6,6,'QJA/GR/17/X/015','USD',13262.00,475.00),(7,7,'QJA/GR/17/X/018','USD',13337.00,6768.12),(8,8,'QJA/GR/17/X/018','USD',13337.00,6768.12),(9,9,'QJA/GR/17/XI/019','USD',13000.00,3230.25),(10,10,'QJA/GR/17/XI/019','USD',13000.00,3230.25),(11,11,'QJA/GR/17/XI/020','USD',13000.00,2868.75),(12,12,'QJA/GR/17/XI/021','USD',13000.00,3136.72),(13,13,'QJA/GR/17/XI/022','USD',13000.00,14257.81),(14,14,'QJA/GR/17/XI/023','USD',13000.00,2737.50),(15,15,'QJA/GR/17/XI/020','USD',13000.00,1485.00),(16,16,'QJA/GR/17/XI/023','USD',13000.00,1320.00),(17,17,'QJA/GR/17/XI/020','USD',13000.00,1485.00),(18,18,'QJA/GR/17/XI/023','USD',13000.00,1320.00),(19,19,'QJA/GR/17/XI/022','USD',13000.00,6875.00),(20,20,'QJA/GR/17/XI/024','USD',13000.00,14257.81),(21,21,'QJA/GR/17/XI/024','USD',13000.00,6875.00),(22,22,'QJA/GR/17/XI/024','USD',13000.00,6875.00),(23,23,'QJA/GR/17/XI/025','USD',13000.00,14371.87),(24,24,'QJA/GR/17/XI/025','USD',13000.00,6930.00),(25,25,'QJA/GR/17/XI/027','USD',13000.00,10265.63),(26,26,'QJA/GR/17/XI/027','USD',13000.00,4950.00),(27,27,'QJA/GR/17/XI/028','USD',13000.00,4781.25),(28,28,'QJA/GR/17/XI/028','USD',13000.00,2475.00),(29,29,'QJA/GR/17/XI/028','USD',13000.00,2475.00),(30,30,'QJA/GR/17/XI/028','USD',13000.00,4781.25),(31,31,'QJA/GR/17/XI/028','USD',13000.00,2475.00),(32,32,'QJA/GR/17/XI/029','USD',13000.00,22287.81),(33,33,'QJA/GR/17/XI/029','USD',13000.00,22287.81),(34,34,'QJA/GR/17/XI/029','USD',13000.00,10747.00),(35,35,'QJA/GR/17/XI/030','USD',13000.00,2053.12),(36,36,'QJA/GR/17/XI/031','USD',13000.00,7071.87),(37,37,'QJA/GR/17/XI/031','USD',13000.00,3410.00),(38,38,'QJA/GR/17/XI/031','USD',13000.00,3410.00),(39,39,'QJA/GR/17/XI/031','USD',13000.00,3410.00),(40,40,'QJA/GR/17/XII/001','USD',13000.00,3650.00),(41,41,'QJA/GR/17/XII/001','USD',13000.00,1760.00),(42,42,'QJA/GR/17/XII/002','USD',13000.00,44731.25),(43,43,'QJA/GR/17/XII/003','USD',13000.00,10607.81),(44,44,'QJA/GR/17/XII/003','USD',13000.00,5115.00),(45,45,'QJA/GR/17/XII/001','USD',13000.00,1760.00),(46,46,'QJA/GR/17/XII/001','USD',13000.00,3650.00),(47,47,'QJA/GR/17/XII/001','USD',13000.00,1760.00),(48,48,'QJA/GR/17/XI/004','USD',13000.00,15740.62),(49,49,'QJA/GR/17/XI/004','USD',13000.00,7590.00),(50,50,'QJA/GR/17/XI/004','USD',13000.00,7590.00),(51,51,'QJA/GR/17/XI/004','USD',13000.00,7590.00),(52,52,'QJA/GR/18/I/001','USD',13000.00,0.00),(54,54,'QJA/GR/18/I/001','USD',13000.00,12500.00),(55,55,'QJA/GR/18/I/002','USD',0.00,29362.50),(56,56,'QJA/GR/18/I/002','USD',0.00,14500.00),(57,57,'QJA/GR/18/I/001','USD',13000.00,12500.00),(58,58,'QJA/GR/18/I/003','USD',0.00,27203.12),(59,59,'QJA/GR/18/I/003','USD',0.00,4961.25),(60,60,'QJA/GR/18/I/003','USD',0.00,2450.00),(61,61,'QJA/GR/18/I/004','USD',0.00,27203.12),(62,62,'QJA/GR/18/I/004','USD',0.00,7875.00),(63,63,'QJA/GR/18/I/005','USD',0.00,6378.75),(64,64,'QJA/GR/18/I/005','USD',0.00,3150.00),(65,65,'QJA/GR/18/I/006','USD',13000.00,1215.00),(66,66,'QJA/GR/18/I/006','USD',13000.00,600.00),(67,67,'QJA/GR/18/I/007','USD',13000.00,8577.55),(68,68,'QJA/GR/18/I/007','USD',13000.00,3800.00),(69,69,'QJA/GR/18/I/007','USD',13000.00,8577.55),(70,70,'QJA/GR/18/I/007','USD',13000.00,3800.00),(71,71,'QJA/GR/18/I/008','USD',13000.00,988.12),(72,72,'QJA/GR/18/I/008','USD',13000.00,988.12),(73,73,'QJA/GR/18/I/008','USD',13000.00,511.50),(74,74,'QJA/GR/18/I/009','USD',13000.00,16042.37),(75,75,'QJA/GR/18/I/009','USD',13000.00,4737.50),(76,76,'QJA/GR/18/I/010','USD',13000.00,46170.00),(77,77,'QJA/GR/18/I/010','USD',13000.00,22800.00),(78,78,'QJA/GR/18/I/011','USD',13000.00,4303.13),(79,79,'QJA/GR/18/I/011','USD',13000.00,2125.00),(80,80,'QJA/GR/18/I/012','USD',13569.00,0.00),(81,81,'QJA/GR/18/I/012','USD',13569.00,9031.25),(82,82,'QJA/GR/18/I/012','USD',13569.00,4675.00),(83,83,'QJA/GR/18/I/013','USD',13000.00,14478.75),(84,84,'QJA/GR/18/I/013','USD',13000.00,7150.00),(85,85,'QJA/GR/18/I/014','USD',13000.00,2632.50),(86,86,'QJA/GR/18/I/014','USD',13000.00,1300.00),(87,87,'QJA/GR/18/I/015','USD',13569.00,9562.50),(88,88,'QJA/GR/18/I/015','USD',13569.00,4950.00),(89,89,'QJA/GR/18/I/016','USD',13000.00,1974.37),(90,90,'QJA/GR/18/I/016','USD',13000.00,975.00),(91,91,'QJA/GR/18/I/017','USD',13000.00,4860.00),(92,92,'QJA/GR/18/I/017','USD',13000.00,2400.00),(93,93,'QJA/GR/18/I/018','USD',13000.00,7809.37),(94,94,'QJA/GR/18/I/018','USD',13000.00,4042.50),(95,95,'QJA/GR/18/I/019','USD',13000.00,3697.50),(96,96,'QJA/GR/18/I/019','USD',13000.00,1914.00),(97,97,'QJA/GR/18/I/020','USD',13000.00,17718.75),(98,98,'QJA/GR/18/I/020','USD',13000.00,8750.00),(99,99,'QJA/GR/18/I/021','USD',13000.00,14175.00),(100,100,'QJA/GR/18/I/021','USD',13000.00,7000.00),(101,101,'QJA/GR/18/I/022','USD',13000.00,17718.75),(102,102,'QJA/GR/18/I/022','USD',13000.00,8750.00),(103,103,'QJA/GR/18/I/023','USD',13000.00,25075.00),(104,104,'QJA/GR/18/I/023','USD',13000.00,12980.00),(105,105,'QJA/GR/18/I/024','USD',13000.00,3478.91),(106,106,'QJA/GR/18/I/024','USD',13000.00,1677.50),(107,107,'QJA/GR/18/I/025','USD',13000.00,3307.81),(108,108,'QJA/GR/18/I/025','USD',13000.00,1595.00),(109,109,'QJA/GR/18/I/026','USD',13000.00,10783.12),(110,110,'QJA/GR/18/I/026','USD',13000.00,5325.00),(111,111,'QJA/GR/18/I/027','USD',13000.00,22680.00),(112,112,'QJA/GR/18/I/027','USD',13000.00,11200.00),(113,113,'QJA/GR/18/II/028','USD',13000.00,2025.00),(114,114,'QJA/GR/18/II/028','USD',13000.00,1000.00),(115,115,'QJA/GR/18/II/029','USD',13000.00,1265.63),(116,116,'QJA/GR/18/II/029','USD',13000.00,625.00),(117,117,'QJA/GR/17/XI/001','USD',13000.00,31481.25),(118,118,'QJA/GR/17/XI/001','USD',13000.00,15180.00),(119,119,'QJA/GR/17/XII/002','USD',13000.00,22578.12),(120,120,'QJA/GR/17/XII/002','USD',13000.00,11687.50),(121,121,'QJA/GR/17/XII/003','USD',13000.00,3506.25),(122,122,'QJA/GR/17/XII/003','USD',13000.00,1815.00),(123,123,'QJA/GR/17/XII/004','USD',13000.00,1567.19),(124,124,'QJA/GR/17/XII/004','USD',13000.00,811.25),(125,125,'QJA/GR/17/XII/005','USD',13000.00,13387.50),(126,126,'QJA/GR/17/XII/005','USD',13000.00,6930.00),(127,127,'QJA/GR/17/XII/006','USD',13000.00,5312.50),(128,128,'QJA/GR/17/XII/006','USD',13000.00,2750.00),(129,129,'QJA/GR/17/XII/007','USD',13000.00,17000.00),(130,130,'QJA/GR/17/XII/007','USD',13000.00,8800.00),(131,131,'QJA/GR/17/XII/008','USD',13000.00,2550.00),(132,132,'QJA/GR/17/XII/008','USD',13000.00,1320.00),(133,133,'QJA/GR/17/XII/009','USD',13325.00,133875.00),(134,134,'QJA/GR/17/XII/009','USD',13325.00,69300.00),(135,135,'QJA/GR/17/XII/010','USD',13000.00,30600.00),(136,136,'QJA/GR/17/XII/010','USD',13000.00,15840.00),(137,137,'QJA/GR/17/XI/011','USD',13000.00,34225777.30),(138,138,'QJA/GR/17/XI/011','USD',13000.00,34225777.30),(139,139,'QJA/GR/17/XI/011','USD',13000.00,45540.00),(140,140,'QJA/GR/17/XI/012','USD',13000.00,6277.50),(141,141,'QJA/GR/17/XI/012','USD',13000.00,3100.00),(142,142,'QJA/GR/17/XI/013','USD',13000.00,14662.50),(143,143,'QJA/GR/17/XI/013','USD',13000.00,7590.00),(144,144,'QJA/GR/18/II/031','USD',13000.00,22817185.60),(145,145,'QJA/GR/18/II/031','USD',13000.00,15180.00),(146,0,'QJA/GR/17/XI/014','USD',13000.00,8446.87),(147,146,'QJA/GR/17/XI/014','USD',13000.00,4372.50),(148,0,'QJA/GR/17/XI/014','USD',13000.00,8556444.60),(149,147,'QJA/GR/18/II/029','USD',13000.00,1042000.00),(150,0,'QJA/GR/17/XI/015','USD',13000.00,3931.25),(151,148,'QJA/GR/17/XI/015','USD',13000.00,2035.00),(152,0,'QJA/GR/17/XI/015','USD',13000.00,3140000.00),(153,0,'QJA/GR/17/XI/015','USD',13000.00,3140000.00),(154,0,'QJA/GR/17/XI/016','USD',13000.00,2656.25),(155,149,'QJA/GR/17/XI/016','USD',13000.00,1375.00),(156,0,'QJA/GR/17/XI/017','USD',13000.00,2018.75),(157,150,'QJA/GR/17/XI/017','USD',13000.00,1045.00),(158,0,'QJA/GR/17/XI/016','USD',13000.00,1956000.00),(159,0,'QJA/GR/17/XI/017','USD',13000.00,1956000.00),(160,151,'QJA/GR/17/XI/018','USD',13000.00,25798.50),(161,152,'QJA/GR/17/XI/018','USD',13000.00,12740.00),(162,153,'QJA/GR/17/XI/019','USD',13000.00,2075.63),(163,154,'QJA/GR/17/XI/019','USD',13000.00,1025.00),(164,155,'QJA/GR/17/XI/018','USD',13000.00,22648000.00),(165,156,'QJA/GR/17/XI/019','USD',13000.00,1823000.00),(166,0,'QJA/GR/17/XI/020','USD',13000.00,2784.37),(167,157,'QJA/GR/17/XI/020','USD',13000.00,1375.00),(168,0,'QJA/GR/17/XI/020','USD',13000.00,2329000.00),(169,158,'QJA/GR/17/II/048','USD',13000.00,21261.96),(170,159,'QJA/GR/17/II/048','USD',13000.00,9770.00),(171,160,'QJA/GR/17/II/048','USD',13000.00,17359000.00),(172,161,'QJA/GR/17/XI/033','USD',13000.00,1822.50),(173,162,'QJA/GR/17/XI/033','USD',13000.00,900.00),(174,163,'QJA/GR/17/XI/033','USD',13000.00,2668000.00),(175,164,'QJA/GR/17/XI/034','USD',13000.00,0.00),(176,165,'QJA/GR/17/XI/034','USD',13000.00,2035.00),(177,0,'QJA/GR/17/XI/035','USD',13000.00,2430.00),(178,166,'QJA/GR/17/XI/035','USD',13000.00,1200.00),(179,0,'QJA/GR/17/XI/035','USD',13000.00,2134000.00),(180,0,'QJA/GR/17/XI/036','USD',13000.00,9112.50),(181,167,'QJA/GR/17/XI/036','USD',13000.00,4500.00),(182,168,'QJA/GR/17/XI/037','USD',13000.00,934000.00),(183,169,'QJA/GR/17/XI/037','USD',13000.00,550.00),(184,170,'QJA/GR/17/XI/038','USD',13000.00,48060000.00),(185,171,'QJA/GR/17/XI/038','USD',13000.00,28400.00),(186,172,'QJA/GR/17/XII/039','USD',13000.00,6787000.00),(187,173,'QJA/GR/17/XII/039','USD',13000.00,6787000.00),(188,174,'QJA/GR/17/XII/039','USD',13000.00,3825.00),(189,175,'QJA/GR/17/XI/041','USD',13000.00,7363000.00),(190,176,'QJA/GR/17/XI/041','USD',13000.00,3000.00),(191,177,'QJA/GR/17/XII/040','USD',13000.00,1437000.00),(192,178,'QJA/GR/17/XII/040','USD',13000.00,850.00),(193,179,'QJA/GR/17/XII/042','USD',13000.00,41310.00),(194,180,'QJA/GR/17/XII/042','USD',13000.00,20400.00),(195,181,'QJA/GR/17/XI/043','USD',13000.00,12757.50),(196,182,'QJA/GR/17/XI/043','USD',13000.00,6300.00),(197,183,'QJA/GR/17/XII/044','USD',13000.00,57879000.00),(198,184,'QJA/GR/17/XII/044','USD',13000.00,31540883.00),(199,185,'QJA/GR/17/XII/044','USD',13000.00,15900.00),(200,186,'QJA/GR/17/XII/045','USD',13000.00,9250000.00),(201,187,'QJA/GR/17/XII/045','USD',13000.00,3775.00),(202,188,'QJA/GR/17/XI/046','USD',13000.00,3809000.00),(203,189,'QJA/GR/17/XI/046','USD',13000.00,2250.00),(204,190,'QJA/GR/17/XI/047','USD',13000.00,2287000.00),(205,191,'QJA/GR/17/XI/047','USD',13000.00,1350.00),(206,192,'QJA/GR/17/XI/047','USD',13000.00,2287000.00),(207,193,'QJA/GR/17/V/046','USD',13000.00,105404000.00),(208,194,'QJA/GR/17/V/046','USD',13000.00,63000.00),(209,195,'QJA/GR/17/XI/047','USD',13000.00,2287000.00),(210,196,'QJA/GR/17/XI/047','USD',13000.00,1350.00),(211,197,'QJA/GR/17/XI/048','USD',13000.00,3809000.00),(212,198,'QJA/GR/17/XI/048','USD',13000.00,2250.00),(213,199,'QJA/GR/17/XI/047','USD',13000.00,2287000.00),(214,200,'QJA/GR/18/II/030','USD',13000.00,3538000.00),(215,201,'QJA/GR/18/II/030','USD',13000.00,2125.00),(216,202,'QJA/GR/18/II/032','USD',13000.00,40279000.00),(217,203,'QJA/GR/18/II/032','USD',13000.00,23975.00),(218,204,'QJA/GR/18/II/033','USD',13000.00,9955000.00),(219,205,'QJA/GR/18/II/033','USD',13000.00,5925.00),(220,206,'QJA/GR/18/II/034','USD',13000.00,3710832.50),(221,207,'QJA/GR/18/II/034','USD',13000.00,737.50),(222,208,'QJA/GR/18/II/035','USD',13000.00,3710832.50),(223,209,'QJA/GR/18/II/035','USD',13000.00,5500.00),(224,210,'QJA/GR/18/II/036','USD',13000.00,1513000.00),(225,211,'QJA/GR/18/II/036','USD',13000.00,900.00),(226,212,'QJA/GR/18/II/037','USD',13000.00,1984.50),(227,213,'QJA/GR/18/II/037','USD',13000.00,4705335.00),(228,214,'QJA/GR/18/II/037','USD',13000.00,980.00),(229,215,'QJA/GR/18/II/038','USD',13000.00,1084000.00),(230,216,'QJA/GR/18/II/038','USD',13000.00,520.00),(231,217,'QJA/GR/18/II/040','USD',13000.00,59197000.00),(232,218,'QJA/GR/18/II/040','USD',13000.00,24300.00),(233,219,'QJA/GR/18/II/041','USD',13000.00,2100000.00),(234,220,'QJA/GR/18/II/041','USD',13000.00,1250.00),(235,221,'QJA/GR/18/II/042','USD',13000.00,1488000.00),(236,222,'QJA/GR/18/II/042','USD',13000.00,875.00),(237,223,'QJA/GR/18/II/043','USD',13000.00,2831000.00),(238,224,'QJA/GR/18/II/043','USD',13000.00,1150.00),(239,225,'QJA/GR/18/II/044','USD',13000.00,4162000.00),(240,226,'QJA/GR/18/I/026','USD',13000.00,5325.00);
/*!40000 ALTER TABLE `tr_supplierpayabledetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplierpayablehead`
--

DROP TABLE IF EXISTS `tr_supplierpayablehead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplierpayablehead` (
  `payableNum` int(11) NOT NULL AUTO_INCREMENT,
  `payableDate` datetime NOT NULL,
  `supplierID` int(11) NOT NULL,
  PRIMARY KEY (`payableNum`),
  KEY `fk_supplierpayablehead_supplierid_idx` (`supplierID`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplierpayablehead`
--

LOCK TABLES `tr_supplierpayablehead` WRITE;
/*!40000 ALTER TABLE `tr_supplierpayablehead` DISABLE KEYS */;
INSERT INTO `tr_supplierpayablehead` VALUES (1,'2017-10-09 16:23:31',2),(2,'2017-10-11 08:18:12',7),(3,'2017-10-11 09:01:55',14),(4,'2017-10-11 11:40:12',7),(5,'2017-10-11 11:53:16',7),(6,'2017-10-19 13:13:02',36),(7,'2017-10-24 16:55:00',7),(8,'2017-10-25 11:19:23',7),(9,'2017-11-03 14:55:37',7),(10,'2017-11-03 16:46:56',7),(11,'2017-11-17 09:58:43',7),(12,'2017-11-17 15:49:28',7),(13,'2017-11-17 16:19:29',7),(14,'2017-11-22 09:39:27',7),(15,'2017-11-22 09:39:52',46),(16,'2017-11-22 09:42:13',62),(17,'2017-11-22 10:04:48',46),(18,'2017-11-22 14:48:09',62),(19,'2017-11-22 14:55:00',35),(20,'2017-11-22 15:19:18',7),(21,'2017-11-22 15:23:11',17),(22,'2017-11-22 15:35:16',17),(23,'2017-11-23 16:50:53',7),(24,'2017-11-23 16:53:18',23),(25,'2017-11-27 09:59:36',7),(26,'2017-11-27 10:01:50',4),(27,'2017-11-27 14:07:06',7),(28,'2017-11-27 14:09:11',21),(29,'2017-11-27 14:10:43',21),(30,'2017-11-27 14:29:56',7),(31,'2017-11-27 14:30:33',21),(32,'2017-11-27 16:29:55',7),(33,'2017-11-27 16:30:56',7),(34,'2017-11-27 16:36:17',18),(35,'2017-11-28 15:11:27',7),(36,'2017-11-28 16:08:06',7),(37,'2017-11-28 16:10:09',14),(38,'2017-11-28 16:28:23',14),(39,'2017-11-28 16:36:33',14),(40,'2017-12-21 14:22:14',7),(41,'2017-12-21 14:24:11',11),(42,'2017-12-21 15:47:31',7),(43,'2017-12-21 16:26:33',7),(44,'2017-12-21 16:28:27',43),(45,'2017-12-22 09:55:01',11),(46,'2017-12-22 14:03:14',7),(47,'2017-12-22 14:03:37',11),(48,'2017-12-22 14:24:02',7),(49,'2017-12-22 14:25:55',11),(50,'2017-12-22 14:37:31',11),(51,'2018-01-16 13:30:24',11),(52,'2018-01-25 15:25:08',7),(54,'2018-01-26 10:48:18',2),(55,'2018-01-26 14:19:05',7),(56,'2018-01-26 14:22:14',14),(57,'2018-01-26 15:46:38',2),(58,'2018-01-26 16:45:13',7),(59,'2018-02-01 11:04:42',7),(60,'2018-02-01 11:08:14',78),(61,'2018-02-01 11:27:08',7),(62,'2018-02-01 11:30:53',23),(63,'2018-02-01 11:45:39',7),(64,'2018-02-01 11:47:51',9),(65,'2018-02-02 14:55:45',77),(66,'2018-02-02 14:57:47',14),(67,'2018-02-02 15:17:42',7),(68,'2018-02-02 15:19:56',27),(69,'2018-02-05 10:14:17',7),(70,'2018-02-05 10:17:15',27),(71,'2018-02-05 13:40:20',7),(72,'2018-02-05 17:35:54',7),(73,'2018-02-05 17:41:22',16),(74,'2018-02-05 17:49:48',7),(75,'2018-02-05 17:51:21',16),(76,'2018-02-06 14:13:35',7),(77,'2018-02-06 14:15:48',40),(78,'2018-02-06 14:30:53',7),(79,'2018-02-06 14:33:35',20),(80,'2018-02-06 14:46:50',7),(81,'2018-02-06 15:17:03',7),(82,'2018-02-06 15:18:29',20),(83,'2018-02-06 15:33:40',7),(84,'2018-02-06 15:36:20',2),(85,'2018-02-06 15:48:21',7),(86,'2018-02-06 15:49:39',9),(87,'2018-02-06 15:57:05',7),(88,'2018-02-06 15:59:32',70),(89,'2018-02-06 16:30:30',7),(90,'2018-02-06 16:32:21',16),(91,'2018-02-06 16:51:17',7),(92,'2018-02-06 16:52:35',16),(93,'2018-02-07 09:04:24',7),(94,'2018-02-07 09:07:33',78),(95,'2018-02-07 10:06:46',7),(96,'2018-02-07 10:08:23',16),(97,'2018-02-07 10:20:38',7),(98,'2018-02-07 10:33:47',70),(99,'2018-02-07 11:23:52',7),(100,'2018-02-07 11:27:45',61),(101,'2018-02-07 12:59:41',7),(102,'2018-02-07 13:01:09',61),(103,'2018-02-07 13:12:00',7),(104,'2018-02-07 13:14:38',70),(105,'2018-02-07 14:34:58',7),(106,'2018-02-07 14:38:40',11),(107,'2018-02-07 14:50:58',7),(108,'2018-02-07 14:52:45',2),(109,'2018-02-07 15:07:35',7),(110,'2018-02-07 15:08:50',11),(111,'2018-02-07 16:02:31',7),(112,'2018-02-07 16:04:45',70),(113,'2018-02-07 16:17:18',7),(114,'2018-02-07 16:19:12',33),(115,'2018-02-07 16:31:46',7),(116,'2018-02-07 16:34:28',43),(117,'2018-02-12 09:22:10',7),(118,'2018-02-12 11:15:13',11),(119,'2018-02-12 11:27:24',7),(120,'2018-02-12 11:29:30',20),(121,'2018-02-12 11:38:47',7),(122,'2018-02-12 11:40:44',11),(123,'2018-02-12 15:15:00',7),(124,'2018-02-12 15:19:50',40),(125,'2018-02-12 15:38:46',7),(126,'2018-02-12 15:42:02',23),(127,'2018-02-12 15:50:11',7),(128,'2018-02-12 15:51:37',27),(129,'2018-02-12 16:07:48',7),(130,'2018-02-12 16:09:07',43),(131,'2018-02-12 16:16:01',7),(132,'2018-02-12 16:18:19',14),(133,'2018-02-12 16:25:01',7),(134,'2018-02-12 16:27:24',2),(135,'2018-02-12 16:34:45',7),(136,'2018-02-12 16:37:18',34),(137,'2018-02-22 10:11:38',7),(138,'2018-02-22 11:03:30',7),(139,'2018-02-22 11:05:22',11),(140,'2018-02-22 15:10:03',7),(141,'2018-02-22 15:13:42',14),(142,'2018-02-22 15:51:00',7),(143,'2018-02-23 10:23:56',11),(144,'2018-02-23 10:38:23',7),(145,'2018-02-23 10:42:18',11),(146,'2018-02-23 10:48:05',11),(147,'2018-02-23 13:47:47',7),(148,'2018-02-23 13:56:04',70),(149,'2018-02-23 16:14:18',39),(150,'2018-02-23 16:16:12',39),(151,'2018-02-26 14:42:49',10),(152,'2018-02-26 14:43:03',19),(153,'2018-02-26 14:55:51',10),(154,'2018-02-26 14:56:03',38),(155,'2018-02-26 14:56:12',10),(156,'2018-02-26 16:21:25',10),(157,'2018-02-26 17:15:30',11),(158,'2018-02-26 17:50:56',10),(159,'2018-02-26 17:51:24',70),(160,'2018-02-28 16:37:17',10),(161,'2018-03-01 09:14:48',76),(162,'2018-03-01 09:15:18',41),(163,'2018-03-01 13:17:41',76),(164,'2018-03-01 13:58:56',76),(165,'2018-03-01 14:02:44',43),(166,'2018-03-01 16:54:13',62),(167,'2018-03-02 16:19:56',70),(168,'2018-03-07 14:43:02',7),(169,'2018-03-07 14:44:46',36),(170,'2018-03-07 15:11:37',7),(171,'2018-03-07 15:13:34',40),(172,'2018-03-07 15:37:25',7),(173,'2018-03-07 16:00:11',7),(174,'2018-03-07 16:01:40',11),(175,'2018-03-08 09:30:39',7),(176,'2018-03-08 09:32:49',27),(177,'2018-03-08 09:45:17',7),(178,'2018-03-08 09:47:02',16),(179,'2018-03-08 14:28:41',7),(180,'2018-03-08 14:30:50',44),(181,'2018-03-08 14:41:39',7),(182,'2018-03-08 14:43:35',23),(183,'2018-03-08 15:04:41',7),(184,'2018-03-08 15:12:15',7),(185,'2018-03-08 15:16:29',40),(186,'2018-03-08 15:38:22',7),(187,'2018-03-08 15:40:17',70),(188,'2018-03-08 16:14:28',7),(189,'2018-03-08 16:16:44',70),(190,'2018-03-08 16:30:03',7),(191,'2018-03-08 16:31:48',62),(192,'2018-03-08 16:45:22',7),(193,'2018-03-09 14:13:04',7),(194,'2018-03-09 14:15:18',2),(195,'2018-03-09 14:24:06',7),(196,'2018-03-09 14:26:16',46),(197,'2018-03-09 14:35:42',7),(198,'2018-03-09 14:37:54',21),(199,'2018-03-09 14:50:44',7),(200,'2018-03-20 10:28:50',7),(201,'2018-03-20 10:31:09',36),(202,'2018-03-21 13:43:14',7),(203,'2018-03-21 13:57:34',11),(204,'2018-03-21 14:15:20',7),(205,'2018-03-21 14:25:26',11),(206,'2018-03-21 15:14:16',7),(207,'2018-03-21 15:16:09',40),(208,'2018-03-21 15:20:19',7),(209,'2018-03-21 15:22:17',40),(210,'2018-03-21 15:37:22',7),(211,'2018-03-21 15:38:28',16),(212,'2018-03-21 15:42:24',7),(213,'2018-03-21 15:43:54',7),(214,'2018-03-21 15:45:29',40),(215,'2018-03-21 15:56:03',7),(216,'2018-03-21 15:58:51',64),(217,'2018-03-21 16:12:58',7),(218,'2018-03-21 16:14:31',70),(219,'2018-03-21 16:24:01',7),(220,'2018-03-21 16:25:46',14),(221,'2018-03-21 16:30:24',7),(222,'2018-03-21 16:34:24',70),(223,'2018-03-21 16:36:50',7),(224,'2018-03-21 16:39:11',58),(225,'2018-03-23 14:21:40',7),(226,'2018-04-06 14:03:40',11);
/*!40000 ALTER TABLE `tr_supplierpayablehead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplierpaymentdetail`
--

DROP TABLE IF EXISTS `tr_supplierpaymentdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplierpaymentdetail` (
  `supplierPaymentDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `supplierPaymentNum` varchar(50) NOT NULL,
  `refNum` varchar(50) NOT NULL,
  `whtAmount` decimal(18,2) DEFAULT NULL,
  `transactionAmountBeforeTax` decimal(18,2) NOT NULL,
  `tax` decimal(18,2) DEFAULT NULL,
  `paymentAmount` decimal(18,2) NOT NULL,
  PRIMARY KEY (`supplierPaymentDetailID`),
  KEY `fk_supplierpaymentdetail_paymentnum_idx` (`supplierPaymentNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplierpaymentdetail`
--

LOCK TABLES `tr_supplierpaymentdetail` WRITE;
/*!40000 ALTER TABLE `tr_supplierpaymentdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_supplierpaymentdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_supplierpaymenthead`
--

DROP TABLE IF EXISTS `tr_supplierpaymenthead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_supplierpaymenthead` (
  `supplierPaymentNum` varchar(50) NOT NULL COMMENT 'Supplier Payment Number',
  `voucherNum` varchar(50) DEFAULT NULL,
  `supplierPaymentDate` datetime NOT NULL COMMENT 'Payment Transaction Date',
  `supplierID` int(11) NOT NULL COMMENT 'Supplier ID',
  `currencyID` varchar(5) NOT NULL,
  `rate` decimal(18,2) NOT NULL,
  `coaNo` varchar(20) DEFAULT NULL,
  `adminFeePaymentCoa` varchar(20) DEFAULT NULL,
  `adminFeeRate` decimal(18,2) DEFAULT NULL,
  `adminFeeAmount` decimal(18,2) DEFAULT NULL,
  `additionalInfo` varchar(200) DEFAULT NULL COMMENT 'Additional Info',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) DEFAULT NULL COMMENT 'Edited By',
  `editedDate` datetime DEFAULT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`supplierPaymentNum`),
  KEY `fk_supplierpaymenthead_supplierid_idx` (`supplierID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_supplierpaymenthead`
--

LOCK TABLES `tr_supplierpaymenthead` WRITE;
/*!40000 ALTER TABLE `tr_supplierpaymenthead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_supplierpaymenthead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_taxindetail`
--

DROP TABLE IF EXISTS `tr_taxindetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_taxindetail` (
  `taxInDetailID` bigint(20) NOT NULL COMMENT 'Tax In Detail ID',
  `taxInNum` varchar(50) NOT NULL COMMENT 'Tax In Number',
  `taxInvoice` varchar(20) NOT NULL COMMENT 'Tax Invoice',
  `supplierReceiptNum` varchar(50) NOT NULL COMMENT 'Supplier Receipt Number',
  `supplierInvoiceDate` datetime NOT NULL COMMENT 'Supplier Invoice Date',
  `supplierInvoiceNum` varchar(50) NOT NULL COMMENT 'Supplier Invoice Number',
  `taxAmount` decimal(18,2) NOT NULL COMMENT 'Tax Amount',
  `flagUsed` bit(1) NOT NULL COMMENT 'Flag Used',
  `flagNotUsed` bit(1) NOT NULL COMMENT 'Flag Not Used',
  PRIMARY KEY (`taxInDetailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_taxindetail`
--

LOCK TABLES `tr_taxindetail` WRITE;
/*!40000 ALTER TABLE `tr_taxindetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_taxindetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_taxinhead`
--

DROP TABLE IF EXISTS `tr_taxinhead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_taxinhead` (
  `taxInNum` varchar(50) NOT NULL COMMENT 'Tax In Number',
  `taxInDate` datetime NOT NULL COMMENT 'Tax In Date',
  `taxTotal` decimal(18,2) NOT NULL COMMENT 'Tax Total',
  `additionalInfo` varchar(200) NOT NULL COMMENT 'Additional Info',
  `createdBy` varchar(50) NOT NULL COMMENT 'Created By',
  `createdDate` datetime NOT NULL COMMENT 'Created Date',
  `editedBy` varchar(50) NOT NULL COMMENT 'Edited By',
  `editedDate` datetime NOT NULL COMMENT 'Edited Date',
  PRIMARY KEY (`taxInNum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_taxinhead`
--

LOCK TABLES `tr_taxinhead` WRITE;
/*!40000 ALTER TABLE `tr_taxinhead` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_taxinhead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'ptkd_qerp'
--

--
-- Dumping routines for database 'ptkd_qerp'
--
/*!50003 DROP PROCEDURE IF EXISTS `generate_journal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_journal`(IN `mode` VARCHAR(50))
BEGIN
	DECLARE done INT DEFAULT FALSE;

	DECLARE trNum VARCHAR(50);
	DECLARE curGr CURSOR FOR SELECT head.goodsReceiptNum FROM tr_goodsreceipthead AS head
		LEFT JOIN tr_goodsreceiptdetail AS detail ON detail.goodsReceiptNum = head.goodsReceiptNum
		WHERE detail.goodsReceiptNum IS NOT NULL;
    DECLARE curCashInOut CURSOR FOR SELECT cashInOutNum FROM tr_cashinouthead;
    DECLARE curAdvancePayment CURSOR FOR SELECT supplierAdvancePaymentNum FROM tr_supplieradvancepayment;
    DECLARE curSupplierPayment CURSOR FOR SELECT supplierPaymentNum FROM tr_supplierpaymenthead AS paymentHead
		LEFT JOIN ms_supplier AS supplier ON supplier.supplierID = paymentHead.supplierID
		WHERE supplier.isForwarder = 0;
	DECLARE curCustAdvPayment CURSOR FOR SELECT custAdvancePaymentNum FROM tr_customeradvancepayment;
    DECLARE curCustPayment CURSOR FOR SELECT customerPaymentNum FROM tr_customerpayment;
    DECLARE curGD CURSOR FOR SELECT goodsDeliveryNum FROM tr_goodsdeliveryhead;
    DECLARE curGlToGL CURSOR FOR SELECT gltoglNum FROM tr_gltoglhead;
    DECLARE curCashBankTransfer CURSOR FOR SELECT transferID FROM tr_cashbanktransfer;
    DECLARE curImportDuty CURSOR FOR SELECT goodsReceiptNum FROM tr_goodsreceipthead AS receiptHead
		LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
		WHERE poHead.isImport = 1;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	IF mode = 'goods receipt' THEN
		OPEN curGr;
        
        readLoop: LOOP
			FETCH curGr INTO trNum;
			IF done THEN
				LEAVE readLoop;
			END IF;
				
			CALL insert_journal(trNum, mode);
        END LOOP;
        
        CLOSE curGr;
    ELSEIF mode = 'cash in out' THEN
		OPEN curCashInOut;
        
        readLoop: LOOP
			FETCH curCashInOut INTO trNum;
            IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
		END LOOP;
        
        CLOSE curCashInOut;
	ELSEIF mode = 'supplier advanced payment' THEN
		OPEN curAdvancePayment;
        
        readLoop: LOOP
			FETCH curAdvancePayment INTO trNum;
            IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
        END LOOP;
        
        CLOSE curAdvancePayment;
	ELSEIF mode = 'supplier payment' THEN
		OPEN curSupplierPayment;
        
        readLoop: LOOP
			FETCH curSupplierPayment INTO trNum;
            IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
        END LOOP;
        
        CLOSE curSupplierPayment;
	ELSEIF mode = 'customer advanced payment' THEN
		OPEN curCustAdvPayment;
        
        readLoop: LOOP
			FETCH curCustAdvPayment INTO trNum;
			IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
		END LOOP;
            
        CLOSE curCustAdvPayment;
	ELSEIF mode = 'customer payment' THEN
		OPEN curCustPayment;
        
        readLoop: LOOP
			FETCH curCustPayment INTO trNum;
            IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
		END LOOP;
		
        CLOSE curCustPayment;
	ELSEIF mode = 'goods delivery' THEN
		OPEN curGD;
        
        readLoop: LOOP
			FETCH curGD INTO trNum;
            IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
        END LOOP;
        
        CLOSE curGD;
	ELSEIF mode = 'gl to gl' THEN
		OPEN curGlToGl;
        
        readLoop: LOOP
			FETCH curGlToGl INTO trNum;
            IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
        END LOOP;
        
        CLOSE curGlToGl;
	ELSEIF mode = 'cash/bank transfer' THEN
		OPEN curCashBankTransfer;
			
		readLoop: LOOP
			FETCH curCashBankTransfer INTO trNum;
			IF done THEN
				LEAVE readLoop;
			END IF;
			
			CALL insert_journal(trNum, mode);
		END LOOP;
            
        CLOSE curCashBankTransfer;
	ELSEIF mode = 'import duty' THEN
		OPEN curImportDuty;
        
        readLoop: LOOP
			FETCH curImportDuty INTO trNum;
            IF done THEN
				LEAVE readLoop;
			END IF;
            
            CALL insert_journal(trNum, mode);
		END LOOP;
        
        CLOSE curImportDuty;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insert_journal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_journal`(IN `refNum` VARCHAR(50), `mode` VARCHAR(50))
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE curHeadID,curHeadID2 INT;
    DECLARE countLoop INT;
    DECLARE coaCategory,coaCategory2,coaCategory3 VARCHAR(20);
    DECLARE spRefNum VARCHAR(50);
    DECLARE transType VARCHAR(50);
    DECLARE transTypeGlobal, salesOrderNum VARCHAR(50);
    DECLARE amount,amount2,originalAmount,originalAmount2,profitLossAmount, totalDebit, totalCredit, price, qty, hpp, tax DECIMAL(18,2);
    DECLARE amountGlobal,rateGlobal,rateGlobal2,advancedAmountGlobal,advancedRateGlobal DECIMAL(18,2);
    DECLARE spQty,totalAmount,totalTax,importDuty,PPNImport,PPHImport DECIMAL(18,2);
    DECLARE importDutyGlobal,PPNGlobal,PPNImportGlobal,PPHImportGlobal,hutangDagangGlobal DECIMAL(18,2);
    DECLARE currency,spCurrency VARCHAR(5);
    DECLARE previousRate,rate,spRate DECIMAL(18,2);
    DECLARE spDiscount,totalDiscount DECIMAL(18,2);
    DECLARE flag BIT(1);
    DECLARE isImport BIT(1);
    DECLARE isImportGlobal BIT(1);
    
    DECLARE curTransType CURSOR FOR
		select a.transType from tr_goodsreceipthead a where a.goodsReceiptNum=refNum;
        
    DECLARE curSR CURSOR FOR 
		select c.coaNo,sum(grDetail.qty*e.HPP*((100 + e.VAT)/100)),sum(grDetail.qty*e.HPP*e.VAT/100)
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_salesreturndetail e on a.refNum=e.salesReturnNum
        join tr_salesreturnhead d on a.refNum=d.salesReturnNum
        join ms_product b on b.productID=e.productID
        join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID
        group by b.productCategoryID;
        
	DECLARE cur CURSOR FOR 
		select d.currencyID,d.rate,IF(d.isImport = 1,a.pibRate,d.rate),c.coaNo,grDetail.qty*e.price*((100 - e.discount)/100),d.isImport
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
        join tr_purchaseorderhead d on a.refNum=d.purchaseOrderNum
        join ms_product b on b.productID=e.productID
        join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID
        group by b.productCategoryID;
	
    DECLARE curCheckAPBalance CURSOR FOR
		SELECT abd.amount,ap.rate,ap.amount
		FROM tr_goodsreceipthead grh join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		left join tr_supplieradvancebalancehead abh on po.supplierID=abh.supplierID
		join tr_supplieradvancebalancedetail abd on abh.balanceHeadID=abd.balanceHeadID
		left join tr_supplieradvancepayment ap on grh.refNum=ap.refNum
		WHERE grh.goodsReceiptNum=refNum AND abd.refNum=ap.refNum;
        
	DECLARE curHD cursor for
		select b.currencyID,IF(b.isImport = 1,a.pibRate,b.rate),sum(grDetail.qty*e.price*((100 - e.discount)/100))
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
		left join tr_purchaseorderhead b on e.purchaseOrderNum=b.purchaseOrderNum
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID;
        
	DECLARE curPPN cursor for
		select sum(grDetail.qty*e.price*((100 - e.discount)/100)*b.taxRate/100)
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
		left join tr_purchaseorderhead b on e.purchaseOrderNum=b.purchaseOrderNum
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID;
        
	DECLARE curPPNImport cursor for
		select b.currencyID,a.pibRate,grc.importDutyAmount,grc.PPNImportAmount,grc.PPHImportAmount
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
		left join tr_purchaseorderhead b on e.purchaseOrderNum=b.purchaseOrderNum
        left join tr_goodsreceiptcost grc on a.goodsReceiptNum=grc.goodsReceiptNum
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID;
		
	DECLARE curLR cursor for
		select currency,rate,SUM(originalDrAmount),SUM(originalCrAmount),SUM(drAmount),SUM(crAmount) 
		from tr_journaldetail
		where journalHeadID=curHeadID;
        
	DECLARE curWHT cursor for
		select b.refNum 
        from tr_supplierpaymenthead a join tr_supplierpaymentdetail b on a.supplierPaymentNum=b.supplierPaymentNum
        where a.supplierPaymentNum=refNum;
        
	DECLARE curIUReason cursor for
		select c.coaNo,sum(b.qty),stock.HPP
		from tr_internalusagehead a
        join tr_internalusagedetail b
		join ms_reason c on b.purposeAccount=c.mapReasonID
        join tr_stockhpp stock on a.warehouseID=stock.warehouseID and b.productID=stock.productID
		where a.internalUsageNum=refNum
		group by b.purposeAccount;

	DECLARE curIUCategory cursor for
		select c.coaNo,sum(a.HPP)
		from tr_internalusagedetail a
		join ms_product b on a.productID=b.productID
		join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where internalUsageNum=refNum
		group by b.productCategoryID;
        
	DECLARE curSADebit cursor for
		select c.coaNo,sum(a.HPP)
		from tr_stockopnamedetail a
		join ms_product b on a.productID=b.productID
		join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.stockOpnameNum=refNum and a.qtyInStock>a.qtyReal
		group by b.productCategoryID;
        
	DECLARE curSACredit cursor for
		select c.coaNo,sum(a.HPP)
		from tr_stockopnamedetail a
		join ms_product b on a.productID=b.productID
		join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.stockOpnameNum=refNum and a.qtyInStock<a.qtyReal
		group by b.productCategoryID;
        
	DECLARE curGDTransType cursor for
		select a.transType
        from tr_goodsdeliveryhead a
        where a.goodsDeliveryNum=refNum;
        
	DECLARE curGDCredit cursor for
		select b.salesOrderNum, f.coaNo, a.price, d.qty, hpp.HPP, a.tax, a.discount from tr_salesorderdetail a
		left join tr_salesorderhead b on a.salesOrderNum=b.salesOrderNum
		join tr_goodsdeliveryhead c on b.salesOrderNum=c.refNum
        join tr_goodsdeliverydetail d on c.goodsDeliveryNum=d.goodsDeliveryNum
        join tr_stockhpp hpp on hpp.productID = d.productID AND hpp.batchNumber = d.batchNumber
        join ms_product e on d.productID=e.productID
        join ms_productcategory f on e.productCategoryID=f.productCategoryID
		where c.goodsDeliveryNum=refNum and a.productID=d.productID
        group by e.productCategoryID;
        
	DECLARE curGDCreditReturn cursor for
		select f.coaNo,a.HPP*d.qty*(100+a.VAT)/100
        from tr_purchasereturndetail a
		join tr_purchasereturnhead b on a.purchaseReturnNum=b.purchaseReturnNum
		join tr_goodsdeliveryhead c on b.purchaseReturnNum=c.refNum
        join tr_goodsdeliverydetail d on c.goodsDeliveryNum=d.goodsDeliveryNum
        join ms_product e on d.productID=e.productID
        join ms_productcategory f on e.productCategoryID=f.productCategoryID
		where c.goodsDeliveryNum=refNum and a.productID=d.productID
        group by e.productCategoryID;
        
	DECLARE curGLDebit cursor for
		select coaNo,currencyID,rate,sum(debitAmount)
        from tr_gltogldetail
        where gltoglNum=refNum and debitAmount is not null
        group by coaNo;
        
	DECLARE curGLCredit cursor for
		select coaNo,currencyID,rate,sum(creditAmount)
        from tr_gltogldetail
        where gltoglNum=refNum and creditAmount is not null
        group by coaNo;
        
	DECLARE curBbCredit cursor for
		select a.currencyID, a.rate, d.coaNo, sum(b.subtotal) as subtotal
		from tr_purchaseordernoninventoryhead a
		join tr_purchaseordernoninventorydetail b on a.purchaseOrderNonInventoryNum = b.purchaseOrderNonInventoryNum
		join ms_product c on b.productID = c.productID
		join ms_productcategory d on c.productCategoryID = d.productCategoryID
		where a.purchaseOrderNonInventoryNum =refNum
		group by c.productCategoryID;
        
	DECLARE curPPNCredit cursor for
		select a.currencyID, a.rate, sum((IF(a.hasVAT = 1,0.1,0)) * b.subtotal) as PPN from tr_purchaseOrderNonInventoryHead a
		join tr_purchaseOrderNonInventoryDetail b on a.purchaseOrderNoninventoryNum = b.purchaseOrderNonInventoryNum
        where a.purchaseOrderNonInventoryNum = refNum
		group by a.purchaseOrderNoninventoryNum;
        
	DECLARE curWHTCredit cursor for
		select a.currencyID, a.rate, c.coaNo, sum((a.whtRate / 100) * b.subtotal) as WHT from tr_purchaseOrderNonInventoryHead a
		join tr_purchaseOrderNonInventoryDetail b on a.purchaseOrderNoninventoryNum = b.purchaseOrderNonInventoryNum
        join ms_tax c on c.taxID=a.whtID
        where a.purchaseOrderNonInventoryNum = refNum
		group by a.purchaseOrderNonInventoryNum;
	
    DECLARE curAPCustomer cursor for
		select b.refNum,b.amount
        from tr_customerpayment a join tr_goodsreceipthead gd on a.refNum=gd.refNum
        join tr_customeradvancebalancedetail b on gd.refNum=b.refNum
        where a.customerPaymentNum=refNum;
        
         
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  

	IF mode = 'goods receipt' OR mode = '1' THEN
		OPEN curTransType;
			loopTransType: LOOP
				FETCH curTransType INTO transType;
				IF done = 1 THEN
					LEAVE loopTransType;
				END IF;
                
				IF transType = 'Purchase Order' THEN
					SELECT @purchaseOrderNumber := poHead.purchaseOrderNum, @receiptDate := receiptHead.goodsReceiptDate,
					@inventoryPrice := CAST(SUM(receiptDetail.qty * poDetail.price) AS DECIMAL(18, 2)),
					@advancePaymentAmount := CAST(IFNULL(advancePayment.amount, 0) AS DECIMAL(18, 2)),
					@outstandingAmount := CAST(poHead.grandTotal - IFNULL(advancePayment.amount, 0) AS DECIMAL(18, 2)),
					@currency := poHead.currencyID, @pibRate := IF(poHead.isImport = 1, IFNULL(receiptHead.pibRate, 0), 1), @advancePaymentRate := IFNULL(advancePayment.rate, 0),
                    @coaCategory := category.coaNo, @isImport := poHead.isImport, @additionalInfo := receiptHead.additionalInfo
					FROM tr_goodsreceiptdetail AS receiptDetail
					LEFT JOIN tr_goodsreceipthead AS receiptHead ON receiptHead.goodsReceiptNum = receiptDetail.goodsReceiptNum
					LEFT JOIN tr_purchaseorderhead AS poHead ON poHead.purchaseOrderNum = receiptHead.refNum
					LEFT JOIN tr_purchaseorderdetail AS poDetail  ON poDetail.purchaseOrderNum = poHead.purchaseOrderNum AND poDetail.productID = receiptDetail.productID
					LEFT JOIN tr_supplieradvancepayment AS advancePayment ON advancePayment.refNum = poHead.purchaseOrderNum
					LEFT JOIN ms_product AS product ON product.productID = receiptDetail.productID
					LEFT JOIN ms_productCategory AS category ON category.productCategoryID = product.productCategoryID
                    WHERE receiptDetail.goodsReceiptNum = refNum;
					
					INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate, notes)
					VALUES (@receiptDate, 'Goods Receipt', refNum, 'admin', NOW(), 'admin', NOW(), @additionalInfo);
					
					SELECT LAST_INSERT_ID() INTO curHeadID;
					SET totalAmount = 0;
					SET importDutyGlobal = 0;
					SET PPNGlobal = 0;
                    SET totalDebit = 0;
                    SET totalCredit = 0;
					
                    
                    -- Inventory Barang
                    INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID, @coaCategory, @currency, @pibRate, @inventoryPrice, 0, @inventoryPrice * @pibRate, 0);
                    SET totalDebit = totalDebit + (@inventoryPrice * @pibRate);
                    
                    -- insert PPN for non import
                    SET PPNGlobal = 0;
					if @isImport = 0 THEN 	
						OPEN curPPN;
							loopDebit: LOOP
								FETCH curPPN INTO originalAmount;
								IF done = 1 THEN
									LEAVE loopDebit;
								END IF;
								
								if originalAmount>0 THEN					
									SET PPNGlobal = originalAmount;
                                    SET totalDebit = totalDebit + originalAmount;
                                    
                                    SELECT @piutangPPN := coaNo FROM ms_coasetting WHERE `key` = 'PiutangPPN';
                                    
									INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
									VALUES (curHeadID, @piutangPPN, 'IDR', 1, originalAmount, 0, originalAmount, 0);
								END IF;
								
							END LOOP;
						CLOSE curPPN;
						SET done = 0;
					END IF;
                    
                    SELECT @uangMukaSupplier := coaNo FROM ms_coasetting WHERE `key` = 'UangMukaSupplier';
                    -- Advance Payment
                    IF @advancePaymentAmount > 0 THEN
						INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID, @uangMukaSupplier, @currency, @advancePaymentRate, 0, @advancePaymentAmount, 0, @advancePaymentAmount * @advancePaymentRate);
						SET totalCredit = totalCredit + (@advancePaymentAmount * @advancePaymentRate);
                    END IF;
                    
                    SELECT @hutangDagang := coaNo FROM ms_coasetting WHERE `key` = 'HutangDagang';
                    -- Hutang Dagang
                    INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID, @hutangDagang, @currency, @pibRate, 0, @outstandingAmount, 0, @outstandingAmount * @pibRate);
                    SET totalCredit = totalCredit + (@outstandingAmount * @pibRate);
                        
					if @isImport = 1 THEN 	
						SELECT @selisihKurs := coaNo FROM ms_coasetting WHERE `key` = 'SelisihKursPenjualanPembelian';
						IF (totalDebit < totalCredit) THEN
							INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES(curHeadID, @selisihKurs,'IDR',1, totalCredit - totalDebit, 0 , totalCredit - totalDebit, 0);
						ELSEIF (totalCredit < totalDebit) THEN
							INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES(curHeadID, @selisihKurs,'IDR',1, 0, totalDebit - totalCredit, 0, totalDebit - totalCredit);
						END IF;
                    END IF;
				ELSEIF transType = 'Sales Return' THEN
					SELECT @returnDate := salesReturnDate FROM tr_salesreturnhead WHERE salesReturnNum = refNum;
                
					INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
					VALUES (@returnDate,'Goods Receipt (Return)',refNum,'admin',NOW(),'admin',NOW());
					
					SELECT LAST_INSERT_ID() INTO curHeadID;
                    SET totalAmount = 0;
                    
                    OPEN curSR;
						loopDebit: LOOP
							FETCH curSR INTO coaCategory,amount,PPNGlobal;
							IF done = 1 THEN
								LEAVE loopDebit;
							END IF;
							
							SET totalAmount = totalAmount + amount + PPNGlobal;
							INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES (curHeadID,coaCategory,'IDR',1,amount,0,amount,0);
                            
                            IF PPNGlobal > 0 THEN
								SELECT @piutangPPN := coaNo FROM ms_coasetting WHERE `key` = 'PiutangPPN';
								INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
								VALUES (curHeadID, @piutangPPN,'IDR',1,PPNGlobal,0,PPNGlobal,0);
                            END IF;
							
						END LOOP;
					CLOSE curSR;
					SET done = 0;
                    
                    SELECT @putangDagangCustomer := coaNo FROM ms_coasetting WHERE `key` = 'PiutangDagangCustomer';
                    INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID, @putangDagangCustomer,'IDR',1,0,totalAmount,0,totalAmount);
				END IF;
			END LOOP;
		CLOSE curTransType;
		SET done = 0;
        
	ELSEIF mode = 'cash in out' OR mode = '2' OR mode = '3' THEN
		-- Make sure no duplicate
		DELETE FROM tr_journaldetail WHERE journalHeadID = (SELECT journalHeadID FROM tr_journalhead WHERE tr_journalhead.refNum = refNum);
        DELETE FROM tr_journalhead WHERE tr_journalhead.refNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, notes, createdBy, createdDate, editedBy, editedDate)
		SELECT cashIO.cashInOutDate, (SELECT IF(cashIO.flagCashInOut = 'in', 'Cash In', 'Cash Out')), 
			cashIO.cashInOutNum, cashIO.additionalInfo, cashIO.createdBy , cashIO.createdDate, cashIO.editedBy, cashIO.editedDate
		FROM tr_cashinouthead AS cashIO WHERE cashIO.cashInOutNum = refNum;
        
		
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        IF (SELECT flagCashInOut FROM tr_cashinouthead WHERE tr_cashinouthead.cashInOutNum = refNum) = 'in' THEN
			-- Cash In
			-- Insert the Total
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIO.cashAccount, cashIO.currencyID, cashIO.rate, 
			SUM(cashIODetail.amount), 0, SUM(cashIODetail.amount) * cashIO.rate, 0
			FROM tr_cashinoutdetail AS cashIODetail, tr_cashinouthead AS cashIO
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
				
			-- Insert the Detail
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIODetail.destinationAccount, cashIO.currencyID, cashIO.rate, 
			0, cashIODetail.amount, 0, cashIODetail.amount * cashIO.rate
			FROM  tr_cashinouthead AS cashIO, tr_cashinoutdetail AS cashIODetail
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
		ELSE
			-- Cash Out
			-- Insert the Total
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIO.cashAccount, cashIO.currencyID, cashIO.rate, 
			0, SUM(cashIODetail.amount), 0, SUM(cashIODetail.amount) * cashIO.rate
			FROM tr_cashinoutdetail AS cashIODetail, tr_cashinouthead AS cashIO
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
				
			-- Insert the Detail
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIODetail.destinationAccount, cashIO.currencyID, cashIO.rate, 
			cashIODetail.amount, 0, cashIODetail.amount * cashIO.rate, 0
			FROM  tr_cashinouthead AS cashIO, tr_cashinoutdetail AS cashIODetail
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
		END IF;
		
    ELSEIF mode = 'supplier advanced payment' OR mode = '4' THEN 
		SELECT @paymentDate := supplierAdvancePaymentDate FROM tr_supplieradvancepayment WHERE supplierAdvancePaymentNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (@paymentDate,'Supplier Advanced Payment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.treasuryCOA,a.currencyID,a.rate,a.amount,0,a.amount*a.rate,0
		FROM tr_supplieradvancepayment a
		WHERE a.supplierAdvancePaymentNum=refNum;
            
		INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.paymentCOA,a.currencyID,a.rate,0,a.amount,0,a.amount*a.rate
		FROM tr_supplieradvancepayment a
		WHERE a.supplierAdvancePaymentNum=refNum;
    
    -- supplier payment
    ELSEIF mode = 'supplier payment' OR mode = '5' THEN
		
        SELECT @adminFeeCurrency := adminFeeCoa.currencyID, @adminFeeRate := paymentHead.adminFeeRate, @adminFeeAmount := paymentHead.adminFeeAmount,
        @adminFeePaymentCoa := adminFeeCoa.coaNo, @paymentCoa := paymentHead.coaNo,
        @paymentRate := paymentHead.rate, @paymentCurrencyID := paymentHead.currencyID, @paymentAmount := SUM(paymentDetail.paymentAmount),
        @pibRate := IFNULL(receipthead.pibRate, 1), @additionalInfo := paymentHead.additionalInfo,
        @paymentDate := supplierPaymentDate
        FROM tr_supplierpaymenthead AS paymentHead
        LEFT JOIN tr_supplierpaymentdetail AS paymentDetail ON paymentDetail.supplierPaymentNum = paymentHead.supplierPaymentNum
        LEFT JOIN ms_coa AS adminFeeCoa ON adminFeeCoa.coaNo = paymentHead.adminFeePaymentCoa
        LEFT JOIN tr_goodsreceipthead AS receiptHead ON receiptHead.goodsreceiptnum = paymentDetail.refNum
        WHERE paymentHead.supplierPaymentNum = refNum;
        
        SET totalDebit = 0;
        SET totalCredit = 0;
        
        INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate, notes)
        VALUES (@paymentDate,'Supplier Payment',refNum,'admin',NOW(),'admin',NOW(), @additionalInfo);
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        SELECT @hutangDagang := coaNo FROM ms_coasetting WHERE `key` = 'HutangDagang';
        -- Hutang Dagang supplier
        INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
		VALUES (curHeadID, @hutangDagang, @paymentCurrencyID, @paymentRate, @paymentAmount, 0,
		CAST(@paymentAmount * @pibRate AS DECIMAL(18, 2)), 0);
        SET totalDebit = totalDebit + (@paymentAmount * @pibRate);
        
        SELECT @byTxBank := coaNo FROM ms_coasetting WHERE `key` = 'ByTxBank';
        -- By transfer bank
        IF @adminFeeAmount > 0 THEN
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			VALUES (curHeadID, @byTxBank, @adminFeeCurrency, @adminFeeRate, @adminFeeAmount, 0, 
			CAST(@adminFeeAmount * @adminFeeRate AS DECIMAL(18, 2)), 0);
            SET totalDebit = totalDebit + (@adminFeeAmount * @adminFeeRate);
        END IF;
        
        -- from purchase order non inventory
        OPEN curWHT;
			loopWHT: LOOP
				FETCH curWHT INTO spRefNum;
				IF done = 1 THEN
					LEAVE loopWHT;
				END IF;
				
				if SUBSTRING(spRefNum,5,4)='PONI' THEN
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					SELECT curHeadID,(SELECT t.coaNo from ms_tax t where t.taxID=po.whtID),a.currencyID,a.rate,0,b.whtAmount,0,b.whtAmount*a.rate
					FROM tr_supplierpaymenthead a join tr_supplierpaymentdetail b on a.supplierPaymentNum=b.supplierPaymentNum
					left join tr_purchaseordernoninventoryhead po on b.refNum=po.purchaseOrderNonInventoryNum
					WHERE a.supplierPaymentNum=refNum;
				END IF;
			END LOOP;
		CLOSE curWHT;
		SET done = 0;
        
        SELECT @totalPayment := CAST((@paymentAmount * @paymentRate) + (@adminFeeAmount * @adminFeeRate) AS DECIMAL(18, 2));
        
        -- Bank / Cash
		INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
		VALUES (curHeadID, @paymentCoa, @paymentCurrencyID, @paymentRate, 0, @totalPayment, 0, @totalPayment);
        SET totalCredit = totalCredit + @totalPayment;
        
        SELECT @gapDebit := CAST(IF (totalDebit < totalCredit, totalCredit - totalDebit, 0) AS DECIMAL(18, 2)),
        @gapCredit := CAST(IF (totalCredit < totalDebit, totalDebit - totalCredit, 0) AS DECIMAL(18, 2));
        
        IF @gapDebit > 0 OR @gapCredit > 0 THEN
			SELECT @selisihKursKasBank := coaNo FROM ms_coasetting WHERE `key` = 'SelisihKursKasBank';
			-- Selisih Kurs
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			VALUES (curHeadID, @selisihKursKasBank, 'IDR', 1, @gapDebit, @gapCredit, @gapDebit, @gapCredit);
        END IF;
        
	ELSEIF mode = 'customer advanced payment' OR mode = '6' THEN
		SELECT @paymentDate := custAdvancePaymentDate FROM tr_customeradvancepayment WHERE custAdvancePaymentNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (@paymentDate,'Customer Advanced Payment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.paymentCOA,a.currencyID,a.rate,a.amount,0,a.amount*a.rate,0
		FROM tr_customeradvancepayment a
		WHERE a.custAdvancePaymentNum=refNum;
            
		INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.treasuryCOA,a.currencyID,a.rate,0,a.amount,0,a.amount*a.rate
		FROM tr_customeradvancepayment a
		WHERE a.custAdvancePaymentNum=refNum;
        
	ELSEIF mode = 'customer payment' OR mode = '7' THEN 
		SELECT @transactionDate := payment.paymentTransactionDate, 
        @paymentCoa := payment.coaNo, @paymentCurrency := paymentCoa.currencyID, @paymentRate := paymentCurrency.rate, @paymentAmount := payment.paymentAmount,
        @adminFeeCoa := adminCoa.coaNo, @adminFeeCurrency := adminCoa.currencyID, @adminFeeRate := adminCurrency.rate, @adminFeeAmount := payment.adminFeeAmount,
        @customerID := payment.customerID, @additionalInfo := payment.additionalInfo
        FROM tr_customerpayment AS payment
        LEFT JOIN ms_coa AS paymentCoa ON paymentCoa.coaNo = payment.coaNo
        LEFT JOIN ms_currency AS paymentCurrency ON paymentCurrency.currencyID = paymentCoa.currencyID
        LEFT JOIN ms_coa AS adminCoa ON adminCoa.coaNo = payment.adminFeePaymentCoa
        LEFT JOIN ms_currency AS adminCurrency ON adminCurrency.currencyID = adminCoa.currencyID
        WHERE payment.customerPaymentNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (@transactionDate, 'Customer Payment', refNum, 'admin', NOW(), 'admin', NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        -- Bank / Kas Masuk
        INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
        VALUES (curHeadID, @paymentCoa, @paymentCurrency, @paymentRate, @paymentAmount, 0, @paymentAmount, 0);
        
        -- Not sure what is this?
        OPEN curAPCustomer;
			loopAPC: LOOP
				FETCH curAPCustomer INTO spRefNum,amount;
				IF done = 1 THEN
					LEAVE loopAPC;
				END IF;
				
				if spRefNum is not null THEN
					SELECT @umpCustomer := coaNo FROM ms_coasetting WHERE `key` = 'UMPCustomer';
					-- uang muka ????
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID, @umpCustomer,'IDR',1,amount,0,amount,0);
				END IF;
			END LOOP;
		CLOSE curAPCustomer;
		SET done = 0;
        
        SELECT @piutangDagangCustomer := coaNo FROM ms_coasetting WHERE `key` = 'PiutangDagangCustomer';
        -- Piutang dagang customer
        INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
        VALUES (curHeadID, @piutangDagangCustomer, @paymentCurrency, @paymentRate, 0, @paymentAmount, 0, @paymentAmount);
        
		IF @adminFeeAmount > 0 THEN
			SELECT @byTxBank := coaNo FROM ms_coasetting WHERE `key` = 'ByTxBank';
			-- By admin
            INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
            VALUES (curHeadID, @byTxBank, @adminFeeCurrency, @adminFeeRate, @adminFeeAmount, 0, @adminFeeAmount, 0);
            
            -- Beban ke
            INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
            VALUES (curHeadID, @adminFeeCoa, @adminFeeCurrency, @adminFeeRate, 0, @adminFeeAmount, 0, @adminFeeAmount);
        END iF;
	
    ELSEIF mode = 'stock adjusment' OR mode = '8' THEN
		SELECT @journalDate := stockOpnameDate FROM tr_stockopnamehead WHERE stockOpnameNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (@journalDate,'Stock Adjustment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        OPEN curSADebit;
			SET totalAmount = 0;
            SET countLoop = 0;
			loopSA: LOOP
				FETCH curSADebit INTO coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopSA;
				END IF;
				
                SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,amount,0,amount,0);
                
				SET countLoop = countLoop + 1;
			END LOOP;
            IF countLoop > 0 THEN
				SELECT @rugiStockOpname := coaNo FROM ms_coasetting WHERE `key` = 'RugiStockOpname';
                -- Rugi Stock
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID, @rugiStockOpname,'IDR',1,0,totalAmount,0,totalAmount);
			END IF;
		CLOSE curSADebit;
        SET done = 0;
        
        OPEN curSACredit;
			SET totalAmount = 0;
            SET countLoop = 0;
			loopSA: LOOP
				FETCH curSACredit INTO coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopSA;
				END IF;
				
                SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,0,amount,0,amount);
                
				SET countLoop = countLoop + 1;
			END LOOP;
            IF countLoop > 0 THEN
				SELECT @incomeStockOpname := coaNo FROM ms_coasetting WHERE `key` = 'IncomeStockOpname';
                -- pendapatan stock opname
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID, @incomeStockOpname,'IDR',1,totalAmount,0,totalAmount,0);
			END IF;
		CLOSE curSACredit;
        SET done = 0;
        
    ELSEIF mode = 'internal usage' OR mode = '9' THEN 
		SELECT @journalDate := internalUsageDate FROM tr_internalusagehead WHERE internalUsageNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (@journalDate,'Internal Usage',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        OPEN curIUReason;
			loopIU: LOOP
				FETCH curIUReason INTO coaCategory,spQty,amount;
				IF done = 1 THEN
					LEAVE loopIU;
				END IF;

				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,spQty*amount,0,spQty*amount,0);

			END LOOP;
		CLOSE curIUReason;
        SET done = 0;
        
        OPEN curIUCategory;
			loopIU: LOOP
				FETCH curIUCategory INTO coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopIU;
				END IF;

				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,0,amount,0,amount);

			END LOOP;
		CLOSE curIUCategory;
        SET done = 0;
    ELSEIF mode = 'goods delivery' OR mode = '10' THEN 
        OPEN curGDTransType;
			loopGD: LOOP
				FETCH curGDTransType INTO transType;
				IF done = 1 THEN
					LEAVE loopGD;
				END IF;
				IF transType='Sales Order' THEN
					SELECT @additionalInfo := deliveryHead.additionalInfo , @deliveryDate := goodsDeliveryDate
                    FROM tr_goodsdeliveryhead AS deliveryHead
                    WHERE deliveryHead.goodsDeliveryNum = refNum;
                
                    -- insert sales invoice
                    INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate, notes)
					VALUES (@deliveryDate, 'Sales Invoice', refNum, 'admin', NOW(), 'admin', NOW(), @additionalInfo);
                    
                    SELECT LAST_INSERT_ID() INTO curHeadID;
                    
					OPEN curGDCredit;
					loopCredit: LOOP
						FETCH curGDCredit INTO salesOrderNum, coaCategory, price, qty, hpp, PPNGlobal, spDiscount;
						IF done = 1 THEN
							LEAVE loopCredit;
						END IF;
                        
                        -- COGS / HPP
                        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID, '5110.0001', 'IDR', 1, qty * hpp, 0, qty * hpp, 0);
                        
                        -- Inventory barang
						INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID, coaCategory, 'IDR', 1, 0, qty * hpp, 0, qty * hpp);
                        
                        -- Piutang dagang customer
                        SELECT @subTotalSO := CAST(SUM(soDetail.price * soDetail.qty) AS DECIMAL(18, 2)),
							@discountTotal := CAST(SUM(((soDetail.price * soDetail.qty) / 100) * discount) AS DECIMAL(18, 2)),
                            @taxTotal := CAST(((SUM(soDetail.price * soDetail.qty) - SUM(((soDetail.price * soDetail.qty) / 100) * discount)) / 100) * head.taxRate AS DECIMAL(18, 2)),
                            @advancePayment := IFNULL(advPayment.amount, 0)
                            FROM tr_salesorderdetail soDetail 
                            LEFT JOIN tr_salesOrderHead AS head ON head.salesOrderNum = soDetail.salesOrderNum
                            LEFT JOIN tr_customeradvancepayment AS advPayment ON advPayment.refNum = soDetail.salesOrderNum
                            WHERE soDetail.salesOrderNum = salesOrderNum;
                        SET @piutangDagangCustomer := CAST(@subTotalSO + @taxTotal - @advancePayment AS DECIMAL(18, 2));
                        
                        SELECT @CoaPiutangDagangCustomer := coaNo FROM ms_coasetting WHERE `key` = 'PiutangDagangCustomer';
                        -- Piutang dagang customer
						INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID, @CoaPiutangDagangCustomer,'IDR',1, @piutangDagangCustomer, 0 , @piutangDagangCustomer, 0);
                        
                        SELECT @umpCustomer := coaNo FROM ms_coasetting WHERE `key` = 'UMPCustomer';
                        -- Uang Muka Customer
                        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID, @umpCustomer,'IDR', 1, @advancePayment, 0, @advancePayment, 0);
                        
                        SELECT @coaPenjualanLokal := coaNo FROM ms_coasetting WHERE `key` = 'PenjualanLokal';
                        -- Penjualan Lokal
                        SET @penjualanLokal := CAST(@subTotalSO - @discountTotal AS DECIMAL(18, 2));
                        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID, @coaPenjualanLokal,'IDR',1, 0, @penjualanLokal, 0, @penjualanLokal);
                        
                        -- Discount
                        IF @discountTotal > 0 THEN
							SELECT @discountPenjualanLokal := coaNo FROM ms_coasetting WHERE `key` = 'DiscountPenjualanLokal';
							INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES (curHeadID, @discountPenjualanLokal,'IDR',1, 0, @discountTotal, 0, @discountTotal);
                        END IF;
                        
                        SELECT @ppn := coaNo FROM ms_coasetting WHERE `key` = 'PPN';
                        -- Hutang PPN
                        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID, @ppn,'IDR',1, 0, @taxTotal, 0, @taxTotal);

					END LOOP;
					
					CLOSE curGDCredit;
					SET done = 0;
                    
                ELSEIF transType='Purchase Return' THEN
					SELECT @journalDate := purchaseReturndate FROM tr_purchasereturnhead WHERE purchaseReturnNum = refNum;
                
					INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
					VALUES (@journalDate,'Goods Delivery (Return)',refNum,'admin',NOW(),'admin',NOW());
					
					SELECT LAST_INSERT_ID() INTO curHeadID;
                    
					OPEN curGDCreditReturn;
					SET totalAmount = 0;
					loopCredit: LOOP
						FETCH curGDCreditReturn INTO coaCategory,amount;
						IF done = 1 THEN
							LEAVE loopCredit;
						END IF;
						
						SET totalAmount = totalAmount + amount;
						INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID,coaCategory,'IDR',1,0,amount,0,amount);

					END LOOP;
					
                    SELECT @hutangDagang := coaNo FROM ms_coasetting WHERE `key` = 'HutangDagang';
                    -- Hutang Dagang
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID, @hutangDagang,'IDR',1,totalAmount,0,totalAmount,0);
	
					CLOSE curGDCreditReturn;
					SET done = 0;
                END IF;

			END LOOP;
		CLOSE curGDTransType;
        SET done = 0;
        
        
    
    ELSEIF mode = 'gl to gl' OR mode = '11' THEN 
		SELECT @journalDate := gltoglDate FROM tr_gltoglhead WHERE gltoglNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (@journalDate,'GL To GL',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.coaNo,a.currencyID,a.rate,sum(a.debitAmount),0,sum(a.rate*a.debitAmount),0
		from tr_gltogldetail a
		where a.gltoglNum=refNum and a.debitAmount is not null
		group by a.coaNo;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.coaNo,a.currencyID,a.rate,0,sum(a.creditAmount),0,sum(a.rate*a.creditAmount)
		from tr_gltogldetail a
		where a.gltoglNum=refNum and a.creditAmount is not null
		group by a.coaNo;
        
	ELSEIF mode = 'cash/bank transfer' OR mode = '12' THEN
		SELECT @journalDate := transferDate, @notes := additionalInfo FROM tr_cashbanktransfer WHERE transferID = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, notes, createdBy, createdDate, editedBy, editedDate)
        VALUES (@journalDate,'Cash/Bank Transfer',refNum, @notes, 'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.destinationCurrency,b.currencyID,a.destinationRate,a.sourceAmount*a.sourceRate/a.destinationRate,0,a.sourceAmount*a.sourceRate,0
		from tr_cashbanktransfer a
        join ms_coa b on a.destinationCurrency=b.coaNo
		where a.transferID=refNum;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.sourceCurrency,b.currencyID,a.sourceRate,0,a.sourceAmount*a.sourceRate,0,a.sourceAmount*a.sourceRate
		from tr_cashbanktransfer a
        join ms_coa b on a.sourceCurrency=b.coaNo
		where a.transferID=refNum;
        
	ELSEIF mode = 'purchase order non inventory' OR mode = '13' THEN
		SELECT @journalDate := purchaseOrderNonInventoryDate FROM tr_purchaseordernoninventory
        WHERE purchaseOrderNonInventoryNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (@journalDate,'Purchase Order Non Inventory',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        SET totalAmount = 0;
        
        OPEN curBbCredit;
			loopPONI: LOOP
				FETCH curBbCredit INTO currency,rate,coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopPONI;
				END IF;
                SET spCurrency = currency;
                SET spRate = rate;
				SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,currency,rate,amount,0,amount*rate,0);

			END LOOP;            
		CLOSE curBbCredit;
        SET done = 0;
        
        OPEN curPPNCredit;
			loopPONI: LOOP
				FETCH curPPNCredit INTO currency,rate,amount;
				IF done = 1 THEN
					LEAVE loopPONI;
				END IF;
				SET totalAmount = totalAmount + amount;
                
                SELECT @hutangPPNImpor := coaNo FROM ms_coasetting WHERE `key` = 'HutangPPNImpor';
                -- Hutang PPN impor
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID, @hutangPPNImpor,currency,rate,amount,0,amount*rate,0);

			END LOOP;            
		CLOSE curPPNCredit;
        SET done = 0;
        
        OPEN curWHTCredit;
			loopPONI: LOOP
				FETCH curWHTCredit INTO currency,rate,coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopPONI;
				END IF;
				SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,currency,rate,amount,0,amount*rate,0);

			END LOOP;            
		CLOSE curWHTCredit;
        SET done = 0;
        
        SELECT @hutangDagang := coaNo FROM ms_coasetting WHERE `key` = 'HutangDagang';
		-- insert hutang dagang supplier
		INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		VALUES (curHeadID, @hutangDagang,spCurrency,spRate,0,totalAmount,0,totalAmount*spRate);
	ELSEIF mode = 'import duty' OR mode = '14' THEN
		SELECT @journalDate := goodsReceiptDate, @notes := additionalInfo FROM tr_goodsreceipthead WHERE goodsReceiptNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, notes, createdBy, createdDate, editedBy, editedDate)
        VALUES (@journalDate,'Import Duty',refNum, @notes, 'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        SELECT @beaImpor := beaImpor.coaNo, @ppnImpor := ppnImpor.coaNo, 
		@pph22Impor := pph22Impor.coaNo, @hutangDagang := hutangDagang.coaNo
		FROM ms_coasetting AS beaImpor
		JOIN ms_coasetting AS ppnImpor ON ppnImpor.key = 'PPNImpor'
		JOIN ms_coasetting AS pph22Impor ON pph22Impor.key = 'PPH22Impor'
		JOIN ms_coasetting AS hutangDagang ON hutangDagang.key = 'HutangPPJK'
		WHERE beaImpor.key = 'BeaImpor';
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID, @beaImpor, po.currencyID,grh.pibRate,CAST(IFNULL(grc.importDutyAmount / grh.pibRate, 0) AS DECIMAL(18, 2)),0,grc.importDutyAmount,0
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID, @ppnImpor, po.currencyID,grh.pibRate,CAST(IFNULL(grc.PPNImportAmount/grh.pibRate,0) AS DECIMAL(18, 2)),0,grc.PPNImportAmount,0
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID, @pph22Impor,po.currencyID,grh.pibRate,CAST(IFNULL(grc.PPHImportAmount/grh.pibRate, 0) AS DECIMAL(18, 2)),0,grc.PPHImportAmount,0
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID, @hutangDagang,po.currencyID,grh.pibRate,0,
		CAST(IFNULL((grc.importDutyAmount+grc.PPNImportAmount+grc.PPHImportAmount)/grh.pibRate, 0) AS DECIMAL(18, 2)),
		0,grc.importDutyAmount+grc.PPNImportAmount+grc.PPHImportAmount
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_delete_stockhpp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_stockhpp`(IN `warehouseVar` VARCHAR(50), `productVar` INT(11), `qtyVar` DECIMAL(18,2), `batchNumberVar` VARCHAR(50))
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE spStockID INT;
    DECLARE spQtyStock DECIMAL(18,2);
    DECLARE tempQtyStock DECIMAL(18,2);
	
    DECLARE cur CURSOR FOR
		select ID,qtyStock from tr_stockhpp
        where warehouseID=warehouseVar and productID=productVar and batchNumber=batchNumberVar
        order by stockDate;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
    SET SQL_SAFE_UPDATES=0;
	OPEN cur;
		IF qtyVar > 0 THEN
			loopHPP: LOOP
				FETCH cur INTO spStockID,spQtyStock;
				IF done = 1 THEN
					LEAVE loopHPP;
				END IF;
				
				IF spQtyStock < qtyVar THEN
					SET tempQtyStock = 0;
				ELSE
					SET tempQtyStock = spQtyStock - qtyVar;
				END IF;
				
				SET qtyVar = qtyVar - spQtyStock;
                
				UPDATE tr_stockhpp SET qtyStock=tempQtyStock 
                WHERE ID=spStockID;
				
			END LOOP;
        END IF;
	CLOSE cur;
	SET done = 0;
   
	DELETE FROM tr_stockhpp WHERE qtyStock=0;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insert_journal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_journal`(IN `refNum` VARCHAR(50), `mode` INT)
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE curHeadID,curHeadID2 INT;
    DECLARE countLoop INT;
    DECLARE coaCategory,coaCategory2,coaCategory3 VARCHAR(20);
    DECLARE spRefNum VARCHAR(50);
    DECLARE transType VARCHAR(50);
    DECLARE transTypeGlobal VARCHAR(50);
    DECLARE amount,amount2,originalAmount,originalAmount2,profitLossAmount DECIMAL(18,2);
    DECLARE amountGlobal,rateGlobal,rateGlobal2,advancedAmountGlobal,advancedRateGlobal DECIMAL(18,2);
    DECLARE spQty,totalAmount,totalTax,importDuty,PPNImport,PPHImport DECIMAL(18,2);
    DECLARE importDutyGlobal,PPNGlobal,PPNImportGlobal,PPHImportGlobal,hutangDagangGlobal DECIMAL(18,2);
    DECLARE currency,spCurrency VARCHAR(5);
    DECLARE previousRate,rate,spRate DECIMAL(18,2);
    DECLARE spDiscount,totalDiscount DECIMAL(18,2);
    DECLARE flag BIT(1);
    DECLARE isImport BIT(1);
    DECLARE isImportGlobal BIT(1);
    
    DECLARE curTransType CURSOR FOR
		select a.transType from tr_goodsreceipthead a where a.goodsReceiptNum=refNum;
        
    DECLARE curSR CURSOR FOR 
		select c.coaNo,sum(grDetail.qty*e.HPP*((100 + e.VAT)/100)),sum(grDetail.qty*e.HPP*e.VAT/100)
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_salesreturndetail e on a.refNum=e.salesReturnNum
        join tr_salesreturnhead d on a.refNum=d.salesReturnNum
        join ms_product b on b.productID=e.productID
        join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID
        group by b.productCategoryID;
        
	DECLARE cur CURSOR FOR 
		select d.currencyID,d.rate,IF(d.isImport = 1,a.pibRate,d.rate),c.coaNo,grDetail.qty*e.price*((100 - e.discount)/100),d.isImport
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
        join tr_purchaseorderhead d on a.refNum=d.purchaseOrderNum
        join ms_product b on b.productID=e.productID
        join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID
        group by b.productCategoryID;
	
    DECLARE curCheckAPBalance CURSOR FOR
		SELECT abd.amount,ap.rate,ap.amount
		FROM tr_goodsreceipthead grh join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		left join tr_supplieradvancebalancehead abh on po.supplierID=abh.supplierID
		join tr_supplieradvancebalancedetail abd on abh.balanceHeadID=abd.balanceHeadID
		left join tr_supplieradvancepayment ap on grh.refNum=ap.refNum
		WHERE grh.goodsReceiptNum=refNum AND abd.refNum=ap.refNum;
        
	DECLARE curHD cursor for
		select b.currencyID,IF(b.isImport = 1,a.pibRate,b.rate),sum(grDetail.qty*e.price*((100 - e.discount)/100))
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
		left join tr_purchaseorderhead b on e.purchaseOrderNum=b.purchaseOrderNum
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID;
        
	DECLARE curPPN cursor for
		select sum(grDetail.qty*e.price*((100 - e.discount)/100)*b.taxRate/100)
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
		left join tr_purchaseorderhead b on e.purchaseOrderNum=b.purchaseOrderNum
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID;
        
	DECLARE curPPNImport cursor for
		select b.currencyID,a.pibRate,grc.importDutyAmount,grc.PPNImportAmount,grc.PPHImportAmount
		from tr_goodsreceipthead a 
		join tr_goodsreceiptdetail grDetail on grDetail.goodsReceiptNum=a.goodsReceiptNum
        left join tr_purchaseorderdetail e on a.refNum=e.purchaseOrderNum
		left join tr_purchaseorderhead b on e.purchaseOrderNum=b.purchaseOrderNum
        left join tr_goodsreceiptcost grc on a.goodsReceiptNum=grc.goodsReceiptNum
		where a.goodsReceiptNum=refNum and grDetail.productID=e.productID;
		
	DECLARE curLR cursor for
		select currency,rate,SUM(originalDrAmount),SUM(originalCrAmount),SUM(drAmount),SUM(crAmount) 
		from tr_journaldetail
		where journalHeadID=curHeadID;
        
	DECLARE curWHT cursor for
		select b.refNum 
        from tr_supplierpaymenthead a join tr_supplierpaymentdetail b on a.supplierPaymentNum=b.supplierPaymentNum
        where a.supplierPaymentNum=refNum;
        
	DECLARE curIUReason cursor for
		select c.coaNo,sum(b.qty),stock.HPP
		from tr_internalusagehead a
        join tr_internalusagedetail b
		join ms_reason c on b.purposeAccount=c.mapReasonID
        join tr_stockhpp stock on a.warehouseID=stock.warehouseID and b.productID=stock.productID
		where a.internalUsageNum=refNum
		group by b.purposeAccount;

	DECLARE curIUCategory cursor for
		select c.coaNo,sum(a.HPP)
		from tr_internalusagedetail a
		join ms_product b on a.productID=b.productID
		join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where internalUsageNum=refNum
		group by b.productCategoryID;
        
	DECLARE curSADebit cursor for
		select c.coaNo,sum(a.HPP)
		from tr_stockopnamedetail a
		join ms_product b on a.productID=b.productID
		join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.stockOpnameNum=refNum and a.qtyInStock>a.qtyReal
		group by b.productCategoryID;
        
	DECLARE curSACredit cursor for
		select c.coaNo,sum(a.HPP)
		from tr_stockopnamedetail a
		join ms_product b on a.productID=b.productID
		join ms_productcategory c on b.productCategoryID=c.productCategoryID
		where a.stockOpnameNum=refNum and a.qtyInStock<a.qtyReal
		group by b.productCategoryID;
        
	DECLARE curGDTransType cursor for
		select a.transType
        from tr_goodsdeliveryhead a
        where a.goodsDeliveryNum=refNum;
        
	DECLARE curGDCredit cursor for
		select f.coaNo,a.price*d.qty,a.tax,a.discount from tr_salesorderdetail a
		left join tr_salesorderhead b on a.salesOrderNum=b.salesOrderNum
		join tr_goodsdeliveryhead c on b.salesOrderNum=c.refNum
        join tr_goodsdeliverydetail d on c.goodsDeliveryNum=d.goodsDeliveryNum
        join ms_product e on d.productID=e.productID
        join ms_productcategory f on e.productCategoryID=f.productCategoryID
		where c.goodsDeliveryNum=refNum and a.productID=d.productID
        group by e.productCategoryID;
        
	DECLARE curGDCreditReturn cursor for
		select f.coaNo,a.HPP*d.qty*(100+a.VAT)/100
        from tr_purchasereturndetail a
		join tr_purchasereturnhead b on a.purchaseReturnNum=b.purchaseReturnNum
		join tr_goodsdeliveryhead c on b.purchaseReturnNum=c.refNum
        join tr_goodsdeliverydetail d on c.goodsDeliveryNum=d.goodsDeliveryNum
        join ms_product e on d.productID=e.productID
        join ms_productcategory f on e.productCategoryID=f.productCategoryID
		where c.goodsDeliveryNum=refNum and a.productID=d.productID
        group by e.productCategoryID;
        
	DECLARE curGLDebit cursor for
		select coaNo,currencyID,rate,sum(debitAmount)
        from tr_gltogldetail
        where gltoglNum=refNum and debitAmount is not null
        group by coaNo;
        
	DECLARE curGLCredit cursor for
		select coaNo,currencyID,rate,sum(creditAmount)
        from tr_gltogldetail
        where gltoglNum=refNum and creditAmount is not null
        group by coaNo;
        
	DECLARE curBbCredit cursor for
		select a.currencyID, a.rate, d.coaNo, sum(b.subtotal) as subtotal
		from tr_purchaseordernoninventoryhead a
		join tr_purchaseordernoninventorydetail b on a.purchaseOrderNonInventoryNum = b.purchaseOrderNonInventoryNum
		join ms_product c on b.productID = c.productID
		join ms_productcategory d on c.productCategoryID = d.productCategoryID
		where a.purchaseOrderNonInventoryNum =refNum
		group by c.productCategoryID;
        
	DECLARE curPPNCredit cursor for
		select a.currencyID, a.rate, sum((IF(a.hasVAT = 1,0.1,0)) * b.subtotal) as PPN from tr_purchaseOrderNonInventoryHead a
		join tr_purchaseOrderNonInventoryDetail b on a.purchaseOrderNoninventoryNum = b.purchaseOrderNonInventoryNum
        where a.purchaseOrderNonInventoryNum = refNum
		group by a.purchaseOrderNoninventoryNum;
        
	DECLARE curWHTCredit cursor for
		select a.currencyID, a.rate, c.coaNo, sum((a.whtRate / 100) * b.subtotal) as WHT from tr_purchaseOrderNonInventoryHead a
		join tr_purchaseOrderNonInventoryDetail b on a.purchaseOrderNoninventoryNum = b.purchaseOrderNonInventoryNum
        join ms_tax c on c.taxID=a.whtID
        where a.purchaseOrderNonInventoryNum = refNum
		group by a.purchaseOrderNonInventoryNum;
	
    DECLARE curAPCustomer cursor for
		select b.refNum,b.amount
        from tr_customerpayment a join tr_goodsreceipthead gd on a.refNum=gd.refNum
        join tr_customeradvancebalancedetail b on gd.refNum=b.refNum
        where a.customerPaymentNum=refNum;
        
         
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
    
	IF mode = 1 THEN
		OPEN curTransType;
			loopTransType: LOOP
				FETCH curTransType INTO transType;
				IF done = 1 THEN
					LEAVE loopTransType;
				END IF;
				
				IF transType = 'Purchase Order' THEN
					INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
					VALUES (NOW(),'Goods Receipt',refNum,'admin',NOW(),'admin',NOW());
					
					SELECT LAST_INSERT_ID() INTO curHeadID;
					SET totalAmount = 0;
					SET importDutyGlobal = 0;
					SET PPNGlobal = 0;
					
					OPEN cur;
						loopDebit: LOOP
							FETCH cur INTO currency,previousRate,rate,coaCategory,originalAmount,isImport;
							IF done = 1 THEN
								LEAVE loopDebit;
							END IF;
							
							SET isImportGlobal = isImport;
                            SET spCurrency = currency;
                            SET rateGlobal = rate; -- current rate
                            SET rateGlobal2 = previousRate; -- rate PO
							
							IF isImport = 1 THEN
								SET totalAmount = totalAmount + originalAmount;
								INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
								VALUES (curHeadID,coaCategory,currency,rate,originalAmount,0,originalAmount*rate,0);
							ELSE
								SET totalAmount = totalAmount + originalAmount;
								INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
								VALUES (curHeadID,coaCategory,currency,rate,originalAmount,0,originalAmount,0);
							END IF;
						END LOOP;
					CLOSE cur;
					SET done = 0;
                    
					-- insert Advanced Payment
                    SET advancedAmountGlobal = 0;
                    SET advancedRateGlobal = 0;
                    OPEN curCheckAPBalance;
						loopCredit: LOOP
							FETCH curCheckAPBalance INTO amount,rate,amount2;
							IF done = 1 THEN
								LEAVE loopCredit;
							END IF;
							
							if (amount2>0 && amount2=amount) THEN		
								SET advancedRateGlobal = rate;
								SET advancedAmountGlobal = amount2;
								INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
								SELECT curHeadID,'1120.0002',ap.currencyID,ap.rate,0,ap.amount,0,ap.amount*ap.rate
                                FROM tr_goodsreceipthead grh join tr_supplieradvancepayment ap ON grh.refNum=ap.refNum
                                WHERE grh.goodsReceiptNum=refNum;
                                
							END IF;
							
						END LOOP;
					CLOSE curCheckAPBalance;
					SET done = 0;
                    
                    -- insert PPN for non import
                    SET PPNGlobal = 0;
					if isImportGlobal=0 THEN 	
						OPEN curPPN;
							loopDebit: LOOP
								FETCH curPPN INTO originalAmount;
								IF done = 1 THEN
									LEAVE loopDebit;
								END IF;
								
								if originalAmount>0 THEN					
									SET PPNGlobal = originalAmount;
									INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
									VALUES (curHeadID,(SELECT a.coaNo FROM ms_coasetting a WHERE a.key='PPN'),'IDR',1,originalAmount,0,originalAmount,0);
								END IF;
								
							END LOOP;
						CLOSE curPPN;
						SET done = 0;
					END IF;
                    
                    -- insert Hutang Dagang
                    SET hutangDagangGlobal = totalAmount - advancedAmountGlobal;
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					SELECT curHeadID,(SELECT a.coaNo FROM ms_coasetting a WHERE a.key='HutangDagang'),spCurrency,rateGlobal,0,hutangDagangGlobal+PPNGlobal,0,totalAmount*rateGlobal + advancedAmountGlobal*advancedRateGlobal - PPNGlobal;
                        
					if isImportGlobal=1 THEN 	
						SET profitLossAmount = totalAmount*rateGlobal2 - advancedAmountGlobal*advancedRateGlobal - totalAmount*rateGlobal;
						IF (profitLossAmount > 0) THEN -- profit on debit side
							INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES(curHeadID,'3190.0001','IDR',1,0,profitLossAmount,0,profitLossAmount);
						ELSEIF (profitLossAmount < 0) THEN
							INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES(curHeadID,'3190.0001','IDR',1,-(profitLossAmount),0,-(profitLossAmount),0);
						END IF;
                    END IF;
				ELSEIF transType = 'Sales Return' THEN
					INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
					VALUES (NOW(),'Goods Receipt (Return)',refNum,'admin',NOW(),'admin',NOW());
					
					SELECT LAST_INSERT_ID() INTO curHeadID;
                    SET totalAmount = 0;
                    
                    OPEN curSR;
						loopDebit: LOOP
							FETCH curSR INTO coaCategory,amount,PPNGlobal;
							IF done = 1 THEN
								LEAVE loopDebit;
							END IF;
							
							SET totalAmount = totalAmount + amount + PPNGlobal;
							INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES (curHeadID,coaCategory,'IDR',1,amount,0,amount,0);
                            
                            IF PPNGlobal > 0 THEN
								INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
							VALUES (curHeadID,'1122.0002','IDR',1,PPNGlobal,0,PPNGlobal,0);
                            END IF;
							
						END LOOP;
					CLOSE curSR;
					SET done = 0;
                    
                    INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID,'1114.0001','IDR',1,0,totalAmount,0,totalAmount);
				END IF;
			END LOOP;
		CLOSE curTransType;
		SET done = 0;
     
	ELSEIF mode = -99 THEN
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Cash In',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        		 INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		 SELECT curHeadID,a.cashAccount,a.currencyID,a.rate,a.cashInAmount,0,a.cashInAmount*a.rate,0
		 FROM tr_cashin a
		 WHERE a.cashInNum=refNum;
            
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		 SELECT curHeadID,a.incomeAccount,a.currencyID,a.rate,0,a.cashInAmount,0,a.cashInAmount*a.rate
		 FROM tr_cashin a
		 WHERE a.cashInNum=refNum;
        
	ELSEIF mode = -99 THEN
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Cash Out',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        		 INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		 SELECT curHeadID,a.cashAccount,a.currencyID,a.rate,0,a.cashOutAmount,0,a.cashOutAmount*a.rate
		 FROM tr_cashout a
		 WHERE a.cashOutNum=refNum;
            
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		 SELECT curHeadID,a.expenseAccount,a.currencyID,a.rate,a.cashOutAmount,0,a.cashOutAmount*a.rate,0
		 FROM tr_cashout a
		 WHERE a.cashOutNum=refNum;
         
	ELSEIF mode = 2 OR mode = 3 THEN
		-- Make sure no duplicate
		DELETE FROM tr_journaldetail WHERE journalHeadID = (SELECT journalHeadID FROM tr_journalhead WHERE tr_journalhead.refNum = refNum);
        DELETE FROM tr_journalhead WHERE tr_journalhead.refNum = refNum;
    
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, notes, createdBy, createdDate, editedBy, editedDate)
		SELECT NOW(), (SELECT IF(cashIO.flagCashInOut = 'in', 'Cash In', 'Cash Out')), 
			cashIO.cashInOutNum, cashIO.additionalInfo, cashIO.createdBy , cashIO.createdDate, cashIO.editedBy, cashIO.editedDate
		FROM tr_cashinouthead AS cashIO WHERE cashIO.cashInOutNum = refNum;
        
		
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        IF (SELECT flagCashInOut FROM tr_cashinouthead WHERE tr_cashinouthead.cashInOutNum = refNum) = 'in' THEN
			-- Cash In
			-- Insert the Total
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIO.cashAccount, cashIO.currencyID, cashIO.rate, 
			SUM(cashIODetail.amount), 0, SUM(cashIODetail.amount) * cashIO.rate, 0
			FROM tr_cashinoutdetail AS cashIODetail, tr_cashinouthead AS cashIO
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
				
			-- Insert the Detail
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIODetail.destinationAccount, cashIO.currencyID, cashIO.rate, 
			0, cashIODetail.amount, 0, cashIODetail.amount * cashIO.rate
			FROM  tr_cashinouthead AS cashIO, tr_cashinoutdetail AS cashIODetail
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
		ELSE
			-- Cash Out
			-- Insert the Total
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIO.cashAccount, cashIO.currencyID, cashIO.rate, 
			0, SUM(cashIODetail.amount), 0, SUM(cashIODetail.amount) * cashIO.rate
			FROM tr_cashinoutdetail AS cashIODetail, tr_cashinouthead AS cashIO
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
				
			-- Insert the Detail
			INSERT INTO tr_journaldetail (journalHeadID, coaNo, currency, rate, originalDrAmount, originalCrAmount, drAmount, crAmount)
			SELECT curHeadID, cashIODetail.destinationAccount, cashIO.currencyID, cashIO.rate, 
			cashIODetail.amount, 0, cashIODetail.amount * cashIO.rate, 0
			FROM  tr_cashinouthead AS cashIO, tr_cashinoutdetail AS cashIODetail
			WHERE cashIO.cashInOutNum=refNum AND cashIODetail.cashInOutNum=refNum;
		END IF;
		
    ELSEIF mode = 4 THEN 
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Supplier Advanced Payment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.treasuryCOA,a.currencyID,a.rate,a.amount,0,a.amount*a.rate,0
		FROM tr_supplieradvancepayment a
		WHERE a.supplierAdvancePaymentNum=refNum;
            
		INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.paymentCOA,a.currencyID,a.rate,0,a.amount,0,a.amount*a.rate
		FROM tr_supplieradvancepayment a
		WHERE a.supplierAdvancePaymentNum=refNum;
    
    ELSEIF mode = 5 THEN
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Supplier Payment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
                INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,'2111.0001',a.currencyID,a.rate,sum(b.transactionAmountBeforeTax*(100+b.tax)/100),0,sum(b.transactionAmountBeforeTax*a.rate*(100+b.tax)/100),0
		FROM tr_supplierpaymenthead a join tr_supplierpaymentdetail b on a.supplierPaymentNum=b.supplierPaymentNum
		WHERE a.supplierPaymentNum=refNum;
        
        -- from purchase order non inventory
        OPEN curWHT;
			loopWHT: LOOP
				FETCH curWHT INTO spRefNum;
				IF done = 1 THEN
					LEAVE loopWHT;
				END IF;
				
				if SUBSTRING(spRefNum,5,4)='PONI' THEN
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					SELECT curHeadID,(SELECT t.coaNo from ms_tax t where t.taxID=po.whtID),a.currencyID,a.rate,0,b.whtAmount,0,b.whtAmount*a.rate
					FROM tr_supplierpaymenthead a join tr_supplierpaymentdetail b on a.supplierPaymentNum=b.supplierPaymentNum
					left join tr_purchaseordernoninventoryhead po on b.refNum=po.purchaseOrderNonInventoryNum
					WHERE a.supplierPaymentNum=refNum;
				END IF;
			END LOOP;
		CLOSE curWHT;
		SET done = 0;
        
                INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,'1120.0002',a.currencyID,a.rate,0,-(b.amount),0,-(b.amount)*a.rate
		FROM tr_supplierpaymenthead a join tr_supplieradvancebalancedetail b on a.supplierPaymentNum=b.refNum
		WHERE a.supplierPaymentNum=refNum;
        
                INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.coaNo,a.currencyID,a.rate,0,b.paymentAmount,0,b.paymentAmount*a.rate
		FROM tr_supplierpaymenthead a join tr_supplierpaymentdetail b on a.supplierPaymentNum=b.supplierPaymentNum
		WHERE a.supplierPaymentNum=refNum;
        
	ELSEIF mode = 6 THEN 
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Customer Advanced Payment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.paymentCOA,a.currencyID,a.rate,a.amount,0,a.amount*a.rate,0
		FROM tr_customeradvancepayment a
		WHERE a.custAdvancePaymentNum=refNum;
            
		INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.treasuryCOA,a.currencyID,a.rate,0,a.amount,0,a.amount*a.rate
		FROM tr_customeradvancepayment a
		WHERE a.custAdvancePaymentNum=refNum;
        
	ELSEIF mode = 7 THEN 
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Customer Payment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
                INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,'1114.0001','IDR',1,0,a.transactionAmount,0,a.transactionAmount
		FROM tr_customerpayment a
		WHERE a.customerPaymentNum=refNum;
        
        OPEN curAPCustomer;
			loopAPC: LOOP
				FETCH curAPCustomer INTO spRefNum,amount;
				IF done = 1 THEN
					LEAVE loopAPC;
				END IF;
				
				if spRefNum is not null THEN
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID,'2119.0001','IDR',1,amount,0,amount,0);
				END IF;
			END LOOP;
		CLOSE curAPCustomer;
		SET done = 0;
        
                INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.coaNo,'IDR',1,a.paymentAmount,0,a.paymentAmount,0
		FROM tr_customerpayment a
		WHERE a.customerPaymentNum=refNum;
	
    ELSEIF mode = 8 THEN
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Stock Adjustment',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        OPEN curSADebit;
			SET totalAmount = 0;
            SET countLoop = 0;
			loopSA: LOOP
				FETCH curSADebit INTO coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopSA;
				END IF;
				
                SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,amount,0,amount,0);
                
				SET countLoop = countLoop + 1;
			END LOOP;
            IF countLoop > 0 THEN
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
			VALUES (curHeadID,'8110.0007','IDR',1,0,totalAmount,0,totalAmount);
			END IF;
		CLOSE curSADebit;
        SET done = 0;
        
        OPEN curSACredit;
			SET totalAmount = 0;
            SET countLoop = 0;
			loopSA: LOOP
				FETCH curSACredit INTO coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopSA;
				END IF;
				
                SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,0,amount,0,amount);
                
				SET countLoop = countLoop + 1;
			END LOOP;
            IF countLoop > 0 THEN
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
			VALUES (curHeadID,'7110.0011','IDR',1,totalAmount,0,totalAmount,0);
			END IF;
		CLOSE curSACredit;
        SET done = 0;
        
    ELSEIF mode = 9 THEN 
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Internal Usage',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        OPEN curIUReason;
			loopIU: LOOP
				FETCH curIUReason INTO coaCategory,spQty,amount;
				IF done = 1 THEN
					LEAVE loopIU;
				END IF;

				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,spQty*amount,0,spQty*amount,0);

			END LOOP;
		CLOSE curIUReason;
        SET done = 0;
        
        OPEN curIUCategory;
			loopIU: LOOP
				FETCH curIUCategory INTO coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopIU;
				END IF;

				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,'IDR',1,0,amount,0,amount);

			END LOOP;
		CLOSE curIUCategory;
        SET done = 0;
    ELSEIF mode = 10 THEN 
        OPEN curGDTransType;
			loopGD: LOOP
				FETCH curGDTransType INTO transType;
				IF done = 1 THEN
					LEAVE loopGD;
				END IF;
				IF transType='Sales Order' THEN                    
                    -- insert sales invoice
                    INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
					VALUES (NOW(),'Sales Invoice',refNum,'admin',NOW(),'admin',NOW());
                    
                    SELECT LAST_INSERT_ID() INTO curHeadID;
                    
					OPEN curGDCredit;
					SET totalAmount = 0;
                    SET totalTax = 0;
					SET totalDiscount = 0;
					loopCredit: LOOP
						FETCH curGDCredit INTO coaCategory,amount,PPNGlobal,spDiscount;
						IF done = 1 THEN
							LEAVE loopCredit;
						END IF;
						
						SET totalAmount = totalAmount + amount*(100-spDiscount)/100*(100+PPNGlobal)/100;
                        SET totalTax = totalTax + PPNGlobal*amount/100;
						SET totalDiscount = totalDiscount + spDiscount*amount/100;
						INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID,coaCategory,'IDR',1,0,amount*(100-spDiscount)/100*(100+PPNGlobal)/100,0,amount*(100-spDiscount)/100*(100+PPNGlobal)/100);
                        
                        -- sales invoice
                        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID,'4110.0001','IDR',1,0,amount*(100-spDiscount)/100,0,amount*(100-spDiscount)/100);
                        
                        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID,'2115.0002','IDR',1,0,PPNGlobal*amount/100,0,PPNGlobal*amount/100);

					END LOOP;
					
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID,'4110.0005','IDR',1,totalAmount,0,totalAmount,0);
					
                    -- sales invoice
                    INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID,'1114.0001','IDR',1,totalAmount-totalDiscount,0,totalAmount-totalDiscount,0);
                    
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID,'4110.0003','IDR',1,totalDiscount,0,totalDiscount,0); -- discount

					CLOSE curGDCredit;
					SET done = 0;
                    
                ELSEIF transType='Purchase Return' THEN
					INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
					VALUES (NOW(),'Goods Delivery (Return)',refNum,'admin',NOW(),'admin',NOW());
					
					SELECT LAST_INSERT_ID() INTO curHeadID;
                    
					OPEN curGDCreditReturn;
					SET totalAmount = 0;
					loopCredit: LOOP
						FETCH curGDCreditReturn INTO coaCategory,amount;
						IF done = 1 THEN
							LEAVE loopCredit;
						END IF;
						
						SET totalAmount = totalAmount + amount;
						INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
						VALUES (curHeadID,coaCategory,'IDR',1,0,amount,0,amount);

					END LOOP;
					
					INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
					VALUES (curHeadID,'2111.0001','IDR',1,totalAmount,0,totalAmount,0);
	
					CLOSE curGDCreditReturn;
					SET done = 0;
                END IF;

			END LOOP;
		CLOSE curGDTransType;
        SET done = 0;
        
        
    
    ELSEIF mode = 11 THEN 
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'GL To GL',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.coaNo,a.currencyID,a.rate,sum(a.debitAmount),0,sum(a.rate*a.debitAmount),0
		from tr_gltogldetail a
		where a.gltoglNum=refNum and a.debitAmount is not null
		group by a.coaNo;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.coaNo,a.currencyID,a.rate,0,sum(a.creditAmount),0,sum(a.rate*a.creditAmount)
		from tr_gltogldetail a
		where a.gltoglNum=refNum and a.creditAmount is not null
		group by a.coaNo;
        
	ELSEIF mode = 12 THEN 
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Cash/Bank Transfer',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.destinationCurrency,b.currencyID,a.destinationRate,a.sourceAmount*a.sourceRate/a.destinationRate,0,a.sourceAmount*a.sourceRate,0
		from tr_cashbanktransfer a
        join ms_coa b on a.destinationCurrency=b.coaNo
		where a.transferID=refNum;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,a.sourceCurrency,b.currencyID,a.sourceRate,0,a.sourceAmount*a.sourceRate,0,a.sourceAmount*a.sourceRate
		from tr_cashbanktransfer a
        join ms_coa b on a.sourceCurrency=b.coaNo
		where a.transferID=refNum;
        
	ELSEIF mode = 13 THEN
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Purchase Order Non Inventory',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        SET totalAmount = 0;
        
        OPEN curBbCredit;
			loopPONI: LOOP
				FETCH curBbCredit INTO currency,rate,coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopPONI;
				END IF;
                SET spCurrency = currency;
                SET spRate = rate;
				SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,currency,rate,amount,0,amount*rate,0);

			END LOOP;            
		CLOSE curBbCredit;
        SET done = 0;
        
        OPEN curPPNCredit;
			loopPONI: LOOP
				FETCH curPPNCredit INTO currency,rate,amount;
				IF done = 1 THEN
					LEAVE loopPONI;
				END IF;
				SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,'2115.0010',currency,rate,amount,0,amount*rate,0);

			END LOOP;            
		CLOSE curPPNCredit;
        SET done = 0;
        
        OPEN curWHTCredit;
			loopPONI: LOOP
				FETCH curWHTCredit INTO currency,rate,coaCategory,amount;
				IF done = 1 THEN
					LEAVE loopPONI;
				END IF;
				SET totalAmount = totalAmount + amount;
				INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
				VALUES (curHeadID,coaCategory,currency,rate,amount,0,amount*rate,0);

			END LOOP;            
		CLOSE curWHTCredit;
        SET done = 0;
        
		-- insert hutang dagang supplier
		INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		VALUES (curHeadID,'2111.0001',spCurrency,spRate,0,totalAmount,0,totalAmount*spRate);
	ELSEIF mode = 14 THEN
		INSERT INTO tr_journalhead (journalDate, transactionType, refNum, createdBy, createdDate, editedBy, editedDate)
        VALUES (NOW(),'Import Duty',refNum,'admin',NOW(),'admin',NOW());
        
        SELECT LAST_INSERT_ID() INTO curHeadID;
        
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,(SELECT a.coaNo FROM ms_coasetting a WHERE a.key='BeaImpor'),po.currencyID,grh.pibRate,grc.importDutyAmount/grh.pibRate,0,grc.importDutyAmount,0
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,(SELECT a.coaNo FROM ms_coasetting a WHERE a.key='PPNImpor'),po.currencyID,grh.pibRate,grc.PPNImportAmount/grh.pibRate,0,grc.PPNImportAmount,0
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,(SELECT a.coaNo FROM ms_coasetting a WHERE a.key='PPH22Impor'),po.currencyID,grh.pibRate,grc.PPHImportAmount/grh.pibRate,0,grc.PPHImportAmount,0
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
        INSERT INTO tr_journaldetail (journalHeadID,coaNo,currency,rate,originalDrAmount,originalCrAmount,drAmount,crAmount)
		SELECT curHeadID,(SELECT a.coaNo FROM ms_coasetting a WHERE a.key='HutangDagang'),po.currencyID,grh.pibRate,0,(grc.importDutyAmount+grc.PPNImportAmount+grc.PPHImportAmount)/grh.pibRate,0,grc.importDutyAmount+grc.PPNImportAmount+grc.PPHImportAmount
		FROM tr_goodsreceiptcost grc join tr_goodsreceipthead grh on grc.goodsReceiptNum=grh.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grc.goodsReceiptNum=refNum;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insert_payable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_payable`(IN `refNum` VARCHAR(50), `mode` INT)
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE spAmount DECIMAL(18,2);
    DECLARE POAmount DECIMAL(18,2);
    DECLARE paymentAmount DECIMAL(18,2);
    DECLARE WHTAmount DECIMAL(18,2);
    DECLARE advAmount DECIMAL(18,2);
    DECLARE countPreviousPayment INT;
    DECLARE spSupplierID INT;
    DECLARE spCustomerID INT;
    DECLARE spCurrencyID VARCHAR(5);
    DECLARE spRate DECIMAL(18,2);
    DECLARE headID INT;
    
    DECLARE curGR CURSOR FOR 
		SELECT sum(a.qty*d.price*(100-d.discount)/100)*(1+c.taxRate/100) as price,c.supplierID,c.currencyID,c.rate
		from tr_goodsreceiptdetail a join tr_goodsreceipthead b on a.goodsReceiptNum=b.goodsReceiptNum
		join tr_purchaseorderhead c on b.refNum=c.purchaseOrderNum
		left join tr_purchaseorderdetail d on c.purchaseOrderNum=d.purchaseOrderNum and a.productID=d.productID
		where a.goodsReceiptNum=refNum;
        
	DECLARE curSP CURSOR FOR 
		SELECT count(a.refNum),a.paymentAmount,a.whtAmount,c.supplierID,c.currencyID,c.rate,d.amount
		from tr_supplierpaymenthead a join tr_goodsreceipthead b on a.refNum=b.goodsReceiptNum
		join tr_purchaseorderhead c on b.refNum=c.purchaseOrderNum
		left join tr_supplieradvancepayment d on c.purchaseOrderNum=d.refNum
		where a.supplierPaymentNum=refNum;
        
	DECLARE curGD CURSOR FOR 
		SELECT sum(a.qty*d.price*(100-d.discount)/100)*(1+d.tax/100) as price,c.customerID,'IDR',1
		from tr_goodsdeliverydetail a join tr_goodsdeliveryhead b on a.goodsDeliveryNum=b.goodsDeliveryNum
		join tr_salesorderhead c on b.refNum=c.salesOrderNum
		left join tr_salesorderdetail d on c.salesOrderNum=d.salesOrderNum and a.productID=d.productID
		where a.goodsDeliveryNum=refNum;
        
	DECLARE curCP CURSOR FOR 
		SELECT count(a.refNum),a.paymentAmount,c.customerID,d.amount
		from tr_customerpayment a join tr_goodsdeliveryhead b on a.refNum=b.goodsDeliveryNum
		join tr_salesorderhead c on b.refNum=c.salesOrderNum
		left join tr_customeradvancepayment d on c.salesOrderNum=d.refNum
		where a.customerPaymentNum=refNum;
        
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
    
	IF mode = 1 THEN
		OPEN curGR;
			loopGoodsReceipt: LOOP
				FETCH curGR INTO spAmount,spSupplierID,spCurrencyID,spRate;
				IF done = 1 THEN
					LEAVE loopGoodsReceipt;
				END IF;
                
                INSERT INTO tr_supplierpayablehead (payableDate, supplierID)
				VALUES (NOW(),spSupplierID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
				INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
				VALUES(headID,refNum,spCurrencyID,spRate,spAmount);
			END LOOP;
		CLOSE curGR;
		SET done = 0;
        
	ELSEIF mode = 2 THEN
		OPEN curSP;
			loopSP: LOOP
				FETCH curSP INTO countPreviousPayment,paymentAmount,WHTAmount,spSupplierID,spCurrencyID,spRate,advAmount;
				IF done = 1 THEN
					LEAVE loopSP;
				END IF;
                
                INSERT INTO tr_supplierpayablehead (payableDate, supplierID)
				VALUES (NOW(),spSupplierID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
                IF countPreviousPayment = 1 THEN
					INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,spCurrencyID,spRate,-(paymentAmount+WHTAmount+advAmount));
				ELSE
					INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,spCurrencyID,spRate,-paymentAmount);
				END IF;
			END LOOP;
		CLOSE curSP;
		SET done = 0;
	ELSEIF mode = 3 THEN
		OPEN curGD;
			loopGoodsDelivery: LOOP
				FETCH curGD INTO spAmount,spSupplierID,spCurrencyID,spRate;
				IF done = 1 THEN
					LEAVE loopGoodsDelivery;
				END IF;
                
                INSERT INTO tr_customerreceivablehead (receivableDate, customerID)
				VALUES (NOW(),spSupplierID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
				INSERT INTO tr_customerreceivabledetail(receivableNum,refNum,currency,rate,amount) 
				VALUES(headID,refNum,spCurrencyID,spRate,spAmount);
			END LOOP;
		CLOSE curGD;
		SET done = 0;
	ELSEIF mode = 4 THEN
		OPEN curCP;
			loopCP: LOOP
				FETCH curCP INTO countPreviousPayment,paymentAmount,spCustomerID,advAmount;
				IF done = 1 THEN
					LEAVE loopCP;
				END IF;
                
                INSERT INTO tr_customerreceivablehead (receivableDate, customerID)
				VALUES (NOW(),spCustomerID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
                IF countPreviousPayment = 1 THEN
					INSERT INTO tr_customerreceivabledetail(receivableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,'IDR',1,-(paymentAmount+advAmount));
				ELSE
					INSERT INTO tr_customerreceivabledetail(receivableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,'IDR',1,-paymentAmount);
				END IF;
			END LOOP;
		CLOSE curCP;
		SET done = 0;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insert_payablereceivable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_payablereceivable`(IN `refNum` VARCHAR(50), `mode` INT)
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE spAmount,spAmount2 DECIMAL(18,2);
    DECLARE POAmount DECIMAL(18,2);
    DECLARE paymentAmount DECIMAL(18,2);
    DECLARE WHTAmount DECIMAL(18,2);
    DECLARE balanceAmount,advAmount DECIMAL(18,2);
    DECLARE countPreviousPayment INT;
    DECLARE supplierID,spSupplierID INT;
    DECLARE spCustomerID INT;
    DECLARE currencyID,spCurrencyID VARCHAR(5);
    DECLARE rate,spRate DECIMAL(18,2);
    DECLARE headID INT;
    
    DECLARE curGR CURSOR FOR 
		SELECT sum(a.qty*d.price*(100-d.discount)/100)*(1+c.taxRate/100) as price,c.supplierID,c.currencyID,c.rate
		from tr_goodsreceiptdetail a join tr_goodsreceipthead b on a.goodsReceiptNum=b.goodsReceiptNum
		join tr_purchaseorderhead c on b.refNum=c.purchaseOrderNum
		left join tr_purchaseorderdetail d on c.purchaseOrderNum=d.purchaseOrderNum and a.productID=d.productID
		where a.goodsReceiptNum=refNum;
        
	DECLARE curCheckAP CURSOR FOR
		SELECT SUM(abd.amount),ap.amount
		FROM tr_goodsreceipthead grh join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		left join tr_supplieradvancebalancehead abh on po.supplierID=abh.supplierID
		join tr_supplieradvancebalancedetail abd on abh.balanceHeadID=abd.balanceHeadID
		left join tr_supplieradvancepayment ap on grh.refNum=ap.refNum
		WHERE grh.goodsReceiptNum=refNum;

	DECLARE curPNI CURSOR FOR 
		SELECT a.grandTotal,a.supplierID,a.currencyID,a.rate
		from tr_purchaseordernoninventoryhead a join tr_purchaseordernoninventorydetail b on a.purchaseOrderNonInventoryNum=b.purchaseOrderNonInventoryNum
		where a.purchaseOrderNonInventoryNum=refNum;
        
	DECLARE curSP CURSOR FOR 
		SELECT count(a.refNum),a.paymentAmount,a.whtAmount,c.supplierID,c.currencyID,c.rate,d.amount
		from tr_supplierpaymenthead a join tr_goodsreceipthead b on a.refNum=b.goodsReceiptNum
		join tr_purchaseorderhead c on b.refNum=c.purchaseOrderNum
		left join tr_supplieradvancepayment d on c.purchaseOrderNum=d.refNum
		where a.supplierPaymentNum=refNum;
        
	DECLARE curGD CURSOR FOR 
		SELECT sum(a.qty*d.price*(100-d.discount)/100)*(1+d.tax/100) as price,c.customerID,'IDR',1
		from tr_goodsdeliverydetail a join tr_goodsdeliveryhead b on a.goodsDeliveryNum=b.goodsDeliveryNum
		join tr_salesorderhead c on b.refNum=c.salesOrderNum
		left join tr_salesorderdetail d on c.salesOrderNum=d.salesOrderNum and a.productID=d.productID
		where a.goodsDeliveryNum=refNum;
        
	DECLARE curCP CURSOR FOR 
		SELECT count(a.refNum),a.paymentAmount,c.customerID,d.amount
		from tr_customerpayment a join tr_goodsdeliveryhead b on a.refNum=b.goodsDeliveryNum
		join tr_salesorderhead c on b.refNum=c.salesOrderNum
		left join tr_customeradvancepayment d on c.salesOrderNum=d.refNum
		where a.customerPaymentNum=refNum;
        
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
    
	IF mode = 1 THEN
		OPEN curGR;
			loopGoodsReceipt: LOOP
				FETCH curGR INTO spAmount,supplierID,currencyID,rate;
				IF done = 1 THEN
					LEAVE loopGoodsReceipt;
				END IF;
                -- set parameters
                SET POAmount = spAmount;
                SET spSupplierID = supplierID;
                SET spCurrencyID = currencyID;
                SET spRate = rate;
			END LOOP;
		CLOSE curGR;
		SET done = 0;
        
        -- check AP
        SET balanceAmount = 0;
        SET advAmount = 0;
        OPEN curCheckAP;
			loopAP: LOOP
				FETCH curCheckAP INTO spAmount,spAmount2;
				IF done = 1 THEN
					LEAVE loopAP;
				END IF;
				
				SET balanceAmount = spAmount;
                SET advAmount = spAmount2;
			END LOOP;
		CLOSE curCheckAP;
		SET done = 0;
        
		-- insert to payable
        INSERT INTO tr_supplierpayablehead (payableDate, supplierID)
		VALUES (NOW(),spSupplierID);
		
		SELECT LAST_INSERT_ID() INTO headID;
		
        IF (balanceAmount > 0 && advAmount > 0) THEN
			INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
			VALUES(headID,refNum,spCurrencyID,spRate,POAmount-advAmount);
        ELSE
			INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
			VALUES(headID,refNum,spCurrencyID,spRate,POAmount);
		END IF;
	ELSEIF mode = 2 THEN
		OPEN curSP;
			loopSP: LOOP
				FETCH curSP INTO countPreviousPayment,paymentAmount,WHTAmount,spSupplierID,spCurrencyID,spRate,advAmount;
				IF done = 1 THEN
					LEAVE loopSP;
				END IF;
                
                INSERT INTO tr_supplierpayablehead (payableDate, supplierID)
				VALUES (NOW(),spSupplierID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
                IF countPreviousPayment = 1 THEN
					INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,spCurrencyID,spRate,-(paymentAmount+WHTAmount+advAmount));
				ELSE
					INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,spCurrencyID,spRate,-paymentAmount);
				END IF;
			END LOOP;
		CLOSE curSP;
		SET done = 0;
	ELSEIF mode = 3 THEN
		OPEN curGD;
			loopGoodsDelivery: LOOP
				FETCH curGD INTO spAmount,spSupplierID,spCurrencyID,spRate;
				IF done = 1 THEN
					LEAVE loopGoodsDelivery;
				END IF;
                
                INSERT INTO tr_customerreceivablehead (receivableDate, customerID)
				VALUES (NOW(),spSupplierID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
				INSERT INTO tr_customerreceivabledetail(receivableNum,refNum,currency,rate,amount) 
				VALUES(headID,refNum,spCurrencyID,spRate,spAmount);
			END LOOP;
		CLOSE curGD;
		SET done = 0;
	ELSEIF mode = 4 THEN
		OPEN curCP;
			loopCP: LOOP
				FETCH curCP INTO countPreviousPayment,paymentAmount,spCustomerID,advAmount;
				IF done = 1 THEN
					LEAVE loopCP;
				END IF;
                
                INSERT INTO tr_customerreceivablehead (receivableDate, customerID)
				VALUES (NOW(),spCustomerID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
                IF countPreviousPayment = 1 THEN
					INSERT INTO tr_customerreceivabledetail(receivableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,'IDR',1,-(paymentAmount+advAmount));
				ELSE
					INSERT INTO tr_customerreceivabledetail(receivableNum,refNum,currency,rate,amount) 
					VALUES(headID,refNum,'IDR',1,-paymentAmount);
				END IF;
			END LOOP;
		CLOSE curCP;
		SET done = 0;
	ELSEIF mode = 5 THEN
		OPEN curPNI;
			loopPurchase: LOOP
				FETCH curPNI INTO spAmount,spSupplierID,spCurrencyID,spRate;
				IF done = 1 THEN
					LEAVE loopPurchase;
				END IF;
                
                INSERT INTO tr_supplierpayablehead (payableDate, supplierID)
				VALUES (NOW(),spSupplierID);
                
				SELECT LAST_INSERT_ID() INTO headID;
				
				INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
				VALUES(headID,refNum,spCurrencyID,spRate,spAmount);
			END LOOP;
		CLOSE curPNI;
		SET done = 0;
	ELSEIF mode = 6 THEN
		INSERT INTO tr_supplierpayablehead (payableDate, supplierID)
		SELECT NOW(),b.supplierID FROM tr_goodsreceipthead a join ms_supplier b on a.PPJK=b.supplierID
		WHERE a.goodsReceiptNum=refNum;
		
		SELECT LAST_INSERT_ID() INTO headID;
		
		INSERT INTO tr_supplierpayabledetail(payableNum,refNum,currency,rate,amount) 
		SELECT headID,refNum,po.currencyID,po.rate,grc.importDutyAmount+grc.PPNImportAmount+grc.PPHImportAmount
		FROM tr_goodsreceipthead grh join tr_goodsreceiptcost grc on grh.goodsReceiptNum=grc.goodsReceiptNum
		join tr_purchaseorderhead po on grh.refNum=po.purchaseOrderNum
		WHERE grh.goodsReceiptNum=refNum;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insert_samplestockcard` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_samplestockcard`(IN `mode` INT, `refNum` VARCHAR(50))
BEGIN
	SET SQL_SAFE_UPDATES = 0;
	IF mode = 1 THEN
		INSERT INTO tr_stockcardsample (refNum, transactionDate, productID, warehouseID, batchNumber, manufactureDate, expiredDate, retestDate, inQty, outQty)
		SELECT refNum,now(),a.productID,b.warehouseID,a.batchNumber,a.manufactureDate,a.expiredDate,a.retestDate,a.qty,0
        FROM tr_samplereceiptdetail a join tr_samplereceipthead b on a.sampleReceiptNum=b.sampleReceiptNum
        WHERE a.sampleReceiptNum = refNum;
	ELSEIF mode = 2 THEN
		INSERT INTO tr_stockcardsample (refNum, transactionDate, productID, warehouseID, batchNumber, manufactureDate, expiredDate, retestDate, inQty, outQty)
		SELECT refNum,now(),a.productID,b.warehouseID,a.batchNumber,a.manufactureDate,a.expiredDate,a.retestDate,0,a.qty
        FROM tr_samplereceiptdetail a join tr_samplereceipthead b on a.sampleReceiptNum=b.sampleReceiptNum
        WHERE a.sampleReceiptNum = refNum;
            
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insert_stockcard` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_stockcard`(IN `refNum` VARCHAR(50), `mode` INT)
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE spWarehouseID INT;
    DECLARE spProductID INT;
    DECLARE spQtyIn DECIMAL(18,2);
    DECLARE spQtyOut DECIMAL(18,2);
    DECLARE spManufactureDate DATETIME;
    DECLARE spExpiredDate DATETIME;
    DECLARE spRetestDate DATETIME;
    DECLARE spBatchNumber VARCHAR(50);
    DECLARE spFlagStatus BIT;
    
	DECLARE curGR CURSOR FOR 
		select a.warehouseID,b.productID,b.qty,b.batchNumber,b.manufactureDate,b.expiredDate,b.retestDate,b.goodsCondition
        from tr_goodsreceipthead a 
        join tr_goodsreceiptdetail b on a.goodsReceiptNum=b.goodsReceiptNum
        where a.goodsReceiptNum=refNum;
        
	DECLARE curGD CURSOR FOR 
		select a.warehouseID,b.productID,b.qty,b.batchNumber,b.manufactureDate,b.expiredDate,b.retestDate
        from tr_goodsdeliveryhead a 
        join tr_goodsdeliverydetail b on a.goodsDeliveryNum=b.goodsDeliveryNum
        where a.goodsDeliveryNum=refNum;
        
	DECLARE curSA CURSOR FOR 
		select a.warehouseID,b.productID,b.qtyReal-b.qtyInStock,b.batchNumber,b.manufactureDate,b.expiredDate,b.retestDate
        from tr_stockopnamehead a 
        join tr_stockopnamedetail b on a.stockOpnameNum=b.stockOpnameNum
        where a.stockOpnameNum=refNum;
        
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
	SET SQL_SAFE_UPDATES = 0;
    IF mode = 1 THEN 		
		OPEN curGR;
			loopGoodsReceipt: LOOP
				FETCH curGR INTO spWarehouseID,spProductID,spQtyIn,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate,spFlagStatus;
				IF done = 1 THEN
					LEAVE loopGoodsReceipt;
				END IF;
				
				INSERT INTO tr_stockcard (refNum, transactionDate, warehouseID, productID, inQty, outQty, flagStatus, batchNumber, manufactureDate, expiredDate, retestDate)
				VALUES (refNum,now(),spWarehouseID,spProductID,spQtyIn,0,spFlagStatus,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate);
				
			END LOOP;
		CLOSE curGR;
		SET done = 0;
	ELSEIF mode = 2 THEN 		
		OPEN curGD;
			loopGoods: LOOP
				FETCH curGD INTO spWarehouseID,spProductID,spQtyOut,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate;
				IF done = 1 THEN
					LEAVE loopGoods;
				END IF;
				
				INSERT INTO tr_stockcard (refNum, transactionDate, warehouseID, productID, inQty, outQty, flagStatus, batchNumber, manufactureDate, expiredDate, retestDate)
				VALUES (refNum,now(),spWarehouseID,spProductID,0,spQtyOut,1,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate);
				
			END LOOP;
		CLOSE curGD;
		SET done = 0;
    ELSEIF mode = 3 THEN 		
		OPEN curSA;
			loopGoods: LOOP
				FETCH curSA INTO spWarehouseID,spProductID,spQtyOut,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate;
				IF done = 1 THEN
					LEAVE loopGoods;
				END IF;
				
                IF spQtyOut > 0 THEN
					INSERT INTO tr_stockcard (refNum, transactionDate, warehouseID, productID, inQty, outQty, flagStatus, batchNumber, manufactureDate, expiredDate, retestDate)
					VALUES (refNum,now(),spWarehouseID,spProductID,spQtyOut,0,1,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate);
				ELSE
					INSERT INTO tr_stockcard (refNum, transactionDate, warehouseID, productID, inQty, outQty, flagStatus, batchNumber, manufactureDate, expiredDate, retestDate)
				VALUES (refNum,now(),spWarehouseID,spProductID,0,-spQtyOut,1,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate);
                END IF;
                
			END LOOP;
		CLOSE curSA;
		SET done = 0;
	END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_insert_stockhpp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_stockhpp`(IN `refNum` VARCHAR(50), `productID` INT(11), `hpp` DECIMAL(18,2), `mode` INT)
BEGIN
	DECLARE done INT DEFAULT 0;
    DECLARE spWarehouseID INT;
    DECLARE spProductID INT;
    DECLARE spQtyStock DECIMAL(18,2);
    DECLARE spManufactureDate DATETIME;
    DECLARE spExpiredDate DATETIME;
    DECLARE spRetestDate DATETIME;
    DECLARE spBatchNumber VARCHAR(50);
    
	DECLARE curGR CURSOR FOR 
		select a.warehouseID,b.productID,b.qty,b.batchNumber,b.manufactureDate,b.expiredDate,b.retestDate
        from tr_goodsreceipthead a 
        join tr_goodsreceiptdetail b on a.goodsReceiptNum=b.goodsReceiptNum
        where a.goodsReceiptNum=refNum and b.productID=productID;
        
	DECLARE curSTA CURSOR FOR
		select a.warehouseID,b.manufactureDate,b.expiredDate,b.retestDate,b.qtyReal-b.qtyInStock,b.batchNumber
        from tr_stockopnamehead a
        join tr_stockopnamedetail b on a.stockOpnameNum=b.stockOpnameNum
        where a.stockOpnameNum=refNum and b.productID=productID;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;  
    IF mode = 1 THEN 		OPEN curGR;
			loopGoodsReceipt: LOOP
				FETCH curGR INTO spWarehouseID,spProductID,spQtyStock,spBatchNumber,spManufactureDate,spExpiredDate,spRetestDate;
				IF done = 1 THEN
					LEAVE loopGoodsReceipt;
				END IF;
				
				INSERT INTO tr_stockhpp (stockDate, refNum, manufactureDate, expiredDate, retestDate, warehouseID, productID, HPP, qtyStock, batchNumber)
				VALUES (NOW(),refNum,spManufactureDate,spExpiredDate,spRetestDate,spWarehouseID,spProductID,hpp,spQtyStock,spBatchNumber);
				
			END LOOP;
		CLOSE curGR;
		SET done = 0;
        
	ELSEIF mode = 2 THEN 		OPEN curSTA;
			loopStockOpname: LOOP
				FETCH curSTA INTO spWarehouseID,spManufactureDate,spExpiredDate,spRetestDate,spQtyStock,spBatchNumber;
				IF done = 1 THEN
					LEAVE loopStockOpname;
				END IF;
				
				INSERT INTO tr_stockhpp (stockDate, refNum, manufactureDate, expiredDate, retestDate, warehouseID, productID, HPP, qtyStock, batchNumber)
				VALUES (NOW(),refNum,spManufactureDate,spExpiredDate,spRetestDate,spWarehouseID,productID,hpp,spQtyStock,spBatchNumber);
				
			END LOOP;
		CLOSE curSTA;
		SET done = 0;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_update_hpp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_hpp`(`warehouseIDVar` INT(11), `productIDVar` INT(11), `stockHPP` DECIMAL(18,2), `realHPP` DECIMAL(18,2))
BEGIN
	UPDATE tr_stockhpp SET HPP=realHPP
    WHERE warehouseID=warehouseIDVar and productID=productIDVar and HPP=stockHPP;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_update_samplestockcard` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_samplestockcard`(IN `mode` INT, `refNum` VARCHAR(50))
BEGIN
	SET SQL_SAFE_UPDATES = 0;
    DELETE stock FROM tr_stockcardsample AS stock WHERE stock.refNum = refNum;
    
	IF mode = 1 THEN -- qty in
		INSERT INTO tr_stockcardsample (refNum, transactionDate, productID, warehouseID, batchNumber, manufactureDate, expiredDate, retestDate, inQty, outQty)
		SELECT refNum,now(),a.productID,b.warehouseID,a.batchNumber,a.manufactureDate,a.expiredDate,a.retestDate,a.qty,0
        FROM tr_samplereceiptdetail a join tr_samplereceipthead b on a.sampleReceiptNum=b.sampleReceiptNum
        WHERE a.sampleReceiptNum = refNum;
	ELSEIF mode = 2 THEN -- qty out
		INSERT INTO tr_stockcardsample (refNum, transactionDate, productID, warehouseID, batchNumber, manufactureDate, expiredDate, retestDate, inQty, outQty)
		SELECT refNum,now(),a.productID,b.warehouseID,a.batchNumber,a.manufactureDate,a.expiredDate,a.retestDate,0,a.qty
        FROM tr_sampledeliverydetail a join tr_sampledeliveryhead b on a.sampleDeliveryNum=b.sampleDeliveryNum
        WHERE a.sampleDeliveryNum = refNum;
            
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-06 15:41:15
