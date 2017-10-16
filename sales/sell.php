    <?php session_start();
     
     if (!isset($_SESSION['user'])){
        header("Location : ../index.php");
     }

    include_once '../functions/invoice_functions.php';
    $connection = include('../resources/conection.inc.php');

    //if previous stocks were stored in the session go ahead and delete them
    if(isset($_SESSION['sales'])){
      unset($_SESSION['sales']);
      unset($_SESSION['last_sale_id']);
    }

    $_SESSION['sale_date'] = date('Y-m-d');
    $_SESSION['invoice_number'] = genNewInvoiceNumber($connection);

    //var_dump($_SESSION);

    function get_all($table,$connection){
      $all_data = array();
      $query = "SELECT * FROM $table";
      if ($result = mysqli_query($connection,$query)){

        for($i = 0; $i< mysqli_num_rows($result); $i++){
          array_push($all_data, mysqli_fetch_assoc($result));
        }

      }else{
        trigger_error(mysqli_error($connection));
      }
      return $all_data;

    }   
    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> MUKAZ | Sell</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.6 -->
      <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
      <!-- Ionicons -->
      <link rel="stylesheet" href="../css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../css/AdminLTE.min.css">

      <link rel="stylesheet" href="../css/native-toast.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="../css/skins/_all-skins.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
      <!-- Morris chart -->
      <link rel="stylesheet" href="../plugins/morris/morris.css">

      <link rel="stylesheet" href="../plugins/select2/select2.min.css">

      <link rel="stylesheet" href="../css/animate.min.css">
      <!-- jvectormap -->
      <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
      <!-- Date Picker -->
      <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
      <!-- bootstrap wysihtml5 - text editor -->
      <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
      <style type="text/css">
      .added-stock{
        background-color: whitesmoke;
        font-weight: bold;
      }
      .rounded{
        border-radius: 5px;
      }

      input,select{text-transform: uppercase;}

      .padd{
        padding: 5px;
      }
      #proceed a {
        color:white;
      }
    </style>
  </head>

  <body>

    <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">

        <!-- header  -->
        <?php  include('../resources/templates/header.php') ; ?>
        <!-- end header   -->


        <!-- Left side column. contains the logo and sidebar -->
        <?php  include('../resources/templates/mainsidebar.php') ; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper " ">
         <div class="container-fluid">

          <div class = 'row' style="margin-top:15px">
            <div class = 'col-md-8 no-padding'>
              <div class="container-fluid">
               <div class = 'row'>

                <div class = 'col-md-12'>
                 <div class="box  box-solid">
                  <div class="box-header bg-purple rounded with-border">
                    <h4 class="box-title">Sales Information</h4>
                    <button type = 'button' class = 'close'></button>
                  </div>
                  <div class="box-body">
                    <div class="row">

                     <div class="col-md-4 col-sm-4">
                      <div class="form-group">
                        <label>Customer</label>
                        <select id = 'customer' class="form-control select2 " style=" width: 100%;"> 
                          <!-- get all customrer and render to html -->
                          <?php $customers = get_all('customers',$connection)?>
                          <option></option>
                          <?php foreach ($customers as $customer): ?>
                           <option id = '<?=$customer['id']?>' >
                            <?= $customer['customer_name'] ?>
                            (<?=$customer['customer_phone']?>)
                          </option>
                        <?php endforeach ?>

                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 col-sm-4">
                    <label>invoice Number</label>
                    <input class="form-control " type="number" name="invoice-number" id = "invoice-number"
                    value = '<?=genNewInvoiceNumber($connection)?>'>
                  </div>

                  <div class="col-md-4 col-sm-10 col-xs-12" style="">
                    <label>Sale Date</label>
                    <input class="form-control " type="date" id="sale_date" 
                    value= '<?= date('Y-m-d',strtotime('today'))?>'>
                  </div>

                </div>

              </div>
              <!-- /.box-body -->
            </div>
          </div>

          <div class = 'col-md-12'>
            <div class="box  box-solid">

              <div class="box-header bg-purple with-border">
                <h4 class="box-title">Enter Each Stock Sold</h4>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form>
                <div class="box-body">
                 <div class="alert alert-info animated slideInLeft">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                   <p>Enter Each Stocks Bought and proceed by clicking The Add button.</p>
                 </div>
                 <!-- stock -->
                 <div class="row">
                  <div class="col col-md-7">
                   <div class="form-group">
                    <label for="exampleInputEmail1">Select Stock</label>
                    <select class="form-control select2 input-lg" style=" width: 100%;" id = 'stock'> 
                     <option></option>
                     <?php $stocks = get_all('stocks',$connection)?>
                     <?php foreach ($stocks as $stock): ?>
                      <option id = '<?=$stock['id']?>' price_per_ton = '<?=$stock['cost_per_ton']?>'>
                        <?= $stock['description']?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                </div>

                <div class="col col-md-5">
                  <div class="form-group">
                    <label >Price Per Ton</label>
                    <input type="number" id='price_per_ton' class = 'form-control input-lg'>
                  </div>
                </div>

              </div>
              <!-- end stock -->
              <div class="form-group">
                <label for="exampleInputPassword1">Quantity</label>
                <input type="number" class="form-control input-lg" id="quantity_sold" placeholder="Quantity" required>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Quantity Per Ton</label>
                <input type="number" class="form-control input-lg" id="quantity_per_ton" placeholder="How Many Makes One Ton For This Stock" required>
              </div>


            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary input-lg" id= 'add-stock'>
                Add Stock
                <span class = "glyphicon glyphicon-plus"></span>
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div class = 'col-md-4' >
  <div class="box box-solid" style="max-height:565px; overflow-y:scroll;overflow-x: hidden;">
    <div class="box-header with-border bg-purple"> 
      <button id = 'del_all_stocks' class = 'pull-right btn bg-maroon'><span class= 'glyphicon glyphicon-trash'></span></button>
      <h4 class="box-title">Posted Stocks</h4>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>

    </div> 

    <table id="layout-skins-list" class="table table-striped bring-up nth-2-center">
      <thead>
        <tr>
          <th >Total</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td style="font-size: 30px"><code id = 'show_total_sale'></code></td>
          <td style="font-size: 30px"><code id = 'show_total_qty'> </code></td>
        </tr>

        <tr>
          <td colspan="2"><label>Amount Paid</label>
            <input  class = 'form-control input-lg' type="text" name="" style="width:100%" id = 'new_amount_paid'>
          </td>
        </tr>
      </tbody>
    </table>


    <!-- /.box-header -->
    <!-- <div class="box-body"> -->
      <div class = 'box-body' id = 'cart'>

          <!--   <div class="callout added-stock">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <span class="info-box-text">Description : 10MM TIGER </span> 
              <span class="info-box-text">Quantiy: 10</span>
              <span class="info-box-text">Sub Total: 10,000</span>
            </div> -->


            <!-- </div> -->
          </div>
          <!-- /.box-body --> 
          <button class = 'btn bg-purple btn-block input-lg proceed' id = 'proceed'>
            <!-- <a href="invoice.php"></a> -->Print This Invoice
          </button>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- end content  -->




