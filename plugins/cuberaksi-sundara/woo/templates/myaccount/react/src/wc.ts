import r2wc from "@r2wc/react-to-web-component"
import { OrderRowbookingElement } from "./components/wc/order-booking"

const WebGreeting = r2wc(OrderRowbookingElement, {
	props: {
		image: 'string',
		title: 'string',
		from: 'string',
		to: 'string',
		persons: 'string',
		price: 'string',
	},
	

})


customElements.define("cuberaksi-booking", WebGreeting)