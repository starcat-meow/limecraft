let menu=0;
let test=0;
let ani=0;
function MenuOn(){
  if(ani==0)
  {
  var button=document.getElementById('MenuBox');
  var lose=document.getElementById('menulose');
var close=document.getElementById('menuClose');
  close.removeEventListener('transitionend', closeTransitionEndHandler);  
  if(menu==0 && test==0)
  {
    close.style.top='0%';
    document.body.style.overflow='hidden';
    menu=1;
    test=1;
  }
  ani=1;
  button.classList.toggle("active");
  close.classList.toggle("active");
  lose.classList.toggle("active");
  close.addEventListener('transitionend', closeTransitionEndHandler);  
  // 定义 transitionend 事件的处理函数  
function closeTransitionEndHandler(event) {  
    // 检查是否是预期的过渡或动画  
    if (event.propertyName === 'opacity' || event.propertyName === 'transform') {  
      if(menu==1 && test==0)
       {
        menu=0;
      }
      else
      {
        test=0;
      }
      if(menu==0 && test==0)
      {
        close.style.top='100%';
        document.body.style.overflow='visible';
      }
      close.removeEventListener('transitionend', closeTransitionEndHandler);  
      ani=0;
    }  
}
}
}
function showContent(index) {  
  if(index==4)
  {
// 使用 AJAX 发送请求
var xhr = new XMLHttpRequest();  
xhr.open("GET", "MessageUpdate.php?t=" + Math.random(), true);  
xhr.send();
var text=document.getElementById('unreadMessages');
text.style.display="none";
  }
  // 获取所有的 tab 和 content 元素  
  const tabs = document.querySelectorAll('.tab');  
  const contents = document.querySelectorAll('.content');  

  // 移除所有 tab 的 active 类  
  tabs.forEach(tab => tab.classList.remove('active'));  
  // 移除所有 content 的 active 类  
  contents.forEach(content => content.classList.remove('active'));  

  // 添加 active 类到点击的 tab 和相应的 content  
  tabs[index].classList.add('active');  
  contents[index].classList.add('active');  
  
}  

function fh() {  
  var but = document.getElementById('page');  
  var currentPage = parseInt(but.value, 10);  
  if (currentPage > 1) { // 确保不会变成0或负数  
    but.value = currentPage - 1;  
    document.getElementById('form').submit();  
  }  
}  
  
function xyg() {  
  var but = document.getElementById('page');  
  var currentPage = parseInt(but.value, 10);  
  but.value = currentPage + 1;  
  document.getElementById('form').submit();  
}