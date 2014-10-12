<?php echo '你不能看此模板的内容';exit;?>
<!--{if CURMODULE != 'logging'}-->
	
	<form method="post" autocomplete="off" id="lsform" action="member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes" onsubmit="{if $_G['setting']['pwdsafety']}pwmd5('ls_password');{/if}return lsSubmit();">
	<div class="fastlg cl">
		<span id="return_ls" style="display:none"></span>
        <div id="user_bar">
        	<div class="z" onmouseover="showMenu({'ctrlid':'forgotpw','pos':'34!','duration':2});" id="forgotpw">
                     <div class="passw sipt_field">
                      <label class="z">{lang account}</label>
                      <input type="text" tabindex="901" onblur="if(this.value == ''){this.value = 'UID/用户名/Email';this.className = 'px vm xg1';}" onfocus="if(this.value == 'UID/用户名/Email'){this.value = '';this.className = 'px vm xg1';}" value="UID/用户名/Email" class="px vm xg1" id="ls_username" name="username">
                      </div>
                      <div class="passw sipt_field no0">
                    <label class="z">{lang password}</label>
                    <input type="password" tabindex="902" autocomplete="off" class="px vm" id="ls_password" name="password">
                    </div>
            </div>
            <button tabindex="904" class="pn pn vm" type="submit"><em>{lang login}</em></button>
            <div id="regelink_login" class="pn vm"><em><a href="member.php?mod={$_G[setting][regname]}">$_G['setting']['reglinkname']</a></em></div>
			<input type="hidden" name="quickforward" value="yes" />
			<input type="hidden" name="handlekey" value="ls" />
        </div>
 
            <div class="log_reg">
                  <a title="使用QQ帐号登录" onmouseover="showMenu({'ctrlid':'weibo','pos':'34!','ctrlclass':'a','duration':2});" rel="nofollow" target="_top" id="weibo" href="connect.php?mod=login&op=init&referer=index.php&statfrom=login_simple"><img src="$_G['style']['styleimgdir']/qq_n.png" alt="QQ帐号登录">QQ帐号登录</a>
            </div>
	</div>
    
<!--{if !IS_ROBOT}-->

            <div id="forgotpw_menu" class="p_pop {if !$_G['uid']}blk{/if}" style="display: none;">
            <div class="rfms">
                    <label class="z" for="ls_cookietime"><input type="checkbox" tabindex="903" value="2592000" class="pc" id="ls_cookietime" name="cookietime">自动登录</label>
                    &nbsp;&nbsp;<a onclick="showWindow('login', 'member.php?mod=logging&amp;action=login&amp;viewlostpw=1')" class="xi2" href="javascript:;"><strong>找回密码</strong></a>
            </div>
            </div>
  <!--{/if}-->  
    
	</form>

	<!--{if $_G['setting']['pwdsafety']}-->
		<script type="text/javascript" src="{$_G['setting']['jspath']}md5.js?{VERHASH}" reload="1"></script>
	<!--{/if}-->

<!--{/if}-->
