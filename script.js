document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    const body = document.body;

    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            const isActive = menuToggle.classList.contains('active');
            
            if (!isActive) {
                menuToggle.classList.add('active');
                menuToggle.classList.add('fixed');
                mainNav.classList.add('active');
                body.style.overflow = 'hidden';
            } else {
                closeMenu();
            }
        });

        function closeMenu() {
            menuToggle.classList.remove('active');
            menuToggle.classList.remove('fixed');
            mainNav.classList.remove('active');
            body.style.overflow = '';
        }

        mainNav.addEventListener('click', function(e) {
            if (e.target === mainNav) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mainNav.classList.contains('active')) {
                closeMenu();
            }
        });
    }

    const paginationLinks = document.querySelectorAll('.pagination a');

    paginationLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
    });

    const backBtn = document.getElementById('backToTop');
    if (backBtn) {
        const onScroll = () => {
            if (window.scrollY > 300) backBtn.classList.add('show');
            else backBtn.classList.remove('show');
        };
        window.addEventListener('scroll', onScroll);
        backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        onScroll();
    }

    window.addEventListener('load', function() {});

    const siteTitle = document.querySelector('.site-title');
    if (siteTitle) {
        const titleText = siteTitle.querySelector('a').textContent;
        siteTitle.setAttribute('data-text', titleText);
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    const entryContent = document.querySelector('.entry-content');
    if (entryContent && typeof Viewer !== 'undefined') {
        const images = entryContent.querySelectorAll('img');
        
        if (images.length > 0) {
            images.forEach(img => {
                if (img.parentElement.tagName !== 'A') {
                    img.setAttribute('data-viewer', 'true');
                }
            });
            
            const viewer = new Viewer(entryContent, {
                toolbar: {
                    zoomIn: 1,
                    zoomOut: 1,
                    oneToOne: 1,
                    reset: 1,
                    prev: 1,
                    play: 0,
                    next: 1,
                    rotateLeft: 1,
                    rotateRight: 1,
                    flipHorizontal: 0,
                    flipVertical: 0,
                },
                title: [1, (image, imageData) => {
                    return image.alt || `图片 ${imageData.index + 1} / ${viewer.length}`;
                }],
                navbar: true,
                tooltip: true,
                movable: true,
                zoomable: true,
                rotatable: true,
                scalable: true,
                transition: true,
                fullscreen: true,
                keyboard: true,
                url: 'src',
                filter: (image) => {
                    return image.tagName === 'IMG';
                }
            });
        }
    }
    
    const commentContent = document.querySelectorAll('.comment-content');
    if (commentContent.length > 0 && typeof Viewer !== 'undefined') {
        commentContent.forEach(content => {
            const images = content.querySelectorAll('img');
            if (images.length > 0) {
                new Viewer(content, {
                    toolbar: {
                        zoomIn: 1,
                        zoomOut: 1,
                        oneToOne: 1,
                        reset: 1,
                        prev: 0,
                        play: 0,
                        next: 0,
                        rotateLeft: 1,
                        rotateRight: 1,
                        flipHorizontal: 0,
                        flipVertical: 0,
                    },
                    navbar: false,
                    tooltip: true,
                    url: 'src',
                });
            }
        });
    }

    initCommentReply();
    
    function initCommentReply() {
        const respondElement = document.getElementById('respond');
        const commentParent = document.getElementById('comment-parent');
        let currentReplyLink = null;

        if (!respondElement || !commentParent) {
            return;
        }

        const originalParent = respondElement.parentNode;
        const originalNextSibling = respondElement.nextSibling;

        bindReplyLinks();

        function bindReplyLinks() {
            const replyLinks = document.querySelectorAll('.comment-reply-link');
            
            replyLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    handleReplyClick(this);
                });
            });
        }

        function handleReplyClick(replyLink) {
            const commentId = replyLink.getAttribute('data-comment-id');
            if (!commentId) return;

            const commentLi = document.getElementById('li-comment-' + commentId);
            if (!commentLi) return;

            if (currentReplyLink === replyLink) {
                cancelReply();
                return;
            }

            if (currentReplyLink) {
                currentReplyLink.textContent = '回复';
            }

            replyLink.textContent = '取消回复';
            currentReplyLink = replyLink;

            const commentContentEl = commentLi.querySelector('.comment-content');
            if (!commentContentEl) return;

            if (commentContentEl.nextSibling) {
                commentContentEl.parentNode.insertBefore(respondElement, commentContentEl.nextSibling);
            } else {
                commentContentEl.parentNode.appendChild(respondElement);
            }

            commentParent.value = commentId;

            setTimeout(function() {
                respondElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const textarea = respondElement.querySelector('textarea');
                if (textarea) textarea.focus();
            }, 100);
        }

        function cancelReply() {
            if (currentReplyLink) {
                currentReplyLink.textContent = '回复';
                currentReplyLink = null;
            }

            if (originalNextSibling) {
                originalParent.insertBefore(respondElement, originalNextSibling);
            } else {
                originalParent.appendChild(respondElement);
            }

            commentParent.value = '0';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && currentReplyLink) {
                cancelReply();
            }
        });
    }
});