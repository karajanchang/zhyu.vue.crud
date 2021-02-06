<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use ZhyuVueCurd\Models\Config;
use Livewire\Component;

class ConfigList extends Component
{
    private function getRows(){

        $rows = Config::all();

        return $rows->map(function($row, $key) {
            $row->typeWithName();
            $row->others = $this->button($row);

            return $row;
        });
    }

    private function button($row){
        $editUrl = url(route('admin.system.config.edit', ['config' => $row]));
        $nameValueUrl = str_replace('edit', 'namevalue', $editUrl);
        $setValueUrl = str_replace('edit', 'setvalue', $editUrl);

        $str = '<div class="buttons">
                    <button type="button" class="button is-primary is-small" onclick="location.href=\''.$editUrl.'\'">修改</button>';

        if($row->type==3 || $row->type==4 || $row->type==5){
            $str .= '<button type="button" class="button is-info is-small" onclick="location.href=\''.$nameValueUrl.'\'">屬性設定</button>';
        }
        $str .= '<button type="button" class="button is-warning is-small" onclick="location.href=\''.$setValueUrl.'\'">設定值</button>';
        $str .= '</div>';

        return $str;
    }

    public function render()
    {
        $rows = $this->getRows();
        $view = 'livewire.admin.config-list';

        return view()->first([$view, 'vendor.'.$view, 'ZhyuVueCurd::'.$view], [
            'rows' => $rows,
        ]);
    }
}
