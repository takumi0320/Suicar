<?php
require_once 'DBManager.php';

class PythonSendReceive{
    //ラジコン全方向可能メソッド
    public function RCStartUp(){
        file_get_contents('http://126.165.24.179/getEventManager2.php?method=enable_all');
    }

    //おじゃまアイテム制御メソッド
    public function itemHindrance($itemID){
        $DBM = new DBManager();
        //switch分岐
        switch ($itemID){
            //ラジコン左方向のみ有効
            case 2:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=enable_turn_left&data='.$time);
            break;
            //ラジコン左方向のみ無効
            case 3:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=disable_turn_left&data='.$time);
            break;
            //ラジコン右方向のみ有効
            case 4:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=enable_turn_right&data='.$time);
            break;
            //ラジコン右方向のみ無効
            case 5:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=disable_turn_right&data='.$time);
            break;
            //ラジコン直進のみ有効
            case 6:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=enable_straight&data='.$time);
            break;
            //ラジコン直進のみ無効
            case 7:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=disable_straight&data='.$time);
            break;
            //ラジコン後退のみ有効
            case 8:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=enable_back&data='.$time);
            break;
            //ラジコン後退のみ無効
            case 9:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=disable_back&data='.$time);
            break;
            //ラジコン全方向無効
            case 10:
            $result = $DBM->getItemInfoByItemID($itemID);
            $arr = array("time" => (int)$result[0]->arailTime);
            $json = json_encode($arr);
            $time = urlencode($json);
            file_get_contents('http://126.165.24.179/getEventManager2.php?method=disable_all&data='.$time);
            break;
        }
    }

}

?>
