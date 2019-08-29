-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-08-29 06:54:02
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
  `length` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '字段长度(0-255整型数字)',
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
-- 表的结构 `device_field_log`
--

CREATE TABLE `device_field_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(11) UNSIGNED NOT NULL COMMENT '所属设备id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '功能名称',
  `field` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '字段标识符(英文，等同于表字段名)',
  `field_type_id` int(11) UNSIGNED DEFAULT NULL COMMENT '字段类型id(number,varchar,int,enum等等(设置值的类型,如果是bool 那么就只能设置0,1)',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '字段值',
  `length` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '字段长度(0-255整型数字)',
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
(891, 10, '111', '2019-08-27 21:02:20', '2019-08-27 21:02:20', NULL);

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
(895, 10, 889, 'c更新s', NULL, 'RIWVG82809292829644588FBDC0D1C2FFF51E17AAABE823D148F074D8D5A', '2019-08-28 16:21:32', '2019-08-28 16:21:32', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `field_type`
--

CREATE TABLE `field_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `length` tinyint(4) UNSIGNED DEFAULT '1' COMMENT '字段长度(0-255个字符)',
  `default` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '默认值',
  `desc` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '字段描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `field_type`
--

INSERT INTO `field_type` (`id`, `name`, `length`, `default`, `desc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(890, 'aas', 255, '', NULL, '2019-08-27 19:51:05', '2019-08-27 19:51:05', NULL),
(891, 'aasa', 1, '', NULL, '2019-08-27 19:51:42', '2019-08-27 19:51:42', NULL),
(892, 'aasaa', 1, '', '测试使用的字段', '2019-08-27 19:57:13', '2019-08-27 19:57:13', NULL),
(893, '巨101', 1, '', '', '2019-08-28 11:16:47', '2019-08-28 11:16:47', NULL),
(895, 'a0aaaa', 1, '', '', '2019-08-28 12:51:50', '2019-08-28 12:51:50', NULL),
(896, 'ceshi', 1, '', '', '2019-08-28 12:52:12', '2019-08-28 12:52:12', NULL),
(897, 'ceshis', 1, '', '', '2019-08-28 12:52:28', '2019-08-28 12:52:28', NULL);

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
(889, 'ceshisa', '1111', '2019-08-28 14:47:28', '2019-08-28 14:47:28', NULL);

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
  `length` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '字段长度(0-255整型数字)',
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

INSERT INTO `product_field` (`id`, `product_id`, `name`, `field`, `field_type_id`, `length`, `default`, `common_field`, `common_field_sort`, `desc`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(890, 889, '测试1', 'aa1', 890, 0, '', '', 0, '', 0, '2019-08-28 18:13:25', '2019-08-28 18:13:25', NULL);

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
(21, '与李磊李磊啊', 'aaaaaaaaa', NULL, '2019-08-26 13:12:45', '2019-08-26 13:12:45', NULL);

--
-- 转储表的索引
--

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- 表的索引 `device_room`
--
ALTER TABLE `device_room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
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
-- 使用表AUTO_INCREMENT `device`
--
ALTER TABLE `device`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `device_field`
--
ALTER TABLE `device_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `device_field_log`
--
ALTER TABLE `device_field_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `device_region`
--
ALTER TABLE `device_region`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=892;

--
-- 使用表AUTO_INCREMENT `device_room`
--
ALTER TABLE `device_room`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=896;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=898;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=891;

--
-- 使用表AUTO_INCREMENT `product_field`
--
ALTER TABLE `product_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=891;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '删除时间', AUTO_INCREMENT=890;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
