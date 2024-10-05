<!DOCTYPE HTML>
<?php
if (!session_id()) session_start(); // 移动到文件顶部  
include_once '../../header.php';
UserCookieTest();
time_ip_update();
$pdo=PDOStart();
if (!empty($_COOKIE['usercookie'])) {  
        $cookie = $_COOKIE['usercookie'];  
        $stmt = $pdo->prepare("SELECT name,gid FROM user WHERE cookie = ?");  
  $stmt->bindParam(1, $cookie, PDO::PARAM_STR);  
        $stmt->execute();  
        $arr = $stmt->fetchAll();  
        $shu=$arr[0];
        $gid=$shu['gid'];
        if (empty($gid)) {  
           echo "该页面拒绝访问，别想没登录就进(嘿嘿" ;
           exit;
        }
    }  
    else
    {
      header('Location: ../../login');  
      exit;  
    }
    ?>
<html>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="./style.css?version=<?php echo date('YmdHi'); ?>">
  <title>头像上传</title>
</head>

<body>
<div class="menu-box" id="MenuBox">
    <a href="../">
    <button class="menu-btn">首页</button>
    </a>
    <?php
    if(empty($_COOKIE['usercookie']))
    echo "<a href='../../login'>
      <button class='menu-btn'>登录</button>
    </a>"
    ?>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='../../post'>
      <button class='menu-btn'>发布</button>
    </a>"
    ?>
    <?php
    if(!empty($_COOKIE['usercookie']))
    echo "<a href='../'>
      <button class='menu-btn'>用户中心</button>
    </a>"
    ?>
  </div>
    <div class="div-menu">
      <div class="black-layer"></div>
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
    </div>
  <input id="npt" type="file" style="position:absolute;left:250px;top:10px;" accept="image/*" name="picture">
  <div id="box">
    <img style="position:absolute;top:0px;left:0px;opacity: 0.3;" src="" id="img1" />
    <img style="position:absolute;top:0px;left:0px;clip: rect(50px, 250px, 250px, 50px);" src="" id="img2" />
    <!--第三层需用绝对定位浮在上面-->
    <div id="dragDiv" style="position: absolute;width: 200px;height: 200px;border: 1px solid #fff;top:50px;left:50px;">
      <div class="Divmin up-left"></div>
      <div class="Divmin up"></div>
      <div class="Divmin up-right"></div>
      <div class="Divmin right"></div>
      <div class="Divmin right-down"></div>
      <div class="Divmin down"></div>
      <div class="Divmin left-down"></div>
      <div class="Divmin left"></div>
      <div class="Divmin-btn" style="right: 68px;background-color: #2d87f5;" id="confirmBtn">确定</div>
      <div class="Divmin-btn" style="right: 0px;background-color: #f5a52d;">取消</div>
    </div>
    <div style="position: absolute; right: 0;">
      <img src="" id="later" alt="">
    </div>

  </div>
</body>

</html>

<style>

  #box {
    width: calc(100% - 300px);
    height: calc(100% - 100px);
    background: #333;
    position: absolute;
    top: 50px;
    left: 250px;
  }

  .Divmin-btn {
    bottom: -40px;
    width: 60px;
    height: 30px;
    line-height: 30px;
    color: white;
    font-size: 12px;
    text-align: center;
    display: inline-block;
    position: absolute;
    border-radius: 3px 3px 3px 3px;
  }

  .Divmin-btn:hover {
    background-color: rgba(60, 103, 222, 0.6);
    color: #efeeee;
  }

  .Divmin-btn:active {
    background-color: rgba(69, 94, 167, 0.6);
    color: #efeeee;
  }

  .Divmin {
    position: absolute;
    width: 8px;
    height: 8px;
    background: #fff;
  }

  .up-left {
    margin-top: -4px;
    margin-left: -4px;
    cursor: nw-resize;
  }

  .up {
    left: 50%;
    /*父元素盒子dragDiv宽度的一半，注意要有绝对定位*/
    margin-left: -4px;
    top: -4px;
    cursor: n-resize;
  }

  .up-right {
    top: -4px;
    right: -4px;
    cursor: ne-resize;
  }

  .right {
    top: 50%;
    margin-top: -4px;
    right: -4px;
    cursor: e-resize;
  }

  .right-down {
    right: -4px;
    bottom: -4px;
    cursor: se-resize;
  }

  .down {
    bottom: -4px;
    left: 50%;
    margin-left: -4px;
    cursor: s-resize;
  }

  .left-down {
    left: -4px;
    bottom: -4px;
    cursor: sw-resize;
  }

  .left {
    left: -4px;
    top: 50%;
    margin-top: -4px;
    cursor: w-resize;
  }

  #img1,
  #img2 {
    max-width: 600px;
    max-height: 300px;
  }
