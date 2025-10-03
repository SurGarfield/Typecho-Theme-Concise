<?php
/**
 * Concise 简约主题
 * @package Concise
 * @author 森木志
 * @version 1.0.0
 * @link https://oxxx.cn
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="main-content">
    <div class="container">
        <?php if ($this->have()): ?>
        <div class="posts-grid">
            <?php while($this->next()): ?>
            <article class="post-item">
                <h2 class="post-title">
                    <a href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                </h2>
                <div class="post-meta">
                    <span class="post-date"><?php $this->date('Y-m-d'); ?></span>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <nav class="pagination">
            <div class="page-nav">
                <?php 
                ob_start();
                $this->pageLink('上一页', 'prev');
                $prevLink = ob_get_clean();
                
                if ($prevLink) {
                    echo $prevLink;
                } else {
                    echo '<span class="no-prev">没有哟</span>';
                }
                
                echo '<span class="separator">/</span>';
                
                ob_start();
                $this->pageLink('下一页', 'next');
                $nextLink = ob_get_clean();
                
                if ($nextLink) {
                    echo $nextLink;
                } else {
                    echo '<span class="no-next">没有哟</span>';
                }
                ?>
            </div>
        </nav>
        <?php else: ?>
        <div class="posts-grid">
            <p style="text-align: center; padding: 60px 20px; color: #666;">暂无文章</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
