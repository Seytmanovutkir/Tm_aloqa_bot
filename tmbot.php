<?php
ob_start();
define('API_KEY',"5146708565:AAEKQGz0dVV6BG_IEVLyfhDiZ3b_Tp6vlnw");
$admin = array("854021271","1757148565");

function bot($method, $datas=[]){
	$url = "https://api.telegram.org/bot".API_KEY."/$method";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
	$res = curl_exec($ch);
	if(curl_error($ch)){
		var_dump(curl_error($ch));
	}else{
	return json_decode($res);
	}
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$mid = $message->message_id;
$text = $message->text;
$data = $message->callback_query->data;
$fname = $message->chat->first_name;
$ism = $message->callback_query->from->first_name;
$fid = $message->calback_query->chat->id;

if($text == "/start"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=> "Assalomu aleykum $fname!
			O'zbekiston Respublikasi IIV Nukus 'Temurbeklar maktabi' harbiy-akademik litseyining
			rasmiy botiga xush kelibsiz! So'nggi yangiliklardan xabardor bo'lish uchun iltimos temurbeklar maktabining rasmiy kanaliga obuna bo'ling!",
			'parse_mode'=>'html',
			'reply_markup'=>json_encode([
			'inline_keyboard'=>[
			[["text"=>"Temurbeklar Maktabi",'url'=>"https://t.me/nukustmhal"]],
			[["text"=>"Tasdiqlash",'calback_query'=>"yes"]]
			]
			])
	]);
	
}
$key=json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[["text"=>"Litsey haqida"]],
	[["text"=>"Dasturchi"],["text"=>"Bot haqida"]],
	]
]);

$key1=json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[["text"=>"Orqaga"]]
	]
]);

if($data == "yes"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"Botdan to'liq foydalanishingiz mumkin. Quyidagi tugmalardan birini tanlang:",
		'reply_markup'=>$key,
		'parse_mode'=>'html',
	]);
	bot('sendMessage',[
		'chat_id'=>$admin,
		'text'=>"Hurmatli admin botimizda yangi foydalanuvchi:
		Yangi foydalanuvchi haqida ma'lumot
		Ismi: $ism
		Id: $fid",
	]);
	
}
$key2=json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[["text"=>"Qabul tartibi"]],
	[["text"=>"Savol berish"],["text"=>"Litsey ma'muriyati"]],
	[["text"=>"Orqaga"]]
	]
]);
if($text=="Litsey haqida"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=> "Ushbu bo'limda siz Nukus Temurbeklar Maktabi HAL haqida ma'lumotga ega bo'lasiz.
		Quyidagi tugmalardan birini tanlang:",
		'reply_markup'=>$key2,
		'parse_mode'=>'html'
	]);
}
if($text=="Qabul tartibi"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=> "Litseyga qabul har yili fevral oyining oxirida boshlanadi.\nLitseyga 9-sinf bitiruvchi o'quvchilar(o'g'il bolalar) tibbiy ko'rik, jismoniy tayyorgarlik va davlat test markazi tomonidan o'tkaziladigan tanlovlar orqali qabul qilinadi.",
		'reply_markup'=>$key1,
		'parse_mode'=>'html'
}
if($text=="Savol berish"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"Savol berish uchun savolingizni kiriting:",
		'reply_markup'=>$key1,
		'parse_mode'=>'html',
	]);
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"Xabaringiz adminga muvaffaqiyatli yuborildi",
		'reply_markup'=>$key1,
		'parse_mode'=>'html',
	]);	
	bot('sendMessage',[
		'chat_id'=>$admin,
		'text'=>"Hurmatli admin foydalanuvchi sizga savol yubordi:
		<b>$text</b>
		foydalanuvchi haqida ma'lumot
		Ismi: $ism
		Id: $fid",
	]);
	
}
if($cid == $admin or $cid=="854021271" and $text=="/admin"){
	bot('sendMessage',[
		'chat_id'=>$admin,
		'text'=>"Hurmatli admin sizga yangi xabar kelsa uni reply qilib jo'nating. Bu xabar savolni yo'llagan bot
		foydalanuvchisiga yuboriladi.",
		'message_id'=>$mid,
	]);
	bot('sendMessage',[
		'chat_id'=>$fid,
		'text'=>$text,
		'reply_message'=>true,
		'message_id'=>$mid,
	])
}
if($text=="Litsey ma'muriyati"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=> "Ushbu bo'lim tez orada ishga tushadi. Bot test rejimida",
		'reply_markup'=>$key1,
		'parse_mode'=>'html'
	]);
}
if($text=="Orqaga"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=> "Bosh menyu",
		'reply_markup'=>$key,
		'parse_mode'=>'html'
	]);
}
if($text=="Dasturchi"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=> "Bot dasturchisi: Seytmanov Utkir Kudrat uli,
		Temurbeklar maktabi HAL 2022-yil bitiruvchisi
		Tug'ilgan sanasi: 21.12.2004
		Millati: O'zbek
		Yashash manzili: Qoraqalpog'iston Respublikasi Qo'ng'irot tumani
		Telegram: @Seytmanov_04
		Tel: +998 93 714 15 07
		Shaxsiy kanali: @phpkodlar_baza",
		'reply_markup'=>$key1,
		'parse_mode'=>'html'
	]);
}
if($text=="Bot haqida"){
	bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=> "Ushbu bot O'zbekiston Respublikasi IIV Nukus 'Temurbeklar maktabi' harbiy-akademik litseyining
			rasmiy boti ",
		'reply_markup'=>$key1,
		'parse_mode'=>'html'
	]);
}
?>
