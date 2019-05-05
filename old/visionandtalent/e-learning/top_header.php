<!--Header-part-->
<div>
  <h3><img src="img/vision.png" height="30%" width="12%" alt="logo" ></h3>
</div>
<!--close-Header-part--> 
<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome <?php echo $login_name;?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Courses</a></li>
        <li class="divider"></li>
        <li><a href="logout"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Watched</span></a></li>
    <li class=""><a title="" href="logout"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
<form method="GET" action="search">
  <input type="text" name="query" placeholder="Search here..."/>
  <button type="submit" name="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
  </form>
</div>
<!--close-top-serch-->