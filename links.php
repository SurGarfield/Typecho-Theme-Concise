<?php
/**
 * 友情链接
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php $this->need('header.php'); ?>

<div class="main-content">
    <div class="container">
        <article class="entry">
            <h1 class="entry-title"><?php $this->title(); ?></h1>
            <div class="entry-meta">
                <span class="entry-date"><?php $this->date('Y-m-d'); ?></span>
                <span class="entry-sep"> / </span>
                <span class="entry-views"><?php conciseViews($this); ?> 阅读</span>
            </div>

            <div class="entry-content">
                <?php $this->content(); ?>
            </div>

            <?php if (class_exists('Links_Plugin')): ?>
            <div class="links-container">
                <?php
                $links = array();
                try {
                    $db = Typecho_Db::get();
                    $prefix = $db->getPrefix();
                    $links = $db->fetchAll($db->select()->from($prefix . 'links')
                        ->where('state = ?', 1)
                        ->order($prefix . 'links.order', Typecho_Db::SORT_ASC));
                } catch (Exception $e) {
                }
                ?>
                <?php if (!empty($links)): ?>
                <div class="links-grid">
                    <?php
                    foreach ($links as $link):
                        $domain = parse_url($link['url'], PHP_URL_HOST);
                        if (!$domain) {
                            $domain = $link['url'];
                        }
                    ?>
                    <div class="link-item">
                        <h3 class="link-name">
                            <a href="<?php echo $link['url']; ?>" title="<?php echo htmlspecialchars($link['description']); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($link['name']); ?></a>
                        </h3>
                        <p class="link-desc"><?php echo htmlspecialchars($link['description']); ?></p>
                        <a href="<?php echo $link['url']; ?>" target="_blank" rel="noopener" class="link-url"><?php echo htmlspecialchars($domain); ?></a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="links-notice">
                    <p>暂无友情链接，请在后台「管理」→「友情链接」中添加。</p>
                </div>
                <?php endif; ?>

                <div class="links-apply">
                    <h3>申请友链</h3>
                    <p>欢迎交换友情链接，请在下方评论区留言，格式如下：</p>
                    <ul>
                        <li>网站名称：你的网站名称</li>
                        <li>网站地址：https://yoursite.com</li>
                        <li>网站描述：简短描述（建议20字以内）</li>
                    </ul>
                    <p>本站信息：</p>
                    <ul>
                        <li>网站名称：<?php $this->options->title(); ?></li>
                        <li>网站地址：<?php $this->options->siteUrl(); ?></li>
                        <li>网站描述：<?php $this->options->description(); ?></li>
                    </ul>
                </div>
            </div>
            <?php else: ?>
            <div class="links-container">
                <div class="links-notice">
                    <p>友情链接功能需要启用 <strong>Links 插件</strong>。</p>
                    <p>请在后台「控制台」→「插件」中启用「友情链接」插件。</p>
                </div>
            </div>
            <?php endif; ?>
        </article>
        
        <?php $this->need('comments.php'); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
