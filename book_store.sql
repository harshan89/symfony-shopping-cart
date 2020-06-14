/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : book_store

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-06-15 00:01:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for book
-- ----------------------------
DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBE5A33112469DE2` (`category_id`),
  CONSTRAINT `FK_CBE5A33112469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of book
-- ----------------------------
INSERT INTO `book` VALUES ('1', '1', 'Where the Wild Things Are', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1384434560l/19543.jpg', 'Maurice Bernard Sendak was an American writer and illustrator of children\'s literature who is best known for his book Where the Wild Things Are, published in 1963. An elementary school (from kindergarten to grade five) in North Hollywood, California is named in his honor.', 'Maurice Sendak', '100');
INSERT INTO `book` VALUES ('2', '1', 'The Giving Tree', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1174210942l/370493._SX318_.jpg', 'So begins a story of unforgettable perception, beautifully written and illustrated by the gifted and versatile Shel Silverstein.\r\n\r\nEvery day the boy would come to the tree to eat her apples, swing from her branches, or slide down her trunk...and the tree was happy. But as the boy grew older he began to want more from the tr', 'Shel Silverstein', '150');
INSERT INTO `book` VALUES ('3', '1', 'Green Eggs and Ham', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1468680100l/23772.jpg', '“Do you like green eggs and ham?” asks Sam-I-am in this Beginner Book by Dr. Seuss. In a house or with a mouse? In a boat or with a goat? On a train or in a tree? Sam keeps asking persistently. With unmistakable characters and signature rhymes, Dr. Seuss’s beloved favorite has cemented its place as a children’s classic. In this most famous of cumulative tales,', 'Dr. Seuss', '200');
INSERT INTO `book` VALUES ('4', '1', 'Charlotte\'s Web', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1439632243l/24178._SY475_.jpg', 'This beloved book by E. B. White, author of Stuart Little and The Trumpet of the Swan, is a classic of children\'s literature that is \"just about perfect.\" This high-quality paperback features vibrant illustrations colorized by Rosemary Wells!', 'E.B. White, Garth Williams ', '50');
INSERT INTO `book` VALUES ('5', '1', 'The Cat in the Hat', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1468890477l/233093._SX318_.jpg', 'Poor Sally and her brother. It\'s cold and wet and they\'re stuck in the house with nothing to do . . . until a giant cat in a hat shows up, transforming the dull day into a madcap adventure and almost wrecking the place in the process! Written by Dr. Seuss in 1957 in response to the concern that \"pallid primers [with] abnormally courteous,', 'Dr. Seuss', '100');
INSERT INTO `book` VALUES ('6', '2', 'The Jane Austen Society', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1568730506l/43557477.jpg', 'Just after the Second World War, in the small English village of Chawton, an unusual but like-minded group of people band together to attempt something remarkable.\r\n\r\nOne hundred and fifty years ago, Chawton was the final home of Jane Austen, one of England\'s finest novelists. Now it\'s home to a few distant relatives and their diminishing estate.', 'Natalie Jenner', '100');
INSERT INTO `book` VALUES ('7', '2', 'Clap When You Land', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1592050167l/43892137._SY475_.jpg', 'Camino Rios lives for the summers when her father visits her in the Dominican Republic. But this time, on the day when his plane is supposed to land, Camino arrives at the airport to see crowds of crying people', 'Elizabeth Acevedo', '400');
INSERT INTO `book` VALUES ('8', '2', 'Rodham', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1580749557l/50253429.jpg', 'From the New York Times bestselling author of American Wife and Eligible, a novel that imagines a deeply compelling what-might-have-been: What if Hillary Rodham hadn’t married Bill Clinton?', 'Curtis Sittenfeld', '200');
INSERT INTO `book` VALUES ('9', '2', 'Shakespeare for Squirrels', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1573836756l/52216445._SX318_SY475_.jpg', 'Shakespeare meets Dashiell Hammett in this wildly entertaining murder mystery from New York Times bestselling author Christopher Moore—an uproarious, hardboiled take on the Bard’s most performed play, A Midsummer Night’s Dream, featuring Pocket, the hero of Fool and The Serpent of Venice, along with his sidekick, Drool, and pet monkey, Jeff.', 'Christopher Moore', '200');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', 'Children');
INSERT INTO `category` VALUES ('2', 'Fiction');

-- ----------------------------
-- Table structure for migration_versions
-- ----------------------------
DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migration_versions
-- ----------------------------
INSERT INTO `migration_versions` VALUES ('20200613173747', '2020-06-13 17:39:28');
INSERT INTO `migration_versions` VALUES ('20200613180129', '2020-06-13 18:01:41');
INSERT INTO `migration_versions` VALUES ('20200614063127', '2020-06-14 06:31:39');
