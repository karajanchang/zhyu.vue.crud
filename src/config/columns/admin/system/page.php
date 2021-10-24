<?php

return [
    'model' => ZhyuVueCurd\Models\Page::class,
    'title' => '頁面管理',
    'index_buttons' => [
        'width' => 200,
        'update' => [
            'label' => '修改',
            'url' => '/admin/system/page/{id}/edit',
            'css' => 'is-info',
            'type'=> 'update'
        ],
        'delete' => [
            'label' => '刪除',
            'url' => '/admin/system/page/{id}',
            'css' => 'is-danger',
            'type'=> 'delete'
        ],
        [
            'label' => '版面管理',
            'url' => '/admin/system/pagecontent/{id}/index',
            'css' => 'is-primary',
            'type' => 'button',
        ],
        [
            'label' => '左選單',
            'url' => '/admin/system/page/{id}/arrangement',
            'css' => 'is-primary',
            'type' => 'button',
        ],
    ],
    'form_buttons' => [
        [
            'label' => '取消',
            'url' => '/admin/system/page',
            'css' => 'is-default',
            'type'=> 'cancel'
        ],
        [
            'label' => '送出',
            'css' => 'is-primary',
            'type'=> 'submit'
        ],
    ],
    'columns' => [
        'title' =>
            [
                'name' => '頁面主題',
                'type' => 'text',
                'rules' => [
                    'store' =>  'required|string',
                    'update' =>  'required|string',
                ],
                'params' => [
                    'sortable', 'searchable',
                ],
            ],
        /*
        'banner' =>
            [
                'name' => '頁面Banner',
                'type' => 'image', //---file or image
                'rules' => [
                    'store' =>  'nullable|image',
                    'update' =>  'nullable|image',
                ],
                'params' => [
                    'sortable', 'searchable',
                ],
            ],
        */
        'uri' =>
            [
                'name' => '網址uri',
                'type' => 'text',
                'rules' => [
                    'store' =>  'string',
                    'update' =>  'string',
                ],
                'params' => [
                    'sortable', 'searchable',
                ],
            ],
        'layout' =>
            [
                'name' => '佈局',
                'description' => '可用版型： 內頁 "page" / 無 "empty"',
                'type' => 'radio',
                'rules' => [
                    'store' =>  'string',
                    'update' =>  'string',
                ],
                'values' => [
                    'page' => '內頁layout',
                    'empty' => '空layout',
                ],
                'defaultValue' => 'page',
                'params' => [
                ],
            ],

        'left_menu_id' =>
            [
                'name' => '左選單',
                'type' => 'select',
                'rules' => [
                    'store' =>  'nullable|integer',
                    'update' =>  'nullable|integer',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
                'display_index' => true,
                'display_form' => false,
                'relation' => [
                    'table' => 'menus',
                    'name' => 'left_menu_id',
                    'column' => 'ctitle',
                    'wheres' => [
                        ['menus.parent_id', '=', 0],
                        ['menus.id', '>', 3]
                    ],
                ],
            ],
        'is_online' =>
            [
                'name' => '是否發佈',
                'type' => 'checkbox',
                'rules' => [
                    'store' =>  'nullable|integer',
                    'update' =>  'nullable|integer',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
                'display_index' => true,
                'display_form' => true,
            ],

    ],
    'joins' => [
        'menu_id' => [
            'pages.menu_id', '=', 'menus.id'
        ],
        'left_menu_id' => [
            'pages.left_menu_id', '=', 'menus.id'
        ],
    ],

];
