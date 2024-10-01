
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
function resetVhAndPx() {
  let vh = window.innerHeight * 0.01
  document.documentElement.style.setProperty('--vh', `${vh}px`)
  document.documentElement.style.fontSize = document.documentElement.clientWidth / 375 + 'px'
}

onMounted(() => {
  resetVhAndPx()
  // 监听resize事件 视图大小发生变化就重新计算1vh的值
  window.addEventListener('resize',resetVhAndPx)
})

function substrLength(elementId,length){  //elementId：元素id，length：需保留字符串长度
        var text=document.getElementById(elementId);
        var result = "";
        if(text.innerText.length > length){
            result = text.innerText.substr(0,length)+"...";
        }else{
            result = text.innerText;
        }
        text.innerText=result;
    }
substrLength('post-text','30');
function ToChangePage()
{
  var form=document.getElementById("form");
  form.submit();
}
 