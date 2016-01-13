<?php
$pubDir = dirname(__file__);
$noPubDir = dirname(dirname(dirname(dirname(__file__))));

require_once($pubDir .'/interface.php');
require_once($noPubDir .'/config.php');
require_once($pubDir .'/dbinit.php');
require_once($pubDir .'/operationdb.php');
require_once($pubDir .'/dom.php');
require_once($pubDir .'/getquery.php');
require_once($pubDir .'/sc2chcommon.php');
require_once($pubDir .'/sc2chgetmenu.php');
require_once($pubDir .'/sc2chgetres.php');
require_once($pubDir .'/sc2chgetthread.php');
require_once($pubDir .'/sc2chmenuinsert.php');
require_once($pubDir .'/sc2chthreadinsert.php');
require_once($pubDir .'/sc2chresinsert.php');
require_once($pubDir .'/sc2chmenuselect.php');
require_once($pubDir .'/sc2chthreadselect.php');
require_once($pubDir .'/sc2chresselect.php');
require_once($pubDir .'/sc2chresimageextraction.php');
