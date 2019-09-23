-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-09-23 14:10:37
-- 服务器版本： 8.0.15
-- PHP 版本： 7.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `zhdp`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '删除时间',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `token` char(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '唯一标识',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(900, '123456', '123456', 'gRHwSRwp7GfUudEtcH0JfqcugwSWi7rVAVWMeCH3upSK1piWSN69d1CFIEI0', NULL, '2019-09-23 00:35:34', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE `article` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '文章标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '最大65535',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `crop_class_id` int(11) NOT NULL COMMENT '作物id',
  `article_class_id` int(10) UNSIGNED NOT NULL COMMENT '文章分类id',
  `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '状态 0未结 1已结',
  `essence` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '精华 0正常 1精华',
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '阅读查看次数',
  `comment_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数量',
  `article_collection_count` int(10) UNSIGNED DEFAULT '0' COMMENT '收藏数量',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `user_id`, `crop_class_id`, `article_class_id`, `status`, `essence`, `view_count`, `comment_count`, `article_collection_count`, `updated_at`, `created_at`) VALUES
(5, '测试', '111', 899, 1, 5, '0', '0', 1, 0, 0, '2019-09-11 20:16:16', '2019-09-11 00:41:14'),
(6, 'aa', 'aa', 899, 3, 5, '0', '0', 1, 0, 0, '2019-09-11 14:30:33', '2019-09-11 01:29:06'),
(7, 'aa', 'aa', 899, 3, 5, '0', '0', 2, 0, 1, '2019-09-11 20:01:08', '2019-09-11 01:45:02'),
(8, '测试文章呀', '<p><b>测试文章呀</b></p><p>好可怕</p><p><i>你真棒</i></p><p><u>点点点</u></p><p><u><img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/56.gif\" alt=\"[赞]\"></u><br></p>', 899, 2, 5, '0', '0', 2, 1, 1, '2019-09-11 20:24:47', '2019-09-11 01:47:38'),
(9, '测试', '<div align=\"center\"><p align=\"left\">你知道吗？</p><p align=\"left\">你真的很棒！</p></div>', 899, 3, 5, '0', '0', 3, 2, 2, '2019-09-17 00:57:41', '2019-09-11 02:05:13'),
(10, '西红柿有青虫怎么防治', '<p>&nbsp;&nbsp;&nbsp; 请问大家如何解决西红柿有青虫呢？</p><p>&nbsp;&nbsp;&nbsp; 打什么药呢？<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/2.gif\" alt=\"[哈哈]\"><br></p>', 890, 2, 5, '0', '0', 2, 2, 0, '2019-09-17 00:54:13', '2019-09-11 16:40:08');

-- --------------------------------------------------------

--
-- 表的结构 `article_class`
--

CREATE TABLE `article_class` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '分类名字',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '分类描述',
  `sort` mediumint(9) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类排序',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `article_class`
--

INSERT INTO `article_class` (`id`, `name`, `desc`, `sort`, `updated_at`, `created_at`) VALUES
(5, '提问', 'aa', 0, '2019-09-11 00:43:10', NULL),
(6, '求助', 'aa', 1, '2019-09-11 16:59:45', '2019-09-11 00:41:14');

-- --------------------------------------------------------

--
-- 表的结构 `article_collection`
--

CREATE TABLE `article_collection` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `article_id` int(10) UNSIGNED NOT NULL COMMENT '收藏文章id',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `article_collection`
--

INSERT INTO `article_collection` (`id`, `user_id`, `article_id`, `updated_at`, `created_at`) VALUES
(23, 890, 9, '2019-09-11 20:26:45', '2019-09-11 20:26:45');

-- --------------------------------------------------------

--
-- 表的结构 `article_comment`
--

CREATE TABLE `article_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '评论用户id',
  `article_id` int(10) UNSIGNED NOT NULL COMMENT '文章id',
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '评论内容',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `article_comment`
--

INSERT INTO `article_comment` (`id`, `user_id`, `article_id`, `content`, `updated_at`, `created_at`) VALUES
(5, 899, 9, 'ceshi', NULL, NULL),
(6, 899, 9, 'ceshi', NULL, NULL),
(7, 899, 9, 'ceshi', NULL, NULL),
(8, 899, 9, 'ceshi', NULL, NULL),
(9, 899, 9, 'ceshi', NULL, NULL),
(10, 899, 9, 'ceshi', NULL, NULL),
(11, 899, 9, 'ceshi', NULL, NULL),
(12, 899, 9, 'ceshi', NULL, NULL),
(13, 899, 9, 'ceshi', NULL, NULL),
(14, 899, 9, 'ceshi', NULL, NULL),
(15, 899, 9, 'ceshi', NULL, NULL),
(16, 899, 9, 'ceshi', NULL, NULL),
(17, 890, 9, 'aa', '2019-09-11 11:05:35', '2019-09-11 11:05:35'),
(18, 890, 9, '<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/56.gif\" alt=\"[赞]\">', '2019-09-11 11:06:22', '2019-09-11 11:06:22'),
(19, 897, 7, '楼主好棒<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/49.gif\" alt=\"[猪头]\">', '2019-09-11 12:33:49', '2019-09-11 12:33:49'),
(20, 897, 9, '测试数量', '2019-09-11 14:32:09', '2019-09-11 14:32:09'),
(21, 897, 10, '如题', '2019-09-11 16:40:25', '2019-09-11 16:40:25'),
(22, 890, 8, '<p><b>测试文章呀</b></p><p>好可怕</p><p><i>你真棒</i></p><p><u>点点点</u></p><u><img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/56.gif\" alt=\"[赞]\"></u>', '2019-09-11 17:04:06', '2019-09-11 17:04:06'),
(23, 890, 10, '111', '2019-09-17 00:54:13', '2019-09-17 00:54:13'),
(24, 890, 9, 'aaaa', '2019-09-17 00:57:41', '2019-09-17 00:57:41');

-- --------------------------------------------------------

--
-- 表的结构 `article_msg`
--

CREATE TABLE `article_msg` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '发送消息用户id',
  `article_id` int(10) UNSIGNED NOT NULL COMMENT '文章id',
  `receive_user_id` int(10) UNSIGNED NOT NULL COMMENT '接收消息用户id',
  `status` enum('0','1','2','3') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 评论 1点赞 2收藏 3精帖',
  `view` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 未读 1 已读',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `article_view`
--

CREATE TABLE `article_view` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '查看用户id',
  `article_id` int(10) UNSIGNED NOT NULL COMMENT '文章id',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `article_view`
--

INSERT INTO `article_view` (`id`, `user_id`, `article_id`, `updated_at`, `created_at`) VALUES
(5, 890, 9, '2019-09-17 00:57:43', '2019-09-11 12:16:24'),
(6, 890, 7, '2019-09-11 20:01:04', '2019-09-11 12:24:54'),
(7, 897, 9, '2019-09-11 16:32:17', '2019-09-11 12:33:22'),
(8, 897, 7, '2019-09-11 14:28:56', '2019-09-11 12:33:29'),
(9, 897, 8, '2019-09-11 14:27:23', '2019-09-11 14:27:23'),
(10, 897, 6, '2019-09-11 14:30:33', '2019-09-11 14:30:33'),
(11, 897, 10, '2019-09-11 16:43:12', '2019-09-11 16:40:13'),
(12, 890, 8, '2019-09-11 20:24:54', '2019-09-11 16:54:04'),
(13, 890, 10, '2019-09-18 02:57:16', '2019-09-11 17:23:06'),
(14, 890, 5, '2019-09-11 20:10:52', '2019-09-11 19:29:47');

-- --------------------------------------------------------

--
-- 表的结构 `crop_class`
--

CREATE TABLE `crop_class` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '作物名字',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '作物所属分类，只允许二级分类',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `crop_class`
--

INSERT INTO `crop_class` (`id`, `name`, `pid`, `updated_at`, `created_at`) VALUES
(0, '顶级分类', 0, NULL, NULL),
(1, '蔬菜', 0, NULL, NULL),
(2, '西红柿', 1, NULL, NULL),
(3, '小白菜', 1, '2019-09-09 22:04:07', '2019-09-09 22:02:42');

-- --------------------------------------------------------

--
-- 表的结构 `crop_traceability`
--

CREATE TABLE `crop_traceability` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `device_room_id` int(10) UNSIGNED NOT NULL COMMENT '房间id',
  `crop_class_id` int(10) UNSIGNED NOT NULL COMMENT '作物id',
  `crop_variety` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '作物品种',
  `number_of_plants` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '种植数量',
  `start_time` datetime NOT NULL COMMENT '种植时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `status` enum('0','1') COLLATE utf8_bin DEFAULT '0' COMMENT '种植状态(0 进行中 1 已结束)',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `crop_traceability`
--

INSERT INTO `crop_traceability` (`id`, `user_id`, `device_room_id`, `crop_class_id`, `crop_variety`, `number_of_plants`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(2, 890, 898, 2, '油菜202', '500棵', '2019-09-21 00:00:00', '2019-09-21 10:32:40', '1', '2019-09-21 01:58:35', '2019-09-21 10:32:40'),
(3, 890, 898, 2, '油菜101', '1亩', '2019-09-21 00:00:00', NULL, '0', '2019-09-21 11:18:26', '2019-09-21 11:18:26');

-- --------------------------------------------------------

--
-- 表的结构 `crop_traceability_batch`
--

CREATE TABLE `crop_traceability_batch` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '收获批次(系统填充)',
  `crop_traceability_id` int(10) UNSIGNED NOT NULL,
  `token` char(60) COLLATE utf8_bin NOT NULL COMMENT '唯一标识',
  `batch` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '收获批次(系统填充)',
  `harvest_quantity` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '收获数量(斤/株/棵)',
  `sampling_status` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '抽检状态 0 未抽检 1 抽检合格 2 抽检不合格',
  `qr_code_path` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '二维码文件位置',
  `end_time` datetime DEFAULT NULL COMMENT '收获时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `crop_traceability_batch`
--

INSERT INTO `crop_traceability_batch` (`id`, `crop_traceability_id`, `token`, `batch`, `harvest_quantity`, `sampling_status`, `qr_code_path`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 2, 'sqAtjDhslQsFvWQO7mZnokIZF4NhHLNTq0hxviJtguRg19SNwVcZDt7LPOK4', 1, '500斤', '0', '', '2019-09-21 00:00:00', '2019-09-21 10:25:17', '2019-09-21 10:25:17'),
(2, 2, 'L7r0Sr96auSoDKybSsOEgqzsMgC85qzxW2G5FaKrL5H3AKE9MyAkMFToSrb8', 2, '200斤', '0', '', '2019-09-21 00:00:00', '2019-09-21 10:25:41', '2019-09-21 10:25:41'),
(3, 2, 'rrhTa9kk1PRPyVtBnjOYq4eLQ94e4OTB29J9qmfBaS5tQhPt7K0NqMrkG980', 3, '500斤', '0', '', '2019-09-21 00:00:00', '2019-09-21 10:32:15', '2019-09-21 10:32:15'),
(4, 2, 'vfH2MlqaChgxDGJGLydDzGiGpV2lfxROg3xORtAQztbl5tTokEHndPaPEwQW', 4, '100斤', '0', '', '2019-09-28 00:00:00', '2019-09-21 10:32:40', '2019-09-21 10:32:40'),
(5, 3, 'shxDJGJ2zeg53oGqFHnxHMbimrOKr5h5Lran1Tn5T2n50PzPfoqAXsV9HpUo', 1, '200斤', '0', '/public/qrcode/shxDJGJ2zeg53oGqFHnxHMbimrOKr5h5Lran1Tn5T2n50PzPfoqAXsV9HpUo.svg', '2019-09-21 00:00:00', '2019-09-21 11:19:38', '2019-09-21 11:19:38'),
(6, 3, 'BCLB67ofRsBabin8ogT52m4JymHimNxehCU0G6RkI6ymYWIRquGrBEeADeIN', 2, '20斤', '0', '/storage/qrcode/BCLB67ofRsBabin8ogT52m4JymHimNxehCU0G6RkI6ymYWIRquGrBEeADeIN.svg', '2019-09-21 00:00:00', '2019-09-21 11:45:59', '2019-09-21 11:45:59'),
(7, 3, 'bRWY50DVtU2ALwsoHsOib70dkpYZ2J9pQPlhO1UCY3i9JYc9B01pB8K0tdGF', 3, '20斤', '0', '/storage/qrcode/bRWY50DVtU2ALwsoHsOib70dkpYZ2J9pQPlhO1UCY3i9JYc9B01pB8K0tdGF.svg', '2019-09-21 00:00:00', '2019-09-21 12:00:48', '2019-09-21 12:00:48'),
(8, 3, 'LDCwJhMKYIctA0lZzOxoyYupKutzsesANv9IyvRWBKdJzk3YT0rW5ZOCtI09', 4, '500斤', '1', '/storage/qrcode/LDCwJhMKYIctA0lZzOxoyYupKutzsesANv9IyvRWBKdJzk3YT0rW5ZOCtI09.svg', '2019-09-21 00:00:00', '2019-09-21 12:01:51', '2019-09-21 23:23:28');

-- --------------------------------------------------------

--
-- 表的结构 `crop_traceability_event_log`
--

CREATE TABLE `crop_traceability_event_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `crop_traceability_id` int(10) UNSIGNED NOT NULL COMMENT '所属追溯id',
  `event_name` varchar(120) COLLATE utf8_bin NOT NULL COMMENT '事件名',
  `event_content` text COLLATE utf8_bin NOT NULL COMMENT '事件内容',
  `event_time` datetime NOT NULL COMMENT '事件时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `crop_traceability_event_log`
--

INSERT INTO `crop_traceability_event_log` (`id`, `crop_traceability_id`, `event_name`, `event_content`, `event_time`, `created_at`, `updated_at`) VALUES
(1, 890, '施药', '施药', '2019-09-21 00:00:00', '2019-09-21 10:03:41', '2019-09-21 10:03:41'),
(2, 3, '施药', '美国白俄', '2019-09-21 00:00:00', '2019-09-21 12:28:01', '2019-09-21 12:28:01');

-- --------------------------------------------------------

--
-- 表的结构 `device`
--

CREATE TABLE `device` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '所属用户id',
  `product_id` int(10) UNSIGNED NOT NULL COMMENT '设备所属产品表',
  `device_room_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '设备房间id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '产品名称',
  `desc` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '描述',
  `token` char(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '唯一标识(可以通过该标识更新该设备的参数状态(char60))',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device`
--

INSERT INTO `device` (`id`, `user_id`, `product_id`, `device_room_id`, `name`, `desc`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(889, 10, 889, 895, '测试', '', 'RJTLD829626896143203E4D3E959CF8D412A087A40BB901EF8F1CA9FB00C', '2019-08-29 07:11:29', '2019-08-29 07:11:29', NULL),
(899, 890, 889, 898, 'aa', 'aa', 'tx1LSw33NvvOSXpDHupUbUoAYIT1vL5MQazQQLRkp15yXXfbVM7Z4guOQae4', '2019-09-06 16:40:29', '2019-09-06 16:40:29', NULL),
(900, 890, 889, 898, 'aa', 'aa', 'JKVcex1RaosFdNDH32zM8slNvmXPUoKt5Q8rPyGdXhCUyGa1DzS3ltOk6FTN', '2019-09-06 16:40:39', '2019-09-06 16:40:39', NULL),
(901, 890, 889, 898, 'aa', 'aa', 'lN7Odg1IKzT6H0uqlPHLZGzpO9CqtxPDUS6Y5cvP7o3howyisrPtq79ry4Go', '2019-09-06 16:42:09', '2019-09-06 16:42:09', NULL),
(902, 890, 889, 898, 'aa', 'aa', 'akM7HWS6nmlGKglLJdh6kqqqtQJWNAi0BC9RGOdnBVTNtckX7iSXRaNefWXn', '2019-09-06 16:42:29', '2019-09-06 16:42:29', NULL),
(903, 890, 889, 898, 'aa', 'aa', 'N8P1tFRrN2jgb5Qh0kbzi9oiRhy0o2LoL6ZE7LddwLIsDj08vlSTsis2vn3E', '2019-09-06 16:42:44', '2019-09-06 16:42:44', NULL),
(904, 890, 889, 898, 'aa', 'aa', 'A1kfcnoawVLgdn5ZEA4foUovlGfB9caaVG3DfOnPKJuMqd394judUt8hYFXy', '2019-09-06 16:43:14', '2019-09-06 16:43:14', NULL),
(905, 890, 889, 898, 'aa', 'aa', 'kmgj9IsTjy62GR8Tm7guFkKfHYlgqO3YLwVhmodgAUUvbTny4BBNQXXTOKLM', '2019-09-06 16:43:27', '2019-09-06 16:43:27', NULL),
(906, 890, 889, 898, 'aa', 'aa', '5TbPvRLN9iIhCA3xDsHMVYmarvSRWJ9yHDxI6Er2fscDispajCNBOUBaz6QT', '2019-09-06 16:51:56', '2019-09-06 16:51:56', NULL),
(907, 890, 889, 899, '风扇开关', '', 'lKT5OP0g3R4IbnWyybvD6aQ5F0hn4wWQBa6Elrl2TGnE03WLkFGNVDmVq0fU', '2019-09-14 23:28:23', '2019-09-14 23:28:23', NULL),
(908, 890, 891, 899, '温度计', '', 'RiLqHSOzreLWzQkN9eyOyEVyYcBMoXpUm0kOG4bA3MOhH8Ft9rxvqAAK1VGc', '2019-09-14 23:28:37', '2019-09-14 23:28:37', NULL),
(909, 890, 891, 898, '空气检测2字段', '', 'T0xJ0OEpTH2sE086gE4HFG9IjrBrL6oSJETU4zwvqc5bjlmuEjJtQKdVERSD', '2019-09-16 11:48:06', '2019-09-16 11:48:06', NULL),
(910, 890, 891, 898, '2', '', 'etVd1hdiMf5oH8Nc9lTxL4U09OHsyTckmlBaQ41qvbNws6ggMkrTBZ4ddodZ', '2019-09-16 11:50:46', '2019-09-16 11:50:46', NULL),
(911, 890, 889, 898, '风扇继电器', '', 'v63C2zBkHdlXCXmIBx0MyWfo2l85ZuSUO0DF0Ko6Jod92eOD5HgfadSB818j', '2019-09-16 13:32:59', '2019-09-16 13:32:59', NULL),
(912, 890, 891, 900, '空气检测', '空气检测', 'ZvvatzI07t0Zolxps1BYr5HCtiYaCHqYlv9qvUvhHyzlsHFs8W49hHg9bYue', '2019-09-17 17:47:39', '2019-09-17 17:47:39', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_event`
--

CREATE TABLE `device_event` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '字段所属设备id',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '事件名',
  `type` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 低于 1 等于 2 高于',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '用于比较的值',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '描述',
  `device_region_id` int(10) UNSIGNED DEFAULT NULL COMMENT '设备区域id',
  `device_room_id` int(10) UNSIGNED DEFAULT NULL COMMENT '设备房间id',
  `device_id` int(10) UNSIGNED NOT NULL COMMENT '字段所属设备id',
  `device_field_id` int(10) UNSIGNED NOT NULL COMMENT '事件设备字段id',
  `associated_device_id` int(10) UNSIGNED NOT NULL COMMENT '关联设备id(操作该设备)',
  `associated_device_field_id` int(11) NOT NULL COMMENT '关联设备字段id(操作该字段)',
  `operation_type` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 关闭 1打开(有继电开关的只能有一个字段，并且该字段是bool)',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_event`
--

INSERT INTO `device_event` (`id`, `user_id`, `name`, `type`, `value`, `desc`, `device_region_id`, `device_room_id`, `device_id`, `device_field_id`, `associated_device_id`, `associated_device_field_id`, `operation_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(907, 890, '温度过高降温', '0', '20', NULL, 892, 898, 908, 896, 907, 895, '1', '2019-09-14 23:38:04', '2019-09-14 23:38:04', NULL),
(908, 890, '温度过低关停', '0', '10', NULL, 897, 899, 908, 896, 907, 895, '0', '2019-09-15 00:25:18', '2019-09-15 00:25:18', NULL),
(909, 890, '温度过高预警', '2', '60', '过高打开风扇', 892, 898, 910, 899, 911, 901, '1', '2019-09-16 13:34:05', '2019-09-16 13:34:05', NULL),
(910, 890, '温度过低预警', '0', '60', '低关闭风扇', 892, 898, 910, 899, 911, 901, '0', '2019-09-16 14:20:53', '2019-09-16 14:20:53', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_event_log`
--

CREATE TABLE `device_event_log` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '字段所属设备id',
  `device_event_id` int(10) UNSIGNED DEFAULT NULL COMMENT '设备事件id',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '事件名',
  `type` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 低于 1 等于 2 高于',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '用于比较的值',
  `log_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '实际传入的值',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '描述',
  `device_region_id` int(10) UNSIGNED DEFAULT NULL COMMENT '设备区域id',
  `device_room_id` int(10) UNSIGNED DEFAULT NULL COMMENT '设备房间id',
  `device_id` int(10) UNSIGNED NOT NULL COMMENT '字段所属设备id',
  `device_field_id` int(10) UNSIGNED NOT NULL COMMENT '事件设备字段id',
  `associated_device_id` int(10) UNSIGNED NOT NULL COMMENT '关联设备id(操作该设备)',
  `associated_device_field_id` int(11) NOT NULL COMMENT '关联设备字段id(操作该字段)',
  `operation_type` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 关闭 1打开(有继电开关的只能有一个字段，并且该字段是bool)',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_event_log`
--

INSERT INTO `device_event_log` (`id`, `device_event_id`, `user_id`, `name`, `type`, `value`, `log_value`, `desc`, `device_region_id`, `device_room_id`, `device_id`, `device_field_id`, `associated_device_id`, `associated_device_field_id`, `operation_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(907, NULL, 890, '温度过高降温', '0', '20', NULL, NULL, NULL, NULL, 908, 896, 907, 895, '1', '2019-09-14 23:38:04', '2019-09-14 23:38:04', NULL),
(908, NULL, 890, '温度过高预警', '2', '60', NULL, '过高打开风扇', 892, 898, 910, 899, 911, 901, '1', '2019-09-16 14:18:37', '2019-09-16 14:18:37', NULL),
(909, NULL, 890, '温度过高预警', '2', '61', NULL, '过高打开风扇', 892, 898, 910, 899, 911, 901, '1', '2019-09-16 14:19:07', '2019-09-16 14:19:07', NULL),
(910, NULL, 890, '温度过高预警', '2', '60', '61', '过高打开风扇', 892, 898, 910, 899, 911, 901, '1', '2019-09-16 14:19:45', '2019-09-16 14:19:45', NULL),
(911, NULL, 890, '温度过低预警', '0', '60', '50', '低关闭风扇', 892, 898, 910, 899, 911, 901, '0', '2019-09-16 14:21:12', '2019-09-16 14:21:12', NULL),
(912, NULL, 890, '温度过低预警', '0', '60', '50', '低关闭风扇', 892, 898, 910, 899, 911, 901, '0', '2019-09-16 14:24:08', '2019-09-16 14:24:08', NULL),
(913, NULL, 890, '温度过低预警', '0', '60', '50', '低关闭风扇', 892, 898, 910, 899, 911, 901, '0', '2019-09-16 14:24:15', '2019-09-16 14:24:15', NULL),
(914, NULL, 890, '温度过高预警', '2', '60', '500', '过高打开风扇', 892, 898, 910, 899, 911, 901, '1', '2019-09-17 00:49:57', '2019-09-17 00:49:57', NULL),
(915, NULL, 890, '温度过低预警', '0', '60', '20', '低关闭风扇', 892, 898, 910, 899, 911, 901, '0', '2019-09-17 00:51:51', '2019-09-17 00:51:51', NULL),
(916, NULL, 890, '温度过高预警', '2', '60', '500', '过高打开风扇', 892, 898, 910, 899, 911, 901, '1', '2019-09-17 00:52:11', '2019-09-17 00:52:11', NULL),
(917, NULL, 890, '温度过低预警', '0', '60', '10', '低关闭风扇', 892, 898, 910, 899, 911, 901, '0', '2019-09-22 22:51:25', '2019-09-22 22:51:25', NULL),
(918, NULL, 890, '温度过高预警', '2', '60', '61', '过高打开风扇', 892, 898, 910, 899, 911, 901, '1', '2019-09-22 22:51:56', '2019-09-22 22:51:56', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_field`
--

CREATE TABLE `device_field` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(11) UNSIGNED NOT NULL COMMENT '所属设备id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '功能名称',
  `field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '字段标识符(英文，等同于表字段名)',
  `field_type_id` int(11) UNSIGNED DEFAULT NULL COMMENT '字段类型id(number,varchar,int,enum等等(设置值的类型,如果是bool 那么就只能设置0,1)',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '字段值',
  `beyond_warning` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '超出预警',
  `below_warning` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '低于预警\r\n',
  `field_type_length` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '字段长度(0-255整型数字)',
  `common_field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '共同字段(如果一个设备有最高和最低的两个参数，通过共同字段把他们显示到一行,默认为空)',
  `common_field_sort` smallint(5) UNSIGNED DEFAULT NULL COMMENT '共同字段排序(显示到一行的先后顺序)',
  `desc` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '描述',
  `sort` smallint(5) DEFAULT NULL COMMENT '字段显示排序(字段显示先后排序(上面的是相同字段排序，这个是产品下字段的排序))',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_field`
--

INSERT INTO `device_field` (`id`, `device_id`, `name`, `field`, `field_type_id`, `value`, `beyond_warning`, `below_warning`, `field_type_length`, `common_field`, `common_field_sort`, `desc`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(889, 889, '测试1', 'aa1', 895, NULL, NULL, NULL, 0, '', 0, '', 0, '2019-08-29 08:32:50', '2019-08-29 08:32:50', NULL),
(890, 889, '测试2', 'aa2', 895, NULL, NULL, NULL, 0, '', 0, '', 0, '2019-08-29 08:36:35', '2019-08-29 08:36:35', NULL),
(891, 889, '测试3', 'aa3', 895, NULL, NULL, NULL, 0, '', 0, '', 0, '2019-08-29 08:37:53', '2019-08-29 08:37:53', NULL),
(892, 889, '测试1111', 'aa', 895, NULL, NULL, NULL, 0, '', 0, '', 0, '2019-08-29 08:38:01', '2019-08-29 08:42:53', NULL),
(894, 906, 'aaa', 'aaa', 898, '1', NULL, NULL, 1, '', 0, '', NULL, '2019-09-06 16:51:56', '2019-09-09 14:46:05', NULL),
(895, 907, '开关', 'open_status', 898, NULL, NULL, NULL, 1, '', 0, '开关字段', 1, '2019-09-14 23:28:23', '2019-09-14 23:28:23', NULL),
(896, 908, '低温度', 'bottom', 899, NULL, NULL, NULL, 10, '', 0, '', 0, '2019-09-14 23:28:37', '2019-09-14 23:28:37', NULL),
(897, 909, '高温度', 'top', 899, NULL, NULL, NULL, 10, '0', 0, '', 0, NULL, NULL, NULL),
(898, 909, '低温度', 'bottom', 899, NULL, NULL, NULL, 10, '0', 0, '', 0, NULL, NULL, NULL),
(899, 910, '高温度', 'top', 899, '61', NULL, NULL, 10, '0', 0, '', 0, '2019-09-16 11:50:46', '2019-09-22 22:51:56', NULL),
(900, 910, '低温度', 'bottom', 899, '20', NULL, NULL, 10, '0', 0, '', 0, '2019-09-16 11:50:46', '2019-09-22 22:49:44', NULL),
(901, 911, '开关', 'open_status', 898, '1', NULL, NULL, 1, '0', 0, '开关字段', 1, '2019-09-16 13:32:59', '2019-09-22 22:51:56', NULL),
(902, 912, '高温度', 'top', 899, '50', NULL, NULL, 10, '0', 0, '', 0, '2019-09-17 17:47:39', '2019-09-22 22:48:28', NULL),
(903, 912, '低温度', 'bottom', 899, '20', NULL, NULL, 10, '0', 0, '', 0, '2019-09-17 17:47:39', '2019-09-22 22:48:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_field_log`
--

CREATE TABLE `device_field_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(11) UNSIGNED NOT NULL COMMENT '所属设备id',
  `device_field_id` int(10) UNSIGNED DEFAULT NULL COMMENT '所属字段id',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '功能名称',
  `field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '字段标识符(英文，等同于表字段名)',
  `field_type_id` int(11) UNSIGNED DEFAULT NULL COMMENT '字段类型id(number,varchar,int,enum等等(设置值的类型,如果是bool 那么就只能设置0,1)',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '字段值',
  `field_type_length` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '字段长度(0-255整型数字)',
  `common_field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '共同字段(如果一个设备有最高和最低的两个参数，通过共同字段把他们显示到一行,默认为空)',
  `common_field_sort` smallint(5) UNSIGNED DEFAULT NULL COMMENT '共同字段排序(显示到一行的先后顺序)',
  `desc` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '描述',
  `sort` smallint(5) DEFAULT NULL COMMENT '字段显示排序(字段显示先后排序(上面的是相同字段排序，这个是产品下字段的排序))',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_field_log`
--

INSERT INTO `device_field_log` (`id`, `device_id`, `device_field_id`, `user_id`, `name`, `field`, `field_type_id`, `value`, `field_type_length`, `common_field`, `common_field_sort`, `desc`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(889, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 00:02:26', '2019-09-10 00:02:26', NULL),
(890, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 00:02:35', '2019-09-10 00:02:35', NULL),
(891, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 00:02:37', '2019-09-10 00:02:37', NULL),
(892, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 00:03:04', '2019-09-10 00:03:04', NULL),
(893, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 00:03:06', '2019-09-10 00:03:06', NULL),
(894, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 11:01:48', '2019-09-10 11:01:48', NULL),
(895, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 11:05:05', '2019-09-10 11:05:05', NULL),
(896, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 11:05:12', '2019-09-10 11:05:12', NULL),
(897, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 11:05:21', '2019-09-10 11:05:21', NULL),
(898, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 11:05:33', '2019-09-10 11:05:33', NULL),
(899, 906, 899, 890, 'aaa', 'aaa', 898, '1', 1, '', 0, '', 0, '2019-09-10 11:05:38', '2019-09-10 11:05:38', NULL),
(900, 910, 899, 890, '高温度', 'top', 899, '27', 10, '', 0, '', 0, '2019-09-16 17:00:20', '2019-09-16 13:00:20', NULL),
(901, 910, 899, 890, '低温度', 'bottom', 899, '16', 10, '', 0, '', 0, '2019-09-16 13:00:54', '2019-09-16 13:00:54', NULL),
(902, 910, 899, 890, '低温度', 'bottom', 899, '16', 10, '', 0, '', 0, '2019-09-16 13:01:33', '2019-09-16 13:01:33', NULL),
(903, 910, 899, 890, '低温度', 'bottom', 899, '16', 10, '', 0, '', 0, '2019-09-16 13:01:43', '2019-09-16 13:01:43', NULL),
(904, 910, 899, 890, '低温度', 'bottom', 899, '16', 10, '', 0, '', 0, '2019-09-16 13:02:59', '2019-09-16 13:02:59', NULL),
(905, 910, 900, 890, '低温度', 'bottom', 899, '16', 10, '', 0, '', 0, '2019-09-16 13:03:46', '2019-09-16 13:03:47', NULL),
(906, 910, 900, 890, '低温度', 'bottom', 899, '16', 10, '', 0, '', 0, '2019-09-16 13:03:57', '2019-09-16 13:03:57', NULL),
(907, 910, 900, 890, '低温度', 'bottom', 899, '16', 10, '', 0, '', 0, '2019-09-16 13:05:08', '2019-09-16 13:05:09', NULL),
(908, 910, 900, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 13:07:08', '2019-09-16 13:07:08', NULL),
(909, 910, 900, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 13:09:26', '2019-09-16 13:09:26', NULL),
(910, 910, 900, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 15:00:00', '2019-09-16 13:09:26', NULL),
(911, 910, 900, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 17:09:34', '2019-09-16 13:09:34', NULL),
(912, 910, 900, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 13:09:34', '2019-09-16 13:09:34', NULL),
(913, 910, 900, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 14:07:46', '2019-09-16 14:07:46', NULL),
(914, 910, 900, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:07:46', '2019-09-16 14:07:46', NULL),
(915, 910, 900, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 14:08:33', '2019-09-16 14:08:33', NULL),
(916, 910, 900, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:08:33', '2019-09-16 14:08:33', NULL),
(939, 910, 899, 890, '高温度', 'top', 899, '61', 10, '', 0, '', 0, '2019-09-16 14:18:37', '2019-09-16 14:18:37', NULL),
(940, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:18:37', '2019-09-16 14:18:37', NULL),
(941, 910, 899, 890, '高温度', 'top', 899, '61', 10, '', 0, '', 0, '2019-09-16 14:19:07', '2019-09-16 14:19:07', NULL),
(942, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:19:07', '2019-09-16 14:19:07', NULL),
(943, 910, 899, 890, '高温度', 'top', 899, '61', 10, '', 0, '', 0, '2019-09-16 14:19:45', '2019-09-16 14:19:45', NULL),
(944, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:19:45', '2019-09-16 14:19:45', NULL),
(945, 910, 899, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 14:21:12', '2019-09-16 14:21:12', NULL),
(946, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:21:12', '2019-09-16 14:21:12', NULL),
(947, 910, 899, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 14:24:08', '2019-09-16 14:24:08', NULL),
(948, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:24:08', '2019-09-16 14:24:08', NULL),
(949, 910, 899, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 14:24:15', '2019-09-16 14:24:15', NULL),
(950, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-16 14:24:15', '2019-09-16 14:24:15', NULL),
(951, 910, 899, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-16 14:24:45', '2019-09-16 14:24:45', NULL),
(952, 910, 899, 890, '低温度', 'bottom', 899, '35', 10, '', 0, '', 0, '2019-09-16 14:24:45', '2019-09-16 14:24:45', NULL),
(953, 910, 899, 890, '高温度', 'top', 899, '35', 10, '', 0, '', 0, '2019-09-16 14:30:45', '2019-09-16 14:30:45', NULL),
(954, 910, 899, 890, '低温度', 'bottom', 899, '35', 10, '', 0, '', 0, '2019-09-16 14:30:45', '2019-09-16 14:30:45', NULL),
(955, 910, 899, 890, '高温度', 'top', 899, '35', 10, '', 0, '', 0, '2019-09-17 00:49:57', '2019-09-17 00:49:57', NULL),
(956, 910, 899, 890, '低温度', 'bottom', 899, '35', 10, '', 0, '', 0, '2019-09-17 00:49:57', '2019-09-17 00:49:57', NULL),
(957, 910, 899, 890, '高温度', 'top', 899, '35', 10, '', 0, '', 0, '2019-09-17 00:51:05', '2019-09-17 00:51:05', NULL),
(958, 910, 899, 890, '低温度', 'bottom', 899, '35', 10, '', 0, '', 0, '2019-09-17 00:51:05', '2019-09-17 00:51:05', NULL),
(959, 910, 899, 890, '高温度', 'top', 899, '35', 10, '', 0, '', 0, '2019-09-17 00:51:51', '2019-09-17 00:51:51', NULL),
(960, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-17 00:51:51', '2019-09-17 00:51:51', NULL),
(961, 910, 899, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-17 00:52:03', '2019-09-17 00:52:03', NULL),
(962, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-17 00:52:03', '2019-09-17 00:52:03', NULL),
(963, 910, 899, 890, '高温度', 'top', 899, '500', 10, '', 0, '', 0, '2019-09-17 00:52:11', '2019-09-17 00:52:11', NULL),
(964, 910, 899, 890, '低温度', 'bottom', 899, '10', 10, '', 0, '', 0, '2019-09-17 00:52:11', '2019-09-17 00:52:11', NULL),
(965, 912, 902, 890, '高温度', 'top', 899, '1', 10, '', 0, '', 0, '2019-09-22 22:48:06', '2019-09-22 22:48:06', NULL),
(966, 912, 902, 890, '高温度', 'top', 899, '50', 10, '', 0, '', 0, '2019-09-22 22:48:28', '2019-09-22 22:48:28', NULL),
(967, 912, 903, 890, '低温度', 'bottom', 899, '20', 10, '', 0, '', 0, '2019-09-22 22:48:28', '2019-09-22 22:48:28', NULL),
(968, 910, 899, 890, '高温度', 'top', 899, '60', 10, '', 0, '', 0, '2019-09-22 22:49:09', '2019-09-22 22:49:09', NULL),
(969, 910, 900, 890, '低温度', 'bottom', 899, '20', 10, '', 0, '', 0, '2019-09-22 22:49:09', '2019-09-22 22:49:09', NULL),
(970, 910, 899, 890, '高温度', 'top', 899, '60', 10, '', 0, '', 0, '2019-09-22 22:49:15', '2019-09-22 22:49:15', NULL),
(971, 910, 900, 890, '低温度', 'bottom', 899, '30', 10, '', 0, '', 0, '2019-09-22 22:49:15', '2019-09-22 22:49:15', NULL),
(972, 910, 899, 890, '高温度', 'top', 899, '60', 10, '', 0, '', 0, '2019-09-22 22:49:44', '2019-09-22 22:49:44', NULL),
(973, 910, 900, 890, '低温度', 'bottom', 899, '20', 10, '', 0, '', 0, '2019-09-22 22:49:44', '2019-09-22 22:49:44', NULL),
(974, 910, 899, 890, '高温度', 'top', 899, '10', 10, '', 0, '', 0, '2019-09-22 22:51:25', '2019-09-22 22:51:25', NULL),
(975, 910, 900, 890, '低温度', 'bottom', 899, '20', 10, '', 0, '', 0, '2019-09-22 22:51:25', '2019-09-22 22:51:25', NULL),
(976, 910, 899, 890, '高温度', 'top', 899, '60', 10, '', 0, '', 0, '2019-09-22 22:51:48', '2019-09-22 22:51:48', NULL),
(977, 910, 900, 890, '低温度', 'bottom', 899, '20', 10, '', 0, '', 0, '2019-09-22 22:51:48', '2019-09-22 22:51:48', NULL),
(978, 910, 899, 890, '高温度', 'top', 899, '61', 10, '', 0, '', 0, '2019-09-22 22:51:56', '2019-09-22 22:51:56', NULL),
(979, 910, 900, 890, '低温度', 'bottom', 899, '20', 10, '', 0, '', 0, '2019-09-22 22:51:56', '2019-09-22 22:51:56', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_region`
--

CREATE TABLE `device_region` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '区域所属用户id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `province` int(10) UNSIGNED DEFAULT NULL COMMENT '省',
  `city` int(10) UNSIGNED DEFAULT NULL COMMENT '市',
  `area` int(10) UNSIGNED DEFAULT NULL COMMENT '区(县)',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_region`
--

INSERT INTO `device_region` (`id`, `user_id`, `name`, `province`, `city`, `area`, `created_at`, `updated_at`, `deleted_at`) VALUES
(889, 10, '巨101', NULL, NULL, NULL, '2019-08-28 08:15:19', '2019-08-28 09:57:16', NULL),
(891, 10, '111', NULL, NULL, NULL, '2019-08-27 21:02:20', '2019-08-27 21:02:20', NULL),
(892, 890, '山东省-济南市-市中区', 370000, 370100, 370103, '2019-09-01 16:33:18', '2019-09-14 16:59:51', NULL),
(896, 1, '济南-长青', NULL, NULL, NULL, '2019-09-03 07:50:28', '2019-09-03 07:55:41', NULL),
(897, 890, '河南省-郑州市-新密市', 410000, 410100, 410183, '2019-09-03 15:37:59', '2019-09-14 17:00:14', NULL),
(898, 890, '天津市-天津市辖县-蓟县', 120000, 120200, 120225, '2019-09-14 16:37:10', '2019-09-14 17:00:24', NULL),
(899, 890, '河北省-邯郸市-邯山区', 130000, 130400, 130402, '2019-09-14 16:45:47', '2019-09-14 16:57:54', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_room`
--

CREATE TABLE `device_room` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '房间所属用户id',
  `device_region_id` int(11) DEFAULT NULL COMMENT '区域id',
  `crop_class_id` int(10) UNSIGNED NOT NULL COMMENT '种植作物id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '房间描述',
  `token` char(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '唯一标识用来更新房间下的设备',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_room`
--

INSERT INTO `device_room` (`id`, `user_id`, `device_region_id`, `crop_class_id`, `name`, `desc`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(894, 10, 889, 3, 'c更新', NULL, 'RIPVZ82809285614738900A08983DF463AD954113A236617ADF50B4C25AD', '2019-08-28 16:21:25', '2019-08-28 16:21:25', NULL),
(895, 10, 889, 3, 'c更新s', NULL, 'RIWVG82809292829644588FBDC0D1C2FFF51E17AAABE823D148F074D8D5A', '2019-08-28 16:21:32', '2019-08-28 16:21:32', NULL),
(898, 890, 892, 2, '1号棚', '99999', 'VK0fOe64wsj2yjRJN0MfBB0BJTBsGmmeR0dqBbKHIfazy0Tgh2vGTU4X4eQi', '2019-09-03 15:49:05', '2019-09-09 22:57:02', NULL),
(899, 890, 897, 3, '2号棚', '', 'JnylyyHC5gucPwFHRzxIDVphDJyVIaui9NogJIoaW3Fi4xFPV3aRZSK1YAyJ', '2019-09-03 15:54:31', '2019-09-09 22:56:54', NULL),
(900, 890, 899, 3, '石家庄', '石家庄', 'xQ5vStUybe6xiotksxh546LRNqt1rFmBTRNbQx6knwxe5UXpoRF0BioMDEkn', '2019-09-17 17:47:21', '2019-09-17 17:47:21', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `field_type`
--

CREATE TABLE `field_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `field_type_length` tinyint(4) UNSIGNED DEFAULT '1' COMMENT '字段长度(0-255个字符)',
  `default` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '默认值',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '字段描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `field_type`
--

INSERT INTO `field_type` (`id`, `name`, `field_type_length`, `default`, `desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(898, 'bool', 1, '1', '布尔类型 0关 1开', '2019-09-03 16:57:32', '2019-09-03 17:12:20', NULL),
(899, 'integer', 10, '0', '整数类型', '2019-09-14 23:24:03', '2019-09-16 12:04:04', NULL),
(901, 'float', 10, '0', '浮点类型', '2019-09-16 12:03:08', '2019-09-16 12:03:57', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `login_notice`
--

CREATE TABLE `login_notice` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '登录通知内容',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '登录通知标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '登录通知内容',
  `type` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 每次登录通知 1 只显示一次 【如果每次登录通知则每次进入面板都会提示，如果只显示一次，则给每个用户发送一个通知(写入到系统消息)，当用户已读之后，则不再显示或删除该通知',
  `updated_at` datetime DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `login_notice`
--

INSERT INTO `login_notice` (`id`, `title`, `content`, `type`, `updated_at`, `created_at`) VALUES
(1, '智慧云平台欢迎您', '<p><b>&nbsp;&nbsp;&nbsp; 智慧云平台为您提供优质稳定的快捷服务，使您的设备快速上云。</b></p><p><b>&nbsp;&nbsp;&nbsp; 方便检测与动态响应，百万计数据零延迟。<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/1.gif\" alt=\"[嘻嘻]\"><br></b></p>', '0', '2019-09-16 17:35:28', '2019-09-15 13:06:59'),
(2, '测试', 'aaa<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/28.gif\" alt=\"[馋嘴]\">', '1', '2019-09-15 13:12:05', '2019-09-15 13:12:05'),
(3, 'aaa', 'aaaa', '1', '2019-09-15 13:12:20', '2019-09-15 13:12:20'),
(4, 'aaa', 'aaa', '1', '2019-09-15 13:13:13', '2019-09-15 13:13:13'),
(5, '平台欢迎您', '<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/8.gif\" alt=\"[挤眼]\">', '1', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(6, '使用指南', '<p><b>如有任何问题，请及时联系客服<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/0.gif\" alt=\"[微笑]\"></b></p><p align=\"right\"><b>大棚云平台欢迎您<br></b></p>', '0', '2019-09-16 17:35:18', '2019-09-16 17:21:33'),
(7, '付费通知', '请各位费用到期的客户请及时续费，到期后云平台不再提供服务，请知晓<img src=\"http://code9.com:8080/js/layui-v2.5.4/images/face/62.gif\" alt=\"[浮云]\">', '1', '2019-09-16 17:37:57', '2019-09-16 17:37:57');

-- --------------------------------------------------------

--
-- 表的结构 `login_notice_log`
--

CREATE TABLE `login_notice_log` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '登录通知日志内容',
  `login_notice_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 未查看 1 已查看',
  `updated_at` datetime DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `login_notice_log`
--

INSERT INTO `login_notice_log` (`id`, `login_notice_id`, `user_id`, `status`, `updated_at`, `created_at`) VALUES
(1, 4, 2, '0', NULL, NULL),
(2, 4, 3, '0', NULL, NULL),
(3, 4, 4, '0', NULL, NULL),
(4, 4, 7, '0', NULL, NULL),
(5, 4, 10, '0', NULL, NULL),
(6, 4, 11, '0', NULL, NULL),
(7, 4, 12, '0', NULL, NULL),
(8, 4, 13, '0', NULL, NULL),
(9, 4, 14, '0', NULL, NULL),
(10, 4, 15, '0', NULL, NULL),
(11, 4, 16, '0', NULL, NULL),
(12, 4, 17, '0', NULL, NULL),
(13, 4, 18, '0', NULL, NULL),
(14, 4, 19, '0', NULL, NULL),
(15, 4, 20, '0', NULL, NULL),
(16, 4, 21, '0', NULL, NULL),
(17, 4, 890, '1', '2019-09-16 17:43:44', NULL),
(18, 4, 891, '0', NULL, NULL),
(19, 4, 892, '0', NULL, NULL),
(20, 4, 893, '0', NULL, NULL),
(21, 4, 894, '0', NULL, NULL),
(22, 4, 895, '0', NULL, NULL),
(23, 4, 896, '0', NULL, NULL),
(24, 4, 897, '0', NULL, NULL),
(25, 4, 898, '0', NULL, NULL),
(26, 4, 899, '1', '2019-09-17 00:57:53', NULL),
(27, 5, 2, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(28, 5, 3, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(29, 5, 4, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(30, 5, 7, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(31, 5, 10, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(32, 5, 11, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(33, 5, 12, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(34, 5, 13, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(35, 5, 14, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(36, 5, 15, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(37, 5, 16, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(38, 5, 17, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(39, 5, 18, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(40, 5, 19, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(41, 5, 20, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(42, 5, 21, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(43, 5, 890, '1', '2019-09-16 17:43:44', '2019-09-15 13:38:33'),
(44, 5, 891, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(45, 5, 892, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(46, 5, 893, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(47, 5, 894, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(48, 5, 895, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(49, 5, 896, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(50, 5, 897, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(51, 5, 898, '0', '2019-09-15 13:38:33', '2019-09-15 13:38:33'),
(52, 5, 899, '1', '2019-09-17 00:57:53', '2019-09-15 13:38:33'),
(53, 7, 2, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(54, 7, 3, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(55, 7, 4, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(56, 7, 7, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(57, 7, 10, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(58, 7, 11, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(59, 7, 12, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(60, 7, 13, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(61, 7, 14, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(62, 7, 15, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(63, 7, 16, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(64, 7, 17, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(65, 7, 18, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(66, 7, 19, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(67, 7, 20, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(68, 7, 21, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(69, 7, 890, '1', '2019-09-16 17:38:43', '2019-09-16 17:37:57'),
(70, 7, 891, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(71, 7, 892, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(72, 7, 893, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(73, 7, 894, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(74, 7, 895, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(75, 7, 896, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(76, 7, 897, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(77, 7, 898, '0', '2019-09-16 17:37:57', '2019-09-16 17:37:57'),
(78, 7, 899, '1', '2019-09-17 00:57:53', '2019-09-16 17:37:57');

-- --------------------------------------------------------

--
-- 表的结构 `map`
--

CREATE TABLE `map` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '地图名',
  `code` int(11) NOT NULL COMMENT '地图代码',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属地图id',
  `created_at` datetime DEFAULT NULL,
  `deleted_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `pest_warning`
--

CREATE TABLE `pest_warning` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '病虫害预警标题',
  `type` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '病虫害预警类型 0 病虫害 1 天气预警',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间(选填)',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间(选填)',
  `warning` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '预警信息',
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '防止措施',
  `updated_at` datetime DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `pest_warning`
--

INSERT INTO `pest_warning` (`id`, `title`, `type`, `start_time`, `end_time`, `warning`, `content`, `updated_at`, `created_at`) VALUES
(1, '台风预警', '1', '2019-09-15 00:00:00', '2019-09-19 00:00:00', '山东省将迎来第一次台风', '请大家做好防水，排水的错误', '2019-09-15 09:08:44', '2019-09-15 09:08:44'),
(3, '美国白额', '0', '2019-09-15 00:00:00', NULL, '春季产软高峰请及时打药处理', '皮炎平两只', '2019-09-15 09:32:00', '2019-09-15 09:20:40'),
(5, 'aa', '0', NULL, NULL, 'aa', 'aa', '2019-09-15 09:46:40', '2019-09-15 09:46:40'),
(6, 'aaa', '0', NULL, NULL, 'aa', 'aa', '2019-09-15 09:48:12', '2019-09-15 09:48:12'),
(7, 'aa', '0', NULL, NULL, 'aa', 'aa', '2019-09-15 09:49:48', '2019-09-15 09:49:48'),
(8, 'aa', '0', NULL, NULL, 'aa', 'aa', '2019-09-15 09:51:26', '2019-09-15 09:51:26'),
(9, 'aa', '0', NULL, NULL, 'aa', 'aa', '2019-09-15 09:52:53', '2019-09-15 09:52:53'),
(10, 'aa', '0', NULL, NULL, 'aa', 'aa', '2019-09-15 09:55:15', '2019-09-15 09:55:15'),
(11, 'aa', '0', NULL, NULL, 'aa', 'aa', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(12, 'ceshi', '0', NULL, '2019-09-15 00:00:00', 'ceshi', 'ceshi', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(13, '测试系统消息', '1', '2019-09-17 00:00:00', '2019-09-17 00:00:00', '预警信息', '防治措施', '2019-09-17 00:41:11', '2019-09-17 00:41:11');

-- --------------------------------------------------------

--
-- 表的结构 `pest_warning_log`
--

CREATE TABLE `pest_warning_log` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '登录通知日志内容',
  `pest_warning_id` int(10) UNSIGNED DEFAULT NULL COMMENT '预警信息id',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 未查看 1 已查看',
  `updated_at` datetime DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `pest_warning_log`
--

INSERT INTO `pest_warning_log` (`id`, `pest_warning_id`, `user_id`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 1, '0', NULL, NULL),
(2, 1, 2, '0', NULL, NULL),
(3, 1, 3, '0', NULL, NULL),
(4, 1, 4, '0', NULL, NULL),
(5, 1, 7, '0', NULL, NULL),
(6, 1, 10, '0', NULL, NULL),
(7, 1, 11, '0', NULL, NULL),
(8, 1, 12, '0', NULL, NULL),
(9, 1, 13, '0', NULL, NULL),
(10, 1, 14, '0', NULL, NULL),
(11, 1, 15, '0', NULL, NULL),
(12, 1, 16, '0', NULL, NULL),
(13, 1, 17, '0', NULL, NULL),
(14, 1, 18, '0', NULL, NULL),
(15, 1, 19, '0', NULL, NULL),
(16, 1, 20, '0', NULL, NULL),
(17, 1, 21, '0', NULL, NULL),
(18, 1, 890, '1', '2019-09-15 10:52:50', NULL),
(19, 1, 891, '0', NULL, NULL),
(20, 1, 892, '0', NULL, NULL),
(21, 1, 893, '0', NULL, NULL),
(22, 1, 894, '0', NULL, NULL),
(23, 1, 895, '0', NULL, NULL),
(24, 1, 896, '0', NULL, NULL),
(25, 1, 897, '0', NULL, NULL),
(26, 1, 898, '0', NULL, NULL),
(27, 1, 899, '0', NULL, NULL),
(28, 11, 1, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(29, 11, 2, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(30, 11, 3, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(31, 11, 4, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(32, 11, 7, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(33, 11, 10, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(34, 11, 11, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(35, 11, 12, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(36, 11, 13, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(37, 11, 14, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(38, 11, 15, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(39, 11, 16, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(40, 11, 17, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(41, 11, 18, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(42, 11, 19, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(43, 11, 20, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(44, 11, 21, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(45, 11, 890, '1', '2019-09-15 10:55:07', '2019-09-15 09:58:37'),
(46, 11, 891, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(47, 11, 892, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(48, 11, 893, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(49, 11, 894, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(50, 11, 895, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(51, 11, 896, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(52, 11, 897, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(53, 11, 898, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(54, 11, 899, '0', '2019-09-15 09:58:37', '2019-09-15 09:58:37'),
(55, 12, 1, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(56, 12, 2, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(57, 12, 3, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(58, 12, 4, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(59, 12, 7, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(60, 12, 10, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(61, 12, 11, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(62, 12, 12, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(63, 12, 13, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(64, 12, 14, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(65, 12, 15, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(66, 12, 16, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(67, 12, 17, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(68, 12, 18, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(69, 12, 19, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(70, 12, 20, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(71, 12, 21, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(72, 12, 890, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(73, 12, 891, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(74, 12, 892, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(75, 12, 893, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(76, 12, 894, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(77, 12, 895, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(78, 12, 896, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(79, 12, 897, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(80, 12, 898, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(81, 12, 899, '0', '2019-09-15 10:58:17', '2019-09-15 10:58:17'),
(82, 13, 2, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(83, 13, 3, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(84, 13, 4, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(85, 13, 7, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(86, 13, 10, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(87, 13, 11, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(88, 13, 12, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(89, 13, 13, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(90, 13, 14, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(91, 13, 15, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(92, 13, 16, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(93, 13, 17, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(94, 13, 18, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(95, 13, 19, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(96, 13, 20, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(97, 13, 21, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(98, 13, 890, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(99, 13, 891, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(100, 13, 892, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(101, 13, 893, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(102, 13, 894, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(103, 13, 895, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(104, 13, 896, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(105, 13, 897, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(106, 13, 898, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11'),
(107, 13, 899, '0', '2019-09-17 00:41:11', '2019-09-17 00:41:11');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '产品名称',
  `desc` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `name`, `desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(889, '三路继电器', '双向电5v', '2019-08-28 14:47:28', '2019-09-03 17:36:08', NULL),
(891, '空气温度检测器', '', '2019-09-14 23:26:53', '2019-09-14 23:26:53', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product_field`
--

CREATE TABLE `product_field` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL COMMENT '所属产品id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '功能名称',
  `field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '字段标识符(英文，等同于表字段名)',
  `field_type_id` int(11) UNSIGNED DEFAULT NULL COMMENT '字段类型id(number,varchar,int,enum等等(设置值的类型,如果是bool 那么就只能设置开关)',
  `field_type_length` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '字段长度(0-255整型数字)',
  `default` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '字段默认值(0-255个字符)',
  `common_field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '共同字段(如果一个设备有最高和最低的两个参数，通过共同字段把他们显示到一行,默认为空)',
  `common_field_sort` smallint(5) UNSIGNED DEFAULT NULL COMMENT '共同字段排序(显示到一行的先后顺序)',
  `desc` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '描述',
  `sort` smallint(5) DEFAULT NULL COMMENT '字段显示排序(字段显示先后排序(上面的是相同字段排序，这个是产品下字段的排序))',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `product_field`
--

INSERT INTO `product_field` (`id`, `product_id`, `name`, `field`, `field_type_id`, `field_type_length`, `default`, `common_field`, `common_field_sort`, `desc`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(896, 889, '开关', 'open_status', 898, 1, '0', '0', 0, '开关字段', 1, '2019-09-06 15:05:56', '2019-09-14 23:25:35', NULL),
(897, 891, '高温度', 'top', 899, 10, '0', '0', 0, '', 0, '2019-09-14 23:27:33', '2019-09-14 23:27:33', NULL),
(898, 891, '低温度', 'bottom', 899, 10, '0', '0', 0, '', 0, '2019-09-14 23:27:55', '2019-09-14 23:27:55', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `system_msg`
--

CREATE TABLE `system_msg` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '登录通知日志内容',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户id',
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '通知内容(包含通知内容，文章就包含回复，预警就包含明确的预警信息)',
  `type` enum('0','1','2','3') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 天气预警 1 病虫害预警 2 设备预警 3 文章被回复',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '通知标题',
  `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '0 未查看 1 已查看',
  `updated_at` datetime DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `system_msg`
--

INSERT INTO `system_msg` (`id`, `user_id`, `content`, `type`, `title`, `status`, `updated_at`, `created_at`) VALUES
(1, 890, '文章《我有钱》', '1', '文章被评论', '1', '2019-09-15 23:49:18', NULL),
(2, 2, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(3, 3, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(4, 4, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(5, 7, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(6, 10, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(7, 11, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(8, 12, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(9, 13, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(10, 14, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(11, 15, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(12, 16, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(13, 17, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(14, 18, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(15, 19, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(16, 20, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(17, 21, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(18, 890, '防治措施', '0', '测试系统消息', '1', '2019-09-17 00:41:26', NULL),
(19, 891, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(20, 892, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(21, 893, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(22, 894, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(23, 895, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(24, 896, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(25, 897, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(26, 898, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(27, 899, '防治措施', '0', '测试系统消息', '0', NULL, NULL),
(28, 890, '事件名称：温度过高预警发生了字段: 高于阈值事件，请及时检查', '1', '高于阈值', '1', '2019-09-17 00:51:21', '2019-09-17 00:49:57'),
(29, 890, '事件名称：温度过低预警发生了字段: 低于阈值事件，请及时检查', '2', '低于阈值', '0', '2019-09-17 00:51:51', '2019-09-17 00:51:51'),
(30, 890, '事件名称：温度过高预警发生了字段: 高于阈值事件，请及时检查', '2', '高于阈值', '0', '2019-09-17 00:52:11', '2019-09-17 00:52:11'),
(31, 899, '您的文章：测试有新的用户评论，请及时查看', '3', '文章被回复', '1', '2019-09-17 00:58:06', '2019-09-17 00:57:41'),
(32, 890, '事件名称：温度过低预警发生了字段: 低于阈值事件，请及时检查', '2', '低于阈值', '0', '2019-09-22 22:51:25', '2019-09-22 22:51:25'),
(33, 890, '事件名称：温度过高预警发生了字段: 高于阈值事件，请及时检查', '2', '高于阈值', '0', '2019-09-22 22:51:56', '2019-09-22 22:51:56');

-- --------------------------------------------------------

--
-- 表的结构 `system_settings_group`
--

CREATE TABLE `system_settings_group` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '系统设置组id',
  `field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '设置组唯一标识',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '系统设置组名',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '系统设置组描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `system_settings_group`
--

INSERT INTO `system_settings_group` (`id`, `field`, `name`, `desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(900, 'system_config', '系统设置', NULL, '2019-09-16 00:22:51', '2019-09-17 00:10:53', NULL),
(901, 'alisms', '阿里云短信', '阿里云短信配置', '2019-09-23 00:36:06', '2019-09-23 00:36:06', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `system_settings_group_field`
--

CREATE TABLE `system_settings_group_field` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '系统设置组id',
  `system_settings_group_id` int(10) UNSIGNED NOT NULL COMMENT '默认为系统设置 id = 0 \r\n',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '系统设置字段名',
  `field` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '系统设置字段唯一标识符(英文)',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '系统设置组描述',
  `type` enum('0','1','2','3') CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '0' COMMENT '0 普通文本 1 文本域 2 单选 3 多选',
  `option` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '选项(如果是单选或多选，则本字段必填，选项以逗号分隔)',
  `value` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '如果是普通文本或文本域，则存储字符串。如果是单选或多选，则存储选项，以逗号隔开!!\r\n',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `system_settings_group_field`
--

INSERT INTO `system_settings_group_field` (`id`, `system_settings_group_id`, `name`, `field`, `desc`, `type`, `option`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(902, 900, 'name', 'name', NULL, '0', NULL, 'name', '2019-09-16 01:01:02', '2019-09-16 23:57:52', NULL),
(903, 901, 'accessKey', 'access_key', NULL, '0', NULL, 'LTAI4FtUitkigRgbjPg3iYsS', '2019-09-23 00:40:05', '2019-09-23 01:19:02', NULL),
(904, 901, 'accessSecret', 'access_secret', NULL, '0', NULL, 'MPYQmXnSSyV2WJmMbM2fuEIuM6Yk2n', '2019-09-23 00:40:36', '2019-09-23 01:18:51', NULL),
(905, 901, 'signName', 'sign_name', '签名名称', '0', NULL, '云蛙', '2019-09-23 00:41:01', '2019-09-23 01:18:39', NULL),
(906, 901, 'TemplateCode', 'template_code', '模板id', '0', NULL, 'SMS_174580706', '2019-09-23 01:16:14', '2019-09-23 01:17:58', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '删除时间',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `phone` char(11) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '手机号',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `token` char(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '唯一标识',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `phone`, `password`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '2', NULL, '2', NULL, NULL, NULL, NULL),
(3, '3', NULL, '3', NULL, NULL, NULL, NULL),
(4, '5', NULL, '5', NULL, NULL, NULL, NULL),
(7, '111', NULL, '111', NULL, '2019-08-26 11:31:44', '2019-08-26 11:31:44', NULL),
(10, 'aaaaaaaas', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:09:52', '2019-08-26 12:09:52', NULL),
(11, 'aaaaaaaass', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:12:00', '2019-08-26 12:12:00', NULL),
(12, 'aaaaaaaasss', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:20:19', '2019-08-26 12:20:19', NULL),
(13, 'aaaaaaaassss', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:20:54', '2019-08-26 12:20:54', NULL),
(14, 'aaaaaaaassssaaa', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:21:02', '2019-08-26 12:21:02', NULL),
(15, 'aaaa1a', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:22:03', '2019-08-26 12:22:03', NULL),
(16, 'aaaa1aa', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:22:19', '2019-08-26 12:22:19', NULL),
(17, 'aaaa1aaa', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:22:59', '2019-08-26 12:22:59', NULL),
(18, 'aaaa1aaaa', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:23:26', '2019-08-26 12:23:26', NULL),
(19, 'aaaa1aaaaa', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:26:05', '2019-08-26 12:26:05', NULL),
(20, 'aaaa1aaaaaa', NULL, 'aaaaaaaa', NULL, '2019-08-26 12:26:24', '2019-08-26 12:26:24', NULL),
(21, '与李磊李磊啊', NULL, 'aaaaaaaaa', NULL, '2019-08-26 13:12:45', '2019-08-26 13:12:45', NULL),
(890, '123456', '13800138020', '123456', '', '2019-09-01 08:46:59', '2019-09-23 00:35:25', NULL),
(891, '13800138000aa', NULL, '123456', 'RDUXK901277504889162399BA44E74C535BF872B34AF9BC730592159B204', '2019-09-01 08:49:10', '2019-09-01 08:49:10', NULL),
(892, '1380013800', NULL, '123456', 'RDPXF901277714788278B40EF66D9E9AFD20FA613B1C0C8E1E4D076CD058', '2019-09-01 08:49:31', '2019-09-01 08:49:31', NULL),
(893, '1366666', NULL, '123456', 'RDJYN901298793396053824AB1E25C61AF7975CD8A494892C4E978766995', '2019-09-01 09:24:39', '2019-09-01 09:24:39', NULL),
(894, '1380aaaa', NULL, '123456', 'RDCDA901301402836565F49854A5815948C4CA062A7E4522DA881B5052CC', '2019-09-01 09:29:00', '2019-09-01 09:29:00', NULL),
(895, '1380666666', NULL, '123456', 'RDQFW90130282197309308E08C2C7CB2445C70E2780183BFB1CB4D15868F', '2019-09-01 09:31:22', '2019-09-01 09:31:22', NULL),
(896, '13800asdasd', NULL, '123456', 'RDRJN9013051351832737B42AF7388306D085CD1668409F21E79E395E00F', '2019-09-01 09:35:13', '2019-09-01 09:35:13', NULL),
(897, '13800138000dsfdf', NULL, '123456', 'yjkVnbbdvSWcbfe4ZDtfC1GD5jkUDf8blS5aacP9D6f1avpw10R7edtt4dcD', '2019-09-01 09:35:44', '2019-09-11 12:33:12', NULL),
(898, '1389999', NULL, '123456', 'RDXLB90130621465222404D1D0F682178F9187B11625F05AEFD9D58377F3', '2019-09-01 09:37:01', '2019-09-01 09:37:01', NULL),
(899, '13808888', '13800138001', '13808888', 'ItZyoFsgzFb7dySY0TJ2Wpow7id34q8fgRmQVPIRYjuPyHYlsOitUVjNYMPg', '2019-09-01 09:37:38', '2019-09-20 23:17:52', NULL),
(900, '1234567', '13800138000', 'aaaaaa', '', '2019-09-20 23:08:36', '2019-09-20 23:12:45', NULL),
(901, '1380013', '13800138011', '13800138000', '', '2019-09-20 23:18:17', '2019-09-20 23:18:17', NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- 表的索引 `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `article_class`
--
ALTER TABLE `article_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `article_collection`
--
ALTER TABLE `article_collection`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `article_comment`
--
ALTER TABLE `article_comment`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `article_msg`
--
ALTER TABLE `article_msg`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `article_view`
--
ALTER TABLE `article_view`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `crop_class`
--
ALTER TABLE `crop_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `crop_traceability`
--
ALTER TABLE `crop_traceability`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `crop_traceability_batch`
--
ALTER TABLE `crop_traceability_batch`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `crop_traceability_event_log`
--
ALTER TABLE `crop_traceability_event_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- 表的索引 `device_event`
--
ALTER TABLE `device_event`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `device_event_log`
--
ALTER TABLE `device_event_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `device_field`
--
ALTER TABLE `device_field`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `device_field_log`
--
ALTER TABLE `device_field_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `device_region`
--
ALTER TABLE `device_region`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `device_room`
--
ALTER TABLE `device_room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- 表的索引 `field_type`
--
ALTER TABLE `field_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- 表的索引 `login_notice`
--
ALTER TABLE `login_notice`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `login_notice_log`
--
ALTER TABLE `login_notice_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `map`
--
ALTER TABLE `map`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `pest_warning`
--
ALTER TABLE `pest_warning`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `pest_warning_log`
--
ALTER TABLE `pest_warning_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `product_field`
--
ALTER TABLE `product_field`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `system_msg`
--
ALTER TABLE `system_msg`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `system_settings_group`
--
ALTER TABLE `system_settings_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `system_settings_group_field`
--
ALTER TABLE `system_settings_group_field`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `field` (`field`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '删除时间', AUTO_INCREMENT=901;

--
-- 使用表AUTO_INCREMENT `article`
--
ALTER TABLE `article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `article_class`
--
ALTER TABLE `article_class`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `article_collection`
--
ALTER TABLE `article_collection`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `article_comment`
--
ALTER TABLE `article_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `article_msg`
--
ALTER TABLE `article_msg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `article_view`
--
ALTER TABLE `article_view`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `crop_class`
--
ALTER TABLE `crop_class`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `crop_traceability`
--
ALTER TABLE `crop_traceability`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `crop_traceability_batch`
--
ALTER TABLE `crop_traceability_batch`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '收获批次(系统填充)', AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `crop_traceability_event_log`
--
ALTER TABLE `crop_traceability_event_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `device`
--
ALTER TABLE `device`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=913;

--
-- 使用表AUTO_INCREMENT `device_event`
--
ALTER TABLE `device_event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '字段所属设备id', AUTO_INCREMENT=911;

--
-- 使用表AUTO_INCREMENT `device_event_log`
--
ALTER TABLE `device_event_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '字段所属设备id', AUTO_INCREMENT=919;

--
-- 使用表AUTO_INCREMENT `device_field`
--
ALTER TABLE `device_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=904;

--
-- 使用表AUTO_INCREMENT `device_field_log`
--
ALTER TABLE `device_field_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=980;

--
-- 使用表AUTO_INCREMENT `device_region`
--
ALTER TABLE `device_region`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=900;

--
-- 使用表AUTO_INCREMENT `device_room`
--
ALTER TABLE `device_room`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=901;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=902;

--
-- 使用表AUTO_INCREMENT `login_notice`
--
ALTER TABLE `login_notice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '登录通知内容', AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `login_notice_log`
--
ALTER TABLE `login_notice_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '登录通知日志内容', AUTO_INCREMENT=79;

--
-- 使用表AUTO_INCREMENT `pest_warning`
--
ALTER TABLE `pest_warning`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `pest_warning_log`
--
ALTER TABLE `pest_warning_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '登录通知日志内容', AUTO_INCREMENT=108;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=892;

--
-- 使用表AUTO_INCREMENT `product_field`
--
ALTER TABLE `product_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=899;

--
-- 使用表AUTO_INCREMENT `system_msg`
--
ALTER TABLE `system_msg`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '登录通知日志内容', AUTO_INCREMENT=34;

--
-- 使用表AUTO_INCREMENT `system_settings_group`
--
ALTER TABLE `system_settings_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '系统设置组id', AUTO_INCREMENT=902;

--
-- 使用表AUTO_INCREMENT `system_settings_group_field`
--
ALTER TABLE `system_settings_group_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '系统设置组id', AUTO_INCREMENT=907;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '删除时间', AUTO_INCREMENT=902;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
