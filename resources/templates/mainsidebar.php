<?php// require_once('../const.php') or echo "unable to find file";?> -->


<aside class="main-sidebar" >
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
     
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">

        <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>MUKAZ NIG. LTD.</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->

    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN MENU</li>

      <li class="active treeview">
        <a href="hello.htmp">
          <i class="glyphicon glyphicon-gift"></i> <span>Stock</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-red">3</small>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="active">

            <a href='<?php echo '../stock/new.php'?>'><i class="glyphicon glyphicon-plus"></i> New stock</a></li>
            <li><a href='<?php echo'../stock/receive.php'?>' ><i class="glyphicon glyphicon-arrow-down"></i> Receive Stocks</a></li>
            <li><a href='<?php echo'../stock/view.php'?>'><i class="  glyphicon glyphicon-eye-open"></i> View Stocks</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-user"></i>
            <span>Customer</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">3</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo '../customer/new.php'?>"><i class="fa fa-circle-o"></i> New Customer</a></li>
            <li><a href="<?php echo '../customer/view.php'?>"><i class="fa fa-circle-o"></i>View/Edit Customers</a></li>
            <li><a href="<?php echo '../customer/deposit.php'?>"><i class="fa fa-circle-o"></i>New Deposit</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-euro"></i>
            <span>Sales</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">2</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo '../sales/sell.php'?>"><i class="glyphicon glyphicon-plus"></i> New Sale</a></li>
            <li><a href="<?php echo '../sales/reprint.php'?>"><i class="glyphicon glyphicon-print"></i>Reprint Invoice</a></li>
          </ul>
        </li>

          <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-euro"></i>
            <span>Expense</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">2</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo '../expense/new.php'?>"><i class="glyphicon glyphicon-plus"></i> New </a></li>
            <li><a href="<?php echo '../expense/view.php'?>"><i class="glyphicon glyphicon-eye-open"></i>View</a></li>
          </ul>
        </li>

         <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-stats"></i>
            <span>Enquiries</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">2</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo '../enquiries/dailysales.php'?>"><i class="glyphicon glyphicon"></i> Daily Sales</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-stats"></i>
            <span>B/F</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">2</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo '../bbf/new.php'?>"><i class="glyphicon glyphicon-plus"></i>Add new</a></li>
            <li><a href="<?php echo '../bbf/view.php'?>"><i class="glyphicon glyphicon-eye-open"></i>View</a></li>
          </ul>
        </li>





        <li>
          <a href="../logout.php">
            <i class="glyphicon glyphicon-log-out"></i> <span>Logout</span>
          </a>
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>