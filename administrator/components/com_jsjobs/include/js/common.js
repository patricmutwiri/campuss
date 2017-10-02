function getDataForDepandantField(parentf, childf, type) {
    if (type == 1) {
        var val = jQuery("select#" + parentf).val();
    } else if (type == 2) {
        var val = jQuery("input[name=" + parentf + "]:checked").val();
    }
    var link = "index.php?option=com_jsjobs&c=fieldordering&task=datafordepandantfield";
    jQuery.post(link, {fvalue: val, child: childf}, function (data) {
        if (data) {
            console.log(data);
            var d = jQuery.parseJSON(data);
            jQuery("select#" + childf).replaceWith(d);
        }
    });
}

function deleteCutomUploadedFile(field , isrequired) {
    var message = Joomla.JText._('Are you sure ?');
    var field_1 = field+"_1";
    var result = confirm(message);
    if(result){
        jQuery("input#"+field_1).val(1);
        jQuery("span."+field_1).hide();
        if(isrequired == 1){
            jQuery("input#"+field).addClass('required');
        }        
    }
}
