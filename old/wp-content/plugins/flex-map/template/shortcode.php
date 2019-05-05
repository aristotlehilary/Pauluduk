<?php

function map_frame( $map_id, $map_data ) {
    $general = json_decode($map_data[$map_id]['general']);

    $show = '';
    $show .= '<div class="fl-wrapper mymaps-area-' . $map_id . '" style="">';

    $show .= '  <div class="map-wrapper-' . $map_id . '" style="width=100%;height:500px;">';

    $show .=    '<div id="map-canvas-' . $map_id . '" style="width:100%;height:100%;top:0;left:0;"></div>';
    $show .= '</div>';
    $show .= '<div class="legend-carousel-' . $map_id . '" style="width:100%;">';
    $show .= '</div>
            </div><style>.mymaps-area-' . $map_id . ' img{ visibility:visible; }</style>';
    return $show;
}