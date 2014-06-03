<?php
//Create article custom post type
$slider = register_cuztom_post_type( 'Slider', array( 'supports' => array('title', 'page-attributes')));

$slider->add_meta_box(
    'id',
    'Slider',
    array(
        array(
            'name'          => 'image',
            'label'         => 'Image',
            'description'   => 'Upload image',
            'type'          => 'image',
        ),
        array(
            'name'          => 'image_link',
            'label'         => 'Image URL',
            'description'   => 'Example: http://www.google.ca',
            'type'          => 'text',
        ),
        array(
            'name'          => 'video_url',
            'label'         => 'Video URL',
            'description'   => 'Example: http://www.youtube.ca/...',
            'type'          => 'text',
            
        ),
    )
);

?>