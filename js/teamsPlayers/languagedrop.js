var expanded = "xd";

function showCheckboxes() {
    var languages = document.getElementById("languages");
    if (expanded==false) {
        //languages.style.display = "none";
        $("#languages").slideToggle(150,'linear');
        expanded = true;
    } else if(expanded==true){
        //languages.style.display = "block";   
        $("#languages").slideToggle(150,'linear');
        expanded = false;
    }else if(expanded=="xd"){
        languages.style.display = "none";
        expanded = false;
    }
}
var expanded2 = "xd";
function showCheckboxes2() {
    var languages = document.getElementById("languages2");
    
    if (expanded2==false) {
        //languages.style.display = "none";
        $("#languages2").slideToggle(150,'linear');
        expanded2 = true;
    } else if(expanded2==true){
        //languages.style.display = "block";   
        $("#languages2").slideToggle(150,'linear');
        expanded2 = false;
    }else if(expanded2=="xd"){
        languages.style.display = "none";
        expanded2 = false;
    }  
}
var expanded3 = "xd";
function showCheckboxes3() {
    var languages = document.getElementById("languages3");
    
    if (expanded3==false) {
        //languages.style.display = "none";
        $("#languages3").slideToggle(150,'linear');
        expanded3 = true;
    } else if(expanded3==true){
        //languages.style.display = "block";   
        $("#languages3").slideToggle(150,'linear');
        expanded3 = false;
    }else if(expanded3=="xd"){
        languages.style.display = "none";
        expanded3 = false;
    }  
}
var expanded4 = "xd";
function showCheckboxes4() {
    var languages = document.getElementById("languages4");
    
    if (expanded4 ==false) {
        //languages.style.display = "none";
        $("#languages4").slideToggle(150,'linear');
        expanded4  = true;
    } else if(expanded4 ==true){
        //languages.style.display = "block";   
        $("#languages4").slideToggle(150,'linear');
        expanded4  = false;
    }else if(expanded4 =="xd"){
        languages.style.display = "none";
        expanded4  = false;
    }  
}

