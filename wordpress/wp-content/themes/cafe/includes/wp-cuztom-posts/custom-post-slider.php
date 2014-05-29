<?php
//Create article custom post type
$slider = register_cuztom_post_type( 'Slider', array( 'supports' => array('title')));

$slider->add_meta_box(
    'id',
    'Slider',
    array(
        array(
            'name'          => 'slider',
            'label'         => 'Slider Image',
            'description'   => 'Upload slider',
            'type'          => 'image',
            
        ),
    )
);

?>