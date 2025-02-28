<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div id="comments">
    <?php $this->comments()->to($comments); ?>

    <!-- 评论列表 -->
    <?php if ($this->haveComments()): ?>
        <h3 class="comments-title"><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></h3>
        <?php $comments->listComments(); ?>
        <?php $comments->pageNav('« 前一页', '后一页 »'); ?>
    <?php endif; ?>

    <!-- 评论表单 -->
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <h3 class="comment-form-title"><?php _e('添加新评论'); ?></h3>
            <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" role="form">
                <?php if ($this->user->hasLogin()): ?>
                    <p><?php _e('已登录为'); ?> <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.
                        <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?></a></p>
                <?php else: ?>
                    <p>
                        <label for="author" class="required"><?php _e('称呼'); ?></label>
                        <input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
                    </p>
                    <p>
                        <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('邮箱'); ?></label>
                        <input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                    </p>
                    <p>
                        <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
                        <input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                    </p>
                <?php endif; ?>
                <p>
                    <label for="textarea" class="required"><?php _e('内容'); ?></label>
                    <textarea rows="8" cols="50" name="text" id="textarea" class="textarea" required><?php $this->remember('text'); ?></textarea>
                </p>

                <!-- 人机验证 -->
                <p>
                    <label for="captcha" class="required"><?php _e('验证问题'); ?></label>
                    <?php $captcha = generateCaptcha(); ?>
                    <span id="captcha-question"><?php echo $captcha['question']; ?></span>
                    <input type="hidden" name="captcha_key" value="<?php echo $captcha['key']; ?>" />
                    <input type="text" name="captcha_answer" id="captcha" class="text" placeholder="<?php _e('输入答案'); ?>" required />
                    <button type="button" class="refresh-captcha modern-button" style="padding: 5px 10px; font-size: 14px;"><?php _e('刷新'); ?></button>
                </p>

                <p>
                    <button type="submit" class="submit modern-button"><?php _e('提交评论'); ?></button>
                </p>
            </form>
        </div>
    <?php else: ?>
        <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
</div><!-- end #comments -->

<style>
    .comments-title, .comment-form-title {
        font-size: 1.5em;
        margin-bottom: 15px;
    }
    .comment-list {
        list-style: none;
        padding: 0;
    }
    .comment-list li {
        margin-bottom: 20px;
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .respond {
        margin-top: 20px;
    }
    .text, .textarea {
        width: 100%;
        max-width: 500px;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    #captcha-question {
        display: inline-block;
        margin-right: 10px;
        font-weight: bold;
    }
    .modern-button {
        background-color: #1E88E5;
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    .modern-button:hover {
        background-color: #1976D2;
    }
</style>

<script>
    document.querySelector('.refresh-captcha').addEventListener('click', function() {
        fetch('<?php $this->options->siteUrl(); ?>?action=refresh_captcha', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                document.getElementById('captcha-question').textContent = data.question;
                document.querySelector('input[name="captcha_key"]').value = data.key;
                document.getElementById('captcha').value = '';
            });
    });
</script>