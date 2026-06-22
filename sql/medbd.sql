-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: medbd
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (12,'Adminstrator','admin','21232f297a57a5a743894a0e4a801fc3'),(22,'Nasim Ahamed','nasim','5171cd170a8e204b7709d3819b599051'),(23,'Akib Hasan','akib','f3487412faca20f1af461f047c6181a6'),(24,'Naima Homaira khan','naima','680907fe81ee50cca424604ce8f8b111');
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cart`
--

DROP TABLE IF EXISTS `tbl_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cart`
--

LOCK TABLES `tbl_cart` WRITE;
/*!40000 ALTER TABLE `tbl_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_category`
--

LOCK TABLES `tbl_category` WRITE;
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` VALUES (25,'Baby & Mom Care','Category_80115.jpg','Yes','Yes'),(26,'Devices','Category_53450.jpg','Yes','Yes'),(27,'Herbal and Homeopathy','Category_8507.jpg','No','Yes'),(28,'Nutrition and drinks','Category_94948.jpg','No','Yes'),(29,'Personal Care','Category_5163.jpg','No','Yes'),(30,'Women care','Category_9438.jpg','Yes','Yes'),(31,'Vitamins','Category_12406.png','Yes','Yes'),(32,'Medicine','Category_7765.jpg','No','Yes');
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT '',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer`
--

LOCK TABLES `tbl_customer` WRITE;
/*!40000 ALTER TABLE `tbl_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_order`
--

DROP TABLE IF EXISTS `tbl_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `product` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'Cash on Delivery',
  `payment_status` varchar(50) DEFAULT 'Pending',
  `prescription_image` varchar(255) DEFAULT '',
  `customer_name` varchar(150) NOT NULL,
  `customer_contact` varchar(20) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order`
--

LOCK TABLES `tbl_order` WRITE;
/*!40000 ALTER TABLE `tbl_order` DISABLE KEYS */;
INSERT INTO `tbl_order` VALUES (7,NULL,32,'Blood Glucometer',2300.00,5,11500.00,'2022-12-09 01:45:31','Ordered','Cash on Delivery','Pending','','Rahat hasan','445839579354','hasan34@gmail.com','23/56 hazi danesh road ,dhaka'),(8,NULL,33,'Blood Lancet Needles',115.00,5,575.00,'2022-12-09 01:48:27','Cancelled','Cash on Delivery','Pending','','rakib haque','458234792','rakib345@gmail.com','33/6 merul badda bus stand,Dhaka'),(9,NULL,35,'Reusable Insulin Pen',590.00,1,590.00,'2022-12-09 01:53:25','Delivered','Cash on Delivery','Pending','','dalim sorkar','0138459834','dalim345@yahoo.com','23/7 north badda station road ,Dhaka'),(10,NULL,36,'Thermometer Digital LCD',120.00,1,120.00,'2022-12-09 01:56:36','On Delivery','Cash on Delivery','Pending','','nazrul islam','0183456-765','nazrul562@gmail.com','23/90  mohshin hasan sorok,malibag ,Dhaka'),(11,NULL,21,'Jhonson\'s Baby Shampoo',299.00,1,299.00,'2022-12-11 01:29:39','On Delivery','Cash on Delivery','Pending','','sahil','123456789','sahil@gmail.com','bashundara\'s'),(12,NULL,28,'Pampers',1599.00,1,1599.00,'2022-12-12 01:47:21','Ordered','Cash on Delivery','Pending','','alif','034233241','alif@gmail.com','3/1 Danmondi'),(13,NULL,23,'Kids Brush',350.00,1,350.00,'2022-12-18 09:07:38','Ordered','Cash on Delivery','Pending','','Akib Hasan','01516784700','vondo99baba@gmail.com','287/A, shantibag, dhaka.');
/*!40000 ALTER TABLE `tbl_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL,
  `requires_prescription` varchar(10) DEFAULT 'No',
  PRIMARY KEY (`id`),
  KEY `prod_cons` (`category_id`),
  CONSTRAINT `prod_cons` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product`
--

LOCK TABLES `tbl_product` WRITE;
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` VALUES (21,'Jhonson\'s Baby Shampoo','Jhonson\'s Baby Shampoo 200ml\r\nWash baby\'s hair with Johnson\'s® hypoallergenic and tear-free baby shampoo to gently cleanse and leave baby\'s hair fresh and shiny.',299.00,'Product-Name_73904.jpg',25,'No','Yes','No'),(22,'Huggies Wonder Pants Diaper','Diaper pants with 3-D Bubble-Bed provides ultimate cottony softness to your baby’s skin.',1000.00,'Product-Name_84631.webp',25,'No','Yes','No'),(23,'Kids Brush','Kids U-Shape Silicon Brush',350.00,'Product-Name_83418.jpg',25,'Yes','Yes','No'),(24,'Flashlight Earpick','LED Light Ear Cleaner Flashlight Earpick',250.00,'Product-Name_11140.jpg',25,'No','Yes','No'),(25,'Nestlé Cerelac','Nestlé Cerelac 3 Wheat _ Three Fruits Baby Food BIB ',350.00,'Product-Name_3966.jpg',25,'No','No','No'),(26,'Nestlé Lactogen','Nestlé Lactogen 1 Infant Formula TIN',650.00,'Product-Name_32473.jpg',25,'No','Yes','No'),(27,'Nestlé Milk Powder','Nestlé Nido 1+ Milk Powder (1-3 years)350gm',375.00,'Product-Name_80671.jpg',25,'No','Yes','No'),(28,'Pampers','Pampers All Round Protection Pants-L',1599.00,'Product-Name_48851.jpg',25,'Yes','Yes','No'),(29,'Pozzy Wet Wipes','Pozzy Comfort Cotton Wet Wipes',235.00,'Product-Name_5713.webp',25,'No','Yes','No'),(30,'Baby Spoon','Silicone Feeding Spoon For Baby',180.00,'Product-Name_20514.jpg',25,'No','Yes','No'),(32,'Blood Glucometer','Accu Chek Active Blood Glucometer',2300.00,'Product-Name_77314.jpg',26,'Yes','Yes','No'),(33,'Blood Lancet Needles','Blood Lancet Needles For Diabetes(30g)',115.00,'Product-Name_35022.jpg',26,'Yes','Yes','No'),(34,'Hot Water Bag','Hot Water Bag (Medium Size)With Cover ',250.00,'Product-Name_63938.jpg',26,'No','Yes','No'),(35,'Reusable Insulin Pen','Novopen 4 Silver Reusable Insulin Pen',590.00,'Product-Name_28613.webp',26,'Yes','Yes','No'),(36,'Thermometer Digital LCD','Thermometer Digital LCD',120.00,'Product-Name_1319.jpg',26,'Yes','Yes','No'),(37,'Uptech Go','Uptech Go(AERO SPACER)Adult',369.00,'Product-Name_32636.jpg',26,'Yes','Yes','No'),(38,' SANITARY NAPKIN','WHISPER MAXI FIT SANITARY NAPKIN (15 PADS)',250.00,'Product-Name_93820.webp',30,'No','Yes','No'),(39,'Femicon','Femicon',32.00,'Product-Name_67038.png',30,'No','No','No'),(40,'Sanitary Napkin ','Freedom Savlon Sanitary Napkin (Heavy Flow Wings)',200.00,'Product-Name_95902.jpg',30,'No','No','No'),(41,'Himalaya Shatavari ','Himalaya Shatavari Women_s Wellness',650.00,'Product-Name_24801.webp',30,'Yes','No','No'),(42,'Menstrual Cup','Menstrual Cup for Women Hygiene During Period Icare Cup',1150.00,'Product-Name_82195.webp',30,'No','Yes','No'),(43,'Minicon','Minicon',36.00,'Product-Name_3327.png',30,'No','No','No'),(44,'Pregnancy Test Cassette ','Pregnancy Test Cassette (Get Sure)',50.00,'Product-Name_31644.webp',30,'No','Yes','No'),(45,'VWash Plus Expert Intimate ','VWash Plus Expert Intimate Hygiene For Women- 100ml-',399.00,'Product-Name_64942.jpg',30,'No','Yes','No'),(46,'Beauty Fruit Detox Plum ','Beauty Fruit Detox Plum For Body Sliming',980.00,'Product-Name_45999.jpg',31,'No','Yes','No'),(47,'Bioflora','Bioflora',750.00,'Product-Name_78347.webp',31,'Yes','Yes','No'),(48,'Centrum Silver Multivitamin','Centrum Silver Multivitamin for Multivitamin/Multimineral Supplement with Vitamin D3, B Vitamins and Antioxidants ',2999.00,'Product-Name_87932.jpg',31,'Yes','Yes','No'),(49,'Ispergul','Ispergul',400.00,'Product-Name_92166.jpg',31,'Yes','No','No'),(50,'Lemon Flavour ','Lemon Flavour (Box: 30 Pcs)',450.00,'Product-Name_93549.jpg',31,'No','Yes','No'),(51,'Neo Cell Super Collagen','Neo Cell Super Collagen with Vitamin C',3500.00,'Product-Name_45145.jpg',31,'Yes','Yes','No'),(52,'Rex','Rex 6mg+200mg+50m',90.00,'Product-Name_62372.jpg',31,'No','Yes','No'),(53,'Acnovel Soap ','Acnovel Soap ',480.00,'Product-Name_21742.jpg',29,'Yes','Yes','No'),(54,'Bioderma Pigmentbio','Bioderma Pigmentbio Daily Care SPF50+ 40ml',2800.00,'Product-Name_59753.gif',29,'Yes','Yes','No'),(55,'Sleep Eye Mask','Sleep Eye Mask Eye Shade Eye Blindfold.Naturally Hypo-Allergenic So Is Great For Allergy Sufferers.',470.00,'Product-Name_28571.jpg',29,'No','Yes','No'),(56,'Fresh Up Dental Floss','Fresh Up Dental Floss Mint Flavor (50m)',85.00,'Product-Name_90265.jpg',29,'Yes','Yes','No'),(57,'Moov Cream ','Moov Cream 15',180.00,'Product-Name_68679.jpeg',29,'Yes','Yes','No'),(58,'Moov Spray','Moov Spray',720.00,'Product-Name_33985.jpg',29,'No','No','No'),(59,'Sensodyne Toothbrush ','Sensodyne Toothbrush Daily Care',60.00,'Product-Name_1638.jpeg',29,'No','No','No'),(60,'Braces and Shoulder Support  Belt','Taylor\'s Brace Back Posture Corrector Braces and Shoulder Support Belt(A13) \r\n',2140.00,'Product-Name_9016.webp',29,'No','Yes','No'),(61,'Ear Pick Cleaner Set','HEGRUS 6PCS Ear Pick Set Portable Ear Cleaner Set Stainless Steel Earpick Ear Wax Curette Remover Ear Cleaner.',600.00,'Product-Name_84255.jpg',29,'Yes','Yes','No'),(62,'Adovas','Adovas 250 ml. This herbal cough syrup liquefies phlegm. It soothes irritation of the throat. Helps to relieve hoarseness. ',63.00,'Product-Name_92479.jpeg',27,'Yes','Yes','No'),(63,'Alvasin','Alvasin is a unique combination of valuable medicinal plants for all types of cough and cold. The major ingredients of Alvasin is Vasaka.',126.00,'Product-Name_9775.jpg',27,'No','Yes','No'),(64,'CINKARA','CINKARA-450-ML.  Cinkara is a non-alcoholic vitaminised herbal tonic of proven bioavailability in mental performance, anemia of pregnancy, lactating mother.',67.00,'Product-Name_30518.jpg',27,'Yes','Yes','No'),(65,'Eprim softgel cap','Eprim softgel cap. prim softgel cap 500 mg. PMS symptoms, Cyclicalmastalgia, Atopic dermatitis, Low breast milk supply, Acne vulgaris, Pregnancy musk.',189.00,'Product-Name_67252.jpg',27,'No','No','No'),(66,'Lactohil','Lactohil is a natural formula meant to promote the quality and quantity of milk. Lactohil is 100% safe and effective. It can be used as a tonic',555.00,'Product-Name_98011.jpg',27,'No','Yes','No'),(67,'NAVIT CAP','Herbal Navit Capsule ; Indications. Spirulina is used for the treatment and prevention of malnutrition, diabetes, arthritis, asthma, hyperglycemia, anemia',216.00,'Product-Name_59773.jpg',27,'Yes','Yes','No'),(68,'Peniton','This preparation strengthens the tissue, stimulates the nerves and muscles as well as the flow of blood in the male organ, thus providing it stiffness',180.00,'Product-Name_13660.jpg',27,'No','No','No'),(69,'Radigel','Radigel Effervescent Powder (Container) ; Therapeutic Class. Bulk-forming laxatives',385.00,'Product-Name_80530.jpg',27,'Yes','Yes','No'),(70,'RedClov','Red Clover Isoflavones is indicated for menopausal women, for the relief of menopause symptoms. It helps to relieve symptoms of menopause',10.00,'Product-Name_97431.jpg',27,'No','No','No'),(71,'Safi','Hamdard Safi Syrup contains Sana, Sheesham, Sandal, Gilo, Harar, Chiraita, Nilkanthi, Neem, Tulsi, Chob chini, Keekar, Brahmi, Kasni',180.00,'Product-Name_18950.jpg',27,'Yes','Yes','No'),(72,'Basok','ACME\'S BASOK syrup relieves allergic and dry irritable cough. It liquefies phlegm. It is very effective in asthma, smoker\'s cough and throat hoarseness.',65.00,'Product-Name_81798.jpg',32,'No','Yes','No'),(73,'D-Sefa','Each soft gelatin capsule contains Black Seed Oil 500mg. Indication : D-Sefa is indicated for the treatment of common cold, cough, asthma',63.00,'Product-Name_21271.jpg',32,'No','Yes','No'),(74,'Eredex','Eredex Capsule. Yohimbine Hydrochloride. 5.4 mg. Square Pharmaceuticals Ltd',162.00,'Product-Name_84026.jpg',32,'No','Yes','No'),(75,'Frodex ','Frodex is a research product of Hamdard Laboratories and time tested aphrodisiac. Frodex is being used successfully to treat the patients of erectile',438.00,'Product-Name_28001.jpg',32,'No','Yes','No'),(76,'Ginoba','Herbal Ginoba Capsule. Ginkgo Biloba. 60 mg. Radiant Nutraceuticals Ltd. ',558.00,'Product-Name_19762.jpg',32,'No','Yes','No'),(77,'napa 500mg','napa 500mg Tablet Beximco Pharmaceuticals Ltd. Paracetamol is indicated for fever, common cold and influenza, headache, toothache, earache, bodyache, myalgia, neuralgia, dysmenorrhoea, sprains',7.00,'Product-Name_28331.jpg',32,'No','Yes','No'),(78,'Tufnil','Tufnil Tablet 200 mg (10pcs) ; Indications. Tolfenamic acid is used specifically for relieving the pain of migraine headaches and also recommended for use.',80.00,'Product-Name_68078.png',32,'Yes','Yes','No'),(79,'Pink-Lemonade','Country-Time-Pink-Lemonade-538gm.Weight: 538gm; Specialty: Gluten-Free, Caffeine Free; Country of origin:USA',1280.00,'Product-Name_23009.jpg',28,'No','Yes','No'),(80,'Dabur Honey','abur Honey is widely considered as one of the best cough remedy & often termed as \'the\' Honey for Weight Loss – One of the Best Honey Brand in India',200.00,'Product-Name_14688.jpg',28,'Yes','Yes','No'),(81,'ENO ','Eno Lemon Flavoured Powder, 5 gm ; Consume Type. ORAL ; Description. Get fast relief from acidity with ENO that starts working in just 6 seconds.',15.00,'Product-Name_86824.webp',28,'No','Yes','No'),(82,'GlucomaxD','GlucomaxD is a non-flavoured energy drink that can be used by children and adults alike. It helps in maintaining an active lifestyle for sports person',145.00,'Product-Name_54037.png',28,'No','Yes','No');
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_review`
--

DROP TABLE IF EXISTS `tbl_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_review` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `tbl_review_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_review_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_review`
--

LOCK TABLES `tbl_review` WRITE;
/*!40000 ALTER TABLE `tbl_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_wishlist`
--

DROP TABLE IF EXISTS `tbl_wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_wishlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `tbl_wishlist_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tbl_wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_wishlist`
--

LOCK TABLES `tbl_wishlist` WRITE;
/*!40000 ALTER TABLE `tbl_wishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_wishlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-22 10:46:11
