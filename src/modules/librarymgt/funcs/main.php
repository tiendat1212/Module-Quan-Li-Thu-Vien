<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

require_once NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';

$page_title = $module_info['site_title'];

$per_page = 10;
$page = $nv_Request->get_page('page', 'post,get', 1);
$page = max(1, (int) $page);
$offset = ($page - 1) * $per_page;

$tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';
$tb_categories = NV_PREFIXLANG . '_' . $module_data . '_categories';

$current_catid = 0; // Trang main = tất cả sách


//Lấy danh sách thể loại để hiển thị menu lọc
$categories = [];
$sql_cat = 'SELECT id, title FROM ' . $tb_categories . ' WHERE status = 1 ORDER BY weight ASC';
$result_cat = $db->query($sql_cat);
while ($cat = $result_cat->fetch()) {
    $categories[(int) $cat['id']] = $cat['title'];
}

//Đếm tổng sách (phân trang)
$num_items = (int) $db->query('SELECT COUNT(*) FROM ' . $tb_books . ' WHERE status = 1')->fetchColumn();

//Lấy danh sách sách (join thể loại)
$books = [];
$sql = 'SELECT b.id, b.title, b.author, b.quantity, b.add_time, c.title AS name
        FROM ' . $tb_books . ' b
        LEFT JOIN ' . $tb_categories . ' c ON c.id = b.cat_id
        WHERE b.status = 1
        ORDER BY b.add_time DESC
        LIMIT ' . $offset . ', ' . $per_page;

$result = $db->query($sql);
while ($row = $result->fetch()) {
    $row['name'] = $row['name'] ?? '';
    $row['add_time'] = !empty($row['add_time']) ? nv_date('d/m/Y', (int) $row['add_time']) : '';
    $books[] = $row;
}


//Phân trang
$page_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$generate_page = ($num_items > $per_page) ? nv_generate_page($page_url, $num_items, $per_page, $page) : '';

$contents = nv_theme_books_list($books, $categories, $current_catid, $generate_page, $page_title);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
