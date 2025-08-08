<?php

return [
    'content' => [
        'edit' => 'Edit content',
        'created' => 'The content has been created.',
        'updated' => 'The content has been updated.',
        'deleted' => 'The content has been deleted.',
        'description' => 'Description',
        'name' => 'Name',
        'title' => 'Title',
        'value' => 'Content',
        'slug' => 'Slug',
        'article' => [
            'value' => '{0}Articles|[1,1]article|[2,*]articles'
        ],
        'category' => [
            'value' => '{0}Categories|[1,1]category|[2,*]categories',
            'created' => 'The category has been created.',
            'updated' => 'The category has been updated.',
            'deleted' => 'The category has been deleted.',
        ],
        'tag' => [
            'value' => '{0}Tags|[1,1]tag|[2,*]tags',
            'created' => 'The tag has been created.',
            'updated' => 'The tag has been updated.',
            'deleted' => 'The tag has been deleted.',
        ],
        'page' => [
            'value' => '{0}Pages|[1,1]page|[2,*]pages'
        ],
        'template' => [
            'value' => '{0}Templates|[1,1]template|[2,*]templates'
        ],
        'type' => [
            'article' => 'Article',
            'page' => 'Page',
            'header' => 'Header',
            'footer' => 'Footer',
            'value' => 'Type'
        ],
        'status' => [
            'archived' => 'Archived',
            'draft' => 'Draft',
            'published' => 'Published',
            'value' => 'Status',
        ],
        'published_at' => 'Published at'
    ],
    'editor' => [
        'category' => [
            'layout' => 'Layout',
            'template' => 'Template',
        ],
        'item' => [
            'delete' => [
                'confirmed' => 'The component has been deleted.',
            ],
        ],
        'parse' => [
            'error' => 'Unable to parse visual editor data.',
        ],
        'sidebar' => [
            'action' => [
                'copy' => [
                    'component' => 'Copy component',
                    'instructions' => 'You can paste the component on another page (CTRL + V).',
                    'page' => 'Copy page code',
                    'success' => 'The code has been copied.',
                ],
            ],
            'close' => 'Close',
            'component' => [
                'add' => 'Add a component',
                'all' => 'All components',
                'delete' => 'Delete a component',
                'search' => 'Search for a component',
                'unknown' => 'Unknown component',
            ],
            'empty' => 'You don’t have any content yet',
            'field' => [
                'htmltext' => [
                    'alignment' => [
                        'center' => 'Align center',
                        'justify' => 'Justify text',
                        'left' => 'Align left',
                        'right' => 'Align right',
                        'unset' => 'Reset text alignment',
                    ],
                    'bold' => 'Bold',
                    'color' => 'Color',
                    'formatting' => [
                        'remove' => 'Remove all formatting',
                    ],
                    'heading' => 'Heading :nr',
                    'highlight' => 'Highlight',
                    'italic' => 'Italic',
                    'link' => [
                        'unlink' => 'Remove link',
                        'value' => 'Link',
                    ],
                    'list' => [
                        'lift' => 'Move list item down',
                        'sink' => 'Move list item up',
                        'value' => 'List',
                    ],
                    'redo' => 'Redo',
                    'strike' => 'Strikethrough',
                    'underline' => 'Underline',
                    'undo' => 'Undo',
                    'video' => 'Video',
                ],
            ],
            'item' => 'Items',
            'mode' => [
                'responsive' => 'Responsive view',
            ],
            'tabs' => [
                'animation' => [
                    'delay' => 'Delay',
                    'general' => 'General',
                    'value' => 'Animations',
                    'view-transition-name' => 'Nom de transition de la vue',
                ],
                'appearance' => 'Appearance',
                'automatic-gallery' => [
                    'row' => [
                        'height' => 'Row height',
                    ],
                    'value' => 'Automatic gallery',
                ],
                'background' => [
                    'color' => 'Background color',
                    'image' => [
                        'position' => [
                            'bottom' => 'Bottom',
                            'center' => 'Center',
                            'left' => 'Left',
                            'right' => 'Right',
                            'top' => 'Top',
                            'x' => 'Position (X)',
                            'y' => 'Position (Y)',
                        ],
                        'repeat' => [
                            'no' => 'No repeat',
                            'value' => 'Repeat',
                        ],
                        'size' => [
                            'auto' => 'Original',
                            'contain' => 'Contain',
                            'cover' => 'Cover',
                            'value' => 'Image size',
                        ],
                        'opacity' => 'Opacity',
                        'value' => 'Background image',
                    ],
                    'value' => 'Background',
                ],
                'border' => [
                    'color' => 'Border color',
                    'radius' => [
                        'bottomleft' => 'Bottom Left',
                        'bottomright' => 'Bottom Right',
                        'topleft' => 'Top Left',
                        'topright' => 'Top Right',
                        'value' => 'Border radius',
                    ],
                    'line' => [
                        'blink' => 'Blink',
                        'line-through' => 'Line-through',
                        'underline' => 'Underline',
                        'overline' => 'Overline',
                        'value' => 'Border line',
                    ],
                    'style' => [
                        'dashed' => 'Dashed',
                        'dotted' => 'Dotted',
                        'solid' => 'Solid',
                        'wavy' => 'Wavy',
                        'value' => 'Border style',
                    ],
                ],
                'carousel' => [
                    'items-per-page' => 'Items per page',
                    'value' => 'Carousel',
                ],
                'contact' => [
                    'subject' => [
                        'option' => 'Option',
                        'value' => 'Subject',
                    ],
                    'value' => 'Contact form',
                ],
                'content' => 'Content',
                'ctas' => 'Appels à l\'action',
                'even-columns' => 'Columns',
                'form' => [
                    'value' => 'Form',
                    'sections' => [
                        'value' => 'Sections',
                        'visible' => 'Visible',
                    ],
                    'fields' => [
                        'value' => 'Fields',
                        'type' => 'Type',
                        'options' => 'Options',
                        'label' => 'Label',
                        'help' => 'Help'
                    ]
                ],
                'grid' => [
                    'gap' => 'Gap',
                    'item' => [
                        'size' => [
                            'min' => 'Minimum item size',
                        ],
                    ],
                    'value' => 'Grid',
                ],
                'header' => 'Header',
                'hero' => 'Hero',
                'image' => [
                    'alt' => 'Alt',
                    'height' => [
                        'help' => 'Leave empty for automatic height.',
                        'value' => 'Height',
                    ],
                    'value' => 'Image',
                ],
                'images' => 'Images',
                'label' => [
                    'help' => 'Leave empty to keep the page name.',
                    'value' => 'Label',
                ],
                'link' => [
                    'home' => 'Homepage',
                    'blog' => 'Articles',
                    'login' => 'Log in',
                    'profile' => 'Profile',
                    'type' => [
                        'external' => 'External link',
                        'internal' => 'Internal link',
                        'value' => 'Link type',
                    ],
                    'url' => 'URL',
                    'value' => 'Link',
                ],
                'links' => 'Links',
                'padding' => [
                    'block' => 'Vertical spacing',
                    'inline' => 'Horizontal spacing',
                ],
                'section' => 'Section',
                'theme-switcher' => 'Theme',
                'title' => [
                    'color' => 'Color',
                    'level' => 'Level',
                    'value' => 'Title',
                ],
            ],
            'template' => [
                'choose' => 'Choose a template',
                'use' => 'Use a template',
            ],
        ],
    ],
];