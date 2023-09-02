let check12 = setInterval(function (){
    
    let j = document.querySelectorAll('.el-dropdown-menu__item') 
    if (j.length>=4) {
      // console.log(j)
      j[3].textContent = 'Refund'
      
      clearInterval(check12)
    } 
    
    
  }, 500)
  
