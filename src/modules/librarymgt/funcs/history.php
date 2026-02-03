<?php

if (!defined('NV_IS_MOD_LIBRARYMGT') || !defined('NV_IS_USER')) {
    header('Location: ' . NV_BASE_SITEURL);
    exit();
}


// Lấy danh sách yêu cầu mượn của user hiện tại [cite: 13, 64-65]
$sql = 'SELECT b.*, s.title as book_name FROM ' . NV_PREFIXLANG . '_' . $module_data . '_borrows b 
        JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_books s ON b.book_id = s.id 
        WHERE b.user_id = ' . $user_info['userid'] . ' ORDER BY b.request_date DESC';
$result = $db->query($sql);
$data = [];
$i = 1;

while ($row = $result->fetch()) {
    $row['stt'] = $i++;
    
    // Định dạng ngày tháng từ Database (vốn là kiểu DATETIME hoặc Timestamp)
    $row['date'] = date('d/m/Y', strtotime($row['request_date']));
    $row['due_date_text'] = ($row['due_date']) ? date('d/m/Y', strtotime($row['due_date'])) : '-';
    
    // Ánh xạ class CSS cho label dựa trên trạng thái [cite: 38-44]
    $status_classes = [
        0 => 'info',    // Chờ duyệt [cite: 40]
        1 => 'success', // Đang mượn [cite: 42]
        2 => 'danger',  // Quá hạn [cite: 44]
        3 => 'default', // Đã trả [cite: 43]
        4 => 'warning'  // Đã hủy [cite: 41]
    ];
    
    $row['status_class'] = $status_classes[$row['status']] ?? 'default';
    $row['status_text'] = \NukeViet\Core\Language::$lang_module['status_' . $row['status']];
    
    // Kiểm tra quá hạn thực tế để bôi đỏ (nếu trạng thái vẫn là Đang mượn nhưng đã quá ngày)
    $row['class_due'] = ($row['status'] == 1 && NV_CURRENTTIME > strtotime($row['due_date'])) ? 'text-danger' : '';

    $data[] = $row;
}

// Thiết lập tiêu đề trang cho Site
$page_title = \NukeViet\Core\Language::$lang_module['history'];

// Truyền dữ liệu sang theme.php
$contents = nv_theme_history($data);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';