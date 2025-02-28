<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 配置主题的选项表单。
 *
 * @param object $form 表单对象
 */
function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'logoUrl',
        NULL,
        NULL,
        _t('站点LOGO地址'),
        _t('请输入一个图片 URL（如 https://example.com/logo.png），用于在网站标题前显示LOGO')
    );
    $form->addInput($logoUrl);

    $excerptLength = new Typecho_Widget_Helper_Form_Element_Text(
        'excerptLength',
        NULL,
        '100',
        _t('摘要长度'),
        _t('设置文章摘要的最大字符数，默认值为 100，建议范围 50-200')
    );
    $excerptLength->input->setAttribute('class', 'w-20');
    $form->addInput($excerptLength->addRule('isInteger', _t('请输入整数')));

    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'sidebarBlock',
        array(
            'ShowRecentPosts' => _t('显示最新文章'),
            'ShowCategory' => _t('显示分类'),
            'ShowArchive' => _t('显示归档'),
            'ShowOther' => _t('显示其它杂项')
        ),
        array('ShowRecentPosts', 'ShowCategory', 'ShowArchive', 'ShowOther'),
        _t('侧边栏显示'),
        _t('选择需要在侧边栏显示的内容，默认全选')
    );
    $form->addInput($sidebarBlock->multiMode());

    $footerICPNumber = new Typecho_Widget_Helper_Form_Element_Text(
        'footerICPNumber',
        NULL,
        NULL,
        _t('ICP备案信息'),
        _t('填写工信部ICP备案号（如 京ICP备12345678号），支持 <a> 标签')
    );
    $form->addInput($footerICPNumber);

    $footerSecurityRecord = new Typecho_Widget_Helper_Form_Element_Textarea(
        'footerSecurityRecord',
        NULL,
        NULL,
        _t('网安备案信息'),
        _t('填写全国互联网公安备案信息（如 京公网安备 11000002000001号），支持 <a> 标签')
    );
    $form->addInput($footerSecurityRecord);

    $footerRecord = new Typecho_Widget_Helper_Form_Element_Textarea(
        'footerRecord',
        NULL,
        NULL,
        _t('页脚右侧信息配置'),
        _t('输入需要在页脚右侧显示的自定义信息（如版权声明），支持 <a> 标签')
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
    if (!is_numeric($cid) || (int)$cid <= 0) {
        return '';
    }

    $db = Typecho_Db::get();
    $cid = (int)$cid;

    $rs = $db->fetchRow(
        $db->select('text')
            ->from('table.contents')
            ->where('cid = ?', $cid)
            ->limit(1)
    );

    if (isset($rs['text'])) {
        preg_match_all("/<img.*?src=\"(.*?)\"[^>]*>/i", $rs['text'], $matches);
        if (!empty($matches[1])) {
            return $matches[1][0];
        }
    }
    return '';
}

/**
 * 文章页面参数 - LaTeX 公式渲染启用设置
 *
 * @param object $layout 布局对象
 */
function themeFields($layout) {
    $isLatex = new Typecho_Widget_Helper_Form_Element_Radio(
        'isLatex',
        array(
            1 => _t('启用'),
            0 => _t('关闭')
        ),
        0,
        _t('LaTeX 渲染'),
        _t('是否启用 LaTeX 公式渲染，默认关闭以提升页面加载速度。启用后支持数学公式，但可能增加加载时间。')
    );
    $layout->addItem($isLatex);
}

/**
 * 生成人机验证问题并存储答案到会话
 *
 * @return array 包含问题、键和答案的数组
 */
function generateCaptcha() {
    $operations = ['+', '-', '*'];
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $op = $operations[array_rand($operations)];

    switch ($op) {
        case '+':
            $answer = $num1 + $num2;
            break;
        case '-':
            $answer = $num1 - $num2;
            break;
        case '*':
            $answer = $num1 * $num2;
            break;
        default:
            $answer = $num1 + $num2; // 默认加法
    }

    $question = "$num1 $op $num2 = ?";
    $key = md5(uniqid(rand(), true)); // 生成唯一键
    $session = Typecho_Session::getInstance();
    $session->set('captcha_' . $key, ['answer' => $answer, 'timestamp' => time()]);

    return ['question' => $question, 'key' => $key, 'answer' => $answer];
}

/**
 * 验证人机验证码
 *
 * @param string $key 验证码键
 * @param int $userAnswer 用户提交的答案
 * @return bool 是否通过验证
 */
function verifyCaptcha($key, $userAnswer) {
    $session = Typecho_Session::getInstance();
    $captchaData = $session->get('captcha_' . $key);

    if (!$captchaData || (time() - $captchaData['timestamp']) > 300) { // 5分钟超时
        $session->delete('captcha_' . $key);
        return false;
    }

    $correctAnswer = $captchaData['answer'];
    $session->delete('captcha_' . $key); // 验证后清除

    return (int)$userAnswer === $correctAnswer;
}

/**
 * 评论提交前的验证钩子
 *
 * @param array $comment 评论数据
 * @return array
 */
function theme_comment_verify($comment) {
    if (isset($_POST['captcha_key']) && isset($_POST['captcha_answer'])) {
        $key = trim($_POST['captcha_key']);
        $userAnswer = trim($_POST['captcha_answer']);
        if (!verifyCaptcha($key, $userAnswer)) {
            throw new Typecho_Widget_Exception(_t('人机验证失败，请正确回答问题！'));
        }
    } else {
        throw new Typecho_Widget_Exception(_t('请完成人机验证！'));
    }
    return $comment;
}

/**
 * 处理验证码刷新请求
 */
function handleCaptchaRefresh() {
    if (isset($_GET['action']) && $_GET['action'] === 'refresh_captcha') {
        $captcha = generateCaptcha();
        header('Content-Type: application/json');
        echo json_encode(['question' => $captcha['question'], 'key' => $captcha['key']]);
        exit;
    }
}

// 注册评论验证钩子和刷新处理
Typecho_Plugin::factory('Widget_Feedback')->comment = 'theme_comment_verify';
Typecho_Plugin::factory('Widget_Init')->handle = 'handleCaptchaRefresh';