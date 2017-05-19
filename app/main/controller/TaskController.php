<?php

namespace controller;

use Application;
use model\Task;
use service\UserManager;
use util\RequestHelper;

class TaskController extends AbstractController
{
    public function indexAction()
    {
        $onPage = Application::$config['tasks_on_page'];
        $count = ceil(Task::count() / $onPage);
        $page = RequestHelper::get('page', FILTER_VALIDATE_INT, ['min_range' => 1, 'max_range' => $count]);
        if (!$page) {
            $page = 1;
        }

        $tasks = Task::findAll(($page - 1) * $onPage, $onPage);
        $this->render('task/list', [
            'tasks' => $tasks,
            'pagination' => $count > 0 ? [
                'page' => $page,
                'count' => $count
            ] : []
        ]);
    }

    public function viewAction()
    {
        if ($this->request->isPost()) {
            $task = new Task();
            $task->load();
            $this->render('task/view', ['task' => $task], true);
        } else if (isset($this->request->params['id'])) {
            $task = Task::findOne(['id' => $this->request->params['id']]);
            if (!is_null($task)) {
                $this->render('task/view', [
                    'task' => $task,
                    'editable' => UserManager::hasRole('admin')
                ]);
            }
        }
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $task = new Task();
            $task->load();
            $task->create();
            $this->response->redirect('/task/view/' . $task->id);
        } else {
            $this->render('task/add');
        }
    }

    public function editAction()
    {
        if (UserManager::hasRole('admin')) {
            if ($this->request->isPost()) {
                $task = new Task();
                $task->load();
                var_dump($task);
                $editTask = Task::findOne(['id' => $task->id]);
                if (!empty($editTask)) {
                    $editTask->description = $task->description;
                    $editTask->status = $task->status;
                    $editTask->update(['description', 'status']);
                    $this->response->redirect('/task/view/' . $task->id);
                }
            } else if (isset($this->request->params['id'])) {
                $task = Task::findOne(['id' => $this->request->params['id']]);
                if (!is_null($task)) {
                    $this->render('task/edit', ['task' => $task]);
                }
            }
        }
    }
}
