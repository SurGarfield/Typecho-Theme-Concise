<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php $this->options->title(); ?>. All rights reserved.</p>
        </div>
    </footer>

    <button id="backToTop" class="back-to-top" aria-label="返回顶部" title="返回顶部">↑</button>

    <script src="<?php $this->options->themeUrl('script.js'); ?>?v=<?php echo time(); ?>"></script>
    
    <?php if ($this->options->statisticsCode): ?>
    <?php $this->options->statisticsCode(); ?>
    <?php endif; ?>
    
    <?php $this->footer(); ?>
</body>
</html>
