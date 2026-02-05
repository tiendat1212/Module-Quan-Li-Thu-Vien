<?php

if (!defined('NV_IS_MOD_LIBRARYMGT')) {
    // Not a proper module request
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit();
}

// if user not logged in, return JSON error so AJAX can handle it
if (!defined('NV_IS_USER')) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'need_login', 'message' => \NukeViet\Core\Language::$lang_module['error_login_required'] ?? 'Please login']);
    exit();
}

$book_id = $nv_Request->get_int('book_id', 'post', 0);
if (empty($book_id)) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'error', 'message' => 'Invalid book id']);
    exit();
}

// Load book
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_books WHERE id = ' . $book_id . ' AND status = 1';
$book = $db->query($sql)->fetch();
if (!$book) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'error', 'message' => \NukeViet\Core\Language::$lang_module['error_not_found'] ?? 'Book not found']);
    exit();
}

// Check quantity
if ((int) $book['quantity'] <= 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'error', 'message' => \NukeViet\Core\Language::$lang_module['error_no_quantity'] ?? 'This book is not available']);
    exit();
}

// Check user outstanding borrows
$check_sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_borrows WHERE user_id = ' . $user_info['userid'] . ' AND status IN (0,1,2)';
if ($db->query($check_sql)->fetchColumn() > 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'error', 'message' => \NukeViet\Core\Language::$lang_module['error_not_returned'] ?? 'You must return borrowed books first']);
    exit();
}

// Insert borrow request (status 0 = pending)
$stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_borrows (book_id, user_id, request_date, status) VALUES (:book_id, :user_id, NOW(), 0)');
$stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_info['userid'], PDO::PARAM_INT);
if ($stmt->execute()) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'ok', 'message' => \NukeViet\Core\Language::$lang_module['borrow_request_sent'] ?? 'Request sent']);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => 'error', 'message' => 'Error sending request']);
}

exit();
