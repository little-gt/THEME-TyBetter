<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="col-mb-12 col-offset-1 col-3 kit-hidden-tb" id="secondary" role="complementary">

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('最新文章'); ?></h3>
            <ul class="widget-list">
                <?php $this->widget('Widget_Contents_Post_Recent')
                    ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('分类'); ?></h3>
            <?php $this->widget('Widget_Metas_Category_List')->listCategories('wrapClass=widget-list'); ?>
        </section>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
        <?php $archives = null; // Initialize archives variable ?>
        <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=F Y&limit=5')->to($archives); // Limit to 5 recent archives ?>
        <?php if ($archives->have()): // Check if there are any archives ?>
            <section class="widget">
                <h3 class="widget-title"><?php _e('归档'); ?></h3>
                <ul class="widget-list">
                    <?php while($archives->next()): ?>
                        <li><a href="<?php $archives->permalink(); ?>"><?php $archives->date(); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
        <section class="widget">
            <h3 class="widget-title"><?php _e('其它'); ?></h3>
            <ul class="widget-list">
                <?php if($this->user->hasLogin()): ?>
                    <li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?> (<?php $this->user->screenName(); ?>)</a></li>
                    <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                <?php else: ?>
                    <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                <?php endif; ?>
                <li><button onclick="window.location='<?php $this->options->feedUrl(); ?>';"><?php _e('文章 RSS'); ?></button></li>
                <li><button onclick="window.location='<?php $this->options->commentsFeedUrl(); ?>';"><?php _e('评论 RSS'); ?></button></li>
                <li><a href="http://www.typecho.org">Typecho</a></li>
            </ul>
        </section>
    <?php endif; ?>

</div><!-- end #sidebar -->
