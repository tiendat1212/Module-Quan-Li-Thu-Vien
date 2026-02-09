<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 */

if (!defined('NV_IS_MOD_LIBRABYMGT')) {
    exit('Stop!!!');
}

/**
 * Output JSON and stop execution.
 */
function nv_librarymgt_api_output(array $payload)
{
    if (function_exists('nv_jsonOutput')) {
        nv_jsonOutput($payload);
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit();
}

/**
 * Build image URL from stored relative path.
 */
function nv_librarymgt_api_image_url($image)
{
    $image = trim((string) $image);
    if ($image === '') {
        return '';
    }

    return NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $image;
}

$action = $nv_Request->get_title('action', 'get', 'list');
$action = ($action !== '') ? $action : 'list';

if ($action === 'detail') {
    $book_id = $nv_Request->get_int('book_id', 'get', 0);
    if ($book_id <= 0) {
        $book_id = $nv_Request->get_int('id', 'get', 0);
    }

    if ($book_id <= 0) {
        nv_librarymgt_api_output([
            'success' => false,
            'message' => $nv_Lang->getModule('api_invalid_id'),
            'data' => null
        ]);
    }

    $tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';
    $tb_categories = NV_PREFIXLANG . '_' . $module_data . '_categories';

    $sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
            LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
            WHERE b.id = ' . (int) $book_id;
    $result = $db->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if (empty($row)) {
        nv_librarymgt_api_output([
            'success' => false,
            'message' => $nv_Lang->getModule('api_not_found'),
            'data' => null
        ]);
    }

    $row['id'] = (int) $row['id'];
    $row['cat_id'] = (int) $row['cat_id'];
    $row['publish_year'] = (int) $row['publish_year'];
    $row['quantity'] = (int) $row['quantity'];
    $row['status'] = (int) $row['status'];
    $row['add_time'] = (int) $row['add_time'];
    $row['edit_time'] = (int) $row['edit_time'];
    $row['add_date'] = ($row['add_time'] > 0) ? nv_date('d/m/Y', $row['add_time']) : '';
    $row['edit_date'] = ($row['edit_time'] > 0) ? nv_date('d/m/Y', $row['edit_time']) : '';
    $row['image_url'] = nv_librarymgt_api_image_url($row['image']);

    nv_librarymgt_api_output([
        'success' => true,
        'message' => $nv_Lang->getModule('api_success'),
        'data' => $row
    ]);
}

// Default action: list
$page = $nv_Request->get_page('page', 'get', 1);
$per_page = $nv_Request->get_int('per_page', 'get', 10);
$per_page = max(1, min(50, $per_page));
$page = max(1, (int) $page);
$offset = ($page - 1) * $per_page;

$search = $nv_Request->get_title('search', 'get', '');
$cat_id = $nv_Request->get_int('cat_id', 'get', 0);
$status = $nv_Request->get_int('status', 'get', -1);

$tb_books = NV_PREFIXLANG . '_' . $module_data . '_books';
$tb_categories = NV_PREFIXLANG . '_' . $module_data . '_categories';

$where = ['1=1'];

if ($status >= 0) {
    $where[] = 'b.status = ' . (int) $status;
}

if ($cat_id > 0) {
    $where[] = 'b.cat_id = ' . (int) $cat_id;
}

if ($search !== '') {
    $search_like = $db->quote('%' . $search . '%');
    $where[] = '(b.title LIKE ' . $search_like . ' OR b.author LIKE ' . $search_like . ' OR b.isbn LIKE ' . $search_like . ')';
}

$where_str = implode(' AND ', $where);

$result = $db->query('SELECT COUNT(*) as count FROM ' . $tb_books . ' b WHERE ' . $where_str);
$total = (int) $result->fetchColumn();

$sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
        LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
        WHERE ' . $where_str . '
        ORDER BY b.id ASC
        LIMIT ' . $offset . ', ' . $per_page;
$result = $db->query($sql);

$items = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $row['id'] = (int) $row['id'];
    $row['cat_id'] = (int) $row['cat_id'];
    $row['publish_year'] = (int) $row['publish_year'];
    $row['quantity'] = (int) $row['quantity'];
    $row['status'] = (int) $row['status'];
    $row['add_time'] = (int) $row['add_time'];
    $row['edit_time'] = (int) $row['edit_time'];
    $row['add_date'] = ($row['add_time'] > 0) ? nv_date('d/m/Y', $row['add_time']) : '';
    $row['edit_date'] = ($row['edit_time'] > 0) ? nv_date('d/m/Y', $row['edit_time']) : '';
    $row['image_url'] = nv_librarymgt_api_image_url($row['image']);
    $items[] = $row;
}

nv_librarymgt_api_output([
    'success' => true,
    'message' => $nv_Lang->getModule('api_success'),
    'data' => [
        'items' => $items,
        'total' => $total,
        'page' => $page,
        'per_page' => $per_page
    ]
]);
