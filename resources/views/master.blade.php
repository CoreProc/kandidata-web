<!DOCTYPE html>
<html class="no-js" x-ng-app="kandidata">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title x-ng-bind="title">KandiData | A data-driven Web App for Twitter metrics for the Philippines Election 2016 presidential candidates</title>

    <meta name="description" content="A data-driven webapp for Twitter metrics for the Philippines Election 2016 presidential candidates.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/assets/img/kandidata-favicon.png">
    <link rel="apple-touch-icon" href="/assets/img/kandidata-favicon.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">

    <!-- Plugin Stylesheets -->
    <link rel="stylesheet" href="/assets/lib/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/lib/font-awesome/css/font-awesome.min.css">

    <!-- Project Stylesheets -->
    <link rel="stylesheet" href="/assets/css/addon.css">
    <link rel="stylesheet" href="/assets/css/main.css">

    <!-- Plugin Scripts -->
    <script src="/assets/lib/jquery/dist/jquery.min.js"></script>
    <script src="/assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/assets/lib/angular/angular.min.js"></script>
    <script src="/assets/lib/angular-ui-router/release/angular-ui-router.min.js"></script>
    <script src="/assets/lib/angular-animate/angular-animate.min.js"></script>
    <script src="/assets/lib/angular-moment/angular-moment.min.js"></script>
    <script src="/assets/lib/moment/min/moment.min.js"></script>
    <script src="/assets/lib/amcharts/dist/amcharts/amcharts.js"></script>
    <script src="/assets/lib/oclazyload/dist/ocLazyLoad.min.js"></script>

    <!-- Project Scripts -->
    <script src="/assets/js/app.js"></script>

</head>
<body>

<header class="header" x-ng-include="'/tpl/sections/header.html'"></header>

<div class="main-wrapper" ui-view> </div>

<footer class="footer" x-ng-include="'/tpl/sections/footer.html'"></footer>

<div class="scroll-top">
    <a href="#">
        <i class="fa fa-caret-up"></i>
    </a>
</div>

<script>
    $(function() {
        $('.scroll-top a').on('click', function() {
            var body = $("html, body");
            body.stop().animate({scrollTop:0}, '500', 'swing', function() {
                console.log('scroll top clicked');
            });

            return false;
        });

        $(window).scroll(function() {
            var scrollBtn = $('.scroll-top');

            if ($('body').scrollTop() > $('.header').outerHeight()) {
                scrollBtn.addClass('show');
            } else {
                scrollBtn.removeClass('show');
            }
        });
    });
</script>

</body>
</html>
