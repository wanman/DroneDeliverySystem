<?php

class StartOrderController extends Controller {

    public function index () {
        $this->model('StartOrder');

        // generate 10 clients from file
        $this->model->generate_clients();

        // add new process if there is clients and drones avaialble
        $this->model->StartProcess();

        $this->view('StartOrder' .  DIRECTORY_SEPARATOR . 'index', [
            "message" => $this->model->message()
        ]);

        $this->view->page_title = 'Start process';

        $this->view->render();
    }

}