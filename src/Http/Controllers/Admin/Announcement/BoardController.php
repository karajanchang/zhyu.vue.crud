<?php
namespace ZhyuVueCurd\Http\Controllers\Admin\Announcement;


use ZhyuVueCurd\Models\Board;
use ZhyuVueCurd\Service\Admin\Announcement\BoardService;
use ZhyuVueCurd\Http\Controllers\CRULInterface;
use ZhyuVueCurd\Http\Controllers\CRULTrait;
use ZhyuVueCurd\Http\Controllers\CrulController;

class BoardController extends CrulController implements CRULInterface
{
    use CRULTrait;

    protected $module = 'admin';
    protected $tag = 'announcement.board';

    /*
     * Service 設定
     */
    public function service()
    {

        return BoardService::class;
    }

    public function arrangement(Board $board){

        return view('ZhyuVueCurd::admin.announcement.board.arrangement', compact('board'));
    }

}
