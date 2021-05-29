<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Barangay Helpdesk System with SMS Features for Text Blast Announcements | Inbox</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
  <!-- CHAT -->
  
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="cbox5.css"/>
	

    <script type="text/javascript">
        function loadSubsList(){
            $.ajax({
                type: "GET",
                url: " /utilities.php?entity=subscriber",
//                data: $('form#dictform').serialize(),
                success: function(msg){
                    $("#subslist").empty();
                    msg = JSON.parse(msg)['data'];
                    msg.forEach(function(val,index,arr){                       
                       activeclass = "";
                       if(index===0){
                           activeclass = "active";
                           loadConv(val.subscriberNumber);
                       }
                       subselem = "<li class=\"subselem "+activeclass+"\" name=\""+val.subscriberNumber+"\">"+
                                    "<a href=\"#\" class=\"clearfix\" >"+								
                                        "<div class=\"friend-name\">" +	
                                            "<strong>" + val.subscriberNumber + "</strong>" +
                                        "</div>" +
                                    "<div class=\"last-message text-muted\">"+ val.latestMsg + "</div>" +
                                    "</a>" +
                                "</li>";                                              
                        $("#subslist").append(subselem);
                    });                    
                },  
                error: function(){
                    alert("failure");
                }
            });
        }
        
        function loadConv(subscriberNumber){
            $("#currsub").val(subscriberNumber);
            geturl = "/utilities.php?entity=conv&id="+subscriberNumber;
            $.ajax({
                type: "GET",
                url: geturl,
                success: function(msg){
                    $("#chatarea").empty();
                    msg = JSON.parse(msg)['data'];
                    msg.forEach(function(val,index,arr){
                        posclass = "right";
                        iconSrc = "http://simpleicon.com/wp-content/uploads/comment-256x256.png";
                        pull = "left"
                        if(val.isMO===1) {
                            posclass="left";
                            iconSrc = "http://simpleicon.com/wp-content/uploads/magnifier-8-256x256.png";
                            pull = "right";
                        }
                        chatelem = "<li class=\""+posclass+" clearfix\">"+
                                    "<span class=\"chat-img pull-"+posclass+"\">"+
                                        "<img src=\""+iconSrc+"\" alt=\"User Avatar\">"+
                                    "</span>"+
                                    "<div class=\"chat-body clearfix\">"+
                                        "<div class=\"header\">"+
                                            "<strong class=\"primary-font\">"+val.subscriberNumber+"</strong>"+
                                            "<small class=\"pull-right text-muted\">"+val.dateTime+"</small>"+
                                        "</div>"+
                                        "<p style=\"white-space: pre-wrap;\">"+val.message+"</p>"+
                                    "</div>"+
                                "</li>";
                        
                        $("#chatarea").append(chatelem)
                    });                    
                },  
                error: function(){
                    alert("failure");
                }
            });
        }
        
        function sendMsg(subscriber,message){
            $.ajax({
                type: "POST",
                url: "/utilities.php",
                data:{
                    entity:"conv",
                    id:subscriber,
                    message:message
                },
                success: function(msg){
                    loadSubsList();                    
                },  
                error: function(){
                    alert("failure");
                }
            });
        
        }
        
        $(document).ready(loadSubsList());
    </script>

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini" onload = "loadSubsList()">
<div class="wrapper">

<input type="hidden" value="" id="currsub" />

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Barangay Helpdesk System with SMS Features for Text Blast Announcements</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
	  <!-- Full Screen -->
	  <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <!-- Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Options</span>
          <div class="dropdown-divider"></div>
          <a href="logout.php" action="logout.php" class="dropdown-item">
            <i class="fas fa-door-open mr-2"></i> Log Out
          </a>
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/brgy.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">System Administrator</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
		 
          <li class="nav-header">Functions</li>

          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Messaging
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="message-inbox.html" class="nav-link active">
                  <i class="far fa-comments nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="compose-message.php" class="nav-link">
                  <i class="far fa-keyboard nav-icon"></i>
                  <p>Compose</p>
                </a>
              </li>
            </ul>
          </li>		  


          <li class="nav-item">
            <a href="keywords.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Keyword Lists
              </p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Inbox</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Messaging</a></li>
              <li class="breadcrumb-item active">Inbox</li>
            </ol>
          </div><!-- /.col -->
		  <div class="container bootstrap snippets bootdey">
    <div class="row">
					<div class="col-md-4 bg-white ">
						<div class=" row border-bottom padding-sm" style="height: 40px;" id = "sample">
							
						</div>
						
						<!-- =============================================================== -->
						<!-- member list -->
						<ul id="subslist" class="friend-list">
							<li class="active bounceInDown">
								<a href="#" class="clearfix">									
									<div class="friend-name">	
										<strong>Loading...</strong>
									</div>
									<div class="last-message text-muted">Conversations and Subscriber Lists</div>									
								</a>
							</li>
<!--							<li>
								<a href="#" class="clearfix">
									<img src="https://bootdey.com/img/Content/user_2.jpg" alt="" class="img-circle">
									<div class="friend-name">	
										<strong>Jane Doe</strong>
									</div>
									<div class="last-message text-muted">Lorem ipsum dolor sit amet.</div>
									<small class="time text-muted">5 mins ago</small>
								<small class="chat-alert text-muted"><i class="fa fa-check"></i></small>
								</a>
							</li> -->
							                 
						</ul>
					</div>
        
        <!--=========================================================-->
        <!-- selected chat -->
    	<div class="col-md-8 bg-white ">
						<div class="chat-message">
							<ul id="chatarea" class="chat">								
                                                        </ul>
						</div>
            <div class="chat-box bg-white">
            	<div class="input-group">
								<input id="chatinput" class="form-control border no-shadow no-rounded" placeholder="Type your message here">
								<span class="input-group-btn">
									<button id="sendmsg" class="btn btn-success no-rounded" type="button">Send</button>
								</span>
				</div><!-- /input-group -->	
            </div>            
		</div>        
	</div>
</div>
		  
		  
		  
        </div><!-- /.row -->
		
		

		
		
		
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
			



        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->
    <!-- Main Footer -->
  <footer class="main-footer">
    <strong>&copy; 2021 <a href="#">Barangay Helpdesk System with SMS Features for Text Blast Announcements</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
  

  
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard3.js"></script>


<script src='https://production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>


  <!-- Custom Script for Chatroom -->
    <script type="text/javascript">
        $("#subslist").on("click","li",function(){
            $(".subselem").removeClass("active");
            $(this).addClass("active");
            subscriberNumber = $(this).attr("name");
            loadConv(subscriberNumber);
        });
        
        $("#sendmsg").click(function(){
            message = $("#chatinput").val();
            subscriber = $("#currsub").val();
            $("#chatinput").val('');
            sendMsg(subscriber,message);
        });
    </script>

<!--
<script>$(".messages").animate({ scrollTop: $(document).height() }, "fast");

function newMessage() {
	message = $(".message-input input").val();
	if($.trim(message) == '') {
		return false;
	}
	$('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
	$('.message-input input').val(null);
	$('.contact.active .preview').html('<span>You: </span>' + message);
	$(".messages").animate({ scrollTop: $(document).height() }, "fast");
};

$('.submit').click(function() {
  newMessage();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    newMessage();
    return false;
  }
});
//# sourceURL=pen.js
</script>
-->

</body>
</html>
