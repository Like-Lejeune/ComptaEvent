<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Tools;

class statutController extends Controller
{
    //
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function project_info($val)
    {
        $val = $this->tools->dekrypt($val);
        $VALUE = DB::table('work_editor')
            ->join('works', 'work_editor.work_id', '=', 'id_work')
            ->join('users', 'editor_id', '=', 'users.id')
            ->select('*')
            ->where('work_id', $val)
            ->first();
        // dd($VALUE);
        $editor_id = $VALUE->editor_id;
        return view('admin.redaction.status')
            ->with('work', $VALUE)
            ->with('editor_id', $editor_id)
            ->with('id_work', $val);
    }

    public function DocsTelecharger($val)
    {
        $existingdoc = DB::table('work_doc')->where('wd_work_id',$val)->get();
        return view('status.telechargement_card')
        ->with('documents', $existingdoc);
    }

    public function resultat($val)
    {
        $existingdoc = DB::table('work_doc')->where('wd_work_id',$val)->get();
        $existe = DB::table('work_editor')
                ->where('work_id', $val)
                ->first('id_work_editor');
        $existing = DB::table('work_end')->where('work_editor_id',$existe->id_work_editor)->get();
        $id_work_end = DB::table('work_end')->where('work_editor_id',$existe->id_work_editor)->limit(1)->first();
        return view('admin.redaction.resultat')
                ->with('documents', $existingdoc)
                ->with('work_editor_id', $existe->id_work_editor)
                ->with('work_id', $val)
                ->with('id_work_end', $id_work_end->id_work_end)
                ->with('resultat', $existing);
    }

    public function encrypting_status ($id) {

        $encryptedID = $this->tools->krypt($id);
        return redirect()->route('encrypted_status', [
            'encryptedID' =>  $encryptedID,
        ]);
    }
}
