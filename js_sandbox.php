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
	$header = $row['header'];
	$description = $row['description'];
	$body = $row['body'];
	$sidebar = $row['sidebar'];
	$subtitle = $row['subtitle'];
	$thumbnail = $row['thumbnail'];
	
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
    echo '<meta property="og:url" content="https://orenbell.com/opinion?id=' . base64_encode(sprintf("%03d",$id)) . '"/>'
    ?>
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

    <?php
    echo $header;
    ?>

</head>

<!--Ordinarily the body gets 70px of padding: 50 for the nav bar and 20 for good measure, but in this template, we get
    rid of the excess 20. -->
<body style="padding-top: 50px">
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
                        <a href="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http")
                            . "://$_SERVER[HTTP_HOST]?feed=pdf"; ?>">Research</a>
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

    <?php echo $body; ?>

    <!-- jQuery -->
    <script src="/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.js"></script>

</body>
<script>
    <?php echo $sidebar; ?>
</script>
</html>
