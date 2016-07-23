<?php namespace Arzynik\Task;
use Arzynik\Service\Github;
class Release {
    public function run($repository,$version,$tickets,$zipFile) {
        $curl = new Github();
        $data = $curl->send('repos/' . $repository . '/releases','{"tag_name": "' . $version . '","name": "' . $version . '","body": "Automatic Release\n Fixes to #' . implode(', #',$tickets) . '"}','post','application/json');
        if(isset($data->assets_url) && $data->assets_url) {
            $curl->send($data->assets_url . '?name=' . explode('/',$repository)[1] . '.zip',file_get_contents($zipFile),'post','application/zip');
            if($data->browser_download_url) {
                return true;
            }
        }
        error_log($data);
        return false;
    }
}