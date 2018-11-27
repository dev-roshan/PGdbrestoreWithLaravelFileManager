<?php

namespace App\Http\Controllers;
use Unisharp\Laravelfilemanager\controllers\LfmController;
use Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return redirect('http://'.$_SERVER['HTTP_HOST'].'/laravel-filemanager/demo');
    }
    
    public function custom(){
        $cmd="PGPASSWORD=EsW34DFDKt3vesS pg_dump -d app0_munerp_live_test -U postgres --role=surya --enable-row-security > /var/lib/pgsql/10/backups/test_22/surya_2018_10_02_15_43_10.backup  2>&1";
        // $cmd="ls 2>&1";
        //$output = "";
        // $output = shell_exec('bash -x bashscript.sh');
        $out = array();	
        exec($cmd,$out);
        dd('asdf');
    }
}
