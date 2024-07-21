import { useState } from 'preact/hooks'
import { PrimeReactProvider} from "primereact/api"
import { QueryClientProvider, QueryClient} from "@tanstack/react-query"
import Admin from './admin'

const queryCLient = new QueryClient()

export function App() {


  return (
    <QueryClientProvider client={queryCLient}>
      <PrimeReactProvider>
            <Admin />
      </PrimeReactProvider>
    </QueryClientProvider>
  )
}
