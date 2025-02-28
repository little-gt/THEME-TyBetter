<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <div class="col-mb-12 col-8" id="main" role="main">
        <article class="post single" itemscope itemtype="http://schema.org/BlogPosting">
            <!-- 文章标题 -->
            <h1 class="post-title" itemprop="name headline">
                <a itemtype="url" href="<?php $this->permalink(); ?>">
                    <?php $this->title(); ?>
                </a>
            </h1>

            <!-- 元信息 -->
            <?php render_post_meta($this); ?>

            <!-- 文章内容 -->
            <div class="post-content" itemprop="articleBody">
                <?php $this->content(); ?>
            </div>

            <!-- 标签 -->
            <p itemprop="keywords" class="tags">
                <?php _e('标签: '); ?>
                <?php $this->tags(', ', true, 'none'); ?>
            </p>
        </article>

        <!-- 上一篇/下一篇 -->
        <ul class="post-near">
            <li>上一篇: <?php $this->thePrev('%s', '没有了'); ?></li>
            <li>下一篇: <?php $this->theNext('%s', '没有了'); ?></li>
        </ul>

        <!-- 评论区域 -->
        <?php $this->need('comment.php'); ?>
    </div><!-- end #main -->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>

<?php
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
?>