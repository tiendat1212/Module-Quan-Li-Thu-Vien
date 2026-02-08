<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

if (!defined('NV_IS_USER')) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']));
}

require_once NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';

$page_title = 'Lịch sử mượn sách';

$tb_borrow = NV_PREFIXLANG . '_' . $module_data . '_borrows';
$tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';

// Xử lý hủy yêu cầu
if ($nv_Request->isset_request('cancel', 'post')) {
    $borrow_id = $nv_Request->get_int('borrow_id', 'post', 0);
    
    $return = [
        'status' => 'error',
        'message' => 'Có lỗi xảy ra'
    ];
    
    if ($borrow_id > 0) {
        // Kiểm tra yêu cầu có thuộc về user và đang ở trạng thái "chờ duyệt" không
        $sql = 'SELECT id FROM ' . $tb_borrow . ' 
                WHERE id = ' . $borrow_id . ' 
                AND user_id = ' . $user_info['userid'] . ' 
                AND status = 0'; // Chỉ cho phép hủy khi đang "chờ duyệt"
        
        $borrow = $db->query($sql)->fetch();
        
        if (!empty($borrow)) {
            // Cập nhật trạng thái thành "đã hủy" (status = 3)
            $stmt = $db->prepare('UPDATE ' . $tb_borrow . ' SET status = 3 WHERE id = :id');
            $stmt->bindParam(':id', $borrow_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                $return['status'] = 'success';
                $return['message'] = 'Hủy yêu cầu thành công';
            } else {
                $return['message'] = 'Không thể hủy yêu cầu';
            }
        } else {
            $return['message'] = 'Không tìm thấy yêu cầu hoặc yêu cầu không thể hủy';
        }
    }
    
    $contents = json_encode($return);
    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

// Lấy danh sách yêu cầu mượn sách
$per_page = 20;
$page = $nv_Request->get_int('page', 'get', 1);
$page = max(1, $page);
$offset = ($page - 1) * $per_page;

// Đếm tổng số yêu cầu
$num_items = (int) $db->query('SELECT COUNT(*) FROM ' . $tb_borrow . ' WHERE user_id = ' . $user_info['userid'])->fetchColumn();

// Lấy danh sách yêu cầu
$borrow_list = [];
$stt = $offset;
$sql = 'SELECT br.*, b.title as book_title, b.author, b.image
        FROM ' . $tb_borrow . ' br
        LEFT JOIN ' . $tb_books . ' b ON b.id = br.book_id
        WHERE br.user_id = ' . $user_info['userid'] . '
        ORDER BY br.request_date DESC
        LIMIT ' . $offset . ', ' . $per_page;

$result = $db->query($sql);
while ($row = $result->fetch()) {
    $stt++;
    
    // Định nghĩa trạng thái
    $status_text = '';
    $status_class = '';
    $can_cancel = false;
    
    // Sửa đoạn Switch trong borrowed.php để đồng bộ với định nghĩa trạng thái trong borrowed.php
    switch ((int) $row['status']) {
        case 0: 
            $status_text = 'Chờ duyệt'; $status_class = 'warning'; $can_cancel = true; break;
        case 1: 
            $status_text = 'Đang mượn'; $status_class = 'info'; break;
        case 2: // File Admin định nghĩa 2 là RETURNED
            $status_text = 'Đã trả'; $status_class = 'success'; break;
        case 3: // File Admin định nghĩa 3 là CANCELED
            $status_text = 'Đã hủy'; $status_class = 'default'; break;
        case 4: // File Admin định nghĩa 4 là OVERDUE
            $status_text = 'Quá hạn'; $status_class = 'danger'; break;
    }
    
    $row['stt'] = $stt;
    $row['status_text'] = $status_text;
    $row['status_class'] = $status_class;
    $row['can_cancel'] = $can_cancel;
    $row['request_time_formatted'] = ($row['request_date'] != '0000-00-00 00:00:00') ? nv_date('d/m/Y H:i', strtotime($row['request_date'])) : '-';
    $row['borrow_date_formatted']  = ($row['borrow_date'] > 0) ? nv_date('d/m/Y', strtotime($row['borrow_date'])) : '-';
    $row['due_date_formatted']     = ($row['due_date'] > 0) ? nv_date('d/m/Y', strtotime($row['due_date'])) : '-';
    $row['return_date_formatted']  = ($row['return_date'] > 0) ? nv_date('d/m/Y', strtotime($row['return_date'])) : '-';
    $row['has_image'] = !empty($row['image']);
    
    $borrow_list[] = $row;
}

// Phân trang
$page_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=borrowed';
$generate_page = ($num_items > $per_page) ? nv_generate_page($page_url, $num_items, $per_page, $page) : '';

$contents = nv_theme_borrowed_list($borrow_list, $generate_page, $page_title);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';