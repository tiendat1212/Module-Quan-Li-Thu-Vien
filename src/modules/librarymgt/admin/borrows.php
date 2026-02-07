<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('borrows_manager');

$borrow_table = NV_PREFIXLANG . '_' . $module_data . '_borrows';
$book_table   = NV_PREFIXLANG . '_' . $module_data . '_books';
borrows_manager_auto_overdue($db, $borrow_table);
// $xtpl = new XTemplate('borrows.tpl', NV_ROOTDIR . '/modules/' . $module_file . '/admin/theme');
// $xtpl->assign('LANG', $lang_module);

$action = $nv_Request->get_string('action', 'post', '');
$id     = $nv_Request->get_int('id', 'post', 0);

$xtpl = new XTemplate(
        'borrows.tpl',
        NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file
    );

if ($action == 'approve' && $id > 0) {

    $borrow = $db->query("
        SELECT id, book_id, status
        FROM $borrow_table
        WHERE id=$id
    ")->fetch();

    if (!$borrow || !borrows_manager_can_approve($borrow['status'])) {
        die('Invalid');
    }

    $qty = $db->query("
        SELECT quantity
        FROM $book_table
        WHERE id=" . (int)$borrow['book_id']
    )->fetchColumn();

    if ($qty <= 0) {
        die('Hết sách');
    }

    // Trừ số lượng sách
    $db->query("
        UPDATE $book_table
        SET quantity = quantity - 1
        WHERE id=" . (int)$borrow['book_id']
    );

    // Update mượn
    $db->query("
        UPDATE $borrow_table SET
            status = " . BORROW_BORROWING . ",
            approve_date = NOW(),
            borrow_date = NOW(),
            due_date = DATE_ADD(NOW(), INTERVAL 7 DAY)
        WHERE id=$id
    ");

    die('OK');
}

if ($action == 'cancel' && $id > 0) {

    $db->query("
        UPDATE $borrow_table
        SET status = " . BORROW_CANCELED . "
        WHERE id=$id AND status=" . BORROW_PENDING
    );

    die('OK');
}

if ($action == 'return' && $id > 0) {

    $borrow = $db->query("
        SELECT book_id, status
        FROM $borrow_table
        WHERE id=$id
    ")->fetch();

    if (!$borrow || !borrows_manager_can_return($borrow['status'])) {
        die('Invalid');
    }

    // Cộng lại sách
    $db->query("
        UPDATE $book_table
        SET quantity = quantity + 1
        WHERE id=" . (int)$borrow['book_id']
    );

    $db->query("
        UPDATE $borrow_table SET
            status = " . BORROW_RETURNED . ",
            return_date = NOW()
        WHERE id=$id
    ");

    die('OK');
}

$q      = $nv_Request->get_title('q', 'get', '');
$status = $nv_Request->get_int('status', 'get', -1);

$xtpl->assign('Q', $q);

$status_map = borrows_manager_status_map();

foreach ($status_map as $key => $info) {
    $xtpl->assign('STATUS', [
        'key'      => $key,
        'text'     => $info[0],
        'selected' => ($key == $status) ? 'selected' : ''
    ]);
    $xtpl->parse('main.status');
}


$where = [];
$params = [];

if ($q) {
    $where[] = '(bo.title LIKE :q1 OR u.username LIKE :q2)';
    $params[':q1'] = '%' . $q . '%';
    $params[':q2'] = '%' . $q . '%';
}

if ($status >= 0) {
    $where[] = 'b.status = :status';
    $params[':status'] = $status;
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "
    SELECT b.*, u.username, bo.title AS book_title
    FROM $borrow_table b
    JOIN " . NV_USERS_GLOBALTABLE . " u ON b.user_id = u.userid
    JOIN $book_table bo ON b.book_id = bo.id
    $where_sql
    ORDER BY b.request_date DESC
";

$stmt = $db->prepare($sql);
$stmt->execute($params);

while ($row = $stmt->fetch()) {

    [$text, $class] = borrows_manager_status_info($row['status']);
    $row['status_text']  = $text;
    $row['status_class'] = $class;

    $xtpl->assign('ROW', $row);

    if (borrows_manager_can_approve($row['status'])) {
        $xtpl->parse('main.row.approve');
        $xtpl->parse('main.row.cancel');
    }

    if (borrows_manager_can_return($row['status'])) {
        $xtpl->parse('main.row.return');
    }

    $xtpl->parse('main.row');
}





$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
