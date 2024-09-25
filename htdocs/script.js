let menu=0;
let ani=1;
function MenuOn(){
  var button=document.getElementById('MenuBox');
  var close=document.getElementById('menuClose');
  if(ani==1)
  {
  if(menu==0)
  {
    button.classList.remove('jianback');
  button.classList.add('jian');
  close.classList.remove('layerback');
  close.classList.add('layer');
  menu = 1;
  }
  else
  {
    button.classList.remove('jian');
    button.classList.add('jianback');
    close.classList.remove('layer');
    close.classList.add('layerback');
    menu = 0;
  }
  }
  ani=0;
  button.addEventListener('animationend', function() {  
    ani=1;
  }, { once: true });
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
 