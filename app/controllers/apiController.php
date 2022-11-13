<?php
require_once './app/models/model.php';
require_once './app/views/api.view.php';
require_once './app/controllers/authController.php';


class LightersController
{
    private $model;
    private $view;
    private $data;

    public function __construct()
    {
        $this->model = new LightersModel();
        $this->view = new  ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function ShowLighters()
    {
        try {
            if (isset($_GET['order']) && isset($_GET['sortby'])) {
                $order = $_GET['order'];
                $sortby = $_GET['sortby'];
                $lighters = $this->model->orderLighters($order, $sortby);
            } elseif (isset($_GET['category'])) {
                $category = $_GET['category'];
                $lighters = $this->model->getLightersByCategory($category);
            } else {
                $lighters = $this->model->getList();
            }
            return $this->view->response($lighters, 200);
        } catch (Exception $e) {
            $this->view->response(400);
        }
    }


    public function GetLighter($params = null)
    {
        //obtengo la id del arreglo de parametro
        $id = $params[':ID'];
        $lighter = $this->model->getLighterByID($id);
        // si no existe devolver 404 
        if ($lighter)
            $this->view->response($lighter);
        else
            $this->view->response("The lighter you are looking for isn't available yet.", 404);
    }

    public function DeleteLighter($params = null)
    {
        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $id = $params[':ID'];
        $lighter = $this->model->getLighterByID($id);
        if ($lighter) {
            $this->model->deleteLighterById($id);
            $this->view->response($lighter);
        } else
            $this->view->response("The lighter with the id=$id can not be found.", 404);
    }
    public function InsertLighter($params = null)
    {
        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $lighters = $this->getData();
        if (empty($lighters->producto) || empty($lighters->tipo_fk) || empty($lighters->precio) || empty($lighters->descripcion) || empty($lighters->img_url)) {
            $this->view->response("Complete the data for the insert please.", 400);
        } else {
            $this->model->insertLighter($lighters->producto, $lighters->tipo_fk, $lighters->precio, $lighters->descripcion, $lighters->img_url);
            $id = $this->model->getLastInsertedID();
            $lighter = $this->model->getLighterByID($id);
            $this->view->response($lighter, 201);
        }
    }
    public function UpdateLighter($params = null)
    {
        if(!$this->authHelper->isLoggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $id = $params[':ID'];
        $lighter = $this->model->getLighterByID($id);
        $updatedLighter = $this->getData();
        if ($lighter) {
            $this->model->updateLighter($updatedLighter->producto, $updatedLighter->tipo_fk, $updatedLighter->precio, $updatedLighter->descripcion, $updatedLighter->img_url, $id);
            $this->view->response("The lighter was succesfully edited.", 200);
        } else {
            $this->view->response("The lighter with the id=$id can not be found.", 404);
        }
    }
}
