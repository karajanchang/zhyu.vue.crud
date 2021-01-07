<div id="ConfigListTable" class="m-5">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <template>
        <b-table :data="data" :columns="columns"></b-table>
    </template>
</div>

@push("js_append")
    <script>
    const ConfigTable = {
        data() {
            return {
                data:
                    {!! $rows->toJson() !!},
                /*
                    [
                    { 'id': 1, 'tag': 'Jesse', 'ctitle': 'Simmons', 'type': 1, 'value': 'Male', 'other': '<button type="button" class="is-info">增加</button>' },
                ],*/
                columns: [
                    {
                        field: 'id',
                        label: 'ID',
                        width: '40',
                        numeric: true
                    },
                    {
                        field: 'tag',
                        label: '標籤',
                    },
                    {
                        field: 'ctitle',
                        label: '顯示文字',
                    },
                    {
                        field: 'type',
                        label: '類別',
                        centered: true
                    },
                    {
                        field: 'value',
                        label: '值',
                    },
                    {
                        field: 'others',
                        label: '',
                    }
                ]
            }
        }
    }
    const menu = new Vue(ConfigTable)
    menu.$mount('#ConfigListTable')
    </script>
@endpush
