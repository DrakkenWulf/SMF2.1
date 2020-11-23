<html>
<body>
<?php 
$list = get_loaded_extensions();
sort($list);
echo implode(", ", $list); ?><br>
<br>
<?php echo in_array('gd', get_loaded_extensions()); ?><br>
</body>
</html>
