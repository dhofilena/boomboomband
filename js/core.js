   /**************************/
   /*      Ajax function     */
   /*                        */
   /**************************/
   function doAjaxCall(url,data,showLoading,callback){
       if (showLoading){
           $('.loadingDiv').show();
       }
             $.ajax({
             url: url,
             type: "POST",
             data: data,
             cache: false,
			 
             success: function(html){
             callback(html);
             if (showLoading){
             $('.loadingDiv').hide();
                }
           }
           
        });
      } 
	  
	    /*Example of calling Ajax*/
	//doAjaxCall(url,'',true,function(html){});
 
