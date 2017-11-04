
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
    $this->load->model('Palabras_model');


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
  		$results  = $this->Productos_model->get_productos_like($keyword);
  
  		if($results == false){
        	
        	$this->response( "No existen productos para las palabras ingresadas", REST_Controller::HTTP_OK); // OK (200) 

  		}
      $keywordExist = $this->Palabras_model->get_palabras(strtolower($keyword)); // virifico si la palabra ha sido buscada antes
      if($keywordExist == false) { // si la palabra no existe en bd

        $keywordId = $this->Palabras_model->insert_palabra(strtolower($keyword));

      }
      else{
        $keywordId = $keywordExist->id_palabra;
      }
      foreach ($results as $index => $result) {
        
        $keywordProduct = $this->Palabras_model->get_palabra_producto($keywordId , $result->id_producto);// Verifico si se ha obtenido antes este resultado con la palabra ingresada
        if($keywordProduct == false){// si no ingreso relación nueva

          $this->Palabras_model->insert_palabra_producto($keywordId , $result->id_producto);

        }
        else{  // si ya se ha obtenido , sumo 1 a la cantidad de búsquedas
          $this->Palabras_model->update_palabra_producto($keywordId , $result->id_producto , $keywordProduct->busquedas+1);

        }
       
        
      }

      $this->response($results, REST_Controller::HTTP_OK); // OK (200) : retorno resultados
  		
  }

   public function popularProducts_get(){

    $this->load->model('Productos_model');
    $this->load->model('Palabras_model');

    $products = $this->Productos_model->get_popular_productos(20);
    if($products == false){// si no existen resultados

      $this->response("No se encontraron resultados", REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) 

    }
    foreach ($products as $index => $product) {
      $products[$index]->keywords = $this->Palabras_model->get_popular_palabra($product->id_producto , 5); 
    }
    $this->response($products, REST_Controller::HTTP_OK); // OK (200) : retorno resultados


   }


}

