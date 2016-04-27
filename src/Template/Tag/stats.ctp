<html>
<head>
    <link href="/css/style.css" rel="stylesheet" type="text/css"/>

</head>
<body>
<h1>Top tags</h1>

<a href='/tag/generate_sequence/rand'>Random</a><br/>
<? foreach ($top_tags as $item):?>
    <input type="checkbox" attr-tag-id="<?=$item['tag_id']?>"/> <?=$item['cnt']?> -
    <a href="/tag/generate_sequence/<?=$item['tag_id']?>"><?=$item['name']?></a><br />
<? endforeach;?>

<input type='button' value='Send' onClick='submitCheckboxes();'/>


<script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/show_stats.js"></script>
</body>
</html>
