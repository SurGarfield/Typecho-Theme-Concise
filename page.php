<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-content">
    <div class="container">
        <article class="entry">
            <h1 class="entry-title"><?php $this->title(); ?></h1>
            <div class="entry-meta">
                <span class="entry-date"><?php $this->date('Y-m-d'); ?></span>
                <span class="entry-sep"> / </span>
                <span class="entry-views"><?php conciseViews($this); ?> 阅读</span>
                <span class="entry-sep"> / </span>
                <span class="entry-author"><?php $this->author(); ?></span>
            </div>

            <div class="entry-content">
                <?php $this->content(); ?>
            </div>
        </article>
        <?php $this->need('comments.php'); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>


