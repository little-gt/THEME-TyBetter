<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <div class="col-mb-12 col-8" id="main" role="main">
        <!-- 归档标题 -->
        <h3 class="archive-title">
            <?php $this->archiveTitle([
                'category' => _t('分类 %s 下的文章'),
                'search'   => _t('包含关键字 %s 的文章'),
                'tag'      => _t('标签 %s 下的文章'),
                'author'   => _t('%s 发布的文章')
            ], '', ''); ?>
        </h3>

        <?php if ($this->have()): ?>
            <?php while ($this->next()): ?>
                <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
                    <!-- 文章标题 -->
                    <h2 class="post-title" itemprop="name headline">
                        <a itemtype="url" href="<?php $this->permalink(); ?>">
                            <?php $this->title(); ?>
                        </a>
                    </h2>

                    <!-- 元信息 -->
                    <?php render_post_meta($this); ?>

                    <!-- 文章摘要 -->
                    <div class="post-content" itemprop="articleBody">
                        <?php $this->content('- 阅读剩余部分 -'); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <article class="post">
                <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
            </article>
        <?php endif; ?>

        <!-- 分页导航 -->
        <?php $this->pageNav('« 前一页', '后一页 »'); ?>
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
        <li itemprop="interactionCount">
            <a href="<?php $post->permalink(); ?>#comments">
                <?php $post->commentsNum('评论', '1 条评论', '%d 条评论'); ?>
            </a>
        </li>
    </ul>
    <?php
}
?>