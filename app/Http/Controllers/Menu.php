<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Work;

class Menu extends Controller
{
    public function controle_space($chaine)
    {
        $chaine = trim($chaine);
        $chaine = str_replace("###antiSlashe###t", " ", $chaine);
        $chaine = preg_replace("!\s+!", " ", $chaine);
        $chaine = htmlspecialchars($chaine);
        return $chaine;
    }

    public function Menu()
    {
        return view('vitrine.Menu');
    }

    public function administrator()
    {
        return view('admin.Menu');
    }
    public function user_menu()
    {
        $service = service::get();
        return view('user.Menu')->with('service',  $service);
    }

}