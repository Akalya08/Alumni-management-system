	<header class="header-section">
	    <div class="header-top">
	        <div class=" m-0">
	            <div class="" style="text-align:center">
	                <img src="img/logo-final.png" alt="" style="height: 130px;">
	            </div>
	        </div>
	    </div>
	    <div class="header-bottom">
	        <a href="index.php" class="site-logo" style="color:#fff; font-weight:bold; font-size:26px;     margin-top: 10px;
">
	            <br />
	            <!-- <small style="margin-top:-4%;">ALUMNI Management System</small> -->
	        </a>

	        <div class="container">
	            <ul class="main-menu">
	                <li><a href="index.php"  class="<?= $page == "home" ? 'active' : '';?>"  >Home</a></li>
	                <li><a href="about.php"  class="<?= $page == "about" ? 'active' : '';?>">About</a></li>
	                <li><a href="contact.php"  class="<?= $page == "contact" ? 'active' : '';?>">Contact</a></li>
	                <li><a href="admin/login.php?n=CO-ORDINATOR">Co-ordinator login </a></li>
					<li><a href="admin/login.php?n=STUDENT">Student Login</a></li>
					<li><a href="admin/login.php?n=ALUMNI">Alumni Login</a></li>
					<li><a href="alumni-registration.php"  class="<?= $page == "reg" ? 'active' : '';?>">Alumni Registration</a></li>




	            </ul>
	        </div>
	    </div>
	</header>