<?php

return [
    'model' => ZhyuVueCurd\Models\Resource::class,
    'title' => '資源管理',
    //'orderby' => ['id' => 'asc'],
    'index_buttons' => [
        'draggable' => true,
        'width' => 250,
        [
            'label' => '修改',
            'url' => '/admin/permission/resource/{id}/edit',
            'css' => 'is-info',
            'type'=> 'update'
        ],
        [
            'label' => '刪除',
            'url' => '/admin/permission/resource/{id}',
            'css' => 'is-danger',
            'type'=> 'delete'
        ],
    ],
    'form_buttons' => [
        [
            'label' => '取消',
            'url' => '/admin/permission/resource',
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
        'name' =>
            [
                'name' => '資源名稱',
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
        'slug' =>
            [
                'name' => '資源slug',
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
        'is_online' =>
            [
                'name' => '是否有效',
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

    ],
    'joins' => [
        /*
        'fac_members_id' => [
            'members', 'posts.members_id', '=', 'members.id'
        ],
        */
    ],
];
