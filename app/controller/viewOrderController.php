<?php

class viewOrderController extends Controller {

    public function index ($id) {

        $this->model('viewOrder');

        $this->view('viewOrder\index', [
            'orders_arr' => $this->model->get_order_details($id)
        ]);

        $this->view->page_title = 'View Order';
        $this->view->render();
    }
}