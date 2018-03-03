<!DOCTYPE html>
<html lang="en">
<?php
try {
$conn = new PDO("mysql:host=localhost;dbname=website","guest");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

#When calling the homepage, you can pass parameters that'll dictate what it shows or redirects you to
$id = $_GET['id'];          #Unique ID of a page, this'll redirect you to that page
$feed = $_GET['feed'];      #General category (eq to template), this'll redirect you
$start = $_GET['start'];    #Shows what page you're on. 0 is the first, 10 is the 2nd, etc
$count = 10;                #Display 10 articles on page
    

if (!is_null($id)) {
    #If the URL was passed an ID, then lookup the page and direct to the appropriate template
    $stmt = $conn->query("SELECT template FROM pages WHERE id=" . (int)base64_decode($id));
    $row = $stmt->fetch();
    $path = $row['template'] . "?id=" . $id;
    header('Location: ' . $path, true);
    exit();
}

if (!is_null($start)) {
    #If there's a start param defined, the user is looking at the 2nd or 3rd page. Use the start as offset
    #in the SQL query
    $offset = " OFFSET " . $start;
} else $offset = "";

if (!is_null($feed)) {
    #If a feed is specified, the user wants to look at a categorized list of pages. Pass this as a
    #WHERE template = ... in the SQL query
    $filter = " WHERE template='" . $feed . "'";
} else $filter = "";

    #Fetch basic metadata regarding 10 pages
    #TODO: Let user have a larger feed by making the value 10 dependant on variable
    $stmt = $conn->query("SELECT id, title, subtitle, description, thumbnail, template
                                    FROM pages " . $filter . " ORDER BY pub_date desc LIMIT " . $count . $offset);

    $pages = $stmt->fetchall();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Personal website. I do what I want. Blogging for now. More features to come"/>
    <meta property="og:url" content="http://orenp.com"/>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="The Nightduck's Space" />
    <meta property="og:description" content="Personal website. I do what I want. Blogging for now. More features to come"/>
    <meta property="og:image" content="http://orenp.com/rsc/insertlogohere.png"/>

    <!--TODO: Modify the title, or add a subtitle dependant on the $feed variable-->
    <title>The Nightduck's Space</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylesheet.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body data-gr-c-s-loaded="true">

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="color:blue;">
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
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="https://orenp.com/research">Research</a>
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
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php
                if (is_null($feed)) {
                    echo "Welcome to Oren's Personal Website";
                } else echo ucfirst($feed);
            ?></h1>
        </div>
    </div>
    <!-- /.row -->

    <div class="primary col-md-8 container">
        <!--
        <div class="row article">
            <div class="col-md-4">
                <a href="/article?id=base64_id_here">
                    <img class="img-responsive" src="rsc/thumnail_here.png" alt="">
                </a>
            </div>
            <div class="col-md-8">
                <a href="/template_here?id=base64_id_here">
                    <h3>Example Item
                        <br/>
                        <small>Some of them have subtitles</small>
                    </h3>
                </a>
                <p>Uncomment this section to see what articles should be rendered like</p>
            </div>
        </div>
        -->

        <?php
        foreach ($pages as $row) {
            $link = sprintf("/%s?id=%s", $row['template'] . ".php", base64_encode(sprintf("%03d",$row['id'])));
            $titleinfo = sprintf("<h3>%s<br/><small>%s</small></h3>",$row['title'], $row['subtitle']);

            echo "<div class='row article'><div class='col-md-4'>";
            echo sprintf("<a href='%s'>", $link);
            echo sprintf("<img class='img-responsive' src='rsc/%s' alt=''></a></div>", $row['thumbnail']);
            echo sprintf("<div class='col-md-8'><a href='%s'>%s</a><p>%s</p>",$link, $titleinfo, $row['description']);
            echo "</div></div><hr>";
        }
        ?>

        <!-- Template
        <div class="row article">
            <div class="col-md-4">
                <a href="/articles/link.html">
                    <img class="img-responsive" src="rsc/paretocurve.png" alt="">
                </a>
            </div>
            <div class="col-md-8">
                <a href="/articles/link.html">
                    <h3>Main Title
                        <br/>
                        <small>Subtitle (optional)</small>
                    </h3>
                </a>
                <p>First few words of article. Lorem ipswitchsd  sdlfjls  dijf o
                   sodij  dofi  jf ijef jfifieeo io  jfe foaeopg jeio d ...</p>
            </div>
        </div>

        <hr>-->

    </div>
    <div class="sidebar col-md-4">
        <!--TODO: populate sidebar-->
    </div>

    <!-- <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Contact: inquiries@orenp.com</p>
                <a href="https://gandi.net"><img src="rsc/GANDI_SSL_logo_en.png" alt="Secured by Gandi.net"/></a>
            </div>
        </div>
        <!-- /.row -->
    </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js"></script>




</body>
</html> 