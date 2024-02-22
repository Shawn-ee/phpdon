<?php /*a:1:{s:57:"/www/wwwroot/love.9img.cn/app/agent/view/index/index.html";i:1698217634;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8>
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <meta name=viewport content="width=device-width,initial-scale=1">
    <title>代理管理端</title>
    <link href='<?php echo htmlentities($appcss); ?>' rel=stylesheet>
</head>
<body>
<div id=app></div>
<script>
    var lbConfig = {
        jsPath: '<?php echo htmlentities($jsPath); ?>',
        isWe7: '<?php echo htmlentities($isWe7); ?>',
        is_founder: '<?php echo htmlentities($is_founder); ?>'
    }
    window.lbConfig = lbConfig;
</script>
<script type=text/javascript src='<?php echo htmlentities($manifest); ?>'></script>
<script type=text/javascript src='<?php echo htmlentities($vendor); ?>'></script>
<script type=text/javascript src='<?php echo htmlentities($app); ?>'></script>
</body>
</html>