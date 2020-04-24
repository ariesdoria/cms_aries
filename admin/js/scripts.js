tinymce.init({ selector:'textarea' });
$(document).ready(function(){
  $('#selectAllBoxes').click(function(event){
    if(this.checked){
      $('.checkBoxes').each(function(){
        this.checked = true;
      });
    }else{
      $('.checkBoxes').each(function(){
        this.checked = false;
      });
    }
  });
    //screen loader, jQuery
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $('body').prepend(div_box);
    $('#load-screen').delay(1000).fadeOut(600, function(){
        $(this).remove();
    });
});

function loadOnlineUsers(){
    $.get("functions.php?onlineusers=result", function(data){
        $(".usersonline").text(data);
    });
    
}
setInterval(function(){
    loadOnlineUsers();
},500);

