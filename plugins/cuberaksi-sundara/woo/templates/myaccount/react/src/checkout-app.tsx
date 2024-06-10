import { RouterProvider } from "react-router-dom"
import { QueryClient, QueryClientProvider } from "@tanstack/react-query"
import { routerCheckout } from "./router-checkout"


export const queryClient = new QueryClient()

function CheckoutApp() {
	return (
		<QueryClientProvider client={queryClient}>
      
			<RouterProvider router={routerCheckout} />
		</QueryClientProvider>
   
	)
}

export default CheckoutApp
