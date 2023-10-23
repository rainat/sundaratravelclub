


(function ($) {
  $(document).ready(() => {
    let task = [{ name: 'refund-menu', active: false }, { name: 'event-tabs', active: false }]

    function setTask(name, active) {
   
      for (let i = 0; i < task.length; i++) {
        if (task[i].name === name) task[i].active = active
      }
    }




    let check12 = setInterval(function () {
    
      let j = document.querySelectorAll('.el-dropdown-menu__item') 
      console.log({j:j.length})
      if (j.length >= 4) {
        // console.log(j)
        for (let idx = 3; idx < j.length; idx++) {
          if (idx % 2 >= 1)
            j[idx].textContent = 'Refund'  
        }
      
      
        setTask('refund-menu', true)
      } 

      // let k = document.querySelectorAll('.am-cabinet-menu-item')
      // console.log(k.length)
      // if (k.length >= 1) {
      //   k[1].style.display = 'none'
      //   setTask('event-tabs', true)
      // } 

      setTask('event-tabs', true)
      if ((task[0].active) && (task[1].active)) clearInterval(check12)

    }, 500)

    function updatePanelShow(id)
    {
      if (id==='userinfo'){
          if (!$('#userinfo-panel').hasClass('shown')){
              $('#userinfo-panel').toggleClass('shown')
              $('#usericon-panel').toggleClass('shown')
          }
          if ($('#mytrip-panel').hasClass('shown')) {
              $('#mytrip-panel').toggleClass('shown')
          }
      }

      if (id==='mytrip'){
          if (!$('#mytrip-panel').hasClass('shown')){
            $('#mytrip-panel').toggleClass('shown')  
          }
          
          if ($('#userinfo-panel').hasClass('shown')) {
              $('#userinfo-panel').toggleClass('shown')
              $('#usericon-panel').toggleClass('shown')
          }
      }
    }

    updatePanelShow('userinfo')

    $('#mytrip-btn').on('click', (e) => {
      e.preventDefault()
     
      updatePanelShow('mytrip')
      
    })

     $('#userinfo-btn').on('click', (e) => {
      e.preventDefault()
      updatePanelShow('userinfo')
      
      
    })     

  })      
       
     
})(jQuery)
    

  
