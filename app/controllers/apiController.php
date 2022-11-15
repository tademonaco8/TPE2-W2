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
        $defaultOffset = 0; //de donde empieza
        $defaultLimit = 5; //cuantos trae
        $defaultOrder = 'ASC';
        $defaultSortBy = 'id'; //campo que busca
        try {
            if (isset($_GET['order']) && isset($_GET['sortby'])) {
            //orderBy
                //los dos
                $order = $_GET['order'];
                $sortby = $_GET['sortby'];
                $lighters = $this->model->orderLighters($order, $sortby);
            } elseif (!isset($_GET['order']) && (isset($_GET['sortby']))) {
                //solo sortby
                $sortby = $_GET['sortby'];
                $order = $defaultOrder;
                $lighters = $this->model->orderLighters($order, $sortby);
            } elseif (isset($_GET['order']) && (!isset($_GET['sortby']))) {
                //solo order
                $order = $_GET['order'];
                $sortby = $defaultSortBy;
                $lighters = $this->model->orderLighters($order, $sortby);
            } elseif (isset($_GET['limit']) && (isset($_GET['offset']))) {
            //paginacion
                //limit y offset
                $limit = $_GET['limit'];
                $offset = $_GET['offset'];
                $lighters = $this->model->getList();
                $lighters = $this->paginateArray($limit, $lighters, $offset);
            } elseif (isset($_GET['limit']) && (!isset($_GET['offset']))) {
                //solo limit
                $limit = $_GET['limit'];
                $offset = $defaultOffset;
                $lighters = $this->model->getList();
                $lighters = $this->paginateArray($limit, $lighters, $offset);
            } elseif (!isset($_GET['limit']) && (isset($_GET['offset']))) {
                //solo offset
                $offset = $_GET['offset'];
                $limit = $defaultLimit;
                $lighters = $this->model->getList();
                $lighters = $this->paginateArray($limit, $lighters, $offset);
            } elseif (isset($_GET['category'])) {
                //filter category
                $category = $_GET['category'];
                $lighters = $this->model->getLightersByCategory($category);
            } elseif (isset($_GET['filterby'])) {
                //filter by name
                $filterby = $_GET['filterby'];
                $lighters = $this->model->filterLightersByName($filterby);
            } else {
                //Get all
                $lighters = $this->model->getList();
            }
            return $this->view->response($lighters, 200);
        } catch (Exception $e) {
            $this->view->response(400);
        }
    }


    public function GetLighter($params = null)
    {
        $id = $params[':ID'];
        $lighter = $this->model->getLighterByID($id);
        if ($lighter)
            $this->view->response($lighter);
        else
            $this->view->response("The lighter you are looking for isn't available yet.", 404);
    }

    public function DeleteLighter($params = null)
    {
        if (!$this->authHelper->isLoggedIn()) {
            $this->view->response("No estas logeado", 401);
            return;
        }

        $id = $params[':ID'];
        $lighter = $this->model->getLighterByID($id);
        if ($lighter) {
            $this->model->deleteLighterById($id);
            $this->view->response($lighter);
        } else
            $this->view->response("The lighter with the id= $id can not be found.", 404);
    }

    public function InsertLighter($params = null)
    {
        if (!$this->authHelper->isLoggedIn()) {
            $this->view->response("No estas logeado", 401);
            return;
        }

        $lighters = $this->getData();
        if (empty($lighters->producto) || empty($lighters->tipo_fk) || empty($lighters->precio) || empty($lighters->descripcion) || empty($lighters->img_url)) {
            $this->view->response("Complete the data for the insert please.", 400);
        } else {
            $this->model->insertLighter($lighters->producto, $lighters->tipo_fk, $lighters->precio, $lighters->descripcion, $lighters->img_url);
            $this->view->response($lighters, 201);
        }
    }

    public function UpdateLighter($params = null)
    {
        if (!$this->authHelper->isLoggedIn()) {
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
            $this->view->response("The lighter with the id= $id can not be found.", 404);
        }
    }

    public function paginateArray($limit, $lighters, $offset)
    {
        if (array_slice($lighters, $offset, $limit) == []) {
            $this->view->response("There was an error during the pagination, check the ranges.", 400);
            die();
        }
        return array_slice($lighters, $offset, $limit);
    }
}
