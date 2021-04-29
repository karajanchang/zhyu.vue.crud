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
        'menu_id' =>
            [
                'name' => '選單',
                'type' => 'select',
                'rules' => [
                    'store' =>  'integer',
                    'update' =>  'integer',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
                'relation' => [
                    'table' => 'menus',
                    'name' => 'menu',
                    'column' => 'ctitle',
                ],
            ],
        'is_online' =>
            [
                'name' => '是否有效',
                'type' => 'checkbox',
                'rules' => [
                    'store' =>  'integer',
                    'update' =>  'integer',
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
            'menus', 'pages.menu_id', '=', 'menus.id'
        ],
    ],
];
