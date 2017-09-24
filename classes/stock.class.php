<?php

$con = include('../resources/conection.inc.php');
require_once('../functions/db_functions.inc.php');




   /**
   * @param $description - hold the stock description;
   * @param $type - holds a type which should be specified by the user
   * @param  $cost_per_ton   holds the cost per ton for this stock

   */
   class Stock 
   {
   	var $description;
   	var $cost_per_ton;
   	var $id;
   	var $quantity_in_store;
   	var $last_receive_date;
   	var $date_created;
   	private $error;


   	public function __construct($description){
   		global $connection;

   		if(isset($data['description'])){
   			if($this->exists()){
   				$query = "SELECT FROM stock WHERE description = " . $data['description'] ;
   				if($query = mysqli_query($connection,$query)){
   					$data = mysqli_fetch_assoc();
   					$this->description = $data['description'];
   					$this->cost_per_ton = $data['cost_per_ton'];
   					$this->id  = $data['id'];
   					$this->quantity_in_store = $data['quantity_in_store'];
   					$this->last_receive_date = $data['last_receive_date'];
   					$this->date_created = $data['date_created'];
   				}


   			}
   		}

   		static function create($data){
   			
   			if (!$this->exists()){
   				dbRowinsert('stocks',$stockdata);
   				return new self($stockdata);
   			} else {trigger_error("stock already exists");}

   		}

   		public function exists(){

   			global $con;
   			$query = "SELECT * FROM stocks WHERE 'description' = '$this->description' ";

   			if($result = mysqli_query($con,$query) ){
   				if (mysqli_num_rows($result) == 1){
   					$exist = true;
   				}else { 
   					$exist = false;
   				}
   				return $exist;
   			}else{
   				trigger_error("ERROR OCCURED: Could not check if user exist". mysqli_error());
   			}


   		}

   		public function changePricePerTon($newprice){

   			if($this->exists()){
       	// updates the cost_per_ton_field_in_the_database if the stock exist;
   			// $table,$field,$newvalue,$selection_condition = array()
   				update('stocks', 'price_per_ton',$newprice, array('id' => $this->id));

   			}else{
   				trigger_error('This Stock does not Exist');
   			}    
   		}

   		public function receive(){

   			if($this->exists()){
       	// updates the cost_per_ton_field_in_the_database;
   				$previous_cost_per_ton = (int)get('stock', 'cost_per_ton');
   				$new_cost_per_ton = $previous_cost_per_ton + (int)$this->cost_per_ton;
       	    update('stock','cost_per_ton',$new_cost_per_ton);   //update(table,field,newvalue)

       	}else{
       		trigger_error('This already Exist');
       	}  


       }


       static function get_all_stocks(){
       	$all_stocks = get_all('stock');
       	return(object) $all_stocks;
       }


   }



   $stock = new Stock(array('description'=>'10mm', 'cost_per_ton' => '6000'));
   $stock = $stock->create();
   echo $stock->description;
//$stock->changePricePerTon('3444');
// $stockdata = array(
//    				'description' => $this->description,
//    				'cost_per_ton' => $this->cost_per_ton,
//    				'date_created' => date('Y/m/d'),
//    				'last_receive_date'=> date('Y/m/d')
//    				);

   ?>