import { createHashRouter,createBrowserRouter } from "react-router-dom";
import Layout from "./pages/layout";
import ErrorBoundary from "./components/error";
import { Booking, Logout, Payment, Personal } from "./pages/personal";


export const router = createHashRouter([
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
			{
				path: '/bookings',
				element: <Booking />,
				errorElement: <ErrorBoundary />
			},
			{
				path: '/payments',
				element: <Payment />,
				errorElement: <ErrorBoundary />
			},
			{
				path: '/logout',
				element: <Logout />,
				errorElement: <ErrorBoundary />
			}

		]
	
	},
	
])
