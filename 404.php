<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-content">
    <div class="container">
        <div class="error-page">
            <div class="error-content">
                <h1 class="error-code">404</h1>
                <h2 class="error-title">页面未找到</h2>
                <p class="error-message">抱歉，您访问的页面不存在或已被移除。</p>
                
                <div class="error-actions">
                    <a href="<?php $this->options->siteUrl(); ?>" class="error-btn">返回首页</a>
                    <a href="<?php $this->options->siteUrl(); ?>index.php/blog/" class="error-btn">查看文章</a>
                </div>
                
                <div class="error-suggestions">
                    <p class="suggestions-title">您可以尝试：</p>
                    <ul class="suggestions-list">
                        <li>检查 URL 是否正确</li>
                        <li>使用上方导航菜单</li>
                        <li>返回首页重新开始</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>
