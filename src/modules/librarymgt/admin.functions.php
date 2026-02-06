<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}
$allow_func = array('main', 'config', 'content', 'cat', 'borrows');
define('NV_IS_FILE_ADMIN', true);

// Các hàm dùng chung cho quản lý mượn trả

define('BORROW_PENDING', 0);    // Chờ duyệt
define('BORROW_BORROWING', 1);  // Đang mượn
define('BORROW_RETURNED', 2);   // Đã trả
define('BORROW_CANCELED', 3);   // Đã huỷ
define('BORROW_OVERDUE', 4);    // Quá hạn

function borrows_manager_status_map() {
    return [
        BORROW_PENDING   => ['Chờ duyệt', 'warning'],
        BORROW_BORROWING => ['Đang mượn', 'info'],
        BORROW_RETURNED  => ['Đã trả', 'success'],
        BORROW_CANCELED  => ['Đã huỷ', 'default'],
        BORROW_OVERDUE   => ['Quá hạn', 'danger'],
    ];
}

function borrows_manager_status_info($status) {
    $map = borrows_manager_status_map();
    return $map[$status] ?? ['Không xác định', 'default'];
}

function borrows_manager_can_approve($status) {
    return $status == BORROW_PENDING;
}

function borrows_manager_can_cancel($status) {
    return $status == BORROW_PENDING;
}

function borrows_manager_can_return($status) {
    return in_array($status, [BORROW_BORROWING, BORROW_OVERDUE]);
}

function borrows_manager_auto_overdue($db, $borrow_table) {
    $db->query("
        UPDATE $borrow_table
        SET status = " . BORROW_OVERDUE . "
        WHERE status = " . BORROW_BORROWING . "
          AND due_date < NOW()
    ");
}