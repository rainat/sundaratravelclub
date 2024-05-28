import { createHashRouter } from "react-router-dom";
import Layout from "./pages/layout";
import ErrorBoundary from "./components/error";
import { Booking, Logout, Payment, Personal } from "./pages/personal";


export const routerCheckout = createHashRouter([
	{
		path: '/',
		element: <Layout />,
		errorElement: <ErrorBoundary />,
		children: [
			{
				path: '/',
				element: <Personal />,
				errorElement: <ErrorBoundary />
			},
			

		]
	
	},
	
])
