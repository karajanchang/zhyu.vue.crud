<?php

return [
    'model' => ZhyuVueCurd\Models\Menu::class,
    'title' => '選單管理',
    //'orderby' => ['id' => 'asc'],
    'index_buttons' => [
        'draggable' => true,
        'width' => 250,
        [
            'label' => '修改',
            'url' => '/admin/system/menu/{id}/edit',
            'css' => 'is-info',
            'type'=> 'update'
        ],
        [
            'label' => '刪除',
            'url' => '/admin/system/menu/{id}',
            'css' => 'is-danger',
            'type'=> 'delete'
        ],
        [
            'label' => '下層',
            'url' => '/admin/system/menu?parent_id={id}',
            'css' => 'is-primary',
        ],
    ],
    'form_buttons' => [
        [
            'label' => '取消',
            'url' => '/admin/system/menu',
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
                'name' => '名稱',
                'type' => 'text',
                'rules' => [
                    'store' =>  'required|string',
                    'update' =>  'required|string',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],
        'ctitle' =>
            [
                'name' => '顯示文字',
                'type' => 'text',
                'rules' => [
                    'store' =>  'required|string',
                    'update' =>  'required|string',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],
        'etitle' =>
            [
                'name' => '顯示英文',
                'type' => 'text',
                'rules' => [
                    'store' =>  'nullable|string',
                    'update' =>  'nullable|string',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],
        'url' =>
            [
                'name' => '網址',
                'type' => 'text',
                'rules' => [
                    'store' =>  'string',
                    'update' =>  'string',
                ],
                'params' => [
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],
        'icon_pack' =>
            [
                'name' => 'icon種類',
                'type' => 'text',
                'rules' => [
                    'store' =>  'string',
                    'update' =>  'string',
                ],
            ],
        'icon' =>
            [
                'name' => 'icon名稱',
                'type' => 'text',
                'rules' => [
                    'store' =>  'string',
                    'update' =>  'string',
                ],
            ],
        'orderby' =>
            [
                'name' => '排序',
                'type' => 'integer',
                'rules' => [
                    'store' =>  'integer',
                    'update' =>  'integer',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],
        'is_online' =>
            [
                'name' => '是否上線',
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
            ],
        'parent_id' =>
            [
                'name' => '排序',
                'type' => 'hidden',
                'rules' => [
                    'store' =>  'nullable|integer',
                    'update' =>  'nullable|integer',
                ],
            ],

    ],
    'joins' => [
        /*
        'fac_members_id' => [
            'members', 'posts.members_id', '=', 'members.id'
        ],
        */
    ],
];
