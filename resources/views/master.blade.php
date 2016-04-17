<!DOCTYPE html>
<html class="no-js" x-ng-app="kandidata">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>@{{ title }}</title>

    <meta name="description" content="A data-driven webapp for Twitter metrics for the Philippines Election 2016 presidential candidates.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">

    <!-- Plugin Stylesheets -->
    <link rel="stylesheet" href="assets/lib/bootstrap/dist/css/bootstrap.min.css">

    <!-- Project Stylesheets -->
    <link rel="stylesheet" href="assets/css/addon.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <!-- Plugin Scripts -->
    <script src="assets/lib/jquery/dist/jquery.min.js"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/lib/angular/angular.min.js"></script>
    <script src="assets/lib/angular-ui-router/release/angular-ui-router.min.js"></script>
    <script src="assets/lib/angular-animate/angular-animate.min.js"></script>
    <script src="assets/lib/angular-moment/angular-moment.min.js"></script>
    <script src="assets/lib/moment/min/moment.min.js"></script>
    <script src="assets/lib/amcharts/dist/amcharts/amcharts.js"></script>
    <script src="assets/lib/oclazyload/dist/ocLazyLoad.min.js"></script>

    <!-- Project Scripts -->
    <script src="assets/js/app.js"></script>

</head>
<body>

<header class="header" x-ng-include="'tpl/sections/header.html'"></header>

<div class="main-wrapper" ui-view> </div>

<footer class="footer" x-ng-include="'tpl/sections/footer.html'"></footer>

</body>
</html>
