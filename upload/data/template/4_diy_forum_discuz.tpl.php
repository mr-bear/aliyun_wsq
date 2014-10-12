<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('discuz');
block_get('3,4,5,6,7,8,9,10');?><?php include template('common/header'); ?><style id="diy_style" type="text/css">#portal_block_6 {  margin-top:20px !important;}</style>
<style type="text/css">
     body{ background: url("template/newry_travel/style/img/bbs_bg.jpg");background:repeat-x }
    .recommend{ width:350px; height:280px;background-position: 5px -565px; float:left; overflow:hidden}
    .recommend h2{ height:28px; line-height:36px; font-size:16px; color:#000; padding-left:55px;}
    .r_con{ width:360px; height:280px; padding:0px; overflow:hidden; position:relative}
</style>
<div id="ct" class="wp cl">
<div class="newry_bbs_top">
    <div class="wp">
        <div id="pt" class="bm cl">
<?php if(empty($gid) && $announcements) { ?>
<div class="y">
<div id="an">
<dl class="cl">
<dt class="z xw1">公告:&nbsp;</dt>
<dd>
<div id="anc"><ul id="ancl"><?php echo $announcements;?></ul></div>
</dd>
</dl>
</div>
<script type="text/javascript">announcement();</script>
</div>
<?php } ?>
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a><em>&raquo;</em><a href="forum.php"><?php echo $_G['setting']['navs']['2']['navname'];?></a><?php echo $navigation;?>
</div>
<div class="z"><?php if(!empty($_G['setting']['pluginhooks']['index_status_extra'])) echo $_G['setting']['pluginhooks']['index_status_extra'];?></div>
</div> 
        <div class="bbs_indtop fontYaHei">
            <p class="title">知游论坛</p>
            <p class="slogen">帮助大家,分享精彩旅游人生</p>
            <div class="slogen2">
                <em><?php echo $posts;?></em> 
                篇分享等你探索
            </div>
        </div>
    </div>
</div>
<div class="bbs_sldline2"></div>

        <?php if(empty($gid)) { ?>
        <?php echo adshow("text/wp a_t");?>        <?php } ?>
        <?php if(empty($gid)) { ?>
        
        <div class="wp">
            <!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
        </div>
        <?php } ?>

            <!--[diy=diy_chart]--><div id="diy_chart" class="area"></div><!--[/diy]-->
            <div class="lay_main">
            <div class="discuz_left">

                <!--首页四格开始-->
                <div class="bbs_indone clearfix">
                    <p class="titles fontYaHei">热门话题</p>
                    <div class="recommend">
                        <div class="r_con" id="r_con"> 
                            <!--[diy=page_con]--><div id="page_con" class="area"><div id="framemuL2QE" class="frame move-span cl frame-1"><div id="framemuL2QE_left" class="column frame-1-c"><div id="framemuL2QE_left_temp" class="move-span temp"></div><?php block_display('3');?></div></div></div><!--[/diy]--> 

                        </div>
                        <script type="text/javascript">jQuery("#r_con").slide({ titCell:".page ul",mainCell:"#page_con .list_con",effect:"leftLoop",vis:1,scroll:1,autoPlay:true,autoPage:true});</script> 
                    </div>
                    <div class="bbs_topstory">
                        <!--[diy=bbs_topstory]--><div id="bbs_topstory" class="area"><div id="framehYYIoo" class="frame move-span cl frame-1"><div id="framehYYIoo_left" class="column frame-1-c"><div id="framehYYIoo_left_temp" class="move-span temp"></div><?php block_display('4');?></div></div></div><!--[/diy]--> 
                    </div>
                </div>

                <!--首页四格结束-->
                <div class="bbs_sldline2"></div>

                <div class="bbs_maintit">
                    <h2 class="title fontYaHei">论坛版块</h2>
                    <p class="info"><?php echo $_G['cache']['userstats']['totalmembers'];?> 个会员 &nbsp;&nbsp;今日更新 <?php echo $todayposts;?> 篇贴子</p>
                </div>
                <div class="bbs_topnav_box">
                    <!--[diy=bbs_topnav]--><div id="bbs_topnav" class="area"><div id="frameOP8CC2" class="frame move-span cl frame-1"><div id="frameOP8CC2_left" class="column frame-1-c"><div id="frameOP8CC2_left_temp" class="move-span temp"></div><?php block_display('5');?></div></div></div><!--[/diy]--> 
                </div>


                <?php if(!empty($_G['setting']['pluginhooks']['index_top'])) echo $_G['setting']['pluginhooks']['index_top'];?>
                <?php if(!empty($_G['cache']['heats']['message'])) { ?>
                <div class="bm">
                    <div class="bm_h cl">
                        <h2><?php echo $_G['setting']['navs']['2']['navname'];?>热点</h2>
                    </div>
                    <div class="bm_c cl">
                        <div class="heat z">
                            <?php if(is_array($_G['cache']['heats']['message'])) foreach($_G['cache']['heats']['message'] as $data) { ?>                            <dl class="xld">
                                <dt><?php if($_G['adminid'] == 1) { ?><a class="d" href="forum.php?mod=misc&amp;action=removeindexheats&amp;tid=<?php echo $data['tid'];?>" onclick="return removeindexheats()">delete</a><?php } ?>
                                <a href="forum.php?mod=viewthread&amp;tid=<?php echo $data['tid'];?>" target="_blank" class="xi2"><?php echo $data['subject'];?></a></dt>
                                <dd><?php echo $data['message'];?></dd>
                            </dl>
                            <?php } ?>
                        </div>
                        <ul class="xl xl1 heatl">
                            <?php if(is_array($_G['cache']['heats']['subject'])) foreach($_G['cache']['heats']['subject'] as $data) { ?>                            <li><?php if($_G['adminid'] == 1) { ?><a class="d" href="forum.php?mod=misc&amp;action=removeindexheats&amp;tid=<?php echo $data['tid'];?>" onclick="return removeindexheats()">delete</a><?php } ?>&middot; <a href="forum.php?mod=viewthread&amp;tid=<?php echo $data['tid'];?>" target="_blank" class="xi2"><?php echo $data['subject'];?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($_G['setting']['pluginhooks']['index_catlist_top'])) echo $_G['setting']['pluginhooks']['index_catlist_top'];?>
                <div class="fl bm">
                    <?php if(!empty($collectiondata['follows'])) { ?>

                    <?php $forumscount = count($collectiondata['follows']);?>                    <?php $forumcolumns = 4;?>                    <?php $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';?>                    <div class="bm bmw <?php if($forumcolumns) { ?> flg<?php } ?> cl">
                        <div class="bm_h cl">
                            <span class="o">
                                <img id="category_-1_img" src="<?php echo IMGDIR;?>/<?php echo $collapse['collapseimg_-1'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_-1');" />
                            </span>
                            <h2><a href="forum.php?mod=collection&amp;op=my">我订阅的专辑</a></h2>
                        </div>
                        <div id="category_-1" class="bm_c" style="<?php echo $collapse['category_-1']; ?>">
                            <table cellspacing="0" cellpadding="0" class="fl_tb">
                                <tr>
                                    <?php $ctorderid = 0;?>                                    <?php if(is_array($collectiondata['follows'])) foreach($collectiondata['follows'] as $key => $colletion) { ?>                                    <?php if($ctorderid && ($ctorderid % $forumcolumns == 0)) { ?>
                                </tr>
                                <?php if($ctorderid < $forumscount) { ?>
                                <tr class="fl_row">
                                    <?php } ?>
                                    <?php } ?>
                                    <td class="fl_g"<?php if($forumcolwidth) { ?> width="<?php echo $forumcolwidth;?>"<?php } ?>>
                                        <div class="fl_icn_g">
                                            <a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>" target="_blank"><img src="<?php echo $_G['style']['styleimgdir'];?>/forum<?php if($followcollections[$key]['lastvisit'] < $colletion['lastupdate']) { ?>_new<?php } ?>.gif" alt="<?php echo $colletion['name'];?>" /></a>
                                        </div>
                                        <dl>
                                            <dt><a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>"><?php echo $colletion['name'];?></a></dt>
                                            <dd><em>主题: <?php echo dnumber($colletion['threadnum']); ?></em>, <em>评论: <?php echo dnumber($colletion['commentnum']); ?></em></dd>
                                            <dd>
                                                <?php if($colletion['lastpost']) { ?>
                                                <?php if($forumcolumns < 3) { ?>
                                                <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost" class="xi2"><?php echo cutstr($colletion['lastsubject'], 30); ?></a> <cite><?php echo dgmdate($colletion[lastposttime]);?> <?php if($colletion['lastposter']) { ?><?php echo $colletion['lastposter'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite>
                                                <?php } else { ?>
                                                <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo dgmdate($colletion[lastposttime]);?></a>
                                                <?php } ?>
                                                <?php } else { ?>
                                                从未
                                                <?php } ?>
                                            </dd>
                                            <?php if(!empty($_G['setting']['pluginhooks']['index_followcollection_extra'][$colletion[ctid]])) echo $_G['setting']['pluginhooks']['index_followcollection_extra'][$colletion[ctid]];?>
                                        </dl>
                                    </td>
                                    <?php $ctorderid++;?>                                    <?php } ?>
                                    <?php if(($columnspad = $ctorderid % $forumcolumns) > 0) { echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);; } ?>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <?php } ?>
                    <?php if(empty($gid) && !empty($forum_favlist)) { ?>
                    <?php $forumscount = count($forum_favlist);?>                    <?php $forumcolumns = $forumscount > 3 ? ($forumscount == 4 ? 4 : 5) : 1;?>                    <?php $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';?>                    <div class="bm bmw <?php if($forumcolumns) { ?> flg<?php } ?> cl">
                        <div class="bm_h cl">
                            <span class="o">
                                <img id="category_0_img" src="<?php echo IMGDIR;?>/<?php echo $collapse['collapseimg_0'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_0');" />
                            </span>
                            <h2><a href="home.php?mod=space&amp;do=favorite&amp;type=forum">我收藏的版块</a></h2>
                        </div>
                        <div id="category_0" style="<?php echo $collapse['category_0']; ?>">
                            <table cellspacing="0" cellpadding="0" class="fl_tb">
                                <tr>
                                    <?php $favorderid = 0;?>                                    <?php if(is_array($forum_favlist)) foreach($forum_favlist as $key => $favorite) { ?>                                    <?php if($favforumlist[$favorite['id']]) { ?>
                                    <?php $forum=$favforumlist[$favorite[id]];?>                                    <?php $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];?>                                    <?php if($forumcolumns>1) { ?>
                                    <?php if($favorderid && ($favorderid % $forumcolumns == 0)) { ?>
                                </tr>
                                <?php if($favorderid < $forumscount) { ?>
                                <tr class="fl_row">
                                    <?php } ?>
                                    <?php } ?>
                                    <td class="fl_g"<?php if($forumcolwidth) { ?> width="<?php echo $forumcolwidth;?>"<?php } ?>>
                                        <div class="fl_icn_g"<?php if(!empty($forum['extra']['iconwidth']) && !empty($forum['icon'])) { ?> style="width: <?php echo $forum['extra']['iconwidth'];?>px;"<?php } ?>>
                                         <?php if($forum['icon']) { ?>
                                         <?php echo $forum['icon'];?>
                                         <?php } else { ?>
                                         <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="<?php echo $_G['style']['styleimgdir'];?>/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a>
                                            <?php } ?>

                                        </div>
                                        <dl<?php if(!empty($forum['extra']['iconwidth']) && !empty($forum['icon'])) { ?> style="margin-left: <?php echo $forum['extra']['iconwidth'];?>px;"<?php } ?>>
                                            <dt><a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } if($forum['extra']['namecolor']) { ?> style="color: <?php echo $forum['extra']['namecolor'];?>;"<?php } ?>><?php echo $forum['name'];?></a><?php if($forum['todayposts'] && !$forum['redirect']) { ?><em class="xw0 xi1" title="今日"> (<?php echo $forum['todayposts'];?>)</em><?php } ?></dt>
                                            <?php if(empty($forum['redirect'])) { ?><dd><em>主题: <?php echo dnumber($forum['threads']); ?></em>, <em>帖数: <?php echo dnumber($forum['posts']); ?></em></dd><?php } ?>
                                            <dd>
                                                <?php if($forum['permission'] == 1) { ?>
                                                私密版块
                                                <?php } else { ?>
                                                <?php if($forum['redirect']) { ?>
                                                <a href="<?php echo $forumurl;?>" class="xi2">链接到外部地址</a>
                                                <?php } elseif(is_array($forum['lastpost'])) { ?>
                                                <?php if($forumcolumns < 3) { ?>
                                                <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost" class="xi2"><?php echo cutstr($forum['lastpost']['subject'], 30); ?></a> <cite><?php echo $forum['lastpost']['dateline'];?> <?php if($forum['lastpost']['author']) { ?><?php echo $forum['lastpost']['author'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite>
                                                <?php } else { ?>
                                                <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo $forum['lastpost']['dateline'];?></a>
                                                <?php } ?>
                                                <?php } else { ?>
                                                从未
                                                <?php } ?>
                                                <?php } ?>
                                            </dd>
                                            <?php if(!empty($_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]];?>
                                        </dl>
                                    </td>
                                    <?php $favorderid++;?>                                    <?php } else { ?>
                                    <td class="fl_icn" <?php if(!empty($forum['extra']['iconwidth']) && !empty($forum['icon'])) { ?> style="width: <?php echo $forum['extra']['iconwidth'];?>px;"<?php } ?>>
                                        <?php if($forum['icon']) { ?>
                                        <?php echo $forum['icon'];?>
                                        <?php } else { ?>
                                        <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="<?php echo $_G['style']['styleimgdir'];?>/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <h2><a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } if($forum['extra']['namecolor']) { ?> style="color: <?php echo $forum['extra']['namecolor'];?>;"<?php } ?>><?php echo $forum['name'];?></a><?php if($forum['todayposts'] && !$forum['redirect']) { ?><em class="xw0 xi1" title="今日"> (<?php echo $forum['todayposts'];?>)</em><?php } ?></h2>
                                        <?php if($forum['description']) { ?><p class="xg2"><?php echo $forum['description'];?></p><?php } ?>
                                        <?php if($forum['subforums']) { ?><p>子版块: <?php echo $forum['subforums'];?></p><?php } ?>
                                        <?php if($forum['moderators']) { ?><p>版主: <span class="xi2"><?php echo $forum['moderators'];?></span></p><?php } ?>
                                        <?php if(!empty($_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_favforum_extra'][$forum[fid]];?>
                                    </td>
                                    <td class="fl_i">
                                        <?php if(empty($forum['redirect'])) { ?><span class="xi2"><?php echo dnumber($forum['threads']); ?></span><span class="xg1"> / <?php echo dnumber($forum['posts']); ?></span><?php } ?>
                                    </td>
                                    <td class="fl_by">
                                        <div>
                                            <?php if($forum['permission'] == 1) { ?>
                                            私密版块
                                            <?php } else { ?>
                                            <?php if($forum['redirect']) { ?>
                                            <a href="<?php echo $forumurl;?>" class="xi2">链接到外部地址</a>
                                            <?php } elseif(is_array($forum['lastpost'])) { ?>
                                            <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost" class="xi2"><?php echo cutstr($forum['lastpost']['subject'], 30); ?></a> <cite><?php echo $forum['lastpost']['dateline'];?> <?php if($forum['lastpost']['author']) { ?><?php echo $forum['lastpost']['author'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite>
                                            <?php } else { ?>
                                            从未
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="fl_row">

                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php if(($columnspad = $favorderid % $forumcolumns) > 0) { echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);; } ?>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <?php echo adshow("intercat/bm a_c/-1");?>                    <?php } ?>
                    <?php if(is_array($catlist)) foreach($catlist as $key => $cat) { ?>                    <?php if(!empty($_G['setting']['pluginhooks']['index_catlist'][$cat[fid]])) echo $_G['setting']['pluginhooks']['index_catlist'][$cat[fid]];?>
                    <div class="bm bmw <?php if($cat['forumcolumns']) { ?> flg<?php } ?> cl">
                        <div class="bm_h cl">
                            <span class="o">
                                <img id="category_<?php echo $cat['fid'];?>_img" src="<?php echo IMGDIR;?>/<?php echo $cat['collapseimg'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_<?php echo $cat['fid'];?>');" />
                            </span>
                            <?php if($cat['moderators']) { ?><span class="y">分区版主: <?php echo $cat['moderators'];?></span><?php } ?>
                            <?php $caturl = !empty($cat['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$cat['domain'].'.'.$_G['setting']['domain']['root']['forum'] : '';?>                            <h2><a href="<?php if(!empty($caturl)) { ?><?php echo $caturl;?><?php } else { ?>forum.php?gid=<?php echo $cat['fid'];?><?php } ?>" style="<?php if($cat['extra']['namecolor']) { ?>color: <?php echo $cat['extra']['namecolor'];?>;<?php } ?>"><?php echo $cat['name'];?></a></h2>
                        </div>
                        <div id="category_<?php echo $cat['fid'];?>" style="<?php echo $collapse['category_'.$cat['fid']]; ?>">
                            <table cellspacing="0" cellpadding="0" class="fl_tb">
                                <tr>
                                    <?php if(is_array($cat['forums'])) foreach($cat['forums'] as $forumid) { ?>                                    <?php $forum=$forumlist[$forumid];?>                                    <?php $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];?>                                    <?php if($cat['forumcolumns']) { ?>
                                    <?php if($forum['orderid'] && ($forum['orderid'] % $cat['forumcolumns'] == 0)) { ?>
                                </tr>
                                <?php if($forum['orderid'] < $cat['forumscount']) { ?>
                                <tr class="fl_row">
                                    <?php } ?>
                                    <?php } ?>
                                    <!--三栏开始-->
                                    <td class="fl_g" width="<?php echo $cat['forumcolwidth'];?>">
                                        <div class="fl_icn_g"<?php if(!empty($forum['extra']['iconwidth']) && !empty($forum['icon'])) { ?> style="width: <?php echo $forum['extra']['iconwidth'];?>px;"<?php } ?>>
                                             <?php if($forum['icon']) { ?>
                                             <?php echo $forum['icon'];?>
                                             <?php } else { ?>
                                             <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="<?php echo $_G['style']['styleimgdir'];?>/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a>
                                            <?php } ?>
                                        </div>
                                        <dl<?php if(!empty($forum['extra']['iconwidth']) && !empty($forum['icon'])) { ?> style="margin-left: <?php echo $forum['extra']['iconwidth'];?>px;"<?php } ?>>
                                            <dt><a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } if($forum['extra']['namecolor']) { ?> style="color: <?php echo $forum['extra']['namecolor'];?>;"<?php } ?>><?php echo $forum['name'];?></a><?php if($forum['todayposts'] && !$forum['redirect']) { ?><em class="xw0 xi1" title="今日"> (<?php echo $forum['todayposts'];?>)</em><?php } ?></dt>
                                            <?php if($forum['description']) { ?><p class="xg2 bbs_info"><?php echo $forum['description'];?></p><?php } ?>
                                            <?php if(empty($forum['redirect'])) { ?><dd><em>主题: <?php echo dnumber($forum['threads']); ?></em>, <em>帖数: <?php echo dnumber($forum['posts']); ?></em></dd><?php } ?>
                                            <?php if(!empty($_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]];?>
                                        </dl>
                                    </td>
                                    <?php } else { ?>
                                    <td class="fl_icn" <?php if(!empty($forum['extra']['iconwidth']) && !empty($forum['icon'])) { ?> style="width: <?php echo $forum['extra']['iconwidth'];?>px;"<?php } ?>>
                                        <?php if($forum['icon']) { ?>
                                        <?php echo $forum['icon'];?>
                                        <?php } else { ?>
                                        <a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } ?>><img src="<?php echo $_G['style']['styleimgdir'];?>/forum<?php if($forum['folder']) { ?>_new<?php } ?>.gif" alt="<?php echo $forum['name'];?>" /></a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <h2><a href="<?php echo $forumurl;?>"<?php if($forum['redirect']) { ?> target="_blank"<?php } if($forum['extra']['namecolor']) { ?> style="color: <?php echo $forum['extra']['namecolor'];?>;"<?php } ?>><?php echo $forum['name'];?></a><?php if($forum['todayposts'] && !$forum['redirect']) { ?><em class="xw0 xi1" title="今日"> (<?php echo $forum['todayposts'];?>)</em><?php } ?></h2>
                                        <?php if($forum['description']) { ?><p class="xg2"><?php echo $forum['description'];?></p><?php } ?>
                                        <?php if($forum['subforums']) { ?><p>子版块: <?php echo $forum['subforums'];?></p><?php } ?>
                                        <?php if($forum['moderators']) { ?><p>版主: <span class="xi2"><?php echo $forum['moderators'];?></span></p><?php } ?>
                                        <?php if(!empty($_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]])) echo $_G['setting']['pluginhooks']['index_forum_extra'][$forum[fid]];?>
                                    </td>
                                    <td class="fl_i">
                                        <?php if(empty($forum['redirect'])) { ?><span class="xi2"><?php echo dnumber($forum['threads']); ?></span><span class="xg1"> / <?php echo dnumber($forum['posts']); ?></span><?php } ?>
                                    </td>
                                    <td class="fl_by">
                                        <div>
                                            <?php if($forum['permission'] == 1) { ?>
                                            私密版块
                                            <?php } else { ?>
                                            <?php if($forum['redirect']) { ?>
                                            <a href="<?php echo $forumurl;?>" class="xi2">链接到外部地址</a>
                                            <?php } elseif(is_array($forum['lastpost'])) { ?>
                                            <a href="forum.php?mod=redirect&amp;tid=<?php echo $forum['lastpost']['tid'];?>&amp;goto=lastpost#lastpost" class="xi2"><?php echo cutstr($forum['lastpost']['subject'], 30); ?></a> <cite><?php echo $forum['lastpost']['dateline'];?> <?php if($forum['lastpost']['author']) { ?><?php echo $forum['lastpost']['author'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite>
                                            <?php } else { ?>
                                            从未
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="fl_row">
                                    <?php } ?>
                                    <?php } ?>
                                    <?php echo $cat['endrows'];?>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php echo adshow("intercat/bm a_c/$cat[fid]");?>                    <?php } ?>
                    <?php if(!empty($collectiondata['data'])) { ?>

                    <?php $forumscount = count($collectiondata['data']);?>                    <?php $forumcolumns = 4;?>                    <?php $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';?>                    <div class="bm bmw <?php if($forumcolumns) { ?> flg<?php } ?> cl">
                        <div class="bm_h cl">
                            <span class="o">
                                <img id="category_-2_img" src="<?php echo IMGDIR;?>/<?php echo $collapse['collapseimg_-2'];?>" title="收起/展开" alt="收起/展开" onclick="toggle_collapse('category_-2');" />
                            </span>
                            <h2><a href="forum.php?mod=collection">淘专辑推荐</a></h2>
                        </div>
                        <div id="category_-2" class="bm_c" style="<?php echo $collapse['category_-2']; ?>">
                            <table cellspacing="0" cellpadding="0" class="fl_tb">
                                <tr>
                                    <?php $ctorderid = 0;?>                                    <?php if(is_array($collectiondata['data'])) foreach($collectiondata['data'] as $key => $colletion) { ?>                                    <?php if($ctorderid && ($ctorderid % $forumcolumns == 0)) { ?>
                                </tr>
                                <?php if($ctorderid < $forumscount) { ?>
                                <tr class="fl_row">
                                    <?php } ?>
                                    <?php } ?>
                                    <td class="fl_g"<?php if($forumcolwidth) { ?> width="<?php echo $forumcolwidth;?>"<?php } ?>>
                                        <div class="fl_icn_g">
                                            <a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>" target="_blank"><img src="<?php echo $_G['style']['styleimgdir'];?>/forum.gif" alt="<?php echo $colletion['name'];?>" /></a>
                                        </div>
                                        <dl>
                                            <dt><a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $colletion['ctid'];?>"><?php echo $colletion['name'];?></a></dt>
                                            <dd><em>主题: <?php echo dnumber($colletion['threadnum']); ?></em>, <em>评论: <?php echo dnumber($colletion['commentnum']); ?></em></dd>
                                            <dd>
                                                <?php if($colletion['lastpost']) { ?>
                                                <?php if($forumcolumns < 3) { ?>
                                                <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost" class="xi2"><?php echo cutstr($colletion['lastsubject'], 30); ?></a> <cite><?php echo dgmdate($colletion[lastposttime]);?> <?php if($colletion['lastposter']) { ?><?php echo $colletion['lastposter'];?><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite>
                                                <?php } else { ?>
                                                <a href="forum.php?mod=redirect&amp;tid=<?php echo $colletion['lastpost'];?>&amp;goto=lastpost#lastpost">最后发表: <?php echo dgmdate($colletion[lastposttime]);?></a>
                                                <?php } ?>
                                                <?php } else { ?>
                                                从未
                                                <?php } ?>
                                            </dd>
                                            <?php if(!empty($_G['setting']['pluginhooks']['index_datacollection_extra'][$colletion[ctid]])) echo $_G['setting']['pluginhooks']['index_datacollection_extra'][$colletion[ctid]];?>
                                        </dl>
                                    </td>
                                    <?php $ctorderid++;?>                                    <?php } ?>
                                    <?php if(($columnspad = $ctorderid % $forumcolumns) > 0) { echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);; } ?>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <?php } ?>

                </div>

                <?php if(!empty($_G['setting']['pluginhooks']['index_middle'])) echo $_G['setting']['pluginhooks']['index_middle'];?>
                <div class="wp mtn">
                    <!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
                </div>

                <?php if(empty($gid) && $_G['setting']['whosonlinestatus']) { ?>
                <div id="online" class="bm oll">
                    <div class="bm_h">
                        <?php if($detailstatus) { ?>
                        <span class="o"><a href="forum.php?showoldetails=no#online" title="收起/展开"><img src="<?php echo IMGDIR;?>/collapsed_no.gif" alt="收起/展开" /></a></span>
                        <h3>
                            <strong><a href="home.php?mod=space&amp;do=friend&amp;view=online&amp;type=member">在线会员</a></strong>
                            <span class="xs1">- <strong><?php echo $onlinenum;?></strong> 人在线
                                - <strong><?php echo $membercount;?></strong> 会员(<strong><?php echo $invisiblecount;?></strong> 隐身),
                                <strong><?php echo $guestcount;?></strong> 位游客
                                - 最高记录是 <strong><?php echo $onlineinfo['0'];?></strong> 于 <strong><?php echo $onlineinfo['1'];?></strong>.</span>
                        </h3>
                        <?php } else { ?>
                        <?php if(empty($_G['setting']['sessionclose'])) { ?>
                        <span class="o"><a href="forum.php?showoldetails=yes#online" title="收起/展开"><img src="<?php echo IMGDIR;?>/collapsed_yes.gif" alt="收起/展开" /></a></span>
                        <?php } ?>
                        <h3>
                            <strong>
                                <?php if(!empty($_G['setting']['whosonlinestatus'])) { ?>
                                在线会员
                                <?php } else { ?>
                                <a href="home.php?mod=space&amp;do=friend&amp;view=online&amp;type=member">在线会员</a>
                                <?php } ?>
                            </strong>
                            <span class="xs1">- 总计 <strong><?php echo $onlinenum;?></strong> 人在线
                                <?php if($membercount) { ?>- <strong><?php echo $membercount;?></strong> 会员,<strong><?php echo $guestcount;?></strong> 位游客<?php } ?>
                                - 最高记录是 <strong><?php echo $onlineinfo['0'];?></strong> 于 <strong><?php echo $onlineinfo['1'];?></strong>.</span>
                        </h3>
                        <?php } ?>
                    </div>
                    <?php if($_G['setting']['whosonlinestatus'] && $detailstatus) { ?>
                    <dl id="onlinelist" class="bm_c">
                        <dt class="ptm pbm bbda"><?php echo $_G['cache']['onlinelist']['legend'];?></dt>
                        <?php if($detailstatus) { ?>
                        <dd class="ptm pbm">
                            <ul class="cl">
                                <?php if($whosonline) { ?>
                                <?php if(is_array($whosonline)) foreach($whosonline as $key => $online) { ?>                                <li title="时间: <?php echo $online['lastactivity'];?>">
                                    <img src="<?php echo STATICURL;?>image/common/<?php echo $online['icon'];?>" alt="icon" />
                                    <?php if($online['uid']) { ?>
                                    <a href="home.php?mod=space&amp;uid=<?php echo $online['uid'];?>"><?php echo $online['username'];?></a>
                                    <?php } else { ?>
                                    <?php echo $online['username'];?>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                                <?php } else { ?>
                                <li style="width: auto">当前只有游客或隐身会员在线</li>
                                <?php } ?>
                            </ul>
                        </dd>
                        <?php } ?>
                    </dl>
                    <?php } ?>
                </div>
                <?php } ?>

                <?php if(empty($gid) && ($_G['cache']['forumlinks']['0'] || $_G['cache']['forumlinks']['1'] || $_G['cache']['forumlinks']['2'])) { ?>
                <div class="bm lk">
                    <div id="category_lk" class="bm_c ptm">
                        <?php if($_G['cache']['forumlinks']['0']) { ?>
                        <ul class="m mbn cl"><?php echo $_G['cache']['forumlinks']['0'];?></ul>
                        <?php } ?>
                        <?php if($_G['cache']['forumlinks']['1']) { ?>
                        <div class="mbn cl">
                            <?php echo $_G['cache']['forumlinks']['1'];?>
                        </div>
                        <?php } ?>
                        <?php if($_G['cache']['forumlinks']['2']) { ?>
                        <ul class="x mbm cl">
                            <?php echo $_G['cache']['forumlinks']['2'];?>
                        </ul>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>

                <?php if(!empty($_G['setting']['pluginhooks']['index_bottom'])) echo $_G['setting']['pluginhooks']['index_bottom'];?>
              </div>  
              <div id="sd" class="lay_side">
                <?php if(!empty($_G['setting']['pluginhooks']['index_side_top'])) echo $_G['setting']['pluginhooks']['index_side_top'];?>
                <div class="bbs_sidetool2">
                    <p><a data-bn-ipg="bbs-writepost" class="btn_newbbs2" href="forum.php?mod=misc&amp;action=nav">写新帖</a></p>
                </div>
                <div class="bbs_lastread" id="bbs_lastread">
                    <p class="bbs_lastread_tit"><span><a href="forum.php?mod=guide&amp;view=my"> 我的帖子</a></span></p>
                </div>
                <div class="drag">
                    <!--[diy=diy2]--><div id="diy2" class="area"><div id="frameSMGi77" class="frame move-span cl frame-1"><div id="frameSMGi77_left" class="column frame-1-c"><div id="frameSMGi77_left_temp" class="move-span temp"></div><?php block_display('6');?><?php block_display('7');?><?php block_display('8');?><?php block_display('9');?><?php block_display('10');?></div></div></div><!--[/diy]-->
                </div>
                <?php if(!empty($_G['setting']['pluginhooks']['index_side_bottom'])) echo $_G['setting']['pluginhooks']['index_side_bottom'];?>
            </div>
            </div>

       </div>     
        <?php if($_G['group']['radminid'] == 1) { ?>
        <?php helper_manyou::checkupdate();?>        <?php } ?>
        <?php if(empty($_G['setting']['disfixednv_forumindex']) ) { ?><script>fixed_top_nv();</script><?php } ?>
        
        
        <?php include template('common/footer'); ?>