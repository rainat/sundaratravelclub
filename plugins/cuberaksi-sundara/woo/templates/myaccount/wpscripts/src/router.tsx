import { createBrowserRouter } from "react-router-dom";
import Layout from "./pages/layout.tsx";
import ErrorBoundary from "./components/error.tsx";
import { Booking, Logout, Payment, Personal } from "./pages/personal.tsx";
import CheckoutPage from "./pages/checkout.tsx";

export const router = createBrowserRouter([
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
	{
		path: '/checkout',
		element: <CheckoutPage />,
		errorElement: <ErrorBoundary />
	}
])
