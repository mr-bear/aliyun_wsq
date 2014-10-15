<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class mrbear_wsqdocjump_api
{

    function forumdisplay_sideBar()
    {
        return '[forumdisplay_sideBar]';
    }

	function viewthread_sideBar()
    {
        return '[viewthread_sideBar]';
	}

	function viewthread_postBottom()
    {
        return 'viewthread_postBottom';
	}



	function viewthread_threadBottom()
    {
        return '[viewthread_threadBottom]';
	}

	function viewthread_topBar()
    {
        return 'viewthread_topBar';
	}

    function pluginIconv($inData)
    {
        global $_G;
        $charset = $_G['charset'];
        $outData = $inData;
        if ('UTF-8' != $charset) {
            $outData = diconv($inData, $charset, 'UTF-8');
        }
        return $outData;
    }
}

?>
