<?php
require __DIR__.'/_common.php';key(true);
$id=body()['order_id']??'';$f=$c['data_dir'].'/'.$id.'.json';
if(!is_file($f))out(['ok'=>false,'error'=>'Order tidak ditemukan'],404);
$o=json_decode(file_get_contents($f),true);$o['status']='COMPLETED';$o['updated_at']=date('c');
file_put_contents($f,json_encode($o,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE),LOCK_EX);out(['ok'=>true,'order'=>$o]);
