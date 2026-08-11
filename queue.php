<?php
require __DIR__.'/_common.php';key(true);$a=[];
foreach(glob($c['data_dir'].'/ARC-*.json')?:[] as $f){$o=json_decode(file_get_contents($f),true);if(($o['status']??'')==='PAID_PENDING_COMMAND')$a[]=$o;}
out(['ok'=>true,'count'=>count($a),'orders'=>$a]);
