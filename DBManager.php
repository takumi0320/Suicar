<?php

//テーブル用のクラスを読み込む
//DBManagerが使うクラスを読み込む
require_once 'DBInfo.php';
require_once 'roomTblDT.php';
require_once 'itemTblDT.php';
require_once 'roomItemTblDT.php';

class DBManager{
    private $myPdo;

    //接続のメソッド
    public function dbConnect(){
        try{
            $DBI = new DBInfo();
            $this->myPdo = new PDO('mysql:host='.$DBI->dbhost .';dbname='.$DBI->dbname .';charset=utf8', $DBI->user, $DBI->password, array(PDO::ATTR_EMULATE_PREPARES => true));
        }catch(PDOException $e) {
            print('データベース接続失敗。'.$e->getMessage());
            throw $e;
        }
    }

    //切断のメソッド
    public function dbDisconnect(){
        unset($myPdo);
    }

    //ルーム情報挿入メソッド
    public function setRoomInfo($roomID,$roomPass,$joinedFlg,$gameStartFlg,$gameEndFlg,$gameTime,$atackUserFlg){

        try{
            //DBに接続
            $this->dbConnect();
            ///SQL生成
            $stmt = $this->myPdo->prepare("INSERT INTO room(room_id,room_pass,joined_flg,game_start_flg,game_end_flg,game_time,atack_user_flg)
            VALUES (:RoomID,:RoomPass,:JoinedFlg,:GameStartFlg,:GameEndFlg,:GameTime,:AtackUserFlg)");
            $stmt->bindParam(':RoomID',$roomID,PDO::PARAM_STR);
            $stmt->bindParam(':RoomPass',$roomPass,PDO::PARAM_STR);
            $stmt->bindParam(':JoinedFlg',$joinedFlg,PDO::PARAM_STR);
            $stmt->bindParam(':GameStartFlg',$gameStartFlg,PDO::PARAM_STR);
            $stmt->bindParam(':GameEndFlg',$gameEndFlg,PDO::PARAM_STR);
            $stmt->bindParam(':GameTime',$gameTime,PDO::PARAM_STR);
            $stmt->bindParam(':AtackUserFlg',$atackUserFlg,PDO::PARAM_STR);

            //SQL実行
            $stmt->execute();
            //DB切断
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('書き込み失敗。'.$e->getMessage());
            throw $e;
        }
    }

    //ルーム情報取得メソッド
    public function getRoomInfoByRoomID($roomID){
        try{
            //DBに接続
            $this->dbConnect();

            //SQLを生成
            $stmt = $this->myPdo->prepare("SELECT * FROM room WHERE room_id = :RoomID");
            $stmt->bindParam(':RoomID',$roomID,PDO::PARAM_STR);
            //SQLを実行
            $stmt->execute();
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt ->fetch(PDO::FETCH_ASSOC)){
                $result = new RoomTblDT();
                $result->roomID = $row['room_id'];
                $result->roomPass = $row['room_pass'];
                $result->joinedFlg = $row['joined_flg'];
                $result->gameStartFlg = $row['game_start_flg'];
                $result->gameEndFlg = $row['game_end_flg'];
                $result->gameTime = $row['game_time'];
                $result->atackUserFlg = $row['atack_user_flg'];

                array_push($retList, $result);
            }
            $this->dbDisconnect();
            //結果が格納された配列を返す
            return $retList;
        }catch (PDOException $e) {
            print('検索に失敗。'.$e->getMessage());
        }
    }

    //ルーム情報更新メソッド
    public function updateRoomInfoByRoomID($roomID,$roomPass,$joinedFlg,$gameStartFlg,$gameEndFlg,$gameTime,$atackUserFlg){
        try{
            $this->dbConnect();

            $stmt = $this->myPdo->prepare("UPDATE room SET room_id = :roomID, room_pass = :roomPass, joined_flg = :joinedFlg, game_start_flg = :gameStartFlg, game_end_flg = :gameEndFlg, game_time = :gameTime, atack_user_flg = :atackUserFlg WHERE room_id = :roomID");
            $stmt->bindParam(':roomID',$roomID,PDO::PARAM_STR);
            $stmt->bindParam(':roomPass',$roomPass,PDO::PARAM_STR);
            $stmt->bindParam(':joinedFlg',$joinedFlg,PDO::PARAM_STR);
            $stmt->bindParam(':gameStartFlg',$gameStartFlg,PDO::PARAM_STR);
            $stmt->bindParam(':gameEndFlg',$gameEndFlg,PDO::PARAM_STR);
            $stmt->bindParam(':gameTime',$gameTime,PDO::PARAM_STR);
            $stmt->bindParam(':atackUserFlg',$atackUserFlg,PDO::PARAM_STR);

            $stmt->execute();
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('更新に失敗しました。'.$e->getMessage());
            throw $e;
        }

    }

