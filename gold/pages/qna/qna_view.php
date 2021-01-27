<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gold</title>
  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- main style css link -->
  <link rel="stylesheet" href="/gold/css/style.css">

  <!-- design form style css -->
  <link rel="stylesheet" href="/gold/css/design_web_app.css">

  <link rel="stylesheet" href="/gold/css/qna.css">

  <!-- animation css link -->
  <link rel="stylesheet" href="/gold/css/animation.css">
  
  <!-- media query style css link -->
  <link rel="stylesheet" href="/gold/css/media.css">

  <!-- jQuery link -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="/gold/js/custom.js" defer></script>
  <script src="/gold/js/web_design_page.js" defer></script>
</head>

<body>
  <div class="wrap">
    <?php include $_SERVER["DOCUMENT_ROOT"]."/gold/include/header.php" ?>
    <section class="contents qna hasTitle">
      <div class="center">
        <!-- contact title style -->
        <div class="title">
          <h2>Your Inquiry</h2>
          <div class="subTit">
            <span class="subLine"></span>
            <a href="#" class="subLink">View More Details</a>
          </div>
        </div><!--contact end of common title -->
        <div class="qnaBoxes deweBoxes qnaView">

        <?php
        $ans_num = $_GET['num'];

        include $_SERVER['DOCUMENT_ROOT'].'/gold/php_process/connect/db_connect.php';
        $sql = "select * from gold_qna where GOLD_QNA_num=$ans_num";

        $ans_result = mysqli_query($dbConn,$sql);
        $ans_row = mysqli_fetch_array($ans_result);
        
        $ans_id = $ans_row['GOLD_QNA_id'];
        $ans_tit = $ans_row['GOLD_QNA_tit'];
        $ans_con = $ans_row['GOLD_QNA_con'];
        $ans_reg = $ans_row['GOLD_QNA_reg'];
        $ans_hit = $ans_row['GOLD_QNA_hit'];

        $new_hit = $ans_hit + 1;

        $sql = "update gold_qna set GOLD_QNA_hit='$new_hit' where GOLD_QNA_num=$ans_num";
        mysqli_query($dbConn,$sql); 
        ?>
          <div class="writerInfo">
            <p>Posted By <?=$ans_id?> NO. <?=$ans_num?> / <?=$ans_reg?> / <?=$new_hit?> Hits</p>
          </div>
          <div class="writeBox clear">
          <form action="/gold/php_process/pages/qna_update.php?num=<?=$ans_num?>" method="post" class="writeForm" name="ansForm">
                <p class="qnaTitInput">
                  <label for="ansTitle">제목</label>
                  <input type="text" name="ansTitle" id="ansTitle" placeholder="제목을 입력해 주세요" value="<?=$ans_tit?>">
                </p>
                <p class="qnaTxtInput">
                  <textarea name="ansTxt" placeholder="내용을 입력해 주세요"><?=$ans_con?></textarea>
                </p>
              </form>
              <?php
              if($userid==''){
              ?>
                <button type="submit" class="alertLogin" onclick="plzLogin()">등록</button>  
              <?php
              } else {
              ?>
              <a href="/gold/pages/qna/qna.php">돌아가기</a>
              <button type="submit" class="ansSubmit">수정</button>
              <?php
              }
              ?>
          </div><!--end of write box-->

          <div class="answerBox">
            <form action="" method="post" name="ansInputForm" class="ansInputForm">
              <textarea name="ansInputTxt" placeholder="답글을 작성해주세요"></textarea>
              <p class="ansBtn">
                <button type="submit">답글달기</button>
              </p>
            </form>
          </div>
        </div>
      </div><!--end of center-->
    </section>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/gold/include/about.php" ?>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/gold/include/footer.php" ?>
  </div>
  <script>
    const qnaSubmit = document.querySelector(".ansSubmit");
    qnaSubmit.addEventListener('click',insertAns);

    function plzLogin(){
    alert('글쓰기를 하시려면 로그인이 필요합니다');
    }

    function insertAns(){
    if(!document.ansForm.ansTitle.value){
    alert("제목을 입력해 주세요");
    document.ansForm.ansTitle.focus();
    return;
    }
    if(!document.ansForm.ansTxt.value){
    alert("내용을 입력해 주세요");
    document.ansForm.ansTxt.focus();
    return;
    }
    document.ansForm.submit();
    }
  </script>
</body>
</html>