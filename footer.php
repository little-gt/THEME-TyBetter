<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</div><!-- end .row -->
</div>
</div><!-- end #body -->

<!-- 页脚版权信息 -->
<footer id="footer" role="contentinfo">
    <div class="footer-container">
        <div class="footer-left">
            <div style="font-size: 14px; text-align: left;">
                版权所有 © <?php echo date('Y'); ?>
                <a href="<?php $this->options->siteUrl(); ?>">
                    <?php $this->options->title(); ?>
                </a> 保留所有权利 |
                <?php if ($this->options->footerICPNumber): ?>
                    <br><?php $this->options->footerICPNumber; ?>
                <?php endif; ?>
                <?php if ($this->options->footerSecurityRecord): ?>
                    <br><?php $this->options->footerSecurityRecord; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-right">
            <div style="font-size: 14px; text-align: left;">
                <?php if ($this->options->footerRecord): ?>
                    <br><?php $this->options->footerRecord; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- 动态调整页脚布局的 JavaScript -->
    <script type="text/javascript">
        window.addEventListener('load', function () {
            const footerContainer = document.querySelector('.footer-container');
            const footerLeft = document.querySelector('.footer-left');
            const footerRight = document.querySelector('.footer-right');
            const breakpoint = 600; // 定义断点，便于后续修改

            // 调整页脚布局的函数
            function adjustFooterLayout() {
                if (window.innerWidth <= breakpoint) {
                    footerLeft.style.width = '100%';
                    footerRight.style.width = '100%';
                    footerRight.style.textAlign = 'left';
                    footerContainer.style.display = 'block';
                    footerContainer.style.padding = '0 20px';
                } else {
                    footerLeft.style.width = 'calc(50% - 48px)';
                    footerRight.style.width = 'calc(50% - 48px)';
                    footerRight.style.textAlign = 'left';
                    footerContainer.style.display = 'flex';
                    footerContainer.style.justifyContent = 'space-between';
                    footerContainer.style.padding = '0 24px';
                }
            }

            // 初始化布局并监听窗口大小变化
            adjustFooterLayout();
            window.addEventListener('resize', adjustFooterLayout);
        });
    </script>

    <!-- 文章页面的 KaTeX 渲染支持 -->
    <?php if ($this->is('post') && $this->fields->isLatex == 1): ?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                renderMathInElement(document.body, {
                    delimiters: [
                        { left: "$$", right: "$$", display: true },
                        { left: "$", right: "$", display: false }
                    ],
                    ignoredTags: ["script", "noscript", "style", "textarea", "pre", "code"],
                    ignoredClasses: ["nokatex"]
                });
            });
        </script>
    <?php endif; ?>

    <?php $this->footer(); ?>
</footer>
</body>
</html>