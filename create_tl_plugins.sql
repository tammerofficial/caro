CREATE TABLE `tl_plugins` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `author` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `version` varchar(11) NOT NULL DEFAULT '1',
  `unique_indentifier` text NOT NULL,
  `is_activated` int(10) NOT NULL,
  `namespace` varchar(150) NOT NULL,
  `url` text DEFAULT NULL,
  `type` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tl_plugins`
--

INSERT INTO `tl_plugins` (`id`, `name`, `location`, `author`, `description`, `version`, `unique_indentifier`, `is_activated`, `namespace`, `url`, `type`, `created_at`, `updated_at`) VALUES
(17, 'TL Commerce Core', 'tlecommercecore', 'Themelooks', 'Core plugin of Tl-commerce', '1.0.1', 'sfjhsgdfjkshdf', 1, 'Plugin\\TlcommerceCore\\', 'http://www.themelooks.com/', 'tlcommerce', '2022-06-23 00:12:52', '2023-06-25 04:28:08'),
(21, 'Coupon', 'coupon', 'Themelooks', 'Coupon plugin of Tl-commerce', '1.0.0', 'qweeqeqw', 1, 'Plugin\\Coupon\\', 'http://www.themelooks.com/', 'tlcommerce', '2022-07-31 21:40:52', '2023-06-25 04:25:56'),
(22, 'Flash Deal', 'flashdeal', 'Themelooks', 'Flash Deal plugin of Tl-commerce', '1.0.0', 'qweeqeqw', 1, 'Plugin\\Flashdeal\\', 'http://www.themelooks.com/', 'tlcommerce', '2022-07-31 21:41:21', '2023-06-25 04:30:05'),
(23, 'Pickup Point', 'pickuppoint', 'Themelooks', 'Pickup Point plugin of Tl-commerce', '1.0.0', 'sfjhsgdfjkshdf', 1, 'Plugin\\PickupPoint\\', 'http://www.themelooks.com/', 'tlcommerce', '2022-07-31 22:15:40', '2023-06-25 04:25:56'),
(24, 'Wallet', 'wallet', 'Themelooks', 'Wallet plugin of Tl-commerce', '1.0.1', 'sfjhsgdfjkshdf', 1, 'Plugin\\Wallet\\', 'http://www.themelooks.com/', 'tlcommerce', '2022-08-02 03:01:56', '2023-06-25 04:25:56'),
(26, 'Refunds', 'refund', 'Themelooks', 'Refunds plugin of Tl-commerce', '1.0.0', 'wrwerwer', 1, 'Plugin\\Refund\\', 'http://www.themelooks.com/', 'tlcommerce', '2022-08-03 00:12:15', '2023-06-25 04:25:56'),
(28, '3rd Party Carrier', 'carrier', 'Themelooks', '3rd party plugin of Tl-commerce', '1.0.0', '54646546', 1, 'Plugin\\Carrier\\', 'http://www.themelooks.com/', 'tlcommerce', '2022-09-25 02:24:13', '2023-06-25 04:25:56'),
(31, 'Saas', 'saas', 'Themelooks', 'Saas Plugin for Tl-commerce', '1.0.2', 'sdefd', 1, 'Plugin\\Saas\\', 'http://www.themelooks.com/', 'saas', '2023-07-09 10:26:21', '2023-07-09 10:26:21'),
(34, 'Page Builder', 'pagebuilder', 'Themelooks', 'Page Builder Plugin for Tl-saas', '1.0.1', 'sdefd02', 1, 'Plugin\\PageBuilder\\', 'http://www.themelooks.com/', 'saas', '2023-07-09 10:26:21', '2023-10-19 04:00:27'),
(43, 'Tlcommerce Page Builder', 'tlcommerce-pagebuilder', 'Themelooks', 'Page Builder Plugin for Tlcommerce', '1.0.1', 'dHnrtnr8OUZ5c5h', 1, 'Plugin\\TlPageBuilder\\', 'http://www.themelooks.com/', 'tlcommerce', '2023-10-22 10:09:41', '2023-10-22 10:09:41'),
(44, 'Multivendor', 'multivendor', 'Themelooks', 'Multivendor plugin of Tl-commerce', '1.0.0', '46642-B4D26-0AC23-A0AF5-706A0-70', 1, 'Plugin\\Multivendor\\', 'http://www.themelooks.com/', 'tlcommerce', '2023-06-22 02:10:10', '2023-07-22 23:42:52'),
(45, 'Support Ticket', 'support-ticket', 'Themelooks', 'Support Ticket Plugin', '1.0.1', '4785sdfe545', 1, 'Plugin\\SupportTicket\\', 'http://www.themelooks.com/', 'saas', '2023-06-22 02:10:10', '2023-07-22 23:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `tl_saas_accounts`
--

