--
-- Dumping data for table `tl_saas_payment_methods`
--

INSERT INTO `tl_saas_payment_methods` (`id`, `name`, `logo`, `docs`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Paypal', NULL, NULL, 1, '2023-10-21 11:31:53', '2023-10-21 11:31:53'),
(3, 'Stripe', NULL, NULL, 1, '2023-10-21 11:31:54', '2023-10-21 11:31:54'),
(4, 'Paddle', NULL, NULL, 1, '2023-10-21 11:32:08', '2023-10-21 11:32:08'),
(5, 'Sslcommerz', NULL, NULL, 1, '2023-10-21 11:32:08', '2023-10-21 11:32:08'),
(6, 'Paystack', NULL, NULL, 1, '2023-10-21 11:32:08', '2023-10-21 11:32:08'),
(7, 'Razorpay', NULL, NULL, 1, '2023-10-21 11:32:02', '2023-10-21 11:32:02'),
(8, 'Mollie', NULL, NULL, 1, '2023-10-21 11:32:12', '2023-10-21 11:32:12'),
(10, 'Gpay', NULL, NULL, 1, '2023-10-21 11:32:00', '2023-10-21 11:32:00'),
(15, 'Paymob', NULL, NULL, 1, '2023-10-21 11:32:00', '2023-10-21 11:32:00'),
(16, 'Mercado Pago', NULL, NULL, 1, '2023-10-21 11:32:00', '2023-10-21 11:32:00');


INSERT INTO `tl_saas_payment_method_has_settings` (`id`, `payment_method_id`, `key_name`, `key_value`, `created_at`, `updated_at`) VALUES
(124, 10, 'gpay_currency', 'USD', '2023-09-17 12:24:36', '2023-11-08 15:03:07'),
(120, 8, 'mollie_currency', 'USD', '2023-09-17 12:09:19', '2023-11-08 15:02:56'),
(129, 2, 'paypal_currency', 'USD', '2023-09-18 04:12:24', '2023-09-18 04:13:08'),
(130, 3, 'stripe_currency', 'USD', '2023-09-18 04:12:24', '2023-09-18 04:13:23'),
(131, 4, 'paddle_currency', 'USD', '2023-09-18 04:12:24', '2023-11-08 15:00:50'),
(134, 7, 'razorpay_currency', 'USD', '2023-09-18 04:12:24', '2023-11-08 15:02:43');