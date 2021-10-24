<?php

return [
    'model' =>\App\Models\Board::class,
    'title' => '佈告欄',
    'index_buttons' => [
        'width' => 200,
        [
            'label' => '項目列表',
            'url' => '/admin/announcement/boarditem?board_id={id}',
            'css' => 'is-success',
            'type'=> 'update',
        ],
        [
            'label' => '修改',
            'url' => '/admin/announcement/board/{id}/edit',
            'css' => 'is-info',
            'type'=> 'update',
        ],
        [
            'label' => '刪除',
            'url' => '/admin/announcement/board/{id}',
            'css' => 'is-danger',
            'type'=> 'delete',
        ],
        [
            'label' => '左選單',
            'url' => '/admin/announcement/board/{id}/arrangement',
            'css' => 'is-primary',
            'type' => 'button',
        ],
    ],
    'form_buttons' => [
        [
            'label' => '取消',
            'url' => '/admin/announcement/board',
            'css' => 'is-default',
            'type'=> 'cancel',
        ],
        [
            'label' => '送出',
            'css' => 'is-primary',
            'type'=> 'submit',
        ],
    ],
    'columns' => [
        'title' =>
            [
                'name' => '主題',
                'type' => 'text',
                'rules' => [
                    'store' =>  'required|string',
                    'update' =>  'required|string',
                ],
                'params' => [
                    'sortable', 'searchable',
                ],
            ],
        'uri' =>
            [
                'name' => 'uri (其網址在前台即為 /board/{uri})',
                'type' => 'text',
                'rules' => [
                    'store' =>  'required|string',
                    'update' =>  'required|string',
                ],
                'display_index' => true,
                'display_form' => true,
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

        'left_menu_id' =>
            [
                'name' => '左側選單',
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



    ],
];
