<?php
function textbox( $param_properties )
{
    $extra_class = (isset( $param_properties['class']))?$param_properties['class'] : '';
    $attrs = (isset( $param_properties['attrs']))?$param_properties['attrs'] : '';
    $require = ( isset( $param_properties['require'] ) )? '<span class="setting_required">*</span>' : '';
    $des = ( isset( $param_properties['des'] ) )? '<span class="description">' . $param_properties['des'] . '</span>': '';

    echo'<div class="mymaps-row"><div class="field_title">' . $param_properties['title'] . '</div>
                        <div class="field_container">
                            <input type="text" class="' . $extra_class . '" id="' . $param_properties['id'] . '" name="' . $param_properties['name'] . '" value="' . $param_properties['value'] . '" ' . $attrs . '>' . $require . ' <br> ' . $des . '
                        </div>
        </div>';

}