-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 09:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoppingcart`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `prod_id`, `quantity`, `user_id`) VALUES
(41, 9489411, 1, 19);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_image`) VALUES
(15, 'Dolls 2', '679495871fbc0.PNG'),
(16, 'Files', '6793412e46ea3.jpg'),
(17, 'Fragrances', '6793416028fc8.jpg'),
(18, 'Handbag', '679341aa38bfd.jpg'),
(20, 'Shoes', '6793421aa265c.jpg'),
(21, 'Stationary Items', '679342450e52a.jpg'),
(22, 'Wallet', '6793429a1470e.jpg'),
(23, 'Watches', '679342b6520a4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`, `country_id`) VALUES
(7, 'Karachi', 6);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`) VALUES
(6, 'Black'),
(7, 'golden'),
(8, 'White'),
(9, 'Silver-colored');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `first_Name` varchar(255) NOT NULL,
  `last_Name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `phone_number` decimal(10,0) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`) VALUES
(6, 'Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `creditcard`
--

CREATE TABLE `creditcard` (
  `creditCardId` int(11) NOT NULL,
  `cardNumber` bigint(20) NOT NULL,
  `cvv` int(11) NOT NULL,
  `expiryDate` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `creditcard`
--

INSERT INTO `creditcard` (`creditCardId`, `cardNumber`, `cvv`, `expiryDate`, `user_id`) VALUES
(9, 2142142142142142, 214, '07/02/2025', 19);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delete_order`
--

CREATE TABLE `delete_order` (
  `delete_order_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` bigint(16) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delete_order`
--

INSERT INTO `delete_order` (`delete_order_id`, `prod_id`, `user_id`, `order_id`, `quantity`) VALUES
(1, 4490581, 13, 4968753517827591, 1),
(2, 1239271, 19, 1489938866503827, 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` bigint(16) DEFAULT NULL,
  `feedback_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `feedback_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `order_item_id` int(11) NOT NULL,
  `order_id` bigint(16) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(16) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `dispatch_status` enum('pending','dispatched','delivered') DEFAULT 'pending',
  `total_amount` float DEFAULT NULL,
  `payment_method_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `payment_status`, `dispatch_status`, `total_amount`, `payment_method_id`) VALUES
(1081181304542059, 19, '2025-02-05 17:22:23', 'pending', 'pending', 65, 2),
(1179456120470554, 13, '2025-01-31 18:38:09', 'pending', 'delivered', 53, 1),
(1447127207826890, 19, '2025-02-05 17:22:12', 'pending', 'pending', 65, 2),
(1489938866503827, 13, '2025-01-31 18:37:05', 'failed', 'pending', 123, 1),
(1555756960113144, 13, '2025-01-31 20:53:03', 'pending', 'pending', 58, 1),
(3459075306726270, 19, '2025-02-05 17:21:53', 'pending', 'pending', 65, 2),
(4883428700882264, 19, '2025-02-02 15:51:23', 'pending', 'pending', 60, 1),
(4968753517827591, 13, '2025-01-31 20:06:01', 'pending', 'pending', 56, 1),
(4971891474900479, 19, '2025-02-05 17:06:15', 'pending', 'pending', 63, 1),
(5394356097029567, 19, '2025-02-05 17:25:03', 'pending', 'pending', 65, 2),
(6072095520655579, 19, '2025-02-05 17:22:16', 'pending', 'pending', 65, 2),
(6775583379340634, 19, '2025-02-05 17:22:11', 'pending', 'pending', 65, 2),
(6842520128807593, 19, '2025-02-05 17:25:19', 'pending', 'pending', 65, 2),
(7017144910904636, 19, '2025-02-05 17:12:30', 'pending', 'pending', 65, 2),
(7513515245202183, 13, '2025-01-31 18:37:54', 'paid', 'pending', 65, 1),
(7923537002054154, 19, '2025-02-05 17:23:52', 'pending', 'pending', 65, 2),
(8509932372417663, 19, '2025-02-05 17:24:33', 'pending', 'pending', 65, 2),
(8584161974057625, 19, '2025-02-05 17:23:51', 'pending', 'pending', 65, 2),
(8622450397334175, 19, '2025-02-05 17:25:48', 'pending', 'pending', 65, 2),
(9114535857368804, 19, '2025-02-05 17:22:24', 'pending', 'pending', 65, 2),
(9180640968701109, 19, '2025-02-05 17:21:50', 'pending', 'pending', 65, 2),
(9504693088570850, 19, '2025-02-05 17:17:34', 'pending', 'pending', 65, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `order_status_id` int(11) NOT NULL,
  `order_id` bigint(16) DEFAULT NULL,
  `status` enum('pending','dispatched','delivered','cancelled') DEFAULT 'pending',
  `status_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `order_cart_id` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`order_cart_id`, `order_id`, `prod_id`, `user_id`, `quantity`) VALUES
(52, 1489938866503827, 9489411, 13, 1),
(53, 1489938866503827, 1055576, 13, 3),
(55, 1179456120470554, 4642461, 13, 1),
(57, 1555756960113144, 5254070, 13, 1),
(59, 4971891474900479, 1239271, 19, 1),
(60, 4971891474900479, 6371131, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethods`
--

CREATE TABLE `paymentmethods` (
  `payment_method_id` int(11) NOT NULL,
  `payment_method_name` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paymentmethods`
--

INSERT INTO `paymentmethods` (`payment_method_id`, `payment_method_name`) VALUES
(1, 'Cash On delivery'),
(2, 'PayPal');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` bigint(16) DEFAULT NULL,
  `payment_type` enum('credit_card','cheque','vpp') NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permissions_id` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `permission_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permissions_id`, `permission_name`, `permission_path`) VALUES
(2, 'Add Categories', 'categories/addCategories.php'),
(3, 'View Categories', 'categories/viewCategories.php'),
(4, 'Add Products', 'products/addProducts.php'),
(5, 'View Products', 'products/viewProducts.php'),
(6, 'Add Country', 'country/addCountry.php'),
(7, 'View Country', 'country/viewCountry.php'),
(8, 'Add City', 'cities/addCities.php'),
(9, 'View Cities', 'cities/viewCities.php'),
(10, 'Add Size', 'size/addSize.php'),
(11, 'View Size', 'size/viewSize.php'),
(12, 'Add Color', 'color/addColor.php'),
(13, 'View Color', 'color/viewColor.php'),
(14, 'Add User', 'users/addUser.php'),
(15, 'View User', 'users/viewUser.php'),
(16, 'Add User Permission', 'users/addUserPermission.php'),
(17, 'View User Permission', 'users/viewUserPermission.php'),
(18, 'Add Permission', 'users/addPermission.php'),
(20, 'Add User Role', 'users/addUserRole.php'),
(21, 'View User Role', 'users/viewUserRole.php'),
(22, 'View Orders', 'orders/order.php'),
(23, 'Add Carousel', 'carousel/addCarousel.php'),
(24, 'View Carousel', 'carousel/viewCarousel.php'),
(25, 'View Reviews', 'reviews/viewReview.php'),
(26, 'View Credit Card', 'creditcard/viewCreditcard.php');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 1, 5),
(5, 1, 6),
(6, 1, 7),
(7, 1, 8),
(8, 1, 9),
(9, 1, 10),
(10, 1, 11),
(11, 1, 12),
(12, 1, 13),
(13, 1, 14),
(14, 1, 15),
(15, 1, 16),
(16, 1, 17),
(17, 1, 18),
(18, 1, 20),
(19, 1, 21),
(20, 1, 22),
(21, 1, 23),
(22, 1, 24),
(23, 1, 25),
(24, 1, 26),
(25, 2, 2),
(26, 2, 3),
(27, 2, 4),
(28, 2, 5),
(29, 2, 7),
(30, 2, 9),
(31, 2, 11),
(32, 2, 13),
(33, 2, 22),
(34, 3, 2),
(35, 3, 3),
(36, 3, 4),
(37, 3, 5),
(38, 3, 8),
(39, 3, 9),
(40, 3, 11),
(41, 3, 13),
(42, 3, 15),
(43, 3, 24),
(44, 3, 25),
(45, 3, 26);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` float NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `product_images` text NOT NULL,
  `p_c_n_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`, `category_id`, `stock_quantity`, `status`, `product_images`, `p_c_n_id`) VALUES
(1055576, 'Silver Men\'s Wrist Watch ', '•	Strap Color: Silver •	Case Diameter: 41–45 mm •	Glass Shape: Straight •	Glass Type: Glass •	Case Material: Metal •	Mechanism: Quartz •	Additional Feature: Licenced •	Strap Material: Metal', 16, 23, 17, 'active', '6793d376b8809.jpg,6793d376b8eb3.jpg,6793d376b966e.jpg', 56),
(1239271, 'Stolen Moment', 'A combination of spicy and deep scents that creates a sense of mysteryThe notes of violet leaf give a mossy aroma while cashmere adds muskiness', 10, 17, 15, 'active', '6793ce16d819f.jpg,6793ce16d935c.jpg,6793ce16da75d.jpg', 42),
(1635294, 'Nike Air Max Ltd 3 Men\'s Casual Shoes', 'Upper Material: Artificial Leather + Textile Persona: Cool & Comfort Sole Material: PVC Heel Size: Short heels (1–4 cm) Base Type: Flat Base', 10, 20, 17, 'active', '6793d1f1bb600.jpg,6793d1f1bbbb2.jpg,6793d1f1bc1de.jpg', 51),
(1735944, 'Mocca', 'Classic Hand made leather Wallet that is made for the perfect addition to Men\'s Accessories. Made of 100% Pure Leather.', 6, 22, 12, 'active', '6793d2a54bca3.jpg,6793d2a54c320.jpg,6793d2a54c832.jpg', 54),
(1868304, '2 in 1 Double Ended Tip Pen 24 Colors For Kids', '2 in 1 Double Ended Tip Pen 24 Colors For Kids', 4, 21, 14, 'active', '6793d23463472.jpg,6793d23463ad4.jpg,6793d23464098.jpg', 52),
(2560373, 'Beautiful Fashion Doll ', 'Elevate playtime to new heights with this beautiful fashion doll designed for your young fashion enthusiast! Dressed in the latest fashion trends, this doll exudes charm and sophistication. From her flowing hair to her chic ensemble, every detail is designed to captivate and inspire.', 5, 15, 28, 'active', '6793c521c5f6a.jpg,6793c521c6539.jpg,6793c521c6993.jpg', 38),
(4490581, 'Beekeeper Doll ', 'Meet Barbie Beekeeper, designed for the girl who loves nature, adventure, and learning about the world around her! Dressed in a cute outfit, she is ready to tend to a hive, harvest honey, or explore the wonders of the beekeeping world.', 6, 15, 20, 'active', '6793c56c84fee.jpg,6793c56c85648.jpg,6793c56c85b13.jpg', 39),
(4642461, 'Card Holder Wallet beige', 'Chic beige card holder wallet, offering a sleek design for easy access and organization.', 3, 22, 12, 'active', '6793d27dba8d8.jpg,6793d27dbaee6.jpg,6793d27dbb3e0.jpg', 53),
(5254070, 'Army Green Top Handle Hexagon Bag Back', '•	Width: 10.5 inches   •	Height: 8 inches   •	Depth: 5 inches   •	One main compartment secured by magnetic button and loop. •	One inside zipper pocket. •	Golden chain of 42 inches. •	Material: Faux leather.', 8, 18, 10, 'active', '6793cf3b8be4c.jpg,6793cf3b8c2b0.jpg,6793cf3b8c749.jpg', 45),
(5714855, '5.	Michael Knight Watch', 'Strap Color: Black  Case Diameter: 41–45 mm Mechanism: Quartz Origin: CH Strap Material: Steel Case Material: Steel', 10, 23, 18, 'active', '6793d30f48a56.jpg,6793d30f490ea.jpg,6793d30f4973b.jpg', 55),
(5813453, 'Floral Bloom', 'A fusion of floral and fruity scents complemented with deep musky and amber notes', 20, 17, 12, 'active', '6793ce5ca256b.jpg,6793ce5ca2b22.jpg,6793ce5ca3add.jpg', 43),
(6371131, 'MASCO FILE', 'The MASCO 2 Ring A4 Size Box Folder File (Green) is a practical and durable filing solution designed to organize and store A4 size documents. It features two strong metal rings that securely hold your papers in place. The folder has a compact and portable design, and the green color gives it a professional and appealing look.  The box-type design allows for easy access to your documents while keeping them organized and protected. This folder is ideal for use in offices, schools, or at home to keep important papers safe and well-maintained.', 3, 16, 25, 'active', '6793cdc679200.jpg,6793cdc67a37c.jpg,6793cdc6bf1e0.jpg', 41),
(7297982, 'Defa Lucy Fashion Doll', '•	Introducing our new doll, standing at a majestic height of 30 cm. This meticulously crafted creation features movable knees, elbows, and hands, providing an interactive and lifelike experience. Constructed from high-quality plastic, PVC, and textile materials, this doll is designed to captivate the hearts of children aged 3 and above. Rest assured, this product complies with stringent safety requirements, ensuring peace of mind for both parents and guardians.', 5, 15, 24, 'active', '6793cd0085ec5.jpg,6793cd008663f.jpg,6793cd0086b14.jpg', 40),
(7540082, '21', '', 0, NULL, 0, 'active', '67a35cab74154.', 63),
(8663289, '2.	Converse Sneakers White Flat ', 'Insole Material: Textile External Material: Textile Material: Textile Pattern: Plain Heel Type: Flat Base Type: Flat Base Lining Material: Textile', 12, 20, 17, 'active', '6793d193e4b34.jpg,6793d193e5996.jpg,6793d193e5f51.jpg', 50),
(8983895, 'Cross body pouch', '•	Width: 10 inches •	Height: 7 inches •	Depth: 3 inches •	Long adjustable strap. •	Material: Faux leather.', 10, 18, 18, 'active', '6793cfef6e836.jpg,6793cfef6ef8d.jpg,6793cfef6f505.jpg', 46),
(9489411, 'Oud ', ': A statement scent that combines the intensity of spicy oud with a lively touch of citrusy grapefruit for a powerful olfactive expression', 15, 17, 20, 'active', '6793ce92121a6.jpg,6793ce9212776.jpg,6793ce9212bcf.jpg', 44);

-- --------------------------------------------------------

--
-- Table structure for table `product_code_num`
--

CREATE TABLE `product_code_num` (
  `p_c_n_id` int(11) NOT NULL,
  `product_code` tinyint(2) NOT NULL,
  `product_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_code_num`
--

INSERT INTO `product_code_num` (`p_c_n_id`, `product_code`, `product_num`) VALUES
(56, 10, 55576),
(42, 12, 39271),
(12, 14, 90451),
(51, 16, 35294),
(54, 17, 35944),
(32, 17, 73253),
(52, 18, 68304),
(48, 20, 77760),
(57, 21, 41081),
(30, 22, 52535),
(20, 25, 46726),
(38, 25, 60373),
(60, 26, 40927),
(15, 28, 79761),
(31, 29, 80878),
(62, 31, 18350),
(19, 32, 95415),
(25, 34, 41660),
(61, 36, 79419),
(37, 37, 75676),
(29, 39, 98389),
(34, 41, 23417),
(39, 44, 90581),
(53, 46, 42461),
(26, 48, 43472),
(3, 48, 92023),
(17, 52, 20867),
(45, 52, 54070),
(22, 52, 74170),
(18, 53, 64746),
(23, 55, 72920),
(59, 56, 79904),
(55, 57, 14855),
(47, 57, 19619),
(1, 57, 31537),
(21, 57, 90886),
(43, 58, 13453),
(41, 63, 71131),
(7, 65, 32562),
(27, 66, 80166),
(14, 67, 77796),
(5, 72, 22450),
(40, 72, 97982),
(49, 74, 12027),
(6, 75, 30041),
(63, 75, 40082),
(10, 75, 45802),
(24, 75, 74160),
(58, 77, 34014),
(35, 84, 95008),
(4, 85, 14965),
(28, 86, 14143),
(50, 86, 63289),
(33, 88, 85771),
(46, 89, 83895),
(13, 91, 14633),
(36, 91, 24024),
(16, 92, 84499),
(44, 94, 89411),
(11, 95, 29777),
(2, 98, 93220),
(8, 98, 94585),
(9, 99, 30063);

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`id`, `product_id`, `color_id`) VALUES
(34, 8663289, 8),
(35, 1635294, 6),
(36, 5714855, 6),
(37, 1055576, 9);

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` int(11) NOT NULL,
  `order_id` bigint(16) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `return_type` enum('replacement','refund') NOT NULL,
  `return_reason` text DEFAULT NULL,
  `return_status` enum('pending','processed') DEFAULT 'pending',
  `return_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviews_id` int(11) NOT NULL,
  `Review` varchar(255) NOT NULL,
  `Rating` decimal(10,0) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviews_id`, `Review`, `Rating`, `Name`, `Email`, `product_id`, `user_id`) VALUES
(4, 'assafas', 2, 'huz khan', 'huzaifa@gmail.com', 5254070, 13),
(5, 'saf', 4, 'huz', 'admin@gmail.com', 1239271, 19),
(6, '125safwf', 3, 'huz', 'admin@gmail.com', 6371131, 19);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'user'),
(3, 'Sub Admin');

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE `shipment` (
  `Shipment_id` int(11) NOT NULL,
  `Shipment_price` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`Shipment_id`, `Shipment_price`) VALUES
(1, 500);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`) VALUES
(3, 'Medium'),
(4, 'Large');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(11) NOT NULL,
  `first_text` varchar(255) DEFAULT NULL,
  `second_text` varchar(255) DEFAULT NULL,
  `slider_image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `first_text`, `second_text`, `slider_image`) VALUES
(21, 'heading1', 'heading2', '67a3a2817323c.jpg'),
(22, 'heading3', 'heading4', '67a3a28bb6428.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `product_id` varchar(7) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `phone_number`, `password_hash`, `role_id`, `user_email`, `country_id`, `city_id`) VALUES
(13, 'huz', 'khan', 'huzaifak', '4333333333335', '$2y$10$/lxU8t4.C0vkNt0FV4p0HO8OUYf6R4xZJfEUIuUxL2ycttj5DPXq6', 2, 'huzaifa@gmail.com', 6, 7),
(14, 'huz', 'khan', 'huzaifa', '1212132143243', '$2y$10$AW4Qg3aeaA1OVmj71PtrKOa3LpSXIAi/rooJC.vpZYdFOTIOioAzu', 2, 'cortexgame77@gmail.com', 6, 7),
(19, 'ADMIN', 'Admin', 'Admin', '12345678900', '$2y$10$RTeYLdK9o3Vp60rXT5zXeeD4TQP.JG5Ok4KYBJiUwX0u0UoRfaGLG', 1, 'admin@gmail.com', 6, 7),
(21, 'Sub', 'Admin', 'Sub Admin', '12345678904', '$2y$10$6dpAbDAE1oTyDD5J.SoBv.oX173Yd46HQhn7u1B5MyFE0AK8atimK', 3, 'subadmin@gmail.com', 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `address_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`address_id`, `address`, `user_id`) VALUES
(6, '359 Randall Mill Street Kernersville, NC 27284', 13),
(7, 'street no: 33 house no: 445', 19);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD PRIMARY KEY (`creditCardId`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `delete_order`
--
ALTER TABLE `delete_order`
  ADD PRIMARY KEY (`delete_order_id`),
  ADD KEY `prod_id` (`prod_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `feedback_ibfk_1` (`customer_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `orderitems_ibfk_2` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`order_status_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`order_cart_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `prod_id` (`prod_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permissions_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_ibfk_1` (`category_id`),
  ADD KEY `p_c_n_id` (`p_c_n_id`);

--
-- Indexes for table `product_code_num`
--
ALTER TABLE `product_code_num`
  ADD PRIMARY KEY (`p_c_n_id`),
  ADD UNIQUE KEY `product_code` (`product_code`,`product_num`);

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `returns_ibfk_2` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviews_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`Shipment_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `creditcard`
--
ALTER TABLE `creditcard`
  MODIFY `creditCardId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delete_order`
--
ALTER TABLE `delete_order`
  MODIFY `delete_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `order_cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permissions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_code_num`
--
ALTER TABLE `product_code_num`
  MODIFY `p_c_n_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviews_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipment`
--
ALTER TABLE `shipment`
  MODIFY `Shipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `creditcard`
--
ALTER TABLE `creditcard`
  ADD CONSTRAINT `creditcard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delete_order`
--
ALTER TABLE `delete_order`
  ADD CONSTRAINT `delete_order_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delete_order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delete_order_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitems_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`payment_method_id`) REFERENCES `paymentmethods` (`payment_method_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD CONSTRAINT `orderstatus_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_3` FOREIGN KEY (`prod_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permissions_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_6` FOREIGN KEY (`p_c_n_id`) REFERENCES `product_code_num` (`p_c_n_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_colors_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_sizes_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`) ON DELETE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `returns_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
