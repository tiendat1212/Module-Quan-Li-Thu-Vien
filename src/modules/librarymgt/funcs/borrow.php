<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

$tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';
$tb_borrow = NV_PREFIXLANG . '_' . $module_data . '_borrows';

$contents = 'NO_' . $module_name;

if (!defined('NV_IS_USER')) {
    $contents = json_encode([
        'status' => 'error',
        'message' => 'Bạn cần đăng nhập để mượn sách'
    ]);
    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

if ($nv_Request->isset_request('save', 'post')) {
    $book_id = $nv_Request->get_int('book_id', 'post', 0);
    
    $return = [
        'status' => 'error',
        'message' => 'Có lỗi xảy ra'
    ];
    
    if ($book_id > 0) {
        // Kiểm tra sách có tồn tại không
        $sql = 'SELECT id, title, quantity FROM ' . $tb_books . ' WHERE id = ' . $book_id . ' AND status = 1';
        $book = $db->query($sql)->fetch();
        
        if (!empty($book)) {
            // Kiểm tra user có yêu cầu đang chờ hoặc sách chưa trả không
            $sql_check = 'SELECT COUNT(*) FROM ' . $tb_borrow . ' 
                          WHERE user_id = ' . $user_info['userid'] . ' 
                          AND status IN (0, 1, 2)'; // 0: chờ duyệt, 1: đang mượn, 2: quá hạn
            
            $has_pending = (int) $db->query($sql_check)->fetchColumn();
            
            if ($has_pending > 0) {
                $return['message'] = 'Bạn cần trả sách cũ hoặc chờ yêu cầu được xử lý trước khi mượn sách mới';
            } elseif ((int) $book['quantity'] <= 0) {
                $return['message'] = 'Sách hiện không còn sẵn để mượn';
            } else {
                // Tạo yêu cầu mượn sách
                $stmt = $db->prepare('INSERT INTO ' . $tb_borrow . ' 
                    (user_id, book_id, request_date, status) 
                    VALUES (:userid, :book_id, :request_date, 0)');
                
                $stmt->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
                $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
                $request_time = NV_CURRENTTIME;
                $stmt->bindParam(':request_date', $request_time, PDO::PARAM_INT);
                
                if ($stmt->execute()) {
                    $return['status'] = 'success';
                    $return['message'] = 'Gửi yêu cầu mượn sách thành công! Vui lòng chờ admin phê duyệt.';
                } else {
                    $return['message'] = 'Không thể tạo yêu cầu mượn sách';
                }
            }
        } else {
            $return['message'] = 'Sách không tồn tại';
        }
    }
    
    $contents = json_encode($return);
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';