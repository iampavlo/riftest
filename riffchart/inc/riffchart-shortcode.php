<?php

function reister_riffchart_shortcode() {
    global $post;
    ob_start();
    echo '<div id="chart_div"></div>';
    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}

add_shortcode('product-chart', 'reister_riffchart_shortcode');