<?php

//READ

function isValidUserId($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(select * from User where user_id=?)
                as exist";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return intval($res[0]['exist']);
}

function isValidClothesId($clothes_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(select * from Clothes where clothes_id=?)
                as exist";

    $st = $pdo->prepare($query);
    $st->execute([$clothes_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return intval($res[0]['exist']);
}

function isValidShopId($shop_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT EXISTS(select * from Shop where shop_id=?)
                as exist";

    $st = $pdo->prepare($query);
    $st->execute([$shop_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return intval($res[0]['exist']);
}


function getUsers()
{
    $pdo = pdoSqlConnect();
    $query = "
    SELECT *
    FROM User ";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}




//**************************************   user_id 기준 쇼핑몰 리스트 전체 가져오기
function getShopList($user_id)
{
//    mysql_query("set names 'utf8'");
    $pdo = pdoSqlConnect();
    $query = "SELECT S.shop_id, S.shop_thumbnail, S.shop_name, A.status,
       S.zigzag_shipping, S.free_shipping,
       C.lovely, C.campus, C.modern, C.simple, C.casual
FROM Shop S LEFT JOIN (select * from Favorites F where user_id=?) A
    on S.shop_id = A.shop_id
    JOIN Category C on S.shop_id = C.shop_id;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//**************************************   user_id 기준 즐겨찾기 된 쇼핑몰 수 가져오기
function getFavoriteShopNum($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT COUNT(*) AS '즐겨찾기'
FROM Favorites F
JOIN User U
ON U.user_id = ? AND F.user_id = U.user_id;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}


//**************************************   user_id 기준 즐겨찾기 된 쇼핑몰 목록 가져오기
function getFavoriteShop($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT S.shop_id, S.shop_name, S.shop_thumbnail, S.zigzag_shipping
FROM User U JOIN Favorites F on U.user_id = F.user_id
    JOIN Shop S on F.shop_id = S.shop_id
WHERE U.user_id = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//**************************************   카테고리에 따른 상품 가져오기
function getCategoryClothes($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT S.shop_id, C.clothes_thumbnail, S.shop_name, C.clothes_name,
       FORMAT(C.clothes_price, 0), C.free_shipping, S.zigzag_shipping, A.status
FROM Clothes C JOIN Shop S on S.shop_id = C.shop_id
    LEFT JOIN (
        select LC.*
        from LikeClothes LC
             join User U on LC.user_id = U.user_id
        where U.user_id = ?
    ) A on S.shop_id = A.clothes_id
WHERE C.top!=0;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//**************************************   찜한 아이템 가져오기
function getLikeClothes($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT S.shop_id, C.clothes_thumbnail, S.shop_name, C.clothes_name,
       FORMAT(C.clothes_price, 0), C.free_shipping, S.zigzag_shipping
FROM LikeClothes LC JOIN Clothes C on LC.clothes_id = C.clothes_id
    JOIN Shop S ON S.shop_id = C.shop_id
WHERE LC.user_id=?;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//**************************************   찜한 아이템 개수 가져오기
function getLikeClothesNum($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT COUNT(*) AS '찜한 상품'
FROM LikeClothes LC
JOIN User U
ON U.user_id = ? AND LC.user_id = U.user_id;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

//**************************************   상품 보기
function getClothesInfo($clothes_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT S.shop_id, S.shop_name, C.clothes_thumbnail, C.clothes_name,
       FORMAT(C.clothes_price, 0), C.clothes_size, C.detail_url, LC.status
FROM Clothes C JOIN LikeClothes LC on C.clothes_id = LC.clothes_id
    JOIN Shop S ON S.shop_id=C.shop_id
WHERE C.clothes_id=?;
";

    $st = $pdo->prepare($query);
    $st->execute([$clothes_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

//**************************************   상품리뷰 개수 가져오기
function getClothesNum($clothes_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT COUNT(*) AS '리뷰개수'
FROM Clothes C
JOIN Review R
ON C.clothes_id = ? AND C.clothes_id = R.clothes_id;
";

    $st = $pdo->prepare($query);
    $st->execute([$clothes_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}


//**************************************   상품리뷰 가져오기
function getClothesReview($clothes_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT R.star_rating, R.user_height, R.user_weight, C.clothes_size,
       Riu.review_img, R.writing, date_format(R.review_date, '%Y.%m.%d')
FROM Clothes C JOIN Review R on C.clothes_id = R.clothes_id
    LEFT JOIN Review_img_url Riu on R.review_id = Riu.review_id
WHERE C.clothes_id = ?;
";

    $st = $pdo->prepare($query);
    $st->execute([$clothes_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

//**************************************   마이페이지 가져오기
function getMyPage($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT U.user_name, U.user_email, U.grade
FROM User U
WHERE U.user_id=?;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}



//**************************************   주문조회 가져오기
function getOrderCheck($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT C.clothes_thumbnail,date_format(Ol.Order_date, '%Y.%m.%d'),
       S.shop_name, C.clothes_name, Ol.delivery_status
FROM User U JOIN Order_list Ol on U.user_id = Ol.user_id
    JOIN Clothes C on Ol.clothes_id = C.clothes_id
    JOIN Shop S on S.shop_id=C.shop_id
WHERE U.user_id=?;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}



//**************************************   배송조회 가져오기
function getDeliveryCheck($user_id)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT C.clothes_id, C.clothes_thumbnail,Ol.Invoice, C.clothes_name, FORMAT(C.clothes_price, 0)
FROM Order_list Ol JOIN Clothes C on Ol.clothes_id = C.clothes_id JOIN User U on Ol.user_id = U.user_id
WHERE U.user_id=?;";

    $st = $pdo->prepare($query);
    $st->execute([$user_id]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}


//**************************************   리뷰 등록
function createReview($clothes_id,$user_id,$star_rating,$writing,$user_weight,$user_height,$review_date){
    echo "도착2";
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO Review (clothes_id,user_id,star_rating,writing,user_weight,user_height,review_date) VALUES (?,?,?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$clothes_id,$user_id,$star_rating,$writing,$user_weight,$user_height,$review_date]);

    $st = null;
    $pdo = null;

}



function createUser($name)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO TestTable (Name) VALUES (?);";

    $st = $pdo->prepare($query);
    $st->execute([$name]);

    $st = null;
    $pdo = null;
}






//function testPost($name)
//{
//    $pdo = pdoSqlConnect();
//    $query = "INSERT INTO Test (name) VALUES (?);";
//
//    $st = $pdo->prepare($query);
//    $st->execute([$name]);
//
//    $st = null;
//    $pdo = null;
//
//}


//function isValidUser($id, $pw){
//    $pdo = pdoSqlConnect();
//    $query = "SELECT EXISTS(SELECT * FROM User WHERE userId= ? AND userPw = ?) AS exist;";
//
//
//    $st = $pdo->prepare($query);
//    //    $st->execute([$param,$param]);
//    $st->execute([$id, $pw]);
//    $st->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $st->fetchAll();
//
//    $st=null;$pdo = null;
//
//    return intval($res[0]["exist"]);
//
//}





// UPDATE
//    function updateMaintenanceStatus($message, $status, $no){
//        $pdo = pdoSqlConnect();
//        $query = "UPDATE MAINTENANCE
//                        SET MESSAGE = ?,
//                            STATUS  = ?
//                        WHERE NO = ?";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message, $status, $no]);
//        $st = null;
//        $pdo = null;
//    }

// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM USER_TB WHERE EMAIL= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }
