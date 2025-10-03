<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php $this->need('header.php'); ?>

<div class="main-content">
    <div class="container">
        <div class="blog-page">
            <div class="blog-intro">
                <?php if ($this->options->blogText1): ?>
                <p class="blog-text-1"><?php echo $this->options->blogText1; ?></p>
                <?php endif; ?>
                
                <?php if ($this->options->blogText2): ?>
                <p class="blog-text-2"><?php echo $this->options->blogText2; ?></p>
                <?php endif; ?>
            </div>

            <div class="blog-posts">
                <?php
                $db = Typecho_Db::get();
                $posts = $db->fetchAll($db->select()->from('table.contents')
                    ->where('table.contents.status = ?', 'publish')
                    ->where('table.contents.type = ?', 'post')
                    ->order('table.contents.created', Typecho_Db::SORT_DESC)
                    ->limit(4));
                
                foreach ($posts as $post):
                    $postUrl = Typecho_Router::url('post', array(
                        'cid' => $post['cid'],
                        'slug' => $post['slug']
                    ), $this->options->index);
                ?>
                <article class="blog-post-item">
                    <h3 class="blog-post-title">
                        <a href="<?php echo $postUrl; ?>"><?php echo $post['title']; ?></a>
                    </h3>
                    <div class="blog-post-date">
                        <?php echo date('Y-m-d', $post['created']); ?>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <div class="blog-author-intro">
                <div class="author-intro-avatar">
                    <?php if ($this->options->authorAvatar): ?>
                        <img src="<?php echo $this->options->authorAvatar; ?>" alt="博主头像">
                    <?php else: ?>
                        <img src="<?php $this->options->themeUrl('touxiang.png'); ?>" alt="博主头像">
                    <?php endif; ?>
                </div>
                <div class="author-intro-info">
                    <h3 class="author-intro-name">
                        <?php echo $this->options->authorName ?: $this->options->title; ?>
                    </h3>
                    <div class="author-intro-desc">
                        <?php echo $this->options->authorDesc ?: '这个博主很懒，还没有填写介绍...'; ?>
                    </div>
                    <div class="author-intro-meta">
                        <div class="author-meta-item">
                            <span class="meta-label">博客主题</span>
                            <span class="meta-value">Concise</span>
                        </div>
                        <div class="author-meta-item">
                            <span class="meta-label">博客框架</span>
                            <span class="meta-value">Typecho</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="blog-actions">
                <?php
                $blogUrl = $this->options->siteUrl . 'index.php/blog/';
                $aboutUrl = $this->options->siteUrl . 'index.php/about.html';
                ?>
                <a href="<?php echo $blogUrl; ?>" class="blog-btn">文章列表</a>
                <a href="<?php echo $aboutUrl; ?>" class="blog-btn">查看关于</a>
            </div>
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>
