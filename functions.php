<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'logoUrl', 
        NULL, 
        NULL, 
        _t('网站 Logo 地址'), 
        _t('输入 Logo 图片地址，留空则显示网站标题文字。支持相对路径和绝对路径。')
    );
    $form->addInput($logoUrl);
    
    $statisticsCode = new Typecho_Widget_Helper_Form_Element_Textarea(
        'statisticsCode', 
        NULL, 
        NULL, 
        _t('统计代码'), 
        _t('在这里填入第三方统计代码（如百度统计、Google Analytics 等），代码将插入到页面底部 </body> 标签之前。')
    );
    $form->addInput($statisticsCode);
    
    $blogText1 = new Typecho_Widget_Helper_Form_Element_Text(
        'blogText1', 
        NULL, 
        '欢迎来到我的博客', 
        _t('Blog 页面文字 1'), 
        _t('显示在 Blog 页面顶部的第一行文字')
    );
    $form->addInput($blogText1);
    
    $blogText2 = new Typecho_Widget_Helper_Form_Element_Text(
        'blogText2', 
        NULL, 
        '分享我的思考与创作', 
        _t('Blog 页面文字 2'), 
        _t('显示在 Blog 页面顶部的第二行文字')
    );
    $form->addInput($blogText2);
    
    $authorAvatar = new Typecho_Widget_Helper_Form_Element_Text(
        'authorAvatar', 
        NULL, 
        NULL, 
        _t('博主头像地址'), 
        _t('输入博主头像图片地址，显示在 Blog 页面的博主介绍区域。推荐尺寸：200x200 像素。留空则使用主题默认头像 touxiang.png')
    );
    $form->addInput($authorAvatar);
    
    $authorName = new Typecho_Widget_Helper_Form_Element_Text(
        'authorName', 
        NULL, 
        NULL, 
        _t('博主名称'), 
        _t('显示在 Blog 页面博主介绍区域的名称，留空则显示网站标题')
    );
    $form->addInput($authorName);
    
    $authorDesc = new Typecho_Widget_Helper_Form_Element_Textarea(
        'authorDesc', 
        NULL, 
        NULL, 
        _t('博主介绍'), 
        _t('显示在 Blog 页面博主介绍区域的个人简介')
    );
    $form->addInput($authorDesc);
}

function conciseViews($archive) {
    $cid = $archive->cid;
    $db = Typecho_Db::get();

    $cookieKey = 'concise_view_' . $cid;
    if ($archive->is('single') && empty($_COOKIE[$cookieKey])) {
        $row = $db->fetchRow($db->select('int_value')
            ->from('table.fields')
            ->where('cid = ?', $cid)
            ->where('name = ?', 'views'));
        if ($row) {
            $views = (int)$row['int_value'] + 1;
            $db->query($db->update('table.fields')
                ->rows(array('int_value' => $views))
                ->where('cid = ?', $cid)
                ->where('name = ?', 'views'));
        } else {
            $views = 1;
            $db->query($db->insert('table.fields')->rows(array(
                'cid' => $cid,
                'name' => 'views',
                'type' => 'int',
                'str_value' => '',
                'int_value' => $views,
                'float_value' => 0
            )));
        }
        setcookie($cookieKey, '1', time() + 3600, '/');
    }

    $row = $db->fetchRow($db->select('int_value')
        ->from('table.fields')
        ->where('cid = ?', $cid)
        ->where('name = ?', 'views'));
    $views = $row ? (int)$row['int_value'] : 0;
    echo $views;
}

function threadedComments($comments, $options) {
    $commentId = 'li-comment-' . $comments->coid;
    $commentClass = 'comment-body';
    if ($comments->authorId == $comments->ownerId) {
        $commentClass .= ' comment-by-author';
    }
    
    echo '<li itemscope itemtype="http://schema.org/Comment" id="' . $commentId . '" class="' . $commentClass . '">';
    
    echo '<div class="comment-author" itemprop="author" itemscope itemtype="http://schema.org/Person">';
    echo '<span itemprop="image">';
    $comments->gravatar($options->avatarSize ?: 48, null, null, 'avatar');
    echo '</span>';
    echo '<div class="author-info">';
    echo '<div class="author-name-line">';
    echo '<cite class="fn" itemprop="name">';
    if ($comments->url) {
        echo '<a href="' . $comments->url . '" target="_blank" rel="external nofollow">';
        $comments->author();
        echo '</a>';
    } else {
        $comments->author();
    }
    echo '</cite>';
    echo '<span class="comment-reply">';
    echo '<a href="#respond" class="comment-reply-link" data-comment-id="' . $comments->coid . '">';
    echo $options->replyWord ?: _t('回复');
    echo '</a>';
    echo '</span>';
    echo '</div>';
    echo '<span class="comment-meta">';
    echo '<a href="' . $comments->permalink . '">';
    echo '<time itemprop="datePublished" datetime="' . date('c', $comments->created) . '">';
    $comments->date($options->dateFormat ?: 'Y-m-d H:i');
    echo '</time>';
    echo '</a>';
    echo '</span>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="comment-content" itemprop="text">';
    $comments->content();
    echo '</div>';
    
    if ($comments->children) {
        echo '<div class="comment-children">';
        $comments->threadedComments($options);
        echo '</div>';
    }
    
    echo '</li>';
}
?>
