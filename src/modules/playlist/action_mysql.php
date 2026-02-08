<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_rows';

$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_rows (
 id INT(11) NOT NULL AUTO_INCREMENT,
 title varchar(255) NOT NULL DEFAULT '',
 description TEXT,
 media_url varchar(500) NOT NULL DEFAULT '',
 thumbnail varchar(500),
 duration varchar(20),
 status INT(1) NOT NULL DEFAULT 1,
 created_at INT(11),
 updated_at INT(11),
 PRIMARY KEY (id)
) ENGINE=MyISAM";

// Thêm 5 dòng dữ liệu vào bảng _rows
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (title, description, media_url, thumbnail, duration, status, created_at) VALUES 
('Lạc trôi - Sơn Tùng M-TP', 'Bài hát debut của Sơn Tùng M-TP, kết hợp cùng Snoop Dogg. Một trong những bài hát ghi dấu ấn nhất của anh', 'https://www.youtube.com/embed/UmfP1Op35SE', 'https://via.placeholder.com/320x180?text=Lac+Troi', '03:40', 1, UNIX_TIMESTAMP()),
('Chạy ngay đi - Sơn Tùng M-TP', 'Bài hát hit từ album \"Chasing The Sun\". Ghi dấu ấn sâu trong lòng người nghe Việt Nam', 'https://www.youtube.com/embed/f8mVFmxJpXU', 'https://via.placeholder.com/320x180?text=Chay+Ngay+Di', '03:45', 1, UNIX_TIMESTAMP()),
('Nơi này có anh - Sơn Tùng M-TP', 'Bài hát tình cảm, thể hiện tình yêu sâu sắc qua những lời ca cảm động', 'https://www.youtube.com/embed/VnpqWohqVMg', 'https://via.placeholder.com/320x180?text=Noi+Nay+Co+Anh', '04:15', 1, UNIX_TIMESTAMP()),
('Như là lần đầu tiên - Sơn Tùng M-TP', 'Một bài ballad tuyệt vời từ Sơn Tùng, thể hiện sự yêu thương từ từ', 'https://www.youtube.com/embed/SlPhMPnQ58k', 'https://via.placeholder.com/320x180?text=Nhu+Lan+Dau', '03:30', 1, UNIX_TIMESTAMP()),
('Anh sai rồi - Sơn Tùng M-TP', 'Bài hát đầy cảm xúc, xin lỗi và sự hối hận được thể hiện qua từng câu ca', 'https://www.youtube.com/embed/WvOz6eFqrLg', 'https://via.placeholder.com/320x180?text=Xin+Loi', '03:52', 1, UNIX_TIMESTAMP())";
