<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Main</title>
<link rel="stylesheet" type="text/css" href="../style/admin.css"/>
</head>
<body id="main">
<div class="map">
	管理首页&gt;&gt;后台首页
</div>

<table cellspacing="0">
	<tr><th><strong>快捷操作</strong></th></tr>
	<tr><td><input type="button" onclick="javascript:location.href='main.php?action=delcache'" value="清理缓存">(缓存目录<strong><?php echo $this->_vars['cacheNum']?></strong>个文件)</td></tr>
</table>
</body>
</html>