    //ルーム情報削除メソッド
    public function removeRoomInfoByRoomID($roomID){
        try{
            //DBに接続
            $this->dbConnect();

            //SQLを生成
            $stmt = $this->myPdo->prepare("DELETE FROM room  WHERE room_id = :RoomID");
            $stmt->bindParam(':RoomID',$roomID,PDO::PARAM_STR);
            //SQLを実行
            $stmt->execute();
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('削除に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    //使用ルーム情報挿入メソッド
    public function setRoomItem($roomID,$itemID,$useFlg){
        try{
            //DBに接続
            $this->dbConnect();
            ///SQL生成
            $stmt = $this->myPdo->prepare("INSERT INTO room_item(room_id,item_id,use_flg) VALUES (:RoomID,:ItemID,:UseFlg)");
            $stmt->bindParam(':RoomID',$roomID,PDO::PARAM_STR);
            $stmt->bindParam(':ItemID',$itemID,PDO::PARAM_STR);
            $stmt->bindParam(':UseFlg',$useFlg,PDO::PARAM_STR);

            //SQL実行
            $stmt->execute();
            //DB切断
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('書き込み失敗。'.$e->getMessage());
            throw $e;
        }

    }

    //使用ルーム情報取得メソッド
    public function getRoomItemInfoByRoomID($roomID){
        try{
            //DBに接続
            $this->dbConnect();

            //SQLを生成
            $stmt = $this->myPdo->prepare("SELECT * FROM room_item WHERE room_id = :RoomID");
            $stmt->bindParam(':RoomID',$roomID,PDO::PARAM_STR);
            //SQLを実行
            $stmt->execute();
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt ->fetch(PDO::FETCH_ASSOC)){
                $result = new roomItemTblDT();
                $result->roomID = $row['room_id'];
                $result->itemID = $row['item_id'];
                $result->useFlg = $row['use_flg'];

                array_push($retList, $result);
            }
            $this->dbDisconnect();
            //結果が格納された配列を返す
            return $retList;
        }catch (PDOException $e) {
            print('検索に失敗。'.$e->getMessage());
        }
    }

    //使用ルーム情報更新メソッド
    public function updateRoomItemInfoByRoomIDAndItemID($roomID,$itemID,$useFlg){
        try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare("UPDATE room_item SET room_id = :RoomID, item_id = :ItemID, use_flg = :UseFlg WHERE room_id = :RoomID");
            $stmt->bindParam(':RoomID',$roomID,PDO::PARAM_STR);
            $stmt->bindParam(':ItemID',$itemID,PDO::PARAM_STR);
            $stmt->bindValue(':UseFlg',$useFlg,PDO::PARAM_STR);
            //SQLを実行
            $stmt->execute();
            $this->dbDisconnect();

        }catch (PDOException $e) {
            print('更新に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    //使用ルーム情報削除メソッド
    public function removeRoomItemInfoByRoomID($roomID){
        try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare("DELETE FROM room_item WHERE room_id = :RoomID");
            $stmt->bindParam(':RoomID',$roomID,PDO::PARAM_STR);
            //SQLを実行
            $stmt->execute();
            $this->dbDisconnect();
        }catch (PDOException $e) {
            print('削除に失敗しました。'.$e->getMessage());
            throw $e;
        }
    }

    //アイテム情報取得メソッド
    public function getItemInfoByItemID($itemID){
        try{
            //DBに接続
            $this->dbConnect();

            //SQLを生成
            $stmt = $this->myPdo->prepare("SELECT * FROM item WHERE item_id = :ItemID");
            $stmt->bindParam(':ItemID',$itemID,PDO::PARAM_STR);
            //SQLを実行
            $stmt->execute();
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt ->fetch(PDO::FETCH_ASSOC)){
                $result = new ItemTblDT();
                $result->itemID = $row['item_id'];
                $result->itemName = $row['item_name'];
                $result->itemDetail = $row['item_detail'];
                $result->methodName = $row['method_name'];
                $result->arailTime = $row['arail_time'];
                $result->chargeTime = $row['charge_time'];
                array_push($retList, $result);
            }
            $this->dbDisconnect();
            //結果が格納された配列を返す
            return $retList;
        }catch (PDOException $e) {
            print('検索に失敗。'.$e->getMessage());
        }
    }

    //すべてのアイテム情報取得メソッド
    public function getAllItemInfo(){
        try{
            //DBに接続
            $this->dbConnect();
            //SQLを生成
            $stmt = $this->myPdo->prepare("SELECT * FROM item");
            //SQLを実行
            $stmt->execute();
            //取得したデータを１件ずつループしながらクラスに入れていく
            $retList = array();
            while($row = $stmt ->fetch(PDO::FETCH_ASSOC)){
                $result = new ItemTblDT();
                $result->itemID = $row['item_id'];
                $result->itemName = $row['item_name'];
                $result->itemDetail = $row['item_detail'];
                $result->methodName = $row['method_name'];
                $result->arailTime = $row['arail_time'];
                $result->chargeTime = $row['charge_time'];

                array_push($retList, $result);
            }
            $this->dbDisconnect();
            //結果が格納された配列を返す
            return $retList;
        }catch (PDOException $e) {
            print('検索に失敗。'.$e->getMessage());
        }
    }

}
?>
