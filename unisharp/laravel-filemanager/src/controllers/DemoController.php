<?php namespace Unisharp\Laravelfilemanager\controllers;
use DB;

/**
 * Class DemoController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class DemoController extends LfmController
{

    /**
     * @return mixed
     */
    public function index()
    {
        $items=$this->getItems();
        $dbases=DB::select("SELECT datname FROM pg_database WHERE datistemplate=false Order By datname");
        $roles=DB::select("SELECT rolname FROM pg_roles Order By rolname");
        return view('laravel-filemanager::demo',compact('items','dbases','roles'));
    }
    public function getItems()
    {
        $path = parent::getCurrentPath();
        $files=$this->listFolderFiles('/home/roshan');
        $items=array();
       foreach($files as $files){
           $items[]=$files[0];
       }
        return $items;
    }
    public function listFolderFiles($dir){
        $directory  = env('FILES_PATH');
        $all_files  = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
        $html_files = new \RegexIterator($all_files, '/\.backup$/');

        foreach($html_files as $file) {
            $files[$html_files->getMTime()][] = $html_files->getFilename();
        }
        arsort($files);
        return $files;
    }
    
}
