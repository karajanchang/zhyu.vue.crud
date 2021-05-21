<?php

return [
    'model' => ZhyuVueCurd\Models\Role::class,
    'title' => '⻆色管理',
    //'orderby' => ['id' => 'asc'],
    'index_buttons' => [
        'draggable' => true,
        'width' => 250,
        [
            'label' => '修改',
            'url' => '/admin/permission/role/{id}/edit',
            'css' => 'is-info',
            'type'=> 'update'
        ],
        [
            'label' => '刪除',
            'url' => '/admin/permission/role/{id}',
            'css' => 'is-danger',
            'type'=> 'delete'
        ],
        [
            'label' => '權限管理',
            'url' => '/admin/permission/role/{id}/permission-set',
            'css' => 'is-primary',
        ],
    ],
    'form_buttons' => [
        [
            'label' => '取消',
            'url' => '/admin/permission/role',
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

    ],
    'joins' => [
        /*
        'fac_members_id' => [
            'members', 'posts.members_id', '=', 'members.id'
        ],
        */
    ],
];
