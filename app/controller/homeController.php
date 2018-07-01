<?php

class HomeController extends Controller {

    public function index ($id = '', $name = '') {
        $this->model('HomeModel');

        // check which orders is pending and update status if package is delivered
        $this->model->checkOrder();

        $this->view('home\index',[
            'orders_arr' => $this->model->getOrders()
        ]);

        $this->view->page_title = 'Home page';
        $this->view->render();
    }
}