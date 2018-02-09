<?php
require_once 'DBManager.php';
require_once 'pythonSendReceive.php';

header('Content-type: application/json');

$DBM = new DBManager();
$PSR = new PythonSendReceive();

$json_string = file_get_contents('php://input');
$obj = json_decode($json_string,true);
$methodName = $obj['method'];

$result;

//switch文でメソッド分岐
switch($methodName){
    case 'setRoomInfo':
    $roomID = $obj['roomID'];
    $roomPass = $obj['roomPass'];
    $joinedFlg = $obj['joinedFlg'];
    $gameStartFlg = $obj['gameStartFlg'];
    $gameEndFlg = $obj['gameEndFlg'];
    $gameTime = $obj['gameTime'];
    $attackUserFlg = $obj['attackUserFlg'];
    $DBM->setRoomInfo($roomID,$roomPass,$joinedFlg,$gameStartFlg,$gameEndFlg,$gameTime,$attackUserFlg);
    break;

    case 'getRoomInfoByRoomID':
    $roomID = $obj['roomID'];
    $result = $DBM->getRoomInfoByRoomID($roomID);
    break;

    case 'updateRoomInfoByRoomID':
    $roomID = $obj['roomID'];
    $roomPass = $obj['roomPass'];
    $joinedFlg = $obj['joinedFlg'];
    $gameStartFlg = $obj['gameStartFlg'];
    $gameEndFlg = $obj['gameEndFlg'];
    $gameTime = $obj['gameTime'];
    $attackUserFlg = $obj['attackUserFlg'];
    $DBM->updateRoomInfoByRoomID($roomID,$roomPass,$joinedFlg,$gameStartFlg,$gameEndFlg,$gameTime,$attackUserFlg);
    $result = $DBM->getRoomInfoByRoomID($roomID);
    //ゲームが始まればラジコン全方向可
    if($result[0]->gameStartFlg == '1'){
        $PSR->RCStartUp();
    }
    break;

    case 'removeRoomInfoByRoomID':
    $roomID = $obj['roomID'];
    $DBM->removeRoomInfoByRoomID($roomID);
    break;

    case 'setRoomItem':
    $roomID = $obj['roomID'];
    $itemID = $obj['itemID'];
    $useFlg = $obj['useFlg'];
    $DBM->setRoomItem($roomID,$itemID,$useFlg);
    break;

    case 'getRoomItemInfoByRoomID':
    $roomID = $obj['roomID'];
    $result = $DBM->getRoomItemInfoByRoomID($roomID);
    break;

    case 'updateRoomItemInfoByRoomIDAndItemID':
    $roomID = $_POST['roomID'];
    $itemID = $_POST['itemID'];
    $useFlg = $_POST['useFlg'];
    $roomID = $obj['roomID'];
    $itemID = $obj['itemID'];
    $useFlg = $obj['useFlg'];
    $DBM->updateRoomItemInfoByRoomIDAndItemID($roomID,$itemID,$useFlg);
    $result = $DBM->getRoomItemInfoByRoomID($roomID);
    //アイテム使用開始ならアイテム使用
    if($result[0]->useFlg == 0){
        $PSR->itemHindrance($result[0]->itemID);
    }else{
        $PSR->RCStartUp();
    }
    break;

    case 'removeRoomItemInfoByRoomID':
    $roomID = $obj['roomID'];
    $DBM->removeRoomItemInfoByRoomID($roomID);
    break;

    case 'getItemInfoByItemID':
    $itemID = $obj['itemID'];
    $result = $DBM->getItemInfoByItemID($itemID);
    break;

    case 'getAllItemInfo':
    $result = $DBM->getAllItemInfo();
    break;

    case 'gameEnded':
    //ゲーム終了確認メソッド
    $filename = 'http://126.165.24.179/gameEnded.txt';
    $result = file_exists('http://126.165.24.179/gameEnded.txt');
    break;
}
echo json_encode($result);


?>
