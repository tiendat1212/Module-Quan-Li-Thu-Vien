<?php

if (!defined('NV_IS_MOD_LIBRARYMGT')) {
    exit('Stop!!!');
}

// Lấy alias từ URL (giả định URL dạng domain.com/librarymgt/alias-sach/)
$alias = $array_op[0];

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_books WHERE alias = :alias AND status = 1';
$stmt = $db->prepare($sql);
$stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
$stmt->execute();
$item = $stmt->fetch();

if (!$item) {
    header('Location: ' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name, true));
    exit();
}

// Thiết lập tiêu đề trang cho SEO
$page_title = $item['title'];
$key_words = $item['author'];

$allow_borrow = true;
$error_message = '';

// Kiểm tra các điều kiện mượn sách [cite: 63, 171]
if (!defined('NV_IS_USER')) {
    $allow_borrow = false;
    $error_message = \NukeViet\Core\Language::$lang_module['error_login_required'];
} elseif ($item['quantity'] <= 0) {
    $allow_borrow = false;
    $error_message = \NukeViet\Core\Language::$lang_module['error_no_quantity'];
} else {
    // Kiểm tra quy tắc: Người dùng cần trả sách đã mượn trước khi mượn sách mới [cite: 37]
    $check_sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_borrows 
                  WHERE user_id = ' . $user_info['userid'] . ' AND status IN (0, 1, 2)';
    if ($db->query($check_sql)->fetchColumn() > 0) {
        $allow_borrow = false;
        $error_message = \NukeViet\Core\Language::$lang_module['error_not_returned'];
    }
}

// Gọi hàm từ theme.php đã cập nhật
$contents = nv_theme_detail($item, $allow_borrow, $error_message);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';