 


 setTimeout(() => {
   const $loader = $('.loader')
   if ($loader) {
     $loader.css('height', 0)
     setTimeout(() => {
       $loader.children().hide()
     }, 500)
   }
 })