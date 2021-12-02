$(document).ready(function() {
	var select = document.getElementById('selection');
	var text = select.options[select.selectedIndex].text;
	console.log(text);
	
    $("#selection").change(function(){
        $.ajax({
            type: 'POST',
			url: "minhasoja.php",
            data:  {selection:selection}
        });
    });
});