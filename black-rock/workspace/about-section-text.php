<?php
$css = wp_get_custom_css();
if (strpos($css, '/* BRM about meet-keith text */') === false) {
    $css .= '

/* BRM about meet-keith text */
.kb-row-layout-id70_461967-d8 h2,.kb-row-layout-id70_461967-d8 h3{color:#fff !important;}
.kb-row-layout-id70_461967-d8 p{color:#cfe0de !important;}
.kb-row-layout-id70_461967-d8 .kt-adv-heading-link,.kb-row-layout-id70_461967-d8 a{color:#ffd97d !important;}
.kb-row-layout-id70_461967-d8 .eyebrow,.kb-row-layout-id70_461967-d8 h6{color:#5dcaa5 !important;}
';
    wp_update_custom_css_post($css);
    wp_cache_flush();
    echo "about section text colors forced readable\n";
} else echo "already present\n";