<script src="../js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../js/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>

<script type="text/javascript" src = '../js/native-toast.js'></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script> 
<!-- <script src="../js/fetch-data.js"></script>  -->
<script src="../plugins/select2/select2.min.js"></script>
<script type="text/javascript">

  $('document').ready(function(){

        // since jquery remove does no remove an element slowly this function combined sliudeUP and Remove 
        function removeElem(elem){
          elem.slideUp();
          setTimeout(function(){ elem.remove()},1000);
        }
        // since the event handdler has to be binded when the stock is add for its removal , addstock calls this 
        function bindRemover(){
         $('.delstock').on('click',function(){
          $('[data-toggle = "tooltip"]').tooltip();
          $.post("sales_ajax_manager.php",
          {
           action:"DELETE_INDEX",
           index: $(this).attr('rmv_index')
         },
         function(data,status){
          showToast('success', 'Deleted');
          updateQuantityAndTotal();
        });

          removeElem($(this).parents('.callout'));  
        });
       }

     // success,inf0 error warning
     function showToast(type, message,time= 3000){
      var useEdge = true;
      var useDebug = false;

      nativeToast({
        message: message,
        square: true,
        edge: useEdge,
        debug: useDebug,
        type : type,
        timeout : time
      });
    }

    function updateQuantityAndTotal(){
     $.post("sales_ajax_manager.php",
     {
      action:"GET_QTY_AND_TOTAL"
    },
    function(data,status){
      console.log(data);
      $('#show_total_sale').text(data.quantity);
      $('#show_total_qty').text(data.total);
      $('#new_amount_paid').val(data.quantity);
      });
   }

   function getStockBox(description,quantity,subtotal,rmv_index,price_per_ton){
     var stock_box = "<div class='callout added-stock animated slideInLeft'><button data-toggle = 'tooltip' title='Delete This Item' class = ' close delstock'  rmv_index ="+ rmv_index +" >×</button><span class='info-box-text'>Description :" + description +"</span> <span class='info-box-text'>Quantity:" + quantity +"</span><span class='info-box-text'>Sub Total:"+ subtotal + "</span> </span><span class='info-box-text'>Price Per Ton :" + price_per_ton + "</div>";
     return stock_box;
   }

   $('#stock').change(function(){
     $p_p_t = $('option:selected',stock).attr('price_per_ton');
       //gets the cost per ton from option attribute
       $('#price_per_ton').val($p_p_t);
   });

   $('#save_amount_paid').click(function(){
    $.post('sales_ajax_manager.php',

    {
      'action': 'SAVE_AMOUNT_PAID',
      'amount_paid': $('#amount_paid').val()
    },
    function(data,status){
      console.log(data);
      $('.example-modal').hide();
    });

  });


   $('#del_all_stocks').click(function(){
    if($('.added-stock').length == 0){
     showToast('info', 'Cart Already Empty');
   }else{

    if(confirm('Are You Sure You Want to Delete All Stock')){
     $.post("sales_ajax_manager.php",
     {
      action:"DELETE_ALL"
    },
    function(data,status){
      showToast('success', 'Successfully Emptied Cart');
      removeElem($('.added-stock'));
      updateQuantityAndTotal();
    });

   }
 }


});

   $('#proceed').click(function(){


     if($('#customer').val() == '' || $('#invoice_number').val() == '' || $('#sale_date').val() == ''){
      showToast('error', 'Pls You must make sure to fill up all Fields');
    }
    else if($('.added-stock').length == 0) {
      showToast('warning', 'You cannot Proceed With An Empty Screen, Pls Add Something');
    }
       // else if($('#')){

       // }
       else{
        // sends a req to the server telling it the save the data in the session to the database 
        var cont = confirm('Are You Sure The Amount Paid Is ' + $('#new_amount_paid').val() + '?');
        if(cont){
                    //in this ajax request send the amount paid to the server, including an action to save
                    //data in the session to the db
                    $.post('sale_ajax_creator.php',
                    {
                     action: 'SAVE',
                     amount_paid : $('#new_amount_paid').val()
                   },
                   function(data,status){
                     console.log(data);
                     if(data.status == 'success'){
                      window.location = data.new_location;
                    }
                  });
                     // end the ajax block
                   }else{   
                    // $('#new_amount_paid').attr('autofocus', true);
                    showToast('info', 'Please Change The Amount Paid now');
                  }

       }//end else

    });// end the proceed click event listener



   $('#add-stock').click(function(event){
    event.preventDefault();
    var stock = $('#stock');

    if ($('#stock').val() == '' || $('#quantity').val() == ''){
      showToast('error', "pls fill Up Those Spaces");
    }else{

      $stock_id = $('option:selected',stock).attr('id');

            //send the request to the server
            $.post("sales_ajax_manager.php",
            {
              action: "STORESUBSALE",
              stock_id: $stock_id,
              quantity_sold: $('#quantity_sold').val(),
              quantity_per_ton: $('#quantity_per_ton').val(),
              price_per_ton: $('#price_per_ton').val()
            },

            function(data){
              console.log(data);
              if(data.status == 'success'){
                $('#cart').append(getStockBox(data.description,data.quantity,data.subtotal,data.rmv_index,data.price_per_ton));
                updateQuantityAndTotal();
                if(data.qty_status_message ==''){
                  showToast('success', 'Stock Added');
                }else{
                   showToast('info', 'Stock Added, ' + data.qty_status_message, 10000);
                }
                
                bindRemover();
                $('#stock').val('');
                $('#quantity_sold').val('');
                $('#quantity_per_ton').val('');

              }

           });  
          }   

        });


   $('#customer').change(function(){
    $.post("sales_ajax_manager.php",
    {
      action:"SETCUSTOMERID",
      customer_id:$('option:selected', $('#customer')).attr('id')
    },
    function(data,status){
      console.log(data);
    });
  });

   $('#sale_date').change(function(){
    $.post("sales_ajax_manager.php",
    {
      action:"SETDATE",
      sale_date:$(this).val()
    },
    function(data,status){
      console.log(data);
    });
  });

   $('#invoice-number').change(function(){
    $.post("sales_ajax_manager.php",
    {
      action:"SETINVOICENUM",
      invoice_number:$(this).val()
    },
    function(data,status){
      console.log(data);
    });
  });
 });

</script>
</body>
</html>
