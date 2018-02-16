<?php
class Api extends Controller {
    public function err() {
        $data = [
            'status' => false,
            'msg' => 'API not found !'
        ];
        echo json_encode($data);
    }

    public function visits() {
        $this->model('Visits');
        $this->view('visits', []);
    }

    public function comments() {
        $this->model('Comments');
        $this->view('comments', []);
    }

    public function comment($id = null) {
        $this->model('Comments');
        $this->view('comment', [$id]);
    }

    public function subscribe() {
        $this->view('subscribe', []);
    }

    public function updates($page = 1) {
        $this->model('Updates');
        $this->view('updates', [$page]);
    }

    public function update($id = null) {
        $this->model('Updates');
        $this->view('update', [$id]);
    }

    public function editupdate($id = null) {
        $this->model('Updates');
        $this->view('editupdate', [$id]);
    }

    public function login($id = null) {
        $this->model('Acc');
        $this->view('login', [$id]);
    }
}