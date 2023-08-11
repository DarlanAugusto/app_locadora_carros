<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

    class Repository {

        public $model;

        public function __construct(Model $model)
        {
            $this->model = $model;
        }

        public function selectFieldsRelationship($relationship, $fields)
        {
            if($fields) {
                $this->model = $this->model->with(["$relationship:id,$fields"]);
            }
            else {
                $this->model = $this->model->with([$relationship]);
            }

        }

        public function filter($filters)
        {
            if($filters) {
                $conditions = explode(';', $filters);

                foreach($conditions as $condition) {
                    $where = explode(':', $condition);
                    $this->model = $this->model->where($where[0], $where[1], $where[2]);
                }
            }

        }

        public function selectFields($fields)
        {
            if($fields) {
                $this->model = $this->model->selectRaw($fields);
            }

        }

        public function getResults()
        {
            return $this->model->get();
        }
    }
?>
