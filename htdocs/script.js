function toggleNavbar() {
  var navbar = document.querySelector('.navbar');
  navbar.classList.toggle('show');
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

 