<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <style>
        .post-title {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }
        .modern-button {
            background-color: #1E88E5; /* 蓝色背景 */
            border: none;
            color: white; /* 白色文字 */
            padding: 10px 20px; /* 内边距 */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px; /* 圆角 */
            transition: background-color 0.3s ease; /* 平滑过渡 */
        }
        .modern-button:hover {
            background-color: #1976D2; /* 鼠标悬停时改变背景色 */
        }
    </style>

    <div class="col-mb-12 col-tb-8 col-tb-offset-2">

        <div class="error-page">
            <h2 class="post-title">404 - <?php _e('页面没找到'); ?></h2>
            <p><?php _e('很抱歉，你想要访问的内容可能已被删除或者移动，不如搜索一下吧: '); ?></p>
            <form method="get" action="<?php $this->options->siteUrl(); ?>/search">
                <p><input type="text" name="s" class="text" placeholder="<?php _e('输入关键词...'); ?>" autofocus /></p>
                <p><button type="submit" class="submit modern-button"><?php _e('搜索'); ?></button> | 或者也可以<a href="<?php $this->options->siteUrl(); ?>" target="_blank" style="text-decoration: none;">返回首页</a></p>
            </form>
        </div>

    </div><!-- end #content-->
<?php $this->need('footer.php'); ?>