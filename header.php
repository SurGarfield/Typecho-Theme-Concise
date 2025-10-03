<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>

    <?php $this->header(); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/viewerjs@1.11.6/dist/viewer.min.css">
    <script src="https://cdn.jsdelivr.net/npm/viewerjs@1.11.6/dist/viewer.min.js"></script>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1 class="site-title">
                <a href="<?php $this->options->siteUrl(); ?>">
                    <?php if ($this->options->logoUrl): ?>
                        <img src="<?php $this->options->logoUrl(); ?>" alt="<?php $this->options->title(); ?>" class="site-logo">
                    <?php else: ?>
                        <?php $this->options->title() ?>
                    <?php endif; ?>
                </a>
            </h1>
            <button class="menu-toggle" aria-label="菜单"></button>
        </div>
    </header>

    <nav class="main-nav">
        <div class="nav-container">
            <div class="nav-content">
                <ul>
                    <li><a href="<?php $this->options->siteUrl(); ?>">Home</a></li>
                    <li><a href="<?php $this->options->siteUrl(); ?>index.php/blog/">Article</a></li>
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                    <li><a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </nav>
