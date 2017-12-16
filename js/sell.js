
$('document').ready(function(){
//get Cusotmer ID from The URL

let customer_id = getParameterByName('cid');

if (customer_id != '' && customer_id != null){
  let customerselect = document.getElementById('customer');
  let options = document.getElementById('customer').options;
  for(let i = 0; i < options.length; i++){
    if (options[i].getAttribute('id') == customer_id){
      customerselect.selectedIndex = i; 
    }
  }
  storeCustomer(customer_id);
}

//get URI value
function getParameterByName(name,url){
  if(!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
  results = regex.exec(url);
  if (!results) return null;
  if(!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g," "));
}

//send the save action to the server
function finishSale(supply_status){
  $.post('sale_ajax_creator.php',
  {
    action: 'SAVE',
    amount_paid : $('#new_amount_paid').val(),
    supply_status: supply_status
  },
  function(data,status){
    console.log(data,status);
    if(data.status == 'success'){
      $('.sk-wave').hide();
      window.location = data.new_location;
    }else{
     console.log(Error('an error occured'));
   }
 });
}

//send the customer ID via ajax when the customer is selected from the select box
function storeCustomer(customer_id){
  $.post("sales_ajax_manager.php",
  {
    action:"SETCUSTOMERID",
    customer_id: customer_id
  },
  function(debtobj,status){
    // show some toast if customer is a debtor
    if (status == 'success'){
     debtobj = JSON.parse(debtobj);
     if(debtobj.amount != null && Math.round(debtobj.amount) > 0){
      showToast('warning', debtobj.name + " Was Previously Owing The Sum Of ₦" +  debtobj.amount, 6000);
    }
  }
});
}


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
function showToast(type, message,time = 3000){
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
    $('#show_total_sale').text( '₦' + data.quantity);
    $('#show_total_qty').text(data.total);
    $('#new_amount_paid').val(data.quantity);
  });
}

function getStockBox(description,quantity,subtotal,rmv_index,price_per_ton){
  var stock_box = "<div class='callout added-stock animated rollIn'><button data-toggle = 'tooltip' title='Delete This Item' class = ' close delstock'  rmv_index ="+ rmv_index +" >×</button><span class='info-box-text'>Description :" + description +"</span> <span class='info-box-text'>Quantity:" + quantity +"</span><span class='info-box-text'>Sub Total:"+ subtotal + "</span> </span><span class='info-box-text'>Price Per Ton :" + price_per_ton + "</div>";
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
  else{
  // sends a req to the server telling it the save the data in the session to the database 
  //in this ajax request send the amount paid to the server, including an action to save
  //data in the session to the db
  $('#confirm__supply__status').slideDown();
  $('.status-btn').addClass('zoomInDown');

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

function(data,status){
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
    $('#price_per_ton').val('');
  }

});  
}});


$('#customer').change(function(){
  let customer_id = $('option:selected', $('#customer')).attr('id');

  // returrn {{}} if customer is a debtor
  storeCustomer(customer_id);
  // if(debt_status){

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


$('#item_supplied').click(function(){
  $('.sk-wave').show();
  finishSale(1);
});

$('#item_not_supplied').click(function(){
 $('.sk-wave').show();
 finishSale(0);
});

$('#confirm__supply__status').mouseleave(function(){
 $(this).slideUp();
 $('.sk-wave').hide();
});


});