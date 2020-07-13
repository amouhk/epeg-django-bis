<?php 

    // On prolonge la session
    session_start();
    // On teste si la variable de session existe et contient une valeur
    if(empty($_SESSION['USER'])) 
    {
      // Si inexistante ou nulle, on redirige vers le formulaire de login
      header('Location: admin-404.php');
      exit();
    }
    
    $mysqli = new mysqli("localhost", "epegobel_user", "AY]P~8FYbPzqP9T6a$", "epegobel_database" );
    
    $mysqli->set_charset("utf8");
    if ($mysqli->connect_error) 
    {
        header('Location: /admin-login.php');
    }
    
    $filter_pic_html = "";
    $filter_vid_html = "";
    $list_items_html = "";
    
    
    if ( !empty($mysqli) )
    {
      //All Photo tag
      $sql = "SELECT DISTINCT `album` FROM `galeries` WHERE `type`='Photo'";
      $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

      //Fetch into associative array
      while ( $row = $sql_resp->fetch_assoc())  
      {
          $filter_pic_html .= "\n" . '                           <li>';
          $filter_pic_html .= "\n" . '                              <input data-path=".p'. $row['album'] .'" id="p'. $row['album'] .'" type="checkbox"/>';
          $filter_pic_html .= "\n" . '                              <label for="p'. $row['album'] .'">'. $row['album'] .'</label>';
          $filter_pic_html .= "\n" . '                           </li>';
      }

      //All Video tag
      $sql = "SELECT DISTINCT `album` FROM `galeries` WHERE `type`='Video'";
      $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

      //Fetch into associative array
      while ( $row = $sql_resp->fetch_assoc())  
      {
          $filter_vid_html .= "\n" . '                           <li>';
          $filter_vid_html .= "\n" . '                              <input data-path=".v'. $row['album'] .'" id="v'. $row['album'] .'" type="checkbox"/>';
          $filter_vid_html .= "\n" . '                              <label for="v'. $row['album'] .'">'. $row['album'] .'</label>';
          $filter_vid_html .= "\n" . '                           </li>';
      }
      
      //All Photo tag
      $sql = "SELECT * FROM `galeries`";
      $sql_resp = $mysqli->query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());
      
      while ( $row = $sql_resp->fetch_assoc())  
      {
          $tagClass = "";
          if ( $row['type'] == "Photo")
          {
            $tagClass = 'p'.$row['album'];
          
            $list_items_html .= "\n" . '                    <div class="col-lg-3 col-md-4 col-xs-6 thumb list-item">';
            $list_items_html .= "\n" . '                        <a data-fancybox="gallery" href="'. $row['filepath'] .'?auto=compress&cs=tinysrgb&h=650&w=940" data-caption="'. $row['name'] .'" >';
            $list_items_html .= "\n" . '                            <img  src="'. $row['filepath'] .'?auto=compress&cs=tinysrgb&h=650&w=940"  alt="" class="zoom img-fluid">';
            $list_items_html .= "\n" . '                        </a>';
            $list_items_html .= "\n" . '                        <span class="'. $tagClass .'"></span>';
            $list_items_html .= "\n" . '                    </div>';
          }
          else if ( $row['type'] == "Video")
          {
            $tagClass = 'v'.$row['album'];
          
            $list_items_html .= "\n" . '                    <div class="col-lg-3 col-md-4 col-xs-6 thumb list-item">';
            $list_items_html .= "\n" . '                        <a data-fancybox="gallery" href="'. $row['filepath'] .'?auto=compress&cs=tinysrgb&h=650&w=940" data-caption="'. $row['name'] .'" >';
            $list_items_html .= "\n" . '                             <img class="card-img-top img-fluid" src="https://www.html5rocks.com/en/tutorials/video/basics/poster.png" />';
            $list_items_html .= "\n" . '                        </a>';
            $list_items_html .= "\n" . '                        <video width="640" height="320" controls id="myVideo" style="display:none;">';
            $list_items_html .= "\n" . '                              <source src="'. $row['filepath'] .'?auto=compress&cs=tinysrgb&h=650&w=940" type="video/mp4" class="zoom img-fluid">';
            $list_items_html .= "\n" . '                        </video>';
            $list_items_html .= "\n" . '                        <span class="'. $tagClass .'"></span>';
            $list_items_html .= "\n" . '                    </div>';            
          }     
      }
    }
    else
    {
      header('Location: admin-404.php');
      exit();
    }
    
    
    

    $file = '../../page_gallery.php';

    $html_content = "";
    $html_content .= "\n" . '<!DOCTYPE html>';
    $html_content .= "\n" . '<html lang="fr">';
    $html_content .= "\n" . '  <head>';
    $html_content .= "\n" . "    <?php include('parts/public/head.php'); ?> ";
    $html_content .= "\n" . '    <!-- jQuery lib -->';
    $html_content .= "\n" . '    <script type="text/javascript" src="libs/js/lib/jquery.min.js"></script>';
    $html_content .= "\n" . '    <!-- gallery css -->';
    $html_content .= "\n" . '    <link rel="stylesheet" href="libs/css/gallery.css">';
    $html_content .= "\n" . '    <!-- demo page styles -->';
    $html_content .= "\n" . '    <link href="/libs/css/jplist.demo-pages.min.css" rel="stylesheet" type="text/css" />';
    $html_content .= "\n" . '    <!-- jPList css files -->';
    $html_content .= "\n" . '    <!-- jPList core js and css  -->';
    $html_content .= "\n" . '    <link href="/libs/css/jplist.core.min.css" rel="stylesheet" type="text/css" />';
    $html_content .= "\n" . '    <script src="/libs/js/jplist.core.min.js"></script>';
    $html_content .= "\n" . '    <!-- jPList toggle bundle-->';
    $html_content .= "\n" . '    <script src="/libs/js/jplist.filter-toggle-bundle.min.js"></script>';
    $html_content .= "\n" . '    <link href="/libs/css/jplist.filter-toggle-bundle.min.css" rel="stylesheet" type="text/css" />';
    $html_content .= "\n" . '    <!-- checkbox dropdown control styles and js -->';
    $html_content .= "\n" . '    <link href="/libs/css/jplist.checkbox-dropdown.min.css" rel="stylesheet" type="text/css" />';
    $html_content .= "\n" . '    <script src="/libs/js/jplist.checkbox-dropdown.min.js"></script>';
    $html_content .= "\n" . '    <!-- jplist pagination bundle -->';
    $html_content .= "\n" . '    <script src="/libs/js/jplist.pagination-bundle.min.js"></script>';
    $html_content .= "\n" . '    <link href="/libs/css/jplist.pagination-bundle.min.css" rel="stylesheet" type="text/css" />';
    $html_content .= "\n" . '    <!-- fancy box -->';
    $html_content .= "\n" . '    <script src="/libs/js/jquery.fancybox.min.js"></script>';
    $html_content .= "\n" . '    <link  href="/libs/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css">';
    $html_content .= "\n" . '    <!-- jPList start -->';
    $html_content .= "\n" . "    <script>";
    $html_content .= "\n" . "      //start jplist";
    $html_content .= "\n" . "       $('document').ready(function(){";
    $html_content .= "\n" . "           $('#demo').jplist({";		
    $html_content .= "\n" . "              itemsBox: '.list' ";
    $html_content .= "\n" . "              ,itemPath: '.list-item' ";
    $html_content .= "\n" . "              ,panelPath: '.jplist-panel'	";
    $html_content .= "\n" . "           });";
    $html_content .= "\n" . "        });";
    $html_content .= "\n" . "    </script>";
    $html_content .= "\n" . '  </head>';
    $html_content .= "\n" . '  <body>';
    $html_content .= "\n" . '    <!-- Navigation -->';
    $html_content .= "\n" . "    <?php include('parts/public/nav-topbar.php'); ?>";
    $html_content .= "\n" . "    <?php include('parts/public/header.php'); ?>";
    $html_content .= "\n" . '    <!-- Page Content -->';
    $html_content .= "\n" . '    <div class="container my-4"  id="container-bg">';
    $html_content .= "\n" . '        <div class=" mt-2">';
    $html_content .= "\n" . '            <div class="mt-1">';
    $html_content .= "\n" . '                <h2>Galerie des Photos et Videos </h2>';
    $html_content .= "\n" . '                <hr>';
    $html_content .= "\n" . '            </div>';         
    $html_content .= "\n" . '        </div>';
    $html_content .= "\n" . '         <span id="demo" class="jplist">';
    $html_content .= "\n" . '         <div class="row">';
    $html_content .= "\n" . '             <!-- Filters -->';
    $html_content .= "\n" . '             <div class="col-lg-3">';
    $html_content .= "\n" . '                <div class="card px-1 pt-2 pb-5 border border-success" style="background-color: #d3e6d9; border-radius: 5px;">';
    $html_content .= "\n" . '                <!--  filters type -->';
    $html_content .= "\n" . '                <div class="jplist-panel">';
    $html_content .= "\n" . '                     <!-- checkbox dropdown -->';
    $html_content .= "\n" . '                     <div ';
    $html_content .= "\n" . '                        class="jplist-checkbox-dropdown"';
    $html_content .= "\n" . '                        data-control-type="checkbox-dropdown" ';
    $html_content .= "\n" . '                        data-control-name="category-checkbox-dropdown" ';
    $html_content .= "\n" . '                        data-control-action="filter"';
    $html_content .= "\n" . '                        data-no-selected-text="Photos:"';
    $html_content .= "\n" . '                        data-one-item-text="Photos {selected}"';
    $html_content .= "\n" . '                        data-many-items-text="Photos {num} selected">';
    $html_content .= "\n" . '                        <ul>';
    $html_content .= "\n" .                          $filter_pic_html ;                           
    $html_content .= "\n" . '                        </ul>';
    $html_content .= "\n" . '                     </div>';
    $html_content .= "\n" . '                    <div ';
    $html_content .= "\n" . '                        class="jplist-checkbox-dropdown"';
    $html_content .= "\n" . '                        data-control-type="checkbox-dropdown" ';
    $html_content .= "\n" . '                        data-control-name="category-checkbox-dropdown"' ;
    $html_content .= "\n" . '                        data-control-action="filter"';
    $html_content .= "\n" . '                        data-no-selected-text="Videos :"';
    $html_content .= "\n" . '                        data-one-item-text="Videos {selected}"';
    $html_content .= "\n" . '                        data-many-items-text="Videos {num} selected">';
    $html_content .= "\n" . '                        <ul>';
    $html_content .= "\n" .                          $filter_vid_html;  
    $html_content .= "\n" . '                        </ul>';
    $html_content .= "\n" . '                     </div> ';
    $html_content .= "\n" . '                </div>		';
    $html_content .= "\n" . '                </div>		';
    $html_content .= "\n" . '             </div>';
    $html_content .= "\n" . '             <!-- Picture and Video -->';
    $html_content .= "\n" . '             <div class="col-lg-9">';
    $html_content .= "\n" . '               <div class="row">';
    $html_content .= "\n" . '                 <div class="col-lg-12 col-md-12 col-xs-12 pb-2">' ;
    $html_content .= "\n" . '                     <div class="jplist-panel panel-top border border-success" style="background-color: #d3e6d9; border-radius: 5px;">';						
    $html_content .= "\n" . '                     <!-- items per page dropdown -->';
    $html_content .= "\n" . '                     <div ';
    $html_content .= "\n" . '                        class="jplist-drop-down" ';
    $html_content .= "\n" . '                        data-control-type="items-per-page-drop-down"'; 
    $html_content .= "\n" . '                        data-control-name="paging"'; 
    $html_content .= "\n" . '                        data-control-action="paging">';
    $html_content .= "\n" . '                        <ul>';
    $html_content .= "\n" . '                          <li><span data-number="48"> 48 par page </span></li>';
    $html_content .= "\n" . '                          <li><span data-number="24" data-default="true"> 12 par page </span></li>';
    $html_content .= "\n" . '                          <li><span data-number="all"> Tous </span></li>';
    $html_content .= "\n" . '                        </ul>';
    $html_content .= "\n" . '                     </div>';
    $html_content .= "\n" . '             		<div ';
    $html_content .= "\n" . '             		   class="jplist-label"'; 
    $html_content .= "\n" . '             		   data-type="Page {current} of {pages}"'; 
    $html_content .= "\n" . '             		   data-control-type="pagination-info"'; 
    $html_content .= "\n" . '             		   data-control-name="paging"'; 
    $html_content .= "\n" . '             		   data-control-action="paging">';
    $html_content .= "\n" . '             		</div>';	
    $html_content .= "\n" . '             		<div'; 
    $html_content .= "\n" . '             		   class="jplist-pagination"'; 
    $html_content .= "\n" . '             		   data-control-type="pagination"'; 
    $html_content .= "\n" . '             		   data-control-name="paging"'; 
    $html_content .= "\n" . '             		   data-control-action="paging">';
    $html_content .= "\n" . '             		</div>';			
    $html_content .= "\n" . '             	    </div>';
    $html_content .= "\n" . '                 </div>';
    $html_content .= "\n" . '                <div class="list">';
    $html_content .= "\n" .                     $list_items_html;
    $html_content .= "\n" . '                </div>';
    $html_content .= "\n" . '            </div>';
    $html_content .= "\n" . '        </div>';
    $html_content .= "\n" . '        </span>';
    $html_content .= "\n" . '    </div>';
    $html_content .= "\n" . '    </div>';
    $html_content .= "\n" . '    <!-- /.container -->';
    $html_content .= "\n" . '    <!-- Footer -->';
    $html_content .= "\n" . "    <?php include('parts/footer.php'); ?>";
    $html_content .= "\n" . '    <!-- Bootstrap core JavaScript -->';
    $html_content .= "\n" . '    <script src="libs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>';
    $html_content .= "\n" . "    <script type='text/javascript'>";
    $html_content .= "\n" . '      $(document).ready(function(){';
    $html_content .= "\n" . '        $(".fancybox").fancybox({';
    $html_content .= "\n" . '              openEffect: "none",';
    $html_content .= "\n" . '              closeEffect: "none"';
    $html_content .= "\n" . '          });';
    $html_content .= "\n" . '          $(".zoom").hover(function(){';
    $html_content .= "\n" . '          $(this).addClass("transition");';
    $html_content .= "\n" . '        }, function(){';
    $html_content .= "\n" . '          $(this).removeClass("transition");';
    $html_content .= "\n" . '        });';
    $html_content .= "\n" . '      });';
    $html_content .= "\n" . '    </script>';
    $html_content .= "\n" . '  </body>';
    $html_content .= "\n" . '</html>';
    
    //echo $html_content;
    $ret = file_put_contents($file, $html_content, LOCK_EX);
    //echo $ret;
    header('Location: /admin-index.php');

?>
