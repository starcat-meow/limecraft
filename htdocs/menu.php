<?php
include_once './header.php';
$pdo=PDOStart();
UserCookieTest();
if (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
       $stmt = $pdo->prepare("SELECT img,name,gid FROM user WHERE cookie = ?");  
       $stmt->bindParam(1, $cookie, PDO::PARAM_STR);  
       $stmt->execute();  
       $arr = $stmt->fetchAll();  
        $shu = $arr[0]; 
        if($shu['img']!='')
           $GLOBALS["img"]=$shu['img'];
        else
          $GLOBALS["img"]='../icon/logo.png';
        if (empty($arr)) {  
           $GLOBALS["img"]='../icon/logo.png';
            exit; 
        }
    }  
?>
.user-click{
  position:fixed;
  top:0px;
  right:8px;
  width: 35px;
  height:35px;
  z-index: 6;
}
.useravatar{
  position:fixed;
  top:2px;
  right:5px;
  width: 30px;
  height:30px;
  border-radius: 200px;
  user-select: none;
  border: 1px solid #fff;
      background-color: rgba(255, 255, 255, 0.3);
      /* 增加磨砂质感 */
      backdrop-filter: blur(10px);
      z-index: 5;
}
.black-layer{
  position: fixed;
  top: 0;
  right: 0;
  width:100%;
  height:35px;
  background-color: white;
  z-index: 2;
}
.menu-btn{
  width:100%;
  height:40px;
  margin:auto 0;
  text-align:center;
  justify-content: space-around;
    align-items: center;
  border: 1px solid #e7e7e777;
  backdrop-filter: blur(5px);
  background-color: white;
  transition:all 0.5s ease;
  border-radius: 8px;  
}
.menu-btn:hover{
  background-color: blue;
  color:white;
}
.menuclose{
  position: fixed;
  top: 100%;
  left: 0;
  width:100%;
  height:100%;
  background-color: rgba(0,0,0,0.2);
  backdrop-filter: blur(5px);
  background-size: cover;
  z-index: 9;
  opacity: 0;
  transition:opacity 0.5s ease;
}
.btn{
  position: fixed;
  top:0;
  left:0;
  width:40px;
  height:35px;
  z-index:10;
}
.menucloseclick{
  position: fixed;
  top: 100%;
  left: 0;
  width:100%;
  height:100%;
  z-index: 10;
  transition:all 0.5s ease;
}
.menu-box{
  position: fixed;
  top: 0;
  left: -70%;
  width:70%;
  height:100%;
  background-color: rgba(255,255,255,1);
  z-index: 11;
  transition:left 0.5s ease;
}
.menu-box.active{
  left: 0%;
}
.menuclose.active{
  opacity: 1;
}
.menucloseclick.active{
  top: 0;
}
.navbar-toggle-btn span {
  display: block;
  height: 3px;
  width: 25px;
  background-color: black;
  margin: 5px 0;
}

<body>
  <div class="menu-box" id="MenuBox">
    <a href="./">
    <button class="menu-btn">首页</button>
    </a>
    <a href="../login">
    <button class="menu-btn">登录</button>
    </a>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='../user'>
      <button class='menu-btn'>用户中心</button>
    </a>"
    ?>
  </div>
  <div class="black-layer"></div>
  <div class="user-click" onmousemove="UserOn()"></div>
  <img class="useravatar" src="<?php echo $GLOBALS["img"];?>">
  <div class="menuclose" id="menuClose"></div>
  <div class="menucloseclick" onclick="MenuOn();" id="menulose"></div>
  <div class="btn" onclick="MenuOn();"></div>
  <div class="beiji">
    <div class="navbar-toggle-btn" onclick="MenuOn();" id="menubutton">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</body> 

</html>