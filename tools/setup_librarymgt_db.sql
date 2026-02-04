-- ===================================================================
-- NUKEVIET LIBRARY MANAGEMENT MODULE - DATABASE SETUP
-- Database: nukeviet99
-- Prefix: nv5
-- Language: vi
-- ===================================================================

-- ===================================================================
-- 1. CREATE TABLES
-- ===================================================================

-- Categories Table
CREATE TABLE IF NOT EXISTS `nv5_vi_librarymgt_categories` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `alias` VARCHAR(255) NOT NULL DEFAULT '',
  `description` TEXT NULL,
  `weight` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  `status` TINYINT(3) UNSIGNED NOT NULL DEFAULT 1,
  `add_time` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `edit_time` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_alias` (`alias`),
  KEY `idx_status` (`status`),
  KEY `idx_weight` (`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Books Table
CREATE TABLE IF NOT EXISTS `nv5_vi_librarymgt_books` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_id` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` VARCHAR(255) NOT NULL,
  `alias` VARCHAR(255) NOT NULL DEFAULT '',
  `author` VARCHAR(255) NOT NULL DEFAULT '',
  `publisher` VARCHAR(255) NOT NULL DEFAULT '',
  `publish_year` SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  `isbn` VARCHAR(50) NOT NULL DEFAULT '',
  `quantity` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `description` MEDIUMTEXT NULL,
  `image` VARCHAR(255) NOT NULL DEFAULT '',
  `status` TINYINT(3) UNSIGNED NOT NULL DEFAULT 1,
  `add_time` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `edit_time` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_alias` (`alias`),
  KEY `idx_cat` (`cat_id`),
  KEY `idx_status` (`status`),
  KEY `idx_quantity` (`quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Borrows Table
CREATE TABLE IF NOT EXISTS `nv5_vi_librarymgt_borrows` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `request_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approve_date` DATETIME NULL,
  `borrow_date` DATETIME NULL,
  `due_date` DATETIME NULL,
  `return_date` DATETIME NULL,
  `status` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
  `note_user` VARCHAR(255) NOT NULL DEFAULT '',
  `note_admin` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_book` (`book_id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_due` (`due_date`),
  KEY `idx_user_status` (`user_id`, `status`),
  KEY `idx_status_due` (`status`, `due_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================
-- 2. INSERT SAMPLE DATA
-- ===================================================================

-- Insert Categories
INSERT INTO `nv5_vi_librarymgt_categories` 
(`title`, `alias`, `description`, `weight`, `status`, `add_time`, `edit_time`) 
VALUES 
('Văn Học', 'van-hoc', 'Sách văn học Việt Nam và thế giới', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Khoa Học', 'khoa-hoc', 'Sách khoa học tự nhiên, vật lý, hóa học', 2, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Lịch Sử', 'lich-su', 'Sách lịch sử, tiểu sử nhân vật', 3, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Công Nghệ', 'cong-nghe', 'Sách về lập trình, công nghệ thông tin', 4, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tâm Lý Học', 'tam-ly-hoc', 'Sách về tâm lý, kỹ năng sống', 5, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- Insert Books
INSERT INTO `nv5_vi_librarymgt_books` 
(`cat_id`, `title`, `alias`, `author`, `publisher`, `publish_year`, `isbn`, `quantity`, `description`, `image`, `status`, `add_time`, `edit_time`) 
VALUES 
(1, 'Truyện Kiều', 'truyen-kieu', 'Nguyễn Du', 'NXB Văn Học', 1991, '978-603-06-0123-1', 5, 'Tác phẩm kinh điển của Nguyễn Du - niên biểu của văn học Việt Nam', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(1, 'Chuyện Người Đàn Bà', 'chuyen-nguoi-dan-ba', 'Kim Lân', 'NXB Văn Học', 1998, '978-603-06-0123-2', 3, 'Tác phẩm văn học đương đại nổi bật của Kim Lân', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(1, 'Tắt Đèn', 'tat-den', 'Ngô Tất Tố', 'NXB Văn Học', 2000, '978-603-06-0123-9', 4, 'Tiểu thuyết xã hội chủ nghĩa cổ điển của Ngô Tất Tố', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Thuyết Tiến Hóa', 'thuyet-tien-hoa', 'Charles Darwin', 'NXB Khoa Học', 2010, '978-603-06-0123-3', 4, 'Lý thuyết nền tảng của sinh học hiện đại', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Mở Tầm Hiểu Biết', 'mo-tam-hieu-biet', 'Carl Sagan', 'NXB Thế Giới', 2015, '978-603-06-0123-4', 2, 'Khám phá vũ trụ và các bí ẩn khoa học', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 'Vật Lý Lượng Tử', 'vat-ly-luong-tu', 'Brian Greene', 'NXB Khoa Học Kỹ Thuật', 2012, '978-603-06-0123-10', 3, 'Giải thích dễ hiểu về vật lý lượng tử', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, 'Lịch Sử Việt Nam', 'lich-su-viet-nam', 'Trần Trọng Kim', 'NXB Giáo Dục', 2005, '978-603-06-0123-5', 6, 'Toàn cảnh lịch sử Việt Nam từ xưa đến nay', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, 'Những Năm Tháng Quá Khứ', 'nhung-nam-thang-qua-khu', 'Hồ Chí Minh', 'NXB Sự Thật', 2020, '978-603-06-0123-11', 5, 'Tự truyện và hồi ký của Chủ tịch Hồ Chí Minh', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 'Clean Code', 'clean-code', 'Robert Martin', 'Prentice Hall', 2008, '0132350882', 5, 'Hướng dẫn viết code sạch, dễ bảo trì và mở rộng', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 'Design Patterns', 'design-patterns', 'Gang of Four', 'Addison-Wesley', 1994, '0201633612', 3, 'Các mẫu thiết kế trong lập trình hướng đối tượng', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 'The Pragmatic Programmer', 'the-pragmatic-programmer', 'David Thomas, Andrew Hunt', 'Addison-Wesley', 1999, '0135957052', 4, 'Bí quyết trở thành lập trình viên giỏi', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(5, 'Tư Duy Nhanh và Chậm', 'tu-duy-nhanh-va-cham', 'Daniel Kahneman', 'NXB Tổng Hợp', 2013, '978-603-06-0123-6', 4, 'Khoa học về cách chúng ta suy nghĩ và ra quyết định', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(5, 'Thói Quen Lấy Lại Cuộc Đời', 'thoi-quan-lay-lai-cuoc-doi', 'Charles Duhigg', 'NXB Tổng Hợp', 2014, '978-603-06-0123-7', 3, 'Phương pháp thay đổi thói quen và thành công', '', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- ===================================================================
-- 3. VERIFY DATA
-- ===================================================================

-- Check categories inserted
SELECT COUNT(*) as category_count FROM `nv5_vi_librarymgt_categories`;

-- Check books inserted
SELECT COUNT(*) as book_count FROM `nv5_vi_librarymgt_books`;

-- Check books with categories
SELECT b.id, b.title, c.title as category, b.quantity 
FROM `nv5_vi_librarymgt_books` b 
LEFT JOIN `nv5_vi_librarymgt_categories` c ON b.cat_id = c.id 
LIMIT 5;
