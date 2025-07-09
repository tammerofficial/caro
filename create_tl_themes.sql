CREATE TABLE `tl_themes` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `location` varchar(200) NOT NULL,
  `author` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `version` varchar(150) NOT NULL DEFAULT '1.0',
  `unique_indentifier` text NOT NULL,
  `is_activated` int(11) NOT NULL DEFAULT 1,
  `namespace` varchar(150) NOT NULL,
  `url` text DEFAULT NULL,
  `type` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tl_themes`
--

INSERT INTO `tl_themes` (`id`, `name`, `location`, `author`, `description`, `version`, `unique_indentifier`, `is_activated`, `namespace`, `url`, `type`, `created_at`, `updated_at`) VALUES
(15, 'default', 'default', 'Themelooks', 'The Default theme of tl-saas', '1.0.0', 'B5F46-A30FF-2F518-7B735-5FA13-60', 1, 'Theme\\Default\\', 'http://www.themelooks.com/', 'saas', '2022-08-07 22:11:18', '2023-11-10 04:20:33'),
(16, 'TL Commerce', 'tlcommerce', 'Themelooks', 'The Default theme of TLCommerce Store', '1.0.2', 'B5F46-A30FF-2F518-7B735-5FA13-60', 1, 'Theme\\TLCommerce\\', 'http://www.themelooks.com/', 'store', '2022-08-07 22:11:18', '2023-11-10 04:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `tl_theme_default_home_page_sections`
--

