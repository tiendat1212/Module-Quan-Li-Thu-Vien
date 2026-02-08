<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

/**
 * Load CSS riêng cho module librarymgt
 */
$global_config['site_css'][] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/css/librarymgt.css';

/**
 * Load file theme để render giao diện
 */
require_once NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';

$page_title = $module_info['site_title'];

/**
 * Cấu hình phân trang
 */
$per_page = 10;
$page = $nv_Request->get_page('page', 'post,get', 1);
$page = max(1, (int) $page);
$offset = ($page - 1) * $per_page;

/**
 * Lấy tham số tìm kiếm và lọc
 */
$q = trim($nv_Request->get_string('q', 'get', ''));   // từ khóa tìm kiếm
$current_catid = $nv_Request->get_int('catid', 'get', 0); // thể loại (0 = tất cả)

/**
 * Tên bảng
 */
$tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';
$tb_categories = NV_PREFIXLANG . '_' . $module_data . '_categories';

/**
 * Lấy danh sách thể loại để hiển thị menu lọc
 */
$categories = [];
$sql_cat = 'SELECT id, title FROM ' . $tb_categories . ' WHERE status = 1 ORDER BY weight ASC';
$result_cat = $db->query($sql_cat);
while ($cat = $result_cat->fetch()) {
    $categories[(int) $cat['id']] = $cat['title'];
}

/**
 * Xây dựng điều kiện WHERE cho tìm kiếm + lọc
 */
$where = [];
$where[] = 'b.status = 1';

// Lọc theo thể loại
if ($current_catid > 0) {
    $where[] = 'b.cat_id = ' . (int) $current_catid;
}

// Tìm kiếm theo tên sách hoặc tác giả
if ($q !== '') {
    $q_sql = $db->quote('%' . $q . '%');
    $where[] = '(b.title LIKE ' . $q_sql . ' OR b.author LIKE ' . $q_sql . ')';
}

$where_sql = 'WHERE ' . implode(' AND ', $where);

/**
 * Đếm tổng số sách (phục vụ phân trang)
 */
$sql_count = 'SELECT COUNT(*) 
    FROM ' . $tb_books . ' b 
    ' . $where_sql;

$num_items = (int) $db->query($sql_count)->fetchColumn();

/**
 * Lấy danh sách sách (join thể loại)
 */
$books = [];
$sql = 'SELECT b.id, b.title, b.author, b.quantity, b.add_time, b.image, c.title AS name
        FROM ' . $tb_books . ' b
        LEFT JOIN ' . $tb_categories . ' c ON c.id = b.cat_id
        ' . $where_sql . '
        ORDER BY b.add_time DESC
        LIMIT ' . $offset . ', ' . $per_page;

$result = $db->query($sql);
while ($row = $result->fetch()) {
    $row['name'] = $row['name'] ?? '';
    $row['add_time'] = !empty($row['add_time']) ? nv_date('d/m/Y', (int) $row['add_time']) : '';
    $row['detail_link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&id=' . (int) $row['id'];
    $books[] = $row;
}

/**
 * Tạo URL phân trang (giữ tham số tìm kiếm và lọc)
 */
$page_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA
    . '&' . NV_NAME_VARIABLE . '=' . $module_name;

if ($current_catid > 0) {
    $page_url .= '&catid=' . $current_catid;
}

if ($q !== '') {
    $page_url .= '&q=' . urlencode($q);
}

$generate_page = ($num_items > $per_page)
    ? nv_generate_page($page_url, $num_items, $per_page, $page)
    : '';

/**
 * Render giao diện
 */
$contents = nv_theme_books_list(
    $books,
    $categories,
    $current_catid,
    $generate_page,
    $page_title,
    $q // truyền keyword xuống tpl
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';