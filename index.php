<?php
/**
 * TyBetter
 *
 * @package TyBetter
 * @author Typecho & Rytia & GarfieldTom
 * @version 1.21
 * @link https://www.zzfly.net/tybetter/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 加载头部模板
$this->need('header.php');
?>

    <div class="col-mb-12 col-8" id="main" role="main">
        <?php if ($this->have()): ?>
            <?php while ($this->next()): ?>
                <?php render_post($this); ?>
            <?php endwhile; ?>
        <?php else: ?>
            <p><?php _e('暂无文章'); ?></p>
        <?php endif; ?>

        <!-- 分页导航 -->
        <?php $this->pageNav('« 前一页', '后一页 »'); ?>
    </div><!-- end #main -->

<?php
// 加载侧边栏和底部模板
$this->need('sidebar.php');
$this->need('footer.php');

/**
 * 渲染单篇博文的函数
 * @param object $post 当前博文对象
 */
function render_post($post) {
    ?>
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <!-- 文章标题 -->
        <h2 class="post-title" itemprop="name headline">
            <a itemtype="url" href="<?php $post->permalink(); ?>">
                <?php $post->title(); ?>
            </a>
        </h2>

        <!-- 元信息 -->
        <?php render_post_meta($post); ?>

        <!-- 文章摘要 -->
        <div class="post-content" itemprop="articleBody">
            <?php render_excerpt($post); ?>
        </div>
    </article>
    <?php
}

/**
 * 渲染博文的元信息
 * @param object $post 当前博文对象
 */
function render_post_meta($post) {
    ?>
    <ul class="post-meta">
        <li itemprop="author" itemscope itemtype="http://schema.org/Person">
            <?php _e('作者: '); ?>
            <a itemprop="name" href="<?php $post->author->permalink(); ?>" rel="author">
                <?php $post->author(); ?>
            </a>
        </li>
        <li>
            <?php _e('时间: '); ?>
            <time datetime="<?php $post->date('c'); ?>" itemprop="datePublished">
                <?php $post->date('F j, Y'); ?>
            </time>
        </li>
        <li>
            <?php _e('分类: '); ?>
            <?php $post->category(','); ?>
        </li>
    </ul>
    <?php
}

/**
 * 渲染博文摘要
 * @param object $post 当前博文对象
 */
function render_excerpt($post) {
    // 从主题选项获取摘要长度，默认 100 字
    $excerptLength = $post->options->excerptLength ?: 100;
    $post->excerpt($excerptLength, '');
}
?>