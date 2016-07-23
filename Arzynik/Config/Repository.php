<?php namespace Arzynik\Config;
class Repository {
    protected $key = '';
    protected $repository = '';
    protected $basePath = '';
    protected $deploy = true;
    protected $localPath = __DIR__ . DIRECTORY_SEPARATOR . '..';
    protected $allowedBranches = [];
    public function __construct($name,$data) {
        $this->repository = $name;
        if(isset($data['key'])) {
            $this->key = $data['key'];
        }
        if(isset($data['basePath'])) {
            $this->basePath = $data['basePath'];
        }
        if(isset($data['localPath'])) {
            $this->localPath = $data['localPath'];
        }
        if(isset($data['branches'])) {
            $this->allowedBranches = (array) explode(',',$data['branches']);
        }
        if(isset($data['deploy'])) {
            $this->deploy = $data['deploy'] !== 'false' && $data['deploy'];
        }
    }
    public function getKey() {
        return $this->key;
    }
    public function getRepository() {
        return $this->repository;
    }
    public function getBasePath() {
        return $this->basePath;
    }
    public function isBranchAllowed($branch) {
        return count($this->allowedBranches) === 0 || in_array($branch,$this->allowedBranches);
    }
    public function mayDeploy() {
        return $this->deploy;
    }
    public function getLocalPath($branch) {
        return str_replace('[branch]',preg_replace('/[^a-z0-9]/i','',$branch),$this->localPath);
    }
}