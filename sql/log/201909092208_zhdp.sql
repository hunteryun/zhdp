-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-09-09 14:07:17
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
-- 表的结构 `crop_class`
--

CREATE TABLE `crop_class` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '作物名字',
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
(906, 890, 889, 898, 'aa', 'aa', '5TbPvRLN9iIhCA3xDsHMVYmarvSRWJ9yHDxI6Er2fscDispajCNBOUBaz6QT', '2019-09-06 16:51:56', '2019-09-06 16:51:56', NULL);

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

INSERT INTO `device_field` (`id`, `device_id`, `name`, `field`, `field_type_id`, `value`, `field_type_length`, `common_field`, `common_field_sort`, `desc`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(889, 889, '测试1', 'aa1', 895, NULL, 0, '', 0, '', 0, '2019-08-29 08:32:50', '2019-08-29 08:32:50', NULL),
(890, 889, '测试2', 'aa2', 895, NULL, 0, '', 0, '', 0, '2019-08-29 08:36:35', '2019-08-29 08:36:35', NULL),
(891, 889, '测试3', 'aa3', 895, NULL, 0, '', 0, '', 0, '2019-08-29 08:37:53', '2019-08-29 08:37:53', NULL),
(892, 889, '测试1111', 'aa', 895, NULL, 0, '', 0, '', 0, '2019-08-29 08:38:01', '2019-08-29 08:42:53', NULL),
(894, 906, 'aaa', 'aaa', 898, '1', 1, '', 0, '', NULL, '2019-09-06 16:51:56', '2019-09-09 14:46:05', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_field_log`
--

CREATE TABLE `device_field_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(11) UNSIGNED NOT NULL COMMENT '所属设备id',
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

-- --------------------------------------------------------

--
-- 表的结构 `device_region`
--

CREATE TABLE `device_region` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '区域所属用户id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_region`
--

INSERT INTO `device_region` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(889, 10, '巨101', '2019-08-28 08:15:19', '2019-08-28 09:57:16', NULL),
(891, 10, '111', '2019-08-27 21:02:20', '2019-08-27 21:02:20', NULL),
(892, 890, '济南', '2019-09-01 16:33:18', '2019-09-03 15:37:44', NULL),
(896, 1, '济南-长青', '2019-09-03 07:50:28', '2019-09-03 07:55:41', NULL),
(897, 890, '郑州', '2019-09-03 15:37:59', '2019-09-03 15:37:59', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `device_room`
--

CREATE TABLE `device_room` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '房间所属用户id',
  `device_region_id` int(11) DEFAULT NULL COMMENT '区域id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `desc` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '房间描述',
  `token` char(60) COLLATE utf8_bin DEFAULT NULL COMMENT '唯一标识用来更新房间下的设备',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `device_room`
--

INSERT INTO `device_room` (`id`, `user_id`, `device_region_id`, `name`, `desc`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(894, 10, 889, 'c更新', NULL, 'RIPVZ82809285614738900A08983DF463AD954113A236617ADF50B4C25AD', '2019-08-28 16:21:25', '2019-08-28 16:21:25', NULL),
(895, 10, 889, 'c更新s', NULL, 'RIWVG82809292829644588FBDC0D1C2FFF51E17AAABE823D148F074D8D5A', '2019-08-28 16:21:32', '2019-08-28 16:21:32', NULL),
(898, 890, 892, '张明阳', '老同学', 'VK0fOe64wsj2yjRJN0MfBB0BJTBsGmmeR0dqBbKHIfazy0Tgh2vGTU4X4eQi', '2019-09-03 15:49:05', '2019-09-03 15:49:13', NULL),
(899, 890, 897, '农大', '', 'JnylyyHC5gucPwFHRzxIDVphDJyVIaui9NogJIoaW3Fi4xFPV3aRZSK1YAyJ', '2019-09-03 15:54:31', '2019-09-03 15:54:31', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `field_type`
--

CREATE TABLE `field_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `field_type_length` tinyint(4) UNSIGNED DEFAULT '1' COMMENT '字段长度(0-255个字符)',
  `default` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '默认值',
  `desc` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '字段描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `field_type`
--

INSERT INTO `field_type` (`id`, `name`, `field_type_length`, `default`, `desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(898, 'bool', 1, '1', '{0:true,1:false}', '2019-09-03 16:57:32', '2019-09-03 17:12:20', NULL);

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
(889, '三路继电器', '双向电5v', '2019-08-28 14:47:28', '2019-09-03 17:36:08', NULL);

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
  `default` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '字段默认值(0-255个字符)',
  `common_field` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '共同字段(如果一个设备有最高和最低的两个参数，通过共同字段把他们显示到一行,默认为空)',
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
(896, 889, 'aaa', 'aaa', 898, 1, 'aaa', 'aaa', 0, '测试', 1, '2019-09-06 15:05:56', '2019-09-06 15:22:28', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '删除时间',
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `password` char(32) COLLATE utf8_bin NOT NULL,
  `token` char(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '唯一标识',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', '1', NULL, NULL, NULL, NULL),
(2, '2', '2', NULL, NULL, NULL, NULL),
(3, '3', '3', NULL, NULL, NULL, NULL),
(4, '5', '5', NULL, NULL, NULL, NULL),
(7, '111', '111', NULL, '2019-08-26 11:31:44', '2019-08-26 11:31:44', NULL),
(10, 'aaaaaaaas', 'aaaaaaaa', NULL, '2019-08-26 12:09:52', '2019-08-26 12:09:52', NULL),
(11, 'aaaaaaaass', 'aaaaaaaa', NULL, '2019-08-26 12:12:00', '2019-08-26 12:12:00', NULL),
(12, 'aaaaaaaasss', 'aaaaaaaa', NULL, '2019-08-26 12:20:19', '2019-08-26 12:20:19', NULL),
(13, 'aaaaaaaassss', 'aaaaaaaa', NULL, '2019-08-26 12:20:54', '2019-08-26 12:20:54', NULL),
(14, 'aaaaaaaassssaaa', 'aaaaaaaa', NULL, '2019-08-26 12:21:02', '2019-08-26 12:21:02', NULL),
(15, 'aaaa1a', 'aaaaaaaa', NULL, '2019-08-26 12:22:03', '2019-08-26 12:22:03', NULL),
(16, 'aaaa1aa', 'aaaaaaaa', NULL, '2019-08-26 12:22:19', '2019-08-26 12:22:19', NULL),
(17, 'aaaa1aaa', 'aaaaaaaa', NULL, '2019-08-26 12:22:59', '2019-08-26 12:22:59', NULL),
(18, 'aaaa1aaaa', 'aaaaaaaa', NULL, '2019-08-26 12:23:26', '2019-08-26 12:23:26', NULL),
(19, 'aaaa1aaaaa', 'aaaaaaaa', NULL, '2019-08-26 12:26:05', '2019-08-26 12:26:05', NULL),
(20, 'aaaa1aaaaaa', 'aaaaaaaa', NULL, '2019-08-26 12:26:24', '2019-08-26 12:26:24', NULL),
(21, '与李磊李磊啊', 'aaaaaaaaa', NULL, '2019-08-26 13:12:45', '2019-08-26 13:12:45', NULL),
(890, '13800138000', '123456', 'l6EquRPR9XOKNKQjSrBSP2KfFvcKuN9sHhH73C86yxwOX7rK633dvqs6e5fs', '2019-09-01 08:46:59', '2019-09-09 17:00:04', NULL),
(891, '13800138000aa', '123456', 'RDUXK901277504889162399BA44E74C535BF872B34AF9BC730592159B204', '2019-09-01 08:49:10', '2019-09-01 08:49:10', NULL),
(892, '1380013800', '123456', 'RDPXF901277714788278B40EF66D9E9AFD20FA613B1C0C8E1E4D076CD058', '2019-09-01 08:49:31', '2019-09-01 08:49:31', NULL),
(893, '1366666', '123456', 'RDJYN901298793396053824AB1E25C61AF7975CD8A494892C4E978766995', '2019-09-01 09:24:39', '2019-09-01 09:24:39', NULL),
(894, '1380aaaa', '123456', 'RDCDA901301402836565F49854A5815948C4CA062A7E4522DA881B5052CC', '2019-09-01 09:29:00', '2019-09-01 09:29:00', NULL),
(895, '1380666666', '123456', 'RDQFW90130282197309308E08C2C7CB2445C70E2780183BFB1CB4D15868F', '2019-09-01 09:31:22', '2019-09-01 09:31:22', NULL),
(896, '13800asdasd', '123456', 'RDRJN9013051351832737B42AF7388306D085CD1668409F21E79E395E00F', '2019-09-01 09:35:13', '2019-09-01 09:35:13', NULL),
(897, '13800138000dsfdf', '123456', 'RDWJS9013054495001847057A8A3E1C3D7FA464429D1EB01E1204696455C', '2019-09-01 09:35:44', '2019-09-01 09:35:44', NULL),
(898, '1389999', '123456', 'RDXLB90130621465222404D1D0F682178F9187B11625F05AEFD9D58377F3', '2019-09-01 09:37:01', '2019-09-01 09:37:01', NULL),
(899, '13808888', '123456', 'RDILM9013065831393602CAF679BB750A2BA750F392A22D4D9C37B762CAB', '2019-09-01 09:37:38', '2019-09-01 09:37:38', NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `crop_class`
--
ALTER TABLE `crop_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

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
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `crop_class`
--
ALTER TABLE `crop_class`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `device`
--
ALTER TABLE `device`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=907;

--
-- 使用表AUTO_INCREMENT `device_field`
--
ALTER TABLE `device_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=895;

--
-- 使用表AUTO_INCREMENT `device_field_log`
--
ALTER TABLE `device_field_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `device_region`
--
ALTER TABLE `device_region`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=898;

--
-- 使用表AUTO_INCREMENT `device_room`
--
ALTER TABLE `device_room`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=900;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=899;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=891;

--
-- 使用表AUTO_INCREMENT `product_field`
--
ALTER TABLE `product_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=897;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '删除时间', AUTO_INCREMENT=900;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