</style>

<script type="text/javascript">
  //禁止图片被选中
  document.onselectstart = new Function('event.returnValue = false;');
  let confirmBtn = document.getElementById('confirmBtn')
  confirmBtn.addEventListener('click', () => {
    drawRect();
  })


  // 获取图片base64数据
  let npt = document.getElementById("npt");
  npt.onchange = function () {
    let reader = new FileReader();
    reader.readAsDataURL(npt.files[0]);
    reader.onloadend = function (e) {
      img1.src = e.target.result;
      img2.src = e.target.result;
      // console.log(e.target.result);// 图片的base64数据
      getImage(e.target.result)
    };
  }

  let canvas = document.createElement("canvas");
  let ctx = canvas.getContext('2d');

  // 创建图片
  let getImage = function (b64) {
    // 创建图片对象
    let image = new Image();
    image.src = `${b64}`;
    image.onload = function () {
      // 获取原图宽高
      let height = img1.offsetHeight;
      let width = img1.offsetWidth;
      //设置canvas大小与原图宽高一致
      canvas.height = height;
      canvas.width = width;
      // 在canvas绘制图片
      ctx.drawImage(this, 0, 0, width, height);
      // 截图：
      // drawRect();

      // 图片上传后设置裁剪框与图片大小一致
      let a=img1.offsetHeight < img1.offsetWidth ? img1.offsetHeight : img1.offsetWidth;
      dragDiv.style.height = a + 'px'
      dragDiv.style.width = a + 'px'
      dragDiv.style.top = 0 + 'px';
      dragDiv.style.left = 0 + 'px';
      setChoice();
    }
  };

  // 绘制截图矩阵
  let drawRect = function () {
    let top = dragDiv.offsetTop;
    let right = dragDiv.offsetLeft + dragDiv.offsetWidth;
    let bottom = dragDiv.offsetTop + dragDiv.offsetHeight;
    let left = dragDiv.offsetLeft;

    // 截图宽度
    let w = right - left;
    // 截图高度
    let h = bottom - top;
    // 获取截图区域内容,截图区域的像素点矩阵
    let cutImage = ctx.getImageData(left, top, w, h);
    // 裁剪后的base64数据
    let newImage = createNewCanvas(cutImage, w, h);
    later.src = newImage;
    var base64Data = newImage.replace(/^data:image\/\w+;base64,/, "");  
  
// 创建一个表单数据对象  
var formData = new FormData();  
formData.append("image", base64Data);  
  
// 使用 AJAX 发送表单数据  
var xhr = new XMLHttpRequest();  
xhr.open("POST", "upload.php", true);  
xhr.onload = function () {  
    if (xhr.status === 200) {  
        alert("头像上传成功！");  
    } else {  
        alert("头像上传失败！");  
    }  
};  
xhr.send(formData);
window.location.href = '../';
  };

  var createNewCanvas = function (content, width, height) {
    var nCanvas = document.createElement('canvas');
    var nCtx = nCanvas.getContext('2d');
    nCanvas.width = width;
    nCanvas.height = height;
    nCtx.putImageData(content, 0, 0);// 将画布上指定矩形的像素数据，通过 putImageData() 方法将图像数据放回画布
    return nCanvas.toDataURL('image/png');
  }

  //获取id的函数
  function $(id) {
    if (id.indexOf(".") == 0) {
      let className = id.substring(1, id.length);
      let els = document.getElementsByClassName(className);
      return els[0];
    }
    return document.getElementById(id);
  }

  //获取元素相对于屏幕左边及上边的距离，利用offsetLeft
  function getPosition(el) {
    let left = el.offsetLeft;
    let top = el.offsetTop;
    let parent = el.offsetParent;
    while (parent != null) {
      left += parent.offsetLeft;
      top += parent.offsetTop;
      parent = parent.offsetParent;
    }
    return { "left": left, "top": top };
  }

  let dragDiv = $('dragDiv');
  let box = $('box')
  let img1 = $('img1')
  let rightDiv = $('.right');
  let isDraging = false;
  let contact = "";//表示被按下的触点
  //鼠标按下时
  $('.right').onmousedown = function () {
    isDraging = true;
    contact = "right";
  }
  $('.left').onmousedown = function () {
    isDraging = true;
    contact = "left";
  }
  $('.down').onmousedown = function () {
    isDraging = true;
    contact = "down";
  }
  $('.up').onmousedown = function () {
    isDraging = true;
    contact = "up";
  }
  $('.up-right').onmousedown = function () {
    isDraging = true;
    contact = "up-right";
  }
  $('.right-down').onmousedown = function () {
    isDraging = true;
    contact = "down-right";
  }
  $('.up-left').onmousedown = function () {
    isDraging = true;
    contact = "up-left";
  }
  $('.left-down').onmousedown = function () {
    isDraging = true;
    contact = "down-left";
  }

  //鼠标松开时
  window.onmouseup = function () {
    isDraging = false;
  }

  //鼠标移动时
  window.onmousemove = function (e) {
    var e = e || window.event;
    if (isDraging == true) {
      switch (contact) {
        case "up":
          upMove(e);
          break;
        case "right":
          rightMove(e);
          break;
        case "down":
          downMove(e);
          break;
        case "left":
          leftMove(e);
          break;
        case "up-right":
          upMove(e);
          rightMove(e);
          break;
        case "down-right":
          downMove(e);
          rightMove(e);
          break;
        case "down-left":
          downMove(e);
          leftMove(e);
          break;
        case "up-left":
          upMove(e);
          leftMove(e);
          break;
      }
    }
  }

  //up移动
  function upMove(e) {
    let y = e.clientY;//鼠标位置的纵坐标
    let heightBefore = dragDiv.offsetHeight - 2;//选取框变化前的高度
    let addHeight = getPosition(dragDiv).top - y;//增加的高度
    let height = heightBefore + addHeight
    let top = dragDiv.offsetTop - addHeight
    if (top <= 1 || height <= 1) return
    dragDiv.style.height = height + 'px';//选取框变化后的宽度
    dragDiv.style.top = top + 'px';//相当于变化后左上角的纵坐标，鼠标向上移纵坐标减小，下移增大
    dragDiv.style.width = height + 'px';
    setChoice();
  }

  //right移动
  function rightMove(e) {
    let allWidth = img1.offsetWidth + box.offsetLeft
    let x = e.clientX;//鼠标位置的横坐标
    let widthBefore = dragDiv.offsetWidth - 2;//选取框变化前的宽度
    //let widthBefore = dragDiv.clientWidth;
    if (x >= allWidth) return
    let addWidth = x - getPosition(dragDiv).left - widthBefore;//鼠标移动后选取框增加的宽度
    dragDiv.style.width = widthBefore + addWidth + 'px';//选取框变化后的宽度
    dragDiv.style.height = dragDiv.style.width;
    setChoice();
  }

  //down移动
  function downMove(e) {
    let heightBefore = dragDiv.offsetHeight - 2;
    let bottom = box.offsetTop + img1.offsetHeight
    let addHeight = e.clientY - getPosition(dragDiv).top - dragDiv.offsetHeight;
    if (e.clientY >= bottom) return
    let height = heightBefore + addHeight
    dragDiv.style.height = heightBefore + addHeight + 'px';
    dragDiv.style.width = dragDiv.style.height;
    setChoice();

  }

  //left移动
  function leftMove(e) {
    let widthBefore = dragDiv.offsetWidth - 2;
    let addWidth = getPosition(dragDiv).left - e.clientX;//增加的宽度等于距离屏幕左边的距离减去鼠标位置横坐标
    let width = widthBefore + addWidth
    let left = dragDiv.offsetLeft - addWidth

    if (left <= 1 || width <= 1) return
    dragDiv.style.width = width + 'px';
    dragDiv.style.height = width + 'px';
    dragDiv.style.left = left + 'px';//左边的距离（相当于左边位置横坐标）等于选取框距父级元素的距离减去增加的宽度
    setChoice();
  }

  //设置选取框图片区域明亮显示
  function setChoice() {
    let h=dragDiv.offsetHeight;
      let w=dragDiv.offsetWidth;
      let onW = w;
      let onH = h;
      //let onW = w > h ? h : w;
      //let onH = w > h ? h : w;
      //dragDiv.style.width=onW + 'px';
      //dragDiv.style.height=onH + 'px';
    let top = dragDiv.offsetTop;
    let right = dragDiv.offsetLeft + onW;
    let bottom = dragDiv.offsetTop + onH;
    let left = dragDiv.offsetLeft;
    $('img2').style.clip = "rect(" + top + "px," + right + "px," + bottom + "px," + left + "px)";
  }
</script>

