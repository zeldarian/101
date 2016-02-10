<?php
	   $get_key=get_option('hs_fresh_activation_key');
	   if($get_key=='')
	   {
	   add_action('admin_menu', 'hs_activation_admin_menu'); 
			function hs_activation_admin_menu() 
			 {
			add_menu_page('FreshStart-Activation','WP-FreshStart','manage_options', 'FreshStart-Plugin-Setting', 'FreshStart_panel','',6); 
			 }
        }
		else
	   {
	  add_action('admin_menu','hs_occ_admin_menu');
			function hs_occ_admin_menu() 
			{
			add_menu_page('FreshStart Settings', 'WP-FreshStart', 'manage_options', 'hs-one-click-creation', 'hs_occ_admin','',6 ); 
			}
	   }
	   	function hs_occ_admin() 
	  {
	 	require('hs_settings.php');
       }
function FreshStart_panel()
{	
?>
<style type="text/css">
#container { 
width: 75%;
padding-top: 20px;
padding-left: 20px;
padding-right: 10px;
font-size: 13px;
font-family: Arial;
line-height: 2;
border-right: 2px dashed grey;
float: left;
}
.box {
float: left;
width: 100%;
margin-bottom: 22px;
}
.wf-inputpos {
float: left;
}
.hs_sb_vals
{
width: 135px !important;
margin-left: 23px!important;
}
.hs_sb_input1
{margin-left: 64px;
width: 231px;}
.hs_wf_input{
margin-left: 64px;
width: 231px;
}
.hs_info {
width: 55%;
margin-top: 12px;
font-size: 13px;
line-height: 2em;
color: black;
}
.wf-contbox a {
text-decoration: none;
margin-right: 10px;
}
.wf-button {
margin-left: 24px;
background-color: #21759b;
background-image: -webkit-gradient(linear,left top,left bottom,from(#2a95c5),to(#21759b));
background-image: -webkit-linear-gradient(top,#2a95c5,#21759b);
background-image: -moz-linear-gradient(top,#2a95c5,#21759b);
background-image: -ms-linear-gradient(top,#2a95c5,#21759b);
background-image: -o-linear-gradient(top,#2a95c5,#21759b);
background-image: linear-gradient(to bottom,#2a95c5,#21759b);
border-color: #21759b;
border-bottom-color: #1e6a8d;
-webkit-box-shadow: inset 0 1px 0 rgba(120,200,230,0.5);
box-shadow: inset 0 1px 0 rgba(120,200,230,0.5);
color: #fff;
text-decoration: none;
text-shadow: 0 1px 0 rgba(0,0,0,0.1);
width: 133px;
}
.hs_activtn_section {
float: left;
width: 100%;
}
.wf-labelpos h2 {
margin: 0px!important;
font-weight: normal;
color: grey;
}
.wf-labelpos p {
margin: 0px!important;
margin-bottom: 21px!important;
font-size: 16px;
}
</style>
<script>
jQuery(document).ready(function($){
$('#hs_sb_vals').click(function(e){
e.preventDefault();
$('#hs_notice_info').css('display','block');
});
});
</script>
<div id='container'>

			<div id='header'>
				<a href='http://wpfreshstart.com'><img src="<?php echo HB_SU_PATH ?>images/header.png"></a>
			</div>
<div id="WFItem4123904" class="wf-formTpl">
    <form accept-charset="utf-8" action="https://app.getresponse.com/add_contact_webform.html?u=B7wA" method="post" id="hs_activatn_form">
	       <div class="wf-box">
           <div id="WFIcenter" class="wf-body">
                <ul class="wf-sortable" id="wf-sort-id">
                  <li class="wf-name" rel="temporary" style="display:  none !important;">
                        <div class="wf-contbox">
                            <div class="wf-labelpos">
                                <label class="wf-label">Name:</label>
                            </div>
                            <div class="wf-inputpos">
                                <input class="wf-input" type="text" name="name"></input>
                            </div>
                            <em class="clearfix clearer"></em>
                        </div>
                    </li>
                    <li class="wf-email" rel="undefined" style="display:  block !important;">
                        <div class="wf-contbox">
                            <div class="wf-labelpos">
                                <h2>STEP 1: Get Your Activation Key</h2>
								<p>Enter your best email address here so we can send you an activation key.</p>
								  <div class="wf-inputpos">
                                <input class="wf-input wf-req wf-valid__email hs_wf_input" type="text" name="email"></input>
                            </div><p id="hs_notice_info" style="position: absolute;
margin-top: 29px!important;
margin-left: 253px!important;
color: green;
font-size: 13px;
font-weight: bold;
display: none;">Sending Activation Code, please check your email..</p>
                            </div>
                          
                            <em class="clearfix clearer"></em>
                        </div>
                    </li>
                    <li class="wf-submit" rel="undefined" style="display:  block !important;">
                        <div class="wf-contbox">
                            <div class="wf-inputpos">
                                <input  type="submit" class="wf-button button-primary hs_sb_vals" name="submit" id="hs_sb_vals" value="Get Activation Code"
                                ></input>
                            </div>
                            <em class="clearfix clearer"></em>
                        </div>
                    </li>
                   <li class="wf-counter" rel="undefined" style="display:  none !important;">
                        <div class="wf-contbox">
                            <div>
                                <span style="padding: 4px 6px 8px 24px; background: url(https://app.getresponse.com/images/core/webforms/countertemplates.png) 0% 0px no-repeat;"
                                class="wf-counterbox">
                                    <span class="wf-counterboxbg" style="padding: 4px 12px 8px 5px; background: url(https://app.getresponse.com/images/core/webforms/countertemplates.png) 100% -36px no-repeat;">
                                        <span class="wf-counterbox0" style="padding: 5px 0px;">subscribed:</span>
                                        <span style="padding: 5px;" name="https://app.getresponse.com/display_subscribers_count.js?campaign_name=freshv2_activation&var=0"
                                        class="wf-counterbox1 wf-counterq">0</span>
                                        <span style="padding: 5px 0px;" class="wf-counterbox2"></span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </li>
                    <li class="wf-captcha" rel="undefined" style="display:  none !important;">
                        <div class="wf-contbox wf-captcha-1" id="wf-captcha-1" wf-captchaword="Enter the words above:"
                        wf-captchasound="Enter the numbers you hear:" wf-captchaerror="Incorrect please try again"></div>
                    </li>
                    <li class="wf-privacy" rel="undefined" style="display:  block !important;">
                        <div class="wf-contbox" style="margin-left: 33px!important;
float: left;
text-decoration: none;">
                           <!-- <div>
                                <a class="wf-privacy wf-privacyico" href="http://www.getresponse.com/permission-seal?lang=en"
                                target="_blank" style="height: 15px !important; display: inline !important;">We respect your privacy<em class="clearfix clearer"></em></a>
                            </div>-->
                            <em class="clearfix clearer"></em>
                        </div>
                    </li>
                    <li class="wf-poweredby" rel="undefined" style="display:  block !important;">
                        <div class="wf-contbox" style="margin-left: 33px!important;
float: left;
text-decoration: none;">
                            <div>
                             <!--   <span class="wf-poweredby wf-poweredbyico">
                                    <a class="wf-poweredbylink wf-poweredby" href="http://www.getresponse.com/"
                                    style="display:  inline !important;" target="_blank">Email Marketing</a>by GetResponse</span>-->
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="WFIfooter" class="wf-footer el" style="height: 25px; display:  none !important;">
                <div class="actTinyMceElBodyContent"></div>
                <em class="clearfix clearer"></em>
            </div>
        </div>
      <input type="hidden" name="webform_id" value="4123904" />
    </form>
	</div>

<script type="text/javascript" src="http://app.getresponse.com/view_webform.js?wid=4123904&mg_param1=1&u=B7wA"></script>

	<div class="hs_activtn_section">
	<form action="" method="post">	      
		  <div class="wf-labelpos">
		   <h2>STEP 2: Enter Activation Key</h2>
								<p>Your activation key received in your email should be entered here.</p>
           <input  class="hs_activation_key hs_sb_input1" type="text" name="activation_key" required></input>
           <input type="submit" name="hs_submit_activation" class="hs_sb_vals button-primary " value="Activate">
			</div>
	</form>
	</div>
</div></div>
	<?php
	if(isset($_POST['hs_submit_activation']))
	{
	   if($_POST['activation_key']=='FRSHV29821') 
	   {
	   update_option('hs_fresh_activation_key','FRSHV29821');
	    ?>
	   <script> window.location="<?php echo home_url().'/wp-admin/admin.php?page=hs-one-click-creation&hs_activation=success'; ?>"</script>
		 <?php
	   }
	   else
	   {
	   echo "<p style='float: left;
margin-top: 26px;
margin-left: 5px;
color: red;
font-size: 17px;'>Sorry Your Activation Key is Incorrect.!!</p>";
	   }
	   
	}
	}
	