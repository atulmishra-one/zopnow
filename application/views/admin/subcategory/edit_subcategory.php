<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?=config_item('bootstrap')?>" rel="stylesheet">
    <script src="<?=config_item('jquery')?>"></script>
    <script>
		$(document).ready(function(e) {
			
			/***********************************************/
			
			
			
			/*********************************************/
            $('#frm').submit(function(e) {
                if(document.frm.category_id.value == '0'){
					document.frm.category_id.focus();
					return false;
				}
				if(document.frm.subcategoryname.value == ''){
					
					alert('Please enter a Subcategory name');
					document.frm.subcategoryname.focus();
					return false;
				}
				return true
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
          <?php $this->load->view('admin/templates/sidebar')?>
          <!--/.well -->
        </div><!--/span-->
        <div class="span9">
          
          <div class="well">
          	<strong>Edit SubCategory  &nbsp;&nbsp;" <?=$info[0]['subcategory_name'] ?> "</strong>
          </div>
          
          <a href="<?=base_url()?>admin/subcategory/" class="btn">Back </a> <br>
<br>
<?=$this->session->flashdata('message')?>
          <div class="row-fluid">
           		
             
             <div class="table table-bordered">  <br>

              <form class="form-horizontal" action="<?=base_url()?>admin/subcategory/edit_subcategory/<?=$info[0]['category_id']?>/" method="post" id="frm" name="frm">
            
  <div class="control-group">
    <label class="control-label" for="inputEmail">Category name</label>
    <div class="controls">
      <select name="category_id" id="category_id">
      	<option value="0">--Select a Category--</option>
        <?php foreach($categoryList as $cl):?>
        <option value="<?= $cl['category_id']?>" <?=($info[0]['category_id'] == $cl['category_id'])? 'selected': ''?>><?= $cl['category_name']?></option>
        <?php endforeach;?>
      </select>

    </div>
  </div>
  
  <div id="disabled">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Sub Category name</label>
    <div class="controls">
      <input type="text" name="subcategoryname" placeholder="Sub Category name (required)" value="<?=$info[0]['subcategory_name']?>" />
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Sub Category Details</label>
    <div class="controls">
      <textarea id="inputEmail" name="subcategory_details" placeholder="Sub Category Details"><?=$info[0]['subcategory_details']?></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Status</label>
    <div class="controls">
      <select name="status">
      	<option value="0" <?=($info[0]['subcategory_status'] == 0)? 'selected': ''?>>Active</option>
        <option value="1" <?=($info[0]['subcategory_status'] == 1)? 'selected': ''?>>Inactive</option>
      </select>
    </div>
  </div>
  </div>
  <div class="control-group">
    <div class="controls">
      
      <button type="submit" class="btn" name="btn" id="submit">Submit</button>
    </div>
  </div>
 
</form>
                </div>
                
                
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
