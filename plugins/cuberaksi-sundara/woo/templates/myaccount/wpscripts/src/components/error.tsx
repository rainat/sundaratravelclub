import { useRouteError } from "react-router-dom"

export default function ErrorBoundary() {
  let error = useRouteError();
  console.error(error);
  // Uncaught ReferenceError: path is not defined
  return <p>i'm sorry. i think there is a problem.  </p>;
}