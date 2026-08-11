<?php
header('Content-Type: application/json; charset=utf-8');
$c=require __DIR__.'/../config.php';
$o=$_SERVER['HTTP_ORIGIN']??'';
if(in_array($o,$c['allowed_origins'],true)){header("Access-Control-Allow-Origin: $o");header('Vary: Origin');}
header('Access-Control-Allow-Methods: GET,POST,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,X-API-Key,X-Admin-Key');
if($_SERVER['REQUEST_METHOD']==='OPTIONS')exit;
function out($x,$s=200){http_response_code($s);echo json_encode($x,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);exit;}
function body(){return json_decode(file_get_contents('php://input')?:'{}',true)?:[];}
function key($admin=false){global $c;$v=$_SERVER[$admin?'HTTP_X_ADMIN_KEY':'HTTP_X_API_KEY']??'';if(!hash_equals($admin?$c['admin_secret']:$c['api_secret'],$v))out(['ok'=>false,'error'=>'Unauthorized'],401);}
function user($v){$v=trim($v);if(!preg_match('/^[A-Za-z0-9_]{3,16}$/',$v))out(['ok'=>false,'error'=>'Username tidak valid'],422);return $v;}
function order($d){$r=['ARECADE+'=>10000,'ARECADE++'=>20000,'ARECADE+++'=>30000];$rank=trim($d['rank']??'');$price=(int)($d['price']??0);if(!isset($r[$rank])||$r[$rank]!=$price)out(['ok'=>false,'error'=>'Rank/harga tidak valid'],422);return ['username'=>user($d['username']??''),'rank'=>$rank,'price'=>$price,'payment'=>trim($d['payment']??'')];}
