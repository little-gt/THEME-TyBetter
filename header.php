<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title><?php $this->archiveTitle(array(
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>

    <link rel="stylesheet" href="https://lf3-cdn-tos.bytecdn.com/cdn/expire-1-M/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/grid.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">

    <?php if ($this->is('post') && $this->fields->isLatex == 1): ?>
        <link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/KaTeX/0.15.2/katex.min.css" type="text/css" rel="stylesheet" />
        <script src="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/KaTeX/0.15.2/contrib/auto-render.min.js" type="application/javascript"></script>
        <script src="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/KaTeX/0.15.2/katex.js" type="application/javascript"></script>
    <?php endif; ?>

    <!--[if lt IE 9]>
    <script src="https://lf6-cdn-tos.bytecdn.com/cdn/expire-1-M/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://lf3-cdn-tos.bytecdn.com/cdn/expire-1-M/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php $this->header(); ?>
</head>
<body>
<!--[if lt IE 8]>
    <div class="browsehappy" role="dialog">
        <?php _e('很抱歉，当前网页 <strong>不支持</strong> 您正在使用的浏览器. 为了正常的访问, 建议您下载 <a href="https://www.microsoft.com/edge/download">Microsoft Edge</a> 浏览器。'); ?>
    </div>
<![endif]-->

<header id="header" class="clearfix">
    <div class="container">
        <div class="row">
            <div class="site-name col-mb-12 col-9">
                <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                    <?php if ($this->options->logoUrl): ?>
                        <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title(); ?>" />
                    <?php endif; ?>
                    <?php $this->options->title(); ?>
                </a>
                <p class="description"><?php $this->options->description(); ?></p>
            </div>
            <div class="site-search col-3 kit-hidden-tb">
                <form id="search" method="get" action="<?php $this->options->siteUrl(); ?>/search" role="search">
                    <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
                    <input type="text" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
                    <button type="submit" class="submit"><?php _e('搜索'); ?></button>
                </form>
            </div>
            <div class="col-mb-12">
                <nav id="nav-menu" class="clearfix" role="navigation">
                    <a<?php if ($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while ($pages->next()): ?>
                        <a<?php if ($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                    <?php endwhile; ?>
                </nav>
            </div>
        </div><!-- end .row -->
    </div>
</header><!-- end #header -->

<div id="body">
    <div class="container">
        <div class="row">
            <!-- 正文内容区域 -->