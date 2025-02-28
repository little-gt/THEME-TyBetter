<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</div>
<!-- end .row -->
</div>
</div>
<!-- end #body -->

<!-- footer版权信息 -->
<footer id="footer" role="contentinfo">
    <div class="footer-container">
        <div class="footer-left">
            <div style="font-size: 14px; text-align: left;">
                版权所有 &copy; <?php echo date('Y'); ?> <a href="<?php echo $this->options->siteUrl(); ?>"><?php echo $this->options->title(); ?></a> 保留所有权利 |
                <?php if ($this->options->footerICPNumber): ?>
                    <br><?php echo $this->options->footerICPNumber; ?>
                <?php endif; ?>
                <?php if ($this->options->footerSecurityRecord): ?>
                    <br><?php echo $this->options->footerSecurityRecord; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-right">
            <div style="font-size: 14px; text-align: left;">
                <?php if ($this->options->footerRecord): ?>
                    <br><?php echo $this->options->footerRecord; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.addEventListener('load', function () {
            var footerContainer = document.querySelector('.footer-container');
            var footerLeft = document.querySelector('.footer-left');
            var footerRight = document.querySelector('.footer-right');

            // 根据屏幕宽度调整布局
            function adjustFooterLayout() {
                if (window.innerWidth <= 600) { // 设定一个断点，例如600px
                    footerLeft.style.width = '100%';
                    footerRight.style.width = '100%';
                    footerRight.style.textAlign = 'left';
                    footerContainer.style.display = 'block'; // 块级布局
                    footerContainer.style.padding = '0 20px'; // 给容器添加左右内边距
                } else {
                    footerLeft.style.width = 'calc(50% - 48px)'; // 减去右边的间距
                    footerRight.style.width = 'calc(50% - 48px)';
                    footerRight.style.textAlign = 'left';
                    footerContainer.style.display = 'flex'; // 水平排列
                    footerContainer.style.justifyContent = 'space-between'; // 分隔两边内容
                    footerContainer.style.padding = '0 24px'; // 给容器添加左右内边距
                }
            }

            // 初始化时调整一次布局
            adjustFooterLayout();
            // 当窗口大小改变时重新调整布局
            window.addEventListener('resize', adjustFooterLayout);
        });
    </script>

    <?php if ($this->is('post') && $this->fields->isLatex == 1): ?>
        <script type = "text/javascript" >
            document.addEventListener("DOMContentLoaded", function() {
                renderMathInElement(document.body, {
                    delimiters: [{
                        left: "$$",
                        right: "$$",
                        display: true
                    }, {
                        left: "$",
                        right: "$",
                        display: false
                    }],
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