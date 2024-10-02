function toggleNavbar() {
  var navbar = document.querySelector('.navbar');
  navbar.classList.toggle('show');
}
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
