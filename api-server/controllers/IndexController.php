<?php
require 'function.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
//    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "index":
            echo "API Server";
            break;
        case "ACCESS_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/access.log");
            break;
        case "ERROR_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/errors.log");
            break;
        /*
         * API No. 0
         * API Name : 테스트 API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "getUsers":
            http_response_code(200);
            $res->result = getUsers();
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


         /*
         * API No. 1
         * API Name : 쇼핑몰 목록 API
         * 마지막 수정 날짜 : 20.08.15
         */
        case "getShopList":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getShopList($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 2
         * API Name : 즐겨찾는 쇼핑몰 수 API
         * 마지막 수정 날짜 : 20.08.15
         */
        case "getFavoriteShopNum":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getFavoriteShopNum($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /*
         * API No. 3
         * API Name : 즐겨찾는 쇼핑몰 목록 API
         * 마지막 수정 날짜 : 20.08.15
         */
        case "getFavoriteShop":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getFavoriteShop($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
         * API No. 4
         * API Name : 카테고리에 따른 상품 보여주기 API
         * 마지막 수정 날짜 : 20.08.16
         */
        case "getCategoryClothes":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getCategoryClothes($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
        * API No. 5
        * API Name : 찜한아이템 API
        * 마지막 수정 날짜 : 20.08.16
        */
        case "getLikeClothes":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getLikeClothes($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
        * API No. 6
        * API Name : 찜한아이템 개수 API
        * 마지막 수정 날짜 : 20.08.16
        */
        case "getLikeClothesNum":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getLikeClothesNum($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
        * API No. 7
        * API Name : 상품보기 API
        * 마지막 수정 날짜 : 20.08.16
        */
        case "getClothesInfo":
            http_response_code(200);

            $clothes_id = $vars['clothes_id'];
            if(!isValidClothesId($clothes_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 상품 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getClothesInfo($vars["clothes_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
        * API No. 8
        * API Name : 상품리뷰 개수 API
        * 마지막 수정 날짜 : 20.08.16
        */
        case "getClothesNum":
            http_response_code(200);

            $clothes_id = $vars['clothes_id'];
            if(!isValidClothesId($clothes_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 상품 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getClothesNum($vars["clothes_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
        * API No. 9
        * API Name : 상품의 리뷰보기 API
        * 마지막 수정 날짜 : 20.08.16
        */
        case "getClothesReview":
            http_response_code(200);

            $clothes_id = $vars['clothes_id'];
            if(!isValidClothesId($clothes_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 상품 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getClothesReview($vars["clothes_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
         * API No. 10
         * API Name : 마이페이지 API
         * 마지막 수정 날짜 : 20.08.16
         */

        case "getMyPage":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getMyPage($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        /*
         * API No. 11
         * API Name : 주문조회 API
         * 마지막 수정 날짜 : 20.08.16
         */

        case "getOrderCheck":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getOrderCheck($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
        * API No. 12
         * API Name : 배송조회 API
         * 마지막 수정 날짜 : 20.08.16
         */

        case "getDeliveryCheck":
            http_response_code(200);

            $user_id = $vars['user_id'];
            if(!isValidUserId($user_id)){
                $res->isSuccess = FALSE;
                $res->code = 200;
                $res->message = "유효하지 않은 사용자 ID 입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = getDeliveryCheck($vars["user_id"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        /*
        * API No. 13
         * API Name : 리뷰 등록 API
         * 마지막 수정 날짜 : 20.08.18
         */

        case "createReview":
            echo "도착1";
            http_response_code(200);
            $res->result = createReviewreateReview($req->clothes_id, $req->user_id, $req->star_rating, $req->writing, $req->user_weight, $req->user_height, $req->review_date);

            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
           echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        case "createUser":
            http_response_code(200);
            $res->result = createUser($req->name);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;






    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
