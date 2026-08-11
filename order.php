<?php
require __DIR__.'/_common.php';key();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $d=order(body());if($d['payment']==='')out(['ok'=>false,'error'=>'Payment wajib'],422);
 $id='ARC-'.date('YmdHis').'-'.strtoupper(bin2hex(random_bytes(3)));
 $d+=['id'=>$id,'status'=>'WAITING_PAYMENT','created_at'=>date('c'),'updated_at'=>date('c')];
 if(!is_dir($c['data_dir']))mkdir($c['data_dir'],0755,true);
 file_put_contents($c['data_dir'].'/'.$id.'.json',json_encode($d,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE),LOCK_EX);
 out(['ok'=>true,'order'=>$d],201);
}
if($_SERVER['REQUEST_METHOD']==='GET'){
 $id=$_GET['id']??'';$f=$c['data_dir'].'/'.$id.'.json';
 if(!is_file($f))out(['ok'=>false,'error'=>'Order tidak ditemukan'],404);
 out(['ok'=>true,'order'=>json_decode(file_get_contents($f),true)]);
}
out(['ok'=>false,'error'=>'Method not allowed'],405);