var rankDrop1=false;
jQuery().ready(function () {
    /* Custom select design */
    jQuery('.drop-down').append('<div class="button"></div>');
    jQuery('.drop-down').append('<ul class="select-list"></ul>');
    jQuery('.drop-down select option').each(function () {
        var bg = jQuery(this).css('background-image');
        jQuery('.select-list').append('<li class="clsAnchor"><span value="' + jQuery(this).val() + '" class="' + jQuery(this).attr('class') + '" style=background-image:' + bg + '>' + jQuery(this).text() + '</span></li>');
    });
    //jQuery('.drop-down .button').html('<span style=background-image:' + jQuery('.drop-down select').find(':selected').css('background-image') + '>' + jQuery('.drop-down select').find(':selected').text() + '</span>' + '<a href="javascript:void(0);" class="select-list-link">Arrow</a>');
    jQuery('.drop-down .button').html('<a href="javascript:void(0);" class="select-list-link">' +jQuery('.drop-down select').find(':selected').text()+ '<img src="images/arrow.png" class="arrow"style="float:right;"></a>');
    jQuery('.drop-down ul li').each(function () {
        if (jQuery(this).find('span').text() == jQuery('.drop-down select').find(':selected').text()) {
            jQuery(this).addClass('active');
        }
    });
    
    jQuery('.drop-down .select-list span').on('click', function () {
        
        var dd_text = jQuery(this).text();
        var dd_img = jQuery(this).css('background-image');
        var dd_val = jQuery(this).attr('value');
        jQuery('.drop-down .button').html('<a href="javascript:void(0);" class="select-list-link" >' +dd_text+ '<img src="images/arrow.png" class="arrow"style="float:right;"></a>');
        jQuery('.drop-down .select-list span').parent().removeClass('active');
        jQuery(this).parent().addClass('active');
        $('.drop-down select[name=options]').val(dd_val);
        $('.drop-down .select-list li').slideUp(150,'linear');
        rankDrop1=false;
    });
    jQuery('.drop-down .button').on('click', 'a.select-list-link', function () {
        if(rankDrop1==false){rankDrop1=true}else{rankDrop1=false}
        jQuery('.drop-down ul li').slideToggle(150,'linear');
    });
    /* End */
});
var rankDrop2=false;
jQuery().ready(function () {
    /* Custom select design */
    jQuery('.drop-down2').append('<div class="button"></div>');
    jQuery('.drop-down2').append('<ul class="select-list2"></ul>');
    jQuery('.drop-down2 select option').each(function () {
        var bg2 = jQuery(this).css('background-image');
        jQuery('.select-list2').append('<li class="clsAnchor"><span value="' + jQuery(this).val() + '" class="' + jQuery(this).attr('class') + '" style=background-image:' + bg2 + '>' + jQuery(this).text() + '</span></li>');
    });
    
    
    jQuery('.drop-down2 .button').html('<a href="javascript:void(0);" class="select-list-link">' +jQuery('.drop-down2 select').find(':selected').text()+ '<img src="images/arrow.png" class="arrow"style="float:right;"></a>');
    jQuery('.drop-down2 ul li').each(function () {
        if (jQuery(this).find('span').text() == jQuery('.drop-down2 select').find(':selected').text()) {
            jQuery(this).addClass('active');
        }
    });
    jQuery('.drop-down2 .select-list2 span').on('click', function () {
        var dd_text2 = jQuery(this).text();
        var dd_img2 = jQuery(this).css('background-image');
        var dd_val2 = jQuery(this).attr('value');
        jQuery('.drop-down2 .button').html('<a href="javascript:void(0);" class="select-list-link">' + dd_text2 + '<img src="images/arrow.png" class="arrow"style="float:right;"></a>');
        jQuery('.drop-down2 .select-list2 span').parent().removeClass('active');
        jQuery(this).parent().addClass('active');
        $('.drop-down2 select[name=options2]').val(dd_val2);
        rankDrop2=false;
        $('.drop-down2 .select-list2 li').slideUp(150,'linear');
    });
    jQuery('.drop-down2 .button').on('click', 'a.select-list-link', function () {
        if(rankDrop2==false){rankDrop2=true}else{rankDrop2=false}
        jQuery('.drop-down2 ul li').slideToggle(150,'linear');
    });
    /* End */
});
var rankDrop3=false;
jQuery().ready(function () {
    /* Custom select design */
    jQuery('.drop-down3').append('<div class="button"></div>');
    jQuery('.drop-down3').append('<ul class="select-list3"></ul>');
    jQuery('.drop-down3 select option').each(function () {
        var bg3 = jQuery(this).css('background-image');
        jQuery('.select-list3').append('<li class="clsAnchor"><span value="' + jQuery(this).val() + '" class="' + jQuery(this).attr('class') + '" style=background-image:' + bg3 + '>' + jQuery(this).text() + '</span></li>');
    });
    if(typeoffile=="players"){
        jQuery('.drop-down3 .button').html('<a href="javascript:void(0);" class="select-list-link">' +jQuery('.drop-down3 select').find(':selected').text()+ '<img src="images/arrow.png" class="arrow"style="float:right;"></a>');
    }else{
        console.log("xdd");
        jQuery('.drop-down3 .button').html('<a href="javascript:void(0);" class="select-list-link">' +"Any"+ '<img src="images/arrow.png" class="arrow"style="float:right;"></a>');
    }
    
    jQuery('.drop-down3 ul li').each(function () {
        if (jQuery(this).find('span').text() == jQuery('.drop-down3 select').find(':selected').text()) {
            jQuery(this).addClass('active');
        }
    });
    jQuery('.drop-down3 .select-list3 span').on('click', function () {
        var dd_text3 = jQuery(this).text();
        var dd_img3 = jQuery(this).css('background-image');
        var dd_val3 = jQuery(this).attr('value');
        jQuery('.drop-down3 .button').html('<a href="javascript:void(0);" class="select-list-link">' + dd_text3 + '<img src="images/arrow.png" class="arrow"style="float:right;"></a>');
        jQuery('.drop-down3 .select-list3 span').parent().removeClass('active');
        jQuery(this).parent().addClass('active');
        $('.drop-down3 select[name=options3]').val(dd_val3);
        rankDrop3=false;
        jQuery('.drop-down3 ul li').slideToggle(150,'linear');
    });
    jQuery('.drop-down3 .button').on('click', 'a.select-list-link', function () {
        if(rankDrop3==false){rankDrop3=true}else{rankDrop3=false}
        jQuery('.drop-down3 ul li').slideToggle(150,'linear');
    });
    /* End */
});


function klik(evt) {

    var target = $(evt.target);
    if (!target.parents('div#jezikDrop1').length) {
        if(expanded==true){
            $("#languages").slideToggle(150,'linear');
            expanded=false;
        }
    }
    if (!target.parents('div#jezikDrop2').length) {
        if(expanded2==true){
            $("#languages2").slideToggle(150,'linear');
            expanded2=false;
        }
    }
    if (!target.parents('div#jezikDrop3').length) {
        if(expanded3==true){
            $("#languages3").slideToggle(150,'linear');
            expanded3=false;
        }
    }
    if (!target.parents('div#jezikDrop4').length) {
        if(expanded4==true){
            $("#languages4").slideToggle(150,'linear');
            expanded4=false;
        }
    }
    if (!target.parents('div#rankDrop1').length) {
        if(rankDrop1==true){
            jQuery('.drop-down ul li').slideToggle(150,'linear');
            rankDrop1=false;
        }
    }
    if (!target.parents('div#rankDrop2').length) {
        if(rankDrop2==true){
            jQuery('.drop-down2 ul li').slideToggle(150,'linear');
            rankDrop2=false;
        }
    }
    if (!target.parents('div#rankDrop3').length) {
        if(rankDrop3==true){
            jQuery('.drop-down3 ul li').slideToggle(150,'linear');
            rankDrop3=false;
        }
    }
}


$(document).bind('click', klik);