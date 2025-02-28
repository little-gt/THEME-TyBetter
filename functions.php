<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 配置主题的选项表单。
 *
 * @param object $form 表单对象
 */
function themeConfig($form) {
    // 站点 LOGO 地址配置
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'logoUrl',
        NULL,
        NULL,
        _t('站点LOGO地址'),
        _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO')
    );
    $form->addInput($logoUrl);

    // 设置文章摘要的输出字符长度
    $excerptLength = new Typecho_Widget_Helper_Form_Element_Text(
        'excerptLength',
        NULL, '100',
        _t('摘要长度'),
        _t('设置文章摘要的最大字数，默认为100')
    );
    $form->addInput($excerptLength);

    // 侧边栏显示配置
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'sidebarBlock',
        array(
            'ShowRecentPosts' => _t('显示最新文章'),
            'ShowCategory' => _t('显示分类'),
            'ShowArchive' => _t('显示归档'),
            'ShowOther' => _t('显示其它杂项')
        ),
        array('ShowRecentPosts', 'ShowCategory', 'ShowArchive', 'ShowOther'),
        _t('侧边栏显示')
    );
    $form->addInput($sidebarBlock->multiMode());

    // 页脚ICP备案信息配置
    $footerICPNumber = new Typecho_Widget_Helper_Form_Element_Text(
        'footerICPNumber',
        NULL, NULL,
        _t('ICP备案信息'),
        _t('工信部ICP备案请在此填写，支持\<a\>标签')
    );
    $form->addInput($footerICPNumber);

    // 页脚网安备案信息配置
    $footerSecurityRecord = new Typecho_Widget_Helper_Form_Element_Textarea(
        'footerSecurityRecord',
        NULL, NULL,
        _t('网安备案信息'),
        _t('全国互联网公安备案请在此填写，支持\<a\>标签')
    );
    $form->addInput($footerSecurityRecord);

    // 页脚其他说明信息配置
    $footerRecord = new Typecho_Widget_Helper_Form_Element_Textarea(
        'footerRecord',
        NULL,
        NULL,
        _t('页脚右侧信息配置'),
        _t('请在此输入你需要展示在页面角右侧其他说明信息，支持\<a\>标签')
    );
    $form->addInput($footerRecord);
}

/**
 * 获取文章缩略图。
 *
 * @param int $cid 文章的 CID
 * @return string 缩略图的 URL 或者空字符串
 */
function img_postthumb($cid) {
    $db = Typecho_Db::get();
    $sql = $db->select('table.contents.text')
        ->from('table.contents')
        ->where('table.contents.cid = ?', $cid)
        ->order('table.contents.cid', Typecho_Db::SORT_ASC)
        ->limit(1);

    $rs = $db->fetchRow($sql);
    if (isset($rs['text'])) {
        preg_match_all("/<img.*?src=\"(.*?)\"[^>]*>/i", $rs['text'], $matches);
        if (!empty($matches[1])) {
            return $matches[1][0];
        }
    }
    return '';  // 如果没有找到图片，则返回空字符串
}

/**
 * 文章页面参数 - Letax公式渲染启用设置
 *
 */
function themeFields($layout) {
    $isLatex = new Typecho_Widget_Helper_Form_Element_Radio('isLatex',
        array(1 => _t('启用'),
            0 => _t('关闭')),
        0, _t('LaTeX 渲染'), _t('默认关闭增加网页访问速度，如文章内存在LaTeX语法则需要启用'));
    $layout->addItem($isLatex);
}