CREATE TABLE `tl_saas_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `package_id` int(11) DEFAULT NULL,
  `package_plan` int(11) DEFAULT NULL,
  `membership_type` varchar(150) DEFAULT NULL,
  `store_name` varchar(150) DEFAULT NULL,
  `valid_till` date DEFAULT NULL,
  `is_notified` int(11) DEFAULT NULL,
  `tenant_id` varchar(255) DEFAULT NULL,
  `renewed` int(11) DEFAULT NULL,
  `is_db_created` int(11) NOT NULL DEFAULT 0,
  `is_db_updated` int(11) NOT NULL DEFAULT 0,
  `is_plugin_db_updated` int(11) NOT NULL DEFAULT 1,
  `is_system_db_updated` int(11) NOT NULL DEFAULT 1,
  `initial_language` int(11) DEFAULT NULL,
  `initial_currency` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tl_saas_coupons`
--

