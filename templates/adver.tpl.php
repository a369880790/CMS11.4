<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Main</title>
<link rel="stylesheet" type="text/css" href="../style/admin.css"/>
<script type="text/javascript" src="../js/admin_adver.js"></script>
</head>
<body id="main">
<div class="map">
	管理首页&gt;&gt;内容管理&gt;&gt;<strong id="title">{$title}</strong>
</div>
<ol>
	<li><a href="adver.php?action=show" class="selected">广告列表</a></li>
	<li><a href="adver.php?action=add">新增广告</a></li>
	{if $update}
	<li><a href="adver.php?action=update&id={$id}">更新广告信息</a></li>
	{/if}

</ol>
{if $show}
<table cellspacing="0">
	<tr><th>广告编号</th><th>广告标题</th><th>广告链接</th><th>广告类型</th><th>是否显示</th><th>操作</th></tr>
	{if $AllAdver}
	{foreach $AllAdver(key,value)}
	<tr>
	<td><script type="text/javascript">document.write({@key+1}
	+
	{$num});</script> </td>
	<td>{@value->title}</td>
	<td><a herf="{@value->linkall}" 
	title="{@value->linkall}" 
	>{@value->link}</a></td>
	<td><a href="adver.php?action=show&kind={@value->tp}"
	>{@value->type}</a></td>
	<td>{@value->state}
	{iff @value->ok}
	(<a href="adver.php?action=state&type=notok&id={@value->id}">取消</a>)
	{else}
	(<a href="adver.php?action=state&type=ok&id={@value->id}">显示</a>)
	{/iff}
	</td>
	<td><a href=" adver.php?action=update&id={@value->id}">修改</a>|
	<a href=" adver.php?action=delete&id={@value->id}" onclick="return confirm('吾日三省吾身,你真的要删除么?')?true:false">删除</a></td>
	</tr>
	{/foreach}
	<tr><td colspan="6" style="color:blue;">(*操作广告后必须生成js文件才能同步前台)
	<input style="cursor: pointer;" type="button" value="生成文字广告js" onclick="javascript:location.href='?action=text'">
	<input type="button" value="生成头部广告js" style="cursor: pointer;" onclick="javascript:location.href='?action=header'">
	<input type="button" value="生成侧栏广告js" style="cursor: pointer;" onclick="javascript:location.href='?action=sidebar'">
	</td></tr>
	{else}
	<tr><td colspan="6">没有任何数据,请添加数据</td></tr>
	{/if}
</table>
<form method="get">
<input type="hidden" name="action" value="show">
<div id=page>{$page}
<select name="kind" style="border:1px solid #ccc; width:120px;">
	<option value="0">默认全部</option>
	<option value="1" {$select1}>文字广告</option>
	<option value="2" {$select2}>头部广告690x80</option>
	<option value="3" {$select3}>侧栏广告270x200</option>
</select>
<input type="submit" style="cursor: pointer;" value="查询">
</div>
</form>
{/if}
{if $add}
<form method="post" name="content" action="?action=add">
<input type="hidden" name="change" value="1">
	<table cellspacing="0" class="left">
		<tr><td>广告类型:<input type="radio" name="type" value="1" onclick="adver(1);" checked="checked">文字广告
		<input type="radio" onclick="adver(2);" name="type" value="2">头部广告(690x80)
		<input type="radio" onclick="adver(3);"  name="type" value="3">侧栏广告(270x200)</td></tr>
		<tr><td>广告标题:<input type="text" name="title" class="text"> (*2~20)</td></tr>
		<tr><td>广告链接:<input type="text" name="link" class="text"> </td></tr>
		<tr id="thumbnail" style="display: none;"><td>广告图片 :<input type="text" name="thumbnail" class="text" readonly="readonly">
					<span id="up"></span>
					<img name="pic"  style="display:none;">(请选择200KB以下的jpg,png,gif图片)</td></tr>
		<tr><td>广告信息:<textarea name="info"></textarea> </td></tr>
		<tr><td><input type="submit" name="send" value="新增广告" onclick="return checkAdver();" class="submit">[<a href="{$prev_url}">返回列表</a>]</td></tr>
	</table>
</form>
{/if}
{if $update}
<form method="post" name="content" action="?action=update">
<input type="hidden" name="change" value="1">
<input type="hidden" name="id" value="{$id}">
	<table cellspacing="0" class="left">
		<tr><td>广告类型:<input type="radio" name="type" value="1" onclick="adver(1);" {$type1}>文字广告
		<input type="radio" onclick="adver(2);" name="type" value="2" {$type2}>头部广告(690x80)
		<input type="radio" onclick="adver(3);"  name="type" value="3" {$type3}>侧栏广告(270x200)</td></tr>
		<tr><td>广告标题:<input type="text" name="title" value="{$titlec}" class="text"> (*2~20)</td></tr>
		<tr><td>广告链接:<input type="text" name="link" value="{$link}" class="text"> </td></tr>
		<tr id="thumbnail" {$pic}>
					<td>广告图片 :<input type="text" name="thumbnail" value="{$thumbnail}" class="text" readonly="readonly">
					<span id="up">{$up}</span>
					<img name="pic" src="{$thumbnail}" {$pic}">(请选择200KB以下的jpg,png,gif图片)</td></tr>
		<tr><td>广告信息:<textarea name="info">{$info}</textarea> </td></tr>
		<tr><td><input type="submit" name="send" value="更新广告信息" onclick="return checkAdver();" class="submit">[<a href="{$prev_url}">返回列表</a>]</td></tr>
	</table>
</form>
{/if}
</body>
</html>
