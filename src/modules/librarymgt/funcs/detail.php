<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

require_once NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';

$book_id = $nv_Request->get_int('id', 'get', 0);

if ($book_id <= 0) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';
$tb_categories = NV_PREFIXLANG . '_' . $module_data . '_categories';
$tb_borrow = NV_PREFIXLANG . '_' . $module_data . '_borrows';

// Lấy thông tin sách
$sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
        LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
        WHERE b.id = ' . $book_id . ' AND b.status = 1';

$book = $db->query($sql)->fetch();

if (empty($book)) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Xử lý đường dẫn ảnh (Thêm đoạn này)
if (!empty($book['image']) && file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $book['image'])) {
    $book['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $book['image'];
} else {
    $book['image'] = ''; // Hoặc để trống để template tự xử lý khối no_image
}

// Kiểm tra xem sách có còn sẵn không
$available_quantity = (int) $book['quantity'];

// Kiểm tra trạng thái mượn sách của user (nếu đã đăng nhập)
$can_borrow = false;
$borrow_disabled_reason = '';

if (defined('NV_IS_USER')) {
    // Kiểm tra xem user có sách đang mượn hoặc quá hạn chưa trả không (fix)  
    $sql_check = 'SELECT COUNT(*) FROM ' . $tb_borrow . ' 
                  WHERE user_id = ' . $user_info['userid'] . ' 
                  AND status IN (0, 1, 4)'; // 0: chờ duyệt, 1: đang mượn, 4: quá hạn
    
    $has_pending = (int) $db->query($sql_check)->fetchColumn();
    
    if ($has_pending > 0) {
        $borrow_disabled_reason = 'Bạn cần trả sách cũ hoặc chờ yêu cầu được xử lý trước khi mượn sách mới';
    } elseif ($available_quantity <= 0) {
        $borrow_disabled_reason = 'Sách hiện không còn sẵn để mượn';
    } else {
        $can_borrow = true;
    }
} else {
    $borrow_disabled_reason = 'Bạn cần đăng nhập để mượn sách';
}

// Format dữ liệu
$book['add_time_formatted'] = !empty($book['add_time']) ? nv_date('d/m/Y H:i', (int) $book['add_time']) : '';
$book['cat_title'] = $book['cat_title'] ?? 'Chưa phân loại';

$page_title = $book['title'];
$key_words = $module_info['keywords'];
$description = !empty($book['description']) ? nv_clean60($book['description'], 300) : $module_info['description'];

$contents = nv_theme_book_detail($book, $can_borrow, $borrow_disabled_reason);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';