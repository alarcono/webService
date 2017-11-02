
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Productos extends REST_Controller
{
  public function index_get()
  {

  }

  public function search_get(){

  	$this->load->model('Productos_model');

  		$search = false; // por defecto no existe el parámetro a buscar
  		foreach ($this->get() as $key => $get) { // busco entre los get recibidos

  			if(strpos(urldecode($key) , 'keyword')){ // si existe keyWord

  				$search = json_decode(urldecode($key)); // guarda palabra
  				break;

  			}
  		}

  		if($search == false){ // si no existe parámetro a buscar

            $this->response("Debe ingresar keyword/", REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) 

  		}

  		$keyword = $search->keyword; // obtengo valores que se desean buscar
  		$result  = $this->Productos_model->get_productos_like($keyword);
  
  		if($result == false){
        	
        	$this->response( "No existen productos para las palabras ingresadas", REST_Controller::HTTP_OK); // OK (200) 

  		}

        $this->response(($result), REST_Controller::HTTP_OK); // OK (200) 
  		
  }


}

