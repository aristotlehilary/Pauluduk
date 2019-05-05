<!--sidebar-menu-->
<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i>Forms</a>
  <ul>
    <?php
  $result0 = mysql_query(" SELECT COUNT(tittle) FROM evideos");
  $row0 = mysql_fetch_array($result0);  
 
?>
    <li><a href="index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li><a href="explore"><i class="icon icon-th"></i> <span>Videos</span><span class="label label-important"><?php  echo $count0= $row0[0];?></span></a></li>
    
  </ul>
</div>
<!--sidebar-menu-->