-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2022 at 10:33 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(12, 'Adminstrator', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(22, 'Nasim Ahamed', 'nasim', '5171cd170a8e204b7709d3819b599051'),
(23, 'Akib Hasan', 'akib', 'f3487412faca20f1af461f047c6181a6'),
(24, 'Naima Homaira khan', 'naima', '680907fe81ee50cca424604ce8f8b111');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(25, 'Baby & Mom Care', 'Category_80115.jpg', 'Yes', 'Yes'),
(26, 'Devices', 'Category_53450.jpg', 'Yes', 'Yes'),
(27, 'Herbal and Homeopathy', 'Category_8507.jpg', 'No', 'Yes'),
(28, 'Nutrition and drinks', 'Category_94948.jpg', 'No', 'Yes'),
(29, 'Personal Care', 'Category_5163.jpg', 'No', 'Yes'),
(30, 'Women care', 'Category_9438.jpg', 'Yes', 'Yes'),
(31, 'Vitamins', 'Category_12406.png', 'Yes', 'Yes'),
(32, 'Medicine', 'Category_7765.jpg', 'No', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_contact` varchar(20) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `product_id`, `product`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`) VALUES
(7, 32, 'Blood Glucometer', '2300.00', 5, '11500.00', '2022-12-09 01:45:31', 'Ordered', 'Rahat hasan', '445839579354', 'hasan34@gmail.com', '23/56 hazi danesh road ,dhaka'),
(8, 33, 'Blood Lancet Needles', '115.00', 5, '575.00', '2022-12-09 01:48:27', 'Cancelled', 'rakib haque', '458234792', 'rakib345@gmail.com', '33/6 merul badda bus stand,Dhaka'),
(9, 35, 'Reusable Insulin Pen', '590.00', 1, '590.00', '2022-12-09 01:53:25', 'Delivered', 'dalim sorkar', '0138459834', 'dalim345@yahoo.com', '23/7 north badda station road ,Dhaka'),
(10, 36, 'Thermometer Digital LCD', '120.00', 1, '120.00', '2022-12-09 01:56:36', 'On Delivery', 'nazrul islam', '0183456-765', 'nazrul562@gmail.com', '23/90  mohshin hasan sorok,malibag ,Dhaka'),
(11, 21, 'Jhonson\'s Baby Shampoo', '299.00', 1, '299.00', '2022-12-11 01:29:39', 'On Delivery', 'sahil', '123456789', 'sahil@gmail.com', 'bashundara\'s'),
(12, 28, 'Pampers', '1599.00', 1, '1599.00', '2022-12-12 01:47:21', 'Ordered', 'alif', '034233241', 'alif@gmail.com', '3/1 Danmondi'),
(13, 23, 'Kids Brush', '350.00', 1, '350.00', '2022-12-18 09:07:38', 'Ordered', 'Akib Hasan', '01516784700', 'vondo99baba@gmail.com', '287/A, shantibag, dhaka.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(21, 'Jhonson\'s Baby Shampoo', 'Jhonson\'s Baby Shampoo 200ml\r\nWash baby\'s hair with Johnson\'s® hypoallergenic and tear-free baby shampoo to gently cleanse and leave baby\'s hair fresh and shiny.', '299.00', 'Product-Name_73904.jpg', 25, 'No', 'Yes'),
(22, 'Huggies Wonder Pants Diaper', 'Diaper pants with 3-D Bubble-Bed provides ultimate cottony softness to your baby’s skin.', '1000.00', 'Product-Name_84631.webp', 25, 'No', 'Yes'),
(23, 'Kids Brush', 'Kids U-Shape Silicon Brush', '350.00', 'Product-Name_83418.jpg', 25, 'Yes', 'Yes'),
(24, 'Flashlight Earpick', 'LED Light Ear Cleaner Flashlight Earpick', '250.00', 'Product-Name_11140.jpg', 25, 'No', 'Yes'),
(25, 'Nestlé Cerelac', 'Nestlé Cerelac 3 Wheat _ Three Fruits Baby Food BIB ', '350.00', 'Product-Name_3966.jpg', 25, 'No', 'No'),
(26, 'Nestlé Lactogen', 'Nestlé Lactogen 1 Infant Formula TIN', '650.00', 'Product-Name_32473.jpg', 25, 'No', 'Yes'),
(27, 'Nestlé Milk Powder', 'Nestlé Nido 1+ Milk Powder (1-3 years)350gm', '375.00', 'Product-Name_80671.jpg', 25, 'No', 'Yes'),
(28, 'Pampers', 'Pampers All Round Protection Pants-L', '1599.00', 'Product-Name_48851.jpg', 25, 'Yes', 'Yes'),
(29, 'Pozzy Wet Wipes', 'Pozzy Comfort Cotton Wet Wipes', '235.00', 'Product-Name_5713.webp', 25, 'No', 'Yes'),
(30, 'Baby Spoon', 'Silicone Feeding Spoon For Baby', '180.00', 'Product-Name_20514.jpg', 25, 'No', 'Yes'),
(32, 'Blood Glucometer', 'Accu Chek Active Blood Glucometer', '2300.00', 'Product-Name_77314.jpg', 26, 'Yes', 'Yes'),
(33, 'Blood Lancet Needles', 'Blood Lancet Needles For Diabetes(30g)', '115.00', 'Product-Name_35022.jpg', 26, 'Yes', 'Yes'),
(34, 'Hot Water Bag', 'Hot Water Bag (Medium Size)With Cover ', '250.00', 'Product-Name_63938.jpg', 26, 'No', 'Yes'),
(35, 'Reusable Insulin Pen', 'Novopen 4 Silver Reusable Insulin Pen', '590.00', 'Product-Name_28613.webp', 26, 'Yes', 'Yes'),
(36, 'Thermometer Digital LCD', 'Thermometer Digital LCD', '120.00', 'Product-Name_1319.jpg', 26, 'Yes', 'Yes'),
(37, 'Uptech Go', 'Uptech Go(AERO SPACER)Adult', '369.00', 'Product-Name_32636.jpg', 26, 'Yes', 'Yes'),
(38, ' SANITARY NAPKIN', 'WHISPER MAXI FIT SANITARY NAPKIN (15 PADS)', '250.00', 'Product-Name_93820.webp', 30, 'No', 'Yes'),
(39, 'Femicon', 'Femicon', '32.00', 'Product-Name_67038.png', 30, 'No', 'No'),
(40, 'Sanitary Napkin ', 'Freedom Savlon Sanitary Napkin (Heavy Flow Wings)', '200.00', 'Product-Name_95902.jpg', 30, 'No', 'No'),
(41, 'Himalaya Shatavari ', 'Himalaya Shatavari Women_s Wellness', '650.00', 'Product-Name_24801.webp', 30, 'Yes', 'No'),
(42, 'Menstrual Cup', 'Menstrual Cup for Women Hygiene During Period Icare Cup', '1150.00', 'Product-Name_82195.webp', 30, 'No', 'Yes'),
(43, 'Minicon', 'Minicon', '36.00', 'Product-Name_3327.png', 30, 'No', 'No'),
(44, 'Pregnancy Test Cassette ', 'Pregnancy Test Cassette (Get Sure)', '50.00', 'Product-Name_31644.webp', 30, 'No', 'Yes'),
(45, 'VWash Plus Expert Intimate ', 'VWash Plus Expert Intimate Hygiene For Women- 100ml-', '399.00', 'Product-Name_64942.jpg', 30, 'No', 'Yes'),
(46, 'Beauty Fruit Detox Plum ', 'Beauty Fruit Detox Plum For Body Sliming', '980.00', 'Product-Name_45999.jpg', 31, 'No', 'Yes'),
(47, 'Bioflora', 'Bioflora', '750.00', 'Product-Name_78347.webp', 31, 'Yes', 'Yes'),
(48, 'Centrum Silver Multivitamin', 'Centrum Silver Multivitamin for Multivitamin/Multimineral Supplement with Vitamin D3, B Vitamins and Antioxidants ', '2999.00', 'Product-Name_87932.jpg', 31, 'Yes', 'Yes'),
(49, 'Ispergul', 'Ispergul', '400.00', 'Product-Name_92166.jpg', 31, 'Yes', 'No'),
(50, 'Lemon Flavour ', 'Lemon Flavour (Box: 30 Pcs)', '450.00', 'Product-Name_93549.jpg', 31, 'No', 'Yes'),
(51, 'Neo Cell Super Collagen', 'Neo Cell Super Collagen with Vitamin C', '3500.00', 'Product-Name_45145.jpg', 31, 'Yes', 'Yes'),
(52, 'Rex', 'Rex 6mg+200mg+50m', '90.00', 'Product-Name_62372.jpg', 31, 'No', 'Yes'),
(53, 'Acnovel Soap ', 'Acnovel Soap ', '480.00', 'Product-Name_21742.jpg', 29, 'Yes', 'Yes'),
(54, 'Bioderma Pigmentbio', 'Bioderma Pigmentbio Daily Care SPF50+ 40ml', '2800.00', 'Product-Name_59753.gif', 29, 'Yes', 'Yes'),
(55, 'Sleep Eye Mask', 'Sleep Eye Mask Eye Shade Eye Blindfold.Naturally Hypo-Allergenic So Is Great For Allergy Sufferers.', '470.00', 'Product-Name_28571.jpg', 29, 'No', 'Yes'),
(56, 'Fresh Up Dental Floss', 'Fresh Up Dental Floss Mint Flavor (50m)', '85.00', 'Product-Name_90265.jpg', 29, 'Yes', 'Yes'),
(57, 'Moov Cream ', 'Moov Cream 15', '180.00', 'Product-Name_68679.jpeg', 29, 'Yes', 'Yes'),
(58, 'Moov Spray', 'Moov Spray', '720.00', 'Product-Name_33985.jpg', 29, 'No', 'No'),
(59, 'Sensodyne Toothbrush ', 'Sensodyne Toothbrush Daily Care', '60.00', 'Product-Name_1638.jpeg', 29, 'No', 'No'),
(60, 'Braces and Shoulder Support  Belt', 'Taylor\'s Brace Back Posture Corrector Braces and Shoulder Support Belt(A13) \r\n', '2140.00', 'Product-Name_9016.webp', 29, 'No', 'Yes'),
(61, 'Ear Pick Cleaner Set', 'HEGRUS 6PCS Ear Pick Set Portable Ear Cleaner Set Stainless Steel Earpick Ear Wax Curette Remover Ear Cleaner.', '600.00', 'Product-Name_84255.jpg', 29, 'Yes', 'Yes'),
(62, 'Adovas', 'Adovas 250 ml. This herbal cough syrup liquefies phlegm. It soothes irritation of the throat. Helps to relieve hoarseness. ', '63.00', 'Product-Name_92479.jpeg', 27, 'Yes', 'Yes'),
(63, 'Alvasin', 'Alvasin is a unique combination of valuable medicinal plants for all types of cough and cold. The major ingredients of Alvasin is Vasaka.', '126.00', 'Product-Name_9775.jpg', 27, 'No', 'Yes'),
(64, 'CINKARA', 'CINKARA-450-ML.  Cinkara is a non-alcoholic vitaminised herbal tonic of proven bioavailability in mental performance, anemia of pregnancy, lactating mother.', '67.00', 'Product-Name_30518.jpg', 27, 'Yes', 'Yes'),
(65, 'Eprim softgel cap', 'Eprim softgel cap. prim softgel cap 500 mg. PMS symptoms, Cyclicalmastalgia, Atopic dermatitis, Low breast milk supply, Acne vulgaris, Pregnancy musk.', '189.00', 'Product-Name_67252.jpg', 27, 'No', 'No'),
(66, 'Lactohil', 'Lactohil is a natural formula meant to promote the quality and quantity of milk. Lactohil is 100% safe and effective. It can be used as a tonic', '555.00', 'Product-Name_98011.jpg', 27, 'No', 'Yes'),
(67, 'NAVIT CAP', 'Herbal Navit Capsule ; Indications. Spirulina is used for the treatment and prevention of malnutrition, diabetes, arthritis, asthma, hyperglycemia, anemia', '216.00', 'Product-Name_59773.jpg', 27, 'Yes', 'Yes'),
(68, 'Peniton', 'This preparation strengthens the tissue, stimulates the nerves and muscles as well as the flow of blood in the male organ, thus providing it stiffness', '180.00', 'Product-Name_13660.jpg', 27, 'No', 'No'),
(69, 'Radigel', 'Radigel Effervescent Powder (Container) ; Therapeutic Class. Bulk-forming laxatives', '385.00', 'Product-Name_80530.jpg', 27, 'Yes', 'Yes'),
(70, 'RedClov', 'Red Clover Isoflavones is indicated for menopausal women, for the relief of menopause symptoms. It helps to relieve symptoms of menopause', '10.00', 'Product-Name_97431.jpg', 27, 'No', 'No'),
(71, 'Safi', 'Hamdard Safi Syrup contains Sana, Sheesham, Sandal, Gilo, Harar, Chiraita, Nilkanthi, Neem, Tulsi, Chob chini, Keekar, Brahmi, Kasni', '180.00', 'Product-Name_18950.jpg', 27, 'Yes', 'Yes'),
(72, 'Basok', 'ACME\'S BASOK syrup relieves allergic and dry irritable cough. It liquefies phlegm. It is very effective in asthma, smoker\'s cough and throat hoarseness.', '65.00', 'Product-Name_81798.jpg', 32, 'No', 'Yes'),
(73, 'D-Sefa', 'Each soft gelatin capsule contains Black Seed Oil 500mg. Indication : D-Sefa is indicated for the treatment of common cold, cough, asthma', '63.00', 'Product-Name_21271.jpg', 32, 'No', 'Yes'),
(74, 'Eredex', 'Eredex Capsule. Yohimbine Hydrochloride. 5.4 mg. Square Pharmaceuticals Ltd', '162.00', 'Product-Name_84026.jpg', 32, 'No', 'Yes'),
(75, 'Frodex ', 'Frodex is a research product of Hamdard Laboratories and time tested aphrodisiac. Frodex is being used successfully to treat the patients of erectile', '438.00', 'Product-Name_28001.jpg', 32, 'No', 'Yes'),
(76, 'Ginoba', 'Herbal Ginoba Capsule. Ginkgo Biloba. 60 mg. Radiant Nutraceuticals Ltd. ', '558.00', 'Product-Name_19762.jpg', 32, 'No', 'Yes'),
(77, 'napa 500mg', 'napa 500mg Tablet Beximco Pharmaceuticals Ltd. Paracetamol is indicated for fever, common cold and influenza, headache, toothache, earache, bodyache, myalgia, neuralgia, dysmenorrhoea, sprains', '7.00', 'Product-Name_28331.jpg', 32, 'No', 'Yes'),
(78, 'Tufnil', 'Tufnil Tablet 200 mg (10pcs) ; Indications. Tolfenamic acid is used specifically for relieving the pain of migraine headaches and also recommended for use.', '80.00', 'Product-Name_68078.png', 32, 'Yes', 'Yes'),
(79, 'Pink-Lemonade', 'Country-Time-Pink-Lemonade-538gm.Weight: 538gm; Specialty: Gluten-Free, Caffeine Free; Country of origin:USA', '1280.00', 'Product-Name_23009.jpg', 28, 'No', 'Yes'),
(80, 'Dabur Honey', 'abur Honey is widely considered as one of the best cough remedy & often termed as \'the\' Honey for Weight Loss – One of the Best Honey Brand in India', '200.00', 'Product-Name_14688.jpg', 28, 'Yes', 'Yes'),
(81, 'ENO ', 'Eno Lemon Flavoured Powder, 5 gm ; Consume Type. ORAL ; Description. Get fast relief from acidity with ENO that starts working in just 6 seconds.', '15.00', 'Product-Name_86824.webp', 28, 'No', 'Yes'),
(82, 'GlucomaxD', 'GlucomaxD is a non-flavoured energy drink that can be used by children and adults alike. It helps in maintaining an active lifestyle for sports person', '145.00', 'Product-Name_54037.png', 28, 'No', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prod_cons` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `prod_cons` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
