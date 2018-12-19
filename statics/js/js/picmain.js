$(document).ready(function(){ 
  if($("#imgs").width() > 1000 ){ 
    $("#imgs").attr("width", 1000); 
  } 
  if($(".about_cen").find("img")){ 
    $(".about_cen").find("img").each(function(index, element){ 
      if($(this).width() > 1000){ 
        $(this).attr("width", 1000); 
      } 
    }); 
  } 
}); 