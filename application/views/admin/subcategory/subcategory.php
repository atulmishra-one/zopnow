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
		function del(id){
			if(confirm('Are you Sure you want to move this item to trash ?')){
				$('#bar'+id).fadeOut('slow');
				$.post('<?=base_url()?>admin/subcategory',{ID: id},function(data){});
				return false;
			}
			return false;
		}
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
          	<strong>Sub Categories  <?=$cname?></strong>
          </div>
          
         <a href="<?=base_url()?>admin/subcategory/new_subcategory/<?=$cid?>" class="btn btn-primary">Add New Subcategory <?=$cname?></a> <br>
<br>

          <div class="row-fluid">
         
         &nbsp;&nbsp; Total -  <span class="badge"> {total} </span>
         <br><br>
		
                <table class="table table-bordered">
                	
                    <thead>
                    	<th>
                        	Category name
                        </th>
                        
                        <th>
                        	Sun Category name
                        </th>
                        
                        <th>
                        	Status <a href="<?=base_url()?>admin/subcategory/index/subcategory_status" title="Sort by Status"> <i class="icon-chevron-up"></i> </a>
                        </th>
                        
                       
                        
                        <th>
                        	Date added <a href="<?=base_url()?>admin/subcategory/index/A.date_added/" title="Sort by Date"> <i class="icon-chevron-up"></i> </a>
                        </th>
                        <th>
                        	Edit
                        </th>
                        <th>
                        	Trash
                        </th>
                    </thead>
                  <tbody>
                  	<?php foreach($scategory as $scat):?>
                    
                    	<tr id="bar<?= $scat['subcategory_id'] ?>">
                        	<td><?= $scat['category_name']?></td>
                            <td><?= $scat['subcategory_name'] ?></td>
                            <td><?= ($scat['subcategory_status'] == 0)? 'Active': 'InActive'?></td>
                       
                            <td> <?= date('d M Y', strtotime($scat['date_added'])) ?></td>
                            <td> 
                            <a href="<?=base_url()?>admin/subcategory/edit_subcategory/<?= $scat['subcategory_id'] ?>"> <i class="icon-edit"></i></a>
                            
                            </td>
                            <td>
                            <a href="" onClick="return del(<?= $scat['subcategory_id'] ?>);"> <i class="icon-trash"></i></a>
                            </td>
                        </tr>
                    
                    
                    <?php endforeach;?>
                  </tbody>
                    
                </table>
                
                
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
