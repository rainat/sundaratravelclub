jQuery(document).ready(($)=>{
	let amelbr = $('table .woocommerce-table.woocommerce-table--order-details.shop_table order_details');
	//> td.woocommerce-table__product-name.product-name
	if (amelbr.length===0) {
		console.log('not founded', amelbr)
	} 

	if (amelbr.length>0) {
		console.log('founded', amelbr)
	} 
	
})