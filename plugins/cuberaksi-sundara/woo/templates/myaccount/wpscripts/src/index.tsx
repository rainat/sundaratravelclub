import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.tsx";
import "./globals.css";
import { Toaster } from "sonner";
import CheckoutApp from "./checkout-app.tsx";

if (document.getElementById("myaccountpage")) {
  ReactDOM.createRoot(document.getElementById("myaccountpage")!).render(
    <React.StrictMode>
      <Toaster richColors />
      <App />
    </React.StrictMode>,
  );
}

if (document.getElementById("checkoutpage")) {
  ReactDOM.createRoot(document.getElementById("checkoutpage")!).render(
    <React.StrictMode>
      <Toaster richColors />
      <CheckoutApp />
    </React.StrictMode>,
  );
}

