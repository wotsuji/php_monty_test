<?php

/*************************
 * php -f monty_test.php
 * モンティー・ホール問題の仮説実証プログラム
 * 
 * 【本プログラムの説明】
 * 3枚のドアがあり、1枚はアタリ、2枚はハズレ
 * 最初に1つのドアを選択する。
 * 次に選択してない方からハズレを除く。
 * 「この時に選択をを変える or 変えない」について
 * それぞれ100万回実行して、当たる確立を実証するプログラム
 */
 
//-------------------------------
//ドアを選びなおさないパターン
//-------------------------------
echo "◆ドアを選びなおさないパターンを100万回実行\n";
$counters = array('good'=>0,'ng'=>0);

//100万回ループ
for ( $j=0; $j<=1000000; $j++) {
	//3枚のドアを用意する
	$three_door = three_door_setting();
	//1枚 ドアを選ぶ
	$choise_door_no = mt_rand(0, 2);
	//ハズレの一枚を教える
	$out_no = get_out_door_no($three_door,$choise_door_no);
	//選択を選び・・・なおさない
	
	//アタリ・ハズレを集計する
	if ($three_door[$choise_door_no] === true){
		$counters['good'] = $counters['good'] + 1;
	} else {
		$counters['ng'] = $counters['ng'] + 1;
	}
}
echo "アタリ：".$counters['good']."回\n";
echo "ハズレ：".$counters['ng']."回\n";
echo "正解率：".($counters['good'] / 10000)."％";


//-------------------------------
//ドアを選びなおすパターン
//-------------------------------
echo "◆ドアを選びなおすパターンを100万回実行\n";
$counters = array('good'=>0,'ng'=>0);

//100万回ループ
for ( $j=0; $j<=1000000; $j++) {
	//ドアを用意する
	$three_door = three_door_setting();
	//1枚 ドアを選ぶ
	$choise_door_no = mt_rand(0, 2);
	//ハズレの一枚を教える
	$out_no = get_out_door_no($three_door,$choise_door_no);
	//選択を選びなおす
	$choise_door_no = get_choise_change_no($three_door,$choise_door_no,$out_no)
	//アタリ・ハズレを集計する
	if ($three_door[$choise_door_no]===true){
		$counters['good'] = $counters['good'] + 1;
	} else {
		$counters['ng'] = $counters['ng'] + 1;
	}
}
echo "アタリ：".$counters['good']."回\n";
echo "ハズレ：".$counters['ng']."回\n";
echo "正解率：".($counters['good'] / 10000)."％";


// ドアを3枚用意して1枚にアタリ、2枚にハズレを用意する。
function three_door_setting(){

	// 0-2の配列をすべてハズレ（false）で初期化する
	$doors = array(false,false,false);
	
	//どれか１枚にアタリ（true）をセットする
	$doors[mt_rand(0, 2)] = true;

	return $doors;
}

//ハズレの一枚を教える
function get_out_door_no($three_door,$choise_door_no) {
	$out_no = 0;
	for( $i = 0; $i <= count($three_door); $i++ ){
		if($i === $choise_door_no){
			continue;
		} else if ($three_door[$i]===true) {
			continue;
		}
		$out_no=$i;
		break;
	}
	return $out_no;
}

// 選択を選びなおす
function get_choise_change_no ($three_door,$choise_door_no,$out_no) {
	for( $i = 0; $i <= count($three_door); $i++ ){
		if($i === $out_no){
			continue;
		} else if($i === $choise_door_no){
			continue;
		}
		$choise_door_no = $i;
		break;
	}
	return $choise_door_no;
}


?>

