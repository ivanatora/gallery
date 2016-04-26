
function submitCheckboxes(){
    var aBoxes = $("input:checkbox:checked");
    var aTagIds = [];
    aBoxes.each(function(){
        aTagIds.push($(this).attr('c_id'));
    })

    window.location = "/generate_sequence.php?c_ids=" + aTagIds.join(",");
}

