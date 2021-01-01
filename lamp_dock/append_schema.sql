-- 購入履歴 --
-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 1 月 01 日 04:27
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `Purchase_history`
--

CREATE TABLE `Purchase_history` (
  `id` int(11) NOT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `Purchase_history`
--
ALTER TABLE `Purchase_history`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `Purchase_history`
--
ALTER TABLE `Purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


-- 購入明細 --
-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2021 年 1 月 01 日 04:21
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `Purchase_details`
--

CREATE TABLE `Purchase_details` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `Purchase_history` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT '0',
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `Purchase_details`
--
ALTER TABLE `Purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `Purchase_details`
--
ALTER TABLE `Purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;





