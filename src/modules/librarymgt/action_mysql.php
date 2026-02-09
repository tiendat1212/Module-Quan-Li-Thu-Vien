<?php


if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$sql_drop_module = [];
$sql_create_module = [];


$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rows';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_listtype';

$sql_create_module = $sql_drop_module;
// Categories
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . NV_PREFIXLANG . '_' . $module_data . '_categories';

$sql_create_module[] = 'CREATE TABLE ' . NV_PREFIXLANG . '_' . $module_data . "_categories (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  alias VARCHAR(255) NOT NULL DEFAULT '',
  description TEXT NULL,
  weight SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  status TINYINT(3) UNSIGNED NOT NULL DEFAULT 1,
  add_time INT(10) UNSIGNED NOT NULL DEFAULT 0,
  edit_time INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uk_alias (alias),
  KEY idx_status (status),
  KEY idx_weight (weight)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Books
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . NV_PREFIXLANG . '_' . $module_data . '_books';

$sql_create_module[] = 'CREATE TABLE ' . NV_PREFIXLANG . '_' . $module_data . "_books (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  cat_id INT(10) UNSIGNED NOT NULL DEFAULT 0,
  title VARCHAR(255) NOT NULL,
  alias VARCHAR(255) NOT NULL DEFAULT '',
  author VARCHAR(255) NOT NULL DEFAULT '',
  publisher VARCHAR(255) NOT NULL DEFAULT '',
  publish_year SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  isbn VARCHAR(50) NOT NULL DEFAULT '',
  quantity INT(10) UNSIGNED NOT NULL DEFAULT 0,
  description MEDIUMTEXT NULL,
  image VARCHAR(255) NOT NULL DEFAULT '',
  status TINYINT(3) UNSIGNED NOT NULL DEFAULT 1,
  add_time INT(10) UNSIGNED NOT NULL DEFAULT 0,
  edit_time INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uk_alias (alias),
  KEY idx_cat (cat_id),
  KEY idx_status (status),
  KEY idx_quantity (quantity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Borrows 
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . NV_PREFIXLANG . '_' . $module_data . '_borrows';

$sql_create_module[] = 'CREATE TABLE ' . NV_PREFIXLANG . '_' . $module_data . "_borrows (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  book_id INT(10) UNSIGNED NOT NULL DEFAULT 0,
  user_id INT(10) UNSIGNED NOT NULL DEFAULT 0,

  request_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  approve_date DATETIME NULL,
  borrow_date DATETIME NULL,
  due_date DATETIME NULL,
  return_date DATETIME NULL,

  status TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
  note_user VARCHAR(255) NOT NULL DEFAULT '',
  note_admin VARCHAR(255) NOT NULL DEFAULT '',

  PRIMARY KEY (id),
  KEY idx_book (book_id),
  KEY idx_user (user_id),
  KEY idx_status (status),
  KEY idx_due (due_date),
  KEY idx_user_status (user_id, status),
  KEY idx_status_due (status, due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Sample data: categories
$sql_create_module[] = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . "_categories
(title, alias, description, weight, status, add_time)
VALUES
('Công nghệ thông tin', 'cong-nghe-thong-tin', 'Sách CNTT', 1, 1, " . NV_CURRENTTIME . "),
('Kinh tế', 'kinh-te', 'Sách kinh tế', 2, 1, " . NV_CURRENTTIME . "),
('Văn học', 'van-hoc', 'Sách văn học', 3, 1, " . NV_CURRENTTIME . ")";


// Sample data: books
$sql_create_module[] = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . "_books
(cat_id, title, alias, author, publisher, publish_year, isbn, quantity, description, status, add_time)
VALUES
(1, 'Lập trình PHP cơ bản', 'lap-trinh-php-co-ban', 'Nguyễn Văn A', 'NXB CNTT', 2022, 'ISBN001', 5, 'Sách học PHP cơ bản', 1, " . NV_CURRENTTIME . "),
(1, 'Lập trình Laravel', 'lap-trinh-laravel', 'Trần Văn B', 'NXB CNTT', 2023, 'ISBN002', 3, 'Framework Laravel', 1, " . NV_CURRENTTIME . "),
(2, 'Nguyên lý kinh tế học', 'nguyen-ly-kinh-te', 'Adam Smith', 'NXB Kinh tế', 2020, 'ISBN003', 4, 'Kinh tế học căn bản', 1, " . NV_CURRENTTIME . "),
(3, 'Truyện Kiều', 'truyen-kieu', 'Nguyễn Du', 'NXB Văn học', 2019, 'ISBN004', 2, 'Tác phẩm văn học kinh điển', 1, " . NV_CURRENTTIME . ")";
