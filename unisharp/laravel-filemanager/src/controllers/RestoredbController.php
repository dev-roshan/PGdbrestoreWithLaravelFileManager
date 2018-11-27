<?php namespace Unisharp\Laravelfilemanager\controllers;

use \Illuminate\Http\Request as rqst;
use \RecursiveIteratorIterator;
/**
 * Class CropController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class RestoredbController extends LfmController
{
    /**
     * Delete image and associated thumbnail
     *
     * @return mixed
     */
    public function restoredb(rqst $request)
    {
        //ob_start();
        $filename = $request->get('filename');
        $path=$this->getPath($filename);
        dd($path);
        //$filename = "asdfd";
        $dbname =$request->get('dbname');
        $role = $request->get('role')." < ".$path." 2>&1";
        $cmd="PGPASSWORD=".env('DB_PASSWORD')." pg_restore -h localhost -U postgres -d ".$dbname." -c -O -x -p 5432 --role=".$role;
        // $cmd="ls 2>&1";
        //$output = "";
        // $output = shell_exec('bash -x bashscript.sh');
        $out = array();	
        exec($cmd,$out);
       // $output=exec($cmd);
        // $output="";	
      
        //ob_end_clean();
        //dd($output);
        return response()->json(array('data'=> $out), 200);
    }

    public function getPath($filename){
        $file_to_search = $filename;
        $root_path = env('FILES_PATH'); // your doc root
    
        foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root_path, 
                \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST) as $value) {
    
            if($value->getFilename() == $file_to_search) {
                $files[] = $value->getPathname();
            }   
        }
        return $files[0];
    }
}
