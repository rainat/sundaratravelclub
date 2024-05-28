import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.tsx";
import "./globals.css";
import { Toaster } from "sonner";
import CheckoutApp from "./checkout-app.tsx";
import r2wc from "@r2wc/react-to-web-component"
import { OrderRowbookingElement } from "./components/wc/order-booking.tsx";
// console.log('--process----')
if (document.getElementById("myaccountpage")) {
  // console.log('--process-myaccountpage')
  ReactDOM.createRoot(document.getElementById("myaccountpage")!).render(
    <React.StrictMode>
      <Toaster richColors />
      <App />
    </React.StrictMode>,
  );

}

// if (document.getElementById("checkoutpage")) {
//   console.log('--process-checkoutpage')
//   ReactDOM.createRoot(document.getElementById("checkoutpage")!).render(
//     <React.StrictMode>
//       <Toaster richColors />
//       <CheckoutApp />
//     </React.StrictMode>,
//   );
// }



