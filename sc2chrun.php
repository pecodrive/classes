<?php
session_start();
if (!isset($_SESSION["USERID"])) {
    header("Location: logout.php");
    exit;
}
require_once(dirname(__file__) . '/classes.php');
date_default_timezone_set('Asia/Tokyo');
$dbhandle = new DbInit(new DbInfo);

//Get Query and Regex
$query = 
    (
        new SelectResult
        (
            $dbhandle,
            new GetQuery(),
            "SELECT * FROM query;"
        )
    )->obj->result;

$regex = 
    (
        new SelectResult
        (
            $dbhandle,
            new GetRegex(),
            "SELECT * FROM regex;"
        )
    )->obj->result;

//GetMenu and Insert
// $url = "http://2ch.sc/bbsmenu.html";
// $queryHtml = $regex["sc2ch_menu_html"];
// $queryAnkar = $regex["sc2ch_menu_ankar"];
//
// $menuArray = 
//     (
//         new GetSc2chMenu(
//             new HtmlBody($url), 
//             $queryHtml, 
//             $queryAnkar
//         )
//     )->getMenu();
//
// new ExecuteInsert
//     (
//         $menuArray, 
//         $query["sc2ch_menudata_insert"], 
//         new Sc2chMenuInsert, 
//         $dbhandle
//     );
$starttime = time();
$menu = 
    (
        new SelectResult
        (
            $dbhandle, 
            new Sc2chMenuSelect(), 
            $query["sc2ch_menudata_select"]
        )
    )->obj->result;

//GetThread and INSERT
$threadQueryHtml = $regex["sc2ch_thread_html"];
$threadQueryAnkar = $regex["sc2ch_thread_ankar"];

$thread = 
    (
        new GetSc2chThread
        (
            new HtmlBody($menu[358]["menu_url"]),
            $threadQueryHtml,
            $threadQueryAnkar
        )
    )->getThread() ;
new ExecuteInsert
    (
        $thread,
        $query["sc2ch_threaddata_insert"],
        new Sc2chThreadInsert(),
        $dbhandle
    );

$threadResult = 
    (
        new SelectResult
        (
            $dbhandle,
            new Sc2chThreadSelect(),
            $query["sc2ch_threaddata_select"]
        )
    )->obj->result;

//Get Res and INSERT
$resHandleQuery = $regex["sc2ch_res_handle"];
$resBodyQuery = $regex["sc2ch_res_body"];
$resRowBodyQuery = $regex["sc2ch_res_rowbody"];

foreach ($threadResult as $item) {
    static $i = 0;
   // if($i > 200){break;}
    $res[] = 
        (
            new GetSc2chRes
            (
                new HtmlBody ($threadResult[$i]["thread_url"]),
                $resBodyQuery,
                $resHandleQuery,
                $resRowBodyQuery,
                $threadResult[$i]["sha"],
                $query["site_img_url"]
            )
        )->getRes(); 
    new ExecuteInsert
        (
            $res[$i],
            $query["sc2ch_resdata_insert"],
            new Sc2chResInsert($query["sc2ch_resinsertedno_insert"], $query["sc2ch_resoldlog_insert"], $dbhandle),
            $dbhandle
        );
    $i++;
}
$endtime = time();
$timed = $endtime - $starttime;
var_dump($timed);
