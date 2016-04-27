<!DOCTYPE html/>
<html>
<head>
    <link href="/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>


<div id="play_sequence_title_section"> </div>
<p>
    <img id="image_here" src="img/test.jpg" />
</p>

<script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    var aSequenceContents = <?=json_encode($data)?>;
    
</script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/play_sequence.js"></script>
</body>
</html>
