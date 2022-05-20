-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2021 at 07:42 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minelab`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `access`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '5ff1c3531ed3f1609679699.jpg', NULL, '$2y$10$Z7ifEDvfu5QNI0HpDI1EeuxtokN0BBrQ75jariAYOFGuwKZ2w0iOO', NULL, '2021-01-04 03:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `method_code` int(10) UNSIGNED NOT NULL,
  `is_payment` tinyint(1) NOT NULL DEFAULT 0,
  `amount` decimal(18,8) NOT NULL,
  `method_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge` decimal(18,8) NOT NULL,
  `rate` decimal(18,8) NOT NULL,
  `final_amo` decimal(18,8) DEFAULT 0.00000000,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `try` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `admin_feedback` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_templates`
--

CREATE TABLE `email_sms_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subj` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcodes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_status` tinyint(4) NOT NULL DEFAULT 1,
  `sms_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_sms_templates`
--

INSERT INTO `email_sms_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(1, 'PASS_RESET_CODE', 'Password Reset', 'Password Reset', '<div>We have received a request to reset the password for your account on <b>{{time}} .<br></b></div><div>Requested From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div><div><br></div><br><div><div><div>Your account recovery code is:&nbsp;&nbsp; <font size=\"6\"><b>{{code}}</b></font></div><div><br></div></div></div><div><br></div><div><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><br>', 'Your account recovery code is: {{code}}', ' {\"code\":\"Password Reset Code\",\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2021-01-06 00:49:06'),
(2, 'PASS_RESET_DONE', 'Password Reset Confirmation', 'You have Reset your password', '<div><p>\r\n    You have successfully reset your password.</p><p>You changed from&nbsp; IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}}&nbsp;</b> on <b>{{time}}</b></p><p><b><br></b></p><p><font color=\"#FF0000\"><b>If you did not changed that, Please contact with us as soon as possible.</b></font><br></p></div>', 'Your password has been changed successfully', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-07 10:23:47'),
(3, 'EVER_CODE', 'Email Verification', 'Please verify your email address', '<div><br></div><div>Thanks For join with us. <br></div><div>Please use below code to verify your email address.<br></div><div><br></div><div>Your email verification code is:<font size=\"6\"><b> {{code}}</b></font></div>', 'Your email verification code is: {{code}}', '{\"code\":\"Verification code\"}', 1, 1, '2019-09-24 23:04:05', '2021-01-03 23:35:10'),
(4, 'SVER_CODE', 'SMS Verification ', 'Please verify your phone', 'Your phone verification code is: {{code}}', 'Your phone verification code is: {{code}}', '{\"code\":\"Verification code\"}', 0, 1, '2019-09-24 23:04:05', '2020-03-08 01:28:52'),
(5, '2FA_ENABLE', 'Google Two Factor - Enable', 'Google Two Factor Authentication is now  Enabled for Your Account', '<div>You just enabled Google Two Factor Authentication for Your Account.</div><div><br></div><div>Enabled at <b>{{time}} </b>From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div>', 'Your verification code is: {{code}}', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-08 01:42:59'),
(6, '2FA_DISABLE', 'Google Two Factor Disable', 'Google Two Factor Authentication is now  Disabled for Your Account', '<div>You just Disabled Google Two Factor Authentication for Your Account.</div><div><br></div><div>Disabled at <b>{{time}} </b>From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div>', 'Google two factor verification is disabled', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-08 01:43:46'),
(16, 'ADMIN_SUPPORT_REPLY', 'Support Ticket Reply ', 'Reply Support Ticket', '<div><p><span style=\"font-size: 11pt;\" data-mce-style=\"font-size: 11pt;\"><strong>A member from our support team has replied to the following ticket:</strong></span></p><p><b><span style=\"font-size: 11pt;\" data-mce-style=\"font-size: 11pt;\"><strong><br></strong></span></b></p><p><b>[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</b></p><p>----------------------------------------------</p><p>Here is the reply : <br></p><p> {{reply}}<br></p></div><div><br></div>', '{{subject}}\r\n\r\n{{reply}}\r\n\r\n\r\nClick here to reply:  {{link}}', '{\"ticket_id\":\"Support Ticket ID\", \"ticket_subject\":\"Subject Of Support Ticket\", \"reply\":\"Reply from Staff/Admin\",\"link\":\"Ticket URL For relpy\"}', 1, 1, '2020-06-08 18:00:00', '2020-05-04 02:24:40'),
(206, 'DEPOSIT_COMPLETE', 'Automated Deposit - Successful', 'Deposit Completed Successfully', '<div>Your deposit of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>has been completed Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#000000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br><br></div>', '{{amount}} {{currrency}} Deposit successfully by {{gateway_name}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2020-06-24 18:00:00', '2020-11-17 03:10:00'),
(207, 'DEPOSIT_REQUEST', 'Manual Deposit - User Requested', 'Deposit Request Submitted Successfully', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>submitted successfully<b> .<br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br></div>', '{{amount}} Deposit requested by {{method}}. Charge: {{charge}} . Trx: {{trx}}\r\n', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\"}', 1, 1, '2020-05-31 18:00:00', '2020-06-01 18:00:00'),
(208, 'DEPOSIT_APPROVE', 'Manual Deposit - Admin Approved', 'Your Deposit is Approved', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>is Approved .<b><br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br></div>', 'Admin Approve Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}} transaction : {{transaction}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2020-06-16 18:00:00', '2020-06-14 18:00:00'),
(209, 'DEPOSIT_REJECT', 'Manual Deposit - Admin Rejected', 'Your Deposit Request is Rejected', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} has been rejected</b>.<b><br></b></div><br><div>Transaction Number was : {{trx}}</div><div><br></div><div>if you have any query, feel free to contact us.<br></div><br><div><br><br></div>\r\n\r\n\r\n\r\n{{rejection_message}}', 'Admin Rejected Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}}\r\n\r\n{{rejection_message}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\",\"rejection_message\":\"Rejection message\"}', 1, 1, '2020-06-09 18:00:00', '2020-06-14 18:00:00'),
(210, 'WITHDRAW_REQUEST', 'Withdraw  - User Requested', 'Withdraw Request Submitted Successfully', '<div>Your withdraw request of <b>{{amount}}&nbsp;</b><span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{coin_code}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{coin_code}}</span><b>&nbsp;</b>wallet&nbsp;has been submitted Successfully.<b><br></b></div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}}&nbsp;</b></font><span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap;\">{{coin_code}}</span></div><div><br></div><div><br><br><br><br></div>', '{{amount}} {{coin_code}} withdraw requested by {{wallet}}.  Trx: {{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\", \"coin_code\":\"Miner Coin Code\", \"wallet\":\"User Crypto Wallet Address\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2020-06-07 18:00:00', '2021-03-24 23:43:01'),
(211, 'WITHDRAW_REJECT', 'Withdraw - Admin Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', '<div>Your withdraw request of {{amount}} {{coin_code}}&nbsp; via&nbsp; {{coin_code}} wallet&nbsp;has been Rejected.<br></div><div><br></div><div>Details of your withdraw:<br></div><div><br></div><div>Amount : {{amount}} {{coin_code}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div>----</div><div><br></div><div> {{amount}} {{coin_code}} has been refunded to your account</div><div>-----</div><div><br></div><div>Details of Rejection :</div><div>{{admin_details}}</div><div><br></div><div><br><br><br><br><br><br></div>', 'Admin Rejected Your {{amount}} {{coin_code}} withdraw request. Transaction {{transaction}}', '{\"trx\":\"Transaction Number\",\"wallet\":\"User Crypto Wallet Address\",\"coin_code\":\"Coin Code\",\"amount\":\"Request Amount By user\",\"admin_details\":\"Details Provided By Admin\"}', 1, 1, '2020-06-09 18:00:00', '2021-03-24 23:56:06'),
(212, 'WITHDRAW_APPROVE', 'Withdraw - Admin  Approved', 'Withdraw Request has been Processed and your money is sent', '<div>Your withdraw request of <b>{{amount}} {{coin_code}}</b>&nbsp; via&nbsp; <b>{{wallet}} </b>has been Processed Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your withdraw:<br></b></div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div>-----</div><div><br></div><div><font size=\"4\">Details of Processed Payment :</font></div><div><font size=\"4\"><b>{{admin_details}}</b></font></div><div><br></div><div><br><br><br><br><br></div>', 'Admin Approve Your {{amount}} {{coin_code}} withdraw request by {{wallet}}. Transaction {{transaction}}', '{\"trx\":\"Transaction Number\",\"wallet\":\"User Crypto Wallet Address\",\"coin_code\":\"Coin Code\",\"amount\":\"Request Amount By user\",\"admin_details\":\"Details Provided By Admin\"}', 1, 1, '2020-06-10 18:00:00', '2021-03-25 00:00:21'),
(215, 'BAL_ADD', 'Balance Add by Admin', 'Your Account has been Credited', '<div>{{amount}} {{currency}} has been added to your account .</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div>Your Current Balance is : <font size=\"3\"><b>{{post_balance}}&nbsp; {{currency}}&nbsp;</b></font>', '{{amount}} {{currency}} credited in your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2019-09-14 19:14:22', '2021-01-06 00:46:18'),
(216, 'BAL_SUB', 'Balance Subtracted by Admin', 'Your Account has been Debited', '<div>{{amount}} {{currency}} has been subtracted from your account .</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div>Your Current Balance is : <font size=\"3\"><b>{{post_balance}}&nbsp; {{currency}}</b></font>', '{{amount}} {{currency}} debited from your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2019-09-14 19:14:22', '2019-11-10 09:07:12'),
(217, 'PAYMENT_VIA_USER_BALANCE', 'Payment Via User Balance', 'Plan Purchased Successfully', '<div><div>You have successfully purchased the plan: {{plan_title}}.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Payment:<br></span></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Paid via :&nbsp; {{method_name}}</div><div>Order ID : {{order_id}}</div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{currency}}</span></font></div><div><br></div></div>', 'You have successfully purchased the plan: {{plan_title}}.\r\nDetails of your Payment:\r\nAmount : {{amount}} {{currency}}\r\nPaid via :  {{method_name}}\r\nOrder ID : {{order_id}}\r\nYour current Balance is {{post_balance}} {{currency}}', '{\"order_id\":\"Transaction Number\",\"plan_title\":\"Plan Title\",\"amount\":\"Plan Price\",\"currency\":\"Site Currency\",\"method_name\":\"Payment Method Name\",\"method_currency\":\"Payment Method Currency\", \"post_balance\":\"User Blance After The Transaction\"}', 1, 1, NULL, '2021-03-10 05:53:17'),
(218, 'RETURN_AMOUNT_PER_DAY', 'Daily Return Amount For Purchased Plan', 'Daily Return Amount For Purchased Plan', '<div>You have got {{amount}} {{coin_code}} as The Return Amount Per Day For The Plan {{plan_title}}</div><div><br></div><div>Transaction ID : {{trx}}</div>', 'You have got {{amount}} {{coin_code}} as The Return Amount Per Day For The Plan {{plan_title}}.\r\nTransaction ID : {{trx}}\r\nYour current Balance is {{post_balance}} {{coin_code}}', '{\"plan_title\":\"Plan Title\", \"wallet\":\"User Wallet Address\",\"trx\":\"Transaction Number\", \"amount\":\"Return Amount Per Day\", \"coin_code\":\"Miner Coin Code\", \"post_balance\": \"User Crypto Wallet Balance \"}', 1, 1, NULL, '2021-03-24 13:27:58'),
(219, 'PAYMENT_COMPLETE', 'Payment Via Automatic Gateway', 'Payment Completed Successfully', 'Your Payment For Buying Our Plan {{plan_title}} Has been paid successfully.&nbsp;<br>Amount: {{amount}}&nbsp;{{currency}}<br>Charge: {{charge}}&nbsp;{{currency}}<div>Payment Via:&nbsp;{{method_name}}</div>', NULL, '{\"plan_title\":\"Plan Title\",\"order_id\":\"Transaction Number\",\"amount\":\"Plan Price\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Payment Method Name\",\"method_currency\":\"Payment Method Currency\",\"method_amount\":\"Payment Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, NULL, '2021-03-24 23:34:55'),
(220, 'PAYMENT_APPROVE', 'Payment Approval After Manual Payment', 'Manual Payment Approval', NULL, NULL, '{\"plan_title\":\"Plan Title\",\"order_id\":\"Transaction Number\",\"amount\":\"Plan Price\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Payment Method Name\",\"method_currency\":\"Payment Method Currency\",\"method_amount\":\"Payment Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\r\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\r\n<div class=\"g-recaptcha\" data-sitekey=\"{{sitekey}}\" data-callback=\"verifyCaptcha\"></div>\r\n<div id=\"g-recaptcha-error\"></div>', '{\"sitekey\":{\"title\":\"Site Key\",\"value\":\"---------------------------------\"}}', 'recaptcha.png', 0, NULL, '2019-10-18 23:16:05', '2021-04-04 08:29:33'),
(3, 'custom-captcha', 'Custom Captcha', 'Just Put Any Random String', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 1, NULL, '2019-10-18 23:16:05', '2021-04-04 07:33:20'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google-analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\r\n                <script>\r\n                  window.dataLayer = window.dataLayer || [];\r\n                  function gtag(){dataLayer.push(arguments);}\r\n                  gtag(\"js\", new Date());\r\n                \r\n                  gtag(\"config\", \"{{app_key}}\");\r\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"-------------------------------------\"}}', 'ganalytics.png', 0, NULL, NULL, '2021-04-04 08:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"admin\",\"blog\",\"Bitcoin\",\"Ethereum\",\"Tether\",\"Binance Coin\",\"Cardano\",\"Polkadot\",\"XRP\",\"USD Coin\",\"Filecoin\",\"Klaytn\",\"Elrond\",\"user\",\"payment\",\"coin\",\"litecoin\",\"dogi\",\"sales\",\"report\"],\"description\":\"MineLab is a site built for Cryptocurrency, Initial Coin Offerings, and Mining. It will grow beyond our imagination- and Minelab is built to be ready for whatever mining throws.\",\"social_title\":\"MineLab\",\"social_description\":\"MineLab is an integral part of the cryptocurrency miner space. MineLab is a site built for Cryptocurrency, Initial Coin Offerings, and Mining. The MineLab allows you to instantly switch what you are mining, review earnings, withdraw and receive from the wallets, and much more.\",\"image\":\"605f0536b885d1616839990.png\"}', '2020-07-04 23:42:52', '2021-04-04 08:31:12'),
(24, 'about.content', '{\"has_image\":\"1\",\"heading\":\"About MineLab\",\"paragraph\":\"MineLab is one of the leading cryptocurrency mining platforms, offering cryptocurrency mining capacities in every range - for newcomers. Our mission is to make acquiring cryptocurrencies easy and fast for everyone.\",\"about_image\":\"6059bc7e057951616493694.png\"}', '2020-10-28 00:51:20', '2021-04-05 02:51:41'),
(25, 'blog.content', '{\"heading\":\"See Our Latest Blogs\",\"paragraph\":\"See Our Latest Blogs section to get recent blog posts from this site.\"}', '2020-10-28 00:51:34', '2021-03-27 11:29:00'),
(26, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Should You Invest In Stocks Or Bitcoin?\",\"description\":\"<div><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\">It\\r\\n is a long established fact that a reader will be distracted by the \\r\\nreadable content of a page when looking at its layout. The point of \\r\\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \\r\\nletters, as opposed to using \'Content here, content here\', making it \\r\\nlook like readable English. Many desktop publishing packages and web \\r\\npage editors now use Lorem Ipsum as their default model text, and a \\r\\nsearch for \'lorem ipsum\' will uncover many web sites still in their \\r\\ninfancy. Various versions have evolved over the years, sometimes by \\r\\naccident, sometimes on purpose (injected humour and the like).\\u00a0It is a \\r\\nlong established fact that a reader will be distracted by the readable \\r\\ncontent of a page when looking at its layout. The point of using Lorem \\r\\nIpsum is that it has a more-or-less normal distribution of letters, as \\r\\nopposed to using \'Content here, content here\', making it look like \\r\\nreadable English. Many desktop publishing packages and web page editors \\r\\nnow use Lorem Ipsum as their default model text, and a search for \'lorem\\r\\n ipsum\' will uncover many web sites still in their infancy. Various \\r\\nversions have evolved over the years, sometimes by accident, sometimes \\r\\non purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\">It\\r\\n is a long established fact that a reader will be distracted by the \\r\\nreadable content of a page when looking at its layout. The point of \\r\\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \\r\\nletters, as opposed to using \'Content here, content here\', making it \\r\\nlook like readable English. Many desktop publishing packages and web \\r\\npage editors now use Lorem Ipsum as their default model text, and a \\r\\nsearch for \'lorem ipsum\' will uncover many web sites still in their \\r\\ninfancy. Various versions have evolved over the years, sometimes by \\r\\naccident, sometimes on purpose (injected humour and the like).\\u00a0It is a \\r\\nlong established fact that a reader will be distracted by the readable \\r\\ncontent of a page when looking at its layout. The point of using Lorem \\r\\nIpsum is that it has a more-or-less normal distribution of letters, as \\r\\nopposed to using \'Content here, content here\', making it look like \\r\\nreadable English. Many desktop publishing packages and web page editors \\r\\nnow use Lorem Ipsum as their default model text, and a search for \'lorem\\r\\n ipsum\' will uncover many web sites still in their infancy. Various \\r\\nversions have evolved over the years, sometimes by accident, sometimes \\r\\non purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\">It\\r\\n is a long established fact that a reader will be distracted by the \\r\\nreadable content of a page when looking at its layout. The point of \\r\\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \\r\\nletters, as opposed to using \'Content here, content here\', making it \\r\\nlook like readable English. Many desktop publishing packages and web \\r\\npage editors now use Lorem Ipsum as their default model text, and a \\r\\nsearch for \'lorem ipsum\' will uncover many web sites still in their \\r\\ninfancy. Various versions have evolved over the years, sometimes by \\r\\naccident, sometimes on purpose (injected humour and the like).\\u00a0It is a \\r\\nlong established fact that a reader will be distracted by the readable \\r\\ncontent of a page when looking at its layout. The point of using Lorem \\r\\nIpsum is that it has a more-or-less normal distribution of letters, as \\r\\nopposed to using \'Content here, content here\', making it look like \\r\\nreadable English. Many desktop publishing packages and web page editors \\r\\nnow use Lorem Ipsum as their default model text, and a search for \'lorem\\r\\n ipsum\' will uncover many web sites still in their infancy. Various \\r\\nversions have evolved over the years, sometimes by accident, sometimes \\r\\non purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;font-size:16px;font-style:normal;font-weight:400;letter-spacing:normal;text-align:left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;float:none;\\\"><\\/span><\\/div><br \\/>\",\"blog_image\":\"6043183f22a5d1615009855.jpg\"}', '2020-10-28 00:57:19', '2021-04-06 07:23:05'),
(27, 'contact_us.content', '{\"has_image\":\"1\",\"heading\":\"Contact With Us\",\"email_address\":\"minelab@example.com\",\"contact_number\":\"+ 001 2166 5645\",\"contact_details\":\"MineLab Head Office, ABC 125666, USA\",\"image\":\"606c0eb443bbf1617694388.png\"}', '2020-10-28 00:59:19', '2021-04-06 01:55:33'),
(30, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Tax Rules for Buying and Selling Crypto\",\"description\":\"<div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div>\",\"blog_image\":\"604318ddd3f191615010013.jpg\"}', '2020-10-31 00:39:05', '2021-04-06 07:26:07'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}', '2020-11-12 04:07:30', '2021-03-06 03:09:36'),
(35, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"ACHIVE THE BEST HASHRATE\",\"paragraph\":\"MineLab is a cryptocurrency mining application designed to be a highly secure platform design for future miners. Start mining and achieve the highest level of Hashrate.\",\"button_one\":\"Start Mining\",\"button_one_link\":\"plans\",\"banner_image\":\"6040cb7e059681614859134.jpg\"}', '2021-03-04 05:58:54', '2021-04-06 23:57:08'),
(36, 'how_work.content', '{\"heading\":\"HOW MINELAB WORKS?\",\"paragraph\":\"Learn about our work process. You need to follow the steps below to start your first mining.\"}', '2021-03-04 05:59:16', '2021-04-04 23:43:29'),
(37, 'how_work.element', '{\"title\":\"Create An Account\",\"description\":\"Create a user profile for yourself using the register option and get ready to mining.\",\"icon\":\"<i class=\\\"las la-user-edit\\\"><\\/i>\"}', '2021-03-04 05:59:54', '2021-04-04 23:53:12'),
(38, 'how_work.element', '{\"title\":\"Choose Plans\",\"description\":\"Top up your balance and buy plans at the most reasonable price.\",\"icon\":\"<i class=\\\"fas fa-clipboard-list\\\"><\\/i>\"}', '2021-03-04 06:00:57', '2021-04-05 02:40:40'),
(42, 'about.element', '{\"title\":\"Multiple Cryptocurrencies\",\"description\":\"We are offering 10+ minable cryptocurrencies.\",\"icon\":\"<i class=\\\"fas fa-coins\\\"><\\/i>\"}', '2021-03-04 06:04:56', '2021-04-05 04:19:22'),
(43, 'about.element', '{\"title\":\"World Wide Service\",\"description\":\"Servicing over 2000 customers from 100+ countries\",\"icon\":\"<i class=\\\"fas fa-globe\\\"><\\/i>\"}', '2021-03-04 06:06:40', '2021-04-05 04:17:11'),
(44, 'faq.element', '{\"question\":\"What is Cryptocurrency?\",\"answer\":\"Cryptocurrency is decentralized digital money, based on blockchain technology. You may be familiar with the most popular versions, Bitcoin and Ethereum, but there are more than 5,000 different cryptocurrencies in circulation, according to CoinLore.\"}', '2021-03-04 06:07:42', '2021-04-05 04:51:22'),
(45, 'faq.element', '{\"question\":\"What is crypto currency mining?\",\"answer\":\"In a nutshell, cryptocurrency mining is a term that refers to the process of gathering cryptocurrency as a reward for work that you complete.\"}', '2021-03-04 06:07:55', '2021-04-05 04:52:58'),
(46, 'faq.element', '{\"question\":\"Why do people crypto mine?\",\"answer\":\"For some, they\\u2019re looking for another source of income. For others, it\\u2019s about gaining greater financial freedom without governments or banks butting in. But whatever the reason, cryptocurrencies are a growing area of interest for technophiles, investors, and cybercriminals alike.\"}', '2021-03-04 06:08:13', '2021-04-05 04:53:37'),
(47, 'faq.element', '{\"question\":\"How can withdraw my earning balance?\",\"answer\":\"Miners can withdraw their mining coins. We processed withdrawals manually so it will take more time.\"}', '2021-03-04 06:08:32', '2021-04-05 04:55:32'),
(50, 'subscribe.content', '{\"heading\":\"Subscribe to Our Newsletter to Get All Latest News\"}', '2021-03-04 06:09:17', '2021-04-05 04:58:07'),
(51, 'transaction.content', '{\"heading\":\"Transaction log\",\"paragraph\":\"Our Latest Deposits And Withdraws\"}', '2021-03-04 06:09:30', '2021-03-27 11:15:53'),
(52, 'service.content', '{\"heading\":\"OUR SERVICES\",\"paragraph\":\"We provide the best services to our miners, be connected with us, and get profited.\"}', '2021-03-04 06:10:07', '2021-03-27 13:12:19'),
(53, 'service.element', '{\"icon\":\"<i class=\\\"fab fa-accusoft\\\"><\\/i>\",\"title\":\"Data Protection\",\"description\":\"We constantly work on improving our system and the level of our security to minimize any  risks.\"}', '2021-03-04 06:11:05', '2021-03-27 11:27:02'),
(55, 'service.element', '{\"icon\":\"<i class=\\\"fab fa-bitcoin\\\"><\\/i>\",\"title\":\"Cloud Mining\",\"description\":\"We provide the best cloud mining service and give rewards to our miners on a daily basis.\"}', '2021-03-04 06:12:20', '2021-04-05 04:32:06'),
(57, 'service.element', '{\"icon\":\"<i class=\\\"las la-chart-area\\\"><\\/i>\",\"title\":\"Detailed Statistics\",\"description\":\"We make detailed statistics of your transaction, also you will get all the mining logs.\"}', '2021-03-04 06:26:04', '2021-04-05 04:25:56'),
(58, 'service.element', '{\"icon\":\"<i class=\\\"las la-money-bill-wave-alt\\\"><\\/i>\",\"title\":\"Easy Withdrawal\",\"description\":\"Our withdrawal process takes only 24 hours. We are highly transparent about transactions.\"}', '2021-03-04 06:26:37', '2021-04-05 04:23:58'),
(59, 'service.element', '{\"icon\":\"<i class=\\\"fab fa-connectdevelop\\\"><\\/i>\",\"title\":\"Instant Connect\",\"description\":\"Our team of experts always available and feels happy to help you. Please mail if you have issue\"}', '2021-03-04 06:27:05', '2021-03-27 11:27:27'),
(60, 'service.element', '{\"icon\":\"<i class=\\\"las la-headset\\\"><\\/i>\",\"title\":\"24\\/7 Support\",\"description\":\"We are ready to answer all your questions and advise you 24\\/7. Feel free to reach us anytime.\"}', '2021-03-04 06:27:25', '2021-03-27 11:26:31'),
(61, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"What is cryptocurrency mining?\",\"description\":\"<div class=\\\"blog-item\\\" style=\\\"border:1px solid rgb(229,229,229);padding:20px;color:rgb(119,119,119);font-family:\'Josefin Sans\', sans-serif;\\\"><div class=\\\"blog-content\\\" style=\\\"margin-top:25px;\\\"><div style=\\\"color:rgb(33,37,41);font-family:Montserrat, sans-serif;\\\"><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div style=\\\"color:rgb(33,37,41);font-family:Montserrat, sans-serif;\\\"><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div style=\\\"color:rgb(33,37,41);font-family:Montserrat, sans-serif;\\\"><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div style=\\\"color:rgb(33,37,41);font-family:Montserrat, sans-serif;\\\"><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div style=\\\"color:rgb(33,37,41);font-family:Montserrat, sans-serif;\\\"><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div style=\\\"color:rgb(33,37,41);font-family:Montserrat, sans-serif;\\\"><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div><\\/div><\\/div>\",\"blog_image\":\"6043198019c251615010176.jpg\"}', '2021-03-05 23:56:16', '2021-04-06 07:26:20'),
(62, 'calculate.content', '{\"heading\":\"How Much I Will Earn?\"}', '2021-03-06 00:05:48', '2021-03-24 02:02:13'),
(63, 'faq.content', '{\"heading\":\"ASKED YOUR UNKNOWN QUESTIONS\",\"paragraph\":\"Here you can find our top frequently asked questions. Please let us know if you have any queries regarding our mining platform and FAQs.\"}', '2021-03-06 00:28:26', '2021-03-27 11:10:36'),
(64, 'plan.content', '{\"heading\":\"CHOOSE YOUR PLANS\",\"paragraph\":\"Choose your plans and increase your mining speed and make more coins!\"}', '2021-03-06 01:30:29', '2021-04-05 04:33:28'),
(65, 'feature.content', '{\"has_image\":\"1\",\"heading\":\"Why Choose MineLab?\",\"paragraph\":\"We are combining all the key aspects of conducting an efficient cryptocurrency mining activity. From building a highly efficient data center to providing a robust mining system for our users.\",\"feature_image\":\"60433fce5004c1615019982.png\"}', '2021-03-06 02:35:35', '2021-04-05 05:38:21'),
(68, 'feature.element', '{\"title\":\"Robust Mining Technology\",\"description\":\"For each of the blockchain algorithms that we have proposed, we are providing some of the highest performance mining systems available.\",\"icon\":\"<i class=\\\"las la-hammer\\\"><\\/i>\"}', '2021-03-06 02:42:21', '2021-04-06 06:22:59'),
(69, 'feature.element', '{\"title\":\"Intuitive Dashboard\",\"description\":\"Our system dashboard contains all your crypto mining data and charts.\",\"icon\":\"<i class=\\\"las la-chart-bar\\\"><\\/i>\"}', '2021-03-06 02:42:43', '2021-04-05 05:58:28'),
(70, 'feature.element', '{\"title\":\"Secure and Private\",\"description\":\"We support cryptocurrencies that promote privacy, so we try to keep user data collected to a minimum and will only require information.\",\"icon\":\"<i class=\\\"las la-lock\\\"><\\/i>\"}', '2021-03-06 02:43:13', '2021-04-05 06:24:13'),
(71, 'feature.element', '{\"title\":\"Daily Mining Output\",\"description\":\"Our system will automatically add your daily mining results to your account. Also, you are able to withdraw that amount.\",\"icon\":\"<i class=\\\"las la-wallet\\\"><\\/i>\"}', '2021-03-06 02:44:32', '2021-04-05 06:23:42'),
(72, 'invite.content', '{\"heading\":\"Ready To Start Your Mining\",\"paragraph\":\"Just create an account on our site and start your first mining.\",\"button_text\":\"Start Mining\",\"button_link\":\"register\"}', '2021-03-06 02:49:09', '2021-04-06 23:52:17'),
(73, 'social_icon.element', '{\"title\":\"Twitter\",\"social_icon\":\"<i class=\\\"fab fa-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/www.twitter.com\"}', '2021-03-06 02:52:51', '2021-03-06 02:52:51'),
(74, 'social_icon.element', '{\"title\":\"Instagram\",\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', '2021-03-06 02:53:22', '2021-03-06 02:53:22'),
(75, 'social_icon.element', '{\"title\":\"Linked In\",\"social_icon\":\"<i class=\\\"fab fa-linkedin-in\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\"}', '2021-03-06 02:53:52', '2021-03-06 02:53:52'),
(76, 'breadcrumb.content', '{\"has_image\":\"1\",\"breadcrumb_image\":\"6043507db922f1615024253.jpg\"}', '2021-03-06 03:50:53', '2021-03-06 03:50:53'),
(77, 'links.element', '{\"title\":\"Privacy Policy\",\"description\":\"<div style=\\\"line-height:22px;\\\">Lorem\\u00a0ipsum\\u00a0dolor\\u00a0sit\\u00a0amet\\u00a0consectetur\\u00a0adipisicing\\u00a0elit.\\u00a0Recusandae\\u00a0et\\u00a0veniam\\u00a0esse\\u00a0sed\\u00a0necessitatibus\\u00a0error\\u00a0quam\\u00a0molestias,\\u00a0magnam\\u00a0eveniet\\u00a0asperiores\\u00a0earum\\u00a0amet\\u00a0soluta\\u00a0consequuntur\\u00a0vel\\u00a0quos\\u00a0fugit,\\u00a0incidunt\\u00a0nemo\\u00a0magni\\u00a0natus\\u00a0laudantium!\\u00a0Tenetur\\u00a0fugit\\u00a0maiores\\u00a0unde\\u00a0omnis\\u00a0quam\\u00a0dolores,\\u00a0consequatur\\u00a0asperiores\\u00a0dolorem\\u00a0eum?\\u00a0Necessitatibus\\u00a0reprehenderit\\u00a0expedita\\u00a0dignissimos\\u00a0nemo\\u00a0magni\\u00a0ipsa\\u00a0dolorem\\u00a0perspiciatis,\\u00a0dolor\\u00a0officiis\\u00a0molestiae\\u00a0molestias\\u00a0soluta\\u00a0eligendi\\u00a0eos\\u00a0at.\\u00a0Qui,\\u00a0error\\u00a0eveniet\\u00a0repudiandae\\u00a0temporibus\\u00a0atque\\u00a0natus\\u00a0eligendi\\u00a0assumenda?\\u00a0Inventore,\\u00a0corporis\\u00a0atque\\u00a0ex\\u00a0cum\\u00a0magni\\u00a0consectetur\\u00a0molestiae!\\u00a0Earum\\u00a0reprehenderit\\u00a0suscipit\\u00a0necessitatibus\\u00a0quo\\u00a0reiciendis\\u00a0dolore\\u00a0vitae\\u00a0rerum,\\u00a0quibusdam\\u00a0voluptatibus\\u00a0at\\u00a0rem\\u00a0illo\\u00a0omnis\\u00a0vero\\u00a0aliquid\\u00a0quam,\\u00a0ducimus\\u00a0beatae\\u00a0fugiat\\u00a0eos\\u00a0perferendis\\u00a0quos?\\u00a0Ipsum\\u00a0maiores\\u00a0odit\\u00a0eveniet\\u00a0fugit\\u00a0vitae\\u00a0quis\\u00a0itaque,\\u00a0expedita\\u00a0aspernatur\\u00a0excepturi\\u00a0dicta\\u00a0sapiente\\u00a0eligendi\\u00a0repudiandae\\u00a0nesciunt\\u00a0assumenda\\u00a0in\\u00a0non\\u00a0enim\\u00a0quaerat,\\u00a0mollitia\\u00a0porro\\u00a0praesentium\\u00a0exercitationem\\u00a0pariatur\\u00a0rem\\u00a0laborum?\\u00a0Architecto\\u00a0corporis\\u00a0repellendus\\u00a0impedit\\u00a0quisquam!\\u00a0Eum\\u00a0reprehenderit\\u00a0ad\\u00a0laudantium\\u00a0possimus\\u00a0nesciunt\\u00a0nostrum\\u00a0libero\\u00a0quo\\u00a0inventore\\u00a0ullam\\u00a0consequuntur\\u00a0saepe\\u00a0animi\\u00a0enim\\u00a0quidem,\\u00a0itaque\\u00a0odit\\u00a0officiis\\u00a0quaerat\\u00a0tempore.\\u00a0Optio\\u00a0ipsam\\u00a0consequuntur\\u00a0dignissimos\\u00a0repellendus\\u00a0eligendi\\u00a0corporis\\u00a0ullam\\u00a0dolorum\\u00a0cum\\u00a0repellat\\u00a0vitae\\u00a0excepturi\\u00a0vero\\u00a0voluptas\\u00a0aut\\u00a0deserunt\\u00a0dolorem\\u00a0labore\\u00a0asperiores\\u00a0magni\\u00a0quasi\\u00a0ad,\\u00a0tempora\\u00a0autem,\\u00a0recusandae\\u00a0veniam?\\u00a0Mollitia\\u00a0vitae\\u00a0numquam\\u00a0at\\u00a0magni\\u00a0aliquid\\u00a0laboriosam\\u00a0tempore\\u00a0ducimus\\u00a0rerum\\u00a0quod\\u00a0voluptas\\u00a0iure\\u00a0nisi,\\u00a0praesentium\\u00a0quo\\u00a0neque\\u00a0officia.<\\/div>\"}', '2021-03-08 02:35:42', '2021-04-05 05:18:10'),
(78, 'links.element', '{\"title\":\"Terms of Service\",\"description\":\"<div style=\\\"line-height:22px;\\\">Lorem\\u00a0ipsum\\u00a0dolor\\u00a0sit\\u00a0amet\\u00a0consectetur\\u00a0adipisicing\\u00a0elit.\\u00a0Recusandae\\u00a0et\\u00a0veniam\\u00a0esse\\u00a0sed\\u00a0necessitatibus\\u00a0error\\u00a0quam\\u00a0molestias,\\u00a0magnam\\u00a0eveniet\\u00a0asperiores\\u00a0earum\\u00a0amet\\u00a0soluta\\u00a0consequuntur\\u00a0vel\\u00a0quos\\u00a0fugit,\\u00a0incidunt\\u00a0nemo\\u00a0magni\\u00a0natus\\u00a0laudantium!\\u00a0Tenetur\\u00a0fugit\\u00a0maiores\\u00a0unde\\u00a0omnis\\u00a0quam\\u00a0dolores,\\u00a0consequatur\\u00a0asperiores\\u00a0dolorem\\u00a0eum?\\u00a0Necessitatibus\\u00a0reprehenderit\\u00a0expedita\\u00a0dignissimos\\u00a0nemo\\u00a0magni\\u00a0ipsa\\u00a0dolorem\\u00a0perspiciatis,\\u00a0dolor\\u00a0officiis\\u00a0molestiae\\u00a0molestias\\u00a0soluta\\u00a0eligendi\\u00a0eos\\u00a0at.\\u00a0Qui,\\u00a0error\\u00a0eveniet\\u00a0repudiandae\\u00a0temporibus\\u00a0atque\\u00a0natus\\u00a0eligendi\\u00a0assumenda?\\u00a0Inventore,\\u00a0corporis\\u00a0atque\\u00a0ex\\u00a0cum\\u00a0magni\\u00a0consectetur\\u00a0molestiae!\\u00a0Earum\\u00a0reprehenderit\\u00a0suscipit\\u00a0necessitatibus\\u00a0quo\\u00a0reiciendis\\u00a0dolore\\u00a0vitae\\u00a0rerum,\\u00a0quibusdam\\u00a0voluptatibus\\u00a0at\\u00a0rem\\u00a0illo\\u00a0omnis\\u00a0vero\\u00a0aliquid\\u00a0quam,\\u00a0ducimus\\u00a0beatae\\u00a0fugiat\\u00a0eos\\u00a0perferendis\\u00a0quos?\\u00a0Ipsum\\u00a0maiores\\u00a0odit\\u00a0eveniet\\u00a0fugit\\u00a0vitae\\u00a0quis\\u00a0itaque,\\u00a0expedita\\u00a0aspernatur\\u00a0excepturi\\u00a0dicta\\u00a0sapiente\\u00a0eligendi\\u00a0repudiandae\\u00a0nesciunt\\u00a0assumenda\\u00a0in\\u00a0non\\u00a0enim\\u00a0quaerat,\\u00a0mollitia\\u00a0porro\\u00a0praesentium\\u00a0exercitationem\\u00a0pariatur\\u00a0rem\\u00a0laborum?\\u00a0Architecto\\u00a0corporis\\u00a0repellendus\\u00a0impedit\\u00a0quisquam!\\u00a0Eum\\u00a0reprehenderit\\u00a0ad\\u00a0laudantium\\u00a0possimus\\u00a0nesciunt\\u00a0nostrum\\u00a0libero\\u00a0quo\\u00a0inventore\\u00a0ullam\\u00a0consequuntur\\u00a0saepe\\u00a0animi\\u00a0enim\\u00a0quidem,\\u00a0itaque\\u00a0odit\\u00a0officiis\\u00a0quaerat\\u00a0tempore.\\u00a0Optio\\u00a0ipsam\\u00a0consequuntur\\u00a0dignissimos\\u00a0repellendus\\u00a0eligendi\\u00a0corporis\\u00a0ullam\\u00a0dolorum\\u00a0cum\\u00a0repellat\\u00a0vitae\\u00a0excepturi\\u00a0vero\\u00a0voluptas\\u00a0aut\\u00a0deserunt\\u00a0dolorem\\u00a0labore\\u00a0asperiores\\u00a0magni\\u00a0quasi\\u00a0ad,\\u00a0tempora\\u00a0autem,\\u00a0recusandae\\u00a0veniam?\\u00a0Mollitia\\u00a0vitae\\u00a0numquam\\u00a0at\\u00a0magni\\u00a0aliquid\\u00a0laboriosam\\u00a0tempore\\u00a0ducimus\\u00a0rerum\\u00a0quod\\u00a0voluptas\\u00a0iure\\u00a0nisi,\\u00a0praesentium\\u00a0quo\\u00a0neque\\u00a0officia.<\\/div>\"}', '2021-03-08 02:36:55', '2021-04-05 05:20:01'),
(79, 'testimonial.content', '{\"heading\":\"What people says about us\",\"paragraph\":\"A huge number of people trust us and here are the words of some of them.\"}', '2021-03-24 02:37:03', '2021-03-27 10:43:16'),
(80, 'testimonial.element', '{\"has_image\":[\"1\"],\"author\":\"Mr. Kamal\",\"designation\":\"Businessman\",\"quote\":\"I received my withdrawal from this company in less than 4 hours. A really good start. Now I can refer it to people\",\"author_image\":\"605afae16bc6d1616575201.png\"}', '2021-03-24 02:40:01', '2021-04-05 03:51:48'),
(81, 'footer.content', '{\"heading\":\"About Us\",\"short_details\":\"MineLab is one of the leading cryptocurrency mining platforms, offering cryptocurrency mining capacities in every range - for newcomers. Our mission is to make acquiring cryptocurrencies easy and fast for everyone.\",\"copyright_text\":\"COPYRIGHT \\u00a9 2021 ALL RIGHTS RESERVED\"}', '2021-03-24 03:09:19', '2021-04-05 05:38:08'),
(82, 'testimonial.element', '{\"has_image\":[\"1\"],\"author\":\"Jonathon Smith\",\"designation\":\"Businessman\",\"quote\":\"I have worked with this platform and got good feedback. I recommend this site to all people. Really trustworthy.\",\"author_image\":\"605b10ce303351616580814.png\"}', '2021-03-24 04:13:34', '2021-04-05 05:02:41'),
(83, 'links.element', '{\"title\":\"Cookie Policy\",\"description\":\"<span style=\\\"color:rgb(33,37,41);\\\">Lorem\\u00a0ipsum\\u00a0dolor\\u00a0sit\\u00a0amet\\u00a0consectetur\\u00a0adipisicing\\u00a0elit.\\u00a0Recusandae\\u00a0et\\u00a0veniam\\u00a0esse\\u00a0sed\\u00a0necessitatibus\\u00a0error\\u00a0quam\\u00a0molestias,\\u00a0magnam\\u00a0eveniet\\u00a0asperiores\\u00a0earum\\u00a0amet\\u00a0soluta\\u00a0consequuntur\\u00a0vel\\u00a0quos\\u00a0fugit,\\u00a0incidunt\\u00a0nemo\\u00a0magni\\u00a0natus\\u00a0laudantium!\\u00a0Tenetur\\u00a0fugit\\u00a0maiores\\u00a0unde\\u00a0omnis\\u00a0quam\\u00a0dolores,\\u00a0consequatur\\u00a0asperiores\\u00a0dolorem\\u00a0eum?\\u00a0Necessitatibus\\u00a0reprehenderit\\u00a0expedita\\u00a0dignissimos\\u00a0nemo\\u00a0magni\\u00a0ipsa\\u00a0dolorem\\u00a0perspiciatis,\\u00a0dolor\\u00a0officiis\\u00a0molestiae\\u00a0molestias\\u00a0soluta\\u00a0eligendi\\u00a0eos\\u00a0at.\\u00a0Qui,\\u00a0error\\u00a0eveniet\\u00a0repudiandae\\u00a0temporibus\\u00a0atque\\u00a0natus\\u00a0eligendi\\u00a0assumenda?\\u00a0Inventore,\\u00a0corporis\\u00a0atque\\u00a0ex\\u00a0cum\\u00a0magni\\u00a0consectetur\\u00a0molestiae!\\u00a0Earum\\u00a0reprehenderit\\u00a0suscipit\\u00a0necessitatibus\\u00a0quo\\u00a0reiciendis\\u00a0dolore\\u00a0vitae\\u00a0rerum,\\u00a0quibusdam\\u00a0voluptatibus\\u00a0at\\u00a0rem\\u00a0illo\\u00a0omnis\\u00a0vero\\u00a0aliquid\\u00a0quam,\\u00a0ducimus\\u00a0beatae\\u00a0fugiat\\u00a0eos\\u00a0perferendis\\u00a0quos?\\u00a0Ipsum\\u00a0maiores\\u00a0odit\\u00a0eveniet\\u00a0fugit\\u00a0vitae\\u00a0quis\\u00a0itaque,\\u00a0expedita\\u00a0aspernatur\\u00a0excepturi\\u00a0dicta\\u00a0sapiente\\u00a0eligendi\\u00a0repudiandae\\u00a0nesciunt\\u00a0assumenda\\u00a0in\\u00a0non\\u00a0enim\\u00a0quaerat,\\u00a0mollitia\\u00a0porro\\u00a0praesentium\\u00a0exercitationem\\u00a0pariatur\\u00a0rem\\u00a0laborum?\\u00a0Architecto\\u00a0corporis\\u00a0repellendus\\u00a0impedit\\u00a0quisquam!\\u00a0Eum\\u00a0reprehenderit\\u00a0ad\\u00a0laudantium\\u00a0possimus\\u00a0nesciunt\\u00a0nostrum\\u00a0libero\\u00a0quo\\u00a0inventore\\u00a0ullam\\u00a0consequuntur\\u00a0saepe\\u00a0animi\\u00a0enim\\u00a0quidem,\\u00a0itaque\\u00a0odit\\u00a0officiis\\u00a0quaerat\\u00a0tempore.\\u00a0Optio\\u00a0ipsam\\u00a0consequuntur\\u00a0dignissimos\\u00a0repellendus\\u00a0eligendi\\u00a0corporis\\u00a0ullam\\u00a0dolorum\\u00a0cum\\u00a0repellat\\u00a0vitae\\u00a0excepturi\\u00a0vero\\u00a0voluptas\\u00a0aut\\u00a0deserunt\\u00a0dolorem\\u00a0labore\\u00a0asperiores\\u00a0magni\\u00a0quasi\\u00a0ad,\\u00a0tempora\\u00a0autem,\\u00a0recusandae\\u00a0veniam?\\u00a0Mollitia\\u00a0vitae\\u00a0numquam\\u00a0at\\u00a0magni\\u00a0aliquid\\u00a0laboriosam\\u00a0tempore\\u00a0ducimus\\u00a0rerum\\u00a0quod\\u00a0voluptas\\u00a0iure\\u00a0nisi,\\u00a0praesentium\\u00a0quo\\u00a0neque\\u00a0officia.<\\/span>\"}', '2021-03-27 14:04:40', '2021-04-05 05:20:56'),
(84, 'how_work.element', '{\"title\":\"Start Mining\",\"description\":\"Now you are ready to mine! Increase the mining power on the fly for all the coins using MineLab.\",\"icon\":\"<i class=\\\"las la-coins\\\"><\\/i>\"}', '2021-04-05 00:02:53', '2021-04-05 02:45:11'),
(85, 'how_work.element', '{\"title\":\"Get Mining Output\",\"description\":\"You will periodically receive mining output from your designated wallet. Try our MineLab mining platform now!\",\"icon\":\"<i class=\\\"las la-wallet\\\"><\\/i>\"}', '2021-04-05 00:13:13', '2021-04-05 00:13:31'),
(86, 'about.element', '{\"title\":\"Performance\",\"description\":\"Ultimate performance at low cost\",\"icon\":\"<i class=\\\"las la-database\\\"><\\/i>\"}', '2021-04-05 04:22:11', '2021-04-05 04:22:11'),
(87, 'links.element', '{\"title\":\"Usage Policy\",\"description\":\"<br \\/>\"}', '2021-04-05 05:19:36', '2021-04-05 05:20:33'),
(88, 'feature.element', '{\"title\":\"Easy Payment System\",\"description\":\"We have 20+ payment methods in our system. You can easily complete your payment.\",\"icon\":\"<i class=\\\"fab fa-paypal\\\"><\\/i>\"}', '2021-04-05 06:09:04', '2021-04-05 06:09:04'),
(89, 'feature.element', '{\"title\":\"Multilingual\",\"description\":\"As we run our business in 100+ countries we have a multilingual feature in your system.\",\"icon\":\"<i class=\\\"fas fa-globe-africa\\\"><\\/i>\"}', '2021-04-05 06:12:09', '2021-04-05 06:12:09'),
(90, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"4 Ways Your Small Business Can Benefit From Blockchain\",\"description\":\"<div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div>\",\"blog_image\":\"606c61b3f0b2a1617715635.jpg\"}', '2021-04-06 07:04:41', '2021-04-06 07:27:16');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(91, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"What You Should Know Before Investing in Bitcoin\",\"description\":\"<div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div>\",\"blog_image\":\"606c6473824771617716339.jpeg\"}', '2021-04-06 07:07:23', '2021-04-06 07:38:59'),
(92, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Beyond Crypto: 7 Block Chain Stocks to Buy\",\"description\":\"<div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div>\",\"blog_image\":\"606c613a4384f1617715514.jpeg\"}', '2021-04-06 07:09:06', '2021-04-06 07:25:14'),
(93, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Is Bitcoin Digital Gold?\",\"description\":\"<div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div>\",\"blog_image\":\"606c64fbb5b1d1617716475.jpg\"}', '2021-04-06 07:41:15', '2021-04-06 07:41:15'),
(94, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How Tech is Shaping the Future of Finance?\",\"description\":\"<div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div>\",\"blog_image\":\"606c67042e7a71617716996.jpeg\"}', '2021-04-06 07:46:58', '2021-04-06 07:49:56'),
(95, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Is Bitcoin in a Dangerous Bubble?\",\"description\":\"<div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br \\/><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><\\/div><div><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\\u00a0It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/span><br \\/><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><span style=\\\"font-family:Exo, sans-serif;\\\"><\\/span><\\/div><div><span style=\\\"font-family:Exo, sans-serif;\\\"><br \\/><\\/span><\\/div>\",\"blog_image\":\"606c677693ab11617717110.jpg\"}', '2021-04-06 07:51:50', '2021-04-06 07:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `alias` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_form` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `code`, `alias`, `image`, `name`, `status`, `parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `input_form`, `created_at`, `updated_at`) VALUES
(1, 101, 'paypal', '5f6f1bd8678601601117144.jpg', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-zlbi7986064@personal.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-01-17 03:02:44'),
(2, 102, 'perfect_money', '5f6f1d2a742211601117482.jpg', 'Perfect Money', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"6451561651551\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:46'),
(3, 103, 'stripe', '5f6f1d4bc69e71601117515.jpg', 'Stripe Hosted', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:49'),
(4, 104, 'skrill', '5f6f1d41257181601117505.jpg', 'Skrill', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:52'),
(5, 105, 'paytm', '5f6f1d1d3ec731601117469.jpg', 'PayTM', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:54'),
(6, 106, 'payeer', '5f6f1bc61518b1601117126.jpg', 'Payeer', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.payeer\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:58'),
(7, 107, 'paystack', '5f7096563dfb71601214038.jpg', 'PayStack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_3c9c87f51b13c15d99eb367ca6ebc52cc9eb1f33\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_2a3f97a146ab5694801f993b60fcb81cd7254f12\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.paystack\"}}\r\n', NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:25:38'),
(8, 108, 'voguepay', '5f6f1d5951a111601117529.jpg', 'VoguePay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:52:09'),
(9, 109, 'flutterwave', '5f6f1b9e4bb961601117086.jpg', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"demo_publisher_key\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"demo_secret_key\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"demo_encryption_key\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-01-04 03:29:50'),
(10, 110, 'razorpay', '5f6f1d3672dd61601117494.jpg', 'RazorPay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:51:34'),
(11, 111, 'stripe_js', '5f7096a31ed9a1601214115.jpg', 'Stripe Storefront', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-05 03:56:20'),
(12, 112, 'instamojo', '5f6f1babbdbb31601117099.jpg', 'Instamojo', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:44:59'),
(13, 501, 'blockchain', '5f6f1b2b20c6f1601116971.jpg', 'Blockchain', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-01-31 06:55:45'),
(14, 502, 'blockio', '5f6f19432bedf1601116483.jpg', 'Block.io', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":false,\"value\":\"1658-8015-2e5e-9afb\"},\"api_pin\":{\"title\":\"API PIN\",\"global\":true,\"value\":\"covidvai2020\"}}', '{\"BTC\":\"BTC\",\"LTC\":\"LTC\",\"DOGE\":\"DOGE\"}', 1, '{\"cron\":{\"title\": \"Cron URL\",\"value\":\"ipn.blockio\"}}', NULL, NULL, '2019-09-14 13:14:22', '2021-01-03 23:19:59'),
(15, 503, 'coinpayments', '5f6f1b6c02ecd1601117036.jpg', 'CoinPayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"7638eebaf4061b7f7cdfceb14046318bbdabf7e2f64944773d6550bd59f70274\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"Cb6dee7af8Eb9E0D4123543E690dA3673294147A5Dc8e7a621B5d484a3803207\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:56'),
(16, 504, 'coinpayments_fiat', '5f6f1b94e9b2b1601117076.jpg', 'CoinPayments Fiat', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-10-22 03:17:29'),
(17, 505, 'coingate', '5f6f1b5fe18ee1601117023.jpg', 'Coingate', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"Ba1VgPx6d437xLXGKCBkmwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:44'),
(18, 506, 'coinbase_commerce', '5f6f1b4c774af1601117004.jpg', 'Coinbase Commerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.coinbase_commerce\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:24'),
(24, 113, 'paypal_sdk', '5f6f1bec255c61601117164.jpg', 'Paypal Express', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-10-31 23:50:27'),
(25, 114, 'stripe_v3', '5f709684736321601214084.jpg', 'Stripe Checkout', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"w5555\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.stripe_v3\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-12-05 03:56:14'),
(27, 115, 'mollie', '5f6f1bb765ab11601117111.jpg', 'Mollie', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"ronniearea@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:45:11'),
(30, 116, 'cashmaal', '5f9a8b62bb4dd1603963746.png', 'Cashmaal', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.cashmaal\"}}', NULL, NULL, NULL, '2020-10-29 03:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_code` int(11) DEFAULT NULL,
  `gateway_alias` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(18,8) NOT NULL,
  `max_amount` decimal(18,8) NOT NULL,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_parameter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sitename` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preloader_title` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `referral_bonus` int(11) NOT NULL DEFAULT 0,
  `email_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_api` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email configuration',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `referral_system` tinyint(1) NOT NULL DEFAULT 1,
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `active_template` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_version` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `sitename`, `preloader_title`, `cur_text`, `cur_sym`, `referral_bonus`, `email_from`, `email_template`, `sms_api`, `base_color`, `mail_config`, `ev`, `en`, `sv`, `sn`, `referral_system`, `registration`, `active_template`, `sys_version`, `last_cron`, `created_at`, `updated_at`) VALUES
(1, 'MineLab', 'MineLab', 'USD', '$', 0, 'test@site.com', '<table style=\"color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(0, 23, 54); text-decoration-style: initial; text-decoration-color: initial;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#001736\"><tbody><tr><td valign=\"top\" align=\"center\"><table class=\"mobile-shell\" width=\"650\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"td container\" style=\"width: 650px; min-width: 650px; font-size: 0pt; line-height: 0pt; margin: 0px; font-weight: normal; padding: 55px 0px;\"><div style=\"text-align: center;\"><br></div><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"padding-bottom: 10px;\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"tbrr p30-15\" style=\"padding: 60px 30px; border-radius: 26px 26px 0px 0px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"color: rgb(255, 255, 255); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 46px; padding-bottom: 25px; font-weight: bold;\">Hi {{name}} ,</td></tr><tr><td style=\"color: rgb(193, 205, 220); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 30px; padding-bottom: 25px;\">{{message}}</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"p30-15 bbrr\" style=\"padding: 50px 30px; border-radius: 0px 0px 26px 26px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"text-footer1 pb10\" style=\"color: rgb(0, 153, 255); font-family: Muli, Arial, sans-serif; font-size: 18px; line-height: 30px; text-align: center; padding-bottom: 10px;\">© 2021 MineLab . All Rights Reserved.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>', '********************', '27AE61', '{\"name\":\"php\"}', 1, 1, 0, 0, 0, 1, 'basic', NULL, '2021-04-23 12:16:38', NULL, '2021-05-26 23:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_align` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: left to right text align, 1: right to left text align',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `text_align`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '5f15968db08911595250317.png', 0, 0, '2020-07-06 03:47:55', '2021-01-06 00:33:35'),
(4, 'Bangla', 'bn', '5f1596a650cd11595250342.png', 0, 0, '2020-07-20 07:05:42', '2021-04-06 09:01:45'),
(5, 'Hindi', 'hn', NULL, 0, 0, '2020-12-29 02:20:07', '2020-12-29 02:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `miners`
--

CREATE TABLE `miners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_withdraw_limit` decimal(28,16) NOT NULL DEFAULT 0.0000000000000000,
  `max_withdraw_limit` decimal(28,16) NOT NULL DEFAULT 0.0000000000000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trx` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `plan_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `coin_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_return_per_day` decimal(28,16) NOT NULL DEFAULT 0.0000000000000000,
  `max_return_per_day` decimal(28,16) NOT NULL DEFAULT 0.0000000000000000,
  `period` int(11) NOT NULL DEFAULT 0 COMMENT 'Day',
  `period_remain` int(11) NOT NULL DEFAULT 0 COMMENT 'Day',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Approved, 2=Expired',
  `last_paid` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', 'home', 'templates.basic.', '[\"how_work\",\"about\",\"faq\",\"subscribe\",\"transaction\",\"service\",\"plan\",\"invite\",\"blog\",\"feature\",\"testimonial\"]', 1, '2020-07-11 06:23:58', '2021-04-05 04:11:29'),
(2, 'About', 'about-us', 'templates.basic.', '[\"about\",\"blog\"]', 0, '2020-07-11 06:35:35', '2021-03-06 03:27:51'),
(3, 'Plans', 'plans', 'templates.basic.', '[\"faq\",\"feature\"]', 1, '2021-03-06 09:19:38', '2021-03-25 00:06:40'),
(4, 'Blogs', 'blogs', 'templates.basic.', NULL, 1, '2020-10-22 01:14:43', '2021-04-06 07:05:12'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"about\"]', 1, '2020-10-22 01:14:53', '2021-03-07 06:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `miner_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `speed` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `speed_unit` tinyint(4) NOT NULL DEFAULT 2,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `period` smallint(6) NOT NULL DEFAULT 1,
  `period_unit` tinyint(4) NOT NULL DEFAULT 1,
  `min_return_per_day` decimal(28,16) NOT NULL DEFAULT 0.0000000000000000,
  `max_return_per_day` decimal(28,16) DEFAULT NULL,
  `features` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referral_logs`
--

CREATE TABLE `referral_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `referee_id` int(11) NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(11) NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `supportticket_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_balance` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int(11) DEFAULT NULL,
  `balance` decimal(28,16) NOT NULL DEFAULT 0.0000000000000000,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: sms unverified, 1: sms verified',
  `ver_code` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_coin_balances`
--

CREATE TABLE `user_coin_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `coin_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(28,16) NOT NULL DEFAULT 0.0000000000000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_coin_balance_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(28,16) NOT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdraw_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=>pending, 1=>success,  2=>cancel',
  `admin_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `miners`
--
ALTER TABLE `miners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plans_miner_id_index` (`miner_id`);

--
-- Indexes for table `referral_logs`
--
ALTER TABLE `referral_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_coin_balances`
--
ALTER TABLE `user_coin_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `miners`
--
ALTER TABLE `miners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referral_logs`
--
ALTER TABLE `referral_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_coin_balances`
--
ALTER TABLE `user_coin_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
