<div class="n2-table n2-table-fixed n2-ss-slider-publish">
    <div class="n2-tr">
        <div class="n2-td n2-first">
            <div class="n2-h2"><?php n2_ex('Insert widget', 'magento'); ?></div>

            <div class="n2-h4"><?php n2_e('Copy and paste this shortcode into your pages:'); ?></div>
            <code><div onclick="return selectText(this);">{{widget type="nextend2smartslider3/slider" slider="<?php echo $sliderid; ?>"}}</div></code>
        </div>
        <div class="n2-td">
            <div class="n2-h2"><?php n2_e('Page or Post editor'); ?></div>

            <div class="n2-h4"><?php n2_e('Insert the slider into pages with the icon:'); ?></div>
            <img
                src="<?php echo N2ImageHelper::fixed('$ss$/admin/images/magento-publish.png') ?>"/>
        </div>
        <div class="n2-td n2-last">
            <div class="n2-h2"><?php n2_e('Shortcode'); ?></div>

            <div class="n2-h4"><?php n2_e('Copy and paste this shortcode anywhere:'); ?></div>
            <code><div onclick="return selectText(this);">smartslider3[<?php echo $sliderid; ?>]</div></code>
        </div>
    </div>
</div>