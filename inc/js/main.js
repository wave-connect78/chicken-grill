$(function(){
    let productList = new Array();
    let productListFiltered = new Array();
    let resto = '';
    $(window).on('load',function(){
        $.post('https://chicken-grill.fr/inc/controls.php',{postType:'search'},function(res){
              if(res.resultat && res.resto){
                  productList = res.resultat;
                  resto = res.resto;
              }
        },'json');
        //console.log(productList);
    });
    $('.fa-search').on('click',function(){
        if ($('.search-content').hasClass('activeSearch')) {
            //console.log('test0');
            $('.search-content').removeClass('activeSearch');
            $('.search-content').addClass('searchRemoved');
            setTimeout(function(){ $('.search-content').css({display:'none'}); }, 500);
        } else {
            $('.search-content').addClass('activeSearch');
            $('.search-content').css({display:'flex'});
            $('.search-content').removeClass('searchRemoved');
            //console.log('test1');
        }
    });
    $('header .menu, header .burger-icon').on('click',function(){
        if ($('.navi-content').hasClass('activeNav')) {
            //console.log('test0');
            $('.navi-content').hide(300);
            $('.navi-content').removeClass('activeNav');
        } else {
            $('.navi-content').show(300);
            $('.navi-content').addClass('activeNav');
            //console.log('test1');
        }
    });
    $('.search-content #search').on('input',function(){
        $('.search-bloc .filter ul li').remove();
        productListFiltered = [];
        productList.filter(function(el) {
            if(el.product_name.toLowerCase().includes($('.search-content #search').val().toLowerCase())){
                productListFiltered.push({product_name:el.product_name,product_id:el.product_id});
                $('.search-bloc .filter').css({display:'block'});
                $('.search-bloc .filter ul').prepend('<li><a href="/'+resto+'/product-detail/?access='+el.product_id+'">'+el.product_name+'</a></li>');
                //document.querySelector('.search-bloc .filter').scrollIntoView();
            }
        });
        
    });
    $('.search-content .startsearch').on('click',function(){
        $('.search-bloc .filter ul li').remove();
        if(productListFiltered.length == 0){
            $('.search-bloc .filter').css({display:'none'});
            alert('Aucun produit ne correspond à votre recherche');
        }else{
           for(var el in productListFiltered){
                $('.search-bloc .filter ul').prepend('<li><a href="/'+resto+'/product-detail/?access='+productListFiltered[el].product_id+'">'+productListFiltered[el].product_name+'</a></li>');
            }
            document.querySelector('.search-bloc .filter').scrollIntoView();
        }
    });
    $('.search-content #search').on('keyup',function(){
        if($('.search-content #search').val().length == 0){
            $('.search-bloc .filter').css({display:'none'});
        }
    });
    if($('body .cover').length){
        $('.cover .cookie form').on('submit',function(e){
           e.preventDefault();
           setCookie("chickengrill", 'resto', 365);
           document.location.reload();
        });
    }
    
    $('footer .fa-arrow-alt-circle-up').on('click',function(){
        topFunction();
    });

	var img1 = document.querySelector(".home-img1");
	var img2 = document.querySelector(".home-img2");
	var img3 = document.querySelector(".home-img3");
	var hometext = document.querySelector(".home .text");
	
	
   
    $(window).on('load',function(){
         if($('body .home').length){
            var imgwidth = ((window.innerWidth/2) - img1.offsetWidth);
    	   
            const fact1 = imgwidth/$('.home-img1').height();
        	const fact2 = imgwidth/$('.home-img2').height();
        	const fact3 = imgwidth/$('.home-img3').height();
            $('footer .fa-arrow-alt-circle-up').css({color:'#593207'});
        
            if(window.innerWidth <= 865){
	           // img1.style['object-fit'] = 'initial';
	           // img2.style['object-fit'] = 'initial';
	           // img3.style['object-fit'] = 'initial';
	           img1.style['transform'] = 'translateX('+0+'px)';
	           img3.style['transform'] = 'translateX('+0+'px)';
	           img2.style['transform'] = 'translateX('+0+'px)';
	        }else{
	            var rest = $('.home-img1').position().top - window.scrollY;
     		    var width = fact1*rest;
     		    
     		    if(width >= 0 && width <= imgwidth){
                    img1.style['transform'] = 'translateX('+width+'px)';
                    img1.style['opacity'] = 1;
                }else if(width < 0){
                    img1.style['transform'] = 'translateX('+0+'px)';
                    img1.style['opacity'] = 1;
                }else{
                    img1.style['transform'] = 'translateX('+imgwidth+'px)';
                    img1.style['opacity'] = 0.2;
                }
                
            
            
                var rest = $('.home-img3').position().top - window.scrollY;
     		    var width = fact3*rest;
     		    if(width >= 0 && width <= imgwidth){
                    img3.style['transform'] = 'translateX('+width+'px)';
                    img3.style['opacity'] = 1;
                }else if(width < 0){
                    img3.style['transform'] = 'translateX('+0+'px)';
                    img3.style['opacity'] = 1;
                }else{
                    img3.style['transform'] = 'translateX('+imgwidth+'px)';
                    img3.style['opacity'] = 0.2;
                }
            
           
                var rest = $('.home-img2').position().top - window.scrollY;
     		    var width = fact2*rest;
     		    if(width >= 0 && width <= imgwidth){
                    img2.style['transform'] = 'translateX('+(-width)+'px)';
                    img2.style['opacity'] = 1;
                }else if(width < 0){
                    img2.style['transform'] = 'translateX('+0+'px)';
                }else{
                   img2.style['transform'] = 'translateX('+(-imgwidth)+'px)'; 
                   img2.style['opacity'] = 0.2;
                }
	        }
         }
    });
    
    function setCookie(c_name, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = encodeURIComponent(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
        document.cookie = c_name + "=" + c_value+";path=/";
    }
    
    var lastScrollTop = 0, delta = 5;
	$(window).scroll(function(e){
	    if($('body .home').length){
	        var imgwidth = ((window.innerWidth/2) - img1.offsetWidth);
    	     var canSroll = true;
    	     if(window.innerWidth <= 865){
    	         canSroll = false;
    	       //  img1.style['object-fit'] = 'initial';
    	       //  img2.style['object-fit'] = 'initial';
    	       //  img3.style['object-fit'] = 'initial';
    	     }
             const fact1 = imgwidth/$('.home-img1').height();
        	 const fact2 = imgwidth/$('.home-img2').height();
        	 const fact3 = imgwidth/$('.home-img3').height();
    		 var nowScrollTop = $(this).scrollTop();
    		 
    		 
    		 if(Math.abs(lastScrollTop - nowScrollTop) >= delta){
    		   
    		 	if (nowScrollTop > lastScrollTop){
    		 		if(isInViewport(img1) && canSroll){
    		 		    var rest = $('.home-img1').position().top - nowScrollTop;
    		 		    var width = fact1*rest;
    		 		    
    		 		    if(width >= 0 && width <= imgwidth){
                            img1.style['transform'] = 'translateX('+width+'px)';
                            img1.style['opacity'] = 1;
                        }else if(width < 0){
                            img1.style['transform'] = 'translateX('+0+'px)';
                            img1.style['opacity'] = 1;
                        }
                        
                    }
                    if(isInViewport(img3) && canSroll){
                        var rest = $('.home-img3').position().top - nowScrollTop;
    		 		    var width = fact3*rest;
    		 		    if(width >= 0 && width <= imgwidth){
                            img3.style['transform'] = 'translateX('+width+'px)';
                            img3.style['opacity'] = 1;
                        }else if(width < 0){
                            img3.style['transform'] = 'translateX('+0+'px)';
                            img3.style['opacity'] = 1;
                        }
                    }
                    if(isInViewport(img2) && canSroll){
                        var rest = $('.home-img2').position().top - nowScrollTop;
    		 		    var width = fact2*rest;
    		 		    if(width >= 0 && width <= imgwidth){
                            img2.style['transform'] = 'translateX('+(-width)+'px)';
                            img2.style['opacity'] = 1;
                        }else if(width < 0){
                            img2.style['transform'] = 'translateX('+0+'px)';
                            img2.style['opacity'] = 1;
                        }
                    }
    		 	} else {
    		 		if(isInViewport(img1) && canSroll){
    		 		    var rest = $('.home-img1').position().top - nowScrollTop;
    	 		        var width = fact1*rest;
    	 		        if(width >= 0 && width <= imgwidth){
                            img1.style['transform'] = 'translateX('+width+'px)';
                            img1.style['opacity'] = 1;
                        }else if(width > imgwidth){
                            img1.style['transform'] = 'translateX('+imgwidth+'px)';
                            img1.style['opacity'] = 0.2;
                        }
                    }
                    if(isInViewport(img3) && canSroll){
                        var rest = $('.home-img3').position().top - nowScrollTop;
    	 		        var width = fact3*rest;
    	 		        if(width >= 0 && width <= imgwidth){
                            img3.style['transform'] = 'translateX('+width+'px)';
                            img3.style['opacity'] = 1;
                        }else if(width > imgwidth){
                            img3.style['transform'] = 'translateX('+imgwidth+'px)';
                            img3.style['opacity'] = 0.2;
                        }
                    }
                    if(isInViewport(img2) && canSroll){
    	 		        var rest = $('.home-img2').position().top - nowScrollTop;
    	 		        var width = fact2*rest;
    	 		        if(width >= 0 && width <= imgwidth){
                            img2.style['transform'] = 'translateX('+(-width)+'px)';
                            img2.style['opacity'] = 1;
                        }else if(width > imgwidth){
                            img2.style['transform'] = 'translateX('+(-imgwidth)+'px)';
                            img2.style['opacity'] = 0.2;
                        }
                    }
    			}
    			if(isInViewport(hometext)){
    			    hometext.style['transform'] = 'translateX('+0+'%)';
    			}
    		    lastScrollTop = nowScrollTop;
    		 }   
	    }
	 });
     
    $('.navi-content nav a').filter(function(){
        if (/Edg/.test(navigator.userAgent) || navigator.userAgent.indexOf("Opera")) {
          if(this.href+'/'==location.href){
              $(this).addClass('activelink').siblings().removeClass('activelink');
          }
        }else{
            if('https://chicken-grill.fr'+$(this).attr('href')+'/'==location.href){
                $(this).addClass('activelink').siblings().removeClass('activelink');
            }
        }
    })
        
    if($('.suggestion .card-content .card').length){
        $('.suggestion .card-content .card').each((index)=>{
            if(index >= 3){
                $('.suggestion .card-content').css({'justify-content':'center'});
            }
        });
    } 
    if($('.profil .offer .offer-content').length){
        $('.profil .offer .offer-content .card').each((index)=>{
            if(index >= 3){
                $('.profil .offer .offer-content').css({'justify-content':'center'});
            }
        });
    }
     if($('.product-list').length){
         setTimeout(function(){
             $('.product-list .menu-content .card').each((index)=>{
                if(index >= 3){
                    $('.product-list .menu-content').css({'justify-content':'center'});
                }
            });
            $('.product-list .menu-simple-content .card').each((index)=>{
                if(index >= 3){
                    $('.product-list .menu-simple-content').css({'justify-content':'center'});
                }
                console.log(index);
            });
            $('.product-list .menu-double-content .card').each((index)=>{
                if(index >= 3){
                    $('.product-list .menu-double-content').css({'justify-content':'center'});
                }
            });
            $('.product-list .single-product-content .card').each((index)=>{
                if(index >= 3){
                    $('.product-list .single-product-content').css({'justify-content':'center'});
                }
            });
            $('.product-list .boisson-content .card').each((index)=>{
                if(index >= 3){
                    $('.product-list .boisson-content').css({'justify-content':'center'});
                }
            });
         },15000);
     }
     if($('.profil-navigation').length){
        $('.profil-navigation .adresse').on('click',function(){
            document.querySelector('.delivrary-adresse').scrollIntoView();
        });
        $('.profil-navigation .commande').on('click',function(){
            document.querySelector('.relise-order').scrollIntoView();
        });
        $('.profil-navigation .livraison').on('click',function(){
            document.querySelector('.delivrary-order').scrollIntoView();
        });
        $('.profil-navigation .offre').on('click',function(){
            document.querySelector('.offer-content').scrollIntoView();
        });
        $('.profil-navigation .paramettre').on('click',function(){
            document.querySelector('.setting').scrollIntoView();
        });
     }
     $('.switch input').on('click',function(){
         if($(this).is(':checked')){
             
             if(window.confirm('Êtes vous certains de vouloir de vouloir mettre la boutique en mode on?')){
                  $.post('https://chicken-grill.fr/inc/controls.php',{postType:'switch',state:'on'},function(res){
                      if(res.error){
                          alert(res.error);
                      }else if(res.errorpage){
                          window.location = res.errorpage;
                      }else{
                          $('.switch input').addClass('on');
                          $('.switch .slider').addClass('on');
                          $('.switch input').removeClass('off');
                          $('.switch .slider').removeClass('off');
                      }
                  },'json');
             }else{
                 console.log('annuler');
             }
             
         }else{
             if(window.confirm('Êtes vous certains de vouloir de vouloir mettre la boutique en mode off?')){
                 $.post('https://chicken-grill.fr/inc/controls.php',{postType:'switch',state:'off'},function(res){
                      if(res.error){
                          alert(res.error);
                      }else if(res.errorpage){
                           window.location = res.errorpage;
                      }else{
                          $('.switch input').addClass('off');
                          $('.switch .slider').addClass('off');
                          $('.switch input').removeClass('on');
                          $('.switch .slider').removeClass('on');
                      }
                  },'json');
             }else{
                 console.log('annuler');
             }
         }
     });
});
function isInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (rect.top < window.innerHeight && rect.bottom >= 0);
}
function checkVisible(el) {
    const rect = el.getBoundingClientRect();
    return (rect.top < window.innerHeight && rect.bottom >= 0
        // rect.top >= 0 &&
        // rect.left >= 0 &&
        // rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        // rect.right <= (window.innerWidth || document.documentElement.clientWidth)

    );
}
function onLoad() {
    gapi.load('auth2', function() {
        gapi.auth2.init();
    });
}
let mybutton = document.querySelector("footer .fa-arrow-alt-circle-up");

window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
function exportTableToExcel(filename) {
    var tableId = ".gestion-client table";
    let dataType = 'application/vnd.ms-excel';
    let extension = '.xls';

    let base64 = function(s) {
        return window.btoa(unescape(encodeURIComponent(s)))
    };

    let template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
    let render = function(template, content) {
        return template.replace(/{(\w+)}/g, function(m, p) { return content[p]; });
    };

    let tableElement = document.querySelector(tableId);

    let tableExcel = render(template, {
        worksheet: filename,
        table: tableElement.innerHTML
    });

    filename = filename + extension;

    if (navigator.msSaveOrOpenBlob)
    {
        let blob = new Blob(
            [ '\ufeff', tableExcel ],
            { type: dataType }
        );

        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        let downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        downloadLink.href = 'data:' + dataType + ';base64,' + base64(tableExcel);

        downloadLink.download = filename;

        downloadLink.click();
    }
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll(".gestion-client table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}