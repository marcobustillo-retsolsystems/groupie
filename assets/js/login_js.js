// Just a help to change the background-image
var changeImage = function(id, image){
  $(id).css('background-image', 'url('+image+')');
};

//Auto change Background Image over time
$(window).on('load',function() {
    var images = ['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIzyK3nZLL68iryuUhSI2MRZODdOT7aOPTHmjF0fZC2zEqJzwxrg', 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRHpklb8PSkFar61LdKR9NyK6ZBb0xoyHu8rS805DDg1uzkNbJftQ', 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSdN4w5m25xhv3OcUhTNDxDBbbQa2xqEcjvcHUeb8OsQ8on2Zph'];
    // Your pretty counter
    var i = 0;
    
    // Init sequence, loading the first image
    $("#wrapper_bottom").css("opacity", 0);
    changeImage('#wrapper_bottom', images[i]);
    changeBackground();
    
    // Your function
    // TODO: you should declare this outside of this scope
    function changeBackground() {
      $('#wrapper_bottom')
        .animate({"opacity": 1}, 2000, function(){
          changeImage('#wrapper_top', images[i], 1);
          if (++i >= images.length) { i = 0; } 
          $("#wrapper_bottom").css("opacity", 0);
          changeImage('#wrapper_bottom', images[i]);
      });
    }
  
    setInterval(changeBackground, 3000);
});