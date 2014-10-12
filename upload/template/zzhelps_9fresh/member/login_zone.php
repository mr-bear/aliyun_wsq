<?php echo '你不能看此模板的内容';exit;?>
<!--{if CURMODULE != 'logging'}-->
	<script type="text/javascript" src="{$_G[setting][jspath]}logging.js?{VERHASH}"></script>
	<form method="post" autocomplete="off" id="lsform" action="member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes" onsubmit="return lsSubmit()">
	<div>
		<span id="return_ls" style="display:none"></span>
		<div>
			<table width="268" height="270" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="40" colspan="3" align="left" valign="top"><span style="color:#006699; font-size:17px; font-family:Microsoft Yahei;">登陆我的个人空间</span></td>
                  </tr>
                  <tr>
                    <td width="78" height="36" align="center" valign="middle" style="color:#333333; font-size:14px;">账　　号：
                    <script type="text/javascript">simulateSelect('ls_fastloginfield')</script></td>
                    <td colspan="2" align="left" valign="middle"><input style="width:175px; height:20px; padding-top:4px; border:1px solid #e2e2e2;" type="text" name="username" id="ls_username" autocomplete="off" class="px vm" tabindex="901" /></td>
                  </tr>
                  <tr>
                    <td height="36" align="center" valign="middle" style="color:#333333; font-size:14px;">密　　码：</td>
                    <td colspan="2" align="left" valign="middle"><input type="password" name="password" id="ls_password" class="px vm" autocomplete="off" tabindex="902" style="width:175px; height:20px; padding-top:4px; border:1px solid #e2e2e2;" /></td>
                  </tr>
                  <tr>
                    <td height="30" align="center" valign="middle">&nbsp;</td>
                  <td width="120" align="left" valign="middle" style="color:#333333"><label for="ls_cookietime"><input type="checkbox" name="cookietime" id="ls_cookietime" class="pc" value="2592000" tabindex="903" />
                      下次自动登录</label> </td>
                    <td width="70" align="left" valign="middle"><a href="member.php?mod=logging&action=login&viewlostpw=1" target="_blank" style="color:#0657b2;">忘记密码？</a></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle"><button type="submit" tabindex="904" style="width:82px; height:34px; background:url(static/image/zone/login.gif) no-repeat; border:none; cursor:pointer;"><em></em></button></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" valign="middle">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle">还没有个人空间？<a href="member.php?mod={$_G[setting][regname]}" style="color:#0657b2;" target="_blank">立即开通</a></td>
                  </tr>
                  <tr>
                    <td height="40" colspan="3" align="left" valign="middle" style="border-top:1px solid #e2e2e2;"><!--{hook/global_login_extra}--></td>
                  </tr>
          </table>
				<input type="hidden" name="quickforward" value="yes" />
				<input type="hidden" name="handlekey" value="ls" />
		</div>
	</div>
	</form>
<!--{/if}-->
