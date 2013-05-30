<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?=config_item('bootstrap')?>" rel="stylesheet">
    <script src="<?=config_item('jquery')?>"></script>
    <script>
		$(document).ready(function(e) {
			
			$('#category_id').change(function(e) {
				$('#subcategory').attr('disabled', 'disabled');
				$('#subcategory').empty();
                var id = $(this).val();
				
				if(id == 'n' || id== '0'){
					return false;
				}else{
					$.post('<?=base_url()?>admin/products/subList',{ID: id},function(data){
						
						if(isNaN(data)){
							$('#subcategory').removeAttr('disabled');
							$('#subcategory').html(data);
							
						}else{
							/*if(confirm('There is no Sub category for this category. Would you like to add new?')){
								window.location = '<?=base_url()?>admin/subcategory/new_subcategory/'+data;
							}*/
							return false;	
						}
					
					});
				}
				
				return false;
            });
			
			
			/*************************************************/
            $('#frm').submit(function(e) {
                
				if(document.frm.category_name.value == ''){
					
					alert('Please enter a category name');
					document.frm.category_name.focus();
					return false;
				}
				return true
            });
			/*********************************************/
			
			$('#product_id').blur(function(e) {
                var id = $(this).val();
				if(id != ''){
					$.post('<?=base_url()?>admin/products/checkPiD',{ID: id},function(data){
					
						if(data == 'e'){
							$('#btn').attr('disabled','disabled');
							$('#pid').addClass('error');
						}
						else if(data == 's'){
							$('#btn').removeAttr('disabled');
							$('#pid').addClass('control-group success');
						}
						
					});	
				}
            });
        });
	</script>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
		border:1px solid #CCC;
		border-radius:4px;
		background:#FAFAFA;
      }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Administrator Panel</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link"> {username}</a>
            </p>
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
             
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Menus</li>
              <li class="active"><a href="<?=base_url()?>admin/category">Categories</a></li>
              <li><a href="#">Sub categories</a></li>
              <li><a href="#">Products</a></li>
              <li class="nav-header">Others</li>
              <li><a href="#">Import</a></li>
              <li><a href="#">Export</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          
          <div class="well">
          	<strong>Add New Product</strong>
          </div>
          
          <a href="<?=base_url()?>admin/products/" class="btn">Back </a> <br>
<br>
<?=$this->session->flashdata('message')?>
          <div class="row-fluid">
           		
             
              <br>

              <form class="form-horizontal" action="<?=base_url()?>admin/products/new_products" method="post" id="frm" name="frm" enctype="multipart/form-data">
            
  <div class="pull-left control-group">
    <label class="control-label" for="inputEmail">Category name</label>
    <div class="controls">
      
      <select name="category_id" id="category_id">
      	<option value="n">--Select category--</option>
        <option value="0">Uncategories</option>
        <?php foreach($categoryList as $cl):?>
        	<option value="<?= $cl['category_id']?>"><?= $cl['category_name']?></option>
        <?php endforeach;?>
      </select>

    </div>
  </div>
  <div class="pull-right control-group">
    <label class="control-label" for="inputEmail">Sub Category</label>
    <div class="controls">
      <select name="subcategory" id="subcategory" disabled>
      		
      </select>
    </div>
  </div>
  <div class="pull-left control-group" id="pid">
    <label class="control-label" for="inputEmail">Product ID</label>
    <div class="controls">
      <input type="text" name="product_id"  id="product_id" placeholder="Product Id (required)" />
    </div>
  </div>
  <div class="pull-right control-group">
    <label class="control-label" for="inputEmail">Product Name</label>
    <div class="controls">
      <input type="text" name="product_name" placeholder="Product Name (required)" />
    </div>
  </div>
  <div class="pull-left control-group">
    <label class="control-label" for="inputEmail">Quantity</label>
    <div class="controls">
      <input type="text" title="Enter Zero if no" name="qty" placeholder="Quantity (required)" />
    </div>
  </div>
  <div class="pull-right control-group">
    <label class="control-label" for="inputPassword">Unit</label>
    <div class="controls">
      <select name="unit">
      	<option>Kg</option>
        <option>Ltr</option>
        <option>Gram</option>
        <option>Pcs</option>
      </select>
    </div>
  </div>
  
  <div class="pull-left control-group">
    <label class="control-label" for="inputEmail">MRP</label>
    <div class=" controls">
    <span class="input-prepend input-append">
     <span class="add-on">Rs</span>
      <input type="text"  title="Enter Zero if no" name="mrp" placeholder="MRP (required)" />
      </span>
    </div>
  </div>
  <div class="pull-right control-group">
    <label class="control-label" for="inputEmail">Our price</label>
    <div class="controls">
    <span class="input-prepend input-append">
    <span class="add-on">Rs</span>
      <input type="text" title="Enter Zero if no" name="ourprice" placeholder="Our Price (required)" />
      </span>
    </div>
  </div>
  
  <div class="pull-left control-group">
    <label class="control-label" for="inputEmail">Status</label>
    <div class="controls">
      <select name="status">
      	<option value="0">Active</option>
        <option value="1">Inactive</option>
      </select>
    </div>
  </div>
  
  
  <div class="pull-right control-group">
    <label class="control-label" for="inputEmail">New Launch</label>
    <div class="controls">
      <select name="newlaunch">
      	<option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>
  </div>
  
  <div class="pull-left control-group">
    <label class="control-label" for="inputEmail">Free</label>
    <div class="controls">
      <select name="free">
      	<option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>
  </div>
  
   <div class="pull-right control-group">
    <label class="control-label" for="inputEmail">Image</label>
    <div class="controls">
      <input type="file" name="image" />
    </div>
  </div>
  
  <div class="pull-left control-group">
    <label class="control-label" for="inputEmail">Products Details</label>
    <div class="controls">
      <textarea name="products_details"></textarea>
    </div>
  </div>
  
  <div class="pull-left control-group">
    <div class="controls">
      <label class="checkbox">
        
      </label>
      <button type="submit" class="btn" name="btn" id="btn">Submit</button>
    </div>
  </div>
 
</form>
                
                
                
          </div><!--/row-->
          <!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2012</p>
      </footer>

    </div><!--/.fluid-container-->

  

  </body>
</html>
