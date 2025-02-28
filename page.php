<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

    <div class="col-mb-12 col-8" id="main" role="main">
        <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
            <!-- 页面标题 -->
            <h1 class="post-title" itemprop="name headline">
                <a itemtype="url" href="<?php $this->permalink(); ?>">
                    <?php $this->title(); ?>
                </a>
            </h1>

            <!-- 页面内容 -->
            <div class="post-content" itemprop="articleBody">
                <?php $this->content(); ?>
            </div>
        </article>
    </div><!-- end #main -->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>