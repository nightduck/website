<!DOCTYPE html>
<html lang="en">
<?php
//Get the base64 encoded tag, and convert it back into the ID
$id = (int)base64_decode($_GET['id']);
	
try {
	$conn = new PDO("mysql:host=localhost;dbname=website","guest");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$stmt = $conn->query("SELECT * FROM pages WHERE id=" . $id);
	$row = $stmt->fetch();
	
	$title = $row['title'];
	$pub_date = strtotime($row['pub_date']);
	$description = $row['description'];
	$body = $row['body'];
	$sidebar = $row['sidebar'];
	$subtitle = $row['subtitle'];
	$thumbnail = $row['thumbnail'];
	$header_img = $row['header_img'];
	
} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
	exit();
}

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <?php 
    echo '<meta property="og:url" content="orenbell.com/article?id=' . base64_encode(sprintf("%06d",$id)) . '"/>'
    ?>
    <meta property="og:url" content=""/>
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $title ?>" />
    <meta property="og:title" content="<?php echo $description?>"/>
    <meta property="og:image" content="<?php echo $thumbnail?>"/>
    <meta name="author" content="">

    <title><?php echo $title ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/stylesheet.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http")
                            . "://$_SERVER[HTTP_HOST]"; ?>">Home</a>
                    </li>
                    <li>
                        <a href="https://github.com/nightduck">Github</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Title -->
            <h1><?php echo $title; ?></h1>
            <h3><?php echo $subtitle; ?></h3>

            <hr>

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on
                    <?php
                    $date = date('M d, Y', $pub_date);
                    $time = date('H:i A', $pub_date);
                    echo $date . " at " . $time . " UTC";
                    ?>
                </p>

                <hr>

                <!-- Post Content -->
                <div>
                    <object data="<?php echo $body; ?>" type="application/pdf" width="100%" height="720px">
                        <p>You can't see this because you suck dick for a living</p>
                    </object>
                </div>
               <!--
                <hr>

                <-- Blog Comments --

                <-- Comments Form --
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form">
                        <div class="form-group">
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <-- Posted Comments --

                <-- Comment --
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>

                <-- Comment --
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <-- Nested Comment --
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <-- End Nested Comment --
                    </div>
                </div>-->

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <?php echo $sidebar; ?>
            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!--<!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Contact: inquiries@orenbell.com</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.js"></script>

</body></html>
