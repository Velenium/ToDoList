<?php

namespace App;

use App\Connect\Config;
use App\Connect\Connect;
use App\TaskController;
use App\TaskService;
use App\TaskRepository;
use App\Validation\Validator;
use App\ServiceResult;

class DependencyContainer
{
    private $config;
    private $initDep = [];
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    
    public function getTaskController() : TaskController
    {
        if (!isset($this->initDep[TaskController::class])) {
            $this->initDep[TaskController::class] = new TaskController($this->getTaskService());
        }
        
        return $this->initDep[TaskController::class];
    }
    
    public function getTaskService() : TaskService
    {
        if (!isset($this->initDep[TaskService::class])) {
            $this->initDep[TaskService::class] = new TaskService(
                $this->getTaskRepository(),
                $this->getValidator(),
                $this->getServiceResult()
            );
        }
        
        return $this->initDep[TaskService::class];
    }

    public function getTaskRepository() : TaskRepository
    {
        if (!isset($this->initDep[TaskRepository::class])) {
            $connect = $this->getConnect()->getConnection();
            $this->initDep[TaskRepository::class] = new TaskRepository($connect);
        }
        
        return $this->initDep[TaskRepository::class];
    }

    public function getValidator() : Validator
    {
        if (!isset($this->initDep[Validator::class])) {
            $this->initDep[Validator::class] = new Validator();
        }
        
        return $this->initDep[Validator::class];
    }

    public function getServiceResult() : ServiceResult
    {
        if (!isset($this->initDep[ServiceResult::class])) {
            $this->initDep[ServiceResult::class] = new ServiceResult();
        }
        
        return $this->initDep[ServiceResult::class];
    }
    
    public function getConnect() : Connect
    {
        if (!isset($this->initDep[Connect::class])) {
        	$connectionString = $this->config->getConnectionString();
        	$options = $this->config->getOptions();
            $this->initDep[Connect::class] = new Connect($connectionString, $options);
        }
        
        return $this->initDep[Connect::class];
    }
}