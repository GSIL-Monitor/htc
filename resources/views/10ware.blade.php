<!DOCTYPE html>
<html>
    <head>
    <title>10ware</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans|Montserrat:700' rel='stylesheet' type='text/css'>
    <style>
        html, body {
            overflow: hidden;
            margin: 0;
        }
        body {
            font-family: 'Open Sans', 'Helvetica Neue', 'Hiragino Sans GB', 'LiHei Pro', Arial, sans-serif;
            color: #333;
        }
        #wrapper {
            position: absolute;
            left: 0;
            width: 360px;
            text-align: center;
            top: 50%;
            left: 50%;
            margin-left: -160px;
            margin-top: -160px;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        h1 {
            font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
            font-weight: 700;
            font-size: 30px;
            letter-spacing: 9px;
            text-transform: uppercase;
            margin: 12px 0;
            left: 4px;
        }
        h2 {
            color: #999;
            font-weight: normal;
            font-size: 15px;
            letter-spacing: .12em;
            margin-bottom: 5px;
            left: 3px;
        }
        h1, h2 {
            position: relative;
        }
        p {
            color: #999;
            font-size: 14px;
            line-height: 2em;
            margin: 0;
            letter-spacing: 2px;
        }
        canvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        a {
            color: #999;
            text-decoration: none;
            transition: color .2s ease;
        }
        a:hover {
            color: #f33;
        }
    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-52301626-1"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-52301626-1');
    </script>

    </head>
    <body>
        <div id="wrapper">
        <h1>@10ware</h1>
        <h2>天威尔科技股份有限公司</h2>

        <!--<h2>深圳市宝安区玉律路华美居商务中心</h2>
        <h2>D区1号楼622室</h2>-->
        <h2>深圳市宝安区玉律路华美居D区1号楼622室</h2>

        <!--
        <p><a href="https://github.com/z-song" target="_blank">Github</a></p>
        <p><a href="http://laravel-admin.org" target="_blank">Laravel-admin</a></p>
        <p><a href="https://implode.io" target="_blank">Implode.io</a></p>
        -->
        </div>
        <canvas></canvas>
        <script src="https://cdn.bootcss.com/canvas-nest.js/1.0.1/canvas-nest.min.js" opacity=1></script>
    </body>
</html>