let task = [{name:'refund-menu',active:false},{name:'event-tabs',active:false}]

function setTask(name,active)
{
   
   for (let i = 0; i < task.length; i++) {
     if (task[i].name === name) task[i].active = active
   }
}

let check12 = setInterval(function (){
    
    let j = document.querySelectorAll('.el-dropdown-menu__item') 
    if (j.length>=4) {
      // console.log(j)
      for (let idx=3;idx<j.length;idx++) {
        if (idx%2>=1)
            j[idx].textContent = 'Refund'  
      }
      
      
     setTask('refund-menu',true)
    } 

    let k = document.querySelectorAll('.am-cabinet-menu-item')
    if (k.length>=1) {
      k[1].style.display = 'none'
      setTask('event-tabs',true)
    } 
    
    if ((task[0].active) && (task[1].active)) clearInterval(check12)

  }, 500)
  
