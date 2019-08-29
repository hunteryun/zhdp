-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2019-08-27 09:53:28
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
  `device_region_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '设备区域id',
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

-- --------------------------------------------------------

--
-- 表的结构 `field_type`
--

CREATE TABLE `field_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '字段类型名字',
  `desc` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '字段描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `product_field`
--
ALTER TABLE `product_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=889;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '删除时间', AUTO_INCREMENT=889;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
