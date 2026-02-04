    <?php
    if (!defined('NV_IS_FILE_ADMIN')) {
        exit('Stop!!!');
    }

    $page_title = $nv_Lang->getModule('category');

    $table = NV_PREFIXLANG . '_' . $module_data . '_categories';

    $current_url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op;


    $get = $nv_Request->get_int('get', 'get', 0);
    if ($get == 1) {
        define('NV_IS_AJAX', true);

        // Tắt toàn bộ buffer + gzip
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json; charset=utf-8');

        $id = $nv_Request->get_int('id', 'get', 0);

        $row = $db->query(
            "SELECT id, title, description
            FROM $table
            WHERE id=" . (int)$id
        )->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'Không tìm thấy thể loại'
            ]);
            exit;
        }

        echo json_encode($row);
        exit;
    }
    //  * ======================
    //  * 1. SAVE (ADD / EDIT)
    //  * ======================
    //  */
    $save = $nv_Request->get_int('save', 'post', 0);
    if ($save) {
        $id = $nv_Request->get_int('id', 'post', 0);
        $title = $nv_Request->get_title('title', 'post', '');
        $description = $nv_Request->get_textarea('description', 'post', '');

        if (empty($title)) {
            die("Lỗi: Tên thể loại không được để trống");
        }

        $alias = change_alias($title);

        if ($id == 0) {
            // ADD
            $weight = (int)$db->query("SELECT MAX(weight) FROM $table")->fetchColumn() + 1;

            $stmt = $db->prepare("
                INSERT INTO $table
                (title, alias, description, weight, status, add_time)
                VALUES (:title, :alias, :description, :weight, 1, :time)
            ");

            $stmt->execute([
                ':title' => $title,
                ':alias' => $alias,
                ':description' => $description,
                ':weight' => $weight,
                ':time' => NV_CURRENTTIME
            ]);
        } else {
            // EDIT
            $stmt = $db->prepare("
                UPDATE $table SET
                    title = :title,
                    alias = :alias,
                    description = :description,
                    edit_time = :time
                WHERE id = :id
            ");

            $stmt->execute([
                ':title' => $title,
                ':alias' => $alias,
                ':description' => $description,
                ':time' => NV_CURRENTTIME,
                ':id' => $id
            ]);
        }

        $nv_Cache->delMod($module_name);

        if (ob_get_length()) ob_clean();

        Header("Location: " . $current_url);
        die();
    }

    /**
     * ======================
     * 2. DELETE
     * ======================
     */
    $del = $nv_Request->get_int('delete_id', 'post', 0);
    if ($del) {
        $id = $nv_Request->get_int('delete_id', 'post', 0);

        if ($id <= 0) {
            die('Invalid ID');
        }

        // Check ràng buộc sách
        $check = $db->query(
            'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_books WHERE cat_id=' . $id
        )->fetchColumn();

        if ($check > 0) {
            die('ERROR: Còn ' . $check . ' sách thuộc thể loại này. Vui lòng xóa hoặc chuyển thể loại của các sách này trước khi xóa thể loại.');
        }

        $stmt = $db->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $nv_Cache->delMod($module_name);

        if (ob_get_length()) ob_clean();
       
        die('OK');
    }

    /**
     * ======================
     * 3. LIST
     * ======================
     */
    $xtpl = new XTemplate(
        'cat.tpl',
        NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file
    );

    $xtpl->assign('ACTION_URL', $current_url);

    $result = $db->query("
        SELECT id, title, alias, description, weight, status, add_time
        FROM $table
        ORDER BY weight ASC
    ");

    $stt = 1;

    while ($row = $result->fetch()) {
        $row['stt'] = $stt++;
        $row['add_time_str'] = !empty($row['add_time'])
            ? date('d/m/Y', $row['add_time'])
            : '-';

        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.row');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
