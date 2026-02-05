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
$allow_func = array('main', 'books', 'book_add', 'book_edit', 'book_delete', 'api');
define('NV_IS_FILE_ADMIN', true);

//Lấy danh sách sách với phân trang, lọc

function nv_get_books_list($page = 1, $per_page = 10, $filters = [])
{
    global $db;
    $page = max(1, (int) $page);
    $per_page = max(1, (int) $per_page);
    $offset = ($page - 1) * $per_page;

    $tb_books = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_books';
    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';

    $where = ['1=1'];
    $params = [];

    // Lọc theo status
    if (isset($filters['status']) && $filters['status'] !== '') {
        $where[] = 'b.status = ' . (int) $filters['status'];
    }

    // Lọc theo thể loại
    if (!empty($filters['cat_id'])) {
        $where[] = 'b.cat_id = ' . (int) $filters['cat_id'];
    }

    // Tìm kiếm theo từ khóa (title, author, isbn)
    if (!empty($filters['search'])) {
        $search = '%' . $filters['search'] . '%';
        $search = $db->quote($search);
        $where[] = '(b.title LIKE ' . $search . ' OR b.author LIKE ' . $search . ' OR b.isbn LIKE ' . $search . ')';
    }

    $where_str = implode(' AND ', $where);

    // Lấy tổng số bản ghi
    $result = $db->query('SELECT COUNT(*) as count FROM ' . $tb_books . ' b WHERE ' . $where_str);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $total = (int) $row['count'];

    // Xác định hướng sắp xếp
    $sort_order = (!empty($filters['sort']) && $filters['sort'] === 'DESC') ? 'DESC' : 'ASC';

    // Lấy dữ liệu phân trang
    $sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
            LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
            WHERE ' . $where_str . '
            ORDER BY b.id ' . $sort_order . '
            LIMIT ' . $offset . ', ' . $per_page;

    $result = $db->query($sql);
    $books = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $books[] = $row;
    }

    return [
        'total' => $total,
        'books' => $books,
        'page' => $page,
        'per_page' => $per_page
    ];
}

//Lấy chi tiết 1 cuốn sách

function nv_get_book($book_id)
{
    global $db;
    $book_id = (int) $book_id;
    $tb_books = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_books';
    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';

    $sql = 'SELECT b.*, c.title as cat_title FROM ' . $tb_books . ' b
            LEFT JOIN ' . $tb_categories . ' c ON b.cat_id = c.id
            WHERE b.id = ' . $book_id;

    $result = $db->query($sql);
    return $result->fetch(PDO::FETCH_ASSOC);
}

// Lấy danh sách thể loại
function nv_get_categories_list($only_active = true)
{
    global $db;

    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';
    $where = $only_active ? ' WHERE status = 1' : '';
    $sql = 'SELECT id, title FROM ' . $tb_categories . $where . ' ORDER BY weight ASC, id ASC';

    $result = $db->query($sql);
    $categories = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $categories[(int) $row['id']] = $row['title'];
    }

    return $categories;
}


// Chuẩn hóa dữ liệu sách trả về template
function nv_normalize_book_template_data(array $data)
{
    $publish_year = isset($data['publish_year']) ? (int) $data['publish_year'] : 0;
    $quantity = isset($data['quantity']) ? (int) $data['quantity'] : 0;

    return [
        'title' => isset($data['title']) ? trim((string) $data['title']) : '',
        'author' => isset($data['author']) ? trim((string) $data['author']) : '',
        'cat_id' => isset($data['cat_id']) ? (int) $data['cat_id'] : 0,
        'publisher' => isset($data['publisher']) ? trim((string) $data['publisher']) : '',
        'publish_year' => $publish_year > 0 ? (string) $publish_year : '',
        'isbn' => isset($data['isbn']) ? trim((string) $data['isbn']) : '',
        'quantity' => $quantity > 0 ? (string) $quantity : '',
        'image' => isset($data['image']) ? trim((string) $data['image']) : '',
        'description' => isset($data['description']) ? trim((string) $data['description']) : '',
        'status' => isset($data['status']) ? (int) $data['status'] : 1
    ];
}


// Validate dữ liệu sách

function nv_validate_book($data)
{
    $errors = [];

    if (empty($data['title'])) {
        $errors['title'] = 'Tiêu đề không được để trống';
    }

    if (empty($data['author'])) {
        $errors['author'] = 'Tác giả không được để trống';
    }

    if (empty($data['cat_id']) || (int) $data['cat_id'] <= 0) {
        $errors['cat_id'] = 'Thể loại không hợp lệ';
    }

    $quantity = isset($data['quantity']) ? (int) $data['quantity'] : 0;
    if ($quantity <= 0) {
        $errors['quantity'] = 'Số lượng phải lớn hơn 0';
    }

    return $errors;
}

// Tạo alias từ tiêu đề
function nv_create_alias($title)
{
    $alias = nv_url_rewrite($title);
    return $alias;
}

//Thêm sách mới

