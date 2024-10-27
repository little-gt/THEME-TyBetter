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

$this->need('header.php');
?>

    <div class="col-mb-12 col-8" id="main" role="main">
        <?php while($this->next()): ?>
            <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
                <h2 class="post-title" itemprop="name headline">
                    <a itemtype="url" href="<?php $this->permalink() ?>">
                        <?php $this->title() ?>
                    </a>
                </h2>
                <ul class="post-meta">
                    <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <?php _e('作者: '); ?>
                        <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author">
                            <?php $this->author(); ?>
                        </a>
                    </li>
                    <li>
                        <?php _e('时间: '); ?>
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">
                            <?php $this->date('F j, Y'); ?>
                        </time>
                    </li>
                    <li>
                        <?php _e('分类: '); ?>
                        <?php $this->category(','); ?>
                    </li>
                    <li itemprop="interactionCount">
                        <a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments">
                            <?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?>
                        </a>
                    </li>
                </ul>
                <div class="post-content" itemprop="articleBody">
                    <?php
                    // 获取主题配置中的摘要长度，默认为 100 字
                    $excerptLength = $this->options->excerptLength ?: 100;
                    $this->excerpt($excerptLength, '');
                    ?>
                </div>
            </article>
        <?php endwhile; ?>

        <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    </div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>