<style>
#container { 
	width:902px;step 1
	padding-top:20px;
	padding-left:10px;
	padding-right:10px;
	font-size:13px;
	font-family: Arial;
	line-height:2;
	border-right: 2px dashed grey;
	float:left;
}
.hs_fresh_start {
margin-bottom: 22px;
}
.hs_fresh_start h2 {
margin-bottom: 0px;
}
.hs_fresh_start p {
font-size: 14px;
color: black;
text-align: justify;
margin-top: 0px;
}
.hs_select_task {
margin-left: 171px;
float: left;
}
.hs_select_task input[type="checkbox"] {
float: left;
width: 24px;
}
.hs_select_task span {
float: left;
width: 95%;
margin: -6px 0px 8px 0px;
}
.hs_loading_img
{
margin-left: 115px;
display: none;
position: absolute;
margin-top: -21px;
}
.hs_done
{
display:none;
position: absolute;
margin-top: -27px;
margin-left: 263px;
color: green;
font-weight: bold;
}
.hs_final_cleanup {
}
.hs-save-button {
float: left;
margin-left: 173px;
}
.hs_new_section {
float: left;
margin-top: 10px;
}
h3.hs_contentsection {
cursor: pointer;
font-weight: 600;
color: #222;
font-size: 1.3em;
}
/**********/
.wpfrsh_txtbox
{
margin-left: 32px;
width: 250px;
}
.wpfrshstrt_hidesection{display:none;}
</style>
<script type='text/javascript'>
jQuery(function($){ 
    /***********************************/
	$('.wpfresh_parentdiv').click(function(){
	    if($(this).attr('checked'))
		{
		    $(this).next().next().next().show();
		}
		else
		{
		    $(this).next().next().next().hide();
		}
	});
    /***********************************/
	$('.hs_final_cleanup').click(function(){
	     $('#hs_done1').css('display','none');  
	     $('#hs_done2').css('display','none');  
	     $('#hs_done3').css('display','none');  
	     $('#hs_done4').css('display','none');  
	     $('#hs_done5').css('display','none');  
	     $('#hs_done6').css('display','none');  
	     $('#hs_done7').css('display','none');  
	     $('#hs_done11').css('display','none');  
	     $('#hs_done_f1').css('display','none');  
	     $('#hs_done_f2').css('display','none');  
	     $('#hs_done_f3').css('display','none');  
	     $('#hs_done12').css('display','none');  
	     $('#hs_done13').css('display','none');  
	     $('#hs_done14').css('display','none');  
		$(this).next().show();
		/**************post****************/
		var data={};
		var hsdltallpost=$('#hs_post').attr('checked');
		if(hsdltallpost=='checked')
		    {
						 data.hs_post=hsdltallpost;
						 data.action="hs_post_action";
						  jQuery.post(ajaxurl,data,function(response){
						  if(response=='done1')
						  {
							 $('#hs_done1').slideUp( 300 ).fadeIn( 200 );
					//		 $('#hs_post').attr('checked',false);
						  }	 
						 });
			}			 
		/***************page******************/
		var hs_all_page=$('#hs_all_page').attr('checked');
		if(hs_all_page=='checked')
		    {
			    data.hs_all_page=hs_all_page;
				 data.action="hs_all_page_action";
				  jQuery.post(ajaxurl,data,function(response){
				  if(response=='done2')
								  {
					$('#hs_done2').slideUp( 300 ).delay( 200 ).fadeIn( 400 );
				//	$('#hs_all_page').attr('checked',false);
					}
				 });
		   }
		/******************************************/
		var hs_all_comment=$('#hs_all_comment').attr('checked');
		if(hs_all_comment=='checked')
		    {
				data.hs_all_comment=hs_all_comment;
				data.action="hs_all_comment_action";
				jQuery.post(ajaxurl,data,function(response){
				if(response=='done3')
				{
				$('#hs_done3').slideUp( 300 ).delay( 300 ).fadeIn( 200 );
				//$('#hs_all_comment').attr('checked',false);
				}
				});
			}			 
		/*************/
		var hs_create_about=$('#hs_create_about').attr('checked');
		if(hs_create_about=='checked')
		    {
				 data.hs_create_about=hs_create_about;
				 data.create_field1=$('#field1').val();
				 data.create_field2=$('#field2').val();
				 data.action="hs_create_abpages_action";
				  jQuery.post(ajaxurl,data,function(response){
				   if(response=='done4')
								  {
					$('#hs_done4').slideUp( 300 ).delay( 400 ).fadeIn( 200 );
					//$('#hs_create_about').attr('checked',false);
					}
				 });
		   }
		/*************/
		var hs_create_privacy=$('#hs_create_privacy').attr('checked');
		if(hs_create_privacy=='checked')
		    {
				 data.hs_create_privacy=hs_create_privacy;
				data.action="hs_create_prpages_action";
				  jQuery.post(ajaxurl,data,function(response){
				  if(response=='done5')
					{
					$('#hs_done5').slideUp( 300 ).delay( 400 ).fadeIn( 200 );
					//$('#hs_create_privacy').attr('checked',false);
					}
				 });
		    }
		/*************/
		var hs_create_earnings=$('#hs_create_earnings').attr('checked');
		if(hs_create_earnings=='checked')
		    {
					 data.hs_create_earnings=hs_create_earnings;
					data.action="hs_create_erpages_action";
					  jQuery.post(ajaxurl,data,function(response){
					  if(response=='done6')
									  {
						$('#hs_done6').slideUp( 300 ).delay( 400 ).fadeIn( 200 );
					//	$('#hs_create_earnings').attr('checked',false);
						}
					 });
		    }
		/*************/
		var hs_create_contactus=$('#hs_create_contactus').attr('checked');
		if(hs_create_contactus=='checked')
		    {
					 data.hs_create_contactus=hs_create_contactus;
					data.action="hs_create_cupages_action";
					  jQuery.post(ajaxurl,data,function(response){
					  if(response=='done7')
									  {
						$('#hs_done7').slideUp( 300 ).delay( 400 ).fadeIn( 200 );
					//	$('#hs_create_contactus').attr('checked',false);
						}
					 });
		    }
		/*************/
		var hs_create_termsofuse=$('#hs_create_termsofuse').attr('checked');
		if(hs_create_termsofuse=='checked')
		    {
				data.hs_create_termsofuse=hs_create_termsofuse;
				data.action="hs_create_terms_action";
				  jQuery.post(ajaxurl,data,function(response){
				  if(response=='done11')
								  {
					$('#hs_done11').slideUp( 300 ).delay( 400 ).fadeIn( 200 );
					//$('#hs_create_termsofuse').attr('checked',false);
					}
				 });
		    }
		/*******************************/
							 if($('#hs_set_newalert').attr('checked'))
							 {
								 data.hs_set_newalert=0;
							  }	 
							else
							{
								 data.hs_set_newalert=1;
							} 
							if($('#hs_set_moderatealert').attr('checked'))
							{
								 data.hs_set_moderatealert=0;
							}	 
							else
							{
								 data.hs_set_moderatealert=1;
							}
							if($('#hs_set_permalinks').attr('checked'))
							{
								 data.hs_set_permalinks=1;
							} 
							else
							{
								 data.hs_set_permalinks=0;
							}
							 /***************************************/
							 data.action="hs_action_cleanup";
							 jQuery.post(ajaxurl,data,function(response){

							 if(response=='done8'|| response=='done8done9'|| response=='done8done10' || response=='done8done9done10')
							 {
							 $('#hs_done_f1').slideUp( 300 ).delay(200).fadeIn( 200 );
							
							 }
							 if(response=='done9'|| response=='done8done9'||response=='done9done10' || response=='done8done9done10')
							 {
							 $('#hs_done_f2').slideUp( 300 ).delay(500 ).fadeIn( 200 );
							 }
							 if(response=='done10'|| response=='done8done10'|| response=='done9done10' || response=='done8done9done10')
							 {
							 $('#hs_done_f3').slideUp( 300 ).delay(1000).fadeIn( 200 );
							 }
							   $('.hs_loading_img').css('display','none');
							}); 
		/*****************category section*****************/
		var cat=jQuery('#cat').val();
		var catcheck=$('#wpfresh_categories').attr('checked');
		if(catcheck=='checked')
		{ 
			jQuery.post(ajaxurl,{action:"s4catadd","catcheck":catcheck, "cat":cat, 'cookie':encodeURIComponent(document.cookie)},
				function(response)
				{
				jQuery('#cat').val('');
                  $('#wpfresh_categories').attr('checked',false);
				 if(response=='done12')
						  {
					 $('#hs_done12').slideUp( 300 ).delay(400).fadeIn( 200 );	  
					}
				}
			);
		}	
       /**************create-page***************/		
	   var page=jQuery('#fresh_page_name').val();
	   var pagecheck=$('#wpfresh_pages').attr('checked');
	   if(pagecheck=='checked')
		{
		jQuery.post(ajaxurl,{action:"s4pageadd", "page":page,"pagecheck":pagecheck, 'cookie':encodeURIComponent(document.cookie)},
				function(response)
				{
				 jQuery('#fresh_page_name').val('');
	             jQuery('#wpfresh_pages').attr('checked',false);
				 if(response=='done13')
						  {
					 $('#hs_done13').slideUp( 300 ).delay(400).fadeIn( 200 );	  
					} 
				}
			);
		}	
	   /**************install-plugin*****************/
	   var url=jQuery('#s2_url').val(); 
	    var wpfresh_installplugin=$('#wpfresh_installplugin').attr('checked');
		if(wpfresh_installplugin=='checked')
		{
		jQuery.post(ajaxurl, {action:"hs_s2installurl","s2_url":url,"wpfresh_installplugin":wpfresh_installplugin,"cookie":encodeURIComponent(document.cookie)},
			function (response) {
				jQuery('#s2_url').val('');
				$('#wpfresh_installplugin').attr('checked',false);	
				if(response=='done14')
						  {
					 $('#hs_done14').slideUp( 300 ).delay(400).fadeIn( 200 );	  
				}
		});
		}
	   /*******************************/
	    var wpfresh_mediaupload=$('#wpfresh_mediaupload').attr('checked');
		if(wpfresh_mediaupload=='checked')
		{ 
		    setTimeout(function(){
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
			jQuery('#wpfresh_mediaupload').attr('checked',false);
			},15000);
		} 
		/*******************************/
	});	
	/***********************************/		
});
</script>
<div id='container'>
			<div id='header'>
				<a href='http://wpfreshstart.com'><img src="<?php echo HB_SU_PATH ?>images/header.png"></a>
			</div>
                        <div class="hs_fresh_start"> 
						       <h2>Welcome to WP-FreshStart v2.0 </h2>
                               <p>This awesome plugin lets to clear out all the default values from a new wordpress site or even give your old wordpress site a freshstart. <br/>Just select from the options below and hit start - the plugin will take care of the rest.</p>
                        </div> 
        <div class="hs_select_task">   
              <input type="checkbox" name="hs_post" id="hs_post"/><span>Delete All Posts <p class="hs_done" id="hs_done1">Done</p></span>
			  <input type="checkbox" name="hs_all_page" id="hs_all_page"/><span>Delete All Pages <p class="hs_done" id="hs_done2">Done</p></span>
			  <input type="checkbox" name="hs_all_comment" id="hs_all_comment"/><span>Delete All
			  Comments <p class="hs_done" id="hs_done3">Done</p></span>
			  <input class="wpfresh_parentdiv" type="checkbox" name="hs_create_about" id="hs_create_about"/><span>Create About Page <p class="hs_done hs_done_p" id="hs_done4">Done</p></span>
			  <br/>
			  <div class="wpfrshstrt_hidesection">
					&nbsp;&nbsp;&nbsp;&nbsp;This Site is about: <input type='text' id='field1' style="margin-left: 20px;" class="wpfrsh_txtbox" placeholder="Eg. Dog Training"/><br/>
					&nbsp;&nbsp;&nbsp;&nbsp;Also covers topics like: <input type='text' class="wpfrsh_txtbox" id='field2' placeholder="Eg. Dog Barking, Health and Treatment for Dogs"/>
				</div><br/>
			  <input type="checkbox" name="hs_create_privacy" id="hs_create_privacy"/><span>Create Privacy Policy Page <p class="hs_done hs_done_p" id="hs_done5">Done</p></span>
			  <input type="checkbox" name="hs_create_termsofuse" id="hs_create_termsofuse"/><span>Create Terms of Use Page <p class="hs_done hs_done_p" id="hs_done11">Done</p></span>
			  <input type="checkbox" name="hs_create_earnings" id="hs_create_earnings"/><span>Create Earnings Disclaimer Page <p class="hs_done hs_done_p" id="hs_done6">Done</p></span>
			  <input type="checkbox" name="hs_create_contactus" id="hs_create_contactus"/><span>Create Contact Us Page <p class="hs_done hs_done_p" id="hs_done7">Done</p></span>
			  
			  
			  
			  <input type="checkbox" <?php checked(get_option('permalink_structure'),'/%postname%/');?> name="hs_set_permalinks" id="hs_set_permalinks"/><span>Set Permalinks to /post-name/ for better SEO <p class="hs_done hs_done_f" id="hs_done_f1">Done</p></span>
			  <input type="checkbox" <?php checked(get_option('comments_notify'),0);?> name="hs_set_newalert" id="hs_set_newalert"/><span>Stop new comment notifications via email<p class="hs_done hs_done_f" id="hs_done_f2">Done</p></span>
			   <input type="checkbox" <?php checked(get_option('moderation_notify'),0);?> name="hs_set_moderatealert" id="hs_set_moderatealert"/><span>Stop moderate comment notifications via email <p class="hs_done hs_done_f" id="hs_done_f3">Done</p></span> 
			  <!-----------categtory-------------------> 
			 <input class="wpfresh_parentdiv" type="checkbox" name="wpfresh_categories" id="wpfresh_categories"><span>Create Multiple Categories quickly <p class="hs_done hs_done_p" id="hs_done12">Done</p></span><br/> 
			 <div class="wpfrshstrt_hidesection">
			Enter multiple category names separated by comma (,) <input type="text" id='cat' class="wpfrsh_txtbox" value="" placeholder="Eg. Products, Services, Testimonials">
		     </div> <br/>
			<!-----------blank pages------------------->
			<input class="wpfresh_parentdiv" type="checkbox" name="wpfresh_pages" id="wpfresh_pages"/>
			<span>Create New Blank Pages<p class="hs_done hs_done_p" id="hs_done13">Done</p></span><br/>
			<div class="wpfrshstrt_hidesection">
			Enter multiple page names separated by comma (,) <input type="text" id="fresh_page_name" class="wpfrsh_txtbox" value="" placeholder="Eg. Careers, Marketing"/>
			</div></br>	
            <!----plugin create section----> 
			<input type="checkbox" name="wpfresh_installplugin" id="wpfresh_installplugin">
			<span>Install Multiple Plugins at once<p class="hs_done hs_done_p" id="hs_done14">Done</p></span><br/>
			<div class="">
			<textarea rows="4" cols="50" name="s2_url" id="s2_url" placeholder="Enter Wordpress.org URLs or Zip file URLs here separated by comma"></textarea><div class="wpfrsh_greencolor" id="wpfrsg_Successmsg3"></div>
			
			</div><br>
			<!--upload image-->
			<!--<input type="checkbox" name="wpfresh_mediaupload" id="wpfresh_mediaupload"> 
			<span style="width: 30%;">upload multiple images at once<p class="hs_done hs_done_p" id="hs_done15">Done</p></span><br/>
			-->
		</div> 
		<div class="hs-save-button">
        <input type="button" class="button-primary hs_final_cleanup" name="hs_start_cleanup" value="Start"/>
        <img src="<?php echo HB_SU_PATH ?>images/lod_new.gif" class="hs_loading_img"/>
		</div>
	<!--upload image-->
	<div id='header'><br/>
					<a href='http://wpfreshstart.com'><img src="<?php echo HB_SU_PATH ?>images/footer.png"></a>
<br/>
			<p><small>By clicking the Start button above, I agree to the terms and conditions set forth in the <a href="http://wpfreshstart.com/plugindisclaimer.html" target="_blank">disclaimer</a>.</small></p></div>
</div>	