function nv_insert_book($data)
{
    global $db;
    
    // Validate
    $errors = nv_validate_book($data);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $tb_books = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_books';
    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';

    // Kiểm tra thể loại tồn tại
    $cat_id = (int) $data['cat_id'];
    $result = $db->query('SELECT id FROM ' . $tb_categories . ' WHERE id = ' . $cat_id);
    if (!$result->fetch(PDO::FETCH_ASSOC)) {
        return ['success' => false, 'errors' => ['cat_id' => 'Thể loại không tồn tại']];
    }

    // Tạo alias
    $alias = nv_create_alias($data['title']);
    
    // Kiểm tra alias đã tồn tại
    $result = $db->query('SELECT id FROM ' . $tb_books . ' WHERE alias = ' . $db->quote($alias));
    if ($result->fetch(PDO::FETCH_ASSOC)) {
        $alias = $alias . '-' . time();
    }

        $title = $db->quote($data['title']);
        $author = $db->quote($data['author']);
        $publisher = isset($data['publisher']) ? $db->quote($data['publisher']) : $db->quote('');
        $isbn = isset($data['isbn']) ? $db->quote($data['isbn']) : $db->quote('');
    $publish_year = isset($data['publish_year']) ? (int) $data['publish_year'] : 0;
        $description = isset($data['description']) ? $db->quote($data['description']) : $db->quote('');
        $image = isset($data['image']) ? $db->quote($data['image']) : $db->quote('');
    $quantity = (int) $data['quantity'];
    $status = isset($data['status']) ? (int) $data['status'] : 1;
    $now = time();

    $sql = 'INSERT INTO ' . $tb_books . ' (cat_id, title, alias, author, publisher, publish_year, isbn, quantity, description, image, status, add_time, edit_time)
            VALUES (' . $cat_id . ', ' . $title . ', ' . $db->quote($alias) . ', ' . $author . ', ' . $publisher . ', ' . $publish_year . ', ' . $isbn . ', ' . $quantity . ', ' . $description . ', ' . $image . ', ' . $status . ', ' . $now . ', ' . $now . ')';

    if ($db->query($sql)) {
        return ['success' => true, 'id' => $db->insert_id, 'alias' => $alias];
    }

    return ['success' => false, 'errors' => ['db' => 'Lỗi thêm sách: ' . $db->error]];
}


//Cập nhật sách

function nv_update_book($book_id, $data)
{
    global $db;
    
    $book_id = (int) $book_id;
    
    // Validate
    $errors = nv_validate_book($data);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $tb_books = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_books';
    $tb_categories = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_categories';

    // Kiểm tra sách tồn tại
    $book = nv_get_book($book_id);
    if (!$book) {
        return ['success' => false, 'errors' => ['id' => 'Sách không tồn tại']];
    }

    // Kiểm tra thể loại tồn tại
    $cat_id = (int) $data['cat_id'];
    $result = $db->query('SELECT id FROM ' . $tb_categories . ' WHERE id = ' . $cat_id);
    if (!$result->fetch(PDO::FETCH_ASSOC)) {
        return ['success' => false, 'errors' => ['cat_id' => 'Thể loại không tồn tại']];
    }

    $title = $db->quote($data['title']);
    $author = $db->quote($data['author']);
    $publisher = isset($data['publisher']) ? $db->quote($data['publisher']) : $db->quote('');
    $isbn = isset($data['isbn']) ? $db->quote($data['isbn']) : $db->quote('');
    $publish_year = isset($data['publish_year']) ? (int) $data['publish_year'] : 0;
    $description = isset($data['description']) ? $db->quote($data['description']) : $db->quote('');
    $image = isset($data['image']) ? $db->quote($data['image']) : $db->quote($book['image']);
    $quantity = (int) $data['quantity'];
    $status = isset($data['status']) ? (int) $data['status'] : 1;
    $now = time();

    $sql = 'UPDATE ' . $tb_books . ' SET
            cat_id = ' . $cat_id . ',
            title = ' . $title . ',
            author = ' . $author . ',
            publisher = ' . $publisher . ',
            publish_year = ' . $publish_year . ',
            isbn = ' . $isbn . ',
            quantity = ' . $quantity . ',
            description = ' . $description . ',
            image = ' . $image . ',
            status = ' . $status . ',
            edit_time = ' . $now . '
            WHERE id = ' . $book_id;

    if ($db->query($sql)) {
        return ['success' => true, 'id' => $book_id];
    }

    return ['success' => false, 'errors' => ['db' => 'Lỗi cập nhật sách: ' . $db->error]];
}


// Xóa sách

function nv_delete_book($book_id)
{
    global $db;
    
    $book_id = (int) $book_id;
    $tb_books = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_books';
    $tb_borrows = NV_PREFIXLANG . '_' . $GLOBALS['module_data'] . '_borrows';

    // Kiểm tra sách tồn tại
    $book = nv_get_book($book_id);
    if (!$book) {
        return ['success' => false, 'error' => 'Sách không tồn tại'];
    }

    // Kiểm tra có bản ghi mượn liên quan
    $result = $db->query('SELECT COUNT(*) as count FROM ' . $tb_borrows . ' WHERE book_id = ' . $book_id . ' AND status IN (0, 1, 4)');
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row['count'] > 0) {
        return ['success' => false, 'error' => 'Không thể xóa sách có bản ghi mượn đang hoạt động'];
    }

    // Xóa sách
    $sql = 'DELETE FROM ' . $tb_books . ' WHERE id = ' . $book_id;
    if ($db->query($sql)) {
        return ['success' => true];
    }

    return ['success' => false, 'error' => 'Lỗi xóa sách: ' . $db->error];
}
