<?php
if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('Quản lý mượn trả');

$table = NV_PREFIXLANG . '_' . $module_data . '_borrows';


// $xtpl = new XTemplate('borrows.tpl', NV_ROOTDIR . '/modules/' . $module_file . '/admin/theme');
// $xtpl->assign('LANG', $lang_module);

$xtpl = new XTemplate(
        'borrows.tpl',
        NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file
    );

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
