<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="comments">
    <?php $this->comments()->to($comments); ?>

    <?php if ($comments->have()): ?>
    <h3 class="comments-title"><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></h3>
    
    <div class="comment-list">
        <?php $comments->listComments(array(
            'before' => '<ol class="comment-ol">',
            'after'  => '</ol>',
            'avatarSize' => 48,
            'replyWord' => '回复',
            'dateFormat' => 'Y-m-d H:i',
            'callback' => 'threadedComments'
        )); ?>
        <?php $comments->pageNav('上一页', '下一页'); ?>
    </div>
    <?php endif; ?>

    <?php if ($this->allow('comment')): ?>
    <div id="respond" class="comment-respond">
        <h4 class="respond-title"><?php _e('发表评论'); ?></h4>
        
        <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" role="form">
            <?php if($this->user->hasLogin()): ?>
                <div class="login-info">
                    <span class="li-text"><?php _e('登录身份：'); ?></span>
                    <a class="li-user" href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
                    <span class="li-sep"> · </span>
                    <a class="li-logout" href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a>
                </div>
            <?php endif; ?>
            
            <div class="comment-textarea">
                <textarea id="textarea" name="text" placeholder="评论内容..." required><?php $this->remember('text'); ?></textarea>
            </div>

            <input type="hidden" name="parent" id="comment-parent" value="<?php $this->remember('parent'); ?>" />
            
            <div class="comment-fields">
                <?php if(!$this->user->hasLogin()): ?>
                    <input type="text" name="author" id="author" class="field" placeholder="昵称" value="<?php $this->remember('author'); ?>" required />
                    <input type="email" name="mail" id="mail" class="field" placeholder="邮箱" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                    <input type="url" name="url" id="url" class="field" placeholder="网站（选填）" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireUrl): ?> required<?php endif; ?> />
                <?php endif; ?>
                <button type="submit" class="comment-submit"><?php _e('提交评论'); ?></button>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="comments-closed">
        <?php _e('评论已关闭'); ?>
    </div>
    <?php endif; ?>
</div>

