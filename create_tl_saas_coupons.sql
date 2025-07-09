CREATE TABLE `tl_saas_coupons` (
  `id` int(11) NOT NULL,
  `coupon_name` varchar(150) DEFAULT NULL,
  `coupon_code` varchar(150) DEFAULT NULL,
  `coupon_type` varchar(150) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `valid_for_days` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `total_used` int(11) DEFAULT 0,
  `coupon_usable_times` int(11) NOT NULL DEFAULT 1,
  `valid_till` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tl_saas_coupons_of_packages`
--

